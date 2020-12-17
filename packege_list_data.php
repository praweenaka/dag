<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_POST["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT packegelist FROM invpara";
    $result = $conn->query($sql);

    $row = $result->fetch();
    $no = $row['packegelist'];
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

        $sqlisalma_q = "select * from packegelist where code='" . $_POST['code'] . "'";
        $resultsalma_q = $conn->query($sqlisalma_q);
        if ($rowsalma_q = $resultsalma_q->fetch()) {

            $sql = "update packegelist set design='" . $_POST['design'] . "',size='" . $_POST['size'] . "', des= '" . $_POST['des'] . "'   where code='" . $_POST['code'] . "'";
            $result = $conn->query($sql);

            $conn->commit();
            echo "Updated";
        }else{
            $sql2 = "insert into packegelist(code,design,des,size) values ('" . $_POST['code'] . "', '" . $_POST['design'] . "', '" . $_POST['des'] . "','" . $_POST['size'] . "')"; 
            $result2 = $conn->query($sql2);

            $sql = "SELECT packegelist FROM invpara";
            $resul = $conn->query($sql);
            $row = $resul->fetch();
            $no = $row['packegelist'];
            $no2 = $no + 1;
            $sql = "update invpara set packegelist = $no2 where packegelist = $no";
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

    $sql = "Select * from packegelist where   code ='" . $cuscode . "'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}
?>