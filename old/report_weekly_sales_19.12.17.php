<?php
session_start();

if ($_SESSION["CURRENT_USER"] == "") {
    exit("Please Login Again !!!");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Weekly Sales Report</title>
        <style>
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:14px;
            }
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {

                font-family:Arial, Helvetica, sans-serif;
                padding:5px;
            }
            th
            {
                font-weight:bold;
                font-size:12px;

            }
            td
            {
                font-size:12px;
                border-bottom:dashed 1px black;
            }
        </style>
        <style type="text/css">
            <!--
            .style1 {
                color: #0000FF;
                font-weight: bold;
                font-size: 24px;
            }
            -->

            <!--
            .red {
                color: #FF0000;
                font-weight: bold;
                font-size: 12px;
            }
            -->
        </style>
    </head>

    <body>
        <!-- Progress bar holder -->


        <?php
        require_once("connectioni.php");
        
        

        if ($_GET["cmbdev"] == "ALL") {
            $sysdiv = "A";
        }
        if ($_GET["cmbdev"] == "Computer") {
            $sysdiv = "1";
        }
        if ($_GET["cmbdev"] == "Manual") {
            $sysdiv = "0";
        }

        if ($_GET["radio"] == "optrep") {
            if (trim($_GET["txtyear"]) == "") {
                reports();
                PrintRep1();
            } else {
                reports_monthly();
                PrintRep1_monthly();
            }
        }
        if ($_GET["radio"] == "OPsum") {
            if (trim($_GET["txtyear"]) == "") {
                reports();
                PrintRepsum();
            } else {
                reports_monthly();
                PrintRepsum();
            }
        }
        if ($_GET["radio"] == "optbrand") {
            if (trim($_GET["txtyear"]) == "") {
                reports();
                Printrepbr();
            } else {
                reports_monthly();
                Printrepbr();
            }
        }
        if ($_GET["radio"] == "Optcus") {
            if (trim($_GET["txtyear"]) == "") {
                reports();
                if (isset($_GET['chkcat'])) {
                    if ($_GET['cmbcat'] != "All") {
                        PrintRep1_repwise2();
                    } else {
                        PrintRep1_repwise2();
                    }
                } else {
                    PrintRep1_repwise();
                }
            } else {
                reports_monthly();
                if (isset($_GET['chkcat'])) {
                    if ($_GET['cmbcat'] != "All") {
                        PrintRep1_repwise2_monthly();
                    } else {
                        PrintRep1_repwise2_monthly();
                    }
                } else {
                    PrintRep1_repwise_monthly();
                }
            }
        }

        function reports_monthly() {
            //===========================================depALL/repALL===========

            require_once("connectioni.php");
            
            

            $sql = "delete from salrep_mon where user_id='" . $_SESSION["CURRENT_USER"] . "' ";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 

            $mvatrate = 12;


            //   Report.Open "SELECT *FROM SALREP", DNUSER.CONUSER, adOpenDynamic, adLockOptimistic




            $year = trim($_GET["txtyear"]);


            $PBAR = 0;


            $sql_salma = "select sum(GRAND_TOT/(1 +GST/100)) AS GRAND_TOT , month(SDATE) as cmonth, SAL_EX, Brand, c_code from s_salma where Accname != 'NON STOCK'  and year(SDATE)='" . $year . "' and CANCELL='0' AND DEV!='" . $GLOBALS["sysdiv"] . "'   ";

            if ($_GET["cmbcat"] != "All") {
                $sql_salma .= " and sal_ex = '" . $_GET["cmbcat"] . "'";
            }
            $sql_salma .= "  group by month(SDATE), SAL_EX,Brand,c_code";
            //echo $sql_salma;
            $result_salma = mysqli_query($GLOBALS['dbinv'],$sql_salma);
            $i=0;
            $insert="";
            while ($row_salma = mysqli_fetch_array($result_salma)) {
                //echo date("d",strtotime($row_salma["SDATE"]))."-".$row_salma["GRAND_TOT"]." / ";
                $mon1 = 0;
                $mon2 = 0;
                $mon3 = 0;
                $mon4 = 0;
                $mon5 = 0;
                $mon6 = 0;
                $mon7 = 0;
                $mon8 = 0;
                $mon9 = 0;
                $mon10 = 0;
                $mon11 = 0;
                $mon12 = 0;


                if ($row_salma["cmonth"] == "1") {
                    $mon1 = $row_salma["GRAND_TOT"];
                } else if ($row_salma["cmonth"] == "2") {
                    $mon2 = $row_salma["GRAND_TOT"];
                } else if ($row_salma["cmonth"] == "3") {
                    $mon3 = $row_salma["GRAND_TOT"];
                } else if ($row_salma["cmonth"] == "4") {
                    $mon4 = $row_salma["GRAND_TOT"];
                } else if ($row_salma["cmonth"] == "5") {
                    $mon5 = $row_salma["GRAND_TOT"];
                } else if ($row_salma["cmonth"] == "6") {
                    $mon6 = $row_salma["GRAND_TOT"];
                } else if ($row_salma["cmonth"] == "7") {
                    $mon7 = $row_salma["GRAND_TOT"];
                } else if ($row_salma["cmonth"] == "8") {
                    $mon8 = $row_salma["GRAND_TOT"];
                } else if ($row_salma["cmonth"] == "9") {
                    $mon9 = $row_salma["GRAND_TOT"];
                } else if ($row_salma["cmonth"] == "10") {
                    $mon10 = $row_salma["GRAND_TOT"];
                } else if ($row_salma["cmonth"] == "11") {
                    $mon11 = $row_salma["GRAND_TOT"];
                } else if ($row_salma["cmonth"] == "12") {
                    $mon12 = $row_salma["GRAND_TOT"];
                }

                $targ = 0;
                if ($_GET["radio"] == "Optcus") {
                    $sql_targ = "Select * from dealer_target where rep = '" . $row_salma["SAL_EX"] . "' and cus_code='" . trim($row_salma["c_code"]) . "' and year(ldate)='" . $year . "'";

                    $result_targ = mysqli_query($GLOBALS['dbinv'],$sql_targ);
                    if ($row_targ = mysqli_fetch_array($result_targ)) {
                        $targ = trim($row_targ["target"]);
                    }
                }

                if ($_GET["radio"] != "Optcus") {
                    $sql_targ = "Select * from reptrn where rep_code = '" . $row_salma["SAL_EX"] . "' and brand='" . trim($row_salma["Brand"]) . "'";

                    $result_targ = mysqli_query($GLOBALS['dbinv'],$sql_targ);
                    if ($row_targ = mysqli_fetch_array($result_targ)) {
                        $targ = trim($row_targ["Target"]);
                    }
                }

                
                
                $sql_rep = "select * from s_salrep where repcode = '" . $row_salma["SAL_EX"] . "'";
                $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);
                $row_rep = mysqli_fetch_array($result_rep);

                $sqlven = "select * from vendor where code = '" . $row_salma["c_code"] . "'";
                $result_ven = mysqli_query($GLOBALS['dbinv'],$sqlven);
                if ($row_ven = mysqli_fetch_array($result_ven)) {
                    $cat = trim($row_ven["field1"]);
                }

                if ($i != 0) {
                    $insert = $insert . ", ";
                }

                $insert = $insert . "('" . $row_rep["Name"] . "', '" . $row_salma["Brand"] . "', '" . $targ . "', '" . $mon1 . "', '" . $mon2 . "',  '" . $mon3 . "', '" . $mon4 . "', '" . $mon5 . "', '" . $mon6 . "', '" . $mon7 . "', '" . $mon8 . "', '" . $mon9 . "', '" . $mon10 . "', '" . $mon11 . "', '" . $mon12 . "', '" . $year . "', '" . $row_salma["c_code"] . "', '" . $cat . "', '" . $_SESSION["CURRENT_USER"] . "')";

                $i = 1;
            }



            $sql = "insert into salrep_mon(rep, brand, target, month1, month2, month3, month4, month5, month6, month7, month8, month9, month10, month11, month12, no,cus_code,scat, user_id) values " . $insert;
              
            $result_tmp = mysqli_query($GLOBALS['dbinv'],$sql) ; 

            $i=0;
            $insert="";
            //echo $wk1."/".$wk2."/".$wk3."/".$wk4."/".$wk5." - ";
            if ($_GET["chkdef"] == "on") {
                $sql_cbal = "select sum(AMOUNT/(1 +vatrate/100)) as AMOUNT,month(SDATE) as cmonth,SAL_EX,brand,CUSCODE from c_bal where  year(SDATE)='" . $year . "'   and trn_type!='ARN' and trn_type!='REC' and trn_type!='INC' and trn_type!='PAY' AND DEV!='" . $GLOBALS["sysdiv"] . "' and flag1 != '1' ";
            }
            if ($_GET["chkdef"] != "on") {
                $sql_cbal = "select sum(AMOUNT/(1 +vatrate/100)) as AMOUNT,month(SDATE) as cmonth,SAL_EX,brand,CUSCODE  from c_bal where year(SDATE)='" . $year . "' and trn_type!='ARN' and trn_type!='REC'and trn_type!='DGRN' and trn_type!='INC' and trn_type!='PAY' AND DEV!='" . $GLOBALS["sysdiv"] . "' and flag1 != '1'  ";
            }
//echo $sql_cbal;
            if ($_GET["cmbcat"] != "All") {
                $sql_cbal .= " and sal_ex = '" . $_GET["cmbcat"] . "'";
            }

            $sql_cbal .= " group by month(SDATE), SAL_EX, brand, CUSCODE";
            //echo $sql_cbal;
            $result_cbal = mysqli_query($GLOBALS['dbinv'],$sql_cbal);
            while ($row_cbal = mysqli_fetch_array($result_cbal)) {
                $mon1 = 0;
                $mon2 = 0;
                $mon3 = 0;
                $mon4 = 0;
                $mon5 = 0;
                $mon6 = 0;
                $mon7 = 0;
                $mon8 = 0;
                $mon9 = 0;
                $mon10 = 0;
                $mon11 = 0;
                $mon12 = 0;


                if ($row_cbal["cmonth"] == "1") {
                    $mon1 = $row_cbal["AMOUNT"] * -1;
                } else if ($row_cbal["cmonth"] == "2") {
                    $mon2 = $row_cbal["AMOUNT"] * -1;
                } else if ($row_cbal["cmonth"] == "3") {
                    $mon3 = $row_cbal["AMOUNT"] * -1;
                } else if ($row_cbal["cmonth"] == "4") {
                    $mon4 = $row_cbal["AMOUNT"] * -1;
                } else if ($row_cbal["cmonth"] == "5") {
                    $mon5 = $row_cbal["AMOUNT"] * -1;
                } else if ($row_cbal["cmonth"] == "6") {
                    $mon6 = $row_cbal["AMOUNT"] * -1;
                } else if ($row_cbal["cmonth"] == "7") {
                    $mon7 = $row_cbal["AMOUNT"] * -1;
                } else if ($row_cbal["cmonth"] == "8") {
                    $mon8 = $row_cbal["AMOUNT"] * -1;
                } else if ($row_cbal["cmonth"] == "9") {
                    $mon9 = $row_cbal["AMOUNT"] * -1;
                } else if ($row_cbal["cmonth"] == "10") {
                    $mon10 = $row_cbal["AMOUNT"] * -1;
                } else if ($row_cbal["cmonth"] == "11") {
                    $mon11 = $row_cbal["AMOUNT"] * -1;
                } else if ($row_cbal["cmonth"] == "12") {
                    $mon12 = $row_cbal["AMOUNT"] * -1;
                }





                $sql_rep = "select * from s_salrep where repcode = '" . $row_cbal["SAL_EX"] . "'";
                $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);
                $row_rep = mysqli_fetch_array($result_rep);

                $targ = 0;
                if ($_GET["radio"] == "Optcus") {
                    $sql_targ = "Select * from dealer_target where rep = '" . $row_cbal["SAL_EX"] . "' and cus_code='" . trim($row_cbal["CUSCODE"]) . "' and month(ldate)='" . $row_cbal["cmonth"] . "' and year(ldate)='" . $year . "'";
                    $result_targ = mysqli_query($GLOBALS['dbinv'],$sql_targ);
                    if ($row_targ = mysqli_fetch_array($result_targ)) {
                        $targ = trim($row_targ["target"]);
                    }
                }
                if ($_GET["radio"] != "Optcus") {
                    $sql_targ = "Select * from reptrn where rep_code = '" . $row_cbal["SAL_EX"] . "' and brand='" . trim($row_cbal["brand"]) . "'";

                    $result_targ = mysqli_query($GLOBALS['dbinv'],$sql_targ);
                    if ($row_targ = mysqli_fetch_array($result_targ)) {
                        $targ = trim($row_targ["Target"]);
                    }
                }


                $sqlven = "select * from vendor where code = '" . $row_cbal["CUSCODE"] . "'";
                $result_ven = mysqli_query($GLOBALS['dbinv'],$sqlven);
                if ($row_ven = mysqli_fetch_array($result_ven)) {
                    $cat = trim($row_ven["field1"]);
                }

                if ($i != 0) {
                    $insert = $insert . ", ";
                }

                $insert = $insert . "('" . $row_rep["Name"] . "', '" . $row_cbal["brand"] . "', '" . $targ . "', '" . $mon1 . "', '" . $mon2 . "',  '" . $mon3 . "', '" . $mon4 . "', '" . $mon5 . "', '" . $mon6 . "', '" . $mon7 . "', '" . $mon8 . "', '" . $mon9 . "', '" . $mon10 . "', '" . $mon11 . "', '" . $mon12 . "', '" . $year . "', '" . $row_cbal["CUSCODE"] . "', '" . $cat . "', '" . $_SESSION["CURRENT_USER"] . "')";

                $i = 1;
            }

            $sql = "insert into salrep_mon(rep, brand, target, month1, month2, month3, month4, month5, month6, month7, month8, month9, month10, month11, month12, no,cus_code, scat, user_id) values " . $insert;
 
            $result_tmp = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        }

        function reports() {
            //===========================================depALL/repALL===========

            require_once("connectioni.php");
            
            

            $sql = "delete from salrep where user_id='" . $_SESSION["CURRENT_USER"] . "' ";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 

            $mvatrate = 12;


            //   Report.Open "SELECT *FROM SALREP", DNUSER.CONUSER, adOpenDynamic, adLockOptimistic



            $mon = date("m", strtotime($_GET["calmon"]));
            $year = date("Y", strtotime($_GET["calmon"]));


            $PBAR = 0;

            $sql_salma = "select sum(GRAND_TOT/(1 +GST/100)) AS GRAND_TOT , SDATE,SAL_EX,Brand,c_code from s_salma where Accname != 'NON STOCK'  and month(SDATE)='" . $mon . "' and year(SDATE)='" . $year . "'  and CANCELL='0' AND DEV!='" . $GLOBALS["sysdiv"] . "'   ";

            if ($_GET["cmbcat"] != "All") {
                $sql_salma .= " and sal_ex = '" . $_GET["cmbcat"] . "'";
            }
            $sql_salma .= "  group by SDATE,SAL_EX,Brand,c_code";

            $result_salma = mysqli_query($GLOBALS['dbinv'],$sql_salma);
            while ($row_salma = mysqli_fetch_array($result_salma)) {
                //echo date("d",strtotime($row_salma["SDATE"]))."-".$row_salma["GRAND_TOT"]." / ";
                $wk1 = 0;
                $wk2 = 0;
                $wk3 = 0;
                $wk4 = 0;
                $wk5 = 0;

                if (date("d", strtotime($row_salma["SDATE"])) < 8) {
                    $wk1 = $row_salma["GRAND_TOT"];
                } else if (date("d", strtotime($row_salma["SDATE"])) < 15) {
                    $wk2 = $row_salma["GRAND_TOT"];
                } else if (date("d", strtotime($row_salma["SDATE"])) < 22) {
                    $wk3 = $row_salma["GRAND_TOT"];
                } else if (date("d", strtotime($row_salma["SDATE"])) < 29) {
                    $wk4 = $row_salma["GRAND_TOT"];
                } else {
                    $wk5 = $row_salma["GRAND_TOT"];
                }

                $targ = 0;
                if ($_GET["radio"] == "Optcus") {
                    $sql_targ = "Select * from dealer_target where rep = '" . $row_salma["SAL_EX"] . "' and cus_code='" . trim($row_salma["c_code"]) . "' and month(ldate)='" . date("m", strtotime($_GET["calmon"])) . "' and year(ldate)='" . date("Y", strtotime($_GET["calmon"])) . "'";

                    $result_targ = mysqli_query($GLOBALS['dbinv'],$sql_targ);
                    if ($row_targ = mysqli_fetch_array($result_targ)) {
                        $targ = trim($row_targ["target"]);
                    }
                }

                if ($_GET["radio"] != "Optcus") {
                    $sql_targ = "Select * from reptrn where rep_code = '" . $row_salma["SAL_EX"] . "' and brand='" . trim($row_salma["Brand"]) . "'";

                    $result_targ = mysqli_query($GLOBALS['dbinv'],$sql_targ);
                    if ($row_targ = mysqli_fetch_array($result_targ)) {
                        $targ = trim($row_targ["Target"]);
                    }
                }

                $sql_rep = "select * from s_salrep where repcode = '" . $row_salma["SAL_EX"] . "'";
                $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);
                $row_rep = mysqli_fetch_array($result_rep);

                $sqlven = "select * from vendor where code = '" . $row_salma["c_code"] . "'";
                $result_ven = mysqli_query($GLOBALS['dbinv'],$sqlven);
                if ($row_ven = mysqli_fetch_array($result_ven)) {
                    $cat = trim($row_ven["field1"]);
                }

                if ($i != 0) {
                    $insert = $insert . ", ";
                }

                $insert = $insert . "('" . $row_rep["Name"] . "', '" . $row_salma["Brand"] . "', '" . $targ . "', '" . $wk1 . "', '" . $wk2 . "',  '" . $wk3 . "', '" . $wk4 . "', '" . $wk5 . "', '" . $_GET["cmbweek"] . "', '" . $row_salma["c_code"] . "', '" . $cat . "', '" . $_SESSION["CURRENT_USER"] . "')";

                $i = 1;
            }

            $sql = "insert into salrep(rep, brand, target, week1, week2, week3, week4, week5, no,cus_code,scat, user_id) values " . $insert;
            $result_tmp = mysqli_query($GLOBALS['dbinv'],$sql) ; 

            $insert = "";
$i = 0;
            //echo $wk1."/".$wk2."/".$wk3."/".$wk4."/".$wk5." - ";
            if ($_GET["chkdef"] == "on") {
                $sql_cbal = "select sum(AMOUNT/(1 +vatrate/100)) as AMOUNT,SDATE,SAL_EX,brand,cuscode from c_bal where  month(SDATE)='" . $mon . "' and year(SDATE)='" . $year . "'   and trn_type!='ARN' and trn_type!='REC' and trn_type!='INC' and trn_type!='PAY' AND DEV!='" . $GLOBALS["sysdiv"] . "' and flag1 != '1' ";
            }
            if ($_GET["chkdef"] != "on") {
                $sql_cbal = "select sum(AMOUNT/(1 +vatrate/100)) as AMOUNT,SDATE,SAL_EX,brand,cuscode  from c_bal where  month(SDATE)='" . $mon . "' and year(SDATE)='" . $year . "' and trn_type!='ARN' and trn_type!='REC'and trn_type!='DGRN' and trn_type!='INC' and trn_type!='PAY' AND DEV!='" . $GLOBALS["sysdiv"] . "' and flag1 != '1'  ";
            }

            if ($_GET["cmbcat"] != "All") {
                $sql_cbal .= " and sal_ex = '" . $_GET["cmbcat"] . "'";
            }

            $sql_cbal .= " group by SDATE,SAL_EX,brand,cuscode";
            $result_cbal = mysqli_query($GLOBALS['dbinv'],$sql_cbal);
            while ($row_cbal = mysqli_fetch_array($result_cbal)) {
                $wk1 = 0;
                $wk2 = 0;
                $wk3 = 0;
                $wk4 = 0;
                $wk5 = 0;


                if (date("d", strtotime($row_cbal["SDATE"])) < 8) {
                    $wk1 = $row_cbal["AMOUNT"] * -1;
                } else if (date("d", strtotime($row_cbal["SDATE"])) < 15) {
                    $wk2 = $row_cbal["AMOUNT"] * -1;
                } else if (date("d", strtotime($row_cbal["SDATE"])) < 22) {
                    $wk3 = $row_cbal["AMOUNT"] * -1;
                } else if (date("d", strtotime($row_cbal["SDATE"])) < 29) {
                    $wk4 = $row_cbal["AMOUNT"] * -1;
                } else {
                    $wk5 = $row_cbal["AMOUNT"] * -1;
                }





                $sql_rep = "select * from s_salrep where repcode = '" . $row_cbal["SAL_EX"] . "'";
                $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);
                $row_rep = mysqli_fetch_array($result_rep);

                $targ = 0;
                if ($_GET["radio"] == "Optcus") {
                    $sql_targ = "Select * from dealer_target where rep = '" . $row_cbal["SAL_EX"] . "' and cus_code='" . trim($row_cbal["cuscode"]) . "' and month(ldate)='" . date("m", strtotime($_GET["calmon"])) . "' and year(ldate)='" . date("Y", strtotime($_GET["calmon"])) . "'";
                    $result_targ = mysqli_query($GLOBALS['dbinv'],$sql_targ);
                    if ($row_targ = mysqli_fetch_array($result_targ)) {
                        $targ = trim($row_targ["target"]);
                    }
                }
                if ($_GET["radio"] != "Optcus") {
                    $sql_targ = "Select * from reptrn where rep_code = '" . $row_cbal["SAL_EX"] . "' and brand='" . trim($row_cbal["brand"]) . "'";

                    $result_targ = mysqli_query($GLOBALS['dbinv'],$sql_targ);
                    if ($row_targ = mysqli_fetch_array($result_targ)) {
                        $targ = trim($row_targ["Target"]);
                    }
                }


                $sqlven = "select * from vendor where code = '" . $row_cbal["cuscode"] . "'";
                $result_ven = mysqli_query($GLOBALS['dbinv'],$sqlven);
                if ($row_ven = mysqli_fetch_array($result_ven)) {
                    $cat = trim($row_ven["field1"]);
                }

                if ($i != 0) {
                    $insert = $insert . ", ";
                }

                $insert = $insert . "('" . $row_rep["Name"] . "', '" . $row_cbal["brand"] . "', '" . $targ . "', '" . $wk1 . "', '" . $wk2 . "',  '" . $wk3 . "', '" . $wk4 . "', '" . $wk5 . "', '" . $_GET["cmbweek"] . "', '" . $row_cbal["cuscode"] . "', '" . $cat . "', '" . $_SESSION["CURRENT_USER"] . "')";

                $i = 1;
            }

            $sql = "insert into salrep(rep, brand, target, week1, week2, week3, week4, week5, no,cus_code, scat, user_id) values " . $insert;

            $result_tmp = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        }

        function Printrepbr() {
            require_once("connectioni.php");
            
            

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");






            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            $rtxtmonth = date("F", strtotime($_GET["calmon"])) . " " . date("Y", strtotime($_GET["calmon"]));
            if ($_GET["chkdef"] == "on") {
                $rtxtmonth = date("F", strtotime($_GET["calmon"])) . "&nbsp;" . date("Y", strtotime($_GET["calmon"])) . "    With Defective";
            }
            if ($_GET["chkdef"] != "on") {
                $rtxtmonth = date("F", strtotime($_GET["calmon"])) . "&nbsp;" . date("Y", strtotime($_GET["calmon"]));
            }



            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");


            if ($_GET["chkdef"] == "on") {
                $txtremark = "<b>Weekly Sales Report Brand Wise</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"] . "    With Defective";
            }
            if ($_GET["chkdef"] != "on") {
                $txtremark = "Weekly Sales Report Brand Wise</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"];
            }

            echo "<center><table width=\"1000\" border=\"0\">
  <tr>
    
    <th colspan=\"4\" scope=\"col\">" . $rtxtComName . "</th>
   
  </tr>
  <tr>
   
    <th colspan=\"4\" align=\"center\">" . $rtxtcomadd1 . "</th>
   
  </tr>
  <tr>
    
    <th colspan=\"4\" align=\"center\">" . $rtxtComAdd2 . "</th>
   
  </tr>
  <tr>
    <th colspan=\"2\" width=\"600\">" . $txtremark . "</th>
    <th width=\"268\" colspan=2>" . $rtxtmonth . "</th>
   
  </tr>
  <tr>
    <th colspan=4>&nbsp;</th>
  </tr>
</table>";

            echo "<table width='1000' border=1>";


            echo "
		<tr>
		<th>Brand</th>
		<th>Target</th>
		<th>Week1</th>
		<th>Week2</th>
		<th>Week3</th>
		<th>Week4</th>
		<th>Week5</th>
		<th>Total</th>
		<th>Sort to Target</th>
		</tr>";



            $sql_rsPrInv = "SELECT brand,sum(target) as target,sum(week1) as week1,sum(week2) as week2,sum(week3) as week3,sum(week4) as week4,sum(week5) as week5 from salrep";
            $sql_rsPrInv1 = $sql_rsPrInv . "  where brand <>  '' and rep <> '' and cus_code <> '' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by brand order by brand ";

            $result_rsPrInv = mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv1);
            while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)) {

                $sql_targ = "Select sum(Target) as Target from reptrn where   brand='" . trim($row_rsPrInv["brand"]) . "'";

                $result_targ = mysqli_query($GLOBALS['dbinv'],$sql_targ);
                if ($row_targ = mysqli_fetch_array($result_targ)) {
                    $targ = trim($row_targ["Target"]);
                }



                echo "<tr><td>" . $row_rsPrInv["brand"] . "</td>
			<td align=\"right\">" . number_format($targ, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week1"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week2"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week3"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week4"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week5"], 2, ".", ",") . "</td>";

                $Total = $row_rsPrInv["week1"] + $row_rsPrInv["week2"] + $row_rsPrInv["week3"] + $row_rsPrInv["week4"] + $row_rsPrInv["week5"];
                $sort_tar = $targ - $Total;

                $target = $target + $targ;
                $week1 = $week1 + $row_rsPrInv["week1"];
                $week2 = $week2 + $row_rsPrInv["week2"];
                $week3 = $week3 + $row_rsPrInv["week3"];
                $week4 = $week4 + $row_rsPrInv["week4"];
                $week5 = $week5 + $row_rsPrInv["week5"];

                $totTotal = $totTotal + $Total;
                $totsort_tar = $totsort_tar + $sort_tar;

                echo "<td align=\"right\">" . number_format($Total, 2, ".", ",") . "</td>";
                echo "<td align=\"right\">" . number_format($sort_tar, 2, ".", ",") . "</td></tr>";
            }

            echo "<tr><th>&nbsp;</th>
			<th align=\"right\"><b>" . number_format($target, 2, ".", ",") . "</th>
			<th align=\"right\"><b>" . number_format($week1, 2, ".", ",") . "</th>
			<th align=\"right\"><b>" . number_format($week2, 2, ".", ",") . "</th>
			<th align=\"right\"><b>" . number_format($week3, 2, ".", ",") . "</th>
			<th align=\"right\"><b>" . number_format($week4, 2, ".", ",") . "</th>
			<th align=\"right\"><b>" . number_format($week5, 2, ".", ",") . "</th>
			<th align=\"right\"><b>" . number_format($totTotal, 2, ".", ",") . "</th>
			<th align=\"right\"><b>" . number_format($totsort_tar, 2, ".", ",") . "</th></tr>";

            echo "</table>";
        }

        function PrintRep1_monthly() {

            require_once("connectioni.php");
            
            

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            $rtxtmonth = $_GET["txtyear"];
//            if ($_GET["chkdef"] == "on") {
//                $txtremark = "Department  " . $_GET["cmbdep"] . "    With Defective";
//            }
//            if ($_GET["chkdef"] != "on") {
//                $txtremark = "Department  " . $_GET["cmbdep"];
//            }
            $txtremark = "Monthly Sales - Rep Wise";
            echo "<center><table width=\"1000\" border=\"0\">
  <tr>
    <th width=\"313\" scope=\"col\">&nbsp;</th>
    <th colspan=\"2\" scope=\"col\">" . $rtxtComName . "</th>
    <th width=\"170\" scope=\"col\">&nbsp;</th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan=\"2\" align=\"center\">" . $rtxtcomadd1 . "</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan=\"2\" align=\"center\">" . $rtxtComAdd2 . "</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan=\"2\">" . $txtremark . "</td>
    <td width=\"268\">" . $rtxtmonth . "</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width=\"221\">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>";

            echo "<center><table width=1000 border=1>";

            echo "
		<tr>
		<th>Brand</th>
		<th>Target</th>
		<th>January</th>
		<th>February</th>
		<th>March</th>
		<th>April</th>
		<th>May</th>
		<th>June</th>
		<th>July</th>
		<th>Augest</th>
		<th>September</th>
		<th>October</th>
		<th>November</th>
		<th>December</th>
		<th>Total</th>
		<th>Sort to Target</th>
		</tr>";

            $sql_rep = "select rep from salrep_mon where user_id='" . $_SESSION["CURRENT_USER"] . "' group by rep";

            $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);
            while ($row_rep = mysqli_fetch_array($result_rep)) {
                echo "<th colspan=6 align=left><b>" . $row_rep["rep"] . "</b></th></tr>";

                $sql_rsPrInv = "SELECT brand,target, sum(month1) as month1, sum(month2) as month2, sum(month3) as month3, sum(month4) as month4, sum(month5) as month5, sum(month6) as month6, sum(month7) as month7, sum(month8) as month8, sum(month9) as month9, sum(month10) as month10, sum(month11) as month11, sum(month12) as month12 from salrep_mon where (month1!= '0' or month2!= '0' or month3!= '0' or month4!= '0' or month5!= '0' or month6!= '0' or month7!= '0' or month8!= '0' or month9!= '0' or month10!= '0' or month11!= '0' or month12!= '0') ";
                $sql_rsPrInv1 = $sql_rsPrInv . " and rep = '" . $row_rep["rep"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by brand, target";
                // echo $sql_rsPrInv;
                $result_rsPrInv = mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv1);

                $mon1 = 0;
                $mon2 = 0;
                $mon3 = 0;
                $mon4 = 0;
                $mon5 = 0;
                $mon6 = 0;
                $mon7 = 0;
                $mon8 = 0;
                $mon9 = 0;
                $mon10 = 0;
                $mon11 = 0;
                $mon12 = 0;

                $totTotal = 0;
                $totsort_tar = 0;
                $target = 0;
                while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)) {

                    echo "<tr><td>" . $row_rsPrInv["brand"] . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["target"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month1"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month2"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month3"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month4"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month5"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month6"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month7"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month8"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month9"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month10"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month11"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month12"], 2, ".", ",") . "</td>";

                    $Total = $row_rsPrInv["month1"] + $row_rsPrInv["month2"] + $row_rsPrInv["month3"] + $row_rsPrInv["month4"] + $row_rsPrInv["month5"] + $row_rsPrInv["month6"] + $row_rsPrInv["month7"] + $row_rsPrInv["month8"] + $row_rsPrInv["month9"] + $row_rsPrInv["month10"] + $row_rsPrInv["month11"] + $row_rsPrInv["month12"];

                    $sort_tar = $row_rsPrInv["target"] - $Total;
                    $target = $target + $row_rsPrInv["target"];
                    $month1 = $month1 + $row_rsPrInv["month1"];
                    $month2 = $month2 + $row_rsPrInv["month2"];
                    $month3 = $month3 + $row_rsPrInv["month3"];
                    $month4 = $month4 + $row_rsPrInv["month4"];
                    $month5 = $month5 + $row_rsPrInv["month5"];
                    $month6 = $month6 + $row_rsPrInv["month6"];
                    $month7 = $month7 + $row_rsPrInv["month7"];
                    $month8 = $month8 + $row_rsPrInv["month8"];
                    $month9 = $month9 + $row_rsPrInv["month9"];
                    $month10 = $month10 + $row_rsPrInv["month10"];
                    $month11 = $month11 + $row_rsPrInv["month11"];
                    $month12 = $month12 + $row_rsPrInv["month12"];
                    $totTotal = $totTotal + $Total;
                    $totsort_tar = $totsort_tar + $sort_tar;

                    $targetf = $targetf + $row_rsPrInv["target"];
                    $month1f = $month1f + $row_rsPrInv["month1"];
                    $month2f = $month2f + $row_rsPrInv["month2"];
                    $month3f = $month3f + $row_rsPrInv["month3"];
                    $month4f = $month4f + $row_rsPrInv["month4"];
                    $month5f = $month5f + $row_rsPrInv["month5"];
                    $month6f = $month6f + $row_rsPrInv["month6"];
                    $month7f = $month7f + $row_rsPrInv["month7"];
                    $month8f = $month8f + $row_rsPrInv["month8"];
                    $month9f = $month9f + $row_rsPrInv["month9"];
                    $month10f = $month10f + $row_rsPrInv["month10"];
                    $month11f = $month11f + $row_rsPrInv["month11"];
                    $month12f = $month12f + $row_rsPrInv["month12"];
                    $totTotalf = $totTotalf + $Total;
                    $totsort_tarf = $totsort_tarf + $sort_tar;




                    echo "<td align=\"right\">" . number_format($Total, 2, ".", ",") . "</td>";
                    echo "<td align=\"right\">" . number_format($sort_tar, 2, ".", ",") . "</td></tr>";
                }

                echo "<tr><td>&nbsp;</td>
			<td align=\"right\"><b>" . number_format($target, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month1, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month2, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month3, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month4, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month5, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month6, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month7, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month8, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month9, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month10, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month11, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month12, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($totTotal, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totsort_tar, 2, ".", ",") . "</b></td></tr>";
            }
            echo "<tr><td>&nbsp;</td>
			<td align=\"right\"><b>" . number_format($targetf, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month1f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month2f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month3f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month4f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month5f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month6f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month7f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month8f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month9f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month10f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month11f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($month12f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($totTotalf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totsort_tarf, 2, ".", ",") . "</b></td></tr>";


            echo "</table>";
        }

        function PrintRep1() {

            require_once("connectioni.php");
            
            

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            $rtxtmonth = date("F", strtotime($_GET["calmon"])) . " " . date("Y", strtotime($_GET["calmon"]));
//            if ($_GET["chkdef"] == "on") {
//                $txtremark = "Department  " . $_GET["cmbdep"] . "    With Defective";
//            }
//            if ($_GET["chkdef"] != "on") {
//                $txtremark = "Department  " . $_GET["cmbdep"];
//            }
            $txtremark = "Weekly Sales Rep Wise";
            echo "<center><table width=\"1000\" border=\"0\">
  <tr>
    <th width=\"313\" scope=\"col\">&nbsp;</th>
    <th colspan=\"2\" scope=\"col\">" . $rtxtComName . "</th>
    <th width=\"170\" scope=\"col\">&nbsp;</th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan=\"2\" align=\"center\">" . $rtxtcomadd1 . "</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan=\"2\" align=\"center\">" . $rtxtComAdd2 . "</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan=\"2\">" . $txtremark . "</td>
    <td width=\"268\">" . $rtxtmonth . "</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width=\"221\">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>";

            echo "<center><table width=1000 border=1>";

            echo "
		<tr>
		<th>Brand</th>
		<th>Target</th>
		<th>Week1</th>
		<th>Week2</th>
		<th>Week3</th>
		<th>Week4</th>
		<th>Week5</th>
		<th>Total</th>
		<th>Sort to Target</th>
		</tr>";

            $sql_rep = "select rep from salrep where user_id='" . $_SESSION["CURRENT_USER"] . "' group by rep";

            $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);
            while ($row_rep = mysqli_fetch_array($result_rep)) {
                echo "<th colspan=6 align=left><b>" . $row_rep["rep"] . "</b></th></tr>";

                $sql_rsPrInv = "SELECT brand,target,sum(week1) as week1,sum(week2) as week2,sum(week3) as week3,sum(week4) as week4,sum(week5) as week5 from salrep where (week1!= '0' or week2!= '0' or week3 !='0' or week4 !='0' or week5!='0') ";
                $sql_rsPrInv1 = $sql_rsPrInv . " and rep = '" . $row_rep["rep"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by brand,target";
                //echo $sql_rsPrInv;
                $result_rsPrInv = mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv1);

                $week1 = 0;
                $week2 = 0;
                $week3 = 0;
                $week4 = 0;
                $week5 = 0;
                $totTotal = 0;
                $totsort_tar = 0;
                $target = 0;
                while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)) {

                    echo "<tr><td>" . $row_rsPrInv["brand"] . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["target"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week1"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week2"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week3"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week4"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week5"], 2, ".", ",") . "</td>";

                    $Total = $row_rsPrInv["week1"] + $row_rsPrInv["week2"] + $row_rsPrInv["week3"] + $row_rsPrInv["week4"] + $row_rsPrInv["week5"];
                    $sort_tar = $row_rsPrInv["target"] - $Total;
                    $target = $target + $row_rsPrInv["target"];
                    $week1 = $week1 + $row_rsPrInv["week1"];
                    $week2 = $week2 + $row_rsPrInv["week2"];
                    $week3 = $week3 + $row_rsPrInv["week3"];
                    $week4 = $week4 + $row_rsPrInv["week4"];
                    $week5 = $week5 + $row_rsPrInv["week5"];
                    $totTotal = $totTotal + $Total;
                    $totsort_tar = $totsort_tar + $sort_tar;

                    $targetf = $targetf + $row_rsPrInv["target"];
                    $week1f = $week1f + $row_rsPrInv["week1"];
                    $week2f = $week2f + $row_rsPrInv["week2"];
                    $week3f = $week3f + $row_rsPrInv["week3"];
                    $week4f = $week4f + $row_rsPrInv["week4"];
                    $week5f = $week5f + $row_rsPrInv["week5"];
                    $totTotalf = $totTotalf + $Total;
                    $totsort_tarf = $totsort_tarf + $sort_tar;




                    echo "<td align=\"right\">" . number_format($Total, 2, ".", ",") . "</td>";
                    echo "<td align=\"right\">" . number_format($sort_tar, 2, ".", ",") . "</td></tr>";
                }

                echo "<tr><td>&nbsp;</td>
			<td align=\"right\"><b>" . number_format($target, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($week1, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($week2, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week3, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week4, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week5, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totTotal, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totsort_tar, 2, ".", ",") . "</b></td></tr>";
            }
            echo "<tr><td>&nbsp;</td>
			<td align=\"right\"><b>" . number_format($targetf, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($week1f, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($week2f, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week3f, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week4f, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week5f, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totTotalf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totsort_tarf, 2, ".", ",") . "</b></td></tr>";


            echo "</table>";
        }

        function PrintRep1_repwise() {

            require_once("connectioni.php");
            
            

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            if ($_GET["radio"] == "Optcus") {
                $sql_rsPrInv = "SELECT brand, target, sum(week1) as week1, sum(week2) as week2, sum(week3) as week3, sum(week4) as week4, sum(week5) as week5 from salrep where week1!= '0' or week2!= '0' or week3 !='0' or week4 !='0' or week5!='0' and user_id='" . $_SESSION["CURRENT_USER"] . "' ";
                //Section10.Suppress = True
            } else {
                $sql_rsPrInv = "SELECT brand,  target, sum(week1) as week1, sum(week2) as week2, sum(week3) as week3, sum(week4) as week4, sum(week5) as week5 from salrep where week1!= '0' or week2!= '0' or week3 !='0' or week4 !='0' or week5!='0' and user_id='" . $_SESSION["CURRENT_USER"] . "' ";
            }


            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            $rtxtmonth = date("F", strtotime($_GET["calmon"])) . " " . date("Y", strtotime($_GET["calmon"]));
            if ($_GET["chkdef"] == "on") {
                $txtremark = "<b>Weekly Sales Report Rep Wise</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"] . "    With Defective";
            }
            if ($_GET["chkdef"] != "on") {
                $txtremark = "Weekly Sales Report Rep Wise</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"];
            }

            echo "<center><table width=\"1000\" border=\"0\">
  <tr>
    
    <th colspan=\"4\" scope=\"col\">" . $rtxtComName . "</th>
   
  </tr>
  <tr>
   
    <td colspan=\"4\" align=\"center\">" . $rtxtcomadd1 . "</td>
   
  </tr>
  <tr>
    
    <td colspan=\"4\" align=\"center\">" . $rtxtComAdd2 . "</td>
   
  </tr>
  <tr>
    <td colspan=\"2\" width=\"600\">" . $txtremark . "</td>
    <td width=\"268\" colspan=2>" . $rtxtmonth . "</td>
   
  </tr>
  <tr>
    <td colspan=4>&nbsp;</td>
  </tr>
</table>";

            echo "<center><table width=1000 border=1>
		";


            echo "<center><table width=1000 border=1>";
            echo "
		<tr>
		<th>Brand</th>
		<th>Target</th>
		<th>Week1</th>
		<th>Week2</th>
		<th>Week3</th>
		<th>Week4</th>
		<th>Week5</th>
		<th>Total</th>
		<th>Sort to Target</th>
		</tr>";

            $sql_rep = "select rep from salrep where rep <> '' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by rep";
            $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);

            $week2tf = 0;
            $week3tf = 0;
            $week4tf = 0;
            $week5tf = 0;
            $totTotaltf = 0;
            $totsort_tartf = 0;

            while ($row_rep = mysqli_fetch_array($result_rep)) {
                $week1t = 0;
                $week2t = 0;
                $week3t = 0;
                $week4t = 0;
                $week5t = 0;
                $totTotalt = 0;
                $totsort_tart = 0;
                echo "<th colspan=9 align=left><font color='brown' SIZE=4><b>" . $row_rep["rep"] . "</b></th></tr>";

                $sql_cus = "select cus_code from salrep where rep=  '" . $row_rep["rep"] . "' and cus_code <> '' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by cus_code";
                $result_cus = mysqli_query($GLOBALS['dbinv'],$sql_cus);

                while ($row_cus = mysqli_fetch_array($result_cus)) {


                    $sql_ven = "select * from vendor where code=  '" . $row_cus["cus_code"] . "'";
                    $result_ven = mysqli_query($GLOBALS['dbinv'],$sql_ven);
                    $row_ven = mysqli_fetch_array($result_ven);


                    echo "<th colspan=9 align=left><b>" . $row_cus["cus_code"] . "-" . $row_ven["NAME"] . "<b></th></tr>";


                    $sql_rsPrInv = "SELECT brand,target,sum(week1) as week1,sum(week2) as week2,sum(week3) as week3,sum(week4) as week4,sum(week5) as week5 from salrep where (week1!= '0' or week2!= '0' or week3 !='0' or week4 !='0' or week5!='0') ";
                    $sql_rsPrInv1 = $sql_rsPrInv . " and brand <> '' and rep = '" . $row_rep["rep"] . "'  and cus_code = '" . $row_cus["cus_code"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by brand";

                    $result_rsPrInv = mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv1);
                    $week1 = 0;
                    $week2 = 0;
                    $week3 = 0;
                    $week4 = 0;
                    $week5 = 0;
                    $totTotal = 0;
                    $totsort_tar = 0;
                    while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)) {



                        echo "<tr><td>" . $row_rsPrInv["brand"] . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["target"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week1"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week2"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week3"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week4"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["week5"], 2, ".", ",") . "</td>";

                        $Total = $row_rsPrInv["week1"] + $row_rsPrInv["week2"] + $row_rsPrInv["week3"] + $row_rsPrInv["week4"] + $row_rsPrInv["week5"];
                        $sort_tar = $row_rsPrInv["target"] - $Total;
                        $target = $target + $row_rsPrInv["target"];
                        $week1 = $week1 + $row_rsPrInv["week1"];
                        $week2 = $week2 + $row_rsPrInv["week2"];
                        $week3 = $week3 + $row_rsPrInv["week3"];
                        $week4 = $week4 + $row_rsPrInv["week4"];
                        $week5 = $week5 + $row_rsPrInv["week5"];

                        $week1t = $week1t + $row_rsPrInv["week1"];
                        $week2t = $week2t + $row_rsPrInv["week2"];
                        $week3t = $week3t + $row_rsPrInv["week3"];
                        $week4t = $week4t + $row_rsPrInv["week4"];
                        $week5t = $week5t + $row_rsPrInv["week5"];


                        $totTotal = $totTotal + $Total;
                        $totsort_tar = $totsort_tar + $sort_tar;
                        $totTotalt = $totTotalt + $Total;
                        $totsort_tart = $totsort_tart + $sort_tar;

                        $targettf = $targettf + $row_rsPrInv["target"];

                        $week2tf = $week2tf + $row_rsPrInv["week2"];
                        $week3tf = $week3tf + $row_rsPrInv["week3"];
                        $week4tf = $week4tf + $row_rsPrInv["week4"];
                        $week5tf = $week5tf + $row_rsPrInv["week5"];

                        $totTotaltf = $totTotaltf + $Total;
                        $totsort_tartf = $totsort_tartf + $sort_tar;


                        echo "<td align=\"right\">" . number_format($Total, 2, ".", ",") . "</td>";
                        echo "<td align=\"right\">" . number_format($sort_tar, 2, ".", ",") . "</td></tr>";
                    }

                    echo "<tr><td></td><td></td>
			<td align=\"right\"><b>" . number_format($week1, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week2, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week3, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week4, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week5, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totTotal, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totsort_tar, 2, ".", ",") . "</b></td></tr>   
                            </tr>";
                }

                echo "<tr><td></td><td></td>
			<td align=\"right\"><b>" . number_format($week1t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week2t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week3t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week4t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week5t, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totTotalt, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totsort_tart, 2, ".", ",") . "</b></td></tr>   
                            </tr>";
                $week1tf = $week1tf + $week1t;
            }
            echo "<tr><td>&nbsp;</td>
			<td align=\"right\"><b>" . number_format($targettf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week1tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week2tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week3tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week4tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week5tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totTotaltf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totsort_tartf, 2, ".", ",") . "</b></td></tr>";


            echo "</table>";
        }

        function PrintRep1_repwise_monthly() {

            require_once("connectioni.php");
            
            

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            if ($_GET["radio"] == "Optcus") {
                $sql_rsPrInv = "SELECT brand, target, sum(month1) as month1, sum(month2) as month2, sum(month3) as month3, sum(month4) as month4, sum(month5) as month5, sum(month6) as month6, sum(month7) as month7, sum(month8) as month8, sum(month9) as month9, sum(month10) as month10, sum(month11) as month11, sum(month12) as month12 from salrep_mon where (month1!= '0' or month2!= '0' or month3!= '0' or month4!= '0' or month5!= '0' or month6!= '0' or month7!= '0' or month8!= '0' or month9!= '0' or month10!= '0' or month11!= '0' or month12!= '0') and user_id='" . $_SESSION["CURRENT_USER"] . "' ";
                //Section10.Suppress = True
            } else {
                $sql_rsPrInv = "SELECT brand,  target, sum(month1) as month1, sum(month2) as month2, sum(month3) as month3, sum(month4) as month4, sum(month5) as month5, sum(month6) as month6, sum(month7) as month7, sum(month8) as month8, sum(month9) as month9, sum(month10) as month10, sum(month11) as month11, sum(month12) as month12 from salrep_mon where (month1!= '0' or month2!= '0' or month3!= '0' or month4!= '0' or month5!= '0' or month6!= '0' or month7!= '0' or month8!= '0' or month9!= '0' or month10!= '0' or month11!= '0' or month12!= '0') and user_id='" . $_SESSION["CURRENT_USER"] . "' ";
            }


            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            $rtxtmonth = $_GET["txtyear"];
            if ($_GET["chkdef"] == "on") {
                $txtremark = "<b>Monthly Sales Report Rep Wise</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"] . "    With Defective";
            }
            if ($_GET["chkdef"] != "on") {
                $txtremark = "Monthly Sales Report Rep Wise</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"];
            }

            echo "<center><table width=\"1000\" border=\"0\">
  <tr>
    
    <th colspan=\"4\" scope=\"col\">" . $rtxtComName . "</th>
   
  </tr>
  <tr>
   
    <td colspan=\"4\" align=\"center\">" . $rtxtcomadd1 . "</td>
   
  </tr>
  <tr>
    
    <td colspan=\"4\" align=\"center\">" . $rtxtComAdd2 . "</td>
   
  </tr>
  <tr>
    <td colspan=\"2\" width=\"600\">" . $txtremark . "</td>
    <td width=\"268\" colspan=2>" . $rtxtmonth . "</td>
   
  </tr>
  <tr>
    <td colspan=4>&nbsp;</td>
  </tr>
</table>";

            echo "<center><table width=1000 border=1>
		";


            echo "<center><table width=1000 border=1>";
            echo "
		<tr>
		<th>Brand</th>
		<th>Target</th>
		<th>Month1</th>
		<th>Month2</th>
		<th>Month3</th>
		<th>Month4</th>
		<th>Month5</th>
		<th>Month6</th>
		<th>Month7</th>
		<th>Month8</th>
		<th>Month9</th>
		<th>Month10</th>
		<th>Month11</th>
		<th>Month12</th>
		<th>Total</th>
		<th>Sort to Target</th>
		</tr>";

            $sql_rep = "select rep from salrep_mon where rep <> '' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by rep";
            $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);

            $mon1tf = 0;
            $mon2tf = 0;
            $mon3tf = 0;
            $mon4tf = 0;
            $mon5tf = 0;
            $mon6tf = 0;
            $mon7tf = 0;
            $mon8tf = 0;
            $mon9tf = 0;
            $mon10tf = 0;
            $mon11tf = 0;
            $mon12tf = 0;

            $totTotaltf = 0;
            $totsort_tartf = 0;

            while ($row_rep = mysqli_fetch_array($result_rep)) {

                $mon1t = 0;
                $mon2t = 0;
                $mon3t = 0;
                $mon4t = 0;
                $mon5t = 0;
                $mon6t = 0;
                $mon7t = 0;
                $mon8t = 0;
                $mon9t = 0;
                $mon10t = 0;
                $mon11t = 0;
                $mon12t = 0;

                $totTotalt = 0;
                $totsort_tart = 0;

                echo "<th colspan=16 align=left><font color='brown' SIZE=4><b>" . $row_rep["rep"] . "</b></th></tr>";

                $sql_cus = "select cus_code from salrep_mon where rep=  '" . $row_rep["rep"] . "' and cus_code <> '' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by cus_code";
                $result_cus = mysqli_query($GLOBALS['dbinv'],$sql_cus);

                while ($row_cus = mysqli_fetch_array($result_cus)) {


                    $sql_ven = "select * from vendor where code=  '" . $row_cus["cus_code"] . "'";
                    $result_ven = mysqli_query($GLOBALS['dbinv'],$sql_ven);
                    $row_ven = mysqli_fetch_array($result_ven);


                    echo "<th colspan=16 align=left><b>" . $row_cus["cus_code"] . "-" . $row_ven["NAME"] . "<b></th></tr>";


                    $sql_rsPrInv = "SELECT brand,target, sum(month1) as month1, sum(month2) as month2, sum(month3) as month3, sum(month4) as month4, sum(month5) as month5, sum(month6) as month6, sum(month7) as month7, sum(month8) as month8, sum(month9) as month9, sum(month10) as month10, sum(month11) as month11, sum(month12) as month12 from salrep_mon where (month1!= '0' or month2!= '0' or month3!= '0' or month4!= '0' or month5!= '0' or month6!= '0' or month7!= '0' or month8!= '0' or month9!= '0' or month10!= '0' or month11!= '0' or month12!= '0') ";
                    $sql_rsPrInv1 = $sql_rsPrInv . " and brand <> '' and rep = '" . $row_rep["rep"] . "'  and cus_code = '" . $row_cus["cus_code"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by brand";

                    $result_rsPrInv = mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv1);

                    $mon1 = 0;
                    $mon2 = 0;
                    $mon3 = 0;
                    $mon4 = 0;
                    $mon5 = 0;
                    $mon6 = 0;
                    $mon7 = 0;
                    $mon8 = 0;
                    $mon9 = 0;
                    $mon10 = 0;
                    $mon11 = 0;
                    $mon12 = 0;

                    $totTotal = 0;
                    $totsort_tar = 0;
                    while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)) {



                        echo "<tr><td>" . $row_rsPrInv["brand"] . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["target"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month1"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month2"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month3"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month4"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month5"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month6"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month7"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month8"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month9"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month10"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month11"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv["month12"], 2, ".", ",") . "</td>";

                        $Total = $row_rsPrInv["month1"] + $row_rsPrInv["month2"] + $row_rsPrInv["month3"] + $row_rsPrInv["month4"] + $row_rsPrInv["month5"] + $row_rsPrInv["month6"] + $row_rsPrInv["month7"] + $row_rsPrInv["month8"] + $row_rsPrInv["month9"] + $row_rsPrInv["month10"] + $row_rsPrInv["month11"] + $row_rsPrInv["month12"];
                        $sort_tar = $row_rsPrInv["target"] - $Total;
                        $target = $target + $row_rsPrInv["target"];
                        $mon1 = $mon1 + $row_rsPrInv["month1"];
                        $mon2 = $mon2 + $row_rsPrInv["month2"];
                        $mon3 = $mon3 + $row_rsPrInv["month3"];
                        $mon4 = $mon4 + $row_rsPrInv["month4"];
                        $mon5 = $mon5 + $row_rsPrInv["month5"];
                        $mon6 = $mon6 + $row_rsPrInv["month6"];
                        $mon7 = $mon7 + $row_rsPrInv["month7"];
                        $mon8 = $mon8 + $row_rsPrInv["month8"];
                        $mon9 = $mon9 + $row_rsPrInv["month9"];
                        $mon10 = $mon10 + $row_rsPrInv["month10"];
                        $mon11 = $mon11 + $row_rsPrInv["month11"];
                        $mon12 = $mon12 + $row_rsPrInv["month12"];


                        $mon1t = $mon1t + $row_rsPrInv["month1"];
                        $mon2t = $mon2t + $row_rsPrInv["month2"];
                        $mon3t = $mon3t + $row_rsPrInv["month3"];
                        $mon4t = $mon4t + $row_rsPrInv["month4"];
                        $mon5t = $mon5t + $row_rsPrInv["month5"];
                        $mon6t = $mon6t + $row_rsPrInv["month6"];
                        $mon7t = $mon7t + $row_rsPrInv["month7"];
                        $mon8t = $mon8t + $row_rsPrInv["month8"];
                        $mon9t = $mon9t + $row_rsPrInv["month9"];
                        $mon10t = $mon10t + $row_rsPrInv["month10"];
                        $mon11t = $mon11t + $row_rsPrInv["month11"];
                        $mon12t = $mon12t + $row_rsPrInv["month12"];


                        $totTotal = $totTotal + $Total;
                        $totsort_tar = $totsort_tar + $sort_tar;
                        $totTotalt = $totTotalt + $Total;
                        $totsort_tart = $totsort_tart + $sort_tar;

                        $targettf = $targettf + $row_rsPrInv["target"];

                        $mon1tf = $mon1tf + $row_rsPrInv["month1"];
                        $mon2tf = $mon2tf + $row_rsPrInv["month2"];
                        $mon3tf = $mon3tf + $row_rsPrInv["month3"];
                        $mon4tf = $mon4tf + $row_rsPrInv["month4"];
                        $mon5tf = $mon5tf + $row_rsPrInv["month5"];
                        $mon6tf = $mon6tf + $row_rsPrInv["month6"];
                        $mon7tf = $mon7tf + $row_rsPrInv["month7"];
                        $mon8tf = $mon8tf + $row_rsPrInv["month8"];
                        $mon9tf = $mon9tf + $row_rsPrInv["month9"];
                        $mon10tf = $mon10tf + $row_rsPrInv["month10"];
                        $mon11tf = $mon11tf + $row_rsPrInv["month11"];
                        $mon12tf = $mon12tf + $row_rsPrInv["month12"];


                        $totTotaltf = $totTotaltf + $Total;
                        $totsort_tartf = $totsort_tartf + $sort_tar;


                        echo "<td align=\"right\">" . number_format($Total, 2, ".", ",") . "</td>";
                        echo "<td align=\"right\">" . number_format($sort_tar, 2, ".", ",") . "</td></tr>";
                    }

                    echo "<tr><td></td><td></td>
			<td align=\"right\"><b>" . number_format($mon1, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon2, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon3, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon4, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon5, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon6, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon7, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon8, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon9, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon10, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon11, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon12, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totTotal, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totsort_tar, 2, ".", ",") . "</b></td></tr>   
                            </tr>";
                }

                echo "<tr><td></td><td></td>
			<td align=\"right\"><b>" . number_format($mon1t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon2t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon3t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon4t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon5t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon6t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon7t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon8t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon9t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon10t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon11t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon12t, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totTotalt, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totsort_tart, 2, ".", ",") . "</b></td></tr>   
                            </tr>";
                $mon1tf = $mon1tf + $mon1t;
                $mon2tf = $mon2tf + $mon2t;
                $mon3tf = $mon31tf + $mon3t;
                $mon4tf = $mon4tf + $mont;
                $mon5tf = $mon5tf + $mon1t;
                $mon6tf = $mon6tf + $mon1t;
                $mon7tf = $mon7tf + $mon1t;
                $mon8tf = $mon8tf + $mon1t;
                $mon9tf = $mon9tf + $mon1t;
                $mon10tf = $mon10tf + $mon1t;
                $mon11tf = $mon11tf + $mon1t;
                $mon12tf = $mon12tf + $mon1t;
            }
            echo "<tr><td>&nbsp;</td>
			<td align=\"right\"><b>" . number_format($targettf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon1tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon2tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon3tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon4tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon5tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon6tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon7tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon8tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon9tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon10tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon11tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon12tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totTotaltf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totsort_tartf, 2, ".", ",") . "</b></td></tr>";


            echo "</table>";
        }

        function PrintRep1_repwise1() {

            require_once("connectioni.php");
            
            

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            if ($_GET["radio"] == "Optcus") {
                $sql_rsPrInv = "SELECT brand, target, sum(month1) as month1, sum(month2) as month2, sum(month3) as month3, sum(month4) as month4, sum(month5) as month5, sum(month6) as month6, sum(month7) as month7, sum(month8) as month8, sum(month9) as month9, sum(month10) as month10, sum(month11) as month11, sum(month12) as month12 from salrep where (month1!= '0' or month2!= '0' or month3!= '0' or month4!= '0' or month5!= '0' or month6!= '0' or month7!= '0' or month8!= '0' or month9!= '0' or month10!= '0' or month11!= '0' or month12!= '0') and user_id='" . $_SESSION["CURRENT_USER"] . "' ";
                //Section10.Suppress = True
            } else {
                $sql_rsPrInv = "SELECT brand,  target, sum(month1) as month1, sum(month2) as month2, sum(month3) as month3, sum(month4) as month4, sum(month5) as month5, sum(month6) as month6, sum(month7) as month7, sum(month8) as month8, sum(month9) as month9, sum(month10) as month10, sum(month11) as month11, sum(month12) as month12 from salrep where (month1!= '0' or month2!= '0' or month3!= '0' or month4!= '0' or month5!= '0' or month6!= '0' or month7!= '0' or month8!= '0' or month9!= '0' or month10!= '0' or month11!= '0' or month12!= '0') and user_id='" . $_SESSION["CURRENT_USER"] . "' ";
            }


            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            $rtxtmonth = date("F", strtotime($_GET["calmon"])) . " " . date("Y", strtotime($_GET["calmon"]));
            if ($_GET["chkdef"] == "on") {
                $txtremark = "<b>Weekly Sales Report Rep Wise</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"] . "    With Defective";
            }
            if ($_GET["chkdef"] != "on") {
                $txtremark = "Weekly Sales Report Rep Wise</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"];
            }

            echo "<center><table width=\"1000\" border=\"0\">
  <tr>
    
    <th colspan=\"4\" scope=\"col\">" . $rtxtComName . "</th>
   
  </tr>
  <tr>
   
    <td colspan=\"4\" align=\"center\">" . $rtxtcomadd1 . "</td>
   
  </tr>
  <tr>
    
    <td colspan=\"4\" align=\"center\">" . $rtxtComAdd2 . "</td>
   
  </tr>
  <tr>
    <td colspan=\"2\" width=\"600\">" . $txtremark . "</td>
    <td width=\"268\" colspan=2>" . $rtxtmonth . "</td>
   
  </tr>
  <tr>
    <td colspan=4>&nbsp;</td>
  </tr>
</table>";

            echo "<center><table width=1000 border=1>
		";


            echo "<center><table width=1000 border=1>";
            echo "
		<tr>
		<th>Brand</th>
		<th>Target</th>
		<th>January</th>
		<th>February</th>
		<th>March</th>
		<th>April</th>
		<th>May</th>
		<th>June</th>
		<th>July</th>
		<th>Augest</th>
		<th>September</th>
		<th>October</th>
		<th>November</th>
		<th>December</th>
		<th>Total</th>
		<th>Sort to Target</th>
		</tr>";

            $sql_rep = "select rep from salrep_mon where rep <> '' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by rep";
            $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);

            $mon1tf = 0;
            $mon2tf = 0;
            $mon3tf = 0;
            $mon4tf = 0;
            $mon5tf = 0;
            $mon6tf = 0;
            $mon7tf = 0;
            $mon8tf = 0;
            $mon9tf = 0;
            $mon10tf = 0;
            $mon11tf = 0;
            $mon12tf = 0;
            $totTotaltf = 0;
            $totsort_tartf = 0;

            while ($row_rep = mysqli_fetch_array($result_rep)) {
                $mon1t = 0;
                $mon2t = 0;
                $mon3t = 0;
                $mon4t = 0;
                $mon5t = 0;
                $mon6t = 0;
                $mon7t = 0;
                $mon8t = 0;
                $mon9t = 0;
                $mon10t = 0;
                $mon11t = 0;
                $mon12t = 0;
                $totTotalt = 0;
                $totsort_tart = 0;

                echo "<th colspan=9 align=left><font color='brown' SIZE=4><b>" . $row_rep["rep"] . "</b></th></tr>";


                $sql_cus1 = "select scat from salrep_mon where rep=  '" . $row_rep["rep"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'  group by scat";
                $result_cus1 = mysqli_query($GLOBALS['dbinv'],$sql_cus1);

                while ($row_cus1 = mysqli_fetch_array($result_cus1)) {
                    echo "<th colspan=9 align=left><b>" . $row_cus1["scat"] . "<b></th></tr>";


                    $sql_cus = "select cus_code,target,sum(month1) as month1, sum(month2) as month2, sum(month3) as month3, sum(month4) as month4, sum(month5) as month5, sum(month6) as month6, sum(month7) as month7, sum(month8) as month8, sum(month9) as month9, sum(month10) as month10, sum(month11) as month11, sum(month12) as month12 from salrep where rep=  '" . $row_rep["rep"] . "' and  scat='" . $row_cus1['scat'] . "' and (month1!= '0' or month2!= '0' or month3!= '0' or month4!= '0' or month5!= '0' or month6!= '0' or month7!= '0' or month8!= '0' or month9!= '0' or month10!= '0' or month11!= '0' or month12!= '0') and user_id='" . $_SESSION["CURRENT_USER"] . "' group by cus_code";
                    $result_cus = mysqli_query($GLOBALS['dbinv'],$sql_cus);

                    $mon1 = 0;
                    $mon2 = 0;
                    $mon3 = 0;
                    $mon4 = 0;
                    $mon5 = 0;
                    $mon6 = 0;
                    $mon7 = 0;
                    $mon8 = 0;
                    $mon9 = 0;
                    $mon10 = 0;
                    $mon11 = 0;
                    $mon12 = 0;
                    $totTotal = 0;
                    $totsort_tar = 0;
                    while ($row_cus = mysqli_fetch_array($result_cus)) {


                        $sql_ven = "select * from vendor where code=  '" . $row_cus["cus_code"] . "'";
                        $result_ven = mysqli_query($GLOBALS['dbinv'],$sql_ven);
                        $row_ven = mysqli_fetch_array($result_ven);
                        echo "<tr><td>" . $row_cus["cus_code"] . "-" . $row_ven["NAME"] . "</td>
			<td align=\"right\">" . number_format($row_cus["target"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month1"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month2"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month3"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month4"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month5"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month6"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month7"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month8"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month9"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month10"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month11"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month12"], 2, ".", ",") . "</td>";

                        $Total = $row_cus["month1"] + $row_cus["month2"] + $row_cus["month3"] + $row_cus["month4"] + $row_cus["month5"] + $row_cus["month6"] + $row_cus["month7"] + $row_cus["month8"] + $row_cus["month9"] + $row_cus["month10"] + $row_cus["month11"] + $row_cus["month12"];
                        $sort_tar = $row_rsPrInv["target"] - $Total;
                        $target = $target + $row_cus["target"];
                        $mon1 = $mon1 + $row_cus["month1"];
                        $mon2 = $mon2 + $row_cus["month2"];
                        $mon3 = $mon3 + $row_cus["month3"];
                        $mon4 = $mon4 + $row_cus["month4"];
                        $mon5 = $mon5 + $row_cus["month5"];
                        $mon6 = $mon6 + $row_cus["month6"];
                        $mon7 = $mon7 + $row_cus["month7"];
                        $mon8 = $mon8 + $row_cus["month8"];
                        $mon9 = $mon9 + $row_cus["month9"];
                        $mon10 = $mon10 + $row_cus["month10"];
                        $mon11 = $mon11 + $row_cus["month11"];
                        $mon12 = $mon12 + $row_cus["month12"];

                        $mon1t = $mon1t + $row_cus["month1"];
                        $mon2t = $mon2t + $row_cus["month2"];
                        $mon3t = $mon3t + $row_cus["month3"];
                        $mon4t = $mon4t + $row_cus["month4"];
                        $mon5t = $mon5t + $row_cus["month5"];
                        $mon6t = $mon6t + $row_cus["month6"];
                        $mon7t = $mon7t + $row_cus["month7"];
                        $mon8t = $mon8t + $row_cus["month8"];
                        $mon9t = $mon9t + $row_cus["month9"];
                        $mon10t = $mon10t + $row_cus["month10"];
                        $mon11t = $mon11t + $row_cus["month11"];
                        $mon12t = $mon12t + $row_cus["month12"];

                        $totTotal = $totTotal + $Total;
                        $totsort_tar = $totsort_tar + $sort_tar;
                        $totTotalt = $totTotalt + $Total;
                        $totsort_tart = $totsort_tart + $sort_tar;

                        $targettf = $targettf + $row_cus["target"];

                        $mon1tf = $mon1tf + $row_cus["month1"];
                        $mon2tf = $mon2tf + $row_cus["month2"];
                        $mon3tf = $mon3tf + $row_cus["month3"];
                        $mon4tf = $mon4tf + $row_cus["month4"];
                        $mon5tf = $mon5tf + $row_cus["month5"];
                        $mon6tf = $mon6tf + $row_cus["month6"];
                        $mon7tf = $mon7tf + $row_cus["month7"];
                        $mon8tf = $mon8tf + $row_cus["month8"];
                        $mon9tf = $mon9tf + $row_cus["month9"];
                        $mon10tf = $mon10tf + $row_cus["month10"];
                        $mon11tf = $mon11tf + $row_cus["month11"];
                        $mon12tf = $mon12tf + $row_cus["month12"];

                        $totTotaltf = $totTotaltf + $Total;
                        $totsort_tartf = $totsort_tartf + $sort_tar;


                        echo "<td align=\"right\">" . number_format($Total, 2, ".", ",") . "</td>";
                        echo "<td align=\"right\">" . number_format($sort_tar, 2, ".", ",") . "</td></tr>";
                    }
                    echo "<tr><td></td><td></td>
			<td align=\"right\"><b>" . number_format($week1, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week2, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week3, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week4, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week5, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totTotal, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totsort_tar, 2, ".", ",") . "</b></td></tr>   
                            </tr>";
                }

                echo "<tr><td></td><td></td>
			<td align=\"right\"><b>" . number_format($week1t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week2t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week3t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week4t, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week5t, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totTotalt, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totsort_tart, 2, ".", ",") . "</b></td></tr>   
                            </tr>";
                $week1tf = $week1tf + $week1t;
            }
            echo "<tr><td>&nbsp;</td>
			<td align=\"right\"><b>" . number_format($targettf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week1tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week2tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week3tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week4tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week5tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totTotaltf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totsort_tartf, 2, ".", ",") . "</b></td></tr>";


            echo "</table>";
        }

        function PrintRepsum() {
            require_once("connectioni.php");
            
            

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");



            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];

            $rtxtmonth = date("F", strtotime($_GET["calmon"])) . " " . date("Y", strtotime($_GET["calmon"]));


            if ($_GET["chkdef"] == "1") {
                $txtremark = "Department  " . $_GET["cmbdep"] . "    With Defective";
            }
            if ($_GET["chkdef"] == "0") {
                $txtremark = "Department  " . $_GET["cmbdep"];
            }





            if ($_GET["chkdef"] == "on") {
                $txtremark = "<b>Weekly Sales Report Summery </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"] . "    With Defective";
            }
            if ($_GET["chkdef"] != "on") {
                $txtremark = "Weekly Sales Report Summery</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"];
            }

            echo "<center><table width=\"1000\" border=\"0\">
  <tr>
    
    <th colspan=\"4\" scope=\"col\">" . $rtxtComName . "</th>
   
  </tr>
  <tr>
   
    <td colspan=\"4\" align=\"center\">" . $rtxtcomadd1 . "</td>
   
  </tr>
  <tr>
    
    <td colspan=\"4\" align=\"center\">" . $rtxtComAdd2 . "</td>
   
  </tr>
  <tr>
    <td colspan=\"2\" width=\"600\">" . $txtremark . "</td>
    <td width=\"268\" colspan=2>" . $rtxtmonth . "</td>
   
  </tr>
  <tr>
    <td colspan=4>&nbsp;</td>
  </tr>
</table>";

            echo "<table width='1000' border=1>";



            $sql_rsPrInv = "SELECT rep from salrep  where user_id='" . $_SESSION["CURRENT_USER"] . "' group by rep order by rep ";
            $result_rsPrInv = mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv);
            while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)) {
                echo "
		<tr>
		<th colspan=7 align=left>" . $row_rsPrInv["rep"] . "</th>
		</tr>";


                echo "
		<tr>
		<th></th>
		<th>Week1</th>
		<th>Week2</th>
		<th>Week3</th>
		<th>Week4</th>
		<th>Week5</th>
		<th>Total</th>
		</tr>";


                $sql_rsPrInv = "SELECT sum(week1) as week1,sum(week2) as week2,sum(week3) as week3,sum(week4) as week4,sum(week5) as week5 from salrep where (week1!= '0' or week2!= '0' or week3 !='0' or week4 !='0' or week5!='0') ";
                $sql_rsPrInv1 = $sql_rsPrInv . " and brand <> '' and rep = '" . $row_rsPrInv["rep"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'   ";

                $result_rsPrInv1 = mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv1);
                $row_rsPrInv1 = mysqli_fetch_array($result_rsPrInv1);
                $Total = $row_rsPrInv1["week1"] + $row_rsPrInv1["week2"] + $row_rsPrInv1["week3"] + $row_rsPrInv1["week4"] + $row_rsPrInv1["week5"];

                echo "<tr><td>&nbsp;</td>
			<td align=\"right\">" . number_format($row_rsPrInv1["week1"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv1["week2"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv1["week3"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv1["week4"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_rsPrInv1["week5"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($Total, 2, ".", ",") . "</td>";


                $week1 = $week1 + $row_rsPrInv1["week1"];
                $week2 = $week2 + $row_rsPrInv1["week2"];
                $week3 = $week3 + $row_rsPrInv1["week3"];
                $week4 = $week4 + $row_rsPrInv1["week4"];
                $week5 = $week5 + $row_rsPrInv1["week5"];

                $totTotal = $totTotal + $Total;
            }

            echo "<tr><td>&nbsp;</td>
			<td align=\"right\"><b>" . number_format($week1, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($week2, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($week3, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($week4, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($week5, 2, ".", ",") . "</td>
			<td align=\"right\"><b>" . number_format($totTotal, 2, ".", ",") . "</td></tr>";

            echo "</table>";
        }

        function PrintRep1_repwise2_monthly() {

            require_once("connectioni.php");
            
            

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            if ($_GET["radio"] == "Optcus") {
                $sql_rsPrInv = "SELECT brand, target, sum(month1) as month1, sum(month2) as month2, sum(month3) as month3, sum(month4) as month4, sum(month5) as month5, sum(month6) as month6, sum(month7) as month7, sum(month8) as month8, sum(month9) as month9, sum(month10) as month10, sum(month11) as month11, sum(month12) as month12 from salrep where (month1!= '0' or month2!= '0' or month3!= '0' or month4!= '0' or month5!= '0' or month6!= '0' or month7!= '0' or month8!= '0' or month9!= '0' or month10!= '0' or month11!= '0' or month12!= '0') and user_id='" . $_SESSION["CURRENT_USER"] . "' ";
                //Section10.Suppress = True
            } else {
                $sql_rsPrInv = "SELECT brand,  target, sum(month1) as month1, sum(month2) as month2, sum(month3) as month3, sum(month4) as month4, sum(month5) as month5, sum(month6) as month6, sum(month7) as month7, sum(month8) as month8, sum(month9) as month9, sum(month10) as month10, sum(month11) as month11, sum(month12) as month12 from salrep where (month1!= '0' or month2!= '0' or month3!= '0' or month4!= '0' or month5!= '0' or month6!= '0' or month7!= '0' or month8!= '0' or month9!= '0' or month10!= '0' or month11!= '0' or month12!= '0') and user_id='" . $_SESSION["CURRENT_USER"] . "' ";
            }


            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            $rtxtmonth = date("F", strtotime($_GET["calmon"])) . " " . date("Y", strtotime($_GET["calmon"]));
            if ($_GET["chkdef"] == "on") {
                $txtremark = "<b>Monthly Sales Report Rep Wise</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sales Rep - " . $_GET["cmbdep"] . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"] . "    With Defective";
            }
            if ($_GET["chkdef"] != "on") {
                $txtremark = "Monthly Sales Report Rep Wise</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sales Rep - " . $_GET["cmbcat"] . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"];
            }

            echo "<center><table width=\"1000\" border=\"0\">
  <tr>
    
    <th colspan=\"4\" scope=\"col\">" . $rtxtComName . "</th>
   
  </tr>
  <tr>
   
    <td colspan=\"4\" align=\"center\">" . $rtxtcomadd1 . "</td>
   
  </tr>
  <tr>
    
    <td colspan=\"4\" align=\"center\">" . $rtxtComAdd2 . "</td>
   
  </tr>
  <tr>
    <td colspan=\"2\" width=\"600\">" . $txtremark . "</td>
    <td width=\"268\" colspan=2>" . $rtxtmonth . "</td>
   
  </tr>
  <tr>
    <td colspan=4>&nbsp;</td>
  </tr>
</table>";

            echo "<center><table width=1000 border=1>
		";


            echo "<center><table width=1000 border=1>";
            echo "
		<tr>
		<th>Brand</th>
		<th>Target</th>
		<th>January</th>
		<th>February</th>
		<th>March</th>
		<th>April</th>
		<th>May</th>
		<th>June</th>
		<th>July</th>
		<th>Augest</th>
		<th>September</th>
		<th>October</th>
		<th>November</th>
		<th>December</th>
		<th>Total</th>
		<th>Sort to Target</th>
		</tr>";

            $sql_rep = "select rep from salrep_mon where rep <> '' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by rep";
            $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);

            $mon1tf = 0;
            $mon2tf = 0;
            $mon3tf = 0;
            $mon4tf = 0;
            $mon5tf = 0;
            $mon6tf = 0;
            $mon7tf = 0;
            $mon8tf = 0;
            $mon9tf = 0;
            $mon10tf = 0;
            $mon11tf = 0;
            $mon12tf = 0;
            $totTotaltf = 0;
            $totsort_tartf = 0;

            // while ($row_rep = mysqli_fetch_array($result_rep)) {
            $mon1t = 0;
            $mon2t = 0;
            $mon3t = 0;
            $mon4t = 0;
            $mon5t = 0;
            $mon6t = 0;
            $mon7t = 0;
            $mon8t = 0;
            $mon9t = 0;
            $mon10t = 0;
            $mon11t = 0;
            $mon12t = 0;
            $totTotalt = 0;
            $totsort_tart = 0;

            //    echo "<th colspan=9 align=left><font color='brown' SIZE=4><b>" . $row_rep["rep"] . "</b></th></tr>";


            $sql_cus1 = "select scat from salrep_mon where user_id='" . $_SESSION["CURRENT_USER"] . "'  group by scat";
            $result_cus1 = mysqli_query($GLOBALS['dbinv'],$sql_cus1);

            while ($row_cus1 = mysqli_fetch_array($result_cus1)) {
                echo "<th colspan=16 align=left><b>" . $row_cus1["scat"] . "<b></th></tr>";


                $sql_cus = "select cus_code,target,sum(month1) as month1, sum(month2) as month2 ,sum(month3) as month3 ,sum(month4) as month4 ,sum(month5) as month5 ,sum(month6) as month6 ,sum(month7) as month7 ,sum(month8) as month8 ,sum(month9) as month9 ,sum(month10) as month10 ,sum(month11) as month11, sum(month12) as month12 from salrep_mon where  scat='" . $row_cus1['scat'] . "' and (month1!= '0' or month2!= '0' or month3!= '0' or month4!= '0' or month5!= '0' or month6!= '0' or month7!= '0' or month8!= '0' or month9!= '0' or month10!= '0' or month11!= '0' or month12!= '0') and user_id='" . $_SESSION["CURRENT_USER"] . "' group by cus_code";
                $result_cus = mysqli_query($GLOBALS['dbinv'],$sql_cus);

                $mon1 = 0;
                $mon2 = 0;
                $mon3 = 0;
                $mon4 = 0;
                $mon5 = 0;
                $mon6 = 0;
                $mon7 = 0;
                $mon8 = 0;
                $mon9 = 0;
                $mon10 = 0;
                $mon11 = 0;
                $mon12 = 0;

                $totTotal = 0;
                $totsort_tar = 0;
                while ($row_cus = mysqli_fetch_array($result_cus)) {


                    $sql_ven = "select * from vendor where code=  '" . $row_cus["cus_code"] . "'";
                    $result_ven = mysqli_query($GLOBALS['dbinv'],$sql_ven);
                    $row_ven = mysqli_fetch_array($result_ven);





                    echo "<tr><td>" . $row_cus["cus_code"] . "-" . $row_ven["NAME"] . "</td>
			<td align=\"right\">" . number_format($row_cus["target"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month1"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month2"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month3"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month4"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month5"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month6"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month7"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month8"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month9"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month10"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month11"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["month12"], 2, ".", ",") . "</td>";

                    $Total = $row_cus["month1"] + $row_cus["month2"] + $row_cus["month3"] + $row_cus["month4"] + $row_cus["month5"] + $row_cus["month6"] + $row_cus["month7"] + $row_cus["month8"] + $row_cus["month9"] + $row_cus["month10"] + $row_cus["month11"] + $row_cus["month12"];
                    $sort_tar = $row_rsPrInv["target"] - $Total;
                    $target = $target + $row_cus["target"];
                    $mon1 = $mon1 + $row_cus["month1"];
                    $mon2 = $mon2 + $row_cus["month2"];
                    $mon3 = $mon3 + $row_cus["month3"];
                    $mon4 = $mon4 + $row_cus["month4"];
                    $mon5 = $mon5 + $row_cus["month5"];
                    $mon6 = $mon6 + $row_cus["month6"];
                    $mon7 = $mon7 + $row_cus["month7"];
                    $mon8 = $mon8 + $row_cus["month8"];
                    $mon9 = $mon9 + $row_cus["month9"];
                    $mon10 = $mon10 + $row_cus["month10"];
                    $mon11 = $mon11 + $row_cus["month11"];
                    $mon12 = $mon12 + $row_cus["month12"];

                    $mon1t = $mon1t + $row_cus["month1"];
                    $mon2t = $mon2t + $row_cus["month2"];
                    $mon3t = $mon3t + $row_cus["month3"];
                    $mon4t = $mon4t + $row_cus["month4"];
                    $mon5t = $mon5t + $row_cus["month5"];
                    $mon6t = $mon6t + $row_cus["month6"];
                    $mon7t = $mon7t + $row_cus["month7"];
                    $mon8t = $mon8t + $row_cus["month8"];
                    $mon9t = $mon9t + $row_cus["month9"];
                    $mon10t = $mon10t + $row_cus["month10"];
                    $mon11t = $mon11t + $row_cus["month11"];
                    $mon12t = $mon12t + $row_cus["month12"];


                    $totTotal = $totTotal + $Total;
                    $totsort_tar = $totsort_tar + $sort_tar;
                    $totTotalt = $totTotalt + $Total;
                    $totsort_tart = $totsort_tart + $sort_tar;

                    $targettf = $targettf + $row_cus["target"];

                    $mon1tf = $mon1tf + $row_cus["month1"];
                    $mon2tf = $mon2tf + $row_cus["month2"];
                    $mon3tf = $mon3tf + $row_cus["month3"];
                    $mon4tf = $mon4tf + $row_cus["month4"];
                    $mon5tf = $mon5tf + $row_cus["month5"];
                    $mon6tf = $mon6tf + $row_cus["month6"];
                    $mon7tf = $mon7tf + $row_cus["month7"];
                    $mon8tf = $mon8tf + $row_cus["month8"];
                    $mon9tf = $mon9tf + $row_cus["month9"];
                    $mon10tf = $mon10tf + $row_cus["month10"];
                    $mon11tf = $mon11tf + $row_cus["month11"];
                    $mon12tf = $mon12tf + $row_cus["month12"];

                    $totTotaltf = $totTotaltf + $Total;
                    $totsort_tartf = $totsort_tartf + $sort_tar;


                    echo "<td align=\"right\">" . number_format($Total, 2, ".", ",") . "</td>";
                    echo "<td align=\"right\">" . number_format($sort_tar, 2, ".", ",") . "</td></tr>";
                }
                echo "<tr><td></td><td></td>
			<td align=\"right\"><b>" . number_format($mon1, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon2, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon3, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon4, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon5, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon6, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon7, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon8, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon9, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon10, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon11, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon12, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totTotal, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totsort_tar, 2, ".", ",") . "</b></td></tr>   
                            </tr>";
            }

//                echo "<tr><td></td><td></td>
//			<td align=\"right\"><b>" . number_format($week1t, 2, ".", ",") . "</b></td>
//			<td align=\"right\"><b>" . number_format($week2t, 2, ".", ",") . "</b></td>
//			<td align=\"right\"><b>" . number_format($week3t, 2, ".", ",") . "</b></td>
//			<td align=\"right\"><b>" . number_format($week4t, 2, ".", ",") . "</b></td>
//			<td align=\"right\"><b>" . number_format($week5t, 2, ".", ",") . "</b></td>
//                         <td align=\"right\"><b>" . number_format($totTotalt, 2, ".", ",") . "</b></td>
//                         <td align=\"right\"><b>" . number_format($totsort_tart, 2, ".", ",") . "</b></td></tr>   
//                            </tr>";
            //  $mon1tf = $mon1tf + $mon1t;
            //}
            echo "<tr><td>&nbsp;</td>
			<td align=\"right\"><b>" . number_format($targettf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon1tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon2tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon3tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon4tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon5tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon6tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon7tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon8tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon9tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon10tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon11tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($mon12tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totTotaltf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totsort_tartf, 2, ".", ",") . "</b></td></tr>";


            echo "</table>";
        }

        function PrintRep1_repwise2() {

            require_once("connectioni.php");
            
            

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            if ($_GET["radio"] == "Optcus") {
                $sql_rsPrInv = "SELECT brand, target, sum(week1) as week1, sum(week2) as week2, sum(week3) as week3, sum(week4) as week4, sum(week5) as week5 from salrep where week1!= '0' or week2!= '0' or week3 !='0' or week4 !='0' or week5!='0' and user_id='" . $_SESSION["CURRENT_USER"] . "' ";
                //Section10.Suppress = True
            } else {
                $sql_rsPrInv = "SELECT brand,  target, sum(week1) as week1, sum(week2) as week2, sum(week3) as week3, sum(week4) as week4, sum(week5) as week5 from salrep where week1!= '0' or week2!= '0' or week3 !='0' or week4 !='0' or week5!='0' and user_id='" . $_SESSION["CURRENT_USER"] . "' ";
            }


            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            $rtxtmonth = date("F", strtotime($_GET["calmon"])) . " " . date("Y", strtotime($_GET["calmon"]));
            if ($_GET["chkdef"] == "on") {
                $txtremark = "<b>Weekly Sales Report Rep Wise</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sales Rep - " . $_GET["cmbdep"] . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"] . "    With Defective";
            }
            if ($_GET["chkdef"] != "on") {
                $txtremark = "Weekly Sales Report Rep Wise</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sales Rep - " . $_GET["cmbdep"] . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department - " . $_GET["cmbdep"];
            }

            echo "<center><table width=\"1000\" border=\"0\">
  <tr>
    
    <th colspan=\"4\" scope=\"col\">" . $rtxtComName . "</th>
   
  </tr>
  <tr>
   
    <td colspan=\"4\" align=\"center\">" . $rtxtcomadd1 . "</td>
   
  </tr>
  <tr>
    
    <td colspan=\"4\" align=\"center\">" . $rtxtComAdd2 . "</td>
   
  </tr>
  <tr>
    <td colspan=\"2\" width=\"600\">" . $txtremark . "</td>
    <td width=\"268\" colspan=2>" . $rtxtmonth . "</td>
   
  </tr>
  <tr>
    <td colspan=4>&nbsp;</td>
  </tr>
</table>";

            echo "<center><table width=1000 border=1>
		";


            echo "<center><table width=1000 border=1>";
            echo "
		<tr>
		<th>Brand</th>
		<th>Target</th>
		<th>Week1</th>
		<th>Week2</th>
		<th>Week3</th>
		<th>Week4</th>
		<th>Week5</th>
		<th>Total</th>
		<th>Sort to Target</th>
		</tr>";

            $sql_rep = "select rep from salrep where rep <> '' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by rep";
            $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);

            $week2tf = 0;
            $week3tf = 0;
            $week4tf = 0;
            $week5tf = 0;
            $totTotaltf = 0;
            $totsort_tartf = 0;

            //   while ($row_rep = mysqli_fetch_array($result_rep)) {
            $week1t = 0;
            $week2t = 0;
            $week3t = 0;
            $week4t = 0;
            $week5t = 0;
            $totTotalt = 0;
            $totsort_tart = 0;

            //    echo "<th colspan=9 align=left><font color='brown' SIZE=4><b>" . $row_rep["rep"] . "</b></th></tr>";


            $sql_cus1 = "select scat from salrep where user_id='" . $_SESSION["CURRENT_USER"] . "'  group by scat";
            $result_cus1 = mysqli_query($GLOBALS['dbinv'],$sql_cus1);

            while ($row_cus1 = mysqli_fetch_array($result_cus1)) {
                echo "<th colspan=9 align=left><b>" . $row_cus1["scat"] . "<b></th></tr>";


                $sql_cus = "select cus_code,target,sum(week1) as week1,sum(week2) as week2,sum(week3) as week3,sum(week4) as week4,sum(week5) as week5 from salrep where  scat='" . $row_cus1['scat'] . "' and (week1!= '0' or week2!= '0' or week3 !='0' or week4 !='0' or week5!='0') and user_id='" . $_SESSION["CURRENT_USER"] . "' group by cus_code";
                $result_cus = mysqli_query($GLOBALS['dbinv'],$sql_cus);

                $week1 = 0;
                $week2 = 0;
                $week3 = 0;
                $week4 = 0;
                $week5 = 0;
                $totTotal = 0;
                $totsort_tar = 0;
                while ($row_cus = mysqli_fetch_array($result_cus)) {


                    $sql_ven = "select * from vendor where code=  '" . $row_cus["cus_code"] . "'";
                    $result_ven = mysqli_query($GLOBALS['dbinv'],$sql_ven);
                    $row_ven = mysqli_fetch_array($result_ven);













                    echo "<tr><td>" . $row_cus["cus_code"] . "-" . $row_ven["NAME"] . "</td>
			<td align=\"right\">" . number_format($row_cus["target"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["week1"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["week2"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["week3"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["week4"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row_cus["week5"], 2, ".", ",") . "</td>";

                    $Total = $row_cus["week1"] + $row_cus["week2"] + $row_cus["week3"] + $row_cus["week4"] + $row_cus["week5"];
                    $sort_tar = $row_rsPrInv["target"] - $Total;
                    $target = $target + $row_cus["target"];
                    $week1 = $week1 + $row_cus["week1"];
                    $week2 = $week2 + $row_cus["week2"];
                    $week3 = $week3 + $row_cus["week3"];
                    $week4 = $week4 + $row_cus["week4"];
                    $week5 = $week5 + $row_cus["week5"];

                    $week1t = $week1t + $row_cus["week1"];
                    $week2t = $week2t + $row_cus["week2"];
                    $week3t = $week3t + $row_cus["week3"];
                    $week4t = $week4t + $row_cus["week4"];
                    $week5t = $week5t + $row_cus["week5"];


                    $totTotal = $totTotal + $Total;
                    $totsort_tar = $totsort_tar + $sort_tar;
                    $totTotalt = $totTotalt + $Total;
                    $totsort_tart = $totsort_tart + $sort_tar;

                    $targettf = $targettf + $row_cus["target"];

                    $week2tf = $week2tf + $row_cus["week2"];
                    $week3tf = $week3tf + $row_cus["week3"];
                    $week4tf = $week4tf + $row_cus["week4"];
                    $week5tf = $week5tf + $row_cus["week5"];

                    $totTotaltf = $totTotaltf + $Total;
                    $totsort_tartf = $totsort_tartf + $sort_tar;


                    echo "<td align=\"right\">" . number_format($Total, 2, ".", ",") . "</td>";
                    echo "<td align=\"right\">" . number_format($sort_tar, 2, ".", ",") . "</td></tr>";
                }
                echo "<tr><td></td><td></td>
			<td align=\"right\"><b>" . number_format($week1, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week2, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week3, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week4, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week5, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totTotal, 2, ".", ",") . "</b></td>
                         <td align=\"right\"><b>" . number_format($totsort_tar, 2, ".", ",") . "</b></td></tr>   
                            </tr>";
            }

//                echo "<tr><td></td><td></td>
//			<td align=\"right\"><b>" . number_format($week1t, 2, ".", ",") . "</b></td>
//			<td align=\"right\"><b>" . number_format($week2t, 2, ".", ",") . "</b></td>
//			<td align=\"right\"><b>" . number_format($week3t, 2, ".", ",") . "</b></td>
//			<td align=\"right\"><b>" . number_format($week4t, 2, ".", ",") . "</b></td>
//			<td align=\"right\"><b>" . number_format($week5t, 2, ".", ",") . "</b></td>
//                         <td align=\"right\"><b>" . number_format($totTotalt, 2, ".", ",") . "</b></td>
//                         <td align=\"right\"><b>" . number_format($totsort_tart, 2, ".", ",") . "</b></td></tr>   
//                            </tr>";
            $week1tf = $week1tf + $week1t;

            // }
            echo "<tr><td>&nbsp;</td>
			<td align=\"right\"><b>" . number_format($targettf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week1tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week2tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week3tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week4tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($week5tf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totTotaltf, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totsort_tartf, 2, ".", ",") . "</b></td></tr>";


            echo "</table>";
        }
        ?>



    </body>
</html>
