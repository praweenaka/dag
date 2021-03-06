
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
  <div class="text_forheader">ARN Details - Stores</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="14%"><input type="text"  class="label_purchase" value="ARN No" disabled/></td>
    <td width="18%"><input type="text" name="invno" id="invno" value="" class="text_purchase" onkeypress="keyset('searchcust',event);"  />
      <a href="serach_arn.php" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" >
      </a></td>
    <td width="14%"><input type="text"  class="label_purchase" value="Book No " disabled="disabled"/></td>
    <td width="20%"><input id="book_no" name="book_no" type="text" class="text_purchase3" onkeypress="keyset('lc_no',event);"/></td>
    <td width="14%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="15%"><input type="text"  name="invdate" id="invdate" value="<?php echo date("Y-m-d"); ?>" class="text_purchase3"/></td>
    <td width="5%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="LC No " disabled="disabled"/></td>
    <td><input id="lc_no" name="lc_no" type="text" class="text_purchase3" onkeypress="keyset('pi_no',event);"/></td>
    <td><input type="text"  class="label_purchase" value="PI No " disabled="disabled"/></td>
    <td><input id="pi_no" name="pi_no" type="text" class="text_purchase3" onkeypress="keyset('department',event);"/></td>
    <td><input type="text"  class="label_purchase" value="Department" disabled="disabled"/></td>
    <td><select name="department" id="department" onkeypress="keyset('supplier_code',event);" class="text_purchase3">
      
      <?php
																	$sql="select * from s_stomas_stores order by CODE";
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
																		if ($row["CODE"]=="1"){
                        													echo "<option selected value='".$row["CODE"]."'>".$row["DESCRIPTION"]."</option>";
																		}	else {
																			echo "<option value='".$row["CODE"]."'>".$row["DESCRIPTION"]."</option>";
																		}
                       												}
																?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Supplier" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase" name="supplier_code" id="supplier_code" onblur="suppno_ind('arn');" onkeypress="keyset('purtype',event);"/>
        <a href="" onclick="NewWindow('serach_supplier.php?stname=arn','mywin','800','700','yes','center');return false" onfocus="this.blur()">
        <input type="button" name="searchcust2" id="searchcust2" value="..."  class="btn_purchase1" />
      </a></td>
    <td><input type="text"  class="label_purchase" value="Purchase Type" disabled="disabled"/></td>
    <td><select name="purtype" id="purtype" onkeypress="keyset('brand',event);" class="text_purchase3" onchange="assignbrand();">
      <option value='Import'>Import</option>
      <option value='Local'>Local</option>
    </select>
      <input type="hidden" name="count" id="count" /></td>
    <td><input type="text"  class="label_purchase" value="Brand " disabled="disabled"/></td>
    <td width="15%"><select name="brand" id="brand" onkeypress="keyset('textarea',event);" class="text_purchase3"  onchange="setord();">
      <?php
																	$sql="select * from brand_mas order by barnd_name";
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
                       												}
																?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4"><input type="text"  class="text_purchase3" size="65" id="supplier_name" name="supplier_name" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Special Instruction" disabled="disabled"/></td>
    <td colspan="3"><textarea name="textarea" id="textarea" cols="45" rows="2" class="text_purchase5" onkeypress="keyset('itemd_hidden',event);"></textarea></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
<fieldset>               
            
   	<legend><div class="text_forheader">Item Details</div></legend>
   	<table width="84%" border="0">
      <tr>
        <td width="14%"><span class="style1">
          <input type="text"  class="label_purchase" value="Code" disabled="disabled"/>
        </span></td>
        <td  width="1%">&nbsp;</td>
        <td  width="25%"><span class="style1">
          <input type="text"  class="label_purchase" value="Description" disabled="disabled"/>
        </span></td>
        <td  width="14%"><span class="style1">
          <input type="text"  class="label_purchase" value="Qty" disabled="disabled"/>
        </span></td>
        <td  width="4%">&nbsp;</td>
      </tr>
      <tr>
        <td><font color="#FFFFFF">
          <div id="test"><font color="#FFFFFF">
            <input type="text"  class="text_purchase3" name="itemd_hidden" id="itemd_hidden" size="10" onkeypress="keyset('qty',event);" onblur="itno_arn_ind();"   />
          </font></div>
        </font></td>
        <td><a href="serach_item.php?stname=arn" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
          <input type="button" name="searchitem" id="searchitem" value="..." class="btn_purchase" />
        </a></td>
        <td><font color="#FFFFFF">
          <input type="text"  class="text_purchase3" id="itemd" name="itemd" disabled="disabled" onkeypress="keyset('rate',event);" />
        </font><a href="serach_item.php" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
        <td><font color="#FFFFFF">
          <input type="text" size="15" name="qty" id="qty" value="" onblur="calc1();" class="text_purchase3" onkeypress="keyset('additem_tmp',event);"/>
        </font></td>
        <td><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onclick="add_tmp();" class="btn_purchase1" /></td>
      </tr>
      <tr>
        <td colspan="4"><div class="CSSTableGenerator" id="itemdetails" >
            <table>
              <tr>
                <td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Code</font></td>
                <td width="40%"  background="images/headingbg.gif"><font color="#FFFFFF">Description</font></td>
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Rate</font></td>
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Qty</font></td>
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Discount</font></td>
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Sub Total</font></td>
              </tr>
            </table>
        </div></td>
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