<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/blocks/snippet_cache27704.latte

class Template164ab3f1a7d0cf78d06a93c9e21ed83d extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('1560f8d530', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet26/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->button_text = '' . $slovnik->porovnat_pozicky . '';
$snippet->button_url = '../' . $slovnik->porovnanie_poziciek_url . '/';
/* Var values  */
$snippet->button_text = '' . $slovnik->porovnat_pozicky . '';
$snippet->button_url = '../' . $slovnik->porovnanie_poziciek_url . '/';

}}