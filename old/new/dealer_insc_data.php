<?php
session_start();
require_once ("connection_sql.php");

date_default_timezone_set('Asia/Colombo');
header('Content-Type: text/xml');


if ($_GET['Command']=="search_cos")
{



$sql = "select * from ins_payment where type <> ''";



if ($_GET['ccode']!= "") {
	$sql .= " and cusCode ='" . $_GET['ccode']  . "'";
}
if ($_GET['month']!= "") {
	$sql .= " and I_month ='" . $_GET['month']  . "'";
}
if ($_GET['year']!= "") {
	$sql .= " and I_year ='" . $_GET['year']  . "'";
}
if ($_GET['remar']!= "") {
	$sql .= " and remarks like '%" . $_GET['remar']  . "%'";
}
if ($_GET['cheqno']!= "") {
	$sql .= " and chno like '" . $_GET['cheqno']  . "%'";
}
if ($_GET['typem']!= "") {
	$sql .= " and type like '" . $_GET['typem']  . "%'";
}
$sql .= " order by id desc limit 20";

$tb = "<table class='table table-borderd' style=\"table-layout: fixed;word-wrap: break-word;\">

<tr>
                                <th style=\"width: 10%\">Dealer</th>
                                <th style=\"width: 10%\">Month</th>
                                <th style=\"width: 10%\">Year</th>
								<th style=\"width: 10%\">Type</th>
								<th style=\"width: 20%\">Remarks</th>
								<th style=\"width: 20%\">Cheq. No</th>
                            </tr>";

foreach ($conn->query($sql) as $row) {
	
	$tb .= "<tr>";
	$tb .= "<td><a href=\"#\" onclick=\"get_cos('" . $row['id'] . "');\">" . $row['cusCode'] . "</a></td>";
	$tb .= "<td><a href=\"#\" onclick=\"get_cos('" . $row['id'] . "');\">" . $row['I_month'] . "</a></td>";
	$tb .= "<td><a href=\"#\" onclick=\"get_cos('" . $row['id'] . "');\">" . $row['I_year'] . "</a></td>";
	$tb .= "<td><a href=\"#\" onclick=\"get_cos('" . $row['id'] . "');\">" . $row['Type'] . "</a></td>";
	$tb .= "<td><a href=\"#\" onclick=\"get_cos('" . $row['id'] . "');\">" . $row['remarks'] . "</a></td>";		
	$tb .= "<td><a href=\"#\" onclick=\"get_cos('" . $row['id'] . "');\">" . $row['chno'] . "</a></td>";	
	$tb .= "</tr>";


}

$tb .= "</table>";

echo $tb;

}

if ($_GET['Command']=="get_cos")
{
	$ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
	
	$sql = "select * from ins_payment where id ='" . $_GET['refno'] . "'";
	
	  $result = $conn->query($sql);
    if ($row = $result->fetch()) {
	
	
	 
	$ResponseXML .= "<cusCode><![CDATA[" . $row['cusCode'] . "]]></cusCode>"; 
	$ResponseXML .= "<Cusname><![CDATA[" . $row['Cusname'] . "]]></Cusname>"; 
	$ResponseXML .= "<I_month><![CDATA[" . $row['I_month'] . "]]></I_month>"; 
	$ResponseXML .= "<I_year><![CDATA[" . $row['refno'] . "]]></I_year>"; 
	$ResponseXML .= "<remarks><![CDATA[" . $row['remarks'] . "]]></remarks>"; 	
	$ResponseXML .= "<chno><![CDATA[" . $row['chno'] . "]]></chno>"; 	
	$ResponseXML .= "<id><![CDATA[" . $row['id'] . "]]></id>"; 	
		 	$ResponseXML .= "<sdate><![CDATA[" . $row['sdate'] . "]]></sdate>"; 	
		 
	 
	}
	
	
	
	
	$ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
	
	
}


if ($_GET['Command']=="unlock")
{
	if ($_SESSION["CURRENT_USER"]=="") {
		exit("Invalid User");
	}	
	
	$sql = "select * from ins_payment where id ='" . $_GET['id'] . "'";
	$result = $conn->query($sql);
    if ($row = $result->fetch()) {
			$mremrks= $row['remarks'];
	}	
	
	
	$sql = "update ins_payment set chno ='0',remarks='" . $mremrks . "-UNLOCK BY " . $_SESSION["CURRENT_USER"] . "' where id ='" . $_GET['id'] . "'";
	$result = $conn->query($sql);
	echo "Updated";
	
}	




if ($_GET['Command']=="update_remarks")
{
	if ($_SESSION["CURRENT_USER"]=="") {
		exit("Invalid User");
	}	
	
	$sql = "select * from ins_payment where id ='" . $_GET['id'] . "'";
	$result = $conn->query($sql);
    if ($row = $result->fetch()) {
			$mremrks= $row['remarks'];
	}	
	
	
	$sql = "update ins_payment set chno ='0',remarks='" . $mremrks . "&nbsp;&nbsp;" . $_GET['txt_newremarks'] . "' where id ='" . $_GET['id'] . "'";
	$result = $conn->query($sql);
	echo "Updated";
	
}	











?>