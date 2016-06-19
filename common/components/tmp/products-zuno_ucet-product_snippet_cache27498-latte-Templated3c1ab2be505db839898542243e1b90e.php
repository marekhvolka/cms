<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/zuno_ucet/product_snippet_cache27498.latte

class Templated3c1ab2be505db839898542243e1b90e extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('b179f66589', 'html')
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
'label' => 'Kreditní karta', 'text' => 'zdarma',), 
'2' => (object) array(
'label' => 'Min. počáteční vklad', 'text' => '100 Kč',), 
'3' => (object) array(
'label' => 'Trvalé příkazy, SIPO, inkaso', 'text' => '0 Kč',), 
'4' => (object) array(
'label' => 'Vedení spořícího účtu', 'text' => '0 kč',), 
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