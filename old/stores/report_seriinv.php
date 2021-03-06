<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Receipt</title>
<style type="text/css">
<!--
.companyname {
	color: #0000FF;
	font-weight: bold;
	font-size: 24px;
}

.com_address {
	color: #000000;
	font-weight: bold;
	font-size: 18px;
}

.heading {
	color: #000000;
	font-weight: bold;
	font-size: 20px;
}

body {
	color: #000000;
	font-size: 18px;
}
-->
</style>
</head>

<body><center>

<?php 
require_once("connectioni.php");
	
	
	
	 date_default_timezone_set('Asia/Colombo'); 
	 
	$sql="update s_salma set pirnt_serial='1' where REF_NO='".$_GET["invno"]."'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
	
	$sql1="select * from vendor where CODE='".$row["CA_CODE"]."'";
	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
	$row1 = mysqli_fetch_array($result1);
	$address=$row1["ADD1"]." ".$row1["ADD2"];
	
	$sql_para="select * from invpara";
	$result_para =mysqli_query($GLOBALS['dbinv'],$sql_para);
	$row_para = mysqli_fetch_array($result_para);
	?>
    
    
<table width="800" height="428" border="0">
   <tr height="10">
    <th colspan="2" scope="col"><span class="companyname"><?php 
		if ($_SESSION['company']=="THT"){
			echo "TYRE HOUSE TRADING (PVT) LTD"; 
		} if ($_SESSION['company']=="BEN"){
			echo "BENEDICTSONS (PVT) LTD"; 
		}	
			?></span></th>
    <th scope="col">&nbsp;</th>
    <th scope="col"></th>
  </tr>
 
  
  

 
 
  <tr height="40">
    <td width="100"><b>Invoice No - </b></td>
    <td><b><?php echo $_GET["invno"]; ?></b></td>
    <td width="150"><b>Print Date - </b></td>
    <td><b><?php echo date("Y-m-d"); ?></b></td>
  </tr>
  
  <tr>
    <td colspan="4" valign="top"><table width="800" border="1" cellpadding="0" cellspacing="0">
      
     <?php 
	$totpay=0;
	$totcashtot=0;
	$i=1;
	//$sql_inv1="select distinct invno from tmp_utilization where recno='".$_GET["invno"]."'";
	$sql_seri="select * from inv_serino where refno='".$_GET["invno"]."'";
	$result_seri =mysqli_query($GLOBALS['dbinv'],$sql_seri);
	while ($row_seri = mysqli_fetch_array($result_seri)){
		
		
		
			$a=floor($i/5);
			$j=$i-($a*5);
		
		
		if ($j==1){
			echo "<tr>";
        	echo "<td align=left>".$row_seri["serino"]."</td>";
		}
		if ($j==2){
        	echo "<td align=left>".$row_seri["serino"]."</td>";
		}
		if ($j==3){
        	echo "<td align=left>".$row_seri["serino"]."</td>";
		}
		if ($j==4){
        	echo "<td align=left>".$row_seri["serino"]."</td>";
		}
		if ($j==0){
        	echo "<td align=left>".$row_seri["serino"]."</td>";
			echo "</tr>";
		}	
        
		
		$i=$i+1;
	}
	
	
	
	  ?>
     
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr><tr><td>&nbsp;</td>
  </tr>



  <tr>
    <td colspan="4">
    
</body>
</html>
