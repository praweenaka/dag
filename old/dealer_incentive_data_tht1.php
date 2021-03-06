<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connectioni.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

$MSHFlexGrid1 = array( array());
$MSHFlexGrid1_count = 0;
$gridchk = array( array());

if ($_GET["Command"] == "grnhistory") {
	$txtgrntot = "";

	$year = substr($_GET["dtMonth"], 0, 4);
	$month = substr($_GET["dtMonth"], 5, 2);

	$ii = 1;

	$sql_rsgen = "select * from s_crnma where CANCELL='0' and month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and SAL_EX='" . trim($_GET["cmbrep"]) . "'";
	$result_rsgen = mysqli_query($GLOBALS['dbinv'], $sql_rsgen);
	while ($row_rsgen = mysqli_fetch_array($result_rsgen)) {

		$TypeGrid1[$ii][0] = "GRN";
		$TypeGrid1[$ii][1] = $row_rsgen["REF_NO"];
		$TypeGrid1[$ii][2] = $row_rsgen["GRAND_TOT"];
		$TypeGrid1[$ii][3] = $row_rsgen["INVOICENO"];

		$sql_rs_salm = "Select SDATE, GRAND_TOT, DUMMY_VAL from s_salma where Accname <> 'NON STOCK' and REF_NO='" . $row_rsgen["INVOICENO"] . "' ";
		$result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
		if ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {
			$TypeGrid1[$ii][4] = $row_rs_salm["SDATE"];
			$TypeGrid1[$ii][5] = $row_rs_salm["GRAND_TOT"];
			$TypeGrid1[$ii][6] = $row_rs_salm["DUMMY_VAL"];
			if (($row_rs_salm["DUMMY_VAL"] > 0) and ($row_rs_salm["GRAND_TOT"] > 0)) { $TypeGrid1[$ii][7] = ($row_rs_salm["DUMMY_VAL"] / $row_rs_salm["GRAND_TOT"]) * $row_rsgen["GRAND_TOT"];
			}
			$TypeGrid1[$ii][8] = $row_rsgen["DIS1"];
			$txtgrntot = $_GET["txtgrntot"] + $TypeGrid1[$ii][7] + $TypeGrid1[$ii][8];
			$ii = $ii + 1;

		}

		$sql_rsgen = "select * from cred where CANCELL='0' and month(C_DATE) =" . $month . " and   year(C_DATE) =" . $year . " and C_SALEX='" . trim($_GET["cmbrep"]) . "'  ";
		$result_rsgen = mysqli_query($GLOBALS['dbinv'], $sql_rsgen);
		while ($row_rsgen = mysqli_fetch_array($result_rsgen)) {

			$sql_rsbal = "Select * from c_bal where REFNO = '" . $row_rsgen["C_REFNO"] . " ' and flag1 <> '1'";
			$result_rsbal = mysqli_query($GLOBALS['dbinv'], $sql_rsbal);
			if ($row_rsbal = mysqli_fetch_array($result_rsbal)) {

				$TypeGrid1[$ii][0] = "CRN";
				$TypeGrid1[$ii][1] = $row_rsgen["C_REFNO"];
				$TypeGrid1[$ii][2] = $row_rsgen["C_PAYMENT"];
				$TypeGrid1[$ii][3] = $row_rsgen["C_INVNO"];

				$sql_rs_salm = "Select SDATE,GRAND_TOT,DUMMY_VAL from s_salma where Accname <> 'NON STOCK' and REF_NO='" . $row_rsgen["C_INVNO"] . "'";
				$result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
				if ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {

					$TypeGrid1[$ii][4] = $row_rs_salm["SDATE"];
					$TypeGrid1[$ii][5] = $row_rs_salm["GRAND_TOT"];
					$TypeGrid1[$ii][6] = $row_rs_salm["DUMMY_VAL"];
					if ($row_rs_salm["DUMMY_VAL"] == 0) {
						$TypeGrid1[$ii][7] = 0;
					} else {
						$TypeGrid1[$ii][7] = ($row_rs_salm["DUMMY_VAL"] / $row_rs_salm["GRAND_TOT"]) * $row_rsgen["C_PAYMENT"];
					}
				}
				if (is_null($row_rsgen["SETTLED"]) == false) { $TypeGrid1[$ii][8] = $row_rsgen["SETTLED"];
				}
				$txtgrntot = $txtgrntot + $TypeGrid1[$ii][7] + $TypeGrid1[$ii][8];
				$ii = $ii + 1;

			}

		}

		$TypeGrid1_count = $ii;

		$TypeGrid1[0][1] = "";
		$TypeGrid1[0][1] = "GRN/CRN NO";
		$TypeGrid1[0][2] = "Amount";
		$TypeGrid1[0][3] = "Invoice No";
		$TypeGrid1[0][4] = "IN.Date";
		$TypeGrid1[0][5] = "IN.Amount";
		$TypeGrid1[0][6] = "Paid";
		$TypeGrid1[0][7] = "Commi";
		$TypeGrid1[0][8] = "Comm.Manu";

		$ResponseXML = "";
		$ResponseXML .= "<salesdetails>";

		$ResponseXML .= "<TypeGrid1><![CDATA[ <table  border=1  cellspacing=0>		";
		$r = 0;
		while ($TypeGrid1_count > $r) {

			$gtype = "gtype" . $r;
			$grnno = "grnno" . $r;
			$Commi = "Commi" . $r;
			$commman = "CommManu" . $r;

			$ResponseXML .= "<tr>
						<td><div id=\"" . $gtype . "\">" . $TypeGrid1[$r][0] . "</div></td>
						<td><div id=\"" . $grnno . "\">" . $TypeGrid1[$r][1] . "</div></td>
						<td>" . $TypeGrid1[$r][2] . "</td>
						<td>" . $TypeGrid1[$r][3] . "</td>
						<td>" . $TypeGrid1[$r][4] . "</td>
						<td>" . $TypeGrid1[$r][5] . "</td>
						<td>" . $TypeGrid1[$r][6] . "</td>
						<td><div id=\"" . $Commi . "\">" . $TypeGrid1[$r][7] . "</div></td>";
			if ($r != 0) {
				$ResponseXML .= "<td><input type=\"text\" name=\"" . $commman . "\" id=\"" . $commman . "\" value=\"" . $TypeGrid1[$r][8] . "\" /></td>
						</tr>";
			} else {
				$ResponseXML .= "<td>" . $TypeGrid1[$r][8] . "</td>
						</tr>";
			}
			$r = $r + 1;
		}

		$ResponseXML .= "   </table>]]></TypeGrid1>";
		$ResponseXML .= "<mcount><![CDATA[" . $r . "]]></mcount>";

		$ResponseXML .= " </salesdetails>";
		echo $ResponseXML;
	}

}

if ($_GET["Command"] == "savegrn") {
	include ('connectioni.php');

	$r = 1;
	while ($_GET["grngrid"] > $r) {

		$gtype = "gtype" . $r;
		$grnno = "grnno" . $r;
		$Commi = "Commi" . $r;
		$commman = "CommManu" . $r;

		if ($_GET[$Commi] == "") {
			$Commi_val = 0;
		} else {
			$Commi_val = $_GET[$Commi];
		}

		if ($_GET[$commman] == "") {
			$commman_val = 0;
		} else {
			$commman_val = $_GET[$commman];
		}

		if ($_GET[$gtype] == "GRN") {

			$sql_inv = "update s_crnma set DUMMY_VAL=" . $Commi_val . " ,DIS1=" . $commman_val . "  where  REF_NO='" . $_GET[$grnno] . "'";
			//echo $sql_inv;
			$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

		} else {

			$sql_inv = "update cred set dummy_val=" . $Commi_val . " ,SETTLED=" . $commman_val . "  where  C_REFNO='" . $_GET[$grnno] . "'";
			//echo $sql_inv;
			$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

		}

		$r = $r + 1;
	}

	echo "Updated";
}

if ($_GET["Command"] == "view_report") {
	$txtpr4 = $_GET["txtpre"] . " %";
	$txtNoComCOm = $_GET["txtNoCom_COm"];
	$txtsale4 = $_GET["nosale"];

	$year = substr($_GET["dtMonth"], 0, 4);
	$month = substr($_GET["dtMonth"], 5, 2);

	$rep = $_GET["cmbrep"];

	//If DNUSER.CONUSER.State = 0 Then DNUSER.CONUSER.Open
	$sql = "delete from tmpcommition ";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	$sql_inv = "select * from s_salma where Accname != 'NON STOCK' and SAL_EX='" . $rep . "' and month(SDATE)=" . $month . " AND YEAR(SDATE)=" . $year . " and CANCELL='0' and DEV='" . $_GET["cmbdev"] . "'";
	$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
	while ($row_inv = mysqli_fetch_array($result_inv)) {

		//===============================================Choose Commission Catogory=====================================
		$day1 = 0;
		$day2 = 0;
		$cat1 = 0;
		$cat2 = 0;
		$cat3 = 0;

		$sql_cat = "select * from com_she where sal_ex='" . trim($_GET["cmbrep"]) . "' and Brand='" . trim($row_inv["Brand"]) . "'";
		$result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
		$row_cat = mysqli_fetch_array($result_cat);
		$day1 = $row_cat["day1"];
		$day2 = $row_cat["day2"];
		if ($_GET["txtbalSAleTOT"] > $_GET["txtt2"]) {
			$cat1 = $row_cat["t3_cat1"];
			$cat2 = $row_cat["t3_cat2"];
			$cat3 = $row_cat["t3_cat3"];
			$tarcat = 3;
		} else if ($_GET["txtbalSAleTOT"] > $_GET["txtt1"]) {
			$cat1 = $row_cat["t2_cat1"];
			$cat2 = $row_cat["t2_cat2"];
			$cat3 = $row_cat["t2_cat3"];
			$tarcat = 2;
		} else {
			$cat1 = $row_cat["t1_cat1"];
			$cat2 = $row_cat["t1_cat2"];
			$cat3 = $row_cat["t1_cat3"];
			$tarcat = 1;
		}

		$sql_rsven = "Select incdays from vendor where CODE = '" . trim($row_inv["C_CODE"]) . "'";
		$result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
		$row_rsven = mysqli_fetch_array($result_rsven);
		if ($row_rsven["incdays"] > $day1) {
			$day1 = $row_rsven["incdays"] + 1;
			$day2 = $row_rsven["incdays"] + 1;
		}

		if ($row_inv["cre_pe"] > $day1) {
			$day1 = $row_inv["cre_pe"] + 1;
			$day2 = $row_inv["cre_pe"] + 1;
		}

		//=========================================================================

		$sql_sttr = "SELECT * FROM tmp_s_sttr WHERE ST_INVONO='" . $row_inv["REF_NO"] . "'";
		$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
		if ($row_sttr = mysqli_fetch_array($result_sttr)) {

			while ($row_sttr = mysqli_fetch_array($result_sttr)) {

				$sql_compr = "select * from brand_mas where barnd_name='" . trim($roq_inv["Brand"]) . "'";
				$result_compr = mysqli_query($GLOBALS['dbinv'], $sql_compr);
				$row_compr = mysqli_fetch_array($result_compr);

				$due = $row_inv["GRAND_TOT"] - $row_inv["TOTPAY"];
				$pay_type = $row_sttr["ST_REFNO"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $row_sttr["ST_CHNO"];

				$D_75 = 0;
				$D_76_90 = 0;
				$D_91 = 0;
				$commission = 0;

				if ($row_sttr["ST_FLAG"] == "UT") {
					$days = 0;
					$apdays = 0;
				} else {
					$apdays = $row_sttr["del_days"];
					$diff = abs(strtotime($row_inv["SDATE"]) - strtotime($row_sttr["ST_CHDATE"]));
					$days = floor($diff / (60 * 60 * 24));

				}

				if ($apdays < $day1) {
					$D_75 = $row_sttr["ST_PAID"];
					if ($row_inv["DEV"] == "1") { $commission = $cat1 * $row_sttr["ST_PAID"] * 0.01;
					}
					if ($row_inv["DEV"] == "0") { $commission = $cat1 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($_GET["txtvat"] / 100));
					}

				}

				if (($apdays > $day1 - 1) and ($apdays < $day2)) {
					if ($cat2 > 0) {
						$D_76_90 = $row_sttr["ST_PAID"];
						if ($row_inv["DEV"] == "1") { $commission = $cat2 * $row_sttr["ST_PAID"] * 0.01;
						}
						if ($row_inv["DEV"] == "0") { $commission = $cat2 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($_GET["txtvat"] / 100));
						}

					} else {
						$D_91 = $row_sttr["ST_PAID"];
						if ($row_inv["DEV"] == "1") { $commission = $cat2 * $row_sttr["ST_PAID"] * 0.01;
						}
						if ($row_inv["DEV"] == "0") { $commission = $cat2 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($_GET["txtvat"] / 100));
						}

					}
				}

				if ($apdays > ($day2 - 1)) {
					$D_91 = $row_sttr["ST_PAID"];
					if ($row_inv["DEV"] == "1") { $commission = $cat3 * $row_sttr["ST_PAID"] * 0.01;
					}
					if ($row_inv["DEV"] == "0") { $commission = $cat3 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($_GET["txtvat"] / 100));
					}

				}

				$sql = "insert into tmpcommition(SDATE, REFNO, COS_CODE, cus_name, AMOUNT, DUE, pay_type, PAY_DATE, PAY_AMOUNT, brand, dev, DATES, apdays, D_75, D_76_90, D_91, commission)  values ('" . $row_inv["SDATE"] . "', '" . $row_inv["REF_NO"] . "', '" . $row_inv["C_CODE"] . "', '" . $row_inv["CUS_NAME"] . "', " . $row_inv["GRAND_TOT"] . ", " . $due . ", '" . $pay_type . "', '" . $row_sttr["ST_DATE"] . "', " . $row_sttr["ST_PAID"] . ", '" . $row_inv["Brand"] . "', '" . $row_inv["dev"] . "', " . $days . ", " . $apdays . ", " . $D_75 . ", " . $D_76_90 . ", " . $D_91 . ", " . $commission . ")";
				$result = mysqli_query($GLOBALS['dbinv'], $sql);

			}

		} else {

			$due = $row_inv["GRAND_TOT"] - $row_inv["TOTPAY"];
			$sql = "insert into tmpcommition(SDATE, REFNO, COS_CODE, cus_name, AMOUNT, DUE, brand, dev, PAY_AMOUNT)  values ('" . $row_inv["SDATE"] . "', '" . $row_inv["REF_NO"] . "', '" . $row_inv["C_CODE"] . "', '" . $row_inv["CUS_NAME"] . "', " . $row_inv["GRAND_TOT"] . ", " . $due . ", '" . $row_inv["Brand"] . "', '" . $row_inv["dev"] . "', 0)";
			$result = mysqli_query($GLOBALS['dbinv'], $sql);
		}

		$totamount = $totamount + $row_inv["GRAND_TOT"];
		$totdue = $totdue + $row_inv["GRAND_TOT"] - $row_inv["TOTPAY"];

	}

	if ($_GET["cmbdev"] == "0") {

		$sql_CRN = "select * from cred where year(C_DATE) =" . $year . " and  month(C_DATE) =" . $month . " and   C_SALEX='" . trim($_GET["cmbrep"]) . "'   and CANCELL='0'";
		$result_CRN = mysqli_query($GLOBALS['dbinv'], $sql_CRN);
		while ($row_CRN = mysqli_fetch_array($result_CRN)) {

			$cat1 = 0;
			$sql_cat = "select * from com_she where sal_ex='" . trim($_GET["cmbrep"]) . "' and Brand='" . trim($row_CRN["Brand"]) . "'";
			$result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
			if ($row_cat = mysqli_fetch_array($result_cat)) {

				if ($tarcat == 1) { $cat1 = $row_cat["t1_cat1"];
				}
				if ($tarcat == 2) { $cat1 = $row_cat["t2_cat1"];
				}
				if ($tarcat == 3) { $cat1 = $row_cat["t3_cat1"];
				}

			}

			$sql_rst = "select NAME from vendor where CODE ='" . $row_CRN["C_CODE"] . "'";
			$result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
			if ($row_rst = mysqli_fetch_array($result_rst)) {
				$cus_name = $row_rst["NAME"];
			}

			$sql_invdiv = "select *  from s_salma where Accname <> 'NON STOCK' and REF_NO='" . $row_CRN["C_INVNO"] . "'";
			$result_invdiv = mysqli_query($GLOBALS['dbinv'], $sql_invdiv);

			$sql_compr = "select * from brand_mas where barnd_name='" . trim($row_CRN["Brand"]) . "'";
			$result_compr = mysqli_query($GLOBALS['dbinv'], $sql_compr);

			if (($row_invdiv = mysqli_fetch_array($result_invdiv)) and ($row_compr = mysqli_fetch_array($result_compr))) {
				$dev = $row_invdiv["DEV"];
			} else if ($row_compr = mysqli_fetch_array($result_compr)) {
				$dev = "0";
			}

			$commission = $row_CRN["dummy_val"] + $row_CRN["SETTLED"];

			$sql = "insert into tmpcommition(SDATE, REFNO, COS_CODE, cus_name, return, AMOUNT, dev, commission, brand)  values ('" . $row_CRN["C_DATE"] . "', '" . $row_CRN["C_REFNO"] . "', '" . $row_CRN["C_CODE"] . "', '" . $cus_name . "', " . $row_CRN["C_PAYMENT"] . ", " . (-1 * $row_CRN["C_PAYMENT"]) . ", '" . $dev . "', " . $commission . ", '" . $row_CRN["Brand"] . "')";
			$result = mysqli_query($GLOBALS['dbinv'], $sql);

			$totreturn = $totreturn + $row_CRN["C_PAYMENT"];
		}

		$sql_grn = "select * from view_crnma where month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and SAL_EX='" . trim($_GET["cmbrep"]) . "' and CANCELL='0' and trn_type2='GRN'";
		$result_grn = mysqli_query($GLOBALS['dbinv'], $sql_grn);
		while ($row_grn = mysqli_fetch_array($result_grn)) {

			$cat1 = 0;

			$sql_cat = "select * from com_she where sal_ex='" . trim($_GET["cmbrep"]) . "' and Brand='" . trim($row_grn["Brand"]) . "'";
			$result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
			if ($row_cat = mysqli_fetch_array($result_cat)) {

				if ($tarcat == 1) { $cat1 = $row_cat["t1_cat1"];
				}
				if ($tarcat == 2) { $cat1 = $row_cat["t2_cat1"];
				}
				if ($tarcat == 3) { $cat1 = $row_cat["t3_cat1"];
				}
			}

			$sql_invdiv = "select *  from s_salma where Accname <> 'NON STOCK' and REF_NO='" . $row_grn["INVOICENO"] . "'";
			$result_invdiv = mysqli_query($GLOBALS['dbinv'], $sql_invdiv);

			$sql_compr = "select * from brand_mas where barnd_name='" . trim($row_grn["Brand"]) . "'";
			$result_compr = mysqli_query($GLOBALS['dbinv'], $sql_compr);

			if (($row_invdiv = mysqli_fetch_array($result_invdiv)) and ($row_compr = mysqli_fetch_array($result_compr))) {
				$dev = $row_invdiv["DEV"];
			} else if ($row_compr = mysqli_fetch_array($result_compr)) {
				$dev = "0";
			}

			$sql = "insert into tmpcommition(SDATE, REFNO, COS_CODE, cus_name, return, AMOUNT, dev, brand)  values ('" . $row_grn["SDATE"] . "', '" . $row_grn["REF_NO"] . "', '" . $row_grn["C_CODE"] . "', '" . $row_grn["CUS_NAME"] . "', " . $row_grn["GRAND_TOT"] . ", " . (-1 * $row_grn["GRAND_TOT"]) . ", '" . $dev . "', '" . $row_CRN["Brand"] . "')";
			$result = mysqli_query($GLOBALS['dbinv'], $sql);

			$totreturn = $totreturn + $row_grn["GRAND_TOT"];

		}

	}
	//...........................................................................................................

	$sql_rspara = "select * from invpara";
	$result_rspara = mysqli_query($GLOBALS['dbinv'], $sql_rspara);
	if ($row_rspara = mysqli_fetch_array($result_rspara)) {

		$txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:m:s");

		$sql = "SELECT * from tmpcommition order by id  ";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);
		$row = mysqli_fetch_array($result);

		$sql_sttr1 = "SELECT SUM(commission) AS commission FROM tmpcommition ";
		$result_sttr1 = mysqli_query($GLOBALS['dbinv'], $sql_sttr1);
		$row_sttr1 = mysqli_fetch_array($result_sttr1);

		$mnonocom = 0;
		if (is_null($row_sttr1["commission"]) == false) { $mnonocom = $row_sttr1["commission"];
		}

		$rtxtComName = $row["COMPANY"];
		$rtxtcomadd1 = $row["ADD1"];
		$rtxtComAdd2 = $row["ADD2"] . ", " . $row["ADD3"];

		$rtxtotamount = $totamount;

		$rtxtotdue = $totdue;

		//Call Print_Report(m_Report, 42)
		/*

		 If m_update = flase Then Exit Sub
		 msg = MsgBox("Do You Wish to save Commtion", vbYesNo, "Warning")
		 If Not msg = vbYes Then Exit Sub
		 '==================================check Permission===========================
		 CURRENT_DOC = 42      'document ID
		 'VIEW_DOC = True      '  view current document
		 FEED_DOC = True      '   save  current document
		 'MOD_DOC = True       '   delete   current document
		 'PRINT_DOC = True     ' get additional print   of  current document
		 'PRICE_EDIT=true      ' edit selling price
		 CHECK_USER = True    ' check user permission again
		 REFNO = REFNO = Trim(cmbrep) + Format(dtMonth, "MM/YYYY") + " Save"
		 frmGetAuth.Show 1
		 If Not AUTH_OK Then Exit Sub
		 //=============================================================================

		 Probar.Visible = True
		 Dim rsTMPCOMMITION As New ADODB.Recordset
		 rsTMPCOMMITION.Open "select * from tmpcommition where commission > 0 and  PAY_AMOUNT > 0 ", DNUSER.CONUSER
		 Probar.Max = rsTMPCOMMITION.RecordCount
		 Do While Not rsTMPCOMMITION.EOF
		 dnINV.conINV.Execute "update s_salma set DUMMY_VAL=0  where ref_no='" . rsTMPCOMMITION!REFNO . "'"
		 Probar.Value = rsTMPCOMMITION.AbsolutePosition
		 rsTMPCOMMITION.MoveNext
		 Loop
		 Probar.Visible = False

		 rsTMPCOMMITION.MoveFirst
		 Do While Not rsTMPCOMMITION.EOF
		 dnINV.conINV.Execute "update s_salma set DUMMY_VAL=DUMMY_VAL+" . rsTMPCOMMITION!commission + 1 . " where ref_no='" . rsTMPCOMMITION!REFNO . "'"
		 Probar.Value = rsTMPCOMMITION.AbsolutePosition
		 rsTMPCOMMITION.MoveNext
		 Loop
		 rsTMPCOMMITION.Close
		 Probar.Visible = False*/
	}

}

if ($_GET["Command"] == "com_lock") {

	include ("connectioni.php");

	$mrefno = date("m/Y", strtotime($_GET["dtMonth"])) . "-" . $_GET["cmbrep"] . "-" . $_GET["cmbdev"];

	$sql_commadva = "select * from s_commadva where refno='" . $mrefno . "'";
	$result_commadva = mysqli_query($GLOBALS['dbinv'], $sql_commadva);
	if ($row_commadva = mysqli_fetch_array($result_commadva)) {

		$sql = "Update s_commadva set Lock1 ='1' where refno = '" . $mrefno . "' AND FLAG='ADV'";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);

		$sql = "Update s_commadva set appby = '" . $_SESSION["CURRENT_USER"] . "' where refno = '" . $mrefno . "' AND FLAG='ADV'";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);

		$sql = "Update s_commadva set appdate = '" . date("Y-m-d") . "' where refno = '" . $mrefno . "' AND FLAG='ADV'";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);

		echo "Records are Locked";
	} else {
		echo "No Records Found";
	}

}

if ($_GET["Command"] == "com_unlock") {

	include ("connectioni.php");

	//$X = MsgBox("Are you sure that you want to unlock this entry?", vbYesNo, Warning)
	//If X = vbNo Then Exit Sub

	$mrefno = date("m/Y", strtotime($_GET["dtMonth"])) . "-" . $_GET["cmbrep"] . "-" . $_GET["cmbdev"];
	$sql_commadva = "select * from s_commadva where refno='" . $mrefno . "'";
	$result_commadva = mysqli_query($GLOBALS['dbinv'], $sql_commadva);
	if ($row_commadva = mysqli_fetch_array($result_commadva)) {

		if ($row_commadva["chno"] == "0") {

			$sql = "Update s_commadva set lock1 ='0' where refno = '" . $mrefno . "' AND FLAG='ADV'";
			$result = mysqli_query($GLOBALS['dbinv'], $sql);

			$sql = "Update s_commadva set appby = '' where refno = '" . $mrefno . "' AND FLAG='ADV'";
			$result = mysqli_query($GLOBALS['dbinv'], $sql);

			$sql = "Update s_commadva set appdate = '' where refno = '" . $mrefno . "' AND FLAG='ADV'";
			$result = mysqli_query($GLOBALS['dbinv'], $sql);

			echo "Records are UnLocked";
		} else {
			echo "Can not Unlocked, Cheque written";
		}
	}

}

if ($_GET["Command"] == "lock_advance") {

	$year = substr($_GET["dtMonth"], 0, 4);
	$month = substr($_GET["dtMonth"], 5, 2);

	$mrefno = $month . "/" . $year . "-" . substr($_GET["cmbrep"], 0, 2) . "-" . $_GET["cmbdev"];

	$sql_commadva = "select * from s_commadva where refno='" . $mrefno . "'";
	$result_commadva = mysqli_query($GLOBALS['dbinv'], $sql_commadva);
	if ($row_commadva = mysqli_fetch_array($result_commadva)) {
		$sql = "Update s_commadva set Lock1 ='1' where refno = '" . $mrefno . "' AND FLAG='ADV'";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);
		$sql = "Update s_commadva set Over60out = '" . $_GET["txtover60"] . "' where refno = '" . $mrefno . "' AND FLAG='ADV'";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);
		$sql = "Update s_commadva set Returnchk = '" . $_GET["txtretcheq"] . "' where refno = '" . $mrefno . "' AND FLAG='ADV'";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);

		$sql = "Update s_commadva set appby = '" . $_SESSION["CURRENT_USER"] . "' where refno = '" . $mrefno . "' AND FLAG='ADV'";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);
		$sql = "Update s_commadva set appdate = '" . date("Y-m-d") . "' where refno = '" . $mrefno . "' AND FLAG='ADV'";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);

		echo "Records are Locked";
	} else {
		echo "No Records Found";
	}
}

if ($_GET["Command"] == "view_summery") {
	include ('connectioni.php');

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	$sql_st = "delete from tmp_s_sttr ";
	$result_st = mysqli_query($GLOBALS['dbinv'], $sql_st);

	$year = substr($_GET["dtMonth"], 0, 4);
	$month = substr($_GET["dtMonth"], 5, 2);

	$mrefno = $month . "/" . $year . "-" . substr($_GET["cmbrep"], 1, 2) . "-" . $_GET["cmbdev"];

	$sql_commadva = "select * from s_commadva where refno='" . $mrefno . "'";
	//echo $sql_commadva;
	$result_commadva = mysqli_query($GLOBALS['dbinv'], $sql_commadva);
	if ($row_commadva = mysqli_fetch_array($result_commadva)) {
		$ResponseXML .= "<txtdedamt2><![CDATA[" . $row_commadva["advance"] . "]]></txtdedamt2>";
	}

	$sql = "select * from s_salma where Accname != 'NON STOCK' and month(SDATE)='" . $month . "' and year(SDATE)='" . $year . "' and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0'";
	//echo $sql;
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {

		$sql_st = "insert into tmp_s_sttr select * FROM s_sttr where ST_INVONO='" . $row["REF_NO"] . "'";
		//echo $sql_st;
		$result_st = mysqli_query($GLOBALS['dbinv'], $sql_st);

		$sql_st = "select * from s_sttr where ST_INVONO='" . $row["REF_NO"] . "'";
		//echo $sql_st;
		$result_st = mysqli_query($GLOBALS['dbinv'], $sql_st);
		while ($row_st = mysqli_fetch_array($result_st)) {

			$days = 0;
			if (trim($row_st["ST_FLAG"]) == "UT") {
				if (is_null($row["deli_date"]) == false) {
					$diff = abs(strtotime($row_st["ST_DATE"]) - strtotime($row["deli_date"]));
					$days = floor($diff / (60 * 60 * 24));
				} else {
					$diff = abs(strtotime($row_st["ST_DATE"]) - strtotime($row["SDATE"]));
					$days = floor($diff / (60 * 60 * 24));
				}
			} else {
				if (is_null($row["deli_date"]) == false) {
					$diff = abs(strtotime($row_st["st_chdate"]) - strtotime($row["deli_date"]));
					$days = floor($diff / (60 * 60 * 24));
				} else {
					$diff = abs(strtotime($row_st["st_chdate"]) - strtotime($row["SDATE"]));
					$days = floor($diff / (60 * 60 * 24));
				}
			}

			if (is_null($row_st["comm"]) == false) {
				if (trim($row_st["comm"]) == "Yes") {
					$sql1 = "update s_sttr set del_days=" . $row_st["ap_days"] . " where ID=" . $row_st["ID"];
					$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

					$sql1 = "update tmp_s_sttr set del_days=" . $row_st["ap_days"] . " where ID=" . $row_st["ID"];
					$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
				} else {
					$sql1 = "update s_sttr set del_days=" . $days . " where ID=" . $row_st["ID"];
					$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

					$sql1 = "update tmp_s_sttr set del_days=" . $days . " where ID=" . $row_st["ID"];
					$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
				}
			} else {
				$sql1 = "update s_sttr set del_days=" . $days . " where ID=" . $row_st["ID"];
				$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

				$sql1 = "update tmp_s_sttr set del_days=" . $days . " where ID=" . $row_st["ID"];
				$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
			}
		}
	}

	$m_update = true;
	if ($m_update == true) {
		$sql1 = "update s_salma set DIS='0' where month(SDATE)='" . $month . "' AND year(SDATE)='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0'";
		$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
	}

	$sql1 = "SELECT SUM(AMOUNT)AS RETAMU  FROM c_bal WHERE (flag1 = '0') and MONTH(SDATE)='" . $month . "' AND YEAR(SDATE) ='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0' and (trn_type='GRN' or  trn_type='CNT' ) ";
	$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
	if ($row1 = mysqli_fetch_array($result1)) {
		if (is_null($row1["RETAMU"]) == false) {
			$totret = $row1["RETAMU"];
		}
	}

	if ($_GET["cmbdev"] == "All") {
		$sql_inv = "select SUM(GRAND_TOT) AS SALEAMU  from s_salma where Accname != 'NON STOCK' and month(SDATE)='" . $month . "' AND YEAR(SDATE)='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0' ";
		$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
		if ($row_inv = mysqli_fetch_array($result_inv)) {
			if (is_null($row_inv["SALEAMU"]) == false) {
				$TOTSALE = $row_inv["SALEAMU"];
			}
		}
	} else {
		$sql_inv = "select SUM(GRAND_TOT) AS SALEAMU  from s_salma where Accname != 'NON STOCK' and month(SDATE)='" . $month . "' AND YEAR(SDATE)='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0' and dev='" . trim($_GET["cmbdev"]) . "'";
		$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
		if ($row_inv = mysqli_fetch_array($result_inv)) {
			if (is_null($row_inv["SALEAMU"]) == false) {
				$TOTSALE = $row_inv["SALEAMU"];
			}
		}
	}

	$sql_inv = "select SUM(GRAND_TOT) AS SALEAMU  from s_salma where Accname != 'NON STOCK' and month(SDATE)='" . $month . "' AND YEAR(SDATE)='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0'";
	$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
	if ($row_inv = mysqli_fetch_array($result_inv)) {
		if (is_null($row_inv["SALEAMU"]) == false) {
			$TOTSALEALL = $row_inv["SALEAMU"];
		}
	}

	//==============find target=============================================

	$sql_TAR = "select * from sal_comm where sal_ex='" . $_GET["cmbrep"] . "'";
	$result_TAR = mysqli_query($GLOBALS['dbinv'], $sql_TAR);
	if ($row_TAR = mysqli_fetch_array($result_TAR)) {
		$txtt1 = $row_TAR["T1"];
		$txtt2 = $row_TAR["T2"];
	}

	$ResponseXML .= "<txtt1><![CDATA[" . $txtt1 . "]]></txtt1>";
	$ResponseXML .= "<txtt2><![CDATA[" . $txtt2 . "]]></txtt2>";
	//========================================

	$netSale = ($TOTSALEALL - $totret) / (1 + ($txtvat / 100)) - $_GET["txtRetChkAmou_D1"];
	if ($_GET["cmbdev"] == "1") {
		$txtBalsale = $TOTSALE / (1 + ($_GET["txtvat"] / 100)) - $_GET["txtRetChkAmou_D1"];
		$ResponseXML .= "<txtBalsale><![CDATA[" . $txtBalsale . "]]></txtBalsale>";
	}

	if ($_GET["cmbdev"] == "0") {
		$txtBalsale = ($TOTSALE - $totret) / (1 + ($_GET["txtvat"] / 100)) - $_GET["txtRetChkAmou_Do"];
		$ResponseXML .= "<txtBalsale><![CDATA[" . $txtBalsale . "]]></txtBalsale>";
	}

	if ($_GET["cmbdev"] == "1") {
		$txtnet = $TOTSALE / (1 + ($_GET["txtvat"] / 100));
		$ResponseXML .= "<txtnet><![CDATA[" . $txtnet . "]]></txtnet>";
	}

	if ($_GET["cmbdev"] == "0") {
		$txtnet = ($TOTSALE - $totret) / (1 + ($_GET["txtvat"] / 100));
		$ResponseXML .= "<txtnet><![CDATA[" . $txtnet . "]]></txtnet>";
	}

	$X = 0;

	$sql_inv = "select * from s_salma where Accname != 'NON STOCK' and month(SDATE)='" . $month . "' AND YEAR(SDATE)='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0' order by C_CODE";
	$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
	while ($row_inv = mysqli_fetch_array($result_inv)) {
		$invamou = 0;
		$invamou = $row_inv["GRAND_TOT"];
		if ($row_inv["GRAND_TOT"] == "Y") {
			$lblComm = "Locked";
		}

		//===============================================Choose Commission Catogory=====================================
		$day1 = 0;
		$day2 = 0;
		$cat1 = 0;
		$cat2 = 0;
		$cat3 = 0;

		$sql_cat = "select * from com_she where sal_ex='" . $_GET["cmbrep"] . "' and Brand='" . trim($row_inv["Brand"]) . "'";
		$result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
		$row_cat = mysqli_fetch_array($result_cat);
		$day1 = $row_cat["Day1"];
		$day2 = $row_cat["Day2"];

		if ($netSale > $_GET["txtt2"]) {
			$cat1 = $row_cat["T3_cat1"];
			$cat2 = $row_cat["T3_cat2"];
			$cat3 = $row_cat["T3_cat3"];

		} else if ($netSale > $_GET["txtt1"]) {
			$cat1 = $row_cat["T2_cat1"];
			$cat2 = $row_cat["T2_cat2"];
			$cat3 = $row_cat["T2_cat3"];
		} else {
			$cat1 = $row_cat["T1_cat1"];
			$cat2 = $row_cat["T1_cat2"];
			$cat3 = $row_cat["T1_cat3"];
		}

		$sql_rsven = "Select incdays from vendor where CODE = '" . trim($row_inv["C_CODE"]) . "'";
		$result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
		if ($row_rsven = mysqli_fetch_array($result_rsven)) {
			if ($row_rsven["incdays"] > $day1) {
				$day1 = $row_rsven["incdays"] + 1;
				$day2 = $row_rsven["incdays"] + 1;
			}
		}

		if ($row_inv["cre_pe"] > $day1) {
			$day1 = $row_inv["cre_pe"] + 1;
			$day2 = $row_inv["cre_pe"] + 1;
		}

		if ($row_inv["DEV"] == "1") {
			//=========================================================================
			$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["ST_REFNO"]) . "' AND (del_days<" . $day1 . " and ST_FLAG != 'UT')";
			//echo $sql_sttr;
			$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
			if ($row_sttr = mysqli_fetch_array($result_sttr)) {
				if (is_null($row_sttr["INVPAID"]) == false) {
					$tot_Comm_cat_1_D1 = $tot_Comm_cat_1_D1 + $row_sttr["INVPAID"];
					if ($cat1 > 0) {
						$t = $t + $row_sttr["INVPAID"];
						$TOTcOMMpAY_D1 = $TOTcOMMpAY_D1 + $row_sttr["INVPAID"];
						if (trim($_GET["cmbdev"]) == "1") { $cat1SALE = $cat1SALE + $row_sttr["INVPAID"];
						}
					} else {
						$TOTnOcOMMpAY_D1 = $TOTnOcOMMpAY_D1 + $row_sttr["INVPAID"];
						if ($_GET["cmbdev"] == "1") {
							///////SetNoComm/////////////
							$sql = "select Brand from s_salma where Accname != 'NON STOCK' and REF_NO='" . $row_inv["REF_NO"] . "'";
							$result = mysqli_query($GLOBALS['dbinv'], $sql);
							if ($row = mysqli_fetch_array($result)) {

								$sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
								$result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
								if ($row_brType = mysqli_fetch_array($result_brType)) {

									$r = 0;
									while ($GLOBALS[$MSHFlexGrid1_count] > $r) {
										if ($GLOBALS[$MSHFlexGrid1[$r][0]] == trim($row_brType["class"])) {
											$GLOBALS[$MSHFlexGrid1[$r][1]] = $GLOBALS[$MSHFlexGrid1[$r][1]] + $row_sttr["INVPAID"];
											$r = $GLOBALS[$MSHFlexGrid1_count];
										}
										$r = $r + 1;
										//echo "aaa : ".$GLOBALS[$MSHFlexGrid1[$r][1]];
									}
								}
							}
						}

					}
				}
			}
			//============================================

			$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . $row_inv["REF_NO"] . "' AND (del_days<" . $day1 . " and del_days>60 ) and ST_FLAG != 'UT'";
			$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
			if ($row_sttr = mysqli_fetch_array($result_sttr)) {
				if (is_null($row_sttr["INVPAID"])) {
					// $tot_Comm_cat_1_D1 = $tot_Comm_cat_1_D1 + $row_sttr["INVPAID"];
					if ($cat1 > 0) {
						if (trim($_GET["cmbdev"]) == "1") { $cat1SpSALE = $cat1SpSALE + $sttr["INVPAID"];
						}

					} else {

					}

				}
			}

			//============================================

			$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . $row_inv["REF_NO"] . "' AND   ST_FLAG = 'UT' ";
			$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
			if ($row_sttr = mysqli_fetch_array($result_sttr)) {
				$tot_Comm_cat_1_D1 = $tot_Comm_cat_1_D1 + $row_sttr["INVPAID"];
				if ($cat1 > 0) {
					$TOTcOMMpAY_D1 = $TOTcOMMpAY_D1 + $sttr["INVPAID"];
					$t = $t + $row_sttr["INVPAID"];

					if (trim($_GET["cmbdev"]) == "1") { $cat1SALE = $cat1SALE + $row_sttr["INVPAID"];
					}
				} else {
					$TOTnOcOMMpAY_D1 = $TOTnOcOMMpAY_D1 + $row_sttr["INVPAID"];
					if ($_GET["cmbdev"] == "1") {
						///////SetNoComm/////////////
						$sql = "select Brand from s_salma where Accname != 'NON STOCK' and REF_NO='" . $row_inv["REF_NO"] . "'";
						$result = mysqli_query($GLOBALS['dbinv'], $sql);
						if ($row = mysqli_fetch_array($result)) {

							$sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
							$result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
							if ($row_brType = mysqli_fetch_array($result_brType)) {

								$r = 0;
								while ($GLOBALS[$MSHFlexGrid1_count] > $r) {
									if ($GLOBALS[$MSHFlexGrid1[$r][0]] == trim($row_brType["class"])) {
										$GLOBALS[$MSHFlexGrid1[$r][1]] = $GLOBALS[$MSHFlexGrid1[$r][1]] + $row_sttr["INVPAID"];
										$r = $GLOBALS[$MSHFlexGrid1_count];
									}
									$r = $r + 1;

								}
							}
						}
					}
				}

			}

			$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days> " . $day1 . " or del_days= " . $day1 . ") AND del_days<" . $day2 . " and ST_FLAG!='UT' ";
			$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
			if ($row_sttr = mysqli_fetch_array($result_sttr)) {
				$tot_Comm_cat_2_D1 = $tot_Comm_cat_2_D1 + $row_sttr["INVPAID"];
				if ($cat2 > 0) {
					$t1 = $t1 + $row_sttr["INVPAID"];
					$TOTcOMMpAY_D1 = $TOTcOMMpAY_D1 + $row_sttr["INVPAID"];
					if (trim($_GET["cmbdev"]) == "1") { $cat2SALE = $cat2SALE + $row_sttr["INVPAID"];
					}
				} else {
					$TOTnOcOMMpAY_D1 = $TOTnOcOMMpAY_D1 + $row_sttr["INVPAID"];
					if ($_GET["cmbdev"] == "1") {
						///////SetNoComm/////////////
						$sql = "select Brand from s_salma where Accname != 'NON STOCK' and REF_NO='" . $row_inv["REF_NO"] . "'";
						$result = mysqli_query($GLOBALS['dbinv'], $sql);
						if ($row = mysqli_fetch_array($result)) {

							$sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
							$result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
							if ($row_brType = mysqli_fetch_array($result_brType)) {

								$r = 0;
								while ($GLOBALS[$MSHFlexGrid1_count] > $r) {
									if ($GLOBALS[$MSHFlexGrid1[$r][0]] == trim($row_brType["class"])) {
										$GLOBALS[$MSHFlexGrid1[$r][1]] = $GLOBALS[$MSHFlexGrid1[$r][1]] + $row_sttr["INVPAID"];
										$r = $GLOBALS[$MSHFlexGrid1_count];
									}
									$r = $r + 1;

								}
							}
						}
					}
				}
			}

			$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND   (del_days>" . $day2 . " or del_days=" . $day1 . ") and ST_FLAG<>'UT' ";
			$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
			if ($row_sttr = mysqli_fetch_array($result_sttr)) {
				if (is_null($row_sttr["INVPAID"]) == false) {
					$tot_Comm_cat_3_D1 = $tot_Comm_cat_3_D1 + $row_sttr["INVPAID"];
					if ($cat3 > 0) {
						$TOTcOMMpAY_D1 = $TOTcOMMpAY_D1 + $row_sttr["INVPAID"];
					} else {
						$TOTnOcOMMpAY_D1 = $TOTnOcOMMpAY_D1 + $row_sttr["INVPAID"];
						if ($_GET["cmbdev"] == "1") {
							///////SetNoComm/////////////
							$sql = "select Brand from s_salma where Accname != 'NON STOCK' and REF_NO='" . $row_inv["REF_NO"] . "'";
							$result = mysqli_query($GLOBALS['dbinv'], $sql);
							if ($row = mysqli_fetch_array($result)) {

								$sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
								$result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
								if ($row_brType = mysqli_fetch_array($result_brType)) {

									$r = 0;
									while ($GLOBALS[$MSHFlexGrid1_count] > $r) {
										if ($GLOBALS[$MSHFlexGrid1[$r][0]] == trim($row_brType["class"])) {
											$GLOBALS[$MSHFlexGrid1[$r][1]] = $GLOBALS[$MSHFlexGrid1[$r][1]] + $row_sttr["INVPAID"];
											$r = $GLOBALS[$MSHFlexGrid1_count];
										}
										$r = $r + 1;

									}
								}
							}
						}
					}
				}
			}

		} else {

			//=========================================================================
			$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND  del_days<" . $day1 . "  and ST_FLAG!='UT' ";
			//echo $sql_sttr;
			$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);

			if ($row_sttr = mysqli_fetch_array($result_sttr)) {

				if (is_null($row_sttr["INVPAID"]) == false) {

					$tot_Comm_cat_1_Do = $tot_Comm_cat_1_Do + $row_sttr["INVPAID"];
					if ($cat1 > 0) {
						$TOTcOMMpAY_Do = $TOTcOMMpAY_Do + $row_sttr["INVPAID"];
						$invamou = $invamou - $row_sttr["INVPAID"];
						if (trim($_GET["cmbdev"]) == "0") { $cat1SALE = $cat1SALE + $row_sttr["INVPAID"];
						}
					} else {
						$TOTnOcOMMpAY_Do = $TOTnOcOMMpAY_Do + $row_sttr["INVPAID"];
						$invamou = $invamou - $row_sttr["INVPAID"];
						if ($_GET["cmbdev"] == "0") {
							///////SetNoComm/////////////
							$sql = "select Brand from s_salma where Accname != 'NON STOCK' and REF_NO='" . $row_inv["REF_NO"] . "'";
							$result = mysqli_query($GLOBALS['dbinv'], $sql);
							if ($row = mysqli_fetch_array($result)) {

								$sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
								$result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
								if ($row_brType = mysqli_fetch_array($result_brType)) {

									$r = 0;
									while ($GLOBALS[$MSHFlexGrid1_count] > $r) {
										if ($GLOBALS[$MSHFlexGrid1[$r][0]] == trim($row_brType["class"])) {
											$GLOBALS[$MSHFlexGrid1[$r][1]] = $GLOBALS[$MSHFlexGrid1[$r][1]] + $row_sttr["INVPAID"];
											$r = $GLOBALS[$MSHFlexGrid1_count];
										}
										$r = $r + 1;

									}
								}
							}
						}
					}

				}
			}

			$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' and ST_FLAG!='UT' ";
			$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
			if ($row_sttr = mysqli_fetch_array($result_sttr)) {
				if (is_null($row_sttr["INVPAID"]) == false) {
					$tot_Comm_cat_1_Do = $tot_Comm_cat_1_Do + $row_sttr["INVPAID"];
					if ($cat1 > 0) {
						$TOTcOMMpAY_Do = $TOTcOMMpAY_Do + $row_sttr["INVPAID"];
						$invamou = $invamou - $row_sttr["INVPAID"];
						if (trim($_GET["cmbdev"]) == "0") { $cat1SALE = $cat1SALE + $row_sttr["INVPAID"];
						}
					} else {
						$TOTnOcOMMpAY_Do = $TOTnOcOMMpAY_Do + $row_sttr["INVPAID"];
						$invamou = $invamou - $row_sttr["INVPAID"];
						if ($_GET["cmbdev"] == "0") {
							///////SetNoComm/////////////
							$sql = "select Brand from s_salma where Accname != 'NON STOCK' and REF_NO='" . $row_inv["REF_NO"] . "'";
							$result = mysqli_query($GLOBALS['dbinv'], $sql);
							if ($row = mysqli_fetch_array($result)) {

								$sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
								$result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
								if ($row_brType = mysqli_fetch_array($result_brType)) {

									$r = 0;
									while ($GLOBALS[$MSHFlexGrid1_count] > $r) {
										if ($GLOBALS[$MSHFlexGrid1[$r][0]] == trim($row_brType["class"])) {
											$GLOBALS[$MSHFlexGrid1[$r][1]] = $GLOBALS[$MSHFlexGrid1[$r][1]] + $row_sttr["INVPAID"];
											$r = $GLOBALS[$MSHFlexGrid1_count];
										}
										$r = $r + 1;

									}
								}
							}
						}
					}
				}
			}

			//======================================================================================================
			$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . "  and del_days>60) and ST_FLAG != 'UT' ";
			$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);

			if ($row_sttr = mysqli_fetch_array($result_sttr)) {
				if (is_null($row_sttr["INVPAID"]) == false) {
					if ($cat1 > 0) {
						if (trim($_GET["cmbdev"]) == "0") { $cat1SpSALE = $cat1SpSALE + $row_sttr["INVPAID"];
						}
						$X = $X + 1;
					}
				}
			}

			//====================================================================================================
			$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . "  or  del_days>" . $day1 . ") and ST_FLAG != 'UT' ";
			$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
			if ($row_sttr = mysqli_fetch_array($result_sttr)) {
				if (is_null($row_sttr["INVPAID"]) == false) {
					$tot_Comm_cat_2_Do = $tot_Comm_cat_2_Do + $row_sttr["INVPAID"];
					if ($cat2 > 0) {
						$TOTcOMMpAY_Do = $TOTcOMMpAY_Do + $row_sttr["INVPAID"];
						$invamou = $invamou - $row_sttr["INVPAID"];
						if (trim($_GET["cmbdev"]) == "0") { $cat2SALE = $cat2SALE + $row_sttr["INVPAID"];
						}
					} else {
						$TOTnOcOMMpAY_Do = $TOTnOcOMMpAY_Do + $row_sttr["INVPAID"];
						$invamou = $invamou - $row_sttr["INVPAID"];
						if ($_GET["cmbdev"] == "0") {
							///////SetNoComm/////////////
							$sql = "select Brand from s_salma where Accname != 'NON STOCK' and REF_NO='" . $row_inv["REF_NO"] . "'";
							$result = mysqli_query($GLOBALS['dbinv'], $sql);
							if ($row = mysqli_fetch_array($result)) {

								$sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
								$result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
								if ($row_brType = mysqli_fetch_array($result_brType)) {

									$r = 0;
									while ($GLOBALS[$MSHFlexGrid1_count] > $r) {
										if ($GLOBALS[$MSHFlexGrid1[$r][0]] == trim($row_brType["class"])) {
											$GLOBALS[$MSHFlexGrid1[$r][1]] = $GLOBALS[$MSHFlexGrid1[$r][1]] + $row_sttr["INVPAID"];
											$r = $GLOBALS[$MSHFlexGrid1_count];
										}
										$r = $r + 1;

									}
								}
							}
						}
					}
				}
			}

			$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day2 . "  or  del_days>" . $day2 . ") and ST_FLAG != 'UT' ";
			$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
			if ($row_sttr = mysqli_fetch_array($result_sttr)) {
				if (is_null($row_sttr["INVPAID"]) == false) {
					$tot_Comm_cat_3_Do = $tot_Comm_cat_3_Do + $row_sttr["INVPAID"];
					if ($cat3 > 0) {
						$TOTcOMMpAY_Do = $TOTcOMMpAY_Do + $row_sttr["INVPAID"];
						$invamou = $invamou - $row_sttr["INVPAID"];
					} else {
						$TOTnOcOMMpAY_Do = $TOTnOcOMMpAY_Do + $row_sttr["INVPAID"];
						$invamou = $invamou - $row_sttr["INVPAID"];
						if ($_GET["cmbdev"] == "0") {
							///////SetNoComm/////////////
							$sql = "select Brand from s_salma where Accname != 'NON STOCK' and REF_NO='" . $row_inv["REF_NO"] . "'";
							$result = mysqli_query($GLOBALS['dbinv'], $sql);
							if ($row = mysqli_fetch_array($result)) {

								$sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
								$result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
								if ($row_brType = mysqli_fetch_array($result_brType)) {

									$r = 0;
									while ($GLOBALS[$MSHFlexGrid1_count] > $r) {
										if ($GLOBALS[$MSHFlexGrid1[$r][0]] == trim($row_brType["class"])) {
											$GLOBALS[$MSHFlexGrid1[$r][1]] = $GLOBALS[$MSHFlexGrid1[$r][1]] + $row_sttr["INVPAID"];
											$r = $GLOBALS[$MSHFlexGrid1_count];
										}
										$r = $r + 1;

									}
								}
							}
						}
					}
				}
			}

			if ($invamou < -1) {
				$invamou = 0;
				$REFNO = $row_inv["REF_NO"];
			}
		}
	}
	//===========================================Del days update ==============================================
	$Y = $X;
	$Frame1 = $month . "/" . $year . " -  " . $_GET["cmbrep"];
	$ResponseXML .= "<Frame1><![CDATA[" . $Frame1 . "]]></Frame1>";
	$ResponseXML .= "<txtnetsale><![CDATA[" . number_format($TOTSALE, 2, ".", ",") . "]]></txtnetsale>";

	if ($_GET["cmbdev"] == "0") {
		$ResponseXML .= "<txtret><![CDATA[" . number_format($totret, 2, ".", ",") . "]]></txtret>";
	} else {

		$ResponseXML .= "<txtret><![CDATA[]]></txtret>";
	}

	if ($_GET["cmbdev"] == "1") {
		$txtout = $TOTSALE - $TOTcOMMpAY_D1 - $TOTnOcOMMpAY_D1;
		$ResponseXML .= "<txtout><![CDATA[" . number_format($txtout, 2, ".", ",") . "]]></txtout>";

		$txtpaid = $TOTcOMMpAY_D1 + $TOTnOcOMMpAY_D1;
		$ResponseXML .= "<txtpaid><![CDATA[" . number_format($txtpaid, 2, ".", ",") . "]]></txtpaid>";

		$txtNocomm = $TOTnOcOMMpAY_D1;
		$ResponseXML .= "<txtNocomm><![CDATA[" . number_format($txtNocomm, 2, ".", ",") . "]]></txtNocomm>";
	}

	if ($_GET["cmbdev"] == "0") {
		$txtout = $TOTSALE - $TOTcOMMpAY_Do - $TOTnOcOMMpAY_Do;
		$ResponseXML .= "<txtout><![CDATA[" . number_format($txtout, 2, ".", ",") . "]]></txtout>";

		$txtpaid = $TOTcOMMpAY_Do + $TOTnOcOMMpAY_Do;
		$ResponseXML .= "<txtpaid><![CDATA[" . number_format($txtpaid, 2, ".", ",") . "]]></txtpaid>";

		$txtNocomm = $TOTnOcOMMpAY_Do;
		$ResponseXML .= "<txtNocomm><![CDATA[" . number_format($txtNocomm, 2, ".", ",") . "]]></txtNocomm>";
	}

	if ($_GET["cmbdev"] == "All") {

		$txtNocomm = $TOTnOcOMMpAY_D1 + $TOTnOcOMMpAY_Do / (1 + ($_GET["txtvat"] / 100));
		$ResponseXML .= "<txtNocomm><![CDATA[" . number_format($txtNocomm, 2, ".", ",") . "]]></txtNocomm>";

		$txtout = $TOTSALE - ($TOTcOMMpAY_D1 + $TOTcOMMpAY_Do) - ($TOTnOcOMMpAY_D1 + $TOTnOcOMMpAY_Do);
		$ResponseXML .= "<txtout><![CDATA[" . number_format($txtout, 2, ".", ",") . "]]></txtout>";

		$txtpaid = $TOTcOMMpAY_D1 + $TOTcOMMpAY_Do + $TOTnOcOMMpAY_D1 + $TOTnOcOMMpAY_Do;
		$ResponseXML .= "<txtpaid><![CDATA[" . number_format($txtpaid, 2, ".", ",") . "]]></txtpaid>";

	}

	$netsaleall = ($TOTSALEALL - $totret) / (1 + ($_GET["txtvat"] / 100));
	$txtTotnet = ($TOTSALEALL - $totret) / (1 + ($_GET["txtvat"] / 100));
	$ResponseXML .= "<txtTotnet><![CDATA[" . number_format($netsaleall, 2, ".", ",") . "]]></txtTotnet>";

	//====================Dis chng done coz req of malaka & Milroy================

	$txtTOTNocom = ($TOTnOcOMMpAY_D1 + $TOTnOcOMMpAY_Do) / (1 + ($_GET["txtvat"] / 100));
	$ResponseXML .= "<txtTOTNocom><![CDATA[" . number_format($txtTOTNocom, 2, ".", ",") . "]]></txtTOTNocom>";

	$txtpre = (($TOTnOcOMMpAY_D1 + $TOTnOcOMMpAY_Do) / (1 + ($_GET["txtvat"] / 100)) + $_GET["txtRetChkAmou_D1"] + $_GET["txtRetChkAmou_Do"]) / $netsaleall * 100;
	$ResponseXML .= "<txtpre><![CDATA[" . number_format($txtpre, 2, ".", ",") . "]]></txtpre>";

	$txtcat1sale = $cat1SALE - $cat1SpSALE;
	$ResponseXML .= "<txtcat1sale><![CDATA[" . number_format($txtcat1sale, 2, ".", ",") . "]]></txtcat1sale>";

	$txtcat1Spsale = $cat1SpSALE;
	$ResponseXML .= "<txtcat1Spsale><![CDATA[" . number_format($txtcat1Spsale, 2, ".", ",") . "]]></txtcat1Spsale>";

	$txtcat2sale = $cat2SALE;
	$ResponseXML .= "<txtcat2sale><![CDATA[" . number_format($txtcat2sale, 2, ".", ",") . "]]></txtcat2sale>";

	////////////////////eFFSAle/////////////////////////////////////
	if ($txtpre <= 15) {

		if ($_GET["cmbdev"] == "1") { $txtBalsale = $txtnet;
		}
		if ($_GET["cmbdev"] == "0") { $txtBalsale = $txtnet;
		}
		if ($_GET["cmbdev"] == "All") { $txtBalsale = $txtnet;
		}
		$txtbalSAleTOT = $txtTotnet;

	} else {

		if ($_GET["cmbdev"] == "1") { $txtBalsale = $txtnet - $_GET["txtRetChkAmou_D1"] - $txtNocomm;
		}
		if ($_GET["cmbdev"] == "0") { $txtBalsale = $txtnet - $_GET["txtRetChkAmou_Do"] - $txtNocomm;
		}
		if ($_GET["cmbdev"] == "All") { $txtBalsale = $txtnet - $_GET["txtRetChkAmou_D1"] - $_GET["txtRetChkAmou_Do"] - $txtNocomm;
		}

		$txtbalSAleTOT = $txtTotnet - $_GET["txtRetChkAmou_D1"] - $_GET["txtRetChkAmou_Do"] - $txtTOTNocom;
	}

	$ResponseXML .= "<txtBalsale><![CDATA[" . number_format($txtBalsale, 2, ".", ",") . "]]></txtBalsale>";
	$ResponseXML .= "<txtbalSAleTOT><![CDATA[" . number_format($txtbalSAleTOT, 2, ".", ",") . "]]></txtbalSAleTOT>";

	////////////////////end eFFSAle/////////////////////////////////////

	$ResponseXML .= "<MSHFlexGrid1><![CDATA[ <table  bgcolor=\"#003366\" border=1  cellspacing=0>
								<tr><td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Class</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Paid Amount</font></td>
								
								
							</tr>";

	$r = 0;
	while ($MSHFlexGrid1_count > $r) {
		$ResponseXML .= "<tr><td>" . $GLOBALS[$MSHFlexGrid1[$r][0]] . "</td>
						<td>" . $GLOBALS[$MSHFlexGrid1[$r][1]] . "</td>
						</tr>";
		$r = $r + 1;
	}

	$ResponseXML .= "   </table>]]></MSHFlexGrid1>";

	$ResponseXML .= " </salesdetails>";
	echo $ResponseXML;
}

if ($_GET["Command"] == "calculation") {

	include ('connectioni.php');

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	$year = substr($_GET["dtMonth"], 0, 4);
	$month = substr($_GET["dtMonth"], 5, 2);

	$sql_inv = "select * from s_salma where Accname != 'NON STOCK' and month(SDATE)='" . $month . "' AND YEAR(SDATE)='" . $year . "' AND SAL_EX='" . trim($_GET["cmbrep"]) . "' AND CANCELL='0' ";
	//	echo $sql_inv;
	$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

	while ($row_inv = mysqli_fetch_array($result_inv)) {
		//===============================================Choose Commission Catogory=====================================
		$day1 = 0;
		$day2 = 0;
		$cat1 = 0;
		$cat2 = 0;
		$cat3 = 0;

		$sql_cat = "select * from com_she where sal_ex='" . trim($_GET["cmbrep"]) . "' and Brand='" . trim($row_inv["Brand"]) . "' ";
		$result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
		$row_cat = mysqli_fetch_array($result_cat);

		$day1 = $row_cat["day1"];
		$day2 = $row_cat["day2"];

		if ($_GET["txtbalSAleTOT"] > $_GET["txtt2"]) {
			$cat1 = $row_cat["T3_cat1"];
			$cat2 = $row_cat["T3_cat2"];
			$cat3 = $row_cat["T3_cat3"];
			$tarcat = 3;
		} else if ($_GET["txtbalSAleTOT"] > $_GET["txtt1"]) {
			$cat1 = $row_cat["T2_Cat1"];
			$cat2 = $row_cat["T2_cat2"];
			$cat3 = $row_cat["T2_Cat3"];
			$tarcat = 2;
		} else {
			$cat1 = $row_cat["T1_Cat1"];
			$cat2 = $row_cat["T1_cat2"];
			$cat3 = $row_cat["T1_cat3"];
			$tarcat = 1;
		}

		$sql_rsven = "Select incdays from vendor where CODE = '" . trim($row_inv["C_CODE"]) . "'";
		$result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
		$row_rsven = mysqli_fetch_array($result_rsven);
		if ($row_rsven["incdays"] > $day1) {
			$day1 = $row_rsven["incdays"] + 1;
			$day2 = $row_rsven["incdays"] + 1;
		}

		if ($row_inv["cre_pe"] > $day1) {
			$day1 = $row_inv["cre_pe"] + 1;
			$day2 = $row_inv["cre_pe"] + 1;
		}
		if ($_GET["cmbdev"] == "All") { $dv = "A";
		}
		if ($_GET["cmbdev"] == "1") { $dv = "0";
		}
		if ($_GET["cmbdev"] == "0") { $dv = "1";
		}

		if ($row_inv["DEV"] != $dv) {
			//=========================================================================

			$sql_sttr = "select sum(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . "   or ST_FLAG = 'UT') ";
			//echo  $sql_sttr;
			$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
			if ($row_sttr = mysqli_fetch_array($result_sttr)) {
				if (is_null($row_sttr["INVPAID"]) == false) {
					if ($row_inv["DEV"] == "1") {
						$ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat1 * 0.01;
						$cat1Comm = cat1Comm + $row_sttr["INVPAID"] * $cat1 * 0.01;
					} else {
						$ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat1 * 0.01 / (1 + ($_GET["txtvat"] / 100));
						$cat1Comm = $cat1Comm + $row_sttr["INVPAID"] * $cat1 * 0.01 / (1 + ($_GET["txtvat"] / 100));
					}
				}
			}

		}

		//=================================================================
		$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . ") AND (del_days>60)  and ST_FLAG!='UT'";

		$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
		if ($row_sttr = mysqli_fetch_array($result_sttr)) {
			if (is_null($row_sttr["INVPAID"]) == false) {
				if ($row_inv["DEV"] == "1") {
					$cat1SpComm = $cat1SpComm + $row_sttr["INVPAID"] * $cat1 * 0.01;
				} else {
					$cat1SpComm = $cat1SpComm + $row_sttr["INVPAID"] * $cat1 * 0.01 / (1 + ($_GET["txtvat"] / 100));
				}
			}
		}

		//=======================================================================
		$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days> " . $day1 . " or del_days= " . $day1 . ")AND del_days<" . $day2 . "  and ST_FLAG!='UT' ";
		$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
		if ($row_sttr = mysqli_fetch_array($result_sttr)) {
			if (is_null($row_sttr["INVPAID"]) == false) {
				if ($row_inv["DEV"] == "1") {
					$ComAmou = $ComAmou + $row_inv["INVPAID"] * $cat2 * 0.01;
					$cat2Comm = $cat2Comm + $row_inv["INVPAID"] * $cat2 * 0.01;
				} else {
					$t = $t + $row_inv["INVPAID"];
					$ComAmou = $ComAmou + $row_inv["INVPAID"] * $cat2 * 0.01 / (1 + ($_GET["txtvat"] / 100));
					$cat2Comm = $cat2Comm + $row_inv["INVPAID"] * $cat2 * 0.01 / (1 + ($_GET["txtvat"] / 100));
				}
			}
		}

		$sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND  ( del_days>" . $day2 . " or  del_days=" . $day2 . " ) and ST_FLAG!='UT'";
		$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
		if ($row_sttr = mysqli_fetch_array($result_sttr)) {
			if (is_null($row_sttr["INVPAID"]) == false) {
				if ($row_inv["DEV"] == "1") {
					$ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat3 * 0.01;
					if (($cat3 == 0) and ($_GET["txtpre"] <= 15)) {
						$cat2NoComm = $cat2NoComm + $row_sttr["INVPAID"] * $cat2 * 0.01;
						$ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat2 * 0.01;

						if ($m_update == true) {
							$row_inv["DIS"] = $row_inv["DIS"] + $row_sttr["INVPAID"] * $cat2 * 0.01;

						}

					}
				} else {
					$ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat3 * 0.01 / (1 + ($_GET["txtvat"] / 100));
					if (($cat3 == 0) and ($_GET["txtpre"] <= 15)) {
						$cat2NoComm = $cat2NoComm + $row_sttr["INVPAID"] * $cat2 * 0.01 / (1 + ($_GET["txtvat"] / 100));
						$ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat2 * 0.01 / (1 + ($_GET["txtvat"] / 100));
						if ($m_update == true) {
							$row_inv["DIS"] = $row_inv["DIS"] + $row_inv["INVPAID"] * $cat2 * 0.01 / (1 + ($_GET["txtvat"] / 100));

						}
					}
				}

			}
		}

	}

	$year = substr($_GET["dtMonth"], 0, 4);
	$month = substr($_GET["dtMonth"], 5, 2);

	$retcommamou = 0;

	if ($_GET["cmbdev"] != "1") {
		$retcommamou = 0;

		$sql_rsgen = "select * from s_crnma where CANCELL='0' and month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and SAL_EX='" . trim($_GET["cmbrep"]) . "'  ";
		// echo $sql_rsgen;
		$result_rsgen = mysqli_query($GLOBALS['dbinv'], $sql_rsgen);
		while ($row_rsgen = mysqli_fetch_array($result_rsgen)) {

			$retcommamou = $retcommamou + $row_rsgen["DUMMY_VAL"] + $row_rsgen["DIS1"];

		}

		$row_rsgen = "select * from cred where CANCELL='0' and  month(C_DATE) =" . $month . " and   year(C_DATE) =" . $year . " and C_SALEX='" . trim($_GET["cmbrep"]) . "'  ";
		// echo $row_rsgen;
		$result_rsgen = mysqli_query($GLOBALS['dbinv'], $sql_rsgen);

		while ($row_rsgen = mysqli_fetch_array($result_rsgen)) {
			$sql_rsbal = "Select * from c_bal where REFNO = '" . $row_rsgen["C_REFNO"] . " ' and flag1 != '1'";
			$result_rsbal = mysqli_query($GLOBALS['dbinv'], $sql_rsbal);
			if ($row_rsbal = mysqli_fetch_array($result_rsbal)) {
				if (is_null($row_rsgen["dummy_val"]) == false) { $retcommamou = $retcommamou + $row_rsgen["dummy_val"];
				}
				if (is_null($row_rsgen["SETTLED"]) == false) { $retcommamou = $retcommamou + $row_rsgen["SETTLED"];
				}
			}
		}

	}
	//=============================================================================================================
	$txtComSale = $ComAmou;
	$txtComGRN = $retcommamou;
	$txtComBal = $ComAmou - $retcommamou - $txtretch;

	$txtcat1Com = $cat1Comm - $cat1SpComm;
	$txtcat1Spcomm = $cat1SpComm;
	$txtcat2com = $cat2Comm;
	$txtdedamt1 = $txtComBal * $_GET["txtpr"] * 0.01;
	$txtNoCom_COm = $cat2NoComm;

	$ResponseXML .= "<txtComSale><![CDATA[" . number_format($txtComSale, 2, ".", ",") . "]]></txtComSale>";
	$ResponseXML .= "<txtComGRN><![CDATA[" . number_format($txtComGRN, 2, ".", ",") . "]]></txtComGRN>";
	$ResponseXML .= "<txtComBal><![CDATA[" . number_format($txtComBal, 2, ".", ",") . "]]></txtComBal>";
	$ResponseXML .= "<txtcat1Com><![CDATA[" . number_format($txtcat1Com, 2, ".", ",") . "]]></txtcat1Com>";
	$ResponseXML .= "<txtcat1Spcomm><![CDATA[" . number_format($txtcat1Spcomm, 2, ".", ",") . "]]></txtcat1Spcomm>";
	$ResponseXML .= "<txtcat2com><![CDATA[" . number_format($txtcat2com, 2, ".", ",") . "]]></txtcat2com>";
	$ResponseXML .= "<txtdedamt1><![CDATA[" . number_format($txtdedamt1, 2, ".", ",") . "]]></txtdedamt1>";
	$ResponseXML .= "<txtNoCom_COm><![CDATA[" . number_format($txtNoCom_COm, 2, ".", ",") . "]]></txtNoCom_COm>";

	$ResponseXML .= " </salesdetails>";
	echo $ResponseXML;

}

if ($_GET["Command"] == "save_advance") {

	include ('connectioni.php');

	$mrefno = date("m/Y", strtotime($_GET["dtMonth"])) . "-" . $_GET["cmbrep"] . "-" . $_GET["cmbdev"];

	//Call Auto_cal--------------------------------------------------------

	$txttot1 = 0;
	$i = 1;
	$TypeGrid1_count = $_POST["mcount"];

	while ($i < $TypeGrid1_count) {

		$TypeGrid08 = "TypeGrid_" . $i . "_08";
		$TypeGrid09 = "TypeGrid_" . $i . "_09";
		$TypeGrid10 = "TypeGrid_" . $i . "_10";
		$TypeGrid14 = "TypeGrid_" . $i . "_14";

		if ($_POST[$TypeGrid09] <= 50) {
			$M50 = $M50 + 1;
		} else {
			if ($_POST[$TypeGrid09] <= $_POST[$TypeGrid10]) {
				$m75 = $m75 + 1;
			}
		}
		if ($_POST[$TypeGrid14] == "INV") {
			if ($_POST[$TypeGrid09] <= $_POST[$TypeGrid10]) {
				$txttot1 = $txttot1 + $_POST[$TypeGrid08];
			} else {
				$txttot1 = $txttot1;
			}
		}
		$i = $i + 1;
	}
	if (date("Y", strtotime($_GET["DTPicker1"])) >= 2014) {
		if (trim($_GET["cmbtype"]) == "Tyre") {
			$sql_rsper = "Select * from intper where incen_year = 2014 and traget < '" . (($txttot1 - $txt_grn) / ($txt_vat + 100) * 100) . "' order by traget desc ";
		}
	} else {
		if (trim($_GET["cmbtype"]) == "Tyre") {
			$sql_rsper = "Select * from intper where incen_year = 20101 and traget < '" . (($txttot1 - $txt_grn) / ($txt_vat + 100) * 100) . "' order by traget desc ";
		}
	}
	if (trim($_GET["cmbtype"]) == "Battery") {
		$sql_rsper = "Select * from intper where incen_year = 20111 and traget < '" . (($txttot1 - $txt_grn) / ($txt_vat + 100) * 100) . "' order by traget desc ";
	}
	if (trim($_GET["cmbtype"]) == "Atlas") {
		$sql_rsper = "Select * from intper where incen_year = 2015 and traget < '" . ($txttot1 - $txt_grn) / ($txt_vat + 100) * 100 . "' order by traget desc ";
	}
	$result_rsper = mysqli_query($GLOBALS['dbinv'], $sql_rsper);
	if ($row_rsper = mysqli_fetch_array($result_rsper)) {
		$txt_percentage = $row_rsper["per"];
		$ii = 1;
		$diff = abs(strtotime($ddate) - strtotime($_GET["DTPicker1"]));
		$days = floor($diff / (60 * 60 * 24));
		if (($days > 0) and (trim($_GET["cmbtype"]) == "Tyre")) {
			while ($ii < $TypeGrid1_count) {

				$TypeGrid03 = "TypeGrid_" . $ii . "_03";
				$TypeGrid08 = "TypeGrid_" . $ii . "_08";
				$TypeGrid09 = "TypeGrid_" . $ii . "_09";
				$TypeGrid10 = "TypeGrid_" . $ii . "_10";
				$TypeGrid14 = "TypeGrid_" . $ii . "_14";

				if ($_POST[$TypeGrid14] == "INV") {
					if ($m75 > 0) {
						if (($_POST[$TypeGrid09] <= 50) and ($_POST[$TypeGrid15] == "CHK")) {
							$_POST[$TypeGrid13] = ($_POST[$TypeGrid08] / 100 * ($txt_percentage + 1)) / ($txt_vat + 100) * 100;
						} else {
							if ($_POST[$TypeGrid09] <= $_POST[$TypeGrid10]) {
								$_POST[$TypeGrid13] = ($_POST[$TypeGrid08] / 100 * $txt_percentage) / ($txt_vat + 100) * 100;
							} else {
								$_POST[$TypeGrid13] = 0;
							}
						}
					} else {
						if ($_POST[$TypeGrid09] <= $_POST[$TypeGrid10]) {
							$_POST[$TypeGrid13] = ($_POST[$TypeGrid08] / 100 * ($txt_percentage + 1)) / ($txt_vat + 100) * 100;
						} else {
							$_POST[$TypeGrid13] = 0;
						}
					}
				} else {
					if ($m75 > 0) {
						$_POST[$TypeGrid13] = -1 * ($_POST[$TypeGrid03] / 100 * $txt_percentage) / ($txt_vat + 100) * 100;
					} else {
						$_POST[$TypeGrid13] = -1 * ($_POST[$TypeGrid03] / 100 * ($txt_percentage + 1)) / ($txt_vat + 100) * 100;
					}
				}
				$ii = $ii + 1;
			}
		} else {
			while ($ii < $TypeGrid1_count) {

				$TypeGrid03 = "TypeGrid_" . $ii . "_03";
				$TypeGrid08 = "TypeGrid_" . $ii . "_08";
				$TypeGrid09 = "TypeGrid_" . $ii . "_09";
				$TypeGrid10 = "TypeGrid_" . $ii . "_10";
				$TypeGrid14 = "TypeGrid_" . $ii . "_14";

				if ($_POST[$TypeGrid14] == "INV") {
					if ($_POST[$TypeGrid09] <= $_POST[$TypeGrid10]) {
						$_POST[$TypeGrid13] = ($_POST[$TypeGrid08] / 100 * $txt_percentage) / ($txt_vat + 100) * 100;
					} else {
						$_POST[$TypeGrid13] = 0;
					}
				} else {
					$_POST[$TypeGrid13] = -1 * ($_POST[$TypeGrid03] / 100 * $txt_percentage) / ($txt_vat + 100) * 100;
				}
				$ii = $ii + 1;
			}
		}
	}

	//Call cmd_cal_Click--------------------------------------------------------

	$txttot1 = 0;
	$txttot1 = $txttot1;
	$tinc = 0;
	$ii = 1;
	while ($ii < $TypeGrid1_count) {

		$TypeGrid03 = "TypeGrid_" . $ii . "_03";
		$TypeGrid08 = "TypeGrid_" . $ii . "_08";
		$TypeGrid09 = "TypeGrid_" . $ii . "_09";
		$TypeGrid10 = "TypeGrid_" . $ii . "_10";
		$TypeGrid14 = "TypeGrid_" . $ii . "_14";

		if ($_POST[$TypeGrid14] == "INV") {
			if ($_POST[$TypeGrid09] <= $_POST[$TypeGrid10]) {

				$txttot1 = $txttot1 + $_POST[$TypeGrid08];
			} else {

				$txttot1 = $txttot1;
			}

		}
		if ($_POST[$TypeGrid13] != "") { $tinc = ($tinc + $_POST[$TypeGrid13]);
		}
		$ii = $ii + 1;
	}

	$txt_tot = $txttot1;
	$txttotal = (($txt_tot - $_POST["txt_grn"]) / ($_POST["txt_vat"] + 100) * 100);
	$txttot_inc = $tinc;
	$txtnetin = $txttot_inc - $_POST["txtint"];

	$ii = 1;
	$aa = $TypeGrid1_count;
	while ($ii < $aa) {

		$TypeGrid00 = "TypeGrid_" . $ii . "_00";
		$TypeGrid03 = "TypeGrid_" . $ii . "_03";
		$TypeGrid08 = "TypeGrid_" . $ii . "_08";
		$TypeGrid09 = "TypeGrid_" . $ii . "_09";
		$TypeGrid10 = "TypeGrid_" . $ii . "_10";
		$TypeGrid13 = "TypeGrid_" . $ii . "_13";
		$TypeGrid14 = "TypeGrid_" . $ii . "_14";

		$mdays = $_POST[$TypeGrid10];
		$MAMO = str_replace(",", "", $_POST[$TypeGrid13]);
		$M_id = $_POST[$TypeGrid00];
		$sql = "uPDATE  s_sttr set deliin_days=" . $mdays . ", deliin_amo=" . $MAMO . " WHERE ID=" . $M_id;
		// echo $sql;
		$result = mysqli_query($GLOBALS['dbinv'], $sql);

		$ii = $ii + 1;
	}

	$txt_cusname = str_replace("~", "&", $_POST["txt_cusname"]);
	$txtnetin = str_replace(",", "", $_POST["txtnetin"]);
	$txtint = str_replace(",", "", $_POST["txtint"]);

	if ($_POST["txt_chno"] == "") {
		$chno = 0;
	} else {
		$chno = $_POST["txt_chno"];
	}

	$sql_rs_ins = "Select * from ins_payment where cusCode='" . trim($_POST["txt_cuscode"]) . "' and I_month ='" . intval(date("m", strtotime($_POST["DTPicker1"]))) . "' and I_year='" . date("Y", strtotime($_POST["DTPicker1"])) . "' and Type = '" . trim($_POST["cmbtype"]) . "'";
	echo $sql_rs_ins;
	$result_rs_ins = mysqli_query($GLOBALS['dbinv'], $sql_rs_ins);
	if ($row_rs_ins = mysqli_fetch_array($result_rs_ins)) {

		if ((trim($row_rs_ins["chno"]) == "0") or (trim($row_rs_ins["chno"]) == "X")) {
			//$sql_ins = "delete  from ins_payment where cusCode='" . trim($_POST["txt_cuscode"]) . "' and I_month ='" . intval(date("m", strtotime($_POST["DTPicker1"]))) . "' and I_year='" . date("Y", strtotime($_POST["DTPicker1"])) . "' and Type = '" . trim($_POST["cmbtype"]) . "'";
			$sql_ins = "delete  from ins_payment where cusCode='" . trim($_POST["txt_cuscode"]) . "' and I_month ='" . intval(date("m", strtotime($_POST["DTPicker1"]))) . "' and I_year='" . date("Y", strtotime($_POST["DTPicker1"])) . "' and Type = '" . trim($_POST["cmbtype"]) . "'";
			$result_ins = mysqli_query($GLOBALS['dbinv'], $sql_ins);

			$mtxtPrepare = $_POST["txtPrepare"];
			$mtxtauth = $_POST["txtauth"];

			$sql_para = "select * from invpara";
			$result_para = mysqli_query($GLOBALS['dbinv'], $sql_para);
			$row_para = mysqli_fetch_array($result_para);

			$remark = trim($_POST["txtremark"]) . " " . trim($_POST["txtremark_new"]);
			if ($_POST["chq_ignore"] == "true") { $chno = "X";
			}

			$sql_ins_insert = "insert into ins_payment(Cuscode, CUSNAME, I_month, I_year, SDATE, remarks, pr_by, auth_by, amount, Interest,  Percentage, indate, REFNO, Type, chno) values('" . $_POST["txt_cuscode"] . "', '" . $txt_cusname . "', '" . intval(date("m", strtotime($_POST["DTPicker1"]))) . "', '" . date("Y", strtotime($_POST["DTPicker1"])) . "', '" . date("Y-m-d") . "', '" . $remark . "', '" . $mtxtPrepare . "', '" . $_SESSION["CURRENT_USER"] . "', '" . $txtnetin . "', '" . $txtint . "', '" . $_POST["txt_percentage"] . "', '" . $_POST["DTPicker1"] . "', '" . $row_para["delinno"] . "', '" . $_POST["cmbtype"] . "', '" . $chno . "')";
			echo $sql_ins_insert . "-1";
			$result_ins_insert = mysqli_query($GLOBALS['dbinv'], $sql_ins_insert);

			$sql_inv = "update invpara set delinno=delinno+1";
			$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

			echo "Saved";
		} else {
			exit("This Insentive payment Already Saved");

		}
	} else {
		// $sql_ins = "delete  from ins_payment where cusCode='" . trim($_POST["txt_cuscode"]) . "' and I_month ='" . intval(date("m", strtotime($_POST["DTPicker1"]))) . "' and I_year='" . date("Y", strtotime($_POST["DTPicker1"])) . "' and Type = '" . trim($_POST["cmbtype"]) . "'";

		// $sql_ins = "delete  from ins_payment where cusCode='" . trim($_POST["txt_cuscode"]) . "' and I_month ='" . intval(date("m", strtotime($_POST["DTPicker1"]))) . "' and I_year='" . date("Y", strtotime($_POST["DTPicker1"])) . "' ";

		$result_ins = mysqli_query($GLOBALS['dbinv'], $sql_ins);

		$mtxtPrepare = $_POST["txtPrepare"];
		$mtxtauth = $_POST["txtauth"];

		$sql_para = "select * from invpara";
		$result_para = mysqli_query($GLOBALS['dbinv'], $sql_para);
		$row_para = mysqli_fetch_array($result_para);

		$remark = trim($_POST["txtremark"]) . " " . trim($_POST["txtremark_new"]);
		if ($_POST["chq_ignore"] == "true") { $chno = "X";
		}

		$sql_ins_insert = "insert into ins_payment(Cuscode, CUSNAME, I_month, I_year, SDATE, remarks, pr_by, auth_by, amount, Interest,  Percentage, indate, REFNO, Type, chno) values('" . $_POST["txt_cuscode"] . "', '" . $txt_cusname . "', '" . intval(date("m", strtotime($_POST["DTPicker1"]))) . "', '" . date("Y", strtotime($_POST["DTPicker1"])) . "', '" . date("Y-m-d") . "', '" . $remark . "', '" . $mtxtPrepare . "', '" . $_SESSION["CURRENT_USER"] . "', '" . $txtnetin . "', '" . $txtint . "', '" . $_POST["txt_percentage"] . "', '" . $_POST["DTPicker1"] . "', '" . $row_para["delinno"] . "', '" . $_POST["cmbtype"] . "', '" . $chno . "')";
		echo $sql_ins_insert . "-2";
		$result_ins_insert = mysqli_query($GLOBALS['dbinv'], $sql_ins_insert);

		$sql_inv = "update invpara set delinno=delinno+1";
		$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

		echo "Saved";

	}

}

if ($_GET["Command"] == "lock_data") {
	include ('connectioni.php');

	$ii = 1;
	while ($ii < $_GET["mcount"]) {

		$cell_name_00 = "TypeGrid_" . $ii . "_00";

		$sql = "uPDATE s_sttr set deliin_lock='1' WHERE id=" . $_GET[$cell_name_00];
		echo $sql;
		$result = mysqli_query($GLOBALS['dbinv'], $sql);

		$ii = $ii + 1;
	}

	echo "Locked";
}

if ($_POST["Command"] == "calculate_ins") {

	include ('connectioni.php');


	$txt_vat =11;
	$txttot1 = 0;
	$i = 1;
	$TypeGrid1_count = $_POST["mcount"];

	while ($i < $TypeGrid1_count) {

		$TypeGrid08 = "TypeGrid_" . $i . "_08";
		$TypeGrid09 = "TypeGrid_" . $i . "_09";
		$TypeGrid10 = "TypeGrid_" . $i . "_10";
		$TypeGrid14 = "TypeGrid_" . $i . "_14";

		if ($_POST[$TypeGrid09] <= 50) {
			$M50 = $M50 + 1;
		} else {
			if ($_POST[$TypeGrid09] <= $_POST[$TypeGrid10]) {
				$m75 = $m75 + 1;
			}
		}
		if ($_POST[$TypeGrid14] == "INV") {
			if ($_POST[$TypeGrid09] <= $_POST[$TypeGrid10]) {
				$txttot1 = $txttot1 + str_replace(",","",$_POST[$TypeGrid08]);
			} else {
				$txttot1 = $txttot1;
			}
		}
		$i = $i + 1;
	}
	
	 
	
	if (date("Y", strtotime($_POST["DTPicker1"])) >= 2014) {
		if (trim($_POST["cmbtype"]) == "Tyre") {
			$sql_rsper = "Select * from intper where incen_year = 2014 and traget < '" . (($txttot1 - $txt_grn) / ($txt_vat + 100) * 100) . "' order by traget desc ";
		}
	} else {
		if (trim($_POST["cmbtype"]) == "Tyre") {
			$sql_rsper = "Select * from intper where incen_year = 20101 and traget < '" . (($txttot1 - $txt_grn) / ($txt_vat + 100) * 100) . "' order by traget desc ";
		}
	}
	if (trim($_POST["cmbtype"]) == "Battery") {
		$sql_rsper = "Select * from intper where incen_year = 20111 and traget < '" . (($txttot1 - $txt_grn) / ($txt_vat + 100) * 100) . "' order by traget desc ";
	}
	if (trim($_POST["cmbtype"]) == "Atlas") {
		$sql_rsper = "Select * from intper where incen_year = 2015 and traget < '" . ($txttot1 - $txt_grn) / ($txt_vat + 100) * 100 . "' order by traget desc ";
	}
	$result_rsper = mysqli_query($GLOBALS['dbinv'], $sql_rsper);
	if ($row_rsper = mysqli_fetch_array($result_rsper)) {
		$txt_percentage = $row_rsper["per"];
		$ii = 1;
		$diff = abs(strtotime($ddate) - strtotime($_GET["DTPicker1"]));
		$days = floor($diff / (60 * 60 * 24));
		
		
		
		if (($days > 0) and (trim($_POST["cmbtype"]) == "Tyre")) {
					
				
			$ii=1;
			while ($ii < $TypeGrid1_count) {
					
				
				$TypeGrid13="TypeGrid_".$ii."_13";
				
				
				$TypeGrid03 = "TypeGrid_" . $ii . "_03";
				$TypeGrid08 = "TypeGrid_" . $ii . "_08";
				$TypeGrid09 = "TypeGrid_" . $ii . "_09";
				$TypeGrid10 = "TypeGrid_" . $ii . "_10";
				$TypeGrid14 = "TypeGrid_" . $ii . "_14";

				if ($_POST[$TypeGrid14] == "INV") {
					if ($m75 > 0) {
						if (($_POST[$TypeGrid09] <= 50) and ($_POST[$TypeGrid15] == "CHK")) {
							$TypeGrid[$ii][13] = (str_replace(",","",$_POST[$TypeGrid08]) / 100 * ($txt_percentage + 1)) / ($txt_vat + 100) * 100;
						} else {
							if ($_POST[$TypeGrid09] <= $_POST[$TypeGrid10]) {
								$TypeGrid[$ii][13] = ( str_replace(",","",$_POST[$TypeGrid08])/ 100 * $txt_percentage) / ($txt_vat + 100) * 100;
							} else {
								$TypeGrid[$ii][13] = 0;
							}
						}
					} else {
						if ($_POST[$TypeGrid09] <= $_POST[$TypeGrid10]) {
							$TypeGrid[$ii][13] = ( str_replace(",","",$_POST[$TypeGrid08]) / 100 * ($txt_percentage + 1)) / ($txt_vat + 100) * 100;
						} else {
							$TypeGrid[$ii][13] = 0;
						}
					}
				} else {
					if ($m75 > 0) {
						$TypeGrid[$ii][13] = -1 * ($_POST[$TypeGrid03] / 100 * $txt_percentage) / ($txt_vat + 100) * 100;
					} else {
						$TypeGrid[$ii][13] = -1 * ($_POST[$TypeGrid03] / 100 * ($txt_percentage + 1)) / ($txt_vat + 100) * 100;
					}
				}
				$ii = $ii + 1;
			}
		} else {
				$ii=1;
			while ($ii < $TypeGrid1_count) {

				$TypeGrid13="TypeGrid_".$ii."_13";

				$TypeGrid03 = "TypeGrid_" . $ii . "_03";
				$TypeGrid08 = "TypeGrid_" . $ii . "_08";
				$TypeGrid09 = "TypeGrid_" . $ii . "_09";
				$TypeGrid10 = "TypeGrid_" . $ii . "_10";
				$TypeGrid14 = "TypeGrid_" . $ii . "_14";

				if ($_POST[$TypeGrid14] == "INV") {
					if ($_POST[$TypeGrid09] <= $_POST[$TypeGrid10]) {
						$TypeGrid[$ii][13] = ( str_replace(",","",$_POST[$TypeGrid08]) / 100 * $txt_percentage) / ($txt_vat + 100) * 100;
					} else {
						$TypeGrid[$ii][13] = 0;
					}
				} else {
					$TypeGrid[$ii][13] = -1 * ($_POST[$TypeGrid03] / 100 * $txt_percentage) / ($txt_vat + 100) * 100;
				}
				$ii = $ii + 1;
			}
		}
	}
	////////////////////////////////////////////////
	//Call cmd_cal_Click--------------------------------------------------------

	$txttot1 = 0;
	$txttot1 = $txttot1;
	$tinc = 0;
	$ii = 1;
	while ($ii < $TypeGrid1_count) {
		
		$TypeGrid13="TypeGrid_".$ii."_13";
		$TypeGrid03 = "TypeGrid_" . $ii . "_03";
		$TypeGrid08 = "TypeGrid_" . $ii . "_08";
		$TypeGrid09 = "TypeGrid_" . $ii . "_09";
		$TypeGrid10 = "TypeGrid_" . $ii . "_10";
		$TypeGrid14 = "TypeGrid_" . $ii . "_14";

		if ($_POST[$TypeGrid14] == "INV") {
			if ($_POST[$TypeGrid09] <= $_POST[$TypeGrid10]) {

				$txttot1 = $txttot1 +  str_replace(",","",$_POST[$TypeGrid08]);
			} else {

				$txttot1 = $txttot1;
			}
		}
		if ($TypeGrid[$ii][13] != "") {
			 $tinc = ($tinc + $TypeGrid[$ii][13]);
		}
		$ii = $ii + 1;
	}

	$txt_tot = $txttot1;
	$txttotal = (($txt_tot - $_POST["txt_grn"]) / ($_POST["txt_vat"] + 100) * 100);
	$txttot_inc = $tinc;
	$txtnetin = $txttot_inc - $_POST["txtint"];

	////////////////////////////////////////////////////////

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	$ii = 1;
	while ($ii < $TypeGrid1_count) {
		$TypeGrid13 = "TypeGrid_" . $ii . "_13";

		$ResponseXML .= "<" . $TypeGrid13 . "><![CDATA[" . number_format($TypeGrid[$ii][13], 2, ".", ",") . "]]></" . $TypeGrid13 . ">";
		$ii = $ii + 1;
	}

	$ResponseXML .= "<txt_tot><![CDATA[" . number_format($txt_tot, 2, ".", ",") . "]]></txt_tot>";
	$ResponseXML .= "<txttotal><![CDATA[" . number_format($txttotal, 2, ".", ",") . "]]></txttotal>";
	$ResponseXML .= "<txttot_inc><![CDATA[" . number_format($txttot_inc, 2, ".", ",") . "]]></txttot_inc>";
	$ResponseXML .= "<txtnetin><![CDATA[" . number_format($txtnetin, 2, ".", ",") . "]]></txtnetin>";
	$ResponseXML .= "<txt_percentage><![CDATA[" . number_format($txt_percentage, 2, ".", ",") . "]]></txt_percentage>";
	$ResponseXML .= "<TypeGrid1_count><![CDATA[" . $TypeGrid1_count . "]]></TypeGrid1_count>";
	$ResponseXML .= "</salesdetails>";
	echo $ResponseXML;
}

if ($_GET["Command"] == "advance_proces") {

	$msgrid = array();

	$madjust = $_GET["TXTADJ"];

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	$sql_rs = "select * from sal_comm where sal_ex='" . trim($_GET["cmbrep"]) . "'";
	//echo $sql_rs;
	$result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
	if ($row_rs = mysqli_fetch_array($result_rs)) {

		$txtt1 = $row_rs["T1"];
		$txtt2 = $row_rs["T2"];
	}

	$ResponseXML .= "<txtt1><![CDATA[" . number_format($txtt1, 2, ".", ",") . "]]></txtt1>";
	$ResponseXML .= "<txtt2><![CDATA[" . number_format($txtt2, 2, ".", ",") . "]]></txtt2>";

	$txtnett = 0;
	$txtsales = 0;
	$txtrtn = 0;
	$txtcrn = 0;
	$txtretcheq = 0;
	$txtover60 = 0;
	$TXTADJ = $madjust;

	//.....................................................................................................................................
	$mrep = trim($_GET["cmbrep"]);

	$mdev = trim($_GET["cmbdev"]);

	$year = substr($_GET["dtMonth"], 0, 4);
	$month = substr($_GET["dtMonth"], 5, 2);

	$sql_rs = "Select  sum(GRAND_TOT) as sales from s_salma where Accname != 'NON STOCK' and  CANCELL='0' and SAL_EX='" . $mrep . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "'   ";
	$result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
	if ($row_rs = mysqli_fetch_array($result_rs)) {
		if (is_null($row_rs["sales"]) == false) { $txtsales = $row_rs["sales"];
		}
	}

	$ResponseXML .= "<txtsales><![CDATA[" . number_format($txtsales, 2, ".", ",") . "]]></txtsales>";

	$sql_rs = "Select  sum(AMOUNT) as salesret from c_bal  where  CANCELL='0' and trn_type='CNT' and SAL_EX='" . $mrep . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "' and flag1='0'   ";
	$result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
	if ($row_rs = mysqli_fetch_array($result_rs)) {
		if (is_null($row_rs["salesret"]) == false) { $txtcrn = $row_rs["salesret"];
		}
	}

	$ResponseXML .= "<txtcrn><![CDATA[" . number_format($txtcrn, 2, ".", ",") . "]]></txtcrn>";

	$sql_rs = "Select  sum(AMOUNT) as salesret from c_bal  where CANCELL='0' and trn_type='GRN' and SAL_EX='" . $mrep . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "' and flag1='0'  ";
	$result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
	if ($row_rs = mysqli_fetch_array($result_rs)) {
		if (is_null($row_rs["salesret"]) == false) { $txtrtn = $row_rs["salesret"];
		}
	}
	$ResponseXML .= "<txtrtn><![CDATA[" . number_format($txtrtn, 2, ".", ",") . "]]></txtrtn>";

	$txtnett = ($txtsales - ($txtcrn + $txtrtn)) / 1.12;
	$ResponseXML .= "<txtnett><![CDATA[" . number_format($txtnett, 2, ".", ",") . "]]></txtnett>";

	$mrefno = $month . "/" . $year . "-" . substr($_GET["cmbrep"], 0, 2) . "-" . $_GET["cmbdev"];

	$sql_rs_old = "Select * from s_commadva where refno = '" . $mrefno . "' and FLAG='ADV'";

	$result_rs_old = mysqli_query($GLOBALS['dbinv'], $sql_rs_old);
	if ($row_rs_old = mysqli_fetch_array($result_rs_old)) {

		if (is_null($row_rs_old["ADJ"]) == false) { $TXTADJ = $row_rs_old["ADJ"];
		}
		if (is_null($row_rs_old["Dedcap1"]) == false) { $txtded1 = $row_rs_old["Dedcap1"];
		}
		if (is_null($row_rs_old["Dedcap2"] == false)) { $txtded2 = $row_rs_old["Dedcap2"];
		}
		if (is_null($row_rs_old["Dedcap3"]) == false) { $txtded3 = $row_rs_old["Dedcap3"];
		}
		if (is_null($row_rs_old["Dedcap4"]) == false) { $txtded4 = $row_rs_old["Dedcap4"];
		}
		if (is_null($row_rs_old["Dedcap5"]) == false) { $txtded5 = $row_rs_old["Dedcap5"];
		}
		if (is_null($row_rs_old["Dedcap6"] == false)) { $txtded6 = $row_rs_old["Dedcap6"];
		}
		if (is_null($row_rs_old["Dedcap7"]) == false) { $txtded7 = $row_rs_old["Dedcap7"];
		}
		if (is_null($row_rs_old["Dedcap8"]) == false) { $txtded8 = $row_rs_old["Dedcap8"];
		}
		if (is_null($row_rs_old["Dedamount1"]) == false) { $txtdedamou1 = $row_rs_old["Dedamount1"];
		}
		if (is_null($row_rs_old["Dedamount2"]) == false) { $txtdedamou2 = $row_rs_old["Dedamount2"];
		}
		if (is_null($row_rs_old["Dedamount3"]) == false) { $txtdedamou3 = $row_rs_old["Dedamount3"];
		}
		if (is_null($row_rs_old["Dedamount4"]) == false) { $txtdedamou4 = $row_rs_old["Dedamount4"];
		}
		if (is_null($row_rs_old["Dedamount5"]) == false) { $txtdedamou5 = $row_rs_old["Dedamount5"];
		}
		if (is_null($row_rs_old["Dedamount6"]) == false) { $txtdedamou6 = $row_rs_old["Dedamount6"];
		}
		if (is_null($row_rs_old["Dedamount7"]) == false) { $txtdedamou7 = $row_rs_old["Dedamount7"];
		}
		if (is_null($row_rs_old["Dedamount8"]) == false) { $txtdedamou8 = $row_rs_old["Dedamount8"];
		}
		if (is_null($row_rs_old["remark"]) == false) { $txtdedremark = $row_rs_old["remark"];
		}
		if ($row_rs_old["Lock1"] == 1) {
			if (is_null($row_rs_old["Returnchk"]) == false) { $txtretcheq = $row_rs_old["Returnchk"];
			}
			if (is_null($row_rs_old["Over60out"]) == false) { $txtover60 = $row_rs_old["Over60out"];
			}
		}
		if (is_null($row_rs_old["remark"]) == false) { $txtdedremark = trim($row_rs_old["remark"]);
		}
		if ($row_rs_old["chno"] > 0) { $txtdedremark = trim($txtdedremark) . "-" . trim($row_rs_old["chno"]) . "-" . trim($row_rs_old["Bank"]) . "-" . trim($row_rs_old["PCHNO"]);
		}
	}

	$ResponseXML .= "<TXTADJ><![CDATA[" . number_format($TXTADJ, 2, ".", ",") . "]]></TXTADJ>";
	$ResponseXML .= "<txtded1><![CDATA[" . $txtded1 . "]]></txtded1>";
	$ResponseXML .= "<txtded2><![CDATA[" . $txtded2 . "]]></txtded2>";
	$ResponseXML .= "<txtded3><![CDATA[" . $txtded3 . "]]></txtded3>";
	$ResponseXML .= "<txtded4><![CDATA[" . $txtded4 . "]]></txtded4>";
	$ResponseXML .= "<txtded5><![CDATA[" . $txtded5 . "]]></txtded5>";
	$ResponseXML .= "<txtded6><![CDATA[" . $txtded6 . "]]></txtded6>";
	$ResponseXML .= "<txtded7><![CDATA[" . $txtded7 . "]]></txtded7>";
	$ResponseXML .= "<txtded8><![CDATA[" . $txtded8 . "]]></txtded8>";
	$ResponseXML .= "<txtdedamou1><![CDATA[" . number_format($txtdedamou1, 2, ".", ",") . "]]></txtdedamou1>";
	$ResponseXML .= "<txtdedamou2><![CDATA[" . number_format($txtdedamou2, 2, ".", ",") . "]]></txtdedamou2>";
	$ResponseXML .= "<txtdedamou3><![CDATA[" . number_format($txtdedamou3, 2, ".", ",") . "]]></txtdedamou3>";
	$ResponseXML .= "<txtdedamou4><![CDATA[" . number_format($txtdedamou4, 2, ".", ",") . "]]></txtdedamou4>";
	$ResponseXML .= "<txtdedamou5><![CDATA[" . number_format($txtdedamou5, 2, ".", ",") . "]]></txtdedamou5>";
	$ResponseXML .= "<txtdedamou6><![CDATA[" . number_format($txtdedamou6, 2, ".", ",") . "]]></txtdedamou6>";
	$ResponseXML .= "<txtdedamou7><![CDATA[" . number_format($txtdedamou7, 2, ".", ",") . "]]></txtdedamou7>";
	$ResponseXML .= "<txtdedamou8><![CDATA[" . number_format($txtdedamou8, 2, ".", ",") . "]]></txtdedamou8>";

	$ResponseXML .= "<txtdedremark><![CDATA[" . number_format($txtdedremark, 2, ".", ",") . "]]></txtdedremark>";

	if ($txtretcheq <= 0) {
		$mretche = 0;

		$sql_rs_salm = "Select  sum(CR_CHEVAL-PAID) as retche  from  s_cheq  where S_REF='" . $mrep . "' and CR_FLAG = '0' ";
		$result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
		$row_rs_salm = mysqli_fetch_array($result_rs_salm);
		if (is_null($row_rs_salm["retche"]) == false) {
			$mretche = $row_rs_salm["retche"];
			$txtretcheq = $txtretcheq + $row_rs_salm["retche"];
		}
		$txtretcheq = $txtretcheq;

	}

	$ResponseXML .= "<txtretcheq><![CDATA[" . number_format($txtretcheq, 2, ".", ",") . "]]></txtretcheq>";

	if ($txtover60 <= 0) {
		$mout = 0;
		$sql_rs_salm = "Select  * from s_salma where Accname != 'NON STOCK' and  CANCELL='0' and  GRAND_TOT > TOTPAY and SAL_EX='" . $mrep . "'  ";
		$result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
		while ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {

			$date1 = date("Y-m-d");
			$date2 = $row_rs_salm["SDATE"];

			$diff = abs(strtotime($date2) - strtotime($date1));
			$days = floor($diff / (60 * 60 * 24));

			if ($days >= 61) {
				$mout = $mout + $row_rs_salm["GRAND_TOT"] - $row_rs_salm["TOTPAY"];

				$txtover60 = $mout;
			}

		}

	}

	$ResponseXML .= "<txtover60><![CDATA[" . number_format($txtover60, 2, ".", ",") . "]]></txtover60>";

	$netSale = $txtsales - $txtrtn - $txtcrn;

	if ($txtnett != "") {
		if ($txtnett != 0) { $TXTRATO = ($txtover60 + $TXTADJ + $txtretcheq) / ($txtnett * 1.12) * 100;
		}
	}

	$netSale = (($txtsales - $txtrtn - $txtcrn) / 112) * 100;

	//msgrid.clear

	//.....................................................................................................................................
	$ai = 1;
	$mcom = 0;

	$sql_rs_salm = "Select Brand , sum(GRAND_TOT) as sales from s_salma where Accname != 'NON STOCK' and CANCELL='0' and DEV='" . $mdev . "' and SAL_EX='" . $mrep . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "'  group by Brand  ";
	$result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
	while ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {

		if ($mdev == "1") {
			$msale = $row_rs_salm["sales"];
		} else {
			$msale = ((($row_rs_salm["sales"] / 112) * 100));
		}

		$sql_rs_table = "SELECT *   from com_she where sal_ex='" . $mrep . "' and Brand='" . trim($row_rs_salm["Brand"]) . "'  ";
		$result_rs_table = mysqli_query($GLOBALS['dbinv'], $sql_rs_table);
		if ($row_rs_table = mysqli_fetch_array($result_rs_table)) {

			if ($TXTRATO <= 15) {
				if ($netSale >= $txtt2) {
					$mcom = $mcom + $msale * $row_rs_table["T3_cat1"];
				}
				if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
					$mcom = $mcom + $msale * $row_rs_table["T2_Cat1"];
				}
				if ($netSale < $txtt1) {
					$mcom = $mcom + $msale * $row_rs_table["T1_Cat1"];
				}
			} else {
				if ($netSale >= $txtt2) {
					$mcom = $mcom + $msale * $row_rs_table["T3_cat2"];
				}
				if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
					$mcom = $mcom + $msale * $row_rs_table["T2_cat2"];
				}
				if ($netSale < $txtt1) {
					$mcom = $mcom + $msale * $row_rs_table["T1_cat2"];
				}
			}
		} else {
			$mcom = $mcom + 0;
		}

		$msgrid[$ai][1] = $row_rs_salm["Brand"];
		$msgrid[$ai][2] = $msale;
		$ai = $ai + 1;
	}

	$row_count = $ai;
	//.... CNT ......................................................................................................................................

	$sql_rs_salm = "Select  brand, sum(AMOUNT) as salesret from c_bal  where CANCELL='0' and  trn_type='CNT' and SAL_EX='" . $mrep . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "' and flag1='0' and DEV='" . $mdev . "' group by brand  ";

	$result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
	while ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {

		if ($mdev == "1") {
			$msale = $row_rs_salm["salesret"];
		} else {
			$msale = ((($row_rs_salm["salesret"] / 112) * 100));
		}

		$sql_rs_table = "SELECT *   from com_she where   sal_ex='" . $mrep . "' AND Brand='" . trim($row_rs_salm["brand"]) . "' ";
		$result_rs_table = mysqli_query($GLOBALS['dbinv'], $sql_rs_table);
		if ($row_rs_table = mysqli_fetch_array($result_rs_table)) {

			if ($TXTRATO <= 15) {
				if ($netSale >= $txtt2) {
					$mcom = $mcom - $msale * $row_rs_table["T3_cat1"];
				}
				if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
					$mcom = $mcom - $msale * $row_rs_table["T2_Cat1"];
				}
				if ($netSale < $txtt1) {
					$mcom = $mcom - $msale * $row_rs_table["T1_Cat1"];
				}
			} else {
				if ($netSale >= $txtt2) {
					$mcom = $mcom - $msale * $row_rs_table["T3_cat2"];
				}
				if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
					$mcom = $mcom - $msale * $row_rs_table["T2_cat2"];
				}
				if ($netSale < $txtt1) {
					$mcom = $mcom - $msale * $row_rs_table["T1_cat2"];
				}
			}
		} else {
			$mcom = $mcom - $msale * 1.5;
		}

		$mstat = "NEW";
		$xx = 1;
		while ($xx < $row_count) {
			if (trim($msgrid[$xx][1]) == trim($row_rs_salm["brand"])) {

				$msgrid[$xx][1] = $row_rs_salm["brand"];
				$msgrid[$xx][3] = $msale * -1;
				$xx = $row_count;
				$mstat = "OLD";
			}
			$xx = $xx + 1;
		}
		if ($mstat == "NEW") {

			$msgrid[$ai][1] = $row_rs_salm["brand"];
			$msgrid[$ai][3] = $msale * -1;
		}
		$ai = $ai + 1;
	}
	//.... GRN ......................................................................................................................................

	$sql_rs_salm = "Select  brand, sum(AMOUNT) as salesret from c_bal  where DEV='" . $mdev . "' and trn_type='GRN' and SAL_EX='" . $mrep . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "'  group by brand  ";
	$result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
	while ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {

		if ($mdev == "1") {
			$msale = $row_rs_salm["salesret"];
		} else {
			$msale = ((($row_rs_salm["salesret"] / 112) * 100));
		}

		$sql_rs_table = "SELECT *   from com_she where sal_ex='" . $mrep . "' AND Brand='" . trim($row_rs_salm["brand"]) . "' ";
		$result_rs_table = mysqli_query($GLOBALS['dbinv'], $sql_rs_table);
		if ($row_rs_table = mysqli_fetch_array($result_rs_table)) {

			if ($TXTRATO <= 15) {
				if ($netSale >= $txtt2) {
					$mcom = $mcom - $msale * $row_rs_table["T3_cat1"];
				}
				if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
					$mcom = $mcom - $msale * $row_rs_table["T2_Cat1"];
				}
				if ($netSale < $txtt1) {
					$mcom = $mcom - $msale * $row_rs_table["T1_Cat1"];
				}
			} else {
				if ($netSale >= $txtt2) {
					$mcom = $mcom - $msale * $row_rs_table["T3_cat2"];
				}
				if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
					$mcom = $mcom - $msale * $row_rs_table["T2_cat2"];
				}
				if ($netSale < $txtt1) {
					$mcom = $mcom - $msale * $row_rs_table["T1_cat2"];
				}
			}
		} else {
			$mcom = $mcom - $msale * 1.5;
		}

		$mstat = "NEW";
		$xx = 1;
		while ($xx < $row_count) {
			if (trim($msgrid[$xx][1]) == trim($row_rs_salm["brand"])) {
				$msgrid[$xx][1] = $row_rs_salm["brand"];
				$msgrid[$xx][4] = $msale * -1;
				$xx = $row_count;
				$mstat = "OLD";
			}
			$xx = $xx + 1;
		}
		if ($mstat == "NEW") {

			$msgrid[$ai][1] = $row_rs_salm["brand"];
			$msgrid[$ai][4] = $msale * -1;
		}
		$ai = $ai + 1;

	}
	$TXTCOM = $mcom;

	$Txtadva = 0;
	$mtotcom = 0;
	$mtotded = 0;
	$mded = 0;
	$mretioded = 0;
	$mroundadvance = 0;
	$mdecimal = 0;

	$ai = 1;
	while ($ai < $row_count) {

		$sql_rs_table = "SELECT *   from com_she where   sal_ex='" . $mrep . "' AND Brand='" . trim($msgrid[$ai][1]) . "' ";

		$msale = $msgrid[$ai][2] + $msgrid[$ai][3] + $msgrid[$ai][4];
		$msgrid[$ai][5] = $msale;

		$result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
		if ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {
			if ($TXTRATO <= 15) {
				if ($netSale >= $txtt2) {
					$mcom = $msale * $row_rs_table["T3_cat1"];
					$txtper = $row_rs_table["T3_cat1"];
				}
				if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
					$mcom = $msale * $row_rs_table["T2_Cat1"];
					$txtper = $row_rs_table["T2_Cat1"];
				}
				if ($netSale < $txtt1) {
					$mcom = $msale * $row_rs_table["T1_Cat1"];
					$txtper = $row_rs_table["T1_Cat1"];
				}
			} else {
				if ($netSale >= $txtt2) {
					$mcom = $msale * $row_rs_table["T3_cat2"];
					$txtper = $row_rs_table["T3_cat2"];
				}
				if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
					$mcom = $msale * $row_rs_table["T2_cat2"];
					$txtper = $row_rs_table["T2_cat2"];
				}
				if ($netSale < $txtt1) {
					$mcom = $msale * $row_rs_table["T1_cat2"];
					$txtper = $row_rs_table["T1_cat2"];
				}
			}
		} else {
			$mcom = $msale * 1.5;
		}
		$msgrid[$ai][6] = $mcom / 100;
		$mtotcom = $mtotcom + (($mcom / 100) / 2);

		$ai = $ai + 1;
	}

	$mded = $txtdedamou1 + $txtdedamou2 + $txtdedamou3 + $txtdedamou4 + $txtdedamou5 + $txtdedamou6 + $txtdedamou7 + $txtdedamou8;

	if ($TXTRATO > 15) {
		$mretioded = ($mtotcom * $TXTRATO) / 100;
		$mtotded = $mretioded + $mded;
		$mroundadvance = $mtotcom - $mretioded;
		$mroundadvance = $mroundadvance / 1000;
		$mroundadvance = number_format($mroundadvance, 0, ".", "");
		if ($mroundadvance != "") {
			$mroundadvance = $mroundadvance * 1000;
		} else {
			$mroundadvance = 0;
		}

		$txtadvance = $mtotcom - $mretioded;
		if ($mroundadvance > ($mtotcom - $mretioded)) {
			$mroundadvance = $mroundadvance - 1000;
			$txtad = $mroundadvance;
		} else {
			$txtad = $mroundadvance;
		}
		$txtded = $mded;
		$txtretioded = $mretioded;
		$Txtadva = $mroundadvance - $mded;
	} else {
		$mretioded = 0;
		$mtotded = $mretioded + $mtded;
		$mroundadvance = $mtotcom - $mretioded;
		$mroundadvance = $mroundadvance / 1000;
		$mroundadvance = number_format($mroundadvance, 0, ".", "");
		if ($mroundadvance != "") {
			$mroundadvance = $mroundadvance * 1000;
		} else {
			$mroundadvance = 0;
		}
		$txtadvance = $mtotcom - $mretioded;
		if ($mroundadvance > ($mtotcom - $mretioded)) {
			$mroundadvance = $mroundadvance - 1000;
			$txtad = $mroundadvance;
		} else {
			$txtad = $mroundadvance;
		}
		$txtad = $mroundadvance;
		$txtded = $mded;
		$txtretioded = $mretioded;
		$Txtadva = $mroundadvance - $mded;
	}

	/*msgrid.TextMatrix(0, 1) = "Brand"
	 msgrid.TextMatrix(0, 2) = "Sales"
	 msgrid.TextMatrix(0, 3) = "CRN"
	 msgrid.TextMatrix(0, 4) = "GRN"
	 msgrid.TextMatrix(0, 5) = "Net"
	 msgrid.TextMatrix(0, 6) = "Comm"*/

	$ResponseXML .= "<TXTRATO><![CDATA[" . number_format($TXTRATO, 2, ".", ",") . "]]></TXTRATO>";
	$ResponseXML .= "<TXTADJ><![CDATA[" . number_format($TXTADJ, 2, ".", ",") . "]]></TXTADJ>";
	$ResponseXML .= "<txtadvance><![CDATA[" . number_format($txtadvance, 2, ".", ",") . "]]></txtadvance>";
	$ResponseXML .= "<TXTCOM><![CDATA[" . number_format($TXTCOM, 2, ".", ",") . "]]></TXTCOM>";
	$ResponseXML .= "<txtad><![CDATA[" . number_format($txtad, 2, ".", ",") . "]]></txtad>";
	$ResponseXML .= "<txtded><![CDATA[" . number_format($txtded, 2, ".", ",") . "]]></txtded>";
	$ResponseXML .= "<txtretioded><![CDATA[" . number_format($txtretioded, 2, ".", ",") . "]]></txtretioded>";
	$ResponseXML .= "<Txtadva><![CDATA[" . number_format($Txtadva, 2, ".", ",") . "]]></Txtadva>";
	$ResponseXML .= "<txtper><![CDATA[" . number_format($txtper, 2, ".", ",") . "]]></txtper>";

	$ResponseXML .= "<msgrid><![CDATA[ <table   border=1  cellspacing=0>
								<tr><td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Brand</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Sales</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">GRN</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Net</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Comm</font></td>
						</tr>";

	$i = 1;
	while ($row_count > $i) {

		$msgrid1 = "msgrid1_" . $i;
		$msgrid2 = "msgrid2_" . $i;
		$msgrid3 = "msgrid3_" . $i;
		$msgrid4 = "msgrid4_" . $i;
		$msgrid5 = "msgrid5_" . $i;
		$msgrid6 = "msgrid6_" . $i;

		$ResponseXML .= "<tr><td><div id=" . $msgrid1 . ">" . $msgrid[$i][1] . "</div></td>
						<td align=\"right\"><div id=" . $msgrid2 . ">" . number_format($msgrid[$i][2], 2, ".", ",") . "</div></td>
						<td align=\"right\"><div id=" . $msgrid3 . ">" . number_format($msgrid[$i][3], 2, ".", ",") . "</div></td>
						<td align=\"right\"><div id=" . $msgrid4 . ">" . number_format($msgrid[$i][4], 2, ".", ",") . "</div></td>
						<td align=\"right\"><div id=" . $msgrid5 . ">" . number_format($msgrid[$i][5], 2, ".", ",") . "</div></td>
						<td align=\"right\"><div id=" . $msgrid6 . ">" . number_format($msgrid[$i][6], 2, ".", ",") . "</div></td>
						</tr>";
		$i = $i + 1;
	}

	$ResponseXML .= "   </table>]]></msgrid>";

	$ResponseXML .= "<mgridcount><![CDATA[" . $row_count . "]]></mgridcount>";

	$ResponseXML .= " </salesdetails>";
	echo $ResponseXML;

}

if ($_GET["Command"] == "settlement") {

	$sql = "SELECT * FROM c_bal";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {

		$sql1 = "Select sum(C_PAYMENT) as paid  from s_ut where CRE_NO_NO='" . $row['REFNO'] . "'";
		$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
		if ($row1 = mysqli_fetch_array($result1)) {
			if (is_null($row1["paid"])) { $mpaid = $row1["paid"];
			}

			$sql2 = "update c_bal set totpay ='" . $mpaid . "' where REF_NO='" . $row["REF_NO"] . "'";
			$result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
		}
	}
}

if ($_GET["Command"] == "proces") {

	include ('connectioni.php');

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	if (date("Y", strtotime($_GET["DTPicker1"])) < 2015) {
		$txt_vat = 12;
	} else {
		$txt_vat = 11;
	}
	if (date("Y", strtotime($_GET["DTPicker1"])) >2015) {
		$txt_vat = 8;
	}

	$over_incen = 0;
	$chq_ignore = 0;

	$sql_rssslma = "select * from s_salma where  month(sdate)='" . date("m", strtotime($_GET["DTPicker1"])) . "' and  year(sdate)='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and c_CODE = '" . $_GET["txt_cuscode"] . "' and cancell='0' and totpay1 = '1'";
	$result_rssslma = mysqli_query($GLOBALS['dbinv'], $sql_rssslma);

	$txt_percentage = 0;

	$txttot = 0;
	$totincen = 0;
	$totout = 0;
	$tot_sale = 0;
	$tot_grn = 0;
	$txttot_inc = "";
	$ii = 1;
	 
	while ($row_rssslma = mysqli_fetch_array($result_rssslma)) {

		$sql_rsbrand_mas = "select * from brand_mas where barnd_name = '" . trim($row_rssslma["Brand"]) . "'";
		$result_rsbrand_mas = mysqli_query($GLOBALS['dbinv'], $sql_rsbrand_mas);
		$row_rsbrand_mas =mysqli_fetch_array($result_rsbrand_mas);
		$sql_rsVENDOR = "select * from vendor where code = '" . $row_rssslma["C_CODE"] . "'";
		$result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_rsVENDOR);
		$row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR);

		if ($_GET["cmbtype"] == "Tyre") {
			
			if (date("Y", strtotime($_GET["DTPicker1"])) >= 2014) {
				if ((date("Y", strtotime($_GET["DTPicker1"])) == 2014) and (date("m", strtotime($_GET["DTPicker1"])) <= 4)) {
					if ($row_rsbrand_mas["b60"] == 1) {
						$tot_sale = $tot_sale + $row_rssslma["grand_tot"];
						// Me.TypeGrid1.Rows = ii + 1
						$TypeGrid1[$ii][1] = $row_rssslma["REF_NO"];
						if (is_null($row_rssslma["deli_date"]) == false) {
							$TypeGrid1[$ii][2] = $row_rssslma["deli_date"];
							$mdate = $row_rssslma["deli_date"];
						} else {
							$TypeGrid1[$ii][2] = $row_rssslma["SDATE"];
							$mdate = $row_rssslma["SDATE"];
						}
						$TypeGrid1[$ii][3] = $row_rssslma["GRAND_TOT"];
						$TypeGrid1[$ii][4] = $rssslma["TOTPAY"];
						$TypeGrid1[$ii][5] = $row_rssslma["Brand"];

						if ($row_rssslma["grand_tot"] > $row_rssslma["GRAND_TOT"]) {
							$totout = $totout + ($row_rssslma["GRAND_TOT"] - $row_rssslma["TOTPAY"]);
						} else {
							$totout = $totout + 0;
						}

						$sql_rssttr = "select * from s_sttr where ST_INVONO = '" . trim($row_rssslma["REF_NO"]) . "'";
						$result_rssttr = mysqli_query($GLOBALS['dbinv'], $sql_rssttr);
						while ($row_rssttr = mysqli_fetch_array($result_rssttr)) {
							 
							
							$TypeGrid1[$ii][0] = $row_rssttr["ID"];

							$TypeGrid1[$ii][6] = $row_rssttr["ST_REFNO"];
							$TypeGrid1[$ii][7] = $row_rssttr["ST_DATE"];
							if ((is_null($row_rssttr["st_chdate"]) == false) and (($row_rssttr["st_chdate"]) != "0000-00-00")) {
								//echo $row_rssttr["ST_CHDATE"];
								$TypeGrid1[$ii][7] = $row_rssttr["st_chdate"];
								$diff = abs(strtotime($row_rssttr["st_chdate"]) - strtotime($mdate));
								$days = floor($diff / (60 * 60 * 24));
								$TypeGrid1[$ii][9] = $days;
							} else {
								$TypeGrid1[$ii][7] = $row_rssttr["ST_DATE"];
								$diff = abs(strtotime($row_rssttr["ST_DATE"]) - strtotime($mdate));
								$days = floor($diff / (60 * 60 * 24));
								$TypeGrid1[$ii][9] = $days;
							}

							$diff = abs(strtotime($ddate) - strtotime($_GET["DTPicker1"]));
							$days = floor($diff / (60 * 60 * 24));
							if ($days > 0) {
								if ($row_rsVENDOR["incdays"] == 90) {
									if ($row_rssslma["cre_pe"] > 90) {
										$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
									} else {
										if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
										}
									}
								} else {
									if ($row_rssslma["cre_pe"] != 65) {
										$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
									} else {
										$TypeGrid1[$ii][10] = 75;
									}
								}
							} else {
								if ($row_rsVENDOR["incdays"] == 90) {
									if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
									}
								} else {
									if ($row_rssslma["cre_pe"] != 65) {
										$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
									} else {
										if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
										}
									}
								}
							}
							$TypeGrid1[$ii][8] = number_format($row_rssttr["ST_PAID"], 2, ".", ",");

							if ($row_rssttr["deliin_amo"] > 0) {
								if (is_null($row_rssttr["deliin_days"]) == false) { $TypeGrid1[$ii][10] = $row_rssttr["deliin_days"];
								}
							}

							if (is_null($row_rssttr["deliin_amo"]) == false) {
								$TypeGrid1[$ii][12] = $row_rssttr["deliin_amo"];
								$TypeGrid1[$ii][13] = $row_rssttr["deliin_amo"];
								$txttot_inc = $txttot_inc + $row_rssttr["deliin_amo"];
							}
							if ($row_rssttr["deliin_lock"] == "1") {
								$TypeGrid1[$ii][11] = "YES";
							} else {
								$TypeGrid1[$ii][11] = "NO";
							}
							$TypeGrid1[$ii][14] = "INV";
							$TypeGrid1[$ii][15] = $row_rssttr["ST_FLAG"];

							if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {
								$txttot = $txttot + $row_rssttr["ST_PAID"];
							} else {
								$txttot = $txttot + 0;
							}
							$totincen = $totincen + $TypeGrid1[$ii][12];

							$ii = $ii + 1;
						}
						/*If Not rssttr.EOF Then
						 ii = ii + 1
						 End If
						 rssttr.Close*/
					}
				} else {
					if ($row_rsbrand_mas["d60to75"] == 1) {
						$tot_sale = $tot_sale + $row_rssslma["GRAND_TOT"];
						//Me.TypeGrid1.Rows = ii + 1
						$TypeGrid1[$ii][1] = $row_rssslma["REF_NO"];
						if (is_null($row_rssslma["deli_date"]) == false) {
							$TypeGrid1[$ii][2] = $row_rssslma["deli_date"];
							$mdate = $row_rssslma["deli_date"];
						} else {
							$TypeGrid1[$ii][2] = $row_rssslma["SDATE"];
							$mdate = $row_rssslma["SDATE"];
						}
						$TypeGrid1[$ii][3] = $row_rssslma["GRAND_TOT"];
						$TypeGrid1[$ii][4] = $row_rssslma["TOTPAY"];
						$TypeGrid1[$ii][5] = $row_rssslma["Brand"];

						if ($row_rssslma["GRAND_TOT"] > $row_rssslma["TOTPAY"]) {
							$totout = $totout + ($row_rssslma["GRAND_TOT"] - $row_rssslma["TOTPAY"]);
						} else {
							$totout = totout + 0;
						}

						$sql_rssttr = "select * from s_sttr where ST_INVONO = '" . trim($row_rssslma["REF_NO"]) . "'";
						$result_rssttr = mysqli_query($GLOBALS['dbinv'], $sql_rssttr);
						while ($row_rssttr = mysqli_fetch_array($result_rssttr)) {

							//Me.TypeGrid1.Rows = ii + 1
							$TypeGrid1[$ii][0] = $row_rssttr["ID"];

							$TypeGrid1[$ii][6] = $row_rssttr["ST_REFNO"];
							$TypeGrid1[$ii][7] = $row_rssttr["ST_DATE"];
							if ((is_null($row_rssttr["st_chdate"]) == false) or ($row_rssttr["st_chdate"] !="0000-00-00") ) {
								$TypeGrid1[$ii][7] = $row_rssttr["st_chdate"];
								$diff = abs(strtotime($row_rssttr["st_chdate"]) - strtotime($mdate));
								$days = floor($diff / (60 * 60 * 24));
								$TypeGrid1[$ii][9] = $days;
							} else {
								$TypeGrid1[$ii][7] = $row_rssttr["ST_DATE"];
								$diff = abs(strtotime($row_rssttr["ST_DATE"]) - strtotime($mdate));
								$days = floor($diff / (60 * 60 * 24));
								$TypeGrid1[$ii][9] = $days;
							}
							$ddate ="2011-07-31";
							$diff = abs(strtotime($ddate) - strtotime($_GET["DTPicker1"]));
							$days = floor($diff / (60 * 60 * 24));
							if ($days > 0) {
								if ($row_rsVENDOR["incdays"] == 90) {
									if ($row_rssslma["cre_pe"] > 90) {
										$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
									} else {
										if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
										}
									}
								} else {
									if ($row_rssslma["cre_pe"] != 65) {
										$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
									} else {
										$TypeGrid1[$ii][10] = 75;
									}
								}
							} else {
								if ($row_rsVENDOR["incdays"] == 90) {
									if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
									}
								} else {
									if ($row_rssslma["cre_pe"] != 65) {
										$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
									} else {
										if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
										}
									}
								}
							}
							$TypeGrid1[$ii][8] = number_format($row_rssttr["ST_PAID"], 2, ".", ",");

							if ($row_rssttr["deliin_amo"] > 0) {
								if (is_null($row_rssttr["deliin_days"]) == false) { $TypeGrid1[$ii][10] = $row_rssttr["deliin_days"];
								}
							}

							if (is_null($row_rssttr["deliin_amo"]) == false) {
								$TypeGrid1[$ii][12] = $row_rssttr["deliin_amo"];
								$TypeGrid1[$ii][13] = $row_rssttr["deliin_amo"];
								$txttot_inc = $txttot_inc + $row_rssttr["deliin_amo"];
							}
							if ($row_rssttr["deliin_lock"] == "1") {
								$TypeGrid1[$ii][11] = "YES";
							} else {
								$TypeGrid1[$ii][11] = "NO";
							}
							$TypeGrid1[$ii][14] = "INV";
							$TypeGrid1[$ii][15] = $row_rssttr["ST_FLAG"];

							if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {
								$txttot = $txttot + $row_rssttr["ST_PAID"];
							} else {
								$txttot = $txttot + 0;
							}
							$totincen = $totincen + $TypeGrid1[$ii][12];

							$ii = $ii + 1;
						}
						/*if Not rssttr.EOF Then
						 ii = ii + 1
						 End If
						 rssttr.Close*/
					}
				}
			} else {
				if ((date("m", strtotime($_GET["DTPicker1"])) < 11) and (date("Y", strtotime($_GET["DTPicker1"])) <= 2010)) {
					if ($row_rsbrand_mas = mysqli_fetch_array($result_rsbrand_mas)) {
						if (($row_rsbrand_mas["delinrate"] == 2.5) and ($row_rsbrand_mas["barnd_name"] == "ROADSTONE") or ($row_rsbrand_mas["barnd_name"] == "ROADSTONE CHINA")) {
							if ($row_rsbrand_mas["delinrate"] >= 0) {
								//Me.TypeGrid1.Rows = ii + 1
								$TypeGrid1[$ii][1] = $row_rssslma["REF_NO"];
								if (is_null($row_rssslma["deli_date"]) == false) {
									$TypeGrid1[$ii][2] = $row_rssslma["deli_date"];
									$mdate = $row_rssslma["deli_date"];
								} else {
									$TypeGrid1[$ii][2] = $row_rssslma["SDATE"];
									$mdate = $row_rssslma["SDATE"];
								}
								$TypeGrid1[$ii][3] = $row_rssslma["GRAND_TOT"];
								$TypeGrid1[$ii][4] = $row_rssslma["totpay"];
								$TypeGrid1[$ii][5] = $row_rssslma["brand"];

								if ($row_rssslma["GRAND_TOT"] > $row_rssslma["TOTPAY"]) {
									$totout = $totout + ($row_rssslma["GRAND_TOT"] - $row_rssslma["TOTPAY"]);
								} else {
									$totout = $totout + 0;
								}

								$sql_rssttr = "select * from s_sttr where ST_INVONO = '" . trim($row_rssslma["REF_NO"]) . "'";
								$result_rssttr = mysqli_query($GLOBALS['dbinv'], $sql_rssttr);
								while ($row_rssttr = mysqli_fetch_array($result_rssttr)) {
									//Me.TypeGrid1.Rows = ii + 1
									$TypeGrid1[$ii][0] = $row_rssttr["ID"];

									$TypeGrid1[$ii][6] = $row_rssttr["ST_REFNO"];
									$TypeGrid1[$ii][7] = $row_rssttr["ST_DATE"];
									if ((is_null($row_rssttr["ST_CHDATE"]) == false) and ($row_rssttr["ST_CHDATE"] !="0000-00-00") ) {
										$TypeGrid1[$ii][7] = $row_rssttr["ST_CHDATE"];
										$diff = abs(strtotime($row_rssttr["ST_CHDATE"]) - strtotime($mdate));
										$days = floor($diff / (60 * 60 * 24));
										$TypeGrid1[$ii][9] = $days;
									} else {
										$TypeGrid1[$ii][7] = $row_rssttr["ST_DATE"];

										$diff = abs(strtotime($row_rssttr["ST_DATE"]) - strtotime($mdate));
										$days = floor($diff / (60 * 60 * 24));
										$TypeGrid1[$ii][9] = $days;

									}

									if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
									}
									$TypeGrid1[$ii][8] = $row_rssttr["ST_PAID"];

									if ($row_rssttr["deliin_amo"] > 0) {
										if (is_null($row_rssttr["deliin_days"]) == false) { $TypeGrid1[$ii][10] = $row_rssttr["deliin_days"];
										}
									}

									if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {
										$TypeGrid1[$ii][12] = $row_rssttr["ST_PAID"] / 100 * $txt_percentage / ($txt_vat + 100) * 100;

									} else {
										$TypeGrid1[$ii][12] = 0;
									}

									if (is_null($row_rssttr["deliin_amo"]) == false) {
										$TypeGrid1[$ii][13] = $row_rssttr["deliin_amo"];
										$txttot_inc = $_GET["txttot_inc"] + $row_rssttr["deliin_amo"];
									}

									if ($row_rssttr["deliin_lock"] == "1") {
										$TypeGrid1[$ii][11] = "YES";
									} else {
										$TypeGrid1[$ii][11] = "NO";
									}
									$TypeGrid1[$ii][14] = "INV";

									if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {
										$txttot = $txttot + $row_rssttr["ST_PAID"];
									} else {
										$txttot = $txttot + 0;
									}
									$totincen = $totincen + $TypeGrid1[$ii][12];

									$ii = $ii + 1;

								}

								//$ii = $ii + 1;

							}
						}
					}
				} else {
					if ($row_rsbrand_mas = mysqli_fetch_array($result_rsbrand_mas)) {
						if ($row_rsbrand_mas["delinrate"] == 2.5) {
							if ($row_rsbrand_mas["delinrate"] >= 0) {
								$tot_sale = $tot_sale + $row_rssslma["GRAND_TOT"];
								//Me.TypeGrid1.Rows = ii + 1
								$TypeGrid1[$ii][1] = $row_rssslma["REF_NO"];
								if (is_null($row_rssslma["deli_date"]) == false) {
									$TypeGrid1[$ii][2] = $row_rssslma["deli_date"];
									$mdate = $row_rssslma["deli_date"];
								} else {
									$TypeGrid1[$ii][2] = $row_rssslma["SDATE"];
									$mdate = $row_rssslma["SDATE"];
								}
								$TypeGrid1[$ii][3] = $row_rssslma["GRAND_TOT"];
								$TypeGrid1[$ii][4] = $row_rssslma["totpay"];
								$TypeGrid1[$ii][5] = $row_rssslma["brand"];

								if ($row_rssslma["GRAND_TOT"] > $row_rssslma["totpay"]) {
									$totout = $totout + ($row_rssslma["GRAND_TOT"] - $row_rssslma["totpay"]);
								} else {
									$totout = $totout + 0;
								}

								$sql_rssttr = "select * from s_sttr where ST_INVONO = '" . trim($row_rssslma["REF_NO"]) . "'";
								$result_rssttr = mysqli_query($GLOBALS['dbinv'], $sql_rssttr);
								while ($row_rssttr = mysqli_fetch_array($result_rssttr)) {

									// Me.TypeGrid1.Rows = ii + 1
									$TypeGrid1[$ii][0] = $row_rssttr["ID"];
									$TypeGrid1[$ii][6] = $row_rssttr["ST_REFNO"];
									$TypeGrid1[$ii][7] = $row_rssttr["ST_DATE"];
									if ((is_null($row_rssttr["ST_CHDATE"]) == false) and ($row_rssttr["ST_CHDATE"] !="0000-00-00")) {
										$TypeGrid1[$ii][7] = $row_rssttr["ST_CHDATE"];
										$diff = abs(strtotime($row_rssttr["ST_CHDATE"]) - strtotime($mdate));
										$days = floor($diff / (60 * 60 * 24));
										$TypeGrid1[$ii][9] = $days;
									} else {
										$TypeGrid1[$ii][7] = $row_rssttr["ST_DATE"];
										$diff = abs(strtotime($row_rssttr["ST_DATE"]) - strtotime($mdate));
										$days = floor($diff / (60 * 60 * 24));
										$TypeGrid1[$ii][9] = $days;
									}

									$diff = abs(strtotime($ddate) - strtotime($_GET["DTPicker1"]));
									$days = floor($diff / (60 * 60 * 24));

									if ($days > 0) {
										if ($row_rsVENDOR["incdays"] == 90) {
											if ($row_rssslma["cre_pe"] > 90) {
												$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
											} else {
												if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
												}
											}
										} else {
											if ($row_rssslma["cre_pe"] != 65) {
												$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
											} else {
												$TypeGrid1[$ii][10] = 75;
											}
										}
									} else {
										if ($row_rsVENDOR["incdays"] == 90) {
											if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
											}
										} else {
											if ($row_rssslma["cre_pe"] != 65) {
												$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
											} else {
												if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
												}
											}
										}
									}
									$TypeGrid1[$ii][8] = $row_rssttr["ST_PAID"];

									if ($row_rssttr["deliin_amo"] > 0) {
										if (is_null($row_rssttr["deliin_days"]) == false) { $TypeGrid1[$ii][10] = $row_rssttr["deliin_days"];
										}
									}

									if (is_null($row_rssttr["deliin_amo"]) == false) {
										$TypeGrid1[$ii][12] = $row_rssttr["deliin_amo"];
										$TypeGrid1[$ii][13] = $row_rssttr["deliin_amo"];
										$txttot_inc = $txttot_inc + $row_rssttr["deliin_amo"];
									}
									if ($row_rssttr["deliin_lock"] == "1") {
										$TypeGrid1[$ii][11] = "YES";
									} else {
										$TypeGrid1[$ii][11] = "NO";
									}
									$TypeGrid1[$ii][14] = "INV";
									$TypeGrid1[$ii][15] = $row_rssttr["ST_FLAG"];

									if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {
										$txttot = $txttot + $row_rssttr["ST_PAID"];
									} else {
										$txttot = $txttot + 0;
									}
									$totincen = $totincen + $TypeGrid1[$ii][12];

									$ii = $ii + 1;
								}

								if ($row_rssttr = mysqli_fetch_array($result_rssttr)) {
									$ii = $ii + 1;
								}

							}
						}
					}

				}
			}
		} else {
				
			if ($_GET["cmbtype"] == "Battery") {
				if ((date("m", strtotime($_GET["DTPicker1"])) >= 1) and (date("Y", strtotime($_GET["DTPicker1"])) > 2010)) {
					if ($row_rsbrand_mas = mysqli_fetch_array($result_rsbrand_mas)) {
						if ($row_rsbrand_mas["delinrate"] == 3.5) {
							if ($row_rsbrand_mas["delinrate"] >= 0) {
								$tot_sale = $tot_sale + $row_rssslma["grand_tot"];
								//Me.TypeGrid1.Rows = ii + 1
								$TypeGrid1[$ii][1] = $row_rssslma["REF_NO"];
								if (is_null($row_rssslma["DELI_DATE"]) == false) {
									$TypeGrid1[$ii][2] = $row_rssslma["DELI_DATE"];
									$mdate = $row_rssslma["DELI_DATE"];
								} else {
									$TypeGrid1[$ii][2] = $row_rssslma["SDATE"];
									$mdate = $row_rssslma["SDATE"];
								}
								$TypeGrid1[$ii][3] = $row_rssslma["grand_tot"];
								$TypeGrid1[$ii][4] = $row_rssslma["totpay"];
								$TypeGrid1[$ii][5] = $row_rssslma["brand"];

								if ($row_rssslma["grand_tot"] > $row_rssslma["totpay"]) {
									$totout = $totout + ($row_rssslma["grand_tot"] - $row_rssslma["totpay"]);
								} else {
									$totout = $totout + 0;
								}

								$sql_rssttr = "select * from s_sttr where ST_INVONO = '" . trim($row_rssslma["REF_NO"]) . "'";
								$result_rssttr = mysqli_query($GLOBALS['dbinv'], $sql_rssttr);
								while ($row_rssttr = mysqli_fetch_array($result_rssttr)) {

									// Me.TypeGrid1.Rows = ii + 1
									$TypeGrid1[$ii][0] = $row_rssttr["ID"];

									$TypeGrid1[$ii][6] = $row_rssttr["ST_REFNO"];
									$TypeGrid1[$ii][7] = $row_rssttr["ST_DATE"];
									if ((is_null($row_rssttr["ST_CHDATE"]) == false) or ($row_rssttr["ST_CHDATE"]!="0000-00-00")) {
										$TypeGrid1[$ii][7] = $row_rssttr["ST_CHDATE"];
										$diff = abs(strtotime($row_rssttr["ST_CHDATE"]) - strtotime($mdate));
										$days = floor($diff / (60 * 60 * 24));
										$TypeGrid1[$ii][9] = $days;
									} else {
										$TypeGrid1[$ii][7] = $row_rssttr["ST_DATE"];
										$diff = abs(strtotime($row_rssttr["ST_DATE"]) - strtotime($mdate));
										$days = floor($diff / (60 * 60 * 24));
										$TypeGrid1[$ii][9] = $days;
									}

									$diff = abs(strtotime($ddate) - strtotime($_GET["DTPicker1"]));
									$days = floor($diff / (60 * 60 * 24));
									if ($days > 0) {
										if ($row_rsVENDOR["incdays"] == 90) {
											if ($row_rssslma["cre_pe"] > 90) {
												$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
											} else {
												if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
												}
											}
										} else {
											if ($row_rssslma["cre_pe"] != 65) {
												$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
											} else {
												$TypeGrid1[$ii][10] = 75;
											}
										}
									} else {
										if ($row_rsVENDOR["incdays"] == 90) {
											if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
											}
										} else {
											if ($row_rssslma["cre_pe"] != 65) {
												$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
											} else {
												if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
												}
											}
										}
									}
									$TypeGrid1[$ii][8] = number_format($row_rssttr["ST_PAID"], 2, ".", ",");

									if ($row_rssttr["deliin_amo"] > 0) {
										if (is_null($row_rssttr["deliin_days"]) == false) { $TypeGrid1[$ii][10] = $row_rssttr["deliin_days"];
										}
									}
									if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {
										$TypeGrid1[$ii][12] = ($row_rssttr["ST_PAID"] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;

									} else {
										$TypeGrid1[$ii][12] = 0;
									}
									if (is_null($row_rssttr["deliin_amo"]) == false) {
										$TypeGrid1[$ii][13] = $rssttr["deliin_amo"];
										$txttot_inc = $txttot_inc + $row_rssttr["deliin_amo"];
									}
									if ($row_rssttr["deliin_lock"] == "1") {
										$TypeGrid1[$ii][11] = "YES";
									} else {
										$TypeGrid1[$ii][11] = "NO";
									}
									$TypeGrid1[$ii][14] = "INV";
									if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {
										$txttot = $txttot + $row_rssttr["ST_PAID"];
									} else {
										$txttot = $txttot + 0;
									}
									$totincen = $totincen + $TypeGrid1[$ii][12];
									//rssttr.MoveNext
									$ii = $ii + 1;
								}
								//rssttr.Close
							}
						}
					}
				}
			} else {
				if ($row_rsbrand_mas["d60to75"] == 3) {

					$TypeGrid1[$ii][1] = $row_rssslma["REF_NO"];
					if (is_null($row_rssslma["DELI_DATE"]) == false) {
						$TypeGrid1[$ii][2] = $row_rssslma["DELI_DATE"];
						$mdate = $row_rssslma["DELI_DATE"];
					} else {
						$TypeGrid1[$ii][2] = $row_rssslma["SDATE"];
						$mdate = $row_rssslma["SDATE"];
					}
					$TypeGrid1[$ii][3] = $row_rssslma["grand_tot"];
					$TypeGrid1[$ii][4] = $row_rssslma["totpay"];
					$TypeGrid1[$ii][5] = $row_rssslma["brand"];

					if ($row_rssslma["grand_tot"] > $row_rssslma["totpay"]) {
						$totout = $totout + ($row_rssslma["grand_tot"] - $row_rssslma["totpay"]);
					} else {
						$totout = $totout + 0;
					}

					$sql_rssttr = "select * from s_sttr where ST_INVONO = '" . trim($row_rssslma["REF_NO"]) . "'";
					$result_rssttr = mysqli_query($GLOBALS['dbinv'], $sql_rssttr);
					while ($row_rssttr = mysqli_fetch_array($result_rssttr)) {

						//Me.TypeGrid1.Rows = ii + 1
						$TypeGrid1[$ii][0] = $row_rssttr["ID"];

						$TypeGrid1[$ii][6] = $row_rssttr["ST_REFNO"];
						$TypeGrid1[$ii][7] = $row_rssttr["ST_DATE"];
						if ((is_null($row_rssttr["ST_CHDATE"]) == false) and ($row_rssttr["ST_CHDATE"] != "0000-00-00") ) {
							$TypeGrid1[$ii][7] = $row_rssttr["ST_CHDATE"];
							$diff = abs(strtotime($row_rssttr["ST_CHDATE"]) - strtotime($mdate));
							$days = floor($diff / (60 * 60 * 24));
							$TypeGrid1[$ii][9] = $days;
						} else {
							$TypeGrid1[$ii][7] = $row_rssttr["ST_DATE"];
							$diff = abs(strtotime($row_rssttr["ST_DATE"]) - strtotime($mdate));
							$days = floor($diff / (60 * 60 * 24));
							$TypeGrid1[$ii][9] = $days;
						}

						$diff = abs(strtotime($ddate) - strtotime($_GET["DTPicker1"]));
						$days = floor($diff / (60 * 60 * 24));

						if ($days > 0) {
							if ($row_rsVENDOR["incdays"] == 90) {
								if ($row_rssslma["cre_pe"] > 90) {
									$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
								} else {
									if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
									}
								}
							} else {
								if ($row_rssslma["cre_pe"] != 65) {
									$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
								} else {
									$TypeGrid1[$ii][10] = 75;
								}
							}
						} else {
							if ($row_rsVENDOR["incdays"] == 90) {
								if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
								}
							} else {
								if ($row_rssslma["cre_pe"] != 65) {
									$TypeGrid1[$ii][10] = $row_rssslma["cre_pe"];
								} else {
									if (is_null($row_rsVENDOR["incdays"]) == false) { $TypeGrid1[$ii][10] = $row_rsVENDOR["incdays"];
									}
								}
							}
						}
						$TypeGrid1[$ii][8] = number_format($row_rssttr["ST_PAID"], 2, ".", ",");

						if ($row_rssttr["deliin_amo"] > 0) {
							if (is_null($row_rssttr["deliin_days"]) == false) { $TypeGrid1[$ii][10] = $row_rssttr["deliin_days"];
							}
						}
						if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {
							$TypeGrid1[$ii][12] = ($row_rssttr["ST_PAID"] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;

						} else {
							$TypeGrid1[$ii][12] = 0;
						}
						if (is_null($row_rssttr["deliin_amo"]) == false) {
							$TypeGrid1[$ii][13] = $row_rssttr["deliin_amo"];
							$txttot_inc = $txttot_inc + $row_rssttr["deliin_amo"];
						}
						if ($row_rssttr["deliin_lock"] == "1") {
							$TypeGrid1[$ii][11] = "YES";
						} else {
							$TypeGrid1[$ii][11] = "NO";
						}
						$TypeGrid1[$ii][14] = "INV";
						if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {
							$txttot = $txttot + $row_rssttr["ST_PAID"];
						} else {
							$txttot = $txttot + 0;
						}
						$totincen = $totincen + $TypeGrid1[$ii][12];
						//rssttr.MoveNext
						$ii = $ii + 1;
					}
					//rssttr.Close
				}
			}

		}
	}

	$txt_tot = $txttot;

	$txt_out = $totout;

	$txtremark = "";
	$txtint = "";
	$txtnetin = "";
	$remark = "";
	$xx=0;
	$xx = date("m", strtotime($_GET["DTPicker1"]));

	$sql_rsIncen = "select * from ins_payment where  I_month ='" . date("m", strtotime($_GET["DTPicker1"])) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($_GET["txt_cuscode"]) . "'  order by id";
	$result_rsIncen = mysqli_query($GLOBALS['dbinv'], $sql_rsIncen);
	$row_count = mysqli_num_rows($result_rsIncen);
	while ($row_rsIncen = mysqli_fetch_array($result_rsIncen)) {

		if (is_null($row_rsIncen["Type"]) == false) {
			if (trim($row_rsIncen["Type"]) == trim($_GET["cmbtype"])) {

				if (is_null($row_rsIncen["remarks"]) == false) { $txtremark = $row_rsIncen["remarks"];
				}
				if (is_null($row_rsIncen["remarks"]) == false) { $remark = $row_rsIncen["remarks"];
				}
				if (is_null($row_rsIncen["remarks"]) == false) { $mremark = trim($row_rsIncen["remarks"]);
				}
				if (is_null($row_rsIncen["Interest"]) == false) { $txtint = $row_rsIncen["Interest"];
				}
				if (is_null($row_rsIncen["Percentage"]) == false) { $txt_percentage = $row_rsIncen["Percentage"];
				}
				if (is_null($row_rsIncen["AMOUNT"]) == false) { $txtnetin = $row_rsIncen["AMOUNT"];
				}
				if (is_null($row_rsIncen["chno"]) == false) { $txt_chno = $row_rsIncen["chno"];
				}
				if (trim($row_rsIncen["chno"]) == "X") { $chq_ignore = 1;
				}

			} else {

				$row_rsIncen = mysqli_fetch_assoc($result_rsIncen);
			}
		} else {

			if (is_null($row_rsIncen["remarks"]) == false) { $txtremark = $row_rsIncen["remarks"];
			}
			if (is_null($row_rsIncen["remarks"]) == false) { $remark = $row_rsIncen["remarks"];
			}
			if (is_null($row_rsIncen["remarks"]) == false) { $mremark = trim($row_rsIncen["remarks"]);
			}
			if (is_null($row_rsIncen["Interest"]) == false) { $txtint = $row_rsIncen["Interest"];
			}
			if (is_null($row_rsIncen["Percentage"]) == false) { $txt_percentage = $row_rsIncen["Percentage"];
			}
			if (is_null($row_rsIncen["AMOUNT"]) == false) { $txtnetin = $row_rsIncen["AMOUNT"];
			}
			if (is_null($row_rsIncen["chno"]) == false) { $txt_chno = $row_rsIncen["chno"];
			}
			if ($row_rsIncen["chno"] == "X") { $chq_ignore = 1;
			}
			$row_rsIncen = mysqli_fetch_assoc($result_rsIncen);
		}
	}

	$totgrn = 0;
	$tgrnince = 0;

	$sql_RScbal = "select * from c_bal where month(SDATE)='" . date("m", strtotime($_GET["DTPicker1"])) . "' and  year(SDATE)='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and CANCELL='0'and CUSCODE='" . trim($_GET["txt_cuscode"]) . "' AND trn_type != 'ARN' and trn_type != 'REC' and trn_type != 'DGRN' and flag1 != '1' order by SDATE";
	$result_RScbal = mysqli_query($GLOBALS['dbinv'], $sql_RScbal);
	while ($row_RScbal = mysqli_fetch_array($result_RScbal)) {

		$sql_rs_grn = "Select INVOICENO from s_crnma where REF_NO = '" . trim($row_RScbal["REFNO"]) . "'";
		$result_rs_grn = mysqli_query($GLOBALS['dbinv'], $sql_rs_grn);
		if ($row_rs_grn = mysqli_fetch_array($result_rs_grn)) {

			if ($row_rs_grn["INVOICENO"] != "") {
				$sql_rssslma = "Select TOTPAY1 from s_salma where REF_NO = '" . $row_rs_grn["INVOICENO"] . "'";
				$result_rssslma = mysqli_query($GLOBALS['dbinv'], $sql_rssslma);
				$row_rssslma = mysqli_fetch_array($result_rssslma);

				if ($row_rssslma["TOTPAY1"] == "1") {
					$sql_rsbrand_mas = "select * from brand_mas where barnd_name = '" . trim($row_RScbal["brand"]) . "'";
					$result_rsbrand_mas = mysqli_query($GLOBALS['dbinv'], $sql_rsbrand_mas);
					//$row_rsbrand_mas= mysqli_fetch_array($result_rsbrand_mas);

					if ($_GET["cmbtype"] == "Tyre") {
						if ((date("m", strtotime($_GET["DTPicker1"])) < 11) and (date("Y", strtotime($_GET["DTPicker1"])) <= 2010)) {

							if ($row_rsbrand_mas = mysqli_fetch_array($result_rsbrand_mas)) {
								if (($row_rsbrand_mas["delinrate"] == 2.5) and ($row_rsbrand_mas["barnd_name"] == "ROADSTONE") or ($row_rsbrand_mas["barnd_name"] == "ROADSTONE CHINA")) {
									if ($row_rsbrand_mas["delinrate"] >= 0) {
										//Me.TypeGrid1.Rows = ii + 1

										$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
										$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
										$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
										$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
										$TypeGrid1[$ii][5] = $row_RScbal["brand"];
										$TypeGrid1[$ii][12] = -($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
										$TypeGrid1[$ii][13] = -($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
										$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
										$totgrn = $totgrn + $row_RScbal["AMOUNT"];
										$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
										$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
										$ii = $ii + 1;
									}
								}
							}
						} else {
							if (date("Y", strtotime($_GET["DTPicker1"])) >= 2014) {
								if ((date("Y", strtotime($_GET["DTPicker1"])) == 2014) and (date("m", strtotime($_GET["DTPicker1"])) <= 4)) {
									if ($row_rsbrand_mas["b60"] == 1) {
										// Me.TypeGrid1.Rows = ii + 1

										$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
										$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
										$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
										$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
										$TypeGrid1[$ii][5] = $row_RScbal["brand"];
										$TypeGrid1[$ii][12] = -($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
										$TypeGrid1[$ii][13] = -($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
										$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
										$totgrn = $totgrn + $row_RScbal["AMOUNT"];
										$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
										$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
										$ii = $ii + 1;
									}
								} else {
									if ($row_rsbrand_mas["d60to75"] == 1) {
										//Me.TypeGrid1.Rows = ii + 1

										$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
										$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
										$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
										$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
										$TypeGrid1[$ii][5] = $row_RScbal["brand"];
										$TypeGrid1[$ii][12] = -($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
										$TypeGrid1[$ii][13] = -($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
										$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
										$totgrn = $totgrn + $row_RScbal["AMOUNT"];
										$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
										$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
										$ii = $ii + 1;
									}
								}
							} else {
								if ($row_rsbrand_mas = mysqli_fetch_array($result_rsbrand_mas)) {
									if ($row_rsbrand_mas["delinrate"] == 2.5) {
										if ($row_rsbrand_mas["delinrate"] >= 0) {
											//Me.TypeGrid1.Rows = ii + 1

											$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
											$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
											$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
											$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
											$TypeGrid1[$ii][5] = $row_RScbal["brand"];
											$TypeGrid1[$ii][12] = -($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
											$TypeGrid1[$ii][13] = -($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
											$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
											$totgrn = $totgrn + $row_RScbal["AMOUNT"];
											$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
											$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
											$ii = $ii + 1;
										}
									}
								}
							}
						}
					} else {
						if ($_GET["cmbtype"] == "Battery") {
							if ((date("m", strtotime($_GET["DTPicker1"])) >= 1) and (date("Y", strtotime($_GET["DTPicker1"])) >= 2010)) {
								$result_rsbrand_mas = mysqli_query($GLOBALS['dbinv'], $sql_rsbrand_mas);
								if ($row_rsbrand_mas = mysqli_fetch_array($result_rsbrand_mas)) {
									if ($row_rsbrand_mas["delinrate"] == 3.5) {

										if ($row_rsbrand_mas["delinrate"] >= 0) {
											// Me.TypeGrid1.Rows = ii + 1

											$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
											$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
											$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
											$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
											$TypeGrid1[$ii][5] = $row_RScbal["brand"];
											$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
											$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
											$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
											$totgrn = $totgrn + $row_RScbal["AMOUNT"];
											$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
											$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
											$ii = $ii + 1;
										}
									}
								}
							}
						} else {
							if ($row_rsbrand_mas["d60to75"] == 3) {
								//Me.TypeGrid1.Rows = ii + 1

								$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
								$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
								$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
								$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
								$TypeGrid1[$ii][5] = $row_RScbal["brand"];
								$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
								$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
								$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
								$totgrn = $totgrn + $row_RScbal["AMOUNT"];
								$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
								$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
								$ii = $ii + 1;
							}
						}

					}

				}

			} else {
				$sql_rsbrand_mas = "select * from brand_mas where barnd_name = '" . trim($row_RScbal["brand"]) . "'";
				$result_rsbrand_mas = mysqli_query($GLOBALS['dbinv'], $sql_rsbrand_mas);

				if ($_GET["cmbtype"] == "Tyre") {
					if ((date("m", strtotime($_GET["DTPicker1"])) < 11) and (date("Y", strtotime($_GET["DTPicker1"])) <= 2010)) {
						if ($row_rsbrand_mas = mysqli_fetch_array($result_rsbrand_mas)) {
							if (($row_rsbrand_mas["delinrate"] == 2.5) and ($row_rsbrand_mas["barnd_name"] == "ROADSTONE") or ($row_rsbrand_mas["barnd_name"] == "ROADSTONE CHINA")) {
								if ($row_rsbrand_mas["delinrate"] >= 0) {
									//Me.TypeGrid1.Rows = ii + 1

									$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
									$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
									$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
									$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
									$TypeGrid1[$ii][5] = $row_RScbal["brand"];
									$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
									$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
									$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
									$totgrn = $totgrn + $row_RScbal["AMOUNT"];
									$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
									$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
									$ii = $ii + 1;
								}
							}
						}
					} else {
						if (date("Y", strtotime($_GET["DTPicker1"])) >= 2014) {
							if ((date("Y", strtotime($_GET["DTPicker1"])) == 2014) and (date("m", strtotime($_GET["DTPicker1"])) <= 4)) {
								if ($row_rsbrand_mas["b60"] == 1) {
									//Me.TypeGrid1.Rows = ii + 1

									$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
									$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
									$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
									$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
									$TypeGrid1[$ii][5] = $row_RScbal["brand"];
									$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
									$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
									$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
									$totgrn = $totgrn + $row_RScbal["AMOUNT"];
									$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
									$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
									$ii = $ii + 1;
								}
							} else {
								if ($row_rsbrand_mas["d60to75"] == 1) {
									//Me.TypeGrid1.Rows = ii + 1

									$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
									$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
									$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
									$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
									$TypeGrid1[$ii][5] = $row_RScbal["brand"];
									$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
									$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
									$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
									$totgrn = $totgrn + $row_RScbal["AMOUNT"];
									$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
									$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
									$ii = $ii + 1;
								}
							}
						} else {
							if ($row_rsbrand_mas = mysqli_fetch_array($result_rsbrand_mas)) {
								if ($row_rsbrand_mas["delinrate"] == 2.5) {
									if ($row_rsbrand_mas["delinrate"] >= 0) {
										//Me.TypeGrid1.Rows = ii + 1

										$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
										$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
										$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
										$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
										$TypeGrid1[$ii][5] = $row_RScbal["brand"];
										$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
										$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
										$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
										$totgrn = $totgrn + $row_RScbal["AMOUNT"];
										$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
										$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
										$ii = $ii + 1;
									}
								}
							}
						}
					}
				} else {
					if ($_GET["cmbtype"] == "Battery") {
						if ((date("m", strtotime($_GET["DTPicker1"])) >= 1) and (date("Y", strtotime($_GET["DTPicker1"])) >= 2010)) {
							if ($row_rsbrand_mas = mysqli_fetch_array($result_rsbrand_mas)) {
								if ($row_rsbrand_mas["delinrate"] == 3.5) {
									if ($row_rsbrand_mas["delinrate"] >= 0) {
										//Me.TypeGrid1.Rows = ii + 1

										$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
										$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
										$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
										$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
										$TypeGrid1[$ii][5] = $row_RScbal["brand"];
										$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
										$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
										$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
										$totgrn = $totgrn + $row_RScbal["AMOUNT"];
										$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
										$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
										$ii = $ii + 1;
									}
								}
							}
						}
					} else {
						if ($row_rsbrand_mas["d60to75"] == 3) {
							$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
							$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
							$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
							$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
							$TypeGrid1[$ii][5] = $row_RScbal["brand"];
							$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
							$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
							$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
							$totgrn = $totgrn + $row_RScbal["AMOUNT"];
							$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
							$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
							$ii = $ii + 1;
						}
					}
				}

			}
		} else {
			$sql_rsbrand_mas = "select * from brand_mas where barnd_name = '" . trim($row_RScbal["brand"]) . "'";
			$result_rsbrand_mas = mysqli_query($GLOBALS['dbinv'], $sql_rsbrand_mas);
			if ($_GET["cmbtype"] == "Tyre") {
				if ((date("m", strtotime($_GET["DTPicker1"])) < 11) and date("Y", strtotime("Y", strtotime($_GET["DTPicker1"])) <= 2010)) {
					if ($row_rsbrand_mas = mysqli_fetch_array($result_rsbrand_mas)) {
						if (($row_rsbrand_mas["delinrate"] == 2.5) and ($row_rsbrand_mas["barnd_name"] == "ROADSTONE") or ($row_rsbrand_mas["barnd_name"] == "ROADSTONE CHINA")) {
							if ($row_rsbrand_mas["delinrate"] >= 0) {
								$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
								$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
								$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
								$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
								$TypeGrid1[$ii][5] = $row_RScbal["brand"];
								$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
								$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
								$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
								$totgrn = $totgrn + $row_RScbal["AMOUNT"];
								$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
								$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
								$ii = $ii + 1;
							}
						}
					}
				} else {
					if (date("Y", strtotime($_GET["DTPicker1"])) >= 2014) {
						if ((date("Y", strtotime($_GET["DTPicker1"])) == 2014) and (date("m", strtotime($_GET["DTPicker1"])) <= 4)) {
							if ($row_rsbrand_mas["b60"] == 1) {
								$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
								$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
								$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
								$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
								$TypeGrid1[$ii][5] = $row_RScbal["brand"];
								$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
								$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
								$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
								$totgrn = $totgrn + $row_RScbal["AMOUNT"];
								$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
								$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
								$ii = $ii + 1;
							}
						} else {
							if ($row_rsbrand_mas["d60to75"] == 1) {
								$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
								$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
								$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
								$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
								$TypeGrid1[$ii][5] = $row_RScbal["brand"];
								$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
								$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
								$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
								$totgrn = $totgrn + $row_RScbal["AMOUNT"];
								$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
								$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
								$ii = $ii + 1;
							}
						}
					} else {
						if ($row_rsbrand_mas = mysqli_fetch_array($result_rsbrand_mas)) {
							if ($row_rsbrand_mas["delinrate"] == 2.5) {
								if ($row_rsbrand_mas["delinrate"] >= 0) {
									$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
									$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
									$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
									$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
									$TypeGrid1[$ii][5] = $row_RScbal["brand"];
									$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
									$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
									$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
									$totgrn = $totgrn + $row_RScbal["AMOUNT"];
									$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
									$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
									$ii = $ii + 1;
								}
							}
						}
					}
				}
			} else {
				if ($_GET["cmbtype"] == "Battery") {
					if ((date("m", strtotime($_GET["DTPicker1"])) >= 1) and (date("Y", strtotime($_GET["DTPicker1"])) >= 2010)) {
						if ($row_rsbrand_mas = mysqli_fetch_array($result_rsbrand_mas)) {
							if ($row_rsbrand_mas["delinrate"] == 3.5) {
								if ($row_rsbrand_mas["delinrate"] >= 0) {
									$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
									$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
									$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
									$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
									$TypeGrid1[$ii][5] = $row_RScbal["brand"];
									$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
									$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
									$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
									$totgrn = $totgrn + $row_RScbal["AMOUNT"];
									$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
									$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
									$ii = $ii + 1;
								}
							}
						}
					}
				} else {
					if ($row_rsbrand_mas["d60to75"] == 3) {
						$tot_grn = $tot_grn + $row_RScbal["AMOUNT"];
						$TypeGrid1[$ii][1] = $row_RScbal["REFNO"];
						$TypeGrid1[$ii][2] = $row_RScbal["SDATE"];
						$TypeGrid1[$ii][3] = $row_RScbal["AMOUNT"];
						$TypeGrid1[$ii][5] = $row_RScbal["brand"];
						$TypeGrid1[$ii][12] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
						$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $_GET["txt_percentage"]) / ($txt_vat + 100) * 100;
						$TypeGrid1[$ii][14] = $row_RScbal["TRN_TYPE"];
						$totgrn = $totgrn + $row_RScbal["AMOUNT"];
						$tgrnince = $tgrnince + $TypeGrid1[$ii][12];
						$txttot_inc = $txttot_inc + $TypeGrid1[$ii][12];
						$ii = $ii + 1;
					}
				}
			}
			//rsbrand_mas.Close
		}

		//RScbal.MoveNext
		//rs_grn.Close
	}
	//RScbal.Close

	$txt_grn = $totgrn;

	$txttotal = ($txt_tot - $txt_grn) / ($txt_vat + 100) * 100;

	////Private Sub Auto_cal()
	$txttot1 = 0;
	$i = 1;
	$TypeGrid1_count = $ii;

	while ($i < $TypeGrid1_count) {
		if ($TypeGrid1[$i][9] <= 50) {
			$M50 = $M50 + 1;
		} else {
			if ($TypeGrid1[$i][9] <= $TypeGrid1[$i][10]) {
				$m75 = $m75 + 1;
			}
		}
		if ($TypeGrid1[$i][14] == "INV") {
			if ($TypeGrid1[$i][9] <= $TypeGrid1[$i][10]) {
				$txttot1 = $txttot1 + $TypeGrid1[$i][8];
			} else {
				$txttot1 = $txttot1;
			}
		}
		$i = $i + 1;
	}
	if (date("Y", strtotime($_GET["DTPicker1"])) >= 2014) {
		if (trim($_GET["cmbtype"]) == "Tyre") {
			$sql_rsper = "Select * from intper where incen_year = 2014 and traget < '" . (($txttot1 - $txt_grn) / ($txt_vat + 100) * 100) . "' order by traget desc ";
		}
	} else {
		if (trim($_GET["cmbtype"]) == "Tyre") {
			$sql_rsper = "Select * from intper where incen_year = 20101 and traget < '" . (($txttot1 - $txt_grn) / ($txt_vat + 100) * 100) . "' order by traget desc ";
		}
	}
	if (trim($_GET["cmbtype"]) == "Battery") {
		$sql_rsper = "Select * from intper where incen_year = 20111 and traget < '" . (($txttot1 - $txt_grn) / ($txt_vat + 100) * 100) . "' order by traget desc ";
	}
	if (trim($_GET["cmbtype"]) == "Atlas") {
		$sql_rsper = "Select * from intper where incen_year = 2015 and traget < '" . ($txttot1 - $txt_grn) / ($txt_vat + 100) * 100 . "' order by traget desc ";
	}
	$result_rsper = mysqli_query($GLOBALS['dbinv'], $sql_rsper);
	if ($row_rsper = mysqli_fetch_array($result_rsper)) {
		$txt_percentage = $row_rsper["per"];
		$ii = 1;
		$diff = abs(strtotime($ddate) - strtotime($_GET["DTPicker1"]));
		$days = floor($diff / (60 * 60 * 24));
		if (($days > 0) and (trim($_GET["cmbtype"]) == "Tyre")) {
			while ($ii < $TypeGrid1_count) {
				if ($TypeGrid1[$ii][14] == "INV") {
					if ($m75 > 0) {
						if (($TypeGrid1[$ii][9] <= 50) and ($TypeGrid1[$ii][15] == "CHK")) {
							$TypeGrid1[$ii][13] = ($TypeGrid1[$ii][8] / 100 * ($txt_percentage + 1)) / ($txt_vat + 100) * 100;
						} else {
							if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {
								$TypeGrid1[$ii][13] = ($TypeGrid1[$ii][8] / 100 * $txt_percentage) / ($txt_vat + 100) * 100;
							} else {
								$TypeGrid1[$ii][13] = 0;
							}
						}
					} else {
						if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {
							$TypeGrid1[$ii][13] = ($TypeGrid1[$ii][8] / 100 * ($txt_percentage + 1)) / ($txt_vat + 100) * 100;
						} else {
							$TypeGrid1[$ii][13] = 0;
						}
					}
				} else {
					if ($m75 > 0) {
						$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $txt_percentage) / ($txt_vat + 100) * 100;
					} else {
						$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * ($txt_percentage + 1)) / ($txt_vat + 100) * 100;
					}
				}
				$ii = $ii + 1;
			}
		} else {
			while ($ii < $TypeGrid1_count) {
				if ($TypeGrid1[$ii][14] == "INV") {
					if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {
						$TypeGrid1[$ii][13] = ($TypeGrid1[$ii][8] / 100 * $txt_percentage) / ($txt_vat + 100) * 100;
					} else {
						$TypeGrid1[$ii][13] = 0;
					}
				} else {
					$TypeGrid1[$ii][13] = -1 * ($TypeGrid1[$ii][3] / 100 * $txt_percentage) / ($txt_vat + 100) * 100;
				}
				$ii = $ii + 1;
			}
		}
	}

	//Call cmd_cal_Click--------------------------------------------------------

	$txttot1 = 0;
	$txttot1 = $txttot1;
	$tinc = 0;
	$ii = 1;
	while ($ii < $TypeGrid1_count) {

		if ($TypeGrid1[$ii][14] == "INV") {
			if ($TypeGrid1[$ii][9] <= $TypeGrid1[$ii][10]) {

				$txttot1 = $txttot1 + $TypeGrid1[$ii][8];
			} else {

				$txttot1 = $txttot1;
			}

		}
		if ($TypeGrid1[$ii][13] != "") { $tinc = ($tinc + $TypeGrid1[$ii][13]);
		}
		$ii = $ii + 1;
	}

	$txt_tot = $txttot1;
	$txttotal = (($txt_tot - $txt_grn) / ($txt_vat + 100) * 100);
	$txttot_inc = $tinc;
	$txtnetin = $txttot_inc - $txtint;

	///////////Call gridset

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	$ResponseXML .= "<incen_table><![CDATA[<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"50\"  ><font color=\"#FFFFFF\">ID</font></td>
							  <td width=\"200\"  ><font color=\"#FFFFFF\">Inv No</font></td>
                              <td width=\"200\" ><font color=\"#FFFFFF\">Inv Date</font></td>
							   <td width=\"200\"  ><font color=\"#FFFFFF\">Amount</font></td>
							    <td width=\"200\" ><font color=\"#FFFFFF\">Paid</font></td>
								<td width=\"200\" ><font color=\"#FFFFFF\"></font></td>
								 <td width=\"200\" ><font color=\"#FFFFFF\">Rec.No</font></td>
								  <td width=\"200\" ><font color=\"#FFFFFF\">Rec.Date</font></td>
								   <td width=\"200\" ><font color=\"#FFFFFF\">Rec.Amount</font></td>
								    <td width=\"200\" ><font color=\"#FFFFFF\">Days</font></td>
									 <td width=\"200\" ><font color=\"#FFFFFF\">Apply Days</font></td>
									  <td width=\"200\" ><font color=\"#FFFFFF\">Locked</font></td>
									   <td width=\"200\" ><font color=\"#FFFFFF\">Incentive</font></td>
									   
                             
   							</tr>";

	$i = 1;
	while ($i < $TypeGrid1_count) {

		$grid0 = "TypeGrid_" . $i . "_00";
		$grid1 = "TypeGrid_" . $i . "_01";
		$grid2 = "TypeGrid_" . $i . "_02";
		$grid3 = "TypeGrid_" . $i . "_03";
		$grid4 = "TypeGrid_" . $i . "_04";
		$grid5 = "TypeGrid_" . $i . "_05";
		$grid6 = "TypeGrid_" . $i . "_06";
		$grid7 = "TypeGrid_" . $i . "_07";
		$grid8 = "TypeGrid_" . $i . "_08";
		$grid9 = "TypeGrid_" . $i . "_09";
		$grid10 = "TypeGrid_" . $i . "_10";
		$grid11 = "TypeGrid_" . $i . "_11";
		$grid12 = "TypeGrid_" . $i . "_12";
		$grid13 = "TypeGrid_" . $i . "_13";
		$grid14 = "TypeGrid_" . $i . "_14";
		 
	if ($TypeGrid1[$i][8] =="") { $TypeGrid1[$i][8] =0; }
		$ResponseXML .= " <tr>
                              <td width=\"50\"  ><div id=\"" . $grid0 . "\">" . $TypeGrid1[$i][0] . "</div></td>
							  <td width=\"121\"  ><div id=\"" . $grid1 . "\">" . $TypeGrid1[$i][1] . "</div></td>
							  <td width=\"121\"  ><div id=\"" . $grid2 . "\">" . $TypeGrid1[$i][2] . "</div></td>
							  <td width=\"121\"  ><div id=\"" . $grid3 . "\">" . $TypeGrid1[$i][3] . "</div></td>
							  <td width=\"121\"  ><div id=\"" . $grid4 . "\">" . $TypeGrid1[$i][4] . "</div></td>
							  <td width=\"121\"  ><div id=\"" . $grid5 . "\">" . $TypeGrid1[$i][5] . "</div></td>
							  <td width=\"121\"  ><div id=\"" . $grid6 . "\">" . $TypeGrid1[$i][6] . "</div></td>
							  <td width=\"121\"  ><div id=\"" . $grid7 . "\">" . $TypeGrid1[$i][7] . "</div></td>
							  <td width=\"121\"  ><div id=\"" . $grid8 . "\">" . $TypeGrid1[$i][8] . "</div></td>
							  <td width=\"121\"  ><div id=\"" . $grid9 . "\">" . $TypeGrid1[$i][9] . "</div></td>
							  <td width=\"121\"  ><input type=\"text\"  class=\"text_purchase3\" name=\"" . $grid10 . "\" id=\"" . $grid10 . "\" size=\"15\"  value=\"" . $TypeGrid1[$i][10] . "\"  onblur=\"calc1_table('" . $i . "');\"   /></td>
							  <td width=\"121\"  ><div id=\"" . $grid11 . "\">" . $TypeGrid1[$i][11] . "</div></td>
							  <td width=\"121\" align=right ><div id=\"" . $grid12 . "\">" . number_format($TypeGrid1[$i][12], 2, ".", ",") . "</div></td>
							  <td width=\"121\" align=right ><div id=\"" . $grid13 . "\">" . number_format($TypeGrid1[$i][13], 2, ".", ",") . "</div></td>
							  <td width=\"121\"  ><div id=\"" . $grid14 . "\">" . $TypeGrid1[$i][14] . "</td></tr>";

		$i = $i + 1;
	}

	$ResponseXML .= " </table>]]></incen_table>";

	$txtremark = str_replace("&nbsp;", " ", $txtremark);
	$txt_chno="";
	$ResponseXML .= "<txtremark><![CDATA[" . $txtremark . "]]></txtremark>";
	$ResponseXML .= "<txtint><![CDATA[" . $txtint . "]]></txtint>";
	$ResponseXML .= "<txt_percentage><![CDATA[" . $txt_percentage . "]]></txt_percentage>";
	$ResponseXML .= "<txtnetin><![CDATA[" . number_format($txtnetin, 2, ".", ",") . "]]></txtnetin>";
	$ResponseXML .= "<txt_chno><![CDATA[" . $txt_chno . "]]></txt_chno>";
	$ResponseXML .= "<chq_ignore><![CDATA[" . $chq_ignore . "]]></chq_ignore>";
	$ResponseXML .= "<txttot_inc><![CDATA[" . number_format($txttot_inc, 2, ".", ",") . "]]></txttot_inc>";
	$ResponseXML .= "<txt_tot><![CDATA[" . number_format($txt_tot, 2, ".", ",") . "]]></txt_tot>";
	$ResponseXML .= "<txt_grn><![CDATA[" . number_format($txt_grn, 2, ".", ",") . "]]></txt_grn>";
	$ResponseXML .= "<txttotal><![CDATA[" . number_format($txttotal, 2, ".", ",") . "]]></txttotal>";
	$ResponseXML .= "<txt_out><![CDATA[" . number_format($txt_out, 2, ".", ",") . "]]></txt_out>";
	$ResponseXML .= "<TypeGrid1_count><![CDATA[" . $TypeGrid1_count . "]]></TypeGrid1_count>";
	$ResponseXML .= "<txt_vat><![CDATA[" . $txt_vat . "]]></txt_vat>";

	$ResponseXML .= "</salesdetails>";

	echo $ResponseXML;

	mysqli_close($GLOBALS['dbinv']);
}

if ($_GET["Command"] == "calc1_table") {

	$tincen = 0;

	$TypeGrid08 = str_replace(",", "", $_GET["TypeGrid08"]);

	$old_TypeGrid13 = str_replace(",", "", $_GET["TypeGrid13"]);
	$txttot_inc = str_replace(",", "", $_GET["txttot_inc"]);
	$txtint = str_replace(",", "", $_GET["txtint"]);

	$txttot_inc = $txttot_inc - $old_TypeGrid13;

	if (($_GET["TypeGrid14"] == "INV") or ($_GET["TypeGrid14"] == "INV - TBR") or ($_GET["TypeGrid14"] == "INV - TBB")) {

		if ($_GET["TypeGrid09"] <= $_GET["TypeGrid10"]) {
			$TypeGrid13 = ($TypeGrid08 / 100 * $_GET["txt_percentage"]) / ($_GET["txt_vat"] + 100) * 100;
			$txttot_inc = $txttot_inc + $TypeGrid13;
		} else {
			$TypeGrid13 = 0;
		}

	} else {
		$TypeGrid13 = -($TypeGrid03 / 100 * $_GET["txt_percentage"]) / ($_GET["txt_vat"] + 100) * 100;
		$txttot_inc = $txttot_inc + $TypeGrid13;
	}

	$txtnetin = $txttot_inc - $txtint;
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	$ResponseXML .= "<TypeGrid13><![CDATA[" . number_format($TypeGrid13, 2, ".", ",") . "]]></TypeGrid13>";
	$ResponseXML .= "<txttot_inc><![CDATA[" . number_format($txttot_inc, 2, ".", ",") . "]]></txttot_inc>";
	$ResponseXML .= "<txtnetin><![CDATA[" . number_format($txtnetin, 2, ".", ",") . "]]></txtnetin>";
	$ResponseXML .= "<mcount><![CDATA[" . $_GET["mcount"] . "]]></mcount>";
	$ResponseXML .= "</salesdetails>";

	echo $ResponseXML;
}

if ($_GET["Command"] == "setTotal") {
	$r = 1;
	$chtotal = 0;
	$total = 0;

	while ($GLOBALS[$gridchk[$r][1]] != "") {
		$GLOBALS[$gridchk[$r][7]] = "";
		$chtotal = $chtotal + $GLOBALS[$gridchk[$r][6]];
		$r = $r + 1;
	}

	while ($GLOBALS[$Gridinv[$r][1]] != "") {
		$GLOBALS[$Gridinv[$r][7]] = "";
		$total = $total + $GLOBALS[$Gridinv[$r][6]];
		$r = $r + 1;
	}
	//$re = Val(Format(txtcrnamount.Text, General)) - (total + chtotal + Val(Format(txtcash, General)))

}

if ($_GET["Command"] == "save_crec") {
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	$sql = "Select Guti from invpara";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	$row = mysqli_fetch_array($result);
	$tmprecno = "000000" . $row["Guti"];
	$lenth = strlen($tmprecno);
	$recno = trim("CUTI/ ") . substr($tmprecno, $lenth - 7);
	$_SESSION["recno"] = $recno;

	$sql_ch = "select * from ch_sttr where ST_REFNO='" . trim($_GET["txtrefno"]) . "'";
	$result_ch = mysqli_query($GLOBALS['dbinv'], $sql_ch);
	$row_ch = mysqli_fetch_array($result_ch);

	$sql = "select * from ch_sttr";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	$sql_utmas = "SELECT * FROM s_utmas WHERE C_REFNO ='" . trim($_GET["txtrefno"]) . "'";
	$result_utmas = mysqli_query($GLOBALS['dbinv'], $sql_utmas);
	if ($row_utmas = mysqli_fetch_array($result_utmas)) {
		exit("Ref. No Already Exists");
	}

	if ($_GET["txtcash"] != "") {
		$txtcash = $_GET["txtcash"];
	} else {
		$txtcash = 0;
	}

	$sql_utmas = "insert into s_utmas(C_REFNO, C_DATE, C_CODE, C_CRNNo, C_Amount, C_cash, c_chno, c_chdate, ch_val, ch_bank) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $_GET["Txtcusco"] . "', '" . $_GET["txtcrnno"] . "', '" . $_GET["lblPaid"] . "', '" . $_GET["txtcash"] . "', '" . $_GET["txtchno"] . "', '" . $_GET["DTPicker1"] . "', '" . $_GET["txtamount"] . "', '" . $_GET["txtchbank"] . "')";
	$result_utmas = mysqli_query($GLOBALS['dbinv'], $sql_utmas);

	if ($_GET["chkcash"] == "on") {
		$sql_cruti = "insert into s_ut(C_REFNO, C_DATE, C_CODE, C_INVNO, C_PAYMENT, CRE_NO_NO, TYPE) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $_GET["Txtcusco"] . "', 'CASH', '" . $_GET["lblPaid"] . "', '" . trim($_GET["txtcrnno"]) . "', 'CAS')";
		$result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);
	}

	if ($_GET["chkinv"] == "on") {
		$r = 1;
		while ($GLOBALS[$Gridinv[$r][1]] != "") {
			if (($GLOBALS[$Gridinv[$r][6]] > 0) and ($GLOBALS[$Gridinv[$r][1]] != "") and ($GLOBALS[$Gridinv[$r][2]] != "") and ($GLOBALS[$Gridinv[$r][5]] > 0)) {
				$sql_cruti = "insert into s_ut(C_REFNO, C_DATE, C_CODE, C_INVNO, C_PAYMENT, CRE_NO_NO, TYPE) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $_GET["Txtcusco"] . "', '" . $GLOBALS[$Gridinv[$r][1]] . "', '" . $GLOBALS[$Gridinv[$r][6]] . "', '" . trim($_GET["txtcrnno"]) . "', 'INV')";
				$result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);

				$sql_cruti = "UPDATE s_salma SET TOTPAY = TOTPAY + " . $GLOBALS[$Gridinv[$r][6]] . " WHERE ((REF_NO='" . trim($GLOBALS[$Gridinv[$r][1]]) . "'))";
				$result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);

				$diff = abs(strtotime($_GET["dtdate"]) - strtotime($GLOBALS[$Gridinv[$r][6]]));
				$days = floor($diff / (60 * 60 * 24));

				$sql_cruti = "insert into s_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_CHNO, st_days, ap_days) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $GLOBALS[$Gridinv[$r][1]] . "', '" . $GLOBALS[$Gridinv[$r][6]] . "', 'UT', '" . trim($_GET["txtcrnno"]) . "', '" . $days . "', '" . $days . "')";
				$result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);

				//==================credit limit=============================
				$sql_rsinv = "select Brand from s_salma where Accname != 'NON STOCK' and REF_NO='" . trim($GLOBALS[$Gridinv[$r][1]]) . "'";
				$result_rsinv = mysqli_query($GLOBALS['dbinv'], $sql_rsinv);
				if ($row_rsinv = mysqli_fetch_array($result_rsinv)) {

					$sql_class = "select class from brand_mas where barnd_name='" . $row_rsinv["Brand"] . "'";
					$result_class = mysqli_query($GLOBALS['dbinv'], $sql_class);
					if ($row_class = mysqli_fetch_array($result_class)) {

						$sql_inv = "update br_trn set credit=credit - " . $GLOBALS[$Gridinv[$r][6]] . " where cus_code='" . trim($_GET["txtcrnno"]) . "' and Class='" . $row_class["class"] . "'";
						$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
					}
				}

			}

			$r = $r + 1;
		}
	}

	if ($_GET["chkret"] == "on") {

		$r = 1;
		while ($GLOBALS[$gridchk[$r][1]] != "") {
			if (($GLOBALS[$gridchk[$r][6]] > 0) and ($GLOBALS[$gridchk[$r][1]] != "") and ($GLOBALS[$gridchk[$r][2]] != "") and ($GLOBALS[$gridchk[$r][5]] > 0)) {
				$sql_cruti = "insert into s_ut(C_REFNO, C_DATE, C_CODE, C_INVNO, C_PAYMENT, CRE_NO_NO, TYPE) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $_GET["Txtcusco"] . "', '" . $GLOBALS[$gridchk[$r][1]] . "', '" . $GLOBALS[$gridchk[$r][6]] . "', '" . trim($_GET["txtcrnno"]) . "', 'CHQ')";
				$result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);

				$sql_cruti = "insert into s_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_CHNO) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $GLOBALS[$gridchk[$r][1]] . "', '" . $GLOBALS[$Gridinv[$r][6]] . "', 'UT', '" . trim($_GET["txtcrnno"]) . "')";
				$result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);

				$sql_inv = "UPDATE s_cheq SET PAID = PAID + " . $GLOBALS[$Gridinv[$r][6]] . " WHERE (((CR_REFNO)='" . trim($GLOBALS[$gridchk[$r][1]]) . "'))";
				$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

				$sql_inv = "UPDATE vendor SET RET_CHEQ = RET_CHEQ - " . $GLOBALS[$Gridinv[$r][6]] . " WHERE CODE='" . trim($GLOBALS[$gridchk[$r][1]]) . "'";
				$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
			}
		}
	}

	$sql_inv = "UPDATE c_bal SET BALANCE = BALANCE - " . $_GET["lblPaid"] . " WHERE ((REFNO='" . trim($_GET["txtcrnno"]) . "'))";
	$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

	$sql_inv = "UPDATE invpara SET Guti=Guti+1";
	$result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

	echo "Saved";

}

if ($_GET["Command"] == "search_rec") {

	include_once ("connectioni.php");

	$ResponseXML .= "";
	//$ResponseXML .= "<invdetails>";

	$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
							   <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
							    <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
                             
   							</tr>";

	if ($_GET["mfield"] == "recno") {
		$letters = $_GET['recno'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
		//$letters="/".$letters;
		//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
		//echo $a;

		$sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_crec where  CA_REFNO like  '$letters%'") or die(mysqli_error());
	} else if ($_GET["mstatus"] == "recdate") {
		$letters = $_GET['recdate'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
		$sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_crec where CA_DATE like  '$letters%'") or die(mysqli_error());
	} else if ($_GET["mstatus"] == "recamt") {
		$letters = $_GET['recamt'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
		$sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_crec where CA_AMOUNT like  '$letters%'") or die(mysqli_error());
	} else {
		$letters = $_GET['recno'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
		$sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_crec where CA_REFNO like  '$letters%'") or die(mysqli_error());
	}

	while ($row = mysqli_fetch_array($sql)) {
		$REF_NO = $row['CA_REFNO'];
		$stname = $_GET["mstatus"];
		$ResponseXML .= "<tr>
                           	  <td bgcolor=\"#222222\" onclick=\"recno('$REF_NO');\">" . $row['CA_REFNO'] . "</a></td>
                              <td bgcolor=\"#222222\" onclick=\"recno('$REF_NO');\">" . $row['CA_DATE'] . "</a></td>
                              <td bgcolor=\"#222222\" onclick=\"recno('$REF_NO');\">" . $row['CA_AMOUNT'] . "</a></td>";

		$sql1 = "SELECT * FROM vendor where CODE = '" . $row["CA_CODE"] . "'";
		$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
		$row1 = mysqli_fetch_array($result1);
		$ResponseXML .= "<td bgcolor=\"#222222\" onclick=\"recno('$REF_NO');\">" . $row1['NAME'] . "</a></td>                          	
                            </tr>";
	}

	$ResponseXML .= "   </table>";

	echo $ResponseXML;
}

if ($_GET["Command"] == "pass_recno") {
	//header('Content-Type: text/xml');
	/*echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	$sql = "select * from s_crec where CA_REFNO='" . $_GET["recno"] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	if ($row = mysqli_fetch_array($result)) {
		$ResponseXML .= "<CA_REFNO><![CDATA[" . $row["CA_REFNO"] . "]]></CA_REFNO>";
		$ResponseXML .= "<CA_DATE><![CDATA[" . $row["CA_DATE"] . "]]></CA_DATE>";
		$ResponseXML .= "<CA_CODE><![CDATA[" . $row["CA_CODE"] . "]]></CA_CODE>";

		$sql1 = "select * from vendor where CODE='" . $row["CA_CODE"] . "'";
		$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
		if ($row1 = mysqli_fetch_array($result1)) {
			$ResponseXML .= "<cusname><![CDATA[" . $row1["NAME"] . "]]></cusname>";
		}
		$ResponseXML .= "<CA_CASSH><![CDATA[" . $row["CA_CASSH"] . "]]></CA_CASSH>";
		$ResponseXML .= "<CA_AMOUNT><![CDATA[" . $row["CA_AMOUNT"] . "]]></CA_AMOUNT>";
		$ResponseXML .= "<CA_SALESEX><![CDATA[" . $row["CA_SALESEX"] . "]]></CA_SALESEX>";

		$sql1 = "select * from s_salrep where REPCODE='" . $row["CA_SALESEX"] . "'";
		$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
		if ($row1 = mysqli_fetch_array($result1)) {
			$ResponseXML .= "<repname><![CDATA[" . $row1["Name"] . "]]></repname>";
		}
	}

	$sql = "select * from s_invcheq where refno='" . $_GET["recno"] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	if ($row = mysqli_fetch_array($result)) {
		$ResponseXML .= "<collectcode><![CDATA[" . $row["ch_owner"] . "]]></collectcode>";
	}

	$sql = "delete from tmp_ret_chq_sett where recno='" . $_GET["recno"] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	$sql = "select * from s_invcheq where refno='" . $_GET["recno"] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {
		$sql1 = "insert into tmp_ret_chq_sett(recno, chqno, chqdate, chqbank, chqamt) values ('" . $row["refno"] . "', '" . $row["cheque_no"] . "', '" . $row["che_date"] . "', '" . $row["bank"] . "', " . $row["che_amount"] . ")";
		$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
	}

	$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";

	$sql = "select * from tmp_ret_chq_sett where recno='" . $_GET["recno"] . "' ";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {
		$ResponseXML .= "<tr>
					<td>" . $row["chqno"] . "</td>
					<td>" . $row["chqdate"] . "</td>
					<td>" . $row["chqbank"] . "</td>
					<td align=right>" . number_format($row["chqamt"], 2, ".", ",") . "</td>
					</tr>";
		$totchq = $totchq + $row["chqamt"];
	}

	$ResponseXML .= "   </table>]]></chq_table>";

	$sql = "delete from tmp_utilization where recno='" . $_GET["recno"] . "' ";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);

	$sql = "select * from s_sttr where ST_REFNO='" . $_GET["recno"] . "' ";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {
		$sql1 = "select * from s_salma where REF_NO='" . $row["ST_INVONO"] . "' ";
		$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
		$row1 = mysqli_fetch_array($result1);

		$sql2 = "insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days) values ('" . $_GET["recno"] . "', '" . $row["ST_INVONO"] . "', '" . $row1["SDATE"] . "', '" . $row["ST_CHNO"] . "', '" . $row["st_chdate"] . "', '" . $row["st_chbank"] . "', " . $row["ST_PAID"] . ", " . $row["st_days"] . ")";
		$result2 = mysqli_query($GLOBALS['dbinv'], $sql2);

	}

	$ResponseXML .= "<uti_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Invoice No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Invoice Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Settled</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Days</td>
					</tr>";

	$sql = "select * from tmp_utilization where recno='" . $_GET["recno"] . "'";
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {
		$ResponseXML .= "<tr>
					<td>" . $row["invno"] . "</td>
					<td>" . $row["invdate"] . "</td>
					<td>" . $row["chqno"] . "</td>
					<td>" . $row["chqdate"] . "</td>
					<td align=right>" . number_format($row["settled"], 2, ".", ",") . "</td>
					<td>" . $row["days"] . "</td>
					</tr>";

	}

	$ResponseXML .= "   </table>]]></uti_table>";
	$ResponseXML .= "</salesdetails>";

	echo $ResponseXML;
}

if ($_GET["Command"] == "delete_rec") {
	$ResponseXML = "";

	if ($_GET["invdate"] == date("Y-m-d")) {
		$sql = "select * from c_bal where REFNO='" . $_GET["recno"] . "'";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);
		if ($row = mysqli_fetch_array($result)) {
			if ($row["AMOUNT"] == $row["BALANCE"]) {
				$sql1 = "delete from s_crec where CA_REFNO='" . $_GET["recno"] . "'";
				$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

				$sql1 = "delete from s_sttr where ST_REFNO='" . $_GET["recno"] . "'";
				$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

				$sql1 = "delete from s_led where REF_NO='" . $_GET["recno"] . "'";
				$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

				$sql1 = "delete from s_invcheq where refno='" . $_GET["recno"] . "'";
				$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

				$sql1 = "update vendor set CUR_BAL=CUR_BAL+ " . $_GET["txtpaytot"] . " where CODE='" . $_GET["cuscode"] . "'";
				$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

				$sql1 = "delete from c_bal where REFNO='" . $_GET["recno"] . "'";
				$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

				$sql1 = "update br_trn set credit=credit- " . $_GET["txtpaytot"] . " where cus_code='" . $_GET["cuscode"] . "'";
				$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

				$sql1 = "select * from tmp_utilization where recno='" . $_GET["recno"] . "'";
				$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
				while ($row1 = mysqli_fetch_array($result1)) {
					$sql2 = "update s_salma set TOTPAY=TOTPAY- " . $row1["settled"] . " where recno='" . $row1["invno"] . "'";
					$result2 = mysqli_query($GLOBALS['dbinv'], $sql2);

					if ($row1["chqno"] == "Cash") {
						$sql2 = "update s_salma set CASH=CASH- " . $row1["settled"] . " where REF_NO='" . $row1["invno"] . "'";
						$result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
					}
				}
				$ResponseXML = "Reciept Canceled";
			} else {
				$ResponseXML .= "Sorry over payment utilized.... Cant Cancel";
			}
		} else {
			$sql1 = "delete from s_crec where CA_REFNO='" . $_GET["recno"] . "'";
			$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

			$sql1 = "delete from s_sttr where ST_REFNO='" . $_GET["recno"] . "'";
			$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

			$sql1 = "delete from s_led where REF_NO='" . $_GET["recno"] . "'";
			$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

			$sql1 = "delete from s_invcheq where refno='" . $_GET["recno"] . "'";
			$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

			$sql1 = "update vendor set CUR_BAL=CUR_BAL+ " . $_GET["txtpaytot"] . " where CODE='" . $_GET["cuscode"] . "'";
			$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

			$sql1 = "delete from c_bal where REFNO='" . $_GET["recno"] . "'";
			$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

			$sql1 = "update br_trn set credit=credit- " . $_GET["txtpaytot"] . " where cus_code='" . $_GET["cuscode"] . "'";
			$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

			$sql1 = "select * from tmp_utilization where recno='" . $_GET["recno"] . "'";
			$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
			while ($row1 = mysqli_fetch_array($result1)) {
				$sql2 = "update s_salma set TOTPAY=TOTPAY- " . $row1["settled"] . " where recno='" . $row1["invno"] . "'";
				$result2 = mysqli_query($GLOBALS['dbinv'], $sql2);

				if ($row1["chqno"] == "Cash") {
					$sql2 = "update s_salma set CASH=CASH- " . $row1["settled"] . " where REF_NO='" . $row1["invno"] . "'";
					$result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
				}
			}
			$ResponseXML = "Reciept Canceled";
		}
	} else {
		$ResponseXML = "Sorry Cant Cancel.... please check reciept date";
	}

	echo $ResponseXML;

}
?>