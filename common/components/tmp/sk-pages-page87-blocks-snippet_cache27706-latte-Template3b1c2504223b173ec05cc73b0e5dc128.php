<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/blocks/snippet_cache27706.latte

class Template3b1c2504223b173ec05cc73b0e5dc128 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('ded2e6f266', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet33/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->button_text = '' . $slovnik->porovnat_pozicky . '';
$snippet->button_url = '' . $portal->pozicky_porovnavac->url . '#comparator';
$snippet->typ_produktu = 'porovnanie';
$snippet->text = 'si ' . $slovnik->porovnal . 'o ' . $slovnik->pozicky_1 . '';
$snippet->max_pocet = '60';
/* Var values  */
$snippet->button_text = '' . $slovnik->porovnat_pozicky . '';
$snippet->button_url = '' . $portal->pozicky_porovnavac->url . '#comparator';
$snippet->typ_produktu = 'porovnanie';
$snippet->text = 'si ' . $slovnik->porovnal . 'o ' . $slovnik->pozicky_1 . ''
?>
<div class="cta-box cta-box-with-note-<?php echo Latte\Runtime\Filters::escapeHtml($portal->lang, ENT_COMPAT) ?>
-<?php echo Latte\Runtime\Filters::escapeHtml($snippet->typ_produktu, ENT_COMPAT) ?>">
  <h4><span>Dnes <?php echo Latte\Runtime\Filters::escapeHtml($snippet->text, ENT_NOQUOTES) ?>
 <?php echo Latte\Runtime\Filters::escapeHtml($slovnik->uz, ENT_NOQUOTES) ?> <span style="display:inline;" class="_applicant_count">87</span> <?php echo Latte\Runtime\Filters::escapeHtml($slovnik->klientov, ENT_NOQUOTES) ?>.</span>
    <?php echo Latte\Runtime\Filters::escapeHtml($slovnik->nevahajte_a_pridajte_sa_k_nim_aj_vy, ENT_NOQUOTES) ?></h4>
  <a class="btn main-btn btn-lg" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->button_url), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->button_text, ENT_NOQUOTES) ?></a>
</div>
<script>
  getApplicantCount('_applicant_count', '1', <?php echo Latte\Runtime\Filters::escapeJs($snippet->max_pocet) ?>, '6', '22');
</script><?php
}}