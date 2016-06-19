<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/blocks/snippet_cache27709.latte

class Template553152f5c9b95a3062e8286a49c4931e extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('418e8df8cb', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet28/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->nadpis = '' . $slovnik->caste_otazky . '';
$snippet->otazky = '';
/* Var values  */
$snippet->nadpis = '' . $slovnik->caste_otazky . '';
$snippet->otazky =  array(
'0' => (object) array(
'otazka' => 'Aké pôžičky Provident poskytuje?', 'odpoved' => 'Rýchle, výhodné, bez skrytých poplatkov a obmedzujúcich podmienok. Spoločnosť Provident vychádza klientom v ústrety a poskytuje tie najlepšie služby. Jej cieľom je stať sa Vaším partnerom a finančným poradcom, na ktorého sa môžete kedykoľvek spoľahnúť.',), 
'1' => (object) array(
'otazka' => 'Čo sa stane, ak nemôžem zaplatiť splátku?', 'odpoved' => 'V prípade problémov sa neváhajte na spoločnosť Provident obrátiť. Kontaktujte ktoréhokoľvek poradcu spoločnosti Provident, aby ste mohli spoločne posúdiť Vašu aktuálnu situáciu. Záujmom Providentu je nájsť riešenie, ktoré je výhodné pre obe strany.',), 
'2' => (object) array(
'otazka' => 'Účtuje Provident nejaké poplatky navyše?', 'odpoved' => 'Nie. Provident uprednostňuje priamu a bezprostrednú komunikáciu a klienta vždy oboznámi so všetkými podmienkami, ktoré s pôžičkou súvisia. Neúčtuje žiadne skryté ani dodatočné poplatky.',), 
'3' => (object) array(
'otazka' => 'Chcem pôžičku splatiť skôr. Je to možné?', 'odpoved' => 'Provident vychádza klientom maximálne v ústrety a poskytuje len tie najvýhodnejšie služby.  V prípade záujmu o predčasné splatenie pôžičky spoločnosť kontaktujte a niektorý z poradcov Vás oboznámi s ďalším postupom. ',), 
)
?>
<div class="faq" id="faq">
  <h3><?php echo Latte\Runtime\Filters::escapeHtml($snippet->nadpis, ENT_NOQUOTES) ?></h3>
<?php $iterations = 0; foreach ($snippet->otazky as $polozka) { ?>
  	<div>
      <h4 class="faq-question"><?php echo Latte\Runtime\Filters::escapeHtml($polozka->otazka, ENT_NOQUOTES) ?></h4>
      <div class="faq-answer"><?php echo Latte\Runtime\Filters::escapeHtml($polozka->odpoved, ENT_NOQUOTES) ?></div>
  	</div>
<?php $iterations++; } ?>
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
</script><?php
}}