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
    document.getElementById('des').value="";
     document.getElementById('nic').value = "";
    document.getElementById('land').value = "";
    document.getElementById('mobile').value = "";
    document.getElementById('address').value = ""; 
    document.getElementById('msg_box').innerHTML = "";
    
    var url = "man_data.php";
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
            idno = "W/0000" + idno;
        } else if (idno.length === 2) {
            idno = "W/000" + idno;
        } else if (idno.length === 3) {
            idno = "W/00" + idno;
        } else if (idno.length === 4) {
            idno = "W/0" + idno;
        } else if (idno.length === 5) {
            idno = "W/" + idno;
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
    if (document.getElementById('des').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Enter Name</span></div>";
        return false;
    }
    var url = 'man_data.php';
    var params = 'Command=' + 'save_inv';
    params = params + '&code=' + document.getElementById('code').value; 
    params = params + '&des=' + document.getElementById('des').value;
    params = params + '&uniq=' + document.getElementById('uniq').value; 
    params = params + '&nic=' + document.getElementById('nic').value; 
    params = params + '&land=' + document.getElementById('land').value; 
    params = params + '&mobile=' + document.getElementById('mobile').value; 
    params = params + '&address=' + document.getElementById('address').value;  
    params = params + '&type=' + document.getElementById('type').value;  
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

function custno(code)
{
    //alert(code);
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = 'man_data.php';
    var params = 'Command=' + 'pass_quot';
    params = params + '&custno=' + code;
    

    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = passcusresult_quot;

    xmlHttp.send(params);

}


function passcusresult_quot()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        var obj = JSON.parse(XMLAddress1[0].childNodes[0].nodeValue);

        opener.document.getElementById('code').value = obj.code;  
        opener.document.getElementById('des').value = obj.name;    
        opener.document.getElementById('nic').value = obj.nic;    
        opener.document.getElementById('land').value = obj.land;    
        opener.document.getElementById('mobile').value = obj.mobile;    
        opener.document.getElementById('address').value = obj.address;    
        opener.document.getElementById('type').value = obj.type;    

        self.close();
    }

}