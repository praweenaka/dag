<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">CREATE DAG</h3>
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
                    <a onclick="cancel_inv();" class="btn btn-danger">
                        <span class="fa fa-trash"></span> &nbsp; Cancel
                    </a>
                    <a onclick="NewWindow('dag_search.php', 'mywin', '800', '700', 'yes', 'center');" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-search"></span> &nbsp; FIND
                    </a> 
                    
                </div>

                <input type="hidden" id="uniq" class="form-control">

                <div id="msg_box"  class="span12 text-center"  >  </div>

            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label" for="txt_usernm">INVOICE NO</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="DAG NO" id="refno" disabled class="form-control">
                </div>

                <div class="col-sm-1"> </div>
                <div class="col-sm-2"></div>
                <div class="col-sm-2"></div>
                <label class="col-sm-1 control-label" for="txt_usernm">DATE</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="DATE" id="sdate" value="<?php echo date('Y-m-d')?>"  class="form-control dt">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label" for="txt_usernm">CUSTOMER CODE</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="CUSTOMER CODE" id="cuscode" disabled   class="form-control">
                </div>
                <label class="col-sm-1 control-label" for="txt_usernm">CUSTOMER NAME</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="NAME" id="cusname" disabled=""  class="form-control">
                </div> 
                <div class="col-sm-2">
                    <a onfocus="this.blur()" onclick="NewWindow('customer_search.php?stname=dag', 'mywin', '800', '700', 'yes', 'center');
                    return false" href="">
                    <input type="button" class="btn btn-default" value="..." id="searchcust" name="searchcust">
                </a>
            </div>

        </div>

        <div class="form-group"> 
            <label class="col-sm-1 control-label" for="txt_usernm">ADVANCE PAYMENT</label>
            <div class="col-sm-2">
                <input type="number" placeholder="ADVANCE PAYMENT" id="adpayment"   class="form-control">
            </div>   
            <label class="col-sm-1 control-label" for="txt_usernm">SIZE</label>
            <div class="col-sm-2">
              <select name="size" id="size"    class="text_purchase3 col-sm-9 form-control" > 
                <?php
                require_once("./connection_sql.php");

                $sql = "Select * from size order by code";
                foreach ($conn->query($sql) as $row) {
                    echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
                }
                ?>
            </select>
        </div>        
        <label class="col-sm-1 control-label" for="txt_usernm">MARKER</label>
        <div class="col-sm-2">
          <select name="marker" id="marker"    class="text_purchase3 col-sm-9 form-control" > 
            <?php
            require_once("./connection_sql.php");

            $sql = "Select * from marker order by code";
            foreach ($conn->query($sql) as $row) {
                echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
            }
            ?>
        </select>
    </div>     
    <label class="col-sm-1 control-label" for="txt_usernm">JOB NO</label>
        <div class="col-sm-2">
          <input type="number" placeholder="JOB NO" id="jobno" disabled  class="form-control">
    </div>     

</div>



<div class="form-group">
    <label class="col-sm-1 control-label" for="txt_usernm">SERIAL NO</label>
    <div class="col-sm-2">
        <input type="text" placeholder="SERIAL NO" id="serialno"   class="form-control">
    </div>
    <label class="col-sm-1 control-label" for="txt_usernm">WARRANTY</label>
    <div class="col-sm-2">
        <select name="warranty" id="warranty"    class="text_purchase3 col-sm-9 form-control" > 
            <option value="YES">YES</option>
            <option value="NO">NO</option>
        </select> 
    </div> 
    <label class="col-sm-1 control-label" for="txt_usernm">REMARK</label>
    <div class="col-sm-3">
        <input type="text" placeholder="REMARK" id="remark"   class="form-control">
    </div>
    <div class="col-sm-1">
      <a onclick="add_tmp();" class="btn btn-success">
        <span class="fa fa-save"></span> &nbsp; ADD
    </a> 
</div> 
</div> 

<div class="form-group"></div>
<div class="form-group"></div>

<div id="itemdetails"></div>

</div>

</form>
</div>

</section>

<script src="js/dag.js"></script>
<script>new_inv();</script>