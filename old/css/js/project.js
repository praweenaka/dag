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



function ClearForm()
	{	
		setTimeout("location.reload(true);",1000);
	}
	
function insert_project()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="project_data.php";	
	
	url=url+"?Command="+"add_project_data";
	url=url+"&refno="+document.getElementById('refno').value;
	url=url+"&datetime="+document.getElementById('datetime').value;
	
	url=url+"&district="+document.getElementById('town').value;	
	url=url+"&plk="+document.getElementById('plk').value;	
	url=url+"&gnv="+document.getElementById('grv').value;
	
	url=url+"&project_datails="+document.getElementById('project_datails').value;
	url=url+"&prosuggest="+document.getElementById('prosuggest').value;
	url=url+"&requ="+document.getElementById('requ').value;	
	url=url+"&reqname="+document.getElementById('reqname').value;
	alert(url);
	url=url+"&action="+document.getElementById('action').value;
	url=url+"&projectamt="+document.getElementById('projectamt').value;
	
	xmlHttp.onreadystatechange=showresults;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}


function showresults()
{
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
		//	alert(xmlHttp.responseText);
			document.getElementById("message").innerHTML=xmlHttp.responseText;
			setTimeout("location.reload(true);",1000);
		}
}

function search_project()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="project_data.php";			
	url=url+"?Command="+"search_project_data";
	url=url+"&projectname="+document.getElementById('projectname').value;
	//alert(url);
	xmlHttp.onreadystatechange=searchresults;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function searchresults()
{
		var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
		//	alert(xmlHttp.responseText);		
		}
}


function clearform()
	{	
		setTimeout("location.reload(true);",3000);
	}

	
