<!--header -->
      <div class="row">     
        <div class="col-xs-6 padded">
          <div class="input-container">
            <input id="input-amount" class="form-control" placeholder="{$input_text}"><span class="currency">{currency}</span>
          </div>
        </div>
        <!--<div class="col-xs-4 padded">  
          <select id="dateselect" class="form-control">
            <option selected>Zadajte splatnosť</option>
            <option>1 den</option>
            <option>10 dní</option>
            <option>30 dní</option>
          </select>
        </div>-->
        <div class="col-xs-6">           
          <button id="big-filter-button" class="btn main-btn main-btn-big" href="#">{$slovnik->porovnat_ponuky}</button>
        </div>  
      </div>
 


<!--header-->
<script>
    $(function(){
       $("#big-filter-button").click(function(){
         
         var amount = parseInt($("#input-amount").val().split(" ").join(""));    
         var elements = $(".comparator-item");           
         elements.removeClass("hidden-amount");
         
         if (!isNaN(amount))
         {
           var elements = elements.filter(function() {             
             var attributes = $(this).data("amount-filter-attributes").split('-');
             var lower = attributes[0].split(" ").join("");
             
             lower = lower.replace("{currency}", "");
             lower = parseInt(lower);
             
             var upper = attributes[1].split(" ").join("");
             upper = upper.replace("{currency}","");
             upper = parseInt(upper);
                                  
             return (!((lower <= amount) && (upper >= amount)))
           });
           elements.addClass("hidden-amount");
         }
         
         var count = $(".comparator-item").not("[class*='hidden']").length;
         $("#count").text(count);
       });
    });
</script>