<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/blocks/snippet_cache27972.latte

class Template4e3b3b305d5e804188f8a35c16a76991 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('c2e349203c', 'html')
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
$snippet->text = 'Potreboval som iba menšiu sumu na letnú dovolenku. Nemám rád behanie po pobočkách a typickú reč bánk, tak som sa obrátil na ZUNO, kde mi okamžite vyšli v ústrety. Všetko prebehlo hladko a jednoducho, založil som si u nich účet a tak ďalšia prípadná pôžička prebehne ešte rýchlejšie.';
$snippet->meno_klienta = 'Peter, 28 rokov';
$snippet->datum = '10. 4. 2015';
$snippet->button_text = '' . $slovnik->chcem_si_pozicat . '';
$snippet->button_url = '' . $portal->ziadost_url . '/';
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