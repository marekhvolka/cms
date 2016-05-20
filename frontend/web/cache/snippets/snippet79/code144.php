<h3>{$nadpis}</h3>
<ul>
  {foreach polozky as polozka}
  <li><a href="#{$polozka->kotva}">{$polozka->nazov}</a></li>
  {/foreach}
</ul>