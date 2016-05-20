<div class="kategorie_box" data-tags-category-attributes="{tags}">
  <h3>{$nadpis}</h3>
  <ul>
    {foreach polozky as polozka}
    <li class="tag-item" id="{$polozka->tag}"><a href="{{polozka.podstranka}.url}">{{polozka.podstranka}.name}</a></li>
    {/foreach}
    {foreach polozky2 as polozka2}
    <li class="amount-item" id="{$polozka2->suma}"><a href="{{polozka2.podstranka}.url}">{{polozka2.podstranka}.name}</a></li>
    {/foreach}
  </ul>
</div>

<script>
  $(function(){
    var attributes = $(".kategorie_box").data("tags-category-attributes").split(',');
    
    var items = $(".kategorie_box ul li.tag-item");
    items.addClass("hidden");
    
    var items = items.filter(function() {          
      for(var i=0; i<attributes.length; i++)
      {
      	if (this.id == attributes[i])
        {
          return true;
        }
      }
      return false;
    });
    items.removeClass("hidden");
    
  });
  
  $(function(){
    var rozsah = "{rozsah_porovnavac}".split("-");
        
    var dolna_hranica = parseInt(rozsah[0].split(" ").join(""));
    var horna_hranica = parseInt(rozsah[1].split(" ").join(""));
    
    var items = $(".kategorie_box ul li.amount-item");
    items.addClass("hidden");
    
    var items = items.filter(function() {          
      
      var amount = parseInt(this.id);

      if (amount >=  dolna_hranica && amount <= horna_hranica)
      {
        return true;
      }
      return false;
    });
    items.removeClass("hidden"); 
  });
</script>