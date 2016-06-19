<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/blocks/block_cache27705.latte

class Templatedae8ab554ac097e7491215bf5943f00a extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5f4aacd849', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_var.php"
?>
<h1>Pôžička Provident</h1><h3>Rýchla pôžička online od Providentu</h3><p>Pôžička Provident je vhodným riešením pre tých, ktorí potrebujú rýchlo zíkať financie. Úver môžete čerpať už od <?php echo Latte\Runtime\Filters::escapeHtml($product->dolna_hranica_pozicky, ENT_NOQUOTES) ?>
 € do <?php echo Latte\Runtime\Filters::escapeHtml($product->horna_hranica_pozicky, ENT_NOQUOTES) ?>
 €. Pôžička od Providentu je férová a neskrýva sa za žiadne poplatky. Vždy viete koľko zaplatíte. V spoločnosti Provident nepotrebujete preukázať účel poskytnutých finančných prostriedkov a dokonca ani ručiteľa. Pôžičku od Providentu na čokoľvek získate jednoducho - online prostredníctvom vyplnenia formuláru. </p><?php
}}