
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






<link rel="stylesheet" href="css/table.css" type="text/css"/>	


</label>

<fieldset>
    <legend>
        <div class="text_forheader">Enter GRN Details</div>
    </legend>             

    <form name="form1" id="form1">       
        <?php
        include_once("connectioni.php");

        $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_crnma where REF_NO='" . $_GET['grn'] . "'")or die(mysqli_error());
        $row = mysqli_fetch_array($sql);
        ?>

        <table width="100%" border="0"  class=\"form-matrix-table\">
            <tr>
                <td width="10%"><input type="text"  class="label_purchase" value="GRN No" disabled="disabled"/></td>
                <td width="10%"><input type="text" disabled="disabled" name="grnno" id="grnno" value="<?php echo $row['REF_NO']; ?>" class="text_purchase3" onkeypress="keyset('searchcust', event);" onfocus="got_focus('grnno');"  onblur="lost_focus('grnno');"  /></td>
                <td width="10%"> </td>
                <td width="10%"><input type="text"  class="label_purchase" value="Date" disabled="disabled"/></td>
                <td width="10%"><input type="text" size="20" name="grndate" id="grndate" value="<?php echo $row['SDATE']; ?>" disabled="disabled" class="text_purchase3"/>     </td>
                <td width="10%"></td>
                <td width="10%"><input type="text"  class="label_purchase" value="Department" disabled/></td>
                <td width="10%"><input type="text" size="20" name="department" id="department" value="<?php echo $row['DEPARTMENT']; ?>" disabled="disabled" class="text_purchase3"/>   </td>
                <td width="10%">&nbsp;</td>
            </tr>
            <tr>
                <td><input type="text" disabled="disabled" name="rno" id="rno" value="" class="text_purchase3" onkeypress="keyset('searchcust', event);" onfocus="got_focus('grnno');"  onblur="lost_focus('grnno');"  /></td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td bgcolor="#00CCCC"><label>
                        <input type="radio" name="paymethod" value="credit" id="paymethod_0" />
                        Credit</label></td>
                <td bgcolor="#00CCCC"><label>
                        <input type="radio" name="paymethod" value="cash" id="paymethod_1" />
                        Cash</label></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td bgcolor="#00CCCC"><label>
                        <?php
                        $sql_trn = mysqli_query($GLOBALS['dbinv'], "Select * from s_crntrn where REF_NO='" . $_GET['grn'] . "'")or die(mysqli_error());
                        $row_trn = mysqli_fetch_array($sql_trn);

                        if ($row_trn["VAT"] == "1") {
                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"vat\" checked id=\"vatgroup_0\"  />
      VAT Invoice</label></td>";
                        } else {
                            echo "<input type=\"radio\" name=\"vatgroup\" value=\"vat\" id=\"vatgroup_0\"  />
      VAT Invoice</label></td>";
                        }

                        if ($row_trn["VAT"] == "0") {
                            echo "<td bgcolor=\"#00CCCC\"><label>
      <input type=\"radio\" name=\"vatgroup\" value=\"non\" id=\"vatgroup_1\" checked  />
      Non VAT Invoice</label></td>";
                        } else {
                            echo "<td bgcolor=\"#00CCCC\"><label>
      <input type=\"radio\" name=\"vatgroup\" value=\"non\" id=\"vatgroup_1\"  />
      Non VAT Invoice</label></td>";
                        }
                        ?> 
                        <td bgcolor="#00CCCC"><label>
                                <input type="radio" name="vatgroup" value="svat" id="vatgroup_2"  onkeypress="keyset('discount1', event);" />
                                SVAT Invoice</label></td>
                        <td bgcolor="#00CCCC"><label>
                                <input type="radio" name="vatgroup" value="evat" id="vatgroup_3"  onkeypress="keyset('discount1', event);" />
                                EVAT Invoice</label></td>
                        <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><input type="text"  class="label_purchase" value="Customer" disabled/></td>
                <td colspan="3"><input type="text" disabled="disabled"  class="text_purchase1" value="<?php echo $row['C_CODE']; ?>" name="firstname_hidden" id="firstname_hidden"/>
                    <input type="text" disabled="disabled"  class="text_purchase2" id="firstname" value="<?php echo $row['CUS_NAME'] ?>" name="firstname" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="text"  class="label_purchase" value="Invoice No" disabled="disabled"/></td>
                <td><input type="text" size="15" name="invno" id="invno" value="<?php echo $row['INVOICENO']; ?>" onkeypress="keyset('balance', event);" class="text_purchase3" disabled="disabled"/></td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text"  class="label_purchase" value="Address" disabled/></td>
                <td colspan="2"><input type="text"  class="text_purchase4"  disabled="disabled" id="cus_address" name="cus_address" /></td>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td><input type="text"  class="label_purchase" value="Invoice Date" disabled="disabled"/></td>
                <td><input type="text" size="15" name="invdate" id="invdate" disabled="disabled" value="<?php echo $row['DDATE']; ?>" onkeypress="keyset('department', event);" class="text_purchase3"/></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
                <td><input type="text" size="15" name="brand" id="brand" disabled="disabled" value="<?php echo $row['Brand']; ?>" onkeypress="keyset('department', event);" class="text_purchase3"/> </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="41"><input type="text"  class="label_purchase" value="Marketing Executive" disabled="disabled"/></td>
                <td><input type="text"  class="text_purchase4"  id="salesrep" name="salesrep" value="<?php echo $row['SAL_EX']; ?>" /></td>
                <td>&nbsp;</td>
                <td><input type="text"  class="label_purchase" value="Cost Center" disabled="disabled"/></td>
                <td><input type="text"  class="text_purchase4"  id="costcenter" name="costcenter" value="<?php echo $row['SAL_EX']; ?>" />   </td>
                <td>&nbsp;</td>
                <td><input type="text"  class="label_purchase" value="Serial No (MC)" disabled="disabled"/></td>
                <td><input type="text" size="5" name="serialno" id="serialno" value="0" onkeypress="keyset('itemd_hidden', event);" class="text_purchase"/></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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
                    <td colspan="8">
                        <div class="CSSTableGenerator" id="itemdetails" >

                            <?php
                            echo "<table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Pre.RetQty</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ret.Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";

                            $i = 1;

                            $sql_data = mysqli_query($GLOBALS['dbinv'], "Select count(*) as mcount from s_crntrn where REF_NO='" . $row['REF_NO'] . "'") or die(mysqli_error());
                            $row_data = mysqli_fetch_array($sql_data);
                            $mcou = $row_data['mcount'];

                            $subtot = 0;
//echo "Select * from s_crntrn where REF_NO='".$row['REF_NO']."'";
                            $sql_data = mysqli_query($GLOBALS['dbinv'], "Select * from s_crntrn where REF_NO='" . $row['REF_NO'] . "'") or die(mysqli_error());
                            while ($row_data = mysqli_fetch_array($sql_data)) {
                                $sql_itdata = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $row_data['STK_NO'] . "' and BRAND_NAME='" . $row["Brand"] . "'") or die(mysqli_error());
                                $rowit = mysqli_fetch_array($sql_itdata);

                                $vat = $row_data["VAT"];
                                //$subtot=(floatval($row_data['PRICE'])*floatval($row_data['QTY']))-floatval($row_data['DIS_RS']);
                                if ($row_data['DIS_RS'] == "") {
                                    $DIS_RS = 0;
                                } else {
                                    $DIS_RS = $row_data['DIS_RS'];
                                }
                                if ($row_data['DIS_P'] == "") {
                                    $DIS_P = 0;
                                } else {
                                    $DIS_P = $row_data['DIS_P'];
                                }



                                if (is_null($row_data['QTY']) or $row_data['QTY'] == 0) {
                                    $ret_qty = 0;
                                } else {
                                    $ret_qty = $row_data['QTY'];
                                }


                                echo "<tr>
                        
							 <td>" . $row_data['STK_NO'] . "</td>
							 <td>" . $row_data['DESCRIPT'] . "</td>
							 <td>" . number_format(str_replace(",", "", $row_data['PRICE']), 0, ".", ",") . "</td>";

                                $sql_inv = mysqli_query($GLOBALS['dbinv'], "Select * from s_invo where REF_NO='" . $row['INVOICENO'] . "' and STK_NO='" . $row_data['STK_NO'] . "'") or die(mysqli_error());
                                $minv = 0;
                                if ($row_inv = mysqli_fetch_array($sql_inv)) {
                                    $minv = $row_inv['QTY'];
                                }

                                echo " <td>" . number_format(str_replace(",", "", $minv), 0, ".", ",") . "</td>
							 <td></td>
							
							 <td>" . $ret_qty . "</td>
							 <td>" . $row_data['DIS_P'] . "</td>";
                                $sub = ($row_data['PRICE'] * $ret_qty) - (($row_data['PRICE'] * $ret_qty) * $row_data['DIS_P'] / 100);
                                echo "<td>" . $sub . "</td>
							 
							
							 
                            </tr>";

                                $subtot = $subtot + $sub;
                                $i = $i + 1;
                            }
                            echo "</table>";
                            ?>
                        </div>                                                 		</td>
                </tr>


                <?php
                $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_crnma where REF_NO='" . $_GET['grn'] . "'")or die(mysqli_error());

                $row = mysqli_fetch_array($sql);
                if ($vat == "1") {
                    $vat = $subtot * $row["vatrate"] / 100;
                }
                ?>
                <tr>
                    <td width="10%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">
                            <input type="text"  class="label_purchase" value="Sub Total" disabled="disabled"/>
                        </span></td>
                    <td><input type="text" size="15" name="subtot" id="subtot" disabled="disabled" class="text_purchase3" value="<?php echo ($subtot); ?>"/></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><input type="hidden" name="mcou" id="mcou" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">
                            <input type="text"  class="label_purchase" value="Discount" disabled="disabled"/>
                        </span></td>
                    <td><input type="text" size="15" name="totdiscount" id="totdiscount" value="<?php echo $row["DIS"]; ?>" disabled="disabled"  class="text_purchase3" /></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">
                            <input type="text"  class="label_purchase" value="Tax" name="taxname" id="taxname" disabled="disabled"/>
                        </span></td>
                    <td><input type="text" size="15" name="tax" id="tax" value="<?php echo $vat; ?>"  class="text_purchase3"  disabled="disabled" /></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="5"><div id="storgrid"></div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">
                            <input type="text"  class="label_purchase" value="Invoice Total" disabled="disabled"/>
                        </span></td>
                    <!--+$vat-->
                    <td><input type="text" size="15" name="invtot"  id="invtot" disabled="disabled" class="text_purchase3" value="<?php echo ($subtot); ?>"/></td>
                    <td>&nbsp;</td>
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
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
            </table>


    </form>        

</fieldset>    

<table width="765" border="0" cellpadding="0">
    <tr>
        <th height="189" colspan="5" align="left" nowrap="nowrap">
            <div align="left">