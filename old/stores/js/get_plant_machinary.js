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
	get_plant_machinary_desc(document.getElementById('category').value);
	get_center_unit(document.getElementById('center').value);
}



function get_plant_machinary_desc(cat_val)
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 	
		
		
	var url="get_cat_plant_machinary.php";			
	url=url+"?Command="+"get_plant_descript";		
	url=url+"&desc="+cat_val;
		
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
			//alert(xmlHttp.responseText);
			document.getElementById("cat_desc").innerHTML=xmlHttp.responseText;

		 }
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
