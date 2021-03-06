<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connectioni.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "display") {

    $rep = $_GET["Com_rep"];
    $depart = $_GET["com_dep"];

    $sqlt = "delete from tempreg where user_nm = '" . $_SESSION["CURRENT_USER"] . "'";
    $resultt = mysqli_query($GLOBALS['dbinv'], $sqlt);
    if ($_GET["Check2"] == "ch") {
        if (($_GET["Check1"] == "true") and ( trim($_GET["txt_cuscode"]) != "")) {

            if (trim($_GET["com_dep"]) == "All") {
                if (trim($_GET["Com_rep"]) == "All") {

                    if ($_SESSION['dev'] == "1") {
                        $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and c_code1='" . $_GET["txt_cuscode"] . "' ";
                        $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0' and c_code1='" . $_GET["txt_cuscode"] . "' AND trn_type<>'ARN' and trn_type<>'REC' ";
                    } else {
                        $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and c_code1='" . $_GET["txt_cuscode"] . "' and DEV='" . $_SESSION['dev'] . "' ";
                        $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0' and c_code1='" . $_GET["txt_cuscode"] . "' AND trn_type<>'ARN' and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "'  ";
                    }
                } else {

                    if ($_SESSION['dev'] == "1") {
                        $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "' and c_code1='" . $_GET["txt_cuscode"] . "'  ";
                        $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "' and c_code1='" . $_GET["txt_cuscode"] . "'AND trn_type<>'ARN' and trn_type<>'REC' ";
                    } else {
                        $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "' and c_code1='" . $_GET["txt_cuscode"] . "' and DEV='" . $_SESSION['dev'] . "' ";
                        $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "' and c_code1='" . $_GET["txt_cuscode"] . "'AND trn_type<>'ARN' and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "' ";
                    }
                }
            } else if (trim($_GET["Com_rep"]) == "All") {

                if ($_SESSION['dev'] == "1") {
                    $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "' and c_code1='" . $_GET["txt_cuscode"] . "' ";
                    $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and  DEP  = '" . $depart . "' and c_code1='" . $_GET["txt_cuscode"] . "' AND trn_type<>'ARN'and trn_type<>'REC' ";
                } else {
                    $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "' and c_code1='" . $_GET["txt_cuscode"] . "'and DEV='" . $_SESSION['dev'] . "' ";
                    $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and  DEP  = '" . $depart . "' and c_code1='" . $_GET["txt_cuscode"] . "' AND trn_type<>'ARN'and trn_type<>'REC'and DEV='" . $_SESSION['dev'] . "' ";
                }
            } else {

                if ($_SESSION['dev'] == "1") {
                    $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "'and SAL_EX = '" . $rep . "' and c_code1='" . $_GET["txt_cuscode"] . "' ";
                    $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and  DEP  = '" . $depart . "'and SAL_EX = '" . $rep . "' and c_code1='" . $_GET["txt_cuscode"] . "'AND trn_type<>'ARN' and trn_type<>'REC' ";
                } else {
                    $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "'and SAL_EX = '" . $rep . "' and c_code1='" . $_GET["txt_cuscode"] . "' and DEV='" . $_SESSION['dev'] . "' ";
                    $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and  DEP  = '" . $depart . "'and SAL_EX = '" . $rep . "' and c_code1='" . $_GET["txt_cuscode"] . "'AND trn_type<>'ARN' and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "' ";
                }
            }
        } else {
            if (trim($_GET["com_dep"]) == "All") {
                if (trim($_GET["Com_rep"]) == "All") {

                    if ($_SESSION['dev'] == "1") {
                        $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0' ";
                        $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'AND trn_type<>'ARN'and trn_type<>'REC' ";
                    } else {
                        $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEV='" . $_SESSION['dev'] . "' ";
                        $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'AND trn_type<>'ARN'and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "' ";
                    }
                } else {

                    if ($_SESSION['dev'] == "1") {
                        $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "' ";
                        $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "'AND trn_type<>'ARN'and trn_type<>'REC' ";
                    } else {
                        $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "' and DEV='" . $_SESSION['dev'] . "' ";
                        $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "'AND trn_type<>'ARN'and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "' ";
                    }
                }
            } else if (trim($_GET["Com_rep"]) == "All") {

                if ($_SESSION['dev'] == "1") {
                    $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "' ";
                    $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEP = '" . $depart . "' AND trn_type<>'ARN' and trn_type<>'REC' ";
                } else {
                    $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "' and DEV='" . $_SESSION['dev'] . "' ";
                    $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEP = '" . $depart . "' AND trn_type<>'ARN' and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "' ";
                }
            } else {

                if ($_SESSION['dev'] == "1") {
                    $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "'and SAL_EX = '" . $rep . "'";
                    $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and  DEP  = '" . $depart . "'and SAL_EX = '" . $rep . "'AND trn_type<>'ARN' and trn_type<>'REC' ";
                } else {
                    $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "'and SAL_EX = '" . $rep . "' and DEV='" . $_SESSION['dev'] . "' ";
                    $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and  DEP  = '" . $depart . "'and SAL_EX = '" . $rep . "'AND trn_type<>'ARN' and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "'";
                }
            }
        }
    } else if ($_GET["Check2"] == "nch") {
        if (($_GET["Check1"] == "true") and ( trim($_GET["txt_cuscode"]) != "")) {
            if (trim($_GET["com_dep"]) == "All") {
                if (trim($_GET["Com_rep"]) == "All") {

                    if ($_SESSION['dev'] == "1") {
                        $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and C_CODE='" . $_GET["txt_cuscode"] . "' ";
                        $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0' and CUSCODE='" . $_GET["txt_cuscode"] . "' AND trn_type<>'ARN' and trn_type<>'REC' ";
                    } else {
                        $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and C_CODE='" . $_GET["txt_cuscode"] . "' and DEV='" . $_SESSION['dev'] . "' ";
                        $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0' and CUSCODE='" . $_GET["txt_cuscode"] . "' AND trn_type<>'ARN' and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "'  ";
                    }
                } else {

                    if ($_SESSION['dev'] == "1") {
                        $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "' and C_CODE='" . $_GET["txt_cuscode"] . "'  ";
                        $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "' and CUSCODE='" . $_GET["txt_cuscode"] . "'AND trn_type<>'ARN' and trn_type<>'REC' ";
                    } else {
                        $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "' and C_CODE='" . $_GET["txt_cuscode"] . "' and DEV='" . $_SESSION['dev'] . "' ";
                        $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "' and CUSCODE='" . $_GET["txt_cuscode"] . "'AND trn_type<>'ARN' and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "' ";
                    }
                }
            } else if (trim($_GET["Com_rep"]) == "All") {

                if ($_SESSION['dev'] == "1") {
                    $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "' and C_CODE='" . $_GET["txt_cuscode"] . "' ";
                    $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and  DEP  = '" . $depart . "' and CUSCODE='" . $_GET["txt_cuscode"] . "' AND trn_type<>'ARN'and trn_type<>'REC' ";
                } else {
                    $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "' and C_CODE='" . $_GET["txt_cuscode"] . "'and DEV='" . $_SESSION['dev'] . "' ";
                    $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and  DEP  = '" . $depart . "' and CUSCODE='" . $_GET["txt_cuscode"] . "' AND trn_type<>'ARN'and trn_type<>'REC'and DEV='" . $_SESSION['dev'] . "' ";
                }
            } else {

                if ($_SESSION['dev'] == "1") {
                    $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "'and SAL_EX = '" . $rep . "' and C_CODE='" . $_GET["txt_cuscode"] . "' ";
                    $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and  DEP  = '" . $depart . "'and SAL_EX = '" . $rep . "' and CUSCODE='" . $_GET["txt_cuscode"] . "'AND trn_type<>'ARN' and trn_type<>'REC' ";
                } else {
                    $sql = "select SDATE, REF_NO, CUS_NAME, TYPE, GRAND_TOT, TOTPAY, DEPARTMENT, SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "'and SAL_EX = '" . $rep . "' and C_CODE='" . $_GET["txt_cuscode"] . "' and DEV='" . $_SESSION['dev'] . "' ";
                    $sqlstr = "select * from c_bal where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and  DEP  = '" . $depart . "'and SAL_EX = '" . $rep . "' and CUSCODE='" . $_GET["txt_cuscode"] . "'AND trn_type<>'ARN' and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "' ";
                }
            }
        } else {
            if (trim($_GET["com_dep"]) == "All") {
                if (trim($_GET["Com_rep"]) == "All") {

                    if ($_SESSION['dev'] == "1") {
                        $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0' ";
                        $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'AND trn_type<>'ARN'and trn_type<>'REC' ";
                    } else {
                        $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEV='" . $_SESSION['dev'] . "' ";
                        $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'AND trn_type<>'ARN'and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "' ";
                    }
                } else {

                    if ($_SESSION['dev'] == "1") {
                        $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "' ";
                        $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "'AND trn_type<>'ARN'and trn_type<>'REC' ";
                    } else {
                        $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "' and DEV='" . $_SESSION['dev'] . "' ";
                        $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and SAL_EX = '" . $rep . "'AND trn_type<>'ARN'and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "' ";
                    }
                }
            } else if (trim($_GET["Com_rep"]) == "All") {

                if ($_SESSION['dev'] == "1") {
                    $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "' ";
                    $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEP = '" . $depart . "' AND trn_type<>'ARN' and trn_type<>'REC' ";
                } else {
                    $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "' and DEV='" . $_SESSION['dev'] . "' ";
                    $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEP = '" . $depart . "' AND trn_type<>'ARN' and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "' ";
                }
            } else {

                if ($_SESSION['dev'] == "1") {
                    $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "'and SAL_EX = '" . $rep . "'";
                    $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and  DEP  = '" . $depart . "'and SAL_EX = '" . $rep . "'AND trn_type<>'ARN' and trn_type<>'REC' ";
                } else {
                    $sql = "select SDATE,REF_NO,CUS_NAME,TYPE,GRAND_TOT,TOTPAY,DEPARTMENT,SAL_EX,c_code1 from s_salma where (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and DEPARTMENT = '" . $depart . "'and SAL_EX = '" . $rep . "' and DEV='" . $_SESSION['dev'] . "' ";
                    $sqlstr = "select * from c_bal where ( SDATE<'" . $_GET["dtto"] . "' or  SDATE='" . $_GET["dtto"] . "') and ( SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and CANCELL='0'and  DEP  = '" . $depart . "'and SAL_EX = '" . $rep . "'AND trn_type<>'ARN' and trn_type<>'REC' and DEV='" . $_SESSION['dev'] . "'";
                }
            }
        }
    }



    if (trim($_GET["brand"] != "All")) {
        $sql = $sql . " and brand = '" . $_GET["brand"] . "'";
        $sqlstr = $sqlstr . " and brand = '" . $_GET["brand"] . "'";
    }

    $result_sql = mysqli_query($GLOBALS['dbinv'], $sql);

    $result_cbal = mysqli_query($GLOBALS['dbinv'], $sqlstr);

    $invtot = 0;
    $rettot = 0;
    $paidtot = 0;
    while ($rssalma = mysqli_fetch_array($result_sql)) {
        if ($_GET['inv_type'] == "All" or $_GET['inv_type'] == "INV") {
            $invtot = $invtot + $rssalma["GRAND_TOT"];
            $paidtot = $paidtot + $rssalma["TOTPAY"];

            $usr[] = "('" . $rssalma["REF_NO"] . "', '" . $rssalma["SDATE"] . "', '" . $rssalma["CUS_NAME"] . "', '" . $rssalma["GRAND_TOT"] . "', '" . $rssalma["TOTPAY"] . "', '" . $rssalma["DEPARTMENT"] . "', '" . $rssalma["SAL_EX"] . "', 'INV','" . $_SESSION["CURRENT_USER"] . "','" . $rssalma["c_code1"] . "')";
        }
    }
    if (isset($usr)) {
        $temp = "insert into tempreg(REFNO, SDATE, cus_name, AMOUNT, BALANCE, dep, SAL_EX, TRN_TYPE,user_nm,c_code1) values  " . implode($usr, ",");
        $result_temp = mysqli_query($GLOBALS['dbinv'], $temp);
    }
    while ($cbal = mysqli_fetch_array($result_cbal)) {
        if ($_GET['inv_type'] == "All" or $_GET['inv_type'] == $cbal["trn_type"]) {
            if (trim($cbal["c_code1"] <> "")) {
                $sql_rst = "SELECT c_name as NAME FROM vender_sub WHERE c_code='" . trim($cbal["c_code1"]) . "'";
            } else {
                $sql_rst = "SELECT NAME FROM vendor WHERE CODE='" . trim($cbal["CUSCODE"]) . "'";
            }
            $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);

            $rs_rst = mysqli_fetch_array($result_rst);


            if (date("Y", strtotime($cbal["SDATE"])) < 2008) {
                $BALANCE = $cbal["AMOUNT"];
            } else {
                $BALANCE = $cbal["AMOUNT"] - $cbal["BALANCE"];
            }

            $rettot = $rettot + $cbal["AMOUNT"];

            $usr1[] = "('" . $cbal["REFNO"] . "', '" . $cbal["SDATE"] . "', '" . $rs_rst["NAME"] . "', '" . $cbal["AMOUNT"] . "', '" . $BALANCE . "', '" . $cbal["DEP"] . "', '" . $cbal["SAL_EX"] . "', '" . $cbal["trn_type"] . "','" . $_SESSION["CURRENT_USER"] . "','" . $cbal["c_code1"] . "')";
        }
    }

    if (isset($usr1)) {
        $temp = "insert into tempreg(REFNO, SDATE, cus_name, AMOUNT, BALANCE, dep, SAL_EX, TRN_TYPE,user_nm,c_code1) values " . implode(",", $usr1);
        $result_temp = mysqli_query($GLOBALS['dbinv'], $temp);
    }

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cus Code</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rep</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Total Pay</font></td>
							  
                            </tr>";

    $sql_rst = "select * from tempreg where user_nm = '" . $_SESSION["CURRENT_USER"] . "' order by SDATE";
    $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);

    while ($rstemp = mysqli_fetch_array($result_rst)) {

        if ($rstemp['TRN_TYPE'] == "INV") {

            $ResponseXML .= "<tr>                              
                             <td><a href=\"\" class=\"INV\" onClick=\"NewWindow('sales_inv_display.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"> " . $rstemp['SDATE'] . "</a></td>
                                                         <td><span class=\"INV\">" . $rstemp['c_code1'] . "</span></td>  
							 <td><a href=\"\" class=\"INV\" onClick=\"NewWindow('sales_inv_display.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"> " . $rstemp['REFNO'] . "</a></td>
							 <td><a href=\"\" class=\"INV\" onClick=\"NewWindow('sales_inv_display.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"> " . $rstemp['cus_name'] . "</a></td>
							 <td><a href=\"\" class=\"INV\" onClick=\"NewWindow('sales_inv_display.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"> " . $rstemp['SAL_EX'] . "</a></td>
							 <td><a href=\"\" class=\"INV\" onClick=\"NewWindow('sales_reg_amount_details.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"> " . number_format($rstemp['AMOUNT'], 2, ".", ",") . "</a></td>
							 <td><a href=\"\" class=\"INV\" onClick=\"NewWindow('sales_reg_paytot_details.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"> " . number_format($rstemp['BALANCE'], 2, ".", ",") . "</a></td>
							 <td><span class=\"INV\">" . $rstemp['TRN_TYPE'] . "</span></td></tr>";
        } else if (($rstemp['TRN_TYPE'] == "CNT") or ( $rstemp['TRN_TYPE'] == "INC")) {

            $ResponseXML .= "<tr>                              
                             <td><a href=\"\" class=\"CNT_INC\" onClick=\"NewWindow('crn_display.php?crnno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $rstemp['SDATE'] . "</a></td>
                                                         <td><span class=\"CNT_INC\">" . $rstemp['c_code1'] . "</span></td>  
							 <td><a href=\"\" class=\"CNT_INC\" onClick=\"NewWindow('crn_display.php?crnno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $rstemp['REFNO'] . "</a></td>
							 <td><a href=\"\" class=\"CNT_INC\" onClick=\"NewWindow('crn_display.php?crnno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $rstemp['cus_name'] . "</a></td>
							 <td><a href=\"\" class=\"CNT_INC\" onClick=\"NewWindow('crn_display.php?crnno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $rstemp['SAL_EX'] . "</a></td>
							 <td><span  class=\"CNT_INC\">" . number_format($rstemp['AMOUNT'], 2, ".", ",") . "</span></td>
							 <td><a href=\"\" class=\"CNT_INC\" onClick=\"NewWindow('sales_reg_paytot_details.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . number_format($rstemp['BALANCE'], 2, ".", ",") . "</a></td>
							 <td>" . $rstemp['TRN_TYPE'] . "</td></tr>";
        } else if ($rstemp['TRN_TYPE'] == "GRN") {

            $ResponseXML .= "<tr>                              
                             <td><a href=\"\" class=\"GRN\" onClick=\"NewWindow('grn_display.php?grn=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $rstemp['SDATE'] . "</a></td>
							 <td><span class=\"GRN\">" . $rstemp['c_code1'] . "</span></td>                                                         <td><a href=\"\" class=\"GRN\" onClick=\"NewWindow('grn_display.php?grn=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $rstemp['REFNO'] . "</a></td>
							 <td><a href=\"\" class=\"GRN\" onClick=\"NewWindow('grn_display.php?grn=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $rstemp['cus_name'] . "</a></td>
							 <td><a href=\"\" class=\"GRN\" onClick=\"NewWindow('grn_display.php?grn=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $rstemp['SAL_EX'] . "</a></td>
							 <td><a href=\"\" class=\"GRN\" onClick=\"NewWindow('grn_display.php?grn=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . number_format($rstemp['AMOUNT'], 2, ".", ",") . "</a></td>
							 <td><a href=\"\" class=\"GRN\" onClick=\"NewWindow('sales_reg_paytot_details.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . number_format($rstemp['BALANCE'], 2, ".", ",") . "</a></td>
							 <td><span class=\"GRN\">" . $rstemp['TRN_TYPE'] . "</span></td></tr>";
        } else if ($rstemp['TRN_TYPE'] == "DGRN") {

            $ResponseXML .= "<tr>                              
                             <td><a href=\"\" class=\"DGRN\" onClick=\"NewWindow('defective_item_display.php?txtrefno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $rstemp['SDATE'] . "</a></td>
							 <td><span class=\"DGRN\">" . $rstemp['c_code1'] . "</span></td>  
                                                         <td><a href=\"\" class=\"DGRN\" onClick=\"NewWindow('defective_item_display.php?txtrefno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $rstemp['REFNO'] . "</a></td>
							 <td><a href=\"\" class=\"DGRN\" onClick=\"NewWindow('defective_item_display.php?txtrefno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $rstemp['cus_name'] . "</a></td>
							 <td><a href=\"\" class=\"DGRN\" onClick=\"NewWindow('defective_item_display.php?txtrefno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . $rstemp['SAL_EX'] . "</a></td>
							 <td><a href=\"\" class=\"DGRN\" onClick=\"NewWindow('defective_item_display.php?txtrefno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . number_format($rstemp['AMOUNT'], 2, ".", ",") . "</a></td>
							 <td><a href=\"\" class=\"DGRN\" onClick=\"NewWindow('sales_reg_paytot_details.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\">" . number_format($rstemp['BALANCE'], 2, ".", ",") . "</a></td>
							 <td><span class=\"DGRN\">" . $rstemp['TRN_TYPE'] . "</span></td></tr>";
        } else {

            $ResponseXML .= "<tr>                              
                             <td><a  href=\"sales_inv_display.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "\">" . $rstemp['SDATE'] . "</a></td>
							 <td><span  >" . $rstemp['c_code1'] . "</span></td>  
                                                         <td><a href=\"sales_inv_display.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "\">" . $rstemp['REFNO'] . "</a></td>
							 <td><a href=\"sales_inv_display.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "\">" . $rstemp['cus_name'] . "</a></td>
							 <td><a href=\"sales_inv_display.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "\">" . $rstemp['SAL_EX'] . "</a></td>
							 <td><a href=\"sales_inv_display.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "\">" . number_format($rstemp['AMOUNT'], 2, ".", ",") . "</a></td>
							 <td><a href=\"sales_inv_display.php?refno=" . $rstemp['REFNO'] . "&trn_type=" . $rstemp['TRN_TYPE'] . "\">" . number_format($rstemp['BALANCE'], 2, ".", ",") . "</a></td>
							 <td>" . $rstemp['TRN_TYPE'] . "</td></tr>";
        }
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<invtot><![CDATA[" . number_format($invtot, 2, ".", ",") . "]]></invtot>";
    $ResponseXML .= "<rettot><![CDATA[" . number_format($rettot, 2, ".", ",") . "]]></rettot>";
    $ResponseXML .= "<paidtot><![CDATA[" . number_format($paidtot, 2, ".", ",") . "]]></paidtot>";
    $ResponseXML .= " </salesdetails>";

    echo $ResponseXML;
}
?>