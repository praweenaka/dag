<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">MAN MASTER</h3>
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
                    <a onclick="NewWindow('man_search.php', 'mywin', '800', '700', 'yes', 'center');" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-search"></span> &nbsp; FIND
                    </a>
                </div>

                <input type="hidden" id="uniq" class="form-control">

                <div id="msg_box"  class="span12 text-center"  >  </div>

            </div>
            

            <div class="form-group">
                <label class="col-sm-1 control-label" for="txt_usernm">CODE</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Code" id="code" disabled class="form-control">
                </div>
            </div>
           

            <div class="form-group">
                <label class="col-sm-1 control-label" for="txt_password">WORKER</label>
                <div class="col-sm-3">
                    <input type="text" placeholder="WORKER" id="des" class="form-control">

                </div>
                 <label class="col-sm-1 control-label" for="cus_address">TYPE</label>
                <div class="col-sm-3">
                   <select id="type" class="form-control input-sm">

                    <option value="FACTORY">FACTORY</option>
                    <option value="WORKER">WORKER</option>       
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" for="cus_address">NIC</label>
                <div class="col-sm-3">
                    <input type="text" placeholder="NIC" id="nic" class="form-control input-sm">
                </div>
                
                

            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" for="cus_address">Land</label>
                <div class="col-sm-3">
                    <input type="text" placeholder="Land" id="land" class="form-control input-sm">
                </div>

                <label class="col-sm-1 control-label" for="txt_remarks">Mobile</label>
                <div class="col-sm-3">
                    <input type="text" placeholder="Mobile" id="mobile" class="form-control input-sm">
                </div>

                <div class="col-sm-1">
                    &nbsp;
                </div> 
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" for="cus_address">Address</label>
                <div class="col-sm-3">
                    <input type="text" placeholder="Address" id="address" class="form-control input-sm">
                </div> 
            </div>


            <div id="itemdetails"></div>
        </div>

    </form>
</div>

</section>

<script src="js/man.js"></script>
<script>new_inv();</script>