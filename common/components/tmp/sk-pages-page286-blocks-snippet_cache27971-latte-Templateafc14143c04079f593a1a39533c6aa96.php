<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/blocks/snippet_cache27971.latte

class Templateafc14143c04079f593a1a39533c6aa96 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('488bd83e39', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page286/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet28/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->nadpis = '' . $slovnik->caste_otazky . '';
$snippet->otazky = '';
/* Var values  */
$snippet->nadpis = 'Časté otázky v súvislosti s produktom Zuno pôžička';
$snippet->otazky =  array(
'0' => (object) array(
'otazka' => 'Potrebujem pre získanie pôžičky na čokoľvek účet v ZUNO?', 'odpoved' => 'Áno, na tento účet, ktorý získate za 0 €, bude odoslaná pôžička a takisto sa z tohto účtu bude splácať.',), 
'1' => (object) array(
'otazka' => 'Aké sú podmienky, ktoré musím splniť?', 'odpoved' => 'Máte účet v ZUNO a Váš čistý mesačný príjem je aspoň 250 €. Takisto musíte byť zamestnanec, SZČO alebo dôchodca. V inom prípade ZUNO pôžičku neposkytuje.',), 
'2' => (object) array(
'otazka' => 'Čo nasleduje po schválení mojej žiadosti?', 'odpoved' => 'Uzavriete so ZUNO zmluvu, ktorú jednoducho podpíšete pomocou jednorazového SMS kódu. Následne ZUNO prevedie peniaze na účet.',), 
'3' => (object) array(
'otazka' => 'Môžem pôžičku splatiť predčasne?', 'odpoved' => 'Áno, môžete ZUNO požiadať o úplné predčasné splatenie, prípadne o čiastočné predčasné splatenie pomocou online bankingu.',), 
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