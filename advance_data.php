<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_POST["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT advance FROM invpara";
    $result = $conn->query($sql); 
    $row = $result->fetch();
    $no = $row['advance'];
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

        $sql2 = "insert into advance(refno,name,amount,sdate,remark) values ('" . $_POST['invno'] . "', '" . $_POST['name'] . "','" . $_POST['amount'] . "','" . $_POST['sdate'] . "','" . $_POST['remark'] . "')"; 
        $result2 = $conn->query($sql2);

        $sql1 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values
        ('" . $_POST['invno'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'ADVANCE', 'SAVE', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $result1 = $conn->query($sql1);
        
        $sql = "SELECT advance FROM invpara";
        $resul = $conn->query($sql);
        $row = $resul->fetch();
        $no = $row['advance'];
        $no2 = $no + 1;
        $sql = "update invpara set advance = $no2 where advance = $no";
        $result = $conn->query($sql);
        

        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
    
}


if ($_GET["Command"] == "pass_quot") {
    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];

    $sql = "Select * from advance where   refno ='" . $cuscode . "'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }
 

   $ResponseXML .= "</salesdetails>";
   echo $ResponseXML;
}

?>