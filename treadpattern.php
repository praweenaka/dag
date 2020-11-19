<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">PATTERN MASTER</h3>
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
                </div>

                <input type="hidden" id="uniq" class="form-control">

                <div id="msg_box"  class="span12 text-center"  >  </div>

            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="txt_usernm">Code</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Code" id="code" disabled class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="txt_password">PATTERN</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="PATTERN" id="pattern" class="form-control">

                </div>
            </div>


        </div>

    </form>
</div>

</section>

<script src="js/treadpattern.js"></script>
<script>new_inv();</script>