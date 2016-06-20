<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/blocks/snippet_cache27715.latte

class Templatef44e493e742555980e9434378f881f51 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('c01b50f165', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet35/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->color = '#ffffff';
$snippet->sekcie =  array(
'0' => (object) array(
'podstranka' => $portal->pages->page544, 'popisok' => '<i class="fa fa-home"></i>', 'popisok_url' => '', 'css_class' => 'none', 'bg_color' => '', 'css_style' => '', 'icon' => '',), 
'1' => (object) array(
'podstranka' => $portal->pages->page597, 'popisok' => 'Nebankové pôžičky', 'popisok_url' => '', 'css_class' => 'none', 'bg_color' => '', 'css_style' => '', 'icon' => '', 'podsekcie' =>  array(
'0' => (object) array(
'podstranka' => NULL, 'popisok' => '', 'odkazy' =>  array(
'0' => (object) array(
'podstranka' => $portal->pages->page894, 'text_odkazu' => '', 'css_class' => '',), 
'1' => (object) array(
'podstranka' => $portal->pages->page609, 'text_odkazu' => '', 'css_class' => '',), 
'2' => (object) array(
'podstranka' => $portal->pages->page613, 'text_odkazu' => '', 'css_class' => '',), 
'3' => (object) array(
'podstranka' => $portal->pages->page602, 'text_odkazu' => '', 'css_class' => '',), 
'4' => (object) array(
'podstranka' => $portal->pages->page847, 'text_odkazu' => '', 'css_class' => '',), 
'5' => (object) array(
'podstranka' => $portal->pages->page849, 'text_odkazu' => '', 'css_class' => '',), 
),), 
),), 
'2' => (object) array(
'podstranka' => $portal->pages->page630, 'popisok' => 'Bankové pôžičky', 'popisok_url' => '', 'css_class' => 'none', 'bg_color' => '', 'css_style' => '', 'icon' => '', 'podsekcie' =>  array(
'0' => (object) array(
'podstranka' => NULL, 'popisok' => '', 'odkazy' =>  array(
'0' => (object) array(
'podstranka' => $portal->pages->page728, 'text_odkazu' => '', 'css_class' => '',), 
'1' => (object) array(
'podstranka' => $portal->pages->page724, 'text_odkazu' => '', 'css_class' => '',), 
'2' => (object) array(
'podstranka' => $portal->pages->page726, 'text_odkazu' => '', 'css_class' => '',), 
'3' => (object) array(
'podstranka' => $portal->pages->page722, 'text_odkazu' => '', 'css_class' => '',), 
),), 
),), 
'3' => (object) array(
'podstranka' => $portal->pages->page632, 'popisok' => '', 'popisok_url' => '', 'css_class' => 'none', 'bg_color' => '', 'css_style' => '', 'icon' => '', 'podsekcie' =>  array(
'0' => (object) array(
'podstranka' => NULL, 'popisok' => '', 'odkazy' =>  array(
'0' => (object) array(
'podstranka' => $portal->pages->page892, 'text_odkazu' => '', 'css_class' => '',), 
'1' => (object) array(
'podstranka' => $portal->pages->page617, 'text_odkazu' => '', 'css_class' => '',), 
'2' => (object) array(
'podstranka' => $portal->pages->page851, 'text_odkazu' => '', 'css_class' => '',), 
'3' => (object) array(
'podstranka' => $portal->pages->page890, 'text_odkazu' => '', 'css_class' => '',), 
),), 
),), 
)
?>
<nav id="main-nav" class="navbar-collapse collapse">
  <ul>
<?php $iterations = 0; foreach ($snippet->sekcie as $sekcia) { ?>
    	<li style="background: <?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($sekcia->bg_color), ENT_COMPAT) ?>
; color: <?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($snippet->color), ENT_COMPAT) ?>
; <?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($sekcia->css_style), ENT_COMPAT) ?>
" <?php if (empty($sekcia->podsekcie)) { ?> class="no-child" <?php } ?> >
        <a href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($sekcia->podstranka->url), ENT_COMPAT) ?>
" class="<?php echo Latte\Runtime\Filters::escapeHtml($sekcia->css_class, ENT_COMPAT) ?>">
<?php if (!empty($sekcia->popisok)) { ?>
          	<?php echo Latte\Runtime\Filters::escapeHtml($sekcia->popisok, ENT_NOQUOTES) ?>

<?php } else { ?>
          	<?php echo Latte\Runtime\Filters::escapeHtml($sekcia->podstranka->name, ENT_NOQUOTES) ?>

<?php } ?>
        </a>
<?php if (!empty($sekcia->podsekcie)) { ?>
          <div class="inner-menu">
<?php $iterations = 0; foreach ($sekcia->podsekcie as $podsekcia) { ?>
                <div class="inner-menu-subsection">
<?php if (!empty($podsekcia->podstranka)) { ?>
                  	<h4>
                  		<a href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($podsekcia->podstranka->url), ENT_COMPAT) ?>">
<?php if (!empty($podsekcia->popisok)) { ?>
                        	<?php echo Latte\Runtime\Filters::escapeHtml($podsekcia->popisok, ENT_NOQUOTES) ?>

<?php } else { ?>
                        	<?php echo Latte\Runtime\Filters::escapeHtml($podsekcia->podstranka->name, ENT_NOQUOTES) ?>

<?php } ?>
                      </a>
                  	</h4>
<?php } ?>
                  <ul>
<?php $iterations = 0; foreach ($podsekcia->odkazy as $odkaz) { ?>
                    <li class="<?php echo Latte\Runtime\Filters::escapeHtml($odkaz->css_class, ENT_COMPAT) ?>">
                      <a href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($odkaz->podstranka->url), ENT_COMPAT) ?>">
                        <?php if (!empty($odkaz->text_odkazu)) { ?> <?php echo Latte\Runtime\Filters::escapeHtml($odkaz->text_odkazu, ENT_NOQUOTES) ?>
 <?php } else { ?> <?php echo Latte\Runtime\Filters::escapeHtml($odkaz->podstranka->name, ENT_NOQUOTES) ;} ?>

                      </a>
                    </li>
<?php $iterations++; } ?>
                  </ul>
              	</div>
<?php $iterations++; } ?>
            
          </div>
        <div class="clearfix"></div>
<?php } ?>
    	</li>
<?php $iterations++; } ?>
  </ul>
</nav>
<script>
$(".inner-menu").each(function() 
{
  var count = $(this).children().size();
  $(this).children().each(function() {
	$(this).css("width",100.0/count + "%"); 
  });
});
</script><?php
}}