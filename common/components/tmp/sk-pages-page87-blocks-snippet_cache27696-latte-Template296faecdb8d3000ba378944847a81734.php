<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/blocks/snippet_cache27696.latte

class Template296faecdb8d3000ba378944847a81734 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('068dca7847', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet30/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->nadpis = '' . $slovnik->ako_postupovat . '';
$snippet->kroky = '';
/* Var values  */
$snippet->nadpis = 'Postup pri žiadosti o pôžičku';
$snippet->kroky =  array(
'0' => (object) array(
'text' => 'Vyplňte online formulár a požiadajte o pôžičku.',), 
'1' => (object) array(
'text' => 'Budete kontaktovaný obchodným zástupcom spoločnosti.',), 
'2' => (object) array(
'text' => 'Po podpise zmluvy získate peniaze v hotovosti alebo na účet.',), 
)
?>
<div class="kroky kroky-number-with-dot">
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h3>
  <ol>
<?php $iterations = 0; foreach ($snippet->kroky as $krok) { ?>
    <li><?php echo Latte\Runtime\Filters::escapeHtml($krok->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
  </ol>
</div><?php
}}