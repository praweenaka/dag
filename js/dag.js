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
    document.getElementById('refno').value="";
    document.getElementById('cuscode').value=""; 
    document.getElementById('cusname').value="";
    document.getElementById('size').value="";
    document.getElementById('marker').value="";
    document.getElementById('adpayment').value="";
    document.getElementById('serialno').value="";
    document.getElementById('warranty').value="";
    document.getElementById('remark').value="";
    document.getElementById('uniq').value="";
    document.getElementById('jobno').value="";
    document.getElementById('belt').value="";
    document.getElementById('department').value="01";
    document.getElementById('msg_box').innerHTML="";
    document.getElementById('department').disabled=false;
    
    document.getElementById('itemdetails').innerHTML="";
    var url = "dag_data.php";
    var params = "Command=" + "getdt";
    params = params + "&ls=" + "new";
    params = params + "&department=" + document.getElementById('department').value; 
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
            idno = "D/0000" + idno;
        } else if (idno.length === 2) {
            idno = "D/000" + idno;
        } else if (idno.length === 3) {
            idno = "D/00" + idno;
        } else if (idno.length === 4) {
            idno = "D/0" + idno;
        } else if (idno.length === 5) {
            idno = "D/" + idno;
        }

        document.getElementById("refno").value = idno;
        
       

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uniq");
        document.getElementById("uniq").value = XMLAddress1[0].childNodes[0].nodeValue;
        
         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("scode"); 
        if (XMLAddress1[0].childNodes[0].nodeValue=="K") {
            document.getElementById("jobno").disabled=false;
        }else{
            document.getElementById("jobno").disabled=true;
        }
        
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("jobno");
        document.getElementById("jobno").value = XMLAddress1[0].childNodes[0].nodeValue;
    }
}

function setjobno() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
   
     
    var url = "dag_data.php";
    var params = "Command=" + "setjobno"; 
    params = params + "&department=" + document.getElementById('department').value; 
    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = re_setjobno;
    xmlHttp.send(params);
}


function re_setjobno() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("scode"); 
        if (XMLAddress1[0].childNodes[0].nodeValue=="K") {
            document.getElementById("jobno").disabled=false;
        }else{
            document.getElementById("jobno").disabled=true;
        }
        
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("jobno");
        document.getElementById("jobno").value = XMLAddress1[0].childNodes[0].nodeValue;
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

    if (document.getElementById('cuscode').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Customer</span></div>";
        return false;
    }

    if (document.getElementById('belt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Belt</span></div>";
        return false;
    }
  
    if (document.getElementById('size').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Size</span></div>";
        return false;
    }
     if (document.getElementById('marker').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Marker</span></div>";
        return false;
    }
      if (document.getElementById('serialno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Serial No</span></div>";
        return false;
    }
     if (document.getElementById('warranty').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Warrenty</span></div>";
        return false;
    }
    var url = 'dag_data.php';
    var params = 'Command=' + 'add_tmp';
    params = params + "&Command1=add";  
    params = params + '&uniq=' + document.getElementById('uniq').value; 
    params = params + "&refno="+document.getElementById('refno').value; 
    params = params + "&cuscode="+document.getElementById('cuscode').value;
    params = params + "&cusname="+document.getElementById('cusname').value;
    params = params + "&size="+document.getElementById('size').value;
    params = params + "&marker="+document.getElementById('marker').value;
    params = params + "&adpayment="+document.getElementById('adpayment').value;
    params = params + "&serialno="+document.getElementById('serialno').value;
    params = params + "&warranty="+document.getElementById('warranty').value;
    params = params + "&remark="+document.getElementById('remark').value;
    params = params + "&jobno="+document.getElementById('jobno').value;
    params = params + "&sdate="+document.getElementById('sdate').value;
    params = params + "&belt="+document.getElementById('belt').value;
    params = params + "&department="+document.getElementById('department').value;
    
    document.getElementById('msg_box').innerHTML = "";
    
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

     document.getElementById('warranty').value = "";
     document.getElementById('remark').value = ""; 
     document.getElementById('serialno').value = ""; 
     document.getElementById('marker').value = ""; 
     document.getElementById('size').value = ""; 
      document.getElementById('belt').value = ""; 
     
      
     document.getElementById('department').disabled=true;
     XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("jobno");
    document.getElementById("jobno").value = XMLAddress1[0].childNodes[0].nodeValue;

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

    document.getElementById('msg_box').innerHTML = "";
    if (document.getElementById('cuscode').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Customer</span></div>";
        return false;
    }

    var url = 'dag_data.php';
    var params = 'Command=' + 'save_item'; 
    params = params + '&refno=' + document.getElementById('refno').value; 
    params = params + '&uniq=' + document.getElementById('uniq').value;  
    params = params + '&sdate=' + document.getElementById('sdate').value;  
    params = params + "&cuscode="+document.getElementById('cuscode').value;
    params = params + "&cusname="+document.getElementById('cusname').value;
    params = params + '&adpayment=' + document.getElementById('adpayment').value;   
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

    var url = 'dag_data.php';
    var params ="Command="+"add_tmp";  
    params = params + "&Command1=del"; 
    params = params + '&refno=' + document.getElementById('refno').value; 
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
    var url = "dag_data.php";
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

        opener.document.getElementById('refno').value = obj.refno;  
        opener.document.getElementById('sdate').value = obj.sdate;   
        opener.document.getElementById('cuscode').value = obj.cuscode;   
        opener.document.getElementById('cusname').value = obj.cusname;    
        
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;


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
    if (document.getElementById('refno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Entry</span></div>";
        return false;
    }



    var url = 'dag_data.php';
    var params = 'Command=' + 'cancel_inv'; 
    params = params + '&refno=' + document.getElementById('refno').value; 
    params = params + '&uniq=' + document.getElementById('uniq').value;   
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


        if (xmlHttp.responseText == "Cancel") {
         document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Canceled</span></div>";
         setTimeout("location.reload(true);", 500); 
     } else {
       document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";

   }

}
}