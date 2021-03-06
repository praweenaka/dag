<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("connectioni.php");



////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////



if ($_GET["Command"] == "pass_defectno") {

    include_once("connectioni.php");

    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $VATNO = "";

    if (trim($_GET["txtrefno"]) != "") {

        $sql = "Select * from c_clamas where refno = '" . $_GET["txtrefno"] . "'";

        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row = mysqli_fetch_array($result)) {
            $_SESSION["txt_fno"] = $row["refno"];
            $ResponseXML .= "<cl_no><![CDATA[" . $row["cl_no"] . "]]></cl_no>";
        } else {
            $ResponseXML .= "<cl_no><![CDATA[]]></cl_no>";
        }
        $ResponseXML .= "<c_subcode><![CDATA[" . $row["c_subcode"] . "]]></c_subcode>";

        $ResponseXML .= "<txtrefno><![CDATA[" . $_GET["txtrefno"] . "]]></txtrefno>";

        $sqlrsdef = "select * from s_deftrn where REFNO='" . trim($_GET["txtrefno"]) . "'";
        //echo $sqlrsdef;
        $resultrsdef = mysqli_query($GLOBALS['dbinv'], $sqlrsdef);
        if ($rowrsdef = mysqli_fetch_array($resultrsdef)) {

            $table_col1 = $rowrsdef["STK_NO"];
            $ResponseXML .= "<dtdate><![CDATA[" . $rowrsdef['SDATE'] . "]]></dtdate>";
            $ResponseXML .= "<txtbat><![CDATA[" . $rowrsdef['BAT_NO'] . "]]></txtbat>";
            if (is_null($rowrsdef["arno"]) == false) {
                $ResponseXML .= "<cmbShip><![CDATA[" . $rowrsdef['arno'] . "]]></cmbShip>";
            } else {
                $ResponseXML .= "<cmbShip><![CDATA[]]></cmbShip>";
            }

            if (is_null($rowrsdef["c_code"]) == false) {
                $ResponseXML .= "<txt_cuscode><![CDATA[" . $rowrsdef['c_code'] . "]]></txt_cuscode>";
            } else {
                $ResponseXML .= "<txt_cuscode><![CDATA[]]></txt_cuscode>";
            }

            $sqlcus = "select * from vender_sub where c_code='" . trim($row["c_subcode"]) . "'";
            $resultcus = mysqli_query($GLOBALS['dbinv'], $sqlcus);
            if ($rowcus = mysqli_fetch_array($resultcus)) {
                $ResponseXML .= "<txt_cusname><![CDATA[" . $rowcus['c_name'] . "]]></txt_cusname>";
                if (is_null($rowcus["c_add"]) == false) {
                    $txtadd = $rowcus["c_add"];
                    $ResponseXML .= "<txtadd><![CDATA[" . $txtadd . "]]></txtadd>";
                }

                if ((is_null($rowcus["c_vatno"]) == false) and (trim($rowcus["c_vatno"]) != "")) {
                    $ResponseXML .= "<vatgroup><![CDATA[1]]></vatgroup>";
                    $VATNO = $rowcus["c_vatno"];
                } else {
                    $ResponseXML .= "<vatgroup><![CDATA[0]]></vatgroup>";
                }
            }


            $ResponseXML .= "<txtcl_no><![CDATA[" . $rowrsdef['CLAM_NO'] . "]]></txtcl_no>";

            if (is_null($rowrsdef['STK_NO']) == false) {
                $sql = "SELECT * FROM s_mas WHERE STK_NO='" . $rowrsdef['STK_NO'] . "'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    if (is_null($row["DESCRIPT"]) == false) {
                        $table_col2 = $row["DESCRIPT"];
                    }
                    if (is_null($row["PART_NO"]) == false) {
                        $table_col3 = $row["PART_NO"];
                    }
                }
            }

            if (is_null($rowrsdef['REsult']) == false) {
                $ResponseXML .= "<Cmbres><![CDATA[" . $rowrsdef['REsult'] . "]]></Cmbres>";
            } else {
                $ResponseXML .= "<Cmbres><![CDATA[]]></Cmbres>";
            }

            if (is_null($rowrsdef['Remarks']) == false) {
                $ResponseXML .= "<txtremark><![CDATA[" . $rowrsdef['Remarks'] . "]]></txtremark>";
            }


            $table_col4 = $rowrsdef["AMOUNT"];
            $table_col5 = 1;
            $table_col6 = $rowrsdef["dis"];


            $AMOUNT = str_replace(",", "", $rowrsdef['AMOUNT']);

            if (is_null($rowrsdef['ref_per']) == false) {
                $sql_df_frm = "Select * from c_clamas where DGRN_NO = '" . $_GET["txtrefno"] . "' or DGRN_NO2 = '" . $_GET["txtrefno"] . "' or DGRN_NO3 = '" . $_GET["txtrefno"] . "' ";
                $result_df_frm = mysqli_query($GLOBALS['dbinv'], $sql_df_frm);

                $sql_rcbal = "select * from c_bal where REFNO = '" . $_GET["txtrefno"] . "'";
                $result_rcbal = mysqli_query($GLOBALS['dbinv'], $sql_rcbal);
                $row_rcbal = mysqli_fetch_array($result_rcbal);

                if ($row_df_frm = mysqli_fetch_array($result_df_frm)) {
                    $ResponseXML .= "<txt_fno><![CDATA[" . $row_df_frm['refno'] . "]]></txt_fno>";
                    $_SESSION["txt_fno"] = $row_df_frm['refno'];
                    $ResponseXML .= "<txt_net><![CDATA[" . number_format($AMOUNT, 2, ".", ",") . "]]></txt_net>";

                    $table_col9 = number_format($AMOUNT, 2, ".", ",");
                    $tmp = ($AMOUNT / $rowrsdef['ref_per']) * 100;
                    $table_col7 = $tmp;
                    $tmp = (($AMOUNT / $rowrsdef['ref_per']) * 100) / (100 - $rowrsdef['dis']) * 100;
                    $table_col4 = number_format($tmp, 2, ".", ",");
                    $table_col8 = $rowrsdef['ref_per'];
                    $old = "false";
                } else {
                    $old = "true";
                }

                if ($old == "true") {
                    $ResponseXML .= "<txt_fno><![CDATA[OLD]]></txt_fno>";
                    $_SESSION["txt_fno"] = "OLD";
                    $table_col8 = $rowrsdef['ref_per'];
                    $ResponseXML .= "<txt_net><![CDATA[" . number_format($AMOUNT, 2, ".", ",") . "]]></txt_net>";
                    $table_col9 = number_format($AMOUNT, 2, ".", ",");
                    $table_col7 = ($AMOUNT / $table_col8) * 100;
                    $table_col4 = (($AMOUNT / $table_col8) * 100) / (100 - $rowrsdef['dis']);
                }
            } else {

                $sql_df_frm = "Select * from c_clamas where DGRN_NO = '" . $_GET["txtrefno"] . "'";
                $result_df_frm = mysqli_query($GLOBALS['dbinv'], $sql_df_frm);


                $sql_rcbal = "select * from c_bal where refno = '" . $_GET["txtrefno"] . "'";
                $result_rcbal = mysqli_query($GLOBALS['dbinv'], $sql_rcbal);
                $row_rcbal = mysqli_fetch_array($result_rcbal);

                if ($row_df_frm = mysqli_fetch_array($result_df_frm)) {
                    $ResponseXML .= "<txt_fno><![CDATA[" . $row_df_frm['refno'] . "]]></txt_fno>";
                    $_SESSION["txt_fno"] = $row_df_frm['refno'];
                    $ResponseXML .= "<txt_net><![CDATA[" . number_format($AMOUNT, 2, ".", ",") . "]]></txt_net>";

                    $table_col9 = number_format($AMOUNT, 2, ".", ",");
                    $tmp = ($AMOUNT / $rowrsdef['ref_per']) * 100;
                    $table_col7 = $tmp;
                    $tmp = (($AMOUNT / $rowrsdef['ref_per']) * 100) / (100 - $rowrsdef['dis']) * 100;
                    $table_col4 = number_format($tmp, 2, ".", ",");
                    $table_col8 = $rowrsdef['ref_per'];
                    $old = "false";
                } else {
                    $old = "true";
                }

                $sql_df_frm = "Select * from c_clamas where DGRN_NO2 = '" . $_GET["txtrefno"] . "'";
                $result_df_frm = mysqli_query($GLOBALS['dbinv'], $sql_df_frm);

                $sql_rcbal = "select * from c_bal where refno = '" . $_GET["txtrefno"] . "'";
                $result_rcbal = mysqli_query($GLOBALS['dbinv'], $sql_rcbal);
                $row_rcbal = mysqli_fetch_array($result_rcbal);

                if ($row_df_frm = mysqli_fetch_array($result_df_frm)) {
                    $ResponseXML .= "<txt_fno><![CDATA[" . $row_df_frm['refno'] . "]]></txt_fno>";
                    $_SESSION["txt_fno"] = $row_df_frm['refno'];
                    $ResponseXML .= "<txt_net><![CDATA[" . number_format($AMOUNT, 2, ".", ",") . "]]></txt_net>";

                    $table_col9 = number_format($AMOUNT, 2, ".", ",");
                    $tmp = ($AMOUNT / $row_df_frm['add_ref1']) * 100;
                    $table_col7 = $tmp;
                    $tmp = (($AMOUNT / $row_df_frm['add_ref1']) * 100) / (100 - $rowrsdef['dis']) * 100;
                    $table_col4 = number_format($tmp, 2, ".", ",");
                    $table_col8 = $row_df_frm['add_ref1'];
                    $old = "false";
                } else {
                    if ($old == "false") {
                        $old = "false";
                    } else {
                        $old = "true";
                    }
                }

                $sql_df_frm = "Select * from c_clamas where DGRN_NO3 = '" . $_GET["txtrefno"] . "'";
                $result_df_frm = mysqli_query($GLOBALS['dbinv'], $sql_df_frm);

                $sql_rcbal = "select * from c_bal where refno = '" . $_GET["txtrefno"] . "'";
                $result_rcbal = mysqli_query($GLOBALS['dbinv'], $sql_rcbal);
                $row_rcbal = mysqli_fetch_array($result_rcbal);

                if ($row_df_frm = mysqli_fetch_array($result_df_frm)) {
                    $ResponseXML .= "<txt_fno><![CDATA[" . $row_df_frm['refno'] . "]]></txt_fno>";
                    $_SESSION["txt_fno"] = $row_df_frm['refno'];
                    $ResponseXML .= "<txt_net><![CDATA[" . number_format($AMOUNT, 2, ".", ",") . "]]></txt_net>";

                    $table_col9 = number_format($AMOUNT, 2, ".", ",");

                    $tmp = ($AMOUNT / $row_df_frm['add_ref2']) * 100;
                    $table_col7 = $tmp;

                    $tmp = (($AMOUNT / $row_df_frm['add_ref2']) * 100) / (100 - $rowrsdef['dis']) * 100;
                    $table_col4 = number_format($tmp, 2, ".", ",");

                    $table_col8 = $row_df_frm['add_ref2'];
                    $old = "false";
                } else {
                    if ($old == "false") {
                        $old = "false";
                    } else {
                        $old = "true";
                    }
                }

                $sql_rcbal = "select * from c_bal where refno = '" . $_GET["txtrefno"] . "'";
                $result_rcbal = mysqli_query($GLOBALS['dbinv'], $sql_rcbal);
                $row_rcbal = mysqli_fetch_array($result_rcbal);
                if ($old == "true") {
                    $ResponseXML .= "<txt_fno><![CDATA[OLD]]></txt_fno>";
                    $_SESSION["txt_fno"] = "OLD";
                    $table_col8 = 100;
                    $ResponseXML .= "<txt_net><![CDATA[" . number_format($AMOUNT, 2, ".", ",") . "]]></txt_net>";
                    $table_col9 = number_format($AMOUNT, 2, ".", ",");

                    $tmp = ($AMOUNT / $table_col8) * 100;
                    $table_col7 = $tmp;

                    $tmp = (($AMOUNT / $table_col8) * 100) / (100 - $rowrsdef['dis']) * 100;
                    $table_col4 = number_format($tmp, 2, ".", ",");
                }
            }

            if (is_null($rowrsdef["DEP"]) == false) {
                $sql_rst2 = "select * from s_stomas where CODE='" . $rowrsdef["DEP"] . "'";
                $result_rst2 = mysqli_query($GLOBALS['dbinv'], $sql_rst2);
                if ($row_rst2 = mysqli_fetch_array($result_rst2)) {
                    $dep = $rowrsdef["DEP"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $row_rst2["DESCRIPTION"];
                    $ResponseXML .= "<com_dep><![CDATA[" . $dep . "]]></com_dep>";
                }
            }

            if (is_null($rowrsdef["SAL_EX"]) == false) {
                $sql_rst1 = "select * from s_salrep where REPCODE='" . $rowrsdef["SAL_EX"] . "'";
                $result_rst1 = mysqli_query($GLOBALS['dbinv'], $sql_rst1);
                if ($row_rst1 = mysqli_fetch_array($result_rst1)) {
                    $dep = str_split($rowrsdef["SAL_EX"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 6) . $row_rst1["Name"];

                    //$ResponseXML .= "<Com_rep><![CDATA[".$dep."]]></Com_rep>";
                    $ResponseXML .= "<Com_rep><![CDATA[" . $rowrsdef["SAL_EX"] . "]]></Com_rep>";
                }
            }
        } else {

            $sql_rsdgrn = "Select * from  c_clamas where refno = '" . $_SESSION["txt_fno"] . "'";
            //echo $sql_rsdgrn;
            $result_rsdgrn = mysqli_query($GLOBALS['dbinv'], $sql_rsdgrn);
            if ($row_rsdgrn = mysqli_fetch_array($result_rsdgrn)) {
                $table_col1 = $row_rsdgrn["stk_no"];
                if (is_null($row_rsdgrn["ag_code"]) == false) {
                    $ResponseXML .= "<txt_cuscode><![CDATA[" . $row_rsdgrn["ag_code"] . "]]></txt_cuscode>";
                }

                $sql_cus = "select * from vender_sub where c_code='" . trim($row_rsdgrn["c_subcode"]) . "'";
                $result_cus = mysqli_query($GLOBALS['dbinv'], $sql_cus);
                if ($row_cus = mysqli_fetch_array($result_cus)) {
                    $ResponseXML .= "<txt_cusname><![CDATA[" . $row_cus["c_name"] . "]]></txt_cusname>";

                    if (is_null($row_cus["c_add"]) == false) {
                        $txtadd = $row_cus["c_add"];
                        $ResponseXML .= "<txtadd><![CDATA[" . $txtadd . "]]></txtadd>";
                    }

                    if ((is_null($row_cus["c_vatno"]) == false) and ($row_cus["c_vatno"] != "")) {
                        $ResponseXML .= "<vatgroup><![CDATA[1]]></vatgroup>";
                        $VATNO = $row_cus["c_vatno"];
                    } else {
                        $ResponseXML .= "<vatgroup><![CDATA[0]]></vatgroup>";
                    }
                }

                if (is_null($row_rsdgrn["agadd"]) == false) {
                    $ResponseXML .= "<txtadd><![CDATA[" . $row_rsdgrn["agadd"] . "]]></txtadd>";
                }
                if (is_null($row_rsdgrn["seri_no"]) == false) {
                    $ResponseXML .= "<txtbat><![CDATA[" . $row_rsdgrn["seri_no"] . "]]></txtbat>";
                }

                $txtcl_no = "";
                if (is_null($row_rsdgrn["cl_no"]) == false) {
                    $txtcl_no = $row_rsdgrn["cl_no"];
                }
                if (is_null($row_rsdgrn["rem_per"]) == false) {
                    $txtcl_no = $txtcl_no . "  " . $row_rsdgrn["rem_per"];
                }
                $ResponseXML .= "<txtcl_no><![CDATA[" . $txtcl_no . "]]></txtcl_no>";

                $txtremark = "";
                if (is_null($row_rsdgrn["tc_ob"]) == false) {
                    $txtremark = $row_rsdgrn["tc_ob"];
                }
                if (is_null($row_rsdgrn["Mn_ob"]) == false) {
                    $txtremark = $txtremark . " (" . $row_rsdgrn["Mn_ob"] . ")";
                }
                $ResponseXML .= "<txtremark><![CDATA[" . $txtremark . "]]></txtremark>";


                if (is_null($row_rsdgrn["des"]) == false) {
                    $table_col2 = $row_rsdgrn["des"];
                }
                if (is_null($row_rsdgrn["patt"]) == false) {
                    $table_col3 = $row_rsdgrn["patt"];
                }


                $sql_rst = "SELECT * FROM s_mas WHERE STK_NO='" . $row_rsdgrn["stk_no"] . "'";
                $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
                if ($row_rst = mysqli_fetch_array($result_rst)) {
                    if (is_null($row_rst["SELLING"]) == false) {
                        $table_col4 = $row_rst["SELLING"];
                    }
                }

                $sql_rst = "Select ref_no, dis_per from viewinv where cus_code = '" . trim($row_rsdgrn["ag_code"]) . "' and stk_no = '" . trim($row_rsdgrn["stk_no"]) . "' and cancel_m = '0' order by sdate desc";

                $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
                if ($row_rst = mysqli_fetch_array($result_rst)) {

                    $sql_CH_DIS = "Select Incen_per from  s_crnfrmtrn where inv_no = '" . trim($rst["REF_NO"]) . "'";
                    $result_CH_DIS = mysqli_query($GLOBALS['dbinv'], $sql_CH_DIS);
                    if ($row_CH_DIS = mysqli_fetch_array($result_CH_DIS)) {
                        $add_dis = $row_CH_DIS["Incen_per"];
                    } else {
                        $add_dis = 0;
                    }
                    $table_col6 = $row_rst["dis_per"] + $add_dis;
                }

                $table_col5 = 1;

                $res = "";
                if ($row_rsdgrn["Refund"] == "Recommended") {
                    $res = "DEFECT";
                    //$ResponseXML .= "<Cmbres><![CDATA[DEFECT]]></Cmbres>"; 
                }

                if (($row_rsdgrn["Refund"] == "Recommended") and ($row_rsdgrn["Commercialy"] != "0") and ($row_rsdgrn["Commercialy"] != "")) {
                    $res = "COMMERCIAL CLAIM";
                    //$ResponseXML .= "<Cmbres><![CDATA[COMMERCIAL CLAIM]]></Cmbres>"; 
                }

                if (($row_rsdgrn["Refund"] == "Not Recommended") and ($row_rsdgrn["Commercialy"] != "0") and ($row_rsdgrn["Commercialy"] != "")) {
                    $res = "COMMERCIAL CLAIM";
                }
                $ResponseXML .= "<Cmbres><![CDATA[" . $res . "]]></Cmbres>";

                if (($row_rsdgrn["DGRN_NO"] == "0") and ($row_rsdgrn["rem_per"] > 0)) {
                    $table_col8 = $row_rsdgrn["rem_per"];
                }

                if (($row_rsdgrn["DGRN_NO2"] == "0") and ($row_rsdgrn["add_ref1"] > 0)) {
                    $table_col8 = $row_rsdgrn["add_ref1"];
                }

                if (($row_rsdgrn["DGRN_NO3"] == "0") and ($row_rsdgrn["add_ref2"] > 0)) {
                    $table_col8 = $row_rsdgrn["add_ref2"];
                }
            }
        }
    }

    $sql_rscbal = "select * from c_bal where REFNO='" . trim($_GET["txtrefno"]) . "'";
    $result_rscbal = mysqli_query($GLOBALS['dbinv'], $sql_rscbal);
    if ($row_rscbal = mysqli_fetch_array($result_rscbal)) {
        if (is_null($row_rscbal["RNO"]) == false) {
            $ResponseXML .= "<txtrno><![CDATA[" . $row_rscbal["RNO"] . "]]></txtrno>";
        }
    }





    $ResponseXML .= "<itemno><![CDATA[" . $table_col1 . "]]></itemno>";
    $ResponseXML .= "<item_name><![CDATA[" . $table_col2 . "]]></item_name>";
    $ResponseXML .= "<partno><![CDATA[" . $table_col3 . "]]></partno>";
    $ResponseXML .= "<rate><![CDATA[" . $table_col4 . "]]></rate>";
    $ResponseXML .= "<qty><![CDATA[" . $table_col5 . "]]></qty>";
    $ResponseXML .= "<discou><![CDATA[" . $table_col6 . "]]></discou>";

    $ResponseXML .= "<refund><![CDATA[" . $table_col8 . "]]></refund>";




    //$table_col7 = $table_col4 * $table_col5 - $table_col4 * $table_col5 * $table_col6 * 0.01;
    //echo $table_col7;
    $ResponseXML .= "<subtot><![CDATA[" . number_format($table_col7, 2, ".", ",") . "]]></subtot>";

    //$table_col9 = $table_col9 + ($table_col7 * $table_col8 * 0.01);

    $ResponseXML .= "<total><![CDATA[" . $table_col9 . "]]></total>";
    $ResponseXML .= "<txt_net><![CDATA[" . $table_col9 . "]]></txt_net>";




    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}


if ($_GET["Command"] == "SetListName") {

    echo "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">REF No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">BAT No</font></td>
                               <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Claim No</font></td>
                               <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Date</font></td>
   </tr>";


    require_once("connectioni.php");



    //$sql="select REFNO, BAT_NO, CLAM_NO, SDATE  from s_deftrn where REFNO like '" & txtcode.Text & "%' and CANCELL='0' ORDER BY REFNO"
    //$sql="SELECT * FROM s_crnma where CANCELL='0' order by REF_NO desc";

    if ($_GET["mstatus"] == "invno") {
        $sql = "select REFNO, BAT_NO, CLAM_NO, SDATE  from s_deftrn where  CANCELL='0' and REFNO like '" . $_GET["invno"] . "%' ORDER BY SDATE desc limit 50";
    } else {
        $sql = "select REFNO, BAT_NO, CLAM_NO, SDATE  from s_deftrn where  CANCELL='0' and CLAM_NO like '" . $_GET["customername"] . "%' ORDER BY SDATE desc limit 50";
    }

    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        echo "<tr>               
                              <td onclick=\"defect_d('" . $row['REFNO'] . "');\">" . $row['REFNO'] . "</a></td>
                              <td onclick=\"defect_d('" . $row['REFNO'] . "');\">" . $row['BAT_NO'] . "</a></td>
                              <td onclick=\"defect_d('" . $row['REFNO'] . "');\">" . $row['CLAM_NO'] . "</a></td>
							  <td onclick=\"defect_d('" . $row['REFNO'] . "');\">" . $row['SDATE'] . "</a></td>
                            </tr>";
    }

    echo "</table>";
}

if ($_GET["Command"] == "pass_defectno1") {

    include_once("connectioni.php");

    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $VATNO = "";

    if (trim($_GET["txtrefno"]) != "") {




        $ResponseXML .= "<txtrefno><![CDATA[" . $_GET["txtrefno"] . "]]></txtrefno>";

        $sqlrsdef = "select * from s_deftrn where REFNO='" . trim($_GET["txtrefno"]) . "'";
        //echo $sqlrsdef;
        $resultrsdef = mysqli_query($GLOBALS['dbinv'], $sqlrsdef);
        if ($rowrsdef = mysqli_fetch_array($resultrsdef)) {
            $table_col1 = $rowrsdef["STK_NO"];
            //$ResponseXML .= "<dtdate><![CDATA[".$rowrsdef['SDATE']."]]></dtdate>";
            $ResponseXML .= "<dtdate><![CDATA[" . $rowrsdef['SDATE'] . "]]></dtdate>";
            $ResponseXML .= "<txtbat><![CDATA[" . $rowrsdef['BAT_NO'] . "]]></txtbat>";

            $ResponseXML .= "<cl_no><![CDATA[" . $rowrsdef["cl_no"] . "]]></cl_no>";


            $sql_cl = "Select * from c_clamas where cl_no = '" . $rowrsdef["cl_no"] . "'";
            $result_cl = mysqli_query($GLOBALS['dbinv'], $sql_cl);
            if ($row_cl = mysqli_fetch_array($result_cl)) {
                $_SESSION["txt_fno"] = $row_cl["refno"];
                $ResponseXML .= "<cl_refno><![CDATA[" . $row_cl["refno"] . "]]></cl_refno>";
                $ResponseXML .= "<c_subcode><![CDATA[" . $row_cl["c_subcode"] . "]]></c_subcode>";
            } else {
                $ResponseXML .= "<cl_refno><![CDATA[]]></cl_refno>";
            }

            if (is_null($rowrsdef["arno"]) == false) {
                $ResponseXML .= "<cmbShip><![CDATA[" . $rowrsdef['arno'] . "]]></cmbShip>";
            } else {
                $ResponseXML .= "<cmbShip><![CDATA[]]></cmbShip>";
            }

            if (is_null($rowrsdef["c_code"]) == false) {
                $ResponseXML .= "<txt_cuscode><![CDATA[" . $rowrsdef['c_code'] . "]]></txt_cuscode>";
            } else {
                $ResponseXML .= "<txt_cuscode><![CDATA[]]></txt_cuscode>";
            }

            $sqlcus = "select * from vender_sub where c_code='" . trim($row_cl["c_subcode"]) . "'";
            $resultcus = mysqli_query($GLOBALS['dbinv'], $sqlcus);
            if ($rowcus = mysqli_fetch_array($resultcus)) {
                $ResponseXML .= "<txt_cusname><![CDATA[" . $rowcus['c_name'] . "]]></txt_cusname>";
                if (is_null($rowcus["c_add"]) == false) {
                    $txtadd = $rowcus["c_add"];
                    $ResponseXML .= "<txtadd><![CDATA[" . $txtadd . "]]></txtadd>";
                }
                if ((is_null($rowcus["c_vatno"]) == false) and ($rowcus["c_vatno"] != "")) {
                    $ResponseXML .= "<vatgroup><![CDATA[1]]></vatgroup>";
                    $VATNO = $rowcus["c_vatno"];
                } else {
                    $ResponseXML .= "<vatgroup><![CDATA[0]]></vatgroup>";
                }
            }


            $ResponseXML .= "<txtcl_no><![CDATA[" . $rowrsdef['CLAM_NO'] . "]]></txtcl_no>";

            if (is_null($rowrsdef['STK_NO']) == false) {
                $sql = "SELECT * FROM s_mas WHERE STK_NO='" . $rowrsdef['STK_NO'] . "'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    if (is_null($row["DESCRIPT"]) == false) {
                        $table_col2 = $row["DESCRIPT"];
                    }
                    if (is_null($row["PART_NO"]) == false) {
                        $table_col3 = $row["PART_NO"];
                    }
                }
            }

            if (is_null($rowrsdef['REsult']) == false) {
                $ResponseXML .= "<Cmbres><![CDATA[" . $rowrsdef['REsult'] . "]]></Cmbres>";
            }

            if (is_null($rowrsdef['Remarks']) == false) {
                $ResponseXML .= "<txtremark><![CDATA[" . $rowrsdef['Remarks'] . "]]></txtremark>";
            }


            $table_col4 = $rowrsdef["AMOUNT"];
            $table_col5 = 1;
            $table_col6 = $rowrsdef["dis"];


            $AMOUNT = str_replace(",", "", $rowrsdef['AMOUNT']);

            if (is_null($rowrsdef['ref_per']) == false) {
                $sql_df_frm = "Select * from c_clamas where DGRN_NO = '" . $_GET["txtrefno"] . "' or DGRN_NO2 = '" . $_GET["txtrefno"] . "' or DGRN_NO3 = '" . $_GET["txtrefno"] . "' ";
                $result_df_frm = mysqli_query($GLOBALS['dbinv'], $sql_df_frm);

                $sql_rcbal = "select * from c_bal where REFNO = '" . $_GET["txtrefno"] . "'";
                $result_rcbal = mysqli_query($GLOBALS['dbinv'], $sql_rcbal);
                $row_rcbal = mysqli_fetch_array($result_rcbal);

                if ($row_df_frm = mysqli_fetch_array($result_df_frm)) {
                    $ResponseXML .= "<txt_fno><![CDATA[" . $row_df_frm['refno'] . "]]></txt_fno>";
                    $_SESSION["txt_fno"] = $row_df_frm['refno'];
                    $ResponseXML .= "<txt_net><![CDATA[" . number_format($row_rcbal["AMOUNT"], 2, ".", ",") . "]]></txt_net>";

                    $table_col9 = number_format($row_rcbal["AMOUNT"], 2, ".", ",");
                    if ($rowrsdef['ref_per'] != 0) {
                        $tmp = ($row_rcbal["AMOUNT"] / $rowrsdef['ref_per']) * 100;
                    } else {
                        $tmp = 0;
                    }

                    $table_col7 = $tmp;
                    //echo $row_rcbal["AMOUNT"]."/".$rowrsdef['ref_per']."/".$rowrsdef['dis'];
                    if ($rowrsdef['ref_per'] != 0) {
                        $tmp = (($row_rcbal["AMOUNT"] / $rowrsdef['ref_per']) ) / (100 - $rowrsdef['dis']) * 10000;
                    } else {
                        $tmp = 0;
                    }
                    //echo $tmp;
                    $table_col4 = number_format($tmp, 2, ".", ",");
                    $table_col8 = $rowrsdef['ref_per'];
                    $old = "false";
                } else {
                    $old = "true";
                }

                if ($old == "true") {
                    $ResponseXML .= "<txt_fno><![CDATA[OLD]]></txt_fno>";
                    $_SESSION["txt_fno"] = "OLD";
                    $table_col8 = $rowrsdef['ref_per'];
                    $ResponseXML .= "<txt_net><![CDATA[" . number_format($row_rcbal["AMOUNT"], 2, ".", ",") . "]]></txt_net>";
                    $table_col9 = number_format($row_rcbal["AMOUNT"], 2, ".", ",");
                    $table_col7 = ($row_rcbal["AMOUNT"] / $table_col8) * 100;
                    $table_col4 = (($row_rcbal["AMOUNT"] / $table_col8) * 100) / (100 - $rowrsdef['dis']);
                }
            } else {

                $sql_df_frm = "Select * from c_clamas where DGRN_NO = '" . $_GET["txtrefno"] . "'";
                //echo $sql_df_frm;
                $result_df_frm = mysqli_query($GLOBALS['dbinv'], $sql_df_frm);


                $sql_rcbal = "select * from c_bal where refno = '" . $_GET["txtrefno"] . "'";
                //echo $sql_rcbal;
                $result_rcbal = mysqli_query($GLOBALS['dbinv'], $sql_rcbal);
                $row_rcbal = mysqli_fetch_array($result_rcbal);

                if ($row_df_frm = mysqli_fetch_array($result_df_frm)) {
                    $ResponseXML .= "<txt_fno><![CDATA[" . $row_df_frm['refno'] . "]]></txt_fno>";
                    $_SESSION["txt_fno"] = $row_df_frm['refno'];
                    $ResponseXML .= "<txt_net><![CDATA[" . number_format($AMOUNT, 2, ".", ",") . "]]></txt_net>";



                    $table_col9 = number_format($row_rcbal["AMOUNT"], 2, ".", ",");
                    $tmp = ($row_rcbal["AMOUNT"] / $rowrsdef['ref_per']) * 100;
                    $table_col7 = $tmp;
                    $tmp = (($row_rcbal["AMOUNT"] / $rowrsdef['ref_per']) * 100) / (100 - $rowrsdef['dis']) * 100;
                    $table_col4 = number_format($tmp, 2, ".", ",");
                    $table_col8 = $rowrsdef['ref_per'];
                    $old = "false";
                } else {
                    $old = "true";
                }

                $sql_df_frm = "Select * from c_clamas where DGRN_NO2 = '" . $_GET["txtrefno"] . "'";
                $result_df_frm = mysqli_query($GLOBALS['dbinv'], $sql_df_frm);

                $sql_rcbal = "select * from c_bal where refno = '" . $_GET["txtrefno"] . "'";
                $result_rcbal = mysqli_query($GLOBALS['dbinv'], $sql_rcbal);
                $row_rcbal = mysqli_fetch_array($result_rcbal);

                if ($row_df_frm = mysqli_fetch_array($result_df_frm)) {
                    $ResponseXML .= "<txt_fno><![CDATA[" . $row_df_frm['refno'] . "]]></txt_fno>";
                    $_SESSION["txt_fno"] = $row_df_frm['refno'];
                    $ResponseXML .= "<txt_net><![CDATA[" . number_format($row_rcbal["AMOUNT"], 2, ".", ",") . "]]></txt_net>";

                    $table_col9 = number_format($row_rcbal["AMOUNT"], 2, ".", ",");
                    $tmp = ($row_rcbal["AMOUNT"] / $row_df_frm['add_ref1']) * 100;
                    $table_col7 = $tmp;
                    $tmp = (($row_rcbal["AMOUNT"] / $row_df_frm['add_ref1']) * 100) / (100 - $rowrsdef['dis']) * 100;
                    $table_col4 = number_format($tmp, 2, ".", ",");
                    $table_col8 = $row_df_frm['add_ref1'];
                    $old = "false";
                } else {
                    if ($old == "false") {
                        $old = "false";
                    } else {
                        $old = "true";
                    }
                }

                $sql_df_frm = "Select * from c_clamas where DGRN_NO3 = '" . $_GET["txtrefno"] . "'";
                $result_df_frm = mysqli_query($GLOBALS['dbinv'], $sql_df_frm);

                $sql_rcbal = "select * from c_bal where refno = '" . $_GET["txtrefno"] . "'";
                $result_rcbal = mysqli_query($GLOBALS['dbinv'], $sql_rcbal);
                $row_rcbal = mysqli_fetch_array($result_rcbal);

                if ($row_df_frm = mysqli_fetch_array($result_df_frm)) {
                    $ResponseXML .= "<txt_fno><![CDATA[" . $row_df_frm['refno'] . "]]></txt_fno>";
                    $_SESSION["txt_fno"] = $row_df_frm['refno'];
                    $ResponseXML .= "<txt_net><![CDATA[" . number_format($row_rcbal["AMOUNT"], 2, ".", ",") . "]]></txt_net>";

                    $table_col9 = number_format($row_rcbal["AMOUNT"], 2, ".", ",");

                    $tmp = ($row_rcbal["AMOUNT"] / $row_df_frm['add_ref2']) * 100;
                    $table_col7 = $tmp;

                    $tmp = (($row_rcbal["AMOUNT"] / $row_df_frm['add_ref2']) * 100) / (100 - $rowrsdef['dis']) * 100;
                    $table_col4 = number_format($tmp, 2, ".", ",");

                    $table_col8 = $row_df_frm['add_ref2'];
                    $old = "false";
                } else {
                    if ($old == "false") {
                        $old = "false";
                    } else {
                        $old = "true";
                    }
                }

                $sql_rcbal = "select * from c_bal where refno = '" . $_GET["txtrefno"] . "'";
                $result_rcbal = mysqli_query($GLOBALS['dbinv'], $sql_rcbal);
                $row_rcbal = mysqli_fetch_array($result_rcbal);
                if ($old == "true") {
                    $ResponseXML .= "<txt_fno><![CDATA[OLD]]></txt_fno>";
                    $_SESSION["txt_fno"] = "OLD";
                    $table_col8 = 100;
                    $ResponseXML .= "<txt_net><![CDATA[" . number_format($row_rcbal["AMOUNT"], 2, ".", ",") . "]]></txt_net>";
                    $table_col9 = number_format($row_rcbal["AMOUNT"], 2, ".", ",");

                    $tmp = ($row_rcbal["AMOUNT"] / $table_col8) * 100;
                    $table_col7 = $tmp;

                    $tmp = (($row_rcbal["AMOUNT"] / $table_col8) * 100) / (100 - $rowrsdef['dis']) * 100;
                    $table_col4 = number_format($tmp, 2, ".", ",");
                }
            }

            if (is_null($rowrsdef["DEP"]) == false) {
                $sql_rst2 = "select * from s_stomas where CODE='" . $rowrsdef["DEP"] . "'";
                $result_rst2 = mysqli_query($GLOBALS['dbinv'], $sql_rst2);
                if ($row_rst2 = mysqli_fetch_array($result_rst2)) {
                    $dep = $rowrsdef["DEP"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $row_rst2["DESCRIPTION"];
                    $ResponseXML .= "<com_dep><![CDATA[" . $dep . "]]></com_dep>";
                }
            }

            if (is_null($rowrsdef["SAL_EX"]) == false) {
                $sql_rst1 = "select * from s_salrep where REPCODE='" . $rowrsdef["SAL_EX"] . "'";
                $result_rst1 = mysqli_query($GLOBALS['dbinv'], $sql_rst1);
                if ($row_rst1 = mysqli_fetch_array($result_rst1)) {
                    $dep = $rowrsdef["SAL_EX"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $row_rst1["Name"];
                    //$ResponseXML .= "<Com_rep><![CDATA[".$dep."]]></Com_rep>";
                    $ResponseXML .= "<Com_rep><![CDATA[" . $rowrsdef["SAL_EX"] . "]]></Com_rep>";
                }
            }
        } else {

            $sql_rsdgrn = "Select * from  c_clamas where refno = '" . $_SESSION["txt_fno"] . "'";
            //echo $sql_rsdgrn;
            $result_rsdgrn = mysqli_query($GLOBALS['dbinv'], $sql_rsdgrn);
            if ($row_rsdgrn = mysqli_fetch_array($result_rsdgrn)) {
                $table_col1 = $row_rsdgrn["stk_no"];
                if (is_null($row_rsdgrn["ag_code"]) == false) {
                    $ResponseXML .= "<txt_cuscode><![CDATA[" . $row_rsdgrn["ag_code"] . "]]></txt_cuscode>";
                }
                if (is_null($row_rsdgrn["ag_name"]) == false) {
                    $ResponseXML .= "<txt_cusname><![CDATA[" . $row_rsdgrn["ag_name"] . "]]></txt_cusname>";
                }



                $sqlcus = "select * from vender_sub where c_code='" . trim($row_rsdgrn["c_subcode"]) . "'";
                $resultcus = mysqli_query($GLOBALS['dbinv'], $sqlcus);
                if ($rowcus = mysqli_fetch_array($resultcus)) {
                    $ResponseXML .= "<txt_cusname><![CDATA[" . $rowcus['c_name'] . "]]></txt_cusname>";
                    if (is_null($rowcus["c_add"]) == false) {
                        $txtadd = $rowcus["c_add"];
                        $ResponseXML .= "<txtadd><![CDATA[" . $txtadd . "]]></txtadd>";
                    }
                    if ((is_null($rowcus["c_vatno"]) == false) and ($rowcus["c_vatno"] != "")) {
                        $ResponseXML .= "<vatgroup><![CDATA[1]]></vatgroup>";
                        $VATNO = $rowcus["c_vatno"];
                    } else {
                        $ResponseXML .= "<vatgroup><![CDATA[0]]></vatgroup>";
                    }
                }

                if (is_null($row_rsdgrn["agadd"]) == false) {
                    $ResponseXML .= "<txtadd><![CDATA[" . $row_rsdgrn["agadd"] . "]]></txtadd>";
                }
                if (is_null($row_rsdgrn["seri_no"]) == false) {
                    $ResponseXML .= "<txtbat><![CDATA[" . $row_rsdgrn["seri_no"] . "]]></txtbat>";
                }

                $txtcl_no = "";
                if (is_null($row_rsdgrn["cl_no"]) == false) {
                    $txtcl_no = $row_rsdgrn["cl_no"];
                }
                if (is_null($row_rsdgrn["rem_per"]) == false) {
                    $txtcl_no = $txtcl_no . "  " . $row_rsdgrn["rem_per"];
                }
                $ResponseXML .= "<txtcl_no><![CDATA[" . $txtcl_no . "]]></txtcl_no>";

                $txtremark = "";
                if (is_null($row_rsdgrn["tc_ob"]) == false) {
                    $txtremark = $row_rsdgrn["tc_ob"];
                }
                if (is_null($row_rsdgrn["Mn_ob"]) == false) {
                    $txtremark = $txtremark . " (" . $row_rsdgrn["Mn_ob"] . ")";
                }
                $ResponseXML .= "<txtremark><![CDATA[" . $txtremark . "]]></txtremark>";


                if (is_null($row_rsdgrn["des"]) == false) {
                    $table_col2 = $row_rsdgrn["des"];
                }
                if (is_null($row_rsdgrn["patt"]) == false) {
                    $table_col3 = $row_rsdgrn["patt"];
                }


                $sql_rst = "SELECT * FROM s_mas WHERE STK_NO='" . $row_rsdgrn["stk_no"] . "'";
                $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
                if ($row_rst = mysqli_fetch_array($result_rst)) {
                    if (is_null($row_rst["SELLING"]) == false) {
                        $table_col4 = $row_rst["SELLING"];
                    }
                }

                $sql_rst = "Select ref_no, dis_per from viewinv where cus_code = '" . trim($row_rsdgrn["ag_code"]) . "' and stk_no = '" . trim($row_rsdgrn["stk_no"]) . "' and cancel_m = '0' order by sdate desc";

                $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
                if ($row_rst = mysqli_fetch_array($result_rst)) {

                    $sql_CH_DIS = "Select Incen_per from  s_crnfrmtrn where inv_no = '" . trim($rst["REF_NO"]) . "'";
                    $result_CH_DIS = mysqli_query($GLOBALS['dbinv'], $sql_CH_DIS);
                    if ($row_CH_DIS = mysqli_fetch_array($result_CH_DIS)) {
                        $add_dis = $row_CH_DIS["Incen_per"];
                    } else {
                        $add_dis = 0;
                    }
                    $table_col6 = $row_rst["dis_per"] + $add_dis;
                }

                $table_col5 = 1;

                if ($row_rsdgrn["Refund"] == "Recommended") {
                    $ResponseXML .= "<Cmbres><![CDATA[DEFECT]]></Cmbres>";
                }

                if (($row_rsdgrn["Refund"] == "Recommended") and ($row_rsdgrn["Commercialy"] != "0")) {
                    $ResponseXML .= "<Cmbres><![CDATA[COMMERCIAL CLAIM]]></Cmbres>";
                }

                if (($row_rsdgrn["Refund"] == "Not Recommended") and ($row_rsdgrn["Commercialy"] != "0")) {
                    $ResponseXML .= "<Cmbres><![CDATA[COMMERCIAL CLAIM]]></Cmbres>";
                }

                if (($row_rsdgrn["DGRN_NO"] == "0") and ($row_rsdgrn["rem_per"] > 0)) {
                    $table_col8 = $row_rsdgrn["rem_per"];
                }

                if (($row_rsdgrn["DGRN_NO2"] == "0") and ($row_rsdgrn["rem_per1"] > 0)) {
                    $table_col8 = $row_rsdgrn["rem_per1"];
                }

                if (($row_rsdgrn["DGRN_NO3"] == "0") and ($row_rsdgrn["rem_per2"] > 0)) {
                    $table_col8 = $row_rsdgrn["rem_per2"];
                }
            }
        }
    }

    $sql_rscbal = "select * from c_bal where REFNO='" . trim($_GET["txtrefno"]) . "'";
    $result_rscbal = mysqli_query($GLOBALS['dbinv'], $sql_rscbal);
    if ($row_rscbal = mysqli_fetch_array($result_rscbal)) {
        if (is_null($row_rscbal["RNO"]) == false) {
            $ResponseXML .= "<txtrno><![CDATA[" . $row_rscbal["RNO"] . "]]></txtrno>";
        }
    }





    $ResponseXML .= "<itemno><![CDATA[" . $table_col1 . "]]></itemno>";
    $ResponseXML .= "<item_name><![CDATA[" . $table_col2 . "]]></item_name>";
    $ResponseXML .= "<partno><![CDATA[" . $table_col3 . "]]></partno>";
    $ResponseXML .= "<rate><![CDATA[" . $table_col4 . "]]></rate>";
    $ResponseXML .= "<qty><![CDATA[" . $table_col5 . "]]></qty>";
    $ResponseXML .= "<discou><![CDATA[" . $table_col6 . "]]></discou>";

    $ResponseXML .= "<refund><![CDATA[" . $table_col8 . "]]></refund>";


    //$table_col7 = $table_col4 * $table_col5 - $table_col4 * $table_col5 * $table_col6 * 0.01;
    //echo $table_col7;
    //$table_col9 = $table_col9 + ($table_col7 * $table_col8 * 0.01);

    $ResponseXML .= "<total><![CDATA[" . $table_col9 . "]]></total>";
    $ResponseXML .= "<txt_net><![CDATA[" . $table_col9 . "]]></txt_net>";

    $sql_crnma = "select * from s_crnma where REF_NO = '" . $_GET["txtrefno"] . "'";
    $result_crnma = mysqli_query($GLOBALS['dbinv'], $sql_crnma);
    $row_crnma = mysqli_fetch_array($result_crnma);

    $table_col4 = str_replace(",", "", $table_col4);
    $table_col6 = str_replace(",", "", $table_col6);
    $table_col8 = str_replace(",", "", $table_col8);

    $subtot = $table_col4 - ($table_col4 * $table_col6 / 100);
    $tot = $subtot * $table_col8 / 100;
    $ResponseXML .= "<subtot><![CDATA[" . number_format($subtot, 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<subtot><![CDATA[" . number_format($tot, 2, ".", ",") . "]]></subtot>";


    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}



if ($_GET["Command"] == "new_inv") {



    require_once("connectioni.php");



    $sql = "Select DGRN from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "00000000" . $row["DGRN"];
    $lenth = strlen($tmpinvno);
    if ($_SESSION['company'] == "BEN") {
        $txtrefno = trim("BDRN/ ") . substr($tmpinvno, $lenth - 9);
    } else if ($_SESSION['company'] == "THT") {
        $txtrefno = trim("DGRN/ ") . substr($tmpinvno, $lenth - 9);
    }
    $_SESSION["invno"] = $txtrefno;



    echo $txtrefno;
}

if ($_GET["Command"] == "setord") {

    include_once("connectioni.php");

    $len = strlen($_GET["salesord1"]);
    $need = substr($_GET["salesord1"], $len - 7, $len);
    $salesord1 = trim("ORD/ ") . $_GET["salesrep"] . trim(" / ") . $need;


    $_SESSION["custno"] = $_GET['custno'];
    $_SESSION["brand"] = $_GET["brand"];
    $_SESSION["department"] = $_GET["department"];

    $sql = mysqli_query($GLOBALS['dbinv'], "DROP VIEW view_s_salma") or die(mysqli_error());
    $sql = mysqli_query($GLOBALS['dbinv'], "CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysqli_error());


    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];


    $ResponseXML .= "<salesord><![CDATA[" . $salesord1 . "]]></salesord>";


    $cuscode = $_GET["custno"];
    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $cuscode . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $OldRefno = "";
        $NewRefNo = "";
        $sql1 = mysqli_query($GLOBALS['dbinv'], "SELECT  * From REF_HISTORY WHERE NewRefNo = '" . $_GET["salesrep"] . "'") or die(mysqli_error());
        if ($row1 = mysqli_fetch_array($sql1)) {
            $OldRefno = trim($row1["OldRefno"]);
            $NewRefNo = trim($row1["NewRefNo"]);
        }

        $OutpDAMT = 0;
        $OutREtAmt = 0;
        $OutInvAmt = 0;



        $sql1 = mysqli_query($GLOBALS['dbinv'], "select * from brand_mas where barnd_name='" . trim($_GET["brand"]) . "'") or die(mysqli_error());

        if ($row1 = mysqli_fetch_array($sql1)) {
            if (is_null($row1["class"]) == false) {
                $InvClass = trim($row1["class"]);
            }
        }

        //////// Total Invoice Amount ///////////////////////////////////////////////////////////////	/						
        if ($NewRefNo == $_GET["salesrep"]) {
            $sqlview = mysqli_query($GLOBALS['dbinv'], "select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='" . trim($cuscode) . "' and (sal_ex='" . $OldRefno . "' or sal_ex='" . trim($_GET["salesrep"]) . "' and class='" . $InvClass . "'") or die(mysqli_error());
        } else {
            $sqlview = mysqli_query($GLOBALS['dbinv'], "select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='" . trim($cuscode) . "' and sal_ex='" . trim($_GET["salesrep"]) . "' and class='" . $InvClass . "'") or die(mysqli_error());
        }

        $rowview = mysqli_fetch_array($sqlview);
        if (is_null($rowview["totout"]) == false) {
            $OutInvAmt = $rowview["totout"];
        }


////////// PD Cheques ////////////////////////////////////////////////////////////////////////////
        if ($NewRefNo == $_GET["salesrep"]) {

            $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_invcheq WHERE che_date>'" . date("Y-m-d") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and (sal_ex='" . $OldRefno . "' or sal_ex='" . trim($_GET["salesrep"]) . "'") or die(mysqli_error());
        } else {

            $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_invcheq WHERE che_date>'" . date("Y-m-d") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . trim($_GET["salesrep"]) . "'") or die(mysqli_error());
        }
        while ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {

            $sqlstr = mysqli_query($GLOBALS['dbinv'], "select * from s_sttr where ST_REFNO='" . trim($rowinvcheq["refno"]) . "' and ST_CHNO ='" . trim($rowinvcheq["cheque_no"]) . "'") or die(mysqli_error());

            while ($rowstr = mysqli_fetch_array($sqlstr)) {
                echo "select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($rowstr["ST_INVONO"]) . "' ";
                $sqltmp = mysqli_query($GLOBALS['dbinv'], "select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($rowstr["ST_INVONO"]) . "' ") or die(mysqli_error());
                if ($rowstmp = mysqli_fetch_array($sqltmp)) {
                    //echo $rowstmp["class"];
                    if (trim($rowstmp["class"] == $InvClass)) {
                        $OutpDAMT = $OutpDAMT + $rowstr["ST_PAID"];
                    }
                }
            }
        }

////////////  Return Settlement PD Cheques////////////////////////////////////////////////////////	 
        $pend_ret_set = 0;
        $sqlview = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM S_INVCHeQ WHERE CHE_DATE >'" . date("Y-m-d") . "' AND CUS_CODE='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
        $rowsview = mysqli_fetch_array($sqlview);
        if (is_null($rowsview["che_amount"]) == false) {
            $pend_ret_set = $rowsview["che_amount"];
        }


//////////// Reurn Cheques////////////////////////////////////// //   /////////////////////////////////
        if ($NewRefNo == $_GET["salesrep"]) {

            $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and (S_REF='" . $_GET["salesrep"] . "' or S_REF='" . $OldRefno . "') ") or die(mysqli_error());
        } else {

            $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='" . $_GET["salesrep"] . "' ") or die(mysqli_error());
        }
        $rowscheq = mysqli_fetch_array($sqlcheq);
        if (is_null($rowscheq["tot"]) == false) {
            $OutREtAmt = $rowscheq["tot"];
        } else {
            $OutREtAmt = 0;
        }


        /* $ResponseXML .= "<sales_table><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
          <tr><td>Outstanding Invoice Amount</td><td>".number_format($OutInvAmt, 2, ".", ",")."</td></tr>
          <td>Return Cheque Amount</td><td>".number_format($OutREtAmt, 2, ".", ",")."</td></tr>
          <td>Pending Cheque Amount</td><td>".number_format($OutpDAMT, 2, ".", ",")."</td></tr>
          <td>PSD Cheque Settlments</td><td>".number_format($pend_ret_set, 2, ".", ",")."</td></tr>
          <td>Total</td><td>".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."</td></tr>
          </table></table>]]></sales_table>"; */


        $ResponseXML .= "<sales_table><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutREtAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutpDAMT, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table>";


        $sqlbrtrn = mysqli_query($GLOBALS['dbinv'], "select * from br_trn where Rep='" . trim($_GET["salesrep"]) . "' and brand='" . $InvClass . "' and cus_code='" . trim($cuscode) . "' ") or die(mysqli_error());
        if ($rowsbrtrn = mysqli_fetch_array($sqlbrtrn)) {
            if (is_null($rowsbrtrn["credit_lim"]) == false) {
                $crLmt = $rowsbrtrn["credit_lim"];
            } else {
                $crLmt = 0;
            }

            if (is_null($rowsbrtrn["tmpLmt"]) == false) {
                $tmpLmt = $rowsbrtrn["tmpLmt"];
            } else {
                $tmpLmt = 0;
            }

            if (is_null($rowsbrtrn["CAT"]) == false) {
                $cuscat = $rowsbrtrn["CAT"];
            }
            if ($cuscat = "A") {
                $m = 2.5;
            }
            if ($cuscat = "B") {
                $m = 2.5;
            }
            if ($cuscat = "C") {
                $m = 1;
            }

            $txt_crelimi = "0";
            $txt_crebal = "0";

            $txt_crelimi = number_format($crLmt, 2, ".", ",");

            $txt_crebal = number_format($crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set, 2, ".", ",");


            $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
            $ResponseXML .= "<txt_crebal><![CDATA[" . $txt_crebal . "]]></txt_crebal>";
        } else {
            $ResponseXML .= "<txt_crelimi><![CDATA[0.00]]></txt_crelimi>";
            $ResponseXML .= "<txt_crebal><![CDATA[0.00]]></txt_crebal>";
        }

        $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;





        $sql = mysqli_query($GLOBALS['dbinv'], "select dis from brand_mas where barnd_name = '" . trim($_GET["brand"]) . "'") or die(mysqli_error());
        if ($row = mysqli_fetch_array($sql)) {
            $ResponseXML .= "<dis><![CDATA[" . $row["dis"] . "]]></dis>";
        }
    }


    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "cancel_inv") {

    include('connectioni.php');

    $sql_status = 0;

    mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
    mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");

    $sqlinv = "select * from c_bal where REFNO='" . $_GET['txtrefno'] . "' and AMOUNT=BALANCE";
    $resultinv = mysqli_query($GLOBALS['dbinv'], $sqlinv);
    if ($rowinv = mysqli_fetch_array($resultinv)) {

        if (date("Y-m") !== date("Y-m", strtotime($rowinv["SDATE"]))) {
            echo 'Not in Current Month Can not Cancel';
            exit();
        }

        $sql = "UPDATE  s_crnma SET CANCELL='1' where REF_NO='" . $_GET['txtrefno'] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        $sql = "UPDATE  s_deftrn SET CANCELL='1' where REFNO='" . $_GET['txtrefno'] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        $sql = "DELETE   FROM c_bal WHERE REFNO='" . $_GET['txtrefno'] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        $sql = "update vendor set CUR_BAL= CUR_BAL+" . $rowinv["AMOUNT"] . " where CODE='" . trim($_GET["txt_cuscode"]) . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        $sql = "DELETE   FROM s_led WHERE REF_NO='" . $_GET['txtrefno'] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        $sql = "update br_trn set credit= credit + " . $rowinv["AMOUNT"] . " where cus_code='" . trim($_GET["txt_cuscode"]) . "' AND Rep='" . trim($_GET["Com_rep"]) . "' ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        $sql = "update c_clamas set DGRN_NO = '0' where DGRN_NO = '" . $_GET['txtrefno'] . "' ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        $sql = "update c_clamas set DGRN_NO2 = '0' where DGRN_NO2 = '" . $_GET['txtrefno'] . "' ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        $sql = "update c_clamas set DGRN_NO3 = '0' where DGRN_NO3 = '" . $_GET['txtrefno'] . "' ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        $sql = "Update c_clamas set Amount = Amount - " . $rowinv["AMOUNT"] . "  where refno = '" . $_GET['def_no'] . "' ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        $sql = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values
			('" . trim($_GET["def_no"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Item Claim', 'Delete', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $result1 = mysql_query($sql, $dbinv);

        $sql23 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values
			('" . trim($_GET["txtrefno"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Defective Items2', 'Delete', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $result123 = mysql_query($sql23, $dbinv);

        if ($sql_status == 0) {
            mysqli_query($GLOBALS['dbinv'], "COMMIT");
            echo "Canceled";
        } else {
            mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
            echo "Error has occures. Can't Cancel";
        }
    } else {
        echo "Cant Cancel";
    }
}


if ($_GET["Command"] == "add_tmp") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_ord_data where str_code='" . $_GET['itemcode'] . "' and str_invno='" . $_GET['invno'] . "' ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    //echo $_GET['rate'];
    //echo $_GET['qty'];
    $rate = str_replace(",", "", $_GET["rate"]);
    $qty = str_replace(",", "", $_GET["qty"]);
    $discount = str_replace(",", "", $_GET["discount"]);
    $subtotal = str_replace(",", "", $_GET["subtotal"]);

    $sql = "Insert into tmp_ord_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand)values 
			('" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', " . $rate . ", " . $qty . ", " . $_GET["discountper"] . ", " . $discount . ", " . $subtotal . ", '" . $_GET["brand"] . "') ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);


    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							  <td></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";


    $sql = "Select * from tmp_ord_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td >" . $row['str_code'] . "</a></td>
							 <td >" . $row['str_description'] . "</a></td>
							 <td >" . number_format($row['cur_rate'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['cur_qty'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($_GET["discountper"], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['cur_subtot'], 2, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>";

        include_once("connectioni.php");

        $sqlqty = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'") or die(mysqli_error());
        if ($rowqty = mysqli_fetch_array($sqlqty)) {
            $qty = $rowqty['QTYINHAND'];
        } else {
            $qty = 0;
        }

        $ResponseXML .= "<td >" . $qty . "</a></td>
						
                            </tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

    $sql_invpara = "SELECT * from invpara";
    $row_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
    $row_invpara = mysqli_fetch_array($result_invpara);

    $vatrate = $row_invpara["vatrate"] / 100;

    //$vatrate=0.12;

    if ($_GET["vatmethod"] == "vat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "non") {
        //$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
        $ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";

        $invtot = number_format($row['tot_sub'], 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    }

    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}




if ($_GET["Command"] == "delete_inv") {
    $sql = "select * from S_CUSORDMAS where REF_NO= '" . trim($_GET["salesord1"]) . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $sql1 = "UPDATE S_CUSORDMAS SET S_CUSORDMAS.CANCELL = '1' WHERE (((S_CUSORDMAS.REF_NO)='" . trim($_GET["salesord1"]) . "'))";

        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql1 = "UPDATE S_CUSORDTRN SET S_CUSORDTRN.CANCELL = '1' WHERE (((S_CUSORDTRN.REF_NO)='" . trim($_GET["salesord1"]) . "'))";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }
    echo "Canceled";
}


if ($_GET["Command"] == "del_item") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_ord_data where str_code='" . $_GET['code'] . "' and str_invno='" . $_GET['invno'] . "' ";
    //echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";


    $sql = "Select * from tmp_ord_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >" . $row['str_code'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . $row['str_description'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . $row['cur_rate'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . $row['cur_qty'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . $row['cur_discount'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . $row['cur_subtot'] . "</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>";

        include_once("connectioni.php");

        $sqlqty = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'") or die(mysqli_error());
        if ($rowqty = mysqli_fetch_array($sqlqty)) {
            $qty = $rowqty['QTYINHAND'];
        } else {
            $qty = 0;
        }

        $ResponseXML .= "<td bgcolor=\"#222222\" >" . $qty . "</a></td>
                            </tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

    $vatrate = 0.08;

    if ($_GET["vatmethod"] == "vat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "non") {
        //$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
        $ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";

        $invtot = number_format($row['tot_sub'], 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    }

    $ResponseXML .= "   </salesdetails>";

    //	}	


    echo $ResponseXML;
}



if ($_GET["Command"] == "save_item") {


    $_SESSION["CURRENT_DOC"] = 1;      //document ID
    $_SESSION["VIEW_DOC"] = false;     //view current document
    $_SESSION["FEED_DOC"] = true;       //save  current document
    $_GET["MOD_DOC"] = false;         //delete   current document
    $_GET["PRINT_DOC"] = false;       //get additional print   of  current document
    $_GET["PRICE_EDIT"] = false;       //edit selling price
    $_GET["CHECK_USER"] = false;       //check user permission again
    //$subtot = ($_GET["rate"] * $_GET["qty"]) - ($_GET["rate"] * $_GET["qty"] * $_GET["discou"] * 0.01);
    //$tot = $tot + ($subtot * $_GET["refund"] * 0.01);
    include('connectioni.php');

    $sqltmp = "select * from invpara";
    $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);
    $rowtmp = mysqli_fetch_array($resulttmp);

    if ($rowtmp["form_loc"] == "1") {
        exit("no");
    }

    $sql_status = 0;

    mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
    mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");

    $sql_ex = "Select * from s_crnma where REF_NO='" . $_GET["txtrefno"] . "'";
    $result_ex = mysqli_query($GLOBALS['dbinv'], $sql_ex);
    if ($row_ex = mysqli_fetch_array($result_ex)) {
        echo "Refno already exists ";
    } else {
        $sql3 = "select BRAND_NAME,class from view_brand_smas where STK_NO='" . $_GET["itemno"] . "'";
        $result3 = mysqli_query($GLOBALS['dbinv'], $sql3);
        $row3 = mysqli_fetch_array($result3);

        $sql_invpara = "SELECT * from invpara";
        $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
        $row_invpara = mysqli_fetch_array($result_invpara);

        $mvatrate = $row_invpara["vatrate"];
        $minv = "";
        $date = strtotime($_GET["dtdate"] . ' -3 months');
        $date = date('Y-m-d', $date);
        $sql = "select * from view_salma_invo_smas where  brand = '" . $row3['BRAND_NAME'] . "' and sdate <='" . $_GET["dtdate"] . "' and c_code = '" . $_GET["txt_cuscode"] . "' and sdate <='" . $_GET["dtdate"] . "' and sdate >='" . $date . "' order by id";
        $result_g1 = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row_g1 = mysqli_fetch_array($result_g1)) {

            $mvatrate = $row_g1["GST"];
            $minv = $row_g1['REF_NO'];
        } else {
            $sql = "select * from view_salma_invo_smas where c_code = '" . $_GET["txt_cuscode"] . "' and sdate <='" . $_GET["dtdate"] . "' and sdate <='" . $_GET["dtdate"] . "' and sdate >='" . $date . "' order by id";
            $result_g1 = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_g1 = mysqli_fetch_array($result_g1)) {
                $minv = $row_g1['REF_NO'];
                $mvatrate = $row_g1["GST"];
            }
        }




        //$mvatrate=11;

        $sql = "insert into s_crnma(REF_NO, DDATE, SAL_EX, Brand, C_CODE, CUS_NAME, GRAND_TOT, DEPARTMENT, DEP_CODE, vatrate,sdate1) values ('" . $_GET["txtrefno"] . "', '" . $_GET["dtdate"] . "', '" . $_GET["Com_rep"] . "', '" . $row3["BRAND_NAME"] . "', '" . $_GET["txt_cuscode"] . "', '" . $_GET["txt_cusname"] . "', '" . $_GET["txt_net"] . "', '" . $_GET["com_dep"] . "', '" . $_GET["com_dep"] . "', '" . $mvatrate . "','" . $_GET["dtdate"] . "')";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result == false) {
            $sql_status = 1;
        }


        $mflag1 = 0;
        if ($row3['class'] == "BATTERY") {
            //$mflag1 = "2";
        }

        $sqlrep = "select * from s_salrep where REPCODE = '" . trim($_GET["Com_rep"]) . "'";
        $resultrep = mysqli_query($GLOBALS['dbinv'], $sqlrep);
        if ($rowrep = mysqli_fetch_array($resultrep)) {
            $maindepart = $rowrep['RGROUP1'];
        } else {
            $maindepart = "";
        }

        $sql = "Insert into c_bal (REFNO, SDATE, CUSCODE, AMOUNT, BALANCE, DEP, SAL_EX, brand, trn_type, DEV, vatrate, RNO ,costcenter,flag1,c_code1,active,maindepartment,sdate1) values('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . trim($_GET["txt_cuscode"]) . "', " . $_GET["txt_net"] . ", " . $_GET["txt_net"] . ", '" . $_GET["com_dep"] . "', '" . $_GET["Com_rep"] . "', '" . $row3["BRAND_NAME"] . "', 'DGRN', '" . $_SESSION['dev'] . "', '" . $mvatrate . "', '" . trim($_GET["txtrno"]) . "','" . $minv . "','" . $mflag1 . "','" . $_GET['c_subcode'] . "','2','" . $maindepart . "','" . $_GET["dtdate"] . "')";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result == false) {
            $sql_status = 2;
            echo $sql;
            echo mysqli_error($GLOBALS['dbinv']);
        }




        if ($_GET["discou"] == "") {
            $discou = 0;
        } else {
            $discou = $_GET["discou"];
        }

        if ($_GET["refund"] == "") {
            $refund = 0;
        } else {
            $refund = $_GET["refund"];
        }

        $rate = str_replace(",", "", $_GET["rate"]);

        $sql_fr_clm = "Select * from  c_clamas where refno = '" . $_GET["def_no"] . "'";
        $result_fr_clm = mysqli_query($GLOBALS['dbinv'], $sql_fr_clm);
        $row_fr_clm = mysqli_fetch_array($result_fr_clm);

        $sql = "Insert into s_deftrn (REFNO, STK_NO, SDATE, BAT_NO, CLAM_NO, REsult, qty, Remarks, AMOUNT, dis, c_code, DEP, SAL_EX, arno, ref_per, cl_no, approve_md_wd,sdate1) values('" . trim($_GET["txtrefno"]) . "', '" . $_GET["itemno"] . "', '" . trim($_GET["dtdate"]) . "', '" . $_GET["txtbat"] . "', '" . $_GET["txtcl_no"] . "', '" . $_GET["Cmbres"] . "', '" . $_GET["qty"] . "', '" . $_GET["txtremark"] . "', " . $rate . ", " . $discou . ", '" . $_GET["txt_cuscode"] . "', '" . trim($_GET["com_dep"]) . "', '" . trim($_GET["Com_rep"]) . "', '" . trim($_GET["cmbShip"]) . "', " . $refund . ", '" . $_GET["cl_no1"] . "', '" . $row_fr_clm["approve_md_wd"] . "','" . $_GET["dtdate"] . "')";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result == false) {
            $sql_status = 3;
        }

        if (date("m", strtotime($_GET["dtdate"])) == 1) {
            $sql = "update s_mas set SALE01= SALE01-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 4;
            }
        }
        if (date("m", strtotime($_GET["dtdate"])) == 2) {
            $sql = "update s_mas set SALE02= SALE02-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 5;
            }
        }
        if (date("m", strtotime($_GET["dtdate"])) == 3) {
            $sql = "update s_mas set SALE03= SALE03-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 6;
            }
        }
        if (date("m", strtotime($_GET["dtdate"])) == 4) {
            $sql = "update s_mas set SALE04= SALE04-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 7;
            }
        }
        if (date("m", strtotime($_GET["dtdate"])) == 5) {
            $sql = "update s_mas set SALE05= SALE05-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 8;
            }
        }
        if (date("m", strtotime($_GET["dtdate"])) == 6) {
            $sql = "update s_mas set SALE06= SALE06-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 9;
            }
        }
        if (date("m", strtotime($_GET["dtdate"])) == 7) {
            $sql = "update s_mas set SALE07= SALE07-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 10;
            }
        }
        if (date("m", strtotime($_GET["dtdate"])) == 8) {
            $sql = "update s_mas set SALE08= SALE08-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 11;
            }
        }

        if (date("m", strtotime($_GET["dtdate"])) == 9) {
            $sql = "update s_mas set SALE09= SALE09-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 12;
            }
        }

        if (date("m", strtotime($_GET["dtdate"])) == 10) {
            $sql = "update s_mas set SALE10= SALE10-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 13;
            }
        }

        if (date("m", strtotime($_GET["dtdate"])) == 11) {
            $sql = "update s_mas set SALE11= SALE11-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 14;
            }
        }

        if (date("m", strtotime($_GET["dtdate"])) == 12) {
            $sql = "update s_mas set SALE12= SALE12-" . $_GET["qty"] . " where STK_NO='" . $_GET["itemno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 15;
            }
        }



        //===============Update customer Ledger======
        $rss_led = "SELECT * FROM s_led WHERE REF_NO='" . $_GET["txtrefno"] . "'";
        $result_led = mysqli_query($GLOBALS['dbinv'], $rss_led);

        if ($row_led = mysqli_fetch_array($result_led)) {
            
        } else {
            $sql = "insert into s_led (REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT) values ('" . $_GET["txtrefno"] . "', '" . $_GET["dtdate"] . "', '" . $_GET["txt_cuscode"] . "', '" . $_GET["txt_net"] . "', 'DGRN', '" . $_GET["com_dep"] . "')";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 16;
            }
        }

        //==============update credit limit==========================================

        $sql = "update vendor set CUR_BAL= CUR_BAL-" . $_GET["txt_net"] . " where CODE='" . $_GET["txt_cuscode"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result == false) {
            $sql_status = 17;
        }

        $sql = "update br_trn set credit= credit- " . $_GET["txt_net"] . " where cus_code='" . $_GET["txt_cuscode"] . "' AND Rep='" . $_GET["Com_rep"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result == false) {
            $sql_status = 18;
        }

        $sql = "update invpara set DGRN= DGRN+1";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result == false) {
            $sql_status = 19;
        }

        $sql = "update invpara set rno= rno+1";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result == false) {
            $sql_status = 20;
        }



        //===================update DGRN Form =========================================

        $sql_fr_clm = "Select * from  c_clamas where refno = '" . $_GET["def_no"] . "'";
        $result_fr_clm = mysqli_query($GLOBALS['dbinv'], $sql_fr_clm);

        if ($row_fr_clm = mysqli_fetch_array($result_fr_clm)) {
            //echo "DGRN_NO:".$row_fr_clm["DGRN_NO"];
            if (trim($row_fr_clm["DGRN_NO"]) == "0") {
                $sql = "Update c_clamas set DGRN_NO = '" . $_GET["txtrefno"] . "', ref_per = '" . $_GET["refund"] . "', CRE_date='" . $_GET["dtdate"] . "'  where refno = '" . $_GET["def_no"] . "'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($result == false) {
                    $sql_status = 21;
                }
            }

            if (trim($row_fr_clm["DGRN_NO2"]) == "0") {
                if (is_null($row_fr_clm["add_ref1"]) == false) {
                    if ($row_fr_clm["add_ref1"] > 0) {
                        $sql = "Update c_clamas set DGRN_NO2 = '" . $_GET["txtrefno"] . "', add_ref1 = '" . $_GET["refund"] . "'  where refno = '" . $_GET["def_no"] . "'";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        if ($result == false) {
                            $sql_status = 22;
                        }
                    }
                }
            }
            if (trim($row_fr_clm["DGRN_NO3"]) == "0") {
                if (is_null($row_fr_clm["add_ref2"]) == false) {
                    if ($row_fr_clm["add_ref2"] > 0) {
                        $sql = "Update c_clamas set DGRN_NO3 = '" . $_GET["txtrefno"] . "', add_ref2 = '" . $_GET["refund"] . "'  where refno = '" . $_GET["def_no"] . "'";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        if ($result == false) {
                            $sql_status = 23;
                        }
                    }
                }
            }

            $sql = "Update c_clamas set Amount = Amount + " . $_GET["txt_net"] . "  where refno = '" . trim($_GET["def_no"]) . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($result == false) {
                $sql_status = 24;
            }
        }

        if ($sql_status == 0) {
            mysqli_query($GLOBALS['dbinv'], "COMMIT");
            echo "Saved";
        } else {
            mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
            echo "Error has occured. Can't Saved" . $sql_status;
        }
    }
}

if ($_GET["Command"] == "check_print") {

    echo $_SESSION["print"];
}


if ($_GET["Command"] == "tmp_crelimit") {
    echo "abc";
    $crLmt = 0;
    $cat = "";

    $rep = trim(substr($_GET["Com_rep1"], 0, 5));

    $sql = "select * from br_trn where rep='" . $rep . "' and cus_code='" . trim($_GET["txt_cuscode"]) . "' and brand='" . trim($_GET["cmbbrand1"]) . "'";
    echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $crLmt = $row["credit_lim"];
        If (is_null($row["cat"]) == false) {
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
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;

      $sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      if ($row = mysqli_fetch_array($result)) {
      $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
      $resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);

      } else {

      $sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
      $resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);

      //	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
      }

      If ($_GET["Check1"] == 1) {
      $sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
      $resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
      } else {
      $sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
      $resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
      }

      echo "Tempory limit updated"; */
}

if ($_GET["Command"] == "approve1") {

    $sqlblack = "update s_deftrn set approve= '1' , approve_by='" . $_SESSION["CURRENT_USER"] . "' ,ap_datetime='" . date("Y-m-d H:i:s") . "'   where REFNO='" . $_GET["txtrefno"] . "' ";
    $resultblack = mysqli_query($GLOBALS['dbinv'], $sqlblack);

    $sqlblack1 = "update c_bal set active= '0' where REFNO='" . $_GET["txtrefno"] . "' ";
    $resultblack1 = mysqli_query($GLOBALS['dbinv'], $sqlblack1);

    echo 'Approved';
}

if ($_GET["Command"] == "SetListNameapprove") {

    echo "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">REF No</font></td>
                              <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Customer</font></td>
                               <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                               <td width=\"206\"  background=\"\"><font color=\"#FFFFFF\">Remark</font></td>
                               <td width=\"146\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
                               <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
                               <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Refund</font></td>
                               <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Total</font></td>
                               <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Approve</font></td>
   </tr>";


    require_once("connectioni.php");

    //$sql="select REFNO, BAT_NO, CLAM_NO, SDATE  from s_deftrn where REFNO like '" & txtcode.Text & "%' and CANCELL='0' ORDER BY REFNO"
    //$sql="SELECT * FROM s_crnma where CANCELL='0' order by REF_NO desc";

    if ($_GET["mstatus"] == "invno") {
        $sql = "select * from view_s_deftrn_vender where  CANCELL='0' and approve='0' and REFNO like '" . $_GET["invno"] . "%' ORDER BY SDATE desc limit 50";
    } else {
        $sql = "select * from view_s_deftrn_vender where  CANCELL='0' and approve='0' and CLAM_NO like '" . $_GET["customername"] . "%' ORDER BY SDATE desc limit 50";
    }
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        echo "<tr>               
                              <td onclick=\"approve('" . $row['REFNO'] . "');\">" . $row['REFNO'] . "</a></td>
                                <td onclick=\"approve('" . $row['REFNO'] . "');\">" . $row['NAME'] . "</a></td>
                                 <td onclick=\"approve('" . $row['REFNO'] . "');\">" . $row['DESCRIPT'] . "</a></td>
                                <td onclick=\"approve('" . $row['REFNO'] . "');\">" . $row['Remarks'] . "</a></td>
                                 <td onclick=\"approve('" . $row['REFNO'] . "');\">" . $row['AMOUNT'] . "</a></td>
                                 <td onclick=\"approve('" . $row['REFNO'] . "');\">" . $row['dis'] . "</a></td>
                                 <td onclick=\"approve('" . $row['REFNO'] . "');\">" . $row['ref_per'] . "</a></td>
                                 <td onclick=\"approve('" . $row['REFNO'] . "');\">" . $row['ref_per'] . "</a></td>
                                 <td onclick=\"approve('" . $row['REFNO'] . "');\"><button>Approve</button><button>Reject</button></a></td>
                            </tr>";
    }

    echo "</table>";
}

if ($_GET["Command"] == "denie") {

    $sqlblack1 = "update s_deftrn set denie= '1' where REFNO='" . $_GET["txtrefno"] . "' ";
//    echo $sqlblack1;
    $resultblack1 = mysqli_query($GLOBALS['dbinv'], $sqlblack1);
}

if ($_GET["Command"] == "hide") {
    include_once("connectioni.php");
    $sql = "select * from  s_deftrn where REFNO='" . trim($_GET["invno"]) . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    if ($row = mysqli_fetch_array($result)) {

        $sqlblack = "update s_deftrn set hide= '1'  where REFNO='" . trim($_GET["invno"]) . "' ";
        $result = mysqli_query($GLOBALS['dbinv'], $sqlblack);

        echo "Hide Sucessfully..";
    }
}
?>