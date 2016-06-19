<?php
// source: /Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_prepared.latte

class Template8fbb09a7e281646fd88c708bfd01f860 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('dca8e3d612', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/products.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/main_file.php";

include "/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_var.php";

$global_header = file_get_contents('/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/portal_header.php');
$global_footer = file_get_contents('/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/portal_footer.php');
$page_header = file_get_contents('/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_header.php');
$page_footer = file_get_contents('/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_footer.php');
$page_sidebar = file_get_contents('/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_sidebar.php');
$page_content = file_get_contents('/Users/MarekHvolka/Sites/cms/frontend/web/cache/sk/portals/hyperfinancie.sk/pages/page87/page_content.php');
$page_master = $page_content . $page_sidebar;
$bootstrap_css = 'http://www.hyperfinance.cz/css/bootstrap.min.css';
$bootstrap_js = 'http://www.hyperfinance.cz/js/bootstrap.min.js';
$jquery = '//code.jquery.com/jquery-1.10.2.min.js';
$font_awesome = 'http://www.hyperfinance.cz/fonts/font-awesome-4.3.0/css/font-awesome.min.css'
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