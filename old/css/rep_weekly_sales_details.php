
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

						 
	


<script language="JavaScript" src="js/outstand.js"></script>
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
function load_calader_month(tar){
		new JsDatePick({
			useMode:2,
			target:tar,
			dateFormat:"%Y-%m-%d"
			
		});
		
	}

</script>

</label>
          
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
<fieldset>
                                                	<legend>
  <div class="text_forheader">Weekly Sales Report</div>
                                               	 </legend>             

<form id="form1" name="form1" action="report_weekly_sales.php" target="_blank" method="get">
<table width="767" border="0">
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">  </td>
  </tr>
  <tr>
    <td width="422" align="left"><table width="274">
      <tr>
        <td width="76" align="left">&nbsp;</td>
        <td width="186">&nbsp;</td>
      </tr>
    </table></td>
    <td width="422" align="left">&nbsp;</td>
    <td width="160" colspan="3"><select name="cmbdev" id="cmbdev" class="text_purchase3">
      <?php
    	if ($_SESSION['dev'] == "1") {
			echo "<option value=\"ALL\">ALL</option>
			<option value=\"Manual\">Manual</option>
			<option value=\"Computer\">Computer</option>";
		} else {
			echo "<option value=\"Computer\">Computer</option>";
		}	
	?>
    </select></td>
    </tr>
  
  <tr>
    <td colspan="3" align="left"><table width="710" border="0">
      <tr>
        <th width="140" scope="col"><input type="radio" name="radio" id="optrep" value="optrep" checked="checked" />
          Rep wise</th>
        <th width="160" scope="col"><input type="radio" name="radio" id="optbrand" value="optbrand" />
Brand wise</th>
        <th width="218" scope="col"><input type="radio" name="radio" id="OPsum" value="OPsum" />
Summery</th>
        <th width="174" scope="col"><input type="radio" name="radio" id="Optcus" value="Optcus" />
          Customer wise</th>
      </tr>
      
    </table></td>
    <td colspan="2" align="left"><table width="100" border="0">
      <tr>
        <th scope="col">&nbsp;</th>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" align="left">
    <fieldset>
    <table width="821" border="0">
      <tr>
        <th width="147" scope="col"><input type="checkbox" name="chkdef" id="chkdef" />
With Defective</th>
        <th width="59" scope="col">&nbsp;</th>
        <th width="84" scope="col">&nbsp;</th>
        <th width="144" scope="col"><input type="text"  class="label_purchase" value="Deparment" disabled="disabled"/></th>
        <th width="162" scope="col"><select name="cmbdep" id="cmbdep" onkeypress="keyset('brand',event);" class="text_purchase3">
          <?php
																	$sql="select * from s_stomas order by CODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
                       												}
																?>
        </select></th>
        <th width="195" colspan="2" scope="col">&nbsp;</th>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
        <td><select name="cmbcat" id="cmbcat" onkeypress="keyset('dte_dor',event);" class="text_purchase3">
          <option value='All'>All</option>
          <?php
																	$sql="select * from s_salrep order by REPCODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
        </select></td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td><input type="text"  class="label_purchase" value="Week" disabled="disabled"/></td>
        <td><select name="cmbweek" id="cmbweek" class="text_purchase3">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select></td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="text"  class="label_purchase" value="Month" disabled="disabled"/></td>
        <td><input type="text" name="calmon" id="calmon" class="text_purchase3" onfocus="load_calader_month('calmon')" onchange="set_session();"/></td>
        <td colspan="2">&nbsp;</td>
      </tr>
    </table>
    </fieldset></td>
    </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
    <td colspan="3" align="left"><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
    </tr>
  <tr>
    <td width="422" colspan="2" align="left">&nbsp;</td>
    <td width="160" align="left"></td>
    <td width="399" colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="422" colspan="2" align="left"></td>
    <td>&nbsp;</td>
  </tr>
</table>

             
            
 
</form>        

   
            
          