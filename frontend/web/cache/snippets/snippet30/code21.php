<div class="kroky kroky-number-with-dot">
  <h3>{$nadpis}</h3>
  <ol>
    {foreach $kroky as $krok}
    <li>{$krok->text}</li>
    {/foreach}
  </ol>
</div>