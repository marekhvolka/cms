<div class="vyhody">
  <a id="vyhody"></a>
  <h2>{$nadpis}</h2>
  <ul class="vyhody vyhody-{$pocet_stlpcov_listu}">
    {foreach $zoznam as $vyhoda}
    <li>{$vyhoda->text}</li>
    {/foreach}
  </ul>
  <div class="clearfix"></div>
</div>
{$slovnik->akcia}