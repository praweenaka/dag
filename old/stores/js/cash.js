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

function chk_chqno()
{
  if (document.getElementById('chqno').value!=""){	
	var str = document.getElementById('chqno').value;
	var n = str.length;
	
	if (n!=6){
		alert("Invalied Cheque No");	
	}
  }
}


function search_cust_ind()
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
				var url="cash_rec_data.php";			
				url=url+"?Command="+"pass_cus_cash_rec";
								
				url=url+"&custno="+document.getElementById('cuscode').value;
				url=url+"&refno="+document.getElementById('salesrep').value;
				
				//alert(url);
				xmlHttp.onreadystatechange=passcusresult_cash_rec_ind;
				xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}
	
function passcusresult_cash_rec_ind()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
		document.getElementById('hiddencount').value=XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
		document.getElementById('cuscode').value = XMLAddress1[0].childNodes[0].nodeValue;
			
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
		document.getElementById('cusname').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("address");	
		document.getElementById('cus_address').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");	
		//alert( XMLAddress1[0].childNodes[0].nodeValue);
		document.getElementById('inv_details').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		//alert("ok");
		
		//self.close();
		//opener.document.form1.txtdetar.focus();
	}
}

function get_bank()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			}
			
			var url="cash_rec_data.php";			
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

function new_inv()
{   
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var paymethod;
			

		/*	document.getElementById('debit_acc').value="";
			document.getElementById('debit').value="";
			document.getElementById('credit_acc').value="";
			document.getElementById('credit').value="";*/
		
		//if (document.getElementById('cmd_new').value==1){
			/*var objsalesrep = document.getElementById("paytype");
			objsalesrep.options[0].selected=true;
			
			var objdepartment = document.getElementById("costcenter");
			objdepartment.options[0].selected=true;*/
			
			document.getElementById('invno').value="";
			document.getElementById('cuscode').value="";
			document.getElementById('cusname').value="";
			document.getElementById('cus_address').value="";
			document.getElementById('paytype').value="Cash";
			document.getElementById('dt').value="";
			document.getElementById('salesrep').value="1";
			document.getElementById('chqcollect').value="1";
			
		//	var objsalesrep = document.getElementById("salesrep");
		//	objsalesrep.options[0].selected=true;
			
		//	var objsalesrep = document.getElementById("chqcollect");
		//	objsalesrep.options[0].selected=true;
			
			document.getElementById('cashtot').value="";
			document.getElementById('chqtot').value="";
			document.getElementById('txtpaytot').value="";
			document.getElementById('txtoverpay').value="";
		
			document.getElementById('inv_details').innerHTML="";
		
			document.getElementById('chq_table').innerHTML="";
			document.getElementById('utilization').innerHTML="";
			document.getElementById('ca_refno').value="";
			
			//document.getElementById('invdate').value=Date();
			
			var url="cash_rec_data.php";			
			url=url+"?Command="+"new_rec";
		
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		//} else {
		//	alert("Cannot enter new reciept");	
		//}
}

function assign_invno(){
	//alert(xmlHttp.responseText);
	//location.reload(true);
	//document.getElementById('invno').value=xmlHttp.responseText;	
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("recno");	
	document.getElementById('invno').value= XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_date");	
	document.getElementById('invdate').value= XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_date");	
	document.getElementById('dt').value= XMLAddress1[0].childNodes[0].nodeValue;
		
	document.getElementById('cmd_new').value=1;
	document.getElementById('cmd_save').value=1;
	document.getElementById('cmd_cancel').value=0;
	document.getElementById('cmd_print').value=0;
	document.getElementById('cmd_utilization').value=1;
	
	document.getElementById('cuscode').focus();
	
}


function set_tt()
{
	if (document.getElementById('paytype').value=="Cash TT"){ 
		document.getElementById('tt').innerHTML ="<input type='text' size='20' name='dt' id='dt'   onfocus='load_calader('dt')' class='text_purchase3'/>";
	} else {
		document.getElementById('tt').innerHTML ="<input type='text' size='20' name='dt' id='dt' disabled='disabled' onfocus='load_calader('dt')' class='text_purchase3'/>";
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


function chng_chqno(i)
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			chqno="chqno"+i;
			
			var url="cash_rec_data.php";			
			url=url+"?Command="+"chng_chqno";
			url=url+"&chqno="+document.getElementById(chqno).value;
			url=url+"&i="+i;
			
			
			xmlHttp.onreadystatechange=chng_chqno_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function chng_chqno_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		//document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function chng_chqdate(i)
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			chqdate="chqdate"+i;
			
			var url="cash_rec_data.php";			
			url=url+"?Command="+"chng_chqdate";
			url=url+"&chqdate="+document.getElementById(chqdate).value;
			url=url+"&i="+i;
			
			
			xmlHttp.onreadystatechange=chng_chqdate_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function chng_chqdate_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		//document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function chng_bank(i)
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			bank="bank"+i;
			
			var url="cash_rec_data.php";			
			url=url+"?Command="+"chng_bank";
			url=url+"&bank="+document.getElementById(bank).value;
			url=url+"&i="+i;
			
			
			xmlHttp.onreadystatechange=chng_bank_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function chng_bank_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		//document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
	}
}
/*
function chk_date()
{
	alert(isValidDate(document.getElementById('chqdate').value));
}

function isValidDate(dateString)
{
	alert(dateString);
    // First check for the pattern
  //  if(!/^\d{4}\/\d{2}\/\d{2}$/.test(dateString))
   //     return false;

    // Parse the date parts to integers
    var parts = dateString.split("/");
    var day = parseInt(parts[1], 10);
    var month = parseInt(parts[0], 10);
    var year = parseInt(parts[2], 10);
	return day;
    // Check the ranges of month and year
    if(year < 1000 || year > 3000 || month == 0 || month > 12)
        return false;

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
};
*/
function chng_chqamt(i)
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			chqamt="chqamt"+i;
			
			var url="cash_rec_data.php";			
			url=url+"?Command="+"chng_chqamt";
			//alert(url);
			url=url+"&chqamt="+document.getElementById(chqamt).value;
			url=url+"&i="+i;
			
			
			xmlHttp.onreadystatechange=chng_chqamt_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function chng_chqamt_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		document.getElementById('chqtot').value=xmlHttp.responseText;
		
		
		document.getElementById('chq_balance1').value= xmlHttp.responseText;
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		//document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
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
			
			var url="cash_rec_data.php";			
			url=url+"?Command="+"addchq_cash_rec";
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&chqno="+document.getElementById('chqno').value;
			url=url+"&invdate="+document.getElementById('invdate').value;
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
		//document.getElementById('bank').value="";
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

function chk_calader()
{
	
	var chqdate=document.getElementById("chqdate").value;
	var year=chqdate.substring(0, 4);
	var month=chqdate.substring(5, 7);
	var day=chqdate.substring(8, 10);
	
	
	if (isValidDate(chqdate)==false){
		
		document.getElementById("chqdate").focus();
		alert("Invalied Date");
	} else {
		document.getElementById("bank").focus();	
	}
	/*if (checkdate(month, day, year)	== false){
		alert("Invalied Date");
	}*/
}

function isValidDate(dateString)
{
    // First check for the pattern
    if(!/^\d{4}\-\d{2}\-\d{2}$/.test(dateString))
        return false;

    // Parse the date parts to integers
    var parts = dateString.split("-");
    var day = parseInt(parts[2], 10);
    var month = parseInt(parts[1], 10);
    var year = parseInt(parts[0], 10);

    // Check the ranges of month and year
    if(year < 1000 || year > 3000 || month == 0 || month > 12)
        return false;

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
};

function calc_bal_cash(overdue, cash_pay_next, chq_pay, inv_balance, cash_pay, e)
{	
	var overdue_v;
	var chq_pay_v;
	var cash_pay_v;
	var inv_tot_pay=0;

  
	
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
	
	inv_tot_pay=Number(cash_pay_v);
	inv_tot_pay_all=Number(chq_pay_v)+Number(cash_pay_v);
	//alert("overdue_v"+overdue_v);
	//alert("cash_pay_v"+cash_pay_v);
	
  if (Number(overdue_v)>=Number(inv_tot_pay_all)){
	
 // if(e.keyCode==13){
	 //  alert("ok");
	document.getElementById(inv_balance).value=overdue_v-chq_pay_v-cash_pay_v;
	
	var mcou=document.getElementById("hiddencount").value;
	var i=1;
	var pay_tot=0;
	var pay_cash=0;
	var pay_cheq=0;
	var over=0;
	
	over=Number(document.getElementById("cashtot").value)+Number(document.getElementById("chqtot").value);
	
	while (mcou>=i){
		
		var chq_pay_val="chq_pay"+i;
		var cash_pay_val="cash_pay"+i;
		var inv_balance_val="inv_balance"+i;
		
		if (isNaN(document.getElementById(chq_pay_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(chq_pay_val).value);
			pay_cheq=pay_cheq+Number(document.getElementById(chq_pay_val).value);
			over=over-Number(document.getElementById(chq_pay_val).value);
			
		}
		
		if (isNaN(document.getElementById(cash_pay_val).value)==false){
			pay_cash=pay_cash+Number(document.getElementById(cash_pay_val).value);
			pay_tot=pay_tot+Number(document.getElementById(cash_pay_val).value);
			over=over-Number(document.getElementById(cash_pay_val).value);
		}
		
		
		
	/*	if (Number(document.getElementById(inv_balance_val).value)<0){
			//over=over+(-1*Number(document.getElementById(inv_balance_val).value));
			over=Number(document.getElementById("cashtot").value)-Number(document.getElementById(inv_balance_val).value);
		}*/
		
	  
		//document.getElementById("cashtot").value=pay_cash;
		document.getElementById("txtpaytot").value=pay_tot;
		//alert(over);
				
		document.getElementById("txtoverpay").value=over;
		
		i=i+1;

	}
	
	if (over<0){
		alert("Amount grater than cash total");	
		document.getElementById("txtoverpay").value=0;
		document.getElementById(cash_pay).value="";
	}
	
 } else {
	alert("Invalied Amount"); 
	document.getElementById(cash_pay).value="";
	document.getElementById(cash_pay).focus();
	
	
	document.getElementById(inv_balance).value="";
	
	var mcou=document.getElementById("hiddencount").value;
	var i=1;
	var pay_tot=0;
	var pay_cash=0;
	var pay_cheq=0;
	var over=0;
	
	over=Number(document.getElementById("cashtot").value);
	
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
			over=over-Number(document.getElementById(cash_pay_val).value);
		}
		
		
		
	/*	if (Number(document.getElementById(inv_balance_val).value)<0){
			//over=over+(-1*Number(document.getElementById(inv_balance_val).value));
			over=Number(document.getElementById("cashtot").value)-Number(document.getElementById(inv_balance_val).value);
		}*/
		
	  
		//document.getElementById("cashtot").value=pay_cash;
		document.getElementById("txtpaytot").value=pay_tot;
		//alert(over);
				
		document.getElementById("txtoverpay").value=over;
		
		i=i+1;

	}
	
	
	
 }
 
 if (Number(document.getElementById("cashtot").value) < Number(pay_cash)){
		
		document.getElementById(cash_pay).value="";	
		document.getElementById(cash_pay).focus();
		alert("Cash total is grater than cash pay");
	}	
	//document.getElementById(cash_pay_next).focus();
  // }
 }
 
/*
function print_inv()
{

 if (document.getElementById('cmd_print').value==1){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
 
 
  	var url="cash_rec_data.php";			
			url=url+"?Command="+"check_print";
			url=url+"&invno="+document.getElementById("invno").value;
			url=url+"&cuscode="+document.getElementById("cuscode").value;
			url=url+"&cusname="+document.getElementById("cusname").value;
			url=url+"&cus_address="+document.getElementById("cus_address").value;
			url=url+"&invdate="+document.getElementById("invdate").value;
			url=url+"&cashtot="+document.getElementById("cashtot").value;
			url=url+"&chqtot="+document.getElementById("chqtot").value;
			url=url+"&paytype="+document.getElementById("paytype").value;
			
		/*	url=url+"&mcount="+document.getElementById('hiddencount').value;
			
			mcount=document.getElementById('hiddencount').value;
			var i=1;
			while (mcount > i){
				sdate="sdate"+i;
				delidate="delidate"+i;
				invval="invval"+i;
				overdue="overdue"+i;
				chq_pay="chq_pay"+i;
				chq_balance="chq_balance"+i;
				cash_pay="cash_pay"+i;
				inv_balance="inv_balance"+i;
				invno="invno"+i;
				
				
				if ((isNaN(document.getElementById(chq_pay).value)==false) || (isNaN(document.getElementById(cash_pay).value)==false)){
					url=url+"&"+sdate+"="+document.getElementById(sdate).innerHTML;
					url=url+"&"+delidate+"="+document.getElementById(delidate).innerHTML;
					url=url+"&"+invno+"="+document.getElementById(invno).innerHTML;
					url=url+"&"+invval+"="+document.getElementById(invval).innerHTML;		
					url=url+"&"+overdue+"="+document.getElementById(overdue).value;	
					url=url+"&"+chq_pay+"="+document.getElementById(chq_pay).value;	
					url=url+"&"+chq_balance+"="+document.getElementById(chq_balance).value;	
					url=url+"&"+cash_pay+"="+document.getElementById(cash_pay).value;	
					url=url+"&"+inv_balance+"="+document.getElementById(inv_balance).value;	
				}
				i=i+1;
			}*/
	/*	alert(url);	
    xmlHttp.onreadystatechange=passprintresult;
	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
 } else {
	alert("Cannot Print"); 
 }	
	
}*/

function print_inv()
{
		
	if (document.getElementById('cmd_print').value==1){
		//alert(xmlHttp.responseText);
		//if (xmlHttp.responseText==1){
			var url="rep_rec.php";			
			url=url+"?invno="+document.getElementById('invno').value;
			url=url+"&paytype="+document.getElementById('paytype').value;
			url=url+"&dt="+document.getElementById('dt').value;
			url=url+"&ca_refno="+document.getElementById('ca_refno').value;
			window.open(url,'_blank');
  		//} else {
		//	alert("Invoice is not available");  
  		//}
	}
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
		document.getElementById("chqno").focus();
		
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
	
	inv_tot_pay=chq_pay_v;
  inv_tot_pay_all=chq_pay_v+cash_pay_v;
  
  
  if (Number(overdue_v)>=Number(inv_tot_pay_all)) {  
	document.getElementById(inv_balance).value=Number(parseFloat(Math.round(overdue_v * 100) / 100).toFixed(2))-Number(parseFloat(Math.round(chq_pay_v * 100) / 100).toFixed(2))-Number(parseFloat(Math.round(cash_pay_v * 100) / 100).toFixed(2));  
	
	document.getElementById(chq_balance_next).value=Number(parseFloat(Math.round(document.getElementById(chq_balance).value * 100) / 100).toFixed(2))-Number(parseFloat(Math.round(document.getElementById(chq_pay).value * 100) / 100).toFixed(2));
	
	//document.getElementById('txtoverpay').value=document.getElementById(chq_balance_next).value;
	over=Number(parseFloat(Math.round(document.getElementById("cashtot").value * 100) / 100).toFixed(2))+Number(parseFloat(Math.round(document.getElementById("chqtot").value * 100) / 100).toFixed(2));
	
	var mcou=document.getElementById("hiddencount").value;
	var i=1;
	var pay_tot=0;
	var pay_cash=0;
	var pay_cheq=0;
	
	
	while (mcou>=i){
		
		var chq_pay_val="chq_pay"+i;
		var cash_pay_val="cash_pay"+i;
		var inv_balance_val="inv_balance"+i;
		
		if ((isNaN(document.getElementById(chq_pay_val).value)==false) && (document.getElementById(chq_pay_val).value!="")){
			
		
			pay_cheq=Number(parseFloat(Math.round(pay_cheq * 100) / 100).toFixed(2))+Number(parseFloat(Math.round(document.getElementById(chq_pay_val).value * 100) / 100).toFixed(2));
			pay_tot=Number(parseFloat(Math.round(pay_tot * 100) / 100).toFixed(2))+Number(parseFloat(Math.round(document.getElementById(chq_pay_val).value * 100) / 100).toFixed(2)); 
			over=Number(parseFloat(Math.round(over * 100) / 100).toFixed(2))-Number(parseFloat(Math.round(document.getElementById(chq_pay_val).value * 100) / 100).toFixed(2)); 
			
		}
		if ((isNaN(document.getElementById(cash_pay_val).value)==false) && (document.getElementById(cash_pay_val).value!="")){
			
		
			pay_cash=Number(parseFloat(Math.round(pay_cash * 100) / 100).toFixed(2))+Number(parseFloat(Math.round(document.getElementById(cash_pay_val).value * 100) / 100).toFixed(2));  
			pay_tot=Number(parseFloat(Math.round(pay_tot * 100) / 100).toFixed(2))+Number(parseFloat(Math.round(document.getElementById(cash_pay_val).value * 100) / 100).toFixed(2)); 
			over=Number(parseFloat(Math.round(over * 100) / 100).toFixed(2))-Number(parseFloat(Math.round(document.getElementById(cash_pay_val).value * 100) / 100).toFixed(2));   
		}
		
	/*	if (Number(document.getElementById(inv_balance_val).value)<0){
			over=over+(-1*Number(document.getElementById(inv_balance_val).value));
		}*/
		
		document.getElementById("txtpaytot").value=pay_tot;
		document.getElementById("txtoverpay").value=over;
		
		i=i+1;

	}
	
	if (over<0){
		alert("Amount grater than cheques total");	
		document.getElementById("txtoverpay").value=0;
		document.getElementById(chq_pay).value="";
	}
  } else {
	alert("Invalied Amount"); 
	
	document.getElementById(chq_pay).value="";
	document.getElementById(chq_pay).focus();
	
	//alert(document.getElementById(inv_balance).value);
	document.getElementById(inv_balance).value="";


	//document.getElementById(inv_balance).value=overdue_v-chq_pay_v-cash_pay_v;  
	
	document.getElementById(chq_balance_next).value=Number(parseFloat(Math.round(document.getElementById(chq_balance).value * 100) / 100).toFixed(2))-Number(parseFloat(Math.round(document.getElementById(chq_pay).value * 100) / 100).toFixed(2));
	
	//document.getElementById('txtoverpay').value=document.getElementById(chq_balance_next).value;
	over=Number(parseFloat(Math.round(document.getElementById("cashtot").value * 100) / 100).toFixed(2))+Number(parseFloat(Math.round(document.getElementById("chqtot").value * 100) / 100).toFixed(2));
	
	var mcou=document.getElementById("hiddencount").value;
	var i=1;
	var pay_tot=0;
	var pay_cash=0;
	var pay_cheq=0;
	
	
	while (mcou>=i){
		
		var chq_pay_val="chq_pay"+i;
		var cash_pay_val="cash_pay"+i;
		var inv_balance_val="inv_balance"+i;
		
		if ((isNaN(document.getElementById(chq_pay_val).value)==false) && (document.getElementById(chq_pay_val).value!="")){
			pay_tot=Number(parseFloat(Math.round(pay_tot * 100) / 100).toFixed(2))+Number(parseFloat(Math.round(document.getElementById(chq_pay_val).value * 100) / 100).toFixed(2));
			over=Number(parseFloat(Math.round(over * 100) / 100).toFixed(2))-Number(parseFloat(Math.round(document.getElementById(chq_pay_val).value * 100) / 100).toFixed(2));  
		}
		if ((isNaN(document.getElementById(cash_pay_val).value)==false) && (document.getElementById(cash_pay_val).value!="")){
			pay_tot=Number(parseFloat(Math.round(pay_tot * 100) / 100).toFixed(2))+Number(parseFloat(Math.round(document.getElementById(cash_pay_val).value * 100) / 100).toFixed(2));  
			over=Number(parseFloat(Math.round(over * 100) / 100).toFixed(2))-Number(parseFloat(Math.round(document.getElementById(cash_pay_val).value * 100) / 100).toFixed(2));  
		}
		
	/*	if (Number(document.getElementById(inv_balance_val).value)<0){
			over=over+(-1*Number(document.getElementById(inv_balance_val).value));
		}*/
		
		document.getElementById("txtpaytot").value=pay_tot;
		document.getElementById("txtoverpay").value=over;
		
		i=i+1;

	}
	
  }
	
	if (Number(document.getElementById("chqtot").value) < Number(pay_cheq)){
		
		document.getElementById(chq_pay).value="";	
		document.getElementById(chq_pay).focus();
		alert("Cheque total is grater than cheque pay");
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
 if (document.getElementById('cmd_utilization').value==1){
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
			url=url+"&invdate="+document.getElementById('invdate').value;
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
			
			//alert(url);
			xmlHttp.onreadystatechange=utilization_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
																																																 	}
 } else {
	alert("Cannot Utilize");	 
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
 if (document.getElementById('cmd_cancel').value==1){
 msg=confirm("Are you sure to CANCEL this Reciept ! ");
  if (msg==true){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="cash_rec_data.php";			
			url=url+"?Command="+"delete_rec";
			url=url+"&recno="+document.getElementById("invno").value;
			url=url+"&invdate="+document.getElementById("invdate").value;
			url=url+"&txtpaytot="+document.getElementById("txtpaytot").value;
			url=url+"&cuscode="+document.getElementById("cuscode").value;
			url=url+"&salesrep="+document.getElementById("salesrep").value;
			
	
		xmlHttp.onreadystatechange=result_delete_rec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
  }
 } else {
	alert("Cannot Delete"); 
 }
}

function result_delete_rec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		
			document.getElementById('cmd_new').value=1;
			document.getElementById('cmd_save').value=0;
			document.getElementById('cmd_cancel').value=0;
			document.getElementById('cmd_print').value=0;
			document.getElementById('cmd_utilization').value=0;
			
		setTimeout("location.reload(true);",500);
	}
}


function save_crec()
{
  
  if (document.getElementById("cmd_save").value==1){
	utilization();
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="cash_rec_data.php";			
			url=url+"?Command="+"save_crec";
			url=url+"&recno="+document.getElementById("invno").value;
			url=url+"&invdate="+document.getElementById("invdate").value;
			url=url+"&cuscode="+document.getElementById("cuscode").value;
			url=url+"&accno="+document.getElementById("accno").value;
			url=url+"&acc_name="+document.getElementById("acc_name").value;
			url=url+"&accno2="+document.getElementById("accno2").value;
			url=url+"&acc_name2="+document.getElementById("acc_name2").value;
			url=url+"&cashtot="+document.getElementById("cashtot").value;
			url=url+"&chqtot="+document.getElementById("chqtot").value;
			url=url+"&txtpaytot="+document.getElementById("txtpaytot").value;
			url=url+"&txtoverpay="+document.getElementById("txtoverpay").value;
			url=url+"&paytype="+document.getElementById("paytype").value;
			url=url+"&mcount="+document.getElementById('hiddencount').value;
			url=url+"&salesrep="+document.getElementById('salesrep').value;
			url=url+"&chqcollect="+document.getElementById('chqcollect').value;
			url=url+"&dt="+document.getElementById('dt').value;
			url=url+"&ca_refno="+document.getElementById('ca_refno').value;
			
			var i=1;
			while (mcount > i){
				delidate="delidate"+i;
				chq_pay="chq_pay"+i;
				invno="invno"+i;
				cash_pay="cash_pay"+i;
				
				if (isNaN(document.getElementById(chq_pay).value)==false){
					url=url+"&"+delidate+"="+document.getElementById(delidate).innerHTML;
					url=url+"&"+invno+"="+document.getElementById(invno).innerHTML;
					url=url+"&"+chq_pay+"="+document.getElementById(chq_pay).value;
					url=url+"&"+cash_pay+"="+document.getElementById(cash_pay).value;				
				}
				i=i+1;
			}
			
			//alert(url);
			xmlHttp.onreadystatechange=result_save_crec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
  } else {
		alert("Cannot Save");  
  }
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
		
		
		
		var i=0;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg_dup");	
		if (XMLAddress1[0].childNodes[0].nodeValue != "0"){
			alert(XMLAddress1[0].childNodes[0].nodeValue);
			i=1;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg_incom");	
		if (XMLAddress1[0].childNodes[0].nodeValue != "0"){
			alert(XMLAddress1[0].childNodes[0].nodeValue);	
			i=1;
		}
		
		if (i==0){
			alert("Saved");
			
			document.getElementById('cmd_new').value=1;
			document.getElementById('cmd_save').value=0;
			document.getElementById('cmd_cancel').value=1;
			document.getElementById('cmd_print').value=1;
			document.getElementById('cmd_utilization').value=0;
	
			print_inv();
			
			//setTimeout("location.reload(true);",500);	
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

function update_list(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="cash_rec_data.php";			
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


function update_bank(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="cash_rec_data.php";			
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
			
			
			var url="cash_rec_data.php";			
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
		opener.document.form1.chqcollect.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		//alert("ok");
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");
		window.opener.document.getElementById('chq_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uti_table");
		window.opener.document.getElementById('utilization').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		opener.document.form1.cmd_new.value=1;
		opener.document.form1.cmd_save.value=0;
		opener.document.form1.cmd_cancel.value=1;
		opener.document.form1.cmd_print.value=1;
		opener.document.form1.cmd_utilization.value=0;
		
		
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
			
			
			var url="cash_rec_data.php";			
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
		
		opener.document.form1.chqamt.focus();
		
		self.close();	
	}
}


function close_form()
{
	self.close();	
}