<div class="comparator-wrapper">
<!--navigacia - zoradovanie atd -->
  <div class="layered-navigation">
    <div class="col-sm-2">
      <div class="layer-label">
        <p>Počet {$slovnik->ponuk} : <span id="count">{$produkty->count}</span> </p>
      </div>
    </div>
    {foreach $stlpce as $stlpec}
    <div class="col-sm-2 col-xs-3">
      <div class="layer-content" data-column-name="{$stlpec->hodnota}">
        <p>{$stlpec->nadpis}</p>
        <!--<a class="control order-asc"><i class="fa fa-caret-up"></i></a>
        <a class="control order-desc"><i class="fa fa-caret-down"></i></a>-->
      </div>
    </div>
    {/foreach}
    <div class="clearfix"></div>
  </div>
  <!--navigacia -->
  <!--comparator-->
  <div class="comparator">
    {foreach $produkty as $produkt}
      <div class="comparator-item panel comparator-{$produkt->flag} {$produkt->odkaz_viac}" id="{$produkt->kod_produktu}-item"
           data-tags-filter-attributes="{$produkt->kod_produktu->tags}" data-amount-filter-attributes="{$produkt->kod_produktu->rozsah_porovnavac}">
        <script>
          $(document).ready(function()
          {
            if($produkt->odkaz_viac->isPublic == 0)
            {
              $(".{$produkt->odkaz_viac}").remove();
            }
          });
        </script>
        <div class="row panel-more"> <!--hlavny riadok, ktory je vzdy viditelny -->
          <div class="col-sm-2">
            <div class="comparator-item-inner">
              <div class="comparator-img">
                <img src="{$produkt->kod_produktu->logo_small}" alt="" />
              </div>
              <p class="product-label">{$produkt->kod_produktu->nazov_produktu}</p>
              <input type="hidden" class="rating_number" value="{$produkt->kod_produktu->rating}" />
              <div class="comparator-rating">

              </div>
            </div>
          </div>
          {foreach $stlpce as $stlpec}
          <div class="col-sm-2">
            <div class="comparator-item-inner" data-column-name="{$stlpec->hodnota}">
              <p>
                {$stlpec->nadpis}:
                <strong >{$produkt->kod_produktu[$stlpec->hodnota]}</strong>
              </p>
              <!-- tooltip otaznik -->
              {if !empty($stlpec->poznamka)} 
                <a id="{$stlpec->hodnota}_tooltip" class="popover-btn" data-toggle="tooltip" title="{$produkt->kod_produktu[$stlpec->poznamka]}" data-placement="bottom">
                  <i class="fa fa-question-circle"></i>
                </a> 
              {/if}

              <script>
                var a = "";
                if (a == {$produkt->kod_produktu[$stlpec->poznamka]}){
                  $("#{$produkt->kod_produktu}-item #{$stlpec->hodnota}_tooltip").addClass("hidden");
                }

              </script>
            </div>
          </div>
          {/foreach}

          <div class="col-sm-2">
            <div class="comparator-item-inner btn-item-inner">
              {if !empty($produkt->odkaz_ziadost)} 
                <a href="{$produkt->odkaz_ziadost->url}" class="btn btn-medium main-btn">{$button_mam_zaujem}</a>
              {/if}
              <a class="panel-more-link" >{$label_viac_informacii}<i class="fa fa-caret-down"></i></a>
            </div>
          </div>
        </div>
        <div class="row comparator-hidden-content hidden">
          <div class="col-sm-12">
            <div class="comparator-heading">
              <h3>{$produkt->kod_produktu->nazov_produktu}</h3>
              <a class="comparator-content-links close-content">{$label_zatvorit_detail} <i class="fa fa-times-circle"></i></a>
              {if !empty($produkt->odkaz_viac)} 
                <a class="comparator-content-links link" href="{$produkt->odkaz_viac->url}">Detail produktu</a>
              {/if}
              <div class="clearfix"></div>
            </div>  
            <div class="comparator-inner-body">
              <a href="{$produkt->odkaz_ziadost->url}" id="{$produkt->kod_produktu}-akcia-panel" class="comparator-akcia-panel">
                <div class="comparator-inner-akcia">
                  <h3>{$produkt->kod_produktu->akcia_headline}</h3>
                </div>
              </a>	
              <div class="row">
                <div class="col-sm-4">
                  <div class="box">
                    <h4>{$informacie_label}</h4>
                    <ul>
                      {foreach $produkt->informacie_zoznam as $informacia}
                      <li>{$informacia->text}</li>
                      {/foreach}
                    </ul>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="box">
                    <h4>{$podmienky_label}</h4>
                    <ul>
                      {foreach $produkt->podmienky_zoznam as $podmienka}
                      <li>{$podmienka->text}</li>
                      {/foreach}
                    </ul>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="box repre">
                    {$produkt->kod_produktu[$priklad]}
                  </div>
                </div>
              </div>
              <div class="row comparator-body-footer">
                <div class="col-sm-8">
                  {if !empty($produkt->klient_text)}<div class="box">
                  <div class="comparator-testimonial">
                    <p class="klient-text">
                      "{$produkt->klient_text}" 
                    </p>
                    <div class="klient-name">
                      <p><strong>{$produkt->klient_meno}</strong></p>
                      <div class="rating">
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star-empty"></span>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  </div> {/if}
                </div>
                <div class="col-sm-4 comparator-body-cta">
                  <div class="box">
                    {if !empty($produkt->odkaz_ziadost)}  
                    <a class="btn btn-xl main-btn" href="{$produkt->odkaz_ziadost->url}">{$button_detail_mam_zaujem}</a> 
                    {/if}
                  </div>      
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <script>/*skrytie/odkrytie akcie */
    var dnes = Math.floor(Date.now() / 1000);
    $("#".{$produkt->kod_produktu} . "-akcia-panel").hide();

    if(parseInt({$produkt->kod_produktu->platnost_akcie}) > dnes)
    {
      $("#{$produkt->kod_produktu}-akcia-panel").show();
      $("#{$produkt->kod_produktu}-item").addClass("comparator-akcia-{$lang}");
      $("#{$produkt->kod_produktu}-item").removeClass("comparator-none");
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
      if(!$(e.target).is('.btn-item-inner a.main-btn')){
         $(this).parent().toggleClass('active-panel');
       	 $(this).parent().find('.comparator-hidden-content').toggleClass('hidden');
      }
    });
    
    $('.close-content').click(function(){
      $(this).parents('.comparator-item').removeClass('active-panel');
      $(this).parents('.comparator-hidden-content').addClass('hidden');
    });
  });
</script>
<script><!--hviezdicky pri produktoch -->
  var rating = $(".rating_number");
  for(var i = 0; i < rating.length; i++)
  {
    var pocet_celych = $(rating[i]).val();
    if (pocet_celych != 0)
    {
      for(var j = 0; j < 5; j++)
      {
        var prazdna = j < pocet_celych ? '' : '-empty';
        $(rating[i]).next('.comparator-rating').append('<span class="glyphicon glyphicon-star' + prazdna + '"></span>');
      }
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
   // $('[data-toggle="popover"]').popover();
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
    //  if($(window).scrollTop()<$('.filter').offset().top)
      	$('.loader').show().delay(1000).fadeOut('fast');
      $('html, body').animate({
       scrollTop: filterElement.offset().top
     },800);
      
      return true;
    }
</script>