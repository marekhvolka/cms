<?php
namespace backend\components\FileEditor;

use backend\components\FileEditor\models\NewFileForm;
use backend\components\PathHelper;
use backend\components\FileEditor\models\CreateDirectoryForm;
use backend\components\FileEditor\models\EditFileForm;
use backend\components\FileEditor\models\UploadFileForm;
use DirectoryIterator;
use InvalidArgumentException;
use Leafo\ScssPhp\Compiler;
use Leafo\ScssPhp\Formatter\Compressed;
use ReflectionClass;
use yii;
use yii\base\Component;
use yii\base\ViewContextInterface;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * The file editor. Setup:
 *
 * 1) create the object using Yii
 *
 * <code>
 * $file_editor = Yii::createObject([
 *      'class'     => FileEditorWidget::className(),
 *      'directory' => __DIR__ . '/../testing-data',
 *      'compileScss' => true
 * ]);
 * </code>
 *
 * Note that if you want to compile scss files, set the 'compileScss' to true and the css files will get compiled
 * after saving / uploading and this compiled and minified version will be saved next to the original file.
 *
 * If you want to do some another compilation (will be performed only if SCSS compilation is disabled), specify
 * the callback for `extraCompileBy`. The callback will be called with one argument - path to the file to be compiled.
 *
 * 2) the editor has some its actions that need to be performed, like to return the content of the file when
 * requested by AJAX ... that is done by method performActions(); ... you need to store the return value
 *
 * <code>
 * $state = $file_editor->performActions();
 * </code>
 *
 * 3) the return value is either false meaning that you can proceed to displaying the content of the site, or string
 * (or Response)... in such a case, return the returned object to be displayed
 *
 * <code>
 * if ($state === false) {
 *      return $this->render('editor', [
 *          'fileEditor' => $file_editor
 *      ]);
 * } else {
 *      return $state;
 * }
 * </code>
 *
 * 4) pass the FileEditorWidget instance to the template and display it using method display
 *
 * <code>
 * <?php $fileEditor->display() ?>
 * </code>
 *
 * @package common\widgets\FileEditor
 */
class FileEditorWidget extends Component implements ViewContextInterface
{
    /**
     * @var string the directory to be edited by the file editor
     */
    public $directory;
    public $compileScss = true;
    public $generatedUrlPrefix = '';
    public $removeExtensionFromGeneratedUrl = false;
    public $extraCompileBy = null;

    /**
     * Perform internal actions. In case that it returns something apart from false, return the response to the Yii 2
     * to display the result (used when it is needed to return the content of a file, which happens when using AJAX a
     * file content is loaded into the editor).
     *
     * @return $this|bool|string
     */
    public function performActions()
    {
        if (empty($this->directory) || !is_dir($this->directory)) {
            PathHelper::makePath($this->directory);
        }

        if (!empty(Yii::$app->request->get('file'))) {
            if (!empty(Yii::$app->request->get('fileAction'))) {
                if (Yii::$app->request->get('fileAction') == 'delete') {
                    $realpath = realpath($this->directory . Yii::$app->request->get('file'));
                    if (PathHelper::isInside($realpath, realpath($this->directory))) {
                        PathHelper::remove($realpath);
                    }

                    return Yii::$app->response->redirect(Url::current(['fileAction' => null, 'file' => null]));
                }
            } else {
                $file = Yii::$app->request->get('file');

                return file_get_contents($this->directory . '/' . $file);
            }
        }

        return false;
    }

    /**
     * Display the editor itself - the tree and the textarea / image.
     */
    public function display()
    {
        $is_image_loaded = false;
        $new_file_form = new NewFileForm($this->directory);
        $edit_file_form = new EditFileForm($this->directory);
        $upload_file_form = new UploadFileForm($this->directory);
        $create_directory_form = new CreateDirectoryForm($this->directory);

        $original_path = null;
        $original_relative_path = null;

        // creating file
        if ($new_file_form->load(Yii::$app->request->post()) && $new_file_form->validate()) {
            $new_file_form->save(false);

            $original_path = $new_file_form->getFullPath();
            $original_relative_path = $new_file_form->getRelativePath();

            $edit_file_form->text = $new_file_form->text;
            $edit_file_form->name = $new_file_form->name;
            $edit_file_form->directory = $new_file_form->directory;
            $new_file_form = new NewFileForm($this->directory);
        } else if ($edit_file_form->load(Yii::$app->request->post()) && $edit_file_form->validate()) { // editing file
            $edit_file_form->save(false);

            $original_path = $edit_file_form->getFullPath();
            $original_relative_path = $edit_file_form->getRelativePath();
        }

        // uploading a new file
        if ($upload_file_form->load(Yii::$app->request->post())) {
            $upload_file_form->file = UploadedFile::getInstance($upload_file_form, 'file');
            if ($upload_file_form->validate()) {
                $original_path = $upload_file_form->upload(false);
                $edit_file_form->directory = $upload_file_form->directory;
                $edit_file_form->name = $upload_file_form->file->getBaseName() . '.' . $upload_file_form->file->getExtension();
                $edit_file_form->text = file_get_contents($original_path);
            }
        }

        // creating a new directory
        if ($create_directory_form->load(Yii::$app->request->post()) && $create_directory_form->validate()) {
            $create_directory_form->create(false);
            $create_directory_form = new CreateDirectoryForm($this->directory);
        }

        // Processing the edited file
        if (!empty($original_path)) {
            if (PathHelper::isImageFile($original_path)) {
                $is_image_loaded = true;
            } else {
                if (PathHelper::isSCSSFile($original_path)) {
                    $compiled_path = mb_substr($original_path, 0, count($original_path) - 5) . "min.css";
                    $this->compileScss($original_path, $compiled_path);
                } else if(is_callable($this->extraCompileBy)) {
                    call_user_func_array($this->extraCompileBy, [$original_path, $original_relative_path]);
                }
            }
        }

        // building tree
        $fileTree = $this->buildTreeForDirectory($this->directory);

        echo Yii::$app->getView()->render('file-editor', [
            'directory' => $this->directory,
            'fileTree' => $fileTree['with-files'],
            'directoryTree' => array_merge(["/" => "/"], $fileTree['only-directories']), // add even the root to the list
            'editFileForm' => $edit_file_form,
            'uploadFileForm' => $upload_file_form,
            'newFileForm' => $new_file_form,
            'createDirectoryForm' => $create_directory_form,
            'isImageLoaded' => $is_image_loaded,
            'generatedUrlPrefix' => $this->generatedUrlPrefix,
            'removeExtensionFromGeneratedUrl' => $this->removeExtensionFromGeneratedUrl
        ], $this);
    }

    /**
     * Compile css file determined by its path
     *
     * @param $from string path of the file to be compiled
     * @param $to string save the compiled script to (extension will be replaced by 'css')
     */
    private function compileScss($from, $to)
    {
        if ($this->compileScss) {
            $scss_compiler = new Compiler();
            PathHelper::makePath($to, true);
            $scss_compiler->setFormatter(new Compressed());
            $scss_compiler->setImportPaths(pathinfo($from, PATHINFO_DIRNAME));

            file_put_contents($to, $scss_compiler->compile(file_get_contents($from)));
        }
    }

    /**
     * Build a tree for the directory.
     *
     * @param $directory
     * @return array an array containing two items - under 'with-files', the whole tree is stored... under
     * 'only-directories' only directories as string with their full paths are stored
     */
    private function buildTreeForDirectory($directory)
    {
        $directoriesList = [];
        $tree = [];
        foreach (new DirectoryIterator($directory) as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }
            if ($fileInfo->isDir()) {
                $built_tree = $this->buildTreeForDirectory($fileInfo->getRealPath());

                $full_path = str_replace(realpath($this->directory), "", $fileInfo->getRealPath());
                $directoriesList[$full_path] = $full_path;

                $directoriesList = array_merge($directoriesList, $built_tree['only-directories']);
                $tree[$fileInfo->getFilename()] = $built_tree["with-files"];
                continue;
            };

            $tree[] = $fileInfo->getFilename();
        }

        return ['with-files' => $tree, 'only-directories' => $directoriesList];
    }

    /**
     * Returns the directory containing the view files for this widget.
     * The default implementation returns the 'views' subdirectory under the directory containing the widget class file.
     * @return string the directory containing the view files for this widget.
     */
    public function getViewPath()
    {
        $class = new ReflectionClass($this);

        return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views';
    }
}