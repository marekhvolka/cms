<div class="ziadost_postup">
  <ol id="zoznam">
    {foreach kroky as krok}
    <li>
      <div class="step_content">
        <span class="{$krok->ikona}"></span> 
        {$krok->text}
      </div>
    </li>
    {/foreach}
  </ol> 
  <div class="clearfix"></div> 
</div>
<script>
  var polozky = $("ol#zoznam").children();
  var sirka = 100/(polozky.length);
  polozky.css("width", sirka + "%");
</script>