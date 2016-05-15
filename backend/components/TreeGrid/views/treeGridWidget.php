<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 22:50
 */

?>

<table class="table table-striped">
    <thead>
    <?php foreach ($columns as $column) : ?>
        <th>
            <?= $column['label'] ?>
        </th>
    <?php endforeach; ?>
    </thead>
    <tbody>
    <?php foreach ($rows as $row) : ?>
        <?= $this->render('_row', [
            'row' => $row,
            'columns' => $columns,
            'childrenIdentifier' => $childrenIdentifier
        ]); ?>
    <?php endforeach; ?>
    </tbody>
</table>

