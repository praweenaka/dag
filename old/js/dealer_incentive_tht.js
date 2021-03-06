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

function updateRemark(){
    	xmlHttp=GetXmlHttpObject();
        if (xmlHttp==null)
        {
                alert ("Browser does not support HTTP Request");
                return;
        }
    
        var url="dealer_incentive_data_tht.php";			
        url=url+"?Command="+"updateRemark";

        url=url+"&txtRemarkUpdate="+document.getElementById('txtRemarkUpdate').value;
        url=url+"&txt_cuscode="+document.getElementById('firstname_hidden').value;

        xmlHttp.onreadystatechange=updateRemark_process;
        xmlHttp.open("GET",url,true);
        xmlHttp.send(null);
}

function updateRemark_process(){
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
	alert(xmlHttp.responseText);
    }
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

function view()
{   
	alert("Waitting for result ...");
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			var paymethod;
			

		
		
			//document.getElementById('invdate').value=Date();
			
			var url="dealer_incentive_data_tht.php";			
			url=url+"?Command="+"proces";
			
			url=url+"&DTPicker1="+document.getElementById('DTPicker1').value;
			url=url+"&txt_cuscode="+document.getElementById('firstname_hidden').value;
			
			url=url+"&cmbtype="+document.getElementById('cmbtype').value;
			url=url+"&txt_percentage="+document.getElementById('txt_percentage').value;
			url=url+"&txt_vat="+document.getElementById('txt_vat').value;
			
				//alert(url);
	
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
		//document.getElementById('dealer_ins').innerHTML=xmlHttp.responseText;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TypeGrid1_count");	
		document.getElementById('mcount').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_vat");	
		document.getElementById('txt_vat').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("incen_table");	
		document.getElementById('dealer_ins').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtremark");	
		document.getElementById('txtremark').value = XMLAddress1[0].childNodes[0].nodeValue;
		document.getElementById('txtremark_new').value = "";
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtint");	
		document.getElementById('txtint').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_percentage");	
		document.getElementById('txt_percentage').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtnetin");	
		document.getElementById('txtnetin').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_chno");	
		document.getElementById('txt_chno').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_ignore");	
		var chq_ignore = XMLAddress1[0].childNodes[0].nodeValue;
		
		if (chq_ignore=="1"){
			document.getElementById('chq_ignore').checked=true;	
		} else {
			document.getElementById('chq_ignore').checked=false;		
		}
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txttot_inc");	
		document.getElementById('txttot_inc').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_tot");	
		document.getElementById('txt_tot').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_grn");	
		document.getElementById('txt_grn').value = XMLAddress1[0].childNodes[0].nodeValue;
		

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txttotal");	
		document.getElementById('txttotal').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_out");	
		document.getElementById('txt_out').value = XMLAddress1[0].childNodes[0].nodeValue;
		
                XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("incenRemark");	
		document.getElementById('txtRemarkUpdate').value = XMLAddress1[0].childNodes[0].nodeValue;
		
	}
}


function lock_data(){
	
	var msg = confirm("Do You Want Lock This Month ");
	
	if (msg == true) {
  		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 
		
		var url="dealer_incentive_data_tht.php";			
		url=url+"?Command="+"lock_data";
		
		var i=1;
		while(parseFloat(document.getElementById("mcount").value)>i){
			
			var cell_name_00="TypeGrid_"+i+"_00";
			url=url+"&"+cell_name_00+"="+document.getElementById(cell_name_00).innerHTML;	
			i=i+1;
		}
		alert(url);
		url=url+"&mcount="+document.getElementById("mcount").value;	
		xmlHttp.onreadystatechange=passcusresult_lock_data;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	} 
  		

}

function passcusresult_lock_data(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
		alert(xmlHttp.responseText);
	}
}

function calc1_table(mcount)
{
	
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
		
	var url="dealer_incentive_data_tht.php";			
	url=url+"?Command="+"calc1_table";
	
	var cell_name_03="TypeGrid_"+mcount+"_03";
	var cell_name_08="TypeGrid_"+mcount+"_08";
	var cell_name_09="TypeGrid_"+mcount+"_09";
	var cell_name_10="TypeGrid_"+mcount+"_10";
	var cell_name_13="TypeGrid_"+mcount+"_13";
	var cell_name_14="TypeGrid_"+mcount+"_14";
	
	url=url+"&TypeGrid08="+document.getElementById(cell_name_08).innerHTML;	
	url=url+"&TypeGrid09="+document.getElementById(cell_name_09).innerHTML;	
	url=url+"&TypeGrid10="+document.getElementById(cell_name_10).value;	
	url=url+"&TypeGrid13="+document.getElementById(cell_name_13).innerHTML;	
	url=url+"&TypeGrid14="+document.getElementById(cell_name_14).innerHTML;	
	url=url+"&txt_percentage="+document.getElementById("txt_percentage").value;	
	url=url+"&txt_vat="+document.getElementById("txt_vat").value;	
	url=url+"&txtint="+document.getElementById("txtint").value;	
	url=url+"&txttot_inc="+document.getElementById("txttot_inc").value;	
	
	url=url+"&mcount="+mcount;	
	//alert(url);
	xmlHttp.onreadystatechange=passcusresult_calc1_table;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
	
}

function passcusresult_calc1_table(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
		//alert(xmlHttp.responseText);
		

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");	
		var mcount = XMLAddress1[0].childNodes[0].nodeValue;
		
		var cell_name_13="TypeGrid_"+mcount+"_13";
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TypeGrid13");	
		document.getElementById(cell_name_13).innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txttot_inc");	
		document.getElementById("txttot_inc").value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtnetin");	
		document.getElementById("txtnetin").value = XMLAddress1[0].childNodes[0].nodeValue;
		
	}
}



function save_advance(){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
	
	var url='dealer_incentive_data_tht.php';	
	var params = 'Command=save_advance&mcount='+document.getElementById('mcount').value;
	params =params + '&DTPicker1='+document.getElementById('DTPicker1').value;
	params=params+"&txt_grn="+document.getElementById('txt_grn').value;
	params=params+"&txt_vat="+document.getElementById('txt_vat').value;
	params=params+"&txt_chno="+document.getElementById('txt_chno').value;
	
	var i=1;
	while (parseFloat(document.getElementById('mcount').value)>i){
		
		var cell_name_00="TypeGrid_"+i+"_00";
		var cell_name_03="TypeGrid_"+i+"_03";
		var cell_name_08="TypeGrid_"+i+"_08";
		var cell_name_09="TypeGrid_"+i+"_09";
		var cell_name_10="TypeGrid_"+i+"_10";
		var cell_name_13="TypeGrid_"+i+"_13";
		var cell_name_14="TypeGrid_"+i+"_14";
	
		params=params+"&"+cell_name_00+"="+document.getElementById(cell_name_00).innerHTML;
		
		params=params+"&"+cell_name_03+"="+document.getElementById(cell_name_03).innerHTML;
		params=params+"&"+cell_name_08+"="+document.getElementById(cell_name_08).innerHTML;
		params=params+"&"+cell_name_09+"="+document.getElementById(cell_name_09).innerHTML;
		params=params+"&"+cell_name_10+"="+document.getElementById(cell_name_10).value;
		params=params+"&"+cell_name_13+"="+document.getElementById(cell_name_13).innerHTML;
		params=params+"&"+cell_name_14+"="+document.getElementById(cell_name_14).innerHTML;
		
		i=i+1;
	}
	


	params=params+"&txtPrepare="+document.getElementById('txtPrepare').value;
	params=params+"&txt_cuscode="+document.getElementById('firstname_hidden').value;
	params=params+"&txtauth="+document.getElementById('txtauth').value;
	 
		
	myString=document.getElementById('firstname').value;
	myString = myString.replace(/&/g,"~");
	params=params+"&txt_cusname="+myString;
	
	params=params+"&txtremark="+document.getElementById('txtremark').value;
	params=params+"&txtremark_new="+document.getElementById('txtremark_new').value;
	params=params+"&txtnetin="+document.getElementById('txtnetin').value;
	params=params+"&txtint="+document.getElementById('txtint').value;
	params=params+"&txt_percentage="+document.getElementById('txt_percentage').value;
	params=params+"&cmbtype="+document.getElementById('cmbtype').value;
	params=params+"&chq_ignore="+document.getElementById('chq_ignore').checked;
	
	//alert(params)	;
	
	xmlHttp.open("POST", url, true);

	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.setRequestHeader("Content-length", params.length);
	xmlHttp.setRequestHeader("Connection", "close");
	
	xmlHttp.onreadystatechange=passcusresult_save_advance;
			
	xmlHttp.send(params);
			

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


function calculate_ins(){
	xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
						
	var url="dealer_incentive_data_tht.php";			
	var params ="Command="+"calculate_ins";
	
	params=params+"&mcount="+document.getElementById('mcount').value;
	params=params+"&DTPicker1="+document.getElementById('DTPicker1').value;
	params=params+"&txt_grn="+document.getElementById('txt_grn').value;
	params=params+"&txt_vat="+document.getElementById('txt_vat').value;
	params=params+"&txt_chno="+document.getElementById('txt_chno').value;
	
	var i=1;
	while (parseFloat(document.getElementById('mcount').value)>i){
		
		var cell_name_00="TypeGrid_"+i+"_00";
		var cell_name_03="TypeGrid_"+i+"_03";
		var cell_name_08="TypeGrid_"+i+"_08";
		var cell_name_09="TypeGrid_"+i+"_09";
		var cell_name_10="TypeGrid_"+i+"_10";
		var cell_name_13="TypeGrid_"+i+"_13";
		var cell_name_14="TypeGrid_"+i+"_14";
        var cell_name_15="TypeGrid_"+i+"_15";
        var cell_name_16="TypeGrid_"+i+"_16";
		params=params+"&"+cell_name_00+"="+document.getElementById(cell_name_00).innerHTML;
		
		params=params+"&"+cell_name_03+"="+document.getElementById(cell_name_03).innerHTML;
		params=params+"&"+cell_name_08+"="+document.getElementById(cell_name_08).innerHTML;
		params=params+"&"+cell_name_09+"="+document.getElementById(cell_name_09).innerHTML;
		params=params+"&"+cell_name_10+"="+document.getElementById(cell_name_10).value;
		params=params+"&"+cell_name_13+"="+document.getElementById(cell_name_13).innerHTML;
		params=params+"&"+cell_name_14+"="+document.getElementById(cell_name_14).innerHTML;
		params=params+"&"+cell_name_15+"="+document.getElementById(cell_name_15).innerHTML;
		params=params+"&"+cell_name_16+"="+document.getElementById(cell_name_16).innerHTML;
		i=i+1;
	}
	


	params=params+"&txtPrepare="+document.getElementById('txtPrepare').value;
	params=params+"&txt_cuscode="+document.getElementById('firstname_hidden').value;
	
	myString=document.getElementById('firstname').value;
	myString = myString.replace(/&/g,"~");
	params=params+"&txt_cusname="+myString;
	
	params=params+"&txtremark="+document.getElementById('txtremark').value;
	params=params+"&txtremark_new="+document.getElementById('txtremark_new').value;
	params=params+"&txtnetin="+document.getElementById('txtnetin').value;
	params=params+"&txtint="+document.getElementById('txtint').value;
	params=params+"&txt_percentage="+document.getElementById('txt_percentage').value;
	params=params+"&cmbtype="+document.getElementById('cmbtype').value;
	params=params+"&chq_ignore="+document.getElementById('chq_ignore').checked;
	
	xmlHttp.open("POST", url, true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
	xmlHttp.setRequestHeader("Connection", "close");
	xmlHttp.onreadystatechange=passcusresult_calculate_ins;
    xmlHttp.send(params);
    
}


function passcusresult_calculate_ins(){
	
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
	 
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_tot");	
		document.getElementById('txt_tot').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txttotal");	
		document.getElementById('txttotal').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txttot_inc");	
		document.getElementById('txttot_inc').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtnetin");	
		document.getElementById('txtnetin').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_percentage");	
		document.getElementById('txt_percentage').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TypeGrid1_count");	
		var TypeGrid1_count = XMLAddress1[0].childNodes[0].nodeValue;
		
		i=1;
		while (TypeGrid1_count>i){
			
			var TypeGrid13="TypeGrid_"+i+"_13";
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName(TypeGrid13);	
			//alert(XMLAddress1[0].childNodes[0].nodeValue);
			document.getElementById(TypeGrid13).innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
			i=i+1;
		}
		
		alert("ok");

		
		
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
	
	var url='dealer_incentive_data_tht.php';	
	var params = 'Command=print_advance';
						
	params=params+"&mcount="+document.getElementById('mcount').value;
	
	var i=1;
	while (parseFloat(document.getElementById('mcount').value)>i){
		
		var cell_name_01="TypeGrid_"+i+"_01";
		var cell_name_02="TypeGrid_"+i+"_02";
		var cell_name_03="TypeGrid_"+i+"_03";
		var cell_name_05="TypeGrid_"+i+"_05";
		var cell_name_07="TypeGrid_"+i+"_07";
		var cell_name_08="TypeGrid_"+i+"_08";
		var cell_name_09="TypeGrid_"+i+"_09";
		var cell_name_10="TypeGrid_"+i+"_10";
		var cell_name_13="TypeGrid_"+i+"_13";
		var cell_name_14="TypeGrid_"+i+"_14";
	
		params=params+"&"+cell_name_01+"="+document.getElementById(cell_name_01).innerHTML;
		params=params+"&"+cell_name_02+"="+document.getElementById(cell_name_02).innerHTML;
		params=params+"&"+cell_name_03+"="+document.getElementById(cell_name_03).innerHTML;
		params=params+"&"+cell_name_05+"="+document.getElementById(cell_name_05).innerHTML;
		params=params+"&"+cell_name_07+"="+document.getElementById(cell_name_07).innerHTML;
		params=params+"&"+cell_name_08+"="+document.getElementById(cell_name_08).innerHTML;
		params=params+"&"+cell_name_09+"="+document.getElementById(cell_name_09).innerHTML;
		params=params+"&"+cell_name_10+"="+document.getElementById(cell_name_10).value;
		params=params+"&"+cell_name_13+"="+document.getElementById(cell_name_13).innerHTML;
		params=params+"&"+cell_name_14+"="+document.getElementById(cell_name_14).innerHTML;
		
		i=i+1;
	}
	//alert(params);
	xmlHttp.open("POST", url, true);

			xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlHttp.setRequestHeader("Content-length", params.length);
			xmlHttp.setRequestHeader("Connection", "close");
			
			xmlHttp.onreadystatechange=passresult_print_advance;
			
			xmlHttp.send(params);
			
	//url=url+"&tot_sale="+document.getElementById('tot_sale').value;
	
	//url=url+"&tot_grn="+document.getElementById('tot_grn').value;
	
	

}

function passresult_print_advance(){
	//alert(xmlHttp.responseText);
	
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		
		xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
		
		var url='report_dealer_incentive.php';	
		url=url+"?mcount="+document.getElementById('mcount').value;
		
	url=url+"&txt_vat="+document.getElementById('txt_vat').value;
	url=url+"&txttotal="+document.getElementById('txttotal').value;
	url=url+"&txt_tot="+document.getElementById('txt_tot').value;
	
	url=url+"&txt_percentage="+document.getElementById('txt_percentage').value;
	url=url+"&DTPicker1="+document.getElementById('DTPicker1').value;
	url=url+"&txtnetin="+document.getElementById('txtnetin').value;
	
	url=url+"&txt_cuscode="+document.getElementById('firstname_hidden').value;
	
	myString=document.getElementById('firstname').value;
	myString = myString.replace(/&/g,"~");
	
	url=url+"&txt_cusname="+myString;
	url=url+"&txttot_inc="+document.getElementById('txttot_inc').value;
	alert(url);
	
	window.open(url);
	
	}
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