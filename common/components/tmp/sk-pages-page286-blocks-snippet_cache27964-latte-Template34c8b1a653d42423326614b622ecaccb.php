<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/blocks/snippet_cache27964.latte

class Template34c8b1a653d42423326614b622ecaccb extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('7599157366', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet23/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->nadpis = '' . $product->akcia_headline . '';
$snippet->button_text = '' . $slovnik->chcem_vyuzit_akciu . '';
$snippet->link_url = '' . $slovnik->ziadost_url . '/';
$snippet->text = '' . $product->akcia_text . '';
$snippet->img_url = '';
$snippet->platnost = '';
/* Var values  */
$snippet->nadpis = '' . $product->akcia_headline . '';
$snippet->button_text = '' . $slovnik->chcem_vyuzit_akciu . '';
$snippet->link_url = '' . $slovnik->ziadost_url . '/';
$snippet->text = '' . $product->akcia_text . ''
?>
<div class="akcia akcia-without-image <?php echo Latte\Runtime\Filters::escapeHtml($snippet->bez_spoluprace_trieda, ENT_COMPAT) ?>">
  <a href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->link_url), ENT_COMPAT) ?>">
    <span class="akcia-badge"><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->akcia, ENT_NOQUOTES) ?></span>
    <div class="akcia-content">
      <h2><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h2>
      <div class="text">
        <?php echo Latte\Runtime\Filters::escapeHtml($snippet->text, ENT_NOQUOTES) ?>

      </div> 
    </div>
    <span class="btn main-btn btn-lg" ><?php echo Latte\Runtime\Filters::escapeHtml($snippet->button_text, ENT_NOQUOTES) ?></span>
  </a>
  <script>
    var dnes = Math.floor(Date.now() / 1000);
    if(<?php echo Latte\Runtime\Filters::escapeJs($product->platnost_akcie) ?> > dnes)
    {
      $(".akcia").parent().show();
    }
    else
    {
      var parent = $(".akcia").parent();

      if (parent.children().length > 1)
        $(".akcia").hide();
      else
        parent.hide();
    }
  </script>
</div><?php
}}