<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/mikro_multiform_cz/product_snippet_cache27255.latte

class Template44cc79cb591a64cbd6e685ae29baf202 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5ff47eb1e6', 'html')
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
'text' => 'Vyplnění nezávazného on-line formuláře.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'On-line sjednání půjčky a uzavření smlouvy.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'2' => (object) array(
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