<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">PACKEGE LIST MASTER</h3>
            <h4 style="float: right;height: 3px;"><b id="time"></b></h4>
        </div>
        <form role="form" class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <a onclick="new_inv();" class="btn btn-default">
                        <span class="fa fa-user-plus"></span> &nbsp; New
                    </a>
                    <a onclick="save_inv();" class="btn btn-success">
                        <span class="fa fa-save"></span> &nbsp; Save
                    </a> 
                  <!--   <a onclick="deleteuser();" class="btn btn-danger">
                        <span class="fa fa-trash"></span> &nbsp; Delete
                    </a> -->
                    <a onclick="NewWindow('packege_list_search.php', 'mywin', '800', '700', 'yes', 'center');" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-search"></span> &nbsp; FIND
                    </a>
                </div>

                <input type="hidden" id="uniq" class="form-control">

                <div id="msg_box"  class="span12 text-center"  >  </div>

            </div>
            

            <div class="form-group">
                <label class="col-sm-2 control-label" for="txt_usernm">CODE</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Code" id="code" disabled class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="txt_usernm">SIZE</label>
                <div class="col-sm-2">
                    <select name="SIZE" id="size"    class="text_purchase3 col-sm-9 form-control" > 
                        <?php
                        require_once("./connection_sql.php");

                        $sql = "Select * from size order by code";
                        foreach ($conn->query($sql) as $row) {
                            echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="txt_password">DESIGN</label>
                <div class="col-sm-3">
                    <select name="DESIGN" id="design"    class="text_purchase3 col-sm-9 form-control" > 
                        <?php
                        require_once("./connection_sql.php");

                        $sql = "Select * from design order by code";
                        foreach ($conn->query($sql) as $row) {
                            echo "<option value=\"" . $row["design"] . "\">" . $row["design"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="txt_password">DESCRIPTION</label>
                <div class="col-sm-3">
                    <input type="text" placeholder="DESCRIPTION" id="des" class="form-control">

                </div>
            </div>

            <div id="itemdetails"></div>
        </div>

    </form>
</div>

</section>

<script src="js/packege_list.js"></script>
<script>new_inv();</script>