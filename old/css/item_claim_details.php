
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

<script type="text/javascript">
function load_calader(tar){
		new JsDatePick({
			useMode:2,
			target:tar,
			dateFormat:"%Y-%m-%d"
			
		});
		
	}

</script>
</label>
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Enter Claim Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td align="right" >&nbsp;</td>
    <td colspan="4"  >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="Prn_md" id="Prn_md" />
      Print to Management</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="10%" align="right" ><label><a href="" onclick="NewWindow('search_claim_item.php?stname=claim_item','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust3" id="searchcust3" value="..."  class="btn_purchase1" />
    </a></label></td>
    <td width="10%" colspan="4"  ><label>
    <input type="text" disabled="disabled" name="txtrefno" id="txtrefno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  />
    </label></td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="text"  class="label_purchase" value="Entry Date" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="txtentdate" id="txtentdate" disabled="disabled" value="<?php echo date("Y-m-d"); ?>" class="text_purchase3"/></td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="text"  class="label_purchase" value="Date From" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="dtf" id="dtf" value="<?php echo date("Y-m-d"); ?>" class="text_purchase3"/></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Claim No" disabled="disabled"/></td>
    <td colspan="4"><input type="text" name="txtcl_no" id="txtcl_no" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Recieved Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="DTPicker_recdate" id="DTPicker_recdate" value="<?php echo date("Y-m-d"); ?>" onclick="load_calader('DTPicker_recdate')" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Date To" disabled="disabled"/></td>
    <td><input type="text" size="20" name="dtto" id="dtto" value="<?php echo date("Y-m-d"); ?>" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Agent" disabled/></td>
    <td colspan="6"><input type="text" disabled="disabled"  class="text_purchase1" name="txtag_code" id="txtag_code"/>
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
    <td colspan="5"><input type="text"  class="text_purchase4"  disabled="disabled" id="txtagadd" name="txtagadd" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Customer Address" disabled/></td>
    <td colspan="3"><input type="text"  class="text_purchase4" id="txtcus_add" name="txtcus_add" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="4"><input type="text"  class="label_purchase" value="Stk No" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Description" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Pattern" disabled="disabled"/></td>
    <td colspan="2"><input type="text"  class="label_purchase" value="Seri No" disabled="disabled"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><a href="" onclick="NewWindow('serach_item_claim.php?stname=claim_item','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust2" id="searchcust2" value="..."  class="btn_purchase1" />
    </a></td>
    <td colspan="4"><input type="text" size="20" name="txtstk_no" id="txtstk_no" disabled="disabled" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/></td>
    <td><input type="text" size="20" name="txtdes" id="txtdes" disabled="disabled" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
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
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41"><input type="text"  class="label_purchase" value="Type of Defects" disabled="disabled"/></td>
    <td colspan="9"><select name="Combo1" id="Combo1" onkeypress="keyset('dte_dor',event);" onchange="settec_obs();" class="text_purchase3">
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
    <td colspan="9" rowspan="2"><textarea name="txttc_ob" id="txttc_ob" cols="45" rows="5"></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Refund" disabled="disabled"/></td>
    <td colspan="5"><select name="Cmb_refund" id="Cmb_refund" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
    <option value='Recommended'>Recommended</option>
    <option value='Not Recommended'>Not Recommended</option>
    
    </select></td>
    <td>&nbsp;</td>
    <td colspan="4" rowspan="3"><table  border="0">
      <tr>
        <th scope="col"><input type="text"  class="label_purchase" value="Spec" disabled="disabled"/></th>
        <th scope="col"><input type="text"  class="label_purchase" value="Remming" disabled="disabled"/></th>
        <th scope="col"><input type="text"  class="label_purchase" value="Ref Per" disabled="disabled"/></th>
      </tr>
      <tr>
        <td><input type="text" size="20" name="txtspec" id="txtspec" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
        <td><input type="text" size="20" name="txtremming" id="txtremming" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
        <td><input type="text" size="20" name="txtref_per" id="txtref_per" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Remaining Threads %" disabled="disabled"/></td>
    <td colspan="4" rowspan="2"><table width="184" border="0">
      <tr>
        <th width="30" scope="col"><input type="text" size="5" name="txtremin1" id="txtremin1" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/></th>
        <th width="30" scope="col"><input type="text" size="5" name="txtremin2" id="txtremin2" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/></th>
        <th width="30" scope="col"><input type="text" size="5" name="txtremin3" id="txtremin3" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/></th>
        <th width="30" scope="col"><input type="text" size="5" name="txtremin4" id="txtremin4" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/></th>
        <th width="30" scope="col"><input type="text" size="5" name="txtremin5" id="txtremin5" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/></th>
      </tr>
      <tr>
        <td colspan="5"><hr /></td>
        </tr>
      <tr>
        <td><input type="text" size="5" name="txtorigin1" id="txtorigin1" value="" onkeypress="keyset('vat2',event);" class="text_purchase3" onblur="calc_rem();"/></td>
        <td><input type="text" size="5" name="txtorigin2" id="txtorigin2" value="" onkeypress="keyset('vat2',event);" class="text_purchase3" onblur="calc_rem();"/></td>
        <td><input type="text" size="5" name="txtorigin3" id="txtorigin3" value="" onkeypress="keyset('vat2',event);" class="text_purchase3" onblur="calc_rem();"/></td>
        <td><input type="text" size="5" name="txtorigin4" id="txtorigin4" value="" onkeypress="keyset('vat2',event);" class="text_purchase3" onblur="calc_rem();"/></td>
        <td><input type="text" size="5" name="txtorigin5" id="txtorigin5" value="" onkeypress="keyset('vat2',event);" class="text_purchase3" onblur="calc_rem();"/></td>
      </tr>
    </table>
      <br /></td>
    <td rowspan="2"><input type="text" size="5" name="txtrem_per" id="txtrem_per" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/></td>
    <td rowspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Commercialy" disabled="disabled"/></td>
    <td colspan="5"><select name="cmb_comm" id="cmb_comm" onkeypress="keyset('dte_dor',event);" class="text_purchase3">
      <option value='Allowed'>Allowed</option>
      <option value='Not Allowed'>Not Allowed</option>
                       											
    </select></td>
    <td><input type="checkbox" name="Check1" id="Check1" onclick="show_hide()" />
      Additional Refund</td>
    <td colspan="3">
    <div id="additional">
    
      <input type="hidden" size="20" name="txtadd_ref1" id="txtadd_ref1" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/>
      <input type="hidden" size="20" name="txtadd_ref2" id="txtadd_ref2" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/>
      </div>      </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><input type="text"  class="label_purchase" value="Management Fuether Observation" disabled="disabled"/></td>
    <td colspan="3" rowspan="2"><textarea name="txtmn_ob" id="txtmn_ob" cols="45" rows="5"></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="DGRN No 1" disabled="disabled"/></td>
    <td colspan="4"><input type="text" size="20" name="txtCRD_no" id="txtCRD_no" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRE_date" id="txtCRE_date" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td><input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRE_amount" id="txtCRE_amount" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="DGRN No 2" disabled="disabled"/></td>
    <td colspan="4"><input type="text" size="20" name="txtCRD_no2" id="txtCRD_no2" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRE_date2" id="txtCRE_date2" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td><input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtCRE_amount2" id="txtCRE_amount2" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="DGRN No 3" disabled="disabled"/></td>
    <td colspan="4"><input type="text" size="20" name="txtCRD_no3" id="txtCRD_no3" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
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