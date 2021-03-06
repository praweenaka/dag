<?php

session_start();

date_default_timezone_set('Asia/Colombo');

include_once ("connectioni.php");

if ($_GET["Command"] == "search_inv") {

    $ResponseXML = "";
    //$ResponseXML .= "<invdetails>";

    $ResponseXML .= "<table width=\"800\" border=\"0\" class=\"table-bordered\">
                            <tr>
<th width=\"121\">Order No</th>
<th width=\"200\" >Customer</th>
<th width=\"100\" >Order Date</th>
<th width=\"100\" >Grand Total</th>
<th width=\"100\" >Status</th>
<th width=\"50\" >Rep</th>
<th width=\"50\" >Approve By</th>
<th width=\"70\" ></th>
</tr>";

    if ($_GET["Option1"] == "true") {
        if ($_GET["mstatus"] == "invno") {
            $letters = $_GET['invno'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO='0'  and CANCELL='0'  order by id asc limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO='0'  and CANCELL='0' order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {
            $letters = $_GET['rep'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where sal_ex like  '$letters%' and  INVNO='0' and CANCELL='0'   order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    }

    if ($_GET["Option2"] == "true") {
        if ($_GET["mstatus"] == "invno") {
            $letters = $_GET['invno'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO='0' and Forward<>'WD' and CANCELL='0' and Result='P'   order by id asc limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO='0' and Forward<>'WD'  and CANCELL='0' and Result='P'  order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {
            $letters = $_GET['rep'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where sal_ex like  '$letters%' and  INVNO='0' and Forward<>'WD' and CANCELL='0' and Result='P'  order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    }

    if ($_GET["Option3"] == "true") {
        if ($_GET["mstatus"] == "invno") {
            $letters = $_GET['invno'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO='0' and Forward='WD' and CANCELL='0' and Result='P' order by id asc limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO='0' and Forward='WD' and CANCELL='0' and Result='P' order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {
            $letters = $_GET['rep'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where sal_ex like  '$letters%' and  INVNO='0' and Forward='WD' and CANCELL='0' and Result='P' order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    }

    if ($_GET["Option4"] == "true") {
        if ($_GET["mstatus"] == "invno") {
            $letters = $_GET['invno'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO!='0' and CANCELL='0'  order by id asc limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO!='0' and CANCELL='0'  order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {
            $letters = $_GET['rep'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where sal_ex like  '$letters%' and  INVNO!='0' and CANCELL='0'  order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    }

    if ($_GET["Option5"] == "true") {
        if ($_GET["mstatus"] == "invno") {
            $letters = $_GET['invno'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO='0' and CANCELL='0' and result = 'OK' order by id asc limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO='0' and CANCELL='0' and result = 'OK' order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {
            $letters = $_GET['rep'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where sal_ex like  '$letters%' and  INVNO='0' and CANCELL='0' and result = 'OK' order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    }

    while ($row = mysqli_fetch_array($sql)) {
        $REF_NO = $row['REF_NO'];
        $stname = $_SESSION["stname"];
        $ResponseXML .= "<tr>
                           	  <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['CUS_NAME'] . "</a></td>
                              <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['SDATE'] . "</a></td>
							  <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['GRAND_TOT'] . "</a></td>
							  <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['Result'] . "</a></td>
							  <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['SAL_EX'] . "</a></td>
							  <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['Brand'] . "</a></td>							  
                              <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['Forward'] . "</a></td>                          	
                            </tr>";
    }

    $ResponseXML .= "   </table>";

    echo $ResponseXML;
}



if ($_GET["Command"] == "pass_invno_to_inv") {


    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $brand = "";
    $salrep = "";
    $cuscode = "";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<stname><![CDATA[" . $_GET["stname"] . "]]></stname>";
    $inv = $_GET['invno'];
    $_SESSION["invno"] = $_GET['invno'];
    $_SESSION["salesord1"] = $_GET['invno'];

 

    $sql = "Select SPINV from tmpinvpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);

    $tono = $row['SPINV'];

    $sql = "delete from tmp_inv_data where tmp_no='" . $tono . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql = "update tmpinvpara set SPINV=SPINV+1";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sqlxl = mysqli_query($GLOBALS['dbinv'], "Select * from s_cusordmas where REF_NO='" . $inv . "'") or die(mysqli_error());
    $row_xl = mysqli_fetch_array($sqlxl);

    $sql_invpara = mysqli_query($GLOBALS['dbinv'], "SELECT * from invpara") or die(mysqli_error());
    $rown = mysqli_fetch_array($sql_invpara);

    $sql_vat = mysqli_query($GLOBALS['dbinv'], "SELECT * from vatrate where sdate<='" . $row_xl["SDATE"] . "' order by sdate desc") or die(mysqli_error());
    $row_vat = mysqli_fetch_array($sql_vat);

    $vatrate = $row_vat["vatrate"] / 100;

    $vatmethod = "";

    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_cusordmas where REF_NO='" . $inv . "'") or die(mysqli_error());

    if ($row = mysqli_fetch_array($sql)) {
        $SAL_EX = $row['SAL_EX'];
        $tmpinvno = "000000" . ($rown["SPINV"] + 1);
        $lenth = strlen($tmpinvno);

        $invno = trim("CRI/") . substr($tmpinvno, $lenth - 6) . "/" . $SAL_EX;
        $_SESSION["invno"] = $invno;
        $txtdono = $rown["CRE_INV_NO"] + 1;
        $ResponseXML .= "<str_order_no><![CDATA[" . $inv . "]]></str_order_no>";
        $ResponseXML .= "<Result><![CDATA[" . $row["Result"] . "]]></Result>";
        $ResponseXML .= "<str_invoiceno><![CDATA[" . $invno . "]]></str_invoiceno>";
        $ResponseXML .= "<str_crecash><![CDATA[" . $row['TYPE'] . "]]></str_crecash>";
        $ResponseXML .= "<trans><![CDATA[" . $row['comm'] . "]]></trans>";
        $ResponseXML .= "<sdate><![CDATA[" . date('Y-m-d') . "]]></sdate>";
        $cuscode = $row['C_CODE'];
        $ResponseXML .= "<str_customecode><![CDATA[" . $row['C_CODE'] . "]]></str_customecode>";

        if (trim($row['VAT']) == "0") {
            $ResponseXML .= "<str_vat><![CDATA[0]]></str_vat>";
            $vatmethod = "0";
        }
        if (trim($row['VAT']) == "1") {
            $ResponseXML .= "<str_vat><![CDATA[1]]></str_vat>";
            $vatmethod = "1";
        }
        if (trim($row['VAT']) == "2") {
            $ResponseXML .= "<str_vat><![CDATA[2]]></str_vat>";
            $vatmethod = "2";
        }
        if (trim($row['VAT']) == "3") {
            $ResponseXML .= "<str_vat><![CDATA[3]]></str_vat>";
            $vatmethod = "3";
        }

        $_SESSION["custno"] = $row['C_CODE'];
        //$_SESSION["tmp_no_salinv"]= $row['tmp_no'];
        //	echo "Select * from vendor where CODE='".$row['C_CODE']."'";
        $sqlcustomer = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $row['C_CODE'] . "'") or die(mysqli_error());
        if ($rowcustomer = mysqli_fetch_array($sqlcustomer)) {
            $sql = "select * from vender_sub where c_code = '" . $row["c_code1"] . "'";
            $result_1 = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_1 = mysqli_fetch_array($result_1)) {
                $ResponseXML .= "<str_customername><![CDATA[" . trim($row_1['c_name']) . "]]></str_customername>";
                $address = trim($row_1['c_add']) . ",  " . trim($row_1['c_add1']);
                $ResponseXML .= "<str_address><![CDATA[" . trim($address) . "]]></str_address>";
                $ResponseXML .= "<str_address2>.</str_address2>";
                $ResponseXML .= "<str_vatno1><![CDATA[" . trim($row_1["c_vatno"]) . "]]></str_vatno1>";
                $ResponseXML .= "<str_vatno2><![CDATA[" . trim($row_1["c_svatno"]) . "]]></str_vatno2>";
                $ResponseXML .= "<cur_balance>0</cur_balance>";
            } else {
                $ResponseXML .= "<str_customername><![CDATA[" . trim($rowcustomer['NAME']) . "]]></str_customername>";
                $ResponseXML .= "<str_address><![CDATA[" . trim($rowcustomer['ADD1']) . "]]></str_address>";
                $ResponseXML .= "<str_address2><![CDATA[" . trim($rowcustomer['ADD2']) . "]]></str_address2>";
                $ResponseXML .= "<str_vatno1><![CDATA[" . trim($rowcustomer['vatno']) . "]]></str_vatno1>";
                $ResponseXML .= "<str_vatno2><![CDATA[" . trim($rowcustomer['svatno']) . "]]></str_vatno2>";
                $ResponseXML .= "<cur_balance>0</cur_balance>";
            }
        }
        $ResponseXML .= "<c_subcode><![CDATA[" . $row['c_code1'] . "]]></c_subcode>";
        $ResponseXML .= "<str_salesrep><![CDATA[" . $row['SAL_EX'] . "]]></str_salesrep>";
        $salrep = $row['SAL_EX'];

        $ResponseXML .= "<dte_deliverdate><![CDATA[" . $row['REQ_DATE'] . "]]></dte_deliverdate>";
        $ResponseXML .= "<sdate><![CDATA[" . date("Y-m-d") . "]]></sdate>";

        $ResponseXML .= "<dis><![CDATA[" . $row['DIS'] . "]]></dis>";
        $ResponseXML .= "<dis1><![CDATA[" . $row['DIS1'] . "]]></dis1>";
        $ResponseXML .= "<dis2><![CDATA[" . $row['DIS2'] . "]]></dis2>";

        $ResponseXML .= "<str_department><![CDATA[" . $row['DEPARTMENT'] . "]]></str_department>";
        $department = $row['DEPARTMENT'];
        $_SESSION["department"] = $row['DEPARTMENT'];
        $ResponseXML .= "<str_brand><![CDATA[" . $row['Brand'] . "]]></str_brand>";
        $_SESSION["brand"] = $row['Brand'];
        $brand = $row['Brand'];
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">     
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
    include_once './connection_sql.php';

    $sql_data = mysqli_query($GLOBALS['dbinv'], "Select * from s_cusordtrn where REF_NO='" . $inv . "'") or die(mysqli_error());
    while ($row = mysqli_fetch_array($sql_data)) {


        $sql = "select * from s_mas where stk_no = '" . $row['STK_NO'] . "'";
        $result_q = $conn->query($sql);
        $row_q = $result_q->fetch();

        $_SESSION['type'] = $row_q['type'];

        $SELLING = $row_q['SELLING'];
        $actual_rate = $row_q['SELLING'];

        $dis_val = $SELLING * $row['QTY'] * $row['DIS_per'] / 100;
        $usr[] = "( '" . $_GET["newinvno"] . "', '" . $row['STK_NO'] . "', '" . $row['DESCRIPT'] . "', " . $SELLING . ", " . $row['QTY'] . ", " . $row['DIS_per'] . ", " . $dis_val . ", " . (($SELLING * $row['QTY']) - $dis_val) . ", '" . $row['BRAND'] . "', " . $actual_rate . ", '0', '" . $tono . "')";
    }

    $sql_tmp = mysqli_query($GLOBALS['dbinv'], "Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand, actual_selling, ad, tmp_no) values " . implode($usr, ","));

    $i = 1;
    $cur_subtot = 0;
    $cur_discount = 0;


    $sql = "Select * from tmp_inv_data where tmp_no='" . $tono . "' order by id";
    $mtot = 0;
    $mtot1 = 0;
    $mtot2 = 0;
    foreach ($conn->query($sql) as $row) {

        $id = "id" . $i;
        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $rate = "rate" . $i;

        $qty = "qty" . $i;
        $discountper = "discountper" . $i;
        $subtotal = "subtotal" . $i;
        $discount = "discount" . $i;
        
        $sql_mas = "Select * from s_mas where STK_NO='" . $row['str_code'] . "' and BRAND_NAME='" . $brand . "'";
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
                         }else{
                           $ResponseXML .= " <td bgcolor=\" . $bgcolour . \" onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>";
                         }
                         
        $ResponseXML .= "<td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $rate . "'>" . number_format($row['cur_rate'], 2, ".", ",") . "</div></td>
                         <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $qty . "'>" . number_format($row['cur_qty'], 0, ".", ",") . "</div></td>
                         <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . $row["dis_per"] . "</div><input type=\"hidden\"  name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>
                         <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>
                         <td><a class=\"btn btn-danger btn-xs\"  onClick=\"del_item('" . $row['id'] . "');\"><span class='fa fa-remove'></a></td>";

        $sql = "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $department . "'";
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
    $ResponseXML .= "<type1><![CDATA[" . $_SESSION['type'] . "]]></type1>";
    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";
    $ResponseXML .= "<tmpno><![CDATA[" . $tono . "]]></tmpno>";


    $vatrate = $row_vat["vatrate"] / 100;

    if ($vatmethod != "0") {
        $mtot1 = $mtot1 / (1 + $vatrate);
    } else {
        $mtot1 = $mtot;
    }

    $mtax = $mtot - $mtot1;
    $mdis = $mtot2 - $mtot;



    $ResponseXML .= "<cur_subtotal><![CDATA[" . number_format($mtot1, 2, ".", "") . "]]></cur_subtotal>";
    $ResponseXML .= "<cur_discount><![CDATA[" . number_format($mdis, 2, ".", "") . "]]></cur_discount>";
    $ResponseXML .= "<cur_tax><![CDATA[" . number_format($mtax, 2, ".", "") . "]]></cur_tax>";

    $ResponseXML .= "<cur_invoiceval><![CDATA[" . number_format($mtot, 2, ".", "") . "]]></cur_invoiceval>";




    $RET_AMOUNT = 0;
    $PD_AMOUNT = 0;
    $OUT_AMOUNT = 0;

    $sql = mysqli_query($GLOBALS['dbinv'], "select * from vendor where CODE = '" . trim($cuscode) . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $sqlchq = mysqli_query($GLOBALS['dbinv'], "SELECT che_amount FROM s_invcheq WHERE che_date>'" . $_GET["invdate"] . "' AND cus_code='" . $row["CODE"] . "'") or die(mysqli_error());

        while ($rowchq = mysqli_fetch_array($sqlchq)) {
            $PD_AMOUNT = $PD_AMOUNT + $rowchq["che_amount"];
        }

        if (is_null($row["AltMessage"]) == false) {
            if (trim($row["AltMessage"]) != "") {
                $ResponseXML .= "<AltMessage><![CDATA[" . $row['AltMessage'] . "]]></AltMessage>";
            } else {
                $ResponseXML .= "<AltMessage><![CDATA[]]></AltMessage>";
            }
        } else {
            $ResponseXML .= "<AltMessage><![CDATA[]]></AltMessage>";
        }

        if ($row["chk_bangr"] == "1") {

            $dateDiff = $row["bank_gr_date"] - $_GET["invdate"];
            $m_dates = floor($dateDiff / (60 * 60 * 24));
            if ($m_dates > 30 and $m_dates < 60) {
                $ResponseXML .= "<bank_message><![CDATA[Please Re-New Bank Grantee Date]]></bank_message>";
                $_SESSION["inv_status"] = 0;
            } else if ($m_dates <= 30) {
                $ResponseXML .= "<bank_message><![CDATA[No Permission For Invoice For This Customer Please Re-New Bank Grantee Date]]></bank_message>";
                $_SESSION["inv_status"] = 0;
            }
        } else {
            $ResponseXML .= "<bank_message><![CDATA[]]></bank_message>";
        }

        $adddate = date('Y-m-d', strtotime("-60 days"));
        $sql60 = mysqli_query($GLOBALS['dbinv'], "select SDATE from  s_salma where  C_CODE='" . trim($cuscode) . "' and GRAND_TOT-TOTPAY >1 and CANCELL=0 and sdate <='" . $adddate . "' order by SDATE") or die(mysqli_error());
        if ($row60 = mysqli_fetch_array($sql60)) {

            $_SESSION["inv_status"] = "0";
            if (is_null($row["Over_DUE_IG_Date"]) == false) {

                if (strtotime($row["Over_DUE_IG_Date"]) != strtotime(date("Y-m-d"))) {
                    $ResponseXML .= "<over60_qst><![CDATA[No Permission For Invoice For This Customer Please Re-New LIMIT Grantee Date]]></over60_qst>";
                    $ResponseXML .= "<over60_message><![CDATA[Over 60 Outsnding Avilabale]]></over60_message>";
                    $ResponseXML .= "<over60_txt><![CDATA[60]]></over60_txt>";

                    //$sqltmpCrLmt = mysqli_query($GLOBALS['dbinv'], "insert into tmpcrlmt (sdate, stime, tmpLmt, Class, Rep,cuscode, crLmt,  FLAG) values ('" . $_GET["invdate"] . "','" . date("h:i:s") . "' , " . $mdays . " ,'NB','NR','" . trim($cuscode) . "','0', 'O60')") or die(mysqli_error());
                } else {

                    $ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
                    $ResponseXML .= "<over60_message><![CDATA[]]></over60_message>";
                    $ResponseXML .= "<over60_txt><![CDATA[0]]></over60_txt>";
                }
            } else {
                $ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
                $ResponseXML .= "<over60_message><![CDATA[]]></over60_message>";
                $ResponseXML .= "<over60_txt><![CDATA[0]]></over60_txt>";
            }
        } else {
            $ResponseXML .= "<over60_message><![CDATA[]]></over60_message>";
            $ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
            $ResponseXML .= "<over60_txt><![CDATA[0]]></over60_txt>";
        }

        $sqls_cheq = mysqli_query($GLOBALS['dbinv'], "Select * from s_cheq where CR_CHEVAL-PAID>5 and CR_FLAG='0' and CR_C_CODE='" . trim($cuscode) . "'") or die(mysqli_error());
        if ($rows_cheq = mysqli_fetch_array($sqls_cheq)) {
            $ResponseXML .= "<chq_message><![CDATA[Return Cheque]]></chq_message>";
            $_SESSION["inv_status"] = 0;
            if (is_null($row["Over_DUE_IG_Date"]) == false) {
                if ($row["Over_DUE_IG_Date"] == date("Y-m-d")) {
                    $ResponseXML .= "<chq_message_que><![CDATA[Do You Want To Continue with Return Cheques]]></chq_message_que>";
                    $sqltmpCrLmt = mysqli_query($GLOBALS['dbinv'], "insert into tmpcrlmt (sdate, stime, tmpLmt, Class, Rep,cuscode, crLmt, FLAG) values ('" . $_GET["invdate"] . "', '" . date("h:i:s") . "', '0' ,'NB','NR','" . trim($cuscode) . "','0', 'RTN')") or die(mysqli_error());
                } else {
                    $ResponseXML .= "<chq_message_que><![CDATA[]]></chq_message_que>";
                }
            }
        } else {
            $ResponseXML .= "<chq_message><![CDATA[]]></chq_message>";
            $ResponseXML .= "<chq_message_que><![CDATA[]]></chq_message_que>";
        }

        if (is_null($row["CUR_BAL"]) == false) {
            $OUT_AMOUNT = $row["CUR_BAL"];
        }

        if (is_null($row["CAT"]) == false) {
            $cuscat = $row["CAT"];
        }

        $sqlretchq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-PAID) as CR_CHEVAL  from s_cheq where CR_C_CODE='" . trim($cuscode) . "' and CR_CHEVAL-PAID>0 and CR_FLAG='0'") or die(mysqli_error());
        while ($rowretchq = mysqli_fetch_array($sqlretchq)) {
            $RET_AMOUNT = $RET_AMOUNT + $rowretchq["CR_CHEVAL"];
        }
    }

    //Call SETLIMIT ====================================================================

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

    $sqloutinv = mysqli_query($GLOBALS['dbinv'], "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and SAL_EX='" . trim($salrep) . "' and class='" . $InvClass . "'") or die(mysqli_error());
    if ($rowoutinv = mysqli_fetch_array($sqloutinv)) {
        if (is_null($rowoutinv["totout"]) == false) {
            $OutInvAmt = $rowoutinv["totout"];
        }
    }

    $rs0 = "Select sum(ST_PAID) as out1 from view_sinvcheq_sttr_salma1  where che_date >  '" . $_GET["invdate"] . "' and C_CODE='" . trim($cuscode) . "' and SAL_EX = '" . trim($salrep) . "' and class = '" . $InvClass . "'  ";
    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], $rs0);
    while ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {
        $OutpDAMT = $OutpDAMT + $rowinvcheq["out1"];
    }

    $pend_ret_set = 0;
    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'" . $_GET["invdate"] . "' AND cus_code='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
    if ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {
        if (is_null($rowinvcheq["che_amount"]) == false) {
            $pend_ret_set = $rowinvcheq["che_amount"];
        }
    }

    $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>5 and CR_FLAG='0' and S_REF='" . trim($salrep) . "'") or die(mysqli_error());
    if ($rowcheq = mysqli_fetch_array($sqlcheq)) {
        if (is_null($rowcheq["tot"]) == false) {
            $OutREtAmt = $rowcheq["tot"];
            $ResponseXML .= "<msg_return><![CDATA[Return Cheques Available]]></msg_return>";
        } else {
            $OutREtAmt = 0;
            $ResponseXML .= "<msg_return><![CDATA[]]></msg_return>";
        }
    } else {
        $ResponseXML .= "<msg_return><![CDATA[]]></msg_return>";
    }

    $d = date("Y-m-d");

    $date = date('Y-m-d', strtotime($d . ' -60 days'));
    $rtxover60 = 0;
    $sql_rssal = mysqli_query($GLOBALS['dbinv'], "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE = '" . trim($cuscode) . "' and (SDATE < '" . $date . "') and GRAND_TOT - TOTPAY > 1 and CANCELL = '0'") or die(mysqli_error());

    if ($row_rssal = mysqli_fetch_array($sql_rssal)) {
        if (is_null($row_rssal["out1"]) == false) {
            $rtxover60 = number_format($row_rssal["out1"], 2, ".", ",");
        }
    }

    $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutREtAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutpDAMT, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Over 60 Outstandings\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . $rtxover60 . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";

    $sqlbr_trn = mysqli_query($GLOBALS['dbinv'], "select * from br_trn where Rep='" . trim($salrep) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($cuscode) . "'") or die(mysqli_error());

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
            $cuscat = trim($rowbr_trn["CAT"]);
            if ($cuscat == "A") {
                $m = 2.5;
            }
            if ($cuscat == "B") {
                $m = 2.5;
            }
            if ($cuscat == "C") {
                $m = 1;
            }
            if ($cuscat == "D") {
                $m = 0;
            }
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
        } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
        }

        $crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
        $txt_crebal = $crLmt * $m - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
        $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
    } else {
        $crebal = 0;
    }

    $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
    $ResponseXML .= "<txt_crebal><![CDATA[" . $txt_crebal . "]]></txt_crebal>";
    $ResponseXML .= "<crebal><![CDATA[" . $crebal . "]]></crebal>";
    $ResponseXML .= "<creditbalance><![CDATA[" . number_format($txt_crebal, "2", ".", ",") . "]]></creditbalance>";

    $invqty = 0;
    $rtnqty = 0;

    $Mon = date("m", strtotime(date("Y-m-d")));
    $Yer = date("Y", strtotime(date("Y-m-d")));
//    $Mon = date("m", strtotime("2019-11-30"));
//    $Yer = date("Y", strtotime("2019-11-30"));
    $sql_inv = "Select sum(Qty) as totQty from viewinv where  Cus_CODE = '" . trim($cuscode) . "' and s_Brand = '" . $brand . "' and month(sdate1) = '" . $Mon . "' and year(sdate1) = '" . $Yer . "' and cancel_m = '0' and  stk_no <> 'SC01' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0797'  and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'A0356' and stk_no <> 'L0531' and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003'  and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and stk_no <> 'AL004' and stk_no <> 'AL005' and stk_no <> 'AL006' and stk_no <> 'AL007' and stk_no <> 'AL008' and stk_no <> 'AL009'  and stk_no <>'A0359'  and stk_no <>'AL011' and stk_no <>'A0797' and stk_no <>'MR099' and dis_per <> 100";
    $sql_grn = " Select sum(Qty) as totQty from viewcrntrn where  C_CODE = '" . trim($cuscode) . "' and Brand = '" . $brand . "' and month(sdate1) = '" . $Mon . "' and year(sdate1) = '" . $Yer . "' and cancell = '0' and  stk_no <> 'SC01' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0797'  and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'A0356' and stk_no <> 'L0531' and stk_no <> 'AL001' and stk_no <> 'AL002'  and stk_no <> 'AL003'  and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and stk_no <> 'AL004' and stk_no <> 'AL005' and stk_no <> 'AL006' and stk_no <> 'AL007' and stk_no <> 'AL008' and stk_no <> 'AL009' and stk_no <> 'A0359' and stk_no <>'AL011' and stk_no <>'A0797' and stk_no <>'MR099' ";

    $res_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
    if ($row_inv = mysqli_fetch_array($res_inv)) {
        if (!is_null($row_inv['totQty'])) {
            $invqty = $row_inv['totQty'];
        }
    }
    $res_grn = mysqli_query($GLOBALS['dbinv'], $sql_grn);
    if ($row_grn = mysqli_fetch_array($res_grn)) {
        if (!is_null($row_grn['totQty'])) {
            $rtnqty = $row_grn['totQty'];
        }
    }

    $netqty = $invqty - $rtnqty;

    $ResponseXML .= "<netqty><![CDATA[" . $netqty . "]]></netqty>";

    $ResponseXML .= "</salesdetails>";

    $_SESSION["print"] = 1;
    echo $ResponseXML;
}


mysqli_close($GLOBALS['dbinv']);
?>
