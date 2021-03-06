<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Dealer Inventry Report</title>

        <style>
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
                font-size:14px;

            }
            td
            {
                font-size:14px;
                border-bottom:none;
                border-top:none;
            }
        </style>

    </head>

    <body>


        <?php
        require_once("connectioni.php");
        $rep = trim($_GET["rep"]);

         $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);


        $tb = "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

        $tb .= "<center>Delaer Inventry";

        $tb .= "<center><table border=1><tr>";

        $tb .= "<tr>";
        $tb .= "<th width=\"50\"  background=\"\">Dealer Code</th>";
        $tb .= "<th width=\"350\"  background=\"\">Dealer Name</th>";
		
		
        $sql = "select BRAND_NAME from view_batt_smas  group by BRAND_NAME order by BRAND_NAME";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
		$i=4;
        while ($row = mysqli_fetch_array($result)) {
            $tb .= "<th  width=\"70\">" . $row['BRAND_NAME'] . "</th>";
			$i=$i+1;
        }
		
		
		$tb .= "<th background=\"\">Last Update</th>";
        $tb .= "<th  width=\"70\">Total</th>";
        $tb .= "</tr>";

		$mrep = "";
		
		$sql_head = "select c_code,rep from battry_inv group by c_code,rep order by rep";
		$result = mysqli_query($GLOBALS['dbinv'],$sql_head);
        while ($row = mysqli_fetch_array($result)) {
          
		  
			if ($mrep !=  trim($row['rep'])) {
				$sql = "select * from s_salrep where REPCODE ='" .  $row['rep']  . "'";
				$result_v = mysqli_query($GLOBALS['dbinv'],$sql);			
				$row_v = mysqli_fetch_array($result_v);			
			
				$tb .= "<tr><th align='left' colspan='" . $i . "'>" . $row_v['Name'] . "</th></tr>";
				
			}
			$mrep =  trim($row['rep']);
		  
			$tb .= "<tr>";
            $tb .= "<td>" . $row['c_code'] . "</td>";
			
			$sql = "select NAME from vendor where code = '".  $row['c_code']  . "'";
			$result_v = mysqli_query($GLOBALS['dbinv'],$sql);			
			$row_v = mysqli_fetch_array($result_v);
			
			$tb .= "<td>" . $row_v['NAME'] . "</td>";
			
			$sql = "select sdate from battry_inv where rep='" . $row['rep'] . "' and c_code='" . trim($row['c_code']) . "'  group by sdate order by sdate desc limit 1";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql);
			$row2 = mysqli_fetch_array($result2);
			
			
			
			
	 
			$sql = "select BRAND_NAME from view_batt_smas  group by BRAND_NAME order by BRAND_NAME";
			$result_b = mysqli_query($GLOBALS['dbinv'], $sql);
			$mtot = 0;
            while ($row1 = mysqli_fetch_array($result_b)) {

                $sql = "select sum(qty) as qty from view_batt_smas where rep='" . $row['rep'] . "' and brand_name ='" . $row1['BRAND_NAME']  ."' and c_code='" . trim($row['c_code']) . "' and sdate = '" . $row2['sdate'] . "'";
                
				$result3 = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row3 = mysqli_fetch_array($result3)) {
                    $tb .= "<td align='right'>" . $row3['qty'] . "</td>";
					$mtot = $mtot + $row3['qty'];
                } else {
                   $tb .= "<td align='right'>-</td>";
                }
				
            }
			$tb .= "<td align='right'>" . $row2['sdate'] . "</td>";
			$tb .= "<td align='right'>" . $mtot . "</td>";
			
            $tb .= "</tr>";
        }

        $tb .= "</table>";

        echo $tb;
        ?>
	</body>
</html>

