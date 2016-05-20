<?php
// source: /Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_prepared.latte

class Templateb5d6b8cdcdb6505df16c506d93b230b3 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('b77a3c9ecb', 'html')
;
//
// main template
//

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/dictionary.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/products.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/portal_var.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_var.php";

include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_header.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_footer.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_sidebar.php";
include "/Users/MarekHvolka/Sites/cms/cms/frontend/web/cache/cz/portals/hyperfinance.cz/pages/page356/page_content.php";
$bootstrap_css = 'http://www.hyperfinance.cz/css/bootstrap.min.css';
$bootstrap_js = 'http://www.hyperfinance.cz/js/bootstrap.min.js'
?>
<!DOCTYPE html>
            <html class="no-js">
            <head>
              <meta charset="utf-8">
              <?php echo Latte\Runtime\Filters::escapeHtml($include_head, ENT_NOQUOTES) ?>

              <title><?php echo Latte\Runtime\Filters::escapeHtml($title, ENT_NOQUOTES) ?></title>
              <?php echo Latte\Runtime\Filters::escapeHtml($bootstrap_css, ENT_NOQUOTES) ?>


              <meta name="description" content="<?php echo Latte\Runtime\Filters::escapeHtml($description, ENT_COMPAT) ?>">
              <?php echo Latte\Runtime\Filters::escapeHtml($color_scheme, ENT_NOQUOTES) ?>

              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <meta http-equiv="X-UA-Compatible" content="IE=edge">
              <link href='http://fonts.googleapis.com/css?family=Open+Sans:700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>

              <?php echo Latte\Runtime\Filters::escapeHtml($bootstrap_js, ENT_NOQUOTES) ?>


              <?php echo Latte\Runtime\Filters::escapeHtml($include_head_end, ENT_NOQUOTES) ?>

            </head>
            <body>
              <?php echo Latte\Runtime\Filters::escapeHtml($include_body, ENT_NOQUOTES) ?>


              <?php echo Latte\Runtime\Filters::escapeHtml($global_header, ENT_NOQUOTES) ?>


                <main>
              <?php echo Latte\Runtime\Filters::escapeHtml($page_header, ENT_NOQUOTES) ?>

                <div class="wrapper"><div class="container"><div class="row">
              <?php echo Latte\Runtime\Filters::escapeHtml($page_content, ENT_NOQUOTES) ?>


              <?php echo Latte\Runtime\Filters::escapeHtml($page_sidebar, ENT_NOQUOTES) ?>

                </div> <!-- row end -->
                </div> <!--container end -->
                </div> <!--wrapper end -->

              <?php echo Latte\Runtime\Filters::escapeHtml($page_footer, ENT_NOQUOTES) ?>

                </main>
              <?php echo Latte\Runtime\Filters::escapeHtml($global_footer, ENT_NOQUOTES) ?>

              <?php echo Latte\Runtime\Filters::escapeHtml($include_body_end, ENT_NOQUOTES) ?>

            </body>
            </html><?php
}}