<?php
use backend\models\Page;
use yii\bootstrap\Html;
use yii\helpers\Url;

/** @var $requestedPage \backend\models\LayoutOwner */
?>

<style>
    body {
        margin-top: 60px;
    }
</style>

<link rel="stylesheet" href="/backend/web/css/global-search.css">
<script src="/backend/web/js/global-search.js"></script>

<div class="cms-top-bar">

    <span>CSS štýly</span>
    <select class="input-sm" id="template-switch">
        <?php foreach ($requestedPage->portal->template->getCssSchemes() as $cssScheme) : ?>
            <option value="<?= $cssScheme->getPath() ?>"><?= $cssScheme->name ?></option>

        <?php endforeach; ?>
    </select>

    <?php
        $this->registerJs("var globalSearchUrl = \"" . Url::to(['global-search-results']) . "\";", \yii\web\View::POS_END);
    ?>
    <div class="global-search">
        <?= Html::input('string', 'globalSearch', null, [
            'id' => 'global-search-input',
            'placeholder' => 'Globálne vyhľadávanie',
            'class' => 'form-control',
            'autofocus' => 'autofocus',
            'autocomplete' => 'off'
        ]) ?>
        <ul class="data">
            <li>Žiadne výsledky</li>
        </ul>
    </div>

    <div class="pull-right">
        <?php if ($requestedPage->isPage()) : ?>
            <?= Html::a('Upraviť podstránku', '/backend/web/page/edit/' . $requestedPage->id, [
                'target' => '_blank'
            ]) ?>
            <?= isset($requestedPage->product) ?
                Html::a('Upraviť produkt', '/backend/web/product/edit/' . $requestedPage->product->id, [
                    'target' => '_blank'
                ]) : '' ?>
        <?php elseif ($requestedPage->isPost()) : ?>
            <?= Html::a('Upraviť článok', '/backend/web/post/edit/' . $requestedPage->id, [
                'target' => '_blank'
            ]) ?>
        <?php endif; ?>
        Prihlásený ako <?= Yii::$app->user->getIdentity()->username ?>.
    </div>
</div>

<script>

    $(document).ready(
        function () {
            var stylesPath = getCookie('developTemplate');

            if (stylesPath != null && stylesPath != 'null' && stylesPath != 'undefined') {
                $("#template-switch").val(stylesPath);
                changeTemplate(stylesPath);
            }
        }
    );

    $('#template-switch').change(
        function () {
            var newStylesheet = $(this).val();
            changeTemplate(newStylesheet);
        }
    );

    function changeTemplate(newStylesheet) {
        $('#template-main').attr('href', newStylesheet);
        setCookie('developTemplate', newStylesheet);
    }

    function setCookie(key, value) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';path=/;expires=' + expires.toUTCString();
    }

    function getCookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }
</script>