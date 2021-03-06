<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SVAT Report</title>
        <style>
            .spn {
                border-bottom: 1px solid;
                border-left: 1px solid;
                border-right: 1px solid;
                width: 760px;
            }
            .lefts{
                float: right;
            }
        </style>
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

            .headd 
            {
                font-size: 16px;
            }

            .th1 {
                border-top :none;
            }

            .th2 {
                border-bottom: none;
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

        <style type="text/css">
            <!--
            .style2 {
                border:none ;            
            }
            -->
        </style>


    </head>

    <body> 

        <?php
        require_once("connectioni.php");


        if ($_GET["opsvat"] == "OptSupform1") {

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            $sql = "delete from tmp_svatrepo";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql);


            echo "<center><span>" . $row_head["COMPANY"] . "</span></center><br>";
            $heading = "<center><span>SVAT Report " . $_GET["cuscode"] . "-" . $_GET['cusname'] . " From " . $_GET["dtfrom"] . " To " . $_GET["dtto"] . "</span><br>";

            echo $heading;

            echo "<br>";

            echo "<table border=1>";
            echo "<tr><td width='50'><b><center>Serial No</center></b></td>"
            . "<td width='90'><b><center>Vat No.</center></b></td>"
            . "<td width='150'><b><center>Dealer</center></b></td>"
            . "<td width='100'><b><center>Suspended TAX Invoice No</center></b></td>"
            . "<td width='90'><b><center>Date of Supply</center></b></td>"
            . "<td width='90'><b><center>Value of Invoice (SLRS)</center></b></td>"
            . "<td width='90'><b><center>Suspended VAT Amount (SLRS)</center></b></td>"
            . "</tr>";

            $sql = "SELECT * from s_salma where  CANCELL='0' and sdate >= '" . $_GET["dtfrom"] . " ' and sdate <= ' " . $_GET["dtto"] . " ' and svat > '0'";
            if ($_GET["cuscode"] != "") {
                $sql = $sql . " and c_code='" . $_GET["cuscode"] . "'";
            }
            $sql = $sql . "  order by s_vat_no";



            $i = 1;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $tinvtot = 0;
            $tsvatv = 0;
            $svatno = "";
            while ($row = mysqli_fetch_array($result)) {

                $sql = "select c_name as NAME from vender_sub where c_code ='" . $row['c_code1'] . "'";
                $result_v = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row_v = mysqli_fetch_array($result_v)) {
					
				} else {
				
				$sql = "select * from vender where code ='" . $row['C_CODE'] . "'";
                $result_v = mysqli_query($GLOBALS['dbinv'], $sql);
                $row_v = mysqli_fetch_array($result_v); 
					
				}

                $invtot = $row["GRAND_TOT"] / (1 + ($row["GST"] / 100));
                $svatv = $row["GRAND_TOT"] - $invtot;

                $user[] = "('" . $row['s_vat_no'] . "','" . $row['vat_no'] . "','" . $row['CUS_NAME'] . "','" . $row['REF_NO'] . "','" . $row['SDATE'] . "','" . $invtot . "','" . $svatv . "','" . $row['C_CODE'] . "','INV','" . $row_v['NAME'] . "')";
            }


            $sql = "SELECT * from viewreturn_svat where  CANCELL='0' and sdate >= '" . $_GET["dtfrom"] . " ' and sdate <= ' " . $_GET["dtto"] . " ' and svat > '0'";
            if ($_GET["cuscode"] != "") {
                $sql = $sql . " and cuscode='" . $_GET["cuscode"] . "'";
            }
            $sql = $sql . "  order by s_vat_no";



            $i = 1;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $tinvtot = 0;
            $tsvatv = 0;
            $svatno = "";
            while ($row = mysqli_fetch_array($result)) {

                $sql = "select * from vendor where code ='" . $row['cuscode'] . "'";
                $result_v = mysqli_query($GLOBALS['dbinv'], $sql);
                $row_v = mysqli_fetch_array($result_v);

                $invtot = ($row["AMOUNT"] / (1 + ($row["vatrate"] / 100))) * -1;
                $svatv = ($row["AMOUNT"] * -1) - $invtot;

                $user[] = "('" . $row['s_vat_no'] . "','" . $row['vat_no'] . "','" . $row['NAME'] . "','" . $row['REF_NO'] . "','" . $row['SDATE'] . "','" . $invtot . "','" . $svatv . "','" . $row['cuscode'] . "','RET','" . $row_v['NAME'] . "')";
            }
			
			 $sql = "select * from view_c_bal_vendor_new where sdate >='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and vatno <> ''  and vatno <> '.' and (trn_type = 'CNT')and cancell='0' order by id";
			 $sql = "select * from view_cbal_cred_salma where ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )  and trn_type ='CNT' and svat >0";
            //echo $sql;
			$result = mysqli_query($GLOBALS['dbinv'], $sql);
            $tinvtot = 0;
            $tsvatv = 0;
            $svatno = "";
            while ($row = mysqli_fetch_array($result)) {
				
				$sql = "select * from cred where c_refno = '" . $row['REFNO']  . "'";
				$result_g = mysqli_query($GLOBALS['dbinv'], $sql);
				$row_g =mysqli_fetch_array($result_g);
										
				$invno = $row_g['C_INVNO'];
						
				$sql = "select * from s_salma where ref_no ='" . $invno . "' and svat <> 0";
				$result_g = mysqli_query($GLOBALS['dbinv'], $sql);
				
				if ($row_g =mysqli_fetch_array($result_g)) {
				 	
                $sql = "select * from vendor where code ='" . $row['cuscode'] . "'";
                $result_v = mysqli_query($GLOBALS['dbinv'], $sql);
                $row_v = mysqli_fetch_array($result_v);

                $invtot = ($row["AMOUNT"] / (1 + ($row["vatrate"] / 100))) * -1;
                $svatv = ($row["AMOUNT"] * -1) - $invtot;

                $user[] = "('" . $row_g['s_vat_no'] . "','" . $row_g['vat_no'] . "','" . $row_g['CUS_NAME'] . "','" . $row['REFNO'] . "','" . $row['SDATE'] . "','" . $invtot . "','" . $svatv . "','" . $row['cuscode'] . "','RET','" . $row_v['NAME'] . "')";
				
				}	 
			}


            $sql = "insert into tmp_svatrepo (s_vat_no,vat_no,NAME,REF_NO,SDATE,GRAND_TOT,SVAT,c_code,rtype,cname) values " . implode(",", $user);
			 
            $res = mysqli_query($GLOBALS['dbinv'], $sql);

            $sql = "select * from tmp_svatrepo order by s_vat_no,rtype,sdate,REF_NO";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {



                if ($svatno != $row['s_vat_no']) {

                    if ($svatno != "") {
                        echo "<tr><th colspan='5'></td><th align=\"right\">" . number_format($minvtot1, 2, ".", ",") . "</th>";
                        echo "<th align=\"right\">" . number_format($msvatv1, 2, ".", ",") . "</th></tr>";

                        $i = 1;
                        $minvtot1 = 0;
                        $msvatv1 = 0;

                        echo "<tr><th colspan='5'></td><th align=\"right\">" . number_format($minvtot, 2, ".", ",") . "</th>";
                        echo "<th align=\"right\">" . number_format($msvatv, 2, ".", ",") . "</th></tr>";
                    }
                    $minvtot = 0;
                    $msvatv = 0;

                    $rtype = "";
                    $minvtot1 = 0;
                    $msvatv1 = 0;

                    $i = 1;
                    echo "<tr><td>" . $row["s_vat_no"] . "</td><td colspan='6'>" . $row['cname'] . "</td></tr>";
                    echo "<tr><td colspan='6'>" . $row['rtype'] . "</td></tr>";
                }


                if (($rtype != $row['rtype']) and ( $msvatv1 != 0)) {

                    echo "<tr><th colspan='5'></td><th align=\"right\">" . number_format($minvtot1, 2, ".", ",") . "</th>";
                    echo "<th align=\"right\">" . number_format($msvatv1, 2, ".", ",") . "</th></tr>";

                    echo "<tr><td colspan='6'>" . $row['rtype'] . "</td></tr>";
                    $i = 1;
                    $minvtot1 = 0;
                    $msvatv1 = 0;
                }

                $svatno = $row['s_vat_no'];



                $rtype = $row['rtype'];
                echo "<tr>
			<td>" . $i . "</td>
                        <td>" . $row["vat_no"] . "</td>    
                        <td>" . $row["NAME"] . "</td>        
			<td>" . $row["REF_NO"] . "</td>
			<td>" . $row["SDATE"] . "</td>
			<td align=\"right\">" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["SVAT"], 2, ".", ",") . "</td>";
                echo "</tr>";


                $minvtot = $minvtot + $row["GRAND_TOT"];
                $msvatv = $msvatv + $row["SVAT"];
                $minvtot1 = $minvtot1 + $row["GRAND_TOT"];
                $msvatv1 = $msvatv1 + $row["SVAT"];
                $tinvtot = $tinvtot + $row["GRAND_TOT"];
                $tsvatv = $tsvatv + $row["SVAT"];

                $i = $i + 1;
            }

            echo "<tr><th colspan='5'></td><th align=\"right\">" . number_format($minvtot, 2, ".", ",") . "</th>";
            echo "<th align=\"right\">" . number_format($msvatv, 2, ".", ",") . "</th></tr>";


            echo "<tr><th colspan='5'>Grand Total</th><th align=\"right\">" . number_format($tinvtot, 2, ".", ",") . "</th>";
            echo "<th align=\"right\">" . number_format($tsvatv, 2, ".", ",") . "</th></tr></table>";
        }





        if ($_GET["opsvat"] == "OptSupform") {

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);


            echo "<center><span>Form : SVAT 05</span></center><br>";

            $heading = "<center><span class='style1'>Goods/Services Declaration - Supplementary Form</span><br>";
            echo $heading;

            echo "<br>";

            echo "<table border=1>";
            echo "<tr><td width='90'><b><center>Serial No</center></b></td>"
            . "<td width='90'><b><center>Suspended TAX Invoice No</center></b></td>"
            . "<td width='90'><b><center>Date of Supply</center></b></td>"
            . "<td width='90'><b><center>Value of Invoice (SLRS)</center></b></td>"
            . "<td width='90'><b><center>Suspended VAT Amount (SLRS)</center></b></td>"
            . "<td width='150'><b><center>Credit Voucher No.</center></b></td>"
            . "</tr>";

            $sql = "SELECT * from s_salma where c_code='" . $_GET["cuscode"] . "'and CANCELL='0' and sdate >= '" . $_GET["dtfrom"] . " ' and sdate <= ' " . $_GET["dtto"] . " ' and svat > '0' order by id";

            $i = 1;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $tinvtot = 0;
            $tsvatv = 0;
            while ($row = mysqli_fetch_array($result)) {
                $invtot = $row["GRAND_TOT"] / (1 + ($row["GST"] / 100));
                $svatv = $row["GRAND_TOT"] - $invtot;

                echo "<tr>
			<td>" . $i . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td>" . $row["SDATE"] . "</td>
			<td align=\"right\">" . number_format($invtot, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($svatv, 2, ".", ",") . "</td><td></td>"
                ;

                echo "</tr>";
                $tinvtot = $tinvtot + $invtot;
                $tsvatv = $tsvatv + $svatv;

                $i = $i + 1;
            }

            echo "<tr><td colspan='3'></td><td align=\"right\">" . number_format($tinvtot, 2, ".", ",") . "</td>";
            echo "<td align=\"right\">" . number_format($tsvatv, 2, ".", ",") . "</td></tr></table>";

            echo "<br>";
            echo "<br>";

            echo "<table width='600'><tr> <td>______________________</td><td>________________________</td> </tr><tr><td>Signature of the Supplier & <br> Company Seal</td>";
            echo "<td>Signature of the Purchaser & <br> Company Seal</td>"
            . "</tr><tr><td></td><td></td></tr><tr><td></td><td></td></tr>";
            echo "<tr>"
            . "<td>Date:</td><td>Date:</td></tr></table>";
        }


        if ($_GET["opsvat"] == "opt_deb") {

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);


            echo "<center><span>Form : SVAT 05 (b)</span></center><br>";

            $heading = "<center><span class='style1'>Goods/Services Declaration - Supplementary Form Suspended VAT Credit Notes</span><br>";
            echo $heading;

            echo "<br>";

            echo "<table border=1>";
            echo "<tr><td width='90'><b><center>Serial No</center></b></td>"
            . "<td width='90'><b><center>SVAT Credit Note No</center></b></td>"
            . "<td width='90'><b><center>Relevent SVAT Invoice No</center></b></td>"
            . "<td width='90'><b><center>Date of Supply</center></b></td>"
            . "<td width='90'><b><center>Value of SVAT Credit Note(SLRS)</center></b></td>"
            . "<td width='90'><b><center>Suspended VAT Amount (SLRS)</center></b></td>"
            . "<td width='150'><b><center>Credit Voucher No. already obtained</center></b></td>"
            . "</tr>";


            $sql = "Select * from s_crnma where c_code ='" . $_GET["cuscode"] . "'and CANCELL='0' and sdate >= '" . $_GET["dtfrom"] . " ' and sdate <= ' " . $_GET["dtto"] . " '  order by ref_no";



            $i = 1;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $tinvtot = 0;
            $tsvatv = 0;
            while ($row = mysqli_fetch_array($result)) {

                $sql1 = "Select * from s_salma where ref_no = '" . $row["INVOICENO"] . "'";

                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                $numrow = mysqli_num_rows($result1);

                $row1 = mysqli_fetch_array($result1);



                if ($numrow > 0) {

                    if ($row1['SVAT'] > 0) {


                        $invtot = ($row["GRAND_TOT"] / (1 + ($row["GST"] / 100)));
                        $svatv = ($row["GRAND_TOT"] - $invtot);  // (1 + ($row["GST"] / 100)));


                        echo "<tr>
			<td>" . $i . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td>" . $row1["REF_NO"] . "</td>
			<td>" . $row1["SDATE"] . "</td>
                                             
                        <td align=\"right\">" . number_format($invtot, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($svatv, 2, ".", ",") . "</td><td></td>"
                        ;

                        echo "</tr>";
                        $tinvtot = $tinvtot + $invtot;
                        $tsvatv = $tsvatv + $svatv;

                        $i = $i + 1;
                    }
                }
            }

			
			$sql = "Select * from cred  where c_code ='" . $_GET["cuscode"] . "'and CANCELL='0' and c_date >= '" . $_GET["dtfrom"] . " ' and c_date <= ' " . $_GET["dtto"] . " '  order by c_refno";



            $i = 1;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $tinvtot = 0;
            $tsvatv = 0;
            while ($row = mysqli_fetch_array($result)) {

                $sql1 = "Select * from s_salma where ref_no = '" . $row["C_INVNO"] . "'";

                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                $numrow = mysqli_num_rows($result1);

                $row1 = mysqli_fetch_array($result1);



                if ($numrow > 0) {

                    if ($row1['SVAT'] > 0) {


                        $invtot = ($row["C_PAYMENT"] / (1 + ($row1["GST"] / 100)));
                        $svatv = ($row["C_PAYMENT"]- $invtot);  //   / (1 + ($row1["GST"] / 100)));


                        echo "<tr>
			<td>" . $i . "</td>
			<td>" . $row["C_REFNO"] . "</td>
			<td>" . $row1["REF_NO"] . "</td>
			<td>" . $row1["SDATE"] . "</td>
                                             
                        <td align=\"right\">" . number_format($invtot, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($svatv, 2, ".", ",") . "</td><td></td>"
                        ;

                        echo "</tr>";
                        $tinvtot = $tinvtot + $invtot;
                        $tsvatv = $tsvatv + $svatv;

                        $i = $i + 1;
                    }
                }
            }
			
            echo "<tr><td colspan='4'></td><td align=\"right\">" . number_format($tinvtot, 2, ".", ",") . "</td>";
            echo "<td align=\"right\">" . number_format($tsvatv, 2, ".", ",") . "</td></tr>";

            echo "<tr><td colspan='7'><br><br><br><br><br><br><br><table border='0' width=700><tr>
					   <td align=left width='450'>Signature of the supplier & Company Seal<br></td>
					   <td align=left>Signature of the supplier & Company Seal<br></td></tr>
					   <tr><td align=left><br>Date :</td><td align=left><br>Date :</td></tr></table></td></tr></table>";
        }


        if ($_GET["opsvat"] == "OptDecform") {

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><table class='style2'><tr><td width='20'></td>"
            . "<td><b>Reference No</b></td> "
            . "<td><input type='text' disabled></td> "
            . "<td width='80'></td>"
            . "<td><b>Form: SVAT 04</b></td></tr> "
            . "<tr><td width='20'></td>"
            . "<td></td> "
            . "<td>(Office Use Only)</td> "
            . "<td width='80'></td>"
            . "<td></td></tr>"
            . "</table>";



            echo "<br>";
            echo "<table border=1>";
            $strr = "<tr><td>"
                    . "<table width='750'>"
                    . "<tr>"
                    . "<td class='headd' ><center><b>Goods/Services Declaration under SVATS</b></center></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td class='headd'><center><b>(The Declaration should indicate supplies made during one calender month only)</b></center></td>"
                    . "</tr>"
                    . "</table>"
                    . "</td></tr></table>";
            echo $strr;


            $sql = "select sum(GRAND_TOT) as GRAND_TOT,sum(GRAND_TOT/(1+(GST/100))) as GRAND_TOT1,sum(GRAND_TOT/(1+(GST/100))) as SVAT, sum(Svat) as Svat from s_salma where  Svat > 0 and c_code='" . $_GET["cuscode"] . "' and CANCELL='0' and sdate >= '" . $_GET["dtfrom"] . " ' and sdate <= ' " . $_GET["dtto"] . " ' and svat > '0'";

            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $row = mysqli_fetch_array($result);
            $msale = $row["GRAND_TOT1"];
			$msale1 = $row["GRAND_TOT"];
            $msvat = $row["SVAT"];
            $msvat = $msale - $msvat;
	

            $sql = "select ref_no from s_salma where  Svat > 0 and c_code='" . $_GET["cuscode"] . "'and CANCELL='0' and sdate >= ' " . $_GET["dtfrom"] . " ' and sdate <= ' " . $_GET["dtto"] . " ' ";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $invoice = mysqli_num_rows($result);


            $sql = "select sum(GRAND_TOT) as GRAND_TOT,sum(GRAND_TOT/(1+(GST/100))) as GTOTW from view_s_crnma_s_salma where  SVAT > 0 and C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and SDATE >= '" . $_GET["dtfrom"] . " ' and SDATE <= ' " . $_GET["dtto"] . " ' ";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $row = mysqli_fetch_array($result);
            $mret = $row["GTOTW"];
            $mret1 = $row["GRAND_TOT"];

            $sql = "select sum(AMOUNT) as GRAND_TOT,sum(AMOUNT/(1+(vatrate/100))) as GTOTW from view_cbal_cred_salma  where  SVAT > 0 and CUSCODE='" . $_GET["cuscode"] . "' and CANCELL='0' and SDATE >= '" . $_GET["dtfrom"] . " ' and SDATE <= ' " . $_GET["dtto"] . " ' ";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $row = mysqli_fetch_array($result);
            $mret = $mret + $row["GTOTW"];
            $mret1 = $mret1 + $row["GRAND_TOT"];	
			
			
			$crn=0;
            $sql = "select REF_NO from view_s_crnma_s_salma where  SVAT > 0 and C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and SDATE >= ' " . $_GET["dtfrom"] . " ' and SDATE <= ' " . $_GET["dtto"] . " ' and SVAT > '0'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $crn = mysqli_num_rows($result);

			$sql = "select REFNO from view_cbal_cred_salma where  SVAT > 0 and CUSCODE='" . $_GET["cuscode"] . "' and CANCELL='0' and SDATE >= ' " . $_GET["dtfrom"] . " ' and SDATE <= ' " . $_GET["dtto"] . " ' and SVAT > '0'";
         
			$result = mysqli_query($GLOBALS['dbinv'], $sql);
            $crn = $crn +  mysqli_num_rows($result);

            $sql_ven = "select * from vendor where code = '" . $_GET["cuscode"] . "'";
            $result_ven = mysqli_query($GLOBALS['dbinv'], $sql_ven);
            $row_ven = mysqli_fetch_array($result_ven);

            echo "<div class ='spn' >";
            echo "<table  width='750'>";
            $strr = "<tr><td>"
                    . "<table border='1'  width='750'>"
                    . "<tr>"
                    . "<td></td>"
                    . "<td><center><b>From</b></center></td>"
                    . "<td><center><b>To</b></center></td>"
                    . "<td></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td>1. Period:</td>"
                    . "<td>" . $_GET["dtfrom"] . "</td>"
                    . "<td></td>"
                    . "<td>" . $_GET["dtto"] . "</td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td>2. Supplier:</td>"
                    . "<td></td>"
                    . "<td>3. Purchaser:</td>"
                    . "<td></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td>SVAT No:</td>"
                    . "<td>" . $row_head['svatno'] . "</td>"
                    . "<td>SVAT No:</td>"
                    . "<td>" . $row_ven['svatno'] . "</td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td>VAT No:</td>"
                    . "<td>" . $row_head['VAT'] . "</td>"
                    . "<td>VAT No:</td>"
                    . "<td>" . $row_ven['vatno'] . "</td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td>Name:</td>"
                    . "<td>" . $row_head['COMPANY'] . "</td>"
                    . "<td>Name:</td>"
                    . "<td>" . $row_ven['NAME'] . "</td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td></td>"
                    . "<td></td>"
                    . "<td></td>"
                    . "<td></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td>Address:</td>"
                    . "<td>" . $row_head['ADD1'] . "</td>"
                    . "<td>Address:</td>"
                    . "<td>" . $row_ven['ADD1'] . "</td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td></td>"
                    . "<td>" . $row_head['ADD2'] . "</td>"
                    . "<td></td>"
                    . "<td>" . $row_ven['ADD2'] . "</td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td>Email Address:</td>"
                    . "<td>" . $row_head['EMAIL'] . "</td>"
                    . "<td>Email Address:</td>"
                    . "<td>" . $row_ven['EMAIL'] . "</td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td colspan='3'>4. Total Value of invoices issued under SVAT (FORM SVAT 05)</td>";


            $sql_rs = "select * from vatrate where (sdate)<='" . $_GET["dtto"] . "' order by sdate desc";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
            if ($row_rs = mysqli_fetch_array($result_rs)) {
                $txtvat_new = 0; //$row_rs['vatrate'];
                $txtvat = 0; //$row_rs['vatrate'];
            }
			$crn1=0;
			if ($crn >0) 
			{
				$crn1 = 1; 
			}




            $strr .= "<td>= SLRS. <input type ='text' class='lefts' value ='" . number_format($msale / (1 + ($txtvat_new / 100)), 2, ".", ",") . "' disabled></td>";


            $strr .= "</tr>"
                    . "<tr>"
                    . "<td colspan='3'>5. Total Value of SVAT Debit Notes issued under SVAT (FORM SVAT 05(a))</td>"
                    . "<td>= SLRS.<input type ='text' class='lefts' value='" . number_format(0, 2, ".", ",") . "' disabled></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td  colspan='3' >6. Total Value of SVAT Credit Notes issued under SVAT (FORM SVAT 05(b))</td>";


            $strr .= "<td>= SLRS.<input type ='text' class='lefts' value= '" . number_format($mret / (1 + ($txtvat_new / 100)), 2, ".", ",") . "' disabled></td>";

            $strr .= "</tr>"
                    . "<tr>"
                    . "<td colspan='3'>7. Adjusted Value of Supplies made under SVAT (4 + 5 - 6)</td>";


            $strr .= "<td>= SLRS. <input type ='text' class='lefts' value='" . number_format(($msale - $mret) / (1 + ($txtvat_new / 100)), 2, ".", ",") . "' disabled></td>";

            $strr .= "</tr>"
                    . "<tr>"
                    . "<td colspan='3'>8. Suspended VAT for the above Period</td>";


            $strr .= "<td>= SLRS.<input type ='text' class='lefts' value='" . number_format((($msale1 - $msale)-($mret1-$mret)), 2, ".", ",") . "' disabled></td>";

            $strr .= "</tr>"
                    . "<tr>"
                    . "<td>9. No of Invoices:  </td>"
                    . "<td>SVAT05 <input type ='text' class='lefts' value='" . $invoice . "' disabled></td>"
                    . "<td>10. No of Pages of SVAT 5: </td>"
                    . "<td><input type ='text' value='1' class='lefts' disabled></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td></td>"
                    . "<td>SVAT05(a)<input class='lefts' type ='text' disabled></td>"
                    . "<td>No of Pages of SVAT 5(a):</td>"
                    . "<td><input type ='text'class='lefts' value='0' disabled></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td></td>"
                    . "<td>SVAT05(b) <input class='lefts' type ='text'  value='" . $crn . "'   disabled></td>"
                    . "<td>No of Pages of SVAT 5(b):</td>"
                    . "<td><input type ='text' class='lefts' value = '" . $crn1  . "' disabled></td>"
                    . "</tr>"
                    . "<tr rowspan='6'>"
                    . "<td colspan='2' class='th2' width=375><p>I/We hereby declare that the above good/services were sold <br>
                       by me/us only for the purpose of export and/ or to be used in <br>
                       a specified project and/ or to be used during the project  <br>
                       implementation period of a project approved under section 22(7)<br> 
                       of the VAT Act and/or for indirect export..<br><br>
                       Further, in the event of any failure to comply with the<br>
                       guideline issued by the Commissioner General, I/we<br>
                       am/are aware that I/We ,am/are liable ot VAT  <br>  <br>  <br> <br>
                       Signature of the supplier & Company Seal<br></p>
                       </td>"
                    . "<td colspan=2 class='th2' width=375><p>I/We hereby declare that the above good/services were sold <br>
                       by me/us only for the purpose of export and/ or to be used in <br>
                       a specified project and/ or to be used during the project  <br>
                       implementation period of a project approved under section 22(7)<br> 
                       of the VAT Act and/or for indirect export..<br><br>
                       Further, in the event of any failure to comply with the<br>
                       guideline issued by the Commissioner General, I/we<br>
                       am/are aware that I/We ,am/are liable ot VAT  <br>  <br> <br> <br>
                       Signature of the supplier & Company Seal<br></p></td>"
                    . "</tr>"
                    . "<tr rowspan='6'>"
                    . "<td colspan='2' class='th1' width=375>Date:</p></td>"
                    . "<td colspan='2' class='th1' width=375>Date:</p></td>"
                    . "</table>"
                    . "</td></tr></table>";
            echo $strr;
            echo "</div>";
        }
        ?>



    </body>
</html>
