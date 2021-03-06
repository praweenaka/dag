<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Price Control</h3>
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
                </div>
                <div id="msg_box"  class="span12 text-center"  ></div>

                <input type="hidden" id="tmpno" class="form-control">
                <input type="hidden" id="item_count" class="form-control">


                <div class="form-group">
                    <label for="firstname_hidden" class="col-sm-2 control-label">Brand</label>
                    <div class="col-sm-4">
                        <select id="brand" onclick="load_items();" class="form-control input-sm" width='120' >

                            <?php
                            if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
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


                <div class="col-sm-12">


                    <div id="itemdetails" class="col-sm-9" >

                    </div>
                </div>


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

<script src="js/price_control.js"></script>
<script src="js/common.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.custom.js"></script>
<script src="js/common.js"></script>
<script  type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script  type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>

