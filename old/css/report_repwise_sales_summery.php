<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sales Summery</title>
<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
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




	if ($_GET["salesrep"]=="All") { repoall(); }
	if ($_GET["salesrep"]!="All") { reporecrd(); }
	

if ($_GET["radio2"]=="optdate") { 
	
}


/////////// Sales Summery////////////////////////////////////////
function repoall()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	if ($_GET["cmbdev"] == "All") { $dev = "A"; }
	if ($_GET["cmbdev"] == "Manual") { $dev = "0"; }
	if ($_GET["cmbdev"] == "Computer") { $dev = "1"; }
	
	$sql = "delete from tmprepsale";
	$result =$db->RunQuery($sql);
	//$row = mysql_fetch_array($result);
	
	$sql_rep = "SELECT * FROM s_salrep where cancel = '0' order by REPCODE desc";
	$result_rep =$db->RunQuery($sql_rep);
	while ($row_rep = mysql_fetch_array($result_rep)){
	
   		$mname = "";
   		if (is_null($row_rep["Name"])==false) { 
			$mname = trim($row_rep["Name"]);
   		}
			$SAL = 0;
   			$ret = 0;
   			$mnet = 0;

   		if ($_GET["cmbbrand"] == "All") { 
			$sql_rst= "SELECT * FROM s_salma where   Accname != 'NON STOCK' and SAL_EX='".$row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "' or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' and DEV!='" . $dev . "'";
		}	
   			
		if ($_GET["cmbbrand"] != "All"){  
			$sql_rst="SELECT * FROM s_salma where Accname != 'NON STOCK' and Brand='" . $_GET["cmbbrand"] . "' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' and DEV!='" . $dev . "'";
		}	

		$result_rst =$db->RunQuery($sql_rst);
		while ($row_rst = mysql_fetch_array($result_rst)){
	  		$SAL = $SAL + $row_rst["GRAND_TOT"];
      		$mnet = $mnet + ($row_rst["GRAND_TOT"] / (1 + ($row_rst["GST"] / 100)));
      	}

		if ($_GET["cmbbrand"] == "All") {
   			if ($_GET["chkdef"] != "on") { 
				$sql_rst2= "SELECT * FROM c_bal WHERE  (flag1 = '0') and SAL_EX='" .$row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
			}	
   				
			if ($_GET["chkdef"] == "on") { 
				$sql_rst2= "SELECT * FROM c_bal WHERE  (flag1 = '0') and SAL_EX='" .$row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
			}	
			
		} else {
   				
			if ($_GET["chkdef"] != "on") { 
				$sql_rst2= "SELECT * FROM c_bal WHERE (flag1 = '0') and brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
			}	
  				
			if ($_GET["chkdef"] == "on") { 
					$sql_rst2= "SELECT * FROM c_bal WHERE (flag1 = '0') and brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
			}
		}
		
		$result_rst2 =$db->RunQuery($sql_rst2);
		while ($row_rst2 = mysql_fetch_array($result_rst2)){
   			$ret = $ret + $row_rst2["AMOUNT"];
   			$mnet = $mnet - ($row_rst2["AMOUNT"] / (1 + ($row_rst2["vatrate"] / 100)));

		}	
	
		$sql_tem="insert into tmprepsale(rep, grossale, grossgrn, Name, rgroup, net) values ('".trim($row_rep["REPCODE"])."', ".$SAL.", ".$ret.", '".$mname."', '".trim($row_rep["RGROUP"])."', ".$mnet.")";
		$result_tem =$db->RunQuery($sql_tem);
	
	}
	
			
	if ($_GET["chkdef"] != "on") { 
		$txtName= "Rep wise Sales Summery (Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
	}	
	
	if ($_GET["chkdef"] == "on") { 
		$txtName= "Rep wise Sales Summery (with Defective)(Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
	}


	$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
		echo "<center>".$txtName."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		</tr>";
		//echo $sql;
		$totgrossale=0;
		$totgrossgrn=0;
		$totnet=0;
		
		$chk=0;
					
		$sql="select * from tmprepsale order by rgroup";
		$result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result)){	
			if ($row["rgroup"]!=$rgroup){
				if  ($grossale !=0) {
					$grngrp=$grossgrn/$grossale*100;
				} else { 
					$grngrp=0;
				}
				
				if ($chk!=0){
					echo "<tr><td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"right\"><b>".number_format($grossale, 2, ".", ",")."</b></td>
					<td align=\"right\"><b>".number_format($grossgrn, 2, ".", ",")."</b></td>
					<td align=\"right\"><b>".number_format($grngrp, 2, ".", ",")."</b></td>
					<td align=\"right\"><b>".number_format($net, 2, ".", ",")."</b></td>
					</tr>";
				}	
				$chk=1;
				echo "<tr>
					<td colspan=4 align=left><b>".$row["rgroup"]."</b></td>
					<tr>";
					$grossale=0;
					$grossgrn=0;
					$net=0;
			}
			if (($row["grossale"]>0) or ($row["grossgrn"]>0) or ($row["net"]>0)){
				
				if  ($row["grossale"] !=0) {
					$grn=$row["grossgrn"]/$row["grossale"]*100;
				} else { 
					$grn=0;
				}
	
				echo "<tr><td>".$row["rep"]."</td>
				<td>".$row["Name"]."</td>
				<td align=\"right\">".number_format($row["grossale"], 2, ".", ",")."</td>
				<td align=\"right\">".number_format($row["grossgrn"], 2, ".", ",")."</td>
				<td align=\"right\">".number_format($grn, 2, ".", ",")."</td>
				<td align=\"right\">".number_format($row["net"], 2, ".", ",")."</td>
				</tr>";
				
				$grossale=$grossale+$row["grossale"];
				$grossgrn=$grossgrn+$row["grossgrn"];
				$net=$net+$row["net"];
				
				$totgrossale=$totgrossale+$row["grossale"];
				$totgrossgrn=$totgrossgrn+$row["grossgrn"];
				$totnet=$totnet+$row["net"];
			}	
			$rgroup=$row["rgroup"];
		}
		
				if  ($totgrossale !=0) {
					$totgrngrp=$totgrossgrn/$totgrossale*100;
				} else { 
					$grngrp=0;
				}
				
				echo "<tr><td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align=\"right\"><b>".number_format($totgrossale, 2, ".", ",")."</b></td>
				<td align=\"right\"><b>".number_format($totgrossgrn, 2, ".", ",")."</b></td>
				<td align=\"right\"><b>".number_format($totgrngrp, 2, ".", ",")."</b></td>
				<td align=\"right\"><b>".number_format($totnet, 2, ".", ",")."</b></td>
				</tr>";
				
		echo "<table>";
}

function reporecrd()
{
	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	if ($_GET["cmbdev"] == "All") { $dev == "A"; }
	if ($_GET["cmbdev"] == "Manual") { $dev = "0"; }
	if ($_GET["cmbdev"] == "Computer") { $dev = "1"; }
	
	$sql = "delete from tmprepsale";
	$result =$db->RunQuery($sql);

	
	$sql_rep = "SELECT * FROM s_salrep where REPCODE='" .$_GET["salesrep"]. "' and cancel = '0' order by REPCODE desc";
	$result_rep =$db->RunQuery($sql_rep);
	while ($row_rep = mysql_fetch_array($result_rep)){

   		$mname = "";
   		if (is_null($row_rep["Name"])==false) { 
			$mname = $row_rep["Name"];
		}
			$SAL = 0;
			$ret = 0;
			$mnet = 0;

   		if ($_GET["cmbbrand"] == "All") { 
			$sql_rst = "SELECT * FROM s_salma where Accname != 'NON STOCK' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "' or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' and DEV!='" . $dev . "'";
		}	
   		
		if ($_GET["cmbbrand"] != "All") { 
			$sql_rst = "SELECT * FROM s_salma where Accname != 'NON STOCK' and Brand='" . $_GET["cmbbrand"] . "' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' and DEV!='" . $dev . "'";
		}	
		//echo $sql_rst;
		$result_rst =$db->RunQuery($sql_rst);
		while ($row_rst = mysql_fetch_array($result_rst)){
   			$SAL = $SAL + $row_rst["GRAND_TOT"];
		   	$mnet = $mnet + ($row_rst["GRAND_TOT"] / (1 + ($row_rst["GST"] / 100)));
   		}

   		if ($_GET["cmbbrand"] == "All") {
      		if ($_GET["chkdef"] != "on") { 
			
				$sql_rst2= "SELECT * FROM c_bal WHERE  (flag1 = '0') and SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
			}	
      		
			if ($_GET["chkdef"] == "on") { 
				$sql_rst2= "SELECT * FROM c_bal WHERE  (flag1 = '0') and SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
			}	
   		} else {
      		
			if ($_GET["chkdef"] != "on") { 
				$sql_rst2= "SELECT * FROM c_bal WHERE (flag1 = '0') and brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
			}	
      		
			if ($_GET["chkdef"] == "on") { 
	  			$sql_rst2= "SELECT * FROM c_bal WHERE (flag1 = '0') and brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
  			}
		}	
	

		$result_rst2 =$db->RunQuery($sql_rst2);
		while ($row_rst2 = mysql_fetch_array($result_rst2)){
   			$ret = $ret + $row_rst2["AMOUNT"];
   			$mnet = $mnet - ($row_rst2["AMOUNT"] / (1 + ($row_rst2["vatrate"] / 100)));
		}


		$sql_tem="insert into tmprepsale(rep, grossale, grossgrn, Name, net) values ('".$row_rep["REPCODE"]."', ".$SAL.", ".$ret.", '".$mname."', ".$mnet.")";
		$result_tem =$db->RunQuery($sql_tem);
		
	}
	
	if ($_GET["chkdef"] != "on") { 
		$txtName= "Rep wise Sales Summery (Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
	}	
	
	if ($_GET["chkdef"] == "on") { 
		$txtName= "Rep wise Sales Summery (with Defective)(Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
	}


	$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
		echo "<center>".$txtName."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>Rep Code</th>
		<th>Rep Name</th>
		<th>Gross Sales</th>
		<th>Gross Return</th>
		<th>Net Sales</th>
		</tr>";
		//echo $sql;
		$sql="select * from tmprepsale order by rgroup";
		$result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result)){	
			if ($row["rgroup"]!=$rgroup){
				echo "<tr>
					<td colspan=4 align=left><b>".$row["rgroup"]."</b></td>
					<tr>";
			}		
			echo "<td>".$row["rep"]."</td>
			<td>".$row["Name"]."</td>
			<td align=\"right\">".number_format($row["grossale"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["grossgrn"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["net"], 2, ".", ",")."</td>
			</tr>";
			$rgroup=$row["rgroup"];
		}
		
		echo "<table>";


}






?>



</body>
</html>
