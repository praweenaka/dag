<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
	 date_default_timezone_set('Asia/Colombo'); 
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
		
if($_GET["Command"]=="view_inv")
{
			   
			
	$ResponseXML .= "";
	$ResponseXML .= "<balancedetails>";
			
	$amount_40=0;
	$amount_43=0;
	$rtn_40=0;
	$rtn_43=0;
	$q40=0;
	$q43=0;
	$r40=0;
	$r43=0;
	$q37=0;
	$r37=0;
	$amount_37=0;
	$rtn_37=0;
			
	$sql="delete from tmp_auto_credit_note";
	$result =$db->RunQuery($sql);
			
	$sql="Select cus_code,sum(QTY) as qty from viewinv   where s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and cancel_m='0' group by cus_code order by cus_code";
	$result =$db->RunQuery($sql);
		
	$ResponseXML .= "<balance_table><![CDATA[<table width=\"735\" border=\"0\" class=\"form-matrix-table\">";
		 		
	$i=1;

//==============================VOLTA=======================================================================
	if (trim($_GET["combo1"]) == "VOLTA") {
		$ResponseXML .= "<tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							 
   							</tr>";
							
    	while ($row = mysql_fetch_array($result)){
        	$amount_40 = 0;
        	$amount_43 = 0;
        	$amount_37 = 0;
        	$rtn_40 = 0;
        	$rtn_43 = 0;
        	$rtn_37 = 0;
        	$q40 = 0;
        	$q43 = 0;
        	$q37 = 0;
        	$r40 = 0;
        	$r43 = 0;
        	$r37 = 0;
        	$ccode = $row["cus_code"];
        				
						
			$code="";
			$name="";
			$amount1=0;
			$qty1=0;
			$amount2=0;
			$qty2=0;
			$crnno="";
			$txndate="";
			$amount=0;
			$status="";
										
										
			if ($row["qty"] >= 20 and $row["qty"] < 50) {
						
				$sql_40="Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '".trim($row["cus_code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '35' and cancel_m='0' group by cus_code";
				$result_40 =$db->RunQuery($sql_40);
					
				$sql_43="Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '".trim($row["cus_code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per != '35' and cancel_m='0' group by cus_code";
				$result_43 =$db->RunQuery($sql_43);
							
				$sql_1_40="Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='".trim($row["cus_code"])."' and   Brand='".trim($_GET["combo1"])."' and DIS_P = '35' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and CANCELL='0' group by C_CODE";
				$result_1_40 =$db->RunQuery($sql_1_40);
							
				$sql_1_43="Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='".trim($row["cus_code"])."' and   Brand='".trim($_GET["combo1"])."' and DIS_P != '35' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and CANCELL='0' group by C_CODE";
				$result_1_43 =$db->RunQuery($sql_1_43);
							
                   
           
           		if ($row_40 = mysql_fetch_array($result_40)){
                	if ($row_40["qty"] != "") { $q40 = $row_40["qty"]; }
                	if ($row_40["amount"] != "" ){ $amount_40 = $row_40["amount"]; }
           		}
							
				if ($row_43 = mysql_fetch_array($result_43)){
                	if ($row_43["qty"] != "") { $q43 = $row_43["qty"]; }
                	if ($row_43["amount"] != "" ){ $amount_43 = $row_43["amount"]; }
           		}
							
				if ($row_1_40 = mysql_fetch_array($result_1_40)){
                	if ($row_1_40["qty"] != "") { $r40 = $row_1_40["qty"]; }
                	if ($row_1_40["amount"] != "" ){ $rtn_40 = $row_1_40["amount"]; }
           		}
							
				if ($row_1_43 = mysql_fetch_array($result_1_43)){
                	if ($row_1_43["qty"] != "") { $r43 = $row_1_43["qty"]; }
                	if ($row_1_43["amount"] != "" ){ $rtn_43 = $row_1_43["amount"]; }
           		}
							
           		$sql_rsven="Select NAME from vendor where CODE = '".$row["cus_code"]."'";
				$result_rsven =$db->RunQuery($sql_rsven);
				if ($row_rsven = mysql_fetch_array($result_rsven)){
							
           			if (((($q40 + $q43) - ($r40 + $r43)) >= 20) and (($q40 - $r40) != 0)){
									
						$ResponseXML .= "<tr>
                           	  			<td>".$row["cus_code"]."</td>
                              			<td>".$row_rsven['NAME']."</td>
                              			<td>".($amount_43 - $rtn_43)."</td>
                                        <td>".$q43 - $r43."</td>
										<td>".($amount_40 - $rtn_40)."</td>
										<td>".$q40 - $r40."</td>";
										
						$code=$row["cus_code"];
						$name=$row_rsven['NAME'];
						$amount1=($amount_43 - $rtn_43);
						$qty1=$q43 - $r43;
						$amount2=($amount_40 - $rtn_40);
						$qty2=$q40 - $r40;
										
						$m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/V";
										
						$chk="chk".$i;
										
						$sql_rs1="Select * from cred where C_CODE='".$row["cus_code"]."' and C_SETINV ='".trim($m_flag)."'";
						$result_rs1 =$db->RunQuery($sql_rs1);
						if ($row_rs1 = mysql_fetch_array($result_rs1)){
							$ResponseXML .=  "<td>".$row_rs1["C_REFNO"]."</td>
							<td>".date("Y-m-d",strtotime($row_rs1["C_DATE"]))."</td>
							<td>".number_format($row_rs1["C_PAYMENT"], 2, ".", ",")."</td>
							<td>Lock</td>
							<td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
							$crnno=$row_rs1["C_REFNO"];
							$txndate=date("Y-m-d",strtotime($row_rs1["C_DATE"]));
							$amount=$row_rs1["C_PAYMENT"];
							$status="Lock";
												   
							$i=$i+1;
						} else {		   
							$ResponseXML .=  "<td>Not Saved</td>
							<td></td>
							<td>".number_format((($amount_40 - $rtn_40)/65*2.5), 2, ".", ",")."</td>
							<td></td>
							<td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
												   
							$crnno="Not Saved";
							$txndate="";
							$amount=(($amount_40 - $rtn_40)/65*2.5);
							$status="";
							$i=$i+1;
						}
																				
                        $ResponseXML .=  "</tr>";
					}
				}
            }
						
        	if ($row["QTY"]>50){
						
				$sql_40="Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '".trim($row["cus_code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '35' and cancel_m='0' group by cus_code";
				$result_40 =$db->RunQuery($sql_40);
							
				$sql_37="Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '".trim($row["cus_code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '37.5' and cancel_m='0' group by cus_code";
				$result_37 =$db->RunQuery($sql_37);
							
				$sql_43="Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '".trim($row["cus_code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per != '35' and DIS_per!='37.5' and cancel_m='0' group by cus_code";
				$result_43 =$db->RunQuery($sql_43);
							
				$sql_1_40="Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='".trim($row["cus_code"])."' and   Brand='".trim($_GET["combo1"])."' and DIS_P = '35' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and CANCELL='0' group by C_CODE";
				$result_1_40 =$db->RunQuery($sql_1_40);
							
				$sql_1_43="Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='".trim($row["cus_code"])."' and   Brand='".trim($_GET["combo1"])."' and DIS_P != '35' and DIS_P != '37.5' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and CANCELL='0' group by C_CODE";
				$result_1_43 =$db->RunQuery($sql_1_43);
							
				$sql_1_37="Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='".trim($row["cus_code"])."' and   Brand='".trim($_GET["combo1"])."' and DIS_P = '37.5' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and CANCELL='0' group by C_CODE";
				$result_1_37 =$db->RunQuery($sql_1_37);
							
				if ($row_40 = mysql_fetch_array($result_40)){
					if ($row_40["qty"]!=""){ $q40 = $row_40["qty"]; }
					if ($row_40["amount"]!=""){ $amount_40 = $row_40["amount"]; }
				}
							
				if ($row_43 = mysql_fetch_array($result_43)){
					if ($row_43["qty"]!=""){ $q40 = $row_43["qty"]; }
					if ($row_43["amount"]!=""){ $amount_43 = $row_43["amount"]; }
				}
							
				if ($row_1_40 = mysql_fetch_array($result_40)){
					if ($row_1_40["qty"]!=""){ $r40 = $row_1_40["qty"]; }
					if ($row_1_40["grand_tot"]!=""){ $rtn_40 = $row_1_40["grand_tot"]; }
				}
							
				if ($row_1_43 = mysql_fetch_array($result_43)){
					if ($row_1_43["qty"]!=""){ $r43 = $row_1_43["qty"]; }
					if ($row_1_43["grand_tot"]!=""){ $rtn_43 = $row_1_43["grand_tot"]; }
				}
							
				if ($row_37 = mysql_fetch_array($result_43)){
					if ($row_37["qty"]!=""){ $q37 = $row_37["qty"]; }
					if ($row_37["amount"]!=""){ $amount_37 = $row_37["amount"]; }
				}
							
				if ($row_1_37 = mysql_fetch_array($result_37)){
					if ($row_1_43["qty"]!=""){ $r43 = $row_1_43["qty"]; }
					if ($row_1_43["grand_tot"]!=""){ $rtn_43 = $row_1_43["grand_tot"]; }
				}
							
				$sql_rsven="Select name from vendor where code = '".trim($row["cus_code"])."'";
				$result_rsven =$db->RunQuery($sql_rsven);
				$row_rsven = mysql_fetch_array($result_rsven);
				if (((($q40 + $q43 + $q37) - ($r40 + $r43 + $r37)) >= 50) and ((($q40 + $q37) - ($r40 + $r37)) != 0)) {
								
					$ResponseXML .= "<tr>
                    <td>".$row["cus_code"]."</td>
                    <td>".$row_rsven['NAME']."</td>
                              			<td>".number_format(($amount_43 - $rtn_43), 2, ".", ",")."</td>
                                        <td>".$q43 - $r43."</td>
										<td>".number_format((($amount_40 + $amount_37) - ($rtn_40 + $rtn_37)), 2, ".", ",")."</td>
										<td>".($q40 + $q37)-($r40 + $r37)."</td>";
										
					$code=$row["cus_code"];
					$name=$row_rsven['NAME'];
					$amount1=($amount_43 - $rtn_43);
					$qty1=$q43 - $r43;
					$amount2=(($amount_40 + $amount_37) - ($rtn_40 + $rtn_37));
					$qty2=($q40 + $q37)-($r40 + $r37);
										
					$m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/V";
										
					$chk="chk".$i;
										
					$sql_rs1="Select * from cred where C_CODE='".$row["cus_code"]."' and C_SETINV ='".trim($m_flag)."'";
					$result_rs1 =$db->RunQuery($sql_rs1);
					if ($row_rs1 = mysql_fetch_array($result_rs1)){
						$ResponseXML .=  "<td>".$row_rs1["C_REFNO"]."</td>
												   <td>".date("Y-m-d",strtotime($row_rs1["C_DATE"]))."</td>
												   <td>".number_format($row_rs1["C_PAYMENT"], 2, ".", ",")."</td>
												   <td>Lock</td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno=$row_rs1["C_REFNO"];
						$txndate=date("Y-m-d",strtotime($row_rs1["C_DATE"]));
						$amount=$row_rs1["C_PAYMENT"];
						$status="Lock";
						$i=$i+1; 
					} else {		   
						$ResponseXML .=  "<td>Not Saved</td>
												   <td></td>
												   <td>".number_format((($amount_40 - $rtn_40) / 65 * 5) + (($amount_37 - $rtn_37) / 62.5 * 2.5), 2, ".", ",")."</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno="Not Saved";
						$txndate="";
						$amount=(($amount_40 - $rtn_40) / 65 * 5) + (($amount_37 - $rtn_37) / 62.5 * 2.5);
						$status="";
						$i=$i+1;
					}
																				
                    $ResponseXML .=  "</tr>";
				}
			}
			$sql_tmp="insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status) values ('".$code."', '".$name."', ".$amount1.", ".$qty1.", ".$amount2.", ".$qty2.", '".$crnno."', '".$txndate."', ".$amount.", '".$status."')";
			$result_tmp =$db->RunQuery($sql_tmp);	
		}			
	}
						
						
    				    
			
				//==============================LINGLONG=======================================================================
	if (trim($_GET["combo1"]) == "LINGLONG") {
		$ResponseXML .= "
                   <tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							 
   							</tr>";
						
    	while ($row = mysql_fetch_array($result)){
        	$amount_40 = 0;
        	$amount_43 = 0;
        	$rtn_40 = 0;
        	$rtn_43 = 0;
        	$q40 = 0;
        	$q43 = 0;
        	$r40 = 0;
        	$r43 = 0;
        	$ccode = $row["cus_code"];
			
												
			$sql_40="Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '".trim($row["cus_code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '35' and cancel_m='0' group by cus_code";
			$result_40 =$db->RunQuery($sql_40);
							
			$sql_43="Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '".trim($row["cus_code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per != '35' and cancel_m='0' group by cus_code";
			$result_43 =$db->RunQuery($sql_43);
							
			$sql_1_40="Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='".trim($row["cus_code"])."' and   Brand='".trim($_GET["combo1"])."' and DIS_P = '35' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and CANCELL='0' group by C_CODE";
			$result_1_40 =$db->RunQuery($sql_1_40);
							
			$sql_1_43="Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='".trim($row["cus_code"])."' and   Brand='".trim($_GET["combo1"])."' and DIS_P != '35' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and CANCELL='0' group by C_CODE";
			$result_1_43 =$db->RunQuery($sql_1_43);
							
			if ($row_40 = mysql_fetch_array($result_40)){
				if ($row_40["qty"]!=""){ $q40 = $row_40["qty"]; }
				if ($row_40["amount"]!=""){ $amount_40 = $row_40["amount"]; }
			}
							
			if ($row_43 = mysql_fetch_array($result_43)){
				if ($row_43["qty"]!=""){ $q40 = $row_43["qty"]; }
				if ($row_43["amount"]!=""){ $amount_43 = $row_43["amount"]; }
			}
							
			if ($row_1_40 = mysql_fetch_array($result_40)){
				if ($row_1_40["qty"]!=""){ $r40 = $row_1_40["qty"]; }
				if ($row_1_40["grand_tot"]!=""){ $rtn_40 = $row_1_40["grand_tot"]; }
			}
							
			if ($row_1_43 = mysql_fetch_array($result_43)){
				if ($row_1_43["qty"]!=""){ $r43 = $row_1_43["qty"]; }
				if ($row_1_43["grand_tot"]!=""){ $rtn_43 = $row_1_43["grand_tot"]; }
			}
							
							
			$sql_rsven="Select NAME from vendor where CODE = '".$row["cus_code"]."'";
			$result_rsven =$db->RunQuery($sql_rsven);
			if ($row_rsven = mysql_fetch_array($result_rsven)){
							
           		if (((($q40 + $q43) - ($r40 + $r43)) >= 20) and (($q40 - $r40) != 0)){
									
					$ResponseXML .= "<tr>
                           	  			<td>".$row["cus_code"]."</td>
                              			<td>".$row_rsven['NAME']."</td>
                              			<td>".number_format(($amount_43 - $rtn_43), 2, ".", ",")."</td>
                                        <td>".$q43 - $r43."</td>
										<td>".number_format(($amount_40 - $rtn_40), 2, ".", ",")."</td>
										<td>".$q40 - $r40."</td>";
										
					$code=$row["cus_code"];
					$name=$row_rsven['NAME'];
					$amount1=($amount_43 - $rtn_43);
					$qty1=$q43 - $r43;
					$amount2=($amount_40 - $rtn_40);
					$qty2=$q40 - $r40;
										
					$m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/L";
										
					$chk="chk".$i;
										
					$sql_rs1="Select * from cred where C_CODE='".$row["cus_code"]."' and C_SETINV ='".trim($m_flag)."'";
					$result_rs1 =$db->RunQuery($sql_rs1);
					if ($row_rs1 = mysql_fetch_array($result_rs1)){
						$ResponseXML .=  "<td>".$row_rs1["C_REFNO"]."</td>
												   <td>".date("Y-m-d",strtotime($row_rs1["C_DATE"]))."</td>
												   <td>".number_format($row_rs1["C_PAYMENT"], 2, ".", ",")."</td>
												   <td>Lock</td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno=$row_rs1["C_REFNO"];
						$txndate=date("Y-m-d",strtotime($row_rs1["C_DATE"]));
						$amount=$row_rs1["C_PAYMENT"];
						$status="Lock";
						$i=$i+1;	   
					} else {		   
						$ResponseXML .=  "<td>Not Saved</td>
												   <td></td>
												   <td>".number_format((($amount_40 - $rtn_40)/65*2.5), 2, ".", ",")."</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno="Not Saved";
						$txndate="";
						$amount=(($amount_40 - $rtn_40)/65*2.5);
						$status="";
												   
						$i=$i+1;
					}
																				
                    $ResponseXML .=  "</tr>";
				}
			}
							
			$sql_tmp="insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status) values ('".$code."', '".$name."', ".$amount1.", ".$qty1.", ".$amount2.", ".$qty2.", '".$crnno."', '".$txndate."', ".$amount.", '".$status."')";
						$result_tmp =$db->RunQuery($sql_tmp);	
			
		}			
	}						
			
							//==============================COOPER=======================================================================
	if (trim($_GET["combo1"]) == "COOPER") {
		$ResponseXML .= "
                            <tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							 
   							</tr>";
						
    	while ($row = mysql_fetch_array($result)){
        	$amount_40 = 0;
        	$amount_43 = 0;
        	$rtn_40 = 0;
        	$rtn_43 = 0;
        	$q40 = 0;
       		$q43 = 0;
        	$r40 = 0;
        	$r43 = 0;
        	$ccode = $row["cus_code"];
												
			$sql_40="Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '".trim($row["cus_code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '35' and cancel_m='0' group by cus_code";
			$result_40 =$db->RunQuery($sql_40);
							
			$sql_43="Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '".trim($row["cus_code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per != '35' and cancel_m='0' group by cus_code";
			$result_43 =$db->RunQuery($sql_43);
							
			$sql_1_40="Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='".trim($row["cus_code"])."' and   Brand='".trim($_GET["combo1"])."' and DIS_P = '35' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and CANCELL='0' group by C_CODE";
			$result_1_40 =$db->RunQuery($sql_1_40);
							
			$sql_1_43="Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='".trim($row["cus_code"])."' and   Brand='".trim($_GET["combo1"])."' and DIS_P != '35' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and CANCELL='0' group by C_CODE";
			$result_1_43 =$db->RunQuery($sql_1_43);
							
			if ($row_40 = mysql_fetch_array($result_40)){
				if ($row_40["qty"]!=""){ $q40 = $row_40["qty"]; }
				if ($row_40["amount"]!=""){ $amount_40 = $row_40["amount"]; }
			}
							
			if ($row_43 = mysql_fetch_array($result_43)){
				if ($row_43["qty"]!=""){ $q40 = $row_43["qty"]; }
				if ($row_43["amount"]!=""){ $amount_43 = $row_43["amount"]; }
			}
							
			if ($row_1_40 = mysql_fetch_array($result_40)){
				if ($row_1_40["qty"]!=""){ $r40 = $row_1_40["qty"]; }
				if ($row_1_40["grand_tot"]!=""){ $rtn_40 = $row_1_40["grand_tot"]; }
			}
							
			if ($row_1_43 = mysql_fetch_array($result_43)){
				if ($row_1_43["qty"]!=""){ $r43 = $row_1_43["qty"]; }
				if ($row_1_43["grand_tot"]!=""){ $rtn_43 = $row_1_43["grand_tot"]; }
			}
							
			$sql_rsven="Select NAME from vendor where CODE = '".$row["cus_code"]."'";
			$result_rsven =$db->RunQuery($sql_rsven);
			if ($row_rsven = mysql_fetch_array($result_rsven)){
							
           		if (((($q40 + $q43) - ($r40 + $r43)) >= 20) and (($q40 - $r40) != 0)){
									
					$ResponseXML .= "<tr>
                           	  			<td>".$row["cus_code"]."</td>
                              			<td>".$row_rsven['NAME']."</td>
                              			<td>".number_format(($amount_43 - $rtn_43), 2, ".", ",")."</td>
                                        <td>".$q43 - $r43."</td>
										<td>".number_format(($amount_40 - $rtn_40), 2, ".", ",")."</td>
										<td>".$q40 - $r40."</td>";
										
					$code=$row["cus_code"];
					$name=$row_rsven['NAME'];
					$amount1=($amount_43 - $rtn_43);
					$qty1=$q43 - $r43;
					$amount2=($amount_40 - $rtn_40);
					$qty2=$q40 - $r40;
										
					$m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/C";
										
					$chk="chk".$i;
										
					$sql_rs1="Select * from cred where C_CODE='".$row["cus_code"]."' and C_SETINV ='".trim($m_flag)."'";
					$result_rs1 =$db->RunQuery($sql_rs1);
					if ($row_rs1 = mysql_fetch_array($result_rs1)){
						$ResponseXML .=  "<td>".$row_rs1["C_REFNO"]."</td>
												   <td>".date("Y-m-d",strtotime($row_rs1["C_DATE"]))."</td>
												   <td>".number_format($row_rs1["C_PAYMENT"], 2, ".", ",")."</td>
												   <td>Lock</td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno=$row_rs1["C_REFNO"];
						$txndate=date("Y-m-d",strtotime($row_rs1["C_DATE"]));
						$amount=$row_rs1["C_PAYMENT"];
						$status="Lock";
												   
						$i=$i+1;
														
					} else {		   
						$ResponseXML .=  "<td>Not Saved</td>
												   <td></td>
												   <td>".number_format((($amount_40 - $rtn_40)/65*2.5), 2, ".", ",")."</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno="Not Saved";
						$txndate="";
						$amount=(($amount_40 - $rtn_40)/65*2.5);
						$status="";   
												   
						$i=$i+1;
													
					}
																				
                    $ResponseXML .=  "</tr>";
				}
			}
			
			$sql_tmp="insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status) values ('".$code."', '".$name."', ".$amount1.", ".$qty1.", ".$amount2.", ".$qty2.", '".$crnno."', '".$txndate."', ".$amount.", '".$status."')";
						$result_tmp =$db->RunQuery($sql_tmp);		
		}
	}			
							
		
  				//==============================ROADSTONE=======================================================================
	if (trim($_GET["combo1"]) == "ROADSTONE") {
		$ResponseXML .= "
                            <tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">43%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">43%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">40%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">40%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							 
   							</tr>";
						
    	while ($row = mysql_fetch_array($result)){
        	$amount_40 = 0;
        	$amount_43 = 0;
        	$rtn_40 = 0;
        	$rtn_43 = 0;
        	$q40 = 0;
        	$q43 = 0;
        	$r40 = 0;
        	$r43 = 0;
        	$ccode = $row["cus_code"];
			
												
			$sql_40="Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '".trim($row["cus_code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '45' and cancel_m='0' group by cus_code";
			$result_40 =$db->RunQuery($sql_40);
							
			$sql_43="Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '".trim($row["cus_code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per != '45' and cancel_m='0' group by cus_code";
			$result_43 =$db->RunQuery($sql_43);
							
			$sql_1_40="Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='".trim($row["cus_code"])."' and   Brand='".trim($_GET["combo1"])."' and DIS_P = '45' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and CANCELL='0' group by C_CODE";
			$result_1_40 =$db->RunQuery($sql_1_40);
							
			$sql_1_43="Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='".trim($row["cus_code"])."' and   Brand='".trim($_GET["combo1"])."' and DIS_P != '45' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and CANCELL='0' group by C_CODE";
			$result_1_43 =$db->RunQuery($sql_1_43);
							
			if ($row_40 = mysql_fetch_array($result_40)){
				if ($row_40["qty"]!=""){ $q40 = $row_40["qty"]; }
				if ($row_40["amount"]!=""){ $amount_40 = $row_40["amount"]; }
			}
							
			if ($row_43 = mysql_fetch_array($result_43)){
				if ($row_43["qty"]!=""){ $q40 = $row_43["qty"]; }
				if ($row_43["amount"]!=""){ $amount_43 = $row_43["amount"]; }
			}
							
			if ($row_1_40 = mysql_fetch_array($result_40)){
				if ($row_1_40["qty"]!=""){ $r40 = $row_1_40["qty"]; }
				if ($row_1_40["grand_tot"]!=""){ $rtn_40 = $row_1_40["grand_tot"]; }
			}
							
			if ($row_1_43 = mysql_fetch_array($result_43)){
				if ($row_1_43["qty"]!=""){ $r43 = $row_1_43["qty"]; }
				if ($row_1_43["grand_tot"]!=""){ $rtn_43 = $row_1_43["grand_tot"]; }
			}
							
							
			$sql_rsven="Select NAME from vendor where CODE = '".$row["cus_code"]."'";
			$result_rsven =$db->RunQuery($sql_rsven);
			if ($row_rsven = mysql_fetch_array($result_rsven)){
							
           		if (((($q40 + $q43) - ($r40 + $r43)) >= 150) and (($q40 - $r40) != 0)){
								
					$ResponseXML .= "<tr>
                           	  			<td>".$row["cus_code"]."</td>
                              			<td>".$row_rsven['NAME']."</td>
                              			<td>".number_format(($amount_43 - $rtn_43), 2, ".", ",")."</td>
                                        <td>".$q43 - $r43."</td>
										<td>".number_format(($amount_40 - $rtn_40), 2, ".", ",")."</td>
										<td>".$q40 - $r40."</td>";
										
					$code=$row["cus_code"];
					$name=$row_rsven['NAME'];
					$amount1=($amount_43 - $rtn_43);
					$qty1=$q43 - $r43;
					$amount2=($amount_40 - $rtn_40);
					$qty2=$q40 - $r40;
										
					$m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/R";
										
					$chk="chk".$i;
										
					$sql_rs1="Select * from cred where C_CODE='".$row["cus_code"]."' and C_SETINV ='".trim($m_flag)."'";
					$result_rs1 =$db->RunQuery($sql_rs1);
					if ($row_rs1 = mysql_fetch_array($result_rs1)){
						$ResponseXML .=  "<td>".$row_rs1["C_REFNO"]."</td>
												   <td>".date("Y-m-d",strtotime($row_rs1["C_DATE"]))."</td>
												   <td>".number_format($row_rs1["C_PAYMENT"], 2, ".", ",")."</td>
												   <td>Lock</td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
											
						$crnno=$row_rs1["C_REFNO"];
						$txndate=date("Y-m-d",strtotime($row_rs1["C_DATE"]));
						$amount=$row_rs1["C_PAYMENT"];
						$status="Lock";	
												   
						$i=$i+1;
												   	   
					} else {		   
						$ResponseXML .=  "<td>Not Saved</td>
												   <td></td>
												   <td>".number_format((($amount_40 - $rtn_40)/100)*12.5, 2, ".", ",")."</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno="Not Saved";
						$txndate="";
						$amount=(($amount_40 - $rtn_40)/100)*12.5;
						$status="";  
												   
						$i=$i+1; 	   
					}
																				
                    $ResponseXML .=  "</tr>";
				
				} else if (((($q40 + $q43) - ($r40 + $r43)) >= 100) and (($q40 - $r40) != 0)) {
								
					$ResponseXML .= "<tr>
                           	  			<td>".$row["cus_code"]."</td>
                              			<td>".$row_rsven['NAME']."</td>
                              			<td>".number_format(($amount_43 - $rtn_43), 2, ".", ",")."</td>
                                        <td>".$q43 - $r43."</td>
										<td>".number_format(($amount_40 - $rtn_40), 2, ".", ",")."</td>
										<td>".$q40 - $r40."</td>";
										
					$code=$row["cus_code"];
					$name=$row_rsven['NAME'];
					$amount1=($amount_43 - $rtn_43);
					$qty1=$q43 - $r43;
					$amount2=($amount_40 - $rtn_40);
					$qty2=$q40 - $r40;
										
					$m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/R";
										
					$chk="chk".$i;
										
					$sql_rs1="Select * from cred where C_CODE='".$row["cus_code"]."' and C_SETINV ='".trim($m_flag)."'";
					$result_rs1 =$db->RunQuery($sql_rs1);
					if ($row_rs1 = mysql_fetch_array($result_rs1)){
						$ResponseXML .=  "<td>".$row_rs1["C_REFNO"]."</td>
												   <td>".date("Y-m-d",strtotime($row_rs1["C_DATE"]))."</td>
												   <td>".number_format($row_rs1["C_PAYMENT"], 2, ".", ",")."</td>
												   <td>Lock</td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno=$row_rs1["C_REFNO"];
						$txndate=date("Y-m-d",strtotime($row_rs1["C_DATE"]));
						$amount=$row_rs1["C_PAYMENT"];
						$status="Lock";	
						$i=$i+1;	   
					} else {		   
						$ResponseXML .=  "<td>Not Saved</td>
												   <td></td>
												   <td>".number_format((($amount_40 - $rtn_40)/100)*10, 2, ".", ",")."</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno="Not Saved";
						$txndate="";
						$amount=(($amount_40 - $rtn_40)/100)*10;
						$status=""; 
						$i=$i+1; 	   
					}
				
				} else if (((($q40 + $q43) - ($r40 + $r43)) >= 75) and (($q40 - $r40) != 0)) {
									
					$ResponseXML .= "<tr>
                           	  			<td>".$row["cus_code"]."</td>
                              			<td>".$row_rsven['NAME']."</td>
                              			<td>".number_format(($amount_43 - $rtn_43), 2, ".", ",")."</td>
                                        <td>".$q43 - $r43."</td>
										<td>".number_format(($amount_40 - $rtn_40), 2, ".", ",")."</td>
										<td>".$q40 - $r40."</td>";
										
					$code=$row["cus_code"];
					$name=$row_rsven['NAME'];
					$amount1=($amount_43 - $rtn_43);
					$qty1=$q43 - $r43;
					$amount2=($amount_40 - $rtn_40);
					$qty2=$q40 - $r40;
										
					$m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/R";
										
					$chk="chk".$i;
										
					$sql_rs1="Select * from cred where C_CODE='".$row["cus_code"]."' and C_SETINV ='".trim($m_flag)."'";
					$result_rs1 =$db->RunQuery($sql_rs1);
					if ($row_rs1 = mysql_fetch_array($result_rs1)){
						$ResponseXML .=  "<td>".$row_rs1["C_REFNO"]."</td>
												   <td>".date("Y-m-d",strtotime($row_rs1["C_DATE"]))."</td>
												   <td>".number_format($row_rs1["C_PAYMENT"], 2, ".", ",")."</td>
												   <td>Lock</td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno=$row_rs1["C_REFNO"];
						$txndate=date("Y-m-d",strtotime($row_rs1["C_DATE"]));
						$amount=$row_rs1["C_PAYMENT"];
						$status="Lock";	
						$i=$i+1; 		 	   
					} else {		   
						$ResponseXML .=  "<td>Not Saved</td>
												   <td></td>
												   <td>".number_format((($amount_40 - $rtn_40)/100)*7.5, 2, ".", ",")."</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno="Not Saved";
						$txndate="";
						$amount=(($amount_40 - $rtn_40)/100)*7.5;
						$status="";  
						$i=$i+1; 		   
					}
					$ResponseXML .=  "</tr>";
										
				} else if (((($q40 + $q43) - ($r40 + $r43)) >= 50) and (($q40 - $r40) != 0)) {
									
					$ResponseXML .= "<tr>
                     	  			<td>".$row["cus_code"]."</td>
                              			<td>".$row_rsven['NAME']."</td>
                              			<td>".number_format(($amount_43 - $rtn_43), 2, ".", ",")."</td>
                                        <td>".$q43 - $r43."</td>
										<td>".number_format(($amount_40 - $rtn_40), 2, ".", ",")."</td>
										<td>".$q40 - $r40."</td>";
										
					$code=$row["cus_code"];
					$name=$row_rsven['NAME'];
					$amount1=($amount_43 - $rtn_43);
					$qty1=$q43 - $r43;
					$amount2=($amount_40 - $rtn_40);
					$qty2=$q40 - $r40;
										
					$m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/R";
										
					$chk="chk".$i;
										
					$sql_rs1="Select * from cred where C_CODE='".$row["cus_code"]."' and C_SETINV ='".trim($m_flag)."'";
					$result_rs1 =$db->RunQuery($sql_rs1);
					if ($row_rs1 = mysql_fetch_array($result_rs1)){
						$ResponseXML .=  "<td>".$row_rs1["C_REFNO"]."</td>
												   <td>".date("Y-m-d",strtotime($row_rs1["C_DATE"]))."</td>
												   <td>".number_format($row_rs1["C_PAYMENT"], 2, ".", ",")."</td>
												   <td>Lock</td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno=$row_rs1["C_REFNO"];
						$txndate=date("Y-m-d",strtotime($row_rs1["C_DATE"]));
						$amount=$row_rs1["C_PAYMENT"];
						$status="Lock";	
						$i=$i+1; 		   
					} else {		   
						$ResponseXML .=  "<td>Not Saved</td>
												   <td></td>
												   <td>".number_format((($amount_40 - $rtn_40)/100)*5, 2, ".", ",")."</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno="Not Saved";
						$txndate="";
						$amount=(($amount_40 - $rtn_40)/100)*5;
						$status=""; 
						$i=$i+1; 	 	   
					}
					$ResponseXML .=  "</tr>";
										
				} else if (((($q40 + $q43) - ($r40 + $r43)) >= 25) and (($q40 - $r40) != 0)) {
									
					$ResponseXML .= "<tr>
                           	  			<td>".$row["cus_code"]."</td>
                              			<td>".$row_rsven['NAME']."</td>
                              			<td>".number_format(($amount_43 - $rtn_43), 2, ".", ",")."</td>
                                        <td>".$q43 - $r43."</td>
										<td>".number_format(($amount_40 - $rtn_40), 2, ".", ",")."</td>
										<td>".$q40 - $r40."</td>";
										
					$code=$row["cus_code"];
					$name=$row_rsven['NAME'];
					$amount1=($amount_43 - $rtn_43);
					$qty1=$q43 - $r43;
					$amount2=($amount_40 - $rtn_40);
					$qty2=$q40 - $r40;
										
					$m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/R";
										
					$chk="chk".$i;
										
					$sql_rs1="Select * from cred where C_CODE='".$row["cus_code"]."' and C_SETINV ='".trim($m_flag)."'";
					$result_rs1 =$db->RunQuery($sql_rs1);
					if ($row_rs1 = mysql_fetch_array($result_rs1)){
						$ResponseXML .=  "<td>".$row_rs1["C_REFNO"]."</td>
												   <td>".date("Y-m-d",strtotime($row_rs1["C_DATE"]))."</td>
												   <td>".number_format($row_rs1["C_PAYMENT"], 2, ".", ",")."</td>
												   <td>Lock</td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno=$row_rs1["C_REFNO"];
						$txndate=date("Y-m-d",strtotime($row_rs1["C_DATE"]));
						$amount=$row_rs1["C_PAYMENT"];
						$status="Lock";	
						$i=$i+1; 			   
					} else {		   
						$ResponseXML .=  "<td>Not Saved</td>
												   <td></td>
												   <td>".number_format((($amount_40 - $rtn_40)/100)*3.5, 2, ".", ",")."</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno="Not Saved";
						$txndate="";
						$amount=(($amount_40 - $rtn_40)/100)*3.5;
						$status="";
						$i=$i+1; 	  	   
					}
					$ResponseXML .= "</tr>";
										
				} else if (((($q40 + $q43) - ($r40 + $r43)) >= 15) and (($q40 - $r40) != 0)) {
									
					$ResponseXML .= "<tr>
                           	  			<td>".$row["cus_code"]."</td>
                              			<td>".$row_rsven['NAME']."</td>
                              			<td>".number_format(($amount_43 - $rtn_43), 2, ".", ",")."</td>
                                        <td>".$q43 - $r43."</td>
										<td>".number_format(($amount_40 - $rtn_40), 2, ".", ",")."</td>
										<td>".$q40 - $r40."</td>";
										
					$code=$row["cus_code"];
					$name=$row_rsven['NAME'];
					$amount1=($amount_43 - $rtn_43);
					$qty1=$q43 - $r43;
					$amount2=($amount_40 - $rtn_40);
					$qty2=$q40 - $r40;
										
					$m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/R";
										
					$chk="chk".$i;
										
					$sql_rs1="Select * from cred where C_CODE='".$row["cus_code"]."' and C_SETINV ='".trim($m_flag)."'";
					$result_rs1 =$db->RunQuery($sql_rs1);
					if ($row_rs1 = mysql_fetch_array($result_rs1)){
						$ResponseXML .=  "<td>".$row_rs1["C_REFNO"]."</td>
												   <td>".date("Y-m-d",strtotime($row_rs1["C_DATE"]))."</td>
												   <td>".number_format($row_rs1["C_PAYMENT"], 2, ".", ",")."</td>
												   <td>Lock</td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno=$row_rs1["C_REFNO"];
						$txndate=date("Y-m-d",strtotime($row_rs1["C_DATE"]));
						$amount=$row_rs1["C_PAYMENT"];
						$status="Lock";	
												   
						$i=$i+1; 		
					} else {		   
						$ResponseXML .=  "<td>Not Saved</td>
												   <td></td>
												   <td>".number_format((($amount_40 - $rtn_40)/100)*2.5, 2, ".", ",")."</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";
												   
						$crnno="Not Saved";
						$txndate="";
						$amount=(($amount_40 - $rtn_40)/100)*2.5;
						$status="";
												   
						$i=$i+1; 	
					}
					$ResponseXML .= "</tr>";	
				}			
			}
						$sql_tmp="insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status) values ('".$code."', '".$name."', ".$amount1.", ".$qty1.", ".$amount2.", ".$qty2.", '".$crnno."', '".$txndate."', ".$amount.", '".$status."')";
						$result_tmp =$db->RunQuery($sql_tmp);		
		}
	}			
  	$ResponseXML .=  "</table>]]></balance_table>";		
	$ResponseXML .=  "</balancedetails>";
	echo $ResponseXML;		
}
	
	
	
	
  if ($_GET["Command"]=="changechk"){
  	
	$sql_tmp="update tmp_auto_credit_note set status= '".$_GET["chk"]."' where code='".$_GET["code"]."'";
	$result_tmp =$db->RunQuery($sql_tmp);		
	
	
  }
  
  	
  if ($_GET["Command"]=="save_inv"){
  	
	$mvatrate=0.12;
	
  	$sql_tmp="select * from tmp_auto_credit_note";
	$result_tmp =$db->RunQuery($sql_tmp);
	while ($row_tmp = mysql_fetch_array($result_tmp)){
		
		if ($row_tmp["status"]=="Yes"){
			
			$txt_cuscode = $row_tmp["code"];
            $txtamount = $row_tmp["amounts"];
			
			$sql="Select CRN from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="00000000".$row["CRN"];
			$lenth=strlen($tmpinvno);
			$txtrefno=trim("CRN/ ").substr($tmpinvno, $lenth-9);
			
			if (trim($_GET["combo1"]) == "VOLTA") {
				$sql_RSINVO="Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '".trim($row_tmp["code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per != '40' and cancel_m='0' order by id";
				$result_RSINVO =$db->RunQuery($sql_RSINVO);
				$row_RSINVO = mysql_fetch_array($result_RSINVO);
			}
			
			if (trim($_GET["combo1"]) == "LINGLONG") {
				$sql_RSINVO="Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '".trim($row_tmp["code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '35' and cancel_m='0' order by id";
				$result_RSINVO =$db->RunQuery($sql_RSINVO);
				$row_RSINVO = mysql_fetch_array($result_RSINVO);
			}
			
			if (trim($_GET["combo1"]) == "COOPER") {
				$sql_RSINVO="Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '".trim($row_tmp["code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '35' and cancel_m='0' order by id";
				$result_RSINVO =$db->RunQuery($sql_RSINVO);
				$row_RSINVO = mysql_fetch_array($result_RSINVO);
			}
			
			if (trim($_GET["combo1"]) == "ROADSTONE") {
				$sql_RSINVO="Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '".trim($row_tmp["code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '45' and cancel_m='0' order by id";
				$result_RSINVO =$db->RunQuery($sql_RSINVO);
				$row_RSINVO = mysql_fetch_array($result_RSINVO);
			}
			
			$txt_invno = $row_RSINVO["REF_NO"];
            $m_rep = $row_RSINVO["SAL_EX"];
            $m_dep = $row_RSINVO["DEPARTMENT"];
			$m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/R";
			if (trim($_GET["combo1"]) == "VOLTA") { $m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/V"; } 
			if (trim($_GET["combo1"]) == "LINGLONG") { $m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/L"; } 
			if (trim($_GET["combo1"]) == "COOPER") { $m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/C"; } 
			if (trim($_GET["combo1"]) == "ROADSTONE") { $m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/R"; } 
						
			if (trim($_GET["combo1"]) == "VOLTA") { $txt_remark = "Additional 5%/2.5% Trade Discount for VOLTA - month of ".date("m/Y",strtotime($_GET["dte_dor"])); } 
			
			if (trim($_GET["combo1"]) == "LINGLONG") { $txt_remark = "Additional 2.5% Trade Discount for LING LONG month of ".date("m/Y",strtotime($_GET["dte_dor"])); } 
			
			if (trim($_GET["combo1"]) == "COOPER") { $txt_remark = "Additional 2.5% Trade Discount for COOPER month of ".date("m/Y",strtotime($_GET["dte_dor"])); } 
			
			if (trim($_GET["combo1"]) == "ROADSTONE") { $txt_remark = "Additional Trade Discounts for Roadstone month of ".date("m/Y",strtotime($_GET["dte_dor"])); } 
			
          	$sql_cbal= "insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate) values('".trim($txtrefno)."', '".date("Y-m-d")."', 'CNT', '".trim($txt_cuscode)."', ".$txtamount.", ".$txtamount.", '".trim($_GET["combo1"])."', '".$m_dep."', '".$m_rep."', '0', '".$mvatrate."')"; 
			$result_cbal =$db->RunQuery($sql_cbal);
			
		//	$sql_cbal= "insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate, flag1) values('".trim($txtrefno)."', '".date("Y-m-d",strtotime($_GET["dte_dor"]))."', 'CNQ', '".trim($txt_cuscode)."', ".$txtamount.", ".$txtamount.", '".trim($_GET["combo1"])."', '01', '".$m_rep."', '0', '".$mvatrate."', '".$txtamount."')"; 
		//	$result_cbal =$db->RunQuery($sql_cbal);
			
			
			$sql_cred= "Insert into cred (C_REFNO, C_DATE, C_INVNO, C_CODE, C_PAYMENT, C_REMARK, C_SALEX, Brand, DEV, C_SETINV) values ('".trim($txtrefno)."', '".date("Y-m-d"). "', '".trim($txt_invno)."', '".trim($txt_cuscode)."', ".$txtamount.", '".trim($txt_remark)."', '".trim($m_rep)."', '".trim($_GET["combo1"])."', '0', '".trim($m_flag)."')";
			$result_cred =$db->RunQuery($sql_cred);
			
			$sql_s_led= "Insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values ('".trim($txtrefno)."', '".date("Y-m-d")."', '".trim($txt_cuscode)."', ".$txtamount.", 'CRN', '".$m_dep."', '0')";
			$result_s_led =$db->RunQuery($sql_s_led);
			
			//==============update credit limit==========================================
			$sql_s= "update vendor set CUR_BAL= CUR_BAL-".$txtamount." where CODE='".trim($txt_cuscode)."'";
			$result_s =$db->RunQuery($sql_s);
			
			$sql_s= "update invpara set CRN=CRN+1";
			$result_s =$db->RunQuery($sql_s);
		}
	}
		
              
           
  }
  
 if ($_GET["Command"]=="chk_number"){
 	$sql="select * from vendor where CODE = '".trim($_GET["txt_cuscode"])."'";
	$result =$db->RunQuery($sql);
	if($row = mysql_fetch_array($result)){
		echo "included";
	} else { 
		echo "no";
	}
 }
 
 		
if($_GET["Command"]=="new_inv")
{

	

			
			$_SESSION["print"]=0;
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			$sql="Select debnoteno from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["debnoteno"];
			$lenth=strlen($tmpinvno);
			$invno=trim("CRI/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["invno"]=$invno;
			
			$sql="delete from tmp_inv_data where str_invno='".$invno."'";
			$result =$db->RunQuery($sql);
			
			echo $invno;	
			
		}
	
	
	if($_GET["Command"]=="cancel_inv")
	{
		$sql="select last_update from invpara";
		$result =$db->RunQuery($sql);
		$row = mysql_fetch_array($result);
		
		$sqlinv="select * from s_salma where REF_NO='".$_GET["invno"]."' ";
		$resultinv =$db->RunQuery($sqlinv);
		if ($rowinv = mysql_fetch_array($resultinv)){
			if (($rowinv["TOTPAY"]==0) and ($rowinv["SDATE"]>$row["last_update"])){
				$sql2="update s_salma set CANCELL='1' where REF_NO='".$_GET["invno"]."'";
				$result2 =$db->RunQuery($sql2);
				
				$sql2="update vendor set CUR_BAL=CUR_BAL-".$rowinv["GRAND_TOT"]." where CODE='".$_GET["customer_code"]."'";
				$result2 =$db->RunQuery($sql2);
				
				$sql2="update br_trn set credit=credit-".$rowinv["GRAND_TOT"]." where CODE='".$_GET["customer_code"]."' and cus_code='".$_GET["customer_code"]."' and Rep='".$_GET["salesrep"]."'";
				$result2 =$db->RunQuery($sql2);
				
				$sqltmp="select * from tmp_inv_data where str_invno='".$_GET['invno']."' ";
				$resulttmp =$db->RunQuery($sqltmp);
				while ($rowtmp = mysql_fetch_array($resulttmp)){
					$sql2="update s_invo set CANCELL='1' where REF_NO='".$_GET['invno']."'";
					$resul2 =$db->RunQuery($sql2);
					
					$sql2="update s_mas set QTYINHAND=QTYINHAND+".$rowtmp["cur_qty"]." where STK_NO='".$rowtmp['str_code']."'";
					$resul2 =$db->RunQuery($sql2);
					
					$sql2="update s_submas set QTYINHAND=QTYINHAND+".$rowtmp["cur_qty"]." where STO_CODE='".$_GET['department']."' and STK_NO='".$rowtmp['str_code']."'";
					$resul2 =$db->RunQuery($sql2);
					
					$sql2="delete from s_trn where REFNO='".$_GET['invno']."'";
					$resul2 =$db->RunQuery($sql2);
					
					$sql2="delete from s_led where REF_NO='".$_GET['invno']."'";
					$resul2 =$db->RunQuery($sql2);
				}
				echo "Canceled";
			} else {
				echo "Can't Cancel";
			}
		}
	}
	
	
	if($_GET["Command"]=="add_tmp")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="delete from tmp_inv_data where str_code='".$_GET['itemcode']."' and str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			$rate=str_replace(",", "", $_GET["rate"]);
			$qty=str_replace(",", "", $_GET["qty"]);
			$discount=str_replace(",", "", $_GET["discount"]);
			$subtotal=str_replace(",", "", $_GET["subtotal"]);
			
			$sql="Insert into tmp_inv_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.") ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_inv_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td >".$row['str_code']."</a></td>
							 <td >".$row['str_description']."</a></td>
							 <td >".number_format($row['cur_rate'], 2, ".", ",")."</a></td>
							 <td >".number_format($row['cur_qty'], 2, ".", ",")."</a></td>
							 <td >".number_format($_GET["discountper"], 2, ".", ",")."</a></td>
							 <td >".number_format($row['cur_subtot'], 2, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
							 include_once("connection.php");
						
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$department."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td >".$qty."</a></td>
							 
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where str_invno='".$_GET['invno']."'";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$vatrate=0.12;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="non"){
					//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
					$ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";
					
					$invtot=number_format($row['tot_sub'], 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
				}
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	if($_GET["Command"]=="setord")
	{
		
		include_once("connection.php");
		
		$len=strlen($_GET["salesord1"]);
		$need=substr($_GET["salesord1"],$len-7, $len);
		$salesord1=trim("ORD/ ").$_GET["salesrep"].trim(" / ").$need;
		
		
		$_SESSION["custno"]=$_GET['custno'];
		$_SESSION["brand"]=$_GET["brand"];
		$_SESSION["department"]=$_GET["department"];
		
		
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				$cuscode=$_GET["custno"];	
				$salesrep=$_GET["salesrep"];
				$brand=$_GET["brand"];
					
			//		$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
				
					
	    //Call SETLIMIT ====================================================================
		
		
		
	/*	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
					$sql = mysql_query("CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error());*/

	$OutpDAMT = 0;
	$OutREtAmt = 0;
	$OutInvAmt = 0;
	$InvClass="";
	
	$sqlclass = mysql_query("select class from brand_mas where barnd_name='".trim($brand)."'") or die(mysql_error());
	if ($rowclass = mysql_fetch_array($sqlclass)){
		if (is_null($rowclass["class"])==false){
			$InvClass=$rowclass["class"];
		}
	}
	
	$sqloutinv = mysql_query("select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($salesrep)."' and class='".$InvClass."'") or die(mysql_error());
	if ($rowoutinv = mysql_fetch_array($sqloutinv)){
		if (is_null($rowoutinv["totout"])==false){
			$OutInvAmt=$rowoutinv["totout"];
		}
	}

$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salesrep)."'") or die(mysql_error());
	while($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
		
		$sqlsttr = mysql_query("select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"]) ."'") or die(mysql_error());
		while($rowsttr = mysql_fetch_array($sqlsttr)){
			$sqlview_s_salma = mysql_query("select class from view_s_salma where REF_NO='".trim($rowsttr["ST_INVONO"])."'") or die(mysql_error());
			if($rowview_s_salma = mysql_fetch_array($sqlview_s_salma)){
				
				if (trim($rowview_s_salma["class"]) == $InvClass){
                    $OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
                }
			}
		}
	}


        
        $pend_ret_set = 0;
		
		$sqlinvcheq = mysql_query("SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='RET'") or die(mysql_error());
		if($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
			if (is_null($rowinvcheq["che_amount"])==false){
				$pend_ret_set=$rowinvcheq["che_amount"];
			}
		}
		
		
		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".trim($salesrep)."'") or die(mysql_error());
		if($rowcheq = mysql_fetch_array($sqlcheq)){
			if (is_null($rowcheq["tot"])==false){
				$OutREtAmt=$rowcheq["tot"];
			} else {
				$OutREtAmt=0;
			}
		}
		
            
 

						 
   $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutREtAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutpDAMT, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";
						 
						  
						      

      $sqlbr_trn = mysql_query("select * from br_trn where Rep='".trim($salesrep)."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'") or die(mysql_error());  
	if($rowbr_trn = mysql_fetch_array($sqlbr_trn)){
		if(is_null($rowbr_trn["credit_lim"]) == false){
			$crLmt=$rowbr_trn["credit_lim"];
		} else {	
			$crLmt=0;		
		}
	
		
		if(is_null($rowbr_trn["tmpLmt"]) == false){
			$tmpLmt=$rowbr_trn["tmpLmt"];
		} else {	
			$tmpLmt=0;		
		}
		
		if (is_null($rowbr_trn["CAT"])==false) {
			$cuscat = trim($rowbr_trn["cat"]);
            if ($cuscat = "A"){ $m = 2.5; }
            if ($cuscat = "B"){ $m = 2.5; }
            if ($cuscat = "C"){ $m = 1; }
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
			//$crebal=$crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
			$txt_crebal = $crLmt * $m - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            //$txt_crebal = number_format($crebal, "2", ".", ",");
          } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
          }
         $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;

	   			
			
			 
    }    
			$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
			$ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
          
         	 $ResponseXML .= "<creditbalance><![CDATA[".number_format($txt_crebal, "2", ".", ",")."]]></creditbalance>";

		

		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML;
				
				
	
	
	}

		
	if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_inv_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
			
			$result =$db->RunQuery($sql);
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_inv_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td >".$row['str_code']."</a></td>
							 <td>".$row['str_description']."</a></td>
							 <td >".$row['cur_rate']."</a></td>
							 <td  >".$row['cur_qty']."</a></td>
							 <td  >".$row['cur_discount']."</a></td>
							 <td  >".$row['cur_subtot']."</a></td>
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
							 include_once("connection.php");
							
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td  >".$qty."</a></td>
                            </tr>";
				}			
				
				$ResponseXML .= "   </table>]]></sales_table>";
				 
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where str_invno='".$_GET['invno']."'";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$vatrate=0.12;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="non"){
					//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
					$ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";
					
					$invtot=number_format($row['tot_sub'], 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
				}
							
                $ResponseXML .= " </salesdetails>";
				
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	

	
if ($_GET["Command"]=="check_print")
{
	
	echo $_SESSION["print"];
}

	
if($_GET["Command"]=="tmp_crelimit")
{	
	echo "abc";
	$crLmt = 0;
	$cat = "";
	
	$rep=trim(substr($_GET["Com_rep1"], 0, 5));
	
	$sql = "select * from br_trn where rep='".$rep."' and cus_code='".trim($_GET["txt_cuscode"])."' and brand='".trim($_GET["cmbbrand1"])."'";
	echo $sql;
	$result =$db->RunQuery($sql);
    if ($row = mysql_fetch_array($result)) {
		$crLmt = $row["credit_lim"];
   		If (is_null($row["cat"])==false) {
      		$cat = trim($row["cat"]);
   		} else {
      		$crLmt = 0;
		}	
   	}
/*	
$_SESSION["CURRENT_DOC"] = 66     //document ID
//$_SESSION["VIEW_DOC"] = true      //  view current document
 $_SESSION["FEED_DOC"] = true      //  save  current document
//$_SESSION["MOD_DOC"] = true       //   delete   current document
//$_SESSION["PRINT_DOC"] = true     // get additional print   of  current document
//$_SESSION["PRICE_EDIT"]= true     // edit selling price
$_SESSION["CHECK_USER"] = true    // check user permission again
$crLmt = $crLmt;
setlocale(LC_MONETARY, "en_US");
$CrTmpLmt = number_format($_GET["txt_tmeplimit"], 2, ".", ",");

$REFNO = trim($_GET["txt_cuscode"]) ;

$AUTH_USER="tmpuser";

$sql = "insert into tmpCrLmt (sdate, stime, username, tmpLmt, class, rep, cuscode, crLmt, cat) values 
        ('".date("Y-m-d")."','".date("H:i:s", time())."' ,'".$AUTH_USER."',".$CrTmpLmt." ,'".trim($_GET["cmbbrand1"])."','".$rep."','".trim($_GET["txt_cuscode"])."',".$crLmt.",'".$cat"' )";
$result =$db->RunQuery($sql);

$sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
$result =$db->RunQuery($sql);
if ($row = mysql_fetch_array($result)) {
   $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
   $resultbrtrn =$db->RunQuery($sqlbrtrn);
   
} else {
  
  	$sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
 	$resultbrtrn =$db->RunQuery($sqlbrtrn);
	
//	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
}

	If ($_GET["Check1"] == 1) {
   		$sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =$db->RunQuery($sqlblack);
	} else {	
    	$sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =$db->RunQuery($sqlblack);
	}

echo "Tempory limit updated";*/

}
	
?>