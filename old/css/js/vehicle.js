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



	
var xmlHttp2;

function GetXmlHttpObject2()
	{
		var xmlHttp2=null;
		try
		 {
			 // Firefox, Opera 8.0+, Safari
			 xmlHttp2=new XMLHttpRequest();
		 }
		catch (e)
		 {
			 // Internet Explorer
			 try
			  {
				  xmlHttp2=new ActiveXObject("Msxml2.XMLHTTP");
			  }
			 catch (e)
			  {
				 xmlHttp2=new ActiveXObject("Microsoft.XMLHTTP");
			  }
		 }
		return xmlHttp2;
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
	get_vehicle_description(document.getElementById('category').value);
	get_manufacture(document.getElementById('types').value);
	get_model(document.getElementById('makes').value);
	

}



function get_vehicle_description(vehicle_cat_id)
{

	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 	
		
		
	var url="get_vehicle_type.php";			
	url=url+"?Command="+"Vehicle_type";		
	url=url+"&vehicle_cat_id="+vehicle_cat_id;
		
	xmlHttp.onreadystatechange=print_cat_desc;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
	return true;
	
}


function print_cat_desc()
{
		var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		//	alert(xmlHttp.responseText);
			document.getElementById("cat_desc").innerHTML=xmlHttp.responseText;
			xmlHttp1=GetXmlHttpObject1();
			if (xmlHttp1==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 	
				
				
			var url="default.php";			
			url=url+"?Command="+"default";	
			
				
			xmlHttp1.onreadystatechange=print_default;
			xmlHttp1.open("GET",url,true);
			xmlHttp1.send(null);	
			return true;
			

		 }
}


function get_manufacture()
{
	if(document.getElementById('types').value=="")
	{
		xmlHttp1=GetXmlHttpObject1();
		if (xmlHttp1==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 	
			
			
		var url="default.php";			
		url=url+"?Command="+"default";	
		
			
		xmlHttp1.onreadystatechange=print_default;
		xmlHttp1.open("GET",url,true);
		xmlHttp1.send(null);	
		return true;
		

	}
	
	xmlHttp1=GetXmlHttpObject1();
	if (xmlHttp1==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 	
		
		
	var url="get_manufacture.php";			
	url=url+"?Command="+"Vehicle_manufacture";	
	url=url+"&cat_id="+document.getElementById('category').value;
	url=url+"&type_id="+document.getElementById('types').value;
		
	xmlHttp1.onreadystatechange=print_vehicle_manufacture;
	xmlHttp1.open("GET",url,true);
	xmlHttp1.send(null);	
	return true;
}

function print_vehicle_manufacture()
{
		var XMLAddress1;
	
		if (xmlHttp1.readyState==4 || xmlHttp1.readyState=="complete")
		 { 
	//		alert(xmlHttp1.responseText);
			document.getElementById("vehicle_manufac").innerHTML=xmlHttp1.responseText;

		 }
}

function print_default()
{
		var XMLAddress1;
	
		if (xmlHttp1.readyState==4 || xmlHttp1.readyState=="complete")
		 { 
	//		alert(xmlHttp1.responseText);
			document.getElementById("vehicle_model").innerHTML=xmlHttp1.responseText;
			document.getElementById("vehicle_manufac").innerHTML=xmlHttp1.responseText;

		 }
}


function get_model(make_id)
{
	xmlHttp2=GetXmlHttpObject2();
	if (xmlHttp1==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 	
		
		
	var url="get_model.php";			
	url=url+"?Command="+"Vehicle_model";	
	url=url+"&cat_id="+document.getElementById('category').value;
	url=url+"&type_id="+document.getElementById('types').value;
	url=url+"&make_id="+document.getElementById('makes').value;
		
	xmlHttp2.onreadystatechange=print_vehicle_makes;
	xmlHttp2.open("GET",url,true);
	xmlHttp2.send(null);	
	return true;
}


function print_vehicle_makes()
{
		var XMLAddress1;
	
		if (xmlHttp2.readyState==4 || xmlHttp2.readyState=="complete")
		 { 
	//		alert(xmlHttp2.responseText);
			document.getElementById("vehicle_model").innerHTML=xmlHttp2.responseText;

		 }
}

