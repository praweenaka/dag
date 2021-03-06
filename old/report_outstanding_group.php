<?php session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Outstanding Report - Group</title>

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
	
	
    $GLOBALS['hostname'] = 'localhost';
$GLOBALS['username'] = 'root';
$GLOBALS['password'] = '';
$dbtht = mysqli_connect($GLOBALS['hostname'],$GLOBALS['username'],$GLOBALS['password'],'SWijesooriya_ben');
$dbben = mysqli_connect($GLOBALS['hostname'],$GLOBALS['username'],$GLOBALS['password'],'SWijesooriya_tht');
	 
 
	
	$sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center>";
		
		
		
		
	echo "<center>Date : ".date('Y-m-d') ."<br>";
	
	
	
	if ($_GET['radio'] =="optdet")  {
	 
	echo "<b>Customer :".$_GET["cuscode"]." - ".$_GET["cusname"]."</b>";
	
	 

 
$AMOUNT=0;
$totbal=0;

 

echo "<table border=1 width=1000><tr>
		<th colspan='2'>Tyre House Trading</th><th colspan='2'>Benedictsons</th></tr>";
	 


$sql = "select * from vendor where code = '" . $_GET['cuscode'] . "'";	

$result =mysqli_query($GLOBALS['dbinv'],$sql);
$row = mysqli_fetch_array($result);
$s_code = trim($row['commoncode']);
 
$limit =0;
$crLmt = "select * from br_trn where cus_code='" . trim($_GET["cuscode"]) . "'";
$result_crLmt = mysqli_query($GLOBALS['dbinv'], $crLmt);
    while ($row_crLmt = mysqli_fetch_array($result_crLmt)) {
		$credit_lim = $row_crLmt["credit_lim"];	
        if (trim($row_crLmt["CAT"]) == "C") {
            $limit = $limit + $credit_lim;
        }
        if (trim($row_crLmt["CAT"]) == "B") {
            $limit = $limit + $credit_lim * 2.5;
        }
        if (trim($row_crLmt["CAT"]) == "A") {
            $limit = $limit + $credit_lim * 2.5;
        }
}
	

$crLmt = "select * from br_trn where cus_code='" . trim($s_code) . "'";
$limit_s=0;
	 	
	$result_crLmt = mysqli_query($dbtht, $crLmt);
    while ($row_crLmt = mysqli_fetch_array($result_crLmt)) {
		$credit_lim = $row_crLmt["credit_lim"];	
        if (trim($row_crLmt["CAT"]) == "C") {
            $limit_s = $limit_s + $credit_lim;
        }
        if (trim($row_crLmt["CAT"]) == "B") {
            $limit_s = $limit_s + $credit_lim * 2.5;
        }
        if (trim($row_crLmt["CAT"]) == "A") {
            $limit_s = $limit_s + $credit_lim * 2.5;
        }
}
	 
echo "<tr>
	   <th colspan='2'>Credit Limit :" .  number_format($limit, 2, ".", ",")     . "</th><th colspan='2'>Credit Limit : " .   number_format($limit_s, 2, ".", ",")   . "</th></tr>";
	 

$sql ="Select sum(grand_tot - totpay) as outs from s_salma where c_code = '" . trim($_GET["cuscode"])  .  "' and grand_tot > totpay and cancell = '0' ";	
$result_to =mysqli_query($dbben,$sql);
$row_to = mysqli_fetch_array($result_to);

$sql ="Select sum(grand_tot - totpay) as outs from s_salma where c_code = '" . trim($s_code)  .  "' and grand_tot > totpay and cancell = '0' ";
$result_bo =mysqli_query($dbtht,$sql);
$row_bo = mysqli_fetch_array($result_bo);
	 
	 
	 
 echo "<tr>
	   <th>Outstandings   </th><th>" .  number_format($row_to['outs'], 2, ".", ",")     . "</th><th>Outstandings</th><th>" .   number_format($row_bo['outs'], 2, ".", ",")   . "</th></tr>";
	 	  	

$sql ="Select sum(cr_cheval-paid) as outs from s_cheq where cr_c_code = '" . trim($_GET["cuscode"])  ."' and cr_cheval > paid and cr_flag = '0'";	
$result_tr =mysqli_query($dbben,$sql);
$row_tr = mysqli_fetch_array($result_tr);

$sql ="Select sum(cr_cheval-paid) as outs from s_cheq where cr_c_code = '" . trim($s_code)   ."' and cr_cheval > paid and cr_flag = '0'";
$result_br =mysqli_query($dbtht,$sql);
$row_br = mysqli_fetch_array($result_br);			
	 
 echo "<tr>
	   <th>Return Cheqs    </th><th>" .   number_format($row_tr['outs'], 2, ".", ",")     . "</th><th>Return Cheqs </th><th>" .   number_format($row_br['outs'], 2, ".", ",")    . "</th></tr>";
	 	  	



$sql ="Select sum(che_amount) as outs from S_INVCHEQ where cus_code = '" . trim($_GET["cuscode"])  . "' and che_date > '" .  date('Y-m-d')  . "'";	
$result_tc =mysqli_query($dbben,$sql);
$row_tc = mysqli_fetch_array($result_tc);

$sql ="Select sum(che_amount) as outs from S_INVCHEQ where cus_code = '" . trim($s_code)   . "' and che_date > '" .  date('Y-m-d') .    "'";
$result_bc =mysqli_query($dbtht,$sql);
$row_bc = mysqli_fetch_array($result_bc);	
			
 echo "<tr>
	   <th>Pending Cheqs    </th><th>" . number_format($row_tc['outs'], 2, ".", ",")    . "</th><th>Pending Cheqs </th><th>" .  number_format($row_bc['outs'], 2, ".", ",")   . "</th></tr>";
	 	  	
 
$mtht = $row_to['outs'] + $row_tr['outs'] + $row_tc['outs'];

$mben = $row_bo['outs'] + $row_br['outs'] + $row_bc['outs'];
 
 echo "<tr>
	   <th>Total  </th><th>" .  number_format($mtht, 2, ".", ",")     . "</th><th>Total </th><th>" .   number_format($mben, 2, ".", ",")   . "</th></tr>";
 
  
   

  

 echo "</table>";
 
 echo "<center><h2>Total Group Exporture : " . number_format(($mtht+$mben), 2, ".", ",");
 
 
	} else {
 
 
 $sql = "SELECT sum(grand_tot-totpay) as GRAND_TOT , C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >0 and CANCELL='0' group by C_CODE order by sum(grand_tot-totpay) desc";
 $result = mysqli_query($GLOBALS['dbinv'], $sql);
  while ($row = mysqli_fetch_array($result)) {
	  
	$sql_ven = "select * from vendor where code = '" . $row['C_CODE'] . "'";
	$result_bc =mysqli_query($GLOBALS['dbinv'],$sql_ven);
	$row_bc = mysqli_fetch_array($result_bc);
		
	$user[] = "('" . $row['C_CODE'] . "','" . $row_bc['NAME']  . "','" . $row['GRAND_TOT'] . "','0','" . $_SESSION["CURRENT_USER"] . "')";	

	 
 
  }
  
  $sql = "SELECT sum(grand_tot-totpay) as GRAND_TOT , C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >0 and CANCELL='0' group by C_CODE order by sum(grand_tot-totpay) desc";
  $result_bc1 =mysqli_query($dbtht,$sql);
  while ($row_bc1 = mysqli_fetch_array($result_bc1)) {
	
		
	$sql_ven = "select * from vendor where commoncode = '" . $row_bc1['C_CODE'] . "'";
	$result_bc =mysqli_query($GLOBALS['dbinv'],$sql_ven);
	if ($row_bc = mysqli_fetch_array($result_bc)) {
	 
	$user[] = "('" . $row_bc['CODE'] . "','" . $row_bc['NAME']  . "','0','" . $row_bc1['GRAND_TOT'] . "','". $_SESSION["CURRENT_USER"] . "')";		
	}	
	  
	  
  }
  
  
  
   $sql ="Select cus_code,sum(che_amount) as outs from S_INVCHEQ where che_date > '" .  date('Y-m-d')  . "' group by cus_code";	
   $result = mysqli_query($GLOBALS['dbinv'], $sql);
	while ($row = mysqli_fetch_array($result)) {

    $sql_ven = "select * from vendor where code = '" . $row['cus_code'] . "'";
	$result_bc =mysqli_query($GLOBALS['dbinv'],$sql_ven);
	$row_bc = mysqli_fetch_array($result_bc);
		
	$user[] = "('" . $row['cus_code'] . "','" . $row_bc['NAME']  . "','" . $row['outs'] . "','','" . $_SESSION["CURRENT_USER"] . "')";	
	 
	}
	
	   $sql ="Select cus_code,sum(che_amount) as outs from S_INVCHEQ where che_date > '" .  date('Y-m-d')  . "' group by cus_code";	
   $result = mysqli_query($dbtht, $sql);
	while ($row = mysqli_fetch_array($result)) {

    $sql_ven = "select * from vendor where commoncode = '" . $row['cus_code'] . "'";
	$result_bc =mysqli_query($GLOBALS['dbinv'],$sql_ven);
	if ($row_bc = mysqli_fetch_array($result_bc)) {
		
	$user[] = "('" . $row_bc['CODE'] . "','" . $row_bc['NAME']  . "','','" . $row['outs'] . "','" . $_SESSION["CURRENT_USER"] . "')";	
	}
	}
	
	
  
  
  $sql ="Select sum(cr_cheval-paid) as outs,cr_c_code from s_cheq where cr_cheval > paid and cr_flag = '0' group by cr_c_code";	
   $result = mysqli_query($GLOBALS['dbinv'], $sql);
  while ($row = mysqli_fetch_array($result)) {

    $sql_ven = "select * from vendor where code = '" . $row['cr_c_code'] . "'";
		$result_bc =mysqli_query($GLOBALS['dbinv'],$sql_ven);
		$row_bc = mysqli_fetch_array($result_bc);
		
	$user[] = "('" . $row['cr_c_code'] . "','" . $row_bc['NAME']  . "','" . $row['outs'] . "','','" . $_SESSION["CURRENT_USER"] . "')";	
	
	 
  }
  
  
    $sql ="Select sum(cr_cheval-paid) as outs,cr_c_code from s_cheq where  cr_cheval > paid and cr_flag = '0' group by cr_c_code";	
   $result = mysqli_query($dbtht, $sql);
  while ($row = mysqli_fetch_array($result)) {

    $sql_ven = "select * from vendor where commoncode = '" . $row['cr_c_code'] . "'";
		$result_bc =mysqli_query($GLOBALS['dbinv'],$sql_ven);
	IF ($row_bc = mysqli_fetch_array($result_bc)) {
		
	$user[] = "('" . $row_bc['CODE'] . "','" . $row_bc['NAME']  . "','','" . $row['outs'] . "','" . $_SESSION["CURRENT_USER"] . "')";	
	}
	 
  }
  
  
  
  
  
  
  
  
  $sql = "delete from tmpoutgroup where user_nm='" . $_SESSION["CURRENT_USER"] . "'";
  mysqli_query($GLOBALS['dbinv'],$sql);
  $sql = "insert into tmpoutgroup (C_CODE,NAME,out0,out1,user_nm) values " . implode(",",$user) ;
  if (!$result_bc1 =mysqli_query($GLOBALS['dbinv'],$sql)) {
	 echo mysqli_error($GLOBALS['dbinv']);  
  }	  
 
 $tb = "<table><tr><th>Code</th><th>Name</th><th>Outstanding -THT</th><th>Outstanding -BEN</th></tr>";
 
 $sql = "select c_code,NAME,sum(out0) as out0,sum(out1) as out1 from tmpoutgroup where user_nm='" . $_SESSION["CURRENT_USER"] . "' group by c_code,NAME order by sum(out0) desc";
  
 $result_1 = mysqli_query($GLOBALS['dbinv'], $sql);
  while ($row_1 = mysqli_fetch_array($result_1)) {
	$tb .= "<tr>
				<td>" . $row_1['c_code'] . "</td>
				<td>" . $row_1['NAME'] . "</td>
				<td align='right'>" . number_format($row_1['out0'], 2, ".", ",") . "</td>
				<td align='right'>" . number_format($row_1['out1'], 2, ".", ",") . "</td>
	</tr>";
  }
 
 
 echo $tb;
	}
?>


</body>
</html>
