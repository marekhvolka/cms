<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/sberbank_ferovapozicka/product_snippet_cache27569.latte

class Templatea2cad20118a696b16450b1ede4a0d538 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('6ba1c649a3', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet88/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->podmienky_a_doklady . '';
$snippet->polozky =  array(
'0' => (object) array(
'text' => 'fyzická osoba s trvalým pobytom na Slovensku',), 
'1' => (object) array(
'text' => 'vek v intervale 18 – 65 rokov',), 
'2' => (object) array(
'text' => 'platný doklad totožnosti',), 
'3' => (object) array(
'text' => 'existencia pravidelného príjmu (zo závislej činnosti, z podnikateľskej činnosti...)',), 
)
?>
<div class="vyhody">
  <a id="vyhody"></a>
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h3>
  <ul class="vyhody vyhody-<?php echo Latte\Runtime\Filters::escapeHtml($snippet->pocet_stlpcov_listu, ENT_COMPAT) ?>">
<?php $iterations = 0; foreach ($snippet->polozky as $polozka) { ?>
    <li><?php echo Latte\Runtime\Filters::escapeHtml($polozka->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
  </ul>
  <div class="clearfix"></div>
</div><?php
}}