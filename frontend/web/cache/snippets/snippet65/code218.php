<div class="row information-bar">
  <div class="col-sm-4">
    <div class="comparator-item-inner">
      <p>{$slovnik->vedenie_uctu}
        <strong {if !empty($farba_pisma)} style="color:{$farba_pisma}"{/if}>{$vedenie_uctu}</strong>
      </p>
      
      <!-- tooltip otaznik -->
      <a id="vedenie_uctu_tooltip" class="popover-btn" data-toggle="tooltip" title="{$vedenie_uctu_poznamka}" data-placement="bottom"><i class="fa fa-question-circle"></i></a> 
    </div>
      
  </div>
  <div class="col-sm-4">
    <div class="comparator-item-inner">
      <p>{$slovnik->rocny_urok}
        <strong {if !empty($farba_pisma)} style="color:{$farba_pisma}"{/if}>{$urok}</strong>
      </p>
      
      <!-- tooltip otaznik -->
      <!--<a id="urok_tooltip" class="popover-btn" data-toggle="tooltip" title="{$splatnost_poznamka}" data-placement="bottom"><i class="fa fa-question-circle"></i></a> -->
    </div>
  </div>
  <div class="col-sm-4">
    <div class="comparator-item-inner">
      <p>{$slovnik->karta_k_uctu}
        <strong {if !empty($farba_pisma)} style="color:{$farba_pisma}"{/if}>{$karta_k_uctu}</strong>
      </p>
      
      <!-- tooltip otaznik -->
      <!--<a id="urok_tooltip" class="popover-btn" data-toggle="tooltip" title="{$splatnost_poznamka}" data-placement="bottom"><i class="fa fa-question-circle"></i></a> -->
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
  if ((emptyString == "{vedenie_uctu_poznamka}"))
    $("#vedenie_uctu_tooltip").addClass("hidden");
  
</script>

<script>
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
   // $('[data-toggle="popover"]').popover();
})
</script>