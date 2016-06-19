<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products/ferratum_uver_plus/product_snippet_cache27610.latte

class Template51bb5a00bd34df1befa042d0eb41e36a extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('d048454294', 'html')
;
//
// main template
//
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet60/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->reprezentativny_priklad . '';
$snippet->vyska = '500 €';
$snippet->pocet_splatok = '5';
$snippet->splatka = '109 €';
$snippet->urok = '0 %';
$snippet->poplatok = '45 €';
$snippet->rpmn = '42,32%';
$snippet->celkom = '545 €';
$snippet->splatnost = '5. 6.2016';
$snippet->platnost = '* Reprezentativný príklad je čerpaný z oficiálnej stránky poskytovateľa k dátumu: 7. 1. 2016.';
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