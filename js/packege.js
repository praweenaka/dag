 
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



function getcode(cdata,cdata1,cdata2) {


    document.getElementById('packegename').value = cdata1; 
    document.getElementById('packegecode').value = cdata;
    window.scrollTo(0, 0);

     document.getElementById('msg_box').innerHTML = "";
    add_summeryview();

}

function add_spare() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    
     if (document.getElementById('packegecode').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Packege</span></div>";
        return false;
    }
    if (document.getElementById('spareitem').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Item</span></div>";
        return false;
    }
    if (document.getElementById('cost').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select  Item</span></div>";
        return false;
    }
     if (document.getElementById('qty').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Enter Qty</span></div>";
        return false;
    }
    
    if (document.getElementById('total').value == "0") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Enter Qty</span></div>";
        return false;
    }
        
    var url = "packege_data.php";                                 
    var params ="Command="+"add_spare"; 
    params = params + "&Command1=add_tmp";      
    params = params + "&packegecode=" +document.getElementById('packegecode').value;
    params = params + "&spareitem=" + document.getElementById('spareitem').value;
    params = params + "&cost=" + document.getElementById('cost').value;
    params = params + "&qty=" + document.getElementById('qty').value; 
    params = params + "&total=" + document.getElementById('total').value; 

    document.getElementById('msg_box').innerHTML = "";
    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_spare;

    xmlHttp.send(params);  
     
}

function re_spare()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

       XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table"); 

       document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;  

       document.getElementById('cost').value="";
       document.getElementById('qty').value="";
       document.getElementById('total').value="";


       add_expenseview();
   }
}


function add_spareview() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }



    var url = "packege_data.php";                                 
    var params ="Command="+"add_spare";    
    params = params + "&packegecode=" +document.getElementById('packegecode').value;


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_spare;

    xmlHttp.send(params);  

}

function del_spare(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "packege_data.php";                                 
    var params ="Command="+"add_spare";
    params = params + "&Command1=del_item";   
    params = params + "&id=" + cdate; 
    params = params + "&packegecode=" +document.getElementById('packegecode').value;

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_spare;

    xmlHttp.send(params);  

}



function add_expense() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    if (document.getElementById('packegecode').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Packege</span></div>";
        return false;
    }
    if (document.getElementById('name').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Item</span></div>";
        return false;
    }
    if (document.getElementById('cost1').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select  Item</span></div>";
        return false;
    }
      
    
    var url = "packege_data.php";                                 
    var params ="Command="+"add_expense"; 
    params = params + "&Command1=add_tmp";      
    params = params + "&packegecode=" +document.getElementById('packegecode').value;
    params = params + "&name=" + document.getElementById('name').value;
    params = params + "&cost=" + document.getElementById('cost1').value; 

    document.getElementById('msg_box').innerHTML = "";
    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_expense;

    xmlHttp.send(params);  

}

function re_expense()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

       XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table"); 
       document.getElementById('itemdetails1').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;  

       document.getElementById('cost1').value=""; 
        
        add_summeryview();
   }
}

function add_expenseview() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }



    var url = "packege_data.php";                                 
    var params ="Command="+"add_expense";    
    params = params + "&packegecode=" +document.getElementById('packegecode').value;


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_expense;

    xmlHttp.send(params);  

}

function del_expense(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "packege_data.php";                                 
    var params ="Command="+"add_expense";
    params = params + "&Command1=del_item";   
    params = params + "&id=" + cdate; 
    params = params + "&packegecode=" +document.getElementById('packegecode').value;

    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_expense;

    xmlHttp.send(params);  

}


function add_summeryview() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }



    var url = "packege_data.php";                                 
    var params ="Command="+"add_summeryview";    
    params = params + "&packegecode=" +document.getElementById('packegecode').value;


    xmlHttp.open("POST", url, true);

    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange=re_summery;

    xmlHttp.send(params);  

}

function re_summery()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("spare"); 
        document.getElementById('spcost').value = XMLAddress1[0].childNodes[0].nodeValue;
        
         XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cost"); 
        document.getElementById('tot_cost').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("expense"); 
        document.getElementById('fix_expen').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("wmargin"); 
        document.getElementById('w_margin').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("wprice"); 
        document.getElementById('wprice').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rmargin"); 
        document.getElementById('r_margin').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rprice"); 
        document.getElementById('rprice').value = XMLAddress1[0].childNodes[0].nodeValue;

        add_spareview();

    }
}


function wpricecal()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'packege_data.php';
    var params = 'Command=' + 'wpricecal'; 
    params = params + '&w_margin=' + document.getElementById('w_margin').value; 
    params = params + '&spcost=' + document.getElementById('spcost').value; 
    params = params + '&fix_expen=' + document.getElementById('fix_expen').value;   

    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange =re_wpricecal;

    xmlHttp.send(params);



}

function re_wpricecal()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("toot"); 
        document.getElementById('wprice').value = XMLAddress1[0].childNodes[0].nodeValue;


    }
}

function rpricecal()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'packege_data.php';
    var params = 'Command=' + 'rpricecal'; 
    params = params + '&r_margin=' + document.getElementById('r_margin').value; 
    params = params + '&spcost=' + document.getElementById('spcost').value; 
    params = params + '&fix_expen=' + document.getElementById('fix_expen').value;   
    
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange =re_rpricecal;

    xmlHttp.send(params);



}

function re_rpricecal()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("toot"); 
        document.getElementById('rprice').value = XMLAddress1[0].childNodes[0].nodeValue;


    }
}

function updatepackege()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    
    if (document.getElementById('packegecode').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Packege</span></div>";
        return false;
    }

    var url = 'packege_data.php';
    var params = 'Command=' + 'updatepackege';  
    params = params + '&packegecode=' + document.getElementById('packegecode').value; 
    params = params + '&spcost=' + document.getElementById('spcost').value; 
    params = params + '&fix_expen=' + document.getElementById('fix_expen').value;   
    params = params + '&w_margin=' + document.getElementById('w_margin').value;   
    params = params + '&wprice=' + document.getElementById('wprice').value;   
    params = params + '&r_margin=' + document.getElementById('r_margin').value;   
    params = params + '&rprice=' + document.getElementById('rprice').value;  
    params = params + '&tot_cost=' + document.getElementById('tot_cost').value;  
    
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange =re_updatepackege;

    xmlHttp.send(params);



}

function re_updatepackege()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);  
        location.reload();
    }
}


function sparecal()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'packege_data.php';
    var params = 'Command=' + 'sparecal'; 
    params = params + '&qty=' + document.getElementById('qty').value; 
    params = params + '&cost=' + document.getElementById('cost').value;   
    
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange =re_sparecal;

    xmlHttp.send(params);



}

function re_sparecal()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("toot"); 
        document.getElementById('total').value = XMLAddress1[0].childNodes[0].nodeValue;


    }
}

function expensecost()
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = 'packege_data.php';
    var params = 'Command=' + 'expensecost'; 
    params = params + '&name=' + document.getElementById('name').value;  
    
    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange =re_expensecost;

    xmlHttp.send(params);



}

function re_expensecost()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("price"); 
        document.getElementById('cost1').value = XMLAddress1[0].childNodes[0].nodeValue;


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

    var url = 'packege_data.php';
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
        document.getElementById('cost').value = XMLAddress1[0].childNodes[0].nodeValue;


    }
}