<form name="mainform">
  <fieldset>
    <label>Predčíslie účtu</label>
    <input name="cur" type="number" id="account_prefix">
  </fieldset>
  <fieldset>
    <label>Číslo účtu</label>
    <input name="acc" type="number" id="account_number">
  </fieldset>
  <fieldset>
    <label>Kód banky</label>
    <input name="bnk" type="number" id="bank_code">
  </fieldset>
  <fieldset>
    <input type="button" value="Vypočítať" name="calculate" onclick="vrat_iban(this.form)"/>
    <input type="button" value="Reset" name="reset" onclick="vymaz_obr()"/>
  </fieldset>
</form>

<script>
  
</script>