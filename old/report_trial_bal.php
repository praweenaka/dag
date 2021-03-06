<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Bank Reconsilation</title>
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
	font-size: 16px;
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
include('connectioni.php');



$sql_rsl_code="select c_code, pen from lcodes";
$result_rsl_code=mysqli_query($GLOBALS['dbinv'],$sql_rsl_code, $dbacc);
while ($row_rsl_code = mysqli_fetch_array($result_rsl_code)){

   $mamo = 0;
   
   	$sql_rsledger="select * from ledger  where l_code='" . $row_rsl_code["c_code"] . "' and  l_yearfl != '1' and  l_date >='" . $_GET["dtfrom"] . "' and l_date <='" . $_GET["dtto"] . "' order by l_date";
	$result_rsledger=mysqli_query($GLOBALS['dbinv'],$sql_rsledger, $dbacc);
	while ($row_rsledger = mysqli_fetch_array($result_rsledger)){
	    
      if ($_GET["chk_lastyear"] == "on") {
         if (($row_rsledger["l_flag"] == "OPB") and ($row_rsledger["l_yearfl"] != 2)) {
         } else {
            if ($row_rsledger["l_flag1"] == "DEB") {
              $mamo = $mamo + $row_rsledger["l_amount"];
            } else {
              $mamo = $mamo - $row_rsledger["l_amount"];
            }
         }
      } else {
         if ($row_rsledger["l_yearfl"] != 2) {
            if ($row_rsledger["l_flag1"] == "DEB") {
               $mamo = $mamo + $row_rsledger["l_amount"];
            } else {
               $mamo = $mamo - $row_rsledger["l_amount"];
            }
       	 }
      }
    }
    $sql="select c_code, pen from lcodes where c_code='" . $row_rsl_code["c_code"] . "'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
}
 
$sql_rspara="select * from accpara";
$result_rspara=mysqli_query($GLOBALS['dbinv'],$sql_rspara, $dbacc); 
$row_rspara = mysqli_fetch_array($result_rspara);





$txtdes = "TB Report From : " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "    To: " . date("Y-m-d", strtotime($_GET["dtto"])); 

	?>
    
<table width="922" height="723" border="0">
  <tr>
    <td colspan="3" align="center"><span class="companyname">Tyre House Trading (Pvt) Ltd. </span></td>
  </tr>
  <tr>
    <td height="21" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="208" height="21" colspan="3"><span class="heading"><?php echo $txtdes; ?></span></td>
  </tr>
  
  <tr>
    <td height="21">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td height="199" colspan="3"><?php
	$DEB_amt=0;
	$CRE_amt=0;
	
	
	
	echo "<table width=\"904\" height=\"81\" border=\"1\" cellspacing=\"0\">
		
      	<tr>
        <th width=\"70\" height=\"23\">Ledger</th>
        <th width=\"400\">Account Description</th>
        <th width=\"100\">&nbsp;</th>
        <th width=\"100\" >&nbsp;</th>
        </tr>";
		
		$deb=0;
		$cre=0;
		
		$sql_rsPrInv = "select *  from lcodes where pen != 0 order by c_code";
		$result_rsPrInv=mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv, $dbacc); 
	  	while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)){
			echo "<tr><td>".$row_rsPrInv["c_code"]."</td>
			<td>".$row_rsPrInv["c_name"]."</td>";
			
			if ($row_rsPrInv["pen"]>0){
				echo "<td align=right>".number_format($row_rsPrInv["pen"], 2, ".", ",")."</td>";
				echo "<td>&nbsp;</td>";
				$deb=$deb+$row_rsPrInv["pen"];
			} else if ($row_rsPrInv["pen"]<0){
				echo "<td>&nbsp;</td>";
				echo "<td align=right>".number_format($row_rsPrInv["pen"], 2, ".", ",")."</td>";
				$cre=$cre+$row_rsPrInv["pen"];
			}	
			echo "</tr>";
			
			
		}
		echo "<tr><td colspan=2>&nbsp;</td><td align=right><b>".number_format($deb, 2, ".", ",")."</b></td><td align=right><b>".number_format($cre, 2, ".", ",")."</b></td></tr>";
		echo "<tr><td colspan=3>&nbsp;</td><td align=right><b>".number_format(($deb+$cre), 2, ".", ",")."</b></td></tr>";
		
	
	
	
	  
	   ?>  
</table>
</td>
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
