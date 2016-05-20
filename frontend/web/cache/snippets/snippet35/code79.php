<nav id='main-nav' class='navbar-collapse collapse'>
  <ul>
    {foreach sekcie as sekcia}
    	<li style="background: {$sekcia->bg_color}; color: {$color}; {$sekcia->css_style}" {if empty(sekcia.podsekcie)} class="no-child" {/if} >
        <a href='{{sekcia.podstranka}.url}' class='{$sekcia->css_class}'>
          {if !empty(sekcia.popisok)}
          	{$sekcia->popisok}
          {else}
          	{{sekcia.podstranka}.name}
          {/if}
        </a>
        {if !empty(sekcia.podsekcie)}
          <div class='inner-menu'>
              {foreach sekcia.podsekcie as podsekcia}
                <div class="inner-menu-subsection">
                  {if !empty(podsekcia.podstranka)} 
                  	<h4>
                  		<a href="{{podsekcia.podstranka}.url}">
                        {if !empty(podsekcia.popisok)}
                        	{$podsekcia->popisok}
                        {else}
                        	{{podsekcia.podstranka}.name}
                        {/if}
                      </a>
                  	</h4>
                  {/if}
                  <ul>
                  {foreach podsekcia.odkazy as odkaz}
                    <li class="{$odkaz->css_class}">
                      <a href='{{odkaz.podstranka}.url}'>
                        {if !empty(odkaz.text_odkazu)} {$odkaz->text_odkazu} {else} {{odkaz.podstranka}.name}{/if}
                      </a>
                    </li>
                  {/foreach}
                  </ul>
              	</div>
              {/foreach}
            
          </div>
        <div class="clearfix"></div>
        {/if}
    	</li>
    {/foreach}
  </ul>
</nav>
<script>
$(".inner-menu").each(function() 
{
  var count = $(this).children().size();
  $(this).children().each(function() {
	$(this).css("width",100.0/count + "%"); 
  });
});
</script>