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

<body> <center> 


<?php

    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmpstkbal";
	$result =$db->RunQuery($sql);
	

 
//if ($_GET["brand"]!="All"){	
//	$sql_smas="select * from s_mas  where   BRAND_NAME='" & cmbbrand & "'";
//} else {	
	$sql_smas="select * from s_mas";
//}
//$result_smas =$db->RunQuery($sql_smas);
//while($row_smas = mysql_fetch_array($result_smas)){

$sql_brand="select * from brand_mas";
$result_brand =$db->RunQuery($sql_brand);
while($row_brand = mysql_fetch_array($result_brand)){
    $stkval = 0;
   
        $sql_smas= "select * from s_mas where BRAND_NAME='".$row_brand["barnd_name"]."'";
        $result_smas =$db->RunQuery($sql_smas);
		while($row_smas = mysql_fetch_array($result_smas)){
            if ($_GET["department"] == "All"){
                if ((!is_null($row_smas["acc_cost"])) and (!is_null($row_smas["QTYINHAND"]))){
					$stkval = $stkval + $row_smas["acc_cost"] * $row_smas["QTYINHAND"];
				}
            } else {
                	$sql_submas= "select QTYINHAND from s_submas where STK_NO='".$row_smas["STK_NO"]."' and STO_CODE='".$_GET["department"]."'";
					$result_submas =$db->RunQuery($sql_submas);
					$row_submas = mysql_fetch_array($result_submas);
					if ((!is_null($row_smas["acc_cost"])) and (!is_null($row_submas["QTYINHAND"]))){
						$stkval = $stkval + $row_smas["acc_cost"] * $row_submas["QTYINHAND"];
					}
                }
            }
       
        
    	$sql_new="insert into tmpstkbal(brand, stkbal) values ('".$row_brand["barnd_name"]."', ".$stkval.")";
		$result_new =$db->RunQuery($sql_new);
   
 }
 
  $sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>Current Stock Balance</center><br>";

echo "<table border=1>";
		echo "<tr><td width=300><b>Brand</b></td><td><b>Quantity</b></td></tr>";
 $sql= "SELECT * from tmpstkbal";
 $result =$db->RunQuery($sql);
 while($row = mysql_fetch_array($result)){
 	
	if ($row["stkbal"]>0){
		echo "<tr><td>".$row["brand"]."</td><td align=right>".number_format($row["stkbal"], 2, ".", ",")."</td></tr>";
 	}
 }


echo "</table>";




?>


</body>
</html>
