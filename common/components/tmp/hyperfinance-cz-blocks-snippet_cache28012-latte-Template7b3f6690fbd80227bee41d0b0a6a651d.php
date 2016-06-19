<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/blocks/snippet_cache28012.latte

class Template7b3f6690fbd80227bee41d0b0a6a651d extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('d0d880988c', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet51/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->portal_name = 'HyperFinance.cz'
?>
<div id="copyright-panel">
	<p>© <?php echo date("Y") ?> <a href='/'><?php echo Latte\Runtime\Filters::escapeHtml($snippet->portal_name, ENT_NOQUOTES) ?>
</a> <?php echo Latte\Runtime\Filters::escapeHtml($slovnik->vsetky_prava_vyhradene, ENT_NOQUOTES) ?></p>
  
</div><?php
}}