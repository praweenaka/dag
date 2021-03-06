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

function close_form()
{
	self.close();	
}

function update_bank_list(mstatus)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="bankmast_data.php";			
			url=url+"?Command="+"update_bank_list";
			url=url+"&mstatus="+mstatus;
			url=url+"&bcode="+document.getElementById('bcode').value;
			url=url+"&bbcode="+document.getElementById('bbcode').value;
			url=url+"&bname="+document.getElementById('bname').value;

			
					
			xmlHttp.onreadystatechange=show_bank_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function show_bank_result()
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
		
		document.getElementById('bank_table').innerHTML=xmlHttp.responseText;
	}
}










function save_bank()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
	
			var url="bankmast_data.php";			
			url=url+"?Command="+"save_bank";
			url=url+"&bcode="+document.getElementById('bcode').value;
			url=url+"&bbcode="+document.getElementById('bbcode').value;
			url=url+"&bname="+document.getElementById('bname').value;
			url=url+"&shname="+document.getElementById('shname').value;
			
			
			
		
			
			xmlHttp.onreadystatechange=salessaveresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
}

function salessaveresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('bank_table').innerHTML=xmlHttp.responseText;
		document.getElementById('bcode').value="";
		document.getElementById('bbcode').value="";
		document.getElementById('bname').value="";
		document.getElementById('shname').value="";
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		//document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}




function bankno(bcode, bbcode, bname, shname)
{   
	
			document.getElementById('bcode').value =bcode;
			document.getElementById('bbcode').value =bbcode;
			document.getElementById('bname').value =bname;
			document.getElementById('shname').value =shname;
}

function delete_bank()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
	
			var url="bankmast_data.php";			
			url=url+"?Command="+"delete_bank";
			url=url+"&bcode="+document.getElementById('bcode').value;
		
			xmlHttp.onreadystatechange=bankdeletresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
}

function bankdeletresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('bank_table').innerHTML=xmlHttp.responseText;
		document.getElementById('bcode').value="";
		document.getElementById('bbcode').value="";
		document.getElementById('bname').value="";
		document.getElementById('shname').value="";
		alert("Deleted");
		
	}
	
}







function new_item()
{
		document.getElementById('bcode').value ="";
		document.getElementById('bbcode').value ="";
		document.getElementById('bname').value ="";
		document.getElementById('shname').value ='';
		document.getElementById('bcode').focus();
}



