<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/blocks/snippet_cache28017.latte

class Template27eeeca32f7fdefa2941098513748df6 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('332652517b', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet101/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->text = 'Nejschvalovanější půjčka do 250 000 Kč. Schváleno až 95 % žádostí!';
$snippet->btn_url = 'http://www.hyperfinance.cz/pujcky/hyper-pujcka/zadost/';
$snippet->btn_text = '' . $slovnik->chcem_si_pozicat . '';
$snippet->podstranka = $portal->pages->page428
?>
<!-- top bar -->
      <div class="top-bar text-center">
          <div class="container">
        
             <p>
               <i class="fa fa-star"></i>  <?php echo Latte\Runtime\Filters::escapeHtml($snippet->text, ENT_NOQUOTES) ?>
  <a class="btn btn-small main-btn" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->btn_url), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->btn_text, ENT_NOQUOTES) ?></a>  </p>
 
          </div>
      </div>

<script>
	$(function(){
    
    
    
    // ******************** top bar show
    
    
    $(window).scroll(function(){
        
       var scrol=$(window).scrollTop();
        
        
        if(scrol>500){
                        
            
            if(!$('.top-bar').hasClass('shown')){
                $('.top-bar').addClass('shown');
            }
        }
        
        if(scrol<10){
            if($('.top-bar').hasClass('shown')){
                $('.top-bar').removeClass('shown');
            }
        }
    });
    
  });
</script>
      
      <!-- /top bar --><?php
}}