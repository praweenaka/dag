
<?php 
session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
	 date_default_timezone_set('Asia/Colombo'); 
		
if($_GET["Command"]=="addchq_cash_rec")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		$sql="delete from tmp_cash_chq where recno='".$_GET["invno"]."' and chqno='".$_GET["chqno"]."'";
		$result =$db->RunQuery($sql);
		
		$sql="insert into tmp_cash_chq(recno, chqno, chqdate, chqbank, chqamt, tmp_no) values ('".$_GET["invno"]."', '".$_GET["chqno"]."', '".$_GET["chqdate"]."', '".$_GET["bank"]."', '".$_GET["chqamt"]."', '".$_SESSION["tmp_no_cashrec"]."')";
		$result =$db->RunQuery($sql);
			
			$totchq=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$sql="select * from tmp_cash_chq where recno='".$_GET["invno"]."' ";
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
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



if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_cash_chq where recno='".$_GET["invno"]."' and chqno='".$_GET["chqno"]."'";
			//echo $sql;
		$result =$db->RunQuery($sql);
			
			$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
							
			
			$sql="select * from tmp_cash_chq where recno='".$_GET["invno"]."' ";
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
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
	$i=0;
	$a_chq_no=array();
	$a_chq_date=array();
	$a_chq_amt=array();
	
	$chq_pay="";
	$invno="";
	$delidate="";
	$available_inv_amt=0;
	$available_chq_amt=0;
	
	$sql="delete from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'"; 
	$result =$db->RunQuery($sql);
	
	$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'"; 
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		$a_chq_no[$i]=$row["chqno"];
		$a_chq_date[$i]=$row["chqdate"];
		$a_chq_amt[$i]=$row["chqamt"];
		$a_chq_bank[$i]=$row["chqbank"];
		$i=$i+1;
	}	
	$mcou=$i;
		
	$i=0;
	$j=1;
	
			
	while ($mcou>$i){
		
		$chq_pay="chq_pay".$j;
			$invno="invno".$j;
			$delidate="delidate".$j;
			
		if ($available_inv_amt==0){
			
			$available_inv_amt=$_GET[$chq_pay];
		} 	
		
		if($a_chq_amt[$i] > $available_inv_amt){
			//echo $a_chq_amt[$i];
			//echo $available_inv_amt;
			$available_chq_amt=$a_chq_amt[$i]-$available_inv_amt;
			
			$date1 = $_GET[$delidate];
			$date2 = $a_chq_date[$i];
			$diff = abs(strtotime($date2) - strtotime($date1));
			$days = floor($diff / (60*60*24));
			
			
			$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$available_inv_amt.", ".$days.", '".$_SESSION["tmp_no_cashrec"]."')"; 
			//echo $sql1." 1 /";
			$result =$db->RunQuery($sql1);
			
		} else if($a_chq_amt[$i] < $available_inv_amt){
			
			
			$date1 = $_GET[$delidate];
			$date2 = $a_chq_date[$i];
			$diff = abs(strtotime($date2) - strtotime($date1));
			$days = floor($diff / (60*60*24));
		
			$available_inv_amt=$available_inv_amt-$a_chq_amt[$i];
			$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$a_chq_amt[$i].", ".$days.", '".$_SESSION["tmp_no_cashrec"]."')"; 
			//echo $sql1." 2 /";
			$result =$db->RunQuery($sql1);
		
		} else if($a_chq_amt[$i] = $available_inv_amt){
			
			$available_chq_amt=0;
			
			$date1 = $_GET[$delidate];
			$date2 = $a_chq_date[$i];
			$diff = abs(strtotime($date2) - strtotime($date1));
			$days = floor($diff / (60*60*24));
			
			
			$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$available_inv_amt.", ".$days.", '".$_SESSION["tmp_no_cashrec"]."')"; 
			//echo $sql1." 1 /";
			$result =$db->RunQuery($sql1);
			$available_inv_amt=0;
			
			$j=$j+1;
		}
		
		//echo $available_chq_amt;
		while ($available_chq_amt>0){
			$j=$j+1;
			$chq_pay="chq_pay".$j;
			$invno="invno".$j;
			$delidate="delidate".$j;
			
			if ($available_chq_amt < $_GET[$chq_pay]){
				$available_inv_amt=$_GET[$chq_pay]-$available_chq_amt;
				
				$date1 = $_GET[$delidate];
				$date2 = $a_chq_date[$i];
				$diff = abs(strtotime($date2) - strtotime($date1));
				$days = floor($diff / (60*60*24));
			
				$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$available_chq_amt.", ".$days.", '".$_SESSION["tmp_no_cashrec"]."')";
				//echo $sql1." 3 /"; 
				$result =$db->RunQuery($sql1);
				$available_chq_amt=0;
				
			} else if (($available_chq_amt >= $_GET[$chq_pay]) and ($available_chq_amt >0)){
				
				$available_chq_amt =$available_chq_amt - $_GET[$chq_pay];
				
				$date1 = $_GET[$delidate];
				$date2 = $a_chq_date[$i];
				$diff = abs(strtotime($date2) - strtotime($date1));
				$days = floor($diff / (60*60*24));
			
				$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$_GET[$chq_pay].", ".$days.", '".$_SESSION["tmp_no_cashrec"]."')"; 
				//echo $sql1." 4 /";
				$result =$db->RunQuery($sql1);
			}
		}
		
		
		$i=$i+1;
	}
		
		
		////////// Cash Settlement ////////////////////////////////////////////
	
	$i=1;
	
	while ($_GET["mcount"]>$i){
	
		$cash_pay="cash_pay".$i;
		$invno="invno".$i;
		$delidate="delidate".$i;
		
		
		if ($_GET[$cash_pay]!=""){
			
			if ($_GET["paytype"]=="Cash TT"){
				$chqdate=$_GET["dt"];
				
				$date1 = $_GET[$delidate];
				$date2 = $chqdate;
				$diff = abs(strtotime($date2) - strtotime($date1));
				$days = floor($diff / (60*60*24));
			} else {
				$chqdate=date("Y-m-d");
				
				$date1 = $_GET[$delidate];
				$date2 = date("Y-m-d");
				$diff = abs(strtotime($date2) - strtotime($date1));
				$days = floor($diff / (60*60*24));
			}
				
				 $invval="invval".$i;
				 $col2=str_replace(",", "", $_GET[$invval]);
				 
			
				 
			$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, settled, days, c2, tmp_no) values
			    ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', 'Cash', '".$chqdate."', ".$_GET[$cash_pay].", ".$days.", ".$col2.", '".$_SESSION["tmp_no_cashrec"]."')"; 
				//echo "------".$sql1;
			$result1 =$db->RunQuery($sql1);	
		}
		$i=$i+1;
	}
	
/*
	$i=1;
	while ($_GET["mcount"]>$i){
		$cash_pay="cash_pay".$i;
		$invno="invno".$i;
		$delidate="delidate".$i;
		
		$sql="select * from tmp_utilization where recno='".$_GET["recno"]."' order by invno desc"; 
		//echo $sql;
		$result =$db->RunQuery($sql);	
		while ($row = mysql_fetch_array($result)){
			if ($_GET[$invno]==$row["invno"]){
			
				$row_next = mysql_fetch_assoc($result);
				if ($row_next["invno"]==$row["invno"]){
					
					if (trim($row["chqno"]) != "Cash") {
            			$col1= $row_next["c1"] + $row_next["settled"] - $_GET[$cash_pay];
        			} else {
						$col1= $row_next["c1"] + $row_next["settled"] ;
        			}
					
					$sql1="update tmp_utilization set c1=".$col1." where  recno='".$_GET["recno"]."' and invno='".$_GET[$invno]."'"; 
				//echo $sql1." 4 /";
					$result =$db->RunQuery($sql1);	
					
				} else {
				
					if (trim($row["chqno"]) != "Cash") {
            			$col1= $_GET[$inv_balance] - $_GET[$cash_pay];
        			} else {
						$col1= $_GET[$inv_balance]; 
        			}
					
					$sql1="update tmp_utilization set c1=".$col1." where  recno='".$_GET["recno"]."' and invno='".$_GET[$invno]."'"; 
				//echo $sql1." 4 /";
					$result1 =$db->RunQuery($sql1);	
					
					
				}
			}
		}
		
		
		$i=$i+1;
	}*/


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
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
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
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
						
			
			
			
				
				$sql="select AD_NO from invpara";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["AD_NO"];
				$lenth=strlen($tmprecno);
				$recno=trim("PAY/ ").substr($tmprecno, $lenth-7);
				$_SESSION["adv_recno"]=$recno;
				
				$sql="Select AD_NO from tmpinvpara";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
				$_SESSION["tmp_no_advance"]="PAY/ ".$row["AD_NO"];
				
				$sql="update tmp_inv_data set AD_NO=AD_NO+1";
				$result =$db->RunQuery($sql);
 			
			
			
			
			
			echo $recno;	
			
		}
		
		
if($_GET["Command"]=="save_crec")
{
			
				
				$sql="select AD_NO from invpara";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["AD_NO"];
				$lenth=strlen($tmprecno);
				$recno=trim("PAY/ ").substr($tmprecno, $lenth-7);
				$_SESSION["adv_recno"]=$recno;
				
		
		$sql="insert into s_invcheq (refno,Sdate,cus_code,CUS_NAME,cheque_no,che_date,bank,che_amount) values ('" . trim($_GET["lblReciptNo"]) . "', '" . $_GET["invdate"] . "', '" . trim($_GET["cuscode"]) . "', '" . trim($_GET["cusname"]) . "', '" . $_GET["txtChequeNo"] . "', '" . trim($_GET["chqdate"]) . "', '" . trim($_GET["bank"]) . "', " . $_GET["txtChequeAmount"] . " )";
		$result =$db->RunQuery($sql);
		
		$sql="insert into s_crec (CA_REFNO, CA_DATE, CA_CODE, CA_CASSH, CA_AMOUNT, DEPARTMENT, DEV, FLAG) values('" . trim($_GET["lblReciptNo"]) . "', '" . $_GET["invdate"] . "','" . trim($_GET["cuscode"]) . "'," . $_GET["txtamount"] . "," . $_GET["txtamount"] . ", '1', '" . $_SESSION['dev'] . "', 'PAY')";
		$result =$db->RunQuery($sql);
		
		
		$sql="insert into c_bal (REFNO, SDATE, CUSCODE, AMOUNT, BALANCE, DEP, SAL_EX, trn_type) values ('" . trim($_GET["lblReciptNo"]) . "', '" . $_GET["invdate"] . "','" . trim($_GET["cuscode"]) . "'," . $_GET["txtamount"] . "," . $_GET["txtamount"] . ", '".$_GET["department"]."', '" . $_GET['salesrep'] . "', 'PAY')";
		$result =$db->RunQuery($sql);

		$sql="insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT) values ('" . trim($_GET["lblReciptNo"]) . "','" . $_GET["invdate"] . "','" . trim($_GET["cuscode"]) . "'," . $_GET["txtamount"] . ",'PAY','" . $_GET["department"] . "')";
		$result =$db->RunQuery($sql);


		$sql="UPDATE invpara SET AD_NO=AD_NO+1";
		$result =$db->RunQuery($sql);





	echo "Saved";

}

if ($_GET["Command"]=="search_rec"){
	
	include_once("connection.php");
	
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
								
								$sql = mysql_query("SELECT * from s_crec where  CA_REFNO like  '$letters%' limit 50") or die(mysql_error());
							} else if ($_GET["mstatus"]=="recdate"){
								$letters = $_GET['recdate'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_crec where CA_DATE like  '$letters%' limit 50") or die(mysql_error());
							}else if ($_GET["mstatus"]=="recamt"){
								$letters = $_GET['recamt'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_crec where CA_AMOUNT like  '$letters%' limit 50") or die(mysql_error());
							} else {
								$letters = $_GET['recno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_crec where CA_REFNO like  '$letters%' limit 50") or die(mysql_error());
							}
							
													
						
							while($row = mysql_fetch_array($sql)){
								$REF_NO = $row['CA_REFNO'];
								$stname = $_GET["mstatus"];
							$ResponseXML .= "<tr>
                           	  <td bgcolor=\"#222222\" onclick=\"recno('$REF_NO');\">".$row['CA_REFNO']."</a></td>
                              <td bgcolor=\"#222222\" onclick=\"recno('$REF_NO');\">".$row['CA_DATE']."</a></td>
                              <td bgcolor=\"#222222\" onclick=\"recno('$REF_NO');\">".$row['CA_AMOUNT']."</a></td>";
							  
							  $sql1="SELECT * FROM vendor where CODE = '".$row["CA_CODE"]."'";
							  $result1 =$db->RunQuery($sql1);
							  $row1 = mysql_fetch_array($result1);
                              $ResponseXML .= "<td bgcolor=\"#222222\" onclick=\"recno('$REF_NO');\">".$row1['NAME']."</a></td>                          	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}


if ($_GET["Command"]=="search_bank"){
	
	include_once("connection.php");
	
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
						   		$sql = mysql_query("SELECT * from bankmas where  bcode like  '$letters%'") or die(mysql_error());
							 } else if ($_GET["mfield"]=="bank"){
							 	$letters = $_GET['bank'];
						   		$sql = mysql_query("SELECT * from bankmas where  bname like  '$letters%'") or die(mysql_error());
							 }	
						   } 
						   
						  						
						
							while($row = mysql_fetch_array($sql)){
								
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
	$result =$db->RunQuery($sql);
	if ($row = mysql_fetch_array($result)){
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
	$result =$db->RunQuery($sql);
	if ($row = mysql_fetch_array($result)){
		$ResponseXML .= "<CA_REFNO><![CDATA[".$row["CA_REFNO"]."]]></CA_REFNO>";
		$ResponseXML .= "<CA_DATE><![CDATA[".$row["CA_DATE"]."]]></CA_DATE>";
		$ResponseXML .= "<CA_CODE><![CDATA[".$row["CA_CODE"]."]]></CA_CODE>";
		$_SESSION["tmp_no_cashrec"]=$row["tmp_no"];
		
		$sql1="select * from vendor where CODE='".$row["CA_CODE"]."'";
		$result1 =$db->RunQuery($sql1);
		if ($row1 = mysql_fetch_array($result1)){
			$ResponseXML .= "<cusname><![CDATA[".$row1["NAME"]."]]></cusname>";
		}
		$ResponseXML .= "<CA_CASSH><![CDATA[".$row["CA_CASSH"]."]]></CA_CASSH>";
		$ResponseXML .= "<CA_AMOUNT><![CDATA[".$row["CA_AMOUNT"]."]]></CA_AMOUNT>";
		$ResponseXML .= "<CA_SALESEX><![CDATA[".$row["CA_SALESEX"]."]]></CA_SALESEX>";
		
		$sql1="select * from s_salrep where REPCODE='".$row["CA_SALESEX"]."'";
		$result1 =$db->RunQuery($sql1);
		if ($row1 = mysql_fetch_array($result1)){
			$ResponseXML .= "<repname><![CDATA[".$row1["Name"]."]]></repname>";
		}
	}
	
		
	$sql="select * from s_invcheq where refno='".$_GET["recno"]."'";
	$result =$db->RunQuery($sql);
	if ($row = mysql_fetch_array($result)){
		$ResponseXML .= "<collectcode><![CDATA[".$row["ch_owner"]."]]></collectcode>";
	}
	
	$sql="delete from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result =$db->RunQuery($sql);
		
	$sql="select * from s_invcheq where refno='".$_GET["recno"]."'";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		$sql1="insert into tmp_cash_chq(recno, chqno, chqdate, chqbank, chqamt, tmp_no) values ('".$row["refno"]."', '".$row["cheque_no"]."', '".$row["che_date"]."', '".$row["bank"]."', ".$row["che_amount"].", '".$_SESSION["tmp_no_cashrec"]."')";
		$result1 =$db->RunQuery($sql1);
	}		
		
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$sql="select * from tmp_cash_chq where recno='".$_GET["recno"]."' ";
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["chqno"]."</td>
					<td>".$row["chqdate"]."</td>
					<td>".$row["chqbank"]."</td>
					<td align=right>".number_format($row["chqamt"], 2, ".", ",")."</td>
					</tr>";
					$totchq=$totchq+$row["chqamt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";

				$sql="delete from tmp_utilization where recno='".$_GET["recno"]."' ";
				$result =$db->RunQuery($sql);
				
				$sql="select * from s_sttr where ST_REFNO='".$_GET["recno"]."' ";
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
					$sql1="select * from s_salma where REF_NO='".$row["ST_INVONO"]."' ";
					$result1 =$db->RunQuery($sql1);
					$row1 = mysql_fetch_array($result1);
				
					$sql2="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$row["ST_INVONO"]."', '".$row1["SDATE"]."', '".$row["ST_CHNO"]."', '".$row["st_chdate"]."', '".$row["st_chbank"]."', ".$row["ST_PAID"].", ".$row["st_days"].", '".$_SESSION["tmp_no_cashrec"]."')"; 
					$result2 =$db->RunQuery($sql2);
			
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
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
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
	
	if ($_GET["invdate"]==date("Y-m-d")){
		$sql="select * from c_bal where REFNO='".$_GET["recno"]."'";
		$result =$db->RunQuery($sql);
		if ($row = mysql_fetch_array($result)){
			if ($row["AMOUNT"]==$row["BALANCE"]){
				$sql1="delete from s_crec where CA_REFNO='".$_GET["recno"]."'";
				$result1 =$db->RunQuery($sql1);
				
				$sql1="delete from s_sttr where ST_REFNO='".$_GET["recno"]."'";
				$result1 =$db->RunQuery($sql1);
				
				$sql1="delete from s_led where REF_NO='".$_GET["recno"]."'";
				$result1 =$db->RunQuery($sql1);
				
				$sql1="delete from s_invcheq where refno='".$_GET["recno"]."'";
				$result1 =$db->RunQuery($sql1);
				
				$sql1="update vendor set CUR_BAL=CUR_BAL+ ".$_GET["txtpaytot"]." where CODE='".$_GET["cuscode"]."'";
				$result1 =$db->RunQuery($sql1);
				
				$sql1="delete from c_bal where REFNO='".$_GET["recno"]."'";
				$result1 =$db->RunQuery($sql1);
				
				$sql1="update br_trn set credit=credit- ".$_GET["txtpaytot"]." where cus_code='".$_GET["cuscode"]."'";
				$result1 =$db->RunQuery($sql1);
				
				$sql1="select * from tmp_utilization where recno='".$_GET["recno"]."'";
				$result1 =$db->RunQuery($sql1);
				while ($row1 = mysql_fetch_array($result1)){	
					$sql2="update s_salma set TOTPAY=TOTPAY- ".$row1["settled"]." where recno='".$row1["invno"]."'";
					$result2 =$db->RunQuery($sql2);
					
					if ($row1["chqno"]=="Cash"){
						$sql2="update s_salma set CASH=CASH- ".$row1["settled"]." where REF_NO='".$row1["invno"]."'";
						$result2 =$db->RunQuery($sql2);
					}
				}		
				$ResponseXML = "Reciept Canceled";
			} else {
				$ResponseXML .= "Sorry over payment utilized.... Cant Cancel";
			}
		} else {
			$sql1="delete from s_crec where CA_REFNO='".$_GET["recno"]."'";
			$result1 =$db->RunQuery($sql1);
				
			$sql1="delete from s_sttr where ST_REFNO='".$_GET["recno"]."'";
			$result1 =$db->RunQuery($sql1);
				
			$sql1="delete from s_led where REF_NO='".$_GET["recno"]."'";
			$result1 =$db->RunQuery($sql1);
				
			$sql1="delete from s_invcheq where refno='".$_GET["recno"]."'";
			$result1 =$db->RunQuery($sql1);
				
			$sql1="update vendor set CUR_BAL=CUR_BAL+ ".$_GET["txtpaytot"]." where CODE='".$_GET["cuscode"]."'";
			$result1 =$db->RunQuery($sql1);
				
			$sql1="delete from c_bal where REFNO='".$_GET["recno"]."'";
			$result1 =$db->RunQuery($sql1);
				
			$sql1="update br_trn set credit=credit- ".$_GET["txtpaytot"]." where cus_code='".$_GET["cuscode"]."'";
			$result1 =$db->RunQuery($sql1);
			
			$sql1="select * from tmp_utilization where recno='".$_GET["recno"]."'";
			$result1 =$db->RunQuery($sql1);
			while ($row1 = mysql_fetch_array($result1)){	
				$sql2="update s_salma set TOTPAY=TOTPAY- ".$row1["settled"]." where recno='".$row1["invno"]."'";
				$result2 =$db->RunQuery($sql2);
					
				if ($row1["chqno"]=="Cash"){
					$sql2="update s_salma set CASH=CASH- ".$row1["settled"]." where REF_NO='".$row1["invno"]."'";
					$result2 =$db->RunQuery($sql2);
				}
			}		
			$ResponseXML = "Reciept Canceled";
		}
	} else {
		$ResponseXML = "Sorry Cant Cancel.... please check reciept date";
	}

	echo $ResponseXML;

}
?>