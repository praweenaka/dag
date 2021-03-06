<?php 
session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
	 date_default_timezone_set('Asia/Colombo'); 
	
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
			
			$sql="select ordNo from s_salrep where REPCODE='".trim($_GET["salesrep"])."'";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["ordNo"];
			$lenth=strlen($tmpinvno);
			$invno=trim("WO/").$_GET["salesrep"]."/"."00".substr($tmpinvno, $lenth-4);
			$_SESSION["invno"]=$invno;
			
			
			$sql2="select tmp_no from s_salrep where REPCODE='".trim($_GET["salesrep"])."'";
			$result2 =$db->RunQuery($sql2);
			$row2 = mysql_fetch_array($result2);
			$tmpinvno="000000".$row2["tmp_no"];
			$lenth=strlen($tmpinvno);
			$_SESSION["tmp_no_word"]=trim("WO/").$_GET["salesrep"]."/"."00".substr($tmpinvno, $lenth-4);
			
			
			$sql2="update s_salrep set tmp_no=tmp_no+1 where REPCODE='".trim($_GET["salesrep"])."'";
			$result2 =$db->RunQuery($sql2);
			
			//echo $sql2;
			//echo $_SESSION["tmp_no_word"];
			
			$sql1="delete from tmp_cusord_data where str_invno='".$invno."'";
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
			
			$sqltmp="select * from tmp_cusord_data where str_invno='".$_GET['salesord1']."' ";
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
			
			
			$sql="delete from tmp_cusord_data where str_code='".$_GET['itemcode']."' and tmp_no='".$_SESSION["tmp_no_word"]."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			$rate=str_replace(",", "", $_GET["rate"]);
			$qty=str_replace(",", "", $_GET["qty"]);
			$discount=str_replace(",", "", $_GET["discount"]);
			$subtotal=str_replace(",", "", $_GET["subtotal"]);
			
			$sql="Insert into tmp_cusord_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, tmp_no)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.", '".$_GET["brand"]."', '".$_SESSION["tmp_no_word"]."') ";
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
							
			
			$sql="Select * from tmp_cusord_data where tmp_no='".$_SESSION["tmp_no_word"]."'";
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
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_cusord_data where str_invno='".$_GET['invno']."'";
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
			
	
			$sql="delete from tmp_cusord_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
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
							
			
			$sql="Select * from tmp_cusord_data where str_invno='".$_GET['invno']."'";
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
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_cusord_data where str_invno='".$_GET['invno']."'";
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
						
			$sql="Insert into s_cusordmas(REF_NO, TRN_TYPE, SDATE, C_CODE, BRAND, CUS_NAME, VAT, TYPE, DISCOU, AMOUNT, GRAND_TOT, DIS, DIS1, DIS2,  DEPARTMENT, SAL_EX, VAT_VAL, CANCELL, DEV, REQ_DATE, INVNO, tmp_no) values('".$invno."', 'INV', '".$_GET["invdate"]."', '".$_GET["customercode"]."', '".$_GET["brand"]."', '".$cusname."', 	'".$_GET["vatmethod"]."', '".$_GET["paymethod"]."', ".$totdiscount.", ".$subtot.", ".$invtot.", ".$discount1.", ".$discount2.", ".$discount3.",  '".$_GET['department']."', '".$_GET["salesrep"]."', ".$tax.", '0', '0', '".$_GET["deldate"]."', '0', '".$_SESSION["tmp_no_word"]."')";
			//echo $sql;
			$result =$db->RunQuery($sql);
			
			
			
    		$totpay = $_GET["txt_chetot"] + $_GET["txt_cash"];
			$sql="Insert into s_wcusordmas (REF_NO, TRN_TYPE,  SDATE, C_CODE, Brand, CUS_NAME, VAT, TYPE, DISCOU, AMOUNT, GRAND_TOT, ORD_NO, ORD_DA, DEPARTMENT, SAL_EX, BTT, CASH, DEV, TOTPAY, DIS, DIS1, REQ_DATE, tmp_no) values ('" .$_GET["salesord1"] . "', 'INV', '".$_GET["dtdate"]."', '".$_GET["customercode"] ."', '".trim($_GET["brand"])."', '" . trim($_GET["customername"])."', '".$_GET["vatmethod"]."', '".$_GET["paymethod"]."', ".$_GET["totdiscount"].", ".$_GET["subtot"].", ".$_GET["invtot"].", '".trim($_GET["txt_ordno"])."', '".$_GET["dtdate"]."', ".trim($_GET["department"]).", '".trim($_GET["salesrep"])."', ".$_GET["txt_tax"].", ".$_GET["txt_cash"].", '".$_SESSION['dev']."', ".$totpay.", ".$_GET["txtdis1"].", ".$_GET["txtdis2"].", '".$_GET["DTREQ_DATE"]."', '".$_SESSION["tmp_no_word"]."')";
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
			
			$sqltmp="select * from tmp_cusord_data where str_invno='".$invno."'";
			//echo $sqltmp;
			$resulttmp =$db->RunQuery($sqltmp);	
			while($rowtmp = mysql_fetch_array($resulttmp)){	
				
				$mqty = 0;
				$sqlcost="select * from s_submas where STK_NO='".$rowtmp["str_code"]."' and STO_CODE='".$_GET["department"]."'";
				//echo $sqlcost;
				$resultcost =$db->RunQuery($sqlcost);	
				if ($rowcost = mysql_fetch_array($resultcost)){
					$mqty = $rowcost["QTYINHAND"];
				}
				
				
				 $dis_per = $rowtmp["cur_rate"] * $rowtmp["cur_qty"] * $rowtmp["dis_per"] * 0.01;
			
			
			// Update s_inv, s_trn ==========================================================
				
				$sql="insert into s_cusordtrn (REF_NO, SDATE, STK_NO, DESCRIPT, UNIT, COST, PRICE, QTY, DEPARTMENT, DIS_PER, DIS_RS, REP, TAX_PER, BRAND, CANCELL, subtot, c_code, stk) values ('".$invno."', '".$_GET["dtdate"]."', '".$rowtmp["str_code"]."', '".$rowtmp["str_description"]."', 'WEO', ".$rowtmp["cur_rate"].", ".$rowtmp["cur_rate"].", ".$rowtmp["cur_qty"].", '".$_GET["department"]."', '".$rowtmp["dis_per"]."', '".$dis_per."', '".$_GET["salesrep"]."', '15', '".$rowcost["BRAND_NAME"]."', '0', ".$rowtmp["cur_subtot"].", '".$_GET["customercode"]."', ".mqty.")" ;
				//echo $sql;
				$result =$db->RunQuery($sql);	
			
				
				 //====update stock==========================================================
        
       			$m_STK_NO = $rowtmp["str_code"];
       			$M_STOCODE = $_GET["department"];
	   
				$sql="delete  from tmp_cusord_data where str_invno='".$invno."' and str_code='".$rowtmp["str_code"]."'";
				$result =$db->RunQuery($sql);
				
			}
        
      
	  	$flag="";
	  
    	if ($_GET["paymethod"]=="CR"){
       		$flag = "INV"; //cash Invoice
    	} else {
       		$flag = "INV"; //Credit Invoice
    	}
		
		$sql="update s_salrep set ordNo=ordNo+1 where REPCODE='" . $_GET["salesrep"] . "'";
		$result =$db->RunQuery($sql);
  	
       

  
   			
			
			echo "Saved";
			
			
	}

if ($_GET["Command"]=="achivement")
{
	$mrep = $_GET["salesrep"];
	$mvatrate="15";
	
	$sql="delete * from tmpord";
	$result =$db->RunQuery($sql);
		
	
	$sql_rs="select * from  view_wcusordtrn_submas where CANCELL='0' and UNIT='WEO' and  SAL_EX='".$mrep."' and SDATE='".$_GET["dtdate"]."'";
	$result_rs =$db->RunQuery($sql_rs);
	while ($row_rs = mysql_fetch_array($result_rs)){
		
		if ($row_rs["DIS_per"]>0){
			$cost=(($row_rs["PRICE"] - ($row_rs["PRICE"] * ($row_rs["DIS_per"] / 100))) * $row_rs["QTY"]) / (1 + ($mvatrate / 100));
		} else {
			$cost=($row_rs["PRICE"] * $row_rs["QTY"]) /  (1 + ($mvatrate / 100));
		}
		$sql="insert into tmpord (stkno, des, Cuscode, CUSNAME, ordqty, cost, QTYINHAND, stk) values ('".$row_rs["STK_NO"]."', '".$row_rs["DESCRIPT"]."', '".$row_rs["c_code"]."', '".$row_rs["NAME"]."', ".$row_rs["QTY"].", ".$cost.", ".$row_rs["QTYINHAND"].", '".$row_rs["stk"]."')";
		$result =$db->RunQuery($sql);
	}
	
	$mdateto = $_GET["DTdateto"];
	
	$sql_rs= "Select * from VIEW_Salma_sinvo where SAL_EX='".$mrep."' and SDATE>='".$_GET["dtdate"]."' and SDATE <='".$_GET["mdateto"]."' and CANCELL = '0' ";
	$result_rs =$db->RunQuery($sql_rs);
	while ($row_rs = mysql_fetch_array($result_rs)){
		$archval = (($row_rs["PRICE"] - ($row_rs["DIS_per"] / $row_rs["QTY"])) * $row_rs["QTY"]) / (1 + ($mvatrate / 100));
		
		$sql="insert into tmpord (stkno, des, Cuscode, CUSNAME, archqty, archval) values ('".$row_rs["STK_NO"]."', '".$row_rs["DESCRIPT"]."', '".$row_rs["C_CODE"]."', '".$row_rs["CUS_NAME"]."', ".$row_rs["QTY"].", ".$archval.")";
		$result =$db->RunQuery($sql);
	}	
	
	
	$sql_rs= "Select * from VIEW_CRNMA_CRNTRN  where  SAL_EX='".$mrep."' and SDATE>='".$_GET["dtdate"]."' and SDATE <='".$_GET["mdateto"]."' ";
	$result_rs =$db->RunQuery($sql_rs);
	while ($row_rs = mysql_fetch_array($result_rs)){
		
		$qty=$row_rs["QTY"]*-1;
		$mdis = 0;
		
		if (is_null($row_rs["DIS_P"])==false){
      		if ($row_rs["DIS_P"] > 0) { $mdis = $row_rs["DIS_P"]; }
   		}
   
   		if ($mdis > 0) {
      		$archval = ((($row_rs["PRICE"] - ($row_rs["PRICE"] * ($row_rs["DIS_P"] / 100))) * $row_rs["QTY"]) * -1) / (1 + ($mvatrate / 100));
   		} else {
      		$archval = (($row_rs["PRICE"] * $row_rs["QTY"]) * -1) / (1 + ($mvatrate / 100));
   		}
   
		$sql="insert into tmpord (stkno, des, Cuscode, CUSNAME, archqty, archval) values ('".$row_rs["STK_NO"]."', '".$row_rs["DESCRIPT"]."', '".$row_rs["C_CODE"]."', '".$row_rs["CUS_NAME"]."', ".$qty.", ".$archval.")";
		$result =$db->RunQuery($sql);
	}	
   
   
   	$sql_tmpord= "SELECT * from tmpord where stkno != 'SC01' and stkno != 'A0350' and stkno != 'A0351' and stkno != 'A0352' and stkno != 'A0353' and stkno != 'A0600' and stkno != 'L0531' order by stkno , Cuscode , ordqty desc";
	$result_tmpord =$db->RunQuery($sql_tmpord);
	while ($row_tmpord = mysql_fetch_array($result_tmpord)){
   		if ($row_tmpord["ordqty"] != 0) {
        	$totordq = $totordq + $row_tmpord["ordqty"];
        	$val_totordq = $val_totordq + $row_tmpord["cost"];
    	}
    	if ($row_tmpord["archqty"] != 0) {
        	$totarchq = $totarchq + $row_tmpord["archqty"];
        	$val_totarchq = $val_totarchq + $row_tmpord["archval"];
    	}
    	if ($row_tmpord["stkno"] == "06365"){
        	$X = 1;
    	}
		
		if ($row_tmpord["stkno"] == $sno) {
        	if ($row_tmpord["ordqty"] > 0) {
            	$ordq = $ordq + $row_tmpord["ordqty"];
            	$val_ordq = $val_ordq + $row_tmpord["cost"];
            	$cusn = $row_tmpord["Cuscode"];
        	}
        	if ($row_tmpord["Cuscode"] == $cusn) {
            	if ($row_tmpord["archqty"] > 0) {
                	$archq = $archq + $row_tmpord["archqty"];
                	$val_archq = $val_archq + $row_tmpord["archval"];
            	}
            	$differ = $ordq - $archq;
            	$val_differ = $val_ordq - $val_archq;
        	}
    	} else {
			$totdif = $totdif + $differ;
        	$val_totdif = $val_totdif + $val_differ;
        	$ordq = 0;
        	$val_ordq = 0;
        	$archq = 0;
        	$val_archq = 0;
        	$differ = 0;
        	$val_differ = 0;
        	
			if ($row_tmpord["ordqty"] != 0) {
            	$sno = $row_tmpord["stkno"];
            	$cusn = $row_tmpord["Cuscode"];
            	
				if ($row_tmpord["ordqty"] > 0) {
                	$ordq = $ordq + $row_tmpord["ordqty"];
                	$val_ordq = $val_ordq + $row_tmpord["cost"];
            	}
            	if ($row_tmpord["archqty"] > 0) {
                	$archq = $archq + $row_tmpord["archqty"];
                	$val_archq = $val_archq + $row_tmpord["archval"];
            	}
            	$differ = $ordq - $archq;
            	$val_differ = $val_ordq - $val_archq;
        	}
		}
	}
	
	$totdif = $totdif + $differ;
	$val_totdif = $val_totdif + $val_differ;

	$mrep = $_GET["salesrep"];
	
	$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		$Text1=$_GET["department"];
		$txtdes="Date From : " . $_GET["dtdate"] . " Date To:" . $_GET["DTdateto"];
	
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		
		echo "<center>".$rtxtdate."</center><br>";
		echo "<center>".$txtrectype."</center><br>";
		echo "<center>".$txtcus."</center><br>";
		
		echo "<center><table border=1><tr>
		<th>Stock No</th>
		<th>Description</th>
		<th>Customer No</th>
		<th>Customer Name</th>
		<th>Order Qty</th>
		<th>Cost</th>
		<th>Achive Qty</th>
		<th>Achive Value</th>
		</tr>";
		
	$sql = "SELECT * from tmpord WHERE stkno != 'SC01' and stkno != 'A0350' and stkno != 'A0351' and stkno != 'A0352' and stkno != 'A0353' and stkno != 'A0600' and stkno != 'L0531' ";
	$result =$db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {
		
		echo "<tr>";
	echo "<td>".$row["stkno"]."</td>";
	echo "<td>".$row["des"]."</td>";
	echo "<td>".$row["Cuscode"]."</td>";
	echo "<td>".$row["CUSNAME"]."</td>";
	echo "<td align=\"right\">".number_format($row["ordqty"], 2, ".", ",")."</td>";
	echo "<td align=\"right\">".number_format($row["cost"], 2, ".", ",")."</td>";
	echo "<td align=\"right\">".number_format($row["archqty"], 2, ".", ",")."</td>";
	echo "<td align=\"right\">".number_format($rows["archval"], 2, ".", ",")."</td>";
	
	}
	
	$Text22=($val_totordq - $val_totdif) / ($val_totordq) * 100;
	$Text30=($val_totarchq / $val_totordq) * 100;

	if ($totarchq < $totordq) {
    	$Text10=$totarchq - ($totordq - $totdif);
	} else {
    	$Text10=($totarchq - $totordq) + $totdif;
	}
	
	if ($totarchq < $totordq) {
    	$Text21=$totarchq - ($totordq - $totdif);
	} else {
    	$Text21=($totarchq - $totordq) + $totdif;
	}

	if ($totarchq < $totordq) {
    	$rtxtqty= ($totordq - $totdif);
	} else {
    	$rtxtqty=$totarchq - (($totarchq - $totordq) + $totdif);
	}

	if ($val_totarchq < $val_totordq) {
    	$rtxtval=$val_totordq - $val_totdif;
	} else {
    	$rtxtval=$val_totarchq - (($val_totarchq - $val_totordq) + $val_totdif);
	}
	
	if ($val_totarchq < $val_totordq) {
    	$Text24=$val_totarchq - ($val_totordq - $val_totdif);
	} else {
    	$Text24=($val_totarchq - $val_totordq) + $val_totdif;
	}
	
	//-------------------------------- All Month Target -----------------------------------
 
 	$sql_target = "select sum(target) as target  from rep_target where rep='".$_GET["salesrep"]."'  and TMonth=".date("m", $_GET["dtdate"])." and Tyear=".date("Y", $_GET["dtdate"])."";
	$result_target =$db->RunQuery($sql_target);
    $row_target = mysql_fetch_array($result_target);
	
	$sql_salma = "select sum(GRAND_TOT) as tot  from s_salma where Accname != 'NON STOCK' and   SAL_EX='".$_GET["salesrep"]."' and month(SDATE)='".date("m", $_GET["dtdate"])."'   and year(SDATE)='".date("Y", $_GET["dtdate"])."'  and CANCELL='0'";
	$result_salma =$db->RunQuery($sql_salmat);
    $row_salma = mysql_fetch_array($result_salma);
	
	$sql_cbal = "select sum(AMOUNT) as tot from c_bal where   SAL_EX='".$_GET["salesrep"]."' and  month(SDATE)='".date("m", $_GET["dtdate"])."'   and year(SDATE)='".date("Y", $_GET["dtdate"])."'  and trn_type!='ARN' and trn_type!='REC'and trn_type!='DGRN' and trn_type!='INC' and trn_type!='PAY' and flag1 != '1'  ";
	$result_cbal =$db->RunQuery($sql_cbal);
    $row_cbal = mysql_fetch_array($result_cbal);



	if (is_null($row_target["target"])==false) {
    	$txttot=$row_target["target"];
	} else {
    	$txttot=0;
	}
	
	if (is_null($row_cbal["tot"])==false) {
    	$txtach=($row_salma["tot"] - $row_cbal["tot"]) / 1.12;
	} else {
    	$txtach= $row_salma["tot"] / 1.12;
	}
	
	if (is_null($row_cbal["tot"])==false) {
    	$txtbal=($row_target["target"] - ($row_salma["tot"] - $row_cbal["tot"]) / 1.12);
	} else {
    	$txtbal=($row_target["target"] - ($row_salma["tot"]) / 1.12);
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