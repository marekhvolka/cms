<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/zaplo_cz/product_snippet_cache27312.latte

class Templatea7aab271bc068b7b4ca22eb8fd0a1839 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('c823569e66', 'html')
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
'text' => 'Žadatel musí být občanem České republiky',), 
'1' => (object) array(
'text' => 'Minimální věk 18 let',), 
'2' => (object) array(
'text' => 'Bankovní účet vedený na jméno žadatele',), 
'3' => (object) array(
'text' => 'Bezdlužnost',), 
'4' => (object) array(
'text' => 'Schopnost splatit půjčku ve stanoveném termínu',), 
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