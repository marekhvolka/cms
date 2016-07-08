<?php
use backend\models\Area;
use backend\models\Portal;
use backend\models\Product;
use yii\helpers\Url;

/* @var $areas */
/* @var $products */
/* @var $portals */

?>
<?php if (count($areas)) { ?>
    <h2>Stránky</h2>
    <ul>
        <?php foreach ($areas as $area) { ?>
            <li>
                <a href="<?= Url::to(['/page/edit', 'id' => $area[2]->id]) ?>#block-<?= $area[1]->id ?>"><?= $area[2]->name ?> (<?= $area[0]->type ?>)</a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
<?php if (count($portals)) { ?>
    <h2>Portály</h2>
    <ul>
        <?php foreach ($portals as $portal) { ?>
            <li>
                <a href="<?= Url::to(['/portal/edit', 'id' => $portal[0]->id]) ?>#var-<?= $portal[1]->portal_var_value_id ?>"><?= $portal[0]->name ?></a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
<?php if (count($products)) { ?>
    <h2>Produkty</h2>
    <ul>
        <?php foreach ($products as $product) { ?>
            <li>
                <a href="<?= Url::to(['/product/edit', 'id' => $product[0]->id]) ?>#var-<?= $product[1]->product_var_value_id ?>"><?= $product[0]->name ?></a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>