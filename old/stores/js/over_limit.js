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

function cal_subtot(count, totcount)
{
	
	var preretqty='preretqty'+count;
	var price='price'+count;
	var retqty='retqty'+count;
	var value='value'+count;

	
	
	
	var dTotal = 0;
	
	if (document.getElementById('checkbox').checked == true) {
		var i=1;
		
		while (i<totcount){
			
			if (parseFloat(document.getElementById(retqty).value) >= 0) {
				alert(document.getElementById(preretqty).value);
				document.getElementById(value).value = parseFloat(document.getElementById(retqty).value) * parseFloat(document.getElementById(price).value) * (100 - parseFloat(document.getElementById(preretqty).value)) / 100;
				dTotal = dTotal + parseFloat(document.getElementById(value).value);
			} else {
  				if (document.getElementById('txt_stat').value!= "OLD") { document.getElementById(retqty).value = ""; }
			}
			i=i+1;
		}
	}
	
	if (document.getElementById('checkbox').checked == false) {
    	var i=1;
		while (i<totcount){
			
    		if (parseFloat(document.getElementById(retqty).value) > 0) {
        		document.getElementById(value).value = parseFloat(document.getElementById(retqty).value) * parseFloat(document.getElementById(price).value) * (100 - parseFloat(document.getElementById(preretqty).value)) / 100;
        		dTotal = dTotal + parseFloat(document.getElementById(value).value);
			}
			i=i+1;
		}
	}
	document.getElementById('invtot').value = dTotal;

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
		//alert("ok");
		//var txt_cuscode=document.getElementById('txt_cuscode').value
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
			
			
		if (document.getElementById('qty').value<=document.getElementById('stklevel').value){
			var str=document.getElementById('rate').value;
			var n=str.replace(/,/gi, ""); 
			
			var subtotal=parseFloat(n)*parseFloat(document.getElementById('qty').value);
			var dis=0;
			var dis1=0;
			var dis2=0;
			var dis3=0;
			var disper=0;
			var dis1f=0;
			var dis2f=0;
			var dis3f=0;
			
			
			if ((document.getElementById('discount1').value != '') && (document.getElementById('discount1').value != "0") && (document.getElementById('discount1').value != "0.00")){
				dis1=subtotal*document.getElementById('discount1').value/100;
				disper=document.getElementById('discount1').value;
				
			}
			dis1f=dis1.toFixed(2);
			subtotal=subtotal-dis1f;
			
			if ((document.getElementById('discount2').value != '')&&(document.getElementById('discount2').value != "0")&&(document.getElementById('discount2').value != "0.00")){
				dis2=subtotal*document.getElementById('discount2').value/100;
				disper=100-(100-document.getElementById('discount2').value)*(100-document.getElementById('discount1').value)/100;
				
			}
			dis2f=dis2.toFixed(2);
			subtotal=subtotal-dis2f;
			
			if ((document.getElementById('discount3').value != '')&&(document.getElementById('discount3').value != "0")&&(document.getElementById('discount3').value != "0.00")){
				dis3=subtotal*document.getElementById('discount3').value/100;
				disper=100-(100-document.getElementById('discount3').value)*(100-document.getElementById('discount2').value)*(100-document.getElementById('discount1').value)/100;
				
			}
			dis3f=dis3.toFixed(2);
			subtotal=subtotal-dis3f;
			
			dis=parseFloat(dis1f)+parseFloat(dis2f)+parseFloat(dis3f);
			
			document.getElementById('discount').value=dis;
			document.getElementById('discountper').value=disper;
			document.getElementById('subtotal').value= subtotal.toFixed(2);
		} else {
			alert("Insufficient Quantity");	
		}
		
	
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
			
		
			
			var url="pur_ord_data.php";			
			url=url+"?Command="+"add_tmp";
			url=url+"&invno="+document.getElementById('invno').value;
			
			url=url+"&itemcode="+document.getElementById('itemd_hidden').value;
			
			url=url+"&item="+document.getElementById('itemd').value;
			url=url+"&partno="+document.getElementById('partno').value;
			url=url+"&qty="+document.getElementById('qty').value;
			
			//alert(url);
			
			xmlHttp.onreadystatechange=showarmyresult_addtmp;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function showarmyresult_addtmp()
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
		
	
		
		
		
		//document.getElementById('invno').value="";
		document.getElementById('itemd_hidden').value="";
		document.getElementById('itemd').value="";
		document.getElementById('partno').value="";
		document.getElementById('qty').value="";
		
		document.getElementById('searchcust').focus();
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
			
			
			var url="pur_ord_data.php";			
			url=url+"?Command="+"del_item";
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&code="+code;
			
			
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

function clear_customer(){
	location.reload();
	/*document.getElementById('txt_cuscode').value="";
	document.getElementById('txtCNAME').value="";
	document.getElementById('txtBADD1').value="";
	document.getElementById('txtBADD2').value="";
	document.getElementById('txtTEL').value="";
	document.getElementById('txttel2').value="";
	document.getElementById('txtFAX').value="";
	document.getElementById('TXTEMAIL').value="";
	document.getElementById('DTbankgrdate').value="";
	document.getElementById('DTOPDATE').value="";
	document.getElementById('txtcper').value="";
	document.getElementById('txtACCno').value="";
	document.getElementById('txtcrlimt').value="";
	document.getElementById('txtbal').value="";
	document.getElementById('txtover').value="";
	document.getElementById('txtvatno').value="";
	document.getElementById('txtcat').value="";
	document.getElementById('txttype').value="";
	document.getElementById('txtarea').value="";
	document.getElementById('TXT_REP').value="";
	document.getElementById('txtBRAND_NAME11').value="";
	document.getElementById('creditlim').innerHTML="";
	document.getElementById('txtlimit').value="";
	document.getElementById('cmbCAt').value="";
	document.getElementById('txtBRAND_NAME11').value="";*/

}

function new_customer()
{
	clear_customer();
}

function save_customer()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 	
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"save_customer";
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&txtCNAME="+document.getElementById('txtCNAME').value;
			url=url+"&txtBADD1="+document.getElementById('txtBADD1').value;
			url=url+"&txtBADD2="+document.getElementById('txtBADD2').value;
			url=url+"&txtTEL="+document.getElementById('txtTEL').value;
			url=url+"&txttel2="+document.getElementById('txttel2').value;
			url=url+"&txtFAX="+document.getElementById('txtFAX').value;
			url=url+"&TXTEMAIL="+document.getElementById('TXTEMAIL').value;
			url=url+"&DTbankgrdate="+document.getElementById('DTbankgrdate').value;
			url=url+"&DTOPDATE="+document.getElementById('DTOPDATE').value;
			url=url+"&txtcper="+document.getElementById('txtcper').value;
			url=url+"&txtACCno="+document.getElementById('txtACCno').value;
			url=url+"&txtcrlimt="+document.getElementById('txtcrlimt').value;
			url=url+"&txtbal="+document.getElementById('txtbal').value;
			url=url+"&txtover="+document.getElementById('txtover').value;
			url=url+"&txtvatno="+document.getElementById('txtvatno').value;
			url=url+"&txtcat="+document.getElementById('txtcat').value;
			url=url+"&txttype="+document.getElementById('txttype').value;
			url=url+"&txtarea="+document.getElementById('txtarea').value;
			url=url+"&TXT_REP="+document.getElementById('TXT_REP').value;
			url=url+"&txtInc="+document.getElementById('txtInc').value;
			url=url+"&chkgarant="+document.getElementById('chkgarant').value;
			url=url+"&txtMsg="+document.getElementById('txtMsg').value;

		
			xmlHttp.onreadystatechange=save_customer_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function save_customer_result()
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

function delete_customer()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 	
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"delete_customer";
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			

		
			xmlHttp.onreadystatechange=delete_customer_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function delete_customer_result()
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

function save_inv()
{   
	
		//alert("ok");	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		//alert(inv_status);
	
		var url='over_limit_data.php';	
			var params = "Command=save_inv";
			params = params+"&mcount="+document.getElementById('mcount').value;
			
			
			var mcou=document.getElementById('mcount').value;
			var i=1;
			
			while (mcou>i){
				myg01="myg"+i+"_01";
   				myg02="myg"+i+"_02";
				myg03="myg"+i+"_03";
				myg04="myg"+i+"_04";
				myg05="myg"+i+"_05";
				myg06="myg"+i+"_06";
				myg07="myg"+i+"_07";
				myg08="myg"+i+"_08";
				myg09="myg"+i+"_09";
				myg10="myg"+i+"_10";
				myg11="myg"+i+"_11";
				myg12="myg"+i+"_12";
				myg13="myg"+i+"_13";
				myg14="myg"+i+"_14";
				myg15="myg"+i+"_15";
				myg16="myg"+i+"_16";
				myg17="myg"+i+"_17";
				myg18="myg"+i+"_18";
				myg19="myg"+i+"_19";
				myg20="myg"+i+"_20";
				myg21="myg"+i+"_21";

				params = params+"&"+myg01+"="+document.getElementById(myg01).innerHTML;
				params = params+"&"+myg02+"="+document.getElementById(myg02).innerHTML;
				params = params+"&"+myg03+"="+document.getElementById(myg03).innerHTML;
				params = params+"&"+myg04+"="+document.getElementById(myg04).innerHTML;
				params = params+"&"+myg05+"="+document.getElementById(myg05).innerHTML;
				params = params+"&"+myg06+"="+document.getElementById(myg06).innerHTML;
				params = params+"&"+myg07+"="+document.getElementById(myg07).innerHTML;
				params = params+"&"+myg08+"="+document.getElementById(myg08).innerHTML;
				params = params+"&"+myg09+"="+document.getElementById(myg09).innerHTML;
				params = params+"&"+myg10+"="+document.getElementById(myg10).innerHTML;
				params = params+"&"+myg11+"="+document.getElementById(myg11).innerHTML;
				params = params+"&"+myg12+"="+document.getElementById(myg12).innerHTML;
				params = params+"&"+myg13+"="+document.getElementById(myg13).innerHTML;
				params = params+"&"+myg14+"="+document.getElementById(myg14).innerHTML;
				params = params+"&"+myg15+"="+document.getElementById(myg15).innerHTML;
				params = params+"&"+myg16+"="+document.getElementById(myg16).innerHTML;
				params = params+"&"+myg17+"="+document.getElementById(myg17).innerHTML;
				params = params+"&"+myg18+"="+document.getElementById(myg18).innerHTML;
				params = params+"&"+myg19+"="+document.getElementById(myg19).innerHTML;
				params = params+"&"+myg20+"="+document.getElementById(myg20).innerHTML;
				params = params+"&"+myg21+"="+document.getElementById(myg21).innerHTML;
				
				i=i+1;
			}
			alert(params);	
			xmlHttp.open("POST", url, true);

			xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlHttp.setRequestHeader("Content-length", params.length);
			xmlHttp.setRequestHeader("Connection", "close");
			
			xmlHttp.onreadystatechange=passresult_save_inv;
			
			xmlHttp.send(params);
			
		
			
			
		
		
}

function passresult_save_inv()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
	}
}

function appro(cellno, a)
{
	//alert(cellno);
	/*if (document.getElementById(cellno).innertHTML==" "){
		document.getElementById(cellno).innertHTML="YES";
	} else if (document.getElementById(cellno).innertHTML=="YES"){
		document.getElementById(cellno).innertHTML="NO";
	} else if (document.getElementById(cellno).innertHTML=="NO"){
		document.getElementById(cellno).innertHTML="";
	}*/
	
		
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 	
			
			myg01="myg"+cellno+"_01";
			myg08="myg"+cellno+"_08";
			myg20="myg"+cellno+"_20";
			myg21="myg"+cellno+"_21";
			
			var url="over_limit_data.php";			
			url=url+"?Command="+"appro";
			url=url+"&i="+cellno;
			url=url+"&a="+a;
			url=url+"&myg01="+document.getElementById(myg01).innerHTML;
			url=url+"&myg08="+document.getElementById(myg08).innerHTML;
			url=url+"&myg20="+document.getElementById(myg20).innerHTML;
			url=url+"&myg21="+document.getElementById(myg21).innerHTML;
			alert(url);
			xmlHttp.onreadystatechange=result_appro;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function result_appro()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
		if (xmlHttp.responseText=="Sorry you are trying to exceed more then 25% Exceed limit"){
			alert(xmlHttp.responseText);
		}
		
		var msg;
		var a= xmlHttp.responseText;
		var res=a.split("-");
		message=res[1];
			
		alert(a);
		alert(res[0]);
		alert(message);
		
		
		if (message=="You are trying to exceed more then 25% Exceed limit"){
			 msg=confirm("Are you trying to exceed more then 25% Exceed limit ?");
			 
			  if (msg==true){
				  appro(res[0], '1');
			  }
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("warn");	
		var msg = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("i");	
		var i = XMLAddress1[0].childNodes[0].nodeValue;
		
		myg20="myg"+i+"_20";
		
		var res;
		
		if (msg!=""){
			res=confirm(msg);
			if (res==true){
				document.getElementById(myg20).innerHTML="YES";
			} else {
				document.getElementById(myg20).innerHTML="---";	
			}
		} else {
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("resmyg20");	
			document.getElementById(myg20).innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
			
		}
		
		
	}
}

function arnno(arno)
{
	//alert("ok");
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="arn_pur_ret_data.php";			
	url=url+"?Command="+"pass_arnno";
	url=url+"&arnno="+arno;
	//alert(url);
	
	xmlHttp.onreadystatechange=result_pass_arnno;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function result_pass_arnno()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REFNO");	
		opener.document.form1.arnno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");	
		opener.document.form1.grndate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SUP_CODE");	
		opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SUP_NAME");	
		opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
	
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REMARK");	
		opener.document.form1.reason.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEPARTMENT");	
		var objSalesrep = opener.document.getElementById("department");
		
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
		 
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("count");	
		opener.document.form1.mcou.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tot");	
		opener.document.form1.invtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		self.close();
	}
	
}


function cancel_inv()
{
		xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		//alert(inv_status);
			
			var url="arn_data.php";			
			url=url+"?Command="+"cancel_inv";
		
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&orderno1="+document.getElementById('orderno1').value;
			url=url+"&department="+document.getElementById('department').value;
						
			xmlHttp.onreadystatechange=salescancelresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function salescancelresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
	}
}

function close_form()
{
	self.close();	
}

function view_from()
{   
	document.getElementById('wait_lbl').innerHTML= "Please Wait..........";
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
						
			
			
			//var objsalesrep = document.getElementById("salesrep");
			//objsalesrep.options[0].selected=true;
			
			
		
		
			var url="over_limit_data.php";			
			url=url+"?Command="+"view_from";
			url=url+"&dtfrom="+document.getElementById('dtfrom').value;
			alert(url);
			xmlHttp.onreadystatechange=assign_view_from;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_view_from(){
	alert(xmlHttp.responseText);
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
				
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
		document.getElementById('mcount').value = XMLAddress1[0].childNodes[0].nodeValue;
	}
	
	document.getElementById('wait_lbl').innerHTML="";
	//document.getElementById('credper').value=65;
//	document.getElementById('searchcust').focus();
	
}

function print_inv()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
 
 	var url="inv_data.php";			
	url=url+"?Command="+"check_print";
  
    xmlHttp.onreadystatechange=passprintresult;
	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	
	
}

function passprintresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		if (xmlHttp.responseText==1){
			var url="rep_inv.php";			
			url=url+"?invno="+document.getElementById('invno').value;
			window.open(url);
  		} else {
			alert("Invoice is not available");  
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
			
			
			var url="search_arn_data.php";			
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



function passinvresult_crn()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REF_NO");
		opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");
		opener.document.form1.inv_date.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CODE");
		opener.document.form1.cus_code.value = XMLAddress1[0].childNodes[0].nodeValue;
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUS_NAME");
		opener.document.form1.cus_name.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SAL_EX");	
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEPARTMENT");	
		var objSalesrep = opener.document.getElementById("department");
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");
		opener.document.form1.inv_date.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_amt");
		opener.document.form1.invamount.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TOTPAY");
		opener.document.form1.totpay.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("balance");
		opener.document.form1.invbal.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Brand");	
		var objSalesrep = opener.document.getElementById("brand");
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
		self.close();
	}
	
}

function passinvresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
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
		var txt_cuscode=XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");	
		opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address");	
		opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno1");	
		opener.document.form1.vat1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno2");	
		opener.document.form1.vat2.value = XMLAddress1[0].childNodes[0].nodeValue;
	

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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_orderno1");	
		opener.document.form1.salesord1.value = XMLAddress1[0].childNodes[0].nodeValue;
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

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");	
		opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
		opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis1");	
		opener.document.form1.discount2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis2");	
		opener.document.form1.discount3.value = XMLAddress1[0].childNodes[0].nodeValue;
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");	
		window.opener.document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		opener.document.form1.credper.value = 65;
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

function suppno(suppno)
{   
			//alert(stname);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			
			var url="search_supplier_data.php";			
			url=url+"?Command="+"pass_suppno";
			url=url+"&suppno="+suppno;
			//url=url+"&brand="+opener.document.form1.brand.value;
			//url=url+"&salesrep="+opener.document.form1.salesrep.value;
			xmlHttp.onreadystatechange=passsuppresult;
			
			
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function passsuppresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
		opener.document.form1.supplier_code.value=XMLAddress1[0].childNodes[0].nodeValue;;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
		opener.document.form1.supplier_name.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("address");	
		opener.document.form1.address.value = XMLAddress1[0].childNodes[0].nodeValue;
						
		self.close();
		opener.document.form1.salesrep.focus();
	}
}

function passcusresult_crn()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");	
		opener.document.form1.cus_code.value=XMLAddress1[0].childNodes[0].nodeValue;;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");	
		opener.document.form1.cus_name.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");	
		var add1=XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");	
		var add2=XMLAddress1[0].childNodes[0].nodeValue;
		
		opener.document.form1.cus_address.value =add1+" "+add2;
		
		self.close();
	}
}

function passcusresult_cash_rec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
		opener.document.form1.hiddencount.value=XMLAddress1[0].childNodes[0].nodeValue;;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
		opener.document.form1.cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
			
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
		opener.document.form1.cusname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("address");	
		opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");	
		//alert( XMLAddress1[0].childNodes[0].nodeValue);
		window.opener.document.getElementById('inv_details').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		self.close();
		//opener.document.form1.txtdetar.focus();
	}
}

function setord()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
	var url="inv_data.php";			
	url=url+"?Command="+"setord";
	url=url+"&custno="+document.getElementById('firstname_hidden').value;
	//url=url+"&salesord1="+document.getElementById('salesord1').value;
	url=url+"&salesrep="+document.getElementById('salesrep').value;
	url=url+"&brand="+document.getElementById('brand').value;
	url=url+"&department="+document.getElementById('department').value;
//alert(url);
	xmlHttp.onreadystatechange=setord_result_inv;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function setord_result_inv(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		//document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;


		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");	
		document.getElementById('creditlimit').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");	
		document.getElementById('balance').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");	
		document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

	}
		
		
}

function passcusresult_rep_mast_s()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
		opener.document.form1.txt_cuscode_s.value = XMLAddress1[0].childNodes[0].nodeValue;
			
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
		opener.document.form1.txt_cusname_s.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		opener.document.form1.txtdetar_s.value = "";
		
		
		self.close();
		opener.document.form1.txtdetar.focus();
	}
}

function passcusresult_rep_mast()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");	
		opener.document.form1.txt_cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
			
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
		opener.document.form1.txt_cusname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		opener.document.form1.txtdetar.value = "";
		
		
		self.close();
		opener.document.form1.txtdetar.focus();
	}
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_svatno");	
		opener.document.form1.vat2.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		if ((opener.document.form1.vat1.value == '') && (opener.document.form1.vat2.value == '')) {
			opener.document.form1.vatgroup_1.checked=true;
		} else if ((opener.document.form1.vat1.value != '') && (opener.document.form1.vat2.value == '')){
			opener.document.form1.vatgroup_0.checked=true;
		} else if ((opener.document.form1.vat1.value != '') && (opener.document.form1.vat2.value != '')){
			opener.document.form1.vatgroup_2.checked=true;
		} 
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");	
		opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");	
		opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;
	
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
		//opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");	
		window.opener.document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

		
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
			
			
			var url="search_item_purord_data.php";			
			url=url+"?Command="+"pass_itno";
			url=url+"&itno="+itno;
			url=url+"&brand="+opener.document.form1.brand.value;
			url=url+"&department="+opener.document.form1.department.value;
			
			
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
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");	
		opener.document.form1.itemd_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");	
		opener.document.form1.itemd.value = XMLAddress1[0].childNodes[0].nodeValue;


		
		self.close();
		opener.document.form1.partno.focus();
		
	
		
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




function tmp_crelimit()
{ 
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"tmp_crelimit";
			url=url+"&Com_rep1="+document.getElementById('Com_rep1').value;
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&cmbbrand1="+document.getElementById('cmbbrand1').value;
			url=url+"&txt_templimit="+document.getElementById('txt_templimit').value;
			//alert(url);
			
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

