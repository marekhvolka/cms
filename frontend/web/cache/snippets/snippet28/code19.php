<div class="faq" id="faq">
  <h3>{$nadpis}</h3>
  {foreach otazky as polozka}
  	<div>
      <h4 class="faq-question">{$polozka->otazka}</h4>
      <div class="faq-answer">{$polozka->odpoved}</div>
  	</div>
  {/foreach}
</div>

<script>
  $(function ()
  {
  	$('.faq-question').click(function() 
    {
      $(this).parent().find(".faq-answer").slideToggle('fast');
    });
    $(document).ready()
    {
      $(".faq-answer").css("display", "none");
    }
  });
</script>