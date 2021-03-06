<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Weekly Target</title>
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
	font-size: 18px;
}

.heading {
	color: #000000;
	font-weight: bold;
	font-size: 20px;
}

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
                border:1px solid black;
                font-family:Arial, Helvetica, sans-serif;
                padding:4px;
            }
            th
            {
                font-weight:bold;
                font-size:14px;

            }
            td
            {
                font-size:14px;
				border-bottom:none;
				border-top:none;
            }

</style>
</head>

<body><center>
<p>
  <?php 
require_once("connectioni.php");
	
	
	
	$sql_para="select * from invpara";
	$result_para =mysqli_query($GLOBALS['dbinv'],$sql_para);
	$row_para = mysqli_fetch_array($result_para);
	
	$txtrepono= $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");





	$TXTHEAD0 = "Sales Plan From : " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "   To :  " . date("Y-m-d", strtotime($_GET["dtto"]));
	
	$sql_rep= "sELECT *  from s_salrep where REPCODE='".$_GET["Com_rep"]."' ";
	$result_rep =mysqli_query($GLOBALS['dbinv'],$sql_rep);	
	$row_rep = mysqli_fetch_array($result_rep);
	
	$TXTHEAD1 = "Sales Executive  - " . $row_rep["Name"];
	?>
</p>
<p><b><?php echo $TXTHEAD0; ?></b></p>
<p><?php echo $TXTHEAD1; ?></p>

    <table width="1000" border="1" cellpadding="0" cellspacing="0">
      <tr>
        
        <th width="200" scope="col">Dealer Code</th>
        <th width="600" scope="col">Dealer Name</th>
        <th width="170" scope="col">Target</th>
        <th width="170" scope="col">Achivement</th>
        <th width="150" height="22">Non Target </th>
        <th width="150" height="22">Balance</th>
      </tr>
     <?php
	 	$target=0;
		$target_achiv=0;
		$non_target_achiv=0;
		
	 	$sql_rsPrInv= "sELECT *  from week_tragets where rep='".$_GET["Com_rep"]."' and Tardate>='".$_GET["dtfrom"]."' and Tardate<='".$_GET["dtto"]."'";
		$result_rsPrInv =mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv);	
		while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)){
	 
      
	
        	echo "<td align=left>".$row_rsPrInv["cus_code"]."</td>";
			
			$sql_ven= "sELECT *  from vendor where CODE='".$row_rsPrInv["cus_code"]."'";
			$result_ven =mysqli_query($GLOBALS['dbinv'],$sql_ven);	
			$row_ven = mysqli_fetch_array($result_ven);
		
			echo "<td align=left>".$row_ven["NAME"]."</td>";
			
			if ($row_rsPrInv["Target"]==0){
       	 		echo "<td align=right></td>";
			} else {	
				echo "<td align=right>".$row_rsPrInv["Target"]."</td>";
				$Target=$Target+$row_rsPrInv["Target"];
			}	
			
			
			if ($row_rsPrInv["Sale"]==0){
       	 		echo "<td align=right></td>";
			} else {	
				echo "<td align=right>".$row_rsPrInv["Sale"]."</td>";
				$Sale=$Sale+$row_rsPrInv["Sale"];
			}	
			
			if (($row_rsPrInv["Target"]==0) and ($row_rsPrInv["Sale"]>0)){
       	 		echo "<td align=right>".$row_rsPrInv["Sale"]."</td>";
				$non_tar=$non_tar+$row_rsPrInv["Sale"];
			} else {	
				echo "<td align=right></td>";
			}	
						
			$bal=$row_rsPrInv["Target"]-$row_rsPrInv["Sale"];
			
			echo "<td align=right>".$bal."</td>";
			
			
      		echo "</tr>";
	  	
	  	}
	  
	  echo "<tr><th colspan=2>&nbsp;</th>";
	  echo "<th align=right><b>".number_format($Target, 2, ".", ",")."</b></th><th align=right><b>".number_format($Sale, 2, ".", ",")."</b></th><th align=right><b>".number_format($non_tar, 2, ".", ",")."</b></th><th align=right><b>".number_format($bal, 2, ".", ",")."</b></th>";
	  
	  $all_sale=$Sale+$non_tar;
      ?>
    </table>
<p><b>Traget Archivement = <?php echo number_format(($all_sale/$Target * 100), 2, ".", ","); ?>%</b></p>
</body>
</html>
