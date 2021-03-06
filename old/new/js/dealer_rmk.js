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
    var url = "dealer_rmk_data.php";
    url = url + "?Command=" + "save";
   
    url = url + "&rmk=" + document.getElementById('txt_remarks').value;

    url = url + "&sal_ex=" + document.getElementById('sal_ex').value;


    url = url + "&stime=" + document.getElementById('stime').value;
    url = url + "&ftime=" + document.getElementById('ftime').value;
    url = url + "&invdate=" + document.getElementById('invdate').value;


    url = url + "&loc=" + document.getElementById('loc').value;
    url = url + "&target=" + document.getElementById('target').value;
	url = url + "&ord=" + document.getElementById('ord').value;
    url = url + "&outst=" + document.getElementById('outst').value;
    url = url + "&retch=" + document.getElementById('retch').value;
    url = url + "&outstCltd=" + document.getElementById('outstCltd').value;
    url = url + "&retchStld=" + document.getElementById('retchStld').value;
    
	  url = url + "&mstart=" + document.getElementById('mstart').value;
    url = url + "&mfini=" + document.getElementById('mfini').value;
    

    xmlHttp.onreadystatechange = result_save;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function load(cdata,cdata1,cdata2,cdata3,cdata4,cdata5,cdata6,cdata7,cdata8,cdata9,cdata10,cdata11,cdata12) {
	
	document.getElementById('invdate').value = cdata;
	document.getElementById('stime').value = cdata1;
	document.getElementById('ftime').value = cdata2;
	document.getElementById('loc').value = cdata4;
	document.getElementById('txt_remarks').value = cdata3;
	 
    document.getElementById('target').value=cdata5;
	document.getElementById('ord').value=cdata6;
    document.getElementById('outst').value=cdata7;
	document.getElementById('outstCltd').value=cdata8;
    document.getElementById('retch').value=cdata9;
    document.getElementById('retchStld').value=cdata10;
	
	document.getElementById('mstart').value=cdata11;
	document.getElementById('mfini').value=cdata12;
	
	
	
}
function result_save() {

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
		setRep();
    }
}


function del_item(cdata) {
	
 $('#myModal_c').modal('show');
	    document.getElementById('txtref').value=cdata;
	
	
}


function cancel_inv() {
	$('#myModal_c').modal('hide');
	
	xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "dealer_rmk_data.php";
    url = url + "?Command=" + "dele";
   
    url = url + "&ref=" + document.getElementById('txtref').value;
	
	xmlHttp.onreadystatechange = result_cancel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}	

function result_cancel() {

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
       setRep();
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

 document.getElementById('itemdetails').innerHTML =xmlHttp.responseText ;
		
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
    var url = "dealer_rmk_data.php";
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