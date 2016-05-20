<?php 
$domain = 'hyperfinance.cz';
$name = 'HyperFinance.cz';
$lang = 'cz';
$currency = 'Kč';
$color_scheme = 'http://www.hyperfinance.cz/template/hyperfinancie.sk_hlavna_sablona/css/public/blue.css';
$include_head = '<!-- VWO-->
<!-- Start Visual Website Optimizer Asynchronous Code -->
<script type=\'text/javascript\'>
var _vwo_code=(function(){
var account_id=64425,
settings_tolerance=2000,
library_tolerance=2500,
use_existing_jquery=false,
// DO NOT EDIT BELOW THIS LINE
f=false,d=document;return{use_existing_jquery:function(){return use_existing_jquery;},library_tolerance:function(){return library_tolerance;},finish:function(){if(!f){f=true;var a=d.getElementById(\'_vis_opt_path_hides\');if(a)a.parentNode.removeChild(a);}},finished:function(){return f;},load:function(a){var b=d.createElement(\'script\');b.src=a;b.type=\'text/javascript\';b.innerText;b.onerror=function(){_vwo_code.finish();};d.getElementsByTagName(\'head\')[0].appendChild(b);},init:function(){settings_timer=setTimeout(\'_vwo_code.finish()\',settings_tolerance);this.load(\'//dev.visualwebsiteoptimizer.com/j.php?a=\'+account_id+\'&u=\'+encodeURIComponent(d.URL)+\'&r=\'+Math.random());var a=d.createElement(\'style\'),b=\'body{opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;}\',h=d.getElementsByTagName(\'head\')[0];a.setAttribute(\'id\',\'_vis_opt_path_hides\');a.setAttribute(\'type\',\'text/css\');if(a.styleSheet)a.styleSheet.cssText=b;else a.appendChild(d.createTextNode(b));h.appendChild(a);return settings_timer;}};}());_vwo_settings_timer=_vwo_code.init();
</script>
<!-- End Visual Website Optimizer Asynchronous Code -->
<!-- VWOEND -->
';
$include_head_end = '<!-- Hyperia tracker-->
<script type=\"text/javascript\" src=\"http://hyperpartner.cz/js/jquery.hyperia.tracker.js?v=0.1\"></script>
<script type=\"text/javascript\">
	(function(window) {
		window.tracker.track(\'pageView\');
	}(window));
</script>
<!-- Hyperia trackerEND -->
<!-- Favicon-->
<link rel=\"shortcut icon\" href=\"/portal/hyperfinance.cz/images/favicon-32x32.png\">
<!-- FaviconEND -->
<!-- Webmaster Tools-->
<meta name=\"google-site-verification\" content=\"rV2hsrqGFdP4PGcSUvLdO5AQvAbQYPjDMKB6QSrT0tc\" />
<!-- Webmaster ToolsEND -->
';
$include_body = '';
$include_body_end = '<!-- Google Tag Manager-->
<!-- Google Tag Manager -->
<noscript><iframe src=\"//www.googletagmanager.com/ns.html?id=GTM-MFV59B\"
height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
\'//www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,\'script\',\'dataLayer\',\'GTM-MFV59B\');</script>
<!-- End Google Tag Manager -->
<!-- Google Tag ManagerEND -->
<!-- Navbar toggle event-->
<script>
$(function(){
    $(\'.navbar-toggle\').click(function(event){
      event.preventDefault();
    });
  });
</script>
<!-- Navbar toggle eventEND -->
';
$portal_header = '';
$portal_footer = '';
?>