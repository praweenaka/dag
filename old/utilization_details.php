
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
		
	}

</script>

</label>
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Utilization</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td><input type="hidden" name="txt_stat" id="txt_stats" /></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Ref No" disabled="disabled"/></td>
    <td><input type="text" disabled="disabled" name="txtrefno" id="txtrefno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
    <td> <a href="serach_uti.php?stname=uti" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
      <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
    </a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td colspan="2">
      <input type="text" size="20" name="dtdate" id="dtdate" value="<?php echo date("Y-m-d"); ?>" disabled="disabled"  class="text_purchase3"/>
    </td>
    <td> </td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled="disabled"/></td>
    <td><input type="text" disabled="disabled"  class="text_purchase3" name="Txtcusco" id="Txtcusco"/></td>
    <td colspan="2">
      <input type="text" disabled="disabled"  class="text_purchase3" id="txt_cusname" name="txt_cusname" />
    </a></td>
    <td>
     <a href="" onclick="NewWindow('serach_customer.php?stname=utilization','mywin','800','700','yes','center');return false" onfocus="this.blur()"> <input type="button" name="searchinv3" id="searchinv3" value="..." class="btn_purchase1" /></a>
    </td>
    <td>
<input type="checkbox" name="chkinv" id="chkinv" onclick="settle_inv();" />Settle Invoice   
    </td>
    <td>
     <input type="checkbox" name="chkcash" id="chkcash" onclick="settle_cash();" />Cash Pay  
   </td>
    <td>
    	<input type="checkbox" name="chkret" id="chkret" onclick="ret_chq_settle();" />Return Cheque  
    
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="10%"><input type="text"  class="label_purchase" value="Address" disabled="disabled"/></td>
    <td width="10%" colspan="2"><input type="text"  class="text_purchase3"  disabled="disabled" id="TXTADD" name="TXTADD" />      <a href="search_grn.php?stname=grn" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%" colspan="2"><a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="text"  class="label_purchase" value="ARN/GRN/DGRN/CRN/PAY" disabled="disabled"/></td>
    <td colspan="2"><input type="text" name="txtcrnno" id="txtcrnno" value="" class="text_purchase3"   />
      <a href="serach_rec.php?stname=cash_rec" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
    <td><a href="search_arn_grn_crn_all.php" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv2" id="searchinv2" value="..." class="btn_purchase1" />
    </a></td>
    <?php 
    
		if (($_SESSION["CURRENT_USER"] =="admin") or ($_SESSION["CURRENT_USER"] =="Buddhika1")) {
                     echo"<td><a href=\"search_arn_grn_crn_all_1.php\" onclick=\"NewWindow(this.href,'mywin','800','700','yes','center');return false\" onfocus=\"this.blur()\">
                     <input type=\"button\" name=\"searchinv2\" id=\"searchinv2\" value=\"...\" class=\"btn_purchase1\" />
                      </a></td>";
    		
		} 	
   ?>
   
    
    <td><input type="text"  class="label_purchase" value="Pending Balance" disabled="disabled"/></td>
    <td colspan="2">
      <input type="text" name="txtcrnamount" id="txtcrnamount" value="" class="text_purchase3"   />
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><input type="hidden" name="mcount" id="mcount" />
      <input type="hidden" name="mcount_chq" id="mcount_chq" />
      <input type="hidden" name="cmdsave" id="cmdsave" value="1" />
      <input type="hidden" name="cmdcancel" id="cmdcancel" value="1" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Remaining Balance" disabled="disabled"/></td>
    <td colspan="2"><a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text" name="txtrem_bal" id="txtrem_bal" value="" class="text_purchase3"   />
    </a></td>
    <td>&nbsp;</td>
  </tr>
  
    <tr>
    
    <td colspan="8">
    	<div id="cashcre">
    		
    	</div>
    </td>
   
  </tr>
  
  
  </table>

  
  <br/>   
<fieldset>               
            
  <div class="CSSTableGenerator" id="invdetails" >
  <table width="71%">
      <tr>
        <td width="10%"   background="" ><font color="#FFFFFF">Code</font></td>
        <td width="20%"  background=""><font color="#FFFFFF">Description</font></td>
        <td width="10%"  background=""><font color="#FFFFFF">Rate</font></td>
        <td width="10%"  background=""><font color="#FFFFFF">Qty</font></td>
        <td width="10%"  background=""><font color="#FFFFFF">Discount</font></td>
        <td width="10%"  background=""><font color="#FFFFFF">Sub Total</font></td>
      </tr>
    </table>
  </div>
</fieldset> 
<fieldset>
 <div class="CSSTableGenerator" id="chkdetails" >   
<table width="71%">
  <tr>
    <td width="10%"   background="" ><font color="#FFFFFF">Code</font></td>
    <td width="20%"  background=""><font color="#FFFFFF">Description</font></td>
    <td width="10%"  background=""><font color="#FFFFFF">Rate</font></td>
    <td width="10%"  background=""><font color="#FFFFFF">Qty</font></td>
    <td width="10%"  background=""><font color="#FFFFFF">Discount</font></td>
    <td width="10%"  background=""><font color="#FFFFFF">Sub Total</font></td>
  </tr>
</table>
</div>
</fieldset>

  

<br />

<table width="799" border="0">
  <tr>
    <td width="144"><input type="text"  class="label_purchase" name="lblcah" id="lblcah" value="Cash" disabled="disabled" style="visibility:hidden"/></td>
    <td width="127"><input type="text" size="20" name="txtcash" id="txtcash" value="" onblur="settot();"  class="text_purchase3" style="visibility:hidden"/></td>
      
      
      
    <td width="96">
      <input type="button" name="searchcust4" id="searchcust4" value="Invoice"  class="btn_purchase2" onclick="inv_btn();" />
    </td>
    <td width="140">
      <input type="button" name="searchcust5" id="searchcust5" value="Settlement"  class="btn_purchase2" onclick="settlement();" />
    </td>
    <td width="7">&nbsp;</td>
    <td width="144"><input type="text"  class="label_purchase" value="Total" disabled="disabled"/></td>
  <td width="122"><input type="text" size="20" name="lblPaid" id="lblPaid" value="" disabled="disabled" class="text_purchase3"/></td>  
  </tr>
</table>

<br />
<fieldset>               
            
   	<legend>Cheque Pay</legend>
  <table width="84%" border="0">
      
      
      <tr>
        <td><input type="text"  class="label_purchase" name="lblchqno" id="lblchqno" value="Cheque No" disabled="disabled" style="visibility:hidden"/></td>
        <td><input type="text" size="20" name="txtchno" id="txtchno" value="" class="text_purchase3" style="visibility:hidden"/></td>
        <td>&nbsp;</td>
        <td><input type="text"  class="label_purchase" value="Cheque Date" disabled="disabled" name="lblchqdate" id="lblchqdate" style="visibility:hidden"/></td>
        <td><input type="text"  class="text_purchase3" size="10" id="DTPicker1" name="DTPicker1" onfocus="load_calader('DTPicker1')" style="visibility:hidden"/>
        
      </td>
    </tr>
      <tr>
        <td><input type="text"  class="label_purchase" value="Bank" name="lblchbank" id="lblchbank" disabled="disabled" style="visibility:hidden"/></td>
        <td><input type="text" size="20" name="txtchbank" id="txtchbank" value="" class="text_purchase3" style="visibility:hidden"/></td>
        <td>&nbsp;</td>
        <td><input type="text"  class="label_purchase" value="Amount" disabled="disabled" name="lblamt" id="lblamt" style="visibility:hidden"/></td>
        <td><input type="text" size="20" name="txtamount" id="txtamount" value="" class="text_purchase3" onblur="set_cash_pay();" style="visibility:hidden"/></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="16%" colspan="2">
       <fieldset> <legend>As at Credit Note Balance</legend> 
        <table width="274" border="0">
          <tr>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="As st date" disabled="disabled"/></th>
            <th width="120" scope="col"><input type="text" size="20" name="DTasat" id="DTasat" onfocus="load_calader('DTasat')" class="text_purchase3"/></th>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><select name="com_type" id="com_type" onkeypress="keyset('brand',event);" onchange="setord();" class="text_purchase3">
              <?php
                $sql="select * from s_stomas where act='0' order by CODE";
                $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                while($row = mysqli_fetch_array($result)){
                echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
                }
                ?>
            </select></td>
          </tr>
          <tr>
            <td><input type="text"  class="label_purchase" value="Process" disabled="disabled"/></td>
            <td><input type="checkbox" name="Check1" id="Check1" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
              <input type="button" name="com_view" id="com_view" value="View"  class="btn_purchase2" />
            </a></td>
          </tr>
        </table>
       </fieldset>        </td>
        <td width="11%" colspan="4">
         <fieldset> <legend>Periodic Report</legend> 
        <table width="583" border="0">
          <tr>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="Date from" disabled="disabled"/></th>
            <th width="120" scope="col"><input type="text" size="20" name="dtfrom" id="dtfrom" onfocus="load_calader('dtfrom')" class="text_purchase3"/></th>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="Date from" disabled="disabled"/></th>
            <th width="157" scope="col"><input type="text" size="20" name="dtto" id="dtto" onfocus="load_calader('dtto')" class="text_purchase3"/></th>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><select name="Combo1" id="Combo1" onkeypress="keyset('brand',event);" onchange="setord();" class="text_purchase3">
              <?php
                $sql="select * from s_stomas where act='0'  order by CODE";
                $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                while($row = mysqli_fetch_array($result)){
                echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
                }
                ?>
            </select></td>
            <td><input type="radio" name="op_crenote" id="op_crenote" value="radio" />Credit Note</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
            <input type="button" name="com_View_repo" id="com_View_repo" value="View"  class="btn_purchase2" />
            </a></td>
            <td><input type="radio" name="op_Settlement" id="op_Settlement" value="radio" />Settlement</td>
            <td>&nbsp;</td>
          </tr>
        </table>
       </fieldset>        </td>
      </tr>
</table>
</form>        

</fieldset>    
            
              	