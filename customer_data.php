<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_POST["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT customer FROM invpara";
    $result = $conn->query($sql);

    $row = $result->fetch();
    $no = $row['customer'];
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

        $sqlisalma_q = "select * from vendor where code='" . $_POST['code'] . "'";
        $resultsalma_q = $conn->query($sqlisalma_q);
        if ($rowsalma_q = $resultsalma_q->fetch()) {
            $sql = "update vendor set cus_type = '" . $_POST['cus_type'] . "', name = '" . $_POST['name'] . "',shopname =  '" . $_POST['shopname'] . "',nic =  '" . $_POST['nic'] . "', TELE1 = '" . $_POST['land'] . "',TELE2 =  '" . $_POST['mobile'] . "', ADD1 = '" . $_POST['address'] . "'  where code='" . $_POST['code'] . "'";
            $result = $conn->query($sql);
            
            $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST['code']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'CUSTOMER', 'Update', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultlog = $conn->query($sqllog);
        
            $conn->commit();
            echo "Updated";
        }else{
            $sql2 = "insert into vendor(code,cus_type,NAME,shopname,nic,TELE1,TELE2,ADD1) values ('" . $_POST['code'] . "', '" . $_POST['cus_type'] . "', '" . $_POST['name'] . "', '" . $_POST['shopname'] . "', '" . $_POST['nic'] . "', '" . $_POST['land'] . "', '" . $_POST['mobile'] . "', '" . $_POST['address'] . "')"; 
            $result2 = $conn->query($sql2);

            $sql = "SELECT customer FROM invpara";
            $resul = $conn->query($sql);
            $row = $resul->fetch();
            $no = $row['customer'];
            $no2 = $no + 1;
            $sql = "update invpara set customer = $no2 where customer = $no";
            $result = $conn->query($sql);
            
            $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST['code']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'CUSTOMER', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
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

    $sql = "Select * from vendor where   CODE ='" . $cuscode . "'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }

    $ResponseXML .= "<stname><![CDATA[".$_POST["stname"]."]]></stname>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_POST["Command"] == "cancel_inv") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        
        
            $sql = "update vendor set cancel = '1' where  CODE='".$_POST['code']."' ";
            $result = $conn->query($sql);
            
            
         
           $sqllog = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST['refno']) . "', '" . $_SESSION["CURRENT_USER"] . "', 'CUSTOMER', 'CANCEL', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultlog = $conn->query($sqllog);
         
            $conn->commit();
            echo "Cancel";
       

        



    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>