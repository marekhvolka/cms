<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/csob_pujcka/product_snippet_cache27652.latte

class Template1f327c798f90f12d58f7402c9f7133f2 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('f75bd292e7', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet24/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->vyhody . '';
$snippet->pocet_stlpcov_listu = '2';
$snippet->zoznam =  array(
'0' => (object) array(
'text' => 'Sjednání půjčky on-line', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Možnost využití osobní půjčky, refinancování nebo kontokorentu', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'Pojištění schopnosti splácet', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
);
$snippet->vyska_pozicky = '' . $slovnik->vyska_pozicky . '';
$snippet->splatnost = '' . $slovnik->splatnost . ''
?>
<div class="vyhody">
  <a id="vyhody"></a>
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h3>
  <ul class="vyhody">
<?php $iterations = 0; foreach ($snippet->zoznam as $vyhoda) { ?>
    <li><?php echo Latte\Runtime\Filters::escapeHtml($vyhoda->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
  </ul>
  <div class="clearfix"></div>
</div><?php
}}