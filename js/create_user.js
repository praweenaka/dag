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


function newent() {
    document.getElementById('user_name').value = "";
    document.getElementById('pass1').value = "";
    document.getElementById('pass2').value = "";
    document.getElementById('user_type').value = "USER"; 

    document.getElementById('msg_box').innerHTML = "";
    getdt();
}


function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "CheckUsers.php";
    var params ="Command="+"getdt";   
    params=params+"&ls="+ "new";

    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");
    xmlHttp.onreadystatechange=assign_dt;
    xmlHttp.send(params);


}


function assign_dt() {

    document.getElementById('itemdetails').innerHTML = xmlHttp.responseText;

}

function getcode(cdata, cdata1) {


    document.getElementById('user_name').value = cdata;
    document.getElementById('user_type').value = cdata1; 

    window.scrollTo(0, 0);
    
}

function save_inv()
{

    if (document.getElementById("pass1").value != document.getElementById("pass2").value) {
        alert("Please Confirm Password");
        document.getElementById("pass2").value = "";
        document.getElementById("pass2").focus();
    } else {

        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }

        if (document.getElementById('user_name').value == "") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>User Name  Not Entered</span></div>";
            return false;
        }
        if (document.getElementById('pass1').value == "") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Password  Not Entered</span></div>";
            return false;
        }
        if (document.getElementById('pass2').value == "") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Confirm Password  Not Entered</span></div>";
            return false;
        }
        var url = "CheckUsers.php";
        var params ="Command="+"save_inv";   
        params=params+"&user_name="+document.getElementById('user_name').value;
        params=params+"&password="+document.getElementById('pass1').value;
        params=params+"&user_type="+document.getElementById('user_type').value;

        xmlHttp.open("POST", url, true);
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.setRequestHeader("Content-length", params.length);
        xmlHttp.setRequestHeader("Connection", "close");
        xmlHttp.onreadystatechange=passsuppresult_save_inv;
        xmlHttp.send(params);

        document.getElementById('msg_box').innerHTML = "";

    }

}


function deleteuser() {



    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    
    var msg = confirm("Do you want to DELETE this ! ");
    if (msg == true) {
        if (document.getElementById('user_name').value == "") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>User  Not Selected</span></div>";
            return false;
        }


        var url = "CheckUsers.php";
        var params ="Command="+"delete";   
        params=params+"&user_name="+document.getElementById('user_name').value; 

        xmlHttp.open("POST", url, true);
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.setRequestHeader("Content-length", params.length);
        xmlHttp.setRequestHeader("Connection", "close");
        xmlHttp.onreadystatechange=dele;
        xmlHttp.send(params);

        
    }  
}

function dele() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Delete") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-danger' role='alert'><span class='center-block'>Deleted</span></div>";
            setTimeout("location.reload(true);", 1200);
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}
 