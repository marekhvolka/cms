<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/unicredit_prevedenie_sk/product_snippet_cache27302.latte

class Template72cc6cec3d027deed85ac9e619f82fbd extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('e55abcf1e7', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet32/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = 'Tabuľka splátok pri prevedení pôžičky do UniCredit Bank';
$snippet->platnost = '* Uvedené hodnoty sú platné k dátumu 24. 4. 2015. Tento výpočet slúži len na informačné účely a nepredstavuje návrh na uzatvorenie zmluvy.';
$snippet->priklady =  array(
'0' => (object) array(
'ponuka' => 'Pôvodná', 'vyska' => '1 106,00 €', 'splatka' => '25,00 €', 'urok' => '-', 'rpmn' => '-', 'poplatok' => '0 €', 'pocet_splatok' => '53', 'celkom' => '1 475,00 €', 'celkova_uspora' => '-', 'splatnost' => '24. 3. 2020',), 
'1' => (object) array(
'ponuka' => 'Od UniCredit Bank', 'vyska' => '1 106,00 €', 'splatka' => '20.64 €', 'urok' => '3.90 %', 'rpmn' => '9.05 %', 'poplatok' => '0 €', 'pocet_splatok' => '53', 'celkom' => '1 218,00 €', 'celkova_uspora' => '257 €', 'splatnost' => '24. 3. 2020',), 
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