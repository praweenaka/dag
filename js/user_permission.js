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

function select_permission()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'user_permission_data.php';
    var params = 'Command=' + 'select_permission';
    params = params + '&user_name=' + document.getElementById('user_name').value;
    params = params + "&sam_user=" + "olduser";
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = passsuppresult_select_permission;

    xmlHttp.send(params);



}

function passsuppresult_select_permission()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("balance_table");
        document.getElementById('privi_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");
        document.getElementById('mcount').value = XMLAddress1[0].childNodes[0].nodeValue;


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

    var url = 'user_permission_data.php';
    var params = 'Command=' + 'save_inv';

    params = params + '&user_name=' + document.getElementById('user_name').value;
    var i = 1;
    while (i < document.getElementById("mcount").value) {
        chkview = "chkview" + i;
        chkfeed = "chkfeed" + i;
        chkmod = "chkmod" + i;
        chkprice = "chkprice" + i;

        params = params + "&" + chkview + "=" + document.getElementById(chkview).checked;
        params = params + "&" + chkfeed + "=" + document.getElementById(chkfeed).checked;
        params = params + "&" + chkmod + "=" + document.getElementById(chkmod).checked;
        params = params + "&" + chkprice + "=" + document.getElementById(chkprice).checked;

        i = i + 1;
    }

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = passsuppresult_save_inv;

    xmlHttp.send(params);




}



function passsuppresult_save_inv()
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

function sampleuser()
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'user_permission_data.php';
    var params = 'Command=' + 'select_permission';
    params = params + '&sam_user=' + document.getElementById('sam_user').value;

    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = passsuppresult_select_permission;

    xmlHttp.send(params);

}