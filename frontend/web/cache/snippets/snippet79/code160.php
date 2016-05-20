<div class="sub-menu">
  <ul>
    {foreach polozky as polozka}
    <li><a href="{$polozka->adresa}">{$polozka->nazov}</a></li>
    {/foreach}
    <li>
      <a href="<?php if ($tag != 'bez_spoluprace'): ?>{$ziadost_podstranka}<?php else : ?>{pozicky_porovnavac.url}<?php endif;?>">{$slovnik->online_ziadost}</a>
    </li>
  </ul>
</div>
<script> <!--sirka stlpcov podla ich poctu -->
  var polozky = $(".sub-menu").find("a");
  
  var sirka = 100/(polozky.length);
  polozky.css("width", sirka +  "%");
</script>