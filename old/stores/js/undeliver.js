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

function add_tmp()
{   
	
			alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
		
		if (document.getElementById('refno').value!=""){
			
			var url="un_delivered_data.php";			
			url=url+"?Command="+"add_tmp";
			url=url+"&refno="+document.getElementById('refno').value;
			
			url=url+"&itemcode="+document.getElementById('itemd_hidden').value;
			
			url=url+"&item="+document.getElementById('itemd').value;
			url=url+"&part_no="+document.getElementById('part_no').value;
			url=url+"&rate="+document.getElementById('rate').value;
			url=url+"&qty="+document.getElementById('qty').value;
			
			
			
			xmlHttp.onreadystatechange=showarmyresultadd_tmp;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
		} else {
			alert("Please enter Invoice No");	
		}
	
}

function showarmyresultadd_tmp()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		//location.reload(true);
		
		//document.getElementById('invno').value="";
		document.getElementById('itemd_hidden').value="";
		document.getElementById('itemd').value="";
		document.getElementById('part_no').value="";
		document.getElementById('rate').value="";
		document.getElementById('qty').value="";
		
		
		document.getElementById('itemd_hidden').focus();
	}
}

function keyset(key, e)
{	

   if(e.keyCode==13){
	document.getElementById(key).focus();
   }
}

function new_inv()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
		document.getElementById('refno').value="";
		document.getElementById('itemd_hidden').value="";
		document.getElementById('itemd').value="";
		document.getElementById('part_no').value="";
		document.getElementById('rate').value="";
		document.getElementById('qty').value="";
		
		document.getElementById('refno').focus();
		
	/*	
		
			
			var url="un_delivered_data.php";			
			url=url+"?Command="+"new_inv";
			
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);*/
			
}

function assign_invno(){
	//alert(xmlHttp.responseText);
	document.getElementById('salesord1').value=xmlHttp.responseText;	
	document.getElementById('itemd_hidden').focus();
	
}

function itno_ind()
{   
//alert("ok");
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_item_data.php";			
			url=url+"?Command="+"pass_itno_undeliver";
			url=url+"&itno="+document.getElementById('itemd_hidden').value;
			//url=url+"&stname="+stname;
			
			
			//alert(url);
			xmlHttp.onreadystatechange=passitresult_ind;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
	
}

function passitresult_ind()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");	
		document.getElementById('itemd_hidden').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");	
		document.getElementById('itemd').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PART_NO");	
		document.getElementById('part_no').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("COST");	
		document.getElementById('rate').value = XMLAddress1[0].childNodes[0].nodeValue;
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
	//	opener.document.form1.discount.value = XMLAddress1[0].childNodes[0].nodeValue;

		
		document.getElementById('qty').focus();
		
		
	
		
	}
}


function save_inv()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
	
			
			var url="un_delivered_data.php";			
			url=url+"?Command="+"save_item";
			
			url=url+"&refno="+document.getElementById('refno').value;
			

			//alert(url);
			
			xmlHttp.onreadystatechange=salessaveresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		//}
	
}

function salessaveresult()
{
	var XMLAddress1;
	//alert(xmlHttp.responseText);
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
		alert(xmlHttp.responseText);
		
		location.reload(true);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		//document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function cancel_inv()
{
		
	var msg=confirm("Are you sure to CANCEL ! ");
	if (msg==true){
		xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
					
			var url="un_delivered_data.php";			
			url=url+"?Command="+"cancel_inv";
			url=url+"&refno="+document.getElementById('refno').value;
		
			//alert(url);
			
			xmlHttp.onreadystatechange=showarmyresultcancel_inv;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	}
}


function showarmyresultcancel_inv()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		location.reload(true);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		//document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

	}
	
}


function find_inv()
{
	{   
				
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="un_delivered_data.php";			
			url=url+"?Command="+"find_inv";
			url=url+"&refno="+document.getElementById('refno').value;
			
	
			//alert(url);
			
			xmlHttp.onreadystatechange=find_inv_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);

}

function find_inv_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
	}
}

function del_item(code)
{   
				
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="un_delivered_data.php";			
			url=url+"?Command="+"del_item";
			url=url+"&refno="+document.getElementById('refno').value;
			url=url+"&code="+code;
	
			//alert(url);
			
			xmlHttp.onreadystatechange=itemresultdel;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function itemresultdel()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
	}
}
