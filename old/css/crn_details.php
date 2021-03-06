
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
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Credit Note Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="14%"><input type="text"  class="label_purchase" value="CRN No" disabled/></td>
    <td width="14%"><input type="text" name="crnno" id="crnno" value="" class="text_purchase" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  />
      <a href="serach_crn.php" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" >
      </a></td>
    <td width="9%">&nbsp;</td>
    <td width="9%"><input type="text"  class="label_purchase1" value="Date" disabled="disabled"/></td>
    <td width="15%"><input type="text"  name="crndate" id="crndate" value="<?php echo date("Y-m-d"); ?>" disabled="disabled" class="text_purchase2"/></td>
    <td width="14%"><input type="text"  class="label_purchase" value="Department" disabled="disabled"/></td>
    <td width="14%"><select name="department" id="department" onkeypress="keyset('brand',event);" class="text_purchase3">
      <option value=""> --Select-- </option>
      <?php
																	$sql="select * from s_stomas order by DESCRIPTION";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
																		if ($row["CODE"]=="01"){
                        													echo "<option selected value='".$row["CODE"]."'>".$row["DESCRIPTION"]."</option>";
																		}	else {
																			echo "<option value='".$row["CODE"]."'>".$row["DESCRIPTION"]."</option>";
																		}
                       												}
																?>
    </select></td>
    <td width="4%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled="disabled"/></td>
    <td><input type="text" disabled="disabled"  class="text_purchase3" name="cus_code" id="cus_code"/></td>
    <td colspan="3"><input type="text" disabled="disabled"  class="text_purchase2" id="cus_name" name="cus_name" />      <a href="" onclick="NewWindow('serach_customer.php?stname=crn','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase" />
      </a></td>
    <td><input type="text"  class="label_purchase" value="Invoice No" disabled="disabled"/></td>
    <td><input type="text" name="invno" id="invno" value="" onkeypress="keyset('orderdate',event);" class="text_purchase"/>
     <a href="serach_inv.php?stname=crn" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"><input type="button" name="searchord" id="searchord" value="..." class="btn_purchase1" >
     <input type="hidden" name="txtrno" id="txtrno" value="" onkeypress="keyset('orderdate',event);" class="text_purchase"/>
     </a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled="disabled"/></td>
    <td colspan="3"><input type="text"  class="text_purchase3"  disabled="disabled" id="cus_address" name="cus_address" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Form No" disabled="disabled"/></td>
    <td width="14%"><input type="text" name="orderno1" id="orderno1" value="" onkeypress="keyset('orderdate',event);" class="text_purchase"/>
     <a href="search_purord.php?stname=arn" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"><input type="button" name="searchord" id="searchord" value="..." class="btn_purchase1" ></a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="85"><input type="text"  class="label_purchase" value="Remarks" disabled/></td>
    <td colspan="3"><textarea name="remarks" id="remarks" cols="60" rows="5" class="text_purchase3"></textarea></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Invoice Date" disabled="disabled"/></td>
    <td><input type="text" size="15" name="inv_date" id="inv_date" value="" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td colspan="4"><select name="salesrep" id="salesrep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase1">
      <?php
																	$sql="select * from s_salrep order by REPCODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
    </select></td>
    <td><input type="text"  class="label_purchase" value="Invoice Amount" disabled="disabled"/></td>
    <td><input type="text" size="15" name="invamount" id="invamount" value="" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
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
    <td><input type="text" size="15" name="amount" id="amount" value="" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Total Paid" disabled="disabled"/></td>
    <td><input type="text" size="15" name="totpay" id="totpay" value="" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
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
    <td><input type="text" size="15" name="invbal" id="invbal" value="" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td><select name="brand" id="brand" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="setord();">
      <?php
																	$sql="select * from brand_mas order by barnd_name";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
                       												}
																?>
    </select></td>
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