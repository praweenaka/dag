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

function keychange(key)
{	

	document.getElementById(key).focus();
  
}

function got_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000066";
  
}

function lost_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000000";
  
}

function chk_sales()
{
	document.getElementById('type').innerHTML="";
	document.getElementById('dev').innerHTML="<select name='cmbdev' id='cmbdev' class='text_purchase3'><option value='All'>All</option><option value='Manual'>Manual</option><option value='Computer'>Computer</option></select>";
	document.getElementById('summery').innerHTML="";
	document.getElementById('cashdis').innerHTML="";
	document.getElementById('svat').innerHTML="<input type='checkbox' name='chk_svat' id='chk_svat' />SVAT";
	document.getElementById('rectype').innerHTML="";
	document.getElementById('chkrettype').innerHTML="";
	
	
}

function chk_return()
{
	document.getElementById('type').innerHTML="<select name='cmbtype' id='cmbtype' class='text_purchase3'><option value='All'>All</option><option value='GRN'>GRN</option><option value='DGRN'>DGRN</option><option value='Credit Note'>Credit Note</option></select>";
	
	document.getElementById('dev').innerHTML="<select name='cmbdev' id='cmbdev' class='text_purchase3'><option value='All'>All</option><option value='Manual'>Manual</option><option value='Computer'>Computer</option></select>";
	document.getElementById('summery').innerHTML="";
	document.getElementById('cashdis').innerHTML="<input type='checkbox' name='chk_cash' id='chk_cash' />Cash Dis";
	document.getElementById('svat').innerHTML="";
	document.getElementById('rectype').innerHTML="";
	document.getElementById('chkrettype').innerHTML="";
	
	
}

function datehide()
{
	document.getElementById('dateto_name').innerHTML="";
	document.getElementById('dateto').innerHTML="";
}

function showtodate()
{
	document.getElementById('dateto_name').innerHTML="<input type='text'  class='label_purchase' value='To' disabled='disabled'/>";
	document.getElementById('dateto').innerHTML="<input type='text' size='20' name='dtto' id='dtto' value='' onfocus='load_calader('dtto')' class='text_purchase3'/>";
}

function tmp_crelimit()
{ 
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="search_custom_data.php";			
			url=url+"?Command="+"tmp_crelimit";
			url=url+"&Com_rep1="+document.getElementById('Com_rep1').value;
			url=url+"&txt_cuscode="+document.getElementById('txt_cuscode').value;
			url=url+"&cmbbrand1="+document.getElementById('cmbbrand1').value;
			url=url+"&txt_templimit="+document.getElementById('txt_templimit').value;
			//alert(url);
			
			if (document.getElementById('check1').checked==true)
			{
				var mcheck=1;
			} else {
				var mcheck=0;
			}
			url=url+"&check1="+mcheck;
			
				
			xmlHttp.onreadystatechange=result_tmp_crelimit;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function result_tmp_crelimit()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
	}
}

