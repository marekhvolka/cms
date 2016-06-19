<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/blocks/snippet_cache27662.latte

class Template4974c91046d88c8ee045c6a89728ba4c extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('0e5dd258b1', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet86/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->polozky =  array(
'0' => (object) array(
'partner' => $home_credit_sk, 'podstranka' => $portal->pages->page507, 'sirka' => '79', 'vyska' => '45',), 
'1' => (object) array(
'partner' => $provident_sk, 'podstranka' => $portal->pages->page87, 'sirka' => '210', 'vyska' => '45',), 
'2' => (object) array(
'partner' => $ferratum_sk, 'podstranka' => $portal->pages->page90, 'sirka' => '194', 'vyska' => '45',), 
'3' => (object) array(
'partner' => $proficredit_sk, 'podstranka' => $portal->pages->page89, 'sirka' => '184', 'vyska' => '45',), 
'4' => (object) array(
'partner' => $sberbank_sk, 'podstranka' => $portal->pages->page583, 'sirka' => '220', 'vyska' => '45',), 
'5' => (object) array(
'partner' => $unicredit_sk, 'podstranka' => $portal->pages->page586, 'sirka' => '250', 'vyska' => '45',), 
'6' => (object) array(
'partner' => $creditone_sk, 'podstranka' => $portal->pages->page304, 'sirka' => '194', 'vyska' => '45',), 
'7' => (object) array(
'partner' => $zuno_sk, 'podstranka' => $portal->pages->page585, 'sirka' => '132', 'vyska' => '45',), 
'8' => (object) array(
'partner' => $mbank, 'podstranka' => $portal->pages->page554, 'sirka' => '', 'vyska' => '',), 
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