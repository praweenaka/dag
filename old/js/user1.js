
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


// codes for log on button

function IsValiedData()
{
	//alert("ok");
	
	if(document.getElementById('txtUserName').value=="" )
	{
		//alert("Please Enter UserName");	
		document.getElementById("txtUserName").focus();
		document.getElementById("txterror").innerHTML="Please Enter User Name";
		return false;
	}
	else if(document.getElementById('txtPassword').value=="" )
	{
		
		document.getElementById("txterror").innerHTML="Please Enter Password";
		//alert("Please Enter Password");	
		document.getElementById("txtPassword").focus();
		return false;
	}
	else
	{
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="CheckUsers.php";
			
			url=url+"?Command="+"CheckUsers";
			url=url+"&UserName="+document.getElementById('txtUserName').value;
			url=url+"&Password="+document.getElementById('txtPassword').value;
			//alert(url);
			xmlHttp.onreadystatechange=CheckUsers;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
		
	}
	
}

function setdiv()
{
		xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="CheckUsers.php";
			
			url=url+"?Command="+"setdiv";
			url=url+"&activ="+document.getElementById('activ').checked;
			//url=url+"&Password="+document.getElementById('txtPassword').value;
			
			xmlHttp.onreadystatechange=logout_state_setdiv;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
}

// logon button stateChanged
function CheckUsers()

{	//alert("ok");
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	//alert(xmlHttp.responseText);
			if (xmlHttp.responseText=="Invalied Connection"){
				alert(xmlHttp.responseText);
			}
			var val=xmlHttp.responseText;	
			//alert (val);
			if(val=="ok"){
				location.href="http://web/ben/home.php";	
			}
			else
			{
			//alert(xmlHttp.responseText);
			 document.getElementById("txterror").innerHTML="Invalied UserName or Password";
		 	}
		}
}


function keyset(key, e)
{	

   if((e.keyCode==13) || (e.keyCode==40)){
	document.getElementById(key).focus();
   }
}

// function for log out
function logout()
{
		//alert("ok");
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="CheckUsers.php";
			
			url=url+"?Command="+"logout";
			
			xmlHttp.onreadystatechange=logout_state_Changed;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
		
}


function logout_state_setdiv()
{	
	var XMLAddress1;
	
	alert(xmlHttp.responseText);

		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	
				alert("Changed");
				
		 }
		 
}

function logout_state_Changed()
{	
	var XMLAddress1;
	
	//alert(xmlHttp.responseText);

		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	
				location.href="index.php";
				
		 }
		 
}



//////////////////////////////////////////////////////////////////////////////////////////////

function newuser()
{
		//alert("ok");
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			
			
			location.href="logon_users.php";
		
}









