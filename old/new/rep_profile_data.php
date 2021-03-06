<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connection_sql.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "get_rep") {

	
	$strinv = "select sum(grand_tot/(1 +gst/100)) as gtot,month(sdate) as month ,year(sdate) as year from s_salma where ACCNAME <> 'NON STOCK'   and CANCELL='0' ";      
	$strinv .=" and sal_ex= '" . $_GET['rep'] . "'";				
     $i=1;
	$year = date('Y');	
	$year1 = date('Y') -1;	
	$strinv.= " and (";
	while ($i <= 12) {
		$month = $i;
		
		
		$strinv.= "  ( month(sdate) = '" . $month . "'  and year(sdate) = '" . $year . "')   ";		 
		$strinv .= " or";		 
		$strinv.= "  ( month(sdate) = '" . $month . "'  and year(sdate) = '" . $year1 . "')   ";
		if ($i <=11 ) {
			$strinv .= " or";
		}
		
		
		$i =$i+1;
		
		
		
		
		
	}
	
	$strinv.= ")";
	$strinv.= " group by month(sdate),year(sdate)";
	 
 
	
	    $i=1;
	$strgrn = "select sum(amount/(1 +vatrate/100)) as gtot,month(sdate) as month ,year(sdate) as year from c_bal where   trn_type<>'INC'and trn_type<>'REC' and trn_type<>'PAY' and trn_type<>'ARN'  and flag1 <> '1'";
    $strgrn .=" and SAL_EX ='" . $_GET['rep'] . "'";
    $strgrn.= " and (";
	while ($i <= 12) {
		$month = $i;
		
		
		$strgrn.= "  ( month(sdate) = '" . $month . "'  and year(sdate) = '" . $year . "')   ";		 
		$strgrn .= " or";		 
		$strgrn.= "  ( month(sdate) = '" . $month . "'  and year(sdate) = '" . $year1 . "')   ";
		if ($i <=11 ) {
			$strgrn .= " or";
		}
		
		
		$i =$i+1;
		
		
		
		
		
	}
	$strgrn.= ")";
	$strgrn.= " group by month(sdate),year(sdate)";
	 
 		
			
	foreach ($conn->query($strinv) as $row) {

	
	$userdata[] = "('" . $_GET['rep'] . "','" .  $row['gtot'] . "','" .  $row['month']  . "','" .  $row['year']  . "')";
	
	}
	
	
	 
    foreach ($conn->query($strgrn) as $row) {

	
	$userdata1[] = "('" . $_GET['rep'] . "','" . ($row['gtot']*-1) . "','" .  $row['month']  . "','" .  $row['year']  . "')";
	
	}   
	
	$sql = "delete from tmp_salprofile ";
		$result = $conn->query($sql);
  
	
	$sql = "insert into  tmp_salprofile  (sal_ex,sal_amo,mon,year) values " . implode(',', $userdata);
	 
	$result = $conn->query($sql);
  
	$sql = "insert into  tmp_salprofile  (sal_ex,sal_amo,mon,year) values " . implode(',', $userdata1);
	 
	$result = $conn->query($sql); 
   
	 
			
 
 
 
	$tb ="<table style=\"visibility: hidden;\" id=\"datatable\">
				<thead>";
	$tb .= "<tr>
			<th></th>	
			<th>" . $year . "</th>
			<th>" . $year1 . "</th>	
			
			</tr>
			</thead>
			<tbody>";
	
	$i=1;
	
	while ($i <= 12) {
		
	$dt = date(date('Y') . "-" . $i . "-1"); 	
		$dt = date("F", strtotime($dt));
	$tb .= "<tr>
			<th>" . $dt . "</th>";
			
			$sql = "select sum(sal_amo) as sal_amo from tmp_salprofile where sal_ex ='" . $_GET['rep']   . "' and mon = '" . $i . "' and year = '" . $year . "'";
			$result = $conn->query($sql);
			if ($row = $result->fetch()) {
				$tb .= "<td>" .  number_format($row['sal_amo'], 0, ".", "")  . "</td>";
			}  
			
			$sql = "select sum(sal_amo) as sal_amo from tmp_salprofile where sal_ex ='" . $_GET['rep']   . "' and mon = '" . $i . "' and year = '" . $year1 . "'";
			$result = $conn->query($sql);
			if ($row = $result->fetch()) {
				$tb .= "<td>" .  number_format($row['sal_amo'], 0, ".", "")  . "</td>";
			} 	
			
			$tb .= "</tr>";	


			$i = $i+1;
	}	
	
	
			
	 
	$tb .= "</tbody></table>";
	
	$ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
	
	$sql = "select * from s_salrep where repcode = '" . $_GET['rep']  . "'" ;
	$result = $conn->query($sql);
	if ($row = $result->fetch()) {
		$ResponseXML .= "<stat><![CDATA[1]]></stat>";		
		$ResponseXML .= "<Name><![CDATA["  .  $row['Name']  .  "]]></Name>";					 				
		$ResponseXML .= "<Join_Date><![CDATA[]]></Join_Date>";					
		$ResponseXML .= "<remark><![CDATA[]]></remark>";	
		$ResponseXML .= "<pic><![CDATA[]]></pic>";	
	} else {
		$ResponseXML .= "<stat><![CDATA[0]]></stat>";		
	}	 
	   
    $ResponseXML .= "<tb><![CDATA[" . $tb . "]]></tb>";
    $ResponseXML .= "</salesdetails>";  
    echo $ResponseXML;
	
}


?>