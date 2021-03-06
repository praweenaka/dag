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

	//echo "dddddddddd ". $_GET["cmbtype"];
	if ($_GET["cmbdev"] == "All") { $GLOBALS[$dev] = "A"; }
	if ($_GET["cmbdev"] == "Manual") { $GLOBALS[$dev] = "1"; }
	if ($_GET["cmbdev"] == "Computer") { $GLOBALS[$dev] = "0"; }
	

	if ($_GET["cmbtype"] == "Detail") 
	{ 
		prin(); 
	} else if($_GET["chk_over25"]=="on"){
		prin_over25();
	} else if($_GET["Chk_cus_wise"]!="on"){
		//prin_summery();
	} else {	
		//prin_summery_cuswise();
	}
	


/////////// Sales Summery////////////////////////////////////////
function prin()
{
require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$sql_tmp= "delete from tmpqtysale";
        	$result_tmp =$db->RunQuery($sql_tmp);
	
	//$sql="select * from tmpqtysale";
	//$result =$db->RunQuery($sql);

		
if ($_GET["cmbbrand"] == "All") {
    if ($_GET["cmbrep"] != "All") {
      if ($_GET["Chk_cus"] == "on") {
        if ($_GET["cuscode"] == "") {
        	exit("Cusomer Not Selected");
        }
		
        if ($GLOBALS[$dev] == "A") { 
			$sql = "SELECT * from viewinv where SAL_EX='" . $_GET["cmbrep"] . "' and cus_code='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and STK_NO != 'SC01' ";
			//echo "1";
		}
        if ($GLOBALS[$dev] != "A") { 
			$sql = "SELECT * from viewinv where SAL_EX='" . $_GET["cmbrep"] . "' and cus_code='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
			//echo "2";
		}	
        
		$result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result)){
			$sql_rep="select name from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
			$result_rep =$db->RunQuery($sql_rep);
			$row_rep = mysql_fetch_array($result_rep);
			
        	$sql_tmp= "insert into tmpqtysale (SDATE,refno,ccode,cname,INVqty,sal_ex,repname,stkno,description,brand) values('" . $row["SDATE"] . "', '" . trim($row["REF_NO"]) . "', '" . trim($row["cus_code"]) . "','" . trim($row["CUS_NAME"]) . "', " . trim($row["QTY"]) . ", '" . $row["SAL_EX"] . "', '" . $row_rep["Name"] . "','" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["s_brand"] . "') ";
        	$result_tmp =$db->RunQuery($sql_tmp);
        		
        }
        if ($GLOBALS[$dev] == "A") { 
			$sql = "SELECT * from viewcrntrn where SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and STK_NO != 'SC01' ";
			//echo "3";
		}	
        if ($GLOBALS[$dev] != "A") { 
			$sql = "SELECT * from viewcrntrn where SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and dev = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
			//echo "4";
		}	
        $result2 =$db->RunQuery($sql);
		while($row2 = mysql_fetch_array($result2)){
        	$sql_tmp= "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand) values('" . trim($row2["SDATE"]) . "', '" . trim($row2["REF_NO"]) . "', '" . trim($row2["C_CODE"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . $row2["STK_NO"] . "', '" . $row2["DESCRIPT"] . "', '" . $row2["Brand"] . "') ";
			$result_tmp =$db->RunQuery($sql_tmp);
        
        }
      } else {
        if ($GLOBALS[$dev] == "A") { 
			$sql = "SELECT * from viewinv where SAL_EX='" . $_GET["cmbrep"] . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and STK_NO != 'SC01' ";
			//echo "5";
		}	
        if ($GLOBALS[$dev] != "A") { 
			$sql = "SELECT * from viewinv where SAL_EX='" . $_GET["cmbrep"] . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
			//echo "6";
		}	
        $result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result)){
			$sql_rep="select name from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
			$result_rep =$db->RunQuery($sql_rep);
        
        	$sql_tmp=  "insert into tmpqtysale (sdate,refno,ccode,cname,INVqty,sal_ex,repname,stkno,description,brand) values('" . trim($row["SDATE"]) . "', '" . trim($row["REF_NO"]) . "', '" . trim($row["cus_code"]) . "','" . trim($row["CUS_NAME"]) . "'," . trim($row["QTY"]) . ",'" . $row["SAL_EX"] . "','" . $row_rep["Name"] . "','" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["s_brand"] . "') ";
			$result_tmp =$db->RunQuery($sql_tmp);
        }
		
        if ($GLOBALS[$dev] == "A") { 
			$sql = "SELECT * from viewcrntrn where SAL_EX='" . $_GET["cmbrep"] . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and STK_NO != 'SC01' ";
			//echo "7";
		}	
        if ($GLOBALS[$dev] != "A") { 
			$sql = "SELECT * from viewcrntrn where SAL_EX='" . $_GET["cmbrep"] . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01'";
			//echo "8";
		}	
        $result2 =$db->RunQuery($sql);
		while($row2 = mysql_fetch_array($result2)){
        	$sql_tmp= "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand) values('" . trim($row2["SDATE"]) . "','" . trim($row2["REF_NO"]) . "','" . trim($row2["C_CODE"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . $row2["STK_NO"] . "','" . $row2["descript"] . "','" . $row2["Brand"] . "') ";
			$result_tmp =$db->RunQuery($sql_tmp);
        
        }
      }
    } else {
      if ($_GET["Chk_cus"] == "on") {
        
		if ($_GET["cuscode"] == "") {
        	exit("Cusomer Not Selected");
        }
        if ($GLOBALS[$dev] == "A") { 
			$sql = "SELECT * from viewinv where cus_code='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and STK_NO != 'SC01' ";
			//echo $sql."</br>";
			//echo "9";
		}	
        if ($GLOBALS[$dev] != "A") { 
			$sql = "SELECT * from viewinv where cus_code='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
			//echo "10";
		}	
        $result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result)){
			$sql_rep="select name from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
			$result_rep =$db->RunQuery($sql_rep);
        
        	$sql_tmp=  "insert into tmpqtysale (sdate,refno,ccode,cname,INVqty,sal_ex,repname,stkno,description,brand) values('" . trim($row["SDATE"]) . "', '" . trim($row["REF_NO"]) . "','" . trim($row["cus_code"]) . "','" . trim($row["CUS_NAME"]) . "'," . trim($row["QTY"]) . ",'" . $row["SAL_EX"] . "','" . $row_rep["Name"] . "','" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["s_brand"] . "')  ";
			//echo $sql_tmp."</br>";
			$result_tmp =$db->RunQuery($sql_tmp);
		}
        
        if ($GLOBALS[$dev] == "A") { 
			$sql = "SELECT * from viewcrntrn where C_CODE='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and STK_NO != 'SC01' ";
			//echo $sql."</br>";
			//echo "11";
		}	
        if ($GLOBALS[$dev] != "A") { 
			$sql = "SELECT * from viewcrntrn where C_CODE='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Dev = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
			//echo "12";
		}	
        $result2 =$db->RunQuery($sql);
		while($row2 = mysql_fetch_array($result2)){
        	$sql_tmp= "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand) values('" . trim($row2["SDATE"]) . "', '" . trim($row2["REF_NO"]) . "', '" . trim($row2["C_CODE"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . $row2["STK_NO"] . "','" . $row2["descript"] . "','" . $row2["Brand"] . "') ) ";
			//echo $sql_tmp."</br>";
			$result_tmp =$db->RunQuery($sql_tmp);
        
        }
       
      } else {
        if ($GLOBALS[$dev] == "A") { 
			$sql = "SELECT * from viewinv where SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and STK_NO != 'SC01' ";
			//echo "13";
		}	
        if ($GLOBALS[$dev] != "A") { 
			$sql = "SELECT * from viewinv where SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
			//echo "14";
		}
        $result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result)){
			$sql_rep="select name from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
			$result_rep =$db->RunQuery($sql_rep);
        
        	$sql_tmp=  "insert into tmpqtysale (sdate,refno,ccode,cname,INVqty,sal_ex,repname,stkno,description,brand) values('" . trim($row["SDATE"]) . "','" . trim($row["REF_NO"]) . "','" . trim($row["cus_code"]) . "','" . trim($row["CUS_NAME"]) . "'," . trim($row["QTY"]) . ",'" . $row["SAL_EX"] . "','" . $row_rep["Name"] . "','" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["s_brand"] . "')   ";
			$result_tmp =$db->RunQuery($sql_tmp);
		}	
        
		if ($GLOBALS[$dev] == "A") { 
			$sql = "SELECT * from viewcrntrn where SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and STK_NO != 'SC01' ";
			//echo "15";
		}	
        if ($GLOBALS[$dev] != "A") { 
			$sql = "SELECT * from viewcrntrn where SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Dev = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
			//echo "16";
		}	
        $result2 =$db->RunQuery($sql);
		while($row2 = mysql_fetch_array($result2)){
        	$sql_tmp= "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand) values('" . trim($row2["SDATE"]) . "','" . trim($row2["REF_NO"]) . "','" . trim($row2["C_CODE"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . $row2["STK_NO"] . "','" . $row2["descript"] . "','" . $row2["Brand"] . "')";
			$result_tmp =$db->RunQuery($sql_tmp);
        
        }
        
      }
    }
} else {
    if ($_GET["cmb_t"] == "ALL") {
        if ($_GET["cmbrep"] != "All") {
         if ($_GET["Chk_cus"] == 1) {
            if ($_GET["cuscode"] == "") {
            	exit("Cusomer Not Selected");
            }
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewinv where SAL_EX='" . $_GET["cmbrep"] . "' and cus_code='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' ";
				//echo "17";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewinv where SAL_EX='" . $_GET["cmbrep"] . "' and cus_code='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
				//echo "18";
			}	
            $result =$db->RunQuery($sql);
			while($row = mysql_fetch_array($result)){
				$sql_rep="select name from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
				$result_rep =$db->RunQuery($sql_rep);
        
        		$sql_tmp=  "insert into tmpqtysale (sdate,refno,ccode,cname,INVqty,sal_ex,repname,stkno,description,brand) values('" . trim($row["SDATE"]) . "','" . trim($row["REF_NO"]) . "','" . trim($row["cus_code"]) . "','" . trim($row["CUS_NAME"]) . "'," . trim($row["QTY"]) . ",'" . $row["SAL_EX"] . "','" . $row_rep["Name"] . "','" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["s_brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
			}	
		            
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewcrntrn where SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01'  ";
				//echo "19";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewcrntrn where SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and brand = '" . trim($_GET["cmbbrand"]) . "' and dev = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01'  ";
				//echo "20";
			}	
            $result2 =$db->RunQuery($sql);
			while($row2 = mysql_fetch_array($result2)){
        		$sql_tmp= "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand) values('" . trim($row2["SDATE"]) . "','" . trim($row2["REF_NO"]) . "','" . trim($row2["C_CODE"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . $row2["STK_NO"] . "','" . $row2["descript"] . "','" . $row2["Brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
        
        	}
            
          } else {
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewinv where SAL_EX='" . $_GET["cmbrep"] . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' ";
				//echo "21";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewinv where SAL_EX='" . $_GET["cmbrep"] . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
				//echo "22";
			}
			$result =$db->RunQuery($sql);
			while($row = mysql_fetch_array($result)){
				$sql_rep="select name from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
				$result_rep =$db->RunQuery($sql_rep);
        
        		$sql_tmp=  "insert into tmpqtysale (sdate,refno,ccode,cname,INVqty,sal_ex,repname,stkno,description,brand) values('" . trim($row["SDATE"]) . "','" . trim($row["REF_NO"]) . "','" . trim($row["cus_code"]) . "','" . trim($row["CUS_NAME"]) . "'," . trim($row["qty"]) . ",'" . $row["SAL_EX"] . "','" . $row_rep["Name"] . "','" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["s_brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
			}		
            
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewcrntrn where SAL_EX='" . $_GET["cmbrep"] . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' ";
				//echo "23";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewcrntrn where SAL_EX='" . $_GET["cmbrep"] . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and dev = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
				//echo "24";
			}
			
			$result2 =$db->RunQuery($sql);
			while($row2 = mysql_fetch_array($result2)){
        		$sql_tmp= "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand) values('" . trim($row2["SDATE"]) . "','" . trim($row2["REF_NO"]) . "','" . trim($row2["C_CODE"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . $row2["STK_NO"] . "','" . $row2["descript"] . "','" . $row2["Brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
        
        	}	
			
            
          }
        } else {
          if ($_GET["Chk_cus"] == "on") {
            if ($_GET["cuscode"] == "") {
            	exit("Cusomer Not Selected");
            }
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewinv where cus_code='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' ";
				//echo "25";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewinv where cus_code='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
				//echo "26";
			}
			
			$result =$db->RunQuery($sql);
			while($row = mysql_fetch_array($result)){
				$sql_rep="select name from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
				$result_rep =$db->RunQuery($sql_rep);
        
        		$sql_tmp=  "insert into tmpqtysale (sdate,refno,ccode,cname,INVqty,sal_ex,repname,stkno,description,brand) values('" . trim($row["SDATE"]) . "','" . trim($row["REF_NO"]) . "','" . trim($row["cus_code"]) . "','" . trim($row["CUS_NAME"]) . "'," . trim($row["QTY"]) . ",'" . $row["SAL_EX"] . "','" . $row_rep["Name"] . "','" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["s_brand"] . "') ";
				$result_tmp =$db->RunQuery($sql_tmp);
			}		
			
            
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewcrntrn where C_CODE='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' ";
				//echo "27";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewcrntrn where C_CODE='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and dev = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
				//echo "28";
			}	
			
			$result2 =$db->RunQuery($sql);
			while($row2 = mysql_fetch_array($result2)){
        		$sql_tmp= "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand) values('" . trim($row2["SDATE"]) . "','" . trim($row2["REF_NO"]) . "','" . trim($row2["C_CODE"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . $row2["STK_NO"] . "','" . $row2["descript"] . "','" . $row2["Brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
        
        	}	
			
            
          } else {
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewinv where SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' ";
				//echo "29";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewinv where SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
				//echo "30";
			}
			
			$result =$db->RunQuery($sql);
			while($row = mysql_fetch_array($result)){
				$sql_rep="select name from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
				$result_rep =$db->RunQuery($sql_rep);
        
        		$sql_tmp=  "insert into tmpqtysale (sdate,refno,ccode,cname,INVqty,sal_ex,repname,stkno,description,brand) values('" . trim($row["SDATE"]) . "','" . trim($row["REF_NO"]) . "','" . trim($row["cus_code"]) . "','" . trim($row["CUS_NAME"]) . "'," . trim($row["QTY"]) . ",'" . $row["SAL_EX"] . "','" . $row_rep["Name"] . "','" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["s_brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
			}		
            
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewcrntrn where SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' ";
				//echo "31";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewcrntrn where SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and dev = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' ";
				//echo "32";
			}
			
			$result2 =$db->RunQuery($sql);
			while($row2 = mysql_fetch_array($result2)){
        		$sql_tmp= "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand) values('" . trim($row2["SDATE"]) . "','" . trim($row2["REF_NO"]) . "','" . trim($row2["C_CODE"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . $row2["STK_NO"] . "','" . $row2["descript"] . "','" . $row2["Brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
        
        	}		
            
          }
        }
    } else {
        if ($_GET["cmbrep"] != "All") {
         if ($_GET["Chk_cus"] == "on") {
            if ($_GET["cuscode"] == "") {
            	exit("Cusomer Not Selected");
            }
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewinv where SAL_EX='" . $_GET["cmbrep"] . "' and cus_code='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' and type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "33";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewinv where SAL_EX='" . $_GET["cmbrep"] . "' and cus_code='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' and type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "34";
			}
				
			while($row = mysql_fetch_array($result)){
				$sql_rep="select name from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
				$result_rep =$db->RunQuery($sql_rep);
        
        		$sql_tmp=  "insert into tmpqtysale (sdate,refno,ccode,cname,INVqty,sal_ex,repname,stkno,description,brand) values('" . trim($row["SDATE"]) . "', '" . trim($row["REF_NO"]) . "','" . trim($row["cus_code"]) . "','" . trim($row["CUS_NAME"]) . "'," . trim($row["QTY"]) . ",'" . $row["SAL_EX"] . "','" . $row_rep["Name"] . "','" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["s_brand"] . "') ";
				$result_tmp =$db->RunQuery($sql_tmp);
			}
            
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewcrntrn where SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' and s_type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "35";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewcrntrn where SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and dev = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' and s_type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "36";
			}	
			
			$result2 =$db->RunQuery($sql);
			while($row2 = mysql_fetch_array($result2)){
        		$sql_tmp= "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand) values('" . trim($row2["SDATE"]) . "', '" . trim($row2["REF_NO"]) . "','" . trim($row2["C_CODE"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . $row2["STK_NO"] . "','" . $row2["descript"] . "','" . $row2["Brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
        
        	}
			
            
          } else {
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewinv where SAL_EX='" . $_GET["cmbrep"] . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' and type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "37";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewinv where SAL_EX='" . $_GET["cmbrep"] . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' and type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "38";
			}
			
			while($row = mysql_fetch_array($result)){
				$sql_rep="select name from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
				$result_rep =$db->RunQuery($sql_rep);
        
        		$sql_tmp=  "insert into tmpqtysale (sdate,refno,ccode,cname,INVqty,sal_ex,repname,stkno,description,brand) values('" . trim($row["SDATE"]) . "', '" . trim($row["REF_NO"]) . "','" . trim($row["cus_code"]) . "','" . trim($row["CUS_NAME"]) . "'," . trim($row["QTY"]) . ",'" . $row["SAL_EX"] . "','" . $row_rep["Name"] . "','" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["s_brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
			}	
            
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewcrntrn where SAL_EX='" . $_GET["cmbrep"] . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' and s_type = '" . trim($_GET["cmb_t"]) . "' ";
				echo "39";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewcrntrn where SAL_EX='" . $_GET["cmbrep"] . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and dev = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' and s_type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "40";
			}
			
			$result2 =$db->RunQuery($sql);
			while($row2 = mysql_fetch_array($result2)){
        		$sql_tmp= "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand) values('" . trim($row2["SDATE"]) . "','" . trim($row2["REF_NO"]) . "','" . trim($row2["C_CODE"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . $row2["STK_NO"] . "','" . $row2["descript"] . "','" . $row2["Brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
        
        	}	
            
          }
        } else {
          if ($_GET["Chk_cus"] == "on") {
            if ($_GET["cuscode"] == "") {
            	exit("Cusomer Not Selected");
            }
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewinv where cus_code='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' and type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "41";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewinv where cus_code='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' and type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "42";
			}
			
			while($row = mysql_fetch_array($result)){
				$sql_rep="select name from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
				$result_rep =$db->RunQuery($sql_rep);
        
        		$sql_tmp=  "insert into tmpqtysale (sdate,refno,ccode,cname,INVqty,sal_ex,repname,stkno,description,brand) values('" . trim($row["SDATE"]) . "','" . trim($row["REF_NO"]) . "','" . trim($row["cus_code"]) . "','" . trim($row["CUS_NAME"]) . "'," . trim($row["QTY"]) . ",'" . $row["SAL_EX"] . "','" . $row_rep["Name"] . "','" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["s_brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
			}	
				
            
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewcrntrn where C_CODE='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' and s_type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "43";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewcrntrn where C_CODE='" . trim($_GET["cuscode"]) . "' and  SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and dev = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' and s_type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "44";
			}	
			
			$result2 =$db->RunQuery($sql);
			while($row2 = mysql_fetch_array($result2)){
        		$sql_tmp= "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand) values('" . trim($row2["SDATE"]) . "', '" . trim($row2["REF_NO"]) . "','" . trim($row2["C_CODE"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . $row2["STK_NO"] . "','" . $row2["descript"] . "','" . $row2["Brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
        
        	}	
            
          } else {
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewinv where SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' and type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "45";
			}
			
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewinv where SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0' and s_brand = '" . trim($_GET["cmbbrand"]) . "' and DEV = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' and type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "46";
			}
			while($row = mysql_fetch_array($result)){
				$sql_rep="select name from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
				$result_rep =$db->RunQuery($sql_rep);
        
        		$sql_tmp=  "insert into tmpqtysale (sdate,refno,ccode,cname,INVqty,sal_ex,repname,stkno,description,brand) values('" . trim($row["SDATE"]) . "','" . trim($row["REF_NO"]) . "','" . trim($row["cus_code"]) . "','" . trim($row["CUS_NAME"]) . "'," . trim($row["QTY"]) . ",'" . $row["SAL_EX"] . "','" . $row_rep["Name"] . "','" . $row["STK_NO"] . "','" . $row["DESCRIPT"] . "','" . $row["s_brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
			}		
            
            if ($GLOBALS[$dev] == "A") { 
				$sql = "SELECT * from viewcrntrn where SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and STK_NO != 'SC01' and s_type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "47";
			}	
            if ($GLOBALS[$dev] != "A") { 
				$sql = "SELECT * from viewcrntrn where SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and CANCELL='0' and Brand = '" . trim($_GET["cmbbrand"]) . "' and dev = '" . $GLOBALS[$dev] . "' and STK_NO != 'SC01' and s_type = '" . trim($_GET["cmb_t"]) . "' ";
				//echo "48";
			}
			
			$result2 =$db->RunQuery($sql);
			while($row2 = mysql_fetch_array($result2)){
        		$sql_tmp= "insert into tmpqtysale (sdate,refno,ccode,cname,RETqty,stkno,description,brand) values('" . trim($row2["SDATE"]) . "','" . trim($row2["REF_NO"]) . "','" . trim($row2["C_CODE"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . $row2["STK_NO"] . "','" . $row2["descript"] . "','" . $row2["Brand"] . "')";
				$result_tmp =$db->RunQuery($sql_tmp);
        
        	}	
				
            
          }
        }
    }
}

		$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		$heading ="Qty Sales For " . $_GET["cusname"]."</br>";
		$heading .="Sales Rep :" . $_GET["cmbrep"] . " Date Range From : " . $_GET["DTfrom"] . "   To : " . $_GET["DTTO"];
		
		echo "<center>".$heading."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>Stk No</th>
		<th>Description</th>";
		if ($_GET["cmbbrand"]=="All"){
			echo "<th>Brand</th>";
		} 
		echo "<th>Invoice Qty</th>
		<th>Return Qty</th>
		<th>Effective Qty</th>
	
		</tr>";
		//echo $sql;
		$brand="";
		$i=0;
		$sql="Select * from tmpqtysale order by brand";
		$result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result)){	
		  
			echo "<tr>
			<td>".$row["stkno"]."</td>
			<td>".$row["description"]."</td>";
			if ($_GET["cmbbrand"]=="All"){
				echo "<td>".$row["brand"]."</td>";
			} 
			
			if (is_null($row["INVqty"])==false){
				$INVqty=$row["INVqty"];
			} else {
				$INVqty=0;
			}	
			echo "<td align=right>".number_format($INVqty, 0, ",", ".")."</td>";
			
			if (is_null($row["RETqty"])==false){
				$RETqty=$row["RETqty"];
			} else {
				$RETqty=0;
			}	
			echo "<td align=right>".number_format($RETqty, 0, ",", ".")."</td>
			<td>".number_format($INVqty-$RETqty, 0, ",", ".")."</td>
			
			</tr>";
		}
		
		echo "<table>";

}








?>



</body>
</html>
