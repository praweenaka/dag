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

 function add_workersview() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "reject_list_data.php";                                 
    var params ="Command="+"add_workers";      
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value; 


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_work;

    xmlHttp.send(params);  

}

function re_work()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

     XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table"); 
     document.getElementById('itemdetails1').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;  
 }
}

function add_buildersview() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "reject_list_data.php";                                 
    var params ="Command="+"add_builders";      
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value; 


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_builder;

    xmlHttp.send(params);  

}

function re_builder()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

     XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table"); 
     document.getElementById('itemdetails2').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;  
 }
}



function add_spareview() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

     

    var url = "reject_list_data.php";                                 
    var params ="Command="+"add_spare";   
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value; 


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_search;

    xmlHttp.send(params);  

}

function re_search()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

       XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
       document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;  

   }
}

function add_finishview() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

     

    var url = "reject_list_data.php";                                 
    var params ="Command="+"add_finishview";   
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value; 
 

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_finish;

    xmlHttp.send(params);  

}

function re_finish()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

       XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("warrenty");
       document.getElementById('warrenty').value = XMLAddress1[0].childNodes[0].nodeValue;  

         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("design");
       document.getElementById('design').value = XMLAddress1[0].childNodes[0].nodeValue;  

   }
}

function sendproduction() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    
    var msg = confirm("Do you want to Continue this ! ");
    if (msg == true) {
        var url = "reject_list_data.php";
        var params ="Command="+"sendproduction";    
       params = params + "&refno=" + document.getElementById('refno').value;
         params = params + "&serialno=" + document.getElementById('serialno').value; 

        xmlHttp.open("POST", url, true);

        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.setRequestHeader("Content-length", params.length);
        xmlHttp.setRequestHeader("Connection", "close");

        xmlHttp.onreadystatechange=re_onhand;

        xmlHttp.send(params);  

    }
}


function re_onhand() {

    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        alert(xmlHttp.responseText);
        setTimeout("location.reload(true);", 500);
    }
}

