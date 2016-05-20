<div class="comparator">
  <h3>{$nadpis}</h3>
  {foreach polozky as polozka}
  	<div class="panel comparator-item row" data-tags-filter-attributes="{{polozka.produkt}.tags}">	
      <div class="col-md-6">
        <div class="comparator-item-inner">
          <div class="comparator-img">
              <img src="{{polozka.produkt}.logo_small}" alt="" />
            </div>
          <p class="product-label">
            {{polozka.produkt}.nazov_produktu}
          </p>
          <input type="hidden" class="rating_number" value="{{polozka.produkt}.rating}">
          <div class="comparator-rating">
          </div>
        </div>
      </div>       
      <div class="col-md-6">
          <div class="comparator-item-inner btn-item-inner">
            {if !empty(polozka.ziadost_podstranka)}
            	<a href="{{polozka.ziadost_podstranka}.url}" class="btn main-btn btn-default">{$slovnik->poziadat}</a>
            {/if}
            {if !empty(polozka.viac_podstranka)}
            	<a href="{{polozka.viac_podstranka}.url}" class="panel-more-link">{$slovnik->viac_informacii}<i class="fa fa-caret-down"></i></a>
            {/if}
          </div>
        </div>
  	</div>
  {/foreach}
</div>

<script><!--hviezdicky pri produktoch -->
  var rating = $(".rating_number");
  
  for(var i = 0; i < rating.length; i++)
  {
    var pocet_celych = $(rating[i]).val();
    
    if (pocet_celych == 0)
  	{
  		$(rating[i]).next(".comparator-rating").addClass("hidden");    
  	}
    else
    {	
      for(var j = 0; j < 5; j++)
    	{
      	var prazdna = j < pocet_celych ? '' : '-empty';
      	$(rating[i]).next('.comparator-rating').append('<span class="glyphicon glyphicon-star' + prazdna + '"></span>');
    	}
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
</script>