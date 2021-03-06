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


function print_inv()
{
    //var XMLAddress1;
   
    //if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    //{
    //    alert(xmlHttp.responseText);
        //if (xmlHttp.responseText==1){
            var url="rep_retchk_print.php";           
            url=url+"?invno="+document.getElementById('invno').value;
                        url=url+"&paytype="+document.getElementById('paytype').value;
            window.open(url);
          //} else {
        //    alert("Invoice is not available"); 
          //}
    //}
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
				
			var objsalesrep = document.getElementById("paytype");
			objsalesrep.options[0].selected=true;
			
			var objdepartment = document.getElementById("costcenter");
			objdepartment.options[0].selected=true;
			
			document.getElementById('cuscode').value="";
			document.getElementById('cusname').value="";
			
			var objsalesrep = document.getElementById("salesrep");
			objsalesrep.options[0].selected=true;
			
			var objsalesrep = document.getElementById("chqcollect");
			objsalesrep.options[0].selected=true;
			
			document.getElementById('cashtot').value="";
			document.getElementById('chqtot').value="";
			document.getElementById('txtpaytot').value="";
			document.getElementById('txtoverpay').value="";
		
			document.getElementById('itemdetails').innerHTML="";
			
			document.getElementById('chq_table').innerHTML="";
			
			//document.getElementById('invdate').value=Date();
			
			var url="ret_chq_settle_data.php";			
			url=url+"?Command="+"new_rec";
		
			xmlHttp.onreadystatechange=assign_invno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_invno(){
	//alert(xmlHttp.responseText);
	//location.reload(true);
	if (xmlHttp.responseText=="no"){
		alert("Please Login Again !!!");	
	} else {
		document.getElementById('invno').value=xmlHttp.responseText;	
	}
	//document.getElementById('searchcust2').focus();
	
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
		document.getElementById('balance1').value= XMLAddress1[0].childNodes[0].nodeValue;
		
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
/*
function calc_bal_cash1(overdue, cash_pay_next, chq_pay, inv_balance, cash_pay, e)
{	
	var overdue_v;
	var chq_pay_v;
	var cash_pay_v;
	
  if (document.getElementById(overdue).value!=""){	
	var str = document.getElementById(overdue).value;
	var res = str.replace(',', ''); 
	
	if (isNaN(res)==false){
		overdue_v=res;
	} else {
		overdue_v=0;
	}
  } else {
	 overdue_v=0;  
  }
	
  
  if (document.getElementById(chq_pay).value!=""){	
	var str = document.getElementById(chq_pay).value;
	var res = str.replace(',', ''); 
	
    if (isNaN(res)==false){
		chq_pay_v=res;
	} else {
		chq_pay_v=0;
	}
  } else {
	chq_pay_v=0;	  
  }

   if (document.getElementById(cash_pay).value!=""){	
	var str = document.getElementById(cash_pay).value;
	var res = str.replace(',', ''); 
	
	if (isNaN(res)==false){
		cash_pay_v=res;
	} else {
		cash_pay_v=0;
	}
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
		
		var chq_pay_val="setamount"+i;
		var cash_pay_val="cash"+i;
		var inv_balance_val="retchqbal"+i;
		
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
	
	if (document.getElementById("chqtot").value==""){
		document.getElementById("chqtot").value=0;
	}
	
	if (document.getElementById("cashtot").value==""){
		document.getElementById("cashtot").value=0;
	}
	
	var balval=parseFloat(document.getElementById("chqtot").value)+parseFloat(document.getElementById("cashtot").value)-parseFloat(document.getElementById("txtpaytot").value);
	
	if (balval>=0)	{
		document.getElementById("txtoverpay").value=balval;
	} else {
		document.getElementById("txtoverpay").value=0;	
	}
	//document.getElementById(cash_pay_next).focus();
  // }
 }
  
*/


function calc_bal_cash(overdue, cash_pay_next, chq_pay, inv_balance, cash_pay, e)
{	
	var overdue_v=0;
	var chq_pay_v=0;
	var cash_pay_v=0;
	var inv_tot_pay=0;

  	
	overdue_v_str=document.getElementById(overdue).value;
	var overdue_v_tmp = overdue_v_str.replace(/,/g,"");
	
	
	if ((isNaN(overdue_v_tmp)==false) && (overdue_v_tmp!="")){
		overdue_v=parseFloat(overdue_v_tmp);
	} else {
		overdue_v=0;
	}
	
	if ((isNaN(document.getElementById(chq_pay).value)==false) && (document.getElementById(chq_pay).value!="")){
		chq_pay_v=parseFloat(document.getElementById(chq_pay).value);
	} else {
		chq_pay_v=0;
	}
	
	if ((isNaN(document.getElementById(cash_pay).value)==false) && (document.getElementById(cash_pay).value!="")){
		cash_pay_v=parseFloat(document.getElementById(cash_pay).value);
	} else {
		cash_pay_v=0;
	}
	
	inv_tot_pay=Number(cash_pay_v);
	inv_tot_pay_all=Number(chq_pay_v)+Number(cash_pay_v);
	//alert("overdue_v"+overdue_v);
	//alert("cash_pay_v"+cash_pay_v);
	
	tmp_overdue_v=parseFloat(overdue_v);
	overdue_v=tmp_overdue_v.toFixed(2);
	
	tmp_inv_tot_pay_all=parseFloat(inv_tot_pay_all);
	inv_tot_pay_all=tmp_inv_tot_pay_all.toFixed(2);
	//alert(overdue_v+"-"+inv_tot_pay_all);
	
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
	over_tmp=parseFloat(over);
	over=over_tmp.toFixed(2);
	while (mcou>=i){
		
		var chq_pay_val="setamount"+i;
		var cash_pay_val="cash"+i;
		var inv_balance_val="retchqbal"+i;
		
		/*if ((isNaN(document.getElementById(chq_pay_val).value)==false) && (document.getElementById(chq_pay_val).value!="")){
			pay_tot=pay_tot+Number(document.getElementById(chq_pay_val).value);
			tmp_pay_tot=parseFloat(pay_tot);
			pay_tot=tmp_pay_tot.toFixed(2);
			
			
			pay_cheq=pay_cheq+Number(document.getElementById(chq_pay_val).value);
			tmp_pay_cheq=parseFloat(pay_cheq);
			pay_cheq=tmp_pay_cheq.toFixed(2);
			
			
			over=over-Number(document.getElementById(chq_pay_val).value);
			over_tmp=parseFloat(over);
			over=over_tmp.toFixed(2);
			
		}
		
		if ((isNaN(document.getElementById(cash_pay_val).value)==false) && (document.getElementById(cash_pay_val).value!="")){
			pay_cash=pay_cash+Number(document.getElementById(cash_pay_val).value);
			tmp_pay_cash=parseFloat(pay_cash);
			pay_cash=tmp_pay_cash.toFixed(2);
			
			pay_tot=pay_tot+Number(document.getElementById(cash_pay_val).value);
			tmp_pay_tot=parseFloat(pay_tot);
			pay_tot=tmp_pay_tot.toFixed(2);
			
			over=over-Number(document.getElementById(cash_pay_val).value);
			
			over_tmp=parseFloat(over);
			over=over_tmp.toFixed(2);
		}*/
		
		if ((isNaN(document.getElementById(chq_pay_val).value)==false) && (document.getElementById(chq_pay_val).value!="")){
			
		
			pay_cheq=Number(parseFloat(Math.round(pay_cheq * 100) / 100).toFixed(2))+Number(parseFloat(Math.round(document.getElementById(chq_pay_val).value * 100) / 100).toFixed(2));
			tmp_pay_cheq=parseFloat(pay_cheq);
			pay_cheq=tmp_pay_cheq.toFixed(2);
			
			pay_tot=Number(parseFloat(Math.round(pay_tot * 100) / 100).toFixed(2))+Number(parseFloat(Math.round(document.getElementById(chq_pay_val).value * 100) / 100).toFixed(2)); 
			tmp_pay_tot=parseFloat(pay_tot);
			pay_tot=tmp_pay_tot.toFixed(2);
			
			over=Number(parseFloat(Math.round(over * 100) / 100).toFixed(2))-Number(parseFloat(Math.round(document.getElementById(chq_pay_val).value * 100) / 100).toFixed(2)); 
			over_tmp=parseFloat(over);
			over=over_tmp.toFixed(2);
			
		}
		if ((isNaN(document.getElementById(cash_pay_val).value)==false) && (document.getElementById(cash_pay_val).value!="")){
			
		
			pay_cash=Number(parseFloat(Math.round(pay_cash * 100) / 100).toFixed(2))+Number(parseFloat(Math.round(document.getElementById(cash_pay_val).value * 100) / 100).toFixed(2));  
			tmp_pay_cash=parseFloat(pay_cash);
			pay_cash=tmp_pay_cash.toFixed(2);
			
			pay_tot=Number(parseFloat(Math.round(pay_tot * 100) / 100).toFixed(2))+Number(parseFloat(Math.round(document.getElementById(cash_pay_val).value * 100) / 100).toFixed(2)); 
			tmp_pay_tot=parseFloat(pay_tot);
			pay_tot=tmp_pay_tot.toFixed(2);
			
			over=Number(parseFloat(Math.round(over * 100) / 100).toFixed(2))-Number(parseFloat(Math.round(document.getElementById(cash_pay_val).value * 100) / 100).toFixed(2));   
			over_tmp=parseFloat(over);
			over=over_tmp.toFixed(2);
		}
		
		
	/*	if (Number(document.getElementById(inv_balance_val).value)<0){
			//over=over+(-1*Number(document.getElementById(inv_balance_val).value));
			over=Number(document.getElementById("cashtot").value)-Number(document.getElementById(inv_balance_val).value);
		}*/
		
	  
		//document.getElementById("cashtot").value=pay_cash;
		//alert(pay_tot);
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
	over_tmp=over;
	over=over_tmp.toFixed(2);
	
	while (mcou>=i){
		
		var chq_pay_val="chq_pay"+i;
		var cash_pay_val="cash_pay"+i;
		var inv_balance_val="inv_balance"+i;
		
		if (isNaN(document.getElementById(chq_pay_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(chq_pay_val).value);
			tmp_pay_tot=parseFloat(pay_tot);
			pay_tot=tmp_pay_tot.toFixed(2);
			
			pay_cheq=pay_cheq+Number(document.getElementById(chq_pay_val).value);
			tmp_pay_cheq=parseFloat(pay_cheq);
			pay_cheq=tmp_pay_cheq.toFixed(2);
		}
		
		if (isNaN(document.getElementById(cash_pay_val).value)==false){
			pay_cash=pay_cash+Number(document.getElementById(cash_pay_val).value);
			tmp_pay_cash=parseFloat(pay_cash);
			pay_cash=tmp_pay_cash.toFixed(2);
			
			pay_tot=pay_tot+Number(document.getElementById(cash_pay_val).value);
			tmp_pay_tot=parseFloat(pay_tot);
			pay_tot=tmp_pay_tot.toFixed(2);
			
			over=over-Number(document.getElementById(cash_pay_val).value);
			over_tmp=parseFloat(over);
			over=over_tmp.toFixed(2);
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


function calc_bal(overdue, chq_pay, inv_balance, chq_balance, chq_balance_next, cash_pay, i, e)
{	
	
	
 // alert(document.getElementById(overdue).value);
 	var overdue_v;
	var chq_pay_v;
	var cash_pay_v;
	
  if (document.getElementById(overdue).value!=""){	
	var str = document.getElementById(overdue).value;
	var res = str.replace(',', ''); 
	
	if (isNaN(res)==false){
		overdue_v=parseFloat(res);
	} else {
		overdue_v=0;
	}
  } else {
	overdue_v=0;	  
  }

  if (document.getElementById(chq_pay).value!=""){
	var str = document.getElementById(chq_pay).value;
	var res = str.replace(',', ''); 
	if (isNaN(res)==false){
		chq_pay_v=parseFloat(res);
	} else {
		chq_pay_v=0;
	}
  } else {
	 chq_pay_v=0;
  }

  if (document.getElementById(cash_pay).value!=""){
	var str = document.getElementById(cash_pay).value;
	var res = str.replace(',', ''); 
	if (isNaN(res)==false){
		cash_pay_v=parseFloat(res);
	} else {
		cash_pay_v=0;
	}
  } else {
	cash_pay_v=0;	  
  }
		
	document.getElementById(inv_balance).value=overdue_v-chq_pay_v-cash_pay_v;  
	
	document.getElementById(chq_balance_next).value=document.getElementById(chq_balance).value-document.getElementById(chq_pay).value;
	
	
	
	var mcou=document.getElementById("hiddencount").value;
	var i=1;
	var pay_tot=0;
	var balance=0;
	
	while (mcou>=i){
		
		var setamount_val="setamount"+i;
		var cash_val="cash"+i;
		var retchqbal_val="retchqbal"+i;
		var balance_val="balance"+i;
		
		if (isNaN(document.getElementById(setamount_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(setamount_val).value);
		}
		if (isNaN(document.getElementById(cash_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(cash_val).value);
		}
		
		
		
		
		document.getElementById("txtpaytot").value=pay_tot;
		
		
		
		i=i+1;

	}
	
	if (document.getElementById("chqtot").value==""){
		document.getElementById("chqtot").value=0;
	}
	
	if (document.getElementById("cashtot").value==""){
		document.getElementById("cashtot").value=0;
	}
	
	var balval=parseFloat(document.getElementById("chqtot").value)+parseFloat(document.getElementById("cashtot").value)-parseFloat(document.getElementById("txtpaytot").value);
	
	if (balval>=0)	{
		document.getElementById("txtoverpay").value=balval;
	} else {
		document.getElementById("txtoverpay").value=0;	
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
	
	if (document.getElementById("invno").value==""){
		alert("Please Click New !!!");	
	} else {
			
			var url='ret_chq_settle_data.php';	
			var params = 'Command=utilization&paytype='+document.getElementById('paytype').value;
			params =params + '&mcount='+document.getElementById('hiddencount').value;
			params =params + '&recno='+document.getElementById('invno').value;
			
		
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
					
					params=params+"&"+setamount+"="+document.getElementById(setamount).value;
					params=params+"&"+cash+"="+document.getElementById(cash).value;
				//}
				i=i+1;
			}
			
			xmlHttp.open("POST", url, true);

			xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlHttp.setRequestHeader("Content-length", params.length);
			xmlHttp.setRequestHeader("Connection", "close");
			
			xmlHttp.onreadystatechange=utilization_result;
			
			xmlHttp.send(params);
			
			
	}
}

function utilization_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
	  if (xmlHttp.responseText=="no"){
			alert("Please Login Again !!!");  
	  } else {
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uti_table");	
		document.getElementById('utilization').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
	  }
	
		
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


function save_crec()
{
	
	if (document.getElementById("invno").value==""){
		alert("Please Click New !!!");	
	} else {
	utilization();
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="ret_chq_settle_data.php";			
			url=url+"?Command="+"save_crec";
			url=url+"&recno="+document.getElementById("invno").value;
			url=url+"&invdate="+document.getElementById("invdate").value;
			url=url+"&salesrep="+document.getElementById("salesrep").value;
			url=url+"&accno="+document.getElementById("accno").value;
			url=url+"&acc_name="+document.getElementById("acc_name").value;
			url=url+"&accno2="+document.getElementById("accno2").value;
			url=url+"&acc_name2="+document.getElementById("acc_name2").value;
			url=url+"&cuscode="+document.getElementById("cuscode").value;
			url=url+"&cusname="+document.getElementById("cusname").value;
			url=url+"&cashtot="+document.getElementById("cashtot").value;
			url=url+"&chqtot="+document.getElementById("chqtot").value;
			url=url+"&txtpaytot="+document.getElementById("txtpaytot").value;
			url=url+"&txtoverpay="+document.getElementById("txtoverpay").value;
			url=url+"&paytype="+document.getElementById("paytype").value;
			url=url+"&mcount="+document.getElementById('hiddencount').value;
			url=url+"&salesrep="+document.getElementById('salesrep').value;
			url=url+"&chqcollect="+document.getElementById('chqcollect').value;
			url=url+"&cashtt="+document.getElementById('cashtt').value;
			
			
			//alert(url);
			xmlHttp.onreadystatechange=result_save_crec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	}
}

function result_save_crec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
		if (xmlHttp.responseText=="no"){
			alert("Please Login Again !!!");
		} else {
			alert(xmlHttp.responseText);
		
		
			if (xmlHttp.responseText!="Receipt No Already Exists"){
				alert("Saved");
				print_inv();
				location.reload(true);
			} else {
				alert(xmlHttp.responseText);	
			}
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
		alert(xmlHttp.responseText);
		
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
		opener.document.form1.salesrep.value=XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("AC_REFNO");	
		opener.document.form1.cashtt.value=XMLAddress1[0].childNodes[0].nodeValue;
		
		
		//var objSalesrep = opener.document.getElementById("salesrep");
		
		/*var salesrep=XMLAddress1[0].childNodes[0].nodeValue;
		var i=0;
		while (i<objSalesrep.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}*/
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("collectcode");	
		opener.document.form1.chqcollect.value=XMLAddress1[0].childNodes[0].nodeValue;
		alert("ok");
		//var objSalesrep = opener.document.getElementById("chqcollect");
		
	/*	var salesrep=XMLAddress1[0].childNodes[0].nodeValue;
		var i=0;
		while (i<objSalesrep.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}*/
		
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