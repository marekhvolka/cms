<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/zuno_pozicka/product_snippet_cache27469.latte

class Templatee3838d38e9bd8c285a912d97d8edd998 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('0693bfeac9', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet88/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->podmienky_a_doklady . '';
$snippet->polozky =  array(
'0' => (object) array(
'text' => 'žiadateľ vo veku  18  - 70 rokov (SZČO min 21 rokov), s pobytom na Slovensku',), 
'1' => (object) array(
'text' => 'existencia vlastného online účtu v ZUNO banke',), 
'2' => (object) array(
'text' => 'bez negatívnych zápisov v registroch',), 
'3' => (object) array(
'text' => 'zdroj trvalého príjmu',), 
)
?>
<div class="vyhody">
  <a id="vyhody"></a>
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h3>
  <ul class="vyhody vyhody-<?php echo Latte\Runtime\Filters::escapeHtml($snippet->pocet_stlpcov_listu, ENT_COMPAT) ?>">
<?php $iterations = 0; foreach ($snippet->polozky as $polozka) { ?>
    <li><?php echo Latte\Runtime\Filters::escapeHtml($polozka->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
  </ul>
  <div class="clearfix"></div>
</div><?php
}}