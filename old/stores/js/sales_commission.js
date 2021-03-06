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

function grnhistory()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
	//var ans=confirm("Block Modifications");
	
		
			var url="sales_commission_data.php";			
			url=url+"?Command="+"grnhistory";
			url=url+"&txtpre="+document.getElementById('txtpre').value;
			url=url+"&txtNoCom_COm="+document.getElementById('txtNoCom_COm').value;
			
			//url=url+"&nosale="+document.getElementById('nosale').value;
			url=url+"&dtMonth="+document.getElementById('dtMonth').value;
			url=url+"&cmbrep="+document.getElementById('cmbrep').value;
			url=url+"&cmbdev="+document.getElementById('cmbdev').value;
			
			url=url+"&txtbalSAleTOT="+document.getElementById('txtbalSAleTOT').value;
			url=url+"&txtt2="+document.getElementById('txtt2').value;
			url=url+"&txtt1="+document.getElementById('txtt1').value;
			url=url+"&txtvat="+document.getElementById('txtvat').value;
			
			
			
			xmlHttp.onreadystatechange=assign_grnhistory;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function assign_grnhistory(){
	alert(xmlHttp.responseText);
	//location.reload(true);
	
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TypeGrid1");	
	document.getElementById('msgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
	document.getElementById('grngrid').value = XMLAddress1[0].childNodes[0].nodeValue;


	//document.getElementById('txtrefno').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}

function savegrn(){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
	
	
		
			var url="sales_commission_data.php";			
			url=url+"?Command="+"savegrn";
			
			var i=1;
			while (i<document.getElementById('grngrid').value){
				gtype="gtype"+i;
				grnno="grnno"+i;
				Commi="Commi"+i;
				commman="CommManu"+i;
				
				url=url+"&"+gtype+"="+document.getElementById(gtype).innerHTML;	
				url=url+"&"+grnno+"="+document.getElementById(grnno).innerHTML;	
				url=url+"&"+Commi+"="+document.getElementById(Commi).innerHTML;	
				url=url+"&"+commman+"="+document.getElementById(commman).value;	
				
				i=i+1;
			}
			url=url+"&grngrid="+document.getElementById('grngrid').value;
			
			alert(url);
			xmlHttp.onreadystatechange=assign_savegrn;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function assign_savegrn(){
	alert(xmlHttp.responseText);
	//location.reload(true);
	//document.getElementById('txtrefno').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}


function view_report()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
	var ans=confirm("Block Modifications");
	
		
			var url="sales_commission_data.php";			
			url=url+"?Command="+"view_report";
			url=url+"&txtpre="+document.getElementById('txtpre').value;
			url=url+"&txtNoCom_COm="+document.getElementById('txtNoCom_COm').value;
			url=url+"&nosale="+document.getElementById('nosale').value;
			url=url+"&dtMonth="+document.getElementById('dtMonth').value;
			url=url+"&cmbrep="+document.getElementById('cmbrep').value;
			url=url+"&cmbdev="+document.getElementById('cmbdev').value;
			url=url+"&txtbalSAleTOT="+document.getElementById('txtbalSAleTOT').value;
			url=url+"&txtt2="+document.getElementById('txtt2').value;
			url=url+"&txtt1="+document.getElementById('txtt1').value;
			url=url+"&txtvat="+document.getElementById('txtvat').value;
			
			
			
			xmlHttp.onreadystatechange=assign_view_report;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function assign_view_report(){
	alert(xmlHttp.responseText);
	//location.reload(true);
	//document.getElementById('txtrefno').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}
function com_lock()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
	var ans=confirm("Block Modifications");
	
		
			var url="sales_commission_data.php";			
			url=url+"?Command="+"com_lock";
			url=url+"&dtMonth="+document.getElementById('dtMonth').value;
			url=url+"&txtComBal="+document.getElementById('txtComBal').value;
			url=url+"&txtAdd="+document.getElementById('txtAdd').value;
			url=url+"&cmbdev="+document.getElementById('cmbdev').value;
			url=url+"&cmbrep="+document.getElementById('cmbrep').value;
			url=url+"&txtComBal="+document.getElementById('txtComBal').value;
			url=url+"&txtAdd="+document.getElementById('txtAdd').value;
			url=url+"&txtdedamt1="+document.getElementById('txtdedamt1').value;
			url=url+"&txtdedamt2="+document.getElementById('txtdedamt2').value;
			url=url+"&txtdedamt3="+document.getElementById('txtdedamt3').value;
			url=url+"&txtdedamt4="+document.getElementById('txtdedamt4').value;
			url=url+"&txtdedamt5="+document.getElementById('txtdedamt5').value;
			url=url+"&txtRetChkAmou_Do="+document.getElementById('txtRetChkAmou_Do').value;
			url=url+"&txtRetChkAmou_D1="+document.getElementById('txtRetChkAmou_D1').value;
			url=url+"&txtBalsale="+document.getElementById('txtBalsale').value;
			url=url+"&txtdes1="+document.getElementById('txtdes1').value;
			url=url+"&txtdes2="+document.getElementById('txtdes2').value;
			url=url+"&txtdes3="+document.getElementById('txtdes3').value;
			url=url+"&txtdes4="+document.getElementById('txtdes4').value;
			url=url+"&txtdes5="+document.getElementById('txtdes5').value;
			url=url+"&txtret="+document.getElementById('txtret').value;
			url=url+"&txtComGRN="+document.getElementById('txtComGRN').value;
			url=url+"&txtNocomm="+document.getElementById('txtNocomm').value;
			url=url+"&txtpre="+document.getElementById('txtpre').value;
			url=url+"&txtcat1sale="+document.getElementById('txtcat1sale').value;
			url=url+"&txtcat1Spsale="+document.getElementById('txtcat1Spsale').value;
			url=url+"&txtcat2sale="+document.getElementById('txtcat2sale').value;
			url=url+"&txtcat1Com="+document.getElementById('txtcat1Com').value;
			url=url+"&txtcat1Spcomm="+document.getElementById('txtcat1Spcomm').value;
			url=url+"&txtcat2com="+document.getElementById('txtcat2com').value;
			url=url+"&txtNoCom_COm="+document.getElementById('txtNoCom_COm').value;
			if (ans==true){
				url=url+"&lblComm=Locked";
				document.getElementById('lblComm').value="Locked";
			} else {
				url=url+"&lblComm=";	
			}
			alert(url);
			xmlHttp.onreadystatechange=assign_com_lock;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function assign_com_lock(){
	alert(xmlHttp.responseText);
	//location.reload(true);
	//document.getElementById('txtrefno').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}

function lock_advance()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
		
			var url="sales_commission_data.php";			
			url=url+"?Command="+"lock_advance";
			url=url+"&dtMonth="+document.getElementById('dtMonth').value;
			url=url+"&cmbdev="+document.getElementById('cmbdev').value;
			url=url+"&cmbrep="+document.getElementById('cmbrep').value;
			url=url+"&txtover60="+document.getElementById('txtover60').value;
			url=url+"&txtretcheq="+document.getElementById('txtretcheq').value;
			
			xmlHttp.onreadystatechange=assign_lock_advance;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_lock_advance(){
	alert(xmlHttp.responseText);
	//location.reload(true);
	//document.getElementById('txtrefno').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
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
			

			document.getElementById('txtrefno').value="";
			document.getElementById('dtdate').value="";
			document.getElementById('Txtcusco').value="";
			document.getElementById('txt_cusname').value="";
			document.getElementById('TXTADD').value="";
			document.getElementById('txtcrnno').value="";
			document.getElementById('txtcrnamount').value="";
			document.getElementById('txtcash').value="";
			document.getElementById('lblPaid').value="";
			document.getElementById('txtchno').value="";
			document.getElementById('DTPicker1').value="";
			document.getElementById('txtchbank').value="";
			document.getElementById('txtamount').value="";
			document.getElementById('dtfrom').value="";
			document.getElementById('dtto').value="";
				
			var objsalesrep = document.getElementById("com_type");
			objsalesrep.options[0].selected=true;
			
			var objdepartment = document.getElementById("Combo1");
			objdepartment.options[0].selected=true;
			
			
			document.getElementById('invdetails').innerHTML="";
			document.getElementById('chkdetails').innerHTML="";
			
			//document.getElementById('invdate').value=Date();
			
			var url="utilization_data.php";			
			url=url+"?Command="+"new_rec";
		
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_invno(){
	//alert(xmlHttp.responseText);
	//location.reload(true);
	document.getElementById('txtrefno').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}


function view_summery()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
		
	var url="sales_commission_data.php";			
	url=url+"?Command="+"view_summery";
	url=url+"&dtMonth="+document.getElementById('dtMonth').value;
	
	url=url+"&cmbdev="+document.getElementById('cmbdev').value;
	url=url+"&cmbrep="+document.getElementById('cmbrep').value;
	url=url+"&txtRetChkAmou_D1="+document.getElementById('txtRetChkAmou_D1').value;
	url=url+"&txtRetChkAmou_Do="+document.getElementById('txtRetChkAmou_Do').value;
	url=url+"&txtvat="+document.getElementById('txtvat').value;
	url=url+"&txtt1="+document.getElementById('txtt1').value;
	url=url+"&txtt2="+document.getElementById('txtt2').value;

alert(url);
	xmlHttp.onreadystatechange=passcusresult_view_summery;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function passcusresult_view_summery(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		//document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;


		
		

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtt1");	
		document.getElementById('txtt1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtt2");	
		document.getElementById('txtt2').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtBalsale");	
		document.getElementById('txtBalsale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtnet");	
		document.getElementById('txtnet').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtnetsale");	
		document.getElementById('txtnetsale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtret");	
		document.getElementById('txtret').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtout");	
		document.getElementById('txtout').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtpaid");	
		document.getElementById('txtpaid').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtNocomm");	
		document.getElementById('txtNocomm').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtTotnet");	
		document.getElementById('txtTotnet').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtTOTNocom");	
		document.getElementById('txtTOTNocom').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtpre");	
		document.getElementById('txtpre').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat1sale");	
		document.getElementById('txtcat1sale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat1Spsale");	
		document.getElementById('txtcat1Spsale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat2sale");	
		document.getElementById('txtcat2sale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtTotnet");	
		document.getElementById('txtTotnet').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtBalsale");	
		document.getElementById('txtBalsale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtbalSAleTOT");	
		document.getElementById('txtbalSAleTOT').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("MSHFlexGrid1");	
		document.getElementById('MSHFlexGrid1').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	
	}
}



function calculation()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
	var url="sales_commission_data.php";			
	url=url+"?Command="+"calculation";
	url=url+"&dtMonth="+document.getElementById('dtMonth').value;
	url=url+"&txtbalSAleTOT="+document.getElementById('txtbalSAleTOT').value;
	url=url+"&txtt1="+document.getElementById('txtt1').value;
	url=url+"&txtt2="+document.getElementById('txtt2').value;
	
	
	url=url+"&cmbdev="+document.getElementById('cmbdev').value;
	url=url+"&cmbrep="+document.getElementById('cmbrep').value;
	url=url+"&txtRetChkAmou_D1="+document.getElementById('txtRetChkAmou_D1').value;
	url=url+"&txtRetChkAmou_Do="+document.getElementById('txtRetChkAmou_Do').value;
	url=url+"&txtvat="+document.getElementById('txtvat').value;
	

alert(url);
	xmlHttp.onreadystatechange=passcusresult_calculation;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function passcusresult_calculation(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		//document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtComSale");	
		document.getElementById('txtComSale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtComGRN");	
		document.getElementById('txtComGRN').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtComBal");	
		document.getElementById('txtComBal').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat1Com");	
		document.getElementById('txtcat1Com').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat1Spcomm");	
		document.getElementById('txtcat1Spcomm').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat2com");	
		document.getElementById('txtcat2com').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdedamt1");	
		document.getElementById('txtdedamt1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtNoCom_COm");	
		document.getElementById('txtNoCom_COm').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		

		
	}
	
}


function save_advance(){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
						
	var url="sales_commission_data.php";			
	url=url+"?Command="+"save_advance";
	url=url+"&dtMonth="+document.getElementById('dtMonth').value;
	url=url+"&msgridcount="+document.getElementById('msgridcount').value;
	url=url+"&txtper="+document.getElementById('txtper').value;
	url=url+"&txtded="+document.getElementById('txtded').value;
	url=url+"&txtdedremark="+document.getElementById('txtdedremark').value;
	
	
	var mgridcount=document.getElementById('mgridcount').value;
	var i=1;
	
	while (mgridcount>i){
		
		msgrid1="msgrid1_"+i;
		msgrid2="msgrid2_"+i;
		msgrid3="msgrid3_"+i;
		msgrid4="msgrid4_"+i;
		msgrid5="msgrid5_"+i;
		msgrid6="msgrid6_"+i;
		
		url=url+"&"+msgrid1+"="+document.getElementById(msgrid1).innerHTML;
		url=url+"&"+msgrid2+"="+document.getElementById(msgrid2).innerHTML;
		url=url+"&"+msgrid3+"="+document.getElementById(msgrid3).innerHTML;
		url=url+"&"+msgrid4+"="+document.getElementById(msgrid4).innerHTML;
		url=url+"&"+msgrid5+"="+document.getElementById(msgrid5).innerHTML;
		url=url+"&"+msgrid6+"="+document.getElementById(msgrid6).innerHTML;
		
		
		i=i+1;
	}
	alert(url);	
	url=url+"&txtretcheq="+document.getElementById('txtretcheq').value;
	url=url+"&txtadvance="+document.getElementById('txtadvance').value;
	url=url+"&Txtadva="+document.getElementById('Txtadva').value;
	
	url=url+"&txtad="+document.getElementById('txtad').value;
	url=url+"&cmbrep="+document.getElementById('cmbrep').value;
	url=url+"&TXTADJ="+document.getElementById('TXTADJ').value;
	url=url+"&txtded1="+document.getElementById('txtded1').value;
	url=url+"&txtded2="+document.getElementById('txtded2').value;
	url=url+"&txtded3="+document.getElementById('txtded3').value;
	url=url+"&txtded4="+document.getElementById('txtded4').value;
	url=url+"&txtded5="+document.getElementById('txtded5').value;
	url=url+"&txtded6="+document.getElementById('txtded6').value;
	url=url+"&txtded7="+document.getElementById('txtded7').value;
	url=url+"&txtded8="+document.getElementById('txtded8').value;
	url=url+"&txtdedamou1="+document.getElementById('txtdedamou1').value;
	url=url+"&txtdedamou2="+document.getElementById('txtdedamou2').value;
	url=url+"&txtdedamou3="+document.getElementById('txtdedamou3').value;
	url=url+"&txtdedamou4="+document.getElementById('txtdedamou4').value;
	url=url+"&txtdedamou5="+document.getElementById('txtdedamou5').value;
	url=url+"&txtdedamou6="+document.getElementById('txtdedamou6').value;
	url=url+"&txtdedamou7="+document.getElementById('txtdedamou7').value;
	url=url+"&txtdedamou8="+document.getElementById('txtdedamou8').value;
	url=url+"&txtover60="+document.getElementById('txtover60').value;
	url=url+"&TXTRATO="+document.getElementById('TXTRATO').value;
	url=url+"&txtretioded="+document.getElementById('txtretioded').value;

	url=url+"&cmbdev="+document.getElementById('cmbdev').value;
	
	url=url+"&mgridcount="+document.getElementById('mgridcount').value;


	xmlHttp.onreadystatechange=passcusresult_save_advance;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function passcusresult_save_advance(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		//document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;

	/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtComSale");	
		document.getElementById('txtComSale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtComGRN");	
		document.getElementById('txtComGRN').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtComBal");	
		document.getElementById('txtComBal').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat1Com");	
		document.getElementById('txtcat1Com').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat1Spcomm");	
		document.getElementById('txtcat1Spcomm').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat2com");	
		document.getElementById('txtcat2com').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdedamt1");	
		document.getElementById('txtdedamt1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtNoCom_COm");	
		document.getElementById('txtNoCom_COm').value = XMLAddress1[0].childNodes[0].nodeValue;*/
		
		
		print_advance();
		
	}
	
}


function print_advance(){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
						
	var url="rep_commadv.php";			
	url=url+"?Command="+"save_advance";
	url=url+"&dtMonth="+document.getElementById('dtMonth').value;
	url=url+"&msgridcount="+document.getElementById('msgridcount').value;
	url=url+"&txtper="+document.getElementById('txtper').value;
	url=url+"&txtded="+document.getElementById('txtded').value;
	url=url+"&txtdedremark="+document.getElementById('txtdedremark').value;
	
	
	var mgridcount=document.getElementById('mgridcount').value;
	var i=1;
	
	while (mgridcount>i){
		
		msgrid1="msgrid1_"+i;
		msgrid2="msgrid2_"+i;
		msgrid3="msgrid3_"+i;
		msgrid4="msgrid4_"+i;
		msgrid5="msgrid5_"+i;
		msgrid6="msgrid6_"+i;
		
		url=url+"&"+msgrid1+"="+document.getElementById(msgrid1).innerHTML;
		url=url+"&"+msgrid2+"="+document.getElementById(msgrid2).innerHTML;
		url=url+"&"+msgrid3+"="+document.getElementById(msgrid3).innerHTML;
		url=url+"&"+msgrid4+"="+document.getElementById(msgrid4).innerHTML;
		url=url+"&"+msgrid5+"="+document.getElementById(msgrid5).innerHTML;
		url=url+"&"+msgrid6+"="+document.getElementById(msgrid6).innerHTML;
		
		
		i=i+1;
	}
	alert(url);	
	url=url+"&txtretcheq="+document.getElementById('txtretcheq').value;
	url=url+"&txtadvance="+document.getElementById('txtadvance').value;
	url=url+"&Txtadva="+document.getElementById('Txtadva').value;
	
	url=url+"&txtad="+document.getElementById('txtad').value;
	url=url+"&cmbrep="+document.getElementById('cmbrep').value;
	url=url+"&TXTADJ="+document.getElementById('TXTADJ').value;
	url=url+"&txtded1="+document.getElementById('txtded1').value;
	url=url+"&txtded2="+document.getElementById('txtded2').value;
	url=url+"&txtded3="+document.getElementById('txtded3').value;
	url=url+"&txtded4="+document.getElementById('txtded4').value;
	url=url+"&txtded5="+document.getElementById('txtded5').value;
	url=url+"&txtded6="+document.getElementById('txtded6').value;
	url=url+"&txtded7="+document.getElementById('txtded7').value;
	url=url+"&txtded8="+document.getElementById('txtded8').value;
	url=url+"&txtdedamou1="+document.getElementById('txtdedamou1').value;
	url=url+"&txtdedamou2="+document.getElementById('txtdedamou2').value;
	url=url+"&txtdedamou3="+document.getElementById('txtdedamou3').value;
	url=url+"&txtdedamou4="+document.getElementById('txtdedamou4').value;
	url=url+"&txtdedamou5="+document.getElementById('txtdedamou5').value;
	url=url+"&txtdedamou6="+document.getElementById('txtdedamou6').value;
	url=url+"&txtdedamou7="+document.getElementById('txtdedamou7').value;
	url=url+"&txtdedamou8="+document.getElementById('txtdedamou8').value;
	url=url+"&txtover60="+document.getElementById('txtover60').value;
	url=url+"&TXTRATO="+document.getElementById('TXTRATO').value;
	url=url+"&txtretioded="+document.getElementById('txtretioded').value;

	url=url+"&cmbdev="+document.getElementById('cmbdev').value;
	
	url=url+"&mgridcount="+document.getElementById('mgridcount').value;

	window.open(url);

}

function advance_proces()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
	var url="sales_commission_data.php";			
	url=url+"?Command="+"advance_proces";
	url=url+"&msgridcount="+document.getElementById('msgridcount').value;
	url=url+"&TXTADJ="+document.getElementById('TXTADJ').value;
	url=url+"&cmbrep="+document.getElementById('cmbrep').value;
	url=url+"&cmbdev="+document.getElementById('cmbdev').value;
	url=url+"&dtMonth="+document.getElementById('dtMonth').value;
	

	//alert(url);
	xmlHttp.onreadystatechange=passcusresult_advance_proces;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function passcusresult_advance_proces(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		//document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;


		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mgridcount");	
		document.getElementById('mgridcount').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXTRATO");	
		document.getElementById('TXTRATO').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtadvance");	
		document.getElementById('txtadvance').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtt1");	
		document.getElementById('txtt1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtt2");	
		document.getElementById('txtt2').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtsales");	
		document.getElementById('txtsales').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcrn");	
		document.getElementById('txtcrn').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtrtn");	
		document.getElementById('txtrtn').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtnett");	
		document.getElementById('txtnett').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtded1");	
		document.getElementById('txtded1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtded2");	
		document.getElementById('txtded2').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtded3");	
		document.getElementById('txtded3').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtded4");	
		document.getElementById('txtded4').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtded5");	
		document.getElementById('txtded5').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtded6");	
		document.getElementById('txtded6').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtded7");	
		document.getElementById('txtded7').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtded8");	
		document.getElementById('txtded8').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdedamou1");	
		document.getElementById('txtdedamou1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdedamou2");	
		document.getElementById('txtdedamou2').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdedamou3");	
		document.getElementById('txtdedamou3').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdedamou4");	
		document.getElementById('txtdedamou4').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdedamou5");	
		document.getElementById('txtdedamou5').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdedamou6");	
		document.getElementById('txtdedamou6').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdedamou7");	
		document.getElementById('txtdedamou7').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdedamou8");	
		document.getElementById('txtdedamou8').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdedremark");	
		document.getElementById('txtdedremark').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtretcheq");	
		document.getElementById('txtretcheq').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtover60");	
		document.getElementById('txtover60').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXTCOM");	
		document.getElementById('TXTCOM').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtad");	
		document.getElementById('txtad').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXTADJ");	
		document.getElementById('TXTADJ').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtretioded");	
		document.getElementById('txtretioded').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Txtadva");	
		document.getElementById('Txtadva').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtded");	
		document.getElementById('txtded').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtper");	
		document.getElementById('txtper').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msgrid");	
		document.getElementById('msgrid_adv').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
	}
}

function allno(grnno)
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
	var url="utilization_data.php";			
	url=url+"?Command="+"pass_allno";
	url=url+"&grnno="+grnno;

//alert(url);
	xmlHttp.onreadystatechange=passcusresult_allno;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function passcusresult_allno(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		//document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;


		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REFNO");	
		opener.document.form1.txtcrnno.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BALANCE");	
		opener.document.form1.txtcrnamount.value = XMLAddress1[0].childNodes[0].nodeValue;
	
	self.close();
	

	}
		
		
}

function settle_inv()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="utilization_data.php";			
	url=url+"?Command="+"settle_inv";
	url=url+"&Txtcusco="+document.getElementById('Txtcusco').value;
						
	xmlHttp.onreadystatechange=settle_inv_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
			
}


function settle_inv_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function ret_chq_settle()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="utilization_data.php";			
	url=url+"?Command="+"ret_chq_settle";
	url=url+"&Txtcusco="+document.getElementById('Txtcusco').value;
						
	xmlHttp.onreadystatechange=ret_chq_settle_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
			
}


function ret_chq_settle_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function inv_btn()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="utilization_data.php";			
	url=url+"?Command="+"inv_btn";
	url=url+"&Txtcusco="+document.getElementById('Txtcusco').value;
						
	xmlHttp.onreadystatechange=inv_btn_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
			
}


function inv_btn_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
	}
}

function settlement()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="utilization_data.php";			
	url=url+"?Command="+"settlement";
	url=url+"&Txtcusco="+document.getElementById('Txtcusco').value;
						
	xmlHttp.onreadystatechange=settlement_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
			
}


function settlement_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function addchq_cash_rec()
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="ret_chq_settle_data.php";			
			url=url+"?Command="+"addchq_cash_rec";
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&chqno="+document.getElementById('chqno').value;
			url=url+"&chqdate="+document.getElementById('chqdate').value;
			url=url+"&bank="+document.getElementById('bank').value;
			url=url+"&chqamt="+document.getElementById('chqamt').value;
			
			xmlHttp.onreadystatechange=addchq_cash_rec_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function addchq_cash_rec_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqbal");	
		document.getElementById('chq_balance1').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('chqno').value="";
		document.getElementById('chqdate').value="";
		document.getElementById('bank').value="";
		document.getElementById('chqamt').value="";
		
		document.getElementById('chqno').focus();
		//document.getElementById('chq_table').innerHTML= xmlHttp.responseText;
		
	}
}



function keyset(key, e)
{	

   if(e.keyCode==13){
	document.getElementById(key).focus();
   }
}


function keysetvalue(key1, key2, key3, e)
{	
	
	
   if(e.keyCode==13){
	 //  alert("ok");
	document.getElementById(key2).value=document.getElementById(key1).value-document.getElementById(key3).value;   
	document.getElementById(key2).focus();
   }
}

function calc_bal_cash(overdue, cash_pay_next, chq_pay, inv_balance, cash_pay, e)
{	
	var overdue_v;
	var chq_pay_v;
	var cash_pay_v;
	
	
	if (isNaN(document.getElementById(overdue).value)==false){
		overdue_v=document.getElementById(overdue).value;
	} else {
		overdue_v=0;
	}
	
	if (isNaN(document.getElementById(chq_pay).value)==false){
		chq_pay_v=document.getElementById(chq_pay).value;
	} else {
		chq_pay_v=0;
	}
	
	if (isNaN(document.getElementById(cash_pay).value)==false){
		cash_pay_v=document.getElementById(cash_pay).value;
	} else {
		cash_pay_v=0;
	}
	
	
  if(e.keyCode==13){
	 //  alert("ok");
	document.getElementById(inv_balance).value=overdue_v-chq_pay_v-cash_pay_v;
	
	var mcou=document.getElementById("hiddencount").value;
	var i=1;
	var pay_tot=0;
	var pay_cash=0;
	var pay_cheq=0;
	var over=0;
	
	while (mcou>=i){
		
		var chq_pay_val="chq_pay"+i;
		var cash_pay_val="cash_pay"+i;
		var inv_balance_val="inv_balance"+i;
		
		if (isNaN(document.getElementById(chq_pay_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(chq_pay_val).value);
			pay_cheq=pay_cheq+Number(document.getElementById(chq_pay_val).value);
		}
		
		if (isNaN(document.getElementById(cash_pay_val).value)==false){
			pay_cash=pay_cash+Number(document.getElementById(cash_pay_val).value);
			pay_tot=pay_tot+Number(document.getElementById(cash_pay_val).value);
		}
		if (Number(document.getElementById(inv_balance_val).value)<0){
			over=over+Number(document.getElementById(inv_balance_val).value);
		}
		
		document.getElementById("cashtot").value=pay_cash;
		document.getElementById("txtpaytot").value=pay_tot;
		//alert(over);
				
		document.getElementById("txtoverpay").value=over;
		
		i=i+1;

	}
	document.getElementById(cash_pay_next).focus();
   }
 }
  


function calc_bal(overdue, chq_pay, inv_balance, chq_balance, chq_balance_next, cash_pay, i, e)
{	
	
	
 // alert(document.getElementById(overdue).value);
 	var overdue_v;
	var chq_pay_v;
	var cash_pay_v;
	
	
	if (isNaN(document.getElementById(overdue).value)==false){
		overdue_v=document.getElementById(overdue).value;
	} else {
		overdue_v=0;
	}
	
	
	if (isNaN(document.getElementById(chq_pay).value)==false){
		chq_pay_v=document.getElementById(chq_pay).value;
	} else {
		chq_pay_v=0;
	}
	

	if (isNaN(document.getElementById(cash_pay).value)==false){
		cash_pay_v=document.getElementById(cash_pay).value;
	} else {
		cash_pay_v=0;
	}
	
	document.getElementById(inv_balance).value=overdue_v-chq_pay_v-cash_pay_v;  
	
	document.getElementById(chq_balance_next).value=document.getElementById(chq_balance).value-document.getElementById(chq_pay).value;
	
	
	
	var mcou=document.getElementById("hiddencount").value;
	var i=1;
	var pay_tot=0;
	var over=0;
	
	while (mcou>=i){
		
		var chq_pay_val="chq_pay"+i;
		var cash_pay_val="cash_pay"+i;
		var inv_balance_val="inv_balance"+i;
		
		if (isNaN(document.getElementById(chq_pay_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(chq_pay_val).value);
		}
		if (isNaN(document.getElementById(cash_pay_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(cash_pay_val).value);
		}
		
		if (Number(document.getElementById(inv_balance_val).value)<0){
			over=over+Number(document.getElementById(inv_balance_val).value);
		}
		
		document.getElementById("txtpaytot").value=pay_tot;
		document.getElementById("txtoverpay").value=over;
		
		i=i+1;

	}
	
		
/*	var j=1;
	var sel_inv_tot=0;
	while (j<=i){
		var chq_pay_all="chq_pay"+j;
		var cash_pay_all="cash_pay"+j;
		alert(document.getElementById(cash_pay_all).value);
		sel_inv_tot= sel_inv_tot+document.getElementById(chq_pay_all).value+document.getElementById(cash_pay_all).value;  
		//alert(sel_inv_tot);
		
		j=j+1;
	}
	
	document.getElementById('txtpaytot').value=sel_inv_tot;
	document.getElementById('txtoverpay').value=(document.getElementById('cashtot').value+document.getElementById('chqtot').value)-sel_inv_tot;*/
	//document.getElementById(key2).focus();
  } 


function got_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000066";
  
}

function lost_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000000";
  
}

function utilization()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
	
			var url="ret_chq_settle_data.php";			
			url=url+"?Command="+"utilization";
			url=url+"&paytype="+document.getElementById('paytype').value;
			url=url+"&mcount="+document.getElementById('hiddencount').value;
			url=url+"&recno="+document.getElementById("invno").value;
			mcount=document.getElementById('hiddencount').value;
			
			var i=1;
			while (mcount > i){
				docno="docno"+i;
				docdate="docdate"+i;
				chqval="chqval"+i;
				chqno="chqno"+i;
				chqdate="chqdate"+i;
				retchqbal="retchqbal"+i;
				cash="cash"+i;
				balance="balance"+i;
				setamount="setamount"+i;
				chqbal="chqbal"+i;
				
				//if (isNaN(document.getElementById(chq_pay).value)==false){
					url=url+"&"+docno+"="+document.getElementById(docno).innerHTML;
					url=url+"&"+docdate+"="+document.getElementById(docdate).innerHTML;
					url=url+"&"+chqval+"="+document.getElementById(chqval).innerHTML;
					url=url+"&"+chqno+"="+document.getElementById(chqno).innerHTML;
					url=url+"&"+chqdate+"="+document.getElementById(chqdate).innerHTML;
				//}
				i=i+1;
			}
			
			//alert(url);
			xmlHttp.onreadystatechange=utilization_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
																																																 	
}

function utilization_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uti_table");	
		document.getElementById('utilization').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
	
		
	}
}


function delete_rec()
{
  var msg;
  msg=confirm("Are you sure to CANCEL this Reciept ! ");
  if (msg==true){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="ret_chq_settle_data.php";			
			url=url+"?Command="+"delete_rec";
			url=url+"&recno="+document.getElementById("invno").value;
			url=url+"&invdate="+document.getElementById("invdate").value;
			url=url+"&txtpaytot="+document.getElementById("txtpaytot").value;
			url=url+"&cuscode="+document.getElementById("cuscode").value;
			
	
		xmlHttp.onreadystatechange=result_delete_rec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
  }
}

function result_delete_rec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		setTimeout("location.reload(true);",500);
	}
}

function setTotal()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 
	
	var url="utilization_data.php";			
	url=url+"?Command="+"setTotal";
	xmlHttp.onreadystatechange=result_setTotal;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function result_setTotal()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
	}
}


function save_crec()
{
	
	//setTotal();
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="utilization_data.php";			
			url=url+"?Command="+"save_crec";
			url=url+"&txtrefno="+document.getElementById("txtrefno").value;
			url=url+"&dtdate="+document.getElementById("dtdate").value;
			url=url+"&chkcash="+document.getElementById("chkcash").checked;
			url=url+"&chkret="+document.getElementById("chkret").checked;
			url=url+"&chkinv="+document.getElementById("chkinv").checked;
			
			url=url+"&lblPaid="+document.getElementById("lblPaid").value;
					
			
			
			//alert(url);
			xmlHttp.onreadystatechange=result_save_crec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function result_save_crec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		
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
			
			
			var url="ret_chq_settle_data.php";			
			url=url+"?Command="+"search_rec";
			url=url+"&mstatus="+stname;
			
			if (document.getElementById('recno').value!=""){
				
				url=url+"&mfield=recno";
				url=url+"&recno="+document.getElementById('recno').value;
				
			} else if (document.getElementById('recdate').value!=""){
				
				url=url+"&mfield=recdate";
				url=url+"&recdate="+document.getElementById('recdate').value;
				
			} else if (document.getElementById('recamt').value!=""){
				
				url=url+"&mfield=recamt";
				url=url+"&recamt="+document.getElementById('recamt').value;
				
			} else if (document.getElementById('reccus').value!=""){
				url=url+"&mfield=reccus";
				url=url+"&reccus="+document.getElementById('reccus').value;
			}
			
			//alert(url);
					
			xmlHttp.onreadystatechange=result_update_list;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function result_update_list()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}

function recno(recno, stname)
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="ret_chq_settle_data.php";			
			url=url+"?Command="+"pass_recno";
			url=url+"&recno="+recno;
			//alert(url);
					
			xmlHttp.onreadystatechange=result_recno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}


function result_recno()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CA_REFNO");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
	//	alert(XMLAddress1[0].childNodes[0].nodeValue);
		opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
		//opener.document.form1.invno.value = "111111111";
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CA_DATE");
		opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CA_CODE");
		opener.document.form1.cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cusname");
		opener.document.form1.cusname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CA_CASSH");
		opener.document.form1.cashtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CA_AMOUNT");
		opener.document.form1.chqtot.value = XMLAddress1[0].childNodes[0].nodeValue-opener.document.form1.cashtot.value;
		
				
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CA_SALESEX");	
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
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("collectcode");	
		var objSalesrep = opener.document.getElementById("chqcollect");
		
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");
		window.opener.document.getElementById('chq_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uti_table");
		window.opener.document.getElementById('utilization').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
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


function close_form()
{
	self.close();	
}