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
 
			var url="utlization_print.php";			
			url=url+"?txtrefno="+document.getElementById('txtrefno').value;
			window.open(url);
  	 
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
			document.getElementById('Txtcusco').value="";
			document.getElementById('txt_cusname').value=""; 
			document.getElementById('txtcrnno').value="";
			document.getElementById('txtcrnamount').value="";
// 			document.getElementById('txtcash').value="";
			document.getElementById('lblPaid').value="";
// 			document.getElementById('txtchno').value="";
// 			document.getElementById('DTPicker1').value="";
// 			document.getElementById('txtchbank').value="";
// 			document.getElementById('txtamount').value="";
// 			document.getElementById('dtfrom').value="";
// 			document.getElementById('dtto').value="";
			document.getElementById('txtrem_bal').value="";
				
// 			var objsalesrep = document.getElementById("com_type");
// 			objsalesrep.options[0].selected=true;
			
// 			var objdepartment = document.getElementById("Combo1");
// 			objdepartment.options[0].selected=true;
			
			
			document.getElementById('invdetails').innerHTML="";
			document.getElementById('chkdetails').innerHTML="";
			
// 			document.getElementById('chkinv').checked=false;
// 			document.getElementById('chkcash').checked=false;
// 			document.getElementById('chkret').checked=false;
			
			//document.getElementById('invdate').value=Date();
			
			var url="utilization_data.php";			
			url=url+"?Command="+"new_rec";
		
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_invno(){
	 
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("recno");	
		document.getElementById('txtrefno').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mdate");	
		document.getElementById('dtdate').value = XMLAddress1[0].childNodes[0].nodeValue;
		
	 
	
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
         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        var obj = JSON.parse(XMLAddress1[0].childNodes[0].nodeValue);

        opener.document.getElementById('txtcrnno').value = obj.REFNO;  
        opener.document.getElementById('txtcrnamount').value = obj.BALANCE;   
         opener.document.getElementById('txtrem_bal').value = obj.BALANCE;   
        
	 
		
		
	
	self.close();
	

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
	
	document.getElementById('invdetails').innerHTML= "";
	document.getElementById('chkdetails').innerHTML= "";
	
	document.getElementById('chkcash').checked=false;
	document.getElementById('chkinv').checked=false;
	//alert(document.getElementById('chkret').checked);
	if (document.getElementById('chkret').checked==true){
		var url="utilization_data.php";			
		url=url+"?Command="+"ret_chq_settle";
		url=url+"&Txtcusco="+document.getElementById('Txtcusco').value;
		
		xmlHttp.onreadystatechange=ret_chq_settle_result;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	
	} else {
		var url="utilization_data.php";			
		url=url+"?Command="+"unsettle_inv";
		url=url+"&Txtcusco="+document.getElementById('Txtcusco').value;
		url=url+"&txtcash="+document.getElementById('txtcash').value;
		url=url+"&txtamount="+document.getElementById('txtamount').value;
		url=url+"&txtcrnamount="+document.getElementById('txtcrnamount').value;
		var i=1;
		while (i<=document.getElementById('mcount').value){
			remain="settle"+i;
			url=url+"&"+settle+"="+document.getElementById(settle).value;
			i=i+1;
		}
		//alert(url);
		xmlHttp.onreadystatechange=unsettle_inv_result;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		
	}
						
	
			
}


function ret_chq_settle_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		document.getElementById('invdetails').innerHTML= "";
		document.getElementById('chkdetails').innerHTML= "";
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uti_table");	
		document.getElementById('chkdetails').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount_chq");	
		document.getElementById('mcount_chq').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
	}
}

function settle_inv_result()
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
		document.getElementById('invdetails').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
		document.getElementById('mcount').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		
	}
}

function settle_cash()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	
	
	document.getElementById('invdetails').innerHTML= "";
	document.getElementById('chkdetails').innerHTML= "";
		
	document.getElementById('chkinv').checked=false;
	document.getElementById('chkret').checked=false;
	
	if (document.getElementById('chkcash').checked==false){
		document.getElementById("txtcash").style.visibility = "hidden";	
		document.getElementById("lblcah").style.visibility = "hidden";	
		document.getElementById("lblchqno").style.visibility = "hidden";	
		document.getElementById("txtchno").style.visibility = "hidden";	
		document.getElementById("lblchbank").style.visibility = "hidden";	
		document.getElementById("txtchbank").style.visibility = "hidden";	
		document.getElementById("lblchqdate").style.visibility = "hidden";	
		document.getElementById("DTPicker1").style.visibility = "hidden";	
		document.getElementById("lblamt").style.visibility = "hidden";	
		document.getElementById("txtamount").style.visibility = "hidden";	
		document.getElementById('txtcash').value="";
	} else {
		document.getElementById("txtcash").style.visibility = "visible";	
		document.getElementById("lblcah").style.visibility = "visible";	
		document.getElementById("lblchqno").style.visibility = "visible";	
		document.getElementById("txtchno").style.visibility = "visible";	
		document.getElementById("lblchbank").style.visibility = "visible";	
		document.getElementById("txtchbank").style.visibility = "visible";	
		document.getElementById("lblchqdate").style.visibility = "visible";	
		document.getElementById("DTPicker1").style.visibility = "visible";	
		document.getElementById("lblamt").style.visibility = "visible";	
		document.getElementById("txtamount").style.visibility = "visible";	
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
	
	opener.document.getElementById('invdetails').innerHTML= "";
	opener.document.getElementById('chkdetails').innerHTML= "";
		  
		var url="utilization_data.php";			
		url=url+"?Command="+"settle_inv";
		url=url+"&Txtcusco="+opener.document.getElementById('Txtcusco').value;
		 
		xmlHttp.onreadystatechange=settle_inv_result1;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);

			
}


function settle_inv_result1()
{ 
	var XMLAddress1;
 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		opener.document.getElementById('invdetails').innerHTML= "";
		opener.document.getElementById('chkdetails').innerHTML= "";
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        opener.document.getElementById("invdetails").innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
       
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
		opener.document.getElementById('mcount').value= XMLAddress1[0].childNodes[0].nodeValue;

self.close();
	}
}

function unsettle_inv_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
	//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uti_table");	
		document.getElementById('invdetails').innerHTML= "";
		document.getElementById('chkdetails').innerHTML= "";
		
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("lblPaid");	
		var lblPaid = XMLAddress1[0].childNodes[0].nodeValue;
		
		if (lblPaid=="Insufficient GRN Amount ..."){
			alert(lblPaid);	
		} else {
			document.getElementById('lblPaid').value= lblPaid;
		}
		
		
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


function keysetvalue_blur(settle, remain, settle_next, bal)
{	
	
	
//  if ((document.getElementById(settle).value!="") && (parseFloat(document.getElementById(settle).value)!="0")){
	   //alert("ok");
     if ((parseFloat(document.getElementById("txtrem_bal").value)>=parseFloat(document.getElementById(settle).value)) && (parseFloat(document.getElementById(bal).value)>=parseFloat(document.getElementById(settle).value))){
		var drem=parseFloat(document.getElementById(bal).value)-parseFloat(document.getElementById(settle).value); 
		document.getElementById(remain).value=  drem.toFixed(2);
		
		//document.getElementById(settle_next).focus();
     } else {
		//alert("Insufficient Amount  !!!");	 
		document.getElementById(settle).value="";
	 }
	 
	 var i=1;
	 var tot_set_amt=0;
	 var mcount=document.getElementById('mcount').value;
	 while (mcount>i){
		 settle="settle"+i;	
		 if (document.getElementById(settle).value!=""){
		 	tot_set_amt=tot_set_amt+parseFloat(document.getElementById(settle).value);
		 }
		 i=i+1;
	 }
	 
	  var d_tot_set_amt=tot_set_amt.toFixed(2);
	 document.getElementById("lblPaid").value=d_tot_set_amt;
	
	
	
	
	 if (parseFloat(document.getElementById('txtcrnamount').value)<parseFloat(d_tot_set_amt)) {
		alert("Insufficient Amount  !!!");	
		document.getElementById(settle).value="";
	 }
	 
	 var dbal=parseFloat(document.getElementById("txtcrnamount").value)-parseFloat(document.getElementById("lblPaid").value);  
   	document.getElementById("txtrem_bal").value=dbal.toFixed(2);
 
		  
 // }
}


function keysetvalue_blur_ret(settle, remain, settle_next, bal)
{	
	
	
  if ((document.getElementById(settle).value)!=""){
	  
     if (parseFloat(document.getElementById(bal).value)>=parseFloat(document.getElementById(settle).value)){	 
		document.getElementById(remain).value=parseFloat(document.getElementById(bal).value)-parseFloat(document.getElementById(settle).value);   
		//document.getElementById(settle_next).focus();
     } else {
		alert("Insufficient Amount !!!");	 
	 }
	 
	 var i=1;
	 var tot_set_amt=0;
	
	 var mcount=document.getElementById('mcount_chq').value;
	 while (mcount>i){
		
		 settle="retsettle"+i;	
		 if (document.getElementById(settle).value!=""){
		 	tot_set_amt=tot_set_amt+parseFloat(document.getElementById(settle).value);
		 }
		 i=i+1;
	 }
	
	 document.getElementById("lblPaid").value=tot_set_amt;
	 if (document.getElementById('txtcrnamount').value<tot_set_amt) {
		alert("Insufficient Amount !!!");	 
	 }
  }
   
}
/*
function keysetvalue(settle, remain, settle_next, bal, e)
{	
	
	
   if(e.keyCode==13){
	 //  alert("ok");
     if (document.getElementById(bal).value>=document.getElementById(settle).value){	 
		document.getElementById(remain).value=document.getElementById(bal).value-document.getElementById(settle).value;   
		document.getElementById(settle_next).focus();
     } else {
		alert("Insufficient Amount !!!");	 
	 }
	 
	 var i=1;
	 var tot_set_amt=0;
	 var mcount=document.getElementById('mcount').value;
	 while (mcount>i){
		 settle="settle"+i;	
		 if (document.getElementById(settle).value!=""){
		 	tot_set_amt=tot_set_amt+parseFloat(document.getElementById(settle).value);
		 }
		 i=i+1;
	 }
	 document.getElementById("lblPaid").value=tot_set_amt;
	 if (document.getElementById('txtcrnamount').value<tot_set_amt) {
		alert("Insufficient Amount !!!");	 
	 }
   }
}*/

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
	//document.getElementById(cash_pay_next).focus();
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
			
			var url='ret_chq_settle_data.php';	
			var params = 'Command=utilization&paytype='+document.getElementById('paytype').value;
			params =params + '&mcount='+document.getElementById('hiddencount').value;
			params =params + '&recno='+document.getElementById('invno').value;
			
			
			params=params+"&recno="+document.getElementById("invno").value;
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
					params=params+"&"+docno+"="+document.getElementById(docno).innerHTML;
					params=params+"&"+docdate+"="+document.getElementById(docdate).innerHTML;
					params=params+"&"+chqval+"="+document.getElementById(chqval).innerHTML;
					params=params+"&"+chqno+"="+document.getElementById(chqno).innerHTML;
					params=params+"&"+chqdate+"="+document.getElementById(chqdate).innerHTML;
				//}
				i=i+1;
			}
			
			//alert(params);
			
			xmlHttp.open("POST", url, true);

			xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlHttp.setRequestHeader("Content-length", params.length);
			xmlHttp.setRequestHeader("Connection", "close");
			
			xmlHttp.onreadystatechange=utilization_result;
			
			xmlHttp.send(params);
																																								 	
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
			
			var url="utilization_data.php";			
			url=url+"?Command="+"delete_rec";
			url=url+"&txtrefno="+document.getElementById("txtrefno").value;
			url=url+"&txtcrnno="+document.getElementById("txtcrnno").value;
			url=url+"&txtcash="+document.getElementById("txtcash").value;
			
			
	
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


function set_cash_pay()
{
	document.getElementById("lblPaid").value=document.getElementById("txtamount").value;	
	document.getElementById("txtrem_bal").value=parseFloat(document.getElementById("txtcrnamount").value)-parseFloat(document.getElementById("txtamount").value);	
			

}


function save_crec()
{
	
 
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			if (document.getElementById('txtrefno').value == "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Please Click New !!!</span></div>";
                return false;
            }
            // if (parseFloat(document.getElementById("txtcrnamount").value)>=parseFloat(document.getElementById("lblPaid").value)){
            //     document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Invalied Amount</span></div>";
            //     return false;
            // }
            
             
			
			var url='utilization_data.php';	
			var params = 'Command=save_crec&txtrefno='+document.getElementById('txtrefno').value;
			params =params + '&dtdate='+document.getElementById('dtdate').value;
			params=params+"&Txtcusco="+document.getElementById("Txtcusco").value;
			params=params+"&txt_cusname="+document.getElementById("txt_cusname").value;
			params=params+"&txtcrnno="+document.getElementById("txtcrnno").value;
			params=params+"&lblPaid="+document.getElementById("lblPaid").value;
			params=params+"&txtcash="+document.getElementById("txtcash").value;
			params=params+"&txtchno="+document.getElementById("txtchno").value;
			params=params+"&txtamount="+document.getElementById("txtamount").value;
			params=params+"&txtchbank="+document.getElementById("txtchbank").value;
			params=params+"&DTPicker1="+document.getElementById("DTPicker1").value; 
			params=params+"&mcount="+document.getElementById("mcount").value;
			params=params+"&mcount_chq="+document.getElementById("mcount_chq").value;
			
			var i=1;		
			while (document.getElementById("mcount").value>i){
				
				invno="invno"+i;
				invdate="invdate"+i;
				settle="settle"+i;
				remain="remain"+i;
				bal="bal"+i;
				
				params=params+"&"+invno+"="+document.getElementById(invno).innerHTML;
				params=params+"&"+invdate+"="+document.getElementById(invdate).innerHTML;
				params=params+"&"+settle+"="+document.getElementById(settle).value;
				params=params+"&"+remain+"="+document.getElementById(remain).value;
				params=params+"&"+bal+"="+document.getElementById(bal).value;
				
				i=i+1;
			}
			
			var i=1;		
			while (document.getElementById("mcount_chq").value>i){
				
				retinvno="retinvno"+i;
				retinvdate="retinvdate"+i;
				retsettle="retsettle"+i;
				retremain="retremain"+i;
				retbal="retbal"+i;
				
				params=params+"&"+retinvno+"="+document.getElementById(retinvno).innerHTML;
				params=params+"&"+retinvdate+"="+document.getElementById(retinvdate).innerHTML;
				params=params+"&"+retsettle+"="+document.getElementById(retsettle).value;
				params=params+"&"+retremain+"="+document.getElementById(retremain).value;
				params=params+"&"+retbal+"="+document.getElementById(retbal).value;
				
				i=i+1;
			}
			alert(url);
			
			xmlHttp.open("POST", url, true);

			xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlHttp.setRequestHeader("Content-length", params.length);
			xmlHttp.setRequestHeader("Connection", "close");
			
			xmlHttp.onreadystatechange=result_save_crec;
			
			xmlHttp.send(params);
			
		
			
	 
  
}

function settot()
{
	document.getElementById('lblPaid').value=document.getElementById('txtcash').value;
}

function result_save_crec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		if (xmlHttp.responseText!="no"){
			alert(xmlHttp.responseText);
			print_inv();
			location.reload(true);
		} else {
			alert("Sorry Please Login Again !!!");
		}
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
			
			
			var url="utilization_data.php";			
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

function recno(recno)
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="utilization_data.php";			
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
		
	
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_REFNO");
		opener.document.getElementById('txtrefno').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_DATE");
		opener.document.getElementById('dtdate').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CODE");
		opener.document.getElementById('Txtcusco').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cusname");
		opener.document.getElementById('txt_cusname').value = XMLAddress1[0].childNodes[0].nodeValue;
		
	 
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CRNNo");
		opener.document.getElementById('txtcrnno').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BALANCE");
		opener.document.getElementById('txtcrnamount').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("total");
		opener.document.getElementById('lblPaid').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_chno");
		opener.document.getElementById('txtchno').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ch_bank");
		opener.document.getElementById('txtchbank').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_chdate");
		opener.document.getElementById('DTPicker1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ch_val");
		opener.document.getElementById('txtamount').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
// 		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ctype");
// 		if (XMLAddress1[0].childNodes[0].nodeValue == "INV"){
// 			opener.document.getElementById('chkinv.checked=true;
// 			opener.document.getElementById('chkcash.checked=false;
// 			opener.document.getElementById('chkret.checked=false;	
// 		} else if (XMLAddress1[0].childNodes[0].nodeValue == "CAS"){
// 			opener.document.getElementById('chkinv.checked=false;
// 			opener.document.getElementById('chkcash.checked=true;
// 			opener.document.getElementById('chkret.checked=false;	
// 		} else if (XMLAddress1[0].childNodes[0].nodeValue == "CHQ"){
// 			opener.document.getElementById('chkinv.checked=false;
// 			opener.document.getElementById('chkcash.checked=false;
// 			opener.document.getElementById('chkret.checked=true;	
// 		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cash");
		opener.document.getElementById('txtcash').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uti_table_inv");
		window.opener.document.getElementById("invdetails").innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uti_table_chq");
		window.opener.document.getElementById("chkdetails").innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
				
	 
		self.close();
	 
	}
}


function close_form()
{
	self.close();	
}



function custno(code)
{
    //alert(code);
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = 'utilization_data.php';
    var params = 'Command=' + 'pass_quot';
    params = params + '&custno=' + code;
    

    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = passcusresult_quot;

    xmlHttp.send(params);

}


function passcusresult_quot()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        var obj = JSON.parse(XMLAddress1[0].childNodes[0].nodeValue);

        opener.document.getElementById('Txtcusco').value = obj.CODE;  
        opener.document.getElementById('txt_cusname').value = obj.NAME;    

        
        
        settle_inv();
    }

}