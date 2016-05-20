<div class="">
  <h2>{$nadpis}</h2>
  <img src="{logo_medium}" class="inline-image" title="{nazov_spolocnosti}" alt="{nazov_spolocnosti}">
  <p>
    {$text}
  </p>
  {if !empty(podstranka_viac)}
  	<a href="{{podstranka_viac}.url}">{$slovnik->viac_informacii}</a>
  {/if}
</div>