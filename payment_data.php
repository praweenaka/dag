<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_POST["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT payment FROM invpara";
    $result = $conn->query($sql); 
    $row = $result->fetch();
    $no = $row['payment'];
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
        
        $sqlisalma_q = "select * from payment where refno='" . $_POST['invno'] . "'";
        $resultsalma_q = $conn->query($sqlisalma_q);
        if ($rowsalma_q = $resultsalma_q->fetch()) {
            $conn->rollBack(); 
            exit("Already Saved Payment !!!"); 
        } 
        
        $sql2 = "insert into payment(refno,name,amount,sdate,remark,type) values ('" . $_POST['invno'] . "', '" . $_POST['name'] . "','" . $_POST['amount'] . "','" . $_POST['sdate'] . "','" . $_POST['remark'] . "','" . $_POST['ptype'] . "')"; 
        $result2 = $conn->query($sql2);

        $sql1 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values
        ('" . $_POST['invno'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'PAYMENT', 'SAVE', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $result1 = $conn->query($sql1);
        
        $sql = "SELECT payment FROM invpara";
        $resul = $conn->query($sql);
        $row = $resul->fetch();
        $no = $row['payment'];
        $no2 = $no + 1;
        $sql = "update invpara set payment = $no2 where payment = $no";
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

    $sql = "Select * from payment where   refno ='" . $cuscode . "'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }
 

   $ResponseXML .= "</salesdetails>";
   echo $ResponseXML;
}


if ($_POST["Command"] == "cancel_inv") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        
        
            $sql = "update payment set cancel = '1' where  refno='".$_POST['invno']."' ";
            $result = $conn->query($sql);
             
           $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST['invno']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'PAYMENT', 'CANCEL', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultlog = $conn->query($sqllog);
         
            $conn->commit();
            echo "Cancel";
        

    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

?>