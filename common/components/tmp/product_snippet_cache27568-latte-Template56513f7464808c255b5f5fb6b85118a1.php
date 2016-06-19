<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/sberbank_ferovapozicka/product_snippet_cache27568.latte

class Template56513f7464808c255b5f5fb6b85118a1 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('b5af9c2582', 'html')
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
'text' => 'Schválenie úveru už na počkanie',), 
'1' => (object) array(
'text' => 'Bezúčelová pôžička na čokoľvek',), 
'2' => (object) array(
'text' => 'Bez akéhokoľvek ručenia',), 
'3' => (object) array(
'text' => 'Bez potvrdenia o príjme',), 
'4' => (object) array(
'text' => 'Možnosť bezplatného predčasného splatenia',), 
'5' => (object) array(
'text' => 'Fixné mesačné splátky',), 
);
$snippet->podmienky_zoznam =  array(
'0' => (object) array(
'text' => 'Vek v rozmedzí 18 – 65 rokov',), 
'1' => (object) array(
'text' => 'Trvalý alebo prechodný pobyt na území SR',), 
'2' => (object) array(
'text' => 'Doklad totožnosti a iný bežný doklad',), 
);
$snippet->klient_text = 'Na kúpu môjho prvého auta mi ešte chýbala menšia časť peňazí, na ktorú som si však vzala pôžičku od Sberbank. Zaobišla som sa bez zbytočných dokladov a administrácie, poskytli mi naozaj výhodný úrok a fixné mesačné splátky s poistením.';
$snippet->klient_meno = 'Michaela, Skalica'
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