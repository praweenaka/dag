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




function add_address()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="inv_data.php";			
			url=url+"?Command="+"add_address";
			url=url+"&customerid="+document.getElementById('firstname_hidden').value;
			//alert(url);
			xmlHttp.onreadystatechange=showarmyresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function showarmyresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
		document.getElementById('cus_address').value= xmlHttp.responseText;
	}
}

function setvisible()
{		
		if (document.getElementById('qbrand').value=="Over")
		{
			document.getElementById('over').innerHTML="Days ><input type=\"text\" name=\"dover\" id=\"dover\">";
		} else if (document.getElementById('qbrand').value=="Between")
		{
			document.getElementById('over').innerHTML="Days ><input type=\"text\" name=\"dover\" id=\"dover\">";
			document.getElementById('between').innerHTML="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<<input type=\"text\" name=\"dbetween\" id=\"dbetween\">";
		} else {
			document.getElementById('over').innerHTML="";
			document.getElementById('between').innerHTML="";
		}
			
}
