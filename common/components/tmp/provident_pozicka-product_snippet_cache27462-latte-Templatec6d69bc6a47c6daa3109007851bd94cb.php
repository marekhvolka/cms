<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/provident_pozicka/product_snippet_cache27462.latte

class Templatec6d69bc6a47c6daa3109007851bd94cb extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('305de8f58f', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet24/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->vyhody . '';
$snippet->pocet_stlpcov_listu = '2';
$snippet->zoznam =  array(
'0' => (object) array(
'text' => 'Pôžička bez skrytých poplatkov', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Jednoduchá zmluva o pôžičke, ktorej porozumie každý', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'Pôžička bez ručiteľa', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
)
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