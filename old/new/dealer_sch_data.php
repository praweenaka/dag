<?php

session_start();
date_default_timezone_set('Asia/Colombo');
require_once('connection_sql.php');


if ($_GET["Command"] == "new_inv") {



    $sql = "Select dealer_shr from tmpinvpara";
    $result = $conn->query($sql);
    $row = $result->fetch();

    $tono = $row['dealer_shr'];

    $sql = "update tmpinvpara set dealer_shr=dealer_shr+1";
    $result = $conn->query($sql);

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<tmpno><![CDATA[" . $tono . "]]></tmpno>";
    $ResponseXML .= "<dt><![CDATA[" . date('Y-m-d') . "]]></dt>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET['Command'] == "add_tmp") {


    $sql = "delete from tmp_dlr_sch where ref_no = '" . $_GET['ref_no'] . "'";


    $sql = "insert into tmp_dlr_sch (tmp_no,c_code,c_name,inv_amo,out_amo) values 
	('" . $_GET['tmpno'] . "','" . $_GET['c_code'] . "','" . $_GET['c_name'] . "','" . $_GET['inv_amo'] . "','" . $_GET['out_amo'] . "')";
    $results = $conn->query($sql);


    $tb = "<table  class=\"table\">";
    $tb .= "<tr> 
					
					<th style=\"width : 320px;\">Dealer Name</th>
					<th style=\"width : 50px;\"></th>					
					
					<th style=\"width : 120px;\">Outstanding Amount</th>				
					<th style=\"width : 120px;\">Return Amount</th>	
					<th style=\"width : 50px;\"></th></tr>";

    $sql = "select * from tmp_dlr_sch where tmp_no = '" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $tb .= "<tr> 
					
					<td>" . $row['c_name'] . "</td>
					<td></td>		
					<td>" . $row['inv_amo'] . "</td>
					<td>" . $row['out_amo'] . "</td>										
					<td><a class=\"btn btn-danger btn-xs\" onclick=\"del_item('" . $row['id'] . "');\"> <span class='fa fa-remove'></span></a></td></tr>";
    }
    $tb .= "</table>";
    echo $tb;
}


if ($_GET["Command"] == "save") {



    $sql = "select * from tmp_dlr_sch where tmp_no = '" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $sql = "insert into dlr_sch (sdate,c_code,c_name,outst,retch,tmpno,rep) values 
	('" .  date('Y-m-d') . "','" . $row["c_code"] . "', '" . $row["c_name"] . "', '" . $row["inv_amo"] . "', '" . $row["out_amo"] . "','" . $_GET['tmpno'] . "','" . $_GET['rep'] . "')";
		 
        $results = $conn->query($sql);
    }

    if (!$results) {
        echo "Not saved! $sql";
    } else {
        echo "Successfully Saved!";
    }
}

if ($_GET["Command"] == "email") {

     

    require 'PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();

    $mail->Host = 'gator4088.hostgator.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "it@tyrehouse.com";
    $mail->Password = "123456";
    $mail->setFrom('it@tyrehouse.com', 'IT Admin');

    $mail->addAddress('praweenakahemachandra@gmail.com');
 
 
 

    $sql = "select Name from s_salrep where REPCODE = '" . $_GET["rep"] . "'";
    $results = $conn->query($sql);
    $row = $results->fetch();

    $body = "";

    $body .= "Dealer Visit Shedule " . $row["Name"] . "</br>";
    $sql = "select * from dlr_sch where tmpno = '" . $_GET['tmpno'] . "'";
	$tb = "<table border=\"1\" class=\"table\">";
	$body .= "<tr> 
				<th style=\"width : 320px;\">Dealer Name</th>
				<th style=\"width : 220px;\">Outstanding Amount</th>				
				<th style=\"width : 120px;\">Return Amount</th>	
				</tr>";
	
    foreach ($conn->query($sql) as $row) {

        $body .= "<tr> 
					
					<td>" . $row['c_name'] . "</td> 		
					<td align='right'>" . number_format($row['outst'], 0, ".", ",") . "</td>
					<td align='right'>" . number_format($row['retch'], 0, ".", ",") . "</td>										
				</tr>";
    }


    $mail->Body = $body;
    $mail->Subject = 'New Dealer Visit Schedule by ' . $row["Name"] ;

    $mail->isHTML(true);

	$mail->send();
 

    if (!$results) {
        echo "Not Sent! $sql";
    } else {
        echo "Email Sent";
    }
}

if ($_GET["Command"] == "setRep") {
    $_SESSION["refRep"] = $_GET["rep"];
    echo "session item refRep is set to " . $_SESSION["refRep"];
}

if ($_GET["Command"] == "pass_rmk") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = "Select * from dlr_rmk where id='" . $_GET["id"] . "' ";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $ResponseXML .= "<id><![CDATA[" . $row['c_code'] . "]]></id>";
        $ResponseXML .= "<str_customername><![CDATA[" . $row['c_name'] . "]]></str_customername>";

        $ResponseXML .= "<outst><![CDATA[" . $row['outst'] . "]]></outst>";
        $ResponseXML .= "<retch><![CDATA[" . $row['retch'] . "]]></retch>";

        $ResponseXML .= "<date><![CDATA[" . $row['date'] . "]]></date>";
        $ResponseXML .= "<remark><![CDATA[" . $row['remark'] . "]]></remark>";
        $ResponseXML .= "<loc><![CDATA[" . $row['loc'] . "]]></loc>";
        $ResponseXML .= "<tgt><![CDATA[" . $row['tgt'] . "]]></tgt>";
        $ResponseXML .= "<ord><![CDATA[" . $row['ord'] . "]]></ord>";
    }
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}
?>
