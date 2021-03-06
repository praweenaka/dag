<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connectioni.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////

///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////



if ($_GET["Command"] == "new_inv") {

	if ($_SESSION["dev"] == "") {
		exit("no");
	}

	$_SESSION["insert"] = 1;

	$sql = "Select Che_exten from invpara";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	$row = mysqli_fetch_array($result);
	$tmpinvno = "000000" . $row["Che_exten"];
	$lenth = strlen($tmpinvno);
	$invno = trim("CEX/ ") . substr($tmpinvno, $lenth - 8);
	$_SESSION["invno"] = $invno;

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	$ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
	$ResponseXML .= "<curdate><![CDATA[" . date("Y-m-d") . "]]></curdate>";
	$ResponseXML .= "<curtime><![CDATA[" . date("H:i:s") . "]]></curtime>";
	$ResponseXML .= " </salesdetails>";
	echo $ResponseXML;

}
 
if ($_GET["Command"] == "save_item") {

	if ($_SESSION["dev"] == "") {
		exit("no");
	}
	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";

	$sql = "Select Che_exten from invpara";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	$row = mysqli_fetch_array($result);
	$tmpinvno = "000000" . $row["Che_exten"];
	$lenth = strlen($tmpinvno);
	$invno = trim("CEX/ ") . substr($tmpinvno, $lenth - 8);
	$_SESSION["invno"] = $invno;

	if ($_GET["txtch_no"] == "") {
		exit("Chq details not found");
	}

	$sql_rs = "SELECT *  FROM s_cheque_extend WHERE REFNO = '" . trim($_GET["txtrefno"]) . "'";
	$result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
	if ($row_rs = mysqli_fetch_array($result_rs)) {
		exit("This Entry No Found");
	}

	$sql_rs = "Select * from s_cheque_extend WHERE ch_no = '" . trim($_GET["txtch_no"]) . "' and c_code = '" . trim($_GET["txtcode"]) . "' and ch_date = '" . trim($_GET["txtch_date"]) . "'";
	$result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
	if ($row_rs = mysqli_fetch_array($result_rs)) {
		exit("Entry already Exist");
	}
	
		$myes ="";
		$sql_inv = mysqli_query($GLOBALS['dbinv'],"Select * from s_sttr where cus_code = '".trim($_GET["txtcode"])."' and ST_CHNO = '".trim($_GET["txtch_no"])."' ORDER BY ST_INVONO") or die(mysqli_error());					
		while($row_inv = mysqli_fetch_array($sql_inv)){
		$refinv = $row_inv["ST_INVONO"];
         
		$sql_rst = mysqli_query($GLOBALS['dbinv'],"select * from view_s_salma where REF_NO='" . trim($refinv) . "'") or die(mysqli_error());
		
		if ($row_rst = mysqli_fetch_array($sql_rst)){
			
							    $sql = "select * from ins_payment where cuscode = '" . $row_rst['C_CODE'] . "' and (I_month) = '" .  intval(date("m", strtotime($row_rst['SDATE']))) . "' and (I_year) = '" .   date("Y", strtotime($row_rst['SDATE'])) . "'";	
							 
								 
								$sql_ins = mysqli_query($GLOBALS['dbinv'],$sql);
								while ($row_rst1 = mysqli_fetch_array($sql_ins)) { 
								
								if (strtoupper(trim($row_rst1['Type'])) == trim($row_rst['class'])) {
									$myes = "YES";
									 
								}
								} 
							}
		}

	
	
	
	
	
	$sql_rs = "insert into s_cheque_extend (refno, sdate, sal_ex, c_code, c_name, ch_no, ch_amount, ch_date, ch_exdate, approved, acc_approved, e_time,ins) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["txtsdate"] . "', '" . trim($_GET["txtsal_ex"]) . "', '" . trim($_GET["txtcode"]) . "', '" . trim($_GET["txtname"]) . "', '" . trim($_GET["txtch_no"]) . "', " . trim($_GET["txtch_amount"]) . ", '" . trim($_GET["txtch_date"]) . "', '" . trim($_GET["txtchexdate"]) . "', '0', '0', '" . date("H:i:s") . "','" . $myes  . "')";
	//echo $sql_rs;
	$result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);

	//if ($result_rs==true){
	echo "Saved";
	//}

	$sql_rs = "Update invpara set Che_exten=Che_exten+1";
	$result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);

}

if ($_GET["Command"] == "apprive") {

	if ($_SESSION["CURRENT_USER"] == "") {
		exit("no");
	}

	$sql = "select * from s_cheque_extend where refno='" . trim($_GET["txtrefno"]) . "'";

	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	if ($row = mysqli_fetch_array($result)) {
		if ($row["acc_approved"] != "0") {
			exit("Account Approved, Can't EDIT!");
		}
	}

	$app = $_SESSION["CURRENT_USER"] . " - " . date("Y-m-d") . " - " . date("H:i:s");

	$sql1 = "update s_cheque_extend set ded = '" . $_GET['ded'] . "',ch_exdate='" . $_GET["txtchexdate"] . "', approved='" . $app . "'  where refno='" . trim($_GET["txtrefno"]) . "'";
	$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

	if ($result1 == true) {
		echo "Updated";
	}

}
if ($_GET["Command"] == "deny") {

	if ($_SESSION["CURRENT_USER"] == "") {
		exit("no");
	}

	$sql = "select * from s_cheque_extend where refno='" . trim($_GET["txtrefno"]) . "'";

	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	if ($row = mysqli_fetch_array($result)) {
		if ($row["acc_approved"] != "0") {
			exit("Account Approved, Can't EDIT!");
		}
	}

	$app = $_SESSION["CURRENT_USER"] . "- N\A - " . date("Y-m-d") . " - " . date("H:i:s");

	$sql1 = "update s_cheque_extend set ch_exdate='" . $_GET["txtchexdate"] . "', approved='" . $app . "',app='1'  where refno='" . trim($_GET["txtrefno"]) . "'";
	$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

	if ($result1 == true) {
		echo "Updated";
	}

}

if ($_GET["Command"] == "acc_apprive") {
	if ($_SESSION["dev"] == "") {
		exit("no");
	}

	$sql = "select * from s_cheque_extend where refno='" . trim($_GET["txtrefno"]) . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	if ($row_rs = mysqli_fetch_array($result)) {
		if ($row_rs["approved"] == "0") {
			exit("Not Approved");
		}
	} else {
		exit("Entry Not Found");
	}

	$sql = "Select * from s_invcheq where  cheque_no ='" . trim($_GET["txtch_no"]) . "' and cus_code = '" . trim($_GET["txtcode"]) . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	if ($row_rs = mysqli_fetch_array($result)) {

		$date1 = $_GET["txtch_date"];
		$date2 = $_GET["txtchexdate"];
		$diff = abs(strtotime($date2) - strtotime($date1));
		$days = floor($diff / (60 * 60 * 24));

		$exdays = $days;
		$c_date = $row_rs["che_date"];

		if (((is_null($row_rs["ex_date1"]) == false) and ($row_rs["ex_date1"] != "0000-00-00")) and ((is_null($row_rs["ex_date2"]) == false) and ($row_rs["ex_date2"] != "0000-00-00"))) {
			exit("Date cannot modified further");

		}

		if (((is_null($row_rs["ex_date1"]) == true) or ($row_rs["ex_date1"] == "0000-00-00")) and ((is_null($row_rs["ex_date2"]) == true) or ($row_rs["ex_date2"] == "0000-00-00"))) {

			$sql1 = "update s_invcheq set che_date='" . $_GET["txtchexdate"] . "', ex_flag='M', ex_date1='" . trim($c_date) . "' where cus_code='" . trim($_GET["txtcode"]) . "' and cheque_no='" . trim($_GET["txtch_no"]) . "'";
			$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
		}

		if (((is_null($row_rs["ex_date1"]) == false) and ($row_rs["ex_date1"] != "0000-00-00")) and ((is_null($row_rs["ex_date2"]) == true) or ($row_rs["ex_date2"] == "0000-00-00"))) {

			$sql1 = "update s_invcheq set che_date='" . $_GET["txtchexdate"] . "', ex_flag='M', ex_date2='" . trim($c_date) . "' where cus_code='" . trim($_GET["txtcode"]) . "' and cheque_no='" . trim($_GET["txtch_no"]) . "'";
			$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

		}

		if (trim($row_rs["trn_type"]) == "REC") {
			$sql1 = "UPDATE s_sttr SET ST_DATE=ST_DATE+" . $exdays . ", ap_days=ap_days+" . $exdays . ", st_chdate='" . $_GET["txtchexdate"] . "' where ST_CHNO='" . trim($_GET["txtch_no"]) . "' and cus_code='" . trim($_GET["txtcode"]) . "'";
			$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
			
		}
	}

	$app_ac = $_GET["CURRENT_USER"] . " - " . date("Y-m-d") . " - " . date("H:i:s");

	$sql1 = "update s_cheque_extend set acc_approved='" . $app_ac . "' where refno='" . trim($_GET["txtrefno"]) . "'";
	$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

	echo "Updated";

}

if ($_GET["Command"] == "acc_no") {
	if ($_SESSION["dev"] == "") {
		exit("no");
	}

	$sql_rs = "select * from s_cheque_extend where refno='" . trim($_GET["txtrefno"]) . "'";
	$result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
	if ($row_rs = mysqli_fetch_array($result_rs)) {

		if ($row_rs["approved"] == "0") {
			exit("Not Approved");
		}

	} else {
		exit("Entry Not Found");
	}

	$acc_no = $_GET["CURRENT_USER"] . "-N/A -" . date("Y-m-d") . " - " . date("H:i:s");

	$sql_rs = "update s_cheque_extend set acc_approved='" . $acc_no . "' where refno='" . trim($_GET["txtrefno"]) . "'";
	$result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);

	echo "Chq extended date ignored";
}






 
if ($_GET["Command"] == "check_print") {

	echo $_SESSION["print"];
}

?>