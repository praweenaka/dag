<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////

///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
 
if ($_GET["Command"] == "add_sub") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

		$sql = "delete from vender_sub where c_code = '" . $_GET['c_code'] . "' and c_main = '" . $_GET['c_main'] . "'";
        $conn->exec($sql);
		
		$sql = "insert into vender_sub (c_code,c_name,c_add,c_tele,c_vatno,c_svatno,c_main,type) values
		('" . $_GET['c_code'] . "','" . $_GET['c_name'] . "','" . $_GET['c_add'] . "','" . $_GET['c_tele'] . "','" . $_GET['c_vatno'] . "','" . $_GET['c_svatno'] . "','" . $_GET['c_main'] . "','S') ";
        $conn->exec($sql);		        
        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

if ($_GET["Command"] == "del_item") {
	
	$sql = "select * from s_Salma where c_code1 ='" . $_GET['c_code'] . "'";
	$result = $conn->query($sql);
	//echo $sql; 
    if ($row = $result->fetch()) {
		echo "Cannot Remove, Inovices Found";
	} else {
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();						
		$sql = "delete from vender_sub where c_code = '" . $_GET['c_code'] . "'";
		$conn->exec($sql);		        
        $conn->commit();
        echo "Removed";
		
	}

}

 

 
 
 
?>