<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Battry Card Report</title>

<style>
	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 16px;
	}
	table {
		border-collapse: collapse;
	}
	table, td, th {

		font-family: Arial, Helvetica, sans-serif;
		padding: 5px;
	}
	th {
		font-weight: bold;
		font-size: 12px;
	}
	td {
		font-size: 12px;
		border-bottom: thick;
	}
</style>

</head>

<body><center>


<p>
  <?php

require_once ("connectioni.php");

 

$sql_head = "select * from invpara";
$result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
$row_head = mysqli_fetch_array($result_head);

//////////////////////

$txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

$sql = "SELECT * from view_s_ut   where C_DATE='" . $_GET["dtfrom"] . "' order by C_DATE ";
?>
</p>
<table width="1000" border="0">
  <tr>
    <td colspan="6" align="center"><b><?php echo $rtxtComName; ?></b></td>
  </tr>
  <tr>
    <td colspan="6" align="center"><?php echo $rtxtcomadd1; ?></td>
    
  </tr>
  <tr>
    <td colspan="6" align="center"><?php echo $rtxtComAdd2; ?></td>
   
  </tr>
  <tr>
    <td colspan="6"><b><?php echo $txthead; ?></b></td>
  
  </tr>
  <tr>
    <td colspan="6"><table width="1000" border="1">
      <tr>
        <td ><b>Ref No</b></td>
        <td ><b>Date</b></td>
        <td ><b>GRN No</b></td>
        <td ><b>GRN Date</b></td>
        <td ><b>Ref INV/Ret. Ch</b></td>
        <td ><b>Customer</b></td>
        <td ><b>Amount</b></td>
       
      </tr>
     <?php
		$C_PAYMENT = 0;

		$result = mysqli_query($GLOBALS['dbinv'], $sql);
		while ($row = mysqli_fetch_array($result)) {
			echo "<tr>
        <td>" . $row["C_REFNO"] . "</td>
        <td>" . $row["C_DATE"] . "</td>
        <td>" . $row["CRE_NO_NO"] . "</td>
        <td>" . $row["grndate"] . "</td>
        <td>" . $row["C_INVNO"] . "</td>
        <td>" . $row["C_CODE"] . " " . $row["name"] . "</td>
        <td align=right>" . number_format($row["C_PAYMENT"], 2, ".", ",") . "</td>
       
      </tr>";
			$C_PAYMENT = $C_PAYMENT + $row["C_PAYMENT"];
		}
	 ?> 
     
      <tr>
        <td colspan="6" >Total</td>
        
        <td  align="right"><b><?php echo number_format($C_PAYMENT, 2, ".", ","); ?></b></td>
       
      </tr>
      
    </table></td>
  </tr>
 
</table>
<p>&nbsp;</p>
</body>
</html>
