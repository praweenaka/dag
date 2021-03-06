
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
</script>

</label>
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Enter GIN Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%"><input type="text"  class="label_purchase" value="Ref No" disabled/></td>
    <td width="10%"><input type="text" disabled="disabled" name="invno" id="invno" value="" class="text_purchase" onKeyPress="keyset('searchcust',event);"   />
      <a href="search_gin.php?stname=gin" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchinv2" id="searchinv2" value="..." class="btn_purchase1" >
      </a></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="10%"><input type="text"  name="invdate" id="invdate" value="<?php echo date("Y-m-d"); ?>" disabled="disabled" class="text_purchase3"/></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="From" disabled/></td>
    <td><select name="from_dep" id="from_dep" onkeypress="keyset('brand',event);" class="text_purchase3">
      <option value=""> --Select-- </option>
      <?php
																	$sql="select * from s_stomas order by CODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
																		if ($row["CODE"]=="01"){
                        													echo "<option selected value='".$row["CODE"]."'>".$row["DESCRIPTION"]."</option>";
																		}	else {
																			echo "<option value='".$row["CODE"]."'>".$row["DESCRIPTION"]."</option>";
																		}
                       												}
																?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="To " disabled/></td>
    <td><select name="to_dep" id="to_dep" onkeypress="keyset('brand',event);" class="text_purchase3">
      <option value=""> --Select-- </option>
      <?php
																	$sql="select * from s_stomas order by CODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
																		if ($row["CODE"]=="01"){
                        													echo "<option selected value='".$row["CODE"]."'>".$row["DESCRIPTION"]."</option>";
																		}	else {
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
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
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
      <input type="text"  class="label_purchase" value="Code" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Description" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Part No" disabled/>
    </span></td>
    <td  width="10%"><span class="style1">
      <input type="text"  class="label_purchase" value="Qty" disabled/>
    </span></td>
    <td  width="10%">&nbsp;</td>
    </tr>
  <tr>
    <td><font color="#FFFFFF">
    <div id="test"> <input type="text"  class="text_purchase3" name="itemd_hidden" id="itemd_hidden" onblur="itno_ind();" onKeyPress="keyset('qty',event);"     />
   </div>  </font></td>
    <td><input type="text"  class="text_purchase2"  id="itemd" name="itemd" disabled="disabled"  ><a href="serach_item_gin.php" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"><input type="button" name="searchcust" id="searchcust" value="..." class="btn_purchase1" ></a></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="partno" id="partno" value="" class="text_purchase3" onKeyPress="keyset('qty',event);"/>
    </font></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="qty" id="qty" value="" class="text_purchase3" onKeyPress="keyset('additem_tmp',event);"/>
    </font></td>
    <td><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onClick="add_tmp();" class="btn_purchase1"></td>
    </tr>
  <tr>
	<td colspan="4">
    <div class="CSSTableGenerator" id="itemdetails" >
<table>
                                                        			<tr>
                              											<td width="70"  background="images/headingbg.gif" ><font color="#FFFFFF">Code</font></td>
                              											<td width="300"  background="images/headingbg.gif"><font color="#FFFFFF">Description</font></td>
                              											<td width="100"  background="images/headingbg.gif"><font color="#FFFFFF">Part No</font></td>
                              											<td width="100"  background="images/headingbg.gif"><font color="#FFFFFF">Qty</font></td>
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
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="ARN No" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="txtarno" id="txtarno"    />
    <a href="serach_arn.php?mstatus=gin" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" >
      </a></font></td>
    <td><input type="button" name="additem_tmp2" id="additem_tmp2" value="Update" onclick="update();" class="btn_purchase1" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="AR Date" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text"  class="text_purchase3" name="DTARdate" id="DTARdate"      />
    </font></td>
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
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Stock Level" disabled="disabled"/>
    </span></td>
    <td><font color="#FFFFFF">
      <input type="text" size="15" name="stklevel" id="stklevel" value="" class="text_purchase3" disabled="disabled" />
    </font></td>
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