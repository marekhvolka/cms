<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/otp_pozicka/product_snippet_cache27561.latte

class Template2a2b6df15e639c5c7b941a83dcccbbca extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('0450a10555', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet83/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->informacie_zoznam =  array(
'0' => (object) array(
'text' => '1 mesiac v roku, kedy pôžičku nesplácate',), 
'1' => (object) array(
'text' => 'Poskytnutie pôžičky bez poplatkov',), 
'2' => (object) array(
'text' => 'Garantovaný úrok počas celej doby splácania',), 
'3' => (object) array(
'text' => 'Účet v ZUNO k pôžičke zdarma',), 
'4' => (object) array(
'text' => 'Dobrovoľné poistenie pre ochranu v neschopnosti splácania',), 
);
$snippet->podmienky_zoznam =  array(
'0' => (object) array(
'text' => 'Vek aspoň 18 rokov',), 
'1' => (object) array(
'text' => 'Zamestnanec, SZČO alebo dôchodca',), 
'2' => (object) array(
'text' => 'Žiadny negatívny záznam v databázach Credit Bureau a SOLUS',), 
)
?>
<div class="col-sm-4">
  <div class="box">
    <h4><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->informacie_o_produkte, ENT_NOQUOTES) ?></h4>
    <ul>
<?php $iterations = 0; foreach ($snippet->informacie_zoznam as $informacia) { ?>
      <li><?php echo Latte\Runtime\Filters::escapeHtml($informacia->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
    </ul>
  </div>
</div>
<div class="col-sm-4">
  <div class="box">
    <h4><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->podmienky_a_doklady, ENT_NOQUOTES) ?></h4>
    <ul>
<?php $iterations = 0; foreach ($snippet->podmienky_zoznam as $podmienka) { ?>
      <li><?php echo Latte\Runtime\Filters::escapeHtml($podmienka->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
    </ul>
  </div>
</div><?php
}}