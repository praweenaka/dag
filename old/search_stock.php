<?php
session_start();
include_once './connection_sql.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Search Item</title>   
 

     <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.bootstrap4.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.colVis.min.js"></script>    
    <script language="JavaScript" src="js/search_item.js"></script>

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
            echo "<th>Item Code</th>";
            echo "<th>Item Description</th>"; 
            echo "<th>Part No</th>";
            echo "<th>Model</th>";
            echo "<th>Stock</th>";
            echo "<th>Price</th>"; 

            echo "</tr></thead><tbody>";

            
            ?>
            <?php
            require_once("connectioni.php");

 
                $sql = "select * from s_mas ORDER BY STK_NO";
            
                    
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {
 
                echo "<tr>                
                              <td onclick=\"itemno('".$row['STK_NO']."');\">".$row['STK_NO']."</a></td>
                              <td onclick=\"itemno('".$row['STK_NO']."');\">".$row['DESCRIPT']."</a></td> 
                              <td onclick=\"itemno('".$row['STK_NO']."');\">".$row['PART_NO']."</a></td>
							  <td onclick=\"itemno('".$row['STK_NO']."');\">".$row['BRAND_NAME']."</a></td>
							  <td onclick=\"itemno('".$row['STK_NO']."');\">".$row['QTYINHAND']."</a></td>
							  <td onclick=\"itemno('".$row['STK_NO']."');\">".$row['SELLING']."</a></td>
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
            "deferRender": true,
             "order": [[ 0, 'desc' ]],
            // buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
            lengthMenu: [[ 10, 25, 50,100, -1 ],[ '10 rows', '25 rows', '50 rows', '100 rows', 'Show all' ]],

        } );
 $("#filter").on('change', function() {
        table.column([4]).search($(this).val()).draw();
    }); 
           table.buttons().container()
           .appendTo( '#example_wrapper .col-md-6:eq(0)' );
       } );

 
   </script>





   </html>






