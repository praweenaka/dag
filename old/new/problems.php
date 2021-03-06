<?php
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();
date_default_timezone_set('Asia/Colombo');
if ($_SESSION["dev"] == "") {
    echo "Invalid User Session";
    exit();
}
?>
<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {background-color: #f2f2f2;}
</style>
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Problems Cases</h3>
        </div>
        <form role="form" name ="form1" class="form-horizontal">
            <div class="box-body">

                <div class="form-group">
                    <a onclick="location.reload();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a> 
                </div>
                <div class="form-group">

                </div>
                <div class="row">
                    <div  class="well col-sm-6" style="height:300px;overflow:scroll;">

                        <table>
                            <?php
                            require_once("./connection_sql.php");
                            echo" <tr> <th style=\"background-color: #4CAF50\">Invoice</th></tr>";

                            $sql = "Select AMOUNT, REF_NO, SDATE,VAT,GRAND_TOT,TOTPAY  from s_salma where   CANCELL='0' and SDATE > curdate() - interval 4 month ";
                            $result = $conn->query($sql);

                            foreach ($conn->query($sql) as $row) {
                                

                                $sql1 = "Select sum(subtot) as subtot,vatrate from s_invo where REF_NO='" . $row["REF_NO"] . "' ";

                                $result1 = $conn->query($sql1);
                                if ($row1 = $result1->fetch()) {
                                    if ($row["VAT"] == '0') {
                                        if (ROUND($row1['subtot']) != round($row['GRAND_TOT'])) {
                                            echo" <tr> <td>S_INVO Amount Not Tally= " . $row["SDATE"] . " - " . $row["REF_NO"] . "</td></tr>";
                                        }
                                    } else {
                                        if (ROUND($row1['subtot']) != round($row['GRAND_TOT'])) {
                                            echo" <tr> <td>S_INVO Amount Not Tally= " . $row["SDATE"] . " - " . $row["REF_NO"] . "</td></tr>";
                                        }
                                    }
                                } else {
                                    echo" <tr> <td>S_INVO NO Result = " . $row["SDATE"] . " - " . $row["REF_NO"] . "</td></tr>";
                                }
 
                                $sql3 = "Select REFNO from s_trn where REFNO='" . $row["REF_NO"] . "'";
                                $result3 = $conn->query($sql3);
                                if ($row3 = $result3->fetch()) {
                                    
                                } else {
                                    echo" <tr> <td>S_TRN = " . $row["SDATE"] . " - " . $row["REF_NO"] . "</td></tr>";
                                }
                            }
                            ?> 
                        </table>
                    </div>
                    <div class="well col-sm-6" style="height:300px;overflow:scroll;">
                        <table>
                            <?php
                            require_once("./connection_sql.php");
                            echo" <tr> <th style=\"background-color: #4CAF50\">Receipt</th></tr>";

                            $sql = "Select CA_REFNO,CA_DATE,CA_AMOUNT,pay_type  from s_crec where  CANCELL='0' and FLAG!='RET'  and CA_DATE > curdate() - interval 4 month";
                            $result = $conn->query($sql);

                            foreach ($conn->query($sql) as $row) {

                                $sql1 = "Select sum(ST_PAID) as paid  from s_sttr where ST_REFNO='" . $row["CA_REFNO"] . "'";
                                $result1 = $conn->query($sql1);
                                if ($row1 = $result1->fetch()) {
                                    if (ROUND($row1['paid']) != round($row['CA_AMOUNT'])) {
                                        echo" <tr> <td>S_STTR Amount Not Tally= " . $row["CA_DATE"] . " - " . $row["CA_REFNO"] . "</td></tr>";
                                    }
                                } else {
                                    echo" <tr> <td>S_STTR No Result= " . $row["CA_DATE"] . " - " . $row["CA_REFNO"] . "</td></tr>";
                                }

//                                $sql2 = "Select sum(ST_PAID) as paid  from s_sttr_all where ST_REFNO='" . $row["CA_REFNO"] . "'";
//                                $result2 = $conn->query($sql2);
//                                if ($row2 = $result2->fetch()) {
//                                    if ($row["pay_type"] != 'Cheque') {
//                                        if (ROUND($row2['paid']) != round($row['CA_AMOUNT'])) {
//                                            echo" <tr> <td>S_STTR_ALL Amount Not Tally= " . $row["CA_DATE"] . " - " . $row["CA_REFNO"] . "</td></tr>";
//                                        }
//                                    }
//                                } else {
//                                    echo" <tr> <td>S_STTR_ALL No Result = " . $row["CA_DATE"] . " - " . $row["CA_REFNO"] . "</td></tr>";
//                                }
                            }
                            ?>  
                        </table>
                    </div> 
                </div>
            </div> 
        </form>
    </div>

</section>
