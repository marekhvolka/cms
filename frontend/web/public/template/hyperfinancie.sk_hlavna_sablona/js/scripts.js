$(function(){
  
  /* scroll */
  $('.slide_to').click(function(event){
    event.preventDefault();
    $('html, body').animate({
      scrollTop:$(this.hash).offset().top},1000);
  });
    
       $('.klient p').addClass("packed"); 
       
       $('.read-more').click(function(){       
          var par = $(this).parent().find('p');
       
          if(par.hasClass('packed')){
            par.removeClass("packed");
            $(this).html('Skryť...');
          } else{
            par.addClass('packed');
            $(this).html('Čítať viac...');
          }  
       });
  
  
  