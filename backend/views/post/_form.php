<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\components\LayoutWidget\LayoutWidget;
use backend\components\MultipleSwitch\MultipleSwitchWidget;
use backend\models\Post;
use backend\models\PostCategory;
use backend\models\PostTag;
use backend\models\PostType;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<script>
    $(document).ready(
        function ()
        {
            initializeMultimediaBtn();
        }
    )
</script>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <ul class="nav nav-tabs" id="myTab">
        <li role="presentation" class="tab-label active">
            <a href="#tab_basic_settings" data-toggle="tab">Základné nastavenia</a>
        </li>
        <li role="presentation" class="tab-label">
            <a href="#tab_tags_settings" data-toggle="tab">Tagy článku</a>
        </li>
        <li role="presentation" class="tab-label">
            <a href="#tab_seo_settings" data-toggle="tab">SEO nastavenia</a>
        </li>
        <li role="presentation" class="tab-label">
            <a href="#tab_layout_settings" data-toggle="tab">Layout</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade in active" id="tab_basic_settings">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

            <?= IdentifierGenerator::widget([
                'idTextFrom' => 'post-name',
                'idTextTo' => 'post-identifier',
                'delimiter' => '-',
            ]) ?>

            <?= $form->field($model, 'published_at')->widget(DatePicker::className(), [
                'dateFormat' => 'yyyy/MM/dd',
                'class' => 'form-control'
            ]) ?>

            <?= $form->field($model, 'post_category_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(PostCategory::find()->all(), 'id', 'name'),
                'language' => 'en',
                'options' => ['placeholder' => 'Výber kategórie ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'post_type_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(PostType::find()->all(), 'id', 'name'),
                'language' => 'en',
                'options' => ['placeholder' => 'Výber typu ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <div class="form-group">
                <?php $id = rand(1000, 100000); ?>

                <textarea class="form-control editor" id="ckeditor<?= $id ?>" rows="3" name="Post[perex]"
                ><?= $model->perex ?></textarea>

                <script type="text/javascript">
                    $(document).ready(
                        function ()
                        {
                            CKEDITOR.replace("ckeditor<?= $id ?>", ckeditorConfig);
                            CKEDITOR.dtd.$removeEmpty['i'] = false;
                        }
                    );
                </script>

            </div>
            <div class="form-group">
                <label>Náhľadový obrázok</label>
            <div class="input-group">
                <input type="text" class="form-control value" name="Post[image]"
                       value="<?= $model->image ?>"/>
                        <span class="input-group-btn">
                        <?= Html::a('<span class="fa fa-fw fa-picture-o"></span>', "#",
                            ['class' => 'pull-right open-multimedia btn btn-success']) ?>
                        </span>
            </div>

                </div>
            <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
                'type' => SwitchInput::CHECKBOX
            ]) ?>
        </div>

        <div class="tab-pane" id="tab_tags_settings">
            <div class="form-group">
                <label class="control-label" for="snippetcode-portal">
                    Tagy pre článok
                </label>
                <?= Select2::widget([
                    'name' => Post::className() . '[_tags]',
                    'value' => array_map(function ($item) {
                        return $item->id;
                    }, $model->tags),
                    'data' => ArrayHelper::map(PostTag::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => 'Priradiť tagy',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                    ],
                ]) ?>
            </div>
        </div>

        <div class="tab-pane" id="tab_seo_settings">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea() ?>

            <?= $form->field($model, 'keywords')->textarea() ?>
        </div>
        <div class="tab-pane" id="tab_layout_settings">
            <h3 class="page-header">Hlavička stránky</h3>

            <?= Html::checkbox('header[active]', $model->header->active, [
                'data-check' => 'switch',
                'data-on-color' => 'primary',
                'data-on-text' => 'Aktívny',
                'data-off-color' => 'default',
                'data-off-text' => 'Neaktívny',
                'value' => 1,
                'uncheck' => 0
            ]) ?>

            <?= LayoutWidget::widget([
                    'area' => $model->header,
                    'controllerUrl' => Url::to(['/page']),
                    'layoutOwner' => $model,
                    'portal' => null
                ]
            ) ?>

            <h3 class="page-header">Hlavný obsah</h3>

            <?= LayoutWidget::widget([
                    'area' => $model->content,
                    'controllerUrl' => Url::to(['/page']),
                    'allowAddingSection' => false,
                    'layoutOwner' => $model,
                    'portal' => null
                ]
            ) ?>

            <h3 class="page-header">Sidebar</h3>

            <?= Html::checkbox('sidebar[active]', $model->sidebar->active, [
                'data-check' => 'switch',
                'data-on-color' => 'primary',
                'data-on-text' => 'Aktívny',
                'data-off-color' => 'default',
                'data-off-text' => 'Neaktívny',
                'value' => 1,
                'uncheck' => 0
            ]) ?>

            <?= Html::checkbox('sidebar_side', $model->sidebar_side, [
                'data-check' => 'switch',
                'data-on-color' => 'default',
                'data-on-text' => 'Vpravo',
                'data-off-color' => 'default',
                'data-off-text' => 'Vľavo',
                'value' => 'right',
                'uncheck' => 'left'
            ]) ?>

            <?= MultipleSwitchWidget::widget([
                'name' => 'sidebar[size]',
                'items' => [
                    '4' => '8:4',
                    '5' => '7:5',
                    '6' => '6:6',
                    '7' => '5:7',
                    '8' => '4:8',
                ],
                'value' => $model->sidebar->size
            ]) ?>

            <?= LayoutWidget::widget([
                    'area' => $model->sidebar,
                    'controllerUrl' => Url::to(['/page']),
                    'allowAddingSection' => false,
                    'layoutOwner' => $model,
                    'portal' => null
                ]
            ) ?>

            <h3 class="page-footer">Patička stránky</h3>

            <?= Html::checkbox('footer[active]', $model->footer->active, [
                'data-check' => 'switch',
                'data-on-color' => 'primary',
                'data-on-text' => 'Aktívny',
                'data-off-color' => 'default',
                'data-off-text' => 'Neaktívny',
                'value' => 1,
                'uncheck' => 0
            ]) ?>

            <?= LayoutWidget::widget([
                    'area' => $model->footer,
                    'controllerUrl' => Url::to(['/page']),
                    'layoutOwner' => $model,
                    'portal' => null
                ]
            ) ?>
        </div>
    </div>

    <div class="navbar-fixed-bottom">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="form-group">
                <?= Html::submitButton('Uložiť', [
                    'class' => 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>

                <?= Html::submitButton('Uložiť a pokračovať', [
                    'class' => 'btn btn-info',
                    'id' => 'submit-btn',
                    'name' => 'continue'
                ]) ?>
                <?= Html::a('Náhľad', Url::to(['show', 'id' => $model->id]), [
                    'class' => 'btn btn-info',
                    'target' => '_blank'
                ]) ?>
                <?= Html::a('Hard reset a náhľad', Url::to(['hard-reset', 'id' => $model->id]), [
                    'class' => 'btn btn-danger',
                    'target' => '_blank'
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
