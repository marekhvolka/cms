<div class="benefits-icons">
  
  <ul class="benefits clearfix"> 
  {foreach $zoznam as $vyhoda}
    <li class="benefit">
      <i class="{$vyhoda->ikona}"></i>
      <p>
        {$vyhoda->popis}
      </p>
    </li>
  
	{/foreach}
  </ul>
</div>