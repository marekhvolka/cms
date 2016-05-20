<?php
// source: /Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/blocks/snippet_cache5602.latte

class Template965d4f3c47a3a45c4eb999b0f338f000 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('97591a3112', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products/word.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_var.php";

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/snippets/snippet76/snippet.php";
$bg_image = '/portal/hyperfinance.cz/images/cestovni-subcategory-box.jpg';
$button_url = 'cestovni-pojisteni/';
$button_text = 'Spočítat';
$nadpis = 'Cestovní pojištění';
$vyhody = array('1364' => (object) array('text' => 'Cestovní pojištění za 25 Kč na den', ), );
$podnadpis = 'Neplaťte zbytečně!'
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