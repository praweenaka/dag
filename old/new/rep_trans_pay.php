<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print Invoice</title>
        <style type="text/css">
            <!--
            .style2 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 15px;
            }
            -->
        </style>
    </head>

    <body><center>
            <?php
            require_once("connectioni.php");

 
            $sql_para = "Select * from invpara ";
            $result_para = mysqli_query($GLOBALS['dbinv'], $sql_para);
            $row_para = mysqli_fetch_array($result_para);

         
 
            

            $sql2 = "Select * from s_salma where trans_no='" . $_GET["ref_no"] . "' and cancell='0'";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
            $row2 = mysqli_fetch_array($result2);
 
            ?>

            <table width="922" height="434" border="0">
                <tr> 
                    <td colspan="2" align="left"><strong style="font-size: 30px;">Transport Payment Approval</strong></td>
                </tr>
                <tr>

                    <td height="21" colspan="4"><span class="style2"</td>
                    <td height="21">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>

 

                <tr>
                    <td height="21">Date</td>
                    <td height="21" colspan="4"><span class="style2"><?php  echo $row2["transdate"]; ?></span></td> 
                </tr>
                <tr>
                    <td height="21">Dealer :</td>
                    <td height="21" colspan="1"><span class="style2"><?php  echo $row2["C_CODE"].'-'.$row2["CUS_NAME"]; ?></span></td> 
               </tr>
               <tr>
                    <td height="21">Town :</td>
                    <td height="21" colspan="1"><span class="style2"><?php  echo $row2["C_ADD1"]; ?></span></td> 
               </tr>
                 
                <tr>

                    <td height="21" colspan="4"><span class="style2"</td>
                    <td height="21">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>

 
                <tr>

                    <td height="21" colspan="4"><span class="style2"><b>Transport Invoice Details </span></td>
                    <td height="21">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>
 
 
                <tr>
                    <td height="56" colspan="7"><table width="904" height="31" border="1" cellspacing="0">
                            <tr >
                                <td width="10" height="13"></td>
                                 <td width="80" height="13"><span class="style1">Inv.Date</span></td>
                                <td width="120"><span class="style1">Inv.No</span></td> 
                                <td width="100"><span class="style1">Deliver Value</span></td>
                                <td width="100"><span class="style1">Transport Fee</span></td> 
                            </tr>  
                            <?php
                            $i = 1;
                            $fee = 0;

                            $sql1 = "SELECT * from s_salma where trans_no='" . $_GET["ref_no"] . "' and cancell='0' and trans_cancell='0' and transamou!='0.00'  ";
                            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                            while ($row1 = mysqli_fetch_array($result1)) {
                                 
                                echo "<tr><td width=10 align=\"right\"><span class=\"style2\">" . $i. "</span></td>
                                <td width=100 align=\"left\"><span class=\"style2\">" . $row1["SDATE"] . "</span></td>
                                <td width=100 align=\"left\"><span class=\"style2\">" . $row1["REF_NO"] . "</span></td> 
                                <td width=100 align=\"right\"><span class=\"style2\">" . $row1["transamou"] . "</span></td>
                                <td width=100 align=\"right\"><span class=\"style2\">" . $row1["trans_thtamou"] . "</span></td>
				                </tr>";
 
                                $i = $i + 1;
                                $fee = $fee+ $row1["trans_thtamou"];
                            }   
                            echo "<tr> 
                                <td colspan=\"4\"align=\"right\"><span class=\"style2\"></span></td> 
                                <td width=100 align=\"right\"><span class=\"style2\">" . number_format($fee,'2') . "</span></td>
                                </tr>";
                            ?>


                        </table>



                    </td>
                </tr>
                 
                 <tr>
                    <td height="2" colspan="6">Only 50% From Transport Fee Will Pay By THT</td>
                </tr>
                  <tr>
                    <td height="2" colspan="6">&nbsp;</td> 
                </tr>
                <tr>
                    <td height="2" style="width: 200px">Stores Confirmation  :</td>
                     <td height="2"  >____________________</td>
                </tr>
                <tr>
                    <td height="2" style="width: 200px">Checked For Payment :</td>
                    <td height="2"  >____________________</td>
                </tr>
                 <tr>
                    <td height="2" style="width: 200px">Journal No  :</td>
                    <td height="2"  >____________________</td>
                </tr>
                
            </table>
    </body>
</html>
