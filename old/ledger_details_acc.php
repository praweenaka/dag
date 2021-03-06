
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


 <!-- Dynamic List area -->
    
    <script type="text/javascript" src="ajax-dynamic-list.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="ajax.js"></script>





  	
    <style type="text/css">
 	/* Big box with list of options */
	#ajax_listOfOptions{
		position:absolute;	/* Never change this one */
		width:175px;	/* Width of box */
		height:250px;	/* Height of box */
		overflow:auto;	/* Scrolling features */
		border:1px solid #317082;	/* Dark green border */
		background-color:#FFF;	/* White background color */
		text-align:left;
		font-size:0.9em;
		z-index:100;
	}
	#ajax_listOfOptions div{	/* General rule for both .optionDiv and .optionDivSelected */
		margin:1px;		
		padding:1px;
		cursor:pointer;
		font-size:0.9em;
	}
	#ajax_listOfOptions .optionDiv{	/* Div for each item in list */
		
	}
	#ajax_listOfOptions .optionDivSelected{ /* Selected item in the list */
		background-color:#317082;
		color:#FFF;
	}
	#ajax_listOfOptions_iframe{
		background-color:#F00;
		position:absolute;
		z-index:5;
	}
	
	form{
		display:inline;
	}

	#article {font: 12pt Verdana, geneva, arial, sans-serif;  background: white; color: black; padding: 10pt 15pt 0 5pt}
    .style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
    </style>   

<!-- End of Dynamic list area -->
</label>
          
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
<fieldset>
                                                	<legend>
  <div class="text_forheader">Enter Ledger Accounts Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="9%"><input type="text"  class="label_purchase" value="Account Code" disabled/></td>
    <td width="15%"><input type="text" name="txtAccCode" id="txtAccCode" value="" class="text_purchase" onKeyPress="keyset('txtDESCRIPTION', event);" onblur="itemno_ind(); "   />
      <a href="search_ledger_acc.php?stname=ledger_sel" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchinv2" id="searchinv2" value="..." class="btn_purchase1" >
      </a></td>
    <td width="8%"><select name="cmbLetter" id="cmbLetter" onchange="keyset_chng();" onkeypress="keyset('txtmodel',event);" class="text_purchase3" >
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
    <td colspan="3"><input type="radio" name="acc_type" id="acc_type1" value="radio" checked="checked" onclick="set_accno();" />
      Main Account <input type="radio" name="acc_type" id="acc_type2" value="radio" onclick="set_accno();"/>
      Sub Account</td>
    <td width="3%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Account Name" disabled/></td>
    <td colspan="3"><input id="txtAccName" name="txtAccName" type="text" onkeypress="keyset('txtGEN_NO',event);" class="text_purchase3" /></td>
    <td colspan="2">    	   </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Address" disabled="disabled"/></td>
    <td colspan="3"><input id="txtAdd1" name="txtAdd1" type="text" onkeypress="keyset('txtGEN_NO',event);" class="text_purchase3" /></td>
    <td colspan="2"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><input id="txtAdd2" name="txtAdd2" type="text" onkeypress="keyset('txtGEN_NO',event);" class="text_purchase3" /></td>
    <td colspan="2"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="5"><fieldset>
        	<legend><strong>Account Type</strong></legend>
            
    
    
    <table border="0">
      <tr>
        <th width="139" scope="col"><input type="radio" name="radio" id="op_manu" value="op_manu" checked="checked" />
    Manufacturing</th>
        <th width="183" scope="col"><input type="radio" name="radio" id="optPLAcc" value="optPLAcc" />
    PNL Account</th>
        <th width="272" scope="col"><input type="radio" name="radio" id="optBal" value="optBal" />
    Balance Sheet Account</th>
      </tr>
    </table>
    </fieldset></td>
    <td width="35%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="5"><fieldset>
       	
           <input type="checkbox" name="Check1" id="Check1" /> Cash Book Account
    <input type="checkbox" name="Check2" id="Check2" />
    Bank Account
    </fieldset> </td>
    <td colspan="4"> </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td width="-1%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9"><table width="954" border="0">
      <tr>
        <th width="16%" scope="col"><input type="text"  class="label_purchase" value="Opening Balance" disabled="disabled"/></th>
        <th width="17%" scope="col"><input type="text" class="text_purchase3"  id="txtOpenBal" name="txtOpenBal" onkeypress="keyset('txtMARGIN',event);"/></th>
        <th width="22%" scope="col"><input type="text"  class="label_purchase" value="Parent Account" disabled="disabled"/></th>
        <th width="16%" scope="col"><a href="search_ledger_acc.php?stname=ledger" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
          <input type="button" name="searchinv" id="searchinv" value="..." class="btn_purchase1" />
        </a></th>
        <th width="16%" scope="col"><input type="text" class="text_purchase3"  id="txtLinkNo" name="txtLinkNo" onkeypress="keyset('txtSELLING',event);"/></th>
        <th width="13%" scope="col">&nbsp;</th>
      </tr>
      <tr>
        <th width="16%" scope="col"><input type="text"  class="label_purchase" value="Opening Date" disabled="disabled"/></th>
        <th scope="col"><input type="text" class="text_purchase3"  id="dtpOpenDate" name="dtpOpenDate" onkeypress="keyset('txtSIZE',event);"/></th>
        <th width="22%" scope="col">&nbsp;</th>
        <th scope="col"><input type="text" class="text_purchase3"  id="txtcode" name="txtcode" onkeypress="keyset('txtRE_O_LEVEL',event);"/></th>
        <th width="16%" scope="col"><input type="text" class="text_purchase3"  id="txtOpenBal1" name="txtOpenBal1" onkeypress="keyset('txtRE_O_qty',event);"/></th>
        <th scope="col">&nbsp;</th>
      </tr>
    </table></td>
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
    <td colspan="9"><fieldset>
        	<legend><strong>Budget</strong></legend>
            
            <table border="0">
              <tr>
                <th scope="col"><input type="text"  class="label_purchase" value="January" disabled="disabled"/></th>
                <th scope="col"><input type="text" class="text_purchase3"  id="jan" name="jan" onkeypress="keyset('txtSIZE',event);"/></th>
                <th scope="col"><input type="text"  class="label_purchase" value="July" disabled="disabled"/></th>
                <th scope="col"><input type="text" class="text_purchase3"  id="jul" name="jul" onkeypress="keyset('txtSIZE',event);"/></th>
              </tr>
              <tr>
                <td><input type="text"  class="label_purchase" value="February" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="feb" name="feb" onkeypress="keyset('txtSIZE',event);"/></td>
                <td><input type="text"  class="label_purchase" value="Augest" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="aug" name="aug" onkeypress="keyset('txtSIZE',event);"/></td>
              </tr>
              <tr>
                <td><input type="text"  class="label_purchase" value="March" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="mar" name="mar" onkeypress="keyset('txtSIZE',event);"/></td>
                <td><input type="text"  class="label_purchase" value="September" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="sep" name="sep" onkeypress="keyset('txtSIZE',event);"/></td>
              </tr>
              <tr>
                <td><input type="text"  class="label_purchase" value="April" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="apr" name="apr" onkeypress="keyset('txtSIZE',event);"/></td>
                <td><input type="text"  class="label_purchase" value="October" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="oct" name="oct" onkeypress="keyset('txtSIZE',event);"/></td>
              </tr>
              <tr>
                <td><input type="text"  class="label_purchase" value="May" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="may" name="may" onkeypress="keyset('txtSIZE',event);"/></td>
                <td><input type="text"  class="label_purchase" value="November" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="nov" name="nov" onkeypress="keyset('txtSIZE',event);"/></td>
              </tr>
              <tr>
                <td><input type="text"  class="label_purchase" value="June" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="jun" name="jun" onkeypress="keyset('txtSIZE',event);"/></td>
                <td><input type="text"  class="label_purchase" value="December" disabled="disabled"/></td>
                <td><input type="text" class="text_purchase3"  id="dec" name="dec" onkeypress="keyset('txtSIZE',event);"/></td>
              </tr>
            </table>
    </fieldset></td>
    </tr>
  

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
 
  <fieldset>               
            
 
</form>        

   
            
          