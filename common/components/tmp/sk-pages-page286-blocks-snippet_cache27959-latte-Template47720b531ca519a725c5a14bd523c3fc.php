<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/blocks/snippet_cache27959.latte

class Template47720b531ca519a725c5a14bd523c3fc extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('e2c190d1dd', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet27/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->nadpis = '' . $slovnik->co_hovoria_spokojni_klienti . '';
$snippet->text = '';
$snippet->meno_klienta = '';
$snippet->datum = '';
$snippet->button_text = '' . $slovnik->chcem_si_pozicat . '';
$snippet->button_url = '' . $portal->ziadost_url . '/';
$snippet->text_align = '';
/* Var values  */
$snippet->nadpis = '' . $slovnik->co_hovoria_spokojni_klienti . '';
$snippet->text = 'Spontánne som sa rozhodla navštíviť moju staršiu sestru v Austrálii, no letenky boli príliš drahé, zvlášť v tak krátku dobu pred odletom. No v ZUNO som našla to, čo som hľadala – moderný online spôsob získania pôžičky na čokoľvek a otvorený ľudský prístup. Nastavila som si splátky tak, ako mi vyhovujú a o dva týždne už letím.';
$snippet->meno_klienta = 'Kristina, 25 rokov';
$snippet->datum = '12. 3. 2015';
$snippet->button_text = '' . $slovnik->chcem_si_pozicat . '';
$snippet->button_url = '' . $portal->ziadost_url . '/';
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