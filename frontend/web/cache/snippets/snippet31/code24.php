<h2>{$nadpis}</h2>
<p>{$popis-paragraph}</p>
<div class="sub-categories">
  {foreach kategorie as kategoria}
	<div class="col-md-4 col-sm-4 sub-cat">
        <a href="{{kategoria.podstranka}.url}"><img src="{$kategoria->obrazok}" alt="" /></a>
        <h3>{$kategoria->nadpis}</h3>
        <p>{$kategoria->popis-kategorie}</p>
        <a class="btn btn-link" href="{{kategoria.podstranka}.url}">{$kategoria->text-linku}</a>
     </div>
  {/foreach}  
</div>