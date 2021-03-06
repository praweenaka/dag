<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>New qty Report</title>

        <style>
            .heading {
                color: #0000FF;
                font-weight: bold;
                font-size: 24px;
            }

            .heading1 {
                color: #000000;
                font-weight: bold;
                font-size: 18px;
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
                font-size:15px;
            }
            td
            {
                font-size:12px;

            }
        </style>

    </head>

    <body> <center> 


            <?php
            require_once("connectioni.php");

			 
			$sql_tmp = "delete from tmpqtysale where user_id='".$_SESSION["CURRENT_USER"]."'";
			$result_tmp = mysqli_query($GLOBALS['dbinv'],$sql_tmp);
		
            $sqlinv = "select * from viewinv  where stk_no ='" . $_GET['stkno'] . "' and   SDATE >= '" . $_GET["dateFrom"] . "' and SDATE <= '" . $_GET["dateTo"] . "' and cancel_m='0'  ";          
            $sqlgrn = "select * from viewcrntrn  where   stk_no ='" . $_GET['stkno'] . "' and SDATE >= '" . $_GET["dateFrom"] . "' and SDATE <= '" . $_GET["dateTo"] . "' and cancell='0'  ";
			
            
           
 
            $result2 = mysqli_query($GLOBALS['dbinv'],$sqlinv);
            $num = mysqli_num_rows($result2);
			
			$i=0;
			
            while ($row2 = mysqli_fetch_array($result2)) {
				
			 
				 
				$userData1[] = "('".trim($row2["SDATE"])."', '".trim($row2["REF_NO"])."', '".trim($row2["cus_code"])."', '".trim($row2["cust_name"])."', '0',  '".trim($row2["STK_NO"])."', '".$row2["DESCRIPT"]."', '".$row2["s_brand"]."', '".trim($row2["QTY"])."', '".$row2["DIS_per"]."', '".$row2["PRICE"]."', '".$_SESSION["CURRENT_USER"]."')";
				 
				 $i=$i+1;
				
				
				
            }



            $result3 = mysqli_query($GLOBALS['dbinv'],$sqlgrn);
			 
            while ($row3 = mysqli_fetch_array($result3)) {
                $sql_rep = "select name from s_salrep where REPCODE='" . $row3["SAL_EX"] . "'";
                $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep); 
			 
				
				 
				 $userData1[] = "('".trim($row3["SDATE"])."', '".trim($row3["REF_NO"])."', '".trim($row3["C_CODE"])."', '".trim($row3["CUS_NAME"])."', '".trim($row3["qty"])."',  '".trim($row3["STK_NO"])."', '".$row3["descript"]."', '".$row3["Brand"]."', '0', '".$row2["DIS_per"]."', '".$row2["PRICE"]."', '".$_SESSION["CURRENT_USER"]."')";
				  
			 }
			
				 
			$sql_tmp = "insert into tmpqtysale (sdate, refno, ccode, cname, RETqty, stkno, description, brand, INVqty, dis,value, user_id) values ". implode(',', $userData1);                 
            $result_tmp = mysqli_query($GLOBALS['dbinv'],$sql_tmp);
				 	
			
			 
			
			
			if ($_GET['Chk_cus_wise1'] =="on") {
			
            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

                echo "<center><span class=\"heading\">" . $row_head["COMPANY"] . "</span></center><br>";
                $dateFrom = $_GET["dateFrom"];
                $dateTo = $_GET["dateTo"];
                $stkNo = $_GET["stkno"];
                
                echo "<center><span class=\"heading1\"> Qty Report (Customer Based) for $stkNo : " . $dateFrom . " to " . $dateTo . "<span class=\"heading\"></center><br>";

                echo "<table  width=700 border=1>";
                echo "<tr>
                      
                        <th align=center width=50>Code</th>
                       <th align=center width=300>Customer</th>
                       <th align=center>Invoice Qty</th>
                       <th align=center>Return Qty</th>
                       <th align=center>Effective Qty</th>
                  </tr>";
 

                    $sql2 = "select ccode,cname,sum(INVqty) as INVqty,sum(RETqty) as RETqty from tmpqtysale where  user_id='".$_SESSION["CURRENT_USER"]."' group by ccode,cname order by ccode";
                    $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                    $mcode = ""; 
					while ($row2 = mysqli_fetch_array($result2)) {
                             echo "<tr>
								<td>" . $row2["ccode"] . "</td>										
                                <td>" . $row2["cname"] . "</td>
                                <td align=right>" . number_format($row2["INVqty"], 0, ".", ",") . "</td>
                                <td align=right>" . number_format($row2["RETqty"], 0, ".", ",") . "</td>
								<td align=right>" . number_format(($row2["INVqty"] - $row2["RETqty"]), 0, ".", ",") . "</td>
                              </tr>";
							  $effectiveQty = $effectiveQty + ($row2["INVqty"] - $row2["RETqty"]);
							  $effectiveQtym = $effectiveQtym + ($row2["INVqty"] - $row2["RETqty"]);
                        
						}
						 
								 
						
								echo "<tr>
                                <td colspan='4'></td>
                                 <td  align=right><b>" . number_format($effectiveQtym, 0, ".", ",") . "</td>
                              </tr>";		
						 
                         
                    
                

                echo "</table>";
			} else {
				$sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

                echo "<center><span class=\"heading\">" . $row_head["COMPANY"] . "</span></center><br>";
                $dateFrom = $_GET["dateFrom"];
                $dateTo = $_GET["dateTo"];
                $stkNo = $_GET["stkno"];
                
                echo "<center><span class=\"heading1\"> Qty Report (Customer and Invoice number Based) for $stkNo : " . $dateFrom . " to " . $dateTo . "<span class=\"heading\"></center><br>";

                echo "<table  width=700 border=1>";
                echo "<tr>
                       <th align=center>Date</th>
                       <th align=center>Refno</th>
                        
                       <th align=center width=300>Customer</th>
                       <th align=center>Invoice Qty</th>
                       <th align=center>Return Qty</th>
                       <th align=center>Effective Qty</th>
                  </tr>";
 

                    $sql2 = "select * from tmpqtysale where  user_id='".$_SESSION["CURRENT_USER"]."' order by ccode";
                    $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                    $mcode = ""; 
					while ($row2 = mysqli_fetch_array($result2)) {
							if ($mcode != "" and $mcode != $row2['ccode']) {
								echo "<tr>
                                <td colspan='5'></td>
                                 <td  align=right><b>" . number_format($effectiveQty, 0, ".", ",") . "</td>
                              </tr>";
								
							}
							
							if ($mcode != $row2['ccode']) {
								$effectiveQty=0;
								echo "<tr>
                                <td colspan='6'>&nbsp;</td>
                                
                              </tr>";
								
							}
							
							$mcode = trim($row2['ccode']);
                            echo "<tr>
                                <td>" . $row2["sdate"] . "</td>
                                <td>" . $row2["refno"] . "</td>    
                                 
                                <td>" . $row2["cname"] . "</td>
                                <td align=right>" . number_format($row2["INVqty"], 0, ".", ",") . "</td>
                                <td align=right>" . number_format($row2["RETqty"], 0, ".", ",") . "</td>
								<td></td>
                              </tr>";
							  $effectiveQty = $effectiveQty + ($row2["INVqty"] - $row2["RETqty"]);
							  $effectiveQtym = $effectiveQtym + ($row2["INVqty"] - $row2["RETqty"]);
                        }
						 
								echo "<tr>
                                <td colspan='5'></td>
                                 <td  align=right><b>" . number_format($effectiveQty, 0, ".", ",") . "</td>
                              </tr>";
						
								echo "<tr>
                                <td colspan='5'></td>
                                 <td  align=right><b>" . number_format($effectiveQtym, 0, ".", ",") . "</td>
                              </tr>";		
						 
                         
                    
                

                echo "</table>";
			}
			
            ?>


    </body>
</html>
