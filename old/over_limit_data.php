<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connectioni.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////

date_default_timezone_set('Asia/Colombo');
header('Content-Type: text/xml');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "view_from") {

    if ($_SESSION["dev"] == "") {
        exit("no");
    }

    $GLOBALS['bdb'] = 'swijesooriya_ben';
    $GLOBALS['dbben'] = mysqli_connect($GLOBALS['hostname'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['bdb']);


    $myg = array();
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<sales_table><![CDATA[ <table>
	<tr>
      <td colspan=9 background=\"\" ><font color=\"#FFFFFF\">Order Details</font></td>
	  <td colspan=3 background=\"\" ><font color=\"#FFFFFF\">IF</font></td>
	  <td colspan=2 background=\"\" ><font color=\"#FFFFFF\">L3M</font></td>
	  <td colspan=2 background=\"\" ><font color=\"#FFFFFF\">N3M</font></td>
	  <td background=\"\" ><font color=\"#FFFFFF\">BEN L3M</font></td>
	  <td background=\"\" ><font color=\"#FFFFFF\">BEN N3M</font></td>
																		
         <tr>
                <td><b>Code</b></td>
               <td><b>Name</b></td>
               <td><b>Limit</b></td>
               <td><b>Outstanding</b></td>
               <td><b>Ret Chq</b></td>
               <td><b>Ret Chq - BEN</b></td>
               <td><b>Order Val</b></td>
                <td><b>Ex Limit</b></td>
               <td><b></b></td>
               <td><b>PD for Rtn</b></td>
               <td><b>Over 75</b></td>
               <td><b></b></td>
                <td><b>Settlement</b></td>
                <td><b>Ret Chq</b></td>
                <td><b>Settlement</b></td>
                <td><b></b></td>
                <td><b>Settlements</b></td>
                <td><b>To Settle</b></td>
                <td><b>Type</b></td>
				<td><b>&nbsp;</b></td>
				<td><b>Remark</b></td>
				<td><b>&nbsp;</b></td>
                </tr>";

    //$sql=  "Select C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from view_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND Limit_need > '0' and Forward = 'MM'  Group by  C_CODE,NAME,SAL_EX,class order by C_CODE";

    if ((strtolower($_SESSION["CURRENT_USER"]) == "rohan") or ( strtolower($_SESSION["CURRENT_USER"]) == "rohan1")) {
        $sql = "Select REF_NO, C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from view_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND  Forward = 'WD' and Result = 'P' ";
    } else {
        if (strtolower($_SESSION["CURRENT_USER"]) == "md") {
            $sql = "Select REF_NO, C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from view_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND  Forward = 'MD' and Result = 'P' ";
        } else {
            if ((strtolower($_SESSION["CURRENT_USER"]) == "errol") or ( strtolower($_SESSION["CURRENT_USER"]) == "errol1")) {
                //$sql=  "Select C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from view_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND Limit_need > '0' and Forward = 'MM' and approveby = '0' and rgroup = 'B1'  Group by  C_CODE,NAME,SAL_EX,class order by C_CODE";

                $sql = "Select REF_NO, C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from view_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND Limit_need > '0' and Forward = 'MM' and Result='P' and approveby = '0' ";
            } else {

                $sql = "Select REF_NO, C_CODE,NAME,SAL_EX,class,sum(GRAND_TOT) as amount from view_repord_brand_btr where INVNO = '0' and CANCELL = '0' AND Limit_need > '0' and Forward = 'MM' and Result='P'  ";
            }
        }
    }
    if (isset($_GET['rep'])) {
        if ($_GET['rep'] != "All") {
            $sql .= " and sal_ex = '" . $_GET['rep'] . "'";
        }
    }
    if (isset($_GET['brand'])) {
        if ($_GET['brand'] != "All") {
            $sql .= " and class = '" . $_GET['brand'] . "'";
        }
    }

    $sql .= " Group by  C_CODE,NAME,SAL_EX,class order by C_CODE";

    $i = 1;

    if ($_SESSION['company'] == "THT") {
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    } else if ($_SESSION['company'] == "BEN") {
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    }

    while ($row = mysqli_fetch_array($result)) {

        $ord_no = $row["REF_NO"];

        $myg[1] = "";
        $myg[2] = "";
        $myg[3] = 0;
        $myg[4] = 0;
        $myg[5] = 0;
        $myg[6] = 0;
        $myg[7] = 0;
        $myg[8] = 0;
        $myg[9] = "";
        $myg[10] = 0;
        $myg[11] = 0;
        $myg[12] = 0;
        $myg[13] = 0;
        $myg[14] = 0;
        $myg[15] = 0;
        $myg[16] = 0;
        $myg[17] = 0;
        $myg[18] = 0;
        $myg[19] = "";
        $myg[20] = "---";
        $myg[21] = "";

        $limit = 0;
        $out = 0;
        $rtn_ch = 0;
        $rtn_ch_n = 0;
        $chq_re = 0;
        $ca_re = 0;
        $Ch_pen = 0;
        $out_pen = 0;

        $myg[1] = $row["C_CODE"];
        $myg[2] = $row["NAME"];
        $myg[3] = 0;

        $rs3 = "Select CAT,credit_lim, brand from br_trn where cus_code='" . $row["C_CODE"] . "' and Rep = '" . $row["SAL_EX"] . "'  and brand = '" . $row["class"] . "' and credit_lim != 0 ";
        //echo "2-".$rs3;
        if ($_SESSION['company'] == "THT") {
            $result3 = mysqli_query($GLOBALS['dbinv'], $rs3);
        } else if ($_SESSION['company'] == "BEN") {
            $result3 = mysqli_query($GLOBALS['dbinv'], $rs3);
        }

        if ($row3 = mysqli_fetch_array($result3)) {

            if (is_null($row3["CAT"]) == false) {
                if (trim($row3["CAT"]) == "A") {
                    $limit = $row3["credit_lim"] * 2.5;
                }
                if (trim($row3["CAT"]) == "B") {
                    $limit = $row3["credit_lim"] * 2.5;
                }
                if (trim($row3["CAT"]) == "C") {
                    $limit = $row3["credit_lim"] * 1;
                }

                $myg[3] = $limit;
            } else {

                $myg[3] = 0;
            }
        }

        $findref = "SELECT * From ref_history WHERE  (NewRefNo = '" . $row["SAL_EX"] . "')";
        $OldRefno = "";
        $NewRefNo = "";

        if ($_SESSION['company'] == "THT") {
            $result_findref = mysqli_query($GLOBALS['dbinv'], $findref);
        } else if ($_SESSION['company'] == "BEN") {
            $result_findref = mysqli_query($GLOBALS['dbinv'], $findref);
        }

        if ($row_findref = mysqli_fetch_array($result_findref)) {

            $OldRefno = $row_findref["OldRefno"];
            $NewRefNo = $row_findref["NewRefNo"];
        }

        //=========================================================
        if ($row["SAL_EX"] == $NewRefNo) {
            $rs0 = "Select sum(GRAND_TOT - TOTPAY) as out1 from view_s_salma  where class='" . $row["class"] . "' and GRAND_TOT > TOTPAY and CANCELL='0' and C_CODE='" . $row["C_CODE"] . "' and (SAL_EX = '" . $row["SAL_EX"] . "' or SAL_EX = '" . $OldRefno . "')";
            //echo "3-".$rs0;
        } else {
            $rs0 = "Select sum(GRAND_TOT - TOTPAY) as out1 from view_s_salma  where class='" . $row["class"] . "' and GRAND_TOT > TOTPAY and CANCELL='0' and C_CODE='" . $row["C_CODE"] . "' and SAL_EX = '" . $row["SAL_EX"] . "'  ";
            //	echo "4-".$rs0;
        }


        if ($_SESSION['company'] == "THT") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        } else if ($_SESSION['company'] == "BEN") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        }

        if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
            if (is_null($row_rs0["out1"]) == false) {
                $out = $row_rs0["out1"];
            }
            $myg[4] = $out;
        }

        if ($row["SAL_EX"] == $NewRefNo) {
            $rs0 = "Select sum(ST_PAID) as out1 from view_sinvcheq_sttr_salma1  where che_date >  '" . $_GET["dtfrom"] . "' and C_CODE='" . $row["C_CODE"] . "' and (sal_ex = '" . $row["SAL_EX"] . "' or sal_ex = '" . $OldRefno . "') and class = '" . $row["class"] . "'  ";
        } else {
            $rs0 = "Select sum(ST_PAID) as out1 from view_sinvcheq_sttr_salma1  where che_date >  '" . $_GET["dtfrom"] . "' and C_CODE='" . $row["C_CODE"] . "' and SAL_EX = '" . $row["SAL_EX"] . "' and class = '" . $row["class"] . "'  ";
        }
        //echo $rs0;

        if ($_SESSION['company'] == "THT") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        } else if ($_SESSION['company'] == "BEN") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        }

        if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
            if (is_null($row_rs0["out1"]) == false) {
                $out = $out + $row_rs0["out1"];
            }
            $myg[4] = $out;
        }

        $rs0 = "Select sum(CR_CHEVAL-paid) as out1 from s_cheq  where  CR_CHEVAL > PAID  and CR_C_CODE='" . $row["C_CODE"] . "' and CR_FLAG != 'c'  ";
        //echo "7-".$rs0;
        if ($_SESSION['company'] == "THT") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        } else if ($_SESSION['company'] == "BEN") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        }
        if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
            if (is_null($row_rs0["out1"]) == false) {
                $rtn_ch = $row_rs0["out1"];
            }
            $myg[5] = $rtn_ch;
        }

        //------------------------------------------------------BPL Return Chq-------------------------------------------------------------



        $sql_ven = "Select commoncode from vendor where CODE = '" . $row["C_CODE"] . "' ";
        $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_ven);

        if ($row_rsven = mysqli_fetch_array($result_rsven)) {

            if ($row_rsven["commoncode"] != "0") {

                $sql_chq = "Select sum(CR_CHEVAL-PAID) as out1 from s_cheq  where  CR_CHEVAL > PAID  and CR_C_CODE='" . trim($row_rsven["commoncode"]) . "' and CR_FLAG != 'c'  ";

                $result_rs0 = mysqli_query($GLOBALS['dbben'], $sql_chq);

                if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
                    if (is_null($row_rs0["out1"]) == false) {
                        $rtn_ch_n = $row_rs0["out1"];
                    }
                    $myg[6] = $rtn_ch_n;
                }
            }
        }



        $myg[7] = $row["amount"];

        $rs0 = "Select sum(che_amount) as out1 from s_invcheq where  che_date > '" . $_GET["dtfrom"] . "'   and cus_code='" . $row["C_CODE"] . "' and trn_type = 'RET'  ";
        //echo "10-".$rs0;
        if ($_SESSION['company'] == "THT") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        } else if ($_SESSION['company'] == "BEN") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        }

        if ($row_rs0 = mysqli_fetch_array($result_rs0)) {

            if (is_null($row_rs0["out1"]) == false) {
                $out = $out + $row_rs0["out1"];
            }
            $myg[4] = $out;
            if (is_null($row_rs0["out1"]) == false) {
                $myg[10] = $row_rs0["out1"];
            }
        }

        // echo $limit." / ".$out." / ".$rtn_ch." / ".$row["amount"];
        $myg[8] = $limit - $out - $rtn_ch - $row["amount"];

        //.........................Ovr 75.............
        $adddate = date('Y-m-d', strtotime("-75 days"));

        $rs0 = "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where  GRAND_TOT > TOTPAY and sdate <='" . $adddate . "'  and C_CODE='" . $row["C_CODE"] . "' and CANCELL = '0'  ";
        //echo "11-".$rs0;

        if ($_SESSION['company'] == "THT") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        } else if ($_SESSION['company'] == "BEN") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        }

        if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
            if (is_null($row_rs0["out1"]) == false) {

                $myg[11] = $row_rs0["out1"];
            }
        }

        //.........................90 days selltle history..................

        $adddate = date('Y-m-d', strtotime("-97 days"));
        $adddate1 = date('Y-m-d', strtotime("-7 days"));

        $rs0 = "SELECT sum(che_amount) as reatot from view_s_invcheq where cus_code='" . $row["C_CODE"] . "'  and ( che_date>'" . $adddate . "' or che_date ='" . $adddate . "')  and ( che_date<'" . $adddate1 . "' or che_date ='" . $adddate1 . "') and trn_type <> 'RET' ";
        // echo "12-".$rs0;
        if ($_SESSION['company'] == "THT") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        } else if ($_SESSION['company'] == "BEN") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        }

        if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
            if (is_null($row_rs0["reatot"]) == false) {
                $chq_re = $row_rs0["reatot"];
            }
        }

        $adddate = date('Y-m-d', strtotime("-90 days"));
        $rs0 = "select sum(CA_CASSH) as ca_reatot from s_crec where CA_CODE = '" . $row["C_CODE"] . "' and ( CA_DATE>'" . $adddate . "' or CA_DATE ='" . $adddate . "')  and ( CA_DATE<'" . date("Y-m-d") . "' or CA_DATE ='" . date("Y-m-d") . "') and CANCELL = '0' and FLAG = 'REC' ";
        //echo  "13-".$rs0;
        if ($_SESSION['company'] == "THT") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        } else if ($_SESSION['company'] == "BEN") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        }

        if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
            if (is_null($row_rs0["ca_reatot"]) == false) {
                $ca_re = $row_rs0["ca_reatot"];
            }
        }

        $myg[13] = $chq_re + $ca_re;

        //.........................90 days void cheque.......................

        $adddate = date('Y-m-d', strtotime("-90 days"));
        $rs0 = "SELECT sum(CR_CHEVAL) as out1 from s_cheq where  (CR_DATE>'" . $adddate . "'or CR_DATE='" . $adddate . "')and (CR_DATE<'" . date("Y-m-d") . "'or CR_DATE='" . date("Y-m-d") . "') and CR_C_CODE = '" . $row["C_CODE"] . "' and CR_FLAG='0' ";
        // echo "14-".$rs0;
        if ($_SESSION['company'] == "THT") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        } else if ($_SESSION['company'] == "BEN") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        }

        if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
            if (is_null($row_rs0["out1"]) == false) {
                $myg[14] = $row_rs0["out1"];
            }
        }

        //.........................90 days void cheque settle.................
        $rs0 = "SELECT sum(che_amount) as out1 from view_s_invcheq where ch_count_ret='0' and cus_code='" . $row["C_CODE"] . "'  and ( che_date>'" . date("Y-m-d") . "' or che_date ='" . date("Y-m-d") . "') ";
        // echo "15-".$rs0;
        if ($_SESSION['company'] == "THT") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        } else if ($_SESSION['company'] == "BEN") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        }

        if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
            if (is_null($row_rs0["out1"]) == false) {
                $Ch_pen = $row_rs0["out1"];
            }
        }

        $rs0 = "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE='" . $row["C_CODE"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 ";
        // echo "16-".$rs0;
        if ($_SESSION['company'] == "THT") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        } else if ($_SESSION['company'] == "BEN") {
            $result_rs0 = mysqli_query($GLOBALS['dbinv'], $rs0);
        }

        if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
            if (is_null($row_rs0["out1"]) == false) {
                $out_pen = $row_rs0["out1"];
            }
        }

        $myg[15] = $Ch_pen + $out_pen;

        //...................SISTER COMPANY.................................
        ///////////////// Start of THT //////////////////////////////////////////////



        $chq_re = 0;
        $ca_re = 0;
        $Ch_pen = 0;
        $out_pen = 0;
        $rsven = "Select commoncode from vendor where CODE = '" . $row["C_CODE"] . "'";
        $result_rsven = mysqli_query($GLOBALS['dbinv'], $rsven);

        if ($row_rsven = mysqli_fetch_array($result_rsven)) {

            if (trim($row_rsven["commoncode"]) != "0") {
                //.........................90 days selltle history..................

                $adddate = date('Y-m-d', strtotime("-97 days"));
                $adddate1 = date('Y-m-d', strtotime("-7 days"));

                $rs0 = "SELECT sum(che_amount) as reatot from view_s_invcheq where cus_code='" . trim($row_rsven["commoncode"]) . "'  and ( che_date>'" . $adddate . "' or che_date ='" . $adddate . "')  and ( che_date<'" . $adddate1 . "' or che_date ='" . $adddate1 . "') and trn_type <> 'RET' ";
                $result_rs0 = mysqli_query($GLOBALS['dbben'], $rs0);

                if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
                    if (is_null($row_rs0["reatot"]) == false) {
                        $chq_re = $row_rs0["reatot"];
                    }
                }

                $adddate = date('Y-m-d', strtotime("-90 days"));

                $rs0 = "select sum(CA_CASSH) as ca_reatot from s_crec where CA_CODE = '" . trim($row_rsven["commoncode"]) . "' and ( CA_DATE>'" . $adddate . "' or CA_DATE ='" . $adddate . "')  and ( CA_DATE<'" . date('Y-m-d') . "' or CA_DATE ='" . date('Y-m-d') . "') and CANCELL = '0' and FLAG = 'REC' ";
                $result_rs0 = mysqli_query($GLOBALS['dbben'], $rs0);

                if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
                    if (is_null($row_rs0["ca_reatot"]) == false) {
                        $ca_re = $row_rs0["ca_reatot"];
                    }
                }

                $myg[17] = $chq_re + $ca_re;

                //.........................90 days void cheque.......................
                //.........................90 days void cheque settle.................
                $rs0 = "SELECT sum(che_amount) as out1 from view_s_invcheq where ch_count_ret='0' and cus_code='" . trim($row_rsven["commoncode"]) . "'  and ( che_date>'" . date('Y-m-d') . "' or che_date ='" . date('Y-m-d') . "') ";
                $result_rs0 = mysqli_query($GLOBALS['dbben'], $rs0);

                if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
                    if (is_null($row_rs0["out1"]) == false) {
                        $Ch_pen = $row_rs0["out1"];
                    }
                }

                $rs0 = "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE='" . trim($row_rsven["commoncode"]) . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 ";
                $result_rs0 = mysqli_query($GLOBALS['dbben'], $rs0);

                if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
                    if (is_null($row_rs0["out1"]) == false) {
                        $out_pen = $row_rs0["out1"];
                    }
                }

                $myg[18] = $Ch_pen + $out_pen;
            }
        }

        ///////////////// End of THT //////////////////////////////////////////////
        //................ END SISTER COMPANY .................................................
        $myg[19] = $row["class"];
        $myg[21] = $row["SAL_EX"];

        //echo $myg[8]."/".$myg[11]."/".$myg[5];
        if ((($myg[8] <= 0) or ( $myg[11] != "0") or ( $myg[5] > 0)) or ( ($myg[8] > 0) or ( $myg[11] != "0") or ( $myg[5] > 0))) {

            $myg01 = "myg" . $i . "_01";
            $myg02 = "myg" . $i . "_02";
            $myg03 = "myg" . $i . "_03";
            $myg04 = "myg" . $i . "_04";
            $myg05 = "myg" . $i . "_05";
            $myg06 = "myg" . $i . "_06";
            $myg07 = "myg" . $i . "_07";
            $myg08 = "myg" . $i . "_08";
            $myg09 = "myg" . $i . "_09";
            $myg10 = "myg" . $i . "_10";
            $myg11 = "myg" . $i . "_11";
            $myg12 = "myg" . $i . "_12";
            $myg13 = "myg" . $i . "_13";
            $myg14 = "myg" . $i . "_14";
            $myg15 = "myg" . $i . "_15";
            $myg16 = "myg" . $i . "_16";
            $myg17 = "myg" . $i . "_17";
            $myg18 = "myg" . $i . "_18";
            $myg19 = "myg" . $i . "_19";
            $myg20 = "myg" . $i . "_20";
            $myg21 = "myg" . $i . "_21";
            $myg22 = "myg" . $i . "_22";

            $ResponseXML .= "<tr><td onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div id=\"" . $myg01 . "\">" . $myg[1] . "</div></td>
   						<td onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div id=\"" . $myg02 . "\">" . $myg[2] . "</div></td>
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg03 . "\">" . number_format($myg[3], 0, ".", ",") . "</div></td>
                                                <td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg04 . "\">" . number_format($myg[4], 0, ".", ",") . "</div></td>";

            if ($myg[5] <> 0) {
                $ResponseXML .= "<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg05 . "\"  style=\"color:red\">" . number_format($myg[5], 0, ".", ",") . "</div></td>";
            } else {
                $ResponseXML .= "<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg05 . "\">" . number_format($myg[5], 0, ".", ",") . "</div></td>";
            }
            if ($myg[6] <> 0) {
                $ResponseXML .= "<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg06 . "\"  style=\"color:red\">" . number_format($myg[6], 0, ".", ",") . "</div></td>";
            } else {
                $ResponseXML .= "<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg06 . "\">" . number_format($myg[6], 0, ".", ",") . "</div></td>";
            }


            $ResponseXML .= "
						
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg07 . "\">" . number_format($myg[7], 0, ".", ",") . "</div></td>
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg08 . "\">" . number_format($myg[8], 0, ".", ",") . "</div></td>
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg09 . "\">" . $myg[9] . "</div></td>
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg10 . "\">" . number_format($myg[10], 0, ".", ",") . "</div></td>
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg11 . "\">" . number_format($myg[11], 0, ".", ",") . "</div></td>
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg12 . "\">" . number_format($myg[12], 0, ".", ",") . "</div></td>
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg13 . "\">" . number_format($myg[13], 0, ".", ",") . "</div></td>
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg14 . "\">" . number_format($myg[14], 0, ".", ",") . "</div></td>
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg15 . "\">" . number_format($myg[15], 0, ".", ",") . "</div></td>
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg16 . "\">" . number_format($myg[16], 0, ".", ",") . "</div></td>
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg17 . "\">" . number_format($myg[17], 0, ".", ",") . "</div></td>
						<td align=right onClick=\"NewWindow('sales_ord_new_display.php?txtrefno=" . $ord_no . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\" ><div align=right id=\"" . $myg18 . "\">" . number_format($myg[18], 0, ".", ",") . "</div></td>
						<td align=right ><div align=right id=\"" . $myg19 . "\">" . $myg[19] . "</div></td>
						<td onclick=\"appro('" . $i . "', '0');\"><div id=\"" . $myg20 . "\">---</div></td>
						<td ><input type=\"text\" name=\"" . $myg22 . "\" id=\"" . $myg22 . "\" /></td>
						
						<td><div id=\"" . $myg21 . "\">" . $myg[21] . "</div></td></tr>";

            $i = $i + 1;
        }
    }
    $ResponseXML .= "</table>]]></sales_table>";
    $ResponseXML .= "<mcount><![CDATA[" . $i . "]]></mcount>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
    mysqli_close($GLOBALS['dbben']);
}

if ($_GET["Command"] == "appro") {
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    if (trim($_GET["myg01"]) != "---") {
        if (trim($_GET["myg20"]) == "YES") {
            $myg20 = "No";
            $ResponseXML .= "<warn><![CDATA[]]></warn>";
        } else {
            $limit = 0;
            $c = 1;
            $rst = "Select * from br_trn where cus_code = '" . trim($_GET["myg01"]) . "' and Rep = '" . trim($_GET["myg21"]) . "' and credit_lim > '0'";
            //echo $rst;
            $result_rst = mysqli_query($GLOBALS['dbinv'], $rst);
            while ($row_rst = mysqli_fetch_array($result_rst)) {
                if (trim($row_rst["CAT"]) != "C") {
                    $c = $c * 2.5;
                }
                $limit = $limit + ($row_rst["credit_lim"] * $c);
            }

            if ($limit > 0) {
                $chk = (($_GET["myg08"] * -1) / $limit) * 100;
            } else {
                $chk = 100;
            }

            $rst = "Select * from   userpermission where docid = '15' and username = '" . trim($_SESSION["CURRENT_USER"]) . "'";
            //echo $rst;
            $result_rst = mysqli_query($GLOBALS['dbinv'], $rst);
            if ($row_rst = mysqli_fetch_array($result_rst)) {

                if ($row_rst["doc_mod"] == "1") {
                    if ($chk > "25") {

                        if ($_GET["a"] == "1") {
                            $myg20 = "YES";
                            $ResponseXML .= "<warn><![CDATA[]]></warn>";
                        } else {
                            exit($_GET["i"] . "-You are trying to exceed more then 25% Exceed limit");
                        }
                        //$ResponseXML .= "<warn><![CDATA[You are trying to exceed more then 25% Exceed limit]]></warn>";
                        //msg = MsgBox("You are trying to exceed more then 25% Exceed limit", vbYesNo, "Warning")
                        //If msg = vbYes Then
                        //   $myg20 = "YES";
                        //Else
                        //    myg.TextMatrix(myg.Row, 20) = ""
                        //End If
                    } else {
                        $myg20 = "YES";
                        $ResponseXML .= "<warn><![CDATA[]]></warn>";
                    }
                } else {
                    if ($chk > "25") {
                        exit("Sorry you are trying to exceed more then 25% Exceed limit");
                    } else {
                        $myg20 = "YES";
                    }
                    $ResponseXML .= "<warn><![CDATA[]]></warn>";
                }
            } else {
                $ResponseXML .= "<warn><![CDATA[]]></warn>";
            }
        }
    } else {
        $ResponseXML .= "<warn><![CDATA[]]></warn>";
    }

    $ResponseXML .= "<resmyg20><![CDATA[" . $myg20 . "]]></resmyg20>";
    $ResponseXML .= "<i><![CDATA[" . $_GET["i"] . "]]></i>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if (isset($_POST["Command"])) {
    if ($_POST["Command"] == "save_inv") {



        $i = 1;

        while ($_POST["mcount"] > $i) {
            $myg01 = "myg" . $i . "_01";
            $myg02 = "myg" . $i . "_02";
            $myg03 = "myg" . $i . "_03";
            $myg04 = "myg" . $i . "_04";
            $myg05 = "myg" . $i . "_05";
            $myg06 = "myg" . $i . "_06";
            $myg07 = "myg" . $i . "_07";
            $myg08 = "myg" . $i . "_08";
            $myg09 = "myg" . $i . "_09";
            $myg10 = "myg" . $i . "_10";
            $myg11 = "myg" . $i . "_11";
            $myg12 = "myg" . $i . "_12";
            $myg13 = "myg" . $i . "_13";
            $myg14 = "myg" . $i . "_14";
            $myg15 = "myg" . $i . "_15";
            $myg16 = "myg" . $i . "_16";
            $myg17 = "myg" . $i . "_17";
            $myg18 = "myg" . $i . "_18";
            $myg19 = "myg" . $i . "_19";
            $myg20 = "myg" . $i . "_20";
            $myg21 = "myg" . $i . "_21";
            $myg22 = "myg" . $i . "_22";


            if (trim($_POST[$myg20]) == "YES") {
                //echo $_POST[$myg20];
                //	$AUTH_USER="";
                if (($_POST[$myg05] > 0) or ( $_POST[$myg11] > 0)) {
                    $sql = "insert into tmpcrlmt (sdate, stime, username, tmpLmt, Class, Rep, cusCode, crLmt, cat, FLAG, remark) values ('" . date("Y-m-d") . "','" . date("H:m:s") . "' ,'" . $_SESSION["CURRENT_USER"] . "', '0' , 'NB', 'NR', '" . trim($_POST[$myg01]) . "', '0', 'C', 'PER' , '" . trim($_POST[$myg22]) . "')";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    //echo "1-".$sql;

                    $sql = "update vendor set Over_DUE_IG_Date='" . date("Y-m-d") . "'  where code='" . trim($_POST[$myg01]) . "' ";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    //echo "2-". $sql;

                    if ($_POST[$myg08] < 0) {
                        $myg08_val = str_replace(",", "", $_POST[$myg08]);
                        $sql = "insert into tmpcrlmt (sdate, stime, username, tmpLmt, Class, Rep, cusCode, crLmt, cat, remark) values ('" . date("Y-m-d") . "','" . date("H:m:s") . "' ,'" . $_SESSION["CURRENT_USER"] . "'," . (($myg08_val - 10) * -1) . " ,'" . trim($_POST[$myg19]) . "','" . trim($_POST[$myg21]) . "','" . trim($_POST[$myg01]) . "'," . str_replace(",", "", $_POST[$myg03]) . ", 'C' , '" . trim($_POST[$myg22]) . "')";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        //echo "3-". $sql;
                        //$sql=  "Update view_repord_brand_btr set Limit_need = Limit_need * -1, Result = 'OK' where C_CODE = '" . trim($_POST[$myg01]) . "' and SAL_EX = '" . trim($_POST[$myg21]) . "' and class = '" . trim($_POST[$myg19]) . "' and INVNO = '0'   ";
                        //$result =mysqli_query($GLOBALS['dbinv'],$sql) ;
                        //echo "4-". $sql;

                        $sql = "select * from  br_trn where cus_code='" . trim($_POST[$myg01]) . "' and Rep='" . trim($_POST[$myg21]) . "' and brand='" . trim($_POST[$myg19]) . "' ";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        if ($row = mysqli_fetch_array($result)) {

                            $sql_br = "update br_trn set tmpLmt= " . (($myg08_val - 10) * -1) . " , day = '" . date("Y-m-d") . "' where cus_code='" . trim($_POST[$myg01]) . "' and Rep='" . trim($_POST[$myg21]) . "' and brand='" . trim($_POST[$myg19]) . "' ";
                            //echo "5-". $sql_br;
                            $result_br = mysqli_query($GLOBALS['dbinv'], $sql_br);
                        } else {
                            $sql_br = "insert into br_trn (cus_code, Rep, credit_lim, brand, tmpLmt, day) values ('" . trim($_POST[$myg01]) . "','" . trim($_POST[$myg21]) . "', '0', '" . trim($_POST[$myg19]) . "', " . (($myg08_val - 10) * -1) . ", '" . date("Y-m-d") . "' )";
                            $result_br = mysqli_query($GLOBALS['dbinv'], $sql_br);
                            //echo "6-". $sql_br;
                        }
                    }

                    if ((strtolower(trim($_SESSION["CURRENT_USER"])) == "gayal") or ( strtolower(trim($_SESSION["CURRENT_USER"])) == "rohan") or ( strtolower(trim($_SESSION["CURRENT_USER"])) == "rohan1")) {
                        $sql_vbr = "Update view_repord_brand_btr set Limit_need = Limit_need * -1, Result = 'OK' where C_CODE = '" . trim($_POST[$myg01]) . "' and sal_ex = '" . trim($_POST[$myg21]) . "' and class = '" . trim($_POST[$myg19]) . "' and INVNO = '0' and Forward = 'WD' and result = 'P'   ";
                        $result_vbr = mysqli_query($GLOBALS['dbinv'], $sql_vbr);
                    } else {
                        $sql_vbr = "Update view_repord_brand_btr set Limit_need = Limit_need * -1, Result = 'OK' where C_CODE = '" . trim($_POST[$myg01]) . "' and sal_ex = '" . trim($_POST[$myg21]) . "' and class = '" . trim($_POST[$myg19]) . "' and INVNO = '0' and Forward = 'MM'  and result = 'P'  ";
                        $result_vbr = mysqli_query($GLOBALS['dbinv'], $sql_vbr);
                    }
                } else {

                    $myg08_val = str_replace(",", "", $_POST[$myg08]);
                    $sql = "insert into tmpcrlmt (sdate, stime, username, tmpLmt, Class, Rep, cusCode, crLmt, cat, remark) values ('" . date("Y-m-d") . "','" . date("H:m:s") . "' ,'" . $_SESSION["CURRENT_USER"] . "'," . (($myg08_val - 10) * -1) . " ,'" . trim($_POST[$myg19]) . "','" . trim($_POST[$myg21]) . "','" . trim($_POST[$myg01]) . "'," . str_replace(",", "", $_POST[$myg03]) . ", 'C' , '" . trim($_POST[$myg22]) . "')";
                    //echo "7-". $sql;
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);

                    if ((strtolower(trim($_SESSION["CURRENT_USER"])) == "gayal") or ( strtolower(trim($_SESSION["CURRENT_USER"])) == "rohan") or ( strtolower(trim($_SESSION["CURRENT_USER"])) == "rohan1")) {
                        $sql = "Update view_repord_brand_btr set Limit_need = Limit_need * -1, Result = 'OK' where C_CODE = '" . trim($_POST[$myg01]) . "' and SAL_EX = '" . trim($_POST[$myg21]) . "' and class = '" . trim($_POST[$myg19]) . "' and INVNO = '0' and Forward = 'WD'  and result = 'P'  ";
                        //echo "8-". $sql;
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    } else {
                        $sql = "Update view_repord_brand_btr set Limit_need = Limit_need * -1, Result = 'OK' where C_CODE = '" . trim($_POST[$myg01]) . "' and SAL_EX = '" . trim($_POST[$myg21]) . "' and class = '" . trim($_POST[$myg19]) . "' and INVNO = '0' and Forward != 'WD' and result = 'P'   ";
                        //echo "8-". $sql;
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    }

                    $sql_br = "select * from  br_trn where cus_code='" . trim($_POST[$myg01]) . "' and Rep='" . trim($_POST[$myg21]) . "' and brand='" . trim($_POST[$myg19]) . "' ";
                    $result_br = mysqli_query($GLOBALS['dbinv'], $sql_br);
                    if ($row_br = mysqli_fetch_array($result_br)) {
                        $sql = "update br_trn set tmpLmt= " . (($myg08_val - 10) * -1) . " , day = '" . date("Y-m-d") . "' where cus_code='" . trim($_POST[$myg01]) . "' and Rep='" . trim($_POST[$myg21]) . "' and brand='" . trim($_POST[$myg19]) . "' ";
                        //echo "9-". $sql;
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    } else {
                        $sql = "insert into br_trn (cus_code, rep, credit_lim, brand, tmpLmt, day) values ('" . trim($_POST[$myg01]) . "','" . trim($_POST[$myg21]) . "','0','" . trim($_POST[$myg19]) . "'," . (($myg08_val - 10) * -1) . ", '" . date("Y-m-d") . "' )";
                        //echo "10-". $sql;
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    }
                }
            } else {
                if (trim($_POST[$myg20]) == "No") {
                    $sql = "Update view_repord_brand_btr set Limit_need = Limit_need * -1, Result = 'No' where C_CODE = '" . trim($_POST[$myg01]) . "' and INVNO = '0'  and SAL_EX = '" . trim($_POST[$myg21]) . "' and class = '" . trim($_POST[$myg19]) . "'   ";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                }
            }
            $i = $i + 1;
        }

        echo "Selected Limits Approved";
    }
}

mysqli_close($GLOBALS['dbinv']);
mysqli_close($GLOBALS['dbacc']);
?>