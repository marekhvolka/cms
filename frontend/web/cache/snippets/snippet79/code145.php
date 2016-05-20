<div class="sidebar-menu">
<h3>Menu</h3>  
  <div class="list-group list-group-menu">

    <a class="list-group-item" href="#">{nazov_produktu}</a>

    <a class="list-group-item" href="#tabulka">{$slovnik->tabulka_splatok}</a>

    <a class="list-group-item" href="#faq">{$slovnik->caste_otazky}</a>

    <a class="list-group-item" href="#zkusenosti">{$slovnik->skusenosti}</a>

    <?php if ($tag != 'bez_spoluprace') : ?><a class="list-group-item" href="zadost/">{$slovnik->online_ziadost}</a><?php endif; ?>

 </div>
</div>
