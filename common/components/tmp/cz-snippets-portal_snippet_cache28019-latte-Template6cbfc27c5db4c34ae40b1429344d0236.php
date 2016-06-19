<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/snippets/portal_snippet_cache28019.latte

class Template6cbfc27c5db4c34ae40b1429344d0236 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('55b3850f19', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet38/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->kroky =  array(
'0' => (object) array(
'text' => 'Vyplnte žádost', 'ikona' => 'glyphicon glyphicon-pencil',), 
'1' => (object) array(
'text' => 'Budete kontaktováni', 'ikona' => 'fa fa-phone',), 
'2' => (object) array(
'text' => 'Peníze jsou Vaše', 'ikona' => 'glyphicon glyphicon-ok',), 
)
?>
<div class="ziadost_postup">
  <ol id="zoznam">
<?php $iterations = 0; foreach ($snippet->kroky as $krok) { ?>
    <li>
      <div class="step_content">
        <span class="<?php echo Latte\Runtime\Filters::escapeHtml($krok->ikona, ENT_COMPAT) ?>"></span> 
        <?php echo Latte\Runtime\Filters::escapeHtml($krok->text, ENT_NOQUOTES) ?>

      </div>
    </li>
<?php $iterations++; } ?>
  </ol> 
  <div class="clearfix"></div> 
</div>
<script>
  var polozky = $("ol#zoznam").children();
  var sirka = 100/(polozky.length);
  polozky.css("width", sirka + "%");
</script><?php
}}