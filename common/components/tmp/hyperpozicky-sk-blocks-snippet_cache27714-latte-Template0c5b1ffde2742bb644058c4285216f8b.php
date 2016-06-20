<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/blocks/snippet_cache27714.latte

class Template0c5b1ffde2742bb644058c4285216f8b extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('65e7f5fc8f', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet84/snippet.php";
/* Snippet values */
/* Var values  */
?>
<div class="social-btns">
  <div class="share-icons">
    <a class="facebook-icon" href="#" 
            onclick="
              window.open(
              'https://www.facebook.com/sharer/sharer.php?u=<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeJs($snippet->url), ENT_COMPAT) ?>', 
              'facebook-share-dialog', 
              'width=626,height=436'); 
            return false;"><i class="fa fa-facebook"></i>
          </a>
    <a class="g-icon" href="https://plus.google.com/share?url=<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->url), ENT_COMPAT) ?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i></a>
    <a href="#" class="twitter-icon" data-lang="sk" onclick="
    window.open(
      'https://twitter.com/share?url=<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeJs($snippet->url), ENT_COMPAT) ?>',
      'width:400',
      'height:200');
    return false;"><i class="fa fa-twitter"></i>
    </a>
  </div>
</div><?php
}}