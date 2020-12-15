
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

        $conn->commit();
        echo "Updated";

    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}



?>