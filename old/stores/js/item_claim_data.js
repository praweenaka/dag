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


function print_inv1()
{
	//alert("ok");
//	var XMLAddress1;
	
	//if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	//{
		//alert(xmlHttp.responseText);
		//if (xmlHttp.responseText==1){
			var url="rep_item_claim.php";			
			url=url+"?txtrefno="+document.getElementById('txtrefno').value;
			url=url+"&txtCRD_no="+document.getElementById('txtCRD_no').value;
			url=url+"&txtCRE_date="+document.getElementById('txtCRE_date').value;
			url=url+"&txtCRE_amount="+document.getElementById('txtCRE_amount').value;
			url=url+"&txtCRD_no2="+document.getElementById('txtCRD_no2').value;
			url=url+"&txtCRE_date2="+document.getElementById('txtCRE_date2').value;
			url=url+"&txtCRE_amount2="+document.getElementById('txtCRE_amount2').value;
			url=url+"&txtCRD_no3="+document.getElementById('txtCRD_no3').value;
			url=url+"&txtCRE_date3="+document.getElementById('txtCRE_date3').value;
			url=url+"&txtCRE_amount3="+document.getElementById('txtCRE_amount3').value;
			url=url+"&Prn_md="+document.getElementById('Prn_md').checked;
			url=url+"&Cmb_refund="+document.getElementById('Cmb_refund').value;
			url=url+"&txtag_code="+document.getElementById('txtag_code').value;
			
			window.open(url,'_blank');
  		//} else {
		//	alert("Invoice is not available");  
  		//}
	//}
}

function show_hide()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
	
	if (document.getElementById('Check1').checked==true){		
		document.getElementById('additional').innerHTML="1.<input type='text' size='20' name='txtadd_ref1' id='txtadd_ref1' value='' onkeypress='keyset('salesrep',event);' class='text_purchase3'/>2.<input type='text' size='20' name='txtadd_ref2' id='txtadd_ref2' value='' onkeypress='keyset('salesrep',event);' class='text_purchase3'/>";
	} else {
		document.getElementById('additional').innerHTML="1.<input type='hidden' size='20' name='txtadd_ref1' id='txtadd_ref1' value='' onkeypress='keyset('salesrep',event);' class='text_purchase3'/>2.<input type='hidden' size='20' name='txtadd_ref2' id='txtadd_ref2' value='' onkeypress='keyset('salesrep',event);' class='text_purchase3'/>";	
	}
}

function keyset(key, e)
{	

   if(e.keyCode==13){
	 
	document.getElementById(key).focus();
   }
}

function calc_rem()
{
	
	if (document.getElementById('txtremin1').value!=""){
		txtremin1=document.getElementById('txtremin1').value;	
	} else {
		txtremin1=0;	
	}
	
	if (document.getElementById('txtremin2').value!=""){
		txtremin2=document.getElementById('txtremin2').value;	
	} else {
		txtremin2=0;	
	}
	
	if (document.getElementById('txtremin3').value!=""){
		txtremin3=document.getElementById('txtremin3').value;	
	} else {
		txtremin3=0;	
	}
	
	if (document.getElementById('txtremin4').value!=""){
		txtremin4=document.getElementById('txtremin4').value;	
	} else {
		txtremin4=0;	
	}
	
	if (document.getElementById('txtremin5').value!=""){
		txtremin5=document.getElementById('txtremin5').value;	
	} else {
		txtremin5=0;	
	}
	
	
	
	if (document.getElementById('txtorigin1').value!=""){
		txtorigin1=document.getElementById('txtorigin1').value;	
	} else {
		txtorigin1=0;	
	}
	
	if (document.getElementById('txtorigin2').value!=""){
		txtorigin2=document.getElementById('txtorigin2').value;	
	} else {
		txtorigin2=0;	
	}
	
	if (document.getElementById('txtorigin3').value!=""){
		txtorigin3=document.getElementById('txtorigin3').value;	
	} else {
		txtorigin3=0;	
	}
	
	if (document.getElementById('txtorigin4').value!=""){
		txtorigin4=document.getElementById('txtorigin4').value;	
	} else {
		txtorigin4=0;	
	}
	
	if (document.getElementById('txtorigin5').value!=""){
		txtorigin5=document.getElementById('txtorigin5').value;	
	} else {
		txtorigin5=0;	
	}
	
	
		
    	var totremain = parseFloat(txtremin1) + parseFloat(txtremin2) + parseFloat(txtremin3) + parseFloat(txtremin4) + parseFloat(txtremin5);
    	var totorigin = parseFloat(txtorigin1) + parseFloat(txtorigin2) + parseFloat(txtorigin3) + parseFloat(txtorigin4) + parseFloat(txtorigin5);
		
		if (totorigin!=0){
			var rep_per=new Number(totremain / totorigin * 100);
    		document.getElementById('txtrem_per').value = rep_per.toPrecision(4);
		}
		
	
}

function chngcomm()
{
	if (document.getElementById('cmb_comm').value=="Not Allowed"){
		
		document.getElementById("apprby").style.visibility="hidden";
		document.getElementById("approvedby").style.visibility="hidden";
		
	} else if (document.getElementById('cmb_comm').value=="Allowed"){
		
		document.getElementById("apprby").style.visibility="visible";
		document.getElementById("approvedby").style.visibility="visible";
		
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
	document.getElementById('dtf').value="";
	document.getElementById('txtcl_no').value="";
	
	document.getElementById('DTPicker_recdate').value="";
	document.getElementById('dtto').value="";
	
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
	document.getElementById('txtremin1').value="";
	document.getElementById('txtremin2').value="";
	document.getElementById('txtremin3').value="";
	document.getElementById('txtremin4').value="";
	document.getElementById('txtremin5').value="";
	document.getElementById('txtorigin1').value="";
	document.getElementById('txtorigin2').value="";
	document.getElementById('txtorigin3').value="";
	document.getElementById('txtorigin4').value="";
	document.getElementById('txtorigin5').value="";
	document.getElementById('txtrem_per').value="";
	document.getElementById('txtspec').value="";
	document.getElementById('txtremming').value="";
	document.getElementById('txtref_per').value="";
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
			
			var url="item_claim_data.php";			
			url=url+"?Command="+"new_inv";
			xmlHttp.onreadystatechange=new_inv_invresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function new_inv_invresult(){
	//alert("okkkk");
	//alert(xmlHttp.responseText);
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");	
	document.getElementById('txtrefno').value = XMLAddress1[0].childNodes[0].nodeValue;		
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_date");	
	document.getElementById('txtentdate').value = XMLAddress1[0].childNodes[0].nodeValue;		
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_date2");	
	document.getElementById('DTPicker_recdate').value = XMLAddress1[0].childNodes[0].nodeValue;		
	
	//document.getElementById('txtrefno').value=xmlHttp.responseText;	
	document.getElementById('txtcl_no').focus();
}


function settec_obs()
{
	document.getElementById('txttc_ob').value=document.getElementById('Combo1').value;	
}

function save_inv1()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="item_claim_data.php";	
	
	url=url+"?Command="+"save_inv";
	//$_FILES["image"]["name"][$key] ;
	
	
	url=url+"&txtrefno="+document.getElementById('txtrefno').value;
	url=url+"&txtentdate="+document.getElementById('txtentdate').value;
	url=url+"&dtf="+document.getElementById('dtf').value;
	url=url+"&txtcl_no="+document.getElementById('txtcl_no').value;
	url=url+"&DTPicker_recdate="+document.getElementById('DTPicker_recdate').value;
	url=url+"&dtto="+document.getElementById('dtto').value;
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
	url=url+"&txtremin1="+document.getElementById('txtremin1').value;
	url=url+"&txtremin2="+document.getElementById('txtremin2').value;
	url=url+"&txtremin3="+document.getElementById('txtremin3').value;
	url=url+"&txtremin4="+document.getElementById('txtremin4').value;
	url=url+"&txtremin5="+document.getElementById('txtremin5').value;
	url=url+"&txtorigin1="+document.getElementById('txtorigin1').value;
	url=url+"&txtorigin2="+document.getElementById('txtorigin2').value;
	url=url+"&txtorigin3="+document.getElementById('txtorigin3').value;
	url=url+"&txtorigin4="+document.getElementById('txtorigin4').value;
	url=url+"&txtorigin5="+document.getElementById('txtorigin5').value;
	url=url+"&txtrem_per="+document.getElementById('txtrem_per').value;
	url=url+"&txtspec="+document.getElementById('txtspec').value;
	url=url+"&txtremming="+document.getElementById('txtremming').value;
	url=url+"&txtref_per="+document.getElementById('txtref_per').value;
	url=url+"&cmb_comm="+document.getElementById('cmb_comm').value;
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
	url=url+"&approvedby="+document.getElementById('approvedby').value;
	
   
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
			
	var url="item_claim_data.php";	
	
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

