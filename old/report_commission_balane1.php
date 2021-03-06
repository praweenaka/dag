<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print Balance Commission</title>
        <style type="text/css">
            <!--
            .companyname {
                color: #0000FF;
                font-weight: bold;
                font-size: 24px;
            }

            .com_address {
                color: #000000;
                font-weight: bold;
                font-size: 22px;
            }

            .heading {
                color: #000000;
                font-weight: bold;
                font-size: 20px;
            }

            body {
                color: #000000;
                font-size: 16px;
            }
            .style1 {
                font-size: 18px;
                font-weight: bold;
            }
			
			.style2 {
                font-size: 18px;
                font-weight: bold;
				color:#FF0000;
            }


            -->
        </style>
    </head>

    <body><center>
            <?php
            require_once("connectioni.php");
            
            
			
			$sql_head="select * from invpara";
			$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
			$row_head = mysqli_fetch_array($result_head);

        
////////////////
	$txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");


	$txtcom= $row_head["COMPANY"];
	$txtrep = $_GET["salrep"];
	$txtmonth = date("M", strtotime($_GET["dtMonth"])) . " / " . date("Y", strtotime($_GET["dtMonth"]));


	$sql_rs = "select * from s_commadva where refno='" . $_GET["refno"] . "'";
	$result_rs =mysqli_query($GLOBALS['dbinv'],$sql_rs);
	$row_rs = mysqli_fetch_array($result_rs);
	
	$m_com = 0;
	$m_com1 = 0;
	$m_com2 = 0;
	$m_com3 = 0;
	$m_grn = 0;
	
	$sql_salrep = "select * from s_salrep where REPCODE='" . $_GET["salrep"] . "'";
	$result_salrep =mysqli_query($GLOBALS['dbinv'],$sql_salrep);
	if ($row_salrep = mysqli_fetch_array($result_salrep)){ $txtrep = $row_salrep["Name"]; }
		

	$txtmonth = date("M/Y", strtotime($row_rs["comdate"]));

	$txtsale1 = $row_rs["Sale_tyre"];
	$txtsale2 = $row_rs["Sale_battery"];
	$txtsale3 = $row_rs["Sale_AW"];
	$txtComsale1 = $row_rs["Com_tyre"];
	$txtComsale2 = $row_rs["Com_battery"];
	$txtComsale3 = $row_rs["Com_AW"];

	$txtpr4 = $row_rs["Over60Ratio"];
	$txtsale4 = $row_rs["Over60out"];
	$txtNoComCOm=$row_rs["Com_tube"];

	if (is_null($row_rs["Com_tyre"])==false) { $m_com = $row_rs["Com_tyre"]; }
	if (is_null($row_rs["Com_battery"])==false) { $m_com1 = $row_rs["Com_battery"]; }
	if (is_null($row_rs["Com_AW"])==false) { $m_com2 = $row_rs["Com_AW"]; }
	if (is_null($row_rs["Com_tube"])==false) { $m_com3 = $row_rs["Com_tube"]; }


	
	$txtComsale = $m_com + $m_com1 + $m_com2 + $m_com3;
	$gros_sale=$txtComsale;

	$txtgrn = $row_rs["Dedamount6"];
	if (is_null($row_rs["Dedamount7"])==false) { $m_grn = $row_rs["Dedamount7"]; }
	$txtcomGrn = $m_grn;

	$txtrtn= $row_rs["Returnchk"];

	$txtBalCom = $m_com + $m_com1 + $m_com2 + $m_com3 - $m_grn;

	if (is_null($row_rs["Dedcap1"])==false) { $txtdes1 = $row_rs["Dedcap1"]; }
	if (is_null($row_rs["Dedcap2"])==false) { $txtdes2 = $row_rs["Dedcap2"]; }
	if (is_null($row_rs["Dedcap3"])==false) { $txtdes3 = $row_rs["Dedcap3"]; }
	if (is_null($row_rs["Dedcap4"])==false) { $txtdes4 = $row_rs["Dedcap4"]; }
	if (is_null($row_rs["Dedcap5"])==false) { $txtdes5 = $row_rs["Dedcap5"]; }
	
	if (is_null($row_rs["Dedamount1"])==false) { $txtded1 = $row_rs["Dedamount1"] * -1; }
	if (is_null($row_rs["Dedamount2"])==false) { $txtded2 = $row_rs["Dedamount2"] * -1; }
	if (is_null($row_rs["Dedamount3"])==false) { $txtded3 = $row_rs["Dedamount3"] * -1; }
	if (is_null($row_rs["Dedamount4"])==false) { $txtded4 = $row_rs["Dedamount4"] * -1; }
	if (is_null($row_rs["Dedamount5"])==false) { $txtded5 = $row_rs["Dedamount5"] * -1; }
	

	$txtnet = $row_rs["advance"] - $row_rs["ded"];
	if (is_null($row_rs["CHEQ_Date"])==false) {
   		$txtchq = trim($row_rs["remark"]) . "-" . trim($row_rs["chno"]) . " " . date("Y-m-d", strtotime($row_rs["CHEQ_Date"])) . " " . "-" . trim($row_rs["Bank"]) . "-" . trim($row_rs["PCHNO"]);
	} else {
   		$txtchq = trim($row_rs["remark"]) . "-" . trim($row_rs["chno"]) . "-" . trim($row_rs["Bank"]) . "-" . trim($row_rs["PCHNO"]);
	}
            ?>
			
            
            
            <?php echo $txtdev; ?>
            <table width="770" border="0">
          <tr>
                    <td colspan="5" align="center"><span class="companyname"><?php echo $txtcom; ?></span></td>
                </tr>
                <tr><td><span class="com_address">Marketing Rep/Executive </td>
                <?php
				//	$sql_rep="select * from s_salrep where REPCODE=".$txtrep;
				//	$result_rep =mysqli_query($GLOBALS['dbinv'],$sql_rep);
				//	$row_rep = mysqli_fetch_array($result_rep);
				
				?>
                    <td colspan="4" align="left"><span class="com_address"><?php echo $txtrep; ?></span></td>
                </tr>
                <?php
//echo $_GET["invno"];

                $sql = "Select * from s_purmas where REFNO='" . $_GET["invno"] . "'";
                $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
                $row = mysqli_fetch_array($result);

                $sql1 = "Select * from vendor where CODE='" . $row["SUP_CODE"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'],$sql1) ; 
                $row1 = mysqli_fetch_array($result1);

                $sql2 = "Select * from viewarn where REFNO='" . $_GET["invno"] . "' order by ID";
//echo $sql2;
                $result2 = mysqli_query($GLOBALS['dbinv'],$sql2) ; 
                ?>



                <tr>
                    <td><span class="style1">Month</span></td>
                    <td colspan="3"><span class="style1"><?php echo $txtmonth; ?></span></td>
                </tr>

                <tr>
                    <th colspan="2" scope="col">&nbsp;</th>
                    <th align="center" ></th>
                    <th align="center" ></th>
                </tr>
                <tr>
                    <th colspan="2" scope="col">&nbsp;</th>
                    <th align="center" >Sales</th>
                    <th align="center" >Commission</th>
                    </tr>
                    <tr>






                        <?php // echo number_format($Text26, 0, ".", ","); ?>
                        <td width="281">Category 1</td>
                      <td align="center" width="182"></td>
                      <td align="right" width="122"><?php if ($txtsale1!=""){ echo number_format($txtsale1, 2, ".", ","); }?></td>
                      <td align="right" width="167"><?php if ($txtComsale1!=""){ echo number_format($txtComsale1, 2, ".", ","); }?></td>
              </tr>
                    <tr>
                        <td>Category 1 (Over 60)</td>
                        <td align="center"></td>
                        <td align="right"><?php if ($txtsale2!=""){ echo number_format($txtsale2, 2, ".", ","); }?></td>
                        <td align="right"><?php if ($txtComsale2!=""){ echo number_format($txtComsale2, 2, ".", ","); }?></td>
                    </tr>
                    <tr>
                        <td>Category 2</td>
                        <td align="center"></td>
                        <td align="right"><?php if ($txtsale3!=""){ echo number_format($txtsale3, 2, ".", ","); }?></td>
                        <td align="right"><?php if ($txtComsale3!=""){ echo number_format($txtComsale3, 2, ".", ","); }?></td>
                    </tr>

                    <tr>
                        <td><?php echo $txtAdd; ?></td>
                        <td align="center"></td>
                        <td align="right"></td>
                        <td align="right"><?php  echo $txtaddAmt; ?></td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>



                    <tr>
                        <td colspan="2">&nbsp;</td>

                        <td  align="right"></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><span class="style1">No Commission</span></td>
                        <td><?php echo number_format($txtpr4, 2, ".", ","); ?>%</td>
                        <td  align="right"><b>
                            <?php
                            $txtnetsale = str_replace(",", "", $_GET['txtnetsale']);
                            $txtcat1sale = str_replace(",", "", $_GET['txtcat1sale']);
                            $txtcat1Spsale = str_replace(",", "", $_GET['txtcat1Spsale']);
                            $txtcat2sale = str_replace(",", "", $_GET['txtcat2sale']);
                            $nosale = $txtnetsale - $txtcat1sale - $txtcat1Spsale - $txtcat2sale;
                            ?>          
                            <?php if ($txtsale4!=""){ echo number_format($txtsale4, "2", ".", ","); }?>                    </b>    </td>
                        <td  align="right"><?php if ($txtNoComCOm!=""){ echo number_format($txtNoComCOm, 2, ".", ","); }?></td>
                    </tr>

                    <tr>
                        <td width="281">&nbsp;</td>
                      <td align="center" width="182"><span class="style1"><?php echo $txttyre; ?></span></td>
                      <td align="right" width="122"><?php if ($txttyresale!=""){ echo number_format($txttyresale, 0, ".", ","); }?></td>
                      <td align="right" width="167"><?php if ($Text26!=""){ echo number_format($Text26, 0, ".", ","); }?></td>
              </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td align="center"><span class="style1"><?php echo $txtbattery; ?></span></td>
                        <td align="right"><?php if ($txtBatsale!=""){ echo number_format($txtBatsale, 0, ".", ","); }?></td>
                        <td align="right"><?php if ($Text27!=""){ echo number_format($Text27, 0, ".", ","); }?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td align="center"><span class="style1"><?php echo $txtalloy; ?></span></td>
                        <td align="right"><?php if ($TxtAWsale!=""){ echo number_format($TxtAWsale, 0, ".", ","); }?></td>
                        <td align="right"><?php if ($Text28!=""){ echo number_format($Text28, 0, ".", ","); }?></td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td align="center"><span class="style1"><?php echo $txttube; ?></span></td>
                        <td align="right"><?php if ($Txttubesale!=""){  echo number_format($Txttubesale, 0, ".", ","); }?></td>
                        <td align="right"><?php if ($Text29!=""){ echo number_format($Text29, 0, ".", ","); }?></td>
                    </tr>    




                    <tr>
                        <td colspan="2"><span class="style1">Gross Sales Commission</span></td>
                        <td align="right">&nbsp;</td>
                        <td align="right"><span class="style1"><?php if ($gros_sale!=""){ echo number_format($gros_sale, 2, ".", ","); }?></span></td>
                    </tr>

                    <tr>
                        <td colspan="2"><span class="style1">&nbsp;</span></td>
                        <td align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>    

                    <tr>
                        <td colspan="2">Less Comm. For GRN</td>
                        <td align="right"> <?php if ($txtgrn!=""){ echo $txtgrn; }?></td>
                        <td align="right"><?php if ($txtComGRN!=""){ echo "(".number_format($txtComGRN, 2, ".", ",").")"; }?></td>
                    </tr>



                    <tr>
                        <td colspan="2">Less Comm. For Return Cheque</td>
                        <td align="right"><?php if ($txtrtn!=""){ echo $txtrtn; }?></td>
                        <td align="right"><?php if ($txtcomRetCh!=""){ echo $txtcomRetCh; }?></td>
                    </tr>

                    <tr>
                        <td colspan="2">Balance Commission</td>
                        <td align="right">&nbsp;</td>
                        <td align="right"><span class="style1"><?php if ($txtBalCom!=""){ echo number_format($txtBalCom, 2, ".", ","); }?></span></td>
                    </tr>      

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>


                    <tr>
                        <td><span class="style1">Deductions</span></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>    

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>     

                    <tr>
                        <td><?php echo $txtdes1; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td  align="right"><?php if ($txtded1!=""){ echo "(".number_format($txtded1, 2, ".", ",").")"; }?> </td>
                    </tr>

                    <tr>
                        <td><?php echo $txtdes2; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td  align="right"><?php if ($txtded2!=""){ echo "(".number_format($txtded2, 2, ".", ",").")"; }?></td>
                    </tr>    

                    <tr>
                        <td><?php echo $txtdes3; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td  align="right"><?php if ($txtded3!=""){ echo "(".number_format($txtded3, 2, ".", ",").")"; }?></td>
                    </tr>    

                    <tr>
                        <td><?php echo $txtdes4; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td  align="right"><?php if ($txtded4!=""){ echo "(".number_format($txtded4, 2, ".", ",").")"; }?></td>
                    </tr>                     

                    <tr>
                        <td><?php echo $txtdes5; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td  align="right"><?php if ($txtded4!=""){ echo "(".number_format($txtded5, 2, ".", ",").")"; }?> </td>
                    </tr> 


                    <tr>
                      <td><span class="style1">Balance Commission Payable</span> </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="right"><span class="style1"><u><?php echo $txtnet; ?></u></span></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="3"><span class="style2"><?php echo $txtchq; ?></span></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Checked By</td>
                        <td>&nbsp;</td>
                        <td>Authorized By:</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><?php echo $txtrepono; ?></td>
                        <td>&nbsp;</td>
                        <td>Approved By:</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
            </table>
</body>
</html>
