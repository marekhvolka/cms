<div class="information-ul-sidebar">
  <h2>{$nadpis}</h2>
  <ul class="list-unstyled">
    <li class="rozsah" data-toggle="tooltip" data-placement="bottom" title="{$rozsah_poznamka}">{$slovnik->vyska_pozicky} <strong>{$rozsah_porovnavac}</strong></li>
    <li class="splatnost" data-toggle="tooltip" data-placement="bottom" title="{$splatnost_poznamka}">{$slovnik->splatnost} <strong>{$splatnost_porovnavac}</strong></li>
    {foreach $dalsie_vyhody as $vyhoda}
    <li>{$vyhoda->text}</li>
    {/foreach}
  </ul>
</div>