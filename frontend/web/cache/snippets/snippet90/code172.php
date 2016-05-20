<div class="product_info" data-tags-attributes="{tags}">
  <h2>{nazov_produktu}</h2>
  <p>{$slovnik->vyska_pozicky}: {rozsah_porovnavac}</p>
  <p>{$slovnik->splatnost}: {splatnost_porovnavac}</p>
  <p id="urok_info">{$slovnik->rocny_urok}: {urok_porovnavac}*</p>
  <p id="rpsn_info">{$slovnik->rpsn}: {rpsn}*</p>
  <p id="t_11">{$slovnik->bez_rucenia}: <span class="answer">{$slovnik->nie}</span></p>
  <p id="t_20">{$slovnik->bez_uvedenia_ucelu}: <span class="answer">{$slovnik->nie}</span></p>
  <p id="t_10">{$slovnik->bez_registra}: <span class="answer">{$slovnik->nie}</span>*</p>
  {foreach polozky as polozka}
    <p>{$polozka->label}:{$polozka->value}</p>
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
</div>