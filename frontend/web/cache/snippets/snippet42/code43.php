<div class="slovnik">
  <h1>{$nadpis}</h1>
  <div class="slovnik-aktual">
	<!-- Vytiahnutie z databazy vsetky zaznamy zacinajuce na dane pismeno -->
<?php

require '../../settings.php';
require '../../classes/core/class.db.php';


$db = new db(hostname, username, password, database, prefix, connector);

/* Vytiahnem z databazy id potalu */
$server_name = str_replace('www.', '', $_SERVER["SERVER_NAME"]);
$data = $db->select("SELECT id FROM s_portal WHERE domena = ?", array($server_name), 's');
$id   = !empty($data) ? $data[0]["id"] : '';

$p = !empty($_GET["p"]) ? $_GET["p"] : 'a';
$data = $db->select("SELECT m.url, m.nazov FROM page_master m LEFT JOIN page_master m2 ON m.rodic = m2.id WHERE m2.url = ? AND m.url LIKE ? AND m.portal = ?", array('slovnik', $p."%", $id), 'ssi');

?>
    
<h2 class="slovnik-pismeno"> <?php echo $p; ?></h2>


<div class="slovnik-list">
<ul class="list-default">

<?php foreach((array)$data as $value) : ?>

	<li><a href="/slovnik/<?php echo $value["url"]; ?>/"> <?php echo $value["nazov"]; ?></a></li> 


<?php endforeach; ?>

</ul></div>

<!-- Koniec -->
  </div>
    
<div class="btn-group btn-group-justified" role="group">

<!-- Generovanie zoznamu pismen -->
<?php
$abeceda = 'abcdefghijklmnopqrstuvwxyz';

for($i = 0; $i<strlen($abeceda); $i++): ?>

 <a href="/slovnik?p=<?php echo $abeceda[$i]; ?>" role="button" class="btn btn-default"><?php echo $abeceda[$i]; ?></a>
<?php endfor; ?>

</div>
</div>