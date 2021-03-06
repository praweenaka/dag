<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Order</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
	text-decoration:underline;
}
.style2 {
	font-family: Arial;
	font-size: 15px;
}
.style4 {
	font-size: 22px;
	font-weight: bold;
}
.style5 {
	font-size: 12px
}
-->
</style>
</head>

<body><center>
<?php 
require_once("connectioni.php");
	
	
	?>
    
    <?php
		
	
        
		
		


		$txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");


		$txtdep= $_GET["department"];
		
		$sql_dep="select * from s_stomas where CODE='" . trim($txtdep) . "'";
    	$result_dep =mysqli_query($GLOBALS['dbinv'],$sql_dep);	
		$row_dep = mysqli_fetch_array($result_dep);
		
		$txtdep_name=$row_dep["DESCRIPTION"];
		
		$rtxtinvno = $_GET["txt_invno"];
		$txtcusvat = $_GET["vat1"];
		
		$rtxtrep = trim($_GET["Com_rep"]);
		$sql_rep="select * from s_salrep where REPCODE='" . trim($rtxtrep) . "'";
    	$result_rep =mysqli_query($GLOBALS['dbinv'],$sql_rep);	
		$row_rep = mysqli_fetch_array($result_rep);
		
		$rep_name=$row_rep["Name"];
		
		$rtxtSupCode = $_GET["txt_cuscode"];
		
		
		$rtxtSupName =str_replace("~", "&", $_GET["txt_cusname"]);  
		$txtadd =str_replace("~", "&", $_GET["txt_cusadd"]);  
		
		$rtxtdate = date("Y-m-d", strtotime($_GET["dtdate"]));
		
		$sql_brndmas="select * from brand_mas where barnd_name='" . trim($_GET["cmbbrand"]) . "'";
    	$result_brndmas =mysqli_query($GLOBALS['dbinv'],$sql_brndmas);	
		if ($row_brndmas = mysqli_fetch_array($result_brndmas)){
			if (is_null($row_brndmas["class"])==false) { $InvClass = trim($row_brndmas["class"]); }
		}	
		
		$sql_rsbr="select * from br_trn where Rep='" . trim($_GET["Com_rep"]) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($_GET["txt_cuscode"]) . "'";
    	$result_rsbr =mysqli_query($GLOBALS['dbinv'],$sql_rsbr);	
		if ($row_rsbr = mysqli_fetch_array($result_rsbr)){

    		if (is_null($row_rsbr["CAT"])==false) { $cuscat = trim($row_rsbr["CAT"]); }
			if ($cuscat == "A") { $m = 2.5; }
    		if ($cuscat == "B") { $m = 2.5; }
    		if ($cuscat == "C") { $m = 1; }
    		$rtxlimit= ($row_rsbr["credit_lim"] * $m);
		} else {
    		$rtxlimit= "0";
		}
		
		$rtxout = str_replace(",", "", $_GET["OutInvAmt"]);
		$rtxrtnchq = str_replace(",", "", $_GET["OutREtAmt"]);
		$crebal = str_replace(",", "", $_GET["txt_crebal"]);
		$net = str_replace(",", "", $_GET["txt_net"]);

		
		if ($crebal < $net) {
    		$limex = $net - $crebal;
    		$rtxexlmt = $limex;
		} else {
    		$limex = $net - $crebal;
    		$rtxexlmt = number_format(0, 2, ".", ",");
		}

		//echo "crebal-".$crebal."/net-".$net."/rtxexlmt".$rtxexlmt;
		
		$sql_rs_ven="Select * From vendor where CODE = '" . trim($_GET["txt_cuscode"]) . "'";
    	$result_rs_ven =mysqli_query($GLOBALS['dbinv'],$sql_rs_ven);	
		if ($row_rs_ven = mysqli_fetch_array($result_rs_ven)){
			if (is_null($row_rs_ven["acno"])==false) {
        		$rtxagree = $row_rs_ven["acno"];
    		} else {
        		$rtxagree = "Agreement Not Signed";
    		}
		}
		
		$d=date("Y-m-d");
		
		$date = date('Y-m-d',strtotime($d.' -60 days'));
		
		$sql_rssal="Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE = '" . trim($_GET["txt_cuscode"]) . "' and (SDATE < '" . $date . "' or SDATE = '" . $date . "') and GRAND_TOT - TOTPAY > 1 and CANCELL = '0'";
		
    	$result_rssal =mysqli_query($GLOBALS['dbinv'],$sql_rssal);	
		if ($row_rssal = mysqli_fetch_array($result_rssal)){

			if (is_null($row_rssal["out1"])==false) { 
				$rtxover60 = $row_rssal["out1"];
			}
		}
		$rtxrtnpd = str_replace(",", "", $_GET["OutpDAMT"]);
    
	?>
<table width="922" height="494" border="0">
  <tr>
    <td height="45" colspan="2">&nbsp;</td>
    <td colspan="4" align="center" valign="top"><span class="style4">AD FORM</span></td>
    <td width="244">&nbsp;</td>
  </tr>
  
  <tr>
    <td width="94" height="21">&nbsp;</td>
    <td width="87"><?php echo $rtxtSupCode; ?></td>
    <td colspan="3" ><?php echo $rtxtSupName; ?></td>
    <td width="175"><?php echo $txtdep."  ".$txtdep_name; ?></td>
    <td><?php echo $rtxtinvno; ?></td>
    <td width="6">&nbsp;</td>
  </tr>
  <tr>
    <td height="21" colspan="2">&nbsp;</td>
    <td colspan="4"><span class="style2"><?php echo $txtadd; ?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="21" colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="21" colspan="2">&nbsp;</td>
    <td colspan="2"><?php echo $txtcusvat; ?></td>
    <td width="164"><span class="style2"><b><?php  echo "&nbsp;&nbsp;&nbsp;&nbsp;". $rep_name; ?></b></span></td>
    <td>&nbsp;</td>
    <td><?php echo $rtxtdate; ?></td>
  </tr>
  
  <tr>
    <td height="87" colspan="7" valign="top"><table border="1" cellpadding="0" cellspacing="0"><tr><td valign="top"><table width="900" height="81" border="0" cellspacing="0">
      <tr  bgcolor="#999999">
        <td width="100" height="30"><span class="style1">Stock No</span></td>
        <td width="400"><span class="style1">Description</span></td>
        <td width="50" align="right"><span class="style1">Qty</span></td>
        <td width="100" align="right"><span class="style1">PRICE</span></td>
        <td width="120" align="right"><span class="style1">Discount (%)</span></td>
        <td width="130" align="right"><span class="style1">Sub Total</span></td>
        </tr>
      <?php 
	  	$sql_rsPrInv="SELECT * from s_adtrn where REF_NO= '" . trim($_GET["txt_invno"]) . "'  order by id";
		
		$totdis=0;
    	$result_rsPrInv =mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv);	
		while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)){	
			echo "<tr height=\"30\"><td><span class=\"style2\">".$row_rsPrInv["STK_NO"]."</span></td>
			<td><span class=\"style2\">".$row_rsPrInv["DESCRIPT"]."</span></td>
			<td  align=\"right\"><span class=\"style2\">".number_format($row_rsPrInv["QTY"], 0, ".", ",")."</span></td>
			<td align=\"right\"><span class=\"style2\">".number_format($row_rsPrInv["PRICE"], 2, ".", ",")."</span></td>
			<td align=\"right\"><span class=\"style2\">".number_format($row_rsPrInv["DIS_per"], 2, ".", ",")."</span></td>";
			
			$dis=($row_rsPrInv["PRICE"]*$row_rsPrInv["QTY"])-($row_rsPrInv["PRICE"]*$row_rsPrInv["QTY"]*$row_rsPrInv["DIS_per"]/100);
			echo "<td align=\"right\"><span class=\"style2\">".number_format($dis, 2, ".", ",")."</span></td></tr>";
			
			$totdis=$totdis+$dis;
		}	
	  	
		$tax=0;
		
		$final_total=0;
		if ((trim($_GET["tax"])!="") and ($_GET["tax"]>0) and ($_GET["tax"]!="0.00")){
			$tax=$totdis*0.12;
			echo "<tr><td colspan=5></td><td align=right><b>".number_format($totdis, 2, ".", ",")."</b></td></tr>";
			echo "<tr><td colspan=4></td><td>VAT 12%</td><td align=right><b>".number_format($tax, 2, ".", ",")."</b></td></tr>";
			$tot=$totdis+$tax;
			$final_total=$tot;
			echo "<tr><td colspan=5></td><td align=right><b><u>".number_format($tot, 2, ".", ",")."</u></b></td></tr>";
		}	else {
			echo "<tr><td colspan=5></td><td align=right><b><u>".number_format($totdis, 2, ".", ",")."</u></b></td></tr>";
			$final_total=$totdis;
		}
		
	   ?>
      
     
      
    </table></td></tr></table></td>
  </tr>
  <tr>
    <td height="83" colspan="2" valign="bottom">_______________________</td>
    <td width="119">&nbsp;</td>
    <td colspan="2" valign="bottom">________________________</td>
    <td>&nbsp;</td>
    <td valign="bottom">__________________________</td>
  </tr>
  <tr>
    <td height="21" colspan="2">Entered By </td>
    <td>&nbsp;</td>
    <td colspan="2">Sales Person</td>
    <td>&nbsp;</td>
    <td>Authorized By</td>
  </tr>
  <tr>
    <td height="50" colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="7"><p class="style5"><strong>Customer agreed to following Terms &amp; Conditions</strong></p>
    <p class="style5">1. If no written complaint received within three days from the date hereof, final Computer generated invoice will be issued by us.</p>
    <p class="style5">2. If you do not receive the computer generated invoice from us within next 14 days, please contact us directly. Tel 011 5445400.</p>
    <p class="style5">3. <strong>Benedictsons (Pvt) Limited </strong>reserve the rights to take the appropriate legal action within the jurisdiction for Colombo District to recover in full if invoiced amount contained herein is not settled.</p>
    <p class="style5">4. This advice of dispatch shall be a valid legal instrument.</p></td>
  </tr>
  <tr>
    <td height="50" colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
