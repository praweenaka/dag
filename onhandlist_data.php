
<?php

session_start();


require_once ("connection_sql.php");
header('Content-Type: text/xml');
date_default_timezone_set('Asia/Colombo');
if ($_POST["Command"] == "sendproduction") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        

        $sql = "UPDATE dag_item set flag='1',onhand_date='" . date("Y-m-d") . "'  where id='" . $_POST['id'] . "'";
        $result = $conn->query($sql); 
        
        $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST['id']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'SEND ONHAND TO PRO', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $resultlog = $conn->query($sqllog);
        
        $conn->commit();
        echo "SEND PRODUCTION";

    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}



?>