
<?php 
 					 
	require_once("connectioni.php");
	
	 
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
  <div class="text_forheader">Enter Quotation Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%" bgcolor="#00CCCC"><label>
      <input type="radio" name="paymethod" value="credit" id="paymethod_0" />
      Credit</label></td>
    <td width="10%"  bgcolor="#00CCCC"><label>
      <input type="radio" name="paymethod" value="cash" id="paymethod_1" />
      Cash</label></td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="text"  class="label_purchase" value="Sales Order No" disabled="disabled"/></td>
    <td width="10%"><input type="text" disabled="disabled" name="salesord1" id="salesord1" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  />     </td>
    <td width="10%"><a href="serach_ord.php?stname=inv_mast" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
    </a></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="invdate" id="invdate" value="<?php echo date("Y-m-d"); ?>" disabled="disabled" class="text_purchase3"/></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Qutation No" disabled/></td>
    <td colspan="3"><input type="text" disabled="disabled"  class="text_purchase" name="invno" id="invno"/>
      <a href="search_quot.php?stname=quot" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
      <input type="button" name="searchcust2" id="searchcust2" value="..."  class="btn_purchase" />
      </a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled/></td>
    <td colspan="3"><input type="text"  class="text_purchase1" name="firstname_hidden" id="firstname_hidden" onblur="custno_ind('')" onkeypress="keyset('department',event);"/>
      <input type="text"  class="text_purchase2" id="firstname" name="firstname" />
      <a href="" onClick="NewWindow('serach_customer.php?stname=quot','mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase">
      </a></td>
    <td><input type="text"  class="label_purchase" value="Credit Limit" disabled/></td>
    <td><input type="text" size="15" name="creditlimit" id="creditlimit" value="0" onkeypress="keyset('balance',event);" class="text_purchase3" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Balance" disabled="disabled"/></td>
    <td><input type="text" size="15" name="balance" id="balance" disabled="disabled" value="0" onkeypress="keyset('department',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled/></td>
    <td colspan="2"><input type="text"  class="text_purchase4"  id="cus_address" name="cus_address" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Department" disabled/></td>
    <td><select name="department" id="department" onkeypress="keyset('brand',event);" onchange="setord();" class="text_purchase3">
      <?php
        $sql="select * from s_stomas where act='0' order by CODE";
        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
        while($row = mysqli_fetch_array($result)){
        echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
        }
        ?>
    </select></td>
    <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td><select name="brand" id="brand" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="setord();">
      <?php
        if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
            $sql="select * from brand_mas where act ='1' and costcenter='".$_SESSION["CURRENT_DEP"]."' order by barnd_name"; 
        }else{
            $sql="select * from brand_mas where act ='1' order by barnd_name";
        } 
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
    <td><input type="text" size="20" name="vat1" id="vat1" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/></td>
    <td><input type="text" size="20" name="vat2" id="vat2" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td bgcolor="#00CCCC"><input type="radio" name="vatgroup" value="vat" id="vatgroup_0"  onkeypress="keyset('discount1',event);" />
      VAT Invoice</td>
    <td bgcolor="#00CCCC"><label>
    <input type="radio" name="vatgroup" value="non" id="vatgroup_1"  onkeypress="keyset('discount1',event);" />
Non VAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="svat" id="vatgroup_2"  onkeypress="keyset('discount1',event);" />
SVAT Invoice</label></td>
   <td bgcolor="#00CCCC"><input type="radio" name="vatgroup" value="evat" id="vatgroup_3"  onkeypress="keyset('discount1',event);" />
EVAT Invoice</td>
  </tr>
  <tr>
    <td height="41"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td><select name="salesrep" id="salesrep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
      <?php
		require_once("connectioni.php");
                if ($_SESSION["MANAGER"]!="") { 			 						
                    $sql="select * from s_salrep where cancel='1' and manager='".$_SESSION["MANAGER"]."'order by REPCODE"; 
                    $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                    while($row = mysqli_fetch_array($result)){
                        echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                    }
                 }else if ($_SESSION["CURRENT_REP"]=="") { 			 						
                    $sql="select * from s_salrep where cancel='1' order by REPCODE";
                    $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                    while($row = mysqli_fetch_array($result)){
                        echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                    }
                 } else {
                     $sql="select * from s_salrep where cancel='1' and repcode = '" . $_SESSION["CURRENT_REP"] ."' order by REPCODE";
                     $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                     while($row = mysqli_fetch_array($result)){
                     echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                     }
                 }
        ?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><select name="COM_GROUPS" id="COM_GROUPS" onkeypress="keyset('searchitem',event);" class="text_purchase3"  >
     <option value=""></option>
     <option value="TYRES">TYRES</option>
     <option value="BATTERIES">BATTERIES</option>
     <option value="TUBES">TUBES</option>
    </select></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><textarea name="TXTREMARK" id="TXTREMARK" cols="45" rows="5">YOUR ESTEEMED INQUIRY REFERS. TYRE HOUSE TRADING (PVT) LTD., WISH TO QUOTE AS 
MENTIONED HEREUNDER FOR YOUR FAVOURABLE CONSIDERATION</textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input id="dte_dor" name="dte_dor" type="hidden"  value="" class="text_purchase3" /></td>
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
            
    <input type="hidden" name="item_count" id="item_count" value="0" />
  <table width="84%" border="0">
  <tr>
    <td width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Code" disabled/>
    </span></td>
    <td  width="40%"><span class="style1">
      <input type="text"  class="label_purchase" value="Description" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Rate" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Qty" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Discount" disabled="disabled"/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>
    </span></td>
    <td  width="10%">&nbsp;</td>
    </tr>
  <tr>
    <td><font color="#FFFFFF">
    <div id="test"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="itemd_hidden" id="itemd_hidden" size="10" onkeypress="keyset('qty',event);" onblur="itno_ind();"   />
    </font></div>  </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase6" size="40" id="itemd" name="itemd" disabled="disabled" onkeypress="keyset('rate',event);" />
    </font><a href="serach_item.php?stname=quot" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"><input type="button" name="searchitem" id="searchitem" value="..." class="btn_purchase" ></a></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="rate" id="rate" value=""  class="text_purchase3" onkeypress="keyset('qty',event);"/>
      <input type="hidden" name="part_no" id="part_no" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="qty" id="qty" value="" onblur="calc1();" class="text_purchase3" onkeypress="keyset('discountper',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="discountper" id="discountper" value="" class="text_purchase3" onblur="calc1();" onkeypress="keyset('additem_tmp',event);"/><input type="hidden" size="15" name="discount" id="discount" value="" disabled class="txtbox" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="subtotal" id="subtotal" value="" class="text_purchase3" disabled="disabled" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onClick="add_tmp();" class="btn_purchase1"></td>
    </tr>
  <tr>
	<td colspan="6">
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td><select name="Combo11" id="Combo11" onchange="setwar();" onkeypress="keyset('dte_dor',event);" class="text_purchase3">
    <option></option>
    <option value="Against Manufacturing defect for remaining tread depth on pro-rata Basis">Against Manufacturing defect for remaining tread depth on pro-rata Basis.</option>
    <option value="12 Months guarantee againts Manufacturing defects Type">12 Months guarantee againts Manufacturing defects Type.</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="subtot" id="subtot" value="0" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Check1" id="Check1" />
      Warranty = </td>
    <td><input type="text" id="Combo1" class="text_purchase3" name="Combo1"> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  
  
  
  <tr>
    <td><input type="checkbox" name="Check2" id="Check2" />
      Delivery =</td>
    <td>Ex-Stock Subject To Prior Sale</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Discount" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="totdiscount" id="totdiscount" value="0" disabled="disabled"  class="text_purchase3" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Check3" id="Check3" />
      Delivery =</td>
    <td>Import and Supply within<font color="#FFFFFF"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="txt_deldays" id="txt_deldays" size="10"    />
    </font></font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Tax" name="taxname" id="taxname" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="tax" id="tax" value="0"  class="text_purchase3"  disabled="disabled" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Check4" id="Check4" />
      Payment Term =</td>
    <td><font color="#FFFFFF"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="txt_paytype" id="txt_paytype" size="10"    />
    </font></font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Invoice Total" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="invtot"  id="invtot" value="0" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Check5" id="Check5" />
      Price Validity =</td>
    <td><font color="#FFFFFF"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="txt_validity" id="txt_validity" size="10"   />
    </font></font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Check6" id="Check6" />
      Country of Origin</td>
    <td><font color="#FFFFFF"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="txt_country" id="txt_country" size="10"   />
    </font></font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="Check7" id="Check7" />
      Milage Performance=</td>
    <td><font color="#FFFFFF"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="txt_milage" id="txt_milage" size="10"    />
    </font></font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Stock Level" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="5" name="stklevel" id="stklevel" value="" class="text_purchase2"/></td>
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
