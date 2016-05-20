<div class="benefits-img">
  <h2>{$nadpis}</h2>
    <ul class="benefits clearfix">
      {foreach $zoznam as $vyhoda}
      <li>
      <img src="{$vyhoda->obrazok}" alt="" />
      <h3>{$vyhoda->text}</h3>
      <p>
        {$vyhoda->popis}
      </p>
      </li>
      {/foreach}
    </ul>
</div>