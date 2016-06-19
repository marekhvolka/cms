<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/kredito24/product_snippet_cache27281.latte

class Template019b7ced908e62ddc963636fee823971 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('31199a1f97', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet88/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->podmienky_a_doklady . '';
$snippet->polozky =  array(
'0' => (object) array(
'text' => 'věk nad 18 let',), 
'1' => (object) array(
'text' => 'trvalý pobyt na území České republiky',), 
'2' => (object) array(
'text' => 'občanský průkaz',), 
'3' => (object) array(
'text' => 'bankovní účet vedený na jméno žadatele',), 
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