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

function new_ent() {

    document.getElementById('code').value = "";
    document.getElementById('des').value = "";
    document.getElementById('partno').value = "";
    document.getElementById('country').value = "";
    document.getElementById('cost').value = "";
    document.getElementById('whprice').value = "";
    document.getElementById('rprice').value = "";
    document.getElementById('whdis').value = "";
    document.getElementById('rdis').value = "";
    document.getElementById('msg_box').innerHTML = "";

    $("#brand").select2('val', '');
    $("#rack").select2('val', '');
    $("#rows").select2('val', '');
    $("#column").select2('val', '');
    $("#type").select2('val', '');
    getdt();
}

function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "item_mas_data.php";

    var params = "Command=" + "getdt";
    params = params + "&ls=" + "new";
    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.send(params);


}


function assign_dt() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");
        document.getElementById('code').value = XMLAddress1[0].childNodes[0].nodeValue;

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
    document.getElementById('msg_box').innerHTML = "";
    if (document.getElementById('code').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Please Click New</span></div>";
        return false;
    }
    if (document.getElementById('des').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Description Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('brand').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Brand Not Enterd</span></div>";
        return false;
    }



    var url = "item_mas_data.php";
    var params = "Command=" + "save_item";
    params = params + "&code=" + document.getElementById('code').value;
    params = params + "&uniq=" + document.getElementById('uniq').value;
    params = params + "&des=" + document.getElementById('des').value;
    params = params + "&brand=" + document.getElementById('brand').value;
    params = params + "&partno=" + document.getElementById('partno').value;
    params = params + "&cost=" + document.getElementById('cost').value;
    params = params + "&whprice=" + document.getElementById('whprice').value;
    params = params + "&rprice=" + document.getElementById('rprice').value;
    params = params + "&rack=" + document.getElementById('rack').value;
    params = params + "&rows=" + document.getElementById('rows').value;
    params = params + "&column=" + document.getElementById('column').value;
    params = params + "&type=" + document.getElementById('type').value;
    params = params + "&whdis=" + document.getElementById('whdis').value;
    params = params + "&rdis=" + document.getElementById('rdis').value;
    params = params + "&type=" + document.getElementById('type').value;
    params = params + "&country=" + document.getElementById('country').value;

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = re_save;

    xmlHttp.send(params);

}

function re_save() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
            newent();
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}


function cancel_inv() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var msg = confirm("Do you want to CANCEL this ! ");
    if (msg == true) {

        var url = "item_mas_data.php";
        var params = "Command=" + "cancel_inv";
        params = params + "&code=" + document.getElementById('code').value;

        xmlHttp.open("POST", url, true);

        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.setRequestHeader("Content-length", params.length);
        xmlHttp.setRequestHeader("Connection", "close");

        xmlHttp.onreadystatechange = re_cancel;

        xmlHttp.send(params);
    }

}

function re_cancel() {
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


 
function custno(code) {
    //alert(code);

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "item_mas_data.php";
    var params = "Command=" + "pass_quot";
    params = params + "&custno=" + code;

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = re_pass;
    xmlHttp.send(params);

}


function re_pass() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        var obj = JSON.parse(XMLAddress1[0].childNodes[0].nodeValue);

        opener.document.getElementById('code').value = obj.STK_NO;
        opener.document.getElementById('des').value = obj.DESCRIPT;
        opener.document.getElementById('brand').value = obj.BRAND_NAME;
        opener.document.getElementById('partno').value = obj.PART_NO;
        opener.document.getElementById('country').value = obj.country;
        opener.document.getElementById('cost').value = obj.COST;
        opener.document.getElementById('whprice').value = obj.whprice;
        opener.document.getElementById('rprice').value = obj.SELLING;
        opener.document.getElementById('type').value = obj.TYPE;
        opener.document.getElementById('whdis').value = obj.whdis;
        opener.document.getElementById('rdis').value = obj.rdis;
 
        opener.document.getElementById('rack').value = obj.rack;
        opener.document.getElementById('rows').value = obj.row;
        opener.document.getElementById('column').value = obj.colum;


        if (obj.cancel == "1") {
            opener.document.getElementById('msg_box').innerHTML = "<div class='alert alert-danger' role='alert'><span class='center-block'>Cancel</span></div>";
        }

        self.close();

    }

}










