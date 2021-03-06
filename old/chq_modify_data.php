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
			
		  if ($_SESSION["dev"]==""){
		  	exit("no");
		  }
		  	
			$_SESSION["insert"]=1;
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			
			
			$sql="Select Che_exten from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["Che_exten"];
			$lenth=strlen($tmpinvno);
			$invno=trim("CEX/ ").substr($tmpinvno, $lenth-8);
			$_SESSION["invno"]=$invno;
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			$ResponseXML .= "<invno><![CDATA[".$invno."]]></invno>";
			$ResponseXML .= "<curdate><![CDATA[".date("Y-m-d")."]]></curdate>";
			$ResponseXML .= "<curtime><![CDATA[".date("H:i:s")."]]></curtime>";
			$ResponseXML .= " </salesdetails>";
			echo $ResponseXML;
			
		
			
			
		

		}
	
	
	if($_GET["Command"]=="add_tmp")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="delete from tmp_purord_data where str_code='".$_GET['itemcode']."' and tmp_no='".$_SESSION['tmp_no_purord']."' ";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			
			$qty=str_replace(",", "", $_GET["qty"]);
			
			
			$sql="Insert into tmp_purord_data (tmp_no, str_invno, str_code, str_description, partno, qty)values 
			('".$_SESSION["tmp_no_purord"]."', '".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', '".$_GET["partno"]."', ".$qty.") ";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                             
                            </tr>";
							
			
			$sql="Select * from tmp_purord_data where tmp_no='".$_SESSION['tmp_no_purord']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td >".$row['str_code']."</a></td>
							 <td >".$row['str_description']."</a></td>
							 <td >".$row['partno']."</a></td>
							 <td >".number_format($row['qty'], 2, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
                           
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
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
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			if($row = mysqli_fetch_array($result)){
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
				$ResponseXML .= "<pi_no><![CDATA[".$row['pi_no']."]]></pi_no>";
				$ResponseXML .= "<Brand><![CDATA[".$row['Brand']."]]></Brand>";
				$_SESSION['tmp_no_purord']=$row["tmp_no"];
			}	
			
			$sql="delete from tmp_purord_data where tmp_no='".$_SESSION['tmp_no_purord']."' ";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="select * from s_ordtrn where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			while($row = mysqli_fetch_array($result)){
				$sql1="Insert into tmp_purord_data (tmp_no, str_invno, str_code, str_description, partno, qty)values 
				('".$_SESSION['tmp_no_purord']."', '".$row['REFNO']."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', '".$row["partno"]."', ".$row["ORD_QTY"].") ";
			//$ResponseXML .= $sql;
				$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 	
			}
							
			
			
	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"70\"  background=\"\" >Code</td>
                              <td width=\"300\"  background=\"\">Description</td>
                              <td width=\"100\"  background=\"\">Part No</td>
                              <td width=\"100\"  background=\"\">Qty</td>
                             
                            </tr>";
							
			
			$sql="Select * from tmp_purord_data where str_invno='".$_GET['invno']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td >".$row['str_code']."</a></td>
							 <td>".$row['str_description']."</a></td>
							 <td >".$row['partno']."</a></td>
							 <td >".number_format($row['qty'], 0, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
                           
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
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_purord_data where str_code='".$_GET['code']."' and tmp_no='".$_GET['tmp_no']."' ";
			
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_purord_data where str_invno='".$_GET['invno']."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
			while($row = mysqli_fetch_array($result)){				
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
	
	if ($_SESSION["dev"]==""){
		exit("no");
	}
	
	if ((trim($_GET["txtfirstdate"]) == "") and (trim($_GET["txtseconddate"]) == "")) { 
		
		$sql="update s_invcheq set che_date='" . $_GET["txtchq_date"] . "', ex_flag='M', ex_date1='" . trim($_GET["txtpredate"]) . "' where cus_code='" . trim($_GET["txtcode"]) . "' and cheque_no='" . trim($_GET["txtch_no"]) . "'";
		//echo $sql;
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	}	
	
	if ((trim($_GET["txtfirstdate"]) != "") and (trim($_GET["txtseconddate"]) == "")) { 
		
		$sql="update s_invcheq set che_date='" . $_GET["txtchq_date"] . "', ex_flag='M', ex_date2='" . trim($_GET["txtpredate"]) . "' where cus_code='" . trim($_GET["txtcode"]) . "' and cheque_no='" . trim($_GET["txtch_no"]) . "'";
		//echo $sql;
		$result =mysqli_query($GLOBALS['dbinv'],$sql); 
		
	}	

	$diff = abs(strtotime($_GET["txtchq_date"]) - strtotime($_GET["txtpredate"]));
	$exdays = floor($diff / (60*60*24));
											
	if (trim($_GET["txtrectype"])== "REC") {
		$sql="UPDATE s_sttr SET st_days=st_days+" . $exdays . ", ap_days=ap_days+" . $exdays . ", st_chdate='" . $_GET["txtchq_date"] . "' where st_chno='" . trim($_GET["txtch_no"]) . "' and cus_code='" . trim($_GET["txtcode"]) . "'";
		//echo $sql;
		$result =mysqli_query($GLOBALS['dbinv'],$sql); 
	}

	echo "Saved";		
			
}
	

if($_GET["Command"]=="apprive")
{
	
	if ($_SESSION["dev"]==""){
		exit("no");
	}
	
	$app = $_SESSION["CURRENT_USER"] . " - " . date("Y-m-d") . " - " . date("H:i:s");



	$sql1="update s_cheque_extend set approved='" . $app . "'  where refno='" . trim($_GET["txtrefno"]) . "'";
	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
	
	if ($result1==true){
		echo "Updated";
	}

}	

if($_GET["Command"]=="acc_apprive")
{
	if ($_SESSION["dev"]==""){
		exit("no");
	}
	
	$sql="select * from s_cheque_extend where refno='" . trim($_GET["txtrefno"]) . "'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	if($row_rs = mysqli_fetch_array($result)){
		if ($row_rs["approved"] == "0") {
   			exit("Not Approved");
   		}
	} else {
		exit("Entry Not Found");
	}

	$sql="Select * from s_invcheq where  cheque_no ='" . trim($_GET["txtch_no"]) . "' and cus_code = '" . trim($_GET["txtcode"]) . "'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	if($row_rs = mysqli_fetch_array($result)){
		
		$date1 = $_GET["txtch_date"];
		$date2 = $_GET["txtchexdate"];
		$diff = abs(strtotime($date2) - strtotime($date1));
		$days = floor($diff / (60*60*24));
				
    	$exdays = $days;
   	 	$c_date = $row_rs["che_date"];
    	
		if ( ((is_null($row_rs["ex_date1"])==false) and ($row_rs["ex_date1"]!="0000-00-00"))  and ((is_null($row_rs["ex_date2"])==false) and ($row_rs["ex_date2"]!="0000-00-00")) ) {
        	exit("Date cannot modified further");
        
    	}
		
    	if ( ((is_null($row_rs["ex_date1"])==true) or ($row_rs["ex_date1"]=="0000-00-00"))  and ((is_null($row_rs["ex_date2"])==true) or ($row_rs["ex_date2"]=="0000-00-00")) ) {
			
			$sql1="update s_invcheq set che_date='" . $_GET["txtchexdate"] . "', ex_flag='M', ex_date1='" . trim($c_date) . "' where cus_code='" . trim($_GET["txtcode"]) . "' and cheque_no='" . trim($_GET["txtch_no"]) . "'";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
		}	
    	
		if ( ((is_null($row_rs["ex_date1"])==false) and ($row_rs["ex_date1"]!="0000-00-00"))  and ((is_null($row_rs["ex_date2"])==true) or ($row_rs["ex_date2"]=="0000-00-00")) ) {
			
			$sql1="update s_invcheq set che_date='" . $_GET["txtchexdate"] . "', ex_flag='M', ex_date2='" . trim($c_date) . "' where cus_code='" . trim($_GET["txtcode"]) . "' and cheque_no='" . trim($_GET["txtch_no"]) . "'";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			
		}	
    	
		if (trim($row_rs["trn_type"]) == "REC") {
			$sql1="UPDATE s_sttr SET ST_DATE=ST_DATE+" . $exdays . ", ap_days=ap_days+" . $exdays . ", st_chdate='" . $_GET["txtchexdate"] . "' where ST_CHNO='" . trim($_GET["txtch_no"]) . "' and cus_code='" . trim($_GET["txtcode"]) . "'";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
		}
	}

	$app_ac = $_GET["CURRENT_USER"] . " - " . date("Y-m-d") . " - " . date("H:i:s");
	
	$sql1="update s_cheque_extend set acc_approved='" . $app_ac . "' where refno='" . trim($_GET["txtrefno"]) . "'";
	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			
	echo  "Updated";

}	


if($_GET["Command"]=="acc_no")
{
	if ($_SESSION["dev"]==""){
		exit("no");
	}
	
	$sql_rs="select * from s_cheque_extend where refno='" . trim($_GET["txtrefno"]) . "'";
	$result_rs =mysqli_query($GLOBALS['dbinv'],$sql_rs);
	if($row_rs = mysqli_fetch_array($result_rs)){
		
		if ($row_rs["approved"] == "0") {
   			exit("Not Approved");
   		}

	} else {
		exit("Entry Not Found");
	}
	

	$acc_no = $_GET["CURRENT_USER"] . "-N/A -" . date("Y-m-d") . " - " . date("H:i:s");
	
	$sql_rs="update s_cheque_extend set acc_approved='" . $acc_no . "' where refno='" . trim($_GET["txtrefno"]) . "'";
	$result_rs =mysqli_query($GLOBALS['dbinv'],$sql_rs);
	
	echo "Chq extended date ignored";
}	

if($_GET["Command"]=="cancel_inv")
{
	$sql1="update s_ordmas set cancel='1' where REFNO='".$_GET["invno"]."'";
	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
	
	$sql1="update s_ordtrn set CANCEL='1' where REFNO='".$_GET["invno"]."'";
	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
	echo "Canceled!";
}	
	
if ($_GET["Command"]=="check_print")
{
	
	echo $_SESSION["print"];
}

	
if($_GET["Command"]=="tmp_crelimit")
{	
	//echo "abc";
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