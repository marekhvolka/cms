<!--navigacia - zoradovanie atd -->

<!--navigacia -->
<!--comparator-->
<div class="comparator-wrapper">
<div class="comparator comparator-light">
  {foreach produkty as produkt}
  	<div class="comparator-item panel comparator-{$produkt->flag} {$produkt->odkaz_viac}" id="{$produkt->kod_produktu}-item"
         data-tags-filter-attributes="{{produkt.kod_produktu}.tags}" data-amount-filter-attributes="{{produkt.kod_produktu}.rozsah_porovnavac}">
    	
      <div class="row panel-more"><!--hlavny riadok, ktory je vzdy viditelny -->
        <div class="col-sm-2">
          <div class="comparator-item-inner">
            <div class="comparator-img">
              <img src="{{produkt.kod_produktu}.logo_small}" alt="" />
            </div>
            <p class="product-label">{{produkt.kod_produktu}.nazov_produktu}</p>
            <input type="hidden" class="rating_number" value="{{produkt.kod_produktu}.rating}" />
            <div class="comparator-rating">
              
            </div>
          </div>
        </div>
				{foreach stlpce as stlpec}
        <div class="col-sm-2">
          <div class="comparator-item-inner" data-column-name="{$stlpec->hodnota}" data-toggle="tooltip" data-placement="bottom" 
               {if !empty(stlpec.poznamka)}
               title="{{produkt.kod_produktu}.{stlpec.poznamka}}"
               {/if}>
            <p>
              {$stlpec->nadpis}:
              <strong >{{produkt.kod_produktu}.{stlpec.hodnota}}</strong>
            </p>
          </div>
        </div>
        {/foreach}
        
        <div class="col-sm-2">
          <div class="comparator-item-inner btn-item-inner">
            {if !empty(produkt.odkaz_ziadost)}
            	<a href="{{produkt.odkaz_ziadost}.url}" class="btn btn-medium main-btn">{$button_mam_zaujem}</a>
            {/if}
            {if !empty(produkt.odkaz_viac)}
            	<a href="{{produkt.odkaz_viac}.url}" class="panel-more-link" >{$label_viac_informacii}<i class="fa fa-caret-right"></i></a>
            {/if}
          </div>
        </div>
      </div>
     
  </div>
  <script> /*skrytie/odkrytie akcie */
  var dnes = Math.floor(Date.now() / 1000);
  $("#{produkt.kod_produktu}-akcia-panel").hide();
  
  if(parseInt("{{produkt.kod_produktu}.platnost_akcie}") > dnes)
  {
    $("#{produkt.kod_produktu}-akcia-panel").show();
    $("#{produkt.kod_produktu}-item").addClass("comparator-akcia-{lang}");
    $("#{produkt.kod_produktu}-item").removeClass("comparator-none");
  }
</script>
  {/foreach}
</div> 
<!--comparator -->
  <div class="loader"><i class="fa fa-spinner fa-pulse"></i></div>
</div>
<!--comparator wrapper -->
<script> <!--otvaranie/zatvaranie -->
  $(function(){
    $('.panel-more').click(function(e){
      if(!$(e.target).is('.btn-item-inner a.main-btn'))
        $(this).parent().find('.comparator-hidden-content').toggleClass('hidden');
    });
    
    $('.close-content').click(function(){
      $(this).parents('.comparator-hidden-content').addClass('hidden');
    });
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

<script> <!--sirka stlpcov podla ich poctu -->
  var polozky = $(".panel-more").children();
  var pocetRadov = $(".panel-more").length;
  
  var sirka = 100/(polozky.length)*pocetRadov;
  polozky.css("width", sirka +  "%");
  $(".layered-navigation").children().css("width", sirka +  "%");
</script>

<script>
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<!--skrytie tlacidiel pri produktoch bez spoluprace -->
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
     // if($(window).scrollTop()<$('.filter').offset().top)
      	$('.loader').show().delay(1000).fadeOut('fast');
      $('html, body').animate({
       scrollTop: filterElement.offset().top
     },800);
      
      return true;
    }
</script>