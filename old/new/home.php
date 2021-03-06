<?php
include "header.php";
include "connectioni.php";
?>

<?php

date_default_timezone_set('Asia/Colombo');
include ("connection_sql.php");
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();

if ($_SESSION["CURRENT_USER"] == "") {
 echo "Please Logging Again..";

 // exit();
}
if ($_SESSION["CURRENT_USER"] != "Aruni") {
    if ($_SESSION['company'] !="THT") {
        echo "Please Loging Again.. Different Company !!!";
        exit();
    }
}



$sqlcumas = "select * from view_userpermission where username='" . $_SESSION["CURRENT_USER"] . "' and  block='0' and name='".$_GET['url']."' and doc_view='1'"; 
$resultcumas = $conn->query($sqlcumas);
if ($rowsumas != $resultcumas->fetch()) { 
    if (isset($_GET['url'])) {

        // if ($_GET['url'] == "rep_repwisesale") {
        //     include_once './rep_repwisesale.php';
        // }
        // if ($_GET['url'] == "po") {
        //     include_once './po.php';
        // }
            // if ($_GET['url'] == "dealer_sch") {
        //     include_once './dealer_schedule.php';
        // }
        if ($_GET['url'] == "dealer_remark") {
            include_once './dealer_remark.php';
        }
        if ($_GET['url'] == "cust_mast") {
            include_once './subcusmas.php';
        }
        if ($_GET['url'] == "rep_profile") {
            include_once './rep_profile.php';
        }

        if ($_GET['url'] == "gin") {
            include_once './gin_m.php';
        } 
        if ($_GET['url'] == "rep_stock_adjustment") {
            include_once './rep_stock_adjustment.php';
        }
        if ($_GET['url'] == "defect_inv") {
            include_once './defect_inv.php';
        }
        if ($_GET['url'] == "vatshdule") {
            include_once './vatshdule.php';
        }
        if ($_GET['url'] == "Dealer_share") {
            include_once './Dealer_share.php';
        }
        if ($_GET['url'] == "def_inv") {
            include_once './def_inv.php';
        }
        if ($_GET['url'] == "price_control") {
            include_once './price_control.php';
        }
        if ($_GET['url'] == "invoice_info") {
            include_once './invoice_info.php';
        }
        if ($_GET['url'] == "dealer_comm") {
            include_once './dealer_comman.php';
        }
        if ($_GET['url'] == "sales_inv") {
            include_once './sales_inv.php';
        }
        if ($_GET['url'] == "bin_card") {
            include_once './bincard.php';
        }
        if ($_GET['url'] == "dealer_insc") {
            include_once './dealer_insc.php';
        }

        if ($_GET['url'] == "login_report") {
            include_once './login_report.php';
        }
        if ($_GET['url'] == "rep_lock_active") {
            include_once './rep_lock_active.php';
        }
        if ($_GET['url'] == "sms_fire") {
            include_once './sms_fire.php';
        }
        if ($_GET['url'] == "insen_pay_modifi") {
            include_once './insen_pay_modifi.php';
        }
        // if ($_GET['url'] == "discount_item") {
        //     include_once './discount_item.php';
        // }

        if ($_GET['url'] == "reqdata_modification") {
            include_once './reqdata_modification.php';
        }
        if ($_GET['url'] == "problems") {
            include_once './problems.php';
        }
        if ($_GET['url'] == "report_vehicle") {
            include_once './report_vehicle.php';
        }
        if ($_GET['url'] == "trans_pay") {
            include_once './trans_pay.php';
        }
        if ($_GET['url'] == "credit_note_app") {
            include_once './credit_note_app.php';
        }
    }else{
        include_once './fpage.php';
    }
}else{
    // echo "You Dont  Have Permission This Page";
    include_once './fpage.php';
}
?>

<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button> -->

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php
include_once './footer.php';
?>

</body>
</html>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="js/app.min.js"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(function() {
        $('.dt').datepicker({
            format: 'yyyy-mm-dd'
        });


    });

    $(function() {
        $('.dt1').datepicker({
            format: 'yyyy-mm'

        });


    });
    function ondate() {
        var a = document.getElementById('months').value;

        var x = a.substr(0, 7);

        document.getElementById('months').value = x;
    }
</script>
<script type="text/javascript">

    function getrep1() {

        $(function() {
            Highcharts.chart('container', {
                data: {
                    table: 'datatable'
                },
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Current Year With Previous Year Sales'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: 'Sale'
                    }
                },
                tooltip: {
                    pointFormat: "Value: {point.y:,.0f}"
                }
            });
        });
    }

    // $('#click').click(function() {
    </script>

    <script src="js/comman.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script>
        $("body").addClass("sidebar-collapse");
    </script>    


    <?php
    include 'login.php';
    ?>
    <script>
        var myVar = setInterval(myTimer, 1000);

        function myTimer() {

            var d = new Date();
                //        var dd = d.toLocaleDateString();
                var tt = d.toLocaleTimeString();
                document.getElementById("time").innerHTML = tt;
            }

        </script>