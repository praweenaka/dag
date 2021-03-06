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
	font-size: 16px;
}

			
            table, td, th
            {
                border:0px solid black;
                font-family:Arial, Helvetica, sans-serif;
                padding:4px;
            }
            th
            {
                font-weight:bold;
                font-size:16px;
				border:1px solid black;

            }
            td
            {
                font-size:16px;
				border-bottom:none;
				border-top:none;
				border-left:none;
				border-right:none;
            }
-->
</style>
</head>

<body><center>
<?php 
require_once("connectioni.php");
	
	
	
	$sql_para="select * from invpara";
	$result_para =mysqli_query($GLOBALS['dbinv'],$sql_para);
	$row_para = mysqli_fetch_array($result_para);
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
    			 
		$sql="Select * from s_purrmas where REFNO='".$_GET["invno"]."'";
    	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
		$row = mysqli_fetch_array($result);			
        
		$sql1="Select * from vendor where CODE='".$row["SUP_CODE"]."'";
    	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
		$row1 = mysqli_fetch_array($result1);	
		
		$sql2="Select * from viewarn where REFNO='".$_GET["invno"]."' order by ID";
		//echo $sql2;
    	$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 	
		
	?>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="128" align="center">    </td>
    <td colspan="2" align="center"></td>
  </tr>
    <tr>
    <td colspan="4" scope="col" align="center"><strong>Purchase Return</strong></td>
  </tr>
  <tr>
    <td width="131">Supplier Code</td>
    <td width="496"><?php echo $row["SUP_CODE"]; ?></td>
    <td width="128">REF No</td>
    <td width="240"><?php echo $row["REFNO"]; ?></td>
  </tr>
  <tr>
    <td>Supplier Name</td>
    <td><?php echo $row["SUP_NAME"]; ?></td>
    <td>ARN No</td>
    <td><?php echo $row["ORDNO"]; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Date</td>
    <td><?php echo $row["SDATE"]; ?></td>
  </tr>
  <tr>
    <td colspan="4"><table width="1000" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th width="101" scope="col">Item Code</th>
        <th width="359" scope="col">Item Description</th>
   		 <th width="148" scope="col">Cost</th>
       <th width="148" scope="col">Qty</th>
       
        <th width="244" scope="col">Sub Total</th>
      </tr>
     <?php
	 	$tot=0;
		$sql_trn="select * from s_purrtrn where REFNO='".$row["REFNO"]."'";
		//echo $sql_trn;
		$result_trn =mysqli_query($GLOBALS['dbinv'],$sql_trn);	
	 	while ($row_trn = mysqli_fetch_array($result_trn)){			 
      echo "<tr>
        <td align=center>".$row_trn["STK_NO"]."</td>
        <td>".$row_trn["DESCRIPT"]."</td>";
		
		
				
        echo "<td align=center>".$row_trn["acc_COST"]."</td>
        <td align=center>".number_format($row_trn["REC_QTY"], 0, ".", ",")."</td>
		<td align=right>".number_format(($row_trn["acc_COST"]*$row_trn["REC_QTY"]), 2, ".", ",")."</td>
        
		
      </tr>";
	  	$tot=$tot+($row_trn["acc_COST"]*$row_trn["REC_QTY"]);
	  }
      ?>
      
      <tr>
        <td scope="col" colspan="3"></td>
       
        <td width="148" scope="col"><b>Total</b></td>
        <td width="244"  align="right"><b><?php  echo number_format($tot, 2, ".", ","); ?></b></td>
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
