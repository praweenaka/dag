
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
  <div class="text_forheader">Commission Schedule Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="18%"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td width="18%"><select name="cmbrep" id="cmbrep" onchange="show_bal();" class="text_purchase3">
    	<option value=''></option>
      <?php
																	$sql="select * from s_salrep order by REPCODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
    </select></td>
    <td>&nbsp;</td>
    <td width="29%"><input type="text"  class="label_purchase" value="General Target (Not effect to the commission calculation)" disabled="disabled"/></td>
    <td width="25%"><input id="txttar" name="txttar" type="text"  value="" class="text_purchase3" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="2nd Target For Commission" disabled="disabled"/></td>
    <td><input id="txtT2" name="txtT2" type="text"  value="" class="text_purchase3" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="1st Target For Commission" disabled="disabled"/></td>
    <td><input id="txtT1" name="txtT1" type="text"  value="" class="text_purchase3" /></td>
  </tr>
  <tr>
    <td width="18%" colspan="2">CAT 1 < Day 1 =< CAT 2 < Day 2 =< CAT 3</td>
    <td width="10%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
<fieldset>               
            
   	<legend></legend>            
            
  <table width="57%" border="0">
    
  
  <tr>
    <td width="11%">&nbsp;</td>
    <td width="25%" bgcolor="#FF99CC">Normal</td>
    <td colspan="3"  bgcolor="#FFFF66">More Than 1st Target</td>
    <td colspan="4" bgcolor="#00CCCC">More Than 2nd Target</td>
    <td width="2%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
  </tr>
  <tr>
	<td colspan="11">
    <div class="CSSTableGenerator" id="itemdetails" >
<div id="comm_table"></div>
<input type="hidden" name="mtot" id="mtot" size="10" value="120" > </div>                                                 		</td>
                                                		</tr>
  
  <tr>
    <td colspan="3">&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="17%">&nbsp;</td>
    <td width="13%">&nbsp;</td>
    </tr>
</table>
          

</form>        

</fieldset>    
            
            <table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">