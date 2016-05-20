<!-- top bar -->
      <div class="top-bar text-center">
          <div class="container">
        
             <p>
               <i class="fa fa-star"></i>  {$text}  <a class="btn btn-small main-btn" href="{$btn_url}">{$btn_text}</a>  </p>
 
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
      
      <!-- /top bar -->