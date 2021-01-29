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


    <title>Search T Card</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">



    <!-- <script language="JavaScript" src="js/search_joborder.js"></script> -->

    <script language="JavaScript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


    <script language="JavaScript" src="js/invoice.js"></script> 



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

            $sql2 = "SELECT * from t_jobcard where STEP='5' ";

            echo "<table id='example'  class='table table-bordered' style='font-size: 14px;'>";

            echo "<thead><tr>";
            echo "<th>CARD NO</th>";
            echo "<th>JOb NO</th>";
            echo "<th>Customer Name</th>"; 
            echo "<th>Date Finished</th>";


            echo "</tr></thead><tbody>";

            foreach ($conn->query($sql2) as $row) { 
                $cuscode = $row['cardno']; 
                echo "<tr>               
                <td onclick=\"custno1('$cuscode', '$stname');\">" . $row['cardno'] . "</a></td>
                <td onclick=\"custno1('$cuscode', '$stname');\">" . $row['jobno'] . "</a></td>
                <td onclick=\"custno1('$cuscode', '$stname');\">" . $row['cusname'] . "</a></td>
                <td onclick=\"custno1('$cuscode', '$stname');\">" . $row['datefini'] . "</a></td> 
                </tr>";
            }
            ?>
        </table> </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').dataTable( {
                  "pageLength": 10
              } );
            } );

// $('#example').DataTable( {
//   "aaSorting": [[ 0, "desc" ]] // Sort by first column descending
// } );

</script>


</body>
</html>
