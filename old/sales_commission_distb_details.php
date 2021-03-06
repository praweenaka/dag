
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

						 
	



<link rel="stylesheet" href="css/table_min.css" type="text/css"/>	
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
			target:"dte_dor",
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

</label><fieldset>
                                                	<legend>
  <div class="text_forheader">Balance Commission - Distribution</div>
                                               	 </legend>             

<form name="form1" id="form1">  
 <table border="1"><tr><td width="1301">         
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="10%"><input type="hidden" name="txt_stat" id="txt_stats" /></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><input type="text" disabled="disabled" name="dttmpda" id="dttmpda" value="<?php echo "2011-04-29"; ?>" class="text_purchase3" onkeypress="keyset('searchcust',event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Month" disabled="disabled"/></td>
    <td>
    <input type="text" name="dtMonth" id="dtMonth" class="text_purchase3"/>
        <script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dtMonth",
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
    <td> <a href="serach_rec.php?stname=cash_rec" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></td>
    <td><input type="text"  class="label_purchase" value="Sales Excecutive" disabled="disabled"/></td>
    <td><select name="cmbrep" id="cmbrep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
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
    </select></td>
    <td><select name="cmbdev" id="cmbdev" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="setord();">
     <?php
				if ($_SESSION['dev']=="1"){
            		echo "<option value=\"0\">Office Sale</option>
                		<option value=\"1\">Van Sale</option>";
				} else if ($_SESSION['dev']=="0"){
            		echo "<option value=\"0\">Office Sale</option>";
				}				
             ?>  
    </select></td>
    <td><input type="text"  class="label_purchase" value="Vat Rate" disabled="disabled"/></td>
    <td><a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text" name="txtvat" id="txtvat" value="11" class="text_purchase3"   />
    </a></td>
    <td> <a href="serach_customer.php?stname=ret_chq_settle" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></td>
  </tr>
  </table>

  
  <br/>   
 


  





<fieldset>               
     <legend><div class="text_forheader">Sales Commission Advance</div></legend>
   <fieldset> 
   <legend><div class="text_forheader">Batteries</div></legend>
   <table><tr>
     <td width="446"><table width="446" border="0">
       <tr>
         <td width="144"></th>
         <td width="144">
           <input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></td>
         <td width="144">
           <input type="text"  class="label_purchase" value="Sales" disabled="disabled"/>  </td>         </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Tar 1" disabled="disabled" id="Critaria_gridA10" name="Critaria_gridA01"/></td>
         <td><input type="text" size="20" name="Critaria_gridA11" id="Critaria_gridA11" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Critaria_gridA12" id="Critaria_gridA12" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Tar 2" disabled="disabled" id="Critaria_gridA20" name="Critaria_gridA02"/></td>
         <td><input type="text" size="20" name="Critaria_gridA21" id="Critaria_gridA21" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Critaria_gridA22" id="Critaria_gridA22" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Base" disabled="disabled" id="Critaria_gridA30" name="Critaria_gridA03" /></td>
         <td><input type="text" size="20" name="Critaria_gridA31" id="Critaria_gridA31" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Critaria_gridA32" id="Critaria_gridA32" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
     </table></td>
     <td width="34">&nbsp;</td>
     <td width="801">&nbsp;<table width="594" border="0">
       <tr>
         <th width="144" scope="col">&nbsp;</th>
         <th width="144" scope="col"><input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></th>
         <th width="144" scope="col"><input type="text"  class="label_purchase" value="Tot Comm" disabled="disabled"/></th>
         <th width="144" scope="col"><input type="text"  class="label_purchase" value="Advance" disabled="disabled"/></th>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Sales" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Sales_gridA11" id="Sales_gridA11" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridA12" id="Sales_gridA12" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridA13" id="Sales_gridA13" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="GRN" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Sales_gridA21" id="Sales_gridA21" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridA22" id="Sales_gridA22" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridA23" id="Sales_gridA23" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="CRN" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Sales_gridA31" id="Sales_gridA31" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridA32" id="Sales_gridA32" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridA33" id="Sales_gridA33" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Net" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Sales_gridA41" id="Sales_gridA41" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridA42" id="Sales_gridA42" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridA43" id="Sales_gridA43" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
     </table></td></tr></table>
   </fieldset>
   <br />
      <fieldset> 
   <legend><div class="text_forheader">Tyres & A/Wheels</div></legend>
   <table><tr>
     <td width="446"><table width="446" border="0">
       <tr>
         <td width="144"></th>
         <td width="144">
           <input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></td>
         <td width="144">
           <input type="text"  class="label_purchase" value="Sales" disabled="disabled"/>  </td>         </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Tar 1" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Critaria_gridB11" id="Critaria_gridB11" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Critaria_gridB12" id="Critaria_gridB12" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Tar 2" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Critaria_gridB21" id="Critaria_gridB21" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Critaria_gridB22" id="Critaria_gridB22" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Base" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Critaria_gridB31" id="Critaria_gridB31" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Critaria_gridB32" id="Critaria_gridB32" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
     </table></td>
     <td width="34">&nbsp;</td>
     <td width="801">&nbsp;<table width="594" border="0">
       <tr>
         <th width="144" scope="col">&nbsp;</th>
         <th width="144" scope="col"><input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></th>
         <th width="144" scope="col"><input type="text"  class="label_purchase" value="Tot Comm" disabled="disabled"/></th>
         <th width="144" scope="col"><input type="text"  class="label_purchase" value="Advance" disabled="disabled"/></th>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Sales" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Sales_gridB11" id="Sales_gridB11" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridB12" id="Sales_gridB12" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridB13" id="Sales_gridB13" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="GRN" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Sales_gridB21" id="Sales_gridB21" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridB22" id="Sales_gridB22" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridB23" id="Sales_gridB23" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="CRN" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Sales_gridB31" id="Sales_gridB31" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridB32" id="Sales_gridB32" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridB33" id="Sales_gridB33" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Net" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Sales_gridB41" id="Sales_gridB41" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridB42" id="Sales_gridB42" value="" disabled="disabled" class="text_purchase3"/></td>
         <td><input type="text" size="20" name="Sales_gridB43" id="Sales_gridB43" value="" disabled="disabled" class="text_purchase3"/></td>
       </tr>
     </table></td></tr></table>
   </fieldset>
   <br />
   <table><tr><td>
      <fieldset> 
   <legend><div class="text_forheader">Total Sales Summery</div></legend>
   <table><tr>
     <td width="298" valign="top"><table width="298" border="0">
       
       <tr>
         <td width="144"><input type="text"  class="label_purchase" value="Total Sales" disabled="disabled"/></td>
         <td width="144"><input type="text" size="20" name="totsal_grid11" id="totsal_grid11" value="" disabled="disabled" class="text_purchase3"/></td>
         </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Total GRN" disabled="disabled"/></td>
         <td><input type="text" size="20" name="totsal_grid21" id="totsal_grid21" value="" disabled="disabled" class="text_purchase3"/></td>
         </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Total CRN" disabled="disabled"/></td>
         <td><input type="text" size="20" name="totsal_grid31" id="totsal_grid31" value="" disabled="disabled" class="text_purchase3"/></td>
         </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Total Net" disabled="disabled"/></td>
         <td><input type="text" size="20" name="totsal_grid41" id="totsal_grid41" value="" disabled="disabled" class="text_purchase3"/></td>
         </tr>
     </table></td>
     </tr></table>
   </fieldset>
   </td><td>
      <fieldset> 
   <legend><div class="text_forheader">Over 60 / Return Cheques</div></legend>
   <table><tr>
     <td width="298" valign="top"><table width="298" border="0">
       
       <tr>
         <td width="144">&nbsp;</td>
         <td width="144"><input type="text"  class="label_purchase" value="Total Sales" disabled="disabled"/></td>
         </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Over 60 Out." disabled="disabled"/></td>
         <td><input type="text" size="20" name="Ratio_grid11" id="Ratio_grid11" value="" disabled="disabled" class="text_purchase3"/></td>
         </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Return Chq." disabled="disabled"/></td>
         <td><input type="text" size="20" name="Ratio_grid21" id="Ratio_grid21" value="" disabled="disabled" class="text_purchase3"/></td>
         </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Total" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Ratio_grid31" id="Ratio_grid31" value="" disabled="disabled" class="text_purchase3"/></td>
         </tr>
     </table></td>
     </tr></table>
   </fieldset>
   </td>
   <td>
      <fieldset> 
   <legend><div class="text_forheader">Tolarance Ratio</div></legend>
   <table><tr>
     <td width="298" valign="top"><table width="298" border="0">
       
       <tr>
         <td width="144"><input type="text"  class="label_purchase" value="Adjustments" disabled="disabled"/></td>
         <td width="144"><input type="text" size="20" name="TXTADJ" id="TXTADJ" value=""  class="text_purchase3"/></td>
         </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Ratio %" disabled="disabled"/></td>
         <td><input type="text" size="20" name="txtra_per" id="txtra_per" value="" class="text_purchase3"/></td>
         </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
     </table></td>
     </tr></table>
   </fieldset>
   </td>
   
   </tr></table>
  <table width="94%" border="0">
  
  <tr>
    <td width="68%"><table width="1124" border="0">
      
      <tr>
        <td colspan="2"><input type="text"  class="label_purchase" value="Other Deductions" disabled="disabled"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="39%" colspan="2" rowspan="6">
         <fieldset> 
   <legend><div class="text_forheader">Commission Totals</div></legend>
   <table><tr>
     <td width="298" valign="top"><table width="298" border="0">
       
       <tr>
         <td width="144"><input type="text"  class="label_purchase" value="Group" disabled="disabled"/></td>
         <td width="144"><input type="text"  class="label_purchase" value="Comm" disabled="disabled"/></td>
         </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Tyres" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Comm_grid11" id="Comm_grid11" value="" disabled="disabled" class="text_purchase3"/></td>
         </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="A/Wheels" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Comm_grid21" id="Comm_grid21" value="" disabled="disabled" class="text_purchase3"/></td>
         </tr>
       <tr>
         <td><input type="text"  class="label_purchase" value="Net" disabled="disabled"/></td>
         <td><input type="text" size="20" name="Comm_grid31" id="Comm_grid31" value="" disabled="disabled" class="text_purchase3"/></td>
         </tr>
     </table></td>
     </tr></table>
   </fieldset>        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" size="20" name="Deduction_grid11" id="Deduction_grid11" value="" class="text_purchase3"/></td>
        <td width="14%"><input type="text" size="20" name="Deduction_grid12" id="Deduction_grid12" value="" class="text_purchase3"/></td>
        <td width="4%">&nbsp;</td>
        <td width="2%">&nbsp;</td>
        <td width="6%">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" size="20" name="Deduction_grid21" id="Deduction_grid21" value="" class="text_purchase3"/></td>
        <td><input type="text" size="20" name="Deduction_grid22" id="Deduction_grid22" value="" class="text_purchase3"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" size="20" name="Deduction_grid31" id="Deduction_grid31" value="" class="text_purchase3"/></td>
        <td><input type="text" size="20" name="Deduction_grid32" id="Deduction_grid32" value="" class="text_purchase3"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" size="20" name="Deduction_grid41" id="Deduction_grid41" value="" class="text_purchase3"/></td>
        <td><input type="text" size="20" name="Deduction_grid42" id="Deduction_grid42" value="" class="text_purchase3"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" size="20" name="Deduction_grid51" id="Deduction_grid51" value="" class="text_purchase3"/></td>
        <td><input type="text" size="20" name="Deduction_grid52" id="Deduction_grid52" value="" class="text_purchase3"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" size="20" name="Deduction_grid61" id="Deduction_grid61" value="" class="text_purchase3"/></td>
        <td><input type="text" size="20" name="Deduction_grid62" id="Deduction_grid62" value="" class="text_purchase3"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" size="20" name="Deduction_grid71" id="Deduction_grid71" value="" class="text_purchase3"/></td>
        <td><input type="text" size="20" name="Deduction_grid72" id="Deduction_grid72" value="" class="text_purchase3"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" size="20" name="Deduction_grid81" id="Deduction_grid81" value="" class="text_purchase3"/></td>
        <td><input type="text" size="20" name="Deduction_grid82" id="Deduction_grid82" value="" class="text_purchase3"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="8"></td>
      </tr>
      <tr>
        <td width="6%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="6%" colspan="8"><table width="1121" border="0">
          <tr>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="Calculate Advance" disabled="disabled"/></th>
            <th width="5" scope="col">-</th>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="Ratio Deduction" disabled="disabled"/></th>
            <th width="9" scope="col">=</th>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="Advance " disabled="disabled"/></th>
            <th width="9" scope="col">=</th>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="Round-up Advance" disabled="disabled"/></th>
            <th width="5" scope="col">-</th>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="Other Deductions" disabled="disabled"/></th>
            <th width="9" scope="col">=</th>
            <th width="144" scope="col"><input type="text"  class="label_purchase" value="Payable Advance" disabled="disabled"/></th>
            <th width="6" scope="col">&nbsp;</th>
            <th width="160" scope="col"><input type="text"  class="label_purchase" value="Issued Chq Details" disabled="disabled"/></th>
          </tr>
          <tr>
            <td><input type="text" size="20" name="txt_cadv" id="txt_cadv" value="" disabled="disabled" class="text_purchase3"/></td>
            <td>&nbsp;</td>
            <td><input type="text" size="20" name="txt_rded" id="txt_rded" value="" disabled="disabled" class="text_purchase3"/></td>
            <td>&nbsp;</td>
            <td><input type="text" size="20" name="txt_adv" id="txt_adv" value="" disabled="disabled" class="text_purchase3"/></td>
            <td>&nbsp;</td>
            <td><input type="text" size="20" name="txt_radv" id="txt_radv" value="" disabled="disabled" class="text_purchase3"/></td>
            <td>&nbsp;</td>
            <td><input type="text" size="20" name="txt_ded" id="txt_ded" value="" disabled="disabled" class="text_purchase3"/></td>
            <td>&nbsp;</td>
            <td><input type="text" size="20" name="txt_padv" id="txt_padv" value="" disabled="disabled" class="text_purchase3"/></td>
            <td>&nbsp;</td>
            <td><input type="text" size="20" name="txt_chq_det" id="txt_chq_det" value="" class="text_purchase3"/></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
 
  </table>
  
   
   	
  
  
  </fieldset>
  </td></tr><tr>
    <td width="8" valign="top">&nbsp;</td>
  </tr>
  
  </table>
</form>        

</fieldset>    
            
              	