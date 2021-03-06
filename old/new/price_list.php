 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Price List</title>
            <link rel="stylesheet" href="css/bootstrap.min.css">
                <style>
                    body {
                        font-size:12px;
                    }
                    .red {
                        background-color:#FCCF50;
                    }
                </style>

        </head>

        <body>
            <center>
                <?php
     
                    include './connection_sql.php';

                    $sql = "select * from invpara";
                    $result_g = $conn->query($sql);
                    $row_g = $result_g->fetch();
                    echo "<h3>" . $row_g["COMPANY"] . "</h3>";
                    echo "<h5>Price List : "  .  $_GET['brand'] .  "</h5>";
                    ?>

                   <table  style=\"width: 300px;\" class="table table-bordered">
					<tr>
						<th style=\"width: 90px;\">Item Code</th>
						<th style=\"width: 250px;\">Description</th>
						<th colspan='2' style=\"width: 90px;\">Cat.</th>
						<th style=\"width: 80px;\">Selling</th> 
						<th style=\"width: 80px;\">Lock</th> 
						<th style=\"width: 80px;\">Tmp .Lock</th> 
					</tr>
					<?php
					$sql = "Select * from s_mas where brand_name='" . $_GET['brand'] . "'";
    
    foreach ($conn->query($sql) as $row) {
		
	 
		
        echo "<tr>                              
                         <td>" . $row['STK_NO'] . "</td>
                         <td>" . $row['DESCRIPT'] . "</td>
						 <td>" . $row['Cat1'] . "</td>
						 <td>" . $row['type'] . "</td>
                         <td align='right'>" . number_format($row['SELLING'], 2, ".", ",") . "</td>";
                              
							echo "<td>";  
							if ($row['active_t']=="1") {
							echo "Locked";	
							}	
							echo "</td>";
							
							echo "<td>";  
							if ($row['active_t1']=="1") {
							echo "Locked";	
							}	
							echo "</td>";
								
                      echo   "</tr>";
  
		
    }
					
				?>	
