<?php
session_start();
include_once './connection_sql.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link href="style.css" rel="stylesheet" type="text/css" media="screen" />


    <title>Search Item List</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

 

    <script language="JavaScript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script language="JavaScript" src="js/item_mas.js"></script> 

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

            $sql2 = "SELECT * from s_mas  order by stk_no  desc";

            echo "<table id='example'  class='table table-bordered' style='font-size: 14px;'>";

            echo "<thead><tr>";
            echo "<th>STK NO</th>";
            echo "<th>DESCRIPTION</th>";
            echo "<th>BRAND</th>";
            echo "<th>COST</th>";
            echo "<th>RETAIL PRICE</th>";
            echo "<th>WHOLESALE PRICE</th>";
            echo "<th>QTYINHAND</th>"; 


            echo "</tr></thead><tbody>";

            foreach ($conn->query($sql2) as $row) { 
                $cuscode = $row['STK_NO']; 
                echo "<tr>               
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['STK_NO'] . "</a></td>
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['DESCRIPT'] . "</a></td>
                 <td onclick=\"custno('$cuscode', '$stname');\">" . $row['BRAND_NAME'] . "</a></td>    
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['COST'] . "</a></td>
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['SELLING'] . "</a></td>
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['whprice'] . "</a></td>
                <td onclick=\"custno('$cuscode', '$stname');\">" . $row['QTYINHAND'] . "</a></td>
                </tr>";
            }
            ?>
        </table> </div>

       <script type="text/javascript">
                $(document).ready(function() {
           var table = $('#example').DataTable( {
            lengthChange: true,
            fixedHeader: true,
            responsive: true,
            "deferRender": true, 
             "order": [[ 0, 'desc' ]], 
            lengthMenu: [[ 25, 50,100, -1 ],[ '25 rows', '50 rows', '100 rows', 'Show all' ]],

        } );

$('div.dataTables_filter input', table.table().container()).focus();
           table.buttons().container()
           .appendTo( '#example_wrapper .col-md-6:eq(0)' );
           
       } );
        </script>

    </body>
    </html>
