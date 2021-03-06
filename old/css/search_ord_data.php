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

if ($_GET["Command"]=="search_inv"){
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Order No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
                             <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Order Date</font></td>
   							</tr>";
                           
						if ($_GET["Option1"]=="true"){
							if ($_GET["mstatus"]=="invno"){
						   		$letters = $_GET['invno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								if ($_GET["stname"]=="ord"){
									$sql = mysql_query("SELECT * from s_cusordmas where REF_NO like  '$letters%' limit 50") or die(mysql_error());
								} else {
									$sql = mysql_query("SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO='0' and CANCELL='0' limit 50") or die(mysql_error());
								}	
							} else if ($_GET["mstatus"]=="customername"){
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								if ($_GET["stname"]=="ord"){
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' limit 50 ") or die(mysql_error()) or die(mysql_error());
								} else {
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO='0' and CANCELL='0' limit 50") or die(mysql_error()) or die(mysql_error());
								}
							} else {
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								if ($_GET["stname"]=="ord"){
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' limit 50") or die(mysql_error()) or die(mysql_error());
								} else {
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO='0' and CANCELL='0' limit 50") or die(mysql_error()) or die(mysql_error());
								}
							}
						}	
						
						
						if ($_GET["Option2"]=="true"){
							if ($_GET["mstatus"]=="invno"){
						   		$letters = $_GET['invno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								if ($_GET["stname"]=="ord"){
									$sql = mysql_query("SELECT * from s_cusordmas where REF_NO like  '$letters%' limit 50 ") or die(mysql_error());
								} else {
									$sql = mysql_query("SELECT * from s_cusordmas where approveby!='0' and REF_NO like  '$letters%' and  INVNO='0' and CANCELL='0' limit 50") or die(mysql_error());
								}	
							} else if ($_GET["mstatus"]=="customername"){
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								if ($_GET["stname"]=="ord"){
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' limit 50 ") or die(mysql_error()) or die(mysql_error());
								} else {
									$sql = mysql_query("SELECT * from s_cusordmas where approveby!='0' and CUS_NAME like  '$letters%' and  INVNO='0' and CANCELL='0' limit 50") or die(mysql_error()) or die(mysql_error());
								}
							} else {
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								if ($_GET["stname"]=="ord"){
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' limit 50") or die(mysql_error()) or die(mysql_error());
								} else {
									$sql = mysql_query("SELECT * from s_cusordmas where approveby!='0' and CUS_NAME like  '$letters%' and  INVNO='0' and CANCELL='0' limit 50") or die(mysql_error()) or die(mysql_error());
								}
							}
						}	
						
						if ($_GET["Option3"]=="true"){
							if ($_GET["mstatus"]=="invno"){
						   		$letters = $_GET['invno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								if ($_GET["stname"]=="ord"){
									$sql = mysql_query("SELECT * from s_cusordmas where REF_NO like  '$letters%'  limit 50") or die(mysql_error());
								} else {
									//echo "SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO!='0' and CANCELL='0'";
									$sql = mysql_query("SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO!='0' and CANCELL='0' limit 50") or die(mysql_error());
								}	
							} else if ($_GET["mstatus"]=="customername"){
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								if ($_GET["stname"]=="ord"){
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' limit 50 ") or die(mysql_error()) or die(mysql_error());
								} else {
									//echo "SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO!='0' and CANCELL='0'";
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO!='0' and CANCELL='0' limit 50") or die(mysql_error()) or die(mysql_error());
								}
							} else {
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								if ($_GET["stname"]=="ord"){
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' limit 50") or die(mysql_error()) or die(mysql_error());
								} else {
									//echo "SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO!='0' and CANCELL='0'";
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO!='0' and CANCELL='0' limit 50") or die(mysql_error()) or die(mysql_error());
								}
							}
						}	
						
						
						if ($_GET["Option4"]=="true"){
							if ($_GET["mstatus"]=="invno"){
						   		$letters = $_GET['invno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								if ($_GET["stname"]=="ord"){
									$sql = mysql_query("SELECT * from s_cusordmas where REF_NO like  '$letters%' limit 50 ") or die(mysql_error());
								} else {
									$sql = mysql_query("SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO='0' and CANCELL='0' limit 50") or die(mysql_error());
								}	
							} else if ($_GET["mstatus"]=="customername"){
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								if ($_GET["stname"]=="ord"){
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' limit 50 ") or die(mysql_error()) or die(mysql_error());
								} else {
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO='0' and CANCELL='0' limit 50") or die(mysql_error()) or die(mysql_error());
								}
							} else {
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								if ($_GET["stname"]=="ord"){
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' limit 50") or die(mysql_error()) or die(mysql_error());
								} else {
									$sql = mysql_query("SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO='0' and CANCELL='0' limit 50") or die(mysql_error()) or die(mysql_error());
								}
							}
						}	
													
						
							while($row = mysql_fetch_array($sql)){
								$REF_NO = $row['REF_NO'];
								$stname = $_SESSION["stname"];
							$ResponseXML .= "<tr>
                           	  <td onclick=\"invno('$REF_NO', '$stname');\">".$row['REF_NO']."</a></td>
                              <td onclick=\"invno('$REF_NO', '$stname');\">".$row['CUS_NAME']."</a></td>
                              <td onclick=\"invno('$REF_NO', '$stname');\">".$row['SDATE']."</a></td>
                                                        	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}


if ($_GET["Command"]=="pass_invno"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$brand="";
			$salrep="";
			$cuscode="";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			$ResponseXML .= "<stname><![CDATA[".$_GET["stname"]."]]></stname>";
					$inv= $_GET['invno']; 
					$_SESSION["invno"]=$_GET['invno']; 
					$_SESSION["salesord1"]=$_GET['invno']; 
					
					$_SESSION["custno"]=$_GET['custno'];
					
			 		//$tmpinvno="0000".substr($_GET['invno'], 4, 7) ;
					//$lenth=strlen($tmpinvno);
					//$serial=substr($tmpinvno, $lenth-7);
					//$inv=substr($_GET['invno'], 0, 3).substr("\ ", 0, 1).$serial;
				$a="Select * from s_cusordmas where REF_NO='".$inv."'";
				
				$sql = mysql_query("Select * from s_cusordmas where REF_NO='".$inv."'") or die(mysql_error());
				
				if($row = mysql_fetch_array($sql)){
					$cuscode=$row['C_CODE'];
					$ResponseXML .= "<str_invoiceno><![CDATA[".$row['REF_NO']."]]></str_invoiceno>";
					$ResponseXML .= "<str_crecash><![CDATA[".$row['TYPE']."]]></str_crecash>";
					$ResponseXML .= "<sdate><![CDATA[".$row['SDATE']."]]></sdate>";
					$cuscode=$row['C_CODE'];
					$ResponseXML .= "<str_customecode><![CDATA[".$row['C_CODE']."]]></str_customecode>";
					$_SESSION["tmp_no_ord"]=$row['tmp_no'];
					$sqlcustomer = mysql_query("Select * from vendor where CODE='".$row['C_CODE']."'") or die(mysql_error());
					if($rowcustomer = mysql_fetch_array($sqlcustomer)){
						$ResponseXML .= "<str_customername><![CDATA[".$rowcustomer['NAME']."]]></str_customername>";
						$ResponseXML .= "<str_address><![CDATA[".$rowcustomer['ADD1']." ".$rowcustomer['ADD2']."]]></str_address>";
						$ResponseXML .= "<str_vatno1><![CDATA[".$rowcustomer['vatno']."]]></str_vatno1>";
						$ResponseXML .= "<str_vatno2><![CDATA[".$rowcustomer['svatno']."]]></str_vatno2>";
					}
					
					//$ResponseXML .= "<str_vatno2><![CDATA[".$row['str_vatno2']."]]></str_vatno2>";
					$ResponseXML .= "<str_salesrep><![CDATA[".$row['SAL_EX']."]]></str_salesrep>";
					$salesrep=$row['SAL_EX'];
					//$ResponseXML .= "<str_salesorder1><![CDATA[".$row['str_salesorder1']."]]></str_salesorder1>";
					//$ResponseXML .= "<str_salesorder2><![CDATA[".$row['str_salesorder2']."]]></str_salesorder2>";
					$ResponseXML .= "<dte_deliverdate><![CDATA[".$row['REQ_DATE']."]]></dte_deliverdate>";
					//$ResponseXML .= "<str_orderno1><![CDATA[".$row['ORD_NO']."]]></str_orderno1>";
					//$ResponseXML .= "<str_orderno2><![CDATA[".$row['ORD_DA']."]]></str_orderno2>";
					//$ResponseXML .= "<cur_credit><![CDATA[".$row['cur_credit']."]]></cur_credit>";
					//$ResponseXML .= "<cur_balance><![CDATA[".$row['cur_balance']."]]></cur_balance>";
					
					$ResponseXML .= "<dis><![CDATA[".$row['DIS']."]]></dis>";
					$ResponseXML .= "<dis1><![CDATA[".$row['DIS1']."]]></dis1>";
					$ResponseXML .= "<dis2><![CDATA[".$row['DIS2']."]]></dis2>";
					
					$ResponseXML .= "<str_department><![CDATA[".$row['DEPARTMENT']."]]></str_department>";
					$department=$row['DEPARTMENT'];
					$_SESSION["department"]=$department;
					
					$ResponseXML .= "<str_brand><![CDATA[".$row['Brand']."]]></str_brand>";
					$brand=$row['Brand'];
					$_SESSION["brand"]=$brand;
					
					$ResponseXML .= "<str_vat><![CDATA[".$row['VAT']."]]></str_vat>";
					//$ResponseXML .= "<cur_discount1><![CDATA[".$row['cur_discount1']."]]></cur_discount1>";
					//$ResponseXML .= "<cur_discount2><![CDATA[".$row['cur_discount2']."]]></cur_discount2>";
					$ResponseXML .= "<cur_subtotal><![CDATA[".number_format($row['AMOUNT'], 2, ".", ",")."]]></cur_subtotal>";
					$ResponseXML .= "<cur_discount><![CDATA[".number_format($row['DISCOU'], 2, ".", ",")."]]></cur_discount>";
					$ResponseXML .= "<cur_tax><![CDATA[".number_format($row['VAT_VAL'], 2, ".", ",")."]]></cur_tax>";
					$ResponseXML .= "<cur_invoiceval><![CDATA[".number_format($row['GRAND_TOT'], 2, ".", ",")."]]></cur_invoiceval>";
						
				}				
		
				
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"70\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"350\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";
							
			/*$sql_data = mysql_query("Select CAS_INV_NO_m from invpara") or die(mysql_error());
			$row = mysql_fetch_array($sql_data);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno=trim("CRI/ ").substr($tmpinvno, $lenth-7);*/
					
				$sql_data = mysql_query("delete from tmp_ord_data where tmp_no='".$_SESSION["tmp_no_ord"]."'") or die(mysql_error());
				//echo "Select * from s_cusordtrn where REF_NO='".$inv."'";
				$sql_data = mysql_query("Select * from s_cusordtrn where REF_NO='".$inv."'") or die(mysql_error());
				while($row = mysql_fetch_array($sql_data)){
					$sql_itdata = mysql_query("Select * from s_mas where STK_NO='".$row['STK_NO']."' and BRAND_NAME='".$brand."'") or die(mysql_error());
					$rowit = mysql_fetch_array($sql_itdata);
							
					//$a="Insert into tmp_ord_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$row['REF_NO']."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$row["subtot"].", '".$row['BRAND']."')";
					//echo $a;	
				//	echo "Insert into tmp_ord_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$invno."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$row["subtot"].", '".$row['BRAND']."')";
					$sql_tmp = mysql_query("Insert into tmp_ord_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand, tmp_no, part_no) values ( '".$inv."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".($row['PRICE']*$row['QTY']).", '".$row['BRAND']."', '".$_SESSION["tmp_no_ord"]."', '".$row["PART_NO"]."')") or die(mysql_error());
					
						
						
			
			 	$ResponseXML .= "<tr>
                              
                             <td >".$row['STK_NO']."</a></td>
  							 <td >".$row['DESCRIPT']."</a></td>
							 <td >".number_format($row['PRICE'], 2, ".", ",")."</a></td>
							 <td >".$row['QTY']."</a></td>
							 <td >".number_format($row['DIS_per'], 2, ".", ",")."</td>
							 <td >".number_format($row['subtot'], 2, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['STK_NO']."  name=".$row['STK_NO']." onClick=\"del_item('".$row['STK_NO']."');\"></td>";
							 
							 	include_once("connection.php");
							 
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['STK_NO']."' AND STO_CODE='".$department."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td >".$qty."</a></td>
                            </tr>";
							
							
            					
				}
			
			    $ResponseXML .= "   </table>]]></sales_table>";
	
	
	
	
		$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
					$sql = mysql_query("CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error());
	

	
	
				
				$sql = mysql_query("Select * from vendor where CODE='".$cuscode."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					
					$OldRefno = "";
					$NewRefNo = "";
					$sql1 = mysql_query("SELECT  * From ref_history WHERE NewRefNo = '".$salesrep."'") or die(mysql_error());
					if($row1 = mysql_fetch_array($sql1)){
						$OldRefno = trim($row1["OldRefno"]);
    					$NewRefNo = trim($row1["NewRefNo"]);	
					}
					
					$OutpDAMT = 0;
					$OutREtAmt = 0;
					$OutInvAmt = 0;
					

		
					$sql1 = mysql_query("select * from brand_mas where barnd_name='".trim($brand)."'") or die(mysql_error());
					
					if($row1 = mysql_fetch_array($sql1)){
						if (is_null($row1["class"])==false){ $InvClass = trim($row1["class"]); }
					}
					
					//$sql1 = mysql_query("select sum(grand_tot-totpay) as totOut from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='".trim($cuscode)."' and sal_ex='".trim($salesrep)."' and class='".$InvClass."'") or die(mysql_error());
					
				if ($NewRefNo==$salesrep){
					$sqlview = mysql_query("select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='".trim($cuscode)."' and (sal_ex='".$OldRefno."' or sal_ex='".trim($salesrep)."' and class='".$InvClass."'") or die(mysql_error());
				} else {
					$sqlview = mysql_query("select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='".trim($cuscode)."' and sal_ex='".trim($salesrep)."' and class='".$InvClass."'") or die(mysql_error());
				}
				
					$rowview = mysql_fetch_array($sqlview);
						if (is_null($rowview["totout"])==false) { $OutInvAmt = $rowview["totout"]; }



				if ($NewRefNo==$salesrep){
					$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and (sal_ex='".$OldRefno."' or sal_ex='".trim($salesrep)."'") or die(mysql_error());
				} else {	
					$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salesrep)."'") or die(mysql_error());
				}
				while($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
					$sqlstr = mysql_query("select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"])."'") or die(mysql_error());
						//echo "select * from s_sttr where st_refno='".trim($rowinvcheq["refno"])."' and st_chno ='".trim($rowinvcheq["cheque_no"])."'";
						while($rowstr = mysql_fetch_array($sqlstr)){
						  	$sqltmp = mysql_query("select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='".trim($rowstr["ST_INVONO"])."' ") or die(mysql_error());
                    		if($rowstmp = mysql_fetch_array($sqltmp)){
								
                    			if (trim($rowstmp["class"] == $InvClass)) {
                   			 		$OutpDAMT = $OutpDAMT + $rowstr["ST_PAID"];
								}
               			     }
                		}
     				}	
	 
	 
	 	 $pend_ret_set = 0;
		 $sqlview = mysql_query("SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE CHE_DATE >'".date("Y-m-d")."' AND CUS_CODE='".trim($cuscode)."' and trn_type='RET'") or die(mysql_error());
          $rowsview = mysql_fetch_array($sqlview);
			if( is_null($rowsview["che_amount"])==false){ $pend_ret_set = $rowsview["che_amount"]; }
							
     
	 	if ($NewRefNo==$salesrep){
		
     		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and (S_REF='".$salesrep."' or S_REF='" & $OldRefno & "') ") or die(mysql_error());
		
		} else {
	 
	 		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".$salesrep."' ") or die(mysql_error());
			
		}	
		$rowscheq = mysql_fetch_array($sqlcheq);
		if (is_null($rowscheq["tot"])==false){ 
			$OutREtAmt=$rowscheq["tot"];
		} else {
			$OutREtAmt=0;
		}
 
   
		$ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td width=\"200\"><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutREtAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutpDAMT, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";
						 
        
        $sqlbrtrn = mysql_query("select * from br_trn where Rep='".trim($salesrep)."' and brand='".$InvClass."' and cus_code='".trim($cuscode)."' ") or die(mysql_error());
       if( $rowsbrtrn = mysql_fetch_array($sqlbrtrn)){
	   	if (is_null($rowsbrtrn["credit_lim"])==false){
			$crLmt = $rowsbrtrn["credit_lim"];
		} else {
			$crLmt =0;
		}
		
		if (is_null($rowsbrtrn["tmpLmt"])==false){
			$tmpLmt = $rowsbrtrn["tmpLmt"];
		} else {
			$tmpLmt =0;
		}
		
		if (is_null($rowsbrtrn["CAT"])==false){ $cuscat=$rowsbrtrn["CAT"]; }
		if ($cuscat="A") { $m=2.5; }
		if ($cuscat="B") { $m=2.5; }
		if ($cuscat="C") { $m=1; }
			
		$txt_crelimi="0";
		$txt_crebal="0";
		
		$txt_crelimi=number_format($crLmt, 2, ".", ",");
		
		$txt_crebal = number_format($crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set, 2, ".", ",");
			
		
		$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
        $ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
	   } else {
	   	$ResponseXML .= "<txt_crelimi><![CDATA[0.00]]></txt_crelimi>";
        $ResponseXML .= "<txt_crebal><![CDATA[0.00]]></txt_crebal>";
	   }
		
		$creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
		
  		$ResponseXML .= "<creditbalance><![CDATA[".number_format($creditbalance, 2, ".", ",")."]]></creditbalance>";

				
				
		 			$sql = mysql_query("select dis from brand_mas where barnd_name = '".trim($brand)."'") or die(mysql_error());
					if ($row = mysql_fetch_array($sql)){	
						$ResponseXML .= "<dis><![CDATA[".$row["dis"]."]]></dis>";
					}
			
				}
				
		
		
			
		$ResponseXML .= "</salesdetails>";		

				$_SESSION["print"]=1;

				echo $ResponseXML;
				
				
	
}


if ($_GET["Command"]=="pass_invno_to_inv"){

header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$brand="";
			$salrep="";
			$cuscode="";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			$ResponseXML .= "<stname><![CDATA[".$_GET["stname"]."]]></stname>";
					$inv= $_GET['invno']; 
					$_SESSION["invno"]=$_GET['invno']; 
					$_SESSION["salesord1"]=$_GET['invno']; 
					
				
					
					
			 		//$tmpinvno="0000".substr($_GET['invno'], 4, 7) ;
					//$lenth=strlen($tmpinvno);
					//$serial=substr($tmpinvno, $lenth-7);
					//$inv=substr($_GET['invno'], 0, 3).substr("\ ", 0, 1).$serial;
				$a="Select * from s_cusordmas where REF_NO='".$inv."'";
				
				$sql = mysql_query("Select * from s_cusordmas where REF_NO='".$inv."'") or die(mysql_error());
				
				if($row = mysql_fetch_array($sql)){
				
					$ResponseXML .= "<str_invoiceno><![CDATA[".$row['REF_NO']."]]></str_invoiceno>";
					$ResponseXML .= "<str_crecash><![CDATA[".$row['TYPE']."]]></str_crecash>";
					$ResponseXML .= "<sdate><![CDATA[".$row['SDATE']."]]></sdate>";
					$cuscode=$row['C_CODE'];
					$ResponseXML .= "<str_customecode><![CDATA[".$row['C_CODE']."]]></str_customecode>";
					$_SESSION["custno"]=$row['C_CODE'];
					//$_SESSION["tmp_no_salinv"]= $row['tmp_no'];
					
					$sqlcustomer = mysql_query("Select * from vendor where CODE='".$row['C_CODE']."'") or die(mysql_error());
					if($rowcustomer = mysql_fetch_array($sqlcustomer)){
						$ResponseXML .= "<str_customername><![CDATA[".$rowcustomer['NAME']."]]></str_customername>";
						$ResponseXML .= "<str_address><![CDATA[".$rowcustomer['ADD1']." ".$rowcustomer['ADD2']."]]></str_address>";
						$ResponseXML .= "<str_vatno1><![CDATA[".$rowcustomer['vatno']."]]></str_vatno1>";
						$ResponseXML .= "<str_vatno2><![CDATA[".$rowcustomer['svatno']."]]></str_vatno2>";
						$ResponseXML .= "<cur_balance><![CDATA[".$rowcustomer['CUR_BAL']."]]></cur_balance>";
					}
					
					//$ResponseXML .= "<str_vatno2><![CDATA[".$row['str_vatno2']."]]></str_vatno2>";
					$ResponseXML .= "<str_salesrep><![CDATA[".$row['SAL_EX']."]]></str_salesrep>";
					$salrep=$row['SAL_EX'];
					//$ResponseXML .= "<str_salesorder1><![CDATA[".$row['str_salesorder1']."]]></str_salesorder1>";
					//$ResponseXML .= "<str_salesorder2><![CDATA[".$row['str_salesorder2']."]]></str_salesorder2>";
					$ResponseXML .= "<dte_deliverdate><![CDATA[".$row['REQ_DATE']."]]></dte_deliverdate>";
					//$ResponseXML .= "<str_orderno1><![CDATA[".$row['ORD_NO']."]]></str_orderno1>";
					//$ResponseXML .= "<str_orderno2><![CDATA[".$row['ORD_DA']."]]></str_orderno2>";
					//$ResponseXML .= "<cur_credit><![CDATA[".$row['cur_credit']."]]></cur_credit>";
					
					
					$ResponseXML .= "<dis><![CDATA[".$row['DIS']."]]></dis>";
					$ResponseXML .= "<dis1><![CDATA[".$row['DIS1']."]]></dis1>";
					$ResponseXML .= "<dis2><![CDATA[".$row['DIS2']."]]></dis2>";
					
					$ResponseXML .= "<str_department><![CDATA[".$row['DEPARTMENT']."]]></str_department>";
					$department=$row['DEPARTMENT'];
					$_SESSION["department"]=$row['DEPARTMENT'];
					$ResponseXML .= "<str_brand><![CDATA[".$row['Brand']."]]></str_brand>";
					$_SESSION["brand"]=$row['Brand'];
					$brand=$row['Brand'];
					$ResponseXML .= "<str_vat><![CDATA[".$row['VAT']."]]></str_vat>";
					//$ResponseXML .= "<cur_discount1><![CDATA[".$row['cur_discount1']."]]></cur_discount1>";
					//$ResponseXML .= "<cur_discount2><![CDATA[".$row['cur_discount2']."]]></cur_discount2>";
					$ResponseXML .= "<cur_subtotal><![CDATA[".number_format($row['AMOUNT'], 2, ".", ",")."]]></cur_subtotal>";
					$ResponseXML .= "<cur_discount><![CDATA[".number_format($row['DISCOU'], 2, ".", ",")."]]></cur_discount>";
					$ResponseXML .= "<cur_tax><![CDATA[".number_format($row['VAT_VAL'], 2, ".", ",")."]]></cur_tax>";
					$ResponseXML .= "<cur_invoiceval><![CDATA[".number_format($row['GRAND_TOT'], 2, ".", ",")."]]></cur_invoiceval>";
						
				}				
		
				
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"0\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							  <td width=\"70\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"350\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
							  <td width=\"0\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"></font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							 
                            </tr>";
							
			/*$sql_data = mysql_query("Select CAS_INV_NO_m from invpara") or die(mysql_error());
			$row = mysql_fetch_array($sql_data);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno=trim("CRI/ ").substr($tmpinvno, $lenth-7);*/
				$i=1;	
				
				$sql_data = mysql_query("delete from tmp_inv_data where tmp_no='".$_SESSION["tmp_no_salinv"]."'") or die(mysql_error());
				//echo "Select * from s_cusordtrn where REF_NO='".$inv."'";
				$sql_data = mysql_query("Select * from s_cusordtrn where REF_NO='".$inv."'") or die(mysql_error());
				while($row = mysql_fetch_array($sql_data)){
					$sql_itdata = mysql_query("Select * from s_mas where STK_NO='".$row['STK_NO']."' and BRAND_NAME='".$brand."'") or die(mysql_error());
					$rowit = mysql_fetch_array($sql_itdata);
							
					//$a="Insert into tmp_ord_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$row['REF_NO']."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$row["subtot"].", '".$row['BRAND']."')";
					//echo $a;	
					//echo "Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand, tmp_no) values ( '".$_GET["newinvno"]."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$row["subtot"].", '".$row['BRAND']."', '".$_SESSION["tmp_no_salinv"]."')";
					//$sql="Insert into tmp_ord_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, tmp_no, part_no)values 
			//('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.", '".$_GET["brand"]."', '".$_SESSION["tmp_no_ord"]."', '".$_GET["str_partno"]."') ";
			
					
					
					$sql_tmp = mysql_query("Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand, actual_selling, ad, tmp_no) values ( '".$_GET["newinvno"]."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".(($row['PRICE']*$row['QTY'])-$row['DIS_rs']).", '".$row['BRAND']."', ".$rowit["SELLING"].", '".$row["ad"]."', '".$_SESSION["tmp_no_salinv"]."')") or die(mysql_error());
				}
				
			$i=1;
			//$sql="Select * from tmp_inv_data where tmp_no='".$_SESSION["tmp_no_salinv"]."'";
			$sql = mysql_query("Select * from tmp_inv_data where tmp_no='".$_SESSION["tmp_no_salinv"]."'") or die(mysql_error());
			while($row = mysql_fetch_array($sql)){
		
				$id="id".$i;		
				$code="code".$i;
				$itemd="itemd".$i;
				$rate="rate".$i;
				$actual_selling="actual_selling".$i;
				$qty="qty".$i;			
				$discountper="discountper".$i;			
				$subtotal="subtotal".$i;	
				$discount="discount".$i;	
				$ad="ad".$i;	
						
             	$ResponseXML .= "<tr>  
				             <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$id."'>".$row['id']."</div></td>                             <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$code."'>".$row['str_code']."</div></td>
							 <td onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$itemd."'>".$row['str_description']."</div></td>
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><input type=\"text\"  class=\"text_purchase3\" name=\"".$rate."\" id=\"".$rate."\" size=\"15\"  value=\"".number_format($row['cur_rate'], 2, ".", ",")."\"  onblur=\"calc1_table('".$i."');\"  onkeypress=\"keyset('credper',event);\" /></td>
							 <td align=right ><input type=\"hidden\"  class=\"text_purchase3\" name=\"".$actual_selling."\" id=\"".$actual_selling."\" size=\"15\"  value=\"".number_format($rowit['SELLING'], 2, ".", ",")."\"  /></td>
							  <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><input type=\"text\"  class=\"text_purchase3\" name=\"".$qty."\" id=\"".$qty."\" size=\"15\"  value=\"".number_format($row['cur_qty'], 0, ".", ",")."\"  onblur=\"calc1_table('".$i."');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$discountper."'>".number_format($row['dis_per'], 2, ".", ",")."</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"".$discount."\" id=\"".$discount."\" size=\"15\"  value=\"".number_format($row['cur_discount'], 2, ".", ",")."\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('".$row['str_code']."');\"><div id='".$subtotal."'>".number_format($row['cur_subtot'], 2, ".", ",")."</div></td>";
							 if ($row['ad']=="1"){
							 	$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."' checked></td>";
							} else {
								$ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>";
							}
							 $ResponseXML .= "<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>
							 
					       </tr>";
			
			 	
						$i=$i+1;	
							
            					
				}
			
			    $ResponseXML .= "   </table>]]></sales_table>";
	
		$ResponseXML .= "<item_count><![CDATA[".$i."]]></item_count>"; 

	//$cuscode=$_GET["custno"];	
	$RET_AMOUNT = 0;
	$PD_AMOUNT = 0;
	$OUT_AMOUNT = 0;

	
	$sql = mysql_query("select * from vendor where CODE = '".trim($cuscode)."'") or die(mysql_error());
	if ($row = mysql_fetch_array($sql)){	
		
		$sqlchq = mysql_query("SELECT che_amount FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".$row["CODE"]."'") or die(mysql_error());
		
		while ($rowchq = mysql_fetch_array($sqlchq)){
			$PD_AMOUNT = $PD_AMOUNT + $rowchq["che_amount"];
		}	
		
		if (is_null($row["AltMessage"])==false ){
           	if (trim($row["AltMessage"]) != ""){
		   		$ResponseXML .= "<AltMessage><![CDATA[".$row['AltMessage']."]]></AltMessage>"; 
			} else {
				$ResponseXML .= "<AltMessage><![CDATA[]]></AltMessage>"; 
			}
		} else {
			$ResponseXML .= "<AltMessage><![CDATA[]]></AltMessage>"; 
        }
		
		if ($row["chk_bangr"] == "1"){
			
           $dateDiff = $row["bank_gr_date"] - date("Y-m-d");
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
			$ResponseXML .= "<over60_txt><![CDATA[60]]></over60_txt>"; 
			$_SESSION["inv_status"]="0";
			if (is_null($row["Over_DUE_IG_Date"])==false){
				if ($row["Over_DUE_IG_Date"]==date("Y-m-d")){
					$ResponseXML .= "<over60_qst><![CDATA[This is Over 60 Days Customer Do you want to Proceed]]></over60_qst>";
		
					$sqltmpCrLmt = mysql_query("insert into tmpcrlmt (sdate, stime, tmpLmt, Class, Rep,cuscode, crLmt,  FLAG) values ('".date("Y-m-d")."','".date("h:i:s")."' , ".$mdays." ,'NB','NR','".trim($cuscode)."','0', 'O60')") or die(mysql_error());
					
				} else {
					$ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
				}
			} else {
				$ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
			}
		} else {
			$ResponseXML .= "<over60_message><![CDATA[]]></over60_message>"; 
			$ResponseXML .= "<over60_txt><![CDATA[0]]></over60_txt>"; 
		}
	 } else {
		  	$ResponseXML .= "<over60_message><![CDATA[]]></over60_message>"; 
			$ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
			$ResponseXML .= "<over60_txt><![CDATA[0]]></over60_txt>"; 
    }
     
    $sqls_cheq = mysql_query("Select * from s_cheq where CR_CHEVAL-PAID>0 and CR_FLAG='0' and CR_C_CODE='".trim($cuscode)."'" ) or die(mysql_error());
	if ($rows_cheq = mysql_fetch_array($sqls_cheq)){
		$ResponseXML .= "<chq_message><![CDATA[Return Cheque]]></chq_message>";
		$_SESSION["inv_status"]=0;
		if (is_null($row["Over_DUE_IG_Date"])==false){
			if ($row["Over_DUE_IG_Date"]==date("Y-m-d")){
				$ResponseXML .= "<chq_message_que><![CDATA[Do You Want To Continue with Return Cheques]]></chq_message_que>";
				
				$sqltmpCrLmt = mysql_query("insert into tmpcrlmt (sdate, stime, tmpLmt, Class, Rep,cuscode, crLmt, FLAG) values ('".date("Y-m-d")."', '".date("h:i:s")."', '0' ,'NB','NR','".trim($cuscode)."','0', 'RTN'") or die(mysql_error());
			} else {
				$ResponseXML .= "<chq_message_que><![CDATA[]]></chq_message_que>";
			}
		}	
	} else {
		$ResponseXML .= "<chq_message><![CDATA[]]></chq_message>";
		$ResponseXML .= "<chq_message_que><![CDATA[]]></chq_message_que>";
	} 
	
		

		
        
        if (is_null($row["cLIMIT"])==false){
			//$ResponseXML .= "<txt_crelimi><![CDATA[".number_format($row['cLIMIT']+$row['temp_limit'], 2, ".", ",")."]]></txt_crelimi>"; 
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
	$sqlclass = mysql_query("select class from brand_mas where barnd_name='".trim($brand)."'") or die(mysql_error());
	if ($rowclass = mysql_fetch_array($sqlclass)){
		if (is_null($rowclass["class"])==false){
			$InvClass=$rowclass["class"];
		}
	}
	//echo $InvClass;
	//echo "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($salrep)."' and class='".$InvClass."'";
	$sqloutinv = mysql_query("select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($salrep)."' and class='".$InvClass."'") or die(mysql_error());
	if ($rowoutinv = mysql_fetch_array($sqloutinv)){
		if (is_null($rowoutinv["totout"])==false){
			$OutInvAmt=$rowoutinv["totout"];
		}
	}
//echo $OutInvAmt;
$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salrep)."'") or die(mysql_error());
	while($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
		$sqlsttr = mysql_query("select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"]) ."'") or die(mysql_error());
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
		$sqlinvcheq = mysql_query("SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='RET'") or die(mysql_error());
		if($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
			if (is_null($rowinvcheq["che_amount"])==false){
				$pend_ret_set=$rowinvcheq["che_amount"];
			}
		}
		
		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".trim($salrep)."'") or die(mysql_error());
		if($rowcheq = mysql_fetch_array($sqlcheq)){
			if (is_null($rowcheq["tot"])==false){
				$OutREtAmt=$rowcheq["tot"];
				$ResponseXML .= "<msg_return><![CDATA[Return Cheques Available]]></msg_return>";
			} else {
				$OutREtAmt=0;
				$ResponseXML .= "<msg_return><![CDATA[]]></msg_return>";
			}
		} else {
			$ResponseXML .= "<msg_return><![CDATA[]]></msg_return>";	
		}
		
            

        
 $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutREtAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutpDAMT, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";
						 		

      $sqlbr_trn = mysql_query("select * from br_trn where Rep='".trim($salrep)."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'") or die(mysql_error());  
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
		
		if (is_null($rowbr_trn["CAT"])==false) {
			$cuscat = trim($rowbr_trn["CAT"]);
            if ($cuscat == "A"){ $m = 2.5; }
            if ($cuscat == "B"){ $m = 2.5; }
            if ($cuscat == "C"){ $m = 1; }
			if ($cuscat == "D"){ $m = 0; }
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
			//$crebal=$crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
           // $txt_crebal = number_format($crebal, "2", ",", "'");
		   	$txt_crebal = $crLmt * $m - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
          } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
          }
         $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;

	   			
			
			 
    }    
			$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
			$ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
			$ResponseXML .= "<crebal><![CDATA[".$crebal."]]></crebal>";
          
         	  $ResponseXML .= "<creditbalance><![CDATA[".number_format($txt_crebal, "2", ".", ",")."]]></creditbalance>";

		$ResponseXML .= "</salesdetails>";
		
		$_SESSION["print"]=1;	
		echo $ResponseXML;
}



if ($_GET["Command"]=="assign_brand"){
	$_SESSION["brand"]=$_GET["brand"];
	//echo $_SESSION["brand"];
	
	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
	
	
	$sql = mysql_query("CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error());
	

	
	header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		$ResponseXML = "";
		$ResponseXML .= "<salesdetails>";
		
	$OutpDAMT = 0;
	$OutREtAmt = 0;
	$OutInvAmt = 0;
	
	$InvClass=" ";
	
	
	$sql = mysql_query("select class from brand_mas where barnd_name = '".trim($_GET["brand"])."'") or die(mysql_error());
	if($row = mysql_fetch_array($sql)){
		if (is_null($row["class"])==false) {
			$InvClass = trim($row["class"]);		
		}
	}	

	/*If InvClass = "" Then
		MsgBox "Brand master file not complete"
	Exit Sub
	End If*/
	
	if ($InvClass!=""){
		$cmbrep=trim(substr($_GET["salesrep"], 0, 5));
		
		$sql = mysql_query("select sum(grand_tot-totpay) as totOut from view_s_salma where grand_tot>totpay and cancell='0' and c_code='".trim($cuscode)."' and sal_ex='".$cmbrep."' and class='".$InvClass."'") or die(mysql_error());
		if($row = mysql_fetch_array($sql)){
		
		   if (is_null($row["totOut"])==false){
		   	$OutInvAmt = $row["totOut"];
			
			}
		}
		
 		
		$sql = mysql_query("SELECT * FROM s_invcheq WHERE CHE_DATE>'".date("Y-m-d")."' AND CUS_CODE='".trim($cuscode)."' and trn_type='REC' and sal_ex='".$cmbrep."'") or die(mysql_error());
		while($row = mysql_fetch_array($sql)){
		    $sql1 = mysql_query("select * from s_sttr where st_refno='".trim($row["REFNO"])."' and st_chno ='".trim($row["cheque_no"])."'") or die(mysql_error());
			while($row1 = mysql_fetch_array($sql1)){
				$sql2 = mysql_query("select class from view_s_salma where ref_no='".trim($row["ST_INVONO"])."' ") or die(mysql_error());
				if ($row2 = mysql_fetch_array($sql2)){
                    if (trim($row2["Class"]) == $InvClass) {
                    	$OutpDAMT = $OutpDAMT + $row1["ST_PAID"];
                    }
                }
			}
		}
		
		$pend_ret_set = 0;		
		$sql = mysql_query("SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE CHE_DATE >'".date("Y-m-d")."' AND CUS_CODE='".trim($cuscode)."' and trn_type='RET' ") or die(mysql_error());
				if ($row = mysql_fetch_array($sql)){	
					if (is_null($row["che_amount"])==false){
						$pend_ret_set = $row["che_amount"];
					}
				}
						
        
 /*       $pend_ret_set = 0;
      	$sql = mysql_query("SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE CHE_DATE >'".date("Y-m-d")."' AND CUS_CODE='".trim(txt_cuscode)."' and trn_type='RET' ") or die(mysql_error());
		if ($row = mysql_fetch_array($sql)){	
       
        	if (is_null($row["che_amount"]==false)) 
			{	
				$pend_ret_set = $row["che_amount"];
			}
		}	*/


       
		 $sql = mysql_query("Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='".trim(txt_cuscode). "'  and CR_CHEVAL-paid>0 and cr_flag='0' and s_ref='".trim($cmbrep)."' ") or die(mysql_error());
		if ($row = mysql_fetch_array($sql)){	
		
        	if (is_null($row["tot"]==false)){
           		$OutREtAmt = $row["tot"];
        	} else {
           		$OutREtAmt = 0;
        	}
        }
		
		
		
        $ResponseXML .= "<sales_table><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>".number_format($OutInvAmt, 2, ".", ",")."</td></tr>
						 <td>Return Cheqe Amount</td><td>".number_format($OutREtAmt, 2, ".", ",")."</td></tr>
						 <td>Pending Cheque Amount</td><td>".number_format($OutpDAMT, 2, ".", ",")."</td></tr>
						 <td>PSD Cheque Settlments</td><td>".number_format($pend_ret_set, 2, ".", ",")."</td></tr>
						 <td>Total</td><td>".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."</td></tr>
						 </table></table>]]></sales_table>";
				

        
		  $sql = mysql_query("select * from br_trn where rep='".$cmbrep."' and brand='".trim($InvClass)."' and cus_code='".trim($cuscode)."' ") or die(mysql_error());
		if ($row = mysql_fetch_array($sql)){	
		           
            if (is_null($row["credit_lim"]==false)){
               $crLmt = $row["credit_lim"];
            } else {
               $crLmt = 0;
            }
			
			if (is_null($row["tmpLmt"]==false)){
               $tmpLmt = $row["tmpLmt"];
            } else {
               $tmpLmt = 0;
            }
			
			if (is_null($row["cat"]==false)){
               $cuscat = trim($row["cat"]);
            }
            
			if ($cuscat=="A"){ $m = 2.5; }
			if ($cuscat=="B"){ $m = 2.5; }
			if ($cuscat=="C"){ $m = 1; }
                      
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi =number_format($crLmt, 2, ".", ",");
            $txt_crebal = number_format($crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set, 2, ".", ",");
			
			$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
			$ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
          } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
			
			$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
			$ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
          }
          $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
          $ResponseXML .= "<creditbalance><![CDATA[".$creditbalance."]]></creditbalance>";
		  
		 $sql = mysql_query("select dis from brand_mas where barnd_name = '".trim($_GET["brand"])."'") or die(mysql_error());
		if ($row = mysql_fetch_array($sql)){	
			$ResponseXML .= "<dis><![CDATA[".$row["dis"]."]]></dis>";
		}
          $xx = 1;
 		}	
		
		
			
		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML;
}	
?>
