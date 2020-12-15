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
    document.getElementById('code').value="";
    document.getElementById('design').value="";
    document.getElementById('des').value="";
    
    var url = "design_data.php";
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
            idno = "D/0000" + idno;
        } else if (idno.length === 2) {
            idno = "D/000" + idno;
        } else if (idno.length === 3) {
            idno = "D/00" + idno;
        } else if (idno.length === 4) {
            idno = "D/0" + idno;
        } else if (idno.length === 5) {
            idno = "D/" + idno;
        }

        document.getElementById("code").value = idno;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uniq");
        document.getElementById("uniq").value = XMLAddress1[0].childNodes[0].nodeValue;
        
    }
}




function save_inv()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'design_data.php';
    var params = 'Command=' + 'save_inv';
    params = params + '&code=' + document.getElementById('code').value;
    params = params + '&design=' + document.getElementById('design').value;
    params = params + '&des=' + document.getElementById('des').value;
    params = params + '&uniq=' + document.getElementById('uniq').value; 
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = save;

    xmlHttp.send(params);



}

function save()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        if (xmlHttp.responseText == "Saved") {
           document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
           setTimeout("location.reload(true);", 500);
       } else {
         document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";

     }

 }
}

function getcode(cdata, cdata1,cdata1) {


    document.getElementById('code').value = cdata;
    document.getElementById('design').value = cdata1; 
    document.getElementById('des').value = cdata2; 

    window.scrollTo(0, 0);
    
}