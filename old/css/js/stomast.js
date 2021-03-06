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









function save_sto()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
	
			var url="stomast_data.php";			
			url=url+"?Command="+"save_sto";
			url=url+"&store_code="+document.getElementById('store_code').value;
			url=url+"&storename="+document.getElementById('storename').value;
			url=url+"&act="+document.getElementById('chk').checked;
			
			xmlHttp.onreadystatechange=save_storesult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
		
}

function save_storesult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
			/*document.getElementById('bank_table').innerHTML=xmlHttp.responseText;
			document.getElementById('bcode').value="";
			document.getElementById('bbcode').value="";
			document.getElementById('bname').value="";
			document.getElementById('shname').value="";*/
			alert("Saved");
			location.reload(true);
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
		//document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	}
}




function stono(code, desc, act)
{   
	
			document.getElementById('store_code').value =code;
			document.getElementById('storename').value =desc;
			
			if (act=="1"){
				document.getElementById('chk').checked =true;	
			} else {
				document.getElementById('chk').checked =false;		
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

function delete_sto()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
		
	
			var url="stomast_data.php";			
			url=url+"?Command="+"delete_sto";
			url=url+"&store_code="+document.getElementById('store_code').value;
		
			
			
			
		
			
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
		document.getElementById('store_code').value ='';
		document.getElementById('storename').value ='';

		alert("Deleted");
		
	}
	
}







function new_item(maxcode)
{
		document.getElementById('store_code').value =maxcode;
		document.getElementById('storename').value ='';
	
}



