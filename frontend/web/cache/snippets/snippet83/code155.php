<div class="col-sm-4">
  <div class="box">
    <h4>{$slovnik->informacie_o_produkte}</h4>
    <ul>
      {foreach informacie_zoznam as informacia}
      <li>{$informacia->text}</li>
      {/foreach}
    </ul>
  </div>
</div>
<div class="col-sm-4">
  <div class="box">
    <h4>{$slovnik->podmienky_a_doklady}</h4>
    <ul>
      {foreach podmienky_zoznam as podmienka}
      <li>{$podmienka->text}</li>
      {/foreach}
    </ul>
  </div>
</div>