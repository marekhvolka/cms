<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/snippets/portal_snippet_cache28018.latte

class Template8a922be39ce84aaa0040e9c147390350 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('e2fe20a5de', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet21/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = 'Sme aj na Facebooku';
$snippet->url = '0'
?>
<div class="fb-like-box-container">
	<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->url), ENT_COMPAT) ?>&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=false"
		scrolling="no" frameborder="0" 
		style="border:none; overflow:hidden; height:290px;width:100%" 
		allowTransparency="true">
  </iframe>
</div><?php
}}