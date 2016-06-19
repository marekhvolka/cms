<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/blocks/snippet_cache28008.latte

class Templatecd68ab12119f2bcd96e37458e531e680 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('9b1e2d4998', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet86/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->polozky =  array(
'0' => (object) array(
'partner' => $ferratum_cz, 'podstranka' => $portal->pages->page320, 'sirka' => '', 'vyska' => '',), 
'1' => (object) array(
'partner' => $home_credit_cz, 'podstranka' => $portal->pages->page679, 'sirka' => '', 'vyska' => '',), 
'2' => (object) array(
'partner' => $proficredit_cz, 'podstranka' => $portal->pages->page1024, 'sirka' => '', 'vyska' => '',), 
'3' => (object) array(
'partner' => $unicredit_cz_presto, 'podstranka' => $portal->pages->page449, 'sirka' => '', 'vyska' => '',), 
'4' => (object) array(
'partner' => $zuno_ucet, 'podstranka' => $portal->pages->page678, 'sirka' => '', 'vyska' => '',), 
'5' => (object) array(
'partner' => $provident_cz, 'podstranka' => $portal->pages->page1025, 'sirka' => '', 'vyska' => '',), 
'6' => (object) array(
'partner' => $zaplo_cz, 'podstranka' => $portal->pages->page310, 'sirka' => '', 'vyska' => '',), 
'7' => (object) array(
'partner' => $cetelem_pujcka, 'podstranka' => $portal->pages->page362, 'sirka' => '', 'vyska' => '',), 
'8' => (object) array(
'partner' => $ge_money_pujcka, 'podstranka' => $portal->pages->page332, 'sirka' => '', 'vyska' => '',), 
'9' => (object) array(
'partner' => $equa_bank, 'podstranka' => $portal->pages->page670, 'sirka' => '', 'vyska' => '',), 
'10' => (object) array(
'partner' => $mbank, 'podstranka' => $portal->pages->page677, 'sirka' => '', 'vyska' => '',), 
'11' => (object) array(
'partner' => $sberbank_cz, 'podstranka' => $portal->pages->page797, 'sirka' => '', 'vyska' => '',), 
'12' => (object) array(
'partner' => $ceska_sporitelna, 'podstranka' => $portal->pages->page881, 'sirka' => '', 'vyska' => '',), 
'13' => (object) array(
'partner' => $airbank_cz, 'podstranka' => $portal->pages->page974, 'sirka' => '', 'vyska' => '',), 
'14' => (object) array(
'partner' => $raiffeisenbank, 'podstranka' => $portal->pages->page975, 'sirka' => '', 'vyska' => '',), 
)
?>
<div class="partners partners-slider">
  <div class="partners-slider-container clearfix">
<?php $iterations = 0; foreach ($snippet->polozky as $polozka) { ?>
  	<div>
<?php if (!empty($polozka->podstranka)) { ?>
  			<a href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($polozka->podstranka->url), ENT_COMPAT) ?>
"><?php } ?><img src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($polozka->partner->logo_medium), ENT_COMPAT) ?>
" alt="<?php echo Latte\Runtime\Filters::escapeHtml($polozka->partner->nazov_spolocnosti, ENT_COMPAT) ?>">
    <?php if (!empty($polozka->podstranka)) { ?></a><?php } ?>

    </div>
<?php $iterations++; } ?>
  </div>
</div>

<link rel="stylesheet" type="text/css" href="/template/hyperfinancie.sk_hlavna_sablona/css/slick-slider/slick.css">
<script type="text/javascript" src="/template/hyperfinancie.sk_hlavna_sablona/css/slick-slider/slick.min.js"></script>

<script>
$(function(){
  $('.partners-slider-container').slick({
		autoplay:true,
    autoplaySpeed:4000,
  	infinite: true,
  	speed: 300,
 		slidesToShow: 5,
 	 	centerMode: false,
  	variableWidth: true
  })
});
</script><?php
}}