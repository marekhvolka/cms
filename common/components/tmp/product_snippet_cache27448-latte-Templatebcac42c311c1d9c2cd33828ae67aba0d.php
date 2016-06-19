<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/proficredit_pozicka/product_snippet_cache27448.latte

class Templatebcac42c311c1d9c2cd33828ae67aba0d extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('6d51811bd2', 'html')
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
'text' => 'fyzická osoba vo veku nad 18 rokov, s trvalým pobytom na Slovensku',), 
'1' => (object) array(
'text' => 'držiteľ platného občianskeho preukazu s pravidelným príjmom',), 
'2' => (object) array(
'text' => 'dokladovanie príjmu - pracovná zmluva, výpis bankového účtu, dôchodkový výmer...',), 
'3' => (object) array(
'text' => 'pre podnikateľov aj - potvrdenie o výške daňovej povinnosti, daňové priznanie za posledné zdaňovacie obdobie, potvrdenie o zápise v podnikateľských registroch, saldo v Sociálnej poisťovni....',), 
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