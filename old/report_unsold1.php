<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Unsold Report</title>
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
 <!-- Progress bar holder -->
<!-- Progress information -->
<div id="information" style="width"></div>

<?php

    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
	$balqty=0;
	
    $sql="delete from tmparmove";
	$result =$db->RunQuery($sql);
	
	if ($_GET["brand"]=="All"){
		$sql="select * from s_mas where QTYINHAND> 0 ";
	} else { 
		$sql="select * from s_mas where QTYINHAND> 0 and BRAND_NAME='".$_GET["brand"]."'";
	}
	
	$result =$db->RunQuery($sql);
	while($row = mysql_fetch_array($result)){
		$balqty=$row["QTYINHAND"];	
		$sqlpur="select * from s_purtrn where STK_NO='".$row["STK_NO"]."' and CANCEL='0' order by SDATE desc ";
		
		$resultpur =$db->RunQuery($sqlpur);
		$rowpur = mysql_fetch_array($resultpur);
		
		while ($balqty != 0){
			
			if (!is_null($rowpur["STK_NO"])){
				
				$SDATE=$rowpur["SDATE"];
				$REFNO=$rowpur["REFNO"];
				$rec_qty=$rowpur["REC_QTY"];
				
				$sqlpurmas="select * from s_purmas where REFNO='".$rowpur["REFNO"]."'";
				$resultpurmas =$db->RunQuery($sqlpurmas);
				if ($rowpurmas = mysql_fetch_array($resultpurmas)){
					$SUP_NAME=$rowpurmas["SUP_NAME"];
					$LCNO=$rowpurmas["LCNO"];
				}
				$ARVALUE=$rowpur["COST"]*$rowpur["REC_QTY"];
				$period = (strtotime(date("Y-m-d")) - strtotime($rowpur["SDATE"]) ) / (60 * 60 * 24);
				
				$sold=0;
				$UN_QTY=0;
							
				if ($balqty > $rowpur["REC_QTY"]){
                    $monsales = 0;
                    $UN_QTY = $rowpur["REC_QTY"];
                    $sold = $rowpur["acc_cost"];
                    $balqty = $balqty - $rowpur["REC_QTY"];
                    $rowpur=mysql_fetch_assoc($resultpur);
                } else {
                   
					$date = $rowpur["SDATE"];
					$date = strtotime(date("Y-m-d", strtotime($date)) . " +30 days");
					$caldate= date("Y-m-d", $date);
					
					$sqls_invo="select QTY from s_invo where STK_NO='".$row["STK_NO"]."' and CANCELL='0' and (SDATE>'".$rowpur["SDATE"]."' or SDATE='".$rowpur["SDATE"]."') and SDATE<'".$caldate."'";
					$results_invo =$db->RunQuery($sqls_invo);
					
					$salqty = 0;
					while ($rows_invo = mysql_fetch_array($results_invo)){
                    	$salqty = $salqty + $rows_invo["QTY"];
                    }
					
                    $UN_QTY = $balqty;
                    $monsales = $rowpur["acc_cost"] * ($salqty - $rowpur["QTYINHAND"]);
                    $sold = $rowpur["acc_cost"];
                    $balqty = 0;
                    
                }
				
				
				//if (is_null($UN_QTY)){ $UN_QTY=0; }
				//if (is_null($rec_qty)){ $rec_qty=0; }
				
				$sqltmp="insert into tmparmove(ardate, AR_NO, STK_NO, des, PART_NO, qty_hnd, AR_QTY, brand, SUPPLIER, LC_NO, ARVALUE, period, monsales, UN_QTY, sold) values ('".$SDATE."', '".$REFNO."', '".$row["STK_NO"]."', '".$row["DESCRIPT"]."', '".$row["PART_NO"]."', ".$row["QTYINHAND"].", ".$rec_qty.", '".$row["BRAND_NAME"]."', '".$SUP_NAME."', '".$LCNO."', ".$ARVALUE.", ".$period.", ".$monsales.", ".$UN_QTY.", ".$sold.") ";
				//echo $sqltmp;
				$resulttmp =$db->RunQuery($sqltmp);
				
			} else {
				exit();
			}
		}
	}



if ($_GET["qbrand"]=="All"){$sql="select * from tmparmove order by STK_NO";}
if ($_GET["qbrand"]=="Over"){$sql="select * from tmparmove where period>".$_GET["over"]." order by STK_NO ";}
if ($_GET["qbrand"]=="Between"){$sql="select * from tmparmove where period>".$_GET["over"]." and period<".$_GET["between"]." order by STK_NO";}	

$result =$db->RunQuery($sql);
while ($rows = mysql_fetch_array($result))
{
	if ($rows["period"] < 31) { $b30 = $b30 + $rows["UN_QTY"] * $rows["sold"]; }
	if (($rows["period"] > 30) and ($rows["period"] < 46)) { $o36b45 = $o36b45 + $rows["UN_QTY"] * $rows["sold"]; }
	if (($rows["period"] > 45) and ($rows["period"] < 61)) { $o46b60 = $o46b60 + $rows["UN_QTY"] * $rows["sold"]; }
	if (($rows["period"] > 60) and ($rows["period"] < 76)) { $o61b75 = $o61b75 + $rows["UN_QTY"] * $rows["sold"]; }
	if (($rows["period"] > 75) and ($rows["period"] < 91)) { $o76b91 = $o76b91 + $rows["UN_QTY"] * $rows["sold"]; }
	if ($rows["period"] > 90) {$o91 = $o91 + $rows["UN_QTY"] * $rows["sold"]; }
	if ((!is_null($rows["sold"])) and (!is_null($rows["UN_QTY"]))){$total = $total + $rows["UN_QTY"] * $rows["sold"]; }
}

if ($_GET["unsold"]=="details")
{
	
		$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
	echo "<center>".date("Y-m-d")."<center>Un Sold Stock Report</center><br>";
	echo "<center><table border=1><tr>
		<th>Stock No</th><th>Description</th><th>Part No</th><th>Qty In Ha</th><th>No of Days</th><th>Un Sold Stock</th><th>L/C No</td>
		<th>AR Date</th><th>AR No</th><th>AR Qty</th><th>Total Value</th><th>Cost Value</th><th>Unsold Value</th></tr>";
$brand="";	
  //mysql_data_seek($result, 0);	
 //echo $sql;
 $result =$db->RunQuery($sql);
  while ($rows = mysql_fetch_array($result)){
  	
	if ($brand!=$rows["brand"]){	
  		echo "<tr>
		<td align=\"left\" colspan=13><b>".$rows["brand"]."</b></td></tr>";
		$brand=$rows["brand"];
	}
	echo "<tr>";
	echo "<td>".$rows["STK_NO"]."</td>";
	echo "<td>".$rows["des"]."</td>";
	echo "<td>".$rows["PART_NO"]."</td>";
	echo "<td align=\"right\">".$rows["qty_hnd"]."</td>";
	echo "<td>".$rows["period"]."</td>";
	echo "<td align=\"right\">".$rows["UN_QTY"]."</td>";
	echo "<td>".$rows["LC_NO"]."</td>";
	echo "<td>".$rows["ardate"]."</td>";
	echo "<td>".$rows["AR_NO"]."</td>";
	echo "<td align=\"right\">".$rows["AR_QTY"]."</td>";
	echo "<td align=\"right\">".number_format($rows["ARVALUE"], 2, ".", ",")."</td>";
	echo "<td align=\"right\">".$rows["sold"]."</td>";
	echo "<td align=\"right\">".number_format($rows["sold"]*$rows["UN_QTY"], 2, ".", ",")."</td>";
	echo "</tr>";
  }	
 echo "</table>";
}

if ($_GET["unsold"]=="stock")
{
	$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
	echo "<center><table border=1><tr>
		<th>Stock No</th><th>Description</th><th>Part No</th><th>Stock</th><th>No of Days</th><th>Un Sold Stock</th>
		<th>AR Date</th><th>AR Qty</th><th>Unsold Value</th></tr>";
	
	if ($_GET["qbrand"]=="All"){$sql="select distinct brand from tmparmove";}
	if ($_GET["qbrand"]=="Over"){$sql="select distinct brand from tmparmove where period>".$_GET["over"]."  ";}
	if ($_GET["qbrand"]=="Between"){$sql="select distinct brand from tmparmove where period>".$_GET["over"]." and period<".$_GET["between"]."";}	
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){	
		$unsold_val_tot=0;
		echo "<tr><td>&nbsp;</td><td><b>".$rows["brand"]."</b></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		
		if ($_GET["qbrand"]=="All"){$sql1="select distinct STK_NO from tmparmove where brand='".$rows["brand"]."'";}
		if ($_GET["qbrand"]=="Over"){$sql1="select distinct STK_NO from tmparmove where period>".$_GET["over"]." and brand='".$rows["brand"]."' ";}
		if ($_GET["qbrand"]=="Between"){$sql1="select distinct STK_NO from tmparmove where period>".$_GET["over"]." and period<".$_GET["between"]." and brand='".$rows["brand"]."'";}	
		$result1 =$db->RunQuery($sql1);
		while ($rows1 = mysql_fetch_array($result1)){
			//$sql2="select sum(UN_QTY) as stock from tmparmove where brand='".$rows["brand"]."' and STK_NO='".$rows1["STK_NO"]."' ";
			//$result2 =$db->RunQuery($sql2);
			//$rows2 = mysql_fetch_array($result2);
			
			$sql3="select * from tmparmove where brand='".$rows["brand"]."' and STK_NO='".$rows1["STK_NO"]."' ";
			$result3 =$db->RunQuery($sql3);
			$rows3 = mysql_fetch_array($result3);
				
	
		echo "<tr><td>".$rows1["STK_NO"]."</td><td>".$rows3["des"]."</td><td>".$rows3["PART_NO"]."</td><td>".$rows3["qty_hnd"]."</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
			
			//mysql_data_seek($result3, 0);
			$result3 =$db->RunQuery($sql3);
			while ($rows4 = mysql_fetch_array($result3))
			{	
				echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>".$rows4["period"]."</td><td>".$rows4["UN_QTY"]."</td><td>".$rows4["ardate"]."</td><td>".$rows4["AR_QTY"]."</td><td align=\"right\">".$rows4["sold"]*$rows4["UN_QTY"]."</td></tr>";
				$unsold_val_tot=$unsold_val_tot+$rows4["sold"]*$rows4["UN_QTY"];
			}
			
		}
		echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>".$unsold_val_tot."</b></td></tr>";
	}
	echo "</table>";
		
}

if ($_GET["unsold"]=="summery")
{
	$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		echo "<center>".date("Y-m-d")."<center>Un Sold Stock Report</center><br>";
		
	echo "<center><table border=1 cellpadding=\"5\" cellspacing=\"0\"><tr>
		<th>Brand</th><th>Bellow 60</th><th>60 to 90</th><th>90 to 120</th><th>Over 120</th><th>Total Stock</th>
		<th>Total Over 90</th><th>%</th></tr>";
	
	$bellow60_tot=0;
	$bet60_90_tot=0;
	$bet90_120_tot=0;
	$over120_tot=0;
	$totstk_tot=0;
	$totover90_tot=0;
	
	if ($_GET["qbrand"]=="All"){$sql="select distinct brand from tmparmove";}
	if ($_GET["qbrand"]=="Over"){$sql="select distinct brand from tmparmove where period>".$_GET["over"]."  "; }
	if ($_GET["qbrand"]=="Between"){$sql="select distinct brand from tmparmove where period>".$_GET["over"]." and period<".$_GET["between"]."";}	
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){	
		
		if ($_GET["qbrand"]=="All"){$sql="select sum(UN_QTY * sold) as bellow60 from tmparmove where  brand='".$rows["brand"]."' and period < 61";}
		if ($_GET["qbrand"]=="Over"){$sql="select sum(UN_QTY * sold) as bellow60 from tmparmove where  brand='".$rows["brand"]."' and period < 61  and period>".$_GET["over"]."  "; }
		if ($_GET["qbrand"]=="Between"){$sql="select sum(UN_QTY * sold) as bellow60 from tmparmove where  brand='".$rows["brand"]."' and period < 61 and (period>".$_GET["over"]." and period<".$_GET["between"].")";}	

		$result1 =$db->RunQuery($sql);
		$rows1 = mysql_fetch_array($result1);
		$bellow60=$rows1["bellow60"];
		if (is_null($bellow60)){$bellow60=0;}	
		
		if ($_GET["qbrand"]=="All"){$sql="select sum(UN_QTY * sold) as bet60_90 from tmparmove where  brand='".$rows["brand"]."' and (period > 60 and period < 91)";}
		if ($_GET["qbrand"]=="Over"){$sql="select sum(UN_QTY * sold) as bet60_90 from tmparmove where  brand='".$rows["brand"]."' and (period > 60 and period < 91)  and period>".$_GET["over"]."  "; }
		if ($_GET["qbrand"]=="Between"){$sql="select sum(UN_QTY * sold) as bet60_90 from tmparmove where  brand='".$rows["brand"]."' and (period > 60 and period < 91) and (period>".$_GET["over"]." and period<".$_GET["between"].")";}	
		$result1 =$db->RunQuery($sql);
		$rows1 = mysql_fetch_array($result1);
		$bet60_90=$rows1["bet60_90"];
		if (is_null($bet60_90)){$bet60_90=0;}	
		
		if ($_GET["qbrand"]=="All"){$sql="select sum(UN_QTY * sold) as bet90_120 from tmparmove where  brand='".$rows["brand"]."' and (period > 90 and period < 121)";}
		if ($_GET["qbrand"]=="Over"){$sql="select sum(UN_QTY * sold) as bet90_120 from tmparmove where  brand='".$rows["brand"]."' and (period > 90 and period < 121)  and period>".$_GET["over"]."  "; }
		if ($_GET["qbrand"]=="Between"){$sql="select sum(UN_QTY * sold) as bet90_120 from tmparmove where  brand='".$rows["brand"]."' and (period > 90 and period < 121) and (period>".$_GET["over"]." and period<".$_GET["between"].")";}	
		$result1 =$db->RunQuery($sql);
		$rows1 = mysql_fetch_array($result1);
		$bet90_120=$rows1["bet90_120"];	
		if (is_null($bet90_120)){$bet90_120=0;}
		
		if ($_GET["qbrand"]=="All"){$sql="select sum(UN_QTY * sold) as over120 from tmparmove where  brand='".$rows["brand"]."' and period > 120";}
		if ($_GET["qbrand"]=="Over"){$sql="select sum(UN_QTY * sold) as over120 from tmparmove where  brand='".$rows["brand"]."' and period > 120  and period>".$_GET["over"]."  "; }
		if ($_GET["qbrand"]=="Between"){$sql="select sum(UN_QTY * sold) as over120 from tmparmove where  brand='".$rows["brand"]."' and period > 120 and (period>".$_GET["over"]." and period<".$_GET["between"].")";}	
		$result1 =$db->RunQuery($sql);
		$rows1 = mysql_fetch_array($result1);
		$over120=$rows1["over120"];	
		if (is_null($over120)){$over120=0;}
		
		$totstk=$bellow60+$bet60_90+$bet90_120+$over120;
		$totover90=$bet90_120+$over120;
		
		$bellow60_tot=$bellow60_tot+$bellow60;
		$bet60_90_tot=$bet60_90_tot+$bet60_90;
		$bet90_120_tot=$bet90_120_tot+$bet90_120;
		$over120_tot=$over120_tot+$over120;
		$totstk_tot=$totstk_tot+$totstk;
		$totover90_tot=$totover90_tot+$totover90;
	
		echo "<tr><td align=\"right\">".$rows["brand"]."</td><td align=\"right\">".number_format($bellow60, 2, ".", ",")."</td><td align=\"right\">".number_format($bet60_90, 2, ".", ",")."</td><td align=\"right\">".number_format($bet90_120, 2, ".", ",")."</td><td align=\"right\">".number_format($over120, 2, ".", ",")."</td><td align=\"right\">".number_format($totstk, 2, ".", ",")."</td><td align=\"right\">".number_format($totover90, 2, ".", ",")."</td><td align=\"right\">100.00</td></tr>";
	}
	
	echo "<tr><td align=\"right\">$nbsp</td><td align=\"right\"><b>".number_format($bellow60_tot, 2, ".", ",")."</b></td><td align=\"right\"><b>".number_format($bet60_90_tot, 2, ".", ",")."</b></td><td align=\"right\"><b>".number_format($bet90_120_tot, 2, ".", ",")."</b></td><td align=\"right\"><b>".number_format($over120_tot, 2, ".", ",")."</b></td><td align=\"right\"><b>".number_format($totstk_tot, 2, ".", ",")."</b></td><td align=\"right\"><b>".number_format($totover90_tot, 2, ".", ",")."</b></td><td align=\"right\"><b>100.00</b></td></tr>";
	
}

?>


</body>
</html>
