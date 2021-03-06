function GetXmlHttpObject()
	{
		var xmlHttp=null;
		var xmlHttp1=null;
		xmlHttp2=null;
		try
		 {
			 // Firefox, Opera 8.0+, Safari
			 xmlHttp1=new XMLHttpRequest();
			  xmlHttp2=new XMLHttpRequest();
		 }
		catch (e)
		 {
			 // Internet Explorer
			 try
			  {
				  xmlHttp1=new ActiveXObject("Msxml2.XMLHTTP");
				  xmlHttp2=new ActiveXObject("Msxml2.XMLHTTP");
			  }
			 catch (e)
			  {
				 xmlHttp1=new ActiveXObject("Microsoft.XMLHTTP");
				 xmlHttp2=new ActiveXObject("Microsoft.XMLHTTP");
			  }
		 }
		return xmlHttp1;
		return xmlHttp2;
}	


function get_plk()
{
	
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="plk.php";			
		url=url+"?Command="+"plk";
		url=url+"&districtid="+document.getElementById('town').value;		

		xmlHttp.onreadystatechange=showresult;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);

}


function showresult()
{
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
			
	//	alert(xmlHttp.responseText);
		document.getElementById("plks").innerHTML=xmlHttp.responseText;

			
		}
}







function get_plk2()
{
	
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="plkproject.php";			
		url=url+"?Command="+"plk";
		url=url+"&districtid="+document.getElementById('town2').value;		

		xmlHttp.onreadystatechange=showresult2;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);

}


function showresult2()
{
	var XMLAddress1;
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
			
	//	alert(xmlHttp.responseText);
		document.getElementById("plks2").innerHTML=xmlHttp.responseText;

			
		}
}



function get_grv(id)
{
		xmlHttp1=GetXmlHttpObject();
		if (xmlHttp1==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="grv.php";			
		url=url+"?Command="+"grv";
		url=url+"&plk="+id;		
		//alert(url);
		xmlHttp1.onreadystatechange=showresult1;
		xmlHttp1.open("GET",url,true);
		xmlHttp1.send(null);

}

function showresult1()
{
	var XMLAddress1;
	
		if (xmlHttp1.readyState==4 || xmlHttp1.readyState=="complete")
		{ 	
			
	//	alert(xmlHttp.responseText);
		document.getElementById("grvs").innerHTML=xmlHttp1.responseText;

			
		}
}


function get_grv2(id)
{
	
		xmlHttp1=GetXmlHttpObject();
		if (xmlHttp1==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 		
			
		var url="grv.php";			
		url=url+"?Command="+"grv";
		url=url+"&plk="+id;		
		//alert(url);
		xmlHttp1.onreadystatechange=showresults2;
		xmlHttp1.open("GET",url,true);
		xmlHttp1.send(null);

}

function showresults2()
{
	var XMLAddress1;
	
		if (xmlHttp1.readyState==4 || xmlHttp1.readyState=="complete")
		{ 	
			
	//	alert(xmlHttp.responseText);
		document.getElementById("grvs2").innerHTML=xmlHttp1.responseText;

			
		}
}


function loadfunc()
{
	get_plk();
	get_grv();
	search_jobsdata();
}





function search_jobsdata()
{
	

		xmlHttp2=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="jobdata.php";		
			url=url+"?Command="+"Search_details";
			url=url+"&nic="+document.getElementById('nic').value;
			xmlHttp2.onreadystatechange=getsearch_job_Result;
			xmlHttp2.open("GET",url,true);
			xmlHttp2.send(null);

		
}


function getsearch_job_Result()
{
	var XMLAddress1;
	
		if (xmlHttp2.readyState==4 || xmlHttp2.readyState=="complete")
		{ 	
		
		
				clear_data();
			//	alert(xmlHttp2.responseText);
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("str_nic");				
				var val= XMLAddress1[0].childNodes[0].nodeValue;
				
				if(val=="invalied")
				{					
					document.getElementById("nic").focus();
					document.getElementById("err_nic").innerHTML="Invalied NIC Number";
					
				}
				else
				{

				
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
					
					if(str_join_politics[i]=='/')
					{
						politics[count]=str_join_politics.substring(val,i);
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
					
					if(other_politics[i]=='/')
					{
						politics[count]=other_politics.substring(val,i);
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
				
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("institute");	
				//alert(XMLAddress1[0].childNodes[0].nodeValue);
				document.getElementById('institute').value= XMLAddress1[0].childNodes[0].nodeValue;
				
				
				XMLAddress1 = xmlHttp2.responseXML.getElementsByTagName("post");				
				document.getElementById('post').value= XMLAddress1[0].childNodes[0].nodeValue;
				
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
				
		
		
				}
				

		
			}
		
}






