<?php session_start();
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
	
	$_SESSION["MonthView1"]="";
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
.style1 {color: #FF0000; font-size: 18px}
.style2 {
	font-size: 18px
}
-->
</style>
<?php
		$_SESSION["CURRENT_DOC"] = "65";     //document ID
    //VIEW_DOC = True      '  view current document
     	$_SESSION["FEED_DOC"] = "true";      //   save  current document
    //MOD_DOC = True       '   delete   current document
    //PRINT_DOC = True     ' get additional print   of  current document
    //PRICE_EDIT=true      ' edit selling price
    	$_SESSION["CHECK_USER"] = "true";    // check user permission again

?>
<fieldset>
                                                	<legend>
  <div class="text_forheader">Credit Note Form</div>
                                               	 </legend>             

                                                 <input type="hidden" name="txt_stat" id="txt_stat" />
<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="14%"><input type="text"  class="label_purchase" value="Reference No" disabled="disabled"/></td>
    <td width="14%"><input type="text" disabled="disabled" name="txtrefno" id="txtrefno" value="" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('grnno');"  onblur="lost_focus('grnno');"  /></td>
    <td width="6%"><a onclick="NewWindow('serach_crn_appro.php?stname=crn_form_all','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust8" id="searchcust8" value="..."  class="btn_purchase1" />
    </a></td>
    <td width="14%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td width="15%"><input type="text" size="20" name="DTPicker1" id="DTPicker1" value="<?php echo date("Y-m-d"); ?>" disabled="disabled" class="text_purchase3"/>     </td>
    <td width="14%"></td>
    <?php
		require_once("config.inc.php");
		require_once("DBConnector.php");
		$db = new DBConnector();
		
		$checked="0";
		$auth="0";
		
		$sql = "select * from userpermission where username = '" . $_SESSION["CURRENT_USER"] . "' and docid = '66' and doc_view = '1' and doc_feed = '1'";
		$result =$db->RunQuery($sql);
		if($row = mysql_fetch_array($result)){
			$sql1 = "Select * from s_crnfrm where Lock1 = '0' and Checked != 'A' and Cancell = '0'";
			$result1 =$db->RunQuery($sql1);
			if($row1 = mysql_fetch_array($result1)){
				$checked="1";
			} else {
				$checked="0";
			}
			
			$sql1 = "Select * from s_crnfrm where Checked = 'A' and Cancell = '0' ";
			$result1 =$db->RunQuery($sql1);
			if($row1 = mysql_fetch_array($result1)){
				$auth="1";
			} else {
				$auth="0";
			}
		} else {
			$auth="0";
			$checked="0";
		}	
												
		
	?>
    <td colspan="3">
    <?php
		if ($checked=="1"){
    		echo "<a onclick=\"NewWindow('serach_crn_appro.php?stname=crn_form_check','mywin','800','700','yes','center');return false\" onfocus=\"this.blur()\">
      <input type=\"button\" name=\"searchcust2\" id=\"searchcust2\" value=\"Check List\"  class=\"btn_purchase1\" />
    </a>";
		}
		
		if ($auth=="1"){
			echo "<a onclick=\"NewWindow('serach_crn_appro.php?stname=crn_form_autho','mywin','800','700','yes','center');return false\" onfocus=\"this.blur()\">
    <input type=\"button\" name=\"searchcust4\" id=\"searchcust4\" value=\"Authorize List\"  class=\"btn_purchase1\" />
    </a>";
		}
		?>
	</td>
    </tr>
  
  
  <tr>
    <td><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td colspan="3"><select name="Com_rep" id="Com_rep" onkeypress="keyset('dte_dor',event);" class="text_purchase3">
      <?php
																	$sql="select * from s_salrep where cancel='0' order by REPCODE";
																	
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
    </select></td>
   <td><div id="lbllock"></div></td>
    <td>&nbsp;</td>
    <td colspan="3">
    <?php
		if ($checked=="1"){	
        	echo "<a onclick=\"NewWindow('autho.php?stname=crn_form','mywin','500','300','yes','center');return false\" onfocus=\"this.blur()\">
      <input type=\"button\" name=\"searchcust6\" id=\"searchcust6\" value=\"Check\"  class=\"btn_purchase1\" />
    </a>";
		}
		if ($auth=="1"){
			echo "<a onclick=\"NewWindow('autho.php?stname=crn_form_autho','mywin','500','300','yes','center');return false\" onfocus=\"this.blur()\">
    <input type=\"button\" name=\"searchcust7\" id=\"searchcust7\" value=\"Authorize\"  class=\"btn_purchase1\" />
    </a>";
		}
		?>
	</td>
    </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Customer" disabled/></td>
    <td colspan="3"><input type="text" disabled="disabled"  class="text_purchase1" name="txt_cuscode" id="txt_cuscode"/>
      <input type="text" disabled="disabled"  class="text_purchase2" id="txt_cusname" name="txt_cusname" />
     <a onClick="NewWindow('serach_supplier.php?stname=crn_form','mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase">
      </a></td>
    <td>
  <input type="text"  class="label_purchase" value="Month" disabled="disabled"/></td>
    <td><input type="text" name="MonthView1" id="MonthView1" class="text_purchase3" onfocus="load_calader('MonthView1')" onchange="set_session();"/></td>
    <td width="9%" colspan="3"><input type="button" name="searchcust5" id="searchcust5" value="Set Month"  class="btn_purchase1" onclick="set_month();" /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td width="9%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div class="style1" id="lock">
      <p class="style2"></p>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
<fieldset>               
            
   	<legend><div class="text_forheader">Invoice Details</div></legend>            
            
  <table width="84%" border="0">
  
  
  <tr>
    <td colspan="8"><a onclick="NewWindow('serach_inv_crn.php?stname=crn_form','mywin','800','700','yes','center');return false" onfocus="this.blur()">
          <input type="button" name="searchcust3" id="searchcust3" value="Select Invoice"  class="btn_purchase2" />
        </a></td>
  </tr>
  <tr>
	<td colspan="8">
    <div class="CSSTableGenerator" id="MSFlexGrid1" > <table>
                                                        			<tr>
                              											<td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Date</font></td>
                              											<td width="25%"  background="images/headingbg.gif"><font color="#FFFFFF">Invoice No</font></td>
                              											<td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Amount</font></td>
                              											<td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Qty</font></td>
                                                                        <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Incentive (%)</font></td>
                                                                        <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Incentive Val</font></td>
                                                                        <td width="10%"  background="images/headingbg.gif"><font color="#FFFFFF">Brand</font></td>
                           											</tr>
                   												</table>  </div>                                                 		</td>
                                                		</tr>
  
  <tr>
    <td width="15%">&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td width="18%">&nbsp;</td>
    <td width="16%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="hidden" name="mcou" id="mcou" value="0" /></td>
    <td><div id="storgrid"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <input type="text"  class="label_purchase" value="Total" disabled="disabled"/>
    </span></td>
    <td><input type="text" size="15" name="txttot" id="txttot" value="0" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
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
  <tr>
    <td colspan="7"><textarea name="txtremark" id="txtremark" cols="100" rows="4"></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
  <tr>
    <td><input type="text"  class="label_purchase" value="Check By" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase2" name="txt_check" id="txt_check"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Approved By" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase2" name="txt_auth" id="txt_auth"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase2" name="DTPicker2" onfocus="load_calader('DTPicker2')" id="DTPicker2"/>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase2" name="DTPicker5" id="DTPicker5" onfocus="load_calader('DTPicker5')"/>
      </td>
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