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

function calc() {


    if (document.getElementById('vatgroup_0').checked == true) {
        if (document.getElementById('vat1').value == "") {
            document.getElementById('vatgroup_1').checked = true;
        }
    }
    if (document.getElementById('vatgroup_2').checked == true) {
        if (document.getElementById('vat2').value == "") {
            document.getElementById('vatgroup_1').checked = true;
        }
    }


    var disper = 0;
    var disper1 = 0;
    var disper2 = 0;
    var disper3 = 0;
    var subtot = 0;

    if ((document.getElementById('discount_org1').value != '') && (document.getElementById('discount_org1').value != "0") && (document.getElementById('discount_org1').value != "0.00")) {

        disper = document.getElementById('discount_org1').value;
        disper1 = document.getElementById('discount_org1').value;

    }


    if ((document.getElementById('discount_org2').value != '') && (document.getElementById('discount_org2').value != "0") && (document.getElementById('discount_org2').value != "0.00")) {


        disper2 = (100 - document.getElementById('discount_org1').value) * (document.getElementById('discount_org2').value) / 100;
        disper = parseFloat(disper1) + parseFloat(disper2);

    }


    if ((document.getElementById('discount_org3').value != '') && (document.getElementById('discount_org3').value != "0") && (document.getElementById('discount_org3').value != "0.00")) {


        disper3 = (100 - (parseFloat(disper1) + parseFloat(disper2))) * (document.getElementById('discount_org3').value) / 100;

        disper = parseFloat(disper1) + parseFloat(disper2) + parseFloat(disper3);

    }

    document.getElementById('discountper').value = disper;

    subtot = parseFloat(document.getElementById('rate').value) - (parseFloat(document.getElementById('rate').value) * parseFloat(document.getElementById('discountper').value) / 100);
    subtot = parseFloat(subtot) * parseFloat(document.getElementById('qty').value);


    document.getElementById('subtotal').value = subtot;

    add_tmp('up');
}




function itno_ind()
{

    if (document.getElementById('itemd_hidden').value != "") {


        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }


        var url = "sales_inv_data.php";
        url = url + "?Command=" + "pass_itno";
        url = url + "&itno=" + document.getElementById('itemd_hidden').value;
        url = url + "&brand=" + document.getElementById('brand').value;
        url = url + "&department=" + document.getElementById('department').value;

        xmlHttp.onreadystatechange = passitresult_ind;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

    }

}

function passitresult_ind()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        var str = xmlHttp.responseText;
        if (str.length > 70) {
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");
            document.getElementById('itemd_hidden').value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");
            document.getElementById('itemd').value = XMLAddress1[0].childNodes[0].nodeValue;



            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");
            document.getElementById('stklevel').value = XMLAddress1[0].childNodes[0].nodeValue;


            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("actual_selling");
            document.getElementById('actual_selling').value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_selpri");
            document.getElementById('rate').value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("costcenter");
            if (XMLAddress1[0].childNodes[0].nodeValue == "1") {
                // document.getElementById('rate').disabled = false;
            } else {
                // document.getElementById('rate').disabled = "disabled";
            }

            document.getElementById('qty').focus();


        } else {


            document.getElementById('searchitem').focus();
        }


    }
}


function load_ord_lst()
{

    NewWindow('search_ord.php?stname=inv_mast', 'mywin', '800', '700', 'yes', 'center');

}

function update_list(stname)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_ord_data.php";
    url = url + "?Command=" + "search_inv";

    if (document.getElementById('invno').value != "") {
        url = url + "&mstatus=invno";
    } else if (document.getElementById('customername').value != "") {
        url = url + "&mstatus=customername";
    } else if (document.getElementById('invdate').value != "") {
        url = url + "&mstatus=rep";
    } else {
        url = url + "&mstatus=";
    }

    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&customername=" + document.getElementById('customername').value;
    url = url + "&rep=" + document.getElementById('invdate').value;

    url = url + "&Option1=" + document.getElementById('Option1').checked;
    url = url + "&Option2=" + document.getElementById('Option2').checked;
    url = url + "&Option3=" + document.getElementById('Option3').checked;
    url = url + "&Option4=" + document.getElementById('Option4').checked;
    url = url + "&Option5=" + document.getElementById('Option5').checked;
    url = url + "&stname=" + stname;
    //alert(url);

    xmlHttp.onreadystatechange = showinvresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function showinvresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}

        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
        //document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('filt_table').innerHTML = xmlHttp.responseText;
    }
}


function cancel_inv() {


    var msg = confirm("Do you want to CANCEL this invoice ! ");
    if (msg == true) {


        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }

        var url = "sales_inv_data.php";
        url = url + "?Command=" + "cancel_inv";
        url = url + "&invno=" + document.getElementById('invno').value;
        url = url + "&invtot=" + document.getElementById('invtot').value;
        url = url + "&customer_code=" + document.getElementById('firstname_hidden').value;
        url = url + "&salesrep=" + document.getElementById('salesrep').value;
        url = url + "&department=" + document.getElementById('department').value;
        url = url + "&tmpno=" + document.getElementById('tmpno').value;


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


function add_tmp(cdata)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    document.getElementById('msg_box').innerHTML = "";

    if (cdata == "add") {

        if (parseFloat(document.getElementById('qty').value) > parseFloat(document.getElementById('stklevel').value)) {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Insufficient Quantity in this Department</span></div>";
            return false;
        }
    }



    var url = "sales_inv_data.php";
    url = url + "?Command=" + "add_tmp";
    url = url + "&Command1=" + cdata;

    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    url = url + "&itemcode=" + document.getElementById('itemd_hidden').value;
    url = url + "&item=" + document.getElementById('itemd').value;


    url = url + "&rate=" + document.getElementById('rate').value;
    url = url + "&actual_selling=" + document.getElementById('actual_selling').value;
    url = url + "&qty=" + document.getElementById('qty').value;

    url = url + "&discountper=" + document.getElementById('discountper').value;
    url = url + "&subtotal=" + document.getElementById('subtotal').value;
    url = url + "&department=" + document.getElementById('department').value;
    url = url + "&brand=" + document.getElementById('brand').value;


    if (document.getElementById('vatgroup_0').checked == true) {
        vatmethod = "vat";
    } else if (document.getElementById('vatgroup_1').checked == true) {
        vatmethod = "non";
    } else if (document.getElementById('vatgroup_2').checked == true) {
        vatmethod = "svat";
    } else if (document.getElementById('vatgroup_3').checked == true) {
        vatmethod = "evat";
    }
    url = url + "&vatmethod=" + vatmethod;

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

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
        document.getElementById('item_count').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");
        document.getElementById('subtot').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totdiscount");
        document.getElementById('totdiscount').value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tax");
        document.getElementById('tax').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invtot");
        document.getElementById('invtot').value = XMLAddress1[0].childNodes[0].nodeValue;



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Command1");
        if (XMLAddress1[0].childNodes[0].nodeValue == "add") {
            document.getElementById('itemd_hidden').value = "";
            document.getElementById('itemd').value = "";
            document.getElementById('rate').value = "";
            document.getElementById('qty').value = "";

            document.getElementById('discountper').value = "";
            document.getElementById('subtotal').value = "";

            document.getElementById('itemd_hidden').focus();
        }
    }
}

function del_item(cdata) {


    var disper = 0;
    var disper1 = 0;
    var disper2 = 0;
    var disper3 = 0;
    var subtot = 0;

    if ((document.getElementById('discount_org1').value != '') && (document.getElementById('discount_org1').value != "0") && (document.getElementById('discount_org1').value != "0.00")) {

        disper = document.getElementById('discount_org1').value;
        disper1 = document.getElementById('discount_org1').value;

    }


    if ((document.getElementById('discount_org2').value != '') && (document.getElementById('discount_org2').value != "0") && (document.getElementById('discount_org2').value != "0.00")) {


        disper2 = (100 - document.getElementById('discount_org1').value) * (document.getElementById('discount_org2').value) / 100;
        disper = parseFloat(disper1) + parseFloat(disper2);

    }


    if ((document.getElementById('discount_org3').value != '') && (document.getElementById('discount_org3').value != "0") && (document.getElementById('discount_org3').value != "0.00")) {


        disper3 = (100 - (parseFloat(disper1) + parseFloat(disper2))) * (document.getElementById('discount_org3').value) / 100;

        disper = parseFloat(disper1) + parseFloat(disper2) + parseFloat(disper3);

    }

    document.getElementById('discountper').value = disper;


    var url = "sales_inv_data.php";
    url = url + "?Command=add_tmp";
    url = url + "&Command1=del";
    url = url + "&id=" + cdata;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    url = url + "&department=" + document.getElementById('department').value;
    url = url + "&brand=" + document.getElementById('brand').value;
    url = url + "&discountper=" + document.getElementById('discountper').value;

    if (document.getElementById('vatgroup_0').checked == true) {
        vatmethod = "vat";
    } else if (document.getElementById('vatgroup_1').checked == true) {
        vatmethod = "non";
    } else if (document.getElementById('vatgroup_2').checked == true) {
        vatmethod = "svat";
    } else if (document.getElementById('vatgroup_3').checked == true) {
        vatmethod = "evat";
    }
    url = url + "&vatmethod=" + vatmethod;

    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function brandsession()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
 

    var url = "sales_inv_data.php";
    url = url + "?Command=" + "brandsession"; 
    url = url + "&brand=" + document.getElementById('brand').value;

    // xmlHttp.onreadystatechange = assign_invno;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function new_inv()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var paymethod;
    document.getElementById('paymethod_0').checked = true;
    document.getElementById('msg_box').innerHTML = "";
    document.getElementById('transp').innerHTML = "";



    document.getElementById('salesord1').value = "";
    document.getElementById('txtreturn').value = "0";
    //document.getElementById('salesord2').value="";
    document.getElementById('invno').value = "";

    document.getElementById('crebal').value = "";




    document.getElementById('firstname_hidden').value = "";

    document.getElementById('firstname').value = "";
    document.getElementById('cus_address').value = "";
    document.getElementById('cus_address2').value = "";

    document.getElementById('vat1').value = "";
    document.getElementById('vat2').value = "";
    document.getElementById('creditlimit').value = "";
    document.getElementById('balance').value = "";
    document.getElementById('txtinvt').value = "";


    document.getElementById('over60').value = "0";
    document.getElementById("promotion").checked = false;


    var objdepartment = document.getElementById("department");
    objdepartment.options[0].selected = true;

    var objbrand = document.getElementById("brand");
    objbrand.options[0].selected = true;



    document.getElementById('vatgroup_0').checked = true;
    document.getElementById('discount_org1').value = "";
    document.getElementById('discount_org2').value = "";
    document.getElementById('discount_org3').value = "";
    document.getElementById('itemdetails').innerHTML = "";
    document.getElementById('subtot').value = "";
    document.getElementById('totdiscount').value = "";
    document.getElementById('tax').value = "";
    document.getElementById('invtot').value = "";
    document.getElementById('subtotal').value = "";

    document.getElementById('itemd_hidden').value = "";
    document.getElementById('itemd').value = "";
    document.getElementById('rate').value = "";
    document.getElementById('qty').value = "";
    document.getElementById('discountper').value = "";
    document.getElementById('stklevel').value = "";
    document.getElementById('storgrid').innerHTML = "";


    document.getElementById('delitype').value = "NORMAL";

    document.getElementById("deli_chk").checked = false;
    document.getElementById("deli_label").style.visibility = 'hidden';
    document.getElementById("deli_name").style.visibility = 'hidden';
    document.getElementById("deli_address").style.visibility = 'hidden';
    document.getElementById("deli_upbut").style.visibility = 'hidden';
    document.getElementById('msg_boxdeliup').innerHTML = "";
    document.getElementById('deli_name').value = "";
    document.getElementById('deli_address').value = "";
    document.getElementById('credper').value = "90";
    document.getElementById("cred_up_but").style.visibility = 'hidden';

    document.getElementById("printdeli").style.visibility = 'hidden';
    document.getElementById('msg_boxcredup').innerHTML = "";

    var url = "sales_inv_data.php";
    url = url + "?Command=" + "new_inv";
    url = url + "&salesrep=" + document.getElementById('salesrep').value;
    url = url + "&brand=" + document.getElementById('brand').value;

    xmlHttp.onreadystatechange = assign_invno;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function assign_invno() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");
        document.getElementById('invno').value = XMLAddress1[0].childNodes[0].nodeValue;

//        document.getElementById('invdate').value = "2019-12-02"
XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sdate");
document.getElementById('invdate').value = XMLAddress1[0].childNodes[0].nodeValue;

XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
document.getElementById('tmpno').value = XMLAddress1[0].childNodes[0].nodeValue;


}



}


function invno(invno, stname)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    



    if (stname == "inv_mast") {

        if (opener.document.form1.invno.value != "") {
            opener.document.form1.txtreturn.value = "0";

            var url = "search_ord_data.php";
            url = url + "?Command=" + "pass_invno_to_inv";
            url = url + "&invno=" + invno;
            url = url + "&stname=" + stname;
            url = url + "&newinvno=" + opener.document.form1.invno.value
            url = url + "&invdate=" + opener.document.form1.invdate.value
            url = url + "&salesrep=" + opener.document.form1.salesrep.value

            url = url + "&custno=" + opener.document.form1.firstname_hidden.value;
            url = url + "&brand=" + opener.document.form1.brand.value;
            url = url + "&department=" + opener.document.form1.department.value;

            xmlHttp.onreadystatechange = passinvresult;
            xmlHttp.open("GET", url, true);
            xmlHttp.send(null);
            //alert(url);
        } else {
            alert("Please insert invoice no");
            self.close();
        }

    } else {
        var url = "search_ord_data.php";
        url = url + "?Command=" + "pass_invno";
        url = url + "&invno=" + invno;
        url = url + "&stname=" + stname;

        url = url + "&custno=" + opener.document.form1.firstname_hidden.value;
        url = url + "&brand=" + opener.document.form1.brand.value;
        url = url + "&department=" + opener.document.form1.department.value;

        xmlHttp.onreadystatechange = passinvresult_ord;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }





    //alert(url);




}


function passinvresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        if (xmlHttp.responseText == "Please click New again!!!") {
            alert(xmlHttp.responseText);
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
        opener.document.form1.item_count.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
        opener.document.form1.tmpno.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sdate");
        opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_invoiceno");
        opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Result");
        opener.document.form1.Result.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("trans");
        if (XMLAddress1[0].childNodes[0].nodeValue == "true") {
            window.opener.document.getElementById('transp').innerHTML = '<div style="background-color:#FF0000"><font size="+3">Transport</font></div>';
        } else {
            window.opener.document.getElementById('transp').innerHTML = "";
        }


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_order_no");

        opener.document.form1.salesord1.value = XMLAddress1[0].childNodes[0].nodeValue;
        opener.document.form1.ordno.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customecode");
        opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
        opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address");
        opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address2");
        opener.document.form1.cus_address2.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_subcode");
        opener.document.form1.c_subcode.value = XMLAddress1[0].childNodes[0].nodeValue;


        opener.document.form1.vatgroup_1.checked = true;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vat");
        if (XMLAddress1[0].childNodes[0].nodeValue == "0") {
            opener.document.form1.vatgroup_1.checked = true;
        } else if (XMLAddress1[0].childNodes[0].nodeValue == "1") {
            opener.document.form1.vatgroup_0.checked = true;
        } else if (XMLAddress1[0].childNodes[0].nodeValue == "2") {
            opener.document.form1.vatgroup_2.checked = true;
        } else if (XMLAddress1[0].childNodes[0].nodeValue == "3") {
            opener.document.form1.vatgroup_3.checked = true;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno1");
        opener.document.form1.vat1.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno2");
        opener.document.form1.vat2.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_salesrep");
        opener.document.getElementById("salesrep").value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("creditbalance");
        opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("crebal");
        opener.document.form1.crebal.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("netqty");
        opener.document.form1.txtinvt.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_department");
        opener.document.getElementById("department").value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_brand");
        opener.document.getElementById("brand").value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");
        opener.document.form1.discount_org1.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis1");
        opener.document.form1.discount_org2.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis2");
        opener.document.form1.discount_org3.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_subtotal");
        opener.document.form1.subtot.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount");
        opener.document.form1.totdiscount.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_tax");
        opener.document.form1.tax.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_invoiceval");
        opener.document.form1.invtot.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
        opener.document.form1.item_count.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");
        opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");
        opener.document.form1.discount_org1.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("over60_txt");
        opener.document.form1.over60.value = XMLAddress1[0].childNodes[0].nodeValue;



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("over60_qst");
        if (XMLAddress1[0].childNodes[0].nodeValue != "") {
            alert(XMLAddress1[0].childNodes[0].nodeValue);
        }
        if ((XMLAddress1[0].childNodes[0].nodeValue == "You have approved for proceed") || (XMLAddress1[0].childNodes[0].nodeValue == "")) {
            opener.document.form1.over60.value = "0";
        }


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");
        window.opener.document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

//edited 18.05.10 praweenaka
XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("type1");
var cre1 = (XMLAddress1[0].childNodes[0].nodeValue).toString();

if (cre1 === "TBR") {
    opener.document.form1.credper.value = 60;
} else {
    opener.document.form1.credper.value = 60;
}
//
XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("AltMessage");
if (XMLAddress1[0].childNodes[0].nodeValue != "") {
    alert(XMLAddress1[0].childNodes[0].nodeValue);
}

XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bank_message");
if (XMLAddress1[0].childNodes[0].nodeValue != "") {
    alert(XMLAddress1[0].childNodes[0].nodeValue);
}

XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("over60_message");
if (XMLAddress1[0].childNodes[0].nodeValue != "") {
    alert(XMLAddress1[0].childNodes[0].nodeValue);
}

XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_message");
if (XMLAddress1[0].childNodes[0].nodeValue != "") {
    alert(XMLAddress1[0].childNodes[0].nodeValue);
}

XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_message_que");
if (XMLAddress1[0].childNodes[0].nodeValue != "") {
    var ans = confirm(XMLAddress1[0].childNodes[0].nodeValue);
    if (ans == true) {
        opener.document.form1.txtreturn.value = "0";
    } else {
        opener.document.form1.txtreturn.value = "1";
    }
}


self.close();

}
}


function save_inv() {


    document.getElementById('msg_box').innerHTML = "";

    if (document.getElementById('salesord1').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Cannot Save without Order No</span></div>";
        return false;
    }

    // if ((document.getElementById('txtreturn').value != "0") && (document.getElementById('Result').value != "OK")) {
    //     document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Return Cheque Available !!!</span></div>";
    //     return false;
    // }

    // if ((document.getElementById('over60').value == "60") && (document.getElementById('Result').value != "OK")) {
    //     document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Over 60 outstanding available !!!</span></div>";
    //     return false;
    // }

    if (parseFloat(document.getElementById('item_count').value) < 1) {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Please insert items</span></div>";
        return false;
    }

    var balance = document.getElementById('balance').value;
    var crebal = 0;
    if (document.getElementById('crebal').value != "") {
        crebal = document.getElementById('crebal').value;
    }

    i = 0;
    while (i < 4) {
        balance = balance.replace(",", "");
        i = i + 1;
    }

    var invtot = document.getElementById('invtot').value;
    i = 0;
    while (i < 4) {
        invtot = invtot.replace(",", "");
        i = i + 1;
    }

    var crebal = document.getElementById('crebal').value;
    i = 0;
    while (i < 4) {
        crebal = crebal.replace(",", "");
        i = i + 1;
    }

    // if (((parseFloat(crebal) < 0) || (parseFloat(crebal) < parseFloat(invtot))) && (document.getElementById('Result').value != "OK"))
    // {
    //     document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Credit Limit Exceeded</span></div>";
    //     return false;
    // }


    var url = "sales_inv_data.php";
    url = url + "?Command=" + "save_inv";
    if (document.getElementById('paymethod_0').checked == true) {
        paymethod = "CR";
    } else if (document.getElementById('paymethod_1').checked == true) {
        paymethod = "CA";
    }
    url = url + "&paymethod=" + paymethod;
    url = url + "&salesord1=" + document.getElementById('salesord1').value;
    url = url + "&ordno=" + document.getElementById('ordno').value;
    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;

    url = url + "&invdate=" + document.getElementById('invdate').value;
    url = url + "&customercode=" + document.getElementById('firstname_hidden').value;
    url = url + "&c_subcode=" + document.getElementById('c_subcode').value;
    url = url + "&delitype=" + document.getElementById('delitype').value;


    myString = document.getElementById('firstname').value;
    myString = myString.replace(/&/g, "~");
    url = url + "&customername=" + myString;

    myString = document.getElementById('cus_address').value;
    myString = myString.replace(/&/g, "~");
    url = url + "&cus_address=" + myString;
    //	url=url+"&orderno1="+document.getElementById('orderno1').value;
    //	url=url+"&orderdate="+document.getElementById('orderdate').value;
    url = url + "&vat1=" + document.getElementById('vat1').value;
    url = url + "&vat2=" + document.getElementById('vat2').value;
    url = url + "&creditlimit=" + document.getElementById('creditlimit').value;
    url = url + "&balance=" + document.getElementById('balance').value;
    url = url + "&salesrep=" + document.getElementById('salesrep').value;
    url = url + "&department=" + document.getElementById('department').value;
    url = url + "&brand=" + document.getElementById('brand').value;


    if (document.getElementById('vatgroup_0').checked == true) {
        vatmethod = "vat";
    } else if (document.getElementById('vatgroup_1').checked == true) {
        vatmethod = "non";
    } else if (document.getElementById('vatgroup_2').checked == true) {
        vatmethod = "svat";
    } else if (document.getElementById('vatgroup_3').checked == true) {
        vatmethod = "evat";
    }

    url = url + "&vatmethod=" + vatmethod;
    url = url + "&discount_org1=" + document.getElementById('discount_org1').value;
    url = url + "&discount_org2=" + document.getElementById('discount_org2').value;
    url = url + "&discount_org3=" + document.getElementById('discount_org3').value;


    url = url + "&subtot=" + document.getElementById('subtot').value;
    url = url + "&totdiscount=" + document.getElementById('totdiscount').value;
    url = url + "&tax=" + document.getElementById('tax').value;
    url = url + "&invtot=" + document.getElementById('invtot').value;
    url = url + "&credper=" + document.getElementById('credper').value;


    if (document.getElementById('promotion').checked == true) {
        url = url + "&promotion=1";
    } else {
        url = url + "&promotion=0";
    }

    url = url + "&deli_name=" + document.getElementById('deli_name').value;
    url = url + "&deli_address=" + document.getElementById('deli_address').value;

    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);





}

function salessaveresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        var res = xmlHttp.responseText;
        var str = res.replace("Saved", "");
        var n = res.endsWith("Saved");

        if (n == true) {

            document.getElementById('invno').value = str;
            print_inv();
            new_inv();
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

function update_list_inv(stname)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_inv_data.php";
    url = url + "?Command=" + "search_inv";

    if (document.getElementById('invno').value != "") {
        url = url + "&mstatus=invno";
    } else if (document.getElementById('customername').value != "") {
        url = url + "&mstatus=customername";
    } else {
        url = url + "&mstatus=";
    }

    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&customername=" + document.getElementById('customername').value;
    url = url + "&stname=" + stname;


    xmlHttp.onreadystatechange = showinvresult_inv;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function showinvresult_inv()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        document.getElementById('filt_table').innerHTML = xmlHttp.responseText;
    }
}


function invno_inv(invno, stname)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (stname == "grn") {
        var url = "search_inv_data.php";
        url = url + "?Command=" + "pass_grn";
        url = url + "&invno=" + invno;

        //alert(url);
        xmlHttp.onreadystatechange = passinvresult_grn;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    } else if (stname == "search_grn") {
        var url = "search_inv_data.php";
        url = url + "?Command=" + "pass_search_grn";
        url = url + "&invno=" + invno;

        //alert(url);
        xmlHttp.onreadystatechange = passinvresult_search_grn;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    } else if (stname == "crn") {
        var url = "search_inv_data.php";
        url = url + "?Command=" + "pass_crn";
        url = url + "&invno=" + invno;

        //alert(url);
        xmlHttp.onreadystatechange = passinvresult_crn;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    } else {
        var url = "search_inv_data.php";
        url = url + "?Command=" + "pass_invno";
        url = url + "&invno=" + invno;
        url = url + "&custno=" + opener.document.form1.firstname_hidden.value;
        url = url + "&brand=" + opener.document.form1.brand.value;
        url = url + "&department=" + opener.document.form1.department.value;


        xmlHttp.onreadystatechange = passinvresult_inv;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
    //alert(url);




}

function passinvresult_inv()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //  alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_invoiceno");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
        //alert(XMLAddress1[0].childNodes[0].nodeValue);
        opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
        //opener.document.form1.invno.value = "111111111";

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");
        opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;

        // XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TYPE");
        // if (XMLAddress1[0].childNodes[0].nodeValue == "CR") {
        //     opener.document.form1.paymethod_0.checked = true;
        // } else {
        //     opener.document.form1.paymethod_1.checked = true;
        // }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customecode");
        opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
        opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address");
        opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address2");
        opener.document.form1.cus_address2.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno1");
        opener.document.form1.vat1.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno2");
        opener.document.form1.vat2.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_salesrep");
        opener.document.getElementById("salesrep").value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("delitype");
        opener.document.getElementById("delitype").value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_orderno1");
        opener.document.form1.salesord1.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_department");
        opener.document.getElementById("department").value = XMLAddress1[0].childNodes[0].nodeValue;



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_brand");
        opener.document.getElementById("brand").value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("promotion");
        if (XMLAddress1[0].childNodes[0].nodeValue == "1") {
            opener.document.getElementById("promotion").checked = true;
        } else {
            opener.document.getElementById("promotion").checked = false;
        }


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vat");

        if (XMLAddress1[0].childNodes[0].nodeValue == '1')
        {
            opener.document.form1.vatgroup_0.checked = true;

        } else if (XMLAddress1[0].childNodes[0].nodeValue == '2')
        {
            opener.document.form1.vatgroup_2.checked = true;

        } else if (XMLAddress1[0].childNodes[0].nodeValue == '3')
        {
            opener.document.form1.vatgroup_3.checked = true;

        } else {
            opener.document.form1.vatgroup_1.checked = true;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SVAT");
        if (XMLAddress1[0].childNodes[0].nodeValue > 0) {
            opener.document.form1.vatgroup_2.checked = true;
        }


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_subtotal");
        opener.document.form1.subtot.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount");
        opener.document.form1.totdiscount.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount1");
        opener.document.form1.discount_org1.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount2");
        opener.document.form1.discount_org2.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount3");
        opener.document.form1.discount_org3.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_tax");
        opener.document.form1.tax.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_invoiceval");
        opener.document.form1.invtot.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");
        opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");
        opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");
        window.opener.document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("deli_chk1");

        if (XMLAddress1[0].childNodes[0].nodeValue == 'Y')
        {
            opener.document.getElementById("deli_chk").checked = true;

        } else {
            opener.document.getElementById("deli_chk").checked = false;
        }
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cred_but");

        if (XMLAddress1[0].childNodes[0].nodeValue == 'Y')
        {
            opener.document.getElementById("cred_up_but").style.visibility = 'visible';
        } else {
            opener.document.getElementById("cred_up_but").style.visibility = 'hidden';
        }

        opener.document.getElementById("deli_label").style.visibility = 'visible';
        opener.document.getElementById("printdeli").style.visibility = 'visible';
        opener.document.getElementById("deli_name").style.visibility = 'visible';
        opener.document.getElementById("deli_address").style.visibility = 'visible';
        opener.document.getElementById("deli_upbut").style.visibility = 'visible';

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("deli_name");
        opener.document.form1.deli_name.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("deli_add");
        opener.document.form1.deli_address.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cred_per");
        opener.document.form1.credper.value = XMLAddress1[0].childNodes[0].nodeValue;

        self.close();

    }
}


function print_inv()
{

    if (document.getElementById('promotion').checked == true) {
        var url = "rep_inv_1.php";
    } else {
        var url = "rep_inv.php";
    }
    url = url + "?invno=" + document.getElementById('invno').value;

    if (document.getElementById('deli_chk').checked == true) {
        url = url + "&delivachk=Y";
    } else {
        url = url + "&delivachk=N";
    }

    myString = document.getElementById('firstname').value;
    myString = myString.replace(/&/g, "~");
    url = url + "&cus_name=" + myString;

    myString = document.getElementById('cus_address').value;
    myString = myString.replace(/&/g, "~");
    url = url + "&cus_address=" + myString;

    url = url + "&vat1=" + document.getElementById('vat1').value;
    url = url + "&vat2=" + document.getElementById('vat2').value;

    window.open(url);

}


function print_inv_net()
{

    var url = "rep_inv_1.php";
    url = url + "?invno=" + document.getElementById('invno').value;


    myString = document.getElementById('firstname').value;
    myString = myString.replace(/&/g, "~");
    url = url + "&cus_name=" + myString;

    myString = document.getElementById('cus_address').value;
    myString = myString.replace(/&/g, "~");
    url = url + "&cus_address=" + myString;

    url = url + "&vat1=" + document.getElementById('vat1').value;
    url = url + "&vat2=" + document.getElementById('vat2').value;

    window.open(url);

}



//function delichk() {
//    document.getElementById("deli_label").style.visibility = 'visible';
//    document.getElementById("deli_name").style.visibility = 'visible';
//    document.getElementById("deli_address").style.visibility = 'visible';
//}
function delichk() {
    if (document.getElementById('itemdetails').innerHTML == "") {
        document.getElementById("deli_label").style.visibility = 'visible';
        document.getElementById("deli_name").style.visibility = 'visible';
        document.getElementById("deli_address").style.visibility = 'visible';

    } else {
        document.getElementById("deli_label").style.visibility = 'visible';
        document.getElementById("deli_name").style.visibility = 'visible';
        document.getElementById("deli_address").style.visibility = 'visible';
        document.getElementById("deli_upbut").style.visibility = 'visible';
        document.getElementById("printdeli").style.visibility = 'visible';

    }

}

function deli_update() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    if (document.getElementById('deli_name').value == "") {
        document.getElementById('msg_boxdeliup').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Empty Delivary Name...</span></div>";
        return false;
    }
    if (document.getElementById('deli_address').value == "") {
        document.getElementById('msg_boxdeliup').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Empty Delivary Address...</span></div>";
        return false;
    }

    var url = "sales_inv_data.php";
    url = url + "?Command=" + "deli_update";

    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&deli_name=" + document.getElementById('deli_name').value;
    url = url + "&deli_address=" + document.getElementById('deli_address').value;

    xmlHttp.onreadystatechange = salessaveresult_deliup;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function salessaveresult_deliup()
{

    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        document.getElementById('msg_boxdeliup').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        setTimeout(function () {
            new_inv();
        }, 1000);
    }
}


function credupdate() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    if (document.getElementById('credper').value == "") {
        document.getElementById('msg_boxcredup').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Empty Credit Period...</span></div>";
        return false;
    }
    var url = "sales_inv_data.php";
    url = url + "?Command=" + "cred_update";

    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&credper=" + document.getElementById('credper').value;

    xmlHttp.onreadystatechange = credupdate_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function credupdate_result()
{

    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        document.getElementById('msg_boxcredup').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        setTimeout(function () {
            new_inv();
        }, 1000);
    }
}

function print_deli()
{

    var url = "rep_inv_deli.php";
    url = url + "?invno=" + document.getElementById('invno').value;

    if (document.getElementById('deli_chk').checked == true) {
        url = url + "&delivachk=Y";
    } else {
        url = url + "&delivachk=N";
    }

    window.open(url);

}