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
    var url = "dealer_shr_data.php";
    url = url + "?Command=" + "save";
    url = url + "&invdate=" + document.getElementById('invdate').value;
    url = url + "&c_code=" + document.getElementById('c_code').value;
    url = url + "&c_name=" + document.getElementById('c_name').value;
    url = url + "&rmk=" + document.getElementById('txt_remarks').value;

    url = url + "&amt=" + document.getElementById('amt').value;
    url = url + "&ref=" + document.getElementById('ref').value;
	url = url + "&tmpno=" + document.getElementById('tmp_no').value;

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

function cancell() {
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "dealer_shr_data.php";
    url = url + "?Command=" + "delete";
	url = url + "&tmpno=" + document.getElementById('tmp_no').value;

    xmlHttp.onreadystatechange = result_del;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}




function result_del() {

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
		location.reload();
    }
}



function add_tmp() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

     
        var url = "dealer_shr_data.php";
        url = url + "?Command=" + "add_tmp";
        url = url + "&ref_no=" + document.getElementById('ref').value;
        url = url + "&c_code=" + document.getElementById('c_code').value;
        url = url + "&c_name=" + document.getElementById('c_name').value;
        url = url + "&inv_amo=" + document.getElementById('inv_amount').value;
        url = url + "&out_amo=" + document.getElementById('out_amount').value;
		url = url + "&amo=" + document.getElementById('amt').value;
		
        url = url + "&tmpno=" + document.getElementById('tmp_no').value;

		
        xmlHttp.onreadystatechange = showarmyresultdel;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

     

}
function del_item(cdata) {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

     
        var url = "dealer_shr_data.php";
        url = url + "?Command=" + "del_item";
        url = url + "&code=" + cdata;
 
		
        url = url + "&tmpno=" + document.getElementById('tmp_no').value;

		
        xmlHttp.onreadystatechange = showarmyresultdel;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

     

}


function pass_com(cdata) {



try {


        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }

        var url = "dealer_shr_data.php";
        url = url + "?Command=" + "pass_rec";
        url = url + "&refno=" + cdata;

        xmlHttp.onreadystatechange = pass_rec_result;

        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    } catch (err) {
        alert(err.message);
    }
}	



function pass_rec_result() {
	
	var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tb");
        window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
        
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dt");
        window.opener.document.getElementById('invdate').value = XMLAddress1[0].childNodes[0].nodeValue;
        
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("remrk");
        window.opener.document.getElementById('txt_remarks').value = XMLAddress1[0].childNodes[0].nodeValue;
        		

				  
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
        window.opener.document.getElementById('tmp_no').value = XMLAddress1[0].childNodes[0].nodeValue;
        	
				
			 
				
		self.close();
	}
	
	
	
	
}	



function showarmyresultdel() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

       // XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = xmlHttp.responseText;

 
        document.getElementById('ref').value = "";
        document.getElementById('c_code').value = "";
        document.getElementById('c_name').value = "";
        document.getElementById('inv_amount').value = "";
        document.getElementById('out_amount').value = "";
        document.getElementById('amt').value = "";
         
    }
}


function new_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    document.getElementById('ref').value = "";
    document.getElementById('c_name').value = "";
    document.getElementById('c_code').value = "";

    document.getElementById('itemdetails').innerHTML = "";

    document.getElementById('inv_amount').value = "";
    document.getElementById('out_amount').value = "";
    document.getElementById('amt').value = "";
    document.getElementById('txt_remarks').value = "";
	
	
	
	var url = "dealer_shr_data.php";
    url = url + "?Command=" + "new_inv";

    xmlHttp.onreadystatechange = assign_invno;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function assign_invno() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
        document.getElementById('tmp_no').value = XMLAddress1[0].childNodes[0].nodeValue;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dt");
        document.getElementById('invdate').value = XMLAddress1[0].childNodes[0].nodeValue;
    }
}




