<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_POST["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT sizemas FROM invpara";
    $result = $conn->query($sql);

    $row = $result->fetch();
    $no = $row['sizemas'];
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

        $sqlisalma_q = "select * from design where code='" . $_POST['code'] . "'";
        $resultsalma_q = $conn->query($sqlisalma_q);
        if ($rowsalma_q = $resultsalma_q->fetch()) {
            
            $sql = "update size set name= '" . $_POST['des'] . "'   where code='" . $_POST['code'] . "'";
            $result = $conn->query($sql);

            $conn->commit();
            echo "Updated";
        }else{
            $sql2 = "insert into size(code,name) values ('" . $_POST['code'] . "' , '" . $_POST['des'] . "')"; 
            $result2 = $conn->query($sql2);

            $sql = "SELECT sizemas FROM invpara";
            $resul = $conn->query($sql);
            $row = $resul->fetch();
            $no = $row['sizemas'];
            $no2 = $no + 1;
            $sql = "update invpara set sizemas = $no2 where sizemas = $no";
            $result = $conn->query($sql);


            $conn->commit();
            echo "Saved";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
    
}
?>