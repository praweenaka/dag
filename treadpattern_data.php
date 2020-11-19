<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_POST["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT pattern FROM invpara";
    $result = $conn->query($sql);

    $row = $result->fetch();
    $no = $row['pattern'];
    $uniq = uniqid();
    $ResponseXML .= "<id><![CDATA[$no]]></id>";
    $ResponseXML .= "<uniq><![CDATA[$uniq]]></uniq>";

    $ResponseXML .= "</new>";

    echo $ResponseXML;
}


if ($_POST["Command"] == "save_inv") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $sql2 = "insert into pattern(code,name) values ('" . $_POST['code'] . "', '" . $_POST['pattern'] . "')"; 
        $result2 = $conn->query($sql2);

        $sql = "SELECT pattern FROM invpara";
        $resul = $conn->query($sql);
        $row = $resul->fetch();
        $no = $row['pattern'];
        $no2 = $no + 1;
        $sql = "update invpara set pattern = $no2 where pattern = $no";
        $result = $conn->query($sql);
        

        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
    
}
?>