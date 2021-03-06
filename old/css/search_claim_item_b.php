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
<script language="JavaScript" src="js/search_claim_item.js"></script>
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

 <table width="735" border="0" class=\"form-matrix-table\">
 
<tr>
                             <td width="422"  background="images/headingbg.gif" ><input type="text" size="30" name="refno" id="refno" value="" class="txtbox" onkeyup="update_list();"/></td>
      <td width="603"  background="images/headingbg.gif" ><input type="text" size="30" name="claim_no" id="claim_no" value="" class="txtbox" onkeyup="update_list();"/></td>
       <td width="603"  background="images/headingbg.gif" ><input type="text" size="30" name="agent_no" id="agent_no" value="" class="txtbox" onkeyup="update_list();"/></td>
        <td width="603"  background="images/headingbg.gif" ><input type="text" size="50" name="agent_name" id="agent_name" value="" class="txtbox" onkeyup="update_list();"/></td>
      </table>    
                <div id="filt_table" class="CSSTableGenerator">  <table width="735" border="0" class=\"form-matrix-table\">
                            <tr>
                              <td width="121"  background="images/headingbg.gif" ><strong><font color="#FFFFFF">Reference No</font></strong></td>
                              <td width="424"  background="images/headingbg.gif"><strong><font color="#FFFFFF">Claim No</font></strong></td>
                              <td width="150"  background="images/headingbg.gif"><strong><font color="#FFFFFF">Agent Code</font></strong></td>
                              <td width="150"  background="images/headingbg.gif"><strong><font color="#FFFFFF">Agent Name</font></strong></td>
                             
   </tr>
                          <?php 
						  require_once("config.inc.php");
							require_once("DBConnector.php");
							$db = new DBConnector();
						  
						if ($_GET["stname"]=="claim_item"){
						 	$sql = "select refno, cl_no, ag_code, ag_name  from c_clamas where type = 'BAT' ORDER BY entdate desc limit 50";
							$result =$db->RunQuery($sql);
							while($row = mysql_fetch_array($result)){
					
								echo "<tr>               
                              		<td onclick=\"itno_claim('".$row['refno']."', '".$_GET["stname"]."');\">".$row['refno']."</a></td>
                              		<td onclick=\"itno_claim('".$row['refno']."', '".$_GET["stname"]."');\">".$row['cl_no']."</a></td>
							  		<td onclick=\"itno_claim('".$row['refno']."', '".$_GET["stname"]."');\">".$row['ag_code']."</a></td>
									<td onclick=\"itno_claim('".$row['refno']."', '".$_GET["stname"]."');\">".$row['ag_name']."</a></td>";
							  							 							  
							 
							   echo "</tr>";
							 }  
						}
							  ?>
                    </table>
                </div>

</body>
</html>
