<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/pozickomat/product_snippet_cache27490.latte

class Templatefa23aaf4bd5729e2419912377e7e394e extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('e5856efb9c', 'html')
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
'text' => 'trvalý pobyt na Slovensku a vek minimálne 18 rokov',), 
'1' => (object) array(
'text' => 'pravidelný príjem (zo závislej činnosti, z podnikania, dôchodok...)',), 
'2' => (object) array(
'text' => 'osobný účet v niektorej bankovej inštitúcii',), 
'3' => (object) array(
'text' => 'žiadateľ nesmie byť v omeškaní so splácaním svojich záväzkov u iných finančných subjektov',), 
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