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

function select_permission()
{   
			//alert(suppno);
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			
			var url="assign_privilages_data.php";			
			url=url+"?Command="+"select_permission";
			url=url+"&user_name="+document.getElementById("user_name").value;
		
			//url=url+"&brand="+opener.document.form1.brand.value;
			//url=url+"&salesrep="+opener.document.form1.salesrep.value;
			xmlHttp.onreadystatechange=passsuppresult_select_permission;
			
			
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}

function passsuppresult_select_permission()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
				
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("balance_table");	
		document.getElementById('privi_table').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
		document.getElementById('mcount').value= XMLAddress1[0].childNodes[0].nodeValue;
		
	
	}
}

function save_inv1()
{
			
	if (document.getElementById("pass1").value!=document.getElementById("pass2").value){	
		alert("Please Confirm Password");
		document.getElementById("pass2").value="";
		document.getElementById("pass2").focus();
	} else {
		
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			
			var url="create_user_data.php";			
			url=url+"?Command="+"save_inv";
			url=url+"&user_name="+document.getElementById("user_name").value;
			url=url+"&user_level="+document.getElementById("user_level").value;
			url=url+"&division="+document.getElementById("division").value;
			url=url+"&pass1="+document.getElementById("pass1").value;
			
			//url=url+"&brand="+opener.document.form1.brand.value;
			//url=url+"&salesrep="+opener.document.form1.salesrep.value;
			xmlHttp.onreadystatechange=passsuppresult_save_inv;
			
			
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
			
	}
		
}

function passsuppresult_save_inv()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		setTimeout("location.reload(true);",500);
		//document.getElementById("privi_table").innerHTML=xmlHttp.responseText;
		
	
		
	}
}