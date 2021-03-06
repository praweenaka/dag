<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<style>
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
font-size:11px;

}
</style>

</head>

<body>
	<?php
	
    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmpvari";
	$result =$db->RunQuery($sql);
	
if ($_GET["chkitem"] != "on"){
	if ($_GET["brand"] == "All"){ $sql_rst= "Select * from s_mas where COST>0";}
	if ($_GET["brand"] != "All"){ $sql_rst= "select * from s_mas where COST>0 and BRAND_NAME='".$_GET["brand"]."'";}
	$result_rst =$db->RunQuery($sql_rst);
	while ($row_rst = mysql_fetch_array($result_rst)){
		$sql_rst1 = "select sum(QTY) as qty  from stk_take where STK_NO='".$row_rst["STK_NO"]."'";
   		$result_rst1 =$db->RunQuery($sql_rst1);
		$row_rst1 = mysql_fetch_array($result_rst1);
		
        if (!is_null($row_rst1["qty"])){
            $stk_count = $row_rst1["qty"];
        } else {
            $stk_count = 0;
        }
        
        $sql_rst1 = "select sum(QTY) as qty  from stk_take_undelever where STK_NO='".$row_rst["STK_NO"]."'";
		$result_rst1 =$db->RunQuery($sql_rst1);
		$row_rst1 = mysql_fetch_array($result_rst1);
		
        if (!is_null($row_rst1["qty"])){
            $stk_undeliver = $row_rst1["qty"];
        } else {
            $stk_undeliver = 0;
        }
            
        if ($row_rst["QTYINHAND"] != $stk_count){
			
        	$STK_NO = $row_rst["STK_NO"];
        	$descript = $row_rst["descript"];
        	$PART_NO = $row_rst["PART_NO"];
        	$QTYINHAND = $row_rst["QTYINHAND"];
        	$cost = $row_rst["acc_cost"];
        	$vari = $stk_count - $row_rst["QTYINHAND"] - $stk_undeliver;
        	$undeli = $stk_undeliver;
        
			$sql_temp="Insert into tmpvari(STK_NO, descript, PART_NO, QTYINHAND, cost, vari, stk_count, undeli) values ('".$STK_NO."', '".$descript."', '".$PART_NO."', ".$QTYINHAND.", ".$cost.", ".$vari.", ".$stk_count.", ".$undeli.")";
			$result_temp =$db->RunQuery($sql_temp);
		}
	}
}	
	
if ($_GET["chkitem"] == "on"){
	$sql="select itemcode, name from tmpitem";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		$sql_rst = "Select * from s_mas where COST>0 and STK_NO='".$row["itemcode"]."' ";
		$result_rst =$db->RunQuery($sql_rst);
		$row_rst = mysql_fetch_array($result_rst);
		
		$sql_rst1 = "select sum(QTY) as qty  from stk_take where STK_NO='".$row["itemcode"]."'";
		$result_rst1 =$db->RunQuery($sql_rst1);
		$row_rst1 = mysql_fetch_array($result_rst1);
		
		if (!is_null($row_rst1["qty"])){
			$stk_count = $row_rst1["qty"];
		} else {
			$stk_count = 0;
		}
		
		if ($sql_rst["QTYINHAND"] != $stk_count){
			$STK_NO = $row_rst["STK_NO"];
        	$descript = $row_rst["descript"];
        	$PART_NO = $row_rst["PART_NO"];
        	$QTYINHAND = $row_rst["QTYINHAND"];
        	$cost = $row_rst["acc_cost"];
        	$vari = $stk_count - $row_rst["QTYINHAND"];
        	        
			$sql_temp="Insert into tmpvari(STK_NO, descript, PART_NO, QTYINHAND, cost, vari, stk_count) values ('".$STK_NO."', '".$descript."', '".$PART_NO."', ".$QTYINHAND.", ".$cost.", ".$vari.", ".$stk_count.")";
			$result_temp =$db->RunQuery($sql_temp);
		}
		
	}
}

		$heading = "Stock Variation Report Brand ".$_GET["brand"];
		
		$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>Item</th>
		<th>Description</th>
		<th>Part No</th>
		<th>Qty</th>
		<th>U. Deli</th>
		<th>Count</th>
		<th>Vari</th>
		<th>Cost</th>
		<th>Sort Value</th>
		<th>Excess Value</th>
		</tr>";
		//echo $sql;
		$totsort_val=0;
		$totexceed_val=0;
			
		$sql="select * from tmpvari where vari!=0";
		$result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result)){	
			echo "<tr>
			<td>".$row["STK_NO"]."</td>
			<td>".$row["descript"]."</td>
			<td>".$row["PART_NO"]."</td>
			<td align=\"right\">".$row["QTYINHAND"]."</td>
			<td align=\"right\">".number_format($row["undeli"], 2, ".", ",")."</td>
			<td align=\"right\">".$row["stk_count"]."</td>
			<td align=\"right\">".$row["vari"]."</td>
			<td align=\"right\">".number_format($row["cost"], 2, ".", ",")."</td>";
			
			$sort_val=0;
			$exceed_val=0;
			
			if ($row["QTYINHAND"]>0){
				$sort_val=$row["QTYINHAND"]*$row["cost"];
				$totsort_val=$totsort_val+$sort_val;
			} else {
				$exceed_val=$row["vari"]*$row["cost"];
				$totexceed_val=$totexceed_val+$exceed_val;
			}	
			echo "<td align=\"right\">".number_format($sort_val, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($exceed_val, 2, ".", ",")."</td>
			
			</tr>";
			
			
		}
		
		echo "<tr>
			<td colspan=8>&nbsp;</td>
			
			<td align=\"right\">&nbsp;</td>
			<td align=\"right\"><b>".number_format($totexceed_val-$totsort_val, 2, ".", ",")."</b></td>
			</tr>";
			
		echo "<tr>
			<td colspan=8>&nbsp;</td>
			
			<td align=\"right\"><b>".number_format($totsort_val, 2, ".", ",")."</b></td>
			<td align=\"right\"><b>".number_format($totexceed_val, 2, ".", ",")."</b></td>
			</tr>";
			
		echo "<table>";
	
	echo "<b>Total Variation : ".number_format($totexceed_val-$totsort_val, 2, ".", ",")."</b>";
   

?>
</body>
</html>
