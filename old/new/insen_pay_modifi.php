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
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Insentive Payment Modification</h3>
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


                </div>
                <div id="msg_box"  class="span12 text-center"  ></div>
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Code</label>
                    <div class="col-sm-4 form-group-sm">
                        <?php
                        include './connection_sql.php';
                        echo"<select id = \"code\"  class =\"form-control input-sm\">";
                        echo "<option value=''></option>";
                        $sql = "select * from vendor ";
                        foreach ($conn->query($sql) as $row) {
                            echo "<option value='" . $row["CODE"] . "' >" . $row["CODE"] . "  -  " . $row["NAME"] . "</option>";
                        }
                        echo"</select>";
                        ?>                     
                    </div>

                    <label class="col-sm-1 control-label" for="sdate">Month</label>
                    <div class="col-sm-2">
                        <input type="text" name="sdate"   onchange="ondate1();"  id="sdate"  class="form-control dt1 input-sm">    
                    </div>

                </div> 
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Brand</label>
                    <div  class=" col-sm-4 form-group-sm" >
                        <?php
                        include './connection_sql.php';
                        echo"<select id = \"brand\"  class =\"selectpicker form-control input-sm\" data-show-subtext=\"true\" data-live-search=\"true\">";
                        echo "<option data-subtext= \"\"></option>";
                        $sql = "select * from brand_mas where act='1' ";
                        foreach ($conn->query($sql) as $row) {
                            echo "<option data-subtext='" . $row["barnd_name"] . "'   >" . $row["barnd_name"] . "</option>";
                        }
                        echo"</select>";
                        ?>   

                    </div>


                </div> 
                <div class="form-group">
                    <label class="col-sm-1 control-label" for="invno">Description</label>
                    <div class="col-sm-2">
                        <textarea placeholder="Description" style="width: 450px;height: 100px;" id="des" class="form-control input-sm"></textarea> 
                    </div>
                </div>
        </form>
    </div>

</section>

<script src="js/insen_pay_modifi.js"></script>


<script>
                            function myFunction() {
                                location.reload();
                            }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
