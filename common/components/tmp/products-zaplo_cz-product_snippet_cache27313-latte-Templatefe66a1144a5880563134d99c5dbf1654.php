<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/zaplo_cz/product_snippet_cache27313.latte

class Templatefe66a1144a5880563134d99c5dbf1654 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('f9b0f8d94c', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet24/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->vyhody . '';
$snippet->pocet_stlpcov_listu = '2';
$snippet->zoznam =  array(
'0' => (object) array(
'text' => 'První půjčka zcela bez poplatků', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Navyšování úvěrového rámce', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'Nízké nároky na bonitu klienta', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'3' => (object) array(
'text' => 'Rychlé a jednoduché vyřízení online', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'4' => (object) array(
'text' => 'Zpráva o schválení během několika minut', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
'5' => (object) array(
'text' => 'Možnost žádat 24 hodin denně 7 dní v týdnu', 'popis' => '', 'ikona' => '', 'obrazok' => '',), 
);
$snippet->vyska_pozicky = '' . $slovnik->vyska_pozicky . '';
$snippet->splatnost = '' . $slovnik->splatnost . ''
?>
<div class="vyhody">
  <a id="vyhody"></a>
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h3>
  <ul class="vyhody">
<?php $iterations = 0; foreach ($snippet->zoznam as $vyhoda) { ?>
    <li><?php echo Latte\Runtime\Filters::escapeHtml($vyhoda->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
  </ul>
  <div class="clearfix"></div>
</div><?php
}}