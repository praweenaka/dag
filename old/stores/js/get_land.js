// JavaScript Document

var xmlHttp;

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
	
	
var xmlHttp1;

function GetXmlHttpObject1()
	{
		var xmlHttp1=null;
		try
		 {
			 // Firefox, Opera 8.0+, Safari
			 xmlHttp1=new XMLHttpRequest();
		 }
		catch (e)
		 {
			 // Internet Explorer
			 try
			  {
				  xmlHttp1=new ActiveXObject("Msxml2.XMLHTTP");
			  }
			 catch (e)
			  {
				 xmlHttp1=new ActiveXObject("Microsoft.XMLHTTP");
			  }
		 }
		return xmlHttp1;
	}
	


function ClearForm()
	{	
		setTimeout("location.reload(true);",1000);
	}
	
	
		
function close_window()
{
	window.close();
}


function page_load()
{

	get_center_unit(document.getElementById('center').value);
}



function get_center_unit(center_id)
{
	
	
	xmlHttp1=GetXmlHttpObject1();
	if (xmlHttp1==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 	
		
		
	var url="get_center_unit.php";			
	url=url+"?Command="+"get_center_unit";		
	url=url+"&center_id="+center_id;
	
		
	xmlHttp1.onreadystatechange=print_center_unit;
	xmlHttp1.open("GET",url,true);
	xmlHttp1.send(null);	
	return true;
}




function print_center_unit()
{
		var XMLAddress1;
	
		if (xmlHttp1.readyState==4 || xmlHttp1.readyState=="complete")
		 { 
			//alert(xmlHttp1.responseText);
			document.getElementById("center_unit").innerHTML=xmlHttp1.responseText;

		 }
}

function get_building_type()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp1==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 	
		
		
	var url="land_type.php";			
	url=url+"?Command="+"get_land_type";		
	url=url+"&land_id="+document.getElementById('category').value;
	
		
	xmlHttp.onreadystatechange=print_center_unit;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
	return true;
}

function ptint_land_type()
{
	var XMLAddress;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		alert(xmlHttp.responseText);
		//document.getElementById("center_unit").innerHTML=xmlHttp1.responseText;

	}
}
