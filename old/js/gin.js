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

 

function print_inv()
{
	 
			var url="rep_gin.php";			
			url=url+"?invno="+document.getElementById('invno').value;
		 
			window.open(url,'_blank');
  		 
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
			 
			xmlHttp.onreadystatechange=passitresult_ind;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
	
}

function passitresult_ind()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		 
		var str=xmlHttp.responseText;
	 
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");	
		document.getElementById('itemd_hidden').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");	
		document.getElementById('itemd').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_partno");	
		document.getElementById('partno').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");	
		document.getElementById('stklevel').value = XMLAddress1[0].childNodes[0].nodeValue;
	 
			document.getElementById('qty').focus();
	 
		
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
	if (document.getElementById('invno').value!=""){
	
			 
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
	} else {
		alert("Sorry Please Click New");	
	}
}

function showarmyresultdel()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
	 
	  XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_validity");	
	  var chq_validity = XMLAddress1[0].childNodes[0].nodeValue;	
	
	  if (chq_validity=="yes"){
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txttot");	
		document.getElementById('txttot').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		 
		
		
		
	 
		document.getElementById('itemd_hidden').value="";
		document.getElementById('itemd').value="";
		document.getElementById('partno').value="";
		document.getElementById('qty').value="";
		
		document.getElementById('itemd_hidden').focus();
	  
	  } else {
		alert("Please Login Again !!!");  
	  }
	}
}


function keyset(key, e)
{	

   if(e.keyCode==13){
	document.getElementById(key).focus();
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
		 
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}

function clear_customer(){
	location.reload();
	 

}

function new_customer()
{
	clear_customer();
}

 
function save_inv(inv_status)
{   
	
	
	if (document.getElementById('to_dep').value =="") {
		alert("Please Select Department");	
		return;	
	}
	
	if (document.getElementById('invno').value!=""){		
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		//alert(inv_status);
	
		if (document.getElementById('cmdsave').value==1){
			var url="gin_data.php";			
			url=url+"?Command="+"save_item";
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&invdate="+document.getElementById('invdate').value;
			url=url+"&from_dep="+document.getElementById('from_dep').value;
 			url=url+"&to_dep="+document.getElementById('to_dep').value;
			url=url+"&txtarno="+document.getElementById('txtarno').value;
			url=url+"&DTARdate="+document.getElementById('DTARdate').value;
			
			document.getElementById('cmdsave').value="0";
		//alert(url);
			
			xmlHttp.onreadystatechange=salessaveresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		} else {
			alert("Cannot Save twice!");	
		}
	} else {
		alert("Please Click New !!!");	
	}
}

function salessaveresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		if (xmlHttp.responseText=="no item"){
			alert("Please Add Items ");	
		} else {
			alert(xmlHttp.responseText);
                        print_inv();
			setTimeout("location.reload(true);",0);
		}
		 
		
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
		 
		
	}
}


function assign_invno(){
 
	if (xmlHttp.responseText!="no"){
		document.getElementById('invno').value=xmlHttp.responseText;	
 
	} else {
		alert("Please Login Again !!!")	
	}
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
