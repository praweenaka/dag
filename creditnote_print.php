<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print CRN</title>
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
	font-size: 17px;

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
  
<table width="922" height="378" border="0">
  <?php
		//echo $_GET["invno"];
    		//	$sql="Insert into cred (C_REFNO, C_DATE, C_INVNO, C_CODE, C_PAYMENT, C_REMARK, C_SALEX, Brand, DEV, DEPARTMENT, cus_ref) values 
			///('".$_GET["crnno"]."', '".$_GET["crndate"]."', '".$_GET["invno"]."', '".$_GET["cus_code"]."', '".$_GET["amount"]."', '".$_GET["remarks"]."', '".$_GET["salesrep"]."', '".$_GET["brand"]."', '".$_SESSION['dev']."', 'O', '0') ";
			//$result =$db->RunQuery($sql);	
			
		//	$sql="Insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, vatrate, RNO, flag1, DEV, CANCELL, old, active, totpay) values 
		//	('".$_GET["crnno"]."', '".$_GET["crndate"]."', 'CNT', '".$_GET["cus_code"]."', '".$_GET["amount"]."', '".$_GET["amount"]."', '".$_GET["brand"]."', '".$_GET["department"]."', '".$_GET["salesrep"]."', '".$mvatrate."', '".$_GET["txtrno"]."', '".$mcash."', '".$_SESSION['dev']."', '0', '0', 1, 0) ";
		//	$result =$db->RunQuery($sql);	
			
			 
		$sql="Select * from cred where C_REFNO='".$_GET["invno"]."'";
    	$result =$db->RunQuery($sql);	
		$row = mysql_fetch_array($result);			
        
		$sql1="Select * from vendor where CODE='".$row["C_CODE"]."'";
    	$result1 =$db->RunQuery($sql1);	
		$row1 = mysql_fetch_array($result1);	
		
		$sql_bal="Select * from c_bal where REFNO='".$_GET["invno"]."' and trn_type='CNT'";
    	$result_bal =$db->RunQuery($sql_bal);	
		$row_bal = mysql_fetch_array($result_bal);			
		
		
		
	?>
  
   <tr>
    <th colspan="5" scope="col" class="heading">Credit Note</th>
  </tr>
   
   
  <tr>
  <td height="74" colspan="5" scope="col">
  <table cellpadding="0" cellspacing="0" border="0"><tr><td>
  <table border="0">
  <tr>
    <td width="150" align="left">Customer Code :- </td>
    <td width="600" align="left"><?php echo $row1["CODE"]; ?></td>
    <td width="170" align="left">CRN No :- </td>
    <td width="266" align="left"><?php echo $row["C_REFNO"]; ?></td>
  </tr>
  <tr>
    <td align="left">Customer Name :- </td>
    <td align="left"><?php echo $row1["NAME"]; ?></td>
    <td align="left">Date :- </td>
    <td align="left"><?php echo $row["C_DATE"]; ?></td>
  </tr>
  <tr>
<!--    <td align="left">Department :- </td>
    <?php
		/*$sql_dep="Select * from s_stomas where CODE='".$row_bal["DEP"]."'";
    	$result_dep =$db->RunQuery($sql_dep);	
		$row_dep = mysql_fetch_array($result_dep);		 */
	?>
    <td align="left"><?php //echo $row_bal["DEP"]." - ".$row_dep["DESCRIPTION"]; ?></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">Sales Rep :- </td>
    <?php
	/*	$sql_ex="Select * from s_salrep where REPCODE='".$row_bal["DEP"]."'";
    	$result_ex =$db->RunQuery($sql_ex);	
		$row_ex = mysql_fetch_array($result_ex);	*/	 
	?>
    <td align="left"><?php //echo $row["C_SALEX"]." - ".$row_ex["Name"]; ?></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>-->
  </table>
  </td></tr></table>  </td>
  </tr>
  
    <tr>
  <td height="74" colspan="5" scope="col">
  <table cellpadding="0" cellspacing="0" border="1"><tr><td>
  <table border="0">
  <tr>
    <td width="150" height="95" align="left" valign="top">Remarks :- </td>
    <td width="836" align="left" valign="top"><?php echo $row["C_REMARK"]; ?></td>
    </tr>
  </table>
  </td></tr></table>  </td>
  </tr>
          
            <tr>
              <td width="261">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
              <td><b>CRN Amount</b></td>
              <td width="182" align="right"><b><?php echo number_format($row["C_PAYMENT"], 2, ".", ","); ?></b></td>
            </tr>
  
   
    <tr>
      <td>&nbsp;</td>
      <td width="214">&nbsp;</td>
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
    <td><b><?PHP if($row["CANCELL"]=="1") echo "CANCELED";?></b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="115">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>_____________________</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>__________________________</td>
  </tr>
  <tr>
    <td>Prepared By</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>Authorised By</td>
  </tr>
</table>
</body>
</html>
