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

function setbrand() {
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "po_data.php";
    url = url + "?Command=" + "setbrand";
    url = url + "&brand=" + document.getElementById('brand').value;


    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function add_tmp() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    document.getElementById('msg_box').innerHTML = "";

    if (document.getElementById('tmpno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Invalid</span></div>";
        return;
    }

    if (parseFloat(document.getElementById('qtyinhand').value) < parseFloat(document.getElementById('qty').value)) {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Insufficent Qty</span></div>";
        return;
    }

//    if (parseFloat(document.getElementById('qty').value) < 0) {
//        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Minus Qty</span></div>";
//        return;
//    }


if (document.getElementById('invno').value == "") {
    document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Invalid</span></div>";
    return;
}

if ((document.getElementById('invno').value != "")) {

    var url = "gin_m_data.php";
    url = url + "?Command=" + "add_tmp";
    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&itemCode=" + document.getElementById('itemCode').value;
    url = url + "&itemDesc=" + document.getElementById('itemDesc').value;
    url = url + "&qty=" + document.getElementById('qty').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    url = url + "&from_dep=" + document.getElementById('from_dep').value;



    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

}

function showarmyresultdel() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
        document.getElementById('item_count').value = XMLAddress1[0].childNodes[0].nodeValue;



        document.getElementById('itemCode').value = "";
        document.getElementById('itemDesc').value = "";
        document.getElementById('qty').value = "";

        document.getElementById('qtyinhand').value = 0;
        document.getElementById('submas').innerHTML = "";
        document.getElementById('itemCode').focus();
    }
}



function save_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    document.getElementById('msg_box').innerHTML = "";

    var url = "gin_m_data.php";
    url = url + "?Command=" + "save_item";

    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    url = url + "&to_dep=" + document.getElementById('to_dep').value;
    url = url + "&from_dep=" + document.getElementById('from_dep').value;



    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function salessaveresult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
            print_inv();
            setTimeout(function() {
                window.location.reload(1);
            }, 3);
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

function print_inv() {

    var url = "gin_m_print.php";
    url = url + "?tmp_no=" + document.getElementById('tmpno').value;

    window.open(url, '_blank');

}

function new_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var paymethod;

    document.getElementById('invno').value = "";

    document.getElementById('invno').value = "";

    document.getElementById('unsold').innerHTML = "";


    document.getElementById('itemdetails').innerHTML = "";
    document.getElementById('msg_box').innerHTML = "";

    document.getElementById('submas').innerHTML = "";

    document.getElementById('itemCode').value = "";
    document.getElementById('itemDesc').value = "";
    document.getElementById('qtyinhand').value = "";

    document.getElementById('qty').value = "";

    var url = "gin_m_data.php";
    url = url + "?Command=" + "new_inv";

    xmlHttp.onreadystatechange = assign_invno;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function assign_invno() {



    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");
        document.getElementById('invno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
        document.getElementById('tmpno').value = XMLAddress1[0].childNodes[0].nodeValue;


    }

}




function del_item(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "gin_m_data.php";
    url = url + "?Command=" + "del_item";
    url = url + "&code=" + cdate;
    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;

    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function itno_ind()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    document.getElementById('unsold').innerHTML = "";
    var url = "../search_item_gin_data.php";
    url = url + "?Command=" + "pass_itno";
    url = url + "&itno=" + document.getElementById('itemCode').value;
    url = url + "&department=" + document.getElementById('from_dep').value;

    xmlHttp.onreadystatechange = passitresult_ind;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);



}

function passitresult_ind()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        var str = xmlHttp.responseText;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");
        document.getElementById('itemCode').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");
        document.getElementById('itemDesc').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");
        document.getElementById('qtyinhand').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("itemlist");
        document.getElementById('submas').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("unsold");
        if (XMLAddress1[0].childNodes[0].nodeValue > 0) {
            document.getElementById('unsold').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + XMLAddress1[0].childNodes[0].nodeValue + "</span></div>";
        } else {
            document.getElementById('unsold').innerHTML = "";
        }


        document.getElementById('qty').focus();


    }
}



function update_list(stname)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_gin_multi_data.php";
    url = url + "?Command=" + "search_inv";

    if (document.getElementById('invno').value != "") {
        url = url + "&mstatus=invno";
    } else if (document.getElementById('customername').value != "") {
        url = url + "&mstatus=from";
    } else if (document.getElementById('invdate').value != "") {
        url = url + "&mstatus=to";
    }

    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&customername=" + document.getElementById('customername').value;
    url = url + "&invdate=" + document.getElementById('invdate').value;
    url = url + "&stname=" + stname;
    //alert(url);

    xmlHttp.onreadystatechange = showinvresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function showinvresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        document.getElementById('filt_table').innerHTML = xmlHttp.responseText;
    }
}



function gin(invno)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }




    var url = "gin_m_data.php";
    url = url + "?Command=" + "gin";
    url = url + "&invno=" + invno;
    //alert(url);
    xmlHttp.onreadystatechange = passginresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);






}

function passginresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

       
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("to_dep");
        opener.document.form1.to_dep.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmp_no");
        opener.document.form1.tmpno.value = XMLAddress1[0].childNodes[0].nodeValue;
        


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        self.close();
    }
}

function cancel_inv() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    document.getElementById('msg_box').innerHTML = "";


    var url = "gin_m_data.php";
    url = url + "?Command=" + "del_inv";
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    xmlHttp.onreadystatechange = cancel_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function cancel_result() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        if (xmlHttp.responseText == "ok") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Cancelled</span></div>";
            setTimeout(function() {
                window.location.reload(1);
            }, 3000);
        } else {
            if (xmlHttp.responseText != "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
            }
        }
    }
}



function update()
{
    //alert("ok");
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "gin_m_data.php";
    url = url + "?Command=" + "update";
    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&txtarno=" + document.getElementById('txtarno').value;
    url = url + "&DTARdate=" + document.getElementById('DTARdate').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;

    xmlHttp.onreadystatechange = passupdate;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function passupdate()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        if (xmlHttp.responseText == "ok") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Updated</span></div>";

        } else {
            if (xmlHttp.responseText != "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
            }
        }

    }

}