
<?php
/* if($_SESSION["login"]!="True")
  {
  header('Location:./index.php');
  } */




/* if($_SESSION["login"]!="True")
  {
  header('Location:./index.php');
  } */




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
    var win = null;
    function NewWindow(mypage, myname, w, h, scroll, pos) {
        if (pos == "random") {
            LeftPosition = (screen.width) ? Math.floor(Math.random() * (screen.width - w)) : 100;
            TopPosition = (screen.height) ? Math.floor(Math.random() * ((screen.height - h) - 75)) : 100;
        }
        if (pos == "center") {
            LeftPosition = (screen.width) ? (screen.width - w) / 2 : 100;
            TopPosition = (screen.height) ? (screen.height - h) / 2 : 100;
        }
        else if ((pos != "center" && pos != "random") || pos == null) {
            LeftPosition = 0;
            TopPosition = 20
        }
        settings = 'width=' + w + ',height=' + h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
        win = window.open(mypage, myname, settings);
    }
// -->
</script>

<script type="text/javascript">
    function openWin()
    {
        myWindow = window.open('serach_inv.php', '', 'width=200,height=100');
        myWindow.focus();

    }
</script>

<script type="text/javascript">
    function load_calader(tar) {
        new JsDatePick({
            useMode: 2,
            target: tar,
            dateFormat: "%Y-%m-%d"

        });

    }

</script>

<script type="text/javascript">
    window.onload = function () {
        new JsDatePick({
            useMode: 2,
            target: "dte_shedule",
            dateFormat: "%Y-%m-%d"
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
        <div class="text_forheader">Defective Report</div>
    </legend>             

    <form id="form1" name="form1" action="report_defective_item.php" target="_blank" method="get">
        <table width="767" border="0">
            <tr>
                <td colspan="2" align="left"><input type="checkbox" name="chkcus" id="chkcus" />
                    Customer Wise</td>
                <td>&nbsp;</td>
                <td><script type="text/javascript">
                    window.onload = function () {
                        new JsDatePick({
                            useMode: 2,
                            target: "dtddate",
                            dateFormat: "%Y-%m-%d"
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
                <td colspan="2" align="left"><table width="274">
                        <tr>
                            <td width="76" align="left"><input type="text"  class="label_purchase" value="Customer" disabled/></td>
                            <td width="186"><input type="text" name="cuscode" id="cuscode" class="text_purchase3"/></td>
                        </tr>
                    </table></td>
                <td width="281"><input type="text" name="cusname" id="cusname" class="text_purchase3"/>
                </td>
                <td width="266"><a href="serach_customer.php?stname=rep_outstand_state" onclick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
                        return false" onfocus="this.blur()">
                        <input type="button" name="searchcust" id="searchcust" value="..."  class="btn_purchase1" />
                    </a></td>
            </tr>
            <tr>
                <td colspan="4" align="left"><input type="text"  class="text_purchase3"  disabled="disabled" id="cus_address" name="cus_address" /></td>
            </tr>
            <tr>
                <td colspan="3" align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" align="left"><table width="991" border="0">
                        <tr>
                            <th scope="col"><input type="radio" name="radio" id="Option1" value="Option1"  onclick="opt12();"  />
                                Option 1</th>
                            <th scope="col"><input type="radio" name="radio" id="Option2" value="Option2" onclick="opt12();"  />
                                Option 2</th>
                            <th colspan="2" scope="col"><input type="radio" name="radio" id="Option3" value="Option3" checked="checked" onclick="opt3();"  />
                                Total Claims</th>
                            <th scope="col"><input type="text"  class="label_purchase" id="Refund" name="Refund" value="Refund" disabled="disabled"/></th>
                            <th colspan="2" scope="col"><select name="cmb_refund" id="cmb_refund" onkeypress="keyset('dte_dor', event);" onchange="refund();" class="text_purchase3">
                                    <option value='Recommended'>Recommended</option>
                                    <option  value='Not Recommended'>Not Recommended</option>
                                    <option selected="selected" value='All'>All</option>
                                </select></th>
                        </tr>
                        <tr>
                            <th width="139" scope="col"><input type="radio" name="radio" id="Option4" value="Option4" onclick="opt12();"  />
                                Summery</th>
                            <th width="145" scope="col"><input type="radio" name="radio" id="Option5" value="Option5" onclick="opt3();"  />Total Claims 2</th>
                            <th width="34" scope="col">&nbsp;</th>
                            <th width="133" scope="col"><input type="radio" name="radio" id="Option6" value="Option5" onclick="opt3();"  />Battry Claims</th>
                            <th width="160" scope="col"><input type="text"  class="label_purchase" value="Not Recommended" id="NotRecommended" name="NotRecommended" disabled="disabled" style="visibility:hidden"/></th>
                            <th width="184" colspan="2" scope="col"><select name="cmb_notreco" id="cmb_notreco" onchange="notrec();"  class="text_purchase3" style="visibility:hidden">
                                    <option value='Allowed'>Allowed</option>
                                    <option value='Not Allowed'>Not Allowed</option>
                                    <option value='All' selected="selected">All</option>
                                </select></th>
                        </tr>
                        <tr>
                            <th width="139" scope="col"><input type="radio" name="radio" id="Option7" value="Option7" onclick="opt3();"  />
                                Total Claim - Rep</th>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><input type="text"  class="label_purchase" value="Approved By" id="ApprovedBy" name="ApprovedBy" disabled="disabled" style="visibility:hidden"/></td>
                            <td colspan="2"><select name="cmb_approv" id="cmb_approv"  class="text_purchase3" style="visibility:hidden;">
                                    <option value='All'>All</option>
                                    <option value='MD'>MD</option>
                                    <option value='WD'>WD</option>

                                </select></td>
                        </tr>
                        <tr>
                            <td><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
                            <td><input type="text" size="20" name="dtfrom" id="dtfrom" value="<?php echo date("Y-m-d"); ?>"  onfocus="load_calader('dtfrom')" class="text_purchase3"/></td>
                            <td>&nbsp;</td>
                            <td><input type="text"  class="label_purchase" value="To" disabled="disabled"/></td>
                            <td><input type="text" size="20" name="dtto" id="dtto" value="<?php echo date("Y-m-d"); ?>" onfocus="load_calader('dtto')" class="text_purchase3"/></td>
                           <td  colspan="2"><input type="checkbox" name="datewise" id="datewise" />Return Date wise</td>
                           <td  colspan="5"><input type="checkbox" name="datewise1" id="datewise1" />None Gate Pass Ent Date wise</td>
                        </tr>

                    </table></td>
            </tr>
            <tr>
                <td colspan="2" align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
            </tr>
			<tr>
			
			    <td height="41"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
    <td colspan="2"><select name="salesrep" id="salesrep" onkeypress="keyset('dte_dor',event);" onchange="setord();" class="text_purchase3">
<option value='All'>All</option>     

	 <?php
																	$sql="select * from s_salrep where cancel='1' order by REPCODE";
																	
																	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
																	while($row = mysqli_fetch_array($result)){
                        												echo "<option value='".$row["REPCODE"]."'>".$row["REPCODE"]." ".$row["Name"]."</option>";
                       												}
																?>
			
			
			
			</tr>
			
            <tr>
                <td width="144" align="left"><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
                <td width="152" align="left"><select name="cmbbrand" id="cmbbrand" onkeypress="keyset('searchitem', event);" class="text_purchase3"  onchange="setord();">
                        <option value="All">All</option>
<?php
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
                <td align="left"><input type="text"  class="label_purchase" value="Stock No" disabled="disabled"/></td>
                <td align="left"><input type="text" size="20" name="stkno" id="stkno" value=""  class="text_purchase3"/></td>
            </tr>
            <tr>
                <td width="144" align="left"><input type="text"  class="label_purchase" value="Type" disabled="disabled"/></td>
                <td width="152" align="left"><select name="cmbtype" id="cmbtype" onkeypress="keyset('searchitem', event);" class="text_purchase3"  onchange="setord();">
                        <option value="All">All</option>
<?php
$sql = "select class from brand_mas where act='1' group by class";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
while ($row = mysqli_fetch_array($result)) {
    echo "<option value='" . $row["class"] . "'>" . $row["class"] . "</option>";
}
?>
                    </select></td>
                <td width="281" align="left"></td>
                <td width="266" align="left"><input type="checkbox" name="detailed" id="detailed" /> 
                    Detailed Report</td>
            </tr>
            <tr>
                <td colspan="2" align="left"></td>
                <td><input type="submit" name="button" id="button" value="View" class="btn_purchase1"/></td>
            </tr>
        </table>
        <fieldset>               


    </form>        



