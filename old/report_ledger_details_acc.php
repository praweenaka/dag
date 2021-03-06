<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sales Summery</title>
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
</style>
</head>

<body>
 <!-- Progress bar holder -->


<?php
	include('connectioni.php');
	//echo $_GET["txtAccCode"];
	if (trim($_GET["txtAccCode"]) != "") {
    	ledcal(trim($_GET["txtAccCode"]), $_GET["dtfrom"], $_GET["dtto"]);
	} else {
    	ledcal("C", $_GET["dtfrom"], $_GET["dtto"]);
	}
	
	
	
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		$txthead= $_GET["txtAccCode"] . "   " . $_GET["txtAccName"] . " - " . $_SESSION['company'];
		
		
		echo "<center>".$txthead."</center><br>";
		
		echo "<center>".date("Y-m-d H:i:s")."</center><br>";
		echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Refno</th>
		<th>Naration</th>
		<th>Debit</th>
		<th>Credit</th>
		<th>Balance</th>
		</tr>";
		//echo $sql;
		
		
		$debtot=0;
		$cretot=0;
		
		$sql="select * from ledprint order by sdate, refno";
		
		$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
		while($row = mysqli_fetch_array($result)){		
		  	
			$deb=0;
			$cre=0;
		
			echo "<tr>
			<td>".$row["sdate"]."</td>
			<td>".$row["refno"]."</td>
			<td>".$row["remarks"]."</td>";
			
			if ($row["flag"]=="DEB") {
				echo "<td>".number_format($row["amount"], 2, ".", ",")."</td>";
				$deb=$row["amount"];
				$debtot=$debtot+$row["amount"];
			} else {
				echo "<td>&nbsp;</td>";
			}	
			
			if ($row["flag"]=="CRE") {
				echo "<td>".number_format($row["amount"], 2, ".", ",")."</td>";
				$cre=$row["amount"];
				$cretot=$cretot+$row["amount"];
				
			} else {
				echo "<td>&nbsp;</td>";
			}	
			$bal=$deb-$cre;
			echo "<td>".number_format($bal, 2, ".", ",")."</td>
			
			</tr>";
		}
		
		echo "<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><b>".number_format($debtot, ".", 2, ",")."</b></td>
			<td><b>".number_format($cretot, ".", 2, ",")."</b></td>
			<td>&nbsp;</td></tr>
		<table>";

	

function ledcal($acccode, $dtfrom, $dtto){
	include('connectioni.php');
		
	$sql="delete from ledprint";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
			
	$OpDbAmu = 0;
	$OpCrAmu = 0;
	
/*	$sql="Select * from userpermission  where username ='" . $_SESSION['UserName'] . "'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
	if($row = mysqli_fetch_array($result)){		
	} else {
		exit("User Not Found");
	}	
	*/
	if ($_SESSION['User_Type']=="1"){
		$sql_rs="sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code='" . $acccode . "' and l_yearfl = '2'";
		//echo "1-".$sql_rs;
		$result_rs=mysqli_query($GLOBALS['dbinv'],$sql_rs, $dbacc);
		if($row_rs = mysqli_fetch_array($result_rs)){	
   
      		if ($row_rs["l_flag1"] == "CRE") {
         		$OpCrAmu = $row_rs["l_amount"];
      		} else {
         		$OpDbAmu = $row_rs["l_amount"];
      		}
   		}
	} else {
		$sql_rs="sELECT  l_amount, l_code, l_refno, l_flag1 from ledger where l_flag = 'OPB' and l_code='" . $acccode . "' and l_yearfl = '0'";
		//echo "2-".$sql_rs;
		$result_rs=mysqli_query($GLOBALS['dbinv'],$sql_rs, $dbacc);
		if($row_rs = mysqli_fetch_array($result_rs)){	
  
      		if ($row_rs["l_flag1"] == "CRE") {
         		$OpCrAmu = $row_rs["l_amount"];
      		} else {
         		$OpDbAmu = $row_rs["l_amount"];
      		}
   		}
	}

	$sql_opCR="select sum(l_amount)as ctot from ledger where l_flag != 'OPB' and l_yearfl != '2' and  l_yearfl != '1'  AND l_flag1='CRE' and l_code='" . $acccode . "' and (l_date<'" . $dtfrom . "'  )";
	//echo "3-".$sql_opCR;
	$result_opCR=mysqli_query($GLOBALS['dbinv'],$sql_opCR, $dbacc);
	if($row_opCR = mysqli_fetch_array($result_opCR)){	
		if (is_null($row_opCR["ctot"])==false){
			$OpCrAmu = $OpCrAmu + $row_opCR["ctot"];
		}
	}

	$sql_opDb="select sum(l_amount)as dtot from ledger where  l_flag != 'OPB' and l_yearfl != '2' and  l_yearfl != '1' AND l_flag1='DEB' and l_code='" . $acccode . "'  and (l_date<'" . $dtfrom . "' )";
	//echo "4-".$sql_opDb;
	$result_opDb=mysqli_query($GLOBALS['dbinv'],$sql_opDb, $dbacc);
	if($row_opDb = mysqli_fetch_array($result_opDb)){	
		if (is_null($row_opDb["ctot"])==false){
			$OpCrAmu = $OpCrAmu + $row_opDb["ctot"];
			$OpDbAmu = $OpDbAmu + $row_opDb["dtot"];
		}
	}


	$bF = $OpBalAm + $OpDbAmu - $OpCrAmu + $OpLnkAmt;
	if ($bF > 0) {
   		$bfFlag = "DEB";
	} else {
   		$bfFlag = "CRE";
	}
	
	$sql="insert into ledprint (sdate, refno, remarks, flag, amount) values('" . $dtfrom . "', 'B/F', 'Opening Balance ', '" . $bfFlag . "', " . abs($bF) . ")";
	//echo $sql;
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
	

	$sql_rst="select * from ledger where l_flag != 'OPB' and  l_yearfl != '2' and   l_yearfl != '1' and l_code='" . trim($acccode) . "' and ( l_date >'" . $dtfrom . "' or l_date ='" . $dtfrom . "') and  ( l_date < '" . $dtto . "' or l_date ='" . $dtto . "') ";
	//echo "5-".$sql_rst;
	$result_rst=mysqli_query($GLOBALS['dbinv'],$sql_rst, $dbacc);
	while($row_rst = mysqli_fetch_array($result_rst)){	
		if ($row_rst["l_flag4"] == "CHQ") {
		
			$sql="insert into ledprint (sdate, refno, remarks, flag, amount) values('" . $row_rst["l_date"] . "', '" . trim($row_rst["l_refno"]) . "', '" . trim($row_rst["l_lmem"]) . " " . trim($row_rst["chno"]) . "', '" . trim($row_rst["l_flag1"]) . "', " . $row_rst["l_amount"] . ") ";
			//echo $sql;
			$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
			
    	} else {
			$sql="insert into ledprint (sdate, refno, remarks, flag, amount) values('" . $row_rst["l_date"] . "', '" . trim($row_rst["l_refno"]) . "', '" . trim($row_rst["l_lmem"]) . "', '" . trim($row_rst["l_flag1"]) . "', " . $row_rst["l_amount"] . ") ";
			//echo $sql;
			$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
		}	
        
    }
	
	//$sql_strsql = "select * from ledprint order by sdate, refno ";
 	//$txthead= $_GET["txtAccCode"] . "   " . $_GET["txtAccName"] . " - " . $_SESSION['company'];

}
	






?>



</body>
</html>
