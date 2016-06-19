<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/smart_pujcka/product_snippet_cache27323.latte

class Templatefcda2d7e16da181e29f32fbf598211fe extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('78f714b474', 'html')
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
'text' => 'Půjčka je bez poplatků za poskytnutí půjčky', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Zažádáte si o ní on-line', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'K získání půjčky potřebujete minimum dokumentů', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'3' => (object) array(
'text' => 'Půjčka je neúčelová', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'4' => (object) array(
'text' => 'Není nahlíženo do registru dlužníků a rejstříku exekucí', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'5' => (object) array(
'text' => 'Kdykoliv lze půjčku splatit předčasně', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
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