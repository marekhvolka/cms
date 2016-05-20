<div>
  <h2>{$nadpis}</h2>
  <ul class="benefits">
    {foreach $zoznam as $vyhoda}
    <li>
      <h4>{$vyhoda->text}</h4>
      <p>{$vyhoda->popis}</p>
    </li>
    {/foreach}
  </ul>
  <div class="clearfix"></div>
</div>