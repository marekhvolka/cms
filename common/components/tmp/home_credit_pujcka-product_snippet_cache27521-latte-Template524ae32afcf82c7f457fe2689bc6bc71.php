<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/home_credit_pujcka/product_snippet_cache27521.latte

class Template524ae32afcf82c7f457fe2689bc6bc71 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('29d51efabf', 'html')
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
'text' => 'Půjčka bez ručitele', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Půjčka bez zbytečné administrativy ', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'Půjčka není omezena horní věkovou hranicí', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'3' => (object) array(
'text' => 'Možnost získat peníze v hotovosti', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'4' => (object) array(
'text' => 'Půjčka je bezúčelová', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'5' => (object) array(
'text' => 'Možnost sjednat pojištění proti neschopnosti splácet', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
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