<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sales Summery</title>
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
                border:1px solid black;
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
        <!-- Progress bar holder -->


        <?php
        require_once("config.inc.php");
        require_once("DBConnector.php");
        $db = new DBConnector();

        //echo "dddddddddd ". $_GET["cmbtype"];
        if ($_GET["cmbdev"] == "All") {
            $GLOBALS[$dev] = "A";
        }
        if ($_GET["cmbdev"] == "Manual") {
            $GLOBALS[$dev] = "1";
        }
        if ($_GET["cmbdev"] == "Computer") {
            $GLOBALS[$dev] = "0";
        }



        prin();

/////////// Sales Summery////////////////////////////////////////
        function prin() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();

            $sql_tmp = "delete from tmpqtysale";
            $result_tmp = $db->RunQuery($sql_tmp);

            //$sql="select * from tmpqtysale";
            //$result =$db->RunQuery($sql);

            $sqlinv = "select * from viewinv  where   SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0'  ";
            if ($_GET["cmbrep"] != "All") {
                $sqlinv .= " and sal_ex='" . $_GET["cmbrep"] . "'";
            }

            if ($_GET["Chk_cus"] == "on") {
                $sqlinv .= " and cus_code='" . trim($_GET["cuscode"]) . "'";
            }

            if ($_GET["cmbbrand"] != "All") {
                $sqlinv .= " and s_brand = '" . trim($_GET["cmbbrand"]) . "'";
            }

            //if ($GLOBALS[$dev] == "A") {
                $sqlinv .=" and Dev != '" . $GLOBALS[$dev] . "'";
            //}

//            if ($_GET["cmb_t"] != "ALL") {
//                $sqlinv .=" and type = '" . $_GET["cmb_t"] . "'";
//            }

            if (!isset($_GET["chk_over"])) {
                $sqlinv .= " and stk_no <> 'SC01' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'L0531' ";
            } else {
                $sqlinv .= " and stk_no <> '06432' and stk_no <> '06433' and stk_no <> 'M6424' and stk_no <> 'M6425' and stk_no <> '06055' and stk_no <> '06426' and stk_no <> '06428' and  stk_no <> '06173' and stk_no <> '06169' and stk_no <> '06160' and stk_no <> '06155' and stk_no <> 'SC01' ";
            }

            
            
            $sqlgrn = "select * from viewcrntrn  where   SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancell='0'  ";
            if ($_GET["cmbrep"] != "All") {
                $sqlgrn .= " and sal_ex='" . $_GET["cmbrep"] . "'";
            }

            if ($_GET["Chk_cus"] == "on") {
                $sqlgrn .= " and c_code='" . trim($_GET["cuscode"]) . "'";
            }

            if ($_GET["cmbbrand"] != "All") {
                $sqlgrn .= " and brand = '" . trim($_GET["cmbbrand"]) . "'";
            }

            //if ($GLOBALS[$dev] == "A") {
                $sqlgrn .=" and Dev != '" . $GLOBALS[$dev] . "'";
            //}

//            if ($_GET["cmb_t"] != "ALL") {
//                $sqlgrn .=" and s_type = '" . $_GET["cmb_t"] . "'";
//            }

            if (!isset($_GET["chk_over"])) {
                $sqlgrn .= " and stk_no <> 'SC01' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'L0531' ";
            } else {
                $sqlgrn .= " and stk_no <> '06432' and stk_no <> '06433' and stk_no <> 'M6424' and stk_no <> 'M6425' and stk_no <> '06055' and stk_no <> '06426' and stk_no <> '06428' and  stk_no <> '06173' and stk_no <> '06169' and stk_no <> '06160' and stk_no <> '06155' and stk_no <> 'SC01' ";
            }


            $result2 = $db->RunQuery($sqlinv);
            $num = mysql_num_rows($result2);

            while ($row2 = mysql_fetch_array($result2)) {


                $sql_tmp = "insert into tmpqtysale (sdate,refno,ccode,cname,INVqty,stkno,description,brand,RETqty,dis,value) values"
                        . "('" . trim($row2["SDATE"]) . "','" . trim($row2["REF_NO"]) . "','" . trim($row2["cus_code"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["QTY"]) . "','" . $row2["STK_NO"] . "','" . $row2["DESCRIPT"] . "','" . $row2["s_brand"] . "','0','" . $row2["DIS_per"] . "' ,'" . $row2["PRICE"] . "'  )";

                $result_tmp = $db->RunQuery($sql_tmp);
            }



            $result3 = $db->RunQuery($sqlgrn);
            while ($row3 = mysql_fetch_array($result3)) {
                $sql_rep = "select name from s_salrep where REPCODE='" . $row3["SAL_EX"] . "'";
                $result_rep = $db->RunQuery($sql_rep); 
                $sql_tmp = "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand,INVqty,dis,value) values"
                        . "('" . trim($row3["SDATE"]) . "','" . trim($row3["REF_NO"]) . "','" . trim($row3["C_CODE"]) . "','" . trim($row3["CUS_NAME"]) . "','" . trim($row3["qty"]) . "','" . $row3["STK_NO"] . "','" . $row3["descript"] . "','" . $row3["Brand"] . "','0','" . $row2["DIS_per"] . "' ,'" . $row2["PRICE"] . "' )";
                $result_tmp = $db->RunQuery($sql_tmp);
            }
             
            
              
             




            $sql_head = "select * from invpara";
            $result_head = $db->RunQuery($sql_head);
            $row_head = mysql_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            $heading = "Qty Sales For " . $_GET["cusname"] . "</br>";
            $heading .="Sales Rep :" . $_GET["cmbrep"] . " Date Range From : " . $_GET["DTfrom"] . "   To : " . $_GET["DTTO"];

            echo "<center>" . $heading . "</center><br>";

            if ($_GET["cmbtype"] == "Detail") {
                print_det();
            } else if ($_GET["chk_over25"] == "on") {
                print_ov25();
            } else if ($_GET["Chk_cus_wise"] == "on") {
                print_cuswise();
            } else {
                print_summ();
            }
        }

        function print_det() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();


            echo "<center><table border=1><tr>
		<th>Stk No</th>
		<th>Description</th><th>Brand</th><th>Invoice Qty</th>
		<th>Return Qty</th>
		<th>Effective Qty</th>
	
		</tr>";
            $sql = "Select stkno,brand,description,sum(INVqty)as totINVqty,sum(RETqty) as totRETqty  from tmpqtysale group by stkno,description,brand order by  brand,stkno";
            
            $result = $db->RunQuery($sql);
            while ($row = mysql_fetch_array($result)) {
                
                
                
                
                
                echo "<tr>
			<td>" . $row["stkno"] . "</td>
			<td>" . $row["description"] . "</td> 
                        <td>" . $row["brand"] . "</td>"
                . "<td align='right'>" . number_format($row["totINVqty"], 0, ",", ".") . "</td>"
                . "<td align='right'>" . number_format($row["totRETqty"], 0, ",", ".") . "</td>
			<td  align='right'>" . number_format($row["totINVqty"] - $row["totRETqty"], 0, ",", ".") . "</td>
			</tr>";
                $totINVqty = $totINVqty + $row["totINVqty"];
                $totRETqty = $totRETqty + $row["totRETqty"];
                $totqty = $row["totINVqty"] - $row["totRETqty"];
                $tot = $tot + $totqty;
            }
            echo "<tr>
			<td colspan=3></td>
			<td align='right'><b>" . $totINVqty . "</b></td>
			<td align='right'><b>" . $totRETqty . "</b></td>
			<td align='right'><b>" . $tot . "</b></td>";
            echo "<table>";
        }

        function print_summ() {
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();


            echo "<center><table border=1><tr>
		<th>Brand</th><th>Invoice Qty</th>
		<th>Return Qty</th>
		<th>Effective Qty</th>
		</tr>";
            $sql = "Select brand,sum(INVqty)as totINVqty,sum(RETqty) as totRETqty  from tmpqtysale group by brand order by brand";
            $result = $db->RunQuery($sql);
            while ($row = mysql_fetch_array($result)) {
                echo "<tr>
			
                        <td width ='450'>" . $row["brand"] . "</td>"
                . "<td align='right'>" . number_format($row["totINVqty"], 0, ",", ".") . "</td>"
                . "<td align='right'>" . number_format($row["totRETqty"], 0, ",", ".") . "</td>
			<td align='right'>" . number_format($row["totINVqty"] - $row["totRETqty"], 0, ",", ".") . "</td>
			</tr>";
                $totINVqty = $totINVqty + $row["totINVqty"];
                $totRETqty = $totRETqty + $row["totRETqty"];
                $totqty = $row["totINVqty"] - $row["totRETqty"];
                $tot = $tot + $totqty;
            }
            echo "<tr>
			<td></td>
			<td align='right'><b>" . $totINVqty . "</b></td>
			<td align='right'><b>" . $totRETqty . "</b></td>
			<td align='right'><b>" . $tot . "</b></td>";
            echo "<table>";
        }

        function print_cuswise() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();


            echo "<center><table border=1><tr>
		<th colspan='2'>Brand</th><th>Invoice Qty</th>
		<th>Return Qty</th>
		<th>Effective Qty</th>
		</tr>";
            $sql = "Select ccode  from tmpqtysale group by ccode order by ccode";
            $resultr = $db->RunQuery($sql);
            while ($row2 = mysql_fetch_array($resultr)) {

                $sql = "Select brand,sum(INVqty)as totINVqty,sum(RETqty) as totRETqty  from tmpqtysale where ccode ='" . $row2['ccode'] . "' group by brand order by brand";
                $result = $db->RunQuery($sql);

                
                $sql_ven = "Select * from vendor where code = '"  .  $row2["ccode"] .  "'";
                $result_ven = $db->RunQuery($sql_ven);
                $row_ven = mysql_fetch_array($result_ven);
                
                echo "<tr><td>" . $row2["ccode"] . "</td>     
			<td colspan='4'>" . $row_ven["NAME"] . "</td>  </tr>";

                while ($row = mysql_fetch_array($result)) {
                    echo "<tr>
			
                        <td align='right' width = '450' colspan='2'>" . $row["brand"] . "</td>"
                    . "<td align='right'>" . number_format($row["totINVqty"], 0, ",", ".") . "</td>"
                    . "<td align='right'>" . number_format($row["totRETqty"], 0, ",", ".") . "</td>
			<td>" . number_format($row["totINVqty"] - $row["totRETqty"], 0, ",", ".") . "</td>
			</tr>";
                    $totINVqty = $totINVqty + $row["totINVqty"];
                    $totRETqty = $totRETqty + $row["totRETqty"];
                    $totqty = $row["totINVqty"] - $row["totRETqty"];
                    $tot = $tot + $totqty;
                }
            }
            echo "<tr>
			<td></td><td></td>
			<td align='right'><b>" . $totINVqty . "</b></td>
			<td align='right'><b>" . $totRETqty . "</b></td>
			<td align='right'><b>" . $tot . "</b></td>";
            echo "<table>";
        }

        function print_ov25() {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();


            echo "<center><table border=1><tr>
		<th colspan='2'>Brand</th><th>Invoice Qty</th>
		<th>Return Qty</th>
		<th>Effective Qty</th>  <td>40%</td><td>43%</td> <td>CRN</td> 
		</tr>";
            $sql = "Select ccode  from tmpqtysale group by ccode order by ccode";
            $resultr = $db->RunQuery($sql);
            while ($row2 = mysql_fetch_array($resultr)) {

                $sql = "Select brand,sum(INVqty)as totINVqty,sum(RETqty) as totRETqty  from tmpqtysale where ccode ='" . $row2['ccode'] . "' group by brand order by brand";
                $result = $db->RunQuery($sql);


                while ($row = mysql_fetch_array($result)) {
                    
                    $sql = "select* from tmpqtysale where brand = '" .$row["brand"]  . "' and ccode ='" . $row2['ccode'] . "' ";
                    
                    $t40=0;
                    $t43=0;
                    $crn=0;
                    $crn_t=0;
                    $totq=0;
                    if ($row2['ccode']  == "P105") {
                        $a = $a;
                    }
                    
                    $result_tot = $db->RunQuery($sql);
                    while ($row_tot= mysql_fetch_array($result_tot)) {
                        if ($row_tot['INVqty'] >0) {
                        if ($row_tot['dis']== 40) {
                            $t40 =$t40+ $row_tot["INVqty"];
                        }
                        if ($row_tot['dis']!= 40) {
                            $t43 =$t43+ $row_tot["INVqty"];
                        }
                        
                        if  (($row_tot['dis']) <37.5 and  $row_tot['dis'] >0  ) {
                            $crn = $crn +  (($row_tot['value'])*((37.5-$row_tot['dis'])/100))*$row_tot['INVqty'];
                        } 
                        $totq = $totq + $row_tot['INVqty']; 
                    }}
                    //if {@Eff qty} >= 20 and {@Eff qty} < 50  then Sum ({@CRN}, {ado.Brand}) 
                    
                    if ($totq >=20 and $totq < 50) {
                        $crn_t = $crn_t+ $crn;
                        $ocrn = $ocrn+  $crn_t;
                    }
                    
                    
                    if ($crn_t >0 ) {

                      
                $sql_ven = "Select * from vendor where code = '"  .  $row2["ccode"] .  "'";
                $result_ven = $db->RunQuery($sql_ven);
                $row_ven = mysql_fetch_array($result_ven);
                
                echo "<tr><td>" . $row2["ccode"] . "</td>     
			<td colspan='7'>" . $row_ven["NAME"] . "</td> </tr>";                  
                                        
                                        
                                        
                        echo "<tr>
			
                        <td align='right' width = '350' colspan='2'>" . $row["brand"] . "</td>"
                    . "<td align='right'>" . number_format($row["totINVqty"], 0, ",", ".") . "</td>"
                    . "<td align='right'>" . number_format($row["totRETqty"], 0, ",", ".") . "</td>
			<td>" . number_format($row["totINVqty"] - $row["totRETqty"], 0, ",", ".") . "</td><td>" . $t40 . "</td>    
		     <td>" . $t43 . "</td>    "
                            . "<td>" . $crn_t . "</td>    "
                            
                            . "	</tr>";
                    $totINVqty = $totINVqty + $row["totINVqty"];
                    $totRETqty = $totRETqty + $row["totRETqty"];
                    $totqty = $row["totINVqty"] - $row["totRETqty"];
                    $tot = $tot + $totqty;
                }
                }
                
            }
            echo "<tr>
			<td></td><td></td>
			<td align='right'><b>" . $totINVqty . "</b></td>
			<td align='right'><b>" . $totRETqty . "</b></td>
			<td align='right'><b>" . $tot . "</b></td><td></td><td></td> <td>". $ocrn  . "</td> ";
            echo "<table>";
        }
        ?>



    </body>
</html>
