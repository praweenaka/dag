<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Outstanding Statement</title>

<style>
table
{
border-collapse:collapse;
}
table, td, th
{
border:1px solid black;
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
font-size:14px;

}
</style>

</head>

<body>


<?php

    require_once("connectioni.php");
	
	
    
    $sql="delete from tmpcustomerout";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
	$sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center>";
		
	echo "<center><h3>Outstanding Statement As At: ".$_GET["dtddate"]."</h3><br>";
        
//	echo "<b>Customer :".$_GET["cuscode"]." - ".$_GET["cusname"]."</b>";
	
	if ($_SESSION['dev']=="1") {
		$sql_salma="select * from s_salma where (GRAND_TOT-TOTPAY)>1 and (SDATE<='".$_GET["dtddate"]."')  and CANCELL='0' order by SDATE";
	} else if ($_SESSION['dev']=="0") {
		$sql_salma="select * from s_salma where (GRAND_TOT-TOTPAY)>1 and (SDATE<='".$_GET["dtddate"]."') and DEV='0' and CANCELL='0' order by SDATE";
	}	
	//echo $sql_salma;
	$result_salma =mysqli_query($GLOBALS['dbinv'],$sql_salma);
	while($row_salma = mysqli_fetch_array($result_salma)){
		 
		 	$date1 = $row_salma["SDATE"];
			$date2 = date("Y-m-d");
			$diff = abs(strtotime($date2) - strtotime($date1));
			$days = floor($diff / (60*60*24));
			
		 $sql="insert into tmpcustomerout(REF_NO, SDATE, days, AMOUNT, paid, SAL_EX, barnd, REPNAME) value ('".$row_salma["REF_NO"]."', '".$row_salma["SDATE"]."', '".$days."', '".$row_salma["GRAND_TOT"]."', '".$row_salma["TOTPAY"]."', '".$row_salma["C_CODE"]."', '".$row_salma["Brand"]."', '".$row_salma["CUS_NAME"]."')";
                 $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	}

/*
if (($_GET["salesrep"] == "All") and ($_GET["brand"] == "All")) { $sql = "SELECT * from tmpcustomerout order by SDATE "; }
if (($_GET["salesrep"] == "All") and ($_GET["brand"] != "All")) { $sql = "SELECT * from tmpcustomerout where barnd='".$_GET["brand"]."' order by SDATE "; }
if (($_GET["salesrep"] != "All") and ($_GET["brand"] == "All")) { $sql = "SELECT * from tmpcustomerout where SAL_EX='".$_GET["salesrep"]."' order by SDATE "; }
if (($_GET["salesrep"] != "All") and ($_GET["brand"] != "All")) { $sql = "SELECT * from tmpcustomerout where barnd='".$_GET["brand"]."' and SAL_EX='".$_GET["salesrep"]."' order by SDATE "; }
*/
        
    echo "<table border=1 width=1000><tr>
		<th>Date</th><th>Inv No.</th><th>Cus.code</th><th>Customer</th><th>Days</th><th>Invoice Value</td><th>Outstanding</td><th>30 Days</th><th>60 Days</th><th>90 Days</th><th>90 Days</th><th>Over 120 Days</th></tr>";    
        
    $sqlOuter = "select distinct SAL_EX from tmpcustomerout";  
    $resultOuter =mysqli_query($GLOBALS['dbinv'],$sqlOuter) ; 
    
    while($rowOuter = mysqli_fetch_array($resultOuter)){
        $sql = "SELECT * from tmpcustomerout where SAL_EX = '".$rowOuter["SAL_EX"]."' order by SDATE";
        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
        $AMOUNT=0;
        $totbal=0;
        $belowA=0;
        $belowB=0;
        $belowC=0;
        $belowD=0;
        $overD=0;
  while ($rows = mysqli_fetch_array($result)){
  	
	
	$bal=$rows["AMOUNT"]-$rows["paid"];
        if ($bal>0.5){	
            echo "<tr>";
            echo "<td>".$rows["SDATE"]."</td>";
            echo "<td>".$rows["REF_NO"]."</td>";
            $days = $rows["days"];
            echo "<td align=\"right\">".$rows["SAL_EX"]."</td>";
            echo "<td align=\"right\">".$rows["REPNAME"]."</td>";
            echo "<td align=\"right\">".$days."</td>";
            echo "<td align=\"right\">".number_format($rows["AMOUNT"], 2, ".", ",")."</td>";
            echo "<td align=\"right\">".number_format($bal, 2, ".", ",")."</td>";
        
        if($days < 30){
            $belowA += $bal;
            echo "<td align=\"right\">".number_format($bal, 2, ".", ",")."</td>";
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">0.0</td>";
        }
	
        else if($days < 60){
            $belowB += $bal;
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">".number_format($bal, 2, ".", ",")."</td>";
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">0.0</td>";
        }
	
        else if($days < 90){
            $belowC += $bal;
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">".number_format($bal, 2, ".", ",")."</td>";
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">0.0</td>";
        }
	
        else if($days < 120){
            $belowD += $bal;
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">".number_format($bal, 2, ".", ",")."</td>";
            echo "<td align=\"right\">0.0</td>";
        }
	
        else if($days > 120){
            $overD += $bal;
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">0.0</td>";
            echo "<td align=\"right\">".number_format($bal, 2, ".", ",")."</td>";
        }
	
	echo "</tr>";
	$AMOUNT=$AMOUNT+$rows["AMOUNT"];
	$totbal=$totbal+$bal;
   }
  }
  
  echo "<tr>";
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "<td align=\"right\">&nbsp;</td>";
	echo "<td align=\"right\"><b>".number_format($AMOUNT, 2, ".", ",")."</b></td>";
	echo "<td align=\"right\"><b>".number_format($totbal, 2, ".", ",")."</b></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td align=\"right\"><b>".number_format($belowA, 2, ".", ",")."</b></td>";
	echo "<td align=\"right\"><b>".number_format($belowB, 2, ".", ",")."</b></td>";
	echo "<td align=\"right\"><b>".number_format($belowC, 2, ".", ",")."</b></td>";
	echo "<td align=\"right\"><b>".number_format($overC, 2, ".", ",")."</b></td>";
        echo "<td align=\"right\"><b>".number_format($belowD, 2, ".", ",")."</b></td>";
	echo "<td align=\"right\"><b>".number_format($overD, 2, ".", ",")."</b></td>";
	echo "</tr>"; 
    }            

    

 echo "<tr><td colspan=7>Please draw Account Payee cheques in favour of 'TYRE HOUSE TRADING (PVT) LTD.' 
Any discrepancies should be brought to the notice of  'TYRE HOUSE TRADING (PVT) LTD.' within 14 days from the date of Statement of Account.</br>
The Statement of Account will be considered accepted by you if discrepancies whatsoever is not reported within the said 14 working days.
The relevant Invoice Number should be quoted when making payment</td></table>";

 echo "</table>";
?>


</body>
</html>
