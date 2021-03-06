<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Outstanding Credit Limits</title>

        <style>
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {
                border:1px solid black;
                font-family:Arial, Helvetica, sans-serif;
                padding:5px;
            }
            th
            {
                font-weight:bold;
                font-size:12px;

            }
            td
            {
                font-size:11px;

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
        
        





        if (!isset($_GET["Check1"])) {

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

            $heading = "<center>Credit Limit Report On  " . date("Y-m-d") . "<br>";
            echo $heading;



            echo "<table border=1>";
            echo "<tr><td><b>Code</b></td>"
            . "<td><b>Name</b></td>"
            . "<td><b>Address</b></td>"
            . "<td><b>Cat</b></td>"
            . "<td><b>Credit Limit</b></td>"
            . "</tr>";

            $sql = "SELECT * from vendor where code <> ''  ";


            if ($_GET["cmbclass"] != "All") {
                $sql .= " and cat='" . $_GET["cmbclass"] . "' ";
            }

            if ($_GET["cmb_rep"] != "All") {
                $sql .= " and rep='" . $_GET["cmb_rep"] . "' ";
            }

            $sql .= "order by code";

            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>
			<td>" . $row["CODE"] . "</td>
			<td>" . $row["NAME"] . "</td>
			<td>" . $row["ADD1"] . " " . $row["ADD2"] . "</td>
			<td>" . $row["CAT"] . "</td>
			<td align=\"right\">" . number_format($row["cLIMIT"], 2, ".", ",") . "</td>";



                echo "</tr>";
            }
        }


        if (isset($_GET["Check1"])) {

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

            $heading = "<center>Credit Limit Report On  " . date("Y-m-d") . "<br>";
            echo $heading;



            echo "<table border=1>";
            echo "<tr><td><b>Code</b></td>"
            . "<td><b>Name</b></td>"
            . "<td><b>Address</b></td>"
            . "<td><b>Cat</b></td>"
            . "<td><b>Credit Limit</b></td>"
            . "</tr>";

            $sql = "SELECT provi from vendor where code <> ''  ";


            if ($_GET["cmbclass"] != "All") {
                $sql .= " and cat='" . $_GET["cmbclass"] . "' ";
            }

            if ($_GET["cmb_rep"] != "All") {
                $sql .= " and rep='" . $_GET["cmb_rep"] . "' ";
            }



            $sql .=" group by provi order by provi";

            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            while ($row = mysqli_fetch_array($result)) {

                $sql1 = "SELECT * from vendor where code <> ''  ";


                if ($_GET["cmbclass"] != "All") {
                    $sql1 .= " and cat='" . $_GET["cmbclass"] . "' ";
                }

                if ($_GET["cmb_rep"] != "All") {
                    $sql1 .= " and rep='" . $_GET["cmb_rep"] . "' ";
                }

                $sql1 .= " and provi = '" . $row["provi"] . "' order by code";


                if (trim($row["provi"]) == "A") {
                    $prov = "Western Province";
                }
                if (trim($row["provi"]) == "B") {
                    $prov = "Central Province";
                }
                if (trim($row["provi"]) == "C") {
                    $prov = "Sabaragamuwa Provice";
                }
                if (trim($row["provi"]) == "D") {
                    $prov = "Southern Province";
                }
                if (trim($row["provi"]) == "E") {
                    $prov = "North Central Province";
                }
                if (trim($row["provi"]) == "F") {
                    $prov = "North Western Province";
                }
                if (trim($row["provi"]) == "G") {
                    $prov = "Eastern Province 1";
                }
                if (trim($row["provi"]) == "H") {
                    $prov = "Uva Province";
                }
                if (trim($row["provi"]) == "I") {
                    $prov = "Eastern Province 2";
                }


                $str = "<tr>"
                        . "<td><b>" . $row["provi"] . "</b></td>"
                        . "<td colspan='4'><b>" . $prov . "</b></td>"
                        . "</tr>";
                echo $str;






                $result1 = mysqli_query($GLOBALS['dbinv'],$sql1) ; 
                while ($row1 = mysqli_fetch_array($result1)) {



                    echo "<tr>
                <td>" . $row1["CODE"] . "</td>
                <td>" . $row1["NAME"] . "</td>
                <td>" . $row1["ADD1"] . " " . $row1["ADD2"] . "</td>
                <td>" . $row1["CAT"] . "</td>
                <td align = \"right\">" . number_format($row1["cLIMIT"], 2, ".", ",") . "</td>";



                    echo "</tr>";
                }
            }
        }
        ?>



    </body>
</html>
