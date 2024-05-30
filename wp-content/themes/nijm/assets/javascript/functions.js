jQuery(document).ready(function(){
    jQuery('#mobile-menu').click( function(){
        jQuery('#mobile-menu #icon').toggleClass("is-active");
        jQuery('#menu .menu-hoofdmenu-container').slideToggle();
    });
});


window.onload = function() {

  var pageTitle = document.title;
  var attentionMessage = 'Tot straks?';
  var blinkEvent = null;

  document.addEventListener('visibilitychange', function(e) {
    var isPageActive = !document.hidden;

    if(!isPageActive){
      blink();
    }else {
      document.title = pageTitle;
      clearInterval(blinkEvent);
    }
  });

  function blink(){
    blinkEvent = setInterval(function() {
      if(document.title === attentionMessage){
        document.title = pageTitle;
      }else {
        document.title = attentionMessage;
      }
    }, 100);
  }
};

/*
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('sw.js').then(function(registration) {
            // Registration was successful
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
            // registration failed :(
            console.log('ServiceWorker registration failed: ', err);
        });
    });
}*/

console.info("Did you see how fast we made WordPress CMS? We can help you too!  Contact us at \r\n"+atob('CiAgICAgICAgICAgICAgICAgICAgICAgCiBfICAgXyBfX18gICAgXyBfXyAgX18gCnwgXCB8IHxfIF98ICB8IHwgIFwvICB8CnwgIFx8IHx8IHxfICB8IHwgfFwvfCB8CnwgfFwgIHx8IHwgfF98IHwgfCAgfCB8CnxffCBcX3xfX19cX19fL3xffCAgfF98CiAgICAgICAgICAgICAgICAgICAgICAgCg==')+"\r\n\r\nnijm.nl/contact");