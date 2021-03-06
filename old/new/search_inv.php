<?php
session_start();
include_once './connection_sql.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Search Item</title>   
<!--     <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet"> 
    <link href="vvendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet"> 
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script> 
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script> -->


    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"/> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css"/> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"> -->
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <!-- Include Required Prerequisites -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" /> -->

    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />



    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.bootstrap4.min.css" rel="stylesheet">

    <script language="JavaScript" src="js/sales_inv.js"></script>

</head>
<body>
    <?php
    $stname = "";
    if (isset($_GET['stname'])) {
        $stname = $_GET["stname"];
    }
    ?>
    <input type="hidden" value="" id="cur" />


    <div id="filt_table" class="CSSTableGenerator container"> 
        <table id="testTable"  class="table table-bordered">

            <?php



            echo "<table id='example' class='table table-striped table-bordered' style='width:100%'>";

            echo "<thead><tr>";
            echo "<th>Invoice No</th>";
            echo "<th>Customer</th>";
            echo "<th>Invoice Date</th>"; 
            echo "<th>Invoice Value</th>";  


            echo "</tr></thead><tbody>";

            
            ?>
            <?php
            require_once("connectioni.php");



            if ($stname == "crn") {
                if ($_SESSION["custno"] != "") {
                    $sql = "SELECT * FROM s_salma where C_CODE='" . $_SESSION["custno"] . "' and DEV='" . $_SESSION["dev"] . "' and CANCELL='0' order by id desc limit 150";
                } else {
                    $sql = "SELECT * FROM s_salma where CANCELL='0' order by id desc limit 150";
                }
            } else if ($stname == "grn") {
                if ($_SESSION["custno"] != "") {
                    $sql = "SELECT * FROM s_salma where C_CODE='" . $_SESSION["custno"] . "' and DEV='" . $_SESSION["dev"] . "' and CANCELL='0' order by id desc limit 150";
                } else {
                    $sql = "SELECT * FROM s_salma where CANCELL='0' and DEV='" . $_SESSION["dev"] . "' order by id desc limit 150";
                }
            } else if ($stname == "search_grn") {
                $sql = "SELECT * FROM s_crnma where CANCELL='0' order by id desc limit 150";
            } else {
                $sql = "SELECT * FROM s_salma where  CANCELL='0' and DEV='" . $_SESSION["dev"] . "' order by id desc limit 3150";
            }
                    // echo $sql;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {
// cri/212906
                echo "<tr>               
                <td onclick=\"invno_inv('" . $row['REF_NO'] . "', '" . $stname . "');\">" . $row['REF_NO'] . "</a></td>
                <td onclick=\"invno_inv('" . $row['REF_NO'] . "', '" . $stname . "');\">" . $row["CUS_NAME"] . "</a></td>
                <td onclick=\"invno_inv('" . $row['REF_NO'] . "', '" . $stname . "');\">" . $row['SDATE'] . "</a></td>
                <td onclick=\"invno_inv('" . $row['REF_NO'] . "', '" . $stname . "');\">" . $row['GRAND_TOT'] . "</a></td>

                </tr>";
            }
            ?>
        </table> </div>



    </body>
    <script>
       $(document).ready(function() {
           var table = $('#example').DataTable( {
            lengthChange: true,
            fixedHeader: true,
            responsive: true,
            buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
            lengthMenu: [[ 10, 25, 50,100, -1 ],[ '10 rows', '25 rows', '50 rows', '100 rows', 'Show all' ]],

        } );

           table.buttons().container()
           .appendTo( '#example_wrapper .col-md-6:eq(0)' );
       } );
       

   </script>



   <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.bootstrap4.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.colVis.min.js"></script>

   </html>




