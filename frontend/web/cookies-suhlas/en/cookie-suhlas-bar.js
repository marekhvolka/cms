function generateCookieBar(){

    
    var style='<style type="text/css">\
    .cookie-bar{\
        font-family: Arial,"Helvetica Neue",Helvetica,sans-serif;\
        position: fixed;\
    background: rgba(0,0,0,0.87);\
    left: 0;\
    bottom: 0;\
        line-height:20px;\
    width: 100%;\
    -webkit-transform: translateZ(0);\
    color: #fff;\
    z-index: 1000;\
    padding: 4px;\
    text-align: center;\
        font-size:12px;\
    }\
    .cookie-bar a{\
        color:#fff;\
        text-decoration:none;\
        margin:0 6px;\
    }\
    .cookie-bar a:hover{\
        text-decoration:underline;\
        cursor:pointer;\
    }\
    a.cookie-btn{\
        background:#428BCA;\
        padding:4px 8px;\
        border-radius:4px;\
    }\
</style>';
    
    var bar='<div id="cookies-information" class="cookie-bar"> This site uses cookies for content personalization and traffic analysis. By using this site you agree. <a id="allow-cookies-button" class="cookie-btn">OK</a> <a href="https://www.google.com/policies/technologies/cookies/" target="_blank" rel="nofollow">More information</a></div>';
    
    var div=style + bar;
    
    return div;
}