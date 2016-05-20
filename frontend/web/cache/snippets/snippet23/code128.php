<div class="akcia akcia-without-image akcia-ziadost">
    <span class="akcia-badge">{$slovnik->akcia}</span>
    <div class="akcia-content">
      <h2>{$nadpis}</h2>
      <div class="text">
        {$text}  
      </div> 
    </div>

  <script>
    var dnes = Math.floor(Date.now() / 1000);
    if({platnost_akcie} > dnes)
    {
      $(".akcia").parent().show();
    }
    else
    {
      var parent = $(".akcia").parent();

      if (parent.children().length > 1)
        $(".akcia").hide();
      else
        parent.hide();
    }
  </script>
</div>