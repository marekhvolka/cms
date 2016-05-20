<div class="priklady">
  <h3>{$nadpis}</h3>
  {foreach polozky as polozka}
  <div class="item-box">
    <div class="icon icon-small" style="background-color: {$polozka->icon_bg_color};">
      <i class="{$polozka->icon}" style="color: {$polozka->icon_fg_color}"></i>
    </div>
    <div class="geo-content">
    	<h4 class="bigger nopadding">{$polozka->nadpis}</h4>
    	<p class="nopadding">
      	{$polozka->text}
    	</p>
    </div>
    <a class="btn main-btn btn-medium" href="{{polozka.podstranka}.url}">{$polozka->button_text}</a>
    <div class="clearfix"></div>
  </div>
  {/foreach}
</div>