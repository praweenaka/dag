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

function chk_user(stname)
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="autho_data.php";			
	url=url+"?Command="+"chk_user";
	url=url+"&txtUserName="+document.getElementById('txtUserName').value;
	url=url+"&txtPassword="+document.getElementById('txtPassword').value;
	url=url+"&stname="+stname;
	
	if (stname=='cash_crn_form'){
		url=url+"&txtrefno="+opener.document.form1.txtrefno.value;
		url=url+"&txt_cuscode="+opener.document.form1.txt_cuscode.value;
		url=url+"&mcou="+opener.document.form1.mcou.value;
	}
	
	if (stname=='cash_crn_form_autho'){
		url=url+"&txtrefno="+opener.document.form1.txtrefno.value;
		url=url+"&txt_cuscode="+opener.document.form1.txt_cuscode.value;
		url=url+"&mcou="+opener.document.form1.mcou.value;
	}
	
	if (stname=='crn_form'){
		url=url+"&txtrefno="+opener.document.form1.txtrefno.value;
		url=url+"&txt_cuscode="+opener.document.form1.txt_cuscode.value;
		url=url+"&mcou="+opener.document.form1.mcou.value;
	}
	
	if (stname=='crn_form_autho'){
		url=url+"&txtrefno="+opener.document.form1.txtrefno.value;
		url=url+"&txt_cuscode="+opener.document.form1.txt_cuscode.value;
		url=url+"&mcou="+opener.document.form1.mcou.value;
	}
	
	if (stname=='item_mast'){
		url=url+"&txtrefno="+opener.document.form1.txtrefno.value;
		url=url+"&txt_cuscode="+opener.document.form1.txt_cuscode.value;
		url=url+"&mcou="+opener.document.form1.mcou.value;
	}
	
	
	
	
	
			//alert(url);
	xmlHttp.onreadystatechange=chk_user_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function chk_user_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		self.close();
		
		if (xmlHttp.responseText=="1"){
			opener.document.form1.autho.value=xmlHttp.responseText;
			self.close();
		} else {
			opener.document.form1.autho.value=0;	
		}
		
		if ((xmlHttp.responseText=="Access Denied") || (xmlHttp.responseText=="You have No Permission")){
			alert(xmlHttp.responseText);
			
			self.close();
		} 
		
		if ((xmlHttp.responseText=="Recordes are marked as Checked") || (xmlHttp.responseText=="Recordes are marked as Locked")) {
			alert(xmlHttp.responseText);
			//window.opener.document.reload(true);
			self.close();
		} 
		
		
		
		setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
		//document.getElementById('cus_address').value= xmlHttp.responseText;
	}
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

function set_month()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="credit_note_form_data.php";			
			url=url+"?Command="+"set_month";
			url=url+"&MonthView1="+document.getElementById('MonthView1').value;
			
			alert(url);
			
			//xmlHttp.onreadystatechange=result_note_update;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
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

