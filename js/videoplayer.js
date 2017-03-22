


window.onload = function() {

    if (isTouchDevice() == true) {
        $('.video-js').addClass('touch');
    }


    //init standard videos with player controls
    $('.video-js.responsive').each( function() {
      console.log('video-js added.')
      $(this).addClass('vjs-fluid');
      videojs(this, {
          loop: true,
          muted: true,
          preload: "auto",
          autoplay: false,
          controls: true,
          responsive: true,
          //youtube support:
          //techOrder: ["youtube","html5"]
          chromecast: {
              //appId:'APP-ID'
          },
          controlBar: {
              volumeMenuButton: {
                  inline: true
              }
          },
          plugins: {
              responsiveLayout: {}
          }
      });

    });

    //init all videos which should act like GIFs (without controls, looping)
    $('.video-js.gif').each( function() {
      $(this).on('contextmenu', function(e) { return false });
      $(this).addClass('vjs-fluid');
      videojs(this).gifplayer();
    });

    //init gif preview videos
    $('.video-js.gif-preview').each( function() {
      //$(this).hover(hoverVideo, hideVideo).addClass('vjs-fluid');
      $(this).on('contextmenu', function(e) { return false });
      $(this).mouseenter(hoverVideo);
      $(this).mouseleave(hideVideo);
      $(this).addClass('vjs-fluid');
      videojs(this, {
          loop: true,
          muted: true,
          preload: "none",
          autoplay: false,
          controls: false,
          fluid: true
      })
    });


};





function isTouchDevice() {
    var deviceAgent = navigator.userAgent.toLowerCase();
    return ('ontouchstart' in document.documentElement) || (deviceAgent.match(/(iphone|ipod|ipad)/) ||
        deviceAgent.match(/(android)/) ||
        deviceAgent.match(/(iemobile)/) ||
        deviceAgent.match(/iphone/i) ||
        deviceAgent.match(/ipad/i) ||
        deviceAgent.match(/ipod/i) ||
        deviceAgent.match(/blackberry/i) ||
        deviceAgent.match(/bada/i)); // works on IE10/11 and Surface
}


function hoverVideo(e) {
    this.play();
}

function hideVideo(e) {
    this.pause();
}
