<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/blocks/snippet_cache27962.latte

class Template5e71ba0ab047d0d74106d4aadd68acc8 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('fc62ac98d3', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet11/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->nadpis = '' . $product->nazov_produktu . '';
$snippet->podnadpis = '';
$snippet->odrazky = '';
$snippet->popis = '';
$snippet->bg_image = '';
$snippet->button_url = '' . $portal->ziadost_url . '/';
$snippet->button_text = '' . $slovnik->chcem_si_pozicat . '';
$snippet->bg_color = '#166681';
$snippet->text_color = '#ffffff';
$snippet->h1_color = '#ffffff';
$snippet->background_color = '';
$snippet->bg_position = '';
$snippet->align = '';
$snippet->text = '' . $slovnik->poziadal . '<span class="person_end"></span> o <span class="person_amount">100 €</span>';
$snippet->zadatel = '';
/* Var values  */
$snippet->nadpis = 'ZUNO pôžička';
$snippet->odrazky =  array(
'0' => (object) array(
'text' => 'Garantovaný úrok počas celej doby splácania',), 
'1' => (object) array(
'text' => '1 mesiac v roku, kedy pôžičku nesplácate',), 
'2' => (object) array(
'text' => 'Účet v ZUNO k pôžičke zdarma',), 
);
$snippet->bg_image = '/portal/hyperfinancie.sk/headers/main-hero-zuno.jpg';
$snippet->button_url = '' . $portal->ziadost_url . '/';
$snippet->button_text = '' . $slovnik->chcem_si_pozicat . '';
$snippet->bg_color = '#166681';
$snippet->text_color = '#ffffff';
$snippet->h1_color = '#ffffff';
$snippet->bg_position = 'bg-bottom-right';
$snippet->align = 'pull-left';
$snippet->text = '' . $slovnik->poziadal . '<span class="person_end"></span> o <span class="person_amount">100 €</span>';
$snippet->zadatel = 'true'
?>
<div class="poster <?php echo Latte\Runtime\Filters::escapeHtml($snippet->bg_position, ENT_COMPAT) ?>
 <?php echo Latte\Runtime\Filters::escapeHtml($snippet->bez_spoluprace_trieda, ENT_COMPAT) ?>
" style=" <?php if (!empty($snippet->bg_image)) { ?> background-image: url(<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($snippet->bg_image), ENT_COMPAT) ?>
) <?php } ?> ">
  <div class="poster-content poster-boxed-content <?php echo Latte\Runtime\Filters::escapeHtml($snippet->align, ENT_COMPAT) ?>
" style="background : <?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($snippet->bg_color), ENT_COMPAT) ?>
; color : <?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($snippet->text_color), ENT_COMPAT) ?>">
    <div class="poster-content-text">
      <div id="headline" style="color : <?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($snippet->h1_color), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></div>
      <ul>
<?php $iterations = 0; foreach ($snippet->odrazky as $odrazka) { ?>
        	<li><?php echo Latte\Runtime\Filters::escapeHtml($odrazka->text, ENT_NOQUOTES) ?></li>
<?php $iterations++; } ?>
      </ul>
    </div>
    <div class="poster-content-cta">
      <a class="btn main-btn btn-xl" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->button_url), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->button_text, ENT_NOQUOTES) ?></a>
      
      <?php if ($snippet->zadatel == 'true') : ?>
      	<div class="geo">
        	<h4><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->posledny_ziadatel, ENT_NOQUOTES) ?>: <strong><span class="person_first_name">Miroslav </span> <span class="person_last_name">D.</span>, <span class="person_place"></span></strong></h4>
       		<p>
          	<span class="person_salut"></span> <span class="person_first_name">Miroslav </span> dnes <?php echo Latte\Runtime\Filters::escapeHtml($slovnik->o, ENT_NOQUOTES) ?>
 <span class="person_time">12:54</span> <?php echo Latte\Runtime\Filters::escapeHtml($snippet->text, ENT_NOQUOTES) ?>

        	</p>
      	</div>
      <?php endif ?>
    </div>
  </div>
  <div class="clearfix"></div>
  <script>
    
    getPerson('person', <?php echo Latte\Runtime\Filters::escapeJs($product->dolna_hranica_pozicky) ?>
, <?php echo Latte\Runtime\Filters::escapeJs($product->horna_hranica_pozicky) ?>
, <?php echo Latte\Runtime\Filters::escapeJs($portal->lang) ?>, <?php echo Latte\Runtime\Filters::escapeJs($product->zaokruhlenie) ?>);
  </script>
</div><?php
}}