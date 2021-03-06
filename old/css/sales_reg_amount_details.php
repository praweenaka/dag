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
<script language="JavaScript" src="js/arr.js"></script>
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


                <div class="CSSTableGenerator" id="filt_table">  <table width="735" border="0" class=\"form-matrix-table\">
                           <?php
						   	if ($_GET["trn_type"]=="INV"){   
						    
                            echo "<tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">REF No</font></td>
                              <td width=\"121\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"121\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cus Code</font></td>
							  <td width=\"121\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Payment</font></td>
							  <td width=\"121\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Brand</font></td>
							
</tr>";

							} 
						
                            
							
							require_once("config.inc.php");
							require_once("DBConnector.php");
							$db = new DBConnector();
							
						if ($_GET["trn_type"]=="INV"){  
						
							$sql="Select C_REFNO, C_DATE, C_CODE, C_PAYMENT, Brand from cred where C_INVNO='" . trim($_GET["refno"]) . "' and cancell = '0'";
							
							
							$result =$db->RunQuery($sql);
							while($row = mysql_fetch_array($result)){
					
							echo "<tr>               
                              <td >".$row['C_REFNO']."</a></td>
                              <td >".$row['C_DATE']."</a></td>
                             <td >".$row['C_CODE']."</a></td>
							 <td >".$row['C_PAYMENT']."</a></td>
							 <td >".$row['Brand']."</a></td>
							 
							 
                            </tr>";
							}
						
						} 
							  ?>
                    </table>
                </div>

</body>
</html>
