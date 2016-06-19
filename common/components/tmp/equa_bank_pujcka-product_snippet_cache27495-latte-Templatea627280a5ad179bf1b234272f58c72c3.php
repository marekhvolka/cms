<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products/equa_bank_pujcka/product_snippet_cache27495.latte

class Templatea627280a5ad179bf1b234272f58c72c3 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('318f2c96c0', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet32/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->tabulka_splatok . '';
$snippet->platnost = '*Uvedené údaje jsou čerpány z oficiální stránky partnera ke dni: 31. 8. 2015. ';
$snippet->priklady =  array(
'0' => (object) array(
'ponuka' => '', 'vyska' => '5 000 Kč', 'pocet_splatok' => '30', 'splatka' => '201 Kč', 'rpmn' => '16,13 %', 'urok' => '14,90 %', 'poplatok' => '0 Kč', 'celkom' => '6 030 Kč', 'celkova_uspora' => '', 'splatnost' => '',), 
'1' => (object) array(
'ponuka' => '', 'vyska' => '300 000 Kč', 'pocet_splatok' => '50', 'splatka' => '7 347 Kč', 'rpmn' => '10,36 %', 'urok' => '9,90 %', 'poplatok' => '0 Kč', 'celkom' => '367 350 Kč.', 'celkova_uspora' => '', 'splatnost' => '',), 
'2' => (object) array(
'ponuka' => '', 'vyska' => '600 000 Kč', 'pocet_splatok' => '84', 'splatka' => '10 242 Kč', 'rpmn' => '11,46 %', 'urok' => '10,90 %', 'poplatok' => '0 Kč', 'celkom' => '860 328 Kč', 'celkova_uspora' => '', 'splatnost' => '',), 
);
$snippet->vyska_label = '' . $slovnik->vyska_pozicky . '';
$snippet->pocet_splatok_label = '' . $slovnik->pocet_splatok . '';
$snippet->splatka_label = '' . $slovnik->mesacna_splatka . '';
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