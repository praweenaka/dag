 
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




function add_spare(refno,serialno) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "pro_list_data.php";                                 
    var params ="Command="+"add_spare";
    params = params + "&Command1=add_tmp";   
    params = params + "&refno=" + refno;
    params = params + "&serialno=" + serialno;
    params = params + "&spareitem=" + document.getElementById('spareitem').value;
    params = params + "&price=" + document.getElementById('price').value;
    params = params + "&qty=" + document.getElementById('qty').value;
    params = params + "&total=" + document.getElementById('total').value; 


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
     opener.document.form1.itemdetails.innerHTML = XMLAddress1[0].childNodes[0].nodeValue;  

 }
}


function add_workers(refno,serialno) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "pro_list_data.php";                                 
    var params ="Command="+"add_workers";    
    params = params + "&refno=" + refno;
    params = params + "&serialno=" + serialno;
    params = params + "&hours=" + document.getElementById('hours').value;
    params = params + "&workers=" + document.getElementById('workers').value; 


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
     opener.document.form1.itemdetails1.innerHTML = XMLAddress1[0].childNodes[0].nodeValue;  

 }
}

function sendonhand(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    
    var msg = confirm("Do you want to Continue this ! ");
    if (msg == true) {
        var url = "pro_list_data.php";
        var params ="Command="+"sendonhand";    
        params = params + "&id=" + cdate; 

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

function sendreject(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    
    var msg = confirm("Do you want to Continue this ! ");
    if (msg == true) {
        var url = "pro_list_data.php";
        var params ="Command="+"sendreject";    
        params = params + "&id=" + cdate; 

        xmlHttp.open("POST", url, true);

        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.setRequestHeader("Content-length", params.length);
        xmlHttp.setRequestHeader("Connection", "close");

        xmlHttp.onreadystatechange=re_reject;

        xmlHttp.send(params);  

    }
}


function re_reject() {

    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        alert(xmlHttp.responseText);
        setTimeout("location.reload(true);", 500);
    }
}


function sendfinish(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    
    var msg = confirm("Do you want to Continue this ! ");
    if (msg == true) {
        var url = "pro_list_data.php";
        var params ="Command="+"sendfinish";    
        params = params + "&id=" + cdate; 
        params = params + '&warranty=' + document.getElementById('warranty').value; 
        params = params + '&design=' + document.getElementById('design').value;  

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


function totqty()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'pro_list_data.php';
    var params = 'Command=' + 'totqty'; 
    params = params + '&price=' + document.getElementById('price').value; 
    params = params + '&qty=' + document.getElementById('qty').value;   
    
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange =re_totqty;

    xmlHttp.send(params);



}

function re_totqty()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tot");
        document.getElementById('total').value = XMLAddress1[0].childNodes[0].nodeValue;


    }
}

function del_item(id)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'pro_list_data.php';
    var params ="Command="+"add_tmp";  
    params = params + "&Command1=del";  
    params = params + "&id=" + id; 

    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = del;

    xmlHttp.send(params);



}


function del() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
        
        
        
    }
}
