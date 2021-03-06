// JavaScript Document
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

function chk_number()
{
	//alert("ok");
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_rep_data.php";			
			url=url+"?Command="+"pass_repno";
			url=url+"&repno="+document.getElementById('txtcode').value;
			//url=url+"&stname="+stname;
			//alert(url);
					
			xmlHttp.onreadystatechange=passrepnoresult_ind;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function passrepnoresult_ind()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("repcode");	
		document.getElementById('txtcode').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("repname");	
		document.getElementById('txtname').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target");	
		document.getElementById('txttottar').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("group");	
		var group = XMLAddress1[0].childNodes[0].nodeValue;
		
		var objGroup = document.getElementById('cmb_group');
		var i=0;
		//objGroup.options[i].selected=true;
		
		while (i<objGroup.length)
		{
			if (group == objGroup.options[i].value)
			{
				objGroup.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cancel");	
		var cancel = XMLAddress1[0].childNodes[0].nodeValue;
		if (cancel=='1'){
			document.getElementById('chk_active').checked=true;
		} else {
			document.getElementById('chk_active').checked=false;	
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table");	
		document.getElementById('target').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table_s");	
		document.getElementById('target_s').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		//self.close();
		//opener.document.form1.salesrep.focus();
	}
}


function chk_number_results()
{
	var XMLAddress1;
	//alert(xmlHttp.responseText);
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
						
		//	document.getElementById("message").innerHTML=xmlHttp.responseText;
		//	setTimeout("location.reload(true);",1000);
			if (xmlHttp.responseText=="included"){
				alert("Already Included Stock No ! ");
				location.reload(true);
			}
			
			
		}
}

function update_rep_list(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_rep_data.php";			
			url=url+"?Command="+"search_inv";
			
			if (document.getElementById('repno').value!=""){
				url=url+"&mstatus=repno";
			} else if (document.getElementById('repname').value!=""){
				url=url+"&mstatus=repname";
			}
			
			url=url+"&repno="+document.getElementById('repno').value;
			url=url+"&repname="+document.getElementById('repname').value;
			url=url+"&stname="+stname;
			//alert(url);
					
			xmlHttp.onreadystatechange=showinvresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function showinvresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}

function repno(repno, stname)
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_rep_data.php";			
			url=url+"?Command="+"pass_repno";
			url=url+"&repno="+repno;
			url=url+"&stname="+stname;
			//alert(url);
					
			xmlHttp.onreadystatechange=passrepnoresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}


function passrepnoresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("repcode");	
		opener.document.form1.txtcode.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("repname");	
		opener.document.form1.txtname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target");	
		opener.document.form1.txttottar.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("group");	
		var group = XMLAddress1[0].childNodes[0].nodeValue;
		
		var objGroup = opener.document.form1.cmb_group;
		var i=0;
		//objGroup.options[i].selected=true;
		
		while (i<objGroup.length)
		{
			if (group == objGroup.options[i].value)
			{
				objGroup.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cancel");	
		var cancel = XMLAddress1[0].childNodes[0].nodeValue;
		
		if (cancel=='1'){
			opener.document.form1.chk_active.checked=false;
		} else {
			opener.document.form1.chk_active.checked=true;	
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table");	
		window.opener.document.getElementById('target').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table_s");	
		window.opener.document.getElementById('target_s').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		self.close();
		//opener.document.form1.salesrep.focus();
	}
}

function showtarget(cuscode, name, target)
{
	
	document.getElementById('txt_cuscode').value=cuscode;
	document.getElementById('txt_cusname').value=name;
	document.getElementById('txtdetar').value=target;
	
	
}

function showtarget_s(cuscode, name, target)
{
	
	document.getElementById('txt_cuscode_s').value=cuscode;
	document.getElementById('txt_cusname_s').value=name;
	document.getElementById('txtdetar_s').value=target;
	
	
}

function savetarget()
{
		
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_rep_data.php";			
			url=url+"?Command="+"savetarget";
			url=url+"&repno="+document.getElementById('txtcode').value;
			url=url+"&cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&name="+document.getElementById('txt_cusname').value;
			url=url+"&target="+document.getElementById('txtdetar').value;
			
			//alert(url);
					
			xmlHttp.onreadystatechange=savetarget_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}



function savetarget_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table");	
		document.getElementById('target').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('txt_cuscode').value = "";
		document.getElementById('txt_cusname').value = "";
		document.getElementById('txtdetar').value = "";
	}
}

function savetarget_s()
{
		
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_rep_data.php";			
			url=url+"?Command="+"savetarget_s";
			url=url+"&repno="+document.getElementById('txtcode').value;
			url=url+"&cuscode="+document.getElementById('txt_cuscode_s').value;
			url=url+"&name="+document.getElementById('txt_cusname_s').value;
			url=url+"&target="+document.getElementById('txtdetar_s').value;
			
			//alert(url);
					
			xmlHttp.onreadystatechange=savetarget_result_s;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function savetarget_result_s()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table");	
		document.getElementById('target_s').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('txt_cuscode_s').value = "";
		document.getElementById('txt_cusname_s').value = "";
		document.getElementById('txtdetar_s').value = "";
	}
}

function deletetarget()
{
		
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_rep_data.php";			
			url=url+"?Command="+"deletetarget";
			url=url+"&repno="+document.getElementById('txtcode').value;
			url=url+"&cuscode="+document.getElementById('txt_cuscode').value;
		//	url=url+"&name="+document.getElementById('txt_cusname').value;
		//	url=url+"&target="+document.getElementById('txtdetar').value;
			
			//alert(url);
					
			xmlHttp.onreadystatechange=deletetarget_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function deletetarget_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table");	
		document.getElementById('target').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('txt_cuscode').value = "";
		document.getElementById('txt_cusname').value = "";
		document.getElementById('txtdetar').value = "";
	}
}

function deletetarget_s()
{
		
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_rep_data.php";			
			url=url+"?Command="+"deletetarget_s";
			url=url+"&repno="+document.getElementById('txtcode').value;
			url=url+"&cuscode="+document.getElementById('txt_cuscode_s').value;
		//	url=url+"&name="+document.getElementById('txt_cusname').value;
		//	url=url+"&target="+document.getElementById('txtdetar').value;
			
			//alert(url);
					
			xmlHttp.onreadystatechange=deletetarget_result_s;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function deletetarget_result_s()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
	
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table");	
		document.getElementById('target_s').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('txt_cuscode_s').value = "";
		document.getElementById('txt_cusname_s').value = "";
		document.getElementById('txtdetar_s').value = "";
	}
}

function new_target()
{
	location.reload();
	
	document.getElementById('txtcode').focus();
}

function brand_target()
{
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_rep_data.php";			
			url=url+"?Command="+"brand_target";
			url=url+"&cmbbrand="+document.getElementById('cmbbrand').value;
			url=url+"&txtcode="+document.getElementById('txtcode').value;
			
			xmlHttp.onreadystatechange=brand_target_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function brand_target_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		document.getElementById('txttar').value=xmlHttp.responseText;
	}
}

function update_target()
{
		xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_rep_data.php";			
			url=url+"?Command="+"update_target";
			url=url+"&cmbbrand="+document.getElementById('cmbbrand').value;
			url=url+"&txtcode="+document.getElementById('txtcode').value;
			url=url+"&txttar="+document.getElementById('txttar').value;
			
			xmlHttp.onreadystatechange=update_target_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function update_target_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//document.getElementById('txttar').value=xmlHttp.responseText;
	}
}

function save_rep()
{
		xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_rep_data.php";			
			url=url+"?Command="+"save_rep";
			url=url+"&txtcode="+document.getElementById('txtcode').value;
			url=url+"&txtname="+document.getElementById('txtname').value;
			url=url+"&txttottar="+document.getElementById('txttottar').value;
			url=url+"&cmb_group="+document.getElementById('cmb_group').value;
			
			var act=0;
			if (document.getElementById('chk_active').checked==true){
				act=1;
			}else{
				act=0;
			}
			
			url=url+"&act="+act;
			
			xmlHttp.onreadystatechange=save_rep_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function save_rep_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//document.getElementById('txttar').value=xmlHttp.responseText;
	}
}


function deleterep()
{
	var msg=confirm("Are you sure to DELETE ? ");
  if (msg==true){
		xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_rep_data.php";			
			url=url+"?Command="+"deleterep";
			url=url+"&txtcode="+document.getElementById('txtcode').value;
			xmlHttp.onreadystatechange=deleterep_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
  }
}

function deleterep_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		setTimeout("location.reload(true);",500);
		//document.getElementById('txttar').value=xmlHttp.responseText;
	}
}