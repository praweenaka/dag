
<?php 
/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/




/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/

	

						 
	include_once("connection.php");
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
			target:"DTinv_date",
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
          
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {color: #FF0000; font-size: 36px; }
-->
</style>
<fieldset>
                                                	<legend>
  <div class="text_forheader">Enter Cheque Pay Details</div>
                                               	 </legend>
                                               	 <form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%"><input type="hidden" name="hiddencount" id="hiddencount" /></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Entry No" disabled="disabled"/></td>
    <td colspan="2"> <a href="serach_rec_acc.php?stname=cash_rec" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
      <input type="text" disabled="disabled" name="txt_entno" id="txt_entno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  />
    </a></td>
    <td><a href="serach_chq_pay_acc.php?stname=chq_pay" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
    </a></td>
    <td><input type="text"  class="label_purchase" value="Entry Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="Calendar1" id="Calendar1" value="<?php echo date("Y-m-d"); ?>" disabled="disabled" class="text_purchase3"/></td>
    <td colspan="2">&nbsp;</td>
    <td><div class="style2" id="labcan"> </div></td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Voucher No" disabled="disabled"/></td>
    <td colspan="2"><input type="text"  class="text_purchase3" name="TXT_HEADING" id="TXT_HEADING"/></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="A/C Payee Only" disabled="disabled"/></td>
    <td><input type="checkbox" name="Check1" id="Check1" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Barer" disabled="disabled"/></td>
    <td colspan="6">
      <input type="text"  class="text_purchase3" name="txt_bea" id="txt_bea"/>
    </td>
    <td><a href="search_checus_acc.php?stname=cheque_pay" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv2" id="searchinv2" value="..." class="btn_purchase1" />
    </a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Invoice No" disabled="disabled"/></td>
    <td colspan="2">
      <input type="text" class="text_purchase3" name="txtINVNO" id="txtINVNO"/>
    </td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Invoice Date" disabled="disabled"/></td>
    <td>
     <input type="text"  class="text_purchase3" size="10" id="DTinv_date" name="DTinv_date" onkeypress="keyset('bank',event);" />
        
        <script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"DTinv_date",
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
   </td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="VAT No" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtVATNO" id="txtVATNO"/></td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Naration" disabled="disabled"/></td>
    <td colspan="7">
      <input type="text" class="text_purchase3" name="TXT_NARA" id="TXT_NARA"/>
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="VAT Barer" disabled="disabled"/></td>
    <td colspan="7">
      <select name="txtvatbea" id="txtvatbea"  class="text_purchase3">
        <?php 
			include('connection.php');
			
			$sql="select bea1 from paymas group by bea1";
			$result=mysql_query($sql, $dbacc);
			while($row = mysql_fetch_array($result)){	
				echo "<option value=\"".$row["bea1"]."\">".$row["bea1"]."</option>	";
			}
      ?>
      </select>
   </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><input type="text"  class="label_purchase" value="Commission Advance/Balance" disabled="disabled"/>
     </td>
    <td colspan="2">
      <select name="Combo1" id="Combo1"  class="text_purchase3">
      	<option value=""></option>
        <?php 

			$sql="select * from s_commadva where chno='0' and  appby != '0' and Lock1 = '1'";
			$result=mysql_query($sql, $dbinv);
			while($row = mysql_fetch_array($result)){	
				echo "<option value=\"".$row["refno"]."\">".$row["refno"]."</option>	";
			}
      ?>
      </select>
   </td>
    <td colspan="2"><input type="text"  class="label_purchase" value="Incentive" disabled="disabled"/></td>
    <td colspan="2">
      <select name="Combo2" id="Combo2"  class="text_purchase3">
      <option value=""></option>
        <?php 
		
			$sql="Select * from ins_payment where chno = '0'";
			$result=mysql_query($sql, $dbinv);
			while($row = mysql_fetch_array($result)){	
				$incen = trim($row["id"]) . " " . trim($row["cusCode"]) . " " . trim($row["I_month"]) . " " . trim($row["I_year"]);
				//$incen=$row["id"]." ".$row["cuscode"]." ".$row["i_month"]." ".$row["i_year"];
				echo "<option value=\"".$incen."\">".$incen."</option>	";
			}
      ?>
      </select>
    </td>
    </tr>
  </table>
<br>
  <fieldset>               
            
   	<legend><div class="text_forheader"></div></legend>
  <table width="84%" border="0">
      <tr>
        <td><span class="style1">
          <input type="text"  class="label_purchase" value="Amount in word" disabled="disabled"/>
        </span></td>
        <td colspan="3"><font color="#FFFFFF">
          <input type="text"  class="text_purchase3" size="10" id="txt_amoinword" name="txt_amoinword" onkeypress="keyset('bank',event);" />
        </font></td>
      </tr>
      <tr>
        <td width="18%"><span class="style1">
          <input type="text"  class="label_purchase" value="Bank" disabled="disabled"/>
        </span></td>
        <td  width="30%">
       
          <select name="com_cas" id="com_cas"  class="text_purchase3" onchange="set_chno();">
          	<option value=""></option>
            <?php 
		
			$sql="select * from lcodes where cat='B'";
			echo $sql;
			$result=mysql_query($sql, $dbacc);
			while($row = mysql_fetch_array($result)){	
				echo "<option value=\"".$row["c_code"]."\">".$row["c_code"]." ".$row["c_name"]."</option>	";
			}
      ?>
          </select>
        </td>
        <td  width="26%"><span class="style1">
        <input type="text"  class="label_purchase" value="Cheque No" disabled="disabled"/>
        </span></td>
        <td  width="26%"><font color="#FFFFFF">
          <input type="text"  class="text_purchase3" size="10" id="txt_cheno" name="txt_cheno" onkeypress="keyset('bank',event);" />
        </font></td>
      </tr>
  </table>
       

</fieldset>    

  <br/>   
<fieldset>               
            
   	<legend><div class="text_forheader">Debit</div></legend>
  <table width="89%" border="0">
  <tr>
        <td width="17%"><span class="style1">
        <input type="text"  class="label_purchase" value="Account No" disabled="disabled"/>
        </span></td>
        <td  width="17%"><span class="style1">
        <input type="text"  class="label_purchase" value="Account Name" disabled="disabled"/>
        </span></td>
        <td  width="32%"><span class="style1">
        <input type="text"  class="label_purchase" value="Description" disabled="disabled"/>
        </span></td>
        <td  width="6%">&nbsp;</td>
        <td  width="19%"><span class="style1">
        <input type="text"  class="label_purchase" value="Amount" disabled="disabled"/>
        </span></td>
    </tr>
      <tr>
        <td><font color="#FFFFFF">
          <div id="test"><font color="#FFFFFF">
            <input type="text"  class="text_purchase3" name="accno" id="accno" size="10" onkeypress="keyset('chqdate',event);"     />
          </font></div>
        </font></td>
        <td><font color="#FFFFFF">
        <input type="text"  class="text_purchase3" size="10" id="acc_name" name="acc_name" onkeypress="keyset('bank',event);" />
        
        <script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"chqdate",
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
        <td><font color="#FFFFFF">
          <input type="text" size="15" name="descript" id="descript" value="" class="text_purchase3" />
        
        </font></td>
        <td><font color="#FFFFFF"><a href="search_ledger_acc.php?stname=cheque_pay" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
          <input type="button" name="additem_tmp2" id="additem_tmp2" value="..." class="btn_purchase1" />
        </a></font></td>
        <td><font color="#FFFFFF">
          <input type="text" size="15" name="amt" id="amt" value="" class="text_purchase3" onkeypress="keyset('additem_tmp',event);"/>
        </font></td>
        
      
        <td width="5%"><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onClick="addchq_cash_rec();" class="btn_purchase1" /></td>
    </tr>
      <tr>
        <td colspan="5"><div class="CSSTableGenerator" id="chq_table" >
          <table width="80%">
              <tr>
                <td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Account No</font></td>
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Account Name</font></td>
                <td width="20%"  background="images/headingbg.gif"><font color="#FFFFFF">Description</font></td>
              
                <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Amount</font></td>
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
        <td>&nbsp;</td>
        <td width="2%">&nbsp;</td>
        <td width="2%">&nbsp;</td>
      </tr>
    </table>
       

</fieldset>    



<br />

<table width="921" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Pay Total" disabled="disabled"/></td>
    <td><input type="text" size="20" name="TXT_DEBTOT" id="TXT_DEBTOT" value="" disabled="disabled" class="text_purchase3"/></td>
  </tr>
  <tr>
    <td width="144">&nbsp;</td>
    <td width="127">&nbsp;</td>
      
      
      
    <td width="58">&nbsp;</td>
    <td width="58">&nbsp;</td>
    <td width="209">&nbsp;</td>
    <td width="144">&nbsp;</td>
  <td width="151">&nbsp;</td>  
  </tr>
</table>


<fieldset>               
            
<legend>
</legend>
</form>        

</fieldset>    
            
<table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">