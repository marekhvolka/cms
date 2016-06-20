<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/snippets/portal_snippet_cache27719.latte

class Template80f0d46a55320e6c234c3439e47ced95 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('98276eb785', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/portal_var.php"; 
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet79/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = 'Menu';
$snippet->polozky =  array(
'0' => (object) array(
'nazov' => 'Informácie o produkte', 'kotva' => '', 'adresa' => '',), 
'1' => (object) array(
'nazov' => 'Časté otázky', 'kotva' => '', 'adresa' => 'caste-otazky/',), 
'2' => (object) array(
'nazov' => 'Recenzia produktu', 'kotva' => '', 'adresa' => 'recenzia/',), 
);
$snippet->ziadost_podstranka = '' . $portal->ziadost_url . '/'
?>
<div class="sub-menu">
  <ul>
<?php $iterations = 0; foreach ($snippet->polozky as $polozka) { ?>
    <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($polozka->adresa), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($polozka->nazov, ENT_NOQUOTES) ?></a></li>
<?php $iterations++; } ?>
    <li>
      <a href="<?php if ($snippet->tag != 'bez_spoluprace'): echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($snippet->ziadost_podstranka), ENT_COMPAT) ;else : echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($portal->pozicky_porovnavac->url), ENT_COMPAT) ;endif?>
"><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->online_ziadost, ENT_NOQUOTES) ?></a>
    </li>
  </ul>
</div>
<script> <!--sirka stlpcov podla ich poctu -->
  var polozky = $(".sub-menu").find("a");
  
  var sirka = 100/(polozky.length);
  polozky.css("width", sirka +  "%");
</script><?php
}}