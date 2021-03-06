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

function show_claim()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	
	if (document.getElementById('Cmb_refund').value=="Recommended"){
		document.getElementById('claim').innerHTML="<select name='cmb_cl_type' id='cmb_cl_type' onkeypress='keyset('dte_dor',event);' class='text_purchase3'><option value=''>Select</option><option value='FULL'>FULL</option><option value='PRO-RATA'>PRO-RATA</option></select>";
		
		document.getElementById('commerc').innerHTML="<input type='hidden'  class='label_purchase' value='Commercialy' id='cmb_comm' name='cmb_comm' />";
	} else {
		document.getElementById('claim').innerHTML="<input type='hidden' size='20' name='cmb_cl_type' id='cmb_cl_type' value='' class='text_purchase3'/>";	
		document.getElementById('commerc').innerHTML="<select name='cmb_comm' id='cmb_comm' onchange='commercially();' class='text_purchase3'><option value=''>Select</option><option value='Allowed'>Allowed</option><option value='Not Allowed'>Not Allowed</option></select>";
	}
}

function commercially()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	if (document.getElementById('cmb_comm').value=="Allowed"){
		document.getElementById('commercialy_sub').innerHTML="<select name='cmb_c_Cl_type' id='cmb_c_Cl_type' onchange='com_sub_sub();' class='text_purchase3'><option value='FULL'>FULL</option><option value='Rec %'>Rec %</option></select>";
		
		
	} else {
		
		document.getElementById('commercialy_sub').innerHTML="<input type='hidden' size='20' name='cmb_c_Cl_type' id='cmb_c_Cl_type' value='' class='text_purchase3'/>";
	}
}

function com_sub_sub()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	if (document.getElementById('cmb_c_Cl_type').value!="FULL"){
		document.getElementById('commercialy_ref').innerHTML="1.<input type='text' size='20' name='txtadd_ref1' id='txtadd_ref1' value='' onkeypress='keyset('salesrep',event);' class='text_purchase3'/>2.<input type='text' size='20' name='txtadd_ref2' id='txtadd_ref2' value='' onkeypress='keyset('salesrep',event);' class='text_purchase3'/>";
		
		
	} else {
		
		document.getElementById('commercialy_ref').innerHTML="<input type='hidden' size='20' name='txtadd_ref1' id='txtadd_ref1' value='' onkeypress='keyset('salesrep',event);' class='text_purchase3'/><input type='hidden' size='20' name='txtadd_ref2' id='txtadd_ref2' value='' onkeypress='keyset('salesrep',event);' class='text_purchase3'/>";
	}
}

function keyset(key, e)
{	

   if(e.keyCode==13){
	 
	document.getElementById(key).focus();
   }
}

function clear_item()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
			
	document.getElementById('txtrefno').value="";
	document.getElementById('txtentdate').value="";
	
	//document.getElementById('dtf').value="";
	document.getElementById('txtcl_no').value="";
	
	document.getElementById('DTPicker_recdate').value="";
	//document.getElementById('dtto').value="";
	
	document.getElementById('txtag_code').value="";
	document.getElementById('txtag_name').value="";
	document.getElementById('txtcus_name').value="";
	
	document.getElementById('txtagadd').value="";
	document.getElementById('txtcus_add').value="";
	document.getElementById('txtstk_no').value="";
	document.getElementById('txtdes').value="";
	
	document.getElementById('txtbrand').value="";
	document.getElementById('txtpatt').value="";
	document.getElementById('txtseri_no').value="";
	document.getElementById('Combo1').value="";
	
	
	document.getElementById('txttc_ob').value="";
	document.getElementById('Cmb_refund').value="";
	
	document.getElementById('cmb_cl_type').value="";
	document.getElementById('cmb_c_Cl_type').value="";

	document.getElementById('cmb_comm').value="";
	document.getElementById('txtadd_ref1').value="";
	document.getElementById('txtadd_ref2').value="";
	document.getElementById('txtmn_ob').value="";
	document.getElementById('txtCRD_no').value="";
	document.getElementById('txtCRD_no2').value="";
	document.getElementById('txtCRD_no3').value="";
	document.getElementById('txtCRE_date').value="";
	document.getElementById('txtCRE_date2').value="";
	document.getElementById('txtCRE_date3').value="";
	document.getElementById('txtCRE_amount').value="";
	document.getElementById('txtCRE_amount2').value="";
	document.getElementById('txtCRE_amount3').value="";
	
    
}

function new_inv1()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			clear_item();
			
			//document.getElementById('invdate').value=Date();
			
			var url="battery_claim_data.php";			
			url=url+"?Command="+"new_inv";
			xmlHttp.onreadystatechange=new_inv_invresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function new_inv_invresult(){
	//alert("okkkk");
	alert(xmlHttp.responseText);
	
	document.getElementById('txtrefno').value=xmlHttp.responseText;	
	document.getElementById('txtcl_no').focus();
}


function save_inv1()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="battery_claim_data.php";	
	
	url=url+"?Command="+"save_inv";
	//$_FILES["image"]["name"][$key] ;
	
	
	url=url+"&txtrefno="+document.getElementById('txtrefno').value;
	url=url+"&txtentdate="+document.getElementById('txtentdate').value;
	//url=url+"&dtf="+document.getElementById('dtf').value;
	
	url=url+"&txtcl_no="+document.getElementById('txtcl_no').value;
	url=url+"&DTPicker_recdate="+document.getElementById('DTPicker_recdate').value;
	url=url+"&DTPicker_ddate="+document.getElementById('DTPicker_ddate').value;
	url=url+"&DTPicker_cdate="+document.getElementById('DTPicker_cdate').value;
	
	url=url+"&Check1="+document.getElementById('Check1').checked;
	//url=url+"&dtto="+document.getElementById('dtto').value;
	url=url+"&txtag_code="+document.getElementById('txtag_code').value;
	url=url+"&txtag_name="+document.getElementById('txtag_name').value;
	
	url=url+"&txtcus_name="+document.getElementById('txtcus_name').value;
	url=url+"&txtagadd="+document.getElementById('txtagadd').value;
	url=url+"&txtcus_add="+document.getElementById('txtcus_add').value;
	url=url+"&txtstk_no="+document.getElementById('txtstk_no').value;
	url=url+"&txtdes="+document.getElementById('txtdes').value;
	url=url+"&txtbrand="+document.getElementById('txtbrand').value;
	url=url+"&txtpatt="+document.getElementById('txtpatt').value;
	url=url+"&txtseri_no="+document.getElementById('txtseri_no').value;
	url=url+"&Combo1="+document.getElementById('Combo1').value;
	url=url+"&txttc_ob="+document.getElementById('txttc_ob').value;
	url=url+"&Cmb_refund="+document.getElementById('Cmb_refund').value;
	
	if ((document.getElementById('t11').value!="") && (isNaN(document.getElementById('t11').value)==false)){
		url=url+"&t11="+document.getElementById('t11').value;
	} else {
		url=url+"&t11=0";	
	}
	if ((document.getElementById('t12').value!="") && (isNaN(document.getElementById('t12').value)==false)){
		url=url+"&t12="+document.getElementById('t12').value;
	} else {
		url=url+"&t12=0";	
	}
	if ((document.getElementById('t13').value!="") && (isNaN(document.getElementById('t13').value)==false)){
		url=url+"&t13="+document.getElementById('t13').value;
	} else {
		url=url+"&t13=0";	
	}
	if ((document.getElementById('t14').value!="") && (isNaN(document.getElementById('t14').value)==false)){
		url=url+"&t14="+document.getElementById('t14').value;
	} else {
		url=url+"&t14=0";	
	}
	if ((document.getElementById('t15').value!="") && (isNaN(document.getElementById('t15').value)==false)){
		url=url+"&t15="+document.getElementById('t15').value;
	} else {
		url=url+"&t15=0";	
	}
	if ((document.getElementById('t16').value!="") && (isNaN(document.getElementById('t16').value)==false)){
		url=url+"&t16="+document.getElementById('t16').value;
	} else {
		url=url+"&t16=0";	
	}
	if ((document.getElementById('t21').value!="") && (isNaN(document.getElementById('t21').value)==false)){
		url=url+"&t21="+document.getElementById('t21').value;
	} else {
		url=url+"&t21=0";	
	}
	if ((document.getElementById('t22').value!="") && (isNaN(document.getElementById('t22').value)==false)){
		url=url+"&t22="+document.getElementById('t22').value;
	} else {
		url=url+"&t22=0";	
	}
	if ((document.getElementById('t23').value!="") && (isNaN(document.getElementById('t23').value)==false)){
		url=url+"&t23="+document.getElementById('t23').value;
	} else {
		url=url+"&t23=0";	
	}
	if ((document.getElementById('t24').value!="") && (isNaN(document.getElementById('t24').value)==false)){
		url=url+"&t24="+document.getElementById('t24').value;
	} else {
		url=url+"&t24=0";	
	}
	if ((document.getElementById('t25').value!="") && (isNaN(document.getElementById('t25').value)==false)){
		url=url+"&t25="+document.getElementById('t25').value;
	} else {
		url=url+"&t25=0";	
	}
	if ((document.getElementById('t26').value!="") && (isNaN(document.getElementById('t26').value)==false)){
		url=url+"&t26="+document.getElementById('t26').value;
	} else {
		url=url+"&t26=0";	
	}
	
	if ((document.getElementById('t31').value!="") && (isNaN(document.getElementById('t31').value)==false)){
		url=url+"&t31="+document.getElementById('t31').value;
	} else {
		url=url+"&t31=0";	
	}
	if ((document.getElementById('t32').value!="") && (isNaN(document.getElementById('t32').value)==false)){
		url=url+"&t32="+document.getElementById('t32').value;
	} else {
		url=url+"&t32=0";	
	}
	if ((document.getElementById('t33').value!="") && (isNaN(document.getElementById('t33').value)==false)){
		url=url+"&t33="+document.getElementById('t33').value;
	} else {
		url=url+"&t33=0";	
	}
	if ((document.getElementById('t34').value!="") && (isNaN(document.getElementById('t34').value)==false)){
		url=url+"&t34="+document.getElementById('t34').value;
	} else {
		url=url+"&t34=0";	
	}
	if ((document.getElementById('t35').value!="") && (isNaN(document.getElementById('t35').value)==false)){
		url=url+"&t35="+document.getElementById('t35').value;
	} else {
		url=url+"&t35=0";	
	}
	if ((document.getElementById('t36').value!="") && (isNaN(document.getElementById('t36').value)==false)){
		url=url+"&t36="+document.getElementById('t36').value;
	} else {
		url=url+"&t36=0";	
	}
	
	
	
	//url=url+"&txtrem_per="+document.getElementById('txtrem_per').value;
	//url=url+"&txtspec="+document.getElementById('txtspec').value;
	//url=url+"&txtremming="+document.getElementById('txtremming').value;
	//url=url+"&txtref_per="+document.getElementById('txtref_per').value;
	url=url+"&cmb_comm="+document.getElementById('cmb_comm').value;
	//alert(url);
	url=url+"&txtadd_ref1="+document.getElementById('txtadd_ref1').value;
	url=url+"&txtadd_ref2="+document.getElementById('txtadd_ref2').value;
	url=url+"&txtmn_ob="+document.getElementById('txtmn_ob').value;
	url=url+"&txtCRD_no="+document.getElementById('txtCRD_no').value;
	url=url+"&txtCRD_no2="+document.getElementById('txtCRD_no2').value;
	url=url+"&txtCRD_no3="+document.getElementById('txtCRD_no3').value;
	url=url+"&txtCRE_date="+document.getElementById('txtCRE_date').value;
	url=url+"&txtCRE_date2="+document.getElementById('txtCRE_date2').value;
	url=url+"&txtCRE_date3="+document.getElementById('txtCRE_date3').value;
	url=url+"&txtCRE_amount="+document.getElementById('txtCRE_amount').value;
	url=url+"&txtCRE_amount2="+document.getElementById('txtCRE_amount2').value;
	url=url+"&txtCRE_amount3="+document.getElementById('txtCRE_amount3').value;
	
   
	xmlHttp.onreadystatechange=item_save_results;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function item_save_results()
{
	var XMLAddress1;
	//alert(xmlHttp.responseText);
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
		alert(xmlHttp.responseText);
						
		//	document.getElementById("message").innerHTML=xmlHttp.responseText;
		//	setTimeout("location.reload(true);",1000);
			alert("Successfully Saved");
			
			clear_item();
		}
}

function cancel_inv()
{
	
  var msg=confirm("Are you sure to DELETE ? ");
  if (msg==true){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="battery_claim_data.php";	
	
	url=url+"?Command="+"cancel_inv";
	//$_FILES["image"]["name"][$key] ;
	
	url=url+"&txtrefno="+document.getElementById('txtrefno').value;
	xmlHttp.onreadystatechange=cancel_inv_results;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
 
  }
}

function cancel_inv_results()
{
	var XMLAddress1;
	//alert(xmlHttp.responseText);
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
						
		//	document.getElementById("message").innerHTML=xmlHttp.responseText;
		//	setTimeout("location.reload(true);",1000);
			alert(xmlHttp.responseText);
			
			//clear_item();
		}
}

function chk_number()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="item_data.php";	
	
	url=url+"?Command="+"chk_number";
	//$_FILES["image"]["name"][$key] ;
	
	url=url+"&txtSTK_NO="+document.getElementById('txtSTK_NO').value;
	//alert(url);
	xmlHttp.onreadystatechange=chk_number_results;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function chk_number_results()
{
	var XMLAddress1;
	//alert(xmlHttp.responseText);
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
						
		//	document.getElementById("message").innerHTML=xmlHttp.responseText;
		//	setTimeout("location.reload(true);",1000);
			if (xmlHttp.responseText=="included"){
				alert("Already Included Stock No ! ");
				location.reload(true);
			}
			
			
		}
}

function item_delete_results()
{
	var XMLAddress1;
	//alert(xmlHttp.responseText);
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
						
		//	document.getElementById("message").innerHTML=xmlHttp.responseText;
		//	setTimeout("location.reload(true);",1000);
			alert("Successfully Deleted");
			
			clear_item();
		}
}

function stores_update()
{
		
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="item_data.php";	
	
	xmlHttp.onreadystatechange=stores_update_results;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function stores_update_results()
{
	var XMLAddress1;
	//alert(xmlHttp.responseText);
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
			
			alert(xmlHttp.responseText);
		}
}

