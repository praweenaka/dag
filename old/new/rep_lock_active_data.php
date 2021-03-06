<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("./connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');


if ($_GET["Command"] == "update_inv") {

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();


        $sql11 = "Select * from s_commadva where rep='" . $_GET['name'] . "'  and month(comdate)='" . date("m", strtotime($_GET["months"])) . "' and  year(comdate)='" . date("Y", strtotime($_GET["months"])) . "' and FLAG='" . $_GET['type'] . "'";
       
        $result11 = $conn->query($sql11);
        if ($row11 = $result11->fetch()) {

            $sql = "update s_commadva set Lock1='0' where rep='" . $row11['rep'] . "' and month(comdate)='" . date("m", strtotime($_GET["months"])) . "' and  year(comdate)='" . date("Y", strtotime($_GET["months"])) . "' and FLAG='" . $_GET['type'] . "'";
            $result = $conn->query($sql);

            $sqlbrand = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $row11['rep'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'RepActive', 'Active', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $result11 = $conn->query($sqlbrand);

            echo "Saved";
        } else {
            echo "No  Result...!!";
        } 
        
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

