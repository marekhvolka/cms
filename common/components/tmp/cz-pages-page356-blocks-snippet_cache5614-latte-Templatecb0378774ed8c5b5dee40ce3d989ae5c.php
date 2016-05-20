<?php
// source: /Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/blocks/snippet_cache5614.latte

class Templatecb0378774ed8c5b5dee40ce3d989ae5c extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('f0c9375e54', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products/word.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_var.php";

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/snippets/snippet73/snippet.php";
$nadpis = 'Penzijní připojištění';
$text = 'Kvalita života ve stáří je palčivou otázkou již pro dnešní seniory. Jaký bude váš důchod, už záleží jen na tom, kolik si na něj dokážete naspořit sami. S penzijním připojištěním máte v rukou skvělý nástroj podporovaný státem i největšími pojišťovnami u nás.';
$polozky = array('1392' => (object) array('text' => '<strong>Státní příspěvek až 230 Kč měsíčně</strong>, tedy 2 760 Kč ročně, neboli 100 000 Kč za 36 let plus úroky!', ), '1393' => (object) array('text' => 'Daňově zvýhodněné příspěvky zaměstnavatele – takzvané „čisté“ peníze, nedaněné ani na straně zaměstnance.', ), '1394' => (object) array('text' => '<strong>Bonus až 1 800 Kč ročně</strong> pro příspěvky účastníka nad 12 000 Kč ročně', ), '1395' => (object) array('text' => 'Průměrný výnos kolem 5 % ročně od vzniku penzijního připojištění', ), '1396' => (object) array('text' => 'Jediný efektivní způsob dlouhodobého spoření na penzi se státním zvýhodněním', ), '1397' => (object) array('text' => 'Možnost volby z více investičních strategií a vyvážení zisku a rizika', ), );
$ikona = ''
?>
<div class="poistenie-snippet">
<?php if (!empty($ikona)) { ?><i class="<?php echo Latte\Runtime\Filters::escapeHtml($ikona, ENT_COMPAT) ?>
"></i><?php } ?>

<h2><?php echo Latte\Runtime\Filters::escapeHtml($nadpis, ENT_NOQUOTES) ?></h2>
<p><?php echo Latte\Runtime\Filters::escapeHtml($text, ENT_NOQUOTES) ?></p>
<ul class="list-default">
<?php $iterations = 0; foreach ($polozky as $polozka) { ?>
  <li><?php echo Latte\Runtime\Filters::escapeHtml($polozka->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
</ul>
</div><?php
}}