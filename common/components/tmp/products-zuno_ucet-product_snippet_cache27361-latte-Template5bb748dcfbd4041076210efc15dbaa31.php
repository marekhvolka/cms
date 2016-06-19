<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/zuno_ucet/product_snippet_cache27361.latte

class Template5bb748dcfbd4041076210efc15dbaa31 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('d731627fe6', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet72/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->informacie_o_produkte . '';
$snippet->informacie =  array(
'0' => (object) array(
'label' => 'Platobná karta VISA', 'text' => '',), 
'1' => (object) array(
'label' => 'Notifikácie emailom a SMS', 'text' => '',), 
'2' => (object) array(
'label' => 'Možnosť poistenia kariet', 'text' => '',), 
'3' => (object) array(
'label' => 'Prehľadný a jednoducho ovládateľný online banking', 'text' => '',), 
'4' => (object) array(
'label' => 'Praktický a jednoducho ovládateľný mobile banking', 'text' => '',), 
)
?>
<h4><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h4>
<ul>
<?php $iterations = 0; foreach ($snippet->informacie as $informacia) { ?>
  <li><?php echo Latte\Runtime\Filters::escapeHtml($informacia->label, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
</ul><?php
}}