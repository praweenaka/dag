
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
   <script>
    $(function(){
    	$('.mytb').on('mouseover', 'tr', function(){
    		 
    	}).on('mouseout', 'tr', function(){
    		 
    	}).on('click', 'tr', function(){
    		$(this).parent().children().css({
    			'background-color': '#FFFFFF'
    		});
    		$(this).css({
    			'background-color': '#7DAFFF'
    		});
    	});
    });
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
  <div class="text_forheader">Balance Commission</div>
                                               	 </legend>             

<form name="form1" id="form1">  
 <table border="1"><tr><td width="1301">         
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="14%"><input type="hidden" name="txt_stat" id="txt_stats" /></td>
    <td width="14%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="14%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="16%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Month" disabled="disabled"/></td>
    <td>
    <input type="text" name="dtMonth" id="dtMonth" class="text_purchase3"   onchange="getdATA();"/>
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
</script>
    </td>
    <td><input type="text"  class="label_purchase" value="Sales Excecutive" disabled="disabled"/></td>
    <td><select name="cmbrep" id="cmbrep" class="text_purchase3">
      <?php
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
                    echo $sql;
                    $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                    while($row = mysqli_fetch_array($result)){
                    echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                    }
                } 
      ?>
    </select></td>
    
    <td><input type="button" name="com_view" id="com_view" value="View Summery"  class="btn_purchase2" onclick="getdATA();" /></td>
    <td><input type="button" name="com_view2" id="com_view2" value="Save"  class="btn_purchase2" onclick="update();" /></td>
    <td><input type="button" name="com_view3" id="com_view3" value="Calc"  class="btn_purchase2" onclick="calcc();" /></td>
    <td colspan='2'>
    	<select name="radio" id="radio" class="text_purchase3">
    		<option value='All'>All</option>
    		<option value='2'>2nd Cat</option>
    		<option value='3'>No Commision</option>
    	</select>
    </td>
     
  </tr>
  <tr>
    <td colspan="2"><input type="hidden" name="mcount" id="mcount" /></td>
    <td><a href="" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onfocus="this.blur()"></a><a href="serach_rec.php?stname=cash_rec" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  </table>

  
  <br/>   
  <div class="CSSTableGenerator" id="gridinv" style="overflow:scroll; height:200px"  >   
        
        <table class='mytb' >
          <tr>
            <td width="10%" ><font color="#FFFFFF">Date</font></td>
            <td width="15%" ><font color="#FFFFFF">Inv. NO</font></td>
            <td width="30%" ><font color="#FFFFFF">Customer</font></td>
            <td width="20%" ><font color="#FFFFFF">Brand</font></td>
            <td width="15%" ><font color="#FFFFFF">Inv. Amount</font></td>
            <td width="15%" ><font color="#FFFFFF">Paid Amount</font></td>
            
          </tr>
        </table>
        </div>     


  





 
   
   <fieldset> 
  <table width="100%" border="0">
      
      
      <tr>
        <td colspan="6">
        <div class="CSSTableGenerator" id="TypeGrid1" style="overflow:scroll; height:150px"  >   
        
        <table >
          <tr>
            <td width="10%" ><font color="#FFFFFF">Date</font></td>
            <td width="10%" ><font color="#FFFFFF">Rec. NO</font></td>
            <td width="10%" ><font color="#FFFFFF">Ch.No</font></td>
            <td width="10%" ><font color="#FFFFFF">Paid</font></td>
            <td width="10%" ><font color="#FFFFFF">Days</font></td>
            <td width="10%" ><font color="#FFFFFF">Commission</font></td>
            <td width="10%" ><font color="#FFFFFF">Comment</font></td>
          </tr>
        </table>
        </div>        </td>
        <td colspan="2">
        <div class="CSSTableGenerator" id="MSHFlexGrid1" style="overflow:scroll; height:100px"  >   
        
        <table >
          <tr>
            <td width="10%"   background="images/headingbg.gif" ><font color="#FFFFFF">Days</font></td>
            <td width="20%"  background="images/headingbg.gif"><font color="#FFFFFF">Rate %</font></td>
          </tr>
        </table>
        </div>     
    </br>        </td>
        </tr>
      <tr>
        <td width="17%"><input type="text"  class="label_purchase" value="Total Sale" disabled="disabled"/></td>
        <td width="14%"><input type="text" size="20" name="txtnetsale" id="txtnetsale" value="" class="text_purchase3"/></td>
        <td width="17%"><input type="text"  class="label_purchase" value="Paid" disabled="disabled"/></td>
        <td colspan="3"><input type="text" size="20" name="txtpaid" id="txtpaid" value="" class="text_purchase3"/></td>
        <td width="14%"><input type="text"  class="label_purchase" value="Outstanding" disabled="disabled"/></td>
        <td width="14%"><input type="text" size="20" name="txtout" id="txtout" value="" class="text_purchase3"/></td>
    </tr>
      <tr>
        <td><input type="text"  class="label_purchase" value="Return" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtret" id="txtret" value="" class="text_purchase3"/></td>
        <td><input type="text"  class="label_purchase" value="No Commission" disabled="disabled"/></td>
        <td colspan="3"><input type="text" size="20" name="txtNocomm" id="txtNocomm" value="" class="text_purchase3"/></td>
        <td><input type="text"  class="label_purchase" value="2 nd Target" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtt2" id="txtt2" value="" class="text_purchase3"/></td>
    </tr>
      
      
      
      <tr>
        <td colspan="6">             </td>
        <td colspan="2">           </td>
      </tr>
      
      <tr>
        <td><input type="text"  class="label_purchase" value="Net Sale" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtnet" id="txtnet" value="" class="text_purchase3"/></td>
        <td><input type="text"  class="label_purchase" value="Precentage" disabled="disabled"/></td>
        <td colspan="3"><input type="text" size="20" name="txtpre" id="txtpre" value="" class="text_purchase3"/></td>
        <td><input type="text"  class="label_purchase" value="1 st Target" disabled="disabled"/></td>
        <td><input type="text" size="20" name="txtt1" id="txtt1" value="" class="text_purchase3"/></td>
      </tr>
      
       <tr>
        <td>&nbsp; </td>
        <td>&nbsp; </td>
        <td>&nbsp; </td>
      </tr>
      <tr>
      
        <td><input type="text"  class="label_purchase" value="Remark" disabled="disabled"/></td>
       <td colspan="4"><textarea name="TXTREMARK" id="TXTREMARK" cols="55" rows="5"> </textarea></td>
        <!--<td><input type="button" name="com_view" id="com_view" value="Remark Update"  class="btn_purchase2" onclick="upremark();" /></td>-->
        <td>&nbsp; </td>    
      </tr>
      
  </table>
  
  </fieldset>
  
  
  </td></tr><tr>
    <td width="8" valign="top">&nbsp;</td>
  </tr>
  
  </table>
</form>        

</fieldset>    
            
              	