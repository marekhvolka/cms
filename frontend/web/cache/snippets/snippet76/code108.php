<div class="subcategory-box vyhody" {if !empty($bg_image)} style="background-image: url({$bg_image})"{/if}>
  <h3>{$nadpis}</h3>
  <ul class="list-unstyled">
  	{foreach $links as $link}
    <li><a href="{$link->podstranka->url}">
      {if !empty($link->label_podstranky)}
      	{$link->label_podstranky}
      {else}
      	{$link->podstranka->name}	
      {/if}
      </a></li>
    {/foreach}
  </ul>
  <a class="btn btn-medium main-btn" href="{$button_url}">{$button_text}</a>
</div>