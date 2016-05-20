<div class="table-container table-responsive" id="tabulka">
  <h2>{$nadpis}</h2>
  <table class="table table-striped">
    <thead>
      <tr class="bg-primary">
        <th>{$ponuka_label}</th>
        {foreach priklady as priklad}
        	<th>{$priklad->ponuka}</th>
        {/foreach}
      </tr>
    </thead>
    <tr>
      <td>{$vyska_label}</td>
      {foreach priklady as priklad}
      <td>{$priklad->vyska}</td>
      {/foreach}
    </tr>
    <tr>
      <?php if (!empty($priklady[0]["pocet_splatok"])) : ?>
        <td>{$pocet_splatok_label}</td>
        {foreach priklady as priklad}
          <td>{$priklad->pocet_splatok}</td>
        {/foreach}
      <?php endif; ?>
    </tr>
    <tr>
      <?php if (!empty($priklady[0]["splatka"])) : ?>
        <td>{$splatka_label}</td>
        {foreach priklady as priklad}
          <td>{$priklad->splatka}</td>
        {/foreach}
      <?php endif; ?>
    </tr>
    <tr>
      <?php if (!empty($priklady[0]["urok"])) : ?>
        <td>{$urok_label}</td>
        {foreach priklady as priklad}
          <td>{$priklad->urok}</td>
        {/foreach}
      <?php endif; ?>
    </tr>
    <tr>
      <?php if (!empty($priklady[0]["poplatok"])) : ?>
        <td>{$poplatok_label}</td>
        {foreach priklady as priklad}
          <td>{$priklad->poplatok}</td>
        {/foreach}
      <?php endif; ?>
    </tr>
    <tr>
      <?php if (!empty($priklady[0]["rpmn"])) : ?>
        <td>{$rpmn_label}</td>
        {foreach priklady as priklad}
          <td>{$priklad->rpmn}</td>
        {/foreach}
      <?php endif; ?>
    </tr>
    <tr>
      <?php if (!empty($priklady[0]["celkom"])) : ?>
        <td>{$celkom_label}</td>
        {foreach priklady as priklad}
        <td>{$priklad->celkom}</td>
        {/foreach}
      <?php endif; ?>
    </tr>
    <tr>
      <?php if (!empty($priklady[0]["celkova_uspora"])) : ?>
      <td class="bg-success"><b>{$celkova_uspora_label}</b></td>
        {foreach priklady as priklad}
      <td class="bg-success"><b>{$priklad->celkova_uspora}</b></td>
        {/foreach}
      <?php endif; ?>
    </tr>
    <tr>
      <?php if (!empty($priklady[0]["splatnost"])) : ?>
        <td>{$splatnost_label}</td>
        {foreach priklady as priklad}
          <td>{$priklad->splatnost}</td>
        {/foreach}
      <?php endif; ?>
    </tr>
  </table>
  <p class="table-info">{$platnost}</p>
  <a class="btn btn-medium main-btn" href="{$button_url}">{$button_text}</a>
  <div class="clearfix"></div>
</div>