
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
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Commission Rates Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="18%">&nbsp;</td>
    <td width="18%">&nbsp;</td>
    <td width="29%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
<fieldset>               
            
   	<legend></legend>            
            
  <table width="57%" border="0">
    
  
  <tr>
	<td width="20%" colspan="9">
    <div class="CSSTableGenerator" id="itemdetails" >
<div id="comm_table">
                                  <?php
								  require_once("config.inc.php");
			require_once("DBConnector.php");
			$db = new DBConnector();
	
		echo "<table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Brand</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">Bel_60</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">D_60_To_75</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">D_75_To_90</td>
					<td width=\"70\"  background=\"images/headingbg.gif\">Ov_90</td>";
				
				$i=1;
				$sql="select barnd_name, b60, d60to75, d75to90, o90 from brand_mas order by barnd_name";
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
											
						$barnd_name="barnd_name".$i;
						$b60="b60".$i;
						$d60to75="d60to75".$i;
						$d75to90="d75to90".$i;
						$o90="o90".$i;
												
						echo "<tr>
						<td><font size=2><div id=".$barnd_name.">".$row["barnd_name"]."</div></font></td>
						<td><input type=\"text\" name=".$b60." id=".$b60." size=\"10\" value=".$row["b60"]." class=\"txtbox\" ></td>
						<td><input type=\"text\" name=".$d60to75." id=".$d60to75." size=\"10\" value=".$row["d60to75"]." class=\"txtbox\"  ></td>
						<td><input type=\"text\" name=".$d75to90." id=".$d75to90." size=\"10\" value=".$row["d75to90"]."  class=\"txtbox\" ></td>
						<td><input type=\"text\" name=".$o90." id=".$o90." size=\"10\" value=".$row["o90"]."  class=\"txtbox\" ></td>
						</tr>";
						$i=$i+1;
					
								
				}
				
				echo  "</table>";
				//echo "<input type=\"text\" name=mtot id=mtot size=\"10\" value=".$i." >";
								  ?>

</div>
<input type="hidden" name="mtot" id="mtot" size="10" value="120" > </div>                                                 		</td>
                                                		</tr>
  
  <tr>
    <td width="10%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    </tr>
</table>
          

</form>        

</fieldset>    
            
            <table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">