<?php

	include('connectioni.php');
	
	$AWORD="";
	
	$sql_rs="Select l_lmem from ledger where l_refno= '" . trim($_GET["Txtrecno"]) . "'";
	$result_rs=mysqli_query($GLOBALS['dbinv'],$sql_rs, $dbacc);
	$row_rs = mysqli_fetch_array($result_rs);
	
	$sql_strsql="select * from s_invcheq where refno='" . trim($_GET["Txtrecno"]) . "'";
	$result_strsql=mysqli_query($GLOBALS['dbinv'],$sql_strsql);
	$row_strsql = mysqli_fetch_array($result_strsql);
	
	$txtrepono = date("Y-m-d H:i:s");
	if ($_SESSION['company'] == "THT") { $RTXCNAME = "TYRE HOUSE TRADING (PVT) LTD"; }
	if ($_SESSION['company'] == "BEN") { $RTXCNAME = "BENEDICTSONS (PVT) LTD"; }
	if ($_SESSION['company'] == "THT") { $RTXCADD = "No.221 1/4, Sri Sangaraja Mawatha, Colombo 10"; }
	if ($_SESSION['company'] == "BEN") { $RTXCADD = "No.221 1/2, Sri Sangaraja Mawatha, Colombo 10"; }

	$rtxrno = $_GET["Txtrecno"];
	$rtxdate = date("Y-m-d",  strtotime($_GET["txtDATE"]));

	$RTXMNAME = $row_rs["l_lmem"];

 	amoword_cal();
	
	$RTXAMOUNT= "The sum of Rupees " . $AWORD;


	$RTXBNO = "Bill Nos ";
	$RTXRS = "Rs. " . number_format($_GET["txtpaytot"], 2, ".", ",");



	//report
	
	echo "<center><table width=\"1000\" border=\"0\">
  <tr>
    <td><center><span class=\"style1\">".$RTXCNAME."</span></center></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan=\"2\">".$RTXCADD."</td>
    <td>CASH RECEIPT</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>".$rtxrno."</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>".$rtxdate."</td>
  </tr>
  <tr>
    <td colspan=\"4\">".$RTXMNAME."</td>
  </tr>
  <tr>
    <td colspan=\"4\">".$RTXAMOUNT."</td>
  </tr>
  <tr>
    <td colspan=\"2\">&nbsp;</td>
    <td colspan=\"2\">".$RTXBNO."</td>
  </tr>
</table><br>";
		
		
		
		echo "<center><table border=1><tr>
		<th>Cheque No</th>
		<th>Bank</th>
		<th>Date</th>
		<th>Cheque Amount</th>
		</tr>";
		//echo $sql;
		
		$che_amount=0;
		$result_strsql=mysqli_query($GLOBALS['dbinv'],$sql_strsql);
		while($row_strsql = mysqli_fetch_array($result_strsql)){	
			echo "<tr>
			<td>".$row_strsql["cheque_no"]."</td>
			<td>".$row_strsql["bank"]."</td>
			<td>".$row_strsql["Sdate"]."</td>
			<td>".number_format($row_strsql["che_amount"], 2, ".", ",")."</td>
			</tr>";
			
		}
		echo "</table><br>";
		
		echo "<table width=\"1000\" border=\"0\">
  <tr>
    <td>".$RTXRS."</th>
    <td>&nbsp;</th>
    <td>Stamp</th>
  </tr>
  <tr>
    <td>________</td>
    <td>&nbsp;</td>
    <td>________</td>
  </tr>
  <tr>
    <td>Entered By</td>
    <td>".$txtrepono."</td>
    <td>Checked By</td>
  </tr>
  
</table>";


		

function amoword_cal(){
    $M_TXT = "";
    $M_INPUT="";
	$M_INPUTLEN="";
	$M_TM ="";
	
    $M_INPUT = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $GLOBALS['txtpaytot'];
    $M_INPUTLEN = strlen($M_INPUT);
    //Cents.........................................................................
    $m_cent = "";
    $ii = 1;
    $m_ok = "false";
    while ($ii <= strlen(trim($GLOBALS['txtpaytot']))){
       if ($m_ok == "true") { $m_cent = $m_cent + substr(trim($GLOBALS['txtpaytot']), $ii, 1); }
       if (substr(trim($GLOBALS['txtpaytot']), $ii, 1) == ".") { $m_ok == "true"; }
       $ii = $ii + 1;
    }
    $m_say = "";
    $m_say1 = "";
    $m_amo = substr($m_cent, 1, 2);
    
    $M_AMO1 = substr($m_cent, 1, 1) + "0";
    $m_amo2 = substr($m_cent, 2, 1);
    if ($m_amo <= 19) {
       $Text3 = $m_amo;
       BEL_ninten();
       $m_say = $Text3;
    } else {
       $Text3 = $M_AMO1;
       BEL_TY();
       $m_say = $Text3;
       
       $Text3 = $m_amo2;
       BEL_ninten();
       $m_say1 = $Text3;
    }
    $m_cent = trim($m_say . " " . $m_say1);
    //1-99..........................................................................
    $m_say = "";
    $m_say1 = "";
    $m_amo = substr($M_INPUT, $M_INPUTLEN - 1, 2);
    
    $M_AMO1 = substr($M_INPUT, $M_INPUTLEN - 1, 1) . "0";
    $m_amo2 = substr($M_INPUT, $M_INPUTLEN, 1);
    
    if ($m_amo <= 19) {
       $Text3 = $m_amo;
       BEL_ninten();
       $m_say = $Text3;
    } else {
       $Text3 = $M_AMO1;
       BEL_TY();
       $m_say = $Text3;
       
       $Text3 = $m_amo2;
       BEL_ninten();
       $m_say1 = $Text3;
    }
    $m_bel99 = trim($m_say . " " . $m_say1);
    //99-999..........................................................................
    $m_bel999 = "";
    $i = 1;
    $Text3 = substr($M_INPUT, $M_INPUTLEN - 2, 1);
    if ($Text3 > 0) {
       BEL_ninten();
       $m_bel999 = $Text3;
    }
    $AWORD = $m_bel999;
    //.....Thousand.............................................................................
    $m_say = "";
    $m_say1 = "";
    $m_amo = substr($M_INPUT, $M_INPUTLEN - 4, 2);
    
    $M_AMO1 = substr($M_INPUT, $M_INPUTLEN - 4, 1) . "0";
    $m_amo2 = substr($M_INPUT, $M_INPUTLEN - 3, 1);
    
    if ($m_amo <= 19) {
       $Text3 = $m_amo;
       BEL_ninten();
       $m_say = $Text3;
    } else {
       $Text3 = $M_AMO1;
       BEL_TY();
       $m_say = $Text3;
       
       $Text3 = $m_amo2;
       BEL_ninten();
       $m_say1 = $Text3;
    }
    $m_bel1000 = trim($m_say . " " . $m_say1);
    //....Lack..............................................................................
    $m_say = "";
    $m_amo = substr($M_INPUT, $M_INPUTLEN - 5, 1);
    if ($m_amo <= 9) {
       $Text3 = $m_amo;
       BEL_ninten();
       $m_say = $Text3;
    }
    $m_bel100000 = trim($m_say);
    //.....Million.............................................................................
    $m_say = "";
    $m_say1 = "";
    $m_amo = substr($M_INPUT, $M_INPUTLEN - 7, 2);
    
    $M_AMO1 = substr($M_INPUT, $M_INPUTLEN - 7, 1) . "0";
    $m_amo2 = substr($M_INPUT, $M_INPUTLEN - 6, 1);
    
    if ($m_amo <= 19) {
       $Text3 = $m_amo;
       BEL_ninten();
       $m_say = $Text3;
    } else {
       $Text3 = $M_AMO1;
       BEL_TY();
       $m_say = $Text3;
       
       $Text3 = $m_amo2;
       BEL_ninten();
       $m_say1 = $Text3;
    }
    $m_overmil = trim($m_say . " " . $m_say1);
    $AWORD = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "And";
    //..................................................................................
    if (trim($m_overmil) != "") {
       if (substr($AWORD, strlen($AWORD) - 2, 3) != "And") {
          $AWORD = $AWORD . "   ";
       }
       $AWORD = trim($AWORD) . " " . $m_overmil . " Million ";
    }
    
    if (trim($m_bel100000) != "") {
       if (substr($AWORD, strlen($AWORD) - 2, 3) != "  ") {
          $AWORD = $AWORD . "   ";
       }
       $AWORD = trim($AWORD) . " " . $m_bel100000 . " Hundred";
       if (trim($m_bel1000) == "") { $AWORD = $AWORD . " Thousand";}
    }
    
    if (trim($m_bel1000) != "") {
       if (substr($AWORD, strlen($AWORD) - 2, 3) != "And") {
          $AWORD = $AWORD . "   ";
       }
       $AWORD = trim($AWORD) . " " . $m_bel1000 . " Thousand ";
    }
    
    if (trim($m_bel999) != "") {
       if (substr($AWORD, strlen($AWORD) - 2, 3) != "And") {
          $AWORD = $AWORD . "   ";
       }
       $AWORD = trim($AWORD) . " " . $m_bel999 . " Hundred ";
    }
    
    if (trim($m_bel99) != "") {
       if (substr($AWORD, strlen($AWORD) - 2, 3) != "And") {
          $AWORD = $AWORD . "   ";
       }
       $AWORD = trim($AWORD) . " " . $m_bel99;
    }
    
    if (trim($m_cent) != "") {
       if (substr($AWORD, strlen($AWORD) - 2, 3) != "And") {
          $AWORD = $AWORD . " And";
       }
       $AWORD = trim($AWORD) . " Cents " . $m_cent;
    }
    $AWORD = substr($AWORD, 5, strlen($AWORD) - 3);
    
}


function BEL_ninten(){
  $m_amo = $GLOBALS['Text3'];
  if ($m_amo == 1) { $M_TXT = "One"; }
  if ($m_amo == 2) { $M_TXT = "Two"; }
  if ($m_amo == 3) { $M_TXT = "Three"; }
  if ($m_amo == 4) { $M_TXT = "Four"; }
  if ($m_amo == 5) { $M_TXT = "Five"; }
  if ($m_amo == 6) { $M_TXT = "Six"; }
  if ($m_amo == 7) { $M_TXT = "Seven"; }
  if ($m_amo == 8) { $M_TXT = "Eight"; }
  if ($m_amo == 9) { $M_TXT = "Nine"; }
  if ($m_amo == 10) { $M_TXT = "Ten"; }
  if ($m_amo == 11) { $M_TXT = "Eleven"; }
  if ($m_amo == 12) { $M_TXT = "Twelve"; }
  if ($m_amo == 13) { $M_TXT = "Thirteen"; }
  if ($m_amo == 14) { $M_TXT = "Fourteen"; }
  if ($m_amo == 15) { $M_TXT = "Fifteen"; }
  if ($m_amo == 16) { $M_TXT = "Sixteen"; }
  if ($m_amo == 17) { $M_TXT = "Seventeen"; }
  if ($m_amo == 18) { $M_TXT = "Eighteen"; }
  if ($m_amo == 19) { $M_TXT = "Nineteen"; }
 
 $GLOBALS['Text3'] = $M_TXT;
}

function BEL_TY(){
 $m_amo = $GLOBALS['Text3'];
 if (($m_amo >= 20) and ($m_amo < 30)) { $M_TXT = "Twenty"; }
 if (($m_amo >= 30) and ($m_amo < 40)) { $M_TXT = "Thirty"; }
 if (($m_amo >= 40) and ($m_amo < 50)) { $M_TXT = "Forty"; }
 if (($m_amo >= 50) and ($m_amo < 60)) { $M_TXT = "Fifty"; }
 if (($m_amo >= 60) and ($m_amo < 70)) { $M_TXT = "Sixty"; }
 if (($m_amo >= 70) and ($m_amo < 80)) { $M_TXT = "Seventy"; }
 if (($m_amo >= 80) and ($m_amo < 90)) { $M_TXT = "Eighty"; }
 if (($m_amo >= 90) and ($m_amo < 99)) { $M_TXT = "Ninety"; }
 $GLOBALS['Text3'] = $M_TXT;
}

?>