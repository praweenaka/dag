<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Multi GIN</h3>
        </div>
        <form role="form" name ="form1" class="form-horizontal">
            <div class="box-body">

                <div class="form-group">
                    <a onclick="new_inv();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
                    <a onclick="save_inv();" class="btn btn-primary">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>
                    <a onclick="print_inv();" class="btn btn-default">
                        <span class="fa fa-print"></span> &nbsp; Print
                    </a>
                    <a onclick="NewWindow('search_gin_multi.php', 'mywin', '800', '700', 'yes', 'center');
                    return false" class="btn btn-default">
                    <span class="fa fa-search"></span> &nbsp; Find
                </a>
                <a onclick="cancel_inv();" class="btn btn-danger">
                    <span class="fa fa-print"></span> &nbsp; Cancel
                </a>	
            </div>
            <div id="msg_box"  class="span12 text-center"  ></div>

            <input type="hidden" id="tmpno" class="form-control">
            <input type="hidden" id="item_count" class="form-control">

            <div class="form-group">
                <label class="col-sm-2 control-label" for="firstname_hidden">Ref No</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Ref No"  disabled="" id="invno" class="form-control">
                </div> 

            </div>

            <div class="form-group">
                <label for="firstname_hidden" class="col-sm-2 control-label">To Department</label>
                <div class="col-sm-2">
                    <select id="to_dep"   class="form-control col-sm-1" >

                        <?php
                        $sql = "select * from s_stomas where act='0' order by CODE";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        while ($row = mysqli_fetch_array($result)) {
                                //echo "<option value='" . $row["barnd_name"] . "'>" . $row["barnd_name"] . "</option>";
                            if ($row["CODE"] == "01") {
                                echo "<option selected value='" . $row["CODE"] . "'>" . $row["DESCRIPTION"] . "</option>";
                            } else {
                                echo "<option value='" . $row["CODE"] . "'>" . $row["DESCRIPTION"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div> 
                <div id="unsold" class="col-sm-1">

                </div>
            </div>


            <div class="col-sm-12">
                <table class="table">
                    <tr>
                        <th style="width: 150px;">From Department</th>
                        <th style="width: 150px;">Item</th>
                        <th style="width: 5px;"></th>
                        <th style="width: 280px;">Description</th>
                        <th style="width: 80px;">Qty</th>

                        <th style="width: 10px;"></th>
                        <td style="width: 90px;"></td>
                    </tr>

                    <tr>
                        <td>
                            <select id="from_dep" onblur="itno_ind();" class="form-control col-sm-1" >

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

                        </td>
                        <td>
                            <input type="text"  onkeypress="keyset('qty', event);" onblur="itno_ind();" placeholder="Item" id="itemCode" class="form-control">
                        </td>
                        <td>
                            <a href="" onclick="NewWindow('serach_item.php', 'mywin', '800', '700', 'yes', 'center');
                            return false" onfocus="this.blur()">
                            <input name="searchcusti" id="searchcusti" value="..." class="btn btn-default btn-sm" type="button">
                        </a>
                    </td>
                    <td>
                        <input type="text" placeholder="Description" id="itemDesc" class="form-control">
                    </td>

                    <td>
                        <input type="text" onkeypress="keyset('add_tmp_it', event);" placeholder="Qty" id="qty" class="form-control">
                    </td>                        
                    <td>
                        <input type="button"  onclick="add_tmp();" id="add_tmp_it" value= "+"  class="btn btn-default" ></input>

                    </td>
                    <td><input id="itemPrice" type= "hidden">

                    </td>
                </tr>

            </table>
            <div class="span6 pull-right">
                <div id="submas">

                </div>
            </div>
            <div id="itemdetails" class="col-sm-9" >

            </div>
        </div>
        <table class="table">
            <tr>
                <td style="width: 90px;">In Hand</td>
                <td style="width: 100px;"><input type="text" disabled="" style="color: red" name='qtyinhand'  id="qtyinhand" class="form-control"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>

                <td></td>
            </tr>
        </table>	 

    </div>

</div>
<div class="form-group"></div>
<div class="form-group"></div>


<div class="form-group">
    <label for="firstname_hidden" class="col-sm-1 control-label">ARN No</label>
    <div class="col-sm-2">
        <input type="text"   name="txtarno" id="txtarno" disabled=""  class="form-control"> 
    </div> 
    <div class="col-sm-1">
       <a href="" onclick="NewWindow('../serach_arn.php?mstatus=gin', 'mywin', '800', '700', 'yes', 'center');
       return false" onfocus="this.blur()">
       <input name="searchinv" id="searchinv" value="..." class="btn btn-default btn-sm" type="button">
   </a>
    </div> 
    <div class="col-sm-1">
       <a onclick="update();"class="btn btn-success">
        <span class="fa fa-edit"></span> &nbsp; Update Arn
    </a>
    </div> 
</div> 
<br><div class="form-group"></div>
<div class="form-group">
   <label for="firstname_hidden" class="col-sm-1 control-label">AR Date</label>
   <div class="col-sm-2">
     <input type="text" disabled class="form-control" name="DTARdate" id="DTARdate"/>
   </div> 

</div> 

<div  class='space' >
    <br>&nbsp;
    <br>&nbsp;
    <br>&nbsp;

</div>

</form>
</div>

</section>

<script src="js/gin_m.js"></script>
<script src="js/common.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.custom.js"></script>
<script src="js/common.js"></script>
<script  type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script  type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>
<script>
    new_inv();

</script>
