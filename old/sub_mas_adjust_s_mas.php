<?php  session_start();

/*
	include_once("config.inc.php");
	include_once("DBConnector.php");
	$letters = $_GET['letters'];
	
	$sql="SELECT * FROM mast_family where name like '".$letters."%'";
		$result =$db->RunQuery($sql);
			
			
			while($row = mysql_fetch_array($result))
			{
			
			echo $row["name"];
			
			}
			
		*/	
		
		



	include_once("connection.php");


//$sql_item = mysql_query("select * from s_mas where BRAND_NAME='CHENG SHING' and STK_NO='06010' order by STK_NO") or die(mysql_error());				
$sql_item = mysql_query("select * from s_mas  order by STK_NO") or die(mysql_error());				
while($row_item = mysql_fetch_array($sql_item)){	

	$sql1 = mysql_query("select sum(QTYINHAND) as tot from s_submas where STK_NO='".$row_item["STK_NO"]."' ") or die(mysql_error());
	$row1 = mysql_fetch_array($sql1);
	
if ($row1["tot"] !=  $row_item['QTYINHAND'] ) {
	echo $row_item["STK_NO"] . "-" . $row1["tot"] . "-" . $row_item["QTYINHAND"] .  "-" .  "<br>"; 
}
	//$sql1 = mysql_query("update s_submas set QTYINHAND=".$M_BAL." where STO_CODE='".$row_sto["CODE"]."' and STK_NO='".$row_item["STK_NO"]."'") or die(mysql_error());
//	$sql1 = mysql_query("update s_mas set QTYINHAND=".$row1["tot"]." where STK_NO='".$row_item["STK_NO"]."' ") or die(mysql_error());
//	echo "update s_mas set QTYINHAND=".$M_BAL." where STK_NO='".$row_item["STK_NO"]."'</br>";


}
	echo "ok";
?>
