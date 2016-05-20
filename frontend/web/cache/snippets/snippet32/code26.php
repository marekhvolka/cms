<div class="table-container table-rows table-responsive" id="tabulka">
  <h2>{$nadpis}</h2>
  <table class="table table-striped table-condensed">
    <thead>
      <tr class="bg-primary"><th>{$vyska_label}</th><th>{$pocet_splatok_label}</th><th>{$splatka_label}</th><th>{$urok_label}</th><th>{$poplatok_label}</th><th>{$rpmn_label}</th><th>{$celkom_label}</th><th>{$splatnost_label}</th></tr>
    </thead>
    {foreach priklady as priklad}
    <tr><td>{$priklad->vyska}</td><td>{$priklad->pocet_splatok}</td><td>{$priklad->splatka}</td><td>{$priklad->urok}</td><td>{$priklad->poplatok}</td><td>{$priklad->rpmn}</td><td class="bg-success">{$priklad->celkom}</td><td>{$priklad->splatnost}</td></tr>
    {/foreach}
  </table>
  <p class="table-info">{$platnost}</p>
  <a class="btn btn-medium main-btn" href="{$button_url}">{$button_text}</a>
  <div class="clearfix"></div>
</div>