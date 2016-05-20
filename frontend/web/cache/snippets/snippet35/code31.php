<div class="bottom-menu">
  {foreach sekcie as sekcia}
     <div class="bottom-menu-block"> 
    	<h4>
        <a 
           {if !empty(sekcia.podstranka)} href='{{sekcia.podstranka}.url}' {else} href='javascript:void(0);' {/if}
           ><i class="{sekcia.icon}"></i>
        	{if !empty(sekcia.popisok)}
          	{$sekcia->popisok}
          {else}
          	{{sekcia.podstranka}.name}
          {/if}
        </a>
       </h4>
      <ul>
        {foreach sekcia.odkazy as odkaz}
        	<li><a href="{{odkaz.podstranka}.url}">{{odkaz.podstranka}.name}</a></li>
        {/foreach}
      </ul>
  	</div>
  {/foreach}
</div>


<script>
$(function(){
  /************** rozbalenie footer menu na mobile *********************/
  
    if($(window).width()<768) {
      $('.bottom-menu-block h4').click(function(){
         $(this).parent().find('ul').slideToggle();
      });

    }

})
</script>