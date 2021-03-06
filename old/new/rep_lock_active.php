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

<style>
    * {
        box-sizing: border-box;
    }

    /* Create two equal columns that floats next to each other */
    .column {
        float: left;
        width: 50%;
        padding: 10px;
        height: 300px; /* Should be removed. Only for demonstration */
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>

<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Rep Lock Active</h3>
        </div>
    </div>

    <form role="form" name ="form1" class="form-horizontal">
        <div>



            <div class="panel-group">
                <div class="panel panel-info">
                    <div class="panel-heading"> </div>
                    <div class="form-group"></div>
                    <div id="msg_box"  class="span12 text-center"  ></div>
                    <div class="form-group">
                        <a style="margin-left: 40px;">
                        </a>
                        <a onclick="myFunction()" class="btn btn-default">
                            <span class="fa fa-user-plus"></span> &nbsp; New

                        </a>
                        <a onclick="update_inv();" class="btn btn-primary">
                            <span class="glyphicon glyphicon-edit"></span> &nbsp; Unlock
                        </a>
                        <div><br></div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="invno">Rep Code</label>

                        <div class="col-sm-3 form-group-sm">
                            <?php
                            include './connection_sql.php';
                            echo"<select id = \"name\"  class =\"form-control input-sm\">";
                            echo "<option value='' ></option>";
                            $sql = "select * from s_salrep where cancel='1' order by REPCODE";
                            foreach ($conn->query($sql) as $row) {
                                echo "<option value='" . $row["REPCODE"] . "' >" . $row["REPCODE"] . "-" . $row["Name"] . "</option>";
                            }
                            echo"</select>";
                            ?>                     
                        </div>
                        <label class="col-sm-1 control-label" for="invdate">Month</label>
                        <div class="col-sm-2">
                            <input type="text" name="months"  onchange="ondate();"  id="months" class="form-control dt1 input-sm">  
                        </div>
                        <label class="col-sm-1 control-label" for="invdate">Type</label>
                        <div class="col-sm-2">
                            <select id="type" class="form-control input-sm">
                                <option value=""></option>
                                <option value="ADV">Advance</option>
                                <option value="BAL">Balance</option> 
                            </select>
                        </div>

                        <br>
                        <hr>
                    </div>
                </div>            
            </div>
        </div>








    </form>


</section>

<script src="js/rep_lock_active.js"></script>


<script>
                                function myFunction() {
                                    location.reload();
                                }
</script>
