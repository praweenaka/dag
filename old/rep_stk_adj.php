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
    
<table width="700" border="0">
  <tr>
    <td colspan="6" align="center"><span class="companyname"><?php echo $row_para["COMPANY"]; ?></span></td>
  </tr>
  <tr>
    <td colspan="6" align="center"><span class="com_address"><?php echo $row_para["ADD1"]; ?></span></td>
  </tr>
   <?php
		//echo $_GET["invno"];
    	
		

		$txtdate = date("Y-m-d", strtotime($_GET["invdate"]));

		$rtxtRefNo= trim($_GET["invno"]);
 
		if ($_GET["Addition"]=="true") {$txttype = "Stock Addition"; }
		if ($_GET["Deduction"]=="true") {$txttype = "Stock Deduction"; }
		
		$txtremarks = $_GET["spinst"];

		 
		
		
	?>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td width="167" align="center">    </td>
    <td colspan="2" align="center"></td>
  </tr>
    <tr>
    <th colspan="5" scope="col">Stock Adjestment</th>
  </tr>
  <tr>
    <td colspan="3"><?php echo $txttype; ?></td>
    <td width="167">Ref No</td>
    <td width="298"><?php echo $rtxtRefNo; ?></td>
  </tr>
  <tr>
    <td width="141">Remark</td>
    <td colspan="2"><?php echo $txtremarks; ?></td>
    <td>Date</td>
    <td><?php echo $txtdate; ?></td>
  </tr>
  
  <tr>
    <td colspan="5"><table width="700" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <th width="200" scope="col" >Stock No</th>
        <th width="400" scope="col">Description</th>
        <th width="170" scope="col">Qty</th>
      </tr>
     <?php
	 	$tot=0;
	 	$sql = "SELECT * from view_adj where refno= '" . trim($_GET["invno"]) . "'";
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
		while ($row = mysqli_fetch_array($result)){			 
      		echo "<tr>";
       
				
        	echo "<td align=center>".$row["stk_no"]."</td>
        	<td align=left>".$row["DESCRIPT"]."</td>
        	<td align=center>".number_format($row["qty"], 0, ".", ",")."</td>
     
		
      		</tr>";
			
			$tot = $tot + $row["qty"];
		}

			echo "<tr><td></td><td></td><th align=center>" . number_format($tot, 0, ".", ",")   . "</th></tr>";
	  
	 
      ?>
      
     
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>__________________________</td>
    <td width="208">&nbsp;</td>
    <td width="170">__________________________</td>
    <td>&nbsp;</td>
    <td>__________________________</td>
  </tr>
  <tr>
    <td>Entered By</td>
    <td>&nbsp;</td>
    <td>Checked  By</td>
    <td>&nbsp;</td>
    <td>Approved  By</td>
  </tr>
</table>
</body>
</html>
