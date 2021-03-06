<?php  session_start();
$_SESSION["brand"]="";
$_SESSION["bin_item"]="";
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

</label>
          
<fieldset>
                                                	<legend>
  <div class="text_forheader">Enter Order Details</div>
                                               	 </legend>             

<form name="form1" id="form1">            
  <table width="100%" border="0"  class=\"form-matrix-table\">
  <tr>
    <td colspan="8">
    <table width="866" border="0">
                                  <tr>
                                    <td width="60"><input type="text"  class="label_purchase" value="Jan" disabled/></td>
                                    <td width="60"><input type="text"  class="label_purchase" value="Feb" disabled/></td>
                                    <td width="60"><input type="text"  class="label_purchase" value="Mar" disabled/></td>
                                    <td width="60"><input type="text"  class="label_purchase" value="Apr" disabled/></td>
                                    <td width="60"><input type="text"  class="label_purchase" value="May" disabled/></td>
                                    <td width="61"><input type="text"  class="label_purchase" value="Jun" disabled/></td>
                                    <td width="61"><input type="text"  class="label_purchase" value="Jul" disabled/></td>
                                    <td width="61"><input type="text"  class="label_purchase" value="Aug" disabled/></td>
                                    <td width="60"><input type="text"  class="label_purchase" value="Sep" disabled/></td>
                                    <td width="60"><input type="text"  class="label_purchase" value="Oct" disabled/></td>
                                    <td width="60"><input type="text"  class="label_purchase" value="Nov" disabled/></td>
                                    <td width="61"><input type="text"  class="label_purchase" value="Dec" disabled/></td>
                                    <td width="60"><input type="text"  class="label_purchase" value="Avg" disabled/></td>
                                  </tr>
                                  <tr>
                                    <td><font color="#FFFFFF">
                                      <input type="text" class="text_purchase3" name="sal1" id="sal1" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                    <td><font color="#FFFFFF">
                                      <input type="text"  class="text_purchase3" name="sal2" id="sal2" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                    <td><font color="#FFFFFF">
                                      <input type="text"  class="text_purchase3" name="sal3" id="sal3" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                    <td><font color="#FFFFFF">
                                      <input type="text"  class="text_purchase3" name="sal4" id="sal4" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                    <td><font color="#FFFFFF">
                                      <input type="text"  class="text_purchase3" name="sal5" id="sal5" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                    <td><font color="#FFFFFF">
                                      <input type="text"  class="text_purchase3" name="sal6" id="sal6" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                    <td><font color="#FFFFFF">
                                      <input type="text"  class="text_purchase3" name="sal7" id="sal7" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                    <td><font color="#FFFFFF">
                                      <input type="text"  class="text_purchase3" name="sal8" id="sal8" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                    <td><font color="#FFFFFF">
                                      <input type="text"  class="text_purchase3" name="sal9" id="sal9" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                    <td><font color="#FFFFFF">
                                      <input type="text"  class="text_purchase3" name="sal10" id="sal10" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                    <td><font color="#FFFFFF">
                                      <input type="text"  class="text_purchase3" name="sal11" id="sal11" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                    <td><font color="#FFFFFF">
                                      <input type="text"  class="text_purchase3" name="sal12" id="sal12" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                    <td><font color="#FFFFFF">
                                      <input type="text"  class="text_purchase3" name="avg" id="avg" size="10"  onKeyPress="keyset('itemd',event);"     />
                                    </font></td>
                                  </tr>
      </table>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%"><a href="serach_ord.php?stname=ord" onclick="NewWindow(this.href,'mywin','800','700','yes','center');return false" onfocus="this.blur()"></a></td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Item Code" disabled/></td>
    <td><input type="text" class="text_purchase2" name="invno" id="invno" onblur="itno1();" onkeypress="keyset('department',event);" />
      <a href="" onClick="NewWindow('serach_item_bin.php','mywin','800','700','yes','center');return false" onFocus="this.blur()">
        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase1">
      </a></td>
    <td><input type="text"  class="label_purchase" value="Item Name" disabled="disabled"/></td>
    <td colspan="3"><input type="text" size="15" name="itemname" id="itemname" value=""  class="text_purchase3" /></td>
    <td colspan="2" rowspan="2" align="center"><div id="day90"></div></td>
    <td colspan="2" rowspan="2" align="center"><div id="qtyinahand1"></div></td>
	<td colspan="2" rowspan="2" align="center"><div id="active_t"></div></td>
	
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Part No" disabled="disabled"/></td>
    <?php
	require_once("connectioni.php");
	
	
	
	$sqlt="Select * from invpara";
	$resultt =mysqli_query($GLOBALS['dbinv'],$sqlt) ; 
	$rowt = mysqli_fetch_array($resultt);
		
	?>
    <td><input type="text" size="15" name="partno" id="partno" value=""  class="text_purchase3" /></td>
    <td><input type="text"  class="label_purchase" value="From" disabled="disabled"/></td>
    <td><input type="text" size="20" name="dte_from" id="dte_from" value="<?php echo $rowt["last_invdata"]; ?>" disabled="disabled" class="text_purchase3"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text"  class="label_purchase" value="Department" disabled="disabled"/></td>
    <td><select name="department" id="department"    onkeypress="keyset('brand',event);" onblur="itno1();" class="text_purchase3">
      <option value='All'>All</option>
      <?php
	  
																	$sql="select * from s_stomas order by CODE";
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["CODE"]."'>".$row["CODE"]." ".$row["DESCRIPTION"]."</option>";
                       												}
																?>
    </select></td>
    <td><input type="text"  class="label_purchase" value="Selling" disabled="disabled"/></td>
    <td colspan="2" rowspan="2"><label>
      <input type="text" size="15" name="selling" id="selling" value=""  class="text_purchase_l" />
    </label></td>
    <td><label></label></td>
    <td colspan="2" rowspan="2" align="center"><div id="unsold"></div></td>
    <td colspan="2" rowspan="2" align="center"><div id="qtyinhand"></div></td>
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
            
  
            
  <table width="84%" border="0">
  
  <tr>
	<td colspan="4">                                             		</td>
                                                		</tr>
  
  <tr>
    <td width="6%">&nbsp;</td>
    <td width="71%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td width="17%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="2" valign="top">
                                                                    <table width="707" border="0" class=\"form-matrix-table\">
                                                                        <tr><td><div class="CSSTableGenerator"><table><tr>
                        	<td width="100"  background="images/headingbg.gif" ><font color="#FFFFFF">Ref No</font></td>
                            <td width="79"  background="images/headingbg.gif"><font color="#FFFFFF">Date</font></td>
                            <td width="130"  background="images/headingbg.gif"><font color="#FFFFFF">Document Type</font></td>
                            <td width="75"  background="images/headingbg.gif"><font color="#FFFFFF">Stk In</font></td>
                            <td width="90"  background="images/headingbg.gif"><font color="#FFFFFF">Stk Out</font></td>
                            <td width="121"  background="images/headingbg.gif"><font color="#FFFFFF">Stk Bal</font></td>
                        </tr></table></div></td></tr>
                                                                        
                                                                        
                                                                        <tr>
                                                                          <td width="707" colspan="5" ><div class="CSSTableGenerator" id="itemdetails" style="overflow:scroll;  height:300px" > <table>
                                                                              <tr>
                                                                                <td width="100"  background="images/headingbg.gif" ><font color="#FFFFFF">Ref No</font></td>
                                                                                <td width="79"  background="images/headingbg.gif"><font color="#FFFFFF">Date</font></td>
                                                                                <td width="130"  background="images/headingbg.gif"><font color="#FFFFFF">Document Type</font></td>
                                                                                <td width="75"  background="images/headingbg.gif"><font color="#FFFFFF">Stk In</font></td>
                                                                                <td width="119"  background="images/headingbg.gif"><font color="#FFFFFF">Stk Out</font></td>
                                                                                <td width="121"  background="images/headingbg.gif"><font color="#FFFFFF">Stk Bal</font></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                             
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                              
                                                                          </table></div></td>
                                                                        </tr>
                                                                      </table>
                                                                  </div></td>
    <td colspan="2" rowspan="2" valign="top">  <div id="stock_det" class="CSSTableGenerator" style="width:200px; float: left; overflow:scroll;  height:500px">
                                                                
                                                                    <table>
                                                                        <tr>
                                                                          <td width="122"  background="images/headingbg.gif" ><font color="#FFFFFF">Department</font></td>
                                                                          <td width="101"  background="images/headingbg.gif"><font color="#FFFFFF">Stock</font></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td width="122" ></td>
                                                                          <td width="101"></td>
                                                                        </tr>
                                                                    </table>
                   		                    		          </div>      </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
    <div id="it" style="width:710px; height:100px; float: left; overflow-x:hidden">
                                                                        <table width="679" border="0" class=\"form-matrix-table\">
                                                                          <tr>
                                                                            <td width="673" colspan="5" >
                                                                            
                                                                            <div class="CSSTableGenerator" id="orddetails"  style="overflow:scroll;  height:300px" >
                                                                            <table>
                                                                                <tr>
                                                                                  <td width="52"  background="images/headingbg.gif" ><font color="#FFFFFF">Ref No</font></td>
                                                                                  <td width="79"  background="images/headingbg.gif"><font color="#FFFFFF">Ord Date</font></td>
                                                                                  <td width="130"  background="images/headingbg.gif"><font color="#FFFFFF">Schedule Date</font></td>
                                                                                  <td width="75"  background="images/headingbg.gif"><font color="#FFFFFF">Qty</font></td>
                                                                                  <td width="119"  background="images/headingbg.gif"><font color="#FFFFFF">LC No</font></td>
                                                                                  <td width="121"  background="images/headingbg.gif"><font color="#FFFFFF">Supplier</font></td>
                                                                                </tr>
                                                                                 <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                               <tr>
                                                                              	<td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                              </tr>
                                                                            </table>
                                                                            </div>                                                                            </td>
                                                                          </tr>
                                                                        </table>
                                                                  </div>    </td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="2" rowspan="5"><div id="storgrid"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>
          

</form>        

</fieldset>    
            
            <table width="765" border="0" cellpadding="0">
<tr>
                	<th height="189" colspan="5" align="left" nowrap="nowrap">
              			<div align="left">