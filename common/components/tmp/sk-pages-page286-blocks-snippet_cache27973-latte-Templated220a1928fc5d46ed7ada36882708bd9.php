<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/blocks/snippet_cache27973.latte

class Templated220a1928fc5d46ed7ada36882708bd9 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('1100a9f76d', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet94/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->nadpis = 'O ' . $slovnik->spolocnosti . ' ' . $product->nazov_spolocnosti . '';
$snippet->text = '';
$snippet->podstranka_viac = '';
/* Var values  */
$snippet->nadpis = 'O ' . $slovnik->spolocnosti . ' ' . $product->nazov_spolocnosti . '';
$snippet->text = 'Za pomerne novou bankou ZUNO stojí silná a stabilná medzinárodná skupina Raiffeisen Bank International. Tá má korene v rakúskej skupine Raiffeisen so 125 ročnými skúsenosťami. Svoje služby poskytuje viac ako 14,2 miliónom klientom v 3 100 pobočkách. Má zastúpenie v 17 krajinách strednej a východnej Európy a je jednou z vedúcich bankových skupín v regióne.';
$snippet->podstranka_viac = $portal->pages->page585
?>
<div class="">
  <h2><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h2>
  <img src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($product->logo_medium), ENT_COMPAT) ?>
" class="inline-image" title="<?php echo Latte\Runtime\Filters::escapeHtml($product->nazov_spolocnosti, ENT_COMPAT) ?>
" alt="<?php echo Latte\Runtime\Filters::escapeHtml($product->nazov_spolocnosti, ENT_COMPAT) ?>">
  <p>
    <?php echo Latte\Runtime\Filters::escapeHtml($snippet->text, ENT_NOQUOTES) ?>

  </p>
<?php if (!empty($snippet->podstranka_viac)) { ?>
  	<a href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->podstranka_viac->url), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->viac_informacii, ENT_NOQUOTES) ?></a>
<?php } ?>
</div><?php
}}