<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/equa_ucet/product_snippet_cache27362.latte

class Template8facaf7b46a7b9976e4f11f851280da9 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('2707985be0', 'html')
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
'label' => 'Debetní karta', 'text' => 'MasterCard',), 
'2' => (object) array(
'label' => 'Min. počáteční vklad', 'text' => '0 Kč',), 
'3' => (object) array(
'label' => 'Trvalé příkazy, inkaso', 'text' => '0 Kč',), 
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