function GetXmlHttpObject()
{
    var xmlHttp = null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    }
    catch (e)
    {
        // Internet Explorer
        try
        {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}


function keyset(key, e)
{

    if (e.keyCode == 13) {
        document.getElementById(key).focus();
    }
}

function got_focus(key)
{
    document.getElementById(key).style.backgroundColor = "#000066";

}

function lost_focus(key)
{
    document.getElementById(key).style.backgroundColor = "#000000";

}


function saveimage(image_name, cou)
{
    picnum = 'uploaded_pic' + cou;
    pichid = 'pic' + cou;

    window.opener.document.getElementById(picnum).innerHTML = "<img src='upload/" + image_name + "' />";
    window.opener.document.getElementById(pichid).value = image_name;

}


function setitem()
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "inv_data.php";

    url = url + "?Command=" + "setitem";
    url = url + "&itemd_hidden=" + document.getElementById('itemd_hidden').value;
    url = url + "&department=" + document.getElementById('department').value;

    var vatmethod = "";
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
    //alert(url);

    xmlHttp.onreadystatechange = setitem_results;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function setitem_results()
{
    var XMLAddress1;
    //alert(xmlHttp.responseText);
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("STK_NO");
        document.getElementById('itemd_hidden').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DESCRIPT");
        document.getElementById('itemd').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SELLING");
        document.getElementById('rate').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");
        document.getElementById('stklevel').value = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('qty').focus();
    }
}

function chk_number()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "inv_data.php";

    url = url + "?Command=" + "chk_number";
    //$_FILES["image"]["name"][$key] ;

    url = url + "&txt_cuscode=" + document.getElementById('txt_cuscode').value;
    //alert(url);
    xmlHttp.onreadystatechange = chk_number_results;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function chk_number_results()
{
    var XMLAddress1;
    //alert(xmlHttp.responseText);
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        //	document.getElementById("message").innerHTML=xmlHttp.responseText;
        //	setTimeout("location.reload(true);",1000);
        if (xmlHttp.responseText == "included") {
            alert("Already Included Stock No ! ");
            location.reload(true);
        }


    }
}

function add_address()
{

    //alert("ok");
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "inv_data.php";
    url = url + "?Command=" + "add_address";
    url = url + "&customerid=" + document.getElementById('firstname_hidden').value;
    //alert(url);
    xmlHttp.onreadystatechange = showarmyresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showarmyresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}

        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
        document.getElementById('cus_address').value = xmlHttp.responseText;
    }
}

function note_update()
{

    //alert("ok");
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    document.getElementById('txtnote').value = document.getElementById('txtnote').value + document.getElementById('txt_new').value;

    var url = "search_custom_data.php";

    var params = "Command=" + "note_update";
    params = params + "&txt_cuscode=" + document.getElementById('txt_cuscode').value;
    params = params + "&txtnote=" + escape(document.getElementById('txtnote').value);

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = result_note_update;

    xmlHttp.send(params);


}

function result_note_update()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert("ok");
        //var txt_cuscode=document.getElementById('txt_cuscode').value
        //custno(txt_cuscode, "cust_mast");

        //alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}

        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
        //document.getElementById('cus_address').value= xmlHttp.responseText;
    }
}

function app_only_for()
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    document.getElementById('txtnote').value = document.getElementById('txtnote').value + document.getElementById('txt_new').value;

    var url = "search_custom_data.php";
    url = url + "?Command=" + "app_only_for";
    url = url + "&txt_cuscode=" + document.getElementById('txt_cuscode').value;
    url = url + "&DT_Over_DUE_IG=" + document.getElementById('DT_Over_DUE_IG').value;
    //alert(url);
    xmlHttp.onreadystatechange = result_app_only_for;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function result_app_only_for()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert("ok");

        alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}

        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("army_table");	
        //document.getElementById('cus_address').value= xmlHttp.responseText;
    }
}

function calc1()
{

    //alert("ok");
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    //alert (document.getElementById('stklevel').value);
    //alert(document.getElementById('qty').value);
    if (parseFloat(document.getElementById('qty').value) <= parseFloat(document.getElementById('stklevel').value)) {
        var str = document.getElementById('rate').value;
        var n = str.replace(/,/gi, "");

        var subtotal = parseFloat(n) * parseFloat(document.getElementById('qty').value);
        var dis = 0;
        var dis1 = 0;
        var dis2 = 0;
        var dis3 = 0;
        var disper = 0;
        var dis1f = 0;
        var dis2f = 0;
        var dis3f = 0;


        if ((document.getElementById('discount_org1').value != '') && (document.getElementById('discount_org1').value != "0") && (document.getElementById('discount_org1').value != "0.00")) {
            dis1 = subtotal * document.getElementById('discount_org1').value / 100;
            disper = document.getElementById('discount_org1').value;
            disper1 = document.getElementById('discount_org1').value;

        }
        dis1f = dis1.toFixed(2);
        subtotal = subtotal - dis1f;

        if ((document.getElementById('discount_org2').value != '') && (document.getElementById('discount_org2').value != "0") && (document.getElementById('discount_org2').value != "0.00")) {
            dis2 = subtotal * document.getElementById('discount_org2').value / 100;
            //disper=100-(100-document.getElementById('discount_org2').value)*(100-document.getElementById('discount_org1').value)/100;
            disper2 = (100 - document.getElementById('discount_org1').value) * (document.getElementById('discount_org2').value) / 100;
            disper = parseFloat(disper1) + parseFloat(disper2);

        }
        dis2f = dis2.toFixed(2);
        subtotal = subtotal - dis2f;

        if ((document.getElementById('discount_org3').value != '') && (document.getElementById('discount_org3').value != "0") && (document.getElementById('discount_org3').value != "0.00")) {
            dis3 = subtotal * document.getElementById('discount_org3').value / 100;
            //disper=100-(100-document.getElementById('discount_org3').value)*(100-document.getElementById('discount_org2').value)*(100-document.getElementById('discount_org1').value)/100;
            disper3 = (100 - (parseFloat(disper1) + parseFloat(disper2))) * (document.getElementById('discount_org3').value) / 100;

            disper = parseFloat(disper1) + parseFloat(disper2) + parseFloat(disper3);

        }
        dis3f = dis3.toFixed(2);
        subtotal = subtotal - dis3f;

        dis = parseFloat(dis1f) + parseFloat(dis2f) + parseFloat(dis3f);

        document.getElementById('discount').value = dis;
        document.getElementById('discountper').value = disper;
        document.getElementById('subtotal').value = subtotal.toFixed(2);

    } else {
        alert("Insufficient Quantity in this Department");
    }


}

function calc1_table(i)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    id = "id" + i;
    code = "code" + i;
    itemd = "itemd" + i;
    rate = "rate" + i;
    actual_selling = "actual_selling" + i;
    qty = "qty" + i;
    discount = "discount" + i;
    total = "total" + i;
    discountper = "discountper" + i;
    subtotal_name = "subtotal" + i;
    ad = "ad" + i;


    var str = document.getElementById(actual_selling).value;
    var n = str.replace(/,/gi, "");
    var vatrate = 0.08;   //vat rate
    var SELLING = 0;

    var actual_rate = n;

    if (document.getElementById('vatgroup_1').checked == true) {
        SELLING = n;
    } else {
        SELLING = n / (vatrate + 1);
    }
    //alert(SELLING);
    var subtotal = parseFloat(SELLING) * parseFloat(document.getElementById(qty).value);



    //var subtotal=parseFloat(n)*parseFloat(document.getElementById(qty).value);

    var dis = 0;
    var dis1 = 0;
    var dis2 = 0;
    var dis3 = 0;
    var disper = 0;
    var dis1f = 0;
    var dis2f = 0;
    var dis3f = 0;


    if ((document.getElementById('discount_org1').value != '') && (document.getElementById('discount_org1').value != "0") && (document.getElementById('discount_org1').value != "0.00")) {
        dis1 = subtotal * document.getElementById('discount_org1').value / 100;
        disper = document.getElementById('discount_org1').value;

    }
    dis1f = dis1.toFixed(2);
    subtotal = subtotal - dis1f;

    if ((document.getElementById('discount_org2').value != '') && (document.getElementById('discount_org2').value != "0") && (document.getElementById('discount_org2').value != "0.00")) {
        dis2 = subtotal * document.getElementById('discount_org2').value / 100;
        disper = 100 - (100 - document.getElementById('discount_org2').value) * (100 - document.getElementById('discount_org1').value) / 100;

    }
    dis2f = dis2.toFixed(2);
    subtotal = subtotal - dis2f;

    if ((document.getElementById('discount_org3').value != '') && (document.getElementById('discount_org3').value != "0") && (document.getElementById('discount_org3').value != "0.00")) {
        dis3 = subtotal * document.getElementById('discount_org3').value / 100;
        disper = 100 - (100 - document.getElementById('discount_org3').value) * (100 - document.getElementById('discount_org2').value) * (100 - document.getElementById('discount_org1').value) / 100;

    }
    dis3f = dis3.toFixed(2);
    subtotal = subtotal - dis3f;

    dis = parseFloat(dis1f) + parseFloat(dis2f) + parseFloat(dis3f);

    document.getElementById(discount).value = dis;
    document.getElementById(discountper).innerHTML = disper;

    document.getElementById(subtotal_name).innerHTML = subtotal.toFixed(2);


    //////////////////////////////////////////////////////////////////////////////
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    if ((document.getElementById('invno').value != "") && (document.getElementById('firstname_hidden').value != "")) {

        //	document.getElementById('discount1').disabled=true;
        //	document.getElementById('discount2').disabled=true;
        //	document.getElementById('discount3').disabled=true;

        var url = "inv_data.php";
        url = url + "?Command=" + "add_tmp_edit_rate";
        url = url + "&invno=" + document.getElementById('invno').value;


        url = url + "&id=" + document.getElementById(id).innerHTML;

        url = url + "&itemcode=" + document.getElementById(code).innerHTML;

        url = url + "&item=" + document.getElementById(itemd).innerHTML;
        //url=url+"&rate="+document.getElementById(rate).value;
        url = url + "&rate=" + SELLING;


        //url=url+"&actual_selling="+document.getElementById(actual_selling).value;
        url = url + "&actual_selling=" + actual_rate;

        url = url + "&qty=" + document.getElementById(qty).value;
        url = url + "&discount=" + document.getElementById(discount).value;
        url = url + "&discountper=" + document.getElementById(discountper).innerHTML;
        url = url + "&subtotal=" + document.getElementById(subtotal_name).innerHTML;
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

        //alert(url);
        xmlHttp.onreadystatechange = showarmyresultdel;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

    } else if (document.getElementById('salesord1').value == "") {
        alert("Order No is EMPTY ! ");
    } else if (document.getElementById('firstname_hidden').value == "") {
        alert("Please Select Customer");
    }

}


function calc1_table_discount1()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (document.getElementById('vatgroup_0').checked == true) {
        if (document.getElementById('vat1').value == "") {
            document.getElementById('vatgroup_1').checked = true
            return false;
        }
    }

    if (document.getElementById('vatgroup_2').checked == true) {
        if (document.getElementById('vat2').value == "") {
            document.getElementById('vatgroup_1').checked = true
            return false;
        }
    }

    var j = 1;
    while (document.getElementById('item_count').value > j) {

        id = "id" + j;
        code = "code" + j;
        itemd = "itemd" + j;
        rate = "rate" + j;
        actual_selling = "actual_selling" + j;
        qty = "qty" + j;
        discount = "discount" + j;
        total = "total" + j;
        discountper = "discountper" + j;
        subtotal_name = "subtotal" + j;
        ad = "ad" + j;

        //var str=document.getElementById(rate).value;
        //var n=str.replace(/,/gi, ""); 

        var str = document.getElementById(actual_selling).value;
        var n = str.replace(/,/gi, "");
        var vatrate = 0.08;   //vatrate
        var SELLING = 0;

        if (document.getElementById('vatgroup_1').checked == true) {
            SELLING = n;
        } else {
            SELLING = n / (vatrate + 1);
        }
        var subtotal = parseFloat(SELLING) * parseFloat(document.getElementById(qty).value);

        var dis = 0;
        var dis1 = 0;
        var dis2 = 0;
        var dis3 = 0;
        var disper = 0;
        var dis1f = 0;
        var dis2f = 0;
        var dis3f = 0;


        if ((document.getElementById('discount_org1').value != '') && (document.getElementById('discount_org1').value != "0") && (document.getElementById('discount_org1').value != "0.00")) {
            //dis1=subtotal*document.getElementById('discount1').value/100;

            //var srate=document.getElementById(rate).value;
            //valrate=srate.replace(/,/gi, "");
            valrate = SELLING;
            var sqty = document.getElementById(qty).value;
            valqty = sqty.replace(/,/gi, "");

            var valsubstr = valrate * valqty;
            //var valsubstr=strsubt.replace(/,/gi, "");

            dis1 = valsubstr * document.getElementById('discount_org1').value / 100;
            disper1 = document.getElementById('discount_org1').value;
            disper = document.getElementById('discount_org1').value;

            dis1f = dis1.toFixed(2);
            subtotal = valsubstr - dis1f;

        }


        if ((document.getElementById('discount_org2').value != '') && (document.getElementById('discount_org2').value != "0") && (document.getElementById('discount_org2').value != "0.00")) {



            dis2 = subtotal * document.getElementById('discount_org2').value / 100;
            disper2 = (100 - document.getElementById('discount_org1').value) * (document.getElementById('discount_org2').value) / 100;
            disper = parseFloat(disper1) + parseFloat(disper2);


            dis2f = dis2.toFixed(2);
            subtotal = subtotal - dis2f;
        }


        if ((document.getElementById('discount_org3').value != '') && (document.getElementById('discount_org3').value != "0") && (document.getElementById('discount_org3').value != "0.00")) {
            //alert(disper2);
            dis3 = subtotal * document.getElementById('discount_org3').value / 100;
            disper3 = (100 - (parseFloat(disper1) + parseFloat(disper2))) * (document.getElementById('discount_org3').value) / 100;

            disper = parseFloat(disper1) + parseFloat(disper2) + parseFloat(disper3);

            dis3f = dis3.toFixed(2);
            subtotal = subtotal - dis3f;

        }


        dis = parseFloat(dis1f) + parseFloat(dis2f) + parseFloat(dis3f);

        document.getElementById(discount).innerHTML = dis;
        document.getElementById(discountper).innerHTML = disper;
        document.getElementById(rate).value = SELLING;

        document.getElementById(subtotal_name).innerHTML = subtotal.toFixed(2);

        j = j + 1;
    }

    //////////////////////////////////////////////////////////////////////////////
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    if ((document.getElementById('invno').value != "") && (document.getElementById('firstname_hidden').value != "")) {

        //	document.getElementById('discount1').disabled=true;
        //	document.getElementById('discount2').disabled=true;
        //	document.getElementById('discount3').disabled=true;

        var url = "inv_data.php";
        url = url + "?Command=" + "add_tmp_edit_discount";
        url = url + "&invno=" + document.getElementById('invno').value;
        url = url + "&item_count=" + document.getElementById('item_count').value;
        url = url + "&discountper=" + document.getElementById('discountper').value;


        var i = 1;
        while (document.getElementById('item_count').value > i) {
            id = "id" + i;
            code = "code" + i;
            itemd = "itemd" + i;
            rate = "rate" + i;
            qty = "qty" + i;
            actual_selling = "actual_selling" + i;
            discount = "discount" + i;
            total = "total" + i;
            discountper = "discountper" + i;
            subtotal_name = "subtotal" + i;
            ad = "ad" + i;

            url = url + "&" + id + "=" + document.getElementById(id).innerHTML;
            url = url + "&" + code + "=" + document.getElementById(code).innerHTML;
            url = url + "&" + itemd + "=" + document.getElementById(itemd).innerHTML;
            url = url + "&" + rate + "=" + document.getElementById(rate).value;

            url = url + "&" + actual_selling + "=" + document.getElementById(actual_selling).value;
            url = url + "&" + qty + "=" + document.getElementById(qty).value;
            url = url + "&" + discount + "=" + document.getElementById(discount).innerHTML;
            url = url + "&" + discountper + "=" + document.getElementById(discountper).innerHTML;
            url = url + "&" + subtotal_name + "=" + document.getElementById(subtotal_name).innerHTML;
            url = url + "&" + ad + "=" + document.getElementById(ad).checked;

            i = i + 1;
        }
        url = url + "&department=" + document.getElementById('department').value;
        url = url + "&brand=" + document.getElementById('brand').value;
        url = url + "&item_count=" + document.getElementById('item_count').value;

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

        //alert(url);
        xmlHttp.onreadystatechange = showarmyresultdel;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

    } else if (document.getElementById('salesord1').value == "") {
        alert("Order No is EMPTY ! ");
    } else if (document.getElementById('firstname_hidden').value == "") {
        alert("Please Select Customer");
    }


}


function calc1_table_discount2()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var j = 1;
    while (document.getElementById('item_count').value > j) {

        code = "code" + j;
        itemd = "itemd" + j;
        rate = "rate" + j;
        qty = "qty" + j;
        discount = "discount" + j;
        total = "total" + j;
        discountper = "discountper" + j;
        subtotal_name = "subtotal" + j;

        var str = document.getElementById(rate).value;
        var n = str.replace(/,/gi, "");

        var subtotal = parseFloat(n) * parseFloat(document.getElementById(qty).value);

        var dis = 0;
        var dis1 = 0;
        var dis2 = 0;
        var dis3 = 0;
        var disper = 0;
        var dis1f = 0;
        var dis2f = 0;
        var dis3f = 0;


        if ((document.getElementById('discount_org1').value != '') && (document.getElementById('discount_org1').value != "0") && (document.getElementById('discount_org1').value != "0.00")) {
            //dis1=subtotal*document.getElementById('discount1').value/100;
            var strsubt = document.getElementById(subtotal_name).innerHTML;
            var valsubstr = strsubt.replace(/,/gi, "");

            dis1 = valsubstr * document.getElementById('discount_org1').value / 100;
            disper = document.getElementById('discount_org1').value;

        }
        dis1f = dis1.toFixed(2);
        subtotal = subtotal - dis1f;

        if ((document.getElementById('discount_org2').value != '') && (document.getElementById('discount_org2').value != "0") && (document.getElementById('discount_org2').value != "0.00")) {
            dis2 = subtotal * document.getElementById('discount_org2').value / 100;
            disper = 100 - (100 - document.getElementById('discount_org2').value) * (100 - document.getElementById('discount_org1').value) / 100;

        }
        dis2f = dis2.toFixed(2);
        subtotal = subtotal - dis2f;

        if ((document.getElementById('discount_org3').value != '') && (document.getElementById('discount_org3').value != "0") && (document.getElementById('discount_org3').value != "0.00")) {
            dis3 = subtotal * document.getElementById('discount_org3').value / 100;
            disper = 100 - (100 - document.getElementById('discount_org3').value) * (100 - document.getElementById('discount_org2').value) * (100 - document.getElementById('discount_org1').value) / 100;

        }
        dis3f = dis3.toFixed(2);
        subtotal = subtotal - dis3f;

        dis = parseFloat(dis1f) + parseFloat(dis2f) + parseFloat(dis3f);

        document.getElementById(discount).value = dis;
        document.getElementById(discountper).innerHTML = disper;

        document.getElementById(subtotal_name).innerHTML = subtotal.toFixed(2);
        //alert(j);
        j = j + 1;
    }

    //////////////////////////////////////////////////////////////////////////////
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    if ((document.getElementById('invno').value != "") && (document.getElementById('firstname_hidden').value != "")) {

        //	document.getElementById('discount1').disabled=true;
        //	document.getElementById('discount2').disabled=true;
        //	document.getElementById('discount3').disabled=true;

        var url = "inv_data.php";
        url = url + "?Command=" + "add_tmp_edit_discount";
        url = url + "&invno=" + document.getElementById('invno').value;


        var i = 1;
        while (document.getElementById('item_count').value > i) {
            code = "code" + i;
            itemd = "itemd" + i;
            rate = "rate" + i;
            qty = "qty" + i;
            discount = "discount" + i;
            total = "total" + i;
            discountper = "discountper" + i;
            subtotal_name = "subtotal" + i;

            url = url + "&itemcode=" + document.getElementById(code).innerHTML;
            url = url + "&item=" + document.getElementById(itemd).innerHTML;
            url = url + "&rate=" + document.getElementById(rate).value;
            url = url + "&qty=" + document.getElementById(qty).value;
            url = url + "&discount=" + document.getElementById(discount).value;
            url = url + "&discountper=" + document.getElementById(discountper).innerHTML;
            url = url + "&subtotal=" + document.getElementById(subtotal_name).innerHTML;

            i = i + 1;
        }
        url = url + "&department=" + document.getElementById('department').value;
        url = url + "&brand=" + document.getElementById('brand').value;
        url = url + "&item_count=" + document.getElementById('item_count').value;

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
        //alert(url);

        xmlHttp.onreadystatechange = showarmyresultdel;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

    } else if (document.getElementById('salesord1').value == "") {
        alert("Order No is EMPTY ! ");
    } else if (document.getElementById('firstname_hidden').value == "") {
        alert("Please Select Customer");
    }


}


function calc1_table_discount3()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var j = 1;
    while (document.getElementById('item_count').value > j) {

        code = "code" + j;
        itemd = "itemd" + j;
        rate = "rate" + j;
        qty = "qty" + j;
        discount = "discount" + j;
        total = "total" + j;
        discountper = "discountper" + j;
        subtotal_name = "subtotal" + j;

        var str = document.getElementById(rate).value;
        var n = str.replace(/,/gi, "");

        var subtotal = parseFloat(n) * parseFloat(document.getElementById(qty).value);

        var dis = 0;
        var dis1 = 0;
        var dis2 = 0;
        var dis3 = 0;
        var disper = 0;
        var dis1f = 0;
        var dis2f = 0;
        var dis3f = 0;


        if ((document.getElementById('discount_org1').value != '') && (document.getElementById('discount_org1').value != "0") && (document.getElementById('discount_org1').value != "0.00")) {
            //dis1=subtotal*document.getElementById('discount1').value/100;
            var strsubt = document.getElementById(subtotal_name).innerHTML;
            var valsubstr = strsubt.replace(/,/gi, "");

            dis1 = valsubstr * document.getElementById('discount_org1').value / 100;
            disper = document.getElementById('discount_org1').value;

        }
        dis1f = dis1.toFixed(2);
        subtotal = subtotal - dis1f;

        if ((document.getElementById('discount_org2').value != '') && (document.getElementById('discount_org2').value != "0") && (document.getElementById('discount_org2').value != "0.00")) {
            dis2 = subtotal * document.getElementById('discount_org2').value / 100;
            disper = 100 - (100 - document.getElementById('discount_org2').value) * (100 - document.getElementById('discount_org1').value) / 100;

        }
        dis2f = dis2.toFixed(2);
        subtotal = subtotal - dis2f;

        if ((document.getElementById('discount_org3').value != '') && (document.getElementById('discount_org3').value != "0") && (document.getElementById('discount_org3').value != "0.00")) {
            dis3 = subtotal * document.getElementById('discount_org3').value / 100;
            disper = 100 - (100 - document.getElementById('discount_org3').value) * (100 - document.getElementById('discount_org2').value) * (100 - document.getElementById('discount_org1').value) / 100;

        }
        dis3f = dis3.toFixed(2);
        subtotal = subtotal - dis3f;

        dis = parseFloat(dis1f) + parseFloat(dis2f) + parseFloat(dis3f);

        document.getElementById(discount).value = dis;
        document.getElementById(discountper).innerHTML = disper;

        document.getElementById(subtotal_name).innerHTML = subtotal.toFixed(2);
        //alert(j);
        j = j + 1;
    }

    //////////////////////////////////////////////////////////////////////////////
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    if ((document.getElementById('invno').value != "") && (document.getElementById('firstname_hidden').value != "")) {

        //	document.getElementById('discount1').disabled=true;
        //	document.getElementById('discount2').disabled=true;
        //	document.getElementById('discount3').disabled=true;

        var url = "inv_data.php";
        url = url + "?Command=" + "add_tmp_edit_discount";
        url = url + "&invno=" + document.getElementById('invno').value;


        var i = 1;
        while (document.getElementById('item_count').value > i) {
            code = "code" + i;
            itemd = "itemd" + i;
            rate = "rate" + i;
            qty = "qty" + i;
            discount = "discount" + i;
            total = "total" + i;
            discountper = "discountper" + i;
            subtotal_name = "subtotal" + i;

            url = url + "&itemcode=" + document.getElementById(code).innerHTML;
            url = url + "&item=" + document.getElementById(itemd).innerHTML;
            url = url + "&rate=" + document.getElementById(rate).value;
            url = url + "&qty=" + document.getElementById(qty).value;
            url = url + "&discount=" + document.getElementById(discount).value;
            url = url + "&discountper=" + document.getElementById(discountper).innerHTML;
            url = url + "&subtotal=" + document.getElementById(subtotal_name).innerHTML;

            i = i + 1;
        }
        url = url + "&department=" + document.getElementById('department').value;
        url = url + "&brand=" + document.getElementById('brand').value;
        url = url + "&item_count=" + document.getElementById('item_count').value;

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
        //alert(url);

        xmlHttp.onreadystatechange = showarmyresultdel;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

    } else if (document.getElementById('salesord1').value == "") {
        alert("Order No is EMPTY ! ");
    } else if (document.getElementById('firstname_hidden').value == "") {
        alert("Please Select Customer");
    }


}

function calc2()
{

    //alert("ok");
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    document.getElementById('subtotal').value = document.getElementById('subtotal').value - document.getElementById('discount').value;



}

function disp_qty(it_code)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "inv_data.php";
    url = url + "?Command=" + "disp_qty";
    url = url + "&it_code=" + it_code;
    url = url + "&department=" + document.getElementById('department').value;


    xmlHttp.onreadystatechange = show_disp_qty;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function show_disp_qty()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}

        document.getElementById('stklevel').value = xmlHttp.responseText;

    }
}

function chk_ad(i)
{

    alert("Please ENTER the AD NUMBER !");

    document.getElementById("salesord1").value = ""

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var chk = "ad" + i;
    var code = "code" + i;
    var id = "id" + i;

    var url = "inv_data.php";
    url = url + "?Command=" + "chk_ad";
    url = url + "&chk=" + document.getElementById(chk).checked;
    url = url + "&itemcode=" + document.getElementById(code).innerHTML;
    url = url + "&id=" + document.getElementById(id).innerHTML;
    //alert(url);

    xmlHttp.onreadystatechange = showarmyresultchk_ad;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function showarmyresultchk_ad()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
    }
}


function add_tmp()
{

    if (document.getElementById('cmd_save').value == 1) {
        //alert("ok");
        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }

        if ((document.getElementById('invno').value != "") && (document.getElementById('firstname_hidden').value != "") ) {
alert('1');
            //	document.getElementById('discount1').disabled=true;
            //	document.getElementById('discount2').disabled=true;
            //	document.getElementById('discount3').disabled=true;

            var url = "inv_data.php";
            url = url + "?Command=" + "add_tmp";
            url = url + "&invno=" + document.getElementById('invno').value;

            url = url + "&itemcode=" + document.getElementById('itemd_hidden').value;

            url = url + "&item=" + document.getElementById('itemd').value;


            url = url + "&rate=" + document.getElementById('rate').value;
            url = url + "&actual_selling=" + document.getElementById('actual_selling').value;
            url = url + "&qty=" + document.getElementById('qty').value;
            url = url + "&discount=" + document.getElementById('discount').value;
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
            //alert(url);

            xmlHttp.onreadystatechange = showarmyresultdel;
            xmlHttp.open("GET", url, true);
            xmlHttp.send(null);

        } else if (document.getElementById('salesord1').value == "") {
            alert("Order No is EMPTY ! ");
        } else if (document.getElementById('firstname_hidden').value == "") {
            alert("Please Select Customer");
        }
    } else {
        alert("Cannot add items");
    }
}

function showarmyresultdel()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_validity");
        var chq_validity = XMLAddress1[0].childNodes[0].nodeValue;

        if (chq_validity == "yes") {
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
            document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
            document.getElementById('item_count').value = XMLAddress1[0].childNodes[0].nodeValue;





            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");

            document.getElementById('subtot').value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tot_dis");
            document.getElementById('totdiscount').value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tax");
            document.getElementById('tax').value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("taxname");
            document.getElementById('taxname').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invtot");
            document.getElementById('invtot').value = XMLAddress1[0].childNodes[0].nodeValue;



            //document.getElementById('invno').value="";
            document.getElementById('itemd_hidden').value = "";
            document.getElementById('itemd').value = "";
            document.getElementById('rate').value = "";
            document.getElementById('qty').value = "";
            document.getElementById('discount').value = "";
            document.getElementById('discountper').value = "";
            document.getElementById('subtotal').value = "";

            document.getElementById('itemd_hidden').focus();
        } else {
            alert("Please Login Again !!!");
        }
    }
}




function shownavyresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("navy_table");
        document.getElementById('tblnavy').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    }
}


function del_item_rep_cat(credit_lim, rep, credit, balance, cat, brand, doc_mod)
{

    // if (doc_mod == "1") {

        var msg = confirm("Are you sure to DELETE ?");

        if (msg == true) {
            xmlHttp = GetXmlHttpObject();
            if (xmlHttp == null)
            {
                alert("Browser does not support HTTP Request");
                return;
            }


            var url = "search_custom_data.php";
            url = url + "?Command=" + "del_item_rep_cat";

            url = url + "&txt_cuscode=" + document.getElementById('txt_cuscode').value
            url = url + "&credit_lim=" + credit_lim;
            url = url + "&rep=" + rep;
            url = url + "&credit=" + credit;
            url = url + "&balance=" + balance;
            url = url + "&cat=" + cat;
            url = url + "&brand=" + brand;
            url = url + "&doc_mod=" + doc_mod;

            //alert(url);

            xmlHttp.onreadystatechange = del_item_rep_cat_resultdel;
            xmlHttp.open("GET", url, true);
            xmlHttp.send(null);
        }
    // } else {
    //     alert("You have no permission to DELETE.");
    // }


}

function del_item_rep_cat_resultdel()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}

        document.getElementById('creditlim').innerHTML = xmlHttp.responseText;


    }
}



function del_item(code)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "inv_data.php";
    url = url + "?Command=" + "del_item";
    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&code=" + code;
    url = url + "&department=" + document.getElementById('department').value;
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
    //alert(url);

    xmlHttp.onreadystatechange = itemresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function itemresultdel()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");
        document.getElementById('subtot').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tot_dis");
        document.getElementById('totdiscount').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tax");
        document.getElementById('tax').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("taxname");
        document.getElementById('taxname').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invtot");
        document.getElementById('invtot').value = XMLAddress1[0].childNodes[0].nodeValue;

    }
}

function clear_customer_ind() {
    //location.reload();
    //document.getElementById('txt_cuscode').value="";
    document.getElementById('txtCNAME').value = "";
    document.getElementById('txtBADD1').value = "";
    document.getElementById('txtBADD2').value = "";
    document.getElementById('txtTEL').value = "";
    document.getElementById('txttel2').value = "";
    document.getElementById('txtFAX').value = "";
    document.getElementById('TXTEMAIL').value = "";
    document.getElementById('DTbankgrdate').value = "";
    var cdate = new Date();
    document.getElementById('DTOPDATE').value = cdate.getFullYear() + "-" + (cdate.getMonth() + 1) + "-" + cdate.getDate();
    document.getElementById('txtcper').value = "";
    document.getElementById('txtACCno').value = "";
    document.getElementById('txtcrlimt').value = "";
    document.getElementById('txtbal').value = "";
    document.getElementById('txtover').value = "";
    document.getElementById('txtvatno').value = "";
    document.getElementById('txtcat').value = "";
    document.getElementById('txttype').value = "";
    document.getElementById('txtarea').value = "";
    document.getElementById('TXT_REP').value = "";

    //document.getElementById('txtBRAND_NAME11').value="";

    document.getElementById('creditlim').innerHTML = "";

    document.getElementById('txtlimit').value = "";
    document.getElementById('cmbCAt').value = "";
    //document.getElementById('txtBRAND_NAME11').value="";

}


function clear_customer() {
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    //location.reload();
    document.getElementById('txt_cuscode').value = "";
    document.getElementById('txtCNAME').value = "";
    document.getElementById('txtBADD1').value = "";
    document.getElementById('txtBADD2').value = "";
    document.getElementById('txtTEL').value = "";
    document.getElementById('txttel2').value = "";
    document.getElementById('txtFAX').value = "";
    document.getElementById('TXTEMAIL').value = "";
    document.getElementById('DTbankgrdate').value = "";
    var cdate = new Date();
    document.getElementById('DTOPDATE').value = cdate.getFullYear() + "-" + (cdate.getMonth() + 1) + "-" + cdate.getDate();
    document.getElementById('txtcper').value = "";
    document.getElementById('txtACCno').value = "";
    document.getElementById('txtcrlimt').value = "";
    document.getElementById('txtbal').value = "";
    document.getElementById('txtover').value = "";
    document.getElementById('txtvatno').value = "";
    document.getElementById('txtcat').value = "";
    document.getElementById('txttype').value = "";
    document.getElementById('txtarea').value = "";
    document.getElementById('TXT_REP').value = "";

    document.getElementById('creditlim').innerHTML = "";
    document.getElementById('txtlimit').value = "";
    document.getElementById('cmbCAt').value = "";
    document.getElementById('searchinv2').focus();

    document.getElementById('days').value = "";
    
    var url = "search_custom_data.php";
    url = url + "?Command=" + "custmast_inv"; 
    xmlHttp.onreadystatechange = custmast_inv1;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function custmast_inv1()
{
    var XMLAddress1; 
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    { 
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_cuscode")
        document.getElementById('txt_cuscode').value = XMLAddress1[0].childNodes[0].nodeValue;
    }
}

function new_customer()
{
    clear_customer();
}

function stopinvcing()
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "search_custom_data.php";
    url = url + "?Command=" + "pass_sto_inv";
    url = url + "&txt_cuscode=" + document.getElementById('txt_cuscode').value;
    url = url + "&chkstop=" + document.getElementById('check1').checked;

    xmlHttp.onreadystatechange = stopinvcing_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}


function stopinvcing_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);

    }
}

function sellimit()
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "search_custom_data.php";
    url = url + "?Command=" + "pass_sellimit_result";
    url = url + "&txt_cuscode=" + document.getElementById('txt_cuscode').value;
    url = url + "&Com_rep=" + document.getElementById('Com_rep').value;
    url = url + "&cmbbrand=" + document.getElementById('cmbbrand').value;

    xmlHttp.onreadystatechange = sellimit_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}


function sellimit_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CAT");
        document.getElementById('cmbbrand').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("credit_lim");
        document.getElementById('txtlimit').value = XMLAddress1[0].childNodes[0].nodeValue;
    }
}

function displimit()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "search_custom_data.php";

    url = url + "?Command=" + "pass_displimit_result";

    url = url + "&Com_rep=" + document.getElementById('Com_rep').value;
    url = url + "&cmbbrand=" + document.getElementById('cmbbrand').value;
    //alert(url);
    xmlHttp.onreadystatechange = displimit_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}


function displimit_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}

        document.getElementById('limit_det').innerHTML = xmlHttp.responseText;


    }
}

function save_limit(i)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "search_custom_data.php";

    url = url + "?Command=" + "pass_save_limit";

    cuscode = "cuscode_" + i;
    cat = "cat_" + i;
    credit_lim = "credit_lim_" + i;

    url = url + "&i=" + i;
    url = url + "&cuscode=" + document.getElementById(cuscode).innerHTML;
    url = url + "&cat=" + document.getElementById(cat).innerHTML;
    url = url + "&credit_lim=" + document.getElementById(credit_lim).value;
    url = url + "&Com_rep=" + document.getElementById("Com_rep").value;
    url = url + "&cmbbrand=" + document.getElementById("cmbbrand").value;
    //alert(url);
    xmlHttp.onreadystatechange = save_limit_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}


function save_limit_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);

        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}

        //document.getElementById('limit_det').innerHTML = xmlHttp.responseText;


    }
}


function save_customer()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "search_custom_data.php";
    url = url + "?Command=" + "save_customer";
    url = url + "&txt_cuscode=" + document.getElementById('txt_cuscode').value;

    str = document.getElementById('txtCNAME').value;
    var n = str.replace("&", "~");

    url = url + "&txtCNAME=" + n;
    url = url + "&txtBADD1=" + document.getElementById('txtBADD1').value;
    url = url + "&txtBADD2=" + document.getElementById('txtBADD2').value;
    url = url + "&txtdistrict=" + document.getElementById('txtdistrict').value;
    url = url + "&txtprovince=" + document.getElementById('txtprovince').value;
    url = url + "&txtTEL=" + document.getElementById('txtTEL').value;
    url = url + "&txttel2=" + document.getElementById('txttel2').value;
    url = url + "&txtFAX=" + document.getElementById('txtFAX').value;
    url = url + "&TXTEMAIL=" + document.getElementById('TXTEMAIL').value;
    url = url + "&DTbankgrdate=" + document.getElementById('DTbankgrdate').value;
    url = url + "&DTOPDATE=" + document.getElementById('DTOPDATE').value;
    url = url + "&txtcper=" + document.getElementById('txtcper').value;
    url = url + "&txtACCno=" + document.getElementById('txtACCno').value;
    url = url + "&txtcrlimt=" + document.getElementById('txtcrlimt').value;
    url = url + "&txtbal=" + document.getElementById('txtbal').value;
    url = url + "&txtover=" + document.getElementById('txtover').value;
    url = url + "&txtvatno=" + document.getElementById('txtvatno').value;
    url = url + "&txtcat=" + document.getElementById('txtcat').value;
    url = url + "&txttype=" + document.getElementById('txttype').value;
    url = url + "&txtarea=" + document.getElementById('txtarea').value;
    url = url + "&SVAT=" + document.getElementById('SVAT').value;
    url = url + "&txtInc=" + document.getElementById('txtInc').value;
    url = url + "&TXT_REP=" + document.getElementById('TXT_REP').value;
    url = url + "&txt_scat=" + document.getElementById('txt_scat').value;
    url = url + "&txt_commcode=" + document.getElementById('txt_commcode').value;
    url = url + "&remark=" + document.getElementById('remark').value;
    url = url + "&txtvatgroup=" + document.getElementById('txtvatgroup').value;

    //alert(url)
    url = url + "&chkgarant=" + document.getElementById('chkgarant').value;
    url = url + "&chkstop=" + document.getElementById('check1').value;


    url = url + "&txtMsg=" + document.getElementById('txtMsg').value;


    xmlHttp.onreadystatechange = save_customer_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function save_customer_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        location.reload(true);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}
        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
        //document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    }
}

function cancel_inv()
{
    if (document.getElementById('cmd_cancel').value == 1) {
        var msg = confirm("Do you want to CANCEL this invoice ! ");
        if (msg == true) {

            document.getElementById('cmd_new').value = 1;
            document.getElementById('cmd_save').value = 0;
            document.getElementById('cmd_cancel').value = 0;
            document.getElementById('cmd_print').value = 0;

            xmlHttp = GetXmlHttpObject();
            if (xmlHttp == null)
            {
                alert("Browser does not support HTTP Request");
                return;
            }

            var url = "inv_data.php";
            url = url + "?Command=" + "cancel_inv";
            url = url + "&invno=" + document.getElementById('invno').value;
            url = url + "&invtot=" + document.getElementById('invtot').value;
            url = url + "&customer_code=" + document.getElementById('firstname_hidden').value;
            url = url + "&salesrep=" + document.getElementById('salesrep').value;
            url = url + "&department=" + document.getElementById('department').value;


            xmlHttp.onreadystatechange = cancel_inv_result;
            xmlHttp.open("GET", url, true);
            xmlHttp.send(null);
        }
    } else {
        alert("Cannot Cancel");
    }
}

function cancel_inv_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {


        alert(xmlHttp.responseText);
        location.reload(true);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}
        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
        //document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    }
}


function close_form()
{
    self.close();
}

function delete_customer(doc_mod)
{
    // if (doc_mod == "1") {

        var msg = confirm("Are you sure to DELETE ? ");
        if (msg == true) {
            xmlHttp = GetXmlHttpObject();
            if (xmlHttp == null)
            {
                alert("Browser does not support HTTP Request");
                return;
            }

            var url = "search_custom_data.php";
            url = url + "?Command=" + "delete_customer";
            url = url + "&txt_cuscode=" + document.getElementById('txt_cuscode').value;

            xmlHttp.onreadystatechange = delete_customer_result;
            xmlHttp.open("GET", url, true);
            xmlHttp.send(null);


        }
    // } else {
    //     alert("You have no permission to DELETE!");
    // }
}

function delete_customer_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        setTimeout("location.reload(true);", 500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}
        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");	
        //document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    }
}

function save_inv(inv_status)
{

    if (document.getElementById('cmd_save').value == 1) {

        document.getElementById('cmd_new').value = 1;
        document.getElementById('cmd_save').value = 0;
        document.getElementById('cmd_cancel').value = 1;
        document.getElementById('cmd_print').value = 1;

        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }
        //alert(inv_status); 

        if (document.getElementById('salesord1').value != "") {

            if ((document.getElementById('txtreturn').value == "0") || (document.getElementById('Result').value == "OK")) {
                if ((document.getElementById('over60').value != "60") || (document.getElementById('Result').value == "OK")) {
                    if (parseFloat(document.getElementById('item_count').value) > 0) {

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


                        if (((parseFloat(crebal) < 0) || (parseFloat(crebal) < parseFloat(invtot))) && (document.getElementById('Result').value != "OK"))
                        {
                            alert("Credit Limit Exceeded");
                            //} else if (inv_status==0){
                            //	alert("Unable to Save");
                        } else {
                            //alert("ok");
                            var paymethod;

                            var url = "inv_data.php";
                            url = url + "?Command=" + "save_item";
                            if (document.getElementById('paymethod_0').checked == true) {
                                paymethod = "CR";
                            } else if (document.getElementById('paymethod_1').checked == true) {
                                paymethod = "CA";
                            }
                            url = url + "&paymethod=" + paymethod;
                            url = url + "&salesord1=" + document.getElementById('salesord1').value;
                            url = url + "&ordno=" + document.getElementById('ordno').value;
                            url = url + "&invno=" + document.getElementById('invno').value;
                            url = url + "&invdate=" + document.getElementById('invdate').value;
                            url = url + "&deldate=" + document.getElementById('dte_dor').value;
                            url = url + "&customercode=" + document.getElementById('firstname_hidden').value;
                            url = url + "&c_subcode=" + document.getElementById('c_subcode').value;


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

                            url = url + "&txtad=" + document.getElementById('txtad').value;

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
                            //alert(url);

                            xmlHttp.onreadystatechange = salessaveresult;
                            xmlHttp.open("GET", url, true);
                            xmlHttp.send(null);

                        }
                    } else {
                        alert("Please insert items");
                    }
                } else {
                    alert("Over 60 outstanding available !!!");
                }
            } else {
                alert("Return Cheque Available !!!");
            }
        } else {
            alert("Cannot Save without Order No");
        }
    } else {
        alert("Cannot Save Invoice");
    }
}

function salessaveresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}


        if (xmlHttp.responseText == "no") {
            alert("Please Login Again !!!");
        } else {

            if (xmlHttp.responseText == "Invoice No Already Exist !!!") {
                alert(xmlHttp.responseText);
            } else if (xmlHttp.responseText == "err1") {
                alert("ERROR IN SUB TOTAL");
            } else if (xmlHttp.responseText == "err2") {
                alert("ERROR IN DISCOUNT");
            } else if (xmlHttp.responseText == "err3") {
                alert("ERROR IN TAX");
            } else if (xmlHttp.responseText == "err4") {
                alert("ERROR IN INVOICE TOTAL");
            } else if (xmlHttp.responseText == "err5") {
                alert("Invalied NON VAT Invoice");
            } else if (xmlHttp.responseText == "err6") {
                alert("Invalied VAT Invoice");
            } else if (xmlHttp.responseText == "Invoice Facilitey Stoped for This Customer,Please Invoice For Approved Sales Order") {
                alert(xmlHttp.responseText);
            } else if (xmlHttp.responseText == "Invoice Facilitey Stoped for This Customer,Please Invoice For Approved Sales Order") {
                alert(xmlHttp.responseText);
            } else if (xmlHttp.responseText == "Empty Items List. Cannot Save!!!") {
                alert(xmlHttp.responseText);
            } else {

                XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg_crelimi");
                if (XMLAddress1[0].childNodes[0].nodeValue != "no") {
                    alert(XMLAddress1[0].childNodes[0].nodeValue);
                }
            }

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Saved");
            var res = XMLAddress1[0].childNodes[0].nodeValue;
            //alert(res);
            if (res != "no") {
                alert(res);
            }

            if (res == "Saved") {


                XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");
                document.getElementById('invno').value = XMLAddress1[0].childNodes[0].nodeValue;

                XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("company");
                var company = XMLAddress1[0].childNodes[0].nodeValue;


                document.getElementById('cmd_new').value = 1;
                document.getElementById('cmd_save').value = 0;
                document.getElementById('cmd_cancel').value = 1;
                document.getElementById('cmd_print').value = 1;


                var url = "rep_inv.php";
                if (document.getElementById('promotion').checked == true) {
                    var url = "rep_inv_1.php";
                } else {
                    var url = "rep_inv.php";
                }

                url = url + "?invno=" + document.getElementById('invno').value;

                str = document.getElementById('firstname').value;
                var n = str.replace("&", "~");

                url = url + "&cus_name=" + n;
                url = url + "&cus_address=" + document.getElementById('cus_address').value;
                url = url + "&cus_address2=" + document.getElementById('cus_address2').value;
                url = url + "&vat1=" + document.getElementById('vat1').value;
                url = url + "&vat2=" + document.getElementById('vat2').value;
                window.open(url, '_blank');
                location.reload(true);
                new_inv();
            } else {
                if (res == "no") {
                    alert("Can't Save !!!");
                } else {
                    if (res == "insuficent") {
                        alert("Insufficient Stock");
                    } else {

                        alert(res);
                        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg_crelimi");
                        if (XMLAddress1[0].childNodes[0].nodeValue != 'no') {
                            alert(XMLAddress1[0].childNodes[0].nodeValue);
                        }

                        location.reload(true);
                    }

                }
                document.getElementById('cmd_new').value = 1;
                document.getElementById('cmd_save').value = 1;
                document.getElementById('cmd_cancel').value = 0;
                document.getElementById('cmd_print').value = 0;

            }
        }
    }
}

function new_inv()
{

    if (document.getElementById('cmd_new').value == 1) {
        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }

        var paymethod;

        //document.getElementById('discount1').disabled=false;
        //document.getElementById('discount2').disabled=false;
        //document.getElementById('discount3').disabled=false;

        document.getElementById('paymethod_0').checked = true;

        document.getElementById('salesord1').value = "";
        document.getElementById('txtreturn').value = "0";
        //document.getElementById('salesord2').value="";
        document.getElementById('invno').value = "";

        document.getElementById('crebal').value = "";
        document.getElementById('brand').value = "";

        //document.getElementById('invdate').value="";
        document.getElementById('dte_dor').value = "";
        document.getElementById('firstname_hidden').value = "";

        document.getElementById('firstname').value = "";
        document.getElementById('cus_address').value = "";
        document.getElementById('cus_address2').value = "";
        //document.getElementById('orderno1').value="";
        //document.getElementById('orderdate').value="";
        document.getElementById('vat1').value = "";
        document.getElementById('vat2').value = "";
        document.getElementById('creditlimit').value = "";
        document.getElementById('balance').value = "";
        document.getElementById('salesrep').value = "";

        document.getElementById('over60').value = "0";

        document.getElementById('txtad').value = "";
        //var objsalesrep = document.getElementById("salesrep");
        //objsalesrep.options[0].selected=true;

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

        document.getElementById('itemd_hidden').value = "";
        document.getElementById('itemd').value = "";
        document.getElementById('rate').value = "";
        document.getElementById('qty').value = "";
        document.getElementById('discountper').value = "";
        document.getElementById('subtotal').value = "";
        document.getElementById("promotion").checked = false;
        //alert("ok");
        //document.getElementById('invdate').value=Date();

        var url = "inv_data.php";
        url = url + "?Command=" + "new_inv";
        url = url + "&salesrep=" + document.getElementById('salesrep').value;

        xmlHttp.onreadystatechange = assign_invno;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    } else {
        alert("Cannot enter new Invoice");
    }
}

function assign_invno() {
    //alert(xmlHttp.responseText);
    //document.getElementById('invno').value=xmlHttp.responseText;	

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_validity");
    var chq_validity = XMLAddress1[0].childNodes[0].nodeValue;

    if (chq_validity == "yes") {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");
        document.getElementById('invno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sdate");
        document.getElementById('invdate').value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdono");
        document.getElementById('txtdono').value = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('cmd_new').value = 1;
        document.getElementById('cmd_save').value = 1;
        document.getElementById('cmd_cancel').value = 0;
        document.getElementById('cmd_print').value = 0;

        document.getElementById('credper').value = 65;
        document.getElementById('txtcper').focus();
    } else {
        alert("Please Login Again !!!");
    }
}
/*
 function print_inv_ben()
 {
 
 if (document.getElementById('cmd_print').value==1){	
 xmlHttp=GetXmlHttpObject();
 if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request");
 return;
 } 		
 
 var url="inv_data.php";			
 url=url+"?Command="+"check_print";
 
 
 xmlHttp.onreadystatechange=passprintresult_ben;
 
 xmlHttp.open("GET",url,true);
 xmlHttp.send(null);
 } else {
 alert("Cannot Print");	
 }
 
 
 }*/

function print_inv_ben_disp()
{

    if (document.getElementById('cmd_print').value == 1) {
        var url = "rep_inv_ben.php";
        url = url + "?invno=" + document.getElementById('invno').value;

        myString = document.getElementById('firstname_hidden').value;
        myString = myString.replace(/&/g, "~");
        url = url + "&cus_name=" + myString;

        myString = document.getElementById('cus_address').value;
        myString = myString.replace(/&/g, "~");
        url = url + "&cus_address=" + myString;

        //myString=document.getElementById('cus_address2').value;
        //myString = myString.replace(/&/g,"~");
        //url=url+"&cus_address2="+myString;

        url = url + "&vat1=" + document.getElementById('vat1').value;
        url = url + "&vat2=" + document.getElementById('vat2').value;
        //alert(url);
        window.open(url);
    } else {
        alert("Cannot Print");
    }

}

function print_inv_ben()
{

    if (document.getElementById('cmd_print').value == 1) {
        var url = "rep_inv_ben.php";
        url = url + "?invno=" + document.getElementById('invno').value;

        myString = document.getElementById('firstname').value;
        myString = myString.replace(/&/g, "~");
        url = url + "&cus_name=" + myString;

        myString = document.getElementById('cus_address').value;
        myString = myString.replace(/&/g, "~");
        url = url + "&cus_address=" + myString;

        myString = document.getElementById('cus_address2').value;
        myString = myString.replace(/&/g, "~");
        url = url + "&cus_address2=" + myString;

        url = url + "&vat1=" + document.getElementById('vat1').value;
        url = url + "&vat2=" + document.getElementById('vat2').value;
        //alert(url);
        window.open(url);
    } else {
        alert("Cannot Print");
    }

}
/*
 function print_inv()
 {
 
 if (document.getElementById('cmd_print').value==1){	
 xmlHttp=GetXmlHttpObject();
 if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request");
 return;
 } 		
 
 var url="inv_data.php";			
 url=url+"?Command="+"check_print";
 
 
 xmlHttp.onreadystatechange=passprintresult;
 
 xmlHttp.open("GET",url,true);
 xmlHttp.send(null);
 } else {
 alert("Cannot Print");	
 }
 
 
 }*/

function print_inv()
{
    if (document.getElementById('cmd_print').value == 1) {

        if (document.getElementById('promotion').checked == true) {
            var url = "rep_inv_1.php";
        } else {
            var url = "rep_inv.php";
        }
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
    } else {
        alert("Cannot Print");
    }
}

function print_inv_1()
{
    if (document.getElementById('cmd_print').value == 1) {
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
    } else {
        alert("Cannot Print");
    }
}


function update_list(stname)
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
    }

    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&customername=" + document.getElementById('customername').value;
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

function set_cursor()
{
    document.getElementById("cusno").focus();
}

function update_cust_list(stname)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_custom_data.php";
    url = url + "?Command=" + "search_custom";

    if (stname == 'incentive') {
        url = url + "&incen=1";
    } else if (stname == 'incentive2') {
        url = url + "&incen=2";
    }
    if (document.getElementById('cusno').value != "") {
        url = url + "&mstatus=cusno";
    } else if (document.getElementById('customername').value != "") {
        url = url + "&mstatus=customername";
    }

    url = url + "&cusno=" + document.getElementById('cusno').value;
    url = url + "&customername=" + document.getElementById('customername').value;
    url = url + "&stname=" + stname;


    xmlHttp.onreadystatechange = showcustresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showcustresult()
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

function update_item_list(stname)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_item_data.php";
    url = url + "?Command=" + "search_item";
    url = url + "&itno=" + document.getElementById('itno').value;
    url = url + "&itemname=" + document.getElementById('itemname').value;
    url = url + "&checkbox=" + document.getElementById('checkbox').checked;
    url = url + "&stname=" + stname;
    if (document.getElementById('itno').value != "") {
        url = url + "&mstatus=itno";
    } else if (document.getElementById('itemname').value != "") {
        url = url + "&mstatus=itemname";
    }
    url = url + "&mstatus2=grn_item";
    //alert(url);		
    xmlHttp.onreadystatechange = showitemresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function update_item_list_ord()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_item_data.php";
    url = url + "?Command=" + "search_item";
    url = url + "&itno=" + document.getElementById('itno').value;
    url = url + "&itemname=" + document.getElementById('itemname').value;
    url = url + "&checkbox=" + document.getElementById('checkbox').checked;

    if (document.getElementById('itno').value != "") {
        url = url + "&mstatus=itno";
    } else if (document.getElementById('itemname').value != "") {
        url = url + "&mstatus=itemname";
    }
    url = url + "&mstatus2=ord_item";
    //alert(url);		
    xmlHttp.onreadystatechange = showitemresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showitemresult()
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

function assignbrand()
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "search_inv_data.php";
    url = url + "?Command=" + "assign_brand";
    url = url + "&brand=" + document.getElementById('brand').value;
    url = url + "&salesrep=" + document.getElementById('salesrep').value;
    url = url + "&txt_cuscode=" + document.getElementById('firstname_hidden').value;

    //alert(url);

    xmlHttp.onreadystatechange = barand_details_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function barand_details_result()
{
    //alert(xmlHttp.responseText);

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");
    document.getElementById('creditlimit').value = XMLAddress1[0].childNodes[0].nodeValue;

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");
    document.getElementById('balance').value = XMLAddress1[0].childNodes[0].nodeValue;

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");
    document.getElementById('discount1').value = XMLAddress1[0].childNodes[0].nodeValue;

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
    document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("netqty");
    opener.document.form1.txtinvt.value = XMLAddress1[0].childNodes[0].nodeValue;



}


function assignbrand_search(brand, salesrep, txt_cuscode)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "search_inv_data.php";
    url = url + "?Command=" + "assign_brand";
    url = url + "&brand=" + brand;
    url = url + "&salesrep=" + salesrep;
    url = url + "&txt_cuscode=" + txt_cuscode;

    //alert(url);

    xmlHttp.onreadystatechange = barand_details_result_search;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function barand_details_result_search()
{
    //alert(xmlHttp.responseText);

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");
    opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");
    opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");
    opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
    window.opener.document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

}


function invno(invno, stname)
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


        xmlHttp.onreadystatechange = passinvresult;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
    //alert(url);




}

function passinvresult_grn()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REF_NO");
        opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CODE");
        opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUS_NAME");
        opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("address");
        opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SAL_EX");
        opener.document.form1.salesrep.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");
        opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GST");
        opener.document.form1.gst.value = XMLAddress1[0].childNodes[0].nodeValue;


        opener.document.form1.vatgroup_1.checked = true;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("VAT");
        if (XMLAddress1[0].childNodes[0].nodeValue == "1") {
            opener.document.form1.vatgroup_0.checked = true;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SVAT");
        if (XMLAddress1[0].childNodes[0].nodeValue > 0) {
            opener.document.form1.vatgroup_2.checked = true;
        }

        opener.document.form1.chkinvno.checked = true;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Brand");
        var objSalesrep = opener.document.getElementById("brand");
        var salesrep = XMLAddress1[0].childNodes[0].nodeValue;
        var i = 0;
        while (i < objSalesrep.length)
        {
            if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
            {
                objSalesrep.options[i].selected = true;

            }
            i = i + 1;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEPARTMENT");
        var objSalesrep = opener.document.getElementById("department");
        var salesrep = XMLAddress1[0].childNodes[0].nodeValue;
        var i = 0;
        while (i < objSalesrep.length)
        {
            if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
            {
                objSalesrep.options[i].selected = true;

            }
            i = i + 1;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TYPE");
        if (XMLAddress1[0].childNodes[0].nodeValue == "CR") {
            opener.document.form1.paymethod_0.checked = true;
        } else {
            opener.document.form1.paymethod_1.checked = true;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SVAT");
        if (XMLAddress1[0].childNodes[0].nodeValue > 0) {
            opener.document.form1.vatgroup_2.checked = true;
        }


        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DISCOU");
        //	opener.document.form1.totdiscount.value = XMLAddress1[0].childNodes[0].nodeValue;

        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("GRAND_TOT");
        //	opener.document.form1.invtot.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcou");
        opener.document.form1.mcou.value = XMLAddress1[0].childNodes[0].nodeValue;


        /*	document.getElementById('cmd_new').value=1;	
         document.getElementById('cmd_save').value=0;	
         document.getElementById('cmd_cancel').value=1;	
         document.getElementById('cmd_print').value=1;	*/

        self.close();
    }

}

function passinvresult_search_grn()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("RNO");
        opener.document.form1.rno.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REF_NO");
        opener.document.form1.grnno.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CODE");
        opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADDRESS");
        opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("INVOICENO");
        opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");
        opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SAL_EX");
        opener.document.form1.salesrep.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("seri_no");
        opener.document.form1.serialno.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Brand");
        var objSalesrep = opener.document.getElementById("brand");
        var salesrep = XMLAddress1[0].childNodes[0].nodeValue;
        var i = 0;
        while (i < objSalesrep.length)
        {
            if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
            {
                objSalesrep.options[i].selected = true;

            }
            i = i + 1;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEPARTMENT");
        var objSalesrep = opener.document.getElementById("department");
        var salesrep = XMLAddress1[0].childNodes[0].nodeValue;
        var i = 0;
        while (i < objSalesrep.length)
        {
            if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
            {
                objSalesrep.options[i].selected = true;

            }
            i = i + 1;
        }

        /*	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TYPE");
         if (XMLAddress1[0].childNodes[0].nodeValue == "CR"){
         opener.document.form1.paymethod_0.checked=true;
         } else {
         opener.document.form1.paymethod_1.checked=true;
         }
         
         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("VAT");
         if (XMLAddress1[0].childNodes[0].nodeValue == "1"){
         opener.document.form1.vatgroup_0.checked=true;
         } else {
         opener.document.form1.vatgroup_1.checked=true;
         }*/


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sub_tot");
        opener.document.form1.subtot.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");
        opener.document.form1.totdiscount.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vat");
        opener.document.form1.tax.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("net");
        opener.document.form1.invtot.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcou");
        opener.document.form1.mcou.value = XMLAddress1[0].childNodes[0].nodeValue;


        self.close();
    }

}




function passinvresult_crn()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("REF_NO");
        opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");
        opener.document.form1.inv_date.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CODE");
        opener.document.form1.cus_code.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CODE");
        opener.document.form1.c_subcode.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUS_NAME");
        opener.document.form1.cus_name.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUS_add");
        opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SAL_EX");
        var objSalesrep = opener.document.getElementById("salesrep");

        var salesrep = XMLAddress1[0].childNodes[0].nodeValue;
        var i = 0;
        while (i < objSalesrep.length)
        {
            if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
            {
                objSalesrep.options[i].selected = true;

            }
            i = i + 1;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DEPARTMENT");
        var objSalesrep = opener.document.getElementById("department");
        var salesrep = XMLAddress1[0].childNodes[0].nodeValue;
        var i = 0;
        while (i < objSalesrep.length)
        {
            if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
            {
                objSalesrep.options[i].selected = true;

            }
            i = i + 1;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");
        opener.document.form1.inv_date.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_amt");
        opener.document.form1.invamount.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TOTPAY");
        opener.document.form1.totpay.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("balance");
        opener.document.form1.invbal.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Brand");
        var objSalesrep = opener.document.getElementById("brand");
        var salesrep = XMLAddress1[0].childNodes[0].nodeValue;
        var i = 0;
        while (i < objSalesrep.length)
        {
            if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
            {
                objSalesrep.options[i].selected = true;

            }
            i = i + 1;
        }
        self.close();
    }

}

function passinvresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_invoiceno");
//		document.getElementById('invno1').value = XMLAddress1[0].childNodes[0].nodeValue;
        //alert(XMLAddress1[0].childNodes[0].nodeValue);
        opener.document.form1.invno.value = XMLAddress1[0].childNodes[0].nodeValue;
        //opener.document.form1.invno.value = "111111111";

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SDATE");
        opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_crecash");

        if (XMLAddress1[0].childNodes[0].nodeValue == 'CR')
        {
            opener.document.form1.paymethod_0.checked = true;

        } else if (XMLAddress1[0].childNodes[0].nodeValue == 'CA')
        {
            opener.document.form1.paymethod_1.checked = true;

        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customecode");
        opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;
        var txt_cuscode = XMLAddress1[0].childNodes[0].nodeValue;

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
        var objSalesrep = opener.document.getElementById("salesrep");

        var salesrep = XMLAddress1[0].childNodes[0].nodeValue;
        var i = 0;
        while (i < objSalesrep.length)
        {
            if (XMLAddress1[0].childNodes[0].nodeValue == objSalesrep.options[i].value)
            {
                objSalesrep.options[i].selected = true;

            }
            i = i + 1;
        }

        //alert(objSalesrep.length);



        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_salesorder1");	
        //	opener.document.form1.salesord1.value = XMLAddress1[0].childNodes[0].nodeValue;

        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_salesorder2");	
        //	opener.document.form1.salesord2.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dte_deliverdate");
        opener.document.form1.dte_dor.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_orderno1");
        opener.document.form1.salesord1.value = XMLAddress1[0].childNodes[0].nodeValue;
        //	opener.document.form1.orderno1.value = XMLAddress1[0].childNodes[0].nodeValue;

        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_orderno2");	
        //	opener.document.form1.orderdate.value = XMLAddress1[0].childNodes[0].nodeValue;

        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_credit");	
        //	opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;

        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_balance");	
        //	opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_department");
        var objDepartment = opener.document.getElementById("department");

        var i = 0;
        while (i < objDepartment.length)
        {
            if (XMLAddress1[0].childNodes[0].nodeValue == objDepartment.options[i].value)
            {
                objDepartment.options[i].selected = true;

            }
            i = i + 1;
        }


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_brand");
        var objBrand = opener.document.getElementById("brand");

        var i = 0;
        var brand = XMLAddress1[0].childNodes[0].nodeValue;
        while (i < objBrand.length)
        {
            if (XMLAddress1[0].childNodes[0].nodeValue == objBrand.options[i].value)
            {
                objBrand.options[i].selected = true;

            }
            i = i + 1;
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




        //else if(XMLAddress1[0].childNodes[0].nodeValue=='svat')
        //{
        //	opener.document.form1.vatgroup_2.checked=true;

        //}

        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount1");	
        //	opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;

        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cur_discount2");	
        //	opener.document.form1.discount2.value = XMLAddress1[0].childNodes[0].nodeValue;

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

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("promotion");
        if (XMLAddress1[0].childNodes[0].nodeValue == "1") {
            opener.document.getElementById("promotion").checked = true;
        } else {
            opener.document.getElementById("promotion").checked = false;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");
        opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");
        opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;

        /*XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
         opener.document.form1.discount_org1.value = XMLAddress1[0].childNodes[0].nodeValue;
         
         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis1");	
         opener.document.form1.discount_org2.value = XMLAddress1[0].childNodes[0].nodeValue;
         
         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis2");	
         opener.document.form1.discount_org3.value = XMLAddress1[0].childNodes[0].nodeValue;*/

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");
        window.opener.document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        opener.document.form1.cmd_new.value = 1;
        opener.document.form1.cmd_save.value = 0;
        opener.document.form1.cmd_cancel.value = 1;
        opener.document.form1.cmd_print.value = 1;


        opener.document.form1.credper.value = 65;
        //window.opener.document.getElementById("test").innerHTML="TESTNBMSVMS"
        //opener.document.forminv.invno.value = "123";
        //myWindow.opener.document.invno.value = "123";
        self.close();
        //alert(myWindow.opener.document.getElementById('invno').value);
        //forminv.getElementById('invno').value="125";

        //setTimeout("location.reload(true);",500);
        //if (xmlHttp.responseText=="exist"){
        //	alert("Already Exists");	
        //}

        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_table");	
        //document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        //document.getElementById('filt_table').innerHTML=xmlHttp.responseText;
    }
}


var win = null;
function NewWindow(mypage, myname, w, h, scroll, pos) {
    if (pos == "random") {
        LeftPosition = (screen.width) ? Math.floor(Math.random() * (screen.width - w)) : 100;
        TopPosition = (screen.height) ? Math.floor(Math.random() * ((screen.height - h) - 75)) : 100;
    }
    if (pos == "center") {
        LeftPosition = (screen.width) ? (screen.width - w) / 2 : 100;
        TopPosition = (screen.height) ? (screen.height - h) / 2 : 100;
    }
    else if ((pos != "center" && pos != "random") || pos == null) {
        LeftPosition = 0;
        TopPosition = 20
    }
    settings = 'width=' + w + ',height=' + h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
    win = window.open(mypage, myname, settings);
}

function load_ord_lst()
{
    if (document.getElementById('cmd_save').value == 1) {
        NewWindow('serach_ord.php?stname=inv_mast', 'mywin', '800', '700', 'yes', 'center');
    } else {
        alert("Cannot load order list");
    }
}

function load_ad_lst()
{
    if (document.getElementById('cmd_save').value == 1) {
        NewWindow('serach_ad.php?stname=inv_mast', 'mywin', '800', '700', 'yes', 'center');
    } else {
        alert("Cannot load order list");
    }
}

function ass_lim(credit_lim, rep, credit, balance, cat, brand, days)
{
    document.getElementById('txtlimit').value = credit_lim;

    document.getElementById("Com_rep").value = rep;

    document.getElementById("cmbbrand").value = brand;
    document.getElementById("cmbCAt").value = cat;
    document.getElementById("days").value = days;



}

function custno_ind(stname)
{
    //alert(stname);

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (stname == "utilization") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_utilization";
        url = url + "&custno=" + custno;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_utilization;

    } else if (stname == "ret_cheque_entry") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_ret_cheque_entry";
        url = url + "&custno=" + custno;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_ret_cheque;

    } else if (stname == "item_claim") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_item_claim";
        url = url + "&custno=" + custno;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_item_claim;
    } else if (stname == "grn") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_grn";
        url = url + "&custno=" + custno;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_grn;
    } else if (stname == "cust_mast") {
        clear_customer_ind();
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_cusno_cust_mast";
        url = url + "&custno=" + document.getElementById('txt_cuscode').value;
        xmlHttp.onreadystatechange = passcusresult_cust_mast_ind;
    } else if (stname == "rep_mast_general") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_repno_cust_mast";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_rep_mast;
    } else if (stname == "rep_mast_general_s") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_repno_cust_mast";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_rep_mast_s;
    } else if (stname == "cash_rec") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_cus_cash_rec";
        url = url + "&custno=" + custno;
        url = url + "&refno=" + opener.document.form1.salesrep.value;

        xmlHttp.onreadystatechange = passcusresult_cash_rec;
    } else if (stname == "ret_chq_settle") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_ret_chq_settle";
        url = url + "&custno=" + custno;
        url = url + "&refno=" + opener.document.form1.salesrep.value;

        xmlHttp.onreadystatechange = passcusresult_ret_chq;
    } else if (stname == "crn") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_crn";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_crn;
    } else if (stname == "rep_outstand_state") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "rep_outstand_state";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_rep_outstand_state_ind;

    } else if (stname == "weekly_ord") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "weekly_ord";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_weekly_ord;

    } else if (stname == "weekly_tar") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "weekly_tar";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_weekly_tar;

    } else if (stname == "defective_item") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "defective_item";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_defective_item;

    } else if (stname == "sal_reg") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "defective_item";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_sal_reg;
    } else {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_cusno";
        url = url + "&custno=" + document.getElementById("firstname_hidden").value;
        url = url + "&brand=" + document.getElementById("brand").value;
        url = url + "&salesrep=" + document.getElementById("salesrep").value;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_ind;
    }

    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function passcusresult_ind()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        var str = xmlHttp.responseText;
        if (str.length > 1335) {

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
            document.getElementById("firstname_hidden").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
            document.getElementById("firstname").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address");
            document.getElementById("cus_address").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno");
            document.getElementById("vat1").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_svatno");
            document.getElementById("vat2").value = XMLAddress1[0].childNodes[0].nodeValue;

            if ((document.getElementById("vat1").value == '') && (document.getElementById("vat2").value == '')) {
                document.getElementById("vatgroup_1").checked = true;
            } else if ((document.getElementById("vat1").value != '') && (document.getElementById("vat2").value == '')) {
                document.getElementById("vatgroup_0").checked = true;
            } else if ((document.getElementById("vat1").value != '') && (document.getElementById("vat2").value != '')) {
                document.getElementById("vatgroup_2").checked = true;
            }

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");
            document.getElementById("creditlimit").value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");
            document.getElementById("balance").value = XMLAddress1[0].childNodes[0].nodeValue;

            //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
            //opener.document.form1.discount1.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");
            document.getElementById("storgrid").innerHTML = XMLAddress1[0].childNodes[0].nodeValue;



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
            }

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg_return");
            if (XMLAddress1[0].childNodes[0].nodeValue != "") {
                alert(XMLAddress1[0].childNodes[0].nodeValue);
            }
            document.getElementById("department").focus();
        } else {

            alert("Invalid Customer No");
            document.getElementById("searchcust").focus();
        }
        //self.close();

        //opener.document.form1.salesrep.focus();


    }
}

function itno_ind()
{

    if (document.getElementById('itemd_hidden').value != "") {

        document.getElementById("additem_tmp").disabled = true;

        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }


        var url = "search_item_data.php";
        url = url + "?Command=" + "pass_itno";
        url = url + "&itno=" + document.getElementById('itemd_hidden').value;
        url = url + "&brand=" + document.getElementById('brand').value;
        url = url + "&department=" + document.getElementById('department').value;
        //alert(url);
        var vatmethod = "";
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

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_selpri");
            document.getElementById('rate').value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");
            document.getElementById('stklevel').value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("actual_selling");
            document.getElementById('actual_selling').value = XMLAddress1[0].childNodes[0].nodeValue;
            //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
            //	opener.document.form1.discount.value = XMLAddress1[0].childNodes[0].nodeValue;
            document.getElementById('qty').focus();

            document.getElementById("additem_tmp").disabled = false;
        } else {
            //self.close();
            alert("Invalid Item No");
            document.getElementById('searchitem').focus();
        }


    }
}



function custno(custno, stname)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (stname == "modify") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_modify";
        url = url + "&custno=" + custno;


        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_modify;

    } else if (stname == "quot") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_quot";
        url = url + "&custno=" + custno;


        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_quot;

    } else if (stname == "utilization") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_utilization";
        url = url + "&custno=" + custno;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_utilization;

    } else if (stname == "ret_cheque_entry") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_ret_cheque_entry";
        url = url + "&custno=" + custno;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_ret_cheque;

    } else if (stname == "item_claim") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_item_claim";
        url = url + "&custno=" + custno;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_item_claim;
    } else if (stname == "grn") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_grn";
        url = url + "&custno=" + custno;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_grn;
    } else if (stname == "cust_mast") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_cusno_cust_mast";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_cust_mast;
    } else if (stname == "rep_mast_general") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_repno_cust_mast";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_rep_mast;
    } else if (stname == "rep_mast_general_s") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_repno_cust_mast";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_rep_mast_s;
    } else if (stname == "cash_rec") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_cus_cash_rec";
        url = url + "&custno=" + custno;
        url = url + "&refno=" + opener.document.form1.salesrep.value;

        xmlHttp.onreadystatechange = passcusresult_cash_rec;

    } else if (stname == "adv_rec") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_cus_cash_rec";
        url = url + "&custno=" + custno;
        url = url + "&refno=" + opener.document.form1.salesrep.value;

        xmlHttp.onreadystatechange = passcusresult_adv_rec;

    } else if (stname == "ret_chq_settle") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_ret_chq_settle";
        url = url + "&custno=" + custno;
        url = url + "&refno=" + opener.document.form1.salesrep.value;

        xmlHttp.onreadystatechange = passcusresult_ret_chq;
    } else if (stname == "crn") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "pass_crn";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_crn;

    } else if (stname == "rep_outstand_state") {
//        alert('asdas');
        var url = "search_custom_data.php";
        url = url + "?Command=" + "rep_outstand_state";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_rep_outstand_state;

    } else if (stname == "rep_settlement") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "rep_settlement";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_rep_settlement;

    } else if (stname == "rep_monthly_sales") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "rep_outstand_state";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_rep_monthly_sales;

    } else if (stname == "weekly_ord") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "weekly_ord";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_weekly_ord;

    } else if (stname == "weekly_tar") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "weekly_tar";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_weekly_tar;

    } else if (stname == "defective_item") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "defective_item";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_defective_item;

    } else if (stname == "sal_reg") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "defective_item";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_sal_reg;
    } else if (stname == "sal_reg1") {
        var url = "search_custom_data.php";
        url = url + "?Command=" + "sal_reg1";
        url = url + "&custno=" + custno;
        xmlHttp.onreadystatechange = passcusresult_sal_reg1;
    } else if (stname == "incentive") {

        var url = "search_custom_data.php";

        url = url + "?Command=" + "incentive";
        url = url + "&custno=" + custno;
        //url=url+"&brand="+opener.document.form1.brand.value;
        //url=url+"&salesrep="+opener.document.form1.salesrep.value;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_incentive;

    } else if (stname == "incentive2") {

        var url = "search_custom_data.php";

        url = url + "?Command=" + "incentive2";
        url = url + "&custno=" + custno;
        //url=url+"&brand="+opener.document.form1.brand.value;
        //url=url+"&salesrep="+opener.document.form1.salesrep.value;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_incentive;


    } else if (stname == "bin_card") {

        var url = "search_custom_data.php";

        url = url + "?Command=" + "bin_card";
        url = url + "&custno=" + custno;
        //url=url+"&brand="+opener.document.form1.brand.value;
        //url=url+"&salesrep="+opener.document.form1.salesrep.value;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_bin_card;

    } else if (stname == "rep_dealercard") {

        var url = "search_custom_data.php";

        url = url + "?Command=" + "rep_dealercard";
        url = url + "&custno=" + custno;
        //url=url+"&brand="+opener.document.form1.brand.value;
        //url=url+"&salesrep="+opener.document.form1.salesrep.value;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult_rep_dealercard;
    
    }else if (stname == "sales_order") {

        var url = "search_custom_data.php";

        url = url + "?Command=" + "pass_cusno";
        url = url + "&custno=" + custno;
        url=url+"&stname="+stname;
        url = url + "&brand=" + opener.document.form1.brand.value;
        url = url + "&salesrep=" + opener.document.form1.salesrep.value;
        //url=url+"&salesrep="+opener.document.form1.salesrep.value;
        // alert(url);
        xmlHttp.onreadystatechange = passcusresult;

    } else {

        document.getElementById('stat').innerHTML = "Please Wait"

        var url = "search_custom_data.php";

        url = url + "?Command=" + "pass_cusno";
        url = url + "&custno=" + custno;
        url = url + "&brand=" + opener.document.form1.brand.value;
        url = url + "&salesrep=" + opener.document.form1.salesrep.value;
        //alert(url);
        xmlHttp.onreadystatechange = passcusresult;
    }

    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}


function passcusresult_rep_dealercard()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.cusname.value = XMLAddress1[0].childNodes[0].nodeValue;

        opener.document.form1.chkcus.checked = true;


        self.close();
    }
}


function passcusresult_utilization()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.Txtcusco.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.txt_cusname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");
        var add1 = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");
        var add2 = XMLAddress1[0].childNodes[0].nodeValue;

        add = add1 + ' ' + add2;
        opener.document.form1.TXTADD.value = add;

        opener.document.form1.txtcrnno.value = ""
        opener.document.form1.txtcrnamount.value = ""
        opener.document.form1.txtrem_bal.value = ""


        self.close();
    }
}

function passcusresult_ret_cheque()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        //var a=XMLAddress1[0].childNodes[0].nodeValue;;
        //alert(a);
        opener.document.form1.Txtcusco.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.txtcusname.value = XMLAddress1[0].childNodes[0].nodeValue;




        self.close();
    }
}

function passcusresult_item_claim()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.txtag_code.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.txtag_name.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");
        var add1 = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");
        var add2 = XMLAddress1[0].childNodes[0].nodeValue;

        opener.document.form1.txtagadd.value = add1 + " " + add2;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_subcode");
        opener.document.form1.c_subcode.value = XMLAddress1[0].childNodes[0].nodeValue;


        self.close();
    }
}


function passcusresult_grn()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");
        var add1 = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");
        var add2 = XMLAddress1[0].childNodes[0].nodeValue;

        opener.document.form1.cus_address.value = add1 + " " + add2;

        self.close();
    }
}


function passcusresult_modify()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.txtcode.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.txtname.value = XMLAddress1[0].childNodes[0].nodeValue;

        /*XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");	
         var add1=XMLAddress1[0].childNodes[0].nodeValue;
         
         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");	
         var add2=XMLAddress1[0].childNodes[0].nodeValue;
         
         opener.document.form1.cus_address.value =add1+" "+add2;*/

        self.close();
    }
}


function passcusresult_crn()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.cus_code.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.cus_name.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");
        var add1 = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");
        var add2 = XMLAddress1[0].childNodes[0].nodeValue;



        opener.document.form1.cus_address.value = add1 + " " + add2;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_subcode");
        opener.document.form1.c_subcode.value = XMLAddress1[0].childNodes[0].nodeValue;


        self.close();
    }
}

function passcusresult_rep_monthly_sales()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.cusname.value = XMLAddress1[0].childNodes[0].nodeValue;

        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");	
        //var add1=XMLAddress1[0].childNodes[0].nodeValue;

        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");	
        //	var add2=XMLAddress1[0].childNodes[0].nodeValue;

        //opener.document.form1.cus_address.value =add1+" "+add2;

        self.close();
    }
}

function passcusresult_rep_outstand_state()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.cusname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");
        var add1 = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");
        var add2 = XMLAddress1[0].childNodes[0].nodeValue;

        opener.document.form1.cus_address.value = add1 + " " + add2;
//alert('asds');
        //opener.document.form1.chkcus.checked=true;
        self.close();
    }
}


function passcusresult_rep_settlement()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.cusname.value = XMLAddress1[0].childNodes[0].nodeValue;

        opener.document.form1.chkcus.checked = true;

        self.close();
    }
}

function passcusresult_rep_outstand_state_ind()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        document.getElementById('cuscode').value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        document.getElementById('cusname').value = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('searchcust').focus();
    }
}

function passcusresult_weekly_ord()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");
        var add1 = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");
        var add2 = XMLAddress1[0].childNodes[0].nodeValue;

        opener.document.form1.cus_address.value = add1 + " " + add2;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vatno");
        opener.document.form1.vat1.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("svatno");
        opener.document.form1.vat2.value = XMLAddress1[0].childNodes[0].nodeValue;

        self.close();
    }
}

function passcusresult_weekly_tar()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.cusname.value = XMLAddress1[0].childNodes[0].nodeValue;


        self.close();
    }
}

function passcusresult_defective_item()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.txt_cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.txt_cusname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");
        var add1 = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");
        var add2 = XMLAddress1[0].childNodes[0].nodeValue;

        opener.document.form1.txtadd.value = add1 + " " + add2;

        self.close();
    }
}

function passcusresult_sal_reg()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.txt_cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;
        ;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.txt_cusname.value = XMLAddress1[0].childNodes[0].nodeValue;



        self.close();
    }
}


function passcusresult_sal_reg1()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.txt_cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.txt_cusname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("type1");

        if (XMLAddress1[0].childNodes[0].nodeValue == "S") {
            opener.document.form1.Check2.checked = true;
            opener.document.form1.Check2.disabled = true;

        } else {
            opener.document.form1.Check2.checked = false;
            opener.document.form1.Check2.disabled = true;
        }

        self.close();
    }
}

function passcusresult_ret_chq()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");
        opener.document.form1.hiddencount.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");
        opener.document.form1.cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");
        opener.document.form1.cusname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("address");
        opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");
        //alert( XMLAddress1[0].childNodes[0].nodeValue);
        window.opener.document.getElementById('inv_details').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
        //alert("ok");

        self.close();
        //opener.document.form1.txtdetar.focus();
    }
}

function passcusresult_adv_rec()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");
        opener.document.form1.cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");
        opener.document.form1.cusname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("address");
        opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;


        //alert("ok");

        self.close();
        //opener.document.form1.txtdetar.focus();
    }
}


function passcusresult_cash_rec()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mcount");
        opener.document.form1.hiddencount.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");
        opener.document.form1.cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");
        opener.document.form1.cusname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("address");
        opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");
        //alert( XMLAddress1[0].childNodes[0].nodeValue);
        window.opener.document.getElementById('inv_details').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
        //alert("ok");

        self.close();
        //opener.document.form1.txtdetar.focus();
    }
}


function add_gr1()
{

    if (document.getElementById('txt_cuscode').value != "") {

        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }

        var url = "search_custom_data.php";
        url = url + "?Command=" + "add_gr";
        url = url + "&txt_cuscode=" + document.getElementById('txt_cuscode').value;
        url = url + "&gr_type=" + document.getElementById('gr_type').value;
        url = url + "&gr_amount=" + document.getElementById('gr_amount').value;
        url = url + "&gr_date=" + document.getElementById('gr_date').value;
        url = url + "&gr_status=" + document.getElementById('gr_status').checked;
        url = url + "&gr_bank=" + document.getElementById('gr_bank').value;
        url = url + "&gr_id=" + document.getElementById('gr_id').value;

    } else {
        alert("Customer Code Is Empty");
    }
//alert(url);
    xmlHttp.onreadystatechange = res_add_gr;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function res_add_gr() {


    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
        //document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('gr_type').value = "";
        document.getElementById('gr_amount').value = "";
        document.getElementById('gr_date').value = "";
        document.getElementById('gr_status').value = "";
        document.getElementById('gr_id').value = "";
        document.getElementById('gr_bank').value = "";

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('grdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    }
}



function del_gr(txt_cuscode, gr_id)
{



    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "search_custom_data.php";
    url = url + "?Command=" + "del_gr";
    url = url + "&txt_cuscode=" + txt_cuscode;
    url = url + "&gr_id=" + gr_id;


//alert(url);
    xmlHttp.onreadystatechange = res_del_gr;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function res_del_gr() {


    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
        //document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('gr_type').value = "";
        document.getElementById('gr_amount').value = "";
        document.getElementById('gr_date').value = "";
        document.getElementById('gr_status').value = "";
        document.getElementById('gr_id').value = "";

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('grdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    }
}


function setord()
{
    document.getElementById('stklevel').value = "";

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "inv_data.php";
    url = url + "?Command=" + "setord";
    url = url + "&custno=" + document.getElementById('firstname_hidden').value;
    //url=url+"&salesord1="+document.getElementById('salesord1').value;
    url = url + "&salesrep=" + document.getElementById('salesrep').value;
    url = url + "&brand=" + document.getElementById('brand').value;
    url = url + "&department=" + document.getElementById('department').value;
    url = url + "&invdate=" + document.getElementById('invdate').value;
//alert(url);
    xmlHttp.onreadystatechange = setord_result_inv;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function setord_result_inv() {


    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesord");	
        //document.getElementById('salesord1').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");
        document.getElementById('invno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdono");
        document.getElementById('txtdono').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");
        document.getElementById('creditlimit').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("creditbalance");
        document.getElementById('balance').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("crebal");
        document.getElementById('crebal').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");
        document.getElementById('invno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtdono");
        document.getElementById('txtdono').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");
        document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("netqty");
        document.getElementById('txtinvt').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

    }


}

function passcusresult_rep_mast_s()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");
        opener.document.form1.txt_cuscode_s.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");
        opener.document.form1.txt_cusname_s.value = XMLAddress1[0].childNodes[0].nodeValue;

        opener.document.form1.txtdetar_s.value = "";


        self.close();
        opener.document.form1.txtdetar.focus();
    }
}

function passcusresult_rep_mast()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("code");
        opener.document.form1.txt_cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");
        opener.document.form1.txt_cusname.value = XMLAddress1[0].childNodes[0].nodeValue;

        opener.document.form1.txtdetar.value = "";


        self.close();
        opener.document.form1.txtdetar.focus();
    }
}

function passcusresult_cust_mast_ind()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("blacklist");

        if (XMLAddress1[0].childNodes[0].nodeValue == "1") {
            document.getElementById('check1').value = true;
        } else {
            document.getElementById('check1').value = false;
        }

        document.getElementById('txt_cuscode').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        document.getElementById('txt_cuscode').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        document.getElementById('txtCNAME').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");
        document.getElementById('txtBADD1').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");
        document.getElementById('txtBADD2').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("district");
        document.getElementById('txtdistrict').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("province");
        document.getElementById('txtprovince').value = XMLAddress1[0].childNodes[0].nodeValue;


        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("OPBAL");	
        //	opener.document.form1.txt_crelimi.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TELE1");
        document.getElementById('txtTEL').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TELE2");
        document.getElementById('txttel2').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CONT");
        document.getElementById('txtcper').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUR_BAL");
        document.getElementById('txtbal').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("LIMIT");
        document.getElementById('txtcrlimt').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PEN");
        document.getElementById('txtover').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("FAX");
        document.getElementById('txtFAX').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("acno");
        document.getElementById('txtACCno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("EMAIL");
        document.getElementById('TXTEMAIL').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CAT");
        document.getElementById('txtcat').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("svatno");
        document.getElementById('SVAT').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vatno");
        document.getElementById('txtvatno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("OPDATE");
        document.getElementById('DTOPDATE').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("area");
        document.getElementById('txtarea').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUS_TYPE");
        document.getElementById('txttype').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("note");
        document.getElementById('txtnote').value = XMLAddress1[0].childNodes[0].nodeValue;

        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("temp_limit");	
        //opener.document.form1.txt_tmeplimit.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bank_gr_date");
        document.getElementById('DTbankgrdate').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("AltMessage");
        document.getElementById('txtMsg').value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("gr_table");
        document.getElementById('grdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('creditlim').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cre_lim");
        document.getElementById('txtcrlimt').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtvatgroup");
        document.getElementById('txtvatgroup').value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("incdays");
        document.getElementById('txtInc').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_cat");
        document.getElementById('txt_scat').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_commcode");
        document.getElementById('txt_commcode').value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("remark");
        document.getElementById('remark').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("doc_mod");
        var doc_mod = XMLAddress1[0].childNodes[0].nodeValue;
        if (doc_mod != "1") {
            opener.document.form1.txt_cuscode.disabled = true;
            opener.document.form1.txt_cuscode.disabled = true;
            opener.document.form1.txtCNAME.disabled = true;
            opener.document.form1.txtBADD1.disabled = true;
            opener.document.form1.txtBADD2.disabled = true;
            opener.document.form1.txtTEL.disabled = true;
            opener.document.form1.txttel2.disabled = true;
            opener.document.form1.txtcper.disabled = true;
            opener.document.form1.txtbal.disabled = true;
            opener.document.form1.txtcrlimt.disabled = true;
            opener.document.form1.txtover.disabled = true;
            opener.document.form1.txtFAX.disabled = true;
            opener.document.form1.txtACCno.disabled = true;
            opener.document.form1.TXTEMAIL.disabled = true;
            opener.document.form1.txtcat.disabled = true;
            opener.document.form1.SVAT.disabled = true;
            //opener.document.form1.txtvatno.disabled = true;
            opener.document.form1.DTOPDATE.disabled = true;
            opener.document.form1.txtarea.disabled = true;
            opener.document.form1.txttype.disabled = true;
            opener.document.form1.txtnote.disabled = true;
            opener.document.form1.DTbankgrdate.disabled = true;
            opener.document.form1.txtMsg.disabled = true;
            window.opener.document.getElementById('grdetails').disabled = true;
            window.opener.document.getElementById('creditlim').disabled = true;
            window.opener.document.getElementById('info_table').disabled = true;
            opener.document.form1.txtcrlimt.disabled = true;
            opener.document.form1.txtInc.disabled = true;
            opener.document.form1.TXT_REP.disabled = true;
            opener.document.form1.txt_scat.disabled = true;
            opener.document.form1.remark.disabled = true;
        }
        //opener.document.form1.salesrep.focus();


    }
}


function passcusresult_cust_mast()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("blacklist");

        if (XMLAddress1[0].childNodes[0].nodeValue == "1") {
            opener.document.form1.check1.checked = true;
        } else {
            opener.document.form1.check1.checked = false;
        }

        opener.document.form1.txt_cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.txt_cuscode.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.txtCNAME.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD1");
        opener.document.form1.txtBADD1.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ADD2");
        opener.document.form1.txtBADD2.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("district");
        opener.document.getElementById('txtdistrict').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("province");
        opener.document.getElementById('txtprovince').value = XMLAddress1[0].childNodes[0].nodeValue;


        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("OPBAL");	
        //	opener.document.form1.txt_crelimi.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TELE1");
        opener.document.form1.txtTEL.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TELE2");
        opener.document.form1.txttel2.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CONT");
        opener.document.form1.txtcper.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUR_BAL");
        opener.document.form1.txtbal.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("LIMIT");
        opener.document.form1.txtcrlimt.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PEN");
        opener.document.form1.txtover.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("FAX");
        opener.document.form1.txtFAX.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("acno");
        opener.document.form1.txtACCno.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("EMAIL");
        opener.document.form1.TXTEMAIL.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CAT");
        opener.document.form1.txtcat.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("svatno");
        opener.document.form1.SVAT.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vatno");
        opener.document.form1.txtvatno.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("OPDATE");
        opener.document.form1.DTOPDATE.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("area");
        opener.document.form1.txtarea.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CUS_TYPE");
        opener.document.form1.txttype.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("note");
        opener.document.form1.txtnote.value = XMLAddress1[0].childNodes[0].nodeValue;

        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("temp_limit");	
        //opener.document.form1.txt_tmeplimit.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bank_gr_date");
        opener.document.form1.DTbankgrdate.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("AltMessage");
        opener.document.form1.txtMsg.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtvatgroup");
        opener.document.form1.txtvatgroup.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("gr_table");
        window.opener.document.getElementById('grdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        window.opener.document.getElementById('creditlim').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("info_table");
        window.opener.document.getElementById('info_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cre_lim");
        opener.document.form1.txtcrlimt.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("incdays");
        opener.document.form1.txtInc.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TXT_REP");
        opener.document.form1.TXT_REP.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_cat");
        opener.document.form1.txt_scat.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_commcode");
        opener.document.form1.txt_commcode.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("remark");
        opener.document.form1.remark.value = XMLAddress1[0].childNodes[0].nodeValue;


        //opener.document.form1.check1.disabled = true;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("doc_mod");
        var doc_mod = XMLAddress1[0].childNodes[0].nodeValue;
        if (doc_mod != "1") {
            opener.document.form1.txt_cuscode.disabled = true;
            opener.document.form1.txt_cuscode.disabled = true;
            opener.document.form1.txtCNAME.disabled = true;
            opener.document.form1.txtBADD1.disabled = true;
            opener.document.form1.txtBADD2.disabled = true;
            opener.document.form1.txtTEL.disabled = true;
            opener.document.form1.txttel2.disabled = true;
            opener.document.form1.txtcper.disabled = true;
            opener.document.form1.txtbal.disabled = true;
            opener.document.form1.txtcrlimt.disabled = true;
            opener.document.form1.txtover.disabled = true;
            opener.document.form1.txtFAX.disabled = true;
            opener.document.form1.txtACCno.disabled = true;
            opener.document.form1.TXTEMAIL.disabled = true;
            opener.document.form1.txtcat.disabled = true;
            opener.document.form1.SVAT.disabled = true;
            //opener.document.form1.txtvatno.disabled = true;
            opener.document.form1.DTOPDATE.disabled = true;
            opener.document.form1.txtarea.disabled = true;
            opener.document.form1.txttype.disabled = true;
            opener.document.form1.txtnote.disabled = true;
            opener.document.form1.DTbankgrdate.disabled = true;
            opener.document.form1.txtMsg.disabled = true;
            window.opener.document.getElementById('grdetails').disabled = true;
            window.opener.document.getElementById('creditlim').disabled = true;
            window.opener.document.getElementById('info_table').disabled = true;
            opener.document.form1.txtcrlimt.disabled = true;
            opener.document.form1.txtInc.disabled = true;
            opener.document.form1.TXT_REP.disabled = true;
            opener.document.form1.txt_scat.disabled = true;
            opener.document.form1.remark.disabled = true;
        }

        self.close();
        opener.document.form1.salesrep.focus();


    }
}

function update_limit(doc_mod)
{

    if (doc_mod == "1") {

        //var msg=confirm("Are you sure to DELETE ?");

        //if (msg==true){
        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }


        var url = "search_custom_data.php";
        url = url + "?Command=" + "update_limit";
        url = url + "&txt_cuscode=" + document.getElementById('txt_cuscode').value;
        url = url + "&rep=" + document.getElementById('Com_rep').value;
        url = url + "&brand=" + document.getElementById('cmbbrand').value;
        url = url + "&txtlimit=" + document.getElementById('txtlimit').value;
        url = url + "&cmbCAt=" + document.getElementById('cmbCAt').value;
        url = url + "&days=" + document.getElementById('days').value;
        url = url + "&stopinv=" + document.getElementById('check1').checked;

        xmlHttp.onreadystatechange = passitresult_update_limit;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
        //}
    } else {
        alert("You have no permission to update!");
    }


}

function passitresult_update_limit()
{
    //alert(xmlHttp.responseText);

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totcr");
    document.getElementById('txtcrlimt').value = XMLAddress1[0].childNodes[0].nodeValue;

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cre_table");
    //alert(XMLAddress1[0].childNodes[0].nodeValue);
    document.getElementById('creditlim').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

    alert("Updated");

}

function delete_limit(doc_mod)
{
    if (doc_mod == "1") {

        var msg = confirm("Are you sure to DELETE ?");

        if (msg == true) {
            xmlHttp = GetXmlHttpObject();
            if (xmlHttp == null)
            {
                alert("Browser does not support HTTP Request");
                return;
            }


            var url = "search_custom_data.php";
            url = url + "?Command=" + "delete_limit";
            url = url + "&txt_cuscode=" + document.getElementById('txt_cuscode').value;
            url = url + "&rep=" + document.getElementById('Com_rep').value;
            url = url + "&brand=" + document.getElementById('cmbbrand').value;
            url = url + "&txtlimit=" + document.getElementById('txtlimit').value;
            url = url + "&cmbCAt=" + document.getElementById('cmbCAt').value;
            url = url + "&stopinv=" + document.getElementById('check1').checked;

            xmlHttp.onreadystatechange = passitresult_delete_limit;
            xmlHttp.open("GET", url, true);
            xmlHttp.send(null);
        }
    } else {
        alert("You have no permission to delete!");
    }

}

function passitresult_delete_limit()
{
    //alert(xmlHttp.responseText);

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totcr");
    document.getElementById('txtcrlimt').value = XMLAddress1[0].childNodes[0].nodeValue;

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cre_table");
    document.getElementById('creditlim').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

    alert("Deleted");

}


function passcusresult_quot()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
        opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address");
        opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno");
        opener.document.form1.vat1.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_svatno");
        opener.document.form1.vat2.value = XMLAddress1[0].childNodes[0].nodeValue;

        vat1 = opener.document.form1.vat1.value;
        vat2 = opener.document.form1.vat2.value;

        if ((vat1.trim() == '') && (vat2.trim() == '')) {
            opener.document.form1.vatgroup_1.checked = true;
        } else if ((vat1.trim() != '') && (vat2.trim() == '')) {

            opener.document.form1.vatgroup_0.checked = true;
        } else if ((vat1.trim() != '') && (vat2.trim() != '')) {
            opener.document.form1.vatgroup_2.checked = true;

        }



        self.close();
    }
}


function passcusresult_incentive()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;



        self.close();

        //opener.document.form1.salesrep.focus();


    }
}

function passcusresult_bin_card()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("NAME");
        opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;



        self.close();

        //opener.document.form1.salesrep.focus();


    }
}


function passcusresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        // alert(xmlHttp.responseText);


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.firstname_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
        opener.document.form1.firstname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address");
        opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;
        
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stname");
        var stname =XMLAddress1[0].childNodes[0].nodeValue;
        if(stname == "sales_order"){
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_address1");
            opener.document.form1.cus_address1.value = XMLAddress1[0].childNodes[0].nodeValue;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_vatno");
        opener.document.form1.vat1.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_svatno");
        opener.document.form1.vat2.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("c_subcode");
        opener.document.form1.c_subcode.value = XMLAddress1[0].childNodes[0].nodeValue;


        vat1 = opener.document.form1.vat1.value;
        vat2 = opener.document.form1.vat2.value;

        if ((vat1.trim() == '') && (vat2.trim() == '')) {
            opener.document.form1.vatgroup_1.checked = true;
        } else if ((vat1.trim() != '') && (vat2.trim() == '')) {

            opener.document.form1.vatgroup_0.checked = true;
        } else if ((vat1.trim() != '') && (vat2.trim() != '')) {
            opener.document.form1.vatgroup_2.checked = true;

        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("crebal");
        opener.document.form1.crebal.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crelimi");
        opener.document.form1.creditlimit.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_crebal");
        opener.document.form1.balance.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("over60_txt");
        opener.document.form1.over60.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("netqty");
        opener.document.form1.txtinvt.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("over60_qst");
        if (XMLAddress1[0].childNodes[0].nodeValue != "") {
            opener.document.form1.over60.value = "0";
        }



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table_acc");
        window.opener.document.getElementById('storgrid').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("AltMessage");
        var a = XMLAddress1[0].childNodes[0].nodeValue;
        if (a.trim() != "") {
            alert(XMLAddress1[0].childNodes[0].nodeValue);
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("bank_message");
        var a = XMLAddress1[0].childNodes[0].nodeValue;
        if (a.trim() != "") {
            alert(XMLAddress1[0].childNodes[0].nodeValue);
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("over60_message");
        var a = XMLAddress1[0].childNodes[0].nodeValue;
        if (a.trim() != "") {
            alert(XMLAddress1[0].childNodes[0].nodeValue);
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_message");
        var a = XMLAddress1[0].childNodes[0].nodeValue;
        if (a.trim() != "") {
            alert(XMLAddress1[0].childNodes[0].nodeValue);
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("chq_message_que");
        var a = XMLAddress1[0].childNodes[0].nodeValue;
        if (a.trim() != "") {
            var ans = confirm(XMLAddress1[0].childNodes[0].nodeValue);
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg_return");
        var a = XMLAddress1[0].childNodes[0].nodeValue;
        if (a.trim() != "") {
            alert(XMLAddress1[0].childNodes[0].nodeValue);
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("blacklist");
        var a = XMLAddress1[0].childNodes[0].nodeValue;
        if (a.trim() == "1") {
            alert("Blocked For Invoicing");
        }

        self.close();




    }
}

function itno_quot(itno)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_item_data.php";
    url = url + "?Command=" + "pass_itno_quot";
    url = url + "&itno=" + itno;
    url = url + "&brand=" + opener.document.form1.brand.value;
    url = url + "&department=" + opener.document.form1.department.value;

    var vatmethod = "";
    if (opener.document.form1.vatgroup_0.checked == true) {
        vatmethod = "vat";
    } else if (opener.document.form1.vatgroup_1.checked == true) {
        vatmethod = "non";
    } else if (opener.document.form1.vatgroup_2.checked == true) {
        vatmethod = "svat";
    } else if (opener.document.form1.vatgroup_3.checked == true) {
        vatmethod = "evat";
    }

    url = url + "&vatmethod=" + vatmethod;

    //alert(url);
    xmlHttp.onreadystatechange = passitresult_itno_quot;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);



}

function passitresult_itno_quot()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");
        opener.document.form1.itemd_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");
        opener.document.form1.itemd.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_selpri");
        opener.document.form1.rate.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");
        opener.document.form1.stklevel.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_partno");
        opener.document.form1.part_no.value = XMLAddress1[0].childNodes[0].nodeValue;

        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
        //	opener.document.form1.discount.value = XMLAddress1[0].childNodes[0].nodeValue;


        self.close();
        opener.document.form1.qty.focus();



    }
}

function itno(itno)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_item_data.php";
    url = url + "?Command=" + "pass_itno";
    url = url + "&itno=" + itno;
    url = url + "&brand=" + opener.document.form1.brand.value;
    url = url + "&department=" + opener.document.form1.department.value;

    var vatmethod = "";
    if (opener.document.form1.vatgroup_0.checked == true) {
        vatmethod = "vat";
    } else if (opener.document.form1.vatgroup_1.checked == true) {
        vatmethod = "non";
    } else if (opener.document.form1.vatgroup_2.checked == true) {
        vatmethod = "svat";
    } else if (opener.document.form1.vatgroup_3.checked == true) {
        vatmethod = "evat";
    }
 
    url = url + "&vatmethod=" + vatmethod;

    url = url + "&discount_org1=" + opener.document.form1.discount_org1.value;
    url = url + "&discount_org2=" + opener.document.form1.discount_org2.value;
    url = url + "&discount_org3=" + opener.document.form1.discount_org3.value;

    //alert(url);
    xmlHttp.onreadystatechange = passitresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);



}

function passitresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");
        opener.document.form1.itemd_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");
        opener.document.form1.itemd.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_selpri");
        opener.document.form1.rate.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");
        opener.document.form1.stklevel.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_partno");
        opener.document.form1.part_no.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("actual_selling");
        opener.document.form1.actual_selling.value = XMLAddress1[0].childNodes[0].nodeValue;

        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
        //	opener.document.form1.discount.value = XMLAddress1[0].childNodes[0].nodeValue;


        self.close();
        opener.document.form1.qty.focus();



    }
}


function itno_grn(itno)
{

    //alert("ok");
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "search_item_data.php";
    url = url + "?Command=" + "pass_itno_grn";
    url = url + "&itno=" + itno;
    url = url + "&brand=" + opener.document.form1.brand.value;
    url = url + "&department=" + opener.document.form1.department.value;

    var vatmethod = "";
    if (opener.document.form1.vatgroup_0.checked == true) {
        vatmethod = "vat";
    } else if (opener.document.form1.vatgroup_1.checked == true) {
        vatmethod = "non";
    } else if (opener.document.form1.vatgroup_2.checked == true) {
        vatmethod = "svat";
    } else if (opener.document.form1.vatgroup_3.checked == true) {
        vatmethod = "evat";
    }

    url = url + "&vatmethod=" + vatmethod;

    //alert(url);
    xmlHttp.onreadystatechange = passitresult_grn;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);



}

function passitresult_grn()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");
        opener.document.form1.item_code.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");
        opener.document.form1.itemd.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_selpri");
        opener.document.form1.rate.value = XMLAddress1[0].childNodes[0].nodeValue;

        /*XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");	
         opener.document.form1.stklevel.value = XMLAddress1[0].childNodes[0].nodeValue;
         
         
         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_partno");	
         opener.document.form1.part_no.value = XMLAddress1[0].childNodes[0].nodeValue;
         
         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("actual_selling");	
         opener.document.form1.actual_selling.value = XMLAddress1[0].childNodes[0].nodeValue;*/

        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
        //	opener.document.form1.discount.value = XMLAddress1[0].childNodes[0].nodeValue;
        opener.document.form1.qty.focus();

        self.close();




    }
}

function itno_weekly(itno)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_item_data.php";
    url = url + "?Command=" + "pass_itno_weekly";
    url = url + "&itno=" + itno;
    url = url + "&brand=" + opener.document.form1.brand.value;
    url = url + "&department=" + opener.document.form1.department.value;

    var vatmethod = "non";
    /*if (opener.document.form1.vatgroup_0.checked==true){
     vatmethod="vat";
     } else if (opener.document.form1.vatgroup_1.checked==true){
     vatmethod="non";
     } else if (opener.document.form1.vatgroup_2.checked==true){
     vatmethod="svat";
     } else if (opener.document.form1.vatgroup_3.checked==true){
     vatmethod="evat";
     }*/

    url = url + "&vatmethod=" + vatmethod;
    alert(url);
    /*	url=url+"&discount_org1="+opener.document.form1.discount_org1.value;
     url=url+"&discount_org2="+opener.document.form1.discount_org2.value;
     url=url+"&discount_org3="+opener.document.form1.discount_org3.value;*/

    //alert(url);
    xmlHttp.onreadystatechange = passitresult_weekly;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);



}

function passitresult_weekly()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");
        opener.document.form1.itemd_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");
        opener.document.form1.itemd.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_selpri");
        opener.document.form1.rate.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("qtyinhand");
        opener.document.form1.stklevel.value = XMLAddress1[0].childNodes[0].nodeValue;


        //XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_partno");	
        //opener.document.form1.part_no.value = XMLAddress1[0].childNodes[0].nodeValue;

        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
        //	opener.document.form1.discount.value = XMLAddress1[0].childNodes[0].nodeValue;


        self.close();
        opener.document.form1.qty.focus();



    }
}

function itno_undeliver(itno, stname)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_item_data.php";
    url = url + "?Command=" + "pass_itno_undeliver";
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
        opener.document.form1.itemd_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");
        opener.document.form1.itemd.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PART_NO");
        opener.document.form1.part_no.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("COST");
        opener.document.form1.rate.value = XMLAddress1[0].childNodes[0].nodeValue;
        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
        //	opener.document.form1.discount.value = XMLAddress1[0].childNodes[0].nodeValue;


        self.close();
        opener.document.form1.qty.focus();



    }
}




function itno_claim(itno, stname)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_item_data.php";
    url = url + "?Command=" + "pass_itno_claim";
    url = url + "&itno=" + itno;
    url = url + "&stname=" + stname;

    //alert(url);
    xmlHttp.onreadystatechange = itno_claim_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);



}

function itno_claim_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");
        opener.document.form1.txtstk_no.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");
        opener.document.form1.txtdes.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BRAND_NAME");
        opener.document.form1.txtbrand.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PART_NO");
        opener.document.form1.txtpatt.value = XMLAddress1[0].childNodes[0].nodeValue;
        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
        //	opener.document.form1.discount.value = XMLAddress1[0].childNodes[0].nodeValue;


        self.close();
        opener.document.form1.Combo1.focus();



    }
}


function itno_defect(itno, stname)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_item_data.php";
    url = url + "?Command=" + "pass_itno_defect";
    url = url + "&itno=" + itno;
    url = url + "&stname=" + stname;

    //alert(url);
    xmlHttp.onreadystatechange = pass_itno_defect_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);



}

function pass_itno_defect_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_code");
        opener.document.form1.itemd_hidden.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_description");
        opener.document.form1.itemd.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BRAND_NAME");
        opener.document.form1.txtbrand.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("PART_NO");
        opener.document.form1.txtpatt.value = XMLAddress1[0].childNodes[0].nodeValue;
        //	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dis");	
        //	opener.document.form1.discount.value = XMLAddress1[0].childNodes[0].nodeValue;


        self.close();
        opener.document.form1.Combo1.focus();



    }
}
function chk_opener()
{
    //alert("ok");
    //self.close();	
    //opener.document.form1.invno.value = document.bull.lon.value;
    opener.document.form1.invno.value = "123";
}




function tmp_crelimit()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_custom_data.php";
    url = url + "?Command=" + "tmp_crelimit";
    url = url + "&Com_rep1=" + document.getElementById('Com_rep1').value;
    url = url + "&txt_cuscode=" + document.getElementById('txt_cuscode').value;
    url = url + "&cmbbrand1=" + document.getElementById('cmbbrand1').value;
    url = url + "&txt_templimit=" + document.getElementById('txt_templimit').value;
    //alert(url);

    if (document.getElementById('check1').checked == true)
    {
        var mcheck = 1;
    } else {
        var mcheck = 0;
    }
    url = url + "&check1=" + mcheck;
    //alert(url);

    xmlHttp.onreadystatechange = result_tmp_crelimit;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function result_tmp_crelimit()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
    }
}

function subcus() {
 
    url = "new/home.php?url=cust_mast&c_code=" + document.getElementById('txt_cuscode').value;
    window.open(url);

}
