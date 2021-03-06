<?php 
session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("connectioni.php");
	
	
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		
	
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
			
			$resultt =mysqli_query($GLOBALS['dbinv'],$sqlt);
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
			
			
			
			
			$sql="select DEL from s_salrep  where REPCODE = '".$_GET["Com_rep"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			if ($row = mysqli_fetch_array($result)){
			
				$invno = $_GET["Com_rep"]."/".trim($row["DEL"] + 1);
			} else {
				$invno = $_GET["Com_rep"]."/1";
			}
			
			$_SESSION["invno"]=$invno;
			
			$sql="delete from tmp_weekly_tar where ref_no='".$invno."'";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			echo $invno;
		}
	
	
	if($_GET["Command"]=="add_tmp")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			//$sql="delete from tmp_weekly_tar where ref_no='".$_GET['txtref']."'";
			//$ResponseXML .= $sql;
			//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$cus_name=str_replace("~", "&", $_GET["cus_name"]);
			
			$sql="Insert into tmp_weekly_tar (sal_ref, ref_no, tar_date, cus_code, cus_name, target, sale, remark)values 
			('".$_GET['Com_rep']."', '".$_GET['txtref']."', '".$_GET['tar_date']."', '".$_GET['cus_code']."', '".$cus_name."', ".$_GET["target"].", 0, '".$_GET['remark']."') ";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Target Date</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cus. Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cus. Name</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Target</font></td>
							  <td width=\"150\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Remark</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_weekly_tar where ref_no='".$_GET['txtref']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
				if ($row['target']==""){
					$target=0;
				} else {
					$target=$row['target'];
				}
				
				if ($row['sale']==""){
					$sale=0;
				} else {
					$sale=$row['sale'];
				}
							
             	$ResponseXML .= "<tr>                              
                            <td >".$row['tar_date']."</a></td>
							<td >".$row['cus_code']."</a></td>
							<td >".$row['cus_name']."</a></td>
							<td >".number_format($target, 2, ".", ",")."</a></td>
							<td >".$row['remark']."</a></td>
							<td><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['tar_date']."', '".$row['cus_code']."');\"></td>
							 
							
							 
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				
				
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
		
			
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			//$sql="delete from tmp_weekly_tar where ref_no='".$_GET['txtref']."'";
			//$ResponseXML .= $sql;
			//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
	
			
			$sql="delete from  tmp_weekly_tar where ref_no='".$_GET['txtref']."' and tar_date='".$_GET['tar_date']."' and cus_code='".$_GET['cus_code']."'";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Target Date</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cus. Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cus. Name</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Target</font></td>
							  <td width=\"150\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Remark</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_weekly_tar where ref_no='".$_GET['txtref']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){	
				if ($row['target']==""){
					$target=0;
				} else {
					$target=$row['target'];
				}
				
				if ($row['sale']==""){
					$sale=0;
				} else {
					$sale=$row['sale'];
				}
							
             	$ResponseXML .= "<tr>                              
                            <td >".$row['tar_date']."</a></td>
							<td >".$row['cus_code']."</a></td>
							<td >".$row['cus_name']."</a></td>
							<td >".number_format($target, 2, ".", ",")."</a></td>
							<td >".$row['remark']."</a></td>
							<td><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['tar_date']."', '".$row['cus_code']."');\"></td>
							 
							
							 
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	
if($_GET["Command"]=="save_item")
{
	
include('connectioni.php');
	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
 			$sql_status=0;
 
 			mysqli_query($GLOBALS['dbinv'],"SET AUTOCOMMIT=0");	 
    		mysqli_query($GLOBALS['dbinv'],"START TRANSACTION");	
 
 
			$sql_rsweek_tragets="Select refno  from week_tragets  where refno='".trim($_GET["txtref"])."' AND  rep='".$_GET["Com_rep"]."'";
			$result_rsweek_tragets =  mysqli_query($GLOBALS['dbinv'],$sql_rsweek_tragets);
			if($row_rsweek_tragets = mysqli_fetch_array($result_rsweek_tragets)){
				
				$sql="delete  from week_tragets  where refno='".$_GET["txtref"]."' AND  rep='".$_GET["Com_rep"]."'";
				$result = mysqli_query($GLOBALS['dbinv'],$sql);
				if ($result!=1){ $sql_status=1; }	
				
				$sql_tmp="Select * from tmp_weekly_tar where ref_no ='".trim($_GET["txtref"])."' ";
				$result_tmp = mysqli_query($GLOBALS['dbinv'],$sql_tmp);
				while ($row_tmp = mysqli_fetch_array($result_tmp)){
					 $dt = $row_tmp["tar_date"];
					 
					 $sql="insert into week_tragets (refno, rep, cus_code, Target, Sale, remark, Tardate, dtfrom) values ('".trim($_GET["txtref"])."', '".$_GET["Com_rep"]."', '".$row_tmp["cus_code"]."', ".$row_tmp["target"].", 0, '".$row_tmp["remark"]."', '".$dt."', '".$_GET["dtfrom"]."')";
					 $result = mysqli_query($GLOBALS['dbinv'],$sql);
					if ($result!=1){ $sql_status=2; }	
				}
				
			} else {		
				$sql="uPDATE s_salrep SET DEL=DEL +1 where REPCODE = '".$_GET["Com_rep"]."'";				
				$result = mysqli_query($GLOBALS['dbinv'],$sql);
				if ($result!=1){ $sql_status=3; }	
				
				$sql_rep="Select rgroup from s_salrep where REPCODE ='".$_GET["Com_rep"]."' ";
				$result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);
				$row_rep = mysqli_fetch_array($result_rep);	
				
				
				$sql="delete  from week_tragets  where refno='".$_GET["txtref"]."' AND  rep='".$_GET["Com_rep"]."'";				
				$result =  mysqli_query($GLOBALS['dbinv'],$sql);
				if ($result!=1){ $sql_status=4; }	
				
				$sql_tmp="Select * from tmp_weekly_tar where ref_no ='".trim($_GET["txtref"])."' ";
				//echo $sql_tmp;
				$result_tmp =  mysqli_query($GLOBALS['dbinv'],$sql_tmp);
				while ($row_tmp = mysqli_fetch_array($result_tmp)){
					 $dt = $row_tmp["tar_date"];
					 
					 $sql="insert into week_tragets (refno, rep, cus_code, Target, Sale, remark, Tardate, dtfrom) values ('".trim($_GET["txtref"])."', '".$_GET["Com_rep"]."', '".$row_tmp["cus_code"]."', ".$row_tmp["target"].", 0, '".$row_tmp["remark"]."', '".$dt."', '".$_GET["dtfrom"]."')";
					 //echo $sql;
					 $result =mysqli_query($GLOBALS['dbinv'],$sql);
					if ($result!=1){ $sql_status=5; }	
       
				}
		  
			}
			

			$sql="delete from tmp_weekly_tar where ref_no='".$_GET["txtref"]."'";
			//$ResponseXML .= $sql;
			$result = mysqli_query($GLOBALS['dbinv'],$sql);
			if ($result!=1){ $sql_status=6; }	
			
			if ($sql_status==0){
					
			mysqli_query($GLOBALS['dbinv'],"COMMIT");
			echo "Saved";
			} else {	
					
			mysqli_query($GLOBALS['dbinv'],"ROLLBACK");
			echo "Error has occured. Not Saved-" . $sql_status;
			}					
	}
	

if ($_GET["Command"]=="print_inv"){
	
	


}


if ($_GET["Command"]=="pass_grnno"){
include_once("connectioni.php");

	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			$sql=mysqli_query($GLOBALS['dbinv'],"Select * from s_crnma where REF_NO='".$_GET['grn']."'")or die(mysqli_error());
			if($row = mysqli_fetch_array($sql)){		
			
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
				//	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
				
				
				
				
				
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
				$sql_data = mysqli_query($GLOBALS['dbinv'],"delete from tmp_grn_data where str_invno='".$row['REF_NO']."'") or die(mysqli_error());
				//echo "Select * from s_invo where REF_NO='".$inv."'";
				
				$sql_data = mysqli_query($GLOBALS['dbinv'],"Select count(*) as mcount from s_crntrn where REF_NO='".$row['REF_NO']."'") or die(mysqli_error());
				$row_data = mysqli_fetch_array($sql_data);
				$mcou=$row_data['mcount'];
				
				//echo "Select * from s_crntrn where REF_NO='".$row['REF_NO']."'";
				$sql_data = mysqli_query($GLOBALS['dbinv'],"Select * from s_crntrn where REF_NO='".$row['REF_NO']."'") or die(mysqli_error());
				while($row_data = mysqli_fetch_array($sql_data)){
					$sql_itdata = mysqli_query($GLOBALS['dbinv'],"Select * from s_mas where STK_NO='".$row_data['STK_NO']."' and BRAND_NAME='".$row["Brand"]."'") or die(mysqli_error());
					$rowit = mysqli_fetch_array($sql_itdata);
					
				
					$subtot=(floatval($row_data['PRICE'])*floatval($row_data['QTY']))-floatval($row_data['DIS_RS']);
					if ($row_data['DIS_RS']==""){$DIS_RS=0;} else {$DIS_RS=$row_data['DIS_RS'];}
					if ($row_data['DIS_P']==""){$DIS_P=0;} else {$DIS_P=$row_data['DIS_P'];}
					//echo $subtot;
				//	echo "Insert into tmp_grn_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$row['REF_NO']."', '".$row_data['STK_NO']."', '".$row_data['DESCRIPT']."', ".$row_data['PRICE'].", 0, ".$DIS_P.", ".$DIS_RS.", ".$subtot.", '".$row["Brand"]."')";
					$sql_tmp = mysqli_query($GLOBALS['dbinv'],"Insert into tmp_grn_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$row['REF_NO']."', '".$row_data['STK_NO']."', '".$row_data['DESCRIPT']."', ".str_replace(",", "", $row_data['PRICE']).", 0, ".$DIS_P.", ".$DIS_RS.", ".$subtot.", '".$row["Brand"]."')") or die(mysqli_error());
					
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
							 
							 $sql_inv = mysqli_query($GLOBALS['dbinv'],"Select * from s_invo where REF_NO='".$row['INVOICENO']."' and STK_NO='".$row_data['STK_NO']."'") or die(mysqli_error());
							 $row_inv = mysqli_fetch_array($sql_inv);
						
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
		
		$sql="delete  from week_tragets  where refno='".$_GET["txtref"]."' AND  rep='".$_GET["Com_rep"]."'";
				//echo $sql;
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
				
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