<?php

session_start();
date_default_timezone_set('Asia/Colombo');
require_once('./connection_sql.php');

if ($_GET["Command"] == "save") {

	$sql = "select * from dlr_shr where tmpno = '" . $_GET['tmpno'] . "'";
	$results = $conn->query($sql);
	if ($row = $results->fetch()) {	
		exit("Already Saved");	
	}

    $sql = "select * from tmp_sal_com where tmp_no = '" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $sql = "insert into dlr_shr (sdate,c_code,c_name,remark,refno,amt,inv_amo,out_amo,tmpno) values 
	('" . $_GET["invdate"] . "','" . $row["c_code"] . "', '" . $row["c_name"] . "','" . $_GET["rmk"] . "','" . $row["ref_no"] . "', '" . $row["amo"] . "', '" . $row["inv_amo"] . "', '" . $row["out_amo"] . "','" . $_GET['tmpno'] . "')";

        $results = $conn->query($sql);
    }

    if (!$results) {
        echo "Not saved! $sql";
    } else {
        echo "Successfully Saved!";
    }
}


if ($_GET['Command'] == "add_tmp") {


    $sql = "delete from tmp_sal_com where ref_no = '" . $_GET['ref_no'] . "'";


    $sql = "insert into tmp_sal_com (ref_no,tmp_no,c_code,c_name,inv_amo,out_amo,amo) values ('" . $_GET['ref_no'] . "','" . $_GET['tmpno'] . "',
							'" . $_GET['c_code'] . "','" . $_GET['c_name'] . "','" . $_GET['inv_amo'] . "','" . $_GET['out_amo'] . "','" . $_GET['amo'] . "') ";
    $results = $conn->query($sql);


    $tb = "<table  class=\"table\">";
    $tb .= "<tr><th style=\"width : 120px;\">Invoioce No</th>
					<th style=\"width : 50px;\"></th>
					<th style=\"width : 320px;\">Dealer Name</th>		
					<th style=\"width : 120px;\">Invoice Amount</th>
					<th style=\"width : 120px;\">Outstanding Amount</th>				
					<th style=\"width : 120px;\">Incentive Amount</th>	
					<th style=\"width : 50px;\"></th></tr>";

    $sql = "select * from tmp_sal_com where tmp_no = '" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $tb .= "<tr><td>" . $row['ref_no'] . "</td>
					<td></td>
					<td>" . $row['c_name'] . "</td>		
					<td>" . $row['inv_amo'] . "</td>
					<td>" . $row['out_amo'] . "</td>				
					<td>" . $row['amo'] . "</td>	
					<td><a class=\"btn btn-danger btn-xs\" onclick=\"del_item('" . $row['id'] . "');\"> <span class='fa fa-remove'></span></a></td></tr>";
    }
    $tb .= "</table>";
    echo $tb;
}

if ($_GET['Command'] == "del_item") {


    $sql = "delete from tmp_sal_com where id = '" . $_GET['code'] . "'";
    $results = $conn->query($sql);


    $tb = "<table  class=\"table\">";
    $tb .= "<tr><th style=\"width : 120px;\">Invoioce No</th>
					<th style=\"width : 50px;\"></th>
					<th style=\"width : 320px;\">Dealer Name</th>		
					<th style=\"width : 120px;\">Invoice Amount</th>
					<th style=\"width : 120px;\">Outstanding Amount</th>				
					<th style=\"width : 120px;\">Incentive Amount</th>	
					<th style=\"width : 50px;\"></th></tr>";

    $sql = "select * from tmp_sal_com where tmp_no = '" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $tb .= "<tr><td>" . $row['ref_no'] . "</td>
					<td></td>
					<td>" . $row['c_name'] . "</td>		
					<td>" . $row['inv_amo'] . "</td>
					<td>" . $row['out_amo'] . "</td>				
					<td>" . $row['amo'] . "</td>	
					<td><a class=\"btn btn-danger btn-xs\" onclick=\"del_item('" . $row['id'] . "');\"> <span class='fa fa-remove'></span></a></td></tr>";
    }
    $tb .= "</table>";
    echo $tb;
}


if ($_GET["Command"] == "new_inv") {



    $sql = "Select sal_com from tmpinvpara";
    $result = $conn->query($sql);
    $row = $result->fetch();

    $tono = $row['sal_com'];

    $sql = "update tmpinvpara set sal_com=sal_com+1";
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


if ($_GET["Command"] == "pass_rec") {


	$sql = "delete from tmp_sal_com where tmp_no = '" .  $_GET['refno'] . "'";
	$results = $conn->query($sql);
	
    $sql = "select * from dlr_shr where tmpno = '" . $_GET['refno'] . "'";
   
   foreach ($conn->query($sql) as $row) {

        $sql = "insert into tmp_sal_com (c_code,c_name,ref_no,amo,inv_amo,out_amo,tmp_no) values 
	('" . $row["c_code"] . "', '" . $row["c_name"] . "','" . $row["refno"] . "', '" . $row["amt"] . "', '" . $row["inv_amo"] . "', '" . $row["out_amo"] . "','" . $_GET['refno'] . "')";
		$dt = $row['sdate'];
		$remk = $row['remark'];
		
        $results = $conn->query($sql);
    }


    $tb = "<table  class=\"table\">";
    $tb .= "<tr><th style=\"width : 120px;\">Invoioce No</th>
					<th style=\"width : 50px;\"></th>
					<th style=\"width : 320px;\">Dealer Name</th>		
					<th style=\"width : 120px;\">Invoice Amount</th>
					<th style=\"width : 120px;\">Outstanding Amount</th>				
					<th style=\"width : 120px;\">Incentive Amount</th>	
					<th style=\"width : 50px;\"></th></tr>";

    $sql = "select * from tmp_sal_com where tmp_no = '" . $_GET['refno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $tb .= "<tr><td>" . $row['ref_no'] . "</td>
					<td></td>
					<td>" . $row['c_name'] . "</td>		
					<td>" . $row['inv_amo'] . "</td>
					<td>" . $row['out_amo'] . "</td>				
					<td>" . $row['amo'] . "</td>	
					<td><a class=\"btn btn-danger btn-xs\" onclick=\"del_item('" . $row['id'] . "');\"> <span class='fa fa-remove'></span></a></td></tr>";
    
	}
    $tb .= "</table>";
     
	
	 header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<tb><![CDATA[" . $tb . "]]></tb>";
    $ResponseXML .= "<dt><![CDATA[" . $dt . "]]></dt>";
	$ResponseXML .= "<tmpno><![CDATA[" .  $_GET['refno'] . "]]></tmpno>";
	$ResponseXML .= "<remrk><![CDATA[" . $remk . "]]></remrk>";	
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
	
	
}


if ($_GET["Command"] == "delete") {
	

	 $sql = "delete from dlr_shr where tmpno = '" . $_GET['tmpno'] . "'";
	 $results = $conn->query($sql);
	echo "Deleted";
	
}	






?>
