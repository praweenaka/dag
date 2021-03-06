<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Settlement Summery Report</title>
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
border:0px solid black ;
font-family:Arial, Helvetica, sans-serif;
padding:5px;
}
th
{
font-weight:bold;
font-size:12px;
border-bottom:dotted 1px black;

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
	
	



echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		echo "<center>Stock<br><br>";
		echo "<center><b>Invoice No : ".$_GET["refno"]."</b><br><br>";
		echo "<center>".$_GET["dtfrom"];
		
		echo "<center><table border=1><tr>
		<th>Stk No</th>
		<th>Description</th>
		<th>Part No</th>
		<th>Brand</th>
		<th>Qty</th>
		<th>Damage</th>
		<th>Cost</th>
		<th>Total Cost</th>
		</tr>";
		//echo $sql;
		//$sql=$sql." order by SDATE, ST_INVONO"; 
		//echo $sql;
		$sql = "SELECT * from stk_take_undelever where REF_NO= '" . trim($_GET["refno"]) . "'  order by id ";
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		while($row = mysqli_fetch_array($result)){	
			
			echo "<tr>
				<td>".$row["STK_NO"]."</td>
				<td>".$row["DESCRIPT"]."</td>
				<td>".$row["PART_NO"]."</td>
				<td>".$row["BRAND"]."</td>
				<td align=right>".$row["QTY"]."</td>
				<td align=right>".$row["damage"]."</td>
				<td align=right>".number_format($row["COST"], 2, ".", ",")."</td>
				<td align=right>".number_format(($row["QTY"]*$row["COST"]), 2, ".", ",")."</td></tr>";
				
				$qty=$qty+$row["QTY"];
				$damage=$damage+$row["damage"];
				$tot_cost=$tot_cost+($row["QTY"]*$row["COST"]);
		}		 
		 	
			
		echo "<tr>
				<th colspan=4>&nbsp;</th>
				<th align=right><b>".$qty."</b></th>
				<th align=right><b>".$damage."</b></th>
				<th>&nbsp;</th>
				<th align=right><b>".number_format($tot_cost, 2, ".", ",")."</b></th></tr>";
			
			
		echo "<table>";	

?>
</body>
</html>
