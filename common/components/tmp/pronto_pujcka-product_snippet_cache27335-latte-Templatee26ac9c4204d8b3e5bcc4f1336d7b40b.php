<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/pronto_pujcka/product_snippet_cache27335.latte

class Templatee26ac9c4204d8b3e5bcc4f1336d7b40b extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5a634341dd', 'html')
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
'text' => 'Naprostá transparentnost', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Možnost rozložení splátek do 1 - 2 let', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'Kompletní on-line vyřízení', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'3' => (object) array(
'text' => 'Žádné poplatky', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'4' => (object) array(
'text' => 'Velmi nízká úroková sazba', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
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