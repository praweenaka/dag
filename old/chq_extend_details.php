<?php   
	

						 
	require_once("connectioni.php");
	
	
	
	$_SESSION["insert"]=0;
	$_SESSION["update"]=0;
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
                                                	<legend>
  <div class="text_forheader">Enter Cheque Extend Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%"><input type="text"  class="label_purchase" value="Ref No" disabled="disabled"/></td>
    <td width="10%"><input type="text" name="txtrefno" id="txtrefno" disabled="disabled" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);"   onblur="purord_ind('ord');"  /></td>
    <td width="10%"><a href="search_cheq_extn.php?stname=extend" onclick="NewWindow(this.href,'mywin','1000','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
    </a></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="txtsdate" id="txtsdate" value="<?php echo date("Y-m-d"); ?>" disabled="disabled" class="text_purchase3"/></td>
    <td width="10%"><a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Time" disabled="disabled"/></td>
    <td width="10%"><input type="text" size="20" name="txttime" id="txttime" disabled="disabled" value="" class="text_purchase3"/>
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
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Cheque No" disabled="disabled"/></td>
    <td><input type="text" name="txtch_no" id="txtch_no" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('searchcust',event);"   onblur="purord_ind('ord');"  /></td>
    <td><a href="search_cheq.php?stname=extend" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv2" id="searchinv2" value="..." class="btn_purchase1" />
    </a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled/></td>
    <td colspan="3"><input type="text" class="text_purchase1" name="txtcode" id="txtcode" disabled="disabled" onblur="suppno_ind('purord');" onkeypress="keyset('salesrep',event);"/>
      <input type="text" disabled="disabled"  class="text_purchase2" id="txtname" name="txtname" />      </td>
    <td><input type="text"  class="label_purchase" value="Type Ref No" disabled="disabled"/></td>
    <td colspan="2"><input type="text" size="20" name="typeref" id="typeref" disabled="disabled" value="" class="text_purchase3"/></td>
    <td><input type="text"  class="label_purchase" id="dedlb1" value="Ded.(Ins.) From Dealer" disabled/></td>
    <td>
	<select name="ded" id="ded"  class="text_purchase3">
        				<option value='--'></option>
						<option value='YES'>YES</option>	
						<option value='NO'>NO</option>									 
        </select>
	
	</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Sales Ex:" disabled/></td>
    <td colspan="2"><input type="text"  class="text_purchase4"  disabled="disabled" id="txtsal_ex" name="txtsal_ex" /></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Reciept Date" disabled="disabled"/></td>
    <td colspan="2"><input type="text" size="20" name="recdate" id="recdate" disabled="disabled" value="" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Cheque Amount" disabled="disabled"/></td>
    <td colspan="2"><input type="text"  class="text_purchase4"  disabled="disabled" id="txtch_amount" name="txtch_amount" /></td>
    <td>&nbsp;</td>
    <td><label></label></td>
    <td><label></label></td>
    <td><label></label></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="24"><input type="text"  class="label_purchase" value="Cheque Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtch_date" id="txtch_date"  disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Extend" disabled="disabled"/></td>
    <td><input type="text" size="20" name="txtchexdate" id="txtchexdate"  class="text_purchase3" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('txtchexdate');"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Approved By" disabled="disabled"/></td>
    <td colspan="2"><input type="text"  class="text_purchase3"  id="txtapproved" disabled="disabled" name="txtapproved" /></td>
    <td><input type="text"  class="label_purchase" value="Post By Acc Dep" disabled="disabled"/></td>
    <td colspan="3"><input type="text"  class="text_purchase3"  id="Textposted" disabled="disabled" name="Textposted" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>


 <tr>
    <td><input type="text" disabled="disabled" value="Previous Extended" class="label_purchase"></td>
    <td><input type="text" disabled="disabled" value="1st Date" class="label_purchase"></td>
    <td><input type="text" onfocus="load_calader('txtchexdate');" value="" class="text_purchase3" disabled="disabled" id="txtfirstdate" name="txtfirstdate" size="20"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>

<tr>
    <td></td>
    <td><input type="text" disabled="disabled" value="2nd Date" class="label_purchase"></td>
    <td><input type="text" onfocus="load_calader('txtchexdate');" value="" class="text_purchase3" disabled="disabled" id="txtseconddate" name="txtseconddate" size="20"></td>
    <td></td>
    <td></td>
    <td><div id="lblmodi" class="style1"></div></td>
  </tr>



  </table>

  
  <br/>   
<fieldset>               
            
   	<legend>
   	<div class="text_forheader">Invoice Details</div>
  </legend>            
            
  <table width="84%" border="0">
  
  <tr>
	<td colspan="4">
    <div class="CSSTableGenerator" id="itemdetails" >
<table>
                                                        			<tr>
                              											<td width="10%"   background="" ><font color="#FFFFFF">Code</font></td>
                              											<td width="40%"  background=""><font color="#FFFFFF">Description</font></td>
                              											<td width="10%"  background=""><font color="#FFFFFF">Part No</font></td>
                              											<td width="10%"  background=""><font color="#FFFFFF">Qty</font></td>
                           											</tr>
                   												</table>   </div>                                                 		</td>
                                                		</tr>
  
  <tr>
    <td width="10%">&nbsp;</td>
    <td width="40%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
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
          

</form>        

</fieldset>    
            
            <table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">
