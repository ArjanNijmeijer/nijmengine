var dropCookie = true; // false disables the Cookie, allowing you to style the banner
var cookieDuration = 30; // Number of days before the cookie expires, and the banner reappears
var cookieName = 'complianceCookie'; // Name of our cookie
var cookieValue = 'off'; // Value of cookie

function createDiv(){
    var bodytag = document.getElementsByTagName('body')[0];

    var div = document.createElement('div');
        div.setAttribute('id','cookie-law');
        div.innerHTML = '<div class="container"><div class="row"><div class="col-12"><p>Wij maken gebruik van cookies om de website goed te laten functioneren en het gebruik van de website te analyseren en te kunnen verbeteren. <a href="/privacyverklaring/" title="Privacyverklaring" class="defaultUrl">Lees onze privacyverklaring</a> <span class="close-cookie-banner" href="javascript:void(0);" onclick="createCookie( window.cookieName, \'on\', window.cookieDuration); removeMe();"><span>Ik ga akkoord</span></span></p></div></div></div>';

    bodytag.appendChild(div); // Adds the Cookie Law Banner just before the closing </body> tag
    // bodytag.insertBefore( div, bodytag.firstChild ); // Adds the Cookie Law Banner just after the opening <body> tag

    document.getElementsByTagName('body')[0].className+=' cookiebanner'; //Adds a class to the <body> tag when the banner is visible
}

function createCookie( name, value, days ) {
    if (days)
    {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";

    if( window.dropCookie ) {
        document.cookie = name+"="+value+expires+"; path=/";
    }
}

function checkCookie( name ) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name,"",-1);
}

function removeMe(){
    var element = document.getElementById('cookie-law');
    element.parentNode.removeChild(element);
}

window.onload = function(){
    if( checkCookie( window.cookieName ) !== 'on' ){
        createDiv();
    }
}