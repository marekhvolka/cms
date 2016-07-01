<?php

namespace backend\components;

use LogicException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class to simplify work with paths and files.
 *
 * @package common\components
 */
class PathHelper
{
    /**
     * Ensure that each directory of the path exists.
     *
     * @param $path string the path
     * @param bool $moveDeeper even the most outer directory?
     * @return bool
     */
    public static function makePath($path, $moveDeeper = false)
    {
        $dir = $moveDeeper ? pathinfo($path, PATHINFO_DIRNAME) : $path;

        if (is_dir($dir)) {
            return true;
        } else {
            if (self::makePath($dir, true)) {
                if (mkdir($dir)) {
                    chmod($dir, 0777);

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Behaves like realpath(), but does not resolve symlinks and works even for not existing files.
     *
     * @param $path string the path
     * @param string $separator directory separator
     * @return string the normalized path
     */
    public static function normalizePath($path, $separator = '\\/')
    {
        // Remove any kind of funky unicode whitespace
        $normalized = preg_replace('#\p{C}+|^\./#u', '', $path);

        // Path remove self referring paths ("/./").
        $normalized = preg_replace('#/\.(?=/)|^\./|\./$#', '', $normalized);

        // Regex for resolving relative paths
        $regex = '#\/*[^/\.]+/\.\.#Uu';

        while (preg_match($regex, $normalized)) {
            $normalized = preg_replace($regex, '', $normalized);
        }

        if (preg_match('#/\.{2}|\.{2}/#', $normalized)) {
            throw new LogicException('Path is outside of the defined root, path: [' . $path . '], resolved: [' . $normalized . ']');
        }

        return trim($normalized, $separator);
    }

    /**
     * Remove the given directory or file. If directory is provided, recursively remove all files contained in in.
     * @param $path string the path
     * @return bool true if successful, false otherwise
     */
    public static function remove($path)
    {
        if (is_dir($path)) {
            // recursively delete all files in the folder
            $it = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it,
                RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            return @rmdir($path);
        } else {
            return @unlink($path);
        }
    }

    /**
     * Is the $subject path inside the $in_path path? Paths have to be normalized to make the function work properly.
     *
     * @param $subject string the path to be checked
     * @param $in_path string the path to be the another path in
     * @return bool is or not
     */
    public static function isInside($subject, $in_path)
    {
        return (strrpos($subject, $in_path, -strlen($subject)) !== false);
    }

    /**
     * Does the given path contain an image file?
     *
     * @param $fileName string the path
     * @return bool
     */
    public static function isImageFile($fileName)
    {
        return in_array(mb_strtolower(pathinfo($fileName, PATHINFO_EXTENSION)), ["jpg", "jpeg", "gif", "png", "svg"]);
    }

    /**
     * Does the given path contain an scss file?
     *
     * @param $fileName string the path
     * @return bool yes or not?
     */
    public static function isSCSSFile($fileName){
        return mb_strtolower(pathinfo($fileName, PATHINFO_EXTENSION)) == "scss";
    }
}