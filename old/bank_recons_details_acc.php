
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

					 
	
    <!-- Tab -->
<link rel="stylesheet" type="text/css" href="css/tabcontent.css" />
<link rel="stylesheet" href="css/table.css" type="text/css"/>	
<script type="text/javascript" src="js/tabcontent.js">

/***********************************************
* Tab Content script v2.2- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

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


function NewWindow1(mypage,myname,w,h,scroll,pos){

mypage=mypage+'&cus_id='+document.getElementById("txt_cuscode").value;

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
  <div class="text_forheader">Bank Reconsilation</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="14%"><input type="text"  class="label_purchase" value="Reconsilation Date" disabled/></td>
    <td width="14%"><input type="text" class="text_purchase3" name="dtpDate" id="dtpDate" onfocus="load_calader('dtpDate')"  value="<?php echo date("Y-m-d"); ?>"/>      </td>
    <td width="2%">&nbsp;</td>
    <td width="20%"><input type="text"  class="label_purchase" value="Balance as per Bank Statement" disabled="disabled"/></td>
    <td colspan="2"><input type="text" class="text_purchase3" name="txtBankClosBal" id="txtBankClosBal" onkeypress="keyset('txtTEL',event);"/></td>
    <td width="4%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Last Reconsilation Date" disabled/></td>
    <td><input type="text" class="text_purchase3" name="dtfrom" id="dtfrom" onfocus="load_calader('dtfrom')" onkeypress="keyset('gr_status',event);"/></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Bank" disabled="disabled"/></td>
    <td colspan="2"><select name="Com_CAS" id="Com_CAS"  class="text_purchase3" onchange="lastmonthcal();" >
      <option value=''></option>
      <?php
	  include('connection.php');
	  
	  	$sql="select * from bankmaster  order by bm_code ";
		$result=mysql_query($sql, $dbacc);
		while ($row = mysql_fetch_array($result)){
      		echo "<option value='".$row["bm_code"]."'>".$row["bm_bank"]."</option>";
    	}
		?>
	</select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="6">&nbsp;</td>
    <td width="4%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">
    
    
  <ul id="countrytabs" class="shadetabs">	
	<li><a href="#" rel="country1" class="selected">Reciepts</a></li>
	<li><a href="#" rel="country2">Payments</a></li>
  </ul>
    
    
    <div style="border:1px solid gray; width:1200px; margin-bottom: 1em; padding: 10px">

<div id="country1" class="tabcontent">
	<!-- Tab 1  -->
 
      
       <div id="flexDeb" class="CSSTableGenerator"> <table width="300" border="1" cellspacing="0">
         <tr>
          <td background="images/headingbg.gif" height="25">Ref No</td>
          <td background="images/headingbg.gif">Date</td>
          <td background="images/headingbg.gif">Cheque No</td>
          <td background="images/headingbg.gif">Name</td>
          <td background="images/headingbg.gif">Head</td>
          <td background="images/headingbg.gif">Amount</td>
          <td background="images/headingbg.gif">F</td>
          <td background="images/headingbg.gif">Description</td>
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
        </tr>
       
      </table></div>
</div>

<div id="country2" class="tabcontent">
<!-- Tab 2  -->
 
      
       <div id="flexCre" class="CSSTableGenerator"> <table width="300" border="1" cellspacing="0">
        <tr>
          <td background="images/headingbg.gif" height="25">Ref No</td>
          <td background="images/headingbg.gif">Date</td>
          <td background="images/headingbg.gif">Cheque No</td>
          <td background="images/headingbg.gif">Name</td>
          <td background="images/headingbg.gif">Head</td>
          <td background="images/headingbg.gif">Amount</td>
          <td background="images/headingbg.gif">F</td>
          <td background="images/headingbg.gif">Description</td>
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
        </tr>
       
      </table></div>
</div>

<div id="country3" class="tabcontent">
<textarea name="txtMsg" id="txtMsg" cols="45" rows="5"></textarea><br />
</div>

<div id="country4" class="tabcontent">
Approved only for <input type="text" name="DT_Over_DUE_IG" id="DT_Over_DUE_IG" class="text_purchase1"/><input type="button" name="update" id="update" value="Update" onClick="app_only_for();" /><br />
</div>
</div>

<script type="text/javascript">

var countries=new ddtabcontent("countrytabs")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

</script>    </td>
    <td colspan="3"> </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" rowspan="6">
    <fieldset><legend>Summerized Bank Account</legend>
    	
        <table border="0">
          <tr>
            <th width="284" scope="col"><input type="text"  class="label_purchase" value="Opening Bank Balance (Last Month End Balance)" disabled/></th>
            <th width="179" scope="col"><input type="text" class="text_purchase3" align="right" name="txt_bankbal" id="txt_bankbal"  onkeypress="keyset('gr_status',event);"/></th>
          </tr>
          <tr>
            <td><input type="text"  class="label_purchase" value="ADD- Total Amount Of Bank Deposit" disabled="disabled"/></td>
            <td><input type="text" class="text_purchase3" name="txtbankdepo" id="txtbankdepo" align="right"  onkeypress="keyset('gr_status',event);"/></td>
          </tr>
          <tr>
            <td><input type="text"  class="label_purchase" value="LESS- Total Amount Of Bank Payment" disabled="disabled"/></td>
            <td><input type="text" class="text_purchase3" name="txtbankpay" id="txtbankpay"  align="right" onkeypress="keyset('gr_status',event);"/></td>
          </tr>
          <tr>
            <td><input type="text"  class="label_purchase" value="Closing Balance As At " disabled="disabled"/></td>
            <td><input type="text" class="text_purchase3" name="txtclosebal" id="txtclosebal"  align="right" onkeypress="keyset('gr_status',event);"/></td>
          </tr>
        </table>
    </fieldset>    </td>
    <td colspan="2">&nbsp;</td>
    <td rowspan="6">&nbsp;</td>
    <td rowspan="6">&nbsp;</td>
    <td rowspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td width="26%"><input type="text"  class="label_purchase" value="Balance As Per Cash Book" disabled="disabled"/></td>
    <td width="20%"><input type="text" class="text_purchase3" name="txttot" id="txttot"  align="right" onkeypress="keyset('gr_status',event);"/></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Actual Balance" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtFinalBal" id="txtFinalBal"  align="right" onkeypress="keyset('gr_status',event);"/></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
    </tr>
  
  <tr>
    <td colspan="9">&nbsp;</td>
    </tr>
  </table>

  
 
  <input type="hidden" name="chkgarant" id="chkgarant" />
  <fieldset>               
            
 
</form>        

   
            
          