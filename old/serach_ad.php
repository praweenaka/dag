<?php session_start();

date_default_timezone_set('Asia/Colombo'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="admin_min.css" rel="stylesheet" type="text/css" media="screen" />


<title>Search Customer</title>
<link rel="stylesheet" href="css/table_min.css" type="text/css"/>	
<script language="JavaScript" src="js/search_ad.js"></script>
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

 <table width="810" border="0" class=\"form-matrix-table\">
 
<tr>
  <td  background="" ><input type="radio" name="radio" id="Option1" value="Option1" checked="checked" onclick="update_list('$stname');" />
    Pending Order</td>
  <td width="179"  background="" >&nbsp;</td>
  <td width="258"  background="" ><input type="radio" name="radio" id="Option2" value="Option2" onclick="update_list('$stname');"/>
Invoiced</td>
  <td  background="" >&nbsp;</td>
</tr>
<tr>					
						<?php 
	  				$stname = $_GET["stname"];
					$_SESSION["stname"]=$stname;
					?>
                             <td width="140"  background="" ><input type="text" size="20" name="invno" id="invno" value="" class="txtbox"  onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
    <td colspan="2"  background="" ><input type="text" size="70" name="customername" id="customername" value="" class="txtbox" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
      <td width="215"  background="" ><input type="text" size="29" name="invdate" id="invdate" value="" class="txtbox"/></td>
   </tr>  </table>    
<div id="filt_table" class="CSSTableGenerator">  <table width="735" border="0" class=\"form-matrix-table\">
                            <tr>
                              <td width="121"  background="" ><font color="#FFFFFF">Order No</font></td>
                              <td width="424"  background=""><font color="#FFFFFF">Customer</font></td>
                              <td width="176"  background=""><font color="#FFFFFF">Order Date</font></td>
                              <td width="176"  background=""><font color="#FFFFFF">Grand Total</font></td>
   </tr>
                            <?php 
							
							require_once("connectioni.php");
							
							
							
							//if ($_GET["stname"]=="ord"){
							//	$sql="SELECT * FROM s_cusordmas where CANCELL='0' order by SDATE desc limit 50";
							//} else {
								$sql="SELECT * FROM s_admas where INVNO='0' and CANCELL='0' order by SDATE desc limit 50";
							//}
							
							$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
							while($row = mysqli_fetch_array($result)){
								$ref_no=$row['REF_NO'];
							echo "<tr>               
                              <td onclick=\"invno('$ref_no', '$stname');\">".$row['REF_NO']."</a></td>
                              <td onclick=\"invno('$ref_no', '$stname');\">".$row['CUS_NAME']."</a></td>
                              <td onclick=\"invno('$ref_no', '$stname');\">".$row['SDATE']."</a></td>
							   <td onclick=\"invno('$ref_no', '$stname');\">".$row['GRAND_TOT']."</a></td>
                              
                            </tr>";
							}
							  ?>
                    </table>
                </div>

</body>
</html>
