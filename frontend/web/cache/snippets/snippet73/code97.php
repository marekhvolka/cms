<div class="poistenie-snippet">
{if !empty($ikona)}<i class="{$ikona}"></i>{/if}
<h2>{$nadpis}</h2>
<p>{$text}</p>
<ul class="list-default">
  {foreach $polozky as $polozka}
  <li>{$polozka->text}</li>
  {/foreach}
</ul>
</div>