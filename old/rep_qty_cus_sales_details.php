
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

						 
	

 
<link rel="stylesheet" href="css/table.css" type="text/css"/>	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" language="javascript" src="js/datepickr.js"></script>
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
function load_calader(tar){
		new JsDatePick({
			useMode:2,
			target:tar,
			dateFormat:"%Y-%m-%d"
			
		});	
	}
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
  <div class="text_forheader">Qty Report</div>
                                               	 </legend>             

    <form id="form1" name="form1" action="report_new_qty_sales.php" target="_blank" method="get">
<table width="767" border="0">
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
    <td>&nbsp;</td>
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
          <td><input type="text"  class="label_purchase" value="Department" disabled="disabled"/></td>
    <td><select name="department" id="department"  disabled="disabled"   class="text_purchase3">
      <option value='All'>All</option>
      <?php
	  
                $sql="select * from s_stomas order by CODE";
                $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                while($row = mysqli_fetch_array($result)){
echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
}
        ?>
    </select></td>
  </tr>
  <tr>
    <td colspan="2" align="left"><table width="274">
      <tr>
          
            <td><input type="text"  class="label_purchase" value="Item Code" disabled/></td>
    <td><input type="text" class="text_purchase2" name="stkno" id="stkno" onblur="itno1();" onkeypress="keyset('department',event);" />
      <a href="" onClick="NewWindow('serach_item_simple.php','mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase1">
      </a></td>
        
      </tr>
    </table></td>
    <td width="209">&nbsp;</td>
    <td width="209">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">
      <input type="text"  class="label_purchase" value="From" disabled="disabled"/>
     
   </td>
    <td align="left"><input type="text" size="20" name="dateFrom" id="dateFrom" value="<?php echo date("Y-m-d"); ?>"  onfocus="load_calader('dateFrom');"   " /></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">
      <input type="text"  class="label_purchase" value="To" disabled="disabled"/>
     
   </td>
    <td align="left"><input type="text" size="20" name="dateTo" id="dateTo" value="<?php echo date("Y-m-d"); ?>"  onfocus="load_calader('dateTo');"   " /></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><input type="checkbox" id="Chk_cus_wise1" name="Chk_cus_wise1"><label id="Chk_cus_wise_lbl1">Summery</label></td>
    <td align="left"></td>
    <td align="left">&nbsp;</td>
  </tr>	
  <tr>
    <td colspan="2" align="left"></td>
    <td><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
  </tr>
</table>
<fieldset>               
            
 
</form>        

   
            
          