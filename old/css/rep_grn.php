<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print GRN</title>
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
	font-size: 24px;
}

body {
	color: #000000;
	font-size: 14px;
}
-->
</style>
</head>

<body><center>
<?php 
require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	?>
    
<table width="902" height="428" border="0">
  
        <?php
		
    			 
		$sql="Select * from s_crnma where REF_NO='".$_GET["invno"]."'";
    	$result =$db->RunQuery($sql);	
		$row = mysql_fetch_array($result);			
        
		$sql1="Select * from vendor where CODE='".$row["C_CODE"]."'";
    	$result1 =$db->RunQuery($sql1);	
		$row1 = mysql_fetch_array($result1);
		
		$sql2="Select * from s_crntrn where REF_NO='".$_GET["invno"]."'";
    	$result2 =$db->RunQuery($sql2);		    
	?>
  <tr>
    <td colspan="2" rowspan="2" scope="col"><span class="heading">Good Return Note</span></td>
    <td scope="col">GRN No</td>
    <td scope="col"><?php echo $row["REF_NO"]; ?></td>
  </tr>
  <tr>
    <td scope="col">GRN Date</td>
    <td scope="col"><?php echo $row["SDATE"]; ?></td>
  </tr>
  <tr>
    <td width="161">Sales Reference - </td>
    <td width="452"><?php echo $row["SAL_EX"]; ?></td>
    <td width="113">&nbsp;</td>
    <td width="184">&nbsp;</td>
  </tr>
  <tr>
    <td>Return By -</td>
    <td><?php echo $row["C_CODE"]." - ".$row["CUS_NAME"]; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $row1["ADD1"].", ".$row1["ADD2"]; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table width="922" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <th width="102" scope="col">Stk No</th>
        <th width="259" scope="col">Description</th>
        <th width="98" scope="col">Part No</th>
        <th width="117" scope="col">Rate</th>
        <th width="79" height="22">Qty</th>
        <th width="74" scope="col">D%</th>
        <th width="177" scope="col">Amount</th>
      </tr>
      <?php
	  
	  while ($row2 = mysql_fetch_array($result2)){
      
	  echo "<tr>
        <td>".$row2["STK_NO"]."</td>
        <td>".$row2["DESCRIPT"]."</td>";
		
		$sql_stk="Select * from s_mas where STK_NO='".$row2["STK_NO"]."'";
    	$result_stk =$db->RunQuery($sql_stk);	
		$row_stk = mysql_fetch_array($result_stk);
        
		echo "<td>".$row_stk["PART_NO"]."</td>";
	/*	if ($row2["VAT"]=="1"){
			$rate=$row2["PRICE"]/(1+$row["GST"]/100);
		} else {
			$rate=$row2["PRICE"];
		}	 */
        echo "<td>".number_format($row2["PRICE"], 2, ".", ",")."</td>
        <td>".number_format($row2["QTY"], 0, ".", ",")."</td>
        <td>".$row2["DIS_P"]."</td>";
		
		if ($row2["VAT"]=='1') {
    		if (is_null($row2["DIS_P"])==false) {
        		$amount=($row2["QTY"]*$row2["PRICE"]-$row2["QTY"]*$row2["PRICE"]*$row2["DIS_P"]/100)/ (1+ $row["GST"]/100);
    		} else {
        		$amount=$row2["QTY"]*$row2["PRICE"]/(1+ $row["GST"]/100);
			}	
		} else {
			if (is_null($row2["DIS_P"])==false) {
        		$amount=$row2["QTY"]*$row2["PRICE"]-$row2["QTY"]*$row2["PRICE"]*$row2["DIS_P"]/100;
    		} else {
        		$amount=$row2["QTY"]*$row2["PRICE"];
			}
		}		
       echo " <td align=right>".number_format($amount, 2, ".", ",")."</td>
     
      </tr>";
	  }
	  ?>
      <tr>
        <td colspan="5">&nbsp;</td>
        <?php
	  
		$sql_vat="Select SVAT from s_salma where REF_NO='".$_GET["invoiceno"]."'";
    	$result_vat =$db->RunQuery($sql_vat);	
		$row_vat = mysql_fetch_array($result_vat);
		      
        if ($row_vat["SVAT"] > 0) {
            $txtvat= "SVAT 12%: ";
        } else {
            $txtvat= "VAT 12%: ";
        }
        
    
		
	 ?>   
        <td><?php echo $txtvat; ?></td>
        <td align="right"><?php echo number_format($_GET["tax"], 2, ".", ","); ?></td>
      </tr>
      
      <tr>
        <td colspan="6">&nbsp;</td>
        <td align="right"><?php echo number_format($_GET["invtot"], 2, ".", ",") ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>_______________________</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>__________________________</td>
  </tr>
  <tr>
    <td>Entered By</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Checked by</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
