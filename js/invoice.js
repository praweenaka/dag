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



function print_inv(cdata) {

    var url = "invoice_print.php";
    url = url + "?tmp_no=" + document.getElementById('tmpno').value;
    url = url + "&action=" + cdata;

    window.open(url, '_blank');


}

function add_tmp() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    

    document.getElementById('msg_box').innerHTML =""; 

    
     if (document.getElementById('tmpno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>New Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('c_code').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('jobno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Job Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('cost').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Cost Not Entered</span></div>";
        return false;
    }
    if (document.getElementById('selling').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Selling Not Entered</span></div>";
        return false;
    }
    
        var url = "invoice_data.php";
        url = url + "?Command=" + "setitem";
        url = url + "&Command1=" + "add_tmp";
        url = url + "&txt_entno=" + document.getElementById('txt_entno').value; 
        url = url + "&jobno=" + document.getElementById('jobno').value;
        url = url + "&make=" + document.getElementById('make').value;
        url = url + "&design=" + document.getElementById('design').value; 
        url = url + "&size=" + document.getElementById('size').value;
        url = url + "&serialno=" + document.getElementById('serialno').value;
        url = url + "&adpay=" + document.getElementById('adpay').value;
        url = url + "&cost=" + document.getElementById('cost').value;
        url = url + "&selling=" + document.getElementById('selling').value; 
        url = url + "&dis=" + document.getElementById('dis').value;
        url = url + "&repair=" + document.getElementById('repair').value; 
        url = url + "&subtotal=" + document.getElementById('subtotal').value; 
        url = url + "&tmpno=" + document.getElementById('tmpno').value; 
         url = url + "&invdate=" + document.getElementById('invdate').value; 
        var vattype;
        if (document.getElementById('nonvat').checked == true) {
            vattype = "nonvat";
        }

        if (document.getElementById('vat').checked == true) {
            vattype = "vat";
        }
        url = url + "&vat=" + vattype;
        xmlHttp.onreadystatechange = showarmyresultdel;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

   
}

function showarmyresultdel() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
        document.getElementById('item_count').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");
        document.getElementById('subtot').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("gtot");
        document.getElementById('gtot').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("discount");
        document.getElementById('discount').value = XMLAddress1[0].childNodes[0].nodeValue;
        



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("err");
        if (XMLAddress1[0].childNodes[0].nodeValue=="") {

            document.getElementById('jobno').value = ""; 
            document.getElementById('make').value = "";
            document.getElementById('size').value = "";
            document.getElementById('design').value = "";
            document.getElementById('serialno').value = "";
            document.getElementById('adpay').value = ""; 
            document.getElementById('cost').value = "";
            document.getElementById('selling').value = "";
            document.getElementById('repair').value = "";
            document.getElementById('dis').value = "";
            document.getElementById('subtotal').value = "";

            // document.getElementById('amount').focus();
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + XMLAddress1[0].childNodes[0].nodeValue + "</span></div>";
        }
    }
}



function save_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }


    
    if (document.getElementById('tmpno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>New Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('c_name').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('subtot').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Amount Not Enterd</span></div>";
        return false;
    }


    if (document.getElementById('salesrep').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Rep  Not Selected</span></div>";
        return false;
    }

    var url = "invoice_data.php";
    url = url + "?Command=" + "save_item";

    url = url + "&txt_entno=" + document.getElementById('txt_entno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    url = url + "&customercode=" + document.getElementById('c_code').value;
    url = url + "&customername=" + document.getElementById('c_name').value;
    url = url + "&cus_address=" + document.getElementById('cus_address').value;
    url = url + "&txt_remarks=" + document.getElementById('txt_remarks').value;

    url = url + "&subtot=" + document.getElementById('subtot').value;
    url = url + "&invdate=" + document.getElementById('invdate').value;
  

    url = url + "&salesrep=" + document.getElementById('salesrep').value; 
    url = url + "&DANO=" + document.getElementById('DANO').value;   
    url = url + "&gtot=" + document.getElementById('gtot').value;   

    var vattype;
    if (document.getElementById('nonvat').checked == true) {
        vattype = "nonvat";
    }

    if (document.getElementById('vat').checked == true) {
        vattype = "vat";
    }
    url = url + "&vat=" + vattype;

    if (document.getElementById('paymethod_0').checked == true) {
        paymethod = "CR"; 
    } else if (document.getElementById('paymethod_1').checked == true) {
        paymethod = "CA";
    }
    url = url + "&paymethod=" + paymethod;
    
  
    

    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function salessaveresult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
            print_inv('save');
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

    var paymethod;

    document.getElementById('txt_entno').value = "";
    document.getElementById('c_code').value = "";
    document.getElementById('c_name').value = "";
    document.getElementById('cus_address').value = "";
    document.getElementById('nonvat').checked = true;
    document.getElementById('itemdetails').innerHTML = "";
    document.getElementById('subtot').value = "";
    document.getElementById('msg_box').innerHTML = ""; 
    document.getElementById('jobno').value = "";
    document.getElementById('size').value = "";
    document.getElementById('make').value = "";
    document.getElementById('adpay').value = "";
    document.getElementById('cost').value = "";
    document.getElementById('selling').value = "";
    document.getElementById('repair').value = "";
    document.getElementById('gtot').value = "";
    document.getElementById('txt_remarks').value = ""; 
    document.getElementById('DANO').value = "";
    document.getElementById('subtotal').value = "";
    document.getElementById('discount').value = "";
    document.getElementById('dis').value = ""; 
    document.getElementById('serialno').value = ""; 

    document.getElementById('paymethod_1').checked =true; 

    document.getElementById('vattot').value = "";
    var url = "invoice_data.php";
    url = url + "?Command=" + "new_inv";

    xmlHttp.onreadystatechange = assign_invno;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function assign_invno() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        var idno = XMLAddress1[0].childNodes[0].nodeValue;
        if (idno.length === 1) {
            idno = "I/0000" + idno;
        } else if (idno.length === 2) {
            idno = "I/000" + idno;
        } else if (idno.length === 3) {
            idno = "I/00" + idno;
        } else if (idno.length === 4) {
            idno = "I/0" + idno;
        } else if (idno.length === 5) {
            idno = "I/" + idno;
        }

        document.getElementById("txt_entno").value = idno;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("uniq");
        document.getElementById("tmpno").value = XMLAddress1[0].childNodes[0].nodeValue;

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

    var url = "invoice_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "del_item";
    url = url + "&itemCode=" + cdate;
    url = url + "&invno=" + document.getElementById('txt_entno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    var vattype;
    if (document.getElementById('nonvat').checked == true) {
        vattype = "nonvat";
    }

    if (document.getElementById('vat').checked == true) {
        vattype = "vat";
    }
    url = url + "&vat=" + vattype;

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

        var url = "invoice_data.php";
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
        
         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        var obj = JSON.parse(XMLAddress1[0].childNodes[0].nodeValue);

        opener.document.getElementById('tmpno').value = obj.tmp_no;  
        opener.document.getElementById('txt_entno').value = obj.REF_NO;  
        opener.document.getElementById('c_code').value = obj.C_CODE;  
        opener.document.getElementById('c_name').value = obj.CUS_NAME;  
        opener.document.getElementById('invdate').value = obj.SDATE;  
        opener.document.getElementById('txt_remarks').value = obj.REMARK;  
        opener.document.getElementById('cus_address').value = obj.C_ADD1;  
        opener.document.getElementById('salesrep').value = obj.SAL_EX;  
        opener.document.getElementById('DANO').value = obj.dele_no;   

          

 

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");
        window.opener.document.getElementById('subtot').value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
        opener.document.form1.item_count.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");
        opener.document.form1.subtot.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("gtot");
        opener.document.form1.gtot.value = XMLAddress1[0].childNodes[0].nodeValue;
 
        

        // if (XMLAddress1[0].childNodes[0].nodeValue > 0) {
        //     window.opener.document.getElementById('vat').checked = true;
        // } else {
        //     window.opener.document.getElementById('nonvat').checked = true;
        // }



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
    if (document.getElementById('subtot').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Entry</span></div>";
        return false;
    }

    var url = "invoice_data.php";
    url = url + "?Command=" + "del_inv";
    url = url + "&crnno=" + document.getElementById('txt_entno').value;
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
            setTimeout(function () {
                window.location.reload(1);
            }, 3000);
        } else {
            if (xmlHttp.responseText != "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
            }
        }
    }
}

function calc() {


    var disper = 0;
    var disper1 = 0; 
    var subtot = 0;
    var subtot1 = 0;

    if ((document.getElementById('dis').value != '') && (document.getElementById('dis').value != "0") && (document.getElementById('dis').value != "0.00")) {

        disper = document.getElementById('dis').value;
        disper1 = document.getElementById('dis').value;

    }

    document.getElementById('dis').value = disper;
    subtot1=parseFloat(document.getElementById('repair').value+document.getElementById('selling').value);
    subtot = subtot1 - (subtot1  * parseFloat(document.getElementById('dis').value) / 100);



    document.getElementById('subtotal').value = subtot;

    // add_tmp('up');
}



function tickamouchange(cdate){
 document.getElementById('tick_amou').value="";
 if(cdate=="paymethod_1"){ 
    document.getElementById('tick_amou').disabled = true; 
}else if(cdate=="paymethod_0"){ 
    document.getElementById('tick_amou').disabled = true;
}else{ 
    document.getElementById('tick_amou').disabled = false;
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
    var url = "invoice_data.php";
    url = url + "?Command=" + "pass_card";
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

        opener.document.getElementById('jobno').value = obj.jobno;  
        opener.document.getElementById('make').value = obj.marker;
        opener.document.getElementById('design').value = obj.design;  
        opener.document.getElementById('size').value = obj.size;  
        opener.document.getElementById('serialno').value = obj.serialno;   
        opener.document.getElementById('adpay').value = obj.adpayment;   
        opener.document.getElementById('cost').value = obj.cost;   
        opener.document.getElementById('selling').value = obj.total;   


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
    var url = "invoice_data.php";
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
        opener.document.getElementById('cus_address').value = obj.ADD1;   


        self.close();
    }

}