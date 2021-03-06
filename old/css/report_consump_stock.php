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

function itemselect()
{
	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmpstkmve";
	$result =$db->RunQuery($sql);
	

$sql="select itemcode, name from tmpitem";
$result =$db->RunQuery($sql);
while ($rows = mysql_fetch_array($result)){
	$sql_s_mas="select * from s_mas where stk_no='".$rows["itemcode"]."'";
	$result_s_mas =$db->RunQuery($sql_s_mas);
	while($row_s_mas = mysql_fetch_array($result_s_mas)){
		$STK_NO = $row_s_mas["STK_NO"];
		$brand_name = $row_s_mas["BRAND_NAME"];
		$descript = $row_s_mas["DESCRIPT"];
		$QTYINHAND = $row_s_mas["QTYINHAND"];
		$totcost = $row_s_mas["QTYINHAND"] * $row_s_mas["COST"];
		$PART_NO = $row_s_mas["PART_NO"];

		$sql_ar="select * from s_purtrn where STK_NO='".$row_s_mas["STK_NO"]."' and CANCEL='0' order by ID desc";
		$result_ar =$db->RunQuery($sql_ar);
		if($row_ar = mysql_fetch_array($result_ar)){
			$AR_NO = $row_ar["REFNO"];
    		$arqty = $row_ar["REC_QTY"];
	    	$ardate = $row_ar["SDATE"];
		}

		$sql_ord="select * from s_ordtrn where STK_NO='".$row_s_mas["STK_NO"]."' and CANCEL=0 order by id desc";
		$result_ord =$db->RunQuery($sql_ord);
		if($row_ord = mysql_fetch_array($result_ord)){
    		$sql_ordmas="select * from s_ordmas where REFNO='".$row_ord["REFNO"]."'";
			$result_ordmas =$db->RunQuery($sql_ordmas);
			if($row_ordmas = mysql_fetch_array($result_ordmas)){
            	$LCNO = $row_ordmas["REFNO"];
            	$shdate = $row_ordmas["S_date"];
   			}
    		$ordqty = $row_ord["ORD_QTY"];
    	}
		
		$mydate=$_GET["dte_from"];
		$month = date("m",strtotime($mydate));
		
		if ($month==12){
        	$m1 = $row_s_mas["SALE01"];
	        $m2 = $row_s_mas["SALE02"];
	        $m3 = $row_s_mas["SALE03"];
	        $m4 = $row_s_mas["SALE04"];
	        $m5 = $row_s_mas["SALE05"];
	        $m6 = $row_s_mas["SALE06"];
	        $m7 = $row_s_mas["SALE07"];
	        $m8 = $row_s_mas["SALE08"];
	        $m9 = $row_s_mas["SALE09"];
	        $m10 = $row_s_mas["SALE10"];
	        $m11 = $row_s_mas["SALE11"];
	        $m12 = $row_s_mas["SALE12"];
		}	
		if ($month==11){
	        $m1 = $row_s_mas["SALE12"];
	        $m2 = $row_s_mas["SALE01"];
	        $m3 = $row_s_mas["SALE02"];
	        $m4 = $row_s_mas["SALE03"];
	        $m5 = $row_s_mas["SALE04"];
	        $m6 = $row_s_mas["SALE05"];
	        $m7 = $row_s_mas["SALE06"];
	        $m8 = $row_s_mas["SALE07"];
	        $m9 = $row_s_mas["SALE08"];
	        $m10 = $row_s_mas["SALE09"];
	        $m11 = $row_s_mas["SALE10"];
	        $m12 = $row_s_mas["SALE11"];
		}
		if ($month==10){
	        $m1 = $row_s_mas["SALE11"];
	        $m2 = $row_s_mas["SALE12"];
	        $m3 = $row_s_mas["SALE01"];
    	    $m4 = $row_s_mas["SALE02"];
	        $m5 = $row_s_mas["SALE03"];
	        $m6 = $row_s_mas["SALE04"];
	        $m7 = $row_s_mas["SALE05"];
	        $m8 = $row_s_mas["SALE06"];
	        $m9 = $row_s_mas["SALE07"];
	        $m10 = $row_s_mas["SALE08"];
	        $m11 = $row_s_mas["SALE09"];
	        $m12 = $row_s_mas["SALE10"];
		}
		if ($month==9){
	        $m1 = $row_s_mas["SALE10"];
	        $m2 = $row_s_mas["SALE11"];
	        $m3 = $row_s_mas["SALE12"];
	        $m4 = $row_s_mas["SALE01"];
	        $m5 = $row_s_mas["SALE02"];
	        $m6 = $row_s_mas["SALE03"];
	        $m7 = $row_s_mas["SALE04"];
	        $m8 = $row_s_mas["SALE05"];
	        $m9 = $row_s_mas["SALE06"];
	        $m10 = $row_s_mas["SALE07"];
	        $m11 = $row_s_mas["SALE08"];
	        $m12 = $row_s_mas["SALE09"];
		}
		if ($month==8){
	        $m1 = $row_s_mas["SALE09"];
	        $m2 = $row_s_mas["SALE10"];
	        $m3 = $row_s_mas["SALE11"];
	        $m4 = $row_s_mas["SALE12"];
	        $m5 = $row_s_mas["SALE01"];
	        $m6 = $row_s_mas["SALE02"];
	        $m7 = $row_s_mas["SALE03"];
	        $m8 = $row_s_mas["SALE04"];
	        $m9 = $row_s_mas["SALE05"];
	        $m10 = $row_s_mas["SALE06"];
	        $m11 = $row_s_mas["SALE07"];
	        $m12 = $row_s_mas["SALE08"];
		}
		if ($month==7){
	        $m1 = $row_s_mas["SALE08"];
	        $m2 = $row_s_mas["SALE09"];
	        $m3 = $row_s_mas["SALE10"];
	        $m4 = $row_s_mas["SALE11"];
	        $m5 = $row_s_mas["SALE12"];
	        $m6 = $row_s_mas["SALE01"];
	        $m7 = $row_s_mas["SALE02"];
	        $m8 = $row_s_mas["SALE03"];
	        $m9 = $row_s_mas["SALE04"];
	        $m10 = $row_s_mas["SALE05"];
	        $m11 = $row_s_mas["SALE06"];
	        $m12 = $row_s_mas["SALE07"];
		}
		if ($month==6){
	        $m1 = $row_s_mas["SALE07"];
	        $m2 = $row_s_mas["SALE08"];
	        $m3 = $row_s_mas["SALE09"];
	        $m4 = $row_s_mas["SALE10"];
	        $m5 = $row_s_mas["SALE11"];
	        $m6 = $row_s_mas["SALE12"];
	        $m7 = $row_s_mas["SALE01"];
	        $m8 = $row_s_mas["SALE02"];
	        $m9 = $row_s_mas["SALE03"];
	        $m10 = $row_s_mas["SALE04"];
	        $m11 = $row_s_mas["SALE05"];
	        $m12 = $row_s_mas["SALE06"];
		}
		if ($month==5){
	        $m1 = $row_s_mas["SALE06"];
	        $m2 = $row_s_mas["SALE07"];
	        $m3 = $row_s_mas["SALE08"];
	        $m4 = $row_s_mas["SALE09"];
	        $m5 = $row_s_mas["SALE10"];
	        $m6 = $row_s_mas["SALE11"];
	        $m7 = $row_s_mas["SALE12"];
	        $m8 = $row_s_mas["SALE01"];
	        $m9 = $row_s_mas["SALE02"];
	        $m10 = $row_s_mas["SALE03"];
	        $m11 = $row_s_mas["SALE04"];
	        $m12 = $row_s_mas["SALE05"];
		}
		if ($month==4){
	        $m1 = $row_s_mas["SALE05"];
	        $m2 = $row_s_mas["SALE06"];
	        $m3 = $row_s_mas["SALE07"];
	        $m4 = $row_s_mas["SALE08"];
	        $m5 = $row_s_mas["SALE09"];
	        $m6 = $row_s_mas["SALE10"];
	        $m7 = $row_s_mas["SALE11"];
	        $m8 = $row_s_mas["SALE12"];
	        $m9 = $row_s_mas["SALE01"];
	        $m10 = $row_s_mas["SALE02"];
	        $m11 = $row_s_mas["SALE03"];
	        $m12 = $row_s_mas["SALE04"];
		}
		if ($month==3){
	        $m1 = $row_s_mas["SALE04"];
	        $m2 = $row_s_mas["SALE05"];
	        $m3 = $row_s_mas["SALE06"];
	        $m4 = $row_s_mas["SALE07"];
	        $m5 = $row_s_mas["SALE08"];
	        $m6 = $row_s_mas["SALE09"];
	        $m7 = $row_s_mas["SALE10"];
	        $m8 = $row_s_mas["SALE11"];
	        $m9 = $row_s_mas["SALE12"];
	        $m10 = $row_s_mas["SALE01"];
	        $m11 = $row_s_mas["SALE02"];
	        $m12 = $row_s_mas["SALE03"];
		}
		if ($month==2){
	        $m1 = $row_s_mas["SALE03"];
	        $m2 = $row_s_mas["SALE04"];
	        $m3 = $row_s_mas["SALE05"];
	        $m4 = $row_s_mas["SALE06"];
	        $m5 = $row_s_mas["SALE07"];
	        $m6 = $row_s_mas["SALE08"];
	        $m7 = $row_s_mas["SALE09"];
	        $m8 = $row_s_mas["SALE10"];
	        $m9 = $row_s_mas["SALE11"];
	        $m10 = $row_s_mas["SALE12"];
	        $m11 = $row_s_mas["SALE01"];
	        $m12 = $row_s_mas["SALE02"];
		}
		if ($month==1){
	        $m1 = $row_s_mas["SALE02"];
	        $m2 = $row_s_mas["SALE03"];
	        $m3 = $row_s_mas["SALE04"];
	        $m4 = $row_s_mas["SALE05"];
	        $m5 = $row_s_mas["SALE06"];
	        $m6 = $row_s_mas["SALE07"];
	        $m7 = $row_s_mas["SALE08"];
	        $m8 = $row_s_mas["SALE09"];
	        $m9 = $row_s_mas["SALE10"];
	        $m10 = $row_s_mas["SALE11"];
	        $m11 = $row_s_mas["SALE12"];
	        $m12 = $row_s_mas["SALE01"];
		}
		 $sql1="Insert into tmpstkmve (STK_NO, BRAND_NAME, DESCRIPT, QTYINHAND, totcost, PART_NO, AR_NO, arqty, ardate, LCNO, shdate, ordqty, m1, m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12 ) values('".$STK_NO."', '".$brand_name."', '".$descript."', ".$QTYINHAND.", ".$totcost.", '".$PART_NO."', '".$AR_NO."', ".$arqty.", '".$ardate."', '".$LCNO."', '".$shdate."', ".$ordqty.", ".$m1.", ".$m2.", ".$m3.", ".$m4.", ".$m5.", ".$m6.", ".$m7.", ".$m8.", ".$m9.", ".$m10.", ".$m11.", ".$m12.")";
		$result1 =$db->RunQuery($sql1);
	}
}

}


function all()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmpstkmve";
	$result =$db->RunQuery($sql);
	


	if ($_GET["brand"]!="All"){$sql_s_mas="select * from s_mas where  BRAND_NAME='".$_GET["brand"]."'";}
	if ($_GET["brand"]=="All"){$sql_s_mas="select * from s_mas";}
	$result_s_mas =$db->RunQuery($sql_s_mas);
	while($row_s_mas = mysql_fetch_array($result_s_mas)){
		$STK_NO = $row_s_mas["STK_NO"];
		$brand_name = $row_s_mas["BRAND_NAME"];
		$descript = $row_s_mas["DESCRIPT"];
		$QTYINHAND = $row_s_mas["QTYINHAND"];
		$totcost = $row_s_mas["QTYINHAND"] * $row_s_mas["COST"];
		$PART_NO = $row_s_mas["PART_NO"];

		$sql_ar="select * from s_purtrn where STK_NO='".$row_s_mas["STK_NO"]."' and CANCEL='0' order by ID desc";
		$result_ar =$db->RunQuery($sql_ar);
		if($row_ar = mysql_fetch_array($result_ar)){
			$AR_NO = $row_ar["REFNO"];
    		$arqty = $row_ar["REC_QTY"];
	    	$ardate = $row_ar["SDATE"];
		}

		$sql_ord="select * from s_ordtrn where STK_NO='".$row_s_mas["STK_NO"]."' and CANCEL=0 order by id desc";
		$result_ord =$db->RunQuery($sql_ord);
		if($row_ord = mysql_fetch_array($result_ord)){
    		$sql_ordmas="select * from s_ordmas where REFNO='".$row_ord["REFNO"]."'";
			$result_ordmas =$db->RunQuery($sql_ordmas);
			if($row_ordmas = mysql_fetch_array($result_ordmas)){
            	$LCNO = $row_ordmas["REFNO"];
            	$shdate = $row_ordmas["S_date"];
   			}
    		$ordqty = $row_ord["ORD_QTY"];
    	}
		
		$month = date("m",strtotime($mydate));
		
		if ($month==12){
        	$m1 = $row_s_mas["SALE01"];
	        $m2 = $row_s_mas["SALE02"];
	        $m3 = $row_s_mas["SALE03"];
	        $m4 = $row_s_mas["SALE04"];
	        $m5 = $row_s_mas["SALE05"];
	        $m6 = $row_s_mas["SALE06"];
	        $m7 = $row_s_mas["SALE07"];
	        $m8 = $row_s_mas["SALE08"];
	        $m9 = $row_s_mas["SALE09"];
	        $m10 = $row_s_mas["SALE10"];
	        $m11 = $row_s_mas["SALE11"];
	        $m12 = $row_s_mas["SALE12"];
		}	
		if ($month==11){
	        $m1 = $row_s_mas["SALE12"];
	        $m2 = $row_s_mas["SALE01"];
	        $m3 = $row_s_mas["SALE02"];
	        $m4 = $row_s_mas["SALE03"];
	        $m5 = $row_s_mas["SALE04"];
	        $m6 = $row_s_mas["SALE05"];
	        $m7 = $row_s_mas["SALE06"];
	        $m8 = $row_s_mas["SALE07"];
	        $m9 = $row_s_mas["SALE08"];
	        $m10 = $row_s_mas["SALE09"];
	        $m11 = $row_s_mas["SALE10"];
	        $m12 = $row_s_mas["SALE11"];
		}
		if ($month==10){
	        $m1 = $row_s_mas["SALE11"];
	        $m2 = $row_s_mas["SALE12"];
	        $m3 = $row_s_mas["SALE01"];
    	    $m4 = $row_s_mas["SALE02"];
	        $m5 = $row_s_mas["SALE03"];
	        $m6 = $row_s_mas["SALE04"];
	        $m7 = $row_s_mas["SALE05"];
	        $m8 = $row_s_mas["SALE06"];
	        $m9 = $row_s_mas["SALE07"];
	        $m10 = $row_s_mas["SALE08"];
	        $m11 = $row_s_mas["SALE09"];
	        $m12 = $row_s_mas["SALE10"];
		}
		if ($month==9){
	        $m1 = $row_s_mas["SALE10"];
	        $m2 = $row_s_mas["SALE11"];
	        $m3 = $row_s_mas["SALE12"];
	        $m4 = $row_s_mas["SALE01"];
	        $m5 = $row_s_mas["SALE02"];
	        $m6 = $row_s_mas["SALE03"];
	        $m7 = $row_s_mas["SALE04"];
	        $m8 = $row_s_mas["SALE05"];
	        $m9 = $row_s_mas["SALE06"];
	        $m10 = $row_s_mas["SALE07"];
	        $m11 = $row_s_mas["SALE08"];
	        $m12 = $row_s_mas["SALE09"];
		}
		if ($month==8){
	        $m1 = $row_s_mas["SALE09"];
	        $m2 = $row_s_mas["SALE10"];
	        $m3 = $row_s_mas["SALE11"];
	        $m4 = $row_s_mas["SALE12"];
	        $m5 = $row_s_mas["SALE01"];
	        $m6 = $row_s_mas["SALE02"];
	        $m7 = $row_s_mas["SALE03"];
	        $m8 = $row_s_mas["SALE04"];
	        $m9 = $row_s_mas["SALE05"];
	        $m10 = $row_s_mas["SALE06"];
	        $m11 = $row_s_mas["SALE07"];
	        $m12 = $row_s_mas["SALE08"];
		}
		if ($month==7){
	        $m1 = $row_s_mas["SALE08"];
	        $m2 = $row_s_mas["SALE09"];
	        $m3 = $row_s_mas["SALE10"];
	        $m4 = $row_s_mas["SALE11"];
	        $m5 = $row_s_mas["SALE12"];
	        $m6 = $row_s_mas["SALE01"];
	        $m7 = $row_s_mas["SALE02"];
	        $m8 = $row_s_mas["SALE03"];
	        $m9 = $row_s_mas["SALE04"];
	        $m10 = $row_s_mas["SALE05"];
	        $m11 = $row_s_mas["SALE06"];
	        $m12 = $row_s_mas["SALE07"];
		}
		if ($month==6){
	        $m1 = $row_s_mas["SALE07"];
	        $m2 = $row_s_mas["SALE08"];
	        $m3 = $row_s_mas["SALE09"];
	        $m4 = $row_s_mas["SALE10"];
	        $m5 = $row_s_mas["SALE11"];
	        $m6 = $row_s_mas["SALE12"];
	        $m7 = $row_s_mas["SALE01"];
	        $m8 = $row_s_mas["SALE02"];
	        $m9 = $row_s_mas["SALE03"];
	        $m10 = $row_s_mas["SALE04"];
	        $m11 = $row_s_mas["SALE05"];
	        $m12 = $row_s_mas["SALE06"];
		}
		if ($month==5){
	        $m1 = $row_s_mas["SALE06"];
	        $m2 = $row_s_mas["SALE07"];
	        $m3 = $row_s_mas["SALE08"];
	        $m4 = $row_s_mas["SALE09"];
	        $m5 = $row_s_mas["SALE10"];
	        $m6 = $row_s_mas["SALE11"];
	        $m7 = $row_s_mas["SALE12"];
	        $m8 = $row_s_mas["SALE01"];
	        $m9 = $row_s_mas["SALE02"];
	        $m10 = $row_s_mas["SALE03"];
	        $m11 = $row_s_mas["SALE04"];
	        $m12 = $row_s_mas["SALE05"];
		}
		if ($month==4){
	        $m1 = $row_s_mas["SALE05"];
	        $m2 = $row_s_mas["SALE06"];
	        $m3 = $row_s_mas["SALE07"];
	        $m4 = $row_s_mas["SALE08"];
	        $m5 = $row_s_mas["SALE09"];
	        $m6 = $row_s_mas["SALE10"];
	        $m7 = $row_s_mas["SALE11"];
	        $m8 = $row_s_mas["SALE12"];
	        $m9 = $row_s_mas["SALE01"];
	        $m10 = $row_s_mas["SALE02"];
	        $m11 = $row_s_mas["SALE03"];
	        $m12 = $row_s_mas["SALE04"];
		}
		if ($month==3){
	        $m1 = $row_s_mas["SALE04"];
	        $m2 = $row_s_mas["SALE05"];
	        $m3 = $row_s_mas["SALE06"];
	        $m4 = $row_s_mas["SALE07"];
	        $m5 = $row_s_mas["SALE08"];
	        $m6 = $row_s_mas["SALE09"];
	        $m7 = $row_s_mas["SALE10"];
	        $m8 = $row_s_mas["SALE11"];
	        $m9 = $row_s_mas["SALE12"];
	        $m10 = $row_s_mas["SALE01"];
	        $m11 = $row_s_mas["SALE02"];
	        $m12 = $row_s_mas["SALE03"];
		}
		if ($month==2){
	        $m1 = $row_s_mas["SALE03"];
	        $m2 = $row_s_mas["SALE04"];
	        $m3 = $row_s_mas["SALE05"];
	        $m4 = $row_s_mas["SALE06"];
	        $m5 = $row_s_mas["SALE07"];
	        $m6 = $row_s_mas["SALE08"];
	        $m7 = $row_s_mas["SALE09"];
	        $m8 = $row_s_mas["SALE10"];
	        $m9 = $row_s_mas["SALE11"];
	        $m10 = $row_s_mas["SALE12"];
	        $m11 = $row_s_mas["SALE01"];
	        $m12 = $row_s_mas["SALE02"];
		}
		if ($month==1){
	        $m1 = $row_s_mas["SALE02"];
	        $m2 = $row_s_mas["SALE03"];
	        $m3 = $row_s_mas["SALE04"];
	        $m4 = $row_s_mas["SALE05"];
	        $m5 = $row_s_mas["SALE06"];
	        $m6 = $row_s_mas["SALE07"];
	        $m7 = $row_s_mas["SALE08"];
	        $m8 = $row_s_mas["SALE09"];
	        $m9 = $row_s_mas["SALE10"];
	        $m10 = $row_s_mas["SALE11"];
	        $m11 = $row_s_mas["SALE12"];
	        $m12 = $row_s_mas["SALE01"];
		}
		
		 $sql1="Insert into tmpstkmve (STK_NO, BRAND_NAME, DESCRIPT, QTYINHAND, totcost, PART_NO, AR_NO, arqty, ardate, LCNO, shdate, ordqty, m1, m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12 ) values('".$STK_NO."', '".$brand_name."', '".$descript."', ".$QTYINHAND.", ".$totcost.", '".$PART_NO."', '".$AR_NO."', ".$arqty.", '".$ardate."', '".$LCNO."', '".$shdate."', ".$ordqty.", ".$m1.", ".$m2.", ".$m3.", ".$m4.", ".$m5.", ".$m6.", ".$m7.", ".$m8.", ".$m9.", ".$m10.", ".$m11.", ".$m12.")";
		$result1 =$db->RunQuery($sql1);
	}

}

    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmpstkmve";
	$result =$db->RunQuery($sql);
	
	if ($_GET["checkbox"]=="on"){
		itemselect();
	} else {
		all();
	}
	

 echo "<table border=1><tr><td>Item No</td><td>Description</td><td>AR_No</td><td>AR_QTY</td>";
	$month = date("m",strtotime($mydate));
		if ($month==12){
			echo "<th>Jan</th>";
			echo "<th>Feb</th>";
			echo "<th>Mar</th>";
			echo "<th>Apr</th>";
			echo "<th>May</th>";
			echo "<th>Jun</th>";
			echo "<th>Jul</th>";
			echo "<th>Aug</th>";
			echo "<th>Sep</th>";
			echo "<th>Oct</th>";
			echo "<th>Nov</th>";
			echo "<th>Dec</th>";
		}
		
		if ($month==1){
			
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
		}
		
		if ($month==2){
			
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
		}
		
		if ($month==3){
			
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
		}
		
		if ($month==4){
			
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
		}
		
		if ($month==5){
			
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
		}
		
		if ($month==6){
			
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
		}
		
		if ($month==7){
			
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
		}
		
		
		if ($month==8){
			
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
		}
		
		if ($month==9){
			
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
		}
		
		if ($month==10){
			
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
		}
		
		if ($month==11){
			
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
		}
		echo "<td>arDate</td></tr>";
		
	$sql="select * from tmpstkmve";
	$result =$db->RunQuery($sql);
	while($row = mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td>".$row["STK_NO"]."</td>";
		echo "<td>".$row["DESCRIPT"]."</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>".$row["m1"]."</td>";
		echo "<td>".$row["m2"]."</td>";
		echo "<td>".$row["m3"]."</td>";
		echo "<td>".$row["m4"]."</td>";
		echo "<td>".$row["m5"]."</td>";
		echo "<td>".$row["m6"]."</td>";
		echo "<td>".$row["m7"]."</td>";
		echo "<td>".$row["m8"]."</td>";
		echo "<td>".$row["m9"]."</td>";
		echo "<td>".$row["m10"]."</td>";
		echo "<td>".$row["m11"]."</td>";
		echo "<td>".$row["m12"]."</td>";
		echo "<td></td>";
		echo "</tr>";
	}

echo "</table>";


?>


</body>
</html>
