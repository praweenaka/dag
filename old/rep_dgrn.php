<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print DGRN</title>
<style type="text/css">
<!--
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.style4 {
	font-size: 24px;
	
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
	
	
	
	        
	$txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");
	
	$txt_net=str_replace(",", "", $_GET["txt_net"]);	

	$sql_invpara="Select * from invpara ";
    $result_invpara =mysqli_query($GLOBALS['dbinv'],$sql_invpara);	
	$row_invpara = mysqli_fetch_array($result_invpara);
 
 
 	$sql_sql="SELECT * from viewdef where REFNO= '" . trim($_GET["txtrefno"]) . "'";
	//echo $sql_sql;
    $result_sql =mysqli_query($GLOBALS['dbinv'],$sql_sql);	
	$row_rsPrInv = mysqli_fetch_array($result_sql);
	
	/*$sql_c_clamas="SELECT * from c_clamas where cl_no= '" . trim($row_rsPrInv["cl_no"]) . "'";
	$result_c_clamas =mysqli_query($GLOBALS['dbinv'],$sql_c_clamas);	
	$row_c_clamas = mysqli_fetch_array($result_c_clamas);*/
	
	$rtxtDocdate= date("Y-m-d", strtotime($_GET["dtdate"]));

	$rtxtRefNo= trim($_GET["txtrefno"]);
	$rtxtComName = $row_invpara["COMPANY"];
	$rtxtcomadd1= $row_invpara["ADD1"];
	$rtxtComAdd2 =$row_invpara["ADD2"] . ", " . $row_invpara["ADD3"];
	$rtxtCusCode =$_GET["txt_cuscode"];
	$rtxtamo =number_format($txt_net, 2, ".", ",");
	
	if (is_null($row_rsPrInv["Ref_per"])==false) {
    	$rtxrefund = trim($row_rsPrInv["Ref_per"]);
	} else {
    	$sql_df_frm="Select * from c_clamas where DGRN_NO = '" . trim($_GET["txtrefno"]) . "'";
    	$result_df_frm =mysqli_query($GLOBALS['dbinv'],$sql_df_frm);	
		if ($row_df_frm = mysqli_fetch_array($result_df_frm)){
	    	$rtxrefund = trim($row_df_frm["rem_per"]);
        	if (trim($row_df_frm["rem_per"]) == "") { $rtxrefund= 100; }
        	$old = false;
    	} else {
        	$old = true;
    	}
		
		$sql_df_frm="Select * from c_clamas where DGRN_NO2 = '" . trim($_GET["txtrefno"]) . "'";
    	$result_df_frm =mysqli_query($GLOBALS['dbinv'],$sql_df_frm);	
		if ($row_df_frm = mysqli_fetch_array($result_df_frm)){
	    	$rtxrefund = trim($row_df_frm["add_ref1"]);
        	if (trim($row_df_frm["rem_per"]) == "") { $rtxrefund= 100; }
        	$old = false;
    	} else {
        	$old = true;
    	}
    	
    
    	$sql_df_frm="Select * from c_clamas where DGRN_NO2 = '" . trim($_GET["txtrefno"]) . "'";
    	$result_df_frm =mysqli_query($GLOBALS['dbinv'],$sql_df_frm);	
		if ($row_df_frm = mysqli_fetch_array($result_df_frm)){
        	$rtxrefund= trim($row_df_frm["add_ref1"]);
        	$old = false;
    	} else {
        	if ($old == false) {
            	$old = false;
        	} else {
            	$old = true;
        	}
    	}
    
    	
		$sql_df_frm="Select * from c_clamas where DGRN_NO3 = '" . trim($_GET["txtrefno"]) . "'";
    	$result_df_frm =mysqli_query($GLOBALS['dbinv'],$sql_df_frm);	
		if ($row_df_frm = mysqli_fetch_array($result_df_frm)){
	    	$rtxrefund = trim($row_df_frm["add_ref2"]);
        	$old = false;
    	} else {
        	if ($old == false) {
            	$old = false;
        	} else {
            	$old = true;
        	}
    	}
    
    	if ($old == true) { $rtxrefund = 100; }
	}
	
	
	
	if ($_GET["vatgroup_0"] == "vat") {
    	$rtxtamo = $txt_net / 1.12;
    	$Rtxamou = ((($txt_net / $rtxrefund) * 100) / (100 - $row_rsPrInv["dis"]) * 100) / 1.12;
    	$RTXVAT = ($txt_net / 1.12) * 12 / 100;
    	$RTXTOT = ($txt_net / 1.12) + (($txt_net / 1.12) * 12 / 100);
    	//$rtxvatno= VATNO;
	} else {
    	$rtxtamo = $txt_net;
    	$Rtxamou = (($txt_net / $rtxrefund) * 100) / (100 - $row_rsPrInv["dis"]) * 100;
    	
	}

	$rtxtCusname = $_GET["txt_cusname"];
	$rtxadd = $_GET["txtadd"];
	$rtxtdep = $_GET["com_dep"];
	$rtxtrep =$_GET["Com_rep"];
    	
		

		
	?>
    
<table width="922" height="474" border="0">
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="4" align="center"><span class="style4">Defective Goods Return Note</span></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="4" align="center">    <span class="style2"><?php echo $rtxtComName; ?></span></td>
    <td width="191">&nbsp;</td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" align="center"><span class="style2"><?php echo $rtxtcomadd1; ?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" align="center"><span class="style2" ><?php echo $rtxtComAdd2; ?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="109" height="21">Customer :-</td>
    <td width="103"><span class="style2"><?php echo $rtxtCusCode; ?></span></td>
    
    <?php
		$txt_cusname=str_replace("~", "&", $_GET["txt_cusname"]); 
	?>
    <td colspan="3"><?php echo $txt_cusname; ?></td>
    <td width="92">No</td>
    <td><?php echo $rtxtRefNo; ?></td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td height="21" colspan="4"><?php echo $rtxadd; ?></td>
    <td>Date</td>
    <td><?php echo $rtxtDocdate; ?></td>
  </tr>
  
  <tr>
    <td height="21">VAT No :-</td>
    <td height="21" colspan="4"><?php echo $rtxvatno; ?></td>
    <td>Claim No</td>
    <td><span class="style2"><?php echo $row_rsPrInv["CLAM_NO"]; ?></span></td>
  </tr>
  <tr>
    <td height="21">Department</td>
    <td height="21" colspan="2"><?php 
		$sqltmp="Select * from s_stomas where CODE='".$rtxtdep."'";
    	$resulttmp =mysqli_query($GLOBALS['dbinv'],$sqltmp);	
		$rowtmp = mysqli_fetch_array($resulttmp);
				
		
	echo $rowtmp["DESCRIPTION"]; ?></td>
    <td width="124">Sales Rep</td>
    <td width="264"><?php 
		$sqltmp="Select * from s_salrep where REPCODE='".$rtxtrep."'";
    	$resulttmp =mysqli_query($GLOBALS['dbinv'],$sqltmp);	
		$rowtmp = mysqli_fetch_array($resulttmp);
	echo $rowtmp["Name"]; ?></td>
    <td>Serial No</td>
    <td><?php echo $row_rsPrInv["BAT_NO"]; ?></td>
  </tr>
  
  
  <tr>
    <td height="89" colspan="7">
    <table width="904" border="0" cellspacing="0">
    <!--  <tr  bgcolor="#999999">
        <td width="130" height="23"><span class="style1">STK No</span></td>
        <td width="295"><span class="style1">Description</span></td>
        <td width="158"><span class="style1">Rate</span></td>
        <td width="135"><span class="style1">Quantity</span></td>
        <td width="152"><span class="style1">Sub Total</span></td>
        </tr> -->
     
      
     
    </table>
    <table cellpadding="0" cellspacing="0" border="1">
    <tr><td>
    <table><tr>
          <td align="center" width="100"><strong>Item Code</strong></td>
          <td align="center" width="500"><strong>Description</strong></td>
          <td align="center" width="100"><strong>Part No</strong></td>
          <td align="center" width="100"><strong>Rate</strong></td>
          <td align="center" width="100"><strong>Qty</strong></td>
          <td align="center" width="100"><strong>Discount</strong></td>
          <td align="center" width="100"><strong>Refund %</strong></td>
          <td align="center" width="150" ><strong>Refund Value</strong></td>
        </tr></table>
      </td></tr>
      <tr><td>  
      <table width="900" border="0">
        
        <tr>
          <td width="100"><?php echo $row_rsPrInv["STK_NO"]; ?></td>
          <td width="500" ><?php echo $row_rsPrInv["DESCRIPT"]; ?></td>
          <td align="center" width="100"><?php echo $row_rsPrInv["PART_NO"]; ?></td>
          <td align="center" width="100"><?php echo number_format($Rtxamou, 2, ".", ","); ?></td>
          <td align="center" width="100"><?php echo $row_rsPrInv["qty"]; ?></td>
          <td align="center" width="100"><?php echo $row_rsPrInv["dis"]; ?></td>
          <td  align="center" width="100"><?php echo $rtxrefund; ?></td>
          <td  align="center" width="150"><?php echo number_format($rtxtamo, 2, ".", ","); ?></td>
        </tr>
      </table>
    </td>
    </tr></table>  
      <table width="900" border="0">
        <tr>
          <td width="252" colspan="2" scope="col"><b><?php echo $row_rsPrInv["REsult"]." &nbsp;&nbsp;"; 
		  if ($row_rsPrInv["approve_md_wd"]=="MD"){
		  	echo "(Approved By MD)";
		  } else if ($row_rsPrInv["approve_md_wd"]=="WD"){
		  	echo "(Approved By WD)";
		  }
		  ?></b></td>
          <td width="265" scope="col">&nbsp;</td>
        </tr>
        <tr>
          <td width="252">&nbsp;</td>
          <td width="369">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><?php echo $row_rsPrInv["Remarks"]; ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>__________________</td>
          <td>&nbsp;</td>
          <td>___________________</td>
        </tr>
        <tr>
          <td>Prepared By</td>
          <td>&nbsp;</td>
          <td>Authorized By</td>
        </tr>
      </table>
    <p>&nbsp;</p></td>
  </tr>
  <tr><td colspan="7">&nbsp;</td>
  </tr>
</table>
</body>
</html>
