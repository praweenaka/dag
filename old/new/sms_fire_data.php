<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("./connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');



if ($_GET["Command"] == "filter") {
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<sales_table><![CDATA[";
    $Rep = "";
    $Message = "";
    $Message1 = "";
    $Message2 = "";
    $Message3 = "";

    $sql = "Select * from view_s_cheq_s_salrep where CR_DATE='" . $_GET['filterdate'] . "' order by S_REF"; 
    $AMSG = "";

    foreach ($conn->query($sql) as $row) {

        $sql1 = "Select * from view_brtrn_vendor where cus_code='" . $row['CR_C_CODE'] . "'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch();

        if ($Rep != $row['Name']) {

            $Message2 = $row['Name'] . "\n";
            $Rep = $row['Name'];
        } else {
            $Message2 = "";
        }
        $Message3 = "" . number_format($row['CR_CHEVAL'], 2, ".", ",") . " /- (" . $row['reason'] . ")  " . $row['CR_C_NAME'] . "";
        $Message = $Message2 . $Message3 . "\n";
        $AMSG = $AMSG . $Message;
    }

    $Message1 = " " . trim($_GET["filterdate"]) . " RTN CHQS - THT \n";
    $ResponseXML .= "<textarea name='message' id='message' cols='110' rows='19'>$Message1$AMSG</textarea>";

    $ResponseXML .= "]]></sales_table>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}



if ($_GET["Command"] == "fire") {

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();

        $cusMessage = $_GET["message"];
        $con1 = $_GET["con1"];
        $con2 = $_GET["con2"];

        $cusMessage = urlencode($cusMessage);

        $url = "http://203.153.222.25:5000/sms/send_sms.php?username=perera_tyre&password=pts2018&src=Perera%20Tyre&dst=94779515540&msg=$cusMessage";
        $sendrequest = file_get_contents($url);

        $url = "http://203.153.222.25:5000/sms/send_sms.php?username=perera_tyre&password=pts2018&src=Perera%20Tyre&dst=$con1&msg=$cusMessage";
        $sendrequest = file_get_contents($url);
        
        $url = "http://203.153.222.25:5000/sms/send_sms.php?username=perera_tyre&password=pts2018&src=Perera%20Tyre&dst=$con2&msg=$cusMessage";
        $sendrequest = file_get_contents($url);

        echo "Sended";

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}

 