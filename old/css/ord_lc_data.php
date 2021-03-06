<?php 
session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
		
		if($_GET["Command"]=="add_address")
		{
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;
			
			
	/*		$sql="Select * from tmp_army_no where edu= '".$_GET['edu']."'";
			$result =$db->RunQuery($sql);
			if($row = mysql_fetch_array($result)){
				$ResponseXML .= "exist";
				
				
				
			}	else {*/
			
		//	$ResponseXML .= "";
			//$ResponseXML .= "<ArmyDetails>";
			
		/*	$sql1="Select * from mas_educational_qualifications where str_Educational_Qualification= '".$_GET['edu']."'";
			$result1 =$db->RunQuery($sql1);
			$row1 = mysql_fetch_array($result1);
			$ResponseXML .=  $row1["int_Educational_Qulifications"];*/
			
			$sqlt="Select * from customer_mast where id ='".$_GET['customerid']."'";
			
			$resultt =$db->RunQuery($sqlt);
			if ($rowt = mysql_fetch_array($resultt)){
				echo $rowt["str_address"];
			}
			
			
				
			
	}
	
			
		if($_GET["Command"]=="new_inv")
		{
			
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			$_SESSION["print"]=0;
			
			$sql="Select ORD_NO from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["ORD_NO"];
			$lenth=strlen($tmpinvno);
			$invno=trim("ORD/1/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["invno"]=$invno;
			
			$sql1="delete from tmp_ord_data where str_invno='".$invno."'";
			$result1 =$db->RunQuery($sql1);
			
			echo $invno;	
			
		}
	if($_GET["Command"]=="setord")
	{
		
		include_once("connection.php");
		
		$len=strlen($_GET["salesord1"]);
		$need=substr($_GET["salesord1"],$len-7, $len);
		$salesord1=trim("ORD/ ").$_GET["salesrep"].trim(" / ").$need;
		
		
		$_SESSION["custno"]=$_GET['custno'];
		$_SESSION["brand"]=$_GET["brand"];
		$_SESSION["department"]=$_GET["department"];
	
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
			
				$cuscode=$_GET["custno"];	
				
					
					$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
				
					
				$cuscode=$_GET["custno"];	
				$sql = mysql_query("Select * from vendor where CODE='".$cuscode."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					
					$OldRefno = "";
					$NewRefNo = "";
					$sql1 = mysql_query("SELECT  * From REF_HISTORY WHERE NewRefNo = '".$_GET["salesrep"]."'") or die(mysql_error());
					if($row1 = mysql_fetch_array($sql1)){
						$OldRefno = trim($row1["OldRefno"]);
    					$NewRefNo = trim($row1["NewRefNo"]);	
					}
					
					$OutpDAMT = 0;
					$OutREtAmt = 0;
					$OutInvAmt = 0;
					

		
					$sql1 = mysql_query("select * from brand_mas where barnd_name='".trim($_GET["brand"])."'") or die(mysql_error());
					
					if($row1 = mysql_fetch_array($sql1)){
						if (is_null($row1["class"])==false){ $InvClass = trim($row1["class"]); }
					}
					
		//////// Total Invoice Amount ///////////////////////////////////////////////////////////////	/						
				if ($NewRefNo==$_GET["salesrep"]){
				//	echo "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where Accname != 'NON STOCK' and GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and (SAL_EX='".$OldRefno."' or SAL_EX='".trim($_GET["salesrep"])."' and class='".$InvClass."'";
					$sqlview = mysql_query("select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and (SAL_EX='".$OldRefno."' or SAL_EX='".trim($_GET["salesrep"])."' and class='".$InvClass."'") or die(mysql_error());
				} else {
				//	echo "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where Accname != 'NON STOCK' and GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($_GET["salesrep"])."' and class='".$InvClass."'";
					$sqlview = mysql_query("select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($_GET["salesrep"])."' and class='".$InvClass."'") or die(mysql_error());
				}
				
					$rowview = mysql_fetch_array($sqlview);
						if (is_null($rowview["totout"])==false) { $OutInvAmt = $rowview["totout"]; }


////////// PD Cheques ////////////////////////////////////////////////////////////////////////////
				if ($NewRefNo==$_GET["salesrep"]){
				
					$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and (sal_ex='".$OldRefno."' or sal_ex='".trim($_GET["salesrep"])."'") or die(mysql_error());
				} else {	
					
					$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($_GET["salesrep"])."'") or die(mysql_error());
				}
				while($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
				
					$sqlstr = mysql_query("select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"])."'") or die(mysql_error());
						
						while($rowstr = mysql_fetch_array($sqlstr)){
							//echo "select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='".trim($rowstr["ST_INVONO"])."' ";
						  	$sqltmp = mysql_query("select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='".trim($rowstr["ST_INVONO"])."' ") or die(mysql_error());
                    		if($rowstmp = mysql_fetch_array($sqltmp)){
								//echo $rowstmp["class"];
                    			if (trim($rowstmp["class"] == $InvClass)) {
                   			 		$OutpDAMT = $OutpDAMT + $rowstr["ST_PAID"];
								}
               			     }
                		}
     				}	
	 
////////////  Return Settlement PD Cheques////////////////////////////////////////////////////////	 
	 	 $pend_ret_set = 0;
		 $sqlview = mysql_query("SELECT sum(che_amount) as  che_amount FROM S_INVCHeQ WHERE CHE_DATE >'".date("Y-m-d")."' AND CUS_CODE='".trim($cuscode)."' and trn_type='RET'") or die(mysql_error());
          $rowsview = mysql_fetch_array($sqlview);
			if( is_null($rowsview["che_amount"])==false){ $pend_ret_set = $rowsview["che_amount"]; }
							

//////////// Reurn Cheques////////////////////////////////////// //   /////////////////////////////////
	 	if ($NewRefNo==$_GET["salesrep"]){
		
     		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and (S_REF='".$_GET["salesrep"]."' or S_REF='" & $OldRefno & "') ") or die(mysql_error());
		
		} else {
	 
	 		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".$_GET["salesrep"]."' ") or die(mysql_error());
			
		}	
		$rowscheq = mysql_fetch_array($sqlcheq);
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
						 
        
        $sqlbrtrn = mysql_query("select * from br_trn where Rep='".trim($_GET["salesrep"])."' and brand='".$InvClass."' and cus_code='".trim($cuscode)."' ") or die(mysql_error());
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
		


				
				
		 			$sql = mysql_query("select dis from brand_mas where barnd_name = '".trim($_GET["brand"])."'") or die(mysql_error());
					if ($row = mysql_fetch_array($sql)){	
						$ResponseXML .= "<dis><![CDATA[".$row["dis"]."]]></dis>";
					}
			
				}
			
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
	
	}
	
	
	if($_GET["Command"]=="cancel_inv")
{
	$sql="select last_update from invpara  ";
	$result =$db->RunQuery($sql);
	$row = mysql_fetch_array($result);	
	
	$sqlinv="select * from s_cusordmas where REF_NO='".$_GET['salesord1']."'";
	$resultinv =$db->RunQuery($sqlinv);
	if ($rowinv = mysql_fetch_array($resultinv))
	{
		if (($rowinv["TOTPAY"]==0) and ($rowinv["SDATE"]>$row["last_update"])){
			$sql2="update s_cusordmas set CANCELL='1' where REF_NO='".$_GET['salesord1']."'";
			$result2 =$db->RunQuery($sql2);
			
			$sqltmp="select * from tmp_ord_data where str_invno='".$_GET['salesord1']."' ";
			$resulttmp =$db->RunQuery($sqltmp);
			while ($rowtmp = mysql_fetch_array($resulttmp)){
				$sqlorddata="update s_cusordtrn set CANCELL='1' where REF_NO='".$_GET['salesord1']."'";
				$resultorddata =$db->RunQuery($sqlorddata);
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
			
			
			$sql="delete from tmp_ord_data where str_code='".$_GET['itemcode']."' and str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			$rate=str_replace(",", "", $_GET["rate"]);
			$qty=str_replace(",", "", $_GET["qty"]);
			$discount=str_replace(",", "", $_GET["discount"]);
			$subtotal=str_replace(",", "", $_GET["subtotal"]);
			
			$sql="Insert into tmp_ord_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.", '".$_GET["brand"]."') ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);	
			
			
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
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td >".$row['str_code']."</a></td>
							 <td >".$row['str_description']."</a></td>
							 <td >".number_format($row['cur_rate'], 2, ".", ",")."</a></td>
							 <td >".number_format($row['cur_qty'], 2, ".", ",")."</a></td>
							 <td >".number_format($_GET["discountper"], 2, ".", ",")."</a></td>
							 <td >".number_format($row['cur_subtot'], 2, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
						
						include_once("connection.php");
							 
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td >".$qty."</a></td>
						
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where str_invno='".$_GET['invno']."'";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);	
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
	


	
if($_GET["Command"]=="delete_inv")
{
	$sql="select * from S_CUSORDMAS where REF_NO= '".trim($_GET["salesord1"])."' ";
	$result =$db->RunQuery($sql);					
	if($row = mysql_fetch_array($result)){	
		$sql1="UPDATE S_CUSORDMAS SET S_CUSORDMAS.CANCELL = '1' WHERE (((S_CUSORDMAS.REF_NO)='".trim($_GET["salesord1"])."'))";
		
		$result1 =$db->RunQuery($sql1);	
		
		$sql1="UPDATE S_CUSORDTRN SET S_CUSORDTRN.CANCELL = '1' WHERE (((S_CUSORDTRN.REF_NO)='".trim($_GET["salesord1"])."'))";
		$result1 =$db->RunQuery($sql1);		
		
	}
	echo "Canceled";	
  
}
	
		
	if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_ord_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
			//echo $sql;
			$result =$db->RunQuery($sql);
			
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
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_rate']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_qty']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_discount']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_subtot']."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
							 	include_once("connection.php");
							 
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td bgcolor=\"#222222\" >".$qty."</a></td>
                            </tr>";
				}			
				
				 $ResponseXML .= "   </table>]]></sales_table>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where str_invno='".$_GET['invno']."'";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);	
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
			
		
			$_SESSION["CURRENT_DOC"] = 1;      //document ID
			$_SESSION["VIEW_DOC"] = false ;     //view current document
			$_SESSION["FEED_DOC"] = true;       //save  current document
			$_GET["MOD_DOC"] = false  ;         //delete   current document
			$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
			$_GET["PRICE_EDIT"] = false ;       //edit selling price
			$_GET["CHECK_USER"] = false ;       //check user permission again

			
			$_SESSION["salesord1"]=$_GET['salesord1'];
			$invno=$_GET['salesord1'];
			
			$sql="delete from s_cusordmas where REF_NO='".$invno."' ";
			$result =$db->RunQuery($sql);
			
			
			// Insert s_salma ============================================================ 
			
			$sql="Select * from vendor where CODE='".$_GET['customercode']."'";
			$result =$db->RunQuery($sql);	
			$row = mysql_fetch_array($result);
			$cusname=$row["NAME"];	
			
			$totdiscount=str_replace(",", "", $_GET["totdiscount"]);
			$subtot=str_replace(",", "", $_GET["subtot"]);
			$invtot=str_replace(",", "", $_GET["invtot"]);
			$tax=str_replace(",", "", $_GET["tax"]);
			
			if ($_GET["discount1"]==''){
				$discount1=0;
			} else{
				$discount1=$_GET["discount1"];
			}
			if ($_GET["discount2"]==''){
				$discount2=0;
			} else{
				$discount2=$_GET["discount2"];
			}
			if ($_GET["discount3"]==''){
				$discount3=0;
			} else{
				$discount3=$_GET["discount3"];
			}
						
			$sql="Insert into s_cusordmas(REF_NO, TRN_TYPE, SDATE, C_CODE, BRAND, CUS_NAME, VAT, TYPE, DISCOU, AMOUNT, GRAND_TOT, DIS, DIS1, DIS2,  DEPARTMENT, SAL_EX, VAT_VAL, CANCELL, DEV, REQ_DATE, INVNO) values('".$invno."', 'INV', '".$_GET["invdate"]."', '".$_GET["customercode"]."', '".$_GET["brand"]."', '".$cusname."', 	'".$_GET["vatmethod"]."', '".$_GET["paymethod"]."', ".$totdiscount.", ".$subtot.", ".$invtot.", ".$discount1.", ".$discount2.", ".$discount3.",  '".$_GET['department']."', '".$_GET["salesrep"]."', ".$tax.", '0', '0', '".$_GET["deldate"]."', '0')";
			//echo $sql;
			$result =$db->RunQuery($sql);
			
			
			
			
			// Update credit limit ==========================================================
			
	/*		$sqlbrmas="select class from brand_mas where barnd_name='".$_GET["brand"]."'";
			$resultbrmas =$db->RunQuery($sqlbrmas);	
			$rowbrmas = mysql_fetch_array($resultbrmas);	
			
			$sql="update vendor set CUR_BAL=CUR_BAL+".$_GET["invtot"]." where CODE='".$_GET["customercode"]."'";
			$result =$db->RunQuery($sql);	
				
			$sql="update BR_TRN set credit=credit+".$_GET["invtot"]." where cus_code='".$_GET["customercode"]."' and rep='".$_GET["salesrep"]."'";
			$result =$db->RunQuery($sql);	*/
			 
				
			// Update Invoice Data  ==========================================================
			
			$sql="delete from s_cusordtrn where REF_NO='".$invno."'" ;
			$result =$db->RunQuery($sql);
			
			$sqltmp="select * from tmp_ord_data where str_invno='".$invno."'";
			//echo $sqltmp;
			$resulttmp =$db->RunQuery($sqltmp);	
			while($rowtmp = mysql_fetch_array($resulttmp)){	
				$sqlcost="select * from s_mas where STK_NO='".$rowtmp["str_code"]."' and BRAND_NAME='".$_GET["brand"]."'";
				//echo $sqlcost;
				$resultcost =$db->RunQuery($sqlcost);	
				$rowcost = mysql_fetch_array($resultcost);	
				
				//$dis_per = Val(Format(MSFlexGrid1.TextMatrix(i, 2), General)) * Val(Format(MSFlexGrid1.TextMatrix(i, 3), General)) * Val(Format(MSFlexGrid1.TextMatrix(i, 4), General)) * 0.01;
			
			
			// Update s_inv, s_trn ==========================================================
				
				$sql="insert into s_cusordtrn (REF_NO, SDATE, STK_NO, DESCRIPT, UNIT, COST, PRICE, QTY, DEPARTMENT, DIS_PER, DIS_RS, REP, TAX_PER, BRAND, CANCELL, subtot) values ('".$invno."', '".$_GET["invdate"]."', '".$rowtmp["str_code"]."', '".$rowtmp["str_description"]."', 'ORD', ".$rowcost["COST"].", ".$rowtmp["cur_rate"].", ".$rowtmp["cur_qty"].", '".$_GET["department"]."', '".$rowtmp["dis_per"]."', '".$rowtmp["cur_discount"]."', '".$_GET["salesrep"]."', '12', '".$rowcost["BRAND_NAME"]."', '0', ".$rowtmp["cur_subtot"].")" ;
				//echo $sql;
				$result =$db->RunQuery($sql);	
				//echo $sql;
			//	$sql="Insert into s_trn	(STK_NO, SDATE, REFNO, QTY, DEPARTMENT) values 
			//	 ('".$rowtmp["str_code"]."',  '".$_GET["invdate"]."', '".$invno."', ".$rowtmp["cur_qty"].", '".$_GET["department"]."')";
			//	$result =$db->RunQuery($sql);
				//echo $sql;
				
		
       		//====update stock==========================================================
			
			/*	$sql="update s_mas set QTYINHAND= QTYINHAND-".$rowtmp["cur_qty"]." where STK_NO='".$rowtmp["str_code"]."'";
				$result =$db->RunQuery($sql);
				
				//$M_STOCODE = Trim(substr($_GET["department"], 1, 5))
				
        		$sql="update s_submas set QTYINHAND=QTYINHAND- ".$rowtmp["cur_qty"]." where stk_no= '".$rowtmp["str_code"]."'  and sto_code= '". $_GET["department"]."' ";
				$result =$db->RunQuery($sql);*/
				
				$sql="delete  from tmp_ord_data where str_invno='".$invno."' and str_code='".$rowtmp["str_code"]."'";
				$result =$db->RunQuery($sql);
				
			}
        
      
  
   			//====creditor file ================================================
			
   
			$sql="Insert into s_led(REF_NO, SDATE, C_CODE, amount, flag, department) values ('".$invno."', '".$_GET["invdate"]."', '".$_GET["customercode"]."', ".$_GET["invtot"].", 'INV', '".$_GET["department"]."')";
			$result =$db->RunQuery($sql);
				
			$sql="update invpara set ORD_NO=ORD_NO+1";
			$result =$db->RunQuery($sql);	
  
			$_SESSION["print"]=1;
			
			echo "Saved";
			
			
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
	$result =$db->RunQuery($sql);
    if ($row = mysql_fetch_array($result)) {
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
$result =$db->RunQuery($sql);

$sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
$result =$db->RunQuery($sql);
if ($row = mysql_fetch_array($result)) {
   $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
   $resultbrtrn =$db->RunQuery($sqlbrtrn);
   
} else {
  
  	$sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
 	$resultbrtrn =$db->RunQuery($sqlbrtrn);
	
//	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
}

	If ($_GET["Check1"] == 1) {
   		$sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =$db->RunQuery($sqlblack);
	} else {	
    	$sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
		$resultblack =$db->RunQuery($sqlblack);
	}

echo "Tempory limit updated";*/

}
	
?>