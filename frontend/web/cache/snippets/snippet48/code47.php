<!--filter -->
<div class="filter">
  <p class="filter-label">{$nadpis}:</p>
 	{foreach tagy as tagItem}
  	<a class="btn btn-default {tagItem.css_class} filter-btn" data-filter-id="{$tagItem->tag}"><span class="{$tagItem->icon}"></span>
      {if !empty(tagItem.label)}
  			{$tagItem->label}
  		{else}
  			{{tagItem.tag}.label}
  		{/if}</a>
  {/foreach}
  
  {if !empty(filter_checkbox)}
    <div class="other-filters">
      {foreach filter_checkbox as filter}
      <div class="checkbox-inline">
        <label ><input type="checkbox" class="filter-checkbox" data-filter-id="{$filter->tag}">
          {if !empty(filter.label)}
  					{$filter->label}
  				{else}
  					{{filter.tag}.label}
  				{/if}
        </label>
      </div>
    {/foreach}
    </div>
  {/if}
  <script>
    $(function(){
      $(".filter-btn").click(function(){

        // animacia loading
        animujPorovnavac($(".filter"));


        $(".filter-btn").removeClass("active"); //zmazeme predchadzajuce aktivne
        var button = $(this);
        button.addClass("active"); //nastavime nove aktivne tlacidlo
        var tagId = button.data("filter-id");

        var elements = $(".comparator-item");
        elements.addClass("hidden-filter");

        if (tagId != "t_all")
        {
          if (tagId == "t_action")
          {
              var elements = elements.filter(".comparator-akcia-{lang}");
          }
          else
          {
            var elements = elements.filter(function() {
              var attributes = $(this).data("tags-filter-attributes").split(',');
              var equals = false;

              for (var i=0; i<attributes.length; i++)
              {
                if (attributes[i] == tagId)
                {
                  equals = true;
                  break;
                }
              }
              return equals;
            });
          }
        }
        elements.removeClass("hidden-filter");

        var count = $(".comparator-item").not("[class*='hidden']").length;
        $("#count").text(count);
      });
      $(".filter-checkbox").click(function(){

        // animacia loading
        animujPorovnavac($(".filter"));

        var button = $(this);

        var tagId = button.data("filter-id");

        var elements = $(".comparator-item");

        if (button.is(":checked"))
        {
          elements.addClass("hidden-" + tagId);

          if (tagId != "t_all")
          {
            if (tagId == "t_action")
            {
                var elements = elements.filter(".comparator-akcia-{lang}");
            }
            else
            {
              var elements = elements.filter(function() {
                var attributes = $(this).data("tags-filter-attributes").split(',');
                var equals = false;

                for (var i=0; i<attributes.length; i++)
                {
                  if (attributes[i] == tagId)
                  {
                    equals = true;
                    break;
                  }
                }
                return equals;
              });
            }
          }
        }

        elements.removeClass("hidden-" + tagId);

        var count = $(".comparator-item").not("[class*='hidden']").length;
        $("#count").text(count);
      });
    });
  </script>
</div>
<!--filter -->