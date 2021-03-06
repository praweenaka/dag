<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Return Cheque Summery</title>
        <style>
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:14px;
            }
            table
            {
                border-bottom: 1px solid;
                border-left: 1px solid;
                border-right: 1px solid;
                border-top: 1px solid;

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
                font-size:14px;
            }
            td
            {
                font-size:13px;
            }

            .thd {
                border-top: 1px solid;
            }

            .thl {
                border-right: 1px solid;
            }

            .th2 {
                border-bottom: 1px dotted;
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
        </style>
    </head>

    <body>


<?php

include('connectioni.php');



 $sql_head = "select * from invpara";
        $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
        $row_head = mysqli_fetch_array($result_head);

        echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


        echo "<center>" . $heading . "</center><br>";
		

$tb = "<table><tr>";
$tb .= "<th></th>";
								$tb .= "<th>Settlement No</th>";
								$tb .= "<th>Refno</th>";
								$tb .= "<th>Cheque No</th>";
								$tb .= "<th>Cheque Date</th>";
								$tb .= "</tr>";




$t= "f";
			$i=0;
			$cou =12;
			$mchno = trim($_GET["txtChequeNo"]);
			$mchdate = $_GET["che_date"];
			//echo $t;
			$p=1;
			
			$tb .= "<tr>";
								$tb .= "<td>" . $p . "</td>";
								$tb .= "<td></td>";
								 $tb .= "<td></td>";
								$tb .= "<td>" . $mchno  . "</td>";
								$tb .= "<td>" . $mchdate  . "</td>";
								$tb .= "</tr>";
			
			$p=2;
			while ($i <= $cou) {
				
			$sql = "select * from  s_invcheq where  cheque_no='". trim($mchno) ."' and che_date = '". $mchdate ."'";
			
			$result = mysqli_query($GLOBALS['dbinv'],$sql);
			if($row = mysqli_fetch_array($result)){
				  
				if (trim($row['trn_type']) == "RET") {
					$sql = "select * from ch_sttr where st_refno ='" . $row['refno'] . "' and st_chno='" . $mchno . "'";
					$result_p = mysqli_query($GLOBALS['dbinv'],$sql);
					
					if ($row_p = mysqli_fetch_array($result_p)){
						$sql = "select * from s_cheq where cr_refno ='" . $row_p['ST_INVONO'] . "'";
						$result_p1 = mysqli_query($GLOBALS['dbinv'],$sql);
						if ($row_p1 = mysqli_fetch_array($result_p1)) {
							
							$sql = "select * from  s_invcheq where  cheque_no='". trim($row_p1['CR_CHNO']) ."' and che_date = '". $row_p1['CR_CHDATE'] ."'";
							$result_p2 = mysqli_query($GLOBALS['dbinv'],$sql);
							if($row_p2 = mysqli_fetch_array($result_p2)) {
								$mchno = trim($row_p2["cheque_no"]);
								$mchdate = $row_p2["che_date"];
								
								$tb .= "<tr>";
								$tb .= "<td>" . $p . "</td>";
								$tb .= "<td>" . $row['refno']  . "</td>";
								$tb .= "<td>" . $row_p['ST_INVONO']  . "</td>";
								 
								$tb .= "<td>" . $mchno  . "</td>";
								$tb .= "<td>" . $mchdate  . "</td>";
								$tb .= "</tr>";
								$p=$p+1;
							} else {
								$cou = $i;
							}
							
							
						}
					} else {
					
					$cou = $i;

					
					}
				
			} else {
				$t ="t";
				$mrefno = $row['refno'];
				$cou = $i;
			}	
			}
			$i = $i +1;
			}










echo $tb;











?>