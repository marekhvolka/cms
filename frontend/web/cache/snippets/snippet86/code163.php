<div class="partners">
  {foreach polozky as polozka}
  	{if !empty(polozka.podstranka)}
  			<a href="{{polozka.podstranka}.url}">{/if}<img src="{{polozka.partner}.logo_medium}" alt="{{polozka.partner}.nazov_spolocnosti}" 
         {if !empty(polozka.sirka)}
         width="{$polozka->sirka}"
         {/if}
         {if !empty(polozka.vyska)}
         height="{$polozka->vyska}" 
                                              {/if}/>{if !empty(polozka.podstranka)}</a>{/if}
  {/foreach}
</div>