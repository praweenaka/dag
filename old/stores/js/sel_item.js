
		
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

function setserial()
{
		document.getElementById("txtinvno").value="";
}

function setinvono()
{
		document.getElementById("txtseri").value="";
}

function set_other_month()
{
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="sel_item_data.php";			
			url=url+"?Command="+"set_other_month";
			var month1=document.getElementById("month1").value+"-01";
			url=url+"&month1="+month1;
			
			xmlHttp.onreadystatechange=passcusresult_set_other_month;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}


function passcusresult_set_other_month()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("month2");	
		document.getElementById('month2').value=XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("month3");	
		document.getElementById('month3').value=XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function utility_chk()
{
	
	if (document.getElementById('optdaly').checked==true){
		document.getElementById('dtto').style.visibility="hidden";	
	} else {
		document.getElementById('dtto').style.visibility="visible";		
	}
}

function utility_load()
{
	
	
		document.getElementById('dtto').style.visibility="hidden";	
	
}

function set_chk()
{
	
	if (document.getElementById('cmbtype').value=="Summary"){
		document.getElementById('Chk_cus_wise').style.visibility="visible";
		document.getElementById('chk_over25').style.visibility="visible";
		document.getElementById('Chk_cus_wise_lbl').style.visibility="visible";
		document.getElementById('chk_over25_lbl').style.visibility="visible";
	} else {
		document.getElementById('Chk_cus_wise').style.visibility="hidden";
		document.getElementById('chk_over25').style.visibility="hidden";	
		document.getElementById('Chk_cus_wise_lbl').style.visibility="hidden";
		document.getElementById('chk_over25_lbl').style.visibility="hidden";
	}

}

function uploadwindow()
{   
	var url="sel_item.php";
	//url=url+"?nic="+document.getElementById('nic').value;
	//alert(url);
	window.open(url,'Item Details','height=500,width=500,resizable=no,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
}



function custno_ind(stname)
{   
			//alert(stname);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			if (stname=="utilization"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_utilization";
				url=url+"&custno="+custno;
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_utilization;
				
			} else if (stname=="ret_cheque_entry"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_ret_cheque_entry";
				url=url+"&custno="+custno;
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_ret_cheque;
				
			} else if (stname=="item_claim"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_item_claim";
				url=url+"&custno="+custno;
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_item_claim;
			} else if (stname=="grn"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_grn";
				url=url+"&custno="+custno;
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_grn;
			} else if (stname=="cust_mast"){
				clear_customer_ind();
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_cusno_cust_mast";
				url=url+"&custno="+document.getElementById('txt_cuscode').value;
				xmlHttp.onreadystatechange=passcusresult_cust_mast_ind;
			} else if (stname=="rep_mast_general"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_repno_cust_mast";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult_rep_mast;
			} else if (stname=="rep_mast_general_s"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_repno_cust_mast";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult_rep_mast_s;
			} else if (stname=="cash_rec"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_cus_cash_rec";
				url=url+"&custno="+custno;
				url=url+"&refno="+opener.document.form1.salesrep.value;
				
				xmlHttp.onreadystatechange=passcusresult_cash_rec;
			} else if (stname=="ret_chq_settle"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_ret_chq_settle";
				url=url+"&custno="+custno;
				url=url+"&refno="+opener.document.form1.salesrep.value;
				
				xmlHttp.onreadystatechange=passcusresult_ret_chq;	
			} else if (stname=="crn"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_crn";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult_crn;
			} else if (stname=="rep_outstand_state"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"rep_outstand_state";
				url=url+"&custno="+document.getElementById("cuscode").value;
				xmlHttp.onreadystatechange=passcusresult_rep_outstand_state_ind;
				
			} else if (stname=="weekly_ord"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"weekly_ord";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult_weekly_ord;
				
			} else if (stname=="weekly_tar"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"weekly_tar";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult_weekly_tar;	
				
			}  else if (stname=="defective_item"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"defective_item";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult_defective_item;	
			
			}  else if (stname=="sal_reg"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"defective_item";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult_sal_reg;	
				
			} else {
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_cusno";
				url=url+"&custno="+document.getElementById("firstname_hidden").value;
				url=url+"&brand="+document.getElementById("brand").value;
				url=url+"&salesrep="+document.getElementById("salesrep").value;
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_ind;
			}
			
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}


function passcusresult_rep_outstand_state_ind()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");	
		document.getElementById('cuscode').value=XMLAddress1[0].childNodes[0].nodeValue;;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");	
		document.getElementById('cusname').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('searchcust').focus();
	}
}

function opt12(){
	
	//document.getElementById("Refund").style.visibility="hidden";
	document.getElementById("Refund").style.visibility="hidden";
	document.getElementById("cmb_refund").style.visibility="hidden";
	
	document.getElementById("NotRecommended").style.visibility="hidden";
	document.getElementById("cmb_notreco").style.visibility="hidden";
	
	document.getElementById("ApprovedBy").style.visibility="hidden";
	document.getElementById("cmb_approv").style.visibility="hidden";
}

function opt3(){
	
	//document.getElementById("Refund").style.visibility="hidden";
	document.getElementById("Refund").style.visibility="visible";
	document.getElementById("cmb_refund").style.visibility="visible";
	
	document.getElementById("NotRecommended").style.visibility="hidden";
	document.getElementById("cmb_notreco").style.visibility="hidden";
	
	document.getElementById("ApprovedBy").style.visibility="hidden";
	document.getElementById("cmb_approv").style.visibility="hidden";
}


function refund()
{
	if (document.getElementById("cmb_refund").value=="Not Recommended"){
		document.getElementById("NotRecommended").style.visibility="visible";
		document.getElementById("cmb_notreco").style.visibility="visible";	
	} else {
		document.getElementById("NotRecommended").style.visibility="hidden";
		document.getElementById("cmb_notreco").style.visibility="hidden";	
		document.getElementById("cmb_approv").style.visibility="hidden";	
		document.getElementById("ApprovedBy").style.visibility="hidden";
	}
}

function notrec()
{
	if (document.getElementById("cmb_notreco").value=="Allowed"){
		document.getElementById("ApprovedBy").style.visibility="visible";
		document.getElementById("cmb_approv").style.visibility="visible";
	} else {
		document.getElementById("ApprovedBy").style.visibility="hidden";
	document.getElementById("cmb_approv").style.visibility="hidden";
	}
}

function sel_one(cdata)
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
	
	var url="sel_item_data.php";
	url=url+"?Command="+"sel_one";
	url=url+"&cdata="+cdata;
	//alert(url);
	xmlHttp.onreadystatechange=sel_one_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	

}

function sel_one_result()
{
	
	var XMLAddress1;
	//alert(xmlHttp.responseText);
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rep_sel");	
		document.getElementById('availab').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
	}
	
}

function close_form()
{
	self.close();	
}

function setlist()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
	
	var url="sel_item_data.php";
	url=url+"?Command="+"setlist";
	url=url+"&brand="+document.getElementById('brand').value;
	//alert(url);
	xmlHttp.onreadystatechange=setlist_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function setlist_result()
{
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);	
		document.getElementById('available_frm').innerHTML=xmlHttp.responseText;  
	
	}
	
}

function desel_one(cdata)
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
	
	var url="sel_item_data.php";
	url=url+"?Command="+"desel_one";
	url=url+"&cdata="+cdata;
	//alert(url);
	xmlHttp.onreadystatechange=desel_one_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	

}

function desel_one_result()
{
	
	var XMLAddress1;
	//alert(xmlHttp.responseText);
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rep_sel");	
		document.getElementById('availab').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
	}
	
}
function selall(){
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
	
	var url="sel_item_data.php";
	if (document.getElementById('selall').checked==true){
		url=url+"?Command="+"select_all_rep_true";
		//alert(url);
	} else {
		url=url+"?Command="+"select_all_rep_false";
		//alert(url);
	}
	//alert(url);
	xmlHttp.onreadystatechange=sel_all_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function sel_all_result()
{
	var XMLAddress1;
	alert(xmlHttp.responseText);
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rep_table");	
		document.getElementById('selrep').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rep_sel");	
		window.opener.document.getElementById('repselected').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
	}
}



function move_sel(imei)
{	
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="sel_item_data.php";	
			url=url+"?Command="+"select_rep";
			url=url+"&imei="+imei;
			url=url+"&chk="+document.getElementById(imei).checked;
			//alert(url);
			xmlHttp.onreadystatechange=move_sel_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}


function move_sel_result()
{
	var XMLAddress1;
	
	//alert(xmlHttp.responseText);


		window.opener.document.getElementById('repselected').innerHTML= xmlHttp.responseText;
}



    

      var geocoder;
   
      function initialize_geo(lati, lon, id) {
		  
		
        geocoder = new google.maps.Geocoder();
 	
		var lat = parseFloat(lati);
        var lng = parseFloat(lon);
        var latlng = new google.maps.LatLng(lat, lng);
		
        geocoder.geocode({'latLng': latlng}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
				//document.getElementById('geoloc').value = results[1].formatted_address;
				addr=results[1].formatted_address;
				addrs=addr.split(',');
			
				document.getElementById('txtgeo').value = addrs[0];
				updatequr(addrs[0], id);
				
             } else {
              alert('No results found');
            }
          } else {
            alert('Geocoder failed due to: ' + status);
          }
        });
		
		
      }

function updatequr(addrs, id)
{
	//alert(addrs);
	//alert(id);
		xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="map_track_rep_data_geo.php";			
			url=url+"?Command="+"view_rep_history_rep";
			url=url+"&id="+id;
			url=url+"&addrs="+addrs;
			
			xmlHttp.onreadystatechange=updatequr_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function updatequr_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
	//alert(xmlHttp.responseText);
	}
}
	
	function a()
	{
			document.getElementById('txtgeo').value="nscnkscksdnc";
			return document.getElementById('txtgeo').value;
	}
	
function view_rep_history_rep()
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="map_track_rep_data.php";			
			//var url="test1.php";			
			url=url+"?Command="+"view_rep_history_rep";
			//url=url+"&imei="+document.getElementById('selected').value;
			url=url+"&txtdatefrom="+document.getElementById('txtdatefrom').value;
			url=url+"&txtdateto="+document.getElementById('txtdateto').value;
			
			xmlHttp.onreadystatechange=view_rep_history_result_rep;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function view_rep_history_result_rep()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rep_table");	
		document.getElementById('rep').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		//initialize();
	}
	
}



var map;
var geocoder;
var address;

function initialize_name() {
	
 // map = new GMap2(document.getElementById("map_canvas"));
  
  //map.setCenter(new GLatLng(40.730885,-73.997383), 15);
  //map.addControl(new GLargeMapControl);
 // GEvent.addListener(map, "click", getAddress);
 try{
  geocoder = new GClientGeocoder();
  alert("ok");
  myLatlng = new google.maps.LatLng(6.91282224990859, 79.8528873933414);
  address =myLatlng;
  geocoder.getLocations(myLatlng, showAddress);
  }catch(err){
			alert(err);
		}
}

/*function getAddress(overlay, latlng) {
  if (latlng != null) {
    address = latlng;
    geocoder.getLocations(latlng, showAddress);
 }
}*/

function showAddress(response) {
  map.clearOverlays();
  if (!response || response.Status.code != 200) {
    alert("Status Code:" + response.Status.code);
  } else {
    place = response.Placemark[0];
	alert(place.address);
   // point = new GLatLng(place.Point.coordinates[1],place.Point.coordinates[0]);
   // marker = new GMarker(point);
   // map.addOverlay(marker);
   // marker.openInfoWindowHtml(
    //    '<b>orig latlng:</b>' + response.name + '<br/>' + 
    //    '<b>latlng:</b>' + place.Point.coordinates[1] + "," + place.Point.coordinates[0] + '<br>' +
    //    '<b>Status Code:</b>' + response.Status.code + '<br>' +
    //    '<b>Status Request:</b>' + response.Status.request + '<br>' +
     //   '<b>Address:</b>' + place.address + '<br>' +
     //   '<b>Accuracy:</b>' + place.AddressDetails.Accuracy + '<br>' +
     //   '<b>Country code:</b> ' + place.AddressDetails.Country.CountryNameCode);
  }
}


function showarmyresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tot");	
		tot = XMLAddress1[0].childNodes[0].nodeValue;
	

		var i=0;
		
		try{
		while (i < tot)
		{
			
			var mlat="latitude"+i;
			var mlon="longtitude"+i;
		
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName(mlat);	
			lat[i] = XMLAddress1[0].childNodes[0].nodeValue;
		
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName(mlon);	
			lon[i] = XMLAddress1[0].childNodes[0].nodeValue;
			
			
			i=i+1;
			

		}
		}catch(err){
			alert(err);
		}

		//	alert("wdfcwsfwefw");
			initialize();
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
		//document.getElementById('cus_address').value= xmlHttp.responseText;
		
		//location.href="map_track.php";
		
		
	}
}

/*function initialize() {
	
	var cou=tot;
	var i=0;
	
	var myLatlngc = new google.maps.LatLng(lat[i], lon[i]);
		
		var mapOptions = {
  		zoom: 8,
  		center: myLatlngc,
  		mapTypeId: google.maps.MapTypeId.ROADMAP,
		}
	var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

		
	while (i < cou)
	{	
		alert(lat[1]);
		var myLatlng = new google.maps.LatLng(lat[i], lon[i]);

		var marker = new google.maps.Marker({
    		position: myLatlng,
    		title:"IEMI No : 2"
		});

		// To add the marker to the map, call setMap();
		marker.setMap(map);		
		i=i+1;
		
    }
}*/

 
 function initialize() {
	
		var myLatlng = new google.maps.LatLng(8.363882, 80.044922);
		var mapOptions = {
  		zoom: 12,
  		center: myLatlng,
  		mapTypeId: google.maps.MapTypeId.ROADMAP,
		}
		var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

		var marker = new google.maps.Marker({
    		position: myLatlng,
    		title:"IEMI No : 1"
		});

		// To add the marker to the map, call setMap();
		marker.setMap(map);
		
		myLatlng = new google.maps.LatLng(8.373882, 80.145922);
		var marker = new google.maps.Marker({
    		position: myLatlng,
    		title:"IEMI No : 2"
		});

		// To add the marker to the map, call setMap();
		marker.setMap(map);
		
		myLatlng = new google.maps.LatLng(8.473882, 80.145922);
		var marker = new google.maps.Marker({
    		position: myLatlng,
    		title:"IEMI No : 3"
		});

		// To add the marker to the map, call setMap();
		marker.setMap(map);
      
      }
	 