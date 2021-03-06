
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
  <div class="text_forheader">Enter Stock Adustment Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td><input type="hidden" name="hiddencount" id="hiddencount" /></td>
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
    <td><input type="text"  class="label_purchase" value="Document No" disabled="disabled"/></td>
    <td><input type="text"   name="invno" id="invno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
    <td> <a href="search_stock_adjust.php" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
      <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
    </a></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="invdate" id="invdate" value="<?php echo date("Y-m-d"); ?>" onclick="load_calader('invdate');" class="text_purchase3"/></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Special Instructions" disabled="disabled"/></td>
    <td colspan="3"><input type="text"  class="text_purchase3"  id="spinst" name="spinst" /></td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="10%"><input type="radio" name="radio" id="Addition" value="Addition" checked="checked" />
      Additions</td>
    <td width="10%"><input type="radio" name="radio" id="Deduction" value="Deduction" />
      Deductions</td>
    <td width="10%"> <a href="search_grn.php?stname=grn" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="text"  class="label_purchase" value="Department" disabled="disabled"/></td>
    <td width="10%"><select name="dep" id="dep" onkeypress="keyset('brand',event);"  class="text_purchase3">
      <?php
																	$sql="select * from s_stomas_stores order by CODE";
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
                       												}
																?>
    </select></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
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
  </table>

  
  <br/>   
<fieldset>               
            
   	<legend><div class="text_forheader">Stock Details</div></legend>
   	<table width="84%" border="0">
      <tr>
        <td width="10%"><span class="style1">
          <input type="text"  class="label_purchase" value="Code" disabled="disabled"/>
        </span></td>
        <td  width="40%"><span class="style1">
          <input type="text"  class="label_purchase" value="Description" disabled="disabled"/>
        </span></td>
        <td  width="10%"><span class="style1">
          <input type="text"  class="label_purchase" value="Part No" disabled="disabled"/>
        </span></td>
        <td  width="10%"><span class="style1">
          <input type="text"  class="label_purchase" value="Qty" disabled="disabled"/>
        </span></td>
        <td  width="10%">&nbsp;</td>
      </tr>
      <tr>
        <td><font color="#FFFFFF">
          <div id="test"><font color="#FFFFFF">
            <input type="text"  class="text_purchase3" name="itemd_hidden" id="itemd_hidden" size="10" disabled="disabled"  onkeypress="keyset('itemd',event);"     />
          </font></div>
        </font></td>
        <td><font color="#FFFFFF">
          <input type="text"  class="text_purchase6" size="40" id="itemd" name="itemd" disabled="disabled" onkeypress="keyset('rate',event);" />
          </font><a href="serach_item_stok_adj.php" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
            <input type="button" name="searchitem" id="searchitem" value="..." class="btn_purchase" />
          </a></td>
        <td><font color="#FFFFFF">
          <input type="text" size="15" name="partno" id="partno" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('qty',event);"/>
        </font></td>
        <td><font color="#FFFFFF">
          <input type="text" size="15" name="qty" id="qty" value="" class="text_purchase3" onBlur="calc1();"  onkeypress="keyset('additem_tmp',event);"/>
        </font></td>
        <td><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onClick="add_tmp();" class="btn_purchase1" /></td>
      </tr>
      <tr>
        <td colspan="4"><div class="CSSTableGenerator" id="itemdetails" >
            <table>
              <tr>
                <td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Code</font></td>
                <td width="40%"  background="images/headingbg.gif"><font color="#FFFFFF">Description</font></td>
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Part No</font></td>
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Qty</font></td>
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
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" rowspan="5"><div id="storgrid"></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
</fieldset>    

</form> 
</form> 

<br /><br />
            
