function GetXmlHttpObject()
{
    var xmlHttp = null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    } catch (e)
    {
        // Internet Explorer
        try
        {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e)
        {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function new_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "addfiles_data.php";
    var params = "Command=" + "getdt";
    params = params + "&ls=" + "new";
    // params = params + "&uniq=" + document.getElementById('uniq').value; 
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

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        var idno = XMLAddress1[0].childNodes[0].nodeValue;
        if (idno.length === 1) {
            idno = "F/0000" + idno;
        } else if (idno.length === 2) {
            idno = "F/000" + idno;
        } else if (idno.length === 3) {
            idno = "F/00" + idno;
        } else if (idno.length === 4) {
            idno = "F/0" + idno;
        } else if (idno.length === 5) {
            idno = "F/" + idno;
        }

        document.getElementById("batchno").value = idno;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uniq");
        document.getElementById("uniq").value = XMLAddress1[0].childNodes[0].nodeValue;
    }
}



function imgup(cdata) {

    var files = $('#file-3')[0].files; //where files would be the id of your multi file input
//or use document.getElementById('files').files;

for (var i = 0, f; f = files[i]; i++) {
    var name = document.getElementById('file-3');
    var alpha = name.files[i];
    console.log(alpha.name);
    var data = new FormData();
    var batchno = document.getElementById('batchno').value;
    data.append('Command', "imageup");
    data.append('file', alpha);
    data.append('batchno', batchno);
    $.ajax({
        url: 'addfiles_data.php',
        data: data,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (msg) {
            alert(msg);

        }
    });
}
}