<div class="partners partners-slider">
  <div class="partners-slider-container clearfix">
  {foreach polozky as polozka}
  	<div>
    {if !empty(polozka.podstranka)}
  			<a href="{{polozka.podstranka}.url}">{/if}<img src="{{polozka.partner}.logo_medium}" alt="{{polozka.partner}.nazov_spolocnosti}" />
    {if !empty(polozka.podstranka)}</a>{/if}
    </div>
  {/foreach}
  </div>
</div>

<link rel="stylesheet" type="text/css" href="/template/hyperfinancie.sk_hlavna_sablona/css/slick-slider/slick.css"/>
<script type="text/javascript" src="/template/hyperfinancie.sk_hlavna_sablona/css/slick-slider/slick.min.js"></script>

<script>
$(function(){
  $('.partners-slider-container').slick({
		autoplay:true,
    autoplaySpeed:4000,
  	infinite: true,
  	speed: 300,
 		slidesToShow: 5,
 	 	centerMode: false,
  	variableWidth: true
  })
});
</script>