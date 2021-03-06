<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("connectioni.php");



////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////



if ($_GET["Command"] == "new_inv") {


    $_SESSION["insert"] = 1;

    /* 	$sql="Select CAS_INV_NO_m from invpara";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      $row = mysqli_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      $invno="INV".substr($tmpinvno, $lenth-7);
      echo $invno; */

    $sql = "Select ORD_NO from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["ORD_NO"];
    $lenth = strlen($tmpinvno);
    $invno = trim("ORD/ ") . substr($tmpinvno, $lenth - 8);
    $_SESSION["invno"] = $invno;

    $sql = "Select ORD_NO from tmpinvpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $_SESSION["tmp_no_purord"] = "ORD/" . $row["ORD_NO"];

    $sql1 = "delete from tmp_purord_data where tmp_no='" . $_SESSION["tmp_no_purord"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

    $sql1 = "update tmpinvpara set ORD_NO=ORD_NO+1";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

    echo $invno;
}


if ($_GET["Command"] == "add_tmp") {



    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $pur0 = 0;
    $con0 = 0;
    $ordqty = 0;
    $pur1 = 0;
    $con1 = 0;
    $open_stk = 0;
    $pur2 = 0;
    $con2 = 0;
    $pur3 = 0;
    $con3 = 0;
    $pur4 = 0;
    $con4 = 0;
    $pur5 = 0;
    $con5 = 0;
    $QTYINHAND = 0;
    $over90 = 0;
    $ord_qty1 = 0;
    $ord_qty2 = 0;
    $ord_qty3 = 0;
    $larqty = 0;
    $sql = "delete from tmppurcon where STK_NO='" . $_GET['itemcode'] . "' and user_nm = '" . $_SESSION["CURRENT_USER"] . "'";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql_s_mas = "select * from s_mas where stk_no ='" . $_GET['itemcode'] . "'";
    $result_s_mas = mysqli_query($GLOBALS['dbinv'], $sql_s_mas);
    if ($row_s_mas = mysqli_fetch_array($result_s_mas)) {

        $date = date("Y-m-d");
        $date = strtotime(date("Y-m-d", strtotime($date)) . " -91 days");
        $dt = date("Y-m-d", $date);

        $sql_rs = "select sum(REC_QTY) as stk from s_purtrn where STK_NO='" . $row_s_mas["STK_NO"] . "' and CANCEL='0' and SDATE > '" . $dt . "' ";
        $result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
        $row_rs = mysqli_fetch_array($result_rs);
        $mnewstk = 0;
        $munsold = 0;

        if (!is_null($row_rs["stk"])) {
            $mnewstk = $row_rs["stk"];
        }
        if ($row_s_mas["QTYINHAND"] > $mnewstk) {
            $munsold = $row_s_mas["QTYINHAND"] - $mnewstk;
        }

        $con[0] = 0;
        $con[1] = 0;
        $con[2] = 0;
        $con[3] = 0;
        $con[4] = 0;
        $con[5] = 0;
        $otherord = 0;
        $otherqty = 0;
        if (!is_null($row_s_mas["GEN_NO"])) {

            If (Trim($row_s_mas["GEN_NO"]) <> "") {
                $sql = "select stk_no,QTYINHAND from s_mas where gen_no='" . Trim($row_s_mas["GEN_NO"]) . "' and BRAND_NAME <> '" . Trim($row_s_mas["BRAND_NAME"]) . "' ";
                $result_LASTAR = mysqli_query($GLOBALS['dbinv'], $sql);
                While ($row_LASTAR = mysqli_fetch_array($result_LASTAR)) {
                    $sql = "select sum(ord_qty) as ord_qty from s_ordtrn where stk_no='" . $row_LASTAR['stk_no'] . "'and cancel=0 ";
                    $result_LASTAR1 = mysqli_query($GLOBALS['dbinv'], $sql);
                    While ($row_LASTAR1 = mysqli_fetch_array($result_LASTAR1)) {
                        if (!is_null($row_LASTAR1["ord_qty"])) {
                            $otherord = $otherord + $row_LASTAR1['ord_qty'];
                        }
                    }
                    $otherqty = $otherqty + $row_LASTAR['QTYINHAND'];
                }
            }
        }

        $sql_LASTAR = "SELECT * FROM s_trn  WHERE STK_NO='" . $row_s_mas["STK_NO"] . "' and LEDINDI='ARN' order by ID desc";
        $result_LASTAR = mysqli_query($GLOBALS['dbinv'], $sql_LASTAR);
        $row_LASTAR = mysqli_fetch_array($result_LASTAR);

        $STK_NO = $row_s_mas["STK_NO"];
        if (!is_null($row_s_mas["DESCRIPT"])) {
            $desctript = $row_s_mas["DESCRIPT"];
        }
        if (!is_null($row_s_mas["PART_NO"])) {
            $PART_NO = $row_s_mas["PART_NO"];
        }
        if (!is_null($row_s_mas["GROUP3"])) {
            $group3 = $row_s_mas["GROUP3"];
        }

        if (!is_null($row_LASTAR["REFNO"])) {
            $arno = $row_LASTAR["REFNO"];
        } else {
            $arno = "";
        }
        if (!is_null($row_LASTAR["SDATE"])) {
            $ardate = $row_LASTAR["SDATE"];
        } else {
            $ardate = "";
        }
        if (!is_null($row_LASTAR["QTY"])) {
            $larqty = $row_LASTAR["QTY"];
        }

        $ordqty = 0;
        $sql = "select sum(ord_qty) as ord_qty from s_ordtrn where stk_no='" . $row_s_mas["STK_NO"] . "'and cancel=0 ";
        $result_LASTAR1 = mysqli_query($GLOBALS['dbinv'], $sql);
        While ($row_LASTAR1 = mysqli_fetch_array($result_LASTAR1)) {
            if (!is_null($row_LASTAR1["ord_qty"])) {
                $ordqty = $row_LASTAR1['ord_qty'];
            }
        }

        $open_stk = 0;

        $date = date("Y-m-d");
        $dateyear = date("Y");
        $mon = intval((date("m", strtotime($date))));
        $mon = $mon - 1;

        $month1 = date("Y-m", strtotime(date("Y-m")));
        if ($month1 == "$dateyear-01") {
            $mon = 12;
        }

        if ($mon == 12) {
            $con0 = $row_s_mas["SALE12"];
            $con1 = $row_s_mas["SALE11"];
            $con2 = $row_s_mas["SALE10"];
            $con3 = $row_s_mas["SALE09"];
            $con4 = $row_s_mas["SALE08"];
            $con5 = $row_s_mas["SALE09"];
        }
        if ($mon == 01) {
            $con0 = $row_s_mas["SALE01"];
            $con1 = $row_s_mas["SALE12"];
            $con2 = $row_s_mas["SALE11"];
            $con3 = $row_s_mas["SALE10"];
            $con4 = $row_s_mas["SALE09"];
            $con5 = $row_s_mas["SALE08"];
        }
        if ($mon == 2) {
            $con0 = $row_s_mas["SALE02"];
            $con1 = $row_s_mas["SALE01"];
            $con2 = $row_s_mas["SALE12"];
            $con3 = $row_s_mas["SALE11"];
            $con4 = $row_s_mas["SALE10"];
            $con5 = $row_s_mas["SALE09"];
        }
        if ($mon == 3) {
            $con0 = $row_s_mas["SALE03"];
            $con1 = $row_s_mas["SALE02"];
            $con2 = $row_s_mas["SALE01"];
            $con3 = $row_s_mas["SALE12"];
            $con4 = $row_s_mas["SALE11"];
            $con5 = $row_s_mas["SALE10"];
        }
        if ($mon == 4) {
            $con0 = $row_s_mas["SALE04"];
            $con1 = $row_s_mas["SALE03"];
            $con2 = $row_s_mas["SALE02"];
            $con3 = $row_s_mas["SALE01"];
            $con4 = $row_s_mas["SALE12"];
            $con5 = $row_s_mas["SALE11"];
        }
        if ($mon == 5) {
            $con0 = $row_s_mas["SALE05"];
            $con1 = $row_s_mas["SALE04"];
            $con2 = $row_s_mas["SALE03"];
            $con3 = $row_s_mas["SALE02"];
            $con4 = $row_s_mas["SALE01"];
            $con5 = $row_s_mas["SALE12"];
        }
        if ($mon == 6) {
            $con0 = $row_s_mas["SALE06"];
            $con1 = $row_s_mas["SALE05"];
            $con2 = $row_s_mas["SALE04"];
            $con3 = $row_s_mas["SALE03"];
            $con4 = $row_s_mas["SALE02"];
            $con5 = $row_s_mas["SALE01"];
        }
        if ($mon == 7) {
            $con0 = $row_s_mas["SALE07"];
            $con1 = $row_s_mas["SALE06"];
            $con2 = $row_s_mas["SALE05"];
            $con3 = $row_s_mas["SALE04"];
            $con4 = $row_s_mas["SALE03"];
            $con5 = $row_s_mas["SALE02"];
        }
        if ($mon == 8) {
            $con0 = $row_s_mas["SALE08"];
            $con1 = $row_s_mas["SALE07"];
            $con2 = $row_s_mas["SALE06"];
            $con3 = $row_s_mas["SALE05"];
            $con4 = $row_s_mas["SALE04"];
            $con5 = $row_s_mas["SALE03"];
        }
        if ($mon == 9) {
            $con0 = $row_s_mas["SALE09"];
            $con1 = $row_s_mas["SALE08"];
            $con2 = $row_s_mas["SALE07"];
            $con3 = $row_s_mas["SALE06"];
            $con4 = $row_s_mas["SALE05"];
            $con5 = $row_s_mas["SALE04"];
        }
        if ($mon == 10) {
            $con0 = $row_s_mas["SALE10"];
            $con1 = $row_s_mas["SALE09"];
            $con2 = $row_s_mas["SALE08"];
            $con3 = $row_s_mas["SALE07"];
            $con4 = $row_s_mas["SALE06"];
            $con5 = $row_s_mas["SALE05"];
        }
        if ($mon == 11) {
            $con0 = $row_s_mas["SALE11"];
            $con1 = $row_s_mas["SALE10"];
            $con2 = $row_s_mas["SALE09"];
            $con3 = $row_s_mas["SALE08"];
            $con4 = $row_s_mas["SALE07"];
            $con5 = $row_s_mas["SALE06"];
        }

        if (is_null($row_s_mas["QTYINHAND"]) == false) {
            $QTYINHAND = $row_s_mas["QTYINHAND"];
        } else {
            $QTYINHAND = 0;
        }
        $over90 = $munsold;
//        if ($row_s_mas["active_t1"] == "0") {
        $usr[] = "('" . $STK_NO . "', '" . $desctript . "', '" . $PART_NO . "', '" . $group3 . "', '" . $arno . "', '" . $ardate . "', '" . $larqty . "', '" . $ord_qty1 . "', '" . $ord_qty2 . "', '" . $ord_qty3 . "', '" . $con0 . "', '" . $ordqty . "', '" . $con1 . "', '" . $open_stk . "',  '" . $con2 . "', '" . $con3 . "', '" . $con4 . "', '" . $con5 . "', '" . $QTYINHAND . "', '" . $over90 . "','" . $otherqty . "','" . $otherord . "','" . $_SESSION["CURRENT_USER"] . "')";
//        } else {
//            $msg = "Item Locked";
//        }
    }
    if (isset($usr)) {
        $sql_temp = "insert into tmppurcon(STK_NO, desctript, PART_NO, group3, arno, ardate, larqty, ord_qty1, ord_qty2, ord_qty3,   con0, ordqty,  con1, open_stk,  con2,  con3,  con4,  con5, QTYINHAND, over90,otherqty,otherord,user_nm) values " . implode(",", $usr);
        $result_temp = mysqli_query($GLOBALS['dbinv'], $sql_temp);
        if (!$result_temp) {
            echo mysqli_error($GLOBALS['dbinv']);
        }
    }
    $month = date("m", strtotime(date("Y-m-d")));
    $month = $month - 1;

    if ($month == 1) {
        $txtmon1 = "Aug";
        $txtmon2 = "Sep";
        $txtmon3 = "Oct";
        $txtmon4 = "Nov";
        $txtmon5 = "Dec";
        $txtmon6 = "Jan";
    }

    if ($month == 2) {
        $txtmon1 = "Sep";
        $txtmon2 = "Oct";
        $txtmon3 = "Nov";
        $txtmon4 = "Dec";
        $txtmon5 = "Jan";
        $txtmon6 = "Feb";
    }
    if ($month == 3) {
        $txtmon1 = "Oct";
        $txtmon2 = "Nov";
        $txtmon3 = "Dec";
        $txtmon4 = "Jan";
        $txtmon5 = "Feb";
        $txtmon6 = "Mar";
    }
    if ($month == 4) {
        $txtmon1 = "Nov";
        $txtmon2 = "Dec";
        $txtmon3 = "Jan";
        $txtmon4 = "Feb";
        $txtmon5 = "Mar";
        $txtmon6 = "Apr";
    }
    if ($month == 5) {
        $txtmon1 = "Dec";
        $txtmon2 = "Jan";
        $txtmon3 = "Feb";
        $txtmon4 = "Mar";
        $txtmon5 = "Apr";
        $txtmon6 = "May";
    }
    if ($month == 6) {
        $txtmon1 = "Jan";
        $txtmon2 = "Feb";
        $txtmon3 = "Mar";
        $txtmon4 = "Apr";
        $txtmon5 = "May";
        $txtmon6 = "Jun";
    }
    if ($month == 7) {
        $txtmon1 = "Feb";
        $txtmon2 = "Mar";
        $txtmon3 = "Apr";
        $txtmon4 = "May";
        $txtmon5 = "Jun";
        $txtmon6 = "Jul";
    }
    if ($month == 8) {
        $txtmon1 = "Mar";
        $txtmon2 = "Apr";
        $txtmon3 = "May";
        $txtmon4 = "Jun";
        $txtmon5 = "Jul";
        $txtmon6 = "Aug";
    }
    if ($month == 9) {
        $txtmon1 = "Apr";
        $txtmon2 = "May";
        $txtmon3 = "Jun";
        $txtmon4 = "Jul";
        $txtmon5 = "Aug";
        $txtmon6 = "Sep";
    }
    if ($month == 10) {
        $txtmon1 = "May";
        $txtmon2 = "Jun";
        $txtmon3 = "Jul";
        $txtmon4 = "Aug";
        $txtmon5 = "Sep";
        $txtmon6 = "Oct";
    }
    if ($month == 11) {
        $txtmon1 = "Jun";
        $txtmon2 = "Jul";
        $txtmon3 = "Aug";
        $txtmon4 = "Sep";
        $txtmon5 = "Oct";
        $txtmon6 = "Nov";
    }
    if ($month == 12) {
        $txtmon1 = "Jul";
        $txtmon2 = "Aug";
        $txtmon3 = "Sep";
        $txtmon4 = "Oct";
        $txtmon5 = "Nov";
        $txtmon6 = "Dec";
    }

    function MonthName($mon) {
        switch ($mon) {
            case 1 :
                return "Jan";
            case 2 :
                return "Feb";
            case 3 :
                return "Mar";
            case 4 :
                return "Apr";
            case 5 :
                return "May";
            case 6 :
                return "Jun";
            case 7 :
                return "Jul";
            case 8 :
                return "Aug";
            case 9 :
                return "Sep";
            case 10 :
                return "Oct";
            case 11 :
                return "Nov";
            case 12 :
                return "Dec";
        }
    }

    $ResponseXML .= "<sales_table><![CDATA[";
    $ResponseXML .= "<table class='CSSTableGenerator'><tr>
		<th background='images/headingbg.gif' rowspan=\"2\" scope=\"col\">Stock No</th>
		<th background='images/headingbg.gif'  rowspan=\"2\" scope=\"col\">Description</th>
		<th background='images/headingbg.gif'  colspan='3' scope=\"col\">On Card</th>
		<th background='images/headingbg.gif'  colspan='2' rowspan=\"2\" scope=\"col\">Last AR </th>
		<th background='images/headingbg.gif'  colspan=\"12\" scope=\"col\">6 Months Consumption</th>
		<th background='images/headingbg.gif'  colspan=\"2\" scope=\"col\">On Order</th>
		<th background='images/headingbg.gif'  rowspan=\"2\" scope=\"col\">To Be order</th>
		</tr>
		<tr>
		
		<th scope=\"col\">Brand</th>
		<th scope=\"col\">Other</th>
		<th scope=\"col\">Over 90</th>
		<th colspan=\"2\" scope=\"col\">" . $txtmon1 . "</th>
		<th colspan=\"2\" scope=\"col\">" . $txtmon2 . "</th>
		<th colspan=\"2\" scope=\"col\">" . $txtmon3 . "</th>
		<th colspan=\"2\" scope=\"col\">" . $txtmon4 . "</th>
		<th colspan=\"2\" scope=\"col\">" . $txtmon5 . "</th>
		<th colspan=\"2\" scope=\"col\">" . $txtmon6 . "</th>
		<th scope=\"col\">Brand</th>
		<th scope=\"col\">Other</th>
		</tr>";
    //echo $sql;
    $totsort_val = 0;
    $totexceed_val = 0;

    $sql = "SELECT * from tmppurcon   where user_nm = '" . $_SESSION["CURRENT_USER"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $sql_mas = "select * from s_mas where STK_NO='" . $row["STK_NO"] . "'";
        $result_mas = mysqli_query($GLOBALS['dbinv'], $sql_mas);
        $row_mas = mysqli_fetch_array($result_mas);
        $ResponseXML .= '<tr>';
            if ($row_mas["active_t1"] == 1) {
                $ResponseXML .="<td bgcolor = \"#FF0000\">" . $row["STK_NO"] . "</td>";
            } else {
                $ResponseXML .="<td >" . $row["STK_NO"] . "</td>";
            }
        $ResponseXML .= " 
		<td>" . $row["desctript"] . "</td>
		<td align=\"right\">" . number_format($row["QTYINHAND"], 0, ".", ",") . "</td>
		<td align=\"right\">" . number_format($row["otherqty"], 0, ".", ",") . "</td>
		<td align=\"right\">" . number_format($row["over90"], 0, ".", ",") . "</td>
		<td>" . $row["ardate"] . "</td>
		<td align=\"right\">" . $row["larqty"] . "</td>";

        $ResponseXML .= "
		
		<td colspan='2' align=\"right\">" . number_format($row["con5"], 0, ".", ",") . "</td>
		
		<td colspan='2' align=\"right\">" . number_format($row["con4"], 0, ".", ",") . "</td>
		
		<td colspan='2' align=\"right\">" . number_format($row["con3"], 0, ".", ",") . "</td>
		
		<td colspan='2' align=\"right\">" . number_format($row["con2"], 0, ".", ",") . "</td>
		
		<td colspan='2' align=\"right\">" . number_format($row["con1"], 0, ".", ",") . "</td>
		
		<td colspan='2' align=\"right\">" . number_format($row["con0"], 0, ".", ",") . "</td>";

        $ResponseXML .= "<td align=\"right\">" . number_format($row["ordqty"], 0, ".", ",") . "</td>";
        $ResponseXML .= "<td align=\"right\">" . number_format($row["otherord"], 0, ".", ",") . "</td>";

        if ($row["over90"] > 0) {
            $over90 = $row["over90"];
        } else {
            $over90 = "";
        }

        //echo "<td align=\"right\">".number_format($over90, 2, ".", ",")."</td>";
        $ResponseXML .= "</tr>";
    }




    $ResponseXML .= "   </table>]]></sales_table>";
    $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";
    $ResponseXML .= " </salesdetails>";

    //	}	
    echo $ResponseXML;
}

if ($_GET["Command"] == "purord") {

    //$department=$_GET["department"];
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $_SESSION["update"] = 1;

    $sql = "select * from s_ordmas where REFNO='" . $_GET['invno'] . "' ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<REFNO><![CDATA[" . $row['REFNO'] . "]]></REFNO>";
        $ResponseXML .= "<SDATE><![CDATA[" . $row['SDATE'] . "]]></SDATE>";
        $ResponseXML .= "<SUP_CODE><![CDATA[" . $row['SUP_CODE'] . "]]></SUP_CODE>";
        $ResponseXML .= "<SUP_NAME><![CDATA[" . $row['SUP_NAME'] . "]]></SUP_NAME>";
        $ResponseXML .= "<REMARK><![CDATA[" . $row['REMARK'] . "]]></REMARK>";
        $ResponseXML .= "<DEP_CODE><![CDATA[" . $row['DEP_CODE'] . "]]></DEP_CODE>";
        $ResponseXML .= "<DEP_NAME><![CDATA[" . $row['DEP_NAME'] . "]]></DEP_NAME>";
        $ResponseXML .= "<REP_CODE><![CDATA[" . $row['REP_CODE'] . "]]></REP_CODE>";
        $ResponseXML .= "<REP_NAME><![CDATA[" . $row['REP_NAME'] . "]]></REP_NAME>";
        $ResponseXML .= "<S_date><![CDATA[" . $row['S_date'] . "]]></S_date>";
        $ResponseXML .= "<LC_No><![CDATA[" . $row['LC_No'] . "]]></LC_No>";
        $ResponseXML .= "<pi_no><![CDATA[" . $row['pi_no'] . "]]></pi_no>";
        $ResponseXML .= "<Brand><![CDATA[" . $row['Brand'] . "]]></Brand>";
        $_SESSION['tmp_no_purord'] = $row["tmp_no"];
    }

    $sql = "delete from tmp_purord_data where tmp_no='" . $_SESSION['tmp_no_purord'] . "' ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql = "select * from s_ordtrn where REFNO='" . $_GET['invno'] . "' ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $sql1 = "Insert into tmp_purord_data (tmp_no, str_invno, str_code, str_description, partno, qty)values 
				('" . $_SESSION['tmp_no_purord'] . "', '" . $row['REFNO'] . "', '" . $row['STK_NO'] . "', '" . $row['DESCRIPT'] . "', '" . $row["partno"] . "', " . $row["ORD_QTY"] . ") ";
        //$ResponseXML .= $sql;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }






    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"70\"  background=\"\" >Code</td>
                              <td width=\"300\"  background=\"\">Description</td>
                              <td width=\"100\"  background=\"\">Part No</td>
                              <td width=\"100\"  background=\"\">Qty</td>
                             
                            </tr>";


    $sql = "Select * from tmp_purord_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>                              
                             <td >" . $row['str_code'] . "</a></td>
							 <td>" . $row['str_description'] . "</a></td>
							 <td >" . $row['partno'] . "</a></td>
							 <td >" . number_format($row['qty'], 0, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td></tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}


if ($_GET["Command"] == "setord") {

    include_once("connectioni.php");

    $len = strlen($_GET["salesord1"]);
    $need = substr($_GET["salesord1"], $len - 7, $len);
    $salesord1 = trim("ORD/ ") . $_GET["salesrep"] . trim(" / ") . $need;


    $_SESSION["custno"] = $_GET['custno'];
    $_SESSION["brand"] = $_GET["brand"];
    $_SESSION["department"] = $_GET["department"];



    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];
    $salesrep = $_GET["salesrep"];
    $brand = $_GET["brand"];

    //		$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
    //Call SETLIMIT ====================================================================



    /* 	$sql = mysqli_query($GLOBALS['dbinv'],"DROP VIEW view_s_salma") or die(mysqli_error());
      $sql = mysqli_query($GLOBALS['dbinv'],"CREATE VIEW view_s_salma
      AS
      SELECT     s_salma.*, brand_mas.class AS class
      FROM         brand_mas RIGHT OUTER JOIN
      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysqli_error()); */

    $OutpDAMT = 0;
    $OutREtAmt = 0;
    $OutInvAmt = 0;
    $InvClass = "";

    $sqlclass = mysqli_query($GLOBALS['dbinv'], "select class from brand_mas where barnd_name='" . trim($brand) . "'") or die(mysqli_error());
    if ($rowclass = mysqli_fetch_array($sqlclass)) {
        if (is_null($rowclass["class"]) == false) {
            $InvClass = $rowclass["class"];
        }
    }

    $sqloutinv = mysqli_query($GLOBALS['dbinv'], "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and SAL_EX='" . trim($salesrep) . "' and class='" . $InvClass . "'") or die(mysqli_error());
    if ($rowoutinv = mysqli_fetch_array($sqloutinv)) {
        if (is_null($rowoutinv["totout"]) == false) {
            $OutInvAmt = $rowoutinv["totout"];
        }
    }

    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_invcheq WHERE che_date>'" . date("d-m-Y") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . trim($salesrep) . "'") or die(mysqli_error());
    while ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {

        $sqlsttr = mysqli_query($GLOBALS['dbinv'], "select * from s_sttr where ST_REFNO='" . trim($rowinvcheq["refno"]) . "' and ST_CHNO ='" . trim($rowinvcheq["cheque_no"]) . "'") or die(mysqli_error());
        while ($rowsttr = mysqli_fetch_array($sqlsttr)) {
            $sqlview_s_salma = mysqli_query($GLOBALS['dbinv'], "select class from view_s_salma where REF_NO='" . trim($rowsttr["ST_INVONO"]) . "'") or die(mysqli_error());
            if ($rowview_s_salma = mysqli_fetch_array($sqlview_s_salma)) {

                if (trim($rowview_s_salma["class"]) == $InvClass) {
                    $OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
                }
            }
        }
    }



    $pend_ret_set = 0;

    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'" . date("d-m-Y") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
    if ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {
        if (is_null($rowinvcheq["che_amount"]) == false) {
            $pend_ret_set = $rowinvcheq["che_amount"];
        }
    }


    $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='" . trim($salesrep) . "'") or die(mysqli_error());
    if ($rowcheq = mysqli_fetch_array($sqlcheq)) {
        if (is_null($rowcheq["tot"]) == false) {
            $OutREtAmt = $rowcheq["tot"];
        } else {
            $OutREtAmt = 0;
        }
    }



    $ResponseXML .= "<sales_table_acc><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>" . number_format($OutInvAmt, 2, ".", ",") . "</td></tr>
						 <td>Return Cheque Amount</td><td>" . number_format($OutREtAmt, 2, ".", ",") . "</td></tr>
						 <td>Pending Cheque Amount</td><td>" . number_format($OutpDAMT, 2, ".", ",") . "</td></tr>
						 <td>PSD Cheque Settlments</td><td>" . number_format($pend_ret_set, 2, ".", ",") . "</td></tr>
						 <td>Total</td><td>" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "</td></tr>
						 </table></table>]]></sales_table_acc>";


    $sqlbr_trn = mysqli_query($GLOBALS['dbinv'], "select * from br_trn where Rep='" . trim($salesrep) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($cuscode) . "'") or die(mysqli_error());
    if ($rowbr_trn = mysqli_fetch_array($sqlbr_trn)) {
        if (is_null($rowbr_trn["credit_lim"]) == false) {
            $crLmt = $rowbr_trn["credit_lim"];
        } else {
            $crLmt = 0;
        }


        if (is_null($rowbr_trn["tmpLmt"]) == false) {
            $tmpLmt = $rowbr_trn["tmpLmt"];
        } else {
            $tmpLmt = 0;
        }

        if (is_null($rowbr_trn["CAT"]) == false) {
            $cuscat = trim($rowbr_trn["cat"]);
            if ($cuscat = "A") {
                $m = 2.5;
            }
            if ($cuscat = "B") {
                $m = 2.5;
            }
            if ($cuscat = "C") {
                $m = 1;
            }
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
            $crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $txt_crebal = number_format($crebal, "2", ".", ",");
        } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
        }
        $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
    }
    $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
    $ResponseXML .= "<txt_crebal><![CDATA[" . $txt_crebal . "]]></txt_crebal>";

    $ResponseXML .= "<creditbalance><![CDATA[" . $creditbalance . "]]></creditbalance>";


    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "del_item") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_purord_data where str_code='" . $_GET['code'] . "' and tmp_no='" . $_SESSION["tmp_no_purord"] . "' ";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";


    $sql = "Select * from tmp_purord_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td >" . $row['str_code'] . "</a></td>
							 <td >" . $row['str_description'] . "</a></td>
							 <td >" . $row['partno'] . "</a></td>
							 <td >" . $row['qty'] . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td></tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";


    //	}	


    echo $ResponseXML;
}



if ($_GET["Command"] == "save_item") {

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    //	$_SESSION["CURRENT_DOC"] = 1;      //document ID
    //	$_SESSION["VIEW_DOC"] = false ;     //view current document
    //	$_SESSION["FEED_DOC"] = true;       //save  current document
    //	$_GET["MOD_DOC"] = false  ;         //delete   current document
    //	$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
    //	$_GET["PRICE_EDIT"] = false ;       //edit selling price
    //	$_GET["CHECK_USER"] = false ;       //check user permission again
    //$cre_balance=str_replace(",", "", $_GET["balance"]);


    $sql = "select * from s_ordmas where REFNO='" . $_GET["invno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    //echo $sql;
    if ($row = mysqli_fetch_array($result)) {
        $sql1 = "delete from s_ordmas where REFNO='" . $_GET["invno"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql1 = "delete from s_ordtrn where REFNO='" . $_GET["invno"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    } else {
        $sql = "Select ORD_NO from invpara";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $tmpinvno = "000000" . $row["ORD_NO"];
        $lenth = strlen($tmpinvno);
        $invno = trim("ORD/ ") . substr($tmpinvno, $lenth - 7);
        $_SESSION["invno"] = $invno;

        $sql1 = "update invpara set ORD_NO=ORD_NO+1";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }
    $sql1 = "select * from s_stomas where CODE='" . $_GET["department"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    $row1 = mysqli_fetch_array($result1);
    $dep_name = $row1["DESCRIPTION"];

    $sql1 = "select * from s_salrep where REPCODE='" . $_GET["salesrep"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    $row1 = mysqli_fetch_array($result1);
    $rep_name = $row1["Name"];

    $sql1 = "insert into s_ordmas(REFNO, SDATE, SUP_CODE, SUP_NAME, REMARK, DEP_CODE, DEP_NAME, REP_CODE, REP_NAME, cancel, S_date, LC_No, pi_no, Brand, tmp_no) values ('" . $_GET["invno"] . "', '" . $_GET["invdate"] . "', '" . $_GET["supplier_code"] . "','" . $_GET["supplier_name"] . "','" . $_GET["remarks"] . "','" . $_GET["department"] . "','" . $dep_name . "','" . $_GET["salesrep"] . "','" . $rep_name . "', '0','" . $_GET["dte_shedule"] . "','" . $_GET["lc_no"] . "', '" . $_GET["pi_no"] . "', '" . $_GET["brand"] . "',  '" . $_SESSION['tmp_no_purord'] . "')";
    //echo $sql1;
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);


    $sql = "select * from tmp_purord_data where tmp_no='" . $_SESSION['tmp_no_purord'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $sql1 = "insert into s_ordtrn(REFNO, SDATE, STK_NO, DESCRIPT, ORD_QTY, partno, CANCEL, tmp_no) values ('" . $row["str_invno"] . "', '" . $_GET["invdate"] . "', '" . $row["str_code"] . "','" . $row["str_description"] . "','" . $row["qty"] . "','" . $row["partno"] . "','0', '" . $_SESSION['tmp_no_purord'] . "')";
        //echo $sql1;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }
    //$_SESSION["print"]=1;


    echo "Saved";
}


if ($_GET["Command"] == "cancel_inv") {
    $sql1 = "update s_ordmas set cancel='1' where REFNO='" . $_GET["invno"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

    $sql1 = "update s_ordtrn set CANCEL='1' where REFNO='" . $_GET["invno"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    echo "Canceled!";
}

if ($_GET["Command"] == "check_print") {

    echo $_SESSION["print"];
}


if ($_GET["Command"] == "tmp_crelimit") {
    //echo "abc";
    $crLmt = 0;
    $cat = "";

    $rep = trim(substr($_GET["Com_rep1"], 0, 5));

    $sql = "select * from br_trn where rep='" . $rep . "' and cus_code='" . trim($_GET["txt_cuscode"]) . "' and brand='" . trim($_GET["cmbbrand1"]) . "'";
    echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $crLmt = $row["credit_lim"];
        If (is_null($row["cat"]) == false) {
            $cat = trim($row["cat"]);
        } else {
            $crLmt = 0;
        }
    }
    /* 	
      $_SESSION["CURRENT_DOC"] = 66     //document ID
      //$_SESSION["VIEW_DOC"] = true      //  view current document
      $_SESSION["FEED_DOC"] = true      //  save  current document
      //$_SESSION["MOD_DOC"] = true       //   delete   current document
      //$_SESSION["PRINT_DOC"] = true     // get additional print   of  current document
      //$_SESSION["PRICE_EDIT"]= true     // edit selling price
      $_SESSION["CHECK_USER"] = true    // check user permission again
      $crLmt = $crLmt;
      setlocale(LC_MONETARY, "en_US");
      $CrTmpLmt = number_format($_GET["txt_tmeplimit"], 2, ".", ",");

      $REFNO = trim($_GET["txt_cuscode"]) ;

      $AUTH_USER="tmpuser";

      $sql = "insert into tmpCrLmt (sdate, stime, username, tmpLmt, class, rep, cuscode, crLmt, cat) values
      ('".date("Y-m-d")."','".date("H:i:s", time())."' ,'".$AUTH_USER."',".$CrTmpLmt." ,'".trim($_GET["cmbbrand1"])."','".$rep."','".trim($_GET["txt_cuscode"])."',".$crLmt.",'".$cat"' )";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;

      $sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      if ($row = mysqli_fetch_array($result)) {
      $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
      $resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);

      } else {

      $sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
      $resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);

      //	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
      }

      If ($_GET["Check1"] == 1) {
      $sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
      $resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
      } else {
      $sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
      $resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
      }

      echo "Tempory limit updated"; */
}
?>