<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("connectioni.php");
	
	
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
		
		if($_GET["Command"]=="add_address")
		{
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;
			
			
	/*		$sql="Select * from tmp_army_no where edu= '".$_GET['edu']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			if($row = mysqli_fetch_array($result)){
				$ResponseXML .= "exist";
				
				
				
			}	else {*/
			
		//	$ResponseXML .= "";
			//$ResponseXML .= "<ArmyDetails>";
			
		/*	$sql1="Select * from mas_educational_qualifications where str_Educational_Qualification= '".$_GET['edu']."'";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			$row1 = mysqli_fetch_array($result1);
			$ResponseXML .=  $row1["int_Educational_Qulifications"];*/
			
			$sqlt="Select * from customer_mast where id ='".$_GET['customerid']."'";
			
			$resultt =mysqli_query($GLOBALS['dbinv'],$sqlt) ; 
			if ($rowt = mysqli_fetch_array($resultt)){
				echo $rowt["str_address"];
			}
			
			
				
			
	}
	
			
		if($_GET["Command"]=="new_inv")
		{
			
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			$sql="Select ARR from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["ARR"];
			
			$lenth=strlen($tmpinvno);
			$invno=trim("ARR/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["invno"]=$invno;
			
			$sql="Select ARR from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$_SESSION["tmp_no_purret"]="ARR/".$row["ARR"];
			
		//	$sql="delete from tmp_grn_data where str_invno='".$invno."'";
		//	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			echo $invno;
			
			
		}
	
	
	if($_GET["Command"]=="add_tmp")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="delete from tmp_grn_data where str_code='".$_GET['itemcode']."' and str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			$rate=str_replace(",", "", $_GET["rate"]);
			$qty=str_replace(",", "", $_GET["qty"]);
			$discount=str_replace(",", "", $_GET["discount"]);
			$subtotal=str_replace(",", "", $_GET["subtotal"]);
			
			$sql="Insert into tmp_grn_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.") ";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_grn_data where str_invno='".$_GET['invno']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['cur_rate'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['cur_qty'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($_GET["discountper"], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['cur_subtot'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
							 include_once("connectioni.php");
						
							 $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$department."'") or die(mysqli_error());
					if($rowqty = mysqli_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td bgcolor=\"#222222\" >".$qty."</a></td>
							 
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_grn_data where str_invno='".$_GET['invno']."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$vatrate=0.12;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="non"){
					//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
					$ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";
					
					$invtot=number_format($row['tot_sub'], 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
				}
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	if($_GET["Command"]=="setord")
	{
		
		include_once("connectioni.php");
		
		$len=strlen($_GET["salesord1"]);
		$need=substr($_GET["salesord1"],$len-7, $len);
		$salesord1=trim("ORD/ ").$_GET["salesrep"].trim(" / ").$need;
		
		
		$_SESSION["custno"]=$_GET['custno'];
		$_SESSION["brand"]=$_GET["brand"];
		$_SESSION["department"]=$_GET["department"];
		
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				$cuscode=$_GET["custno"];	
				$salesrep=$_GET["salesrep"];
				$brand=$_GET["brand"];
					
			//		$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
				
					
	    //Call SETLIMIT ====================================================================
		
		
		
	/*	$sql = mysqli_query($GLOBALS['dbinv'],"DROP VIEW view_s_salma") or die(mysqli_error());
					$sql = mysqli_query($GLOBALS['dbinv'],"CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysqli_error());*/

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
	
	$sqloutinv = mysqli_query($GLOBALS['dbinv'],"select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($salesrep)."' and class='".$InvClass."'") or die(mysqli_error());
	if ($rowoutinv = mysqli_fetch_array($sqloutinv)){
		if (is_null($rowoutinv["totout"])==false){
			$OutInvAmt=$rowoutinv["totout"];
		}
	}

$sqlinvcheq = mysqli_query($GLOBALS['dbinv'],"SELECT * FROM s_invcheq WHERE che_date>'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salesrep)."'") or die(mysqli_error());
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
		
		
		$sqlcheq = mysqli_query($GLOBALS['dbinv'],"Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".trim($salesrep)."'") or die(mysqli_error());
		if($rowcheq = mysqli_fetch_array($sqlcheq)){
			if (is_null($rowcheq["tot"])==false){
				$OutREtAmt=$rowcheq["tot"];
			} else {
				$OutREtAmt=0;
			}
		}
		
            
 
$ResponseXML .= "<sales_table_acc><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>".number_format($OutInvAmt, 2, ".", ",")."</td></tr>
						 <td>Return Cheque Amount</td><td>".number_format($OutREtAmt, 2, ".", ",")."</td></tr>
						 <td>Pending Cheque Amount</td><td>".number_format($OutpDAMT, 2, ".", ",")."</td></tr>
						 <td>PSD Cheque Settlments</td><td>".number_format($pend_ret_set, 2, ".", ",")."</td></tr>
						 <td>Total</td><td>".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."</td></tr>
						 </table></table>]]></sales_table_acc>";
        

      $sqlbr_trn = mysqli_query($GLOBALS['dbinv'],"select * from br_trn where Rep='".trim($salesrep)."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'") or die(mysqli_error());  
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
			$cuscat = trim($rowbr_trn["cat"]);
            if ($cuscat = "A"){ $m = 2.5; }
            if ($cuscat = "B"){ $m = 2.5; }
            if ($cuscat = "C"){ $m = 1; }
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
		echo $ResponseXML;
				
				
	
	
	}

		
	if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_grn_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_grn_data where str_invno='".$_GET['invno']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_rate']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_qty']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_discount']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_subtot']."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
							 include_once("connectioni.php");
							 
							 $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
					if($rowqty = mysqli_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td bgcolor=\"#222222\" >".$qty."</a></td>
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table></salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	
if($_GET["Command"]=="save_item")
{

	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
	/*		$_SESSION["CURRENT_DOC"] = 1;      //document ID
			$_SESSION["VIEW_DOC"] = false ;     //view current document
			$_SESSION["FEED_DOC"] = true;       //save  current document
			$_GET["MOD_DOC"] = false  ;         //delete   current document
			$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
			$_GET["PRICE_EDIT"] = false ;       //edit selling price
			$_GET["CHECK_USER"] = false ;       //check user permission again

	*/
	
	
	
			$mvatrate=12;
			
			$cre_balance=str_replace(",", "", $_GET["balance"]);
			$totdiscount=str_replace(",", "", $_GET["totdiscount"]);
			$subtot=str_replace(",", "", $_GET["subtot"]);
			$invtot=str_replace(",", "", $_GET["invtot"]);
		  
			
			// Insert c_bal ============================================================ 
			
			$sql="insert into c_bal(REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate, RNO, Cancell) values ('".$_GET["grnno"]."', '".$_GET["grndate"]."', 'GRN', '".$_GET["cusno"]."', ".$invtot.", ".$invtot.", '".$_GET["brand"]."', '".$_GET["department"]."', '".$_GET["salesrep"]."', '0', ".$mvatrate.", '".$_GET["rno"]."', '0')";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="insert into s_crnma(REF_NO, SDATE, INVOICENO, DDATE, C_CODE, CUS_NAME, GRAND_TOT, DIS, DEPARTMENT, DEP_CODE, Brand, SAL_EX, DEV, GST, seri_no, vatrate, CANCELL) values ('".$_GET["grnno"]."', '".$_GET["grndate"]."', '".$_GET["invno"]."', '".$_GET["invdate"]."', '".$_GET["cusno"]."', '".$_GET["cusname"]."', ".$invtot.", ".$totdiscount.", '".$_GET["department"]."', '".$_GET["department"]."', '".$_GET["brand"]."', '".$_GET["salesrep"]."', '0', ".$mvatrate.", '".$_GET["serialno"]."', ".$mvatrate.", '0')";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			if ($_GET["serialno"]!=""){
				$sql="update seri_trn set loc='01', Sold='0' where seri_no='".$_GET["serialno"]."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			}
		
			$i=1;
			
			while($_GET["mcou"]>$i){
				$stkno="stkno".$i;
				$descript="descript".$i;
				$price="price".$i;
				$qty="qty".$i;
				$preretqty="preret"+$i;
				$retqty="ret".$i;
				$disc="disc".$i;
				$subtot="subtot".$i;
				
				if ($_GET[$retqty]>0){
					$sql="insert into s_crntrn(REF_NO, STK_NO, SDATE, DESCRIPT, PRICE, DIS_P, QTY, DEPARTMENT, VAT, Seri_no, vatrate) values ('".$_GET["grnno"]."', '".$_GET[$stkno]."', '".$_GET["grndate"]."', '".$_GET[$descript]."', '".$_GET[$price]."', '".$_GET[$disc]."', ".$_GET[$retqty].", '".$_GET["department"]."', '".$_GET["vatmethod"]."', '".$_GET["serialno"]."', ".$mvatrate.")";
					//echo $sql;
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
					
					$sql="update s_invo set ret_qty=ret_qty+".$_GET[$retqty]." where REF_NO='".$_GET["grnno"]."' and STK_NO='".$_GET[$stkno]."'";
					
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
					
					$sql="update s_mas set QTYINHAND=QTYINHAND+".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."'";
					
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
					
					$sql="update s_submas set QTYINHAND=QTYINHAND+".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."' and STO_CODE='".$_GET["department"]."'";
					
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
					
					$sql="insert into s_trn(STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, seri_no) values ('".$stkno."', '".$_GET["grndate"]."', '".$_GET["grnno"]."', ".$_GET[$retqty].", 'GRN', '".$_GET["department"]."', '".$_GET["serialno"]."')";
					
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
					
					
				}
				
				$i=$i+1;
			}
			
			
			$sql="update s_salma set RET_AMO=RET_AMO+".$_GET["invtot"]." where REF_NO='".$_GET["grnno"]."' ";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
					
			$sql="insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values ('".$_GET["grnno"]."', '".$_GET["grndate"]."', '".$_GET["cusno"]."', ".$_GET["invtot"].", 'GRN', '".$_GET["department"]."', '0') ";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 

			$sql="update vendor set CUR_BAL=CUR_BAL-".$_GET["invtot"]." where CODE='".$_GET["cusno"]."' ";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="update invpara set grn=grn+1 ";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 


			
			echo "Saved";
			
			
	}
	

if($_GET["Command"]=="cancel_inv")
{

	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
	/*		$_SESSION["CURRENT_DOC"] = 1;      //document ID
			$_SESSION["VIEW_DOC"] = false ;     //view current document
			$_SESSION["FEED_DOC"] = true;       //save  current document
			$_GET["MOD_DOC"] = false  ;         //delete   current document
			$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
			$_GET["PRICE_EDIT"] = false ;       //edit selling price
			$_GET["CHECK_USER"] = false ;       //check user permission again

	*/
			$mvatrate=12;
			
			$cre_balance=str_replace(",", "", $_GET["balance"]);
			$totdiscount=str_replace(",", "", $_GET["totdiscount"]);
			$subtot=str_replace(",", "", $_GET["subtot"]);
			$invtot=str_replace(",", "", $_GET["invtot"]);
		  
			
			$sql="select * from c_bal where REFNO='".$_GET["grnno"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			if ($row = mysqli_fetch_array($result)) {
				if ($row["AMOUNT"]==$row["BALANCE"]){
					$sql1="update s_crnma set CANCELL='1' where REF_NO='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
					$sql1="update s_crntrn set CANCELL='1' where REF_NO='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
					$sql1="delete from c_bal where REFNO='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
                  
				
					$i=1;
					while ($_GET["mcou"]>$i){
						$stkno="stkno".$i;
						$descript="descript".$i;
						$price="price"+i;
						$qty="qty"+i;
						$preretqty="preret"+i;
						$retqty="ret"+i;
						$disc="disc"+i;
						$subtot="subtot"+i;
				
						if ($_GET[$retqty]>0){
							$sql1="update s_invo set ret_qty=ret_qty-".$_GET[$retqty]." where REF_NO='".$_GET["grnno"]."' and STK_NO='".$_GET[$stkno]."'";
							$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
											
							$sql1="update s_mas set QTYINHAND=QTYINHAND-".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."'";
							$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
							$sql1="update s_submas set QTYINHAND=QTYINHAND-".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."' and STO_CODE='".$_GET["department"]."'";
							$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					
                           
						}
						$i=$i+1;
					}
			
					$sql1="delete from s_trn where ltrim(REFNO)='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
							
					$sql1="delete from s_led where REF_NO='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			
		            $sql1="update s_salma set RET_AMO=RET_AMO+".$_GET["invtot"]." where REF_NO='".$_GET["grnno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			        
        		    $sql1="update vendor set CUR_BAL=CUR_BAL+".$_GET["invtot"]." where CODE='".$_GET["cusno"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ;         
               
				}
				
			}	


			
			echo "Canceled";
			
			
	}


	
if($_GET["Command"]=="tmp_crelimit")
{	
	echo "abc";
	$crLmt = 0;
	$cat = "";
	
	$rep=trim(substr($_GET["Com_rep1"], 0, 5));
	
	$sql = "select * from br_trn where rep='".$rep."' and cus_code='".trim($_GET["txt_cuscode"])."' and brand='".trim($_GET["cmbbrand1"])."'";
	echo $sql;
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
    if ($row = mysqli_fetch_array($result)) {
		$crLmt = $row["credit_lim"];
   		If (is_null($row["cat"])==false) {
      		$cat = trim($row["cat"]);
   		} else {
      		$crLmt = 0;
		}	
   	}
/*	
$_SESSION["CURRENT_DOC"] = 66     //document ID
//$_SESSION["VIEW_DOC"] = true      //  view current document
 $_SESSION["FEED_DOC"] = true      //  save  current document
//$_SESSION["MOD_DOC"] = true       //   delete   current document
//$_SESSION["PRINT_DOC"] = true     // get additional print   of  current document
//$_SESSION["PRICE_EDIT"]= true     // edit selling price
$_SESSION["CHECK_USER"] = true    // check user permission again
$crLmt = $crLmt;
setlocale(LC_MONETARY, "en_US");
$CrTmpLmt = number_format($_GET["txt_tmeplimit"], 2, ".", ",");

$REFNO = trim($_GET["txt_cuscode"]) ;

$AUTH_USER="tmpuser";

$sql = "insert into tmpCrLmt (sdate, stime, username, tmpLmt, class, rep, cuscode, crLmt, cat) values 
        ('".date("Y-m-d")."','".date("H:i:s", time())."' ,'".$AUTH_USER."',".$CrTmpLmt." ,'".trim($_GET["cmbbrand1"])."','".$rep."','".trim($_GET["txt_cuscode"])."',".$crLmt.",'".$cat"' )";
$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 

$sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
if ($row = mysqli_fetch_array($result)) {
   $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
   $resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);
   
} else {
  
  	$sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
 	$resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);
	
//	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
}

	If ($_GET["Check1"] == 1) {
   		$sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
	} else {	
    	$sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
	}

echo "Tempory limit updated";*/

}
	
?>