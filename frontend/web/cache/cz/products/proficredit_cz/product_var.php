<?php 
$tempObject = (object) array(
'dolna_hranica_splatnosti' => '12',
'horna_hranica_pozicky' => '166000',
'horna_hranica_splatnosti' => '48',
'dolna_hranica_pozicky' => '10000',
'rozsah_porovnavac' => '10 000 - 166 000 Kč',
'splatnost_porovnavac' => '12 - 48 měsíců',
'nazov_produktu' => 'PROFI CREDIT půjčka',
'zaokruhlenie' => '1000',
'logo_small' => '/multimedia/products_small/pc-small.png',
'platnost_akcie' => '01.05.2021',
'akcia_headline' => 'Půjčka s odměnou 25 000 Kč',
'logo_medium' => '/multimedia/products_medium/pc-medium.png',
'rating' => '5',
);
$proficredit_cz = new ObjectBridge($tempObject, 'proficredit_cz'); 
