<?php
include './connection_sql.php';
if ($_GET['rtype'] == "detail") {
    ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>VAT Shedule Report</title>
            <link rel="stylesheet" href="css/bootstrap.min.css">
                <style>
                    body {
                        font-size:12px;
                    }
                    .red {
                        background-color:#FCCF50;
                    }
                </style>

        </head>

        <body>
            <center>
                <?php
                if ($_GET['shtype'] == "sh1") {
                    include './connection_sql.php';

                    $sql = "select * from invpara";
                    $result_g = $conn->query($sql);
                    $row_g = $result_g->fetch();
                    echo "<h3>" . $row_g["COMPANY"] . "</h3>";
                    echo "<h5>VAT Shedule Report From " . $_GET["dtfrom"] . " To " . $_GET["dtto"] . "</h5>";
                    ?>

                    <table class="table table-bordered">
                        <tr>
                            <th  style="width: 50px;">D Code</b></th>
                            <th  style="width: 50px;">Serial No</b></th>
                            <th  style="width: 80px;">Invoice Date</b></th>
                            <th  style="width: 110px;">Tax Invoice No</b></th>
                            <th  style="width: 110px;">Purchaser's TIN</th>
                            <th  style="width: 179px;">Name of the Purchaser</th>
                            <th  style="width: 122px;">Description</th>
                            <th  style="width: 50px;">Value of supply</th>
                            <th  style="width: 50px;">VAT Amount</th>
                        </tr>

                        <?php
                        $mtot = 0;
                        $mtot1 = 0;
                        $i = 1;
                        //and vat ='1' and vat_no <> ''
                        $sql = "select * from s_salma where sdate >='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "'  and cancell='0' and svat =0   order by id";
                        foreach ($conn->query($sql) as $row) {
                            echo "<tr>";
                            echo "<td>" . $row['C_CODE'] . "</td>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . date("m/d/Y", strtotime($row['SDATE'])) . "</td>";
                            echo "<td>" . $row['REF_NO'] . "</td>";

                            $mvatno = substr(trim($row['vat_no']), 0, 9);
                            $sql = "select * from vendor where code ='" . $row['C_CODE'] . "'";
                            $result_g = $conn->query($sql);
                            $row_g = $result_g->fetch();
                            if (strlen($row['vat_no'] < 3)) {
                                if ($row_g['vatgroup'] <> "") {
                                    $sql = "select * from vatgroup where code ='" . $row_g['vatgroup'] . "'";
                                    $result_v = $conn->query($sql);
                                    if ($row_v = $result_v->fetch()) {
                                        $mvatno = $row_v['vatno'];
                                    }
                                } else {
                                    $sql = "select * from vatgroup where code ='PRIVATE'";
                                    $result_v = $conn->query($sql);
                                    if ($row_v = $result_v->fetch()) {
                                        $mvatno = $row_v['vatno'];
                                    }
                                }
                            }



                            echo "<td>" . $mvatno . "</td>";

                            echo "<td>" . $row['CUS_NAME'] . "</td>";
                            echo "<td>Sales Of Automative Tyres</td>";

                            $net = $row["GRAND_TOT"] / (1 + ($row["GST"] / 100));

                            $vat = $net * $row["GST"] / 100;

                            echo "<td align=\"right\">" . number_format($net, 2, ".", "") . "</td>";
                            echo "<td align=\"right\">" . number_format($vat, 2, ".", "") . "</td>";

                            $mtot = $mtot + $net;
                            $mtot1 = $mtot1 + $vat;

                            $i = $i + 1;
                            echo "<tr>";
                        }
                        echo "<tr>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";

                        echo "<td></td>";

                        echo "<td></td>";
                        echo "<td></td>";


                        echo "<td align=\"right\"><b>" . number_format($mtot, 2, ".", "") . "</b></td>";
                        echo "<td align=\"right\"><b>" . number_format($mtot1, 2, ".", "") . "</b></td>";
                        echo "</tr>";
                        ?>



                </center>


                <?php
            }



            if ($_GET['shtype'] == "sh44") {
                include './connection_sql.php';


                echo "<h3>" . $row_g["COMPANY"] . "</h3>";
                echo "<h5>VAT Shedule Report From " . $_GET["dtfrom"] . " To " . $_GET["dtto"] . "</h5>";
                ?>

                <table class="table table-bordered">
                    <tr>
                        <th colspan='2'>Dealer</th>
                        <th  style="width: 50px;">Serial No</b></th>
                        <th  style="width: 110px;">TIN No</th>
                        <th  style="width: 80px;">Invoice Date</b></th>
                        <th  style="width: 110px;">Invoice No</b></th>

                        <th  style="width: 179px;">Tax Credit / Tax Debit Note</th>
                        <th  style="width: 179px;">Date of Tax Credit / Tax Debit Note</th>
                        <th  style="width: 179px;">Tax Credit No. / Tax Debit Note No.</th>						
                        <th  style="width: 179px;">Value of Tax Credit Note / Tax Debit Note</th>						
                        <th  style="width: 50px;">VAT Amount</th>
                        <th  style="width: 50px;">%</th>
                        <th colspan='3'></th>
                    </tr>

                    <?php
                    $mtot = 0;
                    $mtot1 = 0;
                    $i = 1;
                    $sql = "select * from view_c_bal_vendor_new where  sdate >='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and (trn_type <> 'REC' and trn_type <> 'ARN')and cancell='0' order by id";

                    foreach ($conn->query($sql) as $row) {
                        $date_from = strtotime($row["SDATE"] . ' -180 days');
                        $date_from = date('Y-m-d', $date_from);
                        $mok = "0";

                        $invno = "";
                        $invdt = "";
                        $vatrate = $row["vatrate"];
                        $vatno = $row['vatno'];

                        $cus_name = $row['NAME'];
                        $svat = 0;

                        $sql = "select * from view_cbal_salma where ret_no = '" . $row['REFNO'] . "'";

                        $result_g = $conn->query($sql);
                        if ($row_g1 = $result_g->fetch()) {
                            $invdt = $row_g1['SDATE'];
                            //$cus_name = $row_g1['CUS_NAME'];
                            $invno = $row_g1['REF_NO'];
                            $mok = "1";
                            $svat = 0;
                        } else {
                            if ($row['trn_type'] == "CNT") {

                                $sql = "select * from cred where c_refno = '" . $row['REFNO'] . "'";
                                $result_g = $conn->query($sql);
                                $row_g1 = $result_g->fetch();


                                $date = strtotime($row_g['SDATE'] . ' -180 days');
                                $date = date('Y-m-d', $date);

                                $sql = "select * from s_salma where  c_code ='" . $row['CUSCODE'] . "' and gst = '" . $vatrate . "' and sdate >='" . $date_from . "' and sdate <='" . $row['SDATE'] . "' and grand_tot >='" . $row['AMOUNT'] . "' and cancell='0'";
                                if (is_null($row_g1['C_SETINV'])) {
                                    $sql .= " and ref_no = '" . $row_g1['C_INVNO'] . "'";
                                }
                                $sql .= " order by grand_tot desc limit 1";

                                $result_g = $conn->query($sql);
                                if ($row_g = $result_g->fetch()) {
                                    $invdt = $row_g['SDATE'];
                                    $vatrate = $row_g["GST"];
                                    $vatno = $row_g['vat_no'];
                                    $cus_name = $row_g['CUS_NAME'];
                                    $svat = $row_g['SVAT'];
                                    $invno = $row_g['REF_NO'];
                                }
                            }

                            if ($row['trn_type'] == "GRN") {

                                $sql = "select * from s_crnma where REF_NO = '" . $row['REFNO'] . "'";
                                $result_g = $conn->query($sql);
                                $row_g = $result_g->fetch();


                                $date = strtotime($row_g['SDATE'] . ' -180 days');
                                $date = date('Y-m-d', $date);

                                $sql = "select * from s_salma where ref_no ='" . $row_g['INVOICENO'] . "' and gst = '" . $vatrate . "' and sdate >='" . $date_from . "' and sdate <='" . $row['SDATE'] . "'  and cancell='0'  limit 1";
                                if ($row['REFNO'] == "BGRN/005114") {
                                    //	echo $sql;
                                }

                                $result_g = $conn->query($sql);
                                if ($row_g = $result_g->fetch()) {
                                    $invdt = $row_g['SDATE'];
                                    $vatrate = $row_g["GST"];
                                    $vatno = $row_g['vat_no'];
                                    $cus_name = $row_g['CUS_NAME'];
                                    $svat = $row_g['SVAT'];
                                    $invno = $row_g['REF_NO'];
                                }
                            }

                            if ($row['trn_type'] == "DGRN") {


                                $sql = "select * from s_salma where ref_no ='" . $row['Costcenter'] . "' and c_code = '" . $row['CUSCODE'] . "' and grand_tot >='" . $row['AMOUNT'] . "' and sdate >='" . $date_from . "' and sdate <='" . $row['SDATE'] . "' and cancell='0'  order by id limit 1";

                                $result_g1 = $conn->query($sql);
                                if ($row_g1 = $result_g1->fetch()) {
                                    $invdt = $row_g1['SDATE'];
                                    $invno = $row_g1['REF_NO'];
                                    $vatrate = $row_g1["GST"];
                                    $vatno = $row_g1['vat_no'];
                                    $cus_name = $row_g1['CUS_NAME'];
                                }
                            }
                        }



                        if ($invno != "") {

                            $rtn_amo = 0;
                            $sql = "select sum(ret_amo) as amo from view_cbal_salma where ref_no = '" . $invno . "' and ret_no <> '" . $row['REFNO'] . "'";

                            $result_g = $conn->query($sql);
                            if ($row_g1 = $result_g->fetch()) {
                                if (!is_null($row_g1['amo'])) {
                                    $rtn_amo = $row_g1['amo'];
                                }
                            }
                            $gtot = $row['AMOUNT'] + $rtn_amo;



                            $inv_tot = 0;
                            $sql = "select * from s_salma where ref_no ='" . $invno . "' and cancell='0'  order by id limit 1";
                            $result_g1 = $conn->query($sql);
                            if ($row_g1 = $result_g1->fetch()) {
                                $inv_tot = $row_g1['GRAND_TOT'];
                            }


                            if ($inv_tot - $gtot < 0) {



                                $sql_l = "select * from s_salma where ref_no <> '" . $invno . "' and c_code = '" . $row['CUSCODE'] . "' and grand_tot >='" . $row['AMOUNT'] . "' and sdate >='" . $date_from . "' and sdate <='" . $row['SDATE'] . "'  and cancell='0'  order by sdate";
                                $invno = "";
                                $invdt = "";
                                foreach ($conn->query($sql_l) as $row_g1) {

                                    $inv_tot = $row_g1['GRAND_TOT'];
                                    $rtn_amo = 0;
                                    $sql = "select sum(ret_amo) as amo from view_cbal_salma where  ref_no = '" . $row_g1['REF_NO'] . "'";


                                    $result_g2 = $conn->query($sql);
                                    if ($row_g2 = $result_g2->fetch()) {
                                        if (!is_null($row_g2['amo'])) {
                                            $rtn_amo = $row_g2['amo'];
                                        }
                                    }
                                    $gtot = $row['AMOUNT'] + $rtn_amo;

                                    if ($inv_tot - $gtot > 0) {
                                        $invdt = $row_g1['SDATE'];
                                        $invno = $row_g1['REF_NO'];
                                        $vatrate = $row_g1["GST"];
                                        $vatno = $row_g1['vat_no'];
                                        $cus_name = $row_g1['CUS_NAME'];


                                        if ($mok == "0") {


                                            $sql_ins = "insert into c_bal_s_salma (ret_no,ret_amo,inv_no,sdate) values ('" . $row['REFNO'] . "','" . $row['AMOUNT'] . "','" . $invno . "','" . $row['SDATE'] . "') ";
                                            $result_g = $conn->query($sql_ins);
                                            break;
                                        }
                                    }
                                }
                            } else {

                                if ($mok == "0") {
                                    $sql_ins = "insert into c_bal_s_salma (ret_no,ret_amo,inv_no,sdate) values ('" . $row['REFNO'] . "','" . $row['AMOUNT'] . "','" . $invno . "','" . $row['SDATE'] . "') ";
                                    $result_g = $conn->query($sql_ins);
                                }
                            }
                        }



                        if ($invno == "") {



                            $gtot = $row['AMOUNT'];





                            $sql_l = "select * from s_salma where ref_no <> '" . $invno . "' and c_code = '" . $row['CUSCODE'] . "' and grand_tot >='" . $row['AMOUNT'] . "' and sdate >='" . $date_from . "'  and cancell='0'  order by sdate";

                            foreach ($conn->query($sql_l) as $row_g1) {
                                $inv_tot = $row_g1['GRAND_TOT'];
                                $rtn_amo = 0;
                                $sql = "select sum(ret_amo) as amo from view_cbal_salma where  ref_no = '" . $row_g1['REF_NO'] . "'";
                                $result_g2 = $conn->query($sql);
                                if ($row_g2 = $result_g2->fetch()) {
                                    $rtn_amo = $row_g2['amo'];
                                }
                                if ($inv_tot - ($gtot + $rtn_amo) > 0) {
                                    $invdt = $row_g1['SDATE'];
                                    $invno = $row_g1['REF_NO'];
                                    $vatrate = $row_g1["GST"];
                                    $vatno = $row_g1['vat_no'];
                                    $cus_name = $row_g1['CUS_NAME'];


                                    if ($mok == "0") {
                                        $sql_ins = "insert into c_bal_s_salma (ret_no,ret_amo,inv_no,sdate) values ('" . $row['REFNO'] . "','" . $row['AMOUNT'] . "','" . $invno . "','" . $row['SDATE'] . "') ";
                                        $result_g = $conn->query($sql_ins);
                                        break;
                                    }
                                }
                            }
                        }


                        $sql = "select * from vendor where code ='" . $row['CUSCODE'] . "'";
                        $result_g = $conn->query($sql);
                        $row_g = $result_g->fetch();
                        if (strlen($vatno < 3)) {
                            if ($row_g['vatgroup'] <> "") {
                                $sql = "select * from vatgroup where code ='" . $row_g['vatgroup'] . "'";
                                $result_v = $conn->query($sql);
                                if ($row_v = $result_v->fetch()) {
                                    $vatno = $row_v['vatno'];
                                }
                            } else {
                                $sql = "select * from vatgroup where code ='PRIVATE'";
                                $result_v = $conn->query($sql);
                                if ($row_v = $result_v->fetch()) {
                                    $vatno = $row_v['vatno'];
                                }
                            }
                        }
                        if ($svat == 0) {
                            $userdata[] = "('" . $vatno . "','" . $invdt . "','" . $invno . "','" . $row['SDATE'] . "','" . $row['REFNO'] . "','" . $row["AMOUNT"] . "','" . $vatrate . "','" . $row['CUSCODE'] . "','" . $cus_name . "','" . $grand_tot . "')";
                        }
                    }

                    $sql = "delete from tmp_vat";
                    $result_g = $conn->query($sql);


                    $sql = "insert into tmp_vat (vatno,invdt,invno,SDATE,REFNO,AMOUNT,vatrate,c_code,cus_name,grand_tot) values " . implode(",", $userdata);

                    $result_g = $conn->query($sql);







                    $sql = "select * from tmp_vat order by c_code, invno";

                    foreach ($conn->query($sql) as $row) {

                        echo "<tr>";

                        echo "<td>" . $row['c_code'] . "</td>";
                        echo "<td>" . $row['cus_name'] . "</td>";


                        echo "<td>" . $i . "</td>";
                        echo "<td>" . substr(trim($row['vatno']), 0, 9) . "</td>";

                        if ($row['invdt'] == "") {
                            echo "<td></td>";
                        } else {
                            echo "<td>" . date("m/d/Y", strtotime($row['invdt'])) . "</td>";
                        }
                        echo "<td>" . $row['invno'] . "</td>";


                        echo "<td>Credit</td>";
                        echo "<td>" . date("m/d/Y", strtotime($row['SDATE'])) . "</td>";
                        echo "<td>" . $row['REFNO'] . "</td>";


                        $net = number_format(($row["AMOUNT"] / (1 + ($row['vatrate'] / 100))), 2, ".", "");

                        $vat = $net * $row['vatrate'] / 100;

                        echo "<td align=\"right\">" . number_format($net, 2, ".", "") . "</td>";
                        echo "<td align=\"right\">" . number_format($vat, 2, ".", "") . "</td>";
                        echo "<td align=\"right\">" . number_format($row['vatrate'], 0, ".", "") . "</td>";

                        $amo = 0;

                        $sql = "select sum(ret_amo) as amo from view_cbal_salma where  ref_no = '" . $row['invno'] . "'";
                        $result_g2 = $conn->query($sql);
                        if ($row_g2 = $result_g2->fetch()) {
                            echo "<td align=\"right\">" . number_format($row_g2['amo'], 2, ".", "") . "</td>";
                            $amo = $row_g2['amo'];
                        } else {
                            echo "<td align=\"right\">0</td>";
                        }
                        $gtot = 0;

                        $sql = "select grand_tot from s_Salma where ref_no= '" . $row['invno'] . "'";
                        $result_g2 = $conn->query($sql);
                        if ($row_g2 = $result_g2->fetch()) {
                            echo "<td align=\"right\">" . number_format($row_g2['grand_tot'], 2, ".", "") . "</td>";
                            $gtot = $row_g2['grand_tot'];
                        } else {
                            echo "<td align=\"right\">0</td>";
                        }

                        echo "<td align=\"right\">" . number_format(($gtot - $amo), 2, ".", "") . "</td>";
                        $mtot = $mtot + $net;
                        $mtot1 = $mtot1 + $vat;


                        $i = $i + 1;
                        echo "<tr>";
                    }

                    echo "<tr>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";


                    echo "<td align=\"right\"><b>" . number_format($mtot, 2, ".", "") . "</b></td>";
                    echo "<td align=\"right\"><b>" . number_format($mtot1, 2, ".", "") . "</b></td>";
                    echo "</tr>";
                }


                if ($_GET['shtype'] == "sh4") {
                    include './connection_sql.php';


                    echo "<h3>" . $row_g["COMPANY"] . "</h3>";
                    echo "<h5>VAT Shedule Report From " . $_GET["dtfrom"] . " To " . $_GET["dtto"] . "</h5>";
                    ?>






                    <table class="table table-bordered">
                        <tr>
                            <th colspan='2'>Dealer</th>
                            <th  style="width: 50px;">Serial No</b></th>
                            <th  style="width: 110px;">TIN No</th>
                            <th  style="width: 80px;">Invoice Date</b></th>
                            <th  style="width: 110px;">Invoice No</b></th>

                            <th  style="width: 179px;">Tax Credit / Tax Debit Note</th>
                            <th  style="width: 179px;">Date of Tax Credit / Tax Debit Note</th>
                            <th  style="width: 179px;">Tax Credit No. / Tax Debit Note No.</th>						
                            <th  style="width: 179px;">Value of Tax Credit Note / Tax Debit Note</th>						
                            <th  style="width: 50px;">VAT Amount</th>
                            <th  style="width: 50px;">%</th>
                            <th  style="width: 50px;">Total Return On Inv.</th>
                            <th  style="width: 50px;">Inv. Val.</th>
                            <th  style="width: 50px;">Diff. Val.</th>
                        </tr>

                        <?php
                        $mtot = 0;
                        $mtot1 = 0;
                        $i = 1;
                        $sql = "select * from view_c_bal_vendor_new where  sdate >='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "' and (trn_type <> 'REC' and trn_type <> 'ARN')and cancell='0' order by id";


                        foreach ($conn->query($sql) as $row) {
                            $date_from = strtotime($row["SDATE"] . ' -180 days');
                            $date_from = date('Y-m-d', $date_from);

                            $invno = "";
                            $invdt = "";
                            $vatrate = $row["vatrate"];
                            $vatno = $row['vatno'];

                            $cus_name = $row['NAME'];
                            $svat = 0;
                            if ($row['trn_type'] == "CNT") {

                                $sql = "select * from cred where c_refno = '" . $row['REFNO'] . "'";
                                $result_g = $conn->query($sql);
                                $row_g1 = $result_g->fetch();
                                $invno = $row_g1['C_INVNO'];

                                $date = strtotime($row['SDATE'] . ' -3 months');
                                $date = date('Y-m-d', $date);

                                $sql = "select * from s_salma where  c_code ='" . $row['CUSCODE'] . "' and gst = '" . $vatrate . "' and sdate >='" . $date_from . "' and sdate <='" . $row['SDATE'] . "' and grand_tot >='" . $row['AMOUNT'] . "' and cancell='0'";
                                if (is_null($row_g1['C_SETINV'])) {
                                    $sql .= " and ref_no = '" . $invno . "'";
//                                    echo $sql;
                                }
                                $sql .= " order by grand_tot desc";
                                if ($row['REFNO'] == "BCRN/016931") {
                                    //echo $sql;
                                }
                                $result_g = $conn->query($sql);
                                if ($row_g = $result_g->fetch()) {
                                    $invdt = $row_g['SDATE'];
                                    $vatrate = $row_g["GST"];
                                    $vatno = $row_g['vat_no'];
                                    $cus_name = $row_g['CUS_NAME'];
                                    $svat = $row_g['SVAT'];
                                    $invno = $row_g['REF_NO'];
                                } else {
                                    $sql = "select * from s_salma where c_code ='" . $row['CUSCODE'] . "' and gst = '" . $vatrate . "' and sdate >='" . $date_from . "' and sdate <='" . $row['SDATE'] . "'  and grand_tot >='" . $row['AMOUNT'] . "' and cancell='0'";

                                    $sql .= " order by grand_tot desc";

                                    $result_g = $conn->query($sql);
                                    if ($row_g = $result_g->fetch()) {
                                        $invdt = $row_g['SDATE'];
                                        $vatrate = $row_g["GST"];
                                        $vatno = $row_g['vat_no'];
                                        $cus_name = $row_g['CUS_NAME'];
                                        $invno = $row_g['REF_NO'];
                                    }
                                }
                            }

                            if ($row['trn_type'] == "GRN") {

                                $sql = "select * from s_crnma where REF_NO = '" . $row['REFNO'] . "'";
                                $result_g = $conn->query($sql);
                                $row_g = $result_g->fetch();

                                $invno = $row_g['INVOICENO'];

                                $date = strtotime($row['SDATE'] . ' -3 months');
                                $date = date('Y-m-d', $date);

                                $sql = "select * from s_salma where ref_no ='" . $invno . "' and gst = '" . $vatrate . "' and sdate >='" . $date_from . "' and sdate <='" . $row['SDATE'] . "'  and cancell='0'";
                                if ($row['REFNO'] == "BGRN/005114") {
                                    //	echo $sql;
                                }

                                $result_g = $conn->query($sql);
                                if ($row_g = $result_g->fetch()) {
                                    $invdt = $row_g['SDATE'];
                                    $vatrate = $row_g["GST"];
                                    $vatno = $row_g['vat_no'];
                                    $cus_name = $row_g['CUS_NAME'];
                                    $svat = $row_g['SVAT'];
                                    $invno = $row_g['REF_NO'];
                                } else {
                                    $sql = "select * from s_salma where c_code ='" . $row['CUSCODE'] . "' and gst = '" . $vatrate . "' and sdate >='" . $date_from . "' and sdate <='" . $row['SDATE'] . "' and cancell='0'";
                                    $result_g = $conn->query($sql);
                                    if ($row_g = $result_g->fetch()) {
                                        $invdt = $row_g['SDATE'];
                                        $vatrate = $row_g["GST"];
                                        $vatno = $row_g['vat_no'];
                                        $cus_name = $row_g['CUS_NAME'];
                                        $invno = $row_g['REF_NO'];
                                    }
                                }
                            }

                            if ($row['trn_type'] == "DGRN") {

                                if (($row['Costcenter'] == "") or ( is_null($row['Costcenter']))) {
                                    $sql = "select * from viewdef where REFNO = '" . $row['REFNO'] . "'";
                                    $result_g = $conn->query($sql);
                                    $row_g = $result_g->fetch();
                                    $date = strtotime($row_g['SDATE'] . ' -180 days');
                                    $date = date('Y-m-d', $date);
                                    $sql = "select * from view_salma_invo_smas where gst ='" . $vatrate . "' and brand = '" . $row_g['BRAND_NAME'] . "' and sdate <='" . $row['SDATE'] . "' and c_code = '" . $row_g['c_code'] . "' and sdate <='" . $row_g['SDATE'] . "' and sdate >='" . $date_from . "' and grand_tot >='" . $row['AMOUNT'] . "'  and cancell='0' order by id ";
                                    $result_g1 = $conn->query($sql);
                                    if ($row_g1 = $result_g1->fetch()) {
                                        $invdt = $row_g1['SDATE'];
                                        $invno = $row_g1['REF_NO'];
                                        $vatrate = $row_g1["GST"];
                                        $vatno = $row_g1['vat_no'];
                                        $cus_name = $row_g1['CUS_NAME'];
                                        $sql = "update c_bal set costcenter = '" . $row_g1['REF_NO'] . "' where refno = '" . $row['REFNO'] . "'";
                                        $result_g2 = $conn->query($sql);
                                    } else {
                                        $sql = "select * from view_salma_invo_smas where gst ='" . $vatrate . "' and c_code = '" . $row_g['c_code'] . "' and sdate <='" . $row['SDATE'] . "' and sdate <='" . $row_g['SDATE'] . "' and sdate >='" . $date_from . "' and grand_tot >='" . $row['AMOUNT'] . "'  and cancell='0' order by id";
                                        $result_g1 = $conn->query($sql);
                                        if ($row_g1 = $result_g1->fetch()) {
                                            $invdt = $row_g1['SDATE'];
                                            $invno = $row_g1['REF_NO'];
                                            $vatrate = $row_g1["GST"];
                                            $vatno = $row_g1['vat_no'];
                                            $cus_name = $row_g1['CUS_NAME'];
                                        } else {
                                            $sql = "select * from view_salma_invo_smas where gst ='" . $vatrate . "' and brand = '" . $row_g['BRAND_NAME'] . "' and sdate <='" . $row['SDATE'] . "' and c_code = '" . $row_g['c_code'] . "' and sdate <='" . $row_g['SDATE'] . "' and sdate >='" . $date_from . "' and grand_tot >='" . $row['AMOUNT'] . "'  and cancell='0'   order by id ";
                                            $result_g1 = $conn->query($sql);
                                            if ($row_g1 = $result_g1->fetch()) {
                                                $invdt = $row_g1['SDATE'];
                                                $invno = $row_g1['REF_NO'];
                                                $vatrate = $row_g1["GST"];
                                                $vatno = $row_g1['vat_no'];
                                                $cus_name = $row_g1['CUS_NAME'];
                                                $sql = "update c_bal set costcenter = '" . $row_g1['REF_NO'] . "' where refno = '" . $row['REFNO'] . "'";
                                                $result_g2 = $conn->query($sql);
                                            }
                                        }
                                    }
                                } else {
                                    $sql = "select * from s_salma where ref_no ='" . $row['Costcenter'] . "' and c_code = '" . $row['CUSCODE'] . "' and grand_tot >='" . $row['AMOUNT'] . "' and sdate >='" . $date_from . "'  and cancell='0'  order by id limit 1";
                                    $result_g1 = $conn->query($sql);
                                    if ($row_g1 = $result_g1->fetch()) {
                                        $invdt = $row_g1['SDATE'];
                                        $invno = $row_g1['REF_NO'];
                                        $vatrate = $row_g1["GST"];
                                        $vatno = $row_g1['vat_no'];
                                        $cus_name = $row_g1['CUS_NAME'];
                                    } else {

                                        $sql = "select * from s_salma where gst ='" . $vatrate . "' and c_code = '" . $row['CUSCODE'] . "' and grand_tot >='" . $row['AMOUNT'] . "' and sdate >='" . $date_from . "'   and cancell='0' order by id limit 1";
                                        $result_g1 = $conn->query($sql);
                                        if ($row_g1 = $result_g1->fetch()) {
                                            $invdt = $row_g1['SDATE'];
                                            $invno = $row_g1['REF_NO'];
                                            $vatrate = $row_g1["GST"];
                                            $vatno = $row_g1['vat_no'];
                                            $cus_name = $row_g1['CUS_NAME'];
                                        }
                                    }
                                }
                            }


                            $sql = "select * from vendor where code ='" . $row['C_CODE'] . "'";
                            $result_g = $conn->query($sql);
                            $row_g = $result_g->fetch();
                            if (strlen($vatno < 3)) {
                                if ($row_g['vatgroup'] <> "") {
                                    $sql = "select * from vatgroup where code ='" . $row_g['vatgroup'] . "'";
                                    $result_v = $conn->query($sql);
                                    if ($row_v = $result_v->fetch()) {
                                        $vatno = $row_v['vatno'];
                                    }
                                } else {
                                    $sql = "select * from vatgroup where code ='PRIVATE'";
                                    $result_v = $conn->query($sql);
                                    if ($row_v = $result_v->fetch()) {
                                        $vatno = $row_v['vatno'];
                                    }
                                }
                            }
                            if ($svat == 0) {
                                $userdata[] = "('" . $vatno . "','" . $invdt . "','" . $invno . "','" . $row['SDATE'] . "','" . $row['REFNO'] . "','" . $row["AMOUNT"] . "','" . $vatrate . "','" . $row['CUSCODE'] . "','" . $cus_name . "')";
                            }
                        }
                        $sql = "delete from tmp_vat";
                        $result_g = $conn->query($sql);


                        $sql = "insert into tmp_vat (vatno,invdt,invno,SDATE,REFNO,AMOUNT,vatrate,c_code,cus_name) values " . implode(",", $userdata);
                        $result_g = $conn->query($sql);

                        $sql = "select * from tmp_vat";

                        foreach ($conn->query($sql) as $row) {

                            echo "<tr>";

                            echo "<td>" . $row['c_code'] . "</td>";
                            echo "<td>" . $row['cus_name'] . "</td>";


                            echo "<td>" . $i . "</td>";
                            echo "<td>" . substr(trim($row['vatno']), 0, 9) . "</td>";

                            if ($row['invdt'] == "") {
                                echo "<td></td>";
                            } else {
                                echo "<td>" . date("m/d/Y", strtotime($row['invdt'])) . "</td>";
                            }
                            echo "<td>" . $row['invno'] . "</td>";


                            echo "<td>Credit</td>";
                            echo "<td>" . date("m/d/Y", strtotime($row['SDATE'])) . "</td>";
                            echo "<td>" . $row['REFNO'] . "</td>";


                            $net = number_format(($row["AMOUNT"] / (1 + ($row['vatrate'] / 100))), 2, ".", "");

                            $vat = $net * $row['vatrate'] / 100;

                            echo "<td align=\"right\">" . number_format($net, 2, ".", "") . "</td>";
                            echo "<td align=\"right\">" . number_format($vat, 2, ".", "") . "</td>";
                            echo "<td align=\"right\">" . number_format($row['vatrate'], 0, ".", "") . "</td>";

                            $amo = 0;
                            $minfv = str_replace("*", "", $row['invno']);
                            $sql = "select sum(AMOUNT) as AMO from tmp_vat where invno= '" . $minfv . "' and invno <>'' ";
                            $result_g2 = $conn->query($sql);
                            if ($row_g2 = $result_g2->fetch()) {
                                echo "<td align=\"right\">" . number_format($row_g2['AMO'], 2, ".", "") . "</td>";
                                $amo = $row_g2['AMO'];
                            } else {
                                echo "<td align=\"right\">0</td>";
                            }
                            $gtot = 0;

                            $sql = "select grand_tot from s_Salma where ref_no= '" . $minfv . "'";
                            $result_g2 = $conn->query($sql);
                            if ($row_g2 = $result_g2->fetch()) {
                                echo "<td align=\"right\">" . number_format($row_g2['grand_tot'], 2, ".", "") . "</td>";
                                $gtot = $row_g2['grand_tot'];
                            } else {
                                echo "<td align=\"right\">0</td>";
                            }

                            echo "<td align=\"right\">" . number_format(($gtot - $amo), 2, ".", "") . "</td>";
                            $mtot = $mtot + $net;
                            $mtot1 = $mtot1 + $vat;

                            $i = $i + 1;
                            echo "<tr>";
                        }

                        echo "<tr>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";


                        echo "<td align=\"right\"><b>" . number_format($mtot, 2, ".", "") . "</b></td>";
                        echo "<td align=\"right\"><b>" . number_format($mtot1, 2, ".", "") . "</b></td>";
                        echo "</tr>";
                    }
                }

                if ($_GET['rtype'] == "summ") {
                    if ($_GET['shtype'] == "sh1") {
                        // output headers so that the file is downloaded rather than displayed
                        header('Content-Type: text/csv; charset=utf-8');
                        header('Content-Disposition: attachment; filename=114195383_VAT_SCHEDULE01_1620_20160709_ORIGINAL_V1.csv');

// create a file pointer connected to the output stream
                        $output = fopen('php://output', 'w');

// output the column headings
                        fputcsv($output, array("Serial No", "Invoice Date", "Tax Invoice No", "Purchasers TIN", "Name of the Purchaser", "Description", "Value of supply", "VAT Amount"));

                        $sql = "select * from s_salma where sdate >='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "'  and cancell='0' and vat ='1' order by id";
                        $i = 1;
                        foreach ($conn->query($sql) as $row) {
                            $m1 = $i;
                            $m2 = date("m/d/Y", strtotime($row['SDATE']));
                            $m3 = $row['REF_NO'];
                            $m4 = substr(trim($row['vat_no']), 0, 9);
                            $m5 = $row['CUS_NAME'];
                            $m6 = "Purchase Of Tyres";

                            $net = $row["GRAND_TOT"] / (1 + ($row["GST"] / 100));
                            $vat = $row["GRAND_TOT"] - $net;


                            $net = number_format($row["GRAND_TOT"] / (1 + ($row["GST"] / 100)), 0, ".", "");

                            $vat = $net * $row["GST"] / 100;

                            $m7 = number_format($net, 0, ".", "");
                            $m8 = number_format($vat, 2, ".", "");
                            $i = $i + 1;

                            fputcsv($output, array($m1, $m2, $m3, $m4, $m5, $m6, $m7, $m8));
                        }
                    }

                    if ($_GET['shtype'] == "sh4") {
                        // output headers so that the file is downloaded rather than displayed
                        header('Content-Type: text/csv; charset=utf-8');
                        header('Content-Disposition: attachment; filename=114195383_VAT_SCHEDULE01_1620_20160709_ORIGINAL_V1.csv');

// create a file pointer connected to the output stream
                        $output = fopen('php://output', 'w');

// output the column headings
                        /* 		<th  style="width: 50px;"></b></th>
                          <th  style="width: 110px;"></th>
                          <th  style="width: 80px;"></b></th>
                          <th  style="width: 110px;"></b></th>

                          <th  style="width: 179px;"></th>
                          <th  style="width: 179px;"></th>
                          <th  style="width: 179px;"></th>
                          <th  style="width: 179px;"></th>
                          <th  style="width: 50px;"></th>
                         */

                        fputcsv($output, array("Serial No", "TIN No", "Invoice Date", "Invoice No", "Tax Credit / Tax Debit Note", "Date of Tax Credit / Tax Debit Note", "Tax Credit No. / Tax Debit Note No.", "Value of Tax Credit Note / Tax Debit Note", "VAT Amount"));

                        $sql = "select * from s_salma where sdate >='" . $_GET["dtfrom"] . "' and sdate <='" . $_GET["dtto"] . "'  and cancell='0' and vat ='1' order by id";
                        $i = 1;
                        foreach ($conn->query($sql) as $row) {
                            $m1 = $i;
                            $m2 = date("m/d/Y", strtotime($row['SDATE']));
                            $m3 = $row['REF_NO'];
                            $m4 = substr(trim($row['vat_no']), 0, 9);
                            $m5 = $row['CUS_NAME'];
                            $m6 = "Purchase Of Tyres";

                            $net = $row["GRAND_TOT"] / (1 + ($row["GST"] / 100));
                            $vat = $row["GRAND_TOT"] - $net;


                            $net = number_format($row["GRAND_TOT"] / (1 + ($row["GST"] / 100)), 0, ".", "");

                            $vat = $net * $row["GST"] / 100;

                            $m7 = number_format($net, 0, ".", "");
                            $m8 = number_format($vat, 2, ".", "");
                            $i = $i + 1;

                            fputcsv($output, array($m1, $m2, $m3, $m4, $m5, $m6, $m7, $m8));
                        }
                    }
                }
                ?>
