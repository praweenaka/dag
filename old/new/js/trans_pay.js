 
function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
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
 
   if (document.getElementById('ref_no').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Invoice No Is Empty</span></div>";
        return false;
    }
     if (document.getElementById('code').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer Is Empty</span></div>";
        return false;
    }
   
    


    var url = "trans_pay_data.php";
    url = url + "?Command=" + "saveinv"; 

    url = url + "&ref_no=" + document.getElementById('ref_no').value; 
    url = url + "&sdate=" + document.getElementById('sdate').value; 

    xmlHttp.onreadystatechange = inv_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function inv_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        if (xmlHttp.responseText == "Updated") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Updated</span></div>";
            print_inv();
            setTimeout("location.reload(true);", 1000);

        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}




function cancel_inv() {


    var msg = confirm("Do you want to CANCEL this TransportPay ! ");
    if (msg == true) {


        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }

        var url = "trans_pay_data.php";
        url = url + "?Command=" + "cancel_inv";
        url = url + "&ref_no=" + document.getElementById('ref_no').value; 


        xmlHttp.onreadystatechange = cancel_inv_result;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }


}

function cancel_inv_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        if (xmlHttp.responseText == "Canceled") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>cancelled</span></div>";
//            location.reload(true);
            setTimeout("location.reload(true);", 500);
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}



function custno(custno, stname)
{   
            
            
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null)
    {
        alert ("Browser does not support HTTP Request");
        return;
    }       
     
    var url="trans_pay_data.php";     

    if (stname == "transpay") {
        url=url+"?Command="+"pass_quot1"; 
        url=url+"&custno="+custno; 
        xmlHttp.onreadystatechange=passcusresult_quot1; 
        xmlHttp.open("GET",url,true);
        xmlHttp.send(null);
    } else { 
        if(stname=="NotPaid"){
            url=url+"?Command="+"pass_quot";
            url=url+"&custno="+custno; 
            xmlHttp.onreadystatechange=passcusresult_quot;
            xmlHttp.open("GET",url,true);
            xmlHttp.send(null);
        }else{
            alert("Already Paid");
            return;
        }
        
    }      
              
}



function passcusresult_quot1()
{
    var XMLAddress1;
    
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");   
        opener.document.form1.code.value=XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cusname");   
        opener.document.form1.name.value=XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("transdate");   
        opener.document.form1.sdate.value=XMLAddress1[0].childNodes[0].nodeValue;
        
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("trans_no"); 
        opener.document.form1.ref_no.value = XMLAddress1[0].childNodes[0].nodeValue;
         
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("remtable");
        opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
        self.close();
    }
}

 

function passcusresult_quot()
{
    var XMLAddress1;
    
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");   
        opener.document.form1.invno.value=XMLAddress1[0].childNodes[0].nodeValue;;
        
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("date"); 
        opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;
         
        
        self.close();
    }
}

function update_cust_list(stname)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "trans_pay_data.php";

    if(stname=="transpay"){
        url = url + "?Command=" + "search_custom1"; 
        if (document.getElementById('cusno').value != "") {
            url = url + "&mstatus=cusno";
        } else if (document.getElementById('customername').value != "") {
            url = url + "&mstatus=customername";
        }

        url = url + "&cusno=" + document.getElementById('cusno').value;
        url = url + "&customername=" + document.getElementById('customername').value;
        url = url + "&stname=" + stname; 
        xmlHttp.onreadystatechange = showcustresult;
    }else{
        url = url + "?Command=" + "search_custom"; 
        if (document.getElementById('cusno').value != "") {
            url = url + "&mstatus=cusno";
        } else if (document.getElementById('customername').value != "") {
            url = url + "&mstatus=customername";
        }

        url = url + "&cusno=" + document.getElementById('cusno').value;
        url = url + "&customername=" + document.getElementById('customername').value;
        url = url + "&stname=" + stname; 
        xmlHttp.onreadystatechange = showcustresult;
    }
    
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}



function showcustresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    { 

        document.getElementById('filt_table').innerHTML = xmlHttp.responseText;

    }
}


function add_tmp(cdata)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    if (document.getElementById('invno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Invoice N0 Is Empty</span></div>";
        return false;
    }
    if (document.getElementById('transamou').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Transport Amount Is Empty</span></div>";
        return false;
    }
    if (document.getElementById('transthtamou').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>THT Pay Amount is Empty</span></div>";
        return false;
    }

    document.getElementById('msg_box').innerHTML = "";
  
    var url = "trans_pay_data.php";
    url = url + "?Command=" + "add_tmp";
    url = url + "&Command1=" + cdata;

    url = url + "&ref_no=" + document.getElementById('ref_no').value;
    url = url + "&code=" + document.getElementById('code').value;
     url = url + "&name=" + document.getElementById('name').value; 
    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&invdate=" + document.getElementById('invdate').value;
    url = url + "&transamou=" + document.getElementById('transamou').value;
    url = url + "&transthtamou=" + document.getElementById('transthtamou').value;
    url = url + "&type=" + document.getElementById('type').value; 
    url = url + "&remark=" + document.getElementById('remark').value; 
 

    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function del_item(cdata)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    document.getElementById('msg_box').innerHTML = "";
  
    var url = "trans_pay_data.php";
    url = url + "?Command=add_tmp";
    url = url + "&Command1=del";
    url = url + "&invno=" + cdata; 
    url = url + "&ref_no=" + document.getElementById('ref_no').value;  
 

    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}
     


function showarmyresultdel()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Command1");
        if (XMLAddress1[0].childNodes[0].nodeValue == "add") {
            document.getElementById('invno').value = "";
            document.getElementById('invdate').value = "";
            document.getElementById('transamou').value = "";
            document.getElementById('transthtamou').value = "";

            document.getElementById('remark').value = ""; 

            document.getElementById('invno').focus();
        }
    }
}
function new_inv()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
 
    document.getElementById('code').value="";
    document.getElementById('name').value="";
    document.getElementById('town').value=""; 
    document.getElementById('msg_box').innerHTML="";
    document.getElementById('itemdetails').innerHTML ="";

    var url = "trans_pay_data.php";
    url = url + "?Command=" + "new_inv";
    url = url + "&ref_no=" + document.getElementById('ref_no').value;

    xmlHttp.onreadystatechange = assign_invno;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function assign_invno() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");
        document.getElementById('ref_no').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sdate");
        document.getElementById('sdate').value = XMLAddress1[0].childNodes[0].nodeValue;
    }



}

function print_inv()
{
    url = "rep_trans_pay.php";
    url = url + "?ref_no=" + document.getElementById('ref_no').value;
     window.open(url);

}