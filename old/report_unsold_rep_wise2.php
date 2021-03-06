<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Unsold Rep Wise Report</title>
        <style>
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
                font-size:13px;

            }
            td
            {
                font-size:13px;

            }
        </style>
    </head>

    <body>
        <!-- Progress bar holder -->
        <!-- Progress information -->
        <div id="information" style="width"></div>

        <?php
        require_once("connectioni.php");
        
        



        $daysover = $_GET["txtdays"];
        $daysbel = $_GET["txtbel"];

        $sql = "delete from tmparmove";
        $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
		
		$ardate_arr= array();
		$AR_NO_arr= array();
		$STK_NO_arr= array();
		$des_arr= array();
		$PART_NO_arr= array();
		$qty_hnd_arr= array();
		$AR_QTY_arr= array();
		$brand_arr= array();
		$SUPPLIER_arr= array(); 
		$LC_NO_arr= array(); 
		$ARVALUE_arr= array(); 
		$period_arr= array(); 
		$monsales_arr= array(); 
		$UN_QTY_arr= array(); 
		$sold_arr= array();
		
		$i_row=0;
		 
        if ($_GET["cmbbrand"] == "All") {
            $sql_smas = "select STK_NO, QTYINHAND  from s_submas where STO_CODE='" . $_GET["com_dep"] . "' AND  QTYINHAND> 0  ";
        }
        if ($_GET["cmbbrand"] != "All") {
            //$sql_smas= "select * from s_submas where STO_CODE='" . $_GET["com_dep"] . "' AND QTYINHAND> 0 and BRAND_NAME='" . $_GET["cmbbrand"] . "'";
            $sql_smas = "select STK_NO, QTYINHAND from s_submas where STO_CODE='" . $_GET["com_dep"] . "' AND QTYINHAND> 0 ";
        }
//echo $sql_smas."</br>";
		
		
        $result_smas = mysqli_query($GLOBALS['dbinv'],$sql_smas);
        while ($row_smas = mysqli_fetch_array($result_smas)) {
//if($row_smas = mysqli_fetch_array($result_smas)){

            $balqty = $row_smas["QTYINHAND"];
            $totarqty = 0;
            $totbalqty = 0;
            // echo $row_smas["STK_NO"];
            $sql_s_mas = "Select DESCRIPT, PART_NO, BRAND_NAME, QTYINHAND, COST, acc_cost from s_mas where STK_NO='" . trim($row_smas["STK_NO"]) . "' ";
            $result_s_mas = mysqli_query($GLOBALS['dbinv'],$sql_s_mas);
            $row_s_mas = mysqli_fetch_array($result_s_mas);
            $totbalqty = $row_s_mas["QTYINHAND"];

            $rownum = 0;

            $sql_artrn = "select REFNO, REC_QTY, SDATE, COST, acc_cost from s_purtrn where STK_NO='" . $row_smas["STK_NO"] . "' and CANCEL='0' order by SDATE desc ";
            //echo "</br></br>".$sql_artrn."</br>";
            $result_artrn = mysqli_query($GLOBALS['dbinv'],$sql_artrn);

            $last = mysqli_num_rows($result_artrn);


            $result_artrn = mysqli_query($GLOBALS['dbinv'],$sql_artrn);
            $row_artrn = mysqli_fetch_array($result_artrn);



            while ($balqty != 0) {
                //echo  "(last : ".$last."/ key :".$rownum.")";
                $update = 0;
                if ($last >= $rownum) {

                    $totarqty = $totarqty + $row_artrn["REC_QTY"];
                    $sql_sgin = "select REF_NO from s_ginmas where AR_NO = '" . trim($row_artrn["REFNO"]) . "' and DEP_TO = '" . $_GET["com_dep"] . "'";
                    // echo $sql_sgin."</br>";
                    $result_sgin = mysqli_query($GLOBALS['dbinv'],$sql_sgin);
                    if ($row_sgin = mysqli_fetch_array($result_sgin)) {

                        $result_sgin = mysqli_query($GLOBALS['dbinv'],$sql_sgin);
                        while ($row_sgin = mysqli_fetch_array($result_sgin)) {
                            $update = 0;
                            //echo $result_sgin;
                            $sql_strn = "select QTY from s_trn where REFNO = '" . trim($row_sgin["REF_NO"]) . "' and STK_NO = '" . $row_smas["STK_NO"] . "' and DEPARTMENT = '" . $_GET["com_dep"] . "'";
                            $result_strn = mysqli_query($GLOBALS['dbinv'],$sql_strn);
                            if ($row_strn = mysqli_fetch_array($result_strn)) {
                                $result_strn = mysqli_query($GLOBALS['dbinv'],$sql_strn);
                                while ($row_strn = mysqli_fetch_array($result_strn)) {

                                    $ardate = $row_artrn["SDATE"];
                                    $AR_NO = trim($row_artrn["REFNO"]);
                                    $STK_NO = trim($row_smas["STK_NO"]);
                                    $des = trim($row_s_mas["DESCRIPT"]);
                                    $PART_NO = trim($row_s_mas["PART_NO"]);
                                    $qty_hnd = $row_smas["QTYINHAND"];
                                    $AR_QTY = $row_artrn["REC_QTY"];
                                    $brand = $row_s_mas["BRAND_NAME"];


                                    $sql_armas = "select SUP_NAME, LCNO from s_purmas where REFNO='" . $row_artrn["REFNO"] . "' ";
                                    $result_armas = mysqli_query($GLOBALS['dbinv'],$sql_armas);
                                    if ($row_armas = mysqli_fetch_array($result_armas)) {
                                        $SUPPLIER = trim($row_armas["SUP_NAME"]);
                                        $LC_NO = trim($row_armas["LCNO"]);
                                    }

                                    if ($_SESSION['dev'] == '1') {
                                        $ARVALUE = $row_artrn["COST"] * $row_artrn["REC_QTY"];
                                    } else if ($_SESSION['dev'] == '0') {
                                        $ARVALUE = $row_artrn["acc_cost"] * $row_artrn["REC_QTY"];
                                    }
                                    $period = (strtotime(date("Y-m-d")) - strtotime($row_artrn["SDATE"]) ) / (60 * 60 * 24);

                                    if ($balqty > $row_strn["QTY"]) {
                                        $monsales = 0;

                                        $UN_QTY = $row_strn["QTY"];

                                        if ($_SESSION['dev'] == '1') {
                                            $sold = $row_s_mas["COST"];
                                        } else if ($_SESSION['dev'] == '0') {
                                            $sold = $row_s_mas["acc_cost"];
                                        }

                                        $balqty = $balqty - $row_strn["QTY"];
                                        if ($row_s_mas["QTYINHAND"] < $totarqty) {
//// 1 /////////////////////////////                                    

                                            if ($update == 0) {
                                              //  $sqltmp = "insert into tmparmove(ardate, AR_NO, STK_NO, des, PART_NO, qty_hnd, AR_QTY, brand, SUPPLIER, LC_NO, ARVALUE, period, monsales, UN_QTY, sold) values ('" . $ardate . "', '" . $AR_NO . "', '" . $STK_NO . "', '" . $des . "', '" . $PART_NO . "', " . $qty_hnd . ", " . $AR_QTY . ", '" . $brand . "', '" . $SUPPLIER . "', '" . $LC_NO . "', " . $ARVALUE . ", " . $period . ", " . $monsales . ", " . $UN_QTY . ", " . $sold . ") ";
                                                //echo "<br> 1 ".$sqltmp;
                                             //   $resulttmp = mysqli_query($GLOBALS['dbinv'],$sqltmp);
											   
											   $ardate_arr[$i_row]=$ardate;
												$AR_NO_arr[$i_row]=$AR_NO;
												$STK_NO_arr[$i_row]=$STK_NO;
												$des_arr[$i_row]=$des;
												$PART_NO_arr[$i_row]=$PART_NO;
												$qty_hnd_arr[$i_row]=$qty_hnd;
												$AR_QTY_arr[$i_row]=$AR_QTY;
												$brand_arr[$i_row]=$brand;
												$SUPPLIER_arr[$i_row]=$SUPPLIER;
												$LC_NO_arr[$i_row]=$LC_NO;
												$ARVALUE_arr[$i_row]=$ARVALUE;
												$period_arr[$i_row]=$period;
												$monsales_arr[$i_row]=$monsales;
												$UN_QTY_arr[$i_row]=$UN_QTY;
												$sold_arr[$i_row]=$sold;
										
												$i_row=$i_row+1;
										
                                                $update = 1;
                                            }
                                            $sql_tmp1 = "Select UN_QTY, AR_NO, STK_NO from tmparmove where STK_NO = '" . trim($row_smas["STK_NO"]) . "' order by ardate ";
                                            $result_tmp1 = mysqli_query($GLOBALS['dbinv'],$sql_tmp1);
                                            if ($row_tmp1 = mysqli_fetch_array($result_tmp1)) {
                                                $sql = "update tmparmove set UN_QTY = '" . ($row_tmp1["UN_QTY"] + $balqty) . "' where AR_NO = '" . $row_tmp1["AR_NO"] . "' and STK_NO = '" . trim($row_smas["STK_NO"]) . "'";
                                                $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
												echo $row_smas["STK_NO"]."</br>";
                                            } else {
                                                $UN_QTY = $row_strn["QTY"] + $balqty;
                                            }
											
											$i=0;
											$detect=0;
											
											while ($i<=$i_row){
												
												if ($STK_NO_arr[$i]==$STK_NO){
													
													if ($AR_NO_arr[$i]==$AR_NO){
														//echo $i_row."-".$STK_NO_arr[$i]."</br>";
														$UN_QTY_arr[$i]=$UN_QTY_arr[$i]+$balqty;
														
													}
													$detect=1;
												}
												$i=$i+1;
											}
											
											if ($detect==0){
												$UN_QTY_arr[$i_row] = $UN_QTY + $balqty;
											}
                                            $balqty = 0;
                                        }
                                    } else {

                                        $date = $row_artrn["SDATE"];
                                        $date = strtotime(date("Y-m-d", strtotime($date)) . " +30 days");
                                        $caldate = date("Y-m-d", $date);

                                        $sql_saltr = "select QTY from s_invo where STK_NO='" . $row_smas["STK_NO"] . "' and CANCELL='0' and DEPARTMENT = '" . $_GET["com_dep"] . "' and (SDATE>'" . $row_artrn["SDATE"] . "' or SDATE='" . $row_artrn["SDATE"] . "') and SDATE<'" . $caldate . "'";
                                        $result_saltr = mysqli_query($GLOBALS['dbinv'],$sql_saltr);


                                        $salqty = 0;
                                        while ($row_saltr = mysqli_fetch_array($result_saltr)) {
                                            $salqty = $salqty + $row_saltr["QTY"];
                                        }
                                        if (($totbalqty <= 0) and ( $balqty > 0)) {
                                            $date = date("Y-m-d");
                                            $date = strtotime(date("Y-m-d", strtotime($date)) . " -91 days");
                                            $caldate = date("Y-m-d", $date);

                                            $sql_rs = "select sum(REC_QTY) as stk from s_purtrn where STK_NO='" . $row_smas["STK_NO"] . "' and CANCEL='0' and SDATE > '" . $caldate . "'";
                                            $result_rs = mysqli_query($GLOBALS['dbinv'],$sql_rs);
                                            $row_rs = mysqli_fetch_array($result_rs);

                                            $mnewstk = 0;
                                            $txtunsold = 0;
                                            if (is_null($row_rs["stk"]) == false) {
                                                $mnewstk = $row_rs["stk"];
                                            }
                                            if ($row_s_mas["QTYINHAND"] > $mnewstk) {
                                                $txtunsold = $row_s_mas["QTYINHAND"] - $mnewstk;
                                            }
                                            if ($txtunsold > 0) {
                                                $UN_QTY = $balqty;

                                                if ($_SESSION['dev'] == '1') {
                                                    $sold = $row_s_mas["COST"];
                                                } else if ($_SESSION['dev'] == '0') {
                                                    $sold = $row_s_mas["acc_cost"];
                                                }
                                            } else {
                                                $UN_QTY = "0";

                                                $monsales = "0";
                                                $sold = "0";
                                            }
                                        } else {
                                            $UN_QTY = $balqty;

                                            if ($_SESSION['dev'] == '1') {
                                                $sold = $row_s_mas["COST"];
                                            } else if ($_SESSION['dev'] == '0') {
                                                $sold = $row_s_mas["acc_cost"];
                                            }
                                        }

                                        $balqty = 0;
                                    }
//// 2 ///////////////////////////// 
                                    if ($update == 0) {
									
										$ardate_arr[$i_row]=$ardate;
										$AR_NO_arr[$i_row]=$AR_NO;
										$STK_NO_arr[$i_row]=$STK_NO;
										$des_arr[$i_row]=$des;
										$PART_NO_arr[$i_row]=$PART_NO;
										$qty_hnd_arr[$i_row]=$qty_hnd;
										$AR_QTY_arr[$i_row]=$AR_QTY;
										$brand_arr[$i_row]=$brand;
										$SUPPLIER_arr[$i_row]=$SUPPLIER;
										$LC_NO_arr[$i_row]=$LC_NO;
										$ARVALUE_arr[$i_row]=$ARVALUE;
										$period_arr[$i_row]=$period;
										$monsales_arr[$i_row]=$monsales;
										$UN_QTY_arr[$i_row]=$UN_QTY;
										$sold_arr[$i_row]=$sold;
										
										//  $sqltmp = "insert into tmparmove(ardate, AR_NO, STK_NO, des, PART_NO, qty_hnd, AR_QTY, brand, SUPPLIER, LC_NO, ARVALUE, period, monsales, UN_QTY, sold) values ('" . $ardate . "', '" . $AR_NO . "', '" . $STK_NO . "', '" . $des . "', '" . $PART_NO . "', " . $qty_hnd . ", " . $AR_QTY . ", '" . $brand . "', '" . $SUPPLIER . "', '" . $LC_NO . "', " . $ARVALUE . ", " . $period . ", " . $monsales . ", " . $UN_QTY . ", " . $sold . ") ";
                                                //echo "<br> 1 ".$sqltmp;
                                       //         $resulttmp = mysqli_query($GLOBALS['dbinv'],$sqltmp);
												
										$i_row=$i_row+1;
										
                                        $update = 2;
                                    }
                                }
                            } else {



                                $ardate = $row_artrn["SDATE"];
                                $AR_NO = trim($row_artrn["REFNO"]);
                                $STK_NO = trim($row_smas["STK_NO"]);
                                $des = trim($row_s_mas["DESCRIPT"]);
                                $PART_NO = trim($row_s_mas["PART_NO"]);
                                $qty_hnd = $row_smas["QTYINHAND"];
                                $AR_QTY = $row_artrn["REC_QTY"];
                                $brand = $row_s_mas["BRAND_NAME"];

                                $sql_armas = "select SUP_NAME, LCNO from s_purmas where REFNO='" . $row_artrn["REFNO"] . "'";
                                $result_armas = mysqli_query($GLOBALS['dbinv'],$sql_armas);
                                if ($row_armas = mysqli_fetch_array($result_armas)) {

                                    $SUPPLIER = trim($row_armas["SUP_NAME"]);
                                    $LC_NO = trim($row_armas["LCNO"]);
                                }

                                if ($_SESSION['dev'] == '1') {
                                    $ARVALUE = $row_artrn["COST"] * $row_artrn["REC_QTY"];
                                } else if ($_SESSION['dev'] == '0') {
                                    $ARVALUE = $row_artrn["acc_cost"] * $row_artrn["REC_QTY"];
                                }
                                $period = (strtotime(date("Y-m-d")) - strtotime($row_artrn["SDATE"]) ) / (60 * 60 * 24);

                                if ($totbalqty > $row_artrn["REC_QTY"]) {
                                    $UN_QTY = "0";
                                    $monsales = "0";
                                    $sold = "0";
                                } else {
                                    $UN_QTY = $balqty;
                                    if ($_SESSION['dev'] == '1') {
                                        $monsales = $row_s_mas["COST"] * ($salqty - $row_artrn["QTYINHAND"]);
                                        $sold = $row_s_mas["COST"];
                                    } else if ($_SESSION['dev'] == '0') {
                                        $monsales = $row_s_mas["acc_cost"] * ($salqty - $row_artrn["QTYINHAND"]);
                                        $sold = $row_s_mas["acc_cost"];
                                    }
                                    $balqty = 0;
                                }
                                if ($update == 0) {
									
									$ardate_arr[$i_row]=$ardate;
												$AR_NO_arr[$i_row]=$AR_NO;
												$STK_NO_arr[$i_row]=$STK_NO;
												$des_arr[$i_row]=$des;
												$PART_NO_arr[$i_row]=$PART_NO;
												$qty_hnd_arr[$i_row]=$qty_hnd;
												$AR_QTY_arr[$i_row]=$AR_QTY;
												$brand_arr[$i_row]=$brand;
												$SUPPLIER_arr[$i_row]=$SUPPLIER;
												$LC_NO_arr[$i_row]=$LC_NO;
												$ARVALUE_arr[$i_row]=$ARVALUE;
												$period_arr[$i_row]=$period;
												$monsales_arr[$i_row]=$monsales;
												$UN_QTY_arr[$i_row]=$UN_QTY;
												$sold_arr[$i_row]=$sold;
										
												$i_row=$i_row+1;
                                   // $sqltmp = "insert into tmparmove(ardate, AR_NO, STK_NO, des, PART_NO, qty_hnd, AR_QTY, brand, SUPPLIER, LC_NO, ARVALUE, period, monsales, UN_QTY, sold) values ('" . $ardate . "', '" . $AR_NO . "', '" . $STK_NO . "', '" . $des . "', '" . $PART_NO . "', " . $qty_hnd . ", " . $AR_QTY . ", '" . $brand . "', '" . $SUPPLIER . "', '" . $LC_NO . "', " . $ARVALUE . ", " . $period . ", " . $monsales . ", " . $UN_QTY . ", " . $sold . ") ";
                                    //echo "<br> 3 ".$sqltmp;
                                  //  $resulttmp = mysqli_query($GLOBALS['dbinv'],$sqltmp);
                                    $update = 3;
                                }
                                if ($totbalqty < "0") {
                                    $balqty = 0;
                                }
                            }
                        }
                        $totbalqty = $totbalqty - $row_artrn["REC_QTY"];
                        $row_artrn = mysqli_fetch_assoc($result_artrn);
                        $rownum = $rownum + 1;
                        //echo "/".$rownum;
                    } else {


                        $ardate = $row_artrn["SDATE"];
                        $AR_NO = trim($row_artrn["REFNO"]);
                        $STK_NO = trim($row_smas["STK_NO"]);
                        $des = trim($row_s_mas["DESCRIPT"]);
                        $PART_NO = trim($row_s_mas["PART_NO"]);
                        $qty_hnd = $row_smas["QTYINHAND"];
                        $AR_QTY = $row_artrn["REC_QTY"];
                        $brand = $row_s_mas["BRAND_NAME"];



                        $sql_armas = "select SUP_NAME, LCNO from s_purmas where REFNO='" . $row_artrn["REFNO"] . "'";
                        $result_armas = mysqli_query($GLOBALS['dbinv'],$sql_armas);
                        if ($row_armas = mysqli_fetch_array($result_armas)) {
                            $SUPPLIER = trim($row_armas["SUP_NAME"]);
                            $LC_NO = trim($row_armas["LCNO"]);
                        }

                        if ($_SESSION['dev'] == '1') {
                            $ARVALUE = $row_artrn["COST"] * $row_artrn["REC_QTY"];
                        } else if ($_SESSION['dev'] == '0') {
                            $ARVALUE = $row_artrn["acc_cost"] * $row_artrn["REC_QTY"];
                        }
                        $period = (strtotime(date("Y-m-d")) - strtotime($row_artrn["SDATE"]) ) / (60 * 60 * 24);

                        if ($row_s_mas["QTYINHAND"] < $totarqty) {
                            $monsales = 0;
                            $UN_QTY = $balqty;
                            if ($_SESSION['dev'] == '1') {
                                $sold = $row_s_mas["COST"];
                            } else if ($_SESSION['dev'] == '0') {
                                $sold = $row_s_mas["acc_cost"];
                            }
                            $balqty = 0;
                            $totbalqty = $totbalqty - $row_artrn["REC_QTY"];
                            $row_artrn = mysqli_fetch_assoc($result_artrn);
                            $rownum = $rownum + 1;
                            //echo "/".$rownum;
                        } else {
                            $date = $row_artrn["SDATE"];
                            $date = strtotime(date("Y-m-d", strtotime($date)) . " +30 days");
                            $caldate = date("Y-m-d", $date);
                            $sql_saltr = "select qty from s_invo where STK_NO='" . $row_smas["STK_NO"] . "' and CANCELL='0' and DEPARTMENT = '" . $_GET["com_dep"] . "' and(SDATE>'" . $row_artrn["SDATE"] . "' or SDATE='" . $row_artrn["SDATE"] . "') and SDATE<'" . $caldate . "'";
                            $result_saltr = mysqli_query($GLOBALS['dbinv'],$sql_saltr);

                            $salqty = 0;
                            while ($row_saltr = mysqli_fetch_array($result_saltr)) {
                                $salqty = $salqty + $row_saltr["qty"];
                            }
                            $UN_QTY = 0;
                            $monsales = 0;
                            $sold = 0;

                            $totbalqty = $totbalqty - $row_artrn["REC_QTY"];
                            $row_artrn = mysqli_fetch_assoc($result_artrn);
                            $rownum = $rownum + 1;
                            //echo "/".$rownum;
                        }
                        if ($update == 0) {
                         
						   $ardate_arr[$i_row]=$ardate;
												$AR_NO_arr[$i_row]=$AR_NO;
												$STK_NO_arr[$i_row]=$STK_NO;
												$des_arr[$i_row]=$des;
												$PART_NO_arr[$i_row]=$PART_NO;
												$qty_hnd_arr[$i_row]=$qty_hnd;
												$AR_QTY_arr[$i_row]=$AR_QTY;
												$brand_arr[$i_row]=$brand;
												$SUPPLIER_arr[$i_row]=$SUPPLIER;
												$LC_NO_arr[$i_row]=$LC_NO;
												$ARVALUE_arr[$i_row]=$ARVALUE;
												$period_arr[$i_row]=$period;
												$monsales_arr[$i_row]=$monsales;
												$UN_QTY_arr[$i_row]=$UN_QTY;
												$sold_arr[$i_row]=$sold;
										
												$i_row=$i_row+1;
									
                            $update = 4;
                        }
                    }
//// 5 /////////////////////////////   
                    if ($update == 0) {
                      //  $sqltmp = "insert into tmparmove(ardate, AR_NO, STK_NO, des, PART_NO, qty_hnd, AR_QTY, brand, SUPPLIER, LC_NO, ARVALUE, period, monsales, UN_QTY, sold) values ('" . $ardate . "', '" . $AR_NO . "', '" . $STK_NO . "', '" . $des . "', '" . $PART_NO . "', " . $qty_hnd . ", " . $AR_QTY . ", '" . $brand . "', '" . $SUPPLIER . "', '" . $LC_NO . "', " . $ARVALUE . ", " . $period . ", " . $monsales . ", " . $UN_QTY . ", " . $sold . ") ";
                        //echo "<br> 5 ".$sqltmp;
                     //   $resulttmp = mysqli_query($GLOBALS['dbinv'],$sqltmp);
					   
					   $ardate_arr[$i_row]=$ardate;
												$AR_NO_arr[$i_row]=$AR_NO;
												$STK_NO_arr[$i_row]=$STK_NO;
												$des_arr[$i_row]=$des;
												$PART_NO_arr[$i_row]=$PART_NO;
												$qty_hnd_arr[$i_row]=$qty_hnd;
												$AR_QTY_arr[$i_row]=$AR_QTY;
												$brand_arr[$i_row]=$brand;
												$SUPPLIER_arr[$i_row]=$SUPPLIER;
												$LC_NO_arr[$i_row]=$LC_NO;
												$ARVALUE_arr[$i_row]=$ARVALUE;
												$period_arr[$i_row]=$period;
												$monsales_arr[$i_row]=$monsales;
												$UN_QTY_arr[$i_row]=$UN_QTY;
												$sold_arr[$i_row]=$sold;
										
												$i_row=$i_row+1;
									
                        $update = 5;
                    }
                } else {
                    exit();
                }
                //echo $balqty;
            }
             
        }

      /*  if ($_GET["cmbtype"] == "All") {
            $sql_rst = "select * from tmparmove ";
        }
        if ($_GET["cmbtype"] == "Over") {
            $sql_rst = "select * from tmparmove where period>" . $daysover;
        }
        if ($_GET["cmbtype"] == "Between") {
            $sql_rst = "select * from tmparmove where period>" . $daysover . " and period<" . $daysbel;
        }*/
//echo $sql_rst;

		if ($_GET["cmbtype"] == "All") {
			$i=0;
			while ($i_row>$i){
				if ($period_arr[$i] < 31) {
               	 	$b30 = $b30 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if (($period_arr[$i] > 30) and ( $period_arr[$i] < 46)) {
                	$o36b45 = $o36b45 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if (($period_arr[$i] > 45) and ( $period_arr[$i] < 61)) {
                	$o46b60 = $o46b60 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if (($period_arr[$i] > 60) and ( $period_arr[$i] < 76)) {
                	$o61b75 = $o61b75 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if (($period_arr[$i] > 75) and ( $period_arr[$i] < 91)) {
                	$o76b91 = $o76b91 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if ($period_arr[$i] > 90) {
                	$o91 = $o91 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if ((is_null($sold_arr[$i]) == false) and ( is_null($UN_QTY_arr[$i]) == false)) {
                	$total = $total + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
				
            	
				$i=$i+1;
			}	
        }
        if ($_GET["cmbtype"] == "Over") {
			$i=0;
			while ($i_row>$i){
			  
			  if ($daysover	<$period_arr[$i]){
				if ($period_arr[$i] < 31) {
               	 	$b30 = $b30 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if (($period_arr[$i] > 30) and ( $period_arr[$i] < 46)) {
                	$o36b45 = $o36b45 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if (($period_arr[$i] > 45) and ( $period_arr[$i] < 61)) {
                	$o46b60 = $o46b60 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if (($period_arr[$i] > 60) and ( $period_arr[$i] < 76)) {
                	$o61b75 = $o61b75 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if (($period_arr[$i] > 75) and ( $period_arr[$i] < 91)) {
                	$o76b91 = $o76b91 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if ($period_arr[$i] > 90) {
                	$o91 = $o91 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if ((is_null($sold_arr[$i]) == false) and ( is_null($UN_QTY_arr[$i]) == false)) {
                	$total = $total + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
			  }	
            	$i=$i+1;
			}	
           
        }
        if ($_GET["cmbtype"] == "Between") {
			$i=0;
			while ($i_row>$i){
			  
			  if (($daysover	<$period_arr[$i]) and ($daysbel	>$period_arr[$i])){
				if ($period_arr[$i] < 31) {
               	 	$b30 = $b30 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if (($period_arr[$i] > 30) and ( $period_arr[$i] < 46)) {
                	$o36b45 = $o36b45 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if (($period_arr[$i] > 45) and ( $period_arr[$i] < 61)) {
                	$o46b60 = $o46b60 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if (($period_arr[$i] > 60) and ( $period_arr[$i] < 76)) {
                	$o61b75 = $o61b75 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if (($period_arr[$i] > 75) and ( $period_arr[$i] < 91)) {
                	$o76b91 = $o76b91 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if ($period_arr[$i] > 90) {
                	$o91 = $o91 + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
            	if ((is_null($sold_arr[$i]) == false) and ( is_null($UN_QTY_arr[$i]) == false)) {
                	$total = $total + $UN_QTY_arr[$i] * $sold_arr[$i];
            	}
			  }	
            	$i=$i+1;
			}	
           // $sql_rst = "select * from tmparmove where period>" . $daysover . " and period<" . $daysbel;
        }
		
		
     /*   $result_rst = mysqli_query($GLOBALS['dbinv'],$sql_rst);
        while ($row_rst = mysqli_fetch_array($result_rst)) {

            if ($row_rst["period"] < 31) {
                $b30 = $b30 + $row_rst["UN_QTY"] * $row_rst["sold"];
            }
            if (($row_rst["period"] > 30) and ( $row_rst["period"] < 46)) {
                $o36b45 = $o36b45 + $row_rst["UN_QTY"] * $row_rst["sold"];
            }
            if (($row_rst["period"] > 45) and ( $row_rst["period"] < 61)) {
                $o46b60 = $o46b60 + $row_rst["UN_QTY"] * $row_rst["sold"];
            }
            if (($row_rst["period"] > 60) and ( $row_rst["period"] < 76)) {
                $o61b75 = $o61b75 + $row_rst["UN_QTY"] * $row_rst["sold"];
            }
            if (($row_rst["period"] > 75) and ( $row_rst["period"] < 91)) {
                $o76b91 = $o76b91 + $row_rst["UN_QTY"] * $row_rst["sold"];
            }
            if ($row_rst["period"] > 90) {
                $o91 = $o91 + $row_rst["UN_QTY"] * $row_rst["sold"];
            }
            if ((is_null($row_rst["sold"]) == false) and ( is_null($row_rst["UN_QTY"]) == false)) {
                $total = $total + $row_rst["UN_QTY"] * $row_rst["sold"];
            }
        }*/


		echo "AAAAAAAAA";

        if ($_GET["unsold"] == "summery") {
			echo "BBBBBBBBBBBBB";
            printSummery();
            exit();
        }
        /* if op_Stock Then
          Call stock_repo
          Exit Sub
          End If */
        if ($_GET["unsold"] == "soldsummery") {
            sold_sum();
            PRINT_WEEKS();
            exit();
        }




        $sql_head = "select * from invpara";
        $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
        $row_head = mysqli_fetch_array($result_head);

        $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

        if ($_GET["cmbtype"] == "All") {
            $sql = "SELECT * from tmparmove where UN_QTY > 0 order by brand";
            $txtdays = " All Stock";
        }
        if ($_GET["cmbtype"] == "Over") {
            $sql = "SELECT * from tmparmove where period>" . $daysover . " and UN_QTY > 0  order by brand" ;
            $txtdays = " Over  " . $daysover . "  days Stock";
        }
        if ($_GET["cmbtype"] == "Between") {
            $sql = "SELECT * from tmparmove where period>" . $daysover . " and period<" . $daysbel . " and UN_QTY > 0 order by brand";
            $txtdays = " Over  " . $daysover . "  Bellow   " . $daysbel . "  days Stock";
        }
        ?>

        <center><table width="1200">
                <tr>
                    <th colspan="13" scope="col"><?php echo $row_head["COMPANY"]; ?></th>
                </tr>
                <tr>
                    <th colspan="13" scope="col"><?php echo $row_head["ADD1"] . " , " . $row_head["ADD2"]; ?></th>
                </tr>
                <tr>
<?php
$sql_dep = "select * from s_stomas where CODE='" . $_GET["com_dep"] . "'";
$result_dep = mysqli_query($GLOBALS['dbinv'],$sql_dep);
$rows_dep = mysqli_fetch_array($result_dep);
?>
                    <td colspan="3">AR Moving Report - Department : <?php echo $_GET["com_dep"] . " - " . $rows_dep["DESCRIPTION"]; ?></td>
                    <td colspan="7" align="center"><?php echo $txtdays; ?></td>
                    <td colspan="3" align="right"><?php echo date("Y-m-d"); ?></td>
                </tr>
            </table>
            <table width="1200" border="1">
                <tr>
                    <th>Stock No</th><th width="250">Description</th><th>Part No</th><th>Qty In Ha</th><th>No of Days</th><th>Un Sold Stock</th><th>L/C No</td>
                        <th>AR Date</th><th>AR No</th><th>AR Qty</th><th>Total Value</th><th>Cost Value</th><th>Unsold Value</th></tr>
                <?php
                $brand = "";
                $STK_NO = "";

                 
				$i=0;
				while ($i_row>=$i){
				  
				  	if ($_GET["cmbtype"] == "All") {	
                    	if ($brand != $brand_arr[$i]) {
                        	echo "<tr>
		<td align=\"left\" colspan=13><b>" . $brand_arr[$i] . "</b></td></tr>";
                        	$brand = $brand_arr[$i];
                    	}
                    	
						if ($UN_QTY_arr[$i]>0){	
						  if ($STK_NO != $STK_NO_arr[$i]) {

                        	echo "<tr>";
                       	 	echo "<td>" . $STK_NO_arr[$i] . "</td>";
                        	echo "<td>" . $des_arr[$i] . "</td>";
                        	echo "<td>" . $PART_NO_arr[$i] . "</td>";
                        	echo "<td align=\"right\">" . $qty_hnd_arr[$i] . "</td>";
                        	echo "<td>&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "<td>&nbsp;</td>";
                        	echo "<td>&nbsp;</td>";
                        	echo "<td>&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "</tr>";
                        	$STK_NO = $STK_NO_arr[$i];
                    	  }
				  
				  		
                    		echo "<tr>";
                    		echo "<td>&nbsp;</td>";
                    		echo "<td>&nbsp;</td>";
                    		echo "<td>&nbsp;</td>";
                    		echo "<td align=\"right\">&nbsp;</td>";
                    		echo "<td>" . $period_arr[$i] . "</td>";
                    		echo "<td align=\"right\"><b>" . number_format($UN_QTY_arr[$i], 0, ".", ",") . "</b></td>";
                    		echo "<td>" . $LC_NO_arr[$i] . "</td>";
                    		echo "<td>" . $ardate_arr[$i] . "</td>";
                    		echo "<td>" . $AR_NO_arr[$i] . "</td>";
                    		echo "<td align=\"right\">" . $AR_QTY_arr[$i] . "</td>";
                    		echo "<td align=\"right\">" . number_format($ARVALUE_arr[$i], 2, ".", ",") . "</td>";
                    		echo "<td align=\"right\">" . number_format($sold_arr[$i], 2, ".", ",") . "</td>";
                    		echo "<td align=\"right\">" . number_format($sold_arr[$i] * $UN_QTY_arr[$i], 2, ".", ",") . "</td>";
                    		echo "</tr>";
				  		}	
                    	$tot = $tot + ($sold_arr[$i] * $UN_QTY_arr[$i]);
					}
					
					if ($_GET["cmbtype"] == "Over") {
                    	if ($brand != $brand_arr[$i]) {
                        	echo "<tr>
		<td align=\"left\" colspan=13><b>" . $brand_arr[$i] . "</b></td></tr>";
                        	$brand = $brand_arr[$i];
                    	}
                    	
						if (($UN_QTY_arr[$i]>0) and ($daysover<$period_arr[$i])){	
						  if ($STK_NO != $STK_NO_arr[$i]) {

                        	echo "<tr>";
                       	 	echo "<td>" . $STK_NO_arr[$i] . "</td>";
                        	echo "<td>" . $des_arr[$i] . "</td>";
                        	echo "<td>" . $PART_NO_arr[$i] . "</td>";
                        	echo "<td align=\"right\">" . $qty_hnd_arr[$i] . "</td>";
                        	echo "<td>&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "<td>&nbsp;</td>";
                        	echo "<td>&nbsp;</td>";
                        	echo "<td>&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "</tr>";
                        	$STK_NO = $STK_NO_arr[$i];
                    	  }
				  
				  		
                    		echo "<tr>";
                    		echo "<td>&nbsp;</td>";
                    		echo "<td>&nbsp;</td>";
                    		echo "<td>&nbsp;</td>";
                    		echo "<td align=\"right\">&nbsp;</td>";
                    		echo "<td>" . $period_arr[$i] . "</td>";
                    		echo "<td align=\"right\"><b>" . number_format($UN_QTY_arr[$i], 0, ".", ",") . "</b></td>";
                    		echo "<td>" . $LC_NO_arr[$i] . "</td>";
                    		echo "<td>" . $ardate_arr[$i] . "</td>";
                    		echo "<td>" . $AR_NO_arr[$i] . "</td>";
                    		echo "<td align=\"right\">" . $AR_QTY_arr[$i] . "</td>";
                    		echo "<td align=\"right\">" . number_format($ARVALUE_arr[$i], 2, ".", ",") . "</td>";
                    		echo "<td align=\"right\">" . number_format($sold_arr[$i], 2, ".", ",") . "</td>";
                    		echo "<td align=\"right\">" . number_format($sold_arr[$i] * $UN_QTY_arr[$i], 2, ".", ",") . "</td>";
                    		echo "</tr>";
				  		}	
                    	$tot = $tot + ($sold_arr[$i] * $UN_QTY_arr[$i]);
					}
					
					if ($_GET["cmbtype"] == "Between") {
                    	if ($brand != $brand_arr[$i]) {
                        	echo "<tr>
		<td align=\"left\" colspan=13><b>" . $brand_arr[$i] . "</b></td></tr>";
                        	$brand = $brand_arr[$i];
                    	}
                    	
						if (($UN_QTY_arr[$i]>0) and ($daysover<$period_arr[$i]) and ($daysbel>$period_arr[$i])){	
						  if ($STK_NO != $STK_NO_arr[$i]) {

                        	echo "<tr>";
                       	 	echo "<td>" . $STK_NO_arr[$i] . "</td>";
                        	echo "<td>" . $des_arr[$i] . "</td>";
                        	echo "<td>" . $PART_NO_arr[$i] . "</td>";
                        	echo "<td align=\"right\">" . $qty_hnd_arr[$i] . "</td>";
                        	echo "<td>&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "<td>&nbsp;</td>";
                        	echo "<td>&nbsp;</td>";
                        	echo "<td>&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "<td align=\"right\">&nbsp;</td>";
                        	echo "</tr>";
                        	$STK_NO = $STK_NO_arr[$i];
                    	  }
				  
				  		
                    		echo "<tr>";
                    		echo "<td>&nbsp;</td>";
                    		echo "<td>&nbsp;</td>";
                    		echo "<td>&nbsp;</td>";
                    		echo "<td align=\"right\">&nbsp;</td>";
                    		echo "<td>" . $period_arr[$i] . "</td>";
                    		echo "<td align=\"right\"><b>" . number_format($UN_QTY_arr[$i], 0, ".", ",") . "</b></td>";
                    		echo "<td>" . $LC_NO_arr[$i] . "</td>";
                    		echo "<td>" . $ardate_arr[$i] . "</td>";
                    		echo "<td>" . $AR_NO_arr[$i] . "</td>";
                    		echo "<td align=\"right\">" . $AR_QTY_arr[$i] . "</td>";
                    		echo "<td align=\"right\">" . number_format($ARVALUE_arr[$i], 2, ".", ",") . "</td>";
                    		echo "<td align=\"right\">" . number_format($sold_arr[$i], 2, ".", ",") . "</td>";
                    		echo "<td align=\"right\">" . number_format($sold_arr[$i] * $UN_QTY_arr[$i], 2, ".", ",") . "</td>";
                    		echo "</tr>";
				  		}	
                    	$tot = $tot + ($sold_arr[$i] * $UN_QTY_arr[$i]);
					}
					$i=$i+1;
                }

                echo "<tr>";
                echo "<td colspan=12>&nbsp;</td>";

                echo "<td align=\"right\"><b>" . number_format($tot, 2, ".", ",") . "</b></td>";
                echo "</tr>";
                //echo "</table>";

                /* Set rsPrInv = CreateObject("adodb.recordset")
                  Screen.MousePointer = 0
                  rsPrInv.Open sql, DNUSER.CONUSER
                  m_Report.DiscardSavedData
                  m_Report.rtxtComName.SetText rspara.Fields("COMPANY")
                  m_Report.rtxtcomadd1.SetText rspara.Fields("ADD1")
                  m_Report.rtxtComAdd2.SetText rspara.Fields("ADD2") & ", " & rspara.Fields("ADD3")
                  m_Report.rtxtdate.SetText "AR Moving Report"

                  m_Report.b35.SetText Format(b30, "###,###.00")
                  m_Report.o36b45.SetText Format(o36b45, "###,###.00")
                  m_Report.o46b60.SetText Format(o46b60, "###,###.00")
                  m_Report.o61b75.SetText Format(o61b75, "###,###.00")
                  m_Report.o76b90.SetText Format(o76b91, "###,###.00")
                  m_Report.o91.SetText Format(o91, "###,###.00")
                  m_Report.total.SetText Format(total, "###,###.00") */
                ?>
            </table><table width='1200'>
                <tr>
                    <td width='400'><b>Total Value Rs.</b></td>
                    <td align="right" width='200'><b><?php echo number_format($total, 2, ".", ","); ?></b></td>
                    <td width='600'></td>

                </tr>
                <tr>
                    <td width='400'> <b>Below 30 Days Stock Rs.</b></td>
                    <td align="right"><b><?php echo number_format($b30, 2, ".", ","); ?></b></td>
                    <td width='600'></td>

                </tr>
                <tr>
                    <td width='400'><b>Over 31 and Below 45 Days Stock Rs.</b></td>
                    <td align="right"><b><?php echo number_format($o36b45, 2, ".", ","); ?></b></td>
                    <td width='600'></td>

                </tr>
                <tr>
                    <td width='400'><b>Over 46 and Below 60 Days Stock Rs.</b></td>
                    <td align="right"><b><?php echo number_format($o46b60, 2, ".", ","); ?></b></td>
                    <td width='600'></td>

                </tr>
                <tr>
                    <td width='400'><b>Over 61 and Below 75 Days Stock Rs.</b></td>
                    <td align="right"><b><?php echo number_format($o61b75, 2, ".", ","); ?></b></td>
                    <td width='600'></td>

                </tr>
                <tr>
                    <td width='400'><b>Over 76  and Below 90 Days Stock Rs.</b></td>
                    <td align="right"><b><?php echo number_format($o76b91, 2, ".", ","); ?></b></td>
                    <td width='600'></td>

                </tr>
                <tr>
                    <td width='400'><b>Over 90 Days Stock Rs.</b></td>
                    <td align="right"><b><?php echo number_format($o91, 2, ".", ","); ?></b></td>
                    <td width='600'></td>
                </tr>
            </table>

            <?php

            function printSummery() {

                require_once("connectioni.php");
                
                

                $sql_head = "select * from invpara";
                $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
                $row_head = mysqli_fetch_array($result_head);

                //$txtrepono= $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

                $sql_dep = "select * from s_stomas where CODE='" . $_GET["com_dep"] . "'";
                $result_dep = mysqli_query($GLOBALS['dbinv'],$sql_dep);
                $rows_dep = mysqli_fetch_array($result_dep);


                $TXTREP = "Sales Rep : " . $_GET["com_dep"] . " - " . $rows_dep["DESCRIPTION"];

                $daysover = $_GET["txtdays"];
                $daysbel = $_GET["txtbel"];

                if ($_GET["cmbtype"] == "All") {
                    $txtdays = " All Stock";
                }

                if ($_GET["cmbtype"] == "Over") {
                    $txtdays = " Over  " . $daysover . "  days Stock";
                }
                if ($_GET["cmbtype"] == "Between") {
                    $txtdays = " Over  " . $daysover . "  Bellow   " . $daysbel . "  days Stock";
                }

                echo "<center><table width=\"1000\" border=\"0\">
  <tr>
    <th colspan=\"13\" scope=\"col\">" . $row_head["COMPANY"] . "</th>
  </tr>
  <tr>
    <th colspan=\"13\" scope=\"col\">" . $row_head["ADD1"] . " , " . $row_head["ADD2"] . "</th>
  </tr>
  <tr>
    <td colspan=\"3\">AR Moving Report</td>
    <td colspan=\"7\" align=\"center\">" . $txtdays . "</td>
    <td colspan=\"3\" align=\"right\">" . date("Y-m-d") . "</td>
  </tr>
  <tr>
    <td colspan=\"3\">" . $TXTREP . "</td>
    <td colspan=\"7\" align=\"center\"></td>
    <td colspan=\"3\" align=\"right\"></td>
  </tr>
  </table><br>";

                echo "<center><table border=1  width=\"1000\" cellpadding=\"5\" cellspacing=\"0\"><tr>
		<th>Brand</th><th>Bellow 60</th><th>60 to 90</th><th>90 to 120</th><th>Over 120</th><th>Total Stock</th>
		<th>Total Over 90</th><th>%</th></tr>";
				
				$distnct_brand= array(); 
				
				$i=0;
				$j_row=0;
				$brand="";
				while ($GLOBALS['i_row']>=$i){
					
					if ($brand!=$GLOBALS['brand_arr'][$i]){
						$distnct_brand[$j_row]=$GLOBALS['brand_arr'][$i];
						//echo $distnct_brand[$j_row];
						$j_row=$j_row+1;
					}
					$i=$i+1;
					$brand=$GLOBALS['brand_arr'][$i];
					
				}
               /* $sql1 = "SELECT distinct brand from tmparmove order by brand";
                $result1 = mysqli_query($GLOBALS['dbinv'],$sql1) ; 
                while ($row1 = mysqli_fetch_array($result1)) {


                    if ($_GET["cmbtype"] == "All") {
                        $sql = "SELECT * from tmparmove where brand='" . $row1["brand"] . "'";
                    }

                    if ($_GET["cmbtype"] == "Over") {
                        $sql = "SELECT * from tmparmove where period>" . $daysover . " and brand='" . $row1["brand"] . "'";
                    }
                    if ($_GET["cmbtype"] == "Between") {
                        $sql = "SELECT * from tmparmove where period>" . $daysover . " and period<" . $daysbel . " and brand='" . $row1["brand"] . "'";
                    }*/
                    $totbel60 = 0;
                    $toto60_90 = 0;
                    $toto90to120 = 0;
                    $toto120 = 0;
                    $totunsold = 0;
                    $tottotover90 = 0;
                    $totsubpr = 0;


                  //  $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
                   // while ($row = mysqli_fetch_array($result)) {
				   	
					$j=0;
					while ($j_row>$j){
						
					  $i=0;
					  
					  while ($GLOBALS['i_row']>$i){
					  
					   if ($distnct_brand[$j]==	$GLOBALS['brand_arr'][$i]){
                        $bel60 = 0;
                        $o60_9 = 0;
                        $o90to120 = 0;
                        $o120 = 0;
                        $unsold = 0;
                        $totover90 = 0;
                        $subpr = 0;

                        $unsold = $GLOBALS['sold_arr'][$i] * $GLOBALS['UN_QTY_arr'][$i];

                        if ($GLOBALS['period_arr'][$i] <= 30) {
                            $b30 = $GLOBALS['sold_arr'][$i] * $GLOBALS['UN_QTY_arr'][$i];
                        } else {
                            $b30 = 0;
                        }
                        if (($GLOBALS['period_arr'][$i] > 30) and ( $GLOBALS['period_arr'][$i] <= 45)) {
                            $o31to45 = $GLOBALS['sold_arr'][$i] * $GLOBALS['UN_QTY_arr'][$i];
                        } else {
                            $o31to45 = 0;
                        }

                        if (($GLOBALS['period_arr'][$i] > 45) and ( $GLOBALS['period_arr'][$i] <= 60)) {
                            $o45to60 = $GLOBALS['sold_arr'][$i] * $GLOBALS['UN_QTY_arr'][$i];
                        } else {
                            $o45to60 = 0;
                        }

                        if (($GLOBALS['period_arr'][$i] > 60) and ( $GLOBALS['period_arr'][$i] <= 75)) {
                            $o60to75 = $GLOBALS['sold_arr'][$i] * $GLOBALS['UN_QTY_arr'][$i];
                        } else {
                            $o60to75 = 0;
                        }

                        if (($GLOBALS['period_arr'][$i] > 75) and ( $GLOBALS['period_arr'][$i] <= 90)) {
                            $o75to90 = $GLOBALS['sold_arr'][$i] * $GLOBALS['UN_QTY_arr'][$i];
                        } else {
                            $o75to90 = 0;
                        }

                        if (($GLOBALS['period_arr'][$i] > 90) and ( $GLOBALS['period_arr'][$i] <= 120)) {
                            $o90to120 = $GLOBALS['sold_arr'][$i] * $GLOBALS['UN_QTY_arr'][$i];
                        } else {
                            $o90to120 = 0;
                        }

                        if ($GLOBALS['period_arr'][$i] > 120) {
                            $o120 = $GLOBALS['sold_arr'][$i] * $GLOBALS['UN_QTY_arr'][$i];
                        } else {
                            $o120 = 0;
                        }

                        $totover90 = $o120 + $o90to120;

                        //if Sum ({@unsold}, {ado.brand})>0 then 
//Sum ({@totOver90}, {ado.brand})/Sum ({@unsold}, {ado.brand})*100

                        if ($unsold > 0) {
                            $subpr = $totover90 / $unsold * 100;
                        }

                        //if Sum ({@unsold})>0 then
//Sum ({@totOver90})/Sum ({@unsold})*100
                        if ($unsold > 0) {
                            $totpr = ($totover90) / $unsold * 100;
                        }

                        $bel60 = $b30 + $o31to45 + $o45to60;

                        $o60_90 = $o60to75 + $o75to90;

                        //$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                        //while($row = mysqli_fetch_array($result)){



                        $totbel60 = $totbel60 + $bel60;
                        $toto60_90 = $toto60_90 + $o60_90;
                        $toto90to120 = $toto90to120 + $o90to120;
                        $toto120 = $toto120 + $o120;
                        $totunsold = $totunsold + $unsold;
                        $tottotover90 = $tottotover90 + $totover90;
					   }
					   $i=$i+1;
					  } 	
                        //$totsubpr=$totsubpr+$subpr;
                        //echo "<tr>
                        //<td>".$row1["brand"]."</td><td>".number_format($bel60, 2, ".", ",")."</td><td>".number_format($o60_90, 2, ".", ",")."</td><td>".number_format($o90to120, 2, ".", ",")."</td><td>".number_format($o120, 2, ".", ",")."</td><td>".number_format($unsold, 2, ".", ",")."</td><td>".number_format($totover90, 2, ".", ",")."</td><td>".number_format($subpr, 2, ".", ",")."</td></tr>";
                    

                    if ($totunsold > 0) {
                        $totsubpr = $tottotover90 / $totunsold * 100;
                    }

                    echo "<tr>
		<td>" . $distnct_brand[$j] . "</td><td>" . number_format($totbel60, 2, ".", ",") . "</td><td>" . number_format($toto60_90, 2, ".", ",") . "</td><td>" . number_format($toto90to120, 2, ".", ",") . "</td><td>" . number_format($toto120, 2, ".", ",") . "</td><td>" . number_format($totunsold, 2, ".", ",") . "</td><td>" . number_format($tottotover90, 2, ".", ",") . "</td><td>" . number_format($totsubpr, 2, ".", ",") . "</td></tr>";

                    $all_totbel60 = $all_totbel60 + $totbel60;
                    $all_toto60_90 = $all_toto60_90 + $toto60_90;
                    $all_toto90to120 = $all_toto90to120 + $toto90to120;
                    $all_toto120 = $all_toto120 + $toto120;
                    $all_totunsold = $all_totunsold + $totunsold;
                    $all_tottotover90 = $all_tottotover90 + $tottotover90;
                 
				 $j=$j+1;
				}

                if ($all_totunsold > 0) {
                    $all_totsubpr = $all_tottotover90 / $all_totunsold * 100;
                }

                echo "<tr>
		<td>&nbsp;</td><td>" . number_format($all_totbel60, 2, ".", ",") . "</td><td><b>" . number_format($all_toto60_90, 2, ".", ",") . "</b></td><td><b>" . number_format($all_toto90to120, 2, ".", ",") . "</b></td><td><b>" . number_format($all_toto120, 2, ".", ",") . "</b></td><td><b>" . number_format($all_totunsold, 2, ".", ",") . "</b></td><td><b>" . number_format($all_tottotover90, 2, ".", ",") . "</b></td><td><b>" . number_format($all_totsubpr, 2, ".", ",") . "</b></td></tr>";
            }
            ?>	



    </body>
</html>
