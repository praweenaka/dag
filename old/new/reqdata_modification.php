<?php
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();
$_SESSION["brand"] = "";
if ($_SESSION["dev"] == "") {
    echo "Invalid User Session";
    exit();
}
?>

<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Request Data Modifications</h3>
        </div>

        <form role="form" name ="form1" class="form-horizontal">
            <div class="box-body">
                <br>               
                <div class="form-group">
                    <a onclick="location.reload();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New

                    </a>
                    <a onclick="save_inv();" class="btn btn-primary">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a>

                    <a onclick="NewWindow('search_reqdatamodi.php', 'mywin', '800', '700', 'yes', 'center');
                            return false" class="btn btn-default active">
                        <span class="fa fa-search"></span> &nbsp; Find
                    </a>
                     <?php if ($_SESSION['User_Type'] == "1") { ?>
                        <a onclick="cancelInv();" class="btn btn-danger">
                            <span class="fa fa-print"></span> &nbsp; Cancel
                        </a>	
                    <?php } ?>


                </div>
                <div id="msg_box"  class="span12 text-center"  ></div>
                <div class="col-sm-1">
                    <input type="text" placeholder="Uniq"  id="uniq" class="form-control hidden input-sm">
                </div>

                <div class="form-group"></div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Code</label>
                    <div class="col-sm-3">
                        <input type="text" disabled name="code" id="code" class="form-control   input-sm">  
                    </div>
                    <label class="col-sm-1 control-label" for="sdate">Date</label>
                    <div class="col-sm-2">
                        <input type="text" disabled value="<?php echo date('Y-m-d'); ?>" name="sdate" id="sdate" class="form-control dt input-sm">  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Request By</label>
                    <div class="col-sm-3">
                        <input type="text"     name="Request By" id="reqby" class="form-control   input-sm">  
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Description</label>
                    <div class="col-sm-5">
                        <textarea placeholder="Description" style="width: 650px;height: 150px;" id="des" class="form-control input-sm"></textarea> 
                    </div>
                </div>
        </form>
    </div>

</section>

<script src="js/reqdata_modification.js"></script>


<script>newent();</script>