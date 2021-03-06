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


if($_GET["Command"]=="addchq_cash_rec")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		$sql="delete from tmp_cash_chq where chqno='".$_GET["chqno"]."' and tmp_no='".$_SESSION["tmp_no_cashrecacc"]."'";
		$result=mysql_query($sql, $dbacc);
		
		$sql="insert into tmp_cash_chq(recno, chqno, chqdate, chqbank, chqamt, tmp_no) values ('".$_GET["invno"]."', '".$_GET["chqno"]."', '".$_GET["chqdate"]."', '".$_GET["bank"]."', '".$_GET["chqamt"]."', '".$_SESSION["tmp_no_cashrecacc"]."')";
		$result=mysql_query($sql, $dbacc);
			
			$totchq=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
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
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
			if ($_SESSION['company']=="TH"){		
				$sql="select rec_no from accpara";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["rec_no"];
				$lenth=strlen($tmprecno);
				$recno=trim("ACC/THT/ ").substr($tmprecno, $lenth-7);
				$_SESSION["recno"]=$recno;
				
				$sql="select rec_no from tmpaccpara";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
				$_SESSION["tmp_no_cashrecacc"]="ACC/THT/ ".$row["rec_no"];
				
				$sql="update tmpaccpara set rec_no=rec_no+1";
				$result=mysql_query($sql, $dbacc);
				
			}	
			
			if ($_SESSION['company']=="BEN"){		
				$sql="select rec_no from accpara";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["rec_no"];
				$lenth=strlen($tmprecno);
				$recno=trim("ACC/BEN/ ").substr($tmprecno, $lenth-7);
				$_SESSION["recno"]=$recno;
				
				$sql="select rec_no from tmpaccpara";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
				$_SESSION["tmp_no_cashrecacc"]="ACC/BEN/ ".$row["rec_no"];
				
				$sql="update tmpaccpara set rec_no=rec_no+1";
				$result=mysql_query($sql, $dbacc);
				
			}	
			
			$sql="delete from tmp_cash_chq where recno='".$recno."'";
			$result=mysql_query($sql, $dbacc);
		
			$ResponseXML .= "<recno><![CDATA[".$recno."]]></recno>";	
			
			$sql1="Select code,name from vendor where code = 'ACC'";
			$result1=mysql_query($sql1, $dbinv);
			if ($row1 = mysql_fetch_array($result1)){
				$ResponseXML .= "<code><![CDATA[".$row1["code"]."]]></code>";	
				$ResponseXML .= "<name><![CDATA[".$row1["name"]."]]></name>";	
			}
				
			$ResponseXML .= "</salesdetails>";

			echo $ResponseXML;
			
		}
		
		
if($_GET["Command"]=="save_crec")
{
	include('connection.php');
	
	$dev = 0;
	
			if ($_SESSION['company']=="TH"){		
				$sql="select rec_no from accpara";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["rec_no"];
				$lenth=strlen($tmprecno);
				$recno=trim("ACC/THT/ ").substr($tmprecno, $lenth-7);
				$_SESSION["recno"]=$recno;
				
			}	
			
			if ($_SESSION['company']=="BEN"){		
				$sql="select rec_no from accpara";
				$result=mysql_query($sql, $dbacc);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["rec_no"];
				$lenth=strlen($tmprecno);
				$recno=trim("ACC/BEN/ ").substr($tmprecno, $lenth-7);
				$_SESSION["recno"]=$recno;
				
			}	
			
	$sql="select * from s_crec where CA_REFNO='" . trim($recno) . "'";
	$result=mysql_query($sql, $dbinv);
	if ($row = mysql_fetch_array($result)){
		exit("Reciept No Already Saved");
	}
	
	if (trim($recno)==""){
		exit("Reciept No Not Found");
	}	
	
	if ((trim($_GET["txt_accode"])=="") or (trim($_GET["txt_accode1"])=="")){
		exit("Account Not Selected");
	}	
	
	if ($_GET["txtpaytot"]!=""){
		$txtpaytot=$_GET["txtpaytot"];
	} else {
		$txtpaytot=0;
	}
	
			
			
	
	$sql="insert into recmas(refno, bdate, amount, type) values ('".trim($recno)."', '".$_GET["txtDATE"]."', ".$txtpaytot.", 'D')";
	
	$result=mysql_query($sql, $dbacc);
	
	$l_lmem = "Cash/Cheque recieved from " . trim($_GET["txtcusname"]);
	
	$sql="insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem) values ('".trim($recno)."', '".$_GET["txtDATE"]."', '". trim($_GET["txt_accode1"])."', ".$txtpaytot.", 'REC', 'CRE', '".$l_lmem."')";
	
	$result=mysql_query($sql, $dbacc);
	
	
	$sql="insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem) values ('".trim($recno)."', '".$_GET["txtDATE"]."', '". trim($_GET["txt_accode"])."', ".$txtpaytot.", 'REC', 'DEB', '".$l_lmem."')";
	
	$result=mysql_query($sql, $dbacc);
	
	$sql="insert into cashrectrn(refno, bdate, code, amount) values ('".trim($recno)."', '".$_GET["txtDATE"]."', '". trim($_GET["txt_accode"])."', ".$txtpaytot.")";
	
	$result=mysql_query($sql, $dbacc);
	
	
	mysql_query("START TRANSACTION", $dbinv);
	
	$sql="insert into s_crec(CA_REFNO, CA_DATE, CA_CODE, CA_CASSH, CA_AMOUNT, DEV, FLAG, pay_type, DEPARTMENT, CANCELL, tmp_no) values ('".trim($recno)."', '".$_GET["txtDATE"]."', '". trim($_GET["Txtcusco"])."', ".$_GET["txtcash"].", ".$_GET["txtpaytot"].", '".$dev."', 'REC-A', '".$_GET["CMBPAYTYPE"]."', 'A', '0', '".$_SESSION["tmp_no_cashrecacc"]."')";
	
	$result=mysql_query($sql, $dbinv);
	
	
	$sql1="Select CO_CHNO, MA_CHNO, RET_CHNO from invpara";
	$result1=mysql_query($sql1, $dbinv);
	$row1 = mysql_fetch_array($result1);
	$mno = $row1["CO_CHNO"];
   
	$sql1="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrecacc"]."'";
	$result1=mysql_query($sql1, $dbacc);
	while ($row1 = mysql_fetch_array($result1)){
		
		$serino="C".$mno;
		
		$sql="insert into s_invcheq(refno, Sdate, cus_code, CUS_NAME, cheque_no, che_date, bank, che_amount, dev, sal_ex, trn_type, ex_flag, SERI_NO) values ('".trim($recno)."', '".$_GET["txtDATE"]."', '". trim($_GET["Txtcusco"])."', '". trim($_GET["txtcusname"])."', '".$row1["chqno"]."', '".$row1["chqdate"]."', '".$row1["chqbank"]."', '".$row1["chqamt"]."', '".$dev."', '', 'REC-A', 'N', '".$serino."')";
		
		$result=mysql_query($sql, $dbinv);
		
		$mno=$mno+1;
	}	
	
	$sql="update accpara set rec_no=rec_no+1";
	$result=mysql_query($sql, $dbacc);

	mysql_query("COMMIT", $dbinv);
	
	//print_inv($recno, $_GET["txtDATE"], $txtpaytot);
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
	$result_rsLED1=mysql_query($sql_rsLED, $dbacc);
	
	if($row_rscrec = mysql_fetch_array($result_rscrec)){	
		
		$_SESSION["tmp_no_cashrecacc"]=$row_rscrec["tmp_no"];
		
		$ResponseXML .= "<Txtrecno><![CDATA[".$row_rscrec["CA_REFNO"]."]]></Txtrecno>";
		$ResponseXML .= "<txtDATE><![CDATA[".$row_rscrec["CA_DATE"]."]]></txtDATE>";
		$ResponseXML .= "<Txtcusco><![CDATA[".$row_rscrec["CA_CODE"]."]]></Txtcusco>";
    	
		$acc=0;
		$acc1=0;
		
		if($row_rsLED1 = mysql_fetch_array($result_rsLED1)){
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
			
		//$sql_rs="Select chno, l_date, l_code, l_amount, l_lmem, l_bank, chno from ledger where l_flag1='DEB' and l_refno ='" . trim($_GET["recno"]) . "' order by id";
		$sql_rs="select * from s_invcheq where refno='" . trim($_GET["recno"]) . "' order by ID";
		$result_rs=mysql_query($sql_rs, $dbinv);
		while($row_rs = mysql_fetch_array($result_rs)){
			   
    		$sql1="insert into tmp_cash_chq(recno, chqno, chqdate, chqbank, chqamt, tmp_no) values ('".$_GET["recno"]."', '".$row_rs["cheque_no"]."', '".$row_rs["che_date"]."', '".$row_rs["bank"]."', ".$row_rs["che_amount"].", '".$_SESSION["tmp_no_cashrecacc"]."')";
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
					<td>".date("Y-m-d", strtotime($row["chqdate"]))."</td>
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
		
		 mysql_query("START TRANSACTION", $dbinv);
         
		 $sql="delete s_crec where  CA_REFNO='" . trim($_GET["Txtrecno"]) . "'";
		 $result=mysql_query($sql, $dbinv);
		 
		 $sql="DELETE s_sttr  where  ST_REFNO='" . trim($_GET["Txtrecno"]) . "'";
		 $result=mysql_query($sql, $dbinv);
		 
		 $sql="DELETE s_led WHERE REF_NO='" . trim($_GET["Txtrecno"]) . "'";
		 $result=mysql_query($sql, $dbinv);
		 
		 $sql="DELETE s_invcheq WHERE refno='" . trim($_GET["Txtrecno"]) . "'";
		 $result=mysql_query($sql, $dbinv);
		 
		 $sql="DELETE  c_bal WHERE REFNO='" . trim($_GET["Txtrecno"]) . "'";
		 $result=mysql_query($sql, $dbinv);
		 
		 $sql="DELETE ledger WHERE l_refno='" . trim($_GET["Txtrecno"]) . "'";
		 $result=mysql_query($sql, $dbacc);
	
		 mysql_query("COMMIT", $dbinv);
        
         //echo "Reciept Canceled";
         //Call cmdNew_Click
			
			
			$ResponseXML = "Reciept Canceled";
		
	} else {
		$ResponseXML = "Sorry Cant Cancel.... please check reciept date";
	}

	echo $ResponseXML;

}
?>