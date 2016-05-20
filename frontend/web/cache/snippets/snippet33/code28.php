<div class="cta-box cta-box-with-note-{$lang}-{$typ_produktu}">
  <h4><span>Dnes {$text} {$slovnik->uz} <span style="display:inline;" class="_applicant_count">87</span> {$slovnik->klientov}.</span>
    {$slovnik->nevahajte_a_pridajte_sa_k_nim_aj_vy}</h4>
  <a class="btn main-btn btn-lg" href="{$button_url}">{$button_text}</a>
</div>
<script>
  getApplicantCount('_applicant_count', '1', '{$max_pocet}', '6', '22');
</script>