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

if ($_GET["radio"]=="optout"){ htmlview(); }
if ($_GET["radio"]=="optpen"){ printut(); }


function htmlview(){

	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();

  	$totinv = 0;
   	$totret = 0;
   	$totpd = 0;
        
  
    $TotCrLmt=0;
   	$cat=0;
       echo "<center>"; 
   if (($_GET["cmbrep"] == "All") and ($_GET["cmbbrand1"] == "All")) { 
   		$crLmt = "select * from br_trn where cus_code='".trim($_GET["cuscode"])."'";
	}	
   
   	if (($_GET["cmbrep"] == "All") and ($_GET["cmbbrand1"] != "All")) { 
		$crLmt = "select * from br_trn where brand ='" . $_GET["cmbbrand1"] . "' and  cus_code='".trim($_GET["cuscode"])."'";
	}	
	
   	if (($_GET["cmbrep"] != "All") and ($_GET["cmbbrand1"] == "All")) { 
		$crLmt = "select * from br_trn where Rep='" . trim($_GET["cmbrep"]) . "' and  cus_code='" . trim($_GET["cuscode"]) . "'";
	}
		
   	if (($_GET["cmbrep"] != "All") and ($_GET["cmbbrand1"] != "All")) { 
		$crLmt = "select *  from br_trn where  Rep='" . trim($_GET["cmbrep"]) . "' and  brand ='" . $_GET["cmbbrand1"] . "' and  cus_code='" . trim($_GET["cuscode"]) . "'";
	}
	
	$mcount=0;
	$result_crLmt =$db->RunQuery($crLmt);
	while($row_crLmt = mysql_fetch_array($result_crLmt)){	
		$mcount=$mcount+1;
		$credit_lim=$row_crLmt["credit_lim"];
		$tmpcat=$row_crLmt["CAT"];
	}
			
   	if ($mcount == 1) {
      	$limit = $credit_lim;
      	if (is_null($row_crLmt["CAT"])==false) { $cat = $tmpcat; }
   	} else {
      	$result_crLmt =$db->RunQuery($crLmt);
		while($row_crLmt = mysql_fetch_array($result_crLmt)){	
         	if (trim($row_crLmt["CAT"]) == "C") { $limit = $limit + $row_crLmt["credit_lim"]; }
			if (trim($row_crLmt["CAT"]) == "B") { $limit = $limit + $row_crLmt["credit_lim"]* 2.5; }
			if (trim($row_crLmt["CAT"]) == "A") { $limit = $limit + $row_crLmt["credit_lim"]* 2.5; }
         
         	$cat = "CC";
        }
   	}
        

    if ($_GET["cmbbrand1"] != "All") {
       $stringhesd = $_GET["cuscode"] . "  " . $_GET["cusname"] . "  Outsanding Statement Rep." . " " . $_GET["cmbrep"] . "   " . $_GET["cmbbrand1"];
    } else {
       $stringhesd = $_GET["cuscode"] . "  " . $_GET["cusname"] . "  Outsanding Statement Rep." . " " . $_GET["cmbrep"];
    }

		$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$stringhesd."</center><br>";
		
		if (($_GET["cmbbrand1"] != "All") and ($_GET["cmbrep"] != "All")) {
      		echo "Credit Limit : ".number_format($limit, 2, ".", ",")."   Category  : ".$cat."</br>";
   		} else {
      		echo "Credit Limit : ".number_format($limit, 2, ".", ","). "   Category  : ".$cat. "</br>";
   		}
		
		//============================================Invoice==========================================
		echo "<b>Outstanding Invoice</b>";
   
   echo  "<center><table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
   echo  "<tr align=center bgcolor=#00aaaa>";
   echo  "<td><b>Invoice no</b></td>";
   echo  "<td><b>Date</b></td>";
   echo  "<td><b>Del.Date</b></td>";
   echo  "<td><b>Amount </b></td>";
   echo  "<td><b>Paid</b></td>";
   echo  "<td><b>Balance</b></td>";
   echo  "<td><b>Days</b></td>";
   echo  "<td><b>Del.Days</b></td>";
   echo  "</tr>";
   
   
    if (($_GET["cmbbrand1"] == "All") and ($_GET["cmbrep"] == "All")) { 
		$strsql = "Select * from s_salma where C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 order by SDATE ";
	}	
	
    if (($_GET["cmbbrand1"] == "All") and ($_GET["cmbrep"] != "All")) { 
		$strsql = "Select * from s_salma where C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE ";
	}	
   
    if (($_GET["cmbbrand1"] != "All") and ($_GET["cmbrep"] == "All")) { 
		$strsql = "Select * from view_s_salma where class='" . trim($_GET["cmbbrand1"]) . "' and  C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 order by SDATE ";
	}	
    
	if (($_GET["cmbbrand1"] != "All") and ($_GET["cmbrep"] != "All")) { 
		$strsql = "Select * from view_s_salma where class='" . trim($_GET["cmbbrand1"]) . "' and  C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE ";
	}	
           
  
   	$result =$db->RunQuery($strsql);
	while($row = mysql_fetch_array($result)){	
	
      	if ((trim($row["red"]) == "1") or (is_null($row["REMARK"])==false)) {
         	echo "<tr><td>".trim($row["REF_NO"])."</td>";
         	echo "<td>".$row["SDATE"]."</td>";
        
		 	if ((is_null($row["deli_date"])==false) and ($row["deli_date"]!="1970-01-01")) {
            	echo "<td>".$row["deli_date"]."</td>";
         	} else {
            	echo "<td>".$row["SDATE"]. "</td>";
         	}
         	echo "<td align=right > ". number_format($row["GRAND_TOT"], 2, ".", ",")."</font></td>";
         	echo "<td align=right >" .number_format($row["TOTPAY"], 2, ".", ",")."</font></td>";
         	echo "<td align=right >" .number_format(($row["GRAND_TOT"] - $row["TOTPAY"]), 2, ".", ","). "</font></td>";
					$diff = abs(strtotime(date("Y-m-d")) - strtotime($row["SDATE"]));
					$days = floor($diff / (60*60*24));
         	echo "<td align=right >" .$days. "</td>";
			
         	if (is_null($row["deli_date"])==false) {
				$diff = abs(strtotime(date("Y-m-d")) - strtotime($row["deli_date"]));
				$days = floor($diff / (60*60*24));
					
            	echo  "<td align=right > ".$days. "</td>";
         	} else {
				$diff = abs(strtotime(date("Y-m-d")) - strtotime($row["SDATE"]));
				$days = floor($diff / (60*60*24));
            	echo "<td align=right > " . $days . "</td>";
         	}
         	$totinv = $totinv + ($row["GRAND_TOT"] - $row["TOTPAY"]);
      	} else {
         	echo "<tr><td>".trim($row["REF_NO"]) . "</td>";
         	echo "<td>" . $row["SDATE"] . "</td>";
			
         	if (is_null($row["deli_date"])==false) {
            	echo "<td>" .$row["deli_date"] . "</td>";
         	} else {
            	echo "<td>" . $row["SDATE"] . "</td>";
         	}
         	echo "<td align=right > " . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>";
         	echo "<td align=right >" . number_format($row["TOTPAY"], 2, ".", ",") . "</td>";
         	echo "<td align=right >" . number_format($row["GRAND_TOT"]-$row["TOTPAY"], 2, ".", ",") ."</td>";
			
			
         	
			if (is_null($row["deli_date"])==false) {
				$diff = abs(strtotime(date("Y-m-d")) - strtotime($row["deli_date"]));
				$days = floor($diff / (60*60*24));
         		echo "<td align=right >" . $days . "</td>";
            	echo "<td align=right >" .$days. "</font></td>";
        	} else {
				$diff = abs(strtotime(date("Y-m-d")) - strtotime($row["SDATE"]));
				$days = floor($diff / (60*60*24));
				
            	echo "<td align=right >" .$days. "</font></td>";
         	} 
         	$totinv = $totinv + ($row["GRAND_TOT"] - $row["TOTPAY"]);
      	}
      	
   	}
   

   	echo  "</table>";
   	echo "<b>Total Outstanding Invoice Balance=" .number_format($totinv, 2, ".", ","). "</b></br></br>";
	
	
	
	
 //============================================Return cheqe==========================================
   echo  "<b>Outstanding Return Cheque<b>";

   echo  "<table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
   echo "<tr align=center bgcolor=#00aaaa>";
   echo "<td><b>Cheque no</b></td>";
   echo "<td><b>Date</b></td>";
   echo "<td><b>Amount </b></td>";
   echo "<td><b>Paid</b></td>";
   echo "<td><b>Balance</b></td>";
   echo "<td><b>Days</b></td>";
   echo "</tr>";
           
        
        
   if ($_GET["cmbrep"] == "All") { 
   		$strsql = "Select * from s_cheq where CR_C_CODE='".$_GET["cuscode"]."'  and CR_CHEVAL-PAID>1 and CR_FLAG='0'  ";
	}	
   
   if ($_GET["cmbrep"] != "All") { 
   		$strsql = "Select * from s_cheq where CR_C_CODE='" . $_GET["cuscode"] . "'  and CR_CHEVAL-PAID>1 and S_REF='" . trim($_GET["cmbrep"]) . "' and CR_FLAG='0'";
	}	
   
   
   	$result =$db->RunQuery($strsql);
	while($row = mysql_fetch_array($result)){	         
   
       echo "<tr><td>".trim($row["CR_CHNO"])."</font></td>";
       echo "<td>" . $row["CR_CHDATE"] . "</font></td>";
       echo "<td align=right>" .number_format($row["CR_CHEVAL"], 2, ".", ",") . "</font></td>";
       echo "<td align=right>" .number_format($row["PAID"], 2, ".", ",") . "</td>";
       echo "<td align=right>" .number_format($row["CR_CHEVAL"]-$row["PAID"], 2, ".", ",") . "</td>";
	   
	    $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["CR_CHDATE"]));
		$days = floor($diff / (60*60*24));
				
       echo "<td>" . $days . "</font></td>";
       $totret = $totret + ($row["CR_CHEVAL"] - $row["PAID"]);
   }
   
   echo "</table>";
   echo "Total Outstanding Return Cheque Balance=" .number_format($totret, 2, ".", ","). "</br></br>";




 //============================================PD cheqe==========================================
   
	echo  "<b>Pending Cheque<b>";
	
   echo  "<table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
   echo "<tr align=center bgcolor=#00aaaa>";
   echo "<td><b>Cheque no</b></td>";
   echo "<td><b>Date</b></td>";
   echo "<td><b>Amount </b></td>";
   echo "<td><b>bank</b></td>";
   echo "<td><b>Days</b></td>";
   echo "</tr>";
     
   if ($_GET["cmbbrand1"] != "All") { 
       if ($_GET["cmbrep"] == "All") { 
	   		$sql_rst4= "SELECT * FROM s_invcheq WHERE che_date>'" . date("Y-m-d") . "' AND CUS_CODE='" . trim($_GET["cuscode"]) . "' and trn_type='REC' order by che_date ";
		}	
       if ($_GET["cmbrep"] != "All") { 
	   		$sql_rst4= "SELECT * FROM s_invcheq WHERE che_date>'" . date("Y-m-d") . "' AND CUS_CODE='" . trim($_GET["cuscode"]) . "' and trn_type='REC' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
		}	
      
        
        $result_rst4 =$db->RunQuery($sql_rst4);
		while($row_rst4 = mysql_fetch_array($result_rst4)){	      
         $OutpDAMT = 0;
             $sql_st=  "select * from s_sttr where ST_REFNO='" . trim($row_rst4["REFNO"]) . "' and ST_CHNO ='" . trim($row_rst4["cheque_no"]) . "' ";
              $result_st =$db->RunQuery($sql_st);
			  while($row_st = mysql_fetch_array($result_st)){	      
                 $sql_tmp= "select class from view_s_salma where REF_NO='" . trim($row_st["ST_INVONO"]) . "'  order by SDATE";
				 $result_tmp =$db->RunQuery($sql_tmp);
				 if($row_tmp = mysql_fetch_array($result_tmp)){	      
                     if (trim($row_tmp["class"]) == trim($_GET["cmbbrand1"])) {
                     	$OutpDAMT = $OutpDAMT + $row_st["ST_PAID"];
                     }
                 }
              } 
             
                     
             if ($OutpDAMT > 0) {

               $mtype = "&nbsp;&nbsp;&nbsp;";
               if (is_null($row_rst4["trn_type"])==false) {
                  $mtype = trim($row_rst4["trn_type"]);
               }
               if ($mtype == "RET") {
                  echo "<tr><td> <font face='Arial' color='Red'> " . trim($row_rst4["cheque_no"]) . " - " . $mtype . "</font></td>";
                  echo "<td> <font face='Arial' color='Red'>" . $row_rst4["che_date"] . "</font></td>";
                  echo "<td align=right> <font face='Arial' color='Red'>" . number_format($OutpDAMT, 2, ".", ",") . "</td>";
                  if (is_null($row_rst4["bank"])==false) {
                     echo "<td><font face='Arial' color='Red'>" . trim($row_rst4["bank"]) . "</font></td>";
                  } else {
                     echo  "<td></td>";
                  }
				  
				  $date1 = date("Y-m-d");
				  $date2 = $row_rst4["che_date"];
				  $diff = abs(strtotime($date2) - strtotime($date1));
				  $days = floor($diff / (60*60*24));
			
                  echo "<td><font face='Arial' color='Red'>" . $days . "</font></td>";
               } else {
                  echo "<tr><td><font face='Arial'  > " . trim($row_rst4["cheque_no"]) . " - " . $mtype . "</font></td>";
                  echo "<td><font face='Arial'>" . $row_rst4["che_date"] . "</font></td>";
                  echo "<td align=right>" . number_format($OutpDAMT, 2, ".", ",") . "</td>";
                  if (is_null($row_rst4["bank"])==false) {
                     echo "<td><font face='Arial'>" . trim($row_rst4["bank"]) . "</font></td>";
                  } else {

                     print "<td></td>";
                  }
				  $date1 = date("Y-m-d");
				  $date2 = $row_rst4["che_date"];
				  $diff = abs(strtotime($date2) - strtotime($date1));
				  $days = floor($diff / (60*60*24));
                  echo "<td><font face='Arial'>" . $days . "</font></td>";
               }
                
                $totpd = $totpd + $OutpDAMT;
                 
                        

             }
        }
                     
                        echo "</table>";
                        echo "Cheque For Pending Cheques=" + number_format($totpd, 2, ".", ","). "</br></br>";
                        //============================================PD cheqe==========================================
                         echo "<b>PD For Returns</b>";
                     
                        echo "<table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
                        echo "<tr align=center bgcolor=#00aaaa>";
                        echo "<td><b>Cheque NNo</b></td>";
                        echo "<td><b>Date</b></td>";
                        echo "<td><b>Amount </b></td>";
                        echo "<td><b>bank</b></td>";
                        echo "<td><b>Days</b></td>";
                        echo "</tr>";
                       
                        
                     if ($_GET["cmbrep"] == "All") { 
					 	$sql_rst4= "SELECT * FROM s_invcheq WHERE trn_type='RET' and che_date>'" . date("Y-m-d") . "' AND cus_code='" . trim($_GET["cuscode"]) . "' and trn_type='RET'  ";
					  }	
                      if ($_GET["cmbrep"] != "All") { 
					  	$sql_rst4= "SELECT * FROM s_invcheq WHERE trn_type='RET' and che_date>'" . date("Y-m-d") . "' AND cus_code='" . trim($_GET["cuscode"]) . "' and trn_type='RET' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
					  }	
                      $result_rst4 =$db->RunQuery($sql_rst4);
					  while($row_rst4 = mysql_fetch_array($result_rst4)){	      
                        $OutpDAMT = 0;
                        $sql_st="select * from ch_sttr where cus_code='" . $row_rst4["cus_code"] . "' and ST_REFNO='" . trim($row_rst4["REFNO"]) . "' and ST_CHNO='" . trim($row_rst4["cheque_no"]) . "'";
                        //xx = st.RecordCount
                        $result_st =$db->RunQuery($sql_st);
			  			while($row_st = mysql_fetch_array($result_st)){	      
                           $sql_tmpRet= "select * from ret_chq_history where Ref_no='" . trim($row_st["ST_INVONO"]) . "' ";
                           //xx = tmpRet.RecordCount
                           $result_tmpRet =$db->RunQuery($sql_tmpRet);
			  			   while($row_tmpRet = mysql_fetch_array($result_tmpRet)){	 
                              $sql_tmp= "select class from view_s_salma where REF_NO='" . trim($row_tmpRet["Inv_no"]) . "' ";
                              //yy = tmp.RecordCount
                               $result_tmp =$db->RunQuery($sql_tmp);
			  			       if($row_tmp = mysql_fetch_array($result_tmp)){	 
                                 if (trim($row_tmp["class"]) == trim($_GET["cmbbrand1"])) {
                                 	$OutpDAMT = $row_rst4["che_amount"];
                                 }
                               }
                           }
                        }
                        
                        
                          if ($OutpDAMT > 0) {
                             $mtype = "&nbsp;&nbsp;&nbsp;";
                             if (is_null($row_rst4["trn_type"])==false) {
                                $mtype = trim($row_rst4["trn_type"]);
                             }
                              
                              if ($mtype == "RET") {
                                 echo "<tr><td><font face='Arial' color='Red'> " + trim($row_rst4["cheque_no"]) . "-" . $mtype . "</td>";
                                 
                                 echo "<td><font face='Arial' color='Red'> " . $row_rst4["che_date"] . "</td>";
                                 echo "<td align=right><font face='Arial' color='Red'>" . number_format($OutpDAMT, 2, ".", ",") . "</td>";
                                 if (is_null($row_rst4["bank"])==false) {
                                    echo "<td><font face='Arial' color='Red'>" . trim($row_rst4["bank"]) . "</td>";
                                 } else {
                                    echo "<td></td><font face='Arial' color='Red'>";
                                 }
								 
								$date1 = date("Y-m-d");
				  				$date2 = $row_rst4["che_date"];
				  				$diff = abs(strtotime($date2) - strtotime($date1));
				  				$days = floor($diff / (60*60*24));
				  
                                 echo "<td><font face='Arial'color='Red'>" . $days . "</td>";
                              
                              } else {
                                 echo "<tr><td>  " + trim($row_rst4["cheque_no"]) . "-" . $mtype . "</td>";
                                 
                                 echo "<td>  " . $row_rst4["che_date"] . "</td>";
                                 echo "<td align=right> " . number_format($OutpDAMT, 2, ".", ",") . "</td>";
                                 if (is_null($row_rst4["bank"])==false) {
                                    echo "<td> " . trim($row_rst4["bank"]) . "</td>";
                                 } else {
                                    echo "<td></td> ";
                                 }
								 $date1 = date("Y-m-d");
				  				$date2 = $row_rst4["che_date"];
				  				$diff = abs(strtotime($date2) - strtotime($date1));
				  				$days = floor($diff / (60*60*24));
								
                                 echo "<td> " . $days . "</td>";
                              
                              }
                              
                              $totpd = $totpd + $OutpDAMT;
                               
                           }
                 
                          
                        }
                        
                
          }
          if ($_GET["cmbbrand1"] == "All") {
                       
            if ($_GET["cmbrep"] == "All") { 
				$strsql = "Select * from s_invcheq where cus_code='" . $_GET["cuscode"] . "'  and che_date>'" . date("Y-m-d") . "' order by che_date ";
				//echo $strsql;
			}	
            if ($_GET["cmbrep"] != "All") { 
				$strsql = "Select * from s_invcheq where cus_code='" . $_GET["cuscode"] . "'  and che_date>'" . date("Y-m-d") . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' order by che_date";
			}	

			$result_rst2 =$db->RunQuery($strsql);
			while($row_rst2 = mysql_fetch_array($result_rst2)){	   
               $mtype = "&nbsp;&nbsp;&nbsp;";
               if (is_null($row_rst2["trn_type"])==false) {
                  $mtype = trim($row_rst2["trn_type"]);
               }
             
                if ($mtype == "RET") {
                  echo "<tr><td><font face='Arial' color='Red'>" . trim($row_rst2["cheque_no"]) . "-" . $mtype . "</font></td>";
                  echo  "<td><font face='Arial' color='Red'>" . $row_rst2["che_date"] . "</font></td>";
                  echo "<td align=right><color='Red' >" . number_format($row_rst2["che_amount"], 2, ".", ",") . "</font></td>";
                  if (is_null($row_rst2["bank"])==false) {
                     echo "<td> <font face='Arial' color='Red'> " . trim($row_rst2["bank"]) . "</td>";
                  }else{
                     echo "<td></td>";
                  }
				   				$date1 = date("Y-m-d");
				  				$date2 = $row_rst2["che_date"];
				  				$diff = abs(strtotime($date2) - strtotime($date1));
				  				$days = floor($diff / (60*60*24));
                  echo "<td><font face='Arial' color='Red'>" . $days . "</font></td>";
               } else {
                  echo "<tr><td><font face='Arial'>" . trim($row_rst2["cheque_no"]) . "-" . $mtype . "</font></td>";
                  echo "<td><font face='Arial'>" . $row_rst2["che_date"] . "</font></td>";
                  echo "<td align=right>" . number_format($row_rst2["che_amount"], 2, ".", ",") . "</font></td>";
                  if (is_null($row_rst2["bank"])==false) {
                     echo "<td>" . trim($row_rst2["bank"]) . "</td>";
                  } else {
                     echo "<td></td>";
                  }
				  				$date1 = date("Y-m-d");
				  				$date2 = $row_rst2["che_date"];
				  				$diff = abs(strtotime($date2) - strtotime($date1));
				  				$days = floor($diff / (60*60*24));
								
                  echo "<td align=right><font face='Arial'>" . $days . "</font></td>";
               }
               $totpd = $totpd + $row_rst2["che_amount"];
               
            }
            
          }
        
          echo "</table>";
        
          echo "Total Pending  Cheque Amount=" . number_format($totpd, 2, ".", ",") . "</br></br>";
          echo "Total Outsanding Amount=" . number_format($totinv + $totpd + $totret, 2, ".", ",") . "</br></br>";
         
          echo "</body>";
          echo "</html>";

}


function printut()
{

require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	
	if (($_GET["cmbbrand1"] == "All") and ($_GET["cmbGRNtype"] == "All") and (trim($_GET["cuscode"]) == "") and ($_GET["cmbrep"] == "All")){  		$sql = "select * from view_c_bal_s_deftrn where  BALANCE>0 AND CANCELL = '0' and trn_type<>'ARN'  and sdate>'2011-01-01' order by sdate ";
	}
	if (($_GET["cmbbrand1"] == "All") and ($_GET["cmbGRNtype"] == "All") and (trim($_GET["cuscode"]) != "") and ($_GET["cmbrep"] == "All")) { 
		$sql = "select * from view_c_bal_s_deftrn where CUSCODE='" . trim($_GET["cuscode"]) . "' AND CANCELL = '0' and BALANCE>0 and trn_type<>'ARN'  and sdate>'2011-01-01' order by sdate ";
	}	

	if (($_GET["cmbbrand1"] == "All") and ($_GET["cmbGRNtype"] == "All") and ($_GET["cmbrep"] != "All") and (trim($_GET["cuscode"]) == "")) { 
		$sql = "select * from view_c_bal_s_deftrn  where  sal_ex='" .  trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2011-01-01'";
	}	
	if (($_GET["cmbbrand1"] == "All") and ($_GET["cmbGRNtype"] == "All") and ($_GET["cmbrep"] != "All") and (trim($_GET["cuscode"]) != "")) { 
		$sql = "select * from view_c_bal_s_deftrn  where CUSCODE='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2011-01-01'";
	}	
 
	if (($_GET["cmbbrand1"] == "All") and ($_GET["cmbGRNtype"] != "All") and (trim($_GET["cuscode"]) == "") and ($_GET["cmbrep"] == "All")) { 
		$sql = "select * from view_c_bal_s_deftrn where   trn_type='" . $_GET["cmbGRNtype"] . "'and BALANCE>0 AND CANCELL = '0' and trn_type<>'ARN'  and sdate>'2011-01-01' order by sdate ";
	}	
	if (($_GET["cmbbrand1"] == "All") and ($_GET["cmbGRNtype"] != "All") and (trim($_GET["cuscode"]) != "") and ($_GET["cmbrep"] == "All")) { 
		$sql = "select * from view_c_bal_s_deftrn where  trn_type='" . $_GET["cmbGRNtype"] . "'and CUSCODE='" . trim($_GET["cuscode"]) . "' AND CANCELL = '0' and BALANCE>0 and trn_type<>'ARN'  and sdate>'2011-01-01' order by sdate ";
	}	

	if (($_GET["cmbbrand1"] == "All") and ($_GET["cmbGRNtype"] != "All") and ($_GET["cmbrep"] != "All") and (trim($_GET["cuscode"]) == "")) { 
		$sql = "select * from view_c_bal_s_deftrn  where  trn_type='" . $_GET["cmbGRNtype"] . "'and  sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2011-01-01'";
	}	
	if (($_GET["cmbbrand1"] == "All") and ($_GET["cmbGRNtype"] != "All") and ($_GET["cmbrep"] != "All") and (trim($_GET["cuscode"]) != "")) { 
		$sql = "select * from view_c_bal_s_deftrn  where  trn_type='" . $_GET["cmbGRNtype"] . "'and CUSCODE='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2011-01-01'";
	}	
 
	if (($_GET["cmbbrand1"] != "All") and ($_GET["cmbGRNtype"] == "All") and (trim($_GET["cuscode"]) == "") and ($_GET["cmbrep"] == "All")) { 
		$sql = "select * from view_c_bal_s_deftrn where  cat1='" . trim($_GET["cmbbrand1"]) . "' and  BALANCE>0 AND CANCELL = '0' and trn_type<>'ARN'  and sdate>'2011-01-01' order by sdate ";
	}	
	if (($_GET["cmbbrand1"] != "All") and ($_GET["cmbGRNtype"] == "All") and (trim($_GET["cuscode"]) != "") and ($_GET["cmbrep"] == "All")) { 
		$sql = "select * from view_c_bal_s_deftrn where   cat1='" . trim($_GET["cmbbrand1"]) . "' and CUSCODE='" . trim($_GET["cuscode"]) . "' AND CANCELL = '0' and BALANCE>0 and trn_type<>'ARN'  and sdate>'2011-01-01' order by sdate ";
	}	

	if (($_GET["cmbbrand1"] != "All") and ($_GET["cmbGRNtype"] == "All") and ($_GET["cmbrep"] != "All") and (trim($_GET["cuscode"]) == "")) { 
		$sql = "select * from view_c_bal_s_deftrn  where   cat1='" . trim($_GET["cmbbrand1"]) . "' and  sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2011-01-01'";
	}	
	if (($_GET["cmbbrand1"] != "All") and ($_GET["cmbGRNtype"] == "All") and ($_GET["cmbrep"] != "All") and (trim($_GET["cuscode"]) != "")) { 
		$sql = "select * from view_c_bal_s_deftrn  where  cat1='" . trim($_GET["cmbbrand1"]) . "' and  CUSCODE='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "'AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2011-01-01'";
	}	
 
	if (($_GET["cmbbrand1"] != "All") and ($_GET["cmbGRNtype"] != "All") and (trim($_GET["cuscode"]) == "") and ($_GET["cmbrep"] == "All")) { 
		$sql = "select * from view_c_bal_s_deftrn where   cat1='" . trim($_GET["cmbbrand1"]) . "' and   trn_type='" . $_GET["cmbGRNtype"] . "'and BALANCE>0 AND CANCELL = '0' and trn_type<>'ARN'  and sdate>'2011-01-01' order by sdate ";
	}	
	if (($_GET["cmbbrand1"] != "All") and ($_GET["cmbGRNtype"] != "All") and (trim($_GET["cuscode"]) != "") and ($_GET["cmbrep"] == "All")) { 
		$sql = "select * from view_c_bal_s_deftrn where    cat1='" . trim($_GET["cmbbrand1"]) . "' and trn_type='" . $_GET["cmbGRNtype"] . "'and CUSCODE='" . trim($_GET["cuscode"]) . "' AND CANCELL = '0' and BALANCE>0 and trn_type<>'ARN'  and sdate>'2011-01-01' order by sdate ";
	}	

	if (($_GET["cmbbrand1"] != "All") and ($_GET["cmbGRNtype"] != "All") and ($_GET["cmbrep"] != "All") and (trim($_GET["cuscode"]) == "")) { 
		$sql = "select * from view_c_bal_s_deftrn  where   cat1='" . trim($_GET["cmbbrand1"]) . "' and  trn_type='" . $_GET["cmbGRNtype"] . "'and  sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2011-01-01'";
	}	
	if (($_GET["cmbbrand1"] != "All") and ($_GET["cmbGRNtype"] != "All") and ($_GET["cmbrep"] != "All") and (trim($_GET["cuscode"]) != "")) { 
		$sql = "select * from view_c_bal_s_deftrn  where   cat1='" . trim($_GET["cmbbrand1"]) . "' and  trn_type='" . $_GET["cmbGRNtype"] . "'and CUSCODE='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2011-01-01'";
	}	
//echo $sql;

if ($_GET["cmbbrand1"] != "All") {
       $stringhesd = $_GET["cuscode"] . "  " . $_GET["cusname"] . "  Outsanding Statement Rep." . " " . $_GET["cmbrep"] . "   " . $_GET["cmbbrand1"];
    } else {
       $stringhesd = $_GET["cuscode"] . "  " . $_GET["cusname"] . "  Outsanding Statement Rep." . " " . $_GET["cmbrep"];
    }

		$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>Unsettle GRN / Credit Note / Over Payments</center><br>";
		
		echo "<center>Customer Code : ".$_GET["cuscode"]."</br>";
		echo "Customer Name : ".$_GET["cusname"]."</br>";
		

		echo "<table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
                        echo "<tr align=center bgcolor=#00aaaa>";
                        echo "<td><b>Ref No</b></td>";
                        echo "<td><b>Customer</b></td>";
                        echo "<td><b>Rep</b></td>";
                        echo "<td><b>Date</b></td>";
                        echo "<td><b>Brand</b></td>";
						echo "<td><b>Amount</b></td>";
						echo "<td><b>Balance</b></td>";
                        echo "</tr>";
		
		$AMOUNT=0;
		$BALANCE=0;	
						
	$result =$db->RunQuery($sql);
	while($row = mysql_fetch_array($result)){	 
		 echo "<tr >";
         echo "<td>".$row["REFNO"]."</td>";
         echo "<td>".$row["CUSCODE"]."</td>";
		 echo "<td>".$row["sal_ex"]."</td>";
		 echo "<td>".$row["sdate"]."</td>";
		 echo "<td>".$row["brand"]."</td>";
		 echo "<td>".number_format($row["AMOUNT"], 2, ".", ",")."</td>";
		 echo "<td>".number_format($row["BALANCE"], 2, ".", ",")."</td><tr>";
		 
		 $AMOUNT=$AMOUNT+$row["AMOUNT"];
		 $BALANCE=$BALANCE+$row["BALANCE"];
	}
	 echo "<tr >";
     echo "<td colspan=5>&nbsp;</td>";
	  echo "<td><b>".number_format($AMOUNT, 2, ".", ",")."</b></td>";
	   echo "<td><b>".number_format($BALANCE, 2, ".", ",")."</b></td>";
	   echo "</table>";
}
?>



</body>
</html>
