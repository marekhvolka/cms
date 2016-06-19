<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/ceska_sporitelna_pujcka/product_snippet_cache27378.latte

class Templatebe361564c4624f133395ad9bd6a7fb61 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('485c369a95', 'html')
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
'text' => 'věk 18 let',), 
'1' => (object) array(
'text' => 'trvalý pobyt na území České republiky',), 
'2' => (object) array(
'text' => '2 doklady totožnosti - občanský průkaz, řidičský průkaz či rodný list',), 
'3' => (object) array(
'text' => 'údaje o zaměstnavateli (potvrzení od zaměstnavatele o příjmu za poslední 3 měsíce)',), 
'4' => (object) array(
'text' => 'založení bankovního konta',), 
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