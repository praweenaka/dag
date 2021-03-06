<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Over Payment Report</title>

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
font-size:13px;

}
td
{
font-size:12px;
border-bottom:none;
border-top:none;
 

}
</style>

</head>

<body>
<center>

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


if ($_GET["cmbdev"] == "ALL") { $dev = "A"; }
if ($_GET["cmbdev"] == "Manual") { $dev = "0"; }
if ($_GET["cmbdev"] == "Computer") { $dev = "1"; }



 
 if ($_GET["radio"]=="optdaly") { 
 	
	if ($_SESSION['company']=="BEN"){
		$sql = "SELECT * from c_bal where  SDATE='" . $_GET["dtfrom"] . "' and trn_type='REC' and DEV!='" . $dev . "' and CANCELL = '0' order by SDATE";
	} else if ($_SESSION['company']=="THT"){
		$sql = "SELECT * from view_c_bal where  SDATE='" . $_GET["dtfrom"] . "' and trn_type='REC' and DEV!='" . $dev . "' and CANCELL = '0' order by SDATE";
	}	
}	
  
 if ($_GET["radio"]=="optperiod") { 
 	
	if ($_SESSION['company']=="BEN"){
 		$sql = "SELECT * from c_bal where  (SDATE='" . $_GET["dtfrom"] . "' or SDATE>'" . $_GET["dtfrom"] . "' ) and (SDATE='" . $_GET["dtto"] . "' or SDATE<'" . $_GET["dtto"] . "' )  and trn_type='REC' and DEV!='" . $dev . "' and CANCELL = '0' order by SDATE";
	} else 	if ($_SESSION['company']=="THT"){
		$sql = "SELECT * from view_c_bal where  (SDATE='" . $_GET["dtfrom"] . "' or SDATE>'" . $_GET["dtfrom"] . "' ) and (SDATE='" . $_GET["dtto"] . "' or SDATE<'" . $_GET["dtto"] . "' )  and trn_type='REC' and DEV!='" . $dev . "' and CANCELL = '0' order by SDATE";
	}	
}	
 
//echo $sql;	
if ($_GET["radio"]=="opt  daly"){ 
	$txthead = "Over Payment Report       On  " . date("Y-m-d", strtotime($_GET["dtfrom"]));
}
if ($_GET["radio"]=="optperiod"){ 
	$txthead = "Over Payment Report     From   " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "   To  " . date("Y-m-d", strtotime($_GET["dtto"]));
}	


?>
</p>

    <?php 
	echo $row_head["COMPANY"]."</br>"; 
	echo $row_head["ADD1"]."</br>"; 
	
	echo $row_head["ADD2"] . ", " . $row_head["ADD3"]."</br></br>"; 
	
	
	
	echo "<b>".$txthead."</b></br>"; 
	
	?>
    
    <table width="1000" border="1">
      <tr>
        <th ><b>Ref No</b></th>
        <th ><b>Date</b></th>
        <th ><b>Customer</b></th>
        <th align="right" ><b>Amount</b></th>
        <th align="right" ><b>Balance</b></th>
        
      </tr>
     <?php 
	 	$AMOUNT=0;
		$BALANCE=0;
		
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	  while ($row = mysqli_fetch_array($result)){
	  	
		

		if ($_GET["cmbdev"] == "Computer"){
		  $REFNO=substr($row["REFNO"], 0, 3);
		
	  		$sql_cus="Select * from vendor where CODE='".$row["CUSCODE"]."'";
	  		$result_cus =mysqli_query($GLOBALS['dbinv'],$sql_cus);
	    	$row_cus = mysqli_fetch_array($result_cus);
	  
      			echo "<tr>
        		<td>".$row["REFNO"]."</td>
        		<td>".$row["SDATE"]."</td>
        		<td>".$row["CUSCODE"]."&nbsp;&nbsp;&nbsp;".$row_cus["NAME"]."</td>
        		<td  align=\"right\">".number_format($row["AMOUNT"], 2, ".", ",")."</td>
        		<td  align=\"right\">".number_format($row["BALANCE"], 2, ".", ",")."</td>
        
      			</tr>";
	  			$AMOUNT=$AMOUNT+$row["AMOUNT"];
				$BALANCE=$BALANCE+$row["BALANCE"];
			
		} else {
				$sql_cus="Select * from vendor where CODE='".$row["CUSCODE"]."'";
	  			$result_cus =mysqli_query($GLOBALS['dbinv'],$sql_cus);
	    		$row_cus = mysqli_fetch_array($result_cus);
	  
      			echo "<tr>
        		<td>".$row["REFNO"]."</td>
        		<td>".$row["SDATE"]."</td>
        		<td>".$row["CUSCODE"]."&nbsp;&nbsp;&nbsp;".$row_cus["NAME"]."</td>
        		<td  align=\"right\">".number_format($row["AMOUNT"], 2, ".", ",")."</td>
        		<td  align=\"right\">".number_format($row["BALANCE"], 2, ".", ",")."</td>
        
      			</tr>";
	  			$AMOUNT=$AMOUNT+$row["AMOUNT"];
				$BALANCE=$BALANCE+$row["BALANCE"];				
		}	
	 }
	 
	 ?> 
     
      <tr>
        <th colspan="3" >Total</th>
        
        <th align="right" ><b><?php echo number_format($AMOUNT, 2, ".", ","); ?></b></th>
       <th  align="right"><b><?php echo number_format($BALANCE, 2, ".", ","); ?></b></th>
      </tr>
      
    </table>
<p>&nbsp;</p>
</body>
</html>
