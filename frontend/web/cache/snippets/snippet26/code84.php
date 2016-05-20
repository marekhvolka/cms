<div class="geo-location">
  <div class="icon icon-middle">
    <i class="fa fa-user"></i>
  </div>
  <div class="geo-content">
    <h4>{$slovnik->posledny_ziadatel}: <strong><span class="person_first_name">Patrik</span> <span class="person_last_name">M.</span>, <span class="person_place"></span></strong></h4>
    <p>
      <span class="person_salut">pán</span> <span class="person_first_name">Patrik</span> dnes {$slovnik->o} <span class="person_time">10:41</span> {$text}. 
    </p>
  </div>
  <a class="btn main-btn btn-default" href="{$button_url}">{$button_text}</a>
  <div class="clearfix"></div>
</div>

<script>
  getPerson('person', '{dolna_hranica_pozicky}', '{horna_hranica_pozicky}', '{lang}', '{zaokruhlenie}');
</script>