
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



// logon button stateChanged
function CheckUsers()

{	//alert("ok");
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	
			//alert(xmlHttp.responseText);
			var val=xmlHttp.responseText;	
			//alert (val);
			if(val=="Administrator")
			{
				//alert(xmlHttp.responseText);
				location.href="index.php";	
			}
			
			else if(val=="membershipofficer")
			{
				
				 //alert(xmlHttp.responseText);
				 location.href="logon_reception_officer.php";
			}
			else if(val=="ledgerofficer")
			{
				
				 //alert(xmlHttp.responseText);
				 location.href="logon_ledger_officer.php";
			}	
			
			else if(val=="Reception")
			{
				
				 //alert(xmlHttp.responseText);
				 location.href="logon_reception.php";
			}
			
			
			else if(val=="Sales")
			{
				//alert(xmlHttp.responseText);
				location.href="logon_shop_officer.php";
			}
					
			else if(val=="Ledger")
			{
				
				//alert(xmlHttp.responseText);
				location.href="deduction_monitoring.php";
			}
			
			else if(val=="Loan")
			{
				
				//alert(xmlHttp.responseText);
				location.href="logon_Loan_officer.php";
			}
			
			
					
			else if(val=="User")
			{
				location.href="logon_user.php";
			}
			
			else if(val=="Dla")
			{
				location.href="logon_shop_officer_DLA.php";
			}
			else if(val=="Kdy")
			{
				location.href="logon_shop_officer_KDY.php";
			}
			else if(val=="Anp")
			{
				location.href="logon_shop_officer_ANP.php";
			}
			else if(val=="Gla")
			{
				location.href="logon_shop_officer_GLA.php";
			}
			else if(val=="Mnr")
			{
				location.href="logon_shop_officer_MNR.php";
			}
			else if(val=="Png")
			{
				location.href="logon_shop_officer_PNG.php";
			}
			else if(val=="Tco")
			{
				location.href="logon_shop_officer_TCO.php";
			}
			else if(val=="Amp")
			{
				location.href="logon_shop_officer_AMP.php";
			}
			
			
			
			else
			{
			//alert(xmlHttp.responseText);
			 document.getElementById("txterror").innerHTML="Invalied UserName or Password";
		 }
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



function logout_state_Changed()
{	
	var XMLAddress1;
	
	//alert(xmlHttp.responseText);

		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	
				location.href="logon.php";
				
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









