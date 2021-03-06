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
			
			$_SESSION["print"]=0;
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			$sql="Select ARR from invpara";
			
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["ARR"];
			$lenth=strlen($tmpinvno);
			$invno=trim("ARR/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["invno"]=$invno;
			
			$sql="delete from tmp_purord_data where str_invno='".$invno."'";
			$result =$db->RunQuery($sql);
			
			echo $invno;	
			
		}
	
	
	
	if($_GET["Command"]=="add_tmp")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="delete from tmp_purord_data where str_code='".$_GET['itemcode']."' and str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			
			$qty=str_replace(",", "", $_GET["qty"]);
			
			
			$sql="Insert into tmp_purord_data (str_invno, str_code, str_description, partno, qty)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', '".$_GET["partno"]."', ".$qty.") ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                             
                            </tr>";
							
			
			$sql="Select * from tmp_purord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['partno']."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['qty'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
                           
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	if($_GET["Command"]=="arn")
		{
		
			//$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="select * from s_ordmas where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			if($row = mysql_fetch_array($result)){
				$ResponseXML .= "<REFNO><![CDATA[".$row['REFNO']."]]></REFNO>";
				$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
				$ResponseXML .= "<SUP_CODE><![CDATA[".$row['SUP_CODE']."]]></SUP_CODE>";
				$ResponseXML .= "<SUP_NAME><![CDATA[".$row['SUP_NAME']."]]></SUP_NAME>";
				$ResponseXML .= "<REMARK><![CDATA[".$row['REMARK']."]]></REMARK>";
				$ResponseXML .= "<DEP_CODE><![CDATA[".$row['DEP_CODE']."]]></DEP_CODE>";
				$ResponseXML .= "<DEP_NAME><![CDATA[".$row['DEP_NAME']."]]></DEP_NAME>";
				$ResponseXML .= "<REP_CODE><![CDATA[".$row['REP_CODE']."]]></REP_CODE>";
				$ResponseXML .= "<REP_NAME><![CDATA[".$row['REP_NAME']."]]></REP_NAME>";
				$ResponseXML .= "<S_date><![CDATA[".$row['S_date']."]]></S_date>";
				$ResponseXML .= "<LC_No><![CDATA[".$row['LC_No']."]]></LC_No>";
				$ResponseXML .= "<Brand><![CDATA[".$row['Brand']."]]></Brand>";
				$ResponseXML .= "<COUNTRY><![CDATA[".$row["COUNTRY"]."]]></COUNTRY>";
			}	
			
		//	$sql="delete from tmp_purord_data where str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
		//	$result =$db->RunQuery($sql);
			
		//	$sql="select * from s_ordtrn where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
		//	$result =$db->RunQuery($sql);
		//	while($row = mysql_fetch_array($result)){
		//		$sql1="Insert into tmp_purord_data (str_invno, str_code, str_description, partno, qty)values 
		//		('".$row['REFNO']."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', '".$row["partno"]."', ".$row["ORD_QTY"].") ";
			//$ResponseXML .= $sql;
		//		$result1 =$db->RunQuery($sql1);	
		//	}
							
			
			
	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Order Qty</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">FOB</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cost</font></td>
							   <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Selling</font></td>
							    <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Margin</font></td>
								 <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							
                            </tr>";
				
			$mcou=0;	
			$sql="Select count(*) as mcou from s_ordtrn where REFNO='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			$row = mysql_fetch_array($result);
			$mcou=$row["mcou"]+1;
							
			$i=1;
			$sql="Select * from s_ordtrn where REFNO='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){	
			
				$itemcode="itemcode".$i;
				$itemname="itemname".$i;
				$ord_qty="ord_qty".$i;
				$fob="fob".$i;
				$qty="qty".$i;
				$cost="cost".$i;
				$selling="selling".$i;
				$margin="margin".$i;
				$subtotal="subtotal".$i;
							
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemcode." id=".$itemcode."   value=".$row['STK_NO']." class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemname." id=".$itemname."  value='".$row['DESCRIPT']."' class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$ord_qty." id=".$ord_qty."  value=".$row['ORD_QTY']." class=\"txtbox\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$fob." id=".$fob."  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$qty." id=".$qty."  class=\"txtbox\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$cost." id=".$cost."  class=\"txtbox\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$selling." id=".$selling."  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$margin." id=".$margin."  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$subtotal." id=".$subtotal."  class=\"txtbox\"/></td>
							</tr>";
							$i=$i+1; 
                           
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				$ResponseXML .= "<count><![CDATA[".$i."]]></count>";
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
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
		
		
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				$cuscode=$_GET["custno"];	
				$salesrep=$_GET["salesrep"];
				$brand=$_GET["brand"];
					
			//		$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
				
					
	    //Call SETLIMIT ====================================================================
		
		
		
	/*	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
					$sql = mysql_query("CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error());*/

	$OutpDAMT = 0;
	$OutREtAmt = 0;
	$OutInvAmt = 0;
	$InvClass="";
	
	$sqlclass = mysql_query("select class from brand_mas where barnd_name='".trim($brand)."'") or die(mysql_error());
	if ($rowclass = mysql_fetch_array($sqlclass)){
		if (is_null($rowclass["class"])==false){
			$InvClass=$rowclass["class"];
		}
	}
	
	$sqloutinv = mysql_query("select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($salesrep)."' and class='".$InvClass."'") or die(mysql_error());
	if ($rowoutinv = mysql_fetch_array($sqloutinv)){
		if (is_null($rowoutinv["totout"])==false){
			$OutInvAmt=$rowoutinv["totout"];
		}
	}

$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salesrep)."'") or die(mysql_error());
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
		
		$sqlinvcheq = mysql_query("SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='RET'") or die(mysql_error());
		if($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
			if (is_null($rowinvcheq["che_amount"])==false){
				$pend_ret_set=$rowinvcheq["che_amount"];
			}
		}
		
		
		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".trim($salesrep)."'") or die(mysql_error());
		if($rowcheq = mysql_fetch_array($sqlcheq)){
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
        

      $sqlbr_trn = mysql_query("select * from br_trn where Rep='".trim($salesrep)."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'") or die(mysql_error());  
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
			
	
			$sql="delete from tmp_purord_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
			
			$result =$db->RunQuery($sql);
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_purord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['partno']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['qty']."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
						
				}			
				
				$ResponseXML .= "   </table>]]></sales_table>";
							
                $ResponseXML .= " </salesdetails>";
				
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	
if($_GET["Command"]=="save_item")
{

	$vatrate=0.12;
	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
			$_SESSION["CURRENT_DOC"] = 1;      //document ID
			$_SESSION["VIEW_DOC"] = false ;     //view current document
			$_SESSION["FEED_DOC"] = true;       //save  current document
			$_GET["MOD_DOC"] = false  ;         //delete   current document
			$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
			$_GET["PRICE_EDIT"] = false ;       //edit selling price
			$_GET["CHECK_USER"] = false ;       //check user permission again

		
		
			
	$sql="insert into s_purrmas(REFNO, SDATE, SUP_CODE, SUP_NAME, REMARK, AMOUNT, ORDNO, DEPARTMENT) values ('".$_GET["pur_ret_no"]."', '".$_GET["grndate"]."', '".$_GET["sup_code"]."', '".$_GET["sup_name"]."', '".$_GET["reason"]."', '".$_GET["invtot"]."', '".$_GET["arnno"]."', '".$_GET["department"]."')";
	$result =$db->RunQuery($sql);
				
	$i=1;
	while ($_GET["mcou"]>$i){
			
		$itemcode="itemcode".$i;
		$itemname="itemname".$i;
		$munit="unit".$i;
		$qty="qty".$i;
		$preretqty="preretqty".$i;
		$price="price".$i;
		$retqty="retqty".$i;
		$value="value".$i;
				
		if (($_GET[$itemcode]!="") and ($_GET[$itemname]!="") and ($_GET[$qty]>0)){
					
			$sql="insert into s_purrtrn(REFNO, STK_NO, DESCRIPT, acc_COST, REC_QTY, sDATE) values ('".$_GET["pur_ret_no"]."', '".$_GET[$itemcode]."', '".$_GET[$itemname]."', '".$_GET[$price]."', '".$_GET[$retqty]."', '".$_GET["grndate"]."')";
			$result =$db->RunQuery($sql);
					
					//Avearge Cost
			$avgcost=0;
			$balqty=$_GET[$qty]-$_GET[$preretqty]-$_GET[$retqty];
					
			$sql="select acc_cost_c, QTYINHAND from s_purtrn where REFNO='".$_GET["arnno"]."' and STK_NO='".$_GET[$itemcode]."'";
			$result =$db->RunQuery($sql);
			if($row = mysql_fetch_array($result)){	
				if ($row["acc_cost_c"]==0){
					$avgcost=$_GET[$price];
				} else if (($balqty>0) and (($row["QTYINHAND"]+$balqty)>0)){
					$avgcost = ($row["QTYINHAND"] * $row["acc_cost_c"] + $balqty * $_GET[$price]) / ($row["QTYINHAND"] + $balqty);
				} else {
					$avgcost = $row["acc_cost_c"];
				}		
					
			} else {	
					$avgcost = $_GET[$price];
			}
					
		}	
				
		$sql= "UPDATE s_mas SET acc_cost =".$avgcost.", QTYINHAND = QTYINHAND - ".$_GET[$retqty]."  WHERE STK_NO='".$_GET[$itemcode]."'";
		$result =$db->RunQuery($sql);
				 
				 
		$sql= "UPDATE s_submas SET QTYINHAND = QTYINHAND - ".$_GET[$retqty]."  WHERE STK_NO='".$_GET[$itemcode]."' and STO_CODE='".$_GET["department"]."'";
		$result =$db->RunQuery($sql);
				  
		$sql= "UPDATE s_purtrn SET ret_qty = ret_qty + ".$_GET[$retqty]."  WHERE STK_NO='".$_GET[$itemcode]."' and REFNO='".$_GET["pur_ret_no"]."'";
		$result =$db->RunQuery($sql);
				
		$sql= "UPDATE s_purtrn SET ret_qty = ret_qty + ".$_GET[$retqty]."  WHERE STK_NO='".$_GET[$itemcode]."' and REFNO='".$_GET["pur_ret_no"]."'";
		$result =$db->RunQuery($sql);

  
   
   		$sql= "iNSERT INTO s_trn (STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT) VALUES('".$_GET[$itemcode]."', '".$_GET["grndate"]."', ".$_GET[$retqty].", 'ARR', '".$_GET["pur_ret_no"]."', '".$_GET["department"]."')";
		$result =$db->RunQuery($sql);
				
		
				
			$i=$i+1;
		}
		
		
		//=================update cus ledger=========
    
		$sql= "iNSERT INTO s_led (REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT) VALUES('".$_GET["pur_ret_no"]."', '".$_GET["grndate"]."', '".$_GET["sup_code"]."', '".$_GET["invtot"]."', 'ARR', '".$_GET["department"]."')";
		$result =$db->RunQuery($sql);
				
		$sql= "update invpara set ARR=ARR+1";
		$result =$db->RunQuery($sql);
		
		
			
			echo "Saved";
			
			
	}
	

	if($_GET["Command"]=="pass_arnno")
	{
		$ResponseXML .= "";
		$ResponseXML .= "<salesdetails>";
		$sql="Select * from s_purmas where REFNO='".$_GET['arnno']."'";
		$result =$db->RunQuery($sql);	
		if ($row = mysql_fetch_array($result)){
			$ResponseXML .= "<REFNO><![CDATA[".$row["REFNO"]."]]></REFNO>";
			$ResponseXML .= "<SDATE><![CDATA[".$row["SDATE"]."]]></SDATE>";
			$ResponseXML .= "<ORDNO><![CDATA[".$row["ORDNO"]."]]></ORDNO>";
			$ResponseXML .= "<LCNO><![CDATA[".$row["LCNO"]."]]></LCNO>";
			$ResponseXML .= "<COUNTRY><![CDATA[".$row["COUNTRY"]."]]></COUNTRY>";
			$ResponseXML .= "<SUP_CODE><![CDATA[".$row["SUP_CODE"]."]]></SUP_CODE>";
			$ResponseXML .= "<SUP_NAME><![CDATA[".$row["SUP_NAME"]."]]></SUP_NAME>";
			$ResponseXML .= "<REMARK><![CDATA[".$row["REMARK"]."]]></REMARK>";
			$ResponseXML .= "<DEPARTMENT><![CDATA[".$row["DEPARTMENT"]."]]></DEPARTMENT>";
			$ResponseXML .= "<AMOUNT><![CDATA[".$row["AMOUNT"]."]]></AMOUNT>";
			$ResponseXML .= "<PUR_DATE><![CDATA[".$row["PUR_DATE"]."]]></PUR_DATE>";
			$ResponseXML .= "<brand><![CDATA[".$row["brand"]."]]></brand>";
			$ResponseXML .= "<TYPE><![CDATA[".$row["TYPE"]."]]></TYPE>";
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Unit</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Pre. Ret. Qty</font></td>
							  <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Price</font></td>
							   <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ret Qty</font></td>
							    <td width=\"200\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Value</font></td>
							
                            </tr>";
				
			$mcou=0;	
			$sql="Select count(*) as mcou from s_purtrn where REFNO='".$_GET['arnno']."'";
			$result =$db->RunQuery($sql);	
			$row = mysql_fetch_array($result);
			$mcou=$row["mcou"]+1;
							
			$i=1;
			$tot=0;
			$sql="Select * from s_purtrn where REFNO='".$_GET['arnno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){	
			
				$itemcode="itemcode".$i;
				$itemname="itemname".$i;
				$unit="unit".$i;
				$qty="qty".$i;
				$preretqty="preretqty".$i;
				$price="price".$i;
				$retqty="retqty".$i;
				$value="value".$i;
			
					
				if (($row['ret_qty']=="") or ($row['ret_qty']==0) or is_null($row['ret_qty'])){
					$val_ret_qty=0;
				}	else {
					$val_ret_qty=$row['ret_qty'];
				}
						
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemcode." id=".$itemcode."   value='".$row['STK_NO']."' class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemname." id=".$itemname."  value='".$row['DESCRIPT']."' class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$unit." id=".$unit."  value='' class=\"txtbox\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$qty." id=".$qty." value='".$row['REC_QTY']."'  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$preretqty." id=".$preretqty." value='".$val_ret_qty."'  class=\"txtbox\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$price." id=".$price." value='".$row['SELLING']."'  class=\"txtbox\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$retqty." id=".$retqty." value=''  class=\"txtbox\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$value." id=".$value." value=''  class=\"txtbox\"/></td>
							
							</tr>";
							$tot=$tot+($row['COST']*$row['REC_QTY']);
							$i=$i+1; 
                           
				}			
							
                $ResponseXML .= "</table>]]></sales_table>";
				$ResponseXML .= "<tot><![CDATA[".$tot."]]></tot>";
				$ResponseXML .= "<count><![CDATA[".$i."]]></count>";
		}
		
		
		
		$ResponseXML .= "</salesdetails>";
		echo $ResponseXML;
	}
	
if($_GET["Command"]=="cancel_inv")
{

	$sql="select * from s_purmas where CANCEL='0' order by id desc";
	$result =$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	if ($row["REFNO"]!=$_GET["invno"]){
		echo "You Can't cancel this record without cancel last records ";
	} else {	
		$sql1="update s_purmas set CANCEL='1' where REFNO='".$_GET["invno"]."'";
		$result1 =$db->RunQuery($sql1);
	
		$sql1="update s_purtrn set CANCEL='1' where REFNO='".$_GET["invno"]."'";
		$result1 =$db->RunQuery($sql1);
		
		$sql1="update s_ordmas set cancel='0' where REFNO='".$_GET["orderno1"]."'";
		$result1 =$db->RunQuery($sql1);
	
		$sql1="update s_ordtrn set CANCEL='0' where REFNO='".$_GET["invno"]."'";
		$result1 =$db->RunQuery($sql1);
		
		$sql1="delete from s_trn  where REFNO='".$_GET["invno"]."'";
		$result1 =$db->RunQuery($sql1);
		
		$sql1="delete from c_bal where REFNO='".$_GET["invno"]."'";
		$result1 =$db->RunQuery($sql1);
		
		$sql1="select * from s_purtrn where REFNO='".$_GET["invno"]."'";
		$result1 =$db->RunQuery($sql1);
		while($row1 = mysql_fetch_array($result1)){
		
			$sql2="update s_mas set COST=".$row1["Cost_c"].", acc_cost=".$row1["acc_cost_c"]." where STK_NO='".$row1["STK_NO"]."'";
			$result2 =$db->RunQuery($sql2);
			
			$sql2="update s_submas set QTYINHAND=QTYINHAND-".$row1["ret_qty"]." where STK_NO='".$row1["STK_NO"]."' and STO_CODE='".$_GET["department"]."'";
			$result2 =$db->RunQuery($sql2);
			
			$sql2="update s_mas set QTYINHAND=QTYINHAND-".$row1["ret_qty"]." where STK_NO='".$row1["STK_NO"]."'";
			$result2 =$db->RunQuery($sql2);
		}
		
		echo "Canceled!";
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