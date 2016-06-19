<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/proficredit_pozicka/product_snippet_cache27447.latte

class Templateeafae1295bb3cd77a4a76a73acb5706f extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('ac65bdcf22', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet60/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->reprezentativny_priklad . '';
$snippet->vyska = '1 200 €';
$snippet->pocet_splatok = '42';
$snippet->splatka = '42,08 €';
$snippet->urok = '23,35 %';
$snippet->poplatok = '0 €';
$snippet->rpmn = '26,02 %';
$snippet->celkom = '1 767,36 €';
$snippet->platnost = '*Uvedené údaje sú čerpané z oficiálnej stránky partnera ku dňu 21. 1. 2016';
$snippet->vyska_label = '' . $slovnik->vyska_pozicky . '';
$snippet->pocet_splatok_label = '' . $slovnik->pocet_splatok . '';
$snippet->splatka_label = '' . $slovnik->mesacna_splatka . '';
$snippet->urok_label = '' . $slovnik->rocny_urok . '';
$snippet->poplatok_label = '' . $slovnik->poplatok_za_vybavenie . '';
$snippet->rpmn_label = '' . $slovnik->rpmn . '';
$snippet->celkom_label = '' . $slovnik->celkova_ciastka_na_zaplatenie . '';
$snippet->splatnost_label = '' . $slovnik->datum_splatnosti . ''
?>
<h4><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h4>
<ul>
<?php if (isset($snippet->vyska)) { ?>
  	<li><?php echo Latte\Runtime\Filters::escapeHtml($snippet->vyska_label, ENT_NOQUOTES) ?>
: <?php echo Latte\Runtime\Filters::escapeHtml($snippet->vyska, ENT_NOQUOTES) ?></li>
<?php } if (isset($snippet->pocet_splatok)) { ?>
  	<li><?php echo Latte\Runtime\Filters::escapeHtml($snippet->pocet_splatok_label, ENT_NOQUOTES) ?>
: <?php echo Latte\Runtime\Filters::escapeHtml($snippet->pocet_splatok, ENT_NOQUOTES) ?></li>
<?php } if (isset($snippet->splatka)) { ?>
  	<li><?php echo Latte\Runtime\Filters::escapeHtml($snippet->splatka_label, ENT_NOQUOTES) ?>
: <?php echo Latte\Runtime\Filters::escapeHtml($snippet->splatka, ENT_NOQUOTES) ?></li>
<?php } if (isset($snippet->urok)) { ?>
  	<li><?php echo Latte\Runtime\Filters::escapeHtml($snippet->urok_label, ENT_NOQUOTES) ?>
: <?php echo Latte\Runtime\Filters::escapeHtml($snippet->urok, ENT_NOQUOTES) ?></li>
<?php } if (isset($snippet->poplatok)) { ?>
  	<li><?php echo Latte\Runtime\Filters::escapeHtml($snippet->poplatok_label, ENT_NOQUOTES) ?>
: <?php echo Latte\Runtime\Filters::escapeHtml($snippet->poplatok, ENT_NOQUOTES) ?></li>
<?php } if (isset($snippet->rpmn)) { ?>
  	<li><?php echo Latte\Runtime\Filters::escapeHtml($snippet->rpmn_label, ENT_NOQUOTES) ?>
: <?php echo Latte\Runtime\Filters::escapeHtml($snippet->rpmn, ENT_NOQUOTES) ?></li>
<?php } if (isset($celkom)) { ?>
  	<li><?php echo Latte\Runtime\Filters::escapeHtml($snippet->celkom_label, ENT_NOQUOTES) ?>
: <?php echo Latte\Runtime\Filters::escapeHtml($snippet->celkom, ENT_NOQUOTES) ?></li>
<?php } if (isset($snippet->splatnost)) { ?>
  	<li><?php echo Latte\Runtime\Filters::escapeHtml($snippet->splatnost_label, ENT_NOQUOTES) ?>
: <?php echo Latte\Runtime\Filters::escapeHtml($snippet->splatnost, ENT_NOQUOTES) ?></li>
<?php } ?>
</ul>
<i><?php echo Latte\Runtime\Filters::escapeHtml($snippet->platnost, ENT_NOQUOTES) ?>
</i><?php
}}