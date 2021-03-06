<?php session_start();
?>
<?php date_default_timezone_set('Asia/Colombo'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Defective Report</title>
<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
}
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
font-size:15px;

}
td
{
font-size:15px;
border-bottom:thick;
border-left:none;
border-right:none;


}
</style>
<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
	font-size: 24px;
}
-->
</style>
</head>

<body>
 <!-- Progress bar holder -->


<?php


	
	require_once("connectioni.php");
	
	
	
	
if ($_SESSION['company']=="BEN"){
    $TXTHEAD = "BENEDICTSONS (PVT) LTD.";
    $rtxsumhead = "Cheque Extend";
} else {
    $TXTHEAD = "TYRE HOUSE TRADING (PVT) LTD.";
    $rtxsumhead = "Cheque Extend";
}

   echo  "<center>
   		<table border=1 width=1000 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
   echo  "<tr align=center bgcolor=#00aaaa>";
   echo  "<td align=left><b>Ref No</b></td>";
   echo  "<td  align=left><b>Customer</b></td>";
   echo  "<td><b>Cheque No</b></td>";
   echo  "<td><b>Cheque Date</b></td>";
   echo  "<td><b>Amount</b></td>";
   echo  "<td><b>Extend Date</b></td>";
   echo  "</tr>";
   

		$rst_sql= "select * from s_cheque_extend where acc_approved = '0' and approved <> '0' ";
		$result_sql=mysqli_query($GLOBALS['dbinv'],$rst_sql);
		while($row_sql = mysqli_fetch_array($result_sql)){
		
		echo  "<tr align=center>";
   		echo  "<td align=left>".$row_sql["refno"]."</td>";
   		echo  "<td align=left>".$row_sql["c_name"]."</td>";
   		echo  "<td>".$row_sql["ch_no"]."</td>";
   		echo  "<td>".$row_sql["ch_date"]."</td>";
   		echo  "<td>".$row_sql["ch_amount"]."</td>";
   		echo  "<td>".$row_sql["ch_exdate"]."</td>";
   		echo  "</tr>";
		
		
	}  
	
	
  
   
	echo  "</table>";



?>
</body>
</html>
