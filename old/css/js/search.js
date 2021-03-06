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




function searchoff()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="search_data.php";			
			
			
			if (document.getElementById('txtoffno').value != "")
			{
				url=url+"?Command="+"search_id";
			} else if (document.getElementById('txtoffname').value != ""){
				url=url+"?Command="+"search_name";
			}
										
			url=url+"&txtoffno="+document.getElementById('txtoffno').value;
			url=url+"&txtoffname="+document.getElementById('txtoffname').value;
			
			xmlHttp.onreadystatechange=showsearchresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function showsearchresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		if (xmlHttp.responseText!="no"){
			var url="officercurrent.php?int_Officer_Inique_ID="+xmlHttp.responseText;
			//xmlHttp.onreadystatechange=searchresult;
			//xmlHttp.open("GET",url,true);
			//xmlHttp.send(null);
			window.location = url;
		

		} else {
			alert("Not Exist");
		}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
		//document.getElementById('tblarmy').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}

function searchresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		
			alert("ok");
	
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
		//document.getElementById('tblarmy').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}


