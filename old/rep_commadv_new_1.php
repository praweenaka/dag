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
.style2 {
                font-size: 18px;
                font-weight: bold;
				color:#FF0000;
            }

-->
</style>
</head>

<body><center>
<?php
require_once ("connectioni.php");

$row_rspara = "select * from invpara";
$result_rspara = mysqli_query($GLOBALS['dbinv'], $row_rspara);
$row_rspara = mysqli_fetch_array($result_rspara);

$txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

$row_rss_salrep = "select * from s_salrep where repcode='" . $_GET["cmbrep"] . "'";
$result_rss_salrep = mysqli_query($GLOBALS['dbinv'], $row_rss_salrep);
if ($row_rss_salrep = mysqli_fetch_array($result_rss_salrep)) {
	$TXTREP = $row_rss_salrep["Name"];
}

$TXTCOM = $row_rspara["COMPANY"];
$txtmon = date("M/Y", strtotime($_GET["dtMonth"]));
$txttyre = "Battery";
$txtbattery = "Tyre/A-W";

$txttube = "Total";
$Text5 = "Battery";
$Text6 = "Tyre/A-W";
$Text21 = "Total";

$txttyresale = str_replace(",", "", $_GET["Sales_gridA41"]);
 
$Txttubesale = str_replace(",", "", $_GET["Sales_gridA41"]) + str_replace(",", "", $_GET["Sales_gridB41"]);

$Text22 = str_replace(",", "", $_GET["Sales_gridA41"]) / 2;
$Text23 = str_replace(",", "", $_GET["Sales_gridB41"]) / 2;

$Text25 = (str_replace(",", "", $_GET["Sales_gridA41"]) + str_replace(",", "", $_GET["Sales_gridB41"])) / 2;

 
 
$txtoutamou = $_GET["txt_rded"] * -1;
$txttotcom = $_GET["txt_adv"];
$txtroucom = $_GET["txt_radv"];

$Text9 = $_GET["Deduction_grid11"];
$Text13 = $_GET["Deduction_grid21"];
$Text14 = $_GET["Deduction_grid31"];
$Text15 = $_GET["Deduction_grid41"];
$Text30 = $_GET["Deduction_grid51"];
$Text42 = $_GET["Deduction_grid61"];
$Text43 = $_GET["Deduction_grid71"];
$Text44 = $_GET["Deduction_grid81"];

$Text31 = str_replace(",", "", $_GET["Deduction_grid12"]) * -1;
$Text32 = str_replace(",", "", $_GET["Deduction_grid22"]) * -1;
$Text33 = str_replace(",", "", $_GET["Deduction_grid32"]) * -1;
$Text34 = str_replace(",", "", $_GET["Deduction_grid42"]) * -1;
$Text16 = str_replace(",", "", $_GET["Deduction_grid52"]) * -1;
$Text45 = str_replace(",", "", $_GET["Deduction_grid62"]) * -1;
$Text46 = str_replace(",", "", $_GET["Deduction_grid72"]) * -1;
$Text47 = str_replace(",", "", $_GET["Deduction_grid82"]) * -1;

$mded = $Text31 + $Text32 + $Text33 + $Text34 + $Text16 + $Text45 + $Text46 + $Text47;

 
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
$mrefno = $month . "/" . $year . "-" . substr($_GET["cmbrep"], 0, 2) . "- Bal -0";

$sql_rss_commadva = "select * from s_commadva where FLAG='BAL' AND refno='" . $mrefno . "' ";
 
$result_rss_commadva = mysqli_query($GLOBALS['dbinv'], $sql_rss_commadva);
$row = mysqli_fetch_array($result_rss_commadva);
$txttyres = $row['tar_salB'];
$txttyresc = $row['Com_battery'];

$txttyrens = $row['Com_tyre'];
$txttyrensc =  $row['Com_AW'];

 
   		$txtchq = trim($row["remark"]) . "-" . trim($row["chno"]) . "-" . trim($row["Bank"]) . "-" . trim($row["PCHNO"]);
	 

$txtbats = $row['crn_a'];
$txtbatsc = $row['Crn_d'];

$txtbatns = $row['crn_c'];
$txtbatnsc = $row['Com_tube'];
	?>
  <tr>
    <td><span class="style1">Sales Commission</span></td>
    <td><span class="style1"><?php echo $txtmon; ?></span></td>
    <td width="125" align="center">    </td>
    <td colspan="2" align="center"></td>
  </tr>
    <tr>
    <th colspan="4" scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td width="254"></td>
    <td width="226"></td>
    <td align="center" width="177"><span class="style1">Sale</span></td>
    <td align="center" width="125"><span class="style1">Commission</span></td> 
  </tr>
  
  <tr>
    <td width="254"><span class="style1"><?php echo $txttyre; ?></span></td>
    <td width="177">Cat 1.</td>
    <td align="right" width="125"><?php echo number_format($txttyres, 2, ".", ","); ?></td>
    <td align="right" width="226"><?php echo number_format($txttyresc, 2, ".", ","); ?></td>
  </tr>
  
  <tr>
    <td width="254"></td>
    <td width="177">No Commision</td>
    <td align="right" width="125"><?php echo number_format($txttyrens, 2, ".", ","); ?></td>
    <td align="right" width="226"><?php echo number_format($txttyrensc, 2, ".", ","); ?></td>
  </tr>
  <tr>
    <td><span class="style1"><?php echo $txtbattery; ?></span></td>
    <td>Cat 1.</td>
    <td align="right"><?php echo number_format($txtbats, 2, ".", ","); ?></td>
    <td align="right"><?php echo number_format($txtbatsc, 2, ".", ","); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>No Commision</td>
    <td align="right"><?php echo number_format($txtbatns, 2, ".", ","); ?></td>
    <td align="right"><?php echo number_format($txtbatnsc, 2, ".", ","); ?></td>
  </tr>
  
 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td colspan="2"><span class="style1">Total No Commision</span></td>
    <td><span class="style1"><?php echo number_format($row['Over60Ratio'],2, ".", ","); ?>%</span></td>
    <td>&nbsp;</td>
  </tr>
   
   <tr>
    <td colspan="2"><span class="style1">Gross Sales Commision</span></td>
    <td></td>
    <td align="right"><span class="style1"><?php echo number_format(($txttyresc + $txttyrensc + $txtbatsc + $txtbatnsc + $txtbatnsc), 2, ".", ","); ?></span></td>
  </tr>  
  <?php
$mgross = ($txttyresc + $txttyrensc + $txtbatsc + $txtbatnsc + $txtbatnsc);
 ?>
     <tr>
    
    <td  colspan="2">Less For Comm For GRN</td>
     <td align="right"><?php echo number_format(($row['grn_a'] + $row['grn_b']) * 1, 0, ".", ","); ?></td>
    <td align="right"><?php echo($_GET['txt_rded']); ?></td>
  </tr>  
       <tr>
   
    <td colspan="2">Less For Comm For Return Cheuqe</td>
     <td ></td>
    <td>&nbsp;</td>
  </tr>  
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><span class="style1">___________________</span></td>
  </tr>
  <?php
$mbal = $mgross - str_replace(",", "", $_GET['txt_rded']);
 ?> 
      <tr>
    <td ><span class="style1">Balance Commision</span></td>
    <td></td>
    <td></td> 
    <td align="right"><span class="style1"><?php echo number_format($mbal, "2", ".", ","); ?></span></td>
  </tr>  
 
 <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><span class="style1">___________________</span></td>
  </tr>
  <tr>
    <td height="18"><span class="style1">Deduction</span></td>
    <td height="18"><?php echo $Text9; ?></td>
    <td height="18">&nbsp;</td>
    <td align="right" height="18"><?php echo number_format($Text31, "2", ".", ",") ; ?></td>
  </tr>
  <?php
  if ($Text13 !="") { ?>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text13; ?></td>
    <td height="18">&nbsp;</td>
    <td align="right" height="18"><?php echo number_format($Text32, "2", ".", ","); ?></td>
  </tr>
  <?php } ?>
  <?php
  if ($Text14 !="") { ?>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text14; ?></td>
    <td height="18">&nbsp;</td>
    <td align="right" height="18"><?php echo number_format($Text33, "2", ".", ",") ; ?></td>
  </tr>
  <?php } ?>
  <?php
  if ($Text15 !="") { ?>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text15; ?></td>
    <td height="18">&nbsp;</td>
    <td align="right" height="18"><?php echo number_format($Text34, "2", ".", ",") ; ?></td>
  </tr>
  <?php } ?>
  <?php
  if ($Text30 !="") { ?>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text30; ?></td>
    <td height="18">&nbsp;</td>
    <td align="right" height="18"><?php echo number_format($Text16, "2", ".", ",") ; ?></td>
  </tr>
  <?php } ?>
  <?php
  if ($Text42 !="") { ?>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text42; ?></td>
    <td height="18">&nbsp;</td>
    <td align="right" height="18"><?php echo number_format($Text45, "2", ".", ",") ; ?></td>
  </tr>
  <?php } ?>
  <?php
  if ($Text43 !="") { ?>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text43; ?></td>
    <td height="18">&nbsp;</td>
    <td align="right" height="18"><?php echo number_format($Text46, "2", ".", ",") ; ?></td>
  </tr>
  <?php } ?>
  <?php
  if ($Text44 !="") { ?>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text44; ?></td>
    <td height="18">&nbsp;</td>
    <td align="right" height="18"><?php echo number_format($Text47, "2", ".", ",") ; ?></td>
  </tr>
  <?php } ?>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><span class="style1">___________________</span></td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
  </tr>
  <?php
$mnet = $mbal + $mded;
  ?>
   <tr>
    <td colspan="2"><span class="style1">Balance Commission Payable</span></td>
    <td>&nbsp;</td>
    <td align="right"><span class="style1"><?php echo number_format($mnet, 2, ".", ","); ?></span></td>
  </tr>
   <tr>
                      <td colspan="3"><span class="style2"><?php echo $txtchq; ?></span></td>
                      <td>&nbsp;</td>
                    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">======================</td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
  </tr>
  <tr>
    <td height="46" colspan="4"></td>
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
    <td>Prepared Date: </td>
    <td>&nbsp;</td>
    <td>Authorized Date:</td>
    <td></td>
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
