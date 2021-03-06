function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}
function tick()
{
    //get the mins of the current time
    var mins = new Date().getMinutes();
	var sec = new Date().getSeconds();
	
    if (mins == "00" && sec=="00") {
        getLocation();
     }
   // console.log('Tick ' + mins);
}

setInterval(function() { tick(); }, 1000);


 function getLocation() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(savePosition, positionError, {timeout:10000});
      } else {
          //Geolocation is not supported by this browser
      }
  }

  // handle the error here
  function positionError(error) {
      var errorCode = error.code;
      var message = error.message;

     // alert(message);
  }

  function savePosition(position) {
  
   
			$.post( "geocoordinates.php", {lat: position.coords.latitude, lng: position.coords.longitude})
			.done(function( data ) {
				//document.getElementById('dt').innerHTML = data;
			});
			
  }

  function clicked(cdata)
{
 
 

        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }


        var url = "CheckUsers.php";
        url = url + "?Command=" + "click";
       url = url + "&chkno=" + cdata;
        xmlHttp.onreadystatechange=click_res;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

    }
 function click_res()

{ //alert("ok");
  var XMLAddress1;
  
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
     { 
location.href="home.php"; 
     }

}     
