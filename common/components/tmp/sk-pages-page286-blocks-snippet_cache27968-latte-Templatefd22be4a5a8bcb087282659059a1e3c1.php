<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/blocks/snippet_cache27968.latte

class Templatefd22be4a5a8bcb087282659059a1e3c1 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('e09f0fc2f2', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet33/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->button_text = '' . $slovnik->chcem_si_pozicat . '';
$snippet->button_url = '' . $portal->ziadost_url . '/';
/* Var values  */
$snippet->button_text = '' . $slovnik->chcem_si_pozicat . '';
$snippet->button_url = '' . $portal->ziadost_url . '/'
?>
<div class="cta-box cta-box-with-note-<?php echo Latte\Runtime\Filters::escapeHtml($portal->lang, ENT_COMPAT) ?>
-<?php echo Latte\Runtime\Filters::escapeHtml($snippet->typ_produktu, ENT_COMPAT) ?>">
  <a class="btn main-btn btn-lg" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->button_url), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->button_text, ENT_NOQUOTES) ?></a>
</div><?php
}}