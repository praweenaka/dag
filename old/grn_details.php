<?php 
					 
	require_once("connectioni.php");
	
?>	

						 
	



<link rel="stylesheet" href="css/table_min.css" type="text/css"/>	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

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
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%"><input type="text"  class="label_purchase" value="GRN No" disabled="disabled"/></td>
    <td width="10%"><input type="text" disabled="disabled" name="grnno" id="grnno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('grnno');"  onblur="lost_focus('grnno');"  /></td>
    <td width="10%"> <a href="search_grn.php?stname=grn" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"><input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" /></a></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="10%"><input type="date" size="20" name="grndate" id="grndate"  value="<?php echo date("Y-m-d"); ?>" class="text_purchase3"/>     </td>
    <td width="10%"><a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      
    </a></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Department" disabled/></td>
    <td width="10%"><select name="department" id="department"   onkeypress="keyset('brand',event);" onchange="setord();" class="text_purchase3">
      <?php
        $sql="select * from s_stomas where act='0' order by CODE";
        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
        while($row = mysqli_fetch_array($result)){
        echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
        }
        ?>
    </select></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text" disabled="disabled" name="rno" id="rno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('grnno');"  onblur="lost_focus('grnno');"  /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Sto. Ref." disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtstoRef" id="txtstoRef" value="" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <input type="hidden"  value="" id="gst"/>
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
      <input type="radio" name="vatgroup" value="vat" id="vatgroup_0"   onkeypress="keyset('discount1',event);" />
      VAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="non" id="vatgroup_1"    onkeypress="keyset('discount1',event);" />
      Non VAT Invoice</label></td>
    <td bgcolor="#00CCCC"><label>
      <input type="radio" name="vatgroup" value="svat" id="vatgroup_2"   onkeypress="keyset('discount1',event);" />
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
    <td colspan="3"><input type="text"  class="text_purchase1" name="firstname_hidden" id="firstname_hidden" onkeypress="keyset('searchinv2',event);" onblur="custno_ind();" />
      <input type="text" disabled="disabled"  class="text_purchase2" id="firstname" name="firstname" />
      <a href="" onClick="NewWindow('serach_customer.php?stname=grn','mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase">
      </a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Invoice No" disabled="disabled"/></td>
    <td><input type="text" size="15" name="invno" id="invno" value="" onkeypress="keyset('balance',event);" class="text_purchase3" disabled="disabled"/></td>
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
    <td><input type="text" size="15" name="invdate" id="invdate" disabled="disabled" value="" onkeypress="keyset('department',event);" class="text_purchase3"/></td>
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
    <td><select name="brand" id="brand" onkeypress="keyset('searchitem',event);" disabled="disabled" class="text_purchase3"  onchange="setord();">
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
    <td height="41"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td colspan="2"><select name="salesrep" id="salesrep" disabled="disabled" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
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
    <td><input type="text"  class="label_purchase" value="Cost Center" disabled="disabled"/></td>
    <td><select name="costcenter" id="costcenter" disabled="disabled"  class="text_purchase3">
      <?php 
														 	for ($i=1; $i<51; $i++){
																echo "<option value=".$i.">".$i."</option>";
															}
                                                         ?>
    </select></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Serial No (MC)" disabled="disabled"/></td>
    <td><input type="text" size="5" name="serialno" id="serialno" value="0" onkeypress="keyset('itemd_hidden',event);" class="text_purchase"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Invoice No" disabled="disabled"/></td>
    <td><input type="checkbox" name="chkinvno" id="chkinvno" onclick="enable_disable();" /></td>
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
            
  <table width="95%" border="0">
  <tr>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Code" disabled="disabled"/>
    </span></td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Description" disabled="disabled"/>
    </span></td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Rate" disabled="disabled"/>
    </span></td>
    <td>
      <input type="text"  class="label_purchase" value="Ret. Qty" disabled="disabled"/>    </td>
    <td>
      <input type="text"  class="label_purchase" value="Discount" disabled="disabled"/>    </td>
    <td>
      <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>    </td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td width="14%"><font color="#FFFFFF"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="item_code" disabled="disabled" id="item_code" size="10" onkeypress="keyset('qty',event);" onblur="itno_ind();"   />
    </font></font></td>
    <td  width="3%"><a href="serach_item.php?stname=grn_item" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchitem" id="searchitem" value="..." class="btn_purchase" disabled="disabled" />
    </a></td>
    <td  width="19%"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" id="itemd" name="itemd" disabled="disabled" onkeypress="keyset('rate',event);" />
    </font></td>
    <td  width="14%"><font color="#FFFFFF">
      <input type="text" size="15" name="rate" id="rate" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('qty',event);"/>
    </font></td>
    <td  width="14%"><font color="#FFFFFF">
      <input type="text" size="15" name="qty" id="qty" value="" onblur="calc_tot();" class="text_purchase3" disabled="disabled" onkeypress="keyset('discount',event);"/>
    </font></td>
    <td  width="14%"><font color="#FFFFFF">
      <input type="text" size="15" name="discount" id="discount" value="0" onblur="calc_tot();" disabled="disabled" class="text_purchase3" onkeypress="keyset('additem_tmp',event);"/>
      <input type="hidden" size="15" name="discount_amt" id="discount_amt" value="0" class="text_purchase3" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td  width="14%"><font color="#FFFFFF">
      <input type="text" size="15" name="subtot_new" id="subtot_new" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td  width="8%"><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onclick="add_tmp();" class="btn_purchase2" /></td>
    </tr>
  
  <tr>
	<td colspan="8">
    <div class="CSSTableGenerator" id="itemdetails" >
<table>
                                                        			<tr>
                              											<td width="10%"   background="" ><font color="#FFFFFF">Code</font></td>
                              											<td width="40%"  background=""><font color="#FFFFFF">Description</font></td>
                              											<td width="10%"  background=""><font color="#FFFFFF">Rate</font></td>
                              											<td width="10%"  background=""><font color="#FFFFFF">Qty</font></td>
                                                                        <td width="10%"  background=""><font color="#FFFFFF">Discount</font></td>
                                                                        <td width="10%"  background=""><font color="#FFFFFF">Sub Total</font></td>
                           											</tr>
                   												</table>   </div>                                                 		</td>
                                                		</tr>
  <input type="hidden" name="mcou" id="mcou" value="0" />
  <tr>
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
    <td colspan='5' rowspan='3'><textarea name="remarks" id="remarks" cols="60" rows="5" ></textarea></td>
     
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="subtot" id="subtot" value="0" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    
     
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Discount" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="totdiscount" id="totdiscount" value="0" disabled="disabled"  class="text_purchase3" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    
    
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Tax" name="taxname" id="taxname" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="tax" id="tax" value="0"  class="text_purchase3"  disabled="disabled" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" rowspan="5"><div id="storgrid"></div></td>
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
            
            <table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">