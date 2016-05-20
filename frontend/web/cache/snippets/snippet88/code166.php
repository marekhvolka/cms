<div class="vyhody">
  <a id="vyhody"></a>
  <h2>{$nadpis}</h2>
  <ul class="vyhody vyhody-{$pocet_stlpcov_listu}">
    {foreach polozky as polozka}
    <li>{$polozka->text}</li>
    {/foreach}
  </ul>
  <div class="clearfix"></div>
</div>