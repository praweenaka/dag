<?php ini_set('session.gc_maxlifetime', 30*60*60*60);
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stock Moving Report</title>

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
font-size:12px;

}
td
{
font-size:11px;

}
</style>

</head>

<body>
 <!-- Progress bar holder -->
<div id="progress" style="width:500px;border:1px solid #ccc;"></div>
<!-- Progress information -->
<div id="information" style="width"></div>

<?php

    require_once("connectioni.php");
	
	
    
    $sql="delete from tmpstkmve";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
	

 $m1=0;
 $m2=0;
 $m3=0;
 $m4=0;
 $m5=0;
 $m6=0;
 $m7=0;
 $m8=0;
 $m9=0;
 $m10=0;
 $m11=0;
 $m12=0;
 



 


 

if ($_GET["brand"]!="All")
	{	$sql="select * from s_mas where BRAND_NAME='".$_GET["brand"]."' ";
		$sqlcount="select count(*) as mcou from s_mas where BRAND_NAME='".$_GET["brand"]."' ";
	} 
else
	{	$sql="select * from s_mas order by BRAND_NAME";
		$sqlcount="select count(*) as mcou from s_mas";
	} 
	
	
	// Total processes
	$resultcou =mysqli_query($GLOBALS['dbinv'],$sqlcount);
	$rowcou = mysqli_fetch_array($resultcou);
	$total = $rowcou["mcou"];
	
	$i=1;
	
	$mydate=$_GET["dte_to"];
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	while($row = mysqli_fetch_array($result)){
		
/*		$percent = intval($i/$total * 100)."%";
 
    // Javascript for updating the progress bar and information
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="'.$i.' row(s) processed.";
    </script>';
 
    // This is for the buffer achieve the minimum size in order to flush data
    echo str_repeat(' ',1024*64);
 
    // Send output to browser immediately
    flush();*/
 
    // Sleep one second so we can see the delay
   // sleep(1);
		
	//	$i=$i+1;
	
		$month = date("m",strtotime($mydate));
		
		if ($month==12){
			$m1 = $row["SALE01"];
        	$m2 = $row["SALE02"];
        	$m3 = $row["SALE03"];
        	$m4 = $row["SALE04"];
        	$m5 = $row["SALE05"];
        	$m6 = $row["SALE06"];
        	$m7 = $row["SALE07"];
        	$m8 = $row["SALE08"];
        	$m9 = $row["SALE09"];
        	$m10 = $row["SALE10"];
       	 	$m11 = $row["SALE11"];
        	$m12 = $row["SALE12"];
		}
		
		if ($month==11){
			$m1 = $row["SALE12"];
        	$m2 = $row["SALE01"];
        	$m3 = $row["SALE02"];
        	$m4 = $row["SALE03"];
        	$m5 = $row["SALE04"];
        	$m6 = $row["SALE05"];
        	$m7 = $row["SALE06"];
        	$m8 = $row["SALE07"];
        	$m9 = $row["SALE08"];
        	$m10 = $row["SALE09"];
       	 	$m11 = $row["SALE10"];
        	$m12 = $row["SALE11"];
		}
		
		if ($month==10){
			$m1 = $row["SALE11"];
        	$m2 = $row["SALE12"];
        	$m3 = $row["SALE01"];
        	$m4 = $row["SALE02"];
        	$m5 = $row["SALE03"];
        	$m6 = $row["SALE04"];
        	$m7 = $row["SALE05"];
        	$m8 = $row["SALE06"];
        	$m9 = $row["SALE07"];
        	$m10 = $row["SALE08"];
       	 	$m11 = $row["SALE09"];
        	$m12 = $row["SALE10"];
		}
		
		if ($month==9){
			$m1 = $row["SALE10"];
        	$m2 = $row["SALE11"];
        	$m3 = $row["SALE12"];
        	$m4 = $row["SALE01"];
        	$m5 = $row["SALE02"];
        	$m6 = $row["SALE03"];
        	$m7 = $row["SALE04"];
        	$m8 = $row["SALE05"];
        	$m9 = $row["SALE06"];
        	$m10 = $row["SALE07"];
       	 	$m11 = $row["SALE08"];
        	$m12 = $row["SALE09"];
		}
		
		if ($month==8){
			$m1 = $row["SALE09"];
        	$m2 = $row["SALE10"];
        	$m3 = $row["SALE11"];
        	$m4 = $row["SALE12"];
        	$m5 = $row["SALE01"];
        	$m6 = $row["SALE02"];
        	$m7 = $row["SALE03"];
        	$m8 = $row["SALE04"];
        	$m9 = $row["SALE05"];
        	$m10 = $row["SALE06"];
       	 	$m11 = $row["SALE07"];
        	$m12 = $row["SALE08"];
		}
		
		if ($month==7){
			$m1 = $row["SALE08"];
        	$m2 = $row["SALE09"];
        	$m3 = $row["SALE10"];
        	$m4 = $row["SALE11"];
        	$m5 = $row["SALE12"];
        	$m6 = $row["SALE01"];
        	$m7 = $row["SALE02"];
        	$m8 = $row["SALE003"];
        	$m9 = $row["SALE004"];
        	$m10 = $row["SALE05"];
       	 	$m11 = $row["SALE06"];
        	$m12 = $row["SALE07"];
		}
		
		if ($month==6){
			$m1 = $row["SALE07"];
        	$m2 = $row["SALE08"];
        	$m3 = $row["SALE09"];
        	$m4 = $row["SALE10"];
        	$m5 = $row["SALE11"];
        	$m6 = $row["SALE12"];
        	$m7 = $row["SALE01"];
        	$m8 = $row["SALE02"];
        	$m9 = $row["SALE03"];
        	$m10 = $row["SALE04"];
       	 	$m11 = $row["SALE05"];
        	$m12 = $row["SALE06"];
		}
		
		if ($month==5){
			$m1 = $row["SALE06"];
        	$m2 = $row["SALE07"];
        	$m3 = $row["SALE08"];
        	$m4 = $row["SALE09"];
        	$m5 = $row["SALE10"];
        	$m6 = $row["SALE11"];
        	$m7 = $row["SALE12"];
        	$m8 = $row["SALE01"];
        	$m9 = $row["SALE02"];
        	$m10 = $row["SALE03"];
       	 	$m11 = $row["SALE04"];
        	$m12 = $row["SALE05"];
		}
		
		if ($month==4){
			$m1 = $row["SALE05"];
        	$m2 = $row["SALE06"];
        	$m3 = $row["SALE07"];
        	$m4 = $row["SALE08"];
        	$m5 = $row["SALE09"];
        	$m6 = $row["SALE10"];
        	$m7 = $row["SALE11"];
        	$m8 = $row["SALE12"];
        	$m9 = $row["SALE01"];
        	$m10 = $row["SALE02"];
       	 	$m11 = $row["SALE03"];
        	$m12 = $row["SALE04"];
		}
		
		if ($month==3){
			$m1 = $row["SALE04"];
        	$m2 = $row["SALE05"];
        	$m3 = $row["SALE06"];
        	$m4 = $row["SALE07"];
        	$m5 = $row["SALE08"];
        	$m6 = $row["SALE09"];
        	$m7 = $row["SALE10"];
        	$m8 = $row["SALE11"];
        	$m9 = $row["SALE12"];
        	$m10 = $row["SALE01"];
       	 	$m11 = $row["SALE02"];
        	$m12 = $row["SALE03"];
		}
		
		if ($month==2){
			$m1 = $row["SALE03"];
        	$m2 = $row["SALE04"];
        	$m3 = $row["SALE05"];
        	$m4 = $row["SALE06"];
        	$m5 = $row["SALE07"];
        	$m6 = $row["SALE08"];
        	$m7 = $row["SALE09"];
        	$m8 = $row["SALE10"];
        	$m9 = $row["SALE11"];
        	$m10 = $row["SALE12"];
       	 	$m11 = $row["SALE01"];
        	$m12 = $row["SALE02"];
		}
		
		if ($month==1){
			$m1 = $row["SALE02"];
        	$m2 = $row["SALE03"];
        	$m3 = $row["SALE04"];
        	$m4 = $row["SALE05"];
        	$m5 = $row["SALE06"];
        	$m6 = $row["SALE07"];
        	$m7 = $row["SALE08"];
        	$m8 = $row["SALE09"];
        	$m9 = $row["SALE10"];
        	$m10 = $row["SALE11"];
       	 	$m11 = $row["SALE12"];
        	$m12 = $row["SALE01"];
		}
		
		if ($_SESSION['dev']=='1'){
			$totcost=$row["QTYINHAND"] * $row["COST"];
		}else if ($_SESSION['dev']=='0'){
			$totcost=$row["QTYINHAND"] * $row["acc_cost"];
		}	
			
		 $sql1="Insert into tmpstkmve (STK_NO,BRAND_NAME,DESCRIPT,QTYINHAND,totcost,PART_NO,m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12 ) values('".$row["STK_NO"]."', '".$row["BRAND_NAME"]."', '".$row["DESCRIPT"]."', ".$row["QTYINHAND"].", ".$totcost.", '".$row["PART_NO"]."', ". $m1.", ".$m2.", ".$m3.", ".$m4.", ".$m5.", ".$m6.", ".$m7.", ".$m8.", ".$m9.", ".$m10.", ".$m11.", ".$m12.")";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
	
	}

// Tell user that the process is completed
/*echo '<script language="javascript">document.getElementById("information").innerHTML="Process completed"</script>';
echo '<script language="javascript">document.getElementById("progress").innerHTML=""</script>';
echo '<script language="javascript">document.getElementById("information").innerHTML=""</script>';*/

	$sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
		
		$heading="Stock Moving From ".$_GET["dte_from"]." to ".$_GET["dte_to"]." Brand ".$_GET["brand"];
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
	echo "<center><table border=1><tr><td>Item No</td><td>Description</td><td>AR_No</td><td>AR_QTY</td>";
	
		if ($month==12){
			echo "<th>Jan</th>";
			echo "<th>Feb</th>";
			echo "<th>Mar</th>";
			echo "<th>Apr</th>";
			echo "<th>May</th>";
			echo "<th>Jun</th>";
			echo "<th>Jul</th>";
			echo "<th>Aug</th>";
			echo "<th>Sep</th>";
			echo "<th>Oct</th>";
			echo "<th>Nov</th>";
			echo "<th>Dec</th>";
		}
		
		if ($month==1){
			
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
		}
		
		if ($month==2){
			
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
		}
		
		if ($month==3){
			
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
		}
		
		if ($month==4){
			
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
		}
		
		if ($month==5){
			
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
		}
		
		if ($month==6){
			
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
		}
		
		if ($month==7){
			
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
		}
		
		
		if ($month==8){
			
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
		}
		
		if ($month==9){
			
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
		}
		
		if ($month==10){
			
			echo "<td>Nov</td>";
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
		}
		
		if ($month==11){
			
			echo "<td>Dec</td>";
			echo "<td>Jan</td>";
			echo "<td>Feb</td>";
			echo "<td>Mar</td>";
			echo "<td>Apr</td>";
			echo "<td>May</td>";
			echo "<td>Jun</td>";
			echo "<td>Jul</td>";
			echo "<td>Aug</td>";
			echo "<td>Sep</td>";
			echo "<td>Oct</td>";
			echo "<td>Nov</td>";
		}
		echo "<td>arDate</td></tr>";
		$BRAND_NAME="";
		
		$sql="select * from tmpstkmve order by BRAND_NAME";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	while($row = mysqli_fetch_array($result)){
		
		if ($BRAND_NAME!=$row["BRAND_NAME"]){
		
			$BRAND_NAME=$row["BRAND_NAME"];
			echo "<tr>";
			echo "<td colspan=16 align=left><b>".$row["BRAND_NAME"]."</b></td>";
			echo "</tr>";
		}
			
		echo "<tr>";
		echo "<td>".$row["STK_NO"]."</td>";
		echo "<td>".$row["DESCRIPT"]."</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>".$row["m1"]."</td>";
		echo "<td>".$row["m2"]."</td>";
		echo "<td>".$row["m3"]."</td>";
		echo "<td>".$row["m4"]."</td>";
		echo "<td>".$row["m5"]."</td>";
		echo "<td>".$row["m6"]."</td>";
		echo "<td>".$row["m7"]."</td>";
		echo "<td>".$row["m8"]."</td>";
		echo "<td>".$row["m9"]."</td>";
		echo "<td>".$row["m10"]."</td>";
		echo "<td>".$row["m11"]."</td>";
		echo "<td>".$row["m12"]."</td>";
		echo "<td></td>";
		echo "</tr>";
	}

echo "</table>";


?>


</body>
</html>
