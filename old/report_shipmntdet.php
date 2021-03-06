<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Shipment Details</title>

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
                font-size:13px;

            }
            td
            {
                font-size:12px;

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

        $heading = "<center>Shipment Details From  " . $_GET["DT1"] . " To ".  $_GET["DT2"]  . " <br><br>";
        echo $heading;


        $sql = "SELECT LCNO,SDATE,BRAND,REFNO from view_sh_de where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "'   AND cancel=0  ";
        if ($_GET["cmbcat"] != "All") {
            $sql .=" and cat1 ='" . $_GET["cmbcat"] . "'";
        }
        if ($_GET["cmbbrand"] != "All") {
            $sql .=" and brand ='" . $_GET["cmbbrand"] . "'";
        }
        $sql .= " and type='Import'";

        $sql .="  group by LCNO,SDATE,BRAND,REFNO order by refno ";
        $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 

       
        echo "<table border='1' ><tr> <td><b>LC NO</td> <td><b>DATE</td> <td><b>BRAND</td><td><b>STK NO</td><td><b>DESCRIPTION</td><td><b>QTY</td></tr>";

        while ($row = mysqli_fetch_array($result)) {
            $sql_02 = "SELECT * from view_sh_de where REFNO = '" . $row['REFNO'] . "'";

            echo "<tr> <td>" . $row['LCNO'] . "</td> <td>" . $row['SDATE'] . "</td> <td>" . $row['brand'] . "</td>  <td colspan='3'>" . $row['REFNO'] . "</td>    </tr>";

            $result1 = mysqli_query($GLOBALS['dbinv'],$sql_02);


$mtot=0;

            while ($row1 = mysqli_fetch_array($result1)) {
                echo "<tr> <td colspan='3'></td>            "
                
                . "<td>" . $row1['STK_NO'] . "</td>"
                . "<td>" . $row1['DESCRIPT'] . "</td>"
                . "<td align = 'right'>" . $row1['REC_QTY'] . "</td>"
                . " </tr>";
                $mtot = $mtot +$row1['REC_QTY'] ;
            }
            echo "<tr> <td colspan='5'></td>            "
                
                 
                . "<td align = 'right'><b>" . $mtot . "</b></td>"
                . " </tr>";
        }

        
                
        
        echo "</table><br>";


        $sql = "select sum(rec_qty) as qty from view_sh_de where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "' and type='Import' and ttype='PCR' and cancel='0'";
        if ($_GET["cmbbrand"] != "All") {
            $sql .=" and brand ='" . $_GET["cmbbrand"] . "'";
        }
        $result1 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        $row1 = mysqli_fetch_array($result1);
        $pcr = $row1['qty'];

        $sql = "select sum(rec_qty) as qty from view_sh_de where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "' and type='Import' and ttype='LTR' and cancel='0'";
        if ($_GET["cmbbrand"] != "All") {
            $sql .=" and brand ='" . $_GET["cmbbrand"] . "'";
        }
        $result1 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        $row1 = mysqli_fetch_array($result1);
        $LTR = $row1['qty'];

        $sql = "select sum(rec_qty) as qty from view_sh_de where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "' and type='Import' and ttype='OTR' and cancel='0'";
        if ($_GET["cmbbrand"] != "All") {
            $sql .=" and brand ='" . $_GET["cmbbrand"] . "'";
        }
        $result1 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        $row1 = mysqli_fetch_array($result1);
        $OTR = $row1['qty'];

        $sql = "select sum(rec_qty) as qty from view_sh_de where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "' and type='Import' and ttype='TBR' and cancel='0'";
        if ($_GET["cmbbrand"] != "All") {
            $sql .=" and brand ='" . $_GET["cmbbrand"] . "'";
        }
        $result1 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        $row1 = mysqli_fetch_array($result1);
        $TBR = $row1['qty'];

        $sql = "select sum(rec_qty) as qty from view_sh_de where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "' and type='Import' and ttype='BIAS TYRES' and cancel='0'";
        if ($_GET["cmbbrand"] != "All") {
            $sql .=" and brand ='" . $_GET["cmbbrand"] . "'";
        }
        $result1 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        $row1 = mysqli_fetch_array($result1);
        $bst = $row1['qty'];

        $sql = "select sum(rec_qty) as qty from view_sh_de where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "' and type='Import' and ttype='T/W TYRES' and cancel='0'";
        if ($_GET["cmbbrand"] != "All") {
            $sql .=" and brand ='" . $_GET["cmbbrand"] . "'";
        }
        $result1 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        $row1 = mysqli_fetch_array($result1);
        $twt = $row1['qty'];

        $sql = "select sum(rec_qty) as qty from view_sh_de where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "' and type='Import' and cat1='TYRE' and cancel='0'";
        if ($_GET["cmbbrand"] != "All") {
            $sql .=" and brand ='" . $_GET["cmbbrand"] . "'";
        }
        $result1 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        $row1 = mysqli_fetch_array($result1);
        $tyres = $row1['qty'];

        $sql = "select sum(rec_qty) as qty from view_sh_de where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "' and type='Import' and cat1='BATTERY' and cancel='0'";
        if ($_GET["cmbbrand"] != "All") {
            $sql .=" and brand ='" . $_GET["cmbbrand"] . "'";
        }
        $result1 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        $row1 = mysqli_fetch_array($result1);
        $batt = $row1['qty'];


        $sql = "select sum(rec_qty) as qty from view_sh_de where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "' and type='Import' and cat1='ALLOY WHEEL' and cancel='0'";
        if ($_GET["cmbbrand"] != "All") {
            $sql .=" and brand ='" . $_GET["cmbbrand"] . "'";
        }
        $result1 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        $row1 = mysqli_fetch_array($result1);
        $alwh = $row1['qty'];

        $sql = "select sum(rec_qty) as qty from view_sh_de where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "' and type='Import' and cat1='TUBE' and cancel='0'";
        if ($_GET["cmbbrand"] != "All") {
            $sql .=" and brand ='" . $_GET["cmbbrand"] . "'";
        }
        $result1 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        $row1 = mysqli_fetch_array($result1);
        $tube = $row1['qty'];


        echo "<table border='1' width = '300'><tr><td>PCR</td><td  align = 'right'>" . $pcr . "</td></tr>";
        echo "<tr><td>LTR</td><td  align = 'right'>" . $LTR . "</td></tr>";
        echo "<tr><td>OTR</td><td align = 'right'>" . $OTR . "</td></tr>";
        echo "<tr><td>TBR</td><td  align = 'right'>" . $TBR . "</td></tr>";
        echo "<tr><td>BIAS TYRES</td><td  align = 'right'>" . $bst . "</td></tr>";
        echo "<tr><td>T/W TYRES</td><td  align = 'right'>" . $twt . "</td></tr>";
        echo "<tr><td>TOTAL TYRES</td><td  align = 'right'>" . $tyres . "</td></tr>";
        echo "<tr><td>TOTAL BATTERIES</td><td  align = 'right'>" . $batt . "</td></tr>";
        echo "<tr><td>TOTAL ALLOY WHEELS</td><td  align = 'right'>" . $alwh . "</td></tr>";
        echo "<tr><td>TOTAL TUBES</td><td  align = 'right'>" . $tube . "</td></tr></table>";


        echo"<br><br><br><table width = '500' > <tr><td>Signature </td> <td>..............................................</td>          <td colspan = '4'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </td>         </tr>      "
        . "<tr><td>Working Director </td> <td>..............................................</td>       <td colspan = '4'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </td>              </tr> "
        . "<tr><td>Managing Director </td> <td>..............................................</td>     <td colspan = '4'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </td>                </tr>  </table>"
        ?>



    </body>
</html>
