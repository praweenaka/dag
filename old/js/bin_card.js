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


function keyset(key, e)
{	

   if(e.keyCode==13){
	document.getElementById(key).focus();
   }
}

function keychange(key)
{	

	document.getElementById(key).focus();
  
}

function got_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000066";
  
}

function lost_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000000";
  
}

function close_form()
{
	self.close();	
}


function print_inv()
{
	var url="bincard_print.php";			
			url=url+"?invno="+document.getElementById('invno').value;
			window.open(url);
}

function sup_card()
{
	var url="report_sup_card_print.php";			
			url=url+"?invno="+document.getElementById('invno').value;
			window.open(url);
}


function update_item_list()
{   
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
					
			var url="search_item_bincard_data.php";			
			url=url+"?Command="+"search_item";
			url=url+"&itno="+document.getElementById('itno').value;
			url=url+"&itemname="+document.getElementById('itemname').value;
			url=url+"&department="+opener.document.form1.department.value;
			url=url+"&checkbox="+document.getElementById('checkbox').checked;
			url=url+"&brand="+document.getElementById('brand').value;
			
			
			if (document.getElementById('itno').value!=""){
				url=url+"&mstatus=itno";
			} else if (document.getElementById('itemname').value!=""){
				url=url+"&mstatus=itemname";
			}
			//alert(url);		
			xmlHttp.onreadystatechange=showitemresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function showitemresult()
{
	var XMLAddress1;
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}


function display_data()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="search_item_bincard_data.php";			
			url=url+"?Command="+"pass_bincard";
			url=url+"&itno="+document.getElementById('invno').value;
			url=url+"&department="+document.getElementById('department').value;
			url=url+"&department="+document.getElementById('department').value;
			url=url+"&department="+document.getElementById('department').value;
			url=url+"&department="+document.getElementById('department').value;
			url=url+"&department="+document.getElementById('department').value;
		
			//alert(url);
			xmlHttp.onreadystatechange=pass_display_dataresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function pass_display_dataresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
	
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PART_NO");	
		opener.document.form1.partno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("unsold");	
		window.opener.document.getElementById('unsold').innerHTML = '<div style="background-color:#FF0000"><font size="+3">'+XMLAddress1[0].childNodes[0].nodeValue+'<font><div>';
		
		if (window.opener.document.getElementById('unsold').innerHTML!=""){
			window.opener.document.getElementById('day90').innerHTML='<div style="background-color:#FF0000"><font size="+3">90 Days Stock</font></div>';	
		} else {
			window.opener.document.getElementById('day90').innerHTML="";	
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");	
		window.opener.document.getElementById('qtyinhand').innerHTML = '<div><font size="+3">'+XMLAddress1[0].childNodes[0].nodeValue+'<font><div>';
		
		if (window.opener.document.getElementById('qtyinhand').innerHTML!=""){
			window.opener.document.getElementById('qtyinahand1').innerHTML='<div><font size="+3">Stock</font></div>';	
		} else {
			window.opener.document.getElementById('qtyinahand1').innerHTML="";	
		}		
		
		 
		
		self.close();
		opener.document.form1.partno.focus();
		
	
		
	}
}

function itno_bin()
{   
			document.getElementById('day90').value; 
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_item_bincard_data.php";			
			url=url+"?Command="+"pass_itno1";
			url=url+"&itno="+document.getElementById('invno').value;
			url=url+"&department="+document.getElementById('department').value;
			url=url+"&dte_from="+document.getElementById('dte_from').value;
			
			
			//alert(url);
			xmlHttp.onreadystatechange=passit_purordresult_bin;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function passit_purordresult_bin()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("STK_NO");	
		document.getElementById('invno').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");	
		document.getElementById('itemname').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SELLING");	
		document.getElementById('selling').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PART_NO");	
		document.getElementById('partno').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("unsold");	
		if (XMLAddress1[0].childNodes[0].nodeValue>0){
		document.getElementById('unsold').innerHTML ='<div style="background-color:#FF0000"><font size="+3">'+XMLAddress1[0].childNodes[0].nodeValue+'</font></div>';
		
		if (document.getElementById('unsold').innerHTML!=""){
			document.getElementById('day90').innerHTML ='<div style="background-color:#FF0000"><font size="+3">90 Days Stock</font></div>';
		} else {
			document.getElementById('day90').innerHTML ="";	
		}
		} else {
			document.getElementById('day90').innerHTML ="";		
			document.getElementById('unsold').innerHTML="";
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");	
		if (XMLAddress1[0].childNodes[0].nodeValue>0){
		document.getElementById('qtyinhand').innerHTML ='<div><font size="+3">'+XMLAddress1[0].childNodes[0].nodeValue+'</font></div>';
		
		if (document.getElementById('qtyinhand').innerHTML!=""){
			document.getElementById('qtyinahand1').innerHTML ='<font size="+3">Stock</font></div>';
		} else {
			document.getElementById('qtyinahand1').innerHTML ="";	
		}
		} else {
			document.getElementById('qtyinahand1').innerHTML ="";		
			document.getElementById('qtyinhand').innerHTML="";
		}		
		
		document.getElementById('active_t').innerHTML = "";
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("active_t");	
		if (XMLAddress1[0].childNodes[0].nodeValue>0){
		document.getElementById('active_t').innerHTML ='<div style="background-color:#FF0000"><font size="+3">Locked</font></div>';
		}
		 
		
	/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("unsold");	
		document.getElementById('unsold').innerHTML = '<div style="background-color:#FF0000"><font size="+3">'+XMLAddress1[0].childNodes[0].nodeValue+'</font></div>';
		
		document.getElementById('day90').innerHTML="";	
		if (document.getElementById('unsold').innerHTML!=""){
			document.getElementById('day90').innerHTML='<div style="background-color:#FF0000"><font size="+3">90 Days Stock</font></div>';	
		} else {
			document.getElementById('day90').innerHTML="";	
		}*/
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE01");	
		document.getElementById('sal1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE02");	
		document.getElementById('sal2').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE03");	
		document.getElementById('sal3').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE04");	
		document.getElementById('sal4').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE05");	
		document.getElementById('sal5').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE06");	
		document.getElementById('sal6').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE07");	
		document.getElementById('sal7').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE08");	
		document.getElementById('sal8').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE09");	
		document.getElementById('sal9').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE10");	
		document.getElementById('sal10').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE11");	
		document.getElementById('sal11').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE12");	
		document.getElementById('sal12').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("avg");	
		document.getElementById('avg').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		document.getElementById('stock_det').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bin_table");	
		document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ord_table");	
		document.getElementById('orddetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
	/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");	
		opener.document.form1.itemname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");	
		opener.document.form1.itemname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");	
		opener.document.form1.itemname.value = XMLAddress1[0].childNodes[0].nodeValue;*/


		
		
		
	
		
	}
}


function itno1()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
		if (document.getElementById('invno').value!=""){	
			var url="search_item_bincard_data.php";			
			url=url+"?Command="+"pass_itno";
			url=url+"&itno="+document.getElementById('invno').value;
			
			url=url+"&department="+document.getElementById('department').value;
			url=url+"&dte_from="+document.getElementById('dte_from').value; 
			
			//alert(url);
			
			xmlHttp.onreadystatechange=passit_purordresult1;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
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
			
			
			var url="search_item_bincard_data.php";			
			url=url+"?Command="+"pass_itno";
			url=url+"&itno="+itno;
			url=url+"&department="+opener.document.form1.department.value;
			url=url+"&dte_from="+opener.document.form1.dte_from.value;
			
			
			//alert(url);
			xmlHttp.onreadystatechange=passit_purordresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function passit_purordresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("STK_NO");	
		opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");	
		opener.document.form1.itemname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SELLING");	
		opener.document.form1.selling.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PART_NO");	
		opener.document.form1.partno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("unsold");	
		if (XMLAddress1[0].childNodes[0].nodeValue>0){
		window.opener.document.getElementById('unsold').innerHTML = '<div style="background-color:#FF0000"><font size="+3">'+XMLAddress1[0].childNodes[0].nodeValue+'</font></div>';
		
		if (window.opener.document.getElementById('unsold').innerHTML!=""){
			window.opener.document.getElementById('day90').innerHTML='<div style="background-color:#FF0000"><font size="+3">90 Days Stock</font></div>';	
		} else {
			window.opener.document.getElementById('day90').innerHTML="";	
		}
		} else {
			window.opener.document.getElementById('day90').innerHTML="";
			window.opener.document.getElementById('unsold').innerHTML ="";
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");	
		if (XMLAddress1[0].childNodes[0].nodeValue>0){
		window.opener.document.getElementById('qtyinhand').innerHTML = '<div><font size="+3">'+XMLAddress1[0].childNodes[0].nodeValue+'</font></div>';
		
		if (window.opener.document.getElementById('qtyinhand').innerHTML!=""){
			window.opener.document.getElementById('qtyinahand1').innerHTML='<div><font size="+3">Stock</font></div>';	
		} else {
			window.opener.document.getElementById('qtyinahand1').innerHTML="";	
		}
		} else {
			window.opener.document.getElementById('qtyinahand1').innerHTML="";
			window.opener.document.getElementById('qtyinhand').innerHTML ="";
		}		
		
		window.opener.document.getElementById('active_t').innerHTML = "";
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("active_t");	
		if (XMLAddress1[0].childNodes[0].nodeValue>0){
		window.opener.document.getElementById('active_t').innerHTML ='<div style="background-color:#FF0000"><font size="+3">Locked</font></div>';
		}
		 
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE01");	
		opener.document.form1.sal1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE02");	
		opener.document.form1.sal2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE03");	
		opener.document.form1.sal3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE04");	
		opener.document.form1.sal4.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE05");	
		opener.document.form1.sal5.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE06");	
		opener.document.form1.sal6.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE07");	
		opener.document.form1.sal7.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE08");	
		opener.document.form1.sal8.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE09");	
		opener.document.form1.sal9.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE10");	
		opener.document.form1.sal10.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE11");	
		opener.document.form1.sal11.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE12");	
		opener.document.form1.sal12.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("avg");	
		opener.document.form1.avg.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		window.opener.document.getElementById('stock_det').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bin_table");	
		window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ord_table");	
		window.opener.document.getElementById('orddetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
	/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");	
		opener.document.form1.itemname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");	
		opener.document.form1.itemname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");	
		opener.document.form1.itemname.value = XMLAddress1[0].childNodes[0].nodeValue;*/


		
		self.close();
		opener.document.form1.partno.focus();
		
	
		
	}
}



function passit_purordresult1()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		alert("Ready");
		document.getElementById('selling').select();
		var a=xmlHttp.responseText;
		//alert(a.length);
		if (a.length>400){
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("STK_NO");	
		document.getElementById('invno').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");	
		document.getElementById('itemname').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SELLING");	
		document.getElementById('selling').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PART_NO");	
		document.getElementById('partno').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("unsold");	
		if (XMLAddress1[0].childNodes[0].nodeValue>0){
		document.getElementById('unsold').innerHTML ='<div style="background-color:#FF0000"><font size="+3">'+XMLAddress1[0].childNodes[0].nodeValue+'</font></div>';
		
		if (document.getElementById('unsold').innerHTML!=""){
			document.getElementById('day90').innerHTML ='<div style="background-color:#FF0000"><font size="+3">90 Days Stock</font></div>';
		} else {
			document.getElementById('day90').innerHTML ="";	
		}
		} else {
			document.getElementById('day90').innerHTML ="";		
			document.getElementById('unsold').innerHTML="";
		}
		
		
	    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");	
		if (XMLAddress1[0].childNodes[0].nodeValue>0){
		document.getElementById('qtyinhand').innerHTML ='<div><font size="+3">'+XMLAddress1[0].childNodes[0].nodeValue+'</font></div>';
		
		if (document.getElementById('qtyinhand').innerHTML!=""){
			document.getElementById('qtyinahand1').innerHTML ='<div><font size="+3">Stock</font></div>';
		} else {
			document.getElementById('qtyinahand1').innerHTML ="";	
		}
		} else {
			document.getElementById('day90').innerHTML ="";		
			document.getElementById('qtyinhand').innerHTML="";
		}
		
		document.getElementById('active_t').innerHTML = "";
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("active_t");	
		if (XMLAddress1[0].childNodes[0].nodeValue>0){
		document.getElementById('active_t').innerHTML ='<div style="background-color:#FF0000"><font size="+3">Locked</font></div>';
		}
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE01");	
		document.getElementById('sal1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE02");	
		document.getElementById('sal2').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE03");	
		document.getElementById('sal3').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE04");	
		document.getElementById('sal4').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE05");	
		document.getElementById('sal5').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE06");	
		document.getElementById('sal6').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE07");	
		document.getElementById('sal7').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE08");	
		document.getElementById('sal8').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE09");	
		document.getElementById('sal9').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE10");	
		document.getElementById('sal10').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE11");	
		document.getElementById('sal11').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SALE12");	
		document.getElementById('sal12').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("avg");	
		document.getElementById('avg').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		document.getElementById('stock_det').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bin_table");	
		document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ord_table");	
		document.getElementById('orddetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		/*window.setInterval(function() {
  			var elem = document.getElementById('itemdetails');
  			elem.scrollTop = elem.scrollHeight;
		}, 1000);*/
		
		} else {
			alert("Item not found");
			location.reload(true);
		}
	 
	
		
	}
}

function assignbrandsession()
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_item_data.php";			
			url=url+"?Command="+"pass_assignbrand";
			
			url=url+"&brand="+document.getElementById('brand').value;
			url=url+"&department="+document.getElementById('department').value;
						
			
			xmlHttp.onreadystatechange=passassignbrand;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
}


function passassignbrand()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
	}
}




function passitresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
	 
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");	
		opener.document.form1.itemd_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");	
		opener.document.form1.itemd.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_selpri");	
		opener.document.form1.rate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");	
		opener.document.form1.stklevel.value = XMLAddress1[0].childNodes[0].nodeValue;
	 
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

function itnoSimple(itno)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_item_bincard_data.php";			
			url=url+"?Command="+"pass_itno_simple";
			url=url+"&itno="+itno;
			
			
			//alert(url);
			xmlHttp.onreadystatechange=passit_purordresult_simple;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function passit_purordresult_simple()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("STK_NO");	
		opener.document.form1.stkno.value = XMLAddress1[0].childNodes[0].nodeValue;

		self.close();
		opener.document.form1.dateFrom.focus();
	}
}



function update_item_list_simple()
{   
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
					
			var url="search_item_bincard_data.php";			
			url=url+"?Command="+"search_item_simple";
			url=url+"&itno="+document.getElementById('itno').value;
			url=url+"&itemname="+document.getElementById('itemname').value;
			url=url+"&department="+opener.document.form1.department.value;
			url=url+"&checkbox="+document.getElementById('checkbox').checked;
			
			
			if (document.getElementById('itno').value!=""){
				url=url+"&mstatus=itno";
			} else if (document.getElementById('itemname').value!=""){
				url=url+"&mstatus=itemname";
			}
			//alert(url);		
			xmlHttp.onreadystatechange=showitemresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}



 
