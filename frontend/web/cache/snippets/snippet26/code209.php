<div class="posledne-zadosti priklady priklady-sidebar">
  <h3>{$nadpis}</h3>
  <div class="clearfix"></div>

<?php $i = 1; ?>
{foreach items as item}
  <div class="item-box">
    <div class="icon icon-small img-container"><img src="{$item->logo}" alt="" /></div>
    <p>
      <strong><span class="person<?php echo $i; ?>_first_name"></span>, {$item->mesto}</strong>, dnes {$slovnik->o} <span class="person<?php echo $i; ?>_time"></span><br />
      {$slovnik->poziadal}<span class="person<?php echo $i; ?>_end"></span> o <strong class="poziadal person<?php echo $i; ?>_amount"></strong>
    </p>
  </div>
  <script>
  	getPerson('person<?php echo $i; ?>', '{dolna_hranica_pozicky}', '{horna_hranica_pozicky}', '{lang}', '{zaokruhlenie}');
	</script>
  {i--}
  <?php $i++; ?>
{/foreach}

</div>