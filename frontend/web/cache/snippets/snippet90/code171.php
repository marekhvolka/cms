<div class="product_info" data-tags-attributes="{tags}">
  <h2>{nazov_produktu}</h2>
  <p><b>{$slovnik->vyska_pozicky}</b>: {rozsah_porovnavac}</p>
  <p><b>{$slovnik->splatnost}</b>: {splatnost_porovnavac}</p>
  <p id="urok_info"><b>{$slovnik->rocny_urok}</b>: {urok_porovnavac}*</p>
  <p id="rpsn_info"><b>{$slovnik->rpsn}</b>: {rpsn}*</p>
  <p id="t_11"><b>{$slovnik->bez_rucenia}</b>: <span class="answer"> {$slovnik->nie}</span></p>
  <p id="t_20"><b>{$slovnik->bez_uvedenia_ucelu}</b>: <span class="answer"> {$slovnik->nie}</span></p>
  <p id="t_10"><b>{$slovnik->bez_registra}</b>: <span class="answer"> {$slovnik->nie}</span>*</p>
  {foreach polozky as polozka}
    <p><b>{$polozka->label}</b>: {$polozka->value}</p>
  {/foreach}
  <script>
    var emptyString = "";
    if ((emptyString == "{rpsn}"))
      $("#rpsn_info").addClass("hidden");
    if ((emptyString == "{urok_porovnavac}"))
      $("#urok_info").addClass("hidden");

    var tags = $(".product_info").data("tags-attributes").split(',');
    
    for (var i=0; i<tags.length; i++)
    {
      $("#" + tags[i] + " .answer").html("{slovnik.ano}");
    }

  </script>
  <p>{$info_dole}</p>
</div>