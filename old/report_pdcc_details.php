<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PDCC Incentive</title>

<style>
table
{
border-collapse:collapse;
}
table, td, th
{
border:0px solid black;
font-family:Arial, Helvetica, sans-serif;
padding:5px;
}
th
{
font-weight:bold;
font-size:12px;

}
td
{
font-size:12px;

}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
</style>

</head>

<body>
<center>

<p>
  <?php

    require_once("connectioni.php");
	
	
    

	
	$sql_head="select * from invpara";
	$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
	$row_head = mysqli_fetch_array($result_head);
		
		//////////////////////

	$txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");
        $txtper= trim($_GET["txtper"]);

	$rep = trim($_GET["cmbrep"]);
	
	$sql_RSINVO = "select sum(GRAND_TOT) as Tot from s_salma where Accname != 'NON STOCK' and SAL_EX='" . $rep . "'and CANCELL='0' and month(sdate1)= ' " . date("m", strtotime($_GET["DTpiker1"])) . " ' and year(sdate1) = ' " . date("Y", strtotime($_GET["DTpiker1"])) . " '";
	$result_RSINVO =mysqli_query($GLOBALS['dbinv'],$sql_RSINVO);
	$row_RSINVO = mysqli_fetch_array($result_RSINVO);
	
	$sql_rspay = "select sum(TOTPAY) as Pay from s_salma where Accname != 'NON STOCK' and SAL_EX='" . $rep . "'and CANCELL='0' and month(sdate1)= ' " . date("m", strtotime($_GET["DTpiker1"])) . " ' and year(sdate1) = ' " . date("Y", strtotime($_GET["DTpiker1"])) . " '";
	$result_rspay =mysqli_query($GLOBALS['dbinv'],$sql_rspay);
	$row_rspay = mysqli_fetch_array($result_rspay);
	
	$sql_RSGRN = "select sum(GRAND_TOT) as GRN from s_crnma where SAL_EX = '" . $rep . "' and CANCELL='0' and month(DDATE) = ' " . date("m", strtotime($_GET["DTpiker1"])) . " ' and year(DDATE) = ' " . date("Y", strtotime($_GET["DTpiker1"])) . " ' and sdate1 >= ' " . $_GET["DTpiker1"] . " ' and sdate1 <= ' " . $_GET["DTPicker1"] . " ' ";
	$result_RSGRN =mysqli_query($GLOBALS['dbinv'],$sql_RSGRN);
	$row_RSGRN = mysqli_fetch_array($result_RSGRN);
	// (cbalflag1 != '1' ) and
	$sql_RSUTI = "select sum(ST_PAID) as UT from view_sttr where cbaltrn_type != 'REC'  and SAL_EX = '" . $rep . "' and CANCELL='0' and month(sdate1) = ' " . date("m", strtotime($_GET["DTpiker1"])) . " ' and year(sdate1) = ' " . date("Y", strtotime($_GET["DTpiker1"])) . " ' and ST_FLAG = 'UT'";
	$result_RSUTI =mysqli_query($GLOBALS['dbinv'],$sql_RSUTI); 
	$row_RSUTI = mysqli_fetch_array($result_RSUTI);


	$mgrn = 0;
	if (is_null($row_RSGRN["GRN"])==false) {
   		$mgrn = $row_RSGRN["GRN"];
	}

	$sql_rss_salrep = "select * from s_salrep where REPCODE='" . $rep . "'";
	$result_rss_salrep =mysqli_query($GLOBALS['dbinv'],$sql_rss_salrep);
	if ($row_rss_salrep = mysqli_fetch_array($result_rss_salrep)){
		$txtrep = $row_rss_salrep["Name"]; 
	}	
 

	$TXTCOM = $row_head["COMPANY"];

	$txtgsale = number_format($row_RSINVO["Tot"], 2, ".", ",");
	
	if ($mgrn > 0) {
   		$txtgrn = number_format((-1*$mgrn), 2, ".", ",");
  	 	$txtnsale = number_format(($sql_RSINVO["Tot"] - $mgrn), 2, ".", ",");
   		$txtoutper = number_format((($row_RSINVO["Tot"] - $row_rspay["Pay"]) / ($row_RSINVO["Tot"]) * 100), 3, ".", ",");
   		$txtcolper = number_format((($row_rspay["Pay"] - $row_RSUTI["UT"]) / ($row_RSINVO["Tot"] - $mgrn)) * 100, 3, ".",",");
   		$txtgrnper = number_format(((-1*$mgrn) / ($row_RSINVO["Tot"]) * 100), 3, ".", ",");
   		$txtutper = number_format(($row_RSUTI["UT"] / ($row_RSINVO["Tot"] - $mgrn) * 100), 3, ".",",");
	} else {
   		$txtgrn = number_format(0, 2, ".", ",");
   		$txtnsale = number_format($row_RSINVO["Tot"], 2, ".", ",");
   		$txtoutper = number_format((($row_RSINVO["Tot"] - $row_rspay["Pay"]) / ($row_RSINVO["Tot"]) * 100), 2, ".", ",");
   		$txtcolper = number_format((($row_rspay["Pay"] - $row_RSUTI["UT"]) / ($row_RSINVO["Tot"]) * 100), 2, ".", ",");
   		$txtgrnper = number_format(((-1*$txtgrn) / ($row_RSINVO["Tot"]) * 100), 2, ".", ",");
   		$txtutper = number_format(($row_RSUTI["UT"] / ($row_RSINVO["Tot"]) * 100), 2, ".", ",");
	}

	$txtout = number_format(($row_RSINVO["Tot"] - $row_rspay["Pay"]), 2, ".", ",");
	if (is_null($row_RSUTI["UT"])==TRUE) { 
		$txtcolect = number_format($row_rspay["Pay"], 2, ".", ",");
	}
	if (is_null($row_RSUTI["UT"])==false) { 
		$txtcolect = number_format(($row_rspay["Pay"] - $row_RSUTI["UT"]), 2, ".", ",");
	}
	if (is_null($row_RSUTI["UT"])==false) { 
		$txtut = number_format($row_RSUTI["UT"], 2, ".", ",");
	}
	
	if ($row_RSUTI["UT"] > 0) {
    	$txtcolper = number_format((($row_rspay["Pay"] - $row_RSUTI["UT"]) / ($row_RSINVO["Tot"]) * 100), 2, ".", ",");
    	$txtutper = number_format(($row_RSUTI["UT"] / ($row_RSINVO["Tot"]) * 100), 2, ".", ",");
    	$txtincamo = number_format((($row_rspay["Pay"] - $row_RSUTI["UT"]) * $txtper / 100), 2, ".", ",");
    	$txtinc = number_format((($row_rspay["Pay"] - $row_RSUTI["UT"]) * $txtper / 100), 2, ".", ",");
	} else {
    	$txtut = number_format(0, 2, ".", ",");
    	$txtcolper = number_format((($row_rspay["Pay"]) / ($row_RSINVO["Tot"]) * 100), 2, ".", ",");
    	$txtincamo = number_format((($row_rspay["Pay"]) * $txtper / 100), 2, ".", ",");
    	$txtinc = number_format((($row_rspay["Pay"]) * $txtper / 100), 2, ".", ",");
    	$txtutper = number_format(($txtut / ($row_RSINVO["Tot"]) * 100), 2, ".", ",");
	}
	
	if ($txtper!=""){
		$txtincper = number_format($txtper, 3, ".", ",");
	}	

	$txtmon = date("Y-m", strtotime($_GET["DTpiker1"]));


?>
</p>
<table width="882" border="1">
  <tr>
    <td colspan="3" align="center"><span class="style2"><?php echo $row_head['COMPANY']; ?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="421">&nbsp;</td>
    <td width="183">&nbsp;</td>
    <td width="256">&nbsp;</td>
  </tr>
  <tr>
      <td>
          <span class="style2">
        <?php 
        $sqls = "select * from s_salrep where repcode = '" . $_GET["cmbrep"] . "'";
        $result_rep =mysqli_query($GLOBALS['dbinv'],$sqls);
	$row_rss_salrep = mysqli_fetch_array($result_rep);
        
        echo $row_rss_salrep['Name'];
        
        
        
        ?>   </span>      </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style2">P. D .C. C. Incentive Month of <?php echo date("Y-M", strtotime($_GET["DTpiker1"])); ?></span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style2">Gross Sale</span></td>
    <td align="right"></td>
    <td align="right"><span class="style2"><?php echo $txtgsale; ?></span></td>
  </tr>
  <tr>
    <td><span class="style2">Less: GRN relavent to Incentive Month</span></td>
    <td align="right"></td>
    <td align="right"><span class="style2"><?php echo $txtgrn; ?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"></td>
    <td align="right"><span class="style2"><?php
    
    $ss = str_replace(",","",$txtgsale);
    $s2 = str_replace(",","",$txtgrn);
    echo "<u>" .  number_format($ss-$s2,2,".",",")    .   "</u>";
    
    
    ?></span></td>
  </tr>
  <tr>
    <td><span class="style2">Total Outstanding for Relevent Month</span></td>
    <td align="right"></td>
    <td align="right"><span class="style2"><?php echo $txtout; ?></span></td>
  </tr>
  <tr>
    <td><span class="style2">Collected amount</span></td>
    <td align="right"></td>
    <td align="right"><span class="style2"><?php echo $txtcolect; ?></span></td>
  </tr>
  <tr>
    <td><span class="style2">TGRN &amp; TCRN</span></td>
    <td align="right"></td>
    <td align="right"><span class="style2"><?php echo $txtut; ?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="45"><span class="style2">Outstanding Percentage as at today</span></td>
    <td align="right"><span class="style2"><?php echo $txtoutper; ?>%</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="45"><span class="style2">Collected Percentage as at Today</span></td>
    <td align="right"><span class="style2"><?php echo $txtcolper; ?>%</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="45"><span class="style2">Grn Percentage as at Today</span></td>
    <td align="right"><span class="style2"><?php echo $txtgrnper; ?>%</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="45"><span class="style2">TGRN & TCRN Percentage as at</span></td>
    <td align="right"><span class="style2"><?php echo $txtutper; ?>%</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="45"><span class="style2">P.D.C.C. incentive</span></td>
    <td align="right"><span class="style2"><?php echo $txtincper; ?>%</span></td>
    <td align="right"><?php echo $txtincamo; ?></td>
  </tr>
  <tr>
    <td height="45"><span class="style2">P.D.C.C. incentive Payable</span></td>
    <td>&nbsp;</td>
    <td align="right"><span class="style2"><u><?php echo $txtinc; ?></u></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="95">Prepared By:</td>
    <td>Authorized By:</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
