<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Credit Limit Exceed Report</title>

        <style>
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:16px;
            }
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
                font-size:12px;

            }
            td
            {
                font-size:12px;
                border-bottom:dashed;
                border-width: thin;
                border-left:none;
                border-right:none;
            }
        </style>

    </head>

    <body>
        <center>

            <p>
                <?php
                require_once("connectioni.php");
                
                

                $sql = "delete from tmpcustomerout";
                $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 

                $sql_head = "select * from invpara";
                $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
                $row_head = mysqli_fetch_array($result_head);

                //////////////////////

                $sql = "delete from tmpcrlmtrep";
                $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 


                $sql = "select * from tmpcrlmt where sdate>='" . $_GET["dtfrom"] . "' and sdate<= '" . $_GET["dtto"] . "' ";
                $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
                while ($row = mysqli_fetch_array($result)) {

                    $sql_cus = "select * from vendor where CODE='" . trim($row["cusCode"]) . "'";
                    $result_cus = mysqli_query($GLOBALS['dbinv'],$sql_cus);
                    if ($row_cus = mysqli_fetch_array($result_cus)) {

                        $sql_tmp = "insert into tmpcrlmtrep (c_code, c_name, rep, username, tmpcrlmt, crlmt, cat, remark) VALUES('" . trim($row["cusCode"]) . "', '" . trim($row_cus["NAME"]) . "', '" . trim($row["Rep"]) . "', '" . trim($row["username"]) . "', " . $row["tmpLmt"] . " , " . $row["crLmt"] . ", '" . $row_cus["CAT"] . "', '" . $row["remark"] . "')";
                        $result_tmp = mysqli_query($GLOBALS['dbinv'],$sql_tmp);
                    }
                }

                $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");


                $txthead = " Credit Limit Exceed Summery  From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To  " . date("Y-m-d", strtotime($_GET["dtto"]));
                ?>
            </p>
            <table width="1000" border="0">
            <!--  <tr>
                <td colspan="6"><?php echo $rtxtComName; ?></td>
              </tr>
              <tr>
                <td colspan="6"><?php echo $rtxtcomadd1; ?></td>
                
              </tr>
              <tr>
                <td colspan="6"><?php echo $rtxtComAdd2; ?></td>
               
              </tr> -->
                <tr>
                    <th colspan="6"><b><?php echo $txthead; ?></b></th>

                </tr>
                <tr>     </tr>

            </table>
                    <table width="1000" border="1">
                            <tr>
                                <td ><b>Customer</b></td>
                                <td ><b>User</b></td>
                                <td ><b>Rep</b></td>
                                <td ><b>Cat.</b></td>
                                <td ><b>Credit Lmt</b></td>
                                <td ><b>Temp. Lmt</b></td>
                                <td ><b>Total  Outsanding</b></td>
                                <td ><b>Remarks</b></td>
                                <td ><b>Signature.</b></td>
                            </tr>
<?php
$sql = "Select * from tmpcrlmtrep";
$result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>
        <td>" . $row["c_code"] . "&nbsp;&nbsp;&nbsp; " . $row["c_name"] . "</td>
        <td>" . $row["username"] . "</td>
        <td>" . $row["rep"] . "</td>
        <td>" . $row["cat"] . "</td>
        <td>" . number_format($row["crlmt"], "2", ".", ",")   . "</td>
        <td>" . number_format($row["tmpcrlmt"], "2", ".", ",")     . "</td>";

    $outstand = 0;
    if (trim($row["cat"]) == "A") {
        $outstand = $row["crlmt"] * 2.5 + $row["tmpcrlmt"];
    } else if (trim($row["cat"]) == "B") {
        $outstand = $row["crlmt"] * 2.5 + $row["tmpcrlmt"];
    } else if (trim($row["cat"]) == "C") {
        $outstand == $row["crlmt"] + $row["tmpcrlmt"];
    }

    echo "<td>" . number_format($outstand, "2", ".", ",")  . "</td><td></td>";
    echo " <td>" . $row["remark"] . "</td>
       
      </tr>";
}
?> 

                        <th colspan='9'></th> 

                        </table></td>
           
            <p>&nbsp;</p>
    </body>
</html>
