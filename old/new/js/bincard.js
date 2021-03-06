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

var wage = document.getElementById("stk_no");
wage.addEventListener("keydown", function (e) {
    if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
        load_item('');
}
});



function search() {
    $('#myModal_search').modal('show');
    document.getElementById('sstk_no').focus;
    search_itm('');
}



function search_itm(cdata) {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "search_item_data.php";
    url = url + "?Command=" + "search_itm";


    url = url + "&stk_no=" + document.getElementById('sstk_no').value;
    url = url + "&descript=" + document.getElementById('sdescript').value;
    url = url + "&mtype=" + cdata;

    url = url + "&brand=" + document.getElementById('sbrand').value;
    url = url + "&cmbbrand=" + document.getElementById('cmbbrand').value;

    if (document.getElementById('chk_stockall').checked == true) {
        url = url + "&chk_stockall=1";
    } else {
        url = url + "&chk_stockall=0";
    }
    if (document.getElementById('chk_stock').checked == true) {
        url = url + "&chk_stock=1";
    } else {
        url = url + "&chk_stock=0";
    }
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



function get_itm(cdata) {
    $('#myModal_search').modal('hide');


    document.getElementById('stk_no').value = cdata;


    load_item();
}


function load_item() {

    document.getElementById('descript').value = "";
    document.getElementById('selling').value = "";
    document.getElementById('part_no').value = "";
    document.getElementById('itemdetails1').innerHTML = "";
    document.getElementById('itemdetails2').innerHTML = "";
    document.getElementById('itemdetails').innerHTML = "Please Wait...";
    document.getElementById('day90').innerHTML = "";
    document.getElementById('unsold').innerHTML = "";
    document.getElementById('stk').innerHTML = "";
    document.getElementById('stkinhand').innerHTML = "";
    document.getElementById('active').innerHTML = "";


    if (document.getElementById('stk_no').value == "") {
        document.getElementById('itemdetails').innerHTML = "";
        return false;
    }

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "search_item_data.php";
    url = url + "?Command=" + "get_itm";

    url = url + "&stk_no=" + document.getElementById('stk_no').value;

    if (document.getElementById('chk_trns').checked == true) {
        url = url + "&chk_trns=1";
    } else {
        url = url + "&chk_trns=0";
    }
    url = url + "&dte_from=" + document.getElementById('dtfrom').value;
    url = url + "&yer=" + document.getElementById('yer').value;

    url = url + "&department=" + document.getElementById('to_dep').value;


    xmlHttp.onreadystatechange = showresultsearch_itm;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);






}


function showresultsearch_itm() {


    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        document.getElementById('msg_box').innerHTML = "";

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stat");
        if (XMLAddress1[0].childNodes[0].nodeValue == "1") {

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("STK_NO");
            document.getElementById('stk_no').value = XMLAddress1[0].childNodes[0].nodeValue;


            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");
            document.getElementById('descript').value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SELLING");
            document.getElementById('selling').value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PART_NO");
            document.getElementById('part_no').value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
            document.getElementById('itemdetails1').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ord_table");
            document.getElementById('itemdetails2').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;


            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bin_table");
            document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("consum");
            document.getElementById('consum').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;


            document.getElementById('pending').innerHTML = "";

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("pending");
            if (XMLAddress1[0].childNodes[0].nodeValue != 0) {
                document.getElementById('pending').innerHTML = "<span class='label labels125 label-danger'>Pending AR Qty = " + XMLAddress1[0].childNodes[0].nodeValue + "</span>";
            }


            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("unsold");
            if (XMLAddress1[0].childNodes[0].nodeValue != "0") {
                document.getElementById('day90').innerHTML = "<span class='label labels125 label-danger'>Over 90 Stock</span>";
                document.getElementById('unsold').innerHTML = "<span class='label labels125 label-danger'>" + XMLAddress1[0].childNodes[0].nodeValue + "</span>";
            } else {
                document.getElementById('day90').innerHTML = "";
                document.getElementById('unsold').innerHTML = "";
            }



            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");
            if (XMLAddress1[0].childNodes[0].nodeValue != "0") {
                document.getElementById('stk').innerHTML = "<span class='label labels125 label-primary'>Stock in Hand</span>";
                document.getElementById('stkinhand').innerHTML = "<span class='label labels125 label-primary'>" + XMLAddress1[0].childNodes[0].nodeValue + "</span>";
            } else {
                document.getElementById('stk').innerHTML = "";
                document.getElementById('stkinhand').innerHTML = "";
            }



            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("active_t");
            if (XMLAddress1[0].childNodes[0].nodeValue != "0") {
                document.getElementById('active').innerHTML = "<span class='label labels125 label-danger'>Item Locked</span>";

            } else {
                document.getElementById('active').innerHTML = "";

            }
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Please Check Item Code</span></div>";
            document.getElementById('itemdetails').innerHTML = "";

        }

    }






}



function print_inv() {


    var url = "../bincard_print.php?invno=" + document.getElementById('stk_no').value;
    window.open(url, '_blank');




}


function print_inv1() {


    var url = "../report_sup_card_print.php?invno=" + document.getElementById('stk_no').value;
    window.open(url, '_blank');




}


function cal() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_item_data.php";
    url = url + "?Command=" + "calcu";

    url = url + "&dis1=" + document.getElementById('dis1').value;

    url = url + "&dis2=" + document.getElementById('dis2').value;

    url = url + "&sal=" + document.getElementById('selling').value;


    xmlHttp.onreadystatechange = calq;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function calq() {


    var XMLAddress1;

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("toot");
    document.getElementById('tot').value = XMLAddress1[0].childNodes[0].nodeValue;

}