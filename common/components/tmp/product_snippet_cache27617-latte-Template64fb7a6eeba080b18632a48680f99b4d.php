<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/provident_pujcka_cz/product_snippet_cache27617.latte

class Template64fb7a6eeba080b18632a48680f99b4d extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('34a6c06822', 'html')
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
'text' => 'Vyplnění on-line žádosti.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Vyčkání na spojení s klientským centrem.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'Návštěva obchodního zástupce, podpis smlouvy, hotovostní výplata půjčky.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
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