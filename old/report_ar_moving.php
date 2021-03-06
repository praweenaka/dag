<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AR Moving Report</title>

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

    require_once("connectioni.php");
	
	
    
   // $sql="delete from tmpstkmve";
	//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
	if ($_GET["brand"]=="All"){	
		$sql_smas = "select * from s_mas ";
	}	
	if ($_GET["brand"]!="All"){	
		$sql_smas = "select * from s_mas  where   BRAND_NAME='" . $_GET["brand"] . "'";
	}	
	
	$result_smas =mysqli_query($GLOBALS['dbinv'],$sql_smas);
	while($row_smas = mysqli_fetch_array($result_smas)){

  		$sql_purtrn = "sElect * from s_purtrn where STK_NO='" . trim($row_smas["STK_NO"]) . "'  and cancel=0 ORDER BY REFNO DESC";
  		
		$balqty = $row_smas["QTYINHAND"];
  		$soldover = false;
		
  		$result_purtrn =mysqli_query($GLOBALS['dbinv'],$sql_purtrn);
		while($row_purtrn = mysqli_fetch_array($result_purtrn)){
  
     		if (($balqty > 0) or  (!$soldover)){
     
        		if ($row_purtrn["REC_QTY"] >= $balqty) {
					$soldqty=$row_purtrn["REC_QTY"] - $balqty;
					
          			$sql_update="update s_purtrn set soldqty=".$soldqty." where id = '" . $row_purtrn['ID']  . "'";
					$result_update =mysqli_query($GLOBALS['dbinv'],$sql_update);
					
					 
          			$balqty = 0;
          			$soldover = true;
        		} else {
					$sql_update="update s_purtrn set soldqty=0 where  id = '" . $row_purtrn['ID']  . "'";
					$result_update =mysqli_query($GLOBALS['dbinv'],$sql_update);
			
          			$balqty = $balqty - $row_purtrn["REC_QTY"];
          			$soldover = false;
        		}
        
     		} else {
				
				$sql_update="update s_purtrn set soldqty=".$row_purtrn["REC_QTY"]." where  id = '" . $row_purtrn['ID']  . "'";
				$result_update =mysqli_query($GLOBALS['dbinv'],$sql_update);
      
        		$soldover = true;
     		}
			 
			
			$date1 = $row_purtrn["SDATE"];
			$date2 = date("Y-m-d");
			$diff = abs(strtotime($date2) - strtotime($date1));
			$days = floor($diff / (60*60*24));
				
			$sql_update="update s_purtrn set brand=".$row_smas["BRAND_NAME"].", days=".$days."  where id = '" . $row_purtrn['ID']  . "'";
			$result_update =mysqli_query($GLOBALS['dbinv'],$sql_update);
 
			$sql_update="update s_purmas set brand=".$row_smas["BRAND_NAME"]." where refno = '" . $row_purtrn['REFNO']   . "'";
			$result_update =mysqli_query($GLOBALS['dbinv'],$sql_update);
 
  		}
  	}








		$sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>AR Date</th>
		<th>Item</th>
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
		
		if ($_GET["brand"]=="All"){	
   			$sql1 = "SELECT * from viewpur where days>=" . $_GET["txtover"]." order by REFNO";
		} else {
   			$sql1= "SELECT * from viewpur where brand='" . trim($_GET["brand"]) . "' and days>=" .$_GET["txtover"]." order by REFNO";
		}
		$totbalamou=0;
		//echo $sql1;
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
		while($row = mysqli_fetch_array($result1)){ 
		
		 
			
			
			$arval = $row['acc_cost'] * $row['REC_QTY'];
			$soldamount = $row['acc_cost'] * $row['soldqty'];
			
			
			
			if ($arval>0) { 
				$sold_p=$soldamount/$arval*100;
			} else {
				$sold_p=0;
			}
			
			
			if ($arval>=$soldamount) {
				$balamou=$arval-$soldamount;
			} else {
				$balamou=$arval;
			}	

			$totbalamou=$totbalamou+$balamou;
			
			
			
			$bal_p=100-$sold_p;
			
						
			$diff = abs(strtotime($row["SDATE"]) - strtotime(date("Y-m-d")));
			$days = floor($diff / (60*60*24));
		
			if ($arval>0) {
			if (($sold_p != 100)) {
			echo "<tr>
			<td>".$row["SDATE"]."</td>
			<td>".$row["STK_NO"]."</td>
			<td>".$row["REFNO"]."</td>
			<td>".$row["SUP_NAME"]."</td>";
			echo "<td align=\"right\">".number_format($arval, 2, ".", ",") ."</td>";
			echo "<td align=\"right\">".number_format($soldamount, 2, ".", ",")."</td>";
			echo "<td align=\"right\">".number_format($sold_p, 2, ".", ",")."</td>";
			echo "<td align=\"right\">".number_format($balamou, 2, ".", ",")."</td>";
			echo "<td align=\"right\">".number_format($bal_p, 2, ".", ",")."</td>";
			echo "<td align=\"right\">".$days."</td>
			</tr>";	
			}
			}
			
		 // }	
		
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
