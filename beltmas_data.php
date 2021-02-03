<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_POST["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT belt FROM invpara";
    $result = $conn->query($sql);

    $row = $result->fetch();
    $no = $row['belt'];
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

        $sqlisalma_q = "select * from belt where code='" . $_POST['code'] . "'";
        $resultsalma_q = $conn->query($sqlisalma_q);
        if ($rowsalma_q = $resultsalma_q->fetch()) {
            
            $sql = "update belt set name= '" . $_POST['des'] . "'   where code='" . $_POST['code'] . "'";
            $result = $conn->query($sql);
            
            $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST['code']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'BELT', 'Update', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultlog = $conn->query($sqllog);

            $conn->commit();
            echo "Updated";
        }else{
            $sql2 = "insert into belt(code,name) values ('" . $_POST['code'] . "' , '" . $_POST['des'] . "')"; 
            $result2 = $conn->query($sql2);

            $sql = "SELECT belt FROM invpara";
            $resul = $conn->query($sql);
            $row = $resul->fetch();
            $no = $row['belt'];
            $no2 = $no + 1;
            $sql = "update invpara set belt = $no2 where belt = $no";
            $result = $conn->query($sql);

            
             $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST['code']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'BELT', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
             $resultlog = $conn->query($sqllog);
    
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

    $sql = "Select * from belt where   code ='" . $cuscode . "'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

?>