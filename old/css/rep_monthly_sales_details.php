
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
function load_calader(tar){
		new JsDatePick({
			useMode:2,
			target:tar,
			dateFormat:"%Y-%m"
			
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
  <div class="text_forheader"> Monthly Sales Summery</div>
                                               	 </legend>             

<form id="form1" name="form1" action="report_repwise_sales_summery.php" target="_blank" method="get">
<table width="767" border="0">
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dtddate",
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
  </tr>
  <tr>
    <td colspan="2" align="left"><input type="checkbox" name="chkdef" id="chkdef" />
With Defective </td>
    <td align="left"><input type="radio" name="radio" id="Option1" value="Option1" />
      Normal</td>
    <td align="left"><input type="radio" name="radio" id="Option2" value="Option2" />
      Nil Sale</td>
    <td><input type="radio" name="radio" id="op_traget" value="op_traget" />
      Target Brands</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="422" colspan="2" align="left"><input type="checkbox" name="ChKCUS" id="ChKCUS" />
Customer</td>
    <td width="104" align="left">&nbsp;</td>
    <td width="104" align="left"><input type="text"  class="label_purchase" value="Grater Than" disabled="disabled"/></td>
    <td width="160"><a href="" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text" name="txt_amou" id="txt_amou" value="0" class="text_purchase3"/>
    </a></td>
    <td width="198">&nbsp;</td>
    <td width="399">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td align="left">&nbsp;</td>
    <td align="left"><select name="cmbbrand" id="cmbbrand" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="setord();">
      <option value='All'>All</option>
      <?php
	  			require_once("config.inc.php");
				require_once("DBConnector.php");
				$db = new DBConnector();
	
																	$sql="select * from brand_mas order by barnd_name";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
                       												}
																?>
    </select></td>
    <td align="left"><input type="text"  class="label_purchase" value="Month 1" disabled="disabled"/></td>
    <td align="left"><input type="text" name="month1" id="month1" class="text_purchase3" onfocus="load_calader('month1');"/></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td align="left">&nbsp;</td>
    <td align="left"><select name="salesrep" id="salesrep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
      <option value='All'>All</option>
      <?php
																	$sql="select * from s_salrep order by REPCODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
    </select></td>
    <td align="left"><input type="text"  class="label_purchase" value="Month 2" disabled="disabled"/></td>
    <td align="left"><input type="text" name="month2" id="month2" class="text_purchase3" onfocus="load_calader('month2');"/></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left"><input type="text"  class="label_purchase" value="Month 3" disabled="disabled"/></td>
    <td align="left"><input type="text" name="month3" id="month3" class="text_purchase3" onfocus="load_calader('month3');"/></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left"><table width="500" border="0">
      <tr>
        <th width="403" scope="col"><table width="400" border="0">
          <tr>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
          </tr>
          
        </table></th>
        <th width="87" scope="col"><table width="300" border="0">
          <tr>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
          </tr>
          
        </table></th>
      </tr>
    </table></td>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" align="left">   </td>
    </tr>
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="422" colspan="4" align="left">&nbsp;</td>
    <td width="160" align="left"></td>
    <td width="399" colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="422" colspan="4" align="left"></td>
    <td><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
  </tr>
</table>

             
            
 
</form>        

   
            
          