<div class="posledne-zadosti priklady priklady-sidebar">
  <div class="pozadali-zadost">
    <h3>Dnes {$text2} {$slovnik->uz} <strong><span style="display:inline;" class="_applicant_count">87</span> {$slovnik->klientov}</strong>.</h3>
    <p>{$slovnik->nevahajte_a_pridajte_sa_k_nim_aj_vy}</p>
  </div>

<?php $i = 1; ?>
{foreach items as item}
  <div class="item-box">
    <div class="icon icon-small"><i class="{$item->ikona}"></i></div>
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

<script>
  getApplicantCount('_applicant_count', '1', '{max_pocet}', '6', '22');
</script>