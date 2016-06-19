<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/blocks/snippet_cache27697.latte

class Templateef5710c666c67b8fb2a47ad73acaf3cd extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('a56e9f569f', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet27/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->nadpis = '' . $slovnik->co_hovoria_spokojni_klienti . '';
$snippet->text = '';
$snippet->meno_klienta = '';
$snippet->datum = '';
$snippet->button_text = '' . $slovnik->porovnat_pozicky . '';
$snippet->button_url = '' . $portal->pozicky_porovnavac->url . '#comparator';
$snippet->text_align = '';
/* Var values  */
$snippet->nadpis = '' . $slovnik->co_hovoria_spokojni_klienti . '';
$snippet->text = 'Keď sme rekonštruovali kúpeľňu a potrebovali sme rýchle peniaze na materiál a remeselníkov, kolega v práci mi poradil práve pôžičku od Provident. Skontaktoval som sa so sympatickým zástupcom, spísali sme na mieste zmluvu a na ďalší deň som mal potrebnú hotovosť. A to som ani nemusel opustiť dom. ';
$snippet->meno_klienta = 'Marián, 48 rokov';
$snippet->datum = '15. 12. 2014';
$snippet->button_text = '' . $slovnik->porovnat_pozicky . '';
$snippet->button_url = '' . $portal->pozicky_porovnavac->url . '#comparator';
$snippet->text_align = 'center'
?>
<div class="klient-classic">
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h3>
  <p>
    "<?php echo Latte\Runtime\Filters::escapeHtml($snippet->text, ENT_NOQUOTES) ?>"
  </p>
  <div class="klient-bio">
    <p><strong class="meno"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->meno_klienta, ENT_NOQUOTES) ?></strong></p>
    <div class="rating">
      <span class="glyphicon glyphicon-star"></span>
      <span class="glyphicon glyphicon-star"></span>
      <span class="glyphicon glyphicon-star"></span>
      <span class="glyphicon glyphicon-star"></span>
      <span class="glyphicon glyphicon-star"></span>
      <p><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->hodnotenie, ENT_NOQUOTES) ?>: 5/5</p>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
<!-- /klienti --><?php
}}