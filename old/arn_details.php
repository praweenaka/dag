
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


<link rel="stylesheet" href="css/table_min.css" type="text/css"/>	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript" language="javascript" src="js/get_cat_description.js"></script>
<script type="text/javascript" language="javascript" src="js/datepickr.js"></script>


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
			target:"invdate",
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
  <div class="text_forheader">ARN Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="14%"><input type="text"  class="label_purchase" value="ARN No" disabled/></td>
    <td width="15%"><input type="text" name="invno" id="invno" disabled value="" class="text_purchase3" onkeypress="keyset('searchcust',event);"  />
     </td>
    <td width="14%"> <a href="serach_arn.php" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" >
      </a></td>
    <td width="14%">&nbsp;</td>
    <td width="24%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="14%"><input type="text"  name="invdate" id="invdate" value="<?php echo date("Y-m-d"); ?>"   class="text_purchase3"/></td>
    <td width="2%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="LC No " disabled="disabled"/></td>
    <td><input id="lc_no" type="text" class="text_purchase3" /></td>
    <td><input type="text"  class="label_purchase" value="PI No " disabled="disabled"/></td>
    <td><input id="pi_no" name="pi_no" type="text" class="text_purchase3" /></td>
    <td><input type="text"  class="label_purchase" value="Department" disabled="disabled"/></td>
    <td><select name="department" id="department" onkeypress="keyset('brand',event);" class="text_purchase3">
     
      <?php
        $sql="select * from s_stomas where act='0' order by DESCRIPTION";
        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
        while($row = mysqli_fetch_array($result)){
            if ($row["CODE"]=="1"){
                 echo "<option selected value='".$row["CODE"]."'>".$row["DESCRIPTION"]."</option>";
            }else {
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
    <td><input type="text"  class="label_purchase" value="Purchase Invoice Date" disabled="disabled"/></td>
    <td><input id="dte_dor" name="dte_dor" type="text"  value="" class="text_purchase3" /></td>
    <td><input type="text"  class="label_purchase" value="Brand " disabled="disabled"/></td>
    <td><input id="brand" name="brand" type="text" onkeypress="keyset('department',event);" class="text_purchase3" /></td>
    <td><input type="text"  class="label_purchase" value="Order No" disabled="disabled"/></td>
    <td width="14%"><input type="text" name="orderno1" id="orderno1" disabled  value="" onkeypress="keyset('orderdate',event);" class="text_purchase3"/>
     </td>
    <td width="14%"><a href="search_purord.php?stname=arn" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"><input type="button" name="searchord" id="searchord" value="..." class="btn_purchase2" ></a></td>
    
     
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Supplier" disabled/></td>
    <td><input type="text" class="text_purchase3" name="supplier_code" id="supplier_code" onblur="suppno_ind('arn');" onkeypress="keyset('purtype',event);"/>
      <a href="" onClick="NewWindow('serach_supplier.php?stname=arn','mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchcust2" id="searchcust2" value="..."  class="btn_purchase1">
      </a></td>
    <td><input type="text"  class="label_purchase" value="Purchase Type" disabled="disabled"/></td>
    <td>
      <select name="purtype" id="purtype" onkeypress="keyset('vatgroup_0',event);" class="text_purchase3" onchange="assignbrand();">
        <option value='Import'>Import</option>
        <option value='Local'>Local</option>
      </select>
    <input type="hidden" name="count" id="count"></td>
    <td><input type="text"  class="label_purchase" value="Country" disabled="disabled"/></td>
    <td><input type="text" size="15" name="country" id="country" value="" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><input type="text"  class="text_purchase3" size="65" id="supplier_name" name="supplier_name" /></td>
    <td><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td><select name="salesrep" id="salesrep" onkeypress="keyset('dte_dor',event);" class="text_purchase3">
      <?php
    	require_once("connectioni.php");
        if ($_SESSION["MANAGER"]!="") { 			 						
            $sql="select * from s_salrep where cancel='1' and manager='".$_SESSION["MANAGER"]."'order by REPCODE"; 
            $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
            while($row = mysqli_fetch_array($result)){
                echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
            }
         }else if ($_SESSION["CURRENT_REP"]=="") { 			 						
            $sql="select * from s_salrep where cancel='1' order by REPCODE";
            $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
            while($row = mysqli_fetch_array($result)){
                echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
            }
         } else {
             $sql="select * from s_salrep where cancel='1' and repcode = '" . $_SESSION["CURRENT_REP"] ."' order by REPCODE";
             $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
             while($row = mysqli_fetch_array($result)){
             echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
             }
         }
    ?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Special Instruction" disabled="disabled"/></td>
    <td colspan="3"><textarea name="textarea" id="textarea" cols="45" rows="2" class="text_purchase5"></textarea></td>
    <td><input type="text"  class="label_purchase" value="Cost Centre" disabled="disabled"/></td>
    <td><select name="costcenter" id="costcenter" onkeypress="keyset('vatgroup_0',event);" class="text_purchase3" onchange="assignbrand();">
      <option> --Select-- </option>
      <option value='1'>1</option>
      <option value='2'>2</option>
      <option value='3'>3</option>
      <option value='4'>4</option>
      <option value='5'>5</option>
      <option value='6'>6</option>
      <option value='7'>7</option>
      <option value='8'>8</option>
      <option value='9'>9</option>
      <option value='10'>10</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Container Size" disabled="disabled"/></td>
    <td><input type="text" size="15" name="contsize" id="contsize" value="" onkeypress="keyset('creditlimit',event);" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
   
    <td><input type="text"  class="label_purchase" value="Stocks Received" disabled="disabled"/></td>
    <td>
	<select name="arpend" id="arpend" class="text_purchase3">
	<option value='0'>Received</option>	
	<option value='1'>Pending</option>
	
	</select>
	</td>
	 <td><a class='btn_purchase1' onClick="update_arstat();">Update</a></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
<fieldset>               
            
   	<legend><div class="text_forheader">Item Details</div></legend>            
            
  <table width="94%" border="0">
    
  
  <tr>
	<td width="30%" colspan="9">
    <div class="CSSTableGenerator" id="itemdetails" >
<table>
                                                        			<tr>
                              											<td width="70"  background="images/headingbg.gif" ><font color="#FFFFFF">Code</font></td>
                              											<td width="300"  background="images/headingbg.gif"><font color="#FFFFFF">Description</font></td>
                              											<td width="100"  background="images/headingbg.gif"><font color="#FFFFFF">Order Qty</font></td>
                              											<td width="100"  background="images/headingbg.gif"><font color="#FFFFFF">FOB</font></td>
                                                                        <td width="100"  background="images/headingbg.gif"><font color="#FFFFFF">Qty</font></td>
                                                                        <td width="100"  background="images/headingbg.gif"><font color="#FFFFFF">Cost</font></td>
                                                                        <td width="100"  background="images/headingbg.gif"><font color="#FFFFFF">Selling</font></td>
                                                                        <td width="100"  background="images/headingbg.gif"><font color="#FFFFFF">Margin</font></td>
                                                                        <td width="100"  background="images/headingbg.gif"><font color="#FFFFFF">Sub Total</font></td>
                           											</tr>
                   												</table>   </div>                                                 		</td>
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
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="text"  class="label_purchase" value="Total QTY" disabled="disabled"/></td>
    <td width="10%"> <input type="text" size="20" name="total_qty" id="total_qty" value="" disabled onblur="calc1();" class="text_purchase3" onkeypress="keyset('discount',event);"/>
    </font></td>
    <td width="10%"><input type="text"  class="label_purchase" value="Total Value" disabled="disabled"/></td>
    <td width="10%"><font color="#FFFFFF">
      <input type="text" size="20" name="total_value" id="total_value" value="" disabled onblur="calc1();" class="text_purchase3" onkeypress="keyset('discount',event);"/>
    </font></td>
    </tr>
</table>
          

</form>        

</fieldset>    
            
            <table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">