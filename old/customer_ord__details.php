
<?php 
/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/




/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/

	

						 
	require_once("connectioni.php");
	
						
	$sql = "delete FROM TMP_EDU_FILTER";
	
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
						
	$sql = "delete FROM	TMP_QUALI_FILTER";
	
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
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

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%" ><label>
      <input type="text"  class="label_purchase" value="Order No" disabled="disabled"/>
    </label></td>
    <td width="10%"><label>
      <input type="text" disabled="disabled" name="txt_invno" id="txt_invno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  />
    </label></td>
    <td width="10%"><a href="serach_w_ord.php?stname=cus_ord" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" /></a>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="checkbox" id="checkbox" />    </td>
    <td width="10%">
    Select Customer Only</td>
    <td width="10%"><input type="text"  class="label_purchase" value="Date From" disabled="disabled"/></td>
    <td width="10%">
      <input type="text" size="20" name="dtdate" id="dtdate" class="text_purchase3" onfocus="load_calader('dtdate');" value="<?php echo date("Y-m-d"); ?>"/>    </td>
     <?php
	$date=date("Y-m-d");
	$caldays=" + 7 days";
	$tmpdate=date('Y-m-d', strtotime($caldays));
	?>
    <td width="10%"><input type="text"  class="label_purchase" value="Date To" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="DTdateto" id="DTdateto" value="<?php echo $tmpdate; ?>" onfocus="load_calader('DTdateto');" class="text_purchase3"/></td>
    <td width="10%">&nbsp;</td>
  </tr>
  
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled/></td>
    <td colspan="3"><input type="text" class="text_purchase1" onblur="custno_ind('weekly_ord');" onkeypress="keyset('department',event);" name="firstname_hidden" id="firstname_hidden"/>
      <input type="text" disabled="disabled"  class="text_purchase2" id="firstname" name="firstname" />
      <a href="" onClick="NewWindow('serach_customer.php?stname=weekly_ord','mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase">
      </a></td>
    <td colspan="2"><input type="hidden"  class="label_purchase" value="Credit Limit" disabled/>
      <label></label><input type="hidden" size="15" name="creditlimit" id="creditlimit" value="0" onkeypress="keyset('balance',event);" class="text_purchase3" disabled="disabled"/>
      <input type="hidden"  class="label_purchase" value="Discount 2" disabled="disabled"/>
      <input type="hidden" size="5" name="discount_org2" id="discount_org2" value="0" onblur="keyset('itemd_hidden',event);" class="text_purchase"/>
      <input type="hidden" size="5" name="discount_org3" id="discount_org3" value="0" onblur="keyset('itemd_hidden',event);" class="text_purchase"/>
      <input type="hidden" name="vatgroup" value="non" id="vatgroup_1"  onkeypress="keyset('discount1',event);" disabled="disabled" />
      <input type="hidden" name="paymethod_" value="credit" id="paymethod_0"  disabled="disabled"/>
      <input type="hidden" name="paymethod" value="cash" id="paymethod_1" disabled="disabled" />
      <input type="hidden"  class="label_purchase" value="Discount 3" disabled="disabled"/></td>
    <td><input type="hidden"  class="label_purchase" value="Balance" disabled="disabled"/></td>
    <td><input type="hidden" size="15" name="balance" id="balance" disabled="disabled" value="0" onkeypress="keyset('department',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled/></td>
    <td colspan="2"><input type="text"  class="text_purchase4"  disabled="disabled" id="cus_address" name="cus_address" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Department" disabled/></td>
    <td><select name="department" id="department" onkeypress="keyset('brand',event);" onblur="setord();" class="text_purchase3">
      <?php
        $sql="select * from s_stomas where act='0' order by CODE";
        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
        while($row = mysqli_fetch_array($result)){
        echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
        }
        ?>
    </select></td>
    <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td><select name="brand" id="brand" onkeypress="keyset('salesrep',event);" class="text_purchase3"  onblur="setord();"  >
      <?php
    if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
        $sql="select * from brand_mas where act ='1' and costcenter='".$_SESSION["CURRENT_DEP"]."' order by barnd_name"; 
    }else{
        $sql="select * from brand_mas where act ='1' order by barnd_name";
    } 
    $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
    while($row = mysqli_fetch_array($result)){
         echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
    }?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="VAT No" disabled="disabled"/></td>
    <td><input type="text" size="20" name="vat1" id="vat1" disabled="disabled" value="" onkeypress="keyset('vat2',event);" class="text_purchase3"/></td>
    <td><input type="text" size="20" name="vat2" id="vat2" disabled="disabled" value="" onkeypress="keyset('salesrep',event);" class="text_purchase3"/></td>
    <td><label></label></td>
    <td><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td><label>
      <select name="salesrep" id="salesrep" onkeypress="keyset('discount_org1',event);" class="text_purchase3" onblur="setord();">
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
      </select>
    </label></td>
    <td><label>
      <input type="text"  class="label_purchase" value="Discount" disabled="disabled"/>
    </label></td>
    <td><label>
      <input type="text" size="5" name="discount_org1" id="discount_org1" value="40"  onkeypress="keyset('itemd_hidden',event);" class="text_purchase"/>
    </label></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><input type="hidden"  class="label_purchase" value="Required Date" disabled="disabled"/></td>
    <td><input id="DTREQ_DATE" name="DTREQ_DATE" type="hidden"  onfocus="load_calader('DTREQ_DATE');" class="text_purchase3" /></td>
    <td><input type="hidden" name="txt_chetot" id="txt_chetot" value="0" /><input type="hidden" name="txt_cash" id="txt_cash" value="0" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
 
<fieldset>               
            
   	<legend><div class="text_forheader">Item Details</div></legend>            
            
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
    <div id="test"><font color="#FFFFFF"><font color="#FFFFFF"><font color="#FFFFFF"><font color="#FFFFFF"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="itemd_hidden" id="itemd_hidden" size="10" onblur="itno_weekly_ind1();"  onkeypress="keyset('qty',event);"   />
    </font></font></font></font></font></div>  
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase6" size="40" id="itemd" name="itemd" disabled="disabled" onkeypress="keyset('rate',event);" />
    </font><a href="serach_item.php?stname=weekly_order" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"><input type="button" name="searchitem" id="searchitem" value="..." class="btn_purchase" ></a></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="rate" id="rate" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('qty',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="qty" id="qty" value="" onblur="calc1();" class="text_purchase3" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="discountper" id="discountper" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('subtotal',event);"/><input type="hidden" size="15" name="discount" id="discount" value="" disabled class="txtbox" />
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
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Stock Level" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="5" name="stklevel" id="stklevel" value="" disabled="disabled" class="text_purchase1"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="subtot" id="subtot" value="0" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Credit Period" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="5" name="credper" id="credper" value="" disabled="disabled" class="text_purchase1"/></td>
    <td><input type="hidden" name="txt_ordno" id="txt_ordno" /></td>
    <td><font color="#FFFFFF">
      <input type="hidden" size="15" name="DTappdate" id="DTappdate" value="" class="text_purchase3" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Discount" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="totdiscount" id="totdiscount" value="0" disabled="disabled"  class="text_purchase3" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div id="storgrid"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Tax" name="taxname" id="taxname" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="tax" id="tax" value="0"  class="text_purchase3"  disabled="disabled" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" rowspan="3"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="VAT" name="taxname2" id="taxname2" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="txtvat" id="txtvat" value="0"  class="text_purchase3"  disabled="disabled" /></td>
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