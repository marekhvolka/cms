<h4>{$nadpis}</h4>
<ul>
  {ifset $vyska}
  	<li>{$vyska_label}: {$vyska}</li>
  {/ifset}
  {ifset $pocet_splatok}
  	<li>{$pocet_splatok_label}: {$pocet_splatok}</li>
  {/ifset}
  {ifset $splatka}
  	<li>{$splatka_label}: {$splatka}</li>
  {/ifset}
  {ifset $urok}
  	<li>{$urok_label}: {$urok}</li>
  {/ifset}
  {ifset $poplatok}
  	<li>{$poplatok_label}: {$poplatok}</li>
  {/ifset}
  {ifset $rpmn}
  	<li>{$rpmn_label}: {$rpmn}</li>
  {/ifset}
  {ifset $celkom}
  	<li>{$celkom_label}: {$celkom}</li>
  {/ifset}
  {ifset $splatnost}
  	<li>{$splatnost_label}: {$splatnost}</li>
  {/ifset}
</ul>
<i>{$platnost}</i>