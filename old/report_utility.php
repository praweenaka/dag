<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Utiliti Report</title>

<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
}
table
{
border-collapse:collapse;
}
table, td, th
{
 
font-family:Arial, Helvetica, sans-serif;
padding:5px;
}
th
{
font-weight:bold;
font-size:12px;

}
td
{
font-size:12px;
border-bottom:thick;



}
</style>

</head>

<body><center>


<p>
  <?php

    require_once("connectioni.php");
	
	
    
    $sql="delete from tmpcustomerout";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
	$sql_head="select * from invpara";
	$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
	$row_head = mysqli_fetch_array($result_head);
		
		//////////////////////

	$txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");


if ($_GET["cmbdev"] == "All") { $dev = "A"; }
if ($_GET["cmbdev"] == "Manual") { $dev = "0"; }
if ($_GET["cmbdev"] == "Computer") { $dev = "1"; }


if ($_GET["cmbrep"] == "All") {
   if ($_GET["radio"]=="optdaly") {
      if ($_GET["cmdtype"] = "Invoice") { 
	  	$sql = "SELECT * from view_s_ut where  C_DATE='" . $_GET["dtfrom"] . "' and TYPE='INV' and DEV!='" . $dev . "' order by id";
	  }	
      if ($_GET["cmdtype"] == "Cash") { 
	  	$sql = "SELECT * from view_s_ut  where C_DATE='" . $_GET["dtfrom"] . "' and TYPE='Cash' order by id ";
	  }	
      if ($_GET["cmdtype"] == "Return Cheque") { 
	  	$sql = "SELECT * from view_s_ut   where C_DATE='" . $_GET["dtfrom"] . "' and TYPE='CHQ' order by id ";
	  }	
	  
	  if ($_GET["cmdtype"] == "All") { 
	  	$sql = "SELECT * from view_s_ut   where C_DATE='" . $_GET["dtfrom"] . "' order by id ";
	  }	
   }
    
   if ($_GET["radio"]=="optperiod") {
      if ($_GET["cmdtype"] == "Invoice") { 
	  	$sql = "SELECT * from view_s_ut where  (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' )  and TYPE='INV' and DEV!='" . $dev . "' order by id";
	  }	
      if ($_GET["cmdtype"] == "Cash") { 
	  	$sql = "SELECT * from view_s_ut  where  (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' ) and TYPE='CAS' order by id";
	  }	
      if ($_GET["cmdtype"] == "Return Cheque") { 
	  	$sql = "SELECT * from view_s_ut  where (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' ) and TYPE='CHQ' order by id";
	  }	
	  
	  if ($_GET["cmdtype"] == "All") { 
	  	$sql = "SELECT * from view_s_ut  where (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' ) order by id";
	  }	
   }
} else {
    if ($_GET["radio"]=="optdaly") {
       if ($_GET["cmdtype"] == "Invoice") { 
	   	$sql = "SELECT * from view_s_ut where SAL_EX='" . trim($_GET["cmbrep"]) . "' and C_DATE='" . $_GET["dtfrom"] . "' and TYPE='INV' and DEV!='" . $dev . "' order by id";
	   }	
       if ($_GET["cmdtype"] == "Cash") { 
	   	$sql = "SELECT * from view_s_ut  where SAL_EX='" . trim($_GET["cmbrep"]) . "' and C_DATE='" . $_GET["dtfrom"] . "' and TYPE='Cash' order by id ";
	   }	
       if ($_GET["cmdtype"] == "Return Cheque") { 
	   	$sql = "SELECT * from view_s_ut   where SAL_EX='" . trim($_GET["cmbrep"]) . "' and C_DATE='" . $_GET["dtfrom"] . "' and TYPE='CHQ' order by id ";
		}
		if ($_GET["cmdtype"] == "All") { 
	   	$sql = "SELECT * from view_s_ut   where SAL_EX='" . trim($_GET["cmbrep"]) . "' and C_DATE='" . $_GET["dtfrom"] . "' order by id ";
		}
    }
     
    if ($_GET["radio"]=="optperiod") {
       if ($_GET["cmdtype"] == "Invoice") { 
	   	$sql = "SELECT * from view_s_ut where SAL_EX='" . trim($_GET["cmbrep"]) . "' and (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' )  and TYPE='INV' and DEV!='" . $dev . "' order by id";
	   }	
       if ($_GET["cmdtype"] == "Cash") { 
	   	$sql = "SELECT * from view_s_ut  where  SAL_EX='" . trim($_GET["cmbrep"]) . "' and (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' ) and TYPE='CAS' order by id";
	   }	
       if ($_GET["cmdtype"] == "Return Cheque") { 
	   	$sql = "SELECT * from view_s_ut  where SAL_EX='" . trim($_GET["cmbrep"]) . "' and (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' ) and TYPE='CHQ' order by id";
	   }
	   if ($_GET["cmdtype"] == "All") { 
	   	$sql = "SELECT * from view_s_ut  where SAL_EX='" . trim($_GET["cmbrep"]) . "' and (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' ) order by id";
	   }	
    }
}

$rtxtComName= $row_head["COMPANY"];
$rtxtcomadd1 = $row_head["ADD1"];
$rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
if ($_GET["cmbrep"] == "All") {
	if ($_GET["radio"]=="optdaly") { 
		$txthead ="Utilize Report  Type   :" . "  " . $_GET["cmdtype"] . "   On  " . date("Y-m-d", strtotime($_GET["dtfrom"]));
	}	
	if ($_GET["radio"]=="optperiod") { 
		$txthead = "Utilize Report  Type   :" . "  " . $_GET["cmdtype"] . "   From   " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "   To  " . date("Y-m-d", strtotime($_GET["dtto"]));
	}	
} else {
	if ($_GET["radio"]=="optdaly") { 
		$txthead = "Utilize Report- Rep: " . $_GET["cmbrep"] . "  Type   :" . "  " . $_GET["cmdtype"] . "   On  " . date("Y-m-d", strtotime($_GET["dtfrom"]));
	}	
	if ($_GET["radio"]=="optperiod") { 
		$txthead = "Utilize Report - Rep: " . $_GET["cmbrep"] . "    Type   :" . "  " . $_GET["cmdtype"] . "   From   " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "   To  " . date("Y-m-d", strtotime($_GET["dtto"]));
	}
}

	


?>
</p>
<table width="1000" border="0">
  <tr>
    <td colspan="6" align="center"><b><?php echo $rtxtComName; ?></b></td>
  </tr>
  <tr>
    <td colspan="6" align="center"><?php echo $rtxtcomadd1; ?></td>
    
  </tr>
  <tr>
    <td colspan="6" align="center"><?php echo $rtxtComAdd2; ?></td>
   
  </tr>
  <tr>
    <td colspan="6"><b><?php echo $txthead; ?></b></td>
  
  </tr>
  <tr>
    <td colspan="6"><table width="1000" border="1">
      <tr>
        <td ><b>Ref No</b></td>
        <td ><b>Date</b></td>
        <td ><b>GRN No</b></td>
        <td ><b>GRN Date</b></td>
        <td ><b>Ref INV/Ret. Ch</b></td>
        <td ><b>Customer</b></td>
        <td ><b>Amount</b></td>
        <td ><b>Che No</b></td>
        <td ><b>Bank</b></td>
      </tr>
     <?php 
	 	$C_PAYMENT=0;
		
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	  while ($row = mysqli_fetch_array($result)){
      	echo "<tr>
        <td>".$row["C_REFNO"]."</td>
        <td>".$row["C_DATE"]."</td>
        <td>".$row["CRE_NO_NO"]."</td>
        <td>".$row["grndate"]."</td>
        <td>".$row["C_INVNO"]."</td>
        <td>".$row["C_CODE"]." ".$row["name"]."</td>
        <td align=right>".number_format($row["C_PAYMENT"], 2, ".", ",")."</td>
        <td>".$row["c_chno"]."</td> 
		<td>".$row["ch_bank"]."</td>
      </tr>";
	  	$C_PAYMENT=$C_PAYMENT+$row["C_PAYMENT"];
	 }
	 
	 ?> 
     
      <tr>
        <td colspan="6" >Total</td>
        
        <td  align="right"><b><?php echo number_format($C_PAYMENT, 2, ".", ","); ?></b></td>
       
      </tr>
      
    </table></td>
  </tr>
 
</table>
<p>&nbsp;</p>
</body>
</html>
