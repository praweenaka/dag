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

	

function IsInsertData()
{

	if(document.getElementById('map_ref_no').value=="" )
	{			
		document.getElementById("map_ref_no").focus();
		document.getElementById("mainerror").innerHTML="Please Enter Map Ref No";
		
		return false;
	}
	else if(document.getElementById('telephone').value=="Yes" &  document.getElementById("telno").value=="")
	{
		alert(document.getElementById('telephone').value);
		document.getElementById("mainerror").innerHTML="Please Enter Correct Tel Number";
		return false;
	}
	else if(document.getElementById('telephone').value=="Yes" & document.getElementById("telno").value.length !=10 )
	{
		alert(document.getElementById('telephone').value);
		document.getElementById("mainerror").innerHTML="Please Enter Correct Tel Number";
		return false;
	}
	else if(document.getElementById('telephone').value=="Yes" & !isInteger(document.getElementById('telno').value) )
	{
		alert(document.getElementById('telephone').value);
		document.getElementById("mainerror").innerHTML="Please Enter Correct Tel Number";
		return false;
	}


	else
	{
		document.getElementById("error_ref_no").innerHTML="";
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="savedata.php";
		
		//House Details
		
		if(document.getElementById('map_ref_no').disabled== true)
		{
			//alert ("Edit");
			
			url=url+"?Command="+"Edit_house_details";			
			url=url+"&map_ref_no="+document.getElementById('map_ref_no').value;
			url=url+"&addressline1="+document.getElementById('addressline1').value;
			url=url+"&addressline2="+document.getElementById('addressline2').value;
			url=url+"&addressline3="+document.getElementById('addressline3').value;
			url=url+"&addressline4="+document.getElementById('addressline4').value;
			url=url+"&house_type="+document.getElementById('house_type').value;
			url=url+"&owner_ship="+document.getElementById('owner_ship').value;
			url=url+"&usage="+document.getElementById('usage').value;
			url=url+"&structure="+document.getElementById('structure').value;
			url=url+"&roof_type="+document.getElementById('roof_type').value;
			url=url+"&wall="+document.getElementById('wall').value;
			url=url+"&floor="+document.getElementById('floor').value;
			url=url+"&wall_colour="+document.getElementById('wall_colour').value;
			url=url+"&no_of_rooms="+document.getElementById('no_of_rooms').value;
			url=url+"&perimeter_wall="+document.getElementById('perimeter_wall').value;
			url=url+"&p_w_weight="+document.getElementById('p_w_weight').value;
			url=url+"&house_unit_status="+document.getElementById('house_unit_status').value;
			url=url+"&economics_status="+document.getElementById('economics_status').value;
			
			
			
			//Supplies and services
			
			url=url+"&water_supply="+document.getElementById('water_supply').value;
			url=url+"&garbage_disposal="+document.getElementById('garbage_disposal').value;
			url=url+"&toilet_facility="+document.getElementById('toilet_facility').value;
			url=url+"&electricity="+document.getElementById('electricity').value;
			url=url+"&telephone="+document.getElementById('telephone').value;
			url=url+"&telno="+document.getElementById('telno').value;
			
			
			//Natural Disasrers
			url=url+"&house_come_under_the_flood="+document.getElementById('house_come_under_the_flood').value;
			url=url+"&flood_effect="+document.getElementById('flood_effect').value;
			url=url+"&flood_level="+document.getElementById('flood_level').value;
			url=url+"&drought_effect="+document.getElementById('drought_effect').value;
			url=url+"&other="+document.getElementById('other').value;
			
			//alert(url);
		
			xmlHttp.onreadystatechange=edit_house_details;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
		}
		else
		{
			url=url+"?Command="+"savehousedetails";
			url=url+"&map_ref_no="+document.getElementById('map_ref_no').value;
			url=url+"&addressline1="+document.getElementById('addressline1').value;
			url=url+"&addressline2="+document.getElementById('addressline2').value;
			url=url+"&addressline3="+document.getElementById('addressline3').value;
			url=url+"&addressline4="+document.getElementById('addressline4').value;
			url=url+"&house_type="+document.getElementById('house_type').value;
			url=url+"&owner_ship="+document.getElementById('owner_ship').value;
			url=url+"&usage="+document.getElementById('usage').value;
			url=url+"&structure="+document.getElementById('structure').value;
			url=url+"&roof_type="+document.getElementById('roof_type').value;
			url=url+"&wall="+document.getElementById('wall').value;
			url=url+"&floor="+document.getElementById('floor').value;
			url=url+"&wall_colour="+document.getElementById('wall_colour').value;
			url=url+"&no_of_rooms="+document.getElementById('no_of_rooms').value;
			url=url+"&perimeter_wall="+document.getElementById('perimeter_wall').value;
			url=url+"&p_w_weight="+document.getElementById('p_w_weight').value;
			url=url+"&house_unit_status="+document.getElementById('house_unit_status').value;
			url=url+"&economics_status="+document.getElementById('economics_status').value;
			
			
			
			//Supplies and services
			
			url=url+"&water_supply="+document.getElementById('water_supply').value;
			url=url+"&garbage_disposal="+document.getElementById('garbage_disposal').value;
			url=url+"&toilet_facility="+document.getElementById('toilet_facility').value;
			url=url+"&electricity="+document.getElementById('electricity').value;
			url=url+"&telephone="+document.getElementById('telephone').value;
			url=url+"&telno="+document.getElementById('telno').value;
			
			
			//Natural Disasrers
			url=url+"&house_come_under_the_flood="+document.getElementById('house_come_under_the_flood').value;
			url=url+"&flood_effect="+document.getElementById('flood_effect').value;
			url=url+"&flood_level="+document.getElementById('flood_level').value;
			url=url+"&drought_effect="+document.getElementById('drought_effect').value;
			url=url+"&other="+document.getElementById('other').value;
	
			//alert(url);
			xmlHttp.onreadystatechange=savehouse_setails;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	

		}
		
		
		
	}
}


function edit_house_details()
{
		var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		/*	//alert(xmlHttp.responseText);	
			document.getElementById('map_ref_no').value="";
			document.getElementById('map_ref_no').disabled= false;
			house_detail_clear();
			//btn_new();
			ClearForm();*/
			
			location.href ="occupants.php";
			
		 }
}

function btn_house_exit()
{
	location.href ="index.php";
}



function savehouse_setails()
{	
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
			 if(xmlHttp.responseText=="Map Ref Number is all ready exists")
			 {
				 document.getElementById("mainerror").innerHTML=xmlHttp.responseText;
			 }
			 else
			 {
				 location.href ="occupants.php";
			 }
		 
					
		 }
}

function occupants()
{
	
	
	document.getElementById("printtabledata").innerHTML="";	
	document.getElementById('search_mapref_no').value=document.getElementById('map_ref_no').value;
	btn_search_occupments();
	
	
	if(document.getElementById('map_ref_no').value=="")
	{	
		document.getElementById("er_occipants").innerHTML="First Please Enter House Details.";
		document.getElementById("mapreferror").innerHTML="";
		return false;
	}
	if(document.getElementById('firstname').value=="")
	{	
		document.getElementById("firstname").focus();
		document.getElementById("er_occipants").innerHTML="Please Enter First Name.";
		document.getElementById("mapreferror").innerHTML="";
		return false;
	}
/*	else if(document.getElementById('nic').value=="")
	{
		document.getElementById("nic").focus();
		document.getElementById("er_occipants").innerHTML="Please Enter NIC Number";	
		document.getElementById("mapreferror").innerHTML="";
		return false;
	}*/
	else if(document.getElementById('nic').value!="" & isvaliedNIC(document.getElementById('nic').value)==false)
	{
		document.getElementById("nic").focus();
		document.getElementById("er_occipants").innerHTML="Invalied NIC Number";	
		document.getElementById("mapreferror").innerHTML="";
		return false;
	}
	else if(document.getElementById('relatoinship').value==0)
	{		
		document.getElementById("relatoinship").focus();
		document.getElementById("er_occipants").innerHTML="Please Select Relation Ship";	
		document.getElementById("mapreferror").innerHTML="";
		return false;
	}

	else
	{
		
		document.getElementById("er_occipants").innerHTML="";		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="savedata.php";
		
		//House Details
		url=url+"?Command="+"saveoccupation";		
		
		url=url+"&map_ref_no="+document.getElementById('map_ref_no').value;
		url=url+"&serialno="+document.getElementById('serialno').value;
		url=url+"&firstname="+document.getElementById('firstname').value;
		url=url+"&lastname="+document.getElementById('lastname').value;
		url=url+"&nic="+document.getElementById('nic').value;		
		url=url+"&txtdatetime="+document.getElementById('txtdatetime').value;
		url=url+"&age="+document.getElementById('age').value;
		url=url+"&relatoinship="+document.getElementById('relatoinship').value;
		url=url+"&sex="+document.getElementById('sex').value;
		url=url+"&race="+document.getElementById('race').value;
		url=url+"&religeon="+document.getElementById('religeon').value;
		url=url+"&marital="+document.getElementById('marital').value;
		url=url+"&education="+document.getElementById('education').value;
		url=url+"&occupation="+document.getElementById('occupation').value;
		url=url+"&industry="+document.getElementById('industry').value;
		url=url+"&naturejob="+document.getElementById('naturejob').value;
		url=url+"&voter="+document.getElementById('voter').value;
		url=url+"&disablestatus="+document.getElementById('disablestatus').value;
		url=url+"&disability="+document.getElementById('disability').value;
		url=url+"&rcv_public_funds="+document.getElementById('rcv_public_funds').value;
		url=url+"&if_not_avalable_at_home="+document.getElementById('if_not_avalable_at_home').value;	
		url=url+"&prev_district="+document.getElementById('prev_district').value;
		url=url+"&training_field="+document.getElementById('training_field').value;
		url=url+"&training_period="+document.getElementById('training_period').value;
	
		xmlHttp.onreadystatechange=save_occupants;
		
		xmlHttp.open("GET",url,true);	
		xmlHttp.send(null);	
		document.getElementById("mapreferror").innerHTML="";
		
	
	}
}



function save_occupants()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	
	//	alert(xmlHttp.responseText);
		document.getElementById('search_mapref_no').value=document.getElementById('map_ref_no').value;
	
	//	btn_search_occupments();
	//	disable_occupation();
		
		if(xmlHttp.responseText=="errornic")
		{
			//alert("ok")
			document.getElementById("er_occipants").innerHTML="NIC is all ready exists";
			//document.getElementById("printtabledata").innerHTML=table;
			//setoccupation();			
			return false;
		}
		else if(xmlHttp.responseText=="errorcho")
		{
			document.getElementById("er_occipants").innerHTML="Chief House Occupation Details is all ready exists";
			//document.getElementById("printtabledata").innerHTML=table;
			//setoccupation();		
			return false;
		}
		
		else if(xmlHttp.responseText=="errorcho1")
		{
			alert("ok");
			document.getElementById("er_occipants").innerHTML="First must be added Chief House Occupation Details";
		//	document.getElementById("printtabledata").innerHTML=table;
		//	setoccupation();			
			return false;
		}
		else if(xmlHttp.responseText=="Invalied house")
		{
			document.getElementById("er_occipants").innerHTML="First Enter House Details";
		//	document.getElementById("printtabledata").innerHTML=table;
		//	setoccupation();			
			return false;
		}
	
		else
		{			
		
			document.getElementById("printtabledata").innerHTML=xmlHttp.responseText;			
			setoccupation();		
		}		
		
	}
}

function setoccupation()
{
	var url="savedata.php";	
	url=url+"?Command="+"printoccupation";
	url=url+"&map_ref_no="+document.getElementById('map_ref_no').value;		
	xmlHttp.onreadystatechange=printoccupation;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
		
}

function printoccupation()
{
		var XMLAddress1;
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		document.getElementById("printtabledata").innerHTML=xmlHttp.responseText;
		disable_occupant();
		location.href ="occupants.php";
	}
}



function checkRelation()
{
	if(document.getElementById('familymember').value.length < 1)
	{			
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="savedata.php";
		
		//occupants Details
		url=url+"?Command="+"get_relation";
		url=url+"&serialno="+document.getElementById('serialno').value;
		url=url+"&map_ref_no="+document.getElementById('map_ref_no').value;
		xmlHttp.onreadystatechange=Relation;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	}
	
}

function Relation()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		
		if(xmlHttp.responseText=="Chief House Occupant")
		{
				 
			document.getElementById("relatoinship").options[1].selected = true;
			document.getElementById("relatoinship").disabled=true;
			
		}
		else
		{
			//alert(document.getElementById("relatoinship").length);	
			document.getElementById("relatoinship").remove(0);
		}
		
	}
}


function isValiedTelephone()
{
	
	if(document.getElementById("telno").value.length !=10)
	{
		alert("invalied Telephone Number");
	}
	else if(!isInteger(document.getElementById('telno').value))
	{
		alert("invalied Telephone Number");
	}
	else
	{
		alert("Valied Telephone Number");
	}
		
}

function Housedetail_search()
{

	
	if(document.getElementById('map_ref_no').value=="" )
	{			
		document.getElementById("map_ref_no").focus();
		document.getElementById("error_ref_no").innerHTML="Please Enter Map Ref No";
		document.getElementById('map_ref_no').disabled= false;
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
			
		var url="savedata.php";		
		url=url+"?Command="+"search_house_details";		
		url=url+"&map_ref_no="+document.getElementById('map_ref_no').value;
		
		xmlHttp.onreadystatechange=house_search_result;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	}

}

function house_search_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		//alert(xmlHttp.responseText);
		disable_house();
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_house_id");	
		var val=XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		if(val=="Invalied")
		{
			document.getElementById("error_ref_no").innerHTML="Invalied Map Ref No";
			house_detail_clear();
			document.getElementById('map_ref_no').disabled= false;
		}
		else
		{
			var text="";
			
			document.getElementById("error_ref_no").innerHTML=" ";
				
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_map_ref_no");						
			document.getElementById('map_ref_no').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address_line1");						
			document.getElementById('addressline1').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address_line2");						
			document.getElementById('addressline2').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address_line3");						
			document.getElementById('addressline3').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address_line4");						
			document.getElementById('addressline4').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
			
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_house_type");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("house_type"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_house_type");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_house_type_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("house_type").options.add(opt);			 
				document.getElementById("house_type").options[(document.getElementById("house_type").length-1)].selected = true;
				
			}

			
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_ownership");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")			
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("owner_ship"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_ownership");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_ownership_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("owner_ship").options.add(opt);			 
				document.getElementById("owner_ship").options[(document.getElementById("owner_ship").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_usage");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")		
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("usage"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_usage");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_usage_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("usage").options.add(opt);			 
				document.getElementById("usage").options[(document.getElementById("usage").length-1)].selected = true;
			}
			
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_structure");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")	
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("structure"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_structure");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_structure_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("structure").options.add(opt);			 
				document.getElementById("structure").options[(document.getElementById("structure").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_roof_type");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")	
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("roof_type"),text);		//Removed Selected Value
				
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_roof_type");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_roof_type_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("roof_type").options.add(opt);			 
				document.getElementById("roof_type").options[(document.getElementById("roof_type").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_wall");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")	
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("wall"),text);		//Removed Selected Value
				
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_wall");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_wall_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("wall").options.add(opt);			 
				document.getElementById("wall").options[(document.getElementById("wall").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_floor");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")	
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("floor"),text);		//Removed Selected Value
				
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_floor");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_floor_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("floor").options.add(opt);			 
				document.getElementById("floor").options[(document.getElementById("floor").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_wall_colour");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")				
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("wall_colour"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_wall_colour");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_wall_colour_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("wall_colour").options.add(opt);			 
				document.getElementById("wall_colour").options[(document.getElementById("wall_colour").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_no_of_rooms");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("no_of_rooms"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_no_of_rooms");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_no_of_rooms");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("no_of_rooms").options.add(opt);			 
				document.getElementById("no_of_rooms").options[(document.getElementById("no_of_rooms").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_perimeter_wall");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("perimeter_wall"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_perimeter_wall");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_permeter_wall_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("perimeter_wall").options.add(opt);			 
				document.getElementById("perimeter_wall").options[(document.getElementById("perimeter_wall").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dbl_pw_hight");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("p_w_weight"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dbl_pw_hight");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dbl_pw_hight");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("p_w_weight").options.add(opt);			 
				document.getElementById("p_w_weight").options[(document.getElementById("p_w_weight").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_house_unit_status");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("house_unit_status"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_house_unit_status");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_house_unit_status_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("house_unit_status").options.add(opt);			 
				document.getElementById("house_unit_status").options[(document.getElementById("house_unit_status").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_economics_status");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("economics_status"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_economics_status");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_economics_status_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("economics_status").options.add(opt);			 
				document.getElementById("economics_status").options[(document.getElementById("economics_status").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_water_supply");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("water_supply"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_water_supply");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_water_supply_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("water_supply").options.add(opt);			 
				document.getElementById("water_supply").options[(document.getElementById("water_supply").length-1)].selected = true;
			}
			
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_garbage_disposal");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("garbage_disposal"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_garbage_disposal");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_garbage_disposal_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("garbage_disposal").options.add(opt);			 
				document.getElementById("garbage_disposal").options[(document.getElementById("garbage_disposal").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_toylet_fac");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();			
				getoption1(document.getElementById("toilet_facility"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_toylet_fac");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_toylet_fac");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("toilet_facility").options.add(opt);			 
				document.getElementById("toilet_facility").options[(document.getElementById("toilet_facility").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_electricity");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getoption1(document.getElementById("electricity"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_electricity");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_electricity");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("electricity").options.add(opt);			 
				document.getElementById("electricity").options[(document.getElementById("electricity").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_telephone");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getoption1(document.getElementById("telephone"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_telephone");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_telephone");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("telephone").options.add(opt);			 
				document.getElementById("telephone").options[(document.getElementById("telephone").length-1)].selected = true;
			}

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_tel_number");						
			document.getElementById('telno').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
			
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_house_come_uf");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getoption1(document.getElementById("house_come_under_the_flood"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_house_come_uf");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_house_come_uf");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("house_come_under_the_flood").options.add(opt);			 
				document.getElementById("house_come_under_the_flood").options[(document.getElementById("house_come_under_the_flood").length-1)].selected = true;
			}
		
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_flood_effect");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("flood_effect"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_flood_effect");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_flood_effect_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("flood_effect").options.add(opt);			 
				document.getElementById("flood_effect").options[(document.getElementById("flood_effect").length-1)].selected = true;
			}
			
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_flood_level_id");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getOptions(document.getElementById("flood_level"),text);		//Removed Selected Value
					
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_flood_level_id");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_flood_level_id");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("flood_level").options.add(opt);			 
				document.getElementById("flood_level").options[(document.getElementById("flood_level").length-1)].selected = true;
			}
			
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_drought_effect");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getoption1(document.getElementById("drought_effect"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_drought_effect");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_drought_effect");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("drought_effect").options.add(opt);			 
				document.getElementById("drought_effect").options[(document.getElementById("drought_effect").length-1)].selected = true;
			}
			
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("other");
			if(XMLAddress1[0].childNodes[0].nodeValue!="")
			{
				text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
				getoption1(document.getElementById("other"),text);		//Removed Selected Value
				
				var opt = document.createElement("option");
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("other");
				opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		 	
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("other");
				opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				document.getElementById("other").options.add(opt);			 
				document.getElementById("other").options[(document.getElementById("other").length-1)].selected = true;
			}

			
			
		}
	}
}


function house_detail_clear()
{
	
	document.getElementById('addressline1').value="";
	document.getElementById('addressline2').value="";
	document.getElementById('addressline3').value="";
	document.getElementById('addressline4').value="";
	ClearDropDown(document.getElementById('house_type'),"");
	ClearDropDown(document.getElementById('owner_ship'),"");
	ClearDropDown(document.getElementById('usage'),"");
	ClearDropDown(document.getElementById('structure'),"");
	ClearDropDown(document.getElementById('roof_type'),"");
	ClearDropDown(document.getElementById('wall'),"");
	ClearDropDown(document.getElementById('floor'),"");
	ClearDropDown(document.getElementById('wall_colour'),"");
	ClearDropDown(document.getElementById('no_of_rooms'),"");
	ClearDropDown(document.getElementById('perimeter_wall'),"");
	ClearDropDown(document.getElementById('p_w_weight'),"");	
	ClearDropDown(document.getElementById('house_unit_status'),"");	
	ClearDropDown(document.getElementById('economics_status'),"");
	
	ClearDropDown(document.getElementById('water_supply'),"");
	ClearDropDown(document.getElementById('garbage_disposal'),"");
	ClearDropDown(document.getElementById('toilet_facility'),"");
	ClearDropDown(document.getElementById('electricity'),"");
	ClearDropDown(document.getElementById('telephone'),"");
	ClearDropDown(document.getElementById('house_come_under_the_flood'),"");
	ClearDropDown(document.getElementById('flood_effect'),"");
	ClearDropDown(document.getElementById('flood_level'),"");
	ClearDropDown(document.getElementById('drought_effect'),"");
	ClearDropDown(document.getElementById('other'),"");
	
}

function addsex(object,txt)
{
//	alert(txt);
	
var x=object;
var val=txt;

	
//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_house_type");	
//	var txt=XMLAddress1[0].childNodes[0].nodeValue;
	
//	var val=txt;
	
	for (i=0;i<x.length;i++)
	  {
		 //  alert(x.options[i].value);
		  if(x.options[i].value==val)
		  {
	//	alert("ok");
			x.options[i].selected = true;	//selected Value			
			x.remove(object.selectedIndex);						//remove selected Value
			//alert("Same");
			// x.options[x.options[i].value].selected = true;	//selected Value
			//  x.remove(x.selectedIndex);						//remove selected Value
		  }
		 
	  }//End For Loop
}

function getOptions(object,txt)
{
	
	var x=object;
	
//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_house_type");	
//	var txt=XMLAddress1[0].childNodes[0].nodeValue;
	
	var val=txt;
	
	for (i=0;i<x.length;i++)
	  {
		  if(x.options[i].text==val)
		  {
			// alert(x.options[i].value)
			// alert("Same");
			  x.options[x.options[i].value].selected = true;	//selected Value
			  x.remove(x.selectedIndex);						//remove selected Value
		  }
		 
	  }//End For Loop
	  
}

function getoption1(object,txt)
{
	var x=object;
	var val=txt;
	
	for (i=0;i<x.length;i++)
	  {
		  
		  if(x.options[i].text==val)
		  {			 
			  x.options[i].selected = true;	//selected Value
			  x.remove(x.selectedIndex);	//remove selected Value
		  }
		 
	  }//End For Loop
}


function disable_house()
{
	document.getElementById('map_ref_no').disabled= true;	
	document.getElementById('addressline1').disabled= true;	
	document.getElementById('addressline2').disabled= true;	
	document.getElementById('addressline3').disabled= true;	
	document.getElementById('addressline4').disabled= true;	
	document.getElementById('house_type').disabled= true;	
	document.getElementById('owner_ship').disabled= true;
	document.getElementById('usage').disabled= true;	
	document.getElementById('structure').disabled= true;	
	document.getElementById('roof_type').disabled= true;	
	document.getElementById('wall').disabled= true;	
	document.getElementById('floor').disabled= true;	
	document.getElementById('wall_colour').disabled= true;	
	document.getElementById('no_of_rooms').disabled= true;	
	document.getElementById('perimeter_wall').disabled= true;	
	document.getElementById('p_w_weight').disabled= true;	
	document.getElementById('house_unit_status').disabled= true;	
	document.getElementById('economics_status').disabled= true;	
	document.getElementById('water_supply').disabled= true;	
	document.getElementById('garbage_disposal').disabled= true;	
	document.getElementById('toilet_facility').disabled= true;	
	document.getElementById('electricity').disabled= true;	
	document.getElementById('telephone').disabled= true;	
	document.getElementById('flood_effect').disabled= true;	
	document.getElementById('house_come_under_the_flood').disabled= true;	
	document.getElementById('flood_level').disabled= true;	
	document.getElementById('drought_effect').disabled= true;
	document.getElementById('other').disabled= true;

}

function enable_house()
{
	document.getElementById('map_ref_no').disabled= true;	
	document.getElementById('addressline1').disabled= false;	
	document.getElementById('addressline2').disabled= false;	
	document.getElementById('addressline3').disabled= false;	
	document.getElementById('addressline4').disabled= false;	
	document.getElementById('house_type').disabled= false;	
	document.getElementById('owner_ship').disabled= false;
	document.getElementById('usage').disabled= false;	
	document.getElementById('structure').disabled= false;	
	document.getElementById('roof_type').disabled= false;	
	document.getElementById('wall').disabled= false;	
	document.getElementById('floor').disabled= false;	
	document.getElementById('wall_colour').disabled= false;	
	document.getElementById('no_of_rooms').disabled= false;	
	document.getElementById('perimeter_wall').disabled= false;	
	document.getElementById('p_w_weight').disabled= false;	
	document.getElementById('house_unit_status').disabled= false;	
	document.getElementById('economics_status').disabled= false;	
	document.getElementById('water_supply').disabled= false;	
	document.getElementById('garbage_disposal').disabled= false;	
	document.getElementById('toilet_facility').disabled= false;	
	document.getElementById('electricity').disabled= false;	
	document.getElementById('telephone').disabled= false;	
	document.getElementById('flood_effect').disabled= false;	
	document.getElementById('house_come_under_the_flood').disabled= false;	
	document.getElementById('flood_level').disabled= false;	
	document.getElementById('drought_effect').disabled= false;
	document.getElementById('other').disabled= false;
}



function ClearDropDown(object,txt)
{
	var x=object;
	var val=txt;
	
	for (i=0;i<x.length;i++)
	  {		 	  	
		  if(x.options[i].text=="")
		  {		  	 
			  x.options[i].selected = true;	//selected Value		 
			
		  }
		 
	  }//End For Loop
}

function Action_new_button(){
	
	house_detail_clear();
	document.getElementById('map_ref_no').disabled= false;
}

function btn_edit()
{
	if(document.getElementById('map_ref_no').value=="" )
	{			
		document.getElementById("map_ref_no").focus();
		document.getElementById("error_ref_no").innerHTML="Please Enter Map Ref No";
		document.getElementById('map_ref_no').disabled= false;
		return false;
	}
	else
	{
		enable_house();
	}
	
}

function btn_new_click1()
{	//alert("ok");
	//house_detail_clear();
	//document.getElementById('map_ref_no').disabled= false;
	//document.getElementById('map_ref_no').value="";
	location.href ="house_details.php";
}

function ClearForm()
	{	
		setTimeout("location.reload(true);",100);
	}



function onloadevnt()
{
//	document.getElementById('telno').style.visibility='hidden';

}

function more_datails(txt)
{
	alert(txt);
}



function occupation_remove(nic)
{
	
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="savedata.php";		
		url=url+"?Command="+"remove_occupation";		
		url=url+"&nic="+nic;
		
		xmlHttp.onreadystatechange=remove_occupation;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
}

function remove_occupation()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		//alert(xmlHttp.responseText);
	//	document.getElementById("printtabledata").innerHTML="";	
	//	btnremove_clear();
		btn_search_occupments();
		location.href ="occupants.php";
		//ClearForm();
		
	}
}


function disable_occupant()
{
	document.getElementById('serialno').disabled= false;	
	document.getElementById('map_ref_no').disabled= true;	
	document.getElementById('firstname').disabled= true;	
	document.getElementById('lastname').disabled= true;	
	document.getElementById('nic').disabled= true;	
	document.getElementById('txtdatetime').disabled= true;	
	document.getElementById('relatoinship').disabled= true;	
	document.getElementById('sex').disabled= true;	
	document.getElementById('race').disabled= true;	
	document.getElementById('religeon').disabled= true;	
	document.getElementById('marital').disabled= true;	
	document.getElementById('education').disabled= true;	
	document.getElementById('occupation').disabled= true;	
	document.getElementById('industry').disabled= true;	
	document.getElementById('naturejob').disabled= true;	
	document.getElementById('voter').disabled= true;	
	document.getElementById('disablestatus').disabled= true;	
	document.getElementById('disability').disabled= true;	
	document.getElementById('rcv_public_funds').disabled= true;	
	document.getElementById('if_not_avalable_at_home').disabled= true;	
	document.getElementById('prev_district').disabled= true;	
	document.getElementById('training_field').disabled= true;	
	document.getElementById('training_period').disabled= true;	
}


function disable_occupation()
{
	
	document.getElementById('serialno').disabled= true;	
	document.getElementById('map_ref_no').disabled= true;	
	document.getElementById('firstname').disabled= true;	
	document.getElementById('lastname').disabled= true;	
	document.getElementById('nic').disabled= true;	
	document.getElementById('txtdatetime').disabled= true;	
	document.getElementById('relatoinship').disabled= true;	
	document.getElementById('sex').disabled= true;	
	document.getElementById('race').disabled= true;	
	document.getElementById('religeon').disabled= true;	
	document.getElementById('marital').disabled= true;	
	document.getElementById('education').disabled= true;	
	document.getElementById('occupation').disabled= true;	
	document.getElementById('industry').disabled= true;	
	document.getElementById('naturejob').disabled= true;	
	document.getElementById('voter').disabled= true;	
	document.getElementById('disablestatus').disabled= true;	
	document.getElementById('disability').disabled= true;	
	document.getElementById('rcv_public_funds').disabled= true;	
	document.getElementById('if_not_avalable_at_home').disabled= true;	
	document.getElementById('prev_district').disabled= true;	
	document.getElementById('training_field').disabled= true;	
	document.getElementById('training_period').disabled= true;	
}




function enable_occupation()
{
	document.getElementById('serialno').disabled= false;	
	document.getElementById('map_ref_no').disabled= false;	
	document.getElementById('firstname').disabled= false;	
	document.getElementById('lastname').disabled= false;	
	document.getElementById('nic').disabled= false;	
	document.getElementById('txtdatetime').disabled= false;	
	document.getElementById('age').disabled= false;	
	document.getElementById('relatoinship').disabled= false;	
	document.getElementById('sex').disabled= false;	
	document.getElementById('race').disabled= false;	
	document.getElementById('religeon').disabled= false;	
	document.getElementById('marital').disabled= false;	
	document.getElementById('education').disabled= false;	
	document.getElementById('occupation').disabled= false;	
	document.getElementById('industry').disabled= false;	
	document.getElementById('naturejob').disabled= false;	
	document.getElementById('voter').disabled= false;	
	document.getElementById('disablestatus').disabled= false;	
	document.getElementById('disability').disabled= false;	
	document.getElementById('rcv_public_funds').disabled= false;	
	document.getElementById('if_not_avalable_at_home').disabled= false;	
	document.getElementById('prev_district').disabled= false;	
	document.getElementById('training_field').disabled= false;	
	document.getElementById('training_period').disabled= false;	
}



/*
function enable_occupation()
{
	

	document.getElementById('serialno').disabled= false;	
	document.getElementById('map_ref_no').disabled= false;	
	document.getElementById('firstname').disabled= false;	
	document.getElementById('lastname').disabled= false;	
	document.getElementById('nic').disabled= false;	
	document.getElementById('txtdatetime').disabled= false;	
	document.getElementById('age').disabled= false;	
	document.getElementById('relatoinship').disabled= false;	
	document.getElementById('sex').disabled= false;	
	document.getElementById('race').disabled= false;	
	document.getElementById('religeon').disabled= false;	
	document.getElementById('marital').disabled= false;	
	document.getElementById('education').disabled= false;	
	document.getElementById('occupation').disabled= false;	
	document.getElementById('industry').disabled= false;	
	document.getElementById('naturejob').disabled= false;	
	document.getElementById('voter').disabled= false;	
	document.getElementById('disablestatus').disabled= false;	
	document.getElementById('disability').disabled= false;	
	document.getElementById('rcv_public_funds').disabled= false;	
	document.getElementById('if_not_avalable_at_home').disabled= false;	
	document.getElementById('prev_district').disabled= false;	
	document.getElementById('training_field').disabled= false;	
	document.getElementById('training_period').disabled= false;	
}
*/
function clear_occupation()
{
	
	document.getElementById('serialno').value="";
	document.getElementById('map_ref_no').value="";
	document.getElementById('firstname').value="";
	document.getElementById('lastname').value="";
	document.getElementById('nic').value="";
	document.getElementById('txtdatetime').value="";
	ClearDropDown(document.getElementById('relatoinship'),"");
	ClearDropDown(document.getElementById('sex'),"");
	ClearDropDown(document.getElementById('race'),"");
	ClearDropDown(document.getElementById('religeon'),"");
	ClearDropDown(document.getElementById('marital'),"");
	ClearDropDown(document.getElementById('education'),"");
	ClearDropDown(document.getElementById('occupation'),"");
	ClearDropDown(document.getElementById('industry'),"");
	ClearDropDown(document.getElementById('naturejob'),"");
	ClearDropDown(document.getElementById('voter'),"");
	ClearDropDown(document.getElementById('disablestatus'),"");
	ClearDropDown(document.getElementById('disability'),"");
	ClearDropDown(document.getElementById('rcv_public_funds'),"");
	ClearDropDown(document.getElementById('if_not_avalable_at_home'),"");
	ClearDropDown(document.getElementById('prev_district'),"");
	ClearDropDown(document.getElementById('training_field'),"");	
	ClearDropDown(document.getElementById('training_period'),"");
}

function btnremove_clear()
{
	
	document.getElementById('firstname').value="";
	document.getElementById('lastname').value="";
	document.getElementById('nic').value="";
	document.getElementById('txtdatetime').value="";
	ClearDropDown(document.getElementById('relatoinship'),"");
	ClearDropDown(document.getElementById('sex'),"");
	ClearDropDown(document.getElementById('race'),"");
	ClearDropDown(document.getElementById('religeon'),"");
	ClearDropDown(document.getElementById('marital'),"");
	ClearDropDown(document.getElementById('education'),"");
	ClearDropDown(document.getElementById('occupation'),"");
	ClearDropDown(document.getElementById('industry'),"");
	ClearDropDown(document.getElementById('naturejob'),"");
	ClearDropDown(document.getElementById('voter'),"");
	ClearDropDown(document.getElementById('disablestatus'),"");
	ClearDropDown(document.getElementById('disability'),"");
	ClearDropDown(document.getElementById('rcv_public_funds'),"");
	ClearDropDown(document.getElementById('if_not_avalable_at_home'),"");
	ClearDropDown(document.getElementById('prev_district'),"");
	ClearDropDown(document.getElementById('training_field'),"");	
	ClearDropDown(document.getElementById('training_period'),"");
}


function search_occupation()
{
	
	if(document.getElementById('searchnic').value=="")
	{
		document.getElementById("searchnic").focus();
		document.getElementById("error_search").innerHTML="Please Enter NIC Number";
		clear_occupation();
		return false;
	}
	else if(isvaliedNIC(document.getElementById('searchnic').value)==false)
	{
		document.getElementById("searchnic").focus();
		document.getElementById("error_search").innerHTML="Invalied NIC Number";	
		clear_occupation();
		return false;
	}
	else
	{
		
		document.getElementById("error_search").innerHTML="";
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="savedata.php";		
		url=url+"?Command="+"search_occupation";		
		url=url+"&nic="+document.getElementById('searchnic').value;
		
		xmlHttp.onreadystatechange=search_occupation_result;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	}
	
}

function search_occupation_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		//alert(xmlHttp.responseText);
		//ClearForm();
		text="";
		
		
		if(xmlHttp.responseText=="Invalied NIC Number")
		{
			document.getElementById("searchnic").focus();
			document.getElementById("error_search").innerHTML=xmlHttp.responseText;
			clear_occupation();
		}
		else
		{
			
			
			
			//	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_occupations_id");						
			//	document.getElementById('serialno').value= XMLAddress1[0].childNodes[0].nodeValue;
			
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_occupation_family_id");	
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					document.getElementById('serialno').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();			
			
				}
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_map_ref_no");		
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					document.getElementById('map_ref_no').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
				}
				
			
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_first_name");			
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					document.getElementById('firstname').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
				}
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_Last_name");	
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					document.getElementById('lastname').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
				}
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_nic");	
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					document.getElementById('nic').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
				}
				
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dte_date_of_birth");	
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					document.getElementById('txtdatetime').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
				}
				
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_relation_ship");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();			
					getOptions(document.getElementById("relatoinship"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_relation_ship");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase(); 	
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_relation_ship_id");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
					document.getElementById("relatoinship").options.add(opt);			 
					document.getElementById("relatoinship").options[(document.getElementById("relatoinship").length-1)].selected = true;
				}
				
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_age");	
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					document.getElementById('age').value= XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
				}
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_sex");				
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					//alert(text);
					addsex(document.getElementById("sex"),text);		//Removed Selected Value
					//alert("ok");
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_sex");
					
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase(); 	
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_sex");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();					
					document.getElementById("sex").options.add(opt);			 
					document.getElementById("sex").options[(document.getElementById("sex").length-1)].selected = true;
				}
		
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_race");				
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();					
					getOptions(document.getElementById("race"),text);		//Removed Selected Value
					
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_race");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();			
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_race_id");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
					document.getElementById("race").options.add(opt);			 
					document.getElementById("race").options[(document.getElementById("race").length-1)].selected = true;
				}
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_religeon");				
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					getOptions(document.getElementById("religeon"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_religeon");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_religeon_id");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
					document.getElementById("religeon").options.add(opt);			 
					document.getElementById("religeon").options[(document.getElementById("religeon").length-1)].selected = true;
				}

				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_marital");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					getOptions(document.getElementById("marital"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_marital");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase(); 	
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_marital_id");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
					document.getElementById("marital").options.add(opt);			 
					document.getElementById("marital").options[(document.getElementById("marital").length-1)].selected = true;
				}
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_education");				
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					getOptions(document.getElementById("education"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_education");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase(); 	
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_education_id");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
					document.getElementById("education").options.add(opt);			 
					document.getElementById("education").options[(document.getElementById("education").length-1)].selected = true;
				}
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_occupation");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
					getOptions(document.getElementById("occupation"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_occupation");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	 	
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_occupation_id");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					document.getElementById("occupation").options.add(opt);			 
					document.getElementById("occupation").options[(document.getElementById("occupation").length-1)].selected = true;
				}				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_occupation");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					getOptions(document.getElementById("industry"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_industry");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	 	
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_industry_id");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					document.getElementById("industry").options.add(opt);			 
					document.getElementById("industry").options[(document.getElementById("industry").length-1)].selected = true;
				}
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_nature_job");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					getOptions(document.getElementById("naturejob"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_nature_job");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	 	
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_nature_job");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					document.getElementById("naturejob").options.add(opt);			 
					document.getElementById("naturejob").options[(document.getElementById("naturejob").length-1)].selected = true;
				}
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vote");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
					getOptions(document.getElementById("voter"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vote");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	 	
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_vote_id");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
					document.getElementById("voter").options.add(opt);			 
					document.getElementById("voter").options[(document.getElementById("voter").length-1)].selected = true;
				}
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_disable_status");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
					getOptions(document.getElementById("disablestatus"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_disable_status");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	 		
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_disable_status_id");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					document.getElementById("disablestatus").options.add(opt);			 
					document.getElementById("disablestatus").options[(document.getElementById("disablestatus").length-1)].selected = true;
				}
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_disibility");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
					getOptions(document.getElementById("disability"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_disibility");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	 		
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_disibility_id");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	
					document.getElementById("disability").options.add(opt);			 
					document.getElementById("disability").options[(document.getElementById("disability").length-1)].selected = true;
				}
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_public_funds");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
					getOptions(document.getElementById("rcv_public_funds"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_public_funds");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	 		
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_rcv_public_funds");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					document.getElementById("rcv_public_funds").options.add(opt);			 
					document.getElementById("rcv_public_funds").options[(document.getElementById("rcv_public_funds").length-1)].selected = true;
				}
				
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_if_not_avalable_at_home");
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
					getOptions(document.getElementById("if_not_avalable_at_home"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_if_not_avalable_at_home");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	 		
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_if_not_avalable_at_home");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					document.getElementById("if_not_avalable_at_home").options.add(opt);			 
					document.getElementById("if_not_avalable_at_home").options[(document.getElementById("if_not_avalable_at_home").length-1)].selected = true;
				}
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_prev_district");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
					getOptions(document.getElementById("prev_district"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_prev_district");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	 		
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_prev_district");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					document.getElementById("prev_district").options.add(opt);			 
					document.getElementById("prev_district").options[(document.getElementById("prev_district").length-1)].selected = true;
				
				}
				
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_prev_district");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
					getOptions(document.getElementById("str_prev_district"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_prev_district");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	 		
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_training_field");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					document.getElementById("prev_district").options.add(opt);			 
					document.getElementById("prev_district").options[(document.getElementById("prev_district").length-1)].selected = true;
			
				}
				
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_training_field");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
					getOptions(document.getElementById("training_field"),text);		//Removed Selected Value
						
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_training_field");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	 		
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_training_field");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					document.getElementById("training_field").options.add(opt);			 
					document.getElementById("training_field").options[(document.getElementById("training_field").length-1)].selected = true;
			
				}
					
				XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_training_period");
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();				
					getOptions(document.getElementById("training_period"),text);		//Removed Selected Value
					
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_training_period");
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();	 		
					XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("int_training_period");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					document.getElementById("training_period").options.add(opt);			 
					document.getElementById("training_period").options[(document.getElementById("training_period").length-1)].selected = true;				
				}
	
				
				get_details_from_nic();
				
			
		}
		
			
	}
}

function clear_btn_new()
{

	document.getElementById('firstname').value="";
	document.getElementById('lastname').value="";
	document.getElementById('nic').value="";
	document.getElementById('txtdatetime').value="";
	ClearDropDown(document.getElementById('relatoinship'),"");
	ClearDropDown(document.getElementById('sex'),"");
	ClearDropDown(document.getElementById('race'),"");
	ClearDropDown(document.getElementById('religeon'),"");
	ClearDropDown(document.getElementById('marital'),"");
	ClearDropDown(document.getElementById('education'),"");
	ClearDropDown(document.getElementById('occupation'),"");
	ClearDropDown(document.getElementById('industry'),"");
	ClearDropDown(document.getElementById('naturejob'),"");
	ClearDropDown(document.getElementById('voter'),"");
	ClearDropDown(document.getElementById('disablestatus'),"");
	ClearDropDown(document.getElementById('disability'),"");
	ClearDropDown(document.getElementById('rcv_public_funds'),"");
	ClearDropDown(document.getElementById('if_not_avalable_at_home'),"");
	ClearDropDown(document.getElementById('prev_district'),"");
	ClearDropDown(document.getElementById('training_field'),"");	
	ClearDropDown(document.getElementById('training_period'),"");
}


function occupation_btn_new()
{
	clear_btn_new();
	get_details_from_nic();
	
}


function btn_search_occupments()
{
	
	if(document.getElementById('search_mapref_no').value=="")
	{
		document.getElementById("search_mapref_no").focus();
		document.getElementById("mapreferror").innerHTML="Please Enter Map Ref No";			
		return false;
	}
	else
	{
		
		document.getElementById("mapreferror").innerHTML="";
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="savedata.php";		
		url=url+"?Command="+"search_Map_refno";		
		url=url+"&map_ref_no="+document.getElementById('search_mapref_no').value;
		//alert(url);
		xmlHttp.onreadystatechange=search_result_maprefno;
		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	}
}

function search_result_maprefno()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
	//	alert(xmlHttp.responseText);
		
		if(xmlHttp.responseText=="Invalied Map Ref No")
		{
			document.getElementById("mapreferror").innerHTML=xmlHttp.responseText;
		}
		else
		{			
			document.getElementById('map_ref_no').value=document.getElementById('search_mapref_no').value;
			document.getElementById("printtabledata").innerHTML=xmlHttp.responseText;	
			getmaxid_from_family();
		}
	}
}

function getmaxid_from_family()
{
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="savedata.php";		
		url=url+"?Command="+"getmaxfamiltid";		
		url=url+"&map_ref_no="+document.getElementById('search_mapref_no').value;
		//alert(url);
		xmlHttp.onreadystatechange=show_max_familyid;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
}

function show_max_familyid()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		document.getElementById("serialno").value=xmlHttp.responseText;
	
	}
}



function change_eve()
{
	if(document.getElementById('telephone').value=="NO")
	{
	
	document.getElementById('telno').value="";

	}
	
}

function load_occupation()
{
	
	
	if(document.getElementById('map_ref_no').value!="")
	{
		btn_search_occupments();
		
		
	}
	

	document.getElementById("mapreferror").innerHTML="";

	
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="savedata.php";		
		url=url+"?Command="+"load_maprefNo";		
		url=url+"&map_ref_no="+document.getElementById('map_ref_no').value;
		
		xmlHttp.onreadystatechange=loadmaprefno;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	
	
}

function loadmaprefno()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		//alert(xmlHttp.responseText);
		document.getElementById("printtabledata").innerHTML=xmlHttp.responseText;	
	
	}
}

function btn_save_occupation()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
		var url="savedata.php";		
		url=url+"?Command="+"edit_occupation";		
		url=url+"&map_ref_no="+document.getElementById('map_ref_no').value;
		url=url+"&serialno="+document.getElementById('serialno').value;
		url=url+"&firstname="+document.getElementById('firstname').value;
		url=url+"&lastname="+document.getElementById('lastname').value;
		url=url+"&nic="+document.getElementById('nic').value;
		url=url+"&txtdatetime="+document.getElementById('txtdatetime').value;
		url=url+"&age="+document.getElementById('age').value;
		url=url+"&relatoinship="+document.getElementById('relatoinship').value;
		url=url+"&sex="+document.getElementById('sex').value;
		url=url+"&race="+document.getElementById('race').value;
		url=url+"&religeon="+document.getElementById('religeon').value;
		url=url+"&marital="+document.getElementById('marital').value;
		url=url+"&education="+document.getElementById('education').value;
		url=url+"&occupation="+document.getElementById('occupation').value;
		url=url+"&industry="+document.getElementById('industry').value;
		url=url+"&naturejob="+document.getElementById('naturejob').value;
		url=url+"&voter="+document.getElementById('voter').value;
		url=url+"&disablestatus="+document.getElementById('disablestatus').value;
		url=url+"&disability="+document.getElementById('disability').value;
		url=url+"&rcv_public_funds="+document.getElementById('rcv_public_funds').value;
		url=url+"&if_not_avalable_at_home="+document.getElementById('if_not_avalable_at_home').value;	
		url=url+"&prev_district="+document.getElementById('prev_district').value;
		url=url+"&training_field="+document.getElementById('training_field').value;
		url=url+"&training_period="+document.getElementById('training_period').value;
		
		xmlHttp.onreadystatechange=result_btn_save_occupation;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
}

function result_btn_save_occupation()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//	alert(xmlHttp.responseText);
		btn_search_occupments();
		location.href ="occupants.php";
	
	}
}


function get_details_from_nic()
{
	
	document.getElementById("mapreferror").innerHTML="";
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="savedata.php";		
		url=url+"?Command="+"search_occupation_from_nic";		
		url=url+"&nic="+document.getElementById('searchnic').value;
		
		xmlHttp.onreadystatechange=print_details_from_nic;
		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
}

function print_details_from_nic()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		//alert(xmlHttp.responseText);		
		document.getElementById("printtabledata").innerHTML=xmlHttp.responseText;	
		disable_occupation();
	
	}
}


function checkTel()
{
	
/*	if(document.getElementById('telno').value=="")
	{
		document.getElementById('telephone').value="YES";
	}
	else
	{
		document.getElementById('telephone').value="NO";
	}*/

}


function create_age()
{	
	if(document.getElementById('nic').value=="")
	{
		document.getElementById('age').value="";
	}
	else if(document.getElementById('nic').value.length>1 & document.getElementById('nic').value.length<3 )
	{
		var d = new Date();
		var curr_year = d.getFullYear();	
	//	alert(curr_year);
		var age=parseInt(curr_year)-parseInt("19"+document.getElementById('nic').value);
	//	alert(age);
		document.getElementById('age').value=age;
		document.getElementById('age').disabled= true;
		document.getElementById('txtdatetime').disabled= true;
		
	}

}

function txtbox_age()
{
	document.getElementById('txtdatetime').disabled= true;
}

function txtbox_dte_of_birth()
{
	if(document.getElementById('txtdatetime').value.length<4)
	{
		document.getElementById('age').value="";
	}
	else if(document.getElementById('txtdatetime').value.length >3)
	{
		var d = new Date();
		var curr_year = d.getFullYear();	
		var birthyear=document.getElementById('txtdatetime').value;
		var birthyear=birthyear.substring(0,4);
		
		birthyear=parseInt(birthyear);
		var age=curr_year-birthyear
		//alert(age);
		document.getElementById('age').value=age;
		document.getElementById('age').disabled= true;
	}
	
	
}

