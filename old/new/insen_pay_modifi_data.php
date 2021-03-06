<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("./connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');



if ($_GET["Command"] == "save_item") {

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        $year = date("Y", strtotime($_GET["sdate"]));
        $month = date("m", strtotime($_GET["sdate"]));

        $sql1 = "select * from ins_payment where cusCode ='" . $_GET['code'] . "' and year(indate)='" . $year . "' and  month(indate)='" . $month . "' and Type='" . $_GET['brand'] . "'";
        $result1 = $conn->query($sql1);
        if ($row1 = $result1->fetch()) {
            $des = $row1['remarks'];
            $sql = "update ins_payment set remarks='$des&nbsp;" . $_GET['des'] . "' where cusCode ='" . $_GET['code'] . "' and year(indate)='" . $year . "' and  month(indate)='" . $month . "' and  Type='" . $_GET['brand'] . "'";
            $result = $conn->query($sql);

            $sqlbrand = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_GET['code'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'Inc Cre Pay Modifi ', '" . $_GET['des'] . " updated', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultbrand = $conn->query($sqlbrand);

            $conn->commit();
            echo "Saved";
        } else {
            echo "No Result Found...";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}


