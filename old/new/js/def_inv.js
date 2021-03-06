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
	
	xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
	
	document.getElementById('msg_box').innerHTML = "";

 
	
	
	var url = "def_inv_data.php";
    url = url + "?Command=" + "save";
    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&trntype=" + document.getElementById('trn_type').value;
    url = url + "&stk_no=" + document.getElementById('stk_no').value;
    

    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
	
	
	
	
	
}
 
function salessaveresult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
             
			setTimeout(function(){
				window.location.reload(1);
			}, 3);
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

function del_item(cdata) {
    

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    document.getElementById('msg_box').innerHTML = "";
    

    var url = "def_inv_data.php";
    url = url + "?Command=" + "del_inv";
    url = url + "&id=" +cdata;
    xmlHttp.onreadystatechange = cancel_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function cancel_result() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        if (xmlHttp.responseText == "ok") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Cancelled</span></div>";
            setTimeout(function () {
                window.location.reload(1);
            }, 3000);
        } else {
            if (xmlHttp.responseText != "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
            }
        }
    }
}
