<?php

session_start();

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
	$txtgrntot = 0;
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
			if (($row_rs_salm["DUMMY_VAL"] > 0) and ($row_rs_salm["GRAND_TOT"] > 0)) {
				$TypeGrid1[$ii][7] = ($row_rs_salm["DUMMY_VAL"] / $row_rs_salm["GRAND_TOT"]) * $row_rsgen["GRAND_TOT"];
			}
			$TypeGrid1[$ii][8] = $row_rsgen["DIS1"];
			$txtgrntot = $TypeGrid1[$ii][7] + $TypeGrid1[$ii][8];
			$ii = $ii + 1;
		}
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
				if (is_null($row_rsgen["SETTLED"]) == false) {
					$TypeGrid1[$ii][8] = $row_rsgen["SETTLED"];
				}
				$txtgrntot = $txtgrntot + $TypeGrid1[$ii][7] + $TypeGrid1[$ii][8];
				$ii = $ii + 1;
			}
		}

		$TypeGrid1_count = $ii;
		$TypeGrid1[0][0] = "";
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
			if (isset($TypeGrid1[$r][0])) {
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
			}
			$r = $r + 1;
		}

		$ResponseXML .= "   </table>]]></TypeGrid1>";
		$ResponseXML .= "<mcount><![CDATA[" . $r . "]]></mcount>";

		$ResponseXML .= " </salesdetails>";
		echo $ResponseXML;
	
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
					if ($row_inv["DEV"] == "1") {
						$commission = $cat1 * $row_sttr["ST_PAID"] * 0.01;
					}
					if ($row_inv["DEV"] == "0") {
						$commission = $cat1 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($_GET["txtvat"] / 100));
					}
				}

				if (($apdays > $day1 - 1) and ($apdays < $day2)) {
					if ($cat2 > 0) {
						$D_76_90 = $row_sttr["ST_PAID"];
						if ($row_inv["DEV"] == "1") {
							$commission = $cat2 * $row_sttr["ST_PAID"] * 0.01;
						}
						if ($row_inv["DEV"] == "0") {
							$commission = $cat2 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($_GET["txtvat"] / 100));
						}
					} else {
						$D_91 = $row_sttr["ST_PAID"];
						if ($row_inv["DEV"] == "1") {
							$commission = $cat2 * $row_sttr["ST_PAID"] * 0.01;
						}
						if ($row_inv["DEV"] == "0") {
							$commission = $cat2 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($_GET["txtvat"] / 100));
						}
					}
				}

				if ($apdays > ($day2 - 1)) {
					$D_91 = $row_sttr["ST_PAID"];
					if ($row_inv["DEV"] == "1") {
						$commission = $cat3 * $row_sttr["ST_PAID"] * 0.01;
					}
					if ($row_inv["DEV"] == "0") {
						$commission = $cat3 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($_GET["txtvat"] / 100));
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

				if ($tarcat == 1) {
					$cat1 = $row_cat["t1_cat1"];
				}
				if ($tarcat == 2) {
					$cat1 = $row_cat["t2_cat1"];
				}
				if ($tarcat == 3) {
					$cat1 = $row_cat["t3_cat1"];
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

				if ($tarcat == 1) {
					$cat1 = $row_cat["t1_cat1"];
				}
				if ($tarcat == 2) {
					$cat1 = $row_cat["t2_cat1"];
				}
				if ($tarcat == 3) {
					$cat1 = $row_cat["t3_cat1"];
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
		if (is_null($row_sttr1["commission"]) == false) {
			$mnonocom = $row_sttr1["commission"];
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
		 Probar.Visible = False */
	}
}

if ($_GET["Command"] == "com_lock") {

	include ("connectioni.php");

	$mrefno = date("m/Y", strtotime($_GET["dtMonth"])) . "-" . $_GET["cmbrep"] . "-" . $_GET["cmbdev"];
	$mrefno = date("m/Y", strtotime($_GET["dtMonth"])) . "-" . $_GET["cmbrep"] . "- Bal -" . $_GET["cmbdev"];
	$sql_commadva = "select * from s_commadva where refno='" . $mrefno . "'";
	$result_commadva = mysqli_query($GLOBALS['dbinv'], $sql_commadva);
	if ($row_commadva = mysqli_fetch_array($result_commadva)) {

		$sql = "Update s_commadva set Lock1 ='1',chno='0' where refno = '" . $mrefno . "' AND FLAG='BAL'";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);
		 
		$sql = "Update s_commadva set appby = '" . $_SESSION["CURRENT_USER"] . "' where refno = '" . $mrefno . "' AND FLAG='BAL'";
		$result = mysqli_query($GLOBALS['dbinv'], $sql);

		$sql = "Update s_commadva set appdate = '" . date("Y-m-d") . "' where refno = '" . $mrefno . "' AND FLAG='BAL'";
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

	$mrefno = date("m/Y", strtotime($_GET["dtMonth"])) . "-" . $_GET["cmbrep"] . " Bal -" . $_GET["cmbdev"];
	 

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
	$mrefno = $month . "/" . $year . "-" . substr($_GET["cmbrep"], 0, 2) . "- Bal -0";

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
						if (trim($_GET["cmbdev"]) == "1") {
							$cat1SALE = $cat1SALE + $row_sttr["INVPAID"];
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
						if (trim($_GET["cmbdev"]) == "1") {
							$cat1SpSALE = $cat1SpSALE + $sttr["INVPAID"];
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

					if (trim($_GET["cmbdev"]) == "1") {
						$cat1SALE = $cat1SALE + $row_sttr["INVPAID"];
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
					if (trim($_GET["cmbdev"]) == "1") {
						$cat2SALE = $cat2SALE + $row_sttr["INVPAID"];
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
						if (trim($_GET["cmbdev"]) == "0") {
							$cat1SALE = $cat1SALE + $row_sttr["INVPAID"];
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
						if (trim($_GET["cmbdev"]) == "0") {
							$cat1SALE = $cat1SALE + $row_sttr["INVPAID"];
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
						if (trim($_GET["cmbdev"]) == "0") {
							$cat1SpSALE = $cat1SpSALE + $row_sttr["INVPAID"];
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
						if (trim($_GET["cmbdev"]) == "0") {
							$cat2SALE = $cat2SALE + $row_sttr["INVPAID"];
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

		if ($_GET["cmbdev"] == "1") {
			$txtBalsale = $txtnet;
		}
		if ($_GET["cmbdev"] == "0") {
			$txtBalsale = $txtnet;
		}
		if ($_GET["cmbdev"] == "All") {
			$txtBalsale = $txtnet;
		}
		$txtbalSAleTOT = $txtTotnet;
	} else {

		if ($_GET["cmbdev"] == "1") {
			$txtBalsale = $txtnet - $_GET["txtRetChkAmou_D1"] - $txtNocomm;
		}
		if ($_GET["cmbdev"] == "0") {
			$txtBalsale = $txtnet - $_GET["txtRetChkAmou_Do"] - $txtNocomm;
		}
		if ($_GET["cmbdev"] == "All") {
			$txtBalsale = $txtnet - $_GET["txtRetChkAmou_D1"] - $_GET["txtRetChkAmou_Do"] - $txtNocomm;
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

	$year = substr($_GET["dtMonth"], 0, 4);
	$month = substr($_GET["dtMonth"], 5, 2);

	$retcommamou = 0;

	if ($_GET["cmbdev"] != "1") {
		$retcommamou = 0;

		$sql_rsgen = "select * from s_crnma where CANCELL='0' and month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and SAL_EX='" . trim($_GET["cmbrep"]) . "'  ";
		$result_rsgen = mysqli_query($GLOBALS['dbinv'], $sql_rsgen);
		while ($row_rsgen = mysqli_fetch_array($result_rsgen)) {

			$retcommamou = $retcommamou + $row_rsgen["DUMMY_VAL"] + $row_rsgen["DIS1"];
		}

		$row_rsgen = "select * from cred where CANCELL='0' and  month(C_DATE) =" . $month . " and   year(C_DATE) =" . $year . " and C_SALEX='" . trim($_GET["cmbrep"]) . "'  ";
		$result_rsgen = mysqli_query($GLOBALS['dbinv'], $row_rsgen);

		while ($row_rsgen = mysqli_fetch_array($result_rsgen)) {
			$sql_rsbal = "Select * from c_bal where REFNO = '" . $row_rsgen["C_REFNO"] . "' and flag1 != '1'";
			$result_rsbal = mysqli_query($GLOBALS['dbinv'], $sql_rsbal);
			if ($row_rsbal = mysqli_fetch_array($result_rsbal)) {
				if (is_null($row_rsgen["dummy_val"]) == false) {
					$retcommamou = $retcommamou + $row_rsgen["dummy_val"];
				}
				if (is_null($row_rsgen["SETTLED"]) == false) {
					$retcommamou = $retcommamou + $row_rsgen["SETTLED"];
				}
			}
		}
	}
	//=============================================================================================================
	$txtComSale = str_replace(",", "", $_GET['Sales_gridA23']) + str_replace(",", "", $_GET['Sales_gridA33']) + str_replace(",", "", $_GET['Sales_gridA43']);
	$txtComSale = $txtComSale + str_replace(",", "", $_GET['Sales_gridB23']) + str_replace(",", "", $_GET['Sales_gridB33']) + str_replace(",", "", $_GET['Sales_gridB43']);
	$txtComGRN = $retcommamou;

	$txtcat1Com = 0;
	$txtcat1Spcomm = 0;
	$txtcat2com = 0;
	$txtdedamt1 = ($txtComSale-$retcommamou) * $_GET["Deduction_grid13"] * 0.01;
	$txtNoCom_COm = $txtdedamt1 + str_replace(",", "", $_GET['Deduction_grid22']) + str_replace(",", "", $_GET['Deduction_grid32']) + str_replace(",", "", $_GET['Deduction_grid42']) + str_replace(",", "", $_GET['Deduction_grid52']) + str_replace(",", "", $_GET['Deduction_grid62']) + str_replace(",", "", $_GET['Deduction_grid72']) + str_replace(",", "", $_GET['Deduction_grid82']);
	$txtComBal = $txtComSale - $retcommamou - $txtNoCom_COm;

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

	$mrefno = date("m/Y", strtotime($_GET["dtMonth"])) . "-" . $_GET["cmbrep"] . "- Bal -" . $_GET["cmbdev"];
	
	$Deduction_grid11 = $_GET['Deduction_grid11'];
	$Deduction_grid12 = intval(str_replace(",", "", $_GET['Deduction_grid12']));
	$Deduction_grid21 = $_GET['Deduction_grid21'];
	$Deduction_grid22 = intval(str_replace(",", "", $_GET['Deduction_grid22']));
	$Deduction_grid31 = $_GET['Deduction_grid31'];
	$Deduction_grid32 = intval(str_replace(",", "", $_GET['Deduction_grid32']));
	$Deduction_grid41 = $_GET['Deduction_grid41'];
	$Deduction_grid42 = intval(str_replace(",", "", $_GET['Deduction_grid42']));
	$Deduction_grid51 = $_GET['Deduction_grid51'];
	$Deduction_grid52 = intval(str_replace(",", "", $_GET['Deduction_grid52']));
	$Deduction_grid61 = $_GET['Deduction_grid61'];
	$Deduction_grid62 = intval(str_replace(",", "", $_GET['Deduction_grid62']));
	$Deduction_grid71 = $_GET['Deduction_grid71'];
	$Deduction_grid72 = intval(str_replace(",", "", $_GET['Deduction_grid72']));
	$Deduction_grid81 = $_GET['Deduction_grid81'];
	$Deduction_grid82 = intval(str_replace(",", "", $_GET['Deduction_grid82']));

	
	$mded = ($Deduction_grid12 + $Deduction_grid22 + $Deduction_grid32 + $Deduction_grid42 + $Deduction_grid52 + $Deduction_grid62 + $Deduction_grid72 + $Deduction_grid82);
	
	$txt_rded = floatval(str_replace(",", "", $_GET['txt_rded']));
	$mded = $mded + $txt_rded;
	
	$sql_rss_commadva = "select * from s_commadva where FLAG='BAL' AND refno='" . $mrefno . "'";
	$result_rss_commadva = mysqli_query($GLOBALS['dbinv'], $sql_rss_commadva);
	if ($row_rss_commadva = mysqli_fetch_array($result_rss_commadva)) {

		$X = "Already saved record found. Do you want to delete & enter ner Records?";
		if ($X = "vbYes") {
			if ($row_rss_commadva["Lock1"] == 1) {
				exit("Sorry this month locked");
			}

			$sql_rss = "Delete from s_commadva where refno = '" . $mrefno . "' AND FLAG='BAL'";
			$result_rss = mysqli_query($GLOBALS['dbinv'], $sql_rss);

			$sql_rss = "insert into s_commadva (refno, sale, grn,ded, advance, rep, comdate, sdate,  Dedcap1, Dedamount1 , Dedcap2, Dedamount2, Dedcap3,Dedamount3, Dedcap4,Dedamount4, Dedcap5,Dedamount5, Dedcap6,Dedamount6, Dedcap7,Dedamount7, Dedcap8,Dedamount8 ,
			 Over60out,  Over60Ratio,  sale_tyre, GRN_a,sale_Battery,GRN_b,sale_Aw,Sale_tube,tar_salA,tar_salb,tar_salc,Com_tyre,Com_battery,Com_Aw,crn_a,crn_b,crn_c,Crn_d,CRN,Com_tube,flag,tar_salcom,Crn_bcom) values 
			('" . $mrefno . "', " . str_replace(",", "", $_GET["totsal_grid11"]) . ", " . str_replace(",", "", $_GET["grn"]) . ", '" . $mded . "' ,'" . str_replace(",", "", $_GET["advance"]) . "', '" . $_GET["cmbrep"] . "', '" . $_GET["dtMonth"] . "', '" . date("Y-m-d") . "', '" . $_GET["Deduction_grid11"] . "', '" . $Deduction_grid12 . "', '" . $_GET["Deduction_grid21"] . "', '" . $Deduction_grid22 . "', '" . $_GET["Deduction_grid31"] . "', '" . $Deduction_grid32 . "', '" . $_GET["Deduction_grid41"] . "', '" . $Deduction_grid42 . "', '" . $_GET["Deduction_grid51"] . "', " . $Deduction_grid52 . ", '" . $_GET["Deduction_grid61"] . "', " . $Deduction_grid62 . ",'" . $_GET["Deduction_grid71"] . "', " . $Deduction_grid72 . ", '" . $_GET["Deduction_grid81"] . "', " . $Deduction_grid82 . ",
			 " . str_replace(",", "", $_GET["over60out"]) . ", " . str_replace(",", "", $_GET["over60ratio"]) . "," . str_replace(",", "", $_GET["sale_tyre"]) . ", " . str_replace(",", "", $_GET["GRN_a"]) . ", " . str_replace(",", "", $_GET["sale_Battery"]) . ", " . str_replace(",", "", $_GET["GRN_b"]) . "," . str_replace(",", "", $_GET["sale_Aw"]) . ",
			 " . str_replace(",", "", $_GET["sale_Aw"]) . ", " . str_replace(",", "", $_GET["Sale_tube"]) . ", " . str_replace(",", "", $_GET["tar_salA"]) . ", " . str_replace(",", "", $_GET["tar_salb"]) . ", " . str_replace(",", "", $_GET["tar_salc"]) . ", " . str_replace(",", "", $_GET["Com_tyre"]) . ", " . str_replace(",", "", $_GET["Com_Aw"]) . ", " . str_replace(",", "", $_GET["crn_a"]) . ", " . str_replace(",", "", $_GET["crn_b"]) . "," . str_replace(",", "", $_GET['crn_c']) . "," . str_replace(",", "", $_GET['Crn_d']) . "," . str_replace(",", "", $_GET['CRN']) . "," . str_replace(",", "", $_GET['Com_tube']) . ",'BAL'," . str_replace(",", "", $_GET['Com_battery']) . "," . str_replace(",", "", $_GET['CRN']) . ")";
		$result_rss = mysqli_query($GLOBALS['dbinv'], $sql_rss);
			if (!$result_rss) {
				 
				echo mysqli_error($GLOBALS['dbinv']);
			}

			echo "Saved";
		} else {
			exit();
		}
	} else {

		$sql_rss = "insert into s_commadva (refno, sale, grn,ded, advance, rep, comdate, sdate,  Dedcap1, Dedamount1 , Dedcap2, Dedamount2, Dedcap3,Dedamount3, Dedcap4,Dedamount4, Dedcap5,Dedamount5, Dedcap6,Dedamount6, Dedcap7,Dedamount7, Dedcap8,Dedamount8 ,
			 Over60out,  Over60Ratio,  sale_tyre, GRN_a,sale_Battery,GRN_b,sale_Aw,Sale_tube,tar_salA,tar_salb,tar_salc,Com_tyre,Com_battery,Com_Aw,crn_a,crn_b,crn_c,Crn_d,CRN,Com_tube,flag,tar_salcom,Crn_bcom) values 
			('" . $mrefno . "', " . str_replace(",", "", $_GET["totsal_grid11"]) . ", " . str_replace(",", "", $_GET["grn"]) . ", '" . $mded . "' ,'" . str_replace(",", "", $_GET["advance"]) . "', '" . $_GET["cmbrep"] . "', '" . $_GET["dtMonth"] . "', '" . date("Y-m-d") . "', '" . $_GET["Deduction_grid11"] . "', '" . $Deduction_grid12 . "', '" . $_GET["Deduction_grid21"] . "', '" . $Deduction_grid22 . "', '" . $_GET["Deduction_grid31"] . "', '" . $Deduction_grid32 . "', '" . $_GET["Deduction_grid41"] . "', '" . $Deduction_grid42 . "', '" . $_GET["Deduction_grid51"] . "', " . $Deduction_grid52 . ", '" . $_GET["Deduction_grid61"] . "', " . $Deduction_grid62 . ",'" . $_GET["Deduction_grid71"] . "', " . $Deduction_grid72 . ", '" . $_GET["Deduction_grid81"] . "', " . $Deduction_grid82 . ",
			 " . str_replace(",", "", $_GET["over60out"]) . ", " . str_replace(",", "", $_GET["over60ratio"]) . "," . str_replace(",", "", $_GET["sale_tyre"]) . ", " . str_replace(",", "", $_GET["GRN_a"]) . ", " . str_replace(",", "", $_GET["sale_Battery"]) . ", " . str_replace(",", "", $_GET["GRN_b"]) . "," . str_replace(",", "", $_GET["sale_Aw"]) . ",
			 " . str_replace(",", "", $_GET["sale_Aw"]) . ", " . str_replace(",", "", $_GET["Sale_tube"]) . ", " . str_replace(",", "", $_GET["tar_salA"]) . ", " . str_replace(",", "", $_GET["tar_salb"]) . ", " . str_replace(",", "", $_GET["tar_salc"]) . ", " . str_replace(",", "", $_GET["Com_tyre"]) . ", " . str_replace(",", "", $_GET["Com_Aw"]) . ", " . str_replace(",", "", $_GET["crn_a"]) . ", " . str_replace(",", "", $_GET["crn_b"]) . "," . str_replace(",", "", $_GET['crn_c']) . "," . str_replace(",", "", $_GET['Crn_d']) . "," . str_replace(",", "", $_GET['CRN']) . "," . str_replace(",", "", $_GET['Com_tube']) . ",'BAL'," . str_replace(",", "", $_GET['Com_battery']) . "," . str_replace(",", "", $_GET['CRN']) . ")";
		$result_rss = mysqli_query($GLOBALS['dbinv'], $sql_rss);
		if (!$result_rss) {
		 
			echo mysqli_error($GLOBALS['dbinv']);
		}
		echo "Saved";
	}
}

if ($_GET["Command"] == "proces") {

	include ('connectioni.php');

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	$m_rep = $_GET["cmbrep"];
	$dev = $_GET["cmbdev"];

	//====================== Comm Critaria =============================================
	$sql_rst = "Select * from sal_comm_new where sal_ex = '" . $m_rep . "'";

	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
	if ($row_rst = mysqli_fetch_array($result_rst)) {

		$result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
		while ($row_rst = mysqli_fetch_array($result_rst)) {
			if (trim($row_rst["D_group"]) == "Battery") {
				$Critaria_gridA11 = $row_rst["T1"];
				$Critaria_gridA12 = $row_rst["P1"];
				$Critaria_gridA21 = $row_rst["T2"];
				$Critaria_gridA22 = $row_rst["P2"];
				$Critaria_gridA31 = "0";
				$Critaria_gridA32 = $row_rst["Base"];
			}
			if (trim($row_rst["D_group"]) == "Tyres") {
				$Critaria_gridB11 = $row_rst["T1"];
				$Critaria_gridB12 = $row_rst["P1"];
				$Critaria_gridB21 = $row_rst["T2"];
				$Critaria_gridB22 = $row_rst["P2"];
				$Critaria_gridB31 = "0";
				$Critaria_gridB32 = $row_rst["Base"];
			}
		}
	} else {
		exit("Sales targets not entered to this M/E");
	}

	//========================================Checking saved records====================================================
	$mrefno = date("m/Y", strtotime($_GET["dtMonth"])) . "-" . $m_rep . "-" . $_GET["cmbdev"];
	$sql_rst = "Select * from s_commadva where refno = '" . trim($mrefno) . "' and FLAG='ADV'";

	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
	if ($row_rst = mysqli_fetch_array($result_rst)) {
		if ((is_null($row_rst["tar_salA"]) == true) and (is_null($row_rst["tar_salB"]) == true)) {
			if ($row_rst["chno"] > 0) {
				exit("This month Advance paid by old target scheme. Please check old form");
			}
		} else {

		}
	}

	$stat = "";

	//=============================================== Calculate Nett Sales ============================================================
	if ($dev == 0) {
		$sql_rst = "Select class, SUM(GRAND_TOT/(1+(GST/100))) AS TOT FROM  view_salma_brand WHERE Accname != 'NON STOCK' and SAL_EX = '" . $m_rep . "' and DEV = '" . $dev . "' and month(SDATE) = '" . date("m", strtotime($_GET["dtMonth"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["dtMonth"])) . "' and CANCELL = '0' group by class";
	}

	if ($dev == 1) {
		$sql_rst = "Select class, SUM(GRAND_TOT) AS TOT FROM  view_salma_brand WHERE Accname != 'NON STOCK' and SAL_EX = '" . $m_rep . "' and DEV = '" . $dev . "' and month(SDATE) = '" . date("m", strtotime($_GET["dtMonth"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["dtMonth"])) . "' and CANCELL = '0' group by class  ";
	}

	$mbat = 0;
	$mtyre = 0;

	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
	while ($row_rst = mysqli_fetch_array($result_rst)) {
		if (trim($row_rst["class"]) == "BATTERY") {
			$mbat = $mbat + $row_rst["TOT"];
		} else {
			$mtyre = $mtyre + $row_rst["TOT"];
		}
	}

	$Sales_gridA11 = $mbat;
	$Sales_gridB11 = $mtyre;

	if ($dev == 0) {
		$sql_rst = "Select class, SUM(AMOUNT/(1+(VATRATE/100))) AS TOT FROM  view_cbal_brand WHERE SAL_EX = '" . $m_rep . "' and DEV = '" . $dev . "' and month(SDATE) = '" . date("m", strtotime($_GET["dtMonth"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["dtMonth"])) . "' and trn_type = 'GRN' and Cancell = '0' group by class";
	}

	if ($dev == 1) {
		$sql_rst = "Select class, SUM(AMOUNT) AS TOT FROM  view_cbal_brand WHERE SAL_EX = '" . $m_rep . "' and DEV = '" . $dev . "' and month(SDATE) = '" . date("m", strtotime($_GET["dtMonth"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["dtMonth"])) . "' and trn_type = 'GRN' and Cancell = '0' group by class";
	}

	$mbat = 0;
	$mtyre = 0;
	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
	while ($row_rst = mysqli_fetch_array($result_rst)) {

		if (trim($row_rst["class"]) == "BATTERY") {
			$mbat = $mbat + $row_rst["TOT"];
		} else {
			$mtyre = $mtyre + $row_rst["TOT"];
		}
	}

	$Sales_gridA21 = $mbat * -1;
	$Sales_gridB21 = $mtyre * -1;

	if ($dev == 0) {
		$sql_rst = "Select class, SUM(AMOUNT/(1+(VATRATE/100))) AS TOT FROM  view_cbal_brand WHERE SAL_EX = '" . $m_rep . "' and DEV = '" . $dev . "' and month(SDATE) = '" . date("m", strtotime($_GET["dtMonth"])) . "' and year(sdate) = '" . date("Y", strtotime($_GET["dtMonth"])) . "' and trn_type = 'CNT' and Cancell = '0' and flag1 != '1' group by class";
	}

	if ($dev == 1) {
		$sql_rst = "Select class, SUM(AMOUNT) AS TOT FROM  view_cbal_brand WHERE SAL_EX = '" . $m_rep . "' and DEV = '" . $dev . "' and month(SDATE) = '" . date("m", strtotime($_GET["dtMonth"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["dtMonth"])) . "' and trn_type = 'CNT' and Cancell = '0' and flag1 != '1' group by class";
	}

	$mbat = 0;
	$mtyre = 0;
	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
	while ($row_rst = mysqli_fetch_array($result_rst)) {

		if (trim($row_rst["class"]) == "BATTERY") {
			$mbat = $mbat + $row_rst["TOT"];
		} else {
			$mtyre = $mtyre + $row_rst["TOT"];
		}
	}

	$Sales_gridA31 = $mbat * -1;
	$Sales_gridB31 = $mtyre * -1;

	$Sales_gridA41 = $Sales_gridA11 + $Sales_gridA21 + $Sales_gridA31;
	$Sales_gridB41 = $Sales_gridB11 + $Sales_gridB21 + $Sales_gridB31;

	//============================================== 15% Tollarance ==========================================================

	$mretche = 0;
	$mout = 0;

	$sql_rst = "Select  sum(CR_CHEVAL-PAID) as retche  from  s_cheq  where S_REF='" . $m_rep . "' and CR_FLAG = '0' ";
	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
	$row_rst = mysqli_fetch_array($result_rst);
	if (is_null($row_rst["retche"]) == false) {
		$mretche = $row_rst["retche"];
	}

	$mdate = date('Y-m-d', strtotime("-61 days"));

	$sql_rst = "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where Accname != 'NON STOCK' and SAL_EX = '" . $m_rep . "' and SDATE <= '" . $mdate . "' and CANCELL = '0' and GRAND_TOT - TOTPAY > '1' ";

	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
	$row_rst = mysqli_fetch_array($result_rst);
	if (is_null($row_rst["out1"]) == false) {
		$mout = $row_rst["out1"];
	}

	//============================================== Calculating Total Sales =======================================================

	$msalA = 0;
	$msalTA = 0;
	$msalTB = 0;
	$msalB = 0;
	$msalC = 0;
	$msalD = 0;
	$msal = 0;
	$mretA = 0;
	$mretB = 0;
	$mretC = 0;
	$mretD = 0;
	$mret = 0;
	$mcrnA = 0;
	$mcrnB = 0;
	$mcrnC = 0;
	$mcrnD = 0;
	$mcrn = 0;
	$mnetA = 0;
	$mnetB = 0;
	$mnetC = 0;
	$mnetD = 0;
	$mnet = 0;
	$mretTB = 0;
	$mretTA = 0;
	$sql_rst = "Select  class, SUM(GRAND_TOT/(1+(GST/100))) AS TOT,SUM(GRAND_TOT) AS TOT1 FROM  view_salma_brand WHERE Accname != 'NON STOCK' and SAL_EX = '" . $m_rep . "'  and month(SDATE) = '" . date("m", strtotime($_GET["dtMonth"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["dtMonth"])) . "' and CANCELL = '0' group by class ";
	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
	while ($row_rst = mysqli_fetch_array($result_rst)) {

		if (trim($row_rst["class"]) == "BATTERY") {
			$msalA = $msalA + $row_rst["TOT"];
			$msalTA = $msalTA + $row_rst["TOT1"];
			$msal = $msal + $row_rst["TOT"];
		} else {
			$msalB = $msalB + $row_rst["TOT"];
			$msalTB = $msalTB + $row_rst["TOT1"];
			$msal = $msal + $row_rst["TOT"];
		}
	}

	$sql_rst = "Select class, SUM(AMOUNT/(1+(VATRATE/100))) AS TOT,sum(amount) as TOT1 FROM  view_cbal_brand WHERE SAL_EX = '" . $m_rep . "'  and month(SDATE) = '" . date("m", strtotime($_GET["dtMonth"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["dtMonth"])) . "' and trn_type = 'GRN' and Cancell = '0' group by class  ";
	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
	while ($row_rst = mysqli_fetch_array($result_rst)) {

		if (trim($row_rst["class"]) == "BATTERY") {
			$mretA = $mretA + $row_rst["TOT"];
			$mret = $mret + $row_rst["TOT"];
			$mretTA = ($mretTA + $row_rst["TOT1"]);
		} else {
			$mretB = $mretB + $row_rst["TOT"];
			$mret = $mret + $row_rst["TOT"];
			$mretTB = ($mretTB + $row_rst["TOT1"]);
		}
	}

	$sql_rst = "Select class, SUM(AMOUNT/(1+(VATRATE/100))) AS TOT,sum(amount) as TOT1 FROM  view_cbal_brand WHERE SAL_EX = '" . $m_rep . "' and month(SDATE) = '" . date("m", strtotime($_GET["dtMonth"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["dtMonth"])) . "' and trn_type = 'CNT' and Cancell = '0' and flag1 != '1' group by class";
	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
	while ($row_rst = mysqli_fetch_array($result_rst)) {

		if (trim($row_rst["class"]) == "BATTERY") {
			$mcrnA = $mcrnA + $row_rst["TOT"];
			$mcrn = $mcrn + $row_rst["TOT"];
			$mretTA = ($mretTA + $row_rst["TOT1"]);
		} else {
			$mcrnB = $mcrnB + $row_rst["TOT"];
			$mcrn = $mcrn + $row_rst["TOT"];
			$mretTB = ($mretTB + $row_rst["TOT1"]);
		}
	}

	
	$sql = "select * from s_salma where month(SDATE)='" . date("m", strtotime($_GET["dtMonth"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dtMonth"])) . "' and SAL_EX='" . $m_rep . "' and CANCELL='0'";
	
	$result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {

		$usr[] = "('" . $row["REF_NO"] . "', '" . $row["TRN_TYPE"] . "', '" . $row["SDATE"] . "', '" . $row["C_CODE"] . "', '" . $row["CUS_NAME"] . "', '" . $row["C_ADD1"] . "', '" . $row["TYPE"] . "', '" . $row["SAL_EX"] . "', " . $row["DISCOU"] . ", " . $row["AMOUNT"] . ", " . $row["GST"] . ", " . $row["GRAND_TOT"] . ", " . $row["DUMMY_VAL"] . ", " . $row["DIS"] . ", " . $row["DIS1"] . ", " . $row["DIS2"] . ", " . $row["DIS_RUP"] . ", " . $row["CASH"] . ", " . $row["TOTPAY"] . ", '" . $row["ORD_NO"] . "', '" . $row["ORD_DA"] . "', '" . $row["SETTLED"] . "', '" . $row["TOTPAY1"] . "', '" . $row["DES_CAT"] . "', '" . $row["DEPARTMENT"] . "', '" . $row["REMARK"] . "', '" . $row["CANCELL"] . "', '" . $row["BTT"] . "', '" . $row["VAT"] . "', " . $row["VAT_VAL"] . ", '" . $row["Brand"] . "', '" . $row["DEV"] . "', '" . $row["Account"] . "', '" . $row["Accname"] . "', '" . $row["Costcenter"] . "', " . $row["RET_AMO"] . ", " . $row["cre_pe"] . ", '" . $row["Comm"] . "', '" . $row["red"] . "', '" . $row["deli_date"] . "', '" . $row["seri_no"] . "', '" . $row["points"] . "', '" . $row["LOCK1"] . "', '" . $row["deliin"] . "', " . $row["SVAT"] . ", '" . $row["REQ_DATE"] . "', '" . $row["tmp_no"] . "', '" . $row["vat_no"] . "', '" . $row["s_vat_no"] . "', '" . $_SESSION['UserName'] . "')";

		$sql_sttr = "select * FROM s_sttr where ST_INVONO='" . $row["REF_NO"] . "'";
		$result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
		while ($row_sttr = mysqli_fetch_array($result_sttr)) {

			if (is_numeric($row_sttr["del_days"]) == false) {
				$del_days = 0;
			} else {
				$del_days = $row_sttr["del_days"];
			}
			
			
		$days = 0;
		$days = 0;
            if (trim($row_sttr["ST_FLAG"]) == "UT") {
                if ((!is_null($row['deli_date'])) and $row['deli_date'] != "0000-00-00") {
                    $diff = abs(strtotime($row_sttr["ST_DATE"]) - strtotime($row["deli_date"]));
                    $days = floor($diff / (60 * 60 * 24));
                } else {
                    $diff = abs(strtotime($row_sttr["ST_DATE"]) - strtotime($row["SDATE"]));
                    $days = floor($diff / (60 * 60 * 24));
                }
            } else {
                if ((!is_null($row['deli_date'])) and $row['deli_date'] != "0000-00-00") {
                    $diff = abs(strtotime($row_sttr["st_chdate"]) - strtotime($row["deli_date"]));
                    $days = floor($diff / (60 * 60 * 24));
                } else {
                    $diff = abs(strtotime($row_sttr["st_chdate"]) - strtotime($row["SDATE"]));
                    $days = floor($diff / (60 * 60 * 24));
                }
            }
        
        If (!is_null(($row_sttr["comm"]))) {
            If ($row_sttr["comm"] == "Yes") {
                $sql = "update s_sttr set del_days=" . $row_sttr["ap_days"] . " where id=" . $row_sttr["ID"] . " ";
                $result_st1 = mysqli_query($GLOBALS['dbinv'], $sql);
            } Else {
                 $sql = "update s_sttr set del_days=" . $days . " where id=" . $row_sttr["ID"] . " ";
				 $result_st1 = mysqli_query($GLOBALS['dbinv'], $sql);
		}
        } Else {
                $sql = "update s_sttr set del_days=" . $days . " where id=" . $row_sttr["ID"] . " ";
				$result_st1 = mysqli_query($GLOBALS['dbinv'], $sql);
        }
			
			
			

			$usr1[] = "(" . $row_sttr["ID"] . ", '" . $row_sttr["ST_REFNO"] . "', '" . $row_sttr["ST_DATE"] . "', '" . $row_sttr["ST_INVONO"] . "', " . $row_sttr["ST_PAID"] . ", '" . $row_sttr["ST_FLAG"] . "', '" . $row_sttr["ST_INDATE"] . "', '" . $row_sttr["st_chbank"] . "', " . $row_sttr["st_days"] . ", '" . $row_sttr["ST_CHNO"] . "', " . $row_sttr["DUE"] . ", " . $row_sttr["SETTLED_NO"] . ", '" . $row_sttr["DEV"] . "', " . $row_sttr["ret_chval"] . ", " . $row_sttr["ret_chset"] . ", '" . $row_sttr["st_chedate"] . "', '" . $row_sttr["st_chdate"] . "', '" . $row_sttr["cus_code"] . "', " . $row_sttr["ap_days"] . ", '" . $row_sttr["comm"] . "', '" . $row_sttr["ap_rem"] . "', " . $del_days . ", " . $row_sttr["deliin_days"] . ", " . $row_sttr["deliin_amo"] . ", '" . $row_sttr["deliin_lock"] . "', '" . $row_sttr["department"] . "', '" . $row_sttr["tmp_no"] . "', '" . $_SESSION['UserName'] . "')";
		}
	}

	$sql = "delete from tmp_s_salma";
	$result_st1 = mysqli_query($GLOBALS['dbinv'], $sql);
	$sql = "delete from tmp_s_sttr";
	$result_st1 = mysqli_query($GLOBALS['dbinv'], $sql);

	$sqli = "insert into tmp_s_salma (REF_NO, TRN_TYPE, SDATE, C_CODE, CUS_NAME, C_ADD1, TYPE, SAL_EX, DISCOU, AMOUNT, GST, GRAND_TOT, DUMMY_VAL, DIS, DIS1, DIS2, DIS_RUP, CASH, TOTPAY, ORD_NO, ORD_DA, SETTLED, TOTPAY1, DES_CAT, DEPARTMENT, REMARK, CANCELL, BTT, VAT, VAT_VAL, Brand, DEV, Account, Accname, Costcenter, RET_AMO, cre_pe, Comm, red, deli_date, seri_no, points, LOCK1, deliin, SVAT, REQ_DATE, tmp_no, vat_no, s_vat_no, userid) values" . implode(",", $usr);
	$result_st1 = mysqli_query($GLOBALS['dbinv'], $sqli);

	$sqli = "insert into tmp_s_sttr (ID, ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_INDATE, st_chbank, st_days, ST_CHNO, DUE, SETTLED_NO, DEV, ret_chval, ret_chset, st_chedate, st_chdate, cus_code, ap_days, comm, ap_rem, del_days, deliin_days, deliin_amo, deliin_lock, department, tmp_no, userid) values" . implode(",", $usr1);
	$result_st1 = mysqli_query($GLOBALS['dbinv'], $sqli);
	$day1 = 0;
	$day2 = 0;
	$mnpaid = 0;
	$mbat_c1 = 0;
	$Nbat_c1 = 0;
	$mtyre_c1 = 0;
	$Ntyre_c1 = 0;

	$mbat_c2 = 0;
	$Nbat_c2 = 0;
	$mtyre_c2 = 0;
	$Ntyre_c2 = 0;

	$mbat_nc = 0;
	$Nbat_nc = 0;
	$Ntyre_nc = 0;
	$mtyre_nc = 0;

	$sql = "delete from TMPCOMMITION";
	$result_st1 = mysqli_query($GLOBALS['dbinv'], $sql);

	$sql = "select * from tmp_s_salma where userid = '" . $_SESSION['UserName'] . "'";
	$result_st1 = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($rs_sal = mysqli_fetch_array($result_st1)) {
		$X = 0;
		$sqlat = "select * from com_she where sal_ex='" . $m_rep . "' and brand='" . Trim($rs_sal['Brand']) . "'";
		$result_st2 = mysqli_query($GLOBALS['dbinv'], $sqlat);
		if ($rs_cat = mysqli_fetch_array($result_st2)) {
			$day1 = $rs_cat['Day1'];
			$day2 = $rs_cat['Day2'];
		}

		$sql_rsven = "Select incdays from vendor where CODE = '" . trim($rs_sal["C_CODE"]) . "'";
		$result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
		if ($row_rsven = mysqli_fetch_array($result_rsven)) {
			if ($row_rsven["incdays"] > $day1) {
				$day1 = $row_rsven["incdays"] + 1;
				$day2 = $row_rsven["incdays"] + 1;
			}
		}

		if ($rs_sal["cre_pe"] > $day1) {
			$day1 = $rs_sal["cre_pe"] + 1;
			$day2 = $rs_sal["cre_pe"] + 1;
		}

		$sqlrst = "select * from   View_sttr_brand_salma where st_invono = '" . Trim($rs_sal["REF_NO"]) . "'  and del_days < " . $day1 . " and st_flag <> 'UT'";

		$result_rst = mysqli_query($GLOBALS['dbinv'], $sqlrst);

		while ($row_rst = mysqli_fetch_array($result_rst)) {

			If (Trim($row_rst["class"]) == "BATTERY") {
				$mbat_c1 = $mbat_c1 + $row_rst["ST_PAID"];
				$Nbat_c1 = $Nbat_c1 + ($row_rst["ST_PAID"] / (1 + ($row_rst["GST"] / 100)));
				$X = $X + $row_rst["ST_PAID"];
			} Else {
				$mtyre_c1 = $mtyre_c1 + $row_rst["ST_PAID"];
				$Ntyre_c1 = $Ntyre_c1 + ($row_rst["ST_PAID"] / (1 + ($row_rst["GST"] / 100)));
				$X = $X + $row_rst["ST_PAID"];
			}

			$sql = "Insert into TMPCOMMITION (sdate,refno,cos_code,amount,pay_date,pay_amount,dates,brand,type,dev,apdays,cus_name,pay_type,D_75,VAT) values ('" . $rs_sal["SDATE"] . "','" . $rs_sal["REF_NO"] . "', '" . $rs_sal["C_CODE"] . "', '" . $rs_sal["GRAND_TOT"] . "', '" . $row_rst["ST_DATE"] . "', '" . $row_rst["ST_PAID"] . "', '" . $row_rst["del_days"] . "','" . $rs_sal["Brand"] . "','" . $row_rst["class"] . "','" . $rs_sal["DEV"] . "'," . $day1 . ",'" . $rs_sal["CUS_NAME"] . "','CHQ','" . $row_rst["ST_PAID"] . "','" . $row_rst["GST"] . "')";
			$result_rstp = mysqli_query($GLOBALS['dbinv'], $sql);
			IF (!$result_rstp) {
				echo mysqli_error($GLOBALS['dbinv']);
			}
		}

		$sqlrst = "select * from   View_sttr_brand_salma where st_invono = '" . Trim($rs_sal["REF_NO"]) . "' and st_flag = 'UT'";
		$result_rst = mysqli_query($GLOBALS['dbinv'], $sqlrst);
		while ($row_rst = mysqli_fetch_array($result_rst)) {

			If (Trim($row_rst["class"]) == "BATTERY") {
				$mbat_c1 = $mbat_c1 + $row_rst["ST_PAID"];
				$Nbat_c1 = $Nbat_c1 + ($row_rst["ST_PAID"] / (1 + ($row_rst["GST"] / 100)));
				$X = $X + $row_rst["ST_PAID"];
			} Else {
				$mtyre_c1 = $mtyre_c1 + $row_rst["ST_PAID"];
				$Ntyre_c1 = $Ntyre_c1 + ($row_rst["ST_PAID"] / (1 + ($row_rst["GST"] / 100)));
				$X = $X + $row_rst["ST_PAID"];
			}

			$sql = "Insert into TMPCOMMITION (sdate,refno,cos_code,amount,pay_date,pay_amount,dates,brand,type,dev,apdays,cus_name,pay_type,D_75,VAT) values  ('" . $rs_sal["SDATE"] . "','" . $rs_sal["REF_NO"] . "', '" . $rs_sal["C_CODE"] . "', '" . $rs_sal["GRAND_TOT"] . "', '" . $row_rst["ST_DATE"] . "' ,'" . $row_rst["ST_PAID"] . "', '0','" . $rs_sal["Brand"] . "','" . $row_rst["class"] . "','" . $rs_sal["DEV"] . "','0','" . $rs_sal["CUS_NAME"] . "','UT','" . $row_rst["ST_PAID"] . "','" . $row_rst["GST"] . "')";
			$result_rstp = mysqli_query($GLOBALS['dbinv'], $sql);
			IF (!$result_rstp) {
				echo mysqli_error($GLOBALS['dbinv']);
			}
		}

		$sqlrst = "select * from   View_sttr_brand_salma where st_invono = '" . Trim($rs_sal["REF_NO"]) . "' and del_days >= " . $day1 . " and del_days < " . $day2 . " and st_flag <> 'UT' ";
		$result_rst = mysqli_query($GLOBALS['dbinv'], $sqlrst);
		while ($row_rst = mysqli_fetch_array($result_rst)) {

			If (Trim($row_rst["class"]) == "BATTERY") {
				$mbat_c2 = $mbat_c2 + $row_rst["ST_PAID"];
				$Nbat_c2 = $Nbat_c2 + ($row_rst["ST_PAID"] / (1 + ($row_rst["GST"] / 100)));
				$X = $X + $row_rst["ST_PAID"];
			} Else {
				$mtyre_c2 = $mtyre_c2 + $row_rst["ST_PAID"];
				$Ntyre_c2 = $Ntyre_c2 + ($row_rst["ST_PAID"] / (1 + ($row_rst["GST"] / 100)));
				$X = $X + $row_rst["ST_PAID"];
			}

			$sql = "Insert into TMPCOMMITION (sdate,refno,cos_code,amount,pay_date,pay_amount,dates,brand,type,dev,apdays,cus_name,pay_type,D_76_90,VAT) values ('" . $rs_sal["SDATE"] . "','" . $rs_sal["REF_NO"] . "', '" . $rs_sal["C_CODE"] . "', '" . $rs_sal["GRAND_TOT"] . "','" . $row_rst["ST_DATE"] . "', '" . $row_rst["ST_PAID"] . "', '" . $row_rst["del_days"] . "','" . $rs_sal["Brand"] . "','" . $row_rst["class"] . "','" . $rs_sal["DEV"] . "','" . $day2 . "','" . $rs_sal["CUS_NAME"] . "','CHQ','" . $row_rst["ST_PAID"] . "','" . $row_rst["GST"] . "')";
			$result_rstp = mysqli_query($GLOBALS['dbinv'], $sql);
			IF (!$result_rstp) {
				echo mysqli_error($GLOBALS['dbinv']);
			}
			
		}

		$sqlrst = "select * from   View_sttr_brand_salma where st_invono = '" . Trim($rs_sal["REF_NO"]) . "' and del_days >= " . $day2 . "  and st_flag <> 'UT' ";
		$result_rst = mysqli_query($GLOBALS['dbinv'], $sqlrst);
		while ($row_rst = mysqli_fetch_array($result_rst)) {

			If (Trim($row_rst["class"]) == "BATTERY") {
				$mbat_nc = $mbat_nc + $row_rst["ST_PAID"];
				$Nbat_nc = $Nbat_nc + ($row_rst["ST_PAID"] / (1 + ($row_rst["GST"] / 100)));
				$X = $X + $row_rst["ST_PAID"];
			} Else {
				$mtyre_nc = $mtyre_nc + $row_rst["ST_PAID"];
				$Ntyre_nc = $Ntyre_nc + ($row_rst["ST_PAID"] / (1 + ($row_rst["GST"] / 100)));
				$X = $X + $row_rst["ST_PAID"];
			}

			$sql = "Insert into TMPCOMMITION (sdate,refno,cos_code,amount,pay_date,pay_amount,dates,brand,type,dev,apdays,cus_name,pay_type,D_91,VAT) values ('" . $rs_sal["SDATE"] . "','" . $rs_sal["REF_NO"] . "', '" . $rs_sal["C_CODE"] . "', '" . $rs_sal["GRAND_TOT"] . "','" . $row_rst["ST_DATE"] . "', '" . $row_rst["ST_PAID"] . "', '" . $row_rst["del_days"] . "','" . $rs_sal["Brand"] . "','" . $row_rst["class"] . "','" . $rs_sal["DEV"] . "','" . $day2 . "','" . $rs_sal["CUS_NAME"] . "','CHQ','" . $row_rst["ST_PAID"] . "','" . $row_rst["GST"] . "')";
			$result_rstp = mysqli_query($GLOBALS['dbinv'], $sql);
			IF (!$result_rstp) {
				echo mysqli_error($GLOBALS['dbinv']);
			}
		}

		$sql = "select sum(st_paid) as tot from   View_sttr_brand_salma where st_invono = '" . $rs_sal["REF_NO"] . "' and  sal_ex = '" . $m_rep . "' and del_days >= " . $day2 . " and st_flag <> 'UT'  and month(SDATE)='" . date("m", strtotime($_GET["dtMonth"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dtMonth"])) . "' and  brand = '" . $rs_sal["Brand"] . "'";
		$result_rst = mysqli_query($GLOBALS['dbinv'], $sql);
		IF ($row_rst = mysqli_fetch_array($result_rst)) {
			If (!Is_Null($row_rst['tot'])) {
				$mnpaid = $mnpaid + $row_rst['tot'];
			}
		}
	}

	$sql = "Select * FROM  View_cbal_brand WHERE sal_ex = '" . $m_rep . "' and month(SDATE)='" . date("m", strtotime($_GET["dtMonth"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dtMonth"])) . "' and trn_type <> 'DGRN' and trn_type <> 'REC' and trn_type <> 'ARN' and cancell = '0' and flag1 <> '1'   ";
	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($rs_cbal = mysqli_fetch_array($result_rst)) {
		If (Trim($rs_cbal["trn_type"]) == "GRN") {
			$sql = "select * from s_crnma where ref_no = '" . Trim($rs_cbal["REFNO"]) . "'";
			$result_rst1 = mysqli_query($GLOBALS['dbinv'], $sql);
			$rst = mysqli_fetch_array($result_rst1);
			$sql = "Insert into TMPCOMMITION (sdate,refno,cos_code,amount,brand,`type`,dev,cus_name,`return`,commission)
         values('" . $rs_cbal["SDATE"] . "','" . $rs_cbal["REFNO"] . "', '" . $rs_cbal["CUSCODE"] . "', '" . $rs_cbal["AMOUNT"] * -1 . "','" . $rs_cbal["brand"] . "','" . $rs_cbal["class"] . "','" . $rs_cbal["DEV"] . "','" . Trim($rst['CUS_NAME']) . "','" . $rs_cbal["AMOUNT"] . "', '" . ($rst["DUMMY_VAL"] + $rst["DIS1"]) . "')";
			$res = mysqli_query($GLOBALS['dbinv'], $sql);
			if (!$res) {
				echo $sql;
				echo mysqli_error($GLOBALS['dbinv']);
				die();
			}
		} Else {
			$sql = "select * from CRED where c_refno = '" . Trim($rs_cbal["REFNO"]) . "'";
			$result_rst1 = mysqli_query($GLOBALS['dbinv'], $sql);
			$rst = mysqli_fetch_array($result_rst1);
			$sql = "Insert into TMPCOMMITION (sdate,refno,cos_code,amount,brand,`type`,dev,`return`,commission)
        values('" . $rs_cbal["SDATE"] . "','" . $rs_cbal["REFNO"] . "', '" . $rs_cbal["CUSCODE"] . "', '" . $rs_cbal["AMOUNT"] * -1 . "','" . $rs_cbal["brand"] . "','" . $rs_cbal["class"] . "','" . $rs_cbal["DEV"] . "','" . $rs_cbal["AMOUNT"] . "', '" . ($rst["dummy_val"] + $rst["SETTLED"]) . "' )";
			$res = mysqli_query($GLOBALS['dbinv'], $sql);
			if (!$res) {
				echo $sql;
				echo mysqli_error($GLOBALS['dbinv']);
				die();
			}
		}
	}

	$mnetA = $msalA - ($mretA + $mcrnA);
	$mnetB = $msalB - ($mretB + $mcrnB);
	$mnetC = $msalC - ($mretC + $mcrnC);
	$mnet = $msal - ($mret + $mcrn);

	$mtol = $mretche + $mout;
	$m_nsal = $mnet;
	$TXTADJ = 0;
	if ($TXTADJ == "") {
		$TXTADJ = 0;
	}
	if ($m_nsal != "") {
		if ($m_nsal != 0) {
			$m_ratio = ($mtol + $TXTADJ) / ($m_nsal * 1.11) * 100;
		}
	}

	$txtra_per = $m_ratio;
	$txt_rded = 0;
	$C_RATEA = 0;
	$C_RATEB = 0;
	$C_RATEC = 0;
	$C_RATED = 0;

	if ($m_ratio <= 15) {
		if ($mnetA >= $Critaria_gridA21) {
			$C_RATEA = $Critaria_gridA22;
			$t_salA = $Critaria_gridA21;
			$Sales_gridA12 = $Sales_gridA11 * $Critaria_gridA22 / 100;
			$Sales_gridA22 = $Sales_gridA21 * $Critaria_gridA22 / 100;
			$Sales_gridA32 = $Sales_gridA31 * $Critaria_gridA22 / 100;
			$Sales_gridA42 = $Sales_gridA41 * $Critaria_gridA22 / 100;
		} else {
			if ($mnetA >= $Critaria_gridA11) {
				$C_RATEA = $Critaria_gridA12;
				$t_salA = $Critaria_gridA11;
				$Sales_gridA12 = $Sales_gridA11 * $Critaria_gridA12 / 100;
				$Sales_gridA22 = $Sales_gridA21 * $Critaria_gridA12 / 100;
				$Sales_gridA32 = $Sales_gridA31 * $Critaria_gridA12 / 100;
				$Sales_gridA42 = $Sales_gridA41 * $Critaria_gridA12 / 100;
			} else {
				$C_RATEA = $Critaria_gridA32;
				$t_salA = $Critaria_gridA31;
				$Sales_gridA12 = $Sales_gridA11 * $Critaria_gridA32 / 100;
				$Sales_gridA22 = $Sales_gridA21 * $Critaria_gridA32 / 100;
				$Sales_gridA32 = $Sales_gridA31 * $Critaria_gridA32 / 100;
				$Sales_gridA42 = $Sales_gridA41 * $Critaria_gridA32 / 100;
			}
		}
		if ($mnetB >= $Critaria_gridB21) {
			$C_RATEB = $Critaria_gridB22;
			$t_salB = $Critaria_gridB21;
			$Sales_gridB12 = $Sales_gridB11 * $Critaria_gridB22 / 100;
			$Sales_gridB22 = $Sales_gridB21 * $Critaria_gridB22 / 100;
			$Sales_gridB32 = $Sales_gridB31 * $Critaria_gridB22 / 100;
			$Sales_gridB42 = $Sales_gridB41 * $Critaria_gridB22 / 100;
		} else {
			if ($mnetB >= $Critaria_gridB11) {
				$C_RATEB = $Critaria_gridB12;
				$t_salB = $Critaria_gridB11;
				$Sales_gridB12 = $Sales_gridB11 * $Critaria_gridB12 / 100;
				$Sales_gridB22 = $Sales_gridB21 * $Critaria_gridB12 / 100;
				$Sales_gridB32 = $Sales_gridB31 * $Critaria_gridB12 / 100;
				$Sales_gridB42 = $Sales_gridB41 * $Critaria_gridB12 / 100;
			} else {
				$C_RATEB = $Critaria_gridB32;
				$t_salB = $Critaria_gridB31;
				$Sales_gridB12 = $Sales_gridB11 * $Critaria_gridB32 / 100;
				$Sales_gridB22 = $Sales_gridB21 * $Critaria_gridB32 / 100;
				$Sales_gridB32 = $Sales_gridB31 * $Critaria_gridB32 / 100;
				$Sales_gridB42 = $Sales_gridB41 * $Critaria_gridB32 / 100;
			}
		}
	} else {
		if ($mnetA >= $Critaria_gridA21) {
			$C_RATEA = $Critaria_gridA12;
			$t_salA = $Critaria_gridA21;
			$Sales_gridA12 = $Sales_gridA11 * $Critaria_gridA12 / 100;
			$Sales_gridA22 = $Sales_gridA21 * $Critaria_gridA12 / 100;
			$Sales_gridA32 = $Sales_gridA31 * $Critaria_gridA12 / 100;
			$Sales_gridA42 = $Sales_gridA41 * $Critaria_gridA12 / 100;
		} else {
			if ($mnetA >= $Critaria_gridA11) {
				$C_RATEA = $Critaria_gridA32;
				$t_salA = $Critaria_gridA11;
				$Sales_gridA12 = $Sales_gridA11 * $Critaria_gridA32 / 100;
				$Sales_gridA22 = $Sales_gridA21 * $Critaria_gridA32 / 100;
				$Sales_gridA32 = $Sales_gridA31 * $Critaria_gridA32 / 100;
				$Sales_gridA42 = $Sales_gridA41 * $Critaria_gridA32 / 100;
			} else {
				$C_RATEA = $Critaria_gridA32 / 2;
				$t_salA = $Critaria_gridA31;
				$Sales_gridA12 = $Sales_gridA11 * $Critaria_gridA32 / 2 / 100;
				$Sales_gridA22 = $Sales_gridA21 * $Critaria_gridA32 / 2 / 100;
				$Sales_gridA32 = $Sales_gridA31 * $Critaria_gridA32 / 2 / 100;
				$Sales_gridA42 = $Sales_gridA41 * $Critaria_gridA32 / 2 / 100;
			}
		}
		if ($mnetB >= $Critaria_gridB21) {
			$C_RATEB = $Critaria_gridB12;
			$t_salB = $Critaria_gridB21;
			$Sales_gridB12 = $Sales_gridB11 * $Critaria_gridB12 / 100;
			$Sales_gridB22 = $Sales_gridB21 * $Critaria_gridB12 / 100;
			$Sales_gridB32 = $Sales_gridB31 * $Critaria_gridB12 / 100;
			$Sales_gridB42 = $Sales_gridB41 * $Critaria_gridB12 / 100;
		} else {
			if ($mnetB >= $Critaria_gridB11) {
				$C_RATEB = $Critaria_gridB32;
				$t_salB = $Critaria_gridB11;
				$Sales_gridB12 = $Sales_gridB11 * $Critaria_gridB32 / 100;
				$Sales_gridB22 = $Sales_gridB21 * $Critaria_gridB32 / 100;
				$Sales_gridB32 = $Sales_gridB31 * $Critaria_gridB32 / 100;
				$Sales_gridB42 = $Sales_gridB41 * $Critaria_gridB32 / 100;
			} else {
				$C_RATEB = $Critaria_gridB32 / 2;
				$t_salB = $Critaria_gridB31;
				$Sales_gridB12 = $Sales_gridB11 * $Critaria_gridB32 / 2 / 100;
				$Sales_gridB22 = $Sales_gridB21 * $Critaria_gridB32 / 2 / 100;
				$Sales_gridB32 = $Sales_gridB31 * $Critaria_gridB32 / 2 / 100;
				$Sales_gridB42 = $Sales_gridB41 * $Critaria_gridB32 / 2 / 100;
			}
		}
		$txt_rded = (($Sales_gridA42 + $Sales_gridB42) * 60 / 100) * $m_ratio / 100;
	}
	$Sales_gridA13 = $Sales_gridA12 * 60 / 100;
	$Sales_gridA23 = $Sales_gridA22 * 60 / 100;
	$Sales_gridA33 = $Sales_gridA32 * 60 / 100;
	$Sales_gridA43 = $Sales_gridA42 * 60 / 100;

	$Sales_gridB13 = $Sales_gridB12 * 60 / 100;
	$Sales_gridB23 = $Sales_gridB22 * 60 / 100;
	$Sales_gridB33 = $Sales_gridB32 * 60 / 100;
	$Sales_gridB43 = $Sales_gridB42 * 60 / 100;

	$Comm_grid11 = $Sales_gridA43;
	$Comm_grid21 = $Sales_gridB43;
	$Comm_grid31 = $Sales_gridA43 + $Sales_gridB43;

	////////////////////Call Final_cal
	//new shan
	$Sales_gridA22 = $mbat_c1;
	$Sales_gridA32 = $mbat_c2;
	$Sales_gridA42 = $mbat_nc;
	$Sales_gridB22 = $mtyre_c1;
	$Sales_gridB32 = $mtyre_c2;
	$Sales_gridB42 = $mtyre_nc;

	if ($msalTA <> 0) {
		$Sales_gridA52 = ($Sales_gridA42 / ($msalTA - $mretTA)) * 100;
	}

	if ($msalTB <> 0) {
		$Sales_gridB52 = ($Sales_gridB42 / ($msalTB - $mretTB)) * 100;
	}

	$sql = "select class,sum(st_paid) as tot from   View_sttr_brand_salma where sal_ex = '" . $m_rep . "'  and year(SDATE)='" . date("Y", strtotime($_GET["dtMonth"])) . "' and month(SDATE)='" . date("m", strtotime($_GET["dtMonth"])) . "'  group by Class ";
	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql);
	$mbat = 0;
	$mtyre = 0;
	while ($row = mysqli_fetch_array($result_rst)) {
		If (Trim($row["class"]) == "BATTERY") {
			$mbat = $mbat + $row["tot"];
		} Else {
			$mtyre = $mtyre + $row["tot"];
		}
	}

	$Sales_gridA12 = $msalTA - $mbat;
	$Sales_gridB12 = $msalTB - $mtyre;

	$Sales_gridA51 = $mbat;
	$Sales_gridB51 = $mtyre;

	$mncom = $mnpaid / (($msalTA - $mretTA) + ($msalTB - $mretTB)) * 100;

	$sql = "Select * from  Sal_comm_new where sal_ex = '" . $m_rep . "'";
	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result_rst)) {
		If (Trim($row["D_group"]) == "Battery") {
			If ($row["T2"] < $mnetA) {
				If ($mncom < 15) {
					$txt_c1cA = $Nbat_c1 * $row["P2"] / 100;
					$txt_c2cA = $Nbat_c2 * $row["P1"] / 100;
					$txt_nccA = $Nbat_nc * ($row["P2"] - 0.5) / 100;
					$c1_b = $row["P2"];
					$c2_b = $row["P1"];
					$nc_b = $row["P2"] - 0.5;
				} Else {
					$txt_c1cA = $Nbat_c1 * $row["P1"] / 100;
					$txt_c2cA = $Nbat_c2 * $row["P3"] / 100;
					$txt_nccA = 0;
					$c1_b = $row["P2"];
					$c2_b = $row["P3"];
					$nc_b = 0;
				}
			} else {
				If ($row["T1"] < $mnetA) {
					If ($mncom < 15) {
						$txt_c1cA = $Nbat_c1 * $row["P1"] / 100;
						$txt_c2cA = $Nbat_c2 * $row["P3"] / 100;
						$txt_nccA = $Nbat_nc * ($row["P1"] - 0.5) / 100;
						$c1_b = $row["P1"];
						$c2_b = $row["P3"];
						$nc_b = $row["P1"] - 0.5;
					} Else {
						$txt_c1cA = $Nbat_c1 * $row["P3"] / 100;
						$txt_c2cA = $Nbat_c2 * ($row["P3"] / 2) / 100;
						$txt_nccA = 0;
						$c1_b = $row["P3"];
						$c2_b = $row["P3"] / 2;
						$nc_b = 0;
					}
				} else {
					If ($mncom < 15) {
						$txt_c1cA = $Nbat_c1 * $row["P3"] / 100;
						$txt_c2cA = $Nbat_c2 * ($row["P3"] / 2) / 100;
						$txt_nccA = $Nbat_nc * ($row["P3"] / 2) / 100;
						$c1_b = $row["P3"];
						$c2_b = $row["P3"] / 2;
						$nc_b = $row["P3"] / 2;
					} Else {
						$txt_c1cA = $Nbat_c1 * ($row["P3"] / 2) / 100;
						$txt_c2cA = $Nbat_c2 * ($row["P3"] / 4) / 100;
						$txt_nccA = 0;
						$c1_b = $row["P3"] / 2;
						$c2_b = $row["P3"] / 4;
						$nc_b = 0;
					}
				}
			}
		}//start tyre
		If (Trim($row["D_group"]) == "Tyres") {
			If ($row["T2"] < $mnetB) {
				If ($mncom < 15) {
					$txt_c1cB = $Ntyre_c1 * $row["P2"] / 100;
					$txt_c2cB = $Ntyre_c2 * $row["P1"] / 100;
					$txt_nccB = $Ntyre_nc * ($row["P2"]-0.25) / 100;
					$c1_t = $row["P2"];
					$c2_t = $row["P1"];
					$nc_t = $row["P2"] - 0.25;
				} Else {
					$txt_c1cB = $Ntyre_c1 * $row["P1"] / 100;
					$txt_c2cB = $Ntyre_c2 * $row["P3"] / 100;
					$txt_nccB = 0;
					$c1_t = $row["P2"];
					$c2_t = $row["P3"];
					$nc_t = 0;
				}
			} else {
				If ($row["T1"] < $mnetB) {
					If ($mncom < 15) {
						$txt_c1cB = $Ntyre_c1 * $row["P1"] / 100;
						$txt_c2cB = $Ntyre_c2 * $row["P3"] / 100;
						$txt_nccB = $Ntyre_nc * ($row["P1"]-0.25) / 100;
						$c1_t = $row["P1"];
						$c2_t = $row["P3"];
						$nc_t = $row["P1"] - 0.25;
					} Else {
						$txt_c1cB = $Ntyre_c1 * $row["P3"] / 100;
						$txt_c2cB = $Ntyre_c2 * $row["P3"] / 100;
						$txt_nccB = 0;
						$c1_t = $row["P3"];
						$c2_t = $row["P3"] / 2;
						$nc_t = 0;
					}
				} else {
					If ($mncom < 15) {
						$txt_c1cB = $Ntyre_c1 * $row["P3"] / 100;
						$txt_c2cB = $Ntyre_c2 * ($row["P3"] / 2) / 100;
						$txt_nccB = $Ntyre_nc * ($row["P3"] / 2) / 100;
						$c1_t = $row["P3"];
						$c2_t = $row["P3"] / 2;
						$nc_t = $row["P3"] / 2;
					} Else {
						$txt_c1cB = $Ntyre_c1 * ($row["P3"] / 2) / 100;
						$txt_c2cB = $Ntyre_c2 * ($row["P3"] / 4) / 100;
						$txt_nccB = 0;
						$c1_t = $row["P3"] / 2;
						$c2_t = $row["P3"] / 4;
						$nc_t = 0;
					}
				}
			}
		}
	}

	$inv_no = "";
	$sql = "select * from TMPCOMMITION";
	$result_rst = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($rst = mysqli_fetch_array($result_rst)) {
		If ($rst["AMOUNT"] > 0) {
			If (Trim($rst["REFNO"]) <> $inv_no) {
				$sql = "update s_salma set DUMMY_VAL=0  where ref_no='" . $rst["REFNO"] . "'";
				mysqli_query($GLOBALS['dbinv'], $sql);
			}
			$inv_no = Trim($rst["REFNO"]);

			$sql_cat = "select * from com_she where sal_ex='" . $_GET["cmbrep"] . "' and Brand='" . trim($rst["brand"]) . "'";
			$result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
			$row_cat = mysqli_fetch_array($result_cat);
			$day1 = $row_cat["Day1"];
			$day2 = $row_cat["Day2"];

			$sql_rsven = "Select incdays from vendor where CODE = '" . trim($rst["COS_CODE"]) . "'";
			$result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
			if ($row_rsven = mysqli_fetch_array($result_rsven)) {
				if ($row_rsven["incdays"] > $day1) {
					$day1 = $row_rsven["incdays"] + 1;
					$day2 = $row_rsven["incdays"] + 1;
				}
			}
			$sql_rsven = "Select cre_pe from s_salma where ref_no = '" . $rst["REFNO"] . "'";
			$result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
			if ($row_rsven = mysqli_fetch_array($result_rsven)) {
				if ($row_rsven["cre_pe"] > $day1) {
					$day1 = $row_rsven["cre_pe"] + 1;
					$day2 = $row_rsven["cre_pe"] + 1;
				}
			}

			If ($rst["DATES"] < $day1) {
				If (Trim($rst["type"]) == "BATTERY") {
					$sql = "update s_salma set DUMMY_VAL=dummy_val +" . ($rst["PAY_AMOUNT"] / (1 + ($rst["VAT"] / 100))) * ($c1_b / 100) . "   where ref_no='" . $rst["REFNO"] . "'";
					$res = mysqli_query($GLOBALS['dbinv'], $sql);
					$sql = "update TMPCOMMITION set commission=commission +" . ($rst["PAY_AMOUNT"] / (1 + ($rst["VAT"] / 100))) * ($c1_b / 100) . "   where refno='" . $rst["REFNO"] . "' and dates < " . $day1 . " AND pay_type = '" . Trim($rst["pay_type"]) . "' and id = '" . ($rst["id"]) . "' ";
					$res = mysqli_query($GLOBALS['dbinv'], $sql);
				} Else {
					$sql = "update s_salma set DUMMY_VAL=dummy_val +" . ($rst["PAY_AMOUNT"] / (1 + ($rst["VAT"] / 100))) * ($c1_t / 100) . "   where ref_no='" . $rst["REFNO"] . "'";
					$res = mysqli_query($GLOBALS['dbinv'], $sql);
					$sql = "update TMPCOMMITION set commission=commission +" . ($rst["PAY_AMOUNT"] / (1 + ($rst["VAT"] / 100))) * ($c1_t / 100) . "   where refno='" . $rst["REFNO"] . "' and dates < " . $day1 . " AND pay_type = '" . Trim($rst["pay_type"]) . "' and id = " . ($rst["id"]) . "";
					$res = mysqli_query($GLOBALS['dbinv'], $sql);
				}
			} Else {
				If (($rst["DATES"] >= $day1) And ($rst["DATES"] < $day2)) {
					If (Trim($rst["type"]) == "BATTERY") {
						$sql = "update s_salma set DUMMY_VAL=dummy_val +" . ($rst["PAY_AMOUNT"] / (1 + ($rst["VAT"] / 100))) * ($c2_b / 100) . "   where ref_no='" . $rst["REFNO"] . "'";
						$res = mysqli_query($GLOBALS['dbinv'], $sql);
						$sql = "update TMPCOMMITION set commission=commission +" . ($rst["PAY_AMOUNT"] / (1 + ($rst["VAT"] / 100))) * ($c2_b / 100) . "   where refno='" . $rst["REFNO"] . "' and dates >= " . $day1 . " and dates < " . $day2 . " AND pay_type = '" . Trim($rst["pay_type"]) . "' and id = " . ($rst["id"]) . "";
						$res = mysqli_query($GLOBALS['dbinv'], $sql);
					} Else {
						$sql = "update s_salma set DUMMY_VAL=dummy_val +" . ($rst["PAY_AMOUNT"] / (1 + ($rst["VAT"] / 100))) * ($c2_t / 100) . "   where ref_no='" . $rst["REFNO"] . "'";
						$res = mysqli_query($GLOBALS['dbinv'], $sql);
						$sql = "update TMPCOMMITION set commission=commission +" . ($rst["PAY_AMOUNT"] / (1 + ($rst["VAT"] / 100))) * ($c2_t / 100) . "   where refno='" . $rst["REFNO"] . "' and dates >= " . $day1 . " and dates < " . $day2 . " AND pay_type = '" . Trim($rst["pay_type"]) . "' and id = " . ($rst["id"]) . "";
						$res = mysqli_query($GLOBALS['dbinv'], $sql);
					}
				} Else {
					If (Trim($rst["type"] == "BATTERY")) {
						$sql = "update s_salma set DUMMY_VAL=dummy_val +" . ($rst["PAY_AMOUNT"] / (1 + ($rst["VAT"] / 100))) * ($nc_b / 100) . "   where ref_no='" . $rst["REFNO"] . "'";
						$res = mysqli_query($GLOBALS['dbinv'], $sql);
						$sql = "update TMPCOMMITION set commission=commission +" . ($rst["PAY_AMOUNT"] / (1 + ($rst["VAT"] / 100))) * ($nc_b / 100) . "   where refno='" . $rst["REFNO"] . "' and dates >= " . $day2 . " AND pay_type = '" . Trim($rst["pay_type"]) . "' and id = " . ($rst["id"]) . "";
						$res = mysqli_query($GLOBALS['dbinv'], $sql);
					} Else {
						$sql = "update s_salma set DUMMY_VAL=dummy_val +" . ($rst["PAY_AMOUNT"] / (1 + ($rst["VAT"] / 100))) * ($nc_t / 100) . "   where ref_no='" . $rst["REFNO"] . "'";
						$res = mysqli_query($GLOBALS['dbinv'], $sql);
						$sql = "update TMPCOMMITION set commission=commission +" . ($rst["PAY_AMOUNT"] / (1 + ($rst["VAT"] / 100))) * ($nc_t / 100) . "   where refno='" . $rst["REFNO"] . "' and dates >= " . $day2 . " AND pay_type = '" . Trim($rst["pay_type"]) . "' and id = " . ($rst["id"]) . "";
						$res = mysqli_query($GLOBALS['dbinv'], $sql);
					}
				}
			}
		}
	}

	$txt_cadv = $Comm_grid31;
	$txt_adv = $txt_cadv - $txt_rded;

	$mround_ad = $txt_adv / 1000;

	if ($mround_ad < 1) {
		$txt_radv = 0;
	} else {

		$mround_ad = number_format($mround_ad, 0, ".", "") * 1000;
		if ($mround_ad > ($txt_cadv - $txt_rded)) {
			$txt_radv = $mround_ad - 1000;
		} else {
			$txt_radv = $mround_ad;
		}
	}

	$X = 0;
	$i = 1;

	$Deduction_grid11 = $_GET['Deduction_grid11'];
	$Deduction_grid12 = str_replace(",", "", $_GET['Deduction_grid12']);
	$Deduction_grid21 = $_GET['Deduction_grid21'];
	$Deduction_grid22 = str_replace(",", "", $_GET['Deduction_grid22']);
	$Deduction_grid31 = $_GET['Deduction_grid31'];
	$Deduction_grid32 = str_replace(",", "", $_GET['Deduction_grid32']);
	$Deduction_grid41 = $_GET['Deduction_grid41'];
	$Deduction_grid42 = str_replace(",", "", $_GET['Deduction_grid42']);
	$Deduction_grid51 = $_GET['Deduction_grid51'];
	$Deduction_grid52 = str_replace(",", "", $_GET['Deduction_grid52']);

	$Deduction_grid61 = $_GET['Deduction_grid61'];
	$Deduction_grid62 = str_replace(",", "", $_GET['Deduction_grid62']);

	$Deduction_grid71 = $_GET['Deduction_grid71'];
	$Deduction_grid72 = str_replace(",", "", $_GET['Deduction_grid72']);

	$Deduction_grid81 = $_GET['Deduction_grid81'];
	$Deduction_grid82 = str_replace(",", "", $_GET['Deduction_grid82']);

	if ($Deduction_grid12 != "") {
		$X = $X + $Deduction_grid12;
	} else {
		$Deduction_grid12 = 0;
	}
	if ($Deduction_grid22 != "") {
		$X = $X + $Deduction_grid22;
	} else {
		$Deduction_grid22 = 0;
	}
	if ($Deduction_grid32 != "") {
		$X = $X + $Deduction_grid32;
	} else {
		$Deduction_grid32 = 0;
	}
	if ($Deduction_grid41 != "") {
		$X = $X + $Deduction_grid42;
	} else {
		$Deduction_grid42 = 0;
	}
	if ($Deduction_grid51 != "") {
		$X = $X + $Deduction_grid52;
	} else {
		$Deduction_grid52 = 0;
	}
	if ($Deduction_grid61 != "") {
		$X = $X + $Deduction_grid62;
	} else {
		$Deduction_grid62 = 0;
	}
	if ($Deduction_grid71 != "") {
		$X = $X + $Deduction_grid72;
	} else {
		$Deduction_grid72 = 0;
	}
	if ($Deduction_grid81 != "") {
		$X = $X + $Deduction_grid82;
	} else {
		$Deduction_grid82 = 0;
	}

	$txt_ded = $X;
	$txt_padv = $txt_radv - $txt_ded;

	/////////////////////////
	$mrefno = date("m/Y", strtotime($_GET["dtMonth"])) . "-" . $m_rep . "-" . $_GET["cmbdev"];
	$sql_rst = "Select * from s_commadva where refno = '" . trim($mrefno) . "' and FLAG='ADV'";
	$res = mysqli_query($GLOBALS['dbinv'], $sql_rst);
	if ($row = mysqli_fetch_array($res)) {
		$Deduction_grid22 = intval(str_replace(",", "", $row['advance']));
	}

	$totsal_grid11 = ($msalTA + $msalTB);
	$totsal_grid21 = ($mretTA + $mretTB);
	$totsal_grid31 = $Sales_gridB42 + $Sales_gridA42;
	$totsal_grid41 = $mncom;

	$Ratio_grid11 = $mout;
	$Ratio_grid21 = $mretche;
	$Ratio_grid31 = $mout + $mretche;

	$ResponseXML .= "<Sales_gridA11><![CDATA[" . number_format($msalTA, 2, ".", ",") . "]]></Sales_gridA11>";
	$ResponseXML .= "<Sales_gridA21><![CDATA[" . number_format(($mretTA * -1), 2, ".", ",") . "]]></Sales_gridA21>";
	$ResponseXML .= "<Sales_gridA31><![CDATA[" . number_format(($msalTA - $mretTA), 2, ".", ",") . "]]></Sales_gridA31>";
	$ResponseXML .= "<Sales_gridA41><![CDATA[" . number_format($Sales_gridA41, 2, ".", ",") . "]]></Sales_gridA41>";

	$ResponseXML .= "<Sales_gridB11><![CDATA[" . number_format($msalTB, 2, ".", ",") . "]]></Sales_gridB11>";
	$ResponseXML .= "<Sales_gridB21><![CDATA[" . number_format(($mretTB * -1), 2, ".", ",") . "]]></Sales_gridB21>";
	$ResponseXML .= "<Sales_gridB31><![CDATA[" . number_format(($msalTB - $mretTB), 2, ".", ",") . "]]></Sales_gridB31>";
	$ResponseXML .= "<Sales_gridB41><![CDATA[" . number_format($Sales_gridB41, 2, ".", ",") . "]]></Sales_gridB41>";

	$ResponseXML .= "<Critaria_gridA11><![CDATA[" . number_format($Critaria_gridA11, 2, ".", ",") . "]]></Critaria_gridA11>";
	$ResponseXML .= "<Critaria_gridA12><![CDATA[" . number_format($Critaria_gridA12, 2, ".", ",") . "]]></Critaria_gridA12>";
	$ResponseXML .= "<Critaria_gridA21><![CDATA[" . number_format($Critaria_gridA21, 2, ".", ",") . "]]></Critaria_gridA21>";
	$ResponseXML .= "<Critaria_gridA22><![CDATA[" . number_format($Critaria_gridA22, 2, ".", ",") . "]]></Critaria_gridA22>";
	$ResponseXML .= "<Critaria_gridA31><![CDATA[" . number_format($Critaria_gridA31, 2, ".", ",") . "]]></Critaria_gridA31>";
	$ResponseXML .= "<Critaria_gridA32><![CDATA[" . number_format($Critaria_gridA32, 2, ".", ",") . "]]></Critaria_gridA32>";

	$ResponseXML .= "<Critaria_gridB11><![CDATA[" . number_format($Critaria_gridB11, 2, ".", ",") . "]]></Critaria_gridB11>";
	$ResponseXML .= "<Critaria_gridB12><![CDATA[" . number_format($Critaria_gridB12, 2, ".", ",") . "]]></Critaria_gridB12>";
	$ResponseXML .= "<Critaria_gridB21><![CDATA[" . number_format($Critaria_gridB21, 2, ".", ",") . "]]></Critaria_gridB21>";
	$ResponseXML .= "<Critaria_gridB22><![CDATA[" . number_format($Critaria_gridB22, 2, ".", ",") . "]]></Critaria_gridB22>";
	$ResponseXML .= "<Critaria_gridB31><![CDATA[" . number_format($Critaria_gridB31, 2, ".", ",") . "]]></Critaria_gridB31>";
	$ResponseXML .= "<Critaria_gridB32><![CDATA[" . number_format($Critaria_gridB32, 2, ".", ",") . "]]></Critaria_gridB32>";

	$ResponseXML .= "<Sales_gridA12><![CDATA[" . number_format($Sales_gridA12, 2, ".", ",") . "]]></Sales_gridA12>";
	$ResponseXML .= "<Sales_gridA22><![CDATA[" . number_format($Sales_gridA22, 2, ".", ",") . "]]></Sales_gridA22>";
	$ResponseXML .= "<Sales_gridA32><![CDATA[" . number_format($Sales_gridA32, 2, ".", ",") . "]]></Sales_gridA32>";
	$ResponseXML .= "<Sales_gridA42><![CDATA[" . number_format($Sales_gridA42, 2, ".", ",") . "]]></Sales_gridA42>";

	$ResponseXML .= "<Sales_gridA23><![CDATA[" . number_format($txt_c1cA, 2, ".", ",") . "]]></Sales_gridA23>";
	$ResponseXML .= "<Sales_gridA33><![CDATA[" . number_format($txt_c2cA, 2, ".", ",") . "]]></Sales_gridA33>";
	$ResponseXML .= "<Sales_gridA43><![CDATA[" . number_format($txt_nccA, 2, ".", ",") . "]]></Sales_gridA43>";

	$ResponseXML .= "<Sales_gridB23><![CDATA[" . number_format($txt_c1cB, 2, ".", ",") . "]]></Sales_gridB23>";
	$ResponseXML .= "<Sales_gridB33><![CDATA[" . number_format($txt_c2cB, 2, ".", ",") . "]]></Sales_gridB33>";
	$ResponseXML .= "<Sales_gridB43><![CDATA[" . number_format($txt_nccB, 2, ".", ",") . "]]></Sales_gridB43>";

	$ResponseXML .= "<Sales_gridB51><![CDATA[" . number_format($Sales_gridB51, 2, ".", ",") . "]]></Sales_gridB51>";
	$ResponseXML .= "<Sales_gridA51><![CDATA[" . number_format($Sales_gridA51, 2, ".", ",") . "]]></Sales_gridA51>";

	$ResponseXML .= "<Sales_gridB52><![CDATA[" . number_format($Sales_gridB52, 2, ".", ",") . "]]></Sales_gridB52>";
	$ResponseXML .= "<Sales_gridA52><![CDATA[" . number_format($Sales_gridA52, 2, ".", ",") . "]]></Sales_gridA52>";

	$ResponseXML .= "<Sales_gridB12><![CDATA[" . number_format($Sales_gridB12, 2, ".", ",") . "]]></Sales_gridB12>";
	$ResponseXML .= "<Sales_gridB22><![CDATA[" . number_format($Sales_gridB22, 2, ".", ",") . "]]></Sales_gridB22>";
	$ResponseXML .= "<Sales_gridB32><![CDATA[" . number_format($Sales_gridB32, 2, ".", ",") . "]]></Sales_gridB32>";
	$ResponseXML .= "<Sales_gridB42><![CDATA[" . number_format($Sales_gridB42, 2, ".", ",") . "]]></Sales_gridB42>";

	$ResponseXML .= "<Sales_gridA13><![CDATA[" . number_format($Sales_gridA13, 2, ".", ",") . "]]></Sales_gridA13>";
	$ResponseXML .= "<Sales_gridA23><![CDATA[" . number_format($Sales_gridA23, 2, ".", ",") . "]]></Sales_gridA23>";
	$ResponseXML .= "<Sales_gridA33><![CDATA[" . number_format($Sales_gridA33, 2, ".", ",") . "]]></Sales_gridA33>";
	$ResponseXML .= "<Sales_gridA43><![CDATA[" . number_format($Sales_gridA43, 2, ".", ",") . "]]></Sales_gridA43>";

	$ResponseXML .= "<Sales_gridB13><![CDATA[" . number_format($Sales_gridB13, 2, ".", ",") . "]]></Sales_gridB13>";
	$ResponseXML .= "<Sales_gridB23><![CDATA[" . number_format($Sales_gridB23, 2, ".", ",") . "]]></Sales_gridB23>";
	$ResponseXML .= "<Sales_gridB33><![CDATA[" . number_format($Sales_gridB33, 2, ".", ",") . "]]></Sales_gridB33>";
	$ResponseXML .= "<Sales_gridB43><![CDATA[" . number_format($Sales_gridB43, 2, ".", ",") . "]]></Sales_gridB43>";

	$ResponseXML .= "<totsal_grid11><![CDATA[" . number_format($totsal_grid11, 2, ".", ",") . "]]></totsal_grid11>";
	$ResponseXML .= "<totsal_grid21><![CDATA[" . number_format($totsal_grid21, 2, ".", ",") . "]]></totsal_grid21>";
	$ResponseXML .= "<totsal_grid31><![CDATA[" . number_format($totsal_grid31, 2, ".", ",") . "]]></totsal_grid31>";
	$ResponseXML .= "<totsal_grid41><![CDATA[" . number_format($totsal_grid41, 2, ".", ",") . "]]></totsal_grid41>";

	$ResponseXML .= "<Ratio_grid11><![CDATA[" . number_format($Ratio_grid11, 2, ".", ",") . "]]></Ratio_grid11>";
	$ResponseXML .= "<Ratio_grid21><![CDATA[" . number_format($Ratio_grid21, 2, ".", ",") . "]]></Ratio_grid21>";
	$ResponseXML .= "<Ratio_grid31><![CDATA[" . number_format($Ratio_grid31, 2, ".", ",") . "]]></Ratio_grid31>";

	$ResponseXML .= "<Comm_grid11><![CDATA[" . number_format($Comm_grid11, 2, ".", ",") . "]]></Comm_grid11>";
	$ResponseXML .= "<Comm_grid21><![CDATA[" . number_format($Comm_grid21, 2, ".", ",") . "]]></Comm_grid21>";
	$ResponseXML .= "<Comm_grid31><![CDATA[" . number_format($Comm_grid31, 2, ".", ",") . "]]></Comm_grid31>";

	$ResponseXML .= "<txt_cadv><![CDATA[" . number_format($txt_cadv, 2, ".", ",") . "]]></txt_cadv>";
	$ResponseXML .= "<txt_rded><![CDATA[" . number_format($txt_rded, 2, ".", ",") . "]]></txt_rded>";
	$ResponseXML .= "<txt_adv><![CDATA[" . number_format($txt_adv, 2, ".", ",") . "]]></txt_adv>";

	$ResponseXML .= "<txt_radv><![CDATA[" . number_format($txt_radv, 2, ".", ",") . "]]></txt_radv>";
	$ResponseXML .= "<txt_ded><![CDATA[" . number_format($txt_ded, 2, ".", ",") . "]]></txt_ded>";
	$ResponseXML .= "<txt_padv><![CDATA[" . number_format($txt_padv, 2, ".", ",") . "]]></txt_padv>";

	$ResponseXML .= "<TXTADJ><![CDATA[" . number_format($TXTADJ, 2, ".", ",") . "]]></TXTADJ>";
	$ResponseXML .= "<txtra_per><![CDATA[" . number_format($txtra_per, 2, ".", ",") . "]]></txtra_per>";

	$ResponseXML .= "<Deduction_grid11><![CDATA[" . ($Deduction_grid11) . "]]></Deduction_grid11>";
	$ResponseXML .= "<Deduction_grid12><![CDATA[" . number_format($Deduction_grid12, 2, ".", ",") . "]]></Deduction_grid12>";
	$ResponseXML .= "<Deduction_grid21><![CDATA[" . ($Deduction_grid21) . "]]></Deduction_grid21>";
	$ResponseXML .= "<Deduction_grid22><![CDATA[" . number_format($Deduction_grid22, 2, ".", ",") . "]]></Deduction_grid22>";
	$ResponseXML .= "<Deduction_grid31><![CDATA[" . ($Deduction_grid31) . "]]></Deduction_grid31>";
	$ResponseXML .= "<Deduction_grid32><![CDATA[" . number_format($Deduction_grid32, 2, ".", ",") . "]]></Deduction_grid32>";
	$ResponseXML .= "<Deduction_grid41><![CDATA[" . ($Deduction_grid41) . "]]></Deduction_grid41>";
	$ResponseXML .= "<Deduction_grid42><![CDATA[" . number_format($Deduction_grid42, 2, ".", ",") . "]]></Deduction_grid42>";
	$ResponseXML .= "<Deduction_grid51><![CDATA[" . ($Deduction_grid51) . "]]></Deduction_grid51>";
	$ResponseXML .= "<Deduction_grid52><![CDATA[" . number_format($Deduction_grid52, 2, ".", ",") . "]]></Deduction_grid52>";
	$ResponseXML .= "<Deduction_grid61><![CDATA[" . ($Deduction_grid61) . "]]></Deduction_grid61>";
	$ResponseXML .= "<Deduction_grid62><![CDATA[" . number_format($Deduction_grid62, 2, ".", ",") . "]]></Deduction_grid62>";
	$ResponseXML .= "<Deduction_grid71><![CDATA[" . ($Deduction_grid71) . "]]></Deduction_grid71>";
	$ResponseXML .= "<Deduction_grid72><![CDATA[" . number_format($Deduction_grid72, 2, ".", ",") . "]]></Deduction_grid72>";
	$ResponseXML .= "<Deduction_grid81><![CDATA[" . ($Deduction_grid81) . "]]></Deduction_grid81>";
	$ResponseXML .= "<Deduction_grid82><![CDATA[" . number_format($Deduction_grid82, 2, ".", ",") . "]]></Deduction_grid82>";

	$ResponseXML .= "</salesdetails>";

	echo $ResponseXML;

	mysqli_close($GLOBALS['dbinv']);
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
?>