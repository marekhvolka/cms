<?php
// source: /Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/blocks/snippet_cache5604.latte

class Template507f22b01b3f7f59d52089dec864f2fd extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('f44f21b1f6', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products/word.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_var.php";

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/snippets/snippet73/snippet.php";
$nadpis = 'Povinné ručení';
$text = 'Díky <strong>online povinnému ručení</strong> si můžete vybrat pojištění s rozumem, podle skutečných čísel, ne jen na základě reklamních hesel. Nezávazné srovnání je otázkou pár minut, po kterých budete mít jasno, jestli se vám vyplatí sjednat některou z nabídek našich partnerských pojišťoven.';
$polozky = array('1366' => (object) array('text' => 'Povinné pojištění se zákonnými parametry za nejvýhodnější ceny.', ), '1367' => (object) array('text' => 'Možnost zvolit si nadstandardní služby i ochrany podle nabídek jednotlivých pojišťoven.', ), '1368' => (object) array('text' => 'Bezplatná konzultace s pojišťovacím specialistou po telefonu.', ), '1369' => (object) array('text' => '<strong>Zelená karta vám přijde emailem ihned po sjednání.</strong>', ), '1370' => (object) array('text' => 'Přehledné srovnání produktů s podobnými až totožnými parametry.', ), );
$ikona = 'fa fa-car'
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