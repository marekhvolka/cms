<div class="kroky kroky-desc kroky-wide">
  <ol>
    {foreach $kroky as $krok}
    <li>
      <h4>{$krok->text}</h4>
      <p>{$krok->popis}</p>
    </li>
    {/foreach}
  </ol>
</div>