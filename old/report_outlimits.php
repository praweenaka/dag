<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Outstanding Credit Limits</title>

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
                font-size:12px;

            }
            td
            {
                font-size:11px;

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
        require_once("connectioni.php");
        
        



        $sql = "DELETE * FROM creditbalance";
        $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 

        $sql_head = "select * from invpara";
        $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
        $row_head = mysqli_fetch_array($result_head);

        echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

        $heading = "<center>Balance Limit Report On  " . date("Y-m-d") . "<br>";
        echo $heading;



        echo "<table border=1>";
        echo "<tr><td><b>Code</b></td>"
        . "<td><b>Name</b></td>"
        . "<td><b>Limit</b></td>"
        . "<td><b>Outstanding</b></td>"
        . "<td><b>Pd Chq</b></td>"
        . "<td><b>Rtn Chq</b></td>"
        . "<td><b>Balance</b></td>"
        . "</tr>";

        $sql = "select *  from vendor where code <> ''  ";

        if (isset($_GET['Chk_cus'])) {
            $sql .=" and code ='" . $_GET['cuscode'] . "'";
        }
      
        $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        while ($row = mysqli_fetch_array($result)) {

            $sql = "select *  from br_trn where credit_lim >0 and cus_code = '" . $row['CODE'] . "' ";

            if ($_GET["cmbbrand"] != "All") {
                $sql .= " and brand='" . $_GET["cmbbrand"] . "' ";
            }
            if ($_GET["cmbrep"] != "All") {
                $sql .= " and rep='" . $_GET["cmbrep"] . "' ";
            }
              
            $result_crlimt = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            if (mysqli_num_rows($result_crlimt) > 0) {
                $balance = 0;
                while ($row_cr = mysqli_fetch_array($result_crlimt)) {

                    if (trim($row_cr['CAT']) != "C") {
                        $balance = $balance + ($row_cr['credit_lim'] * 2.5);
                    } else {
                        $balance = $balance + $row_cr['credit_lim'];
                    }
                }

                $strsql = "Select sum(grand_tot - totpay) as bal from view_s_salma where ACCNAME <> 'NON STOCK' and c_code='" . $row['CODE'] . "' and CANCELL='0' and grand_tot-totpay>1";
                if ($_GET["cmbbrand"] != "All") {
                    $strsql .=" and class='" . Trim($_GET["cmbbrand"]) . "'";
                }
                if ($_GET["cmbrep"] != "All") {
                    $strsql .=" and sal_ex='" . Trim($_GET["cmbrep"]) . "'";
                }
 
                $result_ot = mysqli_query($GLOBALS['dbinv'],$strsql);
                $row_ot = mysqli_fetch_array($result_ot);
                $outt = $row_ot['bal'];

                $strsql = "Select sum(CR_CHEVAL - paid) as rtbal from s_cheq where CR_C_CODE='" . $row['CODE'] . "' and CR_CHEVAL-paid>1 and cr_flag='0'";
                if ($_GET["cmbrep"] != "All") {
                    $strsql .=" and s_ref='" . Trim($_GET["cmbrep"]) . "'";
                }
                $result_ret = mysqli_query($GLOBALS['dbinv'],$strsql);
                $row_ret = mysqli_fetch_array($result_ret);
                $rtnbal = $row_ret['rtbal'];

                $sdate = date("Y-m-d");
                if ($_GET["cmbbrand"] == "All") {
                    $strsql = "SELECT sum(che_amount) as che_amount FROM s_invcheq WHERE CHE_DATE>'" . $sdate . "' and CUS_CODE='" . $row['CODE'] . "'";
                    if ($_GET["cmbrep"] != "All") {
                        $strsql .=" and sal_ex='" . Trim($_GET["cmbrep"]) . "'";
                    }
                     
                    $result_pdc = mysqli_query($GLOBALS['dbinv'],$strsql);
                    $row_pdc = mysqli_fetch_array($result_pdc);
                    $pd_amo =$row_pdc['che_amount'];
                    
                }



                if ($_GET["cmbbrand"] != "All") {
                      
                    $strsql = "SELECT * FROM s_invcheq WHERE CHE_DATE>'" . $sdate . "' and CUS_CODE='" . $row['CODE'] . "'";
                    if ($_GET["cmbrep"] != "All") {
                        $strsql .=" and sal_ex='" . Trim($_GET["cmbrep"]) . "'";
                    }
                   
                    $result_pdc = mysqli_query($GLOBALS['dbinv'],$strsql);
                    while ($row_pdc = mysqli_fetch_array($result_pdc)) {
                        $str_stt = "select * from s_sttr where st_refno='" . Trim($row_pdc["refno"]) . "' and st_chno ='" . Trim($row_pdc["cheque_no"]) . "'";
                       
                        $result_stt = mysqli_query($GLOBALS['dbinv'],$str_stt);
                        $row_stt = mysqli_fetch_array($result_stt);
                        $sql_sm = "select class from view_s_salma where ACCNAME <> 'NON STOCK' and ref_no='" . Trim($row_stt["ST_INVONO"]) . "'  order by sdate";
                         
                        $result_sm = mysqli_query($GLOBALS['dbinv'],$sql_sm);
                        $row_sm = mysqli_fetch_array($result_sm);
                        if ($row_sm['Class'] == $_GET["cmbbrand"]) {
                            $pd_amo = $pd_amo + $row_pdc['ST_PAID'];
                        }
                    }
                }

                $row_pdc = mysqli_fetch_array($result_pdc);
                $rtnbal = $row_ret['rtbal'];

                $totout =$totout+$outt;
                $totpd =$totpd+$pd_amo;
                $totret =$totret+$rtnbal;
                $totlim =$totlim+$balance;
                echo "<tr>
			<td width='70'>" . $row["CODE"] . "</td>
			<td>" . $row["NAME"] . "</td>
			<td width='70' align=\"right\">" . number_format($balance, 2, ".", ",") . "</td>
			<td width='70' align=\"right\">" . number_format($outt, 2, ".", ",") . "</td>
                        <td width='70' align=\"right\">" . number_format($pd_amo, 2, ".", ",") . "</td>
                        <td width='70' align=\"right\">" . number_format($rtnbal, 2, ".", ",") . "</td>    
			<td width='70' align=\"right\">" . number_format($balance - $outt - $rtnbal-$pd_amo, 2, ".", ",") . "</td>";
                echo "</tr>";
            } else {
				
			    $balance =0; 
				$pd_amo =0;
				$rtnbal =0;
				
				
                $strsql = "Select sum(grand_tot - totpay) as bal from view_s_salma where ACCNAME <> 'NON STOCK' and c_code='" . $row['CODE'] . "' and CANCELL='0' and grand_tot-totpay>1";
                if ($_GET["cmbbrand"] != "All") {
                    $strsql .=" and class='" . Trim($_GET["cmbbrand"]) . "'";
                }
                if ($_GET["cmbrep"] != "All") {
                    $strsql .=" and sal_ex='" . Trim($_GET["cmbrep"]) . "'";
                }
 
                $result_ot = mysqli_query($GLOBALS['dbinv'],$strsql);
                $row_ot = mysqli_fetch_array($result_ot);
				
                $outt = $row_ot['bal'];
				
				


                
				
				if ($outt>0) {
					 echo "<tr>
			<td width='70'>" . $row["CODE"] . "</td>
			<td>" . $row["NAME"] . "</td>
			<td width='70' align=\"right\">0</td>
			<td width='70' align=\"right\">" . number_format($outt, 2, ".", ",") . "</td>
                        <td width='70' align=\"right\">" . number_format($pd_amo, 2, ".", ",") . "</td>
                        <td width='70' align=\"right\">" . number_format($rtnbal, 2, ".", ",") . "</td>    
			<td width='70' align=\"right\">" . number_format($balance - $outt - $rtnbal-$pd_amo, 2, ".", ",") . "</td>";
                echo "</tr>";
				}	
				

			


			
			}	
            
          
            
        }
        
              echo "</table><br><br><table ><tr> <td>Total Credit Limit</td>  <td align=\"right\"> " . number_format($balance, 2, ".", ",")  . " </tr>"
                    . "<tr> <td>Total Sum Of Outstanding</td>  <td align=\"right\"> " . number_format($outt+$rtnbal+$pd_amo, 2, ".", ",")  . " </tr> "
                    . "<tr> <td>Total Balance</td>  <td align=\"right\">  " . number_format($balance-($outt+$rtnbal+$pd_amo), 2, ".", ",")  . " </tr>  </table>";
        
        ?>



    </body>
</html>
