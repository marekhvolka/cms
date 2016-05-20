<?php
// source: /Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/blocks/snippet_cache5608.latte

class Template31bb914c2c8de47a3fd42a32e4c99ef0 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('2718d3e971', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products/word.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_var.php";

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/snippets/snippet73/snippet.php";
$nadpis = 'Úrazové pojištění';
$text = 'Každý již měl v životě úraz. Horší je, když vám zhoršení zdraví brání v práci a strádate velkou část příjmu. S úrazovým pojištěním máte kryté náklady po dobu léčení, v případě smrti finančně chráníte své blízké. Sjednejte si ho online ještě dnes.';
$polozky = array('1377' => (object) array('text' => 'Úrazové pojištění lze prostřednictvím online formuláře jednoduše sjednat na našich stránkách', ), '1378' => (object) array('text' => 'Výpadek příjmu v důsledku úrazu nebo dokonce smrti přestane být pro vás i vaši rodinu hrozbou', ), '1379' => (object) array('text' => 'Lze pojistit rizika:
<ul class="list-default">
<li>Smrt jako následek úrazu - ochrání pozůstalé</li>
<li>Trvalé následky v důsledku úrazu – řeší situaci poklesu příjmu</li>
<li>Denní odškodné po dobu léčení – poskytuje finanční prostředky pro krytí nezbytných denních výdajů</li>
</ul>', ), '1380' => (object) array('text' => 'Pomůžeme vám určit optimální pojistné částky', ), );
$ikona = 'fa fa-medkit'
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