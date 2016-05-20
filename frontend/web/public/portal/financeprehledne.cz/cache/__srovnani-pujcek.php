 <!DOCTYPE html>
<html class="no-js">
<head>
  <meta charset="utf-8" />
  
		<base href="//www.financeprehledne.cz/public/" />
		<!--[if IE]></base><script type="text/javascript">
		(function() {
		var baseTag = document.getElementsByTagName("base")[0];
		baseTag.href = baseTag.href;
		})();
		</script><![endif]-->
  
  <title>Srovnání bankovních i nebankovních půjček</title>
  
			<link href="/css/bootstrap.min.css" rel="stylesheet">
			<link href="/fonts/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
			<link href="/css/public/global.css" rel="stylesheet">
  <link href="/template/templateone/css/public/default.css" rel="stylesheet" type="text/css" media="screen" />
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:700|Open+Sans+Condensed:300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  
  
			<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
			<script src="/js/bootstrap.min.js"></script>
			<script src="/js/function.js"></script>
			<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<![endif]-->
  <!--[if lt IE 9]>
    <script src="template/templateone/js/html5shiv.js"></script>
  <![endif]-->
  <!-- Start Webmaster Tools --><meta name="google-site-verification" content="ui2xEX-fW568y9QdxiB0lTDm942wwnRaf1tgJlpNO3M" /><!-- End Webmaster Tools --><!-- Start Hyperia tracker --><script type="text/javascript" src="http://hyperpartner.cz/js/jquery.hyperia.tracker.js?v=0.1"></script>
<script type="text/javascript">
	(function(window) {
		window.tracker.track('pageView');
	}(window));
</script><!-- End Hyperia tracker -->
</head>
<body>
  <div class="main-container container">
  
  
  <header><div id="logo-section" class="wrapper "><div class="container"><div class="row"><div class="col-md-12 "  ><div class="box"><a href="/" class="logo"><span>FinancePřehledně.cz</span></a>
<div class="top-info">
  <div class="top-telefon">
    <i class="fa fa-phone"></i>
    <strong>800 115 555</strong>
  </div>
</div></div></div></div>
		            </div>
		        </div><div id="menu-section" class="wrapper "><div class="container"><div class="row"><div class="col-md-12 "  ><div class="box"><nav id='main-nav' class='navbar-collapse collapse'>
  <ul>
        	<li style="background: ; color: #000000; "  class="no-child"  >
        <a  href='/'  class='none'>
                      	Úvod                  </a>
              	</li>
        	<li style="background: ; color: #000000; "  class="no-child"  >
        <a  href='/bankovni-pujcky/'  class='none'>
                      	Bankovní půjčky                  </a>
              	</li>
        	<li style="background: ; color: #000000; "  class="no-child"  >
        <a  href='/nebankovni-pujcky/'  class='none'>
                      	Nebankovní půjčky                  </a>
              	</li>
        	<li style="background: ; color: #000000; "  class="no-child"  >
        <a  href='/srovnani-pujcek/'  class='none'>
                      	Srovnání půjček                  </a>
              	</li>
      </ul>
</nav></div></div></div>
		            </div>
		        </div></header>
  
  <main><div id="page-header"><div class="wrapper "style="background: #55AB54;">
		            <div class="container"><div class="row"><div class="col-md-12 "  ><div class="box"><div class="poster poster-big" style="color:#fff" id="big-header">
  <div class="poster-content pull-left">
	  <div class="main-box">
        <h1>Srovnání půjček</h1>
        <p>Jakákoli komerční přestávka se v televizi neobejde bez reklamy na půjčku bankovní či nebankovní instituce. Protože je těchto institucí opravdu nepřeberné množství, mnohým z nás dělá občas problém zorientovat se v jednotlivých nabídkách, ale i produktech, které vesměs všechny slibují řešení nepříjemné finanční tísně. Pokud o nějaké půjčce přemýšlíte i vy, nenechte se nalákat triky marketérů ani líbivé reklamní spoty. Raději zjistěte, která půjčka bude nejvíce vyhovovat vašim potřebám a požadavkům a věnujte pozornost srovnání půjček, jež můžete realizovat hned několika způsoby.</p>
 
    </div>
  </div>
  <div class="clearfix"></div>
</div></div></div></div><div class="row"><div class="col-md-12 "  ><div class="box"><!--header -->
<div class="comp-form porovnavac-sumo-filter">
  <div class="row">     
    <div class="col-xs-6 padded col-md-8 col-lg-9">
      <div class="input-container">
        <input id="input-amount" class="form-control" placeholder="Zadejte částku"><span class="currency">Kč</span>
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
    <div class="col-xs-6 col-md-3 col-lg-2">           
      <button id="big-filter-button" class="btn btn-lg main-btn">Porovnat nabídky</button>
    </div>  
  </div>
</div>  

<!--header-->
<script>
    $(function(){
       $("#big-filter-button").click(function(){
         
         //animacia porovnavaca
         animujPorovnavac($(".porovnavac-sumo-filter"));
         
         var amount = parseInt($("#input-amount").val().split(" ").join(""));    
         var elements = $(".comparator-item");           
         elements.removeClass("hidden-amount");
         
         if (!isNaN(amount))
         {
           var elements = elements.filter(function() {             
             var attributes = $(this).data("amount-filter-attributes").split('-');
             var lower = attributes[0].split(" ").join("");
             
             lower = lower.replace("Kč", "");
             lower = parseInt(lower);
             
             var upper = attributes[1].split(" ").join("");
             upper = upper.replace("Kč","");
             upper = parseInt(upper);
                                  
             return (!((lower <= amount) && (upper >= amount)))
           });
           elements.addClass("hidden-amount");
         }
         
         var count = $(".comparator-item").not("[class*='hidden']").length;
         $("#count").text(count);
       });
    });
</script></div></div></div>
		            </div>
		        </div></div>
		<div id="page-content">
		    <div class="wrapper">
		        <div class="container">
		            <div class="row"><div id="content" class="col-md-12"><div class="row"><div class="col-md-12 "  ><div class="box"><h2>Srovnání půjček online</h2><div class="comparator-wrapper">
  <div class="comparator">
        
        <div class="row comparator-item" data-tags-filter-attributes="t_6,t_3" 
         data-amount-filter-attributes="100 - 12 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/everyday-medium.png">
          <p>Everyday+ půjčka</p>
          <input type="hidden" class="rating_number" value="4" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>100 - 12 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>1 - 62 dnů</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/everydayplus-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/everydayplus-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_6,t_7,t_14,t_11,t_17,t_18,t_20,t_27,t_10" 
         data-amount-filter-attributes="500 - 4 500 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/malahyper-medium.png">
          <p>malá HyperPůjčka</p>
          <input type="hidden" class="rating_number" value="5" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>500 - 4 500 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>1 - 45 dnů</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/mala-hyper-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/mala-hyper-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_6,t_20,t_11,t_18,t_17,t_15" 
         data-amount-filter-attributes="500 - 4 999 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/vata-online-medium.png">
          <p>Vataonline půjčka</p>
          <input type="hidden" class="rating_number" value="3" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>500 - 4 999 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>3 - 35 dní</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/vataonline-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/vataonline-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_6,t_10,t_12,t_15,t_11,t_20" 
         data-amount-filter-attributes="500 - 7 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/emmas-medium.png">
          <p>Emma's Credit půjčka</p>
          <input type="hidden" class="rating_number" value="4" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>500 - 7 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>5 - 45 dní</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/emmas-credit-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/emmas-credit-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_6,t_4,t_7,t_10,t_11,t_17,t_18,t_20,t_26,t_21,t_23,t_27" 
         data-amount-filter-attributes="500 - 10 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/fer-medium.png">
          <p>Ferratum půjčka</p>
          <input type="hidden" class="rating_number" value="5" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>500 - 10 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>7 - 45 dnů</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/ferratum-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/ferratum-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_6,t_3,t_7,t_10,t_11,t_17,t_20" 
         data-amount-filter-attributes="500 - 20 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/pujckomat-medium.png">
          <p>Půjčkomat půjčka</p>
          <input type="hidden" class="rating_number" value="4" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>500 - 20 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>5 - 31 dnů</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/pujckomat-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/pujckomat-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_6,t_11,t_17,t_27,t_10" 
         data-amount-filter-attributes="500 - 20 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/crediton-medium.png">
          <p>Crediton půjčka</p>
          <input type="hidden" class="rating_number" value="3" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>500 - 20 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>1 - 40 dní</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/crediton-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/crediton-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_6,t_7,t_28,t_18,t_17,t_10,t_11,t_20" 
         data-amount-filter-attributes="500 - 30 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/creditportal-medium.png">
          <p>CreditPortal půjčka</p>
          <input type="hidden" class="rating_number" value="5" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>500 - 30 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>5 - 30 dní</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/creditportal-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/creditportal-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_6" 
         data-amount-filter-attributes="1 000 - 12 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/netcredit-medium.png">
          <p>Net Credit půjčka</p>
          <input type="hidden" class="rating_number" value="3" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>1 000 - 12 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>1 - 30 dní</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/netcredit-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/netcredit-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_11,t_17" 
         data-amount-filter-attributes="1 000 - 15 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/japonskapujcka-medium.png">
          <p>Japonská půjčka</p>
          <input type="hidden" class="rating_number" value="3" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>1 000 - 15 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>30 dní</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/japonska-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/japonska-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_6,t_3,t_10,t_18,t_11,t_17,t_27" 
         data-amount-filter-attributes="1 000 - 15 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/pujcka7-medium.png">
          <p>Půjčka7</p>
          <input type="hidden" class="rating_number" value="3" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>1 000 - 15 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>7 - 28 dní</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/pujcka7/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/pujcka7/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_6,t_3,t_7" 
         data-amount-filter-attributes="1 000 - 50 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/kouzelna-pujcka-medium.png">
          <p>Kouzelná půjčka</p>
          <input type="hidden" class="rating_number" value="4" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>1 000 - 50 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>2 - 30 dní</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/kouzelna-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/kouzelna-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_10,t_11,t_17,t_12,t_20,t_15" 
         data-amount-filter-attributes="1 000 - 15 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/kredito24-medium.png">
          <p>Kredito24 půjčka</p>
          <input type="hidden" class="rating_number" value="4" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>1 000 - 15 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>1 - 30 dní</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/kredito24-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/kredito24-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_6,t_3,t_7,t_11,t_17,t_14,t_18,t_19,t_15,t_20,t_27,t_10" 
         data-amount-filter-attributes="1 000 - 20 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/zaplo-medium.png">
          <p>Zaplo půjčka</p>
          <input type="hidden" class="rating_number" value="5" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>1 000 - 20 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>7 - 30 dnů</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/zaplo-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/zaplo-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_7,t_11,t_28,t_20,t_16,t_10" 
         data-amount-filter-attributes="2 000 - 80 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/provident-medium.jpg">
          <p>Provident půjčka</p>
          <input type="hidden" class="rating_number" value="5" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>2 000 - 80 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>3 - 22 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/provident-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/provident-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_7,t_10,t_11,t_12,t_15,t_23,t_21,t_20,t_18,t_27,t_26,t_16,t_17" 
         data-amount-filter-attributes="4 000 - 250 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/hyper-medium.png">
          <p>HyperPůjčka</p>
          <input type="hidden" class="rating_number" value="5" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>4 000 - 250 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>12 - 84 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/hyper-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/hyper-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3" 
         data-amount-filter-attributes="5 000 - 20 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/aasa-medium.png">
          <p>Aasa půjčka</p>
          <input type="hidden" class="rating_number" value="2" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>5 000 - 20 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>6 - 12 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/aasa-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/aasa-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_7,t_10,t_11,t_20,t_27" 
         data-amount-filter-attributes="5 000 - 100 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/prontopujcka-medium.png">
          <p>Pronto půjčka</p>
          <input type="hidden" class="rating_number" value="5" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>5 000 - 100 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>12 - 48 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/pronto-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/pronto-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_7,t_10,t_26,t_23,t_21,t_28,t_20,t_11,t_17" 
         data-amount-filter-attributes="5 000 - 70 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/smart-medium.png">
          <p>Smart půjčka</p>
          <input type="hidden" class="rating_number" value="4" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>5 000 - 70 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>13 - 16 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/smart-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/smart-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_6,t_11,t_10,t_17" 
         data-amount-filter-attributes="15 000 - 75 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/zaimo-medium.png">
          <p>Zaimo půjčka</p>
          <input type="hidden" class="rating_number" value="4" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>15 000 - 75 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>6 - 36 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/zaimo-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/zaimo-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_7,t_10,t_11,t_18,t_23,t_21,t_15,t_28,t_20,t_27" 
         data-amount-filter-attributes="5 000 - 150 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/tommy-stachi-medium.png">
          <p>Tommy Stachi půjčka</p>
          <input type="hidden" class="rating_number" value="4" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>5 000 - 150 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>12 - 36 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/tommy-stachi-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/tommy-stachi-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_7,t_11,t_18,t_15,t_20,t_10" 
         data-amount-filter-attributes="10 000 - 166 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/pc-medium.png">
          <p>PROFI CREDIT půjčka</p>
          <input type="hidden" class="rating_number" value="5" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>10 000 - 166 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>12 - 48 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/profi-credit-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/profi-credit-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_7,t_11,t_23,t_21,t_28,t_20,t_27,t_16,t_17" 
         data-amount-filter-attributes="10 000 - 200 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/hc-medium.jpg">
          <p>Home Credit půjčka</p>
          <input type="hidden" class="rating_number" value="4" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>10 000 - 200 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>12 - 84 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/home-credit-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/home-credit-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_4,t_7,t_11,t_18,t_28,t_20,t_27,t_16" 
         data-amount-filter-attributes="10 000 - 600 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/mbank-medium.png">
          <p>mPůjčka Plus</p>
          <input type="hidden" class="rating_number" value="5" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>10 000 - 600 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>12 - 84 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/mbank-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/mbank-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_4,t_9,t_15,t_16,t_20,t_27" 
         data-amount-filter-attributes="15 000 - 500 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/zuno-medium.jpg">
          <p>Zuno půjčka</p>
          <input type="hidden" class="rating_number" value="2" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>15 000 - 500 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>6 - 72 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
                    <a class="btn btn-medium info-btn" href="/zuno-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_20,t_16,t_4,t_15,t_11,t_10" 
         data-amount-filter-attributes="20 000 - 1 000 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/cetelem-medium.png">
          <p>Osobní půjčka Cetelem</p>
          <input type="hidden" class="rating_number" value="3" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>20 000 - 1 000 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>6 - 120 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/cetelem-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/cetelem-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_4" 
         data-amount-filter-attributes="20 000 - 800 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/ge-money-medium.png">
          <p>Expres půjčka</p>
          <input type="hidden" class="rating_number" value="4" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>20 000 - 800 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>24 - 120 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/ge-money-bank-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/ge-money-bank-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_4,t_9,t_18,t_20,t_16,t_27,t_11" 
         data-amount-filter-attributes="30 000 - 500 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/unicr-medium.png">
          <p>Presto půjčka</p>
          <input type="hidden" class="rating_number" value="5" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>30 000 - 500 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>12 - 84 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/unicredit-bank-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/unicredit-bank-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_17,t_15,t_27,t_16,t_28" 
         data-amount-filter-attributes="40 000 - 500 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/cofidis-medium.png">
          <p>Cofidis půjčka</p>
          <input type="hidden" class="rating_number" value="3" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>40 000 - 500 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>12 - 90 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/cofidis-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/cofidis-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_10,t_20,t_17" 
         data-amount-filter-attributes="50 000 - 3 000 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/vitacredit-medium.png">
          <p>Vitacredit půjčka</p>
          <input type="hidden" class="rating_number" value="3" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>50 000 - 3 000 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>12 - 180 měsíců</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/vitacredit-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/vitacredit-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
        
        <div class="row comparator-item" data-tags-filter-attributes="t_3,t_28,t_10,t_17,t_11,t_12,t_15" 
         data-amount-filter-attributes="100 000 - 5 000 000 Kč">
            <div class="col-sm-3">
        <div class="comparator-item-inner">
          <img src="/multimedia/products_medium/acema-medium.png">
          <p>Acema půjčka</p>
          <input type="hidden" class="rating_number" value="2" />
          <div class="comparator-rating">
          </div>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Rozsah</p>
          <p><b>100 000 - 5 000 000 Kč</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <p>Splatnost</p>
          <p><b>1 - 20 let</b></p>
        </div>    
      </div>
      <div class="col-sm-3">
        <div class="comparator-item-inner">
          <a class="btn btn-medium main-btn" href="/acema-pujcka/zadost/">Mám zájem</a>          <a class="btn btn-medium info-btn" href="/acema-pujcka/">Více info</a>        </div>    
      </div>
      
    </div>
      </div>
  <div class="loader"><i class="fa fa-spinner fa-pulse"></i></div>
  <script>
    var elements = $(".comparator-item");
  	elements.each(function(){
      var attributes = $(this).data("tags-filter-attributes").split(',');
      var equals = false;
      for (var i=0; i<attributes.length; i++)
      {
        if (attributes[i] == "t_9")
        {
          equals = true;
          break;
        }
      }
      if (equals == true)
        $(this).addClass("bez-spoluprace");  
    });
  </script>
  <script><!--hviezdicky pri produktoch -->
    var rating = $(".rating_number");
    for(var i = 0; i < rating.length; i++)
    {
      var pocet_celych = $(rating[i]).val();
      for(var j = 0; j < 5; j++)
      {
        var prazdna = j < pocet_celych ? '' : '-empty';
        $(rating[i]).next('.comparator-rating').append('<span class="glyphicon glyphicon-star' + prazdna + '"></span>');
      }
    }
  </script>
  <script>
      var elements = $(".comparator-item");
      elements.each(function(){
        var attributes = $(this).data("tags-filter-attributes").split(',');
        var equals = false;
        for (var i=0; i<attributes.length; i++)
        {
          if (attributes[i] == "t_9")
          {
            equals = true;
            break;
          }
        }
        if (equals == true)
          $(this).addClass("bez-spoluprace");  
      });

    function animujPorovnavac(filterElement){
      //  if($(window).scrollTop()<$('.filter').offset().top)
          $('.loader').show().delay(1000).fadeOut('fast');
        $('html, body').animate({
         scrollTop: filterElement.offset().top
       },800);

        return true;
      }
  </script>
</div>
<!--comparator wrapper -->  </div></div></div><div class="row"><div class="col-md-12 "  ><div class="box"><h3>Srovnání půjček online</h3><p><span style='line-height: 1.42857;'>Již výše jsme nastínili, že efektivním způsobem, jak vybrat vhodnou půjčku, je důkladné porovnání jednotlivých produktů bank a společností, které se na poskytování půjček specializují. Možnosti, jak půjčky porovnat, jsou celkem dvě. První z nich představuje fyzické obcházení jednotlivých institucí, popřípadě postupné sbírání informací z oficiálních webových stránek či portálů. Tato cesta je ovšem zbytečně zdlouhavá a náročná. Mnohem efektivním způsobem, jak mezi sebou jednotlivé produkty porovnat, je online srovnávač půjček, který je součástí také těchto stránek.</span><br></p><h4>Jak funguje náš srovnávač půjček?</h4><p><span style='line-height: 1.42857;'>Srovnání půjček online je velmi jednoduché. Do políčka v horní části stránky stačí zadat pouze částku, která by vyřešila vaše finanční potíže a kliknout na tlačítko „porovnat“. Obratem se před vámi rozevře bohatá nabídka jednotlivých produktů včetně objemu finančních prostředků, které můžete získat, ale i doby splatnosti, během které je potřeba vypůjčené prostředky navrátit. U každé nabídky jsou navíc uvedeny detailní informace nebo přímo možnost „sjednat půjčku online“, skrytá za tlačítkem „mám zájem“. Jakmile na tlačítko kliknete, dostanete se k nezávazné žádosti, v níž stačí navolit konkrétní výši půjčky, dobu, za jakou vypůjčené peníze vrátíte a kontakt. Jakmile žádost odešlete, bude vás kontaktovat zástupce společnosti s podrobnými podmínkami.</span><br></p><h4>Druhy půjček: Vyznáte se v nich?</h4><p><span style='line-height: 1.42857;'>Dvě největší skupiny půjček tvoří půjčky bankovní a nebankovní. Pojďme se společně podívat, na zásadní rozdíly, výhody i nevýhody obou skupin:</span><br></p><p><b><br></b><a href='http://www.financeprehledne.cz/bankovni-pujcky/' target=''><b>Bankovní půjčky</b></a>: Zamíříte-li do banky, můžete narazit na účelové půjčky, jejichž úrok se pohybuje někde na hranici 10 %. Vyřízení samostatné půjčky je ovšem mnohdy často komplikované a zdlouhavé. Je potřeba doložit nejrůznější druhy dokumentů, ale také prověřit finanční minulost klienta, jeho bonitu a další nezbytnosti. Pokud máte navíc záznam v registru dlužníků, půjčku vám žádná banka neposkytne. To samé platí také pro případy, kdy bankovní úředník zhodnotí, že bonita klienta není pro poskytnutí půjčky dostačující. V takovém případě vám nezbyde nic jiného, než zamířit k některé z nebankovních společností.</p><p><b><br></b><a href='http://www.financeprehledne.cz/nebankovni-pujcky/' target=''><b>Nebankovní půjčky</b></a>: Největší výhodou nebankovních půjček je jistě jejich dostupnost, ale i rychlost vyřízení, popřípadě poskytnutí. Mezi žadatele o nebankovní finanční výpomoc patří lidé, kteří potřebují peníze co nejdříve, banka jejich žádost zamítla, mají minimální nebo dokonce žádný příjem či záznam v registru dlužníků. Tyto skutečnosti nepředstavují pro některé společnosti překážku. Na druhou stranu však riziko, jež tímto půjčováním podstupují, se musí nevyhnutelně projevit na výši úroků, které jsou oproti bankovním půjčkám poněkud vyšší.</p><h4>Další druhy půjček, se kterými se můžete setkat:</h4><p><span style='line-height: 1.42857;'><a href='http://www.financeprehledne.cz/pujcky-bez-registru/' target=''><b>Půjčky bez registru</b></a>: Jak již samotný název napovídá, půjčky bez registru jsou určeny žadatelům, kteří mají aktivní záznam v registru dlužníků. Společnosti, které se na tento druh půjček specializují, obvykle do registrů nenahlížejí nebo informacím z nich nepřikládají značnou váhu.</span><br></p><p><b>SMS půjčky</b>: U SMS půjček obvykle platí, že stačí odeslat jednu SMS zprávu v přesném formátu na konkrétní číslo, na základě které vás bude kontaktovat zástupce firmy či vám rovnou přijde vyrozumění, zda vám bude půjčka poskytnuta či nikoli. SMS půjčky jsou vhodné zejména pro osoby, které nechtějí opouštět pohodlí svého domova a nemají rády zbytečnou administrativu. </p><p><a href='http://www.financeprehledne.cz/pujcky-pred-vyplatou/' target=''><b>Půjčky do výplaty</b></a>: Jestliže vám schází nějaká ta tisícovka do výplaty, je pro vás tento druh půjček doslova jako stvořený. Tyto půjčky jsou obvykle poskytování během velmi krátké lhůty. Často také platí, že nejde o nikterak závratné částky jako spíš o několik tisícovek, jež vám ovšem mohou před výplatou „bodnout“.</p><p><a href='http://www.financeprehledne.cz/pujcky-bez-rucitele/' target=''><b>Půjčky bez ručitele</b></a>: Řada společností po klientovi vyžaduje ručitele. Ručitelem může být buďto manžel či manželka nebo rodiče či další rodinní příslušníci, kteří se zaručí za to, že klient vypůjčené prostředky navrátí. Pokud by tomu tak nebylo, věřitel bude vypůjčené peníze vymáhat po ručiteli. Společnosti, které nabízejí půjčky bez ručitele ovšem osobu, která by případně převzala dluh, nepožadují. </p><p><a href='http://www.financeprehledne.cz/pujcky-bez-dolozeni-prijmu/' target=''><b>Půjčky bez dokazování příjmu</b></a>: Společnosti, jež nabízí tento typ půjčky, nepotřebují prokazovat bonitu žadatele. Pokud tedy máte nízké nebo dokonce žádné příjmy, tato skutečnost pro získání půjčky tato nepředstavuje žádnou překážku</p><p><b>Bezúčelové půjčky</b>: V rámci bezúčelové půjčky můžete použít peníze na cokoli, co zrovna potřebujete. Nikde nedokládáte, co jste si za peníze pořídili, jednoduše je utratíte tak, jak uznáte za vhodné. </p></div></div></div></div>
					</div>
		        </div>
		    </div>
		</div></main>
    
  <footer><div class="wrapper "><div class="container"><div class="row"><div class="col-md-12 "  ><div class="box"><div class="partners partners-slider">
  <div class="partners-slider-container clearfix">
    	<div>
      			<a href="/cetelem-pujcka/"><img src="/multimedia/products_medium/cetelem-medium.png" alt="CETELEM ČR, a.s." />
    </a>    </div>
    	<div>
      			<a href="/ge-money-bank-pujcka/"><img src="/multimedia/products_medium/ge-money-medium.png" alt="GE Money Bank, a. s." />
    </a>    </div>
    	<div>
      			<a href="/japonska-pujcka/"><img src="/multimedia/products_medium/japonskapujcka-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/kredito24-pujcka/"><img src="/multimedia/products_medium/kredito24-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/cofidis-pujcka/"><img src="/multimedia/products_medium/cofidis-medium.png" alt="COFIDIS s.r.o." />
    </a>    </div>
    	<div>
      			<a href="/profi-credit-pujcka/"><img src="/multimedia/products_medium/pc-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/home-credit-pujcka/"><img src="/multimedia/products_medium/hc-medium.jpg" alt="Home Credit a.s." />
    </a>    </div>
    	<div>
      			<a href="/smart-pujcka/"><img src="/multimedia/products_medium/smart-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/provident-pujcka/"><img src="/multimedia/products_medium/provident-medium.jpg" alt="Provident Financial s.r.o." />
    </a>    </div>
    	<div>
      			<a href="/tommy-stachi-pujcka/"><img src="/multimedia/products_medium/tommy-stachi-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/ferratum-pujcka/"><img src="/multimedia/products_medium/fer-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/creditportal-pujcka/"><img src="/multimedia/products_medium/creditportal-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/zaplo-pujcka/"><img src="/multimedia/products_medium/zaplo-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/pujckomat-pujcka/"><img src="/multimedia/products_medium/pujckomat-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/mala-hyper-pujcka/"><img src="/multimedia/products_medium/malahyper-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/hyper-pujcka/"><img src="/multimedia/products_medium/hyper-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/unicredit-bank-pujcka/"><img src="/multimedia/products_medium/unicr-medium.png" alt="UniCredit Bank Czech Republic and Slovakia, a.s." />
    </a>    </div>
    	<div>
      			<a href="/mbank-pujcka/"><img src="/multimedia/products_medium/mbank-medium.png" alt="mBank S.A." />
    </a>    </div>
    	<div>
      			<a href="/kouzelna-pujcka/"><img src="/multimedia/products_medium/kouzelna-pujcka-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/everydayplus-pujcka/"><img src="/multimedia/products_medium/everyday-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/vitacredit-pujcka/"><img src="/multimedia/products_medium/vitacredit-medium.png" alt="VITACREDIT s.r.o. " />
    </a>    </div>
    	<div>
      			<a href="/pronto-pujcka/"><img src="/multimedia/products_medium/prontopujcka-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/emmas-credit-pujcka/"><img src="/multimedia/products_medium/emmas-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/pujcka7/"><img src="/multimedia/products_medium/pujcka7-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/aasa-pujcka/"><img src="/multimedia/products_medium/aasa-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/crediton-pujcka/"><img src="/multimedia/products_medium/crediton-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/acema-pujcka/"><img src="/multimedia/products_medium/acema-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/vataonline-pujcka/"><img src="/multimedia/products_medium/vata-online-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/netcredit-pujcka/"><img src="/multimedia/products_medium/netcredit-medium.png" alt="" />
    </a>    </div>
    	<div>
      			<a href="/zuno-pujcka/"><img src="/multimedia/products_medium/zuno-medium.jpg" alt="ZUNO BANK AG" />
    </a>    </div>
    	<div>
      			<a href="/zaimo-pujcka/"><img src="/multimedia/products_medium/zaimo-medium.png" alt="" />
    </a>    </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="/template/hyperfinancie.sk_hlavna_sablona/css/slick-slider/slick.css"/>
<script type="text/javascript" src="/template/hyperfinancie.sk_hlavna_sablona/css/slick-slider/slick.min.js"></script>

<script>
$(function(){
  $('.partners-slider-container').slick({
		autoplay:true,
    autoplaySpeed:4000,
  	infinite: true,
  	speed: 300,
 		slidesToShow: 5,
 	 	centerMode: false,
  	variableWidth: true
  })
});
</script></div></div></div>
		            </div>
		        </div><div id="menu-section" class="wrapper "><div class="container"><div class="row"><div class="col-md-12 "  ><div class="box"><div class="bottom-menu">
       <div class="bottom-menu-block"> 
    	<h4>
        <a 
            href='/bankovni-pujcky/'            ><i class=""></i>
        	          	Bankovní půjčky                  </a>
       </h4>
      <ul>
                	<li><a href="/ferratum-pujcka/">Ferratum půjčka</a></li>
                	<li><a href="/mbank-pujcka/">mBank půjčka</a></li>
                	<li><a href="/zuno-pujcka/">Zuno půjčka</a></li>
                	<li><a href="/cetelem-pujcka/">Cetelem půjčka</a></li>
                	<li><a href="/ge-money-bank-pujcka/">Ge Money Bank půjčka</a></li>
                	<li><a href="/unicredit-bank-pujcka/">Unicredit Bank půjčka</a></li>
              </ul>
  	</div>
       <div class="bottom-menu-block"> 
    	<h4>
        <a 
            href='/nebankovni-pujcky/'            ><i class=""></i>
        	          	Nebankovní půjčky                  </a>
       </h4>
      <ul>
                	<li><a href="/everydayplus-pujcka/">Everydayplus půjčka</a></li>
                	<li><a href="/mala-hyper-pujcka/">Malá Hyper půjčka</a></li>
                	<li><a href="/vataonline-pujcka/">Vataonline půjčka</a></li>
                	<li><a href="/emmas-credit-pujcka/">Emmas Credit půjčka</a></li>
                	<li><a href="/pujckomat-pujcka/">Půjčkomat půjčka</a></li>
                	<li><a href="/crediton-pujcka/">CreditOn půjčka</a></li>
                	<li><a href="/creditportal-pujcka/">CreditPortal půjčka</a></li>
                	<li><a href="/clickcredit-pujcka/">ClickCredit půjčka</a></li>
                	<li><a href="/netcredit-pujcka/">NetCredit půjčka</a></li>
                	<li><a href="/japonska-pujcka/">Japonská půjčka</a></li>
                	<li><a href="/pujcka7/">Půjčka7</a></li>
                	<li><a href="/kouzelna-pujcka/">Kouzelná půjčka</a></li>
                	<li><a href="/kredito24-pujcka/">Kredito24 půjčka</a></li>
                	<li><a href="/zaplo-pujcka/">Zaplo půjčka</a></li>
                	<li><a href="/provident-pujcka/">Provident půjčka</a></li>
                	<li><a href="/hyper-pujcka/">Hyper půjčka</a></li>
                	<li><a href="/aasa-pujcka/">Aasa půjčka</a></li>
                	<li><a href="/pronto-pujcka/">Pronto půjčka</a></li>
                	<li><a href="/smart-pujcka/">Smart půjčka</a></li>
                	<li><a href="/zaimo-pujcka/">Zaimo půjčka</a></li>
                	<li><a href="/tommy-stachi-pujcka/">Tommy Stachi Půjčka</a></li>
                	<li><a href="/profi-credit-pujcka/">Profi Credit půjčka</a></li>
                	<li><a href="/home-credit-pujcka/">Home Credit půjčka</a></li>
                	<li><a href="/cofidis-pujcka/">Cofidis půjčka</a></li>
                	<li><a href="/vitacredit-pujcka/">Vitacredit půjčka</a></li>
                	<li><a href="/acema-pujcka/">Acema půjčka</a></li>
              </ul>
  	</div>
       <div class="bottom-menu-block"> 
    	<h4>
        <a 
            href='/srovnani-pujcek/'            ><i class=""></i>
        	          	Srovnání půjček                  </a>
       </h4>
      <ul>
                	<li><a href="/bankovni-pujcky/">Bankovní půjčky</a></li>
                	<li><a href="/nebankovni-pujcky/">Nebankovní půjčky</a></li>
                	<li><a href="/pujcky-bez-registru/">Půjčky bez registru</a></li>
                	<li><a href="/pujcky-bez-rucitele/">Půjčky bez ručitele</a></li>
                	<li><a href="/pujcky-pred-vyplatou/">Půjčky před výplatou</a></li>
                	<li><a href="/rychla-pujcka-ihned/">Rychlá půjčka ihned</a></li>
                	<li><a href="/pujcky-bez-dolozeni-prijmu/">Půjčky bez doložení příjmu</a></li>
                	<li><a href="/pujcky-v-hotovosti/">Půjčky v hotovosti</a></li>
                	<li><a href="/pujcky-pro-dluzniky/">Půjčky pro dlužníky</a></li>
                	<li><a href="/pujcky-pro-duchodce/">Půjčky pro důchodce</a></li>
                	<li><a href="/prvni-pujcka-zdarma/">První půjčka zdarma</a></li>
                	<li><a href="/pujcky-na-materske/">Půjčky na mateřské</a></li>
                	<li><a href="/pujcky-pro-studenty/">Půjčky pro studenty</a></li>
                	<li><a href="/nejschvalovanejsi-pujcky/">Nejschvalovanější půjčky</a></li>
                	<li><a href="/pujcky-na-obcansky-prukaz/">Půjčky na občanský průkaz</a></li>
                	<li><a href="/pujcky-pro-zivnostniky/">Půjčky pro živnostníky</a></li>
              </ul>
  	</div>
       <div class="bottom-menu-block"> 
    	<h4>
        <a 
            href='/srovnani-pujcek/'            ><i class=""></i>
        	          	Půjčky podle částky                  </a>
       </h4>
      <ul>
                	<li><a href="/pujcka-1000-ihned/">Půjčka 1000 ihned</a></li>
                	<li><a href="/pujcka-2000-ihned/">Půjčka 2000 ihned</a></li>
                	<li><a href="/pujcka-3000-ihned/">Půjčka 3000 ihned</a></li>
                	<li><a href="/pujcka-4000-akce-ihned/">Půjčka 4000 akce ihned</a></li>
                	<li><a href="/pujcka-do-5000/">Půjčka do 5000</a></li>
                	<li><a href="/pujcka-10000-ihned/">Půjčka 10000 ihned</a></li>
                	<li><a href="/pujcka-20000-ihned/">Půjčka 20000 ihned</a></li>
                	<li><a href="/pujcka-30000-ihned/">Půjčka 30000 ihned</a></li>
                	<li><a href="/pujcka-40000-ihned/">Půjčka 40000 ihned</a></li>
                	<li><a href="/pujcka-50000-ihned/">Půjčka 50000 ihned</a></li>
              </ul>
  	</div>
  </div>


<script>
$(function(){
  /************** rozbalenie footer menu na mobile *********************/
  
    if($(window).width()<768) {
      $('.bottom-menu-block h4').click(function(){
         $(this).parent().find('ul').slideToggle();
      });

    }

})
</script></div></div></div>
		            </div>
		        </div><div id="copyright-section" class="wrapper "><div class="container"><div class="row"><div class="col-md-12 "  ><div class="box"><div id="copyright-panel">
	<p>© 2016 <a href='/'>FinancePřehledně.cz</a> Všechna práva vyhrazena</p>
  
</div><div id='technicky-prevadzkovatel'><p dir='ltr'>  Provozovatelem této webové stránky je společnost Content Management s.r.o., se sídlem Kubánské náměstí 1391/11, Vršovice, 100 00 Praha 10, Česká republika. Společnost Content Management s.r.o není poskytovatelem a ani zprostředkovatelem půjček nebo jiných finančních produktů. <a href='http://www.contentmanagementsro.cz/podmienky.pdf' target='_blank'>Podmínky webstránky</a></p></div></div></div></div>
		            </div>
		        </div></footer>
  <!-- Start Google Analytics --><script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43784277-17', 'auto');
  ga('send', 'pageview');

</script><!-- End Google Analytics -->
  </div>
</body>    
</html>