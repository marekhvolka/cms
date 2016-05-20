<div class="map">
  <address>{nazov_spolocnosti},{miesto}</address>
	<script>
  	$(document).ready(function(){
  		$(".map address").each(function(){                         
    		var embed ="<iframe width='100%' height='350' frameborder='0' scrolling='no'  marginheight='0' marginwidth='0'   src='https://maps.google.com/maps?&amp;q="+ encodeURIComponent( $(this).text() ) +"&amp;output=embed'></iframe>";
        $(this).html(embed);                      
   		});
		});
	</script>
</div>