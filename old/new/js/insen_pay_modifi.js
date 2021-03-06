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

function save_inv() {
    
  var msg = confirm("Do you want to Insert This ! ");
    if (msg == true) {
        
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (document.getElementById('code').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Code Is Empty</span></div>";
        return false;
    }
    if (document.getElementById('sdate').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Month Is Not Set</span></div>";
        return false;
    }
    if (document.getElementById('brand').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Brand Is Not Entered</span></div>";
        return false;
    }
    if (document.getElementById('des').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Description Is Not Entered</span></div>";
        return false;
    }



    var url = "insen_pay_modifi_data.php";
    url = url + "?Command=" + "save_item";

//
//    var res = document.getElementById('planNo').value;
//    res = res.substring(1);


    url = url + "&code=" + document.getElementById('code').value;
    url = url + "&sdate=" + document.getElementById('sdate').value;
    url = url + "&brand=" + document.getElementById('brand').value;
    url = url + "&des=" + document.getElementById('des').value;
 
    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
    }
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



