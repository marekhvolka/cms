<div>
  <h2>{$nadpis}</h2>
  <div class="spolocnosti3-boxes">
    {foreach boxiky as boxik}
    <div class="spolocnost-box">
      <h3 {if !empty(boxik.farba_nadpisu)} style="color:{$boxik->farba_nadpisu}" {/if}>{$boxik->nadpis}</h3>
      <div class="img-container">
        <img src="{$boxik->obrazok_spolocnosti}" alt="" />
      </div>
      <a class="link" href="{{boxik.podstranka}.url}">{$slovnik->viac_informacii}</a>
    </div>
    {/foreach}
  </div>
</div>