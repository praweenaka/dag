
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

</label><fieldset>
                                                	<legend>
  <div class="text_forheader">Balance Commission</div>
                                               	 </legend>             

<form name="form1" id="form1">  
 <table border="1"><tr><td width="1301">         
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%"><input type="hidden" name="txt_stat" id="txt_stats" /></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="text" disabled="disabled" name="dttmpda" id="dttmpda" value="<?php echo "2011-04-29"; ?>" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Month" disabled="disabled"/></td>
    <td>
    <input type="text" name="dtMonth" id="dtMonth" class="text_purchase3"/>
        <script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dtMonth",
			dateFormat:"%Y-%m"
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
    </td>
    <td> <a href="serach_rec.php?stname=cash_rec" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></td>
    <td><input type="text"  class="label_purchase" value="Sales Excecutive" disabled="disabled"/></td>
    <td><select name="cmbrep" id="cmbrep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
      <?php
																	$sql="select * from s_salrep order by REPCODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
    </select></td>
    <td><select name="cmbdev" id="cmbdev" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="setord();">
     <option value='0'>0</option>
     <option value='1'>1</option>
    </select></td>
    <td><input type="text"  class="label_purchase" value="Vat Rate" disabled="disabled"/></td>
    <td><a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text" name="txtvat" id="txtvat" value="12" class="text_purchase3"   />
    </a></td>
    <td> <a href="serach_customer.php?stname=ret_chq_settle" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="button" name="searchinv" id="searchinv" value="View Summery" class="btn_purchase2" onclick="view_summery();" />
    </td>
    <td><a href="" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onfocus="this.blur()"></a><a href="serach_rec.php?stname=cash_rec" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
    <td><a href="serach_rec.php?stname=cash_rec" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text"  class="label_purchase" value="2nd Target" disabled="disabled"/>
    </a></td>
    <td><a href="" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text" disabled="disabled"  class="text_purchase3" id="txtt2" name="txtt2" />
    </a></td>
    <td>&nbsp;</td>
    <td><a href="" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text"  class="label_purchase" value="1st Target" disabled="disabled"/>
    </a></td>
    <td><a href="" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text" disabled="disabled"  class="text_purchase3" id="txtt1" name="txtt1" />
    </a></td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
 


  

<br />


<br />
<fieldset>               
            
   	<legend><div class="text_forheader">Sales Commission</div></legend>
   <fieldset> 
  <table width="84%" border="0">
      
      
      <tr>
        <td width="16%"><input type="text"  class="label_purchase" value="Total Sale (With VAT)" disabled="disabled"/></td>
        <td width="13%"><input type="text" size="20" name="txtnetsale" id="txtnetsale" value="" class="text_purchase3"/></td>
        <td width="16%"><input type="text"  class="label_purchase" value="Paid (With VAT)" disabled="disabled"/></td>
        <td width="14%" colspan="3"><input type="text" size="20" name="txtpaid" id="txtpaid" value="" class="text_purchase3"/></td>
        <td width="28%"><input type="text"  class="label_purchase" value="Outstanding(With VAT)" disabled="disabled"/></td>
        <td width="13%"><input type="text" size="20" name="txtout" id="txtout" value="" class="text_purchase3"/></td>
    </tr>
      <tr>
        <td><input type="text"  class="label_purchase" value="Return (With VAT)" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtret" id="txtret" value="" class="text_purchase3"/></td>
        <td><input type="text"  class="label_purchase" value="No Commission" disabled="disabled"/></td>
        <td colspan="3"><input type="text" size="20" name="txtNocomm" id="txtNocomm" value="" class="text_purchase3"/></td>
        <td><input type="text"  class="label_purchase" value="Percentage" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtpre" id="txtpre" value="" class="text_purchase3"/></td>
    </tr>
      <tr>
        <td><input type="text"  class="label_purchase" value="Net Sale (W/O VAT)" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtnet" id="txtnet" value="" class="text_purchase3"/></td>
        <td><input type="text"  class="label_purchase" value="No Commission (With VAT)" disabled="disabled"/></td>
        <td colspan="3">&nbsp;</td>
        <td colspan="2" rowspan="6">
        <fieldset><legend>Advance Payment</legend>
        <table width="300" border="0">
          <tr>
            <th scope="col"><input type="text"  class="label_purchase" value="Radio Deduction" disabled="disabled"/></th>
            <th scope="col"><input type="text" size="20" name="txtretioded" id="txtretioded" value="" class="text_purchase3"/></th>
          </tr>
          <tr>
            <th scope="col"><input type="text"  class="label_purchase" value="Advance" disabled="disabled"/></th>
            <th scope="col"><input type="text" size="20" name="txtadvance" id="txtadvance" value="" class="text_purchase3"/></th>
          </tr>
          <tr>
            <td><input type="text"  class="label_purchase" value="Payable Advance" disabled="disabled"/></td>
            <td><input type="text" size="20" name="txtad" id="txtad" value="" class="text_purchase3"/></td>
          </tr>
          <tr>
            <td><input type="text"  class="label_purchase" value="Deductions" disabled="disabled"/></td>
            <td><input type="text" size="20" name="txtded" id="txtded" value="" class="text_purchase3"/></td>
          </tr>
          <tr>
            <td colspan="2"><textarea name="txtdedremark" id="txtdedremark" cols="45" rows="5"></textarea></td>
          </tr>
          
          <tr>
            <td><input type="text"  class="label_purchase" value="Balance Advance" disabled="disabled"/></td>
            <td><input type="text" size="20" name="Txtadva" id="Txtadva" value="" class="text_purchase3"/></td>
          </tr>
          <tr>
            <td><input type="button" name="com_view3" id="com_view3" value="Save" onclick="save_advance();"  class="btn_purchase2" /></td>
            <td><input type="button" name="com_view4" id="com_view4" value="Lock" onclick="lock_advance();"  class="btn_purchase2" /></td>
          </tr>
        </table>
        </fieldset>        </td>
      </tr>
      <tr>
        <td><input type="text"  class="label_purchase" value="Return Cheque (W/O VAT)" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtRetChkAmou_Do" id="txtRetChkAmou_Do" value="" class="text_purchase3"/></td>
        <td colspan="4" rowspan="3">
        
        <div class="CSSTableGenerator" id="MSHFlexGrid1" style="overflow:scroll; height:100px"  >   
        
        <table >
          <tr>
            <td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Class</font></td>
            <td width="20%"  background="images/headingbg.gif"><font color="#FFFFFF">Paid Amount</font></td>
          </tr>
          
        </table>
        </div>        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="text" size="20" name="txtRetChkAmou_D1" id="txtRetChkAmou_D1" value="" class="text_purchase3"/></td>
      </tr>
      <tr>
        <td><input type="text"  class="label_purchase" value="Effective Sale" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtBalsale" id="txtBalsale" value="" class="text_purchase3"/></td>
      </tr>
      <tr>
        <td colspan="6"><table width="729" border="0">
          <tr>
            <th width="144" scope="col">
              <input type="button" name="com_view2" id="com_view2" value="Calculation"  class="btn_purchase2" onclick="calculation();" />            </th>
            <th width="25%" scope="col"><input type="text" size="20" name="txtTOTNocom" id="txtTOTNocom" value="" class="text_purchase3"/></th>
            <th width="25%" scope="col"><input type="text" size="20" name="txtTotnet" id="txtTotnet" value="" class="text_purchase3"/></th>
            <th width="25%" scope="col"><input type="text" size="20" name="txtbalSAleTOT" id="txtbalSAleTOT" value="" class="text_purchase3"/></th>
          </tr>
          
        </table></td>
      </tr>
      
      <tr>
        <td colspan="6">
        <fieldset><legend>Commission</legend>
        <table width="729" border="0">
          <tr>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="Sales" disabled="disabled"/></th>
            <th width="18" scope="col">&nbsp;</th>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="GRN" disabled="disabled"/></th>
            <th width="21" scope="col">&nbsp;</th>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="Ret.Ch" disabled="disabled"/></th>
            <th width="84" scope="col">&nbsp;</th>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="Balance" disabled="disabled"/></th>
          </tr>
          <tr>
            <th scope="col"><input type="text" size="20" name="txtComSale" id="txtComSale" value="" class="text_purchase3"/></th>
            <th scope="col"><strong>-</strong></th>
            <th scope="col"><input type="text" size="20" name="txtComGRN" id="txtComGRN" value="" class="text_purchase3"/></th>
            <th scope="col"><strong>-</strong></th>
            <th scope="col"><input type="text" size="20" name="txtretch" id="txtretch" value="" class="text_purchase3"/></th>
            <th scope="col"><strong>=</strong></th>
            <th scope="col"><input type="text" size="20" name="txtComBal" id="txtComBal" value="" class="text_purchase3"/></th>
          </tr>
        </table>
        </fieldset>        </td>
      </tr>
      
      <tr>
        <td colspan="6">
        <fieldset><legend>Other Deductions</legend>
        <table width="600" border="0">
          <tr>
            <th width="50%" scope="col"><input type="text" size="20" name="txtdes1" id="txtdes1" value="Security Deposit" class="text_purchase3"/></th>
            <th width="30%" scope="col"><input type="text" size="20" name="txtdedamt1" id="txtdedamt1" value="" class="text_purchase3"/></th>
            <th width="10%" scope="col"><input type="text" size="20" name="txtpr" id="txtpr" value="5" class="text_purchase3"/></th>
            <th width="10%"scope="col">              %</th>
          </tr>
          <tr>
            <td><input type="text" size="20" name="txtdes2" id="txtdes2" value="Advance" class="text_purchase3"/></td>
            <td><input type="text" size="20" name="txtdedamt2" id="txtdedamt2" value="" class="text_purchase3"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input type="text" size="20" name="txtdes3" id="txtdes3" value="Mobile" class="text_purchase3"/></td>
            <td><input type="text" size="20" name="txtdedamt3" id="txtdedamt3" value="" class="text_purchase3"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input type="text" size="20" name="txtdes4" id="txtdes4" value="" class="text_purchase3"/></td>
            <td><input type="text" size="20" name="txtdedamt4" id="txtdedamt4" value="" class="text_purchase3"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input type="text" size="20" name="txtdes5" id="txtdes5" value="" class="text_purchase3"/></td>
            <td><input type="text" size="20" name="txtdedamt5" id="txtdedamt5" value="" class="text_purchase3"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table><div id="lblComm"></div>
        </fieldset>        </td>
        <td colspan="2">
        
        <table width="400" border="0">
          <tr>
            <th scope="col">&nbsp;</th>
            <th scope="col"><input type="text"  class="label_purchase" value="Sale" disabled="disabled"/></th>
            <th scope="col"><input type="text"  class="label_purchase" value="Commission" disabled="disabled"/></th>
          </tr>
          <tr>
            <td><input type="text"  class="label_purchase" value="Cat1" disabled="disabled"/></td>
            <td><input type="text" size="20" name="txtcat1sale" id="txtcat1sale" value="" class="text_purchase3"/></td>
            <td><input type="text" size="20" name="txtcat1Com" id="txtcat1Com" value="" class="text_purchase3"/></td>
          </tr>
          <tr>
            <td><input type="text"  class="label_purchase" value="Cat1 Sp" disabled="disabled"/></td>
            <td><input type="text" size="20" name="txtcat1Spsale" id="txtcat1Spsale" value="" class="text_purchase3"/></td>
            <td><input type="text" size="20" name="txtcat1Spcomm" id="txtcat1Spcomm" value="" class="text_purchase3"/></td>
          </tr>
          <tr>
            <td><input type="text"  class="label_purchase" value="Cat 2" disabled="disabled"/></td>
            <td><input type="text" size="20" name="txtcat2sale" id="txtcat2sale" value="" class="text_purchase3"/></td>
            <td><input type="text" size="20" name="txtcat2com" id="txtcat2com" value="" class="text_purchase3"/></td>
          </tr>
          <tr>
            <td colspan="2"><input type="text"  class="label_purchase" value="Commission For No.Com. Sale" disabled="disabled"/></td>
            <td><input type="text" size="20" name="txtNoCom_COm" id="txtNoCom_COm" value="" class="text_purchase3"/></td>
          </tr>
        </table></td>
      </tr>
      
      
      <tr>
        <td><input type="text"  class="label_purchase" value="Sp. Additions" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtAdd" id="txtAdd" value="" class="text_purchase3"/></td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="6">
        <div id="TypeGrid1">
        <table width="71%">
          <tr>
            <td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Code</font></td>
            <td width="20%"  background="images/headingbg.gif"><font color="#FFFFFF">Description</font></td>
            <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Rate</font></td>
            <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Qty</font></td>
          </tr>
        </table>
        </div>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="button" name="com_view5" id="com_view5" value="Save"  class="btn_purchase2" /></td>
        <td colspan="2"><input type="button" name="com_view6" id="com_view6" value="Cancel"  class="btn_purchase2" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="6"><table width="700" border="0">
          <tr>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col"><input type="text" size="20" name="TXTnetamt" id="TXTnetamt" value="" class="text_purchase3"/></th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
          </tr>
          <tr>
            <th scope="col"><input type="button" name="com_view7" id="com_view7" value="Lock"  class="btn_purchase2" onclick="com_lock();" /></th>
            <th scope="col"><input type="button" name="com_view8" id="com_view8" value="View Report"  class="btn_purchase2" onclick="view_report();" /></th>
            <th scope="col"><input type="button" name="com_view9" id="com_view9" value="Print 1"  class="btn_purchase2" /></th>
            <th scope="col"><input type="button" name="com_view10" id="com_view10" value="Print 2"  class="btn_purchase2" /></th>
            <th scope="col"><input type="button" name="com_view11" id="com_view11" value="GRN History"  class="btn_purchase2" onclick="grnhistory();" /></th>
            <th scope="col"><input type="button" name="com_view12" id="com_view12" value="Quit"  class="btn_purchase2" /></th>
          </tr>
        </table></td>
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
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
  </table>
  
  </fieldset>
  
  </fieldset>
  </td></tr><tr>
  <td width="8" valign="top"><table width="700" border="0">
    <tr>
      <th width="25%" scope="col"><input type="button" name="com_view" id="com_view" value="Process"  class="btn_purchase2" onclick="advance_proces();" /></th>
      <th width="25%" scope="col"><input type="button" name="com_view13" id="com_view13" value="Clear Content"  class="btn_purchase2" /></th>
      <th width="25%" scope="col">&nbsp;</th>
      <th width="25%" scope="col">&nbsp;</th>
    </tr>
    <tr>
      <td><input type="text"  class="label_purchase" value="Sales" disabled="disabled"/></td>
      <td><input type="text" size="20" name="txtsales" id="txtsales" value="" class="text_purchase3"/></td>
      <td><input type="text"  class="label_purchase" value="Ret. Cheque" disabled="disabled"/></td>
      <td><input type="text" size="20" name="txtretcheq" id="txtretcheq" value="" class="text_purchase3"/></td>
    </tr>
    <tr>
      <td><input type="text"  class="label_purchase" value="Return" disabled="disabled"/></td>
      <td><input type="text" size="20" name="txtrtn" id="txtrtn" value="" class="text_purchase3"/></td>
      <td><input type="text"  class="label_purchase" value="Over 60 Out" disabled="disabled"/></td>
      <td><input type="text" size="20" name="txtover60" id="txtover60" value="" class="text_purchase3"/></td>
    </tr>
    <tr>
      <td><input type="text"  class="label_purchase" value="CRN" disabled="disabled"/></td>
      <td><input type="text" size="20" name="txtcrn" id="txtcrn" value="" class="text_purchase3"/></td>
      <td><input type="text"  class="label_purchase" value="Adjustment" disabled="disabled"/></td>
      <td><input type="text" size="20" name="TXTADJ" id="TXTADJ" value="" class="text_purchase3"/></td>
    </tr>
    <tr>
      <td><input type="text"  class="label_purchase" value="Ratio" disabled="disabled"/></td>
      <td><input type="text" size="20" name="TXTRATO" id="TXTRATO" value="" class="text_purchase3"/></td>
      <td><input type="text"  class="label_purchase" value="Percentage" disabled="disabled"/></td>
      <td><input type="text" size="20" name="txtper" id="txtper" value="" class="text_purchase3"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="text"  class="label_purchase" value="Total Net Sale" disabled="disabled"/></td>
      <td><input type="text" size="20" name="txtnett" id="txtnett" value="" class="text_purchase3"/></td>
    </tr>
    <tr>
      <td><input type="text"  class="label_purchase" value="Less" disabled="disabled"/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" size="20" name="txtded1" id="txtded1" value="" class="text_purchase3"/></td>
      <td><input type="text" size="20" name="txtdedamou1" id="txtdedamou1" value="" class="text_purchase3"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" size="20" name="txtded2" id="txtded2" value="" class="text_purchase3"/></td>
      <td><input type="text" size="20" name="txtdedamou2" id="txtdedamou2" value="" class="text_purchase3"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" size="20" name="txtded3" id="txtded3" value="" class="text_purchase3"/></td>
      <td><input type="text" size="20" name="txtdedamou3" id="txtdedamou3" value="" class="text_purchase3"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" size="20" name="txtded4" id="txtded4" value="" class="text_purchase3"/></td>
      <td><input type="text" size="20" name="txtdedamou4" id="txtdedamou4" value="" class="text_purchase3"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" size="20" name="txtded5" id="txtded5" value="" class="text_purchase3"/></td>
      <td><input type="text" size="20" name="txtdedamou5" id="txtdedamou5" value="" class="text_purchase3"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" size="20" name="txtded6" id="txtded6" value="" class="text_purchase3"/></td>
      <td><input type="text" size="20" name="txtdedamou6" id="txtdedamou6" value="" class="text_purchase3"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" size="20" name="txtded7" id="txtded7" value="" class="text_purchase3"/></td>
      <td><input type="text" size="20" name="txtdedamou7" id="txtdedamou7" value="" class="text_purchase3"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" size="20" name="txtded8" id="txtded8" value="" class="text_purchase3"/></td>
      <td><input type="text" size="20" name="txtdedamou8" id="txtdedamou8" value="" class="text_purchase3"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><div id="msgrid"></div></td>
      </tr>
    <tr>
      <td><input type="hidden" name="msgridcount" id="msgridcount" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
    </td>
 </tr>
  
  </table>
</form>        

</fieldset>    
            
              	