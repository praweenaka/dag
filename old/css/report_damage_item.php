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
 <!-- Progress bar holder -->
<!-- Progress information -->
<div id="information" style="width"></div>

<?php

	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmpstkmve";
	$result =$db->RunQuery($sql);
	
	$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
echo "<center><table border=1><tr>
		<th>Stock No</th><th>Description</th><th>Brand</th><th>Damage </th><th>Cost</th><th>Total</th></tr>";

$tot=0;

$sql="SELECT * from stk_take where damage>0";
$result =$db->RunQuery($sql);
while ($rows = mysql_fetch_array($result)){

 echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["BRAND"]."</td><td align=\"right\">".$rows["damage"]."</td><td align=\"right\">".number_format($rows["COST"], 2, ".", ",")."</td><td align=\"right\">".number_format($rows["COST"]*$rows["damage"], 2, ".", ",")."</td></tr>";
 	$tot=$tot+($rows["COST"]*$rows["damage"]);

}
echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\">&nbsp;</td><td align=\"right\">&nbsp;</td><td align=\"right\"><b>".number_format($tot, 2, ".", ",")."</b></td></tr>";
echo "</table>";
?>


</body>
</html>
