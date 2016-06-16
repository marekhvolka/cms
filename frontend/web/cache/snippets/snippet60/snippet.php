<?php 
$tempObject = (object) array(
'nadpis' => '' . $slovnik->reprezentativny_priklad . '',
'vyska' => '',
'pocet_splatok' => '',
'splatka' => '',
'urok' => '',
'poplatok' => '',
'rpmn' => '',
'celkom' => '',
'splatnost' => '',
'platnost' => '',
'vyska_label' => '' . $slovnik->vyska_pozicky . '',
'pocet_splatok_label' => '' . $slovnik->pocet_splatok . '',
'splatka_label' => '' . $slovnik->mesacna_splatka . '',
'urok_label' => '' . $slovnik->rocny_urok . '',
'poplatok_label' => '' . $slovnik->poplatok_za_vybavenie . '',
'rpmn_label' => '' . $slovnik->rpmn . '',
'celkom_label' => '' . $slovnik->celkova_ciastka_na_zaplatenie . '',
'splatnost_label' => '' . $slovnik->datum_splatnosti . '',
);
$snippet = new ObjectBridge($tempObject, 'snippet60');
?>
