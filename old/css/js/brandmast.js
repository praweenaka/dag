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

function close_form()
{
	self.close();	
}

function setbrand()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			}
			
			var url="brandmast_data.php";			
			url=url+"?Command="+"setbrand";
			url=url+"&barnd_name="+document.getElementById('barnd_name').value;

			//alert(url);
					
			xmlHttp.onreadystatechange=setbrandresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);		
}

function setbrandresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("class");	
		//alert(XMLAddress1[0].childNodes[0].nodeValue);
		//document.getElementById('class').value = XMLAddress1[0].childNodes[0].nodeValue;
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("class");	
			document.getElementById('class').value = XMLAddress1[0].childNodes[0].nodeValue;		
			
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("act");
		if (XMLAddress1[0].childNodes[0].nodeValue=="1"){
			document.getElementById('act').checked = true;
		} else {
			document.getElementById('act').checked = false;	
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("delinrate");	
		document.getElementById('cmbtargettype').value = XMLAddress1[0].childNodes[0].nodeValue;
		
	
		
	}
}

function update_brand_list()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="brandmast_data.php";			
			url=url+"?Command="+"search_brand";
			url=url+"&barnd_name="+document.getElementById('barnd_name').value;

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
		
	
			var url="brandmast_data.php";			
			url=url+"?Command="+"save_bank";
			url=url+"&barnd_name="+document.getElementById('barnd_name').value;
			url=url+"&class="+document.getElementById('class').value;
			url=url+"&act="+document.getElementById('act').checked;
			url=url+"&cmbtargettype="+document.getElementById('cmbtargettype').value;
			
			//alert(url);
			
		
			
			xmlHttp.onreadystatechange=salessaveresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
}



function salessaveresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		document.getElementById('bank_table').innerHTML=xmlHttp.responseText;
		document.getElementById('barnd_name').value="";
		document.getElementById('class').value="";
		document.getElementById('act').checked=false;
		//document.getElementById('cmbtargettype').value="";
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		//document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}




function bankno(barnd_name, mclass, mact, delinrate)
{   
	
			document.getElementById('barnd_name').value =barnd_name;
			document.getElementById('class').value =mclass;
			
			if (mact==0){
				
				document.getElementById('act').checked==false
			} else if (mact==1){
				
				document.getElementById('act').checked =true;
			}
			
			var objSalesrep = document.getElementById("cmbtargettype");
			if (delinrate==0){
				objSalesrep.options[0].selected=true;
			} else if (delinrate==2.5){
				objSalesrep.options[1].selected=true;
			} else if (delinrate==3.5){
				objSalesrep.options[2].selected=true;
			}
		
			
		/*	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_ord_data.php";			
			url=url+"?Command="+"pass_invno";
			url=url+"&invno="+invno;
			url=url+"&stname="+stname;
			//alert(url);
					
			xmlHttp.onreadystatechange=passinvresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);*/
			
			
		
	
}

function delete_bank()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
	
			var url="brandmast_data.php";			
			url=url+"?Command="+"delete_bank";
			url=url+"&barnd_name="+document.getElementById('barnd_name').value;
		
			
			
			
		
			
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
		document.getElementById('barnd_name').value ='';
		document.getElementById('class').value ='';
		document.getElementById('act').check =false;
		document.getElementById('cmbtargettype').value ='';
		alert("Deleted");
		
	}
	
}







function new_item()
{
		document.getElementById('barnd_name').value ='';
		document.getElementById('class').value ='';
		document.getElementById('act').check =false;
		document.getElementById('cmbtargettype').value ='';
}



