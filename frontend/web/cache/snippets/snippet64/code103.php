<div class="priklady priklady-sidebar">
  <h3>{$nadpis}</h3>
  {foreach polozky as polozka}
  <div class="item-box">
    <a href="{{polozka.podstranka}.url}">
    <div class="icon icon-small" style="background-color: {$polozka->icon_bg_color};">
      <i class="{$polozka->icon}" style="color: {$polozka->icon_fg_color}"></i>
    </div>
    <div class="geo-content">
    	<h4 class="bigger nopadding">{$polozka->nadpis}</h4>
    	<p class="nopadding">
      	{$polozka->text}
    	</p>
    </div>
    <span class="btn arrow-btn"><i class="fa fa-angle-double-right"></i></span>
    <div class="clearfix"></div>
    </a>
  </div>
  {/foreach}
</div>