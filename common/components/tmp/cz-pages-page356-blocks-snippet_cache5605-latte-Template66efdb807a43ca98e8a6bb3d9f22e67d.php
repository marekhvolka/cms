<?php
// source: /Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/blocks/snippet_cache5605.latte

class Template66efdb807a43ca98e8a6bb3d9f22e67d extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('90d239b857', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products/word.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_var.php";

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/snippets/snippet33/snippet.php";
$button_text = 'Porovnat nabídky';
$button_url = 'vozidla/srovnani/';
$typ_produktu = 'none';
$text = '';
$max_pocet = ''
?>
<div class="cta-box cta-box-with-note-<?php echo Latte\Runtime\Filters::escapeHtml($lang, ENT_COMPAT) ?>
-<?php echo Latte\Runtime\Filters::escapeHtml($typ_produktu, ENT_COMPAT) ?>">
  <a class="btn main-btn btn-lg" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($button_url), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($button_text, ENT_NOQUOTES) ?></a>
</div><?php
}}