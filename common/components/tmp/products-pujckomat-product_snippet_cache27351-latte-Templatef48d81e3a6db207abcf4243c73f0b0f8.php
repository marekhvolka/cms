<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/pujckomat/product_snippet_cache27351.latte

class Templatef48d81e3a6db207abcf4243c73f0b0f8 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('bca5a689d0', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet32/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->tabulka_splatok . '';
$snippet->platnost = '*Uvedené údaje jsou čerpány z oficiální stránky partnera ke dni 7. 7. 2015.';
$snippet->priklady =  array(
'0' => (object) array(
'ponuka' => '', 'vyska' => '2 000 Kč', 'pocet_splatok' => '1', 'splatka' => '31', 'rpmn' => '1 537.4 %', 'urok' => '-', 'poplatok' => '536 Kč', 'celkom' => '2 536 Kč', 'celkova_uspora' => '', 'splatnost' => '7. 8. 2015',), 
'1' => (object) array(
'ponuka' => '', 'vyska' => '6 000 Kč', 'pocet_splatok' => '1', 'splatka' => '20', 'rpmn' => '3 959.6 %', 'urok' => '-', 'poplatok' => '1 350 Kč', 'celkom' => '7 350 Kč', 'celkova_uspora' => '', 'splatnost' => '27. 7. 2015',), 
'2' => (object) array(
'ponuka' => '', 'vyska' => '10 000 Kč', 'pocet_splatok' => '1', 'splatka' => '10', 'rpmn' => '16 323.7 %', 'urok' => '-', 'poplatok' => '1 500 kč', 'celkom' => '11 500 kč', 'celkova_uspora' => '', 'splatnost' => '17. 7. 2015',), 
);
$snippet->vyska_label = '' . $slovnik->vyska_pozicky . '';
$snippet->pocet_splatok_label = '' . $slovnik->pocet_splatok . '';
$snippet->splatka_label = 'Počet dní splácení';
$snippet->rpmn_label = '' . $slovnik->rpmn . '';
$snippet->urok_label = '' . $slovnik->rocny_urok . '';
$snippet->poplatok_label = '' . $slovnik->poplatok_za_vybavenie . '';
$snippet->celkom_label = '' . $slovnik->celkova_ciastka_na_zaplatenie . '';
$snippet->splatnost_label = '' . $slovnik->datum_splatnosti . '';
$snippet->ponuka_label = '' . $slovnik->ponuka . '';
$snippet->celkova_uspora_label = '' . $slovnik->celkova_uspora . ''
?>
<div class="table-container table-responsive" id="tabulka">
  <h2><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h2>
  <table class="table table-striped">
    <thead>
      <tr class="bg-primary">
        <th><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->vyska_pozicky, ENT_NOQUOTES) ?></th>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
        	<th><?php echo Latte\Runtime\Filters::escapeHtml($priklad->vyska, ENT_NOQUOTES) ?></th>
<?php $iterations++; } ?>
      </tr>
    </thead>
    <?php if (!empty($snippet->priklady[0]->pocet_splatok)) : ?>
      <tr>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->pocet_splatok_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
          <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->pocet_splatok, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      </tr>
    <?php endif ?>
    <?php if (!empty($snippet->priklady[0]->splatka)) : ?>
      <tr>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->splatka_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
          <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->splatka, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      </tr>
    <?php endif ?>
    <?php if (!empty($snippet->priklady[0]->urok)) : ?>
      <tr>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->urok_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
          <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->urok, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      </tr>
    <?php endif ?>
    <?php if (!empty($snippet->priklady[0]->poplatok)) : ?>
      <tr>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->poplatok_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
          <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->poplatok, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      </tr>
    <?php endif ?>
    <?php if (!empty($snippet->priklady[0]->rpmn)) : ?>
      <tr>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->rpmn_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
          <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->rpmn, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      </tr>
    <?php endif ?>
    <?php if (!empty($snippet->priklady[0]->celkom)) : ?>
      <tr>
        <td class="bg-success"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->celkom_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
        <td class="bg-success"><?php echo Latte\Runtime\Filters::escapeHtml($priklad->celkom, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      </tr>
    <?php endif ?>
    <?php if (!empty($snippet->priklady[0]->splatnost)) : ?>
      <tr>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->splatnost_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
          <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->splatnost, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      </tr>
    <?php endif ?>
  </table>
  <p class="table-info"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->platnost, ENT_NOQUOTES) ?></p>
  <div class="clearfix"></div>
</div><?php
}}