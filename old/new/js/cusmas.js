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

function add_sub() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "subcusmas_data.php";
    url = url + "?Command=" + "add_sub";
    url = url + "&c_main=" + document.getElementById('c_code').value;

    url = url + "&c_code=" + document.getElementById('txt_code').value;
    url = url + "&c_name=" + document.getElementById('txt_name').value;
    url = url + "&c_add=" + document.getElementById('txt_add').value;
    url = url + "&c_tele=" + document.getElementById('txt_tele').value;
    url = url + "&c_vatno=" + document.getElementById('txt_vat').value;
    url = url + "&c_svatno=" + document.getElementById('txt_svat').value;


    xmlHttp.onreadystatechange = showitemresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function showitemresult()
{
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {


        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
            setTimeout(function () {
                window.location.reload(1);
            }, 3);
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}


function del_item(cdate)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "subcusmas_data.php";
    url = url + "?Command=" + "del_item";

    url = url + "&c_code=" + cdate;


    xmlHttp.onreadystatechange = showitemresult_del;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showitemresult_del()
{
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {


        if (xmlHttp.responseText == "Removed") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Removed</span></div>";
            setTimeout(function () {
                window.location.reload(1);
            }, 3);
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

function  getcus(cdata, cdata1, cdata2, cdata3, cdata4, cdata5)
{
    document.getElementById('txt_code').value = cdata;
    document.getElementById('txt_name').value = cdata1;
    document.getElementById('txt_add').value = cdata2;
    document.getElementById('txt_vat').value = cdata3;
    document.getElementById('txt_svat').value = cdata4;
    document.getElementById('txt_tele').value = cdata5;



}
 

function custno(custno, stname)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "search_custom_data.php";
    if ((stname == "") || (stname == "dlr_sch")) {
        url = url + "?Command=" + "pass_quot";
        url = url + "&custno=" + custno;
        url = url + "&stname=" + stname;
        xmlHttp.onreadystatechange = passcusresult_quot;
    } else if (stname == "info") {
        url = url + "?Command=" + "pass_info";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_info;
    } else if (stname == "dlr_shr") {
        url = url + "?Command=" + "pass_dlr_shr";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_dlr_shr;
    } else if (stname == "dlr_acc") {
        url = url + "?Command=" + "pass_dlr_acc";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_dlr_acc;
    } else if (stname == "po") {
        url = url + "?Command=" + "pass_quot";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_basic;
    } else if (stname == "transpaycus") {
        url = url + "?Command=" + "pass_transpay";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_transpay;
    }
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function passcusresult_transpay()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");
        opener.document.form1.code.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");
        opener.document.form1.name.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("town");
        opener.document.form1.town.value = XMLAddress1[0].childNodes[0].nodeValue;




        self.close();
    }
}


function passcusresult_quot()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
//         alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.c_code.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
        opener.document.form1.c_name.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("outst");
        opener.document.form1.outst.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("retch");
        opener.document.form1.retch.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target");
        opener.document.form1.target.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stname");
        if (XMLAddress1[0].childNodes[0].nodeValue != "dlr_sch") {

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("outstCltd");
            opener.document.form1.outstCltd.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("retchStld");
            opener.document.form1.retchStld.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("remtable");
            opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        }
//        calc();
        self.close();
    }
}

function passcusresult_dlr_shr()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
//         alert(xmlHttp.responseText);

//        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
//        opener.document.form1.c_code.value = XMLAddress1[0].childNodes[0].nodeValue;
//
//        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
//        opener.document.form1.c_name.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("remtable");
        opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        self.close();
    }
}


function passcusresult_dlr_acc()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
//         alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("isRegistered");
        var isReg = XMLAddress1[0].childNodes[0].nodeValue;

        if (isReg == "yes") {
            alert("This Dealer is already registered. You may change his username or password.");
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("user_name");
            opener.document.form1.usn.value = XMLAddress1[0].childNodes[0].nodeValue;
        } else {
            opener.document.form1.usn.value = "";
            opener.document.form1.psw.value = "";
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.c_code.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
        opener.document.form1.c_name.value = XMLAddress1[0].childNodes[0].nodeValue;

//        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("remtable");
//        opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        self.close();
    }
}


function passcusresult_info()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        // alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("terminate");
        if (XMLAddress1[0].childNodes[0].nodeValue == "no") {

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
            opener.document.form1.c_code.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
            opener.document.form1.c_name.value = XMLAddress1[0].childNodes[0].nodeValue;

        } else {
            alert("This dealer has a record today!");
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("remtable");
        opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
        self.close();
    }
}


function passcusresult_basic()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.c_code.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
        opener.document.form1.c_name.value = XMLAddress1[0].childNodes[0].nodeValue;




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


    var url = "search_custom_data.php";
    url = url + "?Command=" + "search_custom";


    if (document.getElementById('cusno').value != "") {
        url = url + "&mstatus=cusno";
    } else if (document.getElementById('customername').value != "") {
        url = url + "&mstatus=customername";
    }

    url = url + "&cusno=" + document.getElementById('cusno').value;
    url = url + "&customername=" + document.getElementById('customername').value;
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



