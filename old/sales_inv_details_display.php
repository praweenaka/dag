<?php
require_once("connectioni.php");
?>	






<link rel="stylesheet" href="css/table.css" type="text/css"/>	





</label>

<fieldset>
    <legend>
        <div class="text_forheader">Enter Order Details</div>
    </legend>    

    <?php
    include_once("connectioni.php");


    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_salma where REF_NO='" . $_GET["refno"] . "'") or die(mysqli_error());
    $row = mysqli_fetch_array($sql);
    ?>                                                       

    <input type="hidden" name="cmd_print" id="cmd_print" value="1" />
    <form name="form1" id="form1">            
        <table width="100%" border="0"  class=\"form-matrix-table\">
            <tr>

                <?php
                if ($row['TYPE'] == "CR") {
                    echo "<td width=\"10%\" bgcolor=\"#00CCCC\"><label><input type=\"radio\" name=\"paymethod\" value=\"credit\" id=\"paymethod_0\" checked=\"checked\" />
      Credit</label></td>";
                    echo "<td width=\"10%\"  bgcolor=\"#00CCCC\"><label>
      <input type=\"radio\" name=\"paymethod\" value=\"cash\" id=\"paymethod_1\" />
      Cash</label></td>";
                } else if ($row['TYPE'] == "CA") {
                    echo "<td width=\"10%\" bgcolor=\"#00CCCC\"><label><input type=\"radio\" name=\"paymethod\" value=\"credit\" id=\"paymethod_0\"  />
      Credit</label></td>";
                    echo "<td width=\"10%\"  bgcolor=\"#00CCCC\"><label>
      <input type=\"radio\" name=\"paymethod\" value=\"cash\" id=\"paymethod_1\" checked=\"checked\"/>
      Cash</label></td>";
                }
                ?>


                <td width="10%">&nbsp;</td>
                <td width="10%"><input type="text"  class="label_purchase" value="Sales Order No" disabled="disabled"/></td>
                <td width="10%"><input type="text" disabled="disabled" name="salesord1" id="salesord1" value="<?php echo $row['ORD_NO']; ?>" class="text_purchase3" onkeypress="keyset('searchcust', event);" onfocus="got_focus('invno');"  onblur="lost_focus('invno');"  />     </td>
                <td width="10%">&nbsp;</td>
                <td width="10%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
                <td width="10%"><input type="text" size="20" name="invdate" id="invdate" value="<?php echo $row['SDATE']; ?>" disabled="disabled" class="text_purchase3"/></td>
                <td width="10%">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3"><input type="hidden" name="hiddencount" id="hiddencount" /></td>
                <td><input type="text"  class="label_purchase" value="Delivery Date" disabled="disabled"/></td>
                <td><input type="text" size="20" name="deli_date" id="deli_date" value="<?php echo $row['deli_date']; ?>" disabled="disabled" class="text_purchase3"/></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><input type="text"  class="label_purchase" value="Invoice No" disabled/></td>
                <td colspan="3"><input type="text" disabled="disabled"  class="text_purchase" name="invno" id="invno" value="<?php echo $_GET["refno"]; ?>"/>
                    <a href="serach_inv.php?stname=inv_mast" onClick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
                            return false" onFocus="this.blur()">
                        <input type="hidden" name="txtdono" id="txtdono" />
                    </a></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><input type="text"  class="label_purchase" value="Customer" disabled/></td>
                <td colspan="3"><input type="text"  class="text_purchase1" name="firstname_hidden" id="firstname_hidden" disabled="disabled"   value="<?php echo $row['C_CODE']; ?>"/>
                    <?php
                    $sqlcustomer = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $row['C_CODE'] . "'") or die(mysqli_error());
                    $rowcustomer = mysqli_fetch_array($sqlcustomer);
                    ?>				

                    <input type="text" disabled="disabled"  class="text_purchase2" id="firstname" name="firstname" value="<?php echo $row['CUS_NAME']; ?>" /></td>
                <td><input type="text"  class="label_purchase" value="Credit Limit" disabled/></td>
                <td><input type="text" size="15" name="creditlimit" id="creditlimit" value="0" onkeypress="keyset('balance', event);" class="text_purchase3" disabled="disabled"/></td>
                <td><input type="text"  class="label_purchase" value="Balance" disabled="disabled"/></td>
                <td><input type="text" size="15" name="balance" id="balance" disabled="disabled" value="0" onkeypress="keyset('department', event);" class="text_purchase3"/></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><input type="text"  class="label_purchase" value="Address" disabled/></td>
                <?php
                if (trim($row['C_ADD1']) != "") {
                    $address = $row['C_ADD1'];
                } else {
                    $address = $rowcustomer['ADD1'] . " " . $rowcustomer['ADD2'];
                }
                ?>	
                <td colspan="2"><input type="text"  class="text_purchase4"  disabled="disabled" id="cus_address" name="cus_address" value="<?php echo $address; ?>" /></td>
                <td>&nbsp;</td>
                <td><input type="text"  class="label_purchase" value="Department" disabled/></td>
                <?php
                $sqldep = mysqli_query($GLOBALS['dbinv'], "Select * from s_stomas where CODE='" . $row['DEPARTMENT'] . "'") or die(mysqli_error());
                $rowdep = mysqli_fetch_array($sqldep);
                $department = $rowdep["CODE"] . " " . $rowdep["DESCRIPTION"];
                ?>
                <td><input type="text" disabled="disabled"  class="text_purchase2" id="department" name="department" value="<?php echo $department; ?>" /> </td>
                <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
                <td><input type="text" disabled="disabled"  class="text_purchase2" id="brand" name="brand" value="<?php echo $row['Brand']; ?>" />   </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><input type="text"  class="label_purchase" value="VAT No" disabled="disabled"/></td>
                <td><input type="text" size="20" name="vat1" id="vat1" disabled="disabled" value="<?php echo $rowcustomer['vatno']; ?>" onkeypress="keyset('vat2', event);" class="text_purchase3"/></td>
                <td><input type="text" size="20" name="vat2" id="vat2" disabled="disabled" value="<?php echo $rowcustomer['svatno']; ?>" onkeypress="keyset('salesrep', event);" class="text_purchase3"/></td>
                <td>&nbsp;</td>
                <td bgcolor="#00CCCC"><label>
                        <?php
                        if (trim($row['VAT']) == "1" and $row['SVAT']==0) {
                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"vat\" id=\"vatgroup_0\"  checked=\"checked\" />VAT Invoice</label></td><td bgcolor=\"#00CCCC\"><label>";
                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"non\" id=\"vatgroup_1\"  /> Non VAT Invoice</label></td>
    <td bgcolor=\"#00CCCC\"><label>";
                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"svat\" id=\"vatgroup_2\" />SVAT Invoice</label></td>
    <td bgcolor=\"#00CCCC\"><label>";
                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"evat\" id=\"vatgroup_3\"  />EVAT Invoice</label>";
                        } else if ($row['SVAT'] > 0) {

                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"vat\" id=\"vatgroup_0\"   />VAT Invoice</label></td><td bgcolor=\"#00CCCC\"><label>";
                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"non\" id=\"vatgroup_1\"  /> Non VAT Invoice</label></td>
    <td bgcolor=\"#00CCCC\"><label>";
                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"svat\" id=\"vatgroup_2\" checked=\"checked\" />SVAT Invoice</label></td>
    <td bgcolor=\"#00CCCC\"><label>";
                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"evat\" id=\"vatgroup_3\"  />EVAT Invoice</label>";
                        } else {

                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"vat\" id=\"vatgroup_0\"   />VAT Invoice</label></td><td bgcolor=\"#00CCCC\"><label>";
                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"non\" id=\"vatgroup_1\" checked=\"checked\" /> Non VAT Invoice</label></td>
    <td bgcolor=\"#00CCCC\"><label>";
                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"svat\" id=\"vatgroup_2\" />SVAT Invoice</label></td>
    <td bgcolor=\"#00CCCC\"><label>";
                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"evat\" id=\"vatgroup_3\"  />EVAT Invoice</label>";
                        }
                        ?>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="41"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
                <?php
                $sqldep = mysqli_query($GLOBALS['dbinv'], "Select * from s_salrep where REPCODE='" . $row['SAL_EX'] . "'") or die(mysqli_error());
                $rowdep = mysqli_fetch_array($sqldep);
                $salrep = $rowdep["REPCODE"] . " " . $rowdep["Name"];
                ?>
                <td><input type="text" disabled="disabled"  class="text_purchase2" id="salesrep" name="salesrep" value="<?php echo $salrep; ?>" /></td>
                <td><input type="text"  class="label_purchase" value="Discount 1" disabled="disabled"/></td>
                <td><input type="text" size="5" name="discount_org1" id="discount_org1" value="<?php echo $row['DIS']; ?>" onkeypress="keyset('discount2', event);" onblur="calc1_table_discount1();" class="text_purchase" disabled="disabled"/></td>
                <td><input type="text"  class="label_purchase" value="Discount 2" disabled="disabled"/></td>
                <td><input type="text" size="5" name="discount_org2" id="discount_org2" value="<?php echo $row['DIS1']; ?>" onkeypress="keyset('itemd_hidden', event);" onblur="calc1_table_discount1();" class="text_purchase"/></td>
                <td><input type="text"  class="label_purchase" value="Discount 3" disabled="disabled"/></td>
                <td><input type="text" size="5" name="discount_org3" id="discount_org3" value="<?php echo $row['DIS2']; ?>" onkeypress="keyset('itemd_hidden', event);" onblur="calc1_table_discount1();" class="text_purchase"/></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input id="dte_dor" name="dte_dor" type="hidden"  value="" class="text_purchase3" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
			<tr>
			<td><input type="text" disabled="disabled" value="Print WO Discount" class="label_purchase"></td>
			<td>
			<?php 
			if (trim($row['Costcenter'])=="1") {
				echo "<input type='checkbox' checked='checked' id='promotion'>";
			} else {
				echo "<input type='checkbox'  id='promotion'>";
			}	
			?>
			</td>			
			</tr>
			
        </table>


        <br/>   
        <fieldset>               

            <legend><div class="text_forheader">Item Details</div></legend>            

            <input type="hidden" name="item_count" id="item_count" value="0" />
            <table width="84%" border="0">

                <tr>
                    <td colspan="6">
                        <div class="CSSTableGenerator" id="itemdetails" >
                            <?php
                            echo "<table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";



                            $sql_data = mysqli_query($GLOBALS['dbinv'], "Select * from s_invo where REF_NO='" . $_GET["refno"] . "'") or die(mysqli_error());
                            while ($row1 = mysqli_fetch_array($sql_data)) {
                                  
                                    $subtot = (floatval($row1['PRICE']) * floatval($row1['QTY'])) - floatval($row1['DIS_rs']);
                                    
                                    $sql_mas =  mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $row1['STK_NO'] . "' and BRAND_NAME='" . $row1['BRAND'] . "'") or die(mysqli_error());
                                    $rowmas = mysqli_fetch_array($sql_mas); 

                                    $dt = date('Y-m-d', strtotime(date('Y-m-d') . ' - 90 days'));

                                    $sql2 = mysqli_query($GLOBALS['dbinv'], "Select sum(REC_QTY) as stk from s_purtrn where STK_NO='" . $row1['STK_NO'] . "' and CANCEL='0' and SDATE>'" . $dt . "' ") or die(mysqli_error());
                                    $row2 = mysqli_fetch_array($sql2);

                                    $mnewstk = 0;
                                    $unsold = 0;
                                    if (is_null($row2["stk"]) == false) {
                                        $mnewstk = $row2["stk"];
                                    }

                                    if ($rowmas["QTYINHAND"] > $row1["stk"]) {
                                        $unsold = $rowmas["QTYINHAND"] - $mnewstk;
                                    }

                                    $bgcolour = "";

//                                    if ($unsold > 0) {
//                                        $bgcolour = "yellow";
//                                    }
                                echo "<tr>
                                        <td onClick=\"disp_qty('" . $row1['STK_NO'] . "');\">" . $row1['STK_NO'] . "</a></td>";
                                        if ($bgcolour == "") {
                                            echo "<td onClick=\"disp_qty('" . $row1['STK_NO'] . "');\">" . $row1['DESCRIPT'] . "</a></td>";
                                        }else{
                                            echo "<td bgcolor=\" . $bgcolour . \ onClick=\"disp_qty('" . $row1['STK_NO'] . "');\">" . $row1['DESCRIPT'] . "</a></td>";
                                        }
                                         
                               echo " <td onClick=\"disp_qty('" . $row1['STK_NO'] . "');\">" . number_format($row1['PRICE'], 2, ".", ",") . "</a></td>
                                         <td onClick=\"disp_qty('" . $row1['STK_NO'] . "');\">" . $row1['QTY'] . "</a></td>
                                         <td onClick=\"disp_qty('" . $row1['STK_NO'] . "');\">" . number_format($row1['DIS_per'], 2, ".", ",") . "</td>
                                         <td onClick=\"disp_qty('" . $row1['STK_NO'] . "');\">" . number_format($subtot, 2, ".", ",") . "</a></td>
							
							 
                            </tr>";
                            }

                            echo "   </table>";
                            ?>
                        </div>                                                 		</td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><span class="style1">
                            <input type="text"  class="label_purchase" value="Stock Level" disabled="disabled"/>
                        </span></td>
                    <td><input type="text" size="5" name="stklevel" id="stklevel" value="" class="text_purchase1"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">
                            <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>
                        </span></td>
                    <td><input type="text" size="15" name="subtot" id="subtot" value="<?php echo $row['AMOUNT']; ?>" disabled="disabled" class="text_purchase3"/></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><span class="style1">
                            <input type="text"  class="label_purchase" value="Credit Period" disabled="disabled"/>
                        </span></td>
                    <td><input type="text" size="5" name="credper" id="credper" value="<?php echo $row['cre_pe']; ?>" disabled="disabled" class="text_purchase1"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">
                            <input type="text"  class="label_purchase" value="Discount" disabled="disabled"/>
                        </span></td>
                    <td><input type="text" size="15" name="totdiscount" id="totdiscount" value="<?php echo $row['DISCOU']; ?>" disabled="disabled"  class="text_purchase3" /></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><input type="text"  class="label_purchase" value="Month Total" disabled="disabled"/></td>
                    <td>
                        <?php
                        $invqty = 0;
                        $rtnqty = 0;
                        $Mon = date("m", strtotime($row['SDATE']));
                        $Yer = date("Y", strtotime($row['SDATE']));
                        $sql_inv = "Select sum(Qty) as totQty from viewinv where  Cus_CODE = '" . $row['C_CODE'] . "' and s_Brand = '" . $row['Brand'] . "' and month(SDATE1) = '" . $Mon . "' and year(SDATE1) = '" . $Yer . "' and cancel_m = '0' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'L0531' AND stk_no <> 'T3520' AND stk_no <> 'T3522' and stk_no <> 'A0356' and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and stk_no <> 'A0359' and stk_no <> 'MR099'";
                        $sql_grn = " Select sum(Qty) as totQty from viewcrntrn where  C_CODE = '" . $row['C_CODE'] . "' and Brand = '" . $row['Brand'] . "' and month(SDATE1) = '" . $Mon . "' and year(SDATE1) = '" . $Yer . "' and cancell = '0' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'L0531' AND stk_no <> 'T3520' AND stk_no <> 'T3522' and stk_no <> 'A0356' and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and stk_no <> 'A0359' and stk_no <> 'MR099'";
                        $res_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
                        if ($row_inv = mysqli_fetch_array($res_inv)) {
                            if (!is_null($row_inv['totQty'])) {
                                $invqty = $row_inv['totQty'];
                            }
                        }
                        $res_grn = mysqli_query($GLOBALS['dbinv'], $sql_grn);
                        if ($row_grn = mysqli_fetch_array($res_grn)) {
                            if (!is_null($row_grn['totQty'])) {
                                $rtnqty = $row_grn['totQty'];
                            }
                        }


                        $netqty = $invqty - $rtnqty;
                        ?>

                        <input type="text" size="15" name="tax" id="tax" value="<?php echo $netqty; ?>"  class="text_purchase3"  disabled="disabled" />
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">
                            <input type="text"  class="label_purchase" value="Tax" name="taxname" id="taxname" disabled="disabled"/>
                        </span></td>
                    <td><input type="text" size="15" name="tax" id="tax" value="<?php echo $row['VAT_VAL']; ?>"  class="text_purchase3"  disabled="disabled" /></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="5"><div id="storgrid"></div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">
                            <input type="text"  class="label_purchase" value="Invoice Total" disabled="disabled"/>
                        </span></td>
                    <td><input type="text" size="15" name="invtot"  id="invtot" value="<?php echo $row['GRAND_TOT']; ?>" disabled="disabled" class="text_purchase3"/></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>


                    <td>&nbsp;</td>
                </tr>

            </table>


    </form>        

</fieldset>    

