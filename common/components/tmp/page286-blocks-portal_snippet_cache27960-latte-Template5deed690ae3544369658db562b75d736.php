<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/blocks/portal_snippet_cache27960.latte

class Template5deed690ae3544369658db562b75d736 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('9b9194f820', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet21/snippet.php";
/* Snippet values */
/* Product type default var values  */
/* Portal/Product var values  */
$snippet->nadpis = 'Sme aj na Facebooku';
$snippet->url = '0';
/* Var values  */
?>
<div class="fb-like-box-container">
	<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->url), ENT_COMPAT) ?>&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=false"
		scrolling="no" frameborder="0" 
		style="border:none; overflow:hidden; height:290px;width:100%" 
		allowTransparency="true">
  </iframe>
</div><?php
}}