<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');


if ($_GET["Command"] == "brandsession") {
 
    $_SESSION["brand"]=$_GET["brand"];
 
}

if ($_GET["Command"] == "new_inv") {

    $sql = "select SPINV from invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();
    $tmpinvno = "000000" . ($row["SPINV"] + 1);
    $lenth = strlen($tmpinvno);
    $invno = trim("CRI/") . substr($tmpinvno, $lenth - 6) . "/" . $_GET["salesrep"];

    $sql = "Select SPINV from tmpinvpara";
    $result = $conn->query($sql);
    $row = $result->fetch();

    $tono = $row['SPINV'];

    $sql = "delete from tmp_inv_data where tmp_no='" . $tono . "'";
    $result = $conn->query($sql);

    $sql = "update tmpinvpara set SPINV=SPINV+1";
    $result = $conn->query($sql);
    $_SESSION["brand"]=$_GET["brand"];

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<tmpno><![CDATA[" . $tono . "]]></tmpno>";
    $ResponseXML .= "<sdate><![CDATA[" . date("Y-m-d") . "]]></sdate>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "cancel_inv") {


    $sql = "select last_update from invpara";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sqlinv = "select * from s_salma where REF_NO='" . $_GET["invno"] . "' ";
        $resultinv = $conn->query($sqlinv);
        if ($rowinv = $resultinv->fetch()) {
            // if (date("Y-m") !== date("Y-m", strtotime($rowinv["sdate1"]))) {
            //     //if (date("Y-m") == date("Y-m", strtotime($rowinv["SDATE"]))) {
            //     echo 'Not in Current Month Can not Cancel';
            //     exit();
            // }
            if (($rowinv["TOTPAY"] == 0) and ( $rowinv["SDATE"] > $row["last_update"])) {

                $sql2 = "update s_salma set CANCELL='1' where REF_NO='" . $_GET["invno"] . "'";
                $result2 = $conn->query($sql2);

                $sql2 = "update vendor set CUR_BAL=CUR_BAL-" . $rowinv["GRAND_TOT"] . " where CODE='" . $_GET["customer_code"] . "'";
                $result2 = $conn->query($sql2);


                $sql2 = "update br_trn set credit=credit-" . $rowinv["GRAND_TOT"] . " where cus_code='" . $_GET["customer_code"] . "' and Rep='" . $_GET["salesrep"] . "'";
                $result2 = $conn->query($sql2);


                $sqltmp = "select * from s_invo where REF_NO='" . $_GET['invno'] . "' ";
                $resulttmp = $conn->query($sqltmp);
                while ($rowtmp = $resulttmp->fetch()) {
                    $sql2 = "update s_invo set CANCELL='1' where REF_NO='" . $_GET['invno'] . "'";
                    $resul2 = $conn->query($sql2);

                    $sql2 = "update s_mas set QTYINHAND=QTYINHAND+" . $rowtmp["QTY"] . " where STK_NO='" . $rowtmp['STK_NO'] . "'";
                    $resul2 = $conn->query($sql2);

                    $sql2 = "update s_submas set QTYINHAND=QTYINHAND+" . $rowtmp["QTY"] . " where STO_CODE='" . $rowinv["DEPARTMENT"] . "' and STK_NO='" . $rowtmp['STK_NO'] . "'";
                    $resul2 = $conn->query($sql2);

                    $sql2 = "delete from s_trn where REFNO='" . $_GET['invno'] . "'";
                    $resul2 = $conn->query($sql2);

                    $sql2 = "delete from s_trn_all where REFNO='" . $_GET['invno'] . "'";
                    $resul2 = $conn->query($sql2);

                    $sql2 = "delete from s_trn_stores where REFNO='" . $_GET['invno'] . "'";
                    $resul2 = $conn->query($sql2);


                    $sql2 = "delete from s_led where REF_NO='" . $_GET['invno'] . "'";
                    $resul2 = $conn->query($sql2);
                }


                $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_GET['invno'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'Invoice', 'Cancel', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
                $result2 = $conn->query($sql2);
                echo "Canceled";
                $conn->commit();
            } else {
                echo "Can't Cancel";
                exit();
            }
        } else {
            echo "Can't Cancel";
            exit();
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}


if ($_GET["Command"] == "add_tmp") {

    if ($_GET['Command1'] == "add") {

        $rate = str_replace(",", "", $_GET["rate"]);

        $actual_selling = str_replace(",", "", $_GET["rate"]);
        $qty = str_replace(",", "", $_GET["qty"]);
        $subtotal = str_replace(",", "", $_GET["subtotal"]);
        $subtotal1 = str_replace(",", "", $_GET["subtotal"]);


        $subtotal2 = $rate - ($rate * $_GET["discountper"] / 100);

        if ($subtotal1 = !$subtotal2) {
            if (($subtotal1 != 1) && ($subtotal2 != 0)) {
                //echo $subtotal1; 
                exit('Error');
            }
        }




        $sql = "Insert into tmp_inv_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,  cur_subtot,  brand, tmp_no,actual_selling)values 
        ('" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', " . $rate . ", " . $qty . ", " . $_GET["discountper"] . ", " . $subtotal . ", '" . $_GET['brand'] . "', '" . $_GET['tmpno'] . "'," . $rate . ") ";

        $result = $conn->query($sql);
    }

    if ($_GET['Command1'] == "del") {

        $sql = "delete from tmp_inv_data where id='" . $_GET['id'] . "'";
        $result = $conn->query($sql);
    }




    $sql = "update tmp_inv_data set dis_per ='" . $_GET["discountper"] . "' where tmp_no='" . $_GET['tmpno'] . "' ";
    $result = $conn->query($sql);


    $sql = "update tmp_inv_data set cur_subtot=(cur_rate-(cur_rate*dis_per/100))*cur_qty where tmp_no='" . $_GET['tmpno'] . "' ";
    $result = $conn->query($sql);


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<sql><![CDATA[" . $sql . "]]></sql>";
    $ResponseXML .= "<sales_table><![CDATA[ <table class=\"table\">     
    <tr>
    <th style=\"width: 100px;\">Item Code</th>
    <th style=\"width: 10px;\"></th>
    <th style=\"width: 450px;\">Description</th>
    <th style=\"width: 120px;text-align: right;\">Price</th>
    <th style=\"width: 120px;text-align: right;\">Qty</th>
    <th style=\"width: 120px;text-align: right;\">%</th>
    <th style=\"width: 120px;text-align: right;\">SubTotal</th>
    <th></th>
    <th></th>
    </tr>";

    $i = 1;
    $mtot = 0;
    $mtot2 = 0;
    $mtot1 = 0;
    $sql = "Select * from tmp_inv_data where tmp_no='" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $id = "id" . $i;
        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $rate = "rate" . $i;

        $qty = "qty" . $i;
        $discountper = "discountper" . $i;
        $subtotal = "subtotal" . $i;
        $discount = "discount" . $i;

        $sql_mas = "Select * from s_mas where STK_NO='" . $row['str_code'] . "' and BRAND_NAME='" . $_GET['brand'] . "'";
        $resultmas = $conn->query($sql_mas);
        $rowmas = $resultmas->fetch();

        $dt = date('Y-m-d', strtotime(date('Y-m-d') . ' - 90 days'));

        $sql1 = "Select sum(REC_QTY) as stk from s_purtrn where STK_NO='" . $row['str_code'] . "' and CANCEL='0' and SDATE>'" . $dt . "' ";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch();

        $mnewstk = 0;
        $unsold = 0;
        if (is_null($row1["stk"]) == false) {
            $mnewstk = $row1["stk"];
        }

        if ($rowmas["QTYINHAND"] > $row1["stk"]) {
            $unsold = $rowmas["QTYINHAND"] - $mnewstk;
        }

        $bgcolour = "";

        if ($unsold > 0) {
            $bgcolour = "green";
        }

        $ResponseXML .= "<tr>                              

        <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>
        <td></td>";
        if ($bgcolour == "") {
            $ResponseXML .= "<td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>";
        } else {
            $ResponseXML .= "<td bgcolor=\" . $bgcolour . \" onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>";
        }
        $ResponseXML .= "<td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $rate . "'>" . number_format($row['cur_rate'], 2, ".", ",") . "</div></td>
        <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $qty . "'>" . number_format($row['cur_qty'], 0, ".", ",") . "</div></td>
        <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . $row["dis_per"] . "</div><input type=\"hidden\"  name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>
        <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>
        <td><a class=\"btn btn-danger btn-xs\"  onClick=\"del_item('" . $row['id'] . "');\"><span class='fa fa-remove'></a></td>";

        $sql = "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'";
        $result_q = $conn->query($sql);
        if ($row_q = $result_q->fetch()) {
            $qty = number_format($row_q['QTYINHAND'], 0, ".", ",");
        } else {
            $qty = 0;
        }


        $mtot = $mtot + $row['cur_subtot'];
        $mtot1 = $mtot1 + $row['cur_subtot'];




        $mtot2 = $mtot2 + ($row['cur_rate'] * $row['cur_qty']);


        $ResponseXML .= "<td>" . $qty . "</td>



        </tr>";
        $i = $i + 1;
    }
    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
    $ResponseXML .= "<Command1><![CDATA[" . $_GET['Command1'] . "]]></Command1>";

    $sql1 = "select vatrate from invpara";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch();

    if ($_GET['vatmethod'] != "non") {
        $mtot1 = $mtot1 / ( 1 + ($row1['vatrate'] / 100));
    } else {
        $mtot1 = $mtot;
    }


    $mtax = $mtot - $mtot1;
    $mdis = $mtot2 - $mtot;
    $ResponseXML .= "<subtot><![CDATA[" . number_format($mtot1, 2, ".", "") . "]]></subtot>";


    $ResponseXML .= "<totdiscount><![CDATA[" . number_format($mdis, 2, ".", "") . "]]></totdiscount>";
    $ResponseXML .= "<tax><![CDATA[" . number_format($mtax, 2, ".", "") . "]]></tax>";
    $ResponseXML .= "<invtot><![CDATA[" . number_format($mtot, 2, ".", "") . "]]></invtot>";




    $ResponseXML .= " </salesdetails>";


    echo $ResponseXML;
}


if ($_GET["Command"] == "pass_itno") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";



    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    if (trim($_GET["brand"]) != "") {
        $sql = "Select * from s_mas where STK_NO='" . $_GET['itno'] . "' and BRAND_NAME='" . $_GET["brand"] . "'";
    } else {
        $sql = "Select * from s_mas where STK_NO='" . $_GET['itno'] . "'";
    }
    $result_q = $conn->query($sql);
    if ($row = $result_q->fetch()) {

        $ResponseXML .= "<str_code><![CDATA[" . $row['STK_NO'] . "]]></str_code>";
        $ResponseXML .= "<str_description><![CDATA[" . $row['DESCRIPT'] . "]]></str_description>";
        $ResponseXML .= "<actual_selling><![CDATA[" . $row['SELLING'] . "]]></actual_selling>";


        $SELLING = $row['SELLING'];

        $ResponseXML .= "<str_selpri><![CDATA[" . number_format($SELLING, 2, ".", "") . "]]></str_selpri>";

        $ResponseXML .= "<str_partno><![CDATA[" . $row["PART_NO"] . "]]></str_partno>";
        $ResponseXML .= "<costcenter><![CDATA[" . $row["costcenter"] . "]]></costcenter>";

        $department = trim(substr($_GET["department"], 0, 2));


        $sql = "select QTYINHAND from s_submas where STK_NO='" . $_GET['itno'] . "' AND STO_CODE='" . $department . "'";
        $result_q = $conn->query($sql);
        if ($row_q = $result_q->fetch()) {
            $qty = number_format($row_q['QTYINHAND'], 0, ".", "");
        } else {
            $qty = 0;
        }

        $ResponseXML .= "<qtyinhand><![CDATA[" . $qty . "]]></qtyinhand>";

        $ResponseXML .= "<str_status><![CDATA[yes]]></str_status>";
    } else {
        $ResponseXML .= "<str_status><![CDATA[no]]></str_status>";
    }




    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "save_inv") {

    try {


        $insuf_qty = "";
        $sql = "select * from tmp_inv_data where tmp_no='" . $_GET["tmpno"] . "'";
        $i = 0;
        foreach ($conn->query($sql) as $rowtmp1) {
            $sql = "select QTYINHAND from s_submas where STK_NO='" . $rowtmp1['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'";
            $result = $conn->query($sql);
            if ($row = $result->fetch()) {
                if ($row["QTYINHAND"] < $rowtmp1["cur_qty"]) {
                    $insuf_qty = $rowtmp1['str_code'];
                }
            }
            $i = $i + 1;
        }

        if ($_SESSION['UserName'] == "") {
            exit("Invalid Session");
        }

        if ($insuf_qty != "") {
            exit("Under Stock");
        }

        if ($i == 0) {
            exit("Items Not Found");
        }

        $i = 0;
        $sqltmp1 = "select dis_per from tmp_inv_data where tmp_no='" . $_GET["tmpno"] . "' group by dis_per";
        foreach ($conn->query($sql) as $rowtmp1) {
            $i = $i + 1;
        }


        if ($i > 1) {
            exit("Error");
        }

        $sqlcumas = "select * from s_cusordmas where REF_NO='" . trim($_GET["ordno"]) . "' and INVNO !='0'";
        $resultcumas = $conn->query($sqlcumas);
        if ($rowsumas = $resultcumas->fetch()) { 
         exit("Already Invoiced Order No...."); 
     }

     $totdiscount = str_replace(",", "", $_GET["totdiscount"]);
     $subtot = str_replace(",", "", $_GET["subtot"]);
     $invtot = str_replace(",", "", $_GET["invtot"]);
     $tax = str_replace(",", "", $_GET["tax"]);
     $vat = "";


     if (($_GET["vatmethod"] == "vat") or ( $_GET["vatmethod"] == "svat") or ( $_GET["vatmethod"] == "evat")) {
        $vat = "1";
    } else {
        $vat = "0";
    }
    $svat = 0;
    if ($_GET["vatmethod"] == "svat") {
        $svat = str_replace(",", "", $_GET["tax"]);
    }



    $sql = "select SPINV,vatrate from invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();


    if ($vat != "1") {
        if ($tax > 0) {
            exit('Error In Tax');
        }
    }


    $sqltmp1 = "select sum(cur_subtot) as cur_subtot from tmp_inv_data where tmp_no='" . $_GET["tmpno"] . "'";
    $result = $conn->query($sqltmp1);
    if ($rowclass = $result->fetch()) {
        if (number_format($rowclass['cur_subtot'], 2, ".", "") != $invtot) {
            exit('Error In Total');
        }

        if ($vat == "1") {
            $mtot = number_format($rowclass['cur_subtot'] / (1 + $row['vatrate'] / 100), 2, ".", "");
            if ($mtot != $subtot) {
//                    exit("Error In Sub Total");
            }
            $mtot = $rowclass['cur_subtot'] - $mtot;
            if ($mtot = !$tax) {
                exit("Error in Tax");
            }
        }
    } else {
        exit("Error");
    }


    $sql = "select * from vendor where CODE = '" . trim($_GET["customercode"]) . "'";
    $result = $conn->query($sql);
    if ($row = $result->fetch()) {
        if ($row["blacklist"] == "1") {
//                $sqlapp = "select * from s_cusordmas where ref_no='" . trim($_GET["salesord1"]) . "'";
//                $resultapp = $conn->query($sqlapp);
//                if ($rowapp = $resultapp->fetch()) {
//                    if ($rowapp["approveby"] == "0") {
//                        exit("Invoice Facilitey Stoped for This Customer,Please Invoice For Approved Sales Order");
//                    } else {
//                        exit("Invoice Facilitey Stoped for This Customer,Please Invoice For Approved Sales Order");
//                    }
//                    $_SESSION["print"] = 0;
//                }
            exit("Invoice Facilitey Stoped for This Customer..!!!");
        }
    }






    $InvClass = "";
    $sqlclass = "select class from brand_mas where barnd_name='" . trim($_GET["brand"]) . "'";
    $result = $conn->query($sqlclass);
    if ($rowclass = $result->fetch()) {
        if (is_null($rowclass["class"]) == false) {
            $InvClass = $rowclass["class"];
        }
    }

    $sql_brtrn = "select * from br_trn where Rep='" . trim($_GET["salesrep"]) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($_GET["customercode"]) . "'";
    $result_brtrn = $conn->query($sql_brtrn);
    $row_brtrn = $result_brtrn->fetch();
    $cuscat = trim($row_brtrn["CAT"]);

    $d1 = str_replace(",", "", $_GET["discount_org1"]);
    $d2 = str_replace(",", "", $_GET["discount_org2"]);
    $d3 = str_replace(",", "", $_GET["discount_org3"]);

    if ($d1 == "") {
        $d1 = 0;
    }
    if ($d2 == "") {
        $d2 = 0;
    }
    if ($d3 == "") {
        $d3 = 0;
    }


    $d = 100 - (100 - $d3) * (100 - $d2) * (100 - $d1) / 100;
        //===============================================

    $cre_balance = str_replace(",", "", $_GET["balance"]);



    $customername = str_replace("~", "&", $_GET["customername"]);
    $cus_address = str_replace("~", "&", $_GET["cus_address"]);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();

    $sql = "select SPINV,vatrate from invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();
    $tmpinvno = "000000" . ($row["SPINV"] + 1);
    $lenth = strlen($tmpinvno);
    $invno = trim("CRI/") . substr($tmpinvno, $lenth - 6) . "/" . $_GET["salesrep"];

    $sqlisalma_q = "select REF_NO from s_salma where REF_NO='" . $invno . "'";
    $resultsalma_q = $conn->query($sqlisalma_q);
    if ($rowsalma_q = $resultsalma_q->fetch()) {
        $conn->rollBack();
        exit("Invoice No Already Exist !!!");
    }
    $sqlisalma_q = "select REF_NO from s_salma where tmp_no='" . $_GET["tmpno"] . "'";
    $resultsalma_q = $conn->query($sqlisalma_q);
    if ($rowsalma_q = $resultsalma_q->fetch()) {
        $conn->rollBack();
        exit("Invoice No Already Exist !!!");
    }



    $mvatrate = $row["vatrate"];
    $sql = "update invpara set SPINV = SPINV +1";
    $res_inv = $conn->query($sql);


    $totpay1 = 1;

    $sql = "select * from tmp_inv_data where tmp_no='" . $_GET["tmpno"] . "'";
    foreach ($conn->query($sql) as $rowtmp) {
        $dis_per = $rowtmp["cur_rate"] * $rowtmp["cur_qty"] * $rowtmp["dis_per"] * 0.01;

        $sqlmas = "select * from s_mas where STK_NO='" . trim($rowtmp["str_code"]) . "'";
        $resultmas = $conn->query($sqlmas);
        $rowmas = $resultmas->fetch();

        if (trim($rowmas['type']) == "TBB") {
            $totpay1 = "0";
        }
        if (trim($rowmas['type']) == "TBR") {
            $totpay1 = "0";
        }
        if (trim($rowmas['type']) == "OTR") {
            $totpay1 = "0";
        }
        $sql_invo = "Insert into s_invo  (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, COST, PRICE, QTY, DEPARTMENT, DIS_per, DIS_rs, REP, TAX_PER, BRAND, vatrate, Print_dis1, Print_dis2, Print_dis3, subtot, ret_qty, DEV, CANCELL, c_code, seri_no, ad,sdate1) values "
        . "('" . $invno . "', '" . $_GET["invdate"] . "', '" . trim($rowtmp["str_code"]) . "', '" . trim($rowtmp["str_description"]) . "', '" . $rowmas["PART_NO"] . "', " . $rowmas["COST"] . ", " . $rowtmp["actual_selling"] . ", " . $rowtmp["cur_qty"] . ", '" . trim($_GET["department"]) . "', '" . $rowtmp["dis_per"] . "', " . $dis_per . ", '" . $_GET["salesrep"] . "', '" . $mvatrate . "', '" . $_GET["brand"] . "', " . $mvatrate . ", " . $d1 . ", " . $d2 . ", " . $d3 . ", " . $rowtmp["cur_subtot"] . ", '0', '', '0', '', '', '" . $rowtmp["ad"] . "','" . $_GET["invdate"] . "')";
        $result_invo = $conn->query($sql_invo);


        $sqls_trn = "Insert into s_trn (STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, Dev, seri_no, SAL_EX, ACTIVE, DONO,sdate1) values('" . trim($rowtmp["str_code"]) . "','" . $_GET["invdate"] . "','" . trim($invno) . "', " . $rowtmp["cur_qty"] . ", 'INV', '" . trim($_GET["department"]) . "', '" . $_SESSION['dev'] . "', '', '', '1', '','" . $_GET["invdate"] . "')";
        $results_trn = $conn->query($sqls_trn);

        $sqls_mas = "update s_mas set QTYINHAND= QTYINHAND-" . $rowtmp["cur_qty"] . " where STK_NO='" . trim($rowtmp["str_code"]) . "'";
        $results_mas = $conn->query($sqls_mas);

        $sqls_submas = "update s_submas set QTYINHAND=QTYINHAND- " . $rowtmp["cur_qty"] . " where STK_NO= '" . trim($rowtmp["str_code"]) . "' and STO_CODE= '" . trim($_GET["department"]) . "'";
        $results_submas = $conn->query($sqls_submas);
    }

    $sqlrep = "select * from s_salrep where REPCODE = '" . trim($_GET["salesrep"]) . "'";
    $resultrep = $conn->query($sqlrep);
    if ($rowrep = $resultrep->fetch()) {
        $maindepart = $rowrep['RGROUP1'];
    } else {
        $maindepart = "";
    }

    $sql = "Insert into s_salma  (REF_NO, TRN_TYPE, SDATE, C_CODE, Brand, CUS_NAME, VAT, VAT_VAL, TYPE, DISCOU, AMOUNT, GRAND_TOT,  TOTPAY, ORD_NO, ORD_DA,  DEPARTMENT, SAL_EX, BTT, cre_pe, GST, DIS, DIS1, DIS2, SVAT, Account, TOTPAY1, REMARK, REQ_DATE, CANCELL, DEV, tmp_no, DIS_RUP, CASH, SETTLED, DES_CAT, Accname, Costcenter, RET_AMO, Comm, red, seri_no, points, LOCK1, deliin, vat_no, s_vat_no, C_ADD1,c_code1,transp,deli_name,deli_add,maindepartment,sdate1) values "
    . "('" . $invno . "', 'INV', '" . $_GET["invdate"] . "', '" . trim($_GET["customercode"]) . "', '" . trim($_GET["brand"]) . "', '" . trim($customername) . "','" . $vat . "', " . $tax . ", '".$_GET["paymethod"]."'," . $totdiscount . ", " . $subtot . " , " . $invtot . ", 0, '" . trim($_GET["salesord1"]) . "', '" . $_GET["invdate"] . "', '" . trim($_GET["department"]) . "', '" . trim($_GET["salesrep"]) . "', " . $tax . ", " . $_GET["credper"] . " , " . $mvatrate . ", " . $d1 . ", " . $d2 . ", " . $d3 . ", '" . $svat . "', 'NOTAUTH', '" . $totpay1 . "',  '" . $invno . "', '" . $_GET["invdate"] . "', '0', '" . $_SESSION['dev'] . "', '" . $_GET["tmpno"] . "', 0, 0, '0', 'N', 'OFFICE', '" . $_GET['promotion'] . "', 0, 'N', '0', '', '0', '0', '', '" . trim($_GET["vat1"]) . "', '" . trim($_GET["vat2"]) . "', '" . $cus_address . "','" . $_GET['c_subcode'] . "','" . $_GET['delitype'] . "','" . $_GET['deli_name'] . "','" . $_GET['deli_address'] . "','" . $maindepart . "','" . $_GET["invdate"] . "')";
    $resultsalma = $conn->query($sql);

    $sqlpara = "update vendor set temp_limit= '0'  where CODE='" . trim($_GET["customercode"]) . "'";
    $resultpara = $conn->query($sqlpara);

    $sqls_submas = "Insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT) values('" . trim($invno) . "', '" . $_GET["invdate"] . "', '" . trim($_GET["customercode"]) . "', " . $invtot . ", 'INV', '" . $_GET["department"] . "')";
    $results_submas = $conn->query($sqls_submas);

    $sqlbr_trn = "update br_trn set tmplmt= '0'   where cus_code='" . trim($_GET["customercode"]) . "' and brand='" . trim($InvClass) . "' and Rep='" . trim($_GET["salesrep"]) . "'";
    $resultbr_trn = $conn->query($sqlbr_trn);

    $sqlbr_trn = "update s_cusordmas set INVNO= '" . $invno . "' where  REF_NO='" . $_GET["ordno"] . "'";
    $resultbr_trn = $conn->query($sqlbr_trn);

    $sqlbrand = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($invno) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Invoice', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
    $resultbrand = $conn->query($sqlbrand);

    $conn->commit();
    echo $invno . " Saved";
} catch (Exception $e) {
    $conn->rollBack();
    echo $e;
}
}

if ($_GET["Command"] == "deli_update") {

    try {
        $sql = "update s_salma set deli_name= '" . $_GET["deli_name"] . "', deli_add='" . $_GET["deli_address"] . "' where  REF_NO='" . $_GET["invno"] . "'";
        $result = $conn->query($sql);

        echo "Updated";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

if ($_GET["Command"] == "cred_update") {

    try {
        $sql = "update s_salma set cre_pe= '" . $_GET["credper"] . "' where  REF_NO='" . $_GET["invno"] . "'";
        $result = $conn->query($sql);

        $sqlentry = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_GET["invno"] . "', '" . $_SESSION["CURRENT_USER"] . "', 'Invoice', 'CredDays Update', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $resultenrty = $conn->query($sqlentry);

        echo "C.P Updated";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}  