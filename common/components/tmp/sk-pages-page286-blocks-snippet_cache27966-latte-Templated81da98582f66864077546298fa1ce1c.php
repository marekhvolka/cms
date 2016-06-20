<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/blocks/snippet_cache27966.latte

class Templated81da98582f66864077546298fa1ce1c extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('1f893a6ad5', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet26/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->button_text = '' . $slovnik->chcem_si_pozicat . '';
$snippet->button_url = '' . $slovnik->ziadost_url . '/';
/* Var values  */
$snippet->button_text = '' . $slovnik->chcem_si_pozicat . '';
$snippet->button_url = '' . $slovnik->ziadost_url . '/';

}}