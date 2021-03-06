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

            <table width="760" border="0">
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
                
                $sql = "SELECT * from s_ginmas where tmp_no= '" . $_GET["tmp_no"] . "'";
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
                    <td width="114">To</td>
                    <td width="641"><?php echo $row1["DEP_T_NAME"]; ?></td>
                    <td>Date</td>
                    <td><?php echo $row1["SDATE"]; ?></td>
                </tr>
                <tr>
                     <td width="193"></td>
                    <td width="240"></td>
                    <td width="193"></td>
                    <td width="240"></td>
                </tr>
				 
                <tr>
                    <td colspan="4">
					<?php
				$ResponseXML ="<table  width='760' border='1' cellpadding='0' cellspacing='0'>
					<tr>
						<th width='100'>From Dep</th>
						<th width='40'>Item</th>
						<th width='400'>Description</th>
						<th width='50'>Qty</th>
						<th width='50'>Ref No</th>
					</tr>";

    $i = 1;
    $sql = "Select * from view_tmp_gin where tmp_no='" . $_GET['tmp_no'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'],$sql);
    while ($row = mysqli_fetch_array($result)) {

        $ResponseXML .= "<tr>                              
                         <td>" . $row['DESCRIPTION'] . "</td>
                         <td>" . $row['str_code'] . "</td>
                         <td>" . $row['str_description'] . "</td>
                         <td>" . number_format($row['cur_qty'], 0, ".", ",") . "</td>
                         <td>" . $row['str_invno'] . "</td>
                         </tr>";
        $i = $i + 1;
		
    }
	
		 
                $ResponseXML .= "   </table>"; 
				
				echo $ResponseXML;
				?>  
				</td>
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
