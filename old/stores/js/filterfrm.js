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




function add_edu()
{   
	
		if(document.getElementById('edu').value=="")
		{
			document.getElementById("err_nic").innerHTML="Please Enter Degree/Diploma/Certificate";
			document.getElementById("edu").focus();
			return false;
		}
		
		else
		{
			
			document.getElementById("err_nic").innerHTML="";
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var strEdu=document.getElementById('edu').value;
			
			
			var url="filterfrm_data.php";			
			url=url+"?Command="+"edu_add";
			url=url+"&edu="+strEdu.replace("&","/");
			url=url+"&edu_critaria="+document.getElementById('edu_critaria').value;
			//alert(url);
			xmlHttp.onreadystatechange=showeduresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
		

	
}

function showeduresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("edu_table");	
		document.getElementById('tbledu').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}



function add_quli()
{   
	 
		if(document.getElementById('qulifi').value=="")
		{
			document.getElementById("err_nic2").innerHTML=" Professional Qualification";
			document.getElementById("qulifi").focus();
			return false;
		}
		
		else
		{
			
			document.getElementById("err_nic2").innerHTML="";
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var strQulifi=document.getElementById('qulifi').value;
			
			var url="filterfrm_data.php";			
			url=url+"?Command="+"quali_add";
			url=url+"&qulifi="+strQulifi.replace("&","/");
			url=url+"&quli_critaria="+document.getElementById('quli_critaria').value;
			//alert(url);
			
			xmlHttp.onreadystatechange=showqualiresult1;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
		

	
}

function showqualiresult1()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("quali_table");	
		document.getElementById('tblquali').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}




function preview()
{   
	
				
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="filterreport.php";			
			url=url+"?Command="+"report_preview";
			url=url+"&services="+document.getElementById('services').value;
			url=url+"&edu="+document.getElementById('edu').value;
			url=url+"&s2="+document.getElementById('s2').value;
			url=url+"&s3="+document.getElementById('s3').value;
			url=url+"&qulifi="+document.getElementById('qulifi').value;
			
			xmlHttp.onreadystatechange=showqualiresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
		

	
}

function showqualiresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("quali_table");	
		document.getElementById('tblquali').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}