<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	include('connection.php');
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
		
if($_GET["Command"]=="keyset_chng")
{
	$sql="select * from dep_mas ";
	$result=mysql_query($sql, $dbacc);
	$row = mysql_fetch_array($result);
	
	$number="";
	switch ($_GET["cmbLetter"])
	{
		case "A":
			$number=$row["a"];
		case "B":
			$number=$row["b"];
		case "C":
			$number=$row["c"];
		case "D":
			$number=$row["d"];
		case "E":
			$number=$row["e"];
		case "F":
			$number=$row["f"];
		case "G":
			$number=$row["g"];
		case "H":
			$number=$row["h"];
		case "I":
			$number=$row["i"];
		case "J":
			$number=$row["j"];
		case "K":
			$number=$row["k"];
		case "L":
			$number=$row["l"];
		case "M":
			$number=$row["m"];
		case "N":
			$number=$row["n"];
		case "O":
			$number=$row["o"];
		case "P":
			$number=$row["p"];
		case "Q":
			$number=$row["q"];
		case "R":
			$number=$row["r"];
		case "S":
			$number=$row["s"];
		case "T":
			$number=$row["t"];
		case "U":
			$number=$row["u"];
		case "V":
			$number=$row["v"];
		case "W":
			$number=$row["w"];
		case "X":
			$number=$row["x"];
		case "Y":
			$number=$row["y"];																								
		case "Z":
			$number=$row["z"];	
	}
	
	$tmpinvno="00".$number;
	$lenth=strlen($tmpinvno);
			
	$invno=trim($_GET["cmbLetter"]).substr($tmpinvno, $lenth-3);
	echo $invno;
}

if($_GET["Command"]=="set_accno")
{
  if ($_GET["acc_type1"]=="true"){
	$sql="select * from dep_mas ";
	$result=mysql_query($sql, $dbacc);
	$row = mysql_fetch_array($result);
	
	$number="";
	switch ($_GET["cmbLetter"])
	{
		case "A":
			$number=$row["a"];
		case "B":
			$number=$row["b"];
		case "C":
			$number=$row["c"];
		case "D":
			$number=$row["d"];
		case "E":
			$number=$row["e"];
		case "F":
			$number=$row["f"];
		case "G":
			$number=$row["g"];
		case "H":
			$number=$row["h"];
		case "I":
			$number=$row["i"];
		case "J":
			$number=$row["j"];
		case "K":
			$number=$row["k"];
		case "L":
			$number=$row["l"];
		case "M":
			$number=$row["m"];
		case "N":
			$number=$row["n"];
		case "O":
			$number=$row["o"];
		case "P":
			$number=$row["p"];
		case "Q":
			$number=$row["q"];
		case "R":
			$number=$row["r"];
		case "S":
			$number=$row["s"];
		case "T":
			$number=$row["t"];
		case "U":
			$number=$row["u"];
		case "V":
			$number=$row["v"];
		case "W":
			$number=$row["w"];
		case "X":
			$number=$row["x"];
		case "Y":
			$number=$row["y"];																								
		case "Z":
			$number=$row["z"];	
	}
	
	$tmpinvno="00".$number;
	$lenth=strlen($tmpinvno);
			
	$invno=trim($_GET["cmbLetter"]).substr($tmpinvno, $lenth-3);
	echo $invno;
  }	
  
  if ($_GET["acc_type2"]=="true"){
	$sql="select * from dep_mas ";
	$result=mysql_query($sql, $dbacc);
	$row = mysql_fetch_array($result);
	
	$number="";
	switch ($_GET["cmbLetter"])
	{
		case "A":
			$number=$row["sub_a"];
		case "B":
			$number=$row["sub_b"];
		case "C":
			$number=$row["sub_c"];
		case "D":
			$number=$row["sub_d"];
		case "E":
			$number=$row["sub_e"];
		case "F":
			$number=$row["sub_f"];
		case "G":
			$number=$row["sub_g"];
		case "H":
			$number=$row["sub_h"];
		case "I":
			$number=$row["sub_i"];
		case "J":
			$number=$row["sub_j"];
		case "K":
			$number=$row["sub_k"];
		case "L":
			$number=$row["sub_l"];
		case "M":
			$number=$row["sub_m"];
		case "N":
			$number=$row["sub_n"];
		case "O":
			$number=$row["sub_o"];
		case "P":
			$number=$row["sub_p"];
		case "Q":
			$number=$row["sub_q"];
		case "R":
			$number=$row["sub_r"];
		case "S":
			$number=$row["sub_s"];
		case "T":
			$number=$row["sub_t"];
		case "U":
			$number=$row["sub_u"];
		case "V":
			$number=$row["sub_v"];
		case "W":
			$number=$row["sub_w"];
		case "X":
			$number=$row["sub_x"];
		case "Y":
			$number=$row["sub_y"];																								
		case "Z":
			$number=$row["sub_z"];	
	}
	
	$tmpinvno="0".$number;
	$lenth=strlen($tmpinvno);
			
	$invno=trim($_GET["txtAccCode"])."-".substr($tmpinvno, $lenth-2);
	echo $invno;
  }	
}


if($_GET["Command"]=="addchq_cash_rec")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		//$sql="delete from tmp_bank_trans where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
		//$result=mysql_query($sql, $dbacc);
		
		$sql="insert into tmp_bank_trans(entno, accno, accname, descript, amt, tmp_no) values ('".$_GET["txt_entno"]."', '".$_GET["accno"]."', '".$_GET["acc_name"]."', '".$_GET["descript"]."', '".$_GET["amt"]."', '".$_SESSION["tmp_no_banktrans"]."')";
		$result=mysql_query($sql, $dbacc);
			
			$totchq=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$sql="select * from tmp_bank_trans where tmp_no='".$_SESSION["tmp_no_banktrans"]."' ";
				$result=mysql_query($sql, $dbacc);
				while ($row = mysql_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["accno"]."</td>
					<td>".$row["accname"]."</td>
					<td>".$row["descript"]."</td>
					<td align=right>".number_format($row["amt"], 2, ".", ",")."</td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['accno']."  name=".$row['accno']." onClick=\"del_item('".$row['accno']."');\"></td></tr>";
					
					
					$totchq=$totchq+$row["amt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<chqtot><![CDATA[".$totchq."]]></chqtot>";	
			
				
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
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
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
	$result =$db->RunQuery($sql);
	
	$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'"; 
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		
		if (($row["chqdate"] < date("Y-m-d")) or ($row["chqdate"] == date("Y-m-d"))) {
			
			$date = date('Y-m-d',strtotime(date("Y-m-d").' +1 days'));
			
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
		
    	if ($invset == 0) {
        	$invset = $_GET[$chq_pay];
        	//datainvlist1.TextMatrix(j, 8) = ""
    	}
        if ($invset > 0) {
            if ($invset <= $chqbal) {
                   
                $chqbal = $chqbal - $invset;
               
			   
				$date1 = $_GET[$delidate];
				$date2 = $a_chq_date[$i];
				$diff = abs(strtotime($date2) - strtotime($date1));
				$days = floor($diff / (60*60*24));
			
				$col2=str_replace(",", "", $_GET[$invval]);
				
   				$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$invset.", ".$days.", ".$col2.", 0, '".$_SESSION["tmp_no_cashrec"]."')"; 
			//echo $sql1." 1 /";
				$result =$db->RunQuery($sql1);
               
            } else {
                if ($invset > 0) { $invset = $invset - $chqbal; }
               
				$date1 = $_GET[$delidate];
				$date2 = $a_chq_date[$i];
				$diff = abs(strtotime($date2) - strtotime($date1));
				$days = floor($diff / (60*60*24));
				
				$col2=str_replace(",", "", $_GET[$invval]);
				
				$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$chqbal.", ".$days.", ".$col2.", 0, '".$_SESSION["tmp_no_cashrec"]."')"; 
			//echo $sql1." 2 /";
				$result =$db->RunQuery($sql1);
            
				$chqbal = 0;
            	$invpos = $j;
            }
            $K = $K + 1;
            
            
        }
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
				
				
		$col2=str_replace(",", "", $_GET[$invval]);		 	
	$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', 'Cash', '".$chqdate."', '".$a_chq_bank[$i]."', ".$_GET[$cash_pay].", ".$days.", ".$col2.", 0, '".$_SESSION["tmp_no_cashrec"]."')"; 
			//echo $sql1." 3 /";
	$result =$db->RunQuery($sql1);
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
		$result =$db->RunQuery($sql);	
		while ($row = mysql_fetch_array($result)){
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
		$result1 =$db->RunQuery($sql11);
	
    } else {
       if (trim($chqno_2[$H]) != "Cash") {
        $c1_6[$H] = $_GET[$inv_balance] - $_GET[$cash_pay];
       } else {
        $c1_6[$H] = $_GET[$inv_balance];
       }
	   $sql11="update tmp_utilization set c1=".$c1_6[$H]." where id=".$id[$H]; 
	   $result1 =$db->RunQuery($sql11);
    }
 }
 $H = $H - 1;
}
$deutot = $deutot + $_GET[$inv_balance];
$S = $S + 1;
}
	
	
	
	
	
	/*		
	while ($mcou>$i){
		
			$chq_pay="chq_pay".$j;
			$invno="invno".$j;
			$delidate="delidate".$j;
			
		if ($available_inv_amt==0){
			//if ($_GET[$chq_pay]!=''){
				$available_inv_amt=$_GET[$chq_pay];
			//}	
		} 	
	
	//echo $a_chq_amt[$i] ." / ". $available_inv_amt;
	 // if ($available_inv_amt!=''){	
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
			//echo $sql1." 3 /";
			$result =$db->RunQuery($sql1);
			$available_inv_amt=0;
			
			
		}
		$j=$j+1;
		echo $available_chq_amt;
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
				//echo $sql1." 4 /"; 
				$result =$db->RunQuery($sql1);
				$available_chq_amt=0;
				
			} else if (($available_chq_amt >= $_GET[$chq_pay]) and ($available_chq_amt >0)){
				
				$available_chq_amt =$available_chq_amt - $_GET[$chq_pay];
				
				$date1 = $_GET[$delidate];
				$date2 = $a_chq_date[$i];
				$diff = abs(strtotime($date2) - strtotime($date1));
				$days = floor($diff / (60*60*24));
			
				$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$_GET[$chq_pay].", ".$days.", '".$_SESSION["tmp_no_cashrec"]."')"; 
				//echo $sql1." 5 /";
				$result =$db->RunQuery($sql1);
			}
		}
	 // }	
		
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
				echo $sql1." 6 /";
			//$result1 =$db->RunQuery($sql1);	
		}
		$i=$i+1;
	}*/
	
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
			
			include('connection.php');
			
		
		
				$sql="select bankent from dep_mas";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["bankent"];
				$lenth=strlen($tmprecno);
				$recno= $_SESSION['company'] . "/" . date("y") . "/P/" . substr($tmprecno, $lenth-7);
				$_SESSION["recno"]=$recno;
				
				$sql="select bankent from tmpdep_mas";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
				$_SESSION["tmp_no_banktrans"]=$_SESSION['company'] . "/" . date("y") . "/P/" . substr($tmprecno, $lenth-7);
				
				$sql="update tmpdep_mas set bankent=bankent+1";
				$result=mysql_query($sql, $dbacc);
				
			
			
			
		

			echo $recno;
			
		}
		
		
if($_GET["Command"]=="save_crec")
{
	include('connection.php');
	
			
	if ($_GET["txtAccCode"] == "") {
   		exit ("Entry Not Completed");
   	}
	
	$mm = "";
	
	if ($_GET["Check1"] == "true") { $mm = "C"; }
	if ($_GET["Check2"] == "true") { $mm = "B"; }

	if ($_GET["optBal"] == "true") { $optAccType = "B"; }
	if ($_GET["op_manu"] == "true") { $optAccType = "M"; }
	if ($_GET["optPLAcc"] == "true") { $optAccType = "P"; }
  
  	if (trim($_GET["txtLinkNo"]) == "") {
     	$PAccNo = "C";
  	} else {
     	$PAccNo = trim($_GET["txtLinkNo"]);
  	}
    

	$sql_rst = "Select * from lcodes  where c_code='" . trim($_GET["txtAccCode"]) . "'";
	$result_rst=mysql_query($sql_rst, $dbacc);
	if ($row_rst = mysql_fetch_array($result_rst)){
   		
		$sql_lcode="update lcodes set   c_opbal=" . $_GET["txtOpenBal"] . ", c_opbal1=" . $_GET["txtOpenBal1"] . ", cat='" . $mm . "', c_code='" . trim($_GET["txtAccCode"]) . "', c_name='" . trim($_GET["txtAccName"]) . "', c_type='" . $optAccType . "',  c_add1= '" . trim($_GET["txtAdd1"]) . "', c_add2='" . trim($_GET["txtAdd2"]) . "', c_date='" . $_GET["dtpOpenDate"] . "', c_nod_add='" . trim($_GET["txtLinkNo"]) . "', paccno='" . trim($_GET["txtLinkNo"]) . "', bud1=" . $_GET["jan"] . ", bud2=" . $_GET["feb"] . ", bud3=" . $_GET["mar"] . ", bud4=" . $_GET["apr"] . ", bud5=" . $_GET["may"] . " , bud6=" . $_GET["jun"] . ",bud7=" . $_GET["jul"] . " , bud8=" . $_GET["aug"] . ",bud9=" . $_GET["sep"] . ",bud10=" . $_GET["oct"] . ", bud11=" . $_GET["nov"] . ", bud12=" . $_GET["dec"] . " ,code1='" . trim($_GET["txtcode"]) . "' where c_code='" . trim($_GET["txtAccCode"]) . "'";
		$result_lcode=mysql_query($sql_lcode, $dbacc);
 
	} else {
		
		$sql_lcode="Insert Into lcodes(c_code, c_name, c_type,   c_add1, c_add2, c_date, cat,  paccno, bud1, bud2, bud3, bud4, bud5, bud6, bud7, bud8, bud9, bud10, bud11, bud12, c_opbal, c_opbal1, code1) Values ('" . trim($_GET["txtAccCode"]) . "', '" . trim($_GET["txtAccName"]) . "', '" . $optAccType . "',  '" . trim($_GET["txtAdd1"]) . "', '" . trim($_GET["txtAdd2"]) . "', '" . $_GET["dtpOpenDate"] . "', '" . $mm . "', '" . $PAccNo . "'," . $_GET["jan"] . " ," . $_GET["feb"] . "," . $_GET["mar"]. "," . $_GET["apr"] . "," . $_GET["may"] . "," . $_GET["jun"] . "," . $_GET["jul"] . "," . $_GET["aug"] . "," . $_GET["sep"] . "," . $_GET["oct"] . "," . $_GET["nov"] . "," . $_GET["dec"] . "," . $_GET["txtOpenBal"] . "," . $_GET["txtOpenBal1"] . ",'" . trim($_GET["txtcode"]) . "')";
		$result_lcode=mysql_query($sql_lcode, $dbacc);
		
 
	}


	$sql_lcode="delete  from ledger where l_code='" . trim($_GET["txtAccCode"]) . "' and l_flag='OPB'";
	$result_lcode=mysql_query($sql_lcode, $dbacc);
			
	$opref = "BF/" . $_SESSION['company'] . "/" . trim($_GET["txtAccCode"]);
	if ($_GET["txtOpenBal"] != 0) {
   		if ($_GET["txtOpenBal"] > 0) {
      		$LedFlag = "DEB";
   		} else {
      		$LedFlag = "CRE";
   		}
		
		$sql_lcode="insert into ledger (l_refno, l_code, l_date, l_lmem, l_amount, l_flag, l_flag1, comcode, l_yearfl) values ('" . $opref . "', '" . trim($_GET["txtAccCode"]) . "', '" . $_GET["dtpOpenDate"] . "' , 'Openning Balance'," . abs($_GET["txtOpenBal"]) . "  , 'OPB', '" . $LedFlag . "' , '" . $_SESSION['company'] . "','0')";
		$result_lcode=mysql_query($sql_lcode, $dbacc);
		
  
	}

	if ($_GET["txtOpenBal1"] != 0) {
    	$opref = "BF/" . $_SESSION['company'] . "/" . trim($_GET["txtAccCode"]);
    	if ($_GET["txtOpenBal1"] > 0) {
       		$LedFlag = "DEB";
    	} else {
       		$LedFlag = "CRE";
    	}
		
		$sql_lcode="insert into ledger (l_refno, l_code, l_date, l_lmem, l_amount, l_flag, l_flag1, comcode, l_yearfl)  values('" . $opref . "', '" . trim($_GET["txtAccCode"]) . "', '" . $_GET["dtpOpenDate"] . "' , 'Openning Balance'," . abs($_GET["txtOpenBal1"]) . "  , 'OPB', '" . $LedFlag . "' , '" . $_SESSION['company'] . "','2')";
		$result_lcode=mysql_query($sql_lcode, $dbacc);
		
   
	}
	echo  "Saved";



	
//Call CRPRINT
//Call cmdNew_Click
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
							   
                             
   							</tr>";
                           
							if ($_GET["mfield"]=="recno"){
						   		$letters = $_GET['recno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								$sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A' and CA_REFNO like  '$letters%'  ORDER BY CA_REFNO limit 50";
								$result=mysql_query($sql, $dbinv);
								
							} else if ($_GET["mstatus"]=="recdate"){
								$letters = $_GET['recdate'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A' and CA_DATE like  '$letters%'  ORDER BY CA_REFNO limit 50";
								$result=mysql_query($sql, $dbinv);
								
							}else if ($_GET["mstatus"]=="recamt"){
								$letters = $_GET['recamt'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A' and CA_AMOUNT like  '$letters%'  ORDER BY CA_REFNO limit 50";
								$result=mysql_query($sql, $dbinv);
								
							} else {
								$letters = $_GET['recno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A' and CA_REFNO like  '$letters%'  ORDER BY CA_REFNO limit 50";
								$result=mysql_query($sql, $dbinv);
							}
							
													
						
							while($row = mysql_fetch_array($sql)){
								$REF_NO = $row['CA_REFNO'];
								$stname = $_GET["mstatus"];
							$ResponseXML .= "<tr>
                           	  <td onclick=\"recno('$REF_NO');\">".$row['CA_REFNO']."</a></td>
                              <td onclick=\"recno('$REF_NO');\">".$row['CA_DATE']."</a></td>
                              <td onclick=\"recno('$REF_NO');\">".$row['CA_AMOUNT']."</a></td>
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
						   		$sql = "SELECT * from bankmas where  bcode like  '$letters%'";
								$result=mysql_query($sql, $dbinv);
							 } else if ($_GET["mfield"]=="bank"){
							 	$letters = $_GET['bank'];
						   		$sql = "SELECT * from bankmas where  bname like  '$letters%'";
								$result=mysql_query($sql, $dbinv);
							 }	
						   } 
						   
						  						
						
							while($row = mysql_fetch_array($result)){
								
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
	$result=mysql_query($sql, $dbinv);
	
	if ($row = mysql_fetch_array($result)){
		$ResponseXML .= "<bname><![CDATA[".$row["bname"]."]]></bname>";
	}
		
	
				$ResponseXML .= "</salesdetails>";

				echo $ResponseXML;
}
	

if ($_GET["Command"]=="pass_recno"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	
	//Call setGrid
	$sql_rscrec="select * from s_crec where CA_REFNO='" .$_GET["recno"]. "'";
	$result_rscrec=mysql_query($sql_rscrec, $dbinv);
	
	
	
	$sql_RSINV_CHEQ="select * from s_invcheq where refno='" .$_GET["recno"]. "'";
	$result_RSINV_CHEQ=mysql_query($sql_RSINV_CHEQ, $dbinv);
	
	$sql_rsLED="Select * from ledger where l_refno ='" .$_GET["recno"]. "'";
	$result_rsLED=mysql_query($sql_rsLED, $dbacc);
	
	if($row_rscrec = mysql_fetch_array($result_rscrec)){	
		
		$_SESSION["tmp_no_cashrecacc"]=$row_rscrec["tmp_no"];
		
		$ResponseXML .= "<Txtrecno><![CDATA[".$row_rscrec["CA_REFNO"]."]]></Txtrecno>";
		$ResponseXML .= "<txtDATE><![CDATA[".$row_rscrec["CA_DATE"]."]]></txtDATE>";
		$ResponseXML .= "<Txtcusco><![CDATA[".$row_rscrec["CA_CODE"]."]]></Txtcusco>";
    	
		$acc=0;
		$acc1=0;
		
		if($row_rsLED = mysql_fetch_array($result_rsLED)){
    		while($row_rsLED = mysql_fetch_array($result_rsLED)){
				if ($row_rsLED["l_flag1"] == "DEB") {
					$ResponseXML .= "<txt_accode><![CDATA[".$row_rsLED["l_code"]."]]></txt_accode>";
                	
					$sql_Rslcode="Select * from lcodes where c_code = '" . trim($row_rsLED["l_code"]) . "'";
					$result_Rslcode = mysql_query($sql_Rslcode, $dbacc);
					if($row_Rslcode = mysql_fetch_array($result_Rslcode)){
               			$ResponseXML .= "<txt_accname><![CDATA[".$row_Rslcode["c_name"]."]]></txt_accname>";
					}
					$acc=1;
              	} else {
					$ResponseXML .= "<txt_accode1><![CDATA[".$row_rsLED["l_code"]."]]></txt_accode1>";
                	
					$sql_Rslcode="Select * from lcodes where c_code = '" . trim($row_rsLED["l_code"]) . "'";
					$result_Rslcode = mysql_query($sql_Rslcode, $dbacc);
					if($row_Rslcode = mysql_fetch_array($result_Rslcode)){
               			$ResponseXML .= "<txt_accname1><![CDATA[".$row_Rslcode["c_name"]."]]></txt_accname1>";
					}
					$acc1=1;
               	}
			}	
		} else {
			$ResponseXML .= "<txt_accode><![CDATA[]]></txt_accode>";
			$ResponseXML .= "<txt_accname><![CDATA[]]></txt_accname>";
			$ResponseXML .= "<txt_accode1><![CDATA[]]></txt_accode1>";
			$ResponseXML .= "<txt_accname1><![CDATA[]]></txt_accname1>";
			$acc=1;
			$acc1=1;
		}
		
		if ($acc==0){
			$ResponseXML .= "<txt_accode><![CDATA[]]></txt_accode>";
			$ResponseXML .= "<txt_accname><![CDATA[]]></txt_accname>";
		}
		
		if ($acc1==0){
			$ResponseXML .= "<txt_accode1><![CDATA[]]></txt_accode1>";
			$ResponseXML .= "<txt_accname1><![CDATA[]]></txt_accname1>";
		}
		
    	$ResponseXML .= "<Txtcusco><![CDATA[".$row_rscrec["CA_CODE"]."]]></Txtcusco>";
		
    	$sql_RSCUS="SELECT * FROM vendor WHERE CODE='" . $row_rscrec["CA_CODE"] . "'";
		$result_RSCUS=mysql_query($sql_RSCUS, $dbinv);
		if($row_RSCUS = mysql_fetch_array($result_RSCUS)){
   			if (is_null($row_RSCUS["NAME"])==false) { 
				$ResponseXML .= "<txtcusname><![CDATA[".$row_RSCUS["NAME"]."]]></txtcusname>";
			} else {
				$ResponseXML .= "<txtcusname><![CDATA[]]></txtcusname>";
			}	
    	} else {
			$ResponseXML .= "<txtcusname><![CDATA[]]></txtcusname>";
		}	
		
		if (is_null($row_rscrec["CA_CASSH"])==false){
			$ResponseXML .= "<txtcash><![CDATA[".number_format($row_rscrec["CA_CASSH"], 2, ".", ",")."]]></txtcash>";
		} else {
			$ResponseXML .= "<txtcash><![CDATA[]]></txtcash>";
		}	
		
		if (is_null($row_rscrec["CA_AMOUNT"])==false){
			$chtot=$row_rscrec["CA_AMOUNT"] - $row_rscrec["CA_CASSH"];
			$ResponseXML .= "<Txtchtot><![CDATA[".number_format($chtot, 2, ".", ",")."]]></Txtchtot>";
		} else {
			$ResponseXML .= "<Txtchtot><![CDATA[]]></Txtchtot>";
		}
		
		if (is_null($row_rscrec["CA_CASSH"])==false){
			$ResponseXML .= "<txtpaytot><![CDATA[".number_format($row_rscrec["CA_AMOUNT"], 2, ".", ",")."]]></txtpaytot>";
		} else {
			$ResponseXML .= "<txtpaytot><![CDATA[]]></txtpaytot>";
		}
    
    	$k = 1;
		
		$sql1="delete from tmp_cash_chq where tmp_no= '".$_SESSION["tmp_no_cashrecacc"]."'";
		
		$result1=mysql_query($sql1, $dbacc);
			
		$sql_rs="Select chno, l_date, l_code, l_amount, l_lmem, l_bank, chno from ledger where l_flag1='DEB' and l_refno ='" . trim($_GET["recno"]) . "' order by id";
		$result_rs=mysql_query($sql_rs, $dbacc);
		while($row_rs = mysql_fetch_array($result_rs)){
			   
    		$sql1="insert into tmp_cash_chq(recno, chqno, chqdate, chqbank, chqamt, tmp_no) values ('".$_GET["recno"]."', '".$row_rs["chno"]."', '".$row_rs["l_date"]."', '".$row_rs["l_bank"]."', ".$row_rs["l_amount"].", '".$_SESSION["tmp_no_cashrecacc"]."')";
			$result1=mysql_query($sql1, $dbacc);
		}		
		
	
		$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
		$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrecacc"]."' ";
		$result=mysql_query($sql, $dbacc);
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
	}	
		$ResponseXML .= "</salesdetails>";

				echo $ResponseXML;
		
}



if ($_GET["Command"]=="delete_rec"){
	$ResponseXML = "";
	
	if ($_GET["invdate"]==date("Y-m-d")){
		
		 mysql_query("START TRANSACTION", $dbacc);
         
		 $sql="Update bankentmas set cancel='1' where refno = '" . trim($_GET["txt_entno"]) . "'";
		 $result=mysql_query($sql, $dbacc);
		 
		 $sql="Delete  from ledger where l_refno = '" . trim($_GET["txt_entno"]) . "'";
		 $result=mysql_query($sql, $dbacc);
		 
		
	
		 mysql_query("COMMIT", $dbacc);
        
         //echo "Reciept Canceled";
         //Call cmdNew_Click
			
			
			$ResponseXML = "Reciept Canceled";
		
	} else {
		$ResponseXML = "Sorry Cant Cancel.... please check reciept date";
	}

	echo $ResponseXML;

}
?>