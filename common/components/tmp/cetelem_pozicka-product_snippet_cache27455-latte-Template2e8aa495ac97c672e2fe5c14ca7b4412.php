<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/cetelem_pozicka/product_snippet_cache27455.latte

class Template2e8aa495ac97c672e2fe5c14ca7b4412 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('4e1af1c2a8', 'html')
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
'text' => 'fyzická osoba vo veku 18 – 65 rokov s trvalým pobytom v SR',), 
'1' => (object) array(
'text' => 'pravidelný príjem (zo závislej činnosti, z podnikania, dôchodok...)',), 
'2' => (object) array(
'text' => 'platný  preukaz totožnosti',), 
'3' => (object) array(
'text' => 'osobný účet v niektorej bankovej inštitúcii',), 
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