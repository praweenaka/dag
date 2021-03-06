<?php 
session_start();
require_once("connectioni.php");	
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
  <div class="text_forheader">Delivery Date Not Entered Report</div>
                                               	 </legend>             

<form id="form1" name="form1" action="report_stores_del_date_not.php" target="_blank" method="get">
<table width="767" border="0">
  
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="145" align="left"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="186" align="left"><input type="text" size="20" name="dtfrom" id="dtfrom" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtfrom');" class="text_purchase3" /></td>
    <td width="209" align="left"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="209" align="left"><input type="text" size="20" name="dtto" id="dtto" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtto');" class="text_purchase3" /></td>
  </tr>
  <tr>
  
  <td><input type="text"  class="label_purchase" value="Rep." disabled="disabled"/></td>
 <td> <select name="cmbrep" id="cmbrep" onkeypress="keyset('dte_dor',event);"  class="text_purchase3">
            <?php
                if ($_SESSION["CURRENT_REP"]=="") {
                    echo "<option value='All'>All</option>";			 						
                    $sql="select * from s_salrep where cancel='1' order by REPCODE";
                    $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                    while($row = mysqli_fetch_array($result)){
                        echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                    }
		} else {
                    $sql="select * from s_salrep where cancel='1' and repcode = '" . $_SESSION["CURRENT_REP"] ."' order by REPCODE";
                    echo $sql;
                    $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                    while($row = mysqli_fetch_array($result)){
                    echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                    }
                }
                ?>
    </select></td>
  
  </tr>
   <tr>
  
  <td><input type="text"  class="label_purchase" value="Type" disabled="disabled"/></td>
        <td colspan="2"><select name="cmbbrand1" id="cmbbrand1" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="setord();">
        <option value="All">All</option> 
            <?php
																	$sql="select class from brand_mas group by class ";
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["class"]."'>".$row["class"]."</option>";
                       												}
																?>
        </select></td>
  
  </tr>
  
  <tr>
    <td colspan="2" align="left"><input type="checkbox" name="checkbox" id="checkbox" />
      Delivery Date Not Entered</td>
	   <td align="left"><input type="checkbox" name="chk_can" id="chk_can" />
      Cancelled</td>
    <td><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
  </tr>
</table>
<fieldset>               
            
 
</form>        

   
            
          