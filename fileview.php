<?php
session_start();
include_once './connection_sql.php';
?>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">File View</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
        <form method='post' action='' enctype='multipart/form-data'>
            <div class="box-body">


                <!-- <link href="bootstrap/vendor/bootstrap.css" rel="stylesheet"> -->
                <link href="bootstrap/vendor/dataTables.bootstrap4.min.css" rel="stylesheet">
                <link href="bootstrap/vendor/buttons.bootstrap4.min.css" rel="stylesheet">

                <script src="bootstrap/vendor/jquery-3.3.1.js" ></script>
                <script src="bootstrap/vendor/jszip.min.js" ></script>
                <script src="bootstrap/vendor/pdfmake.min.js" ></script>
                <script src="bootstrap/vendor/vfs_fonts.js" ></script>
                <script src="bootstrap/vendor/dataTables.min.js" ></script>
                <script src="bootstrap/vendor/dataTables.bootstrap4.min.js" ></script>
                <script src="bootstrap/vendor/buttons.min.js" ></script>
                <script src="bootstrap/vendor/bootstrap4.min.js" ></script>
                <script src="bootstrap/vendor/html5.min.js" ></script>
                <script src="bootstrap/vendor/print.min.js" ></script>
                <script src="bootstrap/vendor/colVis.min.js" ></script>

                <script language="JavaScript" src="js/sales_inv.js"></script>



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
                        echo "<th>Batch No</th>";
                        echo "<th>File</th>";
                        echo "<th>Company</th>"; 
                        echo "<th>User</th>";  
                        echo "<th>Date</th>";  
                        echo "<th>Status</th>";  


                        echo "</tr></thead><tbody>";


                        ?>
                        <?php
                        require_once ("connection_sql.php");

                        $sql = "SELECT * FROM s_addfiles where cancell='0' ";
                        foreach ($conn->query($sql) as $row) {

                            echo "<tr>               
                            <td onclick=\"invno_inv('" . $row['id'] . "', '" . $stname . "');\">" . $row['batch'] . "</a></td>
                            <td onclick=\"invno_inv('" . $row['id'] . "', '" . $stname . "');\"><a href=\"" . $row["file"] . "\" target=\"_blank\">view file</a></td>
                            <td onclick=\"invno_inv('" . $row['id'] . "', '" . $stname . "');\">" . $row['company'] . "</a></td>
                            <td onclick=\"invno_inv('" . $row['id'] . "', '" . $stname . "');\">" . $row['user'] . "</a></td>
                            <td onclick=\"invno_inv('" . $row['id'] . "', '" . $stname . "');\">" . $row['sdate'] . "</a></td>
                            <td onclick=\"invno_inv('" . $row['id'] . "', '" . $stname . "');\">PENDING</a></td>

                            </tr>";
                        }
                        ?>
                    </table> </div>

                </div>

            </form>
        </div>
    </section>
    <script>
     $(document).ready(function() {
         var table = $('#example').DataTable( {
            lengthChange: true,
            fixedHeader: true,
            responsive: true,
            "deferRender": true,
            "order": [[ 0, 'desc' ]],
            buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
            lengthMenu: [[ 10, 25, 50,100, -1 ],[ '10 rows', '25 rows', '50 rows', '100 rows', 'Show all' ]],

        } );

         table.buttons().container()
         .appendTo( '#example_wrapper .col-md-6:eq(0)' );
     } );


 </script>

<script>
    setTimeout(function () {
        location.reload()
    }, 14000);

</script>


