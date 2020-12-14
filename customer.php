<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">CUSTOMER MASTER</h3>
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
                    <a onclick="deleteuser();" class="btn btn-danger">
                        <span class="fa fa-trash"></span> &nbsp; Cancel
                    </a>
                    <a onclick="NewWindow('customer_search.php', 'mywin', '800', '700', 'yes', 'center');" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-search"></span> &nbsp; FIND
                    </a>
                </div>

                <input type="hidden" id="uniq" class="form-control">

                <div id="msg_box"  class="span12 text-center"  >  </div>

            </div>

            
            

            <div class="form-group">
                <label class="col-sm-1 control-label" for="cus_address">Code</label>
                <div class="col-sm-2">
                    <input type="text" placeholder="Code" id="code" disabled="" class="form-control input-sm">
                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" for="cus_address">Title</label>
                <div class="col-sm-3">
                    <input type="text" placeholder="Title" id="title" class="form-control input-sm">
                </div>

                <label class="col-sm-1 control-label" for="txt_remarks">Name</label>
                <div class="col-sm-3">
                    <input type="text" placeholder="Name" id="name" class="form-control input-sm">
                </div>
  
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" for="cus_address">Shop Name</label>
                <div class="col-sm-3">
                    <input type="text" placeholder="Shop Name" id="shopname" class="form-control input-sm">
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


        </div>

    </form>
</div>

</section>

<script src="js/customer.js"></script>
<script>new_inv();</script>