<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	include('connectioni.php');
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		 date_default_timezone_set('Asia/Colombo'); 
		
if($_GET["Command"]=="get_bank")
{
	$sql="select * from bankmas where bcode='".$_GET["bankcode"]."'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql);
	if ($row = mysqli_fetch_array($result)){
		echo $row["bname"];
	}
}


if($_GET["Command"]=="addchq_cash_rec")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		$sql="delete from tmp_rec_ent where accno='".$_GET["accno"]."' and tmp_no='".$_SESSION["tmp_no_rec_ent_acc"]."'";
		$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
		
		$sql="insert into tmp_rec_ent(entno, accno, accname, descript, amt, tmp_no) values ('".$_GET["txt_entno"]."', '".$_GET["accno"]."', '".$_GET["acc_name"]."', '".$_GET["descript"]."', ".$_GET["amt"].", '".$_SESSION["tmp_no_rec_ent_acc"]."')";
		$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
			
			$totamt=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$sql="select * from tmp_rec_ent where tmp_no='".$_SESSION["tmp_no_rec_ent_acc"]."' ";
				$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
				while ($row = mysqli_fetch_array($result)){
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
			
			$sql="delete from tmp_cash_pay where accno='".$_GET["accno"]."' and tmp_no='".$_SESSION["tmp_no_cashpayacc"]."'";
			$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
			
			
			$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
							
			$totamt=0;
			$sql="select * from tmp_cash_pay where tmp_no='".$_SESSION["tmp_no_cashpayacc"]."' ";
				$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
				while ($row = mysqli_fetch_array($result)){
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
				$result =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
               
            } else {
                if ($invset > 0) { $invset = $invset - $chqbal; }
               
				$date1 = $_GET[$delidate];
				$date2 = $a_chq_date[$i];
				$diff = abs(strtotime($date2) - strtotime($date1));
				$days = floor($diff / (60*60*24));
				
				$col2=str_replace(",", "", $_GET[$invval]);
				
				$sql1="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('".$_GET["recno"]."', '".$_GET[$invno]."', '".$_GET[$delidate]."', '".$a_chq_no[$i]."', '".$a_chq_date[$i]."', '".$a_chq_bank[$i]."', ".$chqbal.", ".$days.", ".$col2.", 0, '".$_SESSION["tmp_no_cashrec"]."')"; 
			//echo $sql1." 2 /";
				$result =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
            
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


		if($_GET["Command"]=="set_chno")
		{
			
			include('connectioni.php');
			
			$macccode = trim($_GET["com_cas"]);
				$sql="Select * from bankmaster where bm_code='" . $macccode . "'";
				
				$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
				if ($row = mysqli_fetch_array($result)){
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
			
			include('connectioni.php');
			
			$sql="SELECT recedirect FROM  accpara";
			$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
			$row = mysqli_fetch_array($result);
			$tmprecno="000000".$row["recedirect"];
			$lenth=strlen($tmprecno);
			$recno="DRE/".substr($tmprecno, $lenth-7);
			
			$sql="SELECT recedirect FROM  tmpaccpara";
			$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
			$row = mysqli_fetch_array($result);
			$tmprecno="000000".$row["recedirect"];
			$lenth=strlen($tmprecno);
			$_SESSION["tmp_no_rec_ent_acc"]="DRE/".substr($tmprecno, $lenth-7);
			
			$sql="update tmpaccpara set recedirect=recedirect+1";
			$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
			
			$sql="delete from tmp_rec_ent where tmp_no='".$_SESSION["tmp_no_rec_ent_acc"]."' ";
			$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
	
			$_SESSION["txt_stat"]="new";
			echo $recno;
			
		}
		
		
if($_GET["Command"]=="save_crec")
{
	include('connectioni.php');
	
	//$ResponseXML = "";
	//$ResponseXML .= "<salesdetails>";
	
	
	
	if ($_SESSION["txt_stat"] == "new") {
		
		$sql="SELECT recedirect FROM  accpara";
		$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
		$row = mysqli_fetch_array($result);
			
  		$tmprecno="000000".$row["recedirect"];
		$lenth=strlen($tmprecno);
		$recno="DRE/ ".substr($tmprecno, $lenth-7);
		$_SESSION["recno"]=$recno;
		
		$sql="update  accpara set recedirect=recedirect+1";
		$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);	
	}		
	
	//////////////////
 //com_Flex1.Visible = False
    if ($_SESSION["txt_stat"] == "edit") {
       if ($_GET["txt_entno"] != "") {
          
		  mysqli_query($GLOBALS['dbinv'],"START TRANSACTION", $dbacc);
          
		  $sql_rsrecemas="delete from paymas where refno='".trim($_GET["txt_entno"])."'";
		  $result_rsrecemas=mysqli_query($GLOBALS['dbinv'],$sql_rsrecemas, $dbacc);
		  
		  $sql_rsrecemas="delete from cashpaytrn where refno='".trim($_GET["txt_entno"])."'";
		  $result_rsrecemas=mysqli_query($GLOBALS['dbinv'],$sql_rsrecemas, $dbacc);
		  
		  $sql_rsledger="select * from ledger where l_refno='".trim($_GET["txt_entno"])."'";
		  $result_rsledger=mysqli_query($GLOBALS['dbinv'],$sql_rsledger, $dbacc);
		  while ($row_rsledger = mysqli_fetch_array($result_rsledger)){
		  	if (trim($row_rsledger["l_refno"]) == trim($_GET["txt_entno"])) {
                 $m_amount = $row_rsledger["l_amount"];
                 $m_account = $row_rsledger["l_code"];
                 $m_flag1 = $row_rsledger["l_flag1"];
                 
             }
		  }
		  
		  $sql_rsledger1="delete from ledger where l_refno='".trim($_GET["txt_entno"])."'";
		  $result_rsledger1=mysqli_query($GLOBALS['dbinv'],$sql_rsledger1, $dbacc);
		  
       	mysqli_query($GLOBALS['dbinv'],"COMMIT", $dbacc);  
          
       }
      
    }
    //..............................................................................
    $m_ok = "";
    
    if ($_GET["txt_stat"] == "new") {
		$sql="uPDATE accpara SET recedirect=recedirect+1";
		$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
    }
	
    mysqli_query($GLOBALS['dbinv'],"START TRANSACTION", $dbacc);
    
    if ($_GET["txt_entno"] == "") { $m_ok = "Jouirnal No Not Entered"; }
    if ($_GET["TXT_DEBTOT"] == "0") { $m_ok = "ledger Entry Is Incomplete"; }
    
	$sql="Delete from  recmas where refno = '" . trim($_GET["txt_entno"]) . "'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
		   
	$m_acode = trim($_GET["txtacccode"]);
	   
	$sql="insert recmas (refno, bdate, code, name, heading, barer, naration, amount, type, invno, vatno, inv_date, bea1) values ('".trim($_GET["txt_entno"])."', '".$_GET["Calendar1"]."', '".$_GET["txtacccode"]."', '".trim($_GET["cmbBarer"])."', '".$_GET["TXT_HEADING"]."', '".$_GET["txt_bea"]."', '".$_GET["TXT_NARA"]."', '".$_GET["TXT_DEBTOT"]."', 'D', '".$_GET["txtINVNO"]."', '".$_GET["txtVATNIO"]."', '".$_GET["DTinv_date"]."', '".$_GET["txtbea1"]."')";
	//echo $sql;
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
		 
    
	$sql="insert ledger (l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_head, l_lmem, comcode) values ('".trim($_GET["txt_entno"])."', '".$_GET["Calendar1"]."', '".trim($m_acode)."', ".$_GET["TXT_DEBTOT"].", 'REC', 'DEB', '".$_GET["TXT_HEADING"]."', '".$_GET["TXT_NARA"]."', '".$_SESSION['company']."')";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
	
	if ($_GET["TXT_DEBTOT"]!=""){
  		$m_amount=$_GET["TXT_DEBTOT"];
	} else {
		$m_amount=0;
	}	
	$descri="Receipt Entry" . $m_flag1;
    $sql="insert audit (userid, username, description, refno, account, amount, flag) values ('userid', 'username', '".$descri."', '".trim($_GET["txt_entno"])."', '".$m_accno."', ".$m_amount.", 'DRE')";
	//echo $sql;
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);  
       
     
       
    
       
    $sql="select * from tmp_rec_ent where tmp_no='".$_SESSION["tmp_no_rec_ent_acc"]."' ";
	//echo $sql;
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
	while ($row = mysqli_fetch_array($result)){
          $m_acode = $row["accno"];
          $m_ades = $row["accname"];
          $m_nara = $row["descript"];
          $m_amount = $row["amt"];
		  
          if (($m_acode != "") and ($m_amount != 0)) {
		  	$sql1="insert recpaytrn (refno, date, code, amount, flag, NARA) values ('".$_GET["txt_entno"]."', '".$_GET["Calendar1"]."', '".trim($m_acode)."', ".$m_amount.", 'DRE', '".trim($m_nara)."')";
			//echo $sql1;
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $dbacc);
             
			$sql1="insert ledger (l_refno, l_date, l_code, l_amount, l_flag, l_flag1, comcode, l_lmem) values ('".trim($_GET["txt_entno"])."', '".$_GET["Calendar1"]."', '".trim($m_acode)."', ".$m_amount.", 'REC', 'CRE', '".$_SESSION['company']."', '".trim($m_nara)."')";
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $dbacc);
             
			$descri = "Receipt Entry" . $m_flag1;
            $sql1="insert audit (userid, username, description, action, refno, account, amount, flag) values ('userid', 'username', '".$descri."', 'Add', '".trim($_GET["txt_entno"])."', '".$m_accno."', ".$m_amount.", 'DRE')";
			//echo $sql1;
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $dbacc);
          
      }
      mysqli_query($GLOBALS['dbinv'],"COMMIT", $dbacc);  

      $_SESSION["txt_stat"] = "";
    }
	echo "Saved";
     
}
	////////////		
	

if ($_GET["Command"]=="rec_ent"){

	include('connectioni.php');
	
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	//////////////////////
	
	$sql_recmas="Select * from recmas where refno='" . $_GET["code"] . "'";
	$result_recmas=mysqli_query($GLOBALS['dbinv'],$sql_recmas, $dbacc);
	if($row_recmas = mysqli_fetch_array($result_recmas)){
		
		$ResponseXML .= "<txt_entno><![CDATA[".$_GET["code"]."]]></txt_entno>";
		$ResponseXML .= "<txtacccode><![CDATA[".$row_recmas["code"]."]]></txtacccode>";
		$ResponseXML .= "<cmbBarer><![CDATA[".$row_recmas["name"]."]]></cmbBarer>";
     	
        $ResponseXML .= "<Calendar1><![CDATA[".date("Y-m-d", strtotime($row_recmas["bdate"]))."]]></Calendar1>";
		$ResponseXML .= "<TXT_HEADING><![CDATA[".$row_recmas["heading"]."]]></TXT_HEADING>";
		$ResponseXML .= "<TXT_NARA><![CDATA[".$row_recmas["naration"]."]]></TXT_NARA>";
		$ResponseXML .= "<lab_can><![CDATA[".$row_recmas["cancel"]."]]></lab_can>";
		
		$_SESSION["tmp_no_rec_ent_acc"]=$row_recmas["tmp_no"];
		
           
          // If IsNull(RSACC_RIGHTS.Fields("CHEQUE_ENTRY")) Then Me.Com_add.Enabled = False
         //  If IsNull(RSACC_RIGHTS.Fields("CHEQUE_EDIT")) Then Me.com_Edit.Enabled = False
          // If IsNull(RSACC_RIGHTS.Fields("CHEQUE_CANCEL")) Then Me.Com_cancel.Enabled = False
         
		 $ResponseXML .= "<txtINVNO><![CDATA[".$row_recmas["invno"]."]]></txtINVNO>";
		 $ResponseXML .= "<txtVATNIO><![CDATA[".$row_recmas["vatno"]."]]></txtVATNIO>";
		 $ResponseXML .= "<DTinv_date><![CDATA[".date("Y-m-d", strtotime($row_recmas["inv_date"]))."]]></DTinv_date>";
		 $ResponseXML .= "<txtbea1><![CDATA[".$row_recmas["bea1"]."]]></txtbea1>";
		 
		
		$sql="delete from tmp_rec_ent where tmp_no='".$_SESSION["tmp_no_rec_ent_acc"]."' ";
		$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
				
		$sql_RSRECEPAYTRN="select * from  recpaytrn  where refno='".$_GET["code"]."'";
		$result_RSRECEPAYTRN=mysqli_query($GLOBALS['dbinv'],$sql_RSRECEPAYTRN, $dbacc);
		while($row_RSRECEPAYTRN = mysqli_fetch_array($result_RSRECEPAYTRN)){
	
			$sql_lcode="select * from  lcodes  where c_code='".$_GET["code"]."'";
			echo $sql_lcode;
			$result_lcode=mysqli_query($GLOBALS['dbinv'],$sql_lcode, $dbacc);
			$row_lcode = mysqli_fetch_array($result_lcode);
		
     	 	$sql="insert into tmp_rec_ent(entno, accno, accname, descript, amt, tmp_no) values ('".$_GET["code"]."', '".$row_RSRECEPAYTRN["code"]."', '".$row_lcode["c_name"]."', '".$row_RSRECEPAYTRN["nara"]."', ".$row_RSRECEPAYTRN["amount"].", '".$_SESSION["tmp_no_rec_ent_acc"]."')";
			$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
		}
			
			$totamt=0;
			
			
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Account No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Account Name</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Description</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$sql="select * from tmp_rec_ent where tmp_no='".$_SESSION["tmp_no_rec_ent_acc"]."' ";
				$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
				while ($row = mysqli_fetch_array($result)){
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
				
   }     
      
		$ResponseXML .= "</salesdetails>";

				echo $ResponseXML;
   
	/////////////
	
}


if ($_GET["Command"]=="vou_print_las"){

	include('connectioni.php');
	
	$sql_rsPrInv="select * from ledger where l_refno='" . $_GET["txt_entno"] . "' and l_flag1='DEB'";
	$result_rsPrInv=mysqli_query($GLOBALS['dbinv'],$sql_rsPrInv, $dbacc);
	$ii = 1;
	while($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)){
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
	
	include_once("connectioni.php");
	
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
								$result=mysqli_query($GLOBALS['dbinv'],$sql);
								
							} else if ($_GET["mstatus"]=="recdate"){
								$letters = $_GET['recdate'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A' and CA_DATE like  '$letters%'  ORDER BY CA_REFNO limit 50";
								$result=mysqli_query($GLOBALS['dbinv'],$sql);
								
							}else if ($_GET["mstatus"]=="recamt"){
								$letters = $_GET['recamt'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A' and CA_AMOUNT like  '$letters%'  ORDER BY CA_REFNO limit 50";
								$result=mysqli_query($GLOBALS['dbinv'],$sql);
								
							} else {
								$letters = $_GET['recno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql="select CA_REFNO, CA_DATE, CA_AMOUNT, cus_ref  from s_crec where DEPARTMENT != 'S' and CANCELL='0' and FLAG = 'REC-A' and CA_REFNO like  '$letters%'  ORDER BY CA_REFNO limit 50";
								$result=mysqli_query($GLOBALS['dbinv'],$sql);
							}
							
													
						
							while($row = mysqli_fetch_array($sql)){
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
						   		$sql = "SELECT * from bankmas where  bcode like  '$letters%'";
								$result=mysqli_query($GLOBALS['dbinv'],$sql);
							 } else if ($_GET["mfield"]=="bank"){
							 	$letters = $_GET['bank'];
						   		$sql = "SELECT * from bankmas where  bname like  '$letters%'";
								$result=mysqli_query($GLOBALS['dbinv'],$sql);
							 }	
						   } 
						   
						  						
						
							while($row = mysqli_fetch_array($result)){
								
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
	$result=mysqli_query($GLOBALS['dbinv'],$sql);
	
	if ($row = mysqli_fetch_array($result)){
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
	$result_rscrec=mysqli_query($GLOBALS['dbinv'],$sql_rscrec);
	
	$sql_RSINV_CHEQ="select * from s_invcheq where refno='" .$_GET["recno"]. "'";
	$result_RSINV_CHEQ=mysqli_query($GLOBALS['dbinv'],$sql_RSINV_CHEQ);
	
	$sql_rsLED="Select * from ledger where l_refno ='" .$_GET["recno"]. "'";
	$result_rsLED=mysqli_query($GLOBALS['dbinv'],$sql_rsLED, $dbacc);
	
	if($row_rscrec = mysqli_fetch_array($result_rscrec)){	
	
		$ResponseXML .= "<Txtrecno><![CDATA[".$row_rscrec["CA_REFNO"]."]]></Txtrecno>";
		$ResponseXML .= "<txtDATE><![CDATA[".$row_rscrec["CA_DATE"]."]]></txtDATE>";
		$ResponseXML .= "<Txtcusco><![CDATA[".$row_rscrec["CA_CODE"]."]]></Txtcusco>";
    	
		$acc=0;
		$acc1=0;
		
		if($row_rsLED = mysqli_fetch_array($result_rsLED)){
    		while($row_rsLED = mysqli_fetch_array($result_rsLED)){
				if ($row_rsLED["l_flag1"] == "DEB") {
					$ResponseXML .= "<txt_accode><![CDATA[".$row_rsLED["l_code"]."]]></txt_accode>";
                	
					$sql_Rslcode="Select * from lcodes where c_code = '" . trim($row_rsLED["l_code"]) . "'";
					$result_Rslcode = mysqli_query($GLOBALS['dbinv'],$sql_Rslcode, $dbacc);
					if($row_Rslcode = mysqli_fetch_array($result_Rslcode)){
               			$ResponseXML .= "<txt_accname><![CDATA[".$row_Rslcode["c_name"]."]]></txt_accname>";
					}
					$acc=1;
              	} else {
					$ResponseXML .= "<txt_accode1><![CDATA[".$row_rsLED["l_code"]."]]></txt_accode1>";
                	
					$sql_Rslcode="Select * from lcodes where c_code = '" . trim($row_rsLED["l_code"]) . "'";
					$result_Rslcode = mysqli_query($GLOBALS['dbinv'],$sql_Rslcode, $dbacc);
					if($row_Rslcode = mysqli_fetch_array($result_Rslcode)){
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
		$result_RSCUS=mysqli_query($GLOBALS['dbinv'],$sql_RSCUS);
		if($row_RSCUS = mysqli_fetch_array($result_RSCUS)){
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
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $dbacc);
			
		$sql_rs="Select chno, l_date, l_code, l_amount, l_lmem, l_bank, chno from ledger where l_flag1='DEB' and l_refno ='" . trim($_GET["recno"]) . "' order by id";
		$result_rs=mysqli_query($GLOBALS['dbinv'],$sql_rs, $dbacc);
		while($row_rs = mysqli_fetch_array($result_rs)){
			   
    		$sql1="insert into tmp_cash_chq(recno, chqno, chqdate, chqbank, chqamt, tmp_no) values ('".$_GET["recno"]."', '".$row_rs["chno"]."', '".$row_rs["l_date"]."', '".$row_rs["l_bank"]."', ".$row_rs["l_amount"].", '".$_SESSION["tmp_no_cashrecacc"]."')";
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $dbacc);
		}		
		
	
		$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
		$sql="select * from tmp_cash_chq where recno='".$_GET["recno"]."' ";
		$result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
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
	}	
		$ResponseXML .= "</salesdetails>";

				echo $ResponseXML;
		
}



if ($_GET["Command"]=="delete_rec"){
	$ResponseXML = "";
	
	if ($_GET["invdate"]==date("Y-m-d")){
		
		// mysqli_query($GLOBALS['dbinv'],"START TRANSACTION");
         
		 $sql="Update  recmas set cancel='1' where refno = '" . trim($_GET["txt_entno"]) . "'";
		 $result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
		 
		 $sql="Delete  from  ledger where l_refno = '" . trim($_GET["txt_entno"]) . "'";
		 $result=mysqli_query($GLOBALS['dbinv'],$sql, $dbacc);
		 
		
			
			$ResponseXML = " Canceled";
		
	} else {
		$ResponseXML = "Sorry Cant Cancel.... please check reciept date";
	}

	echo $ResponseXML;

}
?>