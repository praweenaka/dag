<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<style>
table
{
border-collapse:collapse;
}
table, td, th
{
border:1px solid black;
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
font-size:11px;

}
</style>

</head>

<body>


<?php

    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmpcustomerout";
	$result =$db->RunQuery($sql);
	
	$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
	echo "<center><h3>Statement of Account</h3><br>Date : ".$_GET["dtddate"]."<br>";
	echo "<b>Customer :".$_GET["cuscode"]." - ".$_GET["cusname"]."</b>";
	
	if ($_SESSION['dev']=="1") {
		$sql_salma="select * from s_salma where C_CODE='".$_GET["cuscode"]."' and (GRAND_TOT-TOTPAY)>1 and (SDATE<='".$_GET["dtddate"]."')  and CANCELL='0' order by SDATE";
	} else if ($_SESSION['dev']=="0") {
		$sql_salma="select * from s_salma where C_CODE='".$_GET["cuscode"]."' and (GRAND_TOT-TOTPAY)>1 and (SDATE<='".$_GET["dtddate"]."') and DEV='0' and CANCELL='0' order by SDATE";
	}	
	//echo $sql_salma;
	$result_salma =$db->RunQuery($sql_salma);
	while($row_salma = mysql_fetch_array($result_salma)){
		 
		 	$date1 = $row_salma["SDATE"];
			$date2 = date("Y-m-d");
			$diff = abs(strtotime($date2) - strtotime($date1));
			$days = floor($diff / (60*60*24));
			
			$sql_rep="select name from s_salrep where REPCODE='".$row_salma["SAL_EX"]."'";
			//echo $sql_rep;
			$result_rep =$db->RunQuery($sql_rep);
			$row_rep = mysql_fetch_array($result_rep);
	
		 $sql="insert into tmpcustomerout(REF_NO, SDATE, days, AMOUNT, paid, SAL_EX, barnd, REPNAME) value ('".$row_salma["REF_NO"]."', '".$row_salma["SDATE"]."', '".$days."', '".$row_salma["GRAND_TOT"]."', '".$row_salma["TOTPAY"]."', '".$row_salma["SAL_EX"]."', '".$row_salma["Brand"]."', '".$row_rep["name"]."')";
		 $result =$db->RunQuery($sql);
	}


if (($_GET["salesrep"] == "All") and ($_GET["brand"] == "All")) { $sql = "SELECT * from tmpcustomerout order by SDATE "; }
if (($_GET["salesrep"] == "All") and ($_GET["brand"] != "All")) { $sql = "SELECT * from tmpcustomerout where barnd='".$_GET["brand"]."' order by SDATE "; }
if (($_GET["salesrep"] != "All") and ($_GET["brand"] == "All")) { $sql = "SELECT * from tmpcustomerout where SAL_EX='".$_GET["salesrep"]."' order by SDATE "; }
if (($_GET["salesrep"] != "All") and ($_GET["brand"] != "All")) { $sql = "SELECT * from tmpcustomerout where barnd='".$_GET["brand"]."' and SAL_EX='".$_GET["salesrep"]."' order by SDATE "; }

echo "<table border=1><tr>
		<th>Date</th><th>Ref No</th><th>Days</th><th>Amount</th><th>Balance</th><th>Brand</th><th>Sales By</td></tr>";
	$result =$db->RunQuery($sql);			 
  while ($rows = mysql_fetch_array($result)){
  	
	$bal=$rows["AMOUNT"]-$rows["paid"];
  if ($bal>0.5){	
	echo "<tr>";
	echo "<td>".$rows["SDATE"]."</td>";
	echo "<td>".$rows["REF_NO"]."</td>";
	echo "<td align=\"right\">".$rows["days"]."</td>";
	echo "<td align=\"right\">".number_format($rows["AMOUNT"], 2, ".", ",")."</td>";
	echo "<td align=\"right\">".number_format($bal, 2, ".", ",")."</td>";
	echo "<td>".$rows["barnd"]."</td>";
	echo "<td>".$rows["REPNAME"]."</td>";
	
	echo "</tr>";
   }
  }	
 echo "</table>";
?>


</body>
</html>
