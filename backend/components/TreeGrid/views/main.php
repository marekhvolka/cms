<?php

use backend\components\TreeGrid\TreeGridAsset;

TreeGridAsset::register($this);
?>

<div class="tree-grid">
    <div class="head">
        <div class="row">
            <?php foreach ($columns as $column) : ?>
                <div class="col-sm-<?= $column['size'] ?>">
                    <?= $column['label'] ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="body">
        <?php foreach ($rows as $row) : ?>
            <?= $this->render('_row', [
                'row'                => $row,
                'columns'            => $columns,
                'childrenIdentifier' => $childrenIdentifier
            ]); ?>
        <?php endforeach; ?>
    </div>
</div>
