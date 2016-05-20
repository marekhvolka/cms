<div class="comparator-wrapper">
  <div class="comparator">
    {foreach polozky as polozka}   
    <div class="row comparator-item" data-tags-filter-attributes="{{polozka.produkt}.tags}" 
         data-amount-filter-attributes="{{polozka.produkt}.rozsah_porovnavac}">
      {if !empty(polozka.sellpoint)}
        <div class="sellpoint-bubble">
          {$polozka->sellpoint}
        </div>
      {/if}
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="{{polozka.produkt}.logo_small}">
          <p>{{polozka.produkt}.nazov_produktu}</p>
          <input type="hidden" class="rating_number" value="{{polozka.produkt}.rating}" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>{{polozka.produkt}.rozsah_porovnavac}</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>{$slovnik->splatnost}</p>
          <p><b>{{polozka.produkt}.splatnost_porovnavac}</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          {if !empty(polozka.podstranka_ziadost)}<a class="btn btn-medium main-btn" href="{{polozka.podstranka_ziadost}.url}">{$slovnik->mam_zaujem}</a>{/if}
          {if !empty(polozka.podstranka_viac)}<a class="btn btn-medium info-btn" href="{{polozka.podstranka_viac}.url}">{$slovnik->viac_info}</a>{/if}
        </div>    
      </div>
      
      <script>
        var amount = parseInt("<?php echo $filter_suma; ?>");
        var rozsah = "{{polozka.produkt}.rozsah_porovnavac}".split("-");
        
        var dolna_hranica = parseInt(rozsah[0].split(" ").join(""));
        var horna_hranica = parseInt(rozsah[1].split(" ").join(""));
        
        var scriptTag = document.getElementsByTagName('script');
        scriptTag = scriptTag[scriptTag.length - 1];
        var parentTag = scriptTag.parentNode;
        
        if (amount < dolna_hranica || amount > horna_hranica)
        	parentTag.className += " hidden-amount";
      </script>
      
      <script>
        var filter_tag = "{filter_tag}";
        var tags = "{{polozka.produkt}.tags}";
        
        if (filter_tag != "t_all" && tags.indexOf(filter_tag) == -1)
        	parentTag.className += " hidden-tag";
      </script>
    </div>
    
    {/foreach}
  </div>
  <div class="loader"><i class="fa fa-spinner fa-pulse"></i></div>
</div>
<!--comparator wrapper -->
<script>
    var elements = $(".comparator-item");
  	elements.each(function(){
      var attributes = $(this).data("tags-filter-attributes").split(',');
      var equals = false;
      for (var i=0; i<attributes.length; i++)
      {
        if (attributes[i] == "t_9")
        {
          equals = true;
          break;
        }
      }
      if (equals == true)
        $(this).addClass("bez-spoluprace");  
    });
</script>
<script><!--hviezdicky pri produktoch -->
  var rating = $(".rating_number");
  for(var i = 0; i < rating.length; i++)
  {
    var pocet_celych = $(rating[i]).val();
    for(var j = 0; j < 5; j++)
    {
      var prazdna = j < pocet_celych ? '' : '-empty';
      $(rating[i]).next('.comparator-rating').append('<span class="glyphicon glyphicon-star' + prazdna + '"></span>');
    }
  }
</script>
<script>
    var elements = $(".comparator-item");
  	elements.each(function(){
      var attributes = $(this).data("tags-filter-attributes").split(',');
      var equals = false;
      for (var i=0; i<attributes.length; i++)
      {
        if (attributes[i] == "t_9")
        {
          equals = true;
          break;
        }
      }
      if (equals == true)
        $(this).addClass("bez-spoluprace");  
    });
  
  function animujPorovnavac(filterElement){
    //  if($(window).scrollTop()<$('.filter').offset().top)
      	$('.loader').show().delay(1000).fadeOut('fast');
      $('html, body').animate({
       scrollTop: filterElement.offset().top
     },800);
      
      return true;
    }
</script>
  