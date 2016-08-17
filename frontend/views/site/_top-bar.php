<?php
use backend\models\Page;
use backend\models\Portal;
use yii\bootstrap\Html;

/** @var $portal Portal */
/** @var $page Page */
?>

<div class="cms-top-bar">

    <select id="template-switch">
        <?php foreach($page->portal->template->getCssSchemes() as $cssScheme) : ?>
            <option value="<?= $cssScheme->getPath() ?>"><?= $cssScheme->name ?></option>

        <?php endforeach; ?>
    </select>

    <div class="pull-right">
        <?= Html::a('Upraviť podstránku', '/backend/web/page/edit/' . $page->id, [
            'target' => '_blank'
        ]) ?>
        <?= $page->product ?
            Html::a('Upraviť produkt', '/backend/web/product/edit/' . $page->product->id, [
                'target' => '_blank'
            ]) : '' ?>

        Prihlásený ako <?= Yii::$app->user->getIdentity()->username ?>.
    </div>
</div>

<script>

    $(document).ready(function() {
        var stylesPath = getCookie('developTemplate');

        if (stylesPath == null || stylesPath == 'null') {
            stylesPath = $('#template-main').attr('href');
        }

        $("#template-switch").val(stylesPath);
        changeTemplate(stylesPath);
    });

    $('#template-switch').change(function() {
        var newStylesheet = $(this).val();
        changeTemplate(newStylesheet);
    });

    function changeTemplate(newStylesheet) {
        $('#template-main').attr('href', newStylesheet);
        setCookie('developTemplate', newStylesheet);
    }

    function setCookie(key, value) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }

    function getCookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }
</script>