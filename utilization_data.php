<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	include_once './connection_sql.php';
	
	 date_default_timezone_set('Asia/Colombo'); 
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
	$Gridinv = array(array());
	$gridchk = array(array());
		
		
		
 if ($_POST["Command"] == "pass_quot") {
    $_SESSION["uti_cus_code"] = $_POST['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_POST["custno"];

    $sql = "Select * from vendor where   CODE ='" . $cuscode . "'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

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


if ($_GET["Command"]=="pass_allno"){
   

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_POST["custno"];

    $sql = "select REFNO , BALANCE  from c_bal where REFNO='".$_GET["grnno"]."'";
    $result = $conn->query($sql);

    if ($rowM = $result->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . json_encode($rowM) .  "]]></id>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

 

if ($_GET["Command"]=="ret_chq_settle"){
	/*echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/
	
	//$Gridinv = array(array());
	
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	$ResponseXML .= "<uti_table><![CDATA[ <table  border=1  cellspacing=0>
								<tr><td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Return Chq.No</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Return Date</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque Amount</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Paid</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Balance</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Settle Amount</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Remain</font></td>
								
							</tr>";
			
	
	
		$sql1="delete from tmputi_chqdet where c_code='".$_GET["Txtcusco"]."'";
		$result1 =$db->RunQuery($sql1);
					
	$sql="select * from s_cheq where CR_C_CODE='".$_GET["Txtcusco"]." 'and PAID<CR_CHEVAL and CR_FLAG='0' ORDER BY CR_DATE";
	
	$i=1;
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		
		$retinvno="retinvno".$i;
		$retinvdate="retinvdate".$i;
		$retsettle="retsettle".$i;
		
		$j=$i+1;
		$retsettle_next="retsettle".$j;
		
		$retremain="retremain".$i;
		$retbal="retbal".$i;
		
		$sql1="insert into tmputi_chqdet (ret_chq_no, ret_date, chq_amt, paid, balance) values ('".$row["CR_REFNO"]."', '".$row["CR_DATE"]."', ".$row["CR_CHEVAL"].", ".$row["PAID"].", ".($row["CR_CHEVAL"]-$row["PAID"]).")";
		$result1 =$db->RunQuery($sql1);
		/*$GLOBALS[$Gridinv[$r][1]]=$row["REF_NO"];
		$GLOBALS[$Gridinv[$r][2]]=$row["SDATE"];
		$GLOBALS[$Gridinv[$r][3]]=$row["GRAND_TOT"];
		$GLOBALS[$Gridinv[$r][4]]=$row["TOTPAY"];
		$GLOBALS[$Gridinv[$r][5]]=$row["GRAND_TOT"]-$row["TOTPAY"];*/
		
		//$r=$r+1;
		
		$ResponseXML .= "<tr><td><div id=\"".$retinvno."\">".$row["CR_REFNO"]."</div></td>
						<td><div id=\"".$retinvdate."\">".$row["CR_DATE"]."</div></td>
						<td>".$row["CR_CHEVAL"]."</td>
						<td>".$row["PAID"]."</td>
						<td><input type=\"text\"  class=\"txtbox\" name=".$retbal." id=".$retbal." value=".($row["CR_CHEVAL"]-$row["PAID"])." size=\"10\" disabled=\"disabled\"/></td>
						<td><input type=\"text\"  class=\"txtbox\" name=".$retsettle." id=".$retsettle."  onblur=\"keysetvalue_blur_ret('$retsettle','$retremain', '$retsettle_next', '$retbal');\" size=\"10\" /></td>
						<td><input type=\"text\"  class=\"txtbox\" name=".$retremain." id=".$retremain." size=\"10\" disabled=\"disabled\"/></td>
						</tr>";	
						
		$i=$i+1;						
				
	}	
	
	
						
								
			
				$ResponseXML .= "   </table>]]></uti_table>";
				$ResponseXML .= "<mcount_chq><![CDATA[".$i."]]></mcount_chq>";
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;								
}


if ($_GET["Command"]=="settle_inv"){ 
	  header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
 
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	$ResponseXML .= "<sales_table><![CDATA[<table class=\"table table-bordered \">
								<tr class=\"info\"><td >Invoice No</font></td>
								<td >Invoice Date</font></td>
								<td >Invoice Amount</font></td>
								<td >Paid</font></td>
								<td >Balance</font></td>
								<td >Settle Amount</font></td>
								<td >Remain</font></td>
								
							</tr>";
			
	
	
		$sql1="delete from tmputi_invdet where c_code='".$_GET["Txtcusco"]."'";
		   $result1 = $conn->query($sql1);
					
	$sqel="select * from s_salma where C_CODE='".$_GET["Txtcusco"]."' and TOTPAY<GRAND_TOT and (GRAND_TOT-TOTPAY)>0 and CANCELL=0  ORDER BY SDATE";
 
	$i=1;
	foreach ($conn->query($sqel) as $row) { 
	 
		$invno="invno".$i;
		$invdate="invdate".$i;
		$settle="settle".$i;
		
		$j=$i+1;
		$settle_next="settle".$j;
		
		$remain="remain".$i;
		$bal="bal".$i;
		
		$sql1="insert into tmputi_invdet (inv_no, inv_date, inv_amt, paid, balance) values ('".$row["REF_NO"]."', '".$row["SDATE"]."', ".$row["GRAND_TOT"].", ".$row["TOTPAY"].", ".($row["GRAND_TOT"]-$row["TOTPAY"]).")";
	   $result1 = $conn->query($sql1);
	 
		$ResponseXML .= "<tr> 
        <td><div id=\"".$invno."\">".$row["REF_NO"]."</div>
        	<td><div id=\"".$invdate."\">".$row["SDATE"]."</div></td>
       <td align=right>".number_format($row["GRAND_TOT"], 2, ".", ",")."</td>
        	<td align=right>".number_format($row["TOTPAY"], 2, ".", ",")."</td>
        <td><input type=\"text\"   name=".$bal." disabled id=".$bal." value=".number_format(($row["GRAND_TOT"]-$row["TOTPAY"]), 2, ".", "")."  /></td>
       <td><input type=\"text\"   name=".$settle." id=".$settle."  onblur=\"keysetvalue_blur('$settle','$remain', '$settle_next', '$bal');\" onkeypress=\"keyset('$settle_next', event);\"   s /></td>
						<td><input type=\"text\" disabled  name=".$remain." id=".$remain." /></td>
        </tr>";
        
	 
						
		$i=$i+1;						
				
	}	
	
	$invno="invno".$i;
		$invdate="invdate".$i;
	$settle="settle".$i;
		
		$j=$i+1;
		$settle_next="settle".$j;
		
		$remain="remain".$i;
		$bal="bal".$i;
		
	$ResponseXML .= "<tr><td><div id=\"".$invno."\"></div></td>
						<td><div id=\"".$invdate."\"></div></td>
						<td></td>
						<td></td>
						<td><input type=\"text\" disabled class=\"txtbox\" name=".$bal." id=".$bal." value=\"\" size=\"10\"/></td>
						<td><input type=\"text\" disabled class=\"txtbox\" name=".$settle." id=".$settle."  onblur=\"keysetvalue_blur('$settle','$remain', '$settle_next', '$bal');\" size=\"10\"/></td>
						<td><input type=\"text\" disabled class=\"txtbox\" name=".$remain." id=".$remain." size=\"10\"/></td>
						</tr>";	
								
			
				 $ResponseXML .= "</table>]]></sales_table>";   
				$ResponseXML .= "<mcount><![CDATA[".$i."]]></mcount>";
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;								
}


if ($_GET["Command"]=="unsettle_inv"){
 

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	$chtotal = 0;
 
	$invtotal = 0;
	
		$sql="select * from tmputi_invdet where c_code='".$_GET["Txtcusco"]."'";
		$result =$db->RunQuery($sql);
		$rec_count=mysql_num_rows($result);
		$i=1;
		while ($i <= $rec_count){
			$settle="settle".$i;
			$invtotal = $invtotal + $_GET[$settle];
			
			$i =$i +1;
		
		}

		if (($invtotal + $chtotal + $_GET["txtcash"] +$_GET["txtamount"]) > $_GET["txtcrnamount"]) {
        	$ResponseXML .= "<lblPaid><![CDATA[Insufficient GRN Amount ...]]></lblPaid>";
			
		} else {
    		$lblPaid = $_GET["invtotal"] + $_GET["chtotal"] + $_GET["txtcash"] + $_GET["txtamount"];
			$ResponseXML .= "<lblPaid><![CDATA[".$lblPaid."]]></lblPaid>";
		}
	
	
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;								
}



/*if ($_GET["Command"]=="ret_chq_settle"){
	
	
	
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	$ResponseXML .= "<uti_table><![CDATA[ <table  bgcolor=\"#003366\" border=1  cellspacing=0>
								<tr><td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Return Chq.No</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Return Date</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque Amount</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Paid</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Balance</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Settle Amount</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Remain</font></td>
								
							</tr>";
			
	$r=1;
				
	$sql="select *from s_cheq where CR_C_CODE='".$_GET["Txtcusco"]." 'and PAID < CR_CHEVAL and CR_FLAG='0' ORDER BY CR_DATE";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		
		$GLOBALS[$gridchk[$r][1]]=$row["CR_REFNO"];
		$GLOBALS[$gridchk[$r][2]]=$row["CR_DATE"];
		$GLOBALS[$gridchk[$r][3]]=$row["CR_CHEVAL"];
		$GLOBALS[$gridchk[$r][4]]=$row["PAID"];
		$GLOBALS[$gridchk[$r][5]]=$row["CR_CHEVAL"]-$row["PAID"];
		
		$r=$r+1;
		
		$ResponseXML .= "<tr><td>".$row["CR_REFNO"]."</td>
						<td>".$row["CR_DATE"]."</td>
						<td>".$row["CR_CHEVAL"]."</td>
						<td>".$row["PAID"]."</td>
						<td>".$row["CR_CHEVAL"]-$row["PAID"]."</td>
						</tr>";			
				
	}			
			
				$ResponseXML .= "   </table>]]></uti_table>";
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;								
}*/

if($_GET["Command"]=="inv_btn"){

	$sql="select * from  s_salma where CANCELL='0'";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
	
		$sql1="select ST_INVONO, sum(ST_PAID) as tpaid from s_sttr where ST_INVONO='".$row["REF_NO"]."' group by ST_INVONO";
		$result1 =$db->RunQuery($sql1);
		if ($row1 = mysql_fetch_array($result1)){
			if (is_null($row1["tpaid"])){ $pay = $row1["tpaid"]; }
			
			$sql2="update s_salma set DIS_RUP ='".($row["GRAND_TOT"] - $pay)."' where REF_NO='".$row["REF_NO"]."'";
			$result2 =$db->RunQuery($sql2);
		}	
	}
	
}

if($_GET["Command"]=="settlement"){

	$sql="SELECT * FROM c_bal";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
	
		$sql1="Select sum(C_PAYMENT) as paid  from s_ut where CRE_NO_NO='".$row['REFNO']."'";
		$result1 =$db->RunQuery($sql1);
		if ($row1 = mysql_fetch_array($result1)){
			if (is_null($row1["paid"])){ $mpaid = $row1["paid"]; }
			
			$sql2="update c_bal set totpay ='".$mpaid."' where REF_NO='".$row["REF_NO"]."'";
			$result2 =$db->RunQuery($sql2);
		}	
	}
}

if($_GET["Command"]=="utilization")
{	
	
	
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
	$msset = array(array());
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
				if ($invset<=$chqbalval){
					if ($tmp[$j] > 0){ $tmp[$j] = 0; }
					
					$chqbalval=$chqbalval-$invset;
					
					
				
					$diff = abs(strtotime($_GET[$docdate]) - strtotime($row["chqdate"]));
					$days = floor($diff / (60*60*24));
			
					$ResponseXML .= "<tr><td>".$_GET[$docno]."</td>
										<td>".$_GET[$docdate]."</td>
										<td>".$row["chqno"]."</td>
										<td>".$row["chqdate"]."</td>
										<td>".$invset."</td>
										<td>".$days."</td>
										<td>0</td>
										<td>".$_GET[$chqval]."</td>
										<td>".$_GET[$chqno]."</td>
										<td>".$_GET[$chqdate]."</td></tr>";
										
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
					$tmp[$j]=0;					
				} else {
					if ($tmp[$j] > 0){ $tmp[$j] = $invset-$chqbalval; }
					
					$diff = abs(strtotime($_GET[$docdate]) - strtotime($row["chqdate"]));
					$days = floor($diff / (60*60*24));
					
					$ResponseXML .= "<tr><td>".$_GET[$docno]."</td>
										<td>".$_GET[$docdate]."</td>
										<td>".$row["chqno"]."</td>
										<td>".$row["chqdate"]."</td>
										<td>".$chqbalval."</td>
										<td>".$days."</td>";
										
										$tmp[$j]=$invset-$chqbalval;
										
					$ResponseXML .= "<td>".$tmp[$j]."</td>
										<td>".$_GET[$chqval]."</td>
										<td>".$_GET[$chqno]."</td>
										<td>".$_GET[$chqdate]."</td></tr>";
										
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
					$chqbalval=0;					
				}
				$k=$k+1;
			}
			$j=$j+1;
		}
		$i=$i+1; 
	}
	
	$ii=1; 
	while ($_GET[$docdate]!=""){
		if ($_GET[$cash]!=""){
			
			$docno="docno".$ii;
			$docdate="docdate".$ii;
			$chqval="chqval".$ii;
			$chqno="chqno".$ii;
			$chqdate="chqdate".$ii;
			$cash="cash".$ii;
			
			$diff = abs(strtotime($_GET[$docdate]) - strtotime(date("Y-m-d")));
			$days = floor($diff / (60*60*24));
					
			$ResponseXML .= "<tr><td>".$_GET[$docno]."</td>
										<td>".$_GET[$docdate]."</td>
										<td>Cash</td>
										<td>".date("Y-m-d")."</td>
										<td>".$_GET[$cash]."</td>
										<td>".$days."</td>
										<td></td>
										<td>".$_GET[$chqval]."</td>
										<td>".$_GET[$chqno]."</td>
										<td>".$_GET[$chqdate]."</td></tr>";
		}
		$ii=$ii+1;
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

 
	
	$sql1="delete from tmp_utilization_ret_chq_set where recno='".$_GET["recno"]."'";
	$result1 =$db->RunQuery($sql1);
	
	$i=1;
	while ($k >	$i){						
 		$sql1="insert into tmp_utilization_ret_chq_set(recno, docno, docdate, chequeno, chequedate, settled, days, retchbal, retchqval, col1, col2) values ('".$_GET["recno"]."', '".$msset[$i][0]."', '".$msset[$i][1]."', '".$msset[$i][2]."', '".$msset[$i][3]."', '".$msset[$i][4]."', '".$msset[$i][5]."', '".$msset[$i][6]."', '".$msset[$i][7]."', '".$msset[$i][8]."', '".$msset[$i][9]."')"; 
 		$result1 =$db->RunQuery($sql1);
		$i=$i+1;
 	}
	
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
						<td>".$row["col1"]."</td>
						<td>".$row["col2"]."</td></tr>";			
				
	}			
			
				$ResponseXML .= "   </table>]]></uti_table>";
							
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;		
	
	
}



		if($_GET["Command"]=="new_rec")
		{
			
		    
			$sql="Select uti from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmprecno="000000".$row["uti"];
			$lenth=strlen($tmprecno);
			$recno=trim("CUTI/ ").substr($tmprecno, $lenth-7);
			$_SESSION["recno"]=$recno;
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			$ResponseXML .= "<recno><![CDATA[".$recno."]]></recno>";
			$ResponseXML .= "<mdate><![CDATA[".date("Y-m-d")."]]></mdate>";
			$ResponseXML .= "</salesdetails>";
		
			echo $ResponseXML;	
		 
		}
		
if($_GET["Command"]=="setTotal")
		{
			$r=1;
			$chtotal=0;
			$total=0;
			
			while ($GLOBALS[$gridchk[$r][1]]!=""){
				$GLOBALS[$gridchk[$r][7]]="";
				$chtotal=$chtotal+$GLOBALS[$gridchk[$r][6]];
				$r=$r+1;
			} 
			
			while ($GLOBALS[$Gridinv[$r][1]]!=""){
				$GLOBALS[$Gridinv[$r][7]]="";
				$total=$total+$GLOBALS[$Gridinv[$r][6]];
				$r=$r+1;
			}
			//$re = Val(Format(txtcrnamount.Text, General)) - (total + chtotal + Val(Format(txtcash, General)))
			
		
			
		}
		
		
if($_POST["Command"]=="save_crec")
{

 
	include('connection.php');
	
	$sqltmp="select * from invpara";
		$resulttmp=mysql_query($sqltmp, $dbinv);
		$rowtmp = mysql_fetch_array($resulttmp);
	
	 	
		
	$sql_status=0;
			
	mysql_query("SET AUTOCOMMIT=0", $dbinv);
	mysql_query("START TRANSACTION", $dbinv);	
	
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	//mysql_query("START TRANSACTION", $dbinv);	 
	
	$sql="Select uti from invpara";
	$result=mysql_query($sql, $dbinv);
	$row = mysql_fetch_array($result);
	$tmprecno="000000".$row["uti"];
	$lenth=strlen($tmprecno);
	$recno=trim("CUTI/ ").substr($tmprecno, $lenth-7);
	$_SESSION["recno"]=$recno;
	
// 	$sql_ch="select * from ch_sttr where ST_REFNO='".trim($recno)."'";
// 	$result_ch=mysql_query($sql_ch, $dbinv);
// 	$row_ch = mysql_fetch_array($result_ch);
	
// 	$sql="select * from ch_sttr";
// 	$result=mysql_query($sql, $dbinv);
		
	$sql_utmas="SELECT * FROM s_utmas WHERE C_REFNO ='".trim($recno)."'";
	$result_utmas=mysql_query($sql_utmas, $dbinv);
	if($row_utmas = mysql_fetch_array($result_utmas)){
		exit("Ref. No Already Exists");
	}
 
	
	$sql_utmas="insert into s_utmas(C_REFNO, C_DATE, C_CODE, C_CRNNo, C_Amount, C_cash, c_chno, c_chdate, ch_val, ch_bank, CANCEL) values ('".trim($recno)."', '".$_POST["dtdate"]."', '".$_POST["Txtcusco"]."', '".$_POST["txtcrnno"]."', '".$_POST["lblPaid"]."', '".$_POST["txtcash"]."', '".$_POST["txtchno"]."', '".$_POST["DTPicker1"]."', '".$_POST["txtamount"]."', '".$_POST["txtchbank"]."', '0')";
	$result_utmas=mysql_query($sql_utmas, $dbinv);
	if ($result_utmas!=1){ $sql_status=1; }

	
// 	if ($_POST["chkcash"]=="true"){
// 		$sql_cruti="insert into s_ut(C_REFNO, C_DATE, C_CODE, C_INVNO, C_PAYMENT, CRE_NO_NO, TYPE) values ('".trim($recno)."', '".$_POST["dtdate"]."', '".$_POST["Txtcusco"]."', 'CASH', '".$_POST["lblPaid"]."', '".trim($_POST["txtcrnno"])."', 'CAS')";
// 		$result_cruti=mysql_query($sql_cruti, $dbinv);
// 		if ($result_cruti!=1){ $sql_status=2; }
// 	}
	
 
		$r=1;
		while ($_POST["mcount"]>$r){
				$invno="invno".$r;
				$invdate="invdate".$r;
				$settle="settle".$r;
				$remain="remain".$r;
				$bal="bal".$r;
				
			if (($_POST[$settle]>0) and ($_POST[$invno]!="") and ($_POST[$invdate]!="") and ($_POST[$bal]>0)){
				$sql_cruti="insert into s_ut(C_REFNO, C_DATE, C_CODE, C_INVNO, C_PAYMENT, CRE_NO_NO, TYPE) values ('".trim($recno)."', '".$_POST["dtdate"]."', '".$_POST["Txtcusco"]."', '".$_POST[$invno]."', '".$_POST[$settle]."', '".trim($_POST["txtcrnno"])."', 'INV' )";
				$result_cruti=mysql_query($sql_cruti, $dbinv);
				if ($result_cruti!=1){ $sql_status=3; }
								
				$sql_cruti="UPDATE s_salma SET TOTPAY = TOTPAY + ".$_POST[$settle]." WHERE ((REF_NO='".trim($_POST[$invno])."'))";
				$result_cruti=mysql_query($sql_cruti, $dbinv);
				if ($result_cruti!=1){ $sql_status=4; }
				
				$diff = abs(strtotime($_POST["dtdate"]) - strtotime($_POST[$invdate]));
				$days = floor($diff / (60*60*24));
					
				$sql_cruti="insert into s_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_CHNO, st_days, ap_days, DEV, department) values ('".trim($recno)."', '".$_POST["dtdate"]."', '".$_POST[$invno]."', '".$_POST[$settle]."', 'UT', '".trim($_POST["txtcrnno"])."', '".$days."', '".$days."', '".$_SESSION['dev']."', 'O')";
				$result_cruti=mysql_query($sql_cruti, $dbinv);	
				if ($result_cruti!=1){ $sql_status=5; }
								
				$sql1="insert into s_sttr_all(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, netamount, ST_CHNO, ST_FLAG, st_days, ap_days, cus_code, cusname, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department, form_type, trn_type) values
	  ('".trim($recno)."', '".$_POST["dtdate"]."', '".$_POST[$invno]."', ".$_POST[$settle].", ".(-1*$_POST[$settle]).", '".trim($_POST["txtcrnno"])."', '".$ST_flag."', '".$days."', '".$days."', '".$_POST["Txtcusco"]."', '".$_POST["txt_cusname"]."', '".$_SESSION['dev']."', 0, 0, 0, '0', 'O', 'UT', 'SET')";
				$result1=mysql_query($sql1, $dbinv);	
				if ($result1!=1){ $sql_status=6; }
	  		
			 
				 
			}
			
			$r=$r+1;
		}
 

 
	
	
	$sql_inv="UPDATE c_bal SET BALANCE = BALANCE - ".$_POST["lblPaid"]." WHERE ((REFNO='".trim($_POST["txtcrnno"])."'))";
	$result_inv=mysql_query($sql_inv, $dbinv);
	if ($result_inv!=1){ $sql_status=8; }	
		
	$sql1="insert into s_sttr_all(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, balance, netamount, cus_code, cusname, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department, form_type, trn_type) values
	  ('".trim($_POST["txtcrnno"])."', '".$_POST["dtdate"]."', '".trim($_POST["txtcrnno"])."', ".$_POST["lblPaid"].", ".(-1*$_POST["lblPaid"]).", ".$_POST["lblPaid"].", '".$_POST["Txtcusco"]."', '".$_POST["txt_cusname"]."',  '".$_SESSION['dev']."', 0, 0, 0, '0', 'O', 'UT', 'SETOVER')";
	$result1=mysql_query($sql1, $dbinv);
	if ($result1!=1){ $sql_status=9; }		
			
	$sql_inv="UPDATE invpara SET uti=uti+1";
	$result_inv=mysql_query($sql_inv, $dbinv);	
	if ($result_inv!=1){ $sql_status=1; }		
		
	$sql2="insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('".trim($recno)."', '".$_SESSION["CURRENT_USER"]."', 'Utilization', 'Save', '".date("Y-m-d H:i:s")."', '".date("Y-m-d")."')";
	$resul2=mysql_query($sql2, $dbinv);	
	if ($resul2!=1){ $sql_status=10; }		
	echo $sql_status;							
	//mysql_query("COMMIT", $dbinv);
	if ($sql_status==0){
		mysql_query("COMMIT", $dbinv);
		echo "Saved";
	}	else {
		mysql_query("ROLLBACK", $dbinv);
		echo "Error has occures. Can't Save";
	}
		
	
 
	
}

if ($_GET["Command"]=="search_rec"){
	
	include_once("connection.php");
	
	$ResponseXML = "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
							   <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
							    <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
                             
   							</tr>";
							
							$letters = $_GET['recno'];
							
                         	$curYear=date("Y");
							$curMonth=date("m");
							
						   //$sql = mysql_query("SELECT * from s_utmas where CANCEL='0' and year(C_DATE)='".$curYear."' and month(C_DATE)='".$curMonth."' and C_REFNO like  '$letters%' order by C_REFNO desc") or die(mysql_error());
						   $sql = mysql_query("SELECT * from s_utmas where CANCEL='0' and C_REFNO like  '$letters%' order by C_REFNO desc LIMIT 50") or die(mysql_error());
						  // echo "SELECT * from s_utmas where CANCEL='0' and  C_REFNO like  '$letters%' order by C_REFNO desc limit 50";
						   
						/*	if ($_GET["mfield"]=="recno"){
						   		$letters = $_GET['recno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								
								$sql = mysql_query("SELECT * from s_utmas where CANCEL='0' and  C_REFNO like  '$letters%'") or die(mysql_error());
							} else if ($_GET["mstatus"]=="recdate"){
								$letters = $_GET['recdate'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_utmas where CA_DATE like  '$letters%'") or die(mysql_error());
							}else if ($_GET["mstatus"]=="recamt"){
								$letters = $_GET['recamt'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_utmas where CA_AMOUNT like  '$letters%'") or die(mysql_error());
							} else {
								$letters = $_GET['recno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_utmas where CA_REFNO like  '$letters%'") or die(mysql_error());
							}*/
							
													
						
							while($row = mysql_fetch_array($sql)){
								$REF_NO = $row['C_REFNO'];
								$stname = $_GET["mstatus"];
							$ResponseXML .= "<tr>
                           	  <td onclick=\"recno('$REF_NO');\">".$row['C_REFNO']."</a></td>
                              <td onclick=\"recno('$REF_NO');\">".$row['C_DATE']."</a></td>
                              <td onclick=\"recno('$REF_NO');\">".$row['C_Amount']."</a></td>";
							  
							  $sql1="SELECT * FROM vendor where CODE = '".$row["C_CODE"]."'";
							  $result1 =$db->RunQuery($sql1);
							  $row1 = mysql_fetch_array($result1);
                              $ResponseXML .= "<td onclick=\"recno('$REF_NO');\">".$row1['NAME']."</a></td>                          	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}


if ($_GET["Command"]=="pass_recno"){
 header('Content-Type: text/xml'); 
	 echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"; 

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	$sql="select * from s_utmas where C_REFNO='".$_GET["recno"]."'";
	$result =$db->RunQuery($sql);
	if ($row = mysql_fetch_array($result)){
		$ResponseXML .= "<C_REFNO><![CDATA[".$row["C_REFNO"]."]]></C_REFNO>";
		$ResponseXML .= "<C_DATE><![CDATA[".$row["C_DATE"]."]]></C_DATE>";
		$ResponseXML .= "<C_CODE><![CDATA[".$row["C_CODE"]."]]></C_CODE>";
		$ResponseXML .= "<ch_bank><![CDATA[".$row["ch_bank"]."]]></ch_bank>";
		$ResponseXML .= "<c_chno><![CDATA[".$row["c_chno"]."]]></c_chno>";
		$ResponseXML .= "<c_chdate><![CDATA[".$row["c_chdate"]."]]></c_chdate>";
		$ResponseXML .= "<ch_val><![CDATA[".$row["ch_val"]."]]></ch_val>";
		
		$sql1="select * from vendor where CODE='".$row["C_CODE"]."'";
		$result1 =$db->RunQuery($sql1);
		if ($row1 = mysql_fetch_array($result1)){
			$ResponseXML .= "<cusname><![CDATA[".$row1["NAME"]."]]></cusname>";
			 
		}
			
			
		$ResponseXML .= "<C_CRNNo><![CDATA[".$row["C_CRNNo"]."]]></C_CRNNo>"; 
		
		
		$sql_bal="select REFNO , BALANCE  from c_bal where REFNO='".$row["C_CRNNo"]."'";
				
				$result_bal =$db->RunQuery($sql_bal);
				if($row_bal = mysql_fetch_array($result_bal)){
					
					$ResponseXML .= "<BALANCE><![CDATA[".$row_bal['BALANCE']."]]></BALANCE>";
					
				} else {
					$ResponseXML .= "<BALANCE><![CDATA[]]></BALANCE>";
				}
							
		$sql1="select * from s_ut where C_REFNO='".$_GET["recno"]."'";
		$result1 =$db->RunQuery($sql1);
		if ($row1 = mysql_fetch_array($result1)){
			$type=$row1["TYPE"];
			if ($row1["TYPE"]=="CAS"){
				$cash=$row1["C_PAYMENT"];
			} else {
				$cash=0;
			}	
		}
		
// 		$ResponseXML .= "<ctype><![CDATA[".$type."]]></ctype>";
		$ResponseXML .= "<cash><![CDATA[".$cash."]]></cash>";
		
		$ResponseXML .= "<uti_table_chq><![CDATA[<table class=\"table table-bordered \"><tr class=\"info\">
					<td>Invoice No</td>
					<td>Invoice Date</td>
					<td>Invoice Amount</td>
					<td>Paid</td>
					<td>Balance</td>
					<td>Settled Amount</td>
					<td>Remain</td>
					
					</tr>";
		
					
		$sql1="select * from s_ut where C_REFNO='".$_GET["recno"]."' and TYPE='CHQ'";
		$result1 =$db->RunQuery($sql1);
		while ($row1 = mysql_fetch_array($result1)){
			$sql_inv="select * from s_salma where REF_NO='".$row1["C_INVNO"]."'";
			$result_inv =$db->RunQuery($sql_inv);
			$row_inv = mysql_fetch_array($result_inv);
		
			$ResponseXML .= "<tr>
					<td>".$row1["C_INVNO"]."</td>
					<td>".$row_inv["SDATE"]."</td>
					<td>".$row_inv["GRAND_TOT"]."</td>
					<td>".($row_inv["TOTPAY"]-$row1["C_PAYMENT"])."</td>
					<td>".($row_inv["GRAND_TOT"]-($row_inv["TOTPAY"]-$row1["C_PAYMENT"]))."</td>
					<td>".$row1["C_PAYMENT"]."</td>
					<td>".(($row_inv["GRAND_TOT"]-($row_inv["TOTPAY"]-$row1["C_PAYMENT"]))-$row1["C_PAYMENT"])."</td>
					</tr>";
					
				
			
		}
		
		$ResponseXML .= "   </table>]]></uti_table_chq>";
		
				
		$ResponseXML .= "<uti_table_inv><![CDATA[<table class=\"table table-bordered \"> <tr class=\"info\">
					<td>Invoice No</td>
					<td>Invoice Date</td>
					<td>Invoice Amount</td>
					<td>Paid</td>
					<td>Balance</td>
					<td>Settled Amount</td>
					<td>Remain</td>
					
					</tr>";
		
		$C_PAYMENT=0;
		$sql1="select * from s_ut where C_REFNO='".$_GET["recno"]."' and TYPE='INV'";
		$result1 =$db->RunQuery($sql1);
		while ($row1 = mysql_fetch_array($result1)){
			$sql_inv="select * from s_salma where REF_NO='".$row1["C_INVNO"]."'";
			$result_inv =$db->RunQuery($sql_inv);
			$row_inv = mysql_fetch_array($result_inv);
			
			$ResponseXML .= "<tr>
					<td>".$row1["C_INVNO"]."</td>
					<td>".$row_inv["SDATE"]."</td>
					<td>".$row_inv["GRAND_TOT"]."</td>
					<td>".($row_inv["TOTPAY"]-$row1["C_PAYMENT"])."</td>
					<td>".($row_inv["GRAND_TOT"]-($row_inv["TOTPAY"]-$row1["C_PAYMENT"]))."</td>
					<td>".$row1["C_PAYMENT"]."</td>
					<td>".(($row_inv["GRAND_TOT"]-($row_inv["TOTPAY"]-$row1["C_PAYMENT"]))-$row1["C_PAYMENT"])."</td>
					</tr>";
					
			$C_PAYMENT = $C_PAYMENT + $row1["C_PAYMENT"];
			
		}
		
		$ResponseXML .= "   </table>]]></uti_table_inv>";
		
		$ResponseXML .= "<total><![CDATA[".$C_PAYMENT."]]></total>";
		
		
	}
		$ResponseXML .= "</salesdetails>";
		echo $ResponseXML;
}


if ($_GET["Command"]=="delete_rec"){
	$ResponseXML = "";
	
	include('connection.php');
	
	$sql_status=0;
			
	mysql_query("SET AUTOCOMMIT=0", $dbinv);
	mysql_query("START TRANSACTION", $dbinv);	 
			
	$sql1="select * from s_ut where C_REFNO='".$_GET["txtrefno"]."' and TYPE='INV'";
	$result1=mysql_query($sql1, $dbinv);	
	while ($row1 = mysql_fetch_array($result1)){
		
		$sql="UPDATE s_salma SET TOTPAY=TOTPAY-" . $row1["C_PAYMENT"] . "  WHERE REF_NO='" . trim($row1["C_INVNO"]) . "'";
		$result=mysql_query($sql, $dbinv);	
				
		$sql="UPDATE c_bal SET BALANCE=BALANCE+" . $row1["C_PAYMENT"] . "  WHERE REFNO='" . trim($_GET["txtcrnno"]) . "'";
		$result=mysql_query($sql, $dbinv);	
		
	}	
	
	 
	
	if ($_GET["txtcash"]!=""){
		$sql="UPDATE c_bal SET BALANCE=BALANCE+" . $_GET["txtcash"] . "  WHERE REFNO='" .trim($_GET["txtcrnno"]) . "'";
		$result=mysql_query($sql, $dbinv);	
		
		//echo $sql;
	}	
	
	$sql="UPDATE s_utmas SET CANCEL=1 WHERE C_REFNO='" . trim($_GET["txtrefno"]) . "'";
	$result=mysql_query($sql, $dbinv);	
	
	$sql="DELETE from s_ut WHERE C_REFNO='" . trim($_GET["txtrefno"]) . "'";
	$result=mysql_query($sql, $dbinv);	
	
	$sql="DELETE from s_sttr WHERE ST_REFNO='" . trim($_GET["txtrefno"]) . "'";
	$result=mysql_query($sql, $dbinv);	
	
	$sql="DELETE from ch_sttr WHERE ST_REFNO='" . trim($_GET["txtrefno"]) . "'";
	$result=mysql_query($sql, $dbinv);	
		
	
	$sql2="insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('".trim($_GET["txtrefno"])."', '".$_SESSION["CURRENT_USER"]."', 'Utilization', 'Cancel', '".date("Y-m-d H:i:s")."', '".date("Y-m-d")."')";
	$resul2=mysql_query($sql2, $dbinv);	
	echo $sql_status;
	if ($sql_status==0){
		mysql_query("COMMIT", $dbinv);
		echo "Canceled";
	}	else {
		mysql_query("ROLLBACK", $dbinv);
		echo "Error has occures. Can't Cancel";
	}
	
}
 
?>