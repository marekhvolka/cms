<div class="slovnik">
<div class="btn-group btn-group-justified" role="group">

<!-- Generovanie zoznamu pismen -->
<?php
$abeceda = 'abcdefghijklmnopqrstuvwxyz';

for($i = 0; $i<strlen($abeceda); $i++): ?>

 <a href="/slovnik?p=<?php echo $abeceda[$i]; ?>" role="button" class="btn btn-default"><?php echo $abeceda[$i]; ?></a>
<?php endfor; ?>

</div>
</div>