<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/sberbank_pozicka/product_snippet_cache27474.latte

class Template394018fee1759c9ba3517c15932962ed extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('bb6b520221', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet32/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = 'Sberbank mojaPôžička - tabuľka splátok';
$snippet->platnost = '*Uvedené údaje sú čerpané z oficiálnej stránky partnera k dňu 16. 11. 2015  <br> **Maximálna doba splatnosti prislúchajúca k výške úveru<br> *** Úroková sadzba je stanovená na základe ratingu klienta';
$snippet->priklady =  array(
'0' => (object) array(
'ponuka' => '', 'vyska' => '1 000 €', 'pocet_splatok' => '60', 'splatka' => '22,70 €', 'urok' => '12,89 %', 'poplatok' => '<del  style="color:red">20 €</del> 0 €', 'rpmn' => '13,69 %', 'celkom' => '1362 €', 'celkova_uspora' => '', 'splatnost' => '',), 
'1' => (object) array(
'ponuka' => '', 'vyska' => '3 500 €', 'pocet_splatok' => '96', 'splatka' => 'od 50 €', 'urok' => '8,29 % - 11,79 % ', 'poplatok' => '<del  style="color:red">50 €</del> 0 €', 'rpmn' => '8,61 % - 12,45 %', 'celkom' => 'od 4 800 €', 'celkova_uspora' => '', 'splatnost' => '',), 
'2' => (object) array(
'ponuka' => '', 'vyska' => '19 000 €', 'pocet_splatok' => '108', 'splatka' => 'od 247,26 €', 'urok' => '7,99 % - 11,49 %', 'poplatok' => '<del  style="color:red">50 €</del> 0 €', 'rpmn' => '8,29 % - 12,11%', 'celkom' => 'od 26 704,08 €', 'celkova_uspora' => '', 'splatnost' => '',), 
);
$snippet->ponuka_label = '' . $slovnik->ponuka . '';
$snippet->vyska_label = '' . $slovnik->vyska_pozicky . '';
$snippet->pocet_splatok_label = 'Počet splátok **';
$snippet->splatka_label = '' . $slovnik->mesacna_splatka . '';
$snippet->urok_label = 'Ročný úrok ***';
$snippet->poplatok_label = 'Poplatok za poskytnutie úveru';
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