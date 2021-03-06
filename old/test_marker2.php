    <!DOCTYPE html>  
    <html>  
    <head>  
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>  
    <script type="text/javascript">  
      function initialize() {  
        var myLatlng = new google.maps.LatLng(-25.363882,131.044922);  
        var myOptions = {  
          zoom: 4,  
          center: myLatlng,  
          mapTypeId: google.maps.MapTypeId.ROADMAP  
        }  
        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);  
          
        var marker = new google.maps.Marker({  
            position: myLatlng,   
            map: map,  
            icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|FF0000|000000'  
        });     
      }  
    </script>  
    </head>  
    <body onload="initialize()">  
      <div id="map_canvas"></div>  
    </body>  
    </html>  