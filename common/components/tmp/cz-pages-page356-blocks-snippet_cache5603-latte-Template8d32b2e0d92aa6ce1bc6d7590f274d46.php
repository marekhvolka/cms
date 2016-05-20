<?php
// source: /Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/blocks/snippet_cache5603.latte

class Template8d32b2e0d92aa6ce1bc6d7590f274d46 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('da8c42b075', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products/word.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_var.php";

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/snippets/snippet76/snippet.php";
$bg_image = '/portal/hyperfinance.cz/images/urazove-subcategory-box.jpg';
$button_url = 'urazove-pojisteni/';
$button_text = 'Spočítat';
$nadpis = 'Úrazové pojištění';
$vyhody = array('1365' => (object) array('text' => 'Možnost nastavit si variant pojištění', ), );
$podnadpis = 'Chraňte svůj příjem'
?>
<div class="subcategory-box subcategories-poster" <?php if (!empty($bg_image)) { ?>
 style="background-image: url(<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($bg_image), ENT_COMPAT) ?>
)"<?php } ?>>
  <h2><?php echo Latte\Runtime\Filters::escapeHtml($nadpis, ENT_NOQUOTES) ?></h2>
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($podnadpis, ENT_NOQUOTES) ?></h3>
  <ul>
<?php $iterations = 0; foreach ($vyhody as $vyhoda) { ?>
    <li>
      <?php echo Latte\Runtime\Filters::escapeHtml($vyhoda->text, ENT_NOQUOTES) ?>

     </li>
<?php $iterations++; } ?>
  </ul>
  <a class="btn main-btn" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($button_url), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($button_text, ENT_NOQUOTES) ?></a>
</div><?php
}}