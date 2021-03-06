<?php session_start();

require_once ("connectioni.php");

header('Content-Type: text/xml');

if ($_GET["Command"] == "save") {

	/*url=url+"&cuscode="+document.getElementById('cuscode').value ;
	 url=url+"&cusname="+document.getElementById('cusname').value;
	 url=url+"&txtstk_no="+document.getElementById('txtstk_no').value;
	 url=url+"&txtdes="+document.getElementById('txtdes').value;
	 url=url+"&txtbrand="+document.getElementById('txtbrand').value;
	 url=url+"&txtpatt="+document.getElementById('txtpatt').value;
	 url=url+"&txtseri_no="+document.getElementById('txtseri_no').value;*/
	$sql_status = 0;
	
	mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
	mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");

	$sql1 = "delete from BATMAS where BATNO='" . $_GET["txtseri_no"] . "'";
	$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
	if ($result1 != 1) {
		$sql_status = 1;
	}

	$sql = "insert into BATMAS(cuscode, CUSNAME, MODEL, PARTNO,BRAND,batchNo,BATNO,INVNO,INVDATE) values ('" . $_GET["cuscode"] . "', '" . $_GET["cusname"] . "', '" . $_GET["txtstk_no"] . "', '" . $_GET["txtdes"] . "', '" . $_GET["txtbrand"] . "', '" . $_GET["txtpatt"] . "', '" . $_GET["txtseri_no"] . "', '" . $_GET["inv_no"] . "', '" . $_GET["inv_dt"] . "')";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	if ($result != 1) {
		$sql_status = 2;
	}

	if ($sql_status == 0) {
		mysqli_query($GLOBALS['dbinv'], "COMMIT");
		echo "Saved";
	} else {
		mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
		echo "Error Occured";
	}

}
?>