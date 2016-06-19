<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/blocks/snippet_cache27701.latte

class Template0a504b67c652d7bcf1a66c0a42b9904e extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('ed0b8e2947', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_var.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/snippets/snippet65/snippet.php";
/* Snippet values */
/* Product type default var values  */
$snippet->farba_pisma = '';
$snippet->nadpis = '' . $slovnik->preco_sa_oplati . ' ' . $product->nazov_produktu . '?';
/* Var values  */
$snippet->nadpis = '' . $slovnik->preco_sa_oplati . ' ' . $product->nazov_produktu . '?'
?>
<div class="row information-bar">
  <div class="col-sm-4">
    <div class="comparator-item-inner">
      <p><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->vyska_pozicky, ENT_NOQUOTES) ?>

        <strong <?php if (!empty($snippet->farba_pisma)) { ?> style="color:<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($snippet->farba_pisma), ENT_COMPAT) ?>
"<?php } ?>><?php echo Latte\Runtime\Filters::escapeHtml($product->rozsah_porovnavac, ENT_NOQUOTES) ?></strong>
      </p>
      
      <!-- tooltip otaznik -->
<?php if (isset($product->rozsah_poznamka)) { ?>
<a id="rozsah_tooltip" class="popover-btn" data-toggle="tooltip" title="<?php echo Latte\Runtime\Filters::escapeHtml($product->rozsah_poznamka, ENT_COMPAT) ?>" data-placement="bottom"><i class="fa fa-question-circle"></i></a>
<?php } ?>
    </div>
      
  </div>
  <div class="col-sm-4">
    <div class="comparator-item-inner">
      <p><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->splatnost, ENT_NOQUOTES) ?>

        <strong <?php if (!empty($snippet->farba_pisma)) { ?> style="color:<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::escapeCss($snippet->farba_pisma), ENT_COMPAT) ?>
"<?php } ?>><?php echo Latte\Runtime\Filters::escapeHtml($product->splatnost_porovnavac, ENT_NOQUOTES) ?></strong>
      </p>
      
      <!-- tooltip otaznik -->
<?php if (isset($product->splatnost_poznamka)) { ?>
<a id="splatnost_tooltip" class="popover-btn" data-toggle="tooltip" title="<?php echo Latte\Runtime\Filters::escapeHtml($product->splatnost_poznamka, ENT_COMPAT) ?>" data-placement="bottom"><i class="fa fa-question-circle"></i></a> 
<?php } ?>
    </div>
  </div>
  <!--<div class="col-sm-3">
    <div class="comparator-item-inner">
      <p><?php echo Latte\Runtime\Filters::escapeHtmlComment($slovnik->schvalovatelnost) ?>

        <strong <?php if (!empty($snippet->farba_pisma)) { ?> style="color:<?php echo Latte\Runtime\Filters::escapeHtmlComment($snippet->farba_pisma) ?>
"<?php } ?>><?php echo Latte\Runtime\Filters::escapeHtmlComment($product->schvalovatelnost) ?> %</strong>
      </p>
    </div>
  </div>-->
  <div class="col-sm-4" itemscope itemtype="http://schema.org/Product">
    <span style="display:none" itemprop="name"><?php echo Latte\Runtime\Filters::escapeHtml($product->nazov_produktu, ENT_NOQUOTES) ?></span>
    <div class="comparator-item-inner" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
      <input type="hidden" class="rating_number" value="<?php echo Latte\Runtime\Filters::escapeHtml($snippet->hodnotenie, ENT_COMPAT) ?>">
      <div class="rating">
      </div>
      <p><?php echo Latte\Runtime\Filters::escapeHtml($slovnik->hodnotenie, ENT_NOQUOTES) ?>
 <?php echo Latte\Runtime\Filters::escapeHtml($slovnik->klientov, ENT_NOQUOTES) ?>

        <b><span itemprop="ratingValue"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->hodnotenie, ENT_NOQUOTES) ?></span>/5</b>
        - <span itemprop="reviewCount"><?php echo Latte\Runtime\Filters::escapeHtml($snippet->hlasujucich, ENT_NOQUOTES) ?>
</span> <?php echo Latte\Runtime\Filters::escapeHtml($slovnik->hlasov, ENT_NOQUOTES) ?>

      </p>     
    </div>
  </div>
</div>

<script><!--hviezdicky pri produktoch -->
  var rating = $(".rating_number");
  for(var i = 0; i < rating.length; i++)
  {
    var pocet_celych = $(rating[i]).val();
    for(var j = 0; j < 5; j++)
    {
      var prazdna = j < pocet_celych ? "" : "-empty";
      $(rating[i]).next(".rating").append("<span class='glyphicon glyphicon-star" + prazdna + "'></span>");
    }
  }
  var emptyString = "";
  if ((emptyString == <?php echo Latte\Runtime\Filters::escapeJs($product->rozsah_poznamka) ?>))
    $("#rozsah_tooltip").addClass("hidden");
  if ((emptyString == <?php echo Latte\Runtime\Filters::escapeJs($product->splatnost_poznamka) ?>))
    $("#splatnost_tooltip").addClass("hidden");
  
</script>

<script>
  $(function () {
  $("[data-toggle='tooltip']").tooltip()
   // $("[data-toggle='popover']").popover();
})
</script><?php
}}