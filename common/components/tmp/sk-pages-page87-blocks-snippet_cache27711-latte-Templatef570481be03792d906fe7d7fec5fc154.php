<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/blocks/snippet_cache27711.latte

class Templatef570481be03792d906fe7d7fec5fc154 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('bbb5623e57', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet94/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->nadpis = 'O ' . $slovnik->spolocnosti . ' ' . $product->nazov_spolocnosti . '';
$snippet->text = '';
$snippet->podstranka_viac = '';
/* Var values  */
$snippet->nadpis = 'O ' . $slovnik->spolocnosti . ' ' . $product->nazov_spolocnosti . '';
$snippet->text = '<p>Spoločnosť Provident má dlhú tradíciu siahajúcu až do roku 1880, kedy bola vo Veľkej Británii založená. U nás pôsobí už od roku 2001. <strong>Pôžičky od Provident</strong> využíva stále viac Slovákov, a to hlavne vďaka jednoduchému a rýchlemu spôsobu žiadania o pôžičku. Každej pôžičke a zákazníkovi je venovaná individuálna pozornosť a starostlivosť obchodného zástupcu.</p><p>Vďaka sieti obchodných zástupcov spoločnosti Provident po celom území Slovenska môžete všetko vyriešiť z pohodlia domova. Pri hotovostnej pôžičke obdržíte peniaze do 48 hodín, často však ešte v deň požiadania o pôžičku. Nielen dlhá tradícia požičiavania peňazí zaručuje transparentný prístup ku zákazníkom, teda jednoduché a zrozumiteľné podmienky a žiadne skryté poplatky.</p>';
$snippet->podstranka_viac = NULL
?>
<div class="">
  <h2><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h2>
  <img src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($product->logo_medium), ENT_COMPAT) ?>
" class="inline-image" title="<?php echo Latte\Runtime\Filters::escapeHtml($product->nazov_spolocnosti, ENT_COMPAT) ?>
" alt="<?php echo Latte\Runtime\Filters::escapeHtml($product->nazov_spolocnosti, ENT_COMPAT) ?>">
  <p>
    <?php echo Latte\Runtime\Filters::escapeHtml($snippet->text, ENT_NOQUOTES) ?>

  </p>
<?php if (!empty($snippet->podstranka_viac)) { ?>
  	<a href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->podstranka_viac->url), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->viac_informacii, ENT_NOQUOTES) ?></a>
<?php } ?>
</div><?php
}}