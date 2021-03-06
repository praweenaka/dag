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


function login_users()
{
	
	if(document.getElementById('txtUserName').value=="")
	{
		document.getElementById("txtUserName").focus();
		document.getElementById("txterror").innerHTML="Please Enter UserName";
		 
	}
	else if(document.getElementById('txtPassword').value=="")
	{
		document.getElementById("txtPassword").focus();
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
			
			var url="db_createuser.php";			
			url=url+"?Command="+"create_user";
			url=url+"&username="+document.getElementById('txtUserName').value;		
			url=url+"&password="+document.getElementById('txtPassword').value;
			
			xmlHttp.onreadystatechange=getuserResults;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	}
	
}


function getuserResults()
{
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
			//alert(xmlHttp.responseText);
			
			if(xmlHttp.responseText=="True")
			{
				location.href="signup.php";
			//	location.href="house_details.php";
				//alert("ok");
			}				
			else
			{
				document.getElementById("txterror").innerHTML="Invalied UserName or Password";
			}
		
			
		}
}


function ClearForm()
	{	
		setTimeout("location.reload(true);",1000);
	}


	
