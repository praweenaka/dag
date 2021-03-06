<?php
 	
		
		
session_start();


	include_once("connectioni.php");

 
	


if ($_GET["Command"]=="pass_invno"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$brand="";
			$salrep="";
			$cuscode="";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
					$inv= $_GET['invno']; 
					$_SESSION["invno"]=$_GET['invno']; 
					
					$_SESSION["custno"]=$_GET['custno'];
					$_SESSION["brand"]=$_GET["brand"];
					$_SESSION["department"]=$_GET["department"];
			 	
				 
				$sql = mysqli_query($GLOBALS['dbinv'],"Select * from s_quomas where REF_NO='".$inv."'") or die(mysqli_error());
				
				if($row = mysqli_fetch_array($sql)){
				
					$ResponseXML .= "<str_invoiceno><![CDATA[".$row['REF_NO']."]]></str_invoiceno>";
					$ResponseXML .= "<str_crecash><![CDATA[".$row['TYPE']."]]></str_crecash>";
					$cuscode=$row['C_CODE'];
					$ResponseXML .= "<str_customecode><![CDATA[".$row['C_CODE']."]]></str_customecode>";
					$_SESSION["tmp_no_quot"]=$row['tmp_no'];
					
					$sqlcustomer = mysqli_query($GLOBALS['dbinv'],"Select * from vendor where CODE='".$row['C_CODE']."'") or die(mysqli_error());
					if($rowcustomer = mysqli_fetch_array($sqlcustomer)){
						$ResponseXML .= "<str_customername><![CDATA[".$rowcustomer['NAME']."]]></str_customername>";
						$ResponseXML .= "<str_address><![CDATA[".$rowcustomer['ADD1']." ".$rowcustomer['ADD2']."]]></str_address>";
						$ResponseXML .= "<str_vatno1><![CDATA[".$rowcustomer['vatno']."]]></str_vatno1>";
						$ResponseXML .= "<str_vatno2><![CDATA[".$rowcustomer['svatno']."]]></str_vatno2>";
					}
					
					//$ResponseXML .= "<str_vatno2><![CDATA[".$row['str_vatno2']."]]></str_vatno2>";
					$ResponseXML .= "<str_salesrep><![CDATA[".$row['SAL_EX']."]]></str_salesrep>";
					$salrep=$row['SAL_EX'];
					//$ResponseXML .= "<str_salesorder1><![CDATA[".$row['str_salesorder1']."]]></str_salesorder1>";
					//$ResponseXML .= "<str_salesorder2><![CDATA[".$row['str_salesorder2']."]]></str_salesorder2>";
					 
					$ResponseXML .= "<str_orderno1><![CDATA[".$row['ORD_NO']."]]></str_orderno1>";
					$ResponseXML .= "<str_orderno2><![CDATA[".$row['ORD_DA']."]]></str_orderno2>";
					//$ResponseXML .= "<cur_credit><![CDATA[".$row['cur_credit']."]]></cur_credit>";
					//$ResponseXML .= "<cur_balance><![CDATA[".$row['cur_balance']."]]></cur_balance>";
					
					
					
					$ResponseXML .= "<str_department><![CDATA[".$row['DEPARTMENT']."]]></str_department>";
					$ResponseXML .= "<str_brand><![CDATA[".$row['Brand']."]]></str_brand>";
					$brand=$row['Brand'];
					$ResponseXML .= "<str_vat><![CDATA[".$row['VAT']."]]></str_vat>";
					//$ResponseXML .= "<cur_discount1><![CDATA[".$row['cur_discount1']."]]></cur_discount1>";
					//$ResponseXML .= "<cur_discount2><![CDATA[".$row['cur_discount2']."]]></cur_discount2>";
					$ResponseXML .= "<cur_subtotal><![CDATA[".number_format($row['AMOUNT'], 2, ".", ",")."]]></cur_subtotal>";
					$ResponseXML .= "<cur_discount><![CDATA[".number_format($row['DISCOU'], 2, ".", ",")."]]></cur_discount>";
					$ResponseXML .= "<cur_tax><![CDATA[".number_format($row['BTT'], 2, ".", ",")."]]></cur_tax>";
					$ResponseXML .= "<cur_invoiceval><![CDATA[".number_format($row['GRAND_TOT'], 2, ".", ",")."]]></cur_invoiceval>";
					
					$ResponseXML .= "<Perform><![CDATA[".$row['Perform']."]]></Perform>";
					$ResponseXML .= "<chk1><![CDATA[".$row['Chk1']."]]></chk1>";
					$ResponseXML .= "<chk2><![CDATA[".$row['chk2']."]]></chk2>";
					$ResponseXML .= "<chk3><![CDATA[".$row['chk3']."]]></chk3>";
					$ResponseXML .= "<chk4><![CDATA[".$row['chk4']."]]></chk4>";
					$ResponseXML .= "<chk5><![CDATA[".$row['chk5']."]]></chk5>";
					$ResponseXML .= "<chk6><![CDATA[".$row['chk6']."]]></chk6>";
					$ResponseXML .= "<chk7><![CDATA[".$row['chk7']."]]></chk7>";
					$ResponseXML .= "<warranty><![CDATA[".$row['warranty']."]]></warranty>";
					$ResponseXML .= "<delivery><![CDATA[".$row['delivery']."]]></delivery>";
					$ResponseXML .= "<pay_type><![CDATA[".$row['pay_type']."]]></pay_type>";
					$ResponseXML .= "<validity><![CDATA[".$row['validity']."]]></validity>";
					$ResponseXML .= "<Country><![CDATA[".$row['Country']."]]></Country>";
					$ResponseXML .= "<GROUPS><![CDATA[".$row['GROUPS']."]]></GROUPS>";
					
				}				
		
				
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";
							
				
				$sql_data = mysqli_query($GLOBALS['dbinv'],"delete from tmp_quot_data where tmp_no='".$_SESSION["tmp_no_quot"]."'") or die(mysqli_error());
				$sql_data = mysqli_query($GLOBALS['dbinv'],"Select * from s_quotrn where REF_NO='".$inv."'") or die(mysqli_error());
				while($row = mysqli_fetch_array($sql_data)){
					$sql_itdata = mysqli_query($GLOBALS['dbinv'],"Select * from s_mas where STK_NO='".$row['STK_NO']."' and BRAND_NAME='".$brand."'") or die(mysqli_error());
					$rowit = mysqli_fetch_array($sql_itdata);
							
							
					//$sql_tmp = mysqli_query($GLOBALS['dbinv'],"Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, cur_subtot) values ( '".$row['REFNO']."', '".$row['STK_NO']."', '".$rowit['DESCRIPT']."', ".$rowit['SELLING'].", ".$row['QTY'].", ".$rowit['SELLING']*$row['QTY'].")") or die(mysqli_error());
				//	echo "Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$inv."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$row["subtot"].", '".$row['BRAND']."')";
					
					//$sql="Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$inv."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$row["subtot"].", '".$row['BRAND']."')";
				
					$subtot=(floatval($row['PRICE'])*floatval($row['QTY']))-floatval($row['DIS_rs']);
					//echo $subtot;
					
					$sql_tmp = mysqli_query($GLOBALS['dbinv'],"Insert into tmp_quot_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand, tmp_no) values ( '".$inv."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$subtot.", '".$row['BRAND']."', '".$_SESSION["tmp_no_quot"]."')") or die(mysqli_error());
					
						
			
			 	$ResponseXML .= "<tr>
                            <td onClick=\"disp_qty('".$row['STK_NO']."');\">".$row['STK_NO']."</a></td>
  							 <td onClick=\"disp_qty('".$row['STK_NO']."');\">".$row['DESCRIPT']."</a></td>
							 <td onClick=\"disp_qty('".$row['STK_NO']."');\">".number_format($row['PRICE'], 2, ".", ",")."</a></td>
							 <td onClick=\"disp_qty('".$row['STK_NO']."');\">".$row['QTY']."</a></td>
							 <td onClick=\"disp_qty('".$row['STK_NO']."');\">".number_format($row['DIS_per'], 2, ".", ",")."</td>
							 <td onClick=\"disp_qty('".$row['STK_NO']."');\">".number_format($subtot, 2, ".", ",")."</a></td>
							 <td ></td>
							 
                            </tr>";
							
							
            					
				}
			
			    $ResponseXML .= "   </table>]]></sales_table>";
	
 
	

	
	
	$OutpDAMT = 0;
	$OutREtAmt = 0;
	$OutInvAmt = 0;
	$InvClass="";
	
	$sqlclass = mysqli_query($GLOBALS['dbinv'],"select class from brand_mas where barnd_name='".trim($brand)."'") or die(mysqli_error());
	if ($rowclass = mysqli_fetch_array($sqlclass)){
		if (is_null($rowclass["class"])==false){
			$InvClass=$rowclass["class"];
		}
	}
	
	$sqloutinv = mysqli_query($GLOBALS['dbinv'],"select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($salrep)."' and class='".$InvClass."'") or die(mysqli_error());
	if ($rowoutinv = mysqli_fetch_array($sqloutinv)){
		if (is_null($rowoutinv["totout"])==false){
			$OutInvAmt=$rowoutinv["totout"];
		}
	}

$sqlinvcheq = mysqli_query($GLOBALS['dbinv'],"SELECT * FROM s_invcheq WHERE che_date>'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salrep)."'") or die(mysqli_error());
	while($rowinvcheq = mysqli_fetch_array($sqlinvcheq)){
		
		$sqlsttr = mysqli_query($GLOBALS['dbinv'],"select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"]) ."'") or die(mysqli_error());
		while($rowsttr = mysqli_fetch_array($sqlsttr)){
			$sqlview_s_salma = mysqli_query($GLOBALS['dbinv'],"select class from view_s_salma where REF_NO='".trim($rowsttr["ST_INVONO"])."'") or die(mysqli_error());
			if($rowview_s_salma = mysqli_fetch_array($sqlview_s_salma)){
				
				if (trim($rowview_s_salma["class"]) == $InvClass){
                    $OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
                }
			}
		}
	}


        
        $pend_ret_set = 0;
		
		$sqlinvcheq = mysqli_query($GLOBALS['dbinv'],"SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='RET'") or die(mysqli_error());
		if($rowinvcheq = mysqli_fetch_array($sqlinvcheq)){
			if (is_null($rowinvcheq["che_amount"])==false){
				$pend_ret_set=$rowinvcheq["che_amount"];
			}
		}
		
		
		$sqlcheq = mysqli_query($GLOBALS['dbinv'],"Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".trim($salrep)."'") or die(mysqli_error());
		if($rowcheq = mysqli_fetch_array($sqlcheq)){
			if (is_null($rowcheq["tot"])==false){
				$OutREtAmt=$rowcheq["tot"];
			} else {
				$OutREtAmt=0;
			}
		}
		
            

        

$ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td width=\"200\"><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutREtAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutpDAMT, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";


$txt_crelimi=0;
$txt_crebal=0;
$creditbalance=0;
      $sqlbr_trn = mysqli_query($GLOBALS['dbinv'],"select * from br_trn where Rep='".trim($salrep)."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'") or die(mysqli_error());  
	if($rowbr_trn = mysqli_fetch_array($sqlbr_trn)){
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
			$crebal=$crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $txt_crebal = number_format($crebal, "2", ".", ",");
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


	$_SESSION["print"]=1;
	
				echo $ResponseXML;
				
				
	
}

if ($_GET["Command"]=="assign_brand"){
	$_SESSION["brand"]=$_GET["brand"];
}	
?>
