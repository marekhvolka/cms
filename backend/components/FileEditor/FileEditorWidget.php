<?php
namespace backend\components\FileEditor;

use backend\components\PathHelper;
use backend\components\FileEditor\models\CreateDirectoryForm;
use backend\components\FileEditor\models\EditFileForm;
use backend\components\FileEditor\models\UploadFileForm;
use DirectoryIterator;
use InvalidArgumentException;
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
 *      'directory' => __DIR__ . '/../testing-data'
 * ]);
 * </code>
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
 * if ($state == false) {
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
    // not implemented yet
    public $compileScss = false;
    public $compileTo = null;

    /**
     * Perform internal actions. In case that it returns something apart from false, return the response to the Yii 2
     * to display the result (used when it is needed to return the content of a file, which happens when using AJAX a
     * file content is loaded into the editor).
     *
     * @return $this|bool|string
     */
    public function performActions() {
        if (empty($this->directory) || !is_dir($this->directory)) {
            throw new InvalidArgumentException('Given directory does not exist.');
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
        $edit_file_form = new EditFileForm($this->directory);
        $upload_file_form = new UploadFileForm($this->directory);
        $create_directory_form = new CreateDirectoryForm($this->directory);

        // editing file
        if ($edit_file_form->load(Yii::$app->request->post()) && $edit_file_form->validate()) {
            $edit_file_form->save(false);
        }

        // uploading a new file
        if ($upload_file_form->load(Yii::$app->request->post())) {
            $upload_file_form->file = UploadedFile::getInstance($upload_file_form, 'file');
            if ($upload_file_form->validate()) {
                $path = $upload_file_form->upload(false);
                $edit_file_form->fileName = $upload_file_form->directory . '/' . $upload_file_form->file->getBaseName() . '.' . $upload_file_form->file->getExtension();

                if (PathHelper::isImageFile($edit_file_form->fileName)) {
                    $is_image_loaded = true;
                } else {
                    $edit_file_form->text = file_get_contents($path);
                }
            }
        }

        // creating a new directory
        if ($create_directory_form->load(Yii::$app->request->post()) && $create_directory_form->validate()) {
            $create_directory_form->create(false);
            $create_directory_form = new CreateDirectoryForm($this->directory);
        }

        // building tree
        $fileTree = $this->buildTreeForDirectory($this->directory);

        echo Yii::$app->getView()->render('file-editor', [
            'directory'      => $this->directory,
            'fileTree'       => $fileTree['with-files'],
            'directoryTree'  => array_merge(["/" => "/"], $fileTree['only-directories']), // add even the root to the list
            'editFileForm'   => $edit_file_form,
            'uploadFileForm' => $upload_file_form,
            'createDirectoryForm' => $create_directory_form,
            'isImageLoaded'  => $is_image_loaded
        ], $this);
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