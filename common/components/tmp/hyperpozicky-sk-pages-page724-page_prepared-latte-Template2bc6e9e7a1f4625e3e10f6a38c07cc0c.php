<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/pages/page724/page_prepared.latte

class Template2bc6e9e7a1f4625e3e10f6a38c07cc0c extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('67a57ba9ac', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/pages/page724/page_var.php";

$global_header = executeScript('/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/portal_header.php');
$global_footer = executeScript('/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/portal_footer.php');
$page_header = executeScript('/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/pages/page724/page_header.php');
$page_footer = executeScript('/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/pages/page724/page_footer.php');
$page_sidebar = executeScript('/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/pages/page724/page_sidebar.php');
$page_content = executeScript('/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperpozicky.sk/pages/page724/page_content.php');
$page_master = $page_content . $page_sidebar
?>
<!DOCTYPE html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <?php echo Latte\Runtime\Filters::escapeHtml($include_head, ENT_NOQUOTES) ?>

  <title><?php echo Latte\Runtime\Filters::escapeHtml($page->title, ENT_NOQUOTES) ?></title>
  <link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($bootstrap_css), ENT_COMPAT) ?>" rel="stylesheet" type="text/css">
  <link href="http://www.hyperfinance.cz/css/public/global.css" rel="stylesheet" type="text/css">

  <meta name="description" content="<?php echo Latte\Runtime\Filters::escapeHtml($page->description, ENT_COMPAT) ?>">
  <link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($color_scheme), ENT_COMPAT) ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($font_awesome), ENT_COMPAT) ?>" rel="stylesheet" type="text/css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:700&subset=latin,latin-ext" rel="stylesheet" type="text/css">

  <script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($jquery), ENT_COMPAT) ?>"></script>
  <script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($bootstrap_js), ENT_COMPAT) ?>"></script>
  <?php echo Latte\Runtime\Filters::escapeHtml($include_head_end, ENT_NOQUOTES) ?>

</head>
<body>
<?php echo Latte\Runtime\Filters::escapeHtml($include_body, ENT_NOQUOTES) ?>


<?php echo Latte\Runtime\Filters::escapeHtml($global_header, ENT_NOQUOTES) ?>


<main>
  <?php echo Latte\Runtime\Filters::escapeHtml($page_header, ENT_NOQUOTES) ?>

  <div id="page-content">
    <div class="wrapper"><div class="container"><div class="row">
          <?php echo Latte\Runtime\Filters::escapeHtml($page_content, ENT_NOQUOTES) ?>


          <?php echo Latte\Runtime\Filters::escapeHtml($page_sidebar, ENT_NOQUOTES) ?>

        </div> <!-- row end -->
      </div> <!--container end -->
    </div> <!--wrapper end -->
  </div> <!-- page-content-->
  <?php echo Latte\Runtime\Filters::escapeHtml($page_footer, ENT_NOQUOTES) ?>

</main>
<?php echo Latte\Runtime\Filters::escapeHtml($global_footer, ENT_NOQUOTES) ?>

<?php echo Latte\Runtime\Filters::escapeHtml($include_body_end, ENT_NOQUOTES) ?>

</body>
</html><?php
}}