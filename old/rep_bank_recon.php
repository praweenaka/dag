<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Bank Reconsilation</title>
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
	font-size: 18px;
}

.heading {
	color: #000000;
	font-weight: bold;
	font-size: 16px;
}

body {
	color: #000000;
	font-size: 14px;
}


-->
</style>
</head>

<body><center>
<?php 
include('connectioni.php');

$sql_rs="select sum(l_amount) as mcre  from ledger where rights='0' and  l_flag1 ='CRE' and (l_flag != 'opb') and l_code='" . trim($_GET["txtBankCode"]) . "'   and l_flag2 = '0'  and l_date <= '" . $_GET["dtpDate"] . "'";
$result_rs=mysqli_query($GLOBALS['dbinv'],$sql_rs, $dbacc);
if ($row_rs = mysqli_fetch_array($result_rs)){
	if (is_null($row_rs["mcre"])==false) { $mCre = $row_rs["mcre"]; }
}

$sql_rs="select sum(l_amount) as mcre  from ledger where rights='0' and  l_flag1 !='CRE' and (l_flag != 'opb') and l_code='" . trim($_GET["txtBankCode"]) . "'   and l_flag2 = '0'  and l_date <= '" . $_GET["dtpDate"] . "' ";
$result_rs=mysqli_query($GLOBALS['dbinv'],$sql_rs, $dbacc);
if ($row_rs = mysqli_fetch_array($result_rs)){
	if (is_null($row_rs["mcre"])==false) { $mDeb = $row_rs["mcre"]; }
}








$txthead= "BANK RECONCILIATION AS AT " . date("Y-m-d", strtotime($_GET["dtpDate"]));

$sql_rscompany="Select * from dep_mas";
$result_rscompany=mysqli_query($GLOBALS['dbinv'],$sql_rscompany, $dbacc);
$row_rscompany = mysqli_fetch_array($result_rscompany);

$txtcom = $row_rscompany["description"];
$txtBank= $_GET["txtBankCode"];

if ($_GET["txtBankClosBal"] < 0) {
   $txtBankBal= "(" . abs($_GET["txtBankClosBal"]) . ")";
} else {
   $txtBankBal= $_GET["txtBankClosBal"];
}


$mTot = $_GET["txtBankClosBal"] + $mDeb - $mCre;
if ($mTot < 0) {
   $txtbalChbook="(" . abs($mTot) . ")";
} else {
   $txtbalChbook=$mTot;
}

$txtbot= "Balance as per Cash Book as at " . date("Y-m-d", $_GET["dtpDate"]);

$sql_rsBANKMASTER="select * from bankmaster where  bm_code='" . trim($_GET["txtBankCode"]) . "'";
$result_rsBANKMASTER=mysqli_query($GLOBALS['dbinv'],$sql_rsBANKMASTER, $dbacc);
if ($row_rsBANKMASTER = mysqli_fetch_array($result_rsBANKMASTER)){
   $txtBank= " : " . $row_rsBANKMASTER["bm_code"] . ", " . $row_rsBANKMASTER["bm_bank"];
   $txtbrnach= " : " . $row_rsBANKMASTER["bm_branch"];
   $txtaccno= " : " . trim($row_rsBANKMASTER["bm_accno"]);
}

$txtopdate= date("Y-m-d", strtotime($_GET["dtfrom"]));
if ($_GET["txt_bankbal"] < 0) {
   $txtopbal= "(" . abs($_GET["txt_bankbal"]) . ")";
} else {
   $txtopbal= $_GET["txt_bankbal"];
}

if ($_GET["txtbankpay"] < 0) {
   $txtadd= "(" . abs($_GET["txtbankpay"]) . ")";
} else {
   $txtadd= $_GET["txtbankpay"];
}
if ($_GET["txtbankdepo"] < 0) {
   $txtless= "(" . abs($_GET["txtbankdepo"]) . ")";
} else {
   $txtless= $_GET["txtbankdepo"];
}

$txtclosebal=str_replace(",", "", $_GET["txtclosebal"]);
if ($txtclosebal <= 0) {
   $txtclosebal= "(" . abs($txtclosebal) . ")";
} else {
   $txtclosebal= "" . abs($txtclosebal) . "";
}

$txtclosedate= date("Y-m-d", $_GET["dtpDate"]);
	?>
    
<table width="922" height="723" border="0">
  <tr>
    <td colspan="4" align="center"><span class="companyname">Tyre House Trading (Pvt) Ltd. </span></td>
  </tr>
  <tr>
    <td width="186"><span class="heading">BANK</span></td>
    <td width="358"><span class="heading"><?php echo $txtbank; ?></span></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td><span class="heading">BRANCH</span></td>
    <td><span class="heading"><?php echo $txtbrnach; ?></span></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td><span class="heading">ACCOUNT NO</span></td>
    <td><span class="heading"><?php echo $txtaccno; ?></span></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="152" align="center">    </td>
    <td align="center"></td>
  </tr>
  <tr>
    <td width="186" height="21" colspan="4"><span class="heading"><?php echo $txthead; ?></span></td>
  </tr>
  <tr>
    <td height="21" colspan="4"><span class="heading">BALANCE AS PER BANK STATEMENT</span></td>
  </tr>
  <tr>
    <td height="21" colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="208">&nbsp;</td>
  </tr>
  <tr>
    <td height="21" colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td height="199" colspan="4"><?php
	$DEB_amt=0;
	$CRE_amt=0;
	
	
	
	echo "<table width=\"904\" height=\"81\" border=\"1\" cellspacing=\"0\">
		<tr >
        <th colspan=4 align=left>Less: Un-Presented Cheques</th>
		</tr>
      	<tr  bgcolor=\"#999999\">
        <th width=\"70\" height=\"23\">Date</th>
        <th width=\"100\">Chq. No</th>
        <th width=\"445\">Description</th>
        <th width=\"100\" >Amount</th>
        </tr>";
		
	$sql_rsPrInv="select * from ledger where rights='0' and  (l_flag != 'opb') and l_code='" . trim($_GET["txtBankCode"]) . "'   and l_flag2 = '0'  and l_date <= '" . $_GET["dtpDate"] . "' and l_flag1='DEB' order by l_flag1 desc, l_date ";
	$result_rsPrInv=mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv, $dbacc);
	  	while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)){
			echo "<tr><td>".$row_rsPrInv["l_date"]."</td>
			<td>".$row_rsPrInv["chno"]."</td>
			<td>".$row_rsPrInv["l_lmem"]."</td>
			<td align=right>".number_format($row_rsPrInv["l_amount"], 2, ".", ",")."</td>
			</tr>";
			
			$DEB_amt=$DEB_amt+$row_rsPrInv["l_amount"];
		
		}
		echo "<tr><td colspan=3>&nbsp;</td>
			<td align=right>".number_format($DEB_amt, 2, ".", ",")."</td>
			</tr>";
	 	
	
	
	echo "<table width=\"904\" height=\"81\" border=\"1\" cellspacing=\"0\">
		<tr >
        <th colspan=4 align=left>Less: Un-Presented Cheques</th>
		</tr>
      	<tr  bgcolor=\"#999999\">
        <th width=\"70\" height=\"23\">Date</th>
        <th width=\"100\">Chq. No</th>
        <th width=\"445\">Description</th>
        <th width=\"100\">Amount</th>
        </tr>";
		
	$sql_rsPrInv="select * from ledger where rights='0' and  (l_flag != 'opb') and l_code='" . trim($_GET["txtBankCode"]) . "'   and l_flag2 = '0'  and l_date <= '" . $_GET["dtpDate"] . "' and l_flag1='CRE' order by l_flag1 desc, l_date ";
	$result_rsPrInv=mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv, $dbacc);
	  	while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)){
			echo "<tr><td>".$row_rsPrInv["l_date"]."</td>
			<td>".$row_rsPrInv["chno"]."</td>
			<td>".$row_rsPrInv["l_lmem"]."</td>
			<td  align=right>".number_format($row_rsPrInv["l_amount"], 2, ".", ",")."</td>
			</tr>";
			
			$CRE_amt=$CRE_amt+$row_rsPrInv["l_amount"];
		
		}
		echo "<tr><td colspan=3>&nbsp;</td>
			<td align=right>".number_format($CRE_amt, 2, ".", ",")."</td>
			</tr>";
	  
	   ?>  
  <tr>
    <td height="72" colspan="4">&nbsp;</td>
  <tr>
    <td height="72" colspan="3">Balance As per Cash Book as at</td>
    <td height="72" align="right"><b><?php echo number_format(($DEB_amt-$CRE_amt), 2, ".", ","); ?></b></td>
  <tr>
    <td height="72" colspan="4"><p>Summrized Bank Account</p>
    <fieldset>
      <table width="559" border="0">
        <tr>
          <td colspan="2" scope="col"><strong>Opening Balance as At </strong></td>
          <td width="149" scope="col">&nbsp;</td>
          <td width="245" scope="col"><?php echo $txtopbal; ?></td>
        </tr>
        <tr>
          <td width="94">&nbsp;</td>
          <td colspan="2">Add :-  Payment Cash Book</td>
          <td><?php echo $txtadd; ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">Less :- Receipt Cash Book </td>
          <td><?php echo $txtless; ?></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Closing Balance As At</strong></td>
          <td>&nbsp;</td>
          <td><?php echo $txtclosebal; ?></td>
        </tr>
      </table>
      </fieldset>      
    <p>&nbsp;</p>              </td>
  <tr>
    <td height="199" colspan="4">
</table>
</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
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
</body>
</html>
