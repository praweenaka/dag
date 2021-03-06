
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
         <form name="form1" id="form1">  
<fieldset>
                                                	<legend>
  <div class="text_forheader">Defective Details</div>
                                               	 </legend>             

                                                 <a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
                                                 <input type="text" disabled="disabled" name="txt_fno" id="txt_fno" value="" class="text_purchase2" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  />
                                                 </a>
           
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%"><input type="text"  class="label_purchase" value="DGRN No" disabled="disabled"/></td>
    <td width="10%" colspan="2"><a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
    <?php
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$sql="select * from s_crnma where REF_NO='".$_GET["txtrefno"]."'";
			//echo $sql;
	$result =$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	$sql1="select * from s_deftrn where REFNO='".$_GET["txtrefno"]."'";
			//echo $sql;
	$result1 =$db->RunQuery($sql1);
	$row1 = mysql_fetch_array($result1);
	
	
	
			
			
	
	
   
	?>
       <a href="search_defective.php?stname=dgrn" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
       <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
    </a>
      <input type="text" disabled="disabled" name="txtrefno" id="txtrefno" class="text_purchase2" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');" value="<?php echo $row["REF_NO"]; ?>"  />
      <a href="search_defective.php?stname=dgrn" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
    <td width="10%"><a href="search_claim_list.php?stname=DGRN" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv2" id="searchinv2" value="..." class="btn_purchase1" />
    </a></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="10%">
      <input type="text" size="20" name="dtdate" id="dtdate" value="<?php echo $row["DDATE"]; ?>" disabled="disabled" class="text_purchase3"/></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Department" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="dtdate2" id="dtdate2" value="<?php echo $row["DEPARTMENT"]; ?>" disabled="disabled" class="text_purchase3"/></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><input type="text" disabled="disabled" name="txtrno" id="txtrno" value="" class="text_purchase2" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled/></td>
    <td colspan="3"><input type="text" disabled="disabled"  class="text_purchase1" name="txt_cuscode" id="txt_cuscode" value="<?php echo $row["C_CODE"]; ?>"/>
      <input type="text" disabled="disabled"  class="text_purchase2" id="txt_cusname" name="txt_cusname" value="<?php echo $row["CUS_NAME"]; ?>" />
      <a href="" onClick="NewWindow('serach_customer.php?stname=defective_item','mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase">
      </a></td>
    <td><input type="text"  class="label_purchase" value="Batry No" disabled/></td>
    <td><input type="text" size="15" name="txtbat" id="txtbat" value="<?php $row1["BAT_NO"]; ?>" onkeypress="keyset('balance',event);" class="text_purchase3" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="Cost Center" disabled="disabled"/></td>
    <td><select name="com_costcent" id="com_costcent" onkeypress="keyset('searchitem',event);" class="text_purchase3"  >
     
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled/></td>
    <td colspan="2"><input type="text"  class="text_purchase3"  disabled="disabled" id="txtadd" name="txtadd" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Remarks" disabled="disabled"/></td>
    <td width="10%" colspan="2"><input type="text" size="20" name="txtremark" id="txtremark" disabled="disabled" value="<?php echo $row["remarks"]; ?>" onkeypress="keyset('vat2',event);" class="text_purchase3"/></td>
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
    <td height="41"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtremark2" id="txtremark2" disabled="disabled" onkeypress="keyset('vat2',event);" class="text_purchase3" value="<?php echo $row["SAL_EX"]; ?>"/></td>
    <td width="10%">&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Claim No" disabled="disabled"/></td>
    <td><input type="text" size="5" name="txtcl_no" id="txtcl_no" value="<?php echo $row1["CLAM_NO"]; ?>" onblur="keyset('discount2',event);" class="text_purchase"/></td>
    <td><input type="text" size="5" name="txtcl_no2" id="txtcl_no2" value="<?php echo $row1["REsult"]; ?>" onblur="keyset('discount2',event);" class="text_purchase"/></td>
    <td><input type="text"  class="label_purchase" value="Shipment" disabled="disabled"/></td>
    <td><input type="text"  class="label_purchase" value="<?php echo $row1["arno"]; ?>" disabled="disabled"/></td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
<fieldset>               
            
   	<legend><div class="text_forheader">Defective Item Details</div></legend>            
            
  <table width="84%" border="0">
  <tr>
    <td width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Item" disabled/>
    </span></td>
    <td  width="20%"><span class="style1">
      <input type="text"  class="label_purchase" value="Description" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Part No" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Rate" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Qty" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Discount" disabled/>
    </span></td>
     <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Sub Total" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Refund" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Total" disabled/>
    </span></td>
    <td  width="10%">&nbsp;</td>
    </tr>
  <tr>
    <td><font color="#FFFFFF">
    <div id="test"><font color="#FFFFFF">
        <input type="text"  class="text_purchase3" name="itemno" id="itemno" size="10" disabled="disabled" value="<?php echo $row1["STK_NO"]; ?>"  onkeypress="keyset('itemd',event);"     />
    </font></div>  </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase6" size="40" id="item_name" name="item_name" disabled="disabled" onkeypress="keyset('rate',event);" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="partno" id="partno" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('qty',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="rate" id="rate" value="<?php echo $row1["AMOUNT"]; ?>" onblur="calc1();" class="text_purchase3" disabled="disabled"  onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="qty" id="qty" value="<?php echo $row1["qty"]; ?>" disabled="disabled" class="text_purchase3" onkeypress="keyset('subtotal',event);"/><input type="hidden" size="15" name="discount" id="discount" value="" disabled class="txtbox" />
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="discou" id="discou" value="<?php echo $row1["dis"]; ?>" class="text_purchase3"  onblur="settotal();"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="subtot" id="subtot" value="" class="text_purchase3" disabled="disabled" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="refund" id="refund" value="" class="text_purchase3" disabled="disabled" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="total" id="total" value="" class="text_purchase3" disabled="disabled" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    </tr>
  <tr>
	<td colspan="6">
    <div class="CSSTableGenerator" id="itemdetails" ></div>                                                 		</td>
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
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Amount" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="txt_net" id="txt_net" value="<?php $row["GRAND_TOT"]; ?>" disabled="disabled" class="text_purchase3"/></td>
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