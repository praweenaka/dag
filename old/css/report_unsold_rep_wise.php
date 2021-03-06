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
<!-- Progress information -->
<div id="information" style="width"></div>

<?php

    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
	$balqty=0;
	$daysover=$_GET["dover"];
	$daysbel=$_GET["dbetween"];
	
    $sql="delete from tmparmove";
	$result =$db->RunQuery($sql);
	
	if ($_GET["brand"]=="All"){
		$sql="select * from s_mas where QTYINHAND> 0  ";
	} else { 
		$sql="select * from s_mas where QTYINHAND> 0 and BRAND_NAME='".$_GET["brand"]."'";
	}
	//echo $sql;
	$result =$db->RunQuery($sql);
	while($row = mysql_fetch_array($result)){
	
		$balqty = $row["QTYINHAND"];
    	$totarqty = 0;
    	$totbalqty = 0;
    	
		$sql_s_mas="Select DESCRIPT, PART_NO, BRAND_NAME, QTYINHAND, COST, acc_cost from s_mas where STK_NO='".$row["STK_NO"]."'";
		$result_s_mas =$db->RunQuery($sql_s_mas);
		$row_s_mas = mysql_fetch_array($result_s_mas);
    	$totbalqty = $row_s_mas["QTYINHAND"];
    	
		$sql_artrn="select * from s_purtrn where STK_NO='".$row["STK_NO"]."' and CANCEL='0' order by SDATE desc ";
		$result_artrn =$db->RunQuery($sql_artrn);
		while ($balqty != 0){
		
			if($row_artrn = mysql_fetch_array($result_artrn)){
				$totarqty = $totarqty + $result_artrn["REC_QTY"];
				$sql_sgin="select * from s_ginmas where AR_NO = '".$row_artrn["REFNO"]."' and DEL_TO = '".$_GET["department"]."'";
				$result_sgin =$db->RunQuery($sql_sgin);
				if ($row_sgin = mysql_fetch_array($result_sgin)){
					while($row_sgin = mysql_fetch_array($result_sgin)){
					
						$sql_strn="select * from s_trn where REFNO = '".$row_sgin["REF_NO"]."' and STK_NO = '".$row["STK_NO"]."' and DEPARTMENT = '".$_GET["department"]."'";
						$result_strn =$db->RunQuery($sql_strn);
						if ($row_strn = mysql_fetch_array($result_strn)){
							while ($row_strn = mysql_fetch_array($result_strn)){
								
                            	$ardate = $row_artrn["SDATE"];
                            	$AR_NO = $row_artrn["REFNO"];
                            	$STK_NO = $row["STK_NO"];
                            	$des = $row_s_mas["DESCRIPT"];
                            	$PART_NO = $row_s_mas["PART_NO"];
                            	$qty_hnd = $row["QTYINHAND"];
                            	$AR_QTY = $row_artrn["REC_QTY"];
                            	$brand = $row_s_mas["BRAND_NAME"];
                            
								$sql_armas="select * from s_purmas where REFNO='".$row_artrn["REFNO"]."'";
								$result_armas =$db->RunQuery($sql_armas);
								if ($row_armas = mysql_fetch_array($result_armas)){
                            		$SUPPLIER =$row_armas["SUP_NAME"];
                                   	$LC_NO = $row_armas["LCNO"];
								}
							
                           		$ARVALUE = $row_artrn["acc_cost"] * $row_artrn["REC_QTY"];
								$period = (strtotime(date("Y-m-d")) - strtotime($row_artrn["SDATE"]) ) / (60 * 60 * 24);
                            	
                            	if ($balqty > $row_strn["QTY"]){
                                	$monsales = 0;
                                    $UN_QTY = $row_strn["QTY"];
                              
                                	$sold = $row_s_mas["acc_cost"];
                                	$balqty = $balqty - $row_strn["QTY"];
                                    //echo "1 - ".$UN_QTY." / ".$sold."</br>";
									if ($row_strn["QTYINHAND"] < $totarqty){
										$sql_tmp="insert into tmparmove(ardate, AR_NO, STK_NO, des, PART_NO, qty_hnd, AR_QTY, brand, SUPPLIER, LC_NO, ARVALUE, period, monsales, UN_QTY, sold) values ('".$ardate."', '".$AR_NO."', '".$STK_NO."', '".$des."', '".$PART_NO."', ".$qty_hnd.", ".$AR_QTY.", '".$brand."', '".$SUPPLIER."', '".$LC_NO."', ".$ARVALUE.", ".$period.", ".$monsales.", ".$UN_QTY.", ".$sold.")";
										$result_tmp =$db->RunQuery($sql_tmp);
                                    	
                                   		$sql_tmp1="Select * from tmparmove where STK_NO = '".$row["STK_NO"]."' order by ardate ";
										$result_tmp1 =$db->RunQuery($sql_tmp1);
										if ($row_tmp1 = mysql_fetch_array($result_tmp1)){
											$sql_updatetmp="update tmparmove set UN_QTY = '".$row_tmp1["UN_QTY"] + $balqty."' where AR_NO = '".$row_tmp1["AR_NO"]."' and STK_NO = '".$row["STK_NO"]."' ";
											$result_updatetmp =$db->RunQuery($sql_updatetmp);
										} else {
											$UN_QTY = $row_strn["QTY"] + $balqty;
										}
                                   		
                                     	$balqty = 0;
                                    }
                               } else {
                               		
									$date = $row_artrn["SDATE"];
									$date = strtotime(date("Y-m-d", strtotime($date)) . " +30 days");
									$caldate= date("Y-m-d", $date);
									
									$sql_saltr="select QTY from s_invo where STK_NO='".$row["STK_NO"]."' and CANCELL='0' and DEPARTMENT = '".$_GET["department"]."' and(SDATE>'".$row_artrn["SDATE"]."' or SDATE='".$row_artrn["SDATE"]."') and sdate<'".$caldate."'";
									$result_saltr =$db->RunQuery($sql_saltr);
									$salqty = 0;
									while ($row_saltr = mysql_fetch_array($result_saltr)){
										$salqty = $salqty + $row_saltr["QTY"];
									}
									
                                	if ($totbalqty <= 0 and $balqty > 0){
                                     
									 	$date = date("Y-m-d");
										$date = strtotime(date("Y-m-d", strtotime($date)) . " -91 days");
										$caldate= date("Y-m-d", $date);
									
                                    	$sql_rs="select sum(REC_QTY) as stk from s_purtrn where STK_NO='".$row["STK_NO"]."' and CANCEL='0' and SDATE > '".$caldate."' ";
										$result_rs =$db->RunQuery($sql_rs);
                                     	$row_rs = mysql_fetch_array($result_rs);
									 	$mnewstk = 0;
	                                    $txtunsold = 0;
                                     	if (!is_null($row_rs["stk"])){ $mnewstk = $row_rs["stk"]; }
                                     	if ($row_mas["QTYINHAND"] > $mnewstk) {
                                        	$txtunsold = $row_mas["QTYINHAND"] - $mnewstk;
                                     	}
                                     	if ($txtunsold > 0){
                                        	$UN_QTY = $balqty;
                                       		$sold = $row_mas["COST"];
                                     	} else {
                                        	$UN_QTY = "0";
                                      		$monsales = "0";
                                        	$sold = "0";
                                     	}
									} else {
                                     
									 	$UN_QTY = $balqty;
                                 		$sold = $row_mas["acc_cost"];
									}
                                
                                	$balqty = 0;
									//echo "2 - ".$UN_QTY." / ".$sold."</br>";
									$sql_tmp="insert into tmparmove(ardate, AR_NO, STK_NO, des, PART_NO, qty_hnd, AR_QTY, brand, SUPPLIER, LC_NO, ARVALUE, period, monsales, UN_QTY, sold) values ('".$ardate."', '".$AR_NO."', '".$STK_NO."', '".$des."', '".$PART_NO."', ".$qty_hnd.", ".$AR_QTY.", '".$brand."', '".$SUPPLIER."', '".$LC_NO."', ".$ARVALUE.", ".$period.", ".$monsales.", ".$UN_QTY.", ".$sold.")";
									$result_tmp =$db->RunQuery($sql_tmp);
                                
                            	}
								
							}
						} else {
							$ardate = $row_artrn["SDATE"];
                        	$AR_NO = $row_artrn["REFNO"];
                        	$STK_NO = $row["STK_NO"];
                        	$des = $row_s_mas["DESCRIPT"];
                        	$PART_NO = $row_s_mas["PART_NO"];
                        	$qty_hnd = $row_s_mas["QTYINHAND"];
                        	$AR_QTY = $row_artrn["rec_qty"];
                        	$brand = $row_s_mas["BRAND_NAME"];
							
							$sql_armas="select * from s_purmas where REFNO='".$row_artrn["REFNO"]."'";
							$result_armas =$db->RunQuery($sql_armas);
							if ($row_armas = mysql_fetch_array($result_armas)){
								$SUPPLIER = $row_armas["SUP_NAME"];
                               	$LC_NO = $row_armas["LCNO"];
							}
							
							$ARVALUE = $row_artrn["acc_cost"] * $row_artrn["REC_QTY"];
							$period = (strtotime(date("Y-m-d")) - strtotime($row_artrn["SDATE"]) ) / (60 * 60 * 24);
                        	
							if ($totbalqty > $row_artrn["rec_qty"]){
                            	$UN_QTY = 0;
                            	$monsales = 0;
								$sold = 0;
							} else {
                                $UN_QTY = $balqty;
                            	$monsales = $row_s_mas["acc_cost"] * ($salqty - $row_artrn["QTYINHAND"]);
                            	$sold = $row_s_mas["acc_cost"];
                            	$balqty = 0;
							}
							//echo "3 - ".$UN_QTY." / ".$sold."</br>";
							$sql_tmp1="insert into tmparmove(ardate, AR_NO, STK_NO, des, PART_NO, qty_hnd, AR_QTY, brand, SUPPLIER, LC_NO, ARVALUE, period, monsales, UN_QTY, sold) values ('".$ardate."', '".$AR_NO."', '".$STK_NO."', '".$des."', '".$PART_NO."', ".$qty_hnd.", ".$AR_QTY.", '".$brand."', '".$SUPPLIER."', '".$LC_NO."', ".$ARVALUE.", ".$period.", ".$monsales.", ".$UN_QTY.", ".$sold.")";
							$result_tmp1 =$db->RunQuery($sql_tmp1);
							
							if ($totbalqty < 0){
                            	$balqty = 0;
                        	}
							
						}
					}
					
					$totbalqty = $totbalqty - $row_artrn["REC_QTY"];
					$row_artrn=mysql_fetch_assoc($result_artrn);
					
				} else {
															
					$ardate = $row_artrn["SDATE"];
                    $AR_NO = $row_artrn["REFNO"];
                    $STK_NO = $row["STK_NO"];
                    $des = $row_s_mas["DESCRIPT"];
                    $PART_NO = $row_s_mas["PART_NO"];
                    $qty_hnd = $row["QTYINHAND"];
                    $AR_QTY = $row_artrn["REC_QTY"];
                    $brand = $row_s_mas["BRAND_NAME"];
					
					$sql_armas="select * from s_purmas where REFNO='".$row_artrn["REFNO"]."'";
					$result_armas =$db->RunQuery($sql_armas);
					if ($row_armas = mysql_fetch_array($result_armas)){
						$SUPPLIER = $row_armas["SUP_NAME"];
                       	$LC_NO = $row_armas["LCNO"];
					}
							
					$ARVALUE = $row_artrn["acc_cost"] * $row_artrn["REC_QTY"];
					$period = (strtotime(date("Y-m-d")) - strtotime($row_artrn["SDATE"]) ) / (60 * 60 * 24);
                    
					if ($row_s_mas["QTYINHAND"] < $totarqty){
                        $monsales = 0;
                        $UN_QTY = $balqty;
                        $sold = $row_s_mas["acc_cost"];
                        $balqty = 0;
                        $totbalqty = $totbalqty - $row_artrn["REC_QTY"];
                        $row_artrn=mysql_fetch_assoc($result_artrn);
						//echo "4-1 - ".$UN_QTY." / ".$sold."</br>";
                    } else {
						$date = date("Y-m-d");
						$date = strtotime(date("Y-m-d", strtotime($date)) . " +30 days");
						$caldate= date("Y-m-d", $date);
                        $sql_saltr="select QTY from s_invo where STK_NO='".$row["STK_NO"]."' and CANCELL='0' and DEPARTMENT = '".$_GET["department"]."' and(SDATE>'".$row_artrn["SDATE"]."' or SDATE='".$row_artrn["SDATE"]."') and sdate<'".$caldate."'";
                        $salqty = 0;
						$result_saltr =$db->RunQuery($sql_saltr);
						while ($row_saltr = mysql_fetch_array($result_saltr)){
                            $salqty = $salqty + $row_saltr["QTY"];
                        }
                        $UN_QTY = 0;
                        $monsales = 0;
                        $sold = 0;
                        $totbalqty = $totbalqty - $row_artrn["REC_QTY"];
                        $row_artrn=mysql_fetch_assoc($result_artrn);
                      // echo "4 -2 ".$UN_QTY." / ".$sold."</br>";
                    }
                  		$sql_tmp1="insert into tmparmove(ardate, AR_NO, STK_NO, des, PART_NO, qty_hnd, AR_QTY, brand, SUPPLIER, LC_NO, ARVALUE, period, monsales, UN_QTY, sold) values ('".$ardate."', '".$AR_NO."', '".$STK_NO."', '".$des."', '".$PART_NO."', ".$qty_hnd.", ".$AR_QTY.", '".$brand."', '".$SUPPLIER."', '".$LC_NO."', ".$ARVALUE.", ".$period.", ".$monsales.", ".$UN_QTY.", ".$sold.")";
						$result_tmp1 =$db->RunQuery($sql_tmp1);
						
				}
			} else {
				break;
			}
		}
	}

$chk_status=0;

if ($_GET["qbrand"] == "All"){$sql_rst= "select * from tmparmove";}
if ($_GET["qbrand"] == "Over"){ $sql_rst= "select * from tmparmove where period>".$daysover; }
if ($_GET["qbrand"] == "Between") { $sql_rst= "select * from tmparmove where period>".$daysover." and period<".$daysbel; }
$result_rst =$db->RunQuery($sql_rst);
while ($row_rst = mysql_fetch_array($result_rst)){
	if ($row_rst["period"] < 31) { $b30 = $b30 + $row_rst["UN_QTY"] * $row_rst["sold"];}
	if (($row_rst["period"] > 30) and ($row_rst["period"] < 46)) { $o36b45 = $o36b45 + $row_rst["UN_QTY"] * $row_rst["sold"]; }
	if (($row_rst["period"] > 45) and ($row_rst["period"] < 61)) { $o46b60 = $o46b60 + $row_rst["UN_QTY"] * $row_rst["sold"]; }
	if (($row_rst["period"] > 60) and ($row_rst["period"] < 76)) { $o61b75 = $o61b75 + $row_rst["UN_QTY"] * $row_rst["sold"]; }
	if (($row_rst["period"] > 75) and ($row_rst["period"] < 91)) { $o76b91 = $o76b91 + $row_rst["UN_QTY"] * $row_rst["sold"]; }
	if ($row_rst["period"] > 90) { $o91 = $o91 + $row_rst["UN_QTY"] * $row_rst["sold"]; }
	if ((!is_null($row_rst["sold"])) and (!is_null($row_rst["UN_QTY"]))) { $total = $total + $row_rst["UN_QTY"] * $row_rst["sold"]; }
	
	$chk_status=1;
}


if ($_GET["unsold"]=="details")
{
	$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		echo "<center>".date("Y-m-d")."<center>Un Sold Stock Report - Rep wise</center><br>";
		
	echo "<table border=1><tr>
		<th>Stock No</th><th>Description</th><th>Part No</th><th>Qty In Ha</th><th>No of Days</th><th>Un Sold Stock</th><th>L/C No</td>
		<th>AR Date</th><th>AR No</th><th>AR Qty</th><th>Total Value</th><th>Cost Value</th><th>Unsold Value</th></tr>";
  
  if ($chk_status==1){	
  	mysql_data_seek($result_rst, 0);
  }		
  while ($row_rst = mysql_fetch_array($result_rst)){	
	echo "<tr>";
	echo "<td>".$row_rst["STK_NO"]."</td>";
	echo "<td>".$row_rst["des"]."</td>";
	echo "<td>".$row_rst["PART_NO"]."</td>";
	echo "<td>".$row_rst["qty_hnd"]."</td>";
	echo "<td>".$row_rst["period"]."</td>";
	echo "<td>".$row_rst["UN_QTY"]."</td>";
	echo "<td>".$row_rst["LC_NO"]."</td>";
	echo "<td>".$row_rst["ardate"]."</td>";
	echo "<td>".$row_rst["AR_NO"]."</td>";
	echo "<td>".$row_rst["AR_QTY"]."</td>";
	echo "<td>".$row_rst["ARVALUE"]."</td>";
	echo "<td>".$row_rst["sold"]."</td>";
	echo "<td>".$row_rst["sold"]*$row_rst["UN_QTY"]."</td>";
	echo "</tr>";
  }	
 echo "</table>";
}








if ($_GET["unsold"]=="summery")
{
	$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		echo "<center>".date("Y-m-d")."<center>Un Sold Stock Summery Report - Rep wise</center><br>";
		
	echo "<table border=1 cellpadding=\"5\" cellspacing=\"0\"><tr>
		<th>Brand</th><th>Bellow 60</th><th>60 to 90</th><th>90 to 120</th><th>Over 120</th><th>Total Stock</th>
		<th>Total Over 90</th><th>%</th></tr>";
	
	$bellow60_tot=0;
	$bet60_90_tot=0;
	$bet90_120_tot=0;
	$over120_tot=0;
	$totstk_tot=0;
	$totover90_tot=0;
	
	if ($_GET["qbrand"]=="All"){$sql="select distinct brand from tmparmove order by brand";}
	if ($_GET["qbrand"]=="Over"){$sql="select distinct brand from tmparmove where period>".$_GET["dover"]."  order by brand "; }
	if ($_GET["qbrand"]=="Between"){$sql="select distinct brand from tmparmove where period>".$_GET["dover"]." and period<".$_GET["dbetween"]."  order by brand";}	
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){	
		
		if ($_GET["qbrand"]=="All"){$sql="select sum(UN_QTY * sold) as bellow60 from tmparmove where  brand='".$rows["brand"]."' and period < 61";}
		if ($_GET["qbrand"]=="Over"){$sql="select sum(UN_QTY * sold) as bellow60 from tmparmove where  brand='".$rows["brand"]."' and period < 61  and period>".$_GET["dover"]."  "; }
		if ($_GET["qbrand"]=="Between"){$sql="select sum(UN_QTY * sold) as bellow60 from tmparmove where  brand='".$rows["brand"]."' and period < 61 and (period>".$_GET["dover"]." and period<".$_GET["dbetween"].")";}	

		$result1 =$db->RunQuery($sql);
		
		$rows1 = mysql_fetch_array($result1);
		$bellow60=$rows1["bellow60"];
		if (is_null($bellow60)){$bellow60=0;}	
		
		if ($_GET["qbrand"]=="All"){$sql="select sum(UN_QTY * sold) as bet60_90 from tmparmove where  brand='".$rows["brand"]."' and (period > 60 and period < 91)";}
		if ($_GET["qbrand"]=="Over"){$sql="select sum(UN_QTY * sold) as bet60_90 from tmparmove where  brand='".$rows["brand"]."' and (period > 60 and period < 91)  and period>".$_GET["dover"]."  "; }
		if ($_GET["qbrand"]=="Between"){$sql="select sum(UN_QTY * sold) as bet60_90 from tmparmove where  brand='".$rows["brand"]."' and (period > 60 and period < 91) and (period>".$_GET["dover"]." and period<".$_GET["dbetween"].")";}	
		
		$result1 =$db->RunQuery($sql);
		$rows1 = mysql_fetch_array($result1);
		$bet60_90=$rows1["bet60_90"];
		if (is_null($bet60_90)){$bet60_90=0;}	
		
		if ($_GET["qbrand"]=="All"){$sql="select sum(UN_QTY * sold) as bet90_120 from tmparmove where  brand='".$rows["brand"]."' and (period > 90 and period < 121)";}
		if ($_GET["qbrand"]=="Over"){$sql="select sum(UN_QTY * sold) as bet90_120 from tmparmove where  brand='".$rows["brand"]."' and (period > 90 and period < 121)  and period>".$_GET["dover"]."  "; }
		if ($_GET["qbrand"]=="Between"){$sql="select sum(UN_QTY * sold) as bet90_120 from tmparmove where  brand='".$rows["brand"]."' and (period > 90 and period < 121) and (period>".$_GET["dover"]." and period<".$_GET["dbetween"].")";}	
		$result1 =$db->RunQuery($sql);
		$rows1 = mysql_fetch_array($result1);
		$bet90_120=$rows1["bet90_120"];	
		if (is_null($bet90_120)){$bet90_120=0;}
		
		if ($_GET["qbrand"]=="All"){$sql="select sum(UN_QTY * sold) as over120 from tmparmove where  brand='".$rows["brand"]."' and period > 120";}
		if ($_GET["qbrand"]=="Over"){$sql="select sum(UN_QTY * sold) as over120 from tmparmove where  brand='".$rows["brand"]."' and period > 120  and period>".$_GET["dover"]."  "; }
		if ($_GET["qbrand"]=="Between"){$sql="select sum(UN_QTY * sold) as over120 from tmparmove where  brand='".$rows["brand"]."' and period > 120 and (period>".$_GET["dover"]." and period<".$_GET["dbetween"].")";}	
		// $sql."</br>";
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
	echo "</table>";	
}

?>


</body>
</html>
