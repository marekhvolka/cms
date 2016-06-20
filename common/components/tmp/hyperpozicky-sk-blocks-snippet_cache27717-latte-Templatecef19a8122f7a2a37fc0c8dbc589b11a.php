<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/blocks/snippet_cache27717.latte

class Templatecef19a8122f7a2a37fc0c8dbc589b11a extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('2b9f177ad6', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet51/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->portal_name = 'HyperPôžičky.sk'
?>
<div id="copyright-panel">
	<p>© <?php echo date("Y") ?> <a href='/'><?php echo Latte\Runtime\Filters::escapeHtml($snippet->portal_name, ENT_NOQUOTES) ?>
</a> <?php echo Latte\Runtime\Filters::escapeHtml($slovnik->vsetky_prava_vyhradene, ENT_NOQUOTES) ?></p>
  
</div><?php
}}