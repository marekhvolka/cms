<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/postova_banka_pozicka/product_snippet_cache27535.latte

class Template7f1018ea78e810b95267992d31e795a7 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('d90f5ce49e', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet30/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = 'Postup pri žiadaní o pôžičku online';
$snippet->kroky =  array(
'0' => (object) array(
'text' => 'Otvoriť webovú stránku banky a kliknúť na záložku Úvery a pôžičky.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'1' => (object) array(
'text' => 'Na priloženej kalkulačke nastaviť výšku pôžičky, dobu jej splatenia a podmienky poistenia.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'2' => (object) array(
'text' => 'Vyplniť svoje identifikačné údaje a odoslať formulár.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
'3' => (object) array(
'text' => 'Očakávať spätný kontakt z banky.', 'popis' => '', 'icon' => '', 'obrazok' => '',), 
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