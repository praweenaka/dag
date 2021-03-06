<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dealer Incentive Summery</title>
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
-->

table
{
border-collapse:collapse;
}
table, td, th
{
border:0px solid black ;
font-family:Arial, Helvetica, sans-serif;
font-weight:normal;

padding:5px;
}
th
{
font-weight:bold;
font-size:14px;
border-top:dotted 1px black;

}
td
{
font-size:14px;
font-weight:bold;

}
</style>
</head>
<?php

	require_once("connectioni.php");
	
	
	

	include('connectioni.php');

	$sql_inv = "select * from dealer_inc_summery";
	$result_inv=mysqli_query($GLOBALS['dbinv'],$sql_inv);  
	$row_inv= mysqli_fetch_array($result_inv);	
	
	$txt_tot=str_replace(",", "", $_GET["txt_tot"]);
	
	$rtxsale = $_GET["tot_sale"] / (1 + ($_GET["txt_vat"] / 100));
	$rtxgrn = $_GET["tot_grn"] / (1 + ($_GET["txt_vat"] / 100));
	$rtxnsale = ($_GET["tot_sale"] - $_GET["tot_grn"]) / (1 + ($_GET["txt_vat"] / 100));
	$rtxnpaysales = ($_GET["tot_sale"] - $txt_tot) / (1 + ($_GET["txt_vat"] / 100));
	$rtxpaysales = $_GET["txttotal"];
	$rtxper = $_GET["txt_percentage"];
	$rtxincen = $_GET["txtnetin"];
	$rtxcode = $_GET["txt_cuscode"];
	$rtxname = str_replace("~", "&", $_GET["txt_cusname"]);
	$txtinamount = $_GET["txttot_inc"];

?>
<body><center>
<table width="1000" border="0">
  <tr>
    <td colspan="5" align="center"><span class="style1">DEALER INCENTIVE SUMMERY</span></td>
  </tr>
  <tr>
    <td width="198">&nbsp;</td>
    <td width="28">&nbsp;</td>
    <td width="180">&nbsp;</td>
    <td width="285">&nbsp;</td>
    <td width="287">&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style1">Dealer</span></td>
    <td><strong>:</strong></td>
    <td><b><?php echo $rtxcode; ?></b></td>
    <td><b><?php echo $rtxname; ?></b></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Incentive Month</strong></td>
    <td><strong>:</strong></td>
    <td><b><?php echo date("M", strtotime($_GET["DTPicker1"]))." ".date("Y", strtotime($_GET["DTPicker1"])); ?></b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Total Sale</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $rtxsale; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Total GRN/CRN</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $rtxgrn; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Total Net Sale</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $rtxnsale; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Incen. Non Payble Sales</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo number_format($rtxnpaysales, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Incen. Payble Sales</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $rtxpaysales; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Calculated Incentive %</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $rtxper; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Incentive Amount</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $rtxincen; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="1000" border="1" cellspacing="0">
  <tr>
    <th>Ref. No</th>
    <th>Date /Deliver</th>
    <th>Amount</th>
    <th>Brand</th>
    <th>Chq/Cash Date</th>
    <th>Paid Amount</th>
    <th>Days</th>
    <th>Approved Days</th>
    <th>%</th>
    <th>Incentive Amount</th>
  </tr>
  <?php
  
 
  	$incentive=0;
	$i=0;
  	$sql = "select * from dealer_inc_summery order by inv_no";
	$result=mysqli_query($GLOBALS['dbinv'],$sql);
	while ($row= mysqli_fetch_array($result)){
		
		if ($row["inv_no"]!=$inv_no){
			echo "<tr>
    			<th>".$row["inv_no"]."</th>
			    <th align=right>".$row["sdate"]."</th>
			    <th align=right>".number_format($row["amount"], 2, ".", ",")."</th>
			    <th>".$row["brand"]."</th>";
				
		  $inv_no=$row["inv_no"];
		  	$i=0;
		}
		
		
		
		if ($i==0){
			echo "<th>".$row["rec_date"]."</th>
    		<th align=right>".number_format($row["paid"], 2, ".", ",")."</th>
    		<th align=right>".$row["days"]."</th>
    		<th align=right>".$row["apdays"]."</th>
    		<th align=right>".$rtxper."</th>
    		<th align=right>".number_format($row["incentive"], 2, ".", ",")."</th>
  		</tr>";
			$i=1;
		} else {
			echo "<tr>";
			echo "<td colspan=4>&nbsp;</td>";
			echo "<td align=center>".$row["rec_date"]."</td>
    		<td align=right>".number_format($row["paid"], 2, ".", ",")."</td>
    		<td align=right>".$row["days"]."</td>
    		<td align=right>".$row["apdays"]."</td>
    		<td align=right>".$rtxper."</td>
    		<td align=right>".number_format($row["incentive"], 2, ".", ",")."</td>
  		</tr>";
		}	
    		
		$incentive=$incentive+$row["incentive"];
	 }
	 echo "<tr>
    			<td colspan=9>&nbsp;</td>
				<td align=right><b>".number_format($incentive, 2, ".", ",")."</b></td>
			    </tr>";
				
	?> 	
</table>
<p>&nbsp;</p>
</body>
</html>
