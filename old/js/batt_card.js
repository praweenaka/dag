function GetXmlHttpObject() {
	var xmlHttp = null;
	try {
		// Firefox, Opera 8.0+, Safari
		xmlHttp = new XMLHttpRequest();
	} catch (e) {
		// Internet Explorer
		try {
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}

function keyset(key, e) {

	if (e.keyCode == 13) {
		document.getElementById(key).focus();
	}
}

function keychange(key) {

	document.getElementById(key).focus();

}

function got_focus(key) {
	document.getElementById(key).style.backgroundColor = "#000066";

}

function lost_focus(key) {
	document.getElementById(key).style.backgroundColor = "#000000";

}

function close_form() {
	self.close();
}

function new_inv() {
	document.getElementById('cuscode').value = "";
	document.getElementById('cusname').value = "";
	document.getElementById('cus_address').value = "";
	document.getElementById('cus_address1').value = "";
	document.getElementById('txtstk_no').value = "";
	document.getElementById('txtdes').value = "";
	document.getElementById('txtbrand').value = "";
	document.getElementById('txtpatt').value = "";
	document.getElementById('txtseri_no').value = "";
	document.getElementById('inv_no').value = "";
	document.getElementById('inv_dt').value = "";
	
}

function save_inv1() {
	xmlHttp = GetXmlHttpObject();
	if (xmlHttp == null) {
		alert("Browser does not support HTTP Request");
		return;
	}

	var url = "batt_card_data.php";
	url = url + "?Command=" + "save";
	url = url + "&cuscode=" + document.getElementById('cuscode').value;
	url = url + "&cusname=" + document.getElementById('cusname').value;
	url = url + "&cusadd=" + document.getElementById('cus_address').value;
	url = url + "&cusadd1=" + document.getElementById('cus_address1').value;
	url = url + "&txtstk_no=" + document.getElementById('txtstk_no').value;
	url = url + "&txtdes=" + document.getElementById('txtdes').value;
	url = url + "&txtbrand=" + document.getElementById('txtbrand').value;
	url = url + "&txtpatt=" + document.getElementById('txtpatt').value;
	url = url + "&txtseri_no=" + document.getElementById('txtseri_no').value;
	url = url + "&inv_no=" + document.getElementById('inv_no').value;
	url = url + "&inv_dt=" + document.getElementById('inv_dt').value;

	xmlHttp.onreadystatechange = save_customer_result;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);

}

function view() {
	NewWindow('serach_batt.php', 'mywin', '800', '700', 'yes', 'center');
	return false;
}

function save_customer_result() {
	var XMLAddress1;

	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		alert(xmlHttp.responseText);
	}
}

function update_list(stname) {
	xmlHttp = GetXmlHttpObject();
	if (xmlHttp == null) {
		alert("Browser does not support HTTP Request");
		return;
	}

	var url = "batt_card_data.php";
	url = url + "?Command=" + "update_list";
	url = url + "&invno=" + document.getElementById('invno').value;

	xmlHttp.onreadystatechange = save_customer_result1;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);

}

function save_customer_result1() {
	var XMLAddress1;

	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		document.getElementById('bank_table').innerHTML=xmlHttp.responseText;
	}
}

function pass_bat(stname) {
	xmlHttp = GetXmlHttpObject();
	if (xmlHttp == null) {
		alert("Browser does not support HTTP Request");
		return;
	}

	var url = "batt_card_data.php";
	url = url + "?Command=" + "pass_bat";
	url = url + "&invno=" + stname;

	xmlHttp.onreadystatechange = save_customer_result2;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);

}


function save_customer_result2() {
	var XMLAddress1;
////	'cuscode, CUSNAME, MODEL, PARTNO,BRAND,batchNo,BATNO,INVNO,INVDATE'
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cuscode");	
		opener.document.form1.cuscode.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUSNAME");	
		opener.document.form1.cusname.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("MODEL");	
		opener.document.form1.txtstk_no.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PARTNO");	
		opener.document.form1.txtdes.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BRAND");	
		opener.document.form1.txtbrand.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("batchNo");	
		opener.document.form1.txtpatt.value  = XMLAddress1[0].childNodes[0].nodeValue;		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BATNO");	
		opener.document.form1.txtseri_no.value  = XMLAddress1[0].childNodes[0].nodeValue;	
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("INVNO");	
		opener.document.form1.inv_no.value  = XMLAddress1[0].childNodes[0].nodeValue;	
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("INVDATE");	
		opener.document.form1.inv_dt.value  = XMLAddress1[0].childNodes[0].nodeValue;		
                
                
                XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");	
		opener.document.form1.cus_address.value  = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");	
		opener.document.form1.cus_address1.value  = XMLAddress1[0].childNodes[0].nodeValue;
                
                
		self.close();
	}
}


function upseri(stname) {
	xmlHttp = GetXmlHttpObject();
	if (xmlHttp == null) {
		alert("Browser does not support HTTP Request");
		return;
	}

	var url = "batt_card_data.php";
	url = url + "?Command=" + "upseri";
	url = url + "&invno=" + document.getElementById('recno').value;

	xmlHttp.onreadystatechange = save_customer_results;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);

}

function save_customer_results() {
	var XMLAddress1;

	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
	}
}


function view_seri(stname) {
	xmlHttp = GetXmlHttpObject();
	if (xmlHttp == null) {
		alert("Browser does not support HTTP Request");
		return;
	}

	var url = "batt_card_data.php";
	url = url + "?Command=" + "view_seri";
	url = url + "&invno=" + stname;

	xmlHttp.onreadystatechange = pview_seri;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);

}


function pview_seri() {
	var XMLAddress1;
////	'cuscode, CUSNAME, MODEL, PARTNO,BRAND,batchNo,BATNO,INVNO,INVDATE'
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cuscode");	
		opener.document.form1.cuscode.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUSNAME");	
		opener.document.form1.cusname.value  = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");	
		opener.document.form1.cus_address.value  = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");	
		opener.document.form1.cus_address1.value  = XMLAddress1[0].childNodes[0].nodeValue;
				
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("MODEL");	
		opener.document.form1.txtstk_no.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PARTNO");	
		opener.document.form1.txtdes.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BRAND");	
		opener.document.form1.txtbrand.value  = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("batchNo");	
		opener.document.form1.txtpatt.value  = XMLAddress1[0].childNodes[0].nodeValue;		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BATNO");	
		opener.document.form1.txtseri_no.value  = XMLAddress1[0].childNodes[0].nodeValue;	
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("INVNO");	
		opener.document.form1.inv_no.value  = XMLAddress1[0].childNodes[0].nodeValue;	
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("INVDATE");	
		opener.document.form1.inv_dt.value  = XMLAddress1[0].childNodes[0].nodeValue;		
		self.close();
	}
}

