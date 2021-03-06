
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
function load_calader(tar){
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
  <div class="text_forheader">Bin Card Report</div>
                                               	 </legend>             

<form id="form1" name="form1" action="report_bin_card_print.php" target="_blank" method="get">


<table width="1062" border="0">
  
  <tr>
    <td width="183" align="left"><input type="radio" name="radio" id="Option1" value="Option1" checked="checked"  />
      Print Bin card</td>
    <td width="243" align="left"><input type="radio" name="radio" id="Option2" value="Option2" />
      Print Invoice</td>
<td align="left"><input type="radio" name="radio" id="Option3" value="Option3" />
              Option3</td>
    <td width="102" align="left">&nbsp;</td>
    <td width="264" align="left">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="5" align="left"><fieldset><table width="1049" border="0">
      <tr>
        <th width="146" scope="col"><input type="text"  class="label_purchase" value="Location" disabled="disabled"/></th>
        <th colspan="2" scope="col"><select name="cmbdep" id="cmbdep" onkeypress="keyset('brand',event);" class="text_purchase3">
          <?php
		  														
																echo "<option value='All'>All</option>";
																
																	$sql="select * from s_stomas order by CODE";
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
                       												}
																?>
        </select></th>
        <th colspan="2" scope="col" align="right"><input type="checkbox" name="checkbox" id="checkbox" />
          <input type="text"  class="text_purchase" name="firstname_hidden" id="firstname_hidden" onblur="custno_ind('')" onkeypress="keyset('department',event);"/>
          <a href="" onClick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></th>
        <th width="343" scope="col"><input type="text" class="text_purchase3" id="firstname" name="firstname" />
          <a href="" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></th>
        <th width="88" scope="col"><a href="" onclick="NewWindow('serach_customer.php?stname=bin_card','mywin','800','700','yes','center');return false" onfocus="this.blur()">
          <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase1" />
        </a></th>
      </tr>
      <tr>
        <td><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
        <td colspan="2"><select name="Com_rep" id="Com_rep" onkeypress="keyset('dte_dor',event);" class="text_purchase3">
          <?php
																	
																	echo "<option value='All'>All</option>";
																	
																	$sql="select * from s_salrep where cancel='1' order by REPCODE";
																	
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
        </select></td>
        <td width="142">&nbsp;</td>
        <td colspan="3"><input type="hidden" name="invno" id="invno"  value="<?php echo $_GET["invno"]; ?>"/></td>
      </tr>
      <tr>
        <td><input type="text"  class="label_purchase" value="From" disabled="disabled"/></td>
        <td width="120"><input type="text" size="20" name="dtfrom" id="dtfrom" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtfrom')" class="text_purchase3"/></td>
        <td width="144"><div id="dateto_name"><input type="text"  class="label_purchase" value="To" disabled="disabled"/></div></td>
        <td><div id="dateto"><input type="text" size="20" name="dtto" id="dtto" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtto')" class="text_purchase3"/></div></td>
        <td width="36"></td>
        <td colspan="2">&nbsp;</td>
      </tr>
    </table>
    </fieldset></td>
    </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
    <td width="248" align="left"></td>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"></td>
    <td><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
  </tr>
</table>
<fieldset>               
            
 
</form>        

   
            
          