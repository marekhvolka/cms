 <!DOCTYPE html>
<html class="no-js">
<head>
  <meta charset="utf-8" />
  {base_url}
  {include_head}
  <title>{title}</title>
  {bootstrap_css}
  {color_scheme}
  <meta name="description" content="{description}" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:700|Open+Sans+Condensed:300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  
  {bootstrap_js}
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->
  {include_head_end}
</head>
<body>
  <div class="main-container container">
  {include_body}
  
  {global_header}
  
  {master_content}
    
  {global_footer}
  {include_body_end}
  </div>
</body>    
</html>