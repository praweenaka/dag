<?php

session_start();
date_default_timezone_set('Asia/Colombo');
require_once('./connection_sql.php');

if ($_GET["Command"] == "pass_quot") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];

    $sql = "Select * from s_salma where REF_NO='" . $cuscode . "' ";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . $cuscode . "]]></id>";
        $ResponseXML .= "<str_customername><![CDATA[" . $row['CUS_NAME'] . "]]></str_customername>";
        $ResponseXML .= "<sdate><![CDATA[" . $row['SDATE'] . "]]></sdate>";

        $sql = "select * from invoice_det where inv_no = '" . $cuscode . "' ";
        $sql = $conn->query($sql);
        if ($row = $sql->fetch()) {
            $ResponseXML .= "<remark><![CDATA[" . $row['remark'] . "]]></remark>";
            $ResponseXML .= "<status><![CDATA[" . $row['status'] . "]]></status>";
        } else {
            $ResponseXML .= "<remark><![CDATA[]]></remark>";
            $ResponseXML .= "<status><![CDATA[0]]></status>";
        }
    }
	
	$tb = "";
	$sql_rscrn= " Select * from s_crnfrmtrn where Inv_no = '" .$cuscode. "' and Flag = 'CCRN' and Incen_val <> 0";
	$result_rscrn = $conn->query($sql_rscrn);
    if ($row_rscrn = $result_rscrn->fetch()) {
			$incen_per = $row_rscrn["Incen_per"];
			$incen_val = $row_rscrn["Incen_val"];
			
 
			$tb .= "<table class=\"table\"><tr class=\"success\"><td colspan='12' >Cash Discount</td></tr><tr>
                              <th width=\"100\" >Deli.Date</font></th>
							  <th width=\"100\" >Inv.Date</font></th>
                              <th width=\"300\" >Invoice No</font></th>
                              <th width=\"100\" >Inv.Amount</font></th>
							  
							  <th width=\"100\"  >Discount</font></th>
							  <th width=\"100\"  >Dis 2</font></th>
							  
							  
							  
                              <th width=\"100\"  >Settle Amou</font></th>
							  <th width=\"100\"  >Settle Date</font></th>
							  <th width=\"100\"  >Balance</font></th>
							  <th width=\"100\"  >Days</font></th>
							  <th width=\"100\"  >Cash Dis%</font></th>
							  <th width=\"100\"  >Dis Amount</font></th>
       						</tr>";		
			
			$sql_rsstr = "Select * from view_s_sttr_copy where ST_INVONO = '" . trim($cuscode) . "' order by st_paid desc ";
			foreach ($conn->query($sql_rsstr) as $row_rsstr) {
			
			if ((is_null($row_rsstr["deli_date"])==false) and ($row_rsstr["deli_date"]!="0000-00-00")) {
	               $Inv_date = $row_rsstr["deli_date"];	              
			} else {
	               $Inv_date = $row_rsstr["SDATE"];
	        }
			$balance_val=$row_rsstr["GRAND_TOT"]-$row_rsstr["ST_PAID"];
			
			//$settledate = $row_rsstr["ST_DATE"];
			
				$settledate = $row_rsstr["st_chdate"];
					if ($row_rsstr['ST_FLAG']=="UT") {
					$settledate = $row_rsstr["ST_DATE"];	
					} else {
					$settledate = $row_rsstr["st_chdate"];		
					}				
							$date1 = $Inv_date;
							$date2 = $settledate;
							$diff = (strtotime($date2) - strtotime($date1));
							$days = floor($diff / (60*60*24));
			
			$sql_RSINVO= "Select * from s_invo  where REF_NO =  '" .trim($cuscode). "'";
			$result_RSINVO = $conn->query($sql_RSINVO);
			$row_sinvo = $result_RSINVO->fetch();
			$tb .= "<tr>
                              <td width=\"100\" >".$Inv_date."</td>
							  <td width=\"100\" >".$row_rsstr["SDATE"]."</td>
                              <td width=\"300\" >".$row_rsstr["ST_INVONO"]."</td>
                              <td width=\"100\" >".$row_rsstr["GRAND_TOT"]."</td>
							  
							  <td width=\"100\" >".$row_sinvo["DIS_per"]."</td>
							  <td width=\"100\" ></td>
							  
                              <td width=\"100\" >".$row_rsstr["ST_PAID"]."</td>
							  <td width=\"100\" >".$settledate."</td>
							  <td width=\"100\" >".$balance_val."</td>
							  <td width=\"100\" >".$days."</td>
							  <td width=\"100\" >".$incen_per."</td>
							  <td width=\"100\" >".$incen_val."</td>
       						</tr>";						
			$incen_val =0;
			$incen_per =0;
		}
		
		
		$tb .= "</table>";
	}
	
	
	$sql = "select * from dlr_shr  where refno='" . $cuscode . "'";
	$result_rscrn = $conn->query($sql);
    if ($row_rscrn = $result_rscrn->fetch()) {
		
		$tb .= "<table class=\"table\"><tr class=\"success\"><td colspan='3'>Customer Incentive</td></tr><tr>";
		$tb .= "<tr>
					<th>Date</th>
					<th>Paid</th>
                    <th>Remark</th>
				</tr>
				<tr>		
					<td width=\"100\" >".$row_rscrn['sdate']."</td>
					<td width=\"100\" >".$row_rscrn["amt"]."</td>
                    <td width=\"300\" >".$row_rscrn["remark"]."</td>";
		$tb .= "</tr>";

		
	
		
	}
	
	
	
	
	

	$ResponseXML .= "<tb><![CDATA[" . $tb . "]]></tb>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_quot_smp") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];

    $sql = "Select * from s_salma where REF_NO='" . $cuscode . "' ";

    $ResponseXML .= "<stname><![CDATA[" . $_GET['stname'] . "]]></stname>";
	
    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . $cuscode . "]]></id>";
        $ResponseXML .= "<str_customercode><![CDATA[" . $row['C_CODE'] . "]]></str_customercode>";
        $ResponseXML .= "<str_customername><![CDATA[" . $row['CUS_NAME'] . "]]></str_customername>";
		
    }
	
	if ($_GET['stname'] == "dlr_shr") {
		
		$ResponseXML .= "<inv_amount><![CDATA[" . $row['GRAND_TOT'] . "]]></inv_amount>";	
		$ResponseXML .= "<out_amount><![CDATA[" . ($row['GRAND_TOT']-$row['TOTPAY']) . "]]></out_amount>";	
		
		
		$sql = "select * from dlr_shr  where refno ='" .  $cuscode . "'";
		
	   
		$sql = $conn->query($sql);
		if ($row = $sql->fetch()) {
		 $ResponseXML .= "<amo><![CDATA[" . $row['amt'] . "]]></amo>";		
		 $ResponseXML .= "<stat><![CDATA[1]]></stat>";		
		} else {
		 $ResponseXML .= "<amo><![CDATA[]]></amo>";	
		 $ResponseXML .= "<stat><![CDATA[0]]></stat>";		
		}
	}	
	
	
	
	
	
	
	


    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "save") {
    $sql = "delete from invoice_det where inv_no = '" . $_GET["c_code"] . "'";
    $conn->exec($sql);

    $sql = "insert into invoice_det (inv_no,cus_name,remark,status) values ('" . $_GET["c_code"] . "', '" . $_GET["c_name"] . "','" . $_GET["rmk"] . "','" . $_GET["status"] . "')";
    $conn->exec($sql);
    
    echo "saved!";
}

if ($_GET["Command"] == "search_custom") {
    $ResponseXML = "";
    $ResponseXML .= "<table   class=\"table table-bordered\">
                            <tr>
                    <th width=\"121\"  >Invoice No</th>
                    <th width=\"424\"  >Dealer Name</th>
                    <th width=\"300\"  >Date</th>

                </tr>";

    if ($_GET["mstatus"] == "cusno") {
        $letters = $_GET['cusno'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select REF_NO,CUS_NAME,SDATE from s_salma where  REF_NO like '%$letters%' ";
    } else if ($_GET["mstatus"] == "customername") {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select REF_NO,CUS_NAME,SDATE from s_salma where  CUS_NAME like '%$letters%' ";
    } else {

        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select REF_NO,CUS_NAME,SDATE from s_salma where  CUS_NAME like '%$letters%' ";
    }
    $sql .= " order by SDATE DESC limit 50";


    foreach ($conn->query($sql) as $row) {
        $cuscode = $row['REF_NO'];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CUS_NAME'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                            </tr>";
    }


    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}

?>
