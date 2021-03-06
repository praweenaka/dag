<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link media="screen" rel="stylesheet" type="text/css" href="css/admin_min.css"  />

<link rel="stylesheet" href="calendar.css">
<link type="text/css" rel="stylesheet" href="maincss/form.css"/>
<link type="text/css" rel="stylesheet" href="maincss/industrial_dark.css" />


<title>Search Customer</title>
<link rel="stylesheet" href="css/table_min.css" type="text/css"/>	
<script language="JavaScript" src="js/autho.js"></script>
<style type="text/css">

	/* START CSS NEEDED ONLY IN DEMO */
	html{
		height:100%;
	}
	
	
	#mainContainer{
		width:700px;
		margin:0 auto;
		text-align:left;
		height:100%;
		background-color:#FFF;
		border-left:3px double #000;
		border-right:3px double #000;
	}
	#formContent{
		padding:5px;
	}
	/* END CSS ONLY NEEDED IN DEMO */
	
	
	/* Big box with list of options */
	#ajax_listOfOptions{
		position:absolute;	/* Never change this one */
		width:175px;	/* Width of box */
		height:250px;	/* Height of box */
		overflow:auto;	/* Scrolling features */
		border:1px solid #317082;	/* Dark green border */
		background-color:#FFF;	/* White background color */
		text-align:left;
		font-size:0.9em;
		z-index:100;
	}
	#ajax_listOfOptions div{	/* General rule for both .optionDiv and .optionDivSelected */
		margin:1px;		
		padding:1px;
		cursor:pointer;
		font-size:0.9em;
	}
	#ajax_listOfOptions .optionDiv{	/* Div for each item in list */
		
	}
	#ajax_listOfOptions .optionDivSelected{ /* Selected item in the list */
		background-color:#317082;
		color:#FFF;
	}
	#ajax_listOfOptions_iframe{
		background-color:#F00;
		position:absolute;
		z-index:5;
	}
	
	form{
		display:inline;
	}

	#article {font: 12pt Verdana, geneva, arial, sans-serif;  background: white; color: black; padding: 10pt 15pt 0 5pt}
    </style>
	

</head>

<body>

<?php

	require_once("connectioni.php");
	
	
	
	
			
  $_SESSION["AUTH_OK"] = "0";
//  echo "CHECK_USER-".$_SESSION["CHECK_USER"];
  if ($_SESSION["CHECK_USER"]=="true"){
    $sql="select * from userpermission where username='" . $_SESSION["CURRENT_USER"] . "' and docid=" . $_SESSION["CURRENT_DOC"];
	//echo "1-".$sql;
    $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
    if ($row = mysqli_fetch_array($result)){
     // echo "VIEW_DOC-".$_SESSION["VIEW_DOC"];
	  if ($_SESSION["VIEW_DOC"]=="true") {
            $_SESSION["AUTH_OK"] = $row["doc_view"];
            $actType = "view";
      }
      
      if ($_SESSION["FEED_DOC"]=="true") {
            $_SESSION["AUTH_OK"] = $row["doc_feed"];
            $actType = "save";
      }
      
      if ($_SESSION["MOD_DOC"]=="true") {
            $_SESSION["AUTH_OK"] = $row["doc_mod"];
            $actType = "delete";
      }
      
      if ($_SESSION["PRINT_DOC"]=="true") {
            $_SESSION["AUTH_OK"] = $row["doc_print"];
            $actType = "print";
      }
      
      if ($_SESSION["PRICE_EDIT"]=="true") {
            $_SESSION["AUTH_OK"] = $row["price_edit"];
            $actType = "price";
      }
         
  } else {
   // echo ">>>>no";
    	$_SESSION["AUTH_OK"] = "0";
    
  }
	
	if ($_SESSION["AUTH_OK"]=="0"){
		echo "Access Denied";
	} else {
		$sql_doc="select * from doc where docid=" . $_SESSION["CURRENT_DOC"] . "";
   		$result_doc =mysqli_query($GLOBALS['dbinv'],$sql_doc);
    	$row_doc = mysqli_fetch_array($result_doc);
	
		 $sql_log="insert into entry_log (refno, username, docid, docname, trnType, stime, sdate) VALUES ('" . $_SESSION["REFNO"] . "', '" . $_SESSION["CURRENT_USER"] . "', " . $_SESSION["CURRENT_DOC"] . " , '" . $row_doc["docname"] . "' , '" . $actType . "' , '" . date("Y-m-d H:i:s") . "','" . date("Y-m-d") . "')";
    	 $result_log =mysqli_query($GLOBALS['dbinv'],$sql_log);
		
     	/*$_SESSION["VIEW_DOC"] = "false";
     	$_SESSION["FEED_DOC"] = "false";
     	$_SESSION["MOD_DOC"] = "false";
     	$_SESSION["PRINT_DOC"] = "false";
     	$_SESSION["PRICE_EDIT"] = "false";*/
	}
	
    
}
?>

<?php

$muser = "";

if (isset($_SESSION["CURRENT_USER"])) {
	$muser  = $_SESSION["CURRENT_USER"];	
}


?>

 <table width="422" border="0">
 
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td >&nbsp;</td>
  <td >&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td><strong><input name="txtUserName1" type="text" class="text_purchase3" id="txtUserName1" disabled="disabled" onkeypress="keyset('txtPassword', event)" value="User Name"  /></strong></td>
  <td >&nbsp;</td>
  <td ><input name="txtUserName" type="text" class="text_purchase3" id="txtUserName"  value="<?php echo $muser; ?>"  onkeypress="keyset('txtPassword', event)"  /></td>
</tr>
<tr>
  <td >&nbsp;</td>
  <td ><strong><input name="txtUserName3" type="text" class="text_purchase3" id="txtUserName3" disabled="disabled" onkeypress="keyset('txtPassword', event)" value="Password"  /></strong></td>
  <td >&nbsp;</td>
  <td ><input class="text_purchase3" name="txtPassword" type="password" id="txtPassword" onkeypress="keyset('btn', event)"/></td>
</tr>
<tr>
  <td  background="images/headingbg.gif" >&nbsp;</td>
  <td  background="images/headingbg.gif" >&nbsp;</td>
  <td  background="images/headingbg.gif" >&nbsp;</td>
  <td  background="images/headingbg.gif" >&nbsp;</td>
</tr>
<tr>
  <td width="81"  background="images/headingbg.gif" >&nbsp;</td>					
						
                             <td width="81"  background="images/headingbg.gif" >&nbsp;</td>
    <td width="74"  background="images/headingbg.gif" ><input type="button" name="searchcust2" id="searchcust2" value="Ok"  class="btn_purchase2" onclick="chk_user('<?php echo $_GET["stname"]; ?>');" /></td>
    <td width="168"  background="images/headingbg.gif" ><input type="button" name="searchcust" id="searchcust" value="Cancel"  class="btn_purchase2"></td>
</tr>  </table>    


</body>
</html>
