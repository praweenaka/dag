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


function filter() {
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    if (document.getElementById('filterdate').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Filter Date Is Empty...</span></div>";
        return false;
    }


    var url = "sms_fire_data.php";
    url = url + "?Command=" + "filter";
    url = url + "&filterdate=" + document.getElementById('filterdate').value;
 
    document.getElementById('msg_box').innerHTML = "";

    xmlHttp.onreadystatechange = resu_filter;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}


function resu_filter() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

    }
}

function fire() {
    var msg = confirm("Do you want to Send Message.. ! ");
    if (msg == true) {
        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }
        if (document.getElementById('filterdate').value == "") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Filter Date Is Empty...</span></div>";
            return false;
        }
        if (document.getElementById('message').value == "") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Message Is Empty...</span></div>";
            return false;
        }

//        if (document.getElementById('con1').value == "") {
//            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>MD Contact Is Empty...</span></div>";
//            return false;
//        }
//
//        if (document.getElementById('con2').value == "") {
//            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>WD Contact Is Empty...</span></div>";
//            return false;
//        }


        var url = "sms_fire_data.php";
        url = url + "?Command=" + "fire";
        url = url + "&message=" + document.getElementById('message').value;
        url = url + "&con1=" + document.getElementById('con1').value;
        url = url + "&con2=" + document.getElementById('con2').value;

        document.getElementById('msg_box').innerHTML = "";

        xmlHttp.onreadystatechange = resu_fire;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}


function resu_fire() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Sended") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Msg Sended..</span></div>";

            setTimeout("location.reload(true);", 1200);

        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }

    }
}
 