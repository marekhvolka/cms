<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 22:52
 */

/* @var $row */
/* @var $columns */

?>
<tr>
<?php foreach ($columns as $column) : ?>
<td>
    <?= $row[$column['value']] ?>
</td>

<?php endforeach; ?>
</tr>

<?php foreach ($row[$childrenIdentifier] as $child) : ?>
    <?= $this->render('_row', [
        'row' => $child,
        'columns' => $columns,
        'childrenIdentifier' => $childrenIdentifier
    ]); ?>
<?php endforeach; ?>
