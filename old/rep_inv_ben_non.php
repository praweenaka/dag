<?php session_start();
?>
<?php date_default_timezone_set('Asia/Colombo'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Invoice</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 17px;
}

.style3 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 17px;
	font-weight:bold;
}
-->
</style>
</head>

<body><center>
<?php 
require_once("connectioni.php");
	
	
	
	$sql="Select * from s_salma where REF_NO='".$_GET["invno"]."'";
    	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
		$row = mysqli_fetch_array($result);			
        
		$sql1="Select * from vendor where CODE='".$row["C_CODE"]."'";
    	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
		$row1 = mysqli_fetch_array($result1);	
		
		$sql2="Select * from s_stomas where CODE='".$row["DEPARTMENT"]."'";
    	$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 	
		$row2 = mysqli_fetch_array($result2);
				
		$TXTDEP= $row2["DESCRIPTION"];
		$rtxtinvno= $row["invno"];
		$rtxtordno= $row["ORD_NO"]; 
		
		$sql2="Select * from s_salrep where REPCODE='".$row["SAL_EX"]."'";
    	$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 	
		$row2 = mysqli_fetch_array($result2);
		
		$rtxtrep = $row2["Name"];
		$rtxtSupCode= $row1["CODE"];
		$rtxtSupName=  $row1["NAME"];
		$txtadd1 = $row1["ADD1"];
		$txtadd2 = $row1["ADD2"];
		$txtadd = $row1["ADD1"]."</br>".$row1["ADD2"];
		$rtxtdate=date("Y-m-d", strtotime($row["SDATE"]));
		$rtxttot = $row["GRAND_TOT"];

		
		$VAT_per=$row["VAT"];
		
    	
		$sql_para="Select * from invpara ";
    	$result_para =mysqli_query($GLOBALS['dbinv'],$sql_para);	
		$row_para = mysqli_fetch_array($result_para);

		if ($row["VAT"]=="1") {
    		//$txtcusvat= "Customer VAT  " . $row1["vatno"];
			$txtcusvat= "Customer VAT  " . $_GET["vat1"];
    		$txtcomvat= "VAT Reg. " . $row_para["VAT"];
    		$RTXTVAT = "VAT 12%  ";
    		//$RTXVATAMU = $row["BTT"];
    		$txttaxinv = "<b>TAX INVOICE</b>";
    		$txtsubtot = $row["AMOUNT"];
    		$txtsubtotdes= "Sub Total";
		}
		
		if ($row["SVAT"]!="0") {
    		//$txtcusvat= "Customer VAT  " . $row1["vatno"];
			$txtcusvat= "Customer VAT  " . $_GET["vat1"];
    		$txtcomvat= "VAT Reg. " . $row_para["VAT"];
    		$RTXTVAT = "Suspended VAT 12%  ";
    		//$RTXVATAMU= $row["BTT"];
    		$txttaxinv= "<b>SUSPENDED TAX INVOICE</b>";
    		$txtsubtot= $row["AMOUNT"];
    		$txtsubtotdes = "Net Total";
    
    		$txtoursvat = "SVAT Reg. " . $row_para["svatno"];
    		//$txtcussavat= "Customer SVAT " . $row1["svatno"];
			$txtcussavat= "Customer SVAT " . $_GET["vat2"];
    
		}

	?>
    
<table width="1000" height="159" border="0">
  <tr>
    <td height="59" colspan="7" align="center"><p>BENEDICTSONS  (PVT) LTD</p>      <p>SCRAP INVOICE</p></td>
  </tr>
  
  
  <tr>
    <td height="21">&nbsp;</td>
    <td colspan="4"><span class="style2"><?php echo $txtoursvat; ?></span></td>
    <td>Invoice No</td>
    <td><span class="style2">
      <?php
	
		echo $_GET["invno"];
    	
	?>
    </span></td>
  </tr>
  <tr>
    <td width="121" height="21"><span class="style2"><?php echo $rtxtSupCode; ?></span></td>
    <td colspan="4"><span class="style2"><?php 
	$txtCNAME=str_replace("~", "&", $_GET['cus_name']);
	echo $txtCNAME; ?></span></td>
    <td width="97">Invoice Date</td>
    <td width="142"><span class="style2"><?php echo $rtxtdate; ?></span></td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td height="21" colspan="4"><span class="style2"><?php 
	
	$cus_address1=str_replace("~", "&", $_GET['cus_address']);
	$cus_address2=str_replace("~", "&", $_GET['cus_address2']);
	$cus_address=$cus_address1."</br>".$cus_address2;
	echo $cus_address; ?></span></td>
    <td height="21"><span class="style2"></span></td>
    <td height="21"><?php echo $rtxtordno; ?></td>
  </tr>
  

  <tr>
    <td height="25" colspan="2">&nbsp;</td>
    <td colspan="2"></td>
    <td width="383">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="1000" height="81" border="1" cellspacing="0" cellpadding="0">
  <tr >
        <td width="130" height="23"><span class="style1">ITEM NO</span></td>
        <td width="295"><span class="style1">DESCRIPTION</span></td>
        <td width="158"><span class="style1">PRICE</span></td>
        <td width="135"><span class="style1">QTY</span></td>
        <td width="152"><span class="style1">TOTAL</span></td>
  </tr> 
      <?php 
	  	$i=1;
		$totsuntot=0;
		
	  	$sql1="Select * from s_invo where REF_NO='".$_GET["invno"]."'";
    	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
		while ($row1 = mysqli_fetch_array($result1)){
			$sql_part="Select * from s_mas where STK_NO='".$row1["STK_NO"]."'";
    		$result_part =mysqli_query($GLOBALS['dbinv'],$sql_part);	
			$row_part = mysqli_fetch_array($result_part);
			
			if (($VAT_per=="1") or ($VAT_per=="2")){
				$PRICE=$row1["PRICE"]/112*100;
			} else {
				$PRICE=$row1["PRICE"];
			}	
			
			
				
				echo "<tr><td><span class=\"style2\" width=100>".$row1["STK_NO"]."</span></td>
						<td><span class=\"style2\" width=500>".$row1["DESCRIPT"]."</span></td>
						<td  align=\"right\"  width=100><span class=\"style2\">".number_format($PRICE, 2, ".", ",")."</span></td>
						<td align=\"right\"  width=50><span class=\"style2\">".number_format($row1["QTY"], 0, ".", ",")."</span></td>";
						
						$discount1=$PRICE*$row1["QTY"]*$row1["Print_dis1"]/100;
						$subtot=($PRICE*$row1["QTY"])-$discount1;
				echo "<td align=\"right\"  width=100><span class=\"style2\">&nbsp;&nbsp;&nbsp;&nbsp;".number_format($subtot, 2, ".", ",")."</span></td>";
			
			
							
			echo "</tr>";
			$totsuntot=$totsuntot+$subtot;
			$i=$i+1;
		}	
	  
	  	if ($row["DIS1"] > 0) {
    		$txtspdis= "Special Discount   " . floatval($row["DIS1"]) . " %";
   		}
		
		if ($VAT_per=="1"){
       		$RTXVATAMU = $row["AMOUNT"]*0.12;
		} else {
			$RTXVATAMU="";
		}	
	   
    //	if ($row["VAT"]=="0") {
        	$txtdis2= $totsuntot/100 * $row["DIS1"];
    	//} else {
       // 	$txtdis2= (($totsuntot / (1 + $row["GST"] / 100)) / 100) * $row["DIS1"];
    	//}
		
	  		echo "<tr><td colspan=4 align=right><b>TOTAL</b></td>
			<td align=right><span class=\"style2\"><b>".number_format($totsuntot, 2, ".", ",")."</b></span></td>
			</tr>";
		
	   ?>
      
     
</table>
<table width="1000" border="0">
    	
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>___________________</td>
    <td width="122">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="203">&nbsp;</td>
    <td width="262" align="right">______________</td>
  </tr>
  <tr>
    <td>Entered By</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td align="right">Authorized by</td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
    
</body>
</html>
