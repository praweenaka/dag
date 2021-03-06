<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Monthly Sales Report</title>

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

    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
	if ($_GET["radio"]== "op_traget") {
    	tragetbrand();
	} else {
    	othersales();
	}

function tragetbrand()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	
	//$sql="Update vendor set PEN0 = '0'";
	//$result =$db->RunQuery($sql);
	
	$sql="delete from monsales";
	$result =$db->RunQuery($sql);
	//$row = mysql_fetch_array($result);

	
	$month1=date("m", strtotime($_GET["month1"]));
		$month2=date("m", strtotime($_GET["month2"]));
		$month3=date("m", strtotime($_GET["month3"]));
	
		$month1_y=date("Y", strtotime($_GET["month1"]));
		$month2_y=date("Y", strtotime($_GET["month2"]));
		$month3_y=date("Y", strtotime($_GET["month3"]));

	$rep = trim($_GET["cmbrep"]);


if ($_GET["radio"]!="Option2") {
    if ($_GET["radio"]="op_traget") {
        if ($_GET["cmbrep"] == "All") {
            if ($_GET["ChKCUS"] != "on") { 
				//$sql_RSCUS = "SELECT *FROM view_brtrn_vendor where PEN0  !='1' ORDER BY cus_code";
				$sql_RSCUS = "SELECT distinct C_CODE as cus_code FROM s_led where ((month(SDATE)=" . $month1 . " and year(SDATE)=" . $month1_y . ") or (month(SDATE)=" . $month2 . " and year(SDATE)=" . $month2_y . ")or (month(SDATE)=" . $month3 . " and year(SDATE)=" . $month3_y . ")) and (FLAG='INV' or FLAG='GRN') ORDER BY C_CODE"; 
			}	
            if ($_GET["ChKCUS"] == "on") {   
				//$sql_RSCUS = "SELECT *FROM view_brtrn_vendor WHERE PEN0  !='1' and cus_code='" . trim($_GET["txt_cuscode"]) . "'";
				$sql_RSCUS = "SELECT distinct C_CODE as cus_code FROM s_led WHERE  C_CODE='" . trim($_GET["txt_cuscode"]) . "' and ((month(SDATE)=" . $month1 . " and year(SDATE)=" . $month1_y . ") or (month(SDATE)=" . $month2 . " and year(SDATE)=" . $month2_y . ")or (month(SDATE)=" . $month3 . " and year(SDATE)=" . $month3_y . ")) and (FLAG='INV' or FLAG='GRN')";
			}	
            
        } else {
            if ($_GET["ChKCUS"] != "on") {
				if ($_GET["cmbrep"] == "All") {  
					//$sql_RSCUS = "SELECT * FROM view_brtrn_vendor where PEN0 !='1' ORDER BY cus_code";
					$sql_RSCUS = "SELECT distinct C_CODE as cus_code FROM s_led where ((month(SDATE)=" . $month1 . " and year(SDATE)=" . $month1_y . ") or (month(SDATE)=" . $month2 . " and year(SDATE)=" . $month2_y . ")or (month(SDATE)=" . $month3 . " and year(SDATE)=" . $month3_y . ")) and (FLAG='INV' or FLAG='GRN') ORDER BY C_CODE"; 
				} else {
					//$sql_RSCUS = "SELECT * FROM view_brtrn_vendor where Rep = '" . $rep . "' and PEN0 !='1' ORDER BY cus_code";
					$sql_RSCUS = "SELECT distinct C_CODE as cus_code FROM s_led where ((month(SDATE)=" . $month1 . " and year(SDATE)=" . $month1_y . ") or (month(SDATE)=" . $month2 . " and year(SDATE)=" . $month2_y . ")or (month(SDATE)=" . $month3 . " and year(SDATE)=" . $month3_y . ")) and (FLAG='INV' or FLAG='GRN') ORDER BY C_CODE"; 
				}	
			}	
            if ($_GET["ChKCUS"] == "on") {  
				//$sql_RSCUS = "SELECT * FROM view_brtrn_vendor WHERE PEN0  !='1' and  cus_code='" . trim($_GET["cuscode"]) . "' and rep = '" . $rep . "'  ";
				$sql_RSCUS = "SELECT distinct C_CODE as cus_code FROM s_led WHERE  C_CODE='" . trim($_GET["txt_cuscode"]) . "' and ((month(SDATE)=" . $month1 . " and year(SDATE)=" . $month1_y . ") or (month(SDATE)=" . $month2 . " and year(SDATE)=" . $month2_y . ")or (month(SDATE)=" . $month3 . " and year(SDATE)=" . $month3_y . ")) and (FLAG='INV' or FLAG='GRN')  order by C_CODE";
            }
        }
    }
} else {

	$date=$_GET["DTPicker1"];
	$date90=date('Y-m-d', strtotime($date. ' - 90 days'));
    if ($_GET["ChKCUS"] != "on") {  
   		
		//$sql_RSCUS = "SELECT cus_code FROM view_brtrn_vendor where PEN0  !='1' and  OPDATE <=  '" . $date90 . "' and  credit_lim != '0' and Rep='" . trim($rep) . "'  group BY cus_code";
		
		$sql_RSCUS = "SELECT distinct C_CODE as cus_code FROM s_led WHERE  ((month(SDATE)=" . $month1 . " and year(SDATE)=" . $month1_y . ") or (month(SDATE)=" . $month2 . " and year(SDATE)=" . $month2_y . ")or (month(SDATE)=" . $month3 . " and year(SDATE)=" . $month3_y . ")) and (FLAG='INV' or FLAG='GRN') order by C_CODE";
	}
		
   	if ($_GET["ChKCUS"] == "on") { 
		//$sql_RSCUS = "SELECT cus_code FROM view_brtrn_vendor  WHERE PEN0  !='1' and  OPDATE <= '" . $date90 . "' and Rep='" . trim($rep) . "' and cus_code='" . trim($_GET["cuscode"]) . "'   group BY cus_code";
		
		$sql_RSCUS = "SELECT distinct C_CODE as cus_code FROM s_led WHERE  C_CODE='" . trim($_GET["txt_cuscode"]) . "' and ((month(SDATE)=" . $month1 . " and year(SDATE)=" . $month1_y . ") or (month(SDATE)=" . $month2 . " and year(SDATE)=" . $month2_y . ")or (month(SDATE)=" . $month3 . " and year(SDATE)=" . $month3_y . ")) and (FLAG='INV' or FLAG='GRN')";
	}

}
//echo $sql_RSCUS;
$result_RSCUS =$db->RunQuery($sql_RSCUS);
while($row_RSCUS = mysql_fetch_array($result_RSCUS)){

	
	$Cus_Code="";
	$cus_name="";
	$row_limit=0;
	$row_cat="";
	$row_brand="";
	$month1=0;
	$month2=0;
	$month3=0;
	$C_TYPE="";
    $TOTSALE = 0;
    if ($m_cus == $row_RSCUS["cus_code"]) {
        //RSCUS.MoveNext
    } else {
        if ($_GET["radio"]!="Option2") {
            if ($_GET["radio"]=="op_traget") {
                $m_cus = $row_RSCUS["cus_code"];
            } else {
                $m_cus = $row_RSCUS["cus_code"];
            }
        } else {
            $m_cus = $row_RSCUS["cus_code"];
        }
        if (date("Y", strtotime($_GET["month1"])) >= "2014") {
            $sql_itclas = "select * from brand_mas where b60 = '1' ";
        } else {
            $sql_itclas =  "select * from brand_mas where delinrate = '2.5' ";
        }
		//echo $sql_itclas."</br>";
        
		$result_itclas =$db->RunQuery($sql_itclas);
		while($row_itclas = mysql_fetch_array($result_itclas)){
            $mbrand = $row_itclas["barnd_name"];
            
            if ($_GET["cmbrep"] == "All") {
  
                    $sql_strsql = "select *from s_salma where Accname != 'NON STOCK' and C_CODE='" . $m_cus . "'and brand='" . $mbrand . "' and CANCELL='0' and TOTPAY1 = '1'";
                    if ($_GET["chkdef"] == "on") { 
						$sql_grnsql = "select * from c_bal where CUSCODE='" . $m_cus . "' and  trn_type!='INC'and trn_type!='REC' and trn_type!='PAY' and trn_type!='ARN' and brand='" . $mbrand . "' and flag1 != '1'";
					}	
                    if ($_GET["chkdef"] != "on") { 
						$sql_grnsql = "select * from c_bal where CUSCODE='" . $m_cus . "' and  trn_type!='INC'and  trn_type!='DGRN' and trn_type!='REC' and trn_type!='PAY' and trn_type!='ARN' and brand='" . $mbrand . "' and flag1 != '1'";
  					}
					
            } else {
   
                    $sql_strsql = "select *from s_salma where Accname != 'NON STOCK' and C_CODE='" . $m_cus . "'and brand='" . $mbrand . "'and SAL_EX='" . $rep . "' and CANCELL='0' and TOTPAY1 = '1'";
					
                     if ($_GET["chkdef"] == "on") { 
					 	$sql_grnsql = "select * from c_bal where CUSCODE='" . $m_cus . "' and  trn_type!='INC'and trn_type!='REC' and trn_type!='PAY' and trn_type!='ARN' and  brand='" . $mbrand . "' and SAL_EX='" . $rep . "' and flag1 != '1'";
					}	
                    if ($_GET["chkdef"] == "on") { 
						$sql_grnsql = "select * from c_bal where CUSCODE='" . $m_cus . "' and  trn_type!='INC' and trn_type!='REC' and trn_type!='PAY' and trn_type!='DGRN' and trn_type!='ARN' and  brand='" . $mbrand . "' and SAL_EX='" . $rep . "' and flag1 != '1'";
   					}
   
            
            }
          // echo $sql_strsql."</br>";
            $result_strsql =$db->RunQuery($sql_strsql);
			while($row_RSINVO = mysql_fetch_array($result_strsql)){
          		
				  if ((date("m", strtotime($row_RSINVO["SDATE"])) == date("m", strtotime($_GET["month1"]))) and (date("Y", strtotime($row_RSINVO["SDATE"])) == date("Y", strtotime($_GET["month1"])))) 
				  {
                    
                     $m1 = $m1 + $row_RSINVO["GRAND_TOT"] / (1 + $row_RSINVO["GST"] / 100);
                  }
				  if ((date("m", strtotime($row_RSINVO["SDATE"])) == date("m", strtotime($_GET["month2"]))) and (date("Y", strtotime($row_RSINVO["SDATE"])) == date("Y", strtotime($_GET["month2"])))) {
                                     
                     $m2 = $m2 + $row_RSINVO["GRAND_TOT"] / (1 + $row_RSINVO["GST"] / 100);
                     
                  }
				  if ((date("m", strtotime($row_RSINVO["SDATE"])) == date("m", strtotime($_GET["month3"]))) and (date("Y", strtotime($row_RSINVO["SDATE"])) == date("Y", strtotime($_GET["month3"])))){ 
                                       
                     $m3 = $m3 + $row_RSINVO["GRAND_TOT"] / (1 + $row_RSINVO["GST"] / 100);
                  }
                 
            }
         	//echo $sql_grnsql."</br>";
			$result_grnsql =$db->RunQuery($sql_grnsql);
			while($row_grn = mysql_fetch_array($result_grnsql)){
			
                $sql_rs_crnma = "Select INVOICENO from s_crnma where REF_NO = '" . trim($row_grn["REFNO"]) . "'";
				//echo $sql_rs_crnma;
				$result_rs_crnma =$db->RunQuery($sql_rs_crnma);
				if($row_rs_crnma = mysql_fetch_array($result_rs_crnma)){
               
                    if ($row_rs_crnma["INVOICENO"] != "") {
						$sql_rs_sal = "Select TOTPAY1 from s_salma where REF_NO = '" . $row_rs_crnma["INVOICENO"] . "'";
						$result_rs_sal =$db->RunQuery($sql_rs_sal);
						if($row_rs_sal = mysql_fetch_array($result_rs_sal)){
                            if ($row_rs_sal["TOTPAY1"] == "1") {
                                if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["month1"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["month1"])))) {
                                   
                                   $G1 = $G1 + $row_grn["AMOUNT"] / (1 + $row_grn["vatrate"] / 100);
                                }
								if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["month2"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["month2"])))) {
                                                                  
                                  $G2 = $G2 + $row_grn["AMOUNT"] / (1 + $row_grn["vatrate"] / 100);
                                }
								if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["month3"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["month3"])))) {
                                                                  
                                  $G3 = $G3 + $row_grn["AMOUNT"] / (1 + $row_grn["vatrate"] / 100);
                                }
                            }
                        } else {
							if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["month1"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["month1"])))) {
                                $G1 = $G1 + $row_grn["AMOUNT"] / (1 + $row_grn["vatrate"] / 100);                           
                               
                            }
							if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["month2"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["month2"])))) {
                                                          
                              $G2 = $G2 + $row_grn["AMOUNT"] / (1 + $row_grn["vatrate"] / 100);
                            }
                            if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["month3"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["month3"])))) {
                             
                              $G3 = $G3 + $row_grn["AMOUNT"] / (1 + $row_grn["vatrate"] / 100);
                            }
                        }
                        
                    } else {
						if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["month1"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["month1"])))) {
                            $G1 = $G1 + $row_grn["AMOUNT"] / (1 + $row_grn["vatrate"] / 100);                        
                        }
						
                        if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["month2"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["month2"])))) {
                          
                          $G2 = $G2 + $row_grn["AMOUNT"] / (1 + $row_grn["vatrate"] / 100);
                        }
                        if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["month3"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["month3"])))) {
                          
                          $G3 = $G3 + $row_grn["AMOUNT"] / (1 + $row_grn["vatrate"] / 100);
                        }
                    }
                } else {
					if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["month1"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["month1"])))) {
                       $G1 = $G1 + $row_grn["AMOUNT"] / (1 + $row_grn["vatrate"] / 100);                       
                       
                    }
                    if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["month2"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["month2"])))) {
                      
                      $G2 = $G2 + $row_grn["AMOUNT"] / (1 + $row_grn["vatrate"] / 100);
                    }
                    if ((date("m", strtotime($row_grn["SDATE"])) == date("m", strtotime($_GET["month3"]))) and (date("Y", strtotime($row_grn["SDATE"])) == date("Y", strtotime($_GET["month3"])))) {
                     
                      $G3 = $G3 + $row_grn["AMOUNT"] / (1 + $row_grn["vatrate"] / 100);
                    }
                }
                
            }
			
			
			
			//$sql_RSMONSALES="insert into monsales(Cus_Code, ) values ()";
           
            $Cus_Code = trim($m_cus);
            
            $sql_rsVENDOR = "SELECT *FROM vendor WHERE CODE='" . trim($m_cus) . "' ";
            $result_rsVENDOR =$db->RunQuery($sql_rsVENDOR);
			$row_rsVENDOR = mysql_fetch_array($result_rsVENDOR);
               
            
            if ($_GET["cmbrep"] == "All") { 
				
				
				
				$sql_tmpLmt = "select * from br_trn where brand='" . $row_itclas["class"] . "' and  cus_code='" . trim($m_cus) . "' ";
			}	
            if ($_GET["cmbrep"] != "All") { 
				$sql_tmpLmt = "select * from br_trn where  brand='" . $row_itclas["class"] . "' and Rep='" . $rep . "' and cus_code='" . trim($m_cus) . "' ";
            }
            $lmt = 0;
            $cat = 0;
			
			$result_tmpLmt =$db->RunQuery($sql_tmpLmt);
            
            if (mysql_num_rows($result_tmpLmt) == "1") {
				$result_tmpLmt =$db->RunQuery($sql_tmpLmt);
				$row_tmpLmt = mysql_fetch_array($result_tmpLmt);
				
                $lmt = $row_tmpLmt["credit_lim"];
              
                $cat = $row_rsVENDOR["CAT"];
            } else {
                $result_tmpLmt =$db->RunQuery($sql_tmpLmt);
				while($row_tmpLmt = mysql_fetch_array($result_tmpLmt)){
             
                	if (trim($row_tmpLmt["CAT"]) == "A") { $lmt = $lmt + $row_tmpLmt["credit_lim"] * 2.5; }
                	if (trim($row_tmpLmt["CAT"]) == "B") { $lmt = $lmt + $row_tmpLmt["credit_lim"] * 2.5; }
                	if (trim($row_tmpLmt["CAT"]) == "C") { $lmt = $lmt + $row_tmpLmt["credit_lim"]; }
                
             
                	$cat = $row_rsVENDOR["CAT"];
                
                }
                
            }
            
            $row_limit = $lmt;
            $row_cat = trim($cat);
            $row_brand = $mbrand;
            $cus_name = trim($row_rsVENDOR["NAME"]);
            
            
            
            $month1 = ($m1 - $G1);
            $month2 = ($m2 - $G2);
            $month3 = ($m3 - $G3);
            $TOTSALE = $TOTSALE + ($m1 - $G1);
            $C_TYPE = $row_rsVENDOR["cus_type"];
			
			
			if (($month1>0) or ($month2>0) or ($month3>0)){
				$sql_RSMONSALES="insert into monsales(Cus_Code, cus_name, limit1, cat, brand, month1, month2, month3, C_TYPE) values ('".$Cus_Code."', '".$cus_name."', '".$row_limit."', '".$row_cat."', '".$row_brand."', '".$month1."', '".$month2."', '".$month3."', '".$C_TYPE."' )";
			//echo $sql_RSMONSALES."</br>";
            	$result_RSMONSALES =$db->RunQuery($sql_RSMONSALES);
			// echo $mbrand."</br>";
			 $mbrand="";
            
            $m1 = 0;
            $m2 = 0;
            $m3 = 0;
            $G1 = 0;
            $G2 = 0;
            $G3 = 0;
           
        }
		
		$sql_monsales="Update monsales set target = '" . $TOTSALE . "' where Cus_Code = '" . $row_RSCUS["cus_code"] . "'";
		$result_monsales =$db->RunQuery($sql_monsales);
       
    }
}
	PrintRep1();
}

function othersales()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$sql="delete from monsales";
	$result =$db->RunQuery($sql);
	
	$sql="Update vendor set PEN0 = '0'";
	$result =$db->RunQuery($sql);
	

	if ($_GET["cmbbrand"] != "All") {
		$sql_itclas="select * from brand_mas where barnd_name='" . trim($_GET["cmbbrand"]) . "'";
		$result_itclas =$db->RunQuery($sql_itclas);
		$row_itclas = mysql_fetch_array($result_itclas);
	}
//============================================================================================

	$sql_findref = "SELECT     * From ref_history WHERE  NewRefNo = '" . trim($_GET["cmbrep"]) . "'";
	$OldRefno = "";
	$NewRefNo = "";
	$result_findref =$db->RunQuery($sql_findref);
	if ($row_findref = mysql_fetch_array($result_findref)) {
    	$OldRefno = trim($row_findref["OldRefno"]);
    	$NewRefNo = trim($row_findref["NewRefNo"]);
	}
//============================================================================================
	

	$sql_RSMONSALES="delete from monsales";

	$rep = trim($_GET["cmbrep"]);
	
		$month1=date("m", strtotime($_GET["month1"]));
		$month2=date("m", strtotime($_GET["month2"]));
		$month3=date("m", strtotime($_GET["month3"]));
	
		$month1_y=date("Y", strtotime($_GET["month1"]));
		$month2_y=date("Y", strtotime($_GET["month2"]));
		$month3_y=date("Y", strtotime($_GET["month3"]));
		
	if ($_GET["radio"]!= "Option2"){
   		if ($_GET["ChKCUS"] != "on") { 
			//$sql_RSCUS = "SELECT * FROM vendor where PEN0 != '1' ORDER BY CODE"; 
			$sql_RSCUS = "SELECT distinct C_CODE FROM s_led where ((month(SDATE)=" . $month1 . " and year(SDATE)=" . $month1_y . ") or (month(SDATE)=" . $month2 . " and year(SDATE)=" . $month2_y . ")or (month(SDATE)=" . $month3 . " and year(SDATE)=" . $month3_y . ")) and (FLAG='INV' or FLAG='GRN') ORDER BY C_CODE"; 
		}
   		if ($_GET["ChKCUS"] == "on") {
			//$sql_RSCUS = "SELECT * FROM vendor WHERE  CODE='" . trim($_GET["txt_cuscode"]) . "' and PEN0 != '1' "; 
			$sql_RSCUS = "SELECT distinct C_CODE FROM s_led WHERE  C_CODE='" . trim($_GET["txt_cuscode"]) . "' and ((month(SDATE)=" . $month1 . " and year(SDATE)=" . $month1_y . ") or (month(SDATE)=" . $month2 . " and year(SDATE)=" . $month2_y . ")or (month(SDATE)=" . $month3 . " and year(SDATE)=" . $month3_y . ")) and (FLAG='INV' or FLAG='GRN')";
		}
   
	} else {
   
   	
		$date=date("Y-m-d", strtotime($_GET["DTPicker1"]));
		$caldays=" - 90 days";
		$tmpdate=date('Y-m-d', strtotime($date.$caldays));
	
   		if ($_GET["ChKCUS"] != "on") { 
   			if (trim($rep)=="All"){
				$sql_RSCUS = "SELECT cus_code FROM view_brtrn_vendor where OPDATE <=  '" . $tmpdate . "' and  credit_lim != '0' and CAT != 'D'  group BY cus_code";
			} else {
				$sql_RSCUS = "SELECT cus_code FROM view_brtrn_vendor where OPDATE <=  '" . $tmpdate . "' and  credit_lim != '0' and Rep='" . trim($rep) . "' and CAT != 'D'  group BY cus_code";
			}
	 	}
   		if ($_GET["ChKCUS"] == "on") {
			if (trim($rep)=="All"){ 
   				$sql_RSCUS = "SELECT cus_code FROM view_brtrn_vendor  WHERE OPDATE <= '" . $tmpdate . "' and cus_code='" . trim($_GET["txt_cuscode"]) . "'   group BY cus_code"; 
			} else {
				$sql_RSCUS = "SELECT cus_code FROM view_brtrn_vendor  WHERE OPDATE <= '" . $tmpdate . "' and Rep='" . trim($rep) . "' and cus_code='" . trim($_GET["txt_cuscode"]) . "'   group BY cus_code"; 
			}	
		}
	}
	echo $sql_RSCUS;
	$result_RSCUS =$db->RunQuery($sql_RSCUS);
	while ($row_RSCUS = mysql_fetch_array($result_RSCUS)) {
   		if ($_GET["radio"]!= "Option2") {
      		$m_cus = $row_RSCUS["C_CODE"];
   		} else {
      		$m_cus = $row_RSCUS["cus_code"];
   		}
    
		$month1=date("m", strtotime($_GET["month1"]));
		$month2=date("m", strtotime($_GET["month2"]));
		$month3=date("m", strtotime($_GET["month3"]));
	
		$month1_y=date("Y", strtotime($_GET["month1"]));
		$month2_y=date("Y", strtotime($_GET["month2"]));
		$month3_y=date("Y", strtotime($_GET["month3"]));
	
    	if ($_GET["cmbrep"] == "All") {
        	if ($_GET["cmbbrand"] == "All") {
            	$sql_strsql = "select * from s_salma where Accname != 'NON STOCK' and C_CODE='" . $m_cus . "'and ((month(SDATE)=" . $month1 . " and year(SDATE)=" . $month1_y . ") or (month(SDATE)=" . $month2 . " and year(SDATE)=" . $month2_y . ")or (month(SDATE)=" . $month3 . " and year(SDATE)=" . $month3_y . ")) and CANCELL='0'";
			
            	if ($_GET["chkdef"] == "on") { 
					$sql_grnsql = "select * from c_bal where CUSCODE='" . $m_cus . "' and trn_type!='INC' and trn_type!='ARN' and trn_type!='PAY' and trn_type!='REC' and ((month(SDATE)=" . $month1 . " and year(SDATE)=" . $month1_y . ") or (month(SDATE)=" . $month2 . " and year(SDATE)=" . $month2_y . ")or (month(SDATE)=" . $month3 . " and year(SDATE)=" . $month3_y . ")) and flag1 != '1' ";
				}	
            	if ($_GET["chkdef"] != "on") { 
					$sql_grnsql = "select * from c_bal where CUSCODE='" . $m_cus . "' and trn_type!='INC' and trn_type!='ARN' and trn_type!='DGRN' and trn_type!='PAY' and trn_type!='REC' and ((month(SDATE)=" . $month1 . " and year(SDATE)=" . $month1_y .") or (month(SDATE)=" .$month2. " and year(SDATE)=" .$month2_y. ")or (month(SDATE)=" . $month3 . " and year(SDATE)=" . $month3_y . ")) and flag1 != '1' ";
            	}
				
        	} else {
            	$sql_strsql = "select *from s_salma where Accname != 'NON STOCK' and C_CODE='" . $m_cus . "'and Brand='" . $_GET["cmbbrand"] . "' and CANCELL='0'";
				
            	if ($_GET["chkdef"] == "on") { 
					$sql_grnsql = "select * from c_bal where CUSCODE='" . $m_cus . "' and  trn_type!='INC'and trn_type!='REC' and trn_type!='PAY' and trn_type!='ARN' and brand='" . $_GET["cmbbrand"] . "' and flag1 != '1'";
				}	
            	if ($_GET["chkdef"] != "on") { 
					$sql_grnsql = "select * from c_bal where CUSCODE='" . $m_cus . "' and  trn_type!='INC'and  trn_type!='DGRN' and trn_type!='REC' and trn_type!='PAY' and trn_type!='ARN' and brand='" . $_GET["cmbbrand"] . "' and flag1 != '1'";
				}
					
        	}
    	} else {
       		if ($_GET["cmbbrand"] == "All") {
         		
				if (trim($_GET["cmbrep"]) == trim($NewRefNo)){
            		$sql_strsql = "select * from s_salma where Accname != 'NON STOCK' and C_CODE='" . $m_cus . "' and (SAL_EX ='" . $OldRefno . "' or SAL_EX='" . $rep . "') and CANCELL='0'";
         		}else {
            		$sql_strsql = "select * from s_salma where Accname != 'NON STOCK' and C_CODE='" . $m_cus . "' and SAL_EX='" . $rep . "' and CANCELL='0'";
         		}
				
         		if ($_GET["chkdef"] == "on") { 
		 			$sql_grnsql = "select * from c_bal where  SAL_EX='" . $rep . "' and CUSCODE='" . $m_cus . "' and  trn_type!='INC' and trn_type!='REC' and trn_type!='PAY' and trn_type!='ARN' and flag1 != '1' ";
		 		}	
         		if ($_GET["chkdef"] != "on") { 
		 			$sql_grnsql = "select * from c_bal where  SAL_EX='" . $rep . "' and CUSCODE='" . $m_cus . "' and  trn_type!='INC' and  trn_type!='DGRN' and trn_type!='REC' and trn_type!='PAY' and trn_type!='ARN' and flag1 != '1' ";
         		}
        	} else {
            	if (trim($_GET["cmbrep"]) == trim($NewRefNo)) {
                	$sql_strsql = "select *from s_salma where Accname != 'NON STOCK' and C_CODE='" . $m_cus . "' and brand='" . $_GET["cmbbrand"] . "' and (SAL_EX ='" . $OldRefno . "' or SAL_EX='" . $rep . "') and CANCELL='0'";
            	} else {
                	$sql_strsql = "select *from s_salma where Accname != 'NON STOCK' and C_CODE='" . $m_cus . "' and brand='" . $_GET["cmbbrand"] . "'and SAL_EX='" . $rep . "' and CANCELL='0'";
            	}
            	if ($_GET["chkdef"] == "on") {
			  		$grnsql = "select * from c_bal where CUSCODE='" . $m_cus . "' and  trn_type!='INC'and trn_type!='REC' and trn_type!='PAY' and trn_type!='ARN' and  brand='" . $_GET["cmbbrand"] . "' and SAL_EX='" . $rep . "' and flag1 != '1' ";
				}	
            	if ($_GET["chkdef"] != "on") { 
					$sql_grnsql = "select * from c_bal where CUSCODE='" . $m_cus . "' and  trn_type!='INC'and trn_type!='REC' and trn_type!='PAY' and trn_type!='DGRN' and trn_type!='ARN' and  brand='" . $_GET["cmbbrand"] . "' and SAL_EX='" . $rep . "' and flag1 != '1' ";
        		}
        	}
    
    	}
   
    	//echo $sql_strsql;
		$result_RSINVO =$db->RunQuery($sql_strsql);
		while ($row_RSINVO = mysql_fetch_array($result_RSINVO)) {
      	  
		  	if ((date("m", strtotime($row_RSINVO["SDATE"])) == date("m", strtotime($_GET["month1"]))) and (date("Y", strtotime($row_RSINVO["SDATE"])) == date("Y", strtotime($_GET["month1"])))) {
             
             	$m1 = $m1 + $row_RSINVO["GRAND_TOT"] / (1 + $row_RSINVO["GST"] / 100);
          	}
          	if ((date("m", strtotime($row_RSINVO["SDATE"])) == date("m", strtotime($_GET["month2"]))) and (date("Y", strtotime($row_RSINVO["SDATE"])) == date("Y", strtotime($_GET["month2"])))) {
             
             	$m2 = $m2 + $row_RSINVO["GRAND_TOT"] / (1 + $row_RSINVO["GST"] / 100); 
             
          	}
          	if ((date("m", strtotime($row_RSINVO["SDATE"])) == date("m", strtotime($_GET["month3"]))) and (date("Y", strtotime($row_RSINVO["SDATE"])) == date("Y", strtotime($_GET["month3"])))) {
             
             	$m3 = $m3 + $row_RSINVO["GRAND_TOT"] / (1 + $row_RSINVO["GST"] / 100); 
          	}
    	}
 
 		$result_grnsql =$db->RunQuery($sql_grnsql);
		while ($row_grnsql = mysql_fetch_array($result_grnsql)) {
          	if ((date("m", strtotime($row_grnsql["SDATE"])) == date("m", strtotime($_GET["month1"]))) and (date("Y", strtotime($row_grnsql["SDATE"])) == date("Y", strtotime($_GET["month1"])))) {
             
             	$G1 = $G1 + $row_grnsql["AMOUNT"] / (1 + $row_grnsql["vatrate"] / 100);
          	}
          	if ((date("m", strtotime($row_grnsql["SDATE"])) == date("m", strtotime($_GET["month2"]))) and (date("Y", strtotime($row_grnsql["SDATE"])) == date("Y", strtotime($_GET["month2"])))) {
           
            	$G2 = $G2 + $row_grnsql["AMOUNT"] / (1 + $row_grnsql["vatrate"] / 100);
          	}
          	if ((date("m", strtotime($row_grnsql["SDATE"])) == date("m", strtotime($_GET["month3"]))) and (date("Y", strtotime($row_grnsql["SDATE"])) == date("Y", strtotime($_GET["month3"])))) {
           
            	$G3 = $G3 + $row_grnsql["AMOUNT"] / (1 + $row_grnsql["vatrate"] / 100);
          	}
          
    	}
   
    
    	$sql_rsVENDOR = "SELECT * FROM vendor WHERE CODE='" . trim($m_cus) . "' ";
   	 	$result_rsVENDOR =$db->RunQuery($sql_rsVENDOR);
		$row_rsVENDOR = mysql_fetch_array($result_rsVENDOR);
   
    
    
    	if (($_GET["cmbbrand"] == "All") and ($_GET["cmbrep"] == "All")) { 
			$sql_tmpLmt = "select * from br_trn where cus_code='" . trim($m_cus) . "' ";
		}	
    	if (($_GET["cmbbrand"] == "All") and ($_GET["cmbrep"] != "All")) { 
			$sql_tmpLmt = "select * from br_trn where Rep='" . $rep . "' and cus_code='" . trim($m_cus) . "' ";
    	}
    	if (($_GET["cmbbrand"] != "All") and ($_GET["cmbrep"] == "All")) { 
			$sql_tmpLmt = "select * from br_trn where brand='" . $row_itclas["class"] . "' and  cus_code='" . trim($m_cus) . "' ";
		}	
    	if (($_GET["cmbbrand"] != "All") and ($_GET["cmbrep"] != "All")) { 
			$sql_tmpLmt= "select * from br_trn where  brand='" . $row_itclas["class"] . "' and Rep='" . $rep . "' and cus_code='" . trim($m_cus) . "' ";
		}	
    
    	$lmt = 0;
    	$cat = 0;
    
	
		$result_tmpLmt =$db->RunQuery($sql_tmpLmt);
		$rec_count= mysql_num_rows($result_tmpLmt);
	
		$result_tmpLmt =$db->RunQuery($sql_tmpLmt);
		$row_tmpLmt = mysql_fetch_array($result_tmpLmt);
    
		if ($rec_count == 1) {
        	$lmt = $row_tmpLmt["credit_lim"];
       
        	$cat = $row_rsVENDOR["CAT"];
    	} else {
        	$result_tmpLmt =$db->RunQuery($sql_tmpLmt);
		
			while($row_tmpLmt = mysql_fetch_array($result_tmpLmt)){
     
        		if (trim($row_tmpLmt["CAT"]) == "A") { $lmt = $lmt + $row_tmpLmt["credit_lim"] * 2.5; }
        		if (trim($row_tmpLmt["CAT"]) == "B") { $lmt = $lmt + $row_tmpLmt["credit_lim"] * 2.5; }
        		if (trim($row_tmpLmt["CAT"]) == "C") { $lmt = $lmt + $row_tmpLmt["credit_lim"]; }
        
        
        		$cat = $row_rsVENDOR["CAT"];
        	
        	}
        
    	}
    
	
	
	
		$sql_RSMONSALES="insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE) values ('".$m_cus."', '".$row_rsVENDOR["NAME"]."', '".$lmt."', '".$cat."', '".($m1 - $G1)."', '".($m2 - $G2)."', '".($m3 - $G3)."', '".$row_rsVENDOR["cus_type"]."' )";
			//echo $sql_RSMONSALES."</br>";
     	$result_RSMONSALES =$db->RunQuery($sql_RSMONSALES);
			
   
    	$m1 = 0;
    	$m2 = 0;
    	$m3 = 0;
    	$G1 = 0;
    	$G2 = 0;
    	$G3 = 0;
    	
	}  	
	  
  	PrintRep1();
  
}
 
function PrintRep1(){
	//echo "aaaa";
		require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$sql_head="select * from invpara";
	$result_head =$db->RunQuery($sql_head);
	$row_head = mysql_fetch_array($result_head); 


	$txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

	$sql_sql="SELECT * from monsales  order by id";
	//$result_sql =$db->RunQuery($sql_sql);
	//$row_head = mysql_fetch_array($result_sql); 
	
$sql_rst = "Select cus_code, Rep from br_trn where credit_lim > '0' and Rep = '" . trim($_GET["cmbrep"]) . "' group by cus_code, Rep";
$result_rst =$db->RunQuery($sql_rst);
$row_rst = mysql_fetch_array($result_rst); 
if ($_GET["radio"]== "Option1") {
    $sql_sql = "SELECT * from monsales where month1!=0 or month2!=0 or month3!=0  order by id";
}

if ($_GET["radio"]== "Option2") {
    $sql_sql = "SELECT * from monsales where month1=0 and month2=0 and month3=0  and cat != 'D' and C_TYPE != 'F'  order by id";
}

if ($_GET["radio"]== "op_traget") {
    if ($_GET["txt_amou"] > 0) {
        $sql_sql = "SELECT * from monsales where target >= " . $_GET["txt_amou"] . " order by id";

    } else {
        $sql_sql = "SELECT * from monsales where month1!=0 or month2!=0 or month3!=0 order by id";
    }
	
}
//echo $sql_sql;
$rtxtComName = $row_head["COMPANY"];
$rtxtcomadd1 = $row_head["ADD1"];
$rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
if ($_GET["cmbrep"] != "All") { $rtxtrep = "Person : " . trim($_GET["cmbrep"]); }
if ($_GET["cmbrep"] == "All") { $rtxtrep = "Person : " . $_GET["cmbrep"]; }
$rtxtbrand = "Brand : " . $_GET["cmbbrand"];

$rtxtm1= date("M", strtotime($_GET["month1"])) . " " . date("Y", strtotime($_GET["month1"]));
$rtxtm2= date("M", strtotime($_GET["month2"])) . " " . date("Y", strtotime($_GET["month2"]));
$rtxtm3=  date("M", strtotime($_GET["month3"])) . " " . date("Y", strtotime($_GET["month3"]));
//if($_GET["radio"]== "Option2") { $Text8= Format((rsPrInv.RecordCount / rst.RecordCount) * 100, "##.00") & " " & "%"


echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		echo "<center>Monthly Sales Summery  ";
        echo $rtxtrep."</br>";
		echo  $rtxtbrand."</br>";
			
		echo $heading;
		
		echo "<center><table border=1><tr>
		<th>Code</th>
		<th>Cat</th>
		<th>Customer Name</th>
		<th>Brand</th>
		<th>".$rtxtm1."</th>
		<th>".$rtxtm2."</th>
		<th>".$rtxtm3."</th>
		</tr>";
		//echo $sql;
		
		$month1=0;
		$month2=0;
		$month3=0;
		$limit=0;
		
		$i=0;
		
		$result_sql =$db->RunQuery($sql_sql);
		while($row_sql = mysql_fetch_array($result_sql)){	
			
			if ($Cus_Code!=$row_sql["Cus_Code"]){
			 
			  
			  if ($i!=0){	
				echo "<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><b>".$month1."</b></td>
				<td><b>".$month2."</b></td>
				<td><b>".$month3."</b></td>
				</tr>";
				
				$month1=0;
				$month2=0;
				$month3=0;
			  }
			  	
				echo "<tr>
				<td>".$row_sql["Cus_Code"]."</td>
				<td></td>
				<td>".$row_sql["cus_name"]."</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				</tr>";
				$Cus_Code=$row_sql["Cus_Code"];
				$i=1;
			} 
			
		 //if ($row_sql["month1"]!=0) { 	
			echo "<tr>
				<td>".$row_sql["Cus_Code"]."</td>
				<td>".$row_sql["cat"]."</td>
				<td>".$row_sql["cus_name"]."</td>
				<td>".$row_sql["brand"]."</td>
				<td>".$row_sql["month1"]."</td>
				<td>".$row_sql["month2"]."</td>
				<td>".$row_sql["month3"]."</td>
				</tr>";
					
			$limit=$limit+$row_sql["limit1"];
			$month1=$month1+$row_sql["month1"];
			$month2=$month2+$row_sql["month2"];
			$month3=$month3+$row_sql["month3"];
			
			$month1_tot=$month1_tot+$row_sql["month1"];
			$month2_tot=$month2_tot+$row_sql["month2"];
			$month3_tot=$month3_tot+$row_sql["month3"];
		 // }	
		}
		
		echo "<tr>
			<td>Total</td>
			<td></td>
			<td></td>
			<td></td>
			<td align=\"right\"><b>".number_format($month1_tot, 2, ".", ",")."</b></td>
			<td align=\"right\"><b>".number_format($month2_tot, 2, ".", ",")."</b></td>
			<td align=\"right\"><b>".number_format($month3_tot, 2, ".", ",")."</b></td>
			
			</tr>";
			
		echo "<tr>
			<td>% From Credit Limit</td>
			<td></td>
			<td></td>
			<td></td>";
			if ($limit != 0) { 
				$m1=$month1_tot/$limit*100; 
				$m2=$month1_tot/$limit*100; 
				$m3=$month1_tot/$limit*100; 
			} else {
				$m1=0;
				$m2=0;
				$m3=0;
			}
			echo "<td align=\"right\"><b>".number_format($m1, 2, ".", ",")."</b></td>
			<td align=\"right\"><b>".number_format($m2, 2, ".", ",")."</b></td>
			<td align=\"right\"><b>".number_format($m3, 2, ".", ",")."</b></td>
			
			</tr>";	
			
		echo "<table>";
		


}    
?>


</body>
</html>
