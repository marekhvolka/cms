<?php
include("C:\wamp64\www\cms/frontend/web/data/common/cz_dictionary.php");
include("C:\wamp64\www\cms/frontend/web/data/common/products/cz/products.php");

include("C:\wamp64\www\cms/frontend/web/data/hyperfinance.cz/main_file.php");

include("C:\wamp64\www\cms/frontend/web/data/hyperfinance.cz/posts/post6/post_var.php");

include("C:\wamp64\www\cms/frontend/web/data/common/snippets/snippet11/snippet.php");
/* Snippet values */
/* Var values  */
$snippet->nadpis = 'asdas';
$snippet->popis = 'dasdas';
$snippet->bg_position = 'bg-top-left';
$snippet->align = 'pull-left';
$snippet->zadatel = 'false';
$snippet->btn_slider = 'off'
?>
<div class="poster <?php echo Latte\Runtime\Filters::escapeHtml($snippet->bg_position, ENT_COMPAT) ?>
 <?php echo Latte\Runtime\Filters::escapeHtml($snippet->bez_spoluprace_trieda, ENT_COMPAT) ;if (($snippet->maskot=='true')) { ?>
 poster-with-maskot <?php } ?>" style="<?php if (!empty($snippet->bg_image)) { ?>
 background-image: url(<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($snippet->bg_image), ENT_COMPAT) ?>
) <?php } ?> ">
<?php if (($snippet->maskot == 'true')) { ?>
        <img src="http://www.hyperfinance.cz/data/hyperfinance.cz/multimedia/images/hp-maskot.png" alt="" class="header-maskot">
<?php } ?>
    
    <div class="poster-content poster-boxed-content <?php echo Latte\Runtime\Filters::escapeHtml($snippet->align, ENT_COMPAT) ?>
" style="background : <?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($snippet->bg_color), ENT_COMPAT) ?>
; color : <?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($snippet->text_color), ENT_COMPAT) ?>">
        <div class="poster-content-text">
            <div id="headline"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></div>
            <ul>
<?php $iterations = 0; foreach ($snippet->odrazky as $odrazka) { ?>
    	        <li><?php echo Latte\Runtime\Filters::escapeHtml($odrazka->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
            </ul>
        </div>
        <div class="poster-content-cta">
            <a class="btn main-btn btn-xl" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->button_url), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->button_text, ENT_NOQUOTES) ?></a>
  
<?php if (($product->isApi())) { ?>
  	        <div class="geo">
    	        <h4><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->posledny_ziadatel, ENT_NOQUOTES) ?>: <strong><span class="person_first_name">Miroslav </span> <span class="person_last_name">D.</span>, <span class="person_place"></span></strong></h4>
   		        <p>
      	            <span class="person_salut"></span> <span class="person_first_name">Miroslav </span> dnes <?php echo Latte\Runtime\Filters::escapeHtml($slovnik->o, ENT_NOQUOTES) ?>
 <span class="person_time">12:54</span> <?php echo Latte\Runtime\Filters::escapeHtml($snippet->text, ENT_NOQUOTES) ?>

    	        </p>
    	        <script>
                    getPerson('person', <?php echo Latte\Runtime\Filters::escapeJs($product->dolna_hranica_pozicky) ?>
, <?php echo Latte\Runtime\Filters::escapeJs($product->horna_hranica_pozicky) ?>
, <?php echo Latte\Runtime\Filters::escapeJs($portal->lang) ?>, <?php echo Latte\Runtime\Filters::escapeJs($product->zaokruhlenie) ?>);
                </script>
  	        </div>
<?php } ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>