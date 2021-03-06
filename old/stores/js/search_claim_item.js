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


function update_item_list()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_gin_item_data.php";			
			url=url+"?Command="+"search_item";
			url=url+"&itno="+document.getElementById('itno').value;
			url=url+"&itemname="+document.getElementById('itemname').value;
			
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

function update_list(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			//alert("ok");
			
			
			var url="search_claim_item_data.php";	
			
			if (stname=="claim_item"){
				url=url+"?Command="+"search_item";
			} else if (stname=="claim_item_b"){
				url=url+"?Command="+"search_item_b";
			}
			
			if (document.getElementById('refno').value!=""){
				url=url+"&mstatus=refno";
			} else if (document.getElementById('claim_no').value!=""){
				url=url+"&mstatus=claim_no";
			} else if (document.getElementById('agent_no').value!=""){
				url=url+"&mstatus=agent_no";
			} else if (document.getElementById('agent_name').value!=""){
				url=url+"&mstatus=agent_name";
			}
			
				url=url+"&refno="+document.getElementById('refno').value;
				url=url+"&claim_no="+document.getElementById('claim_no').value;
				url=url+"&agent_no="+document.getElementById('agent_no').value;
				url=url+"&agent_name="+document.getElementById('agent_name').value;
			
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

function itno_claim(refno, stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_claim_item_data.php";			
			url=url+"?Command="+"pass_invno";
			url=url+"&refno="+refno;
			url=url+"&stname="+stname;
			
			
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
		alert(xmlHttp.responseText);
		
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
		
		
					
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtrefno");	
		opener.document.form1.txtrefno.value = XMLAddress1[0].childNodes[0].nodeValue;
		//alert("ok");
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtentdate");	
		opener.document.form1.txtentdate.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DTPicker_recdate");	
		opener.document.form1.DTPicker_recdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcl_no");	
		opener.document.form1.txtcl_no.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtag_code");	
		opener.document.form1.txtag_code.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtag_name");	
		opener.document.form1.txtag_name.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtagadd");	
		opener.document.form1.txtagadd.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXTCUS_NAME");	
		opener.document.form1.txtcus_name.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcus_add");	
		opener.document.form1.txtcus_add.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtstk_no");	
		opener.document.form1.txtstk_no.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdes");	
		opener.document.form1.txtdes.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtbrand");	
		opener.document.form1.txtbrand.value = XMLAddress1[0].childNodes[0].nodeValue;

		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtsiz");	
		//opener.document.form1.txtsiz.value = XMLAddress1[0].childNodes[0].nodeValue;

		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtpr");	
		//opener.document.form1.txtpr.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtpatt");	
		opener.document.form1.txtpatt.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtseri_no");	
		opener.document.form1.txtseri_no.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txttc_ob");	
		opener.document.form1.txttc_ob.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtmn_ob");	
		opener.document.form1.txtmn_ob.value = XMLAddress1[0].childNodes[0].nodeValue;
		
				
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremin");	
	//	opener.document.form1.txtremin.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_date");	
		opener.document.form1.txtCRE_date.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtspec");	
		opener.document.form1.txtspec.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremming");	
		opener.document.form1.txtremming.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtref_per");	
		opener.document.form1.txtref_per.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRD_no");	
		opener.document.form1.txtCRD_no.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_date");	
		opener.document.form1.txtCRE_date.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_amount");	
		opener.document.form1.txtCRE_amount.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtorigin1");	
		opener.document.form1.txtorigin1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtorigin2");	
		opener.document.form1.txtorigin2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtorigin3");	
		opener.document.form1.txtorigin3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtorigin4");	
		opener.document.form1.txtorigin4.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtorigin5");	
		opener.document.form1.txtorigin5.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremin1");	
		opener.document.form1.txtremin1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremin2");	
		opener.document.form1.txtremin2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremin3");	
		opener.document.form1.txtremin3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremin4");	
		opener.document.form1.txtremin4.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremin5");	
		opener.document.form1.txtremin5.value = XMLAddress1[0].childNodes[0].nodeValue;
				
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtrem_per");	
		opener.document.form1.txtrem_per.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cmb_refund");	
		opener.document.form1.Cmb_refund.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("add_ref1");	
		opener.document.form1.txtadd_ref1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("add_ref2");	
		opener.document.form1.txtadd_ref2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Commercialy");	
		var Commercialy = XMLAddress1[0].childNodes[0].nodeValue;
		if (Commercialy != "0"){
    		opener.document.form1.cmb_comm.value = "Allowed";
		} else {
			opener.document.form1.cmb_comm.value = "Not Allowed";	
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DGRN_NO");	
		opener.document.form1.txtCRD_no.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DGRN_NO2");	
		opener.document.form1.txtCRD_no2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DGRN_NO3");	
		opener.document.form1.txtCRD_no3.value = XMLAddress1[0].childNodes[0].nodeValue;
			
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_date");	
		opener.document.form1.txtCRE_date.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_amount");	
		opener.document.form1.txtCRE_amount.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_date2");	
		opener.document.form1.txtCRE_date2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_amount2");	
		opener.document.form1.txtCRE_amount2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_date3");	
		opener.document.form1.txtCRE_date3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_amount3");	
		opener.document.form1.txtCRE_amount3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dtf");	
		opener.document.form1.dtf.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dtto");	
		opener.document.form1.dtto.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("approvedby");	
		opener.document.form1.approvedby.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		self.close();
	}
}


function itno_claim_b(refno, stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_claim_item_data.php";			
			url=url+"?Command="+"pass_invno_b";
			url=url+"&refno="+refno;
			url=url+"&stname="+stname;
			
			
			xmlHttp.onreadystatechange=passitemresult_b;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
//		  alert(url);
	
}



function passitemresult_b()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		
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
		
	
				
					
					
				alert("ok");
					
					
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtrefno");	
		opener.document.form1.txtrefno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtentdate");	
		opener.document.form1.txtentdate.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DTPicker_recdate");	
		opener.document.form1.DTPicker_recdate.value = XMLAddress1[0].childNodes[0].nodeValue;
			
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DTPicker_ddate");	
		opener.document.form1.DTPicker_ddate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DTPicker_cdate");	
		opener.document.form1.DTPicker_cdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Chk_date");	
		if (XMLAddress1[0].childNodes[0].nodeValue=="0"){
			opener.document.form1.DTPicker_cdate.checked = false;
		} else {
			opener.document.form1.DTPicker_cdate.checked = true;	
		}
		
					
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcl_no");	
		opener.document.form1.txtcl_no.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtag_code");	
		opener.document.form1.txtag_code.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtag_name");	
		opener.document.form1.txtag_name.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtagadd");	
		opener.document.form1.txtagadd.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXTCUS_NAME");	
		opener.document.form1.txtcus_name.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcus_add");	
		opener.document.form1.txtcus_add.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtstk_no");	
		opener.document.form1.txtstk_no.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdes");	
		opener.document.form1.txtdes.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtbrand");	
		opener.document.form1.txtbrand.value = XMLAddress1[0].childNodes[0].nodeValue;

		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtsiz");	
		//opener.document.form1.txtsiz.value = XMLAddress1[0].childNodes[0].nodeValue;

		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtpr");	
		//opener.document.form1.txtpr.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtpatt");	
		opener.document.form1.txtpatt.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtseri_no");	
		opener.document.form1.txtseri_no.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
				
					
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cell1_el");	
		opener.document.form1.t11.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cell2_el");	
		opener.document.form1.t12.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cell3_el");	
		opener.document.form1.t13.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cell4_el");	
		opener.document.form1.t14.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cell5_el");	
		opener.document.form1.t15.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cell6_el");	
		opener.document.form1.t16.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cell1_Aspg");	
		opener.document.form1.t21.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cell2_Aspg");	
		opener.document.form1.t22.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cell3_Aspg");	
		opener.document.form1.t23.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cell4_Aspg");	
		opener.document.form1.t24.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cell5_Aspg");	
		opener.document.form1.t25.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cell6_Aspg");	
		opener.document.form1.t26.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txttc_ob");	
		opener.document.form1.txttc_ob.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtmn_ob");	
		opener.document.form1.txtmn_ob.value = XMLAddress1[0].childNodes[0].nodeValue;
		
				
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremin");	
	//	opener.document.form1.txtremin.value = XMLAddress1[0].childNodes[0].nodeValue;
		
					
					
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cmb_refund");	
		opener.document.form1.Cmb_refund.value = XMLAddress1[0].childNodes[0].nodeValue;
		/*
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtref_per");	
		opener.document.form1.txtref_per.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rem_per");	
		opener.document.form1.txtref_per.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtspec");	
		opener.document.form1.txtspec.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremming");	
		opener.document.form1.txtremming.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRD_no");	
		opener.document.form1.txtCRD_no.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_date");	
		opener.document.form1.txtCRE_date.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_amount");	
		opener.document.form1.txtCRE_amount.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtorigin1");	
		opener.document.form1.txtorigin1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtorigin2");	
		opener.document.form1.txtorigin2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtorigin3");	
		opener.document.form1.txtorigin3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtorigin4");	
		opener.document.form1.txtorigin4.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtorigin5");	
		opener.document.form1.txtorigin5.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremin1");	
		opener.document.form1.txtremin1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremin2");	
		opener.document.form1.txtremin2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremin3");	
		opener.document.form1.txtremin3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremin4");	
		opener.document.form1.txtremin4.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremin5");	
		opener.document.form1.txtremin5.value = XMLAddress1[0].childNodes[0].nodeValue;
				
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtrem_per");	
		opener.document.form1.txtrem_per.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cmb_refund");	
		opener.document.form1.Cmb_refund.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("add_ref1");	
		opener.document.form1.txtadd_ref1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("add_ref2");	
		opener.document.form1.txtadd_ref2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Commercialy");	
		var Commercialy = XMLAddress1[0].childNodes[0].nodeValue;
		if (Commercialy != "0"){
    		opener.document.form1.cmb_comm.value = "Allowed";
		} else {
			opener.document.form1.cmb_comm.value = "Not Allowed";	
		}*/
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DGRN_NO");	
		opener.document.form1.txtCRD_no.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DGRN_NO2");	
		opener.document.form1.txtCRD_no2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DGRN_NO3");	
		opener.document.form1.txtCRD_no3.value = XMLAddress1[0].childNodes[0].nodeValue;
			
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_date");	
		opener.document.form1.txtCRE_date.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_amount");	
		opener.document.form1.txtCRE_amount.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_date2");	
		opener.document.form1.txtCRE_date2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_amount2");	
		opener.document.form1.txtCRE_amount2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_date3");	
		opener.document.form1.txtCRE_date3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtCRE_amount3");	
		opener.document.form1.txtCRE_amount3.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		self.close();
	}
}
	
