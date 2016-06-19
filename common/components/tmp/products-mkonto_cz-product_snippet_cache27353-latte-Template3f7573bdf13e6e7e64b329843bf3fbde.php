<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/mkonto_cz/product_snippet_cache27353.latte

class Template3f7573bdf13e6e7e64b329843bf3fbde extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('9abc09d5ed', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet72/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->informacie_o_produkte . '';
$snippet->informacie =  array(
'0' => (object) array(
'label' => 'Domácí platby', 'text' => '0 Kč',), 
'1' => (object) array(
'label' => 'Debetní karta', 'text' => 'Visa Classic',), 
'2' => (object) array(
'label' => 'Min. počáteční vklad', 'text' => '1 Kč',), 
'3' => (object) array(
'label' => 'Trvalé příkazy, inkaso', 'text' => '0 Kč',), 
'4' => (object) array(
'label' => 'Vedení účtu', 'text' => '0 kč',), 
)
?>
<h4><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h4>
<ul>
<?php $iterations = 0; foreach ($snippet->informacie as $informacia) { ?>
  <li><?php echo Latte\Runtime\Filters::escapeHtml($informacia->label, ENT_NOQUOTES) ?>
: <?php echo Latte\Runtime\Filters::escapeHtml($informacia->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
</ul><?php
}}