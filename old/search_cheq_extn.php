<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<link href="admin_min.css" rel="stylesheet" type="text/css" media="screen" />



<title>Search Customer</title>
<link rel="stylesheet" href="css/table_min.css" type="text/css"/>	
<script language="JavaScript" src="js/search_cheq_extn.js"></script>
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

 <table width="1444" border="0">
 
<tr>
  <td  background="" ><input type="radio" name="radio" id="Option1" value="Option1" checked="checked" onclick="select_list('Option1');" />Save</td>
  <td  background="" ><input type="radio" name="radio" id="Option2" value="Option2"  onclick="select_list('Option2');" />Not Approved</td>
  <td  background="" ><input type="radio" name="radio" id="Option3" value="Option3" onclick="select_list('Option3');" />Not Posted</td>
  <td  background="" ><input type="radio" name="radio" id="Option4" value="Option4"  onclick="select_list('Option4');" />Complete</td>
</tr>
<tr>					
						<?php 
	  				$stname = $_GET["stname"];
					?>
                             <td width="283"  background="" ><input type="text" size="20" name="invno" id="invno" value="" class="txtbox"  onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
                             <td width="170"  background="" >&nbsp;</td>
    <td width="264"  background="" ><input type="hidden" size="10" name="customername" id="customername" value="" class="txtbox" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
    <td width="709"  background="" ><input type="hidden" size="29" name="invdate" id="invdate" value="" class="txtbox" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
   </tr>  </table>    
<div class="CSSTableGenerator" id="filt_table">  <table width="735" border="0" class=\"form-matrix-table\">
                          <?php
						  	if ($_GET["stname"]=="extend"){
								
								
								
								
                            	echo "<tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">Cheque No</font></td>
                              <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Sales Ex</font></td>
                              <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Chq Amount</font></td>
							  <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Chq Date</font></td>
							  <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Chq Extn Date</font></td>
							  <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Approved</font></td>
							  <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Acc Appro</font></td>
</tr>";
							}
                            
							
							require_once("connectioni.php");
							
							
							
							$sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved,ins  from  s_cheque_extend ORDER BY id desc limit 50";

							//echo $sql;
							$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
							while($row = mysqli_fetch_array($result)){
								
								$bgcolou = "";
									if ($row['ins']=="YES") {
										$bgcolou = "#FF0000";
									}
								
								
									echo "<tr>               
                              <td onclick=\"chq_extn('".trim($row['ch_no'])."', '".$row['refno']."');\"><font color='". $bgcolou . "'>".$row['ch_no']."</a></td>
                              <td onclick=\"chq_extn('".trim($row['ch_no'])."', '".$row['refno']."');\"><font color='". $bgcolou . "'>".$row['refno']."</a></td>
                              <td onclick=\"chq_extn('".trim($row['ch_no'])."', '".$row['refno']."');\"><font color='". $bgcolou . "'>".$row['sal_ex']."</a></td>
							  <td onclick=\"chq_extn('".trim($row['ch_no'])."', '".$row['refno']."');\"><font color='". $bgcolou . "'>".$row['ch_amount']."</a></td>
							   <td onclick=\"chq_extn('".trim($row['ch_no'])."', '".$row['refno']."');\"><font color='". $bgcolou . "'>".$row['ch_date']."</a></td>
							   <td onclick=\"chq_extn('".trim($row['ch_no'])."', '".$row['refno']."');\"><font color='". $bgcolou . "'>".$row['ch_exdate']."</a></td>
							   <td onclick=\"chq_extn('".trim($row['ch_no'])."', '".$row['refno']."');\"><font color='". $bgcolou . "'>".$row['approved']."</a></td>
							   <td onclick=\"chq_extn('".trim($row['ch_no'])."', '".$row['refno']."');\"><font color='". $bgcolou . "'>".$row['acc_approved']."</a></td>
                            </tr>";
							
							}
							  ?>
                    </table>
                </div>

</body>
</html>
