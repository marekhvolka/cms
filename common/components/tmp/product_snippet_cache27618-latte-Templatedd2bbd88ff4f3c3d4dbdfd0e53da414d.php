<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/provident_pujcka_cz/product_snippet_cache27618.latte

class Templatedd2bbd88ff4f3c3d4dbdfd0e53da414d extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('d0e8e29894', 'html')
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
'text' => 'Věk minimálně 18 let',), 
'1' => (object) array(
'text' => 'Pro zaměstnance, důchodce, osvč, ženy na rd',), 
'2' => (object) array(
'text' => 'Pravidelný jakýkoliv příjem',), 
'3' => (object) array(
'text' => 'Platné doklady totožnosti',), 
'4' => (object) array(
'text' => 'Číslo účtu v české bance',), 
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