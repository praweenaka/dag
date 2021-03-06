<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bin Card Print</title>
<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
}
table
{
border-collapse:collapse;
}
table, td, th
{
border:1px solid black;
font-family:Arial, Helvetica, sans-serif;
padding:5px;
}
th
{
font-weight:bold;
font-size:12px;

}
td
{
font-size:12px;

}
</style>
<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
	font-size: 24px;
}
-->
</style>
</head>

<body>
 <!-- Progress bar holder -->


<?php

	require_once("connectioni.php");
	
	
	
	
	echo "<table width=\"1000\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
  <tr>
    <td width=\"100\"><b>Ref No</b></td>
    <td width=\"80\"><b>Date</b></td>
    <td width=\"100\"><b>LC No</b></td>
    <td width=\"500\"><b>Supplier Name</b></td>
    <td width=\"70\"><b>Order Qty</b></td>
    <td width=\"70\"><b>Rec. Qty</b></td>";
	
	
	$sql_per="select * from view_userpermission where username='".$_SESSION["UserName"]."' and docname='Bin Card'";
	$result_per =mysqli_query($GLOBALS['dbinv'],$sql_per);
	$row_per = mysqli_fetch_array($result_per);
	
	if ($row_per['price_edit']=='1') {
	echo "<td width=\"70\"><b>FOB</b></td>";		
	echo "<td width=\"70\"><b>Acc Cost</b></td>";
	} elseif ($row_per['doc_mod']=='1') {
		echo " <td width=\"70\"><b>FOB</b></td>";
	}
	echo "<td width=\"70\"><b>Selling</b></td>
   
  </tr>";
  
	
       
	   $sql = "select REFNO, SDATE, LCNO, SUP_NAME, O_QTY As OrderQty, REC_QTY As RecQty, FOB, acc_cost, COST, SELLING FROM viewpur WHERE STK_NO='" . trim($_GET["invno"]) . "' and CANCEL='0' order by REFNO";

	   $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	   while($row = mysqli_fetch_array($result)){
	   		
			echo "<tr>
    <td>".$row["REFNO"]."</td>
    <td>".$row["SDATE"]."</td>
	<td>".$row["LCNO"]."</td>
	<td>".$row["SUP_NAME"]."</td>
	<td>".number_format($row["OrderQty"], 0, ".", ",")."</td>
    <td>".number_format($row["RecQty"], 0, ".", ",")."</td>";
	if ($row_per['price_edit']=='1') {
		echo "<td>".number_format($row["FOB"], 2, ".", ",")."</td>";
		echo "<td>".number_format($row["acc_cost"], 2, ".", ",")."</td>";
	} elseif ($row_per['doc_mod']=='1') {
		echo "<td>".number_format($row["FOB"], 2, ".", ",")."</td>";
	}
	echo "<td>".number_format($row["SELLING"], 2, ".", ",")."</td>
	</tr>";
	
	   }
       		
	
  echo "</table>";

	


?>



</body>
</html>
