<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" href="calendar.css">
<link type="text/css" rel="stylesheet" href="maincss/form.css"/>
<link type="text/css" rel="stylesheet" href="maincss/industrial_dark.css" />

<title>Search Customer</title>
<link rel="stylesheet" href="css/table.css" type="text/css"/>	
<script language="JavaScript" src="js/ord.js"></script>
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

 <table width="785" border="0" class=\"form-matrix-table\">
 
<tr>
  <td  background="images/headingbg.gif" ><input type="radio" name="radio" id="Option1" value="Option1" checked="checked" onclick="update_list('$stname');" />
    Pending Order</td>
  <td width="208"  background="images/headingbg.gif" ><input type="radio" name="radio" id="Option2" value="Option2" onclick="update_list('$stname');"/>
  Approved and Not Invoiced</td>
  <td width="225"  background="images/headingbg.gif" ><input type="radio" name="radio" id="Option3" value="Option3" onclick="update_list('$stname');"/>
    Approved and Invoiced</td>
  <td  background="images/headingbg.gif" ><input type="radio" name="radio" id="Option4" value="Option4" onclick="update_list('$stname');"/>
    To WD</td>
</tr>
<tr>					
						<?php 
	  				$stname = $_GET["stname"];
					$_SESSION["stname"]=$stname;
					?>
                             <td width="120"  background="images/headingbg.gif" ><input type="text" size="20" name="invno" id="invno" value="" class="txtbox"  onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
      <td colspan="2"  background="images/headingbg.gif" ><input type="text" size="70" name="customername" id="customername" value="" class="txtbox" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
      <td width="214"  background="images/headingbg.gif" ><input type="text" size="29" name="invdate" id="invdate" value="" class="txtbox"/></td>
   </tr>  </table>    
<div id="filt_table" class="CSSTableGenerator">  <table width="735" border="0" class=\"form-matrix-table\">
                            <tr>
                              <td width="121"  background="images/headingbg.gif" ><font color="#FFFFFF">Order No</font></td>
                              <td width="424"  background="images/headingbg.gif"><font color="#FFFFFF">Customer</font></td>
                              <td width="176"  background="images/headingbg.gif"><font color="#FFFFFF">Order Date</font></td>
   </tr>
                            <?php 
							
							require_once("config.inc.php");
							require_once("DBConnector.php");
							$db = new DBConnector();
							
							if ($_GET["stname"]=="ord"){
								$sql="SELECT * FROM s_cusordmas where CANCELL='0' order by SDATE desc";
							} else {
								$sql="SELECT * FROM s_cusordmas where INVNO='0' and CANCELL='0' order by SDATE desc";
							}
							
							$result =$db->RunQuery($sql);
							while($row = mysql_fetch_array($result)){
								$ref_no=$row['REF_NO'];
							echo "<tr>               
                              <td onclick=\"invno('$ref_no', '$stname');\">".$row['REF_NO']."</a></td>
                              <td onclick=\"invno('$ref_no', '$stname');\">".$row['CUS_NAME']."</a></td>
                              <td onclick=\"invno('$ref_no', '$stname');\">".$row['SDATE']."</a></td>
                              
                            </tr>";
							}
							  ?>
                    </table>
                </div>

</body>
</html>
