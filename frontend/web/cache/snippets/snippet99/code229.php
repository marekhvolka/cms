<div class="company-crossing">
  <ul class="nav nav-tabs">
    {foreach typy as typ}
      <li role="presentation" class="tab-label">
        <a href="#tab_{$typ->id}" data-toggle="tab">{$typ->label}</a>
      </li>
    {/foreach}
  </ul>
  <div class="tab-content">
    {foreach typy as typ}
      <div class="tab-pane" id="tab_{$typ->id}">
        {foreach typ.polozky as polozka}
          <div class="col-sm-4">
            <!--<h4>{{polozka.spolocnost}.nazov_spolocnosti}</h4>-->
            <img src="{{polozka.spolocnost}.logo_medium}">
            <p>
              <strong>{{polozka.spolocnost}.nazov_spolocnosti}</strong>
              <br />
              {{polozka.spolocnost}.ulica}
              <br />
              {{polozka.spolocnost}.mesto}
              <br />
              {if !empty(polozka.podstranka)}
                <a href="{{polozka.podstranka}.url}">{$slovnik->viac_informacii}</a>
              {/if}
            </p>
          </div>
        {/foreach}
        <div class="clearfix"></div>
      </div>
    {/foreach}
  </div>
  <div class="clearfix"></div>

  <script>
    $(".company-crossing .tab-label").first().addClass("active");
    $(".company-crossing .tab-pane").first().addClass("fade active in");
  </script>
</div>