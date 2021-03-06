<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
		
if($_GET["Command"]=="get_bank")
{
	$sql="select * from bankmas where bcode='".$_GET["bankcode"]."'";
	$result =$db->RunQuery($sql);
	if ($row = mysql_fetch_array($result)){
		echo $row["bname"];
	}
}


if($_GET["Command"]=="addchq_cash_rec")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		$sql="delete from tmp_cash_chq where chqno='".$_GET["chqno"]."' and tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
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
				
				$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
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
			
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
						
			
			
			if ($_SESSION['dev'] == "0") {
				
				$sql="select INV_RECNO from invpara";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["INV_RECNO"];
				$lenth=strlen($tmprecno);
				$recno=trim("CRN/CR/ ").substr($tmprecno, $lenth-7);
				$_SESSION["recno"]=$recno;
				
				$sql="Select INV_RECNO from tmpinvpara";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
				$_SESSION["tmp_no_cashrec"]="CRN/CR/ ".$row["INV_RECNO"];
				
				$sql="update tmpinvpara set INV_RECNO=INV_RECNO+1";
				$result =$db->RunQuery($sql);
 			}

			if ($_SESSION['dev'] == "1") {
  								
				$sql="select INV_RECNO_M from invpara";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["INV_RECNO_M"];
				$lenth=strlen($tmprecno);
				$recno=trim("CRN/ ").substr($tmprecno, $lenth-7);
				$_SESSION["recno"]=$recno;
				
				$sql="Select INV_RECNO_M from tmpinvpara";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
				$_SESSION["tmp_no_cashrec"]="CRN/".$row["INV_RECNO_M"];
				
				$sql="update tmpinvpara set INV_RECNO_M=INV_RECNO_M+1";
				$result =$db->RunQuery($sql);
 
			}

			
			
			
			

			
			$sql="delete from tmp_inv_data where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
			$result =$db->RunQuery($sql);
			
			$sql="delete from tmp_cash_chq where recno='".$recno."'";
			$result =$db->RunQuery($sql);
		
			echo $recno;	
			
		}
		
		
if($_GET["Command"]=="save_crec")
{
			if ($_SESSION['dev'] == "0") {
				
				$sql="select INV_RECNO from invpara";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["INV_RECNO"];
				$lenth=strlen($tmprecno);
				$recno=trim("CRN/CR/ ").substr($tmprecno, $lenth-7);
				$_SESSION["recno"]=$recno;
				
				
 			}

			if ($_SESSION['dev'] == "1") {
  								
				$sql="select INV_RECNO_M from invpara";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
			
  				$tmprecno="000000".$row["INV_RECNO_M"];
				$lenth=strlen($tmprecno);
				$recno=trim("CRN/ ").substr($tmprecno, $lenth-7);
				$_SESSION["recno"]=$recno;
				
				
 
			}


	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
			
	$sql="select * from s_crec where CA_REFNO='".$recno."'";
	
	$result =$db->RunQuery($sql);
	if ($row = mysql_fetch_array($result)){
		$ResponseXML .= "<msg_dup><![CDATA[Reciept No Already Saved]]></msg_dup>";
		exit();
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
	
	$sql="insert into s_crec(CA_REFNO, CA_DATE, CA_CODE, CA_CASSH, CA_AMOUNT, overpay, FLAG, pay_type, CA_SALESEX, CANCELL, tmp_no, DEPARTMENT, cus_ref) values
	  ('".$recno."', '".$_GET["invdate"]."', '".$_GET["cuscode"]."', ".$cashtot.", ".$txtpaytot.", ".$txtoverpay.", 'REC', '".$_GET["paytype"]."', '".$_GET["salesrep"]."', '0', '".$_SESSION["tmp_no_cashrec"]."', 'O', '0')";
	$result =$db->RunQuery($sql);
	
	$sql="select * from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		if ($row["chqno"]=="CAS"){
			$ST_flag="CAS";
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
	  ('".$recno."', '".$_GET["invdate"]."', '".$row["invno"]."', ".$settled.", '".$row["chqno"]."', '".$ST_CHDATE."', '".$ST_flag."', '".$row["days"]."', '".$row["days"]."', '".$row["chbank"]."', '".$_GET["cuscode"]."', '".$_SESSION['dev']."', 0, 0, 0, '0', 'O')";
	  	$result1 =$db->RunQuery($sql1);
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
			$result =$db->RunQuery($sql);
			if ($row = mysql_fetch_array($result)){
				$sql1="select class from brand_mas where barnd_name='".$row["brand"]."'";
				$result1 =$db->RunQuery($sql1);
				if ($row1 = mysql_fetch_array($result1)){
					$sql2="update br_trn set credit=credit - ".$tot." where cus_code = '".$_GET["cuscode"]."' and Class = '".$row1["class"]."'";
					$result2 =$db->RunQuery($sql2);
				}
			}
			
			$sql2="update vendor set CUR_BAL=CUR_BAL - ".$tot." where CODE = '".$_GET["cuscode"]."'";
			$result2 =$db->RunQuery($sql2);
			
			$sql2="update br_trn set credit=credit - ".$tot." where cus_code = '".$_GET["cuscode"]."' and Rep='".$_GET["salesrep"]."'";
			$result2 =$db->RunQuery($sql2);
			
			$sql2="update s_salma set TOTPAY=TOTPAY + ".$tot." where REF_NO = '".$_GET[$invno]."'";
			$result2 =$db->RunQuery($sql2);
			
			$sql2="update s_salma set CASH=CASH + ".$cash." where REF_NO = '".$_GET[$invno]."'";
			$result2 =$db->RunQuery($sql2);
		}
		$i=$i+1;
	}



	$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		$sql1="select * from vendor where CODE='".$_GET["cuscode"]."'";
		$result1 =$db->RunQuery($sql1);
	 	$row1 = mysql_fetch_array($result1);
		
		if (is_numeric($row["chqamt"])==true){
			$chqamt = $row["chqamt"];
		} else {
			$chqamt = 0;
		}
			
		$sql2="insert into s_invcheq(refno, Sdate, cus_code, CUS_NAME, cheque_no, che_date, bank, che_amount, sal_ex, trn_type, ex_flag, ch_owner, noof, ret_refno, ch_count_ret, department) values
	  ('".$recno."', '".$_GET["invdate"]."', '".$_GET["cuscode"]."', '".$row1["NAME"]."', '".$row["chqno"]."', '".$row["chqdate"]."', '".$row["chqbank"]."',  ".$chqamt.", '".$_GET["salesrep"]."', 'REC', 'N', '".$_GET["chqcollect"]."', 0, '1', '0', 'O')";
	  	$result2 =$db->RunQuery($sql2);
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
	$result =$db->RunQuery($sql);

	if ($_GET["txtoverpay"]>0){
		$sql="insert into c_bal(REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, SAL_EX) values
	  ('".$recno."', '".$_GET["invdate"]."', 'REC', '".$_GET["cuscode"]."',  ".$_GET["txtoverpay"].", ".$_GET["txtoverpay"].", '".$_GET["salesrep"]."')";
	 // echo $sql;
	 	$result =$db->RunQuery($sql);
		
	}
	if ($_SESSION['dev']=="0"){
		$sql2="update invpara set INV_RECNO=INV_RECNO + 1";
		$result2 =$db->RunQuery($sql2);
	}
	
	if ($_SESSION['dev']=="1"){
		$sql2="update invpara set INV_RECNO_M=INV_RECNO_M + 1";
		$result2 =$db->RunQuery($sql2);
	} 	
			
	$ResponseXML .= "<msg_incom><![CDATA[0]]></msg_incom>";
} else {	
	$ResponseXML .= "<msg_incom><![CDATA[Incomplete Detail]]></msg_incom>";
	
}

	$ResponseXML .= "</salesdetails>";

	echo $ResponseXML;

}


if($_GET["Command"]=="check_print")
{
	$sql="delete from tmprct where recno='".$_GET["recno"]."'";
	echo $sql;
			$result =$db->RunQuery($sql);
			
	$i=1;
	echo $_GET["mcount"];
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
			echo $sql;
			$result =$db->RunQuery($sql);
		
		}
		
		$i=$i+1;
	}
	
	$sql1="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result1 =$db->RunQuery($sql1);
	while ($row1 = mysql_fetch_array($result1)){
		$sql="insert into  tmprct (SDATE, REFNO, AMOUNT, balance, CH_VAL, flag) value ('".$row1["chqdate"]."', '".$row1["chqno"]."', '".$row1["chqbank"]."', '".$row1["chqamt"]."', '".$row1["chqamt"]."', 'CHK')";
		$result =$db->RunQuery($sql);
	}
	
		
		

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
                           	  <td onclick=\"recno('$REF_NO');\">".$row['CA_REFNO']."</a></td>
                              <td onclick=\"recno('$REF_NO');\">".$row['CA_DATE']."</a></td>
                              <td onclick=\"recno('$REF_NO');\">".$row['CA_AMOUNT']."</a></td>";
							  
							  $sql1="SELECT * FROM vendor where CODE = '".$row["CA_CODE"]."'";
							  $result1 =$db->RunQuery($sql1);
							  $row1 = mysql_fetch_array($result1);
                              $ResponseXML .= "<td onclick=\"recno('$REF_NO');\">".$row1['NAME']."</a></td>                          	
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
				
				$sql="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
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
				
				$sql1="select * from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
				$result1 =$db->RunQuery($sql1);
				while ($row1 = mysql_fetch_array($result1)){	
					$sql2="update s_salma set TOTPAY=TOTPAY- ".$row1["settled"]." where recno='".$row1["invno"]."'";
					$result2 =$db->RunQuery($sql2);
					
					$sql2="update s_salma set CANCELL= '1' where recno='".$row1["invno"]."'";
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
			
			$sql1="select * from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
			$result1 =$db->RunQuery($sql1);
			while ($row1 = mysql_fetch_array($result1)){	
				$sql2="update s_salma set TOTPAY=TOTPAY- ".$row1["settled"]." where recno='".$row1["invno"]."'";
				$result2 =$db->RunQuery($sql2);
				
				$sql2="update s_salma set CANCELL= '1' where recno='".$row1["invno"]."'";
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