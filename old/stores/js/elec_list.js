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


function elec_list()
{
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
			var url="eleclistdata.php";			
			url=url+"?Command="+"job_details";
			url=url+"&name="+document.getElementById('name').value;		
			url=url+"&address="+document.getElementById('address').value;	
			url=url+"&plk="+document.getElementById('plk').value;	
			url=url+"&town="+document.getElementById('town').value;	
			url=url+"&gramaseva_division="+document.getElementById('gramaseva_division').value;	
			url=url+"&nic="+document.getElementById('nic').value;				
			url=url+"&telno="+document.getElementById('telno').value;			
			url=url+"&political_approve="+document.getElementById('political_approve').value;
			url=url+"&job="+document.getElementById('job').checked;	
		//	alert(url);
		//alert(document.getElementById('job').checked);
			xmlHttp.onreadystatechange=getResult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);

	
}


function getResult()
{
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
			
		alert(xmlHttp.responseText);
	//	location.href="show_details.php";
		
		//document.getElementById("print_message").innerHTML=xmlHttp.responseText;
		
			
		}
}
