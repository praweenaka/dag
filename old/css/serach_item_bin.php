<?php session_start();
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
<script language="JavaScript" src="js/bin_card.js"></script>
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
                             <td width="122"  background="images/headingbg.gif" ><input type="text" size="20" name="itno" id="itno" value="" class="txtbox" onkeyup="update_item_list();"/></td>
      <td width="603"  background="images/headingbg.gif" ><input type="text" size="70" name="itemname" id="itemname" value="" class="txtbox" onkeyup="update_item_list();"/></td>
      </table>    
                <div class="CSSTableGenerator" id="filt_table">  <table width="735" border="0" class=\"form-matrix-table\">
                            <tr>
                              <td width="121"  background="images/headingbg.gif" ><strong><font color="#FFFFFF">Item No</font></strong></td>
                              <td width="424"  background="images/headingbg.gif"><strong><font color="#FFFFFF">Item Description</font></strong></td>
                               <td width="150"  background="images/headingbg.gif"><strong><font color="#FFFFFF">Brand Name</font></strong></td>
                              <td width="150"  background="images/headingbg.gif"><strong><font color="#FFFFFF">Stock In Hand</font></strong></td>
                             
   </tr>
                            <?php 
							
							require_once("config.inc.php");
							require_once("DBConnector.php");
							$db = new DBConnector();
							
								$sql="SELECT * from s_mas order by STK_NO limit 50";
						
							$result =$db->RunQuery($sql);
							//echo $sql;
							while($row = mysql_fetch_array($result)){
					
							echo "<tr>               
                              <td onclick=\"itno('".$row['STK_NO']."');\">".$row['STK_NO']."</a></td>
                              <td onclick=\"itno('".$row['STK_NO']."');\">".$row['DESCRIPT']."</a></td>
							  <td onclick=\"itno('".$row['STK_NO']."');\">".$row['BRAND_NAME']."</a></td>
							  <td onclick=\"itno('".$row['STK_NO']."');\">".number_format($row['QTYINHAND'], 0, ".", ",")."</a></td>";
							  
							  $department=$_SESSION["department"];
							  
							 /* $sql1="select QTYINHAND from s_submas where STK_NO='".$row['STK_NO']."' AND STO_CODE='".$department."'";
							 
							  $result1 =$db->RunQuery($sql1);
							  if($row1 = mysql_fetch_array($result1)){
							  	echo "<td onclick=\"itno('".$row['STK_NO']."');\">".$row1['QTYINHAND']."</a></td>";
							  } else {
							    echo "<td onclick=\"itno('".$row['STK_NO']."');\">0</a></td>";
							  } */
								
                         	                                
                            echo "</tr>";
							}
							  ?>
                    </table>
                </div>

</body>
</html>
