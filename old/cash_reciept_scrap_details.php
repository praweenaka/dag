
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
function load_calader(tar){
		new JsDatePick({
			useMode:2,
			target:tar,
			dateFormat:"%Y-%m-%d"
			
		});
		
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
                                                	
                                               	 <form name="form1" id="form1"> 
                                                  <input type="hidden" name="cmd_new" id="cmd_new" value="1" />
    <input type="hidden" name="cmd_save" id="cmd_save" value="0"/>
    <input type="hidden" name="cmd_cancel" id="cmd_cancel" value="0"/>
    <input type="hidden" name="cmd_print" id="cmd_print" value="0"/>
    <input type="hidden" name="cmd_utilization" id="cmd_utilization" value="0"/>    
    <input type="hidden" name="hiddencount" id="hiddencount" />        
  <table width="1170" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="144"><input type="text"  class="label_purchase" value="Reciept No" disabled="disabled"/></td>
    <td width="147"><input type="text" disabled="disabled" name="invno" id="invno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
    <td width="154"><a href="serach_rec.php?stname=cash_rec" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
    </a></td>
    <td width="122"></td>
    <td width="28"></td>
    <td width="144"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td colspan="3"><select name="salesrep" id="salesrep"  onblur="custno('cash_rec_rep');" onkeypress="keyset('chqno',event);" class="text_purchase3">
      <?php
																	$sql="select * from s_salrep where cancel='1' order by REPCODE";
																	
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
    </select></td>
    </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="cuscode" id="cuscode"  value="SCRP" onkeypress="keyset('salesrep',event);"/></td>
    <td colspan="2"> <a href="" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text" class="text_purchase3" id="cusname" name="cusname" value="SCRAP SALES REGISRTY" />
    </a><a href="serach_rec.php?stname=cash_rec" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></td>
    <td><a href="serach_customer.php?stname=cash_rec" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase1" disabled="disabled" />
    </a></td>
    <td><input type="text"  class="label_purchase" value="Cheque Collected" disabled="disabled"/></td>
    <td colspan="3">
      <select name="chqcollect" id="chqcollect" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
        <?php
																	$sql="select * from s_salrep order by REPCODE";
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
      </select>    </td>
    </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled="disabled"/></td>
    <td colspan="3"><input type="text"  class="text_purchase3"  disabled="disabled" id="cus_address" name="cus_address" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Entry Date" disabled="disabled"/></td>
    <td width="144"><input type="text" size="20" name="invdate" id="invdate" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('invdate')"  class="text_purchase3"/></td>
    <td width="208"><input type="text"  class="label_purchase" value="Cost Center" disabled="disabled"/></td>
    <td width="41"><select name="costcenter" id="costcenter"  class="text_purchase3">
      <?php 
														 	for ($i=1; $i<51; $i++){
																echo "<option value=".$i.">".$i."</option>";
															}
                                                         ?>
    </select></td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Payment Type" disabled="disabled"/></td>
    <td><select name="paytype" id="paytype"  class="text_purchase3" onchange="chng_type();" >
      <option selected="selected" value="Cash">Cash</option>
      <option value="Cheque">Cheque</option>
      <option value="J/Entry">J/Entry</option>
      <option value="Cash TT">Cash TT</option>
    </select></td>
    <td><input type="text"  class="label_purchase" value="T/T Date" disabled="disabled"/></td>
    <td><div id="tt">
      <input type="text" size="20" name="dt" id="dt" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dt')" disabled="disabled" class="text_purchase3"/></div>  </td>
    <td>&nbsp;</td>
    <td><a href="search_grn.php?stname=grn" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text"  class="label_purchase" value="T/T No" disabled="disabled"/>
    </a></td>
    <td><input type="text" class="text_purchase3" name="ca_refno" id="ca_refno" onblur="search_cust_ind();"/></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td><a href="search_grn.php?stname=grn" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text"  class="label_purchase" value="Debit Account" disabled="disabled"/>
    </a></td>
    <td><a href="search_grn.php?stname=grn" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"><font color="#FFFFFF"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="accno" id="accno" size="10" value="120500" onkeypress="keyset('chqdate',event);"     />
    </font></font></a></td>
    <td colspan="2"><font color="#FFFFFF"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="acc_name" name="acc_name" value="Cash In Hand" onkeypress="keyset('bank',event);" />
    </font></font><font color="#FFFFFF"><font color="#FFFFFF"><a href="search_ledger_acc.php?stname=chq_return" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></font></font></td>
    <td><font color="#FFFFFF"><font color="#FFFFFF"><a href="search_ledger_acc.php?stname=cash_rec1" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="additem_tmp5" id="additem_tmp5" value="..." class="btn_purchase1" />
    </a></font></font></td>
    <td><a href="search_grn.php?stname=grn" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text"  class="label_purchase" value="Credit Account" disabled="disabled"/>
    </a></td>
    <td><font color="#FFFFFF"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="accno2" id="accno2" size="10" value="120100" onkeypress="keyset('chqdate',event);"      />
    </font></font></td>
    <td><font color="#FFFFFF"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" size="10" id="acc_name2" name="acc_name2" value="Trade Debtors" onkeypress="keyset('bank',event);" />
    </font></font></td>
    <td><font color="#FFFFFF"><font color="#FFFFFF"><font color="#FFFFFF"><a href="search_ledger_acc.php?stname=cash_rec2" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="additem_tmp3" id="additem_tmp3" value="..." class="btn_purchase1" />
    </a></font><a href="search_ledger_acc.php?stname=chq_return" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></font></font></td>
  </tr>
  </table>

  
 

    <table width="1200" border="0">
      
      <tr>
        <th scope="col" width="600" valign="top">
        <fieldset>               
            
   		<legend><div class="text_forheader">Cheques Details</div></legend>
         <table width="600" border="0">
            <tr>
              <td width="17%"><span class="style1">
                <input type="text"  class="label_purchase" value="Cheque No" disabled="disabled"/>
              </span></td>
              <td  width="17%"><span class="style1">
                <input type="text"  class="label_purchase" value="Cheque Date (yyyy-mm-dd)" disabled="disabled"/>
              </span></td>
              <td  width="22%"><span class="style1">
                <input type="text"  class="label_purchase" value="Bank" disabled="disabled"/>
              </span></td>
              <td  width="6%">&nbsp;</td>
              <td  width="19%"><span class="style1">
                <input type="text"  class="label_purchase" value="Amount" disabled="disabled"/>
              </span></td>
            </tr>
            <tr>
              <td><font color="#FFFFFF">
                <div id="test"><font color="#FFFFFF">
                  <input type="text"  class="text_purchase3" name="chqno" id="chqno" size="10" onkeypress="keyset('chqdate',event);"  onblur="chk_chqno();"/>
                </font></div>
              </font></td>
              <td><font color="#FFFFFF">
              <?php
			  
			if ($_SESSION['company']=="THT"){
                echo "<input type=\"text\"  class=\"text_purchase3\" size=\"10\" id=\"chqdate\" name=\"chqdate\" onblur=\"chk_calader();\"  onkeypress=\"keyset('bank',event);\" />";
			} else if ($_SESSION['company']=="BEN"){
                echo "<input type=\"text\"  class=\"text_purchase3\" size=\"10\" id=\"chqdate\" name=\"chqdate\" onfocus=\"load_calader('chqdate')\"  onkeypress=\"keyset('bank',event);\" />";
			}		
			
			?>
              
              </font></td>
              <td><font color="#FFFFFF">
                <input type="text" size="15" name="bank" id="bank" value="" class="text_purchase3" onblur="get_bank();" onkeypress="keyset('chqamt',event);"/>
              <a href="search_bank.php?stname=cash_rec" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a> </font></td>
              <td><font color="#FFFFFF"><a href="search_bank.php?stname=cash_rec" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
                <input type="button" name="additem_tmp2" id="additem_tmp2" value="..." class="btn_purchase1" />
              </a></font></td>
              <td><font color="#FFFFFF">
                <input type="text" size="15" name="chqamt" id="chqamt" value="" onblur="calc1();" class="text_purchase3" onkeypress="keyset('additem_tmp',event);"/>
              </font></td>
              <td width="2%"><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onclick="addchq_cash_rec();" class="btn_purchase1" /></td>
            </tr>
            </table>
        <div id="itemdetails1111" style="overflow:scroll;  height:170px" >
          <table width="600" border="0">
            
            <tr>
              <td colspan="5"><div class="CSSTableGenerator" id="chq_table" >
                  <table width="500">
                    <tr>
                      <td width="10%"  ><font color="#FFFFFF">Cheque No</font></td>
                      <td width="10%" ><font color="#FFFFFF">Cheque Date</font></td>
                      <td width="10%" ><font color="#FFFFFF">Bank</font></td>
                      <td width="10%" ><font color="#FFFFFF">Qty</font></td>
                      <td width="10%" ><font color="#FFFFFF">Amount</font></td>
                    </tr>
                  </table>
              </div></td>
            </tr>
          </table>
        </div>
        </fieldset>        </th>
        <th scope="col" valign="top">
       
        <fieldset>               
            
   	<legend><div class="text_forheader">Utilization Details</div></legend>
  	<div class="CSSTableGenerator"  id="utilization" style="overflow:scroll; height:200px"></div>
</fieldset>        </th>
      </tr>
      <tr>
        <th scope="col" valign="top"><table width="615" border="0">
          <tr>
            <td width="144"><input type="text"  class="label_purchase" value="Cheque Total" disabled="disabled"/></td>
            <td width="127"><input type="text" size="20" name="chqtot" id="chqtot" value="" disabled="disabled" class="text_purchase3"/></td>
            <td width="58">&nbsp;</td>
            <td width="144"><input type="text"  class="label_purchase" value="Cash Total" disabled="disabled"/></td>
            <td width="120"><input type="text" size="20" name="cashtot" id="cashtot" value="" class="text_purchase3"/></td>
          </tr>
        </table></th>
        <th scope="col" valign="top">&nbsp;</th>
      </tr>
    </table>


                                                 </form> 
</form> 

<fieldset>               
            
   	<legend><div class="text_forheader">Invoice Details</div></legend>
  <table width="84%" border="0">
      
      
      <tr>
        <td colspan="5"><div class="CSSTableGenerator" id="inv_details" >
        	<div class="CSSTableGenerator" id="itemdetails" >
            <table width="71%">
              <tr>
                <td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Code</font></td>
                <td width="20%"  background="images/headingbg.gif"><font color="#FFFFFF">Description</font></td>
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Rate</font></td>
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Qty</font></td>
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Discount</font></td>
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Sub Total</font></td> 
              </tr>
            </table>
            </div>
        </div></td>
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
        <td><input type="text"  class="label_purchase" value="Selected Invoice Amount" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtpaytot" id="txtpaytot" value="" disabled="disabled" class="text_purchase3"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="17%">&nbsp;</td>
        <td width="16%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
        <td width="17%"><input type="text"  class="label_purchase" value="Over Payment" disabled="disabled"/></td>
        <td width="17%"><input type="text" size="20" name="txtoverpay" id="txtoverpay" value="" disabled="disabled" class="text_purchase3"/></td>
        <td width="11%">&nbsp;</td>
        <td width="1%">&nbsp;</td>
      </tr>
</table>
</form>        

</fieldset>    
            
