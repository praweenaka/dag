<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
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
    
<table width="922" height="428" border="0">
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="4" align="center"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="105" align="center">    </td>
    <td colspan="2" align="center"></td>
    <td width="88">&nbsp;</td>
    <td width="211"><span class="style2">
      <?php
		echo $_GET["invno"];
    			 
		$sql="Select * from s_cusordmas where REF_NO='".$_GET["invno"]."'";
    	$result =$db->RunQuery($sql);	
		$row = mysql_fetch_array($result);			
        
		$sql1="Select * from vendor where CODE='".$row["C_CODE"]."'";
    	$result1 =$db->RunQuery($sql1);	
		$row1 = mysql_fetch_array($result1);	    
	?>
    </span></td>
  </tr>
  <tr>
    <td width="83" height="21">&nbsp;</td>
    <td width="78"><span class="style2"><?php echo $row1["CODE"]; ?></span></td>
    <td colspan="3"><span class="style2"><?php echo $row1["NAME"]; ?></span></td>
    <td width="88">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="21" colspan="2">&nbsp;</td>
    <td colspan="4"><span class="style2"><?php echo $row1["ADD1"]." ".$row1["ADD2"]; ?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="21" colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="119">&nbsp;</td>
    <td width="208"><span class="style2"><?php 
		$sql1="Select * from s_salrep where REPCODE='".$row["SAL_EX"]."'";
    	$result1 =$db->RunQuery($sql1);	
		$row1 = mysql_fetch_array($result1);
		echo $row1["Name"]; ?></span></td>
    <td>&nbsp;</td>
    <td><span class="style2"><?php echo $row["SDATE"]; ?></span><span class="style1"></td>
  </tr>
  
  <tr>
    <td height="199" colspan="7"><table width="904" height="81" border="1" cellspacing="0">
      <tr  bgcolor="#999999">
        <td width="130" height="23"><span class="style1">STK No</span></td>
        <td width="295"><span class="style1">Description</span></td>
        <td width="158"><span class="style1">Rate</span></td>
        <td width="135"><span class="style1">Quantity</span></td>
        <td width="152"><span class="style1">Sub Total</span></td>
        </tr>
      <?php 
	  	$sql1="Select * from tmp_ord_data where tmp_no='".$_SESSION["tmp_no_ord"]."'";
    	$result1 =$db->RunQuery($sql1);	
		while ($row1 = mysql_fetch_array($result1)){
			echo "<tr><td><span class=\"style2\">".$row1["str_code"]."</span></td><td><span class=\"style2\">".$row1["str_description"]."</span></td><td  align=\"right\"><span class=\"style2\">".number_format($row1["cur_rate"], 2, ".", ",")."</span></td><td align=\"right\"><span class=\"style2\">".number_format($row1["cur_qty"], 0, ".", ",")."</span></td><td align=\"right\"><span class=\"style2\">".number_format($row1["cur_subtot"], 2, ".", ",")."</span></td></tr>";
		
		}	
	  
	   ?>
      
      <tr>
        <td colspan="3" rowspan="3"></td>
        <td><span class="style1">Sub Total</span></td>
        <td align="right"><span class="style1"><?php echo number_format($row["AMOUNT"], 2, ".", ","); ?></span></td>
      </tr>
      <tr>
        <td><span class="style1">Discount</span></td>
        <td align="right"><span class="style1"><?php echo number_format($row["DISCOU"], 2, ".", ","); ?></span></td>
      </tr>
      <tr bgcolor="#999999">
        <td><span class="style1">Grand Total</span></td>
        <td align="right"><span class="style1"><?php echo number_format($row["GRAND_TOT"], 2, ".", ","); ?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
