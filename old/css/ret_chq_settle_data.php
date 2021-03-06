<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	 date_default_timezone_set('Asia/Colombo'); 
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	$msset = array(array());
	
		
if($_GET["Command"]=="addchq_cash_rec")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		$sql="delete from tmp_ret_chq_sett where recno='".$_GET["invno"]."' and chqno='".$_GET["chqno"]."'";
		$result =$db->RunQuery($sql);
		
		$sql="insert into tmp_ret_chq_sett(recno, chqno, chqdate, chqbank, chqamt) values ('".$_GET["invno"]."', '".$_GET["chqno"]."', '".$_GET["chqdate"]."', '".$_GET["bank"]."', '".$_GET["chqamt"]."')";
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
				
				$sql="select * from tmp_ret_chq_sett where recno='".$_GET["invno"]."' ";
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
				$ResponseXML .= "<chqtot><![CDATA[".$totchq."]]></chqtot>";	
				$ResponseXML .= "<chqbal><![CDATA[".$totchq."]]></chqbal>";			
				
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;			
}



if($_GET["Command"]=="utilization")
{	
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	$msset = array(array());
	
	if (($_GET["paytype"]!="R/Deposit") and ($_GET["paytype"]!="C/TT")) {
		$sql="select * from tmp_ret_chq_sett where recno='".$_GET["recno"]."'"; 
		$result =$db->RunQuery($sql);
		while ($row = mysql_fetch_array($result)){
			if ($row["chqdate"]!=""){
			
				if ((strtotime("Y-m-d", $row["chqdate"]) < strtotime(date("Y-m-d"))) or (strtotime("Y-m-d", $row["chqdate"])== strtotime(date("Y-m-d")))){
					$d=date('Y-m-d', strtotime("+1 days"));
					$sql1="update tmp_ret_chq_sett set chqdate='".$d."' where recno='".$_GET["recno"]."'"; 
					$result1 =$db->RunQuery($sql1);
				}
			}
		}
	}
	$tmp=array();
	
	$i=1;
	$docno="docno".$i;
	
	while ($_GET[$docno]!=""){
		$docno="docno".$i;
		$setamount="setamount".$i;
			
		if ($_GET[$setamount]!=""){
			$tmp[$i]=$_GET[$setamount];
			
		}
		$i=$i+1;
	}	
	
	$i=1;
	$k=1;
	
	
	$sql="select * from tmp_ret_chq_sett where recno='".$_GET["recno"]."'"; 
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		
		$chqbalval = $row["chqamt"];
    	$chqvalval = $row["chqamt"];
		
		$j=1;
		while (($_GET["mcount"]>$j) and ($chqbalval>0)){
			$invset=$tmp[$j];
			$docno="docno".$j;
					$docdate="docdate".$j;
					$chqval="chqval".$j;
					$chqno="chqno".$j;
					$chqdate="chqdate".$j;
					
			if ($invset>0){
				$msset[$k][0]="";
					$msset[$k][1]="";
					$msset[$k][2]="";
					$msset[$k][3]="";
					$msset[$k][4]="";
					$msset[$k][5]="";
					$msset[$k][6]="";
					$msset[$k][7]="";
					$msset[$k][8]="";
					$msset[$k][9]="";
				if ($invset<=$chqbalval){
					if ($tmp[$j] > 0){ $tmp[$j] = 0; }
					
					$chqbalval=$chqbalval-$invset;
					
					
				
					$diff = abs(strtotime($_GET[$docdate]) - strtotime($row["chqdate"]));
					$days = floor($diff / (60*60*24));
			
					/*$ResponseXML .= "<tr><td>".$_GET[$docno]."</td>
										<td>".$_GET[$docdate]."</td>
										<td>".$row["chqno"]."</td>
										<td>".$row["chqdate"]."</td>
										<td>".$invset."</td>
										<td>".$days."</td>
										<td>0</td>
										<td>".$_GET[$chqval]."</td>
										<td>".$_GET[$chqno]."</td>
										<td>".$_GET[$chqdate]."</td></tr>";*/
										
										$msset[$k][0]=$_GET[$docno];
										$msset[$k][1]=$_GET[$docdate];
										$msset[$k][2]=$row["chqno"];
										$msset[$k][3]=$row["chqdate"];
										$msset[$k][4]=$invset;
										$msset[$k][5]=$days;
										$msset[$k][6]=0;
										$msset[$k][7]=$_GET[$chqval];
										$msset[$k][8]=$_GET[$chqno];
										$msset[$k][9]=$_GET[$chqdate];
										
										$sql1="insert into tmp_utilization_ret_chq_set(recno, docno, docdate, chequeno, chequedate, settled, days, retchbal, retchqval, col1, col2) values ('".$_GET["recno"]."', '".$msset[$k][0]."', '".$msset[$k][1]."', '".$msset[$k][2]."', '".$msset[$k][3]."', '".$msset[$k][4]."', '".$msset[$k][5]."', '".$msset[$k][6]."', '".$msset[$k][7]."', '".$msset[$k][8]."', '".$msset[$k][9]."')"; 
 		$result1 =$db->RunQuery($sql1);
					$tmp[$j]=0;					
				} else {
					if ($tmp[$j] > 0){ $tmp[$j] = $invset-$chqbalval; }
					
					$diff = abs(strtotime($_GET[$docdate]) - strtotime($row["chqdate"]));
					$days = floor($diff / (60*60*24));
					
					/*$ResponseXML .= "<tr><td>".$_GET[$docno]."</td>
										<td>".$_GET[$docdate]."</td>
										<td>".$row["chqno"]."</td>
										<td>".$row["chqdate"]."</td>
										<td>".$chqbalval."</td>
										<td>".$days."</td>";*/
										
										$tmp[$j]=$invset-$chqbalval;
										
				/*	$ResponseXML .= "<td>".$tmp[$j]."</td>
										<td>".$_GET[$chqval]."</td>
										<td>".$_GET[$chqno]."</td>
										<td>".$_GET[$chqdate]."</td></tr>";*/
										
										$msset[$k][0]=$_GET[$docno];
										$msset[$k][1]=$_GET[$docdate];
										$msset[$k][2]=$row["chqno"];
										$msset[$k][3]=$row["chqdate"];
										$msset[$k][4]=$chqbalval;
										$msset[$k][5]=$days;
										$msset[$k][6]=$tmp[$j];
										$msset[$k][7]=$_GET[$chqval];
										$msset[$k][8]=$_GET[$chqno];
										$msset[$k][9]=$_GET[$chqdate];
										$sql1="insert into tmp_utilization_ret_chq_set(recno, docno, docdate, chequeno, chequedate, settled, days, retchbal, retchqval, col1, col2) values ('".$_GET["recno"]."', '".$msset[$k][0]."', '".$msset[$k][1]."', '".$msset[$k][2]."', '".$msset[$k][3]."', '".$msset[$k][4]."', '".$msset[$k][5]."', '".$msset[$k][6]."', '".$msset[$k][7]."', '".$msset[$k][8]."', '".$msset[$k][9]."')"; 
 		$result1 =$db->RunQuery($sql1);
					$chqbalval=0;					
				}
				$k=$k+1;
			}
			$j=$j+1;
		}
		$i=$i+1; 
	}
	
	
	$ii=1; 
	$docdate="docdate".$ii;
	
	while ($_GET[$docdate]!=""){
		$cash="cash".$ii;
		
		if ($_GET[$cash]!=""){
			
			$docno="docno".$ii;
			
			$chqval="chqval".$ii;
			$chqno="chqno".$ii;
			$chqdate="chqdate".$ii;
			
			
			$msset[$k][0]="";
					$msset[$k][1]="";
					$msset[$k][2]="";
					$msset[$k][3]="";
					$msset[$k][4]="";
					$msset[$k][5]="";
					$msset[$k][6]="";
					$msset[$k][7]="";
					$msset[$k][8]="";
					$msset[$k][9]="";
					
					
			$diff = abs(strtotime($_GET[$docdate]) - strtotime(date("Y-m-d")));
			$days = floor($diff / (60*60*24));
					
			/*$ResponseXML .= "<tr><td>".$_GET[$docno]."</td>
										<td>".$_GET[$docdate]."</td>
										<td>Cash</td>
										<td>".date("Y-m-d")."</td>
										<td>".$_GET[$cash]."</td>
										<td>".$days."</td>
										<td></td>
										<td>".$_GET[$chqval]."</td>
										<td>".$_GET[$chqno]."</td>
										<td>".$_GET[$chqdate]."</td></tr>";*/
				
										$msset[$k][0]=$_GET[$docno];
										$msset[$k][1]=$_GET[$docdate];
										$msset[$k][2]="Cash";
										$msset[$k][3]=date("Y-m-d");
										$msset[$k][4]=$_GET[$cash];
										$msset[$k][5]=$days;
										$msset[$k][6]=0;
										$msset[$k][7]=$_GET[$chqval];
										$msset[$k][8]=$_GET[$chqno];
										$msset[$k][9]=$_GET[$chqdate];
										
										$sql1="insert into tmp_utilization_ret_chq_set(recno, docno, docdate, chequeno, chequedate, settled, days, retchbal, retchqval, col1, col2) values ('".$_GET["recno"]."', '".$msset[$k][0]."', '".$msset[$k][1]."', '".$msset[$k][2]."', '".$msset[$k][3]."', '".$msset[$k][4]."', '".$msset[$k][5]."', '".$msset[$k][6]."', '".$msset[$k][7]."', '".$msset[$k][8]."', '".$msset[$k][9]."')"; 
									//	echo $sql1;
 		$result1 =$db->RunQuery($sql1);
										
										
		}
		$ii=$ii+1;
		$docdate="docdate".$ii;
	} 
	 
	$S = 1;
	while ($_GET[$docno] != ""){
		$docno="docno".$S;
			$docdate="docdate".$S;
			$chqval="chqval".$S;
			$chqno="chqno".$S;
			$chqdate="chqdate".$S;
			$cash="cash".$S;
			$retchqbal="retchqbal".$S;
			
		$H = 10;
		while ($H != 0){
  			if ($_GET[$docno] == $msset[$H][0]){
    			if ($msset[$H + 1][0] == $msset[$H][0]){
        			if (trim($msset[$H][2]) != "Cash"){
            			$msset[$H][6] = $msset[$H + 1][6] + $msset[$H + 1][4] - $_GET[$cash];
					} else {	
                    	$msset[$H][6] = $msset[$H + 1][6] + $msset[$H + 1][4];
        			}
    			} else {
       				if ($msset[$H][2] != "Cash"){
        				$msset[$H][6] = $_GET[$retchqbal] - $_GET[$cash];
					} else {	 
               			$msset[$H][6] = $_GET[$retchqbal];
       				}
				}
			}		
     		$H = $H - 1;
		}
		$deutot = $deutot +  $_GET[$retchqbal];
		$S = $S + 1;
	}

 
	
/*	$sql1="delete from tmp_utilization_ret_chq_set where recno='".$_GET["recno"]."'";
	$result1 =$db->RunQuery($sql1);
	
	$i=1;
	while ($k >	$i){						
 		$sql1="insert into tmp_utilization_ret_chq_set(recno, docno, docdate, chequeno, chequedate, settled, days, retchbal, retchqval, col1, col2) values ('".$_GET["recno"]."', '".$msset[$i][0]."', '".$msset[$i][1]."', '".$msset[$i][2]."', '".$msset[$i][3]."', '".$msset[$i][4]."', '".$msset[$i][5]."', '".$msset[$i][6]."', '".$msset[$i][7]."', '".$msset[$i][8]."', '".$msset[$i][9]."')"; 
 		$result1 =$db->RunQuery($sql1);
		$i=$i+1;
 	}*/
	
	$ResponseXML .= "<uti_table><![CDATA[ <table  bgcolor=\"#003366\" border=1  cellspacing=0>
								<tr><td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Doc.No</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Doc.Date</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque No</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque Date</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Settled</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Days</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ret.ch.bal</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ret.chq.val</font></td>
							</tr>";
							
	$sql="select * from tmp_utilization_ret_chq_set where recno='".$_GET["recno"]."'";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		$ResponseXML .= "<tr><td>".$row["docno"]."</td>
						<td>".$row["docdate"]."</td>
						<td>".$row["chequeno"]."</td>
						<td>".$row["chequedate"]."</td>
						<td>".$row["settled"]."</td>
						<td>".$row["days"]."</td>
						<td>".$row["retchbal"]."</td>
						<td>".$row["retchqval"]."</td>
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
			
			$sql="Select CHRET from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmprecno="000000".$row["CHRET"];
			$lenth=strlen($tmprecno);
			$recno=trim("RTC/ ").substr($tmprecno, $lenth-7);
			$_SESSION["recno"]=$recno;
			
			$sql="delete from tmp_ret_chq_sett where recno='".$recno."'";
			$result =$db->RunQuery($sql);
			
			$sql="delete from tmp_utilization_ret_chq_set where recno='".$recno."'";
			$result =$db->RunQuery($sql);
		
			echo $recno;	
			
		}
		
		
if($_GET["Command"]=="save_crec")
{
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	$sql="select CA_REFNO from s_crec where CA_REFNO='".trim($_GET["recno"])."'";
	$result =$db->RunQuery($sql);
	if ($row = mysql_fetch_array($result)){
		exit("Receipt No Already Exists");
	} else {
		
	}
	
	$sql="select * from tmp_ret_chq_sett where recno='".trim($_GET["recno"])."'";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		if 	($row["chqdate"]!=""){
			$sql1="insert into s_invcheq(refno, Sdate, cus_code, CUS_NAME, cheque_no, che_date, bank, che_amount, trn_type, ex_flag, sal_ex, dev, noof, ret_refno, ch_count_ret, department, SERI_NO) values ('".trim($_GET["recno"])."', '".$_GET["invdate"]."', '".$_GET["cuscode"]."', '".$_GET["cusname"]."', '".$row["chqno"]."', '".$row["chqdate"]."', '".$row["chqbank"]."', ".$row["chqamt"].", 'RET', 'N', '".$_GET["salesrep"]."', '".$_SESSION['dev']."', 0, '0', '0', 'O', '0')";
			$result1 =$db->RunQuery($sql1);
		} else {
			exit();
		}
	}	
	
	
	
	$sql="select * from tmp_utilization_ret_chq_set where recno='".trim($_GET["recno"])."'";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		
			$sql1="insert into ch_sttr (ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_INDATE, ST_DAYS, ST_CHNO, DEV, cus_code, ap_days) values ('".trim($_GET["recno"])."', '".$_GET["invdate"]."', '".$row["docno"]."', '".$row["settled"]."', 'CRN', '".$row["chequedate"]."', '".$row["days"]."', ".$row["chequeno"].", '".$_SESSION['dev']."', '".$_GET["cuscode"]."', '".$row["days"]."' )";
			$result1 =$db->RunQuery($sql1);
			
			$sql1="update s_cheq set PAID= PAID+".$row["settled"]." where CR_REFNO='".$row["docno"]."'";
			$result1 =$db->RunQuery($sql1);
		
	}	
	
	$sql1="update vendor set RET_CHEQ= RET_CHEQ-".$_GET["txtpaytot"]." where CODE='".$_GET["cuscode"]."'";
	$result1 =$db->RunQuery($sql1);
	
	$sql1="insert into s_led (REF_NO, C_CODE, SDATE, FLAG, AMOUNT, DEV) values ('".trim($_GET["recno"])."', '".$_GET["cuscode"]."', '".$_GET["invdate"]."', 'REC', ".$_GET["txtpaytot"].", '".$_SESSION['dev']."')";
	$result1 =$db->RunQuery($sql1);
	
	$sql1="insert into s_crec (CA_REFNO, CA_DATE, CA_CODE, CA_CASSH, CA_AMOUNT, DEPARTMENT, DEV, FLAG, pay_type) values ('".trim($_GET["recno"])."', '".$_GET["invdate"]."', '".$_GET["cuscode"]."',  ".$_GET["cashtot"].", ".$_GET["txtpaytot"].", 'O', '".$_SESSION['dev']."', 'RET', '".$_GET["paytype"]."')";
	$result1 =$db->RunQuery($sql1);

	
	if ($_GET["txtoverpay"]>0){
		$sql1="Insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, DEV) values ('".trim($_GET["recno"])."', '".$_GET["invdate"]."', 'REC',  '".$_GET["cuscode"]."', ".$_GET["txtoverpay"].", ".$_GET["txtoverpay"].", '".$_SESSION['dev']."')";
		$result1 =$db->RunQuery($sql1);

	}

	$sql1="update  invpara set CHRET=CHRET+1";
	$result1 =$db->RunQuery($sql1);
	
	
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
								
								$sql = mysql_query("SELECT * from s_crec where  CA_REFNO like  '$letters%'") or die(mysql_error());
							} else if ($_GET["mstatus"]=="recdate"){
								$letters = $_GET['recdate'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_crec where CA_DATE like  '$letters%'") or die(mysql_error());
							}else if ($_GET["mstatus"]=="recamt"){
								$letters = $_GET['recamt'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_crec where CA_AMOUNT like  '$letters%'") or die(mysql_error());
							} else {
								$letters = $_GET['recno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_crec where CA_REFNO like  '$letters%'") or die(mysql_error());
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
	
	$sql="delete from tmp_ret_chq_sett where recno='".$_GET["recno"]."'";
	$result =$db->RunQuery($sql);
		
	$sql="select * from s_invcheq where refno='".$_GET["recno"]."'";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		$sql1="insert into tmp_ret_chq_sett(recno, chqno, chqdate, chqbank, chqamt) values ('".$row["refno"]."', '".$row["cheque_no"]."', '".$row["che_date"]."', '".$row["bank"]."', ".$row["che_amount"].")";
		$result1 =$db->RunQuery($sql1);
	}		
		
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$sql="select * from tmp_ret_chq_sett where recno='".$_GET["recno"]."' ";
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
				
					$sql2="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days) values ('".$_GET["recno"]."', '".$row["ST_INVONO"]."', '".$row1["SDATE"]."', '".$row["ST_CHNO"]."', '".$row["st_chdate"]."', '".$row["st_chbank"]."', ".$row["ST_PAID"].", ".$row["st_days"].")"; 
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
				
				$sql="select * from tmp_utilization where recno='".$_GET["recno"]."'";
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