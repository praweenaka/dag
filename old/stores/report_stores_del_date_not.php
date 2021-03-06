<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice Report</title>

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
font-size:12px;

}
.style1 {
	font-size: 16px;
	font-weight: bold;
	color: #FF0000;
}
</style>

</head>

<body><center>


<p>
  <?php

    require_once("connectioni.php");
	
	
			$rtxtdate = " Invoice Report From   " . $_GET["dtfrom"] . "   To " .  $_GET["dtto"] ;
			if ($_GET['checkbox'] =="on") {
				$rtxtdate1 .= " Not Deliverd";
			}
			if ($_GET['chk_can'] =="on") {
				$rtxtdate1 .= " Cancelled";
			}


            echo "<center>" . $rtxtdate .  " "  . $rtxtdate1  . "</center><br>";
	
    
	if ($_GET["checkbox"]=="on"){
	echo "<table border=1>
	<tr>
    <td><b>Invoice No</b></td>
    <td><b>Dealer Code</b></td>
    <td><b>Dealer Name</b></td>
    <td><b>Invoice Date</b></td>
    <td><b>Rep Code</b></td>
    <td><b>Driver</b></td>
    <td><b>Vehicle No</b></td>
    
  </tr>";
  } else {
  	echo "<table border=1>
	<tr>
    <td><b>Invoice No</b></td>
    <td><b>Dealer Code</b></td>
    <td><b>Dealer Name</b></td>
    <td><b>Invoice Date</b></td>
    <td><b>Rep Code</b></td>
    <td><b>Driver</b></td>
    <td><b>Vehicle No</b></td>
    <td><b>Delivery Date</b></td>
  </tr>";
  }
 
	
  if ($_GET["checkbox"]=="on")	{
	$sql_rst = "select * from view_salma_brand where (deli_date IS NULL or deli_date='0000-00-00') and CANCELL='0' and SDATE>='".$_GET["dtfrom"]."' and SDATE<='".$_GET["dtto"]."'";
  } else {
  	$sql_rst = "select * from view_salma_brand where CANCELL='0' and SDATE>='".$_GET["dtfrom"]."' and SDATE<='".$_GET["dtto"]."'";
  }	
  
    if ($_GET["chk_can"]=="on")	{
		$sql_rst = "select * from view_salma_brand where CANCELL='1' and SDATE>='".$_GET["dtfrom"]."' and SDATE<='".$_GET["dtto"]."'";
	}
  
  if ($_GET['cmbrep'] !="All") {
	  $sql_rst .= " and SAL_EX  ='" . $_GET['cmbrep'] . "'";
  }
  
  
  if ($_GET['cmbbrand1'] !="All") {
	  $sql_rst .= " and class  ='" . $_GET['cmbbrand1'] . "'";
  }
  
  
  
	$sql_rst .=  "  order by class,REF_NO";
  
	$result_rst =mysqli_query($GLOBALS['dbinv'],$sql_rst);
	while($row_rst = mysqli_fetch_array($result_rst)){
	
	if ($mclass!=$row_rst['class']) {
		echo "
	<tr>
    <th align='left' colspan='8'>".$row_rst["class"]."</th></tr>";
	}
	
	$mclass =$row_rst["class"];
	
	if ($_GET["checkbox"]=="on"){
		echo "
	<tr>
    <td>".$row_rst["REF_NO"]."</td>
    <td>".$row_rst["C_CODE"]."</td>
    <td>".$row_rst["CUS_NAME"]."</td>
    <td>".$row_rst["SDATE"]."</td>";
	$sql = "select * from s_salrep where repcode = '" . $row_rst["SAL_EX"] . "'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql);
	$row = mysqli_fetch_array($result);
    echo "<td>".$row["Name"]."</td>
    <td>".$row_rst["driver"]."</td>
    <td>".$row_rst["veheno"]."</td>
    
  </tr>";
    } else {
		
		echo "
	<tr>
    <td>".$row_rst["REF_NO"]."</td>
    <td>".$row_rst["C_CODE"]."</td>
    <td>".$row_rst["CUS_NAME"]."</td>
    <td>".$row_rst["SDATE"]."</td>";
	
  $sql = "select * from s_salrep where repcode = '" . $row_rst["SAL_EX"] . "'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql);
	$row = mysqli_fetch_array($result);
    echo "<td>".$row["Name"]."</td>
    <td>".$row_rst["driver"]."</td>
    <td>".$row_rst["veheno"]."</td>
    <td>".$row_rst["deli_date"]."</td>
  </tr>";
		
	}
  }
 

?> 
</table>
</body>
</html>
