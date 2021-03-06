<?php

session_start();
date_default_timezone_set('Asia/Colombo');
require_once('connectioni.php');

if ($_GET["Command"] == "save") {

$sql = "delete from dlr_rmk where date = '" . $_GET['invdate'] . "' and rep ='" .$_GET["sal_ex"]  . "'";
$results = mysqli_query($GLOBALS['dbinv'], $sql);


    $sql = "insert into dlr_rmk (date,rep,remark,loc,tgt,outst,retch,ord,outstCltd,retchStld,stime,ftime,mstart,mfini) 
	values ('" . $_GET['invdate'] . "', '" . $_GET["sal_ex"] . "','" . $_GET["rmk"] . "','" . $_GET["loc"] . "', '" . $_GET["target"] . "', '" . $_GET["outst"] . "', '" . $_GET["retch"] . "','" . $_GET["ord"] . "', '" . $_GET["outstCltd"] . "','" . $_GET["retchStld"] . "'
	,'" . $_GET['stime'] . "','" . $_GET['ftime'] . "','" . $_GET['mstart'] . "','" . $_GET['mfini'] . "')";
    $results = mysqli_query($GLOBALS['dbinv'], $sql);

    if (!$results) {
        echo "Not Saved! $sql";
    } else {
        echo "Successfully Saved!";
    }
}

if ($_GET["Command"] == "dele") {
 
 
 $sql = "delete from dlr_rmk where id ='" . $_GET['ref'] . "'";
  $results = mysqli_query($GLOBALS['dbinv'], $sql);

 
 
} 
 
if ($_GET["Command"] == "setRep") {
   
	
	
	 

    $sql = "SELECT * from dlr_rmk where rep = '" .  $_GET["rep"] . "'  order by date desc limit 35";


    $ResponseXML = "<table class='table table-bordered'><tr>";
	
	$ResponseXML .= "<td colspan='4'></td><th colspan='2'>Sales</th><th colspan='2'>Outstanding</th><th colspan='2'>Return Cheq.</th></tr><tr>";
	
    $ResponseXML .= "<td style=\"width: 350px;\">Date</td>";
    $ResponseXML .= "<td style=\"width: 350px;\">Start/End Time</td>";
    
	$ResponseXML .= "<td style=\"width: 350px;\">Route</td>";
	$ResponseXML .= "<td style=\"width: 350px;\">Dealer Count</td>";
	
	$ResponseXML .= "<td style=\"width: 350px;\">By Visit</td>";
    $ResponseXML .= "<td style=\"width: 350px;\">Over The Phone</td>";
	
	$ResponseXML .= "<td style=\"width: 350px;\">By Visit</td>";
	$ResponseXML .= "<td style=\"width: 350px;\">Pronto/Post/Collector</td>";

	$ResponseXML .= "<td style=\"width: 350px;\">By Visit</td>";
	$ResponseXML .= "<td style=\"width: 350px;\">Pronto/Post/Collector</td>";
	$ResponseXML .= "<td style=\"width: 80px;\"></td>";

	
    $ResponseXML .= "</tr>";



$result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $ResponseXML .= "<tr>";

        $ResponseXML .= "<td><a  href='#' onclick=\"load('" . $row['date'] . "','" . $row['stime'] . "','" . $row['ftime'] . "','" . $row['remark'] . "'
		,'" . $row['loc'] . "','" . $row['tgt'] . "','" . $row['ord'] . "','" . $row['outst'] . "','" . $row['outstCltd'] . "','" . $row['retch'] . "',
		'" . $row['retchStld'] . "','" . $row['mstart'] . "','" . $row['mfini'] . "')\";>" . $row['date'] . "</a></td>";

        $ResponseXML .= "<td>" . date("h:i A" ,strtotime($row['stime'])) . "/" . date("h:i A" ,strtotime($row['ftime'])) . "</td>";
		
		$ResponseXML .= "<td>" . $row['remark'] . "</td>";
     
        $ResponseXML .= "<td>" . $row['loc'] . "</td>";

		$ResponseXML .= "<td>" . number_format($row['tgt'], 2, ".", ",") . "</td>";

        $ResponseXML .= "<td>" . number_format($row['ord'], 2, ".", ",") . "</td>";
		
		$ResponseXML .= "<td>" . number_format($row['outst'], 2, ".", ",") . "</td>";

        $ResponseXML .= "<td>" . number_format($row['outstCltd'], 2, ".", ",") . "</td>";

		 $ResponseXML .= "<td>" . number_format($row['retch'], 2, ".", ",") . "</td>";

        $ResponseXML .= "<td>" . number_format($row['retchStld'], 2, ".", ",") . "</td>";

        
$ResponseXML .= "<td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row['id'] . "')\"> <span class='fa fa-remove'></span></a></td>";

        
    

        
        
        $ResponseXML .= "</tr>";
    } 

    $ResponseXML .= "</table>";

    echo $ResponseXML;
	
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
