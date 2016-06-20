<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/blocks/snippet_cache27970.latte

class Templatefc677e433f6480e6b7f55cb5c44622cf extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('9e7ff458c0', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet29/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->nadpis = 'TIP';
$snippet->text = '';
/* Var values  */
$snippet->nadpis = 'TIP';
$snippet->text = 'Pri pôžičke od ZUNO si môžete vybrať 1 mesiac v roku, kedy nemusíte zaplatiť splátku za pôžičku.'
?>
<div class="tip">
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h3>
  <p>
    <?php echo Latte\Runtime\Filters::escapeHtml($snippet->text, ENT_NOQUOTES) ?>

  </p>
  <div class="clearfix"></div>
</div><?php
}}