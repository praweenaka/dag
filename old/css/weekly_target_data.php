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
			
			
			
			
			$sql="select DEL from s_salrep  where REPCODE = '".$_GET["Com_rep"]."'";
			$result =$db->RunQuery($sql);
			if ($row = mysql_fetch_array($result)){
			
				$invno = $_GET["Com_rep"]."/".trim($row["DEL"] + 1);
			} else {
				$invno = $_GET["Com_rep"]."/1";
			}
			
			$_SESSION["invno"]=$invno;
			
			$sql="delete from tmp_weekly_tar where ref_no='".$invno."'";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			echo $invno;
		}
	
	
	if($_GET["Command"]=="add_tmp")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			//$sql="delete from tmp_weekly_tar where ref_no='".$_GET['txtref']."'";
			//$ResponseXML .= $sql;
			//$result =$db->RunQuery($sql);
			
	
			
			$sql="Insert into tmp_weekly_tar (sal_ref, ref_no, tar_date, cus_code, cus_name, target, remark)values 
			('".$_GET['Com_rep']."', '".$_GET['txtref']."', '".$_GET['tar_date']."', '".$_GET['cus_code']."', '".$_GET['cus_name']."', ".$_GET["target"].", '".$_GET['remark']."') ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cus. Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cus. Name</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Target</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Remark</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_weekly_tar where ref_no='".$_GET['txtref']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td>".$row['tar_date']."</a></td>
							 <td >".$row['cus_code']."</a></td>
							  <td >".$row['cus_name']."</a></td>
							 <td >".number_format($row['target'], 2, ".", ",")."</a></td>
							  <td >".$row['remark']."</a></td>
							
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>
							 
							
							 
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				
				
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
			
	
			$sql="delete from tmp_grn_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
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
							
			
			$sql="Select * from tmp_grn_data where str_invno='".$_GET['invno']."'";
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
			$sql_rsweek_tragets="Select refno  from week_tragets  where refno='".trim($_GET["txtref"])."' AND  rep='".$_GET["Com_rep"]."'";
			$result_rsweek_tragets =$db->RunQuery($sql_rsweek_tragets);	
			if($row_rsweek_tragets = mysql_fetch_array($result_rsweek_tragets)){
			
			} else {		
				$sql="uPDATE s_salrep SET DEL=DEL +1 where REPCODE = '".$_GET["Com_rep"]."'";
				//echo $sql;
				$result =$db->RunQuery($sql);	
				
				$sql_rep="Select rgroup from s_salrep where REPCODE ='".$_GET["Com_rep"]."' ";
				//echo $sql_rep;
				$result_rep =$db->RunQuery($sql_rep);	
				$row_rep = mysql_fetch_array($result_rep);	
				
				$sql="delete  from week_tragets  where refno='".$_GET["txtref"]."' AND  rep='".$_GET["Com_rep"]."'";
				//echo $sql;
				$result =$db->RunQuery($sql);	
				
				$sql_tmp="Select * from tmp_weekly_tar where ref_no ='".trim($_GET["txtref"])."' ";
				//echo $sql_tmp;
				$result_tmp =$db->RunQuery($sql_tmp);	
				while ($row_tmp = mysql_fetch_array($result_tmp)){
					 $dt = $row_tmp["tar_date"];
					 
					 $sql="insert into week_tragets (refno, rep, cus_code, Target, remark, Tardate, dtfrom, DTTTO) values ('".trim($_GET["txtref"])."', '".$_GET["Com_rep"]."', '".$row_tmp["cus_code"]."', ".$row_tmp["target"].", '".$row_tmp["remark"]."', '".$dt."', '".$_GET["dtfrom"]."', '".$_GET["dtto"]."' )";
					// echo $sql;
					 $result =$db->RunQuery($sql);	
				
       
				}
		  
			}
			

			$sql="delete from tmp_weekly_tar where ref_no='".$_GET["txtref"]."'";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			echo "Saved";
			
			
	}
	

if ($_GET["Command"]=="print_inv"){
	
	$sql="delete  from tragets ";
	$result =$db->RunQuery($sql);	
	
	$sql_week_tragets="select * from VIEW_tragers_vendor where refno='".$_GET["txtref"]."'";
	$result_week_tragets =$db->RunQuery($sql_week_tragets);
	while ($row_week_tragets = mysql_fetch_array($result_week_tragets)){
		$sql="insert into tragets(C_CODE, cusNAME, TRAGET, REMARK, TARDATE) values ('".trim($row_week_tragets["Cus_Code"])."', '".trim($row_week_tragets["NAME"])."', ".trim($row_week_tragets["Target"]).", '".trim($row_week_tragets["Remark"])."', '1')";
		$result =$db->RunQuery($sql);	
	}
	
	
	$sql_SALMA="select c_code from s_salma where Accname != 'NON STOCK' and SDATE >= '".$_GET["dtfrom"]."' and SDATE <= '".$_GET["dtto"]."'  and CANCELL='0'  and SAL_EX = '".$_GET["Com_rep"]."'  group by C_CODE";
	$result_SALMA =$db->RunQuery($sql_SALMA);
	while ($row_SALMA = mysql_fetch_array($result_SALMA)){
		$sql_UTRAGETs="SELECT C_CODE from tragets  WHERE C_CODE= '".$row_SALMA["c_code"]."' ";
		$result_UTRAGETs =$db->RunQuery($sql_UTRAGETs);	
		if ($row_UTRAGETs = mysql_fetch_array($result_UTRAGETs)){
		
		} else {
			$sql_UTRAGETs="insert into tragets(C_CODE) values ('".$row_SALMA["c_code"]."')";
			$result_UTRAGETs =$db->RunQuery($sql_UTRAGETs);	
		}
	}
	
	$sql_c_bal="select CUSCODE from c_bal where SDATE >= '".$_GET["dtfrom"]."' and SDATE <= '".$_GET["dtto"]."'  and Cancell='0'  and SAL_EX = '".$_GET["Com_rep"]."' and trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY'  group by CUSCODE";
	$result_c_bal =$db->RunQuery($sql_c_bal);
	while ($row_c_bal = mysql_fetch_array($result_c_bal)){
		$sql_UTRAGETs="SELECT C_CODE from tragets  WHERE C_CODE= '".$row_c_bal["CUSCODE"]."' ";
		$result_UTRAGETs =$db->RunQuery($sql_UTRAGETs);	
		if ($row_UTRAGETs = mysql_fetch_array($result_UTRAGETs)){
		
		} else {
			$sql_UTRAGETs="insert into tragets(C_CODE) values ('".$row_c_bal["CUSCODE"]."')";
			$result_UTRAGETs =$db->RunQuery($sql_UTRAGETs);	
		}
	}
	
	
	
	$sql_TARGET="select *  from tragets ";
	$result_TARGET =$db->RunQuery($sql_TARGET);
	while ($row_TARGET = mysql_fetch_array($result_TARGET)){
		 
		 $m_sales = 0;
		 
		 $sql_sales="select sum(GRAND_TOT-(GRAND_TOT*.112)) as sales from s_salma where Accname != 'NON STOCK' and SAL_EX= '".$_GET["Com_rep"]."' and  SDATE >= '".$_GET["dtfrom"]."' and SDATE <= '".$_GET["dtto"]."'  and CANCELL='0' and C_CODE='".$row_TARGET["C_CODE"]."' and DEV='1' ";
		 $result_sales =$db->RunQuery($sql_sales);	
		 if ($row_sales = mysql_fetch_array($result_sales)){
		 	if (is_null($row_sales["sales"])==false){
				 $m_sales = $row_sales["sales"];
			}
		 }
		 
		 $sql_sales="select sum(GRAND_TOT-(GRAND_TOT*.112)) as sales from s_salma where Accname != 'NON STOCK' and SAL_EX= '".$_GET["Com_rep"]."' and  SDATE >= '".$_GET["dtfrom"]."' and SDATE <= '".$_GET["dtto"]."'  and CANCELL='0' and C_CODE='".$row_TARGET["C_CODE"]."' and DEV='0' ";
		 $result_sales =$db->RunQuery($sql_sales);	
		 if ($row_sales = mysql_fetch_array($result_sales)){
		 	if (is_null($row_sales["sales"])==false){
				 $m_sales = $m_sales+$row_sales["sales"];
				 
			}
		 }
		 
   		 $m_rep = $_GET["Com_rep"];
		 $sql_sales="select sum(AMOUNT-(AMOUNT*.112)) as sales from c_bal where SAL_EX= '".$m_rep."' and  SDATE >= '".$_GET["dtfrom"]."' and SDATE <= '".$_GET["dtto"]."'  and trn_type!='ARN' and trn_type!='REC'and trn_type!='DGRN' and trn_type!='INC' and trn_type!='PAY' and flag1 != '1' and Cancell='0' and CUSCODE='".$row_TARGET["C_CODE"]."' ";
		 $result_sales =$db->RunQuery($sql_sales);	
		 if ($row_sales = mysql_fetch_array($result_sales)){
		 	if (is_null($row_sales["sales"])==false){
				 $m_sales = $m_sales-$row_sales["sales"];
				 
			}
		 }
		 
		 
  		
		$sql="update tragets set sale=".$m_sales.", TARDATE='0' where C_CODE='".$row_TARGET["C_CODE"]."'";
		 $result =$db->RunQuery($sql);	
   
	}

}


if ($_GET["Command"]=="pass_grnno"){
include_once("connection.php");

	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			$sql=mysql_query("Select * from s_crnma where REF_NO='".$_GET['grn']."'")or die(mysql_error());
			if($row = mysql_fetch_array($sql)){		
			
				$ResponseXML .= "<REF_NO><![CDATA[".$row['REF_NO']."]]></REF_NO>";
				$ResponseXML .= "<DDATE><![CDATA[".$row['DDATE']."]]></DDATE>";
				$ResponseXML .= "<C_CODE><![CDATA[".$row['C_CODE']."]]></C_CODE>";
				$ResponseXML .= "<CUS_NAME><![CDATA[".$row['CUS_NAME']."]]></CUS_NAME>";
				$ResponseXML .= "<INVOICENO><![CDATA[".$row['INVOICENO']."]]></INVOICENO>";
				$ResponseXML .= "<SAL_EX><![CDATA[".$row['SAL_EX']."]]></SAL_EX>";
				$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
				$ResponseXML .= "<Brand><![CDATA[".$row['Brand']."]]></Brand>";
				$ResponseXML .= "<DEPARTMENT><![CDATA[".$row['DEPARTMENT']."]]></DEPARTMENT>";
				
			//	$sql1="insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT) values ('".$row2["str_code"]."', '".$_GET["invdate"]."', '".$cur_qty."', 'GINI', '".$_GET["invno"]."', '".$_GET["from_dep"]."')";
				//	$result1 =$db->RunQuery($sql1);
				
				
				
				
				
						$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Pre.RetQty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ret.Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";
							
				$i=1;
				
				//echo "delete from tmp_grn_data where str_invno='".$row['REF_NO']."'";
				$sql_data = mysql_query("delete from tmp_grn_data where str_invno='".$row['REF_NO']."'") or die(mysql_error());
				//echo "Select * from s_invo where REF_NO='".$inv."'";
				
				$sql_data = mysql_query("Select count(*) as mcount from s_crntrn where REF_NO='".$row['REF_NO']."'") or die(mysql_error());
				$row_data = mysql_fetch_array($sql_data);
				$mcou=$row_data['mcount'];
				
				//echo "Select * from s_crntrn where REF_NO='".$row['REF_NO']."'";
				$sql_data = mysql_query("Select * from s_crntrn where REF_NO='".$row['REF_NO']."'") or die(mysql_error());
				while($row_data = mysql_fetch_array($sql_data)){
					$sql_itdata = mysql_query("Select * from s_mas where STK_NO='".$row_data['STK_NO']."' and BRAND_NAME='".$row["Brand"]."'") or die(mysql_error());
					$rowit = mysql_fetch_array($sql_itdata);
					
				
					$subtot=(floatval($row_data['PRICE'])*floatval($row_data['QTY']))-floatval($row_data['DIS_RS']);
					if ($row_data['DIS_RS']==""){$DIS_RS=0;} else {$DIS_RS=$row_data['DIS_RS'];}
					if ($row_data['DIS_P']==""){$DIS_P=0;} else {$DIS_P=$row_data['DIS_P'];}
					//echo $subtot;
				//	echo "Insert into tmp_grn_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$row['REF_NO']."', '".$row_data['STK_NO']."', '".$row_data['DESCRIPT']."', ".$row_data['PRICE'].", 0, ".$DIS_P.", ".$DIS_RS.", ".$subtot.", '".$row["Brand"]."')";
					$sql_tmp = mysql_query("Insert into tmp_grn_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$row['REF_NO']."', '".$row_data['STK_NO']."', '".$row_data['DESCRIPT']."', ".str_replace(",", "", $row_data['PRICE']).", 0, ".$DIS_P.", ".$DIS_RS.", ".$subtot.", '".$row["Brand"]."')") or die(mysql_error());
					
						$stkno="stkno".$i;
						$descript="descript".$i;
						$price="price".$i;
						$qty="qty".$i;
						$preretqty="preret".$i;
						$retqty="ret".$i;
						$disc="disc".$i;
						$subtot="subtot".$i;
			
			
					if (is_null($row_data['QTY']) or $row_data['QTY']==0){
						$ret_qty=0;
					} else {
						$ret_qty=$row_data['QTY'];
					}
					
				
			 	$ResponseXML .= "<tr>
                        
							 <td><input type=\"text\" name=".$stkno."  disabled id=".$stkno." value='".$row_data['STK_NO']."' class=\"text_purchase3\"/></td>
							 <td><input type=\"text\"  name=".$descript."  disabled id=".$descript." value='".$row_data['DESCRIPT']."' class=\"text_purchase3\"/></td>
							 <td><input type=\"text\" name=".$price."  disabled id=".$price." value=".number_format(str_replace(",", "", $row_data['PRICE']), 0, ".", ",")." class=\"text_purchase3\"/></td>";
							 
							 $sql_inv = mysql_query("Select * from s_invo where REF_NO='".$row['INVOICENO']."' and STK_NO='".$row_data['STK_NO']."'") or die(mysql_error());
							 $row_inv = mysql_fetch_array($sql_inv);
						
						$ResponseXML .= " <td><input type=\"text\" name=".$qty."  disabled id=".$qty." value=".number_format(str_replace(",", "", $row_inv['QTY']), 0, ".", ",")." class=\"text_purchase3\"/></td>
							 <td><input type=\"text\" name=".$preretqty."  disabled id=".$preretqty." value=".$ret_qty." class=\"text_purchase3\"/></td>
							
							 <td><input type=\"text\" name=".$retqty." id=".$retqty."  class=\"text_purchase3\" onKeyPress=\"ret_deduct('".$i."',event, '".$mcou."');\"/></td>
							 <td><input type=\"text\" name=".$disc." id=".$disc."  class=\"text_purchase3\" value=\"".$row_data['DIS_per']."\" /></td>
							 <td><input type=\"text\" name=".$subtot." id=".$subtot." value='0' class=\"text_purchase3\"/></td>
							 
							
							 
                            </tr>";
							
							$i=$i+1;
            					
				}
			
			    $ResponseXML .= "   </table>]]></sales_table>";
				
				
				$ResponseXML .= " </salesdetails>";
				
			}	
				
				
				echo $ResponseXML;
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
			$result =$db->RunQuery($sql);
			if ($row = mysql_fetch_array($result)) {
				if ($row["AMOUNT"]==$row["BALANCE"]){
					$sql1="update s_crnma set CANCELL='1' where REF_NO='".$_GET["grnno"]."'";
					$result1 =$db->RunQuery($sql1);
					
					$sql1="update s_crntrn set CANCELL='1' where REF_NO='".$_GET["grnno"]."'";
					$result1 =$db->RunQuery($sql1);
					
					$sql1="delete from c_bal where REFNO='".$_GET["grnno"]."'";
					$result1 =$db->RunQuery($sql1);
                  
				
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
							$result1 =$db->RunQuery($sql1);
											
							$sql1="update s_mas set QTYINHAND=QTYINHAND-".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."'";
							$result1 =$db->RunQuery($sql1);
					
							$sql1="update s_submas set QTYINHAND=QTYINHAND-".$_GET[$retqty]." where STK_NO='".$_GET[$stkno]."' and STO_CODE='".$_GET["department"]."'";
							$result1 =$db->RunQuery($sql1);
					
                           
						}
						$i=$i+1;
					}
			
					$sql1="delete from s_trn where ltrim(REFNO)='".$_GET["grnno"]."'";
					$result1 =$db->RunQuery($sql1);
							
					$sql1="delete from s_led where REF_NO='".$_GET["grnno"]."'";
					$result1 =$db->RunQuery($sql1);
			
		            $sql1="update s_salma set RET_AMO=RET_AMO+".$_GET["invtot"]." where REF_NO='".$_GET["grnno"]."'";
					$result1 =$db->RunQuery($sql1);
			        
        		    $sql1="update vendor set CUR_BAL=CUR_BAL+".$_GET["invtot"]." where CODE='".$_GET["cusno"]."'";
					$result1 =$db->RunQuery($sql1);        
               
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