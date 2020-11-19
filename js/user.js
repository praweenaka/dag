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

 

function IsValiedData()
{
    if (document.getElementById('txtUserName').value == "")
    {     
        document.getElementById("txtUserName").focus();
        document.getElementById("txterror").innerHTML = "Please Enter User Name";
        return false;
    } else if (document.getElementById('txtPassword').value == "") {
        document.getElementById("txterror").innerHTML = "Please Enter Password";
        document.getElementById("txtPassword").focus();
        return false;
    } else {
        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }

        var url = "CheckUsers.php";
        var params ="Command="+"CheckUsers";   
        params=params+"&UserName="+document.getElementById('txtUserName').value;
        params=params+"&Password="+document.getElementById('txtPassword').value;

        xmlHttp.open("POST", url, true);
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.setRequestHeader("Content-length", params.length);
        xmlHttp.setRequestHeader("Connection", "close");
        xmlHttp.onreadystatechange=CheckUsers;
        xmlHttp.send(params);


    }

}




// logon button stateChanged
function CheckUsers()

{ 
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        var val = xmlHttp.responseText;

        if (val == "ok") {
            location.href = "home.php";
        } else if (val == "Invalied Connection") {
            alert(xmlHttp.responseText);
        } else {

            document.getElementById("txterror").innerHTML = "Invalied UserName or Password";
        }
    }
}

function showPostion(position) {

    alert("dsf");
    alert(position.coords.latitude);
}

function logout()
{
    //alert("ok");

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "CheckUsers.php";
    var params ="Command="+"logout";    

    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");
    xmlHttp.onreadystatechange=logout_state_Changed;
    xmlHttp.send(params);


}

function logout_state_Changed()
{
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        location.href = "index.php";
    }

}










