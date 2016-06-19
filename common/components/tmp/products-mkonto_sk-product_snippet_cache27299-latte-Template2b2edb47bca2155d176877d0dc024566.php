<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/mkonto_sk/product_snippet_cache27299.latte

class Template2b2edb47bca2155d176877d0dc024566 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('14a38e43ff', 'html')
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
'label' => 'Dokonalý prehľad o pohyboch na účte', 'text' => '',), 
'1' => (object) array(
'label' => 'Praktická a pohodlná mobilná aplikácia zadarmo', 'text' => '',), 
'2' => (object) array(
'label' => 'Možnosť zakúpenia viacerých druhov poistenia', 'text' => '',), 
'3' => (object) array(
'label' => 'Platobná karta VISA pri aktívnom využívaní zadarmo', 'text' => '',), 
'4' => (object) array(
'label' => 'Všetky platby a príkazy cez internet banking zadarmo', 'text' => '',), 
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