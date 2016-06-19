<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/home_credit_spojenie_sk/product_snippet_cache27300.latte

class Template4635f8b3d1642d9d35d50266a08dece8 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('056abc7ba1', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet32/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = 'Tabuľka splátok pri spojení pôžičiek v Home Credit';
$snippet->platnost = '* Uvedené hodnoty sú platné k dátumu 24. 4. 2015.';
$snippet->priklady =  array(
'0' => (object) array(
'ponuka' => '', 'vyska' => '1 000,00 €', 'splatka' => '24,32 €', 'urok' => '16,05 %', 'rpmn' => '17,40 %', 'poplatok' => '0 €', 'pocet_splatok' => '60', 'celkom' => '1 459,20 €', 'celkova_uspora' => '', 'splatnost' => '24. 4. 2020',), 
'1' => (object) array(
'ponuka' => '', 'vyska' => '3 500,00 €', 'splatka' => '85,11 €', 'urok' => '16,05 %', 'rpmn' => '17,40 %', 'poplatok' => '0 €', 'pocet_splatok' => '60', 'celkom' => '5 106,60 €', 'celkova_uspora' => '', 'splatnost' => '24. 4. 2020',), 
'2' => (object) array(
'ponuka' => '', 'vyska' => '6 000,00 €', 'splatka' => '100,84 €', 'urok' => '13,01 %', 'rpmn' => '13,90 %', 'poplatok' => '0 €', 'pocet_splatok' => '96', 'celkom' => '9 680,64 €', 'celkova_uspora' => '', 'splatnost' => '24. 4. 2023',), 
);
$snippet->rpmn_label = '' . $slovnik->rpmn . '';
$snippet->vyska_label = '' . $slovnik->vyska_pozicky . '';
$snippet->splatnost_label = '' . $slovnik->datum_splatnosti . '';
$snippet->urok_label = '' . $slovnik->rocny_urok . '';
$snippet->celkom_label = '' . $slovnik->celkova_ciastka_na_zaplatenie . '';
$snippet->pocet_splatok_label = '' . $slovnik->pocet_splatok . '';
$snippet->splatka_label = '' . $slovnik->mesacna_splatka . '';
$snippet->poplatok_label = '' . $slovnik->poplatok_za_vybavenie . '';
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