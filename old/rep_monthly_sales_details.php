<?php 
 
						 
	require_once("connectioni.php");
	
						
	 
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
  <div class="text_forheader"> Monthly Sales Summery</div>
                                               	 </legend>             

<form id="form1" name="form1" action="report_monthly_sales.php" target="_blank" method="get">
<table width="767" border="0">
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
    <td><input type="text" name="DTPicker1" id="DTPicker1" class="text_purchase3" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('DTPicker1');"/></td>
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
    <td colspan="2" align="left"><input type="checkbox" name="chkdef" id="chkdef" />
With Defective </td>
    <td align="left"><input type="radio" name="radio" id="Option1" value="Option1" checked="checked" />
      Normal</td>
    <td align="left"><input type="radio" name="radio" id="Option2" value="Option2" />
      Nil Sale</td>
    <td><input type="radio" name="radio" id="op_traget" value="op_traget" />
      Target Brands</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="422" colspan="2" align="left"><input type="checkbox" name="ChKCUS" id="ChKCUS" />
Customer</td>
    <td width="104" align="left">&nbsp;</td>
    <td width="104" align="left"><input type="text"  class="label_purchase" value="Grater Than" disabled="disabled"/></td>
    <td width="160">
      <input type="text" name="txt_amou" id="txt_amou" value="0" class="text_purchase3"/>
    </td>
    <td width="399">&nbsp;</td>
    <td width="399">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><input type="text"  class="label_purchase" value="Customer" disabled="disabled"/></td>
    <td align="left">&nbsp;</td>
    <td align="left"><input type="text" name="cuscode" id="txt_cuscode" class="text_purchase3"/></td>
    <td colspan="3" align="left"><a href="" onclick="NewWindow('serach_customer.php','mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="text" name="cusname" id="cusname" class="text_purchase3"/>
    </a></td>
    <td align="left"><a href="serach_customer.php?stname=rep_monthly_sales" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase1" />
    </a></td>
  </tr>
  <tr>
    <td align="left"><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td align="left">&nbsp;</td>
    <td align="left"><select name="cmbbrand" id="cmbbrand" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="setord();">
      <option value='All'>All</option>
      <?php
	  			require_once("connectioni.php");

        if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
            $sql="select * from brand_mas where act ='1' and costcenter='".$_SESSION["CURRENT_DEP"]."' order by barnd_name"; 
        }else{
            $sql="select * from brand_mas where act ='1' order by barnd_name";
        } 
        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
        while($row = mysqli_fetch_array($result)){
         echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
        }
            ?>
    </select></td>
    <td align="left"><input type="text"  class="label_purchase" value="Month 1" disabled="disabled"/></td>
    <td align="left"><input type="text" name="month1" id="month1" class="text_purchase3" onfocus="load_calader('month1');" /></td>
    <td align="left"><input type="button" name="button2" id="button2" value="Set Month" class="btn_purchase1" onclick="set_other_month();"/></td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td align="left">&nbsp;</td>
    <td align="left"><select name="cmbrep" id="cmbrep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
      
      
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
                    $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                    while($row = mysqli_fetch_array($result)){
                    echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                    }
                }
            ?>
    </select></td>
    <td align="left"><input type="text"  class="label_purchase" value="Month 2" disabled="disabled"/></td>
    <td align="left"><input type="text" name="month2" id="month2" class="text_purchase3" onfocus="load_calader('month2');"/></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left"><input type="text"  class="label_purchase" value="Month 3" disabled="disabled"/></td>
    <td align="left"><input type="text" name="month3" id="month3" class="text_purchase3" onfocus="load_calader('month3');"/></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left"><table width="500" border="0">
      <tr>
        <th width="403" scope="col"><table width="400" border="0">
          <tr>
            <th scope="col"> <td colspan="2"><select name="cmb_t" id="cmb_t" class="text_purchase3">
					 
						<option value='All' selected="selected">All</option>
							<?php
							$sql = "select class from brand_mas where act='1' group by class";
							$result = mysqli_query($GLOBALS['dbinv'], $sql);
							while ($row = mysqli_fetch_array($result)) {
								echo "<option value='" . $row["class"] . "'>" . $row["class"] .  "</option>";
							}
							
							
							?>	
						 
				</select></td></th>
            <th scope="col">&nbsp;</th>
          </tr>
          
        </table></th>
        <th width="87" scope="col"><table width="300" border="0">
          <tr>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
          </tr>
          
        </table></th>
      </tr>
    </table></td>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" align="left">   </td>
    </tr>
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="422" colspan="4" align="left">&nbsp;</td>
    <td width="160" align="left"></td>
    <td width="399" colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="422" colspan="4" align="left"></td>
    <td><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
  </tr>
</table>

             
            
 
</form>        

   
            
          