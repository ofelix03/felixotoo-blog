// window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));

/** A window box for the twitter share button **/
  $('#twitter-popup').click(function(event) { 
    window_open(this.href, "Twitter");
        return false;
  });



/**  A window for a google share button **/
$('#google-popup').click(function(){
  window_open(this.href, "Google+");
  return false;
});




function window_open(url, title){
  var windowWidth = $(window).width(),
    windowHeight = $(window).height(),
    width = 0.5 * windowWidth,
    height = 0.5 * windowHeight,
    left = (width / 2),
    top = (height / 2),
    url = url, 
    window_specs = 'width='+ width + ',height=' + height +',left=' + left + ',top =' + top;

    window.open(url, title, window_specs);
}