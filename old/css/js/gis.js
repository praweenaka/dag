function GetXmlHttpObject()
	{
		var xmlHttp=null;
		try
		 {
			 // Firefox, Opera 8.0+, Safari
			 xmlHttp=new XMLHttpRequest();
		 }
		catch (e)
		 {
			 // Internet Explorer
			 try
			  {
				  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
			  }
			 catch (e)
			  {
				 xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
		 }
		return xmlHttp;
	}	


function init(butcomand)
{
	
			
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
			var url="phpgis.php";			
			url=url+"?Command="+butcomand;
			//url=url+"&Regt="+document.getElementById('Reg_Name_1').value;
		//	url=url+"&RegimentNo="+document.getElementById('Reg_No_1').value;
		  
		 	//alert(url);
		//	alert(xmlHttp.responseText);		
			xmlHttp.onreadystatechange=stateChanged;
			xmlHttp.open("GET",url,true);
			
			xmlHttp.send(null);	
			
		
}




//var longitude;
//var latitude;

function stateChanged() 
	{ 
	
	var XMLAddress1;
	//alert("stateChanged ok");
	
	//alert(xmlHttp.readyState);
	//init1();
		if (xmlHttp.readyState==4)
		 { 
		 	//alert("stateChanged ok");
			 //alert(xmlHttp.responseText);
			// document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
			// setTimeout("location.reload(true);",1000);
			
		//	alert("stateChanged ok");
		//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Mem_No");				
		//	var Mem_No = XMLAddress1[0].childNodes[0].nodeValue;
			
			
		//	if(Mem_No=="ok")
			
		//	{
			//	alert("okkkk");
			//	alert(xmlHttp.responseText);
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("lat");				
				document.getElementById('lat').value = XMLAddress1[0].childNodes[0].nodeValue;
				alert(XMLAddress1[0].childNodes[0].nodeValue);
				latitude= XMLAddress1[0].childNodes[0].nodeValue;
				

				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("lon");				
				document.getElementById('lon').value = XMLAddress1[0].childNodes[0].nodeValue;
				longitude	= XMLAddress1[0].childNodes[0].nodeValue;
				
				init1();
					
		//	}
	
			//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REFNO");				
			//document.getElementById('Reference_No').value = XMLAddress1[0].childNodes[0].nodeValue;			
			//document.getElementById('Reference_No').value ="Check Ref NO";
		 } 
	}
	
	function showmap(lat, lon)
	{
		latitude=lat;
		longitude=lon;
		
		init1();
	}
	
    function addSampleButton(caption, clickHandler) {
        var btn = document.createElement('input');
        btn.type = 'button';
        btn.value = caption;
        
        if (btn.attachEvent)
          btn.attachEvent('onclick', clickHandler);
        else
          btn.addEventListener('click', clickHandler, false);

        // add the button to the Sample UI
        document.getElementById('sample-ui').appendChild(btn);
      }
      
      function addSampleUIHtml(html) {
        document.getElementById('sample-ui').innerHTML += html;
      }
	  
	     var ge;
    
    // store the object loaded for the given file... initially none of the objects
    // are loaded, so initialize these to null
    var currentKmlObjects = {
      'red': null,
      'yellow': null,
      'green': null
    };
    
    google.load("earth", "1");
    
    function init1() {
		//alert("okkkk");
      google.earth.createInstance('map3d', initCallback, failureCallback);
    
      addSampleUIHtml(
        '<h2>Toggle KML Files:</h2>' +
        '<input type="checkbox" id="kml-red-check" onclick="toggleKml(\'red\');"/><label for="kml-red-check">Water Stream</label><br/>' +
        '<input type="checkbox" id="kml-yellow-check" onclick="toggleKml(\'yellow\');"/><label for="kml-yellow-check">Electricity</label><br/>' +
        '<input type="checkbox" id="kml-green-check" onclick="toggleKml(\'green\');"/><label for="kml-green-check">Road</label><br/>'
      );
    }
    
    function initCallback(instance) {

	  //alert(latitude);
	  //alert(longitude);
      ge = instance;
      ge.getWindow().setVisibility(true);
    
      // add a navigation control
      ge.getNavigationControl().setVisibility(ge.VISIBILITY_AUTO);
    
      // add some layers
      ge.getLayerRoot().enableLayerById(ge.LAYER_BORDERS, true);
      ge.getLayerRoot().enableLayerById(ge.LAYER_ROADS, true);
    
      // fly to Santa Cruz
      var la = ge.createLookAt('');
      la.set(latitude, longitude,
        0, // altitude
        ge.ALTITUDE_RELATIVE_TO_GROUND,
        0, // heading
        0, // straight-down tilt
        200 // range (inverse of zoom)
        );
      ge.getView().setAbstractView(la);
    
      // if the page loaded with checkboxes checked, load the appropriate
      // KML files
      if (document.getElementById('kml-red-check').checked)
        loadKml('red');
    
      if (document.getElementById('kml-yellow-check').checked)
        loadKml('yellow');
    
      if (document.getElementById('kml-green-check').checked)
        loadKml('green');
    
      document.getElementById('installed-plugin-version').innerHTML =
        ge.getPluginVersion().toString();
    }
    
    function failureCallback(errorCode) {
    }
    
    function toggleKml(file) {
      // remove the old KML object if it exists
      if (currentKmlObjects[file]) {
        ge.getFeatures().removeChild(currentKmlObjects[file]);
        currentKmlObject = null;
      }
    
      // if the checkbox is checked, fetch the KML and show it on Earth
      var kmlCheckbox = document.getElementById('kml-' + file + '-check');
      if (kmlCheckbox.checked)
        loadKml(file);
    }
    
    function loadKml(file) {
      var kmlUrl = 'http://earth-api-samples.googlecode.com/svn/trunk/' +
        'examples/static/' + file + '.kml';
    
      // fetch the KML
      google.earth.fetchKml(ge, kmlUrl, function(kmlObject) {
        // NOTE: we still have access to the 'file' variable (via JS closures)
    
        if (kmlObject) {
          // show it on Earth
          currentKmlObjects[file] = kmlObject;
          ge.getFeatures().appendChild(kmlObject);
        } else {
          // bad KML
          currentKmlObjects[file] = null;
    
          // wrap alerts in API callbacks and event handlers
          // in a setTimeout to prevent deadlock in some browsers
          setTimeout(function() {
            alert('Bad or null KML.');
          }, 0);
    
          // uncheck the box
          document.getElementById('kml-' + file + '-check').checked = '';
        }
      });
    }
	