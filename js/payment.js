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

   document.getElementById('name').value="";
   document.getElementById('amount').value="";
    document.getElementById('remark').value="";
    document.getElementById('ptype').value="SALARY";
     document.getElementById('msg_box').innerHTML = "";

    var url = "payment_data.php";
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
            idno = "P/0000" + idno;
        } else if (idno.length === 2) {
            idno = "P/000" + idno;
        } else if (idno.length === 3) {
            idno = "P/00" + idno;
        } else if (idno.length === 4) {
            idno = "P/0" + idno;
        } else if (idno.length === 5) {
            idno = "P/" + idno;
        }

        document.getElementById("invno").value = idno;

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
    if (document.getElementById('invno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select PAYMENT</span></div>";
        return false;
    }
    if (document.getElementById('amount').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>ENTER AMOUNT</span></div>";
        return false;
    }
    var url = 'payment_data.php';
    var params = 'Command=' + 'save_inv';
    params = params + '&invno=' + document.getElementById('invno').value;
    params = params + '&name=' + document.getElementById('name').value; 
    params = params + '&amount=' + document.getElementById('amount').value; 
    params = params + '&sdate=' + document.getElementById('sdate').value; 
    params = params + '&remark=' + document.getElementById('remark').value; 
    params = params + '&ptype=' + document.getElementById('ptype').value; 
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
    var url = "payment_data.php";
    url = url + "?Command=" + "pass_quot";
    url = url + "&custno=" + code;

    xmlHttp.onreadystatechange = passcusresult_quot;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function passcusresult_quot()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        var obj = JSON.parse(XMLAddress1[0].childNodes[0].nodeValue);

        opener.document.getElementById('invno').value = obj.refno;  
        opener.document.getElementById('sdate').value = obj.sdate;   
        opener.document.getElementById('name').value = obj.name;   
        opener.document.getElementById('amount').value = obj.amount;    
        opener.document.getElementById('remark').value = obj.remark;    
         opener.document.getElementById('ptype').value = obj.type;    
        
      


        self.close();
    }

}



function cancel_inv()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    document.getElementById('msg_box').innerHTML = "";
    if (document.getElementById('invno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select PAYMENT</span></div>";
        return false;
    }



    var url = 'payment_data.php';
    var params = 'Command=' + 'cancel_inv'; 
    params = params + '&invno=' + document.getElementById('invno').value;  
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = re_cancel;

    xmlHttp.send(params);



}

function re_cancel()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {


        if (xmlHttp.responseText == "cancel") {
         document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Canceled</span></div>";
         setTimeout("location.reload(true);", 500); 
     } else {
       document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";

   }

}
}