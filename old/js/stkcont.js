//Do not change ---------------------------------
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

//---- Inquire Purchase Note by purchase note no --------------------------

function Check_purch_no(butcomand)
{
	
	if(document.getElementById('txnno').value=="" )
		{	
			//alert("ok");		
			document.getElementById("txterror1").innerHTML="Please Enter Ref No";
				document.getElementById('txnno').value="";
				document.getElementById("txndate").value="";
				document.getElementById("supno").value="";
				document.getElementById("supname").value="";
				document.getElementById("itemno").value="";
				document.getElementById("uprice").value="";
				document.getElementById("qty").value="";
				document.getElementById("valu").value="";
				document.getElementById("tbl").innerHTML="";
			document.getElementById("txnno").focus();
			return false;
		}
		else
		{
			
			document.getElementById("txterror1").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="purchase.php";
			
			url=url+"?Command="+butcomand;
			url=url+"&purno="+document.getElementById('txnno').value;
				  
		 // 	alert(url);
		//	alert(xmlHttp.responseText);		
			xmlHttp.onreadystatechange=change_purchaseno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
}






function change_purchaseno() 
	{ 
	
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	//alert("stateChanged ok");
			// alert(xmlHttp.responseText);
			// document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
			// setTimeout("location.reload(true);",1000);
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msgtxt");				
			var msgtxt = XMLAddress1[0].childNodes[0].nodeValue;
			
			if(msgtxt=="Invalied Number")
			{
				document.getElementById("txterror1").innerHTML="Invalied Number";
				
				document.getElementById('txnno').value="";
				document.getElementById("txndate").value="";
				document.getElementById("supno").value="";
				document.getElementById("supname").value="";
				document.getElementById("itemno").value="";
				document.getElementById("uprice").value="";
				document.getElementById("valu").value="";
				document.getElementById("tbl").innerHTML="";
				
			}
			else
			{
				
				//document.getElementById("txterror1").innerHTML="";
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("purdate");				
				document.getElementById('txndate').value = XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("supno");				
				document.getElementById('supno').value = XMLAddress1[0].childNodes[0].nodeValue;
							
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("supname");				
				document.getElementById('supnamecmb').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("itemtbl");				
				document.getElementById('tbl').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;	
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamount");				
				document.getElementById('totamount').value = XMLAddress1[0].childNodes[0].nodeValue;	
			
			//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Date_of_Enlist");				
			//	document.getElementById('tbl').value = XMLAddress1[0].childNodes[0].nodeValue;
								
			}
	
			//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REFNO");				
			//document.getElementById('Reference_No').value = XMLAddress1[0].childNodes[0].nodeValue;			
			document.getElementById('Reference_No').value ="Check Ref NO";
		 } 
	}
	

//--------------- Select Supplier in purchase note ----------------
function selectsupp()
{
	
	if(document.getElementById('txnno').value=="" )
		{	
			//alert("ok");		
			document.getElementById("txterror1").innerHTML="Please Enter Ref No";
				document.getElementById('txnno').value="";
				document.getElementById("txndate").value="";
				document.getElementById("supno").value="";
				document.getElementById("supname").value="";
				document.getElementById("itemno").value="";
				document.getElementById("uprice").value="";
				document.getElementById("valu").value="";
				document.getElementById("tbl").innerHTML="";
			document.getElementById("txnno").focus();
			return false;
		}
		else
		{
			
			document.getElementById("txterror1").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			document.getElementById('supno').value=document.getElementById('supname').value;
			
			
		}
}

//--------------- Select Item in purchase note ----------------
function selectitem()
{
	
	if(document.getElementById('txnno').value=="" )
		{	
			//alert("ok");		
			document.getElementById("txterror1").innerHTML="Please Enter Ref No";
			
			document.getElementById('txnno').value="";
			document.getElementById("txndate").value="";
			document.getElementById("supno").value="";
			document.getElementById("supname").value="";
			document.getElementById("itemno").value="";
			document.getElementById("uprice").value="";
			document.getElementById("valu").value="";
			document.getElementById("tbl").innerHTML="";
			document.getElementById("txnno").focus();
			
			return false;
		}
		else
		{
			
			document.getElementById("txterror1").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			document.getElementById('itemno').value=document.getElementById('itemname').value;
			
			
		}
}


//---- Add Items in to  purchase note  --------------------------

function add_item(butcomand)
{	
	//alert("ok");
	
	if((document.getElementById('txnno').value=="" )&&(document.getElementById('itemno').value=="" ))
		{	
			//alert("ok");		
			document.getElementById("txterror1").innerHTML="Please Enter Ref No ";
				document.getElementById('txnno').value="";
				document.getElementById("txndate").value="";
				document.getElementById("supno").value="";
				document.getElementById("supname").value="";
				document.getElementById("itemno").value="";
				document.getElementById("uprice").value="";
				document.getElementById("valu").value="";
				document.getElementById("tbl").innerHTML="";
			document.getElementById("txnno").focus();
			return false;
		}
		else
		{
			
			document.getElementById("txterror1").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="purchase.php";
			
			url=url+"?Command="+butcomand;
			url=url+"&purno="+document.getElementById('txnno').value;
			url=url+"&itemno="+document.getElementById('itemno').value;
			url=url+"&uprice="+document.getElementById('uprice').value;
			url=url+"&qty="+document.getElementById('qty').value;
			url=url+"&valu="+document.getElementById('valu').value;
							  
		 // 	alert(url);
		//	alert(xmlHttp.responseText);		
			xmlHttp.onreadystatechange=change_itemdata;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
}






function change_itemdata() 
	{ 
	
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	//alert("stateChanged ok");
			 alert(xmlHttp.responseText);
			// document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
			// setTimeout("location.reload(true);",1000);
					
			
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("itemtbl");				
				document.getElementById('tbl').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;	
			    
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totamount");				
				document.getElementById('totamount').value = XMLAddress1[0].childNodes[0].nodeValue;	
			
				document.getElementById("itemno").value="";
				document.getElementById("uprice").value="";
				document.getElementById("qty").value="";
				document.getElementById("valu").value="";
				
		
		 } 
	}

//---- Save purchase note  --------------------------

function save_purch(butcomand)
{
	
	if((document.getElementById('txnno').value=="" )&&(document.getElementById('itemno').value=="" ))
		{	
					
			document.getElementById("txterror1").innerHTML="Please Enter Ref No ";
				document.getElementById('txnno').value="";
				document.getElementById("txndate").value="";
				document.getElementById("supno").value="";
				document.getElementById("supname").value="";
				document.getElementById("itemno").value="";
				document.getElementById("uprice").value="";
				document.getElementById("valu").value="";
				document.getElementById("tbl").innerHTML="";
			document.getElementById("txnno").focus();
			return false;
		}
		else
		{
			
			document.getElementById("txterror1").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="purchase.php";
			
			url=url+"?Command="+butcomand;
			url=url+"&purno="+document.getElementById('txnno').value;
			url=url+"&txndate="+document.getElementById('txndate').value;
			
			url=url+"&supno="+document.getElementById('supno').value;
			
			url=url+"&nettot="+document.getElementById('totamount').value;
	
							  
		 //	alert(url);
		//	alert(xmlHttp.responseText);		
			xmlHttp.onreadystatechange=save_puritem;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
}






function save_puritem() 
	{ 
	
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	//alert("stateChanged ok");
			 alert(xmlHttp.responseText);
			document.getElementById('txnno').value="";
				document.getElementById("txndate").value="";
				document.getElementById("supno").value="";
				document.getElementById("supname").value="";
				document.getElementById("itemno").value="";
				document.getElementById("uprice").value="";
				document.getElementById("valu").value="";
				document.getElementById("tbl").innerHTML="";
			document.getElementById("txnno").focus();
			return false;
				
		
		 } 
	}


//--------------- Calculate Value in purchase note ----------------
function cal_pri()
{
	
		alert("ok");
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			document.getElementById('valu').value=document.getElementById('uprice').value * document.getElementById('qty').value;
	
}


////////////////////////////////////////////////////////////Stock - 1///////////////////////////////////////////////////////////////////////////
//--------------- Select Item in Stock - 1 ----------------
function selectitemstk1()
{
	
	if(document.getElementById('txndate').value=="" )
		{	
			//alert("ok");		
			document.getElementById("txterror1").innerHTML="Please Enter Date";
						
			document.getElementById("itemno").value="";
			document.getElementById("qty").value="";
			document.getElementById("tbl").innerHTML="";
			document.getElementById("txndate").focus();
			
			return false;
		}
		else
		{
			
			document.getElementById("txterror1").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			document.getElementById('itemno').value=document.getElementById('itemname').value;
			
			
		}
}


//---- Add Items in to  Stock1  --------------------------

function add_item_stk1(butcomand)
{	
	//alert("ok");
	
	if(document.getElementById('txndate').value=="" )
		{	
			//alert("ok");		
			document.getElementById("txterror1").innerHTML="Please Enter Date ";
				
			document.getElementById("txndate").focus();
			return false;
		}
		else
		{
			
			document.getElementById("txterror1").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="sql_stktrans1.php";
			
			url=url+"?Command="+butcomand;
			url=url+"&txndate="+document.getElementById('txndate').value;
			url=url+"&itemno="+document.getElementById('itemno').value;
			url=url+"&qty="+document.getElementById('qty').value;
										  
		 // 	alert(url);
		//	alert(xmlHttp.responseText);		
			xmlHttp.onreadystatechange=change_itemdatastk1;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
}






function change_itemdatastk1() 
	{ 
	
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	//alert("stateChanged ok");
			 alert(xmlHttp.responseText);
			// document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
			// setTimeout("location.reload(true);",1000);
					
			
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("itemtbl");				
				document.getElementById('tbl').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;	
			    
							
				document.getElementById("itemno").value="";
				document.getElementById("qty").value="";
							
		
		 } 
	}



//---- Save Stock - 1  --------------------------

function save_stock1(butcomand)
{
	
	if(document.getElementById('txndate').value=="" )
		{	
					
			document.getElementById("txterror1").innerHTML="Please Enter Date ";
				document.getElementById("txndate").value="";
				document.getElementById("itemno").value="";
				document.getElementById("qty").value="";
				document.getElementById("txndate").focus();
			return false;
		}
		else
		{
			
			document.getElementById("txterror1").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="sql_stktrans1.php";
			
			url=url+"?Command="+butcomand;
		
			url=url+"&txndate="+document.getElementById('txndate').value;
		
							  
		 //	alert(url);
		//	alert(xmlHttp.responseText);		
			xmlHttp.onreadystatechange=save_itemstock1;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
}






function save_itemstock1() 
	{ 
	
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	//alert("stateChanged ok");
			 alert(xmlHttp.responseText);
			document.getElementById('txnno').value="";
				document.getElementById("txndate").value="";
				document.getElementById("supno").value="";
				document.getElementById("supname").value="";
				document.getElementById("itemno").value="";
				document.getElementById("uprice").value="";
				document.getElementById("valu").value="";
				document.getElementById("tbl").innerHTML="";
			document.getElementById("txnno").focus();
			return false;
				
		
		 } 
	}

////////////////////////////////////////////////////////////Stock - 2///////////////////////////////////////////////////////////////////////////
//--------------- Select Item in Stock - 2 ----------------
function selectitemstk2()
{
	
	if(document.getElementById('txndate').value=="" )
		{	
			//alert("ok");		
			document.getElementById("txterror1").innerHTML="Please Enter Date";
						
			document.getElementById("itemno").value="";
			document.getElementById("qty").value="";
			document.getElementById("tbl").innerHTML="";
			document.getElementById("txndate").focus();
			
			return false;
		}
		else
		{
			
			document.getElementById("txterror1").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			document.getElementById('itemno').value=document.getElementById('itemname').value;
			
			
		}
}


//---- Add Items in to  Stock 2  --------------------------

function add_item_stk2(butcomand)
{	
	//alert("ok");
	
	if(document.getElementById('txndate').value=="" )
		{	
			//alert("ok");		
			document.getElementById("txterror1").innerHTML="Please Enter Date ";
				
			document.getElementById("txndate").focus();
			return false;
		}
		else
		{
			
			document.getElementById("txterror1").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="sql_stktrans2.php";
			
			url=url+"?Command="+butcomand;
			url=url+"&txndate="+document.getElementById('txndate').value;
			url=url+"&itemno="+document.getElementById('itemno').value;
			url=url+"&qty="+document.getElementById('qty').value;
										  
		 // 	alert(url);
		//	alert(xmlHttp.responseText);		
			xmlHttp.onreadystatechange=change_itemdatastk2;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
}






function change_itemdatastk2() 
	{ 
	
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	//alert("stateChanged ok");
			 alert(xmlHttp.responseText);
			// document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
			// setTimeout("location.reload(true);",1000);
					
			
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("itemtbl");				
				document.getElementById('tbl').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;	
			    
							
				document.getElementById("itemno").value="";
				document.getElementById("qty").value="";
							
		
		 } 
	}



//---- Save Stock - 2  --------------------------

function save_stock2(butcomand)
{
	
	if(document.getElementById('txndate').value=="" )
		{	
					
			document.getElementById("txterror1").innerHTML="Please Enter Date ";
				document.getElementById("txndate").value="";
				document.getElementById("itemno").value="";
				document.getElementById("qty").value="";
				document.getElementById("txndate").focus();
			return false;
		}
		else
		{
			
			document.getElementById("txterror1").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="sql_stktrans2.php";
			
			url=url+"?Command="+butcomand;
		
			url=url+"&txndate="+document.getElementById('txndate').value;
		
							  
		 //	alert(url);
		//	alert(xmlHttp.responseText);		
			xmlHttp.onreadystatechange=save_itemstock2;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
}






function save_itemstock2() 
	{ 
	
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 	//alert("stateChanged ok");
			 alert(xmlHttp.responseText);
			document.getElementById('txnno').value="";
				document.getElementById("txndate").value="";
				document.getElementById("supno").value="";
				document.getElementById("supname").value="";
				document.getElementById("itemno").value="";
				document.getElementById("uprice").value="";
				document.getElementById("valu").value="";
				document.getElementById("tbl").innerHTML="";
			document.getElementById("txnno").focus();
			return false;
				
		
		 } 
	}
