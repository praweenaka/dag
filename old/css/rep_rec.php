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


-->
</style>
</head>

<body><center>

<?php 
require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$sql="select * from s_crec where CA_REFNO='".$_GET["invno"]."'";
	$result =$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	$sql1="select * from vendor where CODE='".$row["CA_CODE"]."'";
	$result1 =$db->RunQuery($sql1);
	$row1 = mysql_fetch_array($result1);
	$address=$row1["ADD1"]." ".$row1["ADD2"];
	
	$sql_para="select * from invpara";
	$result_para =$db->RunQuery($sql_para);
	$row_para = mysql_fetch_array($result_para);
	?>
    
    
<table width="922" height="428" border="0">
   <tr>
    <th colspan="2" scope="col"><span class="companyname"><?php echo $row_para["COMPANY"]; ?></span></th>
    <th scope="col">&nbsp;</th>
    <th scope="col"></th>
  </tr>
  <tr>
    <th colspan="2" scope="col"><span class="com_address"><?php echo $row_para["ADD1"]; ?></span></th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
  </tr>
  
   <tr>
    <th colspan="4" scope="col">&nbsp;</th>
    
  </tr>
  
  <tr>
    <td width="130">Customer :</td>
    <td  width="400"><?php echo $row1["CODE"]; ?></td>
    <td width="100">Receipt No :</td>
    <td width="207"><?php echo $_GET["invno"]; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $row1["NAME"]; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    
    <td><?php echo $address; ?></td>
    <td>Date :</td>
    <td><?php echo $row["CA_DATE"]; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
  <tr>
    <td>Invoice Details
	</td>
    <td width="420">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4"><table width="922" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <th width="170" scope="col">Inv. Date</th>
        <th width="170" scope="col">Inv. No</th>
        <th width="170" scope="col">Inv. Amount</th>
        <th width="170" height="22">Paid</th>
       <th width="170" height="22">Balance</th>
      </tr>
     <?php 
	 $totpay=0;
	 
	 $sql_inv="select * from tmp_utilization where recno='".$_GET["invno"]."'";
	 $result_inv =$db->RunQuery($sql_inv);
	 while ($row_inv = mysql_fetch_array($result_inv)){
      echo "<tr>
        <td align=center>".$row_inv["invdate"]."</td>
        <td align=center>".$row_inv["invno"]."</td>";
		
		$sql_sal="select * from s_salma where REF_NO='".$row_inv["invno"]."'";
	 	$result_sal =$db->RunQuery($sql_sal);
	 	$row_sal = mysql_fetch_array($result_sal);
        echo "<td align=center>".number_format($row_sal["GRAND_TOT"], 2, ".", ",")."</td>
        <td align=center>".number_format($row_inv["settled"], 2, ".", ",")."</td>";
		
		$bal=$row_sal["GRAND_TOT"]-$row_inv["settled"];
		echo "<td align=center>".number_format($bal, 2, ".", ",")."</td>
      </tr>";
	  	$totpay=$totpay+$row_inv["settled"];
	  }
	  ?>
     
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center">Total Invoice Payment Amount</td>
    <td><?php echo number_format($totpay, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>Cheque Details
	</td>
    <td width="420">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4"><table width="922" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <th width="170" scope="col">Ch. Date</th>
        <th width="170" scope="col">Ch. No</th>
        <th width="170" scope="col">Bank</th>
        <th width="170" height="22">Ch. Amount</th>
       
      </tr>
     <?php 
	 $totchq=0;
	 
	 $sql_inv="select * from tmp_cash_chq where recno='".$_GET["invno"]."'";
	 $result_inv =$db->RunQuery($sql_inv);
	 while ($row_inv = mysql_fetch_array($result_inv)){
      echo "<tr>
        <td align=center>".$row_inv["chqdate"]."</td>
        <td align=center>".$row_inv["chqno"]."</td>
		<td align=center>".$row_inv["chqbank"]."</td>
		<td align=center>".number_format($row_inv["chqamt"], 2, ".", ",")."</td>
      </tr>";
	  	$totchq=$totchq+$row_inv["chqamt"];
	  }
	  
	  $tot=$totchq+$row_inv["CA_CASSH"];
	  
	  
	  ?>
     
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center">Total Cheque Payment </td>
    <td><?php echo number_format($totchq, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table width="1000" border="0">
      <tr>
        <th width="197" scope="col"><?php if ($totchq>0) {echo "Payment By cheque"; }?></th>
        <th width="202" scope="col" align="right"><?php if ($totchq>0) {echo number_format($totchq, 2, ".", ",");} ?></th>
        <th width="230" scope="col">&nbsp;</th>
        <th width="163" scope="col">&nbsp;</th>
        <th width="186" scope="col">&nbsp;</th>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <th scope="col" align="right"><?php if ($row_inv["CA_CASSH"]>0) {echo number_format($row_inv["CA_CASSH"], 2, ".", ",");} ?></th>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
         <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>_______________________</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>_______________________</td>
      </tr>
      <tr>
        <td>Entered by</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Checked by</td>
      </tr>
</table>
</body>
</html>
