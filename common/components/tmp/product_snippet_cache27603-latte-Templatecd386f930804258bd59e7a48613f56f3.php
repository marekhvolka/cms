<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/ceska_sporitelna_konsolidace_pujcek/product_snippet_cache27603.latte

class Templatecd386f930804258bd59e7a48613f56f3 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('d447da016d', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet32/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->tabulka_splatok . '';
$snippet->platnost = '*Uvedené hodnoty jsou čerpány z oficiální stránky poskytovatele k datu 21. 12. 2015.';
$snippet->priklady =  array(
'0' => (object) array(
'ponuka' => 'Aktuální výše závazku', 'vyska' => '180 000 Kč', 'pocet_splatok' => '84', 'splatka' => '4 000 Kč', 'urok' => '', 'poplatok' => '', 'rpmn' => '', 'celkom' => '336 143 Kč', 'celkova_uspora' => '', 'splatnost' => '',), 
'1' => (object) array(
'ponuka' => 'Nová nabídka', 'vyska' => '180 000 Kč', 'pocet_splatok' => '84', 'splatka' => '3 445 Kč', 'urok' => '14,6 %', 'poplatok' => '', 'rpmn' => '16,25 % ', 'celkom' => '291 140 Kč ', 'celkova_uspora' => '45 003 Kč', 'splatnost' => '',), 
);
$snippet->ponuka_label = '' . $slovnik->ponuka . '';
$snippet->vyska_label = '' . $slovnik->vyska_pozicky . '';
$snippet->pocet_splatok_label = '' . $slovnik->pocet_splatok . '';
$snippet->splatka_label = '' . $slovnik->mesacna_splatka . '';
$snippet->urok_label = '' . $slovnik->rocny_urok . '';
$snippet->poplatok_label = '' . $slovnik->poplatok_za_vybavenie . '';
$snippet->rpmn_label = '' . $slovnik->rpmn . '';
$snippet->celkom_label = '' . $slovnik->celkova_ciastka_na_zaplatenie . '';
$snippet->celkova_uspora_label = '' . $slovnik->celkova_uspora . '';
$snippet->splatnost_label = '' . $slovnik->datum_splatnosti . ''
?>
<div class="table-container table-responsive" id="tabulka">
  <h2><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h2>
  <table class="table table-striped">
    <thead>
      <tr class="bg-primary">
        <th><?php echo Latte\Runtime\Filters::escapeHtml($snippet->ponuka_label, ENT_NOQUOTES) ?></th>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
        	<th><?php echo Latte\Runtime\Filters::escapeHtml($priklad->ponuka, ENT_NOQUOTES) ?></th>
<?php $iterations++; } ?>
      </tr>
    </thead>
    <tr>
      <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->vyska_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
      <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->vyska, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
    </tr>
    <tr>
      <?php if (!empty($snippet->priklady[0]->pocet_splatok)) : ?>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->pocet_splatok_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
          <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->pocet_splatok, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      <?php endif ?>
    </tr>
    <tr>
      <?php if (!empty($snippet->priklady[0]->splatka)) : ?>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->splatka_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
          <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->splatka, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      <?php endif ?>
    </tr>
    <tr>
      <?php if (!empty($snippet->priklady[0]->urok)) : ?>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->urok_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
          <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->urok, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      <?php endif ?>
    </tr>
    <tr>
      <?php if (!empty($snippet->priklady[0]->poplatok)) : ?>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->poplatok_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
          <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->poplatok, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      <?php endif ?>
    </tr>
    <tr>
      <?php if (!empty($snippet->priklady[0]->rpmn)) : ?>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->rpmn_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
          <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->rpmn, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      <?php endif ?>
    </tr>
    <tr>
      <?php if (!empty($snippet->priklady[0]->celkom)) : ?>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->celkom_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->celkom, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      <?php endif ?>
    </tr>
    <tr>
      <?php if (!empty($snippet->priklady[0]->celkova_uspora)) : ?>
      <td class="bg-success"><b><?php echo Latte\Runtime\Filters::escapeHtml($snippet->celkova_uspora_label, ENT_NOQUOTES) ?></b></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
      <td class="bg-success"><b><?php echo Latte\Runtime\Filters::escapeHtml($priklad->celkova_uspora, ENT_NOQUOTES) ?></b></td>
<?php $iterations++; } ?>
      <?php endif ?>
    </tr>
    <tr>
      <?php if (!empty($snippet->priklady[0]->splatnost)) : ?>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($snippet->splatnost_label, ENT_NOQUOTES) ?></td>
<?php $iterations = 0; foreach ($snippet->priklady as $priklad) { ?>
          <td><?php echo Latte\Runtime\Filters::escapeHtml($priklad->splatnost, ENT_NOQUOTES) ?></td>
<?php $iterations++; } ?>
      <?php endif ?>
    </tr>
  </table>
  <p class="table-info"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->platnost, ENT_NOQUOTES) ?></p>
  <div class="clearfix"></div>
</div><?php
}}