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


    <title>Search Dag</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

 

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
            echo $_SESSION['rejectdag'];
            $sqlven = "select * from vendor where CODE = '" . trim($_SESSION['customer']) . "'";
            $resultven = $conn->query($sqlven);
            $rowven = $resultven->fetch(); 
            
            if($_SESSION['rejectdag']=="true"){
                $sql2 = "SELECT * from dag_item where flag!='0' and cancel='0'"; 
            }else{
                $sql2 = "SELECT * from dag_item where flag='2' and cancel='0'  "; 
            }
             
             if($_SESSION['customer']!=""){
                $sql2 .= " and (cuscode='".$_SESSION['customer']."' or cuscode='C/00021')";
             }
             
            //   $sql2 .= " and invno is null ";
           echo $sql2;
 
            echo "<table id='example'  class='table table-bordered' style='font-size: 14px;'>";

            echo "<thead><tr>";
            echo "<th>#</th>";
            echo "<th>JOB NO</th>";
            echo "<th>CUSTOMER</th>";
            echo "<th>MAKE</th>";
            echo "<th>SIZE</th>"; 
            echo "<th>SERIAL NO</th>";
            echo "<th>AD PAY</th>";
            echo "<th>COST</th>";
            echo "<th>SELLING</th>";  

            echo "</tr></thead><tbody>";
 $i=1;
            foreach ($conn->query($sql2) as $row) { 
                $cuscode = $row['id']; 
                echo "<tr>               
                <td onclick=\"custno1('$cuscode', '$stname');\">" . $i . "</a></td>
                <td onclick=\"custno1('$cuscode', '$stname');\">" . $row['jobno'] . "</a></td>
                 <td onclick=\"custno1('$cuscode', '$stname');\">" . $row['cusname'] . "</a></td>
                <td onclick=\"custno1('$cuscode', '$stname');\">" . $row['marker'] . "</a></td>
                <td onclick=\"custno1('$cuscode', '$stname');\">" . $row['size'] . "</a></td>
                <td onclick=\"custno1('$cuscode', '$stname');\">" . $row['serialno'] . "</a></td> 
                <td onclick=\"custno1('$cuscode', '$stname');\">" . $row['adpayment'] . "</a></td> 
                <td onclick=\"custno1('$cuscode', '$stname');\">" . $row['cost'] . "</a></td> 
                <td onclick=\"custno1('$cuscode', '$stname');\">" . $row['total'] . "</a></td>  
                </tr>";
                $i =$i +1;
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
             "order": [[ 0, 'asc' ]], 
            lengthMenu: [[ 25, 50,100, -1 ],[ '25 rows', '50 rows', '100 rows', 'Show all' ]],

        } );

$('div.dataTables_filter input', table.table().container()).focus();
           table.buttons().container()
           .appendTo( '#example_wrapper .col-md-6:eq(0)' );
           
       } );
        </script>

</body>
</html>
