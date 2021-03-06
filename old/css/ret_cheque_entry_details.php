
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
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Enter Return Cheque Details</div>
                                               	 </legend>             

<form name="form1" id="form1">    



        
  <font color="#FFFFFF">
  
  </font>
<table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%"><input type="text"  class="label_purchase" value="Entry No" disabled="disabled"/></td>
    <td width="10%"><input type="text" disabled="disabled" name="lblReciptNo" id="lblReciptNo" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
    <td width="10%"><a href="search_ret_cheq.php?stname=ret_cheque_entry" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
    </a></td>
    <td width="10%"><input type="checkbox" name="chk_crenote" id="chk_crenote" />
      Credit Note</td>
    <td width="10%"><input type="hidden" name="txt_stat" id="txt_stat" /></td>
    <td width="10%"><a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Department" disabled="disabled"/></td>
    <td width="10%"><select name="com_dep" id="com_dep" onkeypress="keyset('brand',event);" onchange="setord();" class="text_purchase3">
      <?php
																	$sql="select * from s_stomas order by CODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
                       												}
																?>
    </select>
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
</script>    </td>
    <td width="10%"><div id="lab_cancel"></div></td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="DTPicker1" id="DTPicker1" value="<?php echo date("Y-m-d"); ?>" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Cost Center" disabled="disabled"/></td>
    <td><select name="com_costcent" id="com_costcent" onkeypress="keyset('brand',event);" onchange="setord();" class="text_purchase3">
      <?php
																	$sql="select * from s_stomas order by CODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
                       												}
																?>
    </select></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td><select name="com_rep" id="com_rep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
      <?php
																	$sql="select * from s_salrep where cancel='0' order by REPCODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled="disabled"/></td>
    <td colspan="3"><input type="text" disabled="disabled"  class="text_purchase1" name="Txtcusco" id="Txtcusco"/>
  <input type="text" disabled="disabled"  class="text_purchase2" id="txtcusname" name="txtcusname" />
        <a href="" onclick="NewWindow('serach_customer.php?stname=ret_cheque_entry','mywin','800','700','yes','center');return false" onfocus="this.blur()">
        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase" />
      </a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
<br/>   
  <br/> 
<fieldset>               
            
   	<legend><div class="text_forheader">Cheque Details</div></legend>            
            
  <table width="84%" border="0">
  <tr>
    <td width="17%"><span class="style1">
      <input type="text"  class="label_purchase" value="Cheque No" disabled/>
    </span></td>
    <td  width="31%"><input type="text" disabled="disabled"  class="text_purchase1" name="txtChequeNo" id="txtChequeNo"/>
      <a href="" onclick="NewWindow('search_cheq.php?stname=ret_cheque_entry','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust2" id="searchcust2" value="..."  class="btn_purchase" />
      </a></td>
    <td  width="22%"><input type="checkbox" name="Check1" id="Check1" />
    Counter Return</td>
    <td  width="16%"><span class="style1">
      <input type="text"  class="label_purchase" value="Deposite Date" disabled/>
    </span></td>
    <td  width="14%"><font color="#FFFFFF">
    <input type="text"  class="text_purchase3" size="10" id="DTPicker2" name="DTPicker2" onkeypress="keyset('bank',event);" />
      <script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"DTPicker2",
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
    </font></td>
    </tr>
  <tr>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Bank" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="cmbBankname" id="cmbBankname" value="" class="text_purchase3" />  
   </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  
  
  <tr>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Cheque Amount" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="txtChequeAmount" id="txtChequeAmount" value="" class="text_purchase3"  onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Cheque Deposit Bank" disabled="disabled"/>
    </span></td>
    <td><select name="cheq_dpo_bank" id="cheq_dpo_bank" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
      	<option value=''></option>
        <option value='H.N.B-I'>H.N.B-I</option>
        <option value='SBL'>SBL</option>
        <option value='SB'>SB</option>
        <option value='PB'>PB</option>
        <option value='CBC-I'>CBC-I</option>
        <option value='CBC-II'>CBC-II</option>
        <option value='HNB-II'>HNB-II</option>
        <option value='BOC'>BOC</option>
        <option value='DFCC'>DFCC</option>
        <option value='PABC'>PABC</option>
        
       </select></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Credit Note No" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="txtcrenoteno" id="txtcrenoteno" value="" class="text_purchase3"  onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Credit Note" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="txtcrenoteamo" id="txtcrenoteamo" value="" class="text_purchase3"  onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
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
          
      

</fieldset>    

<br />
<fieldset>               
            
   	<legend><div class="text_forheader">1st Return</div></legend>            
            
<table width="84%" border="0">
  <tr>
    <td width="17%"><span class="style1">
      <input type="text"  class="label_purchase" value="Return Ref No" disabled/>
    </span></td>
    <td  width="34%"><input type="text" disabled="disabled"  class="text_purchase1" name="lblretrefno" id="lblretrefno"/>
      <a href="" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust2" id="searchcust2" value="..."  class="btn_purchase" />
      </a></td>
    <td  width="23%"><span class="style1">
      <input type="text"  class="label_purchase" value="Date" disabled="disabled"/>
    </span></td>
    <td  width="21%"><font color="#FFFFFF">
      <input type="text" size="15" name="lblretdate" id="lblretdate" value="" class="text_purchase3"  onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td  width="5%">&nbsp;</td>
    </tr>
  <tr>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Return Cheque No" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="lblRET_chno" id="lblRET_chno" value="" class="text_purchase3"  onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><span class="style1">
    <input type="text"  class="label_purchase" value="No of Return" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="lblnoof" id="lblnoof" value="" class="text_purchase3"  onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td>&nbsp;</td>
    </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="radio" name="op_computer" id="op_computer" value="radio" />Computer</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
          
      

</fieldset>    
<br /><br />
 
            
  <table width="84%" border="0">
  <tr>
    <td width="18%"><span class="style1">
      <input type="text"  class="label_purchase" value="Bank Charges" disabled/>
    </span></td>
    <td  width="34%"><font color="#FFFFFF">
      <input type="text" size="15" name="txtRetChCha" id="txtRetChCha" value="" class="text_purchase3"  onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td  width="25%"><span class="style1">
      <input type="text"  class="label_purchase" value="Cheque Ref" disabled/>
      <input type="button" name="additem_tmp4" id="additem_tmp4" value="..." onclick="add_tmp();" class="btn_purchase1" />
    </span></td>
    <td  width="12%"><font color="#FFFFFF">
      <input type="text" size="15" name="txtforwhat" id="txtforwhat" value="" class="text_purchase3"  onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td  width="11%"><input type="button" name="additem_tmp2" id="additem_tmp2" value="Update" onclick="add_tmp();" class="btn_purchase1" /></td>
    </tr>
  <tr>
    <td><font color="#FFFFFF">
   
    </font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td colspan="4">
    <div class="CSSTableGenerator" id="itemdetails" >
<table>
                                                        			<tr>
                              											<td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Inv No</font></td>
                              											<td width="40%"  background="images/headingbg.gif"><font color="#FFFFFF">Date</font></td>
                              											<td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Inv Amt</font></td>
                              											<td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">St. Amt</font></td>
                           											</tr>
		  </table>   </div>                                                 		</td>
	</tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="button" name="additem_tmp" id="additem_tmp" value="Clear" onclick="add_tmp();" class="btn_purchase1" /></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="button" name="additem_tmp3" id="additem_tmp3" value="Update" onclick="add_tmp();" class="btn_purchase1" /></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="5"><textarea name="txtremark" id="txtremark" cols="45" rows="5"></textarea></td>
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
          

       

 


            
<table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">