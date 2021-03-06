<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connectioni.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

$MSHFlexGrid1 = array(array());
$MSHFlexGrid1_count = 0;
$gridchk = array(array());

if ($_GET["Command"] == "view") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

     $year = substr($_GET["DTPicker1"], 0, 4);
    $month = substr($_GET["DTPicker1"], 5, 2);
	
	
	
	
    
    $sql = "delete from Dealer_inc";
    mysqli_query($GLOBALS['dbinv'], $sql);
    

    
	$sql = "Select c_code,sum(grand_tot) as sale,sum(grand_tot-totpay) as out1,sum(GRAND_TOT/(1+(gst/100))) as totsal1 from  VIEW_S_SALMA_BRAND_MAS where  month(SDATE) =" . $month . " and   year(SDATE) =" . $year . "  and cancell = '0' and brand = '" . $_GET['cmbbrand'] . "'	group by c_code order by c_code";
   
	$result_rssales = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($rssales = mysqli_fetch_array($result_rssales)) {

        $Out = "No";
        $out_b = "No";
        $out_a = "No";
        $GO = "No";
        $ccode = "";

        
            If ($rssales['out1'] < 50) {
                $Out = "Ok";
            }
            $sqlp = "Select * from intper where incen_year = '20162' order by traget";
            $result_rsper = mysqli_query($GLOBALS['dbinv'], $sqlp);
            $rs_per = mysqli_fetch_array($result_rsper);
            If ($rssales['sale'] > $rs_per['traget'] And $Out == "Ok") {
                $GO = "Ok";
            }
         
		
		

        $ret = 0;
        $ret_b = 0;
        $ret_a = 0;
        $mpay = 0;
        $mpay_b = 0;
        $mpay_a = 0;
        $mdays = 0;
        $mpay_50 = 0;
        $cnt = 0;

        If ($GO == "Ok") {

            
        $sqlr1 = "Select vatrate, sum(amount) as rtn from  View_cbal_brand where cuscode = '" . $rssales['C_CODE'] . "' and month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and cancell = '0' and brand ='" . $_GET['cmbbrand'] . "' AND trn_type <> 'ARN' and trn_type <> 'REC' and trn_type <> 'DGRN' and flag1 <> '1' group by vatrate ";
     	$ret=0;  
		
        $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sqlr1);
        while ($rs1 = mysqli_fetch_array($result_rs1)) {
             $ret = $ret + ($rs1['rtn'] / (1 + ($rs1['vatrate'] / 100)));
        }
            



            $sqlv = "Select * from vendor where code = '" . $rssales['C_CODE'] . "'";
            $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sqlv);
            $rsVENDOR = mysqli_fetch_array($result_rsVENDOR);

			$sqlsalma = "Select * from VIEW_salma_sttr_brand where c_code = '" . $rssales['C_CODE'] . "' and brand ='" . $_GET['cmbbrand'] . "' and cancell = '0' and month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and deliin_amo <= '0' and deliin_lock = '0' and totpay1 = '1' order by st_refno";
            
			$result_rssalma = mysqli_query($GLOBALS['dbinv'], $sqlsalma);
            while ($rssalma = mysqli_fetch_array($result_rssalma)) {
                $a = $rssalma['ST_REFNO'];
                If ($Out == "Ok") {
                    if ((!is_null($rssalma['deli_date'])) and $rssalma['deli_date'] != "0000-00-00") {
                        $sdate = $rssalma['deli_date'];
                    } else {
                        $sdate = $rssalma['SDATE'];
                    }

                    if ((!is_null($rssalma['st_chdate'])) and $rssalma['st_chdate'] != "0000-00-00") {
                        $stdate = $rssalma['st_chdate'];
                    } else {
                        $stdate = $rssalma['ST_DATE'];
                    }

                    $diff = abs(strtotime($stdate) - strtotime($sdate));
                    $days = floor($diff / (60 * 60 * 24));
                    $mdays = $days;
				 
					 
                    If ($rsVENDOR['incdays'] > 90) {
                        If ($rssalma['cre_pe'] > $rsVENDOR['incdays']) {
                            If ($rssalma['cre_pe'] >= $mdays And $mdays > 50) {
                                $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                $cnt = $cnt + 1;
                            } else {
                                If ($mdays <= 50) {
                                    If ($rssalma['ST_FLAG'] == "UT") {
                                        $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                    } else {
                                        $mpay_50 = $mpay_50 + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                    }
                                }
                            }
                        } else {
                            $incdays = intval($rsVENDOR['incdays']);
                            If (($incdays >= $mdays) And ( $mdays > 50)) {
                                $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                $cnt = $cnt + 1;
                            } else {
                                If ($mdays <= 50) {
                                    If ($rssalma['ST_FLAG'] == "UT") {
                                        $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                    } else {
                                        $mpay_50 = $mpay_50 + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                    }
                                }
                            }
                        }
                    } else {

                        If ($rssalma['cre_pe'] > 90) {
                            If ($rssalma['cre_pe'] >= $mdays And $mdays > 50) {
                                $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                $cnt = $cnt + 1;
                            } Else {
                                If ($mdays <= 50) {
                                    If ($rssalma['ST_FLAG'] == "UT") {
                                        $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                    } else {
                                        $mpay_50 = $mpay_50 + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                    }
                                }
                            }
                        } else {
                            If ($mdays <= 90 And $mdays > 50) {
                                $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                $cnt = $cnt + 1;
                            } Else {
                                If ($mdays <= 50) {
                                    If ($rssalma['ST_FLAG'] == "UT") {
                                        $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                    } Else {
                                        $mpay_50 = $mpay_50 + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                    }
                                }
                            }
                        }
                    }
                }
            }
			 

            If ($mpay > 0 Or $mpay_50 > 0 Or $mpay_b > 0 Or $mpay_a > 0) {
				 
                If ($mpay > 0) {
                    $mpay = $mpay - $ret;
                } Else {
                    $mpay_50 = $mpay_50 - $ret;
                }
                $mpay_b = $mpay_b - $ret_b;
                $mpay_a = $mpay_a - $ret_a;
				 
				
                $sql = "Select * from intper where traget <= '" . ($mpay + $mpay_50) . "' and incen_year = '20161' and class='" . $_GET['cmbbrand'] . "' order by traget desc";
                $sql_50 = "Select * from intper where traget <= '" . ($mpay + $mpay_50) . "' and incen_year = '20161' and class='" . $_GET['cmbbrand'] . "' order by traget desc";
			 
                $result_rsper = mysqli_query($GLOBALS['dbinv'], $sql);
                $result_rsper50 = mysqli_query($GLOBALS['dbinv'], $sql_50);

                $rsper = mysqli_fetch_array($result_rsper);
                $rsper_50 = mysqli_fetch_array($result_rsper50);
                
				If ($rsper or $rsper_50) {
	         
                    $cuscode = $rsVENDOR["CODE"];
                    $CUS_NAME = $rsVENDOR['NAME'];
                    $month2 = $ret;
                    
                    If ($cnt > 0) {
                        $tyre_inc = ($mpay * (($rsper['per'] / 100))) + ($mpay_50 * (($rsper_50['per'] / 100)));
                    } Else {
                        $tyre_inc = ($mpay * (($rsper_50['per'] / 100))) + ($mpay_50 * (($rsper_50['per'] / 100)));
                    }

                    $Month3 = $tyre_inc;
                    $tyre_inc = $tyre_inc;
                    $target = 0;
                    $target_bat = 0;
                    $limit = $mpay + $mpay_50;
                    $sql = "select * from Ins_payment where  I_month='" . date("m", strtotime($_GET["DTPicker1"])) . "' and I_year ='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCODE = '" . $rsVENDOR["CODE"] . "' order by ID ";
                   
					$result_rsIncen = mysqli_query($GLOBALS['dbinv'], $sql);
                    while ($rsIncen = mysqli_fetch_array($result_rsIncen)) {
						
                        If (!Is_Null($rsIncen['Type'])) {
							 
                            If (trim($rsIncen['Type']) == $_GET['cmbbrand']) {
								 
                                $target = $rsIncen['amount'];
                            } Else {
                                $target_bat = $rsIncen['amount'];
                            }
                        }  
                    }
                    $C_TYPE = "Tyre";
					
                    $sql = "insert into Dealer_inc (Cus_Code,CUS_NAME,month2,Month3,tyre_inc,limit1,target,target_bat,C_TYPE)  values ('" . $cuscode . "','" . $CUS_NAME . "','" . $month2 . "','" . $Month3 . "','" . $tyre_inc . "','" . $limit . "','" . $target . "','" . $target_bat . "','" . $C_TYPE . "') ";
					
                    $res = mysqli_query($GLOBALS['dbinv'], $sql);
                    if (!$res) {
                        echo mysqli_error($GLOBALS['dbinv']);
                    }
                }
				 
                $sql = "Select * from intper where incen_year = 20161 and traget < '" . $mpay_b . "' order by traget desc ";
				
                $result_rsper_b = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($rsper_b = mysqli_fetch_array($result_rsper_b)) {
                    $limit = 0;
                    $month1 = 0;
                    $month2 = 0;
                    $tyre_inc = 0;
                    $target = 0;
                    $target_bat = 0;
                    $month1 = $mpay_b;
                    $cuscode = $rsVENDOR["CODE"];
                    $CUS_NAME = $rsVENDOR['NAME'];
                    $bat_inc = $mpay_b * ($rsper_b['per'] / 100);
                    $Month3 = $bat_inc;
                    $battery_inc = $bat_inc;
                    $BATTERY = $mpay_b;
                    $sql = "select * from Ins_payment where  I_month='" . date("m", strtotime($_GET["DTPicker1"])) . "' and I_year ='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCODE = '" . $rsVENDOR["CODE"] . "' order by ID ";
                    $result_rsIncen = mysqli_query($GLOBALS['dbinv'], $sql);
                    while ($rsIncen = mysqli_fetch_array($result_rsIncen)) {

                        If (!Is_Null($rsIncen['Type'])) {
                            If ($rsIncen['Type'] == $_GET['cmbbrand']) {
                                $target = $rsIncen['amount'];
                            } Else {
                                $target_bat = $rsIncen['amount'];
                            }
                        } Else {
                            If ($bat_inc < 0) {
                                $target = $rsIncen['amount'];
                            }
                        }
                    }
                    $C_TYPE = "Battery";
                    $sql = "insert into Dealer_inc (Cus_Code,CUS_NAME,month1,month2,Month3,tyre_inc,limit1,target,target_bat,C_TYPE,battery_inc,BATTERY)  values ('" . $cuscode . "','" . $CUS_NAME . "','" . $month1 . "','" . $month2 . "','" . $Month3 . "','" . $tyre_inc . "','" . $limit . "','" . $target . "','" . $target_bat . "','" . $C_TYPE . "','" . $battery_inc . "','" . $BATTERY . "') ";
					 
                    $res = mysqli_query($GLOBALS['dbinv'], $sql);
                    if (!$res) {
                        echo mysqli_error($GLOBALS['dbinv']);
                    }
                }
            }
        }
    }

    $tb = "<table>";
    $tb .= "<tr><td>Code</td>";
    $tb .= "<td>Name</td>";
    $tb .= "<td>Effective Sale Green Tour</td>
    <td>Incentive</td><td>Type</td><td></td>
	<td>Sales Return After Sal.Month</td>
     						  <td>Dealer Remark</td>
							   <td>...</td>
	
	</tr>";

    $sql = "select * from Dealer_inc where (target+target_bat =0)";
    $result_rssslma = mysqli_query($GLOBALS['dbinv'], $sql);
	
    while ($row_rssslma = mysqli_fetch_array($result_rssslma)) {
        $chk = $row_rssslma['id'];
        $tb .= "<tr><td>" . $row_rssslma['Cus_Code'] . "</td>";
        $tb .= "<td>" . $row_rssslma['CUS_NAME'] . "</td>";
        $tb .= "<td>" . $row_rssslma['limit1'] . "</td>";
        
        $tb .= "<td>" . $row_rssslma['Month3'] . "</td><td>" . $row_rssslma['C_TYPE'] . "</td>";
        $tb .= "<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onClick=\"chk_ad('" . $chk . "','" . $row_rssslma['id'] . "');\"></td>";
				$mret = 0;	
							$sql = "SELECT sum(amount) as amount FROM view_cbal_bmas_crnma_salma WHERE cuscode = '" .  $row_rssslma['Cus_Code']  . "' and month(sdate) <>" . date("m", strtotime($_GET["DTPicker1"])) . " and month(sal_sdate)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(sal_sdate)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  AND trn_type = 'GRN' AND CANCELL = '0'";			
							if ($row_rssslma['C_TYPE'] =="TYRE") { 
							$sql .= " and b60='1'";
							} else {
							$sql .= " and b60='2'";	
							}
							//echo $sql;
							$result_rsincen = mysqli_query($GLOBALS['dbinv'],$sql);
							if ($row_rsincen = mysqli_fetch_array($result_rsincen)) {
								if (!is_null($row_rsincen['amount'])) {
									$mret = $row_rsincen['amount'];
								}
				
							}
							
							
 
							$tb .= "<td>" . $mret . "</td>";	
							 $sql = "select * from dealer_incen_rmk where d_code = '".  $row_rssslma['Cus_Code']  ."'";
    $result = mysqli_query($GLOBALS['dbinv'],$sql);
    $row = mysqli_fetch_array($result);
	$tb .= "<td><input type='text' id = '" . $row_rssslma['Cus_Code'] . "' value='" . $row["rmk"] . "'></td>";
	$tb .= "<td><a class='btn_purchase' onclick=\"updt('" . $row_rssslma['Cus_Code'] . "');\">..</a></td>"; 
	$tb .= "</tr>";
	}
	
    $tb .= "</table>";

    echo $tb;
}

if ($_GET['Command'] =="updt") {
	$sql = "delete from dealer_incen_rmk where d_code = '".$_GET["cuscode"]."'";
	 
	$result = mysqli_query($GLOBALS['dbinv'],$sql);
	
	$sql = "insert into dealer_incen_rmk (d_code,rmk) values ('" . $_GET['cuscode'] . "','" . $_GET['remark'] . "')";
	echo "Saved";
	$result = mysqli_query($GLOBALS['dbinv'],$sql);
	
	
}

if ($_GET["Command"] == "chk_ad") {
    require_once("connectioni.php");



    if ($_GET["chk_val"] == "true") {
        $rs = "update dealer_inc set print = '1' where id = '" . $_GET["cuscode"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $rs);
        //$row = mysqli_fetch_array($result)){
    } else {
        $rs = "update dealer_inc set print = '0' where id = '" . $_GET["cuscode"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $rs);
    }
    //echo $rs;
}
?>