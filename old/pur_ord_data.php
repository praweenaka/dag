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

    $department = $_GET["department"];

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_purord_data where str_code='" . $_GET['itemcode'] . "' and tmp_no='" . $_SESSION['tmp_no_purord'] . "' ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    //echo $_GET['rate'];
    //echo $_GET['qty'];

    $qty = str_replace(",", "", $_GET["qty"]);


    $sql = "select * from s_mas where stk_no = '" . $_GET['itemcode'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);

    if (($row['active_t'] == "1") and ( $row['active_t1'] == "1")) {
        $msg = "Item Locked";
    } else {
        $sql = "Insert into tmp_purord_data (tmp_no, str_invno, str_code, str_description, partno, qty,ctn,ctnqty)values 
				('" . $_SESSION["tmp_no_purord"] . "', '" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', '" . $_GET["partno"] . "', " . $qty . ",'" . $_GET["ctn"] . "','" . $_GET["ctnqty"] . "') ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    }
    $ResponseXML .= "<msg><![CDATA[" . $msg . "]]></msg>";
    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"150\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"400\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">CTN</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">CTN Qty1</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">TOT Qty</font></td>
                             
                            </tr>";


    $sql = "Select * from tmp_purord_data where tmp_no='" . $_SESSION['tmp_no_purord'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>                              
                             <td >" . $row['str_code'] . "</a></td>
							 <td >" . $row['str_description'] . "</a></td>
							 <td >" . $row['partno'] . "</a></td>
							 <td >" . number_format($row['ctn'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['ctnqty'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['qty'], 2, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td></tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}


if ($_GET["Command"] == "purord") {

    //$department=$_GET["department"];
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $_SESSION["update"] = 1;

    $sql = "select * from s_ordmas where REFNO='" . $_GET['invno'] . "' ";

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

    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql = "select * from s_ordtrn where REFNO='" . $_GET['invno'] . "' ";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $sql1 = "Insert into tmp_purord_data (tmp_no, str_invno, str_code, str_description, partno, qty,ctn,ctnqty)values 
				('" . $_SESSION['tmp_no_purord'] . "', '" . $row['REFNO'] . "', '" . $row['STK_NO'] . "', '" . $row['DESCRIPT'] . "', '" . $row["partno"] . "', " . $row["ORD_QTY"] . ",'" . $row["ctn"] . "','" . $row["ctnqty"] . "') ";

        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }






    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"150\"  background=\"\" >Code</td>
                              <td width=\"400\"  background=\"\">Description</td>
                              <td width=\"100\"  background=\"\">Part No</td>
                              <td width=\"100\"  background=\"\">CTN</td>
                              <td width=\"100\"  background=\"\">CTN Qty</td>
                              <td width=\"100\"  background=\"\">TOT Qty</td>
                             
                            </tr>";


    $sql = "Select * from tmp_purord_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>                              
                             <td >" . $row['str_code'] . "</a></td>
							 <td>" . $row['str_description'] . "</a></td>
							 <td >" . $row['partno'] . "</a></td>
							 <td >" . number_format($row['ctn'], 0, ".", ",") . "</a></td>
							 <td >" . number_format($row['ctnqty'], 0, ".", ",") . "</a></td>
							 <td >" . number_format($row['qty'], 0, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td></tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";
    $log = "";

    $sql = "select * from entry_log where refno ='" . $_GET['invno'] . "' order by id";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $log .= $row['username'] . "/" . $row['stime'] . "<br>";
    }

    $ResponseXML .= "<log><![CDATA[" . $log . "]]></log>";

    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}


if ($_GET["Command"] == "del_item") {


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_purord_data where str_code='" . $_GET['code'] . "' and tmp_no='" . $_SESSION["tmp_no_purord"] . "' ";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"150\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"400\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">CTN</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">CTN Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">TOT Qty</font></td>
                            </tr>";


    $sql = "Select * from tmp_purord_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td >" . $row['str_code'] . "</a></td>
							 <td >" . $row['str_description'] . "</a></td>
							 <td >" . $row['partno'] . "</a></td>
							 <td >" . $row['ctn'] . "</a></td>
							 <td >" . $row['ctnqty'] . "</a></td>
							 <td >" . $row['qty'] . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td></tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";


    //	}	


    echo $ResponseXML;
}



if ($_GET["Command"] == "save_item") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

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
        $sql1 = "insert into s_ordtrn(REFNO, SDATE, STK_NO, DESCRIPT, ORD_QTY, partno, CANCEL, tmp_no,ctn,ctnqty) values ('" . $row["str_invno"] . "', '" . $_GET["invdate"] . "', '" . $row["str_code"] . "','" . $row["str_description"] . "','" . $row["qty"] . "','" . $row["partno"] . "','0', '" . $_SESSION['tmp_no_purord'] . "','" . $row["ctn"] . "','" . $row["ctnqty"] . "')";
        //echo $sql1;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql = "select * from s_mas where stk_no = '" . $row['str_code'] . "'";
        $result_i = mysqli_query($GLOBALS['dbinv'], $sql);
        $row_i = mysqli_fetch_array($result_i);

        if ($row_i['active_t'] == "1") {
            $sql = "update s_mas set active_t1 = '1' where stk_no = '" . trim($row['str_code']) . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
        }
    }
    //$_SESSION["print"]=1;



    $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_GET["invno"] . "', '" . $_SESSION["CURRENT_USER"] . "', 'Order', 'SAVE', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
    $result = mysqli_query($GLOBALS['dbinv'], $sql2);

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
}

if ($_GET["Command"] == "calcu") {
   header('Content-Type: text/xml');
     


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $total = 0;
    if ($_GET["ctn"] != '') {
        
        if ($_GET["ctnqty"] != '') { 
            $total =  $_GET["ctn"] * $_GET["ctnqty"] ; 
        } else {

            $total = 0;
        }
    }

   
    $tot = number_format($total);

    $ResponseXML .= "<toot><![CDATA[$tot]]></toot>";
 $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

?>