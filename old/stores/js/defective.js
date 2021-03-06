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


function SetListName()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="search_claimlist_data.php";			
			url=url+"?Command="+"SetListName";
			url=url+"&tyre="+document.getElementById('tyre').checked;
			url=url+"&battery="+document.getElementById('battery').checked;
			url=url+"&Option1="+document.getElementById('Option1').checked;
			url=url+"&Option2="+document.getElementById('Option2').checked;
			url=url+"&Option3="+document.getElementById('Option3').checked;
			alert(url);
			xmlHttp.onreadystatechange=SetListName_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
}

function SetListName_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
		//document.getElementById('cus_address').value= xmlHttp.responseText;
	}
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
			
			var str=document.getElementById('rate').value;
			var n=str.replace(/,/gi, ""); 
			
			var subtotal=parseFloat(n)*parseFloat(document.getElementById('qty').value);
			var dis=0;
			var dis1=0;
			var dis2=0;
			var dis3=0;
			var disper=0;
			
			if (document.getElementById('discount1').value == '0.00'){ document.getElementById('discount1').value=''; }
			if (document.getElementById('discount2').value == '0.00'){ document.getElementById('discount2').value=''; }
			if (document.getElementById('discount3').value == '0.00'){ document.getElementById('discount3').value=''; }
			
			if (document.getElementById('discount1').value != ''){
				dis1=subtotal*parseFloat(document.getElementById('discount1').value)/100;
				disper=parseFloat(document.getElementById('discount1').value);
				
			}
			dis1f=dis1.toFixed(2);
			subtotal=subtotal-dis1f;
			
			if (document.getElementById('discount2').value != ''){
				dis2=subtotal*parseFloat(document.getElementById('discount2').value)/100;
				disper=100-(100-parseFloat(document.getElementById('discount2').value))*(100-parseFloat(document.getElementById('discount1').value))/100;
			}
			dis2f=dis2.toFixed(2);
			subtotal=subtotal-dis2f;
			
			if (document.getElementById('discount3').value != ''){
				dis3=subtotal*parseFloat(document.getElementById('discount3').value)/100;
				disper=100-(100-parseFloat(document.getElementById('discount3').value))*(100-parseFloat(document.getElementById('discount2').value))*(100-parseFloat(document.getElementById('discount1').value))/100;
			}
			dis3f=dis3.toFixed(2);
			subtotal=subtotal-dis3f;
			
			dis=parseFloat(dis1f)+parseFloat(dis2f)+parseFloat(dis3f);
			
			document.getElementById('discount').value=dis;
			document.getElementById('discountper').value=disper;
			document.getElementById('subtotal').value= subtotal.toFixed(2);
			
		
	
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


function defect(refno)
{   
	//alert(grn);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="defective_data.php";			
			url=url+"?Command="+"pass_defectno";
			url=url+"&txtrefno="+refno;
			
		
	//alert(url);
			xmlHttp.onreadystatechange=pass_defect_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function pass_defect_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtrefno");	
		//opener.document.form1.txtrefno.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_cuscode");	
		opener.document.form1.txt_cuscode.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_cusname");	
		opener.document.form1.txt_cusname.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtadd");	
		opener.document.form1.txtadd.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vatgroup");	
		if (XMLAddress1[0].childNodes[0].nodeValue=='1'){
			opener.document.form1.vatgroup_0.checked=true;
		} else {
			opener.document.form1.vatgroup_1.checked=true;
		}
				
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcl_no");	
		opener.document.form1.txtcl_no.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtbat");	
		opener.document.form1.txtbat.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremark");	
		opener.document.form1.txtremark.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cmbres");	
		opener.document.form1.Cmbres.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("itemno");	
		opener.document.form1.itemno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_name");	
		opener.document.form1.item_name.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("partno");	
		opener.document.form1.partno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rate");	
		opener.document.form1.rate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qty");	
		opener.document.form1.qty.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("discou");	
		opener.document.form1.discou.value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert("ok");
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");	
		opener.document.form1.subtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("refund");	
		opener.document.form1.refund.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("total");	
		opener.document.form1.total.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_net");	
		opener.document.form1.txt_net.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		/*XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SAL_EX");	
		opener.document.form1.salesrep.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Brand");	
		opener.document.form1.brand.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEPARTMENT");	
		opener.document.form1.department.value = XMLAddress1[0].childNodes[0].nodeValue;*/
		
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
	//	window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		self.close();
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REF_NO");	
	//	document.getElementById('invno').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function defect_d(refno)
{   
	//alert(grn);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="defective_data.php";			
			url=url+"?Command="+"pass_defectno";
			url=url+"&txtrefno="+refno;
			
		
	//alert(url);
			xmlHttp.onreadystatechange=pass_defect_result_d;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function pass_defect_result_d()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtrefno");	
		opener.document.form1.txtrefno.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_cuscode");	
		opener.document.form1.txt_cuscode.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_cusname");	
		opener.document.form1.txt_cusname.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtadd");	
		opener.document.form1.txtadd.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vatgroup");	
		if (XMLAddress1[0].childNodes[0].nodeValue=='1'){
			opener.document.form1.vatgroup_0.checked=true;
		} else {
			opener.document.form1.vatgroup_1.checked=true;
		}
				
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcl_no");	
		opener.document.form1.txtcl_no.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremark");	
		opener.document.form1.txtremark.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cmbres");	
		opener.document.form1.Cmbres.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("itemno");	
		opener.document.form1.itemno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_name");	
		opener.document.form1.item_name.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("partno");	
		opener.document.form1.partno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rate");	
		opener.document.form1.rate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qty");	
		opener.document.form1.qty.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("discou");	
		opener.document.form1.discou.value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert("ok");
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");	
		opener.document.form1.subtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("refund");	
		opener.document.form1.refund.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("total");	
		opener.document.form1.total.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_net");	
		opener.document.form1.txt_net.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		/*XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SAL_EX");	
		opener.document.form1.salesrep.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Brand");	
		opener.document.form1.brand.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEPARTMENT");	
		opener.document.form1.department.value = XMLAddress1[0].childNodes[0].nodeValue;*/
		
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
	//	window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		self.close();
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REF_NO");	
	//	document.getElementById('invno').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function settotal()
{
	if (document.getElementById('discou').value<=100){
	document.getElementById('subtot').value = (parseFloat(document.getElementById('rate').value)*parseFloat(document.getElementById('qty').value)) - (parseFloat(document.getElementById('rate').value) * parseFloat(document.getElementById('qty').value) * parseFloat(document.getElementById('discou').value) * 0.01);
	
	document.getElementById('total').value =  parseFloat(document.getElementById('subtot').value) * parseFloat(document.getElementById('refund').value) *  0.01;
	
	document.getElementById('txt_net').value =  parseFloat(document.getElementById('subtot').value) * parseFloat(document.getElementById('refund').value) *  0.01;
	} else {
		alert("Invalied Discount");	
		document.getElementById('discou').value=0;
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
			
					
			var url="ord_data.php";			
			url=url+"?Command="+"cancel_inv";
			url=url+"&salesord1="+document.getElementById('salesord1').value;
		
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


function close_form()
{
	self.close();	
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
			
			document.getElementById('discount1').disabled=true;
			document.getElementById('discount2').disabled=true;
			document.getElementById('discount3').disabled=true;
			
			var url="ord_data.php";			
			url=url+"?Command="+"add_tmp";
			url=url+"&invno="+document.getElementById('salesord1').value;
			
			url=url+"&itemcode="+document.getElementById('itemd_hidden').value;
			
			url=url+"&item="+document.getElementById('itemd').value;
			url=url+"&department="+document.getElementById('department').value;
			url=url+"&rate="+document.getElementById('rate').value;
			url=url+"&qty="+document.getElementById('qty').value;
			url=url+"&discount="+document.getElementById('discount').value;
			url=url+"&discountper="+document.getElementById('discountper').value;
			url=url+"&subtotal="+document.getElementById('subtotal').value;
			
			
			if (document.getElementById('vatgroup_0').checked==true){
				vatmethod="vat";
			} else if (document.getElementById('vatgroup_1').checked==true){
				vatmethod="non";
			} else if (document.getElementById('vatgroup_2').checked==true){
				vatmethod="svat";
			} else if (document.getElementById('vatgroup_3').checked==true){
				vatmethod="evat";
			}
			url=url+"&vatmethod="+vatmethod;
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tot_dis");	
		document.getElementById('totdiscount').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tax");	
		document.getElementById('tax').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("taxname");	
		document.getElementById('taxname').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invtot");	
		document.getElementById('invtot').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		//location.reload(true);
		
		//document.getElementById('invno').value="";
		document.getElementById('itemd_hidden').value="";
		document.getElementById('itemd').value="";
		document.getElementById('rate').value="";
		document.getElementById('qty').value="";
		document.getElementById('discount').value="";
		document.getElementById('discountper').value="";
		document.getElementById('subtotal').value="";
		
		document.getElementById('searchitem').focus();
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

function del_item(code)
{   
				
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="ord_data.php";			
			url=url+"?Command="+"del_item";
			url=url+"&invno="+document.getElementById('salesord1').value;
			url=url+"&code="+code;
			url=url+"&department="+document.getElementById('department').value;
			
			if (document.getElementById('vatgroup_0').checked==true){
				vatmethod="vat";
			} else if (document.getElementById('vatgroup_1').checked==true){
				vatmethod="non";
			} else if (document.getElementById('vatgroup_2').checked==true){
				vatmethod="svat";
			} else if (document.getElementById('vatgroup_3').checked==true){
				vatmethod="evat";
			}
			url=url+"&vatmethod="+vatmethod;
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

function save_inv()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
		if ((document.getElementById('txtrefno').value != "") && (document.getElementById('txt_net').value > 0)) {
		//if (parseFloat(document.getElementById('balance').value) < 0) 
		//{
		//	alert("Unable to Save");
		//} else {


			var url="defective_data.php";			
			url=url+"?Command="+"save_item";
			url=url+"&txtrefno="+document.getElementById('txtrefno').value;
			
			//url=url+"&invdate="+document.getElementById('invdate').value;
			url=url+"&dtdate="+document.getElementById('dtdate').value;
			url=url+"&Com_rep="+document.getElementById('Com_rep').value;
			
			//url=url+"&brand_name="+document.getElementById('brand_name').value;
			
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&txt_cusname="+document.getElementById('txt_cusname').value;
			url=url+"&txt_net="+document.getElementById('txt_net').value;
			url=url+"&com_dep="+document.getElementById('com_dep').value;
			
			url=url+"&dtdate="+document.getElementById('dtdate').value;
			url=url+"&txtbat="+document.getElementById('txtbat').value;
			url=url+"&txtcl_no="+document.getElementById('txtcl_no').value;
			url=url+"&Cmbres="+document.getElementById('Cmbres').value;
			url=url+"&cmbShip="+document.getElementById('cmbShip').value;
				
			url=url+"&itemno="+document.getElementById('itemno').value;
			url=url+"&rate="+document.getElementById('rate').value;
			url=url+"&qty="+document.getElementById('qty').value;
			url=url+"&discou="+document.getElementById('discou').value;
			if (document.getElementById('refund').value=="")
			{
				url=url+"&refund=0";
			} else {
				url=url+"&refund="+document.getElementById('refund').value;	
			}
			
			url=url+"&total="+document.getElementById('total').value;
			
			if (document.getElementById('vatgroup_0').checked==true){
				vatmethod="vat";
			} else if (document.getElementById('vatgroup_1').checked==true){
				vatmethod="non";
			} else if (document.getElementById('vatgroup_2').checked==true){
				vatmethod="svat";
			} else if (document.getElementById('vatgroup_3').checked==true){
				vatmethod="evat";
			}
			url=url+"&vatmethod="+vatmethod;
			
			

			
			
			xmlHttp.onreadystatechange=salessaveresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		} else {
			alert("refno already exists");	
		}
		
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
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		//document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function delete_inv()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
	
		//if (parseFloat(document.getElementById('balance').value) < 0) 
		//{
		//	alert("Unable to Save");
		//} else {
			var paymethod;
			
			var url="ord_data.php";			
			url=url+"?Command="+"delete_inv";
			url=url+"&salesord1="+document.getElementById('salesord1').value;
			
			xmlHttp.onreadystatechange=delete_inv_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);

		}

function delete_inv_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		location.reload();
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
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
			
			
			
			document.getElementById('txtrno').value="";
			///document.getElementById('salesord2').value="";
			
			//document.getElementById('invno').value="";
				
			//document.getElementById('invdate').value="";
			document.getElementById('txt_cuscode').value="";
			document.getElementById('txt_cusname').value="";
		
			document.getElementById('txtadd').value="";
			
			document.getElementById('txtadd').value="";
			//document.getElementById('orderno1').value="";
			
			//document.getElementById('orderdate').value="";
			document.getElementById('txtremark').value="";
			document.getElementById('txtbat').value="";
			document.getElementById('txtcl_no').value="";
			document.getElementById('itemno').value="";
			document.getElementById('item_name').value="";
			
			document.getElementById('partno').value="";
			document.getElementById('rate').value="";
			document.getElementById('qty').value="";
			document.getElementById('discount').value="";
			document.getElementById('discou').value="";
			document.getElementById('subtot').value="";
			document.getElementById('txt_net').value="";
			
			
			//document.getElementById('invdate').value=Date();
			
			var url="defective_data.php";			
			url=url+"?Command="+"new_inv";
			//alert(url);
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_invno(){
	//alert(xmlHttp.responseText);
	document.getElementById('txtrefno').value=xmlHttp.responseText;	
	
	//document.getElementById('searchcust').focus();
	
}

function setord()
{
		xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
	var url="ord_data.php";			
	url=url+"?Command="+"setord";
	url=url+"&custno="+document.getElementById('firstname_hidden').value;
	url=url+"&salesord1="+document.getElementById('salesord1').value;
	url=url+"&salesrep="+document.getElementById('salesrep').value;
	url=url+"&brand="+document.getElementById('brand').value;
	url=url+"&department="+document.getElementById('department').value;
//alert(url);
	xmlHttp.onreadystatechange=setord_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function setord_result(){
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
	//alert(xmlHttp.responseText);
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;


		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");	
		document.getElementById('creditlimit').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");	
		document.getElementById('balance').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

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
			
			
			var url="search_ord_data.php";			
			url=url+"?Command="+"search_inv";
			
			if (document.getElementById('invno').value!=""){
				url=url+"&mstatus=invno";
			} else if (document.getElementById('customername').value!=""){
				url=url+"&mstatus=customername";
			}
			
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&customername="+document.getElementById('customername').value;
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

function update_cust_list(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_custom_data.php";			
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
			url=url+"&itno="+document.getElementById('itno').value;
			url=url+"&itemname="+document.getElementById('itemname').value;
			
			if (document.getElementById('itno').value!=""){
				url=url+"&mstatus=itno";
			} else if (document.getElementById('itemname').value!=""){
				url=url+"&mstatus=itemname";
			}
					
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
			url=url+"&salesrep="+document.getElementById('salesrep').value;
			url=url+"&txt_cuscode="+document.getElementById('firstname_hidden').value;
		
			//alert(url);
					
			xmlHttp.onreadystatechange=barand_details_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function barand_details_result()
{
	//alert(xmlHttp.responseText);
	
/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");	
	document.getElementById('creditlimit').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");	
	document.getElementById('balance').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
	document.getElementById('discount1').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
	document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;*/
}


function assignbrand_search(brand, salesrep, txt_cuscode)
{
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
			var url="search_inv_data.php";			
			url=url+"?Command="+"assign_brand";
			url=url+"&brand="+brand;
			url=url+"&salesrep="+salesrep;
			url=url+"&txt_cuscode="+txt_cuscode;
		
			//alert(url);
					
			xmlHttp.onreadystatechange=barand_details_result_search;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function barand_details_result_search()
{
	//alert(xmlHttp.responseText);
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");	
	opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");	
	opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
	opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
	window.opener.document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	
}


function invno(invno, stname)
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			
			
			if (stname=="inv_mast"){
				if (opener.document.form1.invno.value !=""){
					var url="search_ord_data.php";			
					url=url+"?Command="+"pass_invno_to_inv";
					url=url+"&invno="+invno;
					url=url+"&stname="+stname;
					url=url+"&newinvno="+opener.document.form1.invno.value
				} else {
					alert("Please insert invoice no");
					self.close();
				}
				
			} else {
				var url="search_ord_data.php";			
				url=url+"?Command="+"pass_invno";
				url=url+"&invno="+invno;
				url=url+"&stname="+stname;
			}
				url=url+"&custno="+opener.document.form1.firstname_hidden.value;
				url=url+"&brand="+opener.document.form1.brand.value;
				url=url+"&department="+opener.document.form1.department.value;
				
				
			
			
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
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stname");
		
		var stname = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_invoiceno");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert(XMLAddress1[0].childNodes[0].nodeValue);
		
	
		opener.document.form1.salesord1.value = XMLAddress1[0].childNodes[0].nodeValue;
		 
	//	if (stname=="inv_mast"){
	//		opener.document.form1.orderno1.value = XMLAddress1[0].childNodes[0].nodeValue;
	//	}
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
		var txt_cuscode=XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");	
		opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address");	
		opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno1");	
		opener.document.form1.vat1.value = XMLAddress1[0].childNodes[0].nodeValue;

		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno2");	
		opener.document.form1.vat2.value = XMLAddress1[0].childNodes[0].nodeValue;
	
	//	if (stname=="inv_mast"){
	//		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sdate");	
	//		opener.document.form1.orderdate.value = XMLAddress1[0].childNodes[0].nodeValue;
	//	}
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_salesrep");	
		var objSalesrep = opener.document.getElementById("salesrep");
		
		var salesrep=XMLAddress1[0].childNodes[0].nodeValue;
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
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_orderno1");	
	//	opener.document.form1.orderno1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_orderno2");	
	//	opener.document.form1.orderdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_credit");	
	//	opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_balance");	
		opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
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
		var brand=XMLAddress1[0].childNodes[0].nodeValue;
		while (i<objBrand.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objBrand.options[i].value)
			{
				objBrand.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vat");	
		
		if(XMLAddress1[0].childNodes[0].nodeValue=='vat')
		{
			opener.document.form1.vatgroup_0.checked=true;
		
		} else if(XMLAddress1[0].childNodes[0].nodeValue=='svat')
		{
			opener.document.form1.vatgroup_2.checked=true;
			
		} else if(XMLAddress1[0].childNodes[0].nodeValue=='evat')
		{
			opener.document.form1.vatgroup_3.checked=true;
			
		} else {
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
		opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis1");	
		opener.document.form1.discount2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis2");	
		opener.document.form1.discount3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
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
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");	
		opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;

		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");	
		//opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
		opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis1");	
	//	opener.document.form1.discount2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis2");	
	//	opener.document.form1.discount3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");	
		window.opener.document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		opener.document.form1.credper.value = 65;
		//window.opener.document.getElementById("test").innerHTML="TESTNBMSVMS"
		//opener.document.forminv.invno.value = "123";
		//myWindow.opener.document.invno.value = "123";
		self.close();
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("AltMessage");	
		if (XMLAddress1[0].childNodes[0].nodeValue != ""){
			alert(XMLAddress1[0].childNodes[0].nodeValue);
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bank_message");	
		if (XMLAddress1[0].childNodes[0].nodeValue != ""){
			alert(XMLAddress1[0].childNodes[0].nodeValue);
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("over60_message");	
		if (XMLAddress1[0].childNodes[0].nodeValue != ""){
			alert(XMLAddress1[0].childNodes[0].nodeValue);
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_message");	
		if (XMLAddress1[0].childNodes[0].nodeValue != ""){
			alert(XMLAddress1[0].childNodes[0].nodeValue);
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_message_que");	
		if (XMLAddress1[0].childNodes[0].nodeValue != ""){
			var ans=confirm(XMLAddress1[0].childNodes[0].nodeValue);
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg_return");	
		if (XMLAddress1[0].childNodes[0].nodeValue != ""){
			alert(XMLAddress1[0].childNodes[0].nodeValue);
		}
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


/*function print_inv()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
 
 	var url="ord_data.php";			
	url=url+"?Command="+"check_print";
  
    xmlHttp.onreadystatechange=passprintresult;
	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	
	
}*/

function print_inv()
{
	var XMLAddress1;
	
	//if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	//{
		//alert(xmlHttp.responseText);
	//	if (xmlHttp.responseText==1){
			var url="rep_dgrn.php";			
			url=url+"?txtrefno="+document.getElementById('txtrefno').value;
			url=url+"&dtdate="+document.getElementById('dtdate').value;
			url=url+"&txt_net="+document.getElementById('txt_net').value;
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&txt_cusname="+document.getElementById('txt_cusname').value;
			url=url+"&txtadd="+document.getElementById('txtadd').value;
			url=url+"&Com_rep="+document.getElementById('Com_rep').value;
			url=url+"&com_dep="+document.getElementById('com_dep').value;
			
			window.open(url);
  	//	} else {
	//		alert("Order is not available");  
  	//	}
	//}
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

function custno(custno, stname)
{   
			//alert(stname);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			if (stname=="cust_mast"){
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_cusno_cust_mast";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult_cust_mast;
			} else {
			
				var url="search_custom_data.php";			
				url=url+"?Command="+"pass_cusno";
				url=url+"&custno="+custno;
				xmlHttp.onreadystatechange=passcusresult;
			}
			
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function passcusresult_cust_mast()
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
	//alert(xmlHttp.responseText);
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totcr");	
	document.getElementById('txtcrlimt').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cre_table");	
	//alert(XMLAddress1[0].childNodes[0].nodeValue);
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
		
		if ((opener.document.form1.vat1.value == '') && (opener.document.form1.vat2.value == '')) {
			opener.document.form1.vatgroup_1.checked=true;
		} else if ((opener.document.form1.vat1.value != '') && (opener.document.form1.vat2.value == '')){
			opener.document.form1.vatgroup_0.checked=true;
		} else if ((opener.document.form1.vat1.value != '') && (opener.document.form1.vat2.value != '')){
			opener.document.form1.vatgroup_2.checked=true;
		} 
		
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

