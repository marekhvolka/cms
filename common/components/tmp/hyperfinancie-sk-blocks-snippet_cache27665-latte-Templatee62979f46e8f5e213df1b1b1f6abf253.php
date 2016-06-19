<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/blocks/snippet_cache27665.latte

class Templatee62979f46e8f5e213df1b1b1f6abf253 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('2dab5aa0bb', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet51/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->portal_name = 'HyperFinancie.sk'
?>
<div id="copyright-panel">
	<p>© <?php echo date("Y") ?> <a href='/'><?php echo Latte\Runtime\Filters::escapeHtml($snippet->portal_name, ENT_NOQUOTES) ?>
</a> <?php echo Latte\Runtime\Filters::escapeHtml($slovnik->vsetky_prava_vyhradene, ENT_NOQUOTES) ?></p>
  
</div><?php
}}