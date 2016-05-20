<div class="profil-spolocnosti-header">
  <div class="row">
    <div class="col-md-6">
      <div class="profil-image">
        <img src="{logo_big}" alt="{nadpis}">
      </div>
    </div>
    <div class="col-md-6 contact-info">
      <h1>{nadpis}</h1>
      <div class="adresa">
        <p>{ulica}<br/>{mesto}</p>
      </div>
      <div class="adresa-info">
        <ul class="list-unstyled">
          <li><i class="fa fa-fw fa-envelope"></i>{$slovnik->kontaktny} e-mail: <strong><a href="mailto:{e_mail}">{e_mail}</a></strong></li>
          <li><i class="fa fa-fw fa-phone"></i>{$slovnik->telefon}: <strong>{telefon}</strong></li>
          <li id="kod_banky_info"><i class="fa fa-fw fa-key"></i>Kód banky: <strong>{kod_banky}</strong></li>       
					<li id="swift_kod_banky_info"><i class="fa fa-fw fa-key"></i>Swift kód banky: <strong>{swift_kod_banky}</strong></li>
          <li><i class="fa fa-fw fa-external-link"></i>{$slovnik->oficialny_web_spolocnosti}: <strong><a href="http://{web}">{web}</a></strong></li>
        </ul>
      </div>
    </div>
  </div>
</div>  