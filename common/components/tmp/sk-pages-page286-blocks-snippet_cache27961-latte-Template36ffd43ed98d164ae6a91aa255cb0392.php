<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/blocks/snippet_cache27961.latte

class Template36ffd43ed98d164ae6a91aa255cb0392 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('07d2fa226c', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet22/snippet.php";
/* Snippet values */
/* Product type default var values  */
/* Var values  */
?>
<style scoped>
	.breadcrumbs ul li:after
  {
    content: <?php echo Latte\Runtime\Filters::escapeCss($snippet->icon) ?>;
  }
  .breadcrumbs ul li:nth-last-child(1):after
  {
    content: '';
  }
</style><?php
}}