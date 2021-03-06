
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


// codes for log on button

function IsValiedData()
{
    //alert("ok");

    if (document.getElementById('inputEmail').value == "")
    {
        //alert("Please Enter UserName");	
        document.getElementById("inputEmail").focus();
        document.getElementById("txterror").innerHTML = "Please Enter User Name";
        return false;
    } else if (document.getElementById('inputPassword').value == "")
    {

        document.getElementById("txterror").innerHTML = "Please Enter Password";
        //alert("Please Enter Password");	
        document.getElementById("inputPassword").focus();
        return false;
    } else
    {
        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }

        var url = "CheckUsers.php";

        url = url + "?Command=" + "CheckUsers";
        url = url + "&UserName=" + document.getElementById('inputEmail').value;
        url = url + "&Password=" + document.getElementById('inputPassword').value;
        url = url + "&action=" + document.getElementById('action').value;
        
        url = url + "&form=" + document.getElementById('form').value;
        
        xmlHttp.onreadystatechange = CheckUsers;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

    }

}


function CheckUsers()

{	//alert("ok");
var XMLAddress1;

if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
{
        alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stat");
        var rspo = XMLAddress1[0].childNodes[0].nodeValue;
        if (rspo == "Invalied Connection") {
            alert(rspo);
        }

        if (rspo == "ok") {
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stat");
            if (XMLAddress1[0].childNodes[0].nodeValue == "ok") {
                $('#myModal').modal('hide');
                XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("action");
                if (XMLAddress1[0].childNodes[0].nodeValue == "save") {
                    save_inv();
                }
            } else
            {
                document.getElementById("txterror").innerHTML = "Invalid UserName or Password";
            }

        }
    }
}

function keyset(key, e)
{

    if ((e.keyCode == 13) || (e.keyCode == 40)) {
        document.getElementById(key).focus();
    }
}

// function for log out
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
    url = url + "?Command=" + "logout";
    xmlHttp.onreadystatechange = logout_state_Changed;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function logout_state_Changed()
{
    var XMLAddress1;

    //alert(xmlHttp.responseText);

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        location.href = "index.php";
        //location.href="http://lotterixlk.com/ben/";

    }

}

//////////////////////////////////////////////////////////////////////////////////////////////

function newuser()
{
    //alert("ok");

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }




    location.href = "logon_users.php";

}









