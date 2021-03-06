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
			
			
			$_SESSION["insert"]=1;
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			$sql="Select ORD_NO from invpara";
			$result =$db->RunQuery($sql);
			if ($row = mysql_fetch_array($result)){
				$tmpinvno="000000".$row["ORD_NO"];
				$lenth=strlen($tmpinvno);
				$invno=trim("ORD/").$_GET["salesrep"]."/".substr($tmpinvno, $lenth-7);
			} else {
				$invno=trim("ORD/00001");
			}
			
			
			$_SESSION["invno"]=$invno;
		
			$sql="Select ORD_NO from tmpinvpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$_SESSION["tmp_no_lc_ord"]=$row["ORD_NO"];
			
			$sql1="delete from tmp_purord_data where tmp_no='".$_SESSION["tmp_no_lc_ord"]."'";
			$result1 =$db->RunQuery($sql1);
			
			$sql1="update tmpinvpara set ORD_NO=ORD_NO+1";
			$result1 =$db->RunQuery($sql1);
			
			echo $invno;	
			
		}
	
	
	if($_GET["Command"]=="add_tmp")
		{
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			$qty=0;
			$totval=0;
			
			//$department=$_GET["department"];
			if (trim($_GET["brand"]) != "") {
   				$sql_smas="select * from s_mas where STK_NO = '".$_GET["itemcode"]."' and BRAND_NAME='".$_GET["brand"]."'";
				$result_smas =$db->RunQuery($sql_smas);
			} else {
				$sql_smas="select * from s_mas where STK_NO = '".$_GET["itemcode"]."' ";
				$result_smas =$db->RunQuery($sql_smas);
  			}
			if ($row_smas = mysql_fetch_array($result_smas)){
				$sql="select QTYINHAND from s_submas where STK_NO='".$_GET["itemcode"]."' AND STO_CODE='".$_GET["department"]."'";
				//echo $sql;
				$result =$db->RunQuery($sql);
  				if ($row = mysql_fetch_array($result)){
      				if (is_null($row["QTYINHAND"])==false) { 
						$qty = $row["QTYINHAND"];
						$qtystr = "Stock -> ".$row["QTYINHAND"];
						$ResponseXML .= "<QTYINHAND><![CDATA[".$qtystr."]]></QTYINHAND>";
   					}
   					
					$sql_totval="select * from s_mas where STK_NO = '".$_GET["itemcode"]."' ";
					$result_totval =$db->RunQuery($sql_totval);
					if ($row_totval = mysql_fetch_array($result_totval)){
						if ((is_null($row_totval["SELLING"])==false) and ($_GET["txt_dis"] != "")) {
                			$totval = ((($row_totval["SELLING"] - ($row_totval["SELLING"] * ($_GET["txt_dis"] / 100)) / 112) * 100) * $_GET["qty"]);
							$txt_subtot = $_GET["txt_subtot"] + (((($row_totval["SELLING"]) - ($row_totval["SELLING"]) * ($_GET["txt_dis"] / 100)) / 112) * 100) * $_GET["qty"];
                			
             			}
					}
					
         		} 
			}


			
			
			
			$sql="delete from tmp_purord_data where str_code='".$_GET['itemcode']."' and tmp_no='".$_SESSION['tmp_no_lc_ord']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			
			$qty=str_replace(",", "", $_GET["qty"]);
			
			
			$sql="Insert into tmp_purord_data (tmp_no, str_invno, str_code, str_description, partno, qty, subtotal)values 
			('".$_SESSION["tmp_no_lc_ord"]."', '".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', '".$_GET["partno"]."', ".$qty.", ".$totval.") ";
			//echo $sql;
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_purord_data where tmp_no='".$_SESSION['tmp_no_lc_ord']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td >".$row['str_code']."</a></td>
							 <td >".$row['str_description']."</a></td>
							 <td >".$row['partno']."</a></td>
							 <td >".number_format($row['qty'], 2, ".", ",")."</a></td>
							 <td >".number_format($row['subtotal'], 2, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
                           
			}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
			
			$TypeGrid1=array(array());	
				
			$DT = $_GET["invdate"];
			$Mon = date("m", $_GET["invdate"]);
			$year =  date("Y", $_GET["invdate"]);
			$mrep = $_GET["salesrep"];
			$mstkno = $_GET["itemcode"];
			$ii = 1;
			while ($ii <= 6){
   				if ($Mon == 1) {
      				$Mon = 12;
      				$year = $year - 1;
   				} else {
     				$Mon = $Mon - 1;
   				}
   				$TypeGrid1[0][7 - $ii] = $Mon;
   				$ii = $ii + 1;
			}
			//$DT = $DT - 185;
			//$DT = Format(DT, "MM-01-YYYY")
			$DT = date('Y-m-d', strtotime($DT . ' - 185 days'));
	
			$sql="SELECT SUM(QTY) AS QTY, STK_NO, MONTH(SDATE) AS month, Brand, LEDINDI From VIEW_strn_smas_salma WHERE  SDATE >'".$DT."' and LEDINDI='INV' and STK_NO='".$mstkno."' and SALEX = '".$_GET["salesrep"]."'  GROUP BY STK_NO, MONTH(SDATE), Brand, LEDINDI order by MONTH(SDATE)";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){			
				
				if ($row["month"] == $TypeGrid1[0][1]) { $TypeGrid1[1][1]= $row["QTY"]; }
				if ($row["month"] == $TypeGrid1[0][2]) { $TypeGrid1[1][2]= $row["QTY"]; }
				if ($row["month"] == $TypeGrid1[0][3]) { $TypeGrid1[1][3]= $row["QTY"]; }
				if ($row["month"] == $TypeGrid1[0][4]) { $TypeGrid1[1][4]= $row["QTY"]; }
				if ($row["month"] == $TypeGrid1[0][5]) { $TypeGrid1[1][5]= $row["QTY"]; }
				if ($row["month"] == $TypeGrid1[0][6]) { $TypeGrid1[1][6]= $row["QTY"]; }
			}

			$sql="SELECT SUM(QTY) AS QTY, STK_NO, MONTH(SDATE) AS month, Brand, LEDINDI From VIEW_strn_smas_crnma  WHERE  SDATE >'".$DT."' and LEDINDI='GRN' and STK_NO='".$mstkno."' and SAL_EX = '".$_GET["salesrep"]."'  GROUP BY STK_NO, MONTH(SDATE), Brand, LEDINDI order by MONTH(SDATE)";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){			
				
				if ($row["month"] == $TypeGrid1[0][1]) { $TypeGrid1[1][1]= $TypeGrid1[1][1] - $row["QTY"]; }
				if ($row["month"] == $TypeGrid1[0][2]) { $TypeGrid1[1][2]= $TypeGrid1[1][2] - $row["QTY"]; }
				if ($row["month"] == $TypeGrid1[0][3]) { $TypeGrid1[1][3]= $TypeGrid1[1][3] - $row["QTY"]; }
				if ($row["month"] == $TypeGrid1[0][4]) { $TypeGrid1[1][4]= $TypeGrid1[1][4] - $row["QTY"]; }
				if ($row["month"] == $TypeGrid1[0][5]) { $TypeGrid1[1][5]= $TypeGrid1[1][5] - $row["QTY"]; }
				if ($row["month"] == $TypeGrid1[0][6]) { $TypeGrid1[1][6]= $TypeGrid1[1][6] - $row["QTY"]; }
			}
			
			
			
			$ResponseXML .= "<consumption_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">".$TypeGrid1[0][1]."</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">".$TypeGrid1[0][2]."</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">".$TypeGrid1[0][3]."</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">".$TypeGrid1[0][4]."</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">".$TypeGrid1[0][5]."</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">".$TypeGrid1[0][6]."</font></td>
                            </tr>";
							
			
			
				
             	$ResponseXML .= "<tr>                              
                             <td >".$TypeGrid1[1][1]."</td>
							 <td >".$TypeGrid1[1][2]."</td>
							 <td >".$TypeGrid1[1][3]."</td>
							 <td >".$TypeGrid1[1][4]."</td>
							 <td >".$TypeGrid1[1][5]."</td>
							 <td >".$TypeGrid1[1][6]."</td></tr>";
							 
                           
						
							
                $ResponseXML .= "   </table>]]></consumption_table>";
				
			
				
				
				
			$sql="Select * from s_mas where STK_NO = '".$_GET["itemcode"]."'";
			$result =$db->RunQuery($sql);	
			
				$DT=date("Y-m-d");
				$DT = date('Y-m-d', strtotime($DT . ' - 90 days'));
				
			$sql1="select sum(REC_QTY) as stk from s_purtrn where STK_NO='".$_GET["itemcode"]."' and CANCEL='0' and SDATE > '".$DT."'";
			$result1 =$db->RunQuery($sql1);	
			$row1 = mysql_fetch_array($result1);
			
			if (is_null($row1["stk"])==false) { $mnewstk = $row1["stk"]; }
				
			if($row = mysql_fetch_array($result)){		
				if (is_null($row["QTYINHAND"])==false) {
        			if ($row["QTYINHAND"] > $mnewstk) {
            			$txtunsold = $row["QTYINHAND"] - $mnewstk;
        			}
    			}
			}
			
			$ResponseXML .= "<txtunsold><![CDATA[".$txtunsold."]]></txtunsold>";
			$ResponseXML .= "<txt_subtot><![CDATA[".$txt_subtot."]]></txt_subtot>";
			
			$ResponseXML .= " </salesdetails>";	

		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	if($_GET["Command"]=="purord")
		{
		
			//$department=$_GET["department"];
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			$_SESSION["update"]=1;
			
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
				$_SESSION["tmp_no_lc_ord"]=$row["tmp_no"];
			}	
			
			$sql="delete from tmp_purord_data where tmp_no='".$_SESSION["tmp_no_lc_ord"]."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			$sql="select * from s_ordtrn where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			while($row = mysql_fetch_array($result)){
				$sql1="Insert into tmp_purord_data (tmp_no, str_invno, str_code, str_description, partno, qty)values 
				('".$_SESSION["tmp_no_lc_ord"]."', '".$row['REFNO']."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', '".$row["partno"]."', ".$row["ORD_QTY"].") ";
			//$ResponseXML .= $sql;
				$result1 =$db->RunQuery($sql1);	
			}
							
			
			
	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"70\"  background=\"images/headingbg.gif\" >Code</td>
                              <td width=\"300\"  background=\"images/headingbg.gif\">Description</td>
                              <td width=\"100\"  background=\"images/headingbg.gif\">Part No</td>
                              <td width=\"100\"  background=\"images/headingbg.gif\">Qty</td>
                             
                            </tr>";
							
			
			$sql="Select * from tmp_purord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td >".$row['str_code']."</a></td>
							 <td>".$row['str_description']."</a></td>
							 <td >".$row['partno']."</a></td>
							 <td >".number_format($row['qty'], 2, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
                           
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
			
	
			$sql="delete from tmp_purord_data where str_code='".$_GET['code']."' and tmp_no='".$_GET['tmp_no_lc_ord']."' ";
			
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
                              
                             <td >".$row['str_code']."</a></td>
							 <td >".$row['str_description']."</a></td>
							 <td >".$row['partno']."</a></td>
							 <td >".$row['qty']."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
						
				}			
				
				$ResponseXML .= "   </table>]]></sales_table>";
							
                $ResponseXML .= " </salesdetails>";
				
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	
if($_GET["Command"]=="save_item")
{

	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
		//	$_SESSION["CURRENT_DOC"] = 1;      //document ID
		//	$_SESSION["VIEW_DOC"] = false ;     //view current document
		//	$_SESSION["FEED_DOC"] = true;       //save  current document
		//	$_GET["MOD_DOC"] = false  ;         //delete   current document
		//	$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
		//	$_GET["PRICE_EDIT"] = false ;       //edit selling price
		//	$_GET["CHECK_USER"] = false ;       //check user permission again

		
			//$cre_balance=str_replace(",", "", $_GET["balance"]);

			
			
			$sql="select * from s_ordmas where tmp_no='".$_SESSION["tmp_no_lc_ord"]."'";
			$result =$db->RunQuery($sql);
			//echo $sql;
			if($row = mysql_fetch_array($result)){
				$sql1="delete from s_ordtrn where tmp_no='".$_SESSION["tmp_no_lc_ord"]."'";
				$result1 =$db->RunQuery($sql1);	
			} else {
				$sql="Select ORD_NO from invpara";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
				$tmpinvno="000000".$row["ORD_NO"];
				$lenth=strlen($tmpinvno);
				$invno=trim("ORD/").$_GET["salesrep"]."/".substr($tmpinvno, $lenth-7);
				$_SESSION["invno"]=$invno;
				
				$sql1="update invpara set ORD_NO=ORD_NO+1";
				$result1 =$db->RunQuery($sql1);
			}
			
			$sql2="select * from s_salrep where REPCODE='".$_GET["salesrep"]."'";
				$result2 =$db->RunQuery($sql2);
				$row2 = mysql_fetch_array($result2);
			
			$sql="select * from s_ordmas where REFNO='".$_GET["invno"]."'";
			//echo $sql;
			$result =$db->RunQuery($sql);
			if ($row = mysql_fetch_array($result)){
				$sql1="delete from s_repordtrn where REFNO='".$_GET["invno"]."'";
				$result1 =$db->RunQuery($sql1);
				
				
			
				$sql1="update s_ordmas set SDATE='".$_GET["dte_shedule"]."', REMARK='".$_GET["remarks"]."', S_date='".$_GET["invdate"]."', LC_No='".$_GET["lc_no"]."', DEP_CODE='".$_GET["department"]."', DEP_NAME='".$_GET["department"]."', Brand='".$_GET["brand"]."', REP_CODE='".$_GET["salesrep"]."', REP_NAME='".$row2["Name"]."', SUP_CODE='".$_GET["supplier_code"]."', SUP_NAME='".$_GET["supplier_name"]."', AMOUNT=0, cancel='0' where REFNO='".$_GET["invno"]."' ";
				//echo $sql1;
				$result1 =$db->RunQuery($sql1);
				
			} else {
				
				
				$sql1="insert into s_ordmas(REFNO, SDATE, REMARK, S_date, LC_No, DEP_CODE, DEP_NAME, Brand, REP_CODE, REP_NAME, SUP_CODE, SUP_NAME, AMOUNT, cancel, tmp_no) values ('".$_GET["invno"]."', '".$_GET["dte_shedule"]."', '".$_GET["remarks"]."', '".$_GET["invdate"]."', '".$_GET["lc_no"]."', '".$_GET["department"]."', '".$_GET["department"]."', '".$_GET["brand"]."', '".$_GET["salesrep"]."', '".$row2["Name"]."', '".$_GET["supplier_code"]."', '".$_GET["supplier_name"]."', 0 , '0', '".$_SESSION["tmp_no_lc_ord"]."')";
				//echo $sql1;
				$result1 =$db->RunQuery($sql1);
				
				$sql1="UPDATE invpara SET ORD_NO=ORD_NO+1";
				$result1 =$db->RunQuery($sql1);
			
			}
			
			
				
			
			$sql="select * from tmp_purord_data where tmp_no='".$_SESSION["tmp_no_lc_ord"]."'";
			//echo $sql;
			$result =$db->RunQuery($sql);
			while($row = mysql_fetch_array($result)){
    			$sql1="insert into s_repordtrn(REFNO, SDATE, STK_NO, DESCRIPT, ORD_QTY, partno, CANCEL, tmp_no) values ('".$row["str_invno"]."', '".$_GET["invdate"]."', '".$row["str_code"]."','".$row["str_description"]."','".$row["qty"]."','".$row["partno"]."','0', '".$_SESSION["tmp_no_lc_ord"]."')";
				//echo $sql1;
				$result1 =$db->RunQuery($sql1);	
  			}
			
			$sql="delete from tmp_purord_data where tmp_no='".$_SESSION["tmp_no_lc_ord"]."'";
			$result =$db->RunQuery($sql);
		//$_SESSION["print"]=1;

			
			echo "Saved";
			
			
	}

if($_GET["Command"]=="lcord")
		{
		
			//$department=$_GET["department"];
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			$_SESSION["update"]=1;
			
			$sql="select * from s_ordmas where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			if($row = mysql_fetch_array($result)){
				$ResponseXML .= "<invno><![CDATA[".$row['REFNO']."]]></invno>";
				$ResponseXML .= "<supplier_code><![CDATA[".$row['SUP_CODE']."]]></supplier_code>";
				$ResponseXML .= "<supplier_name><![CDATA[".$row['SUP_NAME']."]]></supplier_name>";
				$ResponseXML .= "<lc_no><![CDATA[".$row['LC_No']."]]></lc_no>";
				$ResponseXML .= "<department><![CDATA[".$row['DEP_CODE']."]]></department>";
				$ResponseXML .= "<brand><![CDATA[".$row['Brand']."]]></brand>";
				$ResponseXML .= "<salesrep><![CDATA[".$row['REP_CODE']."]]></salesrep>";
				$ResponseXML .= "<remarks><![CDATA[".$row['REMARK']."]]></remarks>";
				
				$ResponseXML .= "<txt_subtot><![CDATA[".$row['AMOUNT']."]]></txt_subtot>";
				
				$_SESSION["tmp_no_lc_ord"]=$row["tmp_no"];
			}	
			
			$sql="delete from tmp_purord_data where tmp_no='".$_SESSION["tmp_no_lc_ord"]."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			$sql="select * from s_repordtrn where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			while($row = mysql_fetch_array($result)){
				$sql1="Insert into tmp_purord_data (tmp_no, str_invno, str_code, str_description, partno, qty)values 
				('".$_SESSION["tmp_no_lc_ord"]."', '".$row['REFNO']."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', '".$row["partno"]."', ".$row["ORD_QTY"].") ";
			//$ResponseXML .= $sql;
				$result1 =$db->RunQuery($sql1);	
			}
							
			
			
	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"70\"  background=\"images/headingbg.gif\" >Code</td>
                              <td width=\"300\"  background=\"images/headingbg.gif\">Description</td>
                              <td width=\"100\"  background=\"images/headingbg.gif\">Part No</td>
                              <td width=\"100\"  background=\"images/headingbg.gif\">Qty</td>
                             
                            </tr>";
							
			
			$sql="Select * from tmp_purord_data where str_invno='".$_GET['invno']."'";
			//echo $sql;
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td >".$row['str_code']."</a></td>
							 <td>".$row['str_description']."</a></td>
							 <td >".$row['partno']."</a></td>
							 <td >".number_format($row['qty'], 2, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
                           
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}	

if($_GET["Command"]=="cancel_inv")
{
	$sql1="update s_ordmas set cancel='1' where REFNO='".$_GET["invno"]."'";
	$result1 =$db->RunQuery($sql1);
	
	$sql1="update s_ordtrn set CANCEL='1' where REFNO='".$_GET["invno"]."'";
	$result1 =$db->RunQuery($sql1);
	echo "Canceled!";
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