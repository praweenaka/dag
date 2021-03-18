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

function got_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000066";
  
}

function lost_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000000";
  
}


function print_inv()
{
 
			var url="creditnote_print.php";			
			url=url+"?invno="+document.getElementById('crnno').value;
                        
                     
			window.open(url);
   
}

   
 

function save_inv()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
	 
             document.getElementById('msg_box').innerHTML = "";
            if (document.getElementById('crnno').value == "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Please Click New</span></div>";
                return false;
            }
             if (document.getElementById('cus_code').value == "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Customer</span></div>";
                return false;
            }
            if (document.getElementById('crndate').value == "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Date</span></div>";
                return false;
            }
             if (document.getElementById('amount').value == "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Enter Amount</span></div>";
                return false;
            }
             
         	var paymethod;
			
			var url="creditnote_data.php";			
			url=url+"?Command="+"save_crn";
// 			url=url+"&chkcash_disc="+document.getElementById('chkcash_disc').checked;
			url=url+"&crnno="+document.getElementById('crnno').value;
			url=url+"&cus_code="+document.getElementById('cus_code').value;
			url=url+"&cus_name="+document.getElementById('cus_name').value;
			
			myString=document.getElementById('remarks').value;
			myString = myString.replace(/[\r\n]/g, "<br/>");
			myString = myString.replace(/\s/g, "&nbsp;");
			myString = myString.replace(/'/g, "''");
			myString = myString.replace(/&/g,"~");
			url=url+"&remarks="+myString;
			
			url=url+"&salesrep="+document.getElementById('salesrep').value;
			url=url+"&amount="+document.getElementById('amount').value;
// 			url=url+"&brand="+document.getElementById('brand').value;
			url=url+"&department="+document.getElementById('department').value;
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&inv_date="+document.getElementById('inv_date').value;
			url=url+"&invamount="+document.getElementById('invamount').value;
// 			url=url+"&invbal="+document.getElementById('invbal').value;
// 			url=url+"&settled="+document.getElementById('settled').value;
			url=url+"&crndate="+document.getElementById('crndate').value;
// 			url=url+"&txtrno="+document.getElementById('txtrno').value;
// 			url=url+"&txt_frmno="+document.getElementById('orderno1').value;
		
		 
			
			xmlHttp.onreadystatechange=result_save_crn;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	 
		 
}

function result_save_crn()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
	  
	 
		alert(xmlHttp.responseText);
		print_inv();
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
	
		if (xmlHttp.responseText=="Saved"){
		
			location.reload(true);
		}
	   
		//document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function delete_crn()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
	        if (document.getElementById('crnno').value == "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Please Select Credit Note</span></div>";
                return false;
            }
            if (document.getElementById('amount').value == "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Please Select Credit Note</span></div>";
                return false;
            }
			var paymethod;
			
			var url="creditnote_data.php";			
			url=url+"?Command="+"delete_crn";
			url=url+"&crnno="+document.getElementById('crnno').value;
			url=url+"&amount="+document.getElementById('amount').value;
			
			xmlHttp.onreadystatechange=delete_delete_crn;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);

		}

function delete_delete_crn()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg_cancel");	
		alert(XMLAddress1[0].childNodes[0].nodeValue);
		location.reload();
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
	}	
}
function new_inv()
{   
	
			//alert("ok");
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			document.getElementById('crnno').value="";
			document.getElementById('cus_code').value="";
			document.getElementById('cus_name').value=""; 
			document.getElementById('remarks').value="";
			document.getElementById('amount').value="";
			document.getElementById('invno').value="";
			document.getElementById('crnno').value=""; 
			document.getElementById('inv_date').value="";
			document.getElementById('invamount').value=""; 
			document.getElementById('invbal').value=""; 
			document.getElementById('salesrep').value="01"; 
			document.getElementById('department').value="01";
			 document.getElementById('msg_box').innerHTML = "";
			
			var url="creditnote_data.php";			
			url=url+"?Command="+"new_crn";
		 
			xmlHttp.onreadystatechange=assign_new_crn;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_new_crn(){
	
	
var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
			
	//alert(xmlHttp.responseText);		
	//location.reload(true);
	
	  if (xmlHttp.responseText=="no"){
		alert("Please Login Again !!!");	
	  } else {
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("crn");	
		document.getElementById('crnno').value = XMLAddress1[0].childNodes[0].nodeValue;
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_date");	
		document.getElementById('crndate').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		//document.getElementById('crnno').value=xmlHttp.responseText;	

		document.getElementById('searchcust').focus();
	  }
	}
	
}


 
   
function crnno(crno)
{
	//alert("ok");
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="creditnote_data.php";			
	url=url+"?Command="+"pass_crnno";
	url=url+"&crnno="+crno;
 
	
	xmlHttp.onreadystatechange=result_pass_crnno;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function result_pass_crnno()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_REFNO");	
		opener.document.getElementById('crnno').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_DATE");	
		opener.document.getElementById('crndate').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CODE");	
		opener.document.getElementById('cus_code').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");	
		opener.document.getElementById('cus_name').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_INVNO");	
		opener.document.getElementById('invno').value = XMLAddress1[0].childNodes[0].nodeValue;
		 
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_REMARK");	
		text = XMLAddress1[0].childNodes[0].nodeValue;
		myString = text.replace(/<br\s*\/?>/mg,"\n");
	opener.document.getElementById('remarks').value = myString;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_PAYMENT");	
		opener.document.getElementById('amount').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_SALEX");	
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
		
	 
		
// 		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEP");	
// 		var objSalesrep = opener.document.getElementById("department");
		
// 		var salesrep=XMLAddress1[0].childNodes[0].nodeValue;
// 		var i=0;
// 		while (i<objSalesrep.length)
// 		{
// 			if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
// 			{
// 				objSalesrep.options[i].selected=true;
				
// 			}
// 			i=i+1;
// 		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invdate");	
		opener.document.getElementById('inv_date').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_amt");	
		opener.document.getElementById('invamount').value = XMLAddress1[0].childNodes[0].nodeValue;
		 
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("balance");	
		opener.document.getElementById('invbal').value = XMLAddress1[0].childNodes[0].nodeValue;
		
	 
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cancel");	
		if ((XMLAddress1[0].childNodes[0].nodeValue)=="1"){
			window.opener.document.getElementById('msg_box').innerHTML = "CANCELED";
			//window.opener.document.getElementById('cmdprint').disabled = true;
			
		} else {
			window.opener.document.getElementById('msg_box').innerHTML ="";	
		}		
                
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
    var url = 'creditnote_data.php';
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

        opener.document.getElementById('cus_code').value = obj.CODE;  
        opener.document.getElementById('cus_name').value = obj.NAME;    

        self.close();
    }

}
 