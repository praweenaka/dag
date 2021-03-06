
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

						 
	


<script language="JavaScript" src="js/ord.js"></script>
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
  <div class="text_forheader">Enter Claim Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%" align="right" ><label><a href="" onclick="NewWindow('search_claim_item.php?stname=claim_item_b','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust3" id="searchcust3" value="..."  class="btn_purchase1" />
    </a></label></td>
    <td width="10%"  ><label>
    <input type="text" disabled="disabled" name="txtrefno" id="txtrefno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  />
    </label></td>
    <td width="10%" colspan="-2">&nbsp;</td>
    <td width="10%"><input type="text"  class="label_purchase" value="Entry Date" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="txtentdate" id="txtentdate" value="<?php echo date("Y-m-d"); ?>" class="text_purchase3"/></td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="text"  class="label_purchase" value="Sold Date to Dealer" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="DTPicker_ddate" id="DTPicker_ddate" value="<?php echo date("Y-m-d"); ?>" class="text_purchase3"/></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Claim No" disabled="disabled"/></td>
    <td><input type="text" name="txtcl_no" id="txtcl_no" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
    <td colspan="-2">&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Recieved Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="DTPicker_recdate" id="DTPicker_recdate" value="<?php echo date("Y-m-d"); ?>" class="text_purchase3"/></td>
    <td><input type="checkbox" name="Check1" id="Check1" />Date ok</td>
    <td><input type="text"  class="label_purchase" value="Sold Date To Customer" disabled="disabled"/></td>
    <td><input type="text" size="20" name="DTPicker_cdate" id="DTPicker_cdate" value="<?php echo date("Y-m-d"); ?>" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Agent" disabled/></td>
    <td colspan="3"><input type="text" disabled="disabled"  class="text_purchase1" name="txtag_code" id="txtag_code"/>
      <input type="text" disabled="disabled"  class="text_purchase2" id="txtag_name" name="txtag_name" />
      <a href="" onClick="NewWindow('serach_customer.php?stname=item_claim','mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase">
      </a></td>
    <td><input type="text"  class="label_purchase" value="Customer Name" disabled/></td>
    <td colspan="2"><input type="text" class="text_purchase2" id="txtcus_name" name="txtcus_name" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled/></td>
    <td colspan="2"><input type="text"  class="text_purchase4"  disabled="disabled" id="txtagadd" name="txtagadd" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Customer Address" disabled/></td>
    <td colspan="3"><input type="text"  class="text_purchase4" id="txtcus_add" name="txtcus_add" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Stk No" disabled="disabled"/></td>
    <td colspan="-2"><input type="text"  class="label_purchase" value="Description" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Batch No" disabled="disabled"/></td>
    <td colspan="2"><input type="text"  class="label_purchase" value="Battery Serial No" disabled="disabled"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><a href="" onclick="NewWindow('serach_item.php?stname=claim_item','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust2" id="searchcust2" value="..."  class="btn_purchase1" />
    </a></td>
    <td><input type="text" size="20" name="txtstk_no" id="txtstk_no" disabled="disabled" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/></td>
    <td colspan="-2"><input type="text" size="20" name="txtdes" id="txtdes" disabled="disabled" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td><input type="text" size="20" name="txtbrand" id="txtbrand" disabled="disabled" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/></td>
    <td><label>
      <input type="text" size="20" name="txtpatt" id="txtpatt" disabled="disabled" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/>
    </label></td>
    <td colspan="2"><input type="text" size="20" name="txtseri_no" id="txtseri_no" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/>
      <label></label>      <label></label></td>
    <td><label></label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="22">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="22">&nbsp;</td>
    <td colspan="5">
     <div class="CSSTableGenerator" id="itemdetails" >
<table>
                                                        			<tr>
                              											<td width="40%"   background="images/headingbg.gif" ><font color="#FFFFFF">Type</font></td>
                              											<td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Cell-1</font></td>
                              											<td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Cell-2</font></td>
                              											<td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Cell-3</font></td>
                                                                        <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Cell-4</font></td>
                                                                        <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Cell-5</font></td>
                                                                        <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Cell-6</font></td>
                           											</tr>
                                                                    
                                                                    	<tr>
                              											<td >Electrolite Level</td>
                              											<td ><input name="t11" id="t11" type="text" /></td>
                              											<td ><input name="t12" id="t12" type="text" /></td>
                              											<td ><input name="t13" id="t13" type="text" /></td>
                                                                        <td ><input name="t14" id="t14" type="text" /></td>
                                                                        <td ><input name="t15" id="t15" type="text" /></td>
                                                                        <td ><input name="t16" id="t16" type="text" /></td>
                           											</tr>
                                                                    <tr>
                              											<td >Initial Level SPG</td>
                              											<td ><input name="t21" id="t21" type="text" /></td>
                              											<td ><input name="t22" id="t22" type="text" /></td>
                              											<td ><input name="t23" id="t23" type="text" /></td>
                                                                        <td ><input name="t24" id="t24" type="text" /></td>
                                                                        <td ><input name="t25" id="t25" type="text" /></td>
                                                                        <td ><input name="t26" id="t26" type="text" /></td>
                           											</tr>
                                                                    <tr>
                              											<td>After Charging SPG</td>
                              											<td ><input name="t31" id="t31" type="text" /></td>
                              											<td ><input name="t32" id="t32" type="text" /></td>
                              											<td ><input name="t33" id="t33" type="text" /></td>
                                                                        <td ><input name="t34" id="t34" type="text" /></td>
                                                                        <td ><input name="t35" id="t35" type="text" /></td>
                                                                        <td ><input name="t36" id="t36" type="text" /></td>
                           											</tr>
                   												</table>   </div>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="22">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41"><input type="text"  class="label_purchase" value="Type of Defects" disabled="disabled"/></td>
    <td colspan="6"><select name="Combo1" id="Combo1" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
      <?php
																	$sql="select tc_ob from c_clamas group by tc_ob order by tc_ob";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["tc_ob"]."'>".$row["tc_ob"]."</option>";
                       												}
																?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Technical Observation" disabled="disabled"/></td>
    <td colspan="6" rowspan="2"><textarea name="txttc_ob" id="txttc_ob" cols="45" rows="5"></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Claim" disabled="disabled"/></td>
    <td colspan="2"><select name="Cmb_refund" id="Cmb_refund" onkeypress="keyset('dte_dor',event);" onchange="show_claim();" class="text_purchase3">
    <option value=''>Select</option>
    <option value='Recommended'>Recommended</option>
    <option value='Not Recommended'>Not Recommended</option>
    
    </select></td>
    <td><div id="claim">
      <input type="hidden"  class="label_purchase" value="Claim" id="cmb_cl_type" name="cmb_cl_type" disabled="disabled"/>
    </div></td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td><input type="text"  class="label_purchase" value="Commercialy" disabled="disabled"/></td>
    <td colspan="2"><div id="commerc"><input type="hidden"  class="label_purchase" value="Commercialy" id="cmb_comm" name="cmb_comm" disabled="disabled"/> </div></td>
    <td><div id="commercialy_sub"><input type="hidden"  class="label_purchase" value="Commercialy" id="cmb_c_Cl_type" name="cmb_c_Cl_type" disabled="disabled"/>   </div></td>
    <td colspan="2"><div id="commercialy_ref">
      <input type="hidden" size="20" name="txtadd_ref1" id="txtadd_ref1" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/>
      
      <input type="hidden" size="20" name="txtadd_ref2" id="txtadd_ref2" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="text"  class="label_purchase" value="Management Fuether Observation" disabled="disabled"/></td>
    <td rowspan="2"><textarea name="txtmn_ob" id="txtmn_ob" cols="45" rows="5"></textarea></td>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="DGRN No 1" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRD_no" id="txtCRD_no" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td colspan="-2"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRE_date" id="txtCRE_date" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td><input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRE_amount" id="txtCRE_amount" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="DGRN No 2" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRD_no2" id="txtCRD_no2" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td colspan="-2"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRE_date2" id="txtCRE_date2" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td><input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRE_amount2" id="txtCRE_amount2" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="DGRN No 3" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRD_no3" id="txtCRD_no3" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td colspan="-2"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRE_date3" id="txtCRE_date3" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td><input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRE_amount3" id="txtCRE_amount3" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
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