<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_POST["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT expense FROM invpara";
    $result = $conn->query($sql);

    $row = $result->fetch();
    $no = $row['expense'];
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

        $sqlisalma_q = "select * from expenses where code='" . $_POST['code'] . "'";
        $resultsalma_q = $conn->query($sqlisalma_q);
        if ($rowsalma_q = $resultsalma_q->fetch()) {

            $sql = "update expenses set name='" . $_POST['name'] . "', des= '" . $_POST['des'] . "',cost='" . $_POST['cost'] . "'  where code='" . $_POST['code'] . "'";
            $result = $conn->query($sql);

            $conn->commit();
            echo "Updated";
        }else{
            $sql2 = "insert into expenses(code,name,des,cost) values ('" . $_POST['code'] . "', '" . $_POST['name'] . "', '" . $_POST['des'] . "', '" . $_POST['cost'] . "')"; 
            $result2 = $conn->query($sql2);

            $sql = "SELECT expense FROM invpara";
            $resul = $conn->query($sql);
            $row = $resul->fetch();
            $no = $row['expense'];
            $no2 = $no + 1;
            $sql = "update invpara set expense = $no2 where expense = $no";
            $result = $conn->query($sql);


            $conn->commit();
            echo "Saved";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
    
}

if ($_POST["Command"] == "pass_quot") {
    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_POST["custno"];

    $sql = "Select * from expenses where   code ='" . $cuscode . "'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

?>