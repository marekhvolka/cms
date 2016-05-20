<div class="vyhody">
  <a id="vyhody"></a>
  <h3>{$nadpis}</h3>
  <ul class="vyhody">
    {foreach $zoznam as $vyhoda}
    <li>{$vyhoda->text}</li>
    {/foreach}
  </ul>
  <div class="clearfix"></div>
</div>
{$slovnik->akcia}