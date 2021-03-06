
<?php 
						 
	require_once("connectioni.php");
	
						
	$sql = "delete FROM TMP_EDU_FILTER";
	
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
						
	$sql = "delete FROM	TMP_QUALI_FILTER";
	
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
?>	

						 
	



<link rel="stylesheet" href="css/table_min.css" type="text/css"/>	
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
			dateFormat:"%Y-%m"
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
.style1 {
	font-size: 18px;
	color: #FF0000;
}
-->
</style>
<fieldset>
                                                	<legend>
  <div class="text_forheader">Dealer Incentive</div>
                                               	 </legend>             

<form name="form1" id="form1">  
 <table border="0"><tr><td width="1301">         
  <table width="100%" border="0"  class=\"form-matrix-table\">
  
  <tr>
    <td width="13%"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td width="13%"><select name="cmbrep" id="cmbrep" class="text_purchase3">
      <?php
	  

					$sql="delete from tmprepsale";
					$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																			
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
    <td width="13%"><input type="text"  class="label_purchase" value="Month" disabled="disabled"/></td>
    <td width="12%"><input type="text" size="20" name="DTPicker1" id="DTPicker1" value="<?php echo date("Y-m-d"); ?>"  onfocus="load_calader('DTPicker1');" class="text_purchase3"/></td>
    <td width="13%" colspan="2"><select name="cmbtype" id="cmbtype" class="text_purchase3">
            <option value="TYRE">TYRE</option>
            < 
            <option value="BATTERY">BATTERY</option>
    </select></td>
    <td width="12%" colspan="2"><div class="style1" id="wait_res"></div></td>
    <td width="12%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dtMonth",
			dateFormat:"%Y-%m"
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
</script>    <a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
    <td>&nbsp;</td>
    <td width="12%"><a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
    <td colspan="2">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td> <a href="serach_customer.php?stname=ret_chq_settle" onClick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onFocus="this.blur()"></a></td>
  </tr>
  </table>

  
  <div id="dealer_ins"></div>
 


  





<fieldset>
<table width="94%" border="0">
  
  <tr>
    <td height="499" valign="top" ><div id="tabledet" class="CSSTableGenerator"></div></td>
  </tr>
 
  </table>
  
   
   	
  
  
  </fieldset>
  </td></tr><tr>
    <td width="8" valign="top">&nbsp;</td>
  </tr>
  
  </table>
</form>        

</fieldset>    
            
              	