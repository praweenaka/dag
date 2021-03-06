<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Defect Inventry</title>

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

        $tb .= "<center>Defect Inventry";
 
		 
		 
			
			 
		 
        
		
	 
		 
		 
        $tb .= "<center><table border=1><tr>";

        $tb .= "<tr>";
        $tb .= "<th width=\"50\"  background=\"\">Stock No</th>";
        $tb .= "<th width=\"450\"  background=\"\">Description</th>";
        $tb .= "<th width=\"50\"  background=\"\">Qty</th>";
        $sql = "select stk_no,descript,brand_name,sum(qty) as qty from view_s_trn_def ";
		if ($_GET['cmbbrand'] !="All") {
			$sql .= " where brand_name ='" . $_GET['cmbbrand'] . "'";	
		}
		
		$sql .= " group by stk_no,descript,brand_name order by brand_name";
		
		$result = mysqli_query($GLOBALS['dbinv'],$sql);	
		
		$mbrand = "";
		
        while ($row = mysqli_fetch_array($result)) {
             
			if ($mbrand != $row['BRAND_NAME']) {
				
				if ($mbrand != "") {
					$tb .= "<tr><th colspan='2'></th><th align='right' >" . $mqty . "</th></tr>";
					
				}
				$mqty =0;
				 $tb .= "<tr><th align='left' colspan='3'>" . $row['BRAND_NAME'] . "</th></tr>";
			} 
			$mbrand = $row['BRAND_NAME']; 
            $tb .= "<tr><td>" . $row['STK_NO'] . "</td>";
            $tb .= "<td>" . $row['DESCRIPT'] . "</td>";
            $tb .= "<td align='right'>" . number_format($row['qty'],0,"","") . "</td>";
            
			$mqty = $mqty + $row['qty'];
             $totqty = $totqty + $row['qty'];

            $tb .= "</tr>";
        }
		$tb .= "<tr><th colspan='2'></th><th align='right' >" . $mqty . "</th></tr>";
		$tb .= "<tr><th colspan='2'></th><th align='right' >" . $totqty . "</th></tr>";
        $tb .= "</table>";

        echo $tb;
        ?>


    </body>
</html>

