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



function itno_undeliver_ind()
{   
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_item_data.php";			
			url=url+"?Command="+"pass_itno_undeliver";
			url=url+"&itno="+document.getElementById('itemd_hidden').value;
			
			//alert(url);
			xmlHttp.onreadystatechange=itno_undeliver_result_ind;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
	
}

function itno_undeliver_result_ind()
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
		//self.close();

		
	
		
	}
}

function keyset(key, e)
{	

   if(e.keyCode==13){
	document.getElementById(key).focus();
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
			
		
		if (document.getElementById('refno').value!=""){
			
			var url="inventory_entry_data.php";			
			url=url+"?Command="+"del_item";
			url=url+"&refno="+document.getElementById('refno').value;
			
			url=url+"&itemcode="+code;
			
			xmlHttp.onreadystatechange=showarmyresultadd_del_item;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
		} else {
			alert("Please enter Invoice No");	
		}
	
}

function showarmyresultadd_del_item()
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
		document.getElementById('damage').value="";
		
		
		document.getElementById('itemd_hidden').focus();
	}
}

function add_tmp()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
		
		if (document.getElementById('refno').value!=""){
			
			var url="inventory_entry_data.php";			
			url=url+"?Command="+"add_tmp";
			url=url+"&refno="+document.getElementById('refno').value;
			
			url=url+"&itemcode="+document.getElementById('itemd_hidden').value;
			
			url=url+"&item="+document.getElementById('itemd').value;
			url=url+"&part_no="+document.getElementById('part_no').value;
			url=url+"&rate="+document.getElementById('rate').value;
			url=url+"&qty="+document.getElementById('qty').value;
			url=url+"&damage="+document.getElementById('damage').value;
			
			
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
		//alert(xmlHttp.responseText);
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
		document.getElementById('damage').value="";
		
		
		document.getElementById('itemd_hidden').focus();
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
		document.getElementById('damage').value="";
		document.getElementById('itemdetails').innerHTML="";
		document.getElementById('location').value="";	
			var url="inventory_entry_data.php";			
			url=url+"?Command="+"new_inv";
			//url=url+"&salesrep="+document.getElementById('salesrep').value;
			//alert(url);	
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function assign_invno()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert("Ok");
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
	}
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");	
		document.getElementById('subtot').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tot_dis");	
		document.getElementById('totdiscount').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tax");	
		document.getElementById('tax').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("taxname");	
		document.getElementById('taxname').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invtot");	
		document.getElementById('invtot').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	}
}

function find_inv()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
		
		
			var url="inventory_entry_data.php";			
			url=url+"?Command="+"find_inv";
			url=url+"&refno="+document.getElementById('refno').value;
			
			
			xmlHttp.onreadystatechange=showarmyresult_find_inv;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
	
	
}

function showarmyresult_find_inv()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("location");	
		
		document.getElementById('location').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		
		document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		//location.reload(true);
		
		//document.getElementById('invno').value="";
		document.getElementById('itemd_hidden').value="";
		document.getElementById('itemd').value="";
		document.getElementById('part_no').value="";
		document.getElementById('rate').value="";
		document.getElementById('qty').value="";
		document.getElementById('damage').value="";
		
		
		document.getElementById('itemd_hidden').focus();
	}
}


function cancel_inv()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
		
		
			var url="inventory_entry_data.php";			
			url=url+"?Command="+"cancel_inv";
			url=url+"&refno="+document.getElementById('refno').value;
			
			
			xmlHttp.onreadystatechange=showarmyresult_cancel_inv;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
	
	
}

function showarmyresult_cancel_inv()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		document.getElementById('location').value = "";
		document.getElementById('itemdetails').innerHTML = "";
		
		
		
		//location.reload(true);
		
		//document.getElementById('invno').value="";
		document.getElementById('itemd_hidden').value="";
		document.getElementById('itemd').value="";
		document.getElementById('part_no').value="";
		document.getElementById('rate').value="";
		document.getElementById('qty').value="";
		document.getElementById('damage').value="";
		
		
		document.getElementById('itemd_hidden').focus();
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
			
		
		if (document.getElementById('refno').value!=""){
			
			var url="inventory_entry_data.php";			
			url=url+"?Command="+"save_item";
			url=url+"&refno="+document.getElementById('refno').value;
			url=url+"&location="+document.getElementById('location').value;
	
			
			
			
			xmlHttp.onreadystatechange=showarmyresult_save_inv;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
		} else {
			alert("Please enter Invoice No");	
		}
	
}

function showarmyresult_save_inv()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
	}
}

function print_inv()
{
	
			var url="report_stock_take.php";			
			url=url+"?refno="+document.getElementById('refno').value;
			
			window.open(url);
  	
}
