<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 06.06.16
 * Time: 11:11
 */
use backend\models\Page;
use backend\models\Product;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\color\ColorInput;

/* @var $varValue backend\models\SnippetVarValue */

?>

<?php
switch ($model->var->type->identifier)
{
    case 'list' : ?>
        <div class="panel panel-default" style="position: relative; display: block">
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
                    <?php foreach($model->valueListVar->listItems as $listItem) : ?>
                    <li>
                        <div class="panel panel-default" style="position: relative">
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
                                <?php foreach($listItem->values as $snippetVarValue)
                                {
                                    echo $this->render('_snippet_var', [
                                        'model' => $snippetVarValue,
                                        'productType' => $productType
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
        <div class="form-group code" style="position: relative;">
            <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="<?= $model->id ?>" value="<?= htmlspecialchars($model->value_text, ENT_QUOTES) ?>" placeholder="<?= $model->getDefaultValue($productType) ?>">
                <?php if(!empty($model->getDefaultValue($productType))) : ?>
                    <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je <strong><?= $model->getDefaultValue($productType) ?></strong></p>
                <?php endif; ?>
            </div>
        </div>
    <?php
        break;
    case 'url' : ?>
        <div class="form-group code" style="position: relative;">
            <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="<?= $model->id ?>" name="" value="<?= $model->value_text ?>" placeholder="<?= $model->getDefaultValue($productType) ?>">

                <?php if(!empty($model->getDefaultValue($productType))) : ?>
                <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je <strong><?= $model->getDefaultValue($productType) ?></strong></p>
                <?php endif; ?>
            </div>
        </div>
    <?php
        break;
    case 'textarea' : ?>
        <div class="form-group code" style="position: relative;">
            <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>
            <div class="col-sm-10">
                <textarea class="form-control" id="<?= $model->id ?>" name="" rows="3" placeholder="<?= htmlentities($model->getDefaultValue($productType)) ?>"><?= htmlspecialchars($model->value_text, ENT_QUOTES) ?></textarea>

                <?php if(!empty($model->getDefaultValue($productType))) : ?>
                    <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je <strong><?= htmlentities($model->getDefaultValue($productType)) ?></strong></p>
                <?php endif; ?>
            </div>
        </div>
    <?php
        break;
    case 'color' : ?>
        <div class="form-group code" style="position: relative;">
            <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="color" class="form-control" id="<?= $model->id ?>" name="" value="<?= $model->value_text ?>" placeholder="<?= $model->getDefaultValue($productType) ?>">
                    <span class="input-group-addon"><i></i></span>
                </div>

                <?php if(!empty($model->getDefaultValue($productType))) : ?>
                    <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je <strong><?= htmlentities($model->getDefaultValue($productType)) ?></strong></p>
                <?php endif; ?>
            </div>
        </div>

    <?php
        break;
    case 'editor' : ?>
        <div class="form-group code" style="position: relative;">
            <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>
            <div class="col-sm-10">
                <textarea class="form-control" id="<?= $model->id ?>" name="" rows="3" placeholder="<?= htmlentities($model->getDefaultValue($productType)) ?>"><?= htmlspecialchars($model->value_text, ENT_QUOTES) ?></textarea>

                <?php if(!empty($model->getDefaultValue($productType))) : ?>
                    <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je <strong><?= htmlentities($model->getDefaultValue($productType)) ?></strong></p>
                <?php endif; ?>

            </div>
        </div>
    <?php
        break;
    case 'product' :

        break;
    case 'page' :


        break;
}
