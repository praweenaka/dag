var loc = "add";
// addEventListener("keydown", function (e) {
//     if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
//         add_tmp();
// }
// });

// var wage = document.getElementById("qty");
// wage.addEventListener("keydown", function (e) {
//     if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
//         add_tmp();
//     }
// });


addEventListener("keydown", function (e) {
    if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
        windowWidth = 800;
    windowHeight = 720;
    var left = (screen.width - windowWidth) / 2;
    var top = (screen.height - windowHeight) / 4;
    var myWindow = window.open("serach_customer.php",'_blank','width=' + windowWidth + ', height=' + windowHeight + ', top=' + top + ', left=' + left);

}
}); 

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

function keyset(key, e) {

    if (e.keyCode == 13) {
        document.getElementById(key).focus();
    }
}

function got_focus(key) {
    document.getElementById(key).style.backgroundColor = "#000066";

}

function lost_focus(key) {
    document.getElementById(key).style.backgroundColor = "#000000";

}



function print_inv() {

    var url = "po_print.php";
    url = url + "?invno=" + document.getElementById('txt_entno').value; 

    window.open(url, '_blank');


}

function add_tmp() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }



    document.getElementById('msg_box').innerHTML = "";

    if (document.getElementById('tmpno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>New Not Selected</span></div>";
        return false;
    }

    if (document.getElementById('c_code').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer Not Selected</span></div>";
        return false;
    }


    var url = "po_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "add_tmp";
    url = url + "&invno=" + document.getElementById('txt_entno').value;
    url = url + "&itemCode=" + document.getElementById('itemCode').value;
    url = url + "&itemDesc=" + escape(document.getElementById('itemDesc').value);

    url = url + "&qty=" + document.getElementById('qty').value;
    url = url + "&rate=" + document.getElementById('itemPrice').value;
    url = url + "&selling=" + document.getElementById('selling').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
 
    loc ="add";
    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

    document.getElementById('itemCode').value = "";
    document.getElementById('itemDesc').value = "";
    document.getElementById('itemPrice').value = "";
    document.getElementById('selling').value = "";
    document.getElementById('qty').value = "";

    
}


function showarmyresultdel() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
        document.getElementById('item_count').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");
        
        document.getElementById('total_value').value = XMLAddress1[0].childNodes[0].nodeValue;



        if (loc == "add") {
            document.getElementById('searchcusti').focus();
        } else {
            document.getElementById('itemPrice').focus();     
        }
    }
}



function save_inv() {
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    document.getElementById('msg_box').innerHTML = "";

    if (document.getElementById('tmpno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>New Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('c_name').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer Not Selected</span></div>";
        return false;
    }
    var url = "po_data.php";
    var params = "Command=" + "save_item";
    params = params + "&invno=" + document.getElementById('txt_entno').value;
    params = params + "&tmpno=" + document.getElementById('tmpno').value;
    params = params + "&invdate=" + document.getElementById('invdate').value;
    params = params + "&c_code=" + escape(document.getElementById('c_code').value);
    params = params + "&c_name=" + escape(document.getElementById('c_name').value);
    params = params + "&txt_remarks=" + document.getElementById('txt_remarks').value;  
    params = params + "&department=" + escape(document.getElementById('department').value); 
    params = params + "&lc_no=" + escape(document.getElementById('lc_no').value); 
    params = params + "&total_value=" + document.getElementById('total_value').value;


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = salessaveresult;

    xmlHttp.send(params);

}





function salessaveresult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>"; 
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

function new_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }



    document.getElementById('txt_entno').value = "";
    document.getElementById('c_code').value = "";
    document.getElementById('c_name').value = "";

    document.getElementById('itemdetails').innerHTML = "";

    document.getElementById('msg_box').innerHTML = "";
    document.getElementById('itemCode').value = "";
    document.getElementById('itemDesc').value = "";
    document.getElementById('itemPrice').value = "";
    document.getElementById('subtot').value = "";
    document.getElementById('selling').value = "";
    document.getElementById('qty').value = "";
    document.getElementById('total_value').value = "";

    
    document.getElementById('lc_no').value = "";    
    
    
    document.getElementById('txt_remarks').value = "";
    
    var url = "po_data.php";
    url = url + "?Command=" + "new_inv";

    xmlHttp.onreadystatechange = assign_invno;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function assign_invno() {



    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");
        document.getElementById('txt_entno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
        document.getElementById('tmpno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dt");
        document.getElementById('invdate').value = XMLAddress1[0].childNodes[0].nodeValue;



    }

}




function del_item(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "po_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "del_item";
    url = url + "&itemCode=" + cdate;
    url = url + "&invno=" + document.getElementById('txt_entno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    
    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}



 


function crnview(custno, stname)
{
    try {


        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }
        
            var url = "po_data.php";
            url = url + "?Command=" + "pass_rec";
            url = url + "&refno=" + custno;
            url = url + "&stname=" + stname;

            xmlHttp.onreadystatechange = pass_rec_result;
        
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    } catch (err) {
        alert(err.message);
    }
}

function pass_rec_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmp_no");
        opener.document.form1.tmpno.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_REFNO");
        opener.document.form1.txt_entno.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CODE");
        opener.document.form1.c_code.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");
        opener.document.form1.c_name.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_DATE");
        opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_remarks");
        opener.document.form1.txt_remarks.value = XMLAddress1[0].childNodes[0].nodeValue;

        
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("lc_no");
        opener.document.form1.lc_no.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("department");
        opener.document.form1.department.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("amount");
        opener.document.form1.total_value.value = XMLAddress1[0].childNodes[0].nodeValue;     



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
        opener.document.form1.item_count.value = XMLAddress1[0].childNodes[0].nodeValue;



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg");
        if (XMLAddress1[0].childNodes[0].nodeValue != "") {
            window.opener.document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + XMLAddress1[0].childNodes[0].nodeValue + "</span></div>";
        }
        self.close();
    }
    
}

 

function cancel_inv() {
    $('#myModal_c').modal('hide');

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    document.getElementById('msg_box').innerHTML = "";
    if (document.getElementById('c_name').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Entry</span></div>";
        return false;
    }
    

    var url = "po_data.php";
    url = url + "?Command=" + "del_inv";
    url = url + "&refno=" + document.getElementById('txt_entno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    xmlHttp.onreadystatechange = cancel_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function cancel_result() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        if (xmlHttp.responseText == "ok") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Cancelled</span></div>";
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

function setitem(c1, c2, c3, c4) {

    del_item(c1);
    loc ="del";
    document.getElementById('itemCode').value = c1;
    document.getElementById('itemDesc').value = c2;
    
    document.getElementById('qty').value = c4;

}

function subtotup() {

  qty=  document.getElementById('qty').value; 
  cost=  document.getElementById('itemPrice').value;
  document.getElementById('subtot').value = qty*cost; 
}


function itno_undeliver(itno, stname)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "po_data.php";
    url = url + "?Command=" + "pass_itno";
    url = url + "&itno=" + itno;
    url = url + "&stname=" + stname;
     
    //alert(url);
    xmlHttp.onreadystatechange = itno_undeliver_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);



}

function itno_undeliver_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");
        opener.document.form1.itemCode.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");
        opener.document.form1.itemDesc.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cost");
        opener.document.form1.itemPrice.value = XMLAddress1[0].childNodes[0].nodeValue;

        if (loc == "") {
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("actual_selling");
            opener.document.form1.selling.value = XMLAddress1[0].childNodes[0].nodeValue; 
        }

      
 opener.document.form1.qty.focus();

        self.close();
       



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
    var url = "po_data.php";
    url = url + "?Command=" + "pass_cus";
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

        opener.document.getElementById('c_code').value = obj.CODE;  
        opener.document.getElementById('c_name').value = obj.NAME;   


        self.close();
    }

}
