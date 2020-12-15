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
 

function sendproduction(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    
    var msg = confirm("Do you want to Continue this ! ");
    if (msg == true) {
        var url = "reject_list_data.php";
        var params ="Command="+"sendproduction";    
        params = params + "&id=" + cdate;   

        xmlHttp.open("POST", url, true);

        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.setRequestHeader("Content-length", params.length);
        xmlHttp.setRequestHeader("Connection", "close");

        xmlHttp.onreadystatechange=re_finish;

        xmlHttp.send(params);  

    }
}


function re_finish {

    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        alert(xmlHttp.responseText);
        setTimeout("location.reload(true);", 500);
    }
}

 
  