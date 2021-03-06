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

function clear_customer() {
	location.reload();

}

function new_customer() {
	clear_customer();
}

function save_inv() {

	xmlHttp = GetXmlHttpObject();
	if (xmlHttp == null) {
		alert("Browser does not support HTTP Request");
		return;
	}
	//alert(inv_status);

	if (document.getElementById('txtrefno').value == "") {
		alert("Please Click New !!!");
	} else {

		var url = "chq_extend_data.php";
		url = url + "?Command=" + "save_item";

		url = url + "&txtrefno=" + document.getElementById('txtrefno').value;
		url = url + "&txtsdate=" + document.getElementById('txtsdate').value;

		url = url + "&txttime=" + document.getElementById('txttime').value;
		url = url + "&txtch_no=" + document.getElementById('txtch_no').value;
		url = url + "&txtcode=" + document.getElementById('txtcode').value;
		url = url + "&txtname=" + escape(document.getElementById('txtname').value);
		url = url + "&txtsal_ex=" + document.getElementById('txtsal_ex').value;
		url = url + "&txtch_amount=" + document.getElementById('txtch_amount').value;
		url = url + "&txtch_date=" + document.getElementById('txtch_date').value;
		url = url + "&txtchexdate=" + document.getElementById('txtchexdate').value;
		url = url + "&txtapproved=" + document.getElementById('txtapproved').value;
		url = url + "&Textposted=" + document.getElementById('Textposted').value;

		xmlHttp.onreadystatechange = salessaveresult;
		xmlHttp.open("GET", url, true);
		xmlHttp.send(null);

	}
}

function salessaveresult() {
	var XMLAddress1;

	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		if (xmlHttp.responseText == "no") {
			alert("Please Login Again !!!");
		} else {
			alert(xmlHttp.responseText);
			location.reload(true);
		}
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");
		//}

	}
}
function deny() {
	xmlHttp = GetXmlHttpObject();
	if (xmlHttp == null) {
		alert("Browser does not support HTTP Request");
		return;
	}

	if (document.getElementById('txtrefno').value == "") {
		alert("Please Select Cheque");
	} else {

		var url = "chq_extend_data.php";
		url = url + "?Command=" + "deny";

		url = url + "&txtrefno=" + document.getElementById('txtrefno').value;
		url = url + "&txtchexdate=" + document.getElementById('txtchexdate').value;

		xmlHttp.onreadystatechange = denyresult;
		xmlHttp.open("GET", url, true);
		xmlHttp.send(null);
	}
}

function denyresult() {
	var XMLAddress1;

	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		if (xmlHttp.responseText == "no") {
			alert("Please Login Again !!!");
		} else {
			alert(xmlHttp.responseText);
			location.reload(true);
		}
	}
}

function apprive() {
	xmlHttp = GetXmlHttpObject();
	if (xmlHttp == null) {
		alert("Browser does not support HTTP Request");
		return;
	}

	if (document.getElementById('txtrefno').value == "") {
		alert("Please Select Cheque");
	} else {

		var url = "chq_extend_data.php";
		url = url + "?Command=" + "apprive";

		url = url + "&txtrefno=" + document.getElementById('txtrefno').value;
		url = url + "&txtchexdate=" + document.getElementById('txtchexdate').value;
		url = url + "&ded=" + document.getElementById('ded').value;

		
		xmlHttp.onreadystatechange = appriveresult;
		xmlHttp.open("GET", url, true);
		xmlHttp.send(null);
	}
}

function appriveresult() {
	var XMLAddress1;

	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		if (xmlHttp.responseText == "no") {
			alert("Please Login Again !!!");
		} else {
			alert(xmlHttp.responseText);
			location.reload(true);
		}
	}
}

function acc_apprive() {
	xmlHttp = GetXmlHttpObject();
	if (xmlHttp == null) {
		alert("Browser does not support HTTP Request");
		return;
	}
	//alert(inv_status);

	if (document.getElementById('txtrefno').value == "") {
		alert("Please Select Cheque !!!");
	} else {
		var url = "chq_extend_data.php";
		url = url + "?Command=" + "acc_apprive";

		url = url + "&txtrefno=" + document.getElementById('txtrefno').value;
		url = url + "&txtch_no=" + document.getElementById('txtch_no').value;
		url = url + "&txtcode=" + document.getElementById('txtcode').value;
		url = url + "&txtch_date=" + document.getElementById('txtch_date').value;
		url = url + "&txtchexdate=" + document.getElementById('txtchexdate').value;

		xmlHttp.onreadystatechange = acc_appriveresult;
		xmlHttp.open("GET", url, true);
		xmlHttp.send(null);
	}
}

function acc_appriveresult() {
	var XMLAddress1;

	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		if (xmlHttp.responseText == "no") {
			alert("Please Login Again !!!");
		} else {
			alert(xmlHttp.responseText);
			location.reload(true);
		}
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");
		//}

	}
}

function acc_no() {
	xmlHttp = GetXmlHttpObject();
	if (xmlHttp == null) {
		alert("Browser does not support HTTP Request");
		return;
	}
	//alert(inv_status);

	if (document.getElementById('txtrefno').value == "") {
		alert("Please Select Cheque !!!");
	} else {

		var url = "chq_extend_data.php";
		url = url + "?Command=" + "acc_no";

		url = url + "&txtrefno=" + document.getElementById('txtrefno').value;

		xmlHttp.onreadystatechange = acc_noresult;
		xmlHttp.open("GET", url, true);
		xmlHttp.send(null);
	}
}

function acc_noresult() {
	var XMLAddress1;

	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		if (xmlHttp.responseText == "no") {
			alert("Please Login Again !!!");
		} else {
			alert(xmlHttp.responseText);
			location.reload(true);
		}
		//if (xmlHttp.responseText=="exist"){
		//	alert("Already Exists");
		//}

	}
}

function new_inv() {

	xmlHttp = GetXmlHttpObject();
	if (xmlHttp == null) {
		alert("Browser does not support HTTP Request");
		return;
	}

	document.getElementById('txtchexdate').disabled = false;

	document.getElementById('txtrefno').value = "";
	document.getElementById('txtch_no').value = "";
	document.getElementById('txtcode').value = "";
	document.getElementById('txtname').value = "";
	document.getElementById('txtsal_ex').value = "";
	document.getElementById('txtch_amount').value = "";
	document.getElementById('txtch_date').value = "";
	document.getElementById('txtapproved').value = "";
	document.getElementById('txttime').value = "";
	document.getElementById('txtchexdate').value = "";
	document.getElementById('Textposted').value = "";

	document.getElementById('itemdetails').innerHTML = "";

	
	document.getElementById('dedlb1').disabled=false;
	document.getElementById('ded').disabled=false;
	document.getElementById('ded').value = "--";
	
	var url = "chq_extend_data.php";
	url = url + "?Command=" + "new_inv";

	xmlHttp.onreadystatechange = assign_invno;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);

}

function assign_invno() {

	if (xmlHttp.responseText == "no") {
		alert("Please Login Again");
	} else {
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");
		document.getElementById('txtrefno').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("curdate");
		document.getElementById('txtsdate').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("curdate");
		document.getElementById('txtchexdate').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("curtime");
		document.getElementById('txttime').value = XMLAddress1[0].childNodes[0].nodeValue;
	}
	//document.getElementById('searchcust2').focus();

}

function close_form() {
	self.close();
}

function print_inv() {
	xmlHttp = GetXmlHttpObject();
	if (xmlHttp == null) {
		alert("Browser does not support HTTP Request");
		return;
	}

	var url = "report_chq_extn.php";
	//url=url+"?invno="+document.getElementById('invno').value;
	window.open(url);

}

