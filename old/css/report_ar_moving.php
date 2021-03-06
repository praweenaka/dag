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
 <!-- Progress bar holder -->
<div id="progress" style="width:500px;border:1px solid #ccc;"></div>
<!-- Progress information -->
<div id="information" style="width"></div>

<?php

    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmpstkmve";
	$result =$db->RunQuery($sql);
	

 
if ($_GET["brand"]!="All"){	
	$sql_smas="select * from s_mas  where   BRAND_NAME='".$_GET['brand']."'";
} else {	
	$sql_smas="select * from s_mas";
}

$result_smas =$db->RunQuery($sql_smas);
while($row_smas = mysql_fetch_array($result_smas)){
	$sql_purtrn="select * from s_purtrn where STK_NO='".$row_smas["STK_NO"]."' and CANCEL=0 ORDER BY ID DESC";
	$balqty = $row_smas["QTYINHAND"];
  	$soldover = "false";
	$result_purtrn =$db->RunQuery($sql_purtrn);
	while($row_purtrn = mysql_fetch_array($result_purtrn)){
		if (($balqty > 0) or ($soldover!="false")) {
     
        	if ($row_purtrn["REC_QTY"] > $balqty){
          		$soldqty = $row_purtrn["REC_QTY"] - $balqty;
          		$balqty = 0;
          		$soldover = "true";
        	} else {
          		$soldqty = 0;
          		$balqty = $balqty - $row_purtrn["REC_QTY"];
          		$soldover = "false";
        	}
        
     	} else {
        	$soldqty = $row_purtrn["REC_QTY"];
        	$soldover = "true";
     	}
  		$brand = $row_smas["BRAND_NAME"];
		$days = (strtotime(date("Y-m-d")) - strtotime($row_purtrn["SDATE"]) ) / (60 * 60 * 24);
  		
		$str_update="update s_purtrn set soldqty=".$soldqty.", brand=".$brand.", days=".$days;
		$result_update =$db->RunQuery($str_update);
	}
}
 

$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>AR Date</th>
		<th>AR No</th>
		<th>Supplier</th>
		<th>Ar Value Rs.</th>
		<th>Sold Amount</th>
		<th>Sold %</th>
		<th>Balance Amount</th>
		<th>Balance %</th>
		<th>Period</th>
		</tr>";
		//echo $sql;
		$totgross=0;
		$totvat=0;
		$totnet=0;
		
if ($_GET["brand"] = "All"){
       $sql1 = "SELECT distinct REFNO, SDATE, SUP_NAME  from viewpur where days>".$_GET["txtover"]." or days=".$_GET["txtover"];
} else {
       $sql1 = "SELECT distinct REFNO, SDATE, SUP_NAME from viewpur where brand='".$_GET["brand"]."' and (days>".$_GET["txtover"]." or days=".$_GET["txtover"]." )";
}

if ($_GET["brand"] = "All"){
       $sql2 = "SELECT sum(REC_QTY*COST) as arval, sum(soldqty*COST) as soldamount  from viewpur where days>".$_GET["txtover"]." or days=".$_GET["txtover"];
} else {
       $sql2 = "SELECT * from viewpur where brand='".$_GET["brand"]."' and (days>".$_GET["txtover"]." or days=".$_GET["txtover"]." )";
}

$totbalamou=0;
		$result1 =$db->RunQuery($sql1);
		while($row1 = mysql_fetch_array($result1)){ 
		
			$sql=$sql2." and REFNO ='".$row1["REFNO"]."'";		
		echo $sql;
		  $result =$db->RunQuery($sql);
		  while($row = mysql_fetch_array($result)){ 
			echo "<tr>
			<td>".$row["SDATE"]."</td>
			<td>".$row["REFNO"]."</td>
			<td>".$row["SUP_NAME"]."</td>";
			
			
			echo "<td align=\"right\">".$row["arval"]."</td>";
			echo "<td align=\"right\">".number_format($row["soldamount"], 2, ".", ",")."</td>";
			
			if ($row["arval"]>0) { 
				$sold_p=$row["soldamount"]/$row["arval"]*100;
			}
			echo "<td align=\"right\">".number_format($sold_p, 2, ".", ",")."</td>";
			
			if ($row["arval"]>$row["soldamount"]) {
				$balamou=$row["arval"]-$row["soldamount"];
			} else {
				$balamou=$row["arval"];
			}	

			$totbalamou=$totbalamou+$balamou;
			
			echo "<td align=\"right\">".number_format($balamou, 2, ".", ",")."</td>";
			
			$bal_p=100-$sold_p;
			echo "<td align=\"right\">".number_format($bal_p, 2, ".", ",")."</td>";
						
			$diff = abs(strtotime($row1["SDATE"]) - strtotime(date("Y-m-d")));
			$days = floor($diff / (60*60*24));
	
			
			echo "<td align=\"right\">".$days."</td>
			</tr>";
		  }	
		
		}
		
		echo "<tr>
			<td colspan=6>&nbsp;</td>
			
			<td align=\"right\"><b>".number_format($totbalamou, 2, ".", ",")."</b></td>
			<td align=\"right\">&nbsp;</td>
			<td align=\"right\">&nbsp;</td>
			</tr>";
			
		echo "<table>";


?>


</body>
</html>
