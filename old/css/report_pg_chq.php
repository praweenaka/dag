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
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	if ($_GET["radio"]=="Option1") { opt1(); }	
	if ($_GET["radio"]=="Option2") { optgroop(); }	
	if ($_GET["radio"]=="optAsAt") { asatrep(); }	


	


/////////// Sales Summery////////////////////////////////////////
function opt1()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	
if ($_GET["CHK_RTN"] != "on") {
    if ($_GET["com_rep"] == "All") {
    if ($_GET["chkperiod"] != "on") {
        if ($_GET["Check1"] != "on") { 
			$sql = "SELECT * from view_s_invcheq where (che_date >' " . date("Y-m-d") . "' or che_date =' " . date("Y-m-d") . "') and (sdate <' " . date("Y-m-d") . "' or sdate =' " . date("Y-m-d") . "') order by che_date ";
		}	
        if ($_GET["Check1"] == "on") { 
			$sql = "SELECT * from view_s_invcheq where cus_code='" . $_GET["cuscode"] . "' and (che_date >' " . date("Y-m-d") . "'or che_date =' " . date("Y-m-d") . "') and (sdate <' " . date("Y-m-d") . "' or sdate =' " . date("Y-m-d") . "') order by che_date";
		}	
    }
     
    if ($_GET["chkperiod"] == "on") {
        if ($_GET["Check1"] == "on") { 
			$sql = "SELECT * from view_s_invcheq where  ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "')  order by che_date ";
		}	
        if ($_GET["Check1"] == "on") { 
			$sql = "SELECT * from view_s_invcheq where cus_code='" . $_GET["cuscode"] . "'  and ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "')  order by che_date";
		}	
    }
    }
    
    if ($_GET["com_rep"] != "All") {
    if ($_GET["chkperiod"] != "on") {
        if ($_GET["Check1"] != "on") { 
			$sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and (che_date >' " . date("Y-m-d") . "' or che_date =' " . date("Y-m-d") . "') and sal_ex ='" . $_GET["com_rep"] . "' and (sdate <' " . date("Y-m-d") . "' or sdate =' " . date("Y-m-d") . "') order by che_date ";
		}	
        if ($_GET["Check1"] == "on") { 
			$sql = "SELECT * from view_s_invcheq where cus_code='" . $_GET["cuscode"] . "' and (che_date >' " . date("Y-m-d") . "'or che_date =' " . date("Y-m-d") . "') and sal_ex ='" . $_GET["com_rep"] . "' and (sdate <' " . date("Y-m-d") . "' or sdate =' " . date("Y-m-d") . "') order by che_date";
		}	
    }
     
    if ($_GET["chkperiod"] == "on") {
        if ($_GET["Check1"] != "on") { 
			$sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and  ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "') and sal_ex ='" . $_GET["com_rep"] . "'  order by che_date ";
		}	
        if ($_GET["Check1"] == "on") { 
			$sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and  cus_code='" . $_GET["cuscode"] . "'  and ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "') and sal_ex ='" . $_GET["com_rep"] . "'  order by che_date";
		}	
    }
    }
} else {
    if ($_GET["com_rep"] == "All") {
    if ($_GET["chkperiod"] != "on") {
        if ($_GET["Check1"] == "on") { 
			$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and (che_date >' " . date("Y-m-d") . "' or che_date =' " . date("Y-m-d") . "') and (sdate <' " . date("Y-m-d") . "' or sdate =' " . date("Y-m-d") . "') order by che_date ";
		}	
        if ($_GET["Check1"] == "on") { 
			$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and cus_code='" . $_GET["cuscode"] . "' and (che_date >' " . date("Y-m-d") . "'or che_date =' " . date("Y-m-d") . "') and (sdate <' " . date("Y-m-d") . "' or sdate =' " . date("Y-m-d") . "') order by che_date";
		}
    }
     
    if ($_GET["chkperiod"] == "on") {
        if ($_GET["Check1"] != "on") { 
			$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and  ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "')  order by che_date ";
		}	
        if ($_GET["Check1"] == "on") { 
			$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and cus_code='" . $_GET["cuscode"] . "'  and ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "')  order by che_date";
		}	
    }
    }
    
    if ($_GET["com_rep"] <> "All") {
    if ($_GET["chkperiod"] != "on") {
        if ($_GET["Check1"] != "on") { 
			$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and ch_count_ret='0' and (che_date >' " . date("Y-m-d") . "' or che_date =' " . date("Y-m-d") . "') and sal_ex ='" . $_GET["com_rep"] . "' and (sdate <' " . date("Y-m-d") . "' or sdate =' " . date("Y-m-d") . "') order by che_date ";
		}	
        if ($_GET["Check1"] == "on") { 
			$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and cus_code='" . $_GET["cuscode"] . "' and (che_date >' " . date("Y-m-d") . "'or che_date =' " . date("Y-m-d") . "') and sal_ex ='" . $_GET["com_rep"] . "' and (sdate <' " . date("Y-m-d") . "' or sdate =' " . date("Y-m-d") . "') order by che_date";
		}	
    }
     
    if ($_GET["chkperiod"] == "on") {
        if ($_GET["Check1"] == "on") { 
			$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and ch_count_ret='0' and  ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "') and sal_ex ='" . $_GET["com_rep"] . "'  order by che_date ";
		}	
        if ($_GET["Check1"] == "on") { 
			$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and ch_count_ret='0' and  cus_code='" . $_GET["cuscode"] . "'  and ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "') and sal_ex ='" . $_GET["com_rep"] . "'  order by che_date";
		}	
    }
    }
}

if ($_GET["chkperiod"] != "on") {
	if ($_GET["Check1"]!="on") { 
		$rtxtdate="Pending Cheque Report On   " . date("Y-m-d") . "     All";
	}	
	if ($_GET["Check1"]!="on") {  
		$rtxtdate= "Pending Cheque Report On   " . date("Y-m-d") . "     " . $_GET["cuscode"] . "  " . $_GET["cusname"];
	}	
}

if ($_GET["chkperiod"] == "on") {
	if ($_GET["Check1"]!="on") { 
		$rtxtdate= " Cheque Report From   " . $_GET["dtfrom"] . "   To " . $_GET["dtto"] . "     All";
	}	
	if ($_GET["Check1"]!= "on") { 
		$rtxtdate =" Cheque Report On   " . $_GET["dtfrom"] . "   TO   " . $_GET["dtto"] . "   " . $_GET["cuscode"] . "  " . $_GET["cusname"];
	}	
}
	
	$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
		echo "<center>".$rtxtdate."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>Cust Code</th>
		<th>Customer</th>
		<th>Cheque No</th>
		<th>Cheque Date</th>
		<th>Bank</th>
		<th>Amount</th>
		</tr>";
		//echo $sql;
		
		$che_amount=0;
		$result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result)){	
			echo "<tr>
			<td>".$row["cus_code"]."</td>
			<td>".$row["CUS_NAME"]."</td>
			<td>".$row["cheque_no"]."</td>
			<td>".$row["che_date"]."</td>
			<td>".$row["bank"]."</td>
			<td>".number_format($row["che_amount"], 2, ".", ",")."</td>
			
			</tr>";
			$che_amount=$che_amount+$row["che_amount"];
		}
		
		echo "<tr>
			<td colspan=5></td>
			<td><b>".number_format($che_amount, 2, ".", ",")."</b?</td>
			
			</tr>";
			
		echo "<table>";
		
}

	
	
	
function optgroop()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	if ($_GET["CHK_RTN"] != "on") {
    	if ($_GET["com_rep"] == "All") {
    		if ($_GET["chkperiod"] != "on") {
    			if ($_GET["Check1"]!="on") { 
					$sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and (che_date >' " . date("Y-m-d") . "' or che_date =' " . date("Y-m-d") . "') order by che_date ";
				}	
    			if ($_GET["Check1"]=="on") { 
					$sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and cus_code='" .  $_GET["cuscode"] . "' and (che_date >' " . date("Y-m-d") . "'or che_date =' " . date("Y-m-d") . "') order by che_date";
				}	
    		}
    		if ($_GET["chkperiod"] == "on") {
        		if ($_GET["Check1"]!="on") { 
					$sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and  ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "')  order by che_date ";
				}	
        		if ($_GET["Check1"]=="on") { 
					$sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and cus_code='" . $_GET["cuscode"] . "'  and ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "')  order by che_date";
				}	
    		}
    	} else {
    		if ($_GET["chkperiod"] != "on") {
    			if ($_GET["Check1"]!="on") { 
					$sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and (che_date >' " . date("Y-m-d") . "' or che_date =' " . date("Y-m-d") . "') and sal_ex ='" . $_GET["com_rep"] . "' order by che_date ";
				}	
    			if ($_GET["Check1"]=="on") { 
					$sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and cus_code='" . $_GET["cuscode"] . "' and (che_date >' " . date("Y-m-d") . "'or che_date =' " . date("Y-m-d") . "') and sal_ex ='" . $_GET["com_rep"] . "' order by che_date";
				}	
    		}
    		if ($_GET["chkperiod"] == "on") {
        		if ($_GET["Check1"]!="on") { 
					$sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and  ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "') and sal_ex ='" . $_GET["com_rep"] . "' order by che_date ";
				}	
        		if ($_GET["Check1"]=="on") { 
					$sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and cus_code='" . $_GET["cuscode"] . "'  and ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "') and sal_ex ='" . $_GET["com_rep"] . "' order by che_date";
				}	
    		}
    	}
	} else {
    	if ($_GET["com_rep"] == "All") {
    		if ($_GET["chkperiod"] != "on") {
    			if ($_GET["Check1"]!="on") { 
					$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and ch_count_ret='0' and (che_date >' " . date("Y-m-d") . "' or che_date =' " . date("Y-m-d") . "') order by che_date ";
				}	
    			if ($_GET["Check1"]=="on") { 
					$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and ch_count_ret='0' and cus_code='" . $_GET["cuscode"] . "' and (che_date >' " . date("Y-m-d") . "'or che_date =' " . date("Y-m-d") . "') order by che_date";
				}	
    		}
    		if ($_GET["chkperiod"] == "on") {
        		if ($_GET["Check1"]!="on") { 
					$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and ch_count_ret='0' and  ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "')  order by che_date ";
				}	
        		if ($_GET["Check1"]=="on") { 
					$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and ch_count_ret='0' and cus_code='" . $_GET["cuscode"] . "'  and ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "')  order by che_date";
				}	
    		}
    	}else{
    		if ($_GET["chkperiod"] != "on") {
    			if ($_GET["Check1"]!="on") { 
					$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and ch_count_ret='0' and (che_date >' " . date("Y-m-d") . "' or che_date =' " . date("Y-m-d") . "') and sal_ex ='" . $_GET["com_rep"] . "' order by che_date ";
				}	
    			if ($_GET["Check1"]=="on") { 
					$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and ch_count_ret='0' and cus_code='" . $_GET["cuscode"] . "' and (che_date >' " . date("Y-m-d") . "'or che_date =' " . date("Y-m-d") . "') and sal_ex ='" . $_GET["com_rep"] . "' order by che_date";
				}	
    		}
    		if ($_GET["chkperiod"] == "on") {
        		if ($_GET["Check1"]!="on") { 
					$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and ch_count_ret='0' and  ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "') and sal_ex ='" . $_GET["com_rep"] . "' order by che_date ";
				}	
        		if ($_GET["Check1"]=="on") { 
					$sql = "SELECT * from view_s_invcheq where trn_type = 'RET' and ch_count_ret='0' and cus_code='" . $_GET["cuscode"] . "'  and ( che_date>'" . $_GET["dtfrom"] . "' or che_date ='" . $_GET["dtfrom"] . "')  and ( che_date<'" . $_GET["dtto"] . "' or che_date ='" . $_GET["dtto"] . "') and sal_ex ='" . $_GET["com_rep"] . "' order by che_date";
				}	
    		}
    	}
	}	
	
	$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>Customer</th>
		<th>Cheque No</th>
		<th>Cheque Date</th>
		<th>Bank</th>
		<th>Amount</th>
		</tr>";
		//echo $sql;
	
		$result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result)){	
			echo "<tr>
			<td>".$row["cus_code"]."</td>
			<td>".$row["CUS_NAME"]."</td>
			<td>".$row["cheque_no"]."</td>
			<td>".$row["che_date"]."</td>
			<td>".$row["bank"]."</td>
			<td>".number_format($row["che_amount"], 2, ".", ",")."</td>
			
			</tr>";
		}
		
		echo "<table>";
}	

function asatrep()
{
if ($_GET["CHK_RTN"] != "on") {
    if ($_GET["com_rep"] == "All") {
       $sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and (che_date >'" . $_GET["dtasatDate"] . "' or che_date ='" . $_GET["dtasatDate"] . "') and sdate<='" . $_GET["dtasatDate"] . "' order by che_date ";
	} else {
       $sql = "SELECT * from view_s_invcheq where ch_count_ret='0' and (che_date >'" . $_GET["dtasatDate"] . "' or che_date ='" . $_GET["dtasatDate"] . "') and sdate<='" . $_GET["dtasatDate"] . "' and sal_ex ='" . $_GET["com_rep"] . "' order by che_date ";
    }
} else {
    if ($_GET["com_rep"] == "All") {
       $sql = "SELECT * from view_s_invcheq where trn_type = 'RTN' and ch_count_ret='0' and (che_date >'" . $_GET["dtasatDate"] . "' or che_date ='" . $_GET["dtasatDate"] . "') and sdate<='" . $_GET["dtasatDate"] . "' order by che_date ";
    } else {
       $sql = "SELECT * from view_s_invcheq where trn_type = 'RTN' and ch_count_ret='0' and (che_date >'" . $_GET["dtasatDate"] . "' or che_date ='" . $_GET["dtasatDate"] . "') and sdate<='" . $_GET["dtasatDate"] . "' and sal_ex ='" . $_GET["com_rep"] . "' order by che_date ";
    }
}

	$rtxtdate= "Pending Cheque Report As At    " .$_GET["dtasatDate"];
}
	








?>



</body>
</html>
