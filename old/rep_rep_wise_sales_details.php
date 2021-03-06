
<?php 
 
	

						 
	require_once("connectioni.php");
	
	 
?>	

						 
	

 
<link rel="stylesheet" href="css/table.css" type="text/css"/>	
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript" language="javascript" src="js/get_cat_description.js"></script>
<script type="text/javascript" language="javascript" src="js/datepickr.js"></script>

 
 

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
  <div class="text_forheader"> Sales Summery Report - Repwise</div>
                                               	 </legend>             

<form id="form1" name="form1" action="report_repwise_sales_summeryN.php" target="_blank" method="get">
<table width="810" border="0">
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
    <td>&nbsp;</td>
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
    <td width="144" align="left"><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
    <td width="76" align="left"><select name="cmbbrand" id="cmbbrand" onkeypress="keyset('searchitem',event);" class="text_purchase3"  onchange="setord();">
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
    <td width="117"><select name="cmbdev" id="cmbdev" class="text_purchase3">
      <?php
				if ($_SESSION['dev']=="1"){
            		echo "<option value=\"All\">All</option>
                		<option value=\"Manual\">Van Sale</option>
                		<option value=\"Computer\">Office Sale</option>";
				} else if ($_SESSION['dev']=="0"){
            		echo "<option value=\"Computer\">Office Sale</option>";
				}				
             ?>  
    </select></td>
    <td width="5">&nbsp;</td>
    <td width="45"><input type="checkbox" name="chktar" id="chktar" />
Target</td>
  </tr>
  <tr>
    <td align="left"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td width="186" align="left">&nbsp;</td>
    <td colspan="2" align="left"><select name="salesrep" id="salesrep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
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
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left"><table width="500" border="0">
      <tr>
        <th width="403" scope="col"><table width="400" border="0">
          <tr>
            <th scope="col"><input type="text"  class="label_purchase" value="From" disabled="disabled"/></th>
            <th scope="col"><input type="text" name="DT1" id="DT1" class="text_purchase3" onfocus="load_calader('DT1');" value="<?php echo date("Y-m-d"); ?>"/></th>
          </tr>
          
        </table></th>
        <th width="87" scope="col"><table width="300" border="0">
          <tr>
            <th scope="col"><input type="text"  class="label_purchase" value="To" disabled="disabled"/></th>
            <th scope="col"><input type="text" name="DT2" id="DT2" onfocus="load_calader('DT2');" class="text_purchase3" value="<?php echo date("Y-m-d"); ?>"/></th>
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
    <td width="207" align="left"><input type="text"  class="label_purchase" value="Cat." disabled="disabled"/></td>
    <td colspan="2" align="left"><select name="cmbtype" id="cmbtype" class="text_purchase3">
      <option selected="selected" value='All'>All</option>
      <option value='PCR'>PCR</option>
      <option value='LTR'>LTR</option>
      <option value='OTR'>OTR</option>
      <option value='TBR'>TBR</option>
      <option value='BIAS TYRES'>BIAS TYRES</option>
                       					
    </select></td>
    <td width="76" align="left">&nbsp;</td>
    <td width="117" align="left"></td>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
  <td><input type="text"  class="label_purchase" value="Type." disabled="disabled"/></td>
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
    <td colspan="4" align="left"></td>
    <td><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
  </tr>
</table>

             
            
 
</form>        

   
            
          