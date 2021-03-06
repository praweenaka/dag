<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print GIN</title>
        <style type="text/css">
            <!--
            .companyname {
                color: #0000FF;
                font-weight: bold;
                font-size: 25px;
            }

            .com_address {
                color: #000000;
                font-weight: bold;
                font-size: 19px;
            }

            .heading {
                color: #000000;
                font-weight: bold;
                font-size: 21px;
            }

            body {
                color: #000000;
                font-size: 18px;
            }


            -->
        </style>
    </head>

    <body><center>
            <?php
            require_once("connectioni.php");



            $sql_para = "select * from invpara";
            $result_para = mysqli_query($GLOBALS['dbinv'], $sql_para);
            $row_para = mysqli_fetch_array($result_para);
            ?>

            <table width="700" border="0">
                <tr>
                    <td colspan="5" align="center"><span class="companyname"><?php echo $row_para["COMPANY"]; ?></span></td>
                </tr>
                <tr>
                    <td colspan="5" align="center"><span class="com_address"><?php echo $row_para["ADD1"]; ?></span></td>
                </tr>
                <?php
                //echo $_GET["invno"];

                $sql = "SELECT * from viewstran where REFNO= '" . $_GET["invno"] . "'and LEDINDI='GINR' ";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                
                $sql = "SELECT * from s_ginmas where REF_NO= '" . $_GET["invno"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql);                
                $row1 = mysqli_fetch_array($result1);
                ?>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td width="193" align="center">    </td>
                    <td colspan="2" align="center"></td>
                </tr>
                <tr>
                    <th colspan="4" scope="col">Stock Transfer Note</th>
                </tr>
                <tr>
                    <td width="114">From</td>
                    <td width="641"><?php echo $row1["DEP_F_NAME"]; ?></td>
                    <td width="193">Ref No.</td>
                    <td width="240"><?php echo $row1["REF_NO"]; ?></td>
                </tr>
                <tr>
                    <td>To</td>
                    <td><?php echo $row1["DEP_T_NAME"]; ?></td>
                    <td>Date</td>
                    <td><?php echo $row1["SDATE"]; ?></td>
                </tr>

                <tr>
                    <td colspan="4"><table width="860" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <th width="100" scope="col">Code</th>
                                <th width="600" scope="col">Description</th>
                                <th width="150" scope="col">Part No</th>
                                <th width="100" height="22">Quantity</th>

                            </tr>
<?php
$tot = 0;
while ($row = mysqli_fetch_array($result)) {



    echo "<tr>
        		<td align=center>" . $row["STK_NO"] . "</td>
        		<td>" . $row["DESCRIPT"] . "</td>	
			<td align=center>" . $row["PART_NO"] . "</td>
        		<td align=right>" . number_format($row["QTY"], 0, ".", ",") . "</td>
        		 
        		</tr>";
    $tot=$tot+$row["QTY"];
}
?>

                            <tr>
                                <th width="170" scope="col" colspan="2"></th>

                                <th width="212" scope="col">Total</th>
                                <th width="212" scope="col"><?php echo $tot; ?></th>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>__________________________</td>
                    <td>&nbsp;</td>
                    <td>__________________________</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Prepared By</td>
                    <td>&nbsp;</td>
                    <td>Authorised By</td>
                </tr>
            </table>
    </body>
</html>
