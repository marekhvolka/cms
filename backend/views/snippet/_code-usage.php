<?php
use yii\helpers\Url;

/* @var $pageAreas */
/* @var $portalAreas */
/* @var $products */
/* @var $portals */

?>
<?php if (count($pageAreas)) : ?>
    <h2>Podstránky</h2>
    <ul>
        <?php foreach ($pageAreas as $area) : ?>
            <li>
                <a href="<?= Url::to(['/page/edit', 'id' => $area[2]->id]) ?>#block-<?= $area[1]->id ?>"><?= $area[2]->breadcrumbs ?> (<?= $area[0]->type ?>) - <?= $area[2]->portal->name ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if (count($portalAreas)) : ?>
    <h2>Portálový layout</h2>
    <ul>
        <?php foreach ($portalAreas as $area) : ?>
            <li>
                <a href=""><?= $area[2]->name ?> (<?= $area[0]->type ?>) - <?= $area[2]->name ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if (count($portals)) : ?>
    <h2>Portálové snippety</h2>
    <ul>
        <?php foreach ($portals as $portal) : ?>
            <li>
                <a href="<?= Url::to(['/portal/edit', 'id' => $portal[0]->id]) ?>#var-<?= $portal[1]->portal_var_value_id ?>"><?= $portal[0]->name ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if (count($products)) : ?>
    <h2>Produktové snippety</h2>
    <ul>
        <?php foreach ($products as $product) { ?>
            <li>
                <a href="<?= Url::to(['/product/edit', 'id' => $product[0]->id]) ?>#var-<?= $product[1]->product_var_value_id ?>"><?= $product[0]->name ?></a>
            </li>
        <?php } ?>
    </ul>
<?php endif; ?>