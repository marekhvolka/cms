<div class="kroky kroky-desc">
  <h3>{$nadpis}</h3>
  <ol>
    {foreach $kroky as $krok}
    {if !empty(krok->icon)}<i class="{$krok->icon}"> </i>{/if}
    <li>
      <h4>{$krok->text}</h4>
      <p>{$krok->popis}</p>
    </li>
    {/foreach}
  </ol>
</div>