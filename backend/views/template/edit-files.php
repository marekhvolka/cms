<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Editovať súbory šablóny';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $file_editor = \common\widgets\FileEditor\FileEditorWidget::begin([
    'directory' => __DIR__ . '/../../testing-data'
]) ?>

<div class="edit-files">
    <?php $file_editor->end() ?>
</div>
