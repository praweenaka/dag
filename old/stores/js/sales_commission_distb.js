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

function grnhistory()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
	//var ans=confirm("Block Modifications");
	
		
			var url="sales_commission_data.php";			
			url=url+"?Command="+"grnhistory";
			url=url+"&txtpre="+document.getElementById('txtpre').value;
			url=url+"&txtNoCom_COm="+document.getElementById('txtNoCom_COm').value;
			
			//url=url+"&nosale="+document.getElementById('nosale').value;
			url=url+"&dtMonth="+document.getElementById('dtMonth').value;
			url=url+"&cmbrep="+document.getElementById('cmbrep').value;
			url=url+"&cmbdev="+document.getElementById('cmbdev').value;
			
			url=url+"&txtbalSAleTOT="+document.getElementById('txtbalSAleTOT').value;
			url=url+"&txtt2="+document.getElementById('txtt2').value;
			url=url+"&txtt1="+document.getElementById('txtt1').value;
			url=url+"&txtvat="+document.getElementById('txtvat').value;
			
			
			
			xmlHttp.onreadystatechange=assign_grnhistory;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function assign_grnhistory(){
	alert(xmlHttp.responseText);
	//location.reload(true);
	
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TypeGrid1");	
	document.getElementById('msgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	
	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
	document.getElementById('grngrid').value = XMLAddress1[0].childNodes[0].nodeValue;


	//document.getElementById('txtrefno').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}

function savegrn(){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
	
	
		
			var url="sales_commission_data.php";			
			url=url+"?Command="+"savegrn";
			
			var i=1;
			while (i<document.getElementById('grngrid').value){
				gtype="gtype"+i;
				grnno="grnno"+i;
				Commi="Commi"+i;
				commman="CommManu"+i;
				
				url=url+"&"+gtype+"="+document.getElementById(gtype).innerHTML;	
				url=url+"&"+grnno+"="+document.getElementById(grnno).innerHTML;	
				url=url+"&"+Commi+"="+document.getElementById(Commi).innerHTML;	
				url=url+"&"+commman+"="+document.getElementById(commman).value;	
				
				i=i+1;
			}
			url=url+"&grngrid="+document.getElementById('grngrid').value;
			
			alert(url);
			xmlHttp.onreadystatechange=assign_savegrn;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function assign_savegrn(){
	alert(xmlHttp.responseText);
	//location.reload(true);
	//document.getElementById('txtrefno').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}


function view_report()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
	var ans=confirm("Block Modifications");
	
		
			var url="sales_commission_data.php";			
			url=url+"?Command="+"view_report";
			url=url+"&txtpre="+document.getElementById('txtpre').value;
			url=url+"&txtNoCom_COm="+document.getElementById('txtNoCom_COm').value;
			url=url+"&nosale="+document.getElementById('nosale').value;
			url=url+"&dtMonth="+document.getElementById('dtMonth').value;
			url=url+"&cmbrep="+document.getElementById('cmbrep').value;
			url=url+"&cmbdev="+document.getElementById('cmbdev').value;
			url=url+"&txtbalSAleTOT="+document.getElementById('txtbalSAleTOT').value;
			url=url+"&txtt2="+document.getElementById('txtt2').value;
			url=url+"&txtt1="+document.getElementById('txtt1').value;
			url=url+"&txtvat="+document.getElementById('txtvat').value;
			
			
			
			xmlHttp.onreadystatechange=assign_view_report;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function assign_view_report(){
	alert(xmlHttp.responseText);
	//location.reload(true);
	//document.getElementById('txtrefno').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}
function com_lock()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
	var ans=confirm("Block Modifications");
	
		
			var url="sales_commission_data.php";			
			url=url+"?Command="+"com_lock";
			url=url+"&dtMonth="+document.getElementById('dtMonth').value;
			url=url+"&cmbrep="+document.getElementById('cmbrep').value;
			url=url+"&cmbdev="+document.getElementById('cmbdev').value;
			
			alert(url);
			xmlHttp.onreadystatechange=assign_com_lock;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function assign_com_lock(){
	alert(xmlHttp.responseText);
	//location.reload(true);
	//document.getElementById('txtrefno').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}

function com_unlock()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
	var ans=confirm("Block Modifications");
	
		
			var url="sales_commission_data.php";			
			url=url+"?Command="+"com_unlock";
			url=url+"&dtMonth="+document.getElementById('dtMonth').value;
			url=url+"&cmbrep="+document.getElementById('cmbrep').value;
			url=url+"&cmbdev="+document.getElementById('cmbdev').value;
			
			alert(url);
			xmlHttp.onreadystatechange=assign_com_unlock;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
}

function assign_com_unlock(){
	alert(xmlHttp.responseText);
	//location.reload(true);
	//document.getElementById('txtrefno').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}

function lock_advance()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
		
			var url="sales_commission_data.php";			
			url=url+"?Command="+"lock_advance";
			url=url+"&dtMonth="+document.getElementById('dtMonth').value;
			url=url+"&cmbdev="+document.getElementById('cmbdev').value;
			url=url+"&cmbrep="+document.getElementById('cmbrep').value;
			url=url+"&txtover60="+document.getElementById('txtover60').value;
			url=url+"&txtretcheq="+document.getElementById('txtretcheq').value;
			
			xmlHttp.onreadystatechange=assign_lock_advance;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_lock_advance(){
	alert(xmlHttp.responseText);
	//location.reload(true);
	//document.getElementById('txtrefno').value=xmlHttp.responseText;	
	//document.getElementById('searchcust2').focus();
	
}

function proces()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var paymethod;
			

		
		
			//document.getElementById('invdate').value=Date();
			
			var url="sales_commission_distb_data.php";			
			url=url+"?Command="+"proces";
			
			url=url+"&cmbrep="+document.getElementById('cmbrep').value;
			url=url+"&cmbdev="+document.getElementById('cmbdev').value;
			url=url+"&dtMonth="+document.getElementById('dtMonth').value;
			
				
	
			xmlHttp.onreadystatechange=assign_proces;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_proces(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		//document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;


		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Critaria_gridA11");	
		document.getElementById('Critaria_gridA11').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Critaria_gridA12");	
		document.getElementById('Critaria_gridA12').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Critaria_gridA21");	
		document.getElementById('Critaria_gridA21').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Critaria_gridA22");	
		document.getElementById('Critaria_gridA22').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Critaria_gridA31");	
		document.getElementById('Critaria_gridA31').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Critaria_gridA32");	
		document.getElementById('Critaria_gridA32').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Critaria_gridB11");	
		document.getElementById('Critaria_gridB11').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Critaria_gridB12");	
		document.getElementById('Critaria_gridB12').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Critaria_gridB21");	
		document.getElementById('Critaria_gridB21').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Critaria_gridB22");	
		document.getElementById('Critaria_gridB22').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Critaria_gridB31");	
		document.getElementById('Critaria_gridB31').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Critaria_gridB32");	
		document.getElementById('Critaria_gridB32').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA11");	
		document.getElementById('Sales_gridA11').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA21");	
		document.getElementById('Sales_gridA21').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA31");	
		document.getElementById('Sales_gridA31').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA41");	
		document.getElementById('Sales_gridA41').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA11");	
		document.getElementById('Sales_gridA11').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA21");	
		document.getElementById('Sales_gridA21').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA31");	
		document.getElementById('Sales_gridA31').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB41");	
		document.getElementById('Sales_gridB41').value = XMLAddress1[0].childNodes[0].nodeValue;

///////////////////////////

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA12");	
		document.getElementById('Sales_gridA12').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA22");	
		document.getElementById('Sales_gridA22').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA32");	
		document.getElementById('Sales_gridA32').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA42");	
		document.getElementById('Sales_gridA42').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB12");	
		document.getElementById('Sales_gridB12').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB22");	
		document.getElementById('Sales_gridB22').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB32");	
		document.getElementById('Sales_gridB32').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB42");	
		document.getElementById('Sales_gridB42').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA13");	
		document.getElementById('Sales_gridA13').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA23");	
		document.getElementById('Sales_gridA23').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA33");	
		document.getElementById('Sales_gridA33').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA43");	
		document.getElementById('Sales_gridA43').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB13");	
		document.getElementById('Sales_gridB13').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB23");	
		document.getElementById('Sales_gridB23').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB33");	
		document.getElementById('Sales_gridB33').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB43");	
		document.getElementById('Sales_gridB43').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totsal_grid11");	
		document.getElementById('totsal_grid11').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totsal_grid21");	
		document.getElementById('totsal_grid21').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totsal_grid31");	
		document.getElementById('totsal_grid31').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totsal_grid41");	
		document.getElementById('totsal_grid41').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Ratio_grid11");	
		document.getElementById('Ratio_grid11').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Ratio_grid21");	
		document.getElementById('Ratio_grid21').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Ratio_grid31");	
		document.getElementById('Ratio_grid31').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA11");	
		document.getElementById('Sales_gridA11').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA21");	
		document.getElementById('Sales_gridA21').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA31");	
		document.getElementById('Sales_gridA31').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridA41");	
		document.getElementById('Sales_gridA41').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB11");	
		document.getElementById('Sales_gridB11').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB21");	
		document.getElementById('Sales_gridB21').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB21");	
		document.getElementById('Sales_gridB21').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB31");	
		document.getElementById('Sales_gridB31').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Sales_gridB41");	
		document.getElementById('Sales_gridB41').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXTADJ");	
		document.getElementById('TXTADJ').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtra_per");	
		document.getElementById('txtra_per').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Comm_grid11");	
		document.getElementById('Comm_grid11').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Comm_grid21");	
		document.getElementById('Comm_grid21').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Comm_grid31");	
		document.getElementById('Comm_grid31').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_cadv");	
		document.getElementById('txt_cadv').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_rded");	
		document.getElementById('txt_rded').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_adv");	
		document.getElementById('txt_adv').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_radv");	
		document.getElementById('txt_radv').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_ded");	
		document.getElementById('txt_ded').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_padv");	
		document.getElementById('txt_padv').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid11");	
		document.getElementById('Deduction_grid11').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid12");	
		document.getElementById('Deduction_grid12').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid13");	
		document.getElementById('Deduction_grid13').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid14");	
		document.getElementById('Deduction_grid14').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid15");	
		document.getElementById('Deduction_grid15').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid16");	
		document.getElementById('Deduction_grid16').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid17");	
		document.getElementById('Deduction_grid17').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid18");	
		document.getElementById('Deduction_grid18').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid21");	
		document.getElementById('Deduction_grid21').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid22");	
		document.getElementById('Deduction_grid22').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid23");	
		document.getElementById('Deduction_grid23').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid24");	
		document.getElementById('Deduction_grid24').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid25");	
		document.getElementById('Deduction_grid25').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid26");	
		document.getElementById('Deduction_grid26').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid27");	
		document.getElementById('Deduction_grid27').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Deduction_grid28");	
		document.getElementById('Deduction_grid28').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
	}
}


function view_summery()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
		
	var url="sales_commission_data.php";			
	url=url+"?Command="+"view_summery";
	url=url+"&dtMonth="+document.getElementById('dtMonth').value;
	
	url=url+"&cmbdev="+document.getElementById('cmbdev').value;
	url=url+"&cmbrep="+document.getElementById('cmbrep').value;
	url=url+"&txtRetChkAmou_D1="+document.getElementById('txtRetChkAmou_D1').value;
	url=url+"&txtRetChkAmou_Do="+document.getElementById('txtRetChkAmou_Do').value;
	url=url+"&txtvat="+document.getElementById('txtvat').value;
	url=url+"&txtt1="+document.getElementById('txtt1').value;
	url=url+"&txtt2="+document.getElementById('txtt2').value;

alert(url);
	xmlHttp.onreadystatechange=passcusresult_view_summery;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function passcusresult_view_summery(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		//document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;


		
		

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtt1");	
		document.getElementById('txtt1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtt2");	
		document.getElementById('txtt2').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtBalsale");	
		document.getElementById('txtBalsale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtnet");	
		document.getElementById('txtnet').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtnetsale");	
		document.getElementById('txtnetsale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtret");	
		document.getElementById('txtret').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtout");	
		document.getElementById('txtout').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtpaid");	
		document.getElementById('txtpaid').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtNocomm");	
		document.getElementById('txtNocomm').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtTotnet");	
		document.getElementById('txtTotnet').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtTOTNocom");	
		document.getElementById('txtTOTNocom').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtpre");	
		document.getElementById('txtpre').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat1sale");	
		document.getElementById('txtcat1sale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat1Spsale");	
		document.getElementById('txtcat1Spsale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat2sale");	
		document.getElementById('txtcat2sale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtTotnet");	
		document.getElementById('txtTotnet').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtBalsale");	
		document.getElementById('txtBalsale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtbalSAleTOT");	
		document.getElementById('txtbalSAleTOT').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("MSHFlexGrid1");	
		document.getElementById('MSHFlexGrid1').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
	
	}
}



function calculation()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
	var url="sales_commission_data.php";			
	url=url+"?Command="+"calculation";
	url=url+"&dtMonth="+document.getElementById('dtMonth').value;
	url=url+"&txtbalSAleTOT="+document.getElementById('txtbalSAleTOT').value;
	url=url+"&txtt1="+document.getElementById('txtt1').value;
	url=url+"&txtt2="+document.getElementById('txtt2').value;
	
	
	url=url+"&cmbdev="+document.getElementById('cmbdev').value;
	url=url+"&cmbrep="+document.getElementById('cmbrep').value;
	url=url+"&txtRetChkAmou_D1="+document.getElementById('txtRetChkAmou_D1').value;
	url=url+"&txtRetChkAmou_Do="+document.getElementById('txtRetChkAmou_Do').value;
	url=url+"&txtvat="+document.getElementById('txtvat').value;
	

alert(url);
	xmlHttp.onreadystatechange=passcusresult_calculation;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function passcusresult_calculation(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		//document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtComSale");	
		document.getElementById('txtComSale').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtComGRN");	
		document.getElementById('txtComGRN').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtComBal");	
		document.getElementById('txtComBal').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat1Com");	
		document.getElementById('txtcat1Com').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat1Spcomm");	
		document.getElementById('txtcat1Spcomm').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcat2com");	
		document.getElementById('txtcat2com').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdedamt1");	
		document.getElementById('txtdedamt1').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtNoCom_COm");	
		document.getElementById('txtNoCom_COm').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		

		
	}
	
}


function save_advance(){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
						
	var url="sales_commission_distb_data.php";			
	url=url+"?Command="+"save_advance";
	url=url+"&dtMonth="+document.getElementById('dtMonth').value;
	url=url+"&cmbrep="+document.getElementById('cmbrep').value;
	url=url+"&cmbdev="+document.getElementById('cmbdev').value;
	
	url=url+"&totsal_grid11="+document.getElementById('totsal_grid11').value;
	url=url+"&txt_ded="+document.getElementById('txt_ded').value;
	url=url+"&txt_chq_det="+document.getElementById('txt_chq_det').value;
	url=url+"&txt_radv="+document.getElementById('txt_radv').value;
	url=url+"&TXTADJ="+document.getElementById('TXTADJ').value;
	
	url=url+"&Deduction_grid11="+document.getElementById('Deduction_grid11').value;
	url=url+"&Deduction_grid21="+document.getElementById('Deduction_grid21').value;
	url=url+"&Deduction_grid31="+document.getElementById('Deduction_grid31').value;
	url=url+"&Deduction_grid41="+document.getElementById('Deduction_grid41').value;
	url=url+"&Deduction_grid51="+document.getElementById('Deduction_grid51').value;
	url=url+"&Deduction_grid61="+document.getElementById('Deduction_grid61').value;
	url=url+"&Deduction_grid71="+document.getElementById('Deduction_grid71').value;
	url=url+"&Deduction_grid81="+document.getElementById('Deduction_grid81').value;
	url=url+"&Deduction_grid21="+document.getElementById('Deduction_grid21').value;
	url=url+"&Deduction_grid22="+document.getElementById('Deduction_grid22').value;
	url=url+"&Deduction_grid32="+document.getElementById('Deduction_grid32').value;
	url=url+"&Deduction_grid42="+document.getElementById('Deduction_grid42').value;
	url=url+"&Deduction_grid52="+document.getElementById('Deduction_grid52').value;
	url=url+"&Deduction_grid62="+document.getElementById('Deduction_grid62').value;
	url=url+"&Deduction_grid72="+document.getElementById('Deduction_grid72').value;
	url=url+"&Deduction_grid82="+document.getElementById('Deduction_grid82').value;
	
	url=url+"&Ratio_grid11="+document.getElementById('Ratio_grid11').value;
	url=url+"&Ratio_grid21="+document.getElementById('Ratio_grid21').value;
	url=url+"&txtra_per="+document.getElementById('txtra_per').value;
	url=url+"&txt_rded="+document.getElementById('txt_rded').value;
	url=url+"&Sales_gridA11="+document.getElementById('Sales_gridA11').value;
	url=url+"&Sales_gridB11="+document.getElementById('Sales_gridB11').value;
	
	//url=url+"&C_RATEA="+document.getElementById('C_RATEA').value;
//	url=url+"&C_RATEB="+document.getElementById('C_RATEB').value;
//	
	url=url+"&Sales_gridA11="+document.getElementById('Sales_gridA11').value;
	url=url+"&Sales_gridA21="+document.getElementById('Sales_gridA21').value;
	url=url+"&Sales_gridA31="+document.getElementById('Sales_gridA31').value;
	url=url+"&Sales_gridA41="+document.getElementById('Sales_gridA41').value;
	
	url=url+"&Sales_gridB11="+document.getElementById('Sales_gridB11').value;
	url=url+"&Sales_gridB21="+document.getElementById('Sales_gridB21').value;
	url=url+"&Sales_gridB31="+document.getElementById('Sales_gridB31').value;
	url=url+"&Sales_gridB41="+document.getElementById('Sales_gridB41').value;
	
	url=url+"&totsal_grid21="+document.getElementById('totsal_grid21').value;
	url=url+"&totsal_grid31="+document.getElementById('totsal_grid31').value;
	url=url+"&t_salA="+document.getElementById('t_salA').value;
	url=url+"&t_salB="+document.getElementById('t_salB').value;
	

	

	xmlHttp.onreadystatechange=passcusresult_save_advance;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function passcusresult_save_advance(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		//document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;


		
		
		//print_advance();
		
	}
	
}


function print_advance(){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
						
	var url="rep_commadv_new.php";			
	url=url+"?Command="+"print_advance";
	url=url+"&cmbrep="+document.getElementById('cmbrep').value;
	url=url+"&dtMonth="+document.getElementById('dtMonth').value;
	
	url=url+"&Sales_gridA41="+document.getElementById('Sales_gridA41').value;
	url=url+"&Sales_gridB41="+document.getElementById('Sales_gridB41').value;
	url=url+"&Comm_grid11="+document.getElementById('Comm_grid11').value;
	url=url+"&Comm_grid21="+document.getElementById('Comm_grid21').value;
	url=url+"&Comm_grid31="+document.getElementById('Comm_grid31').value;
	url=url+"&Ratio_grid31="+document.getElementById('Ratio_grid31').value;
	url=url+"&TXTADJ="+document.getElementById('TXTADJ').value;
	url=url+"&txtra_per="+document.getElementById('txtra_per').value;
	url=url+"&txt_rded="+document.getElementById('txt_rded').value;
	url=url+"&txt_adv="+document.getElementById('txt_adv').value;
	url=url+"&txt_radv="+document.getElementById('txt_radv').value;
	
	url=url+"&Deduction_grid11="+document.getElementById('Deduction_grid11').value;
	url=url+"&Deduction_grid21="+document.getElementById('Deduction_grid21').value;
	url=url+"&Deduction_grid31="+document.getElementById('Deduction_grid31').value;
	url=url+"&Deduction_grid41="+document.getElementById('Deduction_grid41').value;
	url=url+"&Deduction_grid51="+document.getElementById('Deduction_grid51').value;
	url=url+"&Deduction_grid61="+document.getElementById('Deduction_grid61').value;
	url=url+"&Deduction_grid71="+document.getElementById('Deduction_grid71').value;
	url=url+"&Deduction_grid81="+document.getElementById('Deduction_grid81').value;
	
	window.open(url);

}


function allno(grnno)
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
	var url="utilization_data.php";			
	url=url+"?Command="+"pass_allno";
	url=url+"&grnno="+grnno;

//alert(url);
	xmlHttp.onreadystatechange=passcusresult_allno;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function passcusresult_allno(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
		//document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;


		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REFNO");	
		opener.document.form1.txtcrnno.value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BALANCE");	
		opener.document.form1.txtcrnamount.value = XMLAddress1[0].childNodes[0].nodeValue;
	
	self.close();
	

	}
		
		
}

function settle_inv()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="utilization_data.php";			
	url=url+"?Command="+"settle_inv";
	url=url+"&Txtcusco="+document.getElementById('Txtcusco').value;
						
	xmlHttp.onreadystatechange=settle_inv_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
			
}


function settle_inv_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function ret_chq_settle()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="utilization_data.php";			
	url=url+"?Command="+"ret_chq_settle";
	url=url+"&Txtcusco="+document.getElementById('Txtcusco').value;
						
	xmlHttp.onreadystatechange=ret_chq_settle_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
			
}


function ret_chq_settle_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function inv_btn()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="utilization_data.php";			
	url=url+"?Command="+"inv_btn";
	url=url+"&Txtcusco="+document.getElementById('Txtcusco').value;
						
	xmlHttp.onreadystatechange=inv_btn_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
			
}


function inv_btn_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
	}
}

function settlement()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="utilization_data.php";			
	url=url+"?Command="+"settlement";
	url=url+"&Txtcusco="+document.getElementById('Txtcusco').value;
						
	xmlHttp.onreadystatechange=settlement_result;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
			
}


function settlement_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
	}
}


function addchq_cash_rec()
{
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="ret_chq_settle_data.php";			
			url=url+"?Command="+"addchq_cash_rec";
			url=url+"&invno="+document.getElementById('invno').value;
			url=url+"&chqno="+document.getElementById('chqno').value;
			url=url+"&chqdate="+document.getElementById('chqdate').value;
			url=url+"&bank="+document.getElementById('bank').value;
			url=url+"&chqamt="+document.getElementById('chqamt').value;
			
			xmlHttp.onreadystatechange=addchq_cash_rec_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function addchq_cash_rec_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqtot");	
		document.getElementById('chqtot').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");	
		document.getElementById('chq_table').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chqbal");	
		document.getElementById('chq_balance1').value= XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('chqno').value="";
		document.getElementById('chqdate').value="";
		document.getElementById('bank').value="";
		document.getElementById('chqamt').value="";
		
		document.getElementById('chqno').focus();
		//document.getElementById('chq_table').innerHTML= xmlHttp.responseText;
		
	}
}



function keyset(key, e)
{	

   if(e.keyCode==13){
	document.getElementById(key).focus();
   }
}


function keysetvalue(key1, key2, key3, e)
{	
	
	
   if(e.keyCode==13){
	 //  alert("ok");
	document.getElementById(key2).value=document.getElementById(key1).value-document.getElementById(key3).value;   
	document.getElementById(key2).focus();
   }
}

function calc_bal_cash(overdue, cash_pay_next, chq_pay, inv_balance, cash_pay, e)
{	
	var overdue_v;
	var chq_pay_v;
	var cash_pay_v;
	
	
	if (isNaN(document.getElementById(overdue).value)==false){
		overdue_v=document.getElementById(overdue).value;
	} else {
		overdue_v=0;
	}
	
	if (isNaN(document.getElementById(chq_pay).value)==false){
		chq_pay_v=document.getElementById(chq_pay).value;
	} else {
		chq_pay_v=0;
	}
	
	if (isNaN(document.getElementById(cash_pay).value)==false){
		cash_pay_v=document.getElementById(cash_pay).value;
	} else {
		cash_pay_v=0;
	}
	
	
  if(e.keyCode==13){
	 //  alert("ok");
	document.getElementById(inv_balance).value=overdue_v-chq_pay_v-cash_pay_v;
	
	var mcou=document.getElementById("hiddencount").value;
	var i=1;
	var pay_tot=0;
	var pay_cash=0;
	var pay_cheq=0;
	var over=0;
	
	while (mcou>=i){
		
		var chq_pay_val="chq_pay"+i;
		var cash_pay_val="cash_pay"+i;
		var inv_balance_val="inv_balance"+i;
		
		if (isNaN(document.getElementById(chq_pay_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(chq_pay_val).value);
			pay_cheq=pay_cheq+Number(document.getElementById(chq_pay_val).value);
		}
		
		if (isNaN(document.getElementById(cash_pay_val).value)==false){
			pay_cash=pay_cash+Number(document.getElementById(cash_pay_val).value);
			pay_tot=pay_tot+Number(document.getElementById(cash_pay_val).value);
		}
		if (Number(document.getElementById(inv_balance_val).value)<0){
			over=over+Number(document.getElementById(inv_balance_val).value);
		}
		
		document.getElementById("cashtot").value=pay_cash;
		document.getElementById("txtpaytot").value=pay_tot;
		//alert(over);
				
		document.getElementById("txtoverpay").value=over;
		
		i=i+1;

	}
	document.getElementById(cash_pay_next).focus();
   }
 }
  


function calc_bal(overdue, chq_pay, inv_balance, chq_balance, chq_balance_next, cash_pay, i, e)
{	
	
	
 // alert(document.getElementById(overdue).value);
 	var overdue_v;
	var chq_pay_v;
	var cash_pay_v;
	
	
	if (isNaN(document.getElementById(overdue).value)==false){
		overdue_v=document.getElementById(overdue).value;
	} else {
		overdue_v=0;
	}
	
	
	if (isNaN(document.getElementById(chq_pay).value)==false){
		chq_pay_v=document.getElementById(chq_pay).value;
	} else {
		chq_pay_v=0;
	}
	

	if (isNaN(document.getElementById(cash_pay).value)==false){
		cash_pay_v=document.getElementById(cash_pay).value;
	} else {
		cash_pay_v=0;
	}
	
	document.getElementById(inv_balance).value=overdue_v-chq_pay_v-cash_pay_v;  
	
	document.getElementById(chq_balance_next).value=document.getElementById(chq_balance).value-document.getElementById(chq_pay).value;
	
	
	
	var mcou=document.getElementById("hiddencount").value;
	var i=1;
	var pay_tot=0;
	var over=0;
	
	while (mcou>=i){
		
		var chq_pay_val="chq_pay"+i;
		var cash_pay_val="cash_pay"+i;
		var inv_balance_val="inv_balance"+i;
		
		if (isNaN(document.getElementById(chq_pay_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(chq_pay_val).value);
		}
		if (isNaN(document.getElementById(cash_pay_val).value)==false){
			pay_tot=pay_tot+Number(document.getElementById(cash_pay_val).value);
		}
		
		if (Number(document.getElementById(inv_balance_val).value)<0){
			over=over+Number(document.getElementById(inv_balance_val).value);
		}
		
		document.getElementById("txtpaytot").value=pay_tot;
		document.getElementById("txtoverpay").value=over;
		
		i=i+1;

	}
	
		
/*	var j=1;
	var sel_inv_tot=0;
	while (j<=i){
		var chq_pay_all="chq_pay"+j;
		var cash_pay_all="cash_pay"+j;
		alert(document.getElementById(cash_pay_all).value);
		sel_inv_tot= sel_inv_tot+document.getElementById(chq_pay_all).value+document.getElementById(cash_pay_all).value;  
		//alert(sel_inv_tot);
		
		j=j+1;
	}
	
	document.getElementById('txtpaytot').value=sel_inv_tot;
	document.getElementById('txtoverpay').value=(document.getElementById('cashtot').value+document.getElementById('chqtot').value)-sel_inv_tot;*/
	//document.getElementById(key2).focus();
  } 


function got_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000066";
  
}

function lost_focus(key)
{	
	document.getElementById(key).style.backgroundColor="#000000";
  
}

function utilization()
{
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
	
			var url="ret_chq_settle_data.php";			
			url=url+"?Command="+"utilization";
			url=url+"&paytype="+document.getElementById('paytype').value;
			url=url+"&mcount="+document.getElementById('hiddencount').value;
			url=url+"&recno="+document.getElementById("invno").value;
			mcount=document.getElementById('hiddencount').value;
			
			var i=1;
			while (mcount > i){
				docno="docno"+i;
				docdate="docdate"+i;
				chqval="chqval"+i;
				chqno="chqno"+i;
				chqdate="chqdate"+i;
				retchqbal="retchqbal"+i;
				cash="cash"+i;
				balance="balance"+i;
				setamount="setamount"+i;
				chqbal="chqbal"+i;
				
				//if (isNaN(document.getElementById(chq_pay).value)==false){
					url=url+"&"+docno+"="+document.getElementById(docno).innerHTML;
					url=url+"&"+docdate+"="+document.getElementById(docdate).innerHTML;
					url=url+"&"+chqval+"="+document.getElementById(chqval).innerHTML;
					url=url+"&"+chqno+"="+document.getElementById(chqno).innerHTML;
					url=url+"&"+chqdate+"="+document.getElementById(chqdate).innerHTML;
				//}
				i=i+1;
			}
			
			//alert(url);
			xmlHttp.onreadystatechange=utilization_result;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
																																																 	
}

function utilization_result()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uti_table");	
		document.getElementById('utilization').innerHTML= XMLAddress1[0].childNodes[0].nodeValue;
		
	
		
	}
}


function delete_rec()
{
  var msg;
  msg=confirm("Are you sure to CANCEL this Reciept ! ");
  if (msg==true){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="ret_chq_settle_data.php";			
			url=url+"?Command="+"delete_rec";
			url=url+"&recno="+document.getElementById("invno").value;
			url=url+"&invdate="+document.getElementById("invdate").value;
			url=url+"&txtpaytot="+document.getElementById("txtpaytot").value;
			url=url+"&cuscode="+document.getElementById("cuscode").value;
			
	
		xmlHttp.onreadystatechange=result_delete_rec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
  }
}

function result_delete_rec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		setTimeout("location.reload(true);",500);
	}
}

function setTotal()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 
	
	var url="utilization_data.php";			
	url=url+"?Command="+"setTotal";
	xmlHttp.onreadystatechange=result_setTotal;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function result_setTotal()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
	}
}


function save_crec()
{
	
	//setTotal();
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var url="utilization_data.php";			
			url=url+"?Command="+"save_crec";
			url=url+"&txtrefno="+document.getElementById("txtrefno").value;
			url=url+"&dtdate="+document.getElementById("dtdate").value;
			url=url+"&chkcash="+document.getElementById("chkcash").checked;
			url=url+"&chkret="+document.getElementById("chkret").checked;
			url=url+"&chkinv="+document.getElementById("chkinv").checked;
			
			url=url+"&lblPaid="+document.getElementById("lblPaid").value;
					
			
			
			//alert(url);
			xmlHttp.onreadystatechange=result_save_crec;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
}

function result_save_crec()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		
	}
}

function update_list(stname)
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="ret_chq_settle_data.php";			
			url=url+"?Command="+"search_rec";
			url=url+"&mstatus="+stname;
			
			if (document.getElementById('recno').value!=""){
				
				url=url+"&mfield=recno";
				url=url+"&recno="+document.getElementById('recno').value;
				
			} else if (document.getElementById('recdate').value!=""){
				
				url=url+"&mfield=recdate";
				url=url+"&recdate="+document.getElementById('recdate').value;
				
			} else if (document.getElementById('recamt').value!=""){
				
				url=url+"&mfield=recamt";
				url=url+"&recamt="+document.getElementById('recamt').value;
				
			} else if (document.getElementById('reccus').value!=""){
				url=url+"&mfield=reccus";
				url=url+"&reccus="+document.getElementById('reccus').value;
			}
			
			//alert(url);
					
			xmlHttp.onreadystatechange=result_update_list;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function result_update_list()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert(xmlHttp.responseText);
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}

function recno(recno, stname)
{   
			
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="ret_chq_settle_data.php";			
			url=url+"?Command="+"pass_recno";
			url=url+"&recno="+recno;
			//alert(url);
					
			xmlHttp.onreadystatechange=result_recno;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		
	
}


function result_recno()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		//alert(xmlHttp.responseText);
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CA_REFNO");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
	//	alert(XMLAddress1[0].childNodes[0].nodeValue);
		opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
		//opener.document.form1.invno.value = "111111111";
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CA_DATE");
		opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CA_CODE");
		opener.document.form1.cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cusname");
		opener.document.form1.cusname.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CA_CASSH");
		opener.document.form1.cashtot.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CA_AMOUNT");
		opener.document.form1.chqtot.value = XMLAddress1[0].childNodes[0].nodeValue-opener.document.form1.cashtot.value;
		
				
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CA_SALESEX");	
		var objSalesrep = opener.document.getElementById("salesrep");
		
		var salesrep=XMLAddress1[0].childNodes[0].nodeValue;
		var i=0;
		while (i<objSalesrep.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("collectcode");	
		var objSalesrep = opener.document.getElementById("chqcollect");
		
		var salesrep=XMLAddress1[0].childNodes[0].nodeValue;
		var i=0;
		while (i<objSalesrep.length)
		{
			if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
			{
				objSalesrep.options[i].selected=true;
				
			}
			i=i+1;
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_table");
		window.opener.document.getElementById('chq_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uti_table");
		window.opener.document.getElementById('utilization').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		//window.opener.document.getElementById("test").innerHTML="TESTNBMSVMS"
		//opener.document.forminv.invno.value = "123";
		//myWindow.opener.document.invno.value = "123";
		self.close();
		//alert(myWindow.opener.document.getElementById('invno').value);
		//forminv.getElementById('invno').value="125";
		
		//setTimeout("location.reload(true);",500);
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");	
		//}
				
		//XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
		//document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		//document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}


function close_form()
{
	self.close();	
}