<?php 

?>

<div class="row child-var-box">
    <div class="col-sm-12">
        <div class="panel panel-default" id="list_19604" style="display: block; position: relative;">
            <div class="panel-heading">
                Premenné pre položku zoznamu

                <button type="button" class="btn btn-success btn-xs btn-add-list-item-var pull-right"
                        data-toggle="dropdown" aria-expanded="false" title="Pridať premennú"
                        onclick="">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>
            <div class="panel-body">
                <input type="hidden" value="0" id="">
                <ul style="list-style: none;" class="snippet-vars">
                    <?php foreach ($snippetVar->children as $child) : ?>
                        <li>
                            <?= $this->render('_variable', ['snippetVar' => $child]); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>