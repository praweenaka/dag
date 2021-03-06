<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Purchase Return Report</title>

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
				border-top:none;
				border-bottom:none;
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

        $heading = "<center>Purchase Return Report From  " . $_GET["DT1"] . " To ". $_GET["DT2"] . " <br><br>";
        echo $heading;


        $sql = "SELECT sDATE, REFNO, SUP_CODE, SUP_NAME, STK_NO, DESCRIPT, REC_QTY, acc_COST, ORDNO from viewpurret where sDATE>='" . $_GET["DT1"] . "' AND sDATE<='" . $_GET["DT2"] . "'   AND CANCEL=0  order by REFNO";
      
        $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
        echo "<table border='1' ><tr> 
		<th><b>DATE</th> 
		<th><b>REF NO</th> 
		<th><b>ARN NO</th>
		<th><b>SUPPLIR</th>
		<th><b>STOCK NO</th>
		<th><b>DESCRIPTION</th>
		<th><b>QTY</th>
		<th><b>COST</th>
		</tr>";
		$tot=0;
        while ($row = mysqli_fetch_array($result)) {      
        	echo "<tr> 
			<td>" . $row['sDATE'] . "</td> 
			<td>" . $row['REFNO'] . "</td> 
			<td>" . $row['ORDNO'] . "</td> 
			<td>" . $row['SUP_CODE']." ".$row['SUP_NAME'] . "</td>  
			<td>" . $row['STK_NO'] . "</td> 
			<td>" . $row['DESCRIPT'] . "</td>  
			<td  align='right'> " . number_format($row['REC_QTY'], "0",".",",") . "</td>    
			<td  align='right'> " . number_format(($row['REC_QTY']*$row['acc_COST']), "2",".",",") . "</td>    
			
			</tr>";
        	$qty = $qty+($row['REC_QTY']);
         	$tot=$tot+($row['REC_QTY']*$row['acc_COST']);
        }
        
 echo "<tr> 
 	<th colspan=6></th><th align='right'><b>" . number_format($qty, "0",".",",")   . "</th> <th align='right'><b>" . number_format($tot, "2",".",",")   . "</th>   </tr>";

        echo "</table><br>";
        ?>



    </body>
</html>
