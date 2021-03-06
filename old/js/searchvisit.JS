//BROWSER CONNECTION

function GetXmlHttpObject()
	{
		var xmlHttp=null;
		try
		 {
			 // Firefox, Opera 8.0+, Safari
			 xmlHttp=new XMLHttpRequest();
		 }
		catch (e)
		 {
			 // Internet Explorer
			 try
			  {
				  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
			  }
			 catch (e)
			  {
				 xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
		 }
		return xmlHttp;
	}
	
	
	
	function filter_nic()
	{//Open outer if conditon
		
		
		/////////////////////////////////////////////// Filter NIC //////////////////////////////////////////////
		if(document.getElementById('nic').value=="")
		{
			document.getElementById("nic").focus();
			document.getElementById("error_nic").innerHTML="Please Enter NIC Number";
		}
		else
		{
			document.getElementById("error_nic").innerHTML="";
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 					
			var url="searchvisit.php";	
			url=url+"?vist_nicnumber="+document.getElementById('nic').value;
			//window.open(url,'name','height=150,width=700');
				window.open(url,'Visit Details','height=130,width=700,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=no');
		
		}
		//////////////////////////////////////////////// END FILTER NIC //////////////////////////////////////////////////////////
	}//close outer if condition


function Test(id)
{
	alert(id);
}