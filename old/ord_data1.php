<?php 
session_start();

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
			
			$_SESSION["print"]=0;
			$_SESSION["save_sales_ord"]=1;
			$_SESSION["brand"]="";
			
			$sql="Select ORD_NO from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["ORD_NO"];
			$lenth=strlen($tmpinvno);
			$invno=trim("ORD/1/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["invno"]=$invno;
			
			$sql="Select ORD_NO from tmpinvpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$_SESSION["tmp_no_ord"]="SALORD/".$row["ORD_NO"];
			
			$sql1="delete from tmp_ord_data where tmp_no='".$_SESSION["tmp_no_ord"]."'";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			
			$sql1="update tmpinvpara set ORD_NO=ORD_NO+1";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			
			echo $invno;	
			
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
	
	//$sql = mysqli_query($GLOBALS['dbinv'],"DROP VIEW view_s_salma") or die(mysqli_error());
	//				$sql = mysqli_query($GLOBALS['dbinv'],"CREATE VIEW view_s_salma
//AS
//SELECT     s_salma.*, brand_mas.class AS class
//FROM         brand_mas RIGHT OUTER JOIN
//                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysqli_error());
					  
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				$cuscode=$_GET["custno"];	
				
					
					$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
				
					
				$cuscode=$_GET["custno"];	
				$sql = mysqli_query($GLOBALS['dbinv'],"Select * from vendor where CODE='".$cuscode."'") or die(mysqli_error());
				if($row = mysqli_fetch_array($sql)){
					//echo $ResponseXML;
					$OldRefno = "";
					$NewRefNo = "";
					
					$sql1 = mysqli_query($GLOBALS['dbinv'],"SELECT  * From ref_history WHERE NewRefNo = '".$_GET["salesrep"]."'") or die(mysqli_error());
					if($row1 = mysqli_fetch_array($sql1)){
						
						$OldRefno = trim($row1["OldRefno"]);
    					$NewRefNo = trim($row1["NewRefNo"]);	
					}
					
					$OutpDAMT = 0;
					$OutREtAmt = 0;
					$OutInvAmt = 0;
					

		
					$sql1 = mysqli_query($GLOBALS['dbinv'],"select * from brand_mas where barnd_name='".trim($_GET["brand"])."'") or die(mysqli_error());
					
					if($row1 = mysqli_fetch_array($sql1)){
						if (is_null($row1["class"])==false){ $InvClass = trim($row1["class"]); }
					}
					
		//////// Total Invoice Amount ///////////////////////////////////////////////////////////////	/						
				if ($NewRefNo==$_GET["salesrep"]){
					//echo "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and (SAL_EX='".$OldRefno."' or SAL_EX='".trim($_GET["salesrep"])."' and class='".$InvClass."'";
					$sqlview = mysqli_query($GLOBALS['dbinv'],"select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and (SAL_EX='".$OldRefno."' or SAL_EX='".trim($_GET["salesrep"])."' and class='".$InvClass."')") or die(mysqli_error());
				} else {
				//	echo "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where Accname != 'NON STOCK' and GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($_GET["salesrep"])."' and class='".$InvClass."'";
					$sqlview = mysqli_query($GLOBALS['dbinv'],"select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($_GET["salesrep"])."' and class='".$InvClass."'") or die(mysqli_error());
				}
				
					$rowview = mysqli_fetch_array($sqlview);
						if (is_null($rowview["totout"])==false) { $OutInvAmt = $rowview["totout"]; }


////////// PD Cheques ////////////////////////////////////////////////////////////////////////////
				if ($NewRefNo==$_GET["salesrep"]){
				
					$sqlinvcheq = mysqli_query($GLOBALS['dbinv'],"SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and (sal_ex='".$OldRefno."' or sal_ex='".trim($_GET["salesrep"])."')") or die(mysqli_error());
				} else {	
					
					$sqlinvcheq = mysqli_query($GLOBALS['dbinv'],"SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($_GET["salesrep"])."'") or die(mysqli_error());
				}
				while($rowinvcheq = mysqli_fetch_array($sqlinvcheq)){
				
					$sqlstr = mysqli_query($GLOBALS['dbinv'],"select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"])."'") or die(mysqli_error());
						
						while($rowstr = mysqli_fetch_array($sqlstr)){
							//echo "select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='".trim($rowstr["ST_INVONO"])."' ";
						  	$sqltmp = mysqli_query($GLOBALS['dbinv'],"select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='".trim($rowstr["ST_INVONO"])."' ") or die(mysqli_error());
                    		if($rowstmp = mysqli_fetch_array($sqltmp)){
								//echo $rowstmp["class"];
                    			if (trim($rowstmp["class"] == $InvClass)) {
                   			 		$OutpDAMT = $OutpDAMT + $rowstr["ST_PAID"];
								}
               			     }
                		}
     				}	
	 
////////////  Return Settlement PD Cheques////////////////////////////////////////////////////////	 
	 	 $pend_ret_set = 0;
		 $sqlview = mysqli_query($GLOBALS['dbinv'],"SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE CHE_DATE >'".date("Y-m-d")."' AND CUS_CODE='".trim($cuscode)."' and trn_type='RET'") or die(mysqli_error());
          $rowsview = mysqli_fetch_array($sqlview);
			if( is_null($rowsview["che_amount"])==false){ $pend_ret_set = $rowsview["che_amount"]; }
							

//////////// Reurn Cheques////////////////////////////////////// //   /////////////////////////////////
	 	if ($NewRefNo==$_GET["salesrep"]){
		
     		$sqlcheq = mysqli_query($GLOBALS['dbinv'],"Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and (S_REF='".$_GET["salesrep"]."' or S_REF='" . $OldRefno . "') ") or die(mysqli_error());
		
		} else {
	 
	 		$sqlcheq = mysqli_query($GLOBALS['dbinv'],"Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".$_GET["salesrep"]."' ") or die(mysqli_error());
			
		}	
		$rowscheq = mysqli_fetch_array($sqlcheq);
		if (is_null($rowscheq["tot"])==false){ 
			$OutREtAmt=$rowscheq["tot"];
		} else {
			$OutREtAmt=0;
		}
 
   
		/*$ResponseXML .= "<sales_table><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>".number_format($OutInvAmt, 2, ".", ",")."</td></tr>
						 <td>Return Cheque Amount</td><td>".number_format($OutREtAmt, 2, ".", ",")."</td></tr>
						 <td>Pending Cheque Amount</td><td>".number_format($OutpDAMT, 2, ".", ",")."</td></tr>
						 <td>PSD Cheque Settlments</td><td>".number_format($pend_ret_set, 2, ".", ",")."</td></tr>
						 <td>Total</td><td>".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."</td></tr>
						 </table></table>]]></sales_table>";*/
						 
						 
		$ResponseXML .= "<sales_table><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutREtAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutpDAMT, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table>";
						 
        
        $sqlbrtrn = mysqli_query($GLOBALS['dbinv'],"select * from br_trn where Rep='".trim($_GET["salesrep"])."' and brand='".$InvClass."' and cus_code='".trim($cuscode)."' ") or die(mysqli_error());
       if( $rowsbrtrn = mysqli_fetch_array($sqlbrtrn)){
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
		


				
				
		 			$sql = mysqli_query($GLOBALS['dbinv'],"select dis from brand_mas where barnd_name = '".trim($_GET["brand"])."'") or die(mysqli_error());
					if ($row = mysqli_fetch_array($sql)){	
						$ResponseXML .= "<dis><![CDATA[".$row["dis"]."]]></dis>";
					}
			
				}
			
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
	
	}
	
	
	if($_GET["Command"]=="cancel_inv")
{
	$sql="select last_update from invpara  ";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	$row = mysqli_fetch_array($result);	
	
	$sqlinv="select * from s_cusordmas where REF_NO='".$_GET['salesord1']."'";
	$resultinv =mysqli_query($GLOBALS['dbinv'],$sqlinv);
	if ($rowinv = mysqli_fetch_array($resultinv))
	{
		if (($rowinv["TOTPAY"]==0) and ($rowinv["SDATE"]>$row["last_update"])){
			$sql2="update s_cusordmas set CANCELL='1' where REF_NO='".$_GET['salesord1']."'";
			$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
			
			$sqltmp="select * from tmp_ord_data where str_invno='".$_GET['salesord1']."' ";
			$resulttmp =mysqli_query($GLOBALS['dbinv'],$sqltmp);
			while ($rowtmp = mysqli_fetch_array($resulttmp)){
				$sqlorddata="update s_cusordtrn set CANCELL='1' where REF_NO='".$_GET['salesord1']."'";
				$resultorddata =mysqli_query($GLOBALS['dbinv'],$sqlorddata);
			}
			echo "Canceled";
		} else {
			echo "Can't Cancel";
		}
	}	
}

	if($_GET["Command"]=="add_tmp")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			$mcount=0;
			
			//$sql="delete from tmp_ord_data where tmp_no='".$_SESSION["tmp_no_ord"]."' and str_code='".$_GET['itemcode']."' ";
			//echo $sql;
			//$ResponseXML .= $sql;
			//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			$sql="delete from tmp_ord_data str_code='".$_GET['itemcode']."' and tmp_no='".$_SESSION["tmp_no_ord"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			$rate=str_replace(",", "", $_GET["rate"]);
			$qty=str_replace(",", "", $_GET["qty"]);
			$discount=str_replace(",", "", $_GET["discount"]);
			$subtotal=str_replace(",", "", $_GET["subtotal"]);
			
			$sql="Insert into tmp_ord_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, tmp_no, part_no)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.", '".$_GET["brand"]."', '".$_SESSION["tmp_no_ord"]."', '".$_GET["str_partno"]."') ";
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
							
			
			$sql="Select * from tmp_ord_data where tmp_no='".$_SESSION["tmp_no_ord"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td >".$row['str_code']."</a></td>
							 <td >".$row['str_description']."</a></td>
							 <td >".number_format($row['cur_rate'], 2, ".", ",")."</a></td>
							 <td >".number_format($row['cur_qty'], 2, ".", ",")."</a></td>
							 <td >".$_GET["discountper"]."</a></td>
							 <td >".number_format($row['cur_subtot'], 2, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
						
						include_once("connectioni.php");
							 
							 $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
					if($rowqty = mysqli_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td >".$qty."</a></td>
						
                            </tr>";
							$mcount=$mcount+1;
			}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where tmp_no='".$_SESSION["tmp_no_ord"]."'";
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
				
				$ResponseXML .= "<mcount><![CDATA[".$mcount."]]></mcount>";
				$ResponseXML .= " </salesdetails>";
				
			
				
				
				echo $ResponseXML;
				
			
	}
	


	
if($_GET["Command"]=="delete_inv")
{
	$sql="select * from S_CUSORDMAS where REF_NO= '".trim($_GET["salesord1"])."' ";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 					
	if($row = mysqli_fetch_array($result)){	
		$sql1="UPDATE S_CUSORDMAS SET S_CUSORDMAS.CANCELL = '1' WHERE (((S_CUSORDMAS.REF_NO)='".trim($_GET["salesord1"])."'))";
		
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
		
		$sql1="UPDATE S_CUSORDTRN SET S_CUSORDTRN.CANCELL = '1' WHERE (((S_CUSORDTRN.REF_NO)='".trim($_GET["salesord1"])."'))";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 		
		
	}
	echo "Canceled";	
  
}
	
		
	if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_ord_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
			//echo $sql;
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
							
			
			$sql="Select * from tmp_ord_data where str_invno='".$_GET['invno']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td >".$row['str_code']."</a></td>
							 <td >".$row['str_description']."</a></td>
							 <td >".$row['cur_rate']."</a></td>
							 <td >".$row['cur_qty']."</a></td>
							 <td >".$row['cur_discount']."</a></td>
							 <td >".$row['cur_subtot']."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
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
				
				 $ResponseXML .= "   </table>]]></sales_table>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where str_invno='".$_GET['invno']."'";
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
							
                $ResponseXML .= "   </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	
	if($_GET["Command"]=="save_item")
		{
			
		
		//	$_SESSION["CURRENT_DOC"] = 1;      //document ID
			//$_SESSION["VIEW_DOC"] = false ;     //view current document
		//	$_SESSION["FEED_DOC"] = true;       //save  current document
		//	$_GET["MOD_DOC"] = false  ;         //delete   current document
		//	$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
		//	$_GET["PRICE_EDIT"] = false ;       //edit selling price
		//	$_GET["CHECK_USER"] = false ;       //check user permission again

			
		if ($_SESSION["save_sales_ord"]==1){
			
			$_SESSION["salesord1"]=$_GET['salesord1'];
			$_SESSION["brand"]="";
			
			$invno=$_GET['salesord1'];
			
			$sql="delete from s_cusordmas where REF_NO='".$invno."' ";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			
			// Insert s_salma ============================================================ 
			
			$sql="Select * from vendor where CODE='".$_GET['customercode']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			$row = mysqli_fetch_array($result);
			$cusname=$row["NAME"];	
			
			$totdiscount=str_replace(",", "", $_GET["totdiscount"]);
			$subtot=str_replace(",", "", $_GET["subtot"]);
			$invtot=str_replace(",", "", $_GET["invtot"]);
			$tax=str_replace(",", "", $_GET["tax"]);
			
			if ($_GET["discount_org1"]==''){
				$discount1=0;
			} else{
				$discount1=$_GET["discount_org1"];
			}
			if ($_GET["discount_org2"]==''){
				$discount2=0;
			} else{
				$discount2=$_GET["discount_org2"];
			}
			if ($_GET["discount_org3"]==''){
				$discount3=0;
			} else{
				$discount3=$_GET["discount_org3"];
			}
			
			$invtot=str_replace(",", "", $_GET["invtot"]);
			$balance=str_replace(",", "", $_GET["balance"]);
			$creditlimit=str_replace(",", "", $_GET["creditlimit"]);
			
			/*if ($_GET["balance"] < $_GET["invtot"]) {
        		$ex_lim = $invtot - $balance;
    		} else {
        		$ex_lim = 0;
    		}*/
			
			if ($balance < $invtot) {
        		$ex_lim = $invtot - $balance;
    		} else {
        		$ex_lim = 0;
        		
        		$sql_over60= "select SDATE from  s_salma where Accname != 'NON STOCK' and  C_CODE='" . trim($_GET['customercode']) . "' and GRAND_TOT-TOTPAY >1 and CANCELL=0  order by SDATE";
				$result_over60 =mysqli_query($GLOBALS['dbinv'],$sql_over60);
				if($row_over60 = mysqli_fetch_array($result_over60)){
					$diff = abs(strtotime(date("Y-m-d")) - strtotime($row_over60["SDATE"]));
					$mdays = floor($diff / (60*60*24));	
        			if ($mdays > 60) {
                		$ex_lim = 1;
            		}
        		}
        		
        		$sql_ret= "Select *  from s_cheq where CR_CHEVAL-PAID>10 and CR_FLAG='0' and CR_C_CODE='" . trim($_GET['customercode']) . "' ";
				$result_ret =mysqli_query($GLOBALS['dbinv'],$sql_ret);
				if($row_ret = mysqli_fetch_array($result_ret)){
        			$ex_lim = 1;
        		}
        		
    		}
			 	
			$sql="Insert into s_cusordmas(REF_NO, TRN_TYPE, SDATE, C_CODE, BRAND, CUS_NAME, VAT, TYPE, DISCOU, AMOUNT, GRAND_TOT, DIS, DIS1, DIS2,  DEPARTMENT, SAL_EX, VAT_VAL, CANCELL, DEV, REQ_DATE, INVNO, tmp_no, Limit_need, Forward, GST, DUMMY_VAL, DIS_RUP, CASH, TOTPAY, ORD_NO, ORD_DA, SETTLED, TOTPAY1, DES_CAT, REMARK, BTT, Account, Accname, Costcenter, RET_AMO, comm, approveby) values('".$invno."', 'INV', '".$_GET["invdate"]."', '".$_GET["customercode"]."', '".$_GET["brand"]."', '".$cusname."', 	'".$_GET["vatmethod"]."', '".$_GET["paymethod"]."', ".$totdiscount.", ".$subtot.", ".$invtot.", ".$discount1.", ".$discount2.", ".$discount3.",  '".$_GET['department']."', '".$_GET["salesrep"]."', ".$tax.", '0', '".$_SESSION['dev']."', '".date("Y-m-d")."', '0', '".$_SESSION["tmp_no_ord"]."', ".$ex_lim.", 'MM', 0, 0, 0, 0, 0, '', '".$_GET["invdate"]."', '', 0, '', '', 0, '', '', '', 0, 0, 0)";
			//echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			
			
			
			// Update credit limit ==========================================================
			
	/*		$sqlbrmas="select class from brand_mas where barnd_name='".$_GET["brand"]."'";
			$resultbrmas =mysqli_query($GLOBALS['dbinv'],$sqlbrmas);	
			$rowbrmas = mysqli_fetch_array($resultbrmas);	
			
			$sql="update vendor set CUR_BAL=CUR_BAL+".$_GET["invtot"]." where CODE='".$_GET["customercode"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
				
			$sql="update BR_TRN set credit=credit+".$_GET["invtot"]." where cus_code='".$_GET["customercode"]."' and rep='".$_GET["salesrep"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	*/
			 
				
			// Update Invoice Data  ==========================================================
			
			$sql="delete from s_cusordtrn where REF_NO='".$invno."'" ;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sqltmp="select * from tmp_ord_data where tmp_no='".$_SESSION["tmp_no_ord"]."'";
			//echo $sqltmp;
			$resulttmp =mysqli_query($GLOBALS['dbinv'],$sqltmp);	
			while($rowtmp = mysqli_fetch_array($resulttmp)){	
				$sqlcost="select * from s_mas where STK_NO='".$rowtmp["str_code"]."' and BRAND_NAME='".$_GET["brand"]."'";
				//echo $sqlcost;
				$resultcost =mysqli_query($GLOBALS['dbinv'],$sqlcost);	
				$rowcost = mysqli_fetch_array($resultcost);	
				
				//$dis_per = Val(Format(MSFlexGrid1.TextMatrix(i, 2), General)) * Val(Format(MSFlexGrid1.TextMatrix(i, 3), General)) * Val(Format(MSFlexGrid1.TextMatrix(i, 4), General)) * 0.01;
			
			
			// Update s_inv, s_trn ==========================================================
				
			//	$sql="insert into s_cusordtrn (REF_NO, SDATE, STK_NO, DESCRIPT, UNIT, COST, PRICE, QTY, DEPARTMENT, DIS_PER, DIS_RS, REP, TAX_PER, BRAND, CANCELL, subtot, tmp_no) values ('".$invno."', '".$_GET["invdate"]."', '".$rowtmp["str_code"]."', '".$rowtmp["str_description"]."', 'ORD', ".$rowcost["COST"].", ".$rowtmp["cur_rate"].", ".$rowtmp["cur_qty"].", '".$_GET["department"]."', '".$rowtmp["dis_per"]."', '".$rowtmp["cur_discount"]."', '".$_GET["salesrep"]."', '12', '".$rowcost["BRAND_NAME"]."', '0', ".$rowtmp["cur_subtot"].", '".$_SESSION["tmp_no_ord"]."')" ;
				
				$sql="insert into s_cusordtrn (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, COST, PRICE, QTY, DEPARTMENT, DIS_per, DIS_rs, REP, TAX_PER, BRAND, CANCELL, tmp_no, UNIT, ret_qty, DEV, c_code, stk) values('" . trim($invno) . "','" . $_GET["invdate"] . "', '" . trim($rowtmp["str_code"]) . "','" . trim($rowtmp["str_description"]) . "', '" . trim($rowtmp["part_no"]) . "'," . $rowcost["COST"] . "," . $rowtmp["cur_rate"] . "," . $rowtmp["cur_qty"] . ",'" . trim($_GET["department"]) . "'," . $rowtmp["dis_per"] . "," . $rowtmp["cur_discount"] . ",'" . trim($_GET["salesrep"]) . "','12','" . trim($rowcost["BRAND_NAME"]) . "', '0',  '".$_SESSION["tmp_no_ord"]."', 'ORD', 0, '', '', 0)";
				//echo $sql;
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
				//echo $sql;
			//	$sql="Insert into s_trn	(STK_NO, SDATE, REFNO, QTY, DEPARTMENT) values 
			//	 ('".$rowtmp["str_code"]."',  '".$_GET["invdate"]."', '".$invno."', ".$rowtmp["cur_qty"].", '".$_GET["department"]."')";
			//	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				//echo $sql;
				
		
       		//====update stock==========================================================
			
			/*	$sql="update s_mas set QTYINHAND= QTYINHAND-".$rowtmp["cur_qty"]." where STK_NO='".$rowtmp["str_code"]."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				
				//$M_STOCODE = Trim(substr($_GET["department"], 1, 5))
				
        		$sql="update s_submas set QTYINHAND=QTYINHAND- ".$rowtmp["cur_qty"]." where stk_no= '".$rowtmp["str_code"]."'  and sto_code= '". $_GET["department"]."' ";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; */
				
				
				
			}
        
     			 $sql="delete  from tmp_ord_data where tmp_no='".$_SESSION["tmp_no_ord"]."' ";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
  
   			//====creditor file ================================================
			
   
			$sql="Insert into s_led(REF_NO, SDATE, C_CODE, amount, flag, department) values ('".$invno."', '".$_GET["invdate"]."', '".$_GET["customercode"]."', ".$_GET["invtot"].", 'INV', '".$_GET["department"]."')";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				
			$sql="update invpara set ORD_NO=ORD_NO+1";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
  
			$_SESSION["print"]=1;
			$_SESSION["save_sales_ord"]=0;
			
			echo "Saved";
		} else {
			echo "no";
		}	
			
	}

if ($_GET["Command"]=="check_print")
{
	
	echo $_SESSION["print"];
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