
<?php 
/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/




/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/

	

						 
	require_once("config.inc.php");
	require_once("DBConnector.php");
						
	$sql = "delete FROM TMP_EDU_FILTER";
	$db = new DBConnector();
	$result =$db->RunQuery($sql);
						
	$sql = "delete FROM	TMP_QUALI_FILTER";
	$db = new DBConnector();
	$result =$db->RunQuery($sql);
?>	

						 
	



<link rel="stylesheet" href="css/table.css" type="text/css"/>	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript" language="javascript" src="js/get_cat_description.js"></script>
<script type="text/javascript" language="javascript" src="js/datepickr.js"></script>

<script language="javascript" src="cal2.js">
/*
Xin's Popup calendar script-  Xin Yang (http://www.yxscripts.com/)
Script featured on/available at http://www.dynamicdrive.com/
This notice must stay intact for use
*/
</script>
<script language="javascript" src="cal_conf2.js"></script>
<script language="javascript" type="text/javascript">
<!--
/****************************************************
     Author: Eric King
     Url: http://redrival.com/eak/index.shtml
     This script is free to use as long as this info is left in
     Featured on Dynamic Drive script library (http://www.dynamicdrive.com)
****************************************************/
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
// -->
</script>

<script type="text/javascript">
function openWin()
{
myWindow=window.open('serach_inv.php','','width=200,height=100');
myWindow.focus();

}
</script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dte_dor",
			dateFormat:"%Y-%m-%d"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});
	};
</script>

</label>
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Enter GRN Details</div>
                                               	 </legend>             

<form name="form1" id="form1">       
<?php
	
	include_once("connection.php");
	
	$sql=mysql_query("Select * from s_crnma where REF_NO='".$_GET['grn']."'")or die(mysql_error());
	$row = mysql_fetch_array($sql);
	
	?>
			     
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%"><input type="text"  class="label_purchase" value="GRN No" disabled="disabled"/></td>
    <td width="10%"><input type="text" disabled="disabled" name="grnno" id="grnno" value="<?php  echo $row['REF_NO']; ?>" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('grnno');"  onblur="lost_focus('grnno');"  /></td>
    <td width="10%"> <a href="search_grn.php?stname=grn" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"><input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" /></a></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="grndate" id="grndate" value="<?php echo $row['DDATE']; ?>" disabled="disabled" class="text_purchase3"/>     </td>
    <td width="10%"><a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      
    </a></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Department" disabled/></td>
    <td width="10%"><input type="text" size="20" name="department" id="department" value="<?php echo $row['DEPARTMENT']; ?>" disabled="disabled" class="text_purchase3"/>   </td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text" disabled="disabled" name="rno" id="rno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('grnno');"  onblur="lost_focus('grnno');"  /></td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="paymethod" value="credit" id="paymethod_0" />
      Credit</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="paymethod" value="cash" id="paymethod_1" />
      Cash</label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="vat" id="vatgroup_0"  onkeypress="keyset('discount1',event);" />
      VAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="non" id="vatgroup_1"  onkeypress="keyset('discount1',event);" />
      Non VAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="svat" id="vatgroup_2"  onkeypress="keyset('discount1',event);" />
      SVAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="evat" id="vatgroup_3"  onkeypress="keyset('discount1',event);" />
      EVAT Invoice</label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
   <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled/></td>
    <td colspan="3"><input type="text" disabled="disabled"  class="text_purchase1" value="<?php echo $row['C_CODE']; ?>" name="firstname_hidden" id="firstname_hidden"/>
      <input type="text" disabled="disabled"  class="text_purchase2" id="firstname" value="<?php echo $row['CUS_NAME'] ?>" name="firstname" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Invoice No" disabled="disabled"/></td>
    <td><input type="text" size="15" name="invno" id="invno" value="<?php echo $row['INVOICENO']; ?>" onkeypress="keyset('balance',event);" class="text_purchase3" disabled="disabled"/></td>
    <td> <a href="serach_inv.php?stname=grn" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
                                                            <input type="button" name="searchinv2" id="searchinv2" class="btn_purchase1" value="..." >
                                                          </a></td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled/></td>
    <td colspan="2"><input type="text"  class="text_purchase4"  disabled="disabled" id="cus_address" name="cus_address" /></td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td><input type="text"  class="label_purchase" value="Invoice Date" disabled="disabled"/></td>
    <td><input type="text" size="15" name="invdate" id="invdate" disabled="disabled" value="<?php echo $row['SDATE']; ?>" onkeypress="keyset('department',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td><input type="text" size="15" name="brand" id="brand" disabled="disabled" value="<?php echo $row['Brand']; ?>" onkeypress="keyset('department',event);" class="text_purchase3"/> </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td><input type="text"  class="text_purchase4"  id="salesrep" name="salesrep" value="<?php echo $row['SAL_EX']; ?>" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Cost Center" disabled="disabled"/></td>
    <td><input type="text"  class="text_purchase4"  id="costcenter" name="costcenter" value="<?php echo $row['SAL_EX']; ?>" />   </td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Serial No (MC)" disabled="disabled"/></td>
    <td><input type="text" size="5" name="serialno" id="serialno" value="0" onkeypress="keyset('itemd_hidden',event);" class="text_purchase"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
<fieldset>               
            
   	<legend><div class="text_forheader">Item Details</div></legend>            
            
  <table width="84%" border="0">
  
  
  <tr>
	<td colspan="8">
    <div class="CSSTableGenerator" id="itemdetails" >

<?php

echo "<table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Pre.RetQty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ret.Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";
							
				$i=1;
				
				$sql_data = mysql_query("Select count(*) as mcount from s_crntrn where REF_NO='".$row['REF_NO']."'") or die(mysql_error());
				$row_data = mysql_fetch_array($sql_data);
				$mcou=$row_data['mcount'];
				
				//echo "Select * from s_crntrn where REF_NO='".$row['REF_NO']."'";
				$sql_data = mysql_query("Select * from s_crntrn where REF_NO='".$row['REF_NO']."'") or die(mysql_error());
				while($row_data = mysql_fetch_array($sql_data)){
					$sql_itdata = mysql_query("Select * from s_mas where STK_NO='".$row_data['STK_NO']."' and BRAND_NAME='".$row["Brand"]."'") or die(mysql_error());
					$rowit = mysql_fetch_array($sql_itdata);
					
				
					$subtot=(floatval($row_data['PRICE'])*floatval($row_data['QTY']))-floatval($row_data['DIS_RS']);
					if ($row_data['DIS_RS']==""){$DIS_RS=0;} else {$DIS_RS=$row_data['DIS_RS'];}
					if ($row_data['DIS_P']==""){$DIS_P=0;} else {$DIS_P=$row_data['DIS_P'];}
						$stkno="stkno".$i;
						$descript="descript".$i;
						$price="price".$i;
						$qty="qty".$i;
						$preretqty="preret".$i;
						$retqty="ret".$i;
						$disc="disc".$i;
						$subtot="subtot".$i;
			
			
					if (is_null($row_data['QTY']) or $row_data['QTY']==0){
						$ret_qty=0;
					} else {
						$ret_qty=$row_data['QTY'];
					}
					
				
			 		echo "<tr>
                        
							 <td>".$row_data['STK_NO']."</td>
							 <td>".$row_data['DESCRIPT']."</td>
							 <td>".number_format(str_replace(",", "", $row_data['PRICE']), 0, ".", ",")."</td>";
							 
							 $sql_inv = mysql_query("Select * from s_invo where REF_NO='".$row['INVOICENO']."' and STK_NO='".$row_data['STK_NO']."'") or die(mysql_error());
							 $row_inv = mysql_fetch_array($sql_inv);
						
						echo " <td>".number_format(str_replace(",", "", $row_inv['QTY']), 0, ".", ",")."</td>
							 <td><input type=\"text\" name=".$preretqty."  disabled id=".$preretqty."  class=\"text_purchase3\"/></td>
							
							 <td><input type=\"text\" name=".$retqty." id=".$retqty."  class=\"text_purchase3\" value=".$ret_qty." onKeyPress=\"ret_deduct('".$i."',event, '".$mcou."');\"/></td>
							 <td><input type=\"text\" name=".$disc." id=".$disc."  class=\"text_purchase3\" value=\"".$row_data['DIS_per']."\" /></td>
							 <td><input type=\"text\" name=".$subtot." id=".$subtot." value='0' class=\"text_purchase3\"/></td>
							 
							
							 
                            </tr>";
							
							$i=$i+1;
            					
				}
				echo "</table>";	

?>
 </div>                                                 		</td>
                                                		</tr>
  
  <tr>
    <td width="10%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="subtot" id="subtot" value="0" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="hidden" name="mcou" id="mcou" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Discount" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="totdiscount" id="totdiscount" value="0" disabled="disabled"  class="text_purchase3" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Tax" name="taxname" id="taxname" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="tax" id="tax" value="0"  class="text_purchase3"  disabled="disabled" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" rowspan="5"><div id="storgrid"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Invoice Total" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="invtot"  id="invtot" value="0" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>
          

</form>        

</fieldset>    
            
            <table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">