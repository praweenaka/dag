<?php
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Advance Commission</title>
<style type="text/css">
<!--
.companyname {
	color: #0000FF;
	font-weight: bold;
	font-size: 24px;
}

.com_address {
	color: #000000;
	font-weight: bold;
	font-size: 22px;
}

.heading {
	color: #000000;
	font-weight: bold;
	font-size: 20px;
}

body {
	color: #000000;
	font-size: 14px;
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}

td {
    font-size: 16px;
}

-->
</style>
</head>

<body><center>
<?php 
	require_once("connectioni.php");
	
	
	
	$row_rspara= "select * from invpara";
	$result_rspara =mysqli_query($GLOBALS['dbinv'],$row_rspara);
	$row_rspara= mysqli_fetch_array($result_rspara);
	
	$txtrepono= $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");
	
	$row_rss_salrep= "select * from s_salrep where repcode='" . $_GET["cmbrep"] . "'";
	$result_rss_salrep =mysqli_query($GLOBALS['dbinv'],$row_rss_salrep);
	if ($row_rss_salrep= mysqli_fetch_array($result_rss_salrep)){
		$TXTREP=$row_rss_salrep["Name"];
	}

	$TXTCOM=$row_rspara["COMPANY"];
	$txtmon=date("M/Y", strtotime($_GET["dtMonth"]));
	$txttyre = "Battery";
	$txtbattery = "Tyre/A-W";

	$txttube = "Total";
	$Text5 = "Battery";
	$Text6 = "Tyre/A-W";

	$Text21 = "Total";


	$txttyresale =str_replace(",", "",$_GET["Sales_gridA41"]);
	
	$txttyresalec =str_replace(",", "",$_GET["Sales_gridA43"]);
	$txtBatsalec =str_replace(",", "",$_GET["Sales_gridB43"]);
	
	$txtBatsale = str_replace(",", "",$_GET["Sales_gridB41"]);

	$Txttubesale = str_replace(",", "",$_GET["Sales_gridA41"]) + str_replace(",", "",$_GET["Sales_gridB41"]);

	$Text22=str_replace(",", "",$_GET["Sales_gridA41"]) / 2;
	$Text23 = str_replace(",", "",$_GET["Sales_gridB41"]) / 2;

	$Text25 = (str_replace(",", "",$_GET["Sales_gridA41"]) + str_replace(",", "",$_GET["Sales_gridB41"])) / 2;

	$Text26 = str_replace(",", "",$_GET["Comm_grid11"]);
	$Text27 = str_replace(",", "",$_GET["Comm_grid21"]);
	$Text29= str_replace(",", "",$_GET["Comm_grid31"]);

	$txtout = str_replace(",", "",$_GET["Ratio_grid31"]);
	$Text40 = str_replace(",", "",$_GET["TXTADJ"]);
	$txtoutper = str_replace(",", "",$_GET["txtra_per"]);
	$txtoutamou = str_replace(",", "",$_GET["txt_rded"]) * -1;
	$txttotcom = str_replace(",", "",$_GET["txt_adv"]);
	$txtroucom = str_replace(",", "",$_GET["txt_radv"]);

	
	
	
    $Text9 = $_GET["Deduction_grid11"];
    $Text13 = $_GET["Deduction_grid21"];
    $Text14 = $_GET["Deduction_grid31"];
    $Text15 = $_GET["Deduction_grid41"];
    $Text30 = $_GET["Deduction_grid51"];
    $Text42 = $_GET["Deduction_grid61"];
    $Text43 = $_GET["Deduction_grid71"];
    $Text44 = $_GET["Deduction_grid81"];
    
    $Text31 = str_replace(",", "",$_GET["Deduction_grid12"]) * -1;
    $Text32 = str_replace(",", "",$_GET["Deduction_grid22"]) * -1;
    $Text33 = str_replace(",", "",$_GET["Deduction_grid32"]) * -1;
    $Text34 = str_replace(",", "",$_GET["Deduction_grid42"]) * -1;
    $Text16 = str_replace(",", "",$_GET["Deduction_grid52"]) * -1;
    $Text45 = str_replace(",", "",$_GET["Deduction_grid62"]) * -1;
    $Text46 = str_replace(",", "",$_GET["Deduction_grid72"]) * -1;
    $Text47 = str_replace(",", "",$_GET["Deduction_grid82"]) * -1;
    
	$txtcommi= str_replace(",", "",$_GET["txt_radv"]);
	$txtcommif =$txtcommi + ($Text31+$Text32+$Text33+$Text34+$Text16+$Text45+$Text46+$Text47);
	


	
	?>
    
<table width="800" border="0">
  <tr>
    <td colspan="5" align="center"><span class="companyname"><?php echo $row_rspara["COMPANY"]; ?></span></td>
  </tr>
  <tr>
    <td colspan="5" align="left"><span class="com_address"><?php echo $TXTREP ?></span></td>
  </tr>
   <?php
		//echo $_GET["invno"];
    			 
		 $year = substr($_GET["dtMonth"], 0, 4);
$month = substr($_GET["dtMonth"], 5, 2);
$mrefno = $month . "/" . $year . "-" . substr($_GET["cmbrep"], 0, 2) . "-0";

$sql_rss_commadva = "select * from s_commadva where FLAG='ADV' AND refno='" . $mrefno . "' ";
 
$result_rss_commadva = mysqli_query($GLOBALS['dbinv'], $sql_rss_commadva);
$row = mysqli_fetch_array($result_rss_commadva);
		
$txtchq = trim($row["remark"]) . "-" . trim($row["chno"]) . "-" . trim($row["Bank"]) . "-" . trim($row["PCHNO"]);
	 		
		
		
	?>
  <tr>
    <td><span class="style1">Sales Commission Advance for</span></td>
    <td><span class="style1"><?php echo $txtmon; ?></span></td>
    <td width="125" align="center">    </td>
    <td colspan="2" align="center"><span class="style1"></span></td>
  </tr>
    <tr>
    <th colspan="4" scope="col">&nbsp;</th>
  </tr>
     <tr>
    <td><span class="style1"></span></td>
    <td><span class="style1"><?php echo $txtmon; ?></span></td>
    <td width="125" align="center">    </td>
    <td colspan="2" align="center"><span class="style1">Commission</span></td>
  </tr>
  <tr>
    <td width="254"><span class="style1">Nett Sales</span></td>
    <td width="177"><?php echo $txttyre; ?></td>
    <td align ="right" width="125"><?php echo number_format($txttyresale, 2, ".", ","); ?></td>
    <td align ="right" width="226"><?php echo number_format($Text26, 2, ".", ","); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $txtbattery; ?></td>
    <td  align ="right" ><?php echo number_format($txtBatsale, 2, ".", ","); ?></td>
    <td  align ="right" ><?php echo number_format($Text27, 2, ".", ","); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $txtalloy; ?></td>
    <td align ="right" ><?php echo number_format($TxtAWsale, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $txttube; ?></td>
    <td  align ="right" ><?php echo number_format($Txttubesale, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1"></span></td>
  </tr>
 
  <tr>
    <td colspan="2"><span class="style1">Return Chqs &amp; Outstanding</span></td>
    <td><?php echo $txtout; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style1">Return Chqs & Outstanding - Adjustment</span></td>
    <td><?php echo $Text40; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Return Chqs &amp; Outstanding - % &amp; Deduct Amount </td>
    <td><?php echo $txtoutper." %"; ?></td>
    <td><?php echo $txtoutamou; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td  align ="right" ><span class="style1"><b>______________________</b></span></td>
  </tr>
  <tr>
    <td colspan="2"><span class="style1">Total for Commission Advance</span></td>
    <td>&nbsp;</td>
    <td  align ="right" ><b><?php echo  number_format($txtcommi,"2",".",",") ; ?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td  align ="right" ><b>======================</b></td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
  </tr>
  <tr>
    <td height="18"><span class="style1">Less</span></td>
    <td height="18"><?php echo $Text9; ?></td>
    <td height="18">&nbsp;</td>
    <td  align ="right"  height="18"><?php echo number_format($Text31,"2",".",","); ?></td>
  </tr>
  <?php 
  if ($Text13 !="") {
  ?>  
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text13; ?></td>
    <td height="18">&nbsp;</td>
    <td  align ="right"  height="18"><?php echo number_format($Text32,"2",".",","); ?></td>
  </tr>
    <?php  } ?>
    <?php 
  if ($Text13 !="") {
  ?> 
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text14; ?></td>
    <td height="18">&nbsp;</td>
    <td  align ="right"  height="18"><?php echo number_format($Text33,"2",".",","); ?></td>
  </tr>
     <?php  } ?>
    <?php 
  if ($Text13 !="") {
  ?> 
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text15; ?></td>
    <td height="18">&nbsp;</td>
    <td  align ="right"  height="18"><?php echo number_format($Text34,"2",".",","); ?></td>
  </tr>
     <?php  } ?>
    <?php 
  if ($Text13 !="") {
  ?> 
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text30; ?></td>
    <td height="18">&nbsp;</td>
    <td  align ="right"  height="18"><?php echo number_format($Text16,"2",".",","); ?></td>
  </tr>
     <?php  } ?>
    <?php 
  if ($Text13 !="") {
  ?> 
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text42; ?></td>
    <td height="18">&nbsp;</td>
    <td  align ="right" height="18"><?php echo number_format($Text45,"2",".",","); ?></td>
  </tr>
     <?php  } ?>
    <?php 
  if ($Text13 !="") {
  ?> 
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text43; ?></td>
    <td height="18">&nbsp;</td>
    <td  align ="right"  height="18"><?php echo number_format($Text46,"2",".",","); ?></td>
  </tr>
     <?php  } ?>
    <?php 
  if ($Text13 !="") {
  ?> 
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text44; ?></td>
    <td height="18">&nbsp;</td>
    <td  align ="right"  height="18"><?php echo number_format($Text47,"2",".",","); ?></td>
  </tr>
     <?php  } ?>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
  </tr>
  <tr>
    <td height="46" colspan="4"><?php echo $Text38; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td  align ="right" ><span class="style1"><b>______________________</b></span></td>
  </tr>
  <tr>
    <td colspan="2"><span class="style1">Total for Commission Advance Payable</span></td>
    <td>&nbsp;</td>
    <td  align ="right" ><b><?php echo number_format($txtcommif,"2",".",",") ; ?></b></td>
  </tr>
     <tr>
                      <td colspan="3"><span class="style2"><?php echo $txtchq; ?></span></td>
                      <td>&nbsp;</td>
                    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td  align ="right" ><b>======================</b></td>
  </tr>
  
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Prepared By:</td>
    <td>&nbsp;</td>
    <td>Authorized By:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Prepared Date: <?php echo $Text36; ?></td>
    <td>&nbsp;</td>
    <td>Authorized Date:</td>
    <td><?php echo $Text37; ?></td>
  </tr>
  <tr>
    <td><?php echo $txtrepono; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
