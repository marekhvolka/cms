<div class="car-example wide"> <!-- Car example -->
  <h3>{$nadpis}</h3>
  <div class="car-example-content"> <!-- Car example content -->      
    <div id="carousel-car-example-wide" class="carousel slide" data-ride="carousel">                    
      <div class="carousel-inner" role="listbox">
        {foreach priklady as priklad}   
        <div class="item">
            <div class="car-description-box col-xs-12 col-md-6">
              <img src="{$priklad->obrazok}" alt="{$priklad->nazov_vozidla}" title="{$priklad->nazov_vozidla}" />
              <p class="car-description"><strong>{$priklad->nazov_vozidla}</strong><br />{$priklad->popis_vozidla}</p>
            </div>        
            <div class="example-table col-xs-12 col-md-6">
                <ul id="car-example-tabs" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active pzp" id="table-pzp-tab"><a href="#" id="table-pzp">Zákonné poj.</a></li>
                    <li role="presentation" class="hav" id="table-hav-tab"><a href="#" id="table-hav">Havarijní poj.</a></li>
                </ul> 
                <div class="tab-content">             
                    <div role="tabpanel" class="active" id="table-pzp"> <!-- Table --> 
                        <table class="table table-striped">
                          <thead>
                            <tr class="bg-primary">
                              <td class="first">{$slovnik->poistovna}</td>
                              <td>Cena</td>
                              <td class="last"><strong>{$slovnik->plnenie}</strong></td>
                            </tr>
                          </thead>
                          <tbody>
                            {foreach priklad.zak_poistovne as poistovna}
                            <tr>
                              <td class="border">{$poistovna->nazov}</td>
                              <td>{$poistovna->cena}</td>
                              <td class="last"><strong>{$poistovna->plnenie}</strong></td>          
                            </tr>
                            {/foreach}
                          </tbody>
                        </table>  
                    </div> <!-- / Table -->  
                    <div role="tabpanel" class="hidden" id="table-hav"> <!-- Table --> 
                        <table class="table table-striped">
                            <thead>
                              <tr class="bg-primary">
                                <td class="first">{$slovnik->poistovna}</td>
                                <td>Cena</td>
                                <td class="last"><strong>{$slovnik->spoluucast}</strong></td>
                              </tr>
                            </thead>
                            <tbody>
                              {foreach priklad.hav_poistovne as poistovna}              
                              <tr>
                                <td class="border">{$poistovna->nazov}</td>
                                <td>{$poistovna->cena}</td>
                                <td class="last"><strong>{$poistovna->spoluucast}</strong></td>          
                              </tr>
                              {/foreach}                           
                            </tbody>
                        </table> 
                    </div> <!-- / Table -->    
                </div><!-- / .tab-content -->
            </div>
            <div class="clearfix"><!-- Clear:Both --></div>
            <div class="car-example-buttons">  
            <a href="{{porovnanie_podstranka}.url}" rel="nofollow" class="btn main-btn"><span>{$slovnik->porovnat}</span></a>
          </div>
          <p class="pexample">
            {$poznamka}
          </p>
          <div class="clearfix"><!-- Clear:Both --></div>
        </div> 
        {/foreach}
      </div>
      <!-- Controls -->
      <a class="left carousel-control" href="#carousel-car-example-wide" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-car-example-wide" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
        
    </div>   
  </div> <!-- / Car example content --> 
<script>
    $('#car-example-tabs a').click(function (e) {
      e.preventDefault();
      var tabcontent = $(this).parent().parent().parent().find(".tab-content");
        tabcontent.children().addClass("hidden"); //skryjeme vsetky
        tabcontent.find("#" + $(this).attr("id")).removeClass("hidden").addClass("active");
      $(this).parent().parent().children().removeClass("active");
      $(this).parent().addClass("active");
    });
    $(document).ready(function() {
      $(".carousel-inner").each(function( index ) {
        $(this).children().first().addClass("active"); 
      });
    })    

</script>
    
</div> <!-- / Car example -->  

