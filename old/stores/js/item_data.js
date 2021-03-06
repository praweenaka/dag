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

function keyset(key, e)
{	

   if(e.keyCode==13){
	 
	document.getElementById(key).focus();
   }
}

function keyset_chng(key, e)
{	

 
	 
	document.getElementById(key).focus();
 
}


function clear_item()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
			
	document.getElementById('txtSTK_NO').value="";
	document.getElementById('txtDESCRIPTION').value="";
	document.getElementById('txtBRAND_NAME').value="";
	document.getElementById('txtmodel').value="";
	document.getElementById('txtGEN_NO').value="";
	document.getElementById('txtPART_NO').value="";
	
	document.getElementById('txtREFNO2').value="";
	document.getElementById('txtREFNO2').value="";
	document.getElementById('txtREFNO3').value="";
	
	document.getElementById('Com_group1').value="";
	document.getElementById('Com_group2').value="";
	document.getElementById('Com_group3').value="";
	document.getElementById('Com_group4').value="";
	
	document.getElementById('txtLOCATE_1').value="";
	document.getElementById('txtLOCATE_2').value="";
	document.getElementById('txtLOCATE_3').value="";
	document.getElementById('txtLOCATE_4').value="";
	
	
	document.getElementById('txtCOST').value="";
	document.getElementById('txtMARGIN').value="";
	document.getElementById('txtSELLING').value="";
	document.getElementById('TXTSELLING_DISPLAY').value="";
	document.getElementById('txtweight').value="";
	document.getElementById('txtcountry').value="";
	
	document.getElementById('txtUNIT').value="";
	document.getElementById('txtSIZE').value="";
	document.getElementById('txtRE_O_LEVEL').value="";
	document.getElementById('txtRE_O_qty').value="";
	document.getElementById('txttype').value="";
	
	document.getElementById('txtpendingord').value="";
	document.getElementById('txtdelivered').value="";
	document.getElementById('cmbcat').value="";
	document.getElementById('cmbtype').value="";
	
	//document.getElementById('txtcus_ord').value="";
	//alert("ok");
	document.getElementById('txtdelivered').value="";
    
}

function new_item()
{   
	
			
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 		
			
			
			clear_item();
			
			//document.getElementById('invdate').value=Date();
			
			var url="item_data.php";			
			url=url+"?Command="+"new_item";
			//alert(url);
			xmlHttp.onreadystatechange=assign_invno1;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
}

function assign_invno1(){
	//alert("okkkk");
	//alert(xmlHttp.responseText);
	
	document.getElementById('txtSTK_NO').value=xmlHttp.responseText;	
	document.getElementById('txtDESCRIPTION').focus();
}

var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}

/*
function chk_save()
{
	NewWindow('autho.php?stname=item_mast','mywin','500','300','yes','center');
	
	
	save_item();
}
*/
function save_item()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
	/*	if (document.getElementById('autho').value=="1"){
		alert("okkkk");	
	} else {
		alert("nooo");		
	}
	alert("ppp");*/
			
	var url="item_data.php";	
	
	url=url+"?Command="+"item_data_save";
	//$_FILES["image"]["name"][$key] ;
	
	url=url+"&txtSTK_NO="+document.getElementById('txtSTK_NO').value;
	url=url+"&txtDESCRIPTION="+document.getElementById('txtDESCRIPTION').value;
	url=url+"&txtBRAND_NAME="+document.getElementById('txtBRAND_NAME').value;
	url=url+"&txtGEN_NO="+document.getElementById('txtGEN_NO').value;
	url=url+"&txtPART_NO="+document.getElementById('txtPART_NO').value;
	url=url+"&txtCOST="+document.getElementById('txtCOST').value;
	
	//url=url+"&txtDISCOUNT="+document.getElementById('txtDISCOUNT').value;
	url=url+"&txtLOCATE_1="+document.getElementById('txtLOCATE_1').value;
	url=url+"&txtLOCATE_2="+document.getElementById('txtLOCATE_2').value;
	url=url+"&txtLOCATE_3="+document.getElementById('txtLOCATE_3').value;
	url=url+"&txtLOCATE_4="+document.getElementById('txtLOCATE_4').value;
	
	
	
	url=url+"&cmbcat="+document.getElementById('cmbcat').value;
	url=url+"&cmbtype="+document.getElementById('cmbtype').value;
	url=url+"&txtMARGIN="+document.getElementById('txtMARGIN').value;
	url=url+"&txtSELLING="+document.getElementById('txtSELLING').value;
	url=url+"&TXTSELLING_DISPLAY="+document.getElementById('TXTSELLING_DISPLAY').value;
	
	url=url+"&txtmodel="+document.getElementById('txtmodel').value;
	url=url+"&txtPART_NO="+document.getElementById('txtPART_NO').value;
	url=url+"&txtUNIT="+document.getElementById('txtUNIT').value;
	url=url+"&txtSIZE="+document.getElementById('txtSIZE').value;
	
	url=url+"&txtRE_O_LEVEL="+document.getElementById('txtRE_O_LEVEL').value;
	url=url+"&txtRE_O_qty="+document.getElementById('txtRE_O_qty').value;
	
	url=url+"&Com_group1="+document.getElementById('Com_group1').value;
	url=url+"&Com_group2="+document.getElementById('Com_group2').value;
	url=url+"&Com_group3="+document.getElementById('Com_group3').value;
	url=url+"&Com_group4="+document.getElementById('Com_group4').value;

	url=url+"&txtSTK_NO="+document.getElementById('txtSTK_NO').value;
	url=url+"&txtweight="+document.getElementById('txtweight').value;
	url=url+"&txtcountry="+document.getElementById('txtcountry').value;
	//url=url+"&txtcus_ord="+document.getElementById('txtcus_ord').value;
	
	url=url+"&txtdelivered="+document.getElementById('txtdelivered').value;
   
	xmlHttp.onreadystatechange=item_save_results;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function item_save_results()
{
	var XMLAddress1;
	//alert(xmlHttp.responseText);
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
						
		//	document.getElementById("message").innerHTML=xmlHttp.responseText;
		//	setTimeout("location.reload(true);",1000);
			alert("Successfully Saved");
			
			clear_item();
		}
}

function delete_item()
{
	
  var msg=confirm("Are you sure to DELETE ? ");
  if (msg==true){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="item_data.php";	
	
	url=url+"?Command="+"delete_item";
	//$_FILES["image"]["name"][$key] ;
	
	url=url+"&txtSTK_NO="+document.getElementById('txtSTK_NO').value;
	xmlHttp.onreadystatechange=item_delete_results;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
 
  }
}

function chk_number()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="item_data.php";	
	
	url=url+"?Command="+"chk_number";
	//$_FILES["image"]["name"][$key] ;
	
	url=url+"&txtSTK_NO="+document.getElementById('txtSTK_NO').value;
	//alert(url);
	xmlHttp.onreadystatechange=chk_number_results;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function chk_number_results()
{
	var XMLAddress1;
	//alert(xmlHttp.responseText);
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
						
		//	document.getElementById("message").innerHTML=xmlHttp.responseText;
		//	setTimeout("location.reload(true);",1000);
			if (xmlHttp.responseText=="included"){
				alert("Already Included Stock No ! ");
				location.reload(true);
			}
			
			
		}
}

function item_delete_results()
{
	var XMLAddress1;
	//alert(xmlHttp.responseText);
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
						
		//	document.getElementById("message").innerHTML=xmlHttp.responseText;
		//	setTimeout("location.reload(true);",1000);
			alert("Successfully Deleted");
			
			clear_item();
		}
}

function stores_update()
{
		
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 		
			
	var url="item_data.php";	
	
	xmlHttp.onreadystatechange=stores_update_results;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function stores_update_results()
{
	var XMLAddress1;
	//alert(xmlHttp.responseText);
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
			
			alert(xmlHttp.responseText);
		}
}

