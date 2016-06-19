<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/home_credit_pozicka/product_snippet_cache27434.latte

class Templatec260a2324bd4104acd5bdf3af9f68000 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('2c3163f468', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet88/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = 'Podmienky pôžičky';
$snippet->polozky =  array(
'0' => (object) array(
'text' => 'vek 18 rokov',), 
'1' => (object) array(
'text' => 'trvalý pobyt na území Slovenska',), 
'2' => (object) array(
'text' => '2 platné doklady totožnosti (občiansky preukaz, vodičský preukaz, cestovný pas...)',), 
'3' => (object) array(
'text' => 'pravidelný zdroj príjmu (mzda, dôchodok, príjem zo živnosti, rodičovské dávky a pod.)',), 
'4' => (object) array(
'text' => 'bankový účet na vlastné meno',), 
)
?>
<div class="vyhody">
  <a id="vyhody"></a>
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h3>
  <ul class="vyhody vyhody-<?php echo Latte\Runtime\Filters::escapeHtml($snippet->pocet_stlpcov_listu, ENT_COMPAT) ?>">
<?php $iterations = 0; foreach ($snippet->polozky as $polozka) { ?>
    <li><?php echo Latte\Runtime\Filters::escapeHtml($polozka->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
  </ul>
  <div class="clearfix"></div>
</div><?php
}}