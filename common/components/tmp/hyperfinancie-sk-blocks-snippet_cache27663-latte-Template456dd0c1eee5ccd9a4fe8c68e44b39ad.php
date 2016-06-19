<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/blocks/snippet_cache27663.latte

class Template456dd0c1eee5ccd9a4fe8c68e44b39ad extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('8b5ae108fd', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet35/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->color = '#ffffff';
$snippet->sekcie =  array(
'0' => (object) array(
'podstranka' => $portal->pages->page570, 'popisok' => 'Bankové pôžičky', 'popisok_url' => '/pozicky/', 'css_class' => 'none', 'bg_color' => '', 'css_style' => '', 'icon' => 'fa fa-university', 'odkazy' =>  array(
'0' => (object) array(
'podstranka' => $portal->pages->page102, 'text_odkazu' => 'Sberbank pôžička', 'css_class' => 'none',), 
'1' => (object) array(
'podstranka' => $portal->pages->page103, 'text_odkazu' => 'UniCredit Bank pôžička', 'css_class' => 'none',), 
'2' => (object) array(
'podstranka' => $portal->pages->page286, 'text_odkazu' => 'Zuno pôžička', 'css_class' => 'none',), 
'3' => (object) array(
'podstranka' => $portal->pages->page270, 'text_odkazu' => 'mBank pôžička', 'css_class' => 'none',), 
),), 
'1' => (object) array(
'podstranka' => $portal->pages->page98, 'popisok' => 'Nebankové pôžičky', 'popisok_url' => '/pozicky/nebankove-pozicky/', 'css_class' => 'none', 'bg_color' => '', 'css_style' => '', 'icon' => 'fa fa-eur', 'odkazy' =>  array(
'0' => (object) array(
'podstranka' => $portal->pages->page89, 'text_odkazu' => 'Profi Credit pôžička', 'css_class' => 'none',), 
'1' => (object) array(
'podstranka' => $portal->pages->page87, 'text_odkazu' => 'Provident pôžička', 'css_class' => 'none',), 
'2' => (object) array(
'podstranka' => $portal->pages->page84, 'text_odkazu' => 'Home Credit pôžička', 'css_class' => 'none',), 
'3' => (object) array(
'podstranka' => $portal->pages->page101, 'text_odkazu' => 'Cetelem pôžička', 'css_class' => 'none',), 
'4' => (object) array(
'podstranka' => $portal->pages->page545, 'text_odkazu' => '', 'css_class' => 'none',), 
),), 
'2' => (object) array(
'podstranka' => $portal->pages->page92, 'popisok' => 'Krátkodobé pôžičky', 'popisok_url' => '/pozicky/pozicka-pred-vyplatou/', 'css_class' => 'none', 'bg_color' => '', 'css_style' => '', 'icon' => 'fa fa-clock-o', 'odkazy' =>  array(
'0' => (object) array(
'podstranka' => $portal->pages->page304, 'text_odkazu' => 'CreditOne pôžička', 'css_class' => 'none',), 
'1' => (object) array(
'podstranka' => $portal->pages->page90, 'text_odkazu' => 'Ferratum pôžička', 'css_class' => 'none',), 
'2' => (object) array(
'podstranka' => $portal->pages->page546, 'text_odkazu' => '', 'css_class' => 'none',), 
),), 
'3' => (object) array(
'podstranka' => $portal->pages->page85, 'popisok' => 'Typy pôžičiek', 'popisok_url' => '', 'css_class' => 'none', 'bg_color' => '', 'css_style' => '', 'icon' => 'fa fa-align-justify', 'odkazy' =>  array(
'0' => (object) array(
'podstranka' => $portal->pages->page387, 'text_odkazu' => '', 'css_class' => 'none',), 
'1' => (object) array(
'podstranka' => $portal->pages->page92, 'text_odkazu' => '', 'css_class' => 'none',), 
'2' => (object) array(
'podstranka' => $portal->pages->page96, 'text_odkazu' => '', 'css_class' => 'none',), 
'3' => (object) array(
'podstranka' => $portal->pages->page432, 'text_odkazu' => '', 'css_class' => 'none',), 
'4' => (object) array(
'podstranka' => $portal->pages->page633, 'text_odkazu' => '', 'css_class' => 'none',), 
'5' => (object) array(
'podstranka' => $portal->pages->page757, 'text_odkazu' => '', 'css_class' => 'none',), 
),), 
'4' => (object) array(
'podstranka' => $portal->pages->page292, 'popisok' => 'Konsolidácia', 'popisok_url' => '/pozicky/konsolidacia-poziciek/', 'css_class' => 'none', 'bg_color' => '', 'css_style' => '', 'icon' => 'fa fa-retweet', 'odkazy' =>  array(
'0' => (object) array(
'podstranka' => $portal->pages->page276, 'text_odkazu' => 'Sberbank refinančná pôžička', 'css_class' => 'none',), 
'1' => (object) array(
'podstranka' => $portal->pages->page290, 'text_odkazu' => 'UniCredit prevedenie', 'css_class' => 'none',), 
'2' => (object) array(
'podstranka' => $portal->pages->page288, 'text_odkazu' => 'UniCredit optimalizácia', 'css_class' => 'none',), 
'3' => (object) array(
'podstranka' => $portal->pages->page278, 'text_odkazu' => 'Home Credit spojenie pôžičiek', 'css_class' => 'none',), 
'4' => (object) array(
'podstranka' => $portal->pages->page298, 'text_odkazu' => '', 'css_class' => 'none',), 
),), 
'5' => (object) array(
'podstranka' => $portal->pages->page272, 'popisok' => 'Účty', 'popisok_url' => '', 'css_class' => 'none', 'bg_color' => '', 'css_style' => '', 'icon' => 'fa fa-credit-card', 'odkazy' =>  array(
'0' => (object) array(
'podstranka' => $portal->pages->page271, 'text_odkazu' => 'mBank účet', 'css_class' => 'none',), 
'1' => (object) array(
'podstranka' => $portal->pages->page548, 'text_odkazu' => '', 'css_class' => 'none',), 
'2' => (object) array(
'podstranka' => $portal->pages->page588, 'text_odkazu' => '', 'css_class' => 'none',), 
'3' => (object) array(
'podstranka' => $portal->pages->page645, 'text_odkazu' => '', 'css_class' => 'none',), 
),), 
'6' => (object) array(
'podstranka' => NULL, 'popisok' => 'Informácie', 'popisok_url' => '', 'css_class' => 'none', 'bg_color' => '', 'css_style' => '', 'icon' => 'fa fa-info', 'odkazy' =>  array(
'0' => (object) array(
'podstranka' => $portal->pages->page104, 'text_odkazu' => 'Slovník', 'css_class' => 'none',), 
'1' => (object) array(
'podstranka' => $portal->pages->page91, 'text_odkazu' => '', 'css_class' => 'none',), 
),), 
'7' => (object) array(
'podstranka' => $portal->pages->page506, 'popisok' => 'Profily spoločností', 'popisok_url' => '', 'css_class' => 'none', 'bg_color' => '', 'css_style' => '', 'icon' => 'fa fa-building', 'odkazy' =>  array(
'0' => (object) array(
'podstranka' => $portal->pages->page507, 'text_odkazu' => '', 'css_class' => 'none',), 
'1' => (object) array(
'podstranka' => $portal->pages->page554, 'text_odkazu' => '', 'css_class' => 'none',), 
'2' => (object) array(
'podstranka' => $portal->pages->page583, 'text_odkazu' => '', 'css_class' => 'none',), 
'3' => (object) array(
'podstranka' => $portal->pages->page585, 'text_odkazu' => '', 'css_class' => 'none',), 
'4' => (object) array(
'podstranka' => $portal->pages->page586, 'text_odkazu' => '', 'css_class' => 'none',), 
),), 
)
?>
<div class="bottom-menu">
<?php $iterations = 0; foreach ($snippet->sekcie as $sekcia) { ?>
     <div class="bottom-menu-block"> 
    	<h4>
        <a 
           <?php if (!empty($sekcia->podstranka)) { ?> href='<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($sekcia->podstranka->url), ENT_QUOTES) ?>
' <?php } else { ?> href='javascript:void(0);' <?php } ?>

           ><i class="<?php echo Latte\Runtime\Filters::escapeHtml($sekcia->icon, ENT_COMPAT) ?>"></i>
<?php if (!empty($sekcia->popisok)) { ?>
          	<?php echo Latte\Runtime\Filters::escapeHtml($sekcia->popisok, ENT_NOQUOTES) ?>

<?php } else { ?>
          	<?php echo Latte\Runtime\Filters::escapeHtml($sekcia->podstranka->name, ENT_NOQUOTES) ?>

<?php } ?>
        </a>
       </h4>
      <ul>
<?php $iterations = 0; foreach ($sekcia->odkazy as $odkaz) { ?>
        	<li><a href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($odkaz->podstranka->url), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($odkaz->podstranka->name, ENT_NOQUOTES) ?></a></li>
<?php $iterations++; } ?>
      </ul>
  	</div>
<?php $iterations++; } ?>
</div>


<script>
$(function(){
  /************** rozbalenie footer menu na mobile *********************/
  
    if($(window).width()<768) {
      $('.bottom-menu-block h4').click(function(){
         $(this).parent().find('ul').slideToggle();
      });

    }

})
</script><?php
}}