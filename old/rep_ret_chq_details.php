
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
  <div class="text_forheader">Return Cheque</div>
                                               	 </legend>             

<form id="form1" name="form1" action="report_return_chq.php" target="_blank" method="get">
<table width="767" border="0">
  <tr>
    <td align="left"><input type="radio" name="radio" id="optunsettle" value="optunsettle" checked="checked" /> 
      Unsettled</td>
    <td align="left"><input type="radio" name="radio" id="optall" value="optall" /> 
      All</td>
      
    <td align="left">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="144" align="left"><input type="checkbox" name="Check1" id="Check1" /> 
      Customer</td>
    <td width="159" align="left"><input type="text"  class="label_purchase" value="From" disabled="disabled"/></td>
    <td width="125" align="left"><input type="text" size="20" name="dtfrom" id="dtfrom" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtfrom');" class="text_purchase3"/></td>
    <td width="144"><input type="text"  class="label_purchase" value="To" disabled="disabled"/></td>
    <td width="125"><input type="text" size="20" name="dtto" id="dtto" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtto');" class="text_purchase4"/></td>
    <td><script type="text/javascript">
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
    <td colspan="2" align="left"><table width="274">
      <tr>
        <td width="76" align="left"><input type="text"  class="label_purchase" value="Customer" disabled/></td>
        <td width="186"><input type="text" name="cuscode" id="cuscode" class="text_purchase3"/></td>
      </tr>
    </table></td>
    <td colspan="3" align="left"><a href="" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onfocus="this.blur()"><input type="text" name="cusname" id="cusname" class="text_purchase3"/>
      
    </a></td>
    <td width="44"><a href="serach_customer.php?stname=rep_outstand_state" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase2" />
    </a></td>
  </tr>
  <tr>
    <td colspan="3" align="left"><input type="text"  class="text_purchase3"  disabled="disabled" id="cus_address" name="cus_address" /></td>
    <td align="left"><select name="cmbdev" id="cmbdev" class="text_purchase3">
      
       <?php
				if ($_SESSION['dev']=="1"){
            		echo "<option value=\"ALL\">ALL</option>
                		<option value=\"Manual\">Van Sale</option>
                		<option value=\"Computer\">Office Sale</option>";
				} else if ($_SESSION['dev']=="0"){
            		echo "<option value=\"Computer\">Office Sale</option>";
				}				
             ?>  
    </select></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  
  <tr>
    <td align="left"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td align="left"><select name="cmbrep" id="cmbrep"   class="text_purchase3">
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
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left"><table width="400" border="0">
      <tr>
        <th width="20" scope="col"><input type="checkbox" name="chk1" id="chk1" /></th>
        <th width="279" >Date 1</th>
        <th width="87" ><input type="text" size="20" name="dt1" id="dt1" value="" onfocus="load_calader('dt1');"  class="text_purchase3"/></th>
      </tr>
      <tr>
        <td><input type="checkbox" name="chk2" id="chk2" /></td>
        <td>Date 2</td>
        <td><input type="text" size="20" name="dt2" id="dt2" value="" onfocus="load_calader('dt2');" class="text_purchase3"/></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chk3" id="chk3" /></td>
        <td>Date 3</td>
        <td><input type="text" size="20" name="dt3" id="dt3" value="" onfocus="load_calader('dt3');" class="text_purchase3"/></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chk4" id="chk4" /></td>
        <td>Date 4</td>
        <td><input type="text" size="20" name="dt4" id="dt4" value="" onfocus="load_calader('dt4');" class="text_purchase3"/></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chk5" id="chk5" /></td>
        <td>Date 5</td>
        <td><input type="text" size="20" name="dt5" id="dt5" value="" onfocus="load_calader('dt5');" class="text_purchase3"/></td>
      </tr>
    </table></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="3" align="left">&nbsp;</td>
    <td colspan="2" align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left">&nbsp;</td>
    <td colspan="2" align="left"><input type="submit" name="button" id="button" value="View" class="btn_purchase2"/></td>
    <td width="44" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left"></td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<fieldset>               
            
 
</form>        

   
            
          