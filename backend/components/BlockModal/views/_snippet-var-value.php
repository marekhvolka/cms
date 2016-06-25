<?php
use backend\models\Page;
use backend\models\Product;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use kartik\color\ColorInput;
use yii\helpers\BaseHtml;
use yii\helpers\Html;
use backend\models\SnippetVarValue;

/* @var $model backend\models\SnippetVarValue */
/* @var $productType backend\models\ProductType */
/* @var $prefix string */

?>

<?php
$defaultValue = $model->getDefaultValue($productType);

switch ($model->typeName)
{
    case 'list' : ?>
        <div class="panel panel-default" >
            <div class="panel-heading">
                <span>
                    <a data-toggle="collapse" href="#panel<?= $model->id ?>">
                        <i class="fa fa-angle-down">
                            <?= $model->var->identifier ?>
                        </i>
                    </a>
                </span>
                <span>
                    Počet položiek: <?= sizeof($model->valueListVar->listItems) ?>
                </span>
                <button class="btn btn-success btn-xs pull-right">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>

            <div class="panel-body panel-collapse collapse in" id="panel<?= $model->id ?>">
                <ul class="list-unstyled">
                    <?php foreach($model->valueListVar->listItems as $indexItem => $listItem) : ?>
                        <li>
                            <?= BaseHtml::hiddenInput($prefix . "[existing]", !$listItem->isNewRecord, ['class' => 'existing']); ?>
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <a data-toggle="collapse" href="#panelItem<?= $listItem->id ?>">
                                        <span>
                                            <i class="fa fa-angle-down"></i>
                                        </span>
                                    </a>
                                    <span>
                                        <i class="fa fa-bars"></i>
                                    </span>
                                    <span>
                                        <?= $listItem->id ?>
                                    </span>
                                    položka
                                    <button class="btn btn-danger btn-xs pull-right">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                </div>
                                <div class="panel-body panel-collapse collapse in" id="panelItem<?= $listItem->id ?>">
                                    <?php foreach($listItem->snippetVarValues as $indexVar => $snippetVarValue)
                                    {
                                        echo $this->render('_snippet-var-value', [
                                            'model' => $snippetVarValue,
                                            'productType' => $productType,
                                            'prefix' => $prefix . "[ListItem][$indexItem][SnippetVarValue][$indexVar]"
                                        ]);
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php
        break;
    case 'textinput' : ?>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="<?= $model->id ?>" name="<?= $prefix . '[value_text]' ?>"
                       placeholder="<?= htmlentities($model->getDefaultValue($productType)) ?>"
                       value="<?= htmlspecialchars($model->value_text, ENT_QUOTES) ?>" />

                <?php if(!empty($defaultValue)) : ?>
                    <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je <strong><?= htmlentities($model->getDefaultValue($productType)) ?></strong></p>
                <?php endif; ?>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php
        break;
    case 'url' : ?>
        <?php
        

        ?>
    <?php
        break;
    case 'textarea' : ?>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>
            <div class="col-sm-10">
                <textarea class="form-control" id="<?= $model->id ?>" name="<?= $prefix . '[value_text]' ?>" rows="3" placeholder="<?= htmlentities($model->getDefaultValue($productType)) ?>"><?= htmlspecialchars($model->value_text, ENT_QUOTES) ?></textarea>

                <?php if(!empty($defaultValue)) : ?>
                <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je <strong><?= htmlentities($model->getDefaultValue($productType)) ?></strong></p>
                <?php endif; ?>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php
        break;
    case 'color' : ?>
        <div class="form-group" >
            <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="color" class="form-control" id="<?= $model->id ?>" name="" value="<?= $model->value_text ?>" placeholder="<?= $model->getDefaultValue($productType) ?>">
                    <span class="input-group-addon"><i></i></span>
                </div>

                <?php if(!empty($defaultValue)) : ?>
                    <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je <strong><?= htmlentities($model->getDefaultValue($productType)) ?></strong></p>
                <?php endif; ?>
            </div>
            <div class="clearfix"></div>
        </div>

    <?php
        break;
    case 'editor' : ?>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>
            <div class="col-sm-10">
                <textarea class="form-control" id="<?= $model->id ?>" name="" rows="3" placeholder="<?= htmlentities($model->getDefaultValue($productType)) ?>"><?= htmlspecialchars($model->value_text, ENT_QUOTES) ?></textarea>

                <?php if(!empty($defaultValue)) : ?>
                    <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je <strong><?= htmlentities($model->getDefaultValue($productType)) ?></strong></p>
                <?php endif; ?>
            </div>
        </div>
    <?php
        break;
    case 'product' : ?>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>

            <div class="col-sm-10">
                <?= Html::activeDropDownList($model, 'value_product_id',
                    ArrayHelper::map(Product::find()->all(), 'id', 'name'),
                    [
                        'name' => $prefix . '[value_product_id]',
                        'class' => 'form-control'
                    ]) ?>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php
        break;
    case 'page' : ?>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>

            <div class="col-sm-10">
                <?= Html::activeDropDownList($model, 'value_page_id',
                    ArrayHelper::map(Page::find()->all(), 'id', 'breadcrumbs'),
                    [
                        'name' => $prefix . '[value_page_id]',
                        'class' => 'form-control'
                    ]) ?>
            </div>
            <div class="clearfix"></div>
        </div>

    <?php
        break;
}
