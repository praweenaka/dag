<?php 	session_start();

if ($_SESSION["CURRENT_USER"]==""){
	exit("Please Login Again !!!");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Customer Master Report</title>
        <style>
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:14px;
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

            <!--
            .red {
                color: #FF0000;
                font-weight: bold;
                font-size: 12px;
            }
            -->
        </style>
    </head>

    <body>
        <!-- Progress bar holder -->


        <?php
        require_once("connectioni.php");
        
        

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");


            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
          

            echo "<center><table width=\"1000\" border=\"0\">
  <tr>
    
    <th colspan=\"4\" scope=\"col\">" . $rtxtComName . "</th>
   
  </tr>
  <tr>
   
    <td colspan=\"4\" align=\"center\">" . $rtxtcomadd1 . "</td>
   
  </tr>
  <tr>
    
    <td colspan=\"4\" align=\"center\">" . $rtxtComAdd2 . "</td>
   
  </tr>
  <tr>
    
	<td  width=\"600\" align=center><b>Customer Master Details</b></td>
    
   
  </tr>
  <tr>
    <td colspan=4>&nbsp;</td>
  </tr>
</table>";

            echo "<center><table width=1000 border=1>
		";


            echo "<center><table width=1000 border=1>";
            echo "
		<tr>
		<th>Customer Code</th>
		<th>Customer Name</th>
		<th>Address1</th>
		<th>Address2</th>
		<th>Telephone1</th>
		<th>Telephone2</th>
		<th>Contact Per</th>
		<th>Fax</th>
		<th>EMail</th>
		<th>Category</th>
		</tr>";

            $sql_cus = "select * from vendor group by CODE";
            $result_cus = mysqli_query($GLOBALS['dbinv'],$sql_cus);
			while ($row_cus = mysqli_fetch_array($result_cus)) {

            	echo "<tr><td>" . $row_cus["CODE"] . "</td>
				<td>" . $row_cus["NAME"] . "</td>
				<td>" . $row_cus["ADD1"] . "</td>
				<td>" . $row_cus["ADD2"] . "</td>
				<td>" . $row_cus["TELE1"] . "</td>
				<td>" . $row_cus["TELE2"] . "</td>
				<td>" . $row_cus["CONT"] . "</td>
				<td>" . $row_cus["FAX"] . "</td>
				<td>" . $row_cus["EMAIL"] . "</td>
				<td>" . $row_cus["CAT"] . "</td></tr>";

        	}
		 echo "</table>";
		
        
        ?>



    </body>
</html>
