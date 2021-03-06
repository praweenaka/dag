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

function save() {
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "dealer_sch_data.php";
    url = url + "?Command=" + "save";
    url = url + "&tmpno=" + document.getElementById('tmp_no').value;
	url = url + "&rep=" + document.getElementById('sal_ex').value;
    xmlHttp.onreadystatechange = result_save;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function email() {
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "dealer_sch_data.php";
    url = url + "?Command=" + "email";
    url = url + "&tmpno=" + document.getElementById('tmp_no').value;
	url = url + "&rep=" + document.getElementById('sal_ex').value;
    xmlHttp.onreadystatechange = result_save;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}


function result_save() {

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
    }
}

function setRep() {
//    alert("setting rep");
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "dealer_rmk_data.php";
    url = url + "?Command=" + "setRep";
    url = url + "&rep=" + document.getElementById('sal_ex').value;
    xmlHttp.onreadystatechange = pass_setRep;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function pass_setRep()
{

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
//        alert(xmlHttp.responseText);
    }
}

function remarkno(id)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "dealer_sch_data.php";
    url = url + "?Command=" + "pass_rmk";
    url = url + "&id=" + id;

    xmlHttp.onreadystatechange = pass_remarkno;

    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}


function pass_remarkno()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        // alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.c_code.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
        opener.document.form1.c_name.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("outst");
        opener.document.form1.outst.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("retch");
        opener.document.form1.retch.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("remark");
        opener.document.form1.txt_remarks.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("loc");
        opener.document.form1.loc.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tgt");
        opener.document.form1.target.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ord");
        opener.document.form1.ord.value = XMLAddress1[0].childNodes[0].nodeValue;


        self.close();
    }
}

function add_tmp() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

     
        var url = "dealer_sch_data.php";
        url = url + "?Command=" + "add_tmp";
        url = url + "&c_code=" + document.getElementById('c_code').value;
        url = url + "&c_name=" + document.getElementById('c_name').value;
        url = url + "&inv_amo=" + document.getElementById('outst').value;
        url = url + "&out_amo=" + document.getElementById('retch').value;
	    url = url + "&tmpno=" + document.getElementById('tmp_no').value;
        xmlHttp.onreadystatechange = showarmyresultdel;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

     

}

function showarmyresultdel() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

       // XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = xmlHttp.responseText;

  ;
        document.getElementById('c_code').value = "";
        document.getElementById('c_name').value = "";
        document.getElementById('outst').value = "";
        document.getElementById('retch').value = "";
       
         
    }
}


function new_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

   
    document.getElementById('c_name').value = "";
    document.getElementById('c_code').value = "";

    document.getElementById('itemdetails').innerHTML = "";

    document.getElementById('outst').value = "";
    document.getElementById('retch').value = "";
   
	
	
	var url = "dealer_sch_data.php";
    url = url + "?Command=" + "new_inv";

    xmlHttp.onreadystatechange = assign_invno;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function assign_invno() {



    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") 
	{
 
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
        document.getElementById('tmp_no').value = XMLAddress1[0].childNodes[0].nodeValue;
    }

}
