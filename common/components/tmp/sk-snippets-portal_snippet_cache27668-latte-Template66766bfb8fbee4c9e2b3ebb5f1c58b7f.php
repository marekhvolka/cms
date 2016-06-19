<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/snippets/portal_snippet_cache27668.latte

class Template66766bfb8fbee4c9e2b3ebb5f1c58b7f extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('e83e73c1ed', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/portal_var.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet38/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->kroky =  array(
'0' => (object) array(
'text' => 'Vyplňte žiadosť', 'ikona' => 'glyphicon glyphicon-pencil',), 
'1' => (object) array(
'text' => 'Budete kontaktovaný', 'ikona' => 'fa fa-phone',), 
'2' => (object) array(
'text' => 'Peniaze sú Vaše', 'ikona' => 'glyphicon glyphicon-ok',), 
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