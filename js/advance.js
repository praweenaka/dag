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
     document.getElementById('cuscode').value="";
   document.getElementById('cusname').value="";
   document.getElementById('paytype').value="CASH";
   document.getElementById('chkno').value="";
   document.getElementById('chkdate').value="";
   document.getElementById('bank').value="";
   document.getElementById('chamount').value="";
   document.getElementById('caamount').value="";
   document.getElementById('remark').value=""; 
   document.getElementById('msg_box').innerHTML = "";
    
     var url = 'advance_data.php';
    var params = 'Command=' + "getdt"; 
    // params = params + "&ls=" + "new";
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
    // if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        var idno = XMLAddress1[0].childNodes[0].nodeValue;
        if (idno.length === 1) {
            idno = "PAY/0000" + idno;
        } else if (idno.length === 2) {
            idno = "PAY/000" + idno;
        } else if (idno.length === 3) {
            idno = "PAY/00" + idno;
        } else if (idno.length === 4) {
            idno = "PAY/0" + idno;
        } else if (idno.length === 5) {
            idno = "PAY/" + idno;
        }

        document.getElementById("invno").value = idno;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uniq");
        document.getElementById("uniq").value = XMLAddress1[0].childNodes[0].nodeValue;
        
    // }
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
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Please Click New</span></div>";
        return false;
    }
    if (document.getElementById('cuscode').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Please Select Customer</span></div>";
        return false;
    }
            
    var url = 'advance_data.php';
    var params = 'Command=' + 'save_inv';
       params = params + '&invno=' + document.getElementById('invno').value;
       params = params + '&uniq=' + document.getElementById('uniq').value;
       params = params + '&sdate=' + document.getElementById('sdate').value;
       params = params + '&cuscode=' + document.getElementById('cuscode').value;
       params = params + '&cusname=' + document.getElementById('cusname').value;
       params = params + '&paytype=' + document.getElementById('paytype').value;;
       params = params + '&chkno=' + document.getElementById('chkno').value;
       params = params + '&chkdate=' + document.getElementById('chkdate').value;
       params = params + '&bank=' + document.getElementById('bank').value;
       params = params + '&chamount=' + document.getElementById('chamount').value;
       params = params + '&caamount=' + document.getElementById('caamount').value;
       params = params + '&remark=' + document.getElementById('remark').value;
       params = params + '&paytype=' + document.getElementById('paytype').value;
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


function print_inv() {

    var url = "advance_print.php";
    url = url + "?invno=" + document.getElementById('invno').value;
    

    window.open(url, '_blank');


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
    var url = "advance_data.php";
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
         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_REFNO");	
		 opener.document.getElementById('invno').value = XMLAddress1[0].childNodes[0].nodeValue;
		 
		  XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_DATE");	
		 opener.document.getElementById('sdate').value = XMLAddress1[0].childNodes[0].nodeValue;
		 
		  XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CODE");	
		 opener.document.getElementById('cuscode').value = XMLAddress1[0].childNodes[0].nodeValue;
		 
		  XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_PAYMENT");	
		 opener.document.getElementById('caamount').value = XMLAddress1[0].childNodes[0].nodeValue;
		 
		  XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("paytype");	
		 opener.document.getElementById('paytype').value = XMLAddress1[0].childNodes[0].nodeValue;
		  
         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cusname");	
		 opener.document.getElementById('cusname').value = XMLAddress1[0].childNodes[0].nodeValue;
		 
		 
		 XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("che_date");	
		 opener.document.getElementById('chkdate').value = XMLAddress1[0].childNodes[0].nodeValue;
		 
		 XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cheque_no");	
		 opener.document.getElementById('chkno').value = XMLAddress1[0].childNodes[0].nodeValue;
		  
		 
		 XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bank");	
		 opener.document.getElementById('bank').value = XMLAddress1[0].childNodes[0].nodeValue;
		 
		  XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("che_amount");	
		 opener.document.getElementById('chamount').value = XMLAddress1[0].childNodes[0].nodeValue;
		 
		  
         


        self.close();
    }

}

function custno1(code)
{
    //alert(code);
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "advance_data.php";
    url = url + "?Command=" + "pass_cus";
    url = url + "&custno=" + code;

    xmlHttp.onreadystatechange = passcusresult_quot1;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function passcusresult_quot1()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        var obj = JSON.parse(XMLAddress1[0].childNodes[0].nodeValue);
   
        opener.document.getElementById('cuscode').value = obj.CODE;   
        opener.document.getElementById('cusname').value = obj.NAME;     
         


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
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Entry</span></div>";
        return false;
    }



    var url = 'advance_data.php';
    var params = 'Command=' + 'cancel_inv'; 
    params = params + '&invno=' + document.getElementById('invno').value; 
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