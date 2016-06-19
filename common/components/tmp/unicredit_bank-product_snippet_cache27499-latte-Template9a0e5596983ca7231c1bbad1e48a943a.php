<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/unicredit_bank/product_snippet_cache27499.latte

class Template9a0e5596983ca7231c1bbad1e48a943a extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('979cb1ea03', 'html')
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
'label' => 'Okamžitá možnosť disponovania s Vašimi peniazmi', 'text' => '',), 
'1' => (object) array(
'label' => 'Disponovanie s peniazmi prostredníctvom  služieb elektronického bankovníctva', 'text' => '',), 
'2' => (object) array(
'label' => 'Riadenie zostatku na účte rezerváciou, vinkuláciou peňazí, príkazom na zrovnávanie zostatku (sweeping) na účte podľa Vašich pokynov', 'text' => '',), 
'3' => (object) array(
'label' => 'Vklad a výber hotovosti', 'text' => '',), 
'4' => (object) array(
'label' => 'Použitie platobných kariet', 'text' => '',), 
)
?>
<h4><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h4>
<ul>
<?php $iterations = 0; foreach ($snippet->informacie as $informacia) { ?>
  <li><?php echo Latte\Runtime\Filters::escapeHtml($informacia->label, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
</ul><?php
}}