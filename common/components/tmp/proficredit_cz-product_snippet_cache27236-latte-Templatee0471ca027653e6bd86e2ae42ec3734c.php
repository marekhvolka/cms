<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/proficredit_cz/product_snippet_cache27236.latte

class Templatee0471ca027653e6bd86e2ae42ec3734c extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('fdf04849a6', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet30/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->ako_postupovat . '';
$snippet->kroky =  array(
'0' => (object) array(
'text' => 'Vyplňte online formulář.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Nastavte základní parametry půjčky.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'Vyčkejte až se vám ozve pracovník společnosti.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'3' => (object) array(
'text' => 'Po podepsání smlouvy vám jsou peníze odeslány do 48 hodin na bankovní účet.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
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