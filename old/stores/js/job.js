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


function GetXmlHttpObject2()
	{
		
		var xmlHttp2=null;
		try
		 {
			 // Firefox, Opera 8.0+, Safari
		
			 xmlHttp2=new XMLHttpRequest();
		 }
		catch (e)
		 {
			 // Internet Explorer
			 try
			  {
				
				   xmlHttp2=new ActiveXObject("Msxml2.XMLHTTP");
			  }
			 catch (e)
			  {
				
				  xmlHttp2=new ActiveXObject("Microsoft.XMLHTTP");
			  }
		 }
		
		return xmlHttp2;
}


function job_data()
{
	
		if(document.getElementById('nic').value=="" || document.getElementById('referance_no').value=="")
		{
			document.getElementById("err_nic").innerHTML="Please Enter NIC of Referance Number";
			document.getElementById("referance_no").focus();
			return false;
		}
		else if(document.getElementById('name').value=="")
		{
			document.getElementById("err_nic").innerHTML="Please Enter Name";
			document.getElementById("name").focus();
			return false;
		}
		else
		{
			
			document.getElementById("print_message").innerHTML="";
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="jobdata.php";			
			url=url+"?Command="+"job_details";
			url=url+"&id="+document.getElementById('id').value;
			url=url+"&referance_no="+document.getElementById('referance_no').value;
			url=url+"&nic="+document.getElementById('nic').value;	
			url=url+"&name="+document.getElementById('name').value;				
			url=url+"&address="+document.getElementById('address').value;				
			url=url+"&town="+document.getElementById('town').value;			
			url=url+"&plk="+document.getElementById('plk').value;	
			
			url=url+"&gramaseva_division="+document.getElementById('grv').value;		
						
			url=url+"&telno="+document.getElementById('telno').value;			
			url=url+"&political_approve="+document.getElementById('political_approve').value;	
			url=url+"&detail1="+document.getElementById('detail1').value;
			url=url+"&detail2="+document.getElementById('detail2').value;
			url=url+"&detail3="+document.getElementById('detail3').value;
			url=url+"&detail4="+document.getElementById('detail4').value;			
			url=url+"&ele1="+document.getElementById('ele1').value;
			url=url+"&ele2="+document.getElementById('ele2').value;
			url=url+"&ele3="+document.getElementById('ele3').value;
			url=url+"&ele4="+document.getElementById('ele4').value;
			url=url+"&ele5="+document.getElementById('ele5').value;
			url=url+"&ele6="+document.getElementById('ele6').value;
			url=url+"&date="+document.getElementById('date').value;
			url=url+"&job="+document.getElementById('job').checked;	
			url=url+"&datetime="+document.getElementById('datetime').value;
		//	alert("ok");
			var institute="";
			var post="";
			
			//INSTITUTE
			if(document.getElementById('organization').value!="" && document.getElementById('institute').value=="")
			{
				institute=document.getElementById('organization').value;
			}
			
			if(document.getElementById('institute').value!="")
			{
				institute=document.getElementById('institute').value;
			}
			url=url+"&institute="+institute;	
			
			//POST
			if(document.getElementById('designation').value!="" && document.getElementById('institute').value=="")
			{
				post=document.getElementById('designation').value;
			}
			
			if(document.getElementById('post').value!="")
			{
				post=document.getElementById('post').value;
			}
			
			url=url+"&post="+post;	
			
			url=url+"&sex="+document.getElementById('sex').value;
			url=url+"&dte_birthday="+document.getElementById('dte_birthday').value;
			url=url+"&other_qualification="+document.getElementById('other_qualification').value;
			url=url+"&education="+document.getElementById('education').value;			
			url=url+"&get_action="+document.getElementById('get_action').value;
			url=url+"&came_reason="+document.getElementById('came_reason').value;
			
			xmlHttp.onreadystatechange=showjobsresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
		

	
}

function showjobsresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		setTimeout("location.reload(true);",500);
		//document.getElementById("print_message").innerHTML=xmlHttp.responseText;
		//clearform();
	}
}



function onload_func()
{
//	alert("ok");	
		var cal=new Date();
		var date=cal.getDate();
		var month=cal.getMonth();
		var year=cal.getFullYear();
		document.getElementById('datetime').value=year+"-"+(month+1)+"-"+date;
		
	document.getElementById('tb_job').style.visibility='hidden';
	
	if(document.getElementById('nic').value=="")
	{
		document.getElementById("nic").focus();
	//	document.getElementById("err_nic").innerHTML="Please Enter NIC";
		
		
	}
	else
	{
		
		xmlHttp2=GetXmlHttpObject();
		if (xmlHttp2==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="jobdata.php";		
			url=url+"?Command="+"Search_details";
			url=url+"&nic="+document.getElementById('nic').value;
			xmlHttp2.onreadystatechange=getsearchResult;
			xmlHttp2.open("GET",url,true);
			xmlHttp2.send(null);
	}
	

	
}




function clear_data()
{
	document.getElementById("print_message").innerHTML="";
	document.getElementById("err_nic").innerHTML="";
	
	document.getElementById('id').value="";
	document.getElementById('referance_no').value="";
	document.getElementById('nic').value="";
	document.getElementById('name').value="";
	document.getElementById('address').value="";
	ClearDropDown(document.getElementById('sex'),"");
	document.getElementById('dte_birthday').value="";
	ClearDropDown(document.getElementById('education'),"");	
	document.getElementById('other_qualification').value="";
	ClearDropDown(document.getElementById('town'),"");
	document.getElementById("plks").innerHTML="";
	document.getElementById("grvs").innerHTML="";	
	document.getElementById('telno').value="";
	document.getElementById('political_approve').value="";
	document.getElementById('detail1').value="";
	document.getElementById('detail2').value="";
	document.getElementById('detail3').value="";
	document.getElementById('detail4').value="";
	document.getElementById('ele1').value="";
	document.getElementById('ele2').value="";
	document.getElementById('ele3').value="";
	document.getElementById('ele4').value="";
	document.getElementById('ele5').value="";
	document.getElementById('ele6').value="";
	document.getElementById('job').checked=false;
	ClearDropDown(document.getElementById('institute'),"");	
	ClearDropDown(document.getElementById('post'),"");	
	document.getElementById('date').value="";	
	document.getElementById('get_action').value="";
	document.getElementById('came_reason').value="";

}



function get_search_jobs()
{

	if(document.getElementById('referance_no').value!="" && document.getElementById('nic').value=="" )
	{
		
		xmlHttp2=GetXmlHttpObject();
		if (xmlHttp2==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="jobdata.php";		
			url=url+"?Command="+"Search_details_rferance";
			url=url+"&referance_no="+document.getElementById('referance_no').value;
			//xmlHttp2.onreadystatechange=getsearchResult;
			xmlHttp2.onreadystatechange=get_search_Result;
			xmlHttp2.open("GET",url,true);
			xmlHttp2.send(null);
	}
	else if(document.getElementById('referance_no').value=="" && document.getElementById('nic').value!="" )
	{
		
		xmlHttp2=GetXmlHttpObject();
		if (xmlHttp2==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="jobdata.php";		
			url=url+"?Command="+"Search_details_nic";
			url=url+"&nic="+document.getElementById('nic').value;
			//xmlHttp2.onreadystatechange=getsearchResult;
			xmlHttp2.onreadystatechange=get_search_Result;
			xmlHttp2.open("GET",url,true);
			xmlHttp2.send(null);
	}
	else if(document.getElementById('referance_no').value!="" && document.getElementById('nic').value!="")
	{
	
		xmlHttp2=GetXmlHttpObject();
		if (xmlHttp2==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="jobdata.php";		
			url=url+"?Command="+"Search_details_rferance";
			url=url+"&referance_no="+document.getElementById('referance_no').value;
			url=url+"&nic="+document.getElementById('nic').value;
		//	xmlHttp2.onreadystatechange=getsearchResult;
			xmlHttp2.onreadystatechange=get_search_Result;
			xmlHttp2.open("GET",url,true);
			xmlHttp2.send(null);
	}
	else
	{
		document.getElementById("referance_no").focus();
		document.getElementById("err_nic").innerHTML="Please Enter NIC";
	}	

		
}


function get_search_Result()
{
	var XMLAddress1;
	
		if (xmlHttp2.readyState==4 || xmlHttp2.readyState=="complete")
		{ 	
		//	alert(xmlHttp2.responseText);
			document.getElementById("print_table").innerHTML=xmlHttp2.responseText;
			
		}
}

function getsearchResult()
{
	var XMLAddress1;
	
		if (xmlHttp2.readyState==4 || xmlHttp2.readyState=="complete")
		{ 	
		
				clear_data();
		//		alert(xmlHttp2.responseText);
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_nic");				
				var val= XMLAddress1[0].childNodes[0].nodeValue;
				
				if(val=="invalied")
				{					
					document.getElementById("nic").focus();
					document.getElementById("err_nic").innerHTML="Invalied NIC Number";
					
				}
				else
				{

						
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_name");				
				document.getElementById('name').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_address");				
				document.getElementById('address').value= XMLAddress1[0].childNodes[0].nodeValue;
				
	
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_nic");				
				document.getElementById('nic').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_tel");				
				document.getElementById('telno').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_politics_approvel");				
				document.getElementById('political_approve').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_join_politics");	
				var str_join_politics=XMLAddress1[0].childNodes[0].nodeValue;
				
				var val=0;
				var count=0;
				var politics=new Array();
			
				for(var i=0;i<=str_join_politics.length;i++)
				{
					//alert(str_join_politics[i]);
					if(str_join_politics[i]=='$')
					{
					
					//	politics[count]=str_join_politics.substring(val,i);
						politics[count]="";
						val=i+1;					
						++count;
						
					}
					if(i==str_join_politics.length)
						politics[count]=str_join_politics.substring(val,i);					
					
				}
		
				for(var loop=0;loop<politics.length;loop++)
				{
					document.getElementById('detail'+(loop+1)).value=politics[loop];				
				}
				
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_other_political_details");	
				var other_politics=XMLAddress1[0].childNodes[0].nodeValue;
				
				
				val=0;
				count=0;
				politics=new Array();
				
				for(var i=0;i<=other_politics.length;i++)
				{
					
					if(other_politics[i]=='$')
					{
						//politics[count]=other_politics.substring(val,i);
						politics[count]="";
						val=i+1;					
						++count;
						
					}
					if(i==other_politics.length)
						politics[count]=other_politics.substring(val,i);					
					
				}
		
				for(var loop=0;loop<politics.length;loop++)
				{
					document.getElementById('ele'+(loop+1)).value=politics[loop];				
				}
	
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("dte_date");				
				document.getElementById('date').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("received_job");
				
				
				if(XMLAddress1[0].childNodes[0].nodeValue>0)
				{				
					document.getElementById('job').checked= true;
					document.getElementById('tb_job').style.visibility='visible';
				}
				else
				{
				
					document.getElementById('job').checked= false;
				}
				
				
				
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_name");				
				document.getElementById('name').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_prev_district");
				//alert(XMLAddress1[0].childNodes[0].nodeValue);
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("int_prev_district");
					 document.getElementById("town").options[document.getElementById("town").options[XMLAddress1[0].childNodes[0].nodeValue].value].selected = true;	//selected Value
					 document.getElementById("town").remove(document.getElementById("town").selectedIndex);		
			  
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_prev_district");			
					opt.text=XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("int_prev_district");			
					opt.value=XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
					document.getElementById("town").options.add(opt);				
					document.getElementById("town").options[(document.getElementById("town").length-1)].selected = true;
					
				}
				
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("plkDSDN");
				
				document.getElementById("plks").innerHTML=XMLAddress1[0].childNodes[0].nodeValue;
				
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("gramasewa_division");
				
				document.getElementById("grvs").innerHTML=XMLAddress1[0].childNodes[0].nodeValue;
				
			/*	
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_sex");				
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
					text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();		
					//alert(text);
					addsex(document.getElementById("sex"),text);		//Removed Selected Value
					//alert("ok");
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_sex");
					
					opt.text = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase(); 	
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_sex");
					opt.value = XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();					
					document.getElementById("sex").options.add(opt);			 
					document.getElementById("sex").options[(document.getElementById("sex").length-1)].selected = true;
				}*/
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_sex");			
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{				
					var opt = document.createElement("option");	
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_sex");					
					opt.text=XMLAddress1[0].childNodes[0].nodeValue;
					
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_sex");		
					var ins=XMLAddress1[0].childNodes[0].nodeValue;
					opt.value=XMLAddress1[0].childNodes[0].nodeValue;
					
					for(var loop=0;loop <document.getElementById("sex").length;loop++ )
					{
						if(document.getElementById("sex").options[loop].value==ins)
						{
							document.getElementById("sex").options[loop].selected = true;
							break;
						}
						

					}
					
				}

					
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("dte_dob");				
					document.getElementById('dte_birthday').value= XMLAddress1[0].childNodes[0].nodeValue;
					
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_other_qualification");				
					document.getElementById('other_qualification').value= XMLAddress1[0].childNodes[0].nodeValue;
					
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("get_action");				
					document.getElementById('get_action').value= XMLAddress1[0].childNodes[0].nodeValue;
					
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("check_ol");	
					if(XMLAddress1[0].childNodes[0].nodeValue>0)
					{
						
						document.getElementById('ol').checked= true;
					}
					else
					{
						document.getElementById('ol').checked= false;
					}
				
					
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("check_al");
					if(XMLAddress1[0].childNodes[0].nodeValue>0)
					{
						
						document.getElementById('al').checked= true;
					}
					else
					{
						document.getElementById('al').checked= false;
					}
					
					
					
					
				//XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("institute");				
				//document.getElementById('institute').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("institute");			
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{				
					var opt = document.createElement("option");	
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("institute");	
					var ins=XMLAddress1[0].childNodes[0].nodeValue;
					opt.text=XMLAddress1[0].childNodes[0].nodeValue;
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("institute");			
					opt.value=XMLAddress1[0].childNodes[0].nodeValue;
					
					for(var loop=0;loop <document.getElementById("organization").length;loop++ )
					{
						if(document.getElementById("organization").options[loop].value==ins)
						{
							document.getElementById("organization").options[loop].selected = true;
							break;
						}
						

					}
					
				}
				
			//	XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("post");				
			//	document.getElementById('post').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("post");			
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{					
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("post");
					var po=XMLAddress1[0].childNodes[0].nodeValue;
					opt.text=XMLAddress1[0].childNodes[0].nodeValue;
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("post");			
					opt.value=XMLAddress1[0].childNodes[0].nodeValue;
					
					for(var loop=0;loop <document.getElementById("designation").length;loop++ )
					{
						if(document.getElementById("designation").options[loop].value==po)
						{
							document.getElementById("designation").options[loop].selected = true;
							break;
						}
						

					}
					
				}
				
		/*		XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("plkDSD_N");
			
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
				
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("plkDSD_N");			
					opt.text=XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("plkDSD_N");			
					opt.value=XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
					document.getElementById("plk").options.add(opt);		
					if(document.getElementById("plk").length>1)
					{
					document.getElementById("plk").options[(document.getElementById("plk").length-1)].selected = true;
					}
					else
					{
						document.getElementById("plk").options[0].selected = true;
					}
				}*/
				
			/*	XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("grvGND_N");		
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{
				//	alert(document.getElementById("grv").length);
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("grvGND_N");			
					opt.text=XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("grvGND_N");			
					opt.value=XMLAddress1[0].childNodes[0].nodeValue.toUpperCase();
					document.getElementById("grv").options.add(opt);		
					if(document.getElementById("grv").length>1)
					{
					document.getElementById("grv").options[(document.getElementById("grv").length-1)].selected = true;
					}
					else
					{
						document.getElementById("grv").options[0].selected = true;
					}
				}
				
				*/
		
				}
				

		
			}
		
}


function change_jobs()
{
	if(document.getElementById('job').checked==true)
	{
		
		document.getElementById('tb_job').style.visibility='visible';
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
					
		var url="jobdata.php";		
		url=url+"?Command="+"changejob";	
		url=url+"&nic="+document.getElementById('nic').value;
		
		xmlHttp.onreadystatechange=prints_job;		
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null)
	}
	else
	{
		
		
	//	document.getElementById('institute').value="";
	//	document.getElementById('post').value="";
		document.getElementById('tb_job').style.visibility='hidden';
	}
}

function clearform()
	{	
		setTimeout("location.reload(true);",4000);
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


function show_job_details(id)
{
	
	//	clear_data();
		xmlHttp2=GetXmlHttpObject();
		if (xmlHttp2==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="get_job_details.php";		
			url=url+"?Command="+"Search_details";
			
			url=url+"&id="+id;			
			xmlHttp2.onreadystatechange=getsearchResult;
			xmlHttp2.open("GET",url,true);
			xmlHttp2.send(null);
		
}




function getsearchResult()
{
	var XMLAddress1;
	
		if (xmlHttp2.readyState==4 || xmlHttp2.readyState=="complete")
		{ 	
		
			//	alert(xmlHttp2.responseText);
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("int_job_id");				
				var val= XMLAddress1[0].childNodes[0].nodeValue;
				
				if(val=="invalied")
				{					
					document.getElementById("nic").focus();
					document.getElementById("err_nic").innerHTML="Invalied NIC Number";
					
				}
				else
				{
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("int_job_id");				
				document.getElementById('id').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("referance_no");				
				//document.getElementById('referance_no').value= XMLAddress1[0].childNodes[0].nodeValue;
				var name=XMLAddress1[0].childNodes[0].nodeValue;				
				for(var i=0;i<name.length;i++)
				{					
					if(name[i]=='@')
					{		
						name=name.replace("@","'")
					}
				}			
				document.getElementById('referance_no').value= name;
				
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_nic");				
				document.getElementById('nic').value= XMLAddress1[0].childNodes[0].nodeValue;
						
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_name");				
			//	document.getElementById('name').value= XMLAddress1[0].childNodes[0].nodeValue;
				var name=XMLAddress1[0].childNodes[0].nodeValue;				
				for(var i=0;i<name.length;i++)
				{					
					if(name[i]=='@')
					{		
						name=name.replace("@","'")
					}
				}			
				document.getElementById('name').value= name;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_address");				
			//	document.getElementById('address').value= XMLAddress1[0].childNodes[0].nodeValue;
			
				var name=XMLAddress1[0].childNodes[0].nodeValue;				
				for(var i=0;i<name.length;i++)
				{					
					if(name[i]=='@')
					{		
						name=name.replace("@","'")
					}
				}			
				document.getElementById('address').value= name;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_sex");			
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{				
					var opt = document.createElement("option");	
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_sex");					
					opt.text=XMLAddress1[0].childNodes[0].nodeValue;
					
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_sex");		
					var ins=XMLAddress1[0].childNodes[0].nodeValue;
					opt.value=XMLAddress1[0].childNodes[0].nodeValue;
					
					for(var loop=0;loop <document.getElementById("sex").length;loop++ )
					{
						if(document.getElementById("sex").options[loop].value==ins)
						{
							document.getElementById("sex").options[loop].selected = true;
							break;
						}
						

					}
					
				}
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("dte_dob");				
				document.getElementById('dte_birthday').value= XMLAddress1[0].childNodes[0].nodeValue;
	
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_education");			
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{				
					var opt = document.createElement("option");	
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_education");					
					opt.text=XMLAddress1[0].childNodes[0].nodeValue;
					
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_education");		
					var ins=XMLAddress1[0].childNodes[0].nodeValue;
					opt.value=XMLAddress1[0].childNodes[0].nodeValue;
					
					for(var loop=0;loop <document.getElementById("education").length;loop++ )
					{
						if(document.getElementById("education").options[loop].value==ins)
						{
							document.getElementById("education").options[loop].selected = true;
							break;
						}
						

					}
					
				}
				
					
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_other_qualification");				
			//	document.getElementById('other_qualification').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				var name=XMLAddress1[0].childNodes[0].nodeValue;				
				for(var i=0;i<name.length;i++)
				{					
					if(name[i]=='@')
					{		
						name=name.replace("@","'")
					}
				}			
				document.getElementById('other_qualification').value= name;
				

				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_tel");				
				document.getElementById('telno').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_politics_approvel");				
			//	document.getElementById('political_approve').value= XMLAddress1[0].childNodes[0].nodeValue;
				
								
				var name=XMLAddress1[0].childNodes[0].nodeValue;				
				for(var i=0;i<name.length;i++)
				{					
					if(name[i]=='@')
					{		
						name=name.replace("@","'")
					}
				}			
				document.getElementById('political_approve').value= name;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_join_politics");	
				var str_join_politics=XMLAddress1[0].childNodes[0].nodeValue;				
												
				for(var i=0;i<str_join_politics.length;i++)
				{					
					if(str_join_politics[i]=='@')
					{		
						str_join_politics=str_join_politics.replace("@","'")
					}
				}			
			
				var val=0;
				var count=0;
				var politics=new Array();
				var string="";
				for(var i=0;i<=str_join_politics.length;i++)
				{
					
					//alert(str_join_politics[i]);
					if(str_join_politics[i]=='$')
					{
					
						politics[count]=string;					
						val=i+1;					
						++count;
						string="";
						
					}
					else
					{
					//	alert(string);
						string+=str_join_politics[i];
					}
					if(i==str_join_politics.length)						
						politics[count]=str_join_politics.substring(val,i);		
					
					
				}
		
				for(var loop=0;loop<politics.length;loop++)
				{
					document.getElementById('detail'+(loop+1)).value=politics[loop];				
				}
				
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_other_political_details");	
				var other_politics=XMLAddress1[0].childNodes[0].nodeValue;
				
				for(var i=0;i<other_politics.length;i++)
				{					
					if(other_politics[i]=='@')
					{		
						other_politics=other_politics.replace("@","'")
					}
				}			
			
				
				
				val=0;
				count=0;
				politics=new Array();
				var string="";
				for(var i=0;i<=other_politics.length;i++)
				{
					
					if(other_politics[i]=='$')
					{
						//politics[count]=other_politics.substring(val,i);
						politics[count]=string;						
						val=i+1;					
						++count;
						string="";
						
					}
					else
					{					
						string+=other_politics[i];
					}
					if(i==other_politics.length)
						politics[count]=other_politics.substring(val,i);					
					
				}
		
				for(var loop=0;loop<politics.length;loop++)
				{
					document.getElementById('ele'+(loop+1)).value=politics[loop];				
				}
		
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("received_job");				
				
				if(XMLAddress1[0].childNodes[0].nodeValue>0)
				{				
					document.getElementById('job').checked= true;
					document.getElementById('tb_job').style.visibility='visible';
				}
				else
				{
				
					document.getElementById('job').checked= false;
				}
				
				if(document.getElementById('job').checked==false)
				{
					document.getElementById('tb_job').style.visibility='hidden';
				}
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("dte_date");				
				document.getElementById('date').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("came_reason");		
			//	alert(XMLAddress1[0].childNodes[0].nodeValue)
				document.getElementById('came_reason').value= XMLAddress1[0].childNodes[0].nodeValue;
				
					
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("get_action");				
				document.getElementById('get_action').value= XMLAddress1[0].childNodes[0].nodeValue;
				

				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_prev_district");		
			//	alert(XMLAddress1[0].childNodes[0].nodeValue)
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{				
					var opt = document.createElement("option");	
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_prev_district");						
					opt.text=XMLAddress1[0].childNodes[0].nodeValue;
					
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("int_prev_district");	
					var ins=XMLAddress1[0].childNodes[0].nodeValue;
					opt.value=XMLAddress1[0].childNodes[0].nodeValue;
					
					for(var loop=0;loop <document.getElementById("town").length;loop++ )
					{//alert("loop ="+document.getElementById("reason").options[loop].value +"  "+"ins ="+ins);
						if(document.getElementById("town").options[loop].value==ins)
						{
							document.getElementById("town").options[loop].selected = true;
							break;
						}
						

					}
					
				}
				
				
				
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("plkDSDN");				
				document.getElementById("plks").innerHTML=XMLAddress1[0].childNodes[0].nodeValue;
				
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("gramasewa_division");				
				document.getElementById("grvs").innerHTML=XMLAddress1[0].childNodes[0].nodeValue;
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("institute");			
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{				
					var opt = document.createElement("option");	
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("institute");	
					var ins=XMLAddress1[0].childNodes[0].nodeValue;
					opt.text=XMLAddress1[0].childNodes[0].nodeValue;
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("institute");			
					opt.value=XMLAddress1[0].childNodes[0].nodeValue;
					
					for(var loop=0;loop <document.getElementById("organization").length;loop++ )
					{
						if(document.getElementById("organization").options[loop].value==ins)
						{
							document.getElementById("organization").options[loop].selected = true;
							break;
						}
						

					}
					
				}
			
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("post");			
				if(XMLAddress1[0].childNodes[0].nodeValue!="")
				{					
					var opt = document.createElement("option");
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("post");
					var po=XMLAddress1[0].childNodes[0].nodeValue;
					opt.text=XMLAddress1[0].childNodes[0].nodeValue;
					XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("post");			
					opt.value=XMLAddress1[0].childNodes[0].nodeValue;
					
					for(var loop=0;loop <document.getElementById("designation").length;loop++ )
					{
						if(document.getElementById("designation").options[loop].value==po)
						{
							document.getElementById("designation").options[loop].selected = true;
							break;
						}
						

					}
					
				}
				
				
							
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("dte_insertdate");
			//	alert(XMLAddress1[0].childNodes[0].nodeValue);
				document.getElementById('datetime').value= XMLAddress1[0].childNodes[0].nodeValue;
				

		
		
				}
				

		
			}
		
}









	
