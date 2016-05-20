<?php

// ini_set("display_startup_errors", "1");
// ini_set("display_errors", "1");
// error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');

include_once('../core/phpfunction/settings.php');
include_once('../core/phpfunction/classes/class.lib.php');
include_once('../core/plugins/scss_compiler/sass-compiler.php');
include_once('../core/phpfunction/api/class.pages.php');
include_once('../core/plugins/router/AltoRouter.php');

$server_name = str_replace('www.', '', $_SERVER["SERVER_NAME"]);

if($server_name == 'hyperfinancetest.cz')
{
    $server_name = 'hyperfinance.cz';
}

//$server_name =  'hyperfinancie.sk';


//isset($_SESSION["developPreview"]) && $_SESSION["developPreview"] || isset($_SESSION["portalLivePreview"]) || 

$admin_id      = !empty($_SESSION["idUser"]) ? $_SESSION["idUser"] : '';
$admin_preview = isset($_COOKIE["cookie_hash"]) ? true : false;
$portal        = isset($_SESSION["portalLivePreview"]) ? $_SESSION["portalLivePreview"] : $server_name;
$baseURL       = '/public';

$template = $db->select("SELECT sablona FROM s_template t LEFT JOIN s_portal p ON t.id = p.template WHERE p.domena = ?  ", array($portal), 's');
if(isset($_SESSION["developPreview"]) && $_SESSION["developPreview"])
{
    $sablona = $_SESSION["developTemplate"];
}
else
{
    $sablona = !empty($template[0]["sablona"]) ? $template[0]["sablona"] : '';
}

if(empty($sablona)) die('Portal '.$portal.' nema nastavenu sablonu. Nastavte ju v administracii portalu');
if(empty($portal))  die('Nie je nastaveny portal');
if(empty($baseURL)) die('Nie je nastavena zakladna URL adresa');

$page   = new api_page($db, $portal);
$router = new AltoRouter();

/* naplni portal pre premenne */
$portal_var = $page->portal_public ? $portal : $page->ip_cms;

/**
    HLAVICKA PRE SUBORY
*/

$bootstrap_js  = $page->getHeadBootstrap('js');
$bootstrap_css = $page->getHeadBootstrap('css');
$baseInsert    = $page->getHeadBase($baseURL);

/**
    KONIEC HLAVICKY
*/


//if(isset($_SESSION["portalLivePreview"]))
    //$router->setBasePath($baseURL);

/* Nastavi sa cesta pre sablonu. pouziva sa iba v class.pages.php. Bez koncoveho lomitka */
$page->template_url = 'template/'.$sablona;

/* vytvori mapu pre smerovanie URL podla hlbky stromu*/
for($i=0;$i<$page->pageDepth;$i++){$m='';for($j=0;$j<=$i;$j++){$m.='/[*:level_'.$j.']';}$router->map('GET',$m,'','level_'.$i);}

$match = $router->match();

/**
    DAKOVACKY
*/
if(isset($match["params"]) && $match["params"]["level_0"] == 'thanks')
{
    unset($match["params"]["level_0"]);
    
    $thanks_file = implode('_', $match["params"]);

    if(!file_exists('portal/'.$portal.'/thanks/'.$thanks_file.'.html'))
    {
        $link    = implode('/', $match["params"]);
        $content = '';

        if(file_exists('thanks/'.$link.'.php'))
        {
            $content = file_get_contents('thanks/'.$link.'.php');
            $param   = array(
                '{base_url}'         => $baseInsert,
                '{lang}'             => $page->getLangCode(),
                '{include_head}'     => $page->includeCode('head'),
                '{include_head_end}' => $page->includeCode('head_end'),
                '{include_body}'     => $page->includeCode('body'),
                '{include_body_end}' => $page->includeCode('body_end'),
                '{bootstrap_js}'     => $bootstrap_js,
                '{bootstrap_css}'    => $bootstrap_css,
                '{portal_url}'       => 'http://'.($portal_var != $page->ip_cms ? 'www.' : '').$portal_var,
                '{portal_url_esc}'   => urlencode('http://'.($portal_var != $page->ip_cms ? 'www.' : '').$portal_var),
                '{portal_domain}'    => $portal_var,
                '{template_url}'     => 'http://'.($portal_var != $page->ip_cms ? 'www.' : '').$portal_var.$baseURL.'/'.$page->template_url,
                '{template_url_esc}' => urlencode('http://'.($portal_var != $page->ip_cms ? 'www.' : '').$portal_var.$baseURL.'/'.$page->template_url),
                '{currency}'         => $page->currency
            );

            $content = $page->replaceHeaderVariable($param, $content);

            file_put_contents('portal/'.$portal.'/thanks/'.$thanks_file.'.html', $content);
        }
        else
        {
            echo 'Zvolena dakovacka neexistuje';
        }
    }
    else
    {
        $content = file_get_contents('portal/'.$portal.'/thanks/'.$thanks_file.'.html');
    }

    echo $content;
    
    exit;
}
/**
    KONIEC DAKOVACKY
*/


//$page->getMenu($page->pageTree, 0, array(), $router);
$page->setRouter($router);
$page->generatePageVariable($page->pageTree);
/* Ak nie je ziadna url tak nastavi home page */
if(!isset($match["params"])) $match["params"]['level_0'] = $page->home_url;   

$stranka      = end($match["params"]);
$page->allURL = implode('/', $match["params"]);
array_pop($match["params"]);

/*  Urcenie ci sa ma cacheovat stranka*/
$pageCache = $page->cache && !$page->checkRedirect($stranka, $match["params"]) ? true : false;
if($pageCache && $admin_id != 1)
{
    $cachefile = 'portal/'.$portal.'/cache/'.implode('__', $match["params"]).'__'.$stranka.'.php';
    if(file_exists($cachefile))
    {
        //echo "<!-- ".date('Hi', filemtime($cachefile))." -->\n";

        /* cierny pasik, ktory sa zobrazi iba v nahladovom rezime */
        if($admin_preview)
        {
            $page->getPageBasicInfo($stranka, $match["params"]);

            $black_strip = $page->generateBlackStrip();
            $output      = file_get_contents($cachefile);
            $output      = str_replace('<body>', $black_strip, $output);
            echo $output;
        }
        else
        {
            include($cachefile);
        }
        /* koniec */

        exit;
    }
}
/* Koniec */


$exist = 0;
foreach($match["params"] as $r)
{
    $exist = $page->checkExist($r, $exist);

    if($page->not_found)
    {
        break;
    }
}

if(!$page->not_found)
{
    /* Vytvori zoznam ktory obsahuje informácie o stránke. Ako argument sa vklada id stranky alebo url */
    $page->getPage($stranka, $match["params"]);
    $page->getGlobal();
    /* Koniec */
}


/* Smerovanie na 404 ak neexistuje stranka */
if($page->not_found)
{
    header("HTTP/1.0 404 Not Found");
    $page->getPage('404', $match["params"]);
    $page->getGlobal();
}

/* Nastavi do session utm kampane z ktorej prisiel (mailing PPC reklama a pod) */
$_SESSION["utm_count"] = true;
$time = 3600;
if(isset($_GET["utm_campaign"]) && !empty($_GET["utm_campaign"]))
{
    $_SESSION["utm_campaign"] = $_GET["utm_campaign"];
    $_SESSION["utm_count"]    = false;
}

if(isset($_GET["utm_content"]) && !empty($_GET["utm_content"]))
{
    $_SESSION["utm_content"] = $_GET["utm_content"];
    $_SESSION["utm_count"]   = false;
}

if(isset($_GET["utm_source"]) && !empty($_GET["utm_source"]))
{
    $_SESSION["utm_source"] = $_GET["utm_source"];
    $_SESSION["utm_count"]  = false;
}

/* Ulozi sa povodne UTM do session aby som potom pri presmerovani vedel toto utm, doplnit do URL */
$_SESSION["utm_povodne"] = !empty($match['queryString']) ? $match['queryString'] : '';


/* Ak uz som sa presmeroval tak odstrani povodne UTM. Tym zabranim aby som sa nepresmerovaval stale s tym istym UTM */
if(isset($_SESSION["redirect"]))
{
    if($_SESSION["redirect"]) unset($_SESSION["utm_povodne"]);
}

/* Urci sa presmerovanie */
if(!empty($page->presmerovanie))
{
    $utm = isset($_SESSION["utm_povodne"]) && empty($page->utm) ? $_SESSION["utm_povodne"] : $page->utm;
    $_SESSION["redirect"] = true;

    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$page->presmerovanie.(!empty($utm) ? "/?".$utm : ''));
}
else
{
    $_SESSION["redirect"] = false;
}
/* Koniec */

/* Global header */
$glob_header = $page->generateGlobalHeaderHTML();
/* Koniec header */

/* Global footer */
$glob_footer = $page->generateGlobalFooterHTML();
/* Koniec footer */

/* Obsah */
$obsah = '<main>';

/* Hlavicka */
$obsah .= $page->generateHeaderHTML();
/* Koniec hlavicky */

/* Obsah*/
$obsah .= $page->generateContentHTML();
/* Koniec obsah */

/* Paticka */
$obsah .= $page->generateFooterHTML();
/* Koniec paticky */

$obsah .= '</main>';
/* Koniec obsah */

/* Presmerovanie na affil linku */
if(!$page->embeded_form)
{
    $_SESSION["utm_campaign"] = isset($_SESSION["utm_campaign"]) ? $_SESSION["utm_campaign"] : '';
    $_SESSION["utm_content"]  = isset($_SESSION["utm_content"]) ? $_SESSION["utm_content"] : '';
    $_SESSION["utm_source"]   = isset($_SESSION["utm_source"]) ? $_SESSION["utm_source"] : '';
    $page->generateAffilLink($_SESSION["utm_source"], $_SESSION["utm_campaign"], $_SESSION["utm_content"]);
    
    if(!empty($_SESSION["utm_campaign"]) || !empty($_SESSION["utm_content"]) || !empty($_SESSION["utm_source"]))
    {
        $indTmp = $_SESSION["utm_source"].$_SESSION["utm_campaign"].$_SESSION["utm_content"];
        $redirect_link = array_key_exists($indTmp, $page->campaign_link) ? $page->campaign_link[$indTmp] : $page->campaign_link["default"];
    }
    else
    {
        $redirect_link = !empty($page->campaign_link["default"]) ? $page->campaign_link["default"] : '';
    }

    $redirect_script = !empty($redirect_link) ? '<script>$(document).ready(function(){setTimeout(function(){window.location=\''.$redirect_link.'\';},'.($page->redirect_delay*1000).');});</script>' : '';
    //$redirect_script = '';
}

/* Ked sa presmerujem tak sa vymaze utm_campaign (netusim preco mi nejde ta SESSION. Ako keby sa SESSION vykonala asynchronne od celeho scriptu..ze najskor sa vykona session az potom zvysok) */
// if($_SESSION["utm_count"])
// {
//     unset($_SESSION["utm_campaign"]);
//     unset($_SESSION["utm_source"]);
//     unset($_SESSION["utm_content"]);
// }
//print_r($_SESSION);

/* vlozenie obsahu do premennych */
$param = array(
    '{color_scheme}'     => $page->color_scheme,
    '{base_url}'         => $baseInsert,
    '{global_header}'    => $glob_header,
    '{global_footer}'    => $glob_footer,
    '{master_content}'   => $obsah,
    '{lang}'             => $page->getLangCode(),
    '{include_head}'     => $page->includeCode('head'),
    '{include_head_end}' => $page->includeCode('head_end'),
    '{include_body}'     => $page->includeCode('body'),
    '{include_body_end}' => $page->includeCode('body_end'),
    '{bootstrap_js}'     => $bootstrap_js,
    '{bootstrap_css}'    => $bootstrap_css,
    '{title}'            => $page->seo_title,
    '{description}'      => $page->seo_description,
    '{keywords}'         => $page->seo_keywords,
    '{menu}'             => $page->menu,
    '{logo}'             => '/portal/'.$portal.'/'.$page->logo,
    '</body>'            => (isset($redirect_script) ? $redirect_script : '').'</body>',
    '{portal_url}'       => 'http://'.($portal_var != $page->ip_cms ? 'www.' : '').$portal_var,
    '{portal_url_esc}'   => urlencode('http://'.($portal_var != $page->ip_cms ? 'www.' : '').$portal_var),
    '{portal_domain}'    => $portal_var,
    '{page_name}'        => $page->nazov,
    '{template_url}'     => 'http://'.($portal_var != $page->ip_cms ? 'www.' : '').$portal_var.$baseURL.'/'.$page->template_url,
    '{template_url_esc}' => urlencode('http://'.($portal_var != $page->ip_cms ? 'www.' : '').$portal_var.$baseURL.'/'.$page->template_url),
    '{breadcrumbs}'      => $page->breadcrumbs,
    '{currency}'         => $page->currency
);

$index = $page->replaceGlobalVariable($param, $sablona);
/* koniec */


/* V pripade ak cacheujem stranku tak ulozim vysledok do suboru a opatovne ho spustim kvoli dynamickym smart sippetom
Pri prvom nacitani stranky sa nevykona dynamicky smart snippet lebo je to este v php kode..toto je kvazi take obidenie toho */
if($pageCache && $admin_id != 1)
{
    file_put_contents($cachefile, $index);
    /* odoislem poziadavku aby sa vykonal subor a vratil mi vysledok */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $defaultSettings["base_url"].'public/'.$cachefile);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    curl_close($ch);

    echo $output;
}
else
{
    /* cierny pasik, ktory sa zobrazi iba v nahladovom rezime */
    if($admin_preview)
    {
        $black_strip = $page->generateBlackStrip();
        $index       = str_replace('<body>', $black_strip, $index);
    }
    /* koniec */

    echo $index;
}

?>
