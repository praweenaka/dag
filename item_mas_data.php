<?php

session_start();


require_once ("connection_sql.php");


date_default_timezone_set('Asia/Colombo');
if ($_POST["Command"] == "getdt") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";

    $sql = "SELECT ITEMMAS FROM invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();
    $no = $row['ITEMMAS'];

    $uniq = uniqid();

    $tmpinvno = "0000" . $no;
    $lenth = strlen($tmpinvno);
    $no = trim("P/") . substr($tmpinvno, $lenth - 5);

    $ResponseXML .= "<code><![CDATA[$no]]></code>";
    $ResponseXML .= "<uniq><![CDATA[$uniq]]></uniq>"; 

    $ResponseXML .= "</new>";

    echo $ResponseXML;
}



if ($_POST["Command"] == "save_item") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        
        $sql = "SELECT * from s_mas where  stk_no  = '" . $_POST['code'] . "' and cancel='1'"; 
        $result = $conn->query($sql);
        if ($row = $result->fetch()) {
            exit("Already Canceled Item No...!!!");
        }

        
        $sql = "Select * from s_stomas where act='0'";
        foreach ($conn->query($sql) as $row) {
            $M_STOCODE = $row["CODE"];

            $sql1 = "select * from s_submas where sto_code= '" . trim($M_STOCODE) . "' and stk_no= '" . trim($_POST["code"]) . "'";
            $result1 = $conn->query($sql1);
            if ($row1 = $result1->fetch()) {
                $sql2 = "update s_submas set STO_CODE='" . trim($M_STOCODE) . "', STK_NO='" . $_POST["code"] . "', DESCRIPt='" . $_POST["des"] . "' where  sto_code= '" . trim($M_STOCODE) . "' and stk_no= '" . trim($_POST["code"]) . "'";
                $result2 = $conn->query($sql2);
            } else {
                $sql2 = "Insert into s_submas (STO_CODE, STK_NO, DESCRIPt) values ('" . trim($M_STOCODE) . "', '" . $_POST["code"] . "', '" . $_POST["des"] . "')";
                $result2 = $conn->query($sql2);
            }


        }
        

        $sql3 = "SELECT * FROM s_mas WHERE stk_no = '" . trim($_POST["code"]) . "'";
        $result3 = $conn->query($sql3);
        if ($row3 = $result3->fetch()) {

            $sql2 = "update s_mas set   SDATE='" . date("Y-m-d") . "', DESCRIPT='" . $_POST["des"] . "', BRAND_NAME='" . $_POST["brand"] . "',   PART_NO='" . $_POST["partno"] . "',  type='" . $_POST["type"] . "',COST='" . $_POST["cost"] . "',SELLING='" . $_POST["rprice"] . "',whprice='" . $_POST["whprice"] . "', country = '" . trim($_POST["country"]) . "',rack = '" . trim($_POST["rack"]) . "',row = '" . trim($_POST["rows"]) . "',colum = '" . trim($_POST["column"]) . "',whdis = '" . trim($_POST["whdis"]) . "',rdis = '" . trim($_POST["rdis"]) . "' WHERE stk_no = '" . trim($_POST["code"]) . "'";  
            $result2 = $conn->query($sql2);

            $sql8 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_POST['code'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'Item', 'Update', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $result8 = $conn->query($sql8);


            echo "Updated";

        } else {

            $sql2 = "Insert into s_mas (SDATE, stk_no, DESCRIPT, BRAND_NAME, PART_NO,country,COST,SELLING,whprice,whdis,rdis,rack,row,colum) values ('" . date("Y-m-d") . "','" . $_POST["code"] . "','" . $_POST["des"] . "','" . $_POST["brand"] . "','" . $_POST["partno"] . "','" . $_POST["country"] . "','" . $_POST["cost"] . "','" . $_POST["rprice"] . "','" . $_POST["whprice"] . "','" . $_POST["whdis"] . "','" . $_POST["rdis"] . "','" . $_POST["rack"] . "','" . $_POST["rows"] . "','" . $_POST["column"] . "')";
             $result2 = $conn->query($sql2);

            $sql4 = "update invpara set ITEMMAS=ITEMMAS+1";
            $result4 = $conn->query($sql4);

            $sql8 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_POST['code'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'Item', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $result8 = $conn->query($sql8);


            echo "Saved";
        }

        $conn->commit();

    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

if ($_POST["Command"] == "pass_quot") {
    $_SESSION["custno"] = $_POST['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_POST["custno"];

    $sql = "Select * from s_mas where   STK_NO ='" . $cuscode . "'";  
    $sql = $conn->query($sql);

    if ($rowM = $sql->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }


    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_POST["Command"] == "cancel_inv") {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        $sql = "SELECT * from s_mas where stk_no='" . $_POST['code'] . "'";

        $result = $conn->query($sql);
        if ($row = $result->fetch()) {

            $sql = "UPDATE s_mas set cancel='1' where stk_no='" . $_POST['code'] . "'";
            $result = $conn->query($sql);
            

            $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_POST['code'] . "', '" . $_SESSION["CURRENT_USER"] . "', 'Item', 'Cancel', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $result2 = $conn->query($sql2);

            $conn->commit();
            echo "Cancel";
        } else {
            exit("Item Not Found...!!!");
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}


?>