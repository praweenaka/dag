<?php

/*
	include_once("config.inc.php");
	include_once("DBConnector.php");
	$letters = $_GET['letters'];
	
	$sql="SELECT * FROM mast_family where name like '".$letters."%'";
		$result =$db->RunQuery($sql);
			
			
			while($row = mysql_fetch_array($result))
			{
			
			echo $row["name"];
			
			}
			
		*/	
		
		
session_start();


	include_once("connection.php");

if ($_GET["Command"]=="search_custom"){

	//if(isset($_GET['customername'])){
		//$letters = $_GET['customername'];
	//$letters = $_GET['letters'];
	//	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
//	$res = mysql_query("SELECT * FROM mast_family where name like '".$letters."%'") or die(mysql_error());
	
	//$res = mysql_query("SELECT distinct trn_involved.str_name FROM trn_involved where str_name like '".$letters."%'") or die(mysql_error());
		
	
	//SELECT * FROM occupation_details where str_first_name like 'k%'
//echo $res;
	
		$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Supplier No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Supplier Name</font></td>
                             <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Address</font></td>
   							</tr>";
                           
							if ($_GET["mstatus"]=="cusno"){
						   		$letters = $_GET['cusno'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from vendor where CODE like  '$letters%' and CAT<>'X' order by CODE limit 50") or die(mysql_error());
							} else if ($_GET["mstatus"]=="customername"){
								$letters = $_GET['customername'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from vendor where NAME like  '$letters%' and CAT<>'X' order by CODE limit 50") or die(mysql_error()) or die(mysql_error());
							} else {
								
								$letters = $_GET['customername'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from vendor where NAME like  '$letters%' and CAT<>'X' order by CODE limit 50") or die(mysql_error()) or die(mysql_error());
							}
							
													
						
							while($row = mysql_fetch_array($sql)){
								$cuscode = $row["CODE"];
								$stname = $_GET["stname"];
							$ResponseXML .= "<tr>
                              <td onclick=\"suppno('$cuscode', '".$_GET['stname']."');\">".$row['CODE']."</a></td>
                              <td onclick=\"suppno('$cuscode', '".$_GET['stname']."');\">".$row['NAME']."</a></td>
                              <td onclick=\"suppno('$cuscode', '".$_GET['stname']."');\">".$row['ADD2']."</a></td>                          	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
//	}
}


if ($_GET["Command"]=="pass_invno"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
	/*		$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";
							
			
			$sql = mysql_query("select * from inv_data where str_invno='".$_GET['invno']."'") or die(mysql_error());
			while($row = mysql_fetch_array($sql)){
									
				$sql1 = mysql_query("Insert into tmp_inv_data (str_invno, str_code, str_description, cur_rate, cur_qty, cur_discount, cur_subtot)values ('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', '".$_GET['rate']."', '".$_GET['qty']."', '".$_GET['discount']."', '".$_GET['subtotal']."') ") or die(mysql_error());
			
		       	$ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_rate']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_qty']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_discount']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_subtot']."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>
							 
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";*/
				
				$sql = mysql_query("Select * from inv_mast where str_invoiceno='".$_GET['invno']."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
				
					$ResponseXML .= "<str_invoiceno><![CDATA[".$row['str_invoiceno']."]]></str_invoiceno>";
					$ResponseXML .= "<str_crecash><![CDATA[".$row['str_crecash']."]]></str_crecash>";
					$ResponseXML .= "<str_customecode><![CDATA[".$row['str_customecode']."]]></str_customecode>";
					
					$sqlcustomer = mysql_query("Select * from customer_mast where id='".$row['str_customecode']."'") or die(mysql_error());
					if($rowcustomer = mysql_fetch_array($sqlcustomer)){
						$ResponseXML .= "<str_customername><![CDATA[".$rowcustomer['str_customername']."]]></str_customername>";
						$ResponseXML .= "<str_address><![CDATA[".$rowcustomer['str_address']."]]></str_address>";
					}
					$ResponseXML .= "<str_vatno1><![CDATA[".$row['str_vatno1']."]]></str_vatno1>";
					$ResponseXML .= "<str_vatno2><![CDATA[".$row['str_vatno2']."]]></str_vatno2>";
					$ResponseXML .= "<str_salesrep><![CDATA[".$row['str_salesrep']."]]></str_salesrep>";
					$ResponseXML .= "<str_salesorder1><![CDATA[".$row['str_salesorder1']."]]></str_salesorder1>";
					$ResponseXML .= "<str_salesorder2><![CDATA[".$row['str_salesorder2']."]]></str_salesorder2>";
					$ResponseXML .= "<dte_deliverdate><![CDATA[".$row['dte_deliverdate']."]]></dte_deliverdate>";
					$ResponseXML .= "<str_orderno1><![CDATA[".$row['str_orderno1']."]]></str_orderno1>";
					$ResponseXML .= "<str_orderno2><![CDATA[".$row['str_orderno2']."]]></str_orderno2>";
					$ResponseXML .= "<cur_credit><![CDATA[".$row['cur_credit']."]]></cur_credit>";
					$ResponseXML .= "<cur_balance><![CDATA[".$row['cur_balance']."]]></cur_balance>";
					$ResponseXML .= "<str_department><![CDATA[".$row['str_department']."]]></str_department>";
					$ResponseXML .= "<str_brand><![CDATA[".$row['str_brand']."]]></str_brand>";
					$ResponseXML .= "<str_vat><![CDATA[".$row['str_vat']."]]></str_vat>";
					$ResponseXML .= "<cur_discount1><![CDATA[".$row['cur_discount1']."]]></cur_discount1>";
					$ResponseXML .= "<cur_discount2><![CDATA[".$row['cur_discount2']."]]></cur_discount2>";
					$ResponseXML .= "<cur_subtotal><![CDATA[".$row['cur_subtotal']."]]></cur_subtotal>";
					$ResponseXML .= "<cur_discount><![CDATA[".$row['cur_discount']."]]></cur_discount>";
					$ResponseXML .= "<cur_tax><![CDATA[".$row['cur_tax']."]]></cur_tax>";
					$ResponseXML .= "<cur_invoiceval><![CDATA[".$row['cur_invoiceval']."]]></cur_invoiceval>";
				}				
			
				
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";
							
				
				$sql_data = mysql_query("delete from tmp_inv_data where str_invno='".$_GET['invno']."'") or die(mysql_error());
				$sql_data = mysql_query("Select * from inv_data where str_invno='".$_GET['invno']."'") or die(mysql_error());
				while($row = mysql_fetch_array($sql_data)){
					$sql_itdata = mysql_query("Select * from item_mast where str_code='".$row['str_code']."'") or die(mysql_error());
					$rowit = mysql_fetch_array($sql_itdata);
							
							
					$sql_tmp = mysql_query("Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, cur_discount, cur_subtot) values ( '".$row['str_invno']."', '".$row['str_code']."', '".$rowit['str_description']."', ".$row['cur_rate'].", ".$row['cur_qty'].", ".$row['cur_discount'].", ".$row['cur_subtot'].")") or die(mysql_error());
					
					
						
			
			 	$ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
  							<td bgcolor=\"#222222\" >".$rowit['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_rate']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_qty']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_discount']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_subtot']."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>
							 
                            </tr>";
							
							
            					
				}
			
			    $ResponseXML .= "   </table>]]></sales_table>";
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
				
	
}	

if ($_GET["Command"]=="save_customer"){
	
	if ($_GET["chkgarant"]==1){
		$chkgarant=1;
	} else {
		$chkgarant=0;
	}
	
	$sql_data = mysql_query("Select * from vendor where CODE='".$_GET['txt_cuscode']."'") or die(mysql_error());
	if($row = mysql_fetch_array($sql_data)){
		$sql_data = mysql_query("update vendor set NAME='".$_GET['txtCNAME']."', ADD1='".$_GET['txtBADD1']."', ADD2='".$_GET['txtBADD2']."', TELE1='".$_GET['txtTEL']."', TELE2='".$_GET['txttel2']."', CONT='".$_GET['txtcper']."', CUR_BAL='".$_GET['txtbal']."', OPDATE='".$_GET['DTOPDATE']."', cLIMIT='".$_GET['txtcrlimt']."', PEN='".$_GET['txtover']."', PENDA='".$_GET['']."', FAX='".$_GET['txtFAX']."', EMAIL='".$_GET['TXTEMAIL']."', vatno='".$_GET['txtvatno']."', acno='".$_GET["txtACCno"]."', CAT='".$_GET['txtcat']."', rep='".$_GET['TXT_REP']."', cus_type='".$_GET['txttype']."', area='".$_GET['txtarea']."', incdays='".$_GET['txtInc']."', chk_bangr='".$chkgarant."', bank_gr_date='".$_GET["DTbankgrdate"]."', AltMessage='".$_GET["txtMsg"]."'  where CODE='".$_GET['txt_cuscode']."'") or die(mysql_error());
	} else {
	
		$sql_data = mysql_query("insert into vendor (CODE, NAME, ADD1, ADD2, TELE1, TELE2, CONT, CUR_BAL, OPDATE, cLIMIT, PEN, FAX, EMAIL, vatno, acno, CAT, rep, cus_type, area, incdays, chk_bangr, bank_gr_date, AltMessage) values ('".$_GET['txt_cuscode']."', '".$_GET['txtCNAME']."', '".$_GET['txtBADD1']."', '".$_GET['txtBADD2']."', '".$_GET['txtTEL']."', '".$_GET['txttel2']."', '".$_GET['txtcper']."', '".$_GET['txtbal']."', '".$_GET['DTOPDATE']."', '".$_GET['txtcrlimt']."', '".$_GET['txtover']."', '".$_GET['txtFAX']."', '".$_GET['TXTEMAIL']."', '".$_GET['txtvatno']."', '".$_GET["txtACCno"]."', '".$_GET['txtcat']."', '".$_GET['TXT_REP']."', '".$_GET['txttype']."', '".$_GET['txtarea']."', '".$_GET['txtInc']."', '".$chkgarant."', '".$_GET["DTbankgrdate"]."', '".$_GET["txtMsg"]."')") or die(mysql_error());
		
	}

echo "Successfully Saved";
	
	
}

if ($_GET["Command"]=="delete_customer"){
	
	
	
	$sql_data = mysql_query("delete from vendor where CODE='".$_GET['txt_cuscode']."'") or die(mysql_error());
	echo "Successfully Deleted";
	
}

if ($_GET["Command"]=="tmp_crelimit"){
	
	$crelim=0;
	$cat="";
	$Com_rep1=trim(substr($_GET["Com_rep1"], 0, 5));
	
	
	$sql = mysql_query("Select * from br_trn where cus_code='".$_GET["txt_cuscode"]."' and Rep='".$Com_rep1."' and  brand='".$_GET["cmbbrand1"]."'") or die(mysql_error());
	if($row = mysql_fetch_array($sql)){
		$crelim=$row["credit_lim"];
		if (is_null($row["CAT"])==false){
			$cat=$row["CAT"];
		} else {
			$crelim=0;
		}
	}	
	
		$sql_data = mysql_query("insert into tmpCrLmt (sdate, stime, username, tmpLmt, Class, Rep, cusCode, crLmt, cat) values ('".date("d-m-Y")."', '".time("H:m:s")."', 'Test_Admin', ".$_GET["txt_templimit"].", '".trim($_GET["cmbbrand1"])."', '".$Com_rep1."', '".trim($_GET["txt_cuscode"])."', ".$crelim.", '".$cat."' )") or die(mysql_error());


$sql = mysql_query("Select * from br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and Rep='".$Com_rep1."' and  brand='".$_GET["cmbbrand1"]."'") or die(mysql_error());
	if($row = mysql_fetch_array($sql)){
		
		$sql_data = mysql_query("update br_trn set tmpLmt= ".$_GET["txt_tmeplimit"]." where cus_code='".trim($_GET["txt_cuscode"])."' and Rep='".$Com_rep1."' and brand='".$_GET["cmbbrand1"]."'") or die(mysql_error());
	} else {
	
		$sql_data = mysql_query("insert into br_trn (cus_code, Rep, credit_lim, brand, tmpLmt) values ('".trim($_GET["txt_cuscode"])."', '".$Com_rep1."', '0', '".$_GET["cmbbrand1"]."', '".$_GET["txt_templimit"]."')") or die(mysql_error());
	}

	if (check1==1){
		
		$sql_data = mysql_query("update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."'") or die(mysql_error());
	} else {
		
		$sql_data = mysql_query("update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."'") or die(mysql_error());
	}

	echo "Updated";
}

if ($_GET["Command"]=="pass_cusno"){

	
				/*	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
					$sql = mysql_query("CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error());*/
					  
	$_SESSION["custno"]=$_GET['custno'];
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				$cuscode=$_GET["custno"];	
				$sql = mysql_query("Select * from vendor where CODE='".$cuscode."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					
					$ResponseXML .= "<id><![CDATA[".$row['CODE']."]]></id>";
					$ResponseXML .= "<str_customername><![CDATA[".$row['NAME']."]]></str_customername>";
					$address=$row['ADD1'].",  ".$row['ADD2'];
					$ResponseXML .= "<str_address><![CDATA[".$address."]]></str_address>";
					$ResponseXML .= "<str_vatno><![CDATA[".$row["vatno"]."]]></str_vatno>";
					$ResponseXML .= "<str_svatno><![CDATA[".$row["svatno"]."]]></str_svatno>";
					$ResponseXML .= "<AltMessage><![CDATA[".$row["AltMessage"]."]]></AltMessage>";
					
				}	
					
				$cuscode=$_GET["custno"];	
	$RET_AMOUNT = 0;
	$PD_AMOUNT = 0;
	$OUT_AMOUNT = 0;

	
	$sql = mysql_query("select * from vendor where CODE = '".trim($cuscode)."'") or die(mysql_error());
	if ($row = mysql_fetch_array($sql)){	
		
		$sqlchq = mysql_query("SELECT che_amount FROM S_INVCHeQ WHERE che_date>'".date("d-m-Y")."' AND cus_code='".$row["CODE"]."'") or die(mysql_error());
		
		while ($rowchq = mysql_fetch_array($sqlchq)){
			$PD_AMOUNT = $PD_AMOUNT + $rowchq["che_amount"];
		}	
		
		/*if (is_null($row["AltMessage"])==false ){
           	if (trim($row["AltMessage"]) != ""){
		   		$ResponseXML .= "<AltMessage><![CDATA[".$row['AltMessage']."]]></AltMessage>"; 
			}
        }*/
		
		if ($row["chk_bangr"] == "1"){
			
           $dateDiff = $row["bank_gr_date"] - date("d-m-Y");
		   $m_dates    = floor($dateDiff/(60*60*24));
		   if ($m_dates>30 and $m_dates<60)
		   {
		   	$ResponseXML .= "<bank_message><![CDATA[Please Re-New Bank Grantee Date]]></bank_message>"; 
			$_SESSION["inv_status"]=0;
		   } else if ($m_dates <= 30){
				$ResponseXML .= "<bank_message><![CDATA[No Permission For Invoice For This Customer Please Re-New Bank Grantee Date]]></bank_message>"; 	
			$_SESSION["inv_status"]=0;
		   }
		  } else {
		  	$ResponseXML .= "<bank_message><![CDATA[]]></bank_message>"; 
         }
		
	
	$sql60 = mysql_query("select SDATE from  s_salma where  C_CODE='".trim($cuscode)."' and GRAND_TOT-TOTPAY >1 and CANCELL=0  order by SDATE") or die(mysql_error());
	if ($row60 = mysql_fetch_array($sql60)){		 
		//$mtmp = date("Y-m-d") - $row60["SDATE"];
		
		//$mdays= floor($mtmp/(60*60*24));
		
		
		$date1 = $row60["SDATE"];
		$date2 = date("Y-m-d");

		$diff = abs(strtotime($date2) - strtotime($date1));

		$years = floor($diff / (365*60*60*24));
	
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	
		$mday = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$mdays=$mday+($months*30)+($years*365);
		
		if ($mdays > 60){
			$ResponseXML .= "<over60_message><![CDATA[Over 60 Outsnding Avilabale]]></over60_message>"; 
			$_SESSION["inv_status"]=0;
			if (is_null($row["Over_DUE_IG_Date"])==false){
				if ($row["Over_DUE_IG_Date"]==date("d-m-Y")){
					$ResponseXML .= "<over60_qst><![CDATA[This is Over 60 Days Customer Do you want to Proceed]]></over60_qst>";
		
					$sqltmpCrLmt = mysql_query("insert into tmpCrLmt (sdate, stime, tmpLmt, Class, Rep,cuscode, crLmt,  FLAG) values ('".date("d-m-Y")."','".date("h:i:s")."' , ".$mdays." ,'NB','NR','".trim($cuscode)."','0', 'O60')") or die(mysql_error());
					
				} else {
					$ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
				}
			} else {
				$ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
			}
		} else {
			$ResponseXML .= "<over60_message><![CDATA[]]></over60_message>"; 
		}
	 } else {
		  	$ResponseXML .= "<over60_message><![CDATA[]]></over60_message>"; 
			$ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
    }
     
    $sqls_cheq = mysql_query("Select * from s_cheq where CR_CHEVAL-PAID>0 and CR_FLAG='0' and CR_C_CODE='".trim($cuscode)."'" ) or die(mysql_error());
	if ($rows_cheq = mysql_fetch_array($sqls_cheq)){
		$ResponseXML .= "<chq_message><![CDATA[Return Cheque]]></chq_message>";
		$_SESSION["inv_status"]=0;
		
		if (is_null($row["Over_DUE_IG_Date"])==false){
			if ($row["Over_DUE_IG_Date"]==date("d-m-Y")){
				$ResponseXML .= "<chq_message_que><![CDATA[Do You Want To Continue with Return Cheques]]></chq_message_que>";
				
				$sqltmpCrLmt = mysql_query("insert into tmpCrLmt (sdate, stime, tmpLmt, Class, Rep,cuscode, crLmt, FLAG) values ('".date("d-m-Y")."', '".date("h:i:s")."', '0' ,'NB','NR','".trim($cuscode)."','0', 'RTN'") or die(mysql_error());
			} else {
				$ResponseXML .= "<chq_message_que><![CDATA[]]></chq_message_que>";
			}
		}
	} else {
		$ResponseXML .= "<chq_message><![CDATA[]]></chq_message>";
		$ResponseXML .= "<chq_message_que><![CDATA[]]></chq_message_que>";
	} 
		

		
        
        if (is_null($row["cLIMIT"])==false){
			$ResponseXML .= "<txt_crelimi><![CDATA[".number_format($row['cLIMIT']+$row['temp_limit'], 2, ".", ",")."]]></txt_crelimi>"; 
		}
		
		if (is_null($row["CUR_BAL"])==false){
			$OUT_AMOUNT=$row["CUR_BAL"];
		}
        
        if (is_null($row["CAT"])==false) {
			$cuscat = $row["CAT"];
		}
  	
		$sqlretchq = mysql_query("Select * from s_cheq where CR_C_CODE='".trim($cuscode)."' and CR_CHEVAL-PAID>0 and CR_FLAG='0'") or die(mysql_error());
		while ($rowretchq = mysql_fetch_array($sqlretchq)){
			$RET_AMOUNT = $RET_AMOUNT + $rowretchq["CR_CHEVAL"] - $rowretchq["PAID"];
		}
	
  }     


        //Call SETLIMIT ====================================================================

	$OutpDAMT = 0;
	$OutREtAmt = 0;
	$OutInvAmt = 0;
	$InvClass="";
	//echo "select class from brand_mas where barnd_name='".trim($_GET["brand"])."'";
	$sqlclass = mysql_query("select class from brand_mas where barnd_name='".trim($_GET["brand"])."'") or die(mysql_error());
	if ($rowclass = mysql_fetch_array($sqlclass)){
		if (is_null($rowclass["class"])==false){
			$InvClass=$rowclass["class"];
		}
	}
	//echo $InvClass;
	//echo "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($_GET["salesrep"])."' and class='".$InvClass."'";
	$sqloutinv = mysql_query("select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($_GET["salesrep"])."' and class='".$InvClass."'") or die(mysql_error());
	if ($rowoutinv = mysql_fetch_array($sqloutinv)){
		if (is_null($rowoutinv["totout"])==false){
			$OutInvAmt=$rowoutinv["totout"];
		}
	}
//echo $OutInvAmt;
$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($_GET["salesrep"])."'") or die(mysql_error());
	while($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
		$sqlsttr = mysql_query("select * from s_sttr where ST_REFNO='".trim($rowinvcheq["REFNO"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"]) ."'") or die(mysql_error());
		while($rowsttr = mysql_fetch_array($sqlsttr)){
			$sqlview_s_salma = mysql_query("select class from view_s_salma where REF_NO='".trim($rowsttr["ST_INVONO"])."'") or die(mysql_error());
			if($rowview_s_salma = mysql_fetch_array($sqlview_s_salma)){
				if (trim($rowview_s_salma["class"]) == $InvClass){
                    $OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
                }
			}
		}
	}


    
        $pend_ret_set = 0;
		$sqlinvcheq = mysql_query("SELECT sum(che_amount) as  che_amount FROM S_INVCHeQ WHERE che_date >'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='RET'") or die(mysql_error());
		if($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
			if (is_null($rowinvcheq["che_amount"])==false){
				$pend_ret_set=$rowinvcheq["che_amount"];
			}
		}
		
		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".trim($_GET["salesrep"])."'") or die(mysql_error());
		if($rowcheq = mysql_fetch_array($sqlcheq)){
			if (is_null($rowcheq["tot"])==false){
				$OutREtAmt=$rowcheq["tot"];
				$ResponseXML .= "<msg_return><![CDATA[Return Cheques Available]]></msg_return>";
			} else {
				$OutREtAmt=0;
			}
		} else {
			$ResponseXML .= "<msg_return><![CDATA[]]></msg_return>";	
		}
		
            
 
$ResponseXML .= "<sales_table_acc><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>".number_format($OutInvAmt, 2, ".", ",")."</td></tr>
						 <td>Return Cheque Amount</td><td>".number_format($OutREtAmt, 2, ".", ",")."</td></tr>
						 <td>Pending Cheque Amount</td><td>".number_format($OutpDAMT, 2, ".", ",")."</td></tr>
						 <td>PSD Cheque Settlments</td><td>".number_format($pend_ret_set, 2, ".", ",")."</td></tr>
						 <td>Total</td><td>".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."</td></tr>
						 </table></table>]]></sales_table_acc>";
        

      $sqlbr_trn = mysql_query("select * from br_trn where rep='".trim($_GET["salesrep"])."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'") or die(mysql_error());  
	if($rowbr_trn = mysql_fetch_array($sqlbr_trn)){
		if(is_null($rowbr_trn["credit_lim"]) == false){
			$crLmt=$rowbr_trn["credit_lim"];
		} else {	
			$crLmt=0;		
		}
	
		
		if(is_null($rowbr_trn["tmpLmt"]) == false){
			$tmpLmt=$rowbr_trn["tmpLmt"];
		} else {	
			$tmpLmt=0;		
		}
		
		if (is_null($rowbr_trn["cat"])==false) {
			$cuscat = trim($rowbr_trn["cat"]);
            if ($cuscat = "A"){ $m = 2.5; }
            if ($cuscat = "B"){ $m = 2.5; }
            if ($cuscat = "C"){ $m = 1; }
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
			$crebal=$crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $txt_crebal = number_format($crebal, "2", ",", "'");
          } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
          }
         $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;

	   			
			
			 
    }    
			$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
			$ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
          
         	 $ResponseXML .= "<creditbalance><![CDATA[".$creditbalance."]]></creditbalance>";

	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
				
	
}	

if ($_GET["Command"]=="pass_crn"){

	$_SESSION["custno"]=$_GET['custno'];
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				
				$sql = mysql_query("Select * from vendor where CODE='".$_GET['custno']."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					
					$ResponseXML .= "<id><![CDATA[".$row['CODE']."]]></id>";
					$ResponseXML .= "<NAME><![CDATA[".$row['NAME']."]]></NAME>";
					$ResponseXML .= "<ADD1><![CDATA[".$row['ADD1']."]]></ADD1>";
					$ResponseXML .= "<ADD2><![CDATA[".$row['ADD2']."]]></ADD2>";
				}
				
				$ResponseXML .= "</salesdetails>";
				echo $ResponseXML;

}

if ($_GET["Command"]=="pass_grn"){

	$_SESSION["custno"]=$_GET['custno'];
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				
				$sql = mysql_query("Select * from vendor where CODE='".$_GET['custno']."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					
					$ResponseXML .= "<id><![CDATA[".$row['CODE']."]]></id>";
					$ResponseXML .= "<NAME><![CDATA[".$row['NAME']."]]></NAME>";
					$ResponseXML .= "<ADD1><![CDATA[".$row['ADD1']."]]></ADD1>";
					$ResponseXML .= "<ADD2><![CDATA[".$row['ADD2']."]]></ADD2>";
				}
				
				$ResponseXML .= "</salesdetails>";
				echo $ResponseXML;

}


if ($_GET["Command"]=="pass_cusno_cust_mast"){

	$_SESSION["custno"]=$_GET['custno'];
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				
				$sql = mysql_query("Select * from vendor where CODE='".$_GET['custno']."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					$ResponseXML .= "<blacklist><![CDATA[".$row['blacklist']."]]></blacklist>";
					$ResponseXML .= "<id><![CDATA[".$row['CODE']."]]></id>";
					$ResponseXML .= "<NAME><![CDATA[".$row['NAME']."]]></NAME>";
					$ResponseXML .= "<ADD1><![CDATA[".$row['ADD1']."]]></ADD1>";
					$ResponseXML .= "<ADD2><![CDATA[".$row['ADD2']."]]></ADD2>";
					$ResponseXML .= "<OPBAL><![CDATA[".$row['OPBAL']."]]></OPBAL>";
					$ResponseXML .= "<TELE1><![CDATA[".$row['TELE1']."]]></TELE1>";
					$ResponseXML .= "<TELE2><![CDATA[".$row['TELE2']."]]></TELE2>";
					$ResponseXML .= "<CONT><![CDATA[".$row['CONT']."]]></CONT>";
					$ResponseXML .= "<CUR_BAL><![CDATA[".$row['CUR_BAL']."]]></CUR_BAL>";
					$ResponseXML .= "<LIMIT><![CDATA[".$row['cLIMIT']."]]></LIMIT>";
					$ResponseXML .= "<PEN><![CDATA[".$row['PEN']."]]></PEN>";
					$ResponseXML .= "<FAX><![CDATA[".$row['FAX']."]]></FAX>";
					$ResponseXML .= "<acno><![CDATA[".$row['acno']."]]></acno>";
					$ResponseXML .= "<EMAIL><![CDATA[".$row['EMAIL']."]]></EMAIL>";
					$ResponseXML .= "<CAT><![CDATA[".$row['CAT']."]]></CAT>";
					$ResponseXML .= "<rep><![CDATA[".$row['rep']."]]></rep>";
					$ResponseXML .= "<vatno><![CDATA[".$row['vatno']."]]></vatno>";
					$ResponseXML .= "<OPDATE><![CDATA[".$row['OPDATE']."]]></OPDATE>";
					$ResponseXML .= "<area><![CDATA[".$row['area']."]]></area>";
					$ResponseXML .= "<CUS_TYPE><![CDATA[".$row['CUS_TYPE']."]]></CUS_TYPE>";
					$ResponseXML .= "<note><![CDATA[".$row['note']."]]></note>";
					$ResponseXML .= "<temp_limit><![CDATA[".$row['temp_limit']."]]></temp_limit>";
					$ResponseXML .= "<bank_gr_date><![CDATA[".$row['bank_gr_date']."]]></bank_gr_date>";
					$ResponseXML .= "<AltMessage><![CDATA[".$row['AltMessage']."]]></AltMessage>";
					
					$ResponseXML .= "<sales_table><![CDATA[ <table width=\"300\" border=\"1\" cellspacing=\"0\">
        												<tr>
          												<td background=\"images/headingbg.gif\" height=\"25\">Credit Limit</td>
         												<td background=\"images/headingbg.gif\">Sales Rep</td>
          												<td background=\"images/headingbg.gif\">Outstanding</td>
          												<td background=\"images/headingbg.gif\">Balance</td>
          												<td background=\"images/headingbg.gif\">Cat</td>
          												<td background=\"images/headingbg.gif\">Type</td>
        												</tr>";
					
					$cre_lim=0;				
					$sql1 = mysql_query("Select * from br_trn where cus_code='".$_GET['custno']."'") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){
						$credit_lim=$row1["credit_lim"];
						$credit=$row1["credit"];
						$rep=$row1["Rep"];
						$cat=$row1["CAT"];
						$brand=$row1["brand"];
						$balance=$credit_lim-$credit;
							
							
										
										$ResponseXML .= "<tr>
											<td bgcolor=\"#222222\">".$credit_lim."</td>
											<td bgcolor=\"#222222\">".$row1["Rep"]."</td>
											<td bgcolor=\"#222222\">".$credit."</td>
											<td bgcolor=\"#222222\"> ".$balance."</td>
											<td bgcolor=\"#222222\">".$row1["CAT"]."</td>
											<td bgcolor=\"#222222\">".$row1["brand"]."</td>
											<td><input type=\"button\" name=\"additem_tmp\" id=\"additem_tmp\" value=\"Select\" onClick=\"ass_lim('$credit_lim', '$rep', '$credit', '$balance', '$cat', '$brand');\"></td>
										</tr>";
										
							if ($row1["CAT"]=="C"){
								$cre_lim=$cre_lim+$credit_lim;
							}
							if ($row1["CAT"]=="B"){
								$cre_lim=$cre_lim+$credit_lim*2.5;
							}
							if ($row1["CAT"]=="A"){
								$cre_lim=$cre_lim+$credit_lim*2.5;
							} 			
						
					}
					
					  $ResponseXML .= "   </table>]]></sales_table>";
					
				}				
			
				
				$ResponseXML .= "<cre_lim><![CDATA[".$cre_lim."]]></cre_lim>";
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
}



if ($_GET["Command"]=="pass_repno_cust_mast")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				
				$sql = mysql_query("Select * from vendor where CODE='".$_GET['custno']."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					$ResponseXML .= "<code><![CDATA[".$row['CODE']."]]></code>";
					$ResponseXML .= "<name><![CDATA[".$row['NAME']."]]></name>";
					
				
				}
				
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
}

if ($_GET["Command"]=="pass_cus_cash_rec")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				
		
				$sql = mysql_query("Select * from vendor where CODE='".$_GET['custno']."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					$ResponseXML .= "<code><![CDATA[".$row['CODE']."]]></code>";
					$ResponseXML .= "<name><![CDATA[".$row['NAME']."]]></name>";
					$ResponseXML .= "<address><![CDATA[".$row['ADD1']." ".$row['ADD2']."]]></address>";
				}
				
					$ResponseXML .= "<sales_table_acc><![CDATA[ <table  bgcolor=\"#003366\" border=1  cellspacing=0>
								<tr><td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Invoice No</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Value</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Paid</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Overdue</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Chq Pay</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Chq Balance</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cash Pay</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Inv Balance</font></td></tr>";
				
				//$sql = mysql_query("Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and DEV='" & rsusercon!dev & "' and CANCELL='0' and SAL_EX='" & Trim(Left(Com_rep, 5)) & "' and Accname <> 'NON STOCK' ORDER BY SDATE") or die(mysql_error());
			//	echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0' and SAL_EX='".$_GET["refno"]."' and Accname <> 'NON STOCK' ORDER BY SDATE";
				
				$i=1;
				//echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0' and SAL_EX='".$_GET["refno"]."' ORDER BY SDATE";
				$sql = mysql_query("Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0'  ORDER BY SDATE") or die(mysql_error());
				while($row = mysql_fetch_array($sql)){

					 $sdate="sdate".$i;
					  $delidate="delidate".$i;
					
					
						if (is_null($row["deli_date"]==false)){
							$ResponseXML .= "<tr><td><div id=".$delidate.">".$row["REQ_DATE"]."</div></td>";
						} else {
							$ResponseXML .= "<tr><td><div id=".$delidate.">".$row["SDATE"]."</div></td>";
						}	
						
						$ResponseXML .= "<td><div id=".$sdate.">".$row["SDATE"]."</div></td>";
						
						$j=$i+1;
						
						$overdue="overdue".$i;
						
						$chq_pay="chq_pay".$i;
						$chq_pay_next="chq_pay".$j;
						
						$chq_balance="chq_balance".$i;
						$chq_balance_next="chq_balance".$j;
						
						$cash_pay="cash_pay".$i;
						$cash_pay_next="cash_pay".$j;
						
						$inv_balance="inv_balance".$i;
						$overdueamt=$row["GRAND_TOT"]-$row["TOTPAY"];
						//number_format($row["GRAND_TOT"]-$row["TOTPAY"], 2, ".")
						
						$invno="invno".$i;
						
					$ResponseXML .= "<td><div id=".$invno.">".$row["REF_NO"]."</div></td>
									 <td>".number_format($row["GRAND_TOT"], 2, ".", ",")."</td>
									 <td>".number_format($row["TOTPAY"], 2, ".", ",")."</td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$overdue." id=".$overdue." value=".$overdueamt." size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$chq_pay." id=".$chq_pay." onBlur=\"calc_bal('$overdue', '$chq_pay', '$inv_balance', '$chq_balance', '$chq_balance_next', '$cash_pay', '$i', event);\"  onKeyPress=\"keyset('$chq_pay_next', event);\"   size=\"10\"/></td>									
									 <td><input type=\"text\"  class=\"txtbox\" name=".$chq_balance." id=".$chq_balance." onKeyPress=\"keysetvalue('$chq_balance','$chq_balance_next', '$chq_pay', event);\" size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$cash_pay." id=".$cash_pay." onKeyPress=\"calc_bal_cash('$overdue', '$cash_pay_next', '$chq_pay', '$inv_balance', '$cash_pay', event);\" size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$inv_balance." id=".$inv_balance." disabled size=\"10\"/></td></tr>";
									 $i=$i+1;
				 }
				 $_SESSION["count"]=$i;
				 $ResponseXML .= "   </table>]]></sales_table_acc>";
				 $ResponseXML .= "<mcount><![CDATA[".$_SESSION["count"]."]]></mcount>";
				 $ResponseXML .= "</salesdetails>";	
				 echo $ResponseXML;

}



if ($_GET["Command"]=="update_limit")
{	
	$sql = mysql_query("Select * from br_trn where cus_code='".$_GET['txt_cuscode']."' and Rep='".$_GET['rep']."' and brand='".$_GET['brand']."'") or die(mysql_error());
	if($row = mysql_fetch_array($sql)){
		$sql1 = mysql_query("update  br_trn set credit_lim=".$_GET['txtlimit'].", CAT='".$_GET['cmbCAt']."' where cus_code='".$_GET['txt_cuscode']."' and Rep='".$_GET['rep']."' and brand='".$_GET['brand']."'") or die(mysql_error());
	} else {
	  $sqlq="insert into br_trn (cus_code, Rep, credit_lim, brand, CAT) values ('".$_GET['txt_cuscode']."', '".$_GET['rep']."', ".$_GET['txtlimit'].", '".$_GET['brand']."', '".$_GET['cmbCAt']."') ";
	  // echo $sqlq;
		$sql1 = mysql_query($sqlq) or die(mysql_error());
	}
	
	if ($_GET["stopinv"]==true){
		$sql1 = mysql_query("update  vendor set blacklist='1' where CODE='".$_GET['txt_cuscode']."'") or die(mysql_error());
	} else {
		$sql1 = mysql_query("update  vendor set blacklist='0' where CODE='".$_GET['txt_cuscode']."'") or die(mysql_error());
	}
	
	$sql = mysql_query("Select sum(credit_lim) as tot from br_trn where cus_code='".$_GET['txt_cuscode']."'") or die(mysql_error());
	if($row = mysql_fetch_array($sql)){
		$totcr=$row["tot"];
	} else {
		$totcr=0;
	}
	
	$sql1 = mysql_query("update vendor set cLIMIT=".$totcr." where CODE='".$_GET['txt_cuscode']."'") or die(mysql_error());
	
		
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			$ResponseXML .= "<totcr><![CDATA[".$totcr."]]></totcr>";
			$ResponseXML .= "<cre_table><![CDATA[ <table width=\"300\" border=\"1\" cellspacing=\"0\">
        												<tr>
          												<td background=\"images/headingbg.gif\" height=\"25\">Credit Limit</td>
         												<td background=\"images/headingbg.gif\">Sales Rep</td>
          												<td background=\"images/headingbg.gif\">Outstanding</td>
          												<td background=\"images/headingbg.gif\">Balance</td>
          												<td background=\"images/headingbg.gif\">Cat</td>
          												<td background=\"images/headingbg.gif\">Type</td>
        												</tr>";
			
			$cre_lim=0;				
					$sql1 = mysql_query("Select * from br_trn where cus_code='".$_GET['txt_cuscode']."'") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){
						$credit_lim=$row1["credit_lim"];
						$credit=$row1["credit"];
						$rep=$row1["Rep"];
						$cat=$row1["CAT"];
						$brand=$row1["brand"];
						$balance=$credit_lim-$credit;
							
							
										
										$ResponseXML .= "<tr>
											<td bgcolor=\"#222222\">".$credit_lim."</td>
											<td bgcolor=\"#222222\">".$row1["Rep"]."</td>
											<td bgcolor=\"#222222\">".$credit."</td>
											<td bgcolor=\"#222222\"> ".$balance."</td>
											<td bgcolor=\"#222222\">".$row1["CAT"]."</td>
											<td bgcolor=\"#222222\">".$row1["brand"]."</td>
											<td><input type=\"button\" name=\"additem_tmp\" id=\"additem_tmp\" value=\"Select\" onClick=\"ass_lim('$credit_lim', '$rep', '$credit', '$balance', '$cat', '$brand');\"></td>
										</tr>";
										
							if ($row1["CAT"]=="C"){
								$cre_lim=$cre_lim+$credit_lim;
							}
							if ($row1["CAT"]=="B"){
								$cre_lim=$cre_lim+$credit_lim*2.5;
							}
							if ($row1["CAT"]=="A"){
								$cre_lim=$cre_lim+$credit_lim*2.5;
							} 			
						
					}
					
					  $ResponseXML .= "   </table>]]></cre_table>";
					 $ResponseXML .= "</salesdetails>";	
				echo $ResponseXML; 
					
	
}

if ($_GET["Command"]=="delete_limit")
{	
	$sql = mysql_query("delete from br_trn where cus_code='".$_GET['txt_cuscode']."' and Rep='".$_GET['rep']."' and brand='".$_GET['brand']."'") or die(mysql_error());
	
	
		
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			$ResponseXML .= "<totcr><![CDATA[".$totcr."]]></totcr>";
			$ResponseXML .= "<cre_table><![CDATA[ <table width=\"300\" border=\"1\" cellspacing=\"0\">
        												<tr>
          												<td background=\"images/headingbg.gif\" height=\"25\">Credit Limit</td>
         												<td background=\"images/headingbg.gif\">Sales Rep</td>
          												<td background=\"images/headingbg.gif\">Outstanding</td>
          												<td background=\"images/headingbg.gif\">Balance</td>
          												<td background=\"images/headingbg.gif\">Cat</td>
          												<td background=\"images/headingbg.gif\">Type</td>
        												</tr>";
			
			$cre_lim=0;				
					$sql1 = mysql_query("Select * from br_trn where cus_code='".$_GET['txt_cuscode']."'") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){
						$credit_lim=$row1["credit_lim"];
						$credit=$row1["credit"];
						$rep=$row1["Rep"];
						$cat=$row1["CAT"];
						$brand=$row1["brand"];
						$balance=$credit_lim-$credit;
							
							
										
										$ResponseXML .= "<tr>
											<td bgcolor=\"#222222\">".$credit_lim."</td>
											<td bgcolor=\"#222222\">".$row1["Rep"]."</td>
											<td bgcolor=\"#222222\">".$credit."</td>
											<td bgcolor=\"#222222\"> ".$balance."</td>
											<td bgcolor=\"#222222\">".$row1["CAT"]."</td>
											<td bgcolor=\"#222222\">".$row1["brand"]."</td>
											<td><input type=\"button\" name=\"additem_tmp\" id=\"additem_tmp\" value=\"Select\" onClick=\"ass_lim('$credit_lim', '$rep', '$credit', '$balance', '$cat', '$brand');\"></td>
										</tr>";
										
							if ($row1["CAT"]=="C"){
								$cre_lim=$cre_lim+$credit_lim;
							}
							if ($row1["CAT"]=="B"){
								$cre_lim=$cre_lim+$credit_lim*2.5;
							}
							if ($row1["CAT"]=="A"){
								$cre_lim=$cre_lim+$credit_lim*2.5;
							} 			
						
					}
					
					  $ResponseXML .= "   </table>]]></cre_table>";
					 $ResponseXML .= "</salesdetails>";	
				echo $ResponseXML; 
					
	
}

if ($_GET["Command"]=="note_update")
{	
	echo "update vendor set note= '".trim($_GET["txtnote"])."' where code='".trim($_GET["txt_cuscode"])."'";
	$sql = mysql_query("update vendor set note= '".trim($_GET["txtnote"])."' where code='".trim($_GET["txt_cuscode"])."'") or die(mysql_error());
	
}
?>
