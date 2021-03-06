<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Return Cheque Report</title>

<style>
table
{
border-collapse:collapse;
}
table, td, th
{
border:0px solid black;
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

}
.style1 {
	font-size: 16px;
	font-weight: bold;
	color: #FF0000;
}
</style>

</head>

<body>


<p>
  <?php

    require_once("connectioni.php");
	
	
    
	
	
	$sql="delete * from tmpsttr_ana";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
	if ($_GET["Com_rep"] == "All") { 
		$sql_rst = "select * from s_cheq where CR_FLAG='0' and CR_DATE<='" . $_GET["dtfrom"] . "' and tmp=0";
	}	
	if ($_GET["Com_rep"] != "All") { 
		$sql_rst = "select * from s_cheq where S_REF='" . trim($_GET["Com_rep"]) . "' and CR_FLAG='0' and CR_DATE<='" . $_GET["dtfrom"] . "' and tmp=0";
	}	
	
	$result_rst =mysqli_query($GLOBALS['dbinv'],$sql_rst);
	while($row_rst = mysqli_fetch_array($result_rst)){
	
		$paid = 0;
		$sql_sttr = "select sum(ST_PAID) as paid from ch_sttr where ST_INVONO='" . trim($row_rst["CR_REFNO"]) . "' and ST_DATE <='" . $_GET["dtfrom"] . "' ";
		$result_sttr =mysqli_query($GLOBALS['dbinv'],$sql_sttr);
		$row_sttr = mysqli_fetch_array($result_sttr);
		if (is_null($row_sttr["paid"])==false) { $paid = $row_sttr["paid"]; }


		if (($row_rst["CR_CHEVAL"] - $paid) > 1) {
			
			$date1 = $row_rst["CR_DATE"];
			$date2 = $_GET["dtto"];
			
			$diff = abs(strtotime($date2) - strtotime($date1));
			$days = floor($diff / (60*60*24));
			
			$sql = "insert into tmpsttr_ana (refno, sdate, cheval, paid, che_no, code, cusname, rep, days) values  ('" . $row_rst["CR_REFNO"] . "', '" . $row_rst["CR_DATE"] . "','" . $row_rst["CR_CHEVAL"] . "' ," . $paid . ",'" . $row_rst["CR_CHNO"] . "' ,'" . $row_rst["CR_C_CODE"] . "','" . $row_rst["CR_C_NAME"] . "','" . $row_rst["S_REF"] . "','" . $days . "' )";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		}
		
		
		$sql_sttr = "select *  from ch_sttr where  ST_INVONO='" . trim($row_rst["CR_REFNO"]) . "' and ST_DATE <='" . $_GET["dtto"] . "' and  ST_DATE >'" . $_GET["dtfrom"] . "'";
		$result_sttr =mysqli_query($GLOBALS['dbinv'],$sql_sttr);
		while ($row_sttr = mysqli_fetch_array($result_sttr)){

			$sql = "insert into tmpsttr_ana (refno, st_recno, st_flag, st_amt, st_date, st_chno, code) values  ('" . $row_sttr["ST_INVONO"] . "','" . $row_sttr["ST_REFNO"] . "','" . $row_sttr["ST_FLAG"] . "' ,'" . $row_sttr["ST_PAID"] . "','" . $row_sttr["ST_DATE"] . "' ,'" . $row_sttr["ST_CHNO"] . "' ,'" . $row_rst["CR_C_CODE"] . "')";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		}
		
	}
}

if ($_GET["Com_rep"] == "All") { 
	$sql_rst = "select * from s_cheq where CR_FLAG='0' and CR_DATE> '" . $_GET["dtfrom"] . "' and CR_DATE<='" . $_GET["dtto"] . "' and tmp=0";
}	
if ($_GET["Com_rep"] != "All") { 
	$sql_rst = "select * from s_cheq where S_REF='" . trim($_GET["Com_rep"]) . "' and CR_FLAG='0' and CR_DATE> '" . $_GET["dtfrom"] . "' and CR_DATE<='" . $_GET["dtto"] . "' and tmp=0";
}	
$result_rst =mysqli_query($GLOBALS['dbinv'],$sql_rst);
while ($row_rst = mysqli_fetch_array($result_rst)){
	
	$date1 = $row_rst["CR_DATE"];
	$date2 = $_GET["dtto"];
			
	$diff = abs(strtotime($date2) - strtotime($date1));
	$days = floor($diff / (60*60*24));
	
	$sql = "insert into tmpsttr_ana (refno, sdate, cheval, paid, che_no, code, cusname, rep, days) values  ('" . $row_rst["CR_REFNO"] . "','" . $row_rst["CR_DATE"] . "','" . $row_rst["CR_CHEVAL"] . "' ,'0','" . $row_rst["CR_CHNO"] . "' ,'" . $row_rst["CR_C_CODE"] . "','" . $row_rst["CR_C_NAME"] . "','" . $row_rst["S_REF"] . "','" . $days . "' )";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 

	$sql_sttr = "select *  from ch_sttr where  ST_INVONO='" . trim($row_rst["CR_REFNO"]) . "' and ST_DATE <='" . $_GET["dtto"] . "' and  ST_DATE > '" . $_GET["dtfrom"] . "'";
	$result_sttr =mysqli_query($GLOBALS['dbinv'],$sql_sttr);
	while ($row_sttr = mysqli_fetch_array($result_sttr)){
		$sql = "insert into tmpsttr_ana (refno, st_recno, st_flag, st_amt, st_date, st_chno, code) values  ('" . $row_sttr["ST_INVONO"] . "','" . $row_sttr["ST_REFNO"] . "','" . $row_sttr["ST_FLAG"] . "' ,'" . $row_sttr["ST_PAID"] . "','" . $row_sttr["ST_DATE"] . "' ,'" . $row_sttr["ST_CHNO"] . "','" . $row_sttr["CR_C_CODE"] . "' )";
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	}
}


        $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");
        
		$sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
	    
        
        $text1 =" Rep - " . $_GET["Com_rep"];
        $txtRtn = "Outstanding As At " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " + " . "Returns From  " . date("Y-m-d", $_GET["dtfrom"])) . "  To  " . date("Y-m-d", strtotime($_GET["dtto"]));
        $txtsett = "Settlement From   " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "  To  " . date("Y-m-d", strtotime($_GET["dtto"]));
        $txtbal = "Balance As at " . date("Y-m-d", strtotime($_GET["dtto"]));
		//////////////////////



?> 
<table width="1000" border="1">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Date</td>
    <td>Che. No</td>
    <td>Customer</td>
    <td>Amount</td>
    <td>Balance</td>
    <td>Sett.Date</td>
    <td>Rec.type</td>
    <td>Sett. Amount</td>
    <td>Balance</td>
    <td>Days</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <?php
  
  $sql = "select * from tmpsttr_ana order by che_no";
  
    echo "<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
