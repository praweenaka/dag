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
font-size:16px;

}
td
{
font-size:16px;

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
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	

	$sysdiv = "1";
	if ($_GET["cmbdev"] == "ALL") { $sysdiv = "A"; }
	if ($_GET["cmbdev"] == "Computer") { $sysdiv = "1"; }
	if ($_GET["cmbdev"] == "Manual") { $sysdiv = "0"; }

	$sql= "delete * from TmpRETCHKAna";
	$result =$db->RunQuery($sql);
	
	$i=0;
	while ($i <= 4 ) {
		$chk="chk".$i;
		$dt="dt".$i;
		if ($_GET[$chk] == "on") { 
			AsAtValue($_GET[$dt]);
		}	
		$i=$i+1;
	}


if ($_GET["radio"]=="optunsettle") {
	if ($_GET["Check1"] != "on") {
    	if ($_GET["cmbrep"] == "All") { 
			$sql_PrInv = "SELECT * from view_s_cheq_copy where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1 and CR_FLAG='0'   ";
		}	
    	if ($_GET["cmbrep"] != "All") { 
			$sql_PrInv = "SELECT * from view_s_cheq_copy where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1 and S_REF='" . trim($_GET["cmbrep"]) . "' and CR_FLAG='0'  ";
		}	
	}
	
	if ($_GET["Check1"]== "on") {
    	if ($_GET["cmbrep"] == "All") { 
			$sql_PrInv = "SELECT * from view_s_cheq_copy where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1  and CR_C_CODE='" . $_GET["cuscode"] . "'  and CR_FLAG='0'  ";
		}	
    	if ($_GET["cmbrep"] != "All") { 
			$sql_PrInv = "SELECT * from view_s_cheq_copy where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1 and S_REF='" . trim($_GET["cmbrep"]) . "'and CR_C_CODE='" . $_GET["cuscode"] . "'and CR_FLAG='0'  ";
		}	
	}
}
 
if ($_GET["radio"]=="optall") {
	if ($_GET["Check1"]!= "on") {
    	if ($_GET["cmbrep"] == "All") { 
			$sql_PrInv = "SELECT * from view_s_cheq_copy where  dev!='" . $sysdiv . "' and   (cr_date>'" . $_GET["dtfrom"] . "'or cr_date='" . $_GET["dtfrom"] . "')and (cr_date<'" . $_GET["dtto"] . "'or cr_date='" . $_GET["dtto"] . "')  and CR_FLAG='0'   ";
		}	
    	
		if ($_GET["cmbrep"] != "All") { 
			$sql_PrInv = "SELECT * from view_s_cheq_copy where  dev!='" . $sysdiv . "' and  (cr_date>'" . $_GET["dtfrom"] . "'or cr_date='" . $_GET["dtfrom"] . "')and (cr_date<'" . $_GET["dtto"] . "'or cr_date='" . $_GET["dtto"] . "') and S_REF='" . trim($_GET["cmbrep"]) . "' and CR_FLAG='0' ";
		}
	}	
	if ($_GET["Check1"] == "on") {
    	if ($_GET["cmbrep"] == "All") { 
			$sql_PrInv = "SELECT * from view_s_cheq_copy where  dev!='" . $sysdiv . "' and  (cr_date>'" . $_GET["dtfrom"] . "'or cr_date='" . $_GET["dtfrom"] . "')and (cr_date<'" . $_GET["dtto"] . "'or cr_date='" . $_GET["dtto"] . "')  and CR_C_CODE='" . $_GET["cuscode"] . "'  and CR_FLAG='0' ";
		}	
    	if ($_GET["cmbrep"] != "All") { 
			$sql_PrInv = "SELECT * from view_s_cheq_copy where  dev!='" . $sysdiv . "' and  (cr_date>'" . $_GET["dtfrom"] . "'or cr_date='" . $_GET["dtfrom"] . "')and (cr_date<'" . $_GET["dtto"] . "'or cr_date='" . $_GET["dtto"] . "') and S_REF='" . trim($_GET["cmbrep"]) . "'and CR_C_CODE='" . $_GET["cuscode"] . "'and CR_FLAG='0' ";
		}	
	}
}




if ($_GET["radio"]="optunsettle") {
	if ($_GET["Check1"]!= "on") {
    	if ($_GET["cmbrep"] == "All") { 
			$sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt,sum(CR_REPAY) as BchaTot  from  s_cheq where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1 and CR_FLAG='0'   ";
		}	
    	if ($_GET["cmbrep"] != "All") { 
			$sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot  from s_cheq where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1 and S_REF='" . trim($_GET["cmbrep"]) . "' and CR_FLAG='0'  ";
		}	
	}
	if ($_GET["Check1"]== "on") {
    	if ($_GET["cmbrep"] == "All") { 
			$sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot  from  s_cheq where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1  and CR_C_CODE='" . $_GET["cuscode"] . "'  and CR_FLAG='0'  ";
		}	
    	if ($_GET["cmbrep"] != "All") { 
			$sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot  from  s_cheq where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1 and S_REF='" . trim($_GET["cmbrep"]) . "'and CR_C_CODE='" . $_GET["cuscode"] . "'and CR_FLAG='0'  ";
		}	
	}
}
 
if ($_GET["radio"]=="optall") {
	if ($_GET["Check1"]!= "on") {
    	if ($_GET["cmbrep"] == "All") { 
			$sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot   from s_cheq where  dev!='" . $sysdiv . "' and   (CR_DATE>'" . $_GET["dtfrom"] . "' or CR_DATE='" . $_GET["dtfrom"] . "')and (CR_DATE<'" . $_GET["dtto"] . "'or CR_DATE='" . $_GET["dtto"] . "')  and CR_FLAG='0'   ";
		}	
    	if ($_GET["cmbrep"] != "All") { 
			$sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot  from s_cheq where  dev!='" . $sysdiv . "' and  (CR_DATE>'" . $_GET["dtfrom"] . "'or CR_DATE='" . $_GET["dtfrom"] . "')and (CR_DATE<'" . $_GET["dtto"] . "'or CR_DATE='" . $_GET["dtto"] . "') and S_REF='" . trim($_GET["cmbrep"]) . "' and CR_FLAG='0' ";
		}	
	}
	if ($_GET["Check1"]== "on") {
    	if ($_GET["cmbrep"] == "All") { 
			$sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot  from s_cheq where  dev!='" . $sysdiv . "' and  (CR_DATE>'" . $_GET["dtfrom"] . "'or CR_DATE='" . $_GET["dtfrom"] . "')and (CR_DATE<'" . $_GET["dtto"] . "'or CR_DATE='" . $_GET["dtto"] . "')  and CR_C_CODE='" . $_GET["cuscode"] . "'  and CR_FLAG='0' ";
		}	
    	if ($_GET["cmbrep"] != "All") { 
			$sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot  from s_cheq where  dev!='" . $sysdiv . "' and  (CR_DATE>'" . $_GET["dtfrom"] . "'or CR_DATE='" . $_GET["dtfrom"] . "')and (CR_DATE<'" . $_GET["dtto"] . "'or CR_DATE='" . $_GET["dtto"] . "') and S_REF='" . trim($_GET["cmbrep"]) . "'and CR_C_CODE='" . $_GET["cuscode"] . "'and CR_FLAG='0' ";
		}	
	}
}

$sql_rs1= " SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt,sum(CR_REPAY) as BchaTot  from  s_cheq where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1 and CR_FLAG='0'   ";
$result_rs1 =$db->RunQuery($sql_rs1);
if($row_rs1 = mysql_fetch_array($result_rs1)){
   $txtunsetcheq=number_format($row_rs1["Baltot"], 2, ".", ",");
}


/*	$sql_rst= "select * from tmpretchkana";
	$txthd= "As At Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ret. Chq. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%";
	$result_rst =$db->RunQuery($sql_rst);
	while($row_rst = mysql_fetch_array($result_rst)){
		switch ()
	Select Case rst.AbsolutePosition
Case 1
      m_Report.txtde1.SetText Format(rst!SDATE, "dd-MMM-yyyy") . Space(10) . Space(5) . Format(rst!ret, "###,###.00") . Space(10) . Format(rst!pr, "###,###.00")
Case 2
      m_Report.txtde2.SetText Format(rst!SDATE, "dd-MMM-yyyy") . Space(10) . Space(5) . Format(rst!ret, "###,###.00") . Space(10) . Format(rst!pr, "###,###.00")
Case 3
      m_Report.txtde3.SetText Format(rst!SDATE, "dd-MMM-yyyy") . Space(10) . Space(5) . Format(rst!ret, "###,###.00") . Space(10) . Format(rst!pr, "###,###.00")
Case 4
      m_Report.txtde4.SetText Format(rst!SDATE, "dd-MMM-yyyy") . Space(10) . Space(5) . Format(rst!ret, "###,###.00") . Space(10) . Format(rst!pr, "###,###.00")
Case 5
      m_Report.txtde5.SetText Format(rst!SDATE, "dd-MMM-yyyy") . Space(10) . Space(5) . Format(rst!ret, "###,###.00") . Space(10) . Format(rst!pr, "###,###.00")

End Select
rst.MoveNext
Loop
*/
	$result_sql =$db->RunQuery($sql);
	$row_tot = mysql_fetch_array($result_sql);
	$txtBal=number_format($row_tot["Baltot"], 2, ".", ",");
	$txtChAmt=number_format($row_tot["chtot"], 2, ".", ",");
	$txtTotCHa=number_format($row_tot["BchaTot"], 2, ".", ",");


 	$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
	if ($_GET["radio"] == "optunsettle") { 
		$heading = "Unsettle Return Cheque Report on  " .date("Y-m-d"). " Sales Rep. ".$_GET["cmbrep"];
	}	
	if ($_GET["radio"] == "optall") { 
		$heading = "Return Cheque Report From  " .$_GET["dtfrom"]. " To  Sales Rep. ".$_GET["dtto"];
	}	

	echo "<center><table border=1><tr>
		<th>Return Date</th>
		<th>Cheq. No</th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th>Rep</th>
		<th colspan=3>Settlement Summery</th>
		<th>Days</th>
		<th>Invoice_Date</th>
		<th>Settled Amount</th>
		<th></th>
		<th>Prev. Cheque No</th>
		</tr>";
		//echo $sql;
		$totgross=0;
		$totvat=0;
		$totnet=0;
		
		$i=0;
		$tototbal=0;
		$totot=0;
		
		$sql_PrInv=$sql_PrInv." order by CODE, CR_CHNO, ST_CHNO, invoice_no"; 
		//echo $sql_PrInv;
		$result_PrInv =$db->RunQuery($sql_PrInv);
		while($row_PrInv = mysql_fetch_array($result_PrInv)){	
		  
		  if ($name!=$row_PrInv["NAME"]){
		  	
			if ($i==1){
				echo "<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				
				<td align=right><b>".number_format($totbal, 2, ".", ",") ."</b></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>";
				echo "</tr>";	
			}
		  	echo "<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan=4><b>".$row_PrInv["CODE"]." ".$row_PrInv["NAME"]." - ".$row_PrInv["ADD2"]."</b></td>
			
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>";
			echo "</tr>";
			$name=$row_PrInv["NAME"];
			
			$i=1;
			$totbal=0;
			
		  }
		  
		  if ($ch_no!=$row_PrInv["CR_CHNO"]){
			echo "<tr>
			<td>".$row_PrInv["CR_DATE"]."</td>
			<td>".$row_PrInv["CR_CHNO"]."</td>";
			$ch_no=$row_PrInv["CR_CHNO"];
			echo "<td>".$row_PrInv["rep_remark"]." ".$row_PrInv["CR_CHDATE"]."</td>
			<td align=right>".number_format($row_PrInv["CR_CHEVAL"], 2, ".", ",")."</td>";
			
			$bal=$row_PrInv["CR_CHEVAL"]-$row_PrInv["PAID"];
			echo "<td align=right>".number_format($bal, 2, ".", ",")."</td>";
			
			$totbal=$totbal+$bal;
			$tototbal=$tototbal+$bal;
			$totot=$totot+$row_PrInv["CR_CHEVAL"];
					
			if ($bal > 1) {
			 					
				$diff = abs(strtotime($row_PrInv["CR_CHDATE"]) - strtotime(date("Y-m-d")));
				$days = floor($diff / (60*60*24));
				
			 } else if ($row_PrInv["ST_FLAG"] == "UT") { 
			 	
				$diff = abs(strtotime($row_PrInv["CR_CHDATE"]) - strtotime($row_PrInv["ST_DATE"]));
				$days = floor($diff / (60*60*24));
			 	
			 }	else {
			 	
				$diff = abs(strtotime($row_PrInv["CR_CHDATE"]) - strtotime($row_PrInv["ST_INDATE"]));
				$days = floor($diff / (60*60*24));
			 }	
			echo "<td>".$days."</td>
			<td>".$row_PrInv["S_REF"]."</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>";
			echo "</tr>";
		  }		
			if (($row_PrInv["ST_CHNO"]!="") and (is_null($row_PrInv["ST_CHNO"])==false)){
				
				if (($ST_CHNO!=$row_PrInv["ST_CHNO"]) and ($ST_INDATE!=$row_PrInv["ST_INDATE"])	 and ($ST_PAID!=$row_PrInv["ST_PAID"])) {		
				
					$ST_CHNO=$row_PrInv["ST_CHNO"];
					$ST_INDATE=$row_PrInv["ST_INDATE"];
					$ST_PAID=$row_PrInv["ST_PAID"];
				
					echo "<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>";
			
					if (is_null($row_PrInv["ST_INDATE"])){ 
						$diff = abs(strtotime($row_PrInv["CR_DATE"]) - strtotime($row_PrInv["ST_INDATE"]));
						$days = floor($diff / (60*60*24));
					} else {
						$diff = abs(strtotime($row_PrInv["CR_DATE"]) - strtotime($row_PrInv["ST_DATE"]));
						$days = floor($diff / (60*60*24));
					}	
					
					echo "<td>".$days."</td>
					<td>&nbsp;</td>
					<td>".$row_PrInv["ST_CHNO"]."</td>";
					if (($row_PrInv["ST_INDATE"]!="1970-01-01") and ($row_PrInv["ST_INDATE"]!="0000-00-00") and (is_null($row_PrInv["ST_INDATE"])==false)) {
						echo "<td>".$row_PrInv["ST_INDATE"]."</td>";
					} else {
						echo "<td>&nbsp;</td>";
					}	
					echo "<td align=right>".$row_PrInv["ST_PAID"]."</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>";
					echo "</tr>";
				}	
			}
			
		if ($invoice_no!=$row_PrInv["invoice_no"]){
			$invoice_no=$row_PrInv["invoice_no"];
			echo "<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>";
					
					if ($bal > 1) {
						$diff = abs(strtotime($row_PrInv["invoice_date"]) - strtotime(date("Y-m-d")));
						$daysin = floor($diff / (60*60*24));
					 
					}	else if ($row_PrInv["ST_FLAG"]== "UT") { 
						$diff = abs(strtotime($row_PrInv["invoice_date"]) - strtotime($row_PrInv["ST_DATE"]));
						$daysin = floor($diff / (60*60*24));
						
					} else {
						$diff = abs(strtotime($row_PrInv["invoice_date"]) - strtotime($row_PrInv["ST_INDATE"]));
						$daysin = floor($diff / (60*60*24));
					}
					echo "<td><font color=\"#FF0000\"><b>".$daysin."</b></font></td>
					<td>".$row_PrInv["invoice_date"]."</td>
					<td>".$row_PrInv["invoice_amt"]."</td>
					<td>".$row_PrInv["noof"]."</td>
					<td>".$row_PrInv["FORwhat"]."</td>";
					echo "</tr>";
					
			}
		}
		echo "<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align=right><b>".number_format($totot, 2, ".", ",") ."</b></td>
				
				<td align=right><b>".number_format($tototbal, 2, ".", ",") ."</b></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>";
				echo "</tr>";	
	
/////////// Sales Summery////////////////////////////////////////
function AsAtValue($dtdate){

require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();


if (date('m', strtotime($dtdate)) == "01") {
    $yr = date('Y', strtotime($dtdate)) - 1;
    $Mon = 12;
} else {
    $yr = date('Y', strtotime($dtdate));
    $Mon =date('m', strtotime($dtdate)) - 1;
}

if ($_GET["cmbrep"]=="All"){
	$sql_rst= "select sum(GRAND_TOT/(1+GST/100)) as sale from s_salma where Accname != 'NON STOCK' and year(SDATE)='" . $yr . "' and month(SDATE)='" . $Mon . "' and CANCELL=0 ";
} else {
	$sql_rst= "select sum(GRAND_TOT/(1+GST/100)) as sale from s_salma where Accname != 'NON STOCK' and year(SDATE)='" . $yr . "' and month(SDATE)='" . $Mon . "' and SAL_EX='" . trim($_GET["cmbrep"]) . "' and CANCELL=0 ";
}

$result_rst =$db->RunQuery($sql_rst);
if($row_rst = mysql_fetch_array($result_rst)){
if (is_null($row_rst["sale"])==false) { 
	$sale = $row_rst["sale"];
}
}	

if ($_GET["cmbrep"]=="All"){
	$rst= "select sum(AMOUNT/(1+vatrate/100)) as ret from c_bal where year(SDATE)='" . $yr . "' and month(SDATE)='" . $Mon . "' and trn_type!='REC' and trn_type!='ARN' and trn_type!='PAY' and CANCELL=0 ";
} else {
	$rst= "select sum(AMOUNT/(1+vatrate/100)) as ret from c_bal where year(SDATE)='" . $yr . "' and month(SDATE)='" . $Mon . "' and trn_type!='REC' and trn_type!='ARN' and trn_type!='PAY' and SAL_EX='" . trim($_GET["cmbrep"]) . "' and CANCELL=0 ";
}	
$result_rst =$db->RunQuery($sql_rst);
if($row_rst = mysql_fetch_array($result_rst)){
	if (is_null($row_rst["sale"])==false) { 
		$sale = $sale-$row_rst["ret"];
	}
}


if ($_GET["cmbrep"]=="All"){
	$rst= "select * from s_cheq where  CR_DATE <'" . $dtdate . "' and CR_FLAG='0'  ";
} else {
	$rst= "select * from s_cheq where  CR_DATE <'" . $dtdate . "' and CR_FLAG='0' and S_REF='" . trim($_GET["cmbrep"]) . "' ";
}	
$result_rst =$db->RunQuery($sql_rst);
while($row_rst = mysql_fetch_array($result_rst)){
	$stt= "select sum(ST_PAID+1) as (totPAID+1) from ch_sttr where ST_INVONO='" . $row_rst["CR_REFNO"] . "' and ST_DATE <'" . $dtdate . "'";
	$result_stt =$db->RunQuery($stt);
	echo $stt;
	$row_stt = mysql_fetch_array($result_stt);

	if (is_null($row_stt["totPAID"])==false) { 
		$sttAmt = $sttAmt + $row_stt["totPAID"] + 1;
	}	
}

if ($_GET["cmbrep"]=="All"){
	$rst="select sum(CR_CHEVAL) as chval from s_cheq where  CR_DATE <'" . $dtdate . "'and CR_FLAG='0'  ";
} else {
	$rst="select sum(CR_CHEVAL) as chval from s_cheq where  CR_DATE <'" . $dtdate . "'and CR_FLAG='0' and S_REF='" . trim($_GET["cmbrep"]) . "' ";
}
$result_rst =$db->RunQuery($rst);
$row_rst = mysql_fetch_array($result_rst);
if (is_null($row_rst["chval"])==false) { 
	$RETCHQ = $row_rst["chval"];
}	

if ($sale > 0 ){ 
	$pr = ($RETCHQ - $sttAmt) / $sale * 100;
	$rst="insert into tmpretchkana (sdate,SAle,ret,Pr) values ('" . $dtdate . "' ," . $sale . ", " . $RETCHQ - $sttAmt . "," . $pr . ")";
	$result_rst =$db->RunQuery($rst);
}

}	










?>



</body>
</html>
