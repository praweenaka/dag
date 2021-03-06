<?php ini_set('session.gc_maxlifetime', 30*60*60*60);
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Variation Report</title>

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
font-size:14px;

}
td
{
font-size:14px;

}
</style>

</head>

<body>
	<?php
	
    require_once("connectioni.php");
    
    $sql="delete from tmpvari";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
if ($_GET["chkitem"] != "on"){
	if ($_GET["brand"] == "All"){ $sql_rst= "Select * from s_mas where COST>0";}
	if ($_GET["brand"] != "All"){ $sql_rst= "select * from s_mas where COST>0 and BRAND_NAME='".$_GET["brand"]."'";}
	$result_rst =mysqli_query($GLOBALS['dbinv'],$sql_rst);
	while ($row_rst = mysqli_fetch_array($result_rst)){
		
		$stk_undeliver=0;
		$stk_count=0;
		$undeli=0;
		
		$sql_rst1 = "select sum(QTY) as qty  from stk_take where STK_NO='".$row_rst["STK_NO"]."'";
   		$result_rst1 =mysqli_query($GLOBALS['dbinv'],$sql_rst1);
		$row_rst1 = mysqli_fetch_array($result_rst1);
		
        if (!is_null($row_rst1["qty"])){
            $stk_count = $row_rst1["qty"];
        } else {
            $stk_count = 0;
        }
        
        $sql_rst1 = "select sum(QTY) as qty  from stk_take_undelever where STK_NO='".$row_rst["STK_NO"]."'";
		$result_rst1 =mysqli_query($GLOBALS['dbinv'],$sql_rst1);
		$row_rst1 = mysqli_fetch_array($result_rst1);
		
        if (!is_null($row_rst1["qty"])){
            $stk_undeliver = $row_rst1["qty"];
        } else {
            $stk_undeliver = 0;
        }
         
		$sql_rst1 = "select sum(damage) as damage  from stk_take where STK_NO='".$row_rst["STK_NO"]."'";
		//echo $sql_rst1;
   		$result_rst1 =mysqli_query($GLOBALS['dbinv'],$sql_rst1);
		$row_rst1 = mysqli_fetch_array($result_rst1);
		
		
		if ($row_rst1["damage"]>0){   
			
			$stk_damage = $row_rst1["damage"];
        	
			$STK_NO = $row_rst["STK_NO"];
        	$descript = $row_rst["DESCRIPT"];
        	$PART_NO = $row_rst["PART_NO"];
        	$QTYINHAND = $row_rst["QTYINHAND"];
			
			if ($_SESSION['dev']=='1'){	 
        		$cost = $row_rst["COST"];
			} else if ($_SESSION['dev']=='0'){	 
				$cost = $row_rst["acc_cost"];
			}
        	
			$vari = $stk_count - $row_rst["QTYINHAND"] - $stk_undeliver;
        	$undeli = $stk_undeliver;
        
			$sql_temp="Insert into tmpvari(STK_NO, descript, PART_NO, QTYINHAND, cost, vari, stk_count, undeli, damage) values ('".$STK_NO."', '".$descript."', '".$PART_NO."', ".$QTYINHAND.", ".$cost.", ".$vari.", ".$stk_count.", ".$undeli.", ".$stk_damage.")";
			//echo $sql_temp;
			$result_temp =mysqli_query($GLOBALS['dbinv'],$sql_temp);
		
        } else if ($row_rst["QTYINHAND"] != $stk_count){
			
        	$STK_NO = $row_rst["STK_NO"];
        	$descript = $row_rst["DESCRIPT"];
        	$PART_NO = $row_rst["PART_NO"];
        	$QTYINHAND = $row_rst["QTYINHAND"];
			
			if ($_SESSION['dev']=='1'){	 
        		$cost = $row_rst["COST"];
			} else if ($_SESSION['dev']=='0'){	 
				$cost = $row_rst["acc_cost"];
			}
        	$vari = $stk_count - $row_rst["QTYINHAND"] - $stk_undeliver;
        	$undeli = $stk_undeliver;
        
			$sql_temp="Insert into tmpvari(STK_NO, descript, PART_NO, QTYINHAND, cost, vari, stk_count, undeli) values ('".$STK_NO."', '".$descript."', '".$PART_NO."', ".$QTYINHAND.", ".$cost.", ".$vari.", ".$stk_count.", ".$undeli.")";
			$result_temp =mysqli_query($GLOBALS['dbinv'],$sql_temp);
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
        	$descript = $row_rst["DESCRIPT"];
        	$PART_NO = $row_rst["PART_NO"];
        	$QTYINHAND = $row_rst["QTYINHAND"];
			if ($_SESSION['dev']=='1'){	 
        		$cost = $row_rst["COST"];
			} else if ($_SESSION['dev']=='0'){	 
				$cost = $row_rst["acc_cost"];
			}	
        	$vari = $stk_count - $row_rst["QTYINHAND"];
        	        
			$sql_temp="Insert into tmpvari(STK_NO, descript, PART_NO, QTYINHAND, cost, vari, stk_count, damage) values ('".$STK_NO."', '".$descript."', '".$PART_NO."', ".$QTYINHAND.", ".$cost.", ".$vari.", ".$stk_count.", ".$row_rst1["damage"].")";
			$result_temp =$db->RunQuery($sql_temp);
		}
		
	}
}

		$heading = "Stock Variation Report Brand ".$_GET["brand"];
		
		$sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
		echo "<center><table border=1 width=\"1000\"><tr>
		<th align=left>Item</th>
		<th align=left>Description</th>
		<th align=left>Part No</th>
		<th  align=right>Qty</th>
		<th align=right>U. Deli</th>
		<th align=right>Count</th>
		<th align=right>Damage</th>
		<th align=right>Vari</th>
		<th align=right>Cost</th>
		<th align=right>Shortage Value</th>
		<th align=right>Excess Value</th>
		<th align=right>Damage Cost</th>
		</tr>";
		//echo $sql;
		$totsort_val=0;
		$totexceed_val=0;
			
		$sql="select * from tmpvari where vari!=0 or damage!=0";
		$result =mysqli_query($GLOBALS['dbinv'],$sql);
		while($row = mysqli_fetch_array($result)){	
			$damage_val=0;
			echo "<tr>
			<td align=\"left\">".$row["STK_NO"]."</td>
			<td align=\"left\">".$row["descript"]."</td>
			<td align=\"left\">".$row["PART_NO"]."</td>
			<td align=\"right\">".number_format($row["QTYINHAND"], 0, ".", ",")."</td>
			<td align=\"right\">".number_format($row["undeli"], 0, ".", ",")."</td>
			<td align=\"right\">".number_format($row["stk_count"], 0, ".", ",")."</td>
			<td align=\"right\">".number_format($row["damage"], 0, ".", ",")."</td>
			<td align=\"right\">".number_format($row["vari"], 0, ".", ",")."</td>
			
			<td align=\"right\">".number_format($row["cost"], 2, ".", ",")."</td>";
			
			$sort_val=0;
			$exceed_val=0;
			
			$tot_cost_val=$row["vari"]*$row["cost"];
			$damage_val=$row["damage"]*$row["cost"];
			/*if ($row["QTYINHAND"]>0){
				$sort_val=$row["QTYINHAND"]*$row["cost"];
				$totsort_val=$totsort_val+$sort_val;
			} else {
				$exceed_val=$row["vari"]*$row["cost"];
				$totexceed_val=$totexceed_val+$exceed_val;
			}*/
			
			if ($damage_val>0){
				$tot_damage_val=$tot_damage_val+$damage_val;
			}
			
			if ($tot_cost_val>0){
				$exceed_val=$tot_cost_val;
				$totexceed_val=$totexceed_val+$exceed_val;
				
			} else {
				$sort_val=$tot_cost_val;
				$totsort_val=$totsort_val+$sort_val;
			}
				
			echo "<td align=\"right\">".number_format((-1*$sort_val), 2, ".", ",")."</td>
			<td align=\"right\">".number_format($exceed_val, 2, ".", ",")."</td>
			<td align=\"right\">".number_format($damage_val, 2, ".", ",")."</td>
			
			</tr>";
			
			
		}
		
		
			
		echo "<tr>
			<td colspan=9>&nbsp;</td>
			
			<td align=\"right\"><b>".number_format((-1*$totsort_val), 2, ".", ",")."</b></td>
			<td align=\"right\"><b>".number_format($totexceed_val, 2, ".", ",")."</b></td>
			<td align=\"right\"><b>".number_format($tot_damage_val, 2, ".", ",")."</b></td>
			</tr>";
			
		echo "<table>";
	
	echo "<b>Total Variation : ".number_format($totexceed_val+$totsort_val, 2, ".", ",")."</b>";
   

?>
</body>
</html>
