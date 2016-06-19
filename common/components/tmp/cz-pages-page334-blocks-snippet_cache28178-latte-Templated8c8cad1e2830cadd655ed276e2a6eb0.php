<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page334/blocks/snippet_cache28178.latte

class Templated8c8cad1e2830cadd655ed276e2a6eb0 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('da71b0ea57', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page334/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet54/snippet.php";
/* Snippet values */
/* Var values  */
$snippet->nadpis = '' . $slovnik->stranka_nebola_najdena . '';
$snippet->button_text = '' . $slovnik->navrat_na_hlavnu_stranku . ''
?>
<i class="fa fa-search" style="font-size:100px; color:#e5eaea; float:right; margin:20px 10px 20px 40px;"></i>
<h2><?php echo Latte\Runtime\Filters::escapeHtml($nadpis, ENT_NOQUOTES) ?></h2>

<p>Je nám líto, nemůžeme požadovanou stránku najít. Zkuste prosím stránku aktualizovat (F5) nebo se uistite, jestli Vami zadaná adresa je správna.</p>

<a class="btn btn-default" href="/"><?php echo Latte\Runtime\Filters::escapeHtml($button_text, ENT_NOQUOTES) ?>
</a><?php
}}