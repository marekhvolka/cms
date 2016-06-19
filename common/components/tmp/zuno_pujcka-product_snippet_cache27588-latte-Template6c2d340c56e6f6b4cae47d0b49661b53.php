<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/zuno_pujcka/product_snippet_cache27588.latte

class Template6c2d340c56e6f6b4cae47d0b49661b53 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('60b7565901', 'html')
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
'text' => 'Vyplnění on-line žádosti (pro stávající zákazníky v internetovém bankovnictví).', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Podpis úvěrové smlouvy, kterou doveze kurýr a předání potřebných dokumentů.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'Založení bankovního účtu u Zuno Bank.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'3' => (object) array(
'text' => 'Schvalovací proces.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'4' => (object) array(
'text' => 'Výplata finančních prostředků.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
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