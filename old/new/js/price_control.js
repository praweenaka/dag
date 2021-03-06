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

 

function save_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
	document.getElementById('msg_box').innerHTML = "";

    var url = "price_control_data.php";
    var params = "Command=" + "save_item";
  
	var count = document.getElementById('item_count').value;
	params = params + "&count=" + count;
    var i = 1;
	while (count > i) {
		
		var stk_no = "stk_no" + i;
        var price = "price" + i;
		 
				
		params = params + '&' + stk_no + '=' + document.getElementById(stk_no).value;
        params = params + '&' + price + '=' + document.getElementById(price).value;
		
		i = i +1;	
    }
    
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

function print_inv() {
	
	var url = "price_list.php";
    url = url + "?brand=" + document.getElementById('brand').value;
  
    window.open(url,'_blank');
	
}

function new_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    

    document.getElementById('item_count').value = "";

     

    document.getElementById('itemdetails').innerHTML = "";
    document.getElementById('msg_box').innerHTML = "";
 

}
 




function del_item(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "gin_m_data.php";
    url = url + "?Command=" + "del_item";
    url = url + "&code=" + cdate;
    url = url + "&invno=" + document.getElementById('invno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;

    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

 
 



function load_items()
{   
	
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			
			
			
			
				var url="price_control_data.php";	
				url=url+"?Command="+"load_items";
				url=url+"&brand="+document.getElementById('brand').value;
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
		 		
	  
 
		
		
		XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
	    document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
		
	 XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("itm_count");
	    document.getElementById('item_count').value = XMLAddress1[0].childNodes[0].nodeValue;
	}
}

