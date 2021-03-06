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

    if ($_SESSION["dev"] != "") {
        

        $sql = "Select strgin from invpara";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $tmpinvno = "000000" . $row["strgin"];
        $lenth = strlen($tmpinvno);
        $invno = trim("SGIN/ ") . substr($tmpinvno, $lenth - 8);
        $_SESSION["invno"] = $invno;

        $sql = "Select strgin from tmpinvpara";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $_SESSION["tmp_no_gin"] = "SGIN/" . $row["strgin"];

        $sql = "delete from tmp_gin_data where tmp_no='" . $_SESSION["tmp_no_gin"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql = "update tmpinvpara set strgin=strgin+1";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        echo $invno;
    } else {
        echo "no";
    }
}

if ($_GET["Command"] == "cancel_inv") {

    $sql = "select * from s_trn_stores where REFNO='" . $_GET["invno"] . "' and LEDINDI='GINR'";
    echo $sql . "</br>";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $sql1 = "update s_submas_stores set QTYINHAND=QTYINHAND-" . $row["QTY"] . " where STK_NO='" . $row["STK_NO"] . "' and STO_CODE='" . $row["DEPARTMENT"] . "'";
        echo $sql1 . "</br>";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }

    $sql = "select * from s_trn_stores where REFNO='" . $_GET["invno"] . "' and LEDINDI='GINI'";
    echo $sql . "</br>";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $sql1 = "update s_submas_stores set QTYINHAND=QTYINHAND+" . $row["QTY"] . " where STK_NO='" . $row["STK_NO"] . "' and STO_CODE='" . $row["DEPARTMENT"] . "'";
        echo $sql1 . "</br>";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }
    $sql1 = "delete from s_strginmas where REF_NO='" . $_GET["invno"] . "'";
    //echo $sql1."</br>";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

    $sql1 = "delete from s_trn_stores where REFNO='" . $_GET["invno"] . "'";
    //echo $sql1."</br>";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

 


    echo "Canceled!";
}

if ($_GET["Command"] == "add_tmp") {

    if ($_SESSION["tmp_no_gin"] != "") {
        $department = $_GET["from_dep"];

        $ResponseXML = "";
        $ResponseXML .= "<salesdetails>";

 

        $qty = str_replace(",", "", $_GET["qty"]);


        $sql = "Insert into tmp_gin_data (str_invno, str_code, str_description, partno, cur_qty, tmp_no)values 
			('" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', '" . $_GET['partno'] . "', " . $qty . ", '" . $_SESSION["tmp_no_gin"] . "') ";
        //$ResponseXML .= $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);


        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";

        $tot=0;
        $sql = "Select * from tmp_gin_data where tmp_no='" . $_SESSION["tmp_no_gin"] . "' order by id desc";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {
            $ResponseXML .= "<tr>                              
                             <td >" . $row['str_code'] . "</a></td>
							 <td >" . $row['str_description'] . "</a></td>
							 <td >" . $row['partno'] . "</a></td>
							 <td >" . number_format($row['cur_qty'], 2, ".", ",") . "</a></td>
							
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>";

         

            $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas_stores where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $department . "'") or die(mysqli_error());
            if ($rowqty = mysqli_fetch_array($sqlqty)) {
                $qty = $rowqty['QTYINHAND'];
            } else {
                $qty = 0;
            }
            $tot = $tot +$row['cur_qty'];
            $ResponseXML .= "<td >" . number_format($qty, 0, ".", ",") . "</a></td>
							 
                            </tr>";
        }

        $ResponseXML .= "   </table>]]></sales_table>";
        $ResponseXML .= "<chq_validity><![CDATA[yes]]></chq_validity>";
        $ResponseXML .= "<txttot><![CDATA[".$tot  . "]]></txttot>";

        $ResponseXML .= " </salesdetails>";

        //	}	


        echo $ResponseXML;
    } else {
        $ResponseXML = " <salesdetails>";
        $ResponseXML .= "<chq_validity><![CDATA[no]]></chq_validity>";
        $ResponseXML .= " </salesdetails>";

        echo $ResponseXML;
    }
}


if ($_GET["Command"] == "gin") {

    //$department=$_GET["department"];

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = "select * from s_strginmas where REF_NO='" . $_GET['invno'] . "' ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<REF_NO><![CDATA[" . $row['REF_NO'] . "]]></REF_NO>";
        $ResponseXML .= "<SDATE><![CDATA[" . $row['SDATE'] . "]]></SDATE>";
        $ResponseXML .= "<DEP_FROM><![CDATA[" . $row['DEP_FROM'] . "]]></DEP_FROM>";
        $ResponseXML .= "<DEP_TO><![CDATA[" . $row['DEP_TO'] . "]]></DEP_TO>";
        $ResponseXML .= "<AR_NO><![CDATA[" . $row['AR_NO'] . "]]></AR_NO>";
        $ResponseXML .= "<AR_DATE><![CDATA[" . $row['AR_DATE'] . "]]></AR_DATE>";

        $_SESSION["tmp_no_gin"] = $row['tmp_no'];

        $sql1 = "delete from tmp_gin_data where tmp_no='" . $_SESSION["tmp_no_gin"] . "'";
        //$ResponseXML .= $sql;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql1 = "select * from s_trn_stores where REFNO='" . $_GET['invno'] . "' and LEDINDI='GINR'";
        //$ResponseXML .= $sql1;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        while ($row1 = mysqli_fetch_array($result1)) {

            $sql3 = "select * from s_mas where STK_NO='" . $row1['STK_NO'] . "'";
            //$ResponseXML .= $sql3;
            $result3 = mysqli_query($GLOBALS['dbinv'],$sql3);
            $row3 = mysqli_fetch_array($result3);

            $sql2 = "Insert into tmp_gin_data (str_invno, str_code, str_description, partno, cur_qty, tmp_no)values 
			('" . $row1['REFNO'] . "', '" . $row1['STK_NO'] . "', '" . $row3['DESCRIPT'] . "', '" . $row3['PART_NO'] . "', " . $row1["QTY"] . ", '" . $row['tmp_no'] . "') ";
            //$ResponseXML .= $sql2;
            $result = mysqli_query($GLOBALS['dbinv'], $sql2);
        }


        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"50\"></td>
							  <td width=\"50\"></td>
                            </tr>";


        $sql = "Select * from tmp_gin_data where tmp_no='" . $_SESSION["tmp_no_gin"] . "'";
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {
            $ResponseXML .= "<tr>                              
                             <td  >" . $row['str_code'] . "</a></td>
							 <td  >" . $row['str_description'] . "</a></td>
							 <td  >" . $row['partno'] . "</a></td>
							 <td  >" . number_format($row['cur_qty'], 2, ".", ",") . "</a></td>
							
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>";

          

           // $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas_stores where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $department . "'") or die(mysqli_error());
           // if ($rowqty = mysqli_fetch_array($sqlqty)) {
           //     $qty = $rowqty['QTYINHAND'];
           // } else {
                $qty = 0;
           // }

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

    $sqlclass = mysqli_query($GLOBALS['dbinv'],"select class from brand_mas where barnd_name='" . trim($brand) . "'") or die(mysqli_error());
    if ($rowclass = mysqli_fetch_array($sqlclass)) {
        if (is_null($rowclass["class"]) == false) {
            $InvClass = $rowclass["class"];
        }
    }

    $sqloutinv = mysqli_query($GLOBALS['dbinv'],"select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and SAL_EX='" . trim($salesrep) . "' and class='" . $InvClass . "'") or die(mysqli_error());
    if ($rowoutinv = mysqli_fetch_array($sqloutinv)) {
        if (is_null($rowoutinv["totout"]) == false) {
            $OutInvAmt = $rowoutinv["totout"];
        }
    }

    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'],"SELECT * FROM s_invcheq WHERE che_date>'" . date("d-m-Y") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . trim($salesrep) . "'") or die(mysqli_error());
    while ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {

        $sqlsttr = mysqli_query($GLOBALS['dbinv'],"select * from s_sttr where ST_REFNO='" . trim($rowinvcheq["refno"]) . "' and ST_CHNO ='" . trim($rowinvcheq["cheque_no"]) . "'") or die(mysqli_error());
        while ($rowsttr = mysqli_fetch_array($sqlsttr)) {
            $sqlview_s_salma = mysqli_query($GLOBALS['dbinv'],"select class from view_s_salma where REF_NO='" . trim($rowsttr["ST_INVONO"]) . "'") or die(mysqli_error());
            if ($rowview_s_salma = mysqli_fetch_array($sqlview_s_salma)) {

                if (trim($rowview_s_salma["class"]) == $InvClass) {
                    $OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
                }
            }
        }
    }



    $pend_ret_set = 0;

    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'],"SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'" . date("d-m-Y") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
    if ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {
        if (is_null($rowinvcheq["che_amount"]) == false) {
            $pend_ret_set = $rowinvcheq["che_amount"];
        }
    }


    $sqlcheq = mysqli_query($GLOBALS['dbinv'],"Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='" . trim($salesrep) . "'") or die(mysqli_error());
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


    $sqlbr_trn = mysqli_query($GLOBALS['dbinv'],"select * from br_trn where Rep='" . trim($salesrep) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($cuscode) . "'") or die(mysqli_error());
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
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";


    $sql = "Select * from tmp_gin_data where str_invno='" . $_GET['invno'] . "' order by id desc";
    //echo $sql
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>                              
                             <td >" . $row['str_code'] . "</a></td>
							 <td >" . $row['str_description'] . "</a></td>
							 <td >" . $row['partno'] . "</a></td>
							 <td >" . number_format($row['cur_qty'], 2, ".", ",") . "</a></td>
							
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>";

        include_once("connectioni.php");

        $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas_stores where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $department . "'") or die(mysqli_error());
        if ($rowqty = mysqli_fetch_array($sqlqty)) {
            $qty = $rowqty['QTYINHAND'];
        } else {
            $qty = 0;
        }

        $ResponseXML .= "<td>" . $qty . "</a></td>
							 
                            </tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";


    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}


if ($_GET["Command"] == "update") {
    $sql = "update s_strginmas  set AR_DATE='" . $_GET["DTARdate"] . "', AR_NO='" . $_GET["txtarno"] . "' where  REF_NO='" . $_GET["invno"] . "'";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    echo "Updated";
}

if ($_GET["Command"] == "save_item") {

    if ($_SESSION["tmp_no_gin"] != "") {

        $sql = "select * from tmp_gin_data where tmp_no='" . $_SESSION["tmp_no_gin"] . "' ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row = mysqli_fetch_array($result)) {
            
        } else {
            exit("no item");
        }


        $_SESSION["CURRENT_DOC"] = 1;      //document ID
        $_SESSION["VIEW_DOC"] = false;     //view current document
        $_SESSION["FEED_DOC"] = true;       //save  current document
        $_GET["MOD_DOC"] = false;         //delete   current document
        $_GET["PRINT_DOC"] = false;       //get additional print   of  current document
        $_GET["PRICE_EDIT"] = false;       //edit selling price
        $_GET["CHECK_USER"] = false;       //check user permission again


        $sql = "Select strgin from invpara";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $tmpinvno = "000000" . $row["strgin"];
        $lenth = strlen($tmpinvno);
        $invno = trim("SGIN/ ") . substr($tmpinvno, $lenth - 8);
        $_SESSION["invno"] = $invno;

        $sql = "select * from s_strginmas where REF_NO='" . $invno . "' ";
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row = mysqli_fetch_array($result)) {
            echo "GIN Number alredy exists";
        } else {
            $sql2 = "select * from s_stomas where CODE='" . $_GET["from_dep"] . "' ";
            //echo $sql2;
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
            $row2 = mysqli_fetch_array($result2);
            $DESCRIPTION_from = $row2["DESCRIPTION"];

            $sql2 = "select * from s_stomas where CODE='" . $_GET["to_dep"] . "' ";
            //echo $sql2;
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
            $row2 = mysqli_fetch_array($result2);
            $DESCRIPTION_to = $row2["DESCRIPTION"];

            $sql1 = "insert into s_strginmas(SDATE, REF_NO, DEP_FROM, DEP_F_NAME, DEP_TO, DEP_T_NAME, AR_DATE, AR_NO, tmp_no) values ('" . $_GET["invdate"] . "', '" . $invno . "', '" . $_GET["from_dep"] . "', '" . $DESCRIPTION_from . "', '" . $_GET["to_dep"] . "', '" . $DESCRIPTION_to . "', '" . $_GET["DTARdate"] . "', '" . $_GET["txtarno"] . "', '" . $_SESSION["tmp_no_gin"] . "')";
            //echo $sql1;
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);



            $sql2 = "select * from tmp_gin_data where tmp_no='" . $_SESSION["tmp_no_gin"] . "' ";
            //echo $sql2;
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
            while ($row2 = mysqli_fetch_array($result2)) {

                $cur_qty = str_replace(",", "", $row2["cur_qty"]);

                $sqlbrand = "select * from s_mas where STK_NO='" . $row2["str_code"] . "'";
                $resultbrand = mysqli_query($GLOBALS['dbinv'],$sqlbrand);
                $rowbrand = mysqli_fetch_array($resultbrand);

                $sql1 = "insert into s_trn_stores(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values ('" . $row2["str_code"] . "', '" . $_GET["invdate"] . "', '" . $cur_qty . "', 'GINI', '" . $invno . "', '" . $_GET["from_dep"] . "', '', '" . $_SESSION['dev'] . "', '', '1', '')";
                //echo $sql1;
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                $sql1 = "insert into s_trn_stores_all(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO, brand) values ('" . $row2["str_code"] . "', '" . $_GET["invdate"] . "', '" . (-1 * $cur_qty) . "', 'GINI', '" . $invno . "', '" . $_GET["from_dep"] . "', '', '" . $_SESSION['dev'] . "', '', '1', '', '" . $rowbrand["BRAND_NAME"] . "')";
                //echo $sql1;
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                $sql1 = "insert into s_trn_stores(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values ('" . $row2["str_code"] . "', '" . $_GET["invdate"] . "', '" . $cur_qty . "', 'GINR', '" . $invno . "', '" . $_GET["to_dep"] . "', '', '" . $_SESSION['dev'] . "', '', '1', '')";
                //echo $sql1;
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                $sql1 = "insert into s_trn_stores_all(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO, brand) values ('" . $row2["str_code"] . "', '" . $_GET["invdate"] . "', '" . $cur_qty . "', 'GINR', '" . $invno . "', '" . $_GET["to_dep"] . "', '', '" . $_SESSION['dev'] . "', '', '1', '', '" . $rowbrand["BRAND_NAME"] . "')";
                //echo $sql1;
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);



                $sqlsub = "Select * from s_submas_stores where STK_NO='" . $row2["str_code"] . "' and STO_CODE='" . $_GET["to_dep"] . "'";
                //echo $sqlsub;
                $resultsub = mysqli_query($GLOBALS['dbinv'],$sqlsub);
                if ($rowsub = mysqli_fetch_array($resultsub)) {

                    $sql1 = "update s_submas_stores set QTYINHAND=QTYINHAND+" . $cur_qty . " where STK_NO='" . $row2["str_code"] . "' and STO_CODE='" . $_GET["to_dep"] . "'";
                    //echo $sql1;
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                } else {
                    $sql1 = "insert into s_submas_stores(STO_CODE, STK_NO, DESCRIPt, OPEN_STK, QTYINHAND) values ('" . $_GET["to_dep"] . "',  '" . $row2["str_code"] . "', '" . $row2["str_description"] . "', 0, " . $cur_qty . ")";
                    //echo $sql1;
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                }

                $sql1 = "update s_submas_stores set QTYINHAND=QTYINHAND-" . $cur_qty . " where STK_NO='" . $row2["str_code"] . "' and STO_CODE='" . $_GET["from_dep"] . "'";
                //echo $sql1;
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            }

            $sql1 = "update invpara set strgin=strgin+1";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);


            $sql = "delete from tmp_gin_data where tmp_no='" . $_SESSION["tmp_no_gin"] . "' ";
            //echo $sql;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            echo "Saved";
        }
    } else {
        echo "Sorry Please Login again !!!";
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