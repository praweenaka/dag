<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	include('connection.php');
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
		
if($_GET["Command"]=="get_bank")
{
	$sql="select * from bankmas where bcode='".$_GET["bankcode"]."'";
	$result=mysql_query($sql, $dbinv);
	if ($row = mysql_fetch_array($result)){
		echo $row["bname"];
	}
}


if($_GET["Command"]=="addchq_cash_rec1")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		$sql="delete from tmp_bankdepo_account where accno='".$_GET["accno1"]."' and tmp_no='".$_SESSION["tmp_no_journal_acc"]."'";
		$result=mysql_query($sql, $dbacc);
		
		$sql="insert into tmp_bankdepo_account(entno, accno, accname, descript, amt, tmp_no) values ('".$_GET["txt_entno"]."', '".$_GET["accno1"]."', '".$_GET["acc_name1"]."', '".$_GET["descript1"]."', ".$_GET["amt1"].", '".$_SESSION['tmp_no_bankdepo_acc']."')";
		$result=mysql_query($sql, $dbacc);
			
			$totamt=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$sql="select * from tmp_bankdepo_account where tmp_no='".$_SESSION["tmp_no_journal_acc"]."' ";
				$result=mysql_query($sql, $dbacc);
				while ($row = mysql_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["accno"]."</td>
					<td>".$row["accname"]."</td>
					<td>".$row["descript"]."</td>
					<td align=right>".number_format($row["amt"], 2, ".", ",")."</td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['accno']."  name=".$row['accno']." onClick=\"del_item('".$row['accno']."');\"></td></tr>";
					
					
					$totamt=$totamt+$row["amt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<totamt><![CDATA[".$totamt."]]></totamt>";		
				
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;			
}

if($_GET["Command"]=="addchq_cash_rec2")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		$sql="delete from tmp_bankdepo_chq where chqno='".$_GET["chqno"]."' and tmp_no='".$_SESSION["tmp_no_journal_acc"]."'";
		$result=mysql_query($sql, $dbacc);
		
		$sql="insert into tmp_bankdepo_chq(id, entno, chqno, chqdate, narration, bank, amt, tmp_no) values ('".$_GET["id"]."', '".$_GET["txt_entno"]."', '".$_GET["chqno"]."', '".$_GET["chqdate"]."', '".$_GET["narration"]."', '".$_GET["bank"]."', ".$_GET["chqamt"].", '".$_SESSION['tmp_no_bankdepo_acc']."')";
		$result=mysql_query($sql, $dbacc);
			
			$totamt=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					<td width=\"0\"  background=\"images/headingbg.gif\"></td>
					</tr>";
				
				$sql="select * from tmp_bankdepo_chq where tmp_no='".$_SESSION['tmp_no_bankdepo_acc']."' ";
				$result=mysql_query($sql, $dbacc);
				while ($row = mysql_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["chqno"]."</td>
					<td>".$row["chqdate"]."</td>
					<td>".$row["narration"]."</td>
					<td>".$row["bank"]."</td>
					<td>".$row["id"]."</td>
					<td align=right>".number_format($row["amt"], 2, ".", ",")."</td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['chqno']."  name=".$row['chqno']." onClick=\"del_item('".$row['chqno']."');\"></td></tr>";
					
					
					$totamt=$totamt+$row["amt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<totamt><![CDATA[".$totamt."]]></totamt>";		
				
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;			
}


if($_GET["Command"]=="addchq_cash_rec3")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		$sql="delete from tmp_bankdepo_depo where accno='".$_GET["accno1"]."' and tmp_no='".$_SESSION['tmp_no_bankdepo_acc']."'";
		$result=mysql_query($sql, $dbacc);
		
		$sql="insert into tmp_bankdepo_depo(entno, accno, accname, descript, amt, tmp_no) values ('".$_GET["txt_entno"]."', '".$_GET["accno1"]."', '".$_GET["acc_name1"]."', '".$_GET["descript1"]."', ".$_GET["amt1"].", '".$_SESSION['tmp_no_bankdepo_acc']."')";
		$result=mysql_query($sql, $dbacc);
			
			$totamt=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$sql="select * from tmp_bankdepo_account where tmp_no='".$_SESSION['tmp_no_bankdepo_acc']."' ";
				$result=mysql_query($sql, $dbacc);
				while ($row = mysql_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["accno"]."</td>
					<td>".$row["accname"]."</td>
					<td>".$row["descript"]."</td>
					<td align=right>".number_format($row["amt"], 2, ".", ",")."</td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['accno']."  name=".$row['accno']." onClick=\"del_item('".$row['accno']."');\"></td></tr>";
					
					
					$totamt=$totamt+$row["amt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<totamt><![CDATA[".$totamt."]]></totamt>";		
				
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;			
}


if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			$sql="delete from tmp_cash_pay where accno='".$_GET["accno"]."' and tmp_no='".$_SESSION["tmp_no_journal_acc"]."'";
			$result=mysql_query($sql, $dbacc);
			
			
			$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
							
			$totamt=0;
			$sql="select * from tmp_cash_pay where tmp_no='".$_SESSION["tmp_no_cashpayacc"]."' ";
				$result=mysql_query($sql, $dbacc);
				while ($row = mysql_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["accno"]."</td>
					<td>".$row["accname"]."</td>
					<td>".$row["descript"]."</td>
					<td align=right>".number_format($row["amt"], 2, ".", ",")."</td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['accno']."  name=".$row['accno']." onClick=\"del_item('".$row['accno']."');\"></td></tr>";
					
					
					$totamt=$totamt+$row["amt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<totamt><![CDATA[".$totamt."]]></totamt>";	
				
				
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


		if($_GET["Command"]=="set_chno")
		{
			
			include('connection.php');
			
			$macccode = trim($_GET["com_cas"]);
				$sql="Select * from bankmaster where bm_code='" . $macccode . "'";
				
				$result=mysql_query($sql, $dbacc);
				if ($row = mysql_fetch_array($result)){
					if (is_null($row["bm_chno"])==false) { 
						$tmprecno="000000".$row["bm_chno"];
						$lenth=strlen($tmprecno);
						$recno=substr($tmprecno, $lenth-7);
						
						echo  $recno;	
					}	
				}
				
		}
			

		if($_GET["Command"]=="new_rec")
		{
			
			include('connection.php');
			
			

			$sql="select * from dep_mas";
			$result=mysql_query($sql, $dbacc);
			$row = mysql_fetch_array($result);
			$tmprecno="000000".$row["bankdep"];
			$lenth=strlen($tmprecno);
			$recno= $_SESSION['company'] . "/" . date("y") . "/R/" . substr($tmprecno, $lenth-7);
			
			


			$sql="SELECT bankdep FROM  tmpdep_mas";
			$result=mysql_query($sql, $dbacc);
			$row = mysql_fetch_array($result);
			$tmprecno="000000".$row["bankdep"];
			$lenth=strlen($tmprecno);
			$_SESSION["tmp_no_bankdepo_acc"]=$_SESSION['company'] . "/" . date("y") . "/R/" . substr($tmprecno, $lenth-7);
			
			$sql="update tmpdep_mas set bankdep=bankdep+1";
			$result=mysql_query($sql, $dbacc);
			
			$_SESSION["txt_stat"]="new";
			echo $recno;
			
		}
		
		
if($_GET["Command"]=="save_crec")
{
	include('connection.php');
	
	//$ResponseXML = "";
	//$ResponseXML .= "<salesdetails>";
	
	
	
	if ($_SESSION["m_stat"] == "new") {
		
		$sql="select * from dep_mas";
		$result=mysql_query($sql, $dbacc);
		$row = mysql_fetch_array($result);
		$tmprecno="000000".$row["bankdep"];
		$lenth=strlen($tmprecno);
		$recno= $_SESSION['company'] . "/" . date("y") . "/R/" . substr($tmprecno, $lenth-7);
			
		$sql="update dep_mas set bankdep=bankdep+1 where code'".$_SESSION['company']."'";
		$result=mysql_query($sql, $dbacc);
			 
	}		
	
	//////////////////
 		
        
		//Call SETTOTAL
		if (($_SESSION["m_stat"] == "new") or ($_SESSION["m_stat"] == "edit")) {
		} else {
   			exit ("Invalid Option, Please Select Option 'New' and Save Entry");
   		}
		
		if ($_GET["totval"] != $_GET["txtCreTot"]) {
   			exit ("Cheque Deposit Account Total and ,Cheque Total Not Tallying");
   		}

		
		

		if ($_GET["txt_entno"] == "") { $m_ok = "Reference No Not Entered"; }
		if (($_GET["txtCreTot"] == 0) and ($_GET["txtDebTot"] == 0) and ($_GET["txtcash"] == 0)) { $m_ok = "Entry Is Incomplete"; }

       
      
  
   		mysql_query("START TRANSACTION", $dbacc); 
   		
		$sql="Delete from bankdepmas where refno = '" . $_GET["txt_entno"] . "'";
		$result=mysql_query($sql, $dbacc);
		
  		$sql_rsBANKDEPTRNp="select * from bankdeptrn where refno = '" . $_GET["txt_entno"] . "'";
		$result_rsBANKDEPTRNp=mysql_query($sql_rsBANKDEPTRNp, $dbacc);
		$row_rsBANKDEPTRNp = mysql_fetch_array($result_rsBANKDEPTRNp);
              
     	$m_flag1 = "";
  		
		$sql_rst="select * from ledger where l_refno = '" . $_GET["txt_entno"] . "'";
		$result_rst=mysql_query($sql_rst, $dbacc);
		while ($row_rst = mysql_fetch_array($result_rst)) {
			$m_amount = $row_rst["l_amount"];
        	$m_account = $row_rst["l_code"];
        	
			if (is_null($row_rst["l_flag1"]) == false) { $m_flag1 = $row_rst["l_flag1"]; }
        	$m_flag1 = "";
		}
		
		$sql_rst="Delete   from ledger where l_refno = '" . $_GET["txt_entno"] . "'";
		$result_rst=mysql_query($sql_rst, $dbacc);
		
		$sql_rst="Delete   from bankdeptrn where refno = '" . $_GET["txt_entno"] . "'";
		$result_rst=mysql_query($sql_rst, $dbacc);
   
   
   		$m_ok = "";
   
       
       if ($m_ok == "") {
        
            
            if (trim($_GET["TXT_HEADING"]) != "") { $mHead = trim($_GET["TXT_HEADING"]); }
            if (trim($_GET["txtBankCode"]) != "") { $mCode = trim($_GET["Com_bank"]); }
            if (trim($_GET["Com_bank"]) != "") { $mName = trim($_GET["Com_bank"]); }
            if ($_GET["totval"] > 0) { $mAmount = $_GET["totval"]; }
            if ($_GET["txtcash"] > 0) { $mCash = $_GET["txtcash"]; }
            $mAmount = $_GET["totval"];
       		
			$sql_rst="Insert into bankdepmas (refno, bdate, heading, code, name, amount, cash, comcode) Values ('" . trim($_GET["txt_entno"]) . "', '" . $_GET["Calendar1"] . "', '" . $mHead . "', '" . $mCode . "', '" . $mName . "', " . mAmount . ", " . $mCash . ",'" . $_SESSION['company'] . "' )";
			$result_rst=mysql_query($sql_rst, $dbacc);
		
                 
            if ($_GET["txtCreTot"] > 0 ){ $mAmount = $_GET["TXT_DEBTOT"];
           
            
            
            if (is_null(trim($_GET["TXT_HEADING"]))==false) { $mHead = trim($_GET["TXT_HEADING"]); }
            if (is_null(trim($m_nara))==false) { $mNara = trim($m_nara); }
       
              
            $sql_rst="select * from tmp_bankdepo_account where tmp_no='".$_SESSION['tmp_no_bankdepo_acc']."'";
			$result_rst=mysql_query($sql_rst, $dbacc);
            while ($row_rst = mysql_fetch_array($result_rst)) {
            
                $mCode = $row_rst["accno"];
                $mHead = $row_rst["accname"];
                $mNara = $row_rst["descript"];
                $mAmount = $row_rst["amt"];
                if (($mCode != "") and ($mAmount != 0)) {
                     $sql="Insert into bankdeptrn(refno, bdate, code, amount, flag, nara, comcode) Values ('" . trim($_GET["txt_entno"]) . "', '" . $_GET["Calendar1"] . "', '" . trim($mCode) . "', " . $mAmount . ", 'CRE', '" . trim($mNara) . "' ,'" . $_SESSION['company'] . "')";
					$result=mysql_query($sql, $dbacc);
					
				
                            
                    if ($_GET["txtDebTot"]) > 0) { $mAmount = $mAmount; }
                    
                    if (is_null(trim($mNara))==false) { $mNara = trim($mNara); }
                    if (is_null(trim($_GET["TXT_HEADING"]))==false) { $mHead = trim($_GET["TXT_HEADING"]); }
                    
                   
					
            		$sql="Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1,  l_lmem, l_head, l_bank, comcode) Values ( '" . trim($_GET["txt_entno"]) . "', '" . $_GET["Calendar1"] . "', '" . trim($mCode) . "', " . $mAmount . ", 'BDE', 'CRE', '" . $mNara . "', '" . $mHead . "', '" . trim($_GET["txtBankCode"]) . "',  '" . $_SESSION['company'] . "' )";
					$result=mysql_query($sql, $dbacc);
                }
               
                
            }
            
            $sql="delete   from bankdepche  where refno='" . trim($_GET["txt_entno"]) . " '";
			$result=mysql_query($sql, $dbacc);
			
           
            
            $mAmount = 0;
			$sql_rst="select * from tmp_bankdepo_chq where tmp_no='".$_SESSION['tmp_no_bankdepo_acc']."'";
			$result_rst=mysql_query($sql_rst, $dbacc);
            while ($row_rst = mysql_fetch_array($result_rst)) {
                                         
                $mAmount = $row_rst["amt"];
                
                if (($row_rst["entno"] != "") and ($row_rst["amt"] > 0)) {
                    
					$sql="Insert into bankdeptrn(refno, bdate, code, amount, flag, comcode) Values ('" . trim($_GET["txt_entno"]) . "', '" . $_GET["Calendar1"] . "', '" . trim($_GET["txtBankCode"]) . "', " . $mAmount . ", 'DEB','" . $_SESSION['tmp_no_bankdepo_acc'] . "' )";
					$result=mysql_query($sql, $dbacc);
                                       
                  
                    if ($row_rst["id"] != "") {
						$sql="Update s_invcheq  set ret_refno='" . trim($_GET["txt_entno"]) . "' where id=" . $row_rst["id"] . "";
						$result=mysql_query($sql, $dbacc);
                    
                    }
                    
					$sql="Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_flag2, l_flag3, l_flag4, l_bank, l_head, l_lmem, rights, chno, comcode) Values ('" . trim($_GET["txt_entno"]) . "', '" . $_GET["Calendar1"] . "', '" . trim($_GET["txtBankCode"]) . "', " . $mAmount . ", 'BDE', 'DEB', '0', 'R', 'CHQ', '" . trim($_GET["txtBankCode"]) . "', '" . trim($_GET["TXT_HEADING"]) . "', '" . trim($row_rst["narration"]) . "', '" . $mUserWrite . "', '" . $row_rst["chqno"] . "','" . $_SESSION['company'] . "')";
					$result=mysql_query($sql, $dbacc);     
					
					$sql="Insert into bankdepche(refno, cheno, bdate, ven_code, ven_name, bank, amount ,comcode  ) Values ('" . trim($_GET["txt_entno"]) . "', '" . $row_rst["chqno"] . "', '" . $_GET["Calendar1"] . "', '" . $row_rst["narration"] . "', '" . $row_rst["narration"] . "', '" . $row_rst["bank"] . "', " . $mAmount . ",'" . $_SESSION['company'] . "' )";
					$result=mysql_query($sql, $dbacc);             
                                                  
            
                    
            
                }
                
                
            }
            
           
            
            $sql_rst="select * from tmp_bankdepo_depo where tmp_no='".$_SESSION['tmp_no_bankdepo_acc']."'";
			$result_rst=mysql_query($sql_rst, $dbacc);
            while ($row_rst = mysql_fetch_array($result_rst)) {
            
                $mCode = $row_rst["accno"];
                $mHead = $row_rst["accname"];
                $mNara = $row_rst["descript"];
                $mAmount = $row_rst["amt"];
                if (($mCode != "") and ($mAmount != 0)) {
				
					$sql="Insert into bankdeptrn(refno, bdate, code, amount, flag, nara, flag1, comcode) Values ('" . trim($_GET["txt_entno"]) . "', '" . $_GET["Calendar1"] . "', '" . trim($mCode) . "', " . $mAmount . ", 'DEB', '" . trim($mNara) . "', 'CASH',  '" . $_SESSION['company'] . "')";
					$result=mysql_query($sql, $dbacc);      
                    
                            
                    if ($_GET["txtcash"] > 0) { $mAmount = $mAmount; }
                    
                    if (is_null(trim($mNara))==false) { $mNara = trim($mNara); }
                    if (is_null(trim($_GET["TXT_HEADING"]))==false ) { $mHead = trim($_GET["TXT_HEADING"]); }
             		
					$sql="Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem, l_head, l_bank, rights, comcode) Values ('" . trim($_GET["txt_entno"]) . "', '" . $_GET["Calendar1"] . "', '" . trim($mCode) . "', " . $mAmount . ", 'BDE', 'CRE', '" . $mNara . "', '" . $mHead . "', '" . trim($_GET["txtBankCode"]) . "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "')";
					$result=mysql_query($sql, $dbacc);    
					
					$sql="Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_flag2, l_flag3, l_flag4, l_lmem, l_head, l_bank, rights, comcode, chno) Values ('" . trim($_GET["txt_entno"]) . "', '" . $_GET["Calendar1"] . "', '" . trim($_GET["txtBankCode"]) . "', " . $mAmount . ", 'BDE', 'DEB', '0', 'R', 'CAS', '" . $mNara . "', '" . $mHead . "', '" . trim($_GET["txtBankCode"]) . "', '" . $mUserWrite . "', '" . $_SESSION['company'] . "','Cash')";
					$result=mysql_query($sql, $dbacc);    
					
                    
                    
                }
                
            }
           
           
           
       }
       
   if ($_SESSION["m_stat"] == "new") {
   
   		$sql="Update dep_mas set bankdep= bankdep + 1 where code='" . $_SESSION['company'] . "'";
		$result=mysql_query($sql, $dbacc);  
					
		$sql="Update bankmaster set dep_no= dep_no + 1 where bm_code='" . $_GET["txtBankCode"] . "'";
		$result=mysql_query($sql, $dbacc);  			
   }
       
      
         

        mysql_query("COMMIT", $dbacc); 

        echo  "Records are saved";
       
         
     
     
}
	////////////		
	

if ($_GET["Command"]=="vou_print_las"){

	include('connection.php');
	
	$sql_rsPrInv="select * from ledger where l_refno='" . $_GET["txt_entno"] . "' and l_flag1='DEB'";
	$result_rsPrInv=mysql_query($sql_rsPrInv, $dbacc);
	$ii = 1;
	while($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
		if ($ii == 1) {
      		$txtacc1= number_format($row_rsPrInv["l_amount"], 2, ".", ",");
   		}
   		if ($ii == 2) {
      		$txtacc2= number_format($row_rsPrInv["l_amount"], 2, ".", ",");
   		}
		if ($ii == 3) {
      		$txtacc3= number_format($row_rsPrInv["l_amount"], 2, ".", ",");
   		}
		if ($ii == 4) {
      		$txtacc4= number_format($row_rsPrInv["l_amount"], 2, ".", ",");
   		}
		if ($ii == 5) {
      		$txtacc5= number_format($row_rsPrInv["l_amount"], 2, ".", ",");
   		}
		if ($ii == 6) {
      		$txtacc6= number_format($row_rsPrInv["l_amount"], 2, ".", ",");
   		}
		if ($ii == 7) {
      		$txtacc7= number_format($row_rsPrInv["l_amount"], 2, ".", ",");
   		}
		if ($ii == 8) {
      		$txtacc8= number_format($row_rsPrInv["l_amount"], 2, ".", ",");
   		}
   		
   		$ii = $ii + 1;
	
	}
	
	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
	$ResponseXML .= "<txtacc1><![CDATA[".$txtacc1."]]></txtacc1>";
	$ResponseXML .= "<txtacc2><![CDATA[".$txtacc2."]]></txtacc2>";
	$ResponseXML .= "<txtacc3><![CDATA[".$txtacc3."]]></txtacc3>";
	$ResponseXML .= "<txtacc4><![CDATA[".$txtacc4."]]></txtacc4>";
	$ResponseXML .= "<txtacc5><![CDATA[".$txtacc5."]]></txtacc5>";
	$ResponseXML .= "<txtacc6><![CDATA[".$txtacc6."]]></txtacc6>";
	$ResponseXML .= "<txtacc7><![CDATA[".$txtacc7."]]></txtacc7>";
	$ResponseXML .= "<txtacc8><![CDATA[".$txtacc8."]]></txtacc8>";
	$ResponseXML .= "</salesdetails>";

	echo $ResponseXML;
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
		
		$sql1="delete from tmp_cash_chq where tmp_no= '".$_SESSION["tmp_no_cashrecacc"]."')";
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
				
		$sql="select * from tmp_cash_chq where recno='".$_GET["recno"]."' ";
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
         
		
		 $sql="Update BANKDEPMAS set Cancel = '1' where refno='" .  trim($_GET["txt_entno"])  . "'";
		 $result=mysql_query($sql, $dbacc);
		 
		 $sql="Delete  from ledger where l_refno ='" .  trim($_GET["txt_entno"])  . "'";
		 $result=mysql_query($sql, $dbacc);
		 
		  $sql="Update s_invcheq  set ret_refno='0' where ret_refno='" .  trim($_GET["txt_entno"])  . "'";
		 $result=mysql_query($sql, $dbacc);
		 
		mysql_query("COMMIT", $dbacc); 
			
			$ResponseXML = " Canceled";
		
	} else {
		$ResponseXML = "Sorry Cant Cancel.... please check reciept date";
	}

	echo $ResponseXML;

}
?>