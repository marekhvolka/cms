<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/blocks/snippet_cache27699.latte

class Template214e1626e3c155088d68fcfad602b483 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('783d9e5534', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_var.php";

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