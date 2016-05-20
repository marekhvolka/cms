<div class="row information-bar">
  <div class="col-sm-4">
    <div class="comparator-item-inner">
      <p>{$slovnik->vyska_pozicky}
        <strong {if !empty($farba_pisma)} style="color:{$farba_pisma}"{/if}>{$rozsah_porovnavac}</strong>
      </p>
      
      <!-- tooltip otaznik -->
      <a id="rozsah_tooltip" class="popover-btn" data-toggle="tooltip" title="{$rozsah_poznamka}" data-placement="bottom"><i class="fa fa-question-circle"></i></a> 
    </div>
      
  </div>
  <div class="col-sm-4">
    <div class="comparator-item-inner">
      <p>{$slovnik->splatnost}
        <strong {if !empty($farba_pisma)} style="color:{$farba_pisma}"{/if}>{$splatnost_porovnavac}</strong>
      </p>
      
      <!-- tooltip otaznik -->
      <a id="splatnost_tooltip" class="popover-btn" data-toggle="tooltip" title="{$splatnost_poznamka}" data-placement="bottom"><i class="fa fa-question-circle"></i></a> 
    </div>
  </div>
  <!--<div class="col-sm-3">
    <div class="comparator-item-inner">
      <p>{$slovnik->schvalovatelnost}
        <strong {if !empty($farba_pisma)} style="color:{$farba_pisma}"{/if}>{$schvalovatelnost} %</strong>
      </p>
    </div>
  </div>-->
  <div class="col-sm-4" itemscope itemtype="http://schema.org/Product">
    <span style="display:none" itemprop="name">{$nazov_produktu}</span>
    <div class="comparator-item-inner" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
      <input type="hidden" class="rating_number" value="{$hodnotenie}" />
      <div class="rating">
      </div>
      <p>{$slovnik->hodnotenie} {$slovnik->klientov} 
        <b><span itemprop="ratingValue">{$hodnotenie}</span>/5</b>
        - <span itemprop="reviewCount">{$hlasujucich}</span> {$slovnik->hlasov}
      </p>     
    </div>
  </div>
</div>

<script><!--hviezdicky pri produktoch -->
  var rating = $(".rating_number");
  for(var i = 0; i < rating.length; i++)
  {
    var pocet_celych = $(rating[i]).val();
    for(var j = 0; j < 5; j++)
    {
      var prazdna = j < pocet_celych ? '' : '-empty';
      $(rating[i]).next('.rating').append('<span class="glyphicon glyphicon-star' + prazdna + '"></span>');
    }
  }
  var emptyString = "";
  if ((emptyString == "{rozsah_poznamka}"))
    $("#rozsah_tooltip").addClass("hidden");
  if ((emptyString == "{splatnost_poznamka}"))
    $("#splatnost_tooltip").addClass("hidden");
  
</script>

<script>
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
   // $('[data-toggle="popover"]').popover();
})
</script>