<h4>{$nadpis}</h4>
<ul>
  {foreach informacie as informacia}
  <li>{$informacia->label}: {$informacia->text}</li>
  {/foreach}
</ul>