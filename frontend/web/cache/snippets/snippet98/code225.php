<div class="poster poster-big" style="color:#fff" id="big-header">
  <div class="poster-content pull-left" style="color : {$text-color}">
	  <div class="main-box">
        <h1>{$nadpis}</h1>
        <h3>{$podnadpis}</h3>
        <ul>
          {foreach odrazky as odrazka}
          <li>{$odrazka->text}</li>
          {/foreach}
        </ul>
        <div class="actions">
          <a class="btn main-btn btn-xl" href="{$button_url}">{$button_text}</a> 
        </div>  
	  
        <div class="geo">
          <h4>{$slovnik->posledny_ziadatel}: <strong><span class="person_first_name">Miroslav </span> <span class="person_last_name">D.</span>, <span class="person_place"></span></strong></h4>
          <p>
            <span class="person_salut"></span> <span class="person_first_name">Miroslav </span> <span class="person_last_name">D.</span> dnes {$slovnik->o} <span class="person_cas">12:54</span> {$text} 
          </p>
          <div class="stars">
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
          </div>
        </div>   
       </div>
  </div>
  <div>
    <img src="{logo_medium}" />
  </div>
  <div class="clearfix"></div>
  <script>
    getPerson('person', '{dolna_hranica_pozicky}', '{horna_hranica_pozicky}', '{lang}', '{zaokruhlenie}');
  </script>
</div>