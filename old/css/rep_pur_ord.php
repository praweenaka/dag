<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Purchase Order</title>
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
		
		$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"companyname\">".$row_head["COMPANY"]."</span></center><br>";
		echo "<center><span class=\"com_address\">".$row_head["ADD1"]."</span></center><br>";
	?>
  
<table width="922" height="428" border="0">
  <?php
		//echo $_GET["invno"];
    			 
		$sql="Select * from s_ordmas where REFNO='".$_GET["invno"]."'";
    	$result =$db->RunQuery($sql);	
		$row = mysql_fetch_array($result);			
        
		$sql1="Select * from vendor where CODE='".$row["SUP_CODE"]."'";
    	$result1 =$db->RunQuery($sql1);	
		$row1 = mysql_fetch_array($result1);	
		
		$sql2="Select * from s_ordtrn where REFNO='".$_GET["invno"]."'";
    	$result2 =$db->RunQuery($sql2);	
		
	?>
  
   <tr>
    <th colspan="4" scope="col" class="heading">Purchase Order</th>
  </tr>
   </tr>
   <tr>
    <th colspan="4" scope="col">&nbsp;</th>
  </tr>
  <tr>
  <th colspan="4" scope="col">
  <table cellpadding="0" cellspacing="0" border="1"><tr><td>
  <table border="0">
  <tr>
    <td width="150" align="left">ORD No</td>
    <td width="600" align="left"><?php echo $row["REFNO"]; ?></td>
    <td width="170" align="left">LC No</td>
    <td width="266" align="left"><?php echo $row["LC_No"]; ?></td>
  </tr>
  <tr>
    <td align="left">Supplier Code</td>
    <td align="left"><?php echo $row1["CODE"]; ?></td>
    <td align="left">Schedule Date</td>
    <td align="left"><?php echo $row["S_date"]; ?></td>
  </tr>
  <tr>
    <td align="left">Supplier Name</td>
    <td align="left"><?php echo $row1["NAME"]; ?></td>
    <td align="left">Order Date</td>
    <td align="left"><?php echo $row["SDATE"]; ?></td>
  </tr>
  </table>
  </td></tr></table>
  </th>
  </tr>
  
  <tr>
    <td colspan="4"><table width="1000" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <th width="100" height="22" scope="col">Item Code</th>
        <th width="600" scope="col">Item Description</th>
        <th width="150" scope="col">Part No</th>
        <th width="150" scope="col">Qty</th>
      </tr>
      <?php 
	  	$ORD_QTY=0;
		
	  	while($row2 = mysql_fetch_array($result2)){	
      
	  echo "<tr>
        <td align=center>".$row2["STK_NO"]."</td>
        <td>".$row2["DESCRIPT"]."</td>
        <td>".$row2["partno"]."</td>
        <td align=right>".$row2["ORD_QTY"]."</td>
      </tr>";
	  $ORD_QTY=$ORD_QTY+$row2["ORD_QTY"];
	  }
	  ?>
      
      <tr>
        <th  scope="col" colspan="3" align="right">Total Qty</th>
        <th  scope="col" align="right"><?php echo $ORD_QTY; ?></th>
     
      </tr>
    </table>
   
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>_____________________</td>
    <td>&nbsp;</td>
    <td width="500">&nbsp;</td>
    <td>__________________________</td>
  </tr>
  <tr>
    <td>Prepared By</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Authorised By</td>
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
