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

function getrep()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			var url="rep_profile_data.php";			
			url=url+"?Command="+"get_rep";
			url=url+"&rep="+  document.getElementById("rep").value;
			
			 
					
			xmlHttp.onreadystatechange=showinvresult;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
	
}

function showinvresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tb");
		document.getElementById('filt_table').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Name");
		document.getElementById('name').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
 
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Join_Date");
		document.getElementById('join_dt').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("remark");
		document.getElementById('remark').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("pic");
		document.getElementById('pic').src = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		getrep1();
		
		
		
	}
}



function gin(invno)
{   
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
			
			
			
				var url="gin_m_data.php";	
				url=url+"?Command="+"gin";
				url=url+"&invno="+invno;
				//alert(url);
				xmlHttp.onreadystatechange=passginresult;
				xmlHttp.open("GET",url,true);
				xmlHttp.send(null);
				
			
			
			
			
			
}

function passginresult()
{
	var XMLAddress1;
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		 		
	 
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("to_dep");
		opener.document.form1.to_dep.value = XMLAddress1[0].childNodes[0].nodeValue;
		
	 
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmp_no");
		opener.document.form1.tmpno.value = XMLAddress1[0].childNodes[0].nodeValue;
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
		window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
		self.close();
	}
}

function cancel_inv() {
    

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    document.getElementById('msg_box').innerHTML = "";
    

    var url = "gin_m_data.php";
    url = url + "?Command=" + "del_inv";
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

