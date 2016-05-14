<?php

use backend\components\LayoutWidget\LayoutWidget;
use yii\helpers\BaseHtml;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $sections backend\models\Section */
?>

<?= LayoutWidget::widget([
        'sections' => $sections
    ]
)?>

<div class="navbar-fixed-bottom">
    <div class="col-sm-10 col-sm-offset-2">
        <div class="form-group">
            <?= BaseHtml::buttonInput('Uložiť', [
                'id' => 'save-btn',
                'class' => 'btn btn-success btn-primary'
            ])?>
        </div>
    </div>
</div>



<?php
$url = Url::to(['portal/header-create']);

$js = <<<JS

var pageParams = {};

pageParams.url = '$url';
        
JS;

$this->registerJs($js);
$this->registerJsFile('@web/js/portal-elements.js');
?>

