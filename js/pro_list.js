 
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





function add_spare() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    // var row = subNode.parentNode;
    // var cell_0 = row.cells[0].innerHTML;
    // var cell_1 = row.cells[1].innerHTML;
    document.getElementById('msg_box').innerHTML =""; 
    if (document.getElementById('spareitem').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>SELCT SPARE ITEM</span></div>";
        return false;
    }
    if (document.getElementById('qty').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Enter QTY</span></div>";
        return false;
    }
    
    var url = "pro_list_data.php";                                 
    var params ="Command="+"add_spare";
    params = params + "&Command1=add_tmp";   
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value;
    params = params + "&spareitem=" + document.getElementById('spareitem').value;
    params = params + "&price=" + document.getElementById('price').value;
    params = params + "&qty=" + document.getElementById('qty').value;
    params = params + "&total=" + document.getElementById('total').value; 

    
    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_search;

    xmlHttp.send(params);  
    document.getElementById('msg_box').innerHTML =""; 
}

function re_search()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

       XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
       document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;  
        
        document.getElementById('total').value = ""; 
        document.getElementById('spareitem').value = ""; 
        document.getElementById('price').value = ""; 
         document.getElementById('qty').value = "";
   }
}


function add_spareview() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }



    var url = "pro_list_data.php";                                 
    var params ="Command="+"add_spare";    
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value;
    params = params + "&spareitem=" + document.getElementById('spareitem').value;
    params = params + "&price=" + document.getElementById('price').value;
    params = params + "&qty=" + document.getElementById('qty').value;
    params = params + "&total=" + document.getElementById('total').value; 


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_search;

    xmlHttp.send(params);  

}


function del_item(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    

    var url = "pro_list_data.php";                                 
    var params ="Command="+"add_spare";
    params = params + "&Command1=del_item";   
    params = params + "&id=" + cdate; 
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value;

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_search;

    xmlHttp.send(params);  

}


function add_workers() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    
    document.getElementById('msg_box').innerHTML =""; 
    if (document.getElementById('workers').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>SELCT WORKERS</span></div>";
        return false;
    }
    
    
    var url = "pro_list_data.php";                                 
    var params ="Command="+"add_workers"; 
    params = params + "&Command1=add_tmp";      
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value;
    params = params + "&hours=" + document.getElementById('hours').value;
    params = params + "&workers=" + document.getElementById('workers').value; 


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_work;

    xmlHttp.send(params);  
document.getElementById('msg_box').innerHTML =""; 
}

function re_work()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

     XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table"); 
     document.getElementById('itemdetails1').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;  
     
     document.getElementById('workers').value = ""; 
 }
}

function del_itemworkers(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "pro_list_data.php";                                 
    var params ="Command="+"add_workers";
    params = params + "&Command1=del_item";   
    params = params + "&id=" + cdate; 
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value;

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_work;

    xmlHttp.send(params);  

}

function add_workersview() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "pro_list_data.php";                                 
    var params ="Command="+"add_workers";      
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value;
    params = params + "&hours=" + document.getElementById('hours').value;
    params = params + "&workers=" + document.getElementById('workers').value; 


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_work;

    xmlHttp.send(params);  

}


function add_builders() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    
     document.getElementById('msg_box').innerHTML =""; 
    if (document.getElementById('builders').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>SELCT BUILDERS</span></div>";
        return false;
    }
    var url = "pro_list_data.php";                                 
    var params ="Command="+"add_builders"; 
    params = params + "&Command1=add_tmp";      
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value;
    params = params + "&hours1=" + document.getElementById('hours1').value;
    params = params + "&builders=" + document.getElementById('builders').value; 


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_builder;

    xmlHttp.send(params);  
     document.getElementById('msg_box').innerHTML =""; 
}

function re_builder()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

     XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table"); 
     document.getElementById('itemdetails2').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;  
     
     document.getElementById('builders').value = ""; 
 }
}

function del_itembuilders(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "pro_list_data.php";                                 
    var params ="Command="+"add_builders";
    params = params + "&Command1=del_item";   
    params = params + "&id=" + cdate; 
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value;

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_builder;

    xmlHttp.send(params);  

}

function add_buildersview() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "pro_list_data.php";                                 
    var params ="Command="+"add_builders";      
    params = params + "&refno=" +document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value;
    params = params + "&hours1=" + document.getElementById('hours1').value;
    params = params + "&builders=" + document.getElementById('builders').value; 


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_builder;

    xmlHttp.send(params);  

}

function sendfinish(){
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "pro_list_data.php";                                 
    var params ="Command="+"sendfinish";      
    params = params + "&refno=" + document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value;
    params = params + "&warranty=" + document.getElementById('warranty').value;
    params = params + "&design=" + document.getElementById('design').value; 
    params = params + "&cusname=" + document.getElementById('cusname').value; 
    params = params + "&size=" + document.getElementById('size').value; 
    params = params + "&cascost=" + document.getElementById('cascost').value; 

 
    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_finish;

    xmlHttp.send(params);  
}

function sendonhand(){
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "pro_list_data.php";                                 
    var params ="Command="+"sendonhand";      
    params = params + "&refno=" + document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value; 


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_finish;

    xmlHttp.send(params);  
}

function sendreject(){
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "pro_list_data.php";                                 
    var params ="Command="+"sendreject";      
    params = params + "&refno=" + document.getElementById('refno').value;
    params = params + "&serialno=" + document.getElementById('serialno').value; 


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_finish;

    xmlHttp.send(params);  
}

function re_finish()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

       alert(xmlHttp.responseText);
       setTimeout("location.reload(true);", 500);
   }
}


function totqty()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'pro_list_data.php';
    var params = 'Command=' + 'totqty'; 
    params = params + '&price=' + document.getElementById('price').value; 
    params = params + '&qty=' + document.getElementById('qty').value;   
    
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange =re_totqty;

    xmlHttp.send(params);



}

function re_totqty()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("toot"); 
        document.getElementById('total').value = XMLAddress1[0].childNodes[0].nodeValue;


    }
}


function spareprice()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'pro_list_data.php';
    var params = 'Command=' + 'spareprice'; 
    params = params + '&spareitem=' + document.getElementById('spareitem').value;  
    
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange =re_spareprice;

    xmlHttp.send(params);



}

function re_spareprice()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("price"); 
        document.getElementById('price').value = XMLAddress1[0].childNodes[0].nodeValue;


    }
}