<?php

session_start();

include_once ("connectioni.php");

if ($_GET["Command"] == "search_item") {

	//	if(isset($_GET['itemname'])){
	//		$letters = $_GET['itemname'];
	//$letters = $_GET['letters'];
	//		$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	//	$res = mysqli_query($GLOBALS['dbinv'],"SELECT * FROM mast_family where name like '".$letters."%'") or die(mysqli_error());

	//$res = mysqli_query($GLOBALS['dbinv'],"SELECT distinct trn_involved.str_name FROM trn_involved where str_name like '".$letters."%'") or die(mysqli_error());

	//SELECT * FROM occupation_details where str_first_name like 'k%'
	//echo $res;

	$ResponseXML .= "";
	//$ResponseXML .= "<invdetails>";

	$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Reference No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Claim No</font></td>
						<td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Agent Code</font></td>
						<td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Agent Name</font></td>
                             
   							</tr>";

	if ($_GET["mstatus"] == "refno") {
		$letters = $_GET['refno'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);

		$sql = mysqli_query($GLOBALS['dbinv'], "select refno, cl_no, ag_code, ag_name  from c_clamas where type !='BAT' and refno like  '$letters%' order by entdate desc limit 50") or die(mysqli_error());

		//$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_mas where STK_NO like  '$letters%' and BRAND_NAME='".$_SESSION["brand"]."' order by STK_NO") or die(mysqli_error());

	} else if ($_GET["mstatus"] == "claim_no") {
		$letters = $_GET['claim_no'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);

		$sql = mysqli_query($GLOBALS['dbinv'], "select refno, cl_no, ag_code, ag_name  from c_clamas where type !='BAT' and cl_no like  '$letters%' order by entdate desc limit 50") or die(mysqli_error());

	} else if ($_GET["mstatus"] == "agent_no") {

		$letters = $_GET['agent_no'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);

		$sql = mysqli_query($GLOBALS['dbinv'], "select refno, cl_no, ag_code, ag_name  from c_clamas where type !='BAT' and agent_no like  '$letters%' order by entdate desc limit 50") or die(mysqli_error());

	} else if ($_GET["mstatus"] == "agent_name") {

		$letters = $_GET['agent_name'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);

		$sql = mysqli_query($GLOBALS['dbinv'], "select refno, cl_no, ag_code, ag_name  from c_clamas where type !='BAT' and agent_name like  '$letters%' order by entdate desc limit 50") or die(mysqli_error());

	} else {
		//$letters = $_GET['agent_name'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);

		$sql = mysqli_query($GLOBALS['dbinv'], "select refno, cl_no, ag_code, ag_name  from c_clamas where  type !='BAT'  order by entdate desc limit 50") or die(mysqli_error());

	}

	//echo $sql;
	while ($row = mysqli_fetch_array($sql)) {

		$ResponseXML .= "<tr>               
                              		<td onclick=\"itno_claim('" . $row['cl_no'] . "', '" . $_GET["stname"] . "');\">" . $row['refno'] . "</a></td>
                              		<td onclick=\"itno_claim('" . $row['cl_no'] . "', '" . $_GET["stname"] . "');\">" . $row['cl_no'] . "</a></td>
							  		<td onclick=\"itno_claim('" . $row['cl_no'] . "', '" . $_GET["stname"] . "');\">" . $row['ag_code'] . "</a></td>
									<td onclick=\"itno_claim('" . $row['cl_no'] . "', '" . $_GET["stname"] . "');\">" . $row['ag_name'] . "</a></td>";

		$ResponseXML .= "</tr>";

		//	$ResponseXML .= "<tr>
		//       <td onclick=\"itno('".$row['STK_NO']."');\">".$row['STK_NO']."</a></td>
		//       <td onclick=\"itno('".$row['STK_NO']."');\">".$row['DESCRIPT']."</a></td>";

		/*	  $department=$_SESSION["department"];

		 $sql1 = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['STK_NO']."' AND STO_CODE='".$department."'") or die(mysqli_error()) or die(mysqli_error());
		 if($row1 = mysqli_fetch_array($sql1)){
		 $ResponseXML .= "<td bgcolor=\"#222222\" onclick=\"itno('".$row['STK_NO']."');\">".$row1['QTYINHAND']."</a></td>";
		 }	else {
		 $ResponseXML .= "<td bgcolor=\"#222222\" onclick=\"itno('".$row['STK_NO']."');\">0</a></td>";
		 }*/

		$ResponseXML .= "</tr>";
	}

	$ResponseXML .= "   </table>";

	echo $ResponseXML;
	//}
}

if ($_GET["Command"] == "search_item_b") {

 

	$ResponseXML .= "";

	$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Reference No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Claim No</font></td>
						<td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Agent Code</font></td>
						<td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Agent Name</font></td>
                             
   							</tr>";

	if ($_GET["mstatus"] == "refno") {
		$letters = $_GET['refno'];
		 

		$sql = mysqli_query($GLOBALS['dbinv'], "select refno, cl_no, ag_code, ag_name  from c_clamas where type ='BAT' and refno like  '$letters%' order by entdate desc limit 50") or die(mysqli_error());

		

	} else if ($_GET["mstatus"] == "claim_no") {
		$letters = $_GET['claim_no'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);

		$sql = mysqli_query($GLOBALS['dbinv'], "select refno, cl_no, ag_code, ag_name  from c_clamas where type ='BAT' and cl_no like  '$letters%' order by entdate desc limit 50") or die(mysqli_error());

	} else if ($_GET["mstatus"] == "agent_no") {

		$letters = $_GET['agent_no'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);

		$sql = mysqli_query($GLOBALS['dbinv'], "select refno, cl_no, ag_code, ag_name  from c_clamas where type ='BAT' and agent_no like  '$letters%' order by entdate desc limit 50") or die(mysqli_error());

	} else if ($_GET["mstatus"] == "agent_name") {

		$letters = $_GET['agent_name'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);

		$sql = mysqli_query($GLOBALS['dbinv'], "select refno, cl_no, ag_code, ag_name  from c_clamas where type ='BAT' and agent_name like  '$letters%' order by entdate desc limit 50") or die(mysqli_error());

	} else {
		//$letters = $_GET['agent_name'];
		//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);

		$sql = mysqli_query($GLOBALS['dbinv'], "select refno, cl_no, ag_code, ag_name  from c_clamas where type ='BAT'  order by entdate desc limit 50") or die(mysqli_error());

	}

	//echo $sql;
	while ($row = mysqli_fetch_array($sql)) {

		$ResponseXML .= "<tr>               
                              		<td onclick=\"itno_claim_b('" . $row['refno'] . "', '" . $_GET["stname"] . "');\">" . $row['refno'] . "</a></td>
                              		<td onclick=\"itno_claim_b('" . $row['refno'] . "', '" . $_GET["stname"] . "');\">" . $row['cl_no'] . "</a></td>
							  		<td onclick=\"itno_claim_b('" . $row['refno'] . "', '" . $_GET["stname"] . "');\">" . $row['ag_code'] . "</a></td>
									<td onclick=\"itno_claim_b('" . $row['refno'] . "', '" . $_GET["stname"] . "');\">" . $row['ag_name'] . "</a></td>";

		$ResponseXML .= "</tr>";

		//	$ResponseXML .= "<tr>
		//       <td onclick=\"itno('".$row['STK_NO']."');\">".$row['STK_NO']."</a></td>
		//       <td onclick=\"itno('".$row['STK_NO']."');\">".$row['DESCRIPT']."</a></td>";

		/*	  $department=$_SESSION["department"];

		 $sql1 = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['STK_NO']."' AND STO_CODE='".$department."'") or die(mysqli_error()) or die(mysqli_error());
		 if($row1 = mysqli_fetch_array($sql1)){
		 $ResponseXML .= "<td bgcolor=\"#222222\" onclick=\"itno('".$row['STK_NO']."');\">".$row1['QTYINHAND']."</a></td>";
		 }	else {
		 $ResponseXML .= "<td bgcolor=\"#222222\" onclick=\"itno('".$row['STK_NO']."');\">0</a></td>";
		 }*/

		$ResponseXML .= "</tr>";
	}

	$ResponseXML .= "   </table>";

	echo $ResponseXML;
	//}
}

if ($_GET["Command"] == "pass_invno") {
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	$sql = mysqli_query($GLOBALS['dbinv'], "Select * from c_clamas where cl_no='" . $_GET['refno'] . "'") or die(mysqli_error());

	if ($row = mysqli_fetch_array($sql)) {

		$ResponseXML .= "<txtrefno><![CDATA[" . $row['refno'] . "]]></txtrefno>";
                
                
                $ResponseXML .= "<cus_id><![CDATA[" . intval(substr($row['refno'],4,9)) . "]]></cus_id>";
                
		$ResponseXML .= "<txtentdate><![CDATA[" . $row['entdate'] . "]]></txtentdate>";
		$ResponseXML .= "<DTPicker_recdate><![CDATA[" . $row['recieve_date'] . "]]></DTPicker_recdate>";

		$ResponseXML .= "<txtcl_no><![CDATA[" . $row['cl_no'] . "]]></txtcl_no>";
		$ResponseXML .= "<txtag_code><![CDATA[" . $row['ag_code'] . "]]></txtag_code>";
		$ResponseXML .= "<txtag_name><![CDATA[" . $row['ag_name'] . "]]></txtag_name>";
		$ResponseXML .= "<txtagadd><![CDATA[" . $row['agadd'] . "]]></txtagadd>";
		$ResponseXML .= "<TXTCUS_NAME><![CDATA[" . $row['cus_name'] . "]]></TXTCUS_NAME>";
		$ResponseXML .= "<txtcus_add><![CDATA[" . $row['cus_add'] . "]]></txtcus_add>";
		$ResponseXML .= "<txtstk_no><![CDATA[" . $row['stk_no'] . "]]></txtstk_no>";
		$ResponseXML .= "<txtdes><![CDATA[" . $row['des'] . "]]></txtdes>";
		$ResponseXML .= "<txtbrand><![CDATA[" . $row['brand'] . "]]></txtbrand>";
		$ResponseXML .= "<txtsiz><![CDATA[" . $row['siz'] . "]]></txtsiz>";
		$ResponseXML .= "<txtpr><![CDATA[" . $row['pr'] . "]]></txtpr>";
		$ResponseXML .= "<txtpatt><![CDATA[" . $row['patt'] . "]]></txtpatt>";
		$ResponseXML .= "<txtseri_no><![CDATA[" . $row['seri_no'] . "]]></txtseri_no>";
		$ResponseXML .= "<txttc_ob><![CDATA[" . $row['tc_ob'] . "]]></txttc_ob>";
		$ResponseXML .= "<txtmn_ob><![CDATA[" . $row['Mn_ob'] . "]]></txtmn_ob>";
		$ResponseXML .= "<txtremin><![CDATA[" . $row['remin'] . "]]></txtremin>";

		$ResponseXML .= "<add_ref1><![CDATA[" . $row['add_ref1'] . "]]></add_ref1>";
		$ResponseXML .= "<add_ref2><![CDATA[" . $row['add_ref2'] . "]]></add_ref2>";

		$ResponseXML .= "<txtspec><![CDATA[" . $row['spec'] . "]]></txtspec>";
		$ResponseXML .= "<txtremming><![CDATA[" . $row['remming'] . "]]></txtremming>";
		$ResponseXML .= "<txtref_per><![CDATA[" . $row['ref_per'] . "]]></txtref_per>";
		$ResponseXML .= "<txtCRD_no><![CDATA[" . $row['CRD_no'] . "]]></txtCRD_no>";
		//$ResponseXML .= "<txtCRE_date><![CDATA[".$row['CRE_date']."]]></txtCRE_date>";

		$ResponseXML .= "<txtorigin1><![CDATA[" . $row['origin1'] . "]]></txtorigin1>";
		$ResponseXML .= "<txtorigin2><![CDATA[" . $row['origin2'] . "]]></txtorigin2>";
		$ResponseXML .= "<txtorigin3><![CDATA[" . $row['origin3'] . "]]></txtorigin3>";
		$ResponseXML .= "<txtorigin4><![CDATA[" . $row['origin4'] . "]]></txtorigin4>";
		$ResponseXML .= "<txtorigin5><![CDATA[" . $row['origin5'] . "]]></txtorigin5>";
		$ResponseXML .= "<txtremin1><![CDATA[" . $row['remin1'] . "]]></txtremin1>";
		$ResponseXML .= "<txtremin2><![CDATA[" . $row['remin2'] . "]]></txtremin2>";
		$ResponseXML .= "<txtremin3><![CDATA[" . $row['remin3'] . "]]></txtremin3>";
		$ResponseXML .= "<txtremin4><![CDATA[" . $row['remin4'] . "]]></txtremin4>";
		$ResponseXML .= "<txtremin5><![CDATA[" . $row['remin5'] . "]]></txtremin5>";
		
		$ResponseXML .= "<c_subcode><![CDATA[" . $row['c_subcode'] . "]]></c_subcode>";

		$ResponseXML .= "<OCV><![CDATA[" . $row['OCV'] . "]]></OCV>";
		$ResponseXML .= "<OCV2><![CDATA[" . $row['OCV2'] . "]]></OCV2>";
		$ResponseXML .= "<OCV3><![CDATA[" . $row['OCV3'] . "]]></OCV3>";
		
						
		
		$ResponseXML .= "<txtrem_per><![CDATA[" . $row['rem_per'] . "]]></txtrem_per>";
		$ResponseXML .= "<Cmb_refund><![CDATA[" . $row['Refund'] . "]]></Cmb_refund>";
		$ResponseXML .= "<Commercialy><![CDATA[" . $row['Commercialy'] . "]]></Commercialy>";

		$ResponseXML .= "<DGRN_NO><![CDATA[" . $row['DGRN_NO'] . "]]></DGRN_NO>";
		$ResponseXML .= "<DGRN_NO2><![CDATA[" . $row['DGRN_NO2'] . "]]></DGRN_NO2>";
		$ResponseXML .= "<DGRN_NO3><![CDATA[" . $row['DGRN_NO3'] . "]]></DGRN_NO3>";

		if ((trim($row['add_ref1']) != "") and ($row['DGRN_NO2'] == "0")) {
			$commercial_enable = "1";
		} else if ((trim($row['add_ref2']) != "") and ($row['DGRN_NO3'] == "0")) {
			$commercial_enable = "1";
		} else {
			$commercial_enable = "0";
		}

		$ResponseXML .= "<commercial_enable><![CDATA[" . $commercial_enable . "]]></commercial_enable>";

		if ($row['gatepass'] == "0000-00-00") {
			$ResponseXML .= "<dtf><![CDATA[]]></dtf>";
		} else {
			$ResponseXML .= "<dtf><![CDATA[" . $row['gatepass'] . "]]></dtf>";
		}

		if ($row['returndate'] == "0000-00-00") {
			$ResponseXML .= "<dtto><![CDATA[]]></dtto>";
		} else {
			$ResponseXML .= "<dtto><![CDATA[" . $row['returndate'] . "]]></dtto>";
		}

		$ResponseXML .= "<approvedby><![CDATA[" . $row['approve_md_wd'] . "]]></approvedby>";

		$sql1 = mysqli_query($GLOBALS['dbinv'], "select * from c_bal where refno = '" . trim($row['DGRN_NO']) . "'") or die(mysqli_error());
		//echo "select * from c_bal where refno = '".trim($row['DGRN_NO'])."'";
		if ($row1 = mysqli_fetch_array($sql1)) {
			$ResponseXML .= "<txtCRE_date><![CDATA[" . $row1['SDATE'] . "]]></txtCRE_date>";
			$ResponseXML .= "<txtCRE_amount><![CDATA[" . $row1['AMOUNT'] . "]]></txtCRE_amount>";
		} else {
			$ResponseXML .= "<txtCRE_date><![CDATA[]]></txtCRE_date>";
			$ResponseXML .= "<txtCRE_amount><![CDATA[]]></txtCRE_amount>";
		}

		$sql1 = mysqli_query($GLOBALS['dbinv'], "select * from c_bal where refno = '" . trim($row['DGRN_NO2']) . "'") or die(mysqli_error());

		if ($row1 = mysqli_fetch_array($sql1)) {
			$ResponseXML .= "<txtCRE_date2><![CDATA[" . $row1['SDATE'] . "]]></txtCRE_date2>";
			$ResponseXML .= "<txtCRE_amount2><![CDATA[" . $row1['AMOUNT'] . "]]></txtCRE_amount2>";
		} else {
			$ResponseXML .= "<txtCRE_date2><![CDATA[]]></txtCRE_date2>";
			$ResponseXML .= "<txtCRE_amount2><![CDATA[]]></txtCRE_amount2>";
		}

		$sql1 = mysqli_query($GLOBALS['dbinv'], "select * from c_bal where refno = '" . trim($row['DGRN_NO3']) . "'") or die(mysqli_error());
		if ($row1 = mysqli_fetch_array($sql1)) {
			$ResponseXML .= "<txtCRE_date3><![CDATA[" . $row1['SDATE'] . "]]></txtCRE_date3>";
			$ResponseXML .= "<txtCRE_amount3><![CDATA[" . $row1['AMOUNT'] . "]]></txtCRE_amount3>";
		} else {
			$ResponseXML .= "<txtCRE_date3><![CDATA[]]></txtCRE_date3>";
			$ResponseXML .= "<txtCRE_amount3><![CDATA[]]></txtCRE_amount3>";
		}

	}

	$ResponseXML .= "</salesdetails>";
	echo $ResponseXML;

}

if ($_GET["Command"] == "pass_invno_b") {
	
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	$sql = mysqli_query($GLOBALS['dbinv'], "Select * from c_clamas where refno='" . $_GET['refno'] . "'") or die(mysqli_error());
	if ($row = mysqli_fetch_array($sql)) {

		$ResponseXML .= "<txtrefno><![CDATA[" . $row['refno'] . "]]></txtrefno>";
		$ResponseXML .= "<txtentdate><![CDATA[" . $row['entdate'] . "]]></txtentdate>";
		$ResponseXML .= "<DTPicker_recdate><![CDATA[" . $row['recieve_date'] . "]]></DTPicker_recdate>";
		$ResponseXML .= "<DTPicker_ddate><![CDATA[" . $row['Sold_date'] . "]]></DTPicker_ddate>";
		$ResponseXML .= "<DTPicker_cdate><![CDATA[" . $row['Sold_date_c'] . "]]></DTPicker_cdate>";
		$ResponseXML .= "<Chk_date><![CDATA[" . $row['Chk_date'] . "]]></Chk_date>";
		
		$ResponseXML .= "<cus_id><![CDATA[" . intval(substr($row['refno'],11,9)) . "]]></cus_id>";
		
		 $ResponseXML .= "<txtcl_no><![CDATA[".$row['cl_no']."]]></txtcl_no>";
		 $ResponseXML .= "<txtag_code><![CDATA[".$row['ag_code']."]]></txtag_code>";
		 $ResponseXML .= "<txtag_name><![CDATA[".$row['ag_name']."]]></txtag_name>";
		 $ResponseXML .= "<txtagadd><![CDATA[".$row['agadd']."]]></txtagadd>";
		 $ResponseXML .= "<TXTCUS_NAME><![CDATA[".$row['cus_name']."]]></TXTCUS_NAME>";
		 $ResponseXML .= "<txtcus_add><![CDATA[".$row['cus_add']."]]></txtcus_add>";
		 $ResponseXML .= "<txtstk_no><![CDATA[".$row['stk_no']."]]></txtstk_no>";
		 $ResponseXML .= "<txtdes><![CDATA[".$row['des']."]]></txtdes>";
		 $ResponseXML .= "<txtbrand><![CDATA[".$row['brand']."]]></txtbrand>";
		 $ResponseXML .= "<txtsiz><![CDATA[".$row['siz']."]]></txtsiz>";
		 $ResponseXML .= "<txtpr><![CDATA[".$row['pr']."]]></txtpr>";
		 $ResponseXML .= "<txtpatt><![CDATA[".$row['patt']."]]></txtpatt>";
		 $ResponseXML .= "<txtseri_no><![CDATA[".$row['seri_no']."]]></txtseri_no>";

		 $ResponseXML .= "<approvedby><![CDATA[".$row['approve_md_wd']."]]></approvedby>";

		  $ResponseXML .= "<c_subcode><![CDATA[" . $row['c_subcode'] . "]]></c_subcode>";
		 
		 $ResponseXML .= "<Cell1_el><![CDATA[".$row['Cell1_el']."]]></Cell1_el>";
		 $ResponseXML .= "<Cell2_el><![CDATA[".$row['Cell2_el']."]]></Cell2_el>";
		 $ResponseXML .= "<Cell3_el><![CDATA[".$row['Cell3_el']."]]></Cell3_el>";
		 $ResponseXML .= "<Cell4_el><![CDATA[".$row['Cell4_el']."]]></Cell4_el>";
		 $ResponseXML .= "<Cell5_el><![CDATA[".$row['Cell5_el']."]]></Cell5_el>";
		 $ResponseXML .= "<Cell6_el><![CDATA[".$row['Cell6_el']."]]></Cell6_el>";

		 $ResponseXML .= "<Cell1_Ispg><![CDATA[".$row['Cell1_Ispg']."]]></Cell1_Ispg>";
		 $ResponseXML .= "<Cell2_Ispg><![CDATA[".$row['Cell2_Ispg']."]]></Cell2_Ispg>";
		 $ResponseXML .= "<Cell3_Ispg><![CDATA[".$row['Cell3_Ispg']."]]></Cell3_Ispg>";
		 $ResponseXML .= "<Cell4_Ispg><![CDATA[".$row['Cell4_Ispg']."]]></Cell4_Ispg>";
		 $ResponseXML .= "<Cell5_Ispg><![CDATA[".$row['Cell5_Ispg']."]]></Cell5_Ispg>";
		 $ResponseXML .= "<Cell6_Ispg><![CDATA[".$row['Cell6_Ispg']."]]></Cell6_Ispg>";
		 
		 $ResponseXML .= "<Cell1_Aspg><![CDATA[".$row['Cell1_Aspg']."]]></Cell1_Aspg>";
		 $ResponseXML .= "<Cell2_Aspg><![CDATA[".$row['Cell2_Aspg']."]]></Cell2_Aspg>";
		 $ResponseXML .= "<Cell3_Aspg><![CDATA[".$row['Cell3_Aspg']."]]></Cell3_Aspg>";
		 $ResponseXML .= "<Cell4_Aspg><![CDATA[".$row['Cell4_Aspg']."]]></Cell4_Aspg>";
		 $ResponseXML .= "<Cell5_Aspg><![CDATA[".$row['Cell5_Aspg']."]]></Cell5_Aspg>";
		 $ResponseXML .= "<Cell6_Aspg><![CDATA[".$row['Cell6_Aspg']."]]></Cell6_Aspg>";

		 $ResponseXML .= "<t17><![CDATA[".$row['OCV']."]]></t17>";
		 $ResponseXML .= "<t27><![CDATA[".$row['OCV2']."]]></t27>";
		 $ResponseXML .= "<t37><![CDATA[".$row['OCV3']."]]></t37>";

		 		 $ResponseXML .= "<t18><![CDATA[".$row['CCA']."]]></t18>";
		 $ResponseXML .= "<t28><![CDATA[".$row['CCA2']."]]></t28>";
		 $ResponseXML .= "<t38><![CDATA[".$row['CCA3']."]]></t38>";


		 $ResponseXML .= "<txttc_ob><![CDATA[".$row['tc_ob']."]]></txttc_ob>";
		 $ResponseXML .= "<txtmn_ob><![CDATA[".$row['Mn_ob']."]]></txtmn_ob>";
		 $ResponseXML .= "<Cmb_refund><![CDATA[".$row['Refund']."]]></Cmb_refund>";
		 $ResponseXML .= "<ref_per><![CDATA[".$row['ref_per']."]]></ref_per>";
		 $ResponseXML .= "<rem_per><![CDATA[".$row['rem_per']."]]></rem_per>";
		 $ResponseXML .= "<spec><![CDATA[".$row['spec']."]]></spec>";
		 $ResponseXML .= "<txtref_per><![CDATA[".$row['ref_per']."]]></txtref_per>";
		 $ResponseXML .= "<add_ref1><![CDATA[".$row['add_ref1']."]]></add_ref1>";
		 $ResponseXML .= "<add_ref2><![CDATA[".$row['add_ref2']."]]></add_ref2>";
		 $ResponseXML .= "<Commercialy><![CDATA[".$row['Commercialy']."]]></Commercialy>";
		 $ResponseXML .= "<type><![CDATA[".$row['type']."]]></type>";

		 $ResponseXML .= "<DGRN_NO><![CDATA[".$row['DGRN_NO']."]]></DGRN_NO>";
		 $ResponseXML .= "<DGRN_NO2><![CDATA[".$row['DGRN_NO2']."]]></DGRN_NO2>";
		 $ResponseXML .= "<DGRN_NO3><![CDATA[".$row['DGRN_NO3']."]]></DGRN_NO3>";

		 $sql1 = mysqli_query($GLOBALS['dbinv'],"select * from c_bal where refno = '".trim($row['DGRN_NO'])."'") or die(mysqli_error());
		 if($row1 = mysqli_fetch_array($sql1)){
		 $ResponseXML .= "<txtCRE_date><![CDATA[".$row1['SDATE']."]]></txtCRE_date>";
		 $ResponseXML .= "<txtCRE_amount><![CDATA[".$row1['AMOUNT']."]]></txtCRE_amount>";
		 } else {
		 $ResponseXML .= "<txtCRE_date><![CDATA[]]></txtCRE_date>";
		 $ResponseXML .= "<txtCRE_amount><![CDATA[]]></txtCRE_amount>";
		 }

		 $sql1 = mysqli_query($GLOBALS['dbinv'],"select * from c_bal where refno = '".trim($row['DGRN_NO2'])."'") or die(mysqli_error());
		 if($row1 = mysqli_fetch_array($sql1)){
		 $ResponseXML .= "<txtCRE_date2><![CDATA[".$row1['SDATE']."]]></txtCRE_date2>";
		 $ResponseXML .= "<txtCRE_amount2><![CDATA[".$row1['AMOUNT']."]]></txtCRE_amount2>";
		 } else {
		 $ResponseXML .= "<txtCRE_date2><![CDATA[]]></txtCRE_date2>";
		 $ResponseXML .= "<txtCRE_amount2><![CDATA[]]></txtCRE_amount2>";
		 }

		 $sql1 = mysqli_query($GLOBALS['dbinv'],"select * from c_bal where refno = '".trim($row['DGRN_NO2'])."'") or die(mysqli_error());
		 if($row1 = mysqli_fetch_array($sql1)){
		 $ResponseXML .= "<txtCRE_date3><![CDATA[".$row1['SDATE']."]]></txtCRE_date3>";
		 $ResponseXML .= "<txtCRE_amount3><![CDATA[".$row1['AMOUNT']."]]></txtCRE_amount3>";
		 } else {
		 $ResponseXML .= "<txtCRE_date3><![CDATA[]]></txtCRE_date3>";
		 $ResponseXML .= "<txtCRE_amount3><![CDATA[]]></txtCRE_amount3>";
		 }

	}

	$ResponseXML .= "</salesdetails>";
	echo $ResponseXML;

}

if ($_GET["Command"] == "pass_itno_claim") {
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	//echo "Select * from s_mas where STK_NO='".$_GET['itno']."' and BRAND_NAME='".$_GET["brand"]."'";
	$sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $_GET['itno'] . "' ") or die(mysqli_error());

	if ($row = mysqli_fetch_array($sql)) {

		$ResponseXML .= "<str_code><![CDATA[" . $row['STK_NO'] . "]]></str_code>";
		$ResponseXML .= "<BRAND_NAME><![CDATA[" . $row['BRAND_NAME'] . "]]></BRAND_NAME>";
		$ResponseXML .= "<str_description><![CDATA[" . $row['DESCRIPT'] . "]]></str_description>";
		$ResponseXML .= "<PART_NO><![CDATA[" . $row['PART_NO'] . "]]></PART_NO>";
	}

	$ResponseXML .= "</salesdetails>";
	echo $ResponseXML;

}

if ($_GET["Command"] == "pass_itno") {
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";

	if ($_GET["brand"] != "") {
		//echo "Select * from s_mas where STK_NO='".$_GET['itno']."' and BRAND_NAME='".$_GET["brand"]."'";
		$sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $_GET['itno'] . "' and BRAND_NAME='" . $_GET["brand"] . "'") or die(mysqli_error());
	} else {
		$sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $_GET['itno'] . "'") or die(mysqli_error());
	}
	if ($row = mysqli_fetch_array($sql)) {

		$ResponseXML .= "<str_code><![CDATA[" . $row['STK_NO'] . "]]></str_code>";
		$ResponseXML .= "<str_description><![CDATA[" . $row['DESCRIPT'] . "]]></str_description>";
		$ResponseXML .= "<str_selpri><![CDATA[" . $row['SELLING'] . "]]></str_selpri>";

		$department = trim(substr($_GET["department"], 0, 2));

		$sql = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $_GET['itno'] . "' AND STO_CODE='" . $department . "'") or die(mysqli_error());
		if ($row = mysqli_fetch_array($sql)) {
			if (is_null($row["QTYINHAND"]) == false) {
				$ResponseXML .= "<qtyinhand><![CDATA[" . $row["QTYINHAND"] . "]]></qtyinhand>";
			} else {
				$ResponseXML .= "<qtyinhand><![CDATA[]]></qtyinhand>";
			}
		}

	}

	$ResponseXML .= "</salesdetails>";
	echo $ResponseXML;

}

if ($_GET["Command"] == "pass_assignbrand") {
	$_SESSION["brand"] = $_GET["brand"];
	$_SESSION["department"] = $_GET["department"];

}
?>
