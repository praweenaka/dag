<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dealer Card</title>

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
font-size:12px;

}
td
{
font-size:12px;

}
.style1 {
	font-size: 16px;
	font-weight: bold;
	color: #FF0000;
}

.style2 {
	font-size: 16px;
	font-weight: bold;
	color:#000000
}

.style3 {
	font-size: 16px;
	font-weight: bold;
	color:#0000FF;
}
</style>

</head>

<body>


<p>
  <?php

    require_once("connectioni.php");
	
	
    
    $sql="delete from tmpcustomerout";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
	$sql_head="select * from invpara";
	$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
	$row_head = mysqli_fetch_array($result_head);
		
		//////////////////////

	$txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");



	$curyear = date("Y", strtotime($_GET["dtto"]));
	$constYear = date("Y", strtotime($_GET["dtfrom"]));
	$curmon = date("m", strtotime($_GET["dtfrom"]));

	$sql_rsVENDOR="select * from vendor where code ='" . trim($_GET["cuscode"]) . "'";
	$result_rsVENDOR =mysqli_query($GLOBALS['dbinv'],$sql_rsVENDOR);
	if($row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR)){
		$txtarea = trim($row_rsVENDOR["ADD2"]);
	}

	if (is_null($row_rsVENDOR["acno"])==false) { $txtlimi3 = trim($row_rsVENDOR["acno"]); }
	if ($_GET["cmbrep"] == "All") {
    	if ($_GET["CmbBrand"] == "All") {
        	if ($_GET["radio"]=="Option1") { 
				$sql_rscheq = "select * from ret_ch_sett where CR_C_CODE ='" . trim($_GET["cuscode"]) . "' and CR_FLAG='0' order by CR_CHDATE, CR_CHNO ";
				
			}	
        	if ($_GET["radio"]=="Option2") { 
				$sql_rscheq = "select * from ret_ch_sett where CR_C_CODE ='" . trim($_GET["cuscode"]) . "' and CR_FLAG='0' and CR_DATE >='" . $_GET["dtfrom"] . "'   and CR_DATE <='" . $_GET["dtto"] . "'  order by CR_CHDATE, CR_CHNO ";
				
			}	
        
        	$sql_rsJAN = "select sum(grand_tot/(1+(gst/100))) as jantot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='1' AND year(SDATE)='" . $curyear . " 'AND  CANCELL='0' ";
			
			$result_rsJAN =mysqli_query($GLOBALS['dbinv'],$sql_rsJAN);
			$row_rsJAN = mysqli_fetch_array($result_rsJAN);
			//if ($curmon < 2) { $curyear = $constYear - 1; }
        
        	$sql_rsFEB = "select sum(grand_tot/(1+(gst/100))) as febtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='2' AND year(SDATE)='" . $curyear . "' AND  CANCELL='0' ";
			$result_rsFEB =mysqli_query($GLOBALS['dbinv'],$sql_rsFEB);
			$row_rsFEB = mysqli_fetch_array($result_rsFEB);
        	//if ($curmon < 3) { $curyear = $constYear - 1; }
        
        	$sql_rsMAR = "select sum(grand_tot/(1+(gst/100))) as martot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='3' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' ";
			$result_rsMAR =mysqli_query($GLOBALS['dbinv'],$sql_rsMAR);
			$row_rsMAR = mysqli_fetch_array($result_rsMAR);
			// echo $sql_rsMAR pp;
        	//if ($curmon < 4) { $curyear = $constYear - 1; }
        
        	$sql_rsAPR = "select sum(grand_tot/(1+(gst/100))) as aprtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='4' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' ";
			$result_rsAPR =mysqli_query($GLOBALS['dbinv'],$sql_rsAPR);
			$row_rsAPR = mysqli_fetch_array($result_rsAPR);
        	//if ($curmon < 5) { $curyear = $constYear - 1; }
        
        	$sql_rsMAY = "select sum(grand_tot/(1+(gst/100))) as maytot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='5' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' ";
			$result_rsMAY =mysqli_query($GLOBALS['dbinv'],$sql_rsMAY);
			$row_rsMAY = mysqli_fetch_array($result_rsMAY);
        	//if ($curmon < 6) { $curyear = $constYear - 1; }
        
        	$sql_rsJUN = "select sum(grand_tot/(1+(gst/100))) as juntot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='6' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' ";
			$result_rsJUN =mysqli_query($GLOBALS['dbinv'],$sql_rsJUN);
			$row_rsJUN = mysqli_fetch_array($result_rsJUN);
        	//if ($curmon < 7) { $curyear = $constYear - 1; }
        
        	$sql_rsJUL = "select sum(grand_tot/(1+(gst/100))) as jultot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='7' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' ";
			$result_rsJUL =mysqli_query($GLOBALS['dbinv'],$sql_rsJUL);
			$row_rsJUL = mysqli_fetch_array($result_rsJUL);
        	//if ($curmon < 8) { $curyear = $constYear - 1; }
        
        	$sql_rsAUG = "select sum(grand_tot/(1+(gst/100))) as augtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='8' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' ";
			$result_rsAUG =mysqli_query($GLOBALS['dbinv'],$sql_rsAUG);
			$row_rsAUG = mysqli_fetch_array($result_rsAUG);
        	//if ($curmon < 9) { $curyear = $constYear - 1; }
        
        	$sql_rsSEP = "select sum(grand_tot/(1+(gst/100))) as septot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='9' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' ";
			$result_rsSEP =mysqli_query($GLOBALS['dbinv'],$sql_rsSEP);
			$row_rsSEP = mysqli_fetch_array($result_rsSEP);
        	//if ($curmon < 10) { $curyear = $constYear - 1; }
        
        	$sql_rsOCT = "select sum(grand_tot/(1+(gst/100))) as octtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='10' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' ";
			$result_rsOCT =mysqli_query($GLOBALS['dbinv'],$sql_rsOCT);
			$row_rsOCT = mysqli_fetch_array($result_rsOCT);
        	//if ($curmon < 11) { $curyear = $constYear - 1; }
        
        	$sql_rsNOV = "select sum(grand_tot/(1+(gst/100))) as novtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='11' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' ";
			$result_rsNOV =mysqli_query($GLOBALS['dbinv'],$sql_rsNOV);
			$row_rsNOV = mysqli_fetch_array($result_rsNOV);
        	//if ($curmon < 12) { $curyear = $constYear - 1; }
        
        	$sql_rsDEC = "select sum(grand_tot/(1+(gst/100))) as dectot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='12' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' ";
			$result_rsDEC =mysqli_query($GLOBALS['dbinv'],$sql_rsDEC);
			$row_rsDEC = mysqli_fetch_array($result_rsDEC);
    	
		} else {
        
			if ($_GET["radio"]=="Option1") { 
				$sql_rscheq = "select * from ret_ch_sett where CR_C_CODE ='" . trim($_GET["cuscode"]) . "' and CR_FLAG='0' order by CR_CHDATE ";
				
			}	
        	if ($_GET["radio"]=="Option2") { 
				$sql_rscheq = "select * from ret_ch_sett where CR_C_CODE ='" . trim($_GET["cuscode"]) . "' and CR_FLAG='0' and CR_DATE >='" . $_GET["dtfrom"] . "'   and CR_DATE <='" . $_GET["dtto"] . "'  order by CR_CHDATE ";
			
			}	
        
        	$sql_rsJAN = "select sum(grand_tot/(1+(gst/100))) as jantot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='1' AND year(SDATE)='" . $curyear . " 'AND  CANCELL='0' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsJAN =mysqli_query($GLOBALS['dbinv'],$sql_rsJAN);
			$row_rsJAN = mysqli_fetch_array($result_rsJAN);
        	//if ($curmon < 2) { $curyear = $constYear - 1; }
        
        	$sql_rsFEB = "select sum(grand_tot/(1+(gst/100))) as febtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='2' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsFEB =mysqli_query($GLOBALS['dbinv'],$sql_rsFEB);
			$row_rsFEB = mysqli_fetch_array($result_rsFEB);
        	//if ($curmon < 3) { $curyear = $constYear - 1; }
        
        	$sql_rsMAR = "select sum(grand_tot/(1+(gst/100))) as martot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='3' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsMAR =mysqli_query($GLOBALS['dbinv'],$sql_rsMAR);
			$row_rsMAR = mysqli_fetch_array($result_rsMAR); 
        	//if ($curmon < 4) { $curyear = $constYear - 1; }
        
        	$sql_rsAPR = "select sum(grand_tot/(1+(gst/100))) as aprtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='4' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsAPR =mysqli_query($GLOBALS['dbinv'],$sql_rsAPR);
			$row_rsAPR = mysqli_fetch_array($result_rsAPR);
        	//if ($curmon < 5) { $curyear = $constYear - 1; }
        
        	$sql_rsMAY = "select sum(grand_tot/(1+(gst/100))) as maytot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='5' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsMAY =mysqli_query($GLOBALS['dbinv'],$sql_rsMAY);
			$row_rsMAY = mysqli_fetch_array($result_rsMAY);
        	//if ($curmon < 6) { $curyear = $constYear - 1; }
        
        	$sql_rsJUN = "select sum(grand_tot/(1+(gst/100))) as juntot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='6' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsJUN =mysqli_query($GLOBALS['dbinv'],$sql_rsJUN);
			$row_rsJUN = mysqli_fetch_array($result_rsJUN);
        	//if ($curmon < 7) { $curyear = $constYear - 1; }
        
        	$sql_rsJUL = "select sum(grand_tot/(1+(gst/100))) as jultot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='7' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsJUL =mysqli_query($GLOBALS['dbinv'],$sql_rsJUL);
			$row_rsJUL = mysqli_fetch_array($result_rsJUL);
	       // if ($curmon < 8) { $curyear = $constYear - 1; }
			
        
        	$sql_rsAUG = "select sum(grand_tot/(1+(gst/100))) as augtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='8' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsAUG =mysqli_query($GLOBALS['dbinv'],$sql_rsAUG);
			$row_rsAUG = mysqli_fetch_array($result_rsAUG);
        	//if ($curmon < 9) { $curyear = $constYear - 1; }
        
        	$sql_rsSEP = "select sum(grand_tot/(1+(gst/100))) as septot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='9' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsSEP =mysqli_query($GLOBALS['dbinv'],$sql_rsSEP);
			$row_rsSEP = mysqli_fetch_array($result_rsSEP);
       		//if ($curmon < 10) { $curyear = $constYear - 1; }
        
        	$sql_rsOCT = "select sum(grand_tot/(1+(gst/100))) as octtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='10' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsOCT =mysqli_query($GLOBALS['dbinv'],$sql_rsOCT);
			$row_rsOCT = mysqli_fetch_array($result_rsOCT);
        	//if ($curmon < 11) { $curyear = $constYear - 1; }
        
        	$sql_rsNOV = "select sum(grand_tot/(1+(gst/100))) as novtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='11' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsNOV =mysqli_query($GLOBALS['dbinv'],$sql_rsNOV);
			$row_rsNOV = mysqli_fetch_array($result_rsNOV);
        
        	//if ($curmon < 12) { $curyear = $constYear - 1; }
        
        	$sql_rsDEC = "select sum(grand_tot/(1+(gst/100))) as dectot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='12' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsDEC =mysqli_query($GLOBALS['dbinv'],$sql_rsDEC);
			$row_rsDEC = mysqli_fetch_array($result_rsDEC);
    	}
	
	} else {
    	
		if ($_GET["CmbBrand"] == "All") {
		
        	if ($_GET["radio"]=="Option1") { 
				$sql_rscheq = "select * from ret_ch_sett where CR_C_CODE ='" . trim($_GET["cuscode"]) . "' and CR_FLAG='0' and s_ref='" . trim($_GET["cmbrep"]) . "' order by CR_CHDATE ";
				
			}	
        	if ($_GET["radio"]=="Option2") { 
				$sql_rscheq = "select * from ret_ch_sett where CR_C_CODE ='" . trim($_GET["cuscode"]) . "' and CR_FLAG='0' and s_ref='" . trim($_GET["cmbrep"]) . "' and CR_DATE >='" . $_GET["dtfrom"] . "'   and CR_DATE <='" . $_GET["dtto"] . "'  order by CR_CHDATE ";
				
        	}
        	
			$sql_rsJAN = "select sum(grand_tot/(1+(gst/100))) as jantot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='1' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "'";
        	$result_rsJAN =mysqli_query($GLOBALS['dbinv'],$sql_rsJAN);
			$row_rsJAN = mysqli_fetch_array($result_rsJAN);
			//if ($curmon < 2) { $curyear = $constYear - 1; }
        
        	$sql_rsFEB = "select sum(grand_tot/(1+(gst/100))) as febtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='2' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
			$result_rsFEB =mysqli_query($GLOBALS['dbinv'],$sql_rsFEB);
			$row_rsFEB = mysqli_fetch_array($result_rsFEB);
        	//if ($curmon < 3) { $curyear = $constYear - 1; }
        
        	$sql_rsMAR = "select sum(grand_tot/(1+(gst/100))) as martot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='3' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
			$result_rsMAR =mysqli_query($GLOBALS['dbinv'],$sql_rsMAR);
			$row_rsMAR = mysqli_fetch_array($result_rsMAR);
        	//if ($curmon < 4) { $curyear = $constYear - 1; }
        
        	$sql_rsAPR = "select sum(grand_tot/(1+(gst/100))) as aprtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='4' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
			$result_rsAPR =mysqli_query($GLOBALS['dbinv'],$sql_rsAPR);
			$row_rsAPR = mysqli_fetch_array($result_rsAPR);
        	//if ($curmon < 5) { $curyear = $constYear - 1; }
        
        	$sql_rsMAY = "select sum(grand_tot/(1+(gst/100))) as maytot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='5' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
			$result_rsMAY =mysqli_query($GLOBALS['dbinv'],$sql_rsMAY);
			$row_rsMAY = mysqli_fetch_array($result_rsMAY);
        	//if ($curmon < 6) { $curyear = $constYear - 1; }
        
        	$sql_rsJUN = "select sum(grand_tot/(1+(gst/100))) as juntot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='6' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
			$result_rsJUN =mysqli_query($GLOBALS['dbinv'],$sql_rsJUN);
			$row_rsJUN = mysqli_fetch_array($result_rsJUN);
        	//if ($curmon < 7) { $curyear = $constYear - 1; }
        
        	$sql_rsJUL = "select sum(grand_tot/(1+(gst/100))) as jultot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='7' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
			$result_rsJUL =mysqli_query($GLOBALS['dbinv'],$sql_rsJUL);
			$row_rsJUL = mysqli_fetch_array($result_rsJUL);
        	//if ($curmon < 8) { $curyear = $constYear - 1; }
        
        	$sql_rsAUG = "select sum(grand_tot/(1+(gst/100))) as augtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='8' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
			$result_rsAUG =mysqli_query($GLOBALS['dbinv'],$sql_rsAUG);
			$row_rsAUG = mysqli_fetch_array($result_rsAUG);
        	//if ($curmon < 9) { $curyear = $constYear - 1; }
        
        	$sql_rsSEP = "select sum(grand_tot/(1+(gst/100))) as septot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='9' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
			$result_rsSEP =mysqli_query($GLOBALS['dbinv'],$sql_rsSEP);
			$row_rsSEP = mysqli_fetch_array($result_rsSEP);
        	//if ($curmon < 10) { $curyear = $constYear - 1; }
        
        	$sql_rsOCT = "select sum(grand_tot/(1+(gst/100))) as octtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='10' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
			$result_rsOCT =mysqli_query($GLOBALS['dbinv'],$sql_rsOCT);
			$row_rsOCT = mysqli_fetch_array($result_rsOCT);
        	//if ($curmon < 11) { $curyear = $constYear - 1; }
        
        	$sql_rsNOV = "select sum(grand_tot/(1+(gst/100))) as novtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='11' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
			$result_rsNOV =mysqli_query($GLOBALS['dbinv'],$sql_rsNOV);
			$row_rsNOV = mysqli_fetch_array($result_rsNOV);
        	//if ($curmon < 12) { $curyear = $constYear - 1; }
        
        	$sql_rsDEC = "select sum(grand_tot/(1+(gst/100))) as dectot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='12' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
			$result_rsDEC =mysqli_query($GLOBALS['dbinv'],$sql_rsDEC);
			$row_rsDEC = mysqli_fetch_array($result_rsDEC);
    	
		} else {
		
        	if ($_GET["radio"]=="Option1") { 
				$sql_rscheq = "select * from ret_ch_sett where CR_C_CODE ='" . trim($_GET["cuscode"]) . "' and CR_FLAG='0' and s_ref='" . trim($_GET["cmbrep"]) . "' order by CR_CHDATE ";
				
			}	
        	if ($_GET["radio"]=="Option2") { 
				$sql_rscheq = "select * from ret_ch_sett where CR_C_CODE ='" . trim($_GET["cuscode"]) . "' and CR_FLAG='0' and s_ref='" . trim($_GET["cmbrep"]) . "' and CR_DATE >='" . $_GET["dtfrom"] . "'   and CR_DATE <='" . $_GET["dtto"] . "'  order by CR_CHDATE ";
				
        	}
			
        	$sql_rsJAN = "select sum(grand_tot/(1+(gst/100))) as jantot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='1' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsJAN =mysqli_query($GLOBALS['dbinv'],$sql_rsJAN);
			$row_rsJAN = mysqli_fetch_array($result_rsJAN);
        	//if ($curmon < 2) { $curyear = $constYear - 1; }
        
        	$sql_rsFEB = "select sum(grand_tot/(1+(gst/100))) as febtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='2' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsFEB =mysqli_query($GLOBALS['dbinv'],$sql_rsFEB);
			$row_rsFEB = mysqli_fetch_array($result_rsFEB);
        	//if ($curmon < 3) { $curyear = $constYear - 1; }
        
        	$sql_rsMAR = "select sum(grand_tot/(1+(gst/100))) as martot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='3' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "' "; 
			$result_rsMAR =mysqli_query($GLOBALS['dbinv'],$sql_rsMAR);
			$row_rsMAR = mysqli_fetch_array($result_rsMAR);
        	//if ($curmon < 4) { $curyear = $constYear - 1; }
        
        	$sql_rsAPR = "select sum(grand_tot/(1+(gst/100))) as aprtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='4' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsAPR =mysqli_query($GLOBALS['dbinv'],$sql_rsAPR);
			$row_rsAPR = mysqli_fetch_array($result_rsAPR);
        	//if ($curmon < 5) { $curyear = $constYear - 1; }
        
        	$sql_rsMAY = "select sum(grand_tot/(1+(gst/100))) as maytot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='5' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsMAY =mysqli_query($GLOBALS['dbinv'],$sql_rsMAY);
			$row_rsMAY = mysqli_fetch_array($result_rsMAY);
        	//if ($curmon < 6) { $curyear = $constYear - 1; }
        
        	$sql_rsJUN = "select sum(grand_tot/(1+(gst/100))) as juntot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='6' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsJUN =mysqli_query($GLOBALS['dbinv'],$sql_rsJUN);
			$row_rsJUN = mysqli_fetch_array($result_rsJUN);
        	//if ($curmon < 7) { $curyear = $constYear - 1; }
        
        	$sql_rsJUL = "select sum(grand_tot/(1+(gst/100))) as jultot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='7' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsJUL =mysqli_query($GLOBALS['dbinv'],$sql_rsJUL);
			$row_rsJUL = mysqli_fetch_array($result_rsJUL);
        	//if ($curmon < 8) { $curyear = $constYear - 1; }
        
        	$sql_rsAUG = "select sum(grand_tot/(1+(gst/100))) as augtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='8' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsAUG =mysqli_query($GLOBALS['dbinv'],$sql_rsAUG);
			$row_rsAUG = mysqli_fetch_array($result_rsAUG);
        	//if ($curmon < 9) { $curyear = $constYear - 1; }
        
        	$sql_rsSEP = "select sum(grand_tot/(1+(gst/100))) as septot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='9' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsSEP =mysqli_query($GLOBALS['dbinv'],$sql_rsSEP);
			$row_rsSEP = mysqli_fetch_array($result_rsSEP);
        	//if ($curmon < 10) { $curyear = $constYear - 1; }
        
        	$sql_rsOCT = "select sum(grand_tot/(1+(gst/100))) as octtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='10' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsOCT =mysqli_query($GLOBALS['dbinv'],$sql_rsOCT);
			$row_rsOCT = mysqli_fetch_array($result_rsOCT);
        	//if ($curmon < 11) { $curyear = $constYear - 1; }
        
        	$sql_rsNOV = "select sum(grand_tot/(1+(gst/100))) as novtot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='11' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsNOV =mysqli_query($GLOBALS['dbinv'],$sql_rsNOV);
			$row_rsNOV = mysqli_fetch_array($result_rsNOV);
        	//if ($curmon < 12) { $curyear = $constYear - 1; }
        
        	$sql_rsDEC = "select sum(grand_tot/(1+(gst/100))) as dectot from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and month(SDATE)='12' AND year(SDATE)='" . $curyear . "'AND  CANCELL='0' and sal_ex='" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "' ";
			$result_rsDEC =mysqli_query($GLOBALS['dbinv'],$sql_rsDEC);
			$row_rsDEC = mysqli_fetch_array($result_rsDEC);
    	}
	}


	
	$date=date("Y-m-d", strtotime($_GET["dtfrom"]));
	$caldays=" - 365 days";
	$tmpdate=date('Y-m-d', strtotime($date.$caldays));
		
	if ($_GET["cmbrep"] == "All") {
    	if ($_GET["CmbBrand"] == "All") {
        	$sql_ret= "Select CUSCODE, year(SDATE) as year, month(SDATE) as mon, sum(AMOUNT/(1+(vatrate/100))) as retamou from c_bal where CUSCODE = '" . trim($_GET["cuscode"]) . "' and SDATE >= '" . $tmpdate . "' AND SDATE <= '" . $_GET["dtto"] . "'  and CANCELL = '0' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' and flag1<>1 group by CUSCODE, year(SDATE), month(SDATE) order by year(SDATE) desc ,month(SDATE) desc";   
        	// echo ppp;
			$result_ret =mysqli_query($GLOBALS['dbinv'],$sql_ret);
			if ($row_ret = mysqli_fetch_array($result_ret)){
        		
				$result_ret =mysqli_query($GLOBALS['dbinv'],$sql_ret);
				while ($row_ret = mysqli_fetch_array($result_ret)){
            	
                	if (($row_ret["mon"] <= date("m", strtotime($_GET["dtfrom"]))) and ($row_ret["year"] != date("Y", strtotime($_GET["dtfrom"])))) {
                    //ret.MoveLast
                	} else {
                    	if ($row_ret["mon"] == 1) { $rtjan = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 2) { $rtfeb = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 3) { $rtmar = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 4) { $rtapr = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 5) { $rtmay = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 6) { $rtjun = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 7) { $rtjul = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 8) { $rtaug = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 9) { $rtsep = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 10) { $rtoct = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 11) { $rtnov = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 12) { $rtdec = $row_ret["retamou"]; }
                	}
                	//ret.MoveNext
            	}
        	}
    	} else {
        	$sql_ret = "Select CUSCODE, year(SDATE) as year, month(SDATE) as mon, sum(AMOUNT/(1+(vatrate/100))) as retamou from c_bal where CUSCODE = '" . trim($_GET["cuscode"]) . "' and SDATE >= '" . $tmpdate . "' AND SDATE <= '" . $_GET["dtto"] . "' and CANCELL = '0' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' and brand = '" . trim($_GET["CmbBrand"]) . "'  and flag1<>1 group by CUSCODE, year(SDATE), month(SDATE) order by year(SDATE) desc ,month(SDATE) desc";
        	$result_ret =mysqli_query($GLOBALS['dbinv'],$sql_ret); 
			if ($row_ret = mysqli_fetch_array($result_ret)){
			
				$result_ret =mysqli_query($GLOBALS['dbinv'],$sql_ret);
				while ($row_ret = mysqli_fetch_array($result_ret)){
                	if (($row_ret["mon"] <= date("m", strtotime($_GET["dtfrom"]))) and ($row_ret["year"] != date("Y", strtotime($_GET["dtfrom"])))) {
                    	//ret.MoveLast
                	} else {
                    	if ($row_ret["mon"] == 1) { $rtjan = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 2) { $rtfeb = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 3) { $rtmar = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 4) { $rtapr = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 5) { $rtmay = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 6) { $rtjun = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 7) { $rtjul = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 8) { $rtaug = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 9) { $rtsep = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 10) { $rtoct = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 11) { $rtnov = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 12) { $rtdec = $row_ret["retamou"]; }
                	}
                	//ret.MoveNext
            	}
        	}
    	}
	} else {
    	
		if ($_GET["CmbBrand"] == "All") {
        	
			$sql_ret = "Select CUSCODE, year(SDATE) as year, month(SDATE) as mon, sum(AMOUNT/(1+(vatrate/100))) as retamou from c_bal where CUSCODE = '" . trim($_GET["cuscode"]) . "' and SDATE >= '" . $tmpdate . "' AND SDATE <= '" . $_GET["dtto"] . "' and CANCELL = '0' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' and SAL_EX = '" . trim($_GET["cmbrep"]) . "'  and flag1<>1 group by CUSCODE, year(SDATE), month(SDATE) order by year(SDATE) desc , month(SDATE) desc";
			$result_ret =mysqli_query($GLOBALS['dbinv'],$sql_ret);
			if ($row_ret = mysqli_fetch_array($result_ret)){
        		
				$result_ret =mysqli_query($GLOBALS['dbinv'],$sql_ret);
				while ($row_ret = mysqli_fetch_array($result_ret)){
            
                	if (($row_ret["mon"] <= date("m", strtotime($_GET["dtfrom"]))) and ($row_ret["year"] != date("Y", strtotime($_GET["dtfrom"])))) {
                   // ret.MoveLast
                	} else {
                    	if ($row_ret["mon"] == 1) { $rtjan = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 2) { $rtfeb = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 3) { $rtmar = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 4) { $rtapr = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 5) { $rtmay = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 6) { $rtjun = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 7) { $rtjul = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 8) { $rtaug = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 9) { $rtsep = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 10) { $rtoct = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 11) { $rtnov = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 12) { $rtdec = $row_ret["retamou"]; }
                	}
                	//ret.MoveNext
            	}
        	}
    	} else {
        	
			$sql_ret = "Select CUSCODE, year(SDATE) as year, month(SDATE) as mon, sum(AMOUNT/(1+(vatrate/100))) as retamou from c_bal where CUSCODE = '" . trim($_GET["cuscode"]) . "' and SDATE >= '" . $tmpdate . "' AND SDATE <= '" . $_GET["dtto"] . "' and CANCELL = '0' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' and SAL_EX = '" . trim($_GET["cmbrep"]) . "' and brand = '" . trim($_GET["CmbBrand"]) . "'  and flag1<>1 group by CUSCODE, year(SDATE), month(SDATE) order by year(SDATE) desc , month(SDATE) desc";
        	$result_ret =mysqli_query($GLOBALS['dbinv'],$sql_ret); 
			if ($row_ret = mysqli_fetch_array($result_ret)){
			
            	$result_ret =mysqli_query($GLOBALS['dbinv'],$sql_ret);
				while ($row_ret = mysqli_fetch_array($result_ret)){
                	
					if (($row_ret["mon"] <= date("m", strtotime($_GET["dtfrom"]))) and ($row_ret["year"] != date("Y", strtotime($_GET["dtfrom"])))) {
                    	//ret.MoveLast
                	} else {
                    	if ($row_ret["mon"] == 1) { $rtjan = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 2) { $rtfeb = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 3) { $rtmar = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 4) { $rtapr = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 5) { $rtmay = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 6) { $rtjun = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 7) { $rtjul = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 8) { $rtaug = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 9) { $rtsep = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 10) { $rtoct = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 11) { $rtnov = $row_ret["retamou"]; }
                    	if ($row_ret["mon"] == 12) { $rtdec = $row_ret["retamou"]; }
                	}
                	//ret.MoveNext
            	}
        	}
    	}
	}


        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All")) { 
			$sql_crLmt = "select * from br_trn where cus_code='" . trim($_GET["cuscode"]) . "'";
		}	
        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All")) { 
			$sql_crLmt = "select * from br_trn where brand ='" . $_GET["CmbBrand"] . "' and  cus_code='" . trim($_GET["cuscode"]) . "'";
		}	
        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All")) { 
			$sql_crLmt = "select * from br_trn where Rep='" . trim($_GET["cmbrep"]) . "' and  cus_code='" . trim($_GET["cuscode"]) . "'";
		}	
        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All")) { 
			$sql_crLmt = "select *  from br_trn where  rep='" . trim($_GET["cmbrep"]) . "' and  brand ='" . $_GET["CmbBrand"] . "' and  cus_code='" . trim($_GET["cuscode"]) . "'";
		}
		
		$result_crLmt=mysqli_query($GLOBALS['dbinv'],$sql_crLmt);
		$row_crLmt = mysqli_fetch_array($result_crLmt);	
		
		$result_crLmt=mysqli_query($GLOBALS['dbinv'],$sql_crLmt);
		$count_crLmt = mysqli_num_rows($result_crLmt);	
		
        if ($count_crLmt == 1) {
            $limit = $row_crLmt["credit_lim"];
            $cat = $row_crLmt["CAT"];
        } else {
		   $result_crLmt=mysqli_query($GLOBALS['dbinv'],$sql_crLmt);
		   while($row_crLmt = mysqli_fetch_array($result_crLmt)){		
           	if (trim($row_crLmt["CAT"]) == "C") { $limit = $limit + $row_crLmt["credit_lim"]; }
            if (trim($row_crLmt["CAT"]) == "B") { $limit = $limit + $row_crLmt["credit_lim"] * 2.5; }
            if (trim($row_crLmt["CAT"]) == "A") { $limit = $limit + $row_crLmt["credit_lim"] * 2.5; }
            $cat = "CC";
           //	crLmt.MoveNext
           }
           
        }
        
	if (is_null($row_rsVENDOR["CAT"])==false) { $txtcat = $cat; }
	if (is_null($row_rsVENDOR["CONT"])==false) { $txtdirec = $row_rsVENDOR["CONT"]; }
	if (is_null($row_rsVENDOR["cLIMIT"])==false) { $txtlimi1 = number_format($limit, 2, ".", ","); }

	$txtdelname = $_GET["cuscode"] . " " . $_GET["cusname"];

	if (is_null($row_rsJAN["jantot"])==false) {
		$a=$row_rsJAN["jantot"] - $rtjan;
		$b=$a;
   		$txtjan = number_format($b, 0, ".", ",");
	}
	if (is_null($row_rsFEB["febtot"])==false) {
		$a=$row_rsFEB["febtot"] - $rtfeb;
		$b=$a;
   		$txtfeb = number_format($b, 0, ".", ",");
	}

	if (is_null($row_rsMAR["martot"])==false) {
		$a=$row_rsMAR["martot"] - $rtmar; 
		$b=$a;
   		$txtmar = number_format($b, 0, ".", ",");
	}

	if (is_null($row_rsAPR["aprtot"])==false) {
		$a=$row_rsAPR["aprtot"] - $rtapr;
		$b=$a;
   		$txtapr = number_format($b, 0, ".", ",");
	}

	if (is_null($row_rsMAY["maytot"])==false) {
		$a=$row_rsMAY["maytot"] - $rtmay;
		$b=$a;
   		$txtmay = number_format($b, 0, ".", ",");
	}

	if (is_null($row_rsJUN["juntot"])==false) {
		$a=$row_rsJUN["juntot"] - $rtjun;
		$b=$a;
   		$txtjun = number_format($b, 0, ".", ",");
	}

	if (is_null($row_rsJUL["jultot"])==false) {
		$a=$row_rsJUL["jultot"] - $rtjul;
		$b=$a;
   		$txtjul = number_format($b, 0, ".", ",");
	}

	if (is_null($row_rsAUG["augtot"])==false) {
		$a=$row_rsAUG["augtot"] - $rtaug;
		$b=$a;
   		$txtaug = number_format($b, 0, ".", ",");
	}

	if (is_null($row_rsSEP["septot"])==false) {
		$a=$row_rsSEP["septot"] - $rtsep;
		$b=$a;
   		$txtsep = number_format($b, 0, ".", ",");
	}

	if (is_null($row_rsOCT["octtot"])==false) {
		$a=$row_rsOCT["octtot"] - $rtoct;
		$b=$a;
   		$txtoct = number_format($b, 0, ".", ",");
	}

	if (is_null($row_rsNOV["novtot"])==false) {
		$a=$row_rsNOV["novtot"] - $rtnov;
		$b=$a;
   		$txtnov = number_format($b, 0, ".", ",");
	}

	if (is_null($row_rsDEC["dectot"])==false) {
		$a=$row_rsDEC["dectot"] - $rtdec;
		$b=$a;
   		$txtdec = number_format($b, 0, ".", ",");
	}


	$sql_cus = "Select * from vendor where CODE='".$_GET["cuscode"]."'";
    $result_cus =mysqli_query($GLOBALS['dbinv'],$sql_cus);
	if ($row_cus = mysqli_fetch_array($result_cus)){
		$txtagreeno=$row_cus["acno"];
		$txtgenlimit=$row_cus["cLIMIT"];
	}
	
	
	$txttyre="";
	$txttyre_cat="";
	$sql_br	 = "Select * from br_trn where cus_code='".$_GET["cuscode"]."' and brand='TYRE'";
	
    $result_br =mysqli_query($GLOBALS['dbinv'],$sql_br);
	while ($row_br = mysqli_fetch_array($result_br)){
	
		$txttyre=$txttyre." &nbsp;&nbsp;".number_format($row_br["credit_lim"], 2, ".", ",");
		$txttyre_cat=$txttyre_cat." &nbsp;&nbsp;".$row_br["CAT"];	
	}
	
	$txtbattery="";
	$txtbattery_cat="";
	$sql_br = "Select * from br_trn where cus_code='".$_GET["cuscode"]."' and brand='BATTERY'";
    $result_br =mysqli_query($GLOBALS['dbinv'],$sql_br);
	while($row_br = mysqli_fetch_array($result_br)){
		$txtbattery=$txtbattery." &nbsp;&nbsp;".number_format($row_br["credit_lim"], 2, ".", ",");
		$txtbattery_cat=$txtbattery_cat." &nbsp;&nbsp;".$row_br["CAT"];
	}
	
	$txtalloy="";
	$txtalloy_cat="";
	$sql_br = "Select * from br_trn where cus_code='".$_GET["cuscode"]."'  and brand='TUBE'";
    $result_br =mysqli_query($GLOBALS['dbinv'],$sql_br);
	while($row_br = mysqli_fetch_array($result_br)){
		$txtalloy=$txtalloy." &nbsp;&nbsp;".number_format($row_br["credit_lim"], 2, ".", ",");
		$txtalloy_cat=$txtalloy_cat." &nbsp;&nbsp;".$row_br["CAT"];
	}
	
	
	$txttube="";
	$txttube_cat="";
	$sql_br = "Select * from br_trn where cus_code='".$_GET["cuscode"]."'  and brand='ALLOY WHEEL'";
    $result_br =mysqli_query($GLOBALS['dbinv'],$sql_br);
	while ($row_br = mysqli_fetch_array($result_br)){
		$txttube=$txttube." &nbsp;&nbsp;".number_format($row_br["credit_lim"], 2, ".", ",");
		$txttube_cat=$txttube_cat." &nbsp;&nbsp;".$row_br["CAT"];
	}	
	
			
?>
</p>
<table width="1000" border="0">
  <tr>
    <td width="308"><span class="style1">DEALER</span></td>
    <td width="257"><?php echo $txtdelname; ?></td>
    <td width="221">&nbsp;</td>
    <td colspan="2"><span class="style1">GENERAL LIMIT</span></td>
    <td colspan="2"><?php echo number_format($txtgenlimit, 2, ".", ","); ?></td>
  </tr>
  <tr>
    <td><span class="style1">DIRECTORS</span></td>
    <td><?php echo $txtdirec; ?></td>
    <td><?php echo $T3; ?></td>
    <td width="150"><span class="style1">TYRE</span></td>
    <td width="39"><?php echo $txttyre_cat; ?></td>
    <td colspan="2"><?php echo $txttyre; ?></td>
  </tr>
  <tr>
    <td><span class="style1">AGREEMENT</span></td>
    <td><?php echo $txtagreeno; ?></td>
    <td>&nbsp;</td>
    <td><span class="style1">BATTERY</span></td>
    <td><?php echo $txtbattery_cat; ?></td>
    <td colspan="2"><?php echo $txtbattery; ?></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">ALLOY WHEEL</span>;</td>
    <td><?php echo $txtalloy_cat; ?></td>
    <td colspan="2"><?php echo $txtalloy; ?></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td><span class="style1">TUBE</span></td>
    <td><?php echo $txttube_cat; ?></td>
    <td colspan="2"><?php echo $txttube; ?></td>
  </tr>
  
  <tr>
    <td colspan="7"><table width="1000" border="1">
      <tr>
        <td width="80">JAN</td>
        <td width="80">FEB</td>
        <td width="80">MAR</td>
        <td width="80">APR</td>
        <td width="80">MAY</td>
        <td width="80">JUN</td>
        <td width="80">JUL</td>
        <td width="80">AUG</td>
        <td width="80">SEP</td>
        <td width="80">OCT</td>
        <td width="80">NOV</td>
        <td width="80">DEC</td>
      </tr>
      <tr>
      <?php
	  	$cmonth=date("m", strtotime($_GET["dtto"]));
		
		if ($cmonth>=1){
        	echo "<td><span class=\"style3\">".$txtjan."</span></td>";
		}
		if ($cmonth>=2){	
        	echo "<td><span class=\"style3\">".$txtfeb."</span></td>";
		}	
        if ($cmonth>=3){
        	echo "<td><span class=\"style3\">".$txtmar."</span></td>";
		}	
        if ($cmonth>=4){
        	echo "<td><span class=\"style3\">".$txtapr."</span></td>";
		}	
        if ($cmonth>=5){
        	echo "<td><span class=\"style3\">".$txtmay."</span></td>";
		}	
        if ($cmonth>=6){
        	echo "<td><span class=\"style3\">".$txtjun."</span></td>";
		}	
        if ($cmonth>=7){
        	echo "<td><span class=\"style3\">".$txtjul."</span></td>";
		}	
        if ($cmonth>=8){
        	echo "<td><span class=\"style3\">".$txtaug."</span></td>";
		}	
        if ($cmonth>=9){
        	echo "<td><span class=\"style3\">".$txtsep."</span></td>";
		}	
        if ($cmonth>=10){
        	echo "<td><span class=\"style3\">".$txtoct."</span></td>";
		}	
        if ($cmonth>=11){
        	echo "<td><span class=\"style3\">".$txtnov."</span></td>";
		}	
        if ($cmonth>=12){
        	echo "<td><span class=\"style3\">".$txtdec."</span></td>";
		}
		?>	
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="86">&nbsp;</td>
    <td width="123">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7"><table width="1200" border="1">
      <tr>
        <td><b>Amount</b></td>
        <td><b>Reason</b></td>
        <td><b>Cheque No</b></td>
        <td><b>Date of Return</b></td>
        <td><b>No. of Times RTN</b></td>
        <td><b>Settlement Dates</b></td>
        <td><b>Paid Amounts</b></td>
        <td><b>Settlment Type</b></td>
        <td><b>Total Days</b></td>
      </tr>
      
      <?php
	// echo $sql_rscheq;
	  $result_rscheq =mysqli_query($GLOBALS['dbinv'],$sql_rscheq);
	  while ($row_rscheq = mysqli_fetch_array($result_rscheq)){
      	
		if ($CR_CHNO!=$row_rscheq["CR_CHNO"]){
			
			$sql_uti="select * from ch_sttr where ST_INVONO='".$CR_REFNO."' and ST_FLAG='UT'";
			$result_uti =mysqli_query($GLOBALS['dbinv'],$sql_uti);
	  		while ($row_uti = mysqli_fetch_array($result_uti)){
				echo "<tr>
        		<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
        		<td>".$row_rscheq["CR_DATE"]."</td>
        		<td>&nbsp;</td>
        		<td>".$row_uti["ST_DATE"]."</td>
        		<td><span class=\"style3\" align=right>".number_format($row_uti["ST_PAID"], 2, ".", ",")."</span></td>
        		<td>".$row_uti["ST_CHNO"]."</td>
        		<td></td></tr>";
			}
	  
			echo "<tr>
        	<td><span class=\"style1\">".number_format($row_rscheq["CR_CHEVAL"], 2, ".", ",")."</span></td>";
			
			$sql_reason="select * from reason where reason_id='".$row_rscheq["reason"]."'";
			$result_reason =mysqli_query($GLOBALS['dbinv'],$sql_reason);
	  		$row_reason = mysqli_fetch_array($result_reason);
	  
        	echo "<td>".$row_reason["reason"]."</td>
        	<td><span class=\"style2\">".$row_rscheq["CR_CHNO"]."</span></td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td></tr>";
			$CR_CHNO=$row_rscheq["CR_CHNO"];
			$CR_REFNO=$row_rscheq["CR_REFNO"];
			
		}
		
		
		echo "<tr>
        	<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        	<td>".$row_rscheq["CR_DATE"]."</td>
        	<td>&nbsp;</td>
        	<td>".$row_rscheq["ST_DATE"]."</td>
        	<td><span class=\"style3\" align=right>".number_format($row_rscheq["ST_PAID"], 2, ".", ",")."</span></td>
        	<td>".$row_rscheq["pay_type"]." ".$row_rscheq["ST_CHNO"]."</td>
        	<td>".$row_rscheq["ST_DAYS"]."</td></tr>";
			
	  }	
		
		?>	
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
