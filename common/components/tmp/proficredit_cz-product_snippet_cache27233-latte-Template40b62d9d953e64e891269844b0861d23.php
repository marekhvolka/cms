<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/proficredit_cz/product_snippet_cache27233.latte

class Template40b62d9d953e64e891269844b0861d23 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('490a0cb6f6', 'html')
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
'text' => 'Registrace a vyplnění on-line žádosti o úvěr.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Vyčkání na kontakt obchodním zástupcem společnosti.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'Schůzka s obchodním zástupcem a sepsání žádosti o úvěrovou smlouvu.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'3' => (object) array(
'text' => 'Dodání potřebných dokladů, které budou odeslány na centrálu ke schvalovacímu procesu.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'4' => (object) array(
'text' => 'Podepsání úvěrové smlouvy s obchodním zástupcem.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'5' => (object) array(
'text' => 'Výplata schválených finančních prostředků.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
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