<?php 
session_start();

/*if($_SESSION["login"]!="True")
{
	header('Location:./index.php');
}*/

	include('header.php'); 

						 
	require_once("config.inc.php");
	require_once("DBConnector.php");
						
	$sql = "delete FROM TMP_EDU_FILTER";
	$db = new DBConnector();
	$result =$db->RunQuery($sql);
						
	$sql = "delete FROM	TMP_QUALI_FILTER";
	$db = new DBConnector();
	$result =$db->RunQuery($sql);
	
	$sqltmp="delete from tmpitem";
	$resulttmp =$db->RunQuery($sqltmp);
?>

<script language="JavaScript" src="js/sel_item.js"></script>

	<style type="text/css">

	/* START CSS NEEDED ONLY IN DEMO */
	html{
		height:100%;
	}
	
	
	#mainContainer{
		width:700px;
		margin:0 auto;
		text-align:left;
		height:100%;
		background-color:#FFF;
		border-left:3px double #000;
		border-right:3px double #000;
	}
	#formContent{
		padding:5px;
	}
	/* END CSS ONLY NEEDED IN DEMO */
	
	
	/* Big box with list of options */
	#ajax_listOfOptions{
		position:absolute;	/* Never change this one */
		width:175px;	/* Width of box */
		height:250px;	/* Height of box */
		overflow:auto;	/* Scrolling features */
		border:1px solid #317082;	/* Dark green border */
		background-color:#FFF;	/* White background color */
		color:#000000;
		
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
    </style>
	
    <style type="text/css">
	body{
		/*
		You can remove these four options 
		
		*/
		background-repeat:no-repeat;
		font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;
		margin:0px;
		

	}
	#ad{
		padding-top:220px;
		padding-left:10px;
	}
</style>
    
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

<link rel="stylesheet" type="text/css" href="css/stylecalander.css" />

<link href="css/dropdown/themes/verticle/helper.css" media="screen" rel="stylesheet" type="text/css" />
<link href="css/dropdown/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="css/dropdown/themes/verticle/default.ultimate.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style5 {color: #FFF}
-->
</style>


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
	
<body onLoad="evnt_onload();"> 

<div id="content">
	<div class="post">
    	<br>
		<h2 class="title" style="color: #FFFFFF"><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stock Report </h2>
        <div class="entry">
          <label class="form-lable" id="label_1" for="input_1">
          </label>
          <form id="form1" name="form1" action="report_stock.php" method="get">
            <table width="765" border="0" cellpadding="0">
            	<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">              			
            				<table width="786" height="547" border="0" cellpadding="0" class="bcgl1">
                  				<tr height="20">
                    				<th colspan="16" valign="top">
                    					<table width="767" border="0">
       						  <tr>
                      							<td width="274" align="left">
                                               	  <table width="274">
                                               		<tr>
                                               		  <td width="76" align="left">Brand</td>
                                                    		<td width="186">
                                                            	<select name="brand" id="brand" onKeyPress="keyset('brand',event);" onChange="setord();" class="txtbox">
                                                    				<option value='All'>All</option>
                                                          <?php
																	$sql="select * from brand_mas order by barnd_name";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["barnd_name"]."'>".$row["barnd_name"]."</option>";
                       												}
																?>
                                                    			</select>
                                                      </td>
                                                  		</tr>
                                               	  </table>
                                                </td>
                      							<td width="173">
                                               	  <table>
                                               		<tr>
                                               		  <td width="80" align="left">Department</td>
                                                    		<td>
                                                            	<select name="department" id="department" onKeyPress="keyset('brand',event);" onChange="setord();" class="txtbox">
                                                    				<option value='All'>All</option>
                                                        <?php
																	$sql="select * from s_stomas order by CODE";
																	$result =$db->RunQuery($sql);
																	while($row = mysql_fetch_array($result)){
                        												echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
                       												}
																?>
                                                      			</select>                                                    
                                                      </td>
                                                  		</tr>
                                               	  </table>
                                                </td>
           						        <td width="306">
                                       	  <table>
                                       		<tr>
                                       		  <td width="80" align="left">Type</td>
                                                    		<td>
                                                            	<select name="stype" id="stype" onKeyPress="keyset('brand',event);" class="txtbox">																	<option value='Cost'>Cost</option>
                                                        			<option value='Selling'>Selling</option>
                                                        			<option value='Print'>Print</option>
                                                        
                       											</select>
                                              </td>
                                                  		</tr>
                                       	  </table>
                                                </td>
									  	  </tr>
                                         	<tr>
                      							<td width="274" align="left"></td>
               							        <td colspan="2">&nbsp;</td>
                                       	  	</tr>
                                            <tr>
                      							<td width="274" align="left"></td>
                   							  	<td colspan="2">
                                                	<table>
                                                		<tr>
                                                  			<td><label></label></td>
                                                		</tr>
                                              		</table>
                                                </td>
                      						</tr>
                      
                        					<tr>
                      							<td width="274" align="left">
                                            <fieldset>
                                                	<legend><font color="#00FF00"><input type="checkbox" name="chkitem" id="chkitem">
                                                	Select Items</font></legend>  
                                                    <input type="checkbox" name="chkall" id="chkall">
                                       All Items<br>
                                                    <?php
                                                    echo "<select multiple=\"multiple\" name=\"available\" id=\"available\" size=20>";
													
													$sql="select STK_NO, DESCRIPT from s_mas order by STK_NO";
													$result =$db->RunQuery($sql);
													while($row = mysql_fetch_array($result)){
            										 	
 														echo "<option id=".$row["STK_NO"]." value=".$row["STK_NO"]." ondblclick=\"sel_one('".$row['STK_NO']."');\">".$row["STK_NO"]." ".$row["DESCRIPT"]."</option>";		
													}
          											echo "</select>";
													
													?>
                                                    
                                                
                                               		</fieldset> 
                                                </td>
               						          	<td colspan="2">
                                                <fieldset>
                                              		<legend><font color="#FFFF00">Selected Items</font></legend> 
                                              			<div id="availab"><br>
                                              				<select multiple="multiple" name="selectedit" id="selectedit" size=20>";
													
											  				</select>
                                              			</div>
                                              		
                                                   </fieldset>   
                                              	</td>
                       					  	</tr>
              
                          				   <tr>
                      							<td width="274" align="left">
                         							<table>
                                                    	<tr>
                        									<td width="60" align="left"></td>
                        									<td></td>
                      									</tr>
                                                    </table>                      							</td>
                   							 <td colspan="2">&nbsp;</td>
                                   		  </tr>
                      
                          					<tr>
                      							<td width="274" align="left"></td>
                   							  <td colspan="2"><input type="submit" name="button" id="button" value="View"></td>
                      						</tr>
                    					</table>
                                  </th>
                  				</tr>
   
   
                     
                    
                    			<th colspan="16" valign="top"><br>
                                	
                                </th>
                             
                        		<tr>
                                	<td>&nbsp;</td>
                              </tr>
                    		</table>
                        </div>
                    </th>
                </tr>
               
                  
                  
                
                 
          
          		</table>
                </form>
            </div>
  </div>
    </div>
</div>
</body>
 <?php //include('footer1.php'); ?>