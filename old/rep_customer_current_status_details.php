
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
  <div class="text_forheader">Customer Current Status Report</div>
                                               	 </legend>             

<form id="form1" name="form1" action="report_customer_current_summery_details.php" target="_blank" method="get">
<table width="767" border="0">
  <tr>
    <td align="left">&nbsp;</td>
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
    <td width="274" align="left"><table width="274">
      <tr>
        <td width="76" align="left"><input type="text"  class="label_purchase" value="Customer" disabled/></td>
        <td width="186"><input type="text" name="cuscode" id="cuscode" class="text_purchase3" onblur="custno_ind('rep_outstand_state');"   /></td>
      </tr>
    </table></td>
    <td width="245"><a href="" onclick="NewWindow('serach_customer.php?stname=rep_outstand_state','mywin','800','700','yes','center');return false" onfocus="this.blur()"><input type="text" name="cusname" id="cusname" class="text_purchase3"/>
      
    </a></td>
    <td width="234"><a href="serach_customer.php?stname=rep_outstand_state" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()">
      <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase1" />
    </a></td>
  </tr>
  <tr>
    <td colspan="3" align="left"><input type="text"  class="text_purchase3"  disabled="disabled" id="cus_address" name="cus_address" /></td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left"><table width="821" border="0">
      <tr>
        <th scope="col"><input type="radio" name="radio" id="optout" value="optout" checked="checked" />
Outstanding</th>
        <th scope="col">&nbsp;</th>
        <th scope="col">&nbsp;</th>
        <th scope="col">&nbsp;</th>
        <th scope="col"><input type="text"  class="label_purchase" value="GRN Type" disabled="disabled"/></th>
        <th colspan="2" scope="col"><select name="cmbGRNtype" id="cmbGRNtype" class="text_purchase3">
          <option value="All">All</option>
          <option value="GRN">GRN</option>
          <option value="DGRN">DGRN</option>
          <option value="CNT">CNT</option>
          <option value="REC">REC</option>
        </select></th>
      </tr>
      <tr>
        <th width="147" scope="col"><input type="radio" name="radio" id="optpen" value="optpen" />
Pending Uti</th>
        <th width="59" scope="col">&nbsp;</th>
        <th width="84" scope="col">&nbsp;</th>
        <th width="144" scope="col">&nbsp;</th>
        <th width="162" scope="col"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></th>
        <th width="195" colspan="2" scope="col">
		
		<select name="cmbrep" id="cmbrep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">

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
              if($_SESSION["CURRENT_USER"]=="rohan"){
                  $sql="select * from s_salrep where cancel='1' and pactive = '1' order by REPCODE"; 
                  $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                  while($row = mysqli_fetch_array($result)){
                      echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                  }
              }else{
                  $sql="select * from s_salrep where cancel='1' order by REPCODE";
                  $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                  while($row = mysqli_fetch_array($result)){
                      echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                  }
              }
           } else {
               
                  $sql="select * from s_salrep where cancel='1' and repcode = '" . $_SESSION["CURRENT_REP"] ."' order by REPCODE";
                  $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                  while($row = mysqli_fetch_array($result)){
                      echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                  }
               
           }
							?>
						</select>
						</th>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="text"  class="label_purchase" value="Type" disabled="disabled"/></td>
        <td colspan="2"><select name="cmbbrand1" id="cmbbrand1" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="setord();">
        <option value="All">All</option> 
            <?php
                $sql="select class from brand_mas where act='1' group by class ";
                $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
                while($row = mysqli_fetch_array($result)){
                echo "<option value='".$row["class"]."'>".$row["class"]."</option>";
                }
                ?>
        </select></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="text"  class="label_purchase" value="Brand (For Outsatnding Invoices)" disabled="disabled"/></td>
        <td colspan="2"><select name="brand" id="brand" class="text_purchase3"  onchange="setord();">
        <option value="All">All</option> 
        <?php
        if ($_SESSION["CURRENT_DEP"] != "") {
            $sql="select * from brand_mas where act ='1' and costcenter='".$_SESSION["department"]."' order by barnd_name"; 
        }else{
            $sql="select * from brand_mas where act ='1' order by barnd_name";
        } 
         
        $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
        while($row = mysqli_fetch_array($result)){
         echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
        }
        ?>
        </select></td>
      </tr>
      
    </table></td>
    </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="274" align="left">&nbsp;</td>
    <td width="245" align="left"></td>
    <td width="234" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="274" align="left"></td>
    <td><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
  </tr>
</table>
<fieldset>               
            
 
</form>        

   
            
          