<?php
session_start();
include_once './connection_sql.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="style.css" rel="stylesheet" type="text/css" media="screen" />


    <title>Search Arn</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <!-- <script language="JavaScript" src="js/search_joborder.js"></script> -->
    <script language="JavaScript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script language="JavaScript" src="js/comman.js"></script>
            <script language="JavaScript" src="js/po.js"></script>

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

            

            echo "<table id='example'  class='table table-bordered' style='font-size: 14px;'>";

            echo "<thead><tr>";
            echo "<th>Reference NO</th>";
            echo "<th>Date</th>";
            echo "<th>Code</th>";
            echo "<th>COST</th>";
            echo "<th>Name</th>"; 
            echo "<th>Amount</th>"; 
 

            echo "</tr></thead><tbody>";

           
                    include './connection_sql.php';

                    $phrase = "";
                    if($stname == "arn"){
                        $phrase = " where cancel='0' ";
                    }
                    $sql = "select * from s_purmas $phrase ORDER BY REFNO desc  ";

                    foreach ($conn->query($sql) as $row) {
                        $cuscode = $row["REFNO"];


                        echo "<tr>               
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['REFNO'] . "</a></td>
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['SUP_CODE'] . "</a></td>
                                  <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['SUP_NAME'] . "</a></td>
                                      <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['AMOUNT'] . "</a></td>
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




 
 
  