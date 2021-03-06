

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

	


function chkuser() {
	//alert("ok");
	if(document.getElementById('userid').value=="")
	{
		document.getElementById("userid").focus();
		document.getElementById("txterror").innerHTML="Please Enter UserName";
		 
	}
	else if(document.getElementById('psw').value=="")
	{
		document.getElementById("psw").focus();
		document.getElementById("txterror").innerHTML="Please Enter Password ";
	}
	else
	{
		document.getElementById("txterror").innerHTML="";
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
	
		var url="login_data.php";		
		url=url+"?Command="+"logindata";	
		url=url+"&userid="+document.getElementById('userid').value;	
		url=url+"&psw="+document.getElementById('psw').value;
	
		
		xmlHttp.onreadystatechange=chk_userresult;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	}
}

function chk_userresult()
{
	
	var XMLAddress1;
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
			//alert(xmlHttp.responseText);
		 if(xmlHttp.responseText == 1)
			{
				location.href="index_org.php";
			//	location.href="house_details.php";
				//alert("ok");
			}				
			else 
			{
				document.getElementById("txterror").innerHTML="Invalied UserName or Password";
			}
	}
}


