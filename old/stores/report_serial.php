<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Serial Report</title>

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
		<center>
        <?php
        require_once("connectioni.php");
        
        









        $sql_head = "select * from invpara";
        $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
        $row_head = mysqli_fetch_array($result_head);

	if (trim($_GET["txtseri"])!=""){
        $sql = "SELECT * from inv_serino where serino='" . trim($_GET["txtseri"]) . "' order by id desc"; 
        $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
		if ($row = mysqli_fetch_array($result)){
			
			$sql1 = "SELECT * from s_salma where REF_NO='" . $row["refno"] . "' ";
        	$result1 = mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			$row1 = mysqli_fetch_array($result1);
			
        	echo "<table border='1' width=800 >
			<tr><td width='200'><b>Invoice No</b></td><td>".$row1["REF_NO"]."</td></tr> 
			<tr><td><b>Invoice Date</b></td><td>".$row1["SDATE"]."</td></tr> 
			<tr><td><b>Delivery Date</b></td><td>".$row1["deli_date"]."</td></tr> 
			<tr><td><b>Cus No</b></td><td>".$row1["C_CODE"]."</td></tr>
			<tr><td><b>Cus Name</b></td><td>".$row1["CUS_NAME"]."</td></tr>
			<tr><td><b>Vehicle No</b></td><td>".$row1["veheno"]."</td></tr>
			<tr><td><b>Driver</b></td><td>".$row1["driver"]."</td></tr>
        	<tr><td><b>Serial Date Time</b></td><td>".$row["seri_datetime"]."</td></tr>";
		
         
        }
        
        echo "</table><br>";
	} else 	if (trim($_GET["txtinvno"])!=""){
			
			$sql1 = "SELECT * from s_salma where REF_NO='" . trim($_GET["txtinvno"]) . "' ";
        	$result1 = mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			$row1 = mysqli_fetch_array($result1);
			
        	echo "<table border='0' width=800 >
			<tr><td width='200'><b>Invoice No</b></td><td>".$row1["REF_NO"]."</td><td><b>Delivery Date</b></td><td>".$row1["deli_date"]."</td></tr> 
			<tr><td><b>Invoice Date</b></td><td>".$row1["SDATE"]."</td><td><b>Vehicle No</b></td><td>".$row1["veheno"]."</td></tr> 
			<tr><td><b>Cus No</b></td><td>".$row1["C_CODE"]."</td><td><b>Driver</b></td><td>".$row1["driver"]."</td></tr>
			<tr><td><b>Cus Name</b></td><td>".$row1["CUS_NAME"]."</td></tr></tr>";
			echo "<table border='1' width=800 >
				<tr><td width='200'><b>Stk No</b></td>
				<td width='200'><b>Serial No</b></td>
				<td width='200'><b>Date Time</b></td></tr>";
			
			$sql = "SELECT * from inv_serino where refno='" . trim($_GET["txtinvno"]) . "' ";
        	$result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
			while ($row = mysqli_fetch_array($result)){
			
        		echo "<tr><td >".$row["stk_no"]."</td><td>".$row["serino"]."</td><td>".$row["seri_datetime"]."</td></tr>";
        	
        	}
        
        	echo "</table><br>";
		 
	}
	
		
        ?>



    </body>
</html>
