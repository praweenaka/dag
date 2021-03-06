<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print ARN</title>
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
	
	$sql_para="select * from invpara";
	$result_para =$db->RunQuery($sql_para);
	$row_para = mysql_fetch_array($result_para);
	?>
    
<table width="1000" border="0">
  <tr>
    <td colspan="5" align="center"><span class="companyname"><?php echo $row_para["COMPANY"]; ?></span></td>
  </tr>
  <tr>
    <td colspan="5" align="center"><span class="com_address"><?php echo $row_para["ADD1"]; ?></span></td>
  </tr>
   <?php
		//echo $_GET["invno"];
    			 
		$sql="Select * from s_purmas where REFNO='".$_GET["invno"]."'";
    	$result =$db->RunQuery($sql);	
		$row = mysql_fetch_array($result);			
        
		$sql1="Select * from vendor where CODE='".$row["SUP_CODE"]."'";
    	$result1 =$db->RunQuery($sql1);	
		$row1 = mysql_fetch_array($result1);	
		
		$sql2="Select * from viewarn where REFNO='".$_GET["invno"]."' order by ID";
		//echo $sql2;
    	$result2 =$db->RunQuery($sql2);	
		
	?>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="130" align="center">    </td>
    <td colspan="2" align="center"></td>
  </tr>
    <tr>
    <th colspan="4" scope="col">Arrival Note</th>
  </tr>
  <tr>
    <td width="115">Supplier Code</td>
    <td width="701"><?php echo $row1["CODE"]; ?></td>
    <td width="130">LC No</td>
    <td width="242"><?php echo $row["LCNO"]; ?></td>
  </tr>
  <tr>
    <td>Supplier Name</td>
    <td><?php echo $row1["NAME"]; ?></td>
    <td>ARN No</td>
    <td><?php echo $row["REFNO"]; ?></td>
  </tr>
  <tr>
    <td>Country</td>
    <td><?php echo $row["COUNTRY"]; ?></td>
    <td>Date</td>
    <td><?php echo $row["SDATE"]; ?></td>
  </tr>
  <tr>
    <td colspan="4"><table width="1200" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <th width="200" scope="col">Item Code</th>
        <th width="600" scope="col">Item Description</th>
        <th width="170" scope="col">Part No</th>
        <th width="170" scope="col">Stock</th>
        <th width="150" height="22">Order Qty</th>
        <th width="150" scope="col">R.Qty</th>
        <th width="150" scope="col">Q.Hand</th>
        <th width="212" scope="col">FOB</th>
        <th width="212" scope="col">Cost</th>
        <th width="212" scope="col">Mar.</th>
        <th width="212" scope="col">Selling</th>
        <th width="212" scope="col">Sub Total</th>
      </tr>
     <?php
	 	$tot=0;
	 	while ($row2 = mysql_fetch_array($result2)){			 
      echo "<tr>
        <td align=center>".$row2["STK_NO"]."</td>
        <td>".$row2["DESCRIPT"]."</td>";
	
        echo "<td align=center>".$row2["PART_NO"]."</td>
        <td align=right>".number_format($row2["QTYINHAND"], 0, ".", ",")."</td>
        <td align=right>".number_format($row2["O_QTY"], 0, ".", ",")."</td>
        <td align=right>".number_format($row2["REC_QTY"], 0, ".", ",")."</td>
        <td align=right>".number_format(($row2["QTYINHAND"]+$row2["REC_QTY"]), 0, ".", ",")."</td>
        <td align=right>".number_format($row2["FOB"], 2, ".", ",")."</td>
		<td align=right>".number_format($row2["COST"], 2, ".", ",")."</td>
		<td align=right>".number_format($row2["MARGIN"], 2, ".", ",")."</td>
		<td align=right>".number_format($row2["SELLING"], 2, ".", ",")."</td>
		<td align=right>".number_format(($row2["COST"]*$row2["REC_QTY"]), 2, ".", ",")."</td>
		
      </tr>";
	  	$tot=$tot+($row2["COST"]*$row2["REC_QTY"]);
	  }
      ?>
      
      <tr>
        <th width="170" scope="col" colspan="10"></th>
       
        <th width="212" scope="col">Total</th>
        <th width="212" scope="col"><?php  echo $tot; ?></th>
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
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>__________________________</td>
    <td>&nbsp;</td>
    <td>__________________________</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Prepared By</td>
    <td>&nbsp;</td>
    <td>Authorised By</td>
  </tr>
</table>
</body>
</html>
