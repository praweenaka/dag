<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("connectioni.php");
	
	
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
		
if($_GET["Command"]=="get_bank")
{
	$sql="select * from bankmas where bcode='".$_GET["bankcode"]."'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	if ($row = mysqli_fetch_array($result)){
		echo $row["bname"];
	}
}
/*
if ($_GET["Command"]=="pass_cus_cash_rec")
{
	include_once("connectioni.php");
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				
		
				$sql = mysqli_query($GLOBALS['dbinv'],"Select * from vendor where CODE='".$_GET['custno']."'") or die(mysqli_error());
				if($row = mysqli_fetch_array($sql)){
					$ResponseXML .= "<code><![CDATA[".$row['CODE']."]]></code>";
					$ResponseXML .= "<name><![CDATA[".$row['NAME']."]]></name>";
					$ResponseXML .= "<address><![CDATA[".$row['ADD1']." ".$row['ADD2']."]]></address>";
				}
				
					$ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=1  cellspacing=0>
								<tr><td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Invoice No</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Value</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Paid</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Overdue</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Chq Pay</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Chq Balance</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cash Pay</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Inv Balance</font></td></tr>";
				
				//$sql = mysqli_query($GLOBALS['dbinv'],"Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and DEV='" & rsusercon!dev & "' and CANCELL='0' and SAL_EX='" & Trim(Left(Com_rep, 5)) & "' and Accname <> 'NON STOCK' ORDER BY SDATE") or die(mysqli_error());
			//	echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0' and SAL_EX='".$_GET["refno"]."' and Accname <> 'NON STOCK' ORDER BY SDATE";
				
				$i=1;
			//	echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0'  ORDER BY SDATE";
			
			if ($_GET['refno']==""){
				$sql = mysqli_query($GLOBALS['dbinv'],"Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and (GRAND_TOT-TOTPAY)>0.5 and CANCELL='0' and Accname='NON STOCK' ORDER BY SDATE") or die(mysqli_error());
			} else {
			
				$sql = mysqli_query($GLOBALS['dbinv'],"Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and (GRAND_TOT-TOTPAY)>0.5 and CANCELL='0' and SAL_EX='".$_GET['refno']."' and Accname='NON STOCK'  ORDER BY SDATE") or die(mysqli_error());
			}	
				while($row = mysqli_fetch_array($sql)){

					 $sdate="sdate".$i;
					  $delidate="delidate".$i;
					  
					  $invval="invval".$i;
					
					
						if (is_null($row["deli_date"]==false)){
							$ResponseXML .= "<tr><td><div id=".$delidate.">".$row["REQ_DATE"]."</div></td>";
						} else {
							$ResponseXML .= "<tr><td><div id=".$delidate.">".$row["SDATE"]."</div></td>";
						}	
						
						$ResponseXML .= "<td><div id=".$sdate.">".$row["SDATE"]."</div></td>";
						
						$j=$i+1;
						
						$overdue="overdue".$i;
						
						$chq_pay="chq_pay".$i;
						$chq_pay_next="chq_pay".$j;
						
						$chq_balance="chq_balance".$i;
						$chq_balance_next="chq_balance".$j;
						
						$cash_pay="cash_pay".$i;
						$cash_pay_next="cash_pay".$j;
						
						$inv_balance="inv_balance".$i;
						$overdueamt=$row["GRAND_TOT"]-$row["TOTPAY"];
						//number_format($row["GRAND_TOT"]-$row["TOTPAY"], 2, ".")
						
						$invno="invno".$i;
						
					$ResponseXML .= "<td><div id=".$invno.">".$row["REF_NO"]."</div></td>
									 <td><div id=".$invval.">".number_format($row["GRAND_TOT"], 2, ".", ",")."</div></td>
									 <td>".number_format($row["TOTPAY"], 2, ".", ",")."</td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$overdue." id=".$overdue." value=".$overdueamt." size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$chq_pay." id=".$chq_pay." onBlur=\"calc_bal('$overdue', '$chq_pay', '$inv_balance', '$chq_balance', '$chq_balance_next', '$cash_pay', '$i', event);\"  onKeyPress=\"keyset('$chq_pay_next', event);\"   size=\"10\"/></td>									
									 <td><input type=\"text\"  class=\"txtbox\" name=".$chq_balance." disabled id=".$chq_balance." onKeyPress=\"keysetvalue('$chq_balance','$chq_balance_next', '$chq_pay', event);\" size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$cash_pay." id=".$cash_pay." onBlur=\"calc_bal_cash('$overdue', '$cash_pay_next', '$chq_pay', '$inv_balance', '$cash_pay', event);\" onKeyPress=\"keyset('$cash_pay_next', event);\" size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$inv_balance." id=".$inv_balance." disabled size=\"10\"/></td></tr>";
									 $i=$i+1;
				 }
				 
				 
				 $overdue="overdue".$i;
						
						$chq_pay="chq_pay".$i;
						$chq_pay_next="chq_pay".$j;
						
						$chq_balance="chq_balance".$i;
						$chq_balance_next="chq_balance".$j;
						
						$cash_pay="cash_pay".$i;
						$cash_pay_next="cash_pay".$j;
						
						$inv_balance="inv_balance".$i;
						$overdueamt=$row["GRAND_TOT"]-$row["TOTPAY"];
						$invno="invno".$i;
				 $ResponseXML .= "<tr><td><td></td>
									 <td></td><div id=".$invno."></div></td>
									 <td></td>
									 <td></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$overdue." id=".$overdue." value=".$overdueamt." size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$chq_pay." id=".$chq_pay." onBlur=\"calc_bal('$overdue', '$chq_pay', '$inv_balance', '$chq_balance', '$chq_balance_next', '$cash_pay', '$i', event);\"  onKeyPress=\"keyset('$chq_pay_next', event);\"   size=\"10\"/></td>									
									 <td><input type=\"text\"  class=\"txtbox\" name=".$chq_balance." id=".$chq_balance." onKeyPress=\"keysetvalue('$chq_balance','$chq_balance_next', '$chq_pay', event);\" size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$cash_pay." id=".$cash_pay." onKeyPress=\"calc_bal_cash('$overdue', '$cash_pay_next', '$chq_pay', '$inv_balance', '$cash_pay', event);\" size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$inv_balance." id=".$inv_balance." disabled size=\"10\"/></td></tr>";
									 
				 $_SESSION["count"]=$i;
				 $ResponseXML .= "   </table>]]></sales_table_acc>";
				 $ResponseXML .= "<mcount><![CDATA[".$_SESSION["count"]."]]></mcount>";
				 $ResponseXML .= "</salesdetails>";	
				 echo $ResponseXML;
				 
				

}
*/

if($_GET["Command"]=="chng_chqno")
{
	$sql="update tmp_cash_chq set chqno='".$_GET["chqno"]."' where tmp_no='".$_SESSION["tmp_no_cashrec"]."' and tmp_count=".$_GET["i"];
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
}

if($_GET["Command"]=="chng_chqdate")
{
	$sql="update tmp_cash_chq set chqdate='".$_GET["chqdate"]."' where tmp_no='".$_SESSION["tmp_no_cashrec"]."' and tmp_count=".$_GET["i"];
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
}

if($_GET["Command"]=="chng_bank")
{
	$sql="update tmp_cash_chq set chqbank='".$_GET["bank"]."' where tmp_no='".$_SESSION["tmp_no_cashrec"]."' and tmp_count=".$_GET["i"];
	//echo $sql;
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
}

if($_GET["Command"]=="chng_chqamt")
{
	$sql="update tmp_cash_chq set chqamt='".$_GET["chqamt"]."' where tmp_no='".$_SESSION["tmp_no_cashrec"]."' and tmp_count=".$_GET["i"];
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
	$sql="select sum(chqamt) as totamt from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	$row = mysqli_fetch_array($result);
	echo $row["totamt"];
}

if($_GET["Command"]=="addchq_cash_rec")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		if (date("Y-m-d", strtotime($_GET["chqdate"])) <= date("Y-m-d", strtotime($_GET["invdate"]))) {
			//$chqdate = DateAdd("d", 1, Date)
			$date=$_GET["invdate"];
			$date1=date('Y-m-d', strtotime($date. ' + 1 days'));
		} else {
			$date1=$_GET["chqdate"];
		}
		
		$sql="delete from tmp_cash_chq where chqno='".$_GET["chqno"]."' and tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		
		$sql="select max(tmp_count) as max_num from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
		//echo $sql;
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		if ($row = mysqli_fetch_array($result)){
			if ((is_null($row["max_num"])==false) and ($row["max_num"]!="")){
				$i=$row["max_num"]+1;
			} else {
				$i=1;
			}	
		}
		
		$sql="insert into tmp_cash_chq(recno, chqno, chqdate, chqbank, chqamt, tmp_no, tmp_count) values ('".$_GET["invno"]."', '".$_GET["chqno"]."', '".$date1."', '".$_GET["bank"]."', '".$_GET["chqamt"]."', '".$_SESSION["tmp_no_cashrec"]."', ".$i.")";
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		
			
			$totchq=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				
				$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."' order by tmp_count";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				while ($row = mysqli_fetch_array($result)){
					$chqno="chqno".$row["tmp_count"];
					$chqdate="chqdate".$row["tmp_count"];
					$bank="bank".$row["tmp_count"];
					$chqamt="chqamt".$row["tmp_count"];
					
					$ResponseXML .= "<tr>
					<td><input type=\"text\"  class=\"text_purchase3\" name=\"".$chqno."\" id=\"".$chqno."\" size=\"10\" onblur=\"chng_chqno('".$row["tmp_count"]."');\" value=\"".$row["chqno"]."\"     /></td>
					<td><input type=\"text\"  class=\"text_purchase3\" size=\"10\" id=\"".$chqdate."\" name=\"".$chqdate."\" onblur=\"chng_chqdate('".$row["tmp_count"]."');\" value=\"".$row["chqdate"]."\" /></td>
					<td><input type=\"text\" size=\"15\" name=\"".$bank."\" id=\"".$bank."\" value=\"".$row["chqbank"]."\" class=\"text_purchase3\" onblur=\"chng_bank('".$row["tmp_count"]."');\" /></td>
					<td align=right><input type=\"text\" size=\"15\" name=\"".$chqamt."\" id=\"".$chqamt."\" value=\"".number_format($row["chqamt"], 2, ".", ",")."\" onblur=\"chng_chqamt('".$row["tmp_count"]."');\" class=\"text_purchase3\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['chqno']."  name=".$row['chqno']." onClick=\"del_item('".$row['chqno']."');\"></td></tr>";
					
					
					$totchq=$totchq+$row["chqamt"];
					
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<chqtot><![CDATA[".$totchq."]]></chqtot>";	
				$ResponseXML .= "<chqbal><![CDATA[".$totchq."]]></chqbal>";			
				
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;
				
					
}



if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."' and chqno='".$_GET["chqno"]."'";
			//echo $sql;
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
							
			
			$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."' ";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				while ($row = mysqli_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["chqno"]."</td>
					<td>".$row["chqdate"]."</td>
					<td>".$row["chqbank"]."</td>
					<td align=right>".number_format($row["chqamt"], 2, ".", ",")."</td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['chqno']."  name=".$row['chqno']." onClick=\"del_item('".$row['chqno']."');\"></td></tr>";
					
					
					$totchq=$totchq+$row["chqamt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<chqtot><![CDATA[".$totchq."]]></chqtot>";	
				$ResponseXML .= "<chqbal><![CDATA[".$totchq."]]></chqbal>";			
				
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;	
				
					
				
			
	}
	

if($_GET["Command"]=="utilization")
{	
	require_once("connectioni.php");
	
	
	
	$i=1;
	$a_chq_no=array();
	$a_chq_date=array();
	$a_chq_amt=array();
	$a_chq_bank=array();
	
	$chq_pay="";
	$invno="";
	$delidate="";
	$available_inv_amt=0;
	$available_chq_amt=0;
	
	$sql="delete from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'"; 
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
	$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'"; 
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	while ($row = mysqli_fetch_array($result)){
		
		if ((strtotime($row["chqdate"]) < strtotime($_GET["invdate"])) or (strtotime($row["chqdate"]) == strtotime($_GET["invdate"]))) {
			
			$date = date('Y-m-d',strtotime(($_GET["invdate"]).' +1 days'));
			
			$a_chq_date[$i] = $date;
		} else {
			$a_chq_date[$i]=$row["chqdate"];
		}
		$a_chq_no[$i]=$row["chqno"];
		$a_chq_amt[$i]=$row["chqamt"];
		$a_chq_bank[$i]=$row["chqbank"];
		
		$i=$i+1;
	}	
	
	$mcou=$i;
		
	
	$j=1;
	$chq_pay_8=array();
	
	while ($j < $_GET["mcount"]){
		$chq_pay="chq_pay".$j;
		
		if ($_GET[$chq_pay]!=""){
			$chq_pay_8[$j]=$_GET[$chq_pay];
		} else {
			$chq_pay_8[$j]="";
		}	
		
		$j=$j+1;
	}
	
	

	$invset=0;
	


	$i = 1;
	$K = 1;
	$invpos = 1;
 
while ($mcou>=$i){
   
 	if ($invset == 0) {
 		$j = 1;
 	} else {
 		$j = $invpos;
 	}
    $chqbal = $a_chq_amt[$i];
    $chqval = $a_chq_amt[$i];
 
 	while (($j < $_GET["mcount"]) and ($chqbal > 0)){
 
 		$chq_pay="chq_pay".$j;
		$chq_balance="chq_balance".$j;
		$invno="invno".$j;
		$delidate="delidate".$j;
		$invval="invval".$j;
		$sdate="sdate".$j;
		
    	if ($invset == 0) {
			//echo $chq_pay."/";
			//echo $_GET[$chq_pay];
			
        	$invset = $chq_pay_8[$j];
        	$chq_pay_8[$j] = "";
    	}
        if ($invset > 0) {
            if ($invset <= $chqbal) {
                
				//echo $invset;   
                $chqbal = $chqbal - $invset;
               
			   	if (($_GET[$delidate]=="0000-00-00") or ($_GET[$delidate]=="")){
					$date1 = $_GET[$sdate];
				} else {
					$date1 = $_GET[$delidate];
				}
			   
				
				$date2 = $a_chq_date[$i];
				$diff = abs(strtotime($date2) - strtotime($date1));
				$days = floor($diff / (60*60*24));
			
				$col2=str_replace(",", "", $_GET[$invval]);
				$invset_val=str_replace(",", "", $invset);	
				
   				$sql1="insert into tmp_utilization(recno, invno, invdate, org_invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$date1."', '".$_GET[$sdate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$invset_val.", ".$days.", ".$col2.", 0, '".$_SESSION["tmp_no_cashrec"]."')"; 
			//echo $sql1." 1 /";
				$result =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
				$invset=0;
               
            } else {
                if ($invset > 0) { $invset = $invset - $chqbal; }
               
			   	if (($_GET[$delidate]=="0000-00-00") or ($_GET[$delidate]=="")){
					$date1 = $_GET[$sdate];
				} else {
					$date1 = $_GET[$delidate];
				}
				//$date1 = $_GET[$delidate];
				$date2 = $a_chq_date[$i];
				$diff = abs(strtotime($date2) - strtotime($date1));
				$days = floor($diff / (60*60*24));
				
				$col2=str_replace(",", "", $_GET[$invval]);
				$chqbal_val=str_replace(",", "", $chqbal);	
				
				$sql1="insert into tmp_utilization(recno, invno, invdate, org_invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$date1."', '".$_GET[$sdate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$chqbal_val.", ".$days.", ".$col2.", 0, '".$_SESSION["tmp_no_cashrec"]."')"; 
			//echo $sql1." 2 /";
				$result =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
            
				$chqbal = 0;
            	$invpos = $j;
            }
            $K = $K + 1;
            
            
        }
       // echo "----".$j."----";
		$j = $j + 1;
         
  	}
    $i = $i + 1;
}
$ii = 1;

while ($_GET["mcount"]>$ii){

	$cash_pay="cash_pay".$ii;
	$invno="invno".$ii;
	$delidate="delidate".$ii;
	$invval="invval".$ii;
	
  if ($_GET[$cash_pay] != "") {
     
	
	if ($_GET["paytype"]=="Cash TT"){
		$chqdate=$_GET["dt"];
				
		if (($_GET[$delidate]=="0000-00-00") or ($_GET[$delidate]=="")){
			$date1 = $_GET[$sdate];
		} else {
			$date1 = $_GET[$delidate];
		}
		//$date1 = $_GET[$delidate];
		$date2 = $chqdate;
		$diff = abs(strtotime($date2) - strtotime($date1));
		$days = floor($diff / (60*60*24));
	} else {
		$chqdate=strtotime($_GET["invdate"]);
			
		if (($_GET[$delidate]=="0000-00-00") or ($_GET[$delidate]=="")){
			$date1 = $_GET[$sdate];
		} else {
			$date1 = $_GET[$delidate];
		}		
		//$date1 = $_GET[$delidate];
		$date2 = $_GET["invdate"];
		$diff = abs(strtotime($date2) - strtotime($date1));
		$days = floor($diff / (60*60*24));
	}
				
				
		$col2=str_replace(",", "", $_GET[$invval]);		
		$cash_pay_val=str_replace(",", "", $_GET[$cash_pay]);	
		 	
	$sql1="insert into tmp_utilization(recno, invno, invdate, org_invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$date1."', '".$_GET[$sdate]."', '".$_GET["paytype"]."', '".$_GET["invdate"]."', '".$a_chq_bank[$i]."', ".$cash_pay_val.", ".$days.", ".$col2.", 0, '".$_SESSION["tmp_no_cashrec"]."')"; 
		//	echo $sql1." 3 /";
	$result =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
     $K = $K + 1;
  }
$ii = $ii + 1;
}

		$invno_0=array();
		$invdate_1=array();
		$chqno_2=array();
		$chqdate_3=array();
		$settled_4=array();
		$days_5=array();
	
	
		$r=1;	
		$sql="select * from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'"; 
		//echo $sql;
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
		while ($row = mysqli_fetch_array($result)){
			$id[$r]=$row["id"];	
			$invno_0[$r]=$row["invno"];	
			$invdate_1[$r]=$row["invdate"];	
			$chqno_2[$r]=$row["chqno"];	
			$chqdate_3[$r]=$row["chqdate"];	
			$settled_4[$r]=$row["settled"];	
			$days_5[$r]=$row["days"];	
			$c1_6[$r]=$row["c1"];
			$r=$r+1;
		}
		

$S = 1;
while ($_GET["mcount"]>$S){
$H = 10;
 while ($H != 0){
 
   $invno="invno".$S;
   $cash_pay="cash_pay".$S;
   $inv_balance="inv_balance".$S;
   
  if ($_GET[$invno] == $invno_0[$H]) {
    if ($invno_0[$H+1] == $invno_0[$H]) {
        if (trim($chqno_2[$H]) != "Cash") {
            $c1_6[$H] = $c1_6[$H+1] + $settled_4[$H+1]  - $_GET[$cash_pay];
        } else {
            $c1_6[$H] = $c1_6[$H+1] + $settled_4[$H+1];
        }
		
		$sql11="update tmp_utilization set c1=".$c1_6[$H]." where id=".$id[$H]; 
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql11);
	
    } else {
       if (trim($chqno_2[$H]) != "Cash") {
        $c1_6[$H] = $_GET[$inv_balance] - $_GET[$cash_pay];
       } else {
        $c1_6[$H] = $_GET[$inv_balance];
       }
	   $sql11="update tmp_utilization set c1=".$c1_6[$H]." where id=".$id[$H]; 
	   $result1 =mysqli_query($GLOBALS['dbinv'],$sql11);
    }
 }
 $H = $H - 1;
}
$deutot = $deutot + $_GET[$inv_balance];
$S = $S + 1;
}
	
	
	
	
 


			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<uti_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Invoice No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Invoice Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Settled</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Days</td>
					</tr>";
				
				$sql="select * from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				while ($row = mysqli_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["invno"]."</td>
					<td>".$row["invdate"]."</td>
					<td>".$row["chqno"]."</td>
					<td>".$row["chqdate"]."</td>
					<td align=right>".number_format($row["settled"], 2, ".", ",")."</td>
					<td>".$row["days"]."</td>
					</tr>";
					
				}
						
				$ResponseXML .= "   </table>]]></uti_table>";
							
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;		
	
	
	
}



		if($_GET["Command"]=="new_rec")
		{
			
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
						
		 if ($_SESSION['company']=="THT"){		
			
			if ($_SESSION['dev'] == "0") {
				
				$sql="select INV_RECNO from invpara";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);
			
  				$tmprecno="000000".$row["INV_RECNO"];
				$lenth=strlen($tmprecno);
				
				$recno=trim("CRN/CR/ ").substr($tmprecno, $lenth-5);
				$_SESSION["recno"]=$recno;
				
				$sql="Select INV_RECNO from tmpinvpara";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);
				$_SESSION["tmp_no_cashrec"]="CRN/CR/ ".$row["INV_RECNO"];
				
				$sql="update tmpinvpara set INV_RECNO=INV_RECNO+1";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
 			}

			if ($_SESSION['dev'] == "1") {
  								
				$sql="select INV_RECNO_M from invpara";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);
			
  				$tmprecno="000000".$row["INV_RECNO_M"];
				$lenth=strlen($tmprecno);
				$recno=trim("CRN/ ").substr($tmprecno, $lenth-5);
				$_SESSION["recno"]=$recno;
				
				$sql="Select INV_RECNO_M from tmpinvpara";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);
				$_SESSION["tmp_no_cashrec"]="CRN/".$row["INV_RECNO_M"];
				
				$sql="update tmpinvpara set INV_RECNO_M=INV_RECNO_M+1";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
 
			}

			
			$sql="delete from tmp_inv_data where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="delete from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="delete from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="delete from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
		} else 	 if ($_SESSION['company']=="BEN") {
			
			
				
			$sql="Select STOrec, STOrec_CODE from invpara";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			$row = mysqli_fetch_array($result);
		
			//if ($_SESSION['dev'] == "0") {
				$tmprecno="000000".$row["STOrec"];
				$lenth=strlen($tmprecno);
				
				$recno=$row["STOrec_CODE"]."/".$row["STOrec"]; 
				$_SESSION["recno"]=$recno;
				
				$sql="Select INV_RECNO from tmpinvpara";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);
				$_SESSION["tmp_no_cashrec"]=$row["STOrec_CODE"]."/".$row["INV_RECNO"];
				
				$sql="update tmpinvpara set INV_RECNO=INV_RECNO+1";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				
  		/*	}
			
			if ($_SESSION['dev'] == "1") {
				$tmprecno="000000".$row["INV_RECNO_M"];
				$lenth=strlen($tmprecno);
				$recno=trim("REM/ ").substr($tmprecno, $lenth-8);
				$_SESSION["recno"]=$recno;
				
				$sql="Select INV_RECNO_M from tmpinvpara";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				$row = mysqli_fetch_array($result);
				$_SESSION["tmp_no_cashrec"]="REM/".$row["INV_RECNO_M"];
				
				$sql="update tmpinvpara set INV_RECNO_M=INV_RECNO_M+1";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				
  			}*/

			$sql="delete from tmp_inv_data where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="delete from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			
			$sql="delete from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			$sql="delete from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		
		}
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			$ResponseXML .= "<recno><![CDATA[".$recno."]]></recno>";
			$ResponseXML .= "<cur_date><![CDATA[".date("Y-m-d")."]]></cur_date>";
			
			$ResponseXML .= " </salesdetails>";
			echo $ResponseXML;		
			
		
		}
		


if ($_GET["Command"]=="pass_cus_cash_rec")
{
	include_once("connectioni.php");
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				
		
				$sql = mysqli_query($GLOBALS['dbinv'],"Select * from vendor where CODE='".$_GET['custno']."'") or die(mysqli_error());
				if($row = mysqli_fetch_array($sql)){
					$ResponseXML .= "<code><![CDATA[".$row['CODE']."]]></code>";
					$ResponseXML .= "<name><![CDATA[".$row['NAME']."]]></name>";
					$ResponseXML .= "<address><![CDATA[".$row['ADD1']." ".$row['ADD2']."]]></address>";
				}
				
					$ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=1  cellspacing=0>
								<tr><td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Invoice No</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Value</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Paid</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Overdue</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Chq Pay</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Chq Balance</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cash Pay</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Inv Balance</font></td></tr>";
				
				//$sql = mysqli_query($GLOBALS['dbinv'],"Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and DEV='" & rsusercon!dev & "' and CANCELL='0' and SAL_EX='" & Trim(Left(Com_rep, 5)) & "' and Accname <> 'NON STOCK' ORDER BY SDATE") or die(mysqli_error());
			//	echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0' and SAL_EX='".$_GET["refno"]."' and Accname <> 'NON STOCK' ORDER BY SDATE";
				
				$i=1;
			//	echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0'  ORDER BY SDATE";
			
			if ($_GET['refno']==""){
				//echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where  GRAND_TOT > TOTPAY and (GRAND_TOT-TOTPAY)>0.5 and CANCELL='0' ORDER BY SDATE";
				$sql = mysqli_query($GLOBALS['dbinv'],"Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where  GRAND_TOT > TOTPAY and (GRAND_TOT-TOTPAY)>0.5 and Accname='NON STOCK' and CANCELL='0' ORDER BY SDATE") or die(mysqli_error());
			} else {
				//echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and (GRAND_TOT-TOTPAY)>0.5 and CANCELL='0' and  ORDER BY SDATE";
				$sql = mysqli_query($GLOBALS['dbinv'],"Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where Accname='NON STOCK' and GRAND_TOT > TOTPAY and (GRAND_TOT-TOTPAY)>0.5 and CANCELL='0'  ORDER BY SDATE") or die(mysqli_error());
				
			}	
				while($row = mysqli_fetch_array($sql)){

					 $sdate="sdate".$i;
					  $delidate="delidate".$i;
					  
					  $invval="invval".$i;
					
						
						//if (is_null($row["deli_date"]==false)){
						if (is_null($row["deli_date"]==false) or ($row["deli_date"]!="0000-00-00")){
						
							
							//$ResponseXML .= "<tr><td><div id=".$delidate.">".$row["REQ_DATE"]."</div></td>";
							$ResponseXML .= "<tr><td><div id=".$delidate.">".$row["deli_date"]."</div></td>";
						} else {
							$ResponseXML .= "<tr><td><div id=".$delidate.">".$row["SDATE"]."</div></td>";
						}	
						
						$ResponseXML .= "<td><div id=".$sdate.">".$row["SDATE"]."</div></td>";
						
						$j=$i+1;
						
						$overdue="overdue".$i;
						
						$chq_pay="chq_pay".$i;
						$chq_pay_next="chq_pay".$j;
						
						$chq_balance="chq_balance".$i;
						$chq_balance_next="chq_balance".$j;
						
						$cash_pay="cash_pay".$i;
						$cash_pay_next="cash_pay".$j;
						
						$inv_balance="inv_balance".$i;
						$overdueamt=$row["GRAND_TOT"]-$row["TOTPAY"];
						//number_format($row["GRAND_TOT"]-$row["TOTPAY"], 2, ".")
						
						$invno="invno".$i;
						
					$ResponseXML .= "<td><div id=".$invno.">".$row["REF_NO"]."</div></td>
									 <td><div id=".$invval."  align=right>".number_format($row["GRAND_TOT"], 2, ".", ",")."</div></td>
									 <td align=right>".number_format($row["TOTPAY"], 2, ".", ",")."</td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$overdue." id=".$overdue." value=".number_format($overdueamt, 2, ".", "")." size=\"10\" disabled  align=right/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$chq_pay." id=".$chq_pay." onBlur=\"calc_bal('$overdue', '$chq_pay', '$inv_balance', '$chq_balance', '$chq_balance_next', '$cash_pay', '$i', event);\"  onKeyPress=\"keyset('$chq_pay_next', event);\"   size=\"10\"/></td>									
									 <td><input type=\"text\"  class=\"txtbox\" name=".$chq_balance." disabled id=".$chq_balance." onKeyPress=\"keysetvalue('$chq_balance','$chq_balance_next', '$chq_pay', event);\" size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$cash_pay." id=".$cash_pay." onBlur=\"calc_bal_cash('$overdue', '$cash_pay_next', '$chq_pay', '$inv_balance', '$cash_pay', event);\" onKeyPress=\"keyset('$cash_pay_next', event);\" size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$inv_balance." id=".$inv_balance." disabled size=\"10\"/></td></tr>";
									 $i=$i+1;
				 }
				 
				 
				 $overdue="overdue".$i;
						
						$chq_pay="chq_pay".$i;
						$chq_pay_next="chq_pay".$j;
						
						$chq_balance="chq_balance".$i;
						$chq_balance_next="chq_balance".$j;
						
						$cash_pay="cash_pay".$i;
						$cash_pay_next="cash_pay".$j;
						
						$inv_balance="inv_balance".$i;
						$overdueamt=$row["GRAND_TOT"]-$row["TOTPAY"];
						$invno="invno".$i;
				 $ResponseXML .= "<tr><td><td></td>
									 <td></td><div id=".$invno."></div></td>
									 <td></td>
									 <td></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$overdue." id=".$overdue." value=".$overdueamt." size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$chq_pay." id=".$chq_pay." onBlur=\"calc_bal('$overdue', '$chq_pay', '$inv_balance', '$chq_balance', '$chq_balance_next', '$cash_pay', '$i', event);\"  onKeyPress=\"keyset('$chq_pay_next', event);\"   size=\"10\"/></td>									
									 <td><input type=\"text\"  class=\"txtbox\" name=".$chq_balance." id=".$chq_balance." onKeyPress=\"keysetvalue('$chq_balance','$chq_balance_next', '$chq_pay', event);\" size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$cash_pay." id=".$cash_pay." onKeyPress=\"calc_bal_cash('$overdue', '$cash_pay_next', '$chq_pay', '$inv_balance', '$cash_pay', event);\" size=\"10\"/></td>
									 <td><input type=\"text\"  class=\"txtbox\" name=".$inv_balance." id=".$inv_balance." disabled size=\"10\"/></td></tr>";
									 
				 $_SESSION["count"]=$i;
				 $ResponseXML .= "   </table>]]></sales_table_acc>";
				 $ResponseXML .= "<mcount><![CDATA[".$_SESSION["count"]."]]></mcount>";
				 $ResponseXML .= "</salesdetails>";	
				 echo $ResponseXML;

}

		
if($_GET["Command"]=="save_crec")
{
	if ($_SESSION["CURRENT_USER"]==""){
		exit("no");
	}
			
	include('connectioni.php');
	
		$sqltmp="select * from invpara";
		$resulttmp=mysqli_query($GLOBALS['dbinv'],$sqltmp);
		$rowtmp = mysqli_fetch_array($resulttmp);
	
		if ($rowtmp["form_loc"]=="1"){
  			exit("no");
  		}	
		
	$sql_status=0;
			
	mysqli_query($GLOBALS['dbinv'],"SET AUTOCOMMIT=0");
	mysqli_query($GLOBALS['dbinv'],"START TRANSACTION");	
		
		if ($_SESSION['company']=="THT"){		
			
			if ($_SESSION['dev'] == "0") {
				
				$sql="select INV_RECNO from invpara";
				$result=mysqli_query($GLOBALS['dbinv'],$sql);
				$row = mysqli_fetch_array($result);
			
  				$tmprecno="000000".$row["INV_RECNO"];
				$lenth=strlen($tmprecno);
				$recno=trim("CRN/CR/ ").substr($tmprecno, $lenth-5);
				$_SESSION["recno"]=$recno;
				
				
 			}

			if ($_SESSION['dev'] == "1") {
  								
				$sql="select INV_RECNO_M from invpara";
				$result=mysqli_query($GLOBALS['dbinv'],$sql);
				$row = mysqli_fetch_array($result);
			
  				$tmprecno="000000".$row["INV_RECNO_M"];
				$lenth=strlen($tmprecno);
				$recno=trim("CRN/ ").substr($tmprecno, $lenth-5);
				$_SESSION["recno"]=$recno;
				
				
 
			}

			
			
		} else 	 if ($_SESSION['company']=="BEN") {
			
			$sql="select INV_RECNO,INV_RECNO_M from invpara ";
			$result=mysqli_query($GLOBALS['dbinv'],$sql);
			$row = mysqli_fetch_array($result);
		
			//if ($_SESSION['dev'] == "0") {
				
				
						
			$sql="Select STOrec, STOrec_CODE from invpara";
			$result=mysqli_query($GLOBALS['dbinv'],$sql);
			$row = mysqli_fetch_array($result);
		
			//if ($_SESSION['dev'] == "0") {
				$tmprecno="000000".$row["STOrec"];
				$lenth=strlen($tmprecno);
				
				$recno=$row["STOrec_CODE"]."/".$row["STOrec"]; 
				
				$_SESSION["recno"]=$recno;
				
				
				
  			/*}
			
			if ($_SESSION['dev'] == "1") {
				$tmprecno="000000".$row["INV_RECNO_M"];
				$lenth=strlen($tmprecno);
				$recno=trim("REM/ ").substr($tmprecno, $lenth-8);
				$_SESSION["recno"]=$recno;
				
				
				
  			}*/

			
		
		}


	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
			
	$sql="select * from s_crec where CA_REFNO='".$recno."'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql);
	if ($row = mysqli_fetch_array($result)){
		$ResponseXML .= "<msg_dup><![CDATA[Reciept No Already Saved]]></msg_dup>";
		exit("Reciept No Already Saved");
	} else {
		$ResponseXML .= "<msg_dup><![CDATA[0]]></msg_dup>";
	}

//	Call accsave====================================================================================???????????????
	
	
//=============================================================================
if ($recno !=''){
	if (is_numeric($_GET["cashtot"])==true){
		$cashtot=$_GET["cashtot"];
	} else {
		$cashtot=0;
	}
	
	if (is_numeric($_GET["txtpaytot"])==true){
		$txtpaytot=$_GET["txtpaytot"];
	} else {
		$txtpaytot=0;
	}
	
	if (is_numeric($_GET["txtoverpay"])==true){
		$txtoverpay=$_GET["txtoverpay"];
	} else {
		$txtoverpay=0;
	}
	
	$sql="insert into s_crec(CA_REFNO, CA_DATE, CA_CODE, CA_CASSH, CA_AMOUNT, overpay, FLAG, pay_type, CA_SALESEX, CANCELL, tmp_no, DEPARTMENT, cus_ref, AC_REFNO, TTDATE, DEV) values
	  ('".$recno."', '".$_GET["invdate"]."', '".$_GET["cuscode"]."', ".$cashtot.", ".$txtpaytot.", ".$txtoverpay.", 'REC', '".$_GET["paytype"]."', '".$_GET["salesrep"]."', '0', '".$_SESSION["tmp_no_cashrec"]."', 'S', '0', '".$_GET["ca_refno"]."', '".$_GET["dt"]."', '1' )";
	$result=mysqli_query($GLOBALS['dbinv'],$sql);
	if ($result!=1){ $sql_status=1; }	
	
	$sql="select * from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql);
	while ($row = mysqli_fetch_array($result)){
		if ($row["chqno"]=="Cash"){
			$ST_flag="CAS";
			$ST_CHDATE=$_GET["invdate"];
		} else if ($row["chqno"]=="Cash TT"){
			$ST_flag="Cash TT";
			$ST_CHDATE=$_GET["dt"];	
		} else if ($row["chqno"]=="J/Entry"){
			$ST_flag="J/Entry";
			$ST_CHDATE=$_GET["invdate"];		
		} else {
			$ST_flag="CHK";
			$ST_CHDATE=$row["chqdate"];
		}
		
		if (is_numeric($row["settled"])==true){
			$settled=$row["settled"];
		} else {
			$settled=0;
		}
		$sql1="insert into s_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_CHNO, st_chdate, ST_FLAG, st_days, ap_days, st_chbank, cus_code, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department) values
	  ('".$recno."', '".$_GET["invdate"]."', '".$row["invno"]."', ".$settled.", '".$row["chqno"]."', '".$ST_CHDATE."', '".$ST_flag."', '".$row["days"]."', '".$row["days"]."', '".$row["chbank"]."', '".$_GET["cuscode"]."', '1', 0, 0, 0, '0', 'S')";
	 	$result1=mysqli_query($GLOBALS['dbinv'],$sql1);
		if ($result1!=1){ $sql_status=1; }	
	  	
	}
	
	$i=1;
	while ($_GET[mcount]>=$i){
		$chq_pay="chq_pay".$i;
		$cash_pay="cash_pay".$i;
		$invno="invno".$i;
		$cash = 0;
   		$chk = 0;
   		$tot = 0;
		
		
		if ((is_numeric($_GET[$chq_pay])==true and $_GET[$chq_pay]!=0) or (is_numeric($_GET[$cash_pay])==true and $_GET[$cash_pay]!=0)){
			
			if (is_numeric($_GET[$cash_pay])==true){
				$cash = $_GET[$cash_pay];
			} else {
				$cash = 0;
			}
			if (is_numeric($_GET[$chq_pay])==true){
				$chk = $_GET[$chq_pay];
			} else {
				$chk = 0;
			}
			
   			
   			$tot = $cash+$chk;
			
			$sql="select brand from s_salma where REF_NO='".$_GET[$invno]."'";
			$result=mysqli_query($GLOBALS['dbinv'],$sql);
			if ($row = mysqli_fetch_array($result)){
				$sql1="select class from brand_mas where barnd_name='".$row["brand"]."'";
				$result1=mysqli_query($GLOBALS['dbinv'],$sql1);
				if ($row1 = mysqli_fetch_array($result1)){
					$sql2="update br_trn set credit=credit - ".$tot." where cus_code = '".$_GET["cuscode"]."' and Class = '".$row1["class"]."'";
					$result2=mysqli_query($GLOBALS['dbinv'],$sql2);
					
				}
			}
			
		//	$sql2="update vendor set CUR_BAL=CUR_BAL - ".$tot." where CODE = '".$_GET["cuscode"]."'";
		//	$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
			
		//	$sql2="update br_trn set credit=credit - ".$tot." where cus_code = '".$_GET["cuscode"]."' and Rep='".$_GET["salesrep"]."'";
		//	$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
			
			$sql2="update s_salma set TOTPAY=TOTPAY + ".$tot." where REF_NO = '".$_GET[$invno]."'";
			$result2=mysqli_query($GLOBALS['dbinv'],$sql2);
			if ($result2!=1){ $sql_status=1; }	
			
			
			$sql2="update s_salma set CASH=CASH + ".$cash." where REF_NO = '".$_GET[$invno]."'";
			$result2=mysqli_query($GLOBALS['dbinv'],$sql2);
			if ($result2!=1){ $sql_status=1; }
			
		}
		$i=$i+1;
	}

	
	$chqno="";

	$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql);
	while ($row = mysqli_fetch_array($result)){
		$sql1="select * from vendor where CODE='".$_GET["cuscode"]."'";
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1);
		$row1 = mysqli_fetch_array($result1);
		
		if (is_numeric($row["chqamt"])==true){
			$chqamt = $row["chqamt"];
		} else {
			$chqamt = 0;
		}
			
		$sql2="insert into s_invcheq(refno, Sdate, cus_code, CUS_NAME, cheque_no, che_date, bank, che_amount, sal_ex, trn_type, ex_flag, ch_owner, noof, ret_refno, ch_count_ret, department) values
	  ('".$recno."', '".$_GET["invdate"]."', '".$_GET["cuscode"]."', '".$row1["NAME"]."', '".$row["chqno"]."', '".$row["chqdate"]."', '".$row["chqbank"]."',  ".$chqamt.", '".$_GET["salesrep"]."', 'REC', 'N', '".$_GET["chqcollect"]."', 0, '1', '0', 'S')";
	  	$result2=mysqli_query($GLOBALS['dbinv'],$sql2);
		if ($result2!=1){ $sql_status=1; }
		
		$chqno=$chqno." ".$row["chqno"]."-".$row["chqamt"];
	}
	
	if (is_numeric($_GET["chqtot"])==true){
		$chqtot = $_GET["chqtot"];
	} else {
		$chqtot = 0;
	}
	
	if (is_numeric($_GET["cashtot"])==true){
		$cashtot = $_GET["cashtot"];
	} else {
		$cashtot = 0;
	}
	
	$cash_chq_tot=$chqtot+$cashtot;
	$sql="insert into s_led(REF_NO, C_CODE, SDATE, FLAG, AMOUNT) values
	  ('".$recno."', '".$_GET["cuscode"]."', '".$_GET["invdate"]."', 'REC', ".$cash_chq_tot.")";
	$result=mysqli_query($GLOBALS['dbinv'],$sql);
	if ($result!=1){ $sql_status=1; }
	
	if ($_GET["txtoverpay"]>0){
		$sql="insert into c_bal(REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, SAL_EX) values
	  ('".$recno."', '".$_GET["invdate"]."', 'REC', '".$_GET["cuscode"]."',  ".$_GET["txtoverpay"].", ".$_GET["txtoverpay"].", '".$_GET["salesrep"]."')";
		$result=mysqli_query($GLOBALS['dbinv'],$sql);
	 	if ($result!=1){ $sql_status=1; }
		
	}
	//if ($_SESSION['dev']=="0"){
		$sql2="update invpara set STOrec=STOrec + 1";
		$result2=mysqli_query($GLOBALS['dbinv'],$sql2);
		if ($result2!=1){ $sql_status=1; }
	//}
	
	//if ($_SESSION['dev']=="1"){
//		$sql2="update invpara set INV_RECNO_M=INV_RECNO_M + 1";
	//	$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
	//} 	
	
	//////////////////////////////		Account System////////////////////
	
	//include_once("connectioni.php");
	
  if (($_GET["paytype"]=="J/Entry") or ($_GET["paytype"]=="Cash TT") ){	
	
	$mHead="CASH TT RECEIVED FROM ".$_GET["cuscode"]." ".$_GET["cusname"]." TO SETTLE RET.CHE.NO.- ".$chqno;
	
	$sql_rst="delete from bankdepmas where refno='" . trim($recno) . "'";
	$result_rst=mysqli_query($GLOBALS['dbinv'],$sql_rst, $dbacc);
	if ($result_rst!=1){ $sql_status=1; }
	
	$sql_rst="Insert into bankdepmas (refno, bdate, heading, code, name, amount, cash, comcode, cancel, type, tmp_no) Values ('" . trim($recno) . "', '" . $_GET["invdate"] . "', '" . $mHead . "', '" . $_GET["accno"] . "', '" . $_GET["acc_name"] . "', " . $txtpaytot . ", 0,'" . $_SESSION['company'] . "', '0', 'D', '".trim($recno)."')";
	//echo $sql_rst;
	$result_rst=mysqli_query($GLOBALS['dbinv'],$sql_rst, $dbacc);
	if ($result_rst!=1){ $sql_status=1; }
		
	
	
	$l_lmem = "Cash/Cheque recieved from " . trim($_GET["cusname"]);
	$l_lmem = $mHead;
	
	$sql="delete from  ledger where l_refno='".trim($recno)."'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
	if ($result!=1){ $sql_status=1; }
	
	$sql="insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem, l_flag2, l_flag3, l_yearfl, comcode, chno, recdate, l_year) values ('".trim($recno)."', '".$_GET["invdate"]."', '". trim($_GET["accno2"])."', ".$txtpaytot.", 'REC', 'CRE', '".$l_lmem."', '0', 'R', 0, '".$_SESSION['company']."', '', '0', ".date("Y").")";
	//echo $sql;
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
	if ($result!=1){ $sql_status=1; }
	
	
	$sql="insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem, l_flag2, l_flag3, l_yearfl, comcode, chno, recdate, l_year) values ('".trim($recno)."', '".$_GET["invdate"]."', '". trim($_GET["accno"])."', ".$txtpaytot.", 'REC', 'DEB', '".$l_lmem."', '1', 'R', 0, '".$_SESSION['company']."', '', '0', ".date("Y").")";
	//echo $sql;
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
	if ($result!=1){ $sql_status=1; }
	
	
	$sql="delete from bankdeptrn where refno='" . trim($recno) . "'";
	 $result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
	 if ($result!=1){ $sql_status=1; }
	 
	 $sql="Insert into bankdeptrn(refno, bdate, code, amount, flag, nara, comcode, tmp_no) Values ('" . trim($recno) . "', '" . $_GET["invdate"] . "', '" . $_GET["accno2"] . "', " . $_GET["txtpaytot"] . ", 'CRE', '" . trim($l_lmem) . "' ,'" . $_SESSION['company'] . "', '".$_GET["recno"]."')";
	 $result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
	 if ($result!=1){ $sql_status=1; }
	 
	$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql);
	while ($row = mysqli_fetch_array($result)){
		
		if (is_numeric($row["chqamt"])==true){
			$chqamt = $row["chqamt"];
		} else {
			$chqamt = 0;
		}
		
		$sql2="delete from bankdeptrn where refno='" . trim($recno) . "'";
		$result2=mysqli_query($GLOBALS['dbinv'],$sql2, $dbacc);
		if ($result2!=1){ $sql_status=1; }
		
		$sql2="Insert into bankdeptrn(refno, bdate, code, amount, flag, nara, comcode, tmp_no) Values ('" . trim($recno) . "', '" . $_GET["invdate"] . "', '" . trim($_GET["accno"]) . "', " . $chqamt . ", 'DEB', '" . trim($l_lmem) . ", '" . $_SESSION['company'] . "', '".trim($_GET["recno"])."' )";
		$result2=mysqli_query($GLOBALS['dbinv'],$sql2, $dbacc);
		if ($result2!=1){ $sql_status=1; }
		
		
		$sql1="delete from bankdepche where refno='" . trim($recno) . "'";
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $dbacc);      
		if ($result1!=1){ $sql_status=1; }
		
		$sql1="Insert into bankdepche(refno, cheno, bdate, ven_code, ven_name, bank, amount ,comcode, id  ) Values ('" . trim($recno) . "', '" . $row["chqno"] . "', '" . $_GET["invdate"] . "', '" . $l_lmem  . "', '" . $l_lmem  . "', '" . $row["chqbank"] . "', " . $chqamt . ",'" . $_SESSION['company'] . "', 0 )";
					//echo $sql;
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $dbacc);   
		if ($result1!=1){ $sql_status=1; }          
		
	}
  }	
  //////////////////////////////////
	
	if ($sql_status==0){
		mysqli_query($GLOBALS['dbinv'],"COMMIT");
		$ResponseXML .= "<recno><![CDATA[".$recno."]]></recno>";
		$ResponseXML .= "<msg_incom><![CDATA[0]]></msg_incom>";
	}	else {
		mysqli_query($GLOBALS['dbinv'],"ROLLBACK");
		$ResponseXML .= "<msg_incom><![CDATA[Incomplete Detail]]></msg_incom>";
	}
		
	
} else {	
	$ResponseXML .= "<msg_incom><![CDATA[Incomplete Detail]]></msg_incom>";
	
}

	$ResponseXML .= "</salesdetails>";
	

			
	//$sql="delete from tmp_cash_chq where recno='".$recno."'";
	//$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
	echo $ResponseXML;


}


if($_GET["Command"]=="check_print")
{
	$sql="delete from tmprct where recno='".$_GET["recno"]."'";
	//echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
	$i=1;
	//echo $_GET["mcount"];
	while ($_GET["mcount"]>=$i){
		$sdate="sdate".$i;
		$invno="invno".$i;
		$invval="invval".$i;
		$overdue="overdue".$i;
		$chq_pay="chq_pay".$i;
		$cash_pay="cash_pay".$i;
		$inv_balance="inv_balance".$i;
		
		$invval_val=str_replace(",", "", $_GET[$invval]); 
		$overdue_val=str_replace(",", "", $_GET[$overdue]); 
		$chq_pay_val=str_replace(",", "", $_GET[$chq_pay]); 
		$cash_pay_val=str_replace(",", "", $_GET[$cash_pay]); 
		$inv_balance_val=str_replace(",", "", $_GET[$inv_balance]); 
		
		if ((($_GET[$chq_pay_val]!="") and ($_GET[$chq_pay_val]!="0")) or (($_GET[$cash_pay_val]!="") and ($_GET[$cash_pay_val]!="0"))){
		
			$paid=$_GET[$chq_pay_val]+$_GET[$cash_pay_val];
			
			$sql="insert into  tmprct (SDATE, REFNO, AMOUNT, balance, paid, OVERDUE, flag) value ('".$_GET[$sdate]."', '".$_GET[$invno]."', '".$_GET[$invval_val]."', '".$_GET[$overdue_val]."', '".$paid."', 'INV')";
			//echo $sql;
			$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		
		}
		
		$i=$i+1;
	}
	
	$sql1="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
	while ($row1 = mysqli_fetch_array($result1)){
		$sql="insert into  tmprct (SDATE, REFNO, AMOUNT, balance, CH_VAL, flag) value ('".$row1["chqdate"]."', '".$row1["chqno"]."', '".$row1["chqbank"]."', '".$row1["chqamt"]."', '".$row1["chqamt"]."', 'CHK')";
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	}
	
		
		

}

if ($_GET["Command"]=="search_rec"){
	
	include_once("connectioni.php");
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
							   <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
							    <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
                             
   							</tr>";
                           
							if ($_GET["mfield"]=="recno"){
						   		$letters = $_GET['recno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_crec where  CA_REFNO like  '$letters%' limit 50") or die(mysqli_error());
							} else if ($_GET["mstatus"]=="recdate"){
								$letters = $_GET['recdate'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_crec where CA_DATE like  '$letters%' limit 50") or die(mysqli_error());
							}else if ($_GET["mstatus"]=="recamt"){
								$letters = $_GET['recamt'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_crec where CA_AMOUNT like  '$letters%' limit 50") or die(mysqli_error());
							} else {
								$letters = $_GET['recno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from s_crec where CA_REFNO like  '$letters%' limit 50") or die(mysqli_error());
							}
							
													
						
							while($row = mysqli_fetch_array($sql)){
								$REF_NO = $row['CA_REFNO'];
								$stname = $_GET["mstatus"];
							$ResponseXML .= "<tr>
                           	  <td onclick=\"recno('$REF_NO');\">".$row['CA_REFNO']."</a></td>
                              <td onclick=\"recno('$REF_NO');\">".$row['CA_DATE']."</a></td>
                              <td onclick=\"recno('$REF_NO');\">".$row['CA_AMOUNT']."</a></td>";
							  
							  $sql1="SELECT * FROM vendor where CODE = '".$row["CA_CODE"]."'";
							  $result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
							  $row1 = mysqli_fetch_array($result1);
                              $ResponseXML .= "<td onclick=\"recno('$REF_NO');\">".$row1['NAME']."</a></td>                          	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}


if ($_GET["Command"]=="search_bank"){
	
	include_once("connectioni.php");
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Bank Code</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Banl Name</font></td>
							  
                             
   							</tr>";
                           
						   
						   if ($_GET["mstatus"]=="cash_rec"){
						    if ($_GET["mfield"]=="bcode"){
						   		$letters = $_GET['bcode'];
						   		$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from bankmas where  bcode like  '$letters%'") or die(mysqli_error());
							 } else if ($_GET["mfield"]=="bank"){
							 	$letters = $_GET['bank'];
						   		$sql = mysqli_query($GLOBALS['dbinv'],"SELECT * from bankmas where  bname like  '$letters%'") or die(mysqli_error());
							 }	
						   } 
						   
						  						
						
							while($row = mysqli_fetch_array($sql)){
								
							$ResponseXML .= "<tr>
                           	    <td onclick=\"selbank('".$row["bcode"]."', '".$stname."');\">".$row["bcode"]."</a></td>
                              <td onclick=\"selbank('".$row["bcode"]."', '".$stname."');\">".$row["bname"]."</a></td>
				
							                           	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}

if ($_GET["Command"]=="pass_selbank"){
	//header('Content-Type: text/xml'); 
	/*echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	$sql="select * from bankmas where bcode='".$_GET["bcode"]."'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	if ($row = mysqli_fetch_array($result)){
		$ResponseXML .= "<bname><![CDATA[".$row["bname"]."]]></bname>";
	}
		
	
				$ResponseXML .= "</salesdetails>";

				echo $ResponseXML;
}
	

if ($_GET["Command"]=="pass_recno"){
	//header('Content-Type: text/xml'); 
	/*echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	$sql="select * from s_crec where CA_REFNO='".$_GET["recno"]."'";
	//echo $sql;
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	if ($row = mysqli_fetch_array($result)){
		$ResponseXML .= "<CA_REFNO><![CDATA[".$row["CA_REFNO"]."]]></CA_REFNO>";
		$ResponseXML .= "<CA_DATE><![CDATA[".$row["CA_DATE"]."]]></CA_DATE>";
		$ResponseXML .= "<CA_CODE><![CDATA[".$row["CA_CODE"]."]]></CA_CODE>";
		$_SESSION["tmp_no_cashrec"]=$row["tmp_no"];
		
		$sql1="select * from vendor where CODE='".$row["CA_CODE"]."'";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
		if ($row1 = mysqli_fetch_array($result1)){
			$ResponseXML .= "<cusname><![CDATA[".$row1["NAME"]."]]></cusname>";
		}
		$ResponseXML .= "<CA_CASSH><![CDATA[".$row["CA_CASSH"]."]]></CA_CASSH>";
		$ResponseXML .= "<CA_AMOUNT><![CDATA[".$row["CA_AMOUNT"]."]]></CA_AMOUNT>";
		$ResponseXML .= "<CA_SALESEX><![CDATA[".$row["CA_SALESEX"]."]]></CA_SALESEX>";
		$ResponseXML .= "<pay_type><![CDATA[".$row["pay_type"]."]]></pay_type>";
		$ResponseXML .= "<TTDATE><![CDATA[".$row["TTDATE"]."]]></TTDATE>";
		$ResponseXML .= "<AC_REFNO><![CDATA[".$row["AC_REFNO"]."]]></AC_REFNO>";
		
		$sql1="select * from s_salrep where REPCODE='".$row["CA_SALESEX"]."'";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
		if ($row1 = mysqli_fetch_array($result1)){
			$ResponseXML .= "<repname><![CDATA[".$row1["Name"]."]]></repname>";
		}
	}
	
		
	$sql="select * from s_invcheq where refno='".$_GET["recno"]."'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	if ($row = mysqli_fetch_array($result)){
		$ResponseXML .= "<collectcode><![CDATA[".$row["ch_owner"]."]]></collectcode>";
	} else {
		$ResponseXML .= "<collectcode><![CDATA[]]></collectcode>";
	}
	
	$sql="delete from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
	$sql="delete from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
	$sql="delete from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		
	$sql="select * from s_invcheq where refno='".$_GET["recno"]."'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	while ($row = mysqli_fetch_array($result)){
		$sql1="insert into tmp_cash_chq(recno, chqno, chqdate, chqbank, chqamt, tmp_no) values ('".$row["refno"]."', '".$row["cheque_no"]."', '".$row["che_date"]."', '".$row["bank"]."', ".$row["che_amount"].", '".$_SESSION["tmp_no_cashrec"]."')";
		//echo $sql1;
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
	}		
		
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				while ($row = mysqli_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["chqno"]."</td>
					<td>".$row["chqdate"]."</td>
					<td>".$row["chqbank"]."</td>
					<td align=right>".number_format($row["chqamt"], 2, ".", ",")."</td>
					</tr>";
					$totchq=$totchq+$row["chqamt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";

				$sql="delete from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."' ";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				
				$sql="select * from s_sttr where ST_REFNO='".$_GET["recno"]."' ";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				while ($row = mysqli_fetch_array($result)){
					$sql1="select * from s_salma where REF_NO='".$row["ST_INVONO"]."' ";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
					$row1 = mysqli_fetch_array($result1);
				
					$sql2="insert into tmp_utilization(recno, invno, invdate, org_invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$row["ST_INVONO"]."', '".$row1["SDATE"]."', '".$row1["SDATE"]."', '".$row["ST_CHNO"]."', '".$row["st_chdate"]."', '".$row["st_chbank"]."', ".$row["ST_PAID"].", ".$row["st_days"].", '".$_SESSION["tmp_no_cashrec"]."')"; 
					//echo $sql2;
					$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
			
				}

				$ResponseXML .= "<uti_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Invoice No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Invoice Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Settled</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Days</td>
					</tr>";
				
				$sql="select * from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
				$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
				while ($row = mysqli_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["invno"]."</td>
					<td>".$row["invdate"]."</td>
					<td>".$row["chqno"]."</td>
					<td>".$row["chqdate"]."</td>
					<td align=right>".number_format($row["settled"], 2, ".", ",")."</td>
					<td>".$row["days"]."</td>
					</tr>";
					
				}
						
				$ResponseXML .= "   </table>]]></uti_table>";
				$ResponseXML .= "</salesdetails>";

				echo $ResponseXML;
	}


if ($_GET["Command"]=="delete_rec"){
	$ResponseXML = "";
	
	include('connectioni.php');
	
		$sql_status=0;
			
		mysqli_query($GLOBALS['dbinv'],"SET AUTOCOMMIT=0");
		mysqli_query($GLOBALS['dbinv'],"START TRANSACTION");	
		
	if (date("m")==date("m", strtotime($_GET["invdate"]))){
		$sql="select * from c_bal where REFNO='".$_GET["recno"]."'";
		$result=mysqli_query($GLOBALS['dbinv'],$sql);	
		if ($row = mysqli_fetch_array($result)){
			if ($row["AMOUNT"]==$row["BALANCE"]){
				$sql1="delete from s_crec where CA_REFNO='".$_GET["recno"]."'";
				$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
				if ($result1!=1){ $sql_status=1; }	
								
				$sql1="delete from s_sttr where ST_REFNO='".$_GET["recno"]."'";
				$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
				if ($result1!=1){ $sql_status=1; }	
								
				$sql1="delete from s_led where REF_NO='".$_GET["recno"]."'";
				$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
				if ($result1!=1){ $sql_status=1; }	
				
				$sql1="delete from s_invcheq where refno='".$_GET["recno"]."'";
				$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
				if ($result1!=1){ $sql_status=1; }	
								
				//$sql1="update vendor set CUR_BAL=CUR_BAL+ ".$_GET["txtpaytot"]." where CODE='".$_GET["cuscode"]."'";
				//$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
				//if ($result1!=1){ $sql_status=1; }	
				
				$sql1="delete from c_bal where REFNO='".$_GET["recno"]."'";
				$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
				if ($result1!=1){ $sql_status=1; }	
				
				
				//$sql1="update br_trn set credit=credit- ".$_GET["txtpaytot"]." where cus_code='".$_GET["cuscode"]."' and Rep='".$_GET["salesrep"]."'";
				//$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
				//if ($result1!=1){ $sql_status=1; }	
								
				
				$sql1="select * from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
				$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
				while ($row1 = mysqli_fetch_array($result1)){	
					$sql2="update s_salma set TOTPAY=TOTPAY- ".$row1["settled"]." where REF_NO='".$row1["invno"]."'";
					$result2=mysqli_query($GLOBALS['dbinv'],$sql2);	
					if ($result2!=1){ $sql_status=1; }	
					//$sql2="update s_salma set CANCELL= '1' where recno='".$row1["invno"]."'";
					//$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
					
					if (($row1["chqno"]=="Cash") or ($row1["chqno"]=="Cash TT") or ($row1["chqno"]=="J/Entry")){
						$sql2="update s_salma set CASH=CASH- ".$row1["settled"]." where REF_NO='".$row1["invno"]."'";
						$result2=mysqli_query($GLOBALS['dbinv'],$sql2);	
						if ($result2!=1){ $sql_status=1; }	
					}
				}		
				$sql_l="delete from ledger where l_refno = '".trim($_GET["recno"])."'";
				$result_l=mysqli_query($GLOBALS['dbinv'],$sql_l, $dbacc);
				if ($result_l!=1){ $sql_status=1; }	
		
				$sql_l="delete from bankdeptrn where refno = '".trim($_GET["recno"])."'";
				$result_l=mysqli_query($GLOBALS['dbinv'],$sql_l, $dbacc);
				if ($result_l!=1){ $sql_status=1; }	
		
				$sql_l="delete from bankdepche where refno = '".trim($_GET["recno"])."'";
				$result_l=mysqli_query($GLOBALS['dbinv'],$sql_l, $dbacc);
				if ($result_l!=1){ $sql_status=1; }	
			
				$sql_l="delete from tmp_ret_chq_sett where recno = '".trim($_GET["recno"])."'";
				$result_l=mysqli_query($GLOBALS['dbinv'],$sql_l);
				if ($result_l!=1){ $sql_status=1; }	
			
				if ($sql_status==0){
					mysqli_query($GLOBALS['dbinv'],"COMMIT");
					$ResponseXML = "Reciept Canceled";
		
				}	else {
					mysqli_query($GLOBALS['dbinv'],"ROLLBACK");
					$ResponseXML = "Error has occured. Can't Cancel";
				}
			} else {
				$ResponseXML .= "Sorry over payment utilized.... Cant Cancel";
			}
		} else {
			$sql1="delete from s_crec where CA_REFNO='".$_GET["recno"]."'";
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
			if ($result1!=1){ $sql_status=1; }	
							
			$sql1="delete from s_sttr where ST_REFNO='".$_GET["recno"]."'";
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
			if ($result1!=1){ $sql_status=1; }	
							
			$sql1="delete from s_led where REF_NO='".$_GET["recno"]."'";
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
			if ($result1!=1){ $sql_status=1; }	
				
			$sql1="delete from s_invcheq where refno='".$_GET["recno"]."'";
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
			if ($result1!=1){ $sql_status=1; }	
				
			//$sql1="update vendor set CUR_BAL=CUR_BAL+ ".$_GET["txtpaytot"]." where CODE='".$_GET["cuscode"]."'";
			//$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
			//if ($result1!=1){ $sql_status=1; }	
				
			$sql1="delete from c_bal where REFNO='".$_GET["recno"]."'";
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
			if ($result1!=1){ $sql_status=1; }	
				
			//$sql1="update br_trn set credit=credit- ".$_GET["txtpaytot"]." where cus_code='".$_GET["cuscode"]."' and Rep='".$_GET["salesrep"]."'";
			//$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
			//if ($result1!=1){ $sql_status=1; }	
			
			$sql1="select * from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
			while ($row1 = mysqli_fetch_array($result1)){	
				$sql2="update s_salma set TOTPAY=TOTPAY- ".$row1["settled"]." where REF_NO='".$row1["invno"]."'";
				$result2=mysqli_query($GLOBALS['dbinv'],$sql2);	
				if ($result2!=1){ $sql_status=1; }	
								
				//$sql2="update s_salma set CANCELL= '1' where recno='".$row1["invno"]."'";
				//$result2 =mysqli_query($GLOBALS['dbinv'],$sql2) ; 
				
				if (($row1["chqno"]=="Cash") or ($row1["chqno"]=="Cash TT") or ($row1["chqno"]=="J/Entry")){		
				
					$sql2="update s_salma set CASH=CASH- ".$row1["settled"]." where REF_NO='".$row1["invno"]."'";
					$result2=mysqli_query($GLOBALS['dbinv'],$sql2);	
					if ($result2!=1){ $sql_status=1; }	
				}
			}		
			
			$sql_l="delete from ledger where l_refno = '".trim($_GET["recno"])."'";
			$result_l=mysqli_query($GLOBALS['dbinv'],$sql_l, $dbacc);
			if ($result_l!=1){ $sql_status=1; }	
		
			$sql_l="delete from bankdeptrn where refno = '".trim($_GET["recno"])."'";
			$result_l=mysqli_query($GLOBALS['dbinv'],$sql_l, $dbacc);
			if ($result_l!=1){ $sql_status=1; }	
		
			$sql_l="delete from bankdepche where refno = '".trim($_GET["recno"])."'";
			$result_l=mysqli_query($GLOBALS['dbinv'],$sql_l, $dbacc);
			if ($result_l!=1){ $sql_status=1; }	
			
			$sql_l="delete from tmp_ret_chq_sett where recno = '".trim($_GET["recno"])."'";
			$result_l=mysqli_query($GLOBALS['dbinv'],$sql_l);
			if ($result_l!=1){ $sql_status=1; }	
			
			if ($sql_status==0){
				mysqli_query($GLOBALS['dbinv'],"COMMIT");
				$ResponseXML = "Reciept Canceled";
		
			}	else {
				mysqli_query($GLOBALS['dbinv'],"ROLLBACK");
				$ResponseXML = "Error has occured. Can't Cancel";
			}
			
			
		}
		
		
		
		
		
	} else {
		$ResponseXML = "Sorry Cant Cancel.... please check reciept date";
	}

	echo $ResponseXML;

}
?>