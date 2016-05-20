<div class="akcia akcia-without-image akcia-with-more-button {$bez_spoluprace_trieda}">
  
    <span class="akcia-badge">{$slovnik->akcia}</span>
    <div class="akcia-content">
      <h2>{$nadpis}</h2>
      <div class="text">
        {$text}  
      </div> 
      <a href="#" class="akcia-more-btn">{$slovnik->viac_informacii} <i class="fa fa-caret-down"></i></a>
    </div>
  
    <a href="{$link_url}" class="btn main-btn btn-lg" >{$button_text}</a>
  
  <script>
    var dnes = Math.floor(Date.now() / 1000);
    if({platnost_akcie} > dnes)
    {
      $(".akcia").parent().show();
    }
    else
    {
      var parent = $(".akcia").parent();

      if (parent.children().length > 1)
        $(".akcia").hide();
      else
        parent.hide();
    }
    
    /**************** skryvanie/odkryvanie dlhej akcie ********************/
    var text_string=$('.text').text();
    
    if(text_string.length>=80){
      
      $('.akcia-content').addClass('akcia-trimmed');
      $('.text').addClass('akcia-trimmed-text');
    }
    
    $('.akcia-more-btn').click(function(e){
      e.preventDefault();
      
      $('.text').toggleClass('akcia-trimmed-text');
      
      if($('.text').hasClass('akcia-trimmed-text')){
        $(this).html('{slovnik.viac_informacii} <i class="fa fa-caret-down"></i>');
      }else{
        $(this).html('{slovnik.skryt} <i class="fa fa-caret-up"></i>');
      }
    });
    
  </script>
</div>