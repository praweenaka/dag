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


function close_form()
{
	self.close();	
}



function show_bal()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="balance_commission_data.php";			
			url=url+"?Command="+"show_bal";
			url=url+"&cmbrep="+document.getElementById('cmbrep').value;
			url=url+"&txtT1="+document.getElementById('txtT1').value;
			//url=url+"&txtT2="+document.getElementById('txtT2').value;
			//alert(url);
			xmlHttp.onreadystatechange=show_bal_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
	
}

function show_bal_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txttar");	
		document.getElementById('txttar').value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert("ok");
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtT1");	
		document.getElementById('txtT1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtT2");	
		document.getElementById('txtT2').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mtot");	
		document.getElementById('mtot').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("balance_table");	
		document.getElementById('comm_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

	}
}

function new_balance()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="balance_commission_data.php";			
			url=url+"?Command="+"new_balance";
			url=url+"&cmbrep="+document.getElementById('cmbrep').value;
			url=url+"&txtT1="+document.getElementById('txtT1').value;
			url=url+"&txtT2="+document.getElementById('txtT2').value;
			//alert(url);
			xmlHttp.onreadystatechange=show_bal_result_new;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
	
}

function show_bal_result_new()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
		//document.getElementById('comm_table').innerHTML= xmlHttp.responseText;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txttar");	
		document.getElementById('txttar').value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert("ok");
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtT1");	
		document.getElementById('txtT1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtT2");	
		document.getElementById('txtT2').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mtot");	
		document.getElementById('mtot').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("balance_table");	
		document.getElementById('comm_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
	}
}


function save_commis()
{
			
			
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
	
	var url="commission_data_post.php";			
	url=url+"?Command="+"save_commission";
	//var url="http://www.medispotlab.com/upload_to_db.php";	
	//var url="upload_to_db.php";	
	alert(url);
	var barnd_nam;
	var b60;
	var d60to75;
	var d75to90;
	var o90;
	
	var cou=1;
	
	params = "mcount="+document.getElementById('mtot').value;
	
	var mtot=document.getElementById('mtot').value;
	
	while (mtot > cou)
	{
		barnd_name="barnd_name"+cou;
		b60="b60"+cou;
		d60to75="d60to75"+cou;
		d75to90="d75to90"+cou;
		o90="o90"+cou;
	
		params = params+"&"+barnd_name+"="+document.getElementById(barnd_name).innerHTML+"&"+
		b60+"="+document.getElementById(b60).value+"&"+
		d60to75+"="+document.getElementById(d60to75).value+"&"+
		d75to90+"="+document.getElementById(d75to90).value+"&"+
		o90+"="+document.getElementById(o90).value;
	
		
		cou=cou+1;
	}
	
	alert(params);
	
		
	xmlHttp.open("POST", url, true);
	
	
	//Send the proper header information along with the request
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.setRequestHeader("Content-length", params.length);
	xmlHttp.setRequestHeader("Connection", "close");
	
	xmlHttp.onreadystatechange=save_commis_result;	
	
	
	
	xmlHttp.send(params);
}

function save_commis_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
	
		
		
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
		//document.getElementById('comm_table').innerHTML= xmlHttp.responseText;
		
	/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txttar");	
		document.getElementById('txttar').value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert("ok");
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtT1");	
		document.getElementById('txtT1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtT2");	
		document.getElementById('txtT2').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("balance_table");	
		document.getElementById('comm_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;*/
	}
}
