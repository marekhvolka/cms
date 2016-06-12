<?php
use backend\components\PathHelper;
use backend\models\MultimediaCategory;
use yii\bootstrap\Html;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $category MultimediaCategory */
/* @var $subcategory string */
/* @var $dataProvider ArrayDataProvider */

?>
    <h2><?= $category->name ?>
        <small><?= $subcategory ?></small>
    </h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'label' => 'Meno',
            'format' => 'raw',
            'value' => function ($multimediaItem) {
                return Html::a(
                    $multimediaItem->name,
                    Url::to([
                        '/multimedia/file/',
                        'subcategory' => $multimediaItem->subcategory,
                        'categoryName' => $multimediaItem->categoryName,
                        'name' => $multimediaItem->name], 'http'
                    ), ['class' => PathHelper::isImageFile($multimediaItem->name) ? 'image-multimedia' : '']
                );
            },
        ],

        [
            'label' => 'Náhľad',
            'format' => 'raw',
            'value' => function ($multimediaItem) {
                if(PathHelper::isImageFile($multimediaItem->name)){
                    $url = Url::to([
                        '/multimedia/file/',
                        'subcategory' => $multimediaItem->subcategory,
                        'categoryName' => $multimediaItem->categoryName,
                        'name' => $multimediaItem->name], 'http'
                    );
                    return Html::a(Html::img($url, ['class' => 'thumbnail']), $url, ['class' => 'image-multimedia']);
                }

                return "-";
            },
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'urlCreator' => function ($action, $model, $key, $index) use ($category ){
                $url = Url::current(['file-action' => $action, 'item-category' => $category->name, 'item-name' => $model->name, 'item-subcategory' => $model->subcategory]);

                return $url;
            }
        ],
    ],
]);
?>