<nav id='main-nav' class='navbar-collapse collapse'>
  <ul>
    {foreach sekcie as sekcia}
    	<li style="background: {$sekcia->bg_color}; color: {$color}; {$sekcia->css_style}" {if empty(sekcia.odkazy)} class="no-child" {/if} >
        <a {if !empty(sekcia.podstranka)} href='{{sekcia.podstranka}.url}' {else} href='javascript:void(0);' {/if} class='{$sekcia->css_class}'>
            {if !empty(sekcia.popisok)}
          	{$sekcia->popisok}
          {else}
          	{{sekcia.podstranka}.name}
          {/if}
        </a>
          {if !empty(sekcia.odkazy)}
            <div class='inner-menu'>
              <ul>
                {foreach sekcia.odkazy as odkaz}
                  <li class="{$odkaz->css-class}">
                    <a href='{{odkaz.podstranka}.url}'>
                    	{if !empty(odkaz.text_odkazu)} {$odkaz->text_odkazu} {else} {{odkaz.podstranka}.name}{/if}
                    </a>
                	</li>
                {/foreach}
              </ul>
            </div>
          {/if}
    	</li>
    {/foreach}
  </ul>
</nav>