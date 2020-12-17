 
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



function getcode(cdata,cdata1,cdata2) {


    document.getElementById('packegename').value = cdata1; 
    document.getElementById('packegecode').value = cdata;
    window.scrollTo(0, 0);
    
}

function add_spare() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "packege_data.php";                                 
    var params ="Command="+"add_spare"; 
    params = params + "&Command1=add_tmp";      
    params = params + "&packegecode=" +document.getElementById('packegecode').value;
    params = params + "&spareitem=" + document.getElementById('spareitem').value;
    params = params + "&cost=" + document.getElementById('cost').value;
    params = params + "&qty=" + document.getElementById('qty').value; 
    params = params + "&total=" + document.getElementById('total').value; 


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_spare;

    xmlHttp.send(params);  

}

function re_spare()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

     XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table"); 
     document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;  

     document.getElementById('cost').value="";
     document.getElementById('qty').value="";
     document.getElementById('total').value="";

 }
}

function del_spare(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "packege_data.php";                                 
    var params ="Command="+"add_spare";
    params = params + "&Command1=del_item";   
    params = params + "&id=" + cdate; 
    params = params + "&packegecode=" +document.getElementById('packegecode').value;

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_spare;

    xmlHttp.send(params);  

}



function add_expense() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "packege_data.php";                                 
    var params ="Command="+"add_expense"; 
    params = params + "&Command1=add_tmp";      
    params = params + "&packegecode=" +document.getElementById('packegecode').value;
    params = params + "&name=" + document.getElementById('name').value;
    params = params + "&cost=" + document.getElementById('cost1').value; 
 

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_expense;

    xmlHttp.send(params);  

}

function re_expense()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

     XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table"); 
     document.getElementById('itemdetails1').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;  

     document.getElementById('cost').value=""; 
     
 }
}

function del_expense(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "packege_data.php";                                 
    var params ="Command="+"add_expense";
    params = params + "&Command1=del_item";   
    params = params + "&id=" + cdate; 
    params = params + "&packegecode=" +document.getElementById('packegecode').value;

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_expense;

    xmlHttp.send(params);  

}