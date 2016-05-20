<?php
// source: /Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/blocks/snippet_cache5606.latte

class Template8f197753cfd38b495a878f7ffddc02de extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('a21bab7f81', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products/word.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_var.php";

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/snippets/snippet73/snippet.php";
$nadpis = 'Havarijní pojištění';
$text = 'S <strong>havarijním pojištěním</strong> se nemusíte bát odcizení, poškození, ani zničení vozidla. Jde o přirozené rozšíření ochrany vašeho majetku, které nikdy nebylo levnější. S <strong>online sjednáním</strong> můžete navíc ušetřit ještě více a k tomu získat bezplatné porovnání produktů od různých pojišťoven.';
$polozky = array('1371' => (object) array('text' => 'Sjednejte spolu s povinným ručením a ušetřete si tak práci i peníze', ), '1372' => (object) array('text' => 'Internetové pojištění s porovnáním mnoha nabídek za nižší ceny, než na pobočce pojišťovny', ), '1373' => (object) array('text' => 'Proti běžným cenám s námi můžete ušetřit až několik tisíc ročně', ), '1374' => (object) array('text' => 'Velký výběr pojistných rizik, limitů i připojištění', ), '1375' => (object) array('text' => 'Pro sjednání havarijního pojištění si nemusíte zároveň sjednávat i povinné ručení', ), '1376' => (object) array('text' => 'Vyřešení celé žádosti můžete mít za pár minut hotové', ), );
$ikona = 'fa fa-ambulance'
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