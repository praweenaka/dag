<?php
date_default_timezone_set('Asia/Colombo');
session_start();
require_once("connectioni.php");
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60); 
$_SESSION["brand"] = "";

if ($_SESSION["CURRENT_USER"] == "") {
    echo "Please Loging Again !!!";
    exit();
}

if ($_SESSION["dev"] == "") {
    echo "Invalid User Session";
    exit();
}


?>
 
<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />
<style>

    .talign{
        text-align: left !important; 

    }
    .text{
        font-weight: 600; 
        color: black;
    }
</style>
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Sales Invoice</h3>
            <b style="margin-top: -10px;"><p style="float: right; color: black" id="time"></p></b> 
        </div>
        <form role="form" name ="form1" class="form-horizontal">
            <div class="box-body">

                <div class="form-group col-sm-9">
                    <a onclick="new_inv();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
                    <a onclick="save_inv();" class="btn btn-primary">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>
                    <a onclick="print_inv();" class="btn btn-default">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a>
                    <a onclick="print_inv_net();" class="btn btn-default">
                        <span class="fa fa-print"></span> &nbsp; Print Net
                    </a>
                    <a onclick="NewWindow('search_inv.php', 'mywin', '800', '700', 'yes', 'center');
                    return false" class="btn btn-default">
                    <span class="fa fa-search"></span> &nbsp; Find
                </a>
                <?php if ($_SESSION['User_Type'] == "1") { ?>
                    <a onclick="cancel_inv();" class="btn btn-danger">
                        <span class="fa fa-print"></span> &nbsp; Cancel
                    </a>	
                <?php } ?>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label talign" style="margin-left: 36px;" for="invdate">Date</label>
                <div class="col-sm-2">
                    <!--<input type="text"  disabled value="2019-12-02" name="invdate" id="invdate"  class="form-control dt input-sm">-->  
                    <input type="text"    value="<?php echo date('Y-m-d'); ?>" name="invdate" id="invdate"  class="form-control dt input-sm">  
                </div>


            </div>
            <div id="msg_box"  class="span12 text-center"  ></div>

            <input type="hidden" id="tmpno" class="form-control">
            <input type="hidden" id="item_count" class="form-control">
            <input type="hidden" name="c_subcode" id="c_subcode">




            <input type="hidden" name="ordno" id="ordno">

            <input type="hidden" name="balance" id="balance">

            <input type="hidden" name="creditlimit" id="creditlimit">
            <label style="background-color: #00CCCC"><input type="radio" name="paymethod" value="credit" id="paymethod_0" />&nbsp;CREDIT&nbsp;&nbsp;&nbsp;</label>
            <label style="background-color: #00CCCC"><input type="radio" name="paymethod" value="credit" id="paymethod_1" />&nbsp;CASH&nbsp;&nbsp;&nbsp;</label>

            <div class="form-group">
                <label class="col-sm-1 control-label talign" for="invno">Ref No</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Ref No" disabled id="invno" class="form-control input-sm">
                </div> 
                <label class="col-sm-1 control-label talign" for="salesord1">Order/AD No</label>
                <div class="col-sm-2">
                    <input type="text" name="salesord1"   id="salesord1" class="form-control input-sm">  
                </div>
                <div class="col-sm-1">
                    <a  onclick="load_ord_lst();" class="btn btn-primary btn-sm">...</a>
                </div>

                <label class="col-sm-1 control-label talign" for="Result">Order Status</label>
                <div class="col-sm-1">
                    <input type="text" name="Result" disabled class="form-control input-sm" id="Result">
                </div>
                <label class="col-sm-1 control-label talign" for="crebal">Return Chq</label>
                <div class="col-sm-1">
                    <input type="text" name="txtreturn" disabled class="form-control input-sm" id="txtreturn">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label talign" for="invno">Customer</label>

                <div class="col-sm-2">
                    <input type="text"  class="form-control input-sm" disabled="disabled" name="firstname_hidden" id="firstname_hidden">
                </div>

                <div class="col-sm-3">
                    <input type="text" class="form-control input-sm" id="firstname" name="firstname" />
                </div>
                <div class="col-sm-1">
                    <a href=""  class="btn btn-primary btn-sm" onClick="NewWindow('../serach_customer.php', 'mywin', '800', '700', 'yes', 'center');
                    return false" onFocus="this.blur()">
                    ...
                </a>
            </div>

            <label class="col-sm-1 control-label talign" for="over60">Over 60</label>
            <div class="col-sm-1">
                <input type="text" name="over60" disabled class="form-control input-sm" id="over60">
            </div>
            <label class="col-sm-1 control-label talign" for="crebal">Credit Balance</label>
            <div class="col-sm-2">
                <input type="text" name="crebal" disabled class="form-control input-sm" id="crebal">
            </div>


        </div>

        <div class="form-group">
            <label class="col-sm-1 control-label talign" for="invno">Address</label>

            <div class="col-sm-5">
                <input type="text"  class="form-control input-sm"  name="cus_address" id="cus_address">
                <input type="hidden"  class="form-control input-sm"  name="cus_address2" id="cus_address2">  
            </div>
            <label class="col-sm-1 control-label talign"   for="invno">Department</label>
            <div class="col-sm-2">   
                <select id="department" onclick="calc();" onchange="calc();"  class="form-control" >

                    <?php
                    $sql = "select * from s_stomas where act='0' order by CODE";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    while ($row = mysqli_fetch_array($result)) {
                                //echo "<option value='" . $row["barnd_name"] . "'>" . $row["barnd_name"] . "</option>";
                        if ($row["CODE"] == "01") {
                            echo "<option selected value='" . $row["CODE"] . "'><strong>" . $row["DESCRIPTION"] . "-" . $row["CODE"] . "<strong></option>";
                        } else {
                            echo "<option value='" . $row["CODE"] . "'>" . $row["DESCRIPTION"] . "-" . $row["CODE"] . "</option>";
                        }
                    }
                    ?>
                </select> 
            </div> 

            <label class="col-sm-1 control-label talign" for="invno">Brand</label>

            <div class="col-sm-2">
                <select id="brand"  class="form-control input-sm" onblur="brandsession();" >

                    <?php
                    if (($_SESSION["CURRENT_DEP"] != "") and ( !is_numeric($_SESSION["CURRENT_DEP"]))) {
                        $sql = "select * from brand_mas where act ='1' and costcenter='" . $_SESSION["CURRENT_DEP"] . "' order by barnd_name";
                    } else {
                        $sql = "select * from brand_mas where act ='1' order by barnd_name";
                    }
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row["barnd_name"] . "'>" . $row["barnd_name"] . "</option>";
                    }
                    ?>
                </select>
            </div> 

        </div>

        <div class="form-group">
            <label class="col-sm-1 control-label talign" for="invno">Vat</label>

            <div class="col-sm-2">
                <input type="text" disabled class="form-control input-sm" name="vat1" id="vat1">
            </div>

            <div class="col-sm-2">                    
                <input type="text"  disabled class="form-control input-sm" name="vat2" id="vat2">    
            </div>

            <div class="col-sm-1">                    
                &nbsp;
            </div>

            <div  class="col-sm-1">
                <input type="radio" name="vatgroup" value="vat" id="vatgroup_0" onclick="calc();">
                VAT
            </div>  
            <div  class="col-sm-1">
                <input type="radio" name="vatgroup" checked value="vat" id="vatgroup_1" onclick="calc();">
                Non VAT
            </div>  
            <div  class="col-sm-1">
                <input type="radio" name="vatgroup" value="vat" id="vatgroup_2" onclick="calc();">
                SVAT
            </div>                      
            <div  class="col-sm-1">
                <input type="radio" name="vatgroup" value="vat" id="vatgroup_3" onclick="calc();">
                EVAT
            </div>  

        </div>


        <div class="form-group">
            <label class="col-sm-1 control-label talign" for="invno">Sales Ex.</label>

            <div class="col-sm-2">
                <select id="salesrep" class="form-control input-sm" >

                    <?php
                    require_once("connectioni.php");
                    if ($_SESSION["MANAGER"] != "") {
                        $sql = "select * from s_salrep where cancel='1' and manager='" . $_SESSION["MANAGER"] . "'order by REPCODE";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
                        }
                    } else if ($_SESSION["CURRENT_REP"] == "") {
                        $sql = "select * from s_salrep where cancel='1' order by REPCODE";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
                        }
                    } else {
                        $sql = "select * from s_salrep where cancel='1' and repcode = '" . $_SESSION["CURRENT_REP"] . "' order by REPCODE";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row["REPCODE"] . "'>" . $row["REPCODE"] . " " . $row["Name"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <label class="col-sm-1 control-label talign" for="invno">Discount 1</label>
            <div class="col-sm-2">   
                <input type="text"  class="form-control input-sm"  onkeyup="calc();" name="discount_org1" id="discount_org1">    
            </div>
            <label class="col-sm-1 control-label talign" for="invno">Discount 2</label>
            <div class="col-sm-2">   
                <input type="text"  class="form-control input-sm" onkeyup="calc();" name="discount_org2" id="discount_org2">   
                <input type="hidden"  class="form-control input-sm" onkeyup="calc();" name="discount_org3" id="discount_org3">    						
            </div>
            <label class="col-sm-1 control-label talign" for="invno">Delivery Type</label>
            <div class="col-sm-2"> 

                <select id="delitype" class="form-control input-sm" >
                    <option value="NORMAL">NORMAL</option>
                    <option value="URGENT">URGENT</option>
                    <option value="TRANSPORT">TRANSPORT</option>
                    <option value="URGENT / TRANSPORT">URGENT / TRANSPORT</option>
                </select>

            </div>

        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label talign" for="invno">Print WO Discount</label>
            <div class="col-sm-2">   
                <input type="checkbox"  name="promotion" id="promotion">    
            </div>
        </div>    

        <table class="table">
            <tr>
                <th style="width: 100px;">Item Code</th>
                <th style="width: 10px;"></th>
                <th style="width: 450px;">Description</th>
                <th style="width: 120px;">Price</th>
                <th style="width: 120px;">Qty</th>
                <th style="width: 120px;">%</th>
                <th style="width: 120px;">SubTotal</th>
                <th></th>
            </tr>


            <tr>
                <td>
                    <input type="text" class="form-control input-sm" name="itemd_hidden" id="itemd_hidden" onblur="itno_ind();">
                </td>
                <td><a href="serach_item.php?stname=invoice" onclick="NewWindow(this.href, 'mywin', '800', '700', 'yes', 'center');
                return false" onfocus="this.blur()">
                <input type="button" name="searchitem" id="searchitem" value="..." class="btn">
            </a></td>
            <td>
                <input type="text"  class="form-control input-sm" id="itemd" name="itemd" disabled="disabled">
            </td>  
            <td>
                <input type="text"   name="rate" id="rate" value="" class="form-control input-sm"  onkeyup="calc();">
                <input type="hidden" name="part_no" id="part_no"> <input type="hidden" name="actual_selling" id="actual_selling">
            </td>
            <td>
                <input type="text" name="qty" id="qty" value="" onkeyup="calc();" class="form-control input-sm">
            </td>
            <td>
                <input type="text" size="15" name="discountper" id="discountper" value="" disabled="disabled" class="form-control input-sm" onkeypress="keyset('subtotal', event);">
            </td>
            <td>
                <input type="text" size="15" name="subtotal" id="subtotal" value="" class="form-control input-sm" disabled="disabled" onkeypress="keyset('additem_tmp', event);">
            </td>
            <td><input type="button" name="additem_tmp" id="additem_tmp" value="Add" onclick="add_tmp('add');" class="btn btn-primary"></td>
        </tr>

    </table>


    <div id="itemdetails"></div>



    <table class="table">
        <tr>
            <th style="width: 100px;">Stock Level</th>
            <th style="width: 60px;"><input type="text"  class="form-control input-sm" disabled=""  name="stklevel" id="stklevel">   </th>
            <th style="width: 400px;"></th>
            <th style="width: 120px;"></th>
            <th style="width: 120px;"><div class="col-sm-2" id="transp"></div></th>
            <th style="width: 120px;">Sub Total</th>
            <th style="width: 120px;"><input type="text"  disabled class="form-control input-sm"   name="subtot" id="subtot"></th>
            <th></th>
        </tr>
        <tr>
            <th style="width: 100px;">Credit Period</th>
            <th style="width: 60px;"><input type="text"  class="form-control input-sm"   name="credper" id="credper"></th>
            <td><input type="button" style="visibility: hidden" id="cred_up_but" name="cred_up_but" value="Cred Period Update" onclick="credupdate();" class="btn btn-primary"></td>
            <th style="width: 120px;"> <div id="msg_boxcredup"  class="span12 text-center"  ></div></label></th>
            <th style="width: 120px;"></th>
            <th style="width: 120px;">Discount</th>
            <th style="width: 120px;"><input type="text"  disabled class="form-control input-sm"   name="totdiscount" id="totdiscount"></th>
            <th></th>
        </tr>     
<!--                    <tr>
                        <th style="width: 100px;">Credit Period</th>
                        <th style="width: 60px;"><input type="text"  class="form-control input-sm"   name="credper" id="credper"></th>
                        <th style="width: 400px;"></th>
                        <th style="width: 120px;"></th>
                        <th style="width: 120px;"></th>
                        <th style="width: 120px;">Discount</th>
                        <th style="width: 120px;"><input type="text"  class="form-control input-sm"   name="totdiscount" id="totdiscount"></th>
                        <th></th>
                    </tr>                    -->
                    <tr>
                        <th style="width: 100px;">Net Qty</th>
                        <th style="width: 60px;"><input type="text"  class="form-control input-sm" disabled=""  name="txtinvt" id="txtinvt">   </th>
                        <th style="width: 400px;"></th>
                        <th style="width: 120px;"></th>
                        <th style="width: 120px;"></th>
                        <th style="width: 120px;">Tax</th>
                        <th style="width: 120px;"><input type="text"  disabled class="form-control input-sm"   name="tax" id="tax"></th>
                        <th></th>
                    </tr>  
                    <tr>
                        <th style="width: 100px;"></th>
                        <th style="width: 60px;"></th>
                        <th style="width: 400px;"></th>
                        <th style="width: 120px;"></th>
                        <th style="width: 120px;"></th>
                        <th style="width: 120px;">Invoice Total</th>
                        <th style="width: 120px;"><input type="text"  disabled class="form-control input-sm"   name="invtot" id="invtot"></th>
                        <th></th>
                    </tr>  

                </table>
                <div id="storgrid"></div>

                <div  class='space' >
                    <br>&nbsp; 
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Delivary</label>
                    <div class="col-sm-2">   
                        <input type="checkbox"  onclick="delichk();"   name="promotion" id="deli_chk">    
                    </div>
                    <div class="col-sm-3">   

                    </div>
                    <div class="col-sm-4">   
                        <div id="msg_boxdeliup"  class="span12 text-center"  ></div>
                    </div>
                    <div class="col-sm-3">   

                    </div>
                </div>
                <div class="form-group"   style="visibility: hidden">
                    <label class="col-sm-1 control-label" id="deli_label" for="invno">Details</label>
                    <div class="col-sm-4">
                        <input type="text"  class="form-control input-sm"   placeholder="Name"  id="deli_name">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control input-sm"  placeholder="Address"  id="deli_address"   />
                    </div>
                    <div class="col-sm-1" id="deli_upbut">
                        <a onclick="deli_update();"  class="btn btn-primary">
                            <span class="fa fa-save"></span> &nbsp; Update
                        </a>
                    </div>
                    <div class="col-sm-2" id="printdeli">
                        <a onclick="print_deli();"  class="btn btn-primary">
                            <span class="fa fa-print"></span> &nbsp; Print Delivary
                        </a>
                    </div>
                </div>

            </form>
        </div>

    </section>

    <script src="js/sales_inv.js?v1"></script>
    <script src="js/comman.js"></script>
    <script>
        new_inv();

    </script>
