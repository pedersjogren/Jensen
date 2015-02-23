    function initialize() {
        var mapOptions = {
          center: { lat: 59.347878, lng:  18.056809},
          zoom: 18
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);
      }
      google.maps.event.addDomListener(window, 'load', initialize);