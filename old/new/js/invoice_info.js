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
    var url = "invoice_inf_data.php";
    url = url + "?Command=" + "save";
    url = url + "&c_code=" + document.getElementById('c_code').value;
    url = url + "&c_name=" + document.getElementById('c_name').value;
    url = url + "&rmk=" + escape(document.getElementById('txt_remarks').value);
    url = url + "&status=" + document.getElementById('comboStatus').value;

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

function custno(custno, stname)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "invoice_inf_data.php";
    url = url + "?custno=" + custno;
	url = url + "&stname=" + stname;
    if (stname == "dlr_shr") {
        url = url + "&Command=" + "pass_quot_smp";
        xmlHttp.onreadystatechange = passcusresult_quot_smp;
	} else {
        url = url + "&Command=" + "pass_quot";
        xmlHttp.onreadystatechange = passcusresult_quot;
    }



    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}


function passcusresult_quot()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.c_code.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
        opener.document.form1.c_name.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sdate");
        opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("remark");
        opener.document.form1.txt_remarks.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("status");
        var combo = opener.document.getElementById("comboStatus");

        var item = XMLAddress1[0].childNodes[0].nodeValue;
        var i = 0;
        while (i < combo.length)
        {
            if (item == combo.options[i].value)
            {
                combo.options[i].selected = true;

            }
            i = i + 1;
        }
		

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tb");
        window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;		

        self.close();
    }
}

function passcusresult_quot_smp()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
		
         	XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stat");
			if (XMLAddress1[0].childNodes[0].nodeValue==0) {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        opener.document.form1.ref.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customername");
        opener.document.form1.c_name.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("str_customercode");
        opener.document.form1.c_code.value = XMLAddress1[0].childNodes[0].nodeValue;

		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stname");
        if (XMLAddress1[0].childNodes[0].nodeValue=="dlr_shr") {
			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stat");
			if (XMLAddress1[0].childNodes[0].nodeValue==0) {

		
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("amo");
			opener.document.form1.amt.value = XMLAddress1[0].childNodes[0].nodeValue;

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("inv_amount");
			opener.document.form1.inv_amount.value = XMLAddress1[0].childNodes[0].nodeValue;

			
			XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("out_amount");
			opener.document.form1.out_amount.value = XMLAddress1[0].childNodes[0].nodeValue;

			opener.document.form1.amt.focus();	
			
			
			
		}	
		
        
		}
		self.close();
		} else {
					
				alert('Customer Commision Paid');	
			}
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


    var url = "invoice_inf_data.php";
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