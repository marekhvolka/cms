<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/proficredit_pozicka/product_snippet_cache27446.latte

class Templateecc37abc72558d3286d80bbe91242d4c extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('d1584e5693', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet32/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->tabulka_splatok . '';
$snippet->platnost = '*Uvedené údaje sú čerpané z oficiálnej stránky partnera ku dňu 21. 1. 2016';
$snippet->priklady =  array(
'0' => (object) array(
'ponuka' => '', 'vyska' => '900 €', 'pocet_splatok' => '36', 'splatka' => '35,01 €', 'urok' => '23,36 %', 'poplatok' => '0 €', 'rpmn' => '26,04 %', 'celkom' => '1 260,36 €', 'celkova_uspora' => '', 'splatnost' => '',), 
'1' => (object) array(
'ponuka' => '', 'vyska' => '1 200 €', 'pocet_splatok' => '42', 'splatka' => '42,08 €', 'urok' => '23,35 %', 'poplatok' => '0 €', 'rpmn' => '26,02 %', 'celkom' => '1 767,36 €', 'celkova_uspora' => '', 'splatnost' => '',), 
'2' => (object) array(
'ponuka' => '', 'vyska' => '1 500 €', 'pocet_splatok' => '42', 'splatka' => '52,59 €', 'urok' => '23,34 %', 'poplatok' => '0 €', 'rpmn' => '26,00 %', 'celkom' => '2 208,78 €', 'celkova_uspora' => '', 'splatnost' => '',), 
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