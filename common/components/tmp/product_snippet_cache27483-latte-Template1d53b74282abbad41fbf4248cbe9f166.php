<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/unicredit_presto_pozicka/product_snippet_cache27483.latte

class Template1d53b74282abbad41fbf4248cbe9f166 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('ac0b53711f', 'html')
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
'text' => 'fyzická osoba staršia ako 18 rokov',), 
'1' => (object) array(
'text' => 'trvalý alebo prechodný pobyt na Slovensku',), 
'2' => (object) array(
'text' => 'dva doklady totožnosti',), 
'3' => (object) array(
'text' => 'pravidelný príjem (zo závislej činnosti, z podnikateľskej činnosti...), výška čistého mesačného príjmu min 280 €',), 
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