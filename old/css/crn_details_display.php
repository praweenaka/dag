
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
			target:"dte_shedule",
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
      
 <?php
 	$sql="Select * from cred where C_REFNO='".$_GET['crnno']."'";
	$result =$db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
 ?>     
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Credit Note Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="14%"><input type="text"  class="label_purchase" value="CRN No" disabled/></td>
    <td width="14%"><input type="text" name="crnno" id="crnno" value="<?php echo $row["C_REFNO"]; ?>" class="text_purchase" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
    <td width="9%">&nbsp;</td>
    <td width="9%"><input type="text"  class="label_purchase1" value="Date" disabled="disabled"/></td>
    <td width="15%"><input type="text"  name="crndate" id="crndate" value="<?php echo $row["C_DATE"]; ?>" disabled="disabled" class="text_purchase2"/></td>
    <td width="14%"><input type="text"  class="label_purchase" value="Department" disabled="disabled"/></td>
    <?php
		$sql2="Select * from c_bal where REFNO='".$_GET['crnno']."'";
		$result2 =$db->RunQuery($sql2);	
		$row2 = mysql_fetch_array($result2);
		
	?>
    <td width="14%"><input type="text"  name="department" id="department" value="<?php echo $row2["DEP"]; ?>" disabled="disabled" class="text_purchase2"/>   </td>
    <td width="4%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled="disabled"/></td>
    <td><input type="text" disabled="disabled" value="<?php echo $row["C_CODE"]; ?>"  class="text_purchase3" name="cus_code" id="cus_code"/></td>
    <?php 
		$sql1="Select * from vendor where CODE='".$row["C_CODE"]."'";
		$result1 =$db->RunQuery($sql1);	
		$row1 = mysql_fetch_array($result1);
	
			$sql3="Select * from s_salma where REF_NO='".$row["C_INVNO"]."'";
			$result3 =$db->RunQuery($sql3);	
			$row3 = mysql_fetch_array($result3);
	
	 ?>	
    <td colspan="3"><input type="text" disabled="disabled" value="<?php echo $row1["NAME"]; ?>"  class="text_purchase2" id="cus_name" name="cus_name" /></td>
    <td><input type="text"  class="label_purchase" value="Invoice No" disabled="disabled"/></td>
    <td><input type="text" name="invno" id="invno" value="<?php echo $row["C_INVNO"]; ?>" onkeypress="keyset('orderdate',event);" class="text_purchase"/>
     <a href="serach_inv.php?stname=crn" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
     <input type="hidden" name="txtrno" id="txtrno" value="" onkeypress="keyset('orderdate',event);" class="text_purchase"/>
     </a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled="disabled"/></td>
    <td colspan="3"><input type="text"  class="text_purchase3"  disabled="disabled" value="<?php echo $row1["ADD1"]." ".$row1["ADD2"]; ?>" id="cus_address" name="cus_address" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Form No" disabled="disabled"/></td>
    <td width="14%"><input type="text" name="orderno1" id="orderno1" value="" onkeypress="keyset('orderdate',event);" disabled="disabled" class="text_purchase"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Remarks" disabled/></td>
    <td colspan="3"><textarea name="remarks" id="remarks" cols="45" rows="2" class="text_purchase3"><?php echo $row["C_REMARK"]; ?></textarea></td>
    <td>&nbsp;</td>
    
    <td><input type="text"  class="label_purchase" value="Invoice Date" disabled="disabled"/></td>
    <td><input type="text" size="15" name="inv_date" id="inv_date" value="<?php  echo $row3["SDATE"]; ?>" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td colspan="4"><input type="text" disabled="disabled" value="<?php echo $row["C_SALEX"]; ?>"  class="text_purchase3" name="salesrep" id="salesrep"/></td>
    <td><input type="text"  class="label_purchase" value="Invoice Amount" disabled="disabled"/></td>
    <td><input type="text" size="15" name="invamount" id="invamount" value="<?php echo $row3['GRAND_TOT']; ?>" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Cost Centre" disabled="disabled"/></td>
    <td><select name="costcenter" id="costcenter" onkeypress="keyset('vatgroup_0',event);" class="text_purchase3" onchange="assignbrand();">
      <option> --Select-- </option>
      <option value='1'>1</option>
      <option value='2'>2</option>
      <option value='3'>3</option>
      <option value='4'>4</option>
      <option value='5'>5</option>
      <option value='6'>6</option>
      <option value='7'>7</option>
      <option value='8'>8</option>
      <option value='9'>9</option>
      <option value='10'>10</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></td>
    <td><input type="text" size="15" name="amount" id="amount" value="<?php echo $row["C_PAYMENT"]; ?>" disabled="disabled" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Total Paid" disabled="disabled"/></td>
    <td><input type="text" size="15" name="totpay" id="totpay" value="<?php  echo $row3['TOTPAY']; ?>" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Invoice Balance" disabled="disabled"/></td>
    <?php 
		$bal=$row3['GRAND_TOT']-$row3['TOTPAY'];
	 ?>
    <td><input type="text" size="15" name="invbal" id="invbal" value="<?php  echo $bal; ?>" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td><input type="text" size="15" name="amount" id="amount" value="<?php echo $row["Brand"]; ?>" disabled="disabled" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="chkcash_disc" id="chkcash_disc" />
      Cash Discount</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Settled" disabled="disabled"/></td>
    <td><input type="text" size="15" name="settled" id="settled" value="" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
              
            
  
</form>        

</fieldset>    
            
            <table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">