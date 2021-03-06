// JavaScript Document
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


function keyset(key, e)
{

    if (e.keyCode == 13) {

        document.getElementById(key).focus();
    }
}

function chk_number()
{
    //alert("ok");
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_rep_data.php";
    url = url + "?Command=" + "pass_repno";
    url = url + "&repno=" + document.getElementById('txtcode').value;
    //url=url+"&stname="+stname;
    //alert(url);

    xmlHttp.onreadystatechange = passrepnoresult_ind;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function passrepnoresult_ind()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("repcode");
        document.getElementById('txtcode').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("repname");
        document.getElementById('txtname').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target");
        document.getElementById('txttottar').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("group");
        var group = XMLAddress1[0].childNodes[0].nodeValue;

        var objGroup = document.getElementById('cmb_group');
        var i = 0;
        //objGroup.options[i].selected=true;

        while (i < objGroup.length)
        {
            if (group == objGroup.options[i].value)
            {
                objGroup.options[i].selected = true;

            }
            i = i + 1;
        }
		

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cancel");
        var cancel = XMLAddress1[0].childNodes[0].nodeValue;
        if (cancel == '1') {
            document.getElementById('chk_active').checked = true;
        } else {
            document.getElementById('chk_active').checked = false;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table");
        document.getElementById('target').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table_s");
        document.getElementById('target_s').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        //self.close();
        //opener.document.form1.salesrep.focus();
    }
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

function update_rep_list(stname)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_rep_data.php";
    url = url + "?Command=" + "search_inv";

    if (document.getElementById('repno').value != "") {
        url = url + "&mstatus=repno";
    } else if (document.getElementById('repname').value != "") {
        url = url + "&mstatus=repname";
    }

    url = url + "&repno=" + document.getElementById('repno').value;
    url = url + "&repname=" + document.getElementById('repname').value;
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

function repno(repno, stname)
{


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_rep_data.php";
    url = url + "?Command=" + "pass_repno";
    url = url + "&repno=" + repno;
    url = url + "&stname=" + stname;
    //alert(url);

    xmlHttp.onreadystatechange = passrepnoresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}


function passrepnoresult()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("repcode");
        opener.document.form1.txtcode.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("repname");
        opener.document.form1.txtname.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target");
        opener.document.form1.txttottar.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("group");
        var group = XMLAddress1[0].childNodes[0].nodeValue;

		
        var objGroup = opener.document.form1.cmb_group;
        var i = 0;
        //objGroup.options[i].selected=true;

        while (i < objGroup.length)
        {
            if (group == objGroup.options[i].value)
            {
                objGroup.options[i].selected = true;

            }
            i = i + 1;
        }
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("group1");
        var group = XMLAddress1[0].childNodes[0].nodeValue;

		
        var objGroup = opener.document.form1.cmb_group1;
        var i = 0;
        //objGroup.options[i].selected=true;

        while (i < objGroup.length)
        {
            if (group == objGroup.options[i].value)
            {
                objGroup.options[i].selected = true;

            }
            i = i + 1;
        }
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("group2");
        var group = XMLAddress1[0].childNodes[0].nodeValue;

		
        var objGroup = opener.document.form1.cmb_group2;
        var i = 0;
        //objGroup.options[i].selected=true;

        while (i < objGroup.length)
        {
            if (group == objGroup.options[i].value)
            {
                objGroup.options[i].selected = true;

            }
            i = i + 1;
        }
		
		
		
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mok1");
        if (XMLAddress1[0].childNodes[0].nodeValue == "1") {


            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tdam1");
            opener.document.form1.tdam1.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tdam2");
            opener.document.form1.tdam2.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tdam3");
            opener.document.form1.tdam3.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tdamr1");
            opener.document.form1.tdamr1.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tdamr2");
            opener.document.form1.tdamr2.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tdamr3");
            opener.document.form1.tdamr3.value = XMLAddress1[0].childNodes[0].nodeValue;


            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tdisam1");
            opener.document.form1.tdisam1.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tdisam2");
            opener.document.form1.tdisam2.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tdisam3");
            opener.document.form1.tdisam3.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tdisar1");
            opener.document.form1.tdisar1.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tdisar2");
            opener.document.form1.tdisar2.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tdisar3");
            opener.document.form1.tdisar3.value = XMLAddress1[0].childNodes[0].nodeValue;

        }

 XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mok2");
        if (XMLAddress1[0].childNodes[0].nodeValue == "1") {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("B1");
        opener.document.form1.BT1.value = XMLAddress1[0].childNodes[0].nodeValue;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("B2");
        opener.document.form1.BT2.value = XMLAddress1[0].childNodes[0].nodeValue;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("B3");
        opener.document.form1.BT3.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BP1");
        opener.document.form1.BR1.value = XMLAddress1[0].childNodes[0].nodeValue;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BP2");
        opener.document.form1.BR2.value = XMLAddress1[0].childNodes[0].nodeValue;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("BP3");
        opener.document.form1.BR3.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("T1");
        opener.document.form1.TT1.value = XMLAddress1[0].childNodes[0].nodeValue;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("T2");
        opener.document.form1.TT2.value = XMLAddress1[0].childNodes[0].nodeValue;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("T3");
        opener.document.form1.TT3.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TP1");
        opener.document.form1.TR1.value = XMLAddress1[0].childNodes[0].nodeValue;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TP2");
        opener.document.form1.TR2.value = XMLAddress1[0].childNodes[0].nodeValue;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TP3");
        opener.document.form1.TR3.value = XMLAddress1[0].childNodes[0].nodeValue;
        }



        var objGroup = opener.document.form1.cmb_group;
        var i = 0;
        //objGroup.options[i].selected=true;

        while (i < objGroup.length)
        {
            if (group == objGroup.options[i].value)
            {
                objGroup.options[i].selected = true;

            }
            i = i + 1;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cancel");
        var cancel = XMLAddress1[0].childNodes[0].nodeValue;

        if (cancel == '1') {
            opener.document.form1.chk_active.checked = true;
        } else {
            opener.document.form1.chk_active.checked = false;
        }

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table");
        window.opener.document.getElementById('target').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table_s");
        window.opener.document.getElementById('target_s').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        self.close();
        //opener.document.form1.salesrep.focus();
    }
}

function showtarget(cuscode, name, target)
{

    document.getElementById('txt_cuscode').value = cuscode;
    document.getElementById('txt_cusname').value = name;
    document.getElementById('txtdetar').value = target;


}

function showtarget_s(cuscode, name, target)
{

    document.getElementById('txt_cuscode_s').value = cuscode;
    document.getElementById('txt_cusname_s').value = name;
    document.getElementById('txtdetar_s').value = target;


}

function savetarget()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_rep_data.php";
    url = url + "?Command=" + "savetarget";
    url = url + "&repno=" + document.getElementById('txtcode').value;
    url = url + "&cuscode=" + document.getElementById('txt_cuscode').value;
    url = url + "&name=" + document.getElementById('txt_cusname').value;
    url = url + "&target=" + document.getElementById('txtdetar').value;

    //alert(url);

    xmlHttp.onreadystatechange = savetarget_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}



function savetarget_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table");
        document.getElementById('target').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('txt_cuscode').value = "";
        document.getElementById('txt_cusname').value = "";
        document.getElementById('txtdetar').value = "";
    }
}

function savetarget_s()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_rep_data.php";
    url = url + "?Command=" + "savetarget_s";
    url = url + "&repno=" + document.getElementById('txtcode').value;
    url = url + "&cuscode=" + document.getElementById('txt_cuscode_s').value;
    url = url + "&name=" + document.getElementById('txt_cusname_s').value;
    url = url + "&target=" + document.getElementById('txtdetar_s').value;

    //alert(url);

    xmlHttp.onreadystatechange = savetarget_result_s;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function savetarget_result_s()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table");
        document.getElementById('target_s').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('txt_cuscode_s').value = "";
        document.getElementById('txt_cusname_s').value = "";
        document.getElementById('txtdetar_s').value = "";
    }
}

function deletetarget()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_rep_data.php";
    url = url + "?Command=" + "deletetarget";
    url = url + "&repno=" + document.getElementById('txtcode').value;
    url = url + "&cuscode=" + document.getElementById('txt_cuscode').value;
    //	url=url+"&name="+document.getElementById('txt_cusname').value;
    //	url=url+"&target="+document.getElementById('txtdetar').value;

    //alert(url);

    xmlHttp.onreadystatechange = deletetarget_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function deletetarget_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table");
        document.getElementById('target').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('txt_cuscode').value = "";
        document.getElementById('txt_cusname').value = "";
        document.getElementById('txtdetar').value = "";
    }
}

function deletetarget_s()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_rep_data.php";
    url = url + "?Command=" + "deletetarget_s";
    url = url + "&repno=" + document.getElementById('txtcode').value;
    url = url + "&cuscode=" + document.getElementById('txt_cuscode_s').value;
    //	url=url+"&name="+document.getElementById('txt_cusname').value;
    //	url=url+"&target="+document.getElementById('txtdetar').value;

    //alert(url);

    xmlHttp.onreadystatechange = deletetarget_result_s;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function deletetarget_result_s()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("target_table");
        document.getElementById('target_s').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('txt_cuscode_s').value = "";
        document.getElementById('txt_cusname_s').value = "";
        document.getElementById('txtdetar_s').value = "";
    }
}

function new_target()
{
    location.reload();

    document.getElementById('txtcode').focus();
}

function brand_target()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_rep_data.php";
    url = url + "?Command=" + "brand_target";
    url = url + "&cmbbrand=" + document.getElementById('cmbbrand').value;
    url = url + "&txtcode=" + document.getElementById('txtcode').value;

    xmlHttp.onreadystatechange = brand_target_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function brand_target_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        //alert(xmlHttp.responseText);
        document.getElementById('txttar').value = xmlHttp.responseText;
    }
}

function update_target()
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_rep_data.php";
    url = url + "?Command=" + "update_target";
    url = url + "&cmbbrand=" + document.getElementById('cmbbrand').value;
    url = url + "&txtcode=" + document.getElementById('txtcode').value;
    url = url + "&txttar=" + document.getElementById('txttar').value;

    xmlHttp.onreadystatechange = update_target_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function update_target_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        //document.getElementById('txttar').value=xmlHttp.responseText;
    }
}

function save_rep()
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "search_rep_data.php";
    url = url + "?Command=" + "save_rep";
    url = url + "&txtcode=" + document.getElementById('txtcode').value;
    url = url + "&txtname=" + document.getElementById('txtname').value;
    url = url + "&txttottar=" + document.getElementById('txttottar').value;
    url = url + "&cmb_group=" + document.getElementById('cmb_group').value;
	url = url + "&cmb_group1=" + document.getElementById('cmb_group1').value;
	url = url + "&cmb_group2=" + document.getElementById('cmb_group2').value;



    url = url + "&tdam1=" + document.getElementById('tdam1').value;
    url = url + "&tdam2=" + document.getElementById('tdam2').value;
    url = url + "&tdam3=" + document.getElementById('tdam3').value;
    url = url + "&tdamr1=" + document.getElementById('tdamr1').value;
    url = url + "&tdamr2=" + document.getElementById('tdamr2').value;
    url = url + "&tdamr3=" + document.getElementById('tdamr3').value;

    url = url + "&tdisam1=" + document.getElementById('tdisam1').value;
    url = url + "&tdisar1=" + document.getElementById('tdisar1').value;
    url = url + "&tdisam2=" + document.getElementById('tdisam2').value;
    url = url + "&tdisar2=" + document.getElementById('tdisar2').value;
    url = url + "&tdisam3=" + document.getElementById('tdisam3').value;
    url = url + "&tdisar3=" + document.getElementById('tdisar3').value;

    url = url + "&BT1=" + document.getElementById('BT1').value;
    url = url + "&BR1=" + document.getElementById('BR1').value;
    url = url + "&BT2=" + document.getElementById('BT2').value;
    url = url + "&BR2=" + document.getElementById('BR2').value;
    url = url + "&BT3=" + document.getElementById('BT3').value;
    url = url + "&BR3=" + document.getElementById('BR3').value;

    url = url + "&TT1=" + document.getElementById('TT1').value;
    url = url + "&TR1=" + document.getElementById('TR1').value;
    url = url + "&TT2=" + document.getElementById('TT2').value;
    url = url + "&TR2=" + document.getElementById('TR2').value;
    url = url + "&TT3=" + document.getElementById('TT3').value;
    url = url + "&TR3=" + document.getElementById('TR3').value;



    var act = 0;
    if (document.getElementById('chk_active').checked == true) {
        act = 1;
    } else {
        act = 0;
    }

    url = url + "&act=" + act;

    xmlHttp.onreadystatechange = save_rep_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function save_rep_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        //document.getElementById('txttar').value=xmlHttp.responseText;
    }
}


function deleterep()
{
    var msg = confirm("Are you sure to DELETE ? ");
    if (msg == true) {
        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }


        var url = "search_rep_data.php";
        url = url + "?Command=" + "deleterep";
        url = url + "&txtcode=" + document.getElementById('txtcode').value;
        xmlHttp.onreadystatechange = deleterep_result;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}

function deleterep_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        setTimeout("location.reload(true);", 500);
        //document.getElementById('txttar').value=xmlHttp.responseText;
    }
}