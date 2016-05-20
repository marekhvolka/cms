{if !empty(cielova_url)}
<script>
$(document).ready(function(){

    setTimeout(function(){
        window.location = '{cielova_url}';
    },{cas_sekundy}*1000);
});
</script>
{/if}
<h2>{$nadpis}</h2>
<p>
  {$text}
  {$slovnik->presmerovanie_text} <a href="{$cielova_url}" rel="nofollow" target="_blank">nasledujúci odkaz</a>
</p>