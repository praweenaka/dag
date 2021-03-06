
function GetXmlHttpObject()
	{
		var xmlHttp=null;		
		var xmlHttpMap=null;
		try
		 {
			 // Firefox, Opera 8.0+, Safari
			 xmlHttp=new XMLHttpRequest();
			 xmlHttpMap=new XMLHttpRequest();
		 }
		catch (e)
		 {
			 // Internet Explorer
			 try
			  {
				  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
				  xmlHttpMap=new ActiveXObject("Msxml2.XMLHTTP");
			  }
			 catch (e)
			  {
				 xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				 xmlHttpMap=new ActiveXObject("Microsoft.XMLHTTP");
			  }
		 }
		return xmlHttp;
		return xmlHttpMap;
	}
	
	var xmlHttp3=null;
	
	function GetXmlHttpObject3()
	{
		var xmlHttp3=null;
		try
		 {
			 // Firefox, Opera 8.0+, Safari
			 xmlHttp3=new XMLHttpRequest();
		 }
		catch (e)
		 {
			 // Internet Explorer
			 try
			  {
				  xmlHttp3=new ActiveXObject("Msxml2.XMLHTTP");
			  }
			 catch (e)
			  {
				 xmlHttp3=new ActiveXObject("Microsoft.XMLHTTP");
			  }
		 }
		return xmlHttp3;
	}
	

	
function print_Details()
{
	
	document.getElementById("print_firstname_details").innerHTML="";
	document.getElementById("print_data").innerHTML="";
	document.getElementById("error_nic").innerHTML="";
	
		//Check NIC 
	if(document.getElementById('nic').value=="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value=="" & document.getElementById('location').value=="" & document.getElementById('Suburb').value=="")
	{
		document.getElementById("print_chief_house_details123").innerHTML="";
		document.getElementById("showgoogleoption").innerHTML="";
		document.getElementById("error_nic").innerHTML="Please Enter NIC Number | First Name Or Last Name";
		return false;
	}
	
	else if(document.getElementById('nic').value!="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value=="" & document.getElementById('location').value=="" & document.getElementById('Suburb').value=="")
	 {
		 if(document.getElementById('nic').value=="")
		{
			document.getElementById("nic").focus();
			document.getElementById("error_nic").innerHTML="Please Enter NIC Number";
			return false;
		}	
		else if(!isvaliedNIC(document.getElementById("nic").value))
		{
			document.getElementById("nic").focus();
			document.getElementById("error_nic").innerHTML="Please Enter NIC Number";
			return false;
		}
			
		//Else Part
		else
		{
			document.getElementById('img_jobs').style.visibility='visible';	
			document.getElementById('img_visit').style.visibility='visible';
			document.getElementById('showgoogleoption').style.visibility='visible';
			document.getElementById('img_insertdata').style.visibility='visible';
			
			document.getElementById("error_nic").innerHTML="";
			document.getElementById("print_data").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
					
			var url="personal_details.php";		
			url=url+"?Command="+"read_personal_data_nic";		
			url=url+"&nic="+document.getElementById('nic').value;
				
				
			xmlHttp.onreadystatechange=search_result_details;			
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);

	
		}
	 }
	 
	 
	 //////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 
	 
	 	//CHECK FIRST NAME
	
	else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value!="" & document.getElementById('lastname').value=="" & document.getElementById('location').value=="" & document.getElementById('Suburb').value=="")
	{
			
		document.getElementById("print_data").innerHTML="";
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";		
		document.getElementById('showgoogleoption').style.visibility='visible';
				
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="filter_first_name.php";		
		url=url+"?Command="+"filter_first_name";		
		url=url+"&firstname="+document.getElementById('firstname').value;
		//alert(url);
			
		xmlHttp.onreadystatechange=search_result_firstname;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	//CHECK OTHER NAME
	else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value!="" & document.getElementById('location').value=="" & document.getElementById('Suburb').value=="")
	{
	//	alert("ok");
		document.getElementById("print_data").innerHTML="";
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";		
		document.getElementById('showgoogleoption').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="other_name.php";		
		url=url+"?Command="+"filter_other_name";		
		url=url+"&lastname="+document.getElementById('lastname').value;
		//alert(url);
			
		xmlHttp.onreadystatechange=search_result_firstname;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	
	}
	
	
	//  LOCATION FILTERING PART //////////////////////////////////////////////////////////////////////////////
else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value=="" & document.getElementById('location').value!="" & document.getElementById('Suburb').value=="")
	{
		
		document.getElementById("print_data").innerHTML="";
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";		
		document.getElementById('showgoogleoption').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="location.php";		
		url=url+"?Command="+"filter_location_wise";		
		url=url+"&location="+document.getElementById('location').value;
		//alert(url);
			
		xmlHttp.onreadystatechange=search_result_firstname;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	
	}
//////////////////////////////// END LOCATION FILTERING PART /////////////////////////////////////////////////////////////////////////

//////////////////////SUBURB FILTERING PART //////////////////////////////////////////////////////////////////////////////
else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value=="" & document.getElementById('location').value=="" & document.getElementById('Suburb').value!="")
	{
		document.getElementById("print_data").innerHTML="";
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";		
		document.getElementById('showgoogleoption').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="suburb.php";		
		url=url+"?Command="+"filter_suburb_wise";		
		url=url+"&Suburb="+document.getElementById('Suburb').value;
		//alert(url);
			
		xmlHttp.onreadystatechange=search_result_firstname;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////END
	
	////////////////////// FIRST NAME AND LOCATION FILTERING PART //////////////////////////////////////////////////////////////////////////////
else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value!="" & document.getElementById('lastname').value=="" & document.getElementById('location').value!="" & document.getElementById('Suburb').value=="")
	{
		document.getElementById("print_data").innerHTML="";
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";		
		document.getElementById('showgoogleoption').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="filter_firstname_location.php";		
		url=url+"?Command="+"filter_firstname_location";		
		url=url+"&firstname="+document.getElementById('firstname').value;
		url=url+"&location="+document.getElementById('location').value;
	//	alert(url);
			
		xmlHttp.onreadystatechange=search_result_firstname;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	
	}
//////////////////////////////// END FIRST NAME AND LOCATION FILTERING PART /////////////////////////////////////////////////////////////////////////

	
	
	
}


function search_result_details()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		//alert(xmlHttp.responseText);
		
		
		
		if(xmlHttp.responseText=="Invalied NIC Number")
		{			
			document.getElementById("print_data").innerHTML=xmlHttp.responseText;
		}
		else
		{
			document.getElementById("print_data").innerHTML=xmlHttp.responseText;
			get_lat_and_long_val();
		}
	
		
	}
}


	
	

function IsValiedNICS()
{
	
	//CLEAR MESSAGES AND PRINTED TABLE
	
	document.getElementById("print_chief_house_details123").innerHTML="";
	document.getElementById("print_firstname_details").innerHTML="";
	document.getElementById("pesonaldetails").innerHTML="";
	document.getElementById("printChiefhouse").innerHTML="";
	document.getElementById("printothertable").innerHTML="";	
	document.getElementById("printimage").innerHTML="";


	
	/////////////////////////// OPEN NIC Check Part ///////////////////////////////////////////////////////////////////////////
	
	//Check NIC First Name & Last Name
	if(document.getElementById('nic').value=="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value=="" & document.getElementById('location').value=="" & document.getElementById('Suburb').value=="")
	{
		document.getElementById("print_chief_house_details123").innerHTML="";
		document.getElementById("showgoogleoption").innerHTML="";
		document.getElementById("error_nic").innerHTML="Please Enter NIC Number | First Name Or Last Name";
		return false;
	}
	
	//Check NIC is Not Equall Null And Others are Equall Null
	else if(document.getElementById('nic').value!="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value=="" & document.getElementById('location').value=="" & document.getElementById('Suburb').value=="")
	{
		if(document.getElementById('nic').value=="")
		{
			document.getElementById("nic").focus();
			document.getElementById("error_nic").innerHTML="Please Enter NIC Number";
			return false;
		}	
		else if(!isvaliedNIC(document.getElementById("nic").value))
		{
			document.getElementById("nic").focus();
			document.getElementById("error_nic").innerHTML="Please Enter NIC Number";
			return false;
		}
			
		//Else Part
		else
		{
			document.getElementById('img_jobs').style.visibility='visible';	
			document.getElementById('img_visit').style.visibility='visible';
			document.getElementById('showgoogleoption').style.visibility='visible';
			document.getElementById('img_insertdata').style.visibility='visible';
			document.getElementById("error_nic").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
					
			var url="personal_details.php";		
			url=url+"?Command="+"read_personal_data_nic";		
			url=url+"&nic="+document.getElementById('nic').value;
				
				
			xmlHttp.onreadystatechange=search_result_mapref;			
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
				
	//		latitude=7.090256547096815;
	//		longitude=79.99964747084724;;
	//		inittest();
			//	inittest();
	
		}
		
		
	}
	
	
	////////////////////////////////////////////////////////// END NIC Check Part /////////////////////////////////////////////////////
	
	
	//STRAT NIC AND FIRST NAME CHECK PART
	
	else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value!="" & document.getElementById('lastname').value=="" & document.getElementById('location').value=="" & document.getElementById('Suburb').value=="")
	{
		//alert("ok");
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";
		document.getElementById("pesonaldetails").innerHTML="";
		document.getElementById("printChiefhouse").innerHTML="";
		document.getElementById("printothertable").innerHTML="";
		document.getElementById("print_chief_house_details123").innerHTML="";
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('showgoogleoption').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="read_data.php";		
		url=url+"?Command="+"filter_first_name";		
		url=url+"&firstname="+document.getElementById('firstname').value;
		//alert(url);
			
		xmlHttp.onreadystatechange=search_result_firstname;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
		
	}
//////END NIC AND FIRST NAME CHECK PART//////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////// STARTING LASTNAME FILTERING PART ////////////////////////////////////////////////////////////////////////////////////
else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value!="" & document.getElementById('location').value=="" & document.getElementById('Suburb').value=="")
	{
	//	alert("ok");
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";
		document.getElementById("pesonaldetails").innerHTML="";
		document.getElementById("printChiefhouse").innerHTML="";
		document.getElementById("printothertable").innerHTML="";
		document.getElementById("print_chief_house_details123").innerHTML="";
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('showgoogleoption').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="read_data.php";		
		url=url+"?Command="+"filter_last_name";		
		url=url+"&lastname="+document.getElementById('lastname').value;
		//alert(url);
			
		xmlHttp.onreadystatechange=search_result_lastname;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	
	}
	//////////////////////////////// END LASTNAME FILTERING PART //////////////////////////////////////////////////////////////////



////////////////////// STARTING LOCATION FILTERING PART //////////////////////////////////////////////////////////////////////////////
else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value=="" & document.getElementById('location').value!="" & document.getElementById('Suburb').value=="")
	{
		//alert("ok");
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";
		document.getElementById("pesonaldetails").innerHTML="";
		document.getElementById("printChiefhouse").innerHTML="";
		document.getElementById("printothertable").innerHTML="";
		document.getElementById("print_chief_house_details123").innerHTML="";
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('showgoogleoption').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="read_data.php";		
		url=url+"?Command="+"filter_location_wise";		
		url=url+"&location="+document.getElementById('location').value;
		//alert(url);
			
		xmlHttp.onreadystatechange=search_location_wise;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	
	}
//////////////////////////////// END LOCATION FILTERING PART /////////////////////////////////////////////////////////////////////////

////////////////////// STARTING SUBURB FILTERING PART //////////////////////////////////////////////////////////////////////////////
else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value=="" & document.getElementById('location').value=="" & document.getElementById('Suburb').value!="")
	{
		//alert("ok");
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";
		document.getElementById("pesonaldetails").innerHTML="";
		document.getElementById("printChiefhouse").innerHTML="";
		document.getElementById("printothertable").innerHTML="";
		document.getElementById("print_chief_house_details123").innerHTML="";
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('showgoogleoption').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="read_data.php";		
		url=url+"?Command="+"filter_suburb_wise";		
		url=url+"&Suburb="+document.getElementById('Suburb').value;
		//alert(url);
			
		xmlHttp.onreadystatechange=search_suburb_wise;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	
	}
//////////////////////////////// END SUBURB FILTERING PART /////////////////////////////////////////////////////////////////////////

////////////////////// STARTING FIRST NAME AND TOWN FILTERING PART //////////////////////////////////////////////////////////////////////////////
else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value!="" & document.getElementById('lastname').value=="" & document.getElementById('location').value!="" & document.getElementById('Suburb').value=="")
	{
		//alert("ok");
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";
		document.getElementById("pesonaldetails").innerHTML="";
		document.getElementById("printChiefhouse").innerHTML="";
		document.getElementById("printothertable").innerHTML="";
		document.getElementById("print_chief_house_details123").innerHTML="";
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('showgoogleoption').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="read_data.php";		
		url=url+"?Command="+"filter_first_town_wise";		
		url=url+"&firstname="+document.getElementById('firstname').value;
		url=url+"&location="+document.getElementById('location').value;
		//alert(url);
			
		xmlHttp.onreadystatechange=search_first_town_wise;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	
	}
//////////////////////////////// END FIRST NAME AND TOWN FILTERING PART /////////////////////////////////////////////////////////////////////////


////////////////////// STARTING FIRST NAME AND SUBURB FILTERING PART //////////////////////////////////////////////////////////////////////////////
else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value!="" & document.getElementById('lastname').value=="" & document.getElementById('location').value=="" & document.getElementById('Suburb').value!="")
	{
		//alert("ok");
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";
		document.getElementById("pesonaldetails").innerHTML="";
		document.getElementById("printChiefhouse").innerHTML="";
		document.getElementById("printothertable").innerHTML="";
		document.getElementById("print_chief_house_details123").innerHTML="";
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('showgoogleoption').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="read_data.php";		
		url=url+"?Command="+"filter_first_suburb_wise";		
		url=url+"&firstname="+document.getElementById('firstname').value;
		url=url+"&Suburb="+document.getElementById('Suburb').value;
		//alert(url);
			
		xmlHttp.onreadystatechange=search_first_Suburb_wise;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	
	}
//////////////////////////////// END FIRST NAME AND SUBURB FILTERING PART /////////////////////////////////////////////////////////////////////////

////////////////////// STARTING OTHER NAME AND TOWN FILTERING PART //////////////////////////////////////////////////////////////////////////////
else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value!="" & document.getElementById('location').value!="" & document.getElementById('Suburb').value=="")
	{
		//alert("ok");
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";
		document.getElementById("pesonaldetails").innerHTML="";
		document.getElementById("printChiefhouse").innerHTML="";
		document.getElementById("printothertable").innerHTML="";
		document.getElementById("print_chief_house_details123").innerHTML="";
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('showgoogleoption').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="read_data.php";		
		url=url+"?Command="+"filter_other_town_wise";		
		url=url+"&lastname="+document.getElementById('lastname').value;
		url=url+"&location="+document.getElementById('location').value;
		//alert(url);
			
		xmlHttp.onreadystatechange=search_other_town_wise;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	
	}
//////////////////////////////// END OTHER NAME AND TOWN FILTERING PART /////////////////////////////////////////////////////////////////////////


////////////////////// STARTING OTHER NAME AND SUBURB FILTERING PART //////////////////////////////////////////////////////////////////////////////
else if(document.getElementById('nic').value=="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value!="" & document.getElementById('location').value=="" & document.getElementById('Suburb').value!="")
	{
		//alert("ok");
		document.getElementById('img_jobs').style.visibility='visible';	
		document.getElementById('img_insertdata').style.visibility='visible';
		document.getElementById('maintable').style.visibility='hidden';
		document.getElementById("print_firstname_details").innerHTML="";
		document.getElementById("pesonaldetails").innerHTML="";
		document.getElementById("printChiefhouse").innerHTML="";
		document.getElementById("printothertable").innerHTML="";
		document.getElementById("print_chief_house_details123").innerHTML="";
		document.getElementById('img_visit').style.visibility='visible';
		document.getElementById('showgoogleoption').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="read_data.php";		
		url=url+"?Command="+"filter_other_Suburb_wise";		
		url=url+"&lastname="+document.getElementById('lastname').value;
		url=url+"&Suburb="+document.getElementById('Suburb').value;
		//alert(url);
			
		xmlHttp.onreadystatechange=search_other_Suburb_wise;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	
	}
//////////////////////////////// END OTHER NAME AND SUBURB FILTERING PART /////////////////////////////////////////////////////////////////////////

}

function search_other_Suburb_wise()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{		
	//	alert(xmlHttp.responseText);	
		document.getElementById("print_firstname_details").innerHTML=xmlHttp.responseText;
	}
}


function search_other_town_wise()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{		
	//	alert(xmlHttp.responseText);	
		document.getElementById("print_firstname_details").innerHTML=xmlHttp.responseText;
	}
}


function search_first_Suburb_wise()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{		
	//	alert(xmlHttp.responseText);	
		document.getElementById("print_firstname_details").innerHTML=xmlHttp.responseText;
	}
}

function search_first_town_wise()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{		
	//	alert(xmlHttp.responseText);	
		document.getElementById("print_firstname_details").innerHTML=xmlHttp.responseText;
	}
}

function search_location_wise()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{		
	//	alert(xmlHttp.responseText);	
		document.getElementById("print_firstname_details").innerHTML=xmlHttp.responseText;
	}
}

function search_suburb_wise()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{		
	//	alert(xmlHttp.responseText);	
		document.getElementById("print_firstname_details").innerHTML=xmlHttp.responseText;
	}
}

////////////////////////////////////////////////////////////////////////////////get details from lastname

function search_result_lastname()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{		
	//	alert(xmlHttp.responseText);	
		document.getElementById("print_firstname_details").innerHTML=xmlHttp.responseText;
	}
}



////////////////////////////////////////////////////////////////////////////////////get Details From FirstName

function search_result_firstname()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{		
	//	alert(xmlHttp.responseText);	
	//	print_house_from_nic();
		document.getElementById("print_firstname_details").innerHTML=xmlHttp.responseText;
	}
}



/////////////////////////////////////////////////////////////////////////////////

function evnt_onload()
{	
	document.getElementById('img_jobs').style.visibility='hidden';
	document.getElementById('showgoogleoption').style.visibility='hidden';
	document.getElementById('img_insertdata').style.visibility='hidden';
	document.getElementById('img_visit').style.visibility='hidden';	
	document.getElementById('maintable').style.visibility='hidden';	
	document.getElementById('dropdownfname').style.visibility='hidden';		
	document.getElementById('dropdownlname').style.visibility='hidden';
	
	
	
	
}




function search_result_mapref()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		//alert(xmlHttp.responseText);
		
		document.getElementById("printChiefhouse").innerHTML="";
		
		if(xmlHttp.responseText=="Invalied NIC Number")
		{			
			document.getElementById("error_nic").innerHTML=xmlHttp.responseText;
			document.getElementById('pesonaldetails').innerHTML="";
			document.getElementById('printChiefhouse').innerHTML="";
			document.getElementById('printothertable').innerHTML="";
		}
	
		else
		{
			
			document.getElementById('maintable').style.visibility='visible';	//visible table			
			document.getElementById("pesonaldetails").innerHTML=xmlHttp.responseText;	
			get_lat_and_long_val();
			get_chief_house_detais();
			print_house_from_nic();
			
		}	
		
		
	}
}




function isvaliedNIC(txt)
{
	var str=txt.toUpperCase();	
		
	if(txt.length != 10)
	{
		//alert("Invalied Nic");
		return false;
	
	}
	else if(!isInteger(txt))
	{
		//alert("Invalied Nic");
		return false;
	}
	else if(str.lastIndexOf("V", str.length)==9 | str.lastIndexOf("X", str.length)==9)
	{
		//alert("Valied");	
		return true;
	}
	else
	{
		//alert("Invalied Nic");
		return false;
	}

	 
}


function isInteger(s)
{
      var i;
	s = s.toString();
      for (i = 0; i < (s.length-1); i++)
      {
         var c = s.charAt(i);
         if (isNaN(c)) 
	   {		
		return false;
	   }
      }
      return true;
}


function disable_personaldetail()
{
	document.getElementById('first_name').disabled= true;
	document.getElementById('last_name').disabled= true;
	document.getElementById('address_line1').disabled= true;
	document.getElementById('address_line2').disabled= true;
	document.getElementById('address_line3').disabled= true;
	document.getElementById('address_line4').disabled= true;
	document.getElementById('nicnum').disabled= true;
	document.getElementById('dte_of_birth').disabled= true;
	document.getElementById('sex').disabled= true;
	document.getElementById('race').disabled= true;
	document.getElementById('relogeon').disabled= true;
	document.getElementById('marital_status').disabled= true;
	
}

function disable_cho_details()
{
	document.getElementById('CHOfirst_name').disabled= true;
	document.getElementById('CHOlast_name').disabled= true;
	document.getElementById('CHOaddress_line1').disabled= true;
	document.getElementById('CHOaddress_line2').disabled= true;
	document.getElementById('CHOaddress_line3').disabled= true;
	document.getElementById('CHOaddress_line4').disabled= true;
	document.getElementById('CHOnicnum').disabled= true;
	document.getElementById('CHOdte_of_birth').disabled= true;
	document.getElementById('CHOsex').disabled= true;
	document.getElementById('CHOrace').disabled= true;
	document.getElementById('CHOrelogeon').disabled= true;
	document.getElementById('CHOmarital_status').disabled= true;
}


function get_chief_house_detais()
{
				
	var url="read_data.php";		
	url=url+"?Command="+"read_newChief_house_details";		
	url=url+"&nic="+document.getElementById('nic').value;
	//	alert(url);

	xmlHttp.onreadystatechange=print_chiefhouse_main_details;
				
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
	
}

function print_chiefhouse_main_details()
{
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	
	//	alert(xmlHttp.responseText);		
		document.getElementById("printChiefhouse").innerHTML=xmlHttp.responseText;
	//	print_house_from_nic();
		//alert("ok");
		//get_other_personal_details();
		
		
	}
}




function Chief_House_Details()
{
	if(document.getElementById('btn_chief_house_details').value=="Hidden Chief House Details")
	{
		document.getElementById('btn_chief_house_details').value="Chief House Details";
		document.getElementById("print_chief_house_details").innerHTML="";
	}
	else
	{
		document.getElementById('btn_chief_house_details').value="Hidden Chief House Details";
		
		if(document.getElementById('nic').value=="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value=="")
		{
			document.getElementById("error_nic").innerHTML="Please Enter NIC Number | First Name Or Last Name";
			return false;
		}
		else if(document.getElementById('nic').value!="" & document.getElementById('firstname').value=="" & document.getElementById('lastname').value=="")
		{
			if(document.getElementById('nic').value=="")
			{
				document.getElementById("nic").focus();
				document.getElementById("error_nic").innerHTML="Please Enter NIC Number";
				return false;
			}	
			else if(!isvaliedNIC(document.getElementById("nic").value))
			{
				document.getElementById("nic").focus();
				document.getElementById("error_nic").innerHTML="Please Enter NIC Number";
				return false;
			}
			else
			{
				
				document.getElementById("error_nic").innerHTML="";
				xmlHttp=GetXmlHttpObject();
				if (xmlHttp==null)
				{
					alert ("Browser does not support HTTP Request");
					return;
				} 		
					
				var url="read_data.php";		
				url=url+"?Command="+"read_Chief_house_details";		
				url=url+"&nic="+document.getElementById('nic').value;
			//	alert(url);
				
				xmlHttp.onreadystatechange=read_Chief_house_details;
				
				xmlHttp.open("GET",url,true);
				xmlHttp.send(null);	
				
			}
		}
	}
	
	
}


function read_Chief_house_details()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	
		//alert(xmlHttp.responseText);
		
		document.getElementById("print_chief_house_details").innerHTML=xmlHttp.responseText;
		
		
	}
}


function get_other_personal_details()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="read_data.php";		
	url=url+"?Command="+"get_other_personal_details";		
	url=url+"&nic="+document.getElementById('nic').value;
		
	xmlHttp.onreadystatechange=print_other_personal_details;		
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function print_other_personal_details()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 	
		//alert(xmlHttp.responseText);		
		document.getElementById("printothertable").innerHTML=xmlHttp.responseText;	
		
	}
}



function other_personal_details()
{
	if(document.getElementById('btn_other').value=="Hidden Other Details")
	{
		document.getElementById("printothertable").innerHTML="";
		document.getElementById('btn_other').value="Other Details";
	}
	else
	{
		document.getElementById('btn_other').value="Hidden Other Details";
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="read_data.php";		
		url=url+"?Command="+"read_other_data";		
		url=url+"&nic="+document.getElementById('nic').value;
		
		xmlHttp.onreadystatechange=read_other_data;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	}
		
}

function read_other_data()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		document.getElementById("printothertable").innerHTML=xmlHttp.responseText;		
	}
	
}


function get_occupationid_firstname(occupationid, lat, lon)
{
//	alert("first");
//	alert(occupationid);
	Occupationid=occupationid;
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="filter_first_name.php";		
	url=url+"?Command="+"get_data_from_firstname";		
	url=url+"&occupationid="+occupationid;	
	xmlHttp.onreadystatechange=get_data_from_firstname;		
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function get_occupationid_othername(occupationid, lat, lon)
{
	//alert(occupationid);
	Occupationid=occupationid;
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="other_name.php";		
	url=url+"?Command="+"get_data_from_firstname";		
	url=url+"&occupationid="+occupationid;	
	xmlHttp.onreadystatechange=get_data_from_firstname;		
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function get_occupationid_location(occupationid, lat, lon)
{
	//alert(occupationid);
	Occupationid=occupationid;
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="location.php";		
	url=url+"?Command="+"get_data_from_firstname";		
	url=url+"&occupationid="+occupationid;	
	xmlHttp.onreadystatechange=get_data_from_firstname;		
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function get_occupationid_sub(occupationid, lat, lon)
{
	//alert(occupationid);
	Occupationid=occupationid;
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="suburb.php";		
	url=url+"?Command="+"filter_suburb_wise_data";		
	url=url+"&occupationid="+occupationid;	
	xmlHttp.onreadystatechange=get_data_from_firstname;		
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function get_occupationid_fname_location(occupationid, lat, lon)
{
	alert(occupationid);
	Occupationid=occupationid;
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="filter_firstname_location.php";		
	url=url+"?Command="+"get_data_from_firstname_location";		
	url=url+"&occupationid="+occupationid;	
	xmlHttp.onreadystatechange=get_data_from_firstname;		
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function get_occupationid(occupationid, lat, lon)
{
	
	//document.getElementById("print_chief_house_details123").innerHTML="";	
	alert(occupationid);
	Occupationid=occupationid;
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="filter_first_name.php";		
	url=url+"?Command="+"get_data_from_firstname";		
	url=url+"&occupationid="+occupationid;	
	xmlHttp.onreadystatechange=get_data_from_firstname;		
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
	
	//latitude=lat;
	//longitude=lon;
	//alert(lat);
	//alert(lon);
	//inittest();
	//get_nic_from_fname(occupationid);
		
	
}


function IsValiedNICHDN(lat, lon){
	//alert("ok");
	//latitude=lat;
	//longitude=lon;
		   
	inittestsecond();	
}

function get_data_from_firstname()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);				
	//	document.getElementById('pesonaldetails').style.visibility='visible';
		document.getElementById("print_data").innerHTML=xmlHttp.responseText;			
		//get_other_details_from_firstname();
		get_lat_long_value_from_occupantid();
	
		
	}
	
}




function get_other_details_from_firstname()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="read_data.php";		
	url=url+"?Command="+"read_other_details_from_firstname";		
	url=url+"&occupationid="+Occupationid;
		
	xmlHttp.onreadystatechange=read_other_details_from_firstname;		
	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function read_other_details_from_firstname()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);		
		document.getElementById("printChiefhouse").innerHTML=xmlHttp.responseText;
		print_house_from_Occupantid(Occupationid);
		//init1();
	}
}


function maptonicmap()
{
	document.getElementById("nicmap").value=document.getElementById("nic").value
	
}



/////////////////////////////////////OPEN  GIS  /////////////////////////////////////////////////////////////////////////




function toggleKml123(lat)
{
	
	 
      // remove the old KML object if it exists
      if (currentKmlObjects[lat]) {
		//  alert("ok2");
        ge.getFeatures().removeChild(currentKmlObjects[lat]);
        currentKmlObject = null;
      }
    
      // if the checkbox is checked, fetch the KML and show it on Earth
     var kmlCheckbox = document.getElementById('kml-' + lat + '-check');
	// var kmlCheckbox = document.getElementById('kml-red-check');
	  
	 // alert(kmlCheckbox.checked);
      if (kmlCheckbox.checked)
	   
        loadKml123(lat);
	
}



 function loadKml123(file) {
     // var kmlUrl = 'http://earth-api-samples.googlecode.com/svn/trunk/' +
     //   'examples/static/' + file + '.kml';
	 
	 var kmlUrl = 'http://127.0.0.1/gissystem/' + file + '.kml';	
   	
      // fetch the KML
      google.earth.fetchKml(ge, kmlUrl, function(kmlObject) {
        // NOTE: we still have access to the 'file' variable (via JS closures)
    // alert(kmlUrl);
        if (kmlObject) {
          // show it on Earth
          currentKmlObjects[file] = kmlObject;
          ge.getFeatures().appendChild(kmlObject);
        } else {
          // bad KML
          currentKmlObjects[file] = null;
    
          // wrap alerts in API callbacks and event handlers
          // in a setTimeout to prevent deadlock in some browsers
          setTimeout(function() {
            alert('Bad or null KML.');
          }, 0);
    
          // uncheck the box
          document.getElementById('kml-' + file + '-check').checked = '';
        }
      });
    }
	


     function addSampleButton(caption, clickHandler) {
        var btn = document.createElement('input');
        btn.type = 'button';
        btn.value = caption;		
        
        if (btn.attachEvent)
          btn.attachEvent('onclick', clickHandler);
        else
          btn.addEventListener('click', clickHandler, false);

        // add the button to the Sample UI
        document.getElementById('sample-ui').appendChild(btn);
      }
      
      function addSampleUIHtml(html) {
        document.getElementById('sample-ui').innerHTML += html;
      }
 
    var ge;
    

    // store the object loaded for the given file... initially none of the objects
    // are loaded, so initialize these to null
    var currentKmlObjects = {
      'red': null,
      'yellow': null,
      'green': null
    };
    google.load("earth", "1");
    
    function inittest() {
      	  
	 // google.earth.createInstance('print_chief_house_details123', initCallback, failureCallback);
	   google.earth.createInstance('print_chief_house_details123', initCB, failureCB);
    	
		
      addSampleUIHtml(
        '<h2>Toggle KML Files:</h2>' +
        '<input type="checkbox" id="kml-red-check" onclick="toggleKml(\'red\');"/><label for="kml-red-check">Water Stream</label><br/>' +
        '<input type="checkbox" id="kml-yellow-check" onclick="toggleKml(\'yellow\');"/><label for="kml-yellow-check">Electricity</label><br/>' +
        '<input type="checkbox" id="kml-green-check" onclick="toggleKml(\'green\');"/><label for="kml-green-check">Road</label><br/>'
      );
	 
    }
	

	
	  function inittestsecond() {
      // alert(latitude);
	  
	  google.earth.createInstance('map3d1', initCallback, failureCallback);
   // alert(latitude);
   
      addSampleUIHtml(
        '<h2>Toggle KML Files:</h2>' +
        '<input type="checkbox" id="kml-red-check" onclick="toggleKml(\'red\');"/><label for="kml-red-check">Water Stream</label><br/>' +
        '<input type="checkbox" id="kml-yellow-check" onclick="toggleKml(\'yellow\');"/><label for="kml-yellow-check">Electricity</label><br/>' +
        '<input type="checkbox" id="kml-green-check" onclick="toggleKml(\'green\');"/><label for="kml-green-check">Road</label><br/>'
      );
    }
 
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
    function initCallback(instance) {
	
//	alert(longitude);
//	var longitude = 79.99964747084724;
//	var latitude = 7.090256547096815;
	
      ge = instance;
      ge.getWindow().setVisibility(true);
    
      // add a navigation control
      ge.getNavigationControl().setVisibility(ge.VISIBILITY_AUTO);
    
      // add some layers
      ge.getLayerRoot().enableLayerById(ge.LAYER_BORDERS, true);
      ge.getLayerRoot().enableLayerById(ge.LAYER_ROADS, true);
	
	
	
	// Add the placemark to Earth.
ge.getFeatures().appendChild(placemark);
    
      // fly to Santa Cruz
      var la = ge.createLookAt('');
      la.set(latitude, longitude,
        0, // altitude
        ge.ALTITUDE_RELATIVE_TO_GROUND,
        0, // heading
        0, // straight-down tilt
        5000 // range (inverse of zoom)
        );
      ge.getView().setAbstractView(la);
    
      // if the page loaded with checkboxes checked, load the appropriate
      // KML files
       if (document.getElementById('kml-red-check').checked)
        loadKml('1');
    
      if (document.getElementById('kml-yellow-check').checked)
        loadKml('yellow');
    
      if (document.getElementById('kml-green-check').checked)
        loadKml('green');
    
      document.getElementById('installed-plugin-version').innerHTML =
        ge.getPluginVersion().toString();
    }
    
    function failureCallback(errorCode) {
    }
    
*/

  function initCB(instance) {

         ge = instance;
         ge.getWindow().setVisibility(true);
         ge.getNavigationControl().setVisibility(ge.VISIBILITY_HIDE);

         // Create the placemark.
         var placemark = ge.createPlacemark('');
        // placemark.setName("placemark (roll over this point)");

		//alert(latitude);
		
         // Set the placemark's location.  
         var point = ge.createPoint('');
         point.setLatitude(latitude);
         point.setLongitude(longitude);
         placemark.setGeometry(point);

         // Create a style map.
         var styleMap = ge.createStyleMap('');

         // Create normal style for style map.
         var normalStyle = ge.createStyle('');
         var normalIcon = ge.createIcon('');
        // normalIcon.setHref('http://maps.google.com/mapfiles/kml/paddle/red-circle.png');
        // normalStyle.getIconStyle().setIcon(normalIcon);

         // Create highlight style for style map.
         var highlightStyle = ge.createStyle('');
         var highlightIcon = ge.createIcon('');
         //highlightIcon.setHref('http://google-maps-icons.googlecode.com/files/girlfriend.png');
         //highlightStyle.getIconStyle().setIcon(highlightIcon);
        // highlightStyle.getIconStyle().setScale(5.0);

         styleMap.setNormalStyle(normalStyle);
         styleMap.setHighlightStyle(highlightStyle);

         // Apply stylemap to a placemark.
         placemark.setStyleSelector(styleMap);

         // Add the placemark to Earth.
         ge.getFeatures().appendChild(placemark);

         // Move the camera.
         var la = ge.createLookAt('');
        // la.set(7.090256547096815, 79.99964747084724, 0, ge.ALTITUDE_RELATIVE_TO_GROUND, -8.541, 66.213, 20000);
		la.set(latitude, longitude, 0, ge.ALTITUDE_RELATIVE_TO_GROUND, 0, 0, 500);
         ge.getView().setAbstractView(la);
      }

      function failureCB(errorCode) {
      }

      google.setOnLoadCallback(init);
	  
   function toggleKml(file) {
	    //alert("ok1");
      // remove the old KML object if it exists
      if (currentKmlObjects[file]) {
		//  alert("ok2");
        ge.getFeatures().removeChild(currentKmlObjects[file]);
        currentKmlObject = null;
      }
    
      // if the checkbox is checked, fetch the KML and show it on Earth
      var kmlCheckbox = document.getElementById('kml-' + file + '-check');
      if (kmlCheckbox.checked)
        loadKml(file);
    }
    
    function loadKml(file) {
     // var kmlUrl = 'http://earth-api-samples.googlecode.com/svn/trunk/' +
     //   'examples/static/' + file + '.kml';
		
	 var kmlUrl = 'http://127.0.0.1/gissystem/' + file + '.kml';
	//  var kmlUrl = 'gissystem/' + file + '.kml';
    
      // fetch the KML
      google.earth.fetchKml(ge, kmlUrl, function(kmlObject) {
        // NOTE: we still have access to the 'file' variable (via JS closures)
    
        if (kmlObject) {
          // show it on Earth
          currentKmlObjects[file] = kmlObject;
          ge.getFeatures().appendChild(kmlObject);
        } else {
          // bad KML
          currentKmlObjects[file] = null;
    
          // wrap alerts in API callbacks and event handlers
          // in a setTimeout to prevent deadlock in some browsers
          setTimeout(function() {
            alert('Bad or null KML.');
          }, 0);
    
          // uncheck the box
          document.getElementById('kml-' + file + '-check').checked = '';
        }
      });
    }
	
	
	/////////////////////////////////// GIS SET POINT /////////////////////////////
	


	
	
	///////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////// END GOOGLE MAP /////////////////////////////////////////////////////////////
	
	function txtbox_nic()
	{
		document.getElementById('firstname').value="";
		document.getElementById('lastname').value="";
		document.getElementById('location').value="";
		document.getElementById('Suburb').value="";
	}
	
	function txtbox_fname()
	{
		document.getElementById('nic').value="";
		document.getElementById('lastname').value="";
		//document.getElementById('location').value="";
		//document.getElementById('Suburb').value="";
	}
	
	function txtbox_lname()
	{
		document.getElementById('nic').value="";
		document.getElementById('firstname').value="";
		//document.getElementById('location').value="";
		//document.getElementById('Suburb').value="";
	}
	
	function txtbox_location()
	{
		document.getElementById('nic').value="";
	//	document.getElementById('firstname').value="";
	//	document.getElementById('lastname').value="";
	//	document.getElementById('Suburb').value="";
	}
	
	function txtbox_suburb()
	{
		document.getElementById('nic').value="";
	//	document.getElementById('firstname').value="";
	//	document.getElementById('lastname').value="";
	//	document.getElementById('location').value="";
	}
	
	
	//GET MORE DETAILS ABOUT OCCUPATION
	function getmore_details(int_occupations_id)
	{
	//	alert("ok");
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
				
		var url="more_details.php";		
	//	url=url+"?Command="+"getmoredetails";		
		url=url+"?occupationid="+int_occupations_id;
		window.open(url,'Personal Details','height=350,width=780,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=no');

	}
	
	
	
	
	
	
	////////////////////////////////////PRINT HOUSE IMAGE /////////////////////////////////////////////////////////////////
function print_house_from_nic()
	{
		
			xmlHttp3=GetXmlHttpObject3();
			if (xmlHttp3==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
	 		
		var url="read_data.php";		
		url=url+"?Command="+"print_house_from_nic";		
		url=url+"&nic="+document.getElementById('nic').value;
		//	alert(url);
			
		xmlHttp3.onreadystatechange=show_image_from_nic;
			
		xmlHttp3.open("GET",url,true);
		xmlHttp3.send(null);	
	}
	
	
	function show_image_from_nic()
	{
		var XMLAddress3;
	
		if (xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete")
		{ 	
			//alert(xmlHttp.responseText);			
			//document.getElementById("imgShow").src=xmlHttp.responseText;	
			document.getElementById("printimage").innerHTML=xmlHttp3.responseText;			
			
		}
	}
///////////////////////////////////////////////// END HOUSE IMAGE /////////////////////////////////////////////////////////////////



////////////////////////////////////PRINT HOUSE FROM FIRSTNAME /////////////////////////////////////////////////////////////////
	function print_house_from_Occupantid(Occupantid)
	{
	 		
		var url="read_data.php";		
		url=url+"?Command="+"print_house_from_show_image_from_Occupantid";		
		url=url+"&Occupantid="+Occupantid;
		//	alert(url);
			
		xmlHttp.onreadystatechange=show_image_from_Occupantid;
			
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	}
	
	
	function show_image_from_Occupantid()
	{
		var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
			//alert(xmlHttp.responseText);			
			//document.getElementById("imgShow").src=xmlHttp.responseText;	
			document.getElementById("printimage").innerHTML=xmlHttp.responseText;			
			
		}
	}
///////////////////////////////////////////////// END HOUSE IMAGE /////////////////////////////////////////////////////////////////








//////////////////////////////////// START GET LAT LON VALUE ////////////////////////////////////////////////////////////////////


function get_lat_and_long_val()
{
	//	alert("ok");
	xmlHttpMap=GetXmlHttpObject();
	if (xmlHttpMap==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
	
	var url="read_data.php";		
	url=url+"?Command="+"latandlon";		
	url=url+"&nic="+document.getElementById('nic').value;
	//alert(url);
	xmlHttpMap.onreadystatechange=set_lan_lone_value;		
	xmlHttpMap.open("GET",url,true);
	xmlHttpMap.send(null);	
}

function set_lan_lone_value()
{
	var XMLAddress1;
	//alert("ok");
	if (xmlHttpMap.readyState==4 || xmlHttpMap.readyState=="complete")
	{
		
		var length=latitude=xmlHttpMap.responseText.length;
		var val=xmlHttpMap.responseText.indexOf('/');
		
		
		latitude=parseFloat(xmlHttpMap.responseText.substring(0,val));
		longitude=parseFloat(xmlHttpMap.responseText.substring(val+1,length));
		//alert(latitude);
		//alert(longitude);
		//latitude=7.090256547096815;
		//longitude=79.99964747084724;;
		inittest();
	}
}

function Insert_Data()
{
		location.href="inserts_data.php";
	
/*	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 					
	var url="inserts_data.php";	
	url=url+"?nic="+document.getElementById('nic').value;
//	location.href=url;
	xmlHttp.onreadystatechange=insertdata();		
	xmlHttp.open("POST",url,true);
	xmlHttp.send(null);	
	*/
}

function insertdata()
{
	var XMLAddress1;
	
	if (xmlHttpMap.readyState==4 || xmlHttpMap.readyState=="complete")
	{
		
	}
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////get lat long value from name////////////////////////////////////////////////////////////////////////////////////////////////////

function get_lat_long_value_from_occupantid()
{
	xmlHttpMap=GetXmlHttpObject();
	if (xmlHttpMap==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 					
	var url="read_data.php";	
	url=url+"?Command="+"lat_lon_name";	
	url=url+"&Occupationid="+Occupationid;	
	xmlHttpMap.onreadystatechange=set_lat_long_name;		
	xmlHttpMap.open("GET",url,true);
	xmlHttpMap.send(null);
}

function set_lat_long_name()
{
	var XMLAddress1;
	
	if (xmlHttpMap.readyState==4 || xmlHttpMap.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		var length=latitude=xmlHttpMap.responseText.length;
		var val=xmlHttpMap.responseText.indexOf('/');
		
		
		latitude=parseFloat(xmlHttpMap.responseText.substring(0,val));
		longitude=parseFloat(xmlHttpMap.responseText.substring(val+1,length));
		//alert(latitude);
		//alert(longitude);
		//latitude=7.090256547096815;
		//longitude=79.99964747084724;;
		inittest();
	}
}



function house_details_page(mapferno)
{
	var url="show_house_detals.php?maprefno="+mapferno;
		window.open(url,'House Details','height=415,width=820,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=no');
}
