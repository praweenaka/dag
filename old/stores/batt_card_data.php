<?php session_start();

require_once ("connectioni.php");

if ($_GET["Command"] == "save") {

	$sql_status = 0;

	if ($_SESSION["CURRENT_USER"] == "") {
		exit("Session Expired Please Login Again");
	}

	mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
	mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");

	$sql1 = "delete from BATMAS where BATNO='" . $_GET["txtseri_no"] . "' and invno = '" . $_GET["inv_no"] . "'";
	$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
	if ($result1 != 1) {
		$sql_status = 1;
	}

	$sql = "insert into BATMAS(cuscode, CUSNAME, MODEL, PARTNO,BRAND,batchNo,BATNO,INVNO,INVDATE,user_nm,CUSAD1,CUSAD2,sdate) values ('" . $_GET["cuscode"] . "', '" . $_GET["cusname"] . "', '" . $_GET["txtstk_no"] . "', '" . $_GET["txtdes"] . "', '" . $_GET["txtbrand"] . "', '" . $_GET["txtpatt"] . "', '" . $_GET["txtseri_no"] . "', '" . $_GET["inv_no"] . "', '" . $_GET["inv_dt"] . "','" . $_SESSION["CURRENT_USER"] . "','". $_GET['cusadd'] . "','". $_GET['cusadd1'] . "','" . date('Y-m-d') . "')";
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

if ($_GET["Command"] == "update_list") {

	$str = "<table width='735' border='0' class=\"form-matrix-table\">
			<tr>
			<td width=\"121\"  ><font color=\"#FFFFFF\">Serial No</font></td>
			<td width=\"424\"  ><font color=\"#FFFFFF\">Size</font></td>
			<td width=\"176\"  ><font color=\"#FFFFFF\">Inv No</font></td>
			</tr>";

	$sql = "SELECT BATNO,MODEL,INVNO,id FROM batmas where batno like '%" . $_GET['invno'] . "%'  order by id desc limit 10 ";

	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {
		$str .= "<tr>
				<td onclick=\"pass_bat('" . $row['id'] . "');\">" . $row['BATNO'] . "</a></td>";
		$str .= "<td onclick=\"pass_bat('" . $row['id'] . "');\">" . $row["MODEL"] . "</a></td>";
		$str .= "<td onclick=\"pass_bat('" . $row['id'] . "');\">" . $row['INVNO'] . "</a></td>
			</tr>";
	}
	$str .= "</table>";
	 
	echo  $str;
	
	
}

if ($_GET["Command"] == "pass_bat") {

	$sql = "SELECT * FROM batmas where id = '" . $_GET['invno'] . "'  order by id desc ";

	header('Content-Type: text/xml');
	$ResponseXML = "";

	//	'cuscode, CUSNAME, MODEL, PARTNO,BRAND,batchNo,BATNO,INVNO,INVDATE'
	$ResponseXML .= " <salesdetails>";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	if ($row = mysqli_fetch_array($result)) {
		$ResponseXML .= "<cuscode><![CDATA[" . $row['cuscode'] . "]]></cuscode>";
		$ResponseXML .= "<CUSNAME><![CDATA[" . $row['CUSNAME'] . "]]></CUSNAME>";
		$ResponseXML .= "<MODEL><![CDATA[" . $row['MODEL'] . "]]></MODEL>";
		$ResponseXML .= "<PARTNO><![CDATA[" . $row['PARTNO'] . "]]></PARTNO>";
		$ResponseXML .= "<BRAND><![CDATA[" . $row['BRAND'] . "]]></BRAND>";
		$ResponseXML .= "<batchNo><![CDATA[" . $row['batchNo'] . "]]></batchNo>";
		$ResponseXML .= "<BATNO><![CDATA[" . $row['BATNO'] . "]]></BATNO>";
		$ResponseXML .= "<INVNO><![CDATA[" . $row['INVNO'] . "]]></INVNO>";
		$ResponseXML .= "<INVDATE><![CDATA[" . $row['INVDATE'] . "]]></INVDATE>";
                $ResponseXML .= "<ADD1><![CDATA[" . $row['CUSAD1'] . "]]></ADD1>";
                $ResponseXML .= "<ADD2><![CDATA[" . $row['CUSAD2'] . "]]></ADD2>";
                
	}
	$ResponseXML .= " </salesdetails>";
	echo $ResponseXML;
}

if ($_GET["Command"] == "upseri") {

	$str = "<table width='735' border='0' class=\"form-matrix-table\">
			<tr>
			<td width=\"121\"  ><font color=\"#FFFFFF\">Serial No</font></td>
			<td width=\"424\"  ><font color=\"#FFFFFF\">Stock No</font></td>
			<td width=\"176\"  ><font color=\"#FFFFFF\">Invoice No</font></td>
			<td width=\"176\"  ><font color=\"#FFFFFF\">Dealer</font></td>
			</tr>";

	$sql = "SELECT * FROM view_serial where serino like '%" . $_GET['invno'] . "%'  order by id desc limit 10 ";

	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {

		$str .= "<tr>
			<td onclick=\"view_seri('" . $row['id'] . "');\">" . $row['serino'] . "</a></td>
			<td onclick=\"view_seri('" . $row['id'] . "');\">" . $row["stk_no"] . "</a></td>
			<td onclick=\"view_seri('" . $row['id'] . "');\">" . $row['REF_NO'] . "</a></td>
			<td onclick=\"view_seri('" . $row['id'] . "');\">" . $row['CUS_NAME'] . "</a></td>
			</tr>";
	}
	$str .= "</table>";
	echo $str;
}

if ($_GET["Command"] == "view_seri") {

	$sql = "SELECT * FROM view_serial where id = '" . $_GET['invno'] . "'  order by id desc ";

	header('Content-Type: text/xml');
	$ResponseXML = "";

	//	'cuscode, CUSNAME, MODEL, PARTNO,BRAND,batchNo,BATNO,INVNO,INVDATE'
	$ResponseXML .= " <salesdetails>";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	if ($row = mysqli_fetch_array($result)) {
		$ResponseXML .= "<cuscode><![CDATA[" . $row['C_CODE'] . "]]></cuscode>";
		$ResponseXML .= "<CUSNAME><![CDATA[" . $row['CUS_NAME'] . "]]></CUSNAME>";
		$ResponseXML .= "<ADD1><![CDATA[" . $row['C_ADD1'] . "]]></ADD1>";
		$sql = "select * from view_sinvo_smas where stk_no ='" . $row['stk_no'] . "' and ref_no ='" . $row['REF_NO'] . "'";
		$result1 = mysqli_query($GLOBALS['dbinv'], $sql);
		if ($row1 = mysqli_fetch_array($result1)) {
			$ResponseXML .= "<MODEL><![CDATA[" . $row1['STK_NO'] . "]]></MODEL>";
			$ResponseXML .= "<PARTNO><![CDATA[" . $row1['DESCRIPT'] . "]]></PARTNO>";
			$ResponseXML .= "<BRAND><![CDATA[" . $row1['BRAND'] . "]]></BRAND>";
			$ResponseXML .= "<batchNo><![CDATA[" . $row1['PART_NO'] . "]]></batchNo>";
			$ResponseXML .= "<BATNO><![CDATA[" . $row['serino'] . "]]></BATNO>";
		}
		$sql = "select * from batmas where batno ='" . trim($row['serino']) . "' and invno ='" . $row['REF_NO'] . "'";
		 
                $result2 = mysqli_query($GLOBALS['dbinv'], $sql);
		if ($row2 = mysqli_fetch_array($result2)) {
			$ResponseXML .= "<ADD2><![CDATA[" . $row2['CUSAD2'] . "]]></ADD2>";
		} else {
			$ResponseXML .= "<ADD2><![CDATA[]]></ADD2>";
		}	 
		$ResponseXML .= "<INVNO><![CDATA[" . $row['REF_NO'] . "]]></INVNO>";
		$ResponseXML .= "<INVDATE><![CDATA[" . $row['SDATE'] . "]]></INVDATE>";
	}
	
	$ResponseXML .= " </salesdetails>";
	echo $ResponseXML;
}
?>