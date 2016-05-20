<?php
// source: /Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/blocks/snippet_cache5612.latte

class Template4c7c38c14a5fb6fcb264f1a12fc50ef3 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('037299d3bb', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products/word.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_var.php";

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/snippets/snippet73/snippet.php";
$nadpis = 'Cestovní pojištění';
$text = 'Úrazy, nemoci, krádeže a způsobení škody, to jsou nejčastější rizika, kterým se turisté v zahraničí vystavují. Efektivní ochranu přitom zajistí pouze komerční cestovní pojištění, které můžete online získat za až nečekaně výhodných podmínek.';
$polozky = array('1387' => (object) array('text' => 'Pojištění léčebných výloh s vysokými limity za pár korun na den', ), '1388' => (object) array('text' => '<strong>Celoroční cestovní pojištění</strong> pro celou rodinu', ), '1389' => (object) array('text' => 'Zvolte si z různých limitů i rozsahu krytí, které nejlépe vyhovují stylu vašeho cestování', ), '1390' => (object) array('text' => 'Pojistěte se i na poslední chvíli díky online formuláři', ), '1391' => (object) array('text' => 'Zjistěte, která pojišťovna vám může nabídnout nejlepší cenu a ideální rozsah pojištění', ), );
$ikona = 'fa fa-suitcase'
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