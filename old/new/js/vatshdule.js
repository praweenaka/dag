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
 

function view_dett()
{

    var url = "report_vatshdule.php";
    url = url + "?dtfrom=" + document.getElementById('dtfrom').value;
    url = url + "&dtto=" + document.getElementById('dtto').value;    
	
	if (document.getElementById('sh1').checked == true) {
	url = url + "&shtype=sh1"; 
	} else {
	url = url + "&shtype=sh4"; 	
	}
	
    url = url + "&rtype=detail";
    window.open(url, '_blank');

}

function view_summ()
{

    var url = "report_vatshdule.php";
    url = url + "?dtfrom=" + document.getElementById('dtfrom').value;
    url = url + "&dtto=" + document.getElementById('dtto').value;
	
	if (document.getElementById('sh1').checked == true) {
	url = url + "&shtype=sh1"; 
	} else {
	url = url + "&shtype=sh4"; 	
	}
    url = url + "&rtype=summ";
    window.open(url, '_blank');

}

 

