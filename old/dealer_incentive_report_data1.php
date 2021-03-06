<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("connectioni.php");
	
	
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
	$MSHFlexGrid1 = array(array());
	$MSHFlexGrid1_count=0;
	$gridchk = array(array());


if($_GET["Command"]=="view")
{
	//if ($_SESSION['company']=="THT"){
	//	calrepo2014();
	//} else 	if ($_SESSION['company']=="BEN"){
		calrepo();
	//}	
}


function calrepo()
{
	require_once("connectioni.php");
	
	
	
	$rs = "delete from monsales";
	$result =mysqli_query($GLOBALS['dbinv'],$rs);
		
	//$rsVENDOR = "select * from  vendor where CODE = '" . trim($_GET["txt_cuscode"]) . "' ";
		//$result_rsVENDOR =mysqli_query($GLOBALS['dbinv'],$rsVENDOR);
		//while($row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR)){
	
	$sql_tmp = "select * from monsales ";

	$sql_rsVENDOR = "select C_CODE, CUS_NAME, incdays, sum(GRAND_TOT) as tot  from  view_salma_vendor_brand where year(SDATE) = '" . date("Y", strtotime($_GET["DTPicker1"])) . "' and month(SDATE) = '" . date("m", strtotime($_GET["DTPicker1"])) . "' and CANCELL = '0' and delinrate = '2.5' group by C_CODE, incdays order by C_CODE ";
//echo $sql_rsVENDOR;
	$rep = trim($_GET["cmbrep"]);
	
	$result_rsVENDOR =mysqli_query($GLOBALS['dbinv'],$sql_rsVENDOR);
	while($row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR)){
    	
	  $sql_inschk="select * from ins_payment where cusCode='".$row_rsVENDOR["C_CODE"]."' and I_year='".date("Y", strtotime($_GET["DTPicker1"]))."' and I_month='".intval(date("m", strtotime($_GET["DTPicker1"])))."'";
	  $result_inschk =mysqli_query($GLOBALS['dbinv'],$sql_inschk);
	  if($row_inschk = mysqli_fetch_array($result_inschk)){
	  } else {
		$sql_rschper = "Select * from intper where incen_year = 2013 and traget < " . $row_rsVENDOR["tot"] / 1.12 . " order by traget desc ";
		//echo $sql_rschper;
    	$result_rschper =mysqli_query($GLOBALS['dbinv'],$sql_rschper);
		if($row_rschper = mysqli_fetch_array($result_rschper)){
        	if ($_GET["cmbrep"] == "All") {
             	$sql_rssalma = "select * from view_salma_sttr where C_CODE='" . trim($row_rsVENDOR["C_CODE"]) . "' and month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . " and CANCELL = '0' and deliin_amo <= '0' and deliin_lock = '0' order by st_days desc";
				
             	$sql_rs = "select    sum(GRAND_TOT) as totsal, sum(GRAND_TOT-TOTPAY) as  out1 from s_salma where Accname != 'NON STOCK' and month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  and C_CODE='" . trim($row_rsVENDOR["C_CODE"]) . "' and CANCELL = '0' ";
				
				//$sql_rs_vat = "select  GST from s_salma where Accname != 'NON STOCK' and month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  and C_CODE='" . trim($row_rsVENDOR["C_CODE"]) . "' and CANCELL = '0' ";
				
				
             	$sql_rs_sal= "Select sum(GRAND_TOT-TOTPAY) as out1 from view_s_salma_brand_mas where month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  and C_CODE='" . trim($row_rsVENDOR["C_CODE"]) . "' and CANCELL = '0' and delinrate = '2.5' ";
             	
			 	$salret = 0;
			 
             	$sql_rs1 = "select * from c_bal where month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  and CUSCODE='" . trim($row_rsVENDOR["C_CODE"]) . "' and CANCELL = '0' AND trn_type != 'ARN' and trn_type != 'REC' and trn_type != 'DGRN' and flag1 != '1' ";
             	$result_rs1 =mysqli_query($GLOBALS['dbinv'],$sql_rs1);
			 	while($row_rs1 = mysqli_fetch_array($result_rs1)){
			 
              		$sql_rsbrn_mas = "select * from brand_mas where barnd_name = '" . trim($row_rs1["brand"]) . "'";
			  		$result_rsbrn_mas =mysqli_query($GLOBALS['dbinv'],$sql_rsbrn_mas);
			  		if($row_rsbrn_mas = mysqli_fetch_array($result_rsbrn_mas)){
             
                		if ($row_rsbrn_mas["delinrate"] == 2.5) {
                  			$salret = $salret + $row_rs1["AMOUNT"];
                 		}
              		}
             	}
                
				//echo $sql_rs;
				$result_rs =mysqli_query($GLOBALS['dbinv'],$sql_rs);
			 	$row_rs = mysqli_fetch_array($result_rs);
				
				//$result_rs_vat =mysqli_query($GLOBALS['dbinv'],$sql_rs_vat);
			 	//$row_rs_vat = mysqli_fetch_array($result_rs_vat);
				
			
				
             	if (is_null($row_rs["totsal"])==false) {
					
					if (date("Y", strtotime($_GET["DTPicker1"]))<=2014){
                		$msal = $row_rs["totsal"] / 1.12;
						$mret = $salret / 1.12;
					} else {
						$msal = $row_rs["totsal"] / 1.11;
						$mret = $salret / 1.11;
					}	
					
                
                	$mpay = 0;
                	if ($row_rs["out1"] < 50) { 
						
						$result_rssalma =mysqli_query($GLOBALS['dbinv'],$sql_rssalma);
			 			while($row_rssalma = mysqli_fetch_array($result_rssalma)){
                  		
                  			$sql_rs_type= "Select * from view_inv_item where REF_NO = '" . $row_rssalma["ST_INVONO"] . "' order by id";
							$result_rs_type =mysqli_query($GLOBALS['dbinv'],$sql_rs_type);
			 				$row_rs_type = mysqli_fetch_array($result_rs_type);
							
                   			$sql_rsbrn_mas= "select * from brand_mas where barnd_name = '" . trim($row_rssalma["Brand"]) . "'";
							$result_rsbrn_mas =mysqli_query($GLOBALS['dbinv'],$sql_rsbrn_mas);
			 				if($row_rsbrn_mas = mysqli_fetch_array($result_rsbrn_mas)){
								if ($row_rsbrn_mas["delinrate"]==2.5){
                   			
                      				if ((is_null($row_rssalma["Deli_date"])==false) and ($row_rssalma["Deli_date"]!="0000-00-00")){
                         				if ((is_null($row_rssalma["st_chdate"])==false) and ($row_rssalma["st_chdate"]!="0000-00-00")){
											
											$diff = abs(strtotime($row_rssalma["st_chdate"]) - strtotime($row_rssalma["Deli_date"]));
											$mdate = floor($diff / (60*60*24));
                             				
                         				} else {
											$diff = abs(strtotime($row_rssalma["ST_DATE"]) - strtotime($row_rssalma["Deli_date"]));
											$mdate = floor($diff / (60*60*24));
                             				/*if (trim($row_rsVENDOR["C_CODE"])=="C005"){
											echo $row_rssalma["ST_DATE"]."-".$row_rssalma["Deli_date"]."---".$row_rssalma["ST_INVONO"]."-".$mdate."/";
											}*/
										
                         				}
                         					
										if ((trim($row_rs_type["type"]) == "TBR") or (trim($row_rs_type["type"]) == "BIAS TYRES")) {
                            				if (90 >= $mdate) {
                                				$mpay = $mpay + $row_rssalma["ST_PAID"];
                            				}
                         				} else {
                            				if ($row_rsVENDOR["incdays"] >= $mdate) {
                                 				$mpay = $mpay + $row_rssalma["ST_PAID"];
                            				}
                         				}
                      				} else {
                         				if ((is_null($row_rssalma["st_chdate"])==false) and ($row_rssalma["st_chdate"]!="0000-00-00")) {
											$date1 = $row_rssalma["st_chdate"];
											$date2 = $row_rssalma["SDATE"];
											$diff = abs(strtotime($date2) - strtotime($date1));
											$mdate = floor($diff / (60*60*24));
                             				
                         				} else {
											$date1 = $row_rssalma["ST_DATE"];
											$date2 = $row_rssalma["SDATE"];
											$diff = abs(strtotime($date2) - strtotime($date1));
											$mdate = floor($diff / (60*60*24));
                             				
                         				}
                         				if ((trim($row_rs_type["type"]) == "TBR") or (trim($row_rs_type["type"]) == "BIAS TYRES")) {
                            				if (90 >= $mdate) {
                                				$mpay = $mpay + $row_rssalma["ST_PAID"];
                            				}
                         				} else {
                            				if ($row_rsVENDOR["incdays"] >= $mdate) {
                                 				$mpay = $mpay + $row_rssalma["ST_PAID"];
                            				}
										}
                         			}
                      			}
                   			}
                   			//rssalma.MoveNext
                   
                  		}
						
						if (date("Y", strtotime($_GET["DTPicker1"]))<=2014){
                  			$mpay = $mpay / 1.12;
						} else {
							$mpay = $mpay / 1.11;
						}	
						
                  		if (is_null($salret)==false) {
                            $msal = $msal - $mret;
                            $mpay = $mpay - $mret;
                            
                  		}
                  		if (date("Y", strtotime($_GET["DTPicker1"])) > 2012) {
                    		$sql_rsper = "Select * from intper where incen_year = 2013 and traget < " . $mpay . " order by traget desc ";
                  		} else {
                    		if (date("Y", strtotime($_GET["DTPicker1"])) < 2010) {
                        		$sql_rsper = "Select * from intper where incen_year = 2009 and traget < " . $mpay . " order by traget desc ";
                    		} else {
                       			if ((date("m", strtotime($_GET["DTPicker1"])) > 3) or (date("Y", strtotime($_GET["DTPicker1"])) >= 2010)) {
                           			$sql_rsper= "Select * from intper where incen_year = 20101 and traget < " . $mpay . " order by traget desc ";
                       			} else {
                           			$sql_rsper= "Select * from intper where incen_year = 2010 and traget < " . $mpay . " order by traget desc ";
                       			}
                    		}
                  		}
						//echo $sql_rsper;
						$result_rsper =mysqli_query($GLOBALS['dbinv'],$sql_rsper);
			 			if($row_rsper = mysqli_fetch_array($result_rsper)){
                   			
							$target_a=0;
							
							$month3 = $mpay * (($row_rsper["per"] / 100));
							$sql_rsincen = "select * from ins_payment where  I_month ='" . intval(date("m", strtotime($_GET["DTPicker1"]))) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($row_rsVENDOR["C_CODE"]) . "'order by id ";
							//echo $sql_rsincen;
							$result_rsincen =mysqli_query($GLOBALS['dbinv'],$sql_rsincen);
			 				if($row_rsincen = mysqli_fetch_array($result_rsincen)){	
                         	
                            	$target_a = $row_rsincen["amount"];
                         	}
						 
							$sql_dealer = "insert into monsales(Cus_Code, cus_name, month1, month2, month3, limit1, target) values ('".$row_rsVENDOR["C_CODE"]."', '".$row_rsVENDOR["CUS_NAME"]."', ".$msal.", ".$mret.", ".$month3.", ".$mpay.", ".$target_a.")";
							$result_dealer =mysqli_query($GLOBALS['dbinv'],$sql_dealer); 
						
                      		//echo $sql_dealer;
                      	}
                      
                   	}
               	}
             
         	} else {
             	$sql_rssalma= "select * from view_salma_sttr where C_CODE='" . trim($row_rsVENDOR["C_CODE"]) . "' and month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . " and SAL_EX = '" . $rep . "' and CANCELL = '0' and deliin_amo <= '0' and deliin_lock = '0' order by st_days desc";
             	
				$sql_rs = "select    sum(GRAND_TOT) as totsal, sum(GRAND_TOT-TOTPAY) as  out1 from s_salma where Accname != 'NON STOCK' and month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  and C_CODE='" . trim($row_rsVENDOR["C_CODE"]) . "' and SAL_EX = '" . $rep . "' and CANCELL = '0' ";
				
				$result_rs =mysqli_query($GLOBALS['dbinv'],$sql_rs);
			 	$row_rs = mysqli_fetch_array($result_rs);
					
				//$sql_rs_vat = "select     GST from s_salma where Accname != 'NON STOCK' and month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  and C_CODE='" . trim($row_rsVENDOR["C_CODE"]) . "' and SAL_EX = '" . $rep . "' and CANCELL = '0' ";
             	
				//$result_rs_vat =mysqli_query($GLOBALS['dbinv'],$sql_rs_vat);
			 	//$row_rs_vat = mysqli_fetch_array($result_rs_vat);
				
             	$salret = 0;
             
			 	$sql_rs1 = "select * from c_bal where month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  and CUSCODE='" . trim($row_rsVENDOR["C_CODE"]) . "' and CANCELL = '0' AND SAL_EX = '" . $rep . "' and trn_type <> 'ARN' and trn_type != 'REC' and trn_type != 'DGRN' and flag1 != '1' ";
				$result_rs1 =mysqli_query($GLOBALS['dbinv'],$sql_rs1);
			 	while($row_rs1 = mysqli_fetch_array($result_rs1)){
             	
              		$sql_rsbrn_mas = "select * from brand_mas where barnd_name = '" . trim($row_rs1["brand"]) . "'";
					$result_rsbrn_mas =mysqli_query($GLOBALS['dbinv'],$sql_rsbrn_mas);
			 		if($row_rsbrn_mas = mysqli_fetch_array($result_rsbrn_mas)){
              			if ($row_rsbrn_mas["delinrate"] == 2.5) {
                  			$salret = $salret + $row_rs1["AMOUNT"];
              			}
					}
				}
                
             	if (is_null($row_rs["totsal"])==false) {
				  
				  if (date("Y", strtotime($_GET["DTPicker1"]))<=2014){
                	$msal = $row_rs["totsal"] / 1.12;
                	$mret = $salret / 1.12;
				  } else {
				  	$msal = $row_rs["totsal"] / 1.11;
                	$mret = $salret / 1.11;
				  }	
                
                	$mpay = 0;
                	if ($row_rs["out1"] < 50) { 
					
						$result_rssalma =mysqli_query($GLOBALS['dbinv'],$sql_rssalma);
			 			while($row_rssalma = mysqli_fetch_array($result_rssalma)){
                  
                  			$sql_rs_type = "Select * from view_inv_item where REF_NO = '" . $row_rssalma["REF_NO"] . "' order by id";
                   			$sql_rsbrn_mas = "select * from brand_mas where barnd_name = '" . trim($row_rssalma["Brand"]) . "'";
							
							$result_rsbrn_mas =mysqli_query($GLOBALS['dbinv'],$sql_rsbrn_mas);
			 				if($row_rsbrn_mas = mysqli_fetch_array($result_rsbrn_mas)){
						
                   				if ($row_rsbrn_mas["delinrate"] == 2.5) {
                      				if ((is_null($row_rssalma["Deli_date"])==false) and ($row_rssalma["Deli_date"]!="0000-00-00")) {
                         				if ((is_null($row_rssalma["st_chdate"])==false) and ($row_rssalma["st_chdate"]!="0000-00-00")){
											$date1 = $row_rssalma["st_chdate"];
											$date2 = $row_rssalma["Deli_date"];
											$diff = abs(strtotime($date2) - strtotime($date1));
											$mdate = floor($diff / (60*60*24));
                             				
                         				} else {
											$date1 = $row_rssalma["ST_DATE"];
											$date2 = $row_rssalma["Deli_date"];
											$diff = abs(strtotime($date2) - strtotime($date1));
											$mdate = floor($diff / (60*60*24));
                             				
                         				}
                         				
										if ((trim($row_rs_type["type"]) == "TBR") or (trim($row_rs_type["type"]) == "BIAS TYRES")) {
                            				if (90 >= $mdate) {
                                				$mpay = $mpay + $row_rssalma["ST_PAID"];
                            				}
                         				} else {
                            				if ($row_rsVENDOR["incdays"] >= $mdate) {
                                 				$mpay = $mpay + $row_rssalma["ST_PAID"];
											}	
                            			}
                         			}
                      			} else {
                         			if ((is_null($row_rssalma["st_chdate"])==false) and ($row_rssalma["st_chdate"]!="0000-00-00")) {
										$date1 = $row_rssalma["st_chdate"];
										$date2 = $row_rssalma["SDATE"];
										$diff = abs(strtotime($date2) - strtotime($date1));
										$mdate = floor($diff / (60*60*24));
											
                             			
                         			} else {
										$date1 = $row_rssalma["ST_DATE"];
										$date2 = $row_rssalma["SDATE"];
										$diff = abs(strtotime($date2) - strtotime($date1));
										$mdate = floor($diff / (60*60*24));
                             			
                         			}
                         			if ((trim($row_rs_type["type"]) == "TBR") or (trim($row_rs_type["type"]) == "BIAS TYRES")) {
                            			if (90 >= $mdate) {
                                			$mpay = $mpay + $row_rssalma["ST_PAID"];
                            			}
                         			} else {
                            			if ($row_rsVENDOR["incdays"] >= $mdate) {
                                 			$mpay = $mpay + $row_rssalma["ST_PAID"];
                            			}
                         			}
                      			}
                   			}
                   
                  		}
                  		
						if (date("Y", strtotime($_GET["DTPicker1"]))<=2014){
							$mpay = $mpay / 1.12;
						} else {
							$mpay = $mpay / 1.11;
						}	
						
                  		if (is_null($salret)==false) {
                            $msal = $msal - $mret;
                            $mpay = $mpay - $mret;
                           
                  		}
                  
				  		if (date("Y", strtotime($_GET["DTPicker1"])) > 2012) {
                    		$sql_rsper = "Select * from intper where incen_year = 2013 and traget < " . $mpay . " order by traget desc ";
                  		} else {
                    		if (date("Y", strtotime($_GET["DTPicker1"])) < 2010) {
                        		$sql_rsper = "Select * from intper where incen_year = 2009 and traget < " . $mpay . " order by traget desc ";
                    		} else {
                       			if ((date("m", strtotime($_GET["DTPicker1"])) > 3) or (date("Y", strtotime($_GET["DTPicker1"])) >= 2010)) {
                           			$sql_rsper = "Select * from intper where incen_year = 20101 and traget < " . $mpay . " order by traget desc ";
                       			} else {
                           			$sql_rsper = "Select * from intper where incen_year = 2010 and traget < " . $mpay . " order by traget desc ";
                       			}
                    		}
                  		}
						
						$result_rsper =mysqli_query($GLOBALS['dbinv'],$sql_rsper);
			 			if($row_rsper = mysqli_fetch_array($result_rsper)){
                   			
							$target_a=0;
							$month3 = $mpay * (($row_rsper["per"] / 100));
							
							$sql_rsincen = "select * from ins_payment where  I_month ='" . intval(date("m", strtotime($_GET["DTPicker1"]))) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($row_rsVENDOR["C_CODE"]) . "'order by id ";
							//echo $sql_rsincen;
							$result_rsincen =mysqli_query($GLOBALS['dbinv'],$sql_rsincen);
			 				if($row_rsincen = mysqli_fetch_array($result_rsincen)){
						
                            	$target_a = $row_rsincen["amount"];
                         	}
							
							$sql_dealer = "insert into monsales(Cus_Code, cus_name, month1, month2, month3, limit1, target) values ('".$row_rsVENDOR["C_CODE"]."', '".$row_rsVENDOR["CUS_NAME"]."', ".$msal.", ".$mret.", ".$month3.", ".$mpay.", ".$target_a.")";
							$result_dealer =mysqli_query($GLOBALS['dbinv'],$sql_dealer); 
							//echo $sql_dealer;
							
							
                     
                      	}
                      
                   	}
               	}
             
         	}
    	}
       }
	}

	
	if ($_GET["cmbrep"] == "All") {
    	
		$mRow = 1;
		
		$sql_tmp1 = "select * from monsales where target = 0";
		//echo $sql_tmp1;
		$result_tmp1 =mysqli_query($GLOBALS['dbinv'],$sql_tmp1);
		while($row_tmp1 = mysqli_fetch_array($result_tmp1)){
        	
			if (is_null($row_tmp1["Cus_Code"]) == false) { $Flexcus[$mRow][1] = trim($row_tmp1["Cus_Code"]); }
        	if (is_null($row_tmp1["cus_name"]) == false) { $Flexcus[$mRow][2] = trim($row_tmp1["cus_name"]); }
        	if (is_null($row_tmp1["limit1"]) == false) { $Flexcus[$mRow][3] = number_format($row_tmp1["limit1"], 2, ".", ","); }
        	if (is_null($row_tmp1["month3"]) == false) { $Flexcus[$mRow][4] = number_format($row_tmp1["month3"], 2, ".", ","); }
			if (is_null($row_tmp1["month1"]) == false) { $Flexcus[$mRow][7] = number_format($row_tmp1["month1"], 2, ".", ","); }
        	
			$mRow = $mRow + 1;
        
    	}
	} else {
    	
		$mrow1 = 1;
		$sql_tmp1 = "select * from monsales";
    	$result_tmp1 =mysqli_query($GLOBALS['dbinv'],$sql_tmp1);
		while($row_tmp1 = mysqli_fetch_array($result_tmp1)){
      
        	if (is_null($row_tmp1["Cus_Code"]) == false) { $Flexcus[$mrow1][1] = trim($row_tmp1["Cus_Code"]); }
        	if (is_null($row_tmp1["cus_name"]) == false) { $Flexcus[$mrow1][2] = trim($row_tmp1["cus_name"]); }
        	if (is_null($row_tmp1["limit1"]) == false) { $Flexcus[$mrow1][3] = number_format($row_tmp1["limit1"], 2, ".", ","); }
        	if (is_null($row_tmp1["month3"]) == false) { $Flexcus[$mrow1][4] = number_format($row_tmp1["month3"], 2, ".", ","); }
        	if ($row_tmp1["target"] > 0) { $Flexcus[$mrow1][5] = "Yes"; }
			
        	$sql_rsincen = "select * from ins_payment where  I_month ='" . intval(date("m", strtotime($_GET["DTPicker1"]))) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($row_tmp1["Cus_Code"]) . "'order by id ";
			$result_rsincen =mysqli_query($GLOBALS['dbinv'],$sql_rsincen);
			if($row_rsincen = mysqli_fetch_array($result_rsincen)){
       
            	$Flexcus[$mrow1][6] = $row_rsincen["remarks"];
        	}
        	if (is_null($row_tmp1["month1"]) == false) { $Flexcus[$mrow1][7] = number_format($row_tmp1["month1"], 2, ".", ","); }
			
        	$mrow1 = $mrow1 + 1;
        
    	}
	}
	
	$ResponseXML="";
	
	if ($_GET["cmbrep"]=="All"){
		
		$ResponseXML .= "<table><tr>
                              <td width=\"10\"  background=\"\" ><font color=\"#FFFFFF\"></font></td>
							  <td width=\"50\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Name</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Net Sale</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Effect Sale</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Incentive</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Yes/No</font></td>
                             
							  
                            </tr>";
	} else {
	
		$ResponseXML .= "<table><tr>
                              <td width=\"10\"  background=\"\" ><font color=\"#FFFFFF\"></font></td>
							  <td width=\"50\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Net Sale</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Effect Sale</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Incentive</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Paid</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Chq Detail</font></td>
                             
							  
                            </tr>";
	}						
							
	
	if ($_GET["cmbrep"] == "All") {	
		
		$i=1;
		
		while($mRow > $i){
			
			$chk="chk".$i;
			$ResponseXML .= "<tr>                              
                             <td>".$i."</td>
							 <td>".$Flexcus[$i][1]."</td>
							 <td>".$Flexcus[$i][2]."</td>
							 <td>".$Flexcus[$i][7]."</td>
							 <td>".$Flexcus[$i][3]."</td>
							 <td>".$Flexcus[$i][4]."</td>
							 <td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onClick=\"chk_ad('".$chk."', '".$Flexcus[$i][1]."');\"></td>
							 </tr>";
							 
			$i=$i+1;
		}
	} else {
	
		$i=1;
		
		while($mrow1 > $i){
			
			$ResponseXML .= "<tr>                              
                             <td>".$i."</td>
							 <td>".$Flexcus[$i][1]."</td>
							 <td>".$Flexcus[$i][2]."</td>
							 <td>".$Flexcus[$i][7]."</td>
							 <td>".$Flexcus[$i][3]."</td>
							 <td>".$Flexcus[$i][4]."</td>
							 <td>".$Flexcus[$i][5]."</td>
							 <td>".$Flexcus[$i][6]."</td>
							 </tr>";
							 
							 
			$i=$i+1;
		}
	
	}	
		
		
		
	
							
                $ResponseXML .= "   </table>";
				
				echo $ResponseXML;

}


if($_GET["Command"]=="chk_ad")
{
	require_once("connectioni.php");
	
	
	
	if ($_GET["chk_val"]=="true"){
		$rs = "update monsales set print = '1' where Cus_Code = '" .$_GET["cuscode"]. "'";
		$result =mysqli_query($GLOBALS['dbinv'],$rs);
		//$row = mysqli_fetch_array($result)){
	} else {
		$rs = "update monsales set print = '0' where Cus_Code = '" .$_GET["cuscode"]. "'";
		$result =mysqli_query($GLOBALS['dbinv'],$rs);
	}
	//echo $rs;
}

/*
function calrepo2014(){
	if ($_GET["Check1"] == "true") {
		
		$rep = $_GET["cmbrep"];
		
    	$rsVENDOR = "select * from  vendor where CODE = '" . trim($_GET["txt_cuscode"]) . "' ";
		$result_rsVENDOR =mysqli_query($GLOBALS['dbinv'],$rsVENDOR);
		while($row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR)){
		
        	$tyre_inc = 0;
        	$bat_inc = 0;
        	$tube_inc = 0;
        	
			$rssalma = "select * from view_salma_sttr where c_code='" . trim($row_rsVENDOR["CODE"]) . "' and month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . " and CANCELL = '0' and deliin_amo <= '0' and deliin_lock = '0' and TOTPAY1 = '1' order by st_days desc";
			
		
        	$rs = "select    sum(GRAND_TOT) as totsal, sum(GRAND_TOT-TOTPAY) as  out1 from s_salma where month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  and C_CODE='" . trim($row_rsVENDOR["CODE"]) . "' and CANCELL = '0' ";
			$result_rs =mysqli_query($GLOBALS['dbinv'],$rs);
			$row_rs = mysqli_fetch_array($result_rs);
			
        	$rssal= "select C_CODE, b60, sum(GRAND_TOT - TOTPAY) as out1 from view_salma_brand where month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  and C_CODE='" . trim($row_rsVENDOR["CODE"]) . "' and CANCELL = '0' and TOTPAY1 = '1' group by C_CODE, b60 ";
			
			$Out = 0;
        	$Out_bat = 0;
        	
			$result_rssal =mysqli_query($GLOBALS['dbinv'],$rssal);
			while($row_rssal = mysqli_fetch_array($result_rssal)){
				if ($row_rssal["b60"] == "1") { $Out = $Out + $row_rssal["out1"]; }
            	if ($row_rssal["b60"] == "2") { $Out_bat = $Out_bat + $row_rssal["out1"]; }
            	
        	}
        	
			$salret = 0;
        	$salret_bat = 0;
        
			$rs1 = "select CUSCODE, trn_type, delinrate, b60, TOTPAY1, YEAR(sal_sdate) AS G_year, YEAR(sal1_sdate) AS C_year, SUM(AMOUNT) AS tot from view_cbal_bmas_crnma_salma where month(SDATE)=" . date("m", strtotime($_GET["DTPicker1"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["DTPicker1"])) . "  and CUSCODE='" . trim($row_rsVENDOR["CODE"]) . "' and CANCELL = '0' AND trn_type != 'ARN' and trn_type != 'REC' and trn_type != 'DGRN' and flag1 != '1' GROUP BY CUSCODE, trn_type, delinrate, b60, TOTPAY1, YEAR(sal_sdate), YEAR(sal1_sdate) ";
			$result_rs1 =mysqli_query($GLOBALS['dbinv'],$rs1);
			while($row_rs1= mysqli_fetch_array($result_rs1)){
       
            	if (trim($row_rs1["TRN_TYPE"]) == "CNT") {
                	if (($row_rs1["b60"] == 1) and ($row_rs1["delinrate"] == 2.5)) { $salret = $salret + $row_rs1["tot"]; }
                	if (($row_rs1["b60"] == 1) and ($row_rs1["delinrate"] == 0) and ($row_rs1["C_year"] >= 2014)) { $salret = $salret + $row_rs1["tot"]; }
                	if ($row_rs1["b60"] == 2) { $salret_bat = $salret_bat + $row_rs1["tot"]; }
            	}
            	if (trim($row_rs1["trn_type"]) == "GRN") {
                	if ((is_null($row_rs1["TOTPAY1"])==false) or ($row_rs1["TOTPAY1"] == 1)) {
                    	if ($row_rs1["b60"] == 1) { $salret = $salret + $row_rs1["tot"]; }
                    	if ($row_rs1["b60"] == 2) { $salret_bat = $salret_bat + $row_rs1["tot"]; }
                	}
            	}
            }
        	
			if (is_null($row_rs["totsal"])==false) {
               $msal = $row_rs["totsal"] / 1.12;
               $mret = $salret / 1.12;
               $mret_bat = $salret_bat / 1.12;
               $mret_tube = $salret_tube / 1.12;
               
               $mpay = 0;
               $mpay_50 = 0;
               $m_pay_ut = 0;
               $c_mpay = 0;
               $c_mpay_50 = 0;
               $mpay_bat = 0;
               $mpay_tube = 0;
               if (($Out < 50) or ($Out_bat < 50) or ($out_tube < 50)) { 
			   		
					$result_rssalma =mysqli_query($GLOBALS['dbinv'],$rssalma);
					while($row_rssalma = mysqli_fetch_array($result_rssalma)){
                                         
                        
						$date1 = $_GET["ddate"];
						$date2 = $_GET["DTPicker1"];
						$diff = abs(strtotime($date2) - strtotime($date1));
						$days = floor($diff / (60*60*24));
				
                        if ($days > 0) {
							$rsbrn_mas = "select * from brand_mas where barnd_name = '" . trim($row_rssalma["brand"]) . "'";
							$result_rsbrn_mas =mysqli_query($GLOBALS['dbinv'],$rsbrn_mas);
							if($row_rsbrn_mas = mysqli_fetch_array($result_rsbrn_mas)){
							
                            	if ($row_rsbrn_mas["delinrate"] == 2.5) {
								
                                	if (is_null($row_rssalma["Deli_date"])==false) {
                                    	
										if (is_null($row_rssalma["st_chdate"])==false) {
											$date1 = $row_rssalma["st_chdate"];
											$date2 = $row_rssalma["Deli_date"];
											$diff = abs(strtotime($date2) - strtotime($date1));
											$mdate = floor($diff / (60*60*24));
                                        	
                                    	} else {
											$date1 = $row_rssalma["ST_DATE"];
											$date2 = $row_rssalma["Deli_date"];
											$diff = abs(strtotime($date2) - strtotime($date1));
											$mdate = floor($diff / (60*60*24));
                                        	
                                    	}
                                    	
										if ($row_rsVENDOR["incdays"] == 90) {
                                        	if ($row_rssalma["cre_pe"] > 90) {
                                            	if (($row_rssalma["cre_pe"] >= $mdate) and ($mdate > 50)) {
                                                	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	$c_mpay = $c_mpay + 1;
                                            	}
                                            	if (50 >= $mdate) {
                                                	if ($row_rssalma["ST_FLAG"] == "UT") {
                                                    	$m_pay_ut = $m_pay_ut + $row_rssalma["ST_PAID"];
                                                	} else {
                                                    	$mpay_50 = $mpay_50 + $row_rssalma["ST_PAID"];
                                                	}
                                                	$c_mpay_50 = $c_mpay_50 + 1;
                                            	}
                                        	} else {
                                            	if (($row_rsVENDOR["incdays"] >= $mdate) and ($mdate > 50)) {
                                                	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	$c_mpay = $c_mpay + 1;
                                            	}
                                           	 	if (50 >= $mdate) {
                                                	if ($row_rssalma["ST_FLAG"] == "UT") {
                                                    	$m_pay_ut = $m_pay_ut + $row_rssalma["ST_PAID"];
                                                	} else {
                                                    	$mpay_50 = $mpay_50 + $row_rssalma["ST_PAID"];
                                                	}
                                                	$c_mpay_50 = $c_mpay_50 + 1;
                                            	}
											}	
                                        } else {
                                        	
											if ($row_rssalma["cre_pe"] != 65) {
                                            	if (($row_rssalma["cre_pe"] >= $mdate) and ($mdate > 50)) {
                                                	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	$c_mpay = $c_mpay + 1;
												}	

                                            	if (50 >= $mdate) {
                                                	if ($row_rssalma["ST_FLAG"] == "UT") {
                                                    	$m_pay_ut = $m_pay_ut + $row_rssalma["ST_PAID"];
                                                	} else {
                                                    	$mpay_50 = $mpay_50 + $row_rssalma["ST_PAID"];
                                                	}
                                               	 	$c_mpay_50 = $c_mpay_50 + 1;
                                            	}
                                        	} else {
                                            	if ((75 >= $mdate) and ($mdate > 50)) {
                                                	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	$c_mpay = $c_mpay + 1;
                                            	}
                                            	if (50 >= $mdate) {
                                                	if ($row_rssalma["ST_FLAG"] == "UT") {
                                                    	$m_pay_ut = $m_pay_ut + $row_rssalma["ST_PAID"];
                                                	} else {
                                                    	$mpay_50 = $mpay_50 + $$row_rssalma["ST_PAID"];
                                                	}
                                                	$c_mpay_50 = $c_mpay_50 + 1;
                                            	}
                                        	}
                                    	}
                                	} else {
                                    	if (is_null($row_rssalma["st_chdate"])==false) {
											$date1 = $row_rssalma["st_chdate"];
											$date2 = $row_rssalma["SDATE"];
											$diff = abs(strtotime($date2) - strtotime($date1));
											$mdate = floor($diff / (60*60*24));
                                        
                                    	} else {
											$date1 = $row_rssalma["ST_DATE"];
											$date2 = $row_rssalma["SDATE"];
											$diff = abs(strtotime($date2) - strtotime($date1));
											$mdate = floor($diff / (60*60*24));
										
                                    	}
                                    	if ($row_rsVENDOR["incdays"] == 90) {
                                        	if ($row_rssalma["cre_pe"] > 90) {
                                            	if (($row_rssalma["cre_pe"] >= $mdate) and ($mdate > 50)) {
                                                	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	$c_mpay = $c_mpay + 1;
                                            	}
                                        	} else {
                                            	if (($row_rsVENDOR["incdays"] >= $mdate) and ($mdate > 50)) {
                                                	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	$c_mpay = $c_mpay + 1;
                                            	}
                                            	if (50 >= $mdate) {
                                                	if ($row_rssalma["ST_FLAG"] == "UT") {
                                                    	$m_pay_ut = $m_pay_ut + $row_rssalma["ST_PAID"];
                                                	} else {
                                                    	$mpay_50 = $mpay_50 + $row_rssalma["ST_PAID"];
                                                	}
                                                	$c_mpay_50 = $c_mpay_50 + 1;
                                            	}
                                        	}
                                    	} else {
                                        	if ($row_rssalma["cre_pe"] != 65) {
                                            	if (($row_rssalma["cre_pe"] >= $mdate) and ($mdate > 50)) {
                                                	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	$c_mpay = $c_mpay + 1;
                                            	}
                                            	if (50 >= $mdate) {
                                                	if ($row_rssalma["ST_FLAG"] == "UT") {
                                                    	$m_pay_ut = $m_pay_ut + $row_rssalma["ST_PAID"];
                                                } else {
                                                    $mpay_50 = $mpay_50 + $row_rssalma["ST_PAID"];
                                                }
                                                $c_mpay_50 = $c_mpay_50 + 1;
                                            
                                        	} else {
                                            	if ((75 >= $mdate) and ($mdate > 50)) {
                                                	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	$c_mpay = $c_mpay + 1;
                                            	}
                                            	if (50 >= $mdate) {
                                                	if ($row_rssalma["ST_FLAG"] == "UT") {
                                                    	$m_pay_ut = $m_pay_ut + $row_rssalma["ST_PAID"];
                                                	} else {
                                                    	$mpay_50 = $mpay_50 + $row_rssalma["ST_PAID"];
                                                	}
                                                	$c_mpay_50 = $c_mpay_50 + 1;
                                            	}
                                        	}
                                    	}
                                	}
                            	}
							}	
                        } else {
                            if ((date("m", strtotime($_GET["DTPicker1"])) < 11) and (date("Y", strtotime($_GET["DTPicker1"])) <= 2010)) {
                                $result_rsbrn_mas =mysqli_query($GLOBALS['dbinv'],$rsbrn_mas);
								if($row_rsbrn_mas = mysqli_fetch_array($result_rsbrn_mas)){
									if (($row_rsbrn_mas["delinrate"] == 2.5) and ($row_rsbrn_mas["barnd_name"] == "ROADSTONE") or ($row_rsbrn_mas["barnd_name"] == "ROADSTONE CHINA")) {
								
                                    	if (is_null($row_rssalma["Deli_date"])==false) {
                                        	if (is_null($row_rssalma["st_chdate"])==false) {
												$date1 = $row_rssalma["st_chdate"];
												$date2 = $row_rssalma["Deli_date"];
												$diff = abs(strtotime($date2) - strtotime($date1));
												$mdate = floor($diff / (60*60*24));
                                            	
                                        	} else {
												$date1 = $row_rssalma["ST_DATE"];
												$date2 = $row_rssalma["Deli_date"];
												$diff = abs(strtotime($date2) - strtotime($date1));
												$mdate = floor($diff / (60*60*24));
												
                                        	}
                                        	if ($row_rsVENDOR["incdays"] >= $mdate) {
                                            	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                        	}
                                     	} else {
                                        	if (is_null($row_rssalma["st_chdate"])==false) {
												$date1 = $row_rssalma["st_chdate"];
												$date2 = $row_rssalma["SDATE"];
												$diff = abs(strtotime($date2) - strtotime($date1));
												$mdate = floor($diff / (60*60*24));
                                            	
                                        	} else {
												$date1 = $row_rssalma["ST_DATE"];
												$date2 = $row_rssalma["SDATE"];
												$diff = abs(strtotime($date2) - strtotime($date1));
												$mdate = floor($diff / (60*60*24));
                                            	
                                        	}
                                        	
											if ($row_rsVENDOR["incdays"] >= $mdate) {
                                            	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                        	}
                                     	}
                                	}
                            	}	
							} else {/////////////////////////////////////
								$result_rsbrn_mas =mysqli_query($GLOBALS['dbinv'],$rsbrn_mas);
								if($row_rsbrn_mas = mysqli_fetch_array($result_rsbrn_mas)){
                                	if ($row_rsbrn_mas["delinrate"] == 2.5) {
                                    	if (is_null($row_rssalma["Deli_date"])==false) {
                                       		if (is_null($row_rssalma["st_chdate"])==false) {
												$date1 = $row_rssalma["st_chdate"];
												$date2 = $row_rssalma["Deli_date"];
												$diff = abs(strtotime($date2) - strtotime($date1));
												$mdate = floor($diff / (60*60*24));
                                           		
                                       		} else {
												$date1 = $row_rssalma["ST_DATE"];
												$date2 = $row_rssalma["Deli_date"];
												$diff = abs(strtotime($date2) - strtotime($date1));
												$mdate = floor($diff / (60*60*24));
                                           			
                                       		}
                                       		if ($row_rsVENDOR["incdays"] == 90) {
                                            	if ($row_rssalma["cre_pe"] > 90) {
                                                	if ($row_rssalma["cre_pe"] >= $mdate) {
                                                    	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	}
                                            	} else {
                                                	if ($row_rsVENDOR["incdays"] >= $mdate) {
                                                    	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	}
                                            	}
                                        	} else {
                                            	if ($row_rssalma["cre_pe"] != 65) {
                                                	if ($row_rssalma["cre_pe"] >= $mdate) {
                                                    	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	}
                                            	} else {
                                                	if ($row_rsVENDOR["incdays"] >= $mdate) {
                                                    	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	}
                                            	}
                                        	}
                                    	} else {
                                       		if (is_null($row_rssalma["st_chdate"])==false) {
												$date1 = $row_rssalma["st_chdate"];
												$date2 = $row_rssalma["SDATE"];
												$diff = abs(strtotime($date2) - strtotime($date1));
												$mdate = floor($diff / (60*60*24));
                                           		
                                       		} else {
												$date1 = $row_rssalma["ST_DATE"];
												$date2 = $row_rssalma["SDATE"];
												$diff = abs(strtotime($date2) - strtotime($date1));
												$mdate = floor($diff / (60*60*24));
                                           		
                                       		}
                                       		
											if ($row_rsVENDOR["incdays"] == 90) {
                                            	if ($row_rssalma["cre_pe"] > 90) {
                                                	if ($row_rssalma["cre_pe"] >= $mdate) {
                                                    	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	}
                                            	} else {
                                                	if ($row_rsVENDOR["incdays"] >= $mdate) {
                                                    	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	}
                                            	}
                                        	} else {
                                            	if ($row_rssalma["cre_pe"] != 65) {
                                                	if ($row_rssalma["cre_pe"] >= $mdate) {
                                                    	$mpay = $mpay + $row_rssalma["ST_PAID"];
                                                	}
                                            	} else {
                                                	if ($row_rssalma["cre_pe"] >= $mdate) {
                                                    	$mpay = $mpay + $row_rssalma["ST_PAID"];
													}	
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
						if ((date("m", strtotime($_GET["DTPicker1"])) >= 1) and (date("Y", strtotime($_GET["DTPicker1"])) > 2010)) {
                        	$result_rsbrn_mas =mysqli_query($GLOBALS['dbinv'],$rsbrn_mas);
							if($row_rsbrn_mas = mysqli_fetch_array($result_rsbrn_mas)){
								if($row_rsbrn_mas["delinrate"] == 3.5){
							
                                	if (is_null($row_rssalma["Deli_date"])==false) {
                                   		if (is_null($row_rssalma["st_chdate"])==false) {
                                       		$date1 = $row_rssalma["st_chdate"];
											$date2 = $row_rssalma["Deli_date"];
											$diff = abs(strtotime($date2) - strtotime($date1));
											$mdate = floor($diff / (60*60*24));
											
                                   		} else {
											$date1 = $row_rssalma["ST_DATE"];
											$date2 = $row_rssalma["Deli_date"];
											$diff = abs(strtotime($date2) - strtotime($date1));
											$mdate = floor($diff / (60*60*24));
                                       		
                                   		}
                                   		if ($row_rsVENDOR["incdays"] == 90) {
                                        	if ($row_rssalma["cre_pe"] > 90) {
                                            	if ($row_rssalma["cre_pe"] >= $mdate) {
                                                	$mpay_bat = $mpay_bat + $row_rssalma["ST_PAID"];
                                            	}
                                        	} else {
                                            	if ($row_rsVENDOR["incdays"] >= $mdate) {
                                                	$mpay_bat = $mpay_bat + $row_rssalma["ST_PAID"];
                                            	}
                                        	}
                                    	} else {
                                        	if ($row_rssalma["cre_pe"] != 65) {
                                            	if ($row_rssalma["cre_pe"] >= $mdate) {
                                                	$mpay_bat = $mpay_bat + $row_rssalma["ST_PAID"];
                                            	}
                                        	} else {
                                            	if (75 >= $mdate) {
                                                	$mpay_bat = $mpay_bat + $row_rssalma["ST_PAID"];
                                            	}
                                        	}
                                    	}
                                	} else {
                                   		if (is_null($row_rssalma["st_chdate"])==false) {
											$date1 = $row_rssalma["st_chdate"];
											$date2 = $row_rssalma["SDATE"];
											$diff = abs(strtotime($date2) - strtotime($date1));
											$mdate = floor($diff / (60*60*24));
                                       		
                                   		} else {
											$date1 = $row_rssalma["ST_DATE"];
											$date2 = $row_rssalma["SDATE"];
											$diff = abs(strtotime($date2) - strtotime($date1));
											$mdate = floor($diff / (60*60*24));
                                       		
                                   		}
                                   		if ($row_rsVENDOR["incdays"] == 90) {
                                        	if ($row_rssalma["cre_pe"] > 90) {
                                            	if ($row_rssalma["cre_pe"] >= $mdate) {
                                                	$mpay_bat = $mpay_bat + $row_rssalma["ST_PAID"];
                                            	}
                                        	} else {
                                            	if ($row_rsVENDOR["incdays"] >= $mdate) {
                                                	$mpay_bat = $mpay_bat + $row_rssalma["ST_PAID"];
                                            	}
                                        	}
                                    	} else {
                                        	if ($row_rssalma["cre_pe"] != 65) {
                                            	if ($row_rssalma["cre_pe"] >= $mdate) {
                                                	$mpay_bat = $mpay_bat + $row_rssalma["ST_PAID"];
                                            	}
                                        	} else {
                                            	if (75 >= $mdate) {
                                                	$mpay_bat = $mpay_bat + $row_rssalma["ST_PAID"];
                                            	}
                                        	}
                                    	}
                                	}
                            	}
                        	}
                        }
						
						$result_rsbrn_mas =mysqli_query($GLOBALS['dbinv'],$rsbrn_mas);
						if($row_rsbrn_mas = mysqli_fetch_array($result_rsbrn_mas)){
                        	if ($row_rsbrn_mas["delinrate"] == 4.5) {
                                if (is_null($row_rssalma["Deli_date"])==false) {
                                   if (is_null($row_rssalma["st_chdate"])==false) {
								   		$date1 = $row_rssalma["st_chdate"];
										$date2 = $row_rssalma["Deli_date"];
										$diff = abs(strtotime($date2) - strtotime($date1));
										$mdate = floor($diff / (60*60*24));
                                      
                                   } else {
								   		$date1 = $row_rssalma["ST_DATE"];
										$date2 = $row_rssalma["Deli_date"];
										$diff = abs(strtotime($date2) - strtotime($date1));
										$mdate = floor($diff / (60*60*24));
                                       
                                   }
                                   if ($row_rsVENDOR["incdays"] == 90) {
                                        if ($row_rssalma["cre_pe"] > 90) {
                                            if ($row_rssalma["cre_pe"] >= $mdate) {
                                                $mpay_tube = $mpay_tube + $row_rssalma["ST_PAID"];
                                            }
                                        } else {
                                            if ($row_rsVENDOR["incdays"] >= $mdate) {
                                                $mpay_tube = $mpay_tube + $row_rssalma["ST_PAID"];
                                            }
                                        }
                                    } else {
                                        if ($row_rssalma["cre_pe"] != 65) {
                                            if ($row_rssalma["cre_pe"] >= $mdate) {
                                                $mpay_tube = $mpay_tube + $row_rssalma["ST_PAID"];
                                            }
                                        } else {
                                            if (75 >= $mdate) {
                                                $mpay_tube = $mpay_tube + $row_rssalma["ST_PAID"];
                                            }
                                        }
                                    }
                                } else {
                                   if (is_null($row_rssalma["st_chdate"])==false) {
								   		$date1 = $row_rssalma["st_chdate"];
										$date2 = $row_rssalma["SDATE"];
										$diff = abs(strtotime($date2) - strtotime($date1));
										$mdate = floor($diff / (60*60*24));
                                       
                                   } else {
								   		$date1 = $row_rssalma["ST_DATE"];
										$date2 = $row_rssalma["SDATE"];
										$diff = abs(strtotime($date2) - strtotime($date1));
										$mdate = floor($diff / (60*60*24));
                                      
                                   }
                                   if ($row_rsVENDOR["incdays"] == 90) {
                                        if ($row_rssalma["cre_pe"] > 90) {
                                            if ($row_rssalma["cre_pe"] >= $mdate) {
                                                $mpay_tube = $mpay_tube + $row_rssalma["ST_PAID"];
                                            }
                                        } else {
                                            if ($row_rsVENDOR["incdays"] >= $mdate) {
                                                $mpay_tube = $mpay_tube + $row_rssalma["ST_PAID"];
                                            }
                                        }
                                    } else {
                                        if ($row_rssalma["cre_pe"] != 65) {
                                            if ($row_rssalma["cre_pe"] >= $mdate) {
                                                $mpay_tube = $mpay_tube + $row_rssalma["ST_PAID"];
                                            }
                                        } else {
                                            if (75 >= $mdate) {
                                                $mpay_tube = $mpay_tube + $row_rssalma["ST_PAID"];
                                            }
                                        }
                                    }
                                }
                            }
						}
                    }
                    
                    $mpay = $mpay / 1.12;
                    $mpay_50 = $mpay_50 / 1.12;
                    $m_pay_ut = $m_pay_ut / 1.12;
                    $mpay_bat = $mpay_bat / 1.12;
                    $mpay_tube = $mpay_tube / 1.12;
                    
					$date1 = $_GET["ddate"];
					$date2 = $_GET["DTPicker1"];
					$diff = abs(strtotime($date2) - strtotime($date1));
					$mdate = floor($diff / (60*60*24));
                    if ($mdate > 0) {
                        if (is_null($salret)==false) {
                            if ($mpay > 0) {
                                $mpay = $mpay - $mret;
                            } else {
                                $mpay_50 = $mpay_50 - $mret;
                            }
                        }
                        if (is_null($salret_bat)==false) {
                            $mpay_bat = $mpay_bat - $mret_bat;
                        }
                        if (is_null($salret_tube)==false) {
                            $mpay_tube = $mpay_tube - $mret_tube;
                        }
                        $sql_rsper1= "Select * from intper where incen_year = 20101 and traget < '" . ($mpay + $mpay_50 + $m_pay_ut) . "' order by traget desc ";
						$result_rsper1 =mysqli_query($GLOBALS['dbinv'],$sql_rsper1);
						$row_rsper1 = mysqli_fetch_array($result_rsper1);
						
						$result_rsper1 =mysqli_query($GLOBALS['dbinv'],$sql_rsper1);
						$count_rsper1 = mysqli_num_rows($result_rsper1);
						
                        $sql_rsper1_50 = "Select * from intper where incen_year = 20112 and traget < '" . ($mpay + $mpay_50 + $m_pay_ut) . "' order by traget desc ";
						$result_rsper1_50 =mysqli_query($GLOBALS['dbinv'],$sql_rsper1_50);
						$row_rsper1_50 = mysqli_fetch_array($result_rsper1_50);
						
						$result_rsper1_50 =mysqli_query($GLOBALS['dbinv'],$sql_rsper1_50);
						$count_rsper1_50 = mysqli_num_rows($result_rsper1_50);
							
                        if (($count_rsper1 > 0) or ($count_rsper1_50 > 0)) {
							
							if ($c_mpay > 0) {
                                if (($count_rsper1 > 0) or ($count_rsper1_50 > 0)) { 
									$tyre_inc = $mpay * ($row_rsper1["per"] / 100) + $m_pay_ut * ($row_rs["per1"] / 100) + $mpay_50 * ($row_rsper1_50["per"] / 100);
								}	
                            } else {
                                if (($count_rsper1 > 0) or ($count_rsper1_50 > 0)) {  
									$tyre_inc = $mpay * (($row_rsper1["per"] / 100)) + $m_pay_ut * ($row_rsper1_50["per"] / 100) + $mpay_50 * ($row_rsper1_50["per"] / 100);
								}	
                            }
							
							$limit = $mpay + $mpay_50 + $m_pay_ut;
							
							$target_a=0;
							$target_bat_a=0;
							
							$sql_rsIncen = "select * from ins_payment where  I_month ='" . date("m", strtotime($_GET["DTPicker1"])) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCODE = '" . trim($row_rsVENDOR["CODE"]) . "' order by id ";
							$result_rsIncen =mysqli_query($GLOBALS['dbinv'],$sql_rsIncen);
							while($row_rsIncen = mysqli_fetch_array($result_rsIncen)){
                            
                                if (is_null($row_rsIncen["Type"])==false) {
                                    if ($row_rsIncen["Type"] == "Tyre") {
                                        $target_a = $row_rsIncen["amount"];
                                    } else {
                                        $target_bat_a = $row_rsIncen["amount"];
                                    }
                                } else {
                                    if ($bat_inc < 0) {
                                        $target_a = $row_rsIncen["amount"];
                                    }
                                }
                                
                            }
							
							$sql_dealer = "insert into dealer_inc(cus_code, cus_name, month2, month3, tyre_inc, limit, target, target_bat, c_type) values ('".$row_rsVENDOR["CODE"]."', '".$row_rsVENDOR["CUS_NAME"]."', ".$mret.", ".$tyre_inc.", ".$tyre_inc.", ".$limit.", ".$target_a.", ".$target_bat_a.", 'Tyre')";
							$result_dealer =mysqli_query($GLOBALS['dbinv'],$sql_dealer);
					
                        }
						
                        if (is_null($mpay_bat)==false) {
                            if ((date("m", strtotime($_GET["DTPicker1"])) > 5) or (date("Y", strtotime($_GET["DTPicker1"])) >= 2011)) {
                                $sql_rsper1_bat = "Select * from intper where incen_year = 20111 and traget < '" . $mpay_bat . "' order by traget desc ";
                            } else {
                                $sql_rsper1_bat = "Select * from intper where incen_year = 2011 and traget < '" . $mpay_bat . "' order by traget desc ";
                            }
                        }
						
						$result_rsper1_bat =mysqli_query($GLOBALS['dbinv'],$sql_rsper1_bat);
						if($row_rsper1_bat = mysqli_fetch_array($result_rsper1_bat)){
                        	
							 $bat_inc = $mpay_bat * ($row_rsper1_bat["per"] / 100);
							 
							
							$sql_rsIncen = "select * from ins_payment where  I_month ='" . date("m", strtotime($_GET["DTPicker1"])) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($row_rsVENDOR["CODE"]) . "'order by id ";
                            $result_rsIncen =mysqli_query($GLOBALS['dbinv'],$sql_rsIncen);
							while($row_rsIncen = mysqli_fetch_array($result_rsIncen)){
                                if (is_null($row_rsIncen["Type"])==false) {
                                    if ($row_rsIncen["Type"] == "Tyre") {
                                        $target_a = $row_rsIncen["amount"];
                                    } else {
                                        $target_bat_a = $row_rsIncen["amount"];
                                    }
                                } else {
                                    if ($bat_inc < 0) {
                                        $target_a = $row_rsIncen["amount"];
                                    }
                                }
                                
                            }
							 
							$sql_dealer = "insert into dealer_inc(cus_code, cus_name, month1, month3, battery_inc, battery, target, target_bat, c_type) values ('".$row_rsVENDOR["CODE"]."', '".$row_rsVENDOR["CUS_NAME"]."', ".$mpay_bat.", ".$bat_inc.", ".$bat_inc.", ".$mpay_bat.", ".$target_a.", ".$target_bat_a.", 'Battery')";
							$result_dealer =mysqli_query($GLOBALS['dbinv'],$sql_dealer);
							
                      
                        }
						
                        if (is_null($mpay_tube)==false) {
                            $sql_rsper1_tube= "Select * from intper where incen_year = 2012 and traget < '" . $mpay_tube . "' order by traget desc ";
                        }
						$result_rsper1_tube =mysqli_query($GLOBALS['dbinv'],$sql_rsper1_tube);
						if($row_rsper1_tube = mysqli_fetch_array($result_rsper1_tube)){
                        	
							$tube_inc = $mpay_tube * ($row_rsper1_tube["per"] / 100);
							
							$sql_rsIncen = "select * from ins_payment where  I_month ='" . date("m", strtotime($_GET["DTPicker1"])) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($row_rsVENDOR["CODE"]) . "'order by id ";
                            $result_rsIncen =mysqli_query($GLOBALS['dbinv'],$sql_rsIncen);
							while($row_rsIncen = mysqli_fetch_array($result_rsIncen)){
							
                                if (is_null($row_rsIncen["Type"])==false) {
                                    if ($row_rsIncen["Type"] == "Tyre") {
                                        $target_a = $row_rsIncen["amount"];
                                    } else {
                                        $target_bat_a = $row_rsIncen["amount"];
                                    }
                                } else {
                                    if ($tube_inc < 0) {
                                        $target_a = $row_rsIncen["amount"];
                                    }
                                }
                                
                            }
							
							$sql_dealer = "insert into dealer_inc(cus_code, cus_name, month1, month3, battery_inc, tube, target, target_bat, c_type) values ('".$row_rsVENDOR["CODE"]."', '".$row_rsVENDOR["CUS_NAME"]."', ".$mpay_tube.", ".$tube_inc.", ".$tube_inc.", ".$mpay_tube.", ".$target_a.", ".$target_bat_a.", 'Tube')";
							$result_dealer =mysqli_query($GLOBALS['dbinv'],$sql_dealer);
							
                      	}
                        
                   	} else {
					 
                         if (is_null($salret)==false) {
                            $msal = $msal - $mret;  
                            $mpay = $mpay - $mret;
                         }
                         if (is_null($salret_bat)==false) {
                            $mpay_bat = $mpay_bat - $mret_bat;
                         }
                         if (is_null($salret_tube)==false) {
                            $mpay_tube = $mpay_tube - $mret_tube;
                         }
                         if (date("Y", strtotime($_GET["DTPicker1"])) < 2010) {
                            $sql_rsper1 = "Select * from intper where incen_year = 2009 and traget < '" . $mpay . "' order by traget desc ";
                         } else {
                            if ((date("m", strtotime($_GET["DTPicker1"])) > 10) or (date("Y", strtotime($_GET["DTPicker1"])) >= 2010)) {
                                $sql_rsper1 = "Select * from intper where incen_year = 20101 and traget < '" . $mpay . "' order by traget desc ";
                            } else {
                                $sql_rsper1 = "Select * from intper where incen_year = 2010 and traget < '" . $mpay . "' order by traget desc ";
                            }
                         }
                         
                         if (is_null($mpay_bat)==false) {
                            if ((date("m", strtotime($_GET["DTPicker1"])) > 5) or (date("Y", strtotime($_GET["DTPicker1"])) >= 2011)) {
                                $sql_rsper1_bat = "Select * from intper where incen_year = 20111 and traget < '" . $mpay_bat . "' order by traget desc ";
                            } else {
                                $sql_rsper1_bat = "Select * from intper where incen_year = 2011 and traget < '" . $mpay_bat . "' order by traget desc ";
                            }
                         }
                         if (is_null(mpay_tube)==false) {
                            $sql_rsper1_tube= "Select * from intper where incen_year = 2012 and traget < '" . $mpay_tube . "' order by traget desc ";
                         }
						 $result_rsper1 =mysqli_query($GLOBALS['dbinv'],$sql_rsper1);
						 if($row_rsper1 = mysqli_fetch_array($result_rsper1)){
                         	
							$tyre_inc = $mpay * (($row_rsper1["per"] / 100));
							
							$sql_rsIncen = "select * from ins_payment where  I_month ='" . date("m", strtotime($_GET["DTPicker1"])) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($row_rsVENDOR["CODE"]) . "'order by id ";
                            $result_rsIncen =mysqli_query($GLOBALS['dbinv'],$sql_rsIncen);
							while($row_rsIncen = mysqli_fetch_array($result_rsIncen)){
                                if (is_null($row_rsIncen["Type"])==false) {
                                    if ($row_rsIncen["Type"] == "Tyre") {
                                        $target_a = $row_rsIncen["amount"];
                                    } else {
                                        $target_bat_a = $row_rsIncen["amount"];
                                    }
                                } else {
                                    if ($bat_inc < 0) {
                                        $target_a = $row_rsIncen["amount"];
                                    }
                                }
                            }
							
							$sql_dealer = "insert into dealer_inc(cus_code, cus_name, month2, month3, tyre_inc, limit, target, target_bat, c_type) values ('".$row_rsVENDOR["CODE"]."', '".$row_rsVENDOR["CUS_NAME"]."', ".$mret.", ".$tyre_inc.", ".$tyre_inc.", ".$mpay.", ".$target_a.", ".$target_bat_a.", 'Tyre')";
							$result_dealer =mysqli_query($GLOBALS['dbinv'],$sql_dealer);
							
                           
                         }
                         
                         $result_rsper1_bat =mysqli_query($GLOBALS['dbinv'],$sql_rsper1_bat);
						 if($row_rsper1_bat = mysqli_fetch_array($result_rsper1_bat)){   
						 	
							 $bat_inc = $mpay_bat * ($row_rsper1_bat["per"] / 100);
							 
							 $sql_rsIncen = "select * from ins_payment where  I_month ='" . date("m", strtotime($_GET["DTPicker1"])) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($row_rsVENDOR["CODE"]) . "'order by id ";
                             $result_rsIncen =mysqli_query($GLOBALS['dbinv'],$sql_rsIncen);
							 while($row_rsIncen = mysqli_fetch_array($result_rsIncen)){
                                if (is_null($row_rsIncen["Type"])==false) {
                                    if ($row_rsIncen["Type"] == "Tyre") {
                                        $target_a = $row_rsIncen["amount"];
                                    } else {
                                        $target_bat_a = $row_rsIncen["amount"];
                                    }
                                } else {
                                    if ($bat_inc < 0) {
                                        $target_a = $row_rsIncen["amount"];
                                    }
                                }
                                
                            }
							
						 	$sql_dealer = "insert into dealer_inc(cus_code, cus_name, month1, month3, battery_inc, battery, target, target_bat, c_type) values ('".$row_rsVENDOR["CODE"]."', '".$row_rsVENDOR["CUS_NAME"]."', ".$mpay_bat.", ".$bat_inc.", ".$bat_inc.", ".$mpay_bat.", ".$target_a.", ".$target_bat_a.", 'Battery')";
							$result_dealer =mysqli_query($GLOBALS['dbinv'],$sql_dealer);
							
                           
                        }
                         
                        $result_rsper1_tube =mysqli_query($GLOBALS['dbinv'],$sql_rsper1_tube);
						if($row_rsper1_tube = mysqli_fetch_array($result_rsper1_tube)){   
                             
							$tube_inc = $mpay_tube * ($row_rsper1_tube["per"] / 100);
							
							$sql_rsIncen = "select * from ins_payment where  I_month ='" . date("m", strtotime($_GET["DTPicker1"])) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($row_rsVENDOR["CODE"]) . "'order by id ";
                            $result_rsIncen =mysqli_query($GLOBALS['dbinv'],$sql_rsIncen);
							while($row_rsIncen = mysqli_fetch_array($result_rsIncen)){
							
                                if (is_null($row_rsIncen["Type"])==false) {
                                    if ($row_rsIncen["Type"] == "Tyre") {
                                        $target_a = $row_rsIncen["amount"];
                                    } else {
                                        $target_bat_a = $row_rsIncen["amount"];
                                    }
                                } else {
                                    if ($tube_inc < 0) {
                                        $target_a = $row_rsIncen["amount"];
                                    }
                                }
                                
                            }
							
							$sql_dealer = "insert into dealer_inc(cus_code, cus_name, month1, month3, battery_inc, tube, target, target_bat, c_type) values ('".$row_rsVENDOR["CODE"]."', '".$row_rsVENDOR["CUS_NAME"]."', ".$mpay_tube.", ".$tube_inc.", ".$tube_inc.", ".$mpay_tube.", ".$target_a.", ".$target_bat_a.", 'Tube')";
							$result_dealer =mysqli_query($GLOBALS['dbinv'],$sql_dealer); 
                           
                           
                        }
                            
                        
                    }
                }
        	}
        }
        
    
    
		if ($_GET["cmbrep"] == "") {
    
    		$mrow3 = 1;
			$sql_tmp2 = "select * from dealer_inc ";
			$result_tmp2 =mysqli_query($GLOBALS['dbinv'],$sql_tmp2);
			while($row_tmp2= mysqli_fetch_array($result_tmp2)){
		    
	        	if (is_null($row_tmp2["cus_code"]) == false) { $Flexcus[$mrow3][1] = trim($row_tmp2["cus_code"]); }
		        if (is_null($row_tmp2["cus_name"]) == false) { $Flexcus[$mrow3][2] = trim($row_tmp2["cus_name"]); }
		        if (is_null($row_tmp2["limit"]) == false) { $Flexcus[$mrow3][3] = $row_tmp2["limit"]; }
		        if (is_null($row_tmp2["battery"]) == false) { $Flexcus[$mrow3][4] = $row_tmp2["battery"]; }
		        if (is_null($row_tmp2["tube"]) == false) { $Flexcus[$mrow3][5] = $row_tmp2["tube"]; }
		        if (is_null($row_tmp2["month3"]) == false) { $Flexcus[$mrow3][6] = $row_tmp2["month3"]; }
		        if (is_null($row_tmp2["id"]) == false) { $Flexcus[$mrow3][8] = $row_tmp2["id"]; }
	    	    $mrow3 = $mrow3 + 1;
	        	
	    	}
		} else {
    
    
    		$mrow2 = 1;
			$sql_tmp2 = "select * from dealer_inc";
		    $result_tmp2 =mysqli_query($GLOBALS['dbinv'],$sql_tmp2);
			while($row_tmp2= mysqli_fetch_array($result_tmp2)){
		        if (is_null($row_tmp2["cus_code"]) == false) { $Flexcus[$mrow2][1] = trim($row_tmp2["cus_code"]); }
		        if (is_null($row_tmp2["cus_name"]) == false) { $Flexcus[$mrow2][2] = trim($row_tmp2["cus_name"]); }
		        if (is_null($row_tmp2["limit"]) == false) { $Flexcus[$mrow2][3] = $row_tmp2["limit"]; }
		        if (is_null($row_tmp2["month1"]) == false) { $Flexcus[$mrow2][4] = $row_tmp2["month1"]; }
	        	if (is_null($row_tmp2["Month3"]) == false) { $Flexcus[$mrow2][5] = $row_tmp2["month3"]; }
	        	if ($row_tmp2["target"] > 0) { $Flexcus[$mrow2][6] == "Yes"; }
		    
				$sql_rsIncen = "select * from ins_payment where  I_month ='" . date("m", strtotime($_GET["DTPicker1"])) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($row_tmp2["cusCode"]) . "'order by id ";
       	 		$result_rsIncen =mysqli_query($GLOBALS['dbinv'],$sql_rsIncen);
				if($row_rsIncen= mysqli_fetch_array($result_rsIncen)){
            		$Flexcus[$mrow2][7] = $row_rsIncen["remarks"];
        		}
        
        		$mrow2 = $mrow2 + 1;
			}	
        
    	}
		
 	}
	} else {
    ////////// test() //////////////////////////////////////////////////////////
	
	
		$sql_tmp = "select * from dealer_inc ";

  		$sql_rssales = "Select C_CODE, delinrate, sum(GRAND_TOT) as sale, sum(GRAND_TOT-TOTPAY) as out1 from  view_s_salma_brand_mas where month(SDATE) = '" . date("m", strtotime($_GET["DTPicker1"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["DTPicker1"])) . "' and CANCELL = '0' and delinrate != '0' and delinrate != '4.5' group by C_CODE, delinrate order by C_CODE, delinrate ";
		
  		$result_rssales =mysqli_query($GLOBALS['dbinv'],$sql_rssales);
  		while($row_rssales= mysqli_fetch_array($result_rssales)){
		
    		if (trim($row_rssales["C_CODE"]) == "M68") {
        		$X = 1;
    		}
    		$Out = "No";
    		$out_b = "No";
    		if ($row_rssales["delinrate"] == 2.5) {
        		if ($row_rssales["Out1"] < 50) { $Out = "Ok"; }
    		} else {
        		if ($row_rssales["Out1"] < 50) { $out_b = "Ok"; }
    		}
    		$ret = 0;
	    	$ret_b = 0;
	    	$mpay = 0;
	    	$mpay_b = 0;
	    	$mdays = 0;
	    	$mpay_50 = 0;
	    	$cnt = 0;
	    	if ($row_rssales["delinrate"] == 2.5) { $sql_rs_per = "Select * from intper where incen_year = '20101' order by traget"; }
	    	if ($row_rssales["delinrate"] == 3.5) { $sql_rs_per = "Select * from intper where incen_year = '20111' order by traget"; }
	
			$result_rs_per =mysqli_query($GLOBALS['dbinv'],$sql_rs_per);
    		$row_rs_per= mysqli_fetch_array($result_rs_per);
  
	    	if (($row_rssales["sale"] > $row_rs_per["traget"]) and ($Out == "Ok") or ($out_b == "Ok")) {
	        	
				if ($row_rssales["delinrate"] == 2.5) { $sql_rs1 = "Select sum(AMOUNT) as rtn from  view_cbal_brand where CUSCODE = '" . trim($row_rssales["C_CODE"]) . "' and month(SDATE) = '" . date("m", strtotime($_GET["DTPicker1"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["DTPicker1"])) . "' and Cancell = '0' and delinrate = '2.5' AND trn_type != 'ARN' and trn_type != 'REC' and trn_type != 'DGRN' and flag1 != '1' ";
				}
	        	if ($row_rssales["delinrate"] == 3.5) { $sql_rs1 = "Select sum(AMOUNT) as rtn from  view_cbal_brand where CUSCODE = '" . trim($row_rssales["C_CODE"]) . "' and month(SDATE) = '" . date("m", strtotime($_GET["DTPicker1"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["DTPicker1"])) . "' and Cancell = '0' and delinrate = '3.5' AND trn_type != 'ARN' and trn_type != 'REC' and trn_type != 'DGRN' and flag1 != '1' ";
				}
		
				$result_rs1 =mysqli_query($GLOBALS['dbinv'],$sql_rs1);
	    		$row_rs1= mysqli_fetch_array($result_rs1);
	
    	    	if ($row_rssales["delinrate"] == 2.5) { 
					if (is_null($row_rs1["rtn"])==false) { 
						$ret = $row_rs1["rtn"]; 
					}
				}
	    	    if ($row_rssales["delinrate"] == 3.5) { 
					if (is_null($row_rs1["rtn"])==false) { 
						$ret_b = $row_rs1["rtn"]; 
					}
				}
	        
	    	    if ($row_rssales["delinrate"] == 2.5) { 
					$sql_rssalma = "Select * from view_salma_sttr_brand where C_CODE = '" . trim($row_rssales["C_CODE"]) . "' and delinrate = '2.5' and cancell = '0' and month(SDATE) = '" . date("m", strtotime($_GET["DTPicker1"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["DTPicker1"])) . "' and deliin_amo <= '0' and deliin_lock = '0' and totpay1 = '1' ";
				}
	      	  	if ($row_rssales["delinrate"] == 3.5) { 
					$sql_rssalma = "Select * from view_salma_sttr_brand where C_CODE = '" . trim($row_rssales["C_CODE"]) . "' and delinrate = '3.5' and cancell = '0' and month(SDATE) = '" . date("m", strtotime($_GET["DTPicker1"])) . "' and year(SDATE) = '" . date("Y", strtotime($_GET["DTPicker1"])) . "' and deliin_amo <= '0' and deliin_lock = '0' and totpay1 = '1' ";
	        	}
		
				$sql_rsVENDOR = "Select * from vendor where CODE = '" . trim($row_rssales["C_CODE"]) . "'";
		        $result_rsVENDOR =mysqli_query($GLOBALS['dbinv'],$sql_rsVENDOR);
		    	$row_rsVENDOR= mysqli_fetch_array($result_rsVENDOR);
		
				$result_rssalma =mysqli_query($GLOBALS['dbinv'],$sql_rssalma);
		    	while($row_rssalma= mysqli_fetch_array($result_rssalma)){
			
	        	    if (($row_rssales["delinrate"] == 2.5) and ($Out == "Ok")) {
		                if (is_null($row_rssalma["DELI_DATE"])==false) {
		                    if (is_null($row_rssalma["ST_CHDATE"])==false) {
		                        $mdays = $row_rssalma["ST_CHDATE"] - $row_rssalma["DELI_DATE"];
		                    } else {
		                        $mdays = $row_rssalma["ST_DATE"] - $row_rssalma["DELI_DATE"];
		                    }
		                } else {
		                    if (is_null($row_rssalma["ST_CHDATE"])==false){
		                        $mdays = $row_rssalma["ST_CHDATE"] - $row_rssalma["SDATE"];
		                    } else {
	    	                    $mdays = $row_rssalma["ST_DATE"] - $row_rssalma["SDATE"];
		                    }
		                }
		                if ($row_rsVENDOR["incdays"] > 75) {
		                    if ($row_rssalma["cre_pe"] > $row_rsVENDOR["incdays"]) {
		                        if (($row_rssalma["cre_pe"] >= $mdays) and ($mdays > 50)) {
		                            $mpay = $mpay + $row_rssalma["ST_PAID"];
		                            $cnt = $cnt + 1;
		                        } else {
		                            if ($mdays <= 50) {
		                                if ($row_rssalma["ST_FLAG"] == "UT") {
		                                    $mpay = $mpay + $row_rssalma["ST_PAID"];
		                                } else {
		                                    $mpay_50 = $mpay_50 + $row_rssalma["ST_PAID"];
		                                }
		                            }
		                        }
		                    } else {
		                        if (($row_rsVENDOR["incdays"] >= $mdays) and ($mdays > 50)) {
		                            $mpay = $mpay + $row_rssalma["ST_PAID"];
		                            $cnt = $cnt + 1;
		                        } else {
		                            if ($mdays <= 50) {
		                                if ($row_rssalma["ST_FLAG"] == "UT") {
	    	                                $mpay = $mpay + $row_rssalma["ST_PAID"];
		                                } else {
		                                    $mpay_50 = $mpay_50 + $row_rssalma["ST_PAID"];
		                                }
		                            }
		                        }
		                    }
		                } else {
	    	                if (($mdays <= 75) and ($mdays > 50)) {
	        	                $mpay = $mpay + $row_rssalma["ST_PAID"];
	            	            $cnt = $cnt + 1;
	                	    } else {
	                    	    if ($mdays <= 50) {
	                        	    if ($row_rssalma["ST_FLAG"] == "UT") {
	                            	    $mpay = $mpay + $row_rssalma["ST_PAID"];
		                            } else {
		                                $mpay_50 = $mpay_50 + $row_rssalma["ST_PAID"];
		                            }
		                        }
		                    }
		                }
	    	        } else {
	               	 	if ($out_b == "Ok") {
	                    	if (is_null($row_rssalma["DELI_DATE"])==false) {
	                        	if (is_null($row_rssalma["ST_CHDATE"])==false) {
		                            $mdays = $row_rssalma["ST_CHDATE"] - $row_rssalma["DELI_DATE"];
		                        } else {
		                            $mdays = $row_rssalma["ST_DATE"] - $row_rssalma["DELI_DATE"];
		                        }
		                    } else {
		                        if (is_null($row_rssalma["ST_CHDATE"])==false) {
		                            $mdays = $row_rssalma["ST_CHDATE"] - $row_rssalma["SDATE"];
		                        } else {
		                            $mdays = $row_rssalma["ST_DATE"] - $row_rssalma["SDATE"];
		                        }
		                    }
		                    if ($row_rsVENDOR["incdays"] > 75) {
	    	                    if ($row_rssalma["cre_pe"] > $row_rsVENDOR["incdays"]) {
		                            if ($row_rssalma["cre_pe"] >= $mdays) { $mpay_b = $mpay_b + $row_rssalma["ST_PAID"]; }
		                        } else {
		                            if ($row_rsVENDOR["incdays"] >= $mdays) { $mpay_b = $mpay_b + $row_rssalma["ST_PAID"]; }
		                        }
		                    } else {
		                        if ($mdays <= 75) { $mpay_b = $mpay_b + $row_rssalma["ST_PAID"]; }
		                    }
		                }
		            }
				}
	        	
				if (($mpay > 0) or ($mpay_50 > 0) or ($mpay_b > 0)) {
	            	if ($mpay > 0) {
    	            	$mpay = $mpay - $ret;
	            	} else {
	                	$mpay_50 = $mpay_50 - $ret;
	            	}
	            	$mpay_b = $mpay_b - $ret_b;
	            
	            	$mpay = $mpay / 1.12;
	            	$mpay_50 = $mpay_50 / 1.12;
	            	$mpay_b = $mpay_b / 1.12;
	            
	            
		            	$sql_rsper = "Select * from intper where traget <= '" . ($mpay + $mpay_50) . "' and incen_year = '20101' order by traget desc";
					$result_rsper =mysqli_query($GLOBALS['dbinv'],$sql_rsper);
    		    	$row_rsper= mysqli_fetch_array($result_rsper);
			
					$result_rsper =mysqli_query($GLOBALS['dbinv'],$sql_rsper);
	    	    	$count_rsper= mysqli_num_rows($result_rsper);
			
	    	        $sql_rsper_50 = "Select * from intper where traget <= '" . ($mpay + $mpay_50) . "' and incen_year = '20112' order by traget desc";
					$result_rsper_50 =mysqli_query($GLOBALS['dbinv'],$sql_rsper_50);
			   	   	$row_rsper_50= mysqli_fetch_array($result_rsper_50);
				
					$result_rsper_50 =mysqli_query($GLOBALS['dbinv'],$sql_rsper_50);
		    	    $count_rsper_50= mysqli_num_rows($result_rsper_50);
				
		            if (($count_rsper > 0) or ($count_rsper_50 > 0)) {
					
					 	if ($cnt > 0) {
    	                	if (($count_rsper > 0) or ($count_rsper_50 > 0 )){ $tyre_inc = $mpay * (($row_rsper["per"] / 100)) + $mpay_50 * (($row_rsper_50["per"] / 100)); }
	                	} else {
	                    	if (($count_rsper > 0) or ($count_rsper_50 > 0)) { $tyre_inc = $mpay * (($row_rsper_50["per"] / 100)) + $mpay_50 * (($row_rsper_50["per"] / 100)); }
    	            	}
				
					 	$limit = $mpay + $mpay_50;
				 
						$sql_rsIncen = "select * from ins_payment where  I_month ='" . date("m", strtotime($_GET["DTPicker1"])) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($row_rsVENDOR["CODE"]) . "'order by id ";
                		$result_rsIncen =mysqli_query($GLOBALS['dbinv'],$sql_rsIncen);
	    	    		while($row_rsIncen= mysqli_fetch_array($result_rsIncen)){
					
    	                	if (is_null($row_rsIncen["Type"])==false) {
	                        	if ($row_rsIncen["Type"] == "Tyre") {
	                            	$target_a = $row_rsIncen["AMOUNT"];
	                        	} else {
	                            	$target_bat_a = $row_rsIncen["AMOUNT"];
	                        	}
	                    	} else {
    	                    	if ($bat_inc < 0) {
	                            	$target_a = $row_rsIncen["AMOUNT"];
	                        	}
	                    	}
	                	}
				
						$sql_dealer = "insert into dealer_inc(cus_code, cus_name, month2, month3, tyre_inc, limit, target, target_bat, c_type) values ('".$row_rsVENDOR["CODE"]."', '".$row_rsVENDOR["CUS_NAME"]."', ".$ret.", ".$tyre_inc.", ".$tyre_inc.", ".$limit.", ".$target_a.", ".$target_bat_a.", 'Tyre')";
						$result_dealer =mysqli_query($GLOBALS['dbinv'],$sql_dealer); 
							
                
                
        	    	}
            
            		$sql_rsper_b = "Select * from intper where incen_year = 20111 and traget < '" . $mpay_b . "' order by traget desc ";
	           	 	$result_rsper_b =mysqli_query($GLOBALS['dbinv'],$sql_rsper_b);
	    	    	if($row_rsper_b= mysqli_fetch_array($result_rsper_b)){
					
						$bat_inc = $mpay_b * ($row_rsper_b["per"] / 100);
				
						$sql_rsIncen = "select * from ins_payment where  I_month ='" . date("m", strtotime($_GET["DTPicker1"])) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($row_rsVENDOR["CODE"]) . "'order by id ";
	                	$result_rsIncen =mysqli_query($GLOBALS['dbinv'],$sql_rsIncen);
	    	    		while($row_rsIncen= mysqli_fetch_array($result_rsIncen)){
	                    	if (is_null($row_rsIncen["Type"])==false) {
    	                    	if ($row_rsIncen["Type"] == "Tyre") {
        	                    	$target_a = $row_rsIncen["AMOUNT"];
	        	                } else {
		                            $target_bat_a = $row_rsIncen["AMOUNT"];
		                        }
		                    } else {
		                        if ($bat_inc < 0) {
	    	                        $target_a = $row_rsIncen["AMOUNT"];
		                        }
		                    }
		                    
    		            }
					
						$sql_dealer = "insert into dealer_inc(cus_code, cus_name, month1, month3, battery_inc, battery, target, target_bat, c_type) values ('".$row_rsVENDOR["CODE"]."', '".$row_rsVENDOR["CUS_NAME"]."', ".$mpay_b.", ".$bat_inc.", ".$bat_inc.", ".$mpay_b.", ".$target_a.", ".$target_bat_a.", 'Battery')";
						$result_dealer =mysqli_query($GLOBALS['dbinv'],$sql_dealer); 
				
               
	            	}
	            
    	    	}
        
    		} else {
        
  			}
		}    


		if ($_GET["cmbrep"] == "") {
    
    
    		$mrow = 1;
	
			$sql_tmp1 = "select * from dealer_inc where target = 0 or target_bat = 0";
			$result_tmp1 =mysqli_query($GLOBALS['dbinv'],$sql_tmp1);
    		while($row_tmp1= mysqli_fetch_array($result_tmp1)){
    
        		if (is_null($row_tmp1["cus_code"]) == false) { $Flexcus[$mrow][1] = trim($row_tmp1["cus_code"]); }
	        	if (is_null($row_tmp1["cus_name"]) == false) { $Flexcus[$mrow][2] = trim($row_tmp1["cus_name"]); }
	        	if (is_null($row_tmp1["limit"]) == false) { $Flexcus[$mrow][3] = $row_tmp1["limit"]; }
	        	if (is_null($row_tmp1["battery"]) == false) { $Flexcus[$mrow][4] = $row_tmp1["battery"]; }
	        	if (is_null($row_tmp1["tube"]) == false) { $Flexcus[$mrow][5] = $row_tmp1["tube"]; }
	        	if (is_null($row_tmp1["month3"]) == false) { $Flexcus[$mrow][6] = $row_tmp1["month3"]; }
	        	if (is_null($row_tmp1["id"]) == false) { $Flexcus[$mrow][8] = $row_tmp1["id"]; }
	        	$mrow = $mrow + 1;
        
	    	}
		} else {
        
    		$mrow1 = 1;
			$sql_tmp1 = "select * from dealer_inc";
			$result_tmp1 =mysqli_query($GLOBALS['dbinv'],$sql_tmp1);
	    	while($row_tmp1= mysqli_fetch_array($result_tmp1)){
	    
	        	if (is_null($row_tmp1["cus_code"]) == false) { $Flexcus[$mrow1][1] = trim($row_tmp1["cus_code"]); }
	        	if (is_null($row_tmp1["cus_name"]) == false) { $Flexcus[$mrow1][2] = trim($row_tmp1["cus_name"]); }
	        	if (is_null($row_tmp1["limit"]) == false) { $Flexcus[$mrow1][3] = $row_tmp1["limit"]; }
	        	if (is_null($row_tmp1["month1"]) == false) { $Flexcus[$mrow1][4] = $row_tmp1["month1"]; }
	        	if (is_null($row_tmp1["month3"]) == false) { $Flexcus[$mrow1][5] = $row_tmp1["month3"]; }
	       	 	if ($row_tmp1["target"] > 0) { $Flexcus[$mrow2][6] = "Yes"; }
	        
				$sql_rsIncen = "select * from ins_payment where  I_month ='" . date("m", strtotime($_GET["DTPicker1"])) . "'  and I_year='" . date("Y", strtotime($_GET["DTPicker1"])) . "' and cusCode = '" . trim($row_tmp1["cus_code"]) . "'order by id ";
				$result_rsIncen =mysqli_query($GLOBALS['dbinv'],$sql_rsIncen);
	    		if($row_rsIncen= mysqli_fetch_array($result_rsIncen)){
        
    	        	$Flexcus[$mrow2][7] = $row_rsIncen["remarks"];
	        	}
	        
    	    	$mrow1 = $mrow1 + 1;
        
    		}


		}
	}	

}*/
	///////////////////////////////////////////////////////////////////
 

?>