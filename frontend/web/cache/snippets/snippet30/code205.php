<div class="benefits-img main-lp-steps">

    <ul class="benefits clearfix">
      {foreach $kroky as $krok}
      <li>
      <img src="{$krok->obrazok}" alt="" />
      <h3>{$krok->text}</h3>
      <p>
        {$krok->popis}
      </p>
      </li>
      {/foreach}
    </ul>	
</div>