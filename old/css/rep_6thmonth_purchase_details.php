
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

						 
	


<script language="JavaScript" src="js/pur_ord.js"></script>
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
          
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
<fieldset>
                                                	<legend>
  <div class="text_forheader">6th Month Purchase Report</div>
                                               	 </legend>             

<form id="form1" name="form1" action="report_6thmonth_purchase.php" target="_blank" method="get">
<table width="816" height="547" border="0" cellpadding="0" class="bcgl1">
  <tr height="20">
    <th width="812" colspan="16" valign="top"> <table width="817" border="0">
      <tr>
        <td width="274" align="left"><table width="274">
          <tr>
            <td width="76" align="left">Brand</td>
            <td width="186"><select name="brand" id="brand" onkeypress="keyset('brand',event);" class="text_purchase3">
              <option value='All'>All</option>
              <?php
																	$sql="select * from brand_mas order by barnd_name";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
                       												}
																?>
            </select>
            </td>
          </tr>
        </table></td>
        <td width="173"><table>
          <tr>
            <td><input type="text" size="20" name="dte_from" id="dte_from" value="<?php echo date("Y-m-d"); ?>" class="text_purchase3"/>
                      <script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dte_from",
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
 </td>
          </tr>
        </table></td>
        <td width="356">&nbsp;</td>
      </tr>
      <tr>
        <td width="274" align="left"></td>
        <td colspan="2"><table>
          <tr>
            <td width="80" align="left">Group I</td>
            <td><input type="text" name="txtgroup1" id="txtgroup1" class="text_purchase3"/></td>
            <td width="80" align="left">Group II</td>
            <td><input type="text" name="txtgroup2" id="txtgroup2" class="text_purchase3"/></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="274" align="left"></td>
        <td colspan="2"><table>
          <tr>
            <td><label></label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="274" align="left"><fieldset>
          <legend><div class="text_forheader">
            <input type="checkbox" name="chkitem" id="chkitem" />
            Select Items</div></legend>
          <input type="checkbox" name="chkall" id="chkall" />
          All Items<br />
          <?php
                                                    echo "<select multiple=\"multiple\" name=\"available\" id=\"available\" size=20>";
													
													$sql="select STK_NO, DESCRIPT from s_mas order by STK_NO";
													$result =$db->RunQuery($sql);
													while($row = mysql_fetch_array($result)){
            										 	
 														echo "<option id=".$row["STK_NO"]." value=".$row["STK_NO"]." ondblclick=\"sel_one('".$row['STK_NO']."');\">".$row["STK_NO"]." ".$row["DESCRIPT"]."</option>";		
													}
          											echo "</select>";
													
													?>
        </fieldset></td>
        <td colspan="2"><fieldset>
          <legend><div class="text_forheader">Selected Items</div></legend>
          <div id="availab"><br />
                <select multiple="multiple" name="selectedit" id="selectedit" size="20">
                  ";
													
											  				
                </select>
          </div>
        </fieldset></td>
      </tr>
      <tr>
        <td width="274" align="left"><table>
          <tr>
            <td width="60" align="left"></td>
            <td></td>
          </tr>
        </table></td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="274" align="left"></td>
        <td colspan="2"><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
      </tr>
    </table></th>
  </tr>
  <tr>
    <th colspan="16" valign="top"><br />
    </th>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<fieldset>               
            
 
</form>        

   
            
          