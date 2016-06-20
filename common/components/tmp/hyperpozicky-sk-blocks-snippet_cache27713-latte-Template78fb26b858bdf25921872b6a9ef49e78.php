<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/blocks/snippet_cache27713.latte

class Template78fb26b858bdf25921872b6a9ef49e78 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('91b09a69d9', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet18/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->telefonne_cislo = '0800 333 009';
$snippet->logo_url = '/portal/hyperpozicky.sk/images/logo.png';
$snippet->phone_icon = 'fa-phone'
?>
<a href="/" class="logo" ><img src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->logo_url), ENT_COMPAT) ?>
" alt="<?php echo Latte\Runtime\Filters::escapeHtml($snippet->alt, ENT_COMPAT) ?>"></a>
<div class="top-info">
  <div class="top-telefon">
    <i class="fa <?php echo Latte\Runtime\Filters::escapeHtml($snippet->phone_icon, ENT_COMPAT) ?>"></i>
    <strong><?php echo Latte\Runtime\Filters::escapeHtml($snippet->telefonne_cislo, ENT_NOQUOTES) ?></strong>
  </div>
</div><?php
}}