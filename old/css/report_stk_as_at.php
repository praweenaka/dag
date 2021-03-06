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
    
    $sql="delete from tmpstk";
	$result =$db->RunQuery($sql);
	
			



	if ($_GET["brand"] == "All"){ $sql_rst= "select * from s_mas";}
	if ($_GET["brand"] != "All"){ $sql_rst= "select * from s_mas where BRAND_NAME='".$_GET["brand"]."'";}
	$result_rst =$db->RunQuery($sql_rst);
	echo $sql_rst;
	while ($row_rst = mysql_fetch_array($result_rst)){
	
    	if ($_GET["department"] == "All") {
        	$sql_rdPrBin = "select * from s_trn where (SDATE <  '".$_GET["dte_from"]."' or SDATE =  '".$_GET["dte_from"]."') and STK_NO='".$row_rst["STK_NO"]."' and LEDINDI <> 'GINR' and LEDINDI <> 'GINI' and LEDINDI <> 'VGI' and LEDINDI <> 'VGR'   ORDER BY SDATE";
    	} else {
        	$sql_rdPrBin = "select *from s_trn where  (SDATE < '".$_GET["dte_from"]."' or SDATE =  '".$_GET["dte_from"]."') and STK_NO='".$row_rst["STK_NO"]."' and DEPARTMENT='".$_GET["department"]."' ORDER by SDATE";
    	}
    	
		$result_rdPrBin =$db->RunQuery($sql_rdPrBin);
		$reccount = mysql_num_rows($result_rdPrBin);
    	$row_rdPrBin = mysql_fetch_array($result_rdPrBin);
		echo "$reccount".$reccount;
    	/*$qty = 0;
    	for ($i = 0; $reccount; $i++){
    		if (!is_null($row_rdPrBin["ID"])){
    
     			if (($row_rdPrBin["LEDINDI"] == "INV") or ($row_rdPrBin["LEDINDI"] == "GINI") or ($row_rdPrBin["LEDINDI"] == "ARR") or ($row_rdPrBin["LEDINDI"] == "IOU")){
    				$qty = $qty - $row_rdPrBin["qty"];
    			}
    
    
    			if (($row_rdPrBin["LEDINDI"] == "ARN") or ($row_rdPrBin["LEDINDI"] == "GINR") or ($row_rdPrBin["LEDINDI"] == "CRN") or ($row_rdPrBin["LEDINDI"] == "GRN") or ($row_rdPrBin["LEDINDI"] == "IIN")){
    				$qty = $qty + $row_rdPrBin["QTY"];
    			}
    
				if ($row_rdPrBin["LEDINDI"] == "TRN"){
    				$qty = $row_rdPrBin["QTY"];
    			}
    
     
    			$row_rdPrBin=mysql_fetch_assoc($result_artrn);
			}
    
    	}
    
   
    	if (!is_null($row_rst["acc_cost"])){
    		$costval = $row_rst["acc_cost"];
    	} else {
    		$costval = 0;
    	}
    
        if ($qty != 0) {
           $sql_insert = "Insert into tmpstk (STK_NO, DESCRIPT, PARTNO, COST, TOTCOST, QTYINHAND) values('".$row_rst["STK_NO"]."', '".$row_rst["DESCRIPT"]."', '".$row_rst["PART_NO"]."', ".$costval.", ".($costval * $qty).", ".$qty.")";
		   $result_insert =$db->RunQuery($sql_insert);
	
    	}*/
    
	}
   
   $sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
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
		$result_report =$db->RunQuery($sql_report);
		while ($row = mysql_fetch_array($result_report)){
			
			
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
