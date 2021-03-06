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
-->
</style>
</head>

<body><center>
<?php 
require_once("connectioni.php");
	
	
	?>
    
    <?php
		
	
        
		
			$sql_invpara="SELECT * from invpara";
			$result_invpara =mysqli_query($GLOBALS['dbinv'],$sql_invpara);
			$row_invpara = mysqli_fetch_array($result_invpara);
			
			


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
		
		$txtRet_PDChq=0;
		$strsql = "Select sum(che_amount) as totchq_amount from s_invcheq where cus_code='" . trim($_GET["txt_cuscode"]) . "'  and che_date>'" . date("Y-m-d") . "' and sal_ex='" . trim($_GET["Com_rep"]) . "' and trn_type='RET' order by che_date";
		
		$result_rst2 =mysqli_query($GLOBALS['dbinv'],$strsql);
		$row_rst2 = mysqli_fetch_array($result_rst2);
		 
		$txtRet_PDChq=$row_rst2["totchq_amount"];
		
	?>
<table width="922" height="833" border="0">
  <tr>
    <td height="45" colspan="2">&nbsp;</td>
    <td colspan="4" align="center" valign="top"><span class="style4">OREDER FORM</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="56" align="center">    </td>
    <td colspan="3" align="center"><?php echo $txtdep."  ".$txtdep_name; ?></td>
    <td width="222">
      <?php echo $rtxtinvno; ?>    </td>
  </tr>
  <tr>
    <td width="95" height="21">&nbsp;</td>
    <td width="87"><?php echo $rtxtSupCode; ?></td>
    <td colspan="3" ><?php echo $rtxtSupName; ?></td>
    <td width="221">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="1">&nbsp;</td>
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
    <td width="204"><span class="style2"><b><?php  echo "&nbsp;&nbsp;&nbsp;&nbsp;". $rep_name; ?></b></span></td>
    <td>&nbsp;</td>
    <td><?php echo $rtxtdate; ?></td>
  </tr>
  
  <tr>
    <td height="164" colspan="7"><table border="1" cellpadding="0" cellspacing="0"><tr><td><table width="900" height="81" border="0" cellspacing="0">
      <tr  bgcolor="#999999">
        <td width="100" height="30"><span class="style1">Stock No</span></td>
        <td width="400"><span class="style1">Description</span></td>
        <td width="50" align="right"><span class="style1">Qty</span></td>
        <td width="100" align="right"><span class="style1">PRICE</span></td>
        <td width="120" align="right"><span class="style1">Discount (%)</span></td>
        <td width="130" align="right"><span class="style1">Sub Total</span></td>
        </tr>
      <?php 
	  	$sql_rsPrInv="SELECT * from print_repord where REF_NO= '" . trim($_GET["txt_invno"]) . "'  order by id";
		
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
			$tax=$totdis*$row_invpara["vatrate"]/100;
			echo "<tr><td colspan=5></td><td align=right><b>".number_format($totdis, 2, ".", ",")."</b></td></tr>";
			echo "<tr><td colspan=4></td><td>VAT ".$row_invpara["vatrate"]."%</td><td align=right><b>".number_format($tax, 2, ".", ",")."</b></td></tr>";
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
    <td height="94" colspan="2" valign="bottom">_______________________</td>
    <td>&nbsp;</td>
    <td colspan="2" valign="bottom">________________________</td>
    <td valign="bottom">__________________________</td>
    <td valign="bottom" align="right">_______________________</td>
  </tr>
  <tr>
    <td colspan="2"  align="center">Sales Person </td>
    <td>&nbsp;</td>
    <td colspan="2"  align="center">Marketing Manager</td>
    <td align="center">Authorized By 1</td>
    <td align="center">Authorized By 2</td>
  </tr>
  <tr>
    <td height="50" colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <?php
  
     $Out = 0;
    $pen = 0;
    $chq_rea = 0;
    $Ca_rea = 0;
    $R_chq = 0;
    $chno = 0;
    $RTNTOT = 0;



    $date = date("Y-m-d");
    $caldays = " - 90 days";
    $tmpdate = date('Y-m-d', strtotime($caldays));




    $sql_ch_rtn = mysqli_query($GLOBALS['dbinv'], "SELECT CR_CHNO, CR_CHEVAL from s_cheq where  (CR_DATE>'" . $tmpdate . "'or CR_DATE='" . $tmpdate . "')and (CR_DATE<'" . date("Y-m-d") . "'or CR_DATE='" . date("Y-m-d") . "') and CR_C_CODE = '" . trim($_GET['txt_cuscode']) . "' and CR_FLAG='0' ORDER BY CR_CHNO") or die(mysqli_error());
    while ($row_ch_rtn = mysqli_fetch_array($sql_ch_rtn)) {

        if ($row_ch_rtn["CR_CHNO"] == $chno) {
            
        } else {
            $chno = $row_ch_rtn["CR_CHNO"];
            $RTNTOT = $RTNTOT + $row_ch_rtn["CR_CHEVAL"];
        }
    }

    $date = date("Y-m-d");
    $caldays = " -97 days";
    $tmpdate97 = date('Y-m-d', strtotime($caldays));

    $date = date("Y-m-d");
    $caldays = " -7 days";
    $tmpdate7 = date('Y-m-d', strtotime($caldays));

    $sql_ch_rea = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as reatot from view_s_invcheq where cus_code='" . trim($_GET['txt_cuscode']) . "'  and ( che_date>'" . $tmpdate97 . "' or che_date ='" . $tmpdate97 . "')  and ( che_date<'" . $tmpdate7 . "' or che_date ='" . $tmpdate7 . "') and trn_type != 'RET'") or die(mysqli_error());
    $row_ch_rea = mysqli_fetch_array($sql_ch_rea);

    $date = date("Y-m-d");
    $caldays = " -7 days";
    $tmpdate90 = date('Y-m-d', strtotime($caldays));

    $sql_cash_rea = mysqli_query($GLOBALS['dbinv'], "select sum(CA_CASSH) as ca_reatot from s_crec where CA_CODE = '" . trim($_GET['txt_cuscode']) . "' and ( CA_DATE>'" . $tmpdate90 . "' or CA_DATE ='" . $tmpdate90 . "')  and ( CA_DATE<'" . date("Y-m-d") . "' or CA_DATE ='" . date("Y-m-d") . "') and CANCELL = '0' and FLAG = 'REC'") or die(mysqli_error());
    $row_cash_rea = mysqli_fetch_array($sql_cash_rea);

    $sql_ch_pen1 = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as pentot1 from view_s_invcheq where ch_count_ret='0' and cus_code='" . trim($_GET['txt_cuscode']) . "'  and ( che_date>'" . date("Y-m-d") . "' or che_date ='" . date("Y-m-d") . "')  and month(che_date) = '" . date("m") . "'") or die(mysqli_error());
    $row_ch_pen1 = mysqli_fetch_array($sql_ch_pen1);

    $sql_ch_pen2 = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as pentot2 from view_s_invcheq where ch_count_ret='0' and cus_code='" . trim($_GET['txt_cuscode']) . "'  and ( che_date>'" . date("Y-m-d") . "' or che_date ='" . date("Y-m-d") . "') ") or die(mysqli_error());
    $row_ch_pen2 = mysqli_fetch_array($sql_ch_pen2);

    $sql_salma = mysqli_query($GLOBALS['dbinv'], "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE='" . trim($_GET['txt_cuscode']) . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1") or die(mysqli_error());
    $row_salma = mysqli_fetch_array($sql_salma);

    $sql_c_rtn = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL - PAID) as Rtn from s_cheq where CR_C_CODE = '" . trim($_GET['txt_cuscode']) . "' and CR_FLAG = '0' and CR_CHEVAL - PAID > 1") or die(mysqli_error());

    $row_c_rtn = mysqli_fetch_array($sql_c_rtn);

		$month = date("m");
	$year = date("Y");
	
	$sql_ssalma = mysqli_query($GLOBALS['dbinv'], "select sum(GRAND_TOT/(1 +GST/100)) AS GRAND_TOT  from s_salma where c_code = '" . trim($_GET['txt_cuscode']) . "' and Accname != 'NON STOCK'  and month(sdate) ='" . $month . "' and year(SDATE)='" . $year . "' and CANCELL='0'");
	$row_ssalma = mysqli_fetch_array($sql_ssalma);

	$sql_scbal = mysqli_query($GLOBALS['dbinv'], "select sum(AMOUNT/(1 +vatrate/100)) as AMOUNT,SDATE,SAL_EX,brand,cuscode  from c_bal where  cuscode = '" . trim($_GET['txt_cuscode']) . "' and  month(SDATE)='" . $month . "' and year(SDATE)='" . $year . "'  and CANCELL='0' and trn_type!='ARN' and trn_type!='REC'and trn_type!='DGRN' and trn_type!='INC' and trn_type!='PAY' and flag1 != '1'");
	$row_scbal = mysqli_fetch_array($sql_scbal);	
	
	$dt = date('Y-m-d');
	$caldays = " +1 month";
	$dt2 = date('Y-m-t', strtotime($caldays));
	
	$dt1m = (date("m", strtotime($dt2)));
	$dt1y = (date("Y", strtotime($dt2)));
	$dt1 = $dt1y . "-" . $dt1m . "-01"; 
	
	
	//echo "SELECT sum(che_amount) as pentot3 from view_s_invcheq where ch_count_ret='0' and cus_code='" . trim($_GET['txt_cuscode']) . "'  and che_date>='" . $dt1 . "' and che_date<='" . $dt2 . "' ";
	$sql_ch_pen3 = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as pentot3 from view_s_invcheq where ch_count_ret='0' and cus_code='" . trim($_GET['txt_cuscode']) . "'  and che_date>='" . $dt1 . "' and che_date<='" . $dt2 . "'   ") or die(mysqli_error());
    $row_ch_pen3 = mysqli_fetch_array($sql_ch_pen3);
	

	$sal=0;
	if (is_null($row_ssalma["GRAND_TOT"]) == false) {
        $sal = $row_ssalma["GRAND_TOT"];
    }
	
	if (is_null($row_scbal["AMOUNT"]) == false) {
        $sal = $sal - $row_scbal["AMOUNT"];
    }
		
	
	
    if (is_null($row_salma["out1"]) == false) {
        $Out = $row_salma["out1"];
    }
    if (is_null($row_ch_pen2["pentot2"]) == false) {
        $pen = $row_ch_pen2["pentot2"];
    }
	if (is_null($row_ch_pen3["pentot3"]) == false) {
        $pen1 = $row_ch_pen3["pentot3"];
    }
    if (is_null($row_ch_rea["reatot"]) == false) {
        $chq_rea = $row_ch_rea["reatot"];
    }
    if (is_null($row_cash_rea["ca_reatot"]) == false) {
        $Ca_rea = $row_cash_rea["ca_reatot"];
    }
    if (is_null($row_c_rtn["Rtn"]) == false) {
        $R_chq = $row_c_rtn["Rtn"];
    }
  
  
  
   /*  echo  "<table cellpadding='0' cellspacing='0' border=1 width=1000>
        												<tr>
          												<td>Info Type</td>
         												<td>Amount</td>
          												</tr>";

    echo  "<tr><td></td><td>" .  . "</td></tr>
				<tr>	<td></td><td align=right>" . number_format(, 2, ".", ",") . "</td></tr>
				<tr>	<td></td><td align=right>" . number_format(, 2, ".", ",") . "</td></tr>
				<tr>	<td>Current Rtn Chqs</td><td align=right>" . number_format($R_chq, 2, ".", ",") . "</td></tr>
				<tr>	<td></td><td align=right>" . number_format($row_ch_pen1["pentot1"], 2, ".", ",") . "</td></tr>";

    echo "   </table>";   
  */
  
  ?>
  
  <tr>
    <td height="35" colspan="2">Credit Limit</td>
    <td colspan="2" align="right"><?php echo number_format($rtxlimit, 2, ".", ","); ?></td>
	<td>&nbsp;</td>
    <td>Last 3 Month Rtn Chqs</td>
    <td align=right><?php echo number_format($RTNTOT, 2, ".", ",") ?></td>
  </tr>
  <tr>
    <td height="35" colspan="2">Outstanding</td>
    <td colspan="2"  align="right"><?php 

	echo number_format($rtxout, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    <td>Last 3 Month Settlements</td>
	<td align=right><?php echo number_format(($chq_rea + $Ca_rea), 2, ".", ",") ?></td>
  </tr>
  <tr>
    <td height="35" colspan="2">Return Chqs</td>
    <td colspan="2" align="right"><?php echo number_format($rtxrtnchq, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    <td>Next 3 month Chqs to be realize</td>
	<td align=right><?php echo number_format(($Out + $pen), 2, ".", ",") ?></td>
  </tr>
  <tr>
    <td  height="35" colspan="2">PD Cheque Amount</td>
    <td colspan="2" align="right"><?php echo number_format($rtxrtnpd, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
	<td>Current month Pending Chqs</td>
    <td align=right><?php echo number_format($row_ch_pen1["pentot1"], 2, ".", ",") ?></td>
  </tr>
  <tr>
    <td height="35" colspan="2">PD Cheque for Return Chq</td>
    <td colspan="2" align="right"><?php echo number_format($txtRet_PDChq, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
	<td>Next Month PD Chqs</td>
    <td align=right><?php  echo number_format($pen1, 2, ".", ","); ?></td>
  </tr>
  <tr>
    <td height="35" colspan="2">Total Outstandigs</td>
    <td colspan="2" align="right"><?php 
	$tmprtnchp=str_replace(",", "", $_GET["OutREtAmt"]);
	$totout=$rtxout+$rtxrtnpd+$tmprtnchp;
	
	
	echo number_format($totout, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
	<td>Current Month Sales</td>
    <td align=right><?php  echo number_format($sal, 2, ".", ","); ?></td>
  </tr>
  <tr>
    <td height="35" colspan="2">Exceed Limit</td>
    <?php
		/*if ($rtxlimit-($rtxrtnpd+$rtxout)<0){
			$rtxexlmt=-1*($rtxlimit-($rtxrtnpd+$rtxout))+$totdis;
		} else {
			$rtxexlmt=$rtxlimit-($rtxrtnpd+$rtxout)+$totdis;
		}*/
		$bal_limit=$rtxlimit-$totout;
		if ($bal_limit>0){
			$bal1=$bal_limit-$final_total;
			
			if ($bal1>=0){
				$rtxexlmt=0;
			} else {
				$rtxexlmt=abs($bal1);
			}
		} else {
			
			$rtxexlmt=$final_total+($totout-$rtxlimit);
		}
	?>
    <td colspan="2" align="right"><?php echo number_format(abs($rtxexlmt), 2, ".", ","); ?></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="35" colspan="2">Agreement No</td>
    <td colspan="2" align="right"><?php echo $rtxagree; ?></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td height="35" colspan="2">Over 60 Days Outstandigs</td>
    <td colspan="2" align="right"><?php echo number_format($rtxover60, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  
  
  
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php



 
$AMOUNT=0;
$totbal=0;

 

echo "<table cellpadding='0' cellspacing='0' border=1 width=1000><tr>
	   <th colspan='2'>Tyre House Trading</th><th colspan='2'>Benedictsons</th></tr>";
	 
$GLOBALS['hostname'] = 'localhost';
$GLOBALS['username'] = 'root';
$GLOBALS['password'] = '';
$dbtht = mysqli_connect($GLOBALS['hostname'],$GLOBALS['username'],$GLOBALS['password'],'SWijesooriya_tht');
$dbben = mysqli_connect($GLOBALS['hostname'],$GLOBALS['username'],$GLOBALS['password'],'SWijesooriya_ben');
	 

$sql = "select * from vendor where code = '" . $_GET['txt_cuscode'] . "'";	

$result =mysqli_query($GLOBALS['dbinv'],$sql);
$row = mysqli_fetch_array($result);
$s_code = trim($row['commoncode']);
 
$limit =0;
$crLmt = "select * from br_trn where cus_code='" . trim($_GET["txt_cuscode"]) . "'";
$result_crLmt = mysqli_query($GLOBALS['dbinv'], $crLmt);
    while ($row_crLmt = mysqli_fetch_array($result_crLmt)) {
		$credit_lim = $row_crLmt["credit_lim"];	
        if (trim($row_crLmt["CAT"]) == "C") {
            $limit = $limit + $credit_lim;
        }
        if (trim($row_crLmt["CAT"]) == "B") {
            $limit = $limit + $credit_lim * 2.5;
        }
        if (trim($row_crLmt["CAT"]) == "A") {
            $limit = $limit + $credit_lim * 2.5;
        }
}
	

$crLmt = "select * from br_trn where cus_code='" . trim($s_code) . "'";
$limit_s=0;
	 	
	$result_crLmt = mysqli_query($dbben, $crLmt);
    while ($row_crLmt = mysqli_fetch_array($result_crLmt)) {
		$credit_lim = $row_crLmt["credit_lim"];	
        if (trim($row_crLmt["CAT"]) == "C") {
            $limit_s = $limit_s + $credit_lim;
        }
        if (trim($row_crLmt["CAT"]) == "B") {
            $limit_s = $limit_s + $credit_lim * 2.5;
        }
        if (trim($row_crLmt["CAT"]) == "A") {
            $limit_s = $limit_s + $credit_lim * 2.5;
        }
}
	 
echo "<tr>
	   <th colspan='2'>Credit Limit :" .  number_format($limit, 2, ".", ",")     . "</th><th colspan='2'>Credit Limit : " .   number_format($limit_s, 2, ".", ",")   . "</th></tr>";
	 

$sql ="Select sum(grand_tot - totpay) as outs from s_salma where c_code = '" . trim($_GET["txt_cuscode"])  .  "' and grand_tot > totpay and cancell = '0' ";	
$result_to =mysqli_query($GLOBALS['dbinv'],$sql);
$row_to = mysqli_fetch_array($result_to);

$sql ="Select sum(grand_tot - totpay) as outs from s_salma where c_code = '" . trim($s_code)  .  "' and grand_tot > totpay and cancell = '0' ";
$result_bo =mysqli_query($dbben,$sql);
$row_bo = mysqli_fetch_array($result_bo);
	 
	 
	 
 echo "<tr>
	   <th>Outstandings   </th><th>" .  number_format($row_to['outs'], 2, ".", ",")     . "</th><th>Outstandings</th><th>" .   number_format($row_bo['outs'], 2, ".", ",")   . "</th></tr>";
	 	  	

$sql ="Select sum(cr_cheval-paid) as outs from s_cheq where cr_c_code = '" . trim($_GET["txt_cuscode"])  ."' and cr_cheval > paid and cr_flag = '0'";	
$result_tr =mysqli_query($GLOBALS['dbinv'],$sql);
$row_tr = mysqli_fetch_array($result_tr);

$sql ="Select sum(cr_cheval-paid) as outs from s_cheq where cr_c_code = '" . trim($s_code)   ."' and cr_cheval > paid and cr_flag = '0'";
$result_br =mysqli_query($dbben,$sql);
$row_br = mysqli_fetch_array($result_br);			
	 
 echo "<tr>
	   <th>Return Cheqs    </th><th>" .   number_format($row_tr['outs'], 2, ".", ",")     . "</th><th>Return Cheqs </th><th>" .   number_format($row_br['outs'], 2, ".", ",")    . "</th></tr>";
	 	  	



$sql ="Select sum(che_amount) as outs from S_INVCHEQ where cus_code = '" . trim($_GET["txt_cuscode"])  . "' and che_date > '" .  date('Y-m-d')  . "'";	
$result_tc =mysqli_query($GLOBALS['dbinv'],$sql);
$row_tc = mysqli_fetch_array($result_tc);

$sql ="Select sum(che_amount) as outs from S_INVCHEQ where cus_code = '" . trim($s_code)   . "' and che_date > '" .  date('Y-m-d') .    "'";
$result_bc =mysqli_query($dbben,$sql);
$row_bc = mysqli_fetch_array($result_bc);	
			
 echo "<tr>
	   <th>Pending Cheqs    </th><th>" . number_format($row_tc['outs'], 2, ".", ",")    . "</th><th>Pending Cheqs </th><th>" .  number_format($row_bc['outs'], 2, ".", ",")   . "</th></tr>";
	 	  	
 
$mtht = $row_to['outs'] + $row_tr['outs'] + $row_tc['outs'];

$mben = $row_bo['outs'] + $row_br['outs'] + $row_bc['outs'];
 
 echo "<tr>
	   <th>Total  </th><th>" .  number_format($mtht, 2, ".", ",")     . "</th><th>Total </th><th>" .   number_format($mben, 2, ".", ",")   . "</th></tr>";
 
  
   

  

 echo "</table>";
 
 echo "<center><h2>Total Group Exporture : " . number_format(($mtht+$mben), 2, ".", ",");




?>


</body>



</html>
