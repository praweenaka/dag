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
require_once("connectioni.php");
	
	
			 
		$sql="Select * from cred where C_REFNO='".$_GET["invno"]."'";
    	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
		$row = mysqli_fetch_array($result);			
        
		
		
		$sql_bal="Select * from c_bal where REFNO='".$_GET["invno"]."' and trn_type='CNT'";
    	$result_bal =mysqli_query($GLOBALS['dbinv'],$sql_bal);	
		$row_bal = mysqli_fetch_array($result_bal);	
	
		$sql1="Select c_main as CODE,c_name as NAME,c_svatno  as svatno ,c_vatno as vatno from vender_sub where c_code='".$row_bal["c_code1"]."'";
		//echo $sql1;
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1); 	
		if ($row1 = mysqli_fetch_array($result1)) {
			
			
			
		} else {
			
		$sql1="Select * from vendor where CODE='".$row["C_CODE"]."'";
    	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
		$row1 = mysqli_fetch_array($result1);	
		
		}
		
		
		$sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
		
		echo "<center><span class=\"companyname\">".$row_head["COMPANY"]."</span></center><br>";
		echo "<center><span class=\"com_address\">".$row_head["ADD1"]."</span></center><br>";
		 if (trim($row1['vatno']) != "") {
		echo "<center><span class=\"com_address1\">VAT Reg:".$row_head["VAT"];	  
		 }	 
		 if (trim($row1['svatno']) != "") {
		echo  "&nbsp;&nbsp;&nbsp;    " .  $row_head["svatno"];	  
		 }
		 if (trim($row1['vatno']) != "") {
		 echo "</span></center><br>";
		 }
		
	?>
  
<table width="922" height="378" border="0">
   
   <tr>
    <th colspan="5" scope="col" class="heading">Credit Note</th>
  </tr>
   
   
  <tr>
  <td height="74" colspan="5" scope="col">
  <table cellpadding="0" cellspacing="0" border="0"><tr><td>
  <table border="0">
  <tr>
    <td width="200" align="left">Customer Code :- </td>
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
  <?php 
     if (trim($row1['vatno']) != "") {
		 
	echo "<td align='left'>VAT No :-</td>" ;
    echo "<td align='left'>" . trim($row1['vatno']) . "</td>";
	 }
	 
	  if (trim($row1['svatno']) != "") {
	echo "<td align=\"left\">SVAT No :-</td>";
    echo "<td align=\"left\">" . trim($row1['svatno']) . "</td>";
	 }
  ?>	
    </tr>
  <tr>
 
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
  
  
  <?php
  
  
  $subamo = $row["C_PAYMENT"]/(1+($row_bal['vatrate']/100));
  $vatamo = $row["C_PAYMENT"] - $subamo;
  ?>
  
  <?php
  if (trim($row1['vatno']) != "") {
  
  ?>
  <tr>
      <td width="261">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td><b>Sub Total</b></td>
      <td width="182" align="right"><b><?php echo number_format($subamo, 2, ".", ","); ?></b></td>
  </tr>
  
  
  <tr>
      <td width="261">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
	  
	  <?php 
	  if (trim($row1['svatno']) == "") {
	  ?>
      <td><b>VAT <?php echo $row_bal['vatrate'];  ?>%  </b></td>
      <?php } else { ?>
      <td><b>SVAT <?php echo $row_bal['vatrate'];  ?>%  </b></td>	  
	  <?php } ?>
	  
	  <td width="182" align="right"><b><?php echo number_format($vatamo, 2, ".", ","); ?></b></td>
  </tr>
  
  <?php
  }
  
  ?>
  
    <tr>
      <td width="261">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td><b>CRN Amount</b></td>
      <td width="182" align="right"><b><?php echo number_format($row["C_PAYMENT"], 2, ".", ","); ?></b></td>
  </tr>
  <?php
  /*	$sql_rscrn="Select * from s_crnfrm where Refno='".$row_bal["DEP"]."'";
    $result_rscrn =mysqli_query($GLOBALS['dbinv'],$sql_rscrn);	
	$row_rscrn = mysqli_fetch_array($result_rscrn);	
		
  	rscrn.Open "Select * From S_crnfrm where Refno = '" & Trim(txt_frmno) & "'", dnINV.conINV
    m_Report.rtxfrmno.SetText txt_frmno
    m_Report.rtxcheck.SetText rscrn!Checked
    m_Report.rtxapprove.SetText rscrn!Approved
    m_Report.Text11.SetText rscrn!Approved */
  ?>
    <tr>
      <td>&nbsp;</td>
      <td width="214">&nbsp;</td>
      <td width="128">CRN Form No</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Checked</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Approved</td>
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
