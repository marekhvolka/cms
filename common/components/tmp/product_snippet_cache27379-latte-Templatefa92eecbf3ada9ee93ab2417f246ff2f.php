<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/ceska_sporitelna_pujcka/product_snippet_cache27379.latte

class Templatefa92eecbf3ada9ee93ab2417f246ff2f extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('469dcc2fd1', 'html')
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
'text' => 'Možnost navrácení až 10 splátek, u konsolidace až 12-ti splátek', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Rychlé vyřízení', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'Možnost konsolidace i kontokorentu', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'3' => (object) array(
'text' => 'Pojištění půjčky proti neschopnosti splácet', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'4' => (object) array(
'text' => 'Možnost odložení splátek až 2x ročně', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'5' => (object) array(
'text' => 'Možnost odstoupení od smlouvy do 60-ti dnů od sjednání', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'6' => (object) array(
'text' => 'Možnost předschváleného úvěru', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
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