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

function update_list()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			//alert("ok");
			var url="search_stk_data.php";			
			url=url+"?Command="+"search_item";
			if (document.getElementById('item_name').value!=""){
				url=url+"&mstatus=name";
			} else if (document.getElementById('itemno').value!=""){
				url=url+"&mstatus=itemno";
			} else if (document.getElementById('model').value!=""){
				url=url+"&mstatus=model";
			}
			
				url=url+"&item_name="+document.getElementById('item_name').value;
				url=url+"&itemno="+document.getElementById('itemno').value;
				url=url+"&model="+document.getElementById('model').value;
			
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

function itemno_ind()
{   
	clear_item_ind();
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_stk_data.php";			
			url=url+"?Command="+"pass_invno";
			url=url+"&itno="+document.getElementById('txtSTK_NO').value;
			
			
			xmlHttp.onreadystatechange=passitemresult_ind;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
//		  alert(url);
	
}

function passitemresult_ind()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
//		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_invoiceno");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert(XMLAddress1[0].childNodes[0].nodeValue);
	//	opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
		//opener.document.form1.invno.value = "111111111";
		
		
	/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_crecash");	
		
		if(XMLAddress1[0].childNodes[0].nodeValue=='credit')
		{
			opener.document.form1.paymethod_0.checked=true;
		
		} else if(XMLAddress1[0].childNodes[0].nodeValue=='cash')
		{
			opener.document.form1.paymethod_1.checked=true;
			
		}*/
	
			
	
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("STK_NO");	
		document.getElementById('txtSTK_NO').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BRAND_NAME");	
		document.getElementById('txtBRAND_NAME').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");	
		document.getElementById('txtDESCRIPTION').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("model");	
		document.getElementById('txtmodel').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GEN_NO");	
		document.getElementById('txtGEN_NO').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PART_NO");	
		document.getElementById('txtPART_NO').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GROUP1");	
		document.getElementById('Com_group1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GROUP2");	
		document.getElementById('Com_group2').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GROUP3");	
		document.getElementById('Com_group3').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GROUP4");	
		document.getElementById('Com_group4').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cost");	
		document.getElementById('txtCOST').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("MARGIN");	
		document.getElementById('txtMARGIN').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("LOCATE_1");	
		document.getElementById('txtLOCATE_1').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("LOCATE_2");	
		document.getElementById('txtLOCATE_2').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("LOCATE_3");	
		document.getElementById('txtLOCATE_3').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("LOCATE_4");	
		document.getElementById('txtLOCATE_4').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SELLING");	
		document.getElementById('txtSELLING').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ar_selling");	
		document.getElementById('TXTSELLING_DISPLAY').value = XMLAddress1[0].childNodes[0].nodeValue;
		
				
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("weight");	
		document.getElementById('txtweight').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("unit");	
		document.getElementById('txtUNIT').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("size");	
		document.getElementById('txtSIZE').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("RE_O_LEVEL");	
		document.getElementById('txtRE_O_LEVEL').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("RE_O_QTY");	
		document.getElementById('txtRE_O_qty').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("country");	
		document.getElementById('txtcountry').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cat1");	
		var objcmbCAt = document.getElementById('cmbcat');
		//alert(objcmbCAt.length);
		var i=0;
		while (i<objcmbCAt.length)
		{	
			//alert(XMLAddress1[0].childNodes[0].nodeValue);
			//alert(objcmbCAt.options[i].value);
			if (XMLAddress1[0].childNodes[0].nodeValue == objcmbCAt.options[i].value)
			{
				objcmbCAt.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("type");	
		var objcmbtype = document.getElementById('cmbtype');
		
		var i=0;
		while (i<objcmbtype.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objcmbtype.options[i].value)
			{
				objcmbtype.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		
	

	}
}

function clear_item_ind()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
			
	//document.getElementById('txtSTK_NO').value="";
	document.getElementById('txtDESCRIPTION').value="";
	document.getElementById('txtBRAND_NAME').value="";
	document.getElementById('txtmodel').value="";
	document.getElementById('txtGEN_NO').value="";
	document.getElementById('txtPART_NO').value="";
	
	document.getElementById('txtREFNO2').value="";
	document.getElementById('txtREFNO2').value="";
	document.getElementById('txtREFNO3').value="";
	
	document.getElementById('Com_group1').value="";
	document.getElementById('Com_group2').value="";
	document.getElementById('Com_group3').value="";
	document.getElementById('Com_group4').value="";
	
	document.getElementById('txtLOCATE_1').value="";
	document.getElementById('txtLOCATE_2').value="";
	document.getElementById('txtLOCATE_3').value="";
	document.getElementById('txtLOCATE_4').value="";
	
	
	document.getElementById('txtCOST').value="";
	document.getElementById('txtMARGIN').value="";
	document.getElementById('txtSELLING').value="";
	document.getElementById('TXTSELLING_DISPLAY').value="";
	document.getElementById('txtweight').value="";
	document.getElementById('txtcountry').value="";
	
	document.getElementById('txtUNIT').value="";
	document.getElementById('txtSIZE').value="";
	document.getElementById('txtRE_O_LEVEL').value="";
	document.getElementById('txtRE_O_qty').value="";
	document.getElementById('txttype').value="";
	
	document.getElementById('txtpendingord').value="";
	document.getElementById('txtdelivered').value="";
	document.getElementById('cmbcat').value="";
	document.getElementById('cmbtype').value="";
	
	//document.getElementById('txtcus_ord').value="";
	//alert("ok");
	document.getElementById('txtdelivered').value="";
    
}

function itemno(itno)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_stk_data.php";			
			url=url+"?Command="+"pass_invno";
			url=url+"&itno="+itno;
			
			
			xmlHttp.onreadystatechange=passitemresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
//		  alert(url);
	
}


function passitemresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
	//	alert(xmlHttp.responseText);
		
//		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_invoiceno");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert(XMLAddress1[0].childNodes[0].nodeValue);
	//	opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
		//opener.document.form1.invno.value = "111111111";
		
		
	/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_crecash");	
		
		if(XMLAddress1[0].childNodes[0].nodeValue=='credit')
		{
			opener.document.form1.paymethod_0.checked=true;
		
		} else if(XMLAddress1[0].childNodes[0].nodeValue=='cash')
		{
			opener.document.form1.paymethod_1.checked=true;
			
		}*/
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("STK_NO");	
		opener.document.form1.txtSTK_NO.value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert("ok");
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BRAND_NAME");	
		opener.document.form1.txtBRAND_NAME.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");	
		opener.document.form1.txtDESCRIPTION.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("model");	
		opener.document.form1.txtmodel.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GEN_NO");	
		opener.document.form1.txtGEN_NO.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PART_NO");	
		opener.document.form1.txtPART_NO.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GROUP1");	
		opener.document.form1.Com_group1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GROUP2");	
		opener.document.form1.Com_group2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GROUP3");	
		opener.document.form1.Com_group3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GROUP4");	
		opener.document.form1.Com_group4.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cost");	
		opener.document.form1.txtCOST.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("MARGIN");	
		opener.document.form1.txtMARGIN.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("LOCATE_1");	
		opener.document.form1.txtLOCATE_1.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("LOCATE_2");	
		opener.document.form1.txtLOCATE_2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("LOCATE_3");	
		opener.document.form1.txtLOCATE_3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("LOCATE_4");	
		opener.document.form1.txtLOCATE_4.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SELLING");	
		opener.document.form1.txtSELLING.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ar_selling");	
		opener.document.form1.TXTSELLING_DISPLAY.value = XMLAddress1[0].childNodes[0].nodeValue;
		
				
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("weight");	
		opener.document.form1.txtweight.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("unit");	
		opener.document.form1.txtUNIT.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("size");	
		opener.document.form1.txtSIZE.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("RE_O_LEVEL");	
		opener.document.form1.txtRE_O_LEVEL.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("RE_O_QTY");	
		opener.document.form1.txtRE_O_qty.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("country");	
		opener.document.form1.txtcountry.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cat1");	
		var objcmbCAt = opener.document.getElementById("cmbcat");
		//alert(objcmbCAt.length);
		var i=0;
		while (i<objcmbCAt.length)
		{	
			//alert(XMLAddress1[0].childNodes[0].nodeValue);
			//alert(objcmbCAt.options[i].value);
			if (XMLAddress1[0].childNodes[0].nodeValue == objcmbCAt.options[i].value)
			{
				objcmbCAt.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("type");	
		var objcmbtype = opener.document.getElementById("cmbtype");
		
		var i=0;
		while (i<objcmbtype.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objcmbtype.options[i].value)
			{
				objcmbtype.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		self.close();
		
/*		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GROUP1");	
		var objCom_group1 = opener.document.getElementById("Com_group1");
		
		var i=0;
		while (i<objCom_group1.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objCom_group1.options[i].value)
			{
				objCom_group1.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GROUP2");	
		var objCom_group2 = opener.document.getElementById("Com_group2");
		
		var i=0;
		while (i<objCom_group2.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objCom_group2.options[i].value)
			{
				objCom_group2.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GROUP3");	
		var objCom_group3 = opener.document.getElementById("Com_group3");
		
		var i=0;
		while (i<objCom_group3.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objCom_group3.options[i].value)
			{
				objCom_group3.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GROUP4");	
		var objCom_group4 = opener.document.getElementById("Com_group4");
		
		var i=0;
		while (i<objCom_group4.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objCom_group4.options[i].value)
			{
				objCom_group4.options[i].selected=true;
				
			}
			i=i+1;
		}
		
				
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("UNIT");	
		opener.document.form1.txtUNIT.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SIZE");	
		opener.document.form1.txtSIZE.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("RE_O_qty");	
		opener.document.form1.txtRE_O_qty.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("RE_O_LEVEL");	
		opener.document.form1.txtRE_O_LEVEL.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cus_ord");	
		opener.document.form1.txtcus_ord.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("delivered");	
		opener.document.form1.txtdelivered.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
				
		
/*		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_salesrep");	
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
		window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;*/
		
		
		
		//window.opener.document.getElementById("test").innerHTML="TESTNBMSVMS"
		//opener.document.forminv.invno.value = "123";
		//myWindow.opener.document.invno.value = "123";
		
		//alert(myWindow.opener.document.getElementById('invno').value);
		//forminv.getElementById('invno').value="125";
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		//document.getElementById('filt_table').innerHTML=xmlHttp.responseText;*/
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
			url=url+"?Command="+"search_item_item_mast";
			url=url+"&itno="+document.getElementById('itemno').value;
			url=url+"&itemname="+document.getElementById('item_name').value;
			url=url+"&model="+document.getElementById('model').value;
			
			url=url+"&checkbox="+document.getElementById('checkbox').checked;
			
			if (document.getElementById('itemno').value!=""){
				url=url+"&mstatus=itno";
			} else if (document.getElementById('item_name').value!=""){
				url=url+"&mstatus=itemname";
			} else if (document.getElementById('model').value!=""){
				url=url+"&mstatus=model";
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
