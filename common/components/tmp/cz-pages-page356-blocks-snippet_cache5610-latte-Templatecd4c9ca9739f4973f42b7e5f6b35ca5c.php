<?php
// source: /Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/blocks/snippet_cache5610.latte

class Templatecd4c9ca9739f4973f42b7e5f6b35ca5c extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('6e5104f172', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products/word.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_var.php";

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/snippets/snippet73/snippet.php";
$nadpis = 'Životní pojištění';
$text = 'Máte rodinu a splácíte hypotéku, leasing nebo máte jiné závazky? Narodili se vám děti a žena je mateřské dovolené? Sjednejte si životní pojištění ihned online a chraňte tak své blízké.';
$polozky = array('1381' => (object) array('text' => 'Životní pojištění sjednané na dožití, vám zajistí spokojené stáří bez finančního nedostatku.', ), '1382' => (object) array('text' => 'Pokud nejsou za dobu pojištění splněna kritéria, lze si nechat vyplatit částku jednorázově nebo po splátkách.', ), '1383' => (object) array('text' => 'Sami si volíte částku, kterou chcete spořit.', ), '1384' => (object) array('text' => 'Získejte daňové úlevy a šetřete peníze', ), '1385' => (object) array('text' => 'Na jednu pojistnou smlouvu můžete pojistit celou rodinu', ), '1386' => (object) array('text' => 'Pomůžeme vám uzavřít pojistku dle vašich specifických potřeb.', ), );
$ikona = 'fa fa-heart'
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