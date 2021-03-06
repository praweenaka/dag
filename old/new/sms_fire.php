<?php
include './connection_sql.php';
if ($_SESSION["CURRENT_USER"] == "") {
   echo "Please Logging Again..";
   
 
}
?>
<button type="button" class="btn btn-primary" data-toggle="modal" onload=" $(window).load(function () {
        $('#myModal').modal('show');
    });" data-target="#myModal">
  Launch demo modal
</button>
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">SMS FIRE</h3>
        </div>
        <form  name= "form1"  role="form" class="form-horizontal">
            <div class="box-body">

                <div class="form-group">
                    <a onclick="location.reload();" class="btn btn-primary btn-sm">
                        <span class="fa fa-plus"></span> &nbsp; New
                    </a>
                    <a onclick="fire();" class="btn btn-success btn-sm">
                        <span class="fa fa-save"></span> &nbsp; Fire
                    </a>
                </div>

                <div id="msg_box"  class="span12 text-center">

                </div>

                <input type="hidden"  id="tmpno" >

                <div class="form-group">
                    <label class="col-sm-1 control-label">Fire Date</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Date" id="filterdate" value="" class="form-control dt"  >
                    </div>
                    <a onclick="filter();" class="btn btn-success btn-sm">
                        <span class="fa fa-filter"></span> &nbsp; Filter
                    </a>
                </div>
                <div class="form-group row">
                    <div id="itemdetails" class="col-sm-8" ></div>
                    <div class="col-sm-4">
                        <label class="col-sm-6 control-label talign  " for="invno">WD</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="WD" id="con1" value="" class="form-control"  >
                        </div> 
                        <div class="form-group"></div>
                        <label class="col-sm-6 control-label talign  " for="invno">MD</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="MD" id="con2" value="" class="form-control"  >
                        </div> 
                        <div class="form-group"></div>
                        <label class="col-sm-6 control-label talign  " for="invno">Nawarathna</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Nawarathna" id="con3" value="" class="form-control"  >
                        </div> 
                        <div class="form-group"></div>
                        <label class="col-sm-6 control-label talign  " for="invno">Other</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Other" id="con4" value="" class="form-control"  >
                        </div> 
                    </div>
                </div>

            </div>


        </form>
    </div>

</section>

<script src="js/sms_fire.js">

</script>



