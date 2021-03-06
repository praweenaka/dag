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

function close_form()
{
	self.close();	
}


function save_balance_item()
{
			
			
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
	
	var url="balance_commission_data.php";			
	url=url+"?Command="+"save_balance_item";
	//var url="http://www.medispotlab.com/upload_to_db.php";	
	//var url="upload_to_db.php";	
	
	var	comid;
	var	barnd_name;
	var	t1cat1;
	var	t1cat2;
	var	t1cat3;
	var	t2cat1;
	var	t2cat2;
	var	t2cat3;
	var	t3cat1;
	var	t3cat2;
	var	t3cat3;
	var day1;
	var day2;
	
	var cou=1;
	
	params = "Command=save_balance_item&mcount="+document.getElementById('mtot').value+"&"+
	"sal_ex="+document.getElementById('cmbrep').value;
	var mtot=document.getElementById('mtot').value;
	
	while (mtot > cou)
	{
		
		id="id"+cou;
		brand="brand"+cou;
		t1cat1="T1_cat1"+cou;
		t1cat2="T1_cat2"+cou;
		t1cat3="T1_cat3"+cou;
		t2cat1="T2_cat1"+cou;
		t2cat2="T2_cat2"+cou;
		t2cat3="T2_cat3"+cou;
		t3cat1="T3_cat1"+cou;
		t3cat2="T3_cat2"+cou;
		t3cat3="T3_cat3"+cou;
	 	day1="Day1"+cou;
	 	day2="Day2"+cou;
		
		params = params+"&"+id+"="+document.getElementById(id).value+"&"+
		brand+"="+document.getElementById(brand).innerHTML+"&"+
		t1cat1+"="+document.getElementById(t1cat1).value+"&"+
		t1cat2+"="+document.getElementById(t1cat2).value+"&"+
		t1cat3+"="+document.getElementById(t1cat3).value+"&"+
		t2cat1+"="+document.getElementById(t2cat1).value+"&"+
		t2cat2+"="+document.getElementById(t2cat2).value+"&"+
		t2cat3+"="+document.getElementById(t2cat3).value+"&"+
		t3cat1+"="+document.getElementById(t3cat1).value+"&"+
		t3cat2+"="+document.getElementById(t3cat2).value+"&"+
		t3cat3+"="+document.getElementById(t3cat3).value+"&"+
		day1+"="+document.getElementById(day1).value+"&"+
		day2+"="+document.getElementById(day2).value;
		
		cou=cou+1;
	}
	
	//alert(params);
	
		
	xmlHttp.open("POST", url, true);
	
	
	//Send the proper header information along with the request
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.setRequestHeader("Content-length", params.length);
	xmlHttp.setRequestHeader("Connection", "close");
	
	xmlHttp.onreadystatechange=save_bal_result_item;	
	
	
	
	xmlHttp.send(params);
}

function save_bal_result_item()
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
