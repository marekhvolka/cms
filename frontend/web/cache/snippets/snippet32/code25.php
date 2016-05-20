<div class="table-container table-responsive" id="tabulka">
  <h2>{$nadpis}</h2>
  <table class="table table-striped">
    <thead>
      <tr class="bg-primary">
        <th>{$slovnik->vyska_pozicky}</th>
        {foreach priklady as priklad}
        	<th>{$priklad->vyska}</th>
        {/foreach}
      </tr>
    </thead>
    <?php if (!empty($priklady[0]["pocet_splatok"])) : ?>
      <tr>
        <td>{$pocet_splatok_label}</td>
        {foreach priklady as priklad}
          <td>{$priklad->pocet_splatok}</td>
        {/foreach}
      </tr>
    <?php endif; ?>
    <?php if (!empty($priklady[0]["splatka"])) : ?>
      <tr>
        <td>{$splatka_label}</td>
        {foreach priklady as priklad}
          <td>{$priklad->splatka}</td>
        {/foreach}
      </tr>
    <?php endif; ?>
    <?php if (!empty($priklady[0]["urok"])) : ?>
      <tr>
        <td>{$urok_label}</td>
        {foreach priklady as priklad}
          <td>{$priklad->urok}</td>
        {/foreach}
      </tr>
    <?php endif; ?>
    <?php if (!empty($priklady[0]["poplatok"])) : ?>
      <tr>
        <td>{$poplatok_label}</td>
        {foreach priklady as priklad}
          <td>{$priklad->poplatok}</td>
        {/foreach}
      </tr>
    <?php endif; ?>
    <?php if (!empty($priklady[0]["rpmn"])) : ?>
      <tr>
        <td>{$rpmn_label}</td>
        {foreach priklady as priklad}
          <td>{$priklad->rpmn}</td>
        {/foreach}
      </tr>
    <?php endif; ?>
    <?php if (!empty($priklady[0]["celkom"])) : ?>
      <tr>
        <td class="bg-success">{$celkom_label}</td>
        {foreach priklady as priklad}
        <td class="bg-success">{$priklad->celkom}</td>
        {/foreach}
      </tr>
    <?php endif; ?>
    <?php if (!empty($priklady[0]["splatnost"])) : ?>
      <tr>
        <td>{$splatnost_label}</td>
        {foreach priklady as priklad}
          <td>{$priklad->splatnost}</td>
        {/foreach}
      </tr>
    <?php endif; ?>
  </table>
  <p class="table-info">{$platnost}</p>
  <a class="btn btn-medium main-btn" href="{$button_url}">{$button_text}</a>
  <div class="clearfix"></div>
</div>