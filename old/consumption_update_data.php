<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("connectioni.php");



////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');



/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "process") {
    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";



    if ($_GET["cmbbrand"] == "All") {
        $strsql = "select STK_NO, DESCRIPT, SALE01, SALE02, SALE03, SALE04, SALE05, SALE06, SALE07, SALE08, SALE09, SALE10, SALE11, SALE12 from s_mas ORDER BY STK_NO";
    }

    if ($_GET["cmbbrand"] != "All") {
        $strsql = "select STK_NO, DESCRIPT, SALE01, SALE02, SALE03, SALE04, SALE05, SALE06, SALE07, SALE08, SALE09, SALE10, SALE11, SALE12 from s_mas where BRAND_NAME='" . trim($_GET["cmbbrand"]) . "' ORDER BY STK_NO";
    }

    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $strsql);
    while ($row_rs1 = mysqli_fetch_array($result_rs1)) {

        $Text1 = $row_rs1["STK_NO"];
        $ResponseXML .= "<Text1><![CDATA[" . $Text1 . "]]></Text1>";

        $str_sale = "select sum(QTY) as salqty from s_trn where  year(SDATE)=" . date("Y", strtotime($_GET["MonthView1"])) . " and  month(SDATE)=" . date("m", strtotime($_GET["MonthView1"])) . " and STK_NO='" . trim($row_rs1["STK_NO"]) . "' and LEDINDI = 'INV' ";
        $result_sale = mysqli_query($GLOBALS['dbinv'], $str_sale);
        $row_sale = mysqli_fetch_array($result_sale);

        $str_ret = "select sum(QTY) as retqty from s_trn where  year(SDATE)=" . date("Y", strtotime($_GET["MonthView1"])) . " and  month(SDATE)=" . date("m", strtotime($_GET["MonthView1"])) . " and STK_NO='" . trim($row_rs1["STK_NO"]) . "' and LEDINDI = 'GRN' ";
        $result_ret = mysqli_query($GLOBALS['dbinv'], $str_ret);
        $row_ret = mysqli_fetch_array($result_ret);


        $m_sal = 0;
        if (is_null($row_sale["salqty"]) == false) {
            $m_sal = $m_sal + $row_sale["salqty"];
        }
        if (is_null($row_ret["retqty"]) == false) {
            $m_sal = $m_sal - $row_ret["retqty"];
        }
        //echo date("m", strtotime($_GET["MonthView1"]));

        if (date("m", strtotime($_GET["MonthView1"])) == "01") {
            $sql = "update s_mas set SALE01= " . $m_sal . "  where STK_NO='" . $row_rs1["STK_NO"] . "'";
        }
        if (date("m", strtotime($_GET["MonthView1"])) == "02") {
            $sql = "update s_mas set SALE02= " . $m_sal . "  where STK_NO='" . $row_rs1["STK_NO"] . "'";
        }
        if (date("m", strtotime($_GET["MonthView1"])) == "03") {
            $sql = "update s_mas set SALE03= " . $m_sal . "  where STK_NO='" . $row_rs1["STK_NO"] . "'";
        }
        if (date("m", strtotime($_GET["MonthView1"])) == "04") {
            $sql = "update s_mas set SALE04= " . $m_sal . "  where STK_NO='" . $row_rs1["STK_NO"] . "'";
        }
        if (date("m", strtotime($_GET["MonthView1"])) == "05") {
            $sql = "update s_mas set SALE05= " . $m_sal . "  where STK_NO='" . $row_rs1["STK_NO"] . "'";
        }
        if (date("m", strtotime($_GET["MonthView1"])) == "06") {
            $sql = "update s_mas set SALE06= " . $m_sal . "  where STK_NO='" . $row_rs1["STK_NO"] . "'";
        }
        if (date("m", strtotime($_GET["MonthView1"])) == "07") {
            $sql = "update s_mas set SALE07= " . $m_sal . "  where STK_NO='" . $row_rs1["STK_NO"] . "'";
        }
        if (date("m", strtotime($_GET["MonthView1"])) == "08") {
            $sql = "update s_mas set SALE08= " . $m_sal . "  where STK_NO='" . $row_rs1["STK_NO"] . "'";
        }
        if (date("m", strtotime($_GET["MonthView1"])) == "09") {
            $sql = "update s_mas set SALE09= " . $m_sal . "  where STK_NO='" . $row_rs1["STK_NO"] . "'";
        }
        if (date("m", strtotime($_GET["MonthView1"])) == 10) {
            $sql = "update s_mas set SALE10= " . $m_sal . "  where STK_NO='" . $row_rs1["STK_NO"] . "'";
        }
        if (date("m", strtotime($_GET["MonthView1"])) == 11) {
            $sql = "update s_mas set SALE11= " . $m_sal . "  where STK_NO='" . $row_rs1["STK_NO"] . "'";
        }
        if (date("m", strtotime($_GET["MonthView1"])) == 12) {
            $sql = "update s_mas set SALE12= " . $m_sal . "  where STK_NO='" . $row_rs1["STK_NO"] . "'";
        }
        $Text2 = $m_sal;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $ResponseXML .= "<Text2><![CDATA[" . $Text2 . "]]></Text2>";
    }

    $msg = "complete";
    $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "new_inv") {


    /* 	$sql="Select CAS_INV_NO_m from invpara";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      $row = mysqli_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      $invno="INV".substr($tmpinvno, $lenth-7);
      echo $invno; */

    $sql = "Select adj from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["adj"];
    $lenth = strlen($tmpinvno);
    $invno = trim("ADJ/ ") . substr($tmpinvno, $lenth - 7);
    $_SESSION["invno"] = $invno;

    $sql = "delete from tmp_stock_adjust_data where str_invno='" . $invno . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    echo $invno;
}


if ($_GET["Command"] == "add_tmp") {

    $department = $_GET["from_dep"];

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_gin_data where str_code='" . $_GET['itemcode'] . "' and str_invno='" . $_GET['invno'] . "' ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    //echo $_GET['rate'];
    //echo $_GET['qty'];

    $qty = str_replace(",", "", $_GET["qty"]);


    $sql = "Insert into tmp_stock_adjust_data (str_invno, str_code, str_description, partno, cur_qty)values 
			('" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', '" . $_GET['partno'] . "', " . $qty . ") ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);


    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";


    $sql = "Select * from tmp_stock_adjust_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>                              
                             <td  >" . $row['str_code'] . "</a></td>
							 <td  >" . $row['str_description'] . "</a></td>
							 <td  >" . $row['partno'] . "</a></td>
							 <td  >" . number_format($row['cur_qty'], 2, ".", ",") . "</a></td>
							
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>
							 </tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";


    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}


if ($_GET["Command"] == "gin") {

    //$department=$_GET["department"];

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "select * from s_ginmas where REF_NO='" . $_GET['invno'] . "' ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<REF_NO><![CDATA[" . $row['REF_NO'] . "]]></REF_NO>";
        $ResponseXML .= "<SDATE><![CDATA[" . $row['SDATE'] . "]]></SDATE>";
        $ResponseXML .= "<DEP_FROM><![CDATA[" . $row['DEP_FROM'] . "]]></DEP_FROM>";
        $ResponseXML .= "<DEP_TO><![CDATA[" . $row['DEP_TO'] . "]]></DEP_TO>";


        $sql1 = "delete from tmp_gin_data where str_invno='" . $row['REF_NO'] . "'";
        //$ResponseXML .= $sql;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql1 = "select * from s_trn where REFNO='" . $_GET['invno'] . "' and LEDINDI='GINR'";
        //$ResponseXML .= $sql;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        while ($row1 = mysqli_fetch_array($result1)) {

            $sql3 = "select * from s_mas where STK_NO='" . $row1['STK_NO'] . "'";
            //$ResponseXML .= $sql;
            $result3 = mysqli_query($GLOBALS['dbinv'], $sql3);
            $row3 = mysqli_fetch_array($result3);

            $sql2 = "Insert into tmp_gin_data (str_invno, str_code, str_description, partno, cur_qty)values 
			('" . $row1['REF_NO'] . "', '" . $row1['STK_NO'] . "', '" . $row3['DESCRIPT'] . "', '" . $row3['PART_NO'] . "', " . $row1["QTY"] . ") ";
            //$ResponseXML .= $sql;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
        }


        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";


        $sql = "Select * from tmp_gin_data where str_invno='" . $_GET['invno'] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {
            $ResponseXML .= "<tr>                              
                             <td  >" . $row['str_code'] . "</a></td>
							 <td  >" . $row['str_description'] . "</a></td>
							 <td  >" . $row['partno'] . "</a></td>
							 <td  >" . number_format($row['cur_qty'], 2, ".", ",") . "</a></td>
							
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>";

            include_once("connectioni.php");

            $sqlqty = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $department . "'") or die(mysqli_error());
            if ($rowqty = mysqli_fetch_array($sqlqty)) {
                $qty = $rowqty['QTYINHAND'];
            } else {
                $qty = 0;
            }

            $ResponseXML .= "<td  >" . $qty . "</a></td>
							 
                            </tr>";
        }

        $ResponseXML .= "   </table>]]></sales_table>";
    }


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


    $sql = "delete from tmp_gin_data where str_code='" . $_GET['code'] . "' and str_invno='" . $_GET['invno'] . "' ";
    //echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";


    $sql = "Select * from tmp_gin_data where str_invno='" . $_GET['invno'] . "'";
    //echo $sql
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>                              
                             <td  >" . $row['str_code'] . "</a></td>
							 <td  >" . $row['str_description'] . "</a></td>
							 <td  >" . $row['partno'] . "</a></td>
							 <td  >" . number_format($row['cur_qty'], 2, ".", ",") . "</a></td>
							
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>";

        include_once("connectioni.php");

        $sqlqty = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $department . "'") or die(mysqli_error());
        if ($rowqty = mysqli_fetch_array($sqlqty)) {
            $qty = $rowqty['QTYINHAND'];
        } else {
            $qty = 0;
        }

        $ResponseXML .= "<td  >" . $qty . "</a></td>
							 
                            </tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";


    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}



if ($_GET["Command"] == "save_item") {



    $_SESSION["CURRENT_DOC"] = 1;      //document ID
    $_SESSION["VIEW_DOC"] = false;     //view current document
    $_SESSION["FEED_DOC"] = true;       //save  current document
    $_GET["MOD_DOC"] = false;         //delete   current document
    $_GET["PRINT_DOC"] = false;       //get additional print   of  current document
    $_GET["PRICE_EDIT"] = false;       //edit selling price
    $_GET["CHECK_USER"] = false;       //check user permission again


    $sql = "select * from inreq_mas where refno='" . $_GET["invno"] . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        echo "Stock Adjust Number alredy exists";
    } else {

        $sql1 = "insert into inreq_mas(refno, sdate, dep, trn_type, remark, CANCELL) values ('" . $_GET["invno"] . "', '" . $_GET["invdate"] . "', '" . $_GET["dep"] . "', '" . $_GET["ttype"] . "', '" . $_GET["spinst"] . "', '0')";
        //echo $sql1;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);


        $sql2 = "select * from tmp_stock_adjust_data where str_invno='" . $_GET["invno"] . "' ";
        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
        while ($row2 = mysqli_fetch_array($result2)) {

            $cur_qty = str_replace(",", "", $row2["cur_qty"]);

            $sql1 = "insert into inreq_trn(refno, sdate, stk_no, trn_type, qty, CANCELL) values ('" . $_GET["invno"] . "', '" . $_GET["invdate"] . "', '" . $row2["str_code"] . "', '" . $_GET["ttype"] . "', '" . $cur_qty . "', '0')";
            echo $sql1;
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            if ($_GET["ttype"] == "IIN") {
                $sql1 = "update s_mas set QTYINHAND=QTYINHAND+" . $cur_qty . " where STK_NO='" . $row2["str_code"] . "' ";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            } else if ($_GET["ttype"] == "IOU") {
                $sql1 = "update s_mas set QTYINHAND=QTYINHAND-" . $cur_qty . " where STK_NO='" . $row2["str_code"] . "' ";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            }

            if ($_GET["ttype"] == "IIN") {
                $sql1 = "update s_submas set QTYINHAND=QTYINHAND+" . $cur_qty . " where STK_NO='" . $row2["str_code"] . "' ";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            } else if ($_GET["ttype"] == "IOU") {
                $sql1 = "update s_submas set QTYINHAND=QTYINHAND-" . $cur_qty . " where STK_NO='" . $row2["str_code"] . "' ";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            }
        }

        $sql1 = "update invpara set adj=adj+1";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        echo "Saved";
    }
}



if ($_GET["Command"] == "tmp_crelimit") {
    echo "abc";
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