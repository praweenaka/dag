<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connectioni.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "new_inv") {

    $sql = "select QTNNO from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["QTNNO"];
    $lenth = strlen($tmpinvno);
    $invno = trim("O/") . substr($tmpinvno, $lenth - 7);

    $sql = "Select QTNNO from tmpinvpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);

    $tono = $row['QTNNO'];

    $sql = "delete from tmp_po_data where tmp_no='" . $tono . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql = "update tmpinvpara set QTNNO=QTNNO+1";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<tmpno><![CDATA[" . $tono . "]]></tmpno>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "add_tmp") {

    if (!isset($_SESSION['CURRENT_REP'])) {
        header('Location: http://220.247.244.155/Admin/');
        exit;
    }


    if ($_GET["tmpno"] == "") {
        exit("Error");
    }


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = "delete from tmp_po_data where stk_no='" . $_GET['itemCode'] . "' and tmp_no='" . $_GET['tmpno'] . "' ";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $rate = str_replace(",", "", $_GET["itemPrice"]);
    $qty = str_replace(",", "", $_GET["qty"]);

    $discount = 0;
    $subtotal = $rate * $qty;

    $sql = "Insert into tmp_po_data (stk_no, descript,rate,qty,subtot, tmp_no)values 
			('" . $_GET['itemCode'] . "', '" . $_GET['itemDesc'] . "', " . $_GET['itemPrice'] . ", " . $_GET['qty'] . ",'" . $subtotal . "','" . $_GET['tmpno'] . "') ";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if (!$result) {
        echo $sql . "<br>";
        echo mysqli_error($GLOBALS['dbinv']);
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">Item</td>
						<td>Description</td>
						<td style=\"width: 60px;\">Qty</td>
						<td style=\"width: 100px;\">Rate</td>
						<td style=\"width: 100px;\">Sub Total</td>
						<td style=\"width: 10px;\"></td>
					</tr>";

    $i = 1;
    $sql = "Select * from tmp_po_data where tmp_no='" . $_GET['tmpno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $rate = "rate" . $i;
        $qty = "qty" . $i;
        $subtotal = "subtotal" . $i;

        $ResponseXML .= "<tr>                              
                         <td>" . $row['stk_no'] . "</td>
                         <td>" . $row['descript'] . "</td>
                         <td>" . number_format($row['qty'], 2, ".", ",") . "</td>
                         <td>" . number_format($row['rate'], 0, ".", ",") . "</td>
                         <td>" . number_format($row['subtot'], 2, ".", ",") . "</td>
                         <td><a class=\"btn btn-default\" onClick=\"del_item('" . $row['stk_no'] . "')\"> <span class='fa fa-remove'></span></a></td>
                         </tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

    $sql = "Select sum(subtot) as tot_sub from tmp_po_data where tmp_no='" . $_GET['tmpno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);


    $mbrand = $_GET["brand"];
    if (trim($mbrand) == "") {
        $mbrand = "CHENG SHING";
    }

    $sql1 = mysqli_query($GLOBALS['dbinv'], "select * from brand_mas where barnd_name='" . trim($mbrand) . "'") or die(mysqli_error());
    $sql = "select * from brand_mas where barnd_name='" . trim($mbrand) . "'";

    if ($row1 = mysqli_fetch_array($sql1)) {
        $mdis = $row1["dis"];
    }


    $mtot = ($row['tot_sub'] - (($row['tot_sub'] * $mdis) / 100));

    $ResponseXML .= "<subtot><![CDATA[" . number_format($mtot, 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "del_item") {

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $sql = "delete from tmp_po_data where stk_no='" . $_GET['code'] . "' and tmp_no='" . $_GET['tmpno'] . "'";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">Item</td>
						<td>Description</td>
						<td style=\"width: 60px;\">Qty</td>
						<td style=\"width: 100px;\">Rate</td>
						<td style=\"width: 100px;\">Sub Total</td>
						<td style=\"width: 10px;\"></td>
					</tr>";

    $i = 1;
    $sql = "Select * from tmp_po_data where tmp_no='" . $_GET['tmpno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $rate = "rate" . $i;
        $qty = "qty" . $i;
        $subtotal = "subtotal" . $i;

        $ResponseXML .= "<tr>                              
                         <td>" . $row['stk_no'] . "</td>
                         <td>" . $row['descript'] . "</td>
                         <td>" . number_format($row['qty'], 2, ".", ",") . "</td>
                         <td>" . number_format($row['rate'], 0, ".", ",") . "</td>
                         <td>" . number_format($row['subtot'], 2, ".", ",") . "</td>
                         <td><a class=\"btn btn-default\" onClick=\"del_item('" . $row['stk_no'] . "')\"> <span class='fa fa-remove'></span></a></td>
                         </tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

    $sql = "Select sum(subtot) as tot_sub from tmp_po_data where tmp_no='" . $_GET['tmpno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);

    $mbrand = $_GET["brand"];
    if (trim($mbrand) == "") {
        $mbrand = "CHENG SHING";
    }


    $sql1 = mysqli_query($GLOBALS['dbinv'], "select * from brand_mas where barnd_name='" . trim($mbrand) . "'") or die(mysqli_error());
    $sql = "select * from brand_mas where barnd_name='" . trim($mbrand) . "'";

    if ($row1 = mysqli_fetch_array($sql1)) {
        $mdis = $row1["dis"];
    }

    $mtot = ($row['tot_sub'] - (($row['tot_sub'] * $mdis) / 100));


    $ResponseXML .= "<subtot><![CDATA[" . number_format($mtot, 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "save_item") {


    if ($_GET["tmpno"] == "") {
        exit("Error");
    }

    $sql = "select QTNNO from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["QTNNO"];
    $lenth = strlen($tmpinvno);
    //echo $tmpinvno;
    $invno = trim("O/") . substr($tmpinvno, $lenth - 7);

    $sql = "delete from s_quomas where REF_NO='" . $invno . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $subtot = str_replace(",", "", $_GET["subtot"]);

    $idate = date('Y-m-d');
    $mbrand = $_GET["brand"];
    if (trim($mbrand) == "") {
        $mbrand = "CHENG SHING";
    }


    $sql1 = mysqli_query($GLOBALS['dbinv'], "select * from brand_mas where barnd_name='" . trim($mbrand) . "'") or die(mysqli_error());
    $sql = "select * from brand_mas where barnd_name='" . trim($mbrand) . "'";

    if ($row1 = mysqli_fetch_array($sql1)) {
        $mdis = $row1["dis"];
    }

    $mtot = 0;

    $sqltmp1 = "select * from tmp_po_data where tmp_no='" . $_GET["tmpno"] . "'";
    $resulttmp1 = mysqli_query($GLOBALS['dbinv'], $sqltmp1);
    while ($rowtmp1 = mysqli_fetch_array($resulttmp1)) {

        $mdisv = (($rowtmp1["rate"] * $rowtmp1["qty"]) * $mdis / 100);
        $mval = ($rowtmp1["rate"] * $rowtmp1["qty"]) - $mdisv;
        $mtot = $mtot + $mval;
        $mtot1 = $mtot1 + ($rowtmp1["rate"] * $rowtmp1["qty"]);

        $sql = "Insert into s_quotrn1 (REF_NO, SDATE, STK_NO, DESCRIPT,  PRICE, QTY,dis_per,brand,dis_rs,department) values 
		('" . trim($invno) . "', '" . $idate . "','" . $rowtmp1["stk_no"] . "','" . $rowtmp1["descript"] . "', " . $rowtmp1["rate"] . "," . $rowtmp1["qty"] . ",'" . $mdis . "','" . $_GET["brand"] . "','" . $mdisv . "','" . $_SESSION["CURRENT_DEP"] . "')";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    }

    $sql = "insert s_quomas1 (REF_NO, SDATE, C_CODE, CUS_NAME, GRAND_TOT,SAL_EX,brand,amount,dis,department) values 
	('" . $invno . "', '" . $idate . "', '" . $_GET["customercode"] . "', '" . $_GET["customername"] . "' , " . $mtot . ",'" . $_SESSION["CURRENT_REP"] . "','" . $mbrand . "','" . $mtot1 . "','" . $mdis . "','" . $_SESSION["CURRENT_DEP"] . "')";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $invno . "', '" . $_SESSION["CURRENT_USER"] . "', 'Order', 'SAVE', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
    $result = mysqli_query($GLOBALS['dbinv'], $sql2);



    $sql = "update invpara set QTNNO=QTNNO+1";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    echo "Saved";
}


if ($_GET["Command"] == "setbrand") {
    $_SESSION["brand"] = $_GET['brand'];
    echo $_SESSION["brand"];
}
?>