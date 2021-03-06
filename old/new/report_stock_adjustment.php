<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Stock Adjustment</title>

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
                font-size:12px;

            }
        </style>

    </head>

    <body>

        <?php
		
		require_once("connectioni.php");
		 
        $d1 = $_GET['dtfrom'];
        $d2 = $_GET['dtto'];

		
		   $sql_invp = "select * from invpara";
        $result_para = mysqli_query($GLOBALS['dbinv'], $sql_invp);
        if ($row_result_para = mysqli_fetch_array($result_para)) {
            $stt = "<center><h3>" . $row_result_para['COMPANY'] . "</h3></center>";
        }
		
		 
        $stt .= "<center><h5>Stock Adjustment From - " .  $_GET['dtfrom']  .  " To " .  $_GET['dtto']  . "</h5></center>";
		 if (isset($_GET['optcancell'])) {
          $stt .= "<center><h5>Cancelled</h5></center>";
		 }
        


     
		

         if (isset($_GET['refno'])) {
			 
			 
	    $sql_invp = "select * from INREQ_MAS where REFNO='" . $_GET['refno'] . "'";
        $result_para = mysqli_query($GLOBALS['dbinv'], $sql_invp);
        if ($row = mysqli_fetch_array($result_para)) {
            
			 
			  $stt .= "<center><table style='width:600px;'><tr><td>Reference No :</td><td>  " . $row['refno'] . "</td><td>Date :</td><td>" . date("Y-m-d", strtotime($row['sdate'])) .  " </td></tr>
			  <tr><td>Remark :</td><td>  " . $row['remark'] . "</td><td></td><td></td></tr></center>";
		} 
		 }

        
       
            $stt .= "<center><table border='1'>";

            $stt .= "<thead>";
            $stt .="<tr><th>Reference #</th><th>Date</th><th>Remark</th><th>Type</th>"
                    . "<th>Item Code</th>"
					. "<th>Description</th>"
					. "<th>Brand</th>"
					. "<th>Qty</th>";
					
            $stt .= "</tr>";
            $stt .= "</thead>";

            $stt .= "<tbody>";
            $sql = "select * from view_adj ";
			if (!isset($_GET['optcancell'])) {
				$sql .= " where  cancell='0'";
			}	else {
				$sql .= " where  cancell='1'";
			}	
			
			if (!isset($_GET['refno'])) {
  			$sql .= "   and (sdate >='" . $_GET['dtfrom']  .  "'  and sdate <='" . $_GET['dtto'] . "')"; 
			} else {
			$sql .= " and refno ='" . $_GET['refno'] . "'";	
				
			}
            $sql .= "  order by refno,trn_type,id";
			
            $tot = 0;  
            $tot1 = 0;
            $tot2 = 0;
            $result_mas = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row_result_mas = mysqli_fetch_array($result_mas)) {
				
				
				
					if ($mrefno != TRIM($row_result_mas['refno'])) {
					if ($mrefno !="") {
					
				$stt .= "<tr>";
                $stt .= "<td colspan='7'></td><td>" . $mqty  . "</td></tr>"; 					
						$mqty =0;
					  $stt .= "<tr>";
                $stt .= "<td colspan='8'></td></tr>"; 
				
				
					}
		
				}
				
                $stt .= "<tr>";
                $stt .= "<td>" .  $row_result_mas['refno'] . "</td>";
				 $stt .= "<td>" .  $row_result_mas['sdate'] . "</td>";
			    $stt .= "<td>" .  $row_result_mas['remark'] . "</td>";
				
				if (trim($row_result_mas['trn_type']) =="IIN") {
					$stt .= "<td>Addition</td>";
					
					$mqty1 = $mqty1 + $row_result_mas['qty'];
				} else {
					$stt .= "<td>Deduction</td>";
					$mqty2 = $mqty2 + $row_result_mas['qty'];
				}
				
                $mqty = $mqty + $row_result_mas['qty'];
				
                $stt .= "<td>" .  $row_result_mas['stk_no'] . "</td>";
				$stt .= "<td>" .  $row_result_mas['DESCRIPT'] . "</td>";
				$stt .= "<td>" .  $row_result_mas['BRAND_NAME'] . "</td>";
				$stt .= "<td>" .  $row_result_mas['qty'] . "</td></tr>"; 
				
				$mtrntype = trim($row_result_mas['trn_type']);
				$mrefno = trim($row_result_mas['refno']);
            }
			
			
			
				$stt .= "<tr>";
                $stt .= "<td colspan='7'></td><td>" . $mqty  . "</td></tr>"; 					
						 
			$stt .= "<tr>";
                $stt .= "<td colspan='7'></td><th>" . ($mqty1-$mqty2) . "</th>
				</tr>"; 
			
		
			
			
            $stt .= "</tbody>";

            $stt .= "</table>";
        
 
 
 
        echo $stt;


        ?>





    </body>
</html>
