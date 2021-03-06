<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "save") {

	if (($_GET['trntype'] =="GATEIN") or ($_GET['trntype'] =="SCRPIN")) {
	$mqty = 1;
	} else {
	$mqty = -1;	
	}
	$sql = "insert into s_trn_defective (refno,stk_no,sdate,qty,ledindi) values ('" . $_GET['invno'] . "','" . $_GET['stk_no'] . "','" . date('Y-m-d') . "','" . $mqty . "','" . $_GET['trntype'] . "') ";
	$result = $conn->query($sql);

	echo "Saved";
	
	 
	
}

if ($_GET["Command"] == "del_inv") {

	 
	$sql = "delete from s_trn_defective where id = '" . $_GET['id'] . "'";
	$result = $conn->query($sql);

	echo "ok";
	
	 
	
}




?>