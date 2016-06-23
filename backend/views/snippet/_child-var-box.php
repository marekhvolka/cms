<?php 
/* @var $this yii\web\View */
/* @var $model backend\models\SnippetVar */
/* @var $prefix string */
?>

<div class="row child-var-box">
    <div class="col-sm-12">
        <div class="panel panel-default" id="list_19604" style="display: block; position: relative;">
            <div class="panel-heading">
                Premenné pre položku zoznamu

                <button type="button" class="btn btn-success btn-xs btn-add-list-item-var pull-right"
                        data-toggle="dropdown" title="Pridať premennú" data-prefix="<?= $prefix . "[Children]" ?>"
                        onclick="">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>
            <div class="panel-body">
                <ul style="list-style: none;" class="snippet-vars">
                    <?php foreach ($model->children as $indexChild => $child) : ?>
                        <li>
                            <?= $this->render('_variable', [
                                'model' => $child,
                                'prefix' => $prefix . "[Children][$indexChild]",
                            ]); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>