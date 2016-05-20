<div class="table-container">
  <table class="table table-striped">
    <thead>
      <tr class="bg-primary">
        <th>Objem v cm3</th>
        <th>{$slovnik->bezna_cena}</th>
        <th>{$slovnik->cena_s_bonusom}</th>
        <th>{$slovnik->maximalna_cena}</th>
        <th>{$slovnik->uspora}</th>    
      </tr>
    </thead>
    <tbody>
    	{foreach priklady as priklad}
      	<tr>
          <td>{$priklad->objem}</td>
          <td>{$priklad->bezna_cena}</td>
          <td>{$priklad->cena_s_bonusom}</td>
          <td>{$priklad->maximalna_cena}</td>
          <td class="bg-success">{$priklad->uspora}</td>          
      	</tr>  
      {/foreach}
    </tbody>
  </table>
</div>