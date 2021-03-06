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
	
    require_once("connectioni.php");
	
	
    
    $sql="delete from tmpstk";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
			



	if ($_GET["brand"] == "All"){ $sql_rst= "select * from s_mas";}
	if ($_GET["brand"] != "All"){ $sql_rst= "select * from s_mas where BRAND_NAME='".$_GET["brand"]."'";}
	$result_rst =mysqli_query($GLOBALS['dbinv'],$sql_rst);
	echo $sql_rst;
	while ($row_rst = mysqli_fetch_array($result_rst)){
	
    	if ($_GET["department"] == "All") {
        	$sql_rdPrBin = "select * from s_trn where (SDATE <  '".$_GET["dte_from"]."' or SDATE =  '".$_GET["dte_from"]."') and STK_NO='".$row_rst["STK_NO"]."' and LEDINDI <> 'GINR' and LEDINDI <> 'GINI' and LEDINDI <> 'VGI' and LEDINDI <> 'VGR'   ORDER BY SDATE";
    	} else {
        	$sql_rdPrBin = "select *from s_trn where  (SDATE < '".$_GET["dte_from"]."' or SDATE =  '".$_GET["dte_from"]."') and STK_NO='".$row_rst["STK_NO"]."' and DEPARTMENT='".$_GET["department"]."' ORDER by SDATE";
    	}
    	
		$result_rdPrBin =mysqli_query($GLOBALS['dbinv'],$sql_rdPrBin);
		$reccount = mysqli_num_rows($result_rdPrBin);
    	$row_rdPrBin = mysqli_fetch_array($result_rdPrBin);
		echo "$reccount".$reccount;
    	 
    
	}
   
   $sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
		
		echo "<center><table border=1><tr>
		<th>Item</th>
		<th>Description</th>
		<th>Part No</th>
		<th></th>
		<th></th>
		<th></th>
		</tr>";
		//echo $sql;
		$i=0;
		$sql_report="select * from tmpstk where QTYINHAND > 0 and TOTCOST > 0";
		$result_report =mysqli_query($GLOBALS['dbinv'],$sql_report);
		while ($row = mysqli_fetch_array($result_report)){
			
			
				echo "<tr>";
				echo "<td>".$row["STK_NO"]."</td>";
				echo "<td>".$row["DESCRIPT"]."</td>";
				echo "<td>".$row["PARTNO"]."</td>";
				echo "<td align=right>".$row["QTYINHAND"]."</td>";
				echo "<td align=right>".number_format($row["COST"], 2, ".", ",")."</td>";
				echo "<td align=right>".number_format($row["TOTCOST"], 2, ".", ",")."</td>";
				
				$QTYINHAND=$QTYINHAND+$row["QTYINHAND"];
				$TOTCOST=$TOTCOST+$row["TOTCOST"];
				
				echo "</tr>";
				$brand=$row["brand"];
				
		}
		
		echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td align=right><b>".number_format($QTYINHAND, 2, ".", ",")."</b></td>";
				echo "<td></td>";
				echo "<td align=right><b>".number_format($TOTCOST, 2, ".", ",")."</b></td>";
				echo "</tr>";
				
		echo "<table>";
		
  
	
	
   

?>
</body>
</html>
