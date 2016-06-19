<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/blocks/snippet_cache28015.latte

class Template20a50a19f154fbfb38992913aef55ee3 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('0f2049a789', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet18/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->telefonne_cislo = '800 115 555';
$snippet->logo_url = '/portal/hyperfinance.cz/images/logo.png';
$snippet->phone_icon = 'fa-phone';
$snippet->alt = 'HyperFinance.cz'
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