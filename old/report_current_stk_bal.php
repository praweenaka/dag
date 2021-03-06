<?php
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Current Stock Balance</title>

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

    </head>

    <body> <center> 


            <?php
            require_once("connectioni.php");
            
            

            $sql = "delete from tmpstkbal";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 



//if ($_GET["brand"]!="All"){	
//	$sql_smas="select * from s_mas  where   BRAND_NAME='" & cmbbrand & "'";
//} else {	
            $sql_smas = "select * from s_mas";
//}
//$result_smas =mysqli_query($GLOBALS['dbinv'],$sql_smas);
//while($row_smas = mysqli_fetch_array($result_smas)){

            $sql_brand = "select * from brand_mas";
            $result_brand = mysqli_query($GLOBALS['dbinv'],$sql_brand);
            while ($row_brand = mysqli_fetch_array($result_brand)) {
                $stkval = 0;

                $sql_smas = "select * from s_mas where BRAND_NAME='" . $row_brand["barnd_name"] . "'";
			//	echo $sql_smas."</br>";
                $result_smas = mysqli_query($GLOBALS['dbinv'],$sql_smas);
                while ($row_smas = mysqli_fetch_array($result_smas)) {
                    if ($_GET["department"] == "All") {
                        if ($_SESSION['dev'] == '1') {
                            if ((!is_null($row_smas["COST"])) and ( !is_null($row_smas["QTYINHAND"]))) {
                                $stkval = $stkval + $row_smas["COST"] * $row_smas["QTYINHAND"];
                            }
                        } else if ($_SESSION['dev'] == '0') {
                            if ((!is_null($row_smas["acc_cost"])) and ( !is_null($row_smas["QTYINHAND"]))) {
                                $stkval = $stkval + $row_smas["acc_cost"] * $row_smas["QTYINHAND"];
                            }
                        }
						//echo $row_smas["QTYINHAND"]."-".$stkval."</br>";
                    } else {
                        $sql_submas = "select QTYINHAND from s_submas where STK_NO='" . $row_smas["STK_NO"] . "' and STO_CODE='" . $_GET["department"] . "'";
                        $result_submas = mysqli_query($GLOBALS['dbinv'],$sql_submas);
                        $row_submas = mysqli_fetch_array($result_submas);
                        if ($_SESSION['dev'] == '1') {
                            if ((!is_null($row_smas["COST"])) and ( !is_null($row_submas["QTYINHAND"]))) {
                                $stkval = $stkval + $row_smas["COST"] * $row_submas["QTYINHAND"];
                            }
                        } else if ($_SESSION['dev'] == '0') {
                            if ((!is_null($row_smas["acc_cost"])) and ( !is_null($row_submas["QTYINHAND"]))) {
                                $stkval = $stkval + $row_smas["acc_cost"] * $row_submas["QTYINHAND"];
                            }
                        }
                    }
                }


                $sql_new[] = "('" . $row_brand["barnd_name"] . "', " . $stkval . ")";
			//	echo $sql_new."</br>";
                
            }

			$sqli ="insert into tmpstkbal(brand, stkbal) values "	 . implode(",", $sql_new);
			$result_new = mysqli_query($GLOBALS['dbinv'],$sqli);
			
            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>Stock Balance As At ".    date("Y-m-d")     .  "</center><br>";

            echo "<table  width=600 border=1>";
            echo "<tr><td align=center width=400><font size = 3><b>Brand</b></font></td><td align=center><font size = 3><b>Stock Value</b></font></td></tr>";
            $sql = "SELECT * from tmpstkbal";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            while ($row = mysqli_fetch_array($result)) {

                if ($row["stkbal"] > 0) {
                    echo "<tr><td><font size = 2>" . $row["brand"] . "</td><td align=right><font size = 2>" . number_format($row["stkbal"], 2, ".", ",") . "</td></tr>";
                
                 $mtot =   $mtot + $row["stkbal"];
                }
            }
 echo "<tr><td><font size = 3><b>Total</b></font></td><td align=right><font size = 3><b>" . number_format($mtot, 2, ".", ",") . "</b></font></td></tr>";

            echo "</table>";
            ?>


    </body>
</html>
