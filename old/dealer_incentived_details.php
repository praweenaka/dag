
<?php 
 
						 
	require_once("connectioni.php");
	
 
?>	

						 
	



<link rel="stylesheet" href="css/table_min.css" type="text/css"/>	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="js/dealer_incentived_tht.js"></script>

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

</label><fieldset>
                                                	<legend>
  <div class="text_forheader">Dealer Incentive</div>
                                               	 </legend>             

<form name="form1" id="form1">  
 <table border="0"><tr><td width="1301">         
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled="disabled"/></td>
    <td><input type="text"  class="text_purchase3" disabled="disabled" name="firstname_hidden" id="firstname_hidden" onblur="custno_ind('')" onkeypress="keyset('department',event);"/></td>
    <td colspan="2">
      <input type="text" class="text_purchase3" id="firstname" name="firstname" />
   </td>
    <td><a href="" onclick="NewWindow('serach_customer.php?stname=incentive','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase" />
    </a></td>
    <td><input type="text"  class="label_purchase" value="Month" disabled="disabled"/></td>
    <td><input type="text" name="DTPicker1" id="DTPicker1" value="" class="text_purchase3"  onfocus="load_calader('DTPicker1')" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="10%"><select name="cmbtype" id="cmbtype" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
    <option value='GREENTOUR' selected="selected">GREENTOUR</option>
    <option value='LONGLIFE'>LONGLIFE</option>
  
    </select></td>
    <td width="10%"><input type="hidden" name="mcount" id="mcount" /></td>
    <td width="10%"><input type="text"  class="label_purchase" value="%" disabled="disabled"/></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Total apply sale for Incentive" disabled="disabled"/></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Less GRN Values" disabled="disabled"/></td>
    <td width="10%"><input type="text"  class="label_purchase" value="VAT %" disabled="disabled"/></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Net Sale" disabled="disabled"/></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><script type="text/javascript">
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
</script>    <a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
    <td> 
      <input type="text" name="txt_percentage" id="txt_percentage" value="0" disabled="disabled"  class="text_purchase3"   />
    </td>
    <td width="10%"><a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a><a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text" name="txt_tot" id="txt_tot" value="" disabled="disabled" class="text_purchase3"   />
    </a></td>
    <td><a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text" name="txt_grn" id="txt_grn" value="" disabled="disabled" class="text_purchase3"   />
    </a></td>
    <td>      <input type="text" name="txt_vat" id="txt_vat" value="12" class="text_purchase3"   />
    </td>
    <td><a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text" name="txttotal" id="txttotal" value="" disabled="disabled" class="text_purchase3"   />
    </a></td>
    <td> <a href="serach_customer.php?stname=ret_chq_settle" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></td>
  </tr>
  </table>

  
  <div class="CSSTableGenerator" id="dealer_ins" style="overflow:scroll;  height:300px" ></div>
 


  





<fieldset>
<input  style="font-size:20px;color:red;" type="text" size="20" name="txt_out" id="txt_out" value="" class="text_purchase3"/>
<table width="94%" border="0">
  
  <tr>
    <td ><table  border="0">
      
      <tr>
        <td><input type="text"  class="label_purchase" value="Incentive Amount" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txttot_inc" id="txttot_inc" value=""   class="text_purchase3"/></td>
        <td><input type="text"  class="label_purchase" value="Adjustment/ Less Interest" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtint" id="txtint" value="" class="text_purchase3"/></td>
        <td><input type="text"  class="label_purchase" value="Net Incentive" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtnetin" id="txtnetin" value="" disabled="disabled" class="text_purchase3"/></td>
        <td><input type="text"  class="label_purchase" value="Chq no" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txt_chno" id="txt_chno" value="" disabled="disabled" class="text_purchase3"/></td>
         
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="9%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="9%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="9%">&nbsp;</td>
        <td width="9%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" rowspan="2"><textarea name="txtremark" id="txtremark" cols="45" rows="5"></textarea></td>
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
        <td colspan="2"><input type="checkbox" name="chq_ignore" id="chq_ignore" />
          Ignore due to return chq</td>
        <td><textarea id="txtRemarkUpdate" rows="5" cols="45" name="txtRemarkUpdate"></textarea></td>
        
        <?php
            $sql_perm="select * from userpermission where username='".$_SESSION['UserName']."' and docid='".$row_doc['docid']."' ";
            $result_perm =mysqli_query($GLOBALS['dbinv'],$sql_perm);
            $row_perm= mysqli_fetch_array($result_perm);

            if ($row_perm["doc_feed"]=="1"){
                echo "<td><input type=\"button\" value=\"Update\" class=\"btn_purchase2\" onclick=\"updateRemark()\"></td>";
            }else{
                echo "<td>&nbsp;</td>";
            }
        ?>
        
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3"><textarea name="txtremark_new" id="txtremark_new" cols="45" rows="5"></textarea></td>
        <td><input type="submit" name="button" id="update" value="Submit" /></td>
        <td>&nbsp;</td>
        <td><input type="text"  class="label_purchase" value="Prepared by" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtPrepare" id="txtPrepare" value="" class="text_purchase3"/></td>
        <td><input type="text"  class="label_purchase" value="Authorized by" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtauth" id="txtauth" value="" class="text_purchase3"/></td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="10"></td>
      </tr>
      <tr>
        <td width="11%">&nbsp;</td>
        <td width="9%">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
 
  </table>
  
   
   	
  
  
  </fieldset>
  </td></tr><tr>
    <td width="8" valign="top">&nbsp;</td>
  </tr>
  
  </table>
</form>        

</fieldset>    
            
              	