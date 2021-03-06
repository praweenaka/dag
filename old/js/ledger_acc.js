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

function keyset_chng()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			}
			
			var url="ledger_data_acc.php";			
			url=url+"?Command="+"keyset_chng";
			url=url+"&cmbLetter="+document.getElementById('cmbLetter').value;
			xmlHttp.onreadystatechange=assign_keyset_chng;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}


function assign_keyset_chng(){
	//alert(xmlHttp.responseText);
	//location.reload(true);
	document.getElementById('txtAccCode').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}

function set_accno()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			}
			
			var url="ledger_data_acc.php";			
			url=url+"?Command="+"set_accno";
			url=url+"&cmbLetter="+document.getElementById('cmbLetter').value;
			url=url+"&acc_type1="+document.getElementById('acc_type1').checked;
			url=url+"&acc_type2="+document.getElementById('acc_type2').checked;
			url=url+"&txtAccCode="+document.getElementById('txtAccCode').value;
			//alert(url);
			xmlHttp.onreadystatechange=assign_set_accno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}


function assign_set_accno(){
	//alert(xmlHttp.responseText);
	//location.reload(true);
	document.getElementById('txtAccCode').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}

function get_bank()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			}
			
			var url="bank_transaction_data_acc.php";			
			url=url+"?Command="+"get_bank";
			url=url+"&bankcode="+document.getElementById('bank').value;
			xmlHttp.onreadystatechange=assign_get_bank;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_get_bank(){
	//alert(xmlHttp.responseText);
	//location.reload(true);
	document.getElementById('bank').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}

function new_inv1()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
		
				
		
			
			document.getElementById('txtAccCode').value="";
			document.getElementById('txtAccName').value="";
			document.getElementById('txtAdd1').value="";
		
			
			document.getElementById('txtAdd2').value="";
			document.getElementById('op_manu').checked=true;
			document.getElementById('Check1').checked=false;
			document.getElementById('Check2').checked=false;
			
			document.getElementById('txtOpenBal').value="";
			document.getElementById('dtpOpenDate').value="";
			document.getElementById('txtLinkNo').value="";
			document.getElementById('txtcode').value="";
			document.getElementById('txtOpenBal1').value="";
			
			document.getElementById('jan').value="";
			document.getElementById('feb').value="";
			document.getElementById('mar').value="";
			document.getElementById('apr').value="";
			document.getElementById('may').value="";
			document.getElementById('jun').value="";
			document.getElementById('jul').value="";
			document.getElementById('aug').value="";
			document.getElementById('sep').value="";
			document.getElementById('oct').value="";
			document.getElementById('nov').value="";
			document.getElementById('dec').value="";
			
			document.getElementById('txtAccCode').focus();
			
		/*	var url="bank_transaction_data_acc.php";			
			url=url+"?Command="+"new_rec";
		
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);*/
			
}

function assign_invno(){
	//alert(xmlHttp.responseText);
	//location.reload(true);
	
	document.getElementById('txt_entno').value= xmlHttp.responseText;
		
//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
	//document.getElementById('Txtcusco').value= XMLAddress1[0].childNodes[0].nodeValue;
		

	//document.getElementById('searchcust2').focus();
	
}


function del_item(code)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="cash_rec_data.php";			
			url=url+"?Command="+"del_item";
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&chqno="+code;
			//alert(url);
			
			xmlHttp.onreadystatechange=itemresultdel;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function itemresultdel()
{
	//	alert(xmlHttp.responseText);
		
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
}

function addchq_cash_rec()
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="bank_transaction_data_acc.php";			
			url=url+"?Command="+"addchq_cash_rec";
			url=url+"&txt_entno="+document.getElementById('txt_entno').value;
			url=url+"&accno="+document.getElementById('accno').value;
			url=url+"&acc_name="+document.getElementById('acc_name').value;
			url=url+"&descript="+document.getElementById('descript').value;
			url=url+"&amt="+document.getElementById('amt').value;
			
			xmlHttp.onreadystatechange=addchq_cash_rec_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function addchq_cash_rec_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('TXT_DEBTOT').value= XMLAddress1[0].childNodes[0].nodeValue;
		
	
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		document.getElementById('accno').value="";
		document.getElementById('acc_name').value="";
		document.getElementById('descript').value="";
		document.getElementById('amt').value="";
		
		document.getElementById('accno').focus();
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
	
	
 // if(e.keyCode==13){
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
  // }
 }
  

function custno(stname)
{   
			//alert(stname);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"pass_cus_cash_rec";
			url=url+"&custno="+document.getElementById("cuscode").value;
			url=url+"&refno="+document.getElementById("salesrep").value;
			xmlHttp.onreadystatechange=passcusresult_cash_rec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function passcusresult_cash_rec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
		document.getElementById("hiddencount").value=XMLAddress1[0].childNodes[0].nodeValue;
		
	/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
		document.getElementById("cuscode").value = XMLAddress1[0].childNodes[0].nodeValue;
			
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
		document.getElementById("cusname").value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("address");	
		document.getElementById("cus_address").value = XMLAddress1[0].childNodes[0].nodeValue;*/
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");	
		//alert( XMLAddress1[0].childNodes[0].nodeValue);
		document.getElementById("inv_details").innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		//alert("ok");
		
		
		//opener.document.form1.txtdetar.focus();
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
	
	document.getElementById('txtoverpay').value=document.getElementById(chq_balance_next).value;
	
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
	//	document.getElementById("txtoverpay").value=over;
		
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
	
	var txtpaytot = Number(document.getElementById("txtpaytot").value);
	var txtoverpay = Number(document.getElementById("txtoverpay").value);
	var chqtot=Number(document.getElementById("chqtot").value);
	var cashtot= Number(document.getElementById("cashtot").value);
													
	if (txtpaytot+txtoverpay != chqtot+cashtot){
																																																 	alert("Payment amount and settlement amount not equal");
																																																	 	} else {
			var url="cash_rec_data.php";			
			url=url+"?Command="+"utilization";
			url=url+"&mcount="+document.getElementById('hiddencount').value;
			url=url+"&recno="+document.getElementById("invno").value;
			url=url+"&paytype="+document.getElementById("paytype").value;
			url=url+"&dt="+document.getElementById("dt").value;
			
			
			mcount=document.getElementById('hiddencount').value;
			
			var i=1;
			while (mcount > i){
				delidate="delidate"+i;
				chq_pay="chq_pay"+i;
				chq_balance="chq_balance"+i;
				invno="invno"+i;
				cash_pay="cash_pay"+i;
				invval="invval"+i;
				inv_balance="inv_balance"+i;
				
				if (isNaN(document.getElementById(chq_pay).value)==false){
					url=url+"&"+delidate+"="+document.getElementById(delidate).innerHTML;
					url=url+"&"+invno+"="+document.getElementById(invno).innerHTML;
					url=url+"&"+chq_pay+"="+document.getElementById(chq_pay).value;
					url=url+"&"+chq_balance+"="+document.getElementById(chq_balance).value;
					url=url+"&"+cash_pay+"="+document.getElementById(cash_pay).value;	
					url=url+"&"+invval+"="+document.getElementById(invval).innerHTML;	
					url=url+"&"+inv_balance+"="+document.getElementById(inv_balance).value;	
				}
				i=i+1;
			}
			
			alert(url);
			xmlHttp.onreadystatechange=utilization_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
																																																 	}
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
			
			var url="bank_transaction_data_acc.php";			
			url=url+"?Command="+"delete_rec";
			url=url+"&txt_entno="+document.getElementById("txt_entno").value;
			
			
	
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


function save_crec()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="ledger_data_acc.php";			
			url=url+"?Command="+"save_crec";
			url=url+"&txtAccCode="+document.getElementById("txtAccCode").value;
			url=url+"&txtAccName="+document.getElementById("txtAccName").value;
			url=url+"&txtAdd1="+document.getElementById("txtAdd1").value;
			url=url+"&txtAdd2="+document.getElementById("txtAdd2").value;
			url=url+"&op_manu="+document.getElementById("op_manu").checked;
			url=url+"&optPLAcc="+document.getElementById("optPLAcc").checked;
			url=url+"&optBal="+document.getElementById("optBal").checked;
			url=url+"&Check1="+document.getElementById("Check1").checked;
			url=url+"&Check2="+document.getElementById("Check2").checked;
			
			url=url+"&txtOpenBal="+document.getElementById("txtOpenBal").value;
			url=url+"&dtpOpenDate="+document.getElementById('dtpOpenDate').value;
			url=url+"&txtLinkNo="+document.getElementById('txtLinkNo').value;
			url=url+"&txtcode="+document.getElementById('txtcode').value;
			url=url+"&txtOpenBal1="+document.getElementById('txtOpenBal1').value;
			
			url=url+"&jan="+document.getElementById('jan').value;
			url=url+"&feb="+document.getElementById('feb').value;
			url=url+"&mar="+document.getElementById('mar').value;
			url=url+"&apr="+document.getElementById('apr').value;
			url=url+"&may="+document.getElementById('may').value;
			url=url+"&jun="+document.getElementById('jun').value;
			url=url+"&jul="+document.getElementById('jul').value;
			url=url+"&aug="+document.getElementById('aug').value;
			url=url+"&sep="+document.getElementById('sep').value;
			url=url+"&oct="+document.getElementById('oct').value;
			url=url+"&nov="+document.getElementById('nov').value;
			url=url+"&dec="+document.getElementById('dec').value;
			
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
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
	
			
		if (xmlHttp.responseText=="Saved"){
		//	alert("Saved");
			setTimeout("location.reload(true);",500);	
		}
		
	/*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqbal");	
		document.getElementById('chq_balance1').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('chqno').value="";
		document.getElementById('chqdate').value="";
		document.getElementById('bank').value="";
		document.getElementById('chqamt').value="";
		
		//document.getElementById('chq_table').innerHTML= xmlHttp.responseText;*/
		
	}
}

function print_inv1(){
		
		
		var url="lcode_p_acc.php";			
		url=url+"?txtAccCode="+document.getElementById('txtAccCode').value+"&txtAccName="+document.getElementById('txtAccName').value;
		window.open(url);
	
}
		
function update_list(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="bank_transaction_data_acc.php";			
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


function update_bank(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="bank_transaction_data_acc.php";			
			url=url+"?Command="+"search_bank";
			url=url+"&mstatus="+stname;
			
			if (document.getElementById('bcode').value!=""){
				
				url=url+"&mfield=bcode";
				url=url+"&bcode="+document.getElementById('bcode').value;
				
			} else if (document.getElementById('bank').value!=""){
				
				url=url+"&mfield=bank";
				url=url+"&bank="+document.getElementById('bank').value;
				
			} 
			
			//alert(url);
					
			xmlHttp.onreadystatechange=result_update_bank;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function result_update_bank()
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
function recno(recno, stname)
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="bank_transaction_data_acc.php";			
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
		alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Txtrecno");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
	//	alert(XMLAddress1[0].childNodes[0].nodeValue);
		opener.document.form1.Txtrecno.value = XMLAddress1[0].childNodes[0].nodeValue;
		//opener.document.form1.invno.value = "111111111";
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtDATE");
		opener.document.form1.txtDATE.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Txtcusco");
		opener.document.form1.Txtcusco.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcusname");
		opener.document.form1.txtcusname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_accode");
		opener.document.form1.txt_accode.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_accname");
		opener.document.form1.txt_accname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_accode1");
		opener.document.form1.txt_accode1.value = XMLAddress1[0].childNodes[0].nodeValue;
		alert("okkl");
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_accname1");
		opener.document.form1.txt_accname1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcash");
		opener.document.form1.txtcash.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Txtchtot");
		opener.document.form1.Txtchtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtpaytot");
		opener.document.form1.txtpaytot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");
		window.opener.document.getElementById('chq_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		
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


function selbank(bcode, stname)
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="bank_transaction_data_acc.php";			
			url=url+"?Command="+"pass_selbank";
			url=url+"&bcode="+bcode;
			url=url+"&stname="+stname;
			//alert(url);
					
			xmlHttp.onreadystatechange=result_selbank;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}


function result_selbank()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bname");
		opener.document.form1.bank.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		self.close();	
	}
}


function close_form()
{
	self.close();	
}