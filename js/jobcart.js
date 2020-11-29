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

    var url = "jobcart_data.php";
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
            idno = "J/0000" + idno;
        } else if (idno.length === 2) {
            idno = "J/000" + idno;
        } else if (idno.length === 3) {
            idno = "J/00" + idno;
        } else if (idno.length === 4) {
            idno = "J/0" + idno;
        } else if (idno.length === 5) {
            idno = "J/" + idno;
        }

        document.getElementById("code").value = idno;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uniq");
        document.getElementById("uniq").value = XMLAddress1[0].childNodes[0].nodeValue;
    }
}




function add_tmp()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'jobcart_data.php';
    var params = 'Command=' + 'add_tmp';
    params = params + "&Command1=add"; 
    params = params + '&code=' + document.getElementById('code').value; 
    params = params + '&uniq=' + document.getElementById('uniq').value; 
    params = params + '&jobref=' + document.getElementById('jobref').value; 
    params = params + '&sdate=' + document.getElementById('sdate').value; 
    params = params + '&cus_code=' + document.getElementById('cus_code').value; 
    params = params + '&cus_name=' + document.getElementById('cus_name').value; 
    params = params + '&fsdate=' + document.getElementById('fsdate').value; 
    params = params + '&address=' + document.getElementById('address').value; 
    params = params + '&pattern=' + document.getElementById('pattern').value; 
    params = params + '&serialno=' + document.getElementById('serialno').value; 
    params = params + '&make=' + document.getElementById('make').value; 
    params = params + '&size=' + document.getElementById('size').value; 
    params = params + '&type=' + document.getElementById('type').value;  
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = add;

    xmlHttp.send(params);



}

function add()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
     XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
     document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;


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

    var url = 'jobcart_data.php';
    var params = 'Command=' + 'save_item'; 
    params = params + '&code=' + document.getElementById('code').value; 
    params = params + '&uniq=' + document.getElementById('uniq').value;  
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

function del_item(id)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'jobcart_data.php';
    var params ="Command="+"add_tmp";  
    params = params + "&Command1=del"; 
    params = params + '&code=' + document.getElementById('code').value; 
    params = params + '&uniq=' + document.getElementById('uniq').value; 
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
        
        document.getElementById('serialno').value = "";
        document.getElementById('make').value = ""; 

        
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
    var url = "jobcart_data.php";
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

        opener.document.getElementById('code').value = obj.jobno;  
        opener.document.getElementById('jobref').value = obj.cardno;  
        opener.document.getElementById('sdate').value = obj.datein;  
        opener.document.getElementById('cus_code').value = obj.cuscode;   
        opener.document.getElementById('cus_name').value = obj.cusname;   
        opener.document.getElementById('fsdate').value = obj.datefini;   
        opener.document.getElementById('address').value = obj.address1;   
        opener.document.getElementById('pattern').value = obj.treadpattern;   
        opener.document.getElementById('serialno').value = obj.serialno;   
        opener.document.getElementById('make').value = obj.make;   
        opener.document.getElementById('size').value = obj.tsize;   
        opener.document.getElementById('type').value = obj.tsize;     
        
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;


        self.close();
    }

}