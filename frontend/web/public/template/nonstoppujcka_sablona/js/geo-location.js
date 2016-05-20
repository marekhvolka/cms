

  var radius = 10;
  var url = 'http://www.geoplugin.net/extras/nearby.gp?radius='+radius+'&format=json&limit=1&jsoncallback=?';
  
   $.getJSON(url, function(location){
   var city_one = location[0].geoplugin_place;
   var country = location[0].geoplugin_countryCode;



  if(city_one=='' || country!='SK'){
    $("#geoname").html('Bratislava');
  } else {       
    $("#geoname").html(city_one);
  }     
     
  });
