<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">EXPENSE MASTER</h3>
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
                    <a onclick="NewWindow('design_search.php', 'mywin', '800', '700', 'yes', 'center');" class="btn btn-info btn-sm">
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
                <label class="col-sm-2 control-label" for="txt_usernm">NAME</label>
                <div class="col-sm-3">
                    <input type="text" placeholder="NAME" id="name"   class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="txt_password">DESCRIPTION</label>
                <div class="col-sm-3">
                    <input type="text" placeholder="DESCRIPTION" id="des" class="form-control">

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="txt_password">COST</label>
                <div class="col-sm-3">
                    <input type="number" placeholder="COST" id="cost" class="form-control">

                </div>
            </div> 

            <div id="itemdetails"></div>
        </div>

    </form>
</div>

</section>

<script src="js/expenses.js"></script>
<script>new_inv();</script>