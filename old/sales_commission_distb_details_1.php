<?php
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
    window.onload = function () {
        new JsDatePick({
            useMode: 2,
            target: "dte_dor",
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

</label><fieldset>
    <legend>
        <div class="text_forheader">Balance Commission - Distribution</div>
    </legend>             

    <form name="form1" id="form1">  
        <table border="1"><tr><td width="1301">         
                    <table width="100%" border="0"  class=\"form-matrix-table\">
                        <tr>
                            <td width="10%"><input type="hidden" name="txt_stat" id="txt_stats" /></td>
                            <td width="10%">&nbsp;</td>
                            <td width="10%">&nbsp;</td>
                            <td width="10%">&nbsp;</td>
                            <td width="10%">&nbsp;</td>
                            <td width="10%">&nbsp;</td>
                            <td width="10%"><input type="text" disabled="disabled" name="dttmpda" id="dttmpda" value="<?php echo "2011-04-29"; ?>" class="text_purchase3" onkeypress="keyset('searchcust', event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  /></td>
                            <td width="10%">&nbsp;</td>
                            <td width="10%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><input type="text"  class="label_purchase" value="Month" disabled="disabled"/></td>
                            <td>
                                <input type="text" name="dtMonth" id="dtMonth" class="text_purchase3"/>
                                <script type="text/javascript">
                                    window.onload = function () {
                                        new JsDatePick({
                                            useMode: 2,
                                            target: "dtMonth",
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
                            <td> <a href="serach_rec.php?stname=cash_rec" onClick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
                                    return false" onFocus="this.blur()"></a></td>
                            <td><input type="text"  class="label_purchase" value="Sales Excecutive" disabled="disabled"/></td>
                            <td><select name="cmbrep" id="cmbrep" onkeypress="keyset('dte_dor', event);" onchange="setord();" class="text_purchase3">
                                    <?php
                                    $sql = "select * from s_salrep order by REPCODE";
                                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
                                    }
                                    ?>
                                </select></td>
                            <td><select name="cmbdev" id="cmbdev" onkeypress="keyset('searchitem', event);" class="text_purchase3"  onchange="setord();">
                                    <?php
                                    if ($_SESSION['dev'] == "1") {
                                        echo "<option value=\"0\">Office Sale</option>
                		<option value=\"1\">Van Sale</option>";
                                    } else if ($_SESSION['dev'] == "0") {
                                        echo "<option value=\"0\">Office Sale</option>";
                                    }
                                    ?>  
                                </select></td>
                            <td><input type="text"  class="label_purchase" value="Vat Rate" disabled="disabled"/></td>
                            <td><a href="serach_customer.php?stname=ret_chq_settle" onclick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
                                    return false" onfocus="this.blur()">
                                    <input type="text" name="txtvat" id="txtvat" value="11" class="text_purchase3"   />
                                </a></td>
                            <td> <a href="serach_customer.php?stname=ret_chq_settle" onClick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
                                    return false" onFocus="this.blur()"></a></td>
                        </tr>
                    </table>


                    <br/>   









                    <fieldset>               
                        <legend><div class="text_forheader">Sales Commission Balance</div></legend>
                        <fieldset> 
                            <legend><div class="text_forheader">Batteries</div></legend>
                            <table><tr>
                                    <td width="446"><table width="446" border="0">
                                            <tr>
                                                <td width="144"></th>
                                                <td width="144">
                                                    <input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></td>
                                                <td width="144">
                                                    <input type="text"  class="label_purchase" value="Sales" disabled="disabled"/>  </td>         </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Tar 1" disabled="disabled" id="Critaria_gridA10" name="Critaria_gridA01"/></td>
                                                <td><input type="text" size="20" name="Critaria_gridA11" id="Critaria_gridA11" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text" size="20" name="Critaria_gridA12" id="Critaria_gridA12" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Tar 2" disabled="disabled" id="Critaria_gridA20" name="Critaria_gridA02"/></td>
                                                <td><input type="text" size="20" name="Critaria_gridA21" id="Critaria_gridA21" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text" size="20" name="Critaria_gridA22" id="Critaria_gridA22" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Base" disabled="disabled" id="Critaria_gridA30" name="Critaria_gridA03" /></td>
                                                <td><input type="text" size="20" name="Critaria_gridA31" id="Critaria_gridA31" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text" size="20" name="Critaria_gridA32" id="Critaria_gridA32" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>
                                        </table></td>
                                    <td width="34">&nbsp;</td>
                                    <td width="801">&nbsp;<table width="740" border="0">
                                            <tr>
                                                <th width="144" scope="col"><input type="text"  class="label_purchase" value="Total Sale (With VAT)" disabled="disabled"/></th>
                                                <th width="144" scope="col"><input type="text" size="20" name="Sales_gridA11" id="Sales_gridA11" value="" disabled="disabled" class="text_purchase3"/></th>
                                                <th width="144" scope="col"><input type="text"  class="label_purchase" value="Outstandings" disabled="disabled"/></th>
                                                <th width="144" scope="col"><input type="text" size="20" name="Sales_gridA12" id="Sales_gridA12" value="" disabled="disabled" class="text_purchase3"/></th>
                                            </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Return (With VAT)" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridA21" id="Sales_gridA21" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text"  class="label_purchase" value="Cat 1 Payments" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridA22" id="Sales_gridA22" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text" size="20" name="Sales_gridA23" id="Sales_gridA23" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Net Sale (With VAT)" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridA31" id="Sales_gridA31" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text"  class="label_purchase" value="Cat 2 Payments" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridA32" id="Sales_gridA32" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text" size="20" name="Sales_gridA33" id="Sales_gridA33" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Net Sale (W/O VAT)" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridA41" id="Sales_gridA41" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text"  class="label_purchase" value="No Com Payments" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridA42" id="Sales_gridA42" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text" size="20" name="Sales_gridA43" id="Sales_gridA43" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Paid Amount" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridA51" id="Sales_gridA51" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text"  class="label_purchase" value="Group No Com%" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridA52" id="Sales_gridA52" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>       

                                        </table></td></tr></table>
                        </fieldset>
                        <br />
                        <fieldset> 
                            <legend><div class="text_forheader">Tyres & A/Wheels</div></legend>
                            <table><tr>
                                    <td width="446"><table width="446" border="0">
                                            <tr>
                                                <td width="144"></th>
                                                <td width="144">
                                                    <input type="text"  class="label_purchase" value="Amount" disabled="disabled"/></td>
                                                <td width="144">
                                                    <input type="text"  class="label_purchase" value="Sales" disabled="disabled"/>  </td>         </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Tar 1" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Critaria_gridB11" id="Critaria_gridB11" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text" size="20" name="Critaria_gridB12" id="Critaria_gridB12" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Tar 2" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Critaria_gridB21" id="Critaria_gridB21" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text" size="20" name="Critaria_gridB22" id="Critaria_gridB22" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Base" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Critaria_gridB31" id="Critaria_gridB31" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text" size="20" name="Critaria_gridB32" id="Critaria_gridB32" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>
                                        </table></td>
                                    <td width="34">&nbsp;</td>
                                    <td width="801">&nbsp;<table width="740" border="0">
                                            <tr>
                                                <th width="144" scope="col"><input type="text"  class="label_purchase" value="Total Sale (With VAT)" disabled="disabled"/></th>
                                                <th width="144" scope="col"><input type="text" size="20" name="Sales_gridB11" id="Sales_gridB11" value="" disabled="disabled" class="text_purchase3"/></th>
                                                <th width="144" scope="col"><input type="text"  class="label_purchase" value="Outstandings" disabled="disabled"/></th>
                                                <th width="144" scope="col"><input type="text" size="20" name="Sales_gridB12" id="Sales_gridB12" value="" disabled="disabled" class="text_purchase3"/></th>
                                            </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Return (With VAT)" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridB21" id="Sales_gridB21" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text"  class="label_purchase" value="Cat 1 Payments" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridB22" id="Sales_gridB22" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text" size="20" name="Sales_gridB23" id="Sales_gridB23" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Net Sale (With VAT)" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridB31" id="Sales_gridB31" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text"  class="label_purchase" value="Cat 2 Payments" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridB32" id="Sales_gridB32" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text" size="20" name="Sales_gridB33" id="Sales_gridB33" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Net Sale (W/O VAT)" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridB41" id="Sales_gridB41" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text"  class="label_purchase" value="No Com Payments" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridB42" id="Sales_gridB42" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text" size="20" name="Sales_gridB43" id="Sales_gridB43" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text"  class="label_purchase" value="Paid Amount" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridB51" id="Sales_gridB51" value="" disabled="disabled" class="text_purchase3"/></td>
                                                <td><input type="text"  class="label_purchase" value="Group No Com%" disabled="disabled"/></td>
                                                <td><input type="text" size="20" name="Sales_gridB52" id="Sales_gridB52" value="" disabled="disabled" class="text_purchase3"/></td>
                                            </tr>       

                                        </table></td></tr></table>
                        </fieldset>
                        <br />
                        <table><tr><td>
                                    <fieldset> 
                                        <legend><div class="text_forheader">Total Sales Summery</div></legend>
                                        <table><tr>
                                                <td width="298" valign="top"><table width="298" border="0">

                                                        <tr>
                                                            <td width="144"><input type="text"  class="label_purchase" value="Total Sales" disabled="disabled"/></td>
                                                            <td width="144"><input type="text" size="20" name="totsal_grid11" id="totsal_grid11" value="" disabled="disabled" class="text_purchase3"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text"  class="label_purchase" value="Total GRN" disabled="disabled"/></td>
                                                            <td><input type="text" size="20" name="totsal_grid21" id="totsal_grid21" value="" disabled="disabled" class="text_purchase3"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text"  class="label_purchase" value="Total No Comm." disabled="disabled"/></td>
                                                            <td><input type="text" size="20" name="totsal_grid31" id="totsal_grid31" value="" disabled="disabled" class="text_purchase3"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text"  class="label_purchase" value="Total No Comm. %" disabled="disabled"/></td>
                                                            <td><input type="text" size="20" name="totsal_grid41" id="totsal_grid41" value="" disabled="disabled" class="text_purchase3"/></td>
                                                        </tr>
                                                    </table></td>
                                            </tr></table>
                                    </fieldset>
                                </td><td rowspan="10">
									<div class="CSSTableGenerator" id="msgrid"></div> 				
                                </td>


                            </tr></table>
                        <table width="94%" border="0">

                            <tr>
                                <td width="68%"><table width="1124" border="0">
										<input type="hidden" name="grngrid" id="grngrid" />		
                                        <tr>
                                            <td colspan="2"><input type="text"  class="label_purchase" value="Other Deductions" disabled="disabled"/></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td >
                                                    </td>
                                            <td><input type="button" onclick="grnhistory();" class="" value="GRN History" id="com_view11" name="com_view11"></td>
                                            <td><input type="button" onclick="savegrn();" class="btn_purchase2" value="Save" id="com_view5" name="com_view5"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><input type="text" size="20" name="Deduction_grid11" id="Deduction_grid11" value="Security Deposit" class="text_purchase3"/></td>
                                            <td width="14%"><input type="text" size="20" name="Deduction_grid12" id="Deduction_grid12" value="" class="text_purchase3"/></td>
                                            <td width="4%"><input type="text" size="20" name="Deduction_grid13" id="Deduction_grid13" value="" class="text_purchase3"/></td>
                                            <td width="2%">&nbsp;</td>
                                            <td width="6%">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><input type="text" size="20" name="Deduction_grid21" id="Deduction_grid21" value="Advance" class="text_purchase3"/></td>
                                            <td><input type="text" size="20" name="Deduction_grid22" id="Deduction_grid22" value="" class="text_purchase3"/></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><input type="text" size="20" name="Deduction_grid31" id="Deduction_grid31" value="" class="text_purchase3"/></td>
                                            <td><input type="text" size="20" name="Deduction_grid32" id="Deduction_grid32" value="" class="text_purchase3"/></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><input type="text" size="20" name="Deduction_grid41" id="Deduction_grid41" value="" class="text_purchase3"/></td>
                                            <td><input type="text" size="20" name="Deduction_grid42" id="Deduction_grid42" value="" class="text_purchase3"/></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><input type="text" size="20" name="Deduction_grid51" id="Deduction_grid51" value="" class="text_purchase3"/></td>
                                            <td><input type="text" size="20" name="Deduction_grid52" id="Deduction_grid52" value="" class="text_purchase3"/></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><input type="text" size="20" name="Deduction_grid61" id="Deduction_grid61" value="" class="text_purchase3"/></td>
                                            <td><input type="text" size="20" name="Deduction_grid62" id="Deduction_grid62" value="" class="text_purchase3"/></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><input type="text" size="20" name="Deduction_grid71" id="Deduction_grid71" value="" class="text_purchase3"/></td>
                                            <td><input type="text" size="20" name="Deduction_grid72" id="Deduction_grid72" value="" class="text_purchase3"/></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><input type="text" size="20" name="Deduction_grid81" id="Deduction_grid81" value="" class="text_purchase3"/></td>
                                            <td><input type="text" size="20" name="Deduction_grid82" id="Deduction_grid82" value="" class="text_purchase3"/></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr>
                                            <td width="6%">&nbsp;</td>
                                            <td width="15%">&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td><input type="button" onclick="calculation();" class="" value="Calculation" id="com_view6" name="com_view6"></td>
                                        </tr>
                                        <tr>
                                            <td width="6%" colspan="8"><table width="1121" border="0">
                                                    <tr>
                                                        <th width="144" scope="col"><input type="text"  class="label_purchase" value="Balance Commision" disabled="disabled"/></th>
                                                        <th width="5" scope="col">-</th>
                                                        <th width="144" scope="col"><input type="text"  class="label_purchase" value="GRN Comm" disabled="disabled"/></th>
                                                        <th width="9" scope="col">=</th>
                                                        <th width="144" scope="col"><input type="text"  class="label_purchase" value="Other Deduction " disabled="disabled"/></th>
                                                        <th width="9" scope="col">=</th>
                                                        <th width="144" scope="col"><input type="text"  class="label_purchase" value="Payable Comm" disabled="disabled"/></th>
                                                         
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" size="20" name="txt_cadv" id="txt_cadv" value="" disabled="disabled" class="text_purchase3"/></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" size="20" name="txt_rded" id="txt_rded" value="" disabled="disabled" class="text_purchase3"/></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" size="20" name="txt_adv" id="txt_adv" value="" disabled="disabled" class="text_purchase3"/></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" size="20" name="txt_radv" id="txt_radv" value="" disabled="disabled" class="text_purchase3"/></td>
                                                         
                                                    </tr>
                                                </table></td>
                                        </tr>
                                    </table></td>
                            </tr>

                        </table>





                    </fieldset>
                </td></tr><tr>
                <td width="8" valign="top">&nbsp;</td>
            </tr>

        </table>
    </form>        

</fieldset>    

