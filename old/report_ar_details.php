<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>AR Report</title>

        <style>
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {

                font-family:Arial, Helvetica, sans-serif;
                padding:5px;
            }
            th
            {
                font-weight:bold;
                font-size:14px;

            }
            td
            {
                font-size:13px;

            }
        </style>
        <style type="text/css">
            <!--
            .style1 {
                color: #0000FF;
                font-weight: bold;
                font-size: 24px;
            }
            -->
        </style>
    </head>

    <body> 

        <?php
        require_once("connectioni.php");
        
        









        $sql_head = "select * from invpara";
        $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
        $row_head = mysqli_fetch_array($result_head);

        echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

        $heading = "<center>AR Report From  " . $_GET["DT1"] . " To ". $_GET["DT2"] . " <br><br>";
        echo $heading;


        $sql = "SELECT SDATE,REFNO,brand_name,LCNO,sum(COST*REC_QTY) as COST,sum(acc_cost*REC_QTY) as acc_COST from viewpur where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "'   AND cancel=0  ";
        if ($_GET["cmbcat"] != "All") {
        $sql .=" and type ='" . $_GET["cmbcat"] . "'";
        }
        $sql .="  group by SDATE,REFNO,brand_name,LCNO order by REFNO ";
        $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        echo "<table border='1' width=800 ><tr> <td><b>DATE</td> <td><b>AR NO</td> <td><b>LC NO</td><td><b>BRAND NAME</td><td><b>AMOUNT</td></tr>";
        while ($row = mysqli_fetch_array($result)) {      
        echo "<tr> <td>" . $row['SDATE'] . "</td> <td>" . $row['REFNO'] . "</td> <td>" . $row['LCNO'] . "</td>  <td>" . $row['brand_name'] . "</td>  <td  align='right'> " . number_format($row['acc_COST'], "2",".",",") . "</td>    </tr>";
        $cos = $cos+($row['acc_COST']);
         
        }
        
 echo "<tr> <td></td> <td></td> <td></td>  <td></td>  <td align='right'><b>" . number_format($cos, "2",".",",")   . "</td>    </tr>";

        echo "</table><br>";
        ?>



    </body>
</html>
