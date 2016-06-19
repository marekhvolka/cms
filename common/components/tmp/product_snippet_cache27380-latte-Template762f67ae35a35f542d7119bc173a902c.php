<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/ceska_sporitelna_pujcka/product_snippet_cache27380.latte

class Template762f67ae35a35f542d7119bc173a902c extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5c6569465c', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet30/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->ako_postupovat . '';
$snippet->kroky =  array(
'0' => (object) array(
'text' => 'Vyplnění on-line formuláře.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Fyzické doložení požadovaných dokumentů na nejbližší pobočce.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'Schvalovací proces na pobočce (do 15 minut znáte výsledek).', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'3' => (object) array(
'text' => 'Podpis úvěrové smlouvy a výplata finačních prostředků.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
)
?>
<div class="kroky kroky-number-with-dot">
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h3>
  <ol>
<?php $iterations = 0; foreach ($snippet->kroky as $krok) { ?>
    <li><?php echo Latte\Runtime\Filters::escapeHtml($krok->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
  </ol>
</div><?php
}}