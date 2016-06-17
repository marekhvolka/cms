<?php
use backend\models\Page;
use backend\models\Product;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\color\ColorInput;
use yii\helpers\Html;
use backend\models\SnippetVarValue;

/* @var $model backend\models\SnippetVarValue */
/* @var $productType backend\models\ProductType */

?>

<?php
$postIndex = rand(0, 10000000); // Index for correctly indexing Post request variable.
?>

<?php 
//$model = new SnippetVarValue; 
//$model->var_id = 17491; 
?>

<?php foreach($model->attributes as $attributeName => $attributeValue):?>
    <?php 
    if ($attributeName == 'id') {
        $attributeValue = $attributeValue ? : $postIndex;
    }
    ?>
    <?php if(strpos($attributeName, 'id') !== false):?>
    <?= Html::hiddenInput("SnippetVarValue[$postIndex][$attributeName]", $attributeValue, ['data-property-name' => $attributeName]); ?>
    <?php endif;?>
<?php endforeach;?>

<?php
$defaultValue = $model->getDefaultValue($productType);

switch ($model->typeName)
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
                                    echo $this->render('_snippet-var-value', [
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
        <?php
        $rawInput = Html::textInput("SnippetVarValue[$postIndex][value_text]", htmlspecialchars($model->value_text, ENT_QUOTES),[
            'class' => 'form-control',
            'data-property-name' => 'value_text',
            'placeholder' => $defaultValue,
        ])?>
        <?php
        $myVar = "foo";
        $myFunction = function($arg1, $arg2) use ($myVar) {
            $test = 'dasda';
            return $arg1 . $myVar . $arg2;
        };
        
        $testtt = $myFunction('aaaa-','bbbb-');
        
        $input = function() use($model, $defaultValue, $rawInput) 
        {
            $test = 0;
//            $input = $this->render('_snippet-var-value-input', [
//                            'model' => $model,
//                            'defaultValue' => $defaultValue,
//                            'input' =>  $rawInput,
//            ]);
            return $test;
        }
        ?>
    <?php
        break;
    case 'url' : ?>
        <?php
        
        //$test = $input();
        ?>
    <?php
        break;
    case 'textarea' : ?>
        <div class="form-group code" style="position: relative;">
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
    case 'color' : ?>
        <div class="form-group code" style="position: relative;">
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
        </div>

    <?php
        break;
    case 'editor' : ?>
        <div class="form-group code" style="position: relative;">
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
    case 'product' :

        break;
    case 'page' :


        break;
}
