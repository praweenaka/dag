
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
  <div class="text_forheader">Sales Summery Report</div>
                                               	 </legend>             

<form id="form1" name="form1" action="report_sales_summery.php" target="_blank" method="get">
<table width="928" border="0">
  <tr>
    <td align="left"><input type="checkbox" name="chkcus" id="chkcus" />
          Customer Wise</td>
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
    <td width="392" align="left"><table width="274">
      <tr>
        <td width="76" align="left"><input type="text"  class="label_purchase" value="Customer" disabled/></td>
        <td width="186"><input type="text" name="cuscode" id="txt_cuscode" class="text_purchase3"/></td>
      </tr>
    </table></td>
    <td width="314"><a href="" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onfocus="this.blur()"><input type="text" name="cusname" id="cusname" class="text_purchase3"/>
      
    </a></td>
    <td colspan="2"><a href="serach_customer.php?stname=rep_outstand_state" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase1" />
    </a></td>
  </tr>
  <tr>
    <td colspan="4" align="left"><input type="text"  class="text_purchase3"  disabled="disabled" id="cus_address" name="cus_address" /></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2" align="left"><table width="500" border="0">
      <tr>
        <th width="403" scope="col"><table width="400" border="0">
          <tr>
            <th scope="col"><input type="radio" name="radio" id="optsales" value="optsales" checked="checked" onclick="chk_sales();" />
              Sales</th>
            <th scope="col"><input type="radio" name="radio" id="optreturn" value="optreturn" onclick="chk_return();"/>
              Return</th>
            <th scope="col"><input type="radio" name="radio" id="optsummery" value="optsummery" />
              Summery</th>
            <th scope="col"><input type="radio" name="radio" id="optscrap" value="optscrap" />
              Screap</th>
          </tr>
          <tr>
            <td><input type="radio" name="radio" id="radio" value="optreceipt" />
              Reciept</td>
            <td><input type="radio" name="radio" id="optitem" value="optitem" />
              Item Sales</td>
            <td><input type="radio" name="radio" id="OPttraget" value="OPttraget" />
              Target</td>
            <td>&nbsp;</td>
          </tr>
        </table></th>
        <th width="87" scope="col"><table width="300" border="0">
          <tr>
            <th scope="col"><div id="type"><select name="cmbtype" id="cmbtype" class="text_purchase3">
            	<option value="All">All</option>
                <option value="GRN">GRN</option>
                <option value="DGRN">DGRN</option>
                <option value="Credit Note">Credit Note</option>
            </select>           </div> </th>
            <th scope="col"><div id="dev"><select name="cmbdev" id="cmbdev" class="text_purchase3">
            	<option value="All">All</option>
                <option value="Manual">Manual</option>
                <option value="Computer">Computer</option>
               
            </select></div></th>
          </tr>
          <tr>
            <td><div id="summery"><select name="cmbsummerytype" id="cmbsummerytype" class="text_purchase3">
              <option value="All">All</option>
              <option value="Seperate">Seperate</option>
            
            </select></div></td>
            <td><div id="cashdis"><input type="checkbox" name="chk_cash" id="chk_cash" />Cash Dis</div><div id="svat"><input type="checkbox" name="chk_svat" id="chk_svat" />SVAT</div></td>
          </tr>
        </table></th>
      </tr>
    </table></td>
    <td width="128" rowspan="2" align="left"><table width="100" border="0">
      <tr>
        <th scope="col"><div id="rectype"><select name="cmbRECtype" id="cmbRECtype" class="text_purchase3">
          <option value="All">All</option>
          <option value="Normal">Normal</option>
          <option value="Ret.ch">Ret.ch</option>
        </select></div></th>
      </tr>
      <tr>
        <td><div id="chkrettype"><select name="cmbretchktype" id="cmbretchktype" class="text_purchase3">
          <option value="All">All</option>
          <option value="Cash">Cash</option>
          <option value="J/Entry">J/Entry</option>
          <option value="R/Deposit">R/Deposit</option>
          <option value="C/TT">C/TT</option>
          
        </select></div></td>
      </tr>
    </table></td>
    <td width="76" align="left"><input type="checkbox" name="chk_discount" id="chk_discount" />
          Discount</td>
  </tr>
  <tr>
    <td align="left"><input type="text" name="txt_disper" id="txt_disper" class="text_purchase3"/></td>
  </tr>
  <tr>
    <td colspan="4" align="left"><fieldset><table width="821" border="0">
      <tr>
        <th width="147" scope="col"><input type="radio" name="radio2" id="optdaily" value="optdaily" checked="checked"  />
          Daily</th>
        <th width="59" scope="col">&nbsp;</th>
        <th width="84" scope="col">&nbsp;</th>
        <th width="144" scope="col">&nbsp;</th>
        <th width="162" scope="col"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></th>
        <th colspan="2" scope="col"><select name="cmbrep" id="cmbrep" onkeypress="keyset('dte_dor',event);" onchange="custno('cash_rec_rep');" class="text_purchase3">
        	<option value="All">All</option>
            <?php
																	$sql="select * from s_salrep order by REPCODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
        </select></th>
      </tr>
      <tr>
        <td><input type="radio" name="radio2" id="optperiod" value="optperiod" />
          For Given Period</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
        <td colspan="2"><select name="CmbBrand" id="CmbBrand" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="setord();">
        <option value="All">All</option> 
            <?php
																	$sql="select * from brand_mas order by barnd_name";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
                       												}
																?>
        </select></td>
      </tr>
      <tr>
        <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
        <td colspan="2"><input type="text" size="20" name="dtfrom" id="dtfrom" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtfrom')" class="text_purchase3"/></td>
        <td><div id="dateto_name"><input type="text"  class="label_purchase" value="To" disabled="disabled"/></div></td>
        <td><div id="dateto"><input type="text" size="20" name="dtto" id="dtto" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtto')" class="text_purchase3"/></div></td>
        <td width="109"></td>
        <td width="86">&nbsp;</td>
      </tr>
    </table></fieldset></td>
    </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="392" align="left">&nbsp;</td>
    <td width="314" align="left"></td>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="392" align="left"></td>
    <td><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
  </tr>
</table>
<fieldset>               
            
 
</form>        

   
            
          