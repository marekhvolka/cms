<div class="subcategory-box subcategories-poster" {if !empty($bg_image)} style="background-image: url({$bg_image})"{/if}>
  <h2>{$nadpis}</h2>
  <h3>{$podnadpis}</h3>
  <ul>
  	{foreach $vyhody as $vyhoda}
    <li>
      {$vyhoda->text}
     </li>
    {/foreach}
  </ul>
  <a class="btn main-btn" href="{$button_url}">{$button_text}</a>
</div>