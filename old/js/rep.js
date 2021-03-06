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

function note_update()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			document.getElementById('txtnote').value=document.getElementById('txtnote').value+document.getElementById('txt_new').value;
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"note_update";
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&txtnote="+document.getElementById('txtnote').value;
			//alert(url);
			xmlHttp.onreadystatechange=result_note_update;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	

}

function result_note_update()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		var txt_cuscode=document.getElementById('txt_cuscode').value
		//custno(txt_cuscode, "cust_mast");
		
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
		//document.getElementById('cus_address').value= xmlHttp.responseText;
	}
}

function calc1()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			document.getElementById('subtotal').value=document.getElementById('rate').value*document.getElementById('qty').value;
			
		
	
}

function calc2()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			document.getElementById('subtotal').value=document.getElementById('subtotal').value-document.getElementById('discount').value;
			
		
	
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
			
			
			var url="inv_data.php";			
			url=url+"?Command="+"add_tmp";
			url=url+"&invno="+document.getElementById('invno').value;
			
			url=url+"&itemcode="+document.getElementById('itemd_hidden').value;
			
			url=url+"&item="+document.getElementById('itemd').value;
			
			url=url+"&rate="+document.getElementById('rate').value;
			url=url+"&qty="+document.getElementById('qty').value;
			url=url+"&discount="+document.getElementById('discount').value;
			url=url+"&subtotal="+document.getElementById('subtotal').value;
			
			//alert(url);
			xmlHttp.onreadystatechange=showarmyresultdel;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");	
		document.getElementById('subtot').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");	
		document.getElementById('invtot').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('invtot').value=document.getElementById('subtot').value-document.getElementById('totdiscount').value-document.getElementById('tax').value
		
		//document.getElementById('invno').value="";
		document.getElementById('itemd_hidden').value="";
		document.getElementById('itemd').value="";
		document.getElementById('rate').value="";
		document.getElementById('qty').value="";
		document.getElementById('discount').value="";
		document.getElementById('subtotal').value="";
	}
}



function cal_dis_tot()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			document.getElementById('invtot').value=document.getElementById('subtot').value-document.getElementById('totdiscount').value-document.getElementById('tax').value;
					
	
}

function cal_tax_tot()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			document.getElementById('invtot').value=document.getElementById('subtot').value-document.getElementById('totdiscount').value-document.getElementById('tax').value;
					
	
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

function del_item(code)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="inv_data.php";			
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

function save_inv()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var paymethod;
			
			var url="inv_data.php";			
			url=url+"?Command="+"save_item";
			if (document.getElementById('paymethod_0').value=="credit"){
				paymethod="CR";
			} else if (document.getElementById('paymethod_1').value=="cash"){
				paymethod="CA";
			}
			url=url+"&paymethod="+paymethod;
			url=url+"&salesord1="+document.getElementById('salesord1').value;
			url=url+"&salesord2="+document.getElementById('salesord2').value;
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&invdate="+document.getElementById('invdate').value;
			url=url+"&deldate="+document.getElementById('dte_dor').value;
			url=url+"&customercode="+document.getElementById('firstname_hidden').value;
			url=url+"&customername="+document.getElementById('firstname').value;
			url=url+"&cus_address="+document.getElementById('cus_address').value;
			url=url+"&orderno1="+document.getElementById('orderno1').value;
			url=url+"&orderdate="+document.getElementById('orderdate').value;
			url=url+"&vat1="+document.getElementById('vat1').value;
			url=url+"&vat2="+document.getElementById('vat2').value;
			url=url+"&creditlimit="+document.getElementById('creditlimit').value;
			url=url+"&balance="+document.getElementById('balance').value;
			url=url+"&salesrep="+document.getElementById('salesrep').value;
			url=url+"&department="+document.getElementById('department').value;
			url=url+"&brand="+document.getElementById('brand').value;
			
			if (document.getElementById('vatgroup_0').value=="vat"){
				vatmethod="vat";
			} else if (document.getElementById('vatgroup_1').value=="non"){
				vatmethod="non";
			} else if (document.getElementById('vatgroup_2').value=="svat"){
				vatmethod="svat";
			}
			
			url=url+"&vatmethod="+vatmethod;
			url=url+"&discount1="+document.getElementById('discount1').value;
			url=url+"&discount2="+document.getElementById('discount2').value;
			
			url=url+"&subtot="+document.getElementById('subtot').value;
			url=url+"&totdiscount="+document.getElementById('totdiscount').value;
			url=url+"&tax="+document.getElementById('tax').value;
			url=url+"&invtot="+document.getElementById('invtot').value;

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
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		//document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
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
			
			var paymethod;
			

			document.getElementById('paymethod_0').checked=true;
			document.getElementById('salesord1').value="";
			document.getElementById('salesord2').value="";
			document.getElementById('invno').value="";
			//document.getElementById('invdate').value="";
			document.getElementById('dte_dor').value="";
			document.getElementById('firstname_hidden').value="";
			document.getElementById('firstname').value="";
			document.getElementById('cus_address').value="";
			document.getElementById('orderno1').value="";
			document.getElementById('orderdate').value="";
			document.getElementById('vat1').value="";
			document.getElementById('vat2').value="";
			document.getElementById('creditlimit').value="";
			document.getElementById('balance').value="";
			document.getElementById('salesrep').value="";
		//alert("okkkk");	
			var objsalesrep = document.getElementById("salesrep");
			objsalesrep.options[0].selected=true;
			
			var objdepartment = document.getElementById("department");
			objdepartment.options[0].selected=true;
			
			var objbrand = document.getElementById("brand");
			objbrand.options[0].selected=true;
			
			
				
			document.getElementById('vatgroup_0').checked=true;
			document.getElementById('discount1').value="";
			document.getElementById('discount2').value="";
			document.getElementById('itemdetails').innerHTML="";
			document.getElementById('subtot').value="";
			document.getElementById('totdiscount').value="";
			document.getElementById('tax').value="";
			document.getElementById('invtot').value="";
			
			//document.getElementById('invdate').value=Date();
			
			var url="inv_data.php";			
			url=url+"?Command="+"new_inv";
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_invno(){
	//alert(xmlHttp.responseText);
	document.getElementById('invno').value=xmlHttp.responseText;	
	
}

function add_air()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="inv_data.php";			
			url=url+"?Command="+"add_air";
			url=url+"&airrank="+document.getElementById('airrank').value;
			url=url+"&airno="+document.getElementById('airno').value;
			
			xmlHttp.onreadystatechange=showairresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function showairresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("air_table");	
		document.getElementById('tblair').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}

function del_air(rank)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="inv_data.php";			
			url=url+"?Command="+"del_air";
			url=url+"&rank="+rank;
			
			
			xmlHttp.onreadystatechange=showairresultdel;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function showairresultdel()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("air_table");	
		document.getElementById('tblair').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}

function update_list()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_inv_data.php";			
			url=url+"?Command="+"search_inv";
			url=url+"&customername="+document.getElementById('customername').value;
			
					
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

function update_rep_list(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_rep_data.php";			
			url=url+"?Command="+"search_custom";
			
			if (document.getElementById('cusno').value!=""){
				url=url+"&mstatus=cusno";
			} else if (document.getElementById('customername').value!=""){
				url=url+"&mstatus=customername";
			}
			
			url=url+"&cusno="+document.getElementById('cusno').value;
			url=url+"&customername="+document.getElementById('customername').value;
			url=url+"&stname="+stname;
			
					
			xmlHttp.onreadystatechange=showcustresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function showcustresult()
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

function update_item_list()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_item_data.php";			
			url=url+"?Command="+"search_item";
			url=url+"&itemname="+document.getElementById('itemname').value;
			
					
			xmlHttp.onreadystatechange=showitemresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function showitemresult()
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

function assignbrand()
{
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
			var url="search_inv_data.php";			
			url=url+"?Command="+"assign_brand";
			url=url+"&brand="+document.getElementById('brand').value;
			//alert(url);
					
			//xmlHttp.onreadystatechange=passinvresultchk;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}


function invno(invno)
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_inv_data.php";			
			url=url+"?Command="+"pass_invno";
			url=url+"&invno="+invno;
			//alert(url);
					
			xmlHttp.onreadystatechange=passinvresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}


function passinvresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
	//	alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_invoiceno");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert(XMLAddress1[0].childNodes[0].nodeValue);
		opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
		//opener.document.form1.invno.value = "111111111";
		

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_crecash");	
		
		if(XMLAddress1[0].childNodes[0].nodeValue=='CR')
		{
			opener.document.form1.paymethod_0.checked=true;
		
		} else if(XMLAddress1[0].childNodes[0].nodeValue=='CA')
		{
			opener.document.form1.paymethod_1.checked=true;
			
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customecode");	
		opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");	
		opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address");	
		opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno1");	
		opener.document.form1.vat1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno2");	
	//	opener.document.form1.vat2.value = XMLAddress1[0].childNodes[0].nodeValue;


		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_salesrep");	
		var objSalesrep = opener.document.getElementById("salesrep");
		
		var i=0;
		while (i<objSalesrep.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		//alert(objSalesrep.length);

		

	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_salesorder1");	
	//	opener.document.form1.salesord1.value = XMLAddress1[0].childNodes[0].nodeValue;

	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_salesorder2");	
	//	opener.document.form1.salesord2.value = XMLAddress1[0].childNodes[0].nodeValue;

		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dte_deliverdate");	
		opener.document.form1.dte_dor.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_orderno1");	
		opener.document.form1.orderno1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_orderno2");	
		opener.document.form1.orderdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_credit");	
	//	opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_balance");	
	//	opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_department");	
		var objDepartment = opener.document.getElementById("department");
		
		var i=0;
		while (i<objDepartment.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objDepartment.options[i].value)
			{
				objDepartment.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_brand");	
		var objBrand = opener.document.getElementById("brand");
		
		var i=0;
		while (i<objBrand.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objBrand.options[i].value)
			{
				objBrand.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vat");	
		
		if(XMLAddress1[0].childNodes[0].nodeValue=='1')
		{
			opener.document.form1.vatgroup_0.checked=true;
		
		} else if(XMLAddress1[0].childNodes[0].nodeValue=='0')
		{
			opener.document.form1.vatgroup_1.checked=true;
			
		}
		
		//else if(XMLAddress1[0].childNodes[0].nodeValue=='svat')
		//{
		//	opener.document.form1.vatgroup_2.checked=true;
			
		//}
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount1");	
	//	opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount2");	
	//	opener.document.form1.discount2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_subtotal");	
		opener.document.form1.subtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount");	
		opener.document.form1.totdiscount.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_tax");	
		opener.document.form1.tax.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_invoiceval");	
		opener.document.form1.invtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
		window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		//window.opener.document.getElementById("test").innerHTML="TESTNBMSVMS"
		//opener.document.forminv.invno.value = "123";
		//myWindow.opener.document.invno.value = "123";
		self.close();
		//alert(myWindow.opener.document.getElementById('invno').value);
		//forminv.getElementById('invno').value="125";
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		//document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}

function ass_lim(credit_lim, rep, credit, balance, cat, brand)
{
	document.getElementById('txtlimit').value=credit_lim;
	
	
		var objSalesrep = document.getElementById("Com_rep");
		
		var i=0;
		objSalesrep.options[i].selected=true;
		while (i<objSalesrep.length)
		{
			if (rep == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		var objBrand = document.getElementById("cmbbrand");
		
		var i=0;
		objBrand.options[i].selected=true;
		while (i<objBrand.length)
		{
			if (brand == objBrand.options[i].value)
			{
				objBrand.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		var objCat = document.getElementById("cmbCAt");
		
		var i=0;
		objCat.options[i].selected=true;
		while (i<objCat.length)
		{
			if (cat == objCat.options[i].value)
			{
				objCat.options[i].selected=true;
				
			}
			i=i+1;
		}
		
}

function repno(repno, stname)
{   
			//alert(stname);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			opener.document.form1.txtcode.value = repno;
		/*	if (stname=="rep_mast"){
				var url="search_rep_data.php";			
				url=url+"?Command="+"pass_rep_mast";
				url=url+"&repno="+repno;
				xmlHttp.onreadystatechange=pass_rep_mast_result;
			
			}*/
			
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function pass_rep_mast_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("blacklist");
		
		if (XMLAddress1[0].childNodes[0].nodeValue=="1"){
			opener.document.form1.check1.checked = true;
		} else {
			opener.document.form1.check1.checked = false;
		}
		
		opener.document.form1.txt_cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");	
		opener.document.form1.txt_cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");	
		opener.document.form1.txtCNAME.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");	
		opener.document.form1.txtBADD1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");	
		opener.document.form1.txtBADD2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("OPBAL");	
	//	opener.document.form1.txt_crelimi.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TELE1");	
		opener.document.form1.txtTEL.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TELE2");	
		opener.document.form1.txttel2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CONT");	
		opener.document.form1.txtcper.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUR_BAL");	
		opener.document.form1.txtbal.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("LIMIT");	
		opener.document.form1.txtcrlimt.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PEN");	
		opener.document.form1.txtover.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("FAX");	
		opener.document.form1.txtFAX.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("acno");	
		opener.document.form1.txtACCno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("EMAIL");	
		opener.document.form1.TXTEMAIL.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CAT");	
		opener.document.form1.txtcat.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rep");	
		opener.document.form1.TXT_REP.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vatno");	
		opener.document.form1.txtvatno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("OPDATE");	
		opener.document.form1.DTOPDATE.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("area");	
		opener.document.form1.txtarea.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUS_TYPE");	
		opener.document.form1.txttype.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("note");	
		opener.document.form1.txtnote.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("temp_limit");	
		//opener.document.form1.txt_tmeplimit.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bank_gr_date");	
		opener.document.form1.DTbankgrdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("AltMessage");	
		opener.document.form1.txtMsg.value = XMLAddress1[0].childNodes[0].nodeValue;
					
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		window.opener.document.getElementById('creditlim').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cre_lim");	
		opener.document.form1.txtcrlimt.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		self.close();
		opener.document.form1.salesrep.focus();
	
		
	}
}

function update_limit()
{  
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"update_limit";
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&rep="+document.getElementById('Com_rep').value;
			url=url+"&brand="+document.getElementById('cmbbrand').value;
			url=url+"&txtlimit="+document.getElementById('txtlimit').value;
			url=url+"&cmbCAt="+document.getElementById('cmbCAt').value;
			url=url+"&stopinv="+document.getElementById('check1').checked;
			
			xmlHttp.onreadystatechange=passitresult_update_limit;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
	
}

function passitresult_update_limit()
{
	alert(xmlHttp.responseText);
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totcr");	
	document.getElementById('txtcrlimt').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cre_table");	
	alert(XMLAddress1[0].childNodes[0].nodeValue);
	document.getElementById('creditlim').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    
	alert("Updated");

}

function delete_limit()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"delete_limit";
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&rep="+document.getElementById('Com_rep').value;
			url=url+"&brand="+document.getElementById('cmbbrand').value;
			url=url+"&txtlimit="+document.getElementById('txtlimit').value;
			url=url+"&cmbCAt="+document.getElementById('cmbCAt').value;
			url=url+"&stopinv="+document.getElementById('check1').checked;
			
			xmlHttp.onreadystatechange=passitresult_delete_limit;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
	
}

function passitresult_delete_limit()
{
	//alert(xmlHttp.responseText);
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totcr");	
	document.getElementById('txtcrlimt').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cre_table");	
	document.getElementById('creditlim').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    
	alert("Deleted");

}

function passcusresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");	
		opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");	
		opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address");	
		opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno");	
		opener.document.form1.vat1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		self.close();
		opener.document.form1.salesrep.focus();
	
		
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

		
		self.close();
		opener.document.form1.qty.focus();
	
		
	}
}

function chk_opener()
{
	//alert("ok");
	//self.close();	
	//opener.document.form1.invno.value = document.bull.lon.value;
	opener.document.form1.invno.value = "123";
}

function keyset(key, e)
{	

   if(e.keyCode==13){
	document.getElementById(key).focus();
   }
}

function got_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000066";
  
}

function lost_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000000";
  
}


function tmp_crelimit()
{ 
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_item_data.php";			
			url=url+"?Command="+"tmp_crelimit";
			url=url+"&Com_rep1="+document.getElementById('Com_rep1').value;
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&cmbbrand1="+document.getElementById('cmbbrand1').value;
			url=url+"&txt_tmeplimit="+document.getElementById('txt_tmeplimit').value;
			
			if (document.getElementById('check1').checked==true)
			{
				var mcheck=1;
			} else {
				var mcheck=0;
			}
			url=url+"&check1="+mcheck;
			
				
			xmlHttp.onreadystatechange=result_tmp_crelimit;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function result_tmp_crelimit()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
	}
}
