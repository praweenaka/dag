<?php 	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sales Summery</title>
        <style>
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:16px;
            }
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {
                border:1px solid black;
                font-family:Arial, Helvetica, sans-serif;
                padding:5px;
            }
            th
            {
                font-weight:bold;
                font-size:16px;
				
            }
            td
            {
				font-size:16px;;
				border-bottom:none;
				border-top:none;            }
        </style>
        <style type="text/css">
            <!--
            .style1 {
                color: #0000FF;
                font-weight: bold;
                font-size: 24px;
            }
            -->
        </style>
    </head>

    <body>
        <!-- Progress bar holder -->


        <?php
        require_once("connectioni.php");
        
        



	 if ($_GET["cmbtype"] == "All") {
        if ($_GET["salesrep"] == "All") {
            repoall();
        }
        if ($_GET["salesrep"] != "All") {
            reporecrd();
        }


        if ($_GET["radio2"] == "optdate") {
            
        }
	} else {
		type_wise();
	}
/////////// Sales Summery////////////////////////////////////////

	function type_wise()
	{
			
			$tar=0;
			
			$insert="";
			
			require_once("connectioni.php");
            
            

            if ($_GET["cmbdev"] == "All") {
                $dev = "A";
            }
            if ($_GET["cmbdev"] == "Manual") {
                $dev = "0";
            }
            if ($_GET["cmbdev"] == "Computer") {
                $dev = "1";
            }
            $i=0;
            $sql = "delete from tmprepsale where user_id='".$_SESSION["CURRENT_USER"]."'";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			

			if ($_GET["salesrep"] == "All") {
	   			$sql_rep = "SELECT * FROM s_salrep where cancel='1' order by REPCODE";
			} else {
   				$sql_rep = "SELECT * FROM s_salrep where REPCODE='" . $_GET["salesrep"] . "' order by REPCODE ";
			}
			
			$result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);	
			$row_rep = mysqli_fetch_array($result_rep);
			
			$mname = "";
			if (is_null($row_rep["Name"])==false) { $mname = $row_rep["Name"]; }
				
		
			$result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);	
			while($row_rep = mysqli_fetch_array($result_rep)){
				$SAL = 0;
				$ret = 0;
				$mnet = 0;

				if ($_GET["cmbbrand"] == "All") {
   					$sql_rst = "SELECT * FROM s_salma where Accname != 'NON STOCK' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' order by id ";
				} else {
   					$sql_rst = "SELECT * FROM s_salma where Accname != 'NON STOCK' and Brand='" . $_GET["cmbbrand"] . "' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' order by id  ";
				}	
				//echo $sql_rst;
				$result_rst = mysqli_query($GLOBALS['dbinv'],$sql_rst);	
				while($row_rst = mysqli_fetch_array($result_rst)){
   					
					$sql_rs0 = "Select ittype from view_salma_invo_smas where REF_NO='" . trim($row_rst["REF_NO"]) . "'";
					//echo $sql_rs0;
   					$result_rs0 = mysqli_query($GLOBALS['dbinv'],$sql_rs0);	
					if($row_rs0 = mysqli_fetch_array($result_rs0)){
						//echo $row_rs0["ittype"]."/".$_GET["cmbtype"]."</br>";
      					if (trim($row_rs0["ittype"]) == trim($_GET["cmbtype"])) {
         					$SAL = $SAL + $row_rst["GRAND_TOT"];
         					$mnet = $mnet + ($row_rst["GRAND_TOT"] / (1 + ($row_rst["GST"] / 100)));
	      				}
   					}
   				
   				}
				//echo $mnet."</br>";
				if ($_GET["cmbbrand"] == "All") {
				
   					if ($_GET["chkdef"] != "on") { 
						
						$sql_rst2 = "SELECT * FROM c_bal WHERE SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "' or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "' or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' and flag1 != '1' ";
					}	
   					if ($_GET["chkdef"] == "on") { 
						
						$sql_rst2 = "SELECT * FROM c_bal WHERE SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' and flag1 != '1' ";
					}	
				} else {
					
   					if ($_GET["chkdef"] != "on") { 
					
						$sql_rst2 = "SELECT * FROM c_bal WHERE brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "' or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "' or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' and flag1 != '1' ";
					}	
   					if ($_GET["chkdef"] == "on") { 
					
						$sql_rst2 = "SELECT * FROM c_bal WHERE brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "' or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "' or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and dev!='" . $dev . "' and flag1 != '1' ";
					}
				}
			
				$result_rst2 = mysqli_query($GLOBALS['dbinv'],$sql_rst2);	
				while($row_rst2 = mysqli_fetch_array($result_rst2)){	

   					$mok = 0;
   					if ($row_rst2["trn_type"] == "GRN") {
      					$sql_rs0 = "Select ittype from view_cbal_crnma_sinvo_smas where REFNO='" . trim($row_rst2["REFNO"]) . "'";
						$result_rs0 = mysqli_query($GLOBALS['dbinv'],$sql_rs0);	
						if($row_rs0 = mysqli_fetch_array($result_rs0)){	
         					if (trim($row_rs0["ittype"]) == trim($_GET["cmbtype"])) {
            					$mok = 1;
         					}
      					}
         			}
   
   					if ($row_rst2["trn_type"] == "CNT") {
      					$sql_rs0 = "Select ittype from view_cbal_credit_sinvo_smas where REFNO='" . trim($row_rst2["REFNO"]) . "'";
      					$result_rs0 = mysqli_query($GLOBALS['dbinv'],$sql_rs0);	
						if($row_rs0 = mysqli_fetch_array($result_rs0)){	
         					if (trim($row_rs0["ittype"]) == trim($_GET["cmbtype"])) {
            					$mok = 1;
         					}
      					}
         			}
   
   					if ($mok == 1) {
      					$ret = $ret + $row_rst2["AMOUNT"];
      					$mnet = $mnet - ($row_rst2["AMOUNT"] / (1 + ($row_rst2["vatrate"] / 100)));
   					}
   					//echo "lm-".$mnet;
				}
				
				if ($i!=0){
					$insert=$insert.", ";
				 }
				 
				  $insert = $insert."('".trim($row_rep["REPCODE"])."', ".$SAL.", ".$ret.", '".$row_rep["Name"]."', '".trim($row_rep["RGROUP"])."', ".$mnet.", ".$tar.", '".$_SESSION["CURRENT_USER"]."')";
				  $i=1;
				  
			 	
					
			}

			$sql_tem = "insert into tmprepsale(rep, grossale, grossgrn, Name, rgroup, net,targ, user_id) values ".$insert;
				//echo $sql_tem;
            $result_tem = mysqli_query($GLOBALS['dbinv'],$sql_tem);
				
			if ($_GET["chktar"] == "on") {
            print2();
            } else { 
            print1();    
            }


		}

        function repoall() {
            require_once("connectioni.php");
            
            
			
			$insert="";
			
            if ($_GET["cmbdev"] == "All") {
                $dev = "A";
            }
            if ($_GET["cmbdev"] == "Manual") {
                $dev = "0";
            }
            if ($_GET["cmbdev"] == "Computer") {
                $dev = "1";
            }

            $sql = "delete from tmprepsale where user_id='".$_SESSION["CURRENT_USER"]."'";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            //$row = mysqli_fetch_array($result);

            $sql_rep = "SELECT * FROM s_salrep order by REPCODE desc";
            $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);
            while ($row_rep = mysqli_fetch_array($result_rep)) {

                $mname = "";
                if (is_null($row_rep["Name"]) == false) {
                    $mname = trim($row_rep["Name"]);
                }
                $SAL = 0;
                $ret = 0;
                $mnet = 0;

                if ($_GET["cmbbrand"] == "All") {
                    $sql_rst = "SELECT * FROM s_salma where   Accname != 'NON STOCK' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "' or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' and DEV!='" . $dev . "'";
                }

                if ($_GET["cmbbrand"] != "All") {
                    $sql_rst = "SELECT * FROM s_salma where Accname != 'NON STOCK' and Brand='" . $_GET["cmbbrand"] . "' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' and DEV!='" . $dev . "'";
                }

                $result_rst = mysqli_query($GLOBALS['dbinv'],$sql_rst);
                while ($row_rst = mysqli_fetch_array($result_rst)) {
                    $SAL = $SAL + $row_rst["GRAND_TOT"];
                    $mnet = $mnet + ($row_rst["GRAND_TOT"] / (1 + ($row_rst["GST"] / 100)));
                }

                if ($_GET["cmbbrand"] == "All") {
                    if ($_GET["chkdef"] != "on") {
                        $sql_rst2 = "SELECT * FROM c_bal WHERE  (flag1 = '0') and SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                    }

                    if ($_GET["chkdef"] == "on") {
                        $sql_rst2 = "SELECT * FROM c_bal WHERE  (flag1 = '0') and SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                    }
                } else {

                    if ($_GET["chkdef"] != "on") {
                        $sql_rst2 = "SELECT * FROM c_bal WHERE (flag1 = '0') and brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                    }

                    if ($_GET["chkdef"] == "on") {
                        $sql_rst2 = "SELECT * FROM c_bal WHERE (flag1 = '0') and brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                    }
                }

                $month1 = date("m", strtotime($_GET["DT1"]));
                $month1_y = date("Y", strtotime($_GET["DT1"]));


 //               $sql_t = "select sum(target) as target  from rep_target where rep='" . trim($row_rep["REPCODE"]) . "'  and tmonth=" . $month1 . " and tyear=" . $month1_y . "  ";
                $sql_t = "select sum(Target) as target  from reptrn where rep_code='" . trim($row_rep["REPCODE"]) . "'";
            
                
                $result_tar = mysqli_query($GLOBALS['dbinv'],$sql_t);
                $tar = 0;
                $row_tar = mysqli_fetch_array($result_tar);
                if ($row_tar["target"] > 0) {
                    $tar = $row_tar["target"];
                }

                $result_rst2 = mysqli_query($GLOBALS['dbinv'],$sql_rst2);
                while ($row_rst2 = mysqli_fetch_array($result_rst2)) {
                    $ret = $ret + $row_rst2["AMOUNT"];
                    $mnet = $mnet - ($row_rst2["AMOUNT"] / (1 + ($row_rst2["vatrate"] / 100)));
                }

                if (($SAL <> 0 ) or ( $ret <> 0)) {
                    
				  if ($i!=0){
					$insert=$insert.", ";
				  }
				
				 	$insert = $insert."('".trim($row_rep["REPCODE"])."', ".$SAL.", ".$ret.", '".$mname."', '".trim($row_rep["RGROUP"])."',  ".$mnet.", ".$tar.", '".$_SESSION["CURRENT_USER"]."')";
				 
				 	$i=1;
				 
				//	$sql_tem = "insert into tmprepsale(rep, grossale, grossgrn, Name, rgroup, net,targ) values ('" . trim($row_rep["REPCODE"]) . "', " . $SAL . ", " . $ret . ", '" . $mname . "', '" . trim($row_rep["RGROUP"]) . "', " . $mnet . ", " . $tar . ")";
                //    $result_tem = mysqli_query($GLOBALS['dbinv'],$sql_tem);
                }
            }
 			
			$sql_tem = "insert into tmprepsale(rep, grossale, grossgrn, Name, rgroup, net, targ, user_id) values ".$insert;
            $result_tem = mysqli_query($GLOBALS['dbinv'],$sql_tem);
				
            if ($_GET["chktar"] == "on") {
            print2();
            } else { 
            print1();    
            }
        }

        function print2() {

            require_once("connectioni.php");
            
            

            if ($_GET["chkdef"] != "on") {
                $txtName = "Rep wise Sales Summery (Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
            }

            if ($_GET["chkdef"] == "on") {
                $txtName = "Rep wise Sales Summery (with Defective)(Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
            }


            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";

            echo "<center>" . $txtName . "</center><br>";

            echo "<center><table border=1><tr>
		 
                <th colspan='2'>Sales Rep</th>
		<th>Target</th>
		<th>Achievement</th>
		<th>Balance</th>
                <th>Ach %</th>
		</tr>";
            //echo $sql;
            $totgrossale = 0;
            $totgrossgrn = 0;
            $totnet = 0;

            $chk = 0;

            $sql = "select * from tmprepsale where user_id='".$_SESSION["CURRENT_USER"]."' order by rgroup";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            while ($row = mysqli_fetch_array($result)) {
                if ($row["rgroup"] != $rgroup) {
                    if ($grossale != 0) {
                        $grngrp = $grossgrn / $grossale * 100;
                        
                         
                    } else {
                        $grngrp = 0;
                         
                    }

                    if ($chk != 0) {
                        
                        echo "<tr><td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"right\"><b>" . number_format($grossale, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grossgrn, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grngrp, 2, ".", ",") . "</b></td>
					</tr>";
                        $grngrp = 0;
                        $grossale=0;
                        $grossgrn=0;
                        $net=0;
                        $grngrp=0;
                    }
                    $chk = 1;
                    echo "<tr>
					<td colspan=4 align=left><b>" . $row["rgroup"] . "</b></td>
					<tr>";
                    $grossale = 0;
                    $grossgrn = 0;
                    $net = 0;
                }
                if (($row["grossale"] > 0) or ( $row["grossgrn"] > 0) or ( $row["net"] > 0)) {

                    
                    $grngrp = 0;
                        
                    
                    if ($row["targ"] != 0) {
                        $grn = $row["net"] / $row["targ"] * 100;
                    } else {
                        $grn = 0;
                    }

                    echo "<tr><td>" . $row["rep"] . "</td>
				<td>" . $row["Name"] . "</td>
				<td align=\"right\">" . number_format($row["targ"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row["net"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row["targ"]-$row["net"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($grn, 2, ".", ",") . "</td>
				</tr>";

                    $grossale = $grossale + $row["targ"];
                    $grossgrn = $grossgrn + $row["net"];
                    $net = $net + ($row["targ"]-$row["net"]);

                    $totgrossale = $totgrossale + $row["targ"];
                    $totgrossgrn = $totgrossgrn + $row["net"];
                    $totnet = $totnet + ($row["targ"]-$row["net"]);
                }
                $rgroup = $row["rgroup"];
            }

            if ($totgrossale != 0) {
                $totgrngrp = $totgrossgrn / $totgrossale * 100;
            } else {
                $grngrp = 0;
            }

              echo "<tr><td>&nbsp;</td>
					<th>&nbsp;</td>
					<th align=\"right\"><b>" . number_format($grossale, 2, ".", ",") . "</b></th>
					<th align=\"right\"><b>" . number_format($grossgrn, 2, ".", ",") . "</b></th>
					<th align=\"right\"><b>" . number_format($net, 2, ".", ",") . "</b></th>
					<th align=\"right\"><b>" . number_format($grngrp, 2, ".", ",") . "</b></th>
					</tr>";
                        $grngrp = 0;
                        $grossale=0;
                        $grossgrn=0;
                        $net=0;
                        $grngrp=0;
            
            
            echo "<tr><td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align=\"right\"><b>" . number_format($totgrossale, 2, ".", ",") . "</b></td>
				<td align=\"right\"><b>" . number_format($totgrossgrn, 2, ".", ",") . "</b></td>
				<td align=\"right\"><b>" . number_format($totnet, 2, ".", ",") . "</b></td>
				<td align=\"right\"><b>" . number_format($totgrngrp, 2, ".", ",") . "</b></td>
				</tr>";

            echo "<table>";
        }
   
        
        
        
        function print1() {

            require_once("connectioni.php");
            
            

            if ($_GET["chkdef"] != "on") {
                $txtName = "Rep wise Sales Summery (Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
            }

            if ($_GET["chkdef"] == "on") {
                $txtName = "Rep wise Sales Summery (with Defective)(Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
            }


            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";

            echo "<center>" . $txtName . "</center><br>";

            echo "<center><table border=1><tr>
		 
                <th colspan='2'>Sales Rep</th>
		<th>Gross Sales</th>
		<th>Gross Return</th>
		<th>GRN %</th>
                <th>Net Sale</th>
		</tr>";
            //echo $sql;
            $totgrossale = 0;
            $totgrossgrn = 0;
            $totnet = 0;

            $chk = 0;

            $sql = "select * from tmprepsale where user_id='".$_SESSION["CURRENT_USER"]."' order by rgroup";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            while ($row = mysqli_fetch_array($result)) {
                if ($row["rgroup"] != $rgroup) {
                    if ($grossale != 0) {
                        $grngrp = $grossgrn / $grossale * 100;
                    } else {
                        $grngrp = 0;
                    }

                    if ($chk != 0) {
                        echo "<tr><td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"right\"><b>" . number_format($grossale, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grossgrn, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grngrp, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net, 2, ".", ",") . "</b></td>
					</tr>";
                    }
                    $chk = 1;
                    echo "<tr>
					<th colspan=6 align=left><b>" . $row["rgroup"] . "</b></th>
					<tr>";
                    $grossale = 0;
                    $grossgrn = 0;
                    $net = 0;
                }
                if (($row["grossale"] > 0) or ( $row["grossgrn"] > 0) or ( $row["net"] > 0)) {

                    if ($row["grossale"] != 0) {
                        $grn = $row["grossgrn"] / $row["grossale"] * 100;
                    } else {
                        $grn = 0;
                    }

                    echo "<tr><td>" . $row["rep"] . "</td>
				<td>" . $row["Name"] . "</td>
				<td align=\"right\">" . number_format($row["grossale"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row["grossgrn"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($grn, 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row["net"], 2, ".", ",") . "</td>
				</tr>";

                    $grossale = $grossale + $row["grossale"];
                    $grossgrn = $grossgrn + $row["grossgrn"];
                    $net = $net + $row["net"];

                    $totgrossale = $totgrossale + $row["grossale"];
                    $totgrossgrn = $totgrossgrn + $row["grossgrn"];
                    $totnet = $totnet + $row["net"];
                }
                $rgroup = $row["rgroup"];
            }

            if ($totgrossale != 0) {
                $totgrngrp = $totgrossgrn / $totgrossale * 100;
            } else {
                $grngrp = 0;
            }
 echo "<tr><td>&nbsp;</td>
					<th>&nbsp;</td>
					<th align=\"right\"><b>" . number_format($grossale, 2, ".", ",") . "</b></td>
					<th align=\"right\"><b>" . number_format($grossgrn, 2, ".", ",") . "</b></td>
					<th align=\"right\"><b>" . number_format($grngrp, 2, ".", ",") . "</b></td>
					<th align=\"right\"><b>" . number_format($net, 2, ".", ",") . "</b></td>
					</tr>";
            echo "<tr><td>&nbsp;</td>
				<th>&nbsp;</td>
				<th align=\"right\"><b>" . number_format($totgrossale, 2, ".", ",") . "</b></td>
				<th align=\"right\"><b>" . number_format($totgrossgrn, 2, ".", ",") . "</b></td>
				<th align=\"right\"><b>" . number_format($totgrngrp, 2, ".", ",") . "</b></td>
				<th align=\"right\"><b>" . number_format($totnet, 2, ".", ",") . "</b></td>
				</tr>";

            echo "<table>";
        }

        
        function reporecrd() {

            require_once("connectioni.php");
            
            
			
			$insert="";

            if ($_GET["cmbdev"] == "All") {
                $dev = "A";
            }
            if ($_GET["cmbdev"] == "Manual") {
                $dev = "0";
            }
            if ($_GET["cmbdev"] == "Computer") {
                $dev = "1";
            }

            $sql = "delete from tmprepsale where user_id='".$_SESSION["CURRENT_USER"]."'";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 


            $sql_rep = "SELECT * FROM s_salrep where REPCODE='" . $_GET["salesrep"] . "'  order by REPCODE desc";
            $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);
            while ($row_rep = mysqli_fetch_array($result_rep)) {

                $mname = "";
                if (is_null($row_rep["Name"]) == false) {
                    $mname = $row_rep["Name"];
                }
                $SAL = 0;
                $ret = 0;
                $mnet = 0;

                if ($_GET["cmbbrand"] == "All") {
                    $sql_rst = "SELECT * FROM s_salma where Accname != 'NON STOCK' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "' or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' and DEV!='" . $dev . "'";
                }

                if ($_GET["cmbbrand"] != "All") {
                    $sql_rst = "SELECT * FROM s_salma where Accname != 'NON STOCK' and Brand='" . $_GET["cmbbrand"] . "' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' and DEV!='" . $dev . "'";
                }
                //echo $sql_rst;
                $result_rst = mysqli_query($GLOBALS['dbinv'],$sql_rst);
                while ($row_rst = mysqli_fetch_array($result_rst)) {
                    $SAL = $SAL + $row_rst["GRAND_TOT"];
                    $mnet = $mnet + ($row_rst["GRAND_TOT"] / (1 + ($row_rst["GST"] / 100)));
                }

                if ($_GET["cmbbrand"] == "All") {
                    if ($_GET["chkdef"] != "on") {

                        $sql_rst2 = "SELECT * FROM c_bal WHERE  (flag1 = '0') and SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                    }

                    if ($_GET["chkdef"] == "on") {
                        $sql_rst2 = "SELECT * FROM c_bal WHERE  (flag1 = '0') and SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                    }
                } else {

                    if ($_GET["chkdef"] != "on") {
                        $sql_rst2 = "SELECT * FROM c_bal WHERE (flag1 = '0') and brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                    }

                    if ($_GET["chkdef"] == "on") {
                        $sql_rst2 = "SELECT * FROM c_bal WHERE (flag1 = '0') and brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                    }
                }


                $result_rst2 = mysqli_query($GLOBALS['dbinv'],$sql_rst2);
                while ($row_rst2 = mysqli_fetch_array($result_rst2)) {
                    $ret = $ret + $row_rst2["AMOUNT"];
                    $mnet = $mnet - ($row_rst2["AMOUNT"] / (1 + ($row_rst2["vatrate"] / 100)));
                }
				
				if ($i!=0){
					$insert=$insert.", ";
				 }
				 
				  $insert = $insert."('".$row_rep["REPCODE"]."', ".$SAL.", ".$ret.", '".$mname."', ".$mnet.", '".$_SESSION["CURRENT_USER"]."')";
				  $i=1;
				   
                
            }
			
			$sql_tem = "insert into tmprepsale(rep, grossale, grossgrn, Name, net, user_id) values ".$insert;
            $result_tem = mysqli_query($GLOBALS['dbinv'],$sql_tem);
			//echo $sql_tem;
				
            if ($_GET["chkdef"] != "on") {
                $txtName = "Rep wise Sales Summery (Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
            }

            if ($_GET["chkdef"] == "on") {
                $txtName = "Rep wise Sales Summery (with Defective)(Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
            }


            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";

            echo "<center>" . $txtName . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Rep Code</th>
		<th>Rep Name</th>
		<th>Gross Sales</th>
		<th>Gross Return</th>
		<th>Net Sales</th>
		</tr>";
            //echo $sql;
            $sql = "select * from tmprepsale where user_id='".$_SESSION["CURRENT_USER"]."' order by rgroup";
	    $rgroup ="";	    	
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            while ($row = mysqli_fetch_array($result)) {
                if ($row["rgroup"] != $rgroup) {
                    echo "<tr>
					<td colspan=4 align=left><b>" . $row["rgroup"] . "</b></td>
					<tr>";
                }
                echo "<td>" . $row["rep"] . "</td>
			<td>" . $row["Name"] . "</td>
			<td align=\"right\">" . number_format($row["grossale"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["grossgrn"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["net"], 2, ".", ",") . "</td>
			</tr>";
                $rgroup = $row["rgroup"];
            }

            echo "<table>";
        }
        ?>



    </body>
</html>
