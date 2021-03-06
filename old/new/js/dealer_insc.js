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

function search() {

    $('#myModal_search').modal('show');
    search_cos('');

}



function search_cos() {

	xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "dealer_insc_data.php";
    url = url + "?Command=" + "search_cos";
    url = url + "&ccode=" + document.getElementById('ccode').value;
    url = url + "&month=" + document.getElementById('month').value;
    url = url + "&year=" + document.getElementById('year').value;
    url = url + "&remar=" + document.getElementById('remar').value;
    url = url + "&cheqno=" + document.getElementById('cheqno').value;
    url = url + "&typem=" + document.getElementById('typem').value;


    xmlHttp.onreadystatechange = showresultsearch;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showresultsearch() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        document.getElementById('search_res').innerHTML = xmlHttp.responseText;


    }
}



function get_cos(cdata) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "dealer_insc_data.php";
    url = url + "?Command=" + "get_cos";
    url = url + "&refno=" + cdata;

    xmlHttp.onreadystatechange = showresultgetcos;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}



function showresultgetcos() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        document.getElementById('msg_box').innerHTML = "";

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("remarks");
        document.getElementById('txt_remarks').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chno");
        document.getElementById('chqno').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cusCode");
        document.getElementById('c_code').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Cusname");
        document.getElementById('c_name').value = XMLAddress1[0].childNodes[0].nodeValue;

		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        document.getElementById('id').value = XMLAddress1[0].childNodes[0].nodeValue;

  	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sdate");
        document.getElementById('invdate').value = XMLAddress1[0].childNodes[0].nodeValue;

         $('#myModal_search').modal('hide');
    }
}


function unlock() {

	xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "dealer_insc_data.php";
    url = url + "?Command=" + "unlock";
    url = url + "&c_code=" + document.getElementById('c_code').value;
    url = url + "&chqno=" + document.getElementById('chqno').value;
    url = url + "&id=" + document.getElementById('id').value;


    xmlHttp.onreadystatechange = showresultupdt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function update_remarks() {

	xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "dealer_insc_data.php";
    url = url + "?Command=" + "update_remarks";
    url = url + "&c_code=" + document.getElementById('c_code').value;
    url = url + "&chqno=" + document.getElementById('chqno').value;
	url = url + "&txt_newremarks=" + document.getElementById('txt_newremarks').value;
	
    url = url + "&id=" + document.getElementById('id').value;


    xmlHttp.onreadystatechange = showresultupdt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}



function showresultupdt() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        document.getElementById('msg_box').innerHTML =  xmlHttp.responseText;
		if (xmlHttp.responseText=="Updated") {
		get_cos(document.getElementById('id').value);
		}
    }
}




