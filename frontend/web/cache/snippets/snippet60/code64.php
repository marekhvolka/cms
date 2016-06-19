<h4>{$snippet->nadpis}</h4>
<ul>
  {ifset $snippet->vyska}
  	<li>{$snippet->vyska_label}: {$snippet->vyska}</li>
  {/ifset}
  {ifset $snippet->pocet_splatok}
  	<li>{$snippet->pocet_splatok_label}: {$snippet->pocet_splatok}</li>
  {/ifset}
  {ifset $snippet->splatka}
  	<li>{$snippet->splatka_label}: {$snippet->splatka}</li>
  {/ifset}
  {ifset $snippet->urok}
  	<li>{$snippet->urok_label}: {$snippet->urok}</li>
  {/ifset}
  {ifset $snippet->poplatok}
  	<li>{$snippet->poplatok_label}: {$snippet->poplatok}</li>
  {/ifset}
  {ifset $snippet->rpmn}
  	<li>{$snippet->rpmn_label}: {$snippet->rpmn}</li>
  {/ifset}
  {ifset $celkom}
  	<li>{$snippet->celkom_label}: {$snippet->celkom}</li>
  {/ifset}
  {ifset $snippet->splatnost}
  	<li>{$snippet->splatnost_label}: {$snippet->splatnost}</li>
  {/ifset}
</ul>
<i>{$snippet->platnost}</i>