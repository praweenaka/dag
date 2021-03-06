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


function got_focus(key) {
    document.getElementById(key).style.backgroundColor = "#000066";

}

function lost_focus(key) {
    document.getElementById(key).style.backgroundColor = "#000000";

}
function newent() {
    document.getElementById('code').value = "";
    document.getElementById('reqby').value = "";
    document.getElementById('des').value = "";

    document.getElementById('msg_box').innerHTML = "";

    getdt();


}
//////////////////////////////////////////////////////End New//////////////////////////////////////////////////

////////////////////////////////////////////////////////////Get Data//////////////////////////////////////////////////////////////
function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "reqdata_modification_data.php";
    url = url + "?Command=" + "getdt";
    url = url + "&ls=" + "new";

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}
function assign_dt() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        var idno = XMLAddress1[0].childNodes[0].nodeValue;

        if (idno.length === 1) {
            idno = "REQM/0000" + idno;
        } else if (idno.length === 2) {
            idno = "REQM/000" + idno;
        } else if (idno.length === 3) {
            idno = "REQM/00" + idno;
        } else if (idno.length === 4) {
            idno = "REQM/0" + idno;
        } else if (idno.length === 5) {
            idno = "REQM/" + idno;
        }

        document.form1.code.value = idno;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uniq");
        document.getElementById('uniq').value = XMLAddress1[0].childNodes[0].nodeValue;
    }
}

function save_inv() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (document.getElementById('code').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>New is Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('reqby').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Request By is Not Entered</span></div>";
        return false;
    }
    if (document.getElementById('des').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Description Is Not Entered</span></div>";
        return false;
    }



    var url = "reqdata_modification_data.php";
    url = url + "?Command=" + "save_item";


    url = url + "&code=" + document.getElementById('code').value;
    url = url + "&uniq=" + document.getElementById('uniq').value;
    url = url + "&sdate=" + document.getElementById('sdate').value;
    url = url + "&reqby=" + document.getElementById('reqby').value;
    url = url + "&des=" + document.getElementById('des').value;
    document.getElementById('msg_box').innerHTML = "";
    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function salessaveresult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";

            setTimeout("location.reload(true);", 500);

        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}



function custno(code)
{
    //alert(code);
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "reqdata_modification_data.php";
    url = url + "?Command=" + "pass_quot";
    url = url + "&custno=" + code;

    xmlHttp.onreadystatechange = passcusresult_quot;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function passcusresult_quot()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");
        opener.document.form1.code.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sdate");
        opener.document.form1.sdate.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("reqby");
        opener.document.form1.reqby.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("des");
        opener.document.form1.des.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uniq");
        opener.document.form1.uniq.value = XMLAddress1[0].childNodes[0].nodeValue;

        self.close();
    }


}

function update_cust_list(stname)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "reqdata_modification_data.php";
    url = url + "?Command=" + "search_custom";
    if (document.getElementById('cusno').value != "") {
        url = url + "&mstatus=cusno";
    } else if (document.getElementById('customername').value != "") {
        url = url + "&mstatus=customername";
    } else if (document.getElementById('des').value != "") {
        url = url + "&mstatus=des";
    }


    url = url + "&code=" + document.getElementById('cusno').value;
    url = url + "&reqby=" + document.getElementById('customername').value;
    url = url + "&des=" + document.getElementById('des').value;
    url = url + "&stname=" + stname;

    xmlHttp.onreadystatechange = showcustresult;

    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}


function showcustresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        document.getElementById('filt_table').innerHTML = xmlHttp.responseText;

    }
}

function cancelInv(stname)
{
    var msg = confirm("Do you want to CANCEL this ! ");
    if (msg == true) {

        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }
        if (document.getElementById('des').value == "") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Plz Find..</span></div>";
            return false;
        }

        var url = "reqdata_modification_data.php";
        url = url + "?Command=" + "cancelinv";
        url = url + "&code=" + document.getElementById('code').value;

        xmlHttp.onreadystatechange = cancel;

        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}
function cancel()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Cancel") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Cancel</span></div>";

            setTimeout("location.reload(true);", 500);

        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}