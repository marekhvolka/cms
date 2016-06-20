<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/blocks/snippet_cache27967.latte

class Templatea4078ab3bb42c34915a80b0d495fa7b4 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('71cc84314b', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet25/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->hlavny_nadpis = '';
$snippet->podnadpis = '';
$snippet->text = '';
/* Var values  */
$snippet->hlavny_nadpis = 'ZUNO pôžička';
$snippet->podnadpis = 'Bezúčelový úver od ZUNO na čokoľvek';
$snippet->text = 'Pôžičku od ZUNO vybavíte online a bez poplatkov a to 24 hodín denne, 7 dní v týždni. Môžete si požičať už od ' . $product->dolna_hranica_pozicky . ' € až do ' . $product->horna_hranica_pozicky . ' € pri garantovanom úroku už ' . $product->urok_porovnavac . '. Dobu splácania si určíte v rozmedzí ' . $product->dolna_hranica_splatnosti . ' až ' . $product->horna_hranica_splatnosti . ' mesiacov sami. Pri pôžičke od ZUNO zariadite úplne všetko online z pohodlia domova. '
?>
<div class="hgroup">
<?php if (!empty($snippet->hlavny_nadpis)) { ?>
    <h1><?php echo Latte\Runtime\Filters::escapeHtml($snippet->hlavny_nadpis, ENT_NOQUOTES) ?></h1>
<?php } ?>
  
<?php if (!empty($snippet->podnadpis)) { ?>
    <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->podnadpis, ENT_NOQUOTES) ?></h3>
<?php } ?>
</div>
<p>
  <?php echo Latte\Runtime\Filters::escapeHtml($snippet->text, ENT_NOQUOTES) ?>

</p><?php
}}