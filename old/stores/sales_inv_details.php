<?php session_start();
/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/




/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/

	

						 
	require_once("connectioni.php");
	
 
?>	

						 
	



<link rel="stylesheet" href="css/table_min.css" type="text/css"/>	
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
  <div class="text_forheader">Enter Order Details</div>
                                               	 </legend>             

<form name="form1" id="form1"> <input type="hidden" name="cmd_new" id="cmd_new" value="1" />
    <input type="hidden" name="cmd_save" id="cmd_save" value="0"/>
    <input type="hidden" name="cmd_cancel" id="cmd_cancel" value="0"/>
    <input type="hidden" name="cmd_print" id="cmd_print" value="0"/>
    <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%" ><input type="text"  class="label_purchase" value="Delivery Date" disabled="disabled"/></td>
    <td width="10%"  ><input type="text" size="20" name="DTdel_date" id="DTdel_date" value="<?php echo date("Y-m-d"); ?>"  onfocus="load_calader('DTdel_date');" class="text_purchase3"/></td>
    <td width="10%"><input type="checkbox" name="checkbox" id="checkbox" />
        <input type="button" name="searchinv2" onclick="save_deli_date();" id="searchinv2" value="Update" class="btn_purchase1" /></td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Driver" disabled="disabled"/>
    </span></td>
    <td width="10%"><input type="text" size="15" name="com_driver"  id="com_driver" value="" class="text_purchase3" onkeypress="keyset('com_vehe',event);" /></td>
    <td width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Vehicle No" disabled="disabled"/>
    </span></td>
    <td width="10%"><input type="text" size="15" name="com_vehe"  id="com_vehe" value="" class="text_purchase3"/></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="paymethod" value="credit" id="paymethod_0" disabled="disabled"/>
      Credit</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="paymethod" value="cash" id="paymethod_1" disabled="disabled"/>
      Cash</label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Invoice No" disabled/></td>
    <td colspan="3">
    <a href="serach_inv.php?stname=inv_mast_saved" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
      <input type="button" name="searchcust2" id="searchcust2" value="Saved"  class="btn_purchase" /></a>
    <input type="text"  class="text_purchase" name="invno" id="invno" disabled="disabled"/>
    <a href="serach_inv.php?stname=inv_mast" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
    <input type="button" name="searchcust" id="searchcust" value="All"  class="btn_purchase" />
    </a><a href="serach_inv.php?stname=inv_mast_date" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
      <input type="button" name="searchcust2" id="searchcust2" value="Deli Date"  class="btn_purchase" /></a>
      <input type="hidden" name="txtdono" id="txtdono" />
      <input type="hidden" name="over60" id="over60" disabled="disabled" class="text_purchase3"/>
      <input type="hidden"  class="label_purchase" value="Balance With Tmp Limit" disabled="disabled"/>
      <input type="hidden" name="crebal" id="crebal" class="text_purchase3" disabled="disabled"/>
      <input type="hidden" name="ordno" id="ordno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);"   />
      <input type="hidden" name="hiddencount" id="hiddencount" />
      <input id="dte_dor" name="dte_dor" type="hidden"  value="" class="text_purchase3" />      </td>
    <td><input type="text"  class="label_purchase" value="Sales Order No" disabled="disabled"/></td>
    <td><input type="text" name="salesord1" id="salesord1" value="" class="text_purchase3" disabled="disabled" onkeypress="keyset('searchcust',event);"   /></td>
    <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="invdate" id="invdate" value=""   class="text_purchase3"  onclick="load_calader('invdate');" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled/></td>
    <td colspan="3"><input type="text"  class="text_purchase1" disabled="disabled" name="firstname_hidden" id="firstname_hidden" onblur="custno_ind('')" onkeypress="keyset('department',event);"/>
      <input type="text" class="text_purchase2" id="firstname" name="firstname" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Credit Limit" disabled/></td>
    <td><input type="text" size="15" name="creditlimit" id="creditlimit" value="0" onkeypress="keyset('balance',event);" class="text_purchase3" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Balance" disabled="disabled"/></td>
    <td><input type="text" size="15" name="balance" id="balance" disabled="disabled" value="0" onkeypress="keyset('department',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled/></td>
    <td colspan="2"><input type="text"  class="text_purchase4"  id="cus_address" name="cus_address" disabled="disabled"/></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Department" disabled/></td>
    <td><select name="department" id="department" onkeypress="keyset('brand',event);" class="text_purchase3" disabled="disabled">
      <?php
																	$sql="select * from s_stomas_stores order by CODE";
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
                       												}
																?>
    </select></td>
    <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td><select name="brand" id="brand" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="setord();" disabled="disabled">
      <?php
																	$sql="select * from brand_mas order by barnd_name";
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
                       												}
																?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="VAT No" disabled="disabled"/></td>
    <td><input type="text" size="20" name="vat1" id="vat1" value="" onkeypress="keyset('vat2',event);" class="text_purchase3" disabled="disabled"/></td>
    <td><input type="text" size="20" name="vat2" id="vat2" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3" disabled="disabled"/></td>
    <td>&nbsp;</td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="vat" id="vatgroup_0"  onclick="calc1_table_discount1();" disabled="disabled"/>
      VAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="non" id="vatgroup_1"  onclick="calc1_table_discount1();" disabled="disabled"/>
      Non VAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="svat" id="vatgroup_2"  onclick="calc1_table_discount1();" disabled="disabled"/>
      SVAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="evat" id="vatgroup_3"  onclick="calc1_table_discount1();" />
      EVAT Invoice</label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td><select name="salesrep" id="salesrep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3" disabled="disabled">
      <?php
																	$sql="select * from s_salrep where cancel='0' order by REPCODE";
																	
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
    </select></td>
    <td><input type="text"  class="label_purchase" value="Discount 1" disabled="disabled"/></td>
    <td><input type="text" size="5" name="discount_org1" id="discount_org1" value="0" onkeypress="keyset('discount_org2',event);" onblur="calc1_table_discount1();" class="text_purchase" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Discount 2" disabled="disabled"/></td>
    <td><input type="text" size="5" name="discount_org2" id="discount_org2" value="0" onkeypress="keyset('discount_org3',event);" onblur="calc1_table_discount1();" class="text_purchase" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Discount 3" disabled="disabled"/></td>
    <td><input type="text" size="5" name="discount_org3" id="discount_org3" value="0" onkeypress="keyset('searchitem',event);" onblur="calc1_table_discount1();" class="text_purchase" disabled="disabled"/></td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  
<fieldset>               
            
   	<legend><div class="text_forheader">Item Details</div></legend>            
            
    <input type="hidden" name="item_count" id="item_count" value="0" />
  <table width="84%" border="0">
  
  <tr>
	<td colspan="7">
    <div class="CSSTableGenerator" id="itemdetails" >
<table>
                                                        			<tr>
                              											<td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Code</font></td>
                              											<td width="40%"  background="images/headingbg.gif"><font color="#FFFFFF">Description</font></td>
                              											<td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Rate</font></td>
                              											<td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Qty</font></td>
                                                                        <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Discount</font></td>
                                                                        <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Sub Total</font></td>
                           											</tr>
                   												</table>   </div>                                                 		</td>
                                                		</tr>
  
  <tr>
    <td width="13%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="13%">&nbsp;</td>
    <td width="17%">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="2%"><input type="hidden" size="5" name="credper" id="credper" value=""  class="text_purchase1"/></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="8" align="left" valign="top">
     <table width="100%" border="0">
  <tr>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Stock No" disabled="disabled"/>
    </span></td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Serial No" disabled="disabled"/>
    </span></td>
  </tr>
  <tr>
    <td width="39%"><input type="text" size="20" name="stk_no" id="stk_no" value="" onkeypress="keyset('seri_no',event);" class="text_purchase3" /></td>
    <td  width="61%"><input type="text" size="20" name="seri_no" id="seri_no" value="" onkeypress="keyset('additem_tmp',event);" class="text_purchase3" /></td></tr></table>
    <div class="CSSTableGenerator" id="serial_details" >
		<table>
        	<tr>
            	<td width="25%"><font color="#FFFFFF">Stock No</font></td>
                <td width="40%"><font color="#FFFFFF">Serial No</font></td>
            </tr>
        </table>   </div>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="subtot" id="subtot" value="0" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onclick="add_tmp();" class="btn_purchase1" /></td>
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
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Tax" name="taxname" id="taxname" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="tax" id="tax" value="0"  class="text_purchase3"  disabled="disabled" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Invoice Total" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="invtot"  id="invtot" value="0" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="button" name="additem_tmp2" id="additem_tmp2" value="Save Serial" onclick="add_serial();" class="btn_purchase1" /></td>
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
  </tr>
  <tr>
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
    </tr>
</table>
          

</form>        

</fieldset>    
            
           
              			