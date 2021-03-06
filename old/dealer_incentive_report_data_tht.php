<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connectioni.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////

$MSHFlexGrid1 = array(array());
$MSHFlexGrid1_count = 0;
$gridchk = array(array());

if ($_GET["Command"] == "view1") {
    header('Content-Type: text/xml');

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $year = substr($_GET["DTPicker1"], 0, 4);
    $month = substr($_GET["DTPicker1"], 5, 2);

    $sql_rs = "select * from vatrate where month(sdate)<='" . trim($month) . "' and  year(sdate)<='" . trim($year) . "' order by sdate desc";
    $result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
    if ($row_rs = mysqli_fetch_array($result_rs)) {
        $txtvat_new = $row_rs['vatrate'];
        $txtvat = $row_rs['vatrate'];
        $txt_vat = $row_rs['vatrate'];
    }





    $sql = "delete from Dealer_inc";
    mysqli_query($GLOBALS['dbinv'], $sql);



    $sql = "Select c_code,b60,sum(grand_tot) as sale,sum(grand_tot-totpay) as out1,sum(GRAND_TOT/(1+(gst/100))) as totsal1 from  VIEW_S_SALMA_BRAND_MAS where month(SDATE) =" . $month . " and   year(SDATE) =" . $year . "  and cancell = '0' and b60 <> '0'  group by c_code,b60 order by c_code,b60 ";

    $result_rssales = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($rssales = mysqli_fetch_array($result_rssales)) {

        $Out = "No";
        $out_b = "No";
        $out_a = "No";
        $GO = "No";
        $ccode = "";




        If ($rssales['b60'] == 1) {
            If ($rssales['out1'] < 50) {
                $Out = "Ok";
            }
            $sqlp = "Select * from intper where incen_year = '2014' order by traget";
            $result_rsper = mysqli_query($GLOBALS['dbinv'], $sqlp);
            $rs_per = mysqli_fetch_array($result_rsper);
            If ($rssales['sale'] > $rs_per['traget'] And $Out == "Ok") {
                $GO = "Ok";
            }
        } else {
            If ($rssales['b60'] == 2) {

                $sql = "select * from dealer_inc where cus_code = '" . $rssales['C_CODE'] . "' and c_type = 'Battery'";
                $result_rsssb = mysqli_query($GLOBALS['dbinv'], $sql);
                $numr = mysqli_num_rows($result_rsssb);
                if ($numr == 0) {
                    If ($rssales['out1'] < 50) {
                        $out_b = "Ok";
                    }
                    $ccode = Trim($rssales['C_CODE']);
                    $tar = $rssales['sale'];


                    $sql = "Select c_code,b60,sum(grand_tot) as sale,sum(grand_tot-totpay) as out1 from  VIEW_S_SALMA_BRAND_MAS where month(SDATE) =" . $month . " and   year(SDATE) =" . $year . "  and cancell = '0' and d60to75 <> '0' and c_code = '" . $rssales['C_CODE'] . "' and b60='2' and b60 <> '" . $rssales['b60'] . "' group by c_code,b60 order by c_code,b60 ";
                    $result_rsss = mysqli_query($GLOBALS['dbinv'], $sql);
                    while ($rowb = mysqli_fetch_array($result_rsss)) {

                        if ($rowb['b60'] == 2) {
                            $ii = 1;
                            If ($rowb['out1'] < 50 And $out_b == "Ok") {
                                $out_b = "Ok";
                            } Else {
                                $out_b = "No";
                            }
                            $tar = $tar + $rowb['sale'];
                        }
                    }
                }
            }
            $sql = "Select * from intper where incen_year = '20111' order by traget";
            $result_rsper = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs_per = mysqli_fetch_array($result_rsper);
            If ($tar > $rs_per['traget'] And $out_b == "Ok") {
                $GO = "Ok";
            }
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

            If ($rssales['b60'] == 1) {
                $sqlr1 = "Select vatrate, sum(amount) as rtn from  View_cbal_brand where cuscode = '" . $rssales['C_CODE'] . "' and month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and cancell = '0' and d60to75 = '1' AND trn_type <> 'ARN' and trn_type <> 'REC' and trn_type <> 'DGRN' and flag1 <> '1' group by vatrate ";
            }
            If ($rssales['b60'] == 1) {
                $sqlsalma = "Select * from VIEW_salma_sttr_brand where c_code = '" . $rssales['C_CODE'] . "' and d60to75 = '1' and cancell = '0' and month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and deliin_amo <= '0' and deliin_lock = '0' and totpay1 = '1' order by st_refno";
            }
            $ret = 0;
            If ($rssales['b60'] == 1) {
                $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sqlr1);
                while ($rs1 = mysqli_fetch_array($result_rs1)) {
                    $ret = $ret + ($rs1['rtn'] / (1 + ($rs1['vatrate'] / 100)));
                }
            }

            If ($rssales['b60'] == 2) {
                $sqlr1 = "Select vatrate, sum(amount) as rtn from  View_cbal_brand where cuscode = '" . $rssales['C_CODE'] . "' and month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and cancell = '0' and b60 = '2' AND trn_type <> 'ARN' and trn_type <> 'REC' and trn_type <> 'DGRN' and flag1 <> '1' group by vatrate ";
            }
            If ($rssales['b60'] == 2) {
                $sqlsalma = "Select * from VIEW_salma_sttr_brand where c_code = '" . $rssales['C_CODE'] . "' and b60 = '2' and cancell = '0' and month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and deliin_amo <= '0' and deliin_lock = '0' and totpay1 = '1' order by st_date";
            }
            $ret_b = 0;
            If ($rssales['b60'] == 2) {
                $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sqlr1);
                while ($rs1 = mysqli_fetch_array($result_rs1)) {
                    $ret_b = $ret_b + ($rs1['rtn'] / (1 + ($rs1['vatrate'] / 100)));
                }
            }

            $sqlv = "Select * from vendor where code = '" . $rssales['C_CODE'] . "'";
            $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sqlv);
            $rsVENDOR = mysqli_fetch_array($result_rsVENDOR);

            $result_rssalma = mysqli_query($GLOBALS['dbinv'], $sqlsalma);
            while ($rssalma = mysqli_fetch_array($result_rssalma)) {
                $a = $rssalma['ST_REFNO'];
                If ($rssales['b60'] == 1 And $Out == "Ok") {
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

                    If ($rsVENDOR['incdays'] > 75) {
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

                        If ($rssalma['cre_pe'] > 75) {
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
                            If ($mdays <= 75 And $mdays > 50) {
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
                } else {

                    If ($rssales['b60'] == 2 And $out_b == "Ok") {

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

                        If ($rsVENDOR['incdays'] > 75) {
                            If ($rssalma['cre_pe'] > $rsVENDOR['incdays']) {
                                If ($rssalma['cre_pe'] >= $mdays) {
                                    $mpay_b = $mpay_b + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                }
                            } Else {
                                If ($rsVENDOR['incdays'] >= $mdays) {
                                    $mpay_b = $mpay_b + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                                }
                            }
                        } Else {
                            If ($mdays <= 75) {
                                $mpay_b = $mpay_b + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
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


                $sql = "Select * from intper where traget <= '" . ($mpay + $mpay_50) . "' and incen_year = '2014' order by traget desc";
                $sql_50 = "Select * from intper where traget <= '" . ($mpay + $mpay_50) . "' and incen_year = '20141' order by traget desc";

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

                            If (trim($rsIncen['Type']) == "Tyre") {

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
                    $C_TYPE = "Tyre";

                    $sql = "insert into Dealer_inc (Cus_Code,CUS_NAME,month2,Month3,tyre_inc,limit1,target,target_bat,C_TYPE)  values ('" . $cuscode . "','" . $CUS_NAME . "','" . $month2 . "','" . $Month3 . "','" . $tyre_inc . "','" . $limit . "','" . $target . "','" . $target_bat . "','" . $C_TYPE . "') ";

                    $res = mysqli_query($GLOBALS['dbinv'], $sql);
                    if (!$res) {
                        echo mysqli_error($GLOBALS['dbinv']);
                    }
                }

                $sql = "Select * from intper where incen_year = 20111 and traget < '" . $mpay_b . "' order by traget desc ";

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
                            If ($rsIncen['Type'] == "Tyre") {
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
    $tb .= "<td>Effective Sale Tyre</td>";
    $tb .= "<td>Effective Sale Volta</td>";
    $tb .= "<td>Effective Sale Atlasbx</td><td>Incentive</td><td>Type</td><td></td>
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
        $tb .= "<td>" . $row_rssslma['BATTERY'] . "</td>";
        $tb .= "<td>0</td>";
        $tb .= "<td>" . $row_rssslma['Month3'] . "</td><td>" . $row_rssslma['C_TYPE'] . "</td>";
        $tb .= "<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onClick=\"chk_ad('" . $chk . "','" . $row_rssslma['id'] . "');\"></td>";
        $mret = 0;
        $sql = "SELECT sum(amount) as amount FROM view_cbal_bmas_crnma_salma WHERE cuscode = '" . $row_rssslma['Cus_Code'] . "' and month(sdate) <>" . date("m", strtotime($_GET["DTPicker1"])) . " and month(sal_sdate)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(sal_sdate)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  AND trn_type = 'GRN' AND CANCELL = '0'";
        if ($row_rssslma['C_TYPE'] == "TYRE") {
            $sql .= " and b60='1'";
        } else {
            $sql .= " and b60='2'";
        }
        //echo $sql;
        $result_rsincen = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row_rsincen = mysqli_fetch_array($result_rsincen)) {
            if (!is_null($row_rsincen['amount'])) {
                $mret = $row_rsincen['amount'];
            }
        }



        $tb .= "<td>" . $mret . "</td>";
        $sql = "select * from dealer_incen_rmk where d_code = '" . $row_rssslma['Cus_Code'] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $tb .= "<td><input type='text' id = '" . $row_rssslma['Cus_Code'] . "' value='" . $row["rmk"] . "'></td>";
        $tb .= "<td><a class='btn_purchase' onclick=\"updt('" . $row_rssslma['Cus_Code'] . "');\">..</a></td>";
        $tb .= "</tr>";
    }

    $tb .= "</table>";

    echo $tb;
}


if ($_GET["Command"] == "view") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $year = substr($_GET["DTPicker1"], 0, 4);
    $month = substr($_GET["DTPicker1"], 5, 2);






    $sql = "delete from Dealer_inc";
    mysqli_query($GLOBALS['dbinv'], $sql);

    $dtfrom = $year . "-" . $month . "-01";
    $dtto = date("Y-m-t", strtotime($_GET["DTPicker1"]));


    $sql = "Select c_code,sum(grand_tot) as sale,sum(grand_tot-totpay) as out1,sum(GRAND_TOT/(1+(gst/100))) as totsal1 from  view_s_salma_brand_mas_incentive where  month(sdate1) =" . $month . " and   year(sdate1) =" . $year . "  and cancell = '0' and sfrom <='" . $dtfrom . "' and sto >='" . $dtfrom . "' and inc_type='" . $_GET['cmbtype'] . "' group by c_code order by c_code ";

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
        $sqlp = "Select * from intper where sdate <= '" . $_GET["DTPicker1"] . "' and traget <= " . $rssales["totsal1"] . "  and class='" . $_GET['cmbtype'] . "' order by sdate desc,traget desc ";

        $result_rsper = mysqli_query($GLOBALS['dbinv'], $sqlp);
        $rs_per = mysqli_fetch_array($result_rsper);
        If ($Out == "Ok") {
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


            $sqlr1 = "Select vatrate, sum(amount) as rtn from  view_cbal_brand_incentive where  cuscode = '" . $rssales['C_CODE'] . "'  and inc_type='" . $_GET['cmbtype'] . "' and month(sdate1) =" . $month . " and   year(sdate1) =" . $year . " and cancell = '0' and sfrom <='" . $dtfrom . "' and sto >='" . $dtfrom . "' AND trn_type <> 'ARN' and trn_type <> 'REC' and trn_type <> 'DGRN' and flag1 <> '1' group by vatrate ";

            $sqlsalma = "Select * from VIEW_salma_sttr_brand_incentive where c_code = '" . $rssales['C_CODE'] . "'  and inc_type='" . $_GET['cmbtype'] . "' and sfrom <='" . $dtfrom . "' and sto >='" . $dtfrom . "' and cancell = '0' and month(sdate1) =" . $month . " and   year(sdate1) =" . $year . " and deliin_amo <= '0' and deliin_lock = '0' and totpay1 = '1' order by st_refno";

            $ret = 0;

            $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sqlr1);
            while ($rs1 = mysqli_fetch_array($result_rs1)) {
                $ret = $ret + ($rs1['rtn'] / (1 + ($rs1['vatrate'] / 100)));
            }


            $sqlv = "Select * from vendor where code = '" . $rssales['C_CODE'] . "'";
            $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sqlv);
            $rsVENDOR = mysqli_fetch_array($result_rsVENDOR);

            $result_rssalma = mysqli_query($GLOBALS['dbinv'], $sqlsalma);
            while ($rssalma = mysqli_fetch_array($result_rssalma)) {
                $a = $rssalma['ST_REFNO'];
                If ($Out == "Ok") {
                    if ((!is_null($rssalma['deli_date'])) and $rssalma['deli_date'] != "0000-00-00") {
                        $sdate = $rssalma['deli_date'];
                    } else {
                        $sdate = $rssalma['sdate1'];
                    }

                    if ((!is_null($rssalma['st_chdate'])) and $rssalma['st_chdate'] != "0000-00-00") {
                        $stdate = $rssalma['st_chdate'];
                    } else {
                        $stdate = $rssalma['ST_DATE'];
                    }

                    $diff = abs(strtotime($stdate) - strtotime($sdate));
                    $days = floor($diff / (60 * 60 * 24));
                    $mdays = $days;

                    // If ($rsVENDOR['incdays'] > 75) {
                        // If ($rssalma['cre_pe'] > $rsVENDOR['incdays']) {
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
                        // } else {
                        //     $incdays = intval($rsVENDOR['incdays']);
                        //     If (($incdays >= $mdays) And ( $mdays > 50)) {
                        //         $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                        //         $cnt = $cnt + 1;
                        //     } else {
                        //         If ($mdays <= 50) {
                        //             If ($rssalma['ST_FLAG'] == "UT") {
                        //                 $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                        //             } else {
                        //                 $mpay_50 = $mpay_50 + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                        //             }
                        //         }
                        //     }
                        // }
                    // } else {
                    //     If ($rssalma['cre_pe'] > 75) {
                    //         If ($rssalma['cre_pe'] >= $mdays And $mdays > 50) {
                    //             $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                    //             $cnt = $cnt + 1;
                    //         } Else {
                    //             If ($mdays <= 50) {
                    //                 If ($rssalma['ST_FLAG'] == "UT") {
                    //                     $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                    //                 } else {
                    //                     $mpay_50 = $mpay_50 + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                    //                 }
                    //             }
                    //         }
                    //     } else {
                    //         If ($mdays <= 75 And $mdays > 50) {
                    //             $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                    //             $cnt = $cnt + 1;
                    //         } Else {
                    //             If ($mdays <= 50) {
                    //                 If ($rssalma['ST_FLAG'] == "UT") {
                    //                     $mpay = $mpay + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                    //                 } Else {
                    //                     $mpay_50 = $mpay_50 + ($rssalma['ST_PAID'] / (1 + ($rssalma['GST'] / 100)));
                    //                 }
                    //             }
                    //         }
                    //     }
                    // }

                    
                }
            }


            If ($mpay > 0 Or $mpay_50 > 0) {

                If ($mpay > 0) {
                    $mpay = $mpay - $ret;
                } Else {
                    $mpay_50 = $mpay_50 - $ret;
                }


                $sql = "Select * from intper where sdate <= '" . $_GET["DTPicker1"] . "' and traget  <= '" . ($mpay + $mpay_50) . "'  and class='" . $_GET['cmbtype'] . "' order by sdate desc,traget desc ";
                //echo $sql; 
                $result_rsper = mysqli_query($GLOBALS['dbinv'], $sql);


                $rsper = mysqli_fetch_array($result_rsper);
                If ($rsper) {

                    $cuscode = $rsVENDOR["CODE"];
                    $CUS_NAME = $rsVENDOR['NAME'];
                    $month2 = $ret;

                    If ($cnt > 0) {
                        $tyre_inc = ($mpay * (($rsper['per'] / 100))) + ($mpay_50 * (($rsper['per'] + $rsper['add']) / 100));
                    } Else {
                        $tyre_inc = ($mpay * (($rsper['per'] + $rsper['add']) / 100)) + ($mpay_50 * (($rsper['per'] + $rsper['add']) / 100));
                    }

                    $Month3 = $tyre_inc;
                    $tyre_inc = $tyre_inc;
                    $target = 0;
                    $target_bat = 0;
                    $limit = $mpay + $mpay_50;
                    $sql = "select * from Ins_payment where  I_month='" . date("m", strtotime($_GET["DTPicker1"])) . "' and I_year ='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCODE = '" . $rsVENDOR["CODE"] . "' and type = '" . $_GET['cmbtype'] . "' order by ID ";

                    $result_rsIncen = mysqli_query($GLOBALS['dbinv'], $sql);
                    while ($rsIncen = mysqli_fetch_array($result_rsIncen)) {

                        If (!Is_Null($rsIncen['Type'])) {

                            If (trim($rsIncen['Type']) == "Tyre") {

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
                    $C_TYPE = $_GET['cmbtype'];

                    $sql = "insert into Dealer_inc (Cus_Code,CUS_NAME,month2,Month3,tyre_inc,limit1,target,target_bat,C_TYPE)  values ('" . $cuscode . "','" . $CUS_NAME . "','" . $month2 . "','" . $Month3 . "','" . $tyre_inc . "','" . $limit . "','" . $target . "','" . $target_bat . "','" . $C_TYPE . "') ";

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
    $tb .= "<td>Effective Sale Tyre</td>";
    $tb .= "<td>Effective Sale Volta</td>";
    $tb .= "<td>Effective Sale Atlasbx</td><td>Incentive</td><td>Type</td><td></td>
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
        $tb .= "<td>" . $row_rssslma['BATTERY'] . "</td>";
        $tb .= "<td>0</td>";
        $tb .= "<td>" . $row_rssslma['Month3'] . "</td><td>" . $row_rssslma['C_TYPE'] . "</td>";
        $tb .= "<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onClick=\"chk_ad('" . $chk . "','" . $row_rssslma['id'] . "');\"></td>";
        $mret = 0;
        $sql = "SELECT sum(amount) as amount FROM view_cbal_bmas_crnma_salma WHERE cuscode = '" . $row_rssslma['Cus_Code'] . "' and month(sdate1) <>" . date("m", strtotime($_GET["DTPicker1"])) . " and month(sal_sdate1)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(sal_sdate1)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  AND trn_type = 'GRN' AND CANCELL = '0'";
        if ($row_rssslma['C_TYPE'] == "TYRE") {
            $sql .= " and b60='1'";
        } else {
            $sql .= " and b60='2'";
        }
        //echo $sql;
        $result_rsincen = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row_rsincen = mysqli_fetch_array($result_rsincen)) {
            if (!is_null($row_rsincen['amount'])) {
                $mret = $row_rsincen['amount'];
            }
        }



        $tb .= "<td>" . $mret . "</td>";
        $sql = "select * from dealer_incen_rmk where d_code = '" . $row_rssslma['Cus_Code'] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $tb .= "<td><input type='text' id = '" . $row_rssslma['Cus_Code'] . "' value='" . $row["rmk"] . "'></td>";
        $tb .= "<td><a class='btn_purchase' onclick=\"updt('" . $row_rssslma['Cus_Code'] . "');\">..</a></td>";
        $tb .= "</tr>";
    }

    $tb .= "</table>";

    echo $tb;
}




if ($_GET['Command'] == "updt") {
    $sql = "delete from dealer_incen_rmk where d_code = '" . $_GET["cuscode"] . "'";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql = "insert into dealer_incen_rmk (d_code,rmk) values ('" . $_GET['cuscode'] . "','" . $_GET['remark'] . "')";
    echo "Saved";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
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