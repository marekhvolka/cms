<?php

/* @var $row */
/* @var $columns */
/* @var $level */
/* @var $childrenIdentifier */

if (!isset($level)) {
    $level = 0;
}

$subitems = $row[$childrenIdentifier];
?>
<div class="level">
    <div class="row">
        <?php foreach ($columns as $index => $column) : ?>
            <div class="col-sm-<?= $column['size'] ?>">
                <span class="content"
                      <?php if ($index == 0) { ?>style="padding-left: <?= $level * 15 + ((count($subitems) == 0) ? 15 : 0) ?>px"<?php } ?>>
                    <?php if(count($subitems) > 0 && $index == 0) { ?>
                        <a href="#" class="toggle"><i class="fa fa-angle-up"></i></a>
                    <?php } ?>
                    <?php if ($level > 0 && $index == 0) echo '<span class="subitem-identifier">└</span>'; ?> <?= $row[$column['value']] ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
    <?php foreach ($subitems as $child) : ?>
        <?= $this->render('_row', [
            'row'                => $child,
            'columns'            => $columns,
            'childrenIdentifier' => $childrenIdentifier,
            'level'              => $level + 1
        ]); ?>
    <?php endforeach; ?>
</div>