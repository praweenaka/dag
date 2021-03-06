
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
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Brand Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td width="18%"><input type="text"  class="label_purchase" value="Brand Name" disabled/></td>
    <td width="18%"><input type="text"  class="label_purchase" value="Class" disabled="disabled"/></td>
    <td width="18%"><input type="text"  class="label_purchase" value="Active" disabled="disabled"/></td>
    <td width="17%"><input type="text"  class="label_purchase" value="Target Type" disabled="disabled"/></td>
    <td width="29%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text" class="text_purchase3"  id="barnd_name" name="barnd_name" onkeypress="keyset('class', event);" onKeyUp="ajax_showOptionsfname(this,'getCountriesByLetters',event,'ajax-list-brand.php');" onblur="setbrand();"/></td>
    <td><select name="class" id="class" onkeypress="keyset('brand',event);" class="text_purchase3">
      <?php
																	$sql="select distinct class from brand_mas order by class";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["class"]."'>".$row["class"]."</option>";
                       												}
																?>
    </select></td>
    <td><input type="checkbox" name="act" id="act" /></td>
    <td><select name="cmbtargettype" id="cmbtargettype" onkeypress="keyset('vatgroup_0',event);" class="text_purchase3" onchange="assignbrand();">
      <option value='Normal'>Normal</option>
      <option value='Tyre'>Tyre</option>
      <option value='Battery'>Battery</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  
  <br/>   
<fieldset>               
            
   	<legend><div class="text_forheader">Item Details</div></legend>            
            
  <table width="84%" border="0">
    
  
  <tr>
	<td width="30%" colspan="9">
    <div class="CSSTableGenerator" id="itemdetails" >
<div id="bank_table">
                                       <br>
                                        <table border="1" cellspacing="0">
                                        <?php
										echo "<tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Brand Name</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Class</font></td>
							   <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Active</font></td>
							    <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Target Type</font></td>
                             
   							</tr>";
                           
										
										$sql="select * from brand_mas order by class, barnd_name";
										$result =$db->RunQuery($sql);	
										while ($row = mysql_fetch_array($result)){
											if ($row["barnd_name"]!=""){
											echo "<tr>
                                            	<td width=\"155\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$row["barnd_name"]."</td>
                                            	<td width=\"155\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$row["class"]."</td>
                                           		<td width=\"435\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$row["act"]."</td>";
											
											$target="";	
											if ($row["delinrate"]=="0"){
												$target="Normal";	
											} else if ($row["delinrate"]=="2.5"){
												$target="Tyre";	
											} else if ($row["delinrate"]=="3.5"){
												$target="Battery";	
											}	
													
                                            	echo"<td width=\"150\" onclick=\"bankno('".$row['barnd_name']."', '".$row['class']."', '".$row['act']."', '".$row['delinrate']."');\">".$target."</td>
                                          		</tr>";
												}
										}
										
										?>
                                          
                                        </table>
                                      
                                      </div>   </div>                                                 		</td>
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