<?php
$path = './' . $_SERVER['REQUEST_URI'];
$pos = strpos($path, "?");

if($pos !== false){
    $path = substr($path, 0, $pos) . '.php' . substr($path, $pos);
} else {
    $path .= '.php';
}

if (is_file($path)) {
    include $path;
} else {
    include 'index.php';
}
