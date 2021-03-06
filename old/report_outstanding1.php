<?php date_default_timezone_set('Asia/Colombo'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Outstanding Report</title>
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
font-size:14px;

}
td
{
font-size:14px;

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
	require_once("connectioni.php");
	
	



if ($_GET["radio2"]=="optcur") { 
	if ($_GET["radio"]=="optinv") { currentrepinv(); }
	if ($_GET["radio"]=="optcus") { currentrepcus(); }
	if ($_GET["radio"]=="optscrap") { currentrepscrap(); }
}


if ($_GET["radio2"]=="optdate") { 
	       
		//  $inv= "Select C_CODE, NAME, REF_NO, SDATE, GRAND_TOT, sum(ST_PAID) as paid from  view_sttr_salma1 where SDATE <= '" & $_GET["dtdate"] & "' and ST_DATE <= '" & $_GET["dtdate"] & "' AND S_DEV = '0' group by C_CODE, NAME, REF_NO, SDATE, GRAND_TOT order by C_CODE  ";
		
		$sql= "delete from tmpoutinv ";
        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
		$sql_inv= "Select C_CODE, NAME, REF_NO, SDATE, GRAND_TOT, SAL_EX, sum(ST_PAID) as paid from  view_sttr_salma1 where SDATE <= '" . $_GET["dtdate"] . "' and ST_DATE <= '" . $_GET["dtdate"] . "' and DEV='0' group by C_CODE, NAME, REF_NO, SDATE, GRAND_TOT order by C_CODE  ";
        $result_inv =mysqli_query($GLOBALS['dbinv'],$sql_inv);
		//echo $sql_inv;
		while ($row_inv = mysqli_fetch_array($result_inv)){
			$sql_tmpinv="insert into tmpoutinv(REF_NO, Customer, Cus_Code, AMOUNT, paid, SDATE, sal_ex) values ('".$row_inv["REF_NO"]."', '".$row_inv["NAME"]."', '".$row_inv["C_CODE"]."', ".$row_inv["GRAND_TOT"].", ".$row_inv["paid"].", '".$row_inv["SDATE"]."', '".$row_inv["SAL_EX"]."')";
			
			$result_tmpinv =mysqli_query($GLOBALS['dbinv'],$sql_tmpinv);
			
		}
		
		$sql_inv= "Select C_CODE, NAME, REF_NO, SDATE, GRAND_TOT, SAL_EX, sum(ST_PAID) as paid from  view_sttr_salma1 where SDATE <= '" . $_GET["dtdate"] . "' and ST_DATE > '" . $_GET["dtdate"] . "'   and DEV='0' group by C_CODE, NAME, REF_NO, SDATE, GRAND_TOT order by C_CODE ";
        $result_inv =mysqli_query($GLOBALS['dbinv'],$sql_inv);
		//echo $sql_inv;
		while ($row_inv = mysqli_fetch_array($result_inv)){
			$sql_tmpinv="insert into tmpoutinv(REF_NO, Customer, Cus_Code, AMOUNT, paid, SDATE, sal_ex) values ('".$row_inv["REF_NO"]."', '".$row_inv["NAME"]."', '".$row_inv["C_CODE"]."', ".$row_inv["GRAND_TOT"].", 0, '".$row_inv["SDATE"]."', '".$row_inv["SAL_EX"]."')";
			$result_tmpinv =mysqli_query($GLOBALS['dbinv'],$sql_tmpinv);
			
		}
		
		
		$sql_inv= "Select C_CODE, CUS_NAME, REF_NO, SDATE, SAL_EX, GRAND_TOT from s_salma where SDATE <= '" . $_GET["dtdate"] . "' and CANCELL = '0' and TOTPAY = '0' and GRAND_TOT > '1' AND DEV = '0' ";
		//echo $sql_inv;
        $result_inv =mysqli_query($GLOBALS['dbinv'],$sql_inv);
		
		while ($row_inv = mysqli_fetch_array($result_inv)){
			
			$rst_cus="select * from vendor where CODE='".$row_inv["C_CODE"]."'";
			$result_cus =mysqli_query($GLOBALS['dbinv'],$rst_cus);
			$row_cus = mysqli_fetch_array($result_cus);
			
			$sql_tmpinv="insert into tmpoutinv(REF_NO, Customer, Cus_Code, AMOUNT, paid, SDATE, sal_ex) values ('".$row_inv["REF_NO"]."', '".$row_cus["NAME"]."', '".$row_inv["C_CODE"]."', ".$row_inv["GRAND_TOT"].", 0, '".$row_inv["SDATE"]."', '".$row_inv["SAL_EX"]."')";
			$result_tmpinv =mysqli_query($GLOBALS['dbinv'],$sql_tmpinv);
			
		}
		 
       
             

        $sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		
		echo "<center>".$heading."</center><br>";
		
	
	if ($_GET["radio"]=="optinv"){	
	
		$heading = "<center>OutStanding Report On  " . $_GET["dtdate"] . "  Invoice Wise ";
         $heading .= "Brand   :  " . $_GET["cmbbrand"]."</center>";
			
		echo $heading;
		
		echo "<center><table border=1><tr>
		<th>Customer</th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		</tr>";
		//echo $sql;
		
		if ($_GET["cmbrep"] == "All"){
		 	$sql = "SELECT * from tmpoutinv where (AMOUNT-paid)> 0 order by Cus_Code"; 
		} else {
			$sql = "SELECT * from tmpoutinv where (AMOUNT-paid)> 0 and sal_ex='" . $_GET["cmbrep"] . "' order by Cus_Code"; 
		}	
		

       	 $baltot=0;   
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		while($row = mysqli_fetch_array($result)){	
			echo "<tr>
			<td>".$row["Cus_Code"]." ".$row["Customer"]."</td>
			<td>".$row["SDATE"]."</td>
			<td></td>
			<td>".number_format($row["AMOUNT"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["AMOUNT"]-$row["paid"], 2, ".", ",")."</td>";
			$baltot=$baltot+($row["AMOUNT"]-$row["paid"]);
			
			
			echo "</tr>";
			
		}
		
		echo "<tr>
			<td colspan=4>".$row["SDATE"]."</td>
			
			<td align=\"right\"><b>".number_format($baltot, 2, ".", ",")."</b></td>
			
			</tr>";
			
		echo "<table>";
		
	} 
	
		
	
   
  if ($_GET["radio"]=="optcus"){
  	
		$heading = "Outstanding Report on  " . $_GET["dtdate"] . "     Customer Wise Over  " . $_GET["txtdays"] . "  Days";
        $heading .= "Brand   :  " . $_GET["cmbbrand"];
		
		
		
		
		echo "<center><table border=1><tr>
		<th>Customer Code</th>
		<th>Customer Name</th>
		<th>Amount</th>
		<th>Balance</th>
		</tr>";
		//echo $sql;
		
		
		if ($_GET["cmbrep"] == "All"){
		 	$sql = "SELECT * from tmpoutinv where (AMOUNT-paid)> 0 order by Cus_Code"; 
		} else {
			$sql = "SELECT * from tmpoutinv where (AMOUNT-paid)> 0 and sal_ex='" . $_GET["cmbrep"] . "' order by Cus_Code"; 
		}	
		

       	 $baltot=0;   
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		while($row = mysqli_fetch_array($result)){	
			echo "<tr>
			<td>".$row["Cus_Code"]."</td>
			<td>".$row["Customer"]."</td>
			<td align=\"right\">".number_format($row["AMOUNT"], 2, ".", ",")."</td>
			
			<td align=\"right\">".number_format($row["AMOUNT"]-$row["paid"], 2, ".", ",")."</td>";
			$baltot=$baltot+($row["AMOUNT"]-$row["paid"]);
			
			
			echo "</tr>";
			
		}
		
		echo "<tr>
			<td colspan=3>".$row["SDATE"]."</td>
			
			<td align=\"right\"><b>".number_format($baltot, 2, ".", ",")."</b></td>
			
			</tr>";
			
		echo "<table>";
	
		
  }     
       
    
       
}


/////////// Sales Summery////////////////////////////////////////
function currentrepinv()
{
	require_once("connectioni.php");
	
	
	
	$txtrepono= date("Y-m-d")."  ".date("H-m-s");
	
	$date=date("Y-m-d");
	$caldays=" - ".$_GET["txtdays"]." days";
	$tmpdate=date('Y-m-d', strtotime($caldays));
	
	$date=date("Y-m-d");
	$caldays=" - ".$_GET["txtover"]." days";
	$tmpover=date('Y-m-d', strtotime($caldays));
	
	$date=date("Y-m-d");
	$caldays=" - ".$_GET["txtdb"]." days";
	$tmpbellow=date('Y-m-d', strtotime($caldays));
	
	

	$rep = $_GET["cmbrep"];
	
	
	if ($_GET["cmbbrand"] == "All") {
            if ($_GET["chkpe"] != "on") {
                if ($_GET["cmbdev"] == "All"){
                   if ($_GET["cmbrep"] == "All") { 
				  
				   		$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'".$tmpdate."'or SDATE='".$tmpdate."') and CANCELL='0' order by C_CODE, SDATE";
						
					}	
                    
					if ($_GET["cmbrep"] != "All") { 
					
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='".$rep."'and (SDATE<'".$tmpdate."'or SDATE='".$tmpdate."')and CANCELL='0' order by C_CODE, SDATE";
						
                	}
               
                }
				if ($_GET["cmbdev"] == "Computer") {
                   	if ($_GET["cmbrep"] == "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'".$tmpdate."'or SDATE='".$tmpdate."')and CANCELL='0' and DEV='0' order by C_CODE, SDATE";
                   	}
				   	if ($_GET["cmbrep"] != "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='".$rep."'and (SDATE<'".$tmpdate."'or SDATE='".$tmpdate."')and CANCELL='0' and DEV='0' order by C_CODE, SDATE";
                	}
                }
				
                if ($_GET["cmbdev"] == "Manual") {
                   	if ($_GET["cmbrep"] == "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" .$tmpdate. "'or SDATE='".$tmpdate."')and CANCELL='0' and DEV='1' order by C_CODE, SDATE";
					}	
                   	if ($_GET["cmbrep"] != "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='".$rep. "'and (SDATE<'".$tmpdate."'or SDATE='".$tmpdate."')and CANCELL='0' and DEV='1'order by C_CODE, SDATE";
                	}
            	}
            }
            
			if ($_GET["chkpe"] == "on") {
                if ($_GET["cmbdev"] == "All") {
                   	if ($_GET["cmbrep"] == "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'".$tmpover."'or SDATE='".$tmpover."')and (SDATE>'".$tmpbellow."'or SDATE='".$tmpbellow."')  and CANCELL='0' order by C_CODE, SDATE";
					}	
                    
					if ($_GET["cmbrep"] != "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='".$rep. "'and (SDATE<'".$tmpover."'or SDATE='".$tmpover."')and (SDATE>'".$tmpbellow."' or SDATE='".$tmpbellow."') and CANCELL='0' order by C_CODE, SDATE";
					}	
               }
               
               if ($_GET["cmbdev"] == "Computer") {
                   if ($_GET["cmbrep"] == "All") { 
				   		
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'".$tmpover ."' or SDATE='".$tmpover."') and (SDATE>'".$tmpbellow."' or SDATE='".$tmpbellow."') and CANCELL='0' and DEV='0' order by C_CODE, SDATE";
					}	
                   	
					if ($_GET["cmbrep"] != "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='".$rep."' and (SDATE<'".$tmpover."'or SDATE='".$tmpover."')and (SDATE>'".$tmpbellow."' or SDATE='".$tmpbellow."') and CANCELL='0' and DEV='0' order by C_CODE, SDATE";
               		}
				}
				
				if ($_GET["cmbdev"] == "Manual") {
                   	if ($_GET["cmbrep"] == "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'".$tmpover."' or SDATE='".$tmpover."') and (SDATE>'".$tmpbellow."' or SDATE='".$tmpbellow."') and CANCELL='0' and DEV='1' order by C_CODE, SDATE";
					}	
                    
					if ($_GET["cmbrep"] != "All") { 
						//echo "12";
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='".$rep."' and (SDATE<'".$tmpover."'or SDATE='".$tmpover."')and (SDATE>'".$tmpbellow."' or SDATE='".$tmpbellow."') and CANCELL='0' and DEV='1' order by C_CODE, SDATE";
                	}
            	}	
			}
    }    
   
   
   
   if ($_GET["cmbbrand"] != "All") {
            if ($_GET["chkpe"] != "on") {
                if ($_GET["cmbdev"] == "All") {
                   	if ($_GET["cmbrep"] == "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'".$tmpdate ."' or SDATE='".$tmpdate."') and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by C_CODE, SDATE";
                   	}
					if ($_GET["cmbrep"] != "All") { 
				   		
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by C_CODE, SDATE";
                	}
               }
               
			   if ($_GET["cmbdev"] == "Computer") {
                    if ($_GET["cmbrep"] == "All") { 
				   		
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' order by C_CODE, SDATE";
					}	
                    if ($_GET["cmbrep"] != "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' order by C_CODE, SDATE";
                	}
				}
                
                if ($_GET["cmbdev"] == "Manual") {
                   
				   if ($_GET["cmbrep"] == "All") { 
				   		
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "') and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by C_CODE, SDATE";
				   }	
                   if ($_GET["cmbrep"] != "All") { 
				   		
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by C_CODE, SDATE";
                   }
            	}
            }
            
			if ($_GET["chkpe"] == "on") {
                if ($_GET["cmbdev"] == "All") {
                   if ($_GET["cmbrep"] == "All") { 
				   		
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "')  and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by C_CODE, SDATE";
					}	
                    
					if ($_GET["cmbrep"] != "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE<'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by C_CODE, SDATE";
					}	
                }
               
                if ($_GET["cmbdev"] == "Computer") {
                   	if ($_GET["cmbrep"] == "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0'and Brand='" . $_GET["cmbbrand"] . "' order by C_CODE, SDATE";
					}	
                    
					if ($_GET["cmbrep"] != "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE<'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' order by C_CODE, SDATE";
					}	
                }
                
                if ($_GET["cmbdev"] == "Manual") {
                   if ($_GET["cmbrep"] == "All") { 
				   		
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by C_CODE, SDATE";
					}	
                    if ($_GET["cmbrep"] != "All") { 
						
						$sql = "SELECT * from view_salma_vendor where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE<'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1'  and Brand='" . $_GET["cmbbrand"] . "' order by C_CODE, SDATE";
					}	
                }
            }
 	}
   
  //echo $sql;
   $sql_head="select * from invpara";
   $result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
   $row_head = mysqli_fetch_array($result_head);
		
	echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
	if ($_GET["chkpe"] != "on") { 
		$heading = "OutStanding Report On  " .date("Y-m-d"). "  Invoice Wise     Over  " .$_GET["txtdays"]. "  Days";
	}	
	if ($_GET["chkpe"] == "on") {  
		$heading = "OutStanding Report On  " .date("Y-m-d"). "  Invoice Wise     Over  " . $_GET["txtover"] . " and bellow " . $_GET["txtdb"] . "  Days";
	}	
		
		//echo "<center>".$heading."</center><br>";
		
	

	echo "<center>Rep :" . $_GET["cmbrep"]."</center>";
	
	$rep=$_GET["cmbrep"];
	
	$date=date("Y-m-d");
	$caldays=" - 119 days";
	$tmpdate=date('Y-m-d', strtotime($date.$caldays));
	
	if ($_GET["cmbbrand"] == "All") {
    	if ($_GET["cmbdev"] == "All") {
        	if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and CANCELL='0'";
			}	
        	
			if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and SAL_EX='" . $rep . "'  and CANCELL='0'";
			}	
    	}
    
    	if ($_GET["cmbdev"] == "Manual") {
        	if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and DEV='1'  and CANCELL='0' ";
			}	
        	
			if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and SAL_EX='" . $rep . "' and DEV='1'  and CANCELL='0' ";
			}
		}		
        
    	if ($_GET["cmbdev"] == "Computer") {
        	if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and DEV='0'  and CANCELL='0' ";
			}	
        	
			if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and SAL_EX='" . $rep . "' and DEV='0'  and CANCELL='0'";
			}	
    	}
	}
   
   
   $date=date("Y-m-d");
	$caldays=" - 119 days";
	$tmpdate=date('Y-m-d', strtotime($date.$caldays));
	
   	if ($_GET["cmbbrand"] != "All"){
    	if ($_GET["cmbdev"] == "All") {
        	if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        	
			if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and SAL_EX='" . $rep . "'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
    	}
    
    	if ($_GET["cmbdev"] == "Manual") {
        	if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and DEV='1'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
        	if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and SAL_EX='" . $rep . "' and DEV='1'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
    	}
    
    	if ($_GET["cmbdev"] == "Computer") {
        	if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
        	if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and SAL_EX='" . $rep . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
    	}
	}
	
   
    $result1 =mysqli_query($GLOBALS['dbinv'],$rst1);
	$row1 = mysqli_fetch_array($result1);
   	$txtover120=$row1["over120"];
   
   $date=date("Y-m-d");
	$caldays=" - 120 days";
	$tmpdate=date('Y-m-d', strtotime($date.$caldays));
	
	$date=date("Y-m-d");
	$caldays=" - 89 days";
	$tmpdate2=date('Y-m-d', strtotime($date.$caldays));
   
   if ($_GET["cmbbrand"] == "All") {
   		if ($_GET["cmbdev"] == "All") {
        	if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "'  and CANCELL='0' ";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "'  and CANCELL='0'";
			}
        }
        
        if ($_GET["cmbdev"] == "Computer") {
            if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='0'  and CANCELL='0' ";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "' and DEV='0'  and CANCELL='0' ";
			}	
        }
        
        if ($_GET["cmbdev"] == "Manual") {
            if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='1' and CANCELL='0' ";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "'and DEV='1'  and CANCELL='0'";
			}	
        }
	}

	$date=date("Y-m-d");
	$caldays=" - 120 days";
	$tmpdate=date('Y-m-d', strtotime($date.$caldays));
	
   
   $date=date("Y-m-d");
	$caldays=" - 89 days";
	$tmpdate2=date('Y-m-d', strtotime($date.$caldays));
	
   if ($_GET["cmbbrand"] != "All") {
        if ($_GET["cmbdev"] == "All") {
            if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "'  and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        }
        
        if ($_GET["cmbdev"] == "Computer") {
            if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        }
        
        if ($_GET["cmbdev"] == "Manual") {
            if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='1' and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "'and DEV='1'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        }
	}	
	
	 $result1 =mysqli_query($GLOBALS['dbinv'],$rst1);
	$row1 = mysqli_fetch_array($result1);
   	$txt90to120=$row1["t90to120"];
	
	$date=date("Y-m-d");
	$caldays=" - 90 days";
	$tmpdate=date('Y-m-d', strtotime($date.$caldays));
	
	$date=date("Y-m-d");
	$caldays=" - 59 days";
	$tmpdate2=date('Y-m-d', strtotime($date.$caldays));
	
	if ($_GET["cmbbrand"] == "All") {
        if ($_GET["cmbdev"] == "All") {
            if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "'  and CANCELL='0' ";
			}	
            if ($_GET["cmbrep"] != "All") {
			 	$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "'  and CANCELL='0'";
			}
        }
        
        if ($_GET["cmbdev"] == "Computer") {
            if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='0'  and CANCELL='0'";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . rep . "' and DEV='0'  and CANCELL='0' ";
			}	
        }
        
        if ($_GET["cmbdev"] == "Manual") {
            if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='1'  and CANCELL='0' ";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . rep . "' and DEV='1'   and CANCELL='0'";
			}	
        }
	}

	if ($_GET["cmbbrand"] != "All") {
        if ($_GET["cmbdev"] == "All") {
            if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . rep . "'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        }
        
        if ($_GET["cmbdev"] == "Computer") {
            if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . rep . "' and DEV='0'  and CANCELL='0'   and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        }
        
        if ($_GET["cmbdev"] == "Manual") {
            if ($_GET["cmbrep"] == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='1'  and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname != 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . rep . "' and DEV='1'   and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
        	}
		}
	}	
	
	
	$result1 =mysqli_query($GLOBALS['dbinv'],$rst1);
	$row1 = mysqli_fetch_array($result1);
   	$txt60to90=$row1["t60to90"];
	
	//echo $rst1;
	$txtbrand= "<center>Brand   :  " . $_GET["cmbbrand"]."</center><br>";
	
	echo "<center>".$heading."</center><br>";
		
		
		
		echo "<center><table border=1><tr>
		<th>Rep No</th>
		<th>Invoice Date</th>
		<th>Delivery date</th>
		<th>Invoice No</th>
		<th></th>
		<th></th>
		<th>Grand Tot</th>
		<th>Balance</th>
		</tr>";
	

		
		$ccode="";
		//$sql="select * from s_salrep order by REPCODE";
		//echo $sql;
		$totbal=0;
		$balance=0;
		$i=0;
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		while($row = mysqli_fetch_array($result)){
			
			if (strtoupper($row["C_CODE"])!=strtoupper($ccode)){
				if ($i!=0){
					echo "<tr>
					<td colspan=9 align=right><b>".number_format($balance, 2, ".", ",")."</b></td>
					</tr>";
				} 
				$i=1;	
				
				$rst_cus="select * from vendor where CODE='".$row["C_CODE"]."'";
				$result_cus =mysqli_query($GLOBALS['dbinv'],$rst_cus);
				$row_cus = mysqli_fetch_array($result_cus);
	
				echo "<tr>
					<td colspan=9 align=left><b>".$row["C_CODE"]." ".$row_cus["NAME"]."</b></td>
					</tr>";
					$balance=$row["GRAND_TOT"]-$row["TOTPAY"];
			} else {
				$balance=$balance+$row["GRAND_TOT"]-$row["TOTPAY"];
			}
			
			$ccode=$row["C_CODE"];
			
			

			echo "<tr>
			<td>".$row["SAL_EX"]."</td>
			<td>".$row["SDATE"]."</td>";
			
			if (($row["deli_date"]=="0000-00-00") or (is_null($row["deli_date"])==true) or ($row["deli_date"]=="")){
				echo "<td><font color=\"#FF0000\"></font></td>";
			} else {
				echo "<td><font color=\"#FF0000\">".$row["deli_date"]."</font></td>";
			}	
			echo "<td>".$row["REF_NO"]."</td>";
			
			$date1 = date("Y-m-d");
			$date2 = $row["SDATE"];
			
			$diff = abs(strtotime($date2) - strtotime($date1));
			$days = floor($diff / (60*60*24));
						
			
			echo "<td align=\"right\">".$days."</td>";
			
			$date1 = date("Y-m-d");
			$date2 = $row["deli_date"];

			$diff = abs(strtotime($date2) - strtotime($date1));
			$days = floor($diff / (60*60*24));
			
			if (($row["deli_date"]=="0000-00-00") or (is_null($row["deli_date"])==true) or ($row["deli_date"]=="")){
				$days="";
			}
			echo "<td align=\"right\"><font color=\"#FF0000\">".$days."</font></td>";
			
			echo "<td align=\"right\">".number_format($row["GRAND_TOT"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format(($row["GRAND_TOT"]-$row["TOTPAY"]), 2, ".", ",")."</td>
			</tr>";
			$totbal=$totbal+$row["GRAND_TOT"]-$row["TOTPAY"];
		}
		
		echo "<tr>
					<td colspan=9 align=right><b>".number_format($balance, 2, ".", ",")."</b></td>
					</tr>";
		echo "<tr>
			<td colspan=7></td><td><b>".number_format($totbal, 2, ".", ",")."</b></td></tr>";
		echo "<table>";
	

	
}

function currentrepcus()
{

	require_once("connectioni.php");
	
	
	
	$txtrepono= date("Y-m-d") . "  " . date("H:m:s");
	
	$rep = $_GET["cmbrep"];
	
	if ($_GET["cmbbrand"] == "All") {
        if ($_GET["cmbdev"] == "All") {
            if ($_GET["cmbrep"] == "All") { 
				$sql = "SELECT sum(grand_tot) as GRAND_TOT, sum(totpay) as TOTPAY, C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and CANCELL='0' group by C_CODE ";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$sql = "SELECT sum(grand_tot) as GRAND_TOT, sum(totpay) as TOTPAY, C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and CANCELL='0' group by C_CODE";
			}
        }
         
        if ($_GET["cmbdev"] == "Manual") {
            if ($_GET["cmbrep"] == "All") { 
				$sql = "SELECT sum(grand_tot) as GRAND_TOT, sum(totpay) as TOTPAY, C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and CANCELL='0' and DEV='1'  group by  C_CODE ";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$sql = "SELECT sum(grand_tot) as GRAND_TOT, sum(totpay) as TOTPAY, C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and CANCELL='0' and DEV='1' group by C_CODE";
			}	
        }
         
        if ($_GET["cmbdev"] == "Computer") {
            if ($_GET["cmbrep"] == "All") { 
				$sql = "SELECT sum(grand_tot) as GRAND_TOT, sum(totpay) as TOTPAY, C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and CANCELL='0' and DEV='0'  group by C_CODE";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$sql = "SELECT sum(grand_tot) as GRAND_TOT, sum(totpay) as TOTPAY, C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and CANCELL='0' and DEV='0'  group by C_CODE";
			}	
        }
	}

	if ($_GET["cmbbrand"] != "All") {
        if ($_GET["cmbdev"] == "All") {
            if ($_GET["cmbrep"] == "All") { 
				$sql = "SELECT sum(grand_tot) as GRAND_TOT, sum(totpay) as TOTPAY, C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "'   group by C_CODE" ;
			}	
            if ($_GET["cmbrep"] != "All") { 
				$sql = "SELECT sum(grand_tot) as GRAND_TOT, sum(totpay) as TOTPAY, C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "'  group by C_CODE ";
        	}
		}
         
        if ($_GET["cmbdev"] == "Manual") {
            if ($_GET["cmbrep"] == "All") { 
				$sql = "SELECT sum(grand_tot) as GRAND_TOT, sum(totpay) as TOTPAY, C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "'   group by C_CODE";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$sql = "SELECT sum(grand_tot) as GRAND_TOT, sum(totpay) as TOTPAY, C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "'  group by C_CODE";
			}	
        }
         
        if ($_GET["cmbdev"] == "Computer") {
            if ($_GET["cmbrep"] == "All") { 
				$sql = "SELECT sum(grand_tot) as GRAND_TOT, sum(totpay) as TOTPAY, C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' group by C_CODE";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$sql = "SELECT sum(grand_tot) as GRAND_TOT, sum(totpay) as TOTPAY, C_CODE from s_salma where Accname != 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and CANCELL='0' and DEV='0'  and Brand='" . $_GET["cmbbrand"] . "'   group by C_CODE";
			}	
        }
	}


	$rtxtdate= "OutStanding Report On  " . $_GET["dtdate"]."  Invoice Wise";
 
	$txtbrand= "Brand   :  " . $_GET["cmbbrand"];
	
	$sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		echo "<center>".$rtxtdate."</center><br>";
		echo "<center>".$txtbrand."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>Customer Code</th>
		<th>Customer Name</th>
		<th>Amount</th>
		<th>Balance</th>
		</tr>";
		//echo $sql;
		$C_CODE="";
		$amount=0;
		$balance=0;
		
		$sql= $sql. " order by C_CODE";
        

                $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		while($row = mysqli_fetch_array($result)){	
			
			
				echo "<tr>
					<td>".$row["C_CODE"]."</td>";
					
					$rst_cus="select * from vendor where CODE='".$row["C_CODE"]."'";
					$result_cus =mysqli_query($GLOBALS['dbinv'],$rst_cus);
					$row_cus = mysqli_fetch_array($result_cus);
					
					echo "<td>".$row_cus["NAME"]."</td>
					<td align=\"right\">".number_format($row['GRAND_TOT'], 2, ".", ",")."</td>
					<td align=\"right\">".number_format($row['GRAND_TOT']-$row['TOTPAY'], 2, ".", ",")."</td>
					</tr>";
			
					$amount=$amount+$row["GRAND_TOT"];
					$balance=$balance+$row["GRAND_TOT"]-$row["TOTPAY"];
					
		}
echo "<td></td>";
					
					
					echo "<td></td>
					<td align=\"right\"><b>".number_format($amount, 2, ".", ",")."</b></td>
					<td align=\"right\"><b>".number_format($balance, 2, ".", ",")."</b></td>
					</tr>";
		
		echo "<table>";
}	
   
   
   
function currentrepscrap()
{  
 	$date=date("Y-m-d");
	$caldays=" - ".$_GET["txtdays"]." days";
	$tmpdate=date('Y-m-d', strtotime($date.$caldays));
	
	$date=date("Y-m-d");
	$caldays=" - ".$_GET["txtover"]." days";
	$tmpover=date('Y-m-d', strtotime($date.$caldays));
	
	$date=date("Y-m-d");
	$caldays=" - ".$_GET["txtdb"]." days";
	$tmpbellow=date('Y-m-d', strtotime($date.$caldays));
	
	$rep=$_GET["cmbrep"];
	
	
	if ($_GET["cmbbrand"] == "All") {
    	if ($_GET["chkpe"] != "on") {
        	if ($_GET["cmbdev"] == "All") {
            	if ($_GET["cmbrep"] == "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' order by SDATE";
				}	
                if ($_GET["cmbrep"] != "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' order by SDATE";
                }
             } 
             if ($_GET["cmbdev"] = "Computer") {
             	if ($_GET["cmbrep"] == "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' order by SDATE";
				 }	
                 if ($_GET["cmbrep"] != "All") { 
				 	$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' order by SDATE";
                 }
			 }   
                
             if ($_GET["cmbdev"] == "Manual") {
             	if ($_GET["cmbrep"] == "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='1' order by SDATE";
				}	
                if ($_GET["cmbrep"] != "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='1'order by SDATE";
				}	
             }
        }
            
        if ($_GET["chkpe"] == "on") {
        	if ($_GET["cmbdev"] == "All") {
            	if ($_GET["cmbrep"] == "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "')  and CANCELL='0' order by SDATE";
				 }	
                 if ($_GET["cmbrep"] != "All") { 
				 	$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' order by SDATE";
				 }	
            }
               
            if ($_GET["cmbdev"] == "Computer") {
            	if ($_GET["cmbrep"] == "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0' order by SDATE";
				}	
                if ($_GET["cmbrep"] != "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0' order by SDATE";
				}	
            }
                
            if ($_GET["cmbdev"] == "Manual") {
            	if ($_GET["cmbrep"] == "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1' order by SDATE";
				}	
                if ($_GET["cmbrep"] != "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1' order by SDATE";
				}	
            }
        }
 	}
		
		
		
	if ($_GET["cmbbrand"] != "All") {
    	if ($_GET["chkpe"] != "on") {
        	if (cmbdev == "All") {
            	if ($_GET["cmbrep"] == "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by SDATE";
				}	
                if ($_GET["cmbrep"] != "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by SDATE";
				}	
            }
               
            if (cmbdev == "Computer") {
            	if ($_GET["cmbrep"] == "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' order by SDATE";
				}	
                if ($_GET["cmbrep"] != "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' order by SDATE";
				}	
            }
                
            if (cmbdev == "Manual") {
            	if ($_GET["cmbrep"] == "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by SDATE";
				}	
                if ($_GET["cmbrep"] != "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpdate . "'or SDATE='" . $tmpdate . "')and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by SDATE";
				}	
            }
        }
            
        if ($_GET["chkpe"] == "on") {
            if (cmbdev == "All") {
            	if ($_GET["cmbrep"] == "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "')  and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by SDATE";
				}	
                if ($_GET["cmbrep"] != "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE<'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' order by SDATE";
				}	
            }
               
            if (cmbdev == "Computer") {
            	if ($_GET["cmbrep"] == "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0'and Brand='" . $_GET["cmbbrand"] . "' order by SDATE";
				}	
                if ($_GET["cmbrep"] != "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE<'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='0' and Brand='" . $_GET["cmbbrand"] . "' order by SDATE";
				}	
            }
                
            if (cmbdev == "Manual") {
            	if ($_GET["cmbrep"] == "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE>'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1' and Brand='" . $_GET["cmbbrand"] . "' order by SDATE";
				}	
                if ($_GET["cmbrep"] != "All") { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and GRAND_TOT - TOTPAY >1 and SAL_EX='" . $rep . "'and (SDATE<'" . $tmpover . "'or SDATE='" . $tmpover . "')and (SDATE<'" . $tmpbellow . "'or SDATE='" . $tmpbellow . "') and CANCELL='0' and DEV='1'  and Brand='" . $_GET["cmbbrand"] . "' order by SDATE";
				}	
            }
        }
 	}
 
   
   
   
   
   
 
	If ($_GET["chkpe"] != "on") { 
		$rtxtdate = "OutStanding Report On  " . date("Y-m-d") . "  Invoice Wise    Over  " . $_GET["txtdays"] . "  Days";
	}	
	
	If ($_GET["chkpe"] == "on") { 
		$rtxtdate = "OutStanding Report On  " . date("Y-m-d") . "  Invoice Wise   Over  " . $_GET["txtover"] . " and bellow " . $_GET["txtdb"] . "  Days";
	}
	
	$txtrep= "Rep :" . $_GET["cmbrep"];
	
	$date=date("Y-m-d");
	$caldays=" - 119 days";
	$tmpdate=date('Y-m-d', strtotime($date.$caldays));
	
	
	
	if ($_GET["cmbbrand"] == "All") {
    	if ($_GET["cmbdev"] == "All") {
        	if ($cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and CANCELL='0'";
			}	
        	if ($cmbrep != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and SAL_EX='" . $rep . "'  and CANCELL='0'";
			}	
    	}
    
    	if ($_GET["cmbdev"] == "Manual") {
        	if ($cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and DEV='1'  and CANCELL='0' ";
			}	
        	if ($cmbrep != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and SAL_EX='" . $rep . "' and DEV='1'  and CANCELL='0' ";
			}	
    	}
    
    	if ($_GET["cmbdev"] == "Computer") {
        	if ($cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and DEV='0'  and CANCELL='0' ";
			}	
        	if ($cmbrep != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and SAL_EX='" . $rep . "' and DEV='0'  and CANCELL='0'";
			}	
		}
	}

	if ($_GET["cmbbrand"] != "All") {
    	if ($_GET["cmbdev"] == "All") {
        	if ($cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        	if ($cmbrep != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and SAL_EX='" . $rep . "'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
    		}
    
    	if ($_GET["cmbdev"] == "Manual") {
        	if ($cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and DEV='1'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
        	if ($cmbrep != "All") { 
				$rst1 ="SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and SAL_EX='" . $rep . "' and DEV='1'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
    	}
    
    	if ($_GET["cmbdev"] == "Computer") {
        	if ($cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
        	if ($cmbrep != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as over120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE<'" . $tmpdate . "' and SAL_EX='" . $rep . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
    	}
	}
	
	$result1 =mysqli_query($GLOBALS['dbinv'],$rst1);
	$row1 = mysqli_fetch_array($result1);
   	$txtover120=$row1["over120"];
	
	$date=date("Y-m-d");
	$caldays=" - 120 days";
	$tmpdate=date('Y-m-d', strtotime($date.$caldays));
	
	$date=date("Y-m-d");
	$caldays=" - 89 days";
	$tmpdate2=date('Y-m-d', strtotime($date.$caldays));

	if ($_GET["cmbbrand"] == "All") {
        if ($_GET["cmbdev"] == "All") {
            if (cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "'  and CANCELL='0' ";
			}	
            if (cmbrep <> "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "'  and CANCELL='0'";
			}	
        }
        
        if ($_GET["cmbdev"] == "Computer") {
            if (cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='0'  and CANCELL='0' ";
			}	
            if (cmbrep <> "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "' and DEV='0'  and CANCELL='0' ";
			}	
        }
        
        if ($_GET["cmbdev"] == "Manual") {
            if (cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='1' and CANCELL='0' ";
			}	
            if (cmbrep <> "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "'and DEV='1'  and CANCELL='0'";
			}	
        }
	}


	if ($_GET["cmbbrand"] <> "All") {
        if ($_GET["cmbdev"] == "All") {
            if (cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
            if (cmbrep <> "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "'  and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        }
        
        if ($_GET["cmbdev"] == "Computer") {
            if (cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
            if (cmbrep <> "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        }
        
        if ($_GET["cmbdev"] == "Manual") {
            if (cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='1' and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
            if (cmbrep <> "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t90to120 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "'and DEV='1'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        }
	}
	
	$result1 =mysqli_query($GLOBALS['dbinv'],$rst1);
	$row1 = mysqli_fetch_array($result1);
   	$txt90to120=$row1["t90to120"];
	
	$date=date("Y-m-d");
	$caldays=" - 90 days";
	$tmpdate=date('Y-m-d', strtotime($date.$caldays));
	
	$date=date("Y-m-d");
	$caldays=" - 59 days";
	$tmpdate2=date('Y-m-d', strtotime($date.$caldays));


	if ($_GET["cmbbrand"] == "All") {
        if ($_GET["cmbdev"] == "All") {
            if (cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "'  and CANCELL='0' ";
			}	
            if (cmbrep <> "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "'  and CANCELL='0'";
			}
        }
        
        if ($_GET["cmbdev"] == "Computer") {
            if ($cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='0'  and CANCELL='0'";
			}	
            if ($cmbrep != "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "' and DEV='0'  and CANCELL='0' ";
			}	
        }
        
        if ($_GET["cmbdev"] == "Manual") {
            if (cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='1'  and CANCELL='0' ";
			}	
            if (cmbrep <> "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "' and DEV='1'   and CANCELL='0'";
			}	
        }
	}

	if ($_GET["cmbbrand"] <> "All") {
        if ($_GET["cmbdev"] == "All") {
            if (cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "' ";
			}
            if (cmbrep <> "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        }
        
        if ($_GET["cmbdev"] == "Computer") {
            if (cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='0'  and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
            if (cmbrep <> "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "' and DEV='0'  and CANCELL='0'   and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        }
        
        if ($_GET["cmbdev"] == "Manual") {
            if (cmbrep == "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and DEV='1'  and CANCELL='0' and Brand='" . $_GET["cmbbrand"] . "' ";
			}	
            if (cmbrep <> "All") { 
				$rst1= "SELECT sum(GRAND_TOT)-sum(totpay) as t60to90 from s_salma where Accname = 'NON STOCK' and GRAND_TOT > TOTPAY and SDATE>'" . $tmpdate . "' and  SDATE<'" . $tmpdate2 . "' and SAL_EX='" . $rep . "' and DEV='1'   and CANCELL='0'  and Brand='" . $_GET["cmbbrand"] . "'";
			}	
        }
	}
	
	$result1 =mysqli_query($GLOBALS['dbinv'],$rst1);
	$row1 = mysqli_fetch_array($result1);
	$txt60to90=$row1["t60to90"];
	
	$txtbrand= "Brand   :  " . $_GET["cmbbrand"];
 
   
}
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
	if ($_GET["radio"]=="optsales") {
    	if ($_GET["chk_svat"] != "on") {
        	if ($_GET["chkcus"]=="on") {
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma SDATE='".$_GET["dtfrom"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by id";
				}	
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by id";
				}	
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."' and C_CODE='".$_GET["txt_cuscode"]."'and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by REF_NO";
				}	
            	
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
				 	$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by id";
				}	
            
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by REF_NO";
				}	
            	
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
				 	$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by id";
				}	
            
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."'and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by REF_NO";
				}	
            
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by id";
				}	
        	} else {
            	
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by id";
				}	
            	
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by id";
				}	
            
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."'and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by REF_NO";
				}	
            	
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by id";
				}	
            	
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and SAL_EX='".$_GET["cmbrep"]."'and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by REF_NO";
				}
					
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and SAL_EX='".$_GET["cmbrep"]."'and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by id";
				}	
            	
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]. "'and SAL_EX='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by REF_NO";
				}	
            
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
				 	$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."'and CANCELL='0' order by id";
				}	
        	}
    	} else {
        	if ($_GET["chkcus"]=="on") {
            	
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0' order by id";
				}	
            	
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0'  order by id";
				}	
            	
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
				 	$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."'and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0' order by REF_NO";
				}	
            	
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
				 	$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0'  order by id";
				}	
            	
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0' order by REF_NO";
				}	
            	
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0' order by id";
				}	
            
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."'and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0' order by REF_NO";
				}	
            	
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0' and SVAT > '0' order by id";
        		}
				
			} else {
            
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"] . "' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0' order by id";
				}	
            	
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0' order by id";
				}	
            	
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."'and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0' order by REF_NO";
				}	
            	
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0' order by id";
				}	
            	
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and SAL_EX='".$_GET["cmbrep"]."'and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0' order by REF_NO";
				}	
            
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and SAL_EX='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0' order by id";
				}	
            
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]. "'and SAL_EX='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and SVAT > '0' order by REF_NO";
				}	
            
				if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname != 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' and CANCELL='0' and SVAT > '0' order by id";
        		}
			}	
    	}
		
	
	
	}
	
	if ($_GET["chk_discount"]== "on") {
		dis_sales();
	} else {
		if ($_GET["chk_svat"] != "on") {
    		if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optdaily")) { 
				$heading ="Sales Summery Report with ".$_GET["txt_disper"]." Discount On ".date("Y-m-d", strtotime($_GET['dtfrom']));
			}	
    		
			if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optperiod")) {
			 	$heading = "Sales Summery Report with ".$_GET["txt_disper"]." Discount From ".date("Y-m-d", strtotime($_GET['dtfrom']) )." To ".date("Y-m-d", strtotime($_GET['dtto']) );
			}	
		} else {
    		if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optdaily")) { 
				$heading = "S.V.A.T. Sales Summery Report with ".$_GET["txt_disper"]." Discount On ".date("Y-m-d", strtotime($_GET['dtfrom']) );
			}
    		
			if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optperiod")) { 
				$heading = "S.V.A.T. Sales Summery Report with ".$_GET["txt_disper"]." Discount From ".date("Y-m-d", strtotime($_GET['dtfrom']) )." To ".date("Y-m-d", strtotime($_GET['dtto']) );
			}
		}
		
		if (($_GET["radio"]=="optreturn") and ($_GET["radio2"]=="optdaily")) { 
			$heading = "Sales Return Summery Report with ".$_GET["txt_disper"]." Discount On ".date("Y-m-d", strtotime($_GET['dtfrom']));
		}	
		
		if (($_GET["radio"]=="optreturn") and ($_GET["radio2"]=="optperiod")) { 
			$heading = "Sales Return Summery Report with ".$_GET["txt_disper"]." Discount From  ".date("Y-m-d", strtotime($_GET['dtfrom']))." To ".date("Y-m-d", strtotime($_GET['dtto']));
		}
		
		$sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Invoice No</th>
		<th>Customer</th>
		<th>Cr. Days</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";
		//echo $sql;
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		while($row = mysqli_fetch_array($result)){	
			echo "<tr>
			<td>".$row["SDATE"]."</td>
			<td>".$row["REF_NO"]."</td>";
			
			$rst_cus="select * from vendor where CODE='".$row["C_CODE"]."'";
			$result_cus =mysqli_query($GLOBALS['dbinv'],$rst_cus);
			$row_cus = mysqli_fetch_array($result_cus);
			echo "<td>".$row["C_CODE"]." ".$row_cus["NAME"]."</td>
			<td align=\"right\">".$row["cre_pe"]."</td>
			<td align=\"right\">".number_format($row["AMOUNT"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["VAT_VAL"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["GRAND_TOT"], 2, ".", ",")."</td>
			</tr>";
		}
		
		echo "<table>";
	}
}


function dis_sales()
{
	require_once("connectioni.php");
	
	
	
	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
		$sql = "SELECT * from view_s_invo where DIS_per=".$_GET["txt_disper"]." and    (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by SDATE";
	}	
	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
		$sql = "SELECT * from view_s_invo where DIS_per=".$_GET["txt_disper"]." and    SDATE='".$_GET["dtfrom"]."'  and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by SDATE";
	}	
	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]="optperiod")) { 
		$sql = "SELECT * from view_s_invo where Brand_name='".$_GET["CmbBrand"]."' and DIS_per=".$_GET["txt_disper"]." and    (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by SDATE";
	}	
	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
		$sql = "SELECT * from view_s_invo where Brand_name='".$_GET["CmbBrand"]."' and DIS_per=".$_GET["txt_disper"]." and    SDATE='".$_GET["dtfrom"]."'  and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by SDATE";
	}	
	
	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
		$sql = "SELECT * from view_s_invo where Brand_name='".$_GET["CmbBrand"]."' and DIS_per=".$_GET["txt_disper"]." and    SDATE='".$_GET["dtfrom"]."'  and DEV!='".$GLOBALS[$sysdiv]."'and SAL_EX='".$_GET["cmbrep"]."' and CANCELL='0'  order by SDATE";
	}	
	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
		$sql = "SELECT * from view_s_invo where Brand_name='".$_GET["CmbBrand"]."' and DIS_per=".$_GET["txt_disper"]." and    (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and DEV!='".$GLOBALS[$sysdiv]."'and SAL_EX='".$_GET["cmbrep"]."' and CANCELL='0'  order by SDATE";
	}	

	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
		$sql = "SELECT * from view_s_invo where Brand_name='".$_GET["CmbBrand"]."' and DIS_per=".$_GET["txt_disper"]." and    SDATE='".$_GET["dtfrom"]."'  and DEV!='".$GLOBALS[$sysdiv]."'and  CANCELL='0'  order by SDATE";
	}	
	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
		$sql = "SELECT * from view_s_invo where Brand_name='".$_GET["CmbBrand"]."' and DIS_per=".$_GET["txt_disper"]." and    (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and DEV!='".$GLOBALS[$sysdiv]."'and  CANCELL='0'  order by SDATE";
	}	

	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
		$sql = "SELECT * from view_s_invo where DIS_per=".$_GET["txt_disper"]." and    SDATE='".$_GET["dtfrom"]."'  and DEV!='".$GLOBALS[$sysdiv]."'and SAL_EX='".$_GET["cmbrep"]."' and CANCELL='0'  order by SDATE";
	}		
	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
		$sql = "SELECT * from view_s_invo where  DIS_per=".$_GET["txt_disper"]." and    (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and DEV!='".$GLOBALS[$sysdiv]."'and SAL_EX='".$_GET["cmbrep"]."' and CANCELL='0'  order by SDATE";
	}
	
	if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optdaily")) {
	 	$heading = "Sales Summery Report(  ".$_GET["txt_disper"]." % Discount)  On ".date("Y-m-d", strtotime($_GET['dtfrom']));
	}	
	if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optperiod")) { 
		 $heading = "Sales Summery Report   ".$_GET["txt_disper"]." % Discount) From ".date("Y-m-d", strtotime($_GET['dtfrom'])). " To ".date("Y-m-d", strtotime($_GET['dtto']));
	}	 
	if (($_GET["radio"]=="optreturn") and ($_GET["radio2"]=="optdaily")) { 
		$heading = "Sales Return Summery Report On " .date("Y-m-d", strtotime($_GET['dtfrom']));
	}	
	if (($_GET["radio"]=="optreturn") and ($_GET["radio2"]=="optperiod")) { 
		$heading = "Sales Return Summery Report From  ".date("Y-m-d", strtotime($_GET['dtfrom']))." To ".date("Y-m-d", strtotime($_GET['dtto']));
	}	
	

}

//////////// Scrap //////////////////////////////////////
function printscrap()
{
	require_once("connectioni.php");
	
	

	if ($_GET["radio"]=="optscrap") {
    	if ($_GET["chk_svat"] != "on") {
        	if ($_GET["chkcus"]=="on") {
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
				 	$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by id";
				}	
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by id";
            	}
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by REF_NO";
				}	
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by id";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by REF_NO";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by id";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by REF_NO";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."'and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by id";
        		}
			} else {
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by id";
            	}
				if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by id";
				}	
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."'and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0'  order by REF_NO";
				}	
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by id";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and SAL_EX='".$_GET["cmbrep"]."'and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by REF_NO";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and SAL_EX='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by id";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."'and SAL_EX='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0'  order by REF_NO";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' and CANCELL='0' order by id";
				}	
        	}
    	} else {
        	
			if ($_GET["chkcus"]=="true"){
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
				 	$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0' and svat > '0' order by id";
				}	
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and svat > '0'  order by id";
				}	
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and svat > '0' order by REF_NO";
				}	
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0' and svat > '0'  order by id";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and svat > '0' order by REF_NO";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and svat > '0' order by id";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0' and svat > '0' order by REF_NO";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' and C_CODE='".$_GET["txt_cuscode"]."'and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0' and svat > '0' order by id";
				}	
        	} else {
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and svat > '0' order by id";
				}	
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and DEV!='".$GLOBALS[$sysdiv]."' and CANCELL='0' and svat > '0' order by id";
				}	
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."'and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0' and svat > '0' order by REF_NO";
				}	
            	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0' and svat > '0' order by id";
				}
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and SAL_EX='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0' and svat > '0' order by REF_NO";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and SAL_EX='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0' and svat > '0' order by id";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."'and CANCELL='0' and svat > '0' order by REF_NO";
				}	
            	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
					$sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')  and Brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' and CANCELL='0' and svat > '0' order by id";
				}	
        	}
		}	
    }

 	if ($_GET["chk_discount"]== "on") {
		dis_sales();
	} else {
		if ($_GET["chk_svat"] != "on") {
    		if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optdaily")) {
			 	$heading =  "Sales Summery Report with ".$_GET["txt_disper"]." Discount On ".date("Y-m-d", strtotime($_GET['dtfrom']));
			}	
    		if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optdaily")) { 
				$heading =  "Sales Summery Report with".$_GET["txt_disper"]." Discount From ".date("Y-m-d", strtotime($_GET['dtfrom'])). " To " .date("Y-m-d", strtotime($_GET['dtto']));
			}	
		} else {
    		if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optdaily")) { 
				$heading =  "S.V.A.T. Sales Summery Report with".$_GET["txt_disper"]." Discount On ".date("Y-m-d", strtotime($_GET['dtfrom']));
			}
    		if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optdaily")) { 
				$heading =  "S.V.A.T. Sales Summery Report with".$_GET["txt_disper"]." Discount From ".date("Y-m-d", strtotime($_GET['dtfrom']))." To " .date("Y-m-d", strtotime($_GET['dtto']));
			}	
		}
		if (($_GET["radio"]=="optreturn") and ($_GET["radio2"]=="optdaily")) { 
			$heading =  "Sales Return Summery Report with".$_GET["txt_disper"]." Discount On ".date("Y-m-d", strtotime($_GET['dtfrom']));
		}	
		if (($_GET["radio"]=="optreturn") and ($_GET["radio2"]=="optdaily")) { 
			$heading =  "Sales Return Summery Report with".$_GET["txt_disper"]." Discount From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
		}	

	}
}


function Printret()
{
	require_once("connectioni.php");
	
	
	
	 if ($_GET["radio"]=="optreturn") {
 		if ($_GET["chkcus"] == "on") {
 			if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
				$sql = "SELECT * from viewreturn where SDATE='".$_GET["dtfrom"]."' and  trn_type!='ARN' and   trn_type!='INC' and   trn_type!='REC' and CUSCODE ='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."'order by id";
			}	
 			if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
				$sql = "SELECT * from viewreturn where (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and   trn_type!='REC' and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and   trn_type!='ARN' and   trn_type!='INC' and CUSCODE ='".$_GET["txt_cuscode"]."'and DEV!='".$GLOBALS[$sysdiv]."'   order by id";
			}	
			if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
				$sql = "SELECT * from viewreturn where SDATE='".$_GET["dtfrom"]."' and  trn_type!='ARN' and   trn_type!='INC' and   trn_type!='REC' and brand='".$_GET["CmbBrand"]."' and CUSCODE ='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' order by id";
			}	
 			if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
				$sql = "SELECT * from viewreturn where (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and   trn_type!='REC' and  (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')and  trn_type!='ARN' and   trn_type!='INC' and brand='".$_GET["CmbBrand"]."' and CUSCODE ='".$_GET["txt_cuscode"]."' order by id";
			}	
 			if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
				$sql = "SELECT * from viewreturn where SDATE='".$_GET["dtfrom"]."' and   trn_type!='ARN' and   trn_type!='REC' and trn_type!='INC' and sal_ex ='".$_GET["cmbrep"]."' and CUSCODE ='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."'  order by id";
			}	
 			if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
				$sql = "SELECT * from viewreturn where (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and   trn_type!='REC' and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and   trn_type!='ARN'  and  trn_type!='INC' and sal_ex ='".$_GET["cmbrep"]."' and CUSCODE ='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."' order by id";
			}	
 			if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
				$sql = "SELECT * from viewreturn where SDATE='".$_GET["dtfrom"]."' and  trn_type!='ARN' and   trn_type!='REC' and   trn_type!='INC'and brand='".$_GET["CmbBrand"]."'and sal_ex =".$_GET["cmbrep"]." and CUSCODE ='".$_GET["txt_cuscode"]."'  and DEV!='".$GLOBALS[$sysdiv]."' order by id";
			}	
 			if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
				$sql = "SELECT * from viewreturn where (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and   trn_type!='REC' and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and  trn_type!='ARN'  and  trn_type!='INC' and brand='".$_GET["CmbBrand"]."' and sal_ex ='".$_GET["cmbrep"]."' and CUSCODE ='".$_GET["txt_cuscode"]."' and DEV!='".$GLOBALS[$sysdiv]."'  order by id";
			}	
		} else {
			if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
				$sql = "SELECT * from viewreturn where SDATE='".$_GET["dtfrom"]."' and  trn_type!='ARN' and   trn_type!='REC' and   trn_type!='INC' and DEV!='".$GLOBALS[$sysdiv]."' order by id";
			}	
 			if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
				$sql = "SELECT * from viewreturn where (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and  trn_type!='ARN' and   trn_type!='REC' and   trn_type!='INC' and DEV!='".$GLOBALS[$sysdiv]."'  order by id";
			}	
 			if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
				$sql = "SELECT * from viewreturn where SDATE='".$_GET["dtfrom"]."'and  trn_type!='ARN' and   trn_type!='INC' and brand='".$_GET["CmbBrand"]."'and   trn_type!='REC' and DEV!='".$GLOBALS[$sysdiv]."'  order by id";
			}	
 			if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
				$sql = "SELECT * from viewreturn where (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and   trn_type!='REC' and  trn_type!='ARN' and   trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "'and DEV!='".$GLOBALS[$sysdiv]."' order by id";
			}	
 			if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
				$sql = "SELECT * from viewreturn where SDATE='".$_GET["dtfrom"]."'and  trn_type!='ARN' and    trn_type!='INC'and   trn_type!='REC' and sal_ex ='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."'order by id";
			}	
 			if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
				$sql = "SELECT * from viewreturn where (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."') and  trn_type!='ARN' and   trn_type!='REC' and   trn_type!='INC' and sal_ex ='".$_GET["cmbrep"]." 'and DEV!='".$GLOBALS[$sysdiv]."' order by id";
			}	
 			if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
				$sql = "SELECT * from viewreturn where SDATE='".$_GET["dtfrom"]."' and  trn_type!='ARN' and   trn_type!='INC' and brand='".$_GET["CmbBrand"]."' and    trn_type!='REC'AND  sal_ex =".$_GET["cmbrep"]."and DEV!='".$GLOBALS[$sysdiv]."' order by id";
			}	
 			if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
				$sql = "SELECT * from viewreturn where (SDATE>'".$_GET["dtfrom"]."' or SDATE='".$_GET["dtfrom"]."') and (SDATE<'".$_GET["dtto"]."' or SDATE='".$_GET["dtto"]."')and   trn_type!='REC' and  trn_type!='ARN' and   trn_type!='INC' and brand='".$_GET["CmbBrand"]."'and sal_ex ='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."' order by id";
			}	
		}
    
	}
	
	if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optdaily")) { 
		$heading = "Sales Summery Report On ".date("Y-m-d", strtotime($_GET['dtfrom']));
	}	
	if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optperiod")) { 
		$heading = "Sales Summery Report From ".date("Y-m-d", strtotime($_GET['dtfrom'])). " To ".date("Y-m-d", strtotime($_GET['dtto']));
	}	
	if (($_GET["radio"]=="optreturn") and ($_GET["radio2"]=="optdaily")) { 
		$heading = "Sales Return Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom']));
	}	
	if (($_GET["radio"]=="optreturn") and ($_GET["radio2"]=="optperiod")) {
		 $heading =  "Sales Return Summery Report From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtfrom']));
	}
	$txtremark= "Sales By    ".$_GET["cmbrep"]. "   Brand  :  " . $_GET["CmbBrand"];	

}


function grnsummery()
{

	require_once("connectioni.php");
	
	
	
	if ($_GET["chk_svat"] != "on") {
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
			$strsql = "select * from viewreturn where CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' ";
		}	
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and (SDATE='".$_GET["dtfrom"]."' or  SDATE >'".$_GET["dtfrom"]."') and (SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."') and DEV!='".$GLOBALS[$sysdiv]."'";
		}	
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='".$_GET["txt_cuscode"]."' and    trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' and Brand='".$_GET["CmbBrand"]."' ";
		}	
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and (SDATE='".$_GET["dtfrom"]. "' or SDATE >'".$_GET["dtfrom"]."') and (SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."') and brand='".$_GET["CmbBrand"]."' and DEV!='".$GLOBALS[$sysdiv]."'";
		}	
    
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' and SAL_EX='".$_GET["cmbrep"]."' ";
		}	
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and (SDATE='".$_GET["dtfrom"]."' or SDATE >'".$_GET["dtfrom"]."')and(SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."') and SAL_EX='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."' ";
    	}
		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' and brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' ";
		}	
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and (SDATE='".$_GET["dtfrom"]. "' or SDATE >'".$_GET["dtfrom"]."')and(SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."') and brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."'and DEV!='".$GLOBALS[$sysdiv]."' ";
		}	
    
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' ";
		}	
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where trn_type='GRN' and (SDATE='".$_GET["dtfrom"]."' or  SDATE >'".$_GET["dtfrom"]."') and (SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."') and DEV!='".$GLOBALS[$sysdiv]."'";
		}	
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' and brand='".$_GET["CmbBrand"]."' ";
		}	
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where trn_type='GRN' and (SDATE='".$_GET["dtfrom"]."' or SDATE >'".$_GET["dtfrom"]."') and (SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."') and brand='".$_GET["CmbBrand"]."' and DEV!='".$GLOBALS[$sysdiv]."'";
		}	
    
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
			$strsql = "select * from viewreturn where trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' and SAL_EX='".$_GET["cmbrep"]."' ";
		}	
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where trn_type='GRN' and (SDATE='".$_GET["dtfrom"]."' or SDATE >'".$_GET["dtfrom"]."') and (SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."') and SAL_EX='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."' ";
		}	
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' and brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' ";
		}	
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where trn_type='GRN' and (SDATE='".$_GET["dtfrom"]."' or SDATE >'".$_GET["dtfrom"]."') and (SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."') and brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."' ";
		}	
	} else {
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn_svat where CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' and SVAT > '0' ";
		}	
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn_svat where  CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and (SDATE='".$_GET["dtfrom"]."' or  SDATE >'".$_GET["dtfrom"]."') and (SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."')and DEV!='".$GLOBALS[$sysdiv]."' and SVAT > '0'";
		}	
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn_svat where  CUSCODE='".$_GET["txt_cuscode"]."' and    trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' and brand='".$_GET["CmbBrand"]."' and SVAT > '0' ";
		}	
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn_svat where  CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and (SDATE='".$_GET["dtfrom"]."' or SDATE >'".$_GET["dtfrom"]."')and(SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."') and brand='".$_GET["CmbBrand"]."'and DEV!='".$GLOBALS[$sysdiv]."' and SVAT > '0'";
		}	
    
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn_svat where  CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' and SAL_EX='".$_GET["cmbrep"]."' and SVAT > '0' ";
		}	
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn_svat where  CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and (SDATE='".$_GET["dtfrom"]."' or SDATE >'".$_GET["dtfrom"]."')and(SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."') and SAL_EX='".$_GET["cmbrep"]."'and DEV!='".$GLOBALS[$sysdiv]."' and SVAT > '0' ";
		}	
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn_svat where  CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' and brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' and SVAT > '0' ";
		}	
    	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn_svat where  CUSCODE='".$_GET["txt_cuscode"]."' and   trn_type='GRN' and (SDATE='".$_GET["dtfrom"]."' or SDATE >'".$_GET["dtfrom"]."')and(SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."') and brand='".$_GET["CmbBrand"]."' and SAL_EX='".$_GET["cmbrep"]."' and DEV!='".$GLOBALS[$sysdiv]."' and SVAT > '0'";
		}	
    
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn_svat where trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' and SVAT > '0' ";
		}	
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn_svat where trn_type='GRN' and (SDATE='".$_GET["dtfrom"]."' or  SDATE >'".$_GET["dtfrom"]."')and(SDATE='".$_GET["dtto"]."' or SDATE < '".$_GET["dtto"]."')and DEV!='".$GLOBALS[$sysdiv]."' and SVAT > '0'";
		}	
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn_svat where trn_type='GRN' and SDATE='".$_GET["dtfrom"]."' and brand='".$_GET["CmbBrand"] . "' and SVAT > '0' ";
		}	
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn_svat where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "'and DEV!='".$GLOBALS[$sysdiv]."' and SVAT > '0'";
    	}
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn_svat where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and SVAT > '0' ";
		}	
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn_svat where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='".$GLOBALS[$sysdiv]."' and SVAT > '0' ";
		}	
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]="optdaily")) {
		 	$strsql = "select * from viewreturn_svat where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and SVAT > '0' ";
		}	
    	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn_svat where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='".$GLOBALS[$sysdiv]."' and SVAT > '0' ";
		}	
	}
	
	if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optdaily")) {
	 	$rtxtdate = "Sales Summery Report On " .date("Y-m-d", strtotime($_GET['dtfrom'])). "   Brand  :   " . $_GET["CmbBrand"];
	}	
	if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optperiod")) { 
		$rtxtdate = "Sales Summery Report From ". date("Y-m-d", strtotime($_GET['dtfrom'])) ." To " .date("Y-m-d", strtotime($_GET['dtto'])) . "   Brand  :   " . $_GET["CmbBrand"];
	}	
	if (($_GET["radio"]=="optreturn") and ($_GET["radio2"]=="optdaily")) { 
		$rtxtdate= "Sales Return Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom'])) ."   Brand  :   "  . $_GET["CmbBrand"];
	}	
	if (($_GET["radio"]=="optreturn") and ($_GET["radio2"]="optperiod")) { 
		$rtxtdate= "Sales Return Summery Report From  "  . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " .date("Y-m-d", strtotime($_GET['dtto'])) . "   Brand  :   "  . $_GET["CmbBrand"];
	}
	
		$sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$rtxtdate."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Ref No</th>
		<th>Customer</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";
		
		$strsql=$strsql." order by brand";
		//echo $strsql;
		$br="";
		$AMOUNT=0;
		$SVAT=0;
		$BALANCE=0;
		
		$status=0;	
			
		$result =mysqli_query($GLOBALS['dbinv'],$strsql);
		while($row = mysqli_fetch_array($result)){	
			if ($br!=$row["brand"]){
				if ($status!=0){
					echo "<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><b>".number_format($AMOUNT, 2, ".", ",")."</b></td><td><b>".number_format($SVAT, 2, ".", ",")."</b></td><td><b>".number_format($BALANCE, 2, ".", ",")."</b></td>
					</tr>";
				}	
				
				echo "<tr>
				<td colspan=\"6\" align=\"left\"><b>".$row["brand"]."</b></td>
				</tr>";
				$br=$row["brand"];
				$AMOUNT=0;
				$SVAT=0;
				$BALANCE=0;
				
				$status=1;
			}	
			echo "<tr>
			<td>".$row["SDATE"]."</td>
			<td>".$row["REFNO"]."</td>
			<td>".$row["CUSCODE"]." ".$row["NAME"]."</td>
			<td align=\"right\">".number_format($row["AMOUNT"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["SVAT"], 2, ".", ",")."</td>
			<td align=\"right\">".number_format($row["BALANCE"], 2, ".", ",")."</td>
			</tr>";
			
			$AMOUNT=$AMOUNT+$row["AMOUNT"];
			$SVAT=$$SVAT+$row["SVAT"];
			$BALANCE=$BALANCE+$row["BALANCE"];
		}
		
		echo "<tr>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>".number_format($AMOUNT, 2, ".", ",")."</b></td><td align=\"right\"><b>".number_format($SVAT, 2, ".", ",")."</b></td><td align=\"right\"><b>".number_format($BALANCE, 2, ".", ",")."</b></td>
				</tr>";
				
		echo "<table>";

}	



//////
function crnsummery()
{
	require_once("connectioni.php");
	
	
	
	if ($_GET["chk_cash"] != "on") {
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' order by refno ";
   		}
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='" . $_GET["txt_cuscode"] . "' and(trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (Sdate='" . $_GET["dtfrom"] . "' or Sdate >'" . $_GET["dtfrom"] . "')and(Sdate='" . $_GET["dtto"] . "' or Sdate < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' order by refno ";
   		}
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
		}	
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (Sdate='" . $_GET["dtfrom"] . "' or Sdate >'" . $_GET["dtfrom"] . "')and(Sdate='" . $_GET["dtto"] . "' or Sdate < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno";
		}	
	} else {
   
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
	   	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and flag1 = '1' order by refno ";
		}	
   
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where  CUSCODE='" . $_GET["txt_cuscode"] . "' and(trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
   		if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (Sdate='" . $_GET["dtfrom"] . "' or Sdate >'" . $_GET["dtfrom"] . "')and(Sdate='" . $_GET["dtto"] . "' or Sdate < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
   
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and flag1 = '1' order by refno ";
		}	
   
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) {
		 	$strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}	
   		if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
		 	$strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (Sdate='" . $_GET["dtfrom"] . "' or Sdate >'" . $_GET["dtfrom"] . "')and(Sdate='" . $_GET["dtto"] . "' or Sdate < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
		}
	}		
	
	if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optdaily")) {
	 	$rtxtdate= "Sales Summery Report On ". date("Y-m-d", strtotime($_GET['dtfrom'])) ;
	}	
	if (($_GET["radio"]=="optsales") and ($_GET["radio2"]=="optperiod")) { 
		$rtxtdate= "Sales Summery Report From ". date("Y-m-d", strtotime($_GET['dtfrom'])). " To ".date("Y-m-d", strtotime($_GET['dtto'])). "   Brand  :   " . $_GET["CmbBrand"];
	}	
	if (($_GET["radio"]=="optreturn") and ($_GET["radio2"]=="optdaily")) {
	 	$rtxtdate= "Sales Return Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   Brand  :   " .$_GET["CmbBrand"];
	}	
	if (($_GET["radio"]=="optreturn") and ($_GET["radio2"]=="optperiod")) { 
		$rtxtdate= "Sales Return Summery Report From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " .date("Y-m-d", strtotime($_GET['dtto'])). "   Brand  :   ".$_GET["CmbBrand"];
	}	

}


function Dgrnsummery()
{
	require_once("connectioni.php");
	
	
	
	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
		$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by REFNO";
	}	
	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
	 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' order by REFNO";
	}	
	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
		$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
	}	
	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) {
	 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
	}	

	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
		$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" .  $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
	}	
	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
	 	$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
	}	
	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
		$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
	}	
	if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
		$strsql = "select * from viewreturn where CUSCODE='" . $_GET["txt_cuscode"] . "' and trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
	}	

	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
		$strsql = "select * from viewreturn where trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by REFNO";
	}	
	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
		$strsql = "select * from viewreturn where trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' order by REFNO";
	}	
	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
		$strsql = "select * from viewreturn where trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
	}	
	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
		$strsql = "select * from viewreturn where trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
	}	

	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
		$strsql = "select * from viewreturn where trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
	}	
	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
		$strsql = "select * from viewreturn where trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
	}	
	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
		$strsql = "select * from viewreturn where trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
	}	
	if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
		$strsql = "select * from viewreturn where trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
	}
	
	
	if ($_GET["radio2"]=="optdaily") { 
		$rtxtdate= "Defective Item Report  On         " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   Rep :    " . $_GET["cmbrep"] . "   Brand  :   " . $_GET["CmbBrand"];
	}	
	if ($_GET["radio2"]=="optperiod") {
	 	$rtxtdate = "Defective Item Report  From      " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   To   " . date("Y-m-d", strtotime($_GET['dtto'])) .  "   Rep : " . $_GET["cmbrep"] . "   Brand  :  " . $_GET["CmbBrand"];
	}	
	

}


function recieptrep()
{
	require_once("connectioni.php");
	
	
	
	$sql="delete from tmpreceipt ";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
	if ($_GET["cmbRECtype"] == "Ret.ch") { $rettype = "RET"; } 
	if ($_GET["cmbRECtype"] == "Normal") { $rettype = "REC"; }
    if ($_GET["chkcus"] != "on") {
    	if ($_GET["cmbretchktype"] == "All") {
        	if (($_GET["radio2"]=="optdaily") and ($_GET["cmbRECtype"] == "All")) { 
				$rct= "select * from s_crec where CA_DATE='".$_GET["dtfrom"]."' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' order by CA_REFNO ";
			}
        	if (($_GET["radio2"]=="optperiod") and ($_GET["cmbRECtype"] == "All")) { 
				$rct= "select * from s_crec where (CA_DATE='" .$_GET["dtfrom"] . "' or CA_DATE>'" .$_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' order by CA_REFNO";
			}	
        
        	if (($_GET["radio2"]=="optdaily") and ($_GET["cmbRECtype"] != "All")) { 
				$rct= "select * from s_crec where CA_DATE='" .$_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and  CANCELL='0' order by CA_REFNO ";
			}	
        	
			if (($_GET["radio2"]=="optperiod") and ($_GET["cmbRECtype"] != "All")) {
			 	$rct= "select * from s_crec where (CA_DATE='" .$_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and  CANCELL='0' order by CA_REFNO ";
			}	
    	} else {
    
        	if (($_GET["radio2"]=="optdaily") and ($_GET["cmbRECtype"] == "All")) { 
				$rct= "select * from s_crec where CA_DATE='" .$_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0' order by CA_REFNO ";
			}	
        	if (($_GET["radio2"]=="optperiod") and ($_GET["cmbRECtype"] == "All")) { 
				$rct= "select * from s_crec where (CA_DATE='" .$_GET["dtfrom"] . "' or CA_DATE>'" .$_GET["dtfrom"] . "' ) and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0' order by CA_REFNO";
			}	
        
        	if (($_GET["radio2"]=="optdaily") and ($_GET["cmbRECtype"] != "All")) { 
				$rct= "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0' order by CA_REFNO";
			}	
        	if (($_GET["radio2"]=="optperiod") and ($_GET["cmbRECtype"] != "All")) { 
				$rct= "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" .$_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0' order by CA_REFNO";
			}	
    	}
    
	}
	
	if ($_GET["chkcus"] == "on") {
    	if ($_GET["cmbretchktype"] == "All") {
        	if (($_GET["radio2"]=="optdaily") and ($_GET["cmbRECtype"] == "All")) {
			 	$rct= "select * from s_crec where CA_DATE='" .$_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' order by CA_REFNO ";
			}	
        	if (($_GET["radio2"]=="optperiod") and ($_GET["cmbRECtype"] == "All")) { 
				$rct = "select * from s_crec where (CA_DATE='" .$_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' order by CA_REFNO";
			}	
        
        	if (($_GET["radio2"]=="optdaily") and ($_GET["cmbRECtype"] != "All")) { 
				$rct= "select * from s_crec where CA_DATE='" .$_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' order by CA_REFNO ";
			}	
        	if (($_GET["radio2"]=="optperiod") and ($_GET["cmbRECtype"] != "All")) { 
				$rct= "select * from s_crec where (CA_DATE='" .$_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and  CANCELL='0' and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' order by CA_REFNO ";
			}	
    	} else {
    
        	if (($_GET["radio2"]=="optdaily") and ($_GET["cmbRECtype"] == "All")) { 
				$rct= "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $_GET["cmbretchktype"] . "'and  CANCELL='0' and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' order by CA_REFNO";
			}	
        	if (($_GET["radio2"]=="optperiod") and ($_GET["cmbRECtype"] == "All")) {
			 	$rct= "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' order by CA_REFNO ";
			}	
        
        	if (($_GET["radio2"]=="optdaily") and ($_GET["cmbRECtype"] != "All")) { 
				$rct= "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' order by CA_REFNO ";
			}	
        	if (($_GET["radio2"]=="optperiod") and ($_GET["cmbRECtype"] != "All")) { 
				$rct= "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'"  .$_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0'and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' order by CA_REFNO";
			}	
    	}
	}	
    $tota=0;
	//echo $rct;
	$result_rct =mysqli_query($GLOBALS['dbinv'],$rct);
	while($row_rct = mysqli_fetch_array($result_rct)){
		if ($row_rct["CA_CASSH"]>0){
			
			if (trim($row_rct["pay_type"]) == "Cheque") {
            	$ptype = "Cash";
        	} else {
            	$ptype = trim($row_rct["pay_type"]);
			}	
        
			$sql="insert into tmpreceipt(REF_NO, CUS_REF, ptype, SDATE, cash, DEPARTMENT) values ('".$row_rct["CA_REFNO"]."', '".$row_rct["CUS_REF"]."', '".$ptype."', '".$row_rct["CA_DATE"]."', '".$row_rct["CA_CASSH"]."', '".$row_rct["DEPARTMENT"]."')";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$tota = tota + $row_rct["CA_CASSH"];
		}
		
		$sql_invch="select * from s_invcheq where refno='".$row_rct["CA_REFNO"]."'";
		$result_invch =mysqli_query($GLOBALS['dbinv'],$sql_invch);
		while($row_invch = mysqli_fetch_array($result_invch)){
			$sql_tmpCh="select * from tmpreceipt where ch_no='".trim($row_invch["cheque_no"])."' and branch='".trim($row_invch["bank"])."'";
			$result_tmpCh =mysqli_query($GLOBALS['dbinv'],$sql_tmpCh);
			if($row_tmpCh = mysqli_fetch_array($result_tmpCh)){
			} else {
				$chQty = $chQty + 1;
			}
			$sql="insert into tmpreceipt(REF_NO, SDATE, ch_date, ch_no, ch_amount, bank, branch, DEPARTMENT) values ('".$row_rct["CA_REFNO"]."', '".$row_rct["CA_DATE"]."', '".$row_invch["che_date"]."', '".$row_invch["cheque_no"]."', '".$row_invch["che_amount"]."', '".$row_invch["cus_code"]."', '".$row_invch["bank"]."', '".$row_invch["department"]."')";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$tota = $tota + $row_invch["che_amount"];
		}	
	}
	
	
	if ($_GET["radio2"]=="optdaily"){  
		$rtxtdate= "Receipt Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom']));
	}	
	if ($_GET["radio2"]=="optperiod") { 
		$rtxtdate= "Receipt Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
	}		
	if ($_GET["cmbRECtype"] == "Ret.ch") {
		$txtrectype ="Return Cheque";
	}	
	if ($_GET["cmbRECtype"] == "Normal") { 
		$txtrectype= "Invoice";
	}	
	if ($_GET["cmbRECtype"] == "All") { 
		$txtrectype= "All";
	}	
	if ($_GET["chkcus"] == "on") { 
		$txtcus = "Customer    " . $_GET["txt_cuscode"] . "    " . $_GET["txt_cusname"];
	}
	
	
	if ($_GET["cmbretchktype"] == "All") {
    	
		if ($_GET["chkcus"] != "on") {
        
            if (($_GET["radio2"]=="optdaily") and ($_GET["cmbRECtype"] == "All")){
                
				$sql_ch= "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='".$_GET["dtfrom"]."' and DEV !='".$GLOBALS[$sysdiv]."' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque')  ";
                
				$sql_ch1= "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";
				
                $sql_ch_sc= "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";
                
				$sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='".$_GET["dtfrom"]."' and DEV!='".$GLOBALS[$sysdiv]."' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT')  ";
				
                $sql_jn= "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='".$_GET["dtfrom"]."' and DEV!='". $GLOBALS[$sysdiv]."' and  CANCELL='0' and (pay_type='J/Entry')  ";
				
                $sql_re= "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='".$_GET["dtfrom"]."' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='R/Deposit')  ";

            }
            
            if (($_GET["radio2"]=="optperiod") and ($_GET["cmbRECtype"] == "All")) {
                $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='".$_GET["dtfrom"]."' or CA_DATE>'".$_GET["dtfrom"]."' )and (CA_DATE='".$_GET["dtto"]."' or CA_DATE<'".$_GET["dtto"]."'  ) and DEV!='".$GLOBALS[$sysdiv]."' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque') ";
                $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";
                $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";
                $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='".$_GET["dtfrom"]."' or CA_DATE>'".$_GET["dtfrom"]."' )and (CA_DATE='".$_GET["dtto"]."' or CA_DATE<'".$_GET["dtto"]."'  ) and DEV!='".$GLOBALS[$sysdiv]."' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT') ";
                $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='".$_GET["dtfrom"]."' or CA_DATE>'".$_GET["dtfrom"]."') and (CA_DATE='".$_GET["dtto"]."' or CA_DATE<'".$_GET["dtto"]."'  ) and DEV!='".$GLOBALS[$sysdiv]."' and  CANCELL='0' and (pay_type='J/Entry') ";
                $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='".$_GET["dtfrom"]."' or CA_DATE>'" .$_GET["dtfrom"]. "' )and (CA_DATE='".$_GET["dtto"]."' or CA_DATE<'".$_GET["dtto"]."'  ) and DEV!='".$GLOBALS[$sysdiv]."' and  CANCELL='0' and (pay_type='R/Deposit')";
            }
            
            if (($_GET["radio2"]=="optdaily") and ($_GET["cmbRECtype"] != "All")) {
                $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='".$_GET["dtfrom"]."' and DEV!='".$GLOBALS[$sysdiv]."' and FLAG ='".$rettype."' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque')  ";
				
                $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";
				
                $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";
				
                $sql_tt = "select sum(CA_AMOUNT) as ttamo  from s_crec where DEPARTMENT = 'O' and  CA_DATE='".$_GET["dtfrom"]."' and DEV!='".$GLOBALS[$sysdiv]."' and FLAG ='".$rettype."' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT')  ";
				
                $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='".$_GET["dtfrom"]."' and DEV!='".$GLOBALS[$sysdiv]."' and FLAG ='".$rettype."' and  CANCELL='0' and (pay_type='J/Entry')  ";
				
                $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='".$_GET["dtfrom"]."' and DEV!='".$GLOBALS[$sysdiv]."' and FLAG ='".$rettype."' and  CANCELL='0' and (pay_type='R/Deposit') ";
           
            }
            
            if (($_GET["radio2"]=="optperiod") and ($_GET["cmbRECtype"] != "All")) {
			
                $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" .  $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and .FLAG ='" . $rettype . "'and  CANCELL='0'and (pay_type='Cash' or pay_type='Cheque') ";
				
                $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";
				
                $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";
				
                $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and .FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT') ";
				
                $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and .FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='J/Entry') ";
				
                $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and .FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='R/Deposit') ";
            }
    	}	
    	
		if ($_GET["chkcus"] == "on") {
        
            if (($_GET["radio2"]=="optdaily") and ($_GET["cmbRECtype"] == "All")) {
                $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque') and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' ";
				
                $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";
                
				$sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";
                
				$sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT') and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' ";
				
                $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='J/Entry') and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' ";
				
                $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='R/Deposit')  and CA_CODE='" . trim($_GET["txt_cuscode"]) . "'";

            }
            
            if (($_GET["radio2"]=="optperiod") and ($_GET["cmbRECtype"] == "All")) {
                $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque') and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' ";
				
                $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";
				
                $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";
				
                $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT') and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' ";
				
                $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='J/Entry') and CA_CODE='" . trim($_GET["txt_cuscode"]) . "'  ";
				
                $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='R/Deposit') and CA_CODE='" . trim($_GET["txt_cuscode"]) . "'";
            }
            
            if (($_GET["radio2"]=="optdaily") and ($_GET["cmbRECtype"] != "All")) {
                $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque') and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' ";
				
                $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";
				
                $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";
				
                $sql_tt = "select sum(CA_AMOUNT) as ttamo  from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT')  and CA_CODE='" . trim($_GET["txt_cuscode"]) . "'";
                $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='J/Entry')  and CA_CODE='" . trim($_GET["txt_cuscode"]) . "'";
                $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='R/Deposit') and CA_CODE='" . trim($_GET["txt_cuscode"]) . "'";
           
            }
            
            if (($_GET["radio2"]=="optperiod") and ($_GET["cmbRECtype"] != "All")) {
                $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and .FLAG ='" . $rettype . "'and  CANCELL='0'and (pay_type='Cash' or pay_type='Cheque') and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' ";
				
                $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";
				
                $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";
				
                $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and .FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT')  and CA_CODE='" . trim($_GET["txt_cuscode"]) . "'";
				
                $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and .FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='J/Entry') and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' ";
				
                $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and .FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='R/Deposit')  and CA_CODE='" . trim($_GET["txt_cuscode"]) . "' ";
				
            }
    	}
   
   
   		$result_ch =mysqli_query($GLOBALS['dbinv'],$sql_ch);
		$row_ch = mysqli_fetch_array($result_ch);
		
		$result_ch1 =mysqli_query($GLOBALS['dbinv'],$sql_ch1);
		$row_ch1 = mysqli_fetch_array($result_ch1);
		
		$result_ch_sc =mysqli_query($GLOBALS['dbinv'],$sql_ch_sc);
		$row_ch_sc = mysqli_fetch_array($result_ch_sc);
		
		$result_tt =mysqli_query($GLOBALS['dbinv'],$sql_tt);
		$row_tt = mysqli_fetch_array($result_tt);
		
		$result_jn =mysqli_query($GLOBALS['dbinv'],$sql_jn);
		$row_jn = mysqli_fetch_array($result_jn);
		
		$result_re =mysqli_query($GLOBALS['dbinv'],$sql_re);
		$row_re = mysqli_fetch_array($result_re);
																	
   		if (is_null($row_ch["chamo"])==false) {
      		$CHA = $row_ch["chamo"];
   		} else {
      		$CHA = 0;
   		}
		
		if (is_null($row_ch["chamo"])==false) {
      		$CHA1 = $row_ch1["chamo"];
   		} else {
      		$CHA1 = 0;
   		}
		
		if (is_null($row_sc["chamo"])==false) {
      		$CHA_SC = $row_sc["chamo"];
   		} else {
      		$CHA_SC = 0;
   		}
		
		if (is_null($row_tt["chamo"])==false) {
      		$TTA = $row_tt["chamo"];
   		} else {
      		$TTA = 0;
   		}
		
		if (is_null($row_jn["chamo"])==false) {
      		$JNA = $row_jn["chamo"];
   		} else {
      		$JNA = 0;
   		}
		
		if (is_null($row_re["chamo"])==false) {
      		$REA = $row_re["chamo"];
   		} else {
      		$REA = 0;
   		}
   
  
  
   
    	$rtxcash= number_format($CHA1 - $REA, 2, ".", ",");
	    $rtxscchq= number_format($CHA_SC, 2, ".", ",");
	    $rtxtt =number_format($TTA, 2, ".", ",");
	    $rtxj =number_format($JNA, 2, ".", ",");
	    $rtxre =number_format($REA, 2, ".", ",");
	    $txttot =number_format($CHA + $TTA + $JNA + $REA, 2, ".", ",");
   
	}	
	
	
		$sql_head="select * from invpara";
		$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
		$row_head = mysqli_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		
		echo "<center>".$rtxtdate."</center><br>";
		echo "<center>".$txtrectype."</center><br>";
		echo "<center>".$txtcus."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Ref No</th>
		<th>Cash</th>
		<th>Cash TT</th>
		<th>J/Entry</th>
		<th>Cheque No</th>
		<th>Cheque Date</th>
		<th>Amount</th>
		<th>Scrap</th>
		</tr>";
		//echo $sql;
		
		$sql="select * from tmpreceipt ";
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		while($row = mysqli_fetch_array($result)){
			if ($row["ptype"]=="Cash TT"){
				echo "<tr>
			<td>".$row["SDATE"]."</td>
			<td>".$row["REF_NO"]."</td>
			<td align=\"right\"></td>
			<td align=\"right\">".number_format($row["cash"], 2, ".", ",")."</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			</tr>";
				
			} else if ($row["ptype"]=="J/Entry"){
				echo "<tr>
			<td>".$row["SDATE"]."</td>
			<td>".$row["REF_NO"]."</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\">".number_format($row["cash"], 2, ".", ",")."</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			</tr>";
			} else if ($row["ptype"]=="Cash"){
			echo "<tr>
			<td>".$row["SDATE"]."</td>
			<td>".$row["REF_NO"]."</td>
			<td align=\"right\">".number_format($row["cash"], 2, ".", ",")."</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			</tr>";
			} else {
				
				echo "<tr>
			<td>".$row["SDATE"]."</td>
			<td>".$row["REF_NO"]."</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\">".$row["ch_no"]."</td>
			<td align=\"right\">".$row["ch_date"]."</td>
			<td align=\"right\">".$row["ch_amount"]."</td>
			<td align=\"right\"></td>
			</tr>";
			}
		}
		
		echo "<table>";

}


function summeryrep()
{
	require_once("connectioni.php");
	
	
	
	$totGrosaleVatamt = 0;
	$VatGdRetAmt = 0;
	$VATnetSaleAmt = 0;

	if ($_GET["cmbdev"] == "All") { $dev = "All"; }
	if ($_GET["cmbdev"] == "Manual") { $dev = "0"; }
	if ($_GET["cmbdev"] == "Computer") { $dev = "1"; }

	$TotGroSale = 0;
	$VATgroSale = 0;
	$NVATatgross = 0;

	$totsvatgrosale = 0;
	$SVATgrosale = 0;
	$totgrosaleSVATamou = 0;
	$SVATgdRet = 0;
	$SVATret = 0;
	$SVATNetSale = 0;
	$SVATAmount = 0;
	$NonSvatNet = 0;

	$Totsalret = 0;
	$VATGdRet = 0;
	$NvaGdRet = 0;

	$TotNetSale = 0;
	$VATnetSale = 0;
	$NonVatNet = 0;

	if ($_GET["radio2"]=="optdaily") { 
		$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and SDATE='".$_GET["dtfrom"]."' and DEV!='".$dev."' and CANCELL='0' ";
		
		if ($_GET["radio2"]=="optperiod") { 
			$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and ( SDATE='".$_GET["dtfrom"]."' OR  SDATE>'".$_GET["dtfrom"]."' ) AND ( SDATE='".$_GET["dtto"]."'  OR  SDATE<'".$_GET["dtto"]."' )and DEV!='".$dev."' and CANCELL='0'";
		}	
		
		$result_sale =mysqli_query($GLOBALS['dbinv'],$sql_sale);
		while ($row_sale = mysqli_fetch_array($result_sale)){
		
   			$TotGroSale = $TotGroSale + $row_sale["GRAND_TOT"];
   			if ($row_sale["DEV"] == "0") {
   
      			$totGrosaleVatamt = $totGrosaleVatamt + $row_sale["GRAND_TOT"] * ($row_sale["GST"] / 100) / (1 + ($row_sale["GST"] / 100));
      		} else {	
   			   
      			$totGrosaleVatamt = $totGrosaleVatamt + $row_sale["GRAND_TOT"] * ($row_sale["GST"] / 100) / (1 + ($row_sale["GST"] / 100));
      
   			}
			
   			if ($row_sale["SVAT"] > 0) {
        		$totsvatgrosale = $totsvatgrosale + $row_sale["GRAND_TOT"];
        		if ($row_sale["DEV"] == "0") {

          			$totgrosaleSVATamou = $totgrosaleSVATamou + $row_sale["GRAND_TOT"] * ($row_sale["GST"] / 100) / (1 + ($row_sale["GST"] / 100));
        		} else {
    
          			$totgrosaleSVATamou = $totgrosaleSVATamou + $row_sale["GRAND_TOT"] * ($row_sale["GST"] / 100) / (1 + ($row_sale["GST"] / 100));
          
        		}
    		}
		}	
    }

	if ($_GET["radio2"]=="optdaily") { 
		$sql_c_bal = "select * from c_bal where SDATE='".$_GET["dtfrom"]."' AND trn_type!='ARN' and  trn_type!='INC' and trn_type!='REC'  and DEV!='" . $dev . "' ";
	}	
	if ($_GET["radio2"]=="optperiod") { 
		$sql_c_bal = "select * from c_bal where ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )AND trn_type!='ARN' and trn_type!='REC' and trn_type!='INC'  and DEV!='" . $dev . "'";
	}	
	
	$result_c_bal =mysqli_query($GLOBALS['dbinv'],$sql_c_bal);
	while ($row_c_bal = mysqli_fetch_array($result_c_bal)){
	
  		$TotGdRet = $TotGdRet + $row_c_bal["AMOUNT"];
   		
		$sql_crnma = "Select * From s_crnma where REF_NO = '" . $row_c_bal["REFNO"] . "'";
   		$result_crnma =mysqli_query($GLOBALS['dbinv'],$sql_crnma);
		if ($row_crnma = mysqli_fetch_array($result_crnma)){
        	$sql_salma = " Select * from s_salma where Accname != 'NON STOCK' and REF_NO = '" . $row_crnma["INVOICENO"] . "' ";
       		$result_salma =mysqli_query($GLOBALS['dbinv'],$sql_salma);
			if ($row_salma = mysqli_fetch_array($result_salma)){
            	if ($row_salma["SVAT"] > 0) {
                	$SVATgdRet = $SVATgdRet + $row_c_bal["AMOUNT"] * ($row_c_bal["vatrate"] / 100) / (1 + ($row_c_bal["vatrate"] / 100));
                	$SVATret = $SVATret + $row_c_bal["AMOUNT"];
            	}
        	}
        }
   		
		if ($row_c_bal["DEV"] == "0") {
     
      		$VatGdRetAmt = $VatGdRetAmt + $row_c_bal["AMOUNT"] * ($row_c_bal["vatrate"] / 100) / (1 + ($row_c_bal["vatrate"] / 100));

	   	} else {
    
      		$VatGdRetAmt = $VatGdRetAmt + $row_c_bal["AMOUNT"] * ($row_c_bal["vatrate"] / 100) / (1 + ($row_c_bal["vatrate"] / 100));
     
   		}
   
	}

	if ($_GET["radio2"]=="optdaily") {
	 	$sql_rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $dev . "' and CANCELL='0' and FLAG='REC' and DEPARTMENT = 'O' ";
	}	
	if ($_GET["radio2"]=="optperiod") { 
		$sql_rct = "select * from s_crec where ( CA_DATE='" . $_GET["dtfrom"] . "' OR  CA_DATE>'" . $_GET["dtfrom"] . "' ) AND ( CA_DATE='" . $_GET["dtto"] . "'  OR  CA_DATE<'" . $_GET["dtto"] . "' ) and DEV!='" . $dev . "' and CANCELL='0' and FLAG='REC' and department = 'O' ";
	}	
	$result_rct =mysqli_query($GLOBALS['dbinv'],$sql_rct);
	while ($row_rct = mysqli_fetch_array($result_rct)){

   		$RctAmount = $RctAmount + $row_rct["CA_AMOUNT"];
   		if (is_null($row_rct["overpay"])==false) { 
			$OVpAYMENT = $OVpAYMENT + $row_rct["overpay"];
		}
	}
	
	$VATgroSale = $totGrosaleVatamt;
	$VATGdRet = $VatGdRetAmt;
	$TotNetSale = $TotGroSale - $TotGdRet;
	$VATnetSale = $totGrosaleVatamt - $VatGdRetAmt;
	$NonVatNet = $TotNetSale - $VATnetSale;
	
	$SVATgrosale = $totgrosaleSVATamou;
	$SVATgdRet = $SVATgdRet;
	$SVATNetSale = $totsvatgrosale - $SVATret;
	$SVATAmount = $totgrosaleSVATamou - $SVATgdRet;
	$NonSvatNet = $SVATNetSale - $SVATAmount;
	
	
	if ($_GET["radio2"]=="optdaily") { $rtxtdate= "Sales Report On " . date("Y-m-d", strtotime($_GET["dtfrom"])); }
	if ($_GET["radio2"]=="optperiod") { $rtxtdate = "Sales Report  From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"])); }
	$Text1= number_format($TotGroSale, 2, ".", ",");
	$Text2= number_format($VATgroSale, 2, ".", ",");

	$Text3= number_format($TotGdRet, 2, ".", ",");
	$Text4= number_format($VATGdRet, 2, ".", ",");
	$Text5= number_format($TotNetSale, 2, ".", ",");
	$Text6= number_format($VATnetSale, 2, ".", ",");
	$Text7= number_format($NonVatNet, 2, ".", ",");
	$Text8= number_format($RctAmount, 2, ".", ",");
	$txtoverpay =number_format($OVpAYMENT, 2, ".", ",");
	$txtRecTot= number_format($RctAmount - $OVpAYMENT, 2, ".", ",");
	
	if ($_GET["cmbdev"] == "Computer") {
    //=============================== SVAT =====================================================
    	$Text67= number_format($totsvatgrosale, 2, ".", ",");
	    $Text68 =number_format($SVATgrosale, 2, ".", ",");
	    $Text69 =number_format($SVATret, 2, ".", ",");
	    $Text70 =number_format($SVATgdRet, 2, ".", ",");
	    $Text71 =number_format($SVATNetSale, 2, ".", ",");
	    $Text72 =number_format($SVATAmount, 2, ".", ",");
	    $Text73 =number_format($NonSvatNet, 2, ".", ",");
    
    //=============================== VAT ======================================================
	    $Text45 =number_format($TotGroSale - $totsvatgrosale, 2, ".", ",");
	    $Text46 =number_format($VATgroSale - $SVATgrosale, 2, ".", ",");
	    $Text47 =number_format($TotGdRet - $SVATret, 2, ".", ",");
	    $Text48 =number_format($VATGdRet - $SVATgdRet, 2, ".", ",");
	    $Text49 =number_format($TotNetSale - $SVATNetSale, 2, ".", ",");
	    $Text50 =number_format($VATnetSale - $SVATAmount, 2, ".", ",");
	    $Text51 =number_format($NonVatNet - $NonSvatNet, 2, ".", ",");
	} else {
	
	}

}


function summerysprte()
{
	require_once("connectioni.php");
	
	
	
	$sql ="delete from tmptotbrandsale";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	

	$sql_brand ="select * from brand_mas";
	$result_brand =mysqli_query($GLOBALS['dbinv'],$sql_brand);
	while ($row_brand = mysqli_fetch_array($result_brand)){
		$TotGroSaleAmt = 0;
		$TotGdRetAmt = 0;
		
		if ($_GET["chkcus"] == "on") {
      		if ($_GET["cmbrep"] == "All") {
        		if ($_GET["radio2"]=="optdaily") { 
					$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and C_CODE ='".trim($_GET["txt_cuscode"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
				}	
        		if ($_GET["radio2"]=="optperiod") { 
					$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and c_code ='" . trim($_GET["txt_cuscode"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
      			}
      		}	
			
			if ($_GET["cmbrep"] != "All") {
        		if ($_GET["radio2"]=="optdaily") { 
					$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and c_code ='" . trim($_GET["txt_cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and  SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
				}	
        		
				if ($_GET["radio2"]=="optperiod") {  
					$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and c_code ='" . trim($_GET["txt_cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
				}	
      		}
		}

		if ($_GET["chkcus"]!="on") {  
      		if ($_GET["cmbrep"] == "All") {
        		if ($_GET["radio2"]=="optdaily") { 
					$sql_sale =  "select * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
				}	
        		
				if ($_GET["radio2"]=="optperiod") { 
					$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . trim($row_brand["barnd_name"]) . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
      			}
      		}
	  		
			if ($_GET["cmbrep"] != "All") {
        		if ($_GET["radio2"]=="optdaily") {
				 	$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and sal_ex='" . trim($_GET["cmbrep"]) . "' and  SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
				}	
        		
				if ($_GET["radio2"]=="optperiod") { 
					$sql_sale = "select * from s_salma where Accname != 'NON STOCK' and sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
				}	
      		}
		}
		
		$result_sale =mysqli_query($GLOBALS['dbinv'],$sql_sale);
		while ($row_sale = mysqli_fetch_array($result_sale)){
		
   			$TotGroSale = $TotGroSale + $row_sale["GRAND_TOT"];
   			$TotGroSaleAmt = $TotGroSaleAmt + ($row_sale["GRAND_TOT"] / (1 + ($row_sale["GST"] / 100)));
   
		}
		
		if ($_GET["chkcus"] == "on") {
    		
			if ($_GET["cmbrep"] == "All") {
        		if ($_GET["radio2"]="optdaily") { 
					$sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["txt_cuscode"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' AND trn_type!='ARN' AND trn_type!='INC' and trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
				}	
        	
				if ($_GET["radio2"]=="optperiod") { 
					$sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["txt_cuscode"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC'and trn_type!='REC'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
				}	
    		}
    
    		if ($_GET["cmbrep"] != "All") {
        		if ($_GET["radio2"]=="optdaily") { 
					$sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["txt_cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC' and trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
				}	
        		
				if ($_GET["radio2"]=="optperiod") { 
					$sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["txt_cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC'and trn_type!='REC'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
				}	
    		}
		}
		
		if ($_GET["chkcus"] != "on") {
    		if ($_GET["cmbrep"] == "All") {
        		if ($_GET["radio2"]=="optdaily") { 
					$sql_c_bal = "select * from c_bal where SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC' and trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
				}	
        		
				if ($_GET["radio2"]=="optperiod") { 
					$sql_c_bal = "select * from c_bal where ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC'and trn_type!='REC'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
				}	
    		}
    
    		if ($_GET["cmbrep"] != "All") {
				if ($_GET["radio2"]=="optdaily") {
				 	$sql_c_bal = "select * from c_bal where sal_ex='" . trim($_GET["cmbrep"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC' and trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
				}	
        		if ($_GET["radio2"]=="optperiod") {
					 $sql_c_bal = "select * from c_bal where sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC'and trn_type!='REC'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
				}	 
    		}
		}
    
        $result_c_bal =mysqli_query($GLOBALS['dbinv'],$sql_c_bal);
		while ($row_c_bal = mysqli_fetch_array($result_c_bal)){

            $TotGdRet = $TotGdRet + $row_c_bal["AMOUNT"];
            $TotGdRetAmt = TotGdRetAmt + ($row_c_bal["AMOUNT"] / (1 + ($row_c_bal["vatrate"] / 100)));
            
        }
        
        $nett=($TotGroSaleAmt - $TotGdRetAmt);
       	
		$sql_tmp="insert into tmptotbrandsale(brand, gross, grn, nett) values ('".trim($row_brand["barnd_name"])."', ".$TotGroSale.", ".$TotGdRet.", ".$nett.")";
        $result_tmp =mysqli_query($GLOBALS['dbinv'],$sql_tmp);
		 
		$TotGdRet = 0;
		$TotGroSale = 0;
	}
	
	if ($_GET["radio2"]=="optdaily") { 
		$rtxtdate = "Total Sales  On " .date("Y-m-d", strtotime($_GET["dtfrom"])) . "Rep   :" . $_GET["cmbrep"];
	}	
	if ($_GET["radio2"]=="optperiod") {  
		$rtxtdate = "Total Sales  From " .date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " .date("Y-m-d", strtotime($_GET["dtto"])) .  " Rep   :" . $_GET["cmbrep"];
	}
}

function item_sales()
{
	require_once("connectioni.php");
	
	
	
	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) { 
		$sql = "SELECT * from view_s_invo where     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
	}	
	
	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
		$sql = "SELECT * from view_s_invo where    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
	}	
	
	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optperiod")) {
	 	$sql = "SELECT * from view_s_invo where     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
	}	

	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"]=="optdaily")) { 
		$sql = "SELECT * from view_s_invo where    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
	}	

	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
		$sql = "SELECT * from view_s_invo where BRAND='" . $_GET["CmbBrand"] . "' and     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
	}	

	if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
		$sql = "SELECT * from view_s_invo where brand='" . $_GET["CmbBrand"] . "' and     SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
	}	

	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optperiod")) { 
		$sql = "SELECT * from view_s_invo where  brand='" . $_GET["CmbBrand"] . "' and     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
	}	

	if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"]=="optdaily")) { 
		$sql = "SELECT * from view_s_invo where   brand='" . $_GET["CmbBrand"] . "' and   SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
	}
	
	if (($_GET["radio"]=="optitem") and ($_GET["radio2"]=="optdaily")) { 
		$rtxtdate = "Item Sales Summery Report  On " . date("Y-m-d", strtotime($_GET["dtfrom"]));
	}	
	
	if (($_GET["radio"]=="optitem") and ($_GET["radio2"]=="optperiod")) { 
		$rtxtdate= "Item Sales Summery Report    From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"]));
	}	
	

}








?>



</body>
</html>
