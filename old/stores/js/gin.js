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


/*function print_inv()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
 
 	var url="arn_data.php";			
	url=url+"?Command="+"check_print";
  
    xmlHttp.onreadystatechange=passprintresult;
	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	
	
}*/

function print_inv()
{
	//var XMLAddress1;
	
	//if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	//{
		//alert(xmlHttp.responseText);
		//if (xmlHttp.responseText==1){
			var url="rep_gin.php";			
			url=url+"?invno="+document.getElementById('invno').value;
			url=url+"?invno="+document.getElementById('invno').value;
			url=url+"?invno="+document.getElementById('invno').value;
			window.open(url,'_blank');
  		//} else {
		//	alert("Invoice is not available");  
  		//}
	//}
}

function itno_ind()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_item_gin_data.php";			
			url=url+"?Command="+"pass_itno";
			url=url+"&itno="+document.getElementById('itemd_hidden').value;
			url=url+"&department="+document.getElementById('from_dep').value;
			/*url=url+"&brand="+opener.document.form1.from_dep.value;
			url=url+"&department="+opener.document.form1.department.value;
			
			var vatmethod="";
			if (opener.document.form1.vatgroup_0.checked==true){
				vatmethod="vat";
			} else if (opener.document.form1.vatgroup_1.checked==true){
				vatmethod="non";
			} else if (opener.document.form1.vatgroup_2.checked==true){
				vatmethod="svat";
			} else if (opener.document.form1.vatgroup_3.checked==true){
				vatmethod="evat";
			}
			
			url=url+"&vatmethod="+vatmethod;
			
			url=url+"&discount1="+opener.document.form1.discount1.value;
			url=url+"&discount2="+opener.document.form1.discount2.value;
			url=url+"&discount3="+opener.document.form1.discount3.value;*/
			
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
		var str=xmlHttp.responseText;
		
		if(str.length>70){
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");	
		document.getElementById('itemd_hidden').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");	
		document.getElementById('itemd').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_partno");	
		document.getElementById('partno').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");	
		document.getElementById('stklevel').value = XMLAddress1[0].childNodes[0].nodeValue;
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
	//	opener.document.form1.discount.value = XMLAddress1[0].childNodes[0].nodeValue;
			document.getElementById('qty').focus();
		} else {
			alert("Invalid Item No");
			document.getElementById('searchcust').focus();
		
		}
		
	}
}

function add_tmp()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			//alert(document.getElementById('stklevel').value);
			//alert(document.getElementById('qty').value);
		if (parseFloat(document.getElementById('stklevel').value)>=parseFloat(document.getElementById('qty').value)){
			var url="gin_data.php";			
			url=url+"?Command="+"add_tmp";
			url=url+"&invno="+document.getElementById('invno').value;
			
			url=url+"&itemcode="+document.getElementById('itemd_hidden').value;
			
			url=url+"&item="+document.getElementById('itemd').value;
			url=url+"&from_dep="+document.getElementById('from_dep').value;
			
			url=url+"&partno="+document.getElementById('partno').value;
			url=url+"&qty="+document.getElementById('qty').value;
			
			
			//alert(url);
			
			xmlHttp.onreadystatechange=showarmyresultdel;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		} else {
			alert("insufficient Quantity");	
		}
	
}

function showarmyresultdel()
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
		
	/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");	
		document.getElementById('subtot').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tot_dis");	
		document.getElementById('totdiscount').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tax");	
		document.getElementById('tax').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("taxname");	
		document.getElementById('taxname').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invtot");	
		document.getElementById('invtot').value = XMLAddress1[0].childNodes[0].nodeValue;*/
		
		
		
		//document.getElementById('invno').value="";
		document.getElementById('itemd_hidden').value="";
		document.getElementById('itemd').value="";
		document.getElementById('partno').value="";
		document.getElementById('qty').value="";
	
	}
}


function keyset(key, e)
{	

   if(e.keyCode==13){
	document.getElementById(key).focus();
   }
}

function shownavyresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("navy_table");	
		document.getElementById('tblnavy').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function update_list(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_gin_item_data.php";			
			url=url+"?Command="+"search_inv";
			
			if (document.getElementById('invno').value!=""){
				url=url+"&mstatus=invno";
			} else if (document.getElementById('customername').value!=""){
				url=url+"&mstatus=from";
			} else if (document.getElementById('invdate').value!=""){
				url=url+"&mstatus=to";
			}
			
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&customername="+document.getElementById('customername').value;
			url=url+"&invdate="+document.getElementById('invdate').value;
			url=url+"&stname="+stname;
			//alert(url);
					
			xmlHttp.onreadystatechange=showinvresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function showinvresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
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
			
			
			var url="gin_data.php";			
			url=url+"?Command="+"del_item";
			url=url+"&invno="+document.getElementById('invno').value;
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

function clear_customer(){
	location.reload();
	/*document.getElementById('txt_cuscode').value="";
	document.getElementById('txtCNAME').value="";
	document.getElementById('txtBADD1').value="";
	document.getElementById('txtBADD2').value="";
	document.getElementById('txtTEL').value="";
	document.getElementById('txttel2').value="";
	document.getElementById('txtFAX').value="";
	document.getElementById('TXTEMAIL').value="";
	document.getElementById('DTbankgrdate').value="";
	document.getElementById('DTOPDATE').value="";
	document.getElementById('txtcper').value="";
	document.getElementById('txtACCno').value="";
	document.getElementById('txtcrlimt').value="";
	document.getElementById('txtbal').value="";
	document.getElementById('txtover').value="";
	document.getElementById('txtvatno').value="";
	document.getElementById('txtcat').value="";
	document.getElementById('txttype').value="";
	document.getElementById('txtarea').value="";
	document.getElementById('TXT_REP').value="";
	document.getElementById('txtBRAND_NAME11').value="";
	document.getElementById('creditlim').innerHTML="";
	document.getElementById('txtlimit').value="";
	document.getElementById('cmbCAt').value="";
	document.getElementById('txtBRAND_NAME11').value="";*/

}

function new_customer()
{
	clear_customer();
}

function save_customer()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 	
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"save_customer";
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&txtCNAME="+document.getElementById('txtCNAME').value;
			url=url+"&txtBADD1="+document.getElementById('txtBADD1').value;
			url=url+"&txtBADD2="+document.getElementById('txtBADD2').value;
			url=url+"&txtTEL="+document.getElementById('txtTEL').value;
			url=url+"&txttel2="+document.getElementById('txttel2').value;
			url=url+"&txtFAX="+document.getElementById('txtFAX').value;
			url=url+"&TXTEMAIL="+document.getElementById('TXTEMAIL').value;
			url=url+"&DTbankgrdate="+document.getElementById('DTbankgrdate').value;
			url=url+"&DTOPDATE="+document.getElementById('DTOPDATE').value;
			url=url+"&txtcper="+document.getElementById('txtcper').value;
			url=url+"&txtACCno="+document.getElementById('txtACCno').value;
			url=url+"&txtcrlimt="+document.getElementById('txtcrlimt').value;
			url=url+"&txtbal="+document.getElementById('txtbal').value;
			url=url+"&txtover="+document.getElementById('txtover').value;
			url=url+"&txtvatno="+document.getElementById('txtvatno').value;
			url=url+"&txtcat="+document.getElementById('txtcat').value;
			url=url+"&txttype="+document.getElementById('txttype').value;
			url=url+"&txtarea="+document.getElementById('txtarea').value;
			url=url+"&TXT_REP="+document.getElementById('TXT_REP').value;
			url=url+"&txtInc="+document.getElementById('txtInc').value;
			url=url+"&chkgarant="+document.getElementById('chkgarant').value;
			url=url+"&txtMsg="+document.getElementById('txtMsg').value;

		
			xmlHttp.onreadystatechange=save_customer_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function save_customer_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		//document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}

function delete_customer()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 	
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"delete_customer";
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			

		
			xmlHttp.onreadystatechange=delete_customer_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function delete_customer_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		//document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}

function save_inv(inv_status)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		//alert(inv_status);
	
			var url="gin_data.php";			
			url=url+"?Command="+"save_item";
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&invdate="+document.getElementById('invdate').value;
			url=url+"&from_dep="+document.getElementById('from_dep').value;
 			url=url+"&to_dep="+document.getElementById('to_dep').value;
			url=url+"&txtarno="+document.getElementById('txtarno').value;
			url=url+"&DTARdate="+document.getElementById('DTARdate').value;
			
		///alert(url);
			
			xmlHttp.onreadystatechange=salessaveresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
}

function salessaveresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
	}
}


function gin(invno)
{   
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
			
			
			
				var url="gin_data.php";	
				url=url+"?Command="+"gin";
				url=url+"&invno="+invno;
				//alert(url);
				xmlHttp.onreadystatechange=passginresult;
				xmlHttp.open("GET",url,true);
				xmlHttp.send(null);
				
			
			
			
			
			
}

function passginresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REF_NO");
		opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");
		opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEP_FROM");
		opener.document.form1.from_dep.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEP_TO");
		opener.document.form1.to_dep.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("AR_NO");
		opener.document.form1.txtarno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("AR_DATE");
		opener.document.form1.DTARdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
		window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		self.close();
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
			
			var objsalesrep = document.getElementById("from_dep");
			objsalesrep.options[0].selected=true;
			
			var objsalesrep = document.getElementById("to_dep");
			objsalesrep.options[0].selected=true;
			
			document.getElementById('itemdetails').innerHTML="";
			document.getElementById('stklevel').value="";
			document.getElementById('itemd_hidden').value="";
			document.getElementById('itemd').value="";
			document.getElementById('partno').value="";
			document.getElementById('qty').value="";
			document.getElementById('txtarno').value="";
			document.getElementById('DTARdate').value="";
			
			
			
			//document.getElementById('invdate').value=Date();*/
			
			var url="gin_data.php";			
			url=url+"?Command="+"new_inv";
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function close_form()
{
	self.close();	
}

function cancel_inv()
{
		xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		//alert(inv_status);
			
			var url="gin_data.php";			
			url=url+"?Command="+"cancel_inv";
		
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&from_dep="+document.getElementById('from_dep').value;
			url=url+"&to_dep="+document.getElementById('to_dep').value;
						
			xmlHttp.onreadystatechange=salescancelresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function salescancelresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
	}
}


function assign_invno(){
	//alert("ok");
//	alert(xmlHttp.responseText);
	document.getElementById('invno').value=xmlHttp.responseText;	
//	document.getElementById('credper').value=65;
//	document.getElementById('searchcust').focus();
	
}

function update()
{
	//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="gin_data.php";			
			url=url+"?Command="+"update";
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&txtarno="+document.getElementById('txtarno').value;
			url=url+"&DTARdate="+document.getElementById('DTARdate').value;
			//alert(url);
			
			xmlHttp.onreadystatechange=passupdate;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function passupdate()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		
	}
	
}

function itno(itno)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_item_data.php";			
			url=url+"?Command="+"pass_itno";
			url=url+"&itno="+itno;
			url=url+"&brand="+opener.document.form1.brand.value;
			url=url+"&department="+opener.document.form1.department.value;
			
			var vatmethod="";
			if (opener.document.form1.vatgroup_0.checked==true){
				vatmethod="vat";
			} else if (opener.document.form1.vatgroup_1.checked==true){
				vatmethod="non";
			} else if (opener.document.form1.vatgroup_2.checked==true){
				vatmethod="svat";
			} else if (opener.document.form1.vatgroup_3.checked==true){
				vatmethod="evat";
			}
			
			url=url+"&vatmethod="+vatmethod;
			
			url=url+"&discount1="+opener.document.form1.discount1.value;
			url=url+"&discount2="+opener.document.form1.discount2.value;
			url=url+"&discount3="+opener.document.form1.discount3.value;
			
			//alert(url);
			xmlHttp.onreadystatechange=passitresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
	
}

function passitresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");	
		opener.document.form1.itemd_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");	
		opener.document.form1.itemd.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_selpri");	
		opener.document.form1.rate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");	
		opener.document.form1.stklevel.value = XMLAddress1[0].childNodes[0].nodeValue;
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
	//	opener.document.form1.discount.value = XMLAddress1[0].childNodes[0].nodeValue;

		
		self.close();
		opener.document.form1.qty.focus();
		
	
		
	}
}
