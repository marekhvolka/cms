<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/blocks/snippet_cache27710.latte

class Template8fac345152640b8e44504c9a3e302aea extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('f308e9e914', 'html')
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
$snippet->text = 'Spoločnosť Provident mi pomohla práve vtedy, keď som peniaze potrebovala naozaj rýchlo. A môžem povedať, že po návšteve obchodného zástupcu a podpísaní zmluvy som ich už na druhý deň naozaj držala v rukách. A to dokonca cez víkend. Výborné riešenie pre nečakané situácie, kedy človek potrebuje peniaze rýchlo a jednoducho. ';
$snippet->meno_klienta = 'Jana, 52 rokov';
$snippet->datum = '10. 1. 2015';
$snippet->button_text = '' . $slovnik->porovnat_pozicky . '';
$snippet->button_url = '' . $portal->pozicky_porovnavac->url . '#comparator';
$snippet->text_align = 'center'
?>
<div class="klient-classic" id="zkusenosti">
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h3>
  <p>
    "<?php echo Latte\Runtime\Filters::escapeHtml($snippet->text, ENT_NOQUOTES) ?>"
  </p>
  <div class="klient-bio">
    <div class="icon icon-middle">
      <i class="fa fa-user"></i>   
    </div>  
    <p><strong class="meno"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->meno_klienta, ENT_NOQUOTES) ?></strong></p>
    <div class="rating">
      <span class="glyphicon glyphicon-star"></span>
      <span class="glyphicon glyphicon-star"></span>
      <span class="glyphicon glyphicon-star"></span>
      <span class="glyphicon glyphicon-star"></span>
      <span class="glyphicon glyphicon-star"></span>
      <p><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->hodnotenie, ENT_NOQUOTES) ?>: 5/5</p>
    </div>
    <div class="clearfix"></div>
  </div>
  <a class="btn btn-medium main-btn" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->button_url), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->button_text, ENT_NOQUOTES) ?></a> 
  <div class="clearfix"></div>
</div>                      
<!-- /klienti --><?php
}}