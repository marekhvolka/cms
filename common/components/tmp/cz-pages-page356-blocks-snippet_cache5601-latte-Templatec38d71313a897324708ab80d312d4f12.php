<?php
// source: /Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/blocks/snippet_cache5601.latte

class Templatec38d71313a897324708ab80d312d4f12 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('d3bc0db541', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products/word.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_var.php";

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/snippets/snippet76/snippet.php";
$nadpis = 'Havarijní pojištění';
$podnadpis = 'Už od 1 356 Kč za rok';
$vyhody = array('1362' => (object) array('text' => 'Výhodné připojištění př. skla', ), '1363' => (object) array('text' => 'Porovnání i uzavření online', ), );
$bg_image = '/portal/hyperfinance.cz/images/havarijni-subcategory-box.jpg';
$button_url = 'havarijni-pojisteni-srovnani/';
$button_text = 'Srovnat nabídky'
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