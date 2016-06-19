<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/blocks/snippet_cache27708.latte

class Templatec146767193c5cc2c61ea468733a76d13 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('20846dd6f6', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet29/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->nadpis = 'TIP';
$snippet->text = '';
/* Var values  */
$snippet->nadpis = 'TIP';
$snippet->text = 'Potrebujete rýchlo peniaze? Provident vyrieši Váš problém v najkratšej možnej dobe. Vyplňte online žiadosť a skráťte tak čas vybavovania rovno o polovicu! '
?>
<div class="tip">
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h3>
  <p>
    <?php echo Latte\Runtime\Filters::escapeHtml($snippet->text, ENT_NOQUOTES) ?>

  </p>
  <div class="clearfix"></div>
</div><?php
}}