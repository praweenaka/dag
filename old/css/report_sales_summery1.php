<?php 
require_once("config.inc.php");
require_once("DBConnector.php");
$db = new DBConnector();
$dtfrom = date("Y-m-d", strtotime($_POST['dtfrom']) );
$dtto = date("Y-m-d", strtotime($_POST['dtto']) );

?>

<!DOCTYPE html>
<head>
<style>
.tab {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
	page-break-inside:auto
}
.tab th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;

}
.tab td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}

thead { display: table-header-group; }
tfoot { display: table-footer-group; }
</style>
<link rel="stylesheet" href="css/salessummery.css">








</head>	
<body>

<?php

if (($_POST['view'] == "sales" )  or ($_POST['view'] == "scrap" )) {
if (isset($_POST['dis'])) {
$sql = "select * from view_s_invo where dis_per =  '" . $_POST['disval'] . "' and CANCELL='0'";  
} else {
$sql = "select * from s_salma where  CANCELL='0'";  
}
if ($_POST['datew'] == "daily") {
if (isset($_POST['dis'])) {        
$heading = "Sales Summery Report with " .    $_POST['disval'] .  "% Discount On " . $dtfrom   ;     
} else {
$heading = "<h3>Sales Summery Report On " . $dtfrom . "</h3>"  ;     
}
}
if ($_POST['datew'] == "date")  {
if (isset($_POST['dis'])) {    
$heading = "<h3>Sales Summery Report with " .    $_POST['disval'] .  "% Discount From " . $dtfrom . " To "  . $dtto . "</h3>"   ;     
} else {
$heading = "<h3>Sales Summery Report From " . $dtfrom . " To "  . $dtto  . "</h3>"   ;     
}

}   

if ($_POST['view']== "sales") {
    $sql .= " and accname <> 'NON STOCK'   ";
} else {
    $sql .= " and   accname = 'NON STOCK'  ";
}

}


if (isset($_POST['chk_svat'])) {
$sql .= " and svat > '0'";

if ($_POST['datew'] == "daily") {
if (isset($_POST['dis'])) {        
$heading = "Sales Summery Report with " .    $_POST['disval'] .  "% Discount On " . $dtfrom   ;     
} else {
$heading = "<h3>Sales Summery Report On " . $dtfrom . "</h3>"  ;     
}
}
if ($_POST['datew'] == "date")  {
if (isset($_POST['dis'])) {    
$heading = "<h3>S.V.A.T Sales Summery Report with " .    $_POST['disval'] .  "% Discount From " . $dtfrom . " To "  . $dtto . "</h3>"   ;     
} else {
$heading = "<h3>S.V.A.T Sales Summery Report From " . $dtfrom . " To "  . $dtto  . "</h3>"   ;     
}

}

}



if ($_POST['view'] == "return") {
$sql = "select brand from viewreturn where cancell=0   "  ;

if ($_POST['cmbtype']=="All")  {
$sql .= " and  trn_type<>'ARN' and   trn_type<>'REC' and   trn_type<>'INC'";
}

if ($_POST['cmbtype']=="GRN")  {
$sql .= " and  trn_type='GRN'";
}

if ($_POST['cmbtype']=="CRN")  {
$sql .= " and  (trn_type='CNT' OR  trn_type='INC')";
if (isset($_POST['chk_cash'])) {
    $sql .= " and flag1 = '1'";
}

}

if ($_POST['cmbtype']=="DGRN")  {
$sql .= " and  trn_type='DGRN' ";
}



}

if ($_POST['view'] == "Item_Sale") {
$sql = "select * from s_salma where CANCELL='0'"  ;
}


if (isset($sql)) { 
if ($_POST['datew'] == "daily") {
$sql .= " and sdate = '" . $dtfrom  . "'";
} 

if ($_POST['datew'] == "date")  {
$sql .= " and  sdate >= '" . $dtfrom  . "' and sdate <= '" . $dtto . "'";
}

if (isset($_POST['cus'])) {
    if ($_POST['view'] == "sale") {
    $sql .= " and C_CODE = '" .$_POST['c_code']  . "'";
	} else {
	$sql .= " and CUSCODE = '" .$_POST['c_code']  . "'";
	}
}

if ($_POST['brand'] !="All") {
    $sql .= " and brand = '" .$_POST['brand']  . "'";
}

if ($_POST['rep'] !="All") {
    $sql .= " and sal_ex = '" .$_POST['rep']  . "'";
}




if ($_POST['view'] =="return") {
     $sql .= "  group by brand order by brand";   
} else {
     $sql .= "  order by id";   
}


}
echo "<div id=\"res\">";
if (isset($heading)) {
echo $heading ;
}
if (($_POST['view'] == "sales") or ($_POST['view'] == "scrap" )) {
$head= "<thead><tr><th>Date</th><th>Invoice No</th><th>Customer</th><th>Gross Amount</th><th>VAT</th><th>Net Amount</th></tr></thead>";
echo "<table class=\"tab\" style=\"border: 1px solid;\">";
echo $head;
echo "<tbody>";
}

if ($_POST['view'] == "return") {
$head= "<thead><tr><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th></tr></thead>";
echo "<table class=\"tab\" style=\"border: 1px solid;\">";
echo $head;
}

if ($_POST['view'] == "Item_Sale") {
$head= "<thead><tr><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th></tr></thead>";
echo "<table class=\"tab\" style=\"border: 1px solid;\">";
echo $head;
}


$mtot  =0;
$gtot = 0;
$gvat=0;
$gnet=0;
$resrow="";

if (isset($sql)) {
$result =$db->RunQuery($sql);

while($row = mysql_fetch_array($result))
{
  
if (($_POST['view'] == "sales") or ($_POST['view'] == "scrap" )) {
$resrow = "<tr>   
<td>" . $row['SDATE'] ."</td>   
<td>" . $row['REF_NO'] . "</td>
<td>" . $row['C_CODE'] . " - " .  $row['CUS_NAME'] .  "</td>
<td>" . $row['GRAND_TOT'] . "</td>
<td>" . round($row['GRAND_TOT'] -$row['GRAND_TOT']/(1+($row['GST']/100)),2) . "</td>
<td>" . round($row['GRAND_TOT']/(1+($row['GST']/100)),2) . "</td>
</tr>";  
$gtot = $gtot + $row['GRAND_TOT']; 
echo $resrow;
}

$bottom = "
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>" . $gtot .  "</td>
        
        </table>";




if ($_POST['view'] == "return") {


$sql = "select * from viewreturn where cancell=0   "  ;
if ($_POST['cmbtype']=="All")  { $sql .= " and  trn_type<>'ARN' and   trn_type<>'REC' and   trn_type<>'INC'"; }
if ($_POST['cmbtype']=="GRN")  { $sql .= " and  trn_type='GRN'"; }
if ($_POST['cmbtype']=="CRN")  { $sql .= " and  (trn_type='CNT' OR  trn_type='INC')"; }
if ($_POST['cmbtype']=="DGRN")  { $sql .= " and  trn_type='DGRN' "; }
if ($_POST['datew'] == "daily") { $sql .= " and sdate = '" . $dtfrom  . "'"; } 
if ($_POST['datew'] == "date")  { $sql .= " and  sdate >= '" . $dtfrom  . "' and sdate <= '" . $dtto . "'"; }
if (isset($_POST['cus'])) { $sql .= " and CUSCODE = '" .$_POST['c_code']  . "'"; }
$sql .= " and brand = '" . $row['brand']  . "'"; 

$result1 =$db->RunQuery($sql);
if (mysql_num_rows($result1) >= 1) { echo "<tr><td colspan=\"6\" >" . $row['brand'] .  " </td></tr>";  } 
$mtot =0;
$vat=0;
$net=0;

while($return = mysql_fetch_array($result1)) {
$resrow ="<tr>   
<td>" . $return['SDATE'] ."</td>   
<td>" . $return['REFNO'] . "</td>
<td>" . $return['CUSCODE'] . " - " .  $return['NAM'] . "</td>
<td>" . $return['AMOUNT'] . "</td>
<td>" . round($return['AMOUNT'] -$return['AMOUNT']/(1+($return['vatrate']/100)),2) . "</td>
<td>" . round($return['AMOUNT']/(1+($return['vatrate']/100)),2) . "</td>
</tr>"; 
$mtot = $mtot + $return['AMOUNT']; 
$vat = $vat + round($return['AMOUNT'] -$return['AMOUNT']/(1+($return['vatrate']/100)),2);
$net = $net + round($return['AMOUNT']/(1+($return['vatrate']/100)),2);

$gtot= $gtot + $return['AMOUNT']; 
$gvat = $gvat + round($return['AMOUNT'] -$return['AMOUNT']/(1+($return['vatrate']/100)),2);
$gnet = $gnet + round($return['AMOUNT']/(1+($return['vatrate']/100)),2);

echo $resrow;
}
echo "<tr><td></td><td></td><td></td><td style=\"font-weight: bold;\" >" . $mtot . "</td>"  .   "<td style=\"font-weight: bold;\">" . $vat . "</td><td style=\"font-weight: bold;\">" . $net . "</td>";


}
if ($_POST['view'] == "return") { $bottom = "<tr>
        <td></td>
        <td></td>
        <td></td>
        <td>"  . $gtot . "</td>
        <td>" . $gvat .  "</td>
        <td>"  . $gnet .  "</td></tr>
  
</table>";
}




if ($_POST['view'] == "Item_Sale")  {
$sql = "select * from s_invo where ref_no = '" . $row['REF_NO']  . "'";  
$row2 = $db->RunQuery($sql);

  echo "<tr> 
       <td>" .  $row['SDATE']  . "  </td>
       <td>" .  $row['REF_NO']  . "  </td>
       <td>" .  $row['C_CODE'] . "-"  . $row['CUS_NAME']  . "  </td>
       <td colspan =\"5\">" .  $row['Brand']  . "  </td>
       
       </tr>";

    
while($sinv = mysql_fetch_array($row2)) {
    echo "<tr>
    <td colspan =\"4\"></td>
    <td> "  .  $sinv['PART_NO']  . " </td>
    <td> "  .  $sinv['QTY']  . " </td>
    <td> "  .  $sinv['PRICE']  . " </td>
    <td> "  .  $row['SAL_EX']  . " </td>   ";     
}

  echo "<tr> <td colspan=\"6\" >
        </td><td>" . $row['GRAND_TOT']  . "</td> </tr>"       ;
}

if ($_POST['view'] == "Item_Sale") {
       $bottom = "
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>         
        </table>";
}

}
if (isset($bottom)) {
echo $bottom;
}
}


if ($_POST['view'] == "summary") {

$totGrosaleVatamt = 0;
$VatGdRetAmt = 0;
$VATnetSaleAmt = 0;
$TotGroSale = 0;
$VATgroSale = 0;
$NVATatgross = 0;
$TotGdRet =0;
$totsvatgrosale = 0;
$SVATgrosale = 0;
$totgrosaleSVATamou = 0;
$SVATgdRet = 0;
$SVATret = 0;
$SVATNetSale = 0;
$SVATAmount = 0;
$NonSvatNet = 0;
$Totsalret = 0;
$VATGdRet = 0;
$NvaGdRet = 0;
$TotNetSale = 0;
$VATnetSale = 0;
$NonVatNet = 0;
$RctAmount =0;
$OVpAYMENT=0;
    
$sql = "select * from s_salma where ACCNAME <> 'NON STOCK' and CANCELL='0' ";    
if ($_POST['datew'] == "daily") { $sql .= " and sdate = '" . $dtfrom  . "'"; } 
if ($_POST['datew'] == "date")  { $sql .= " and  sdate >= '" . $dtfrom  . "' and sdate <= '" . $dtto . "'"; }
 

$sal =$db->RunQuery($sql);
while($sale = mysql_fetch_array($sal)) {
    
$totGrosaleVatamt = $totGrosaleVatamt + $sale['GRAND_TOT'] * ($sale['GST'] / 100) / (1 + ($sale['GST'] / 100));
$TotGroSale = $TotGroSale + $sale['GRAND_TOT'];

if ($sale['SVAT'] > 0) {
$totsvatgrosale = $totsvatgrosale + $sale['GRAND_TOT'] ;
$totgrosaleSVATamou = $totgrosaleSVATamou + $sale['GRAND_TOT'] * ($sale['GST'] / 100) / (1 + ($sale['GST'] / 100));
}

}

$sql = "select * from c_bal where trn_type<>'ARN' and  trn_type<>'INC'and trn_type<>'REC'";
if ($_POST['datew'] == "daily") { $sql .= " and sdate = '" . $dtfrom  . "'"; } 
if ($_POST['datew'] == "date")  { $sql .= " and  sdate >= '" . $dtfrom  . "' and sdate <= '" . $dtto . "'"; }
$bal =$db->RunQuery($sql);
while($cbal = mysql_fetch_array($bal)) {
    $TotGdRet = $TotGdRet + $cbal['AMOUNT'];
    $sql = "Select * From S_crnma where ref_no = '" . $cbal['REFNO'] . "'";
   
    $ret = $db->RunQuery($sql);
    $crnma = mysql_fetch_array($ret);
    if(!$ret) {
    $rows =  mysql_num_rows($crnma);
    } else { $rows =0; } 
    if ($rows >= 0) { 
        $sql = "Select * from s_salma where ACCNAME <> 'NON STOCK' and ref_no = '" . $crnma['INVOICENO'] . "'";
        $sal = $db->RunQuery($sql);
        $salma = mysql_fetch_array($sal);
        
        if(!$sal) {
         $rows =  mysql_num_rows($salma);
        } else { $rows =0; } 
        if ($rows >= 1) { 
            if ($salma['SVAT'] > 0) { 
                $SVATgdRet = $SVATgdRet + $cbal['AMOUNT'] * ($cbal['vatrate'] / 100) / (1 + ($cbal['vatrate'] / 100));
                $SVATret = $SVATret + $cbal['AMOUNT'];
            }
        }
    }   
    $VatGdRetAmt = $VatGdRetAmt + $cbal['AMOUNT'] * ($cbal['vatrate'] / 100) / (1 + ($cbal['vatrate'] / 100));

}

$sql = "select * from s_crec where CANCELL='0' and flag='REC' and department = 'O'";
if ($_POST['datew'] == "daily") { $sql .= " and ca_date = '" . $dtfrom  . "'"; } 
if ($_POST['datew'] == "date")  { $sql .= " and  ca_date >= '" . $dtfrom  . "' and ca_date <= '" . $dtto . "'"; }
$rec = $db->RunQuery($sql);
while($carec = mysql_fetch_array($rec)) {
    $RctAmount = $RctAmount + $carec['CA_AMOUNT'] + $carec['CA_CASSH'];
    $OVpAYMENT = $OVpAYMENT + $carec['overpay'];
}




$VATgroSale = $totGrosaleVatamt;
$VATGdRet = $VatGdRetAmt;
$TotNetSale = $TotGroSale - $TotGdRet;
$VATnetSale = $totGrosaleVatamt - $VatGdRetAmt;
$NonVatNet = $TotNetSale - $VATnetSale;

$SVATgrosale = $totgrosaleSVATamou;
$SVATgdRet = $SVATgdRet;
$SVATNetSale = $totsvatgrosale - $SVATret; 
$SVATAmount = $totgrosaleSVATamou - $SVATgdRet;
$NonSvatNet = $SVATNetSale - $SVATAmount;


if ($_POST['datew'] == "daily") {
    echo "<h3>Sales Report on " . $dtfrom .  "</h3>";
} 

if ($_POST['datew'] == "date")  {
    echo "<h3>Sales Report From " . $dtfrom . " To "  . $dtto . "</h3>";
}


echo "<table id =\"ssummery\">
<tr><td  id =\"sumcol\">Total Sales</td><td>:</td> <td id =\"sumcoll\" > " . round($TotGroSale,2) . "</td></tr>
<tr> <td id =\"sumcol\">VAT/SVAT On Sales </td><td>:</td><td id =\"sumcoll\"> ".   round($VATgroSale,2) . "</td></tr>
<tr> <td id =\"sumcol\">  <td><td> <td id =\"sumcoll\"> </td>      

<tr> <td id =\"sumcol\">Total Goods Returns </td><td>:</td><td id =\"sumcoll\"> ".   round($TotGdRet,2) . "</td></tr>
<tr > <td id =\"sumcol\">VAT/SVAT on Goods  Returns</td><td>:</td><td id =\"sumcoll\"> ".   round($VATGdRet,2) . "</td></tr>

<tr> <td id =\"sumcol\">  <td><td> <td id =\"sumcoll\"> </td> 

<tr > <td id =\"sumcol\">Total Gross Sales </td><td>:</td><td id =\"sumcoll\"> ".   round($TotNetSale,2) . "</td></tr>    
<tr > <td id =\"sumcol\">VAT/SVAT On Gross Sales </td><td>:</td><td id =\"sumcoll\"> ".   round($VATnetSale,2) . "</td></tr>
    
<tr> <td id =\"sumcol\">  <td><td> <td id =\"sumcoll\"> </td> 

<tr> <td id =\"sumcol\">Net  Sales (Without VAT/SVAT)</td><td>:</td><td id =\"sumcoll\"> ".   round($NonVatNet,2) . "</td></tr>
<tr> <td id =\"sumcol\">Receipt Summery(Settlement) </td><td>:</td><td id =\"sumcoll\"> ".   round($RctAmount,2) . "</td></tr>
<tr> <td id =\"sumcol\">Over Payment </td><td>:</td><td id =\"sumcoll\"> ".   round($OVpAYMENT,2) . "</td></tr>
<tr> <td id =\"sumcol\">Receipt Total      </td><td>:</td><td id =\"sumcoll\"> ".   round($RctAmount - $OVpAYMENT,2) . "</td></tr>
    


  
</table>"; 

//<tr style=\"column-width: 500px;\"> <td>Total Sales </td><td> ".   $totsvatgrosale . "</td></tr>  
//<tr style=\"column-width: 500px;\"> <td>SVAT On Sales </td><td> ".   $SVATgrosale . "</td></tr>     
//<tr style=\"column-width: 500px;\"> <td>Total Goods Returns</td><td> ".   $SVATret . "</td></tr>
//    
//<tr style=\"column-width: 500px;\"> <td>SVAT on Goods  Returns</td><td> ".   $SVATgdRet . "</td></tr>
//<tr style=\"column-width: 500px;\"> <td>Total Gross Sales</td><td> ".   ($SVATNetSale) . "</td></tr>
//<tr style=\"column-width: 500px;\"> <td>SVAT On Gross Sales</td><td> ".  $SVATAmount . "</td></tr>    
//<tr style=\"column-width: 500px;\"> <td>Net  Sales (Without SVAT)</td><td> ".  $NonSvatNet . "</td></tr>
//<tr style=\"column-width: 500px;\"> <td>Total Sales</td><td> ".   ($TotGroSale - $totsvatgrosale) . "</td></tr>
//<tr style=\"column-width: 500px;\"> <td>VAT On Sales </td><td> ".   ($VATgroSale - $SVATgrosale) . "</td></tr>
//<tr style=\"column-width: 500px;\"> <td>Total Goods Returns </td><td> ".   ($TotGdRet - $SVATret) . "</td></tr>    
//<tr style=\"column-width: 500px;\"> <td>VAT on Goods  Returns   </td><td> ".   ($VATGdRet - $SVATgdRet) . "</td></tr>
//<tr style=\"column-width: 500px;\"> <td>Total Gross Sales</td><td> ".   ($TotNetSale - $SVATNetSale) . "</td></tr>    
//<tr style=\"column-width: 500px;\"> <td>VAT On Gross Sales</td><td> ".   ($VATnetSale - $SVATAmount) . "</td></tr>    
//<tr style=\"column-width: 500px;\"> <td>Net  Sales (Without VAT)</td><td> ".   ($NonVatNet - $NonSvatNet) . "</td></tr> 




}


if ($_POST['view'] == "recipt")  {
$sql = "select * from s_crec where CANCELL='0'";
if ($_POST['datew'] == "daily") { $sql .= " and ca_date = '" . $dtfrom  . "'"; } 
if ($_POST['datew'] == "date")  { $sql .= " and  ca_date >= '" . $dtfrom  . "' and ca_date <= '" . $dtto . "'"; }
 
if ($_POST['cmbRECtype']  !=  "All") {
   if ($_POST['cmbRECtype'] == "Ret.ch") { 
       $rettype = "RET" ;        
   }
   
   if ($_POST['cmbRECtype'] == "Normal") { 
       $rettype = "REC";      
   }  
   $sql .= " and flag = '" . $rettype . "'";
}

if (isset($_POST['cus'])) { 
    $sql .= " and CA_CODE = '" .$_POST['c_code']  . "'";  
}

$s_crec = $db->RunQuery($sql);    
   $sql = "delete from tmpreceipt" ;
   $res = $db->RunQuery($sql);
   
while ($screc= mysql_fetch_array($s_crec))     {
  if ($screc['CA_CASSH'] >0 ) {
     if ($screc['pay_type'] == "Cheque") {
         $paytpe = 'Cash';
     } else {
         $paytpe = $screc['pay_type'];
     }
        
     
     $sql = "insert into tmpreceipt (REF_NO,CUS_REF,ptype,SDATE,cash,DEPARTMENT) values
      ('" . $screc['CA_REFNO']   . "', '" . $screc['cus_ref']  . "', '" .  $paytpe . "', '" . $screc['CA_DATE'] . "' , '" . $screc['CA_CASSH'] . "' , '" . $screc['DEPARTMENT'] . "')";

     $res = $db->ExecuteQuery($sql); 
      
  }  else {
     $sql = "select * from s_invcheq where refno='" . $screc['CA_REFNO'] . "'" ;
    
     $s_cheq = $db->ExecuteQuery($sql); 
      while ($scheq = mysql_fetch_array($s_cheq)) {
          $sql = "select * from tmpreceipt where ch_no = '" . $scheq['cheque_no'] . "'";
          $c_count = $db->RunQuery($sql);
          $count = mysql_fetch_array($c_count);
          
          if (!$c_count) {
          if (mysql_num_rows($count) >0) {
              $chQty = $chQty +1;
          }
          }
          
          $sql = "insert into tmpreceipt (REF_NO,SDATE,ch_date,ch_no,ch_amount,bank,branch,DEPARTMENT) values
          ('" . mysql_escape_string($screc['CA_REFNO'])   . "', '" . $screc['CA_DATE']  . "', '" .  $scheq['che_date'] . "', '" . mysql_escape_string($scheq['cheque_no']) . "' , '" . mysql_escape_string($scheq['che_amount']) . "' , '" . mysql_escape_string($scheq['cus_code']) . "' ,'" . mysql_escape_string($scheq['bank']) . "' , '" . mysql_escape_string($scheq['department']) . "')";
          
          
          $res = $db->ExecuteQuery($sql); 
          
      }
      
      
      
      
      
      
      
  }
    
}


if ($_POST['datew'] == "daily") { $from= "Receipt Summery Report On " . $dtfrom ; }
if ($_POST['datew'] == "date") { $from= "Receipt Summery Report From " .  $dtfrom . " To " . $dtto ;  }

      
        
if ($_POST['cmbRECtype'] == "Ret.ch") { $strhead=  "Return Cheque"; }
if ($_POST['cmbRECtype'] == "Normal")  { $strhead = "Invoice"; }
if ($_POST['cmbRECtype'] == "All")  {  $strhead= "All";  }

if (isset($_POST['cus']))  { 
    $cusn =  "Customer  " . $_POST['c_code']  .  "  - " . $_POST['c_name'] ;
    }
       


echo "<h4>" . $from  . "</h4><br>";  
echo  $strhead  . "<br>";  
if (isset($cusn)) {
echo $cusn . "<br>";
}


$head = "<thead><table class=\"tab\">
<tr>
<th>Date</th>
<th>Ref NO</th>
<th>Cash</th>
<th>Cash TT</th>
<th>J/Entry</th>
<th>Cheque No</th>
<th>Cheque Date</th>
<th>Amount</th>
<th>Scrap</th>
</tr></thead>";
echo $head;

$sql = "select * from tmpreceipt ORDER BY SDATE";
$tmp= $db->RunQuery($sql);
$tcash =0;
$tcashtt =0;
$tcashjj =0;
$tscrap =0;
$tcheq =0;
echo "<tbody>";
while ($tmp1= mysql_fetch_array($tmp)) {
   if (($tmp1['DEPARTMENT']=="O") and ($tmp1['ptype'] == "Cash")) {
                $cash =  $tmp1['cash'] ;
                $tcash= $tcash+ $tmp1['cash'];
                } else {  $cash = ""; }
  if (($tmp1['DEPARTMENT']=="O") and (($tmp1['ptype'] == "Cash TT") or ($tmp1['ptype'] == "C/TT")  )) {
                $cashtt =  $tmp1['cash'] ;
                $tcashtt= $tcashtt+ $tmp1['cash'];
                } else {  $cashtt = ""; }
   if (($tmp1['DEPARTMENT']=="O") and ($tmp1['ptype'] == "J/Entry")) {
                $cashjj =  $tmp1['cash'] ;
                $tcashjj= $tcashjj+ $tmp1['cash'];
                } else {  $cashjj = ""; }                
   if (($tmp1['DEPARTMENT']=="S") and ($tmp1['ptype'] == "Cash")) {
                $scrap =  $tmp1['cash'] ;
                $tscrap= $tscrap+ $tmp1['cash'];
                } else {  $scrap = ""; }
   $tcheq = $tcheq +     $tmp1['ch_amount'];          
   $res = "<tr><td>" . $tmp1['sdate']  . "</td>
           <td>" . $tmp1['ref_no'] . "</td>
           <td>" . $cash . "</td>           
           <td>" . $cashtt . "</td>
           <td>" . $cashjj . "</td>
           <td>" . $tmp1['ch_no'] . "</td>
           <td>" . $tmp1['ch_date'] . "</td> 
           <td>" . $tmp1['ch_amount'] . "</td>
           <td>" . $scrap . "</td>";    
   echo $res; 
    
    
    
}

echo "<tr>
<td>Total</td>
<td></td>
<td style=\"font-weight:bold;\">" . $tcash  . " </td>
<td style=\"font-weight:bold;\">". $tcashtt  . "  </td>
<td style=\"font-weight:bold;\">" . $tcashjj .   "</td>
<td></td>
<td></td>
<td style=\"font-weight:bold;\">" . $tcheq . "</td>
<td style=\"font-weight:bold;\">" . $tscrap  . "</td>

</tr></tbody></table>";    
    
    
}







?>


    
</div>


</body>
</html>