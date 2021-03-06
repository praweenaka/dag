<?php 
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();
						 
	require_once("connectioni.php");
	
						
 
?>	

					 
	
    <!-- Tab -->
<link rel="stylesheet" type="text/css" href="css/tabcontent.css" />
<link rel="stylesheet" href="css/table_min.css" type="text/css"/>	
<script type="text/javascript" src="js/tabcontent.js">

/***********************************************
* Tab Content script v2.2- � Dynamic Drive DHTML code library (www.dynamicdrive.com)
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

	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>


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
  <div class="text_forheader">Enter Customer Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%"><input type="text"  class="label_purchase" value="Customer Code" disabled/></td>
    <td width="10%"><input type="text" name="txt_cuscode" id="txt_cuscode" value="" class="text_purchase" onblur="custno_ind('cust_mast');"onkeypress="keyset('txtCNAME',event);"   />
      <a href="serach_customer.php?stname=cust_mast" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchinv2" id="searchinv2" value="..." class="btn_purchase1" >
      </a></td>

     <td width="38%"><select name="cmbcat" id="cmbcat" onkeypress="keyset('txtDESCRIPTION',event);" onchange="set_cus_no();" class="text_purchase3"  style="visibility:hidden;">
      <option value=''></option>
      <option value='A'>A</option>
      <option value='B'>B</option>
      <option value='C'>C</option>
      <option value='D'>D</option>
      <option value='E'>E</option>
      <option value='F'>F</option>
      <option value='G'>G</option>
      <option value='H'>H</option>
      <option value='I'>I</option>
      <option value='J'>J</option>
      <option value='K'>K</option>
      <option value='L'>L</option>
      <option value='M'>M</option>
      <option value='N'>N</option>
      <option value='O'>O</option>
      <option value='P'>P</option>
      <option value='Q'>Q</option>
      <option value='R'>R</option>
      <option value='S'>S</option>
      <option value='T'>T</option>
      <option value='U'>U</option>
      <option value='V'>V</option>
      <option value='W'>W</option>
      <option value='X'>X</option>
      <option value='Y'>Y</option>
      <option value='Z'>Z</option>
    </select></td>
    <td width="14%"><input type="text"  class="label_purchase" value="Contact Person" disabled="disabled"/></td>
    <td width="20%"><input type="text" class="text_purchase3" name="txtcper" id="txtcper" onkeypress="keyset('txtACCno',event);"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Name" disabled/></td>
    <td colspan="2"><input type="text" class="text_purchase3" name="txtCNAME" id="txtCNAME" onkeypress="keyset('txtBADD1',event);"/></td>
    <td width="14%"><input type="text"  class="label_purchase" value="Agreement No" disabled="disabled"/></td>
    <td width="20%"><input type="text" class="text_purchase3" name="txtACCno" id="txtACCno" onkeypress="keyset('txtvatno',event);"/></td>
    <td width="7%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address 1" disabled="disabled"/></td>
    <td colspan="2"><input type="text" class="text_purchase3" name="txtBADD1" id="txtBADD1" onkeypress="keyset('txtBADD2',event);"/></td>
    <td><input type="text"  class="label_purchase" value="General Credit Limit" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtcrlimt" id="txtcrlimt" onkeypress="keyset('txtbal',event);"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address 2" disabled="disabled"/></td>
    <td colspan="2"><input type="text" class="text_purchase3" name="txtBADD2" id="txtBADD2" onkeypress="keyset('txtTEL',event);"/></td>
    <td><input type="text"  class="label_purchase" value="Outstanding Balance" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtbal" id="txtbal" onkeypress="keyset('txtover',event);"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Telephone" disabled="disabled"/></td>
    <td colspan="2"><input type="text" class="text_purchase3" name="txtTEL" id="txtTEL" onkeypress="keyset('txttel2',event);"/></td>
    <td><input type="text"  class="label_purchase" value="Overdue" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtover" id="txtover" onkeypress="keyset('txtvatno',event);"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><input type="text" class="text_purchase3" name="txttel2" id="txttel2" onkeypress="keyset('txtFAX',event);"/></td>
    <td><input type="text"  class="label_purchase" value="VAT No" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtvatno" id="txtvatno" onkeypress="keyset('SVAT',event);"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Fax" disabled="disabled"/></td>
    <td colspan="2"><input type="text" class="text_purchase3" name="txtFAX" id="txtFAX" onkeypress="keyset('TXTEMAIL',event);"/></td>
    <td><input type="text"  class="label_purchase" value="SVAT No" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="SVAT" id="SVAT" onkeypress="keyset('txtcat',event);"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="E Mail" disabled="disabled"/></td>
    <td colspan="2"><input type="text" class="text_purchase3" name="TXTEMAIL" id="TXTEMAIL" onkeypress="keyset('gr_type',event);"/></td>
    <td><input type="text"  class="label_purchase" value="Category" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtcat" id="txtcat" onkeypress="keyset('txttype',event);"/></td>
    <td>&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Remark" disabled="disabled"/></td>
    <td colspan="2"><textarea name="remark" id="remark" cols="70" rows="5"></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
   <tr>
 
   
   
    <td><input type="text"  class="label_purchase" value="District" disabled="disabled"/></td>
    <td>
	<select name="txtdistrict" id="txtdistrict"  class="text_purchase3" onchange="keyset('gr_type',event);" >
	<option value='-'>-</option>
<option value='Ampara'>Ampara</option>
<option value='Anuradhapura'>Anuradhapura</option>
<option value='Badulla'>Badulla</option>
<option value='Batticaloa'>Batticaloa</option>
<option value='Colombo'>Colombo</option>
<option value='Galle'>Galle</option>
<option value='Gampaha'>Gampaha</option>
<option value='Hambantota'>Hambantota</option>
<option value='Jaffna'>Jaffna</option>
<option value='Kalutara'>Kalutara</option>
<option value='Kandy'>Kandy</option>
<option value='Kegalle'>Kegalle</option>
<option value='Kilinochchi'>Kilinochchi</option>
<option value='Kurunegala'>Kurunegala</option>
<option value='Mannar'>Mannar</option>
<option value='Matale'>Matale</option>
<option value='Matara'>Matara</option>
<option value='Moneragala'>Moneragala</option>
<option value='Mullaitivu'>Mullaitivu</option>
<option value='Nuwara Eliya'>Nuwara Eliya</option>
<option value='Polonnaruwa'>Polonnaruwa</option>
<option value='Puttalam'>Puttalam</option>
<option value='Ratnapura'>Ratnapura</option>
<option value='Trincomalee'>Trincomalee</option>
<option value='Vavuniya'>Vavuniya</option>


	
	 </select>
	</td>
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
 
   
   
    <td><input type="text"  class="label_purchase" value="Province" disabled="disabled"/></td>
    <td>
	<select name="txtprovince" id="txtprovince"  class="text_purchase3" onchange="keyset('gr_type',event);" >
<option value='-'>-</option>	
<option value='Northern'>Northern</option>
<option value='North Western'>North Western</option>
<option value='North Central'>North Central</option>
<option value='Western'>Western</option>
<option value='Central'>Central</option> 
<option value='Sabaragamuwa'>Sabaragamuwa</option>
<option value='Eastern'>Eastern</option>
<option value='Uva'>Uva</option>
<option value='Southern'>Southern</option>
  
	
	 </select>
	</td>
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
    <td><input type="text"  class="label_purchase" value="VAT Group" disabled="disabled"/></td>
    <td><select name="txtvatgroup" id="txtvatgroup"  class="text_purchase3" onchange="keyset('gr_type',event);" >
               
                        	<option value=''></option>
                            <option value='PRIVATE'>PRIVATE</option>
                            <option value='GOVVAT'>GOV VAT</option>
                            <option value='GOVNON'>GOV. NON VAT</option>
                       		 
															
                </select></td>
    <td>&nbsp;</td>
    <td><input type="text"  class="label_purchase" value="Type" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txttype" id="txttype" onkeypress="keyset('txtarea',event);"/>
	
	
	
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" rowspan="9" align="left" valign="top"><table border="0">
      <tr>
        <th width="100" scope="col"><input type="text"  class="label_purchase" value="Guarentee ID" disabled="disabled"/></th>
        <th width="160" scope="col"><input type="text"  class="label_purchase" value="Guarentee Type" disabled="disabled"/></th>
        <th width="144" scope="col"><input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></th>
        <th width="144" scope="col"><input type="text"  class="label_purchase" value="Exp Date" disabled="disabled"/></th>
        <th width="144" scope="col"><input type="text"  class="label_purchase" value="Bank" disabled="disabled"/></th>
        <th width="10" scope="col"><input type="text"  class="label_purchase" value="Status" disabled="disabled"/></th>
        <th width="28" scope="col">&nbsp;</th>
      </tr>
      <tr>
        <th scope="col"><input type="text" class="text_purchase3" name="gr_id" id="gr_id" onkeypress="keyset('gr_date',event);"/></th>
        <th scope="col"><select name="gr_type" id="gr_type"  class="text_purchase3" onchange="keyset('gr_type',event);" >
               
                        	<option value=''></option>
                            <option value='BANK'>BANK</option>
                            <option value='CASH'>CASH</option>
                            <option value='LIMIT'>LIMIT</option>
                       		 
															
                </select></th>
        <th scope="col"><input type="text" class="text_purchase3" name="gr_amount" id="gr_amount" onkeypress="keyset('gr_date',event);"/></th>
        <th scope="col"><input type="text" class="text_purchase3" name="gr_date" id="gr_date" onfocus="load_calader('gr_date')" onkeypress="keyset('gr_status',event);"/></th>
        <th scope="col"><input type="text" class="text_purchase3" name="gr_bank" id="gr_bank" onfocus="load_calader('gr_date')" onkeypress="keyset('gr_status',event);"/></th>
        <th scope="col"><input type="checkbox" name="gr_status" id="gr_status" /></th>
        <th scope="col">
          <input type="button" name="add_gr" id="add_gr" value="..." onclick="add_gr1();" class="btn_purchase1" />        </th>
      </tr>
      <tr>
        <td colspan="7"> <div class="CSSTableGenerator" id="grdetails" style="overflow:scroll;  height:100px">
<table>
                                                        			<tr>
                              											<td background="images/headingbg.gif" ><font color="#FFFFFF">Guarentee Type</font></td>
                              											<td  background="images/headingbg.gif"><font color="#FFFFFF">Amount</font></td>
                              											<td background="images/headingbg.gif"><font color="#FFFFFF">Exp Date</font></td>
                              											<td  background="images/headingbg.gif"><font color="#FFFFFF">Status</font></td>
                           											</tr>
                   												</table>   </div>  </td>
        </tr>
    </table></td>
    <td><input type="text"  class="label_purchase" value="Town" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtarea" id="txtarea" onkeypress="keyset('txtInc',event);"/></td>
    <td>&nbsp;</td>
    <td><input type="hidden"  class="label_purchase" value="App. Date" disabled="disabled"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Incentive Days" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txtInc" id="txtInc" onkeypress="keyset('TXT_REP',event);"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Rep" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="TXT_REP" id="TXT_REP" onkeypress="keyset('txtarea',event);"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Sales Category" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txt_scat" id="txt_scat" onkeypress="keyset('txtarea',event);"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Comman Code" disabled="disabled"/></td>
    <td><input type="text" class="text_purchase3" name="txt_commcode" id="txt_commcode" onkeypress="keyset('txtarea',event);"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Dealer Signature" disabled="disabled"/></td>
    <td colspan="2"><input type="button"  class="sell_search1" name="idcopy" id="idcopy" value="Upload Image 1" onClick="NewWindow('upload_image.php?cou=image1','mywin','700','200','yes','center');return false" />
      <input type="button"  class="sell_search1" name="idcopy2" id="idcopy2" value="Display Image 1" onclick="NewWindow1('display_image.php?cou=image1','mywin','900','800','yes','center');return false" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="ID Copy" disabled="disabled"/></td>
    <td colspan="2"><input type="button"  class="sell_search1" name="idcopy3" id="idcopy3" value="Upload Image 2" onclick="NewWindow('upload_image.php?cou=image2','mywin','700','200','yes','center');return false" />
      <input type="button"  class="sell_search1" name="idcopy4" id="idcopy4" value="Display Image 2" onclick="NewWindow1('display_image.php?cou=image2','mywin','900','800','yes','center');return false" /></td>
    <td><input type="hidden" size="20" name="DTOPDATE" id="DTOPDATE" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('DTOPDATE')" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="BR Copy" disabled="disabled"/></td>
    <td colspan="2"><input type="button"  class="sell_search1" name="idcopy5" id="idcopy5" value="Upload Image 3" onclick="NewWindow('upload_image.php?cou=image3','mywin','700','200','yes','center');return false" />
      <input type="button"  class="sell_search1" name="idcopy6" id="idcopy6" value="Display Image 3" onclick="NewWindow1('display_image.php?cou=image3','mywin','900','800','yes','center');return false" /></td>
    <td><input type="hidden"  class="label_purchase" value="Bank Guarentee Expire Date" disabled="disabled"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td><input type="hidden" size="20" name="DTbankgrdate" id="DTbankgrdate" value="" onfocus="load_calader('DTbankgrdate')" class="text_purchase3"/>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7">&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7">
    
    
  <ul id="countrytabs" class="shadetabs">	
	<li><a href="#" rel="country1" class="selected">Credit Limit</a></li>
	<li><a href="#" rel="country2">Note</a></li>
	<li><a href="#" rel="country3">Message</a></li>
	<li><a href="#" rel="country4">Ignore Credit Limit - Return Cheque</a></li>
  </ul>
    
    
    <div style="border:1px solid gray; width:800px; margin-bottom: 1em; padding: 10px">

<div id="country1" class="tabcontent">
	<!-- Tab 1  -->
    <p>
              <input type="checkbox" name="check1" id="check1" onclick="stopinvcing();" />
              Stop Invoicing          </p>
      
       <div id="creditlim" class="CSSTableGenerator"> <table width="300" border="1" cellspacing="0">
        <tr>
          <td background="images/headingbg.gif" height="25">Credit Limit</td>
          <td background="images/headingbg.gif">Sales Rep</td>
          <td background="images/headingbg.gif">Outstanding</td>
          <td background="images/headingbg.gif">Balance</td>
          <td background="images/headingbg.gif">Cat</td>
          <td background="images/headingbg.gif">Type</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
       
      </table></div>
            <br />
		<ul id="countrytabs1" class="shadetabs">
        	
			<li><a href="#" rel="subcountry1" class="selected">Credit Limit</a></li>
			<li><a href="#" rel="subcountry2">Tempory Credit Limit</a></li>
		</ul>
		<div style="border:1px solid gray; width:450px; margin-bottom: 1em; padding: 10px">
		<div id="subcountry1" class="tabcontent">
        	<!-- Tab 1 Sub1 -->
			<table>
            	<tr><td>Rep</td><td><select name="Com_rep" id="Com_rep"  class="text_purchase3" onchange="sellimit();" >
               
                    <?php
                    require_once("connectioni.php");
                    if ($_SESSION["MANAGER"]!="") {
                        echo "<option value='All'>All</option>";			 						
                        $sql="select * from s_salrep where cancel='1' and manager='".$_SESSION["MANAGER"]."'order by REPCODE"; 
                        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                        while($row = mysqli_fetch_array($result)){
                            echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                        }
                     }else if ($_SESSION["CURRENT_REP"]=="") {

                        echo "<option value='All'>All</option>";			 						
                        $sql="select * from s_salrep where cancel='1' order by REPCODE";
                        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                        while($row = mysqli_fetch_array($result)){
                            echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                        }
                     } else {
                         $sql="select * from s_salrep where cancel='1' and repcode = '" . $_SESSION["CURRENT_REP"] ."' order by REPCODE";
                         $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                         while($row = mysqli_fetch_array($result)){
                         echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                         }
                     }
					?>			 
															
                </select></td><td>Brand</td><td>
                <select name="cmbbrand" id="cmbbrand" class="text_purchase3" onchange="sellimit();">
                <?php
						$sql="select class from brand_mas where act='1' group by class";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
						while($row = mysqli_fetch_array($result)){
                        	echo "<option value='".$row["class"]."'>".$row["class"]."</option>";
						}	
                ?>			 
                </select></td></tr>
                <tr><td>Cr. Limit</td><td><input type="text" name="txtlimit" id="txtlimit"  class="text_purchase3"/></td>
                
                <td>Cat</td><td><select name="cmbCAt" id="cmbCAt"  class="text_purchase3">
                				<option value=''></option>
                                <option value='A'>A</option>
                                <option value='B'>B</option>
                                <option value='C'>C</option>
                                <option value='D'>D</option>
                                <option value='E'>E</option>
                                
                                </select></td></tr>
								<tr><td>Days</td> <td><input type="text" name="days" id="days"  class="text_purchase3"/></td></tr>	
            </table><br />
            
            <input type="button" name="delete" id="delete" value="Delete" onClick="delete_limit('<?php echo $doc_mod; ?>');" />
            <input type="button" name="update" id="update" value="Update" onClick="update_limit('<?php echo $doc_mod; ?>');" />
		</div>

		<div id="subcountry2" class="tabcontent">
			<table>
            	<tr><td>Rep</td><td><select name="Com_rep1" id="Com_rep1"  class="text_purchase3">
               
                    <?php
			 require_once("connectioni.php");
                    if ($_SESSION["MANAGER"]!="") {
                        echo "<option value='All'>All</option>";			 						
                        $sql="select * from s_salrep where cancel='1' and manager='".$_SESSION["MANAGER"]."'order by REPCODE"; 
                        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                        while($row = mysqli_fetch_array($result)){
                            echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                        }
                     }else if ($_SESSION["CURRENT_REP"]=="") {

                        echo "<option value='All'>All</option>";			 						
                        $sql="select * from s_salrep where cancel='1' order by REPCODE";
                        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                        while($row = mysqli_fetch_array($result)){
                            echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                        }
                     } else {
                         $sql="select * from s_salrep where cancel='1' and repcode = '" . $_SESSION["CURRENT_REP"] ."' order by REPCODE";
                         $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                         while($row = mysqli_fetch_array($result)){
                         echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                         }
                     }
					?>			 
															
                </select></td></tr>
                <tr><td>Brand</td><td>
                <select name="cmbbrand1" id="cmbbrand1" class="text_purchase3">
                <?php
						$sql="select class from brand_mas where act='1' group by class";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
						while($row = mysqli_fetch_array($result)){
                        	echo "<option value='".$row["class"]."'>".$row["class"]."</option>";
						}	
                ?>			 
                </select></td></tr>
                <tr><td>Tempory Cr. Increment</td><td><input type="text" name="txt_templimit" id="txt_templimit"  class="text_purchase3"/></td></tr>
                <tr><td>Brand Wise Limit</td><td><input type="text" name="txtbrandrepiselimit" id="txtbrandrepiselimit"  class="text_purchase3"/></td></tr>
                <tr><td>Balance</td><td><input type="text" name="txtoutbal" id="txtoutbal"  class="text_purchase3"/></td></tr>
            </table><br />
            <input type="button" name="tmp_limit" id="tmp_limit" value="Tmp. Limit Update" onClick="tmp_crelimit();" />
		</div>
		</div>
    	
        <div id="info_table" class="CSSTableGenerator"> <table width="200" border="1" cellspacing="0">
        <tr>
          <td background="images/headingbg.gif" height="25">Info Type</td>
          <td background="images/headingbg.gif">Amount</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
       
      </table></div>
    	<script type="text/javascript">

		var countries=new ddtabcontent("countrytabs1")
		countries.setpersist(true)
		countries.setselectedClassTarget("link") //"link" or "linkparent"
		countries.init()

		</script>

<br />
</div>

<div id="country2" class="tabcontent">
<table><tr><td>
Note Pad</td>
<td> <textarea name="txtnote" id="txtnote" cols="45" rows="5" ></textarea>              </td></tr>
<br />
<tr><td>New Note</td><td>
<textarea name="txt_new" id="txt_new" cols="45" rows="5"></textarea></td></tr></table>
<input type="button" name="update" id="update" value="Update" onClick="note_update();" />
</div>

<div id="country3" class="tabcontent">
<textarea name="txtMsg" id="txtMsg" cols="45" rows="5"></textarea><br />
</div>

<div id="country4" class="tabcontent">
Approved only for <input type="text" name="DT_Over_DUE_IG" id="DT_Over_DUE_IG" value="<?php echo date("Y-m-d"); ?>" class="text_purchase1"/><input type="button" name="update" id="update" value="Update" onClick="app_only_for();" /><br />
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
    <td>&nbsp;</td>
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
    <td colspan="11">&nbsp;</td>
    </tr>
  
  <tr>
    <td colspan="10">&nbsp;</td>
    </tr>
  </table>

  
 
  <input type="hidden" name="chkgarant" id="chkgarant" />
  <fieldset>               
            
 
</form>        

   
            
          