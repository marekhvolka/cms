<ul>
  {foreach produkty as produkt}
  <li><a href="{{produkt.podstranka}.url}">{{produkt.podstranka}.name}</a></li>
  {/foreach}
</ul>
<ul>
  {foreach vseobecne as vseobecna}
  <li><a href="{{vseobecna.podstranka}.url}">{{vseobecna.podstranka}.name}</a></li>
  {/foreach}
</ul>