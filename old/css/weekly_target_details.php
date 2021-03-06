
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
  <div class="text_forheader">Target Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td width="10%"><select name="Com_rep" id="Com_rep" onkeypress="keyset('dte_dor',event);" class="text_purchase3">
      <?php
																	$sql="select * from s_salrep order by REPCODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
    </select></td>
    <td width="10%"> <a href="search_grn.php?stname=grn" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      
    </a></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Ref No" disabled="disabled"/></td>
    <td><input type="text" disabled="disabled" name="txtref" id="txtref" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('grnno');"  onblur="lost_focus('grnno');"  /></td>
    <td><a href="search_tar.php" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
    </a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="dtfrom" id="dtfrom" value="<?php echo date("Y-m-d"); ?>" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td><input type="text" size="20" name="dtto" id="dtto" value="<?php echo date("Y-m-d"); ?>" disabled="disabled" class="text_purchase3"/></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
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
            
   	<legend><div class="text_forheader">Item Details</div></legend>            
            
  <table width="84%" border="0">
  
  <tr>
    <td width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Date" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Cus.Code" disabled/>
    </span></td>
    <td  width="40%"><span class="style1">
      <input type="text"  class="label_purchase" value="Cus. Name" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Target" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Remark" disabled="disabled"/>
    </span></td>
  
    <td  width="10%">&nbsp;</td>
    </tr>
  <tr>
    <td><font color="#FFFFFF">
    <div id="test"><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="tar_date" id="tar_date" size="10" onkeypress="keyset('itemd',event);"     />
    </font></div>  </font></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase6" size="15" id="cus_code" name="cus_code" disabled="disabled" onkeypress="keyset('rate',event);" />
    </font> <a href="" onClick="NewWindow('serach_customer.php?stname=weekly_tar','mywin','800','700','yes','center');return false" onFocus="this.blur()"><input type="button" name="searchitem" id="searchitem" value="..." class="btn_purchase" ></a></td>
    <td><font color="#FFFFFF">
      <input type="text" size="40" name="cus_name" id="cus_name" value="" disabled="disabled" class="text_purchase3" onkeypress="keyset('qty',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="target" id="target" value="" class="text_purchase3" onkeypress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="remark" id="remark" value=""  class="text_purchase3" onkeypress="keyset('subtotal',event);"/><input type="hidden" size="15" name="discount" id="discount" value=""  class="txtbox" />
    </font></td>
    <td><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onclick="add_tmp();" class="btn_purchase1" /></td>
  </tr>
  <tr>
	<td colspan="6">
    <div class="CSSTableGenerator" id="itemdetails" >
<table>
                                                        			<tr>
                              											<td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Date</font></td>
                              											<td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Cus.Code</font></td>
                              											<td width="40%"  background="images/headingbg.gif"><font color="#FFFFFF">Cus. Name</font></td>
                              											<td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Target</font></td>
                                                                        <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Remark</font></td>
                           											</tr>
                   												</table>   </div>                                                 		</td>
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
          

</form>        

</fieldset>    
            
            <table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">