var xmlHttp
var eleid;


///////FIRST NAME //////////////////////////////////////////////////////////////////////////////
function GetResult_firstname(str,geteleid)
{
	eleid=geteleid;
	
	document.getElementById('dropdownfname').style.visibility='visible';
	
	
	Remove_List(eleid);
if (str.length==0)
  { 
  document.getElementById("ViewResult").innerHTML=""
  return
  }
  
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
  
var url="suggation.php"
url=url+"?Command="+"get_firstname";	
url=url+"&q="+str
url=url+"&sid="+Math.random()
//alert(url);
xmlHttp.onreadystatechange=stateChanged 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 


//////LAST NAME //////////////////////////////////////////////////////////////////////

function GetResult_Lastname(str,geteleid)
{
	eleid=geteleid;
	
	document.getElementById('dropdownlname').style.visibility='visible';
	Remove_List(eleid);
if (str.length==0)
  { 
  document.getElementById("ViewResult").innerHTML=""
  return
  }
  
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
  
var url="suggation.php"
url=url+"?Command="+"get_Lastname";	
url=url+"&q="+str
url=url+"&sid="+Math.random()
//alert(url);
xmlHttp.onreadystatechange=stateChanged 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 


function stateChanged() 
{ 

	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	 { 
		 
		// document.getElementById("GetResult").innerHTML=xmlHttp.responseText;	
		 
		//alert(xmlHttp.responseText);
		var a=(xmlHttp.responseText.split(','))
		for (i=0;i<a.length;i++)
		{
			//alert(a[i]);
			AddItem(a[i],a[i]);
			
		}
		
	 } 
}

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

function AddItem(Text,Value)
    {
        // Create an Option object        

        var opt = document.createElement("option");

        // Add an Option object to Drop Down/List Box
        document.getElementById(eleid).options.add(opt);

        // Assign text and value to Option object
        opt.text = Text;
        opt.value = Value;

    }
	
function Remove_List(eleid)
{
	var len = document.getElementById(eleid).options.length;
	//alert(len);
	for(i=0; i<len; i++)
	{
		var x=document.getElementById(eleid)
		x.remove(x.selectedIndex)
		//alert("Test");
	}
	
}

function changeval(txt,drop)
{
	//alert(eleid);
	document.getElementById(txt).value=document.getElementById(drop).value;
	
	
}

