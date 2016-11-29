<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

require_once 'vendor/autoload.php';
use GeoIp2\Database\Reader;

$reader = new Reader('/usr/share/GeoIP/GeoLite2-City.mmdb');

if (isset($_GET['ip'])) {
    $ip = $_GET['ip'];
}
else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$data = geoip_record_by_name($ip);
//$data = utf8_encode($data);

$city = $reader->city($ip);
$data['city'] = $city->city->name;
$data['country_name'] = $city->country->name;

if ($isp = geoip_isp_by_name($ip)) {
    $data['ISP'] = $isp;
}
else {
    $data['ISP'] = "";
}

if (isset($_GET['debug'])) {
var_dump($city);
var_dump($data);
}

echo json_encode($data);

?>
